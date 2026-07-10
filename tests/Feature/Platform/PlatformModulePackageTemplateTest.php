<?php

/*
|--------------------------------------------------------------------------
| File: tests/Feature/Platform/PlatformModulePackageTemplateTest.php
| Purpose: Verifies the root module package template and registration shape.
|--------------------------------------------------------------------------
*/

namespace Tests\Feature\Platform;

use App\Core\Modules\LifecycleState;
use App\Core\Modules\PackageDefinition;
use App\Core\Modules\PackageRegistrar;
use App\Core\Modules\Repository;
use App\Core\Modules\Category;
use Illuminate\Support\Facades\File;
use Tests\TestCase;


class PlatformModulePackageTemplateTest extends TestCase
{
    public function test_template_module_package_declares_single_parent_folder_shape(): void
    {
        $root = base_path('Modules/_Template');

        $this->assertDirectoryExists($root);

        foreach ([
            'README.md',
            'module.php',
            'Providers/.gitkeep',
            'Routes/web.php',
            'Http/Controllers/.gitkeep',
            'Actions/.gitkeep',
            'Models/.gitkeep',
            'Policies/.gitkeep',
            'Definitions/.gitkeep',
            'config/.gitkeep',
            'resources/views/.gitkeep',
            'resources/views/settings/index.blade.php',
            'resources/views/setup/index.blade.php',
            'resources/lang/.gitkeep',
            'resources/lang/en/module.php',
            'database/migrations/.gitkeep',
            'database/seeders/.gitkeep',
            'tests/Feature/.gitkeep',
            'tests/Unit/.gitkeep',
            'docs/README.md',
        ] as $path) {
            $this->assertTrue(File::exists($root.'/'.$path), "Template module path [{$path}] is missing.");
        }

        $strings = require $root.'/resources/lang/en/module.php';

        $this->assertIsArray($strings);
        $this->assertArrayHasKey('title', $strings);
        $this->assertArrayHasKey('description', $strings);
        $this->assertArrayHasKey('settings', $strings);
        $this->assertArrayHasKey('setup', $strings);
    }

    public function test_module_namespace_is_autoload_ready_without_registering_template(): void
    {
        $composer = json_decode((string) File::get(base_path('composer.json')), true, flags: JSON_THROW_ON_ERROR);

        $this->assertSame('Modules/', $composer['autoload']['psr-4']['App\\Modules\\'] ?? null);
        $this->assertArrayNotHasKey('_template', app(Repository::class)->all());
        $this->assertArrayNotHasKey('template-module', app(Repository::class)->all());
    }

    public function test_module_package_defaults_are_derived_from_folder_name(): void
    {
        $definition = PackageDefinition::defaults(base_path('Modules/FancyReports'));
        $manifest = $definition['manifest'];

        $this->assertSame('Modules/FancyReports', $definition['root']);
        $this->assertSame('fancy-reports', $definition['key']);
        $this->assertSame('Fancy Reports', $definition['name']);
        $this->assertSame('fancy-reports', $manifest->key);
        $this->assertSame('Fancy Reports', $manifest->name);
        $this->assertSame(Category::Shared, $manifest->type);
        $this->assertSame(LifecycleState::Available, $manifest->defaultState);
        $this->assertSame(['fancy-reports.*'], $manifest->routePatterns);
        $this->assertSame(['fancy-reports.view'], $manifest->permissions);
        $this->assertSame([], $manifest->permissionDefinitions);
        $this->assertSame(['Modules/FancyReports/resources/views'], $manifest->moduleViewPaths);
        $this->assertSame('fancy-reports', $definition['routes']['web']['prefix']);
        $this->assertSame('fancy-reports.', $definition['routes']['web']['name']);
        $this->assertSame(['web', 'auth'], $definition['routes']['web']['middleware']);
        $this->assertSame('fancy-reports', $definition['views']['namespace']);
        $this->assertSame('resources/views', $definition['views']['path']);
        $this->assertSame('fancy-reports', $definition['translations']['namespace']);
        $this->assertSame('resources/lang', $definition['translations']['path']);
    }

    public function test_template_definition_uses_dynamic_defaults_without_registering_module_views(): void
    {
        $definition = require base_path('Modules/_Template/module.php');
        $manifest = $definition['manifest'];

        $this->assertSame('Modules/_Template', $definition['root']);
        $this->assertSame('template', $definition['key']);
        $this->assertSame('Template', $definition['name']);
        $this->assertSame('template', $manifest->key);
        $this->assertSame('Template', $manifest->name);
        $this->assertSame([], $manifest->moduleViewPaths);
        $this->assertSame('template', $definition['routes']['web']['prefix']);
        $this->assertSame('template.', $definition['routes']['web']['name']);
        $this->assertSame('template', $definition['views']['namespace']);
        $this->assertSame('template', $definition['translations']['namespace']);
        $this->assertSame('resources/lang', $definition['translations']['path']);
        $this->assertSame([], $definition['providers']);
    }

    public function test_dashboard_module_package_declares_real_definition_shape(): void
    {
        $definition = require base_path('Modules/Dashboard/module.php');
        $manifest = $definition['manifest'];

        $this->assertSame('Modules/Dashboard', $definition['root']);
        $this->assertSame('dashboard', $definition['key']);
        $this->assertSame('Dashboard', $definition['name']);
        $this->assertSame('dashboard', $manifest->key);
        $this->assertSame('Dashboard', $manifest->name);
        $this->assertSame(Category::Core, $manifest->type);
        $this->assertSame(['dashboard', 'dashboard.*'], $manifest->routePatterns);
        $this->assertSame([], $manifest->permissions);
        $this->assertSame([], $manifest->permissionDefinitions);
        $this->assertSame(['dashboard'], $manifest->navigationRoutes);
        $this->assertSame(['Modules/Dashboard/resources/views'], $manifest->moduleViewPaths);
        $this->assertSame('', $definition['routes']['web']['prefix']);
        $this->assertSame('', $definition['routes']['web']['name']);
        $this->assertSame('dashboard', $definition['views']['namespace']);
        $this->assertSame('dashboard', $definition['translations']['namespace']);
        $this->assertSame('resources/lang', $definition['translations']['path']);
    }

    public function test_roles_settings_preferences_and_setup_modules_declare_real_package_shapes(): void
    {
        foreach ([
            'Roles' => ['key' => 'roles', 'view_path' => 'Modules/Roles/resources/views'],
            'Settings' => ['key' => 'settings', 'view_path' => 'Modules/Settings/resources/views'],
            'Preferences' => ['key' => 'preferences', 'view_path' => 'Modules/Preferences/resources/views'],
            'Setup' => ['key' => 'setup', 'view_path' => 'Modules/Setup/resources/views'],
        ] as $folder => $expected) {
            $definition = require base_path("Modules/{$folder}/module.php");
            $manifest = $definition['manifest'];

            $this->assertSame("Modules/{$folder}", $definition['root']);
            $this->assertSame($expected['key'], $definition['key']);
            $this->assertSame($expected['key'], $manifest->key);
            $this->assertSame(Category::Core, $manifest->type);
            $this->assertSame([$expected['view_path']], $manifest->moduleViewPaths);
            $this->assertSame('', $definition['routes']['web']['prefix']);
            $this->assertSame('', $definition['routes']['web']['name']);
            $this->assertSame($expected['key'], $definition['views']['namespace']);
            $this->assertSame($expected['key'], $definition['translations']['namespace']);
            $this->assertSame('resources/lang', $definition['translations']['path']);
        }

        $rolesDefinition = require base_path('Modules/Roles/module.php');
        $rolesManifest = $rolesDefinition['manifest'];

        $this->assertSame([
            \App\Modules\Roles\Providers\Provider::class,
        ], $rolesDefinition['providers']);
        $this->assertSame([
            'roles.create',
            'roles.delete',
            'roles.manage',
            'roles.permissions.view',
            'roles.update',
            'roles.view',
        ], $rolesManifest->permissionKeys());
        $this->assertNotEmpty($rolesManifest->permissionDefinitions);
        $this->assertSame('Manage roles', collect($rolesManifest->permissionDefinitions)->firstWhere('key', 'roles.manage')->label);
    }

    public function test_registrar_applies_configured_routes_views_and_translations(): void
    {
        $root = storage_path('framework/testing/modules/RegistrarProbe');

        File::deleteDirectory($root);
        File::ensureDirectoryExists("{$root}/Routes");
        File::ensureDirectoryExists("{$root}/resources/views");
        File::ensureDirectoryExists("{$root}/resources/lang/en");
        File::put("{$root}/Routes/web.php", <<<'PHP'
<?php

use Illuminate\Support\Facades\Route;

Route::get('/probe', fn () => 'registrar-ok')->name('probe');
PHP);
        File::put("{$root}/resources/views/index.blade.php", 'Registrar view');
        File::put("{$root}/resources/lang/en/messages.php", <<<'PHP'
<?php

return [
    'status' => 'Registrar translation',
];
PHP);

        $definition = PackageDefinition::defaults($root, [
            'routes' => [
                'web' => [
                    'prefix' => 'registrar-probe',
                    'name' => 'registrar-probe.',
                    'middleware' => ['web'],
                ],
            ],
            'views' => [
                'namespace' => 'registrar-probe',
            ],
        ]);

        app(PackageRegistrar::class)->register($definition);

        $this->get('/registrar-probe/probe')->assertOk()->assertSee('registrar-ok');
        $this->assertSame('/registrar-probe/probe', route('registrar-probe.probe', absolute: false));
        $this->assertTrue(view()->exists('registrar-probe::index'));
        $this->assertSame('Registrar translation', __('registrar-probe::messages.status'));
    }
}
