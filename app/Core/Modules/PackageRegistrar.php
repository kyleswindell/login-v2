<?php

/*
|--------------------------------------------------------------------------
| File: app/Core/Modules/PackageRegistrar.php
| Purpose: Registers configured package-local module assets.
|--------------------------------------------------------------------------
*/

namespace App\Core\Modules;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\Route;
use Illuminate\Translation\Translator;


final class PackageRegistrar
{
    public function __construct(
        private readonly Application $app,
    ) {
    }

    /**
     * @param  array<string, mixed>  $definition
     */
    public function register(array $definition): void
    {
        $root = $this->absolutePath((string) ($definition['root'] ?? ''));

        $this->registerProviders($definition['providers'] ?? []);
        $this->registerViews($root, $definition['views'] ?? []);
        $this->registerTranslations($root, $definition['translations'] ?? []);
        $this->registerMigrations($root, $definition['migrations'] ?? []);
        $this->registerRoutes($root, $definition['routes'] ?? []);
    }

    /**
     * @param  array<int, class-string>  $providers
     */
    private function registerProviders(array $providers): void
    {
        foreach ($providers as $provider) {
            if (is_string($provider) && class_exists($provider)) {
                $this->app->register($provider);
            }
        }
    }

    /**
     * @param  array<string, mixed>  $views
     */
    private function registerViews(string $root, array $views): void
    {
        $namespace = $views['namespace'] ?? null;
        $path = $views['path'] ?? null;

        if (! is_string($namespace) || $namespace === '' || ! is_string($path) || $path === '') {
            return;
        }

        $viewPath = "{$root}/{$path}";

        if (! is_dir($viewPath)) {
            return;
        }

        $this->app->make(ViewFactory::class)->addNamespace($namespace, $viewPath);
    }

    /**
     * @param  array<string, mixed>  $translations
     */
    private function registerTranslations(string $root, array $translations): void
    {
        $namespace = $translations['namespace'] ?? null;
        $path = $translations['path'] ?? null;

        if (! is_string($namespace) || $namespace === '' || ! is_string($path) || $path === '') {
            return;
        }

        $translationPath = "{$root}/{$path}";

        if (! is_dir($translationPath)) {
            return;
        }

        $translator = $this->app->make('translator');

        if ($translator instanceof Translator) {
            $translator->addNamespace($namespace, $translationPath);
        }
    }

    /**
     * @param  array<string, mixed>  $migrations
     */
    private function registerMigrations(string $root, array $migrations): void
    {
        $path = $migrations['path'] ?? null;

        if (! is_string($path) || $path === '') {
            return;
        }

        $migrationPath = "{$root}/{$path}";

        if (! is_dir($migrationPath)) {
            return;
        }

        $this->app->afterResolving('migrator', function (Migrator $migrator) use ($migrationPath): void {
            $migrator->path($migrationPath);
        });
    }

    /**
     * @param  array<string, mixed>  $routes
     */
    private function registerRoutes(string $root, array $routes): void
    {
        $loadedRoutes = false;

        foreach ($routes as $routeGroup) {
            if (! is_array($routeGroup)) {
                continue;
            }

            $path = $routeGroup['path'] ?? null;

            if (! is_string($path) || $path === '') {
                continue;
            }

            $routePath = "{$root}/{$path}";

            if (! is_file($routePath)) {
                continue;
            }

            Route::group([
                'middleware' => $routeGroup['middleware'] ?? [],
                'prefix' => (string) ($routeGroup['prefix'] ?? ''),
                'as' => (string) ($routeGroup['name'] ?? ''),
            ], $routePath);

            $loadedRoutes = true;
        }

        if ($loadedRoutes) {
            Route::getRoutes()->refreshNameLookups();
            Route::getRoutes()->refreshActionLookups();
        }
    }

    private function absolutePath(string $path): string
    {
        $normalized = str_replace('\\', '/', $path);

        if ($normalized === '') {
            return base_path();
        }

        if (preg_match('#^[A-Za-z]:/#', $normalized) === 1 || str_starts_with($normalized, '/') || str_starts_with($normalized, '//')) {
            return $normalized;
        }

        return base_path($normalized);
    }
}
