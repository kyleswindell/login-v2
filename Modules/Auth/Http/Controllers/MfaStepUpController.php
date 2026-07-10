<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Http/Controllers/MfaStepUpController.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Services\Mfa\MfaAssurance;
use App\Modules\Auth\Services\Mfa\MfaAttemptLimiter;
use App\Modules\Auth\Services\Mfa\MfaManager;
use App\Modules\Auth\Services\Mfa\MfaSession;
use App\Modules\Auth\Services\SuspiciousAuthMonitor;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MfaStepUpController extends Controller
{
    public function __construct(
        private readonly MfaAssurance $assurance,
        private readonly MfaAttemptLimiter $attemptLimiter,
        private readonly MfaManager $mfaManager,
        private readonly MfaSession $mfaSession,
        private readonly PlatformLogger $logger,
        private readonly SuspiciousAuthMonitor $suspiciousAuth,
    ) {}

    public function show(Request $request): RedirectResponse|View
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user->requiresMfa()) {
            return redirect()->to(
                $this->mfaSession->consumeStepUpIntendedUrl($request, route('dashboard', absolute: false))
            );
        }

        if (! $user->hasConfirmedTotpMfa()) {
            return redirect()->route('platform.account.mfa.enroll');
        }

        if ($this->assurance->hasFreshStepUp($request, $user)) {
            return redirect()->to(
                $this->mfaSession->consumeStepUpIntendedUrl($request, route('dashboard', absolute: false))
            );
        }

        return view('auth::mfa-step-up', [
            'user' => $user,
        ]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'min:6', 'max:16', 'regex:/^[0-9\s]+$/'],
        ]);

        /** @var User $user */
        $user = $request->user();

        if (! $user->hasConfirmedTotpMfa()) {
            return redirect()->route('platform.account.mfa.enroll');
        }

        $action = MfaAttemptLimiter::ACTION_STEP_UP;

        if ($this->attemptLimiter->tooManyAttempts($request, $user, $action)) {
            return $this->rateLimitedRedirect($request, $user, $action);
        }

        if (! $this->mfaManager->verifyLoginChallenge($user, $validated['code'])) {
            $this->attemptLimiter->hit($request, $user, $action);

            $this->logger->recordEvent(
                'auth.mfa_rejected',
                [
                    'user_id' => $user->id,
                    'stage' => 'step_up',
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

        $this->assurance->markStepUpSatisfied($request, $user);

        $this->logger->recordEvent(
            'auth.mfa_satisfied',
            [
                'user_id' => $user->id,
                'stage' => 'step_up',
                'ip' => $request->ip(),
            ],
            actorUserId: $user->id,
            subjectType: User::class,
            subjectId: (string) $user->id,
            isSecurityEvent: true,
        );

        return redirect()->to(
            $this->mfaSession->consumeStepUpIntendedUrl($request, route('dashboard', absolute: false))
        );
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
