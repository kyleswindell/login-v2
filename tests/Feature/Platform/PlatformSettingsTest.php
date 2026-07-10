<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Modules\Notifications\Services\NotificationPermissions;
use App\Modules\Roles\Services\RoleCatalog;
use App\Modules\Settings\Services\SettingsPermissions;
use App\Modules\Settings\Services\Store;
use Database\Seeders\PlatformRolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformSettingsTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Access control
    // -------------------------------------------------------------------------

    public function test_guests_are_redirected_from_settings_pages(): void
    {
        foreach ($this->settingsRoutes() as $url) {
            $this->get($url)->assertRedirect('/login');
        }
    }

    public function test_users_without_settings_permission_cannot_access_settings_pages(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        foreach ($this->settingsRoutes() as $url) {
            $this->get($url)->assertForbidden();
        }
    }

    public function test_authorized_users_can_view_current_settings_pages(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/settings')
            ->assertOk()
            ->assertSee('Settings')
            ->assertSee('Manage app-wide settings and module-provided configuration pages.')
            ->assertSee('data-settings-landing-tile', false)
            ->assertSee('data-settings-route="platform.settings.notifications"', false)
            ->assertSee('Notification Defaults')
            ->assertDontSee('Company Information')
            ->assertDontSee('Localization')
            ->assertDontSee('System Update')
            ->assertDontSee('System/Server Info');
        $this->get('/platform/settings')
            ->assertOk()
            ->assertSee('Settings')
            ->assertSee('Manage app-wide settings and module-provided configuration pages.')
            ->assertSee('Notification Defaults');
        $this->get('/platform/settings/notifications')->assertOk()->assertSee('Notification Defaults');
    }

    public function test_deprecated_settings_get_pages_redirect_to_settings_landing(): void
    {
        $this->actingAsPlatformSuperAdmin();

        foreach ($this->deprecatedSettingsPageRoutes() as $url) {
            $this->get($url)->assertRedirect('/settings');
        }
    }

    public function test_permissioned_viewer_can_view_current_settings_pages_but_cannot_update_them(): void
    {
        $this->seed(PlatformRolesAndPermissionsSeeder::class);

        $user = User::factory()->create();
        $user->givePermissionTo([
            SettingsPermissions::VIEW,
            NotificationPermissions::SETTINGS_VIEW,
        ]);

        $this->actingAs($user);

        $this->get('/settings')->assertOk()->assertSee('Settings');
        $this->get('/platform/settings/notifications')->assertOk()->assertSee('Notification Defaults');

        $this->post('/platform/settings/general', [
            'display_name' => 'Reviewer Attempt',
            'timezone' => 'America/New_York',
            'locale' => 'en',
        ])->assertForbidden();
    }

    public function test_authorized_users_are_redirected_from_target_settings_route(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/administration/settings')
            ->assertRedirect('/settings');
    }

    public function test_settings_sidebar_renders_module_surface_navigation_and_current_state(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $response = $this->get('/platform/settings/notifications')
            ->assertOk();

        $html = $response->getContent();

        foreach ([
            'Settings',
            'Notification Defaults',
        ] as $text) {
            $this->assertStringContainsString($text, $html);
        }

        foreach ([
            'Notifications Setup',
            'Documentation Setup',
            'Audit Logs Setup',
            'Error Logs Setup',
            'Staff Setup',
            'Audit Logs',
            'Audit Settings',
            'Documentation Vault',
            'Vault Access',
            'Platform Users',
            'User Defaults',
            'General',
            'Company Information',
            'Localization',
            'System Update',
            'System/Server Info',
        ] as $text) {
            $this->assertStringNotContainsString($text, $html);
        }

        $notificationUrl = preg_quote(url('/platform/settings/notifications'), '#');

        $this->assertMatchesRegularExpression(
            '#<a[^>]*href="'.$notificationUrl.'"[^>]*class="[^"]*is-current#',
            $html,
        );
    }

    public function test_permissioned_viewer_is_redirected_from_target_settings_route(): void
    {
        $this->actingAsPlatformReviewer();

        $this->get('/platform/administration/settings')
            ->assertRedirect('/settings');
    }

    public function test_company_information_settings_can_be_updated(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/general/company-information', [
            'company_name' => 'Para Solutions LLC',
            'company_email' => 'hello@example.com',
            'company_phone' => '1234567890',
            'company_address' => '123 Main St',
        ])->assertRedirect();

        $this->assertDatabaseHas('settings', ['group_key' => 'general_company', 'key' => 'name']);
        $this->assertSame('(123) 456-7890', app(Store::class)->get('general_company', 'phone'));
    }

    public function test_localization_settings_can_be_updated(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/general/localization', [
            'default_language' => 'en',
            'date_format' => 'M j, Y',
            'time_format' => 'g:i A',
            'first_day_of_week' => 'monday',
        ])->assertRedirect();

        $this->assertDatabaseHas('settings', ['group_key' => 'general_localization', 'key' => 'default_language']);
    }

    public function test_general_email_settings_can_be_updated(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/general/email', [
            'from_name' => 'Platform',
            'from_address' => 'platform@example.com',
            'reply_to_address' => 'reply@example.com',
            'mail_driver' => 'smtp',
        ])->assertRedirect();

        $this->assertDatabaseHas('settings', ['group_key' => 'general_email', 'key' => 'from_name']);
    }

    // -------------------------------------------------------------------------
    // General settings
    // -------------------------------------------------------------------------

    public function test_general_settings_can_be_updated(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/general', [
            'display_name' => 'Parasolutions Admin',
            'timezone' => 'America/New_York',
            'locale' => 'en',
        ])->assertRedirect();

        $this->assertDatabaseHas('settings', ['group_key' => 'general', 'key' => 'display_name']);
        $this->assertDatabaseHas('settings', ['group_key' => 'general', 'key' => 'timezone']);
        $this->assertDatabaseHas('settings', ['group_key' => 'general', 'key' => 'locale']);
    }

    public function test_general_settings_validation_rejects_invalid_timezone(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/general', [
            'display_name' => 'Test',
            'timezone' => 'Not/ATimezone',
            'locale' => 'en',
        ])->assertSessionHasErrors(['timezone']);
    }

    public function test_general_settings_validation_rejects_invalid_locale_option(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/general', [
            'display_name' => 'Test',
            'timezone' => 'America/New_York',
            'locale' => 'not-real',
        ])->assertSessionHasErrors(['locale']);
    }

    public function test_general_settings_validation_rejects_missing_display_name(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/general', [
            'display_name' => '',
            'timezone' => 'America/New_York',
            'locale' => 'en',
        ])->assertSessionHasErrors(['display_name']);
    }

    // -------------------------------------------------------------------------
    // Notification defaults
    // -------------------------------------------------------------------------

    public function test_notification_settings_can_be_updated(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/notifications', [
            'default_severity' => 'warning',
            'max_per_user' => 200,
        ])->assertRedirect();

        $this->assertDatabaseHas('settings', ['group_key' => 'notifications', 'key' => 'default_severity']);
        $this->assertDatabaseHas('settings', ['group_key' => 'notifications', 'key' => 'max_per_user']);
    }

    public function test_notification_settings_reject_invalid_severity(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/notifications', [
            'default_severity' => 'unknown',
            'max_per_user' => 100,
        ])->assertSessionHasErrors(['default_severity']);
    }

    public function test_notification_settings_reject_out_of_range_max(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/notifications', [
            'default_severity' => 'info',
            'max_per_user' => 5,
        ])->assertSessionHasErrors(['max_per_user']);
    }

    // -------------------------------------------------------------------------
    // Audit log settings
    // -------------------------------------------------------------------------

    public function test_audit_log_settings_can_be_updated(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/audit-logs', [
            'retention_days' => 730,
            'login_event_severity' => 'notice',
        ])->assertRedirect();

        $this->assertDatabaseHas('settings', ['group_key' => 'audit_logs', 'key' => 'retention_days']);
        $this->assertDatabaseHas('settings', ['group_key' => 'audit_logs', 'key' => 'login_event_severity']);
    }

    public function test_audit_log_settings_reject_invalid_severity(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/audit-logs', [
            'retention_days' => 365,
            'login_event_severity' => 'critical',
        ])->assertSessionHasErrors(['login_event_severity']);
    }

    public function test_audit_log_settings_reject_retention_below_minimum(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/audit-logs', [
            'retention_days' => 3,
            'login_event_severity' => 'info',
        ])->assertSessionHasErrors(['retention_days']);
    }

    // -------------------------------------------------------------------------
    // Docs settings
    // -------------------------------------------------------------------------

    public function test_docs_settings_can_be_updated(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/docs', [
            'access_scope' => 'super_admins_only',
        ])->assertRedirect();

        $this->assertDatabaseHas('settings', [
            'group_key' => 'docs',
            'key' => 'access_scope',
        ]);
    }

    public function test_docs_settings_reject_invalid_access_scope(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/docs', [
            'access_scope' => 'everyone',
        ])->assertSessionHasErrors(['access_scope']);
    }

    // -------------------------------------------------------------------------
    // User defaults settings
    // -------------------------------------------------------------------------

    public function test_user_settings_can_be_updated(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/users', [
            'default_role' => RoleCatalog::ADMIN,
            'default_active' => '1',
        ])->assertRedirect();

        $this->assertDatabaseHas('settings', ['group_key' => 'users', 'key' => 'default_role']);
        $this->assertDatabaseHas('settings', ['group_key' => 'users', 'key' => 'default_active']);
    }

    public function test_user_settings_reject_invalid_role(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->post('/platform/settings/users', [
            'default_role' => 'tenant_admin',
            'default_active' => '1',
        ])->assertSessionHasErrors(['default_role']);
    }

    public function test_users_without_permission_cannot_post_to_settings(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/platform/settings/general', [
            'display_name' => 'Attacker',
            'timezone' => 'UTC',
            'locale' => 'en',
        ])->assertForbidden();

        $this->assertDatabaseMissing('settings', ['group_key' => 'general', 'key' => 'display_name']);
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /** @return list<string> */
    private function settingsRoutes(): array
    {
        return [
            '/settings',
            '/platform/settings',
            '/platform/settings/general',
            '/platform/settings/general/company-information',
            '/platform/settings/general/localization',
            '/platform/settings/general/email',
            '/platform/settings/general/system-update',
            '/platform/settings/general/system-server-info',
            '/platform/settings/notifications',
            '/platform/administration/settings',
        ];
    }

    /** @return list<string> */
    private function deprecatedSettingsPageRoutes(): array
    {
        return [
            '/platform/settings/general',
            '/platform/settings/general/company-information',
            '/platform/settings/general/localization',
            '/platform/settings/general/email',
            '/platform/settings/general/system-update',
            '/platform/settings/general/system-server-info',
        ];
    }
}
