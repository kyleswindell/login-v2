<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        private readonly PlatformLogger $logger,
    ) {}

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::query()->where('email', $request->string('email')->toString())->first();
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if ($user && ! $user->is_active) {
            // Keep inactive-account handling explicit so deactivated privileged users do not
            // authenticate successfully just because their password still matches.
            $this->logger->recordEvent('auth.login_failed', [
                'email' => $request->string('email')->toString(),
                'ip' => $request->ip(),
                'reason' => 'inactive_user',
            ], actorUserId: $user->id, result: 'failure', severity: 'warning', isSecurityEvent: true);

            return back()
                ->withErrors(['email' => __('These credentials do not match our records.')])
                ->onlyInput('email');
        }

        if (! Auth::attempt($credentials, $remember)) {
            $this->logger->recordEvent('auth.login_failed', [
                'email' => $request->string('email')->toString(),
                'ip' => $request->ip(),
            ], result: 'failure', severity: 'warning', isSecurityEvent: true);

            return back()
                ->withErrors(['email' => __('These credentials do not match our records.')])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        Auth::user()?->forceFill([
            'last_login_at' => now(),
            'timezone' => $request->string('timezone')->toString() !== ''
                ? $request->string('timezone')->toString()
                : Auth::user()?->timezone,
        ])->save();

        $this->logger->recordEvent('auth.login_succeeded', [
            'user_id' => Auth::id(),
            'email' => Auth::user()?->email,
            'ip' => $request->ip(),
        ], isSecurityEvent: true);

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $this->logger->recordEvent('auth.logout', [
            'user_id' => $user?->getAuthIdentifier(),
            'email' => $user?->email,
            'ip' => $request->ip(),
        ], actorUserId: $user?->getAuthIdentifier(), isSecurityEvent: true);

        return redirect()->route('login');
    }
}
