<?php

/*
|--------------------------------------------------------------------------
| File: database/seeders/PlatformRolesAndPermissionsSeeder.php
| Purpose: Compatibility wrapper for the Roles module default seeder.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Database\Seeders;

use App\Modules\Roles\Database\Seeders\Defaults;
use Illuminate\Database\Seeder;

class PlatformRolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(Defaults::class);
    }
}
