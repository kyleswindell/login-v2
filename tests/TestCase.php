<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Feature tests should assert authorization and validation behavior,
        // not CSRF token wiring from rendered forms.
        $this->withoutMiddleware(PreventRequestForgery::class);
    }

    protected function actingAsPlatformSuperAdmin(?User $user = null): User
    {
        $user ??= User::factory()->create();

        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user->syncRoles(['platform_super_admin']);
        $this->actingAs($user);

        return $user;
    }
}
