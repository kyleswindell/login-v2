<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Auth/Services/Password/LocalPasswordPolicy.php
| Purpose: Provides Auth module package behavior.
|--------------------------------------------------------------------------
*/

namespace App\Modules\Auth\Services\Password;

use App\Models\User;
use Illuminate\Validation\Rules\Password;

class LocalPasswordPolicy
{
    public const MIN_LENGTH = 12;

    /**
     * @param list<string|null> $contextWords
     * @return list<mixed>
     */
    public static function rules(array $contextWords = []): array
    {
        return [
            Password::min(self::MIN_LENGTH),
            new NotCommonOrContextualPassword($contextWords),
            new BreachedPasswordRule(),
        ];
    }

    /**
     * @return list<mixed>
     */
    public static function rulesForUser(User $user): array
    {
        return self::rules(self::contextWordsForUser($user));
    }

    /**
     * @return list<string|null>
     */
    public static function contextWordsForUser(User $user): array
    {
        return [
            $user->name,
            $user->first_name,
            $user->last_name,
            str($user->email)->before('@')->toString(),
        ];
    }

    /**
     * @param array<string, mixed> $input
     * @return list<string|null>
     */
    public static function contextWordsForInput(array $input): array
    {
        $email = (string) ($input['email'] ?? '');

        return [
            (string) ($input['name'] ?? ''),
            (string) ($input['first_name'] ?? ''),
            (string) ($input['last_name'] ?? ''),
            str($email)->before('@')->toString(),
        ];
    }
}
