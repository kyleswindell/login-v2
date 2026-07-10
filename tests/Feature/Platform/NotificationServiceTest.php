<?php

namespace Tests\Feature\Platform;

use App\Models\User;
use App\Modules\Notifications\Events\Created;
use App\Modules\Notifications\Events\Updated;
use App\Modules\Notifications\Models\Notification;
use App\Modules\Notifications\Models\UserNotificationPreference;
use App\Modules\Notifications\Services\Delivery;
use App\Modules\Notifications\Services\Notifier;
use App\Modules\Notifications\Services\NotificationTypeRegistry;
use App\Modules\Notifications\Services\Store;
use App\Modules\Roles\Notifications\Types as RoleNotificationTypes;
use App\Modules\Settings\Services\Store as SettingsStore;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_database_notifications_for_users(): void
    {
        $user = User::factory()->create();
        Event::fake([Created::class]);

        $notification = app(Delivery::class)->sendTo(
            notifiable: $user,
            moduleKey: 'notifications',
            title: 'Example notification',
            body: 'A notification body.',
            severity: 'notice',
            metadata: ['example' => true],
        );

        $this->assertInstanceOf(Notification::class, $notification);

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'notifiable_type' => User::class,
            'notifiable_id' => $user->id,
            'module_key' => 'notifications',
            'type_key' => null,
            'severity' => 'notice',
            'title' => 'Example notification',
        ]);

        Event::assertDispatched(Created::class, function (Created $event) use ($notification, $user): bool {
            return $event->userId === $user->id
                && $event->notification['id'] === $notification->id
                && $event->notification['type_key'] === null
                && $event->notification['unread_count'] === 1;
        });
    }

    public function test_registry_exposes_module_declared_notification_types(): void
    {
        $registry = app(NotificationTypeRegistry::class);
        $keys = collect($registry->all())->pluck('key')->sort()->values()->all();

        $this->assertContains('auth.password.changed', $keys);
        $this->assertContains('auth.mfa.enrolled', $keys);
        $this->assertContains(RoleNotificationTypes::ASSIGNMENTS_UPDATED, $keys);
        $this->assertContains(RoleNotificationTypes::EFFECTIVE_ACCESS_CHANGED, $keys);
        $this->assertTrue($registry->has(RoleNotificationTypes::ASSIGNMENTS_UPDATED));
        $this->assertSame('roles', $registry->get(RoleNotificationTypes::ASSIGNMENTS_UPDATED)->moduleKey());
    }

    public function test_notifier_creates_registry_backed_notifications_with_type_metadata(): void
    {
        $actor = User::factory()->create(['name' => 'Access Manager']);
        $recipient = User::factory()->create();
        Event::fake([Created::class]);

        $notification = app(Notifier::class)->send(
            type: RoleNotificationTypes::ASSIGNMENTS_UPDATED,
            recipient: $recipient,
            actor: $actor,
            subject: $recipient,
            data: [
                'body' => 'Your assigned roles were changed. Added: Admin.',
                'added_roles' => ['admin'],
                'added_role_labels' => ['Admin'],
                'removed_roles' => [],
                'removed_role_labels' => [],
            ],
        );

        $this->assertSame(RoleNotificationTypes::ASSIGNMENTS_UPDATED, $notification->type_key);
        $this->assertSame('roles', $notification->module_key);
        $this->assertSame('notice', $notification->severity);
        $this->assertSame('Role assignments updated', $notification->title);
        $this->assertSame($actor->id, $notification->metadata['actor_user_id']);
        $this->assertSame(['admin'], $notification->metadata['data']['added_roles']);

        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'notifiable_type' => User::class,
            'notifiable_id' => $recipient->id,
            'module_key' => 'roles',
            'type_key' => RoleNotificationTypes::ASSIGNMENTS_UPDATED,
            'severity' => 'notice',
        ]);

        Event::assertDispatched(Created::class, function (Created $event) use ($notification): bool {
            return $event->notification['id'] === $notification->id
                && $event->notification['type_key'] === RoleNotificationTypes::ASSIGNMENTS_UPDATED;
        });
    }

    public function test_delivery_persists_notifications_when_user_has_delivery_preferences(): void
    {
        $user = User::factory()->create();
        UserNotificationPreference::query()->create([
            'user_id' => $user->id,
            'email_enabled' => false,
            'digest_frequency' => 'never',
        ]);

        Event::fake([Created::class]);

        $notification = app(Delivery::class)->sendTo(
            notifiable: $user,
            moduleKey: 'notifications',
            title: 'Required notification',
            body: 'This should persist.',
            severity: 'notice',
        );

        $this->assertInstanceOf(Notification::class, $notification);
        $this->assertDatabaseHas('notifications', [
            'id' => $notification->id,
            'severity' => 'notice',
        ]);
        Event::assertDispatched(Created::class);
    }

    public function test_delivery_uses_configured_default_severity_and_falls_back_to_info(): void
    {
        $user = User::factory()->create();

        app(SettingsStore::class)->put('notifications', 'default_severity', 'warning');

        $notification = app(Delivery::class)->sendTo(
            notifiable: $user,
            moduleKey: 'notifications',
            title: 'Default severity notification',
            body: 'This should use the configured severity.',
        );

        $this->assertSame('warning', $notification->severity);

        app(SettingsStore::class)->put('notifications', 'default_severity', 'invalid');

        $fallback = app(Delivery::class)->sendTo(
            notifiable: $user,
            moduleKey: 'notifications',
            title: 'Fallback severity notification',
            body: 'This should use the fallback severity.',
        );

        $this->assertSame('info', $fallback->severity);
    }

    public function test_delivery_prunes_oldest_notifications_beyond_configured_limit(): void
    {
        $user = User::factory()->create();
        app(SettingsStore::class)->put('notifications', 'max_per_user', 10);

        Event::fake([Created::class]);

        $oldest = app(Delivery::class)->sendTo(
            notifiable: $user,
            moduleKey: 'notifications',
            title: 'Oldest notification',
            body: 'This should be pruned.',
            severity: 'info',
        );

        for ($index = 1; $index <= 10; $index++) {
            app(Delivery::class)->sendTo(
                notifiable: $user,
                moduleKey: 'notifications',
                title: "Notification {$index}",
                body: 'This should remain within the retention limit.',
                severity: 'info',
            );
        }

        $this->assertDatabaseMissing('notifications', ['id' => $oldest->id]);
        $this->assertSame(10, Notification::query()->whereMorphedTo('notifiable', $user)->count());
    }

    public function test_it_marks_notifications_as_read_and_dismissed(): void
    {
        $user = User::factory()->create();
        Event::fake([Updated::class]);

        $notification = app(Store::class)->sendTo(
            notifiable: $user,
            moduleKey: 'platform',
            title: 'Example notification',
            body: 'A notification body.',
        );

        app(Store::class)->markAsRead($notification);
        app(Store::class)->dismiss($notification->fresh());

        $this->assertNotNull($notification->fresh()->read_at);
        $this->assertNotNull($notification->fresh()->dismissed_at);
        Event::assertDispatchedTimes(Updated::class, 2);
    }
}
