<?php

namespace Tests\Feature\Platform;

use App\Models\PlatformNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformNotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_users_can_view_their_notifications(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        PlatformNotification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'notice',
            'title' => 'Review needed',
            'body' => 'A notification body.',
            'action_url' => '/dashboard',
        ]);

        $this->get('/platform/notifications')
            ->assertOk()
            ->assertSee('Notifications')
            ->assertSee('Review needed')
            ->assertSee('Open notification link')
            ->assertSee('class="ui-action ui-action-notice text-sm"', false)
            ->assertSee('class="ui-action ui-action-primary"', false)
            ->assertSee('class="ui-action ui-action-success"', false)
            ->assertSee('class="ui-action ui-action-ghost"', false);
    }

    public function test_authorized_users_are_redirected_from_target_notifications_route(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/administration/notifications')
            ->assertRedirect('/platform/notifications');
    }

    public function test_notification_index_only_shows_current_user_notifications(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();
        $otherUser = User::factory()->create();

        PlatformNotification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Visible notification',
            'body' => 'Visible body.',
        ]);

        PlatformNotification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $otherUser->id,
            'module_key' => 'platform',
            'severity' => 'warning',
            'title' => 'Hidden notification',
            'body' => 'Hidden body.',
        ]);

        $this->get('/platform/notifications')
            ->assertOk()
            ->assertSee('Visible notification')
            ->assertDontSee('Hidden notification');
    }

    public function test_standard_users_cannot_access_platform_notifications(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/platform/notifications')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/platform/administration/notifications')
            ->assertForbidden();
    }

    public function test_authorized_users_can_mark_a_notification_as_read(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $notification = PlatformNotification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Read me',
            'body' => 'Read body.',
        ]);

        $this->post("/platform/notifications/{$notification->id}/read")
            ->assertRedirect();

        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_users_cannot_mark_other_user_notifications_as_read(): void
    {
        $this->actingAsPlatformSuperAdmin();
        $otherUser = User::factory()->create();

        $notification = PlatformNotification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $otherUser->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Protected',
            'body' => 'Protected body.',
        ]);

        $this->post("/platform/notifications/{$notification->id}/read")
            ->assertNotFound();
    }

    public function test_authorized_users_can_mark_all_their_notifications_as_read(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();
        $otherUser = User::factory()->create();

        $ownedNotification = PlatformNotification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Owned notification',
            'body' => 'Owned body.',
        ]);

        $otherNotification = PlatformNotification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $otherUser->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Other notification',
            'body' => 'Other body.',
        ]);

        $this->post('/platform/notifications/mark-all-read')
            ->assertRedirect();

        $this->assertNotNull($ownedNotification->fresh()->read_at);
        $this->assertNull($otherNotification->fresh()->read_at);
    }

    public function test_notification_trigger_uses_unread_state_treatment_when_unread_notifications_exist(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        PlatformNotification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'notice',
            'title' => 'Unread notification',
            'body' => 'Unread body.',
        ]);

        $this->get('/platform/notifications')
            ->assertOk()
            ->assertSee('class="ui-notification-trigger"', false)
            ->assertSee('data-notification-trigger-unread="true"', false)
            ->assertSee('data-notification-trigger-badge-hidden="false"', false)
            ->assertSee('data-notification-mark-all-enabled="true"', false)
            ->assertSee('data-notification-preview-unread', false)
            ->assertSee('data-notification-preview-item-unread="true"', false)
            ->assertSee('data-notification-preview-severity="notice"', false)
            ->assertSee('class="ui-notification-preview-item ui-notification-preview-item-unread"', false)
            ->assertSee('class="ui-notification-preview-pill ui-notification-preview-pill-notice"', false)
            ->assertSee('1 unread notifications', false)
            ->assertSee('Mark all as read', false)
            ->assertSee('class="ui-notification-trigger-badge"', false);
    }

    public function test_notification_trigger_uses_subdued_state_when_no_unread_notifications_exist(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        PlatformNotification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Already read notification',
            'body' => 'Read body.',
            'read_at' => now(),
        ]);

        $this->get('/platform/notifications')
            ->assertOk()
            ->assertSee('data-notification-trigger-unread="false"', false)
            ->assertSee('data-notification-trigger-badge-hidden="true"', false)
            ->assertSee('data-notification-mark-all-enabled="false"', false)
            ->assertSee('data-notification-preview-item-unread="false"', false)
            ->assertDontSee('ui-notification-preview-item-unread', false)
            ->assertSee('No unread notifications', false);
    }

    public function test_authorized_users_can_dismiss_a_notification(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $notification = PlatformNotification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'warning',
            'title' => 'Dismiss me',
            'body' => 'Dismiss body.',
        ]);

        $this->post("/platform/notifications/{$notification->id}/dismiss")
            ->assertRedirect();

        $this->assertNotNull($notification->fresh()->dismissed_at);

        $this->get('/platform/notifications')
            ->assertOk()
            ->assertDontSee('Dismiss me');
    }
}
