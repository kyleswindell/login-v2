<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Services/AssignmentGuard.php
| Purpose: Owns role assignment guardrails for user-management flows.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

final class AssignmentGuard
{
    public function __construct(
        private readonly RoleCatalog $roles,
        private readonly MutationGuard $mutations,
    ) {
    }

    public function canManageUsers(?User $actor): bool
    {
        return $actor?->can('manage-platform-users') ?? false;
    }

    public function canManageTarget(?User $actor, User $target): bool
    {
        if (! $this->canManageUsers($actor)) {
            return false;
        }

        if ($actor->hasRole(RoleCatalog::SUPER_ADMIN)) {
            return true;
        }

        return ! $target->hasRole(RoleCatalog::SUPER_ADMIN);
    }

    /**
     * @param  list<string>  $roles
     */
    public function canAssignRoles(?User $actor, array $roles, ?User $target = null): bool
    {
        if (! $this->canManageUsers($actor)) {
            return false;
        }

        if ($target !== null && ! $this->canManageTarget($actor, $target)) {
            return false;
        }

        if ($actor->hasRole(RoleCatalog::SUPER_ADMIN)) {
            return true;
        }

        return ! collect($roles)->contains(fn (string $role): bool => $this->mutations->roleHasElevatedPermissions($role));
    }

    /**
     * @return Collection<int, Role>
     */
    public function assignableRolesFor(?User $actor): Collection
    {
        return Role::query()
            ->where('guard_name', 'web')
            ->get()
            ->filter(fn (Role $role): bool => $actor?->hasRole(RoleCatalog::SUPER_ADMIN) === true
                || ! $this->mutations->roleHasElevatedPermissions($role))
            ->sortBy(fn (Role $role): string => sprintf('%03d:%s', $this->roles->sortOrder($role->name), $role->name))
            ->values();
    }

    /**
     * @return list<string>
     */
    public function roleNamesFromInput(mixed $roles): array
    {
        if (! is_array($roles)) {
            return [];
        }

        $legacy = $this->roles->legacyMap();

        return collect($roles)
            ->filter(fn (mixed $role): bool => is_string($role))
            ->map(fn (string $role): string => trim($role))
            ->filter()
            ->map(fn (string $role): string => $legacy[$role] ?? $role)
            ->unique()
            ->values()
            ->all();
    }

}
