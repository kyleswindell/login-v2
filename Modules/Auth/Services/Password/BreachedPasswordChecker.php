<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Password/BreachedPasswordChecker.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Password;

interface BreachedPasswordChecker
{
    public function check(string $password): BreachedPasswordCheckResult;
}
