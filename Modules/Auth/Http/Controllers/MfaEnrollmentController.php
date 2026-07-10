<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Http/Controllers/MfaEnrollmentController.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Notifications\Types as AuthNotificationTypes;
use App\Modules\Auth\Services\Mfa\MfaAssurance;
use App\Modules\Auth\Services\Mfa\MfaAttemptLimiter;
use App\Modules\Auth\Services\Mfa\MfaDecision;
use App\Modules\Auth\Services\Mfa\MfaLoginIssuer;
use App\Modules\Auth\Services\Mfa\MfaManager;
use App\Modules\Auth\Services\Mfa\MfaSession;
use App\Modules\Auth\Services\SuspiciousAuthMonitor;
use App\Modules\Notifications\Services\Notifier;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MfaEnrollmentController extends Controller
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

        if ($decision === MfaDecision::ChallengeRequired) {
            return redirect()->route('mfa.challenge');
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

        $method = $this->mfaManager->beginEnrollment($user);

        return view('auth::mfa-enroll', [
            'action' => route('mfa.enroll.confirm'),
            'manualKey' => $this->mfaManager->pendingManualKey($method),
            'qrSvg' => $this->mfaManager->renderEnrollmentQrSvg($user, $method),
            'user' => $user,
        ]);
    }

    public function confirm(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'min:6', 'max:16', 'regex:/^[0-9\s]+$/'],
        ]);

        $pending = $this->mfaSession->pendingLogin($request);
        $user = $this->mfaSession->pendingUser($request);

        if ($pending === null || ! $user instanceof User) {
            return $this->expiredRedirect();
        }

        $action = MfaAttemptLimiter::ACTION_LOGIN_ENROLLMENT;

        if ($this->attemptLimiter->tooManyAttempts($request, $user, $action)) {
            return $this->rateLimitedRedirect($request, $user, $action);
        }

        if (! $this->mfaManager->verifyPendingTotp($user, $validated['code'])) {
            $this->attemptLimiter->hit($request, $user, $action);

            $this->logger->recordEvent(
                'auth.mfa_rejected',
                [
                    'user_id' => $user->id,
                    'stage' => 'enrollment',
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
            ]);
        }

        $this->attemptLimiter->clear($request, $user, $action);

        $this->mfaSession->storeRecoveryCodesForDisplay(
            $request,
            $this->mfaManager->regenerateRecoveryCodes($user),
            $pending['intended_url'],
        );

        $this->logger->recordEvent(
            'auth.mfa_enrolled',
            [
                'user_id' => $user->id,
                'method' => 'totp',
                'ip' => $request->ip(),
            ],
            actorUserId: $user->id,
            subjectType: User::class,
            subjectId: (string) $user->id,
            isSecurityEvent: true,
        );

        $this->notifier->send(
            type: AuthNotificationTypes::MFA_ENROLLED,
            recipient: $user,
            actor: $user,
            subject: $user,
        );

        $this->logger->recordEvent(
            'auth.mfa_satisfied',
            [
                'user_id' => $user->id,
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
            route('platform.account.mfa.recovery-codes', absolute: false),
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
        ]);
    }
}
