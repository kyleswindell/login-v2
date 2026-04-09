<?php

namespace Tests\Feature\Platform;

use App\Models\PlatformNotification;
use App\Models\User;
use App\Platform\Notifications\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_database_notifications_for_users(): void
    {
        $user = User::factory()->create();

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
    }

    public function test_it_marks_notifications_as_read_and_dismissed(): void
    {
        $user = User::factory()->create();

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
    }
}
