<?php

/*
|--------------------------------------------------------------------------
| File: tests/Feature/Platform/PlatformModuleRegistryTest.php
| Purpose: Verifies module repository validation and command behavior.
|--------------------------------------------------------------------------
*/

namespace Tests\Feature\Platform;

use App\Core\Modules\Definitions;
use App\Core\Modules\Definitions\NotificationType;
use App\Core\Modules\Definitions\Permission;
use App\Core\Modules\LifecycleState;
use App\Core\Modules\Manifest;
use App\Core\Modules\Repository;
use App\Core\Modules\UiPlacement;
use App\Core\Modules\UiEntry;
use App\Core\Modules\UiAccessMode;
use App\Core\Modules\UiEntryType;
use App\Core\Modules\Category;
use Illuminate\Support\Facades\Artisan;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Tests\TestCase;


class PlatformModuleRegistryTest extends TestCase
{
    public function test_module_catalog_registers_expected_foundation_modules(): void
    {
        $registry = app(Repository::class);

        $this->assertSame([
            'auth',
            'account',
            'users',
            'roles',
            'settings',
            'logging',
            'notifications',
            'dashboard',
            'preferences',
            'ui-system',
            'runtime-security',
            'setup',
            'docs-viewer',
            'security-checklist',
            'runtime-readiness',
            'development-tools',
        ], array_keys($registry->all()));
    }

    public function test_core_modules_are_locked_enabled_defaults(): void
    {
        $registry = app(Repository::class);

        foreach ($registry->byType(Category::Core) as $module) {
            $this->assertSame(LifecycleState::Enabled, $module->defaultState, $module->key);
            $this->assertTrue($module->installedByDefault, $module->key);
            $this->assertTrue($module->defaultEnabled, $module->key);
            $this->assertFalse($module->disableable, $module->key);
            $this->assertTrue($module->tenantEligible, $module->key);
        }
    }

    public function test_package_definitions_are_the_static_runtime_package_source(): void
    {
        $this->assertSame(
            ['auth', 'account', 'roles', 'dashboard', 'settings', 'preferences', 'notifications', 'setup'],
            collect(Definitions::packageDefinitions())
                ->map(fn (array $definition): string => $definition['manifest']->key)
                ->values()
                ->all(),
        );
    }

    public function test_platform_management_modules_are_not_tenant_eligible_by_default(): void
    {
        $registry = app(Repository::class);

        foreach ($registry->byType(Category::PlatformManagement) as $module) {
            $this->assertSame(LifecycleState::Enabled, $module->defaultState, $module->key);
            $this->assertTrue($module->installedByDefault, $module->key);
            $this->assertTrue($module->defaultEnabled, $module->key);
            $this->assertTrue($module->disableable, $module->key);
            $this->assertFalse($module->tenantEligible, $module->key);
        }
    }

    public function test_registry_rejects_invalid_catalog_shapes(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('already registered');

        new Repository([
            new Manifest(key: 'duplicate', name: 'Duplicate A', type: Category::Core),
            new Manifest(key: 'duplicate', name: 'Duplicate B', type: Category::Core),
        ]);
    }

    public function test_registry_rejects_unknown_dependencies(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('unknown dependency');

        new Repository([
            new Manifest(
                key: 'consumer',
                name: 'Consumer',
                type: Category::Shared,
                dependencies: ['missing'],
            ),
        ]);
    }

    public function test_registry_rejects_duplicate_owned_resources(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('permission [platform.example.view]');

        new Repository([
            new Manifest(
                key: 'first',
                name: 'First',
                type: Category::Shared,
                permissions: ['platform.example.view'],
            ),
            new Manifest(
                key: 'second',
                name: 'Second',
                type: Category::Shared,
                permissionDefinitions: [
                    new Permission(
                        key: 'platform.example.view',
                        label: 'View example',
                        description: 'View example records.',
                        groupKey: 'example',
                        groupLabel: 'Example',
                    ),
                ],
            ),
        ]);
    }

    public function test_registry_resolves_structured_permission_ownership(): void
    {
        $registry = new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
                permissionDefinitions: [
                    new Permission(
                        key: 'platform.example.view',
                        label: 'View example',
                        description: 'View example records.',
                        groupKey: 'example',
                        groupLabel: 'Example',
                    ),
                ],
            ),
        ]);

        $owners = $registry->ownersForPermission('platform.example.view');

        $this->assertCount(1, $owners);
        $this->assertSame('example', $owners[0]->key);
        $this->assertSame(['platform.example.view'], $owners[0]->permissionKeys());
    }

    public function test_registry_resolves_structured_notification_type_ownership(): void
    {
        $registry = new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
                notificationDefinitions: [
                    new NotificationType(
                        key: 'example.record.updated',
                        label: 'Example updated',
                        description: 'An example record was updated.',
                        category: 'example',
                        defaultSeverity: NotificationType::SEVERITY_NOTICE,
                    ),
                ],
            ),
        ]);

        $owners = $registry->ownersForNotificationType('example.record.updated');
        $definitions = $registry->notificationDefinitions();

        $this->assertCount(1, $owners);
        $this->assertSame('example', $owners[0]->key);
        $this->assertCount(1, $definitions);
        $this->assertSame('example.record.updated', $definitions[0]->key);
    }

    public function test_registry_rejects_invalid_notification_type_definition_shapes(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid notification type definition');

        new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
                notificationDefinitions: [
                    ['key' => 'example.record.updated'],
                ],
            ),
        ]);
    }

    public function test_registry_rejects_duplicate_notification_type_ownership(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('notification type [example.record.updated]');

        new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
                notificationDefinitions: [
                    new NotificationType(
                        key: 'example.record.updated',
                        label: 'Example updated',
                        description: 'An example record was updated.',
                        category: 'example',
                    ),
                    new NotificationType(
                        key: 'example.record.updated',
                        label: 'Example updated duplicate',
                        description: 'An example record was updated again.',
                        category: 'example',
                    ),
                ],
            ),
        ]);
    }

    public function test_notification_type_rejects_invalid_metadata(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid default severity');

        new NotificationType(
            key: 'example.record.updated',
            label: 'Example updated',
            description: 'An example record was updated.',
            category: 'example',
            defaultSeverity: 'loud',
        );
    }

    public function test_notification_type_rejects_invalid_keys(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('must be dot-delimited');

        new NotificationType(
            key: 'example',
            label: 'Example updated',
            description: 'An example record was updated.',
            category: 'example',
        );
    }

    public function test_registry_rejects_notification_types_outside_module_namespace(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('must be owned by module [example]');

        new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
                notificationDefinitions: [
                    new NotificationType(
                        key: 'other.record.updated',
                        label: 'Example updated',
                        description: 'An example record was updated.',
                        category: 'example',
                    ),
                ],
            ),
        ]);
    }

    public function test_registry_rejects_invalid_permission_definition_shapes(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid permission definition');

        new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
                permissionDefinitions: [
                    ['key' => 'platform.example.view'],
                ],
            ),
        ]);
    }

    public function test_permission_definition_rejects_unknown_default_roles(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('unsupported default role');

        new Permission(
            key: 'platform.example.view',
            label: 'View example',
            description: 'View example records.',
            groupKey: 'example',
            groupLabel: 'Example',
            defaultRoles: ['owner'],
        );
    }

    public function test_registry_rejects_duplicate_view_path_ownership(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('platform view path [resources/views/platform/example]');

        new Repository([
            new Manifest(
                key: 'first',
                name: 'First',
                type: Category::Shared,
                platformViewPaths: ['resources/views/platform/example'],
            ),
            new Manifest(
                key: 'second',
                name: 'Second',
                type: Category::Shared,
                platformViewPaths: ['resources/views/platform/example'],
            ),
        ]);
    }

    public function test_registry_rejects_invalid_view_path_shapes(): void
    {
        foreach ([
            ['platformViewPaths' => ['/resources/views/platform/example'], 'message' => 'invalid platform view path'],
            ['platformViewPaths' => ['resources/views/platform/example/'], 'message' => 'invalid platform view path'],
            ['platformViewPaths' => ['resources\\views\\platform\\example'], 'message' => 'invalid platform view path'],
            ['platformViewPaths' => ['Modules/Example/resources/views'], 'message' => 'invalid platform view path'],
            ['moduleViewPaths' => ['resources/views/platform/example'], 'message' => 'invalid module view path'],
            ['moduleViewPaths' => ['resources/views/modules/example'], 'message' => 'invalid module view path'],
            ['moduleViewPaths' => ['Modules/example/resources/views'], 'message' => 'invalid module view path'],
            ['moduleViewPaths' => ['Modules/Example/resources/views/'], 'message' => 'invalid module view path'],
        ] as $case) {
            try {
                new Repository([
                    new Manifest(
                        key: 'example',
                        name: 'Example',
                        type: Category::Shared,
                        platformViewPaths: $case['platformViewPaths'] ?? [],
                        moduleViewPaths: $case['moduleViewPaths'] ?? [],
                    ),
                ]);

                $this->fail('Registry accepted an invalid view path shape.');
            } catch (InvalidArgumentException $exception) {
                $this->assertStringContainsString($case['message'], $exception->getMessage());
            }
        }
    }

    public function test_registry_accepts_package_local_module_view_paths(): void
    {
        $registry = new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
                moduleViewPaths: ['Modules/Example/resources/views'],
                uiEntries: [
                    new UiEntry(
                        key: 'example.main.index',
                        type: UiEntryType::MainView,
                        placement: UiPlacement::Main,
                        access: UiAccessMode::Authenticated,
                        routeName: 'example.index',
                        viewPath: 'Modules/Example/resources/views/index.blade.php',
                    ),
                ],
            ),
        ]);

        $this->assertCount(1, $registry->ownersForModuleViewPath('Modules/Example/resources/views'));
        $this->assertCount(1, $registry->ownersForUiEntryViewPath(UiEntryType::MainView, 'Modules/Example/resources/views/index.blade.php'));
    }

    public function test_registry_rejects_duplicate_ui_entry_keys(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('UI entry [duplicate.entry]');

        new Repository([
            new Manifest(
                key: 'first',
                name: 'First',
                type: Category::Shared,
                uiEntries: [
                    $this->navigationSurface('duplicate.entry', 'first.route'),
                ],
            ),
            new Manifest(
                key: 'second',
                name: 'Second',
                type: Category::Shared,
                uiEntries: [
                    $this->navigationSurface('duplicate.entry', 'second.route'),
                ],
            ),
        ]);
    }

    public function test_registry_rejects_ui_entry_required_field_gaps(): void
    {
        foreach ([
            [
                'entry' => new UiEntry(
                    key: 'missing.navigation.route',
                    type: UiEntryType::NavigationItem,
                    placement: UiPlacement::AreaNavigation,
                    access: UiAccessMode::Authenticated,
                    label: 'Broken',
                ),
                'message' => 'requires [routeName]',
            ],
            [
                'entry' => new UiEntry(
                    key: 'missing.settings.view',
                    type: UiEntryType::SettingsPage,
                    placement: UiPlacement::SettingsSidebar,
                    access: UiAccessMode::Ability,
                    label: 'Broken',
                    routeName: 'platform.settings.broken',
                    accessValue: 'view-platform-settings',
                ),
                'message' => 'requires [viewPath]',
            ],
            [
                'entry' => new UiEntry(
                    key: 'missing.preference.group',
                    type: UiEntryType::PreferencePage,
                    placement: UiPlacement::PreferencesNavigation,
                    access: UiAccessMode::Authenticated,
                    label: 'Broken',
                    routeName: 'platform.account.preferences',
                    viewPath: 'Modules/Preferences/resources/views/personal-defaults.blade.php',
                    icon: 'settings',
                ),
                'message' => 'requires [groupKey]',
            ],
            [
                'entry' => new UiEntry(
                    key: 'missing.setup.icon',
                    type: UiEntryType::SetupScreen,
                    placement: UiPlacement::SetupNavigation,
                    access: UiAccessMode::Ability,
                    label: 'Broken',
                    routeName: 'platform.setup.broken',
                    viewPath: 'resources/views/platform/setup/broken.blade.php',
                    accessValue: 'view-platform-settings',
                ),
                'message' => 'requires [icon]',
            ],
            [
                'entry' => new UiEntry(
                    key: 'missing.header.icon',
                    type: UiEntryType::HeaderGlobalAction,
                    placement: UiPlacement::HeaderGlobalActions,
                    access: UiAccessMode::Authenticated,
                    label: 'Broken',
                    routeName: 'broken.header-action',
                ),
                'message' => 'requires [icon]',
            ],
            [
                'entry' => new UiEntry(
                    key: 'missing.header.target',
                    type: UiEntryType::HeaderGlobalAction,
                    placement: UiPlacement::HeaderGlobalActions,
                    access: UiAccessMode::Authenticated,
                    label: 'Broken',
                    icon: 'warning',
                ),
                'message' => 'requires [routeName] or [panelTarget]',
            ],
            [
                'entry' => new UiEntry(
                    key: 'missing.header.component',
                    type: UiEntryType::HeaderGlobalAction,
                    placement: UiPlacement::HeaderGlobalActions,
                    access: UiAccessMode::Authenticated,
                    label: 'Broken',
                    routeName: 'broken.header-action',
                    icon: 'warning',
                    dataProvider: \App\Modules\Notifications\Header\PanelDataProvider::class,
                ),
                'message' => 'requires [componentView] when [dataProvider] is defined',
            ],
            [
                'entry' => new UiEntry(
                    key: 'invalid.header.component',
                    type: UiEntryType::HeaderGlobalAction,
                    placement: UiPlacement::HeaderGlobalActions,
                    access: UiAccessMode::Authenticated,
                    label: 'Broken',
                    panelTarget: 'broken-panel',
                    icon: 'warning',
                    componentView: 'broken/header.action',
                ),
                'message' => 'invalid [componentView]',
            ],
            [
                'entry' => new UiEntry(
                    key: 'invalid.header.provider',
                    type: UiEntryType::HeaderGlobalAction,
                    placement: UiPlacement::HeaderGlobalActions,
                    access: UiAccessMode::Authenticated,
                    label: 'Broken',
                    panelTarget: 'broken-panel',
                    icon: 'warning',
                    componentView: 'example::header.action',
                    dataProvider: 'App\\Missing\\HeaderProvider',
                ),
                'message' => 'invalid [dataProvider]',
            ],
            [
                'entry' => new UiEntry(
                    key: 'missing.widget.key',
                    type: UiEntryType::DashboardWidget,
                    placement: UiPlacement::Dashboard,
                    access: UiAccessMode::Authenticated,
                ),
                'message' => 'requires [widgetKey]',
            ],
            [
                'entry' => new UiEntry(
                    key: 'missing.extension.point',
                    type: UiEntryType::ExtensionPoint,
                    placement: UiPlacement::Extension,
                ),
                'message' => 'requires [extensionPoint]',
            ],
            [
                'entry' => new UiEntry(
                    key: 'missing.contribution.target',
                    type: UiEntryType::ExtensionContribution,
                    placement: UiPlacement::Extension,
                    access: UiAccessMode::Authenticated,
                    viewPath: 'Modules/Example/resources/views/contribution.blade.php',
                ),
                'message' => 'requires [targetExtensionPoint]',
            ],
        ] as $case) {
            try {
                new Repository([
                    new Manifest(
                        key: 'example',
                        name: 'Example',
                        type: Category::Shared,
                        uiEntries: [$case['entry']],
                    ),
                ]);

                $this->fail('Registry accepted an incomplete UI entry.');
            } catch (InvalidArgumentException $exception) {
                $this->assertStringContainsString($case['message'], $exception->getMessage());
            }
        }
    }

    public function test_registry_rejects_ui_entries_with_wrong_canonical_placement(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('preferences_navigation');

        new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
                uiEntries: [
                    new UiEntry(
                        key: 'preference.wrong-placement',
                        type: UiEntryType::PreferencePage,
                        placement: UiPlacement::AccountMenu,
                        access: UiAccessMode::Authenticated,
                        label: 'Wrong placement',
                        routeName: 'platform.account.preferences',
                        viewPath: 'Modules/Preferences/resources/views/personal-defaults.blade.php',
                        icon: 'settings',
                        groupKey: 'account',
                        groupLabel: 'Account',
                    ),
                ],
            ),
        ]);
    }

    public function test_registry_rejects_ui_entries_without_explicit_access_metadata(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('requires explicit access metadata');

        new Repository([
            new Manifest(
                key: 'example',
                name: 'Example',
                type: Category::Shared,
                uiEntries: [
                    new UiEntry(
                        key: 'missing.access',
                        type: UiEntryType::NavigationItem,
                        placement: UiPlacement::AreaNavigation,
                        label: 'Missing access',
                        routeName: 'example.route',
                    ),
                ],
            ),
        ]);
    }

    public function test_registry_rejects_invalid_ui_entry_access_values(): void
    {
        foreach ([
            [
                'entry' => $this->navigationSurface('permission.missing.value', 'permission.missing', UiAccessMode::Permission),
                'message' => 'requires an access value',
            ],
            [
                'entry' => $this->navigationSurface('authenticated.extra.value', 'authenticated.extra', UiAccessMode::Authenticated, 'extra'),
                'message' => 'must not define an access value',
            ],
        ] as $case) {
            try {
                new Repository([
                    new Manifest(
                        key: 'example',
                        name: 'Example',
                        type: Category::Shared,
                        uiEntries: [$case['entry']],
                    ),
                ]);

                $this->fail('Registry accepted invalid UI entry access metadata.');
            } catch (InvalidArgumentException $exception) {
                $this->assertStringContainsString($case['message'], $exception->getMessage());
            }
        }
    }

    public function test_registry_rejects_extension_contributions_to_unknown_extension_points(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('targets unknown extension point [missing.slot]');

        new Repository([
            new Manifest(
                key: 'contributor',
                name: 'Contributor',
                type: Category::Shared,
                uiEntries: [
                    new UiEntry(
                        key: 'contributor.extension',
                        type: UiEntryType::ExtensionContribution,
                        placement: UiPlacement::Extension,
                        access: UiAccessMode::Authenticated,
                        viewPath: 'Modules/Contributor/resources/views/extension.blade.php',
                        targetExtensionPoint: 'missing.slot',
                    ),
                ],
            ),
        ]);
    }

    public function test_registry_rejects_extension_contributions_without_dependency_on_owner_module(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('does not depend on it');

        new Repository([
            new Manifest(
                key: 'host',
                name: 'Host',
                type: Category::Shared,
                uiEntries: [
                    new UiEntry(
                        key: 'host.extension-point',
                        type: UiEntryType::ExtensionPoint,
                        placement: UiPlacement::Extension,
                        extensionPoint: 'host.detail.tabs',
                    ),
                ],
            ),
            new Manifest(
                key: 'contributor',
                name: 'Contributor',
                type: Category::Shared,
                uiEntries: [
                    new UiEntry(
                        key: 'contributor.extension',
                        type: UiEntryType::ExtensionContribution,
                        placement: UiPlacement::Extension,
                        access: UiAccessMode::Authenticated,
                        viewPath: 'Modules/Contributor/resources/views/extension.blade.php',
                        targetExtensionPoint: 'host.detail.tabs',
                    ),
                ],
            ),
        ]);
    }

    public function test_registry_rejects_tenant_eligible_ui_entry_on_non_tenant_eligible_module(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('cannot be tenant eligible');

        new Repository([
            new Manifest(
                key: 'platform-only',
                name: 'Platform Only',
                type: Category::PlatformManagement,
                tenantEligible: false,
                uiEntries: [
                    new UiEntry(
                        key: 'platform-only.nav',
                        type: UiEntryType::NavigationItem,
                        placement: UiPlacement::AreaNavigation,
                        access: UiAccessMode::Authenticated,
                        label: 'Platform Only',
                        routeName: 'platform.only',
                        tenantEligible: true,
                    ),
                ],
            ),
        ]);
    }

    public function test_modules_list_command_outputs_safe_deterministic_json(): void
    {
        config()->set('database.connections.pgsql.password', 'module-command-secret');

        $exitCode = Artisan::call('platform:modules:list', [
            '--json' => true,
        ]);

        $output = Artisan::output();
        $payload = json_decode($output, true);

        $this->assertSame(Command::SUCCESS, $exitCode);
        $this->assertIsArray($payload);
        $this->assertSame(array_keys(app(Repository::class)->all()), collect($payload['modules'])->pluck('key')->all());
        $this->assertStringNotContainsString('module-command-secret', $output);
        $this->assertArrayHasKey('ownership_counts', $payload['modules'][0]);
    }

    public function test_modules_list_command_filters_by_type(): void
    {
        $exitCode = Artisan::call('platform:modules:list', [
            '--type' => Category::PlatformManagement->value,
            '--json' => true,
        ]);

        $payload = json_decode(Artisan::output(), true);

        $this->assertSame(Command::SUCCESS, $exitCode);
        $this->assertNotEmpty($payload['modules']);
        $this->assertSame(
            [Category::PlatformManagement->value],
            collect($payload['modules'])->pluck('type')->unique()->values()->all(),
        );
    }

    public function test_modules_list_command_rejects_invalid_type(): void
    {
        $this->artisan('platform:modules:list', [
            '--type' => 'invalid',
        ])->assertExitCode(Command::FAILURE)
            ->expectsOutputToContain('Module type must be one of');
    }

    private function navigationSurface(
        string $key,
        string $routeName,
        UiAccessMode $access = UiAccessMode::Authenticated,
        ?string $accessValue = null,
    ): UiEntry {
        return new UiEntry(
            key: $key,
            type: UiEntryType::NavigationItem,
            placement: UiPlacement::AreaNavigation,
            access: $access,
            label: 'Example',
            routeName: $routeName,
            accessValue: $accessValue,
        );
    }
}
