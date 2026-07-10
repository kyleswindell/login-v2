<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Account/Definition.php
| Purpose: Provides Account module package behavior.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Account;

use App\Core\Modules\Category;
use App\Core\Modules\LifecycleState;
use App\Core\Modules\Manifest;
use App\Core\Modules\PackageDefinition;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\UiPlacement;
use App\Modules\Account\Header\MenuDataProvider;

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
                    'platform.account.index',
                    'platform.account.security',
                    'platform.account.details.update',
                    'platform.account.profile-photo.update',
                    'platform.account.profile-photo.destroy',
                    'platform.account.contact-emails.store',
                    'platform.account.contact-emails.destroy',
                    'platform.account.password.update',
                    'platform.account.settings',
                    'platform.account.settings.update',
                ],
                'permissions' => [],
                'navigationRoutes' => [
                    'platform.account.index',
                    'platform.account.security',
                    'platform.account.preferences',
                ],
                'platformViewPaths' => ['resources/views/platform/account'],
                'moduleViewPaths' => ['Modules/Account/resources/views'],
                'uiEntries' => [
                    new UiEntry(
                        key: 'account.header.global-action',
                        type: UiEntryType::HeaderGlobalAction,
                        placement: UiPlacement::HeaderGlobalActions,
                        access: UiAccessMode::Authenticated,
                        label: 'Account menu',
                        routeName: 'platform.account.index',
                        panelTarget: 'app-account-menu',
                        componentView: 'account::header.action',
                        dataProvider: MenuDataProvider::class,
                        icon: 'user--avatar',
                        activeRoutePatterns: ['platform.account.*'],
                        sortOrder: 100,
                        tenantEligible: true,
                    ),
                    self::navigation('account.nav.index', UiPlacement::AccountMenu, 'Profile', 'platform.account.index', sortOrder: 10, tenantEligible: true),
                    self::navigation('account.nav.security', UiPlacement::AccountMenu, 'Security', 'platform.account.security', sortOrder: 20, tenantEligible: true),
                    self::navigation('account.nav.preferences', UiPlacement::AccountMenu, 'Preferences', 'platform.account.preferences', sortOrder: 30, tenantEligible: true),
                    self::mainView('account.main.legacy-platform-directory', 'platform.account.index', 'resources/views/platform/account', access: UiAccessMode::Authenticated, tenantEligible: true),
                    self::mainView('account.main.index', 'platform.account.index', 'Modules/Account/resources/views/index.blade.php', access: UiAccessMode::Authenticated, tenantEligible: true),
                    self::mainView('account.main.security', 'platform.account.security', 'Modules/Account/resources/views/security.blade.php', access: UiAccessMode::Authenticated, tenantEligible: true),
                ],
                'auditEvents' => ['account.*'],
            ],
            'routes' => [
                'web' => [
                    'prefix' => '',
                    'name' => '',
                    'middleware' => ['web', 'auth'],
                ],
            ],
            'views' => [
                'namespace' => 'account',
            ],
            'translations' => [
                'namespace' => 'account',
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
