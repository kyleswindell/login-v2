<?php
/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/Definitions.php
| Purpose: Aggregates current app-owned module definitions.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules;

use App\Core\Modules\Definitions\RuntimeSecurity;
use App\Core\Modules\Definitions\UiSystem;
use App\Core\Modules\Definitions\Permission;
use App\Modules\Account\Definition as AccountDefinition;
use App\Modules\Auth\Definition as AuthDefinition;
use App\Modules\Dashboard\Definition as DashboardDefinition;
use App\Modules\Notifications\Definition as NotificationsDefinition;
use App\Modules\Preferences\Definition as PreferencesDefinition;
use App\Modules\Roles\Definition as RolesDefinition;
use App\Modules\Settings\Definition as SettingsDefinition;
use App\Modules\Setup\Definition as SetupDefinition;

final class Definitions
{
    /**
     * @return list<Manifest>
     */
    public static function manifests(): array
    {
        return [
            AuthDefinition::manifest(),
            AccountDefinition::manifest(),
            new Manifest(
                key: 'users',
                name: 'Users',
                type: Category::Core,
                dependencies: ['auth', 'roles'],
                routePatterns: ['platform.users.*', 'platform.administration.users.index', 'platform.settings.users', 'platform.settings.users.update'],
                permissions: ['platform.users.view', 'platform.users.manage'],
                permissionDefinitions: [
                    new Permission(
                        key: 'platform.users.view',
                        label: 'View users',
                        description: 'View user administration records.',
                        groupKey: 'users',
                        groupLabel: 'Users',
                        defaultRoles: ['super_admin', 'admin'],
                    ),
                    new Permission(
                        key: 'platform.users.manage',
                        label: 'Manage users',
                        description: 'Create, update, deactivate, and assign allowed roles to users.',
                        groupKey: 'users',
                        groupLabel: 'Users',
                        elevated: true,
                        defaultRoles: ['super_admin', 'admin'],
                    ),
                ],
                navigationRoutes: ['platform.administration.users.index'],
                settingsGroups: ['users'],
                ownedTables: ['users'],
                platformViewPaths: ['resources/views/platform/users'],
                uiEntries: [
                    self::mainView('users.main.index', 'platform.users.index', 'resources/views/platform/users', accessValue: 'view-platform-users', tenantEligible: true),
                ],
                auditEvents: ['platform.user.*', 'users.*'],
            ),
            RolesDefinition::manifest(),
            SettingsDefinition::manifest(),
            new Manifest(
                key: 'logging',
                name: 'Logging',
                type: Category::Core,
                dependencies: ['auth', 'users', 'roles'],
                routePatterns: ['platform.audit-logs.*', 'platform.operations.audit-logs.index', 'platform.error-logs.*', 'platform.operations.error-logs.index', 'platform.settings.audit-logs', 'platform.settings.audit-logs.update'],
                permissions: ['platform.audit-logs.view', 'platform.error-logs.view'],
                permissionDefinitions: [
                    new Permission(
                        key: 'platform.audit-logs.view',
                        label: 'View audit logs',
                        description: 'View app-instance audit log entries.',
                        groupKey: 'logging',
                        groupLabel: 'Logging',
                        defaultRoles: ['super_admin', 'admin', 'manager'],
                    ),
                    new Permission(
                        key: 'platform.error-logs.view',
                        label: 'View error logs',
                        description: 'View app-instance error log entries.',
                        groupKey: 'logging',
                        groupLabel: 'Logging',
                        defaultRoles: ['super_admin', 'admin', 'manager'],
                    ),
                ],
                navigationRoutes: ['platform.operations.audit-logs.index', 'platform.operations.error-logs.index'],
                settingsGroups: ['audit_logs'],
                ownedTables: ['platform_audit_logs', 'central_error_logs'],
                platformViewPaths: ['resources/views/platform/audit-logs', 'resources/views/platform/error-logs'],
                uiEntries: [
                    self::navigation('logging.nav.audit-logs', UiPlacement::AreaNavigation, 'Audit Logs', 'platform.operations.audit-logs.index', access: UiAccessMode::Ability, accessValue: 'view-platform-audit-logs', sortOrder: 80, tenantEligible: true),
                    self::navigation('logging.nav.error-logs', UiPlacement::AreaNavigation, 'Error Logs', 'platform.operations.error-logs.index', access: UiAccessMode::Ability, accessValue: 'view-platform-error-logs', sortOrder: 90, tenantEligible: true),
                    self::mainView('logging.main.audit-logs', 'platform.audit-logs.index', 'resources/views/platform/audit-logs', accessValue: 'view-platform-audit-logs', tenantEligible: true),
                    self::mainView('logging.main.error-logs', 'platform.error-logs.index', 'resources/views/platform/error-logs', accessValue: 'view-platform-error-logs', tenantEligible: true),
                ],
            ),
            NotificationsDefinition::manifest(),
            DashboardDefinition::manifest(),
            PreferencesDefinition::manifest(),
            UiSystem::manifest(),
            RuntimeSecurity::manifest(),
            SetupDefinition::manifest(),
            new Manifest(
                key: 'docs-viewer',
                name: 'Docs Viewer',
                type: Category::PlatformManagement,
                disableable: true,
                tenantEligible: false,
                dependencies: ['auth', 'settings'],
                routePatterns: ['platform.docs.*', 'platform.settings.docs', 'platform.settings.docs.update'],
                permissions: ['platform.docs.view'],
                permissionDefinitions: [
                    new Permission(
                        key: 'platform.docs.view',
                        label: 'View docs viewer',
                        description: 'View internal documentation through the Docs Viewer tool.',
                        groupKey: 'docs-viewer',
                        groupLabel: 'Docs Viewer',
                        defaultRoles: ['super_admin', 'admin'],
                    ),
                ],
                navigationRoutes: ['platform.docs.index'],
                settingsGroups: ['docs'],
                platformViewPaths: ['resources/views/platform/docs'],
                uiEntries: [
                    self::navigation('docs-viewer.nav.primary', UiPlacement::AreaNavigation, 'Documentation Vault', 'platform.docs.index', access: UiAccessMode::Ability, accessValue: 'view-platform-docs', sortOrder: 30),
                    self::mainView('docs-viewer.main.index', 'platform.docs.index', 'resources/views/platform/docs', accessValue: 'view-platform-docs'),
                ],
            ),
            new Manifest(
                key: 'security-checklist',
                name: 'Security Checklist',
                type: Category::PlatformManagement,
                disableable: true,
                tenantEligible: false,
                dependencies: ['auth', 'users', 'roles', 'dashboard'],
                routePatterns: ['platform.security.*'],
                permissions: ['platform.security-checklist.view', 'platform.security-checklist.manage'],
                permissionDefinitions: [
                    new Permission(
                        key: 'platform.security-checklist.view',
                        label: 'View security checklist',
                        description: 'View security checklist status and evidence links.',
                        groupKey: 'security-checklist',
                        groupLabel: 'Security Checklist',
                        defaultRoles: ['super_admin', 'admin'],
                    ),
                    new Permission(
                        key: 'platform.security-checklist.manage',
                        label: 'Manage security checklist',
                        description: 'Update security checklist status and evidence links.',
                        groupKey: 'security-checklist',
                        groupLabel: 'Security Checklist',
                        elevated: true,
                        defaultRoles: ['super_admin', 'admin'],
                    ),
                ],
                navigationRoutes: ['platform.security.index'],
                ownedTables: ['security_requirement_groups', 'security_requirements'],
                platformViewPaths: ['resources/views/platform/security'],
                uiEntries: [
                    self::navigation('security-checklist.nav.primary', UiPlacement::AreaNavigation, 'Security Checklist', 'platform.security.index', access: UiAccessMode::Ability, accessValue: 'view-platform-security-checklist', sortOrder: 50),
                    self::mainView('security-checklist.main.index', 'platform.security.index', 'resources/views/platform/security', accessValue: 'view-platform-security-checklist'),
                ],
                auditEvents: ['security.requirement_updated'],
            ),
            new Manifest(
                key: 'runtime-readiness',
                name: 'Runtime Readiness',
                type: Category::PlatformManagement,
                disableable: true,
                tenantEligible: false,
                dependencies: ['runtime-security'],
                commands: ['platform:security-runtime-check'],
            ),
            new Manifest(
                key: 'development-tools',
                name: 'Development Tools',
                type: Category::PlatformManagement,
                disableable: true,
                tenantEligible: false,
                dependencies: ['dashboard', 'notifications'],
            ),
        ];
    }

    public static function repository(): Repository
    {
        return new Repository(self::manifests());
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function packageDefinitions(): array
    {
        return [
            AuthDefinition::definition(),
            AccountDefinition::definition(),
            RolesDefinition::definition(),
            DashboardDefinition::definition(),
            SettingsDefinition::definition(),
            PreferencesDefinition::definition(),
            NotificationsDefinition::definition(),
            SetupDefinition::definition(),
        ];
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
