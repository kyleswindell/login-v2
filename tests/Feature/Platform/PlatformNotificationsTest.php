<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Modules\Notifications\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformNotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_users_can_view_their_notifications(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'notice',
            'title' => 'Review needed',
            'body' => 'A notification body.',
            'action_url' => '/dashboard',
        ]);

        $this->get('/notifications')
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
            ->assertRedirect('/notifications');
    }

    public function test_authorized_users_can_view_notifications_setup_page(): void
    {
        $this->actingAsPlatformSuperAdmin();

        $this->get('/platform/setup/notifications')
            ->assertOk()
            ->assertSee('Notifications Setup');
    }

    public function test_notification_index_only_shows_current_user_notifications(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();
        $otherUser = User::factory()->create();

        Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Visible notification',
            'body' => 'Visible body.',
        ]);

        Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $otherUser->id,
            'module_key' => 'platform',
            'severity' => 'warning',
            'title' => 'Hidden notification',
            'body' => 'Hidden body.',
        ]);

        $this->get('/notifications')
            ->assertOk()
            ->assertSee('Visible notification')
            ->assertDontSee('Hidden notification');
    }

    public function test_standard_users_cannot_access_platform_notifications(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/notifications')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/platform/notifications')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/platform/administration/notifications')
            ->assertForbidden();

        $this->actingAs($user)
            ->get('/platform/setup/notifications')
            ->assertForbidden();
    }

    public function test_authorized_users_can_mark_a_notification_as_read(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $notification = Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Read me',
            'body' => 'Read body.',
        ]);

        $this->post("/notifications/{$notification->id}/read")
            ->assertRedirect();

        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_users_cannot_mark_other_user_notifications_as_read(): void
    {
        $this->actingAsPlatformSuperAdmin();
        $otherUser = User::factory()->create();

        $notification = Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $otherUser->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Protected',
            'body' => 'Protected body.',
        ]);

        $this->post("/notifications/{$notification->id}/read")
            ->assertNotFound();
    }

    public function test_authorized_users_can_mark_all_their_notifications_as_read(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();
        $otherUser = User::factory()->create();

        $ownedNotification = Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Owned notification',
            'body' => 'Owned body.',
        ]);

        $otherNotification = Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $otherUser->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Other notification',
            'body' => 'Other body.',
        ]);

        $this->post('/notifications/mark-all-read')
            ->assertRedirect();

        $this->assertNotNull($ownedNotification->fresh()->read_at);
        $this->assertNull($otherNotification->fresh()->read_at);
    }

    public function test_mark_all_read_returns_json_for_runtime_updates(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $ownedNotification = Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'notice',
            'title' => 'Unread notification',
            'body' => 'Unread body.',
        ]);

        $this->postJson('/notifications/mark-all-read')
            ->assertOk()
            ->assertJson([
                'status' => 'All notifications marked as read.',
                'unread_count' => 0,
                'marked_notification_ids' => [$ownedNotification->id],
            ]);

        $this->assertNotNull($ownedNotification->fresh()->read_at);
    }

    public function test_notification_trigger_uses_unread_state_treatment_when_unread_notifications_exist(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'notice',
            'title' => 'Unread notification',
            'body' => 'Unread body.',
        ]);

        $this->get('/notifications')
            ->assertOk()
            ->assertSee('data-notification-trigger', false)
            ->assertSee('data-notification-trigger-unread="true"', false)
            ->assertSee('data-notification-trigger-badge-hidden="false"', false)
            ->assertSee('data-notification-mark-all-enabled="true"', false)
            ->assertSee('data-notification-mark-all-form', false)
            ->assertSee('data-notification-preview-unread', false)
            ->assertSee('data-notification-preview-item-unread="true"', false)
            ->assertSee('data-notification-preview-severity="notice"', false)
            ->assertSee('1 unread notifications', false)
            ->assertSee('Mark all as read', false)
            ->assertSee('data-notification-trigger-summary', false);
    }

    public function test_notification_trigger_uses_subdued_state_when_no_unread_notifications_exist(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'info',
            'title' => 'Already read notification',
            'body' => 'Read body.',
            'read_at' => now(),
        ]);

        $this->get('/notifications')
            ->assertOk()
            ->assertSee('data-notification-trigger-unread="false"', false)
            ->assertSee('data-notification-trigger-badge-hidden="true"', false)
            ->assertSee('data-notification-mark-all-enabled="false"', false)
            ->assertSee('data-notification-preview-item-unread="false"', false)
            ->assertDontSee('data-notification-preview-unread', false)
            ->assertSee('No unread notifications', false);
    }

    public function test_authorized_users_can_dismiss_a_notification(): void
    {
        $user = $this->actingAsPlatformSuperAdmin();

        $notification = Notification::query()->create([
            'uuid' => (string) fake()->uuid(),
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'warning',
            'title' => 'Dismiss me',
            'body' => 'Dismiss body.',
        ]);

        $this->post("/notifications/{$notification->id}/dismiss")
            ->assertRedirect();

        $this->assertNotNull($notification->fresh()->dismissed_at);

        $this->get('/notifications')
            ->assertOk()
            ->assertDontSee('Dismiss me');
    }
}
