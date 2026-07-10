<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Http/Controllers/SettingsDefaultsController.php
| Purpose: Handles Notifications module default settings.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Notifications\Services\NotificationPermissions;
use App\Modules\Settings\Services\Store;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

final class SettingsDefaultsController extends Controller
{
    public function __construct(
        private readonly Store $settings,
        private readonly PlatformLogger $logger,
    ) {
    }

    public function edit(): View
    {
        $this->authorize(NotificationPermissions::SETTINGS_VIEW);

        return view('notifications::settings.defaults', [
            'defaultSeverity' => $this->settings->get('notifications', 'default_severity', 'info'),
            'maxPerUser' => $this->settings->get('notifications', 'max_per_user', 100),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $this->authorize(NotificationPermissions::SETTINGS_UPDATE);

        $validated = $request->validate([
            'default_severity' => ['required', Rule::in(['info', 'notice', 'success', 'warning', 'error', 'urgent'])],
            'max_per_user' => ['required', 'integer', 'min:10', 'max:10000'],
        ]);

        $userId = $request->user()->id;

        $this->settings->put('notifications', 'default_severity', $validated['default_severity'], updatedBy: $userId);
        $this->settings->put('notifications', 'max_per_user', (int) $validated['max_per_user'], updatedBy: $userId);

        $this->logger->recordEvent('settings.notifications.updated', ['changed_keys' => array_keys($validated)]);

        return back()->with('success', 'Notification settings updated.');
    }
}
