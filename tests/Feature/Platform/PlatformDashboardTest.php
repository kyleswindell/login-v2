<?php

namespace Tests\Feature\Platform;

use App\Models\PlatformNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_platform_management_links_for_super_admins(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee($user->email)
            ->assertSee('Platform Users')
            ->assertSee('/platform/administration/users', false)
            ->assertDontSee('href="/platform/users"', false)
            ->assertSee('Documentation Vault')
            ->assertSee('/platform/administration/notifications', false)
            ->assertSee('/platform/administration/settings', false)
            ->assertSee('/platform/operations/audit-logs', false)
            ->assertSee('/platform/operations/error-logs', false)
            ->assertDontSee('/console/platform-audit-logs', false)
            ->assertDontSee('/console/central-error-logs', false);
    }

    public function test_dashboard_renders_recent_notification_preview_data_for_super_admins(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        PlatformNotification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'notice',
            'title' => 'Header preview notification',
            'body' => 'Recent preview body.',
        ]);

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Recent Notifications')
            ->assertSee('Header preview notification')
            ->assertSee('1 unread')
            ->assertSee('/platform/administration/notifications', false);
    }

    public function test_dashboard_hides_platform_management_links_for_standard_users(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertOk()
            ->assertDontSee('Platform Users')
            ->assertDontSee('/platform/administration/users', false)
            ->assertDontSee('Documentation Vault')
            ->assertDontSee('/platform/administration/notifications', false)
            ->assertDontSee('/platform/administration/settings', false)
            ->assertDontSee('/platform/operations/audit-logs', false)
            ->assertDontSee('/platform/operations/error-logs', false)
            ->assertDontSee('data-setup-open', false);
    }

    public function test_dashboard_shows_setup_trigger_for_super_admins(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('data-setup-open', false);
    }
}
