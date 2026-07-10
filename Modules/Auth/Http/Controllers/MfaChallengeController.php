<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Http/Controllers/MfaChallengeController.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Notifications\Types as AuthNotificationTypes;
use App\Modules\Auth\Services\Mfa\MfaDecision;
use App\Modules\Auth\Services\Mfa\MfaAssurance;
use App\Modules\Auth\Services\Mfa\MfaAttemptLimiter;
use App\Modules\Auth\Services\Mfa\MfaLoginIssuer;
use App\Modules\Auth\Services\Mfa\MfaManager;
use App\Modules\Auth\Services\Mfa\MfaSession;
use App\Modules\Auth\Services\SuspiciousAuthMonitor;
use App\Modules\Notifications\Services\Notifier;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MfaChallengeController extends Controller
{
    public function __construct(
        private readonly MfaAssurance $assurance,
        private readonly MfaAttemptLimiter $attemptLimiter,
        private readonly MfaLoginIssuer $loginIssuer,
        private readonly MfaManager $mfaManager,
        private readonly MfaSession $mfaSession,
        private readonly PlatformLogger $logger,
        private readonly SuspiciousAuthMonitor $suspiciousAuth,
        private readonly Notifier $notifier,
    ) {}

    public function show(Request $request): RedirectResponse|View
    {
        $pending = $this->mfaSession->pendingLogin($request);
        $user = $this->mfaSession->pendingUser($request);

        if ($pending === null || ! $user instanceof User) {
            return $this->expiredRedirect();
        }

        $decision = $this->assurance->forLogin($user, $request);

        if ($decision === MfaDecision::EnrollmentRequired) {
            return redirect()->route('mfa.enroll');
        }

        if ($decision === MfaDecision::NotRequired || $decision === MfaDecision::Satisfied) {
            return $this->loginIssuer->issue(
                $request,
                $user,
                $pending['remember'],
                $pending['timezone'],
                $pending['intended_url'],
                $decision === MfaDecision::Satisfied,
            );
        }

        return view('auth::mfa-challenge', [
            'user' => $user,
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'min:6', 'max:32', 'regex:/^[A-Za-z0-9\s-]+$/'],
        ]);

        $pending = $this->mfaSession->pendingLogin($request);
        $user = $this->mfaSession->pendingUser($request);

        if ($pending === null || ! $user instanceof User) {
            return $this->expiredRedirect();
        }

        $action = MfaAttemptLimiter::ACTION_LOGIN_CHALLENGE;

        if ($this->attemptLimiter->tooManyAttempts($request, $user, $action)) {
            return $this->rateLimitedRedirect($request, $user, $action);
        }

        $satisfiedBy = null;

        if ($this->looksLikeTotpCode($validated['code']) && $this->mfaManager->verifyLoginChallenge($user, $validated['code'])) {
            $satisfiedBy = 'totp';
        } elseif ($this->mfaManager->verifyRecoveryCode($user, $validated['code'])) {
            $satisfiedBy = 'recovery_code';
        }

        if ($satisfiedBy === null) {
            $this->attemptLimiter->hit($request, $user, $action);

            $this->logger->recordEvent(
                'auth.mfa_rejected',
                [
                    'user_id' => $user->id,
                    'ip' => $request->ip(),
                ],
                actorUserId: $user->id,
                subjectType: User::class,
                subjectId: (string) $user->id,
                result: 'failure',
                severity: 'warning',
                isSecurityEvent: true,
            );

            return back()->withErrors([
                'code' => __('The verification code is invalid.'),
            ])->withInput($request->only('mfa_method'));
        }

        $this->attemptLimiter->clear($request, $user, $action);

        if ($satisfiedBy === 'recovery_code') {
            $this->logger->recordEvent(
                'auth.mfa_recovery_code_used',
                [
                    'user_id' => $user->id,
                    'ip' => $request->ip(),
                ],
                actorUserId: $user->id,
                subjectType: User::class,
                subjectId: (string) $user->id,
                isSecurityEvent: true,
            );

            $this->notifier->send(
                type: AuthNotificationTypes::MFA_RECOVERY_CODE_USED,
                recipient: $user,
                actor: $user,
                subject: $user,
            );
        }

        $this->logger->recordEvent(
            'auth.mfa_satisfied',
            [
                'user_id' => $user->id,
                'method' => $satisfiedBy,
                'ip' => $request->ip(),
            ],
            actorUserId: $user->id,
            subjectType: User::class,
            subjectId: (string) $user->id,
            isSecurityEvent: true,
        );

        return $this->loginIssuer->issue(
            $request,
            $user,
            $pending['remember'],
            $pending['timezone'],
            $pending['intended_url'],
            markMfaSatisfied: true,
        );
    }

    private function expiredRedirect(): RedirectResponse
    {
        return redirect()
            ->route('login')
            ->withErrors(['auth' => __('Your sign-in session expired. Please sign in again.')]);
    }

    private function rateLimitedRedirect(Request $request, User $user, string $action): RedirectResponse
    {
        $retryAfter = $this->attemptLimiter->availableIn($request, $user, $action);

        $this->logger->recordEvent(
            'auth.mfa_rate_limited',
            [
                'user_id' => $user->id,
                'action' => $action,
                'retry_after_seconds' => $retryAfter,
                'ip' => $request->ip(),
            ],
            actorUserId: $user->id,
            subjectType: User::class,
            subjectId: (string) $user->id,
            result: 'failure',
            severity: 'warning',
            isSecurityEvent: true,
        );
        $this->suspiciousAuth->mfaRateLimitRepeated($request, $user, $action);

        return back()->withErrors([
            'code' => __('Too many verification attempts. Please wait before trying again.'),
        ])->withInput($request->only('mfa_method'));
    }

    private function looksLikeTotpCode(string $code): bool
    {
        return preg_match('/^\s*[0-9\s]{6,16}\s*$/', $code) === 1;
    }
}
