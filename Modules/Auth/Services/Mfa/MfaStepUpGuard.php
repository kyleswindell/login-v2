<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Mfa/MfaStepUpGuard.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Mfa;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MfaStepUpGuard
{
    public function __construct(
        private readonly MfaAssurance $assurance,
        private readonly MfaSession $session,
    ) {}

    public function requiresEnrollment(User $user): bool
    {
        return $user->requiresMfa() && ! $user->hasConfirmedTotpMfa();
    }

    public function requiresFreshMfa(Request $request, User $user): bool
    {
        return $user->requiresMfa()
            && $user->hasConfirmedTotpMfa()
            && ! $this->assurance->hasFreshStepUp($request, $user);
    }

    public function redirectToChallenge(Request $request, string $intendedUrl, string $message): RedirectResponse
    {
        $this->session->storeStepUpIntendedUrl($request, $intendedUrl);

        return redirect()
            ->route('mfa.step-up')
            ->with('status', $message);
    }

    public function clearFreshMfa(Request $request): void
    {
        $this->assurance->clearFreshStepUp($request);
    }
}
