<?php

namespace Tests\Feature\Platform;

use App\Livewire\Platform\Dashboard\DashboardPage;
use App\Models\PlatformNotification;
use App\Models\User;
use App\Models\UserDashboardLayout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PlatformDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_is_accessible_to_authenticated_users(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee($user->email)
            ->assertSee('data-ui-pattern="widget-shell"', false)
            ->assertSee('dashboard-widget-grid')
            ->assertSee('data-dashboard-reorder-surface', false)
            ->assertSee('Customize');
    }

    public function test_dashboard_redirects_guests_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_dashboard_loads_visible_widgets_for_super_admin(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $component = Livewire::actingAs($user)->test(DashboardPage::class);

        $visibleKeys = collect($component->get('widgetLayout'))
            ->filter(fn ($slot) => $slot['is_visible'] ?? true)
            ->pluck('widget_key')
            ->all();

        $this->assertContains('platform_stats', $visibleKeys);
        $this->assertContains('audit_activity', $visibleKeys);
        $this->assertContains('error_health', $visibleKeys);
        $this->assertContains('notifications_summary', $visibleKeys);
        $this->assertContains('development_tools', $visibleKeys);
    }

    public function test_dashboard_layout_contains_all_core_widgets_in_defaults(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)->test(DashboardPage::class);

        $keys = collect($component->get('widgetLayout'))->pluck('widget_key')->all();

        $this->assertContains('platform_stats', $keys);
        $this->assertContains('error_health', $keys);
        $this->assertContains('audit_activity', $keys);
        $this->assertContains('notifications_summary', $keys);
        $this->assertContains('development_tools', $keys);
    }

    public function test_dashboard_backfills_new_default_widgets_into_saved_layouts(): void
    {
        $user = User::factory()->create();

        UserDashboardLayout::query()->create([
            'user_id' => $user->id,
            'is_locked' => true,
            'layout' => [
                ['widget_key' => 'platform_stats', 'position' => 0, 'column_span' => 'full', 'row_span' => 1, 'is_visible' => true],
                ['widget_key' => 'error_health', 'position' => 1, 'column_span' => 6, 'row_span' => 1, 'is_visible' => true],
                ['widget_key' => 'audit_activity', 'position' => 2, 'column_span' => 6, 'row_span' => 1, 'is_visible' => true],
                ['widget_key' => 'notifications_summary', 'position' => 3, 'column_span' => 'full', 'row_span' => 1, 'is_visible' => true],
            ],
        ]);

        $component = Livewire::actingAs($user)->test(DashboardPage::class);

        $keys = collect($component->get('widgetLayout'))->pluck('widget_key')->all();

        $this->assertContains('development_tools', $keys);
    }

    public function test_dashboard_loads_default_layout_for_new_users(): void
    {
        $user = User::factory()->create();

        $this->assertDatabaseMissing('user_dashboard_layouts', ['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test(DashboardPage::class)
            ->assertSet('isLocked', true)
            ->assertSet('isEditing', false);

        // No layout row created until user explicitly customizes.
        $this->assertDatabaseMissing('user_dashboard_layouts', ['user_id' => $user->id]);
    }

    public function test_dashboard_lock_unlock_persists(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(DashboardPage::class)
            ->call('toggleLock')
            ->assertSet('isLocked', false)
            ->assertSet('isEditing', true);

        $this->assertDatabaseHas('user_dashboard_layouts', [
            'user_id'   => $user->id,
            'is_locked' => false,
        ]);

        Livewire::actingAs($user)
            ->test(DashboardPage::class)
            ->assertSet('isLocked', false);
    }

    public function test_dashboard_toggle_widget_visibility_persists(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)->test(DashboardPage::class);

        $component->call('toggleLock')
            ->assertSet('isLocked', false);

        $component->call('toggleWidgetVisibility', 'platform_stats');

        $layout = UserDashboardLayout::query()->where('user_id', $user->id)->first();
        $this->assertNotNull($layout);

        $statsSlot = collect($layout->layout)->firstWhere('widget_key', 'platform_stats');
        $this->assertFalse($statsSlot['is_visible']);
    }

    public function test_dashboard_reset_layout_restores_defaults(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(DashboardPage::class)
            ->call('toggleLock')
            ->call('toggleWidgetVisibility', 'platform_stats')
            ->call('resetLayout')
            ->assertSet('isLocked', true)
            ->assertSet('isEditing', false);

        $layout = UserDashboardLayout::query()->where('user_id', $user->id)->first();
        $this->assertNotNull($layout);

        $statsSlot = collect($layout->layout)->firstWhere('widget_key', 'platform_stats');
        $this->assertTrue($statsSlot['is_visible']);
    }

    public function test_dashboard_can_generate_test_notification(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        Livewire::actingAs($user)
            ->test(DashboardPage::class)
            ->call('generateTestNotification')
            ->assertDispatched('platform-notification-created');

        $this->assertDatabaseHas('notifications', [
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'development',
            'title' => 'Test notification',
        ]);
    }

    public function test_dashboard_reorder_widgets_ignores_unknown_keys(): void
    {
        $user = User::factory()->create();

        $badLayout = [
            'platform_stats',
            'malicious_widget',
        ];

        Livewire::actingAs($user)
            ->test(DashboardPage::class)
            ->call('toggleLock')
            ->call('reorderWidgets', $badLayout);

        $layout = UserDashboardLayout::query()->where('user_id', $user->id)->first();
        $this->assertNotNull($layout);

        $keys = collect($layout->layout)->pluck('widget_key')->all();
        $this->assertNotContains('malicious_widget', $keys);
        $this->assertContains('platform_stats', $keys);
    }

    public function test_dashboard_reorder_widgets_rebuilds_visible_order_and_preserves_hidden_widgets(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(DashboardPage::class)
            ->call('toggleLock')
            ->call('toggleWidgetVisibility', 'notifications_summary')
            ->call('reorderWidgets', ['audit_activity', 'platform_stats', 'error_health', 'development_tools']);

        $layout = UserDashboardLayout::query()->where('user_id', $user->id)->first();
        $this->assertNotNull($layout);

        $orderedKeys = collect($layout->layout)
            ->sortBy('position')
            ->pluck('widget_key')
            ->all();

        $this->assertSame([
            'audit_activity',
            'platform_stats',
            'error_health',
            'development_tools',
            'notifications_summary',
        ], $orderedKeys);

        $hiddenSlot = collect($layout->layout)->firstWhere('widget_key', 'notifications_summary');
        $this->assertFalse($hiddenSlot['is_visible']);
    }

    public function test_dashboard_saved_layouts_normalize_invalid_placement_metadata(): void
    {
        $user = User::factory()->create();

        UserDashboardLayout::query()->create([
            'user_id' => $user->id,
            'is_locked' => true,
            'layout' => [
                ['widget_key' => 'platform_stats', 'position' => 0, 'column_span' => 'full', 'row_span' => 99, 'is_visible' => true],
                ['widget_key' => 'error_health', 'position' => 1, 'column_span' => 5, 'row_span' => 3, 'is_visible' => true],
                ['widget_key' => 'audit_activity', 'position' => 2, 'column_span' => 6, 'row_span' => 2, 'is_visible' => true],
            ],
        ]);

        $component = Livewire::actingAs($user)->test(DashboardPage::class);

        $layout = collect($component->get('widgetLayout'))->keyBy('widget_key');

        $this->assertSame(1, $layout['platform_stats']['row_span']);
        $this->assertSame(6, $layout['error_health']['column_span']);
        $this->assertSame(1, $layout['error_health']['row_span']);
        $this->assertSame(2, $layout['audit_activity']['row_span']);
    }

    public function test_dashboard_shows_setup_trigger_for_super_admins(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('data-setup-open', false);
    }

    public function test_dashboard_does_not_expose_test_notification_route(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/dashboard/test-notification')->assertNotFound();
    }
}
