<?php

namespace Tests\Feature\Platform;

use App\Platform\Security\RuntimeSecurityChecker;
use App\Platform\Security\RuntimeSecurityConfig;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Command\Command;
use Tests\TestCase;

class PlatformSecurityRuntimeCheckTest extends TestCase
{
    public function test_local_defaults_do_not_fail_runtime_check(): void
    {
        $this->configureLocalDefaults();

        $this->artisan('platform:security-runtime-check', [
            '--target' => 'local',
        ])->assertSuccessful();
    }

    public function test_staging_target_fails_when_required_runtime_hardening_is_missing(): void
    {
        config()->set('app.debug', true);
        config()->set('platform.security.headers.enabled', false);
        config()->set('platform.security.headers.hsts_enabled', false);
        config()->set('platform.security.runtime.expect_https', false);
        config()->set('platform.security.runtime.tls_termination', RuntimeSecurityConfig::TLS_TRUSTED_PROXY);
        config()->set('platform.security.runtime.trusted_proxies', '');
        config()->set('session.secure', false);
        config()->set('session.encrypt', false);
        config()->set('session.same_site', 'none');
        config()->set('database.connections.pgsql.sslmode', 'disable');

        $statuses = collect(app(RuntimeSecurityChecker::class)->check('staging')['checks'])
            ->pluck('status', 'name');

        $this->assertSame('fail', $statuses['app_debug']);
        $this->assertSame('fail', $statuses['security_headers']);
        $this->assertSame('fail', $statuses['expect_https']);
        $this->assertSame('fail', $statuses['hsts']);
        $this->assertSame('fail', $statuses['session_secure_cookie']);
        $this->assertSame('fail', $statuses['session_encryption']);
        $this->assertSame('fail', $statuses['session_same_site']);
        $this->assertSame('pass', $statuses['tls_termination']);
        $this->assertSame('fail', $statuses['trusted_proxies']);
        $this->assertSame('fail', $statuses['database_sslmode']);

        $this->artisan('platform:security-runtime-check', [
            '--target' => 'staging',
        ])->assertExitCode(Command::FAILURE)
            ->expectsOutputToContain('[FAIL] app_debug')
            ->expectsOutputToContain('[FAIL] trusted_proxies')
            ->expectsOutputToContain('[FAIL] session_secure_cookie');
    }

    public function test_trusted_proxy_config_parsing_and_safety_rules(): void
    {
        $this->assertSame(
            ['10.0.0.1', '10.0.0.0/24'],
            RuntimeSecurityConfig::parseTrustedProxies('10.0.0.1, 10.0.0.0/24,,10.0.0.1'),
        );

        $this->assertFalse(RuntimeSecurityConfig::shouldTrustConfiguredProxies(
            RuntimeSecurityConfig::TLS_DIRECT,
            ['10.0.0.1'],
        ));

        $this->assertTrue(RuntimeSecurityConfig::shouldTrustConfiguredProxies(
            RuntimeSecurityConfig::TLS_TRUSTED_PROXY,
            ['10.0.0.1'],
        ));

        $this->assertFalse(RuntimeSecurityConfig::shouldTrustConfiguredProxies(
            RuntimeSecurityConfig::TLS_TRUSTED_PROXY,
            ['0.0.0.0/0'],
        ));
    }

    public function test_trusted_proxy_mode_with_empty_proxies_fails_readiness_without_boot_failure(): void
    {
        config()->set('platform.security.runtime.tls_termination', RuntimeSecurityConfig::TLS_TRUSTED_PROXY);
        config()->set('platform.security.runtime.trusted_proxies', '');

        $checks = collect(app(RuntimeSecurityChecker::class)->check('staging')['checks']);

        $this->assertSame('fail', $checks->firstWhere('name', 'trusted_proxies')['status']);
    }

    public function test_json_output_contains_safe_check_data_only(): void
    {
        config()->set('database.connections.pgsql.password', 'super-secret-password');

        $exitCode = Artisan::call('platform:security-runtime-check', [
            '--target' => 'staging',
            '--json' => true,
        ]);

        $output = Artisan::output();

        $this->assertSame(Command::FAILURE, $exitCode);
        $this->assertJson($output);
        $this->assertStringContainsString('"checks"', $output);
        $this->assertStringNotContainsString('super-secret-password', $output);
    }

    public function test_http_probe_passes_when_deployed_headers_match_runtime_expectations(): void
    {
        $this->configureHardenedStaging();

        Http::fake([
            'https://staging.example.test/*' => Http::response('<html>ok</html>', 200, $this->hardenedHeaders()),
        ]);

        $this->artisan('platform:security-runtime-check', [
            '--target' => 'staging',
            '--url' => 'https://staging.example.test/login',
        ])->assertSuccessful();

        Http::assertSent(fn ($request): bool => $request->url() === 'https://staging.example.test/login');
    }

    public function test_http_probe_fails_when_deployed_headers_are_missing(): void
    {
        $this->configureHardenedStaging();

        Http::fake([
            'https://staging.example.test/*' => Http::response('<html>ok</html>', 200, [
                'Content-Type' => 'text/html; charset=UTF-8',
            ]),
        ]);

        $this->artisan('platform:security-runtime-check', [
            '--target' => 'staging',
            '--url' => 'https://staging.example.test/login',
        ])->assertExitCode(Command::FAILURE)
            ->expectsOutputToContain('[FAIL] http_probe_security_headers')
            ->expectsOutputToContain('[FAIL] http_probe_hsts');
    }

    private function configureLocalDefaults(): void
    {
        config()->set('app.debug', true);
        config()->set('platform.security.headers.enabled', true);
        config()->set('platform.security.headers.hsts_enabled', false);
        config()->set('platform.security.runtime.expect_https', false);
        config()->set('platform.security.runtime.tls_termination', RuntimeSecurityConfig::TLS_DIRECT);
        config()->set('platform.security.runtime.trusted_proxies', '');
        config()->set('session.secure', false);
        config()->set('session.encrypt', false);
        config()->set('session.same_site', 'lax');
        config()->set('database.connections.pgsql.sslmode', 'prefer');
    }

    private function configureHardenedStaging(): void
    {
        config()->set('app.debug', false);
        config()->set('platform.security.headers.enabled', true);
        config()->set('platform.security.headers.hsts_enabled', true);
        config()->set('platform.security.runtime.expect_https', true);
        config()->set('platform.security.runtime.tls_termination', RuntimeSecurityConfig::TLS_DIRECT);
        config()->set('platform.security.runtime.trusted_proxies', '');
        config()->set('session.secure', true);
        config()->set('session.encrypt', true);
        config()->set('session.same_site', 'lax');
        config()->set('database.connections.pgsql.sslmode', 'require');
    }

    /**
     * @return array<string, string>
     */
    private function hardenedHeaders(): array
    {
        return [
            'Content-Type' => 'text/html; charset=UTF-8',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'X-Frame-Options' => 'DENY',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(), payment=(), usb=()',
            'Content-Security-Policy' => "frame-ancestors 'none'",
            'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
        ];
    }
}
