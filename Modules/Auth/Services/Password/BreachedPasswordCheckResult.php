<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Password/BreachedPasswordCheckResult.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Password;

class BreachedPasswordCheckResult
{
    public function __construct(
        public readonly string $provider,
        public readonly bool $checked,
        public readonly bool $breached = false,
        public readonly ?int $breachCount = null,
        public readonly ?string $failureReason = null,
    ) {}

    public static function notBreached(string $provider): self
    {
        return new self(provider: $provider, checked: true);
    }

    public static function breached(string $provider, ?int $breachCount = null): self
    {
        return new self(
            provider: $provider,
            checked: true,
            breached: true,
            breachCount: $breachCount,
        );
    }

    public static function failed(string $provider, string $reason): self
    {
        return new self(
            provider: $provider,
            checked: false,
            failureReason: $reason,
        );
    }
}
