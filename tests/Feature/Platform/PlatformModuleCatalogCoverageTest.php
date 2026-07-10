<?php

/*
|--------------------------------------------------------------------------
| File: tests/Feature/Platform/PlatformModuleCatalogCoverageTest.php
| Purpose: Verifies module ownership coverage for app routes and surfaces.
|--------------------------------------------------------------------------
*/

namespace Tests\Feature\Platform;

use App\Core\Modules\UiAccessMode;
use App\Core\Modules\Category;
use App\Core\Modules\Repository;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\UiPlacement;
use App\Modules\Notifications\Services\NotificationPermissions;
use App\Modules\Roles\Services\PermissionCatalog;
use App\Modules\Roles\Services\RoleCatalog;
use App\Modules\Settings\Services\SettingsPermissions;
use App\Modules\Setup\Services\SetupPermissions;
use App\Platform\Dashboard\WidgetRegistry;
use Illuminate\Routing\Route as LaravelRoute;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PlatformModuleCatalogCoverageTest extends TestCase
{
    public function test_app_owned_web_routes_have_exactly_one_module_owner(): void
    {
        $registry = app(Repository::class);

        foreach ($this->appOwnedRouteNames() as $routeName) {
            $owners = $registry->ownersForRoute($routeName);

            $this->assertCount(1, $owners, "Route [{$routeName}] must have exactly one module owner.");
        }
    }

    public function test_navigation_routes_have_exactly_one_module_owner(): void
    {
        $registry = app(Repository::class);

        foreach ($this->navigationRoutes() as $routeName) {
            $owners = $registry->ownersForNavigationRoute($routeName);

            $this->assertCount(1, $owners, "Navigation route [{$routeName}] must have exactly one module owner.");
        }
    }

    public function test_dashboard_widgets_are_inactive_until_rebuild(): void
    {
        $registry = app(Repository::class);
        $widgetRegistry = app(WidgetRegistry::class);

        $widgets = collect($widgetRegistry->knownKeys())
            ->merge(collect($widgetRegistry->defaults())->pluck('widget_key'))
            ->unique()
            ->sort()
            ->values();

        $this->assertSame([], $widgets->all());
        $this->assertSame([], collect($registry->all())->flatMap(fn ($module): array => $module->dashboardWidgets)->values()->all());
    }

    public function test_seeded_permissions_have_exactly_one_module_owner(): void
    {
        $registry = app(Repository::class);

        foreach ($this->seededPermissionNames() as $permission) {
            $owners = $registry->ownersForPermission($permission);

            $this->assertCount(1, $owners, "Permission [{$permission}] must have exactly one module owner.");
        }
    }

    public function test_seeded_permissions_have_structured_metadata(): void
    {
        $definitions = collect(app(PermissionCatalog::class)->definitions())->keyBy('key');

        foreach ($this->seededPermissionNames() as $permission) {
            $this->assertTrue($definitions->has($permission), "Permission [{$permission}] must have structured metadata.");

            $definition = $definitions->get($permission);

            $this->assertNotEmpty($definition->label, $permission);
            $this->assertNotEmpty($definition->description, $permission);
            $this->assertNotEmpty($definition->groupKey, $permission);
            $this->assertNotEmpty($definition->groupLabel, $permission);
        }
    }

    public function test_ability_backed_ui_entries_map_to_declared_gates_and_permission_metadata(): void
    {
        $registry = app(Repository::class);
        $definitions = collect(app(PermissionCatalog::class)->definitions())->keyBy('key');
        $abilityPermissions = $this->abilityPermissionMap();

        $entries = collect($registry->all())
            ->flatMap(fn ($module): array => $module->uiEntries)
            ->filter(fn ($entry): bool => $entry->access === UiAccessMode::Ability)
            ->values();

        $this->assertNotEmpty($entries);

        foreach ($entries as $entry) {
            $this->assertNotEmpty($entry->accessValue, $entry->key);
            $this->assertArrayHasKey($entry->accessValue, $abilityPermissions, "UI entry [{$entry->key}] uses unmapped ability [{$entry->accessValue}].");
            $this->assertTrue(Gate::has($entry->accessValue), "UI entry [{$entry->key}] uses undefined Gate ability [{$entry->accessValue}].");

            foreach ($abilityPermissions[$entry->accessValue] as $permission) {
                $this->assertTrue($definitions->has($permission), "Gate ability [{$entry->accessValue}] permission [{$permission}] must have structured metadata.");
                $this->assertCount(1, $registry->ownersForPermission($permission), "Gate ability [{$entry->accessValue}] permission [{$permission}] must have exactly one module owner.");
            }
        }
    }

    public function test_gate_backed_feature_permissions_have_module_owners(): void
    {
        $registry = app(Repository::class);

        foreach ($this->abilityPermissionMap() as $ability => $permissions) {
            $this->assertTrue(Gate::has($ability), "Expected Gate ability [{$ability}] to be registered.");

            foreach ($permissions as $permission) {
                $this->assertCount(1, $registry->ownersForPermission($permission), "Gate ability [{$ability}] permission [{$permission}] must have exactly one module owner.");
            }
        }
    }

    public function test_platform_view_directories_have_exactly_one_module_owner(): void
    {
        $registry = app(Repository::class);

        foreach ($this->platformViewPaths() as $path) {
            $owners = $registry->ownersForPlatformViewPath($path);

            $this->assertCount(1, $owners, "Platform view path [{$path}] must have exactly one module owner.");
        }
    }

    public function test_module_view_directories_have_exactly_one_module_owner_when_present(): void
    {
        $registry = app(Repository::class);

        foreach ($this->moduleViewPaths() as $path) {
            $owners = $registry->ownersForModuleViewPath($path);

            $this->assertCount(1, $owners, "Module view path [{$path}] must have exactly one module owner.");
        }
    }

    public function test_platform_management_modules_with_platform_views_are_not_tenant_eligible(): void
    {
        $registry = app(Repository::class);

        foreach ($registry->byType(Category::PlatformManagement) as $module) {
            if ($module->platformViewPaths === []) {
                continue;
            }

            $this->assertFalse($module->tenantEligible, "Platform-management module [{$module->key}] owns platform views and must not be tenant eligible by default.");
        }
    }

    public function test_navigation_routes_have_matching_ui_entry_metadata(): void
    {
        $registry = app(Repository::class);

        foreach ($this->navigationRoutes() as $routeName) {
            $owners = $registry->ownersForUiEntryRoute(UiEntryType::NavigationItem, $routeName);

            $this->assertCount(1, $owners, "Navigation route [{$routeName}] must have exactly one module-owned navigation UI entry.");
        }
    }

    public function test_dashboard_widget_ui_entries_are_inactive_until_rebuild(): void
    {
        $registry = app(Repository::class);
        $widgetRegistry = app(WidgetRegistry::class);

        $widgets = collect($widgetRegistry->knownKeys())
            ->merge(collect($widgetRegistry->defaults())->pluck('widget_key'))
            ->unique()
            ->sort()
            ->values();

        $this->assertSame([], $widgets->all());
        $this->assertSame([], $registry->uiEntries(UiEntryType::DashboardWidget, UiPlacement::Dashboard));
    }

    public function test_settings_page_routes_have_matching_ui_entry_metadata(): void
    {
        $registry = app(Repository::class);

        foreach ($this->settingsPageRouteNames() as $routeName) {
            $owners = $registry->ownersForUiEntryRoute(UiEntryType::SettingsPage, $routeName);

            $this->assertCount(1, $owners, "Settings page route [{$routeName}] must have exactly one module-owned settings page UI entry.");
        }
    }

    public function test_settings_page_ui_entries_have_sidebar_metadata(): void
    {
        $registry = app(Repository::class);
        $entries = $registry->uiEntries(UiEntryType::SettingsPage, UiPlacement::SettingsSidebar);

        $this->assertNotEmpty($entries);

        foreach ($entries as $entry) {
            $this->assertSame(UiAccessMode::Ability, $entry->access, $entry->key);
            $this->assertNotEmpty($entry->accessValue, $entry->key);
            $this->assertNotEmpty($entry->routeName, $entry->key);
            $this->assertNotEmpty($entry->viewPath, $entry->key);
            $this->assertNotEmpty($entry->icon, $entry->key);
            $this->assertNotEmpty($entry->groupKey, $entry->key);
            $this->assertNotEmpty($entry->groupLabel, $entry->key);
        }
    }

    public function test_preference_page_routes_have_matching_ui_entry_metadata(): void
    {
        $registry = app(Repository::class);

        foreach ($this->preferencePageRouteNames() as $routeName) {
            $owners = $registry->ownersForUiEntryRoute(UiEntryType::PreferencePage, $routeName);

            $this->assertCount(1, $owners, "Preference page route [{$routeName}] must have exactly one module-owned preference page UI entry.");
        }
    }

    public function test_preference_page_ui_entries_have_navigation_metadata(): void
    {
        $registry = app(Repository::class);
        $entries = $registry->uiEntries(UiEntryType::PreferencePage, UiPlacement::PreferencesNavigation);

        $this->assertNotEmpty($entries);

        foreach ($entries as $entry) {
            $this->assertNotNull($entry->access, $entry->key);
            $this->assertNotEmpty($entry->routeName, $entry->key);
            $this->assertNotEmpty($entry->viewPath, $entry->key);
            $this->assertNotEmpty($entry->icon, $entry->key);
            $this->assertNotEmpty($entry->groupKey, $entry->key);
            $this->assertNotEmpty($entry->groupLabel, $entry->key);
        }
    }

    public function test_header_global_action_ui_entries_have_initial_metadata(): void
    {
        $registry = app(Repository::class);
        $entries = collect($registry->uiEntries(UiEntryType::HeaderGlobalAction, UiPlacement::HeaderGlobalActions))
            ->keyBy('key');

        $this->assertSame([
            'account.header.global-action',
            'notifications.header.global-action',
            'settings.header.global-action',
        ], $entries->keys()->sort()->values()->all());

        foreach ($entries as $entry) {
            $this->assertContains($entry->access, [UiAccessMode::Ability, UiAccessMode::Authenticated], $entry->key);
            if ($entry->access === UiAccessMode::Ability) {
                $this->assertNotEmpty($entry->accessValue, $entry->key);
            }
            $this->assertNotEmpty($entry->label, $entry->key);
            $this->assertNotEmpty($entry->icon, $entry->key);
            $this->assertTrue(
                filled($entry->routeName) || filled($entry->panelTarget),
                "Header global action [{$entry->key}] must declare a route or panel target.",
            );
        }

        $this->assertSame('platform.account.index', $entries['account.header.global-action']->routeName);
        $this->assertSame('app-account-menu', $entries['account.header.global-action']->panelTarget);
        $this->assertSame('account::header.action', $entries['account.header.global-action']->componentView);
        $this->assertSame(
            \App\Modules\Account\Header\MenuDataProvider::class,
            $entries['account.header.global-action']->dataProvider,
        );
        $this->assertSame('settings.index', $entries['settings.header.global-action']->routeName);
        $this->assertNull($entries['settings.header.global-action']->componentView);
        $this->assertNull($entries['settings.header.global-action']->dataProvider);
        $this->assertSame('notifications.index', $entries['notifications.header.global-action']->routeName);
        $this->assertSame('app-header-notifications', $entries['notifications.header.global-action']->panelTarget);
        $this->assertSame('notifications::header.action', $entries['notifications.header.global-action']->componentView);
        $this->assertSame(
            \App\Modules\Notifications\Header\PanelDataProvider::class,
            $entries['notifications.header.global-action']->dataProvider,
        );
    }

    public function test_setup_routes_have_matching_ui_entry_metadata(): void
    {
        $registry = app(Repository::class);

        foreach ($this->setupRouteNames() as $routeName) {
            $owners = $registry->ownersForUiEntryRoute(UiEntryType::SetupScreen, $routeName);

            $this->assertCount(1, $owners, "Setup route [{$routeName}] must have exactly one module-owned setup screen UI entry.");
        }
    }

    public function test_setup_screen_ui_entries_have_navigation_metadata(): void
    {
        $registry = app(Repository::class);
        $entries = $registry->uiEntries(UiEntryType::SetupScreen, UiPlacement::SetupNavigation);

        $this->assertNotEmpty($entries);

        foreach ($entries as $entry) {
            $this->assertSame(UiAccessMode::Ability, $entry->access, $entry->key);
            $this->assertNotEmpty($entry->accessValue, $entry->key);
            $this->assertNotEmpty($entry->routeName, $entry->key);
            $this->assertNotEmpty($entry->viewPath, $entry->key);
            $this->assertNotEmpty($entry->icon, $entry->key);
        }
    }

    public function test_platform_view_paths_have_matching_content_ui_entry_metadata(): void
    {
        $registry = app(Repository::class);

        foreach ($this->platformViewPaths() as $path) {
            $owners = $registry->ownersForUiEntryViewPath(UiEntryType::MainView, $path);

            $this->assertCount(1, $owners, "Platform view path [{$path}] must have exactly one module-owned content UI entry.");
        }
    }

    public function test_platform_management_ui_entries_are_not_tenant_eligible_by_default(): void
    {
        $registry = app(Repository::class);

        foreach ($registry->byType(Category::PlatformManagement) as $module) {
            foreach ($module->uiEntries as $entry) {
                $this->assertFalse($entry->tenantEligible, "Platform-management UI entry [{$entry->key}] must not be tenant eligible by default.");
            }
        }
    }

    /**
     * @return list<string>
     */
    private function appOwnedRouteNames(): array
    {
        return collect(Route::getRoutes())
            ->map(fn (LaravelRoute $route): ?string => $route->getName())
            ->filter(fn (?string $name): bool => is_string($name) && $this->isAppOwnedRouteName($name))
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    private function isAppOwnedRouteName(string $name): bool
    {
        return $name === 'dashboard'
            || str_starts_with($name, 'dashboard.')
            || $name === 'logout'
            || $name === 'login'
            || str_starts_with($name, 'login.')
            || str_starts_with($name, 'mfa.')
            || str_starts_with($name, 'settings.')
            || str_starts_with($name, 'roles.')
            || str_starts_with($name, 'notifications.')
            || str_starts_with($name, 'platform.');
    }

    /**
     * @return list<string>
     */
    private function settingsPageRouteNames(): array
    {
        return collect(Route::getRoutes())
            ->map(fn (LaravelRoute $route): ?string => $route->getName())
            ->filter(fn (?string $name): bool => is_string($name)
                && str_starts_with($name, 'platform.settings.')
                && $name !== 'platform.settings.index'
                && ! str_ends_with($name, '.update')
                // Legacy direct URLs remain transitional route targets, but they are not
                // current Settings sidebar contributions until their modules are packaged.
                && ! in_array($name, [
                    'platform.settings.general',
                    'platform.settings.general.company-information',
                    'platform.settings.general.email',
                    'platform.settings.general.localization',
                    'platform.settings.general.system-server-info',
                    'platform.settings.general.system-update',
                    'platform.settings.audit-logs',
                    'platform.settings.docs',
                    'platform.settings.users',
                ], true))
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    private function preferencePageRouteNames(): array
    {
        return collect(Route::getRoutes())
            ->map(fn (LaravelRoute $route): ?string => $route->getName())
            ->filter(fn (?string $name): bool => is_string($name)
                && str_starts_with($name, 'platform.account.preferences')
                && ! str_ends_with($name, '.update'))
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    private function setupRouteNames(): array
    {
        return collect(Route::getRoutes())
            ->map(fn (LaravelRoute $route): ?string => $route->getName())
            ->filter(fn (?string $name): bool => is_string($name) && str_starts_with($name, 'platform.setup.'))
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    private function navigationRoutes(): array
    {
        return collect(config('navigation', []))
            ->flatMap(fn (array $items): array => $this->extractNavigationRoutes($items))
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    /**
     * @param  array<int|string, mixed>  $items
     * @return list<string>
     */
    private function extractNavigationRoutes(array $items): array
    {
        $routes = [];

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            if (isset($item['route']) && is_string($item['route'])) {
                $routes[] = $item['route'];
            }

            foreach ($item as $value) {
                if (is_array($value)) {
                    array_push($routes, ...$this->extractNavigationRoutes($value));
                }
            }
        }

        return $routes;
    }

    /**
     * @return list<string>
     */
    private function seededPermissionNames(): array
    {
        return app(PermissionCatalog::class)->all();
    }

    /**
     * @return array<string, list<string>>
     */
    private function abilityPermissionMap(): array
    {
        return [
            'manage-platform-security-checklist' => ['platform.security-checklist.manage'],
            'manage-platform-settings' => [SettingsPermissions::UPDATE, SettingsPermissions::MANAGE],
            'manage-platform-users' => ['platform.users.manage'],
            NotificationPermissions::MANAGE => [NotificationPermissions::MANAGE],
            NotificationPermissions::SETTINGS_UPDATE => [NotificationPermissions::SETTINGS_UPDATE, NotificationPermissions::MANAGE],
            NotificationPermissions::SETTINGS_VIEW => [NotificationPermissions::SETTINGS_VIEW, NotificationPermissions::SETTINGS_UPDATE, NotificationPermissions::MANAGE],
            NotificationPermissions::VIEW => [NotificationPermissions::VIEW, NotificationPermissions::MANAGE],
            RoleCatalog::CREATE => [RoleCatalog::CREATE, RoleCatalog::MANAGE],
            RoleCatalog::DELETE => [RoleCatalog::DELETE, RoleCatalog::MANAGE],
            RoleCatalog::MANAGE => [RoleCatalog::MANAGE],
            RoleCatalog::PERMISSIONS_VIEW => [RoleCatalog::PERMISSIONS_VIEW, RoleCatalog::MANAGE],
            RoleCatalog::UPDATE => [RoleCatalog::UPDATE, RoleCatalog::MANAGE],
            RoleCatalog::VIEW => [RoleCatalog::VIEW, RoleCatalog::MANAGE],
            SettingsPermissions::MANAGE => [SettingsPermissions::MANAGE],
            SettingsPermissions::UPDATE => [SettingsPermissions::UPDATE, SettingsPermissions::MANAGE],
            SettingsPermissions::VIEW => [SettingsPermissions::VIEW, SettingsPermissions::UPDATE, SettingsPermissions::MANAGE],
            SetupPermissions::VIEW => [SetupPermissions::VIEW, RoleCatalog::VIEW, RoleCatalog::MANAGE, NotificationPermissions::VIEW],
            'view-platform-audit-logs' => ['platform.audit-logs.view'],
            'view-platform-docs' => ['platform.docs.view'],
            'view-platform-error-logs' => ['platform.error-logs.view'],
            'view-platform-notifications' => [NotificationPermissions::VIEW, NotificationPermissions::MANAGE],
            'view-platform-security-checklist' => ['platform.security-checklist.view', 'platform.security-checklist.manage'],
            'view-platform-settings' => [SettingsPermissions::VIEW, SettingsPermissions::UPDATE, SettingsPermissions::MANAGE],
            'view-platform-setup' => [SetupPermissions::VIEW, RoleCatalog::VIEW, RoleCatalog::MANAGE, NotificationPermissions::VIEW],
            'view-platform-users' => ['platform.users.view', 'platform.users.manage'],
        ];
    }

    /**
     * @return list<string>
     */
    private function platformViewPaths(): array
    {
        return $this->immediateViewDirectories('platform');
    }

    /**
     * @return list<string>
     */
    private function moduleViewPaths(): array
    {
        $absoluteRoot = base_path('Modules');

        if (! File::isDirectory($absoluteRoot)) {
            return [];
        }

        return collect(File::directories($absoluteRoot))
            ->reject(fn (string $path): bool => str_starts_with(basename($path), '_'))
            ->map(fn (string $path): string => 'Modules/'.basename($path).'/resources/views')
            ->filter(fn (string $path): bool => File::isDirectory(base_path($path)))
            ->sort()
            ->values()
            ->all();
    }

    /**
     * @return list<string>
     */
    private function immediateViewDirectories(string $viewRoot): array
    {
        $absoluteRoot = resource_path("views/{$viewRoot}");

        if (! File::isDirectory($absoluteRoot)) {
            return [];
        }

        return collect(File::directories($absoluteRoot))
            ->map(fn (string $path): string => "resources/views/{$viewRoot}/".basename($path))
            ->sort()
            ->values()
            ->all();
    }
}
