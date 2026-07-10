<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/Definitions/Example.php
| Purpose: Documents the draft module definition shape.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules\Definitions;

use App\Core\Modules\Category;
use App\Core\Modules\Manifest;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\UiPlacement;


final class Example
{
    public static function manifest(): Manifest
    {
        return new Manifest(
            key: 'example',
            name: 'Example',
            type: Category::Shared,
            disableable: true,
            tenantEligible: true,
            dependencies: ['auth'],
            routePatterns: ['example.*'],
            permissions: ['example.view'],
            permissionDefinitions: [
                new Permission(
                    key: 'example.view',
                    label: 'View example',
                    description: 'View Example module pages.',
                    groupKey: 'example',
                    groupLabel: 'Example',
                ),
            ],
            navigationRoutes: ['example.index'],
            dashboardWidgets: ['example_summary'],
            settingsGroups: ['example'],
            ownedTables: ['example_records'],
            moduleViewPaths: ['Modules/Example/resources/views'],
            uiEntries: [
                new UiEntry(
                    key: 'example.nav.primary',
                    type: UiEntryType::NavigationItem,
                    placement: UiPlacement::AreaNavigation,
                    access: UiAccessMode::Permission,
                    label: 'Example',
                    routeName: 'example.index',
                    accessValue: 'example.view',
                    sortOrder: 100,
                    tenantEligible: true,
                ),
                new UiEntry(
                    key: 'example.main.index',
                    type: UiEntryType::MainView,
                    placement: UiPlacement::Main,
                    access: UiAccessMode::Permission,
                    routeName: 'example.index',
                    viewPath: 'Modules/Example/resources/views/index.blade.php',
                    accessValue: 'example.view',
                    tenantEligible: true,
                ),
            ],
            auditEvents: ['example.*'],
        );
    }
}
