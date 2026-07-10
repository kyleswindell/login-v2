<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Notifications/Types.php
| Purpose: Declares Roles-owned persistent notification types.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles\Notifications;

use App\Core\Modules\Definitions\NotificationAudience;
use App\Core\Modules\Definitions\NotificationType;

final class Types
{
    public const ASSIGNMENTS_UPDATED = 'roles.assignments.updated';
    public const EFFECTIVE_ACCESS_CHANGED = 'roles.effective_access.changed';

    /**
     * @return list<NotificationType>
     */
    public static function all(): array
    {
        return [
            new NotificationType(
                key: self::ASSIGNMENTS_UPDATED,
                label: 'Role assignments updated',
                description: 'Your assigned roles were changed.',
                category: 'account_access',
                defaultSeverity: NotificationType::SEVERITY_NOTICE,
                emailEligible: true,
                audience: NotificationAudience::SubjectUser,
                actionRoute: 'platform.account.index',
            ),
            new NotificationType(
                key: self::EFFECTIVE_ACCESS_CHANGED,
                label: 'Access changed',
                description: 'Permissions for one of your assigned roles were changed.',
                category: 'account_access',
                defaultSeverity: NotificationType::SEVERITY_WARNING,
                emailEligible: true,
                audience: NotificationAudience::AssignedUsers,
                actionRoute: 'platform.account.index',
            ),
        ];
    }
}
