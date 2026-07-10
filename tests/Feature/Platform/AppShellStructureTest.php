<?php
/*
|--------------------------------------------------------------------------
| File: tests/Feature/Platform/AppShellStructureTest.php
| Purpose: Verifies app frame structure and metadata-driven header actions.
|--------------------------------------------------------------------------
*/

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Modules\Notifications\Models\Notification;
use App\Modules\Notifications\Services\NotificationPermissions;
use App\Modules\Settings\Services\SettingsPermissions;
use App\Platform\Shell\AppShellData;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppShellStructureTest extends TestCase
{
    use RefreshDatabase;

    public function test_header_area_navigation_renders_area_entries_from_module_metadata(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('data-ui-shell-header-navigation', false)
            ->assertSee('href="'.url('/dashboard').'"', false)
            ->assertSee('ui-shell-header__menu-item--current', false);

        $data = app(AppShellData::class)->forUser(auth()->user());

        $this->assertSame(['dashboard.nav.primary', 'setup.nav.area'], collect($data['headerNavigation'])->pluck('key')->all());
        $this->assertSame(['Dashboard', 'Setup'], collect($data['headerNavigation'])->pluck('label')->all());
        $this->assertSame(['dashboard', 'setup'], collect($data['headerNavigation'])->pluck('areaKey')->all());
        $this->assertSame([0, 20], collect($data['headerNavigation'])->pluck('sortOrder')->all());
    }

    public function test_authenticated_app_layout_uses_grid_by_default_and_renders_page_actions_region(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/account')
            ->assertOk()
            ->assertSee('data-ui-app-grid-enabled="true"', false)
            ->assertSee('data-ui-app-grid-region="authenticated-main"', false)
            ->assertSee('data-ui-shell-page-title-actions-region', false)
            ->assertSee('Edit Profile');
    }

    public function test_guest_auth_views_explicitly_opt_out_of_app_grid(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('data-ui-app-grid-enabled="false"', false)
            ->assertDontSee('data-ui-app-grid-region="guest-main"', false);
    }

    public function test_setup_area_navigation_remains_visible_for_current_setup_capable_users(): void
    {
        $this->actingAsUserWithPermissions([NotificationPermissions::VIEW]);

        $data = app(AppShellData::class)->forUser(auth()->user());

        $this->assertContains('setup.nav.area', collect($data['headerNavigation'])->pluck('key')->all());

        $this->get('/platform/setup')
            ->assertOk()
            ->assertSee('Setup')
            ->assertSee('Notifications')
            ->assertDontSee('Staff Setup')
            ->assertDontSee('Roles &amp; Permissions', false);
    }

    public function test_notifications_are_not_primary_navigation_entries(): void
    {
        $primaryBase = collect(config('navigation.primaryBase', []));

        $this->assertSame(['Dashboard'], $primaryBase->pluck('label')->values()->all());
        $this->assertFalse($primaryBase->contains(fn (array $item): bool => ($item['route'] ?? null) === 'notifications.index'));
    }

    public function test_dashboard_area_keeps_default_sidebar_navigation_available(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $data = app(AppShellData::class)->forUser(auth()->user());

        $this->assertSame(['key' => 'dashboard', 'label' => 'Dashboard'], $data['activeArea']);
        $this->assertArrayHasKey('primaryBase', $data['navigation']);
        $this->assertArrayHasKey('primaryAdmin', $data['navigation']);
        $this->assertArrayHasKey('logs', $data['navigation']);
        $this->assertSame(['Dashboard'], collect($data['navigation']['primaryBase'])->pluck('label')->values()->all());
        $this->assertSame([], $data['navigation']['primaryAdmin']);
        $this->assertSame([], $data['navigation']['logs']);
        $this->assertSame([], $data['navigation']['setupBase']);
        $this->assertSame([], $data['navigation']['setupAdmin']);
    }

    public function test_dashboard_sidebar_renders_only_area_title_and_dashboard_link(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('data-app-sidebar-area-title', false)
            ->assertSee('href="'.url('/dashboard').'"', false);
    }

    public function test_setup_area_switches_sidebar_to_setup_navigation(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/setup')
            ->assertOk()
            ->assertSee('data-app-sidebar-area-title', false)
            ->assertSee('Roles &amp; Permissions', false)
            ->assertDontSee('Staff Setup')
            ->assertDontSee('Notifications Setup')
            ->assertDontSee('Audit Logs Setup')
            ->assertDontSee('Error Logs Setup')
            ->assertDontSee('Documentation Setup');

        $data = app(AppShellData::class)->forUser(auth()->user());

        $this->assertSame(['key' => 'setup', 'label' => 'Setup'], $data['activeArea']);
        $this->assertSame(
            ['Setup', 'Roles & Permissions', 'Notifications'],
            collect($data['navigation']['primaryBase'])->pluck('label')->values()->all(),
        );
        $this->assertSame([], $data['navigation']['primaryAdmin']);
        $this->assertSame([], $data['navigation']['logs']);
    }

    public function test_settings_routes_switch_sidebar_to_settings_navigation(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/settings')
            ->assertOk()
            ->assertSee('data-app-sidebar-area-title', false)
            ->assertSee('Notification Defaults')
            ->assertDontSee('Company Information')
            ->assertDontSee('Localization')
            ->assertDontSee('System Update')
            ->assertDontSee('System/Server Info');

        $data = app(AppShellData::class)->forUser(auth()->user());

        $this->assertSame(['key' => 'settings', 'label' => 'Settings'], $data['activeArea']);
        $this->assertSame(
            ['Settings', 'Notification Defaults'],
            collect($data['navigation']['primaryBase'])->pluck('label')->values()->all(),
        );
        $this->assertSame([], $data['navigation']['primaryAdmin']);
        $this->assertSame([], $data['navigation']['logs']);
    }

    public function test_settings_sidebar_is_used_for_module_settings_pages(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/settings/notifications')
            ->assertOk()
            ->assertSee('data-app-sidebar-area-title', false)
            ->assertSee('Notification Defaults')
            ->assertDontSee('Company Information')
            ->assertDontSee('Localization')
            ->assertDontSee('System Update')
            ->assertDontSee('System/Server Info');
    }

    public function test_header_global_actions_render_from_module_metadata_for_authorized_users(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'notifications',
            'severity' => 'notice',
            'title' => 'Header notice',
            'body' => 'Header notification body.',
        ]);

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('data-header-global-action-key="settings.header.global-action"', false)
            ->assertSee('data-header-global-action-key="notifications.header.global-action"', false)
            ->assertSee('data-header-global-action-key="account.header.global-action"', false)
            ->assertSee('data-header-global-action-module="settings"', false)
            ->assertSee('data-header-global-action-module="notifications"', false)
            ->assertSee('data-header-global-action-module="account"', false)
            ->assertSee('aria-label="Settings"', false)
            ->assertSee('href="'.url('/settings').'"', false)
            ->assertSee('data-app-header-search', false)
            ->assertSee('data-app-account-menu', false)
            ->assertSee('data-notification-trigger-unread="true"', false)
            ->assertSee('data-app-notifications-menu', false)
            ->assertSee('href="'.url('/notifications').'"', false)
            ->assertSee('data-notifications-realtime-auth-url="'.url('/notifications/realtime/auth').'"', false);
    }

    public function test_settings_header_global_action_requires_settings_access(): void
    {
        $this->actingAsUserWithPermissions([NotificationPermissions::VIEW]);

        $this->get('/dashboard')
            ->assertOk()
            ->assertDontSee('settings.header.global-action')
            ->assertSee('notifications.header.global-action');
    }

    public function test_notifications_header_global_action_and_panel_require_notifications_access(): void
    {
        $this->actingAsUserWithPermissions([SettingsPermissions::VIEW]);

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('settings.header.global-action')
            ->assertDontSee('notifications.header.global-action')
            ->assertDontSee('data-app-notifications-menu', false);
    }

    public function test_app_shell_data_does_not_expose_notification_specific_frame_props(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $data = app(AppShellData::class)->forUser(auth()->user());

        $this->assertArrayHasKey('headerGlobalActions', $data);
        $this->assertArrayNotHasKey('accountNavigation', $data);
        $this->assertArrayNotHasKey('canViewNotifications', $data);
        $this->assertArrayNotHasKey('recentNotifications', $data);
        $this->assertArrayNotHasKey('unreadNotifications', $data);
        $this->assertArrayNotHasKey('notificationRoutes', $data);
    }

    public function test_account_header_action_uses_module_metadata_and_account_menu_entries(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('data-header-global-action-key="account.header.global-action"', false)
            ->assertSee('data-header-global-action-module="account"', false)
            ->assertSee('data-app-account-menu', false)
            ->assertSee('data-account-menu-entry-key="account.nav.index"', false)
            ->assertSee('data-account-menu-entry-key="account.nav.security"', false)
            ->assertSee('data-account-menu-entry-key="account.nav.preferences"', false)
            ->assertDontSee('data-account-menu-entry-key="account.nav.settings"', false)
            ->assertDontSee('data-account-menu-entry-key="settings.nav.account"', false)
            ->assertDontSee('data-account-menu-entry-key="notifications.nav.account"', false)
            ->assertDontSee('data-account-menu-entry-key="security-checklist.nav.account"', false)
            ->assertSee('action="'.url('/logout').'"', false);
    }

    /**
     * @param list<string> $permissions
     */
    private function actingAsUserWithPermissions(array $permissions): User
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->givePermissionTo($permissions);

        $this->actingAs($user);

        return $user;
    }
}
