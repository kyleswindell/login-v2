<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/Definitions/NotificationAudience.php
| Purpose: Defines supported module notification audience strategies.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Core\Modules\Definitions;

enum NotificationAudience: string
{
    case ExplicitRecipient = 'explicit_recipient';
    case Actor = 'actor';
    case SubjectUser = 'subject_user';
    case AssignedUsers = 'assigned_users';
}
