<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/PackageDefinition.php
| Purpose: Derives standard metadata for copied module packages.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules;

use Illuminate\Support\Str;


final class PackageDefinition
{
    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public static function defaults(string $root, array $overrides = []): array
    {
        $relativeRoot = self::relativeRoot($root);
        $folder = basename(str_replace('\\', '/', $relativeRoot));
        $isTemplate = str_starts_with($folder, '_');
        $moduleName = ltrim($folder, '_');
        $key = Str::of($moduleName)->kebab()->toString();
        $name = self::displayName($moduleName);

        $manifest = $overrides['manifest'] ?? [];
        $routePatterns = $manifest['routePatterns'] ?? ["{$key}.*"];
        $permissionDefinitions = $manifest['permissionDefinitions'] ?? [];
        $permissions = $manifest['permissions']
            ?? ($permissionDefinitions === [] ? ["{$key}.view"] : self::permissionKeys($permissionDefinitions));
        $moduleViewPaths = $manifest['moduleViewPaths'] ?? ($isTemplate ? [] : ["{$relativeRoot}/resources/views"]);

        return [
            'root' => $relativeRoot,
            'key' => $manifest['key'] ?? $key,
            'name' => $manifest['name'] ?? $name,
            'manifest' => new Manifest(
                key: $manifest['key'] ?? $key,
                name: $manifest['name'] ?? $name,
                type: $manifest['type'] ?? Category::Shared,
                defaultState: $manifest['defaultState'] ?? LifecycleState::Available,
                installedByDefault: $manifest['installedByDefault'] ?? false,
                defaultEnabled: $manifest['defaultEnabled'] ?? false,
                disableable: $manifest['disableable'] ?? true,
                tenantEligible: $manifest['tenantEligible'] ?? false,
                dependencies: $manifest['dependencies'] ?? [],
                routePatterns: $routePatterns,
                permissions: $permissions,
                permissionDefinitions: $permissionDefinitions,
                notificationDefinitions: $manifest['notificationDefinitions'] ?? [],
                navigationRoutes: $manifest['navigationRoutes'] ?? [],
                dashboardWidgets: $manifest['dashboardWidgets'] ?? [],
                settingsGroups: $manifest['settingsGroups'] ?? [],
                ownedTables: $manifest['ownedTables'] ?? [],
                platformViewPaths: $manifest['platformViewPaths'] ?? [],
                moduleViewPaths: $moduleViewPaths,
                uiEntries: $manifest['uiEntries'] ?? [],
                setupRoutes: $manifest['setupRoutes'] ?? [],
                auditEvents: $manifest['auditEvents'] ?? [],
                commands: $manifest['commands'] ?? [],
            ),
            'routes' => [
                'web' => array_replace([
                    'path' => 'Routes/web.php',
                    'prefix' => $key,
                    'name' => "{$key}.",
                    'middleware' => ['web', 'auth'],
                ], $overrides['routes']['web'] ?? []),
            ],
            'views' => array_replace([
                'namespace' => $key,
                'path' => 'resources/views',
            ], $overrides['views'] ?? []),
            'translations' => array_replace([
                'namespace' => $key,
                'path' => 'resources/lang',
            ], $overrides['translations'] ?? []),
            'migrations' => array_replace([
                'path' => 'database/migrations',
            ], $overrides['migrations'] ?? []),
            'providers' => $overrides['providers'] ?? [],
        ];
    }

    private static function relativeRoot(string $root): string
    {
        $normalizedRoot = str_replace('\\', '/', $root);
        $base = str_replace('\\', '/', getcwd());

        if (function_exists('base_path')) {
            try {
                $base = str_replace('\\', '/', base_path());
            } catch (\Throwable) {
                $base = str_replace('\\', '/', getcwd());
            }
        }

        if (str_starts_with($normalizedRoot, "{$base}/")) {
            return substr($normalizedRoot, strlen($base) + 1);
        }

        return trim($normalizedRoot, '/');
    }

    private static function displayName(string $moduleName): string
    {
        $spaced = preg_replace('/(?<!^)[A-Z]/', ' $0', str_replace(['_', '-'], ' ', $moduleName));

        return ucwords(trim((string) $spaced));
    }

    /**
     * @param  list<mixed>  $permissionDefinitions
     * @return list<string>
     */
    private static function permissionKeys(array $permissionDefinitions): array
    {
        return collect($permissionDefinitions)
            ->filter(fn (mixed $permission): bool => is_object($permission) && property_exists($permission, 'key'))
            ->map(fn (object $permission): mixed => $permission->key)
            ->filter(fn (mixed $permission): bool => is_string($permission) && $permission !== '')
            ->unique()
            ->sort()
            ->values()
            ->all();
    }
}
