<?php

namespace App\Platform\Security;

use Illuminate\Support\Facades\Http;
use Throwable;

class RuntimeSecurityChecker
{
    /** @var list<string> */
    private const TARGETS = ['local', 'staging', 'production'];

    /**
     * @return array<string, mixed>
     */
    public function check(string $target = 'local', ?string $url = null): array
    {
        $target = strtolower(trim($target));

        if (! in_array($target, self::TARGETS, true)) {
            return [
                'target' => $target,
                'checks' => [
                    $this->checkRow('target', 'fail', 'Target must be one of: local, staging, production.'),
                ],
                'exit_code' => 1,
            ];
        }

        $checks = [
            $this->debugCheck($target),
            $this->securityHeadersCheck($target),
            $this->httpsExpectationCheck($target),
            $this->hstsCheck($target),
            $this->sessionSecureCookieCheck($target),
            $this->sessionEncryptionCheck($target),
            $this->sessionSameSiteCheck($target),
            $this->tlsTerminationCheck(),
            $this->trustedProxyCheck(),
            $this->databaseSslModeCheck($target),
        ];

        if (is_string($url) && trim($url) !== '') {
            array_push($checks, ...$this->probeUrl(trim($url), $target));
        } else {
            $checks[] = $this->checkRow('http_probe', 'skipped', 'No URL was supplied for deployed response-header probing.');
        }

        $hasFailures = collect($checks)->contains(fn (array $check): bool => $check['status'] === 'fail');

        return [
            'target' => $target,
            'checks' => $checks,
            'exit_code' => $hasFailures && $target !== 'local' ? 1 : 0,
        ];
    }

    private function debugCheck(string $target): array
    {
        if (! (bool) config('app.debug')) {
            return $this->checkRow('app_debug', 'pass', 'Debug output is disabled.');
        }

        return $this->checkRow(
            'app_debug',
            $this->strictStatus($target),
            $target === 'local'
                ? 'Debug output is enabled for local development.'
                : 'Debug output must be disabled for staging and production.',
        );
    }

    private function securityHeadersCheck(string $target): array
    {
        if ((bool) config('platform.security.headers.enabled', true)) {
            return $this->checkRow('security_headers', 'pass', 'Platform security response headers are enabled.');
        }

        return $this->checkRow('security_headers', $this->strictStatus($target), 'Platform security response headers are disabled.');
    }

    private function httpsExpectationCheck(string $target): array
    {
        $expectsHttps = (bool) config('platform.security.runtime.expect_https', false);

        if ($expectsHttps) {
            return $this->checkRow('expect_https', 'pass', 'Runtime is configured to expect HTTPS.');
        }

        return $this->checkRow(
            'expect_https',
            $target === 'local' ? 'pass' : 'fail',
            $target === 'local'
                ? 'Local runtime does not require HTTPS.'
                : 'Staging and production must be configured to expect HTTPS.',
        );
    }

    private function hstsCheck(string $target): array
    {
        $hstsEnabled = (bool) config('platform.security.headers.hsts_enabled', false);

        if ($target === 'local') {
            return $this->checkRow(
                'hsts',
                $hstsEnabled ? 'warn' : 'pass',
                $hstsEnabled
                    ? 'HSTS is enabled locally; confirm this is intentional for HTTPS-only local testing.'
                    : 'HSTS is disabled for local HTTP compatibility.',
            );
        }

        return $this->checkRow(
            'hsts',
            $hstsEnabled ? 'pass' : 'fail',
            $hstsEnabled
                ? 'HSTS is enabled for HTTPS responses.'
                : 'HSTS must be enabled for staging and production HTTPS surfaces.',
        );
    }

    private function sessionSecureCookieCheck(string $target): array
    {
        if ((bool) config('session.secure')) {
            return $this->checkRow('session_secure_cookie', 'pass', 'Session cookies are configured as Secure.');
        }

        return $this->checkRow(
            'session_secure_cookie',
            $target === 'local' ? 'pass' : 'fail',
            $target === 'local'
                ? 'Local HTTP sessions do not force Secure cookies.'
                : 'Staging and production session cookies must be Secure.',
        );
    }

    private function sessionEncryptionCheck(string $target): array
    {
        if ((bool) config('session.encrypt')) {
            return $this->checkRow('session_encryption', 'pass', 'Session payload encryption is enabled.');
        }

        return $this->checkRow('session_encryption', $this->strictStatus($target), 'Session payload encryption is disabled.');
    }

    private function sessionSameSiteCheck(string $target): array
    {
        $sameSite = strtolower((string) config('session.same_site', ''));

        if ($sameSite === 'lax') {
            return $this->checkRow('session_same_site', 'pass', 'Session SameSite posture is Lax.');
        }

        return $this->checkRow('session_same_site', $this->strictStatus($target), 'Session SameSite posture is not Lax.');
    }

    private function tlsTerminationCheck(): array
    {
        $mode = RuntimeSecurityConfig::configuredTlsTermination();

        if (in_array($mode, RuntimeSecurityConfig::TLS_TERMINATION_MODES, true)) {
            return $this->checkRow('tls_termination', 'pass', "TLS termination mode is {$mode}.");
        }

        return $this->checkRow('tls_termination', 'fail', 'TLS termination mode must be direct or trusted_proxy.');
    }

    private function trustedProxyCheck(): array
    {
        $mode = RuntimeSecurityConfig::configuredTlsTermination();
        $proxies = RuntimeSecurityConfig::configuredTrustedProxies();

        if ($mode === RuntimeSecurityConfig::TLS_DIRECT) {
            return $this->checkRow('trusted_proxies', 'pass', 'Trusted proxy declaration is not required for direct TLS termination.');
        }

        if ($mode !== RuntimeSecurityConfig::TLS_TRUSTED_PROXY) {
            return $this->checkRow('trusted_proxies', 'fail', 'Trusted proxy declaration cannot be evaluated until TLS termination mode is valid.');
        }

        if ($proxies === []) {
            return $this->checkRow('trusted_proxies', 'fail', 'Trusted proxy mode requires at least one explicit proxy IP or CIDR.');
        }

        if (RuntimeSecurityConfig::hasUnsafeWildcardProxy($proxies)) {
            return $this->checkRow('trusted_proxies', 'fail', 'Trusted proxy mode must not use wildcard or all-network proxy trust.');
        }

        return $this->checkRow('trusted_proxies', 'pass', 'Trusted proxy mode has explicit proxy entries.', [
            'proxy_count' => count($proxies),
        ]);
    }

    private function databaseSslModeCheck(string $target): array
    {
        $sslMode = strtolower((string) config('database.connections.pgsql.sslmode', ''));

        if (in_array($sslMode, ['require', 'verify-ca', 'verify-full'], true)) {
            return $this->checkRow('database_sslmode', 'pass', 'PostgreSQL SSL mode requires encrypted transport.');
        }

        if ($sslMode === 'prefer') {
            return $this->checkRow('database_sslmode', $target === 'local' ? 'pass' : 'warn', 'PostgreSQL SSL mode is prefer; confirm deployed database transport evidence.');
        }

        return $this->checkRow('database_sslmode', $this->strictStatus($target), 'PostgreSQL SSL mode does not provide deployment evidence for encrypted transport.');
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function probeUrl(string $url, string $target): array
    {
        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        if (! in_array($scheme, ['http', 'https'], true)) {
            return [
                $this->checkRow('http_probe_url', 'fail', 'Probe URL must use http or https.'),
            ];
        }

        $checks = [
            $this->checkRow(
                'http_probe_url',
                $scheme === 'https' || $target === 'local' ? 'pass' : 'fail',
                $scheme === 'https'
                    ? 'Probe URL uses HTTPS.'
                    : 'Probe URL uses HTTP.',
            ),
        ];

        try {
            $response = Http::timeout(10)->get($url);
        } catch (Throwable) {
            $checks[] = $this->checkRow('http_probe_reachable', $this->strictStatus($target), 'Probe URL could not be reached.');

            return $checks;
        }

        $checks[] = $this->checkRow(
            'http_probe_reachable',
            $response->status() < 500 ? 'pass' : $this->strictStatus($target),
            "Probe URL returned HTTP {$response->status()}.",
        );

        $checks[] = $this->probeBaselineHeadersCheck($response->headers());
        $checks[] = $this->probeCspCheck($response->headers());
        $checks[] = $this->probeHstsCheck($response->headers(), $scheme, $target);

        return $checks;
    }

    /**
     * @param array<string, list<string>> $headers
     */
    private function probeBaselineHeadersCheck(array $headers): array
    {
        $missing = [];

        foreach ((array) config('platform.security.headers.defaults', []) as $name => $expected) {
            $actual = $this->headerValue($headers, $name);

            if ($actual !== $expected) {
                $missing[] = $name;
            }
        }

        return $this->checkRow(
            'http_probe_security_headers',
            $missing === [] ? 'pass' : 'fail',
            $missing === []
                ? 'Probe response includes the baseline security headers.'
                : 'Probe response is missing or mismatching baseline security headers: '.implode(', ', $missing).'.',
        );
    }

    /**
     * @param array<string, list<string>> $headers
     */
    private function probeCspCheck(array $headers): array
    {
        $contentType = strtolower($this->headerValue($headers, 'Content-Type') ?? '');

        if (! str_contains($contentType, 'text/html')) {
            return $this->checkRow('http_probe_frame_ancestors', 'skipped', 'Probe response is not HTML; frame-ancestor CSP was not evaluated.');
        }

        $expected = config('platform.security.headers.content_security_policy');

        return $this->checkRow(
            'http_probe_frame_ancestors',
            $this->headerValue($headers, 'Content-Security-Policy') === $expected ? 'pass' : 'fail',
            'Probe HTML response frame-ancestor CSP was evaluated.',
        );
    }

    /**
     * @param array<string, list<string>> $headers
     */
    private function probeHstsCheck(array $headers, string $scheme, string $target): array
    {
        $actual = $this->headerValue($headers, 'Strict-Transport-Security');
        $expected = config('platform.security.headers.strict_transport_security');
        $hstsEnabled = (bool) config('platform.security.headers.hsts_enabled', false);

        if ($scheme === 'https' && $hstsEnabled) {
            return $this->checkRow(
                'http_probe_hsts',
                $actual === $expected ? 'pass' : 'fail',
                'Probe HTTPS response HSTS header was evaluated.',
            );
        }

        if ($scheme === 'http' && $actual !== null) {
            return $this->checkRow('http_probe_hsts', $this->strictStatus($target), 'Probe HTTP response unexpectedly includes HSTS.');
        }

        return $this->checkRow('http_probe_hsts', 'pass', 'Probe HSTS behavior matches the selected URL scheme and config.');
    }

    /**
     * @param array<string, list<string>> $headers
     */
    private function headerValue(array $headers, string $name): ?string
    {
        foreach ($headers as $header => $values) {
            if (strtolower($header) === strtolower($name)) {
                return $values[0] ?? null;
            }
        }

        return null;
    }

    private function strictStatus(string $target): string
    {
        return $target === 'local' ? 'warn' : 'fail';
    }

    /**
     * @param array<string, mixed> $details
     * @return array<string, mixed>
     */
    private function checkRow(string $name, string $status, string $message, array $details = []): array
    {
        return [
            'name' => $name,
            'status' => $status,
            'message' => $message,
            'details' => $details,
        ];
    }
}
