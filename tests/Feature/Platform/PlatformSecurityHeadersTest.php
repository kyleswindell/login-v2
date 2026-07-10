<?php

namespace Tests\Feature\Platform;

use App\Platform\Security\RuntimeSecurityConfig;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PlatformSecurityHeadersTest extends TestCase
{
    use RefreshDatabase;

    public function test_html_responses_include_security_header_baseline(): void
    {
        $response = $this->get('/login');

        $response
            ->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=(), usb=()')
            ->assertHeader('Content-Security-Policy', "frame-ancestors 'none'");

        $this->assertFalse($response->baseResponse->headers->has('Strict-Transport-Security'));
    }

    public function test_json_responses_include_generic_headers_without_html_only_csp(): void
    {
        Route::get('/testing/security-json', fn () => response()->json(['ok' => true]));

        $response = $this->getJson('/testing/security-json');

        $response
            ->assertOk()
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=(), usb=()');

        $this->assertFalse($response->baseResponse->headers->has('Content-Security-Policy'));
    }

    public function test_hsts_is_only_sent_for_secure_requests_when_enabled(): void
    {
        config()->set('platform.security.headers.hsts_enabled', true);

        $httpResponse = $this->get('/login')
            ->assertOk();

        $this->assertFalse($httpResponse->baseResponse->headers->has('Strict-Transport-Security'));

        $this->get('https://localhost/login')
            ->assertOk()
            ->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    }

    public function test_security_headers_can_be_disabled(): void
    {
        config()->set('platform.security.headers.enabled', false);

        $response = $this->get('/login');

        $response->assertOk();

        $this->assertFalse($response->baseResponse->headers->has('X-Content-Type-Options'));
        $this->assertFalse($response->baseResponse->headers->has('Referrer-Policy'));
        $this->assertFalse($response->baseResponse->headers->has('X-Frame-Options'));
        $this->assertFalse($response->baseResponse->headers->has('Permissions-Policy'));
        $this->assertFalse($response->baseResponse->headers->has('Content-Security-Policy'));
    }

    public function test_direct_tls_mode_ignores_forwarded_proto_for_hsts(): void
    {
        config()->set('platform.security.headers.hsts_enabled', true);
        config()->set('platform.security.runtime.tls_termination', RuntimeSecurityConfig::TLS_DIRECT);
        config()->set('platform.security.runtime.trusted_proxies', '10.0.0.1');

        Route::get('/testing/proxy-request-direct', fn (Request $request) => response()->json([
            'secure' => $request->isSecure(),
            'host' => $request->getHost(),
            'port' => $request->getPort(),
            'client_ip' => $request->ip(),
        ]));

        $response = $this->withServerVariables([
            'REMOTE_ADDR' => '10.0.0.1',
            'HTTP_HOST' => 'local.example.test:8080',
            'SERVER_PORT' => 8080,
            'HTTP_X_FORWARDED_FOR' => '203.0.113.10',
            'HTTP_X_FORWARDED_HOST' => 'forwarded.example.test',
            'HTTP_X_FORWARDED_PORT' => '443',
            'HTTP_X_FORWARDED_PROTO' => 'https',
        ])->getJson('/testing/proxy-request-direct');

        $response
            ->assertOk()
            ->assertJson([
                'secure' => false,
                'client_ip' => '10.0.0.1',
            ]);

        $this->assertNotSame('forwarded.example.test', $response->json('host'));
        $this->assertNotSame(443, $response->json('port'));
        $this->assertFalse($response->baseResponse->headers->has('Strict-Transport-Security'));
    }

    public function test_trusted_proxy_mode_honors_forwarded_headers_from_configured_proxy(): void
    {
        config()->set('platform.security.headers.hsts_enabled', true);
        config()->set('platform.security.runtime.tls_termination', RuntimeSecurityConfig::TLS_TRUSTED_PROXY);
        config()->set('platform.security.runtime.trusted_proxies', '10.0.0.1');

        Route::get('/testing/proxy-request-trusted', fn (Request $request) => response()->json([
            'secure' => $request->isSecure(),
            'host' => $request->getHost(),
            'port' => $request->getPort(),
            'client_ip' => $request->ip(),
        ]));

        $this->withServerVariables([
            'REMOTE_ADDR' => '10.0.0.1',
            'HTTP_X_FORWARDED_FOR' => '203.0.113.10',
            'HTTP_X_FORWARDED_HOST' => 'forwarded.example.test',
            'HTTP_X_FORWARDED_PORT' => '443',
            'HTTP_X_FORWARDED_PROTO' => 'https',
        ])->getJson('/testing/proxy-request-trusted')
            ->assertOk()
            ->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains')
            ->assertJson([
                'secure' => true,
                'host' => 'forwarded.example.test',
                'port' => 443,
                'client_ip' => '203.0.113.10',
            ]);
    }

    public function test_trusted_proxy_mode_ignores_forwarded_headers_from_unconfigured_proxy(): void
    {
        config()->set('platform.security.headers.hsts_enabled', true);
        config()->set('platform.security.runtime.tls_termination', RuntimeSecurityConfig::TLS_TRUSTED_PROXY);
        config()->set('platform.security.runtime.trusted_proxies', '10.0.0.1');

        Route::get('/testing/proxy-request-untrusted', fn (Request $request) => response()->json([
            'secure' => $request->isSecure(),
            'client_ip' => $request->ip(),
        ]));

        $response = $this->withServerVariables([
            'REMOTE_ADDR' => '10.0.0.2',
            'HTTP_X_FORWARDED_FOR' => '203.0.113.10',
            'HTTP_X_FORWARDED_PROTO' => 'https',
        ])->getJson('/testing/proxy-request-untrusted');

        $response
            ->assertOk()
            ->assertJson([
                'secure' => false,
                'client_ip' => '10.0.0.2',
            ]);

        $this->assertFalse($response->baseResponse->headers->has('Strict-Transport-Security'));
    }

    public function test_secure_session_cookie_flags_are_emitted_for_https_when_configured(): void
    {
        config()->set('session.secure', true);
        config()->set('session.http_only', true);
        config()->set('session.same_site', 'lax');

        $response = $this->withSession(['security_cookie_test' => true])
            ->withServerVariables([
                'HTTPS' => 'on',
                'SERVER_PORT' => 443,
            ])->get('/login');

        $cookie = $this->sessionCookieFrom($response);

        $this->assertNotNull($cookie);
        $this->assertTrue($cookie->isSecure());
        $this->assertTrue($cookie->isHttpOnly());
        $this->assertSame('lax', strtolower((string) $cookie->getSameSite()));
    }

    public function test_local_http_defaults_do_not_force_secure_session_cookie(): void
    {
        config()->set('session.secure', false);

        $response = $this->withSession(['security_cookie_test' => true])
            ->get('/login');

        $cookie = $this->sessionCookieFrom($response);

        $this->assertNotNull($cookie);
        $this->assertFalse($cookie->isSecure());
        $this->assertTrue($cookie->isHttpOnly());
        $this->assertSame('lax', strtolower((string) $cookie->getSameSite()));
    }

    private function sessionCookieFrom($response): ?\Symfony\Component\HttpFoundation\Cookie
    {
        foreach ($response->baseResponse->headers->getCookies() as $cookie) {
            if ($cookie->getName() === config('session.cookie')) {
                return $cookie;
            }
        }

        return null;
    }
}
