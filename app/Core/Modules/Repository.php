<?php
/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/Repository.php
| Purpose: Validates module manifests and exposes ownership lookups.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules;

use App\Core\Modules\Definitions\Permission;
use App\Core\Modules\Definitions\NotificationType;
use Illuminate\Support\Str;
use InvalidArgumentException;


final class Repository
{
    /** @var array<string, Manifest> */
    private array $modules;

    /**
     * @param  list<Manifest>  $modules
     */
    public function __construct(array $modules)
    {
        $this->modules = [];

        foreach ($modules as $module) {
            if (isset($this->modules[$module->key])) {
                throw new InvalidArgumentException("Module key [{$module->key}] is already registered.");
            }

            $this->modules[$module->key] = $module;
        }

        $this->validateDependencies();
        $this->validatePermissionDefinitions();
        $this->validateNotificationDefinitions();
        $this->validateExclusiveResourceOwnership('permission', fn (Manifest $module): array => $module->permissionKeys());
        $this->validateExclusiveResourceOwnership('notification type', fn (Manifest $module): array => collect($module->notificationDefinitions)
            ->map(fn (NotificationType $type): string => $type->key)
            ->all());
        $this->validateExclusiveResourceOwnership('navigation route', fn (Manifest $module): array => $module->navigationRoutes);
        $this->validateExclusiveResourceOwnership('dashboard widget', fn (Manifest $module): array => $module->dashboardWidgets);
        $this->validateExclusiveResourceOwnership('setting group', fn (Manifest $module): array => $module->settingsGroups);
        $this->validateExclusiveResourceOwnership('owned table', fn (Manifest $module): array => $module->ownedTables);
        $this->validatePlatformViewPathShapes();
        $this->validateModuleViewPathShapes();
        $this->validateExclusiveResourceOwnership('platform view path', fn (Manifest $module): array => $module->platformViewPaths);
        $this->validateExclusiveResourceOwnership('module view path', fn (Manifest $module): array => $module->moduleViewPaths);
        $this->validateExclusiveResourceOwnership('command', fn (Manifest $module): array => $module->commands);
        $this->validateUiEntries();
    }

    /**
     * @return array<string, Manifest>
     */
    public function all(): array
    {
        return $this->modules;
    }

    /**
     * @return list<Manifest>
     */
    public function byType(Category $type): array
    {
        return array_values(array_filter(
            $this->modules,
            fn (Manifest $module): bool => $module->type === $type,
        ));
    }

    public function get(string $key): Manifest
    {
        return $this->modules[$key]
            ?? throw new InvalidArgumentException("Module key [{$key}] is not registered.");
    }

    /**
     * @return list<Manifest>
     */
    public function ownersForRoute(string $routeName): array
    {
        return $this->ownersMatching(fn (Manifest $module): bool => $this->routeBelongsTo($module, $routeName));
    }

    /**
     * @return list<Manifest>
     */
    public function ownersForPermission(string $permission): array
    {
        return $this->ownersContaining(fn (Manifest $module): array => $module->permissionKeys(), $permission);
    }

    /**
     * @return list<Manifest>
     */
    public function ownersForNavigationRoute(string $route): array
    {
        return $this->ownersContaining(fn (Manifest $module): array => $module->navigationRoutes, $route);
    }

    /**
     * @return list<Manifest>
     */
    public function ownersForDashboardWidget(string $widget): array
    {
        return $this->ownersContaining(fn (Manifest $module): array => $module->dashboardWidgets, $widget);
    }

    /**
     * @return list<Manifest>
     */
    public function ownersForCommand(string $command): array
    {
        return $this->ownersContaining(fn (Manifest $module): array => $module->commands, $command);
    }

    /**
     * @return list<Manifest>
     */
    public function ownersForNotificationType(string $type): array
    {
        return $this->ownersContaining(
            fn (Manifest $module): array => collect($module->notificationDefinitions)
                ->map(fn (NotificationType $definition): string => $definition->key)
                ->all(),
            $type,
        );
    }

    /**
     * @return list<NotificationType>
     */
    public function notificationDefinitions(): array
    {
        return collect($this->modules)
            ->flatMap(fn (Manifest $module): array => $module->notificationDefinitions)
            ->values()
            ->all();
    }

    /**
     * @return list<Manifest>
     */
    public function ownersForPlatformViewPath(string $path): array
    {
        return $this->ownersContaining(fn (Manifest $module): array => $module->platformViewPaths, $path);
    }

    /**
     * @return list<Manifest>
     */
    public function ownersForModuleViewPath(string $path): array
    {
        return $this->ownersContaining(fn (Manifest $module): array => $module->moduleViewPaths, $path);
    }

    /**
     * @return list<Manifest>
     */
    public function ownersForUiEntryKey(string $key): array
    {
        return $this->ownersForUiEntryMatching(
            fn (UiEntry $entry): bool => $entry->key === $key,
        );
    }

    /**
     * @return list<Manifest>
     */
    public function ownersForUiEntryRoute(UiEntryType $type, string $routeName): array
    {
        return $this->ownersForUiEntryMatching(
            fn (UiEntry $entry): bool => $entry->type === $type && $entry->routeName === $routeName,
        );
    }

    /**
     * @return list<Manifest>
     */
    public function ownersForUiEntryWidget(string $widgetKey): array
    {
        return $this->ownersForUiEntryMatching(
            fn (UiEntry $entry): bool => $entry->type === UiEntryType::DashboardWidget && $entry->widgetKey === $widgetKey,
        );
    }

    /**
     * @return list<Manifest>
     */
    public function ownersForUiEntryViewPath(UiEntryType $type, string $viewPath): array
    {
        return $this->ownersForUiEntryMatching(
            fn (UiEntry $entry): bool => $entry->type === $type && $entry->viewPath === $viewPath,
        );
    }

    /**
     * @return list<UiEntry>
     */
    public function uiEntries(?UiEntryType $type = null, ?UiPlacement $placement = null): array
    {
        return collect($this->modules)
            ->flatMap(fn (Manifest $module): array => $module->uiEntries)
            ->filter(fn (UiEntry $entry): bool => $type === null || $entry->type === $type)
            ->filter(fn (UiEntry $entry): bool => $placement === null || $entry->placement === $placement)
            ->values()
            ->all();
    }

    /**
     * @return list<UiEntry>
     */
    public function settingsPageEntries(): array
    {
        return $this->uiEntries(UiEntryType::SettingsPage, UiPlacement::SettingsSidebar);
    }

    /**
     * @return list<UiEntry>
     */
    public function setupScreenEntries(): array
    {
        return $this->uiEntries(UiEntryType::SetupScreen, UiPlacement::SetupNavigation);
    }

    /**
     * @return list<UiEntry>
     */
    public function preferencePageEntries(): array
    {
        return $this->uiEntries(UiEntryType::PreferencePage, UiPlacement::PreferencesNavigation);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function summaries(?Category $type = null): array
    {
        $modules = $type === null ? array_values($this->modules) : $this->byType($type);

        return array_map(
            fn (Manifest $module): array => $module->toSummaryArray(),
            $modules,
        );
    }

    private function routeBelongsTo(Manifest $module, string $routeName): bool
    {
        foreach (array_merge($module->routePatterns, $module->setupRoutes) as $pattern) {
            if (Str::is($pattern, $routeName)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return list<Manifest>
     */
    private function ownersContaining(callable $selector, string $needle): array
    {
        return $this->ownersMatching(
            fn (Manifest $module): bool => in_array($needle, $selector($module), true),
        );
    }

    /**
     * @return list<Manifest>
     */
    private function ownersMatching(callable $predicate): array
    {
        return array_values(array_filter($this->modules, $predicate));
    }

    private function validateDependencies(): void
    {
        foreach ($this->modules as $module) {
            foreach ($module->dependencies as $dependency) {
                if ($dependency === $module->key) {
                    throw new InvalidArgumentException("Module [{$module->key}] cannot depend on itself.");
                }

                if (! isset($this->modules[$dependency])) {
                    throw new InvalidArgumentException("Module [{$module->key}] references unknown dependency [{$dependency}].");
                }
            }
        }
    }

    private function validatePermissionDefinitions(): void
    {
        foreach ($this->modules as $module) {
            foreach ($module->permissionDefinitions as $permission) {
                if (! $permission instanceof Permission) {
                    throw new InvalidArgumentException("Module [{$module->key}] has an invalid permission definition.");
                }
            }
        }
    }

    private function validateNotificationDefinitions(): void
    {
        foreach ($this->modules as $module) {
            foreach ($module->notificationDefinitions as $type) {
                if (! $type instanceof NotificationType) {
                    throw new InvalidArgumentException("Module [{$module->key}] has an invalid notification type definition.");
                }

                if (! str_starts_with($type->key, "{$module->key}.")) {
                    throw new InvalidArgumentException("Notification type [{$type->key}] must be owned by module [{$module->key}].");
                }
            }
        }
    }

    private function validatePlatformViewPathShapes(): void
    {
        foreach ($this->modules as $module) {
            foreach ($module->platformViewPaths as $path) {
                if (! $this->isValidRepoPath($path) || ! str_starts_with($path, 'resources/views/platform/') || $path === 'resources/views/platform/') {
                    $this->throwInvalidViewPath($module, 'platform view path', $path, 'repo-relative forward-slash paths under [resources/views/platform/] without leading or trailing slashes');
                }
            }
        }
    }

    private function validateModuleViewPathShapes(): void
    {
        foreach ($this->modules as $module) {
            foreach ($module->moduleViewPaths as $path) {
                if (! $this->isValidRepoPath($path) || ! $this->isPackageViewPath($path)) {
                    $this->throwInvalidViewPath($module, 'module view path', $path, 'repo-relative forward-slash paths under [Modules/<ModuleName>/resources/views] without leading or trailing slashes');
                }
            }
        }
    }

    private function validateUiEntries(): void
    {
        $entryOwners = [];
        $extensionPointOwners = [];

        foreach ($this->modules as $module) {
            foreach ($module->uiEntries as $entry) {
                if (! $entry instanceof UiEntry) {
                    throw new InvalidArgumentException("Module [{$module->key}] has an invalid UI entry entry.");
                }

                if (isset($entryOwners[$entry->key])) {
                    throw new InvalidArgumentException("UI entry [{$entry->key}] is owned by both [{$entryOwners[$entry->key]}] and [{$module->key}].");
                }

                $entryOwners[$entry->key] = $module->key;

                $this->validateUiEntryShape($module, $entry);

                if ($entry->type === UiEntryType::ExtensionPoint) {
                    if (isset($extensionPointOwners[$entry->extensionPoint])) {
                        throw new InvalidArgumentException("Extension point [{$entry->extensionPoint}] is owned by both [{$extensionPointOwners[$entry->extensionPoint]}] and [{$module->key}].");
                    }

                    $extensionPointOwners[$entry->extensionPoint] = $module->key;
                }
            }
        }

        foreach ($this->modules as $module) {
            foreach ($module->uiEntries as $entry) {
                if ($entry->type !== UiEntryType::ExtensionContribution) {
                    continue;
                }

                $targetOwner = $extensionPointOwners[$entry->targetExtensionPoint] ?? null;

                if ($targetOwner === null) {
                    throw new InvalidArgumentException("UI entry [{$entry->key}] targets unknown extension point [{$entry->targetExtensionPoint}].");
                }

                if ($targetOwner !== $module->key && ! in_array($targetOwner, $module->dependencies, true)) {
                    throw new InvalidArgumentException("UI entry [{$entry->key}] contributes to extension point [{$entry->targetExtensionPoint}] owned by [{$targetOwner}] but module [{$module->key}] does not depend on it.");
                }
            }
        }
    }

    private function validateUiEntryShape(Manifest $module, UiEntry $entry): void
    {
        $this->validateUiEntryKey($module, $entry);
        $this->validateUiEntryAccess($module, $entry);
        $this->validateUiEntryPlacement($entry);

        if ($entry->tenantEligible && ! $module->tenantEligible) {
            throw new InvalidArgumentException("UI entry [{$entry->key}] cannot be tenant eligible because module [{$module->key}] is not tenant eligible.");
        }

        match ($entry->type) {
            UiEntryType::NavigationItem => $this->requireUiFields($entry, ['label', 'routeName']),
            UiEntryType::HeaderGlobalAction => $this->requireHeaderGlobalActionFields($entry),
            UiEntryType::SettingsPage => $this->requireUiFields($entry, ['label', 'routeName', 'viewPath', 'icon', 'groupKey', 'groupLabel']),
            UiEntryType::PreferencePage => $this->requireUiFields($entry, ['label', 'routeName', 'viewPath', 'icon', 'groupKey', 'groupLabel']),
            UiEntryType::SetupScreen => $this->requireUiFields($entry, ['label', 'routeName', 'viewPath', 'icon']),
            UiEntryType::DashboardWidget => $this->requireUiFields($entry, ['widgetKey']),
            UiEntryType::MainView => $this->requireUiFields($entry, ['routeName', 'viewPath']),
            UiEntryType::ExtensionPoint => $this->requireUiFields($entry, ['extensionPoint']),
            UiEntryType::ExtensionContribution => $this->requireExtensionContributionFields($entry),
        };

        if ($entry->viewPath !== null) {
            $this->validateUiEntryViewPath($entry);
        }

        $this->validateUiEntryActiveRoutePatterns($entry);
    }

    private function validateUiEntryPlacement(UiEntry $entry): void
    {
        $expected = match ($entry->type) {
            UiEntryType::HeaderGlobalAction => UiPlacement::HeaderGlobalActions,
            UiEntryType::SettingsPage => UiPlacement::SettingsSidebar,
            UiEntryType::PreferencePage => UiPlacement::PreferencesNavigation,
            UiEntryType::SetupScreen => UiPlacement::SetupNavigation,
            UiEntryType::DashboardWidget => UiPlacement::Dashboard,
            UiEntryType::MainView => UiPlacement::Main,
            UiEntryType::ExtensionPoint, UiEntryType::ExtensionContribution => UiPlacement::Extension,
            UiEntryType::NavigationItem => null,
        };

        if ($expected !== null && $entry->placement !== $expected) {
            throw new InvalidArgumentException("UI entry [{$entry->key}] uses placement [{$entry->placement->value}] but [{$expected->value}] is required for [{$entry->type->value}].");
        }
    }

    private function validateUiEntryKey(Manifest $module, UiEntry $entry): void
    {
        if ($entry->key === '' || $entry->key !== trim($entry->key) || str_contains($entry->key, ' ')) {
            throw new InvalidArgumentException("Module [{$module->key}] has invalid UI entry key [{$entry->key}].");
        }
    }

    private function validateUiEntryAccess(Manifest $module, UiEntry $entry): void
    {
        if ($entry->type !== UiEntryType::ExtensionPoint && $entry->access === null) {
            throw new InvalidArgumentException("UI entry [{$entry->key}] owned by [{$module->key}] requires explicit access metadata.");
        }

        if ($entry->access === null) {
            return;
        }

        $requiresAccessValue = in_array($entry->access, [
            UiAccessMode::Permission,
            UiAccessMode::Ability,
        ], true);

        if ($requiresAccessValue && ! $this->filledString($entry->accessValue)) {
            throw new InvalidArgumentException("UI entry [{$entry->key}] requires an access value for [{$entry->access->value}] access.");
        }

        if (! $requiresAccessValue && $entry->accessValue !== null) {
            throw new InvalidArgumentException("UI entry [{$entry->key}] must not define an access value for [{$entry->access->value}] access.");
        }
    }

    /**
     * @param  list<string>  $fields
     */
    private function requireUiFields(UiEntry $entry, array $fields): void
    {
        foreach ($fields as $field) {
            if (! $this->filledString($entry->{$field})) {
                throw new InvalidArgumentException("UI entry [{$entry->key}] requires [{$field}].");
            }
        }
    }

    private function requireHeaderGlobalActionFields(UiEntry $entry): void
    {
        $this->requireUiFields($entry, ['label', 'icon']);

        if (! $this->filledString($entry->routeName) && ! $this->filledString($entry->panelTarget)) {
            throw new InvalidArgumentException("UI entry [{$entry->key}] requires [routeName] or [panelTarget].");
        }

        if (! $this->filledString($entry->componentView) && ! $this->filledString($entry->routeName)) {
            throw new InvalidArgumentException("UI entry [{$entry->key}] requires [routeName] when [componentView] is not defined.");
        }

        if ($this->filledString($entry->dataProvider) && ! $this->filledString($entry->componentView)) {
            throw new InvalidArgumentException("UI entry [{$entry->key}] requires [componentView] when [dataProvider] is defined.");
        }

        foreach (['componentView', 'panelView'] as $viewField) {
            if ($entry->{$viewField} !== null && ! $this->isValidViewReference($entry->{$viewField})) {
                throw new InvalidArgumentException("UI entry [{$entry->key}] has invalid [{$viewField}].");
            }
        }

        if ($entry->dataProvider !== null && (! $this->filledString($entry->dataProvider) || ! class_exists($entry->dataProvider))) {
            throw new InvalidArgumentException("UI entry [{$entry->key}] has invalid [dataProvider].");
        }
    }

    private function requireExtensionContributionFields(UiEntry $entry): void
    {
        $this->requireUiFields($entry, ['targetExtensionPoint']);

        if (
            ! $this->filledString($entry->routeName)
            && ! $this->filledString($entry->viewPath)
            && ! $this->filledString($entry->widgetKey)
        ) {
            throw new InvalidArgumentException("UI entry [{$entry->key}] requires a route, view, or widget target.");
        }
    }

    private function validateUiEntryViewPath(UiEntry $entry): void
    {
        $path = $entry->viewPath;

        if (
            ! is_string($path)
            || $path !== trim($path)
            || str_contains($path, '\\')
            || str_starts_with($path, '/')
            || str_ends_with($path, '/')
            || str_contains($path, '//')
            || (! str_starts_with($path, 'resources/views/') && ! $this->isPackageViewPath($path))
        ) {
            throw new InvalidArgumentException("UI entry [{$entry->key}] has invalid view path [{$path}].");
        }
    }

    private function validateUiEntryActiveRoutePatterns(UiEntry $entry): void
    {
        foreach ($entry->activeRoutePatterns as $pattern) {
            if (! $this->filledString($pattern)) {
                throw new InvalidArgumentException("UI entry [{$entry->key}] has an invalid active route pattern.");
            }
        }
    }

    private function filledString(?string $value): bool
    {
        return is_string($value) && trim($value) !== '';
    }

    private function isValidRepoPath(mixed $path): bool
    {
        return is_string($path)
            && $path === trim($path)
            && ! str_contains($path, '\\')
            && ! str_starts_with($path, '/')
            && ! str_ends_with($path, '/')
            && ! str_contains($path, '//');
    }

    private function isPackageViewPath(string $path): bool
    {
        return (bool) preg_match('#^Modules/[A-Z][A-Za-z0-9]*/resources/views(?:/.+)?$#', $path);
    }

    private function isValidViewReference(string $view): bool
    {
        return $view !== ''
            && $view === trim($view)
            && ! str_contains($view, '\\')
            && ! str_contains($view, '/')
            && ! str_contains($view, ' ')
            && ! str_starts_with($view, '.')
            && ! str_ends_with($view, '.')
            && ! str_contains($view, '..');
    }

    private function throwInvalidViewPath(Manifest $module, string $label, mixed $path, string $requirement): void
    {
        $displayPath = is_scalar($path) ? (string) $path : get_debug_type($path);

        throw new InvalidArgumentException("Module [{$module->key}] has invalid {$label} [{$displayPath}]. Paths must be {$requirement}.");
    }

    private function validateExclusiveResourceOwnership(string $label, callable $selector): void
    {
        $owners = [];

        foreach ($this->modules as $module) {
            foreach ($selector($module) as $resource) {
                if (isset($owners[$resource])) {
                    throw new InvalidArgumentException("{$label} [{$resource}] is owned by both [{$owners[$resource]}] and [{$module->key}].");
                }

                $owners[$resource] = $module->key;
            }
        }
    }

    /**
     * @return list<Manifest>
     */
    private function ownersForUiEntryMatching(callable $predicate): array
    {
        return $this->ownersMatching(
            fn (Manifest $module): bool => collect($module->uiEntries)
                ->contains(fn (UiEntry $entry): bool => $predicate($entry)),
        );
    }
}
