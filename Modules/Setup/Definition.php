<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Setup/Definition.php
| Purpose: Declares the Setup module package metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Setup;

use App\Core\Modules\Category;
use App\Core\Modules\Definitions\Permission;
use App\Core\Modules\LifecycleState;
use App\Core\Modules\Manifest;
use App\Core\Modules\PackageDefinition;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\UiPlacement;
use App\Modules\Setup\Services\SetupPermissions;

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
                'dependencies' => ['auth', 'roles'],
                'setupRoutes' => ['platform.setup.index'],
                'navigationRoutes' => [
                    'platform.setup.index',
                ],
                'permissions' => [SetupPermissions::VIEW],
                'permissionDefinitions' => [
                    new Permission(
                        key: SetupPermissions::VIEW,
                        label: 'View setup',
                        description: 'View the Setup shell and module-contributed setup screens.',
                        groupKey: 'setup',
                        groupLabel: 'Setup',
                        defaultRoles: ['super_admin', 'admin'],
                        action: Permission::ACTION_VIEW,
                    ),
                ],
                'moduleViewPaths' => ['Modules/Setup/resources/views'],
                'uiEntries' => [
                    self::areaNavigation(),
                    self::setupScreen('setup.screen.index', 'Setup', 'platform.setup.index', 'Modules/Setup/resources/views/index.blade.php', 'settings--check', SetupPermissions::VIEW, activeRoutePatterns: ['platform.setup.index'], sortOrder: 0, tenantEligible: true),
                    self::mainView('setup.main.index', 'platform.setup.index', 'Modules/Setup/resources/views/index.blade.php', accessValue: SetupPermissions::VIEW, tenantEligible: true),
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
                'namespace' => 'setup',
            ],
            'translations' => [
                'namespace' => 'setup',
            ],
            'providers' => [
                Providers\Provider::class,
            ],
        ]);
    }

    public static function manifest(): Manifest
    {
        return self::definition()['manifest'];
    }

    private static function areaNavigation(): UiEntry
    {
        return new UiEntry(
            key: 'setup.nav.area',
            type: UiEntryType::NavigationItem,
            placement: UiPlacement::AreaNavigation,
            access: UiAccessMode::Ability,
            label: 'Setup',
            routeName: 'platform.setup.index',
            accessValue: SetupPermissions::VIEW,
            icon: 'settings--check',
            activeRoutePatterns: ['platform.setup.*', 'roles.*'],
            sortOrder: 20,
            tenantEligible: true,
        );
    }

    private static function setupScreen(
        string $key,
        string $label,
        string $routeName,
        string $viewPath,
        string $icon,
        string $accessValue,
        array $activeRoutePatterns = [],
        int $sortOrder = 0,
        bool $tenantEligible = false,
    ): UiEntry {
        return new UiEntry(
            key: $key,
            type: UiEntryType::SetupScreen,
            placement: UiPlacement::SetupNavigation,
            access: UiAccessMode::Ability,
            label: $label,
            routeName: $routeName,
            viewPath: $viewPath,
            accessValue: $accessValue,
            icon: $icon,
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
