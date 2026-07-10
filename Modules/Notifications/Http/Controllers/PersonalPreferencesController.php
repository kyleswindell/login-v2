<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Http/Controllers/PersonalPreferencesController.php
| Purpose: Handles current-user notification preferences.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Account\Support\AccountPageTabs;
use App\Modules\Notifications\Models\UserNotificationPreference;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

final class PersonalPreferencesController extends Controller
{
    public function edit(Request $request): View
    {
        $preference = $request->user()->notificationPreference
            ?? new UserNotificationPreference([
                'email_enabled' => false,
                'digest_frequency' => 'never',
            ]);

        return view('notifications::account.preferences', [
            'accountTabs' => AccountPageTabs::items(),
            'digestItems' => $this->digestItems(),
            'digestOptions' => $this->digestOptions(),
            'preference' => $preference,
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email_enabled' => ['nullable', 'boolean'],
            'digest_frequency' => ['required', Rule::in(array_keys($this->digestOptions()))],
        ]);

        UserNotificationPreference::query()->updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'email_enabled' => $request->boolean('email_enabled'),
                'digest_frequency' => $validated['digest_frequency'],
            ],
        );

        return back()->with('success', 'Notification preferences updated.');
    }

    /**
     * @return array<string, string>
     */
    private function digestOptions(): array
    {
        return [
            'never' => 'No digest',
            'daily' => 'Daily digest',
            'weekly' => 'Weekly digest',
        ];
    }

    /**
     * @return list<array{value: string, label: string}>
     */
    private function digestItems(): array
    {
        return collect($this->digestOptions())
            ->map(fn (string $label, string $value): array => [
                'value' => $value,
                'label' => $label,
            ])
            ->values()
            ->all();
    }
}
