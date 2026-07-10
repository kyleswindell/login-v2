<?php
/*
|--------------------------------------------------------------------------
| File: tests/Feature/Platform/PlatformSetupPagesTest.php
| Purpose: Verifies Setup module route behavior.
|--------------------------------------------------------------------------
*/

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Modules\Roles\Services\RoleCatalog;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformSetupPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_open_all_setup_pages(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/setup')
            ->assertOk()
            ->assertSee('Setup')
            ->assertSee('Roles &amp; Permissions', false)
            ->assertSee('Notifications')
            ->assertSee('data-setup-landing-tile', false)
            ->assertSee('href="'.url('/platform/setup/notifications').'"', false)
            ->assertDontSee('Staff Setup');

        $this->get('/platform/setup/notifications')
            ->assertOk()
            ->assertSee('Notifications Setup');
    }

    public function test_admin_can_open_current_setup_pages(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->assignRole(RoleCatalog::ADMIN);

        $this->actingAs($user)
            ->get('/platform/setup')
            ->assertOk();

        $this->actingAs($user)
            ->get('/platform/setup/notifications')
            ->assertOk();
    }

    public function test_stale_setup_pages_are_not_registered(): void
    {
        $this->actingAsPlatformSuperAdmin();

        foreach ([
            '/platform/setup/docs',
            '/platform/setup/audit-logs',
            '/platform/setup/error-logs',
            '/platform/setup/users',
        ] as $url) {
            $this->get($url)->assertNotFound();
        }
    }
}
