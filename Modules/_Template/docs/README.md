# Template Module Notes

Use this folder for module-local notes that are useful while developing the module but do not belong in canonical `/docs`.

Durable product, architecture, feature, flow, database, planning, reference, or runbook truth still belongs in the canonical `/docs` branch that owns it.

## Language Defaults

Copied modules start with `resources/lang/en/module.php` for package-level title and description strings. Views should call namespaced translation keys such as:

```blade
{{ __('module-key::module.title') }}
```

Add domain language files only when the module needs more specific language groups. Do not use module-local notes as the canonical source for app-wide localization or tenant/app-instance override rules.

## Settings And Setup Starters

Copied modules include inert starter views for optional settings and setup pages:

- `resources/views/settings/index.blade.php`
- `resources/views/setup/index.blade.php`

They are not visible until the copied module adds routes and matching UI metadata. Settings entries use `UiEntryType::SettingsPage` with `UiPlacement::SettingsSidebar`. Setup entries use `UiEntryType::SetupScreen` with `UiPlacement::SetupNavigation`.

Replace the placeholder `module-key::` translation namespace in starter views before enabling them at runtime.
