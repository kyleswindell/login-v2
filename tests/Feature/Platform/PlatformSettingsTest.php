<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Platform\Settings\SettingsService;
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

    public function test_authorized_users_can_view_all_settings_pages(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/settings/general')
            ->assertOk()
            ->assertSee('Platform General')
            ->assertSee('data-ui-component="searchable-select"', false)
            ->assertSee('data-ui-searchable-select-trigger', false);
        $this->get('/platform/settings/general/company-information')->assertOk()->assertSee('Company Information');
        $this->get('/platform/settings/general/localization')->assertOk()->assertSee('Localization');
        $this->get('/platform/settings/general/email')->assertOk()->assertSee('Email');
        $this->get('/platform/settings/general/system-update')->assertOk()->assertSee('System Update');
        $this->get('/platform/settings/general/system-server-info')->assertOk()->assertSee('System/Server Info');
        $this->get('/platform/settings/notifications')->assertOk()->assertSee('Notification Defaults');
        $this->get('/platform/settings/audit-logs')->assertOk()->assertSee('Audit Settings');
        $this->get('/platform/settings/docs')->assertOk()->assertSee('Vault Access');
        $this->get('/platform/settings/users')->assertOk()->assertSee('User Defaults');
    }

    public function test_platform_reviewer_can_view_all_settings_pages_but_cannot_update_them(): void
    {
        $this->actingAsPlatformReviewer();

        $this->get('/platform/settings/general')->assertOk()->assertSee('Platform General');
        $this->get('/platform/settings/general/company-information')->assertOk()->assertSee('Company Information');
        $this->get('/platform/settings/general/localization')->assertOk()->assertSee('Localization');
        $this->get('/platform/settings/general/email')->assertOk()->assertSee('Email');
        $this->get('/platform/settings/general/system-update')->assertOk()->assertSee('System Update');
        $this->get('/platform/settings/general/system-server-info')->assertOk()->assertSee('System/Server Info');
        $this->get('/platform/settings/notifications')->assertOk()->assertSee('Notification Defaults');
        $this->get('/platform/settings/audit-logs')->assertOk()->assertSee('Audit Settings');
        $this->get('/platform/settings/docs')->assertOk()->assertSee('Vault Access');
        $this->get('/platform/settings/users')->assertOk()->assertSee('User Defaults');

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
            ->assertRedirect('/platform/settings/general');
    }

    public function test_platform_reviewer_is_redirected_from_target_settings_route(): void
    {
        $this->actingAsPlatformReviewer();

        $this->get('/platform/administration/settings')
            ->assertRedirect('/platform/settings/general');
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
        $this->assertSame('(123) 456-7890', app(SettingsService::class)->get('general_company', 'phone'));
    }

    public function test_company_information_surface_uses_shared_phone_input_baseline(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/settings/general/company-information')
            ->assertOk()
            ->assertSee('data-ui-phone-input', false)
            ->assertSee('placeholder="(555) 555-5555"', false);
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
            'default_role' => 'platform_admin',
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
            '/platform/settings/general',
            '/platform/settings/general/company-information',
            '/platform/settings/general/localization',
            '/platform/settings/general/email',
            '/platform/settings/general/system-update',
            '/platform/settings/general/system-server-info',
            '/platform/settings/notifications',
            '/platform/settings/audit-logs',
            '/platform/settings/docs',
            '/platform/settings/users',
            '/platform/administration/settings',
        ];
    }
}
