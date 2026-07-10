<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Services/PermissionRegistry.php
| Purpose: Syncs module-declared permissions into Spatie and registry storage.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Services;

use App\Core\Modules\Definitions\Permission as PermissionDefinition;
use App\Core\Modules\Manifest;
use App\Core\Modules\Repository;
use App\Modules\Notifications\Services\NotificationPermissions;
use App\Modules\Settings\Services\SettingsPermissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

final class PermissionRegistry
{
    /**
     * @var array<string, list<string>>
     */
    private const LEGACY_PERMISSION_MAP = [
        'platform.roles.view' => [RoleCatalog::VIEW, RoleCatalog::PERMISSIONS_VIEW],
        'platform.roles.manage' => [RoleCatalog::MANAGE],
        'platform.notifications.view' => [NotificationPermissions::VIEW],
        'platform.settings.view' => [SettingsPermissions::VIEW],
        'platform.settings.manage' => [SettingsPermissions::MANAGE],
    ];

    public function __construct(
        private readonly Repository $modules,
        private readonly PermissionCatalog $catalog,
    ) {
    }

    /**
     * @return array<string, int>
     */
    public function sync(): array
    {
        $definitions = $this->catalog->definitions();
        $permissionIds = [];

        foreach ($definitions as $definition) {
            $permission = Permission::query()->firstOrCreate([
                'name' => $definition->key,
                'guard_name' => 'web',
            ]);

            $permissionIds[$definition->key] = $permission->id;
        }

        $migratedAssignments = $this->migrateLegacyRolePermissions();
        $syncedRegistryRows = $this->syncRegistryRows($definitions, $permissionIds);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return [
            'permissions' => count($definitions),
            'registry_rows' => $syncedRegistryRows,
            'migrated_assignments' => $migratedAssignments,
        ];
    }

    /**
     * @param  list<PermissionDefinition>  $definitions
     * @param  array<string, int>  $permissionIds
     */
    private function syncRegistryRows(array $definitions, array $permissionIds): int
    {
        if (! Schema::hasTable('permission_registry_entries')) {
            return 0;
        }

        $now = now();
        $activeKeys = collect($definitions)->map(fn (PermissionDefinition $definition): string => $definition->key)->all();

        DB::table('permission_registry_entries')
            ->whereNotIn('key', $activeKeys)
            ->update([
                'is_active' => false,
                'is_stale' => true,
                'updated_at' => $now,
            ]);

        foreach ($definitions as $definition) {
            $owner = $this->ownerForPermission($definition->key);

            DB::table('permission_registry_entries')->updateOrInsert(
                ['key' => $definition->key],
                [
                    'permission_id' => $permissionIds[$definition->key] ?? null,
                    'module_key' => $owner?->key ?? $definition->groupKey,
                    'group_key' => $definition->groupKey,
                    'group_label' => $definition->groupLabel,
                    'action' => $definition->action(),
                    'label' => $definition->label,
                    'description' => $definition->description,
                    'is_elevated' => $definition->elevated,
                    'is_destructive' => $definition->destructive,
                    'is_active' => true,
                    'is_stale' => false,
                    'source_hash' => $this->sourceHash($definition, $owner),
                    'synced_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }

        return count($definitions);
    }

    private function migrateLegacyRolePermissions(): int
    {
        $tableNames = config('permission.table_names');
        $roleHasPermissions = $tableNames['role_has_permissions'] ?? 'role_has_permissions';
        $modelHasPermissions = $tableNames['model_has_permissions'] ?? 'model_has_permissions';
        $pivotPermission = config('permission.column_names.permission_pivot_key') ?? 'permission_id';

        $migrated = 0;

        foreach (self::LEGACY_PERMISSION_MAP as $legacyName => $targetNames) {
            $legacyPermission = Permission::query()
                ->where('name', $legacyName)
                ->where('guard_name', 'web')
                ->first();

            if (! $legacyPermission instanceof Permission) {
                continue;
            }

            foreach ($targetNames as $targetName) {
                $targetPermission = Permission::query()
                    ->where('name', $targetName)
                    ->where('guard_name', 'web')
                    ->first();

                if (! $targetPermission instanceof Permission) {
                    continue;
                }

                foreach (DB::table($roleHasPermissions)->where($pivotPermission, $legacyPermission->id)->get() as $assignment) {
                    $row = (array) $assignment;
                    $row[$pivotPermission] = $targetPermission->id;

                    $migrated += DB::table($roleHasPermissions)->insertOrIgnore($row);
                }

                foreach (DB::table($modelHasPermissions)->where($pivotPermission, $legacyPermission->id)->get() as $assignment) {
                    $row = (array) $assignment;
                    $row[$pivotPermission] = $targetPermission->id;

                    $migrated += DB::table($modelHasPermissions)->insertOrIgnore($row);
                }
            }

            $legacyPermission->delete();
        }

        return $migrated;
    }

    private function ownerForPermission(string $permission): ?Manifest
    {
        return collect($this->modules->ownersForPermission($permission))->first();
    }

    private function sourceHash(PermissionDefinition $definition, ?Manifest $owner): string
    {
        return hash('sha256', json_encode([
            'module' => $owner?->key,
            'permission' => $definition->toArray(),
        ], JSON_THROW_ON_ERROR));
    }
}
