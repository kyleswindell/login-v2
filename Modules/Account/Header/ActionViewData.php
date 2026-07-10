<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Account/Header/ActionViewData.php
| Purpose: Normalized view data for the Account header action.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Account\Header;

final class ActionViewData
{
    /**
     * @return array<string, mixed>
     */
    public static function make(array $action = [], array $data = []): array
    {
        $id = data_get($action, 'panelTarget') ?: 'app-account-menu';
        $panelId = "{$id}-content";
        $label = data_get($action, 'label') ?: 'Account menu';
        $open = (bool) data_get($action, 'expanded', false);
        $user = data_get($data, 'user');

        $resolvedName = data_get($user, 'name')
            ?? data_get($user, 'full_name')
            ?? 'Account';

        $resolvedEmail = data_get($user, 'email');

        $themeOptions = data_get($data, 'themeOptions', [
            'light' => 'Light',
            'dark' => 'Dark',
            'system' => 'System',
        ]);

        $themeMode = data_get($data, 'themeMode', 'system');
        $resolvedThemeMode = in_array($themeMode, array_keys($themeOptions), true)
            ? $themeMode
            : 'system';

        return [
            'id' => $id,
            'panelId' => $panelId,
            'entryKey' => data_get($action, 'key'),
            'moduleKey' => data_get($action, 'moduleKey'),
            'label' => $label,
            'open' => $open,
            'user' => $user,
            'name' => $resolvedName,
            'email' => $resolvedEmail,
            'initials' => self::initials((string) $resolvedName),
            'avatarUrl' => data_get($user, 'avatar_url'),
            'navigation' => data_get($data, 'navigation', []),
            'showTheme' => (bool) data_get($data, 'showTheme', true),
            'themeMode' => $resolvedThemeMode,
            'themeOptions' => $themeOptions,
            'showLogout' => (bool) data_get($data, 'showLogout', true),
            'logoutRoute' => data_get($data, 'logoutRoute', 'logout'),
        ];
    }

    private static function initials(string $name): string
    {
        $nameParts = preg_split('/\s+/', trim($name));

        $initials = collect($nameParts)
            ->filter()
            ->take(2)
            ->map(fn (string $part): string => mb_substr($part, 0, 1))
            ->implode('');

        return $initials !== ''
            ? mb_strtoupper($initials)
            : 'A';
    }
}
