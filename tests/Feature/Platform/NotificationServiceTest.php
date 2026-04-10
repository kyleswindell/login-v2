<?php

namespace Tests\Feature\Platform;

use App\Events\PlatformNotificationCreated;
use App\Events\PlatformNotificationUpdated;
use App\Models\PlatformNotification;
use App\Models\User;
use App\Platform\Notifications\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_database_notifications_for_users(): void
    {
        $user = User::factory()->create();
        Event::fake([PlatformNotificationCreated::class]);

        $notification = app(NotificationService::class)->sendTo(
            notifiable: $user,
            moduleKey: 'platform',
            title: 'Example notification',
            body: 'A notification body.',
            severity: 'notice',
            metadata: ['example' => true],
        );

        $this->assertInstanceOf(PlatformNotification::class, $notification);

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'platform',
            'severity' => 'notice',
            'title' => 'Example notification',
        ]);

        Event::assertDispatched(PlatformNotificationCreated::class, function (PlatformNotificationCreated $event) use ($notification, $user): bool {
            return $event->userId === $user->id
                && $event->notification['id'] === $notification->id
                && $event->notification['unread_count'] === 1;
        });
    }

    public function test_it_marks_notifications_as_read_and_dismissed(): void
    {
        $user = User::factory()->create();
        Event::fake([PlatformNotificationUpdated::class]);

        $notification = app(NotificationService::class)->sendTo(
            notifiable: $user,
            moduleKey: 'platform',
            title: 'Example notification',
            body: 'A notification body.',
        );

        app(NotificationService::class)->markAsRead($notification);
        app(NotificationService::class)->dismiss($notification->fresh());

        $this->assertNotNull($notification->fresh()->read_at);
        $this->assertNotNull($notification->fresh()->dismissed_at);
        Event::assertDispatchedTimes(PlatformNotificationUpdated::class, 2);
    }
}
