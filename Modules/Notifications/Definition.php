<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Definition.php
| Purpose: Declares the Notifications module package metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications;

use App\Core\Modules\Category;
use App\Core\Modules\Definitions\Permission;
use App\Core\Modules\LifecycleState;
use App\Core\Modules\Manifest;
use App\Core\Modules\PackageDefinition;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\UiPlacement;
use App\Modules\Notifications\Header\PanelDataProvider;
use App\Modules\Notifications\Providers\Provider as NotificationsProvider;
use App\Modules\Notifications\Services\NotificationPermissions;

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
                'dependencies' => ['auth', 'users', 'roles', 'dashboard', 'settings', 'setup'],
                'routePatterns' => ['notifications.*', 'platform.account.notifications', 'platform.account.notifications.update', 'platform.realtime.auth', 'platform.notifications.*', 'platform.administration.notifications.index', 'platform.settings.notifications', 'platform.settings.notifications.update'],
                'setupRoutes' => ['platform.setup.notifications'],
                'permissions' => NotificationPermissions::all(),
                'permissionDefinitions' => [
                    new Permission(
                        key: NotificationPermissions::VIEW,
                        label: 'View notifications',
                        description: 'View notification bell, inbox, and notification panel data.',
                        groupKey: 'notifications',
                        groupLabel: 'Notifications',
                        defaultRoles: ['super_admin', 'admin', 'manager', 'user'],
                        action: Permission::ACTION_VIEW,
                    ),
                    new Permission(
                        key: NotificationPermissions::SETTINGS_VIEW,
                        label: 'View notification settings',
                        description: 'View Notifications module delivery default settings.',
                        groupKey: 'notifications',
                        groupLabel: 'Notifications',
                        defaultRoles: ['super_admin', 'admin'],
                        action: Permission::ACTION_VIEW,
                    ),
                    new Permission(
                        key: NotificationPermissions::SETTINGS_UPDATE,
                        label: 'Update notification settings',
                        description: 'Update Notifications module delivery default settings.',
                        groupKey: 'notifications',
                        groupLabel: 'Notifications',
                        elevated: true,
                        defaultRoles: ['super_admin', 'admin'],
                        action: Permission::ACTION_UPDATE,
                    ),
                    new Permission(
                        key: NotificationPermissions::MANAGE,
                        label: 'Manage notifications',
                        description: 'Administrative umbrella permission for Notifications module settings and operations.',
                        groupKey: 'notifications',
                        groupLabel: 'Notifications',
                        elevated: true,
                        defaultRoles: ['super_admin'],
                        action: Permission::ACTION_MANAGE,
                    ),
                ],
                'navigationRoutes' => ['notifications.index', 'platform.account.notifications', 'platform.administration.notifications.index'],
                'settingsGroups' => ['notifications'],
                'ownedTables' => ['notifications', 'user_notification_preferences'],
                'moduleViewPaths' => ['Modules/Notifications/resources/views'],
                'uiEntries' => [
                    new UiEntry(
                        key: 'notifications.nav.primary',
                        type: UiEntryType::NavigationItem,
                        placement: UiPlacement::AreaNavigation,
                        access: UiAccessMode::Ability,
                        label: 'Notifications',
                        routeName: 'notifications.index',
                        accessValue: NotificationPermissions::VIEW,
                        sortOrder: 20,
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'notifications.header.global-action',
                        type: UiEntryType::HeaderGlobalAction,
                        placement: UiPlacement::HeaderGlobalActions,
                        access: UiAccessMode::Ability,
                        label: 'Notifications',
                        routeName: 'notifications.index',
                        panelTarget: 'app-header-notifications',
                        componentView: 'notifications::header.action',
                        dataProvider: PanelDataProvider::class,
                        accessValue: NotificationPermissions::VIEW,
                        icon: 'notification',
                        activeRoutePatterns: ['notifications.*', 'platform.notifications.*', 'platform.administration.notifications.index'],
                        sortOrder: 30,
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'notifications.settings.defaults',
                        type: UiEntryType::SettingsPage,
                        placement: UiPlacement::SettingsSidebar,
                        access: UiAccessMode::Ability,
                        label: 'Notification Defaults',
                        routeName: 'platform.settings.notifications',
                        viewPath: 'Modules/Notifications/resources/views/settings/defaults.blade.php',
                        accessValue: NotificationPermissions::SETTINGS_VIEW,
                        icon: 'notification',
                        groupKey: 'notifications',
                        groupLabel: 'Notifications',
                        groupSortOrder: 20,
                        activeRoutePatterns: ['platform.settings.notifications'],
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'notifications.account.preferences',
                        type: UiEntryType::PreferencePage,
                        placement: UiPlacement::PreferencesNavigation,
                        access: UiAccessMode::Authenticated,
                        label: 'Notifications',
                        routeName: 'platform.account.notifications',
                        viewPath: 'Modules/Notifications/resources/views/account/preferences.blade.php',
                        icon: 'notification',
                        groupKey: 'account',
                        groupLabel: 'Account',
                        groupSortOrder: 10,
                        activeRoutePatterns: ['platform.account.notifications'],
                        sortOrder: 20,
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'notifications.setup.index',
                        type: UiEntryType::SetupScreen,
                        placement: UiPlacement::SetupNavigation,
                        access: UiAccessMode::Ability,
                        label: 'Notifications',
                        routeName: 'platform.setup.notifications',
                        viewPath: 'Modules/Notifications/resources/views/setup/index.blade.php',
                        accessValue: NotificationPermissions::VIEW,
                        icon: 'notification',
                        activeRoutePatterns: ['platform.setup.notifications'],
                        sortOrder: 20,
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'notifications.main.index',
                        type: UiEntryType::MainView,
                        placement: UiPlacement::Main,
                        access: UiAccessMode::Ability,
                        routeName: 'notifications.index',
                        viewPath: 'Modules/Notifications/resources/views/index.blade.php',
                        accessValue: NotificationPermissions::VIEW,
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'notifications.main.account-preferences',
                        type: UiEntryType::MainView,
                        placement: UiPlacement::Main,
                        access: UiAccessMode::Authenticated,
                        routeName: 'platform.account.notifications',
                        viewPath: 'Modules/Notifications/resources/views/account/preferences.blade.php',
                        tenantEligible: true,
                    ),
                ],
                'auditEvents' => ['notifications.*', 'notifications.inbox.*'],
            ],
            'routes' => [
                'web' => [
                    'prefix' => '',
                    'name' => '',
                    'middleware' => ['web', 'auth'],
                ],
            ],
            'views' => [
                'namespace' => 'notifications',
            ],
            'translations' => [
                'namespace' => 'notifications',
            ],
            'providers' => [
                NotificationsProvider::class,
            ],
        ]);
    }

    public static function manifest(): Manifest
    {
        return self::definition()['manifest'];
    }
}
