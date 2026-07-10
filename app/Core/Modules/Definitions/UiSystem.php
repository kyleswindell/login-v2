<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/Definitions/UiSystem.php
| Purpose: Declares UI System module ownership metadata.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules\Definitions;

use App\Core\Modules\Category;
use App\Core\Modules\Manifest;

final class UiSystem
{
    public static function manifest(): Manifest
    {
        return new Manifest(
            key: 'ui-system',
            name: 'UI System',
            type: Category::Core,
        );
    }
}
