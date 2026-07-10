<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Services/NotificationPermissions.php
| Purpose: Defines canonical Notifications module permission keys.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Services;

final class NotificationPermissions
{
    public const VIEW = 'notifications.view';
    public const SETTINGS_VIEW = 'notifications.settings.view';
    public const SETTINGS_UPDATE = 'notifications.settings.update';
    public const MANAGE = 'notifications.manage';

    /**
     * @return list<string>
     */
    public static function all(): array
    {
        return [
            self::VIEW,
            self::SETTINGS_VIEW,
            self::SETTINGS_UPDATE,
            self::MANAGE,
        ];
    }
}
