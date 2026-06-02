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
            ->assertSee('Form Patterns')
            ->assertSee('Data + Content')
            ->assertSee('Archetype Proofs');
    }

    public function test_platform_reviewer_can_view_ui_reference_workspace(): void
    {
        $this->actingAsPlatformReviewer();

        $this->get('/platform/ui-reference')
            ->assertOk()
            ->assertSee('UI Reference Workspace');
    }

    public function test_authorized_users_can_view_tier_one_forms_and_navigation_reference_surfaces(): void
    {
        $this->actingAsPlatformSuperAdmin();
        $this->useActiveBatchReviewIds(['P2-B-CQ-001', 'P2-B-CQ-014', 'P2-B-CQ-017']);

        $this->get('/platform/ui-reference/components/actions')
            ->assertOk()
            ->assertSee('Buttons And Icon Buttons')
            ->assertSee('P2-B-CQ-014')
            ->assertSee('data-ui-component="button"', false)
            ->assertSee('data-ui-component="icon-button"', false);

        $this->get('/platform/ui-reference/components/forms')
            ->assertOk()
            ->assertDontSee('Active Batch Review')
            ->assertSee('Date And Time Selection')
            ->assertDontSee('P2-B-CQ-007')
            ->assertSee('Selectable Controls')
            ->assertSee('Utility Primitives')
            ->assertSee('Lock after 15 minutes')
            ->assertDontSee('data-ui-pattern="proof-review-target"', false);

        $this->get('/platform/ui-reference/patterns/navigation')
            ->assertOk()
            ->assertSee('Sub-navigation Bar')
            ->assertSee('Dropdown Action Menu')
            ->assertSee('Search And Filter Bar')
            ->assertSee('Active Batch Review')
            ->assertSee('P2-B-CQ-014')
            ->assertDontSee('P2-B-CQ-004')
            ->assertDontSee('P2-B-CQ-008')
            ->assertDontSee('P2-B-CQ-010')
            ->assertDontSee('P2-B-CQ-011')
            ->assertDontSee('P2-B-CQ-016')
            ->assertSee('data-ui-pattern="date-range-filter"', false)
            ->assertSee('data-ui-pattern="proof-review-target"', false)
            ->assertSee('Reset / Apply:')
            ->assertSee('data-ui-pattern="page-title-actions-row"', false)
            ->assertSee('data-ui-pattern="sub-navigation-bar"', false)
            ->assertSee('data-ui-pattern="dropdown-action-menu"', false)
            ->assertSee('data-ui-component="inline-alert"', false);

        $this->get('/platform/ui-reference/patterns/forms')
            ->assertOk()
            ->assertSee('Active Batch Review')
            ->assertSee('Validation Summary and Form Actions')
            ->assertSee('Support Email')
            ->assertSee('P2-B-CQ-001')
            ->assertSee('P2-B-CQ-017')
            ->assertDontSee('P2-B-CQ-003')
            ->assertSee('data-ui-phone-input', false)
            ->assertSee('data-ui-component="searchable-select"', false)
            ->assertSee('data-ui-searchable-select-trigger', false)
            ->assertSee('data-ui-pattern="form-section"', false)
            ->assertSee('data-ui-pattern="validation-summary"', false);

        $this->get('/platform/ui-reference/patterns/data-content')
            ->assertOk()
            ->assertSee('Data And Content Patterns')
            ->assertSee('Identity Summary Card')
            ->assertSee('Active Batch Review')
            ->assertSee('P2-B-CQ-014')
            ->assertDontSee('P2-B-CQ-003')
            ->assertDontSee('P2-B-CQ-011')
            ->assertDontSee('P2-B-CQ-016')
            ->assertDontSee('P2-B-CQ-009')
            ->assertDontSee('P2-B-CQ-012')
            ->assertSee('data-ui-pattern="identity-summary-card"', false)
            ->assertSee('data-ui-pattern="stat-card"', false)
            ->assertSee('Support Runbook')
            ->assertSee('<a href="#" class="ui-link"', false)
            ->assertSee('data-ui-pattern="empty-state"', false)
            ->assertSee('Para Solutions')
            ->assertSee('Identity-summary variants');

        $this->get('/platform/ui-reference/patterns/layout')
            ->assertOk()
            ->assertSee('Layout And Dashboard Patterns')
            ->assertDontSee('Active Batch Review')
            ->assertDontSee('P2-B-CQ-006')
            ->assertSee('Widget sizing contract')
            ->assertSee('data-ui-pattern="widget-shell"', false)
            ->assertSee('data-ui-pattern="dashboard-grid"', false)
            ->assertSee('data-ui-pattern="content-section-block"', false);

        $this->get('/platform/ui-reference/patterns/archetypes')
            ->assertOk()
            ->assertSee('Archetype Proofs')
            ->assertDontSee('Active Batch Review')
            ->assertDontSee('P2-B-CQ-006')
            ->assertDontSee('P2-B-CQ-008')
            ->assertSee('Apply range')
            ->assertSee('Create / Edit Form')
            ->assertSee('Settings')
            ->assertSee('Account / Profile');

        $this->get('/platform/ui-reference/patterns/tables?workspace_sort=policy_count&workspace_direction=desc&audit_sort=event_type&audit_direction=asc&error_sort=message&error_direction=asc')
            ->assertOk()
            ->assertSee('Enhanced Data Table')
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
            ->assertSee('data-ui-component="inline-alert"', false)
            ->assertSee('data-ui-component="toast"', false)
            ->assertSee('data-ui-component="drawer"', false)
            ->assertSee('data-ui-component="modal"', false)
            ->assertSee('data-ui-demo-toast-generated-stack', false)
            ->assertSee('data-ui-demo-toast-generated-overlay', false);
    }

    public function test_layout_reference_surface_includes_dashboard_customization_proof(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/patterns/layout')
            ->assertOk()
            ->assertSee('Dashboard customization proof')
            ->assertSee('Saved per-user layout')
            ->assertSee('Customize proof')
            ->assertSee('Hidden widget tray')
            ->assertSee('Saved layout preview')
            ->assertSee('Watch the insertion line and swap target before dropping.')
            ->assertSee('data-dashboard-proof-demo', false)
            ->assertSee('data-dashboard-proof-main-content', false)
            ->assertSee('data-dashboard-proof-support', false)
            ->assertSee('data-dashboard-proof-widget-card', false)
            ->assertSee('data-dashboard-reorder-surface', false)
            ->assertSee('data-dashboard-proof-saved-layout', false)
            ->assertSee('data-ui-soft-card="saved-layout-preview"', false)
            ->assertSee('data-ui-soft-card-tone="neutral"', false)
            ->assertSee('Header content')
            ->assertSee('Body content')
            ->assertSee('dashboard-proof-grid', false)
            ->assertSee('ui-soft-card-neutral', false)
            ->assertDontSee('ui-soft-card-success', false)
            ->assertDontSee('ui-soft-card-notice', false)
            ->assertDontSee('ui-soft-card-danger', false)
            ->assertSee('ui-soft-card-link', false)
            ->assertSee('ui-soft-card-action', false)
            ->assertSee('data-dashboard-proof-widget', false);

        $proofScript = file_get_contents(resource_path('js/dashboard-proof-demo.js'));

        $this->assertIsString($proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-1x2', $proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-2x2', $proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-3x2', $proofScript);
        $this->assertStringNotContainsString("tone: 'success'", $proofScript);
        $this->assertStringNotContainsString("tone: 'notice'", $proofScript);
        $this->assertStringNotContainsString("tone: 'danger'", $proofScript);
    }

    public function test_layout_reference_surface_includes_multi_row_widget_span_proof(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/patterns/layout')
            ->assertOk()
            ->assertSee('Multi-row span proof')
            ->assertSee('1x2 Tall List')
            ->assertSee('2x2 Mixed Widget')
            ->assertSee('3x2 Review Surface')
            ->assertSee('Full width + two rows')
            ->assertSee('data-dashboard-span-proof', false)
            ->assertSee('data-ui-widget-span="1x2"', false)
            ->assertSee('data-ui-widget-span="2x2"', false)
            ->assertSee('data-ui-widget-span="3x2"', false)
            ->assertSee('md:auto-rows-[minmax(11rem,auto)]', false);

        $css = file_get_contents(resource_path('css/app.css'));

        $this->assertIsString($css);
        $this->assertStringContainsString('.dashboard-proof-widget-span-1x2', $css);
        $this->assertStringContainsString('.ui-pattern-widget-span-1x2', $css);
        $this->assertStringContainsString('min-height: calc(22rem + 1rem)', $css);
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
