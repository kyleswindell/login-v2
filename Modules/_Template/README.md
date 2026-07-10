# Module Package Template

`Modules/_Template` is a copy source for new module packages. It is not a runtime module and must not be registered by module discovery.

Copy this folder to `Modules/<ModuleName>` using a StudlyCase module folder name such as `Modules/UiReference`, then replace:

- module-specific permissions, dependencies, owned tables, UI surfaces, and route entries
- optional display name overrides when the folder-derived title is not good enough
- default language strings in `resources/lang/en/module.php`
- inert starter settings and setup pages under `resources/views/settings` and `resources/views/setup`
- optional provider classes only when the module needs custom boot behavior

## Single-Parent Rule

Module-specific files belong under the module package root:

- PHP classes: `Modules/<ModuleName>/*`
- routes: `Modules/<ModuleName>/Routes/*`
- Blade views: `Modules/<ModuleName>/resources/views/*`
- default language strings: `Modules/<ModuleName>/resources/lang/*`
- assets/config stubs: `Modules/<ModuleName>/resources/*` or `Modules/<ModuleName>/config/*`
- migrations and seeders: `Modules/<ModuleName>/database/*`
- tests: `Modules/<ModuleName>/tests/*`
- module-local docs: `Modules/<ModuleName>/docs/*`

Shared system files remain outside module packages when they are not owned by the module. For example, UI primitives, foundation elements, surface contracts, and common pattern components remain shared UI-system assets unless the module truly owns them.

## Runtime Notes

Composer maps `App\Modules\` to `Modules/`, so a copied module can use namespaces such as:

```php
App\Modules\UiReference\Http\Controllers
```

The `_Template` folder uses placeholder namespaces and should be ignored by any future module discovery because its folder name starts with `_`.

`module.php` uses `PackageDefinition::defaults(__DIR__)` to derive these values from the copied folder name:

- module key
- route prefix
- route-name prefix
- default permission name
- view namespace
- translation namespace
- package-local view path

For example, copying this folder to `Modules/UiReference` derives `ui-reference`, `ui-reference.`, `Modules/UiReference/resources/views`, and the `ui-reference::` translation namespace without editing router or provider boilerplate.

## Language Defaults

The template includes `resources/lang/en/module.php` so copied modules can immediately reference generic module copy through Laravel namespaced translations:

```blade
{{ __('ui-reference::module.title') }}
```

Keep `module.php` as the starter file for package-level title and description strings. Add module-specific domain files such as `dashboard.php`, `settings.php`, or `reports.php` only when a module needs more detailed language groups.

Tenant or app-instance display names, locale defaults, timezone defaults, and future title overrides belong in database-backed settings after instance resolution exists. They should not be hard-coded into module views.

## Settings And Setup Starters

The template includes starter views for optional module settings and setup pages:

- `resources/views/settings/index.blade.php`
- `resources/views/setup/index.blade.php`

These views are inert by default. A copied module must intentionally enable them by adding routes and module UI metadata:

- Settings pages use `UiEntryType::SettingsPage` at `UiPlacement::SettingsSidebar`.
- Setup pages use `UiEntryType::SetupScreen` at `UiPlacement::SetupNavigation`.

Do not leave the placeholder `module-key::` translation namespace in copied runtime views. Replace it with the copied module key, such as `notifications::module.setup.title`.
