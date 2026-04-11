<?php

namespace Tests\Feature\Platform;

use App\Platform\Settings\SettingsService;
use App\Models\User;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformSetupPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_open_all_setup_pages(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/setup/notifications')->assertOk()->assertSee('Platform Notifications Setup');
        $this->get('/platform/setup/docs')->assertOk()->assertSee('Documentation Vault Setup');
        $this->get('/platform/setup/audit-logs')->assertOk()->assertSee('Audit Logs Setup');
        $this->get('/platform/setup/error-logs')->assertOk()->assertSee('Error Logs Setup');
        $this->get('/platform/setup/users')->assertOk()->assertSee('Platform Users Setup');
    }

    public function test_platform_admin_can_open_setup_pages_except_super_admin_docs_scope(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('platform_admin');

        app(SettingsService::class)->put('docs', 'access_scope', 'super_admins_only', updatedBy: $user->id);

        $this->actingAs($user)
            ->get('/platform/setup/notifications')
            ->assertOk();

        $this->actingAs($user)
            ->get('/platform/setup/docs')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/platform/setup/audit-logs')
            ->assertOk();

        $this->actingAs($user)
            ->get('/platform/setup/error-logs')
            ->assertOk();

        $this->actingAs($user)
            ->get('/platform/setup/users')
            ->assertOk();
    }
}
