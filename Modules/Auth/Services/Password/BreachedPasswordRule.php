<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Password/BreachedPasswordRule.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Password;

use App\Modules\Auth\Services\SuspiciousAuthMonitor;
use App\Platform\Logging\PlatformLogger;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BreachedPasswordRule implements ValidationRule
{
    private const MODE_DISABLED = 'disabled';
    private const MODE_REPORT_ONLY = 'report_only';
    private const MODE_ENFORCED = 'enforced';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || $value === '') {
            return;
        }

        $mode = $this->mode();

        if ($mode === self::MODE_DISABLED) {
            return;
        }

        $result = app(BreachedPasswordChecker::class)->check($value);

        if ($result->breached) {
            $this->logger()->recordEvent(
                'auth.password_breached_detected',
                [
                    'mode' => $mode,
                    'provider' => $result->provider,
                    'breach_count_available' => $result->breachCount !== null,
                ],
                result: $mode === self::MODE_ENFORCED ? 'failure' : 'warning',
                severity: 'warning',
                isSecurityEvent: true,
            );
            app(SuspiciousAuthMonitor::class)->breachedPasswordRepeated(request());

            if ($mode === self::MODE_ENFORCED) {
                $fail('The :attribute has appeared in a known data breach. Choose a different password.');
            }

            return;
        }

        if (! $result->checked) {
            $this->logger()->recordEvent(
                'auth.password_breach_check_failed',
                [
                    'mode' => $mode,
                    'provider' => $result->provider,
                    'failure_reason' => $result->failureReason,
                    'fail_closed' => $this->failClosed(),
                ],
                result: 'failure',
                severity: 'warning',
                isSecurityEvent: true,
            );

            if ($mode === self::MODE_ENFORCED && $this->failClosed()) {
                $fail('The :attribute security check is unavailable. Please try again.');
            }
        }
    }

    private function mode(): string
    {
        $mode = (string) config('platform.security.passwords.breached.mode', self::MODE_DISABLED);

        if (! in_array($mode, [self::MODE_DISABLED, self::MODE_REPORT_ONLY, self::MODE_ENFORCED], true)) {
            return self::MODE_DISABLED;
        }

        return $mode;
    }

    private function failClosed(): bool
    {
        return (bool) config('platform.security.passwords.breached.fail_closed', true);
    }

    private function logger(): PlatformLogger
    {
        return app(PlatformLogger::class);
    }
}
