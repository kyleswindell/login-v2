<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Http/Controllers/LoginController.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Http\Requests\LoginIdentifierRequest;
use App\Modules\Auth\Http\Requests\LoginPasswordRequest;
use App\Modules\Auth\Http\Requests\LoginRequest;
use App\Models\User;
use App\Modules\Auth\Services\Login\LoginAttemptLimiter;
use App\Modules\Auth\Services\Login\ProgressiveLoginSession;
use App\Modules\Auth\Services\Mfa\MfaAssurance;
use App\Modules\Auth\Services\Mfa\MfaDecision;
use App\Modules\Auth\Services\Mfa\MfaLoginIssuer;
use App\Modules\Auth\Services\Mfa\MfaSession;
use App\Modules\Auth\Services\SuspiciousAuthMonitor;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        private readonly PlatformLogger $logger,
        private readonly MfaAssurance $mfaAssurance,
        private readonly MfaLoginIssuer $loginIssuer,
        private readonly MfaSession $mfaSession,
        private readonly ProgressiveLoginSession $progressiveLogin,
        private readonly LoginAttemptLimiter $loginLimiter,
        private readonly SuspiciousAuthMonitor $suspiciousAuth,
    ) {}

    public function create(Request $request): View
    {
        $this->progressiveLogin->clear($request);

        return view('auth::login', [
            'rememberedIdentifier' => $this->progressiveLogin->rememberedIdentifier($request),
        ]);
    }

    public function identify(LoginIdentifierRequest $request): RedirectResponse
    {
        $identifier = trim($request->string('identifier')->toString());
        $rememberIdentifier = $request->boolean('remember_identifier');
        $timezone = $request->string('timezone')->toString();

        $this->progressiveLogin->store(
            $request,
            $identifier,
            $timezone !== '' ? $timezone : null,
            $rememberIdentifier,
        );

        $response = redirect()->route('login.password');

        if ($rememberIdentifier) {
            $response->withCookie(cookie(
                ProgressiveLoginSession::REMEMBERED_IDENTIFIER_COOKIE,
                $identifier,
                ProgressiveLoginSession::REMEMBERED_IDENTIFIER_MINUTES,
                null,
                null,
                null,
                true,
                false,
                'lax',
            ));
        } else {
            $response->withCookie(Cookie::forget(ProgressiveLoginSession::REMEMBERED_IDENTIFIER_COOKIE));
        }

        return $response;
    }

    public function password(Request $request): RedirectResponse|View
    {
        $state = $this->progressiveLogin->state($request);

        if (! $state) {
            return redirect()->route('login');
        }

        return view('auth::login-password', [
            'identifier' => $state['identifier'],
        ]);
    }

    public function authenticate(LoginPasswordRequest $request): RedirectResponse
    {
        $state = $this->progressiveLogin->state($request);

        if (! $state) {
            return redirect()->route('login');
        }

        $timezone = $request->string('timezone')->toString();

        return $this->attemptLogin(
            $request,
            $state['identifier'],
            $request->string('password')->toString(),
            false,
            $timezone !== '' ? $timezone : $state['timezone'],
            $state['intended_url'],
            'login.password',
            true,
        );
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $email = $request->string('email')->toString();
        $timezone = $request->string('timezone')->toString();

        return $this->attemptLogin(
            $request,
            $email,
            $request->string('password')->toString(),
            $request->boolean('remember'),
            $timezone !== '' ? $timezone : null,
            $request->session()->get('url.intended'),
            'login',
            false,
        );
    }

    private function attemptLogin(
        Request $request,
        string $identifier,
        string $password,
        bool $remember,
        ?string $timezone,
        ?string $intendedUrl,
        string $failureRoute,
        bool $clearProgressiveState,
    ): RedirectResponse {
        $identifier = trim($identifier);
        $intendedUrl ??= route('dashboard', absolute: false);
        $identifierHash = $this->loginLimiter->identifierHash($identifier);

        if ($this->loginLimiter->tooManyAttempts($request, $identifier)) {
            $this->logger->recordEvent(
                'auth.login_throttled',
                [
                    'identifier_hash' => $identifierHash,
                    'retry_after_seconds' => $this->loginLimiter->availableIn($request, $identifier),
                ],
                result: 'failure',
                severity: 'warning',
                isSecurityEvent: true,
            );
            $this->suspiciousAuth->loginThrottleRepeated($request, $identifierHash);

            return $this->failedLoginRedirect(
                $failureRoute,
                $identifier,
                __('Too many login attempts. Please wait before trying again.'),
            );
        }

        $user = User::query()->where('email', $identifier)->first();

        if ($user && ! $user->is_active) {
            $this->loginLimiter->hit($request, $identifier);

            $this->logger->recordEvent(
                'auth.login_failed',
                [
                    'email' => $identifier,
                    'identifier_hash' => $identifierHash,
                    'ip' => $request->ip(),
                    'reason' => 'inactive_user',
                ],
                actorUserId: $user->id,
                subjectType: User::class,
                subjectId: (string) $user->id,
                result: 'failure',
                severity: 'warning',
                isSecurityEvent: true,
            );
            $this->suspiciousAuth->inactiveUserProbe($request, $user, $identifierHash);

            return $this->failedLoginRedirect($failureRoute, $identifier);
        }

        if (! $user || ! Hash::check($password, (string) $user->password)) {
            $this->loginLimiter->hit($request, $identifier);

            $this->logger->recordEvent(
                'auth.login_failed',
                [
                    'email' => $identifier,
                    'identifier_hash' => $identifierHash,
                    'ip' => $request->ip(),
                ],
                subjectType: $user ? User::class : null,
                subjectId: $user ? (string) $user->id : null,
                result: 'failure',
                severity: 'warning',
                isSecurityEvent: true,
            );
            $this->suspiciousAuth->passwordSpray($request);

            return $this->failedLoginRedirect($failureRoute, $identifier);
        }

        $this->loginLimiter->clear($request, $identifier);

        $decision = $this->mfaAssurance->forLogin($user, $request);

        if ($clearProgressiveState) {
            $this->progressiveLogin->clear($request);
        }

        $request->session()->put('url.intended', $intendedUrl);

        if ($decision === MfaDecision::NotRequired || $decision === MfaDecision::Satisfied) {
            return $this->loginIssuer->issue(
                $request,
                $user,
                $remember,
                $timezone,
                $intendedUrl,
                $decision === MfaDecision::Satisfied,
            );
        }

        $this->mfaSession->storePendingLogin(
            $request,
            $user,
            $remember,
            $timezone,
        );

        $this->logger->recordEvent(
            'auth.mfa_challenged',
            [
                'user_id' => $user->id,
                'decision' => $decision->value,
                'ip' => $request->ip(),
            ],
            actorUserId: $user->id,
            subjectType: User::class,
            subjectId: (string) $user->id,
            isSecurityEvent: true,
        );

        return redirect()->route(
            $decision === MfaDecision::EnrollmentRequired ? 'mfa.enroll' : 'mfa.challenge'
        );
    }

    private function failedLoginRedirect(
        string $route,
        string $identifier,
        ?string $message = null,
    ): RedirectResponse
    {
        return redirect()
            ->route($route)
            ->withErrors(['password' => $message ?? __('These credentials do not match our records.')])
            ->withInput([
                'identifier' => $identifier,
                'email' => $identifier,
            ]);
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
