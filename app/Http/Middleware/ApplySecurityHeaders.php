<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplySecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! config('platform.security.headers.enabled', true)) {
            return $response;
        }

        foreach ((array) config('platform.security.headers.defaults', []) as $header => $value) {
            if (is_string($value) && $value !== '') {
                $response->headers->set($header, $value);
            }
        }

        $contentSecurityPolicy = config('platform.security.headers.content_security_policy');

        if ($this->shouldApplyBrowserHtmlHeaders($request, $response) && is_string($contentSecurityPolicy) && $contentSecurityPolicy !== '') {
            $response->headers->set('Content-Security-Policy', $contentSecurityPolicy);
        }

        $strictTransportSecurity = config('platform.security.headers.strict_transport_security');

        if (
            config('platform.security.headers.hsts_enabled', false)
            && $request->isSecure()
            && is_string($strictTransportSecurity)
            && $strictTransportSecurity !== ''
        ) {
            $response->headers->set('Strict-Transport-Security', $strictTransportSecurity);
        }

        return $response;
    }

    private function shouldApplyBrowserHtmlHeaders(Request $request, Response $response): bool
    {
        if ($request->expectsJson()) {
            return false;
        }

        $contentType = strtolower((string) $response->headers->get('Content-Type', ''));

        return $contentType === '' || str_contains($contentType, 'text/html');
    }
}
