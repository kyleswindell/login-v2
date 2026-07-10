<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Preferences/Definition.php
| Purpose: Declares the Preferences module package metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Preferences;

use App\Core\Modules\Category;
use App\Core\Modules\LifecycleState;
use App\Core\Modules\Manifest;
use App\Core\Modules\PackageDefinition;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\UiPlacement;

final class Definition
{
    /**
     * @return array<string, mixed>
     */
    public static function definition(): array
    {
        return PackageDefinition::defaults(__DIR__, [
            'manifest' => [
                'type' => Category::Core,
                'defaultState' => LifecycleState::Enabled,
                'installedByDefault' => true,
                'defaultEnabled' => true,
                'disableable' => false,
                'tenantEligible' => true,
                'dependencies' => ['auth', 'account'],
                'routePatterns' => ['platform.account.preferences', 'platform.account.preferences.update'],
                'permissions' => [],
                'moduleViewPaths' => ['Modules/Preferences/resources/views'],
                'uiEntries' => [
                    new UiEntry(
                        key: 'preferences.page.personal-defaults',
                        type: UiEntryType::PreferencePage,
                        placement: UiPlacement::PreferencesNavigation,
                        access: UiAccessMode::Authenticated,
                        label: 'Preferences',
                        routeName: 'platform.account.preferences',
                        viewPath: 'Modules/Preferences/resources/views/personal-defaults.blade.php',
                        icon: 'settings',
                        groupKey: 'account',
                        groupLabel: 'Account',
                        groupSortOrder: 10,
                        activeRoutePatterns: ['platform.account.preferences'],
                        sortOrder: 10,
                        tenantEligible: true,
                    ),
                ],
            ],
            'routes' => [
                'web' => [
                    'prefix' => '',
                    'name' => '',
                    'middleware' => ['web', 'auth'],
                ],
            ],
            'views' => [
                'namespace' => 'preferences',
            ],
            'translations' => [
                'namespace' => 'preferences',
            ],
        ]);
    }

    public static function manifest(): Manifest
    {
        return self::definition()['manifest'];
    }
}
