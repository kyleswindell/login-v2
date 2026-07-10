<?php

namespace App\Platform\Security;

use Illuminate\Http\Request;

class RuntimeSecurityConfig
{
    public const TLS_DIRECT = 'direct';
    public const TLS_TRUSTED_PROXY = 'trusted_proxy';

    /** @var list<string> */
    public const TLS_TERMINATION_MODES = [
        self::TLS_DIRECT,
        self::TLS_TRUSTED_PROXY,
    ];

    public static function configuredTlsTermination(): string
    {
        return self::normalizeTlsTermination((string) config('platform.security.runtime.tls_termination', self::TLS_DIRECT));
    }

    /**
     * @return list<string>
     */
    public static function configuredTrustedProxies(): array
    {
        return self::parseTrustedProxies(config('platform.security.runtime.trusted_proxies', []));
    }

    public static function normalizeTlsTermination(?string $value): string
    {
        return strtolower(trim((string) $value));
    }

    /**
     * @param string|array<int, string>|null $value
     * @return list<string>
     */
    public static function parseTrustedProxies(string|array|null $value): array
    {
        $items = is_array($value)
            ? $value
            : explode(',', (string) $value);

        $proxies = [];

        foreach ($items as $item) {
            $proxy = trim((string) $item);

            if ($proxy !== '') {
                $proxies[] = $proxy;
            }
        }

        return array_values(array_unique($proxies));
    }

    /**
     * @param list<string> $proxies
     */
    public static function shouldTrustConfiguredProxies(string $tlsTermination, array $proxies): bool
    {
        return $tlsTermination === self::TLS_TRUSTED_PROXY
            && $proxies !== []
            && ! self::hasUnsafeWildcardProxy($proxies);
    }

    /**
     * @param list<string> $proxies
     */
    public static function hasUnsafeWildcardProxy(array $proxies): bool
    {
        $unsafe = ['*', '0.0.0.0', '0.0.0.0/0', '::', '::/0'];

        foreach ($proxies as $proxy) {
            if (in_array(strtolower($proxy), $unsafe, true)) {
                return true;
            }
        }

        return false;
    }

    public static function trustedProxyHeaders(): int
    {
        return Request::HEADER_X_FORWARDED_FOR
            | Request::HEADER_X_FORWARDED_HOST
            | Request::HEADER_X_FORWARDED_PORT
            | Request::HEADER_X_FORWARDED_PROTO;
    }
}
