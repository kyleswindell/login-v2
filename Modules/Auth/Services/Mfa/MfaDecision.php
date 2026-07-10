<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Mfa/MfaDecision.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Mfa;

enum MfaDecision: string
{
    case NotRequired = 'not_required';
    case EnrollmentRequired = 'enrollment_required';
    case ChallengeRequired = 'challenge_required';
    case Satisfied = 'satisfied';
}
