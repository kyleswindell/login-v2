<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/Category.php
| Purpose: Declares module category values for module metadata.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules;


enum Category: string
{
    case Core = 'core';
    case Shared = 'shared';
    case PlatformManagement = 'platform_management';
}
