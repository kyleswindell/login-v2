<?php

namespace App\Platform\Notifications;

use App\Events\PlatformNotificationCreated;
use App\Events\PlatformNotificationUpdated;
use App\Models\PlatformNotification;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NotificationService
{
    /**
     * @param  array<int, string>  $deliveryChannels
     * @param  array<string, mixed>  $metadata
     */
    public function sendTo(
        Model $notifiable,
        string $moduleKey,
        string $title,
        string $body,
        string $severity = 'info',
        ?string $actionUrl = null,
        array $deliveryChannels = ['database'],
        array $metadata = [],
    ): PlatformNotification {
        $notification = PlatformNotification::query()->create([
            'uuid' => (string) Str::uuid(),
            'notifiable_type' => $notifiable::class,
            'notifiable_id' => $notifiable->getKey(),
            'module_key' => $moduleKey,
            'severity' => $severity,
            'title' => $title,
            'body' => $body,
            'action_url' => $actionUrl,
            'delivery_channels' => $deliveryChannels,
            'metadata' => $metadata,
        ]);

        $this->broadcastCreated($notification);

        return $notification;
    }

    public function markAsRead(PlatformNotification $notification): PlatformNotification
    {
        $notification->forceFill([
            'read_at' => $notification->read_at ?? now(),
        ])->save();

        $notification = $notification->refresh();
        $this->broadcastUpdated($notification);

        return $notification;
    }

    public function dismiss(PlatformNotification $notification): PlatformNotification
    {
        $notification->forceFill([
            'dismissed_at' => $notification->dismissed_at ?? now(),
        ])->save();

        $notification = $notification->refresh();
        $this->broadcastUpdated($notification);

        return $notification;
    }

    private function broadcastCreated(PlatformNotification $notification): void
    {
        $userId = $this->broadcastUserId($notification);

        if (! $userId) {
            return;
        }

        event(new PlatformNotificationCreated($userId, $this->payload($notification)));
    }

    private function broadcastUpdated(PlatformNotification $notification): void
    {
        $userId = $this->broadcastUserId($notification);

        if (! $userId) {
            return;
        }

        event(new PlatformNotificationUpdated($userId, $this->payload($notification)));
    }

    private function broadcastUserId(PlatformNotification $notification): ?int
    {
        if ($notification->notifiable_type !== User::class) {
            return null;
        }

        return (int) $notification->notifiable_id;
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(PlatformNotification $notification): array
    {
        return [
            'id' => $notification->id,
            'uuid' => $notification->uuid,
            'module_key' => $notification->module_key,
            'severity' => $notification->severity,
            'title' => $notification->title,
            'body' => $notification->body,
            'action_url' => $notification->action_url ?: route('platform.administration.notifications.index'),
            'read_at' => $notification->read_at?->toIso8601String(),
            'dismissed_at' => $notification->dismissed_at?->toIso8601String(),
            'created_at' => $notification->created_at?->toIso8601String(),
            'created_at_label' => $notification->created_at?->format('M j, g:i A'),
            'unread_count' => PlatformNotification::query()
                ->where('notifiable_type', $notification->notifiable_type)
                ->where('notifiable_id', $notification->notifiable_id)
                ->whereNull('read_at')
                ->count(),
            'mark_read_url' => route('platform.notifications.mark-read', $notification),
            'dismiss_url' => route('platform.notifications.dismiss', $notification),
            'index_url' => route('platform.administration.notifications.index'),
        ];
    }
}
