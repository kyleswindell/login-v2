<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\LocalReviewEnvironment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class LocalReadyCommandTest extends TestCase
{
    use RefreshDatabase;

    private string $hotPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->hotPath = storage_path('framework/testing/hot-'.Str::uuid());
    }

    protected function tearDown(): void
    {
        if (File::exists($this->hotPath)) {
            @chmod($this->hotPath, 0644);
        }

        File::delete($this->hotPath);

        parent::tearDown();
    }

    public function test_it_creates_the_local_review_user_and_normalizes_the_hot_file(): void
    {
        $this->artisan('local:ready', [
            '--hot-path' => $this->hotPath,
            '--skip-http-checks' => true,
        ])->assertSuccessful();

        $this->assertSame(LocalReviewEnvironment::VITE_URL, File::get($this->hotPath));

        $user = User::query()
            ->where('email', LocalReviewEnvironment::EMAIL)
            ->firstOrFail();

        $this->assertTrue(Hash::check(LocalReviewEnvironment::PASSWORD, $user->password));
        $this->assertTrue($user->is_active);
        $this->assertTrue($user->hasRole(LocalReviewEnvironment::ROLE));
        $this->assertTrue($user->can('platform.ui-reference.view'));
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
            '--hot-path' => $this->hotPath,
            '--skip-http-checks' => true,
        ])->assertSuccessful();

        $this->artisan('local:ready', [
            '--hot-path' => $this->hotPath,
            '--skip-http-checks' => true,
        ])->assertSuccessful();

        $this->assertSame(1, User::query()->where('email', LocalReviewEnvironment::EMAIL)->count());
        $this->assertSame(LocalReviewEnvironment::VITE_URL, File::get($this->hotPath));

        $user = User::query()
            ->where('email', LocalReviewEnvironment::EMAIL)
            ->firstOrFail();

        $this->assertTrue(Hash::check(LocalReviewEnvironment::PASSWORD, $user->password));
        $this->assertTrue($user->is_active);
        $this->assertTrue($user->hasRole(LocalReviewEnvironment::ROLE));
        $this->assertTrue($user->can('platform.ui-reference.view'));
    }
}
