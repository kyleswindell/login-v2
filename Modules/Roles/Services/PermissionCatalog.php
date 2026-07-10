<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Services/PermissionCatalog.php
| Purpose: Reads module-declared permission names for role seeding and display.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Services;

use App\Core\Modules\Definitions\Permission;
use App\Core\Modules\Manifest;
use App\Core\Modules\Repository;

final class PermissionCatalog
{
    public function __construct(
        private readonly Repository $modules,
    ) {
    }

    /**
     * @return list<string>
     */
    public function all(): array
    {
        return collect($this->definitions())
            ->map(fn (Permission $permission): string => $permission->key)
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    /**
     * @return list<Permission>
     */
    public function definitions(): array
    {
        return collect($this->modules->all())
            ->flatMap(fn (Manifest $module): array => $this->definitionsForModule($module))
            ->unique(fn (Permission $permission): string => $permission->key)
            ->sortBy(fn (Permission $permission): string => $permission->key)
            ->values()
            ->all();
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function grouped(): array
    {
        return collect($this->definitions())
            ->groupBy(fn (Permission $permission): string => $permission->groupKey)
            ->mapWithKeys(function ($permissions, string $group): array {
                /** @var Permission $first */
                $first = $permissions->first();

                return [
                    $group => [
                        'key' => $group,
                        'label' => $first->groupLabel,
                        'permissions' => $permissions
                            ->sortBy(fn (Permission $permission): string => $permission->label)
                            ->map(fn (Permission $permission): array => $permission->toArray())
                            ->values()
                            ->all(),
                    ],
                ];
            })
            ->sortBy(fn (array $group): string => $group['label'])
            ->all();
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    public function metadataByKey(): array
    {
        return collect($this->definitions())
            ->mapWithKeys(fn (Permission $permission): array => [
                $permission->key => $this->metadataFor($permission),
            ])
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function metadataFor(Permission $permission): array
    {
        $owner = collect($this->modules->ownersForPermission($permission->key))->first();

        return array_merge($permission->toArray(), [
            'module_key' => $owner?->key ?? $permission->groupKey,
            'module_label' => $owner?->name ?? $permission->groupLabel,
            'is_elevated' => $permission->elevated,
            'is_destructive' => $permission->destructive,
            'is_stale' => false,
        ]);
    }

    /**
     * @return list<Permission>
     */
    private function definitionsForModule(Manifest $module): array
    {
        $definitions = collect($module->permissionDefinitions)
            ->filter(fn (mixed $permission): bool => $permission instanceof Permission)
            ->keyBy(fn (Permission $permission): string => $permission->key);

        $legacy = collect($module->permissions)
            ->reject(fn (string $permission): bool => $definitions->has($permission))
            ->map(fn (string $permission): Permission => $this->legacyDefinition($module, $permission));

        return $definitions
            ->values()
            ->merge($legacy)
            ->values()
            ->all();
    }

    private function legacyDefinition(Manifest $module, string $permission): Permission
    {
        $label = str($permission)
            ->afterLast('.')
            ->replace('-', ' ')
            ->title()
            ->prepend('Legacy ')
            ->toString();

        return new Permission(
            key: $permission,
            label: $label,
            description: "Legacy permission declaration for [{$permission}].",
            groupKey: $module->key,
            groupLabel: $module->name,
            defaultRoles: [RoleCatalog::SUPER_ADMIN, RoleCatalog::ADMIN],
        );
    }
}
