# Module Layout Convention Implementation Planning

Status: Planning draft
Implementation status: Root module package template, module engine naming cleanup, simple definition extraction proofs, dynamic package defaults, package registrar, view-path ownership evidence, structured permission definition contract and alignment evidence, Dashboard package proof, Notifications package proof, Settings/Preferences/Setup package proofs, Settings landing/header-action routing plus standard Frame sidebar/landing discovery, and Roles & Permissions CRUD implemented; retired reference viewer remains a transitional artifact to ignore/retire, not a migration target

## Purpose

Sequence module layout convention work so physical folders support module ownership without triggering a broad, low-value code move.

This planning note follows the module registry foundation and the module UI entry contract. It exists to keep the next steps focused on evidence, rendered-surface consumption, and selective module package moves only when a module boundary actually needs them.

## Sequencing

1. Document the layout convention in the module architecture doc.
2. Add the root `Modules/_Template` package as the empty initializer copy. Completed.
3. Add dynamic package defaults and a registrar so copied modules derive route prefix, route-name prefix, view namespace, and default view path from their folder name. Completed.
4. Add view-path ownership evidence for current `resources/views/platform/*` directories and future `Modules/<ModuleName>/resources/views` package directories. Completed for current immediate platform view directories and package-local module view path validation.
5. Split the static Definitions into package-local `Modules/<ModuleName>/Definition.php` files when a module graduates into a real package, or into `app/Core/Modules/Definitions/*` only for small non-packaged definition proofs. Roles, Dashboard, Notifications, Settings, Preferences, and Setup now use package-local definitions. UI System, Runtime Security, and Example remain app-core definition proofs.
6. Teach rendered app surfaces to consume module surface metadata for navigation, settings pages, setup screens, widgets, and extension points without replacing normal URL views with a universal renderer.
7. Choose any future proof package from a real approved capability or business module. Do not use retired reference viewer as a module migration target.

## Graduation Criteria

A module may graduate into a dedicated `Modules/<ModuleName>/` package when one or more of these conditions are true:

- it owns multiple content, settings, or setup surfaces
- it has module-local actions, queries, policies, data objects, or orchestration services
- it exposes extension points or contributes into another module's extension points
- it has dependency behavior that is easier to reason about inside a module-local boundary
- it needs shared or tenant-eligible views that should no longer live under `resources/views/platform/*`

Small modules may remain in Laravel-standard folders with manifest ownership. Physical folder movement is not required for module ownership.

## View Composition Direction

View surface composition is tracked in [View Surface Composition Planning](view-surface-composition-planning.md).

Current planning direction:

- Core/admin/account URL views should stay thin and compose reusable patterns with ViewModel/PageData.
- Business module URL views should live under `Modules/<ModuleName>/resources/views` and compose shared patterns.
- Shared UI primitives, shell components, and patterns remain under `resources/views/components`.
- Platform renderers should be reserved for registry-driven surfaces such as Settings, Preferences, Setup, Dashboard widgets, and evidence/check summaries.
- Do not create one universal dynamic renderer for every page, form, table, or business workflow.

## Current View Ownership Map

- `Modules/Auth/resources/views` -> `auth`
- `Modules/Account/resources/views` -> `account`
- `Modules/Settings/resources/views` -> `settings`
- `resources/views/platform/users` -> `users`
- `Modules/Notifications/resources/views` -> `notifications`
- `resources/views/platform/audit-logs` -> `logging`
- `resources/views/platform/error-logs` -> `logging`
- `resources/views/platform/security` -> `security-checklist`
- `resources/views/platform/docs` -> `docs-viewer`
- `retired reference viewer views` -> `retired-reference-viewer`
- `Modules/Setup/resources/views` -> `setup`
- `Modules/Preferences/resources/views` -> `preferences`

## Prohibitions

- Do not mass migrate current app code into `Modules/*`.
- Do not move routes, migrations, tests, or views solely for naming symmetry.
- Do not copy app layout, dashboard grid, settings navigation, setup navigation, or reusable UI primitives into feature modules.
- Do not use arbitrary Blade path overrides as the module extension mechanism.
- Do not make platform-management views tenant-eligible by path move alone.
- Do not register `Modules/_Template` as a runtime module.
- Do not turn normal CRUD/detail/form pages into renderer-driven generic UI definitions.
- Do not put database queries, authorization, or domain mutation behavior into Blade components or patterns.

## Acceptance Criteria For The View-Path Evidence Pass

- View-path ownership tests cover current platform view directories.
- Each current platform view directory has exactly one module owner or an explicit exclusion.
- The module definitions remain the ownership source for route, structured permission definition, navigation, widget, settings group, table, command, setup route, and future view-path evidence.
- No current UI behavior changes.
- No code or view files are moved.

## Current Implementation Notes

- Module manifests include platform and module view-path ownership metadata.
- The module registry rejects invalid or duplicate view-path ownership.
- Module engine naming cleanup is implemented: `Definitions`, `Repository`, `Manifest`, `Category`, `LifecycleState`, `PackageDefinition`, `PackageRegistrar`, `UiEntry`, `UiEntryType`, `UiAccessMode`, and `UiPlacement` are the current approved names.
- Auth and Account are now real Core Module package boundaries. Auth owns login/logout, MFA challenge/enrollment/step-up, account MFA routes, password policy, MFA models, Auth services, route files, views, and module language defaults. Account owns account overview/settings routes, controller behavior, views, account menu metadata, and language defaults while calling Auth-owned services for password/MFA behavior.
- Settings, Preferences, and Setup contribution contracts are represented in module UI metadata. `PreferencePage` and `PreferencesNavigation` are the approved current names for user/account preference contributions. Setup proves a narrow area/sidebar switch: the Header Area Navigation renders Setup from module metadata through the Setup-owned `setup.view` aggregate ability, and the Setup sidebar plus landing page render discovered `SetupNavigation` metadata. Settings remains opened from the header global action, but Settings routes now switch the active Frame sidebar area to Settings and render discovered `SettingsSidebar` metadata. Legacy `view-platform-setup` remains a compatibility delegate only.
- Structured module permission definitions are implemented through `app/Core/Modules/Definitions/Permission.php`. Module manifests still expose the legacy plain `permissions` list for compatibility, but Roles now consumes labels, descriptions, grouping metadata, elevated flags, and default role preset intent from structured definitions.
- Permission alignment evidence supports the active Roles write UI: route-matrix permissions, Gate-backed UI entry abilities, module owners, role default metadata, and role permission assignment behavior are covered by focused tests while keeping current `platform.*` permission keys unchanged.
- `app/Core/Modules/Definitions/Example.php` documents the draft definition shape.
- `Modules/Roles/Definition.php`, `Modules/Dashboard/Definition.php`, `Modules/Notifications/Definition.php`, `Modules/Settings/Definition.php`, `Modules/Preferences/Definition.php`, and `Modules/Setup/Definition.php` prove package-local definitions can own package metadata while keeping current URLs stable.
- `Modules/Roles/Providers/Provider.php` proves package-local providers can own module-specific Gates through the existing package loader.
- `Modules/Roles/Database/Seeders/Defaults.php` proves package-local default seeders can own module bootstrap data while compatibility seeders remain in `database/seeders`; role permission seeding is bootstrap-only after CRUD so manual role edits are preserved.
- `Modules/Roles` now proves a module-owned admin CRUD page can manage protected system roles plus custom roles while consuming module-declared permission metadata.
- Complex definitions such as Logging, Users, Docs Viewer, and Security Checklist remain inline or app-core until their route, view, permission, settings, and audit ownership is reviewed separately. retired reference viewer is a transitional artifact to ignore/retire, not a module migration target.
- `PackageDefinition::defaults` derives standard module package metadata from folder name.
- `PackageRegistrar` can register configured module routes, views, migrations, and optional custom providers.
- Definitions coverage proves current immediate `resources/views/platform/*` directories and real `Modules/<ModuleName>/resources/views` directories have exactly one module owner.
- Future module package view roots under `Modules/<ModuleName>/resources/views` are checked when real, non-template module packages exist.
- Dashboard, Notifications, Settings, Preferences, and Setup have since moved route/view ownership into package-local module roots. Settings now owns the `/settings` landing route, the Settings header global action target, and standard Frame sidebar/landing discovery from `SettingsSidebar` metadata. Deprecated General settings pages are compatibility/update endpoints only, not active Settings sidebar or landing entries. Notifications now owns its setup page contribution in addition to notification settings. Migrations, tenant resolution, and persisted lifecycle state remain unchanged. retired reference viewer remains excluded from target module/core planning.

## Out Of Scope

- dynamic code loading
- runtime install or enable UI
- persisted module lifecycle state
- tenant resolver or tenant provisioning
- route, migration, test, or view reorganization
- converting platform-management tools into tenant-eligible modules
