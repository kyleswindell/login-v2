<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/SuspiciousAuthMonitor.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services;

use App\Models\PlatformAuditLog;
use App\Models\User;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\RateLimiter;

class SuspiciousAuthMonitor
{
    public function __construct(private readonly PlatformLogger $logger) {}

    public function loginThrottleRepeated(Request $request, string $identifierHash): void
    {
        $signal = 'login_throttle_repeated';

        if (! $this->enabled($signal)) {
            return;
        }

        $config = $this->signalConfig($signal);
        $windowMinutes = $this->windowMinutes($config);

        $events = $this->recentEvents('auth.login_throttled', $windowMinutes)
            ->where('ip_address', $request->ip())
            ->filter(fn (PlatformAuditLog $log): bool => ($log->metadata['identifier_hash'] ?? null) === $identifierHash);

        $eventCount = $events->count();
        $threshold = $this->threshold($config);

        if ($eventCount < $threshold) {
            return;
        }

        $this->emit(
            $signal,
            'identifier:'.$identifierHash.'|ip:'.$this->ipHash($request),
            $config,
            [
                'event_count' => $eventCount,
                'identifier_hash' => $identifierHash,
                'ip_hash' => $this->ipHash($request),
            ],
        );
    }

    public function passwordSpray(Request $request): void
    {
        $signal = 'password_spray_ip';

        if (! $this->enabled($signal)) {
            return;
        }

        $config = $this->signalConfig($signal);
        $windowMinutes = $this->windowMinutes($config);

        $events = $this->recentEvents('auth.login_failed', $windowMinutes)
            ->where('ip_address', $request->ip())
            ->filter(fn (PlatformAuditLog $log): bool => filled($log->metadata['identifier_hash'] ?? null));

        $eventCount = $events->count();
        $threshold = $this->threshold($config);
        $distinctIdentifiers = $events
            ->map(fn (PlatformAuditLog $log): ?string => $log->metadata['identifier_hash'] ?? null)
            ->filter()
            ->unique()
            ->count();
        $distinctThreshold = (int) ($config['distinct_identifier_threshold'] ?? 5);

        if ($eventCount < $threshold || $distinctIdentifiers < $distinctThreshold) {
            return;
        }

        $this->emit(
            $signal,
            'ip:'.$this->ipHash($request),
            $config,
            [
                'event_count' => $eventCount,
                'threshold' => $threshold,
                'distinct_identifier_count' => $distinctIdentifiers,
                'distinct_identifier_threshold' => $distinctThreshold,
                'ip_hash' => $this->ipHash($request),
            ],
        );
    }

    public function inactiveUserProbe(Request $request, User $user, string $identifierHash): void
    {
        $signal = 'inactive_user_probe';

        if (! $this->enabled($signal)) {
            return;
        }

        $config = $this->signalConfig($signal);
        $windowMinutes = $this->windowMinutes($config);

        $events = $this->recentEvents('auth.login_failed', $windowMinutes)
            ->filter(function (PlatformAuditLog $log) use ($identifierHash, $user): bool {
                if (($log->metadata['reason'] ?? null) !== 'inactive_user') {
                    return false;
                }

                return (string) $log->subject_id === (string) $user->id
                    || ($log->metadata['identifier_hash'] ?? null) === $identifierHash;
            });

        $eventCount = $events->count();
        $threshold = $this->threshold($config);

        if ($eventCount < $threshold) {
            return;
        }

        $this->emit(
            $signal,
            'user:'.$user->id.'|identifier:'.$identifierHash,
            $config,
            [
                'event_count' => $eventCount,
                'identifier_hash' => $identifierHash,
                'ip_hash' => $this->ipHash($request),
                'user_id' => $user->id,
            ],
            subjectType: User::class,
            subjectId: (string) $user->id,
        );
    }

    public function mfaRateLimitRepeated(Request $request, User $user, string $action): void
    {
        $signal = 'mfa_rate_limit_repeated';

        if (! $this->enabled($signal)) {
            return;
        }

        $config = $this->signalConfig($signal);
        $windowMinutes = $this->windowMinutes($config);

        $events = $this->recentEvents('auth.mfa_rate_limited', $windowMinutes)
            ->filter(function (PlatformAuditLog $log) use ($user, $action): bool {
                return (string) $log->subject_id === (string) $user->id
                    && ($log->metadata['action'] ?? null) === $action;
            });

        $eventCount = $events->count();
        $threshold = $this->threshold($config);

        if ($eventCount < $threshold) {
            return;
        }

        $this->emit(
            $signal,
            'user:'.$user->id.'|action:'.$action,
            $config,
            [
                'event_count' => $eventCount,
                'ip_hash' => $this->ipHash($request),
                'user_id' => $user->id,
            ],
            subjectType: User::class,
            subjectId: (string) $user->id,
        );
    }

    public function breachedPasswordRepeated(Request $request): void
    {
        $signal = 'breached_password_repeated';

        if (! $this->enabled($signal)) {
            return;
        }

        $actorUserId = $request->user()?->id;

        if ($actorUserId === null) {
            return;
        }

        $config = $this->signalConfig($signal);
        $windowMinutes = $this->windowMinutes($config);

        $eventCount = $this->recentEvents('auth.password_breached_detected', $windowMinutes)
            ->where('actor_user_id', $actorUserId)
            ->count();
        $threshold = $this->threshold($config);

        if ($eventCount < $threshold) {
            return;
        }

        $this->emit(
            $signal,
            'actor:'.$actorUserId,
            $config,
            [
                'event_count' => $eventCount,
                'ip_hash' => $this->ipHash($request),
                'user_id' => $actorUserId,
            ],
            actorUserId: $actorUserId,
            subjectType: User::class,
            subjectId: (string) $actorUserId,
        );
    }

    /**
     * @return Collection<int, PlatformAuditLog>
     */
    private function recentEvents(string $eventType, int $windowMinutes): Collection
    {
        return PlatformAuditLog::query()
            ->where('event_type', $eventType)
            ->where('occurred_at', '>=', now('UTC')->subMinutes($windowMinutes))
            ->get();
    }

    /**
     * @param array<string, mixed> $config
     * @param array<string, mixed> $metadata
     */
    private function emit(
        string $signal,
        string $targetKey,
        array $config,
        array $metadata,
        ?int $actorUserId = null,
        ?string $subjectType = null,
        ?string $subjectId = null,
    ): void {
        if (! $this->shouldEmit($signal, $targetKey, $this->dedupeSeconds($config))) {
            return;
        }

        $threshold = $this->threshold($config);
        $windowMinutes = $this->windowMinutes($config);

        $metadata = array_merge([
            'signal' => $signal,
            'window_minutes' => $windowMinutes,
            'threshold' => $threshold,
            'recommended_response' => (string) ($config['recommended_response'] ?? 'review_auth_activity'),
        ], $metadata);

        $this->logger->recordEvent(
            'auth.suspicious_activity_detected',
            $metadata,
            actorUserId: $actorUserId,
            subjectType: $subjectType,
            subjectId: $subjectId,
            result: 'warning',
            severity: 'warning',
            isSecurityEvent: true,
        );
    }

    private function shouldEmit(string $signal, string $targetKey, int $dedupeSeconds): bool
    {
        $key = implode('|', [
            'suspicious-auth',
            $signal,
            sha1($targetKey),
        ]);

        if (RateLimiter::tooManyAttempts($key, 1)) {
            return false;
        }

        RateLimiter::hit($key, $dedupeSeconds);

        return true;
    }

    private function enabled(string $signal): bool
    {
        return (bool) config('platform.security.suspicious_auth.enabled', true)
            && (bool) ($this->signalConfig($signal)['enabled'] ?? true);
    }

    /**
     * @return array<string, mixed>
     */
    private function signalConfig(string $signal): array
    {
        return (array) config("platform.security.suspicious_auth.signals.{$signal}", []);
    }

    /**
     * @param array<string, mixed> $config
     */
    private function threshold(array $config): int
    {
        return max(1, (int) ($config['threshold'] ?? 1));
    }

    /**
     * @param array<string, mixed> $config
     */
    private function windowMinutes(array $config): int
    {
        return max(1, (int) ($config['window_minutes'] ?? 30));
    }

    /**
     * @param array<string, mixed> $config
     */
    private function dedupeSeconds(array $config): int
    {
        return max(1, (int) ($config['dedupe_minutes'] ?? $this->windowMinutes($config))) * 60;
    }

    private function ipHash(Request $request): string
    {
        return sha1((string) $request->ip());
    }
}
