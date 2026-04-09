<?php

namespace App\Platform\Notifications;

use App\Models\PlatformNotification;
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
        return PlatformNotification::query()->create([
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
    }

    public function markAsRead(PlatformNotification $notification): PlatformNotification
    {
        $notification->forceFill([
            'read_at' => $notification->read_at ?? now(),
        ])->save();

        return $notification->refresh();
    }

    public function dismiss(PlatformNotification $notification): PlatformNotification
    {
        $notification->forceFill([
            'dismissed_at' => $notification->dismissed_at ?? now(),
        ])->save();

        return $notification->refresh();
    }
}
