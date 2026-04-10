<?php

namespace Tests\Feature\Platform;

use App\Platform\Settings\SettingsService;
use App\Models\User;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocsRepositoryViewerTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_open_the_docs_repository_viewer(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/docs')
            ->assertOk()
            ->assertSee('Documentation Vault')
            ->assertSee('Repository Tree');
    }

    public function test_super_admin_can_view_a_docs_file(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/docs?path=V2%20App/Planning/V2%20Feature%20Roadmap.md')
            ->assertOk()
            ->assertSee('V2 Feature Roadmap')
            ->assertSee('Phase 1');
    }

    public function test_standard_users_cannot_access_the_docs_repository_viewer(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/platform/docs')
            ->assertForbidden();
    }

    public function test_platform_admin_can_access_docs_when_scope_allows_platform_users(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('platform_admin');

        app(SettingsService::class)->put('docs', 'access_scope', 'all_platform_users', updatedBy: $user->id);

        $this->actingAs($user)
            ->get('/platform/docs')
            ->assertOk();
    }

    public function test_platform_admin_cannot_access_docs_when_scope_is_super_admin_only(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->assignRole('platform_admin');

        app(SettingsService::class)->put('docs', 'access_scope', 'super_admins_only', updatedBy: $user->id);

        $this->actingAs($user)
            ->get('/platform/docs')
            ->assertForbidden();
    }
}
