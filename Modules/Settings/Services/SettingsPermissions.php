<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Settings/Services/SettingsPermissions.php
| Purpose: Defines canonical Settings module permission keys.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Settings\Services;

final class SettingsPermissions
{
    public const VIEW = 'settings.view';
    public const UPDATE = 'settings.update';
    public const MANAGE = 'settings.manage';

    /**
     * @return list<string>
     */
    public static function all(): array
    {
        return [
            self::VIEW,
            self::UPDATE,
            self::MANAGE,
        ];
    }
}
