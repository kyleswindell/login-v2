<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/Definitions/RuntimeSecurity.php
| Purpose: Declares Runtime Security module ownership metadata.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules\Definitions;

use App\Core\Modules\Category;
use App\Core\Modules\Manifest;

final class RuntimeSecurity
{
    public static function manifest(): Manifest
    {
        return new Manifest(
            key: 'runtime-security',
            name: 'Runtime Security',
            type: Category::Core,
        );
    }
}
