<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Services/Delivery.php
| Purpose: Applies delivery rules before persisting durable notifications.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Services;

use App\Modules\Notifications\Models\Notification;
use App\Modules\Settings\Services\Store as SettingsStore;
use Illuminate\Database\Eloquent\Model;

final class Delivery
{
    /**
     * @var list<string>
     */
    private const VALID_SEVERITIES = ['info', 'notice', 'success', 'warning', 'error', 'urgent'];

    public function __construct(
        private readonly Store $store,
        private readonly SettingsStore $settings,
    ) {
    }

    /**
     * @param  array<int, string>  $deliveryChannels
     * @param  array<string, mixed>  $metadata
     */
    public function sendTo(
        Model $notifiable,
        string $moduleKey,
        string $title,
        string $body,
        ?string $severity = null,
        ?string $actionUrl = null,
        array $deliveryChannels = ['database'],
        array $metadata = [],
        ?string $typeKey = null,
    ): Notification {
        $notification = $this->store->sendTo(
            notifiable: $notifiable,
            moduleKey: $moduleKey,
            title: $title,
            body: $body,
            severity: $this->resolveSeverity($severity),
            actionUrl: $actionUrl,
            deliveryChannels: $deliveryChannels,
            metadata: $metadata,
            broadcast: false,
            typeKey: $typeKey,
        );

        $this->pruneOldest($notification);
        $this->store->broadcastCreated($notification->refresh());

        return $notification;
    }

    /**
     * @return array<string, mixed>
     */
    public function payloadFor(Notification $notification): array
    {
        return $this->store->payloadFor($notification);
    }

    private function resolveSeverity(?string $severity): string
    {
        if ($severity !== null && in_array($severity, self::VALID_SEVERITIES, true)) {
            return $severity;
        }

        $configured = $this->settings->get('notifications', 'default_severity', 'info');

        return is_string($configured) && in_array($configured, self::VALID_SEVERITIES, true)
            ? $configured
            : 'info';
    }

    private function maxPerUser(): int
    {
        $configured = $this->settings->get('notifications', 'max_per_user', 100);
        $limit = is_numeric($configured) ? (int) $configured : 100;

        return $limit >= 10 && $limit <= 10000 ? $limit : 100;
    }

    private function pruneOldest(Notification $notification): void
    {
        $limit = $this->maxPerUser();

        $ids = Notification::query()
            ->where('notifiable_type', $notification->notifiable_type)
            ->where('notifiable_id', $notification->notifiable_id)
            ->latest('created_at')
            ->latest('id')
            ->skip($limit)
            ->pluck('id');

        if ($ids->isEmpty()) {
            return;
        }

        Notification::query()
            ->whereIn('id', $ids)
            ->delete();
    }
}
