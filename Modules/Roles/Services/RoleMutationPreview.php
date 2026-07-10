<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Services/RoleMutationPreview.php
| Purpose: Builds table-ready confirmation payloads for role mutations.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;

final class RoleMutationPreview
{
    public function __construct(
        private readonly RoleCatalog $roles,
        private readonly PermissionCatalog $permissions,
        private readonly MutationGuard $guard,
        private readonly RoleMetadata $metadata,
        private readonly RolePermissionResolver $resolver,
    ) {
    }

    /**
     * @param  list<string>  $requestedPermissions
     * @return array<string, mixed>
     */
    public function forCreate(User $actor, string $key, string $label, ?string $description, array $requestedPermissions): array
    {
        $resolvedPermissions = $this->resolver->forCreate($actor, $requestedPermissions);
        $permissionRows = collect($resolvedPermissions)
            ->map(fn (string $permission): array => $this->permissionChangeRow($permission, 'enabled', 'Added to role'))
            ->values()
            ->all();

        return [
            'operation' => 'create',
            'variant' => 'confirmation',
            'status' => $this->statusForRows($permissionRows),
            'subject' => [
                'type' => 'role',
                'id' => null,
                'key' => $key,
                'label' => $label,
                'description' => $description,
                'assignedUsers' => 0,
                'permissionCountBefore' => 0,
                'permissionCountAfter' => count($resolvedPermissions),
                'isSystem' => false,
                'isCustom' => true,
                'isElevated' => $this->hasElevatedPermission($resolvedPermissions),
                'canDelete' => false,
            ],
            'permissionChangeRows' => $permissionRows,
            'impactRows' => $this->createImpactRows($permissionRows),
            'blockerRows' => [],
        ];
    }

    /**
     * @param  list<string>  $requestedPermissions
     * @return array<string, mixed>
     */
    public function forUpdate(User $actor, Role $role, string $label, ?string $description, array $requestedPermissions): array
    {
        $role->loadMissing('permissions');

        $currentPermissions = $role->permissions
            ->pluck('name')
            ->sort()
            ->values();

        $requested = collect($this->resolver->normalize($requestedPermissions));
        $resolved = collect($this->resolver->forUpdate($actor, $role, $requestedPermissions));
        $metadata = $this->metadata->summary($role);

        $added = $resolved->diff($currentPermissions);
        $removed = $currentPermissions->diff($resolved);
        $preserved = $resolved
            ->intersect($currentPermissions)
            ->diff($requested)
            ->values();

        $permissionRows = collect()
            ->merge($added->map(fn (string $permission): array => $this->permissionChangeRow($permission, 'enabled', 'Added to role')))
            ->merge($removed->map(fn (string $permission): array => $this->permissionChangeRow($permission, 'disabled', 'Removed from role')))
            ->merge($preserved->map(function (string $permission): array {
                $details = $this->permissionDetails($permission);

                return $this->permissionChangeRow(
                    $permission,
                    $details['isStale'] ? 'stale' : 'preserved',
                    $details['isStale'] ? 'Preserved stale assignment' : 'Preserved on role'
                );
            }))
            ->sortBy(fn (array $row): string => "{$row['change']}|{$row['permission']}")
            ->values()
            ->all();

        return [
            'operation' => 'update',
            'variant' => 'confirmation',
            'status' => $this->statusForRows($permissionRows),
            'subject' => [
                'type' => 'role',
                'id' => $role->id,
                'key' => $role->name,
                'label' => $label,
                'description' => $description,
                'assignedUsers' => $this->guard->assignedUserCount($role),
                'permissionCountBefore' => $currentPermissions->count(),
                'permissionCountAfter' => $resolved->count(),
                'isSystem' => (bool) $metadata['is_system'],
                'isCustom' => ! (bool) $metadata['is_system'],
                'isElevated' => $this->hasElevatedPermission($resolved->all()),
                'canDelete' => $this->guard->canDelete($actor, $role),
            ],
            'permissionChangeRows' => $permissionRows,
            'impactRows' => $this->updateImpactRows($role, $metadata, $label, $description, $permissionRows),
            'blockerRows' => [],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function forDelete(User $actor, Role $role): array
    {
        $role->loadMissing('permissions');

        $metadata = $this->metadata->summary($role);
        $permissionKeys = $role->permissions->pluck('name')->sort()->values()->all();
        $assignedUsers = $this->guard->assignedUserCount($role);
        $blockerRows = $this->deleteBlockerRows($actor, $role);
        $isBlocked = $blockerRows !== [];

        return [
            'operation' => 'delete',
            'variant' => $isBlocked ? 'blocked' : 'destructive',
            'status' => $isBlocked ? 'error' : 'warning',
            'subject' => [
                'type' => 'role',
                'id' => $role->id,
                'key' => $role->name,
                'label' => $metadata['label'],
                'description' => $metadata['description'],
                'assignedUsers' => $assignedUsers,
                'permissionCountBefore' => count($permissionKeys),
                'permissionCountAfter' => 0,
                'isSystem' => (bool) $metadata['is_system'],
                'isCustom' => ! (bool) $metadata['is_system'],
                'isElevated' => $this->guard->roleHasElevatedPermissions($role),
                'canDelete' => ! $isBlocked,
            ],
            'permissionChangeRows' => [],
            'impactRows' => $this->deleteImpactRows($role, $metadata, $assignedUsers, count($permissionKeys)),
            'blockerRows' => $blockerRows,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function permissionDetails(string $permission): array
    {
        $metadata = $this->permissions->metadataByKey()[$permission] ?? null;

        if ($metadata === null) {
            return [
                'key' => $permission,
                'label' => $permission,
                'description' => __('roles::module.stale_permission_description'),
                'moduleKey' => 'stale',
                'moduleLabel' => __('roles::module.stale_permissions'),
                'groupKey' => 'stale',
                'groupLabel' => __('roles::module.stale_permissions'),
                'action' => 'unknown',
                'isElevated' => false,
                'isDestructive' => false,
                'isStale' => true,
            ];
        }

        return [
            'key' => $metadata['key'],
            'label' => $metadata['label'],
            'description' => $metadata['description'],
            'moduleKey' => $metadata['module_key'],
            'moduleLabel' => $metadata['module_label'],
            'groupKey' => $metadata['group_key'],
            'groupLabel' => $metadata['group_label'],
            'action' => $metadata['action'],
            'isElevated' => (bool) $metadata['is_elevated'],
            'isDestructive' => (bool) $metadata['is_destructive'],
            'isStale' => (bool) $metadata['is_stale'],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function permissionChangeRow(string $permission, string $change, string $result): array
    {
        $details = $this->permissionDetails($permission);

        return array_merge([
            'change' => $change,
            'permission' => $details['label'],
            'area' => $details['groupLabel'],
            'accessLevel' => $this->accessLevel($details),
            'result' => $result,
        ], $details);
    }

    /**
     * @param  array<string, mixed>  $details
     */
    private function accessLevel(array $details): string
    {
        if ($details['isStale']) {
            return 'Stale';
        }

        if ($details['isDestructive']) {
            return 'Destructive';
        }

        if ($details['isElevated']) {
            return 'Elevated';
        }

        return 'Standard';
    }

    /**
     * @param  list<array<string, mixed>>  $rows
     */
    private function statusForRows(array $rows): string
    {
        return collect($rows)->contains(fn (array $row): bool => (bool) $row['isElevated'] || (bool) $row['isDestructive'] || (bool) $row['isStale'])
            ? 'warning'
            : 'info';
    }

    /**
     * @param  list<string>  $permissions
     */
    private function hasElevatedPermission(array $permissions): bool
    {
        return collect($permissions)
            ->contains(fn (string $permission): bool => (bool) $this->permissionDetails($permission)['isElevated']);
    }

    /**
     * @param  list<array<string, mixed>>  $permissionRows
     * @return list<array<string, mixed>>
     */
    private function createImpactRows(array $permissionRows): array
    {
        return $this->permissionImpactRows($permissionRows, assignedUsers: 0);
    }

    /**
     * @param  array<string, mixed>  $currentMetadata
     * @param  list<array<string, mixed>>  $permissionRows
     * @return list<array<string, mixed>>
     */
    private function updateImpactRows(Role $role, array $currentMetadata, string $label, ?string $description, array $permissionRows): array
    {
        $rows = $this->permissionImpactRows($permissionRows, $this->guard->assignedUserCount($role));

        if ((string) $currentMetadata['label'] !== $label) {
            $rows[] = [
                'impact' => 'Role label',
                'count' => 1,
                'effect' => 'Role label will be updated after save',
                'status' => 'Info',
            ];
        }

        if (($currentMetadata['description'] ?? null) !== $description) {
            $rows[] = [
                'impact' => 'Role description',
                'count' => 1,
                'effect' => 'Role description will be updated after save',
                'status' => 'Info',
            ];
        }

        return $rows;
    }

    /**
     * @param  list<array<string, mixed>>  $permissionRows
     * @return list<array<string, mixed>>
     */
    private function permissionImpactRows(array $permissionRows, int $assignedUsers): array
    {
        $rows = [[
            'impact' => 'Assigned users',
            'count' => $assignedUsers,
            'effect' => $assignedUsers > 0
                ? 'Users receive updated access after save'
                : 'No currently assigned users are affected',
            'status' => $assignedUsers > 0 ? 'Review' : 'Info',
        ]];

        foreach ([
            'enabled' => ['Permissions added', 'Permissions will be added after save', 'Review'],
            'disabled' => ['Permissions removed', 'Permissions will be removed after save', 'Review'],
            'preserved' => ['Permissions preserved', 'Permissions remain assigned by guardrail', 'Review'],
            'stale' => ['Stale permissions preserved', 'Stale assignments remain visible but cannot be newly assigned', 'Warning'],
        ] as $change => [$impact, $effect, $status]) {
            $count = collect($permissionRows)->where('change', $change)->count();

            if ($count > 0) {
                $rows[] = compact('impact', 'count', 'effect', 'status');
            }
        }

        $elevatedCount = collect($permissionRows)->filter(fn (array $row): bool => (bool) $row['isElevated'])->count();

        if ($elevatedCount > 0) {
            $rows[] = [
                'impact' => 'Elevated permissions',
                'count' => $elevatedCount,
                'effect' => 'Includes elevated administrative capabilities',
                'status' => 'Warning',
            ];
        }

        $destructiveCount = collect($permissionRows)->filter(fn (array $row): bool => (bool) $row['isDestructive'])->count();

        if ($destructiveCount > 0) {
            $rows[] = [
                'impact' => 'Destructive permissions',
                'count' => $destructiveCount,
                'effect' => 'Includes destructive administrative capabilities',
                'status' => 'Warning',
            ];
        }

        return $rows;
    }

    /**
     * @param  array<string, mixed>  $metadata
     * @return list<array<string, mixed>>
     */
    private function deleteImpactRows(Role $role, array $metadata, int $assignedUsers, int $permissionCount): array
    {
        $rows = [
            [
                'impact' => 'Assigned users',
                'count' => $assignedUsers,
                'effect' => $assignedUsers > 0
                    ? 'Role cannot be deleted while assigned'
                    : 'No users are assigned to this role',
                'status' => $assignedUsers > 0 ? 'Blocked' : 'Info',
            ],
            [
                'impact' => 'Assigned permissions',
                'count' => $permissionCount,
                'effect' => 'Permissions will no longer be grouped by this role',
                'status' => 'Review',
            ],
            [
                'impact' => 'Role type',
                'count' => 1,
                'effect' => $metadata['is_system']
                    ? 'System roles cannot be deleted'
                    : 'Custom role can be deleted when no blockers remain',
                'status' => $metadata['is_system'] ? 'Blocked' : 'Info',
            ],
        ];

        if ($this->guard->roleHasElevatedPermissions($role)) {
            $rows[] = [
                'impact' => 'Elevated role',
                'count' => 1,
                'effect' => 'Deleting elevated roles requires administrative review',
                'status' => 'Warning',
            ];
        }

        return $rows;
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function deleteBlockerRows(User $actor, Role $role): array
    {
        $blockers = collect($this->guard->deleteBlockers($role));

        if (! ($actor->can(RoleCatalog::DELETE))) {
            $blockers->push('missing_permission');
        }

        return $blockers
            ->unique()
            ->map(fn (string $blocker): array => match ($blocker) {
                'system_role' => [
                    'blocker' => 'System role',
                    'effect' => 'System roles are managed by the Roles module defaults',
                    'status' => 'Blocked',
                ],
                'protected_role' => [
                    'blocker' => 'Protected role',
                    'effect' => 'Protected roles cannot be deleted',
                    'status' => 'Blocked',
                ],
                'not_deletable' => [
                    'blocker' => 'Deletion disabled',
                    'effect' => 'Role metadata marks this role as non-deletable',
                    'status' => 'Blocked',
                ],
                'assigned_users' => [
                    'blocker' => 'Assigned users',
                    'effect' => 'Users must be reassigned before deleting this role',
                    'status' => 'Blocked',
                ],
                'last_roles_manager' => [
                    'blocker' => 'Last role manager',
                    'effect' => 'At least one role must retain roles.manage',
                    'status' => 'Blocked',
                ],
                default => [
                    'blocker' => 'Permission required',
                    'effect' => 'Current user cannot delete roles',
                    'status' => 'Blocked',
                ],
            })
            ->values()
            ->all();
    }
}
