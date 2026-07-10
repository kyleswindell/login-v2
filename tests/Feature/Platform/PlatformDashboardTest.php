<?php

/*
|--------------------------------------------------------------------------
| File: tests/Feature/Platform/PlatformDashboardTest.php
| Purpose: Verifies the module-owned blank Dashboard page contract.
|--------------------------------------------------------------------------
*/

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Modules\Notifications\Events\Created;
use App\Modules\Notifications\Models\Notification;
use App\Platform\Dashboard\WidgetRegistry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PlatformDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_module_page_is_accessible_to_authenticated_users(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('Your workspace dashboard is ready for the next module-owned rebuild.')
            ->assertSee('data-dashboard-test-notification-tile', false)
            ->assertSee('Generate test notification')
            ->assertDontSee('dashboard-widget-grid')
            ->assertDontSee('data-dashboard-reorder-surface', false)
            ->assertDontSee('data-ui-pattern="widget-shell"', false)
            ->assertDontSee('Customize');
    }

    public function test_dashboard_redirects_guests_to_login(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_dashboard_route_name_is_preserved(): void
    {
        $this->assertSame('/dashboard', route('dashboard', absolute: false));
    }

    public function test_dashboard_widgets_are_inactive_until_rebuild(): void
    {
        $registry = app(WidgetRegistry::class);

        $this->assertSame([], $registry->knownKeys());
        $this->assertSame([], $registry->defaults());
    }

    public function test_dashboard_can_generate_test_notification(): void
    {
        $this->actingAsPlatformSuperAdmin();
        Event::fake([Created::class]);

        $response = $this->postJson('/dashboard/test-notification');

        $notification = Notification::query()->latest('id')->first();

        $this->assertNotNull($notification);
        $this->assertSame('dashboard', $notification->module_key);
        $this->assertSame('Test notification', $notification->title);
        $this->assertSame('This notification was generated from the Dashboard test tile.', $notification->body);
        $this->assertSame(route('notifications.index'), $notification->action_url);
        $this->assertSame(1, Notification::query()->count());

        Event::assertDispatchedTimes(Created::class, 1);
        Event::assertDispatched(
            Created::class,
            fn (Created $event): bool => $event->notification['id'] === $notification->id,
        );

        $response
            ->assertCreated()
            ->assertExactJson([
                'created' => true,
                'notification_id' => $notification->id,
            ]);
    }

    public function test_dashboard_test_notification_requires_notification_permission(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/dashboard')
            ->assertOk()
            ->assertDontSee('data-dashboard-test-notification-tile', false);

        $this->post('/dashboard/test-notification')->assertForbidden();

        $this->assertSame(0, Notification::query()->count());
    }
}
