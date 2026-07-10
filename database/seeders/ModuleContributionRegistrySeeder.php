<?php

/*
|--------------------------------------------------------------------------
| File: database/seeders/ModuleContributionRegistrySeeder.php
| Purpose: Seeds synced module contribution registry projections.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace Database\Seeders;

use App\Core\Modules\ContributionRegistry;
use Illuminate\Database\Seeder;

class ModuleContributionRegistrySeeder extends Seeder
{
    public function run(): void
    {
        app(ContributionRegistry::class)->sync();
    }
}
