<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/Manifest.php
| Purpose: Defines the immutable module manifest metadata object.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules;

use App\Core\Modules\Definitions\Permission;
use App\Core\Modules\Definitions\NotificationType;

final class Manifest
{
    /**
     * @param  list<string>  $dependencies
     * @param  list<string>  $routePatterns
     * @param  list<string>  $permissions
     * @param  list<Permission>  $permissionDefinitions
     * @param  list<NotificationType>  $notificationDefinitions
     * @param  list<string>  $navigationRoutes
     * @param  list<string>  $dashboardWidgets
     * @param  list<string>  $settingsGroups
     * @param  list<string>  $ownedTables
     * @param  list<string>  $platformViewPaths
     * @param  list<string>  $moduleViewPaths
     * @param  list<UiEntry>  $uiEntries
     * @param  list<string>  $setupRoutes
     * @param  list<string>  $auditEvents
     * @param  list<string>  $commands
     */
    public function __construct(
        public readonly string $key,
        public readonly string $name,
        public readonly Category $type,
        public readonly LifecycleState $defaultState = LifecycleState::Enabled,
        public readonly bool $installedByDefault = true,
        public readonly bool $defaultEnabled = true,
        public readonly bool $disableable = false,
        public readonly bool $tenantEligible = true,
        public readonly array $dependencies = [],
        public readonly array $routePatterns = [],
        public readonly array $permissions = [],
        public readonly array $permissionDefinitions = [],
        public readonly array $notificationDefinitions = [],
        public readonly array $navigationRoutes = [],
        public readonly array $dashboardWidgets = [],
        public readonly array $settingsGroups = [],
        public readonly array $ownedTables = [],
        public readonly array $platformViewPaths = [],
        public readonly array $moduleViewPaths = [],
        public readonly array $uiEntries = [],
        public readonly array $setupRoutes = [],
        public readonly array $auditEvents = [],
        public readonly array $commands = [],
    ) {
    }

    /**
     * @return list<string>
     */
    public function permissionKeys(): array
    {
        return collect($this->permissions)
            ->merge(collect($this->permissionDefinitions)
                ->filter(fn (mixed $permission): bool => $permission instanceof Permission)
                ->map(fn (Permission $permission): string => $permission->key))
            ->filter(fn (mixed $permission): bool => is_string($permission) && $permission !== '')
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    public function toSummaryArray(): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
            'type' => $this->type->value,
            'default_state' => $this->defaultState->value,
            'installed_by_default' => $this->installedByDefault,
            'default_enabled' => $this->defaultEnabled,
            'disableable' => $this->disableable,
            'tenant_eligible' => $this->tenantEligible,
            'dependencies' => $this->dependencies,
            'ownership_counts' => [
                'route_patterns' => count($this->routePatterns),
                'permissions' => count($this->permissionKeys()),
                'notification_types' => count($this->notificationDefinitions),
                'navigation_routes' => count($this->navigationRoutes),
                'dashboard_widgets' => count($this->dashboardWidgets),
                'settings_groups' => count($this->settingsGroups),
                'owned_tables' => count($this->ownedTables),
                'platform_view_paths' => count($this->platformViewPaths),
                'module_view_paths' => count($this->moduleViewPaths),
                'ui_entries' => count($this->uiEntries),
                'setup_routes' => count($this->setupRoutes),
                'audit_events' => count($this->auditEvents),
                'commands' => count($this->commands),
            ],
        ];
    }
}
