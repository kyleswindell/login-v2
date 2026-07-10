<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Login/LoginAttemptLimiter.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Login;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class LoginAttemptLimiter
{
    public const MAX_IDENTIFIER_ATTEMPTS = 5;
    public const MAX_NETWORK_ATTEMPTS = 50;
    public const DECAY_SECONDS = 600;

    public function tooManyAttempts(Request $request, string $identifier): bool
    {
        return RateLimiter::tooManyAttempts($this->identifierIpKey($request, $identifier), self::MAX_IDENTIFIER_ATTEMPTS)
            || RateLimiter::tooManyAttempts($this->networkKey($request), self::MAX_NETWORK_ATTEMPTS);
    }

    public function availableIn(Request $request, string $identifier): int
    {
        return max(
            RateLimiter::availableIn($this->identifierIpKey($request, $identifier)),
            RateLimiter::availableIn($this->networkKey($request)),
        );
    }

    public function hit(Request $request, string $identifier): void
    {
        RateLimiter::hit($this->identifierIpKey($request, $identifier), self::DECAY_SECONDS);
        RateLimiter::hit($this->networkKey($request), self::DECAY_SECONDS);
    }

    public function clear(Request $request, string $identifier): void
    {
        RateLimiter::clear($this->identifierIpKey($request, $identifier));
    }

    public function identifierHash(string $identifier): string
    {
        return hash('sha256', $this->normalizeIdentifier($identifier));
    }

    private function identifierIpKey(Request $request, string $identifier): string
    {
        return implode('|', [
            'login',
            'identifier-ip',
            'identifier:'.$this->identifierHash($identifier),
            'ip:'.$this->ipHash($request),
        ]);
    }

    private function networkKey(Request $request): string
    {
        return implode('|', [
            'login',
            'network',
            'ip:'.$this->ipHash($request),
        ]);
    }

    private function normalizeIdentifier(string $identifier): string
    {
        return strtolower(trim($identifier));
    }

    private function ipHash(Request $request): string
    {
        return sha1((string) $request->ip());
    }
}
