<?php

namespace Tests\Feature\Core\Runtime;

use App\Core\Runtime\Resolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ResolutionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('app.url', 'http://localhost');
    }

    public function test_resolver_returns_current_parasolutions_runtime_context(): void
    {
        $context = app(Resolver::class)->resolve();

        $this->assertSame('parasolutions', $context->key);
        $this->assertSame('Parasolutions', $context->name);
        $this->assertSame('http://localhost', $context->url);
    }

    public function test_resolver_uses_request_url_without_changing_route_generation(): void
    {
        $request = Request::create('https://app.test/dashboard');

        $context = app(Resolver::class)->resolve($request);

        $this->assertSame('https://app.test', $context->url);
        $this->assertSame('http://localhost', config('app.url'));
    }

    public function test_resolver_falls_back_to_configured_app_url_without_request_host(): void
    {
        config()->set('app.url', 'http://192.168.50.10:8000/');

        $context = app(Resolver::class)->resolve();

        $this->assertSame('http://192.168.50.10:8000', $context->url);
    }

    public function test_context_does_not_claim_tenant_or_workspace_isolation(): void
    {
        $context = app(Resolver::class)->resolve();

        $this->assertSame([
            'key' => 'parasolutions',
            'name' => 'Parasolutions',
            'url' => 'http://localhost',
        ], $context->toArray());
    }

    public function test_existing_visible_routes_remain_unchanged(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');

        $user = $this->actingAsPlatformSuperAdmin();

        $this->get('/login')->assertRedirect('/dashboard');
        $this->get('/dashboard')->assertOk();
        $this->get('/account')->assertOk()->assertSee($user->email);
        $this->get('/platform/users')->assertOk();
    }
}
