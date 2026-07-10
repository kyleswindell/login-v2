<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Services/Writer.php
| Purpose: Performs audited Roles module create, update, and delete mutations.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Services;

use App\Models\User;
use App\Platform\Logging\PlatformLogger;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Models\Role;

final class Writer
{
    public function __construct(
        private readonly MutationGuard $guard,
        private readonly PermissionCatalog $permissions,
        private readonly RolePermissionResolver $resolver,
        private readonly RoleMetadata $metadata,
        private readonly PlatformLogger $logger,
    ) {
    }

    /**
     * @param  list<string>  $permissions
     */
    public function create(User $actor, string $key, string $label, ?string $description, array $permissions): Role
    {
        if (! $this->containsOnlyActivePermissions($permissions)) {
            throw new AuthorizationException;
        }

        if (! $this->guard->canCreateWithPermissions($actor, $permissions)) {
            throw new AuthorizationException;
        }

        $role = Role::query()->create([
            'name' => $key,
            'guard_name' => 'web',
        ]);

        $resolvedPermissions = $this->resolver->forCreate($actor, $permissions);

        $role->syncPermissions($resolvedPermissions);
        $this->metadata->createCustom($role, $label, $description, $actor);

        $this->record('roles.created', $actor, $role, [
            'role' => $role->name,
            'label' => $label,
            'permissions' => $resolvedPermissions,
        ]);

        return $role->refresh();
    }

    /**
     * @param  list<string>  $permissions
     */
    public function update(User $actor, Role $role, string $label, ?string $description, array $permissions): Role
    {
        if (! $this->containsOnlyActivePermissions($permissions)) {
            throw new AuthorizationException;
        }

        if (! $this->guard->canSubmitPermissionsForRole($actor, $role, $permissions)) {
            throw new AuthorizationException;
        }

        $resolvedPermissions = $this->resolver->forUpdate($actor, $role, $permissions);

        $role->syncPermissions($resolvedPermissions);
        $this->metadata->update($role, $label, $description, $actor);

        $this->record('roles.updated', $actor, $role->refresh(), [
            'role' => $role->name,
            'label' => $label,
            'permissions' => $resolvedPermissions,
        ]);

        return $role;
    }

    public function delete(User $actor, Role $role): void
    {
        if (! $this->guard->canDelete($actor, $role)) {
            throw new AuthorizationException;
        }

        $roleName = $role->name;
        $roleId = (string) $role->getKey();

        $role->delete();

        $this->logger->recordEvent(
            event: 'roles.deleted',
            metadata: ['role' => $roleName],
            actorUserId: $actor->id,
            subjectType: Role::class,
            subjectId: $roleId,
            isSecurityEvent: true,
        );
    }

    /**
     * @param  array<string, mixed>  $metadata
     */
    private function record(string $event, User $actor, Role $role, array $metadata): void
    {
        $this->logger->recordEvent(
            event: $event,
            metadata: $metadata,
            actorUserId: $actor->id,
            subjectType: Role::class,
            subjectId: (string) $role->getKey(),
            isSecurityEvent: true,
        );
    }

    /**
     * @param  list<string>  $permissions
     */
    private function containsOnlyActivePermissions(array $permissions): bool
    {
        return collect($permissions)
            ->diff($this->permissions->all())
            ->isEmpty();
    }
}
