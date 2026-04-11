<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_platform_users_setup_page(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/setup/users')
            ->assertOk()
            ->assertSee('Platform Users Setup')
            ->assertSee('Add Staff Member')
            ->assertSee('Existing Staff')
            ->assertSee('User Settings');
    }

    public function test_super_admin_can_view_platform_users_index(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/users')
            ->assertOk()
            ->assertSee('Platform Users');
    }

    public function test_super_admin_can_view_filament_platform_users_migration_surface(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/console/platform-users')
            ->assertOk()
            ->assertSee('Platform Users');
    }

    public function test_super_admin_is_redirected_from_target_users_route_to_filament_surface(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/administration/users')
            ->assertRedirect('/console/platform-users');
    }

    public function test_standard_users_cannot_access_platform_user_management(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/platform/users')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/platform/setup/users')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/console/platform-users')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/platform/administration/users')
            ->assertForbidden();
    }

    public function test_super_admin_can_create_platform_users_with_roles(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/users', [
            'first_name' => 'Operations',
            'last_name' => 'User',
            'email' => 'ops@example.com',
            'password' => 'Password123!',
            'is_active' => '1',
            'roles' => ['platform_admin'],
        ])->assertRedirect();

        $user = User::query()->where('email', 'ops@example.com')->firstOrFail();

        $this->assertTrue($user->is_active);
        $this->assertTrue($user->hasRole('platform_admin'));
    }

    public function test_super_admin_can_update_platform_users(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $user = User::factory()->create([
            'is_active' => true,
        ]);

        $this->put("/platform/users/{$user->id}", [
            'first_name' => 'Updated',
            'last_name' => 'User',
            'email' => $user->email,
            'password' => '',
            'roles' => ['platform_admin'],
        ])->assertRedirect();

        $user->refresh();

        $this->assertSame('Updated User', $user->name);
        $this->assertTrue($user->is_active);
        $this->assertTrue($user->hasRole('platform_admin'));
    }
}
