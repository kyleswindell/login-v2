<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Http/Controllers/AccountMfaController.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Notifications\Types as AuthNotificationTypes;
use App\Modules\Auth\Services\Mfa\MfaAssurance;
use App\Modules\Auth\Services\Mfa\MfaAttemptLimiter;
use App\Modules\Auth\Services\Mfa\MfaManager;
use App\Modules\Auth\Services\Mfa\MfaSession;
use App\Modules\Auth\Services\SuspiciousAuthMonitor;
use App\Modules\Notifications\Services\Notifier;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountMfaController extends Controller
{
    public function __construct(
        private readonly MfaAssurance $assurance,
        private readonly MfaAttemptLimiter $attemptLimiter,
        private readonly MfaManager $mfaManager,
        private readonly MfaSession $mfaSession,
        private readonly PlatformLogger $logger,
        private readonly SuspiciousAuthMonitor $suspiciousAuth,
        private readonly Notifier $notifier,
    ) {}

    public function show(Request $request): RedirectResponse|View
    {
        $user = $request->user();

        if ($user->hasConfirmedTotpMfa()) {
            return redirect()
                ->route('platform.account.index')
                ->with('success', 'MFA is already enabled.');
        }

        $method = $this->mfaManager->beginEnrollment($user);

        return view('auth::account.mfa-enroll', [
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

        /** @var User $user */
        $user = $request->user();

        $action = MfaAttemptLimiter::ACTION_ACCOUNT_ENROLLMENT;

        if ($this->attemptLimiter->tooManyAttempts($request, $user, $action)) {
            return $this->rateLimitedRedirect($request, $user, $action);
        }

        if (! $this->mfaManager->verifyPendingTotp($user, $validated['code'])) {
            $this->attemptLimiter->hit($request, $user, $action);

            $this->logger->recordEvent(
                'auth.mfa_rejected',
                [
                    'user_id' => $user->id,
                    'stage' => 'account_enrollment',
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

        $this->assurance->markSatisfied($request, $user);
        $this->mfaSession->storeRecoveryCodesForDisplay(
            $request,
            $this->mfaManager->regenerateRecoveryCodes($user),
            route('platform.account.index', absolute: false),
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

        return redirect()
            ->route('platform.account.mfa.recovery-codes')
            ->with('success', 'MFA enabled.');
    }

    public function recoveryCodes(Request $request): RedirectResponse|View
    {
        $display = $this->mfaSession->consumeRecoveryCodesForDisplay($request);

        if ($display['codes'] === []) {
            return redirect()->route('platform.account.index');
        }

        return view('auth::account.mfa-recovery-codes', [
            'codes' => $display['codes'],
            'continueUrl' => $display['continue_url'],
        ]);
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
