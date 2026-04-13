<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        return view('platform.account.index', [
            'user' => $request->user(),
        ]);
    }

    public function settings(Request $request): View
    {
        return view('platform.account.settings', [
            'user' => $request->user(),
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($request->user()->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'string', 'min:12', 'confirmed'],
        ]);

        $request->user()->forceFill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ])->save();

        if (! empty($validated['new_password'])) {
            $request->user()->forceFill([
                'password' => $validated['new_password'],
            ])->save();
        }

        return back()->with('success', 'Account settings updated.');
    }

    public function preferences(Request $request): View
    {
        return view('platform.account.preferences', [
            'user' => $request->user(),
        ]);
    }

    public function updatePreferences(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'timezone' => ['nullable', 'string', 'timezone'],
            'default_language' => ['nullable', 'string', 'max:10'],
            'theme_preference' => ['nullable', Rule::in(['system', 'dark', 'light'])],
        ]);

        $request->user()->forceFill($validated)->save();

        return back()->with('success', 'Account preferences updated.');
    }
}
