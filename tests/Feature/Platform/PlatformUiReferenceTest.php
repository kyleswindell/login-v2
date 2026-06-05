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
            ->assertSee('Widget Content')
            ->assertSee('Starter Catalog')
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
            ->assertSee('Dashboard customization proof')
            ->assertSee('Dashboard support boundaries')
            ->assertSee('Content allowances moved')
            ->assertSee('Open widget standards')
            ->assertDontSee('Widget sizing contract')
            ->assertDontSee('Multi-row span proof')
            ->assertSee('data-dashboard-proof-demo', false)
            ->assertSee('data-dashboard-proof-support', false)
            ->assertSee('data-ui-pattern="content-section-block"', false);

        $this->get('/platform/ui-reference/patterns/widget-content')
            ->assertOk()
            ->assertSee('Widget Content Standards')
            ->assertSee('Geometry decision')
            ->assertSee('Content-space unit system')
            ->assertSee('data-widget-content-unit-system', false)
            ->assertSee('data-widget-size-navigation', false)
            ->assertSee('data-ui-pattern="dashboard-grid"', false)
            ->assertSee('data-ui-pattern="widget-shell"', false);

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

    public function test_batch_f_button_variant_and_action_label_guidance_is_documented(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/actions')
            ->assertOk()
            ->assertSee('data-ui-guidance="action-usage"', false)
            ->assertSee('data-guidance-id="P2-F-CQ-008"', false)
            ->assertSee('G-ACT-01')
            ->assertSee('G-ACT-02')
            ->assertSee('G-ACT-03')
            ->assertSee('G-ACT-04')
            ->assertSee('G-ACT-05')
            ->assertSee('standard filled treatment')
            ->assertSee('soft')
            ->assertSee('ghost')
            ->assertSee('outline')
            ->assertSee('danger semantic')
            ->assertSee('G-LABEL-01')
            ->assertSee('G-LABEL-06')
            ->assertSee('Apply when the user stays on the same page')
            ->assertSee('Delete, Archive, Disable, or Remove');

        $this->get('/platform/ui-reference/patterns/navigation')
            ->assertOk()
            ->assertSee('data-ui-guidance="page-action-hierarchy"', false)
            ->assertSee('G-ACT-01')
            ->assertSee('G-LABEL-01')
            ->assertSee('G-LABEL-03')
            ->assertSee('G-LABEL-06')
            ->assertSee('the page title row keeps one primary action');
    }

    public function test_batch_f_form_field_and_selection_control_guidance_is_documented(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/forms')
            ->assertOk()
            ->assertSee('data-ui-guidance="form-field-standards"', false)
            ->assertSee('data-guidance-id="P2-F-CQ-010"', false)
            ->assertSee('G-FORM-01')
            ->assertSee('G-FORM-02')
            ->assertSee('G-FORM-03')
            ->assertSee('G-FORM-04')
            ->assertSee('error, warning, disabled, read-only, and focused states')
            ->assertSee('data-ui-guidance="selection-control-usage"', false)
            ->assertSee('G-SEL-01')
            ->assertSee('G-SEL-02')
            ->assertSee('G-SEL-03')
            ->assertSee('Select / combo box / multi-select')
            ->assertSee('Example Warning Field')
            ->assertSee('workspace-subdomain-warning', false);

        $this->get('/platform/ui-reference/patterns/forms')
            ->assertOk()
            ->assertSee('data-ui-guidance="form-pattern-usage"', false)
            ->assertSee('P2-F-CQ-010')
            ->assertSee('submit validation belongs in the form-level summary')
            ->assertSee('short exclusive choices stay visible as radio options');
    }

    public function test_batch_f_notification_badge_and_feedback_guidance_is_documented(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/status')
            ->assertOk()
            ->assertSee('data-ui-guidance="badge-feedback-semantics"', false)
            ->assertSee('data-guidance-id="P2-F-CQ-009"', false)
            ->assertSee('G-BADGE-01')
            ->assertSee('G-BADGE-02')
            ->assertSee('G-BADGE-03')
            ->assertSee('G-BADGE-04')
            ->assertSee('text-first')
            ->assertSee('do not adopt Carbon visual tokens');

        $this->get('/platform/ui-reference/patterns/overlays-feedback')
            ->assertOk()
            ->assertSee('data-ui-guidance="notification-feedback-usage"', false)
            ->assertSee('P2-F-CQ-009')
            ->assertSee('G-NOTIF-01')
            ->assertSee('G-NOTIF-02')
            ->assertSee('G-NOTIF-03')
            ->assertSee('G-NOTIF-04')
            ->assertSee('G-NOTIF-05')
            ->assertSee('Stack toasts from newest to oldest')
            ->assertSee('AJAX feedback should not imply a full page refresh')
            ->assertSee('Persisted notifications belong in the notification center');
    }

    public function test_batch_f_broader_data_navigation_overlay_loading_and_input_guidance_is_documented(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/patterns/tables')
            ->assertOk()
            ->assertSee('data-ui-guidance="table-pagination-usage"', false)
            ->assertSee('G-TABLE-01')
            ->assertSee('G-TABLE-02')
            ->assertSee('G-TABLE-03')
            ->assertSee('G-PAGIN-01')
            ->assertSee('G-PAGIN-02');

        $this->get('/platform/ui-reference/patterns/navigation')
            ->assertOk()
            ->assertSee('data-ui-guidance="navigation-search-overflow-usage"', false)
            ->assertSee('G-TABS-01')
            ->assertSee('G-TABS-02')
            ->assertSee('G-SEARCH-01')
            ->assertSee('G-SEARCH-02')
            ->assertSee('G-OVERFLOW-01')
            ->assertSee('G-OVERFLOW-02')
            ->assertSee('G-BREADCRUMB-01')
            ->assertSee('G-BREADCRUMB-02');

        $this->get('/platform/ui-reference/patterns/overlays-feedback')
            ->assertOk()
            ->assertSee('data-ui-guidance="overlay-loading-usage"', false)
            ->assertSee('G-MODAL-01')
            ->assertSee('G-MODAL-02')
            ->assertSee('G-MODAL-03')
            ->assertSee('G-TOOLTIP-01')
            ->assertSee('G-TOOLTIP-02')
            ->assertSee('G-LOAD-01')
            ->assertSee('G-LOAD-02');

        $this->get('/platform/ui-reference/components/forms')
            ->assertOk()
            ->assertSee('data-ui-guidance="input-file-date-usage"', false)
            ->assertSee('G-INPUT-01')
            ->assertSee('G-INPUT-02')
            ->assertSee('G-FILEUP-01')
            ->assertSee('G-FILEUP-02')
            ->assertSee('G-DATEPICK-01')
            ->assertSee('G-DATEPICK-02');

        $this->get('/platform/ui-reference/patterns/data-content')
            ->assertOk()
            ->assertSee('data-ui-guidance="structured-list-tile-usage"', false)
            ->assertSee('G-STRLIST-01')
            ->assertSee('G-STRLIST-02')
            ->assertSee('G-TILE-01')
            ->assertSee('G-TILE-02');

        $this->get('/platform/ui-reference/patterns/layout')
            ->assertOk()
            ->assertSee('data-ui-guidance="grid-layout-usage"', false)
            ->assertSee('G-GRID-01')
            ->assertSee('G-GRID-02');
    }

    public function test_starter_catalog_route_is_discoverable_and_maps_batch_f_starters(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/patterns/starters')
            ->assertOk()
            ->assertSee('Starter Catalog')
            ->assertSee('P2-F-CQ-007')
            ->assertSee('Module Home / Module Overview')
            ->assertSee('Settings Page')
            ->assertSee('Account / Profile Editable')
            ->assertSee('Content Browser / Split View')
            ->assertSee('Blocked / Empty / Unavailable')
            ->assertSee('UI Reference Route Disposition Matrix')
            ->assertSee('data-ui-reference-starter-catalog', false)
            ->assertSee('data-route-disposition-matrix', false)
            ->assertSee('data-starter-route="/platform/ui-reference/patterns/starters/module-home"', false)
            ->assertSee('/platform/ui-reference/patterns/starters/empty-unavailable')
            ->assertSee('/platform/ui-reference/patterns/widget-content/{size}')
            ->assertSee('P2-F-CQ-002')
            ->assertSee('P2-F-CQ-003')
            ->assertSee('P2-F-CQ-004')
            ->assertSee('P2-F-CQ-005')
            ->assertSee('Keep and extend')
            ->assertSee('Add');
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
            ->assertSee('data-dashboard-proof-saved-layout-card', false)
            ->assertSee('x-bind:data-dashboard-proof-widget-span="widget.span"', false)
            ->assertSee('Header content')
            ->assertSee('Body content')
            ->assertSee('dashboard-proof-grid', false)
            ->assertSee('ui-pattern-widget-shell', false)
            ->assertDontSee('ui-soft-card', false)
            ->assertDontSee('ui-soft-card-neutral', false)
            ->assertDontSee('ui-soft-card-success', false)
            ->assertDontSee('ui-soft-card-notice', false)
            ->assertDontSee('ui-soft-card-danger', false)
            ->assertSee('data-dashboard-proof-widget', false);

        $proofScript = file_get_contents(resource_path('js/dashboard-proof-demo.js'));

        $this->assertIsString($proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-1x2', $proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-2x1', $proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-2x2', $proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-3x1', $proofScript);
        $this->assertStringContainsString('dashboard-proof-widget-span-3x2', $proofScript);
        $this->assertStringContainsString('ui-reference.dashboard-proof-layout.v2', $proofScript);
        $this->assertStringNotContainsString("tone: 'success'", $proofScript);
        $this->assertStringNotContainsString("tone: 'notice'", $proofScript);
        $this->assertStringNotContainsString("tone: 'danger'", $proofScript);
        $this->assertStringNotContainsString('ui-soft-card', $proofScript);
    }

    public function test_widget_content_reference_surface_includes_size_aware_allowances(): void
    {
        $this->actingAsPlatformSuperAdmin();
        $this->useActiveBatchReviewIds(['P2-B-CQ-023']);

        $this->get('/platform/ui-reference/patterns/widget-content')
            ->assertOk()
            ->assertSee('Active Batch Review')
            ->assertSee('P2-B-CQ-023')
            ->assertSee('Widget Content Standards')
            ->assertSee('Geometry decision')
            ->assertSee('Four-unit dashboard model')
            ->assertSee('18rem one-row baseline')
            ->assertSee('No implicit 3x full row')
            ->assertSee('Viewport review baseline')
            ->assertSee('1024px')
            ->assertSee('1280px')
            ->assertSee('1366px')
            ->assertSee('1440px')
            ->assertSee('1920px')
            ->assertSee('Content-space unit system')
            ->assertSee('Pixel budget')
            ->assertSee('Size-standard pages')
            ->assertSee('data-widget-geometry-decision', false)
            ->assertSee('data-widget-viewport-baseline', false)
            ->assertSee('data-widget-content-unit-system', false)
            ->assertSee('data-widget-px-budget', false)
            ->assertSee('data-widget-size-navigation', false)
            ->assertSee('data-widget-size-nav-item="shape-map"', false)
            ->assertSee('data-widget-size-nav-item="3x3"', false)
            ->assertDontSee('Filled widget size examples')
            ->assertDontSee('Allowance matrix')
            ->assertDontSee('Negative boundary')
            ->assertDontSee('3x1 Full Row')
            ->assertDontSee('3x2 Tall Surface')
            ->assertDontSee('md:auto-rows-[minmax(11rem,auto)]', false);

        $css = file_get_contents(resource_path('css/app.css'));
        $dashboardGrid = file_get_contents(resource_path('views/components/ui/patterns/dashboard-grid.blade.php'));

        $this->assertIsString($css);
        $this->assertIsString($dashboardGrid);
        $this->assertStringContainsString("xl:grid-cols-4", $dashboardGrid);
        $this->assertStringNotContainsString("xl:grid-cols-6", $dashboardGrid);
        $this->assertStringContainsString('--ui-dashboard-grid-row-size: 18rem', $css);
        $this->assertStringContainsString('--ui-dashboard-grid-row-size: 24rem', $css);
        $this->assertStringContainsString('grid-auto-rows: var(--ui-dashboard-grid-row-size)', $css);
        $this->assertStringContainsString('.dashboard-proof-widget-span-1x2', $css);
        $this->assertStringContainsString('.ui-pattern-widget-span-1x2', $css);
        $this->assertStringContainsString('block-size: calc((var(--ui-dashboard-grid-row-size) * 2) + var(--ui-dashboard-grid-gap))', $css);
        $this->assertStringContainsString('block-size: var(--ui-dashboard-grid-row-size)', $css);
        $this->assertStringContainsString('.ui-pattern-widget-span-3x3', $css);
        $this->assertStringNotContainsString('grid-auto-rows: minmax(11rem, auto)', $css);
    }

    public function test_widget_content_size_pages_are_accessible(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $sizes = ['shape-map', '1x1', '2x1', '1x2', '2x2', '3x1', '3x2', '3x3', '4x0-5'];

        foreach ($sizes as $size) {
            $response = $this->get('/platform/ui-reference/patterns/widget-content/'.$size);
            $response->assertOk();

            if ($size === 'shape-map') {
                $response->assertSee('data-widget-shape-map', false);
                $response->assertSee('data-widget-composition-matrix', false);
            } else {
                $response->assertSee('data-widget-size-page="'.$size.'"', false);
                $response->assertSee('data-widget-size-module-scaffold="'.$size.'"', false);
            }
        }

        $this->get('/platform/ui-reference/patterns/widget-content/invalid-size')
            ->assertNotFound();

        $css = file_get_contents(resource_path('css/app.css'));
        $this->assertStringContainsString('.ui-pattern-widget-span-3x3', $css);
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
