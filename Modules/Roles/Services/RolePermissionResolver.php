<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Services/RolePermissionResolver.php
| Purpose: Resolves submitted role permissions into the final persisted set.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;

final class RolePermissionResolver
{
    public function __construct(
        private readonly MutationGuard $guard,
        private readonly PermissionCatalog $permissions,
    ) {
    }

    /**
     * @param  list<string>  $requestedPermissions
     * @return list<string>
     */
    public function forCreate(?User $actor, array $requestedPermissions): array
    {
        return $this->normalize($requestedPermissions);
    }

    /**
     * @param  list<string>  $requestedPermissions
     * @return list<string>
     */
    public function forUpdate(?User $actor, Role $role, array $requestedPermissions): array
    {
        return $this->normalize(
            collect($this->guard->preservedElevatedPermissions($actor, $role->refresh(), $requestedPermissions))
                ->merge($this->assignedStalePermissions($role))
                ->all()
        );
    }

    /**
     * @param  list<string>  $permissions
     * @return list<string>
     */
    public function normalize(array $permissions): array
    {
        return collect($permissions)
            ->filter(fn (mixed $permission): bool => is_string($permission))
            ->map(fn (string $permission): string => trim($permission))
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    private function assignedStalePermissions(Role $role): array
    {
        $active = collect($this->permissions->all());

        return $role->permissions()
            ->pluck('name')
            ->diff($active)
            ->values()
            ->all();
    }
}
