<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Mfa/MfaAttemptLimiter.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Mfa;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class MfaAttemptLimiter
{
    public const ACTION_LOGIN_CHALLENGE = 'login_challenge';
    public const ACTION_LOGIN_ENROLLMENT = 'login_enrollment';
    public const ACTION_ACCOUNT_ENROLLMENT = 'account_enrollment';
    public const ACTION_STEP_UP = 'step_up';

    private const MAX_ATTEMPTS = 5;
    private const DECAY_SECONDS = 600;

    public function tooManyAttempts(Request $request, User $user, string $action): bool
    {
        return RateLimiter::tooManyAttempts($this->key($request, $user, $action), self::MAX_ATTEMPTS);
    }

    public function availableIn(Request $request, User $user, string $action): int
    {
        return RateLimiter::availableIn($this->key($request, $user, $action));
    }

    public function hit(Request $request, User $user, string $action): void
    {
        RateLimiter::hit($this->key($request, $user, $action), self::DECAY_SECONDS);
    }

    public function clear(Request $request, User $user, string $action): void
    {
        RateLimiter::clear($this->key($request, $user, $action));
    }

    private function key(Request $request, User $user, string $action): string
    {
        return implode('|', [
            'mfa',
            $action,
            'user:'.$user->id,
            'ip:'.sha1((string) $request->ip()),
        ]);
    }
}
