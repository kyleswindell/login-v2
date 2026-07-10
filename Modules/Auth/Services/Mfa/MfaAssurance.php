<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Mfa/MfaAssurance.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Mfa;

use App\Models\User;
use Illuminate\Http\Request;

class MfaAssurance
{
    public function __construct(
        private readonly MfaSession $session,
    ) {}

    public function forLogin(User $user, Request $request): MfaDecision
    {
        if (! $user->requiresMfa()) {
            return MfaDecision::NotRequired;
        }

        if ($this->session->hasSatisfied($request, $user)) {
            return MfaDecision::Satisfied;
        }

        if ($user->hasConfirmedTotpMfa()) {
            return MfaDecision::ChallengeRequired;
        }

        return MfaDecision::EnrollmentRequired;
    }

    public function markSatisfied(Request $request, User $user): void
    {
        $this->session->markSatisfied($request, $user);
    }

    public function markStepUpSatisfied(Request $request, User $user): void
    {
        $this->session->markStepUpSatisfied($request, $user);
    }

    public function hasSatisfied(Request $request, User $user): bool
    {
        return $this->session->hasSatisfied($request, $user);
    }

    public function clearSatisfied(Request $request): void
    {
        $this->session->clearSatisfied($request);
    }

    public function hasFreshStepUp(Request $request, ?User $user = null): bool
    {
        return $this->session->hasFreshStepUp($request, $user);
    }

    public function clearFreshStepUp(Request $request): void
    {
        $this->session->clearStepUp($request);
    }
}
