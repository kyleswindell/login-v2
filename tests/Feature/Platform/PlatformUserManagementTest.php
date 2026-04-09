<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PlatformUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_platform_users_index(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/users')
            ->assertOk()
            ->assertSee('Platform Users');
    }

    public function test_standard_users_cannot_access_platform_user_management(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/platform/users')
            ->assertForbidden();
    }

    public function test_super_admin_can_create_platform_users_with_roles(): void
    {
        $this->actingAsPlatformSuperAdmin();

        Role::query()->create([
            'name' => 'platform_admin',
            'guard_name' => 'web',
        ]);

        $this->post('/platform/users', [
            'name' => 'Operations User',
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

        Role::query()->create([
            'name' => 'platform_admin',
            'guard_name' => 'web',
        ]);

        $user = User::factory()->create([
            'is_active' => true,
        ]);

        $this->put("/platform/users/{$user->id}", [
            'name' => 'Updated User',
            'email' => $user->email,
            'password' => '',
            'roles' => ['platform_admin'],
        ])->assertRedirect();

        $user->refresh();

        $this->assertSame('Updated User', $user->name);
        $this->assertFalse($user->is_active);
        $this->assertTrue($user->hasRole('platform_admin'));
    }
}
