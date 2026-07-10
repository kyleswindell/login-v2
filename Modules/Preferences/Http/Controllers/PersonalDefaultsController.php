<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Preferences/Http/Controllers/PersonalDefaultsController.php
| Purpose: Handles personal default preference editing.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Preferences\Http\Controllers;

use App\Modules\Account\Support\AccountPageTabs;
use App\Support\UiOptionCatalog;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

final class PersonalDefaultsController extends Controller
{
    public function edit(Request $request): View
    {
        return view('preferences::personal-defaults', [
            'accountTabs' => AccountPageTabs::items(),
            'user' => $request->user(),
            'timezoneOptions' => UiOptionCatalog::timezoneOptions(),
            'localeOptions' => UiOptionCatalog::localeOptions(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'timezone' => ['nullable', 'string', 'timezone'],
            'default_language' => ['nullable', Rule::in(UiOptionCatalog::localeValues())],
            'theme_preference' => ['nullable', Rule::in(['system', 'dark', 'light'])],
        ]);

        $request->user()->forceFill($validated)->save();

        return back()->with('success', 'Account preferences updated.');
    }
}
