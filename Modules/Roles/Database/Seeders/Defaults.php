<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Database/Seeders/Defaults.php
| Purpose: Seeds module-declared permissions and canonical role defaults.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Database\Seeders;

use App\Modules\Roles\Services\PermissionCatalog;
use App\Modules\Roles\Services\PermissionRegistry;
use App\Modules\Roles\Services\RoleCatalog;
use App\Modules\Roles\Services\RoleMetadata;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class Defaults extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $catalog = app(PermissionCatalog::class);
        $permissionDefinitions = $catalog->definitions();
        $roles = app(RoleCatalog::class);

        $migratedRoles = $this->migrateLegacyRoles($roles->legacyMap());
        app(PermissionRegistry::class)->sync();

        $presets = $roles->permissionPresets($permissionDefinitions);

        foreach ($roles->labels() as $roleName => $label) {
            $role = Role::query()->firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            if (
                $role->wasRecentlyCreated
                || (in_array($roleName, $migratedRoles, true) && $role->permissions()->count() === 0)
            ) {
                $role->syncPermissions($presets[$roleName] ?? []);
            }
        }

        app(RoleMetadata::class)->syncDefaults();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * @param  array<string, string>  $legacyMap
     * @return list<string>
     */
    private function migrateLegacyRoles(array $legacyMap): array
    {
        $tableNames = config('permission.table_names');
        $rolePivot = config('permission.column_names.role_pivot_key') ?? 'role_id';
        $modelHasRoles = $tableNames['model_has_roles'] ?? 'model_has_roles';
        $migrated = [];

        foreach ($legacyMap as $legacyName => $canonicalName) {
            $legacyRole = Role::query()->where('name', $legacyName)->where('guard_name', 'web')->first();

            if ($legacyRole === null) {
                continue;
            }

            $canonicalRole = Role::query()->where('name', $canonicalName)->where('guard_name', 'web')->first();

            if ($canonicalRole === null) {
                $legacyRole->forceFill(['name' => $canonicalName])->save();
                $migrated[] = $canonicalName;
                continue;
            }

            foreach (DB::table($modelHasRoles)->where($rolePivot, $legacyRole->id)->get() as $assignment) {
                $row = (array) $assignment;
                $row[$rolePivot] = $canonicalRole->id;

                DB::table($modelHasRoles)->insertOrIgnore($row);
            }

            $legacyRole->delete();
            $migrated[] = $canonicalName;
        }

        return array_values(array_unique($migrated));
    }
}
