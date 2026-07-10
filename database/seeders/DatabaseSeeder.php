<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Roles\Services\RoleCatalog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            PlatformRolesAndPermissionsSeeder::class,
            ModuleContributionRegistrySeeder::class,
            SecurityRequirementSeeder::class,
        ]);

        if (! app()->environment('local')) {
            return;
        }

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user->assignRole(RoleCatalog::SUPER_ADMIN);
    }
}
