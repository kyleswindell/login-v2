<?php

namespace App\Http\Middleware;

use App\Platform\Security\RuntimeSecurityConfig;
use Closure;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfigureTrustedProxies
{
    public function handle(Request $request, Closure $next): Response
    {
        TrustProxies::flushState();

        $tlsTermination = RuntimeSecurityConfig::configuredTlsTermination();
        $trustedProxies = RuntimeSecurityConfig::configuredTrustedProxies();

        if (RuntimeSecurityConfig::shouldTrustConfiguredProxies($tlsTermination, $trustedProxies)) {
            TrustProxies::at($trustedProxies);
            TrustProxies::withHeaders(RuntimeSecurityConfig::trustedProxyHeaders());
        }

        return $next($request);
    }
}
