<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Mfa/MfaSession.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Mfa;

use App\Models\User;
use Illuminate\Http\Request;

class MfaSession
{
    private const PENDING_LOGIN_KEY = 'mfa.pending_login';
    private const RECOVERY_CODES_KEY = 'mfa.recovery_codes';
    private const RECOVERY_CODES_CONTINUE_URL_KEY = 'mfa.recovery_codes_continue_url';
    private const SATISFIED_KEY = 'mfa.satisfied';
    private const STEP_UP_SATISFIED_AT_KEY = 'mfa.step_up_satisfied_at';
    private const STEP_UP_INTENDED_URL_KEY = 'mfa.step_up_intended_url';
    private const PENDING_LOGIN_MINUTES = 10;
    private const STEP_UP_MINUTES = 15;

    public function storePendingLogin(Request $request, User $user, bool $remember, ?string $timezone): void
    {
        $request->session()->put(self::PENDING_LOGIN_KEY, [
            'user_id' => $user->id,
            'remember' => $remember,
            'timezone' => filled($timezone) ? $timezone : null,
            'intended_url' => $request->session()->get('url.intended', route('dashboard', absolute: false)),
            'expires_at' => now()->addMinutes(self::PENDING_LOGIN_MINUTES)->timestamp,
        ]);
    }

    /**
     * @return array{user_id: int, remember: bool, timezone: ?string, intended_url: string, expires_at: int}|null
     */
    public function pendingLogin(Request $request): ?array
    {
        $pending = $request->session()->get(self::PENDING_LOGIN_KEY);

        if (! is_array($pending) || ! isset($pending['user_id'], $pending['expires_at'])) {
            $this->forgetPendingLogin($request);

            return null;
        }

        if (now()->timestamp > (int) $pending['expires_at']) {
            $this->forgetPendingLogin($request);

            return null;
        }

        return [
            'user_id' => (int) $pending['user_id'],
            'remember' => (bool) ($pending['remember'] ?? false),
            'timezone' => $pending['timezone'] ?? null,
            'intended_url' => (string) ($pending['intended_url'] ?? route('dashboard', absolute: false)),
            'expires_at' => (int) $pending['expires_at'],
        ];
    }

    public function pendingUser(Request $request): ?User
    {
        $pending = $this->pendingLogin($request);

        if ($pending === null) {
            return null;
        }

        $user = User::query()->find($pending['user_id']);

        if (! $user instanceof User || ! $user->is_active) {
            $this->forgetPendingLogin($request);

            return null;
        }

        return $user;
    }

    public function forgetPendingLogin(Request $request): void
    {
        $request->session()->forget(self::PENDING_LOGIN_KEY);
    }

    /**
     * @param list<string> $codes
     */
    public function storeRecoveryCodesForDisplay(Request $request, array $codes, string $continueUrl): void
    {
        $request->session()->put(self::RECOVERY_CODES_KEY, $codes);
        $request->session()->put(self::RECOVERY_CODES_CONTINUE_URL_KEY, $continueUrl);
    }

    /**
     * @return array{codes: list<string>, continue_url: string}
     */
    public function consumeRecoveryCodesForDisplay(Request $request): array
    {
        $codes = $request->session()->pull(self::RECOVERY_CODES_KEY, []);
        $continueUrl = (string) $request->session()->pull(
            self::RECOVERY_CODES_CONTINUE_URL_KEY,
            route('platform.account.index', absolute: false),
        );

        return [
            'codes' => is_array($codes) ? array_values($codes) : [],
            'continue_url' => $continueUrl,
        ];
    }

    public function markSatisfied(Request $request, User $user): void
    {
        $request->session()->put(self::SATISFIED_KEY, [
            'user_id' => $user->id,
            'satisfied_at' => now()->timestamp,
        ]);
    }

    public function markStepUpSatisfied(Request $request, User $user): void
    {
        $satisfiedAt = now()->timestamp;

        $this->markSatisfied($request, $user);

        $request->session()->put(self::STEP_UP_SATISFIED_AT_KEY, [
            'user_id' => $user->id,
            'satisfied_at' => $satisfiedAt,
        ]);
    }

    public function hasSatisfied(Request $request, User $user): bool
    {
        $satisfied = $request->session()->get(self::SATISFIED_KEY);

        return is_array($satisfied)
            && (int) ($satisfied['user_id'] ?? 0) === $user->id
            && isset($satisfied['satisfied_at']);
    }

    public function hasFreshStepUp(Request $request, ?User $user = null): bool
    {
        $satisfied = $request->session()->get(self::STEP_UP_SATISFIED_AT_KEY);

        if (is_array($satisfied)) {
            if ($user instanceof User && (int) ($satisfied['user_id'] ?? 0) !== $user->id) {
                return false;
            }

            $satisfiedAt = $satisfied['satisfied_at'] ?? null;

            return is_numeric($satisfiedAt)
                && (int) $satisfiedAt >= now()->subMinutes(self::STEP_UP_MINUTES)->timestamp;
        }

        return is_numeric($satisfied)
            && (int) $satisfied >= now()->subMinutes(self::STEP_UP_MINUTES)->timestamp;
    }

    public function storeStepUpIntendedUrl(Request $request, string $url): void
    {
        $request->session()->put(self::STEP_UP_INTENDED_URL_KEY, $url);
    }

    public function consumeStepUpIntendedUrl(Request $request, ?string $fallback = null): string
    {
        $url = (string) $request->session()->get(
            self::STEP_UP_INTENDED_URL_KEY,
            $fallback ?? route('dashboard', absolute: false),
        );

        $request->session()->forget(self::STEP_UP_INTENDED_URL_KEY);

        return $url;
    }

    public function clearStepUp(Request $request): void
    {
        $request->session()->forget(self::STEP_UP_SATISFIED_AT_KEY);
    }

    public function clearSatisfied(Request $request): void
    {
        $request->session()->forget([self::SATISFIED_KEY, self::STEP_UP_SATISFIED_AT_KEY]);
    }
}
