<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Platform\UiReference\UiReferenceComponentCatalog;
use App\Platform\UiReference\UiReferenceElementCatalog;
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
            ->assertSee('Foundation Elements')
            ->assertSee('Grid')
            ->assertSee('Color')
            ->assertSee('Typography')
            ->assertSee('Form Patterns')
            ->assertSee('Data + Content')
            ->assertSee('T1 Components')
            ->assertSee('Number input')
            ->assertSee('Structured list')
            ->assertSee('Widget Content')
            ->assertSee('Starter Catalog')
            ->assertSee('Archetype Proofs');
    }

    public function test_tier_one_component_catalog_routes_are_discoverable(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $catalog = app(UiReferenceComponentCatalog::class)->primaryPages();

        $overview = $this->get('/platform/ui-reference/components')
            ->assertOk()
            ->assertSee('T1 Component Library')
            ->assertSee('data-ui-reference-component-inventory', false)
            ->assertSee('min-w-[1240px] table-fixed', false)
            ->assertSee('w-[13.5rem]', false)
            ->assertSee('Canonical Doc')
            ->assertSee('inline-flex items-center whitespace-nowrap rounded-full', false);

        foreach ($catalog as $component) {
            $overview
                ->assertSee($component['label'])
                ->assertSee('/platform/ui-reference/components/'.$component['slug'])
                ->assertSee($component['doc_path'])
                ->assertSee($component['disposition']);

            $this->get('/platform/ui-reference/components/'.$component['slug'])
                ->assertOk()
                ->assertSee('data-ui-reference-t1-component="'.$component['slug'].'"', false)
                ->assertSee('data-ui-reference-component-disposition="'.$component['disposition'].'"', false)
                ->assertSee($component['label'])
                ->assertSee($component['owner_route'])
                ->assertSee($component['doc_path'])
                ->assertSee($component['disposition']);
        }

        $this->get('/platform/ui-reference/components/not-a-component')
            ->assertNotFound();
    }

    public function test_foundation_element_catalog_routes_are_discoverable(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $catalog = app(UiReferenceElementCatalog::class)->all();

        $overview = $this->get('/platform/ui-reference/elements')
            ->assertOk()
            ->assertSee('Foundation Elements')
            ->assertSee('data-ui-reference-element-inventory', false)
            ->assertSee('Foundation Elements')
            ->assertSee('T1 Components')
            ->assertSee('T2 Patterns')
            ->assertSee('T3 Feature Modules')
            ->assertSee('Canonical Doc');

        foreach ($catalog as $element) {
            $overview
                ->assertSee($element['label'])
                ->assertSee('/platform/ui-reference/elements/'.$element['slug'])
                ->assertSee($element['doc_path'])
                ->assertSee($element['disposition']);

            $this->get('/platform/ui-reference/elements/'.$element['slug'])
                ->assertOk()
                ->assertSee('data-ui-reference-foundation-element="'.$element['slug'].'"', false)
                ->assertSee('data-ui-reference-element-disposition="'.$element['disposition'].'"', false)
                ->assertSee($element['label'])
                ->assertSee($element['doc_path'])
                ->assertSee($element['carbon_comparison']);
        }

        $this->get('/platform/ui-reference/elements/not-an-element')
            ->assertNotFound();
    }

    public function test_foundation_element_pages_expose_required_examples(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/elements/color')
            ->assertOk()
            ->assertSee('Color Token Namespaces')
            ->assertSee('--ui-text-strong')
            ->assertSee('--ui-action-primary-bg')
            ->assertSee('--ui-status-success-bg')
            ->assertSee('text-primary never means the primary action color')
            ->assertSee('Light mode token sample')
            ->assertSee('Dark mode token sample');

        $this->get('/platform/ui-reference/elements/themes')
            ->assertOk()
            ->assertSee('Theme Token Inheritance')
            ->assertSee('Resolved dark theme')
            ->assertSee('Resolved light theme');

        $this->get('/platform/ui-reference/elements/spacing')
            ->assertOk()
            ->assertSee('Spacing Scale And Ownership')
            ->assertSee('Tailwind-compatible, 8px-centered spacing model')
            ->assertSee('Components own internal padding')
            ->assertSee('Parent layouts own external spacing')
            ->assertSee('Table cell');

        $this->get('/platform/ui-reference/elements/typography')
            ->assertOk()
            ->assertSee('Typography Roles')
            ->assertSee('Page title')
            ->assertSee('Section title')
            ->assertSee('Card title')
            ->assertSee('Table header')
            ->assertSee('Field label')
            ->assertSee('Helper text')
            ->assertSee('Error text')
            ->assertSee('code text');

        $this->get('/platform/ui-reference/elements/icons')
            ->assertOk()
            ->assertSee('Heroicon Usage')
            ->assertSee('16px inline icon')
            ->assertSee('20px action icon')
            ->assertSee('44px touch target')
            ->assertSee('Icon and text center-align')
            ->assertSee('decorative vs semantic');
    }

    public function test_carbon_aligned_tier_one_component_depth_pages_are_documented(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/components/number-input')
            ->assertOk()
            ->assertSee('Default number input')
            ->assertSee('Fluid number input')
            ->assertSee('Stepper controls')
            ->assertSee('min="0"', false)
            ->assertSee('max="4"', false)
            ->assertSee('step="1"', false)
            ->assertSee('Error with inline status icon')
            ->assertSee('Warning with inline status icon')
            ->assertSee('Disabled')
            ->assertSee('Read-only')
            ->assertSee('Focus')
            ->assertSee('Keyboard behavior');

        $this->get('/platform/ui-reference/components/radio-button')
            ->assertOk()
            ->assertSee('Vertical group')
            ->assertSee('Horizontal group')
            ->assertSee('selected')
            ->assertSee('unselected')
            ->assertSee('Error group state')
            ->assertSee('Warning and helper text')
            ->assertSee('Disabled and read-only')
            ->assertSee('single-select only')
            ->assertSee('Use checkbox groups for multi-select choices');

        $this->get('/platform/ui-reference/components/checkbox')
            ->assertOk()
            ->assertSee('Independent choice')
            ->assertSee('Multi-select group')
            ->assertSee('Checked, unchecked, indeterminate')
            ->assertSee('Disabled and read-only')
            ->assertSee('Error and warning')
            ->assertSee('Use radio buttons when exactly one visible option must be selected');

        $this->get('/platform/ui-reference/components/pagination')
            ->assertOk()
            ->assertSee('Full pagination with page-size selector')
            ->assertSee('Compact nav')
            ->assertSee('Overflow')
            ->assertSee('disabled prev/next')
            ->assertSee('Size pairings')
            ->assertSee('below related content');

        $this->get('/platform/ui-reference/components/structured-list')
            ->assertOk()
            ->assertSee('Default structured list')
            ->assertSee('Selectable structured list')
            ->assertSee('Condensed density')
            ->assertSee('Hang alignment')
            ->assertSee('Flush alignment')
            ->assertSee('Selected, focus, disabled, and skeleton states');

        $this->get('/platform/ui-reference/components/tabs')
            ->assertOk()
            ->assertSee('Line tabs')
            ->assertSee('Contained tabs')
            ->assertSee('Vertical tabs')
            ->assertSee('Line tabs with icon')
            ->assertSee('Icon-only line tabs')
            ->assertSee('Overflow / scroll tabs')
            ->assertSee('tab-vs-progress/comparison guidance');

        $this->get('/platform/ui-reference/components/menu')
            ->assertOk()
            ->assertSee('Action items, sizing, and alignment')
            ->assertSee('Current item')
            ->assertSee('Disabled item')
            ->assertSee('Delete workspace')
            ->assertSee('Keyboard and submenu boundary');

        $this->get('/platform/ui-reference/components/ui-shell')
            ->assertOk()
            ->assertSee('UI Shell Disposition')
            ->assertSee('Header content')
            ->assertSee('Left panel')
            ->assertSee('Right panel')
            ->assertSee('T2 navigation and layout surfaces');

        foreach (['ui-shell-header', 'ui-shell-left-panel', 'ui-shell-right-panel'] as $shellAlias) {
            $this->get('/platform/ui-reference/components/'.$shellAlias)
                ->assertOk()
                ->assertSee('data-ui-reference-t1-component="ui-shell"', false)
                ->assertSee('UI Shell Disposition');
        }
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
            ->assertSee('Delete, Archive, Disable, or Remove')
            ->assertSee('data-ui-reference-example="button-variant-contract"', false)
            ->assertSee('data-ui-reference-example="button-state-contract"', false)
            ->assertSee('data-ui-implementation-guide="actions"', false)
            ->assertSee('&lt;x-ui.button semantic=&quot;primary&quot;&gt;Save Workspace&lt;/x-ui.button&gt;', false)
            ->assertSee('&lt;x-ui.button semantic=&quot;notice&quot; variant=&quot;soft&quot;&gt;Queue Review&lt;/x-ui.button&gt;', false)
            ->assertSee('&lt;x-ui.icon-button label=&quot;Open filters&quot;&gt;...&lt;/x-ui.icon-button&gt;', false)
            ->assertSee('x-ui.patterns.dropdown-action-menu')
            ->assertSee('One primary action');

        $this->get('/platform/ui-reference/patterns/navigation')
            ->assertOk()
            ->assertSee('data-ui-guidance="page-action-hierarchy"', false)
            ->assertSee('data-ui-reference-example="t2-action-composition"', false)
            ->assertSee('G-ACT-01')
            ->assertSee('G-LABEL-01')
            ->assertSee('G-LABEL-03')
            ->assertSee('G-LABEL-06')
            ->assertSee('the page title row keeps one primary action')
            ->assertSee('Page-header actions')
            ->assertSee('Filter actions stay on page')
            ->assertSee('Form action bar')
            ->assertSee('Row action overflow');
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
            ->assertSee('workspace-subdomain-warning', false)
            ->assertSee('data-ui-reference-example="form-field-state-contract"', false)
            ->assertSee('data-ui-reference-example="selection-control-contract"', false)
            ->assertSee('data-ui-implementation-guide="forms"', false)
            ->assertSee('T1 Field Reference Matrix')
            ->assertSee('Button file uploader')
            ->assertSee('Searchable select / combo')
            ->assertSee('Queued gap: multi-select component')
            ->assertSee('x-ui.searchable-select')
            ->assertSee('ui-input')
            ->assertSee('ui-switch');

        $this->get('/platform/ui-reference/patterns/forms')
            ->assertOk()
            ->assertSee('data-ui-guidance="form-pattern-usage"', false)
            ->assertSee('data-ui-reference-example="t2-form-composition"', false)
            ->assertSee('P2-F-CQ-010')
            ->assertSee('submit validation belongs in the form-level summary')
            ->assertSee('short exclusive choices stay visible as radio options')
            ->assertSee('Settings-style form section')
            ->assertSee('Compact account/profile form')
            ->assertSee('Validation summary + field error')
            ->assertSee('Form action bar');
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
            ->assertSee('do not adopt Carbon visual tokens')
            ->assertSee('data-ui-reference-example="badge-status-contract"', false)
            ->assertSee('data-ui-implementation-guide="feedback-status"', false)
            ->assertSee('Base semantic badges')
            ->assertSee('Outline + no-icon states')
            ->assertSee('Inline status for dense rows')
            ->assertSee('List context')
            ->assertSee('x-ui.badge')
            ->assertSee('x-ui.status');

        $this->get('/platform/ui-reference/patterns/overlays-feedback')
            ->assertOk()
            ->assertSee('data-ui-guidance="notification-feedback-usage"', false)
            ->assertSee('data-ui-reference-example="feedback-surface-contract"', false)
            ->assertSee('data-ui-reference-example="toast-stacking-contract"', false)
            ->assertSee('data-ui-reference-example="notification-center-handoff"', false)
            ->assertSee('data-ui-implementation-guide="feedback"', false)
            ->assertSee('P2-F-CQ-009')
            ->assertSee('G-NOTIF-01')
            ->assertSee('G-NOTIF-02')
            ->assertSee('G-NOTIF-03')
            ->assertSee('G-NOTIF-04')
            ->assertSee('G-NOTIF-05')
            ->assertSee('Stack toasts from newest to oldest')
            ->assertSee('AJAX feedback should not imply a full page refresh')
            ->assertSee('Persisted notifications belong in the notification center')
            ->assertSee('Form validation feedback')
            ->assertSee('Table/list feedback')
            ->assertSee('Page-level callout/banner')
            ->assertSee('Persisted notification handoff');
    }

    public function test_batch_f_broader_data_navigation_overlay_loading_and_input_guidance_is_documented(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/ui-reference/patterns/tables')
            ->assertOk()
            ->assertSee('data-ui-guidance="table-pagination-usage"', false)
            ->assertSee('data-ui-reference-example="table-pagination-contract"', false)
            ->assertSee('data-ui-implementation-guide="tables-pagination"', false)
            ->assertSee('G-TABLE-01')
            ->assertSee('G-TABLE-02')
            ->assertSee('G-TABLE-03')
            ->assertSee('G-PAGIN-01')
            ->assertSee('G-PAGIN-02')
            ->assertSee('Basic read-only table')
            ->assertSee('Selectable row + overflow action')
            ->assertSee('Table skeleton while loading')
            ->assertSee('Pagination placement');

        $this->get('/platform/ui-reference/patterns/navigation')
            ->assertOk()
            ->assertSee('data-ui-guidance="navigation-search-overflow-usage"', false)
            ->assertSee('data-ui-reference-example="navigation-search-contract"', false)
            ->assertSee('data-ui-implementation-guide="navigation-search-overflow"', false)
            ->assertSee('G-TABS-01')
            ->assertSee('G-TABS-02')
            ->assertSee('G-SEARCH-01')
            ->assertSee('G-SEARCH-02')
            ->assertSee('G-OVERFLOW-01')
            ->assertSee('G-OVERFLOW-02')
            ->assertSee('G-BREADCRUMB-01')
            ->assertSee('G-BREADCRUMB-02')
            ->assertSee('Line tabs for peer sections')
            ->assertSee('Contained tabs for dense panels')
            ->assertSee('Page search + known filters')
            ->assertSee('Breadcrumb with middle overflow');

        $this->get('/platform/ui-reference/patterns/overlays-feedback')
            ->assertOk()
            ->assertSee('data-ui-guidance="overlay-loading-usage"', false)
            ->assertSee('data-ui-reference-example="overlay-loading-contract"', false)
            ->assertSee('data-ui-implementation-guide="overlays-loading"', false)
            ->assertSee('G-MODAL-01')
            ->assertSee('G-MODAL-02')
            ->assertSee('G-MODAL-03')
            ->assertSee('G-TOOLTIP-01')
            ->assertSee('G-TOOLTIP-02')
            ->assertSee('G-LOAD-01')
            ->assertSee('G-LOAD-02')
            ->assertSee('Modal variants')
            ->assertSee('Tooltip vs toggletip')
            ->assertSee('Inline loading')
            ->assertSee('Skeleton loading');

        $this->get('/platform/ui-reference/components/forms')
            ->assertOk()
            ->assertSee('data-ui-guidance="input-file-date-usage"', false)
            ->assertSee('data-ui-reference-example="input-file-date-contract"', false)
            ->assertSee('data-ui-implementation-guide="inputs-file-date"', false)
            ->assertSee('G-INPUT-01')
            ->assertSee('G-INPUT-02')
            ->assertSee('G-FILEUP-01')
            ->assertSee('G-FILEUP-02')
            ->assertSee('G-DATEPICK-01')
            ->assertSee('G-DATEPICK-02')
            ->assertSee('Default width input')
            ->assertSee('Fluid search input')
            ->assertSee('Button file uploader')
            ->assertSee('Date picker family')
            ->assertSee('Queued gap: calendar range control');

        $this->get('/platform/ui-reference/patterns/data-content')
            ->assertOk()
            ->assertSee('data-ui-guidance="structured-list-tile-usage"', false)
            ->assertSee('data-ui-reference-example="structured-list-tile-contract"', false)
            ->assertSee('data-ui-implementation-guide="structured-list-tile"', false)
            ->assertSee('G-STRLIST-01')
            ->assertSee('G-STRLIST-02')
            ->assertSee('G-TILE-01')
            ->assertSee('G-TILE-02')
            ->assertSee('Structured list for compact comparison')
            ->assertSee('Selectable structured list')
            ->assertSee('Tile variants')
            ->assertSee('Queued component gaps');

        $this->get('/platform/ui-reference/patterns/layout')
            ->assertOk()
            ->assertSee('data-ui-guidance="grid-layout-usage"', false)
            ->assertSee('data-ui-reference-example="grid-layout-contract"', false)
            ->assertSee('data-ui-implementation-guide="grid-layout"', false)
            ->assertSee('G-GRID-01')
            ->assertSee('G-GRID-02')
            ->assertSee('Standard page-section grid')
            ->assertSee('Dashboard grid and widget span model');
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
