<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Services/Notifier.php
| Purpose: Sends registry-backed durable notifications for domain modules.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Services;

use App\Core\Modules\Definitions\NotificationType;
use App\Models\User;
use App\Modules\Notifications\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use InvalidArgumentException;

final class Notifier
{
    public function __construct(
        private readonly NotificationTypeRegistry $types,
        private readonly Delivery $delivery,
    ) {
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function send(
        string $type,
        Model $recipient,
        ?User $actor = null,
        ?Model $subject = null,
        array $data = [],
    ): Notification {
        $definition = $this->types->get($type);

        if (! $definition->database) {
            throw new InvalidArgumentException("Notification type [{$type}] is not database-deliverable.");
        }

        return $this->delivery->sendTo(
            notifiable: $recipient,
            moduleKey: $definition->moduleKey(),
            title: $this->title($definition, $data),
            body: $this->body($definition, $data),
            severity: $this->severity($definition, $data),
            actionUrl: $this->actionUrl($definition, $data),
            metadata: $this->metadata($definition, $actor, $subject, $data),
            typeKey: $definition->key,
        );
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function title(NotificationType $definition, array $data): string
    {
        return $this->stringValue($data['title'] ?? null) ?: $definition->label;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function body(NotificationType $definition, array $data): string
    {
        return $this->stringValue($data['body'] ?? null) ?: $definition->description;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function severity(NotificationType $definition, array $data): ?string
    {
        return $this->stringValue($data['severity'] ?? null) ?: $definition->defaultSeverity;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function actionUrl(NotificationType $definition, array $data): ?string
    {
        $explicitUrl = $this->stringValue($data['action_url'] ?? null);

        if ($explicitUrl !== null) {
            return $explicitUrl;
        }

        if ($definition->actionRoute === null) {
            return null;
        }

        $parameters = $data['action_route_parameters'] ?? [];

        return route($definition->actionRoute, is_array($parameters) ? $parameters : []);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function metadata(NotificationType $definition, ?User $actor, ?Model $subject, array $data): array
    {
        return [
            'type_key' => $definition->key,
            'category' => $definition->category,
            'audience' => $definition->audience->value,
            'actor_user_id' => $actor?->getKey(),
            'subject_type' => $subject instanceof Model ? $subject::class : null,
            'subject_id' => $subject?->getKey(),
            'data' => Arr::except($data, [
                'title',
                'body',
                'severity',
                'action_url',
                'action_route_parameters',
            ]),
        ];
    }

    private function stringValue(mixed $value): ?string
    {
        return is_string($value) && trim($value) !== '' ? $value : null;
    }
}
