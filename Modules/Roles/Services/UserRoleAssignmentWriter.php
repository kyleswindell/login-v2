<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Services/UserRoleAssignmentWriter.php
| Purpose: Performs guarded user role assignment mutations and notifications.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Services;

use App\Models\User;
use App\Modules\Notifications\Services\Notifier;
use App\Modules\Roles\Notifications\Types as NotificationTypes;
use Illuminate\Auth\Access\AuthorizationException;
use Spatie\Permission\Models\Role;

final class UserRoleAssignmentWriter
{
    public function __construct(
        private readonly AssignmentGuard $guard,
        private readonly RoleMetadata $metadata,
        private readonly Notifier $notifier,
    ) {
    }

    /**
     * @param  list<string>  $roles
     */
    public function sync(User $actor, User $target, array $roles): User
    {
        $requestedRoles = $this->guard->roleNamesFromInput($roles);

        if (! $this->guard->canAssignRoles($actor, $requestedRoles, $target)) {
            throw new AuthorizationException;
        }

        $before = $target->roles()
            ->pluck('name')
            ->sort()
            ->values()
            ->all();

        $after = collect($requestedRoles)
            ->sort()
            ->values()
            ->all();

        $target->syncRoles($after);

        if ($before !== $after) {
            $this->notifyAssignmentChange($actor, $target->refresh(), $before, $after);
        }

        return $target;
    }

    /**
     * @param  list<string>  $before
     * @param  list<string>  $after
     */
    private function notifyAssignmentChange(User $actor, User $target, array $before, array $after): void
    {
        $added = collect($after)->diff($before)->values()->all();
        $removed = collect($before)->diff($after)->values()->all();
        $addedLabels = $this->roleLabels($added);
        $removedLabels = $this->roleLabels($removed);

        $this->notifier->send(
            type: NotificationTypes::ASSIGNMENTS_UPDATED,
            recipient: $target,
            actor: $actor,
            subject: $target,
            data: [
                'body' => $this->assignmentBody($addedLabels, $removedLabels),
                'added_roles' => $added,
                'added_role_labels' => $addedLabels,
                'removed_roles' => $removed,
                'removed_role_labels' => $removedLabels,
            ],
        );
    }

    /**
     * @param  list<string>  $roleNames
     * @return list<string>
     */
    private function roleLabels(array $roleNames): array
    {
        if ($roleNames === []) {
            return [];
        }

        $roles = Role::query()
            ->where('guard_name', 'web')
            ->whereIn('name', $roleNames)
            ->get()
            ->keyBy('name');

        return collect($roleNames)
            ->map(function (string $roleName) use ($roles): string {
                $role = $roles->get($roleName);

                if ($role instanceof Role) {
                    return (string) $this->metadata->summary($role)['label'];
                }

                return str($roleName)->replace(['-', '_'], ' ')->headline()->toString();
            })
            ->values()
            ->all();
    }

    /**
     * @param  list<string>  $addedLabels
     * @param  list<string>  $removedLabels
     */
    private function assignmentBody(array $addedLabels, array $removedLabels): string
    {
        $details = [];

        if ($addedLabels !== []) {
            $details[] = 'Added: '.implode(', ', $addedLabels).'.';
        }

        if ($removedLabels !== []) {
            $details[] = 'Removed: '.implode(', ', $removedLabels).'.';
        }

        return trim('Your assigned roles were changed. '.implode(' ', $details));
    }
}
