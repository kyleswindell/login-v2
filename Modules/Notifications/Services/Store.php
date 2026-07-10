<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Services/Store.php
| Purpose: Creates and updates app-instance notification records.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Services;

use App\Models\User;
use App\Modules\Notifications\Events\Created;
use App\Modules\Notifications\Events\Updated;
use App\Modules\Notifications\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class Store
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
        bool $broadcast = true,
        ?string $typeKey = null,
    ): Notification {
        $notification = Notification::query()->create([
            'uuid' => (string) Str::uuid(),
            'notifiable_type' => $notifiable::class,
            'notifiable_id' => $notifiable->getKey(),
            'module_key' => $moduleKey,
            'type_key' => $typeKey,
            'severity' => $severity,
            'title' => $title,
            'body' => $body,
            'action_url' => $actionUrl,
            'delivery_channels' => $deliveryChannels,
            'metadata' => $metadata,
        ]);

        if ($broadcast) {
            $this->broadcastCreated($notification);
        }

        return $notification;
    }

    public function markAsRead(Notification $notification): Notification
    {
        $notification->forceFill([
            'read_at' => $notification->read_at ?? now(),
        ])->save();

        $notification = $notification->refresh();
        $this->broadcastUpdated($notification);

        return $notification;
    }

    public function dismiss(Notification $notification): Notification
    {
        $notification->forceFill([
            'dismissed_at' => $notification->dismissed_at ?? now(),
        ])->save();

        $notification = $notification->refresh();
        $this->broadcastUpdated($notification);

        return $notification;
    }

    /**
     * @return array<string, mixed>
     */
    public function payloadFor(Notification $notification): array
    {
        return $this->payload($notification);
    }

    public function broadcastCreated(Notification $notification): void
    {
        $userId = $this->broadcastUserId($notification);

        if (! $userId) {
            return;
        }

        event(new Created($userId, $this->payload($notification)));
    }

    private function broadcastUpdated(Notification $notification): void
    {
        $userId = $this->broadcastUserId($notification);

        if (! $userId) {
            return;
        }

        event(new Updated($userId, $this->payload($notification)));
    }

    private function broadcastUserId(Notification $notification): ?int
    {
        if ($notification->notifiable_type !== User::class) {
            return null;
        }

        return (int) $notification->notifiable_id;
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(Notification $notification): array
    {
        return [
            'id' => $notification->id,
            'uuid' => $notification->uuid,
            'module_key' => $notification->module_key,
            'type_key' => $notification->type_key,
            'severity' => $notification->severity,
            'title' => $notification->title,
            'body' => $notification->body,
            'action_url' => $notification->action_url ?: route('notifications.index'),
            'read_at' => $notification->read_at?->toIso8601String(),
            'dismissed_at' => $notification->dismissed_at?->toIso8601String(),
            'created_at' => $notification->created_at?->toIso8601String(),
            'created_at_label' => $notification->created_at?->format('M j, g:i A'),
            'unread_count' => Notification::query()
                ->where('notifiable_type', $notification->notifiable_type)
                ->where('notifiable_id', $notification->notifiable_id)
                ->whereNull('read_at')
                ->whereNull('dismissed_at')
                ->count(),
            'mark_read_url' => route('notifications.mark-read', $notification),
            'dismiss_url' => route('notifications.dismiss', $notification),
            'index_url' => route('notifications.index'),
        ];
    }
}
