<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Services/NotificationTypeRegistry.php
| Purpose: Exposes module-declared persistent notification type metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Services;

use App\Core\Modules\Definitions\NotificationType;
use App\Core\Modules\Repository;
use InvalidArgumentException;

final class NotificationTypeRegistry
{
    public function __construct(private readonly Repository $modules)
    {
    }

    /**
     * @return list<NotificationType>
     */
    public function all(): array
    {
        return $this->modules->notificationDefinitions();
    }

    public function get(string $key): NotificationType
    {
        return collect($this->all())
            ->first(fn (NotificationType $type): bool => $type->key === $key)
            ?? throw new InvalidArgumentException("Notification type [{$key}] is not registered.");
    }

    public function has(string $key): bool
    {
        return collect($this->all())
            ->contains(fn (NotificationType $type): bool => $type->key === $key);
    }

    /**
     * @return list<NotificationType>
     */
    public function forModule(string $moduleKey): array
    {
        return collect($this->all())
            ->filter(fn (NotificationType $type): bool => $type->moduleKey() === $moduleKey)
            ->values()
            ->all();
    }
}
