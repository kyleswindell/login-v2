<?php

declare(strict_types=1);

namespace App\Modules\ProfileMfgPoc\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

final class ProfileMfgPocTest extends TestCase
{
    use RefreshDatabase;

    private string $fixturePath;

    private string $temporaryDirectory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixturePath = base_path('Modules/ProfileMfgPoc/tests/Fixtures/profile-mfg-poc.json');
        $this->temporaryDirectory = storage_path('framework/testing/profile-mfg-poc');

        File::ensureDirectoryExists($this->temporaryDirectory);
        File::put(
            $this->temporaryDirectory.'/PART-001.png',
            base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=', true),
        );
        config()->set('profile-mfg-poc.enabled', true);
        config()->set('profile-mfg-poc.data_path', $this->fixturePath);
        config()->set('profile-mfg-poc.media_path', $this->temporaryDirectory);
    }

    protected function tearDown(): void
    {
        File::deleteDirectory($this->temporaryDirectory);

        parent::tearDown();
    }

    public function test_disabled_poc_preserves_the_existing_dashboard_and_hides_poc_routes(): void
    {
        config()->set('profile-mfg-poc.enabled', false);
        $this->actingAsPlatformSuperAdmin();

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Your workspace dashboard is ready for the next module-owned rebuild.');

        $this->get('/profile-mfg')->assertNotFound();
    }

    public function test_enabled_poc_routes_require_authentication(): void
    {
        foreach ([
            '/profile-mfg',
            '/profile-mfg/shipping-schedule',
            '/profile-mfg/customers',
            '/profile-mfg/customers/CUST-001',
            '/profile-mfg/parts',
            '/profile-mfg/parts/PART-001',
            '/profile-mfg/orders',
            '/profile-mfg/orders/ORD-1001',
            '/profile-mfg/inventory',
            '/profile-mfg/scanning',
            '/profile-mfg/reports',
            '/profile-mfg/settings',
            '/profile-mfg/parts/PART-001/image',
        ] as $url) {
            $this->get($url)->assertRedirect('/login');
        }
    }

    public function test_enabled_poc_replaces_the_authenticated_dashboard_entry(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/dashboard')->assertRedirect('/profile-mfg');

        $this->get('/profile-mfg')
            ->assertOk()
            ->assertSee('Operations dashboard')
            ->assertSee('Operations workspace')
            ->assertSee('Static proof of concept')
            ->assertSee('Data snapshot: Aug 12, 2026');
    }

    public function test_all_poc_pages_render_consistent_record_links(): void
    {
        $this->actingAs(User::factory()->create());

        foreach ([
            '/profile-mfg',
            '/profile-mfg/shipping-schedule',
            '/profile-mfg/customers',
            '/profile-mfg/customers/CUST-001',
            '/profile-mfg/parts',
            '/profile-mfg/parts/PART-002',
            '/profile-mfg/orders',
            '/profile-mfg/orders/ORD-1002',
            '/profile-mfg/inventory',
            '/profile-mfg/scanning',
            '/profile-mfg/reports',
            '/profile-mfg/settings',
        ] as $url) {
            $this->get($url)
                ->assertOk()
                ->assertSee('Static proof of concept')
                ->assertSee('Data snapshot: Aug 12, 2026')
                ->assertSee('Record-changing actions are unavailable.');
        }

        $this->get('/profile-mfg/customers')
            ->assertSee('Customers')
            ->assertSee('Northstar Automotive')
            ->assertSee('/profile-mfg/customers/CUST-001', false);

        $this->get('/profile-mfg/customers/CUST-001')
            ->assertSee('Northstar Automotive')
            ->assertSee('Deliver to receiving door 4')
            ->assertSee('PMI-01001')
            ->assertSee('ORD-1001')
            ->assertSee('/profile-mfg/orders/ORD-1001', false);

        $this->get('/profile-mfg/parts')
            ->assertSee('Parts')
            ->assertSee('PMI-01002')
            ->assertSee('/profile-mfg/parts/PART-002', false);

        $this->get('/profile-mfg/parts/PART-002')
            ->assertSee('Rear channel assembly')
            ->assertSee('Northstar Automotive')
            ->assertSee('Inventory review before shipping')
            ->assertSee('Serialized finished goods')
            ->assertSee('50')
            ->assertSee('/profile-mfg/orders/ORD-1002', false);

        $this->get('/profile-mfg/orders')
            ->assertSee('Orders')
            ->assertSee('ORD-1001')
            ->assertSee('/profile-mfg/orders/ORD-1001', false)
            ->assertSee('/profile-mfg/customers/CUST-001', false)
            ->assertSee('/profile-mfg/parts/PART-001', false);

        $this->get('/profile-mfg/orders/ORD-1002')
            ->assertSee('ORD-1002')
            ->assertSee('Northstar Automotive')
            ->assertSee('PMI-01002')
            ->assertSee('Partial inventory available.')
            ->assertSee('Containers required')
            ->assertSee('Customer PO')
            ->assertSee('PO-88421');

        $this->get('/profile-mfg/inventory')
            ->assertSee('Finished-goods inventory')
            ->assertSee('Serialized boxes')
            ->assertSee('System balance')
            ->assertSee('/profile-mfg/parts/PART-002', false);

        $this->get('/profile-mfg/scanning')
            ->assertSee('Scan activity')
            ->assertSee('01581')
            ->assertSee('/profile-mfg/parts/PART-001', false);

        $this->get('/profile-mfg/reports')
            ->assertSee('Reports')
            ->assertSee('Daily and weekly shipping schedule')
            ->assertSee('Finished-goods totals')
            ->assertSee('Inventory scanned');

        $this->get('/profile-mfg/settings')
            ->assertSee('Application settings')
            ->assertSee('Default landing page')
            ->assertSee('Inventory readiness signal');
    }

    public function test_dashboard_metrics_are_derived_from_the_snapshot(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/profile-mfg')
            ->assertOk()
            ->assertSeeInOrder(['Open demand', '805'])
            ->assertSeeInOrder(['Past due', '80'])
            ->assertSeeInOrder(['Ship today', '60'])
            ->assertSeeInOrder(['Inventory checks', '3'])
            ->assertSee('Shipping requirements for today')
            ->assertSee('ORD-1004')
            ->assertSee('Open order priorities')
            ->assertSee('Scan activity today')
            ->assertSeeInOrder(['Scanned in', '5 boxes'])
            ->assertSeeInOrder(['Exceptions', '1']);

        $this->get('/profile-mfg/shipping-schedule')
            ->assertOk()
            ->assertSeeInOrder(['Past due', '80'])
            ->assertSeeInOrder(['Ship today', '60'])
            ->assertSeeInOrder(['Rest of this week', '200'])
            ->assertSeeInOrder(['Next week', '200'])
            ->assertSee('Two-week shipping schedule')
            ->assertSee('Wed')
            ->assertSee('Aug 12')
            ->assertSee('NS-4410')
            ->assertSee('Inventory checks before shipping')
            ->assertSee('Verify balances');

        $this->get('/profile-mfg/customers/CUST-001')
            ->assertOk()
            ->assertSeeInOrder(['Open orders', '5'])
            ->assertSeeInOrder(['Past due', '80'])
            ->assertSeeInOrder(['Two-week demand', '260'])
            ->assertSeeInOrder(['ORD-1001', '80'])
            ->assertSeeInOrder(['ORD-1002', '120']);

        $this->get('/profile-mfg/parts/PART-002')
            ->assertOk()
            ->assertSeeInOrder(['System part balance', '50'])
            ->assertSeeInOrder(['Serialized finished goods', '1 box'])
            ->assertSeeInOrder(['Two-week demand', '120'])
            ->assertSeeInOrder(['ORD-1002', '120']);

        $this->get('/profile-mfg/orders/ORD-1002')
            ->assertOk()
            ->assertSeeInOrder(['Ordered', '150'])
            ->assertSeeInOrder(['Recorded shipped', '30'])
            ->assertSeeInOrder(['Remaining', '120'])
            ->assertSeeInOrder(['Full boxes', '2'])
            ->assertSeeInOrder(['Loose pieces', '20'])
            ->assertSeeInOrder(['Containers required', '3'])
            ->assertSee('Due this week');

        $this->get('/profile-mfg/orders/ORD-1001')
            ->assertOk()
            ->assertSee('Past due');

        $this->get('/profile-mfg/inventory')
            ->assertOk()
            ->assertSeeInOrder(['Two-week demand', '540'])
            ->assertSeeInOrder(['Serialized finished goods', '11 boxes'])
            ->assertSeeInOrder(['System part balance', '640'])
            ->assertSeeInOrder(['Needs review', '3 parts'])
            ->assertSee('Verify balances')
            ->assertSee('Short');

        $this->get('/profile-mfg/scanning')
            ->assertOk()
            ->assertSeeInOrder(['Scanned in today', '5 boxes'])
            ->assertSeeInOrder(['Pieces received', '380'])
            ->assertSeeInOrder(['Scanned out today', '1 box'])
            ->assertSeeInOrder(['Exceptions', '1'])
            ->assertSee('Duplicate serial number');
    }

    public function test_part_images_are_served_from_private_media_without_exposing_paths(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/profile-mfg/parts/PART-001/image');

        $response
            ->assertOk()
            ->assertHeader('content-type', 'image/png')
            ->assertDontSee($this->temporaryDirectory);

        $this->get('/profile-mfg/parts/PART-002/image')->assertNotFound();
        $this->get('/profile-mfg/parts/missing/image')->assertNotFound();

        $this->get('/profile-mfg/parts/PART-001')
            ->assertOk()
            ->assertSee('Part image')
            ->assertSee('/profile-mfg/parts/PART-001/image', false)
            ->assertDontSee($this->temporaryDirectory);
    }

    public function test_sidebar_exposes_account_destinations_and_disables_deprecated_employee_access(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/profile-mfg')
            ->assertOk()
            ->assertSee('My profile')
            ->assertSee(route('platform.account.index'), false)
            ->assertSee('Preferences')
            ->assertSee(route('platform.account.preferences'), false)
            ->assertSee('Employees and access — Future preview')
            ->assertDontSee(route('platform.users.index'), false)
            ->assertSee('Application settings')
            ->assertSee(route('profile-mfg.settings.index'), false);
    }

    public function test_dashboard_exposes_daily_actions_workspace_preview_and_demo_notification(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $response = $this->get('/profile-mfg')
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee(route('profile-mfg.dashboard'), false)
            ->assertSee('Shipping schedule')
            ->assertSee(route('profile-mfg.shipping-schedule'), false)
            ->assertSee('Start new scan — Coming soon')
            ->assertSee('Edit dashboard — Coming soon')
            ->assertSee('Generate example notification')
            ->assertSee(route('dashboard.test-notification'), false)
            ->assertSee('data-dashboard-test-notification-form', false)
            ->assertSeeInOrder([
                'Operations',
                'Accounting · Preview',
                'Sales · Preview',
                'Administration · Preview',
                'Setup',
            ])
            ->assertSee('aria-current="true"', false)
            ->assertSee('aria-disabled="true"', false)
            ->assertDontSee('Current workspace')
            ->assertSee('Visualization coming soon')
            ->assertSee('data-dashboard-widget="open-order-priorities"', false)
            ->assertSee('data-dashboard-widget="inventory-attention"', false)
            ->assertSee('data-dashboard-widget="scan-activity"', false)
            ->assertSee('data-dashboard-widget="shipping-demand-trend"', false)
            ->assertSee('data-ui-component="data-table"', false);

        $this->assertSame(
            4,
            substr_count((string) $response->getContent(), 'data-ui-tile-variant="clickable"'),
        );
    }

    public function test_dashboard_uses_the_next_shipping_date_when_snapshot_day_has_no_requirements(): void
    {
        $this->actingAs(User::factory()->create());

        $dataset = json_decode((string) File::get($this->fixturePath), true, flags: JSON_THROW_ON_ERROR);
        $dataset['snapshot_date'] = '2026-08-15';

        $nextShippingPath = $this->temporaryDirectory.'/next-shipping.json';
        File::put($nextShippingPath, json_encode($dataset, JSON_THROW_ON_ERROR));
        config()->set('profile-mfg-poc.data_path', $nextShippingPath);

        $this->get('/profile-mfg')
            ->assertOk()
            ->assertSee('Next shipping requirements · Aug 17, 2026')
            ->assertSee('No open requirements are due on Aug 15, 2026. Showing the next scheduled shipping date.')
            ->assertSee('ORD-1010')
            ->assertDontSee('No open orders are due on the snapshot date.');
    }

    public function test_poc_directory_tables_use_the_full_width_data_table_contract(): void
    {
        $this->actingAs(User::factory()->create());

        foreach (['parts', 'scanning'] as $directory) {
            $this->get('/profile-mfg/'.$directory)
                ->assertOk()
                ->assertSee('data-ui-component="data-table"', false)
                ->assertDontSee('ui-data-table--static', false)
                ->assertDontSee('ui-data-table-static', false);
        }
    }

    public function test_unknown_customer_part_and_order_identifiers_return_not_found(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/profile-mfg/customers/missing')->assertNotFound();
        $this->get('/profile-mfg/parts/missing')->assertNotFound();
        $this->get('/profile-mfg/orders/missing')->assertNotFound();
        $this->get('/profile-mfg/parts/missing/image')->assertNotFound();
    }

    public function test_poc_exposes_no_write_routes(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post('/profile-mfg')->assertMethodNotAllowed();
        $this->post('/profile-mfg/shipping-schedule')->assertMethodNotAllowed();
        $this->put('/profile-mfg/customers/CUST-001')->assertMethodNotAllowed();
        $this->patch('/profile-mfg/parts/PART-001')->assertMethodNotAllowed();
        $this->post('/profile-mfg/orders')->assertMethodNotAllowed();
        $this->put('/profile-mfg/orders/ORD-1001')->assertMethodNotAllowed();
        $this->patch('/profile-mfg/orders/ORD-1001')->assertMethodNotAllowed();
        $this->delete('/profile-mfg/orders/ORD-1001')->assertMethodNotAllowed();
        $this->post('/profile-mfg/inventory')->assertMethodNotAllowed();
        $this->post('/profile-mfg/scanning')->assertMethodNotAllowed();
        $this->post('/profile-mfg/reports')->assertMethodNotAllowed();
        $this->post('/profile-mfg/settings')->assertMethodNotAllowed();
        $this->patch('/profile-mfg/inventory')->assertMethodNotAllowed();
        $this->delete('/profile-mfg/parts/PART-001')->assertMethodNotAllowed();
    }

    public function test_poc_pages_render_installed_ui_component_contracts(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/profile-mfg')
            ->assertOk()
            ->assertSee('data-ui-notification-type="inline"', false)
            ->assertSee('data-ui-pattern="dashboard-grid"', false)
            ->assertSee('data-ui-component="tile"', false)
            ->assertSee('data-ui-component="data-table"', false);

        foreach (['customers', 'parts', 'orders', 'inventory', 'scanning'] as $directory) {
            $this->get('/profile-mfg/'.$directory)
                ->assertOk()
                ->assertSee('data-ui-notification-type="inline"', false)
                ->assertSee('data-ui-component="data-table-toolbar"', false)
                ->assertSee('data-ui-component="data-table"', false);
        }

        $this->get('/profile-mfg/reports')
            ->assertOk()
            ->assertSee('data-ui-component="tile"', false);

        $this->get('/profile-mfg/settings')
            ->assertOk()
            ->assertSee('data-ui-component="select"', false)
            ->assertSee('Save settings — Preview');

        foreach (['customers/CUST-001', 'parts/PART-001', 'orders/ORD-1001'] as $detail) {
            $this->get('/profile-mfg/'.$detail)
                ->assertOk()
                ->assertSee('data-ui-notification-type="inline"', false)
                ->assertSee('data-ui-pattern="key-value-display"', false)
                ->assertSee('data-ui-component="data-table"', false);
        }
    }

    public function test_poc_uses_the_workspace_shell_appearance_without_changing_disabled_mode(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/profile-mfg')
            ->assertOk()
            ->assertSee('data-ui-shell-appearance="workspace"', false)
            ->assertSee('data-ui-theme="gray-100"', false)
            ->assertSee('data-ui-theme="workspace"', false)
            ->assertSee('ui-shell-content--workspace', false);

        config()->set('profile-mfg-poc.enabled', false);

        $this->get('/account')
            ->assertOk()
            ->assertDontSee('data-ui-shell-appearance="workspace"', false)
            ->assertDontSee('data-ui-theme="workspace"', false)
            ->assertDontSee('ui-shell-content--workspace', false)
            ->assertDontSee('Profile Mfg navigation');
    }

    public function test_poc_workspace_persists_across_account_settings_and_setup_pages(): void
    {
        $this->actingAsPlatformSuperAdmin();

        foreach ([
            '/account',
            '/account/security',
            '/account/preferences',
            '/account/notifications',
            '/platform/settings',
            '/platform/setup',
            '/platform/roles',
            '/platform/roles/permissions',
        ] as $url) {
            $this->get($url)
                ->assertOk()
                ->assertSee('data-ui-shell-appearance="workspace"', false)
                ->assertSee('data-ui-app-grid-align="start"', false)
                ->assertSee('data-ui-app-grid-mode="narrow"', false)
                ->assertSee('aria-label="Profile Mfg navigation"', false)
                ->assertSee(route('profile-mfg.dashboard'), false)
                ->assertSee(route('profile-mfg.orders.index'), false)
                ->assertSee(route('profile-mfg.inventory.index'), false);
        }
    }

    public function test_account_preference_pages_use_the_installed_single_section_pattern(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/account/preferences')
            ->assertOk()
            ->assertSee('data-ui-pattern="account.section-tabs"', false)
            ->assertSee('data-account-section-tabs-count="1"', false)
            ->assertSee('data-account-preferences-personal-defaults-pane', false)
            ->assertSee('Edit preferences');

        $this->get('/account/notifications')
            ->assertOk()
            ->assertSee('data-ui-pattern="account.section-tabs"', false)
            ->assertSee('data-account-section-tabs-count="1"', false)
            ->assertSee('data-account-notifications-delivery-pane', false)
            ->assertSee('Edit preferences');
    }

    public function test_poc_views_do_not_reimplement_installed_tables_controls_or_sidebar_layout(): void
    {
        $views = File::allFiles(base_path('Modules/ProfileMfgPoc/resources/views'));

        foreach ($views as $view) {
            $source = File::get($view->getPathname());

            $this->assertStringNotContainsString('<table', $source, $view->getRelativePathname());
            $this->assertStringNotContainsString('<input', $source, $view->getRelativePathname());
            $this->assertStringNotContainsString('<select', $source, $view->getRelativePathname());
            $this->assertStringNotContainsString('<style', $source, $view->getRelativePathname());
            $this->assertStringNotContainsString('ui-platform-table-shell', $source, $view->getRelativePathname());
        }
    }

    public function test_missing_or_invalid_data_returns_a_safe_unavailable_page(): void
    {
        $this->actingAs(User::factory()->create());

        $missingPath = $this->temporaryDirectory.'/missing.json';
        config()->set('profile-mfg-poc.data_path', $missingPath);

        $this->get('/profile-mfg')
            ->assertStatus(503)
            ->assertSee('POC data unavailable')
            ->assertDontSee($missingPath);

        $invalidPath = $this->temporaryDirectory.'/invalid.json';
        File::put($invalidPath, '{not-json');
        config()->set('profile-mfg-poc.data_path', $invalidPath);

        $this->get('/profile-mfg')
            ->assertStatus(503)
            ->assertSee('POC data unavailable')
            ->assertDontSee('not-json');
    }

    public function test_duplicate_or_cross_customer_relationships_are_rejected_safely(): void
    {
        $this->actingAs(User::factory()->create());

        $dataset = json_decode((string) File::get($this->fixturePath), true, flags: JSON_THROW_ON_ERROR);
        $dataset['customers'][] = $dataset['customers'][0];

        $duplicatePath = $this->temporaryDirectory.'/duplicate.json';
        File::put($duplicatePath, json_encode($dataset, JSON_THROW_ON_ERROR));
        config()->set('profile-mfg-poc.data_path', $duplicatePath);

        $this->get('/profile-mfg')
            ->assertStatus(503)
            ->assertSee('POC data unavailable');

        $dataset = json_decode((string) File::get($this->fixturePath), true, flags: JSON_THROW_ON_ERROR);
        $dataset['orders'][0]['customer_id'] = 'CUST-002';

        $relationshipPath = $this->temporaryDirectory.'/relationship.json';
        File::put($relationshipPath, json_encode($dataset, JSON_THROW_ON_ERROR));
        config()->set('profile-mfg-poc.data_path', $relationshipPath);

        $this->get('/profile-mfg')
            ->assertStatus(503)
            ->assertSee('POC data unavailable');

        $dataset = json_decode((string) File::get($this->fixturePath), true, flags: JSON_THROW_ON_ERROR);
        $dataset['scans'][0]['part_id'] = 'missing';

        $scanRelationshipPath = $this->temporaryDirectory.'/scan-relationship.json';
        File::put($scanRelationshipPath, json_encode($dataset, JSON_THROW_ON_ERROR));
        config()->set('profile-mfg-poc.data_path', $scanRelationshipPath);

        $this->get('/profile-mfg/scanning')
            ->assertStatus(503)
            ->assertSee('POC data unavailable');

        $dataset = json_decode((string) File::get($this->fixturePath), true, flags: JSON_THROW_ON_ERROR);
        $dataset['parts'][0]['image_file'] = '../outside.png';

        $unsafeImagePath = $this->temporaryDirectory.'/unsafe-image.json';
        File::put($unsafeImagePath, json_encode($dataset, JSON_THROW_ON_ERROR));
        config()->set('profile-mfg-poc.data_path', $unsafeImagePath);

        $this->get('/profile-mfg')
            ->assertStatus(503)
            ->assertSee('POC data unavailable')
            ->assertDontSee('outside.png');
    }
}
