<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\LocalReviewEnvironment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Tests\TestCase;

class LocalReadyCommandTest extends TestCase
{
    use RefreshDatabase;

    private string $envPath;
    private string $hotPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->envPath = storage_path('framework/testing/env-'.Str::uuid());
        $this->hotPath = storage_path('framework/testing/hot-'.Str::uuid());

        File::ensureDirectoryExists(dirname($this->envPath));
        File::put($this->envPath, implode(PHP_EOL, [
            'APP_URL=http://192.168.50.10:8000',
            'VITE_DEV_SERVER_URL=http://192.168.50.10:5173',
            'REVERB_HOST=localhost',
            'REVERB_PORT=8080',
            'REVERB_SCHEME=http',
            'VITE_REVERB_HOST="${REVERB_HOST}"',
            'VITE_REVERB_PORT="${REVERB_PORT}"',
            'VITE_REVERB_SCHEME="${REVERB_SCHEME}"',
            '',
        ]));
    }

    protected function tearDown(): void
    {
        if (File::exists($this->hotPath)) {
            @chmod($this->hotPath, 0644);
        }

        File::delete($this->hotPath);
        File::delete($this->envPath);

        parent::tearDown();
    }

    public function test_it_creates_the_local_review_user_and_normalizes_the_hot_file(): void
    {
        $this->artisan('local:ready', [
            '--env-path' => $this->envPath,
            '--hot-path' => $this->hotPath,
            '--skip-http-checks' => true,
        ])->assertSuccessful();

        $this->assertSame('http://192.168.50.10:5173', File::get($this->hotPath));
        $this->assertStringContainsString('REVERB_HOST=192.168.50.10', File::get($this->envPath));
        $this->assertStringContainsString('VITE_REVERB_HOST=${REVERB_HOST}', File::get($this->envPath));

        $user = User::query()
            ->where('email', LocalReviewEnvironment::EMAIL)
            ->firstOrFail();

        $this->assertTrue(Hash::check(LocalReviewEnvironment::PASSWORD, $user->password));
        $this->assertTrue($user->is_active);
        $this->assertTrue($user->hasRole(LocalReviewEnvironment::ROLE));
    }

    public function test_it_is_safe_to_rerun_after_a_database_reset_or_existing_user_change(): void
    {
        User::factory()->create([
            'email' => LocalReviewEnvironment::EMAIL,
            'password' => 'old-password',
            'is_active' => false,
        ]);

        File::put($this->hotPath, 'http://0.0.0.0:5173');
        @chmod($this->hotPath, 0444);

        $this->artisan('local:ready', [
            '--env-path' => $this->envPath,
            '--hot-path' => $this->hotPath,
            '--skip-http-checks' => true,
        ])->assertSuccessful();

        $this->artisan('local:ready', [
            '--env-path' => $this->envPath,
            '--hot-path' => $this->hotPath,
            '--skip-http-checks' => true,
        ])->assertSuccessful();

        $this->assertSame(1, User::query()->where('email', LocalReviewEnvironment::EMAIL)->count());
        $this->assertSame('http://192.168.50.10:5173', File::get($this->hotPath));
        $env = File::get($this->envPath);
        $this->assertSame(1, preg_match_all('/^REVERB_HOST=/m', $env));
        $this->assertSame(1, preg_match_all('/^VITE_REVERB_HOST=/m', $env));

        $user = User::query()
            ->where('email', LocalReviewEnvironment::EMAIL)
            ->firstOrFail();

        $this->assertTrue(Hash::check(LocalReviewEnvironment::PASSWORD, $user->password));
        $this->assertTrue($user->is_active);
        $this->assertTrue($user->hasRole(LocalReviewEnvironment::ROLE));
    }

    public function test_it_checks_vite_javascript_css_and_app_routes(): void
    {
        Http::fake([
            'http://node:5173/resources/js/app.js' => Http::response('', 200, [
                'Access-Control-Allow-Origin' => 'http://localhost:8000',
            ]),
            'http://node:5173/resources/css/app.css' => Http::response('', 200, [
                'Access-Control-Allow-Origin' => 'http://localhost:8000',
            ]),
            'http://localhost:8000/login' => Http::response('', 200),
        ]);

        $this->artisan('local:ready', [
            '--env-path' => $this->envPath,
            '--hot-path' => $this->hotPath,
            '--app-url' => 'http://localhost:8000',
            '--vite-url' => LocalReviewEnvironment::VITE_URL,
            '--vite-check-url' => 'http://node:5173',
        ])
            ->expectsOutputToContain('[ok] vite js:')
            ->expectsOutputToContain('[ok] vite css:')
            ->expectsOutputToContain('[ok] app:')
            ->assertSuccessful();

        Http::assertSent(fn ($request): bool => $request->url() === 'http://node:5173/resources/js/app.js'
            && $request->hasHeader('Origin', 'http://localhost:8000'));
        Http::assertSent(fn ($request): bool => $request->url() === 'http://node:5173/resources/css/app.css'
            && $request->hasHeader('Origin', 'http://localhost:8000'));
        Http::assertSent(fn ($request): bool => $request->url() === 'http://localhost:8000/login');
    }

    public function test_it_rejects_vite_assets_that_do_not_allow_the_browser_origin(): void
    {
        Http::fake([
            'http://node:5173/resources/js/app.js' => Http::response('', 200),
            'http://node:5173/resources/css/app.css' => Http::response('', 200, [
                'Access-Control-Allow-Origin' => 'http://localhost:8000',
            ]),
            'http://localhost:8000/login' => Http::response('', 200),
        ]);

        $this->artisan('local:ready', [
            '--env-path' => $this->envPath,
            '--hot-path' => $this->hotPath,
            '--app-url' => 'http://localhost:8000',
            '--vite-url' => LocalReviewEnvironment::VITE_URL,
            '--vite-check-url' => 'http://node:5173',
        ])
            ->expectsOutputToContain('[failed] vite js:')
            ->assertFailed();

        $result = app(LocalReviewEnvironment::class)->prepare(
            envPath: $this->envPath,
            hotPath: $this->hotPath,
            viteUrl: LocalReviewEnvironment::VITE_URL,
            viteCheckUrl: 'http://node:5173',
            appUrl: 'http://localhost:8000',
        );
        $viteJsCheck = collect($result['checks'])->firstWhere('name', 'vite js');

        $this->assertIsArray($viteJsCheck);
        $this->assertSame('failed', $viteJsCheck['status']);
        $this->assertStringContainsString(
            'did not allow browser origin http://localhost:8000',
            $viteJsCheck['message'],
        );
    }
}
