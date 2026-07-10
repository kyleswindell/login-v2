<?php

/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Notifications/Types.php
| Purpose: Declares Auth-owned persistent notification types.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Auth\Notifications;

use App\Core\Modules\Definitions\NotificationAudience;
use App\Core\Modules\Definitions\NotificationType;

final class Types
{
    public const PASSWORD_CHANGED = 'auth.password.changed';
    public const MFA_ENROLLED = 'auth.mfa.enrolled';
    public const MFA_RECOVERY_CODE_USED = 'auth.mfa.recovery_code_used';
    public const MFA_RESET = 'auth.mfa.reset';

    /**
     * @return list<NotificationType>
     */
    public static function all(): array
    {
        return [
            new NotificationType(
                key: self::PASSWORD_CHANGED,
                label: 'Password changed',
                description: 'Your account password was changed.',
                category: 'account_security',
                defaultSeverity: NotificationType::SEVERITY_WARNING,
                emailEligible: true,
                audience: NotificationAudience::SubjectUser,
                actionRoute: 'platform.account.index',
            ),
            new NotificationType(
                key: self::MFA_ENROLLED,
                label: 'MFA enabled',
                description: 'Multi-factor authentication was enabled for your account.',
                category: 'account_security',
                defaultSeverity: NotificationType::SEVERITY_NOTICE,
                emailEligible: true,
                audience: NotificationAudience::SubjectUser,
                actionRoute: 'platform.account.index',
            ),
            new NotificationType(
                key: self::MFA_RECOVERY_CODE_USED,
                label: 'MFA recovery code used',
                description: 'A recovery code was used to complete sign-in to your account.',
                category: 'account_security',
                defaultSeverity: NotificationType::SEVERITY_WARNING,
                emailEligible: true,
                audience: NotificationAudience::SubjectUser,
                actionRoute: 'platform.account.index',
            ),
            new NotificationType(
                key: self::MFA_RESET,
                label: 'MFA reset',
                description: 'Multi-factor authentication enrollment was reset for your account.',
                category: 'account_security',
                defaultSeverity: NotificationType::SEVERITY_WARNING,
                emailEligible: true,
                audience: NotificationAudience::SubjectUser,
                actionRoute: 'platform.account.index',
            ),
        ];
    }
}
