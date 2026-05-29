<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class PlatformUiReferenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_users_can_view_ui_reference_workspace(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference')
            ->assertOk()
            ->assertSee('UI Reference Workspace')
            ->assertSee('ui-card', false)
            ->assertSee('Components / Actions')
            ->assertSee('Patterns / Tables')
            ->assertSee('Patterns / Navigation');
    }

    public function test_authorized_users_can_view_tier_one_forms_and_navigation_reference_surfaces(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/forms')
            ->assertOk()
            ->assertSee('Selectable Controls')
            ->assertSee('Utility Primitives')
            ->assertSee('Lock after 15 minutes');

        $this->get('/platform/ui-reference/patterns/navigation')
            ->assertOk()
            ->assertSee('Layout And Scaffolding')
            ->assertSee('Grid Baseline');

        $this->get('/platform/ui-reference/patterns/tables?workspace_sort=policy_count&workspace_direction=desc&audit_sort=event_type&audit_direction=asc&error_sort=message&error_direction=asc')
            ->assertOk()
            ->assertSee('Policies')
            ->assertSee('Settings')
            ->assertSee('Export')
            ->assertSee('ui-table-sort-icon', false)
            ->assertDontSee('ui-table-sort-state', false)
            ->assertSee('Sorted descending. Activate to sort ascending.')
            ->assertSee('Sorted ascending. Activate to sort descending.')
            ->assertSee('aria-sort="descending"', false)
            ->assertSee('aria-sort="ascending"', false);

        $this->get('/platform/ui-reference/patterns/overlays-feedback')
            ->assertOk()
            ->assertSee('Toast Baseline')
            ->assertSee('Generate Example Toast')
            ->assertSee('data-ui-demo-toast-generated-stack', false)
            ->assertSee('data-ui-demo-toast-generated-overlay', false);
    }

    public function test_standard_users_cannot_view_ui_reference_workspace(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/platform/ui-reference')
            ->assertForbidden();
    }

    public function test_non_super_admin_users_with_docs_permission_still_cannot_view_ui_reference_workspace(): void
    {
        $user = User::factory()->create();

        $this->seed(PlatformRolesAndPermissionsSeeder::class);
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permission = Permission::findByName('platform.docs.view', 'web');
        $user->givePermissionTo($permission);

        $this->actingAs($user)
            ->get('/platform/ui-reference')
            ->assertForbidden();
    }

    public function test_authorized_users_can_load_audit_sample_payload(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->getJson('/platform/ui-reference/audit-logs/user-update')
            ->assertOk()
            ->assertJsonPath('event_type', 'platform.user.updated')
            ->assertJsonPath('result', 'success')
            ->assertJsonPath('route', 'platform.users.update');
    }

    public function test_authorized_users_can_load_error_sample_payload(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->getJson('/platform/ui-reference/error-logs/queue-timeout')
            ->assertOk()
            ->assertJsonPath('exception_class', 'RuntimeException')
            ->assertJsonPath('severity', 'error')
            ->assertJsonPath('route', 'queue:work');
    }

    public function test_unknown_demo_samples_return_not_found(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/audit-logs/not-real')->assertNotFound();
        $this->get('/platform/ui-reference/error-logs/not-real')->assertNotFound();
    }
}
