<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Mfa/MfaLoginIssuer.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Mfa;

use App\Models\User;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MfaLoginIssuer
{
    public function __construct(
        private readonly PlatformLogger $logger,
        private readonly MfaAssurance $assurance,
        private readonly MfaSession $session,
    ) {}

    public function issue(
        Request $request,
        User $user,
        bool $remember,
        ?string $timezone,
        ?string $intendedUrl = null,
        bool $markMfaSatisfied = false,
    ): RedirectResponse {
        $targetUrl = $intendedUrl ?: route('dashboard', absolute: false);

        $this->session->forgetPendingLogin($request);

        Auth::login($user, $remember);

        $request->session()->regenerate();
        $request->session()->forget('url.intended');

        if ($markMfaSatisfied) {
            $this->assurance->markSatisfied($request, $user);
        }

        $user->forceFill([
            'last_login_at' => now(),
            'timezone' => filled($timezone) ? $timezone : $user->timezone,
        ])->save();

        $this->logger->recordEvent('auth.login_succeeded', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
        ], actorUserId: $user->id, isSecurityEvent: true);

        return redirect()->to($targetUrl);
    }
}
