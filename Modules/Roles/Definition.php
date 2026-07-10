<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Roles/Definition.php
| Purpose: Declares the Roles module package metadata.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Roles;

use App\Core\Modules\Category;
use App\Core\Modules\Definitions\Permission;
use App\Core\Modules\LifecycleState;
use App\Core\Modules\Manifest;
use App\Core\Modules\PackageDefinition;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntry;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\UiPlacement;
use App\Modules\Roles\Notifications\Types as NotificationTypes;

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
                'dependencies' => ['auth'],
                'routePatterns' => ['roles.*'],
                'permissions' => [
                    'roles.create',
                    'roles.delete',
                    'roles.manage',
                    'roles.permissions.view',
                    'roles.update',
                    'roles.view',
                ],
                'permissionDefinitions' => [
                    new Permission(
                        key: 'roles.view',
                        label: 'View roles',
                        description: 'View role inventory, role details, and assigned permissions.',
                        groupKey: 'roles',
                        groupLabel: 'Roles',
                        defaultRoles: ['super_admin', 'admin'],
                        action: Permission::ACTION_VIEW,
                    ),
                    new Permission(
                        key: 'roles.create',
                        label: 'Create roles',
                        description: 'Create custom roles from module-declared permissions.',
                        groupKey: 'roles',
                        groupLabel: 'Roles',
                        elevated: true,
                        defaultRoles: ['super_admin'],
                        action: Permission::ACTION_CREATE,
                    ),
                    new Permission(
                        key: 'roles.update',
                        label: 'Update roles',
                        description: 'Update role metadata and assigned permissions.',
                        groupKey: 'roles',
                        groupLabel: 'Roles',
                        elevated: true,
                        defaultRoles: ['super_admin'],
                        action: Permission::ACTION_UPDATE,
                    ),
                    new Permission(
                        key: 'roles.delete',
                        label: 'Delete roles',
                        description: 'Delete safe custom roles after blocker checks pass.',
                        groupKey: 'roles',
                        groupLabel: 'Roles',
                        elevated: true,
                        defaultRoles: ['super_admin'],
                        action: Permission::ACTION_DELETE,
                        destructive: true,
                    ),
                    new Permission(
                        key: 'roles.permissions.view',
                        label: 'View permission catalog',
                        description: 'View module-declared permissions available for role assignment.',
                        groupKey: 'roles',
                        groupLabel: 'Roles',
                        defaultRoles: ['super_admin', 'admin'],
                        action: Permission::ACTION_VIEW,
                    ),
                    new Permission(
                        key: 'roles.manage',
                        label: 'Manage roles',
                        description: 'Elevated umbrella permission for all Roles module CRUD actions.',
                        groupKey: 'roles',
                        groupLabel: 'Roles',
                        elevated: true,
                        defaultRoles: ['super_admin'],
                        action: Permission::ACTION_MANAGE,
                    ),
                ],
                'notificationDefinitions' => NotificationTypes::all(),
                'navigationRoutes' => [],
                'ownedTables' => ['roles', 'permissions', 'model_has_roles', 'model_has_permissions', 'role_has_permissions', 'permission_registry_entries', 'role_metadata'],
                'moduleViewPaths' => ['Modules/Roles/resources/views'],
                'uiEntries' => [
                    new UiEntry(
                        key: 'roles.main.index',
                        type: UiEntryType::MainView,
                        placement: UiPlacement::Main,
                        access: UiAccessMode::Ability,
                        routeName: 'roles.index',
                        viewPath: 'Modules/Roles/resources/views/index.blade.php',
                        accessValue: 'roles.view',
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'roles.main.show',
                        type: UiEntryType::MainView,
                        placement: UiPlacement::Main,
                        access: UiAccessMode::Ability,
                        routeName: 'roles.show',
                        viewPath: 'Modules/Roles/resources/views/show.blade.php',
                        accessValue: 'roles.view',
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'roles.main.create',
                        type: UiEntryType::MainView,
                        placement: UiPlacement::Main,
                        access: UiAccessMode::Ability,
                        routeName: 'roles.create',
                        viewPath: 'Modules/Roles/resources/views/create.blade.php',
                        accessValue: 'roles.create',
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'roles.main.edit',
                        type: UiEntryType::MainView,
                        placement: UiPlacement::Main,
                        access: UiAccessMode::Ability,
                        routeName: 'roles.edit',
                        viewPath: 'Modules/Roles/resources/views/edit.blade.php',
                        accessValue: 'roles.update',
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'roles.main.delete',
                        type: UiEntryType::MainView,
                        placement: UiPlacement::Main,
                        access: UiAccessMode::Ability,
                        routeName: 'roles.delete',
                        viewPath: 'Modules/Roles/resources/views/delete.blade.php',
                        accessValue: 'roles.delete',
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'roles.main.permissions',
                        type: UiEntryType::MainView,
                        placement: UiPlacement::Main,
                        access: UiAccessMode::Ability,
                        routeName: 'roles.permissions.index',
                        viewPath: 'Modules/Roles/resources/views/permissions/index.blade.php',
                        accessValue: 'roles.permissions.view',
                        tenantEligible: true,
                    ),
                    new UiEntry(
                        key: 'roles.setup.permissions',
                        type: UiEntryType::SetupScreen,
                        placement: UiPlacement::SetupNavigation,
                        access: UiAccessMode::Ability,
                        label: 'Roles & Permissions',
                        routeName: 'roles.index',
                        viewPath: 'Modules/Roles/resources/views/index.blade.php',
                        accessValue: 'roles.view',
                        icon: 'user--multiple',
                        activeRoutePatterns: ['roles.*'],
                        sortOrder: 10,
                        tenantEligible: true,
                    ),
                ],
                'auditEvents' => [],
            ],
            'routes' => [
                'web' => [
                    'prefix' => '',
                    'name' => '',
                    'middleware' => ['web', 'auth'],
                ],
            ],
            'views' => [
                'namespace' => 'roles',
            ],
            'translations' => [
                'namespace' => 'roles',
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
}
