<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Settings/Definition.php
| Purpose: Declares the Settings module package metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Settings;

use App\Core\Modules\Category;
use App\Core\Modules\Definitions\Permission;
use App\Core\Modules\LifecycleState;
use App\Core\Modules\Manifest;
use App\Core\Modules\PackageDefinition;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\UiPlacement;
use App\Modules\Settings\Services\SettingsPermissions;

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
                'dependencies' => ['auth', 'users', 'roles'],
                'routePatterns' => [
                    'settings.index',
                    'platform.settings.index',
                    'platform.settings.general',
                    'platform.settings.general.update',
                    'platform.settings.general.company-information',
                    'platform.settings.general.company-information.update',
                    'platform.settings.general.localization',
                    'platform.settings.general.localization.update',
                    'platform.settings.general.email',
                    'platform.settings.general.email.update',
                    'platform.settings.general.system-update',
                    'platform.settings.general.system-update.update',
                    'platform.settings.general.system-server-info',
                    'platform.administration.settings.index',
                ],
                'permissions' => SettingsPermissions::all(),
                'permissionDefinitions' => [
                    new Permission(
                        key: SettingsPermissions::VIEW,
                        label: 'View settings',
                        description: 'View app-instance settings pages.',
                        groupKey: 'settings',
                        groupLabel: 'Settings',
                        defaultRoles: ['super_admin', 'admin'],
                        action: Permission::ACTION_VIEW,
                    ),
                    new Permission(
                        key: SettingsPermissions::UPDATE,
                        label: 'Update settings',
                        description: 'Update app-instance settings values.',
                        groupKey: 'settings',
                        groupLabel: 'Settings',
                        elevated: true,
                        defaultRoles: ['super_admin', 'admin'],
                        action: Permission::ACTION_UPDATE,
                    ),
                    new Permission(
                        key: SettingsPermissions::MANAGE,
                        label: 'Manage settings',
                        description: 'Administrative umbrella permission for Settings module pages and updates.',
                        groupKey: 'settings',
                        groupLabel: 'Settings',
                        elevated: true,
                        defaultRoles: ['super_admin'],
                        action: Permission::ACTION_MANAGE,
                    ),
                ],
                'navigationRoutes' => ['settings.index', 'platform.settings.index', 'platform.administration.settings.index'],
                'settingsGroups' => [],
                'ownedTables' => ['settings'],
                'platformViewPaths' => ['resources/views/platform/settings'],
                'moduleViewPaths' => ['Modules/Settings/resources/views'],
                'uiEntries' => [
                    self::headerGlobalAction('settings.header.global-action', 'Settings', 'settings', accessValue: SettingsPermissions::VIEW, routeName: 'settings.index', sortOrder: 20, activeRoutePatterns: ['settings.*', 'platform.settings.*', 'platform.administration.settings.index'], tenantEligible: true),
                    self::settingsPage('settings.page.index', 'Settings', 'settings.index', 'Modules/Settings/resources/views/index.blade.php', 'settings', 'settings', 'Settings', activeRoutePatterns: ['settings.index', 'platform.settings.index'], sortOrder: 0, tenantEligible: true),
                    self::mainView('settings.main.index', 'settings.index', 'Modules/Settings/resources/views/index.blade.php', accessValue: SettingsPermissions::VIEW, tenantEligible: true),
                    self::mainView('settings.main.platform-index', 'platform.settings.index', 'Modules/Settings/resources/views/index.blade.php', accessValue: SettingsPermissions::VIEW, tenantEligible: true),
                ],
                'auditEvents' => ['settings.*'],
            ],
            'routes' => [
                'web' => [
                    'prefix' => '',
                    'name' => '',
                    'middleware' => ['web', 'auth'],
                ],
            ],
            'views' => [
                'namespace' => 'settings',
            ],
            'translations' => [
                'namespace' => 'settings',
            ],
        ]);
    }

    public static function manifest(): Manifest
    {
        return self::definition()['manifest'];
    }

    private static function navigation(
        string $key,
        UiPlacement $placement,
        string $label,
        string $routeName,
        UiAccessMode $access = UiAccessMode::Authenticated,
        ?string $accessValue = null,
        int $sortOrder = 0,
        bool $tenantEligible = false,
    ): UiEntry {
        return new UiEntry(
            key: $key,
            type: UiEntryType::NavigationItem,
            placement: $placement,
            access: $access,
            label: $label,
            routeName: $routeName,
            accessValue: $accessValue,
            sortOrder: $sortOrder,
            tenantEligible: $tenantEligible,
        );
    }

    /**
     * @param  list<string>  $activeRoutePatterns
     */
    private static function headerGlobalAction(
        string $key,
        string $label,
        string $icon,
        string $accessValue,
        ?string $routeName = null,
        ?string $panelTarget = null,
        int $sortOrder = 0,
        array $activeRoutePatterns = [],
        bool $tenantEligible = false,
    ): UiEntry {
        return new UiEntry(
            key: $key,
            type: UiEntryType::HeaderGlobalAction,
            placement: UiPlacement::HeaderGlobalActions,
            access: UiAccessMode::Ability,
            label: $label,
            routeName: $routeName,
            panelTarget: $panelTarget,
            accessValue: $accessValue,
            icon: $icon,
            activeRoutePatterns: $activeRoutePatterns,
            sortOrder: $sortOrder,
            tenantEligible: $tenantEligible,
        );
    }

    private static function settingsPage(
        string $key,
        string $label,
        string $routeName,
        string $viewPath,
        string $icon,
        string $groupKey,
        string $groupLabel,
        string $accessValue = SettingsPermissions::VIEW,
        int $groupSortOrder = 0,
        int $sortOrder = 0,
        array $activeRoutePatterns = [],
        bool $tenantEligible = false,
    ): UiEntry {
        return new UiEntry(
            key: $key,
            type: UiEntryType::SettingsPage,
            placement: UiPlacement::SettingsSidebar,
            access: UiAccessMode::Ability,
            label: $label,
            routeName: $routeName,
            viewPath: $viewPath,
            accessValue: $accessValue,
            icon: $icon,
            groupKey: $groupKey,
            groupLabel: $groupLabel,
            groupSortOrder: $groupSortOrder,
            activeRoutePatterns: $activeRoutePatterns !== [] ? $activeRoutePatterns : [$routeName],
            sortOrder: $sortOrder,
            tenantEligible: $tenantEligible,
        );
    }

    private static function mainView(
        string $key,
        string $routeName,
        string $viewPath,
        UiAccessMode $access = UiAccessMode::Ability,
        ?string $accessValue = null,
        int $sortOrder = 0,
        bool $tenantEligible = false,
    ): UiEntry {
        return new UiEntry(
            key: $key,
            type: UiEntryType::MainView,
            placement: UiPlacement::Main,
            access: $access,
            routeName: $routeName,
            viewPath: $viewPath,
            accessValue: $accessValue,
            sortOrder: $sortOrder,
            tenantEligible: $tenantEligible,
        );
    }
}
