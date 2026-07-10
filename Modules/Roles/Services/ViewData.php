<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Services/ViewData.php
| Purpose: Builds Roles module view models from role and permission metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\HtmlString;
use Spatie\Permission\Models\Role;

final class ViewData
{
    public function __construct(
        private readonly RoleCatalog $roles,
        private readonly PermissionCatalog $permissions,
        private readonly MutationGuard $guard,
        private readonly RoleMetadata $metadata,
    ) {
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function roleSummaries(?User $actor): array
    {
        return Role::query()
            ->with('permissions')
            ->where('guard_name', 'web')
            ->get()
            ->sortBy(fn (Role $role): string => sprintf('%03d:%s', $this->roles->sortOrder($role->name), $role->name))
            ->map(fn (Role $role): array => $this->roleSummary($role, $actor))
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    public function roleSummary(Role $role, ?User $actor): array
    {
        $role->loadMissing('permissions');

        $permissions = $role->permissions
            ->pluck('name')
            ->sort()
            ->values()
            ->all();
        $metadata = $this->metadata->summary($role);

        return [
            'id' => $role->id,
            'key' => $role->name,
            'label' => $metadata['label'],
            'description' => $metadata['description'],
            'is_system' => $metadata['is_system'],
            'is_default' => $metadata['is_default'],
            'is_protected' => $metadata['is_protected'],
            'is_deletable' => $metadata['is_deletable'],
            'is_assignable' => $metadata['is_assignable'],
            'is_super_admin' => $this->roles->isSuperAdmin($role->name),
            'is_elevated' => $this->guard->roleHasElevatedPermissions($role),
            'assigned_users' => $this->guard->assignedUserCount($role),
            'permission_count' => count($permissions),
            'permissions' => $permissions,
            'updated_at' => $role->updated_at,
            'can_edit' => $this->guard->canEditRole($actor, $role),
            'can_delete' => $this->guard->canDelete($actor, $role),
        ];
    }

    /**
     * @return array<string, int>
     */
    public function permissionCatalogSummary(): array
    {
        $definitions = collect($this->permissions->definitions());

        return [
            'permissions' => $definitions->count(),
            'groups' => $definitions->pluck('groupKey')->unique()->count(),
            'elevated' => $definitions->filter(fn ($definition): bool => (bool) $definition->elevated)->count(),
            'stale' => $this->stalePermissionCount(),
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function permissionCatalogItems(): array
    {
        return collect($this->permissions->grouped())
            ->map(fn (array $group): array => [
                'id' => 'roles-permission-catalog-'.$group['key'],
                'title' => $group['label'],
                'meta' => trans_choice('roles::module.permissions_count', count($group['permissions']), ['count' => count($group['permissions'])]),
                'body' => new HtmlString(view('roles::partials.permission-catalog-group', [
                    'permissions' => $group['permissions'],
                ])->render()),
            ])
            ->values()
            ->all();
    }

    /**
     * @param  list<string>  $selected
     * @return list<array<string, mixed>>
     */
    public function permissionFormItems(array $selected, ?User $actor): array
    {
        return collect($this->permissions->grouped())
            ->map(fn (array $group): array => [
                'id' => 'roles-permission-form-'.$group['key'],
                'title' => $group['label'],
                'meta' => trans_choice('roles::module.permissions_count', count($group['permissions']), ['count' => count($group['permissions'])]),
                'body' => new HtmlString(view('roles::partials.permission-checkbox-group', [
                    'permissions' => $group['permissions'],
                    'selected' => $selected,
                    'canManageElevated' => $actor?->hasRole(RoleCatalog::SUPER_ADMIN) ?? false,
                ])->render()),
            ])
            ->values()
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function assignedPermissionItems(Role $role): array
    {
        $definitions = collect($this->permissions->definitions())
            ->keyBy(fn ($definition): string => $definition->key);

        return $role->permissions()
            ->pluck('name')
            ->sort()
            ->values()
            ->map(function (string $permission) use ($definitions): array {
                $definition = $definitions->get($permission);

                if ($definition !== null) {
                    return array_merge($definition->toArray(), [
                        'is_stale' => false,
                    ]);
                }

                return [
                    'key' => $permission,
                    'label' => $permission,
                    'description' => __('roles::module.stale_permission_description'),
                    'group_key' => 'stale',
                    'group_label' => __('roles::module.stale_permissions'),
                    'action' => 'unknown',
                    'elevated' => false,
                    'destructive' => false,
                    'is_stale' => true,
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function assignedUsers(Role $role): array
    {
        return $role->users()
            ->orderBy('name')
            ->get()
            ->map(fn (User $user): array => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ])
            ->all();
    }

    private function stalePermissionCount(): int
    {
        if (! Schema::hasTable('permission_registry_entries')) {
            return 0;
        }

        return DB::table('permission_registry_entries')
            ->where('is_stale', true)
            ->count();
    }
}
