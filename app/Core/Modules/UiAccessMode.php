<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/UiAccessMode.php
| Purpose: Declares access modes for module UI entries.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules;


enum UiAccessMode: string
{
    case Public = 'public';
    case Authenticated = 'authenticated';
    case Permission = 'permission';
    case Ability = 'ability';
}
