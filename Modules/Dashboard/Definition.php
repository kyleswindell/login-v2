<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Dashboard/Definition.php
| Purpose: Declares the Dashboard module package metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Dashboard;

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
                'dependencies' => ['auth', 'users', 'roles'],
                'routePatterns' => ['dashboard', 'dashboard.*'],
                'permissions' => [],
                'navigationRoutes' => ['dashboard'],
                'ownedTables' => ['user_dashboard_layouts'],
                'moduleViewPaths' => ['Modules/Dashboard/resources/views'],
                'uiEntries' => [
                    new UiEntry(
                        key: 'dashboard.nav.primary',
                        type: UiEntryType::NavigationItem,
                        placement: UiPlacement::AreaNavigation,
                        access: UiAccessMode::Authenticated,
                        label: 'Dashboard',
                        routeName: 'dashboard',
                        sortOrder: 0,
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'dashboard.main.index',
                        type: UiEntryType::MainView,
                        placement: UiPlacement::Main,
                        access: UiAccessMode::Authenticated,
                        routeName: 'dashboard',
                        viewPath: 'Modules/Dashboard/resources/views/index.blade.php',
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
                'namespace' => 'dashboard',
            ],
            'translations' => [
                'namespace' => 'dashboard',
            ],
        ]);
    }

    public static function manifest(): Manifest
    {
        return self::definition()['manifest'];
    }
}
