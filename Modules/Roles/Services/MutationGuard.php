<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Services/MutationGuard.php
| Purpose: Applies Roles module mutation and elevated-permission guardrails.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;

final class MutationGuard
{
    public function __construct(
        private readonly RoleCatalog $roles,
        private readonly PermissionCatalog $permissions,
        private readonly RoleMetadata $metadata,
    ) {
    }

    public function canManageRoles(?User $actor): bool
    {
        return $actor?->can(RoleCatalog::MANAGE) ?? false;
    }

    public function canCreateRole(?User $actor): bool
    {
        return $actor?->can(RoleCatalog::CREATE) ?? false;
    }

    public function canEditRole(?User $actor, Role $role): bool
    {
        return ($actor?->can(RoleCatalog::UPDATE) ?? false)
            && ! $this->roles->isSuperAdmin($role->name);
    }

    public function canRename(Role $role): bool
    {
        return false;
    }

    public function canDelete(?User $actor, Role $role): bool
    {
        return ($actor?->can(RoleCatalog::DELETE) ?? false)
            && $this->deleteBlockers($role) === [];
    }

    /**
     * @return list<string>
     */
    public function deleteBlockers(Role $role): array
    {
        $metadata = $this->metadata->summary($role);
        $blockers = [];

        if ($metadata['is_system']) {
            $blockers[] = 'system_role';
        }

        if ($metadata['is_protected']) {
            $blockers[] = 'protected_role';
        }

        if (! $metadata['is_deletable']) {
            $blockers[] = 'not_deletable';
        }

        if ($this->assignedUserCount($role) > 0) {
            $blockers[] = 'assigned_users';
        }

        if ($this->isLastRolesManager($role)) {
            $blockers[] = 'last_roles_manager';
        }

        return array_values(array_unique($blockers));
    }

    public function canSubmitPermissionsForRole(?User $actor, Role $role, array $requestedPermissions): bool
    {
        if (! $this->canEditRole($actor, $role)) {
            return false;
        }

        if ($actor?->hasRole(RoleCatalog::SUPER_ADMIN)) {
            return true;
        }

        $existingElevated = $this->elevatedPermissionsForRole($role);
        $requestedElevated = collect($requestedPermissions)
            ->filter(fn (string $permission): bool => $this->isElevatedPermission($permission))
            ->values();

        return $requestedElevated
            ->diff($existingElevated)
            ->isEmpty();
    }

    public function canCreateWithPermissions(?User $actor, array $requestedPermissions): bool
    {
        if (! $this->canCreateRole($actor)) {
            return false;
        }

        if ($actor?->hasRole(RoleCatalog::SUPER_ADMIN)) {
            return true;
        }

        return ! collect($requestedPermissions)
            ->contains(fn (string $permission): bool => $this->isElevatedPermission($permission));
    }

    public function isElevatedPermission(string $permission): bool
    {
        return collect($this->permissions->definitions())
            ->contains(fn ($definition): bool => $definition->key === $permission && $definition->elevated);
    }

    public function roleHasElevatedPermissions(Role|string $role): bool
    {
        $roleName = $role instanceof Role ? $role->name : $role;

        if ($this->roles->isSuperAdmin($roleName)) {
            return true;
        }

        $roleModel = $role instanceof Role
            ? $role
            : Role::query()->where('name', $roleName)->where('guard_name', 'web')->first();

        if (! $roleModel instanceof Role) {
            return false;
        }

        return collect($this->elevatedPermissionsForRole($roleModel))->isNotEmpty();
    }

    public function assignedUserCount(Role $role): int
    {
        return $role->users()->count();
    }

    /**
     * @return list<string>
     */
    public function preservedElevatedPermissions(?User $actor, Role $role, array $requestedPermissions): array
    {
        if ($actor?->hasRole(RoleCatalog::SUPER_ADMIN)) {
            return $requestedPermissions;
        }

        return collect($requestedPermissions)
            ->merge($this->elevatedPermissionsForRole($role))
            ->unique()
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    private function elevatedPermissionsForRole(Role $role): array
    {
        return $role->permissions()
            ->pluck('name')
            ->filter(fn (string $permission): bool => $this->isElevatedPermission($permission))
            ->values()
            ->all();
    }

    private function isLastRolesManager(Role $role): bool
    {
        if (! $role->hasPermissionTo(RoleCatalog::MANAGE)) {
            return false;
        }

        return ! Role::query()
            ->where('guard_name', 'web')
            ->whereKeyNot($role->getKey())
            ->whereHas('permissions', fn ($query) => $query->where('name', RoleCatalog::MANAGE))
            ->exists();
    }
}
