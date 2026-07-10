<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Password/HibpBreachedPasswordChecker.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Password;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class HibpBreachedPasswordChecker implements BreachedPasswordChecker
{
    private const PROVIDER = 'hibp';

    public function check(string $password): BreachedPasswordCheckResult
    {
        if ($password === '') {
            return BreachedPasswordCheckResult::notBreached(self::PROVIDER);
        }

        // HIBP's range API intentionally uses SHA-1 prefixes for k-anonymity.
        $hash = strtoupper(sha1($password));
        $prefix = substr($hash, 0, 5);
        $suffix = substr($hash, 5);

        try {
            foreach ($this->rowsForPrefix($prefix) as $row) {
                [$candidateSuffix, $count] = array_pad(explode(':', trim($row), 2), 2, null);

                if (strtoupper((string) $candidateSuffix) !== $suffix) {
                    continue;
                }

                $breachCount = (int) $count;

                if ($breachCount > 0) {
                    return BreachedPasswordCheckResult::breached(self::PROVIDER, $breachCount);
                }

                return BreachedPasswordCheckResult::notBreached(self::PROVIDER);
            }
        } catch (Throwable $exception) {
            return BreachedPasswordCheckResult::failed(
                self::PROVIDER,
                $exception instanceof RuntimeException ? $exception->getMessage() : 'provider_request_failed',
            );
        }

        return BreachedPasswordCheckResult::notBreached(self::PROVIDER);
    }

    /**
     * @return list<string>
     */
    private function rowsForPrefix(string $prefix): array
    {
        $ttl = (int) config('platform.security.passwords.breached.hibp.cache_ttl_seconds', 86400);

        if ($ttl <= 0) {
            return $this->fetchRowsForPrefix($prefix);
        }

        return Cache::remember(
            'platform:hibp-password-prefix:'.strtolower($prefix),
            now()->addSeconds($ttl),
            fn (): array => $this->fetchRowsForPrefix($prefix),
        );
    }

    /**
     * @return list<string>
     */
    private function fetchRowsForPrefix(string $prefix): array
    {
        $endpoint = rtrim((string) config('platform.security.passwords.breached.hibp.endpoint'), '/');
        $timeout = (int) config('platform.security.passwords.breached.hibp.timeout_seconds', 5);

        $response = Http::withHeaders([
            'Add-Padding' => 'true',
            'User-Agent' => $this->userAgent(),
        ])
            ->timeout(max(1, $timeout))
            ->get($endpoint.'/'.$prefix);

        if (! $response->successful()) {
            throw new RuntimeException('provider_http_'.$response->status());
        }

        return array_values(array_filter(
            preg_split('/\r\n|\r|\n/', $response->body()) ?: [],
            fn (string $row): bool => trim($row) !== '',
        ));
    }

    private function userAgent(): string
    {
        return str((string) config('app.service_name', 'login-app-v2'))
            ->append('/', (string) config('app.version', 'local'))
            ->toString();
    }
}
