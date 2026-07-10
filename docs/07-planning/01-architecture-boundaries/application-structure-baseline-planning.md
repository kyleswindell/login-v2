# Application Structure Baseline Planning

Status: Superseded historical baseline review map

This note is retained as historical context for the folder-ownership review that preceded the current core capability package direction. Do not use it as the current implementation map.

Current planning entry points:

- [Core Capability Package Migration Planning](core-capability-package-migration-planning.md)
- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)

## Purpose

Define the historical review order for establishing the application structure baseline under the earlier vocabulary:

- Registry
- App Instance
- Workspace
- Frame
- Area
- Module
- Core Module

This planning note exists because implementation mapping should not start until the baseline ownership model is reviewed across root folders, `app/` internals, controllers, models, routes, views/components, database, and tests.

## Review Status Matrix

| Order | Review Area | Status | Purpose | Expected Output |
| --- | --- | --- | --- | --- |
| 1 | Root folders | Reviewed | Confirm top-level repository folder responsibilities. | Approved root-folder purpose list and any legacy/deferred root folders. |
| 2 | `app/` internal folders | Reviewed | Decide what generic application/runtime code belongs under each `app/` folder. | Ownership rules for `app/Core`, `app/Http`, `app/Models`, `app/Providers`, `app/Support`, and transitional `app/Platform`. |
| 3 | Controllers | Reviewed | Decide controller ownership and placement. | Rules for shared/core controllers, module-owned controllers, Registry controllers later, and transitional `app/Http/Controllers/Platform`. |
| 4 | Models | Reviewed | Decide model ownership and placement. | Rules for app-shared models, module-owned models, future Registry models, and current User/Setting/Notification/log model ownership. |
| 5 | Routes | Reviewed | Decide route ownership, route registration, and transitional route handling. | Rules for `routes/web.php`, module route files, route naming, `/platform/*` transition, and future aliases. |
| 6 | Views/components | Reviewed | Decide rendering file ownership and component placement. | Rules for private `x-layouts.app.frame.*` Frame adapters, auth views, shared UI components, module-owned views, and transitional `resources/views/platform/*`. |
| 7 | Database | Reviewed | Decide migration/schema ownership across core modules, optional modules, and future Registry. | Rules for core module migrations, module migrations, Registry schema later, and app-instance database ownership. |
| 8 | Tests | Reviewed | Decide test ownership and placement. | Rules for app-level integration tests, module tests, naming conventions, and deferred retired reference viewer tests. |

## 1. Root Folders

Review goal:

Confirm the root folder responsibilities before making deeper ownership decisions.

Current approved direction:

- `app/` contains generic Laravel application runtime and shared application services.
- `Modules/` contains self-contained capability packages.
- `config/` contains bootstrap configuration only, not tenant/user/settings/module truth.
- `database/` owns schema and seeders for the current app database layer.
- `resources/` owns shared UI assets, global Blade components, CSS, JS, and transitional non-module views.
- `routes/` owns route entry registration.
- `docs/` owns canonical documentation truth.
- `tests/` owns app-level test coverage.
- `ops/`, `.docker/`, `.github/`, and `scripts/` own support/deployment/automation tooling.
- generated/vendor folders are non-architectural.
- legacy folders such as `Old Docs` must not influence new architecture.

Open items:

- identify root folders that are legacy, generated, transitional, or deferred.
- decide whether module-local tests should eventually live under `Modules/<Module>/tests`.

## 2. `app/` Internal Folders

Review goal:

Decide what belongs under generic `app/` folders now that `app/` must not encode Parasolutions-specific, tenant-specific, workspace-specific, or control-plane-specific boundaries.

Folders to review:

- `app/Core`
- `app/Events`
- `app/Http`
- `app/Models`
- `app/Providers`
- `app/Rules`
- `app/Support`
- `app/Console`
- `app/Livewire`
- `app/Filament`
- `app/Platform`
- `app/Surfaces`
- `app/Ui`

Expected decisions:

- which folders remain canonical
- which folders are transitional
- which folders should eventually move into modules
- which folders should not receive new code

### `app/Platform` Mapping

Status: Reviewed for subfolder mapping.

`app/Platform` is a transitional bucket. It should not receive new generic Workspace, Core Module, Frame, Registry, or app-instance runtime work unless a later decision explicitly keeps that code there.

Current `app/Platform` subfolder mapping:

| Current folder | Actual ownership direction | Status |
| --- | --- | --- |
| `Auth` | Auth Core Module services. | Should eventually move out of `Platform`; core module-owned. |
| `Dashboard` | Legacy Dashboard widget-support code. | Current `/dashboard` proof is now owned by `Modules/Dashboard`; legacy widget code is deferred until a rebuild is approved. |
| `Docs` | Deferred `DocsViewer` internal module candidate. | Not Core; not Registry-owned by default. |
| `Logging` | Audit Logging Core Module service, despite `PlatformLogger` naming. | Should eventually move out of `Platform`; core module-owned. |
| `Navigation` | Workspace Layout / Area Infrastructure for area/sidebar contributions. | Should not be `Platform`; not a module unless a later implementation decision proves module packaging is useful. |
| `Notifications` | Notifications Core Module service. | Migrated to `Modules/Notifications`; old `Platform` location is no longer the owner. |
| `Security` | Mixed runtime security plus Security Checklist/Definitions concerns. | Needs split: runtime security/readiness deeper review versus deferred `SecurityChecklist` module candidate. |
| `Settings` | Settings Core Surface Module service. | Migrated to `Modules/Settings`; old `Platform` location is no longer the owner. |
| `Shell` | Current implementation alias for Frame data. | Transitional alias; target Workspace Layout / Area Infrastructure and private `x-layouts.app.frame.*` composition after Frame implementation naming is approved. |
| `retired reference viewer` | Deferred `retired reference viewer` internal module/tool. | Deferred until rebuilt through `_Template` module path and reference page design. |

Current buckets:

- Core module-owned later: `Auth`, `Logging`
- Implemented Core Module/Core Surface Module packages: `Notifications`, `Dashboard`, `Settings`, `Preferences`, `Setup`
- Workspace Layout / Area Infrastructure later: `Navigation`, `Shell`/Frame
- Deferred/internal module candidates: `DocsViewer`, `SecurityChecklist`, `retired reference viewer`
- Split responsibility: Runtime Readiness
- Internal-tooling boundary: Filament and console proof paths

No files move as part of this planning review.

### Platform-Prefixed Shared Code Migration Target

Status: Planning target identified.

The current `Platform` prefix is overloaded. It currently appears as a namespace, route prefix, route-name prefix, permission prefix, view path, model/event name, and navigation grouping. That prefix should not be treated as one future owner.

Current meanings that must be separated:

| Current `Platform` usage | Current examples | Future ownership direction |
| --- | --- | --- |
| Route URL prefix | `/platform/users`, `/platform/settings`, `/platform/security`, `retired reference viewer routes` | Transitional browser routes. Keep stable until aliases and tests are planned. |
| Route-name prefix | `platform.users.*`, `platform.settings.*`, `notifications.*`, `platform.notifications.*` | `notifications.*` is canonical for the Notifications module. Remaining `platform.*` names are transitional. Do not use route names as ownership proof. |
| Permission prefix | `platform.*` permissions | Transitional permissions. Future permissions should be declared by their owning module or Registry tool. `platform.roles.*`, `platform.notifications.view`, `platform.settings.view`, and `platform.settings.manage` are migration inputs only and map to canonical `roles.*`, `notifications.*`, and `settings.*` permissions. |
| View path prefix | `resources/views/platform/*` | Transitional view grouping. Future shared/module views need owner-approved locations before moving. |
| Service namespace | `Modules/Auth`, `Modules/Notifications`, `Modules/Settings` | Mixed ownership. Auth, Notifications, and Settings have moved to module packages; remaining Platform namespaces still need owner review. |
| Model/event names | `Modules/Notifications/Models/Notification`, `Modules/Notifications/Events/*` | Notifications uses module-local names; remaining `Platform*`/`Central*` names are transitional where still present. |
| Navigation grouping | `PlatformNavigation`, `config/navigation.php` entries | Transitional Frame/navigation configuration. Future navigation should consume module and workspace-area metadata. |

Migration target buckets:

| Bucket | Current examples | Direction |
| --- | --- | --- |
| Core Module code | `Modules/Auth`, `Modules/Notifications`, `app/Platform/Logging/PlatformLogger.php`, `PlatformAuditLog`, `CentralErrorLog` | Auth and Notifications now prove package ownership under `Modules/Auth` and `Modules/Notifications`. Move remaining Core Module code only after each module boundary is approved. Do not keep permanent `Platform` naming for shared Audit Logging or Error Logging behavior. |
| Core Surface Module code | `app/Platform/Dashboard`, `Modules/Settings`, `Modules/Preferences`, `Modules/Setup` | `Modules/Dashboard` now owns the blank `/dashboard` page proof. `app/Platform/Dashboard` is deferred widget-support code. Settings owns the `/settings` landing route and header global action target. Settings, Preferences, and Setup now own package routes, controllers/builders, and views while keeping current URLs stable. |
| Workspace Layout / Area Infrastructure code | `app/Platform/Navigation`, `app/Platform/Shell/AppShellData.php`, Frame/navigation composition data | Future target is not a module by default. Move only after Frame, Area, navigation aggregation, and layout infrastructure naming are approved. `Shell` remains a reserved implementation alias. |
| Runtime readiness/security code | `app/Platform/Security/RuntimeSecurityConfig.php`, `RuntimeSecurityChecker.php`, runtime check command/evidence | Split responsibility. The checker runs app-instance-local. Future Registry visibility may consume sanitized summarized evidence only. |
| Deferred/internal module/tool candidates | `app/Platform/Docs`, `SecurityRequirementCatalog`, Security Checklist controllers/views, `retired reference viewer source`, retired reference viewer routes/views/tests | Current targets are `DocsViewer`, `SecurityChecklist`, and `retired reference viewer`. Do not force Registry ownership by default. |

Migration sequencing rules:

1. Do not mass-rename `Platform` folders, routes, views, models, events, or permissions.
2. Do not create permanent folders named after temporary review labels.
3. Decide owner vocabulary first: Core Module, Workspace framework/surface, Runtime Security, Registry/internal tool, or deferred module/tool.
4. Move service-level code before route/view aliases only when the target owner is approved.
5. Keep `/dashboard` as the default authenticated landing route.
6. Keep existing `/platform/*` browser routes stable until route aliases and compatibility tests are planned.
7. Defer DocsViewer, SecurityChecklist, and retired reference viewer migration until module/tool package plans exist.
8. Treat `platform.*` permissions as transitional; future permission declarations should come from owning modules/tools.
9. Keep Runtime Readiness app-instance-local by default; do not centralize raw runtime configuration or probe results in Registry.
10. Treat Filament as optional internal tooling and `/console/*` proof paths as non-product evidence, not architecture expansion points.

Recommended first reorganization planning target:

Define the neutral owner locations for shared Core Module services currently under `app/Platform/Logging` and app-instance-local error logging. Auth, Account, Notifications, Settings, Preferences, and Setup have completed stable Core Module/Core Surface Module package migrations.

Approved target package roots:

```text
Modules/Auth
Modules/Account
Modules/Users
Modules/Roles
Modules/Notifications
Modules/AuditLogging
Modules/ErrorLogging
```

Core modules use the same package layout as optional modules. Core status is lifecycle metadata, not a separate folder type.

Reason:

- they are used by active auth/account/dashboard flows
- they are shared app-instance behavior, not Registry/internal tooling
- they contain the clearest misleading `Platform` names
- they can be planned without touching deferred retired reference viewer or future Registry routes
- `Modules/ErrorLogging` owns app-instance-local detailed error logs, while future Registry error visibility should use sanitized telemetry or audited support access only

#### Core Module Migration Order For First Four Modules

Status: Planning target approved for modules 1-4.

This order is for future implementation planning only. It does not move files, rename classes, rename routes, rename tables, or create compatibility aliases in this pass.

Migration prerequisites for each module:

- create the module package root from `Modules/_Template`
- define `module.php` with core lifecycle metadata: installed by default, enabled by default, not disableable
- register only package metadata first
- move service-level code before route/view/model/schema renames
- keep existing route URLs and names stable until aliases and tests are explicitly planned
- keep current app-level tests in place until module-local test conventions are approved

##### 1. Auth

Status: Implemented as a real Core Module package boundary.

Target package root:

```text
Modules/Auth
```

Current package ownership:

- `Modules/Auth/Services/*` owns login, MFA, password, and suspicious-auth services.
- `Modules/Auth/Http/Controllers/*` owns login/logout, MFA challenge/enrollment/step-up, and account MFA routes.
- `Modules/Auth/Http/Requests/*` owns login request validation.
- `Modules/Auth/Models/*` owns MFA method, MFA policy, and recovery-code records.
- `Modules/Auth/resources/views/*` owns guest auth and MFA/account-security views.
- `Modules/Auth/Routes/web.php` preserves existing `/login`, `/mfa/*`, `/account/mfa/*`, and `logout` route names.
- MFA/auth migrations and tests remain in root locations until module migration/test conventions are approved.

Reason for first position:

- Auth is the highest-value shared core capability
- MFA, password policy, throttling, suspicious-auth monitoring, and login flow are active security surfaces
- existing focused Auth/MFA tests can protect behavior during a later migration

Guardrails:

- keep login routes and MFA routes stable during package extraction
- do not rename user/MFA tables in the first migration pass
- do not move user identity ownership until Account, Users, and Roles boundaries are reviewed together

##### 2. Notifications

Target package root:

```text
Modules/Notifications
```

Current candidates:

- `Modules/Notifications/Services/Store.php`
- `Modules/Notifications/Events/Created.php`
- `Modules/Notifications/Events/Updated.php`
- `Modules/Notifications/Models/Notification.php`
- `Modules/Notifications/Http/Controllers/*`
- `Modules/Notifications/Routes/web.php`
- `Modules/Notifications/resources/views/index.blade.php`
- `Modules/Notifications/resources/views/settings/defaults.blade.php`
- notification user preferences later

Reason for second position:

- notification runtime is a contained core capability
- the current service/event/model boundary is easy to identify
- visible navigation can remain unchanged while backend ownership is clarified
- Notifications is now implemented as the second stable module package proof after Dashboard

Guardrails:

- notification access through the header notification trigger remains the UI direction
- do not re-add Notifications as a primary navigation item
- keep current `/platform/*` route URLs, route names, permission names, table name, and broadcast payload shape stable
- notification default settings are module-owned inside `Modules/Notifications`; notification user preferences remain future Preferences contribution work

##### 3. Audit Logging

Target package root:

```text
Modules/AuditLogging
```

Current candidates:

- `app/Platform/Logging/PlatformLogger.php`
- `app/Models/PlatformAuditLog.php`
- audit log controller, views, routes, table, seed/test support, and evidence docs later

Reason for third position:

- many services depend on the logger, so service ownership should be clarified before UI/schema naming
- audit logging is app-instance event history, not Registry-global logging
- moving the service first can reduce misleading `PlatformLogger` usage without changing audit behavior

Guardrails:

- do not rename `platform_audit_logs` until a schema-compatibility plan exists
- do not centralize tenant/app-instance audit logs into Registry by default
- keep audit metadata safety requirements intact during any later service move

##### 4. Error Logging

Target package root:

```text
Modules/ErrorLogging
```

Current candidates:

- `app/Models/CentralErrorLog.php`
- error log controller, views, routes, table, exception capture pipeline, and tests later

Reason for fourth position:

- the logging boundary must remain explicit before implementation
- detailed error logs are app-instance-local and may contain sensitive diagnostics
- Registry should receive sanitized telemetry only unless audited support/Direct Control access is designed

Guardrails:

- do not rename or centralize `central_error_logs` until app-instance-local ownership and compatibility are planned
- do not create a Registry raw-error database as part of the module move
- define safe telemetry fields before any Registry error visibility work

##### 5. Users And Roles

Status: Boundary reviewed and implemented for Roles module self-containment, structured permission definition consumption, permission alignment evidence, and the first Roles & Permissions CRUD surface. `Modules/Roles` is now the canonical role package for role presets, custom roles, permission grouping, assignment guardrails, role Gates, bootstrap-only default role seeding, and role permission assignment UI. `Modules/Users` remains pending.

Target package roots:

```text
Modules/Roles
Modules/Users
```

Boundary decision:

- `Modules/Roles` owns role models, role management, permission grouping, role presets/defaults, elevated-role guardrails, and Spatie role/permission integration.
- `Modules/Users` owns administrator-managed user lifecycle: user list, create/edit users, activate/deactivate users, admin-managed profile fields, and assigning/removing roles from a user through the Roles module boundary.
- permission declarations are module-owned; `Modules/Roles` groups permissions into roles but does not own every permission value.
- structured permission metadata is implemented through `app/Core/Modules/Definitions/Permission.php`; current `platform.*` permission keys remain unchanged.
- `Modules/Account` remains separate from Users because Account owns self-service for the currently logged-in user.
- `Modules/Auth` remains separate from Users because Auth owns login, sessions, MFA, step-up, recovery codes, and suspicious-auth controls.

Current mixed-code candidates:

- `app/Http/Controllers/Platform/PlatformUserController.php` mixes user CRUD, role assignment, and permission display.
- `app/Http/Controllers/Platform/PlatformUserMfaController.php` is a Users administrative action that calls Auth/MFA services.
- `app/Http/Requests/Platform/StorePlatformUserRequest.php` and `UpdatePlatformUserRequest.php` mix user validation with role-assignment authorization.
- `Modules/Roles/Services/AssignmentGuard.php` now owns elevated-role assignment guardrails used by current user-management flows.
- `Modules/Roles/Providers/Provider.php` now owns the `super_admin` bypass and Roles-specific Gates.
- `Modules/Roles/Database/Seeders/Defaults.php` now reads structured module-declared permissions, migrates legacy role keys, and bootstraps canonical role presets without overwriting later manual role permission changes.
- `Modules/Roles` now owns the `/platform/roles` Roles & Permissions CRUD surface for custom role create/edit/delete and system role permission assignment. `super_admin` remains immutable.
- `database/seeders/PlatformRolesAndPermissionsSeeder.php` remains as a compatibility wrapper only.
- Permission alignment tests now prove route-matrix permissions, Gate-backed UI entry abilities, module owners, and default role metadata agree before and during Roles write UI behavior.
- `app/Models/User.php` currently mixes identity, role traits, MFA relationship helpers, notification traits, and transitional Filament access.
- `resources/views/platform/users/*` mixes user form fields, role assignment controls, permission display, and administrative MFA controls.
- `app/Core/Modules/Definitions.php` currently treats users and RBAC as one owner with `users-rbac` metadata.

Migration order:

1. Create `Modules/Roles` foundation first. Implemented.
   - Module-owned permission declarations feed the Roles permission catalog.
   - Structured permission definitions provide readable labels, descriptions, groups, elevated flags, and default role preset intent.
   - Canonical role presets are `super_admin`, `admin`, `manager`, `user`, and `default`.
   - Elevated-role assignment guardrails are owned by `Modules/Roles/Services/AssignmentGuard.php`.
   - Roles-specific Gates are owned by `Modules/Roles/Providers/Provider.php`.
   - Default role/permission bootstrap seeding is owned by `Modules/Roles/Database/Seeders/Defaults.php`.
   - Roles & Permissions CRUD is implemented for protected system roles plus custom roles.
   - Permission alignment evidence is complete and supports the active Roles write UI.
   - Spatie package integration remains stable.
2. Create `Modules/Users` administrative lifecycle second.
   - Move user admin services/controllers/requests only after the Roles boundary exists.
   - Route role assignment through Roles-owned services/policies.
   - Keep user CRUD and status changes behaviorally unchanged.
3. Move self-service profile/account work only through `Modules/Account`.
   - Do not mix current-account self-service with administrator user management.
4. Leave the `User` model in `app/Models` during early migration.
   - It is shared by Auth, Account, Users, Roles, MFA, Notifications, and transitional Filament code.
   - Model relocation should wait until module model conventions, Filament internal-tooling boundaries, and user identity ownership are stable.

Guardrails:

- do not rename role or permission tables until Spatie compatibility and schema migration are explicitly planned
- `platform_*` role keys have been migrated to canonical role keys; `platform.*` permission names remain unchanged while structured permission definitions provide readable metadata
- do not move `User` too early
- do not make Users own permission declarations from other modules
- do not make Roles own user profile/lifecycle behavior
- do not mix Account self-service with administrator user management

##### 6. Account

Status: Boundary reviewed and implemented as a real Core Module package boundary.

Target package root:

```text
Modules/Account
```

Boundary decision:

- `Modules/Account` owns current-account self-service for the logged-in user.
- Account owns my account, profile/basic identity editing, email/password change surfaces, account menu self-service entries, and account-owned preference contributions.
- Account may render self-service MFA enrollment and recovery-code screens, but it calls Auth-owned MFA services.
- Account does not own administrator user management, role assignment, permission management, login/session/MFA engines, or the Preferences surface/framework.

Current mixed-code candidates:

- `Modules/Account/Http/Controllers/AccountController.php` owns current-account profile/settings updates and password/email change step-up checks.
- `Modules/Auth/Http/Controllers/AccountMfaController.php` owns self-service MFA enrollment/recovery-code routes because MFA behavior is Auth-owned even when linked from Account.
- `Modules/Account/resources/views/*` contains account overview and account settings views.
- `Modules/Auth/resources/views/account/*` contains self-service MFA enrollment and recovery-code display views.
- Preferences moved to `Modules/Preferences/resources/views`.
- `/account/*` routes are stable browser routes, but their current route names use the transitional `platform.account.*` prefix.
- `Modules/Account/Definition.php` and `Modules/Auth/Definition.php` now own package metadata, but the current route/view names remain platform-prefixed.
- `app/Models/User.php` carries fields used by Account, Users, Auth, Roles, Notifications, MFA, Preferences, and transitional Filament access.

Migration order:

1. Create `Modules/Account` package metadata. Implemented.
   - Preserve `/account/*` URLs.
   - Keep current route names until aliases and tests are planned.
2. Move account self-service controller/request/service logic. Implemented for the current account controller.
   - Keep password/email change step-up behavior intact.
   - Keep Account calling Auth services for MFA and security assurance.
3. Move account views with route/view ownership tests. Implemented for account overview/settings.
   - Do not mix account views with administrator user-management views.
4. Keep preference storage on the current user record until a Preferences storage decision is approved.
   - Account can contribute preference entries, but Preferences remains the Workspace surface/framework.
5. Leave `User` in `app/Models` during early Account migration.

Guardrails:

- do not rename `/account/*` routes in the first Account migration pass
- do not move MFA engine classes into Account
- do not move administrator user lifecycle into Account
- do not make Account own the Preferences framework
- do not move the `User` model before Auth, Account, Users, Roles, Notifications, and Filament dependencies are stable

##### 7. Core Surface Modules

Status: Boundary reviewed and accepted.

Target package roots:

```text
Modules/Dashboard
Modules/Settings
Modules/Setup
Modules/Preferences
```

Boundary decision:

- Core Surface Modules are required modules that provide shared Workspace surfaces.
- They are installed by default, enabled by default, and not disableable.
- They may own routes, controllers, views, storage, registries, contribution contracts, tests, and docs for their surface.
- They do not own every contribution rendered inside the surface.

Surface ownership:

| Module | Owns | Does not own |
| --- | --- | --- |
| `Modules/Dashboard` | Authenticated `/dashboard` route, blank main view, module-local language defaults, Dashboard package metadata, and future dashboard contribution/storage contracts. | Every module's widgets, the old widget grid, current legacy widget customization behavior, or tenant/app-instance copy override storage. |
| `Modules/Settings` | Settings registry, settings page aggregation, settings routes/views, settings storage framework. | Every module's settings values or settings pages. |
| `Modules/Setup` | Setup step/screen aggregation, setup routes/views, setup progress framework when needed. | Every module's setup steps. |
| `Modules/Preferences` | User/account preference aggregation, preferences routes/views, preference storage framework when needed. | Every module's preference fields. |

Workspace Layout / Area Infrastructure ownership:

| Infrastructure | Owns | Does not own |
| --- | --- | --- |
| Frame | Persistent Workspace layout composition: Header, Area Navigation, Global Actions, Sidebar, Main, account/global-action placement. | Business module content, surface routes, or contribution behavior. |
| Area/navigation aggregation | Area registry/resolution, area navigation aggregation, sidebar navigation aggregation, current-state resolution. | Every module's navigation entries. |

Current mixed-code candidates:

- `Modules/Dashboard` now owns the authenticated `/dashboard` route, blank main view, and default Dashboard language strings.
- `app/Platform/Dashboard/*`, `app/Livewire/Platform/Dashboard/DashboardPage.php`, and `resources/views/livewire/platform/*` are deferred legacy widget/customization code and should not receive new Dashboard work before the rebuild plan.
- `Modules/Settings` now owns settings routes/views, the settings store, and settings sidebar builder. Logging, Users, and Docs settings pages remain hosted transitional contributions until those modules are packaged.
- `Modules/Setup` now owns setup routes/views and setup navigation builder.
- `app/Platform/Navigation/*`, `config/navigation.php`, and current Frame navigation data map toward Workspace Layout / Area Infrastructure.
- `app/Platform/Shell/AppShellData.php`, `resources/views/components/layouts/app/*`, and current `components/shell/*` primitives map toward Workspace Layout / Area Infrastructure or shared layout primitives after implementation naming is approved.
- `Modules/Preferences` now owns `/account/preferences` route handling and the preference view. `User` preference fields and `UserDashboardLayout` still overlap with `Modules/Preferences`, `Modules/Account`, and `Modules/Dashboard`.

Migration order:

1. Define contribution contracts before moving files.
   - Settings contributions: implemented as `SettingsPage` entries in `SettingsSidebar`, with settings sidebar consumption already active.
   - Preferences contributions: implemented as `PreferencePage` entries in `PreferencesNavigation`, with the current personal defaults page packaged in `Modules/Preferences`.
   - Setup contributions: implemented as `SetupScreen` entries in `SetupNavigation`, with current setup screens packaged in `Modules/Setup`.
   - Dashboard widget contributions, deferred until the widget system is rebuilt from scratch.
   - Navigation/Area contributions.
2. Move registry/aggregation services before moving rendered views.
3. Keep existing rendered Frame/layout components in place until Workspace Layout / Area Infrastructure ownership is approved in implementation.
4. Keep existing `/platform/settings/*`, `/platform/setup/*`, `/account/preferences`, and `/dashboard` routes stable until aliases/tests are planned.
5. Move storage only after ownership is clear.
   - `settings` table belongs to Settings framework storage.
   - `user_dashboard_layouts` remains deferred legacy Dashboard/Preferences storage until the widget/layout rebuild is approved.
   - user preference fields need a Preferences/Account storage decision before moving.

Guardrails:

- do not create a second authenticated layout/frame
- do not move additional settings/setup/preferences contribution views before their owning modules are packaged
- do not make Settings own every module's settings behavior
- do not make Setup own every module's setup behavior
- do not make Dashboard own every module's widgets
- do not make Preferences own every module's preference definitions
- do not force Frame or navigation aggregation into modules for consistency alone
- treat `Shell` as an implementation alias, not canonical planning vocabulary
- use `doc-review-2026-07-06-frame-contribution-readiness` as the review gate before implementing header global actions, area navigation, sidebar contribution, setup navigation, account/preferences contribution, or notification bell migration

##### 8. Deferred/Internal Modules And Tooling

Status: Boundary reviewed for DocsViewer, SecurityChecklist, retired reference viewer, Runtime Readiness, and Filament/console proof paths.

Deferred/internal module candidates:

| Candidate | Current implementation | Direction |
| --- | --- | --- |
| `DocsViewer` | `app/Platform/Docs`, `Platform/DocsController.php`, `resources/views/platform/docs`, `/platform/docs` | Deferred optional/internal module candidate. Not Core. Not Registry-owned by default. May later be tenant-eligible if an app instance needs a docs viewer. |
| `SecurityChecklist` | `SecurityRequirementCatalog`, `SecurityChecklistController`, `SecurityRequirement*` models, `resources/views/platform/security`, `security_requirement*` tables, `/platform/security/*` | Deferred optional/internal module candidate. Not Core. Do not force Registry ownership before Registry boundaries and evidence aggregation are designed. |
| `retired reference viewer` | `retired reference viewer source`, `retired reference viewer controller`, `retired reference viewer views`, retired reference viewer tests/routes | Deferred tool/module rebuild through `_Template` module path and reference page design. Must not block base Workspace/Core Module work. |

Rules:

- keep current `/platform/docs`, `/platform/security`, and `retired reference viewer routes` routes stable until module route aliases and rebuild plans exist
- do not copy these modules into client app instances by default
- do not treat these modules as Core Modules
- do not force these modules into Registry ownership by default
- `SecurityChecklist` may become Registry-facing later, but that requires a separate Registry/evidence aggregation decision
- `retired reference viewer` stays deferred until the reference page design and module package implementation path are approved

Runtime Readiness split:

| Concern | Current implementation | Direction |
| --- | --- | --- |
| App-instance-local runtime check | `RuntimeSecurityConfig`, `RuntimeSecurityChecker`, `platform:security-runtime-check`, security headers, session cookie posture, trusted proxy checks, HSTS, database transport posture, optional HTTP probe | Keep local to the resolved app instance. It may inspect local config and deployed response headers. It must not imply Registry owns raw runtime config. |
| Registry runtime evidence | Not implemented. | Future Registry visibility may receive only sanitized summarized results: target, status, check names, timestamps, app-instance identity, and non-secret evidence links. Do not centralize raw env values, connection strings, headers containing secrets, cookies, or probe payloads. |
| Security Checklist evidence | `SecurityChecklist` module candidate currently links/checks readiness evidence. | SecurityChecklist can reference runtime readiness evidence locally. Registry-facing evidence remains a later explicit integration decision. |

Filament/console proof-path disposition:

| Current implementation | Direction |
| --- | --- |
| `app/Filament`, `ConsolePanelProvider`, Filament resources/widgets, `/console/*` proof routes | Optional internal tooling. Do not add new Core Module, Workspace, Frame, Registry, notification, settings, DocsViewer, SecurityChecklist, or retired reference viewer product work here. |
| `EnsureConsoleProofPathsEnabled` and `CONSOLE_PROOF_PATHS_ENABLED=false` default | Keep as a temporary proof-path gate while `/console/*` routes exist. Default-off remains the correct posture. |
| Filament audit/error/user proof views | Keep only when they have explicit internal-tooling value. Do not count positive Filament renders as product behavior evidence. |
| Filament dashboard widgets | Remove from product dashboard ownership. App-owned Dashboard adapters or future Dashboard module contributions should own rendered dashboard behavior. |

Filament role-boundary cleanup order:

1. Inventory every remaining `/console/*` proof route and Filament resource/widget.
2. Confirm the app-owned or module-owned replacement for each proof surface.
3. Narrow tests to app-owned behavior and keep only disabled-path proof tests while the gate exists.
4. Remove Filament resources/widgets from product route and dashboard ownership.
5. Keep `ConsolePanelProvider` only if explicitly useful internal tooling remains.
6. Remove `EnsureConsoleProofPathsEnabled`, `CONSOLE_PROOF_PATHS_ENABLED`, and transitional Filament access coupling from `User` only after no Filament auth surface depends on them.

Concrete sequencing owner: [Filament Role Boundary And Console Proof Path Planning](filament-console-proof-retirement-planning.md).

No files move as part of this planning review.

### `app/Livewire` Mapping

Status: Reviewed for current usage.

`app/Livewire` remains an allowed Laravel stack folder while the app uses Livewire. It is no longer required by the authenticated `/dashboard` route; the old `DashboardPage` Livewire component is deferred legacy widget/customization code.

Current direction:

- `app/Livewire` may remain as a framework folder for Livewire component classes.
- Current `app/Livewire/Platform/*` naming is transitional. Dashboard route/view ownership now starts in `Modules/Dashboard`; old Livewire dashboard/widget rendering remains inactive until a rebuild is approved.
- Livewire itself is an implementation tool, not an app architecture boundary. It should not decide whether a capability is a Core Module, Workspace surface, Registry tool, or deferred module.
- Future module-owned Livewire components may move under module-owned folders only after the module controller/view/component conventions are approved.

No files move as part of this planning review.

### `app/Filament` Mapping

Status: Reviewed for current usage.

`app/Filament` is active but transitional. The app still registers a Filament console panel and discovers Filament resources/widgets. Filament may remain installed for explicit internal tooling, but it should not own product Workspace UI or design-system direction.

Current direction:

- `app/Filament` remains allowed only for existing transitional/proof surfaces or explicitly approved internal tooling.
- Do not add new Core Module, Workspace, Frame, Registry, notification, or settings work to Filament unless a later decision explicitly approves it.
- Filament is not required for real-time notifications. Notifications should be owned by the Notifications Core Module/service, with Livewire, Reverb, browser JavaScript, or other delivery/rendering tools used as implementation details.
- Product dashboard rendering should not depend on Filament widget classes.
- Current Filament resources/widgets are not the target architecture for shared Workspace features.

No files move as part of this planning review.

### `app/Surfaces` And `app/Ui` Mapping

Status: Reviewed for current usage and future naming direction.

`app/Surfaces` currently owns the PHP helper classes that load, normalize, and validate UI entry `contract.php` files. Those contracts are intended to become durable app-wide design-system contracts used to prevent visual/API drift across elements, components, and patterns.

`app/Ui` currently contains an empty `Contracts` folder and a `Reference` folder with `retired reference viewer definition repository`. That repository loads and validates retired reference viewer `reference.php` metadata. It is not the component API contract source and is not generic app UI runtime.

Current direction:

- `app/Surfaces` is a transitional name.
- The approved future contract-family name is `Design`.
- The target future home for app-wide design-system contracts is `app/Contracts/Design`.
- `Surface::component()` should eventually become a clearer design contract factory name, such as `Definition::component()`.
- `retired reference viewer definition repository` should eventually move into the retired reference viewer module/tool when retired reference viewer is rebuilt or extracted.
- retired reference viewer may consume design contracts, but the design contract layer must not depend on retired reference viewer.

Current future mapping:

| Current file | Future direction |
| --- | --- |
| `app/Surfaces/Contracts/Surface.php` | `app/Contracts/Design/Definition.php` |
| `app/Surfaces/Contracts/Repository.php` | `app/Contracts/Design/Repository.php` |
| `app/Surfaces/Contracts/Defaults.php` | `app/Contracts/Design/Defaults.php` |
| `app/Surfaces/Contracts/Normalizer.php` | `app/Contracts/Design/Normalizer.php` |
| `app/Surfaces/Contracts/Validator.php` | `app/Contracts/Design/Validator.php` |
| `retired reference viewer definition repository` | Future retired reference viewer module/tool |

No files move as part of this planning review.

### `app/Support` Mapping

Status: Reviewed for current usage.

`app/Support` is a transitional generic support bucket. It may remain for tiny stateless cross-cutting helpers that do not have an approved feature, module, framework, or tooling owner yet. It must not become a dumping ground for feature services, module services, retired reference viewer tooling, review tooling, local environment automation, or business logic.

Current `app/Support` file mapping:

| Current file | Current purpose | Future direction |
| --- | --- | --- |
| `ActiveBatchReviewQueue.php` | Parses active-batch review queue state and writes/reads a proof-review manifest. | Developer/review tooling; should eventually leave app runtime support. |
| `LocalReviewEnvironment.php` | Prepares local browser-review environment, Vite hot file, Reverb settings, and local review user. | Local/dev tooling; should eventually leave app runtime support. |
| `InternalPhoneFormatter.php` | Stateless phone number normalizer used by account/settings/user flows. | Acceptable short-term helper; later move under Account/User/profile normalization if that owner is approved. |
| `UiOptionCatalog.php` | Provides locale and timezone options for settings/preferences/forms and retired reference viewer examples. | Acceptable short-term helper; later move under Settings/Preferences form option providers if that owner is approved. |

Rules:

- keep `app/Support` small
- do not add new feature/domain services here
- prefer an approved Core Module, Workspace framework, module, or tooling owner when one exists
- remove the folder naturally if its remaining helpers are moved to better owners

No files move as part of this planning review.

### `app/Console` Mapping

Status: Reviewed for current usage.

`app/Console` is the normal Laravel Artisan-command folder. It is acceptable for repo-local commands, but commands should still have clear ownership: framework/runtime commands stay generic, module-owned commands should eventually live with the module or be registered by module metadata, and design-system tooling should not be confused with runtime Workspace behavior.

Current file mapping:

| Current file | Current purpose | Future direction |
| --- | --- | --- |
| `Commands/GenerateUiIconManifest.php` | Generates the trusted local SVG icon manifest used by UI icon rendering. | Design-system tooling. Acceptable short term in `app/Console`; later consider moving with the approved `Design` contract/tooling namespace if the Design system becomes a durable app-wide contract owner. |

Rules:

- keep `app/Console` for framework-recognized Artisan command classes
- do not place tenant/app-instance/workspace-specific behavior here
- keep design-system generation commands tied to Design ownership when that namespace is approved
- module-specific commands should be owned or registered by their module once module command conventions exist

No files move as part of this planning review.

### `app/Providers` Mapping

Status: Reviewed for current usage.

`app/Providers` is a normal Laravel bootstrap folder. It may remain the application service-provider location, but it should not become the long-term dumping ground for module catalogs, permissions, module package registration, or Registry/runtime wiring.

Current file mapping:

| Current file | Current purpose | Future direction |
| --- | --- | --- |
| `AppServiceProvider.php` | Registers app singletons, breached-password checker binding, module package loading, and remaining transitional authorization gates. | Acceptable now, but overloaded. Roles Gates moved to `Modules/Roles/Providers/Provider.php`; remaining gates should move as their modules become self-contained. |
| `Filament/ConsolePanelProvider.php` | Registers the transitional Filament console panel, resources, widgets, middleware, and auth middleware. | Optional internal-tooling support. Keep only while Filament has approved internal value; do not add new Core Module, Workspace, Frame, Registry, notification, or settings architecture here. |

Rules:

- keep framework bootstrap bindings in providers
- avoid adding feature/domain behavior directly to providers
- avoid expanding Filament provider usage unless explicitly approved
- prefer module/feature-owned registration once those conventions exist

No files move as part of this planning review.

### `app/Rules` Mapping

Status: Reviewed for current usage.

`app/Rules` is a normal Laravel validation-rule folder. It may remain for small cross-cutting validation rules, but tool-specific rules should eventually move with their owning module/tool when that boundary exists.

Current file mapping:

| Current file | Current purpose | Future direction |
| --- | --- | --- |
| `SafeEvidenceLinkUrl.php` | Validates security checklist evidence-link URLs and rejects unsafe schemes, protocol-relative URLs, traversal, control characters, and embedded credentials. | Deferred `SecurityChecklist` module/tool ownership. Acceptable in `app/Rules` until that module boundary is implemented. |

Rules:

- keep small reusable validation rules in `app/Rules`
- move tool-specific rules with their module/tool once that owner exists
- do not use `app/Rules` for business services or policy decisions

No files move as part of this planning review.

### `app/Events` Mapping

Status: Reviewed for current usage.

`app/Events` is a normal Laravel event folder. Current notification broadcast events have moved to the Notifications Core Module package.

Current file mapping:

| Current file | Current purpose | Future direction |
| --- | --- | --- |
| `Modules/Notifications/Events/Created.php` | Broadcasts created notification payloads on the authenticated user's private channel. | Implemented module-owned event. |
| `Modules/Notifications/Events/Updated.php` | Broadcasts updated notification payloads on the authenticated user's private channel. | Implemented module-owned event. |

Rules:

- keep future notification events under `Modules/Notifications/Events`
- notification event names avoid permanent `Platform` prefixes for shared Workspace/Core Module behavior
- channel naming and permission scope should be revisited when workspace/app-instance notification boundaries are formalized

No files move as part of this planning review.

### `app/Http` Non-Controller Mapping

Status: Reviewed for current non-controller usage.

Controllers are reviewed separately in this document. The remaining `app/Http` contents are middleware and form-request classes. These may stay in Laravel-standard `app/Http` locations while route/controller ownership is transitional, but their future ownership should follow the feature/module/runtime concern they protect or validate.

Current middleware mapping:

| Current file | Current purpose | Future direction |
| --- | --- | --- |
| `Middleware/ApplySecurityHeaders.php` | Applies baseline security response headers and HSTS when enabled. | Runtime Security core concern. Acceptable in HTTP middleware; config/service ownership should remain runtime-security oriented. |
| `Middleware/ConfigureTrustedProxies.php` | Applies trusted proxy behavior from runtime security config. | Runtime Security / deployment posture concern. Acceptable in HTTP middleware. |
| `Middleware/EnsureRequestId.php` | Creates request/trace IDs and exposes `X-Request-Id`. | Cross-cutting request observability. Acceptable in HTTP middleware; later align with audit/logging runtime conventions if needed. |
| `Middleware/EnsureConsoleProofPathsEnabled.php` | Redirects transitional console-proof paths when disabled. | Transitional Filament/console-proof support. Do not expand; remove when console proof paths are retired. |

Current form-request mapping:

| Current file | Current purpose | Future direction |
| --- | --- | --- |
| `Modules/Auth/Http/Requests/LoginIdentifierRequest.php` | Validates progressive login identifier step. | Implemented as Auth Core Module request. |
| `Modules/Auth/Http/Requests/LoginPasswordRequest.php` | Validates progressive login password step. | Implemented as Auth Core Module request. |
| `Modules/Auth/Http/Requests/LoginRequest.php` | Validates legacy compatibility login post. | Implemented as Auth Core Module request; remove only when legacy login compatibility is intentionally retired. |
| `Requests/Platform/StorePlatformUserRequest.php` | Validates and authorizes transitional platform user creation. | Users and Roles/Permissions Core Modules. `Platform` naming is transitional. |
| `Requests/Platform/UpdatePlatformUserRequest.php` | Validates and authorizes transitional platform user updates. | Users and Roles/Permissions Core Modules. `Platform` naming is transitional. |

Rules:

- keep framework-level HTTP middleware in `app/Http/Middleware`
- keep Auth requests under `Modules/Auth/Http/Requests`
- treat `app/Http/Requests/Platform` as transitional naming for current user-management routes
- do not add new permanent `Platform` request folders for shared Workspace/Core Module behavior
- console-proof middleware should not become the basis for future Registry, Workspace, or module routing

No files move as part of this planning review.

### `app/Core` Mapping

Status: Reviewed for child-folder triage.

`app/Core` remains the intended home for generic application runtime/framework code that is not specific to one module, customer, app instance, tenant, or rendered UI page.

`app/Core` must not become the home for Core Modules. Core Modules use the same self-contained `Modules/<ModuleName>` package shape as optional modules. The word `Core` in Core Module describes lifecycle policy, not filesystem placement.

Boundary rule:

- module capability code belongs under `Modules/<ModuleName>` when it owns or contributes routes, controllers, views, tables, permissions, settings, setup steps, events, jobs, tests, or user-visible behavior
- lower-level engines and primitives may stay under `app/Core` when they support multiple modules and are not independently installed, configured, or exposed as a capability

Examples:

- `Modules/Auth` owns authentication capability
- `Modules/Notifications` owns notification capability
- `Modules/AuditLogging` owns app-instance event logging capability
- `Modules/ErrorLogging` owns app-instance-local detailed error logging capability
- `app/Core/Modules` owns generic module registry/manifest/package infrastructure
- `app/Core/Runtime` owns narrow runtime/context primitives until instance resolution is designed

Current `app/Core` child-folder mapping:

| Current folder | Current purpose | Review need |
| --- | --- | --- |
| `Modules` | Module manifest, registry, Definitions, package registration, lifecycle state, UI contribution metadata, and ownership validation. | Reviewed for current organization. Generic module engine code belongs here; Definitions content and UI placement naming remain transitional. |
| `Runtime` | Static Parasolutions runtime context proof and resolver. | No deeper review needed now unless runtime/domain resolution work resumes. |
| `Workspace` | Empty/provisional folder left from earlier workspace naming. | No active purpose. Ignore or remove when cleanup is approved; do not add new code here. |

#### `app/Core/Modules` Focused Review

Status: Reviewed for current organization.

The `app/Core/Modules` folder is the correct current home for the generic module engine. It should not become a home for module-specific business logic, tenant-specific behavior, workspace-specific views, or Registry runtime behavior.

Current file grouping:

| Current file/group | Ownership direction | Status |
| --- | --- | --- |
| `Manifest`, `Repository`, `LifecycleState` | Generic module manifest and registry engine. | Keep under `app/Core/Modules`. |
| `PackageDefinition`, `PackageRegistrar` | Generic module package registration for packaged modules such as `_Template`. | Keep under `app/Core/Modules`. |
| `Category` | Generic module classification enum. | Keep for now; naming values need future vocabulary review. |
| `UiEntry`, `UiEntryType`, `UiAccessMode` | Generic module UI contribution metadata. | Keep for now; contribution vocabulary needs future review. |
| `UiPlacement` | Internal placement enum for UI entry metadata. | Approved current name. `Shell` is reserved as an alias and should not become canonical vocabulary. |
| `Definitions` | Aggregator for current module definitions and ownership evidence. | Transitional organization. Roles, Dashboard, Notifications, Settings, Preferences, and Setup now prove package-owned metadata from `Modules/<ModuleName>/Definition.php`; simple app-level definitions for UI System and Runtime Security remain externalized under `app/Core/Modules/Definitions`. |

Follow-up concerns:

- `Definitions` still aggregates many transitional `platform.*` route names, `platform.*` permission names, and `resources/views/platform/*` paths.
- `Manifest` and `Repository` currently expose `platformViewPaths`; this is accurate evidence for current file ownership but should not become the permanent naming model.
- `Category::PlatformManagement` reflects current Definitions classification, but future naming must align with the Registry/App Instance/Workspace vocabulary.
- `UiPlacement` now uses Frame/Area/Sidebar/Main-aligned placement language instead of Shell terminology.
- Header Global Actions metadata and rendered consumption now exist for Settings, Notifications, and Account. Search remains Frame-owned; notification panel data is prepared by the Notifications module, and account menu data is prepared by the Account module from `AccountMenu` metadata.
- UI entry metadata remains useful, but `platformViewPaths` and platform-prefixed route names are still transitional until route/view reorganization begins.

Recommended follow-up order:

1. Keep the engine files in place.
2. Continue splitting module definitions into package-local `Modules/<ModuleName>/Definition.php` only when the module is being packaged, or into `app/Core/Modules/Definitions/*` only for small non-packaged proofs. UI System and Runtime Security are the current app-level simple proofs.
3. Review `Category` values after Registry/App Instance/Workspace naming is finalized.
4. Replace or generalize `platformViewPaths` only after route/view reorganization begins.

No files move as part of this planning review.

## 3. Controllers

Review goal:

Decide controller ownership before route or folder migration.

Questions:

- Which controllers are shared/core runtime controllers?
- Which controllers should be module-owned?
- Which controllers are transitional under `app/Http/Controllers/Platform`?
- Where would future Registry controllers live?
- Should module controllers live under `Modules/<Module>/Http/Controllers`?

Expected decisions:

- controller namespace and folder rules
- transitional controller rules
- future module controller convention

### Controller Ownership Mapping

Status: Reviewed for current controller folders.

`app/Http/Controllers` remains the Laravel HTTP entrypoint folder. Controllers should stay thin: request authorization/validation handoff, service calls, view/redirect responses, and no durable domain ownership decisions.

Controller status vocabulary:

- `stays temporarily`: current controller remains in place until route aliases, module route loading, tests, and package ownership are approved.
- `future module controller`: future target is a module package controller under `Modules/<ModuleName>/Http/Controllers/...`.
- `app-level framework/controller`: controller is framework glue rather than module-owned behavior.
- `retired/deferred`: controller or proof surface is not part of current base Workspace planning and should wait for rebuild or retirement.

Current controller ownership matrix:

| Current folder/file | Intended owner | Status | Future direction |
| --- | --- | --- | --- |
| `Controller.php` | Laravel app HTTP base controller | `app-level framework/controller` | Keep as app-level framework glue. |
| `Modules/Auth/Http/Controllers/*` | Auth Core Module, including login/logout, MFA login/enrollment/step-up, and account MFA routes. | `future module controller` | Implemented as module-owned controllers while preserving existing URLs and route names. |
| `Modules/Account/Http/Controllers/AccountController.php` | Account Core Module self-service settings. | `future module controller` | Implemented as module-owned controller while keeping `/account/*` route names and URLs stable. |
| `Platform/PlatformUserController.php` | Users Core Module with Roles boundary dependency. | `stays temporarily` | Future `Modules/Users/Http/Controllers/...`; role assignment must call Roles-owned services. |
| `Platform/PlatformUserMfaController.php` | Users administrative action controller using Auth/MFA services. | `stays temporarily` | Future Users controller/action with Auth/MFA service boundary. |
| `Modules/Settings/Http/Controllers/PageController.php` | Settings surface/framework aggregator. | `future module controller` | Implemented as module-owned controller while keeping `/platform/settings/*` route names and URLs stable. Hosted Logging, Users, and Docs settings pages remain transitional until those modules are packaged. |
| `Modules/Preferences/Http/Controllers/PersonalDefaultsController.php` | Preferences personal defaults page. | `future module controller` | Implemented as module-owned controller while keeping `/account/preferences` and `platform.account.preferences*` route names stable. |
| `Modules/Setup/Http/Controllers/ScreenController.php` | Setup surface/framework screens. | `future module controller` | Implemented as module-owned controller while keeping `/platform/setup/*` route names and URLs stable. Setup remains separate from Settings. |
| `Modules/Notifications/Http/Controllers/InboxController.php` | Notifications Core Module inbox. | `future module controller` | Implemented as module-owned controller while keeping current URLs and route names stable. |
| `Modules/Notifications/Http/Controllers/RealtimeAuthController.php` | Notifications/realtime infrastructure. | `future module controller` | Implemented as module-owned realtime route controller while keeping `platform.realtime.auth` stable. |
| `Platform/AuditLogController.php` | Logging Core Module audit channel. | `future module controller` | Future `Modules/Logging/Http/Controllers/...`. |
| `Platform/ErrorLogController.php` | Logging Core Module error channel for app-instance-local detailed errors. | `future module controller` | Future `Modules/Logging/Http/Controllers/...`; Registry may later consume sanitized summaries only. |
| `Platform/DocsController.php` | Docs Viewer deferred module/tool. | `retired/deferred` | Future `Modules/DocsViewer/Http/Controllers/...` only after Docs Viewer module ownership is approved. |
| `Platform/SecurityChecklistController.php` | Security Checklist deferred internal module/tool. | `retired/deferred` | Future `Modules/SecurityChecklist/Http/Controllers/...` only after evidence/tool ownership is approved. |
| `Platform/retired reference viewer controller.php` | retired reference viewer deferred tool. | `retired/deferred` | Rebuild later as a retired reference viewer module/tool; do not use it as a blocker for base Workspace planning. |
| `app/Filament/*` resources/widgets and `/console/*` proof paths | Optional internal tooling/proof surfaces. | `retired/deferred` | Not controller ownership for product Workspace modules; keep only for explicitly approved internal tooling. |

Current request object mapping:

| Current folder/file | Actual ownership direction | Status |
| --- | --- | --- |
| `Modules/Auth/Http/Requests/*` | Auth Core Module request validation. | Implemented as module-owned request validation. |
| `Requests/Platform/StorePlatformUserRequest.php` | Users/roles/permissions Core Module request validation. | Transitional namespace and class name. |
| `Requests/Platform/UpdatePlatformUserRequest.php` | Users/roles/permissions Core Module request validation. | Transitional namespace and class name. |

Controller placement rules:

- keep current non-packaged controller files in place until route, module, and view ownership conventions are approved
- do not add new shared Workspace or Core Module controllers under `App\Http\Controllers\Platform` unless required as a small transitional bridge
- future module-owned controllers use `Modules/<ModuleName>/Http/Controllers/...` only after module route loading, route aliases, tests, and package ownership are approved
- future Registry controllers should not be placed under `Platform`; the Registry naming and folder decision must be approved first
- controller class names should avoid permanent `Platform*` prefixes for shared Workspace/Core Module capabilities
- current `/platform/*` route names do not prove controller ownership; they are transitional browser routes

Follow-up concerns:

- `retired reference viewer controller` is very large and should be deferred until retired reference viewer is rebuilt as its own module/tool.
- `Modules/Settings/Http/Controllers/PageController.php` is still an aggregator; it should thin out as Logging, Users, and Docs become packaged modules with their own settings contributions.
- `Modules/Setup/Http/Controllers/ScreenController.php` is still a setup screen aggregator; it should thin out as setup screens move behind their owning module boundaries.
- `PlatformUserController`, `PlatformUserMfaController`, and related request classes need naming review when Users and roles/permissions ownership is finalized.
- controller moves should happen only after route aliases and module route ownership are planned, because moving controllers before route decisions would create churn without improving behavior.

No files move as part of this planning review.

## 4. Models

Review goal:

Decide model ownership before module/database separation work.

Questions:

- Which models are generic app/shared models?
- Which models are owned by Core Modules?
- Which models should eventually move into module package folders?
- Which models are future Registry models?
- How should current `User`, settings, notifications, audit logs, and error logs be classified?

Expected decisions:

- model placement rules
- module-owned model convention
- future Registry model convention
- transitional model classification

### Model Ownership Mapping

Status: Reviewed for current `app/Models` contents.

`app/Models` remains acceptable for the current single app database. Models should remain generic application/data models and should not encode a specific app instance, tenant, workspace, or Registry runtime assumption in their permanent class names. Future URL/domain resolution should select the active database connection below this layer; model classes should not become tenant-specific folders by themselves.

Current model mapping:

Model status vocabulary:

- `stays temporarily`: current model remains under `app/Models` until module package, route, migration, factory, seeder, and test ownership are approved.
- `future module model`: future target is a module package model under `Modules/<ModuleName>/Models/...`.
- `app-level framework/model`: model is framework glue rather than module-owned business data.
- `deferred tool model`: model belongs to an internal/deferred tool boundary and must not block base Workspace planning.
- `package/external model`: model class is supplied by an installed package, while module ownership applies to configuration, declarations, or seeded defaults around it.

| Current model/table family | Intended owner | Status | Future direction |
| --- | --- | --- | --- |
| `User` | Shared identity model across Account, Users, Roles, Auth/MFA, Notifications, Preferences, and transitional Filament access. | `stays temporarily` | Keep under `app/Models` until identity, role assignment, MFA relationships, and Filament coupling are reviewed together. |
| `UserMfaMethod` | Auth/MFA Core Module. | `future module model` | Implemented under `Modules/Auth/Models/...`; root migrations remain in place until module migration loading is planned. |
| `UserMfaPolicy` | Auth/MFA Core Module. | `future module model` | Implemented under `Modules/Auth/Models/...`; root migrations remain in place until module migration loading is planned. |
| `MfaRecoveryCode` | Auth/MFA Core Module. | `future module model` | Implemented under `Modules/Auth/Models/...`; recovery-code storage remains Auth/MFA-owned, not Account-owned. |
| `Setting` | Settings framework for app-instance/workspace-local settings. | `future module model` | Future `Modules/Settings/Models/...`; settings scope should be database/context driven, not class-name driven. |
| `UserDashboardLayout` | Dashboard/Preferences boundary. | `stays temporarily` | Future decision after Dashboard layout storage and Preferences ownership are reviewed together. |
| `Modules/Notifications/Models/Notification` | Notifications Core Module. | `future module model` | Implemented as module-owned model while keeping the Laravel-conventional `notifications` table stable. |
| `PlatformAuditLog` | Logging Core Module audit channel. | `future module model` | Future `Modules/Logging/Models/...`; audit history remains app-instance/workspace event history. |
| `CentralErrorLog` | Logging Core Module error channel/sink. | `future module model` | Future `Modules/Logging/Models/...`; raw detailed error logs remain app-instance-local by default. |
| `SecurityRequirement` | Security Checklist internal/deferred module/tool. | `deferred tool model` | Future `Modules/SecurityChecklist/Models/...` only after Security Checklist tool ownership is approved. |
| `SecurityRequirementGroup` | Security Checklist internal/deferred module/tool. | `deferred tool model` | Future `Modules/SecurityChecklist/Models/...` only after Security Checklist tool ownership is approved. |
| Spatie `Role`, `Permission`, and pivot tables | Roles Core Module package integration. | `package/external model` | Keep package models; module-owned permission declarations remain with owning modules, while role presets/defaults belong to Roles. |

Model placement rules:

- keep existing models under `app/Models` until module/database conventions are approved
- do not create app-instance-specific, tenant-specific, or workspace-specific model folders in `app/`
- future module-owned models use `Modules/<ModuleName>/Models/...` only after module package, route, migration, factory, seeder, and test ownership conventions are approved
- future Registry models should use a Registry-owned namespace/folder after Registry naming is approved
- avoid permanent `Platform*` or `Central*` model names for shared Workspace/Core Module records
- app-instance separation should be driven by resolved database connection and module schema ownership, not by copying model classes per app instance
- current table names are schema evidence, not permanent module names

Follow-up concerns:

- `User` currently mixes account identity, role/permission traits, MFA relationship helpers, and Filament access support. This is acceptable now but should be revisited when Filament is removed and roles/permissions ownership is finalized.
- `PlatformAuditLog` and `CentralErrorLog` have transitional names that reflect earlier platform-first architecture. Notification records have moved to `Modules/Notifications/Models/Notification`.
- `CentralErrorLog` should not be treated as tenant-local audit history. Audit logging owns tenant/app-instance event history, while Error Logging owns app-instance-local runtime failure details.
- Registry must not become the default raw error-log database. Future Registry visibility should use sanitized telemetry or audited support/Direct Control access into a specific app instance.
- Security checklist models belong to the deferred `SecurityChecklist` module/tool boundary, not to shared Workspace runtime or Registry by default.
- Dashboard layout and user preferences need a later Preferences/Dashboard framework decision before moving.

No files move as part of this planning review.

## 5. Routes

Review goal:

Decide route ownership and naming before moving current `/platform/*` routes.

Questions:

- What remains in `routes/web.php`?
- What belongs in `Modules/<Module>/Routes/web.php`?
- How should current `/platform/*` routes be treated while transitional?
- What is the future route name convention for Home Area, module Areas, settings, setup, account, users, roles, notifications, logs, and Registry?
- When should route aliases be added?

Expected decisions:

- route registration rules
- route naming rules
- transitional `/platform/*` rules
- module route conventions

### Route Ownership Mapping

Status: Reviewed for current route files.

`routes/web.php` is the current browser route surface for the installed app. It contains both stable app routes and transitional `/platform/*` routes. Current URI and route-name prefixes are not ownership proof.

Route status vocabulary:

- `app-level route`: app entry or framework route that is not owned by a module package.
- `stays temporarily`: route remains in its current location until adjacent ownership decisions are complete.
- `future module route`: future target is a module package route under `Modules/<ModuleName>/Routes/web.php`.
- `deferred tool route`: route belongs to a deferred internal tool/module and must not block base Workspace planning.
- `transitional alias`: compatibility redirect or alias route that does not prove future ownership.

Current route family mapping:

| Current route family | Actual ownership direction | Status | Future direction |
| --- | --- | --- |
| `/` | App entry redirect. | `app-level route` | Keep in `routes/web.php`. It redirects authenticated users to `/dashboard` and guests to `/login`. |
| `/dashboard` | Dashboard Core Module. | `future module route` | Implemented as the first module package route proof through `Modules/Dashboard/Routes/web.php`. Keep as the universal authenticated landing route. |
| `/login`, `/login/*`, `/logout` | Auth Core Module. | `future module route` | Implemented through `Modules/Auth/Routes/web.php` with route names preserved. |
| `/mfa/challenge`, `/mfa/enroll`, `/mfa/step-up` | Auth Core Module, including MFA. | `future module route` | Implemented through `Modules/Auth/Routes/web.php`; do not split MFA routes unless Auth ownership is reviewed again. |
| `/account/*` | Account, Preferences, and Auth self-service boundary. | `future module route` | Account routes are implemented through `Modules/Account/Routes/web.php`; Preferences routes are implemented through `Modules/Preferences/Routes/web.php`; Auth-owned account MFA routes are implemented through `Modules/Auth/Routes/web.php`. Route names remain transitional. |
| `/platform/roles*` | Roles Core Module role and permission assignment surface. | `future module route` | Implemented through `Modules/Roles/Routes/web.php`; current URI/name prefix is transitional. System role keys are protected, custom role CRUD is active, and permission assignment uses module-declared metadata. |
| `/platform/users/*` | Users/Roles/Auth boundary for administrator-managed user lifecycle, role assignment, and managed MFA controls. | `future module route` | URI and route-name prefix are transitional. Future split depends on Users/Roles/Auth route ownership review. |
| `/settings`, `/platform/settings/*` | Settings Core Surface Module plus hosted settings contributions. | `future module route` | Implemented through `Modules/Settings/Routes/web.php`; `/settings` is the Settings-owned landing route, `/platform/settings` is compatibility, and `/platform/settings/*` continues serving Settings-owned/general and hosted pages. Notifications settings are implemented through `Modules/Notifications/Routes/web.php`. Current `platform.*` route-name prefix is transitional. |
| `/platform/setup/*` | Setup Core Surface Module. | `future module route` | Implemented through `Modules/Setup/Routes/web.php`. Setup remains separate from Settings; current URI/name prefix is transitional. |
| `/platform/notifications/*` | Notifications Core Module. | `future module route` | Implemented through `Modules/Notifications/Routes/web.php`. Runtime navigation should come from the notification trigger, not primary navigation. |
| `/platform/realtime/auth` | Notifications/realtime authorization endpoint. | `future module route` | Implemented through `Modules/Notifications/Routes/web.php`; current route name remains transitional but stable. |
| `/platform/audit-logs/*`, `/platform/error-logs/*` | Logging Core Module with audit and error channels/sinks. | `future module route` | Audit history and detailed runtime errors stay app-instance-local by default. Future Registry visibility should use sanitized telemetry or audited app-instance support access. |
| `/platform/docs` | Deferred `DocsViewer` module/tool route. | `deferred tool route` | Not Core and not Registry-owned by default. Keep stable until Docs Viewer module ownership is approved. |
| `/platform/security/*` | Deferred `SecurityChecklist` module/tool route family. | `deferred tool route` | Not Core and not Registry-owned by default. Keep stable until Security Checklist module ownership is approved. |
| `retired reference viewer routes` | Deferred retired reference viewer tool route family. | `deferred tool route` | Defer route/render work until retired reference viewer is rebuilt as a module/tool. Stale retired reference viewer render tests must not block base Workspace planning. |
| `/platform/administration/*`, `/platform/operations/*` | Compatibility redirects to current route families. | `transitional alias` | Keep only as compatibility/navigation redirects; do not use as future ownership proof. |

Current non-web route files:

| Current route file | Current purpose | Future direction |
| --- | --- | --- |
| `routes/channels.php` | Broadcast channel authorization for user notification channels. | Notifications/realtime authorization planning; permission name is transitional. |
| `routes/console.php` | Mixed Artisan command registration for module definitions, runtime security check, local review, active-batch support, and default inspire command. | Needs later command ownership review. Current file is acceptable while command count is small. |
| `Modules/_Template/Routes/web.php` | Empty module route stub consumed by `PackageRegistrar`. | Accepted module route convention proof. |

Route rules:

- keep current visible routes stable until route aliases, tests, and navigation changes are explicitly planned
- do not move `/platform/*` routes simply to match future vocabulary
- do not treat `/platform/*` or `platform.*` route names as permanent ownership labels
- `/dashboard` is the universal default authenticated landing route for every app instance
- future module routes should live under `Modules/<ModuleName>/Routes/web.php`; Dashboard, Notifications, Settings, Preferences, and Setup are the current proofs
- route prefixes and names for future modules should come from module package metadata instead of repeated hardcoded strings
- route aliases are a later pass and must not be added during this route ownership review
- future Registry routes require a separate naming and route plan; do not put them under `/platform/*` by default
- deferred retired reference viewer routes should not block base Workspace/Core Module planning

Follow-up concerns:

- route aliases need a dedicated plan after Workspace/App Instance naming is finalized
- account routes should eventually stop using `platform.account.*` route names
- user/settings/setup/notification/log route names need vocabulary cleanup, but only after corresponding ownership decisions are complete
- console commands need ownership review if command count grows or Registry/module commands are added

No route definitions change as part of this planning review.

## 6. Views/Components

Review goal:

Review the full `resources/views` folder organization before moving Blade files, module-owned views, or rebuilding the visible frame.

Questions:

- Where do private `x-layouts.app.frame.*` Frame adapters live?
- Which current `shell` files remain compatibility aliases?
- Which views are shared UI components?
- Which views are auth-only?
- Which current `resources/views/platform/*` views are transitional?
- Which views should eventually move into `Modules/<Module>/resources/views`?
- Which folders are runtime app views versus UI primitive, pattern, or Design reference material?

Expected decisions:

- Frame component naming and placement rules
- view-folder category rules
- view ownership rules
- module view rules
- transitional platform view rules

### View And Component Ownership Mapping

Status: Reviewed for current `resources/views` layout.

The current rendered app already has a functioning authenticated layout and frame composition. Planning should evolve the existing layout/components instead of inventing a parallel rendering system.

View-folder category vocabulary:

- `app frame/layout`: shared authenticated layout and Frame composition.
- `routed app views`: Blade views rendered by current browser routes.
- `module-owned views`: future module package views under `Modules/<ModuleName>/resources/views/...`.
- `ui primitive`: Tier 1 component source, contracts, and reference files.
- `ui pattern`: Tier 2 reusable pattern source, contracts, and reference files.
- `design contract/reference`: Design-system contract/reference material, not runtime Workspace content.
- `deferred tool`: internal tool/module views that do not block base Workspace planning.
- `transitional alias`: legacy or compatibility folder/name that should not be expanded as canonical vocabulary.

Current top-level view mapping:

| Current folder | Category | Actual ownership direction | Status |
| --- | --- | --- | --- |
| `Modules/Auth/resources/views` | `module-owned views` | Guest/authentication flow views plus Auth-owned account MFA views. | Implemented as Auth package views while route names remain stable. |
| `components/layouts` | `app frame/layout` | Laravel anonymous layout components, including `x-layouts.app`. | Keep. This owns shared layout wrappers, not feature-page content. |
| `components/layouts/app` | `app frame/layout` | Private implementation tree for `x-layouts.app`, including layout assembly partials and app-frame adapters. | Keep as layout implementation detail. |
| `components/layouts/app/partials` | `app frame/layout` | Private layout assembly partials for document head, authenticated/guest body, header handoff, and header panels. | Keep private to `x-layouts.app`. |
| `components/layouts/app/frame` | `app frame/layout` | Private Frame adapters for header, sidebar, account menu, search, global actions, and app nav links. | Keep private to `x-layouts.app`; composes `x-shell.*` primitives. |
| `components/ui` | `ui primitive` | Tier 1 UI primitives plus contracts/reference files. | Keep. Do not redefine at pattern/module level. |
| `components/patterns` | `ui pattern` | Tier 2 reusable patterns plus contracts/reference files. | Keep. Pattern family cleanup continues separately. |
| `components/shell` | `transitional alias` | Lower-level frame/layout primitives and legacy/implementation alias components. | Do not expand as canonical product vocabulary; cleanup later after Frame terminology is implemented. |
| `elements` | `design contract/reference` | Design-system element contracts, reference assets, examples, and tests. | Needs later Design naming review; not runtime Workspace content and not module migration by default. |
| `platform` | `routed app views` | Transitional feature/content view buckets for current browser routes, especially `/platform/*`. | Keep until route aliases, module route loading, and module view rendering are explicitly planned. |
| `platform/retired-reference-viewer` | `deferred tool` | retired reference viewer tool views nested under the transitional platform folder. | Deferred until rebuilt as a module/tool; stale render contracts must not block base Workspace planning. |
| `livewire/platform` | `transitional alias` | Deferred legacy Livewire dashboard and widget rendering views. | Inactive after the blank Dashboard module proof. Do not extend until the widget system is rebuilt. |
| `filament` | `transitional alias` | Transitional Filament widget view. | Keep only while Filament proof surfaces remain installed. |
| `layouts` | `transitional alias` | Empty top-level folder. | No ownership decision needed unless reused later. |

Current `resources/views/platform/*` mapping:

| Current folder | Actual ownership direction | Status |
| --- | --- | --- |
| `account` | Account Core Module views. | Implemented under `Modules/Account/resources/views`; Auth-owned MFA account views live under `Modules/Auth/resources/views/account`; Preferences view moved to `Modules/Preferences/resources/views`. |
| `users` | Users and roles/permissions Core Module views. | Transitional location. |
| `settings` | Settings framework/surface views. | Migrated to `Modules/Settings/resources/views`; any remaining empty legacy directory is transitional evidence only. |
| `setup` | Setup framework/surface views. | Migrated to `Modules/Setup/resources/views`. |
| `notifications` | Notifications Core Module views. | Migrated to `Modules/Notifications/resources/views`; any remaining legacy directory is not a future owner. |
| `audit-logs` | Logging Core Module audit-channel views. | Transitional location. |
| `error-logs` | Logging Core Module error-channel views for app-instance-local detailed errors. | Transitional location. Future Registry views should not render raw cross-instance error details by default. |
| `security` | Deferred `SecurityChecklist` module/tool views. | Not Core; not Registry-owned by default. |
| `docs` | Deferred `DocsViewer` module/tool views. | Not Core; not Registry-owned by default. |
| `retired-reference-viewer` | Deferred retired reference viewer tool views. | Deferred until retired reference viewer is rebuilt as a module/tool. |

Frame vocabulary mapping:

| Concept | Current Blade owner | Status |
| --- | --- | --- |
| Workspace layout wrapper | `x-layouts.app` | Keep. |
| Header | `x-layouts.app.frame.header` composed through `components/layouts/app/frame/header/*` | Keep private to `x-layouts.app`. |
| Area Navigation | current header/navigation composition | Needs later navigation data review. |
| Global Actions | `components/layouts/app/frame/header/actions.blade.php` and related panel files | Keep as the Frame render region; Settings, Notifications, and Account contribute their actions through module metadata, while search remains Frame-owned. |
| Sidebar | `x-layouts.app.frame.sidebar` | Keep private to `x-layouts.app`. |
| Side Navigation | `x-layouts.app.frame.nav-link` plus lower-level `x-shell.side-nav.*` primitives | Keep; `shell` naming remains alias-level. |
| Main | `x-shell.content` is current implementation | Transitional name; product vocabulary should use Main. |

View/component placement rules:

- do not create a second authenticated layout/frame
- keep `x-layouts.app` as the shared Laravel layout component
- keep authenticated `x-layouts.app` pages grid-enabled by default; guest auth screens opt out explicitly until guest layout review
- route page titles, subtitles, page actions, route-style page tabs, and reserved tab rail space through `x-layouts.app` / `x-shell.page-header`
- keep `x-layouts.app.frame.*` as the private production Frame adapter layer
- reserve `Frame` as canonical planning vocabulary and `Shell` as a legacy/implementation alias
- do not add feature-specific markup to layout partials
- do not put retired reference viewer-only content into `components/layouts/app/frame`
- avoid `x-patterns.page-title-actions-row`, standalone `x-shell.page-title`, or ad hoc `ui-page-header-*` markup for normal routed app page headers
- direct page-body children should be `x-ui.grid-column` when the authenticated layout grid is active
- module-owned views should eventually live under `Modules/<ModuleName>/resources/views/...` after module view routing and test conventions are approved
- do not move `resources/views/platform/*` until route aliases, module ownership, and tests are planned together
- `resources/views/platform/*` is transitional routed-view storage, not future ownership
- UI primitives and patterns stay under `resources/views/components/ui` and `resources/views/components/patterns`
- Design contracts/reference assets need a later Design naming review and should not be migrated as module runtime views by default

Follow-up concerns:

- `components/shell` needs a later naming/migration decision after Frame terminology is fully approved in implementation.
- `resources/views/platform/*` remains the major transitional content bucket for non-packaged areas.
- `resources/views/livewire/platform` should be renamed or moved only after Livewire/component ownership conventions are approved.
- retired reference viewer views and element/reference assets should stay deferred until retired reference viewer is rebuilt as a module/tool.
- additional physical view moves are deferred until route aliases, module route loading, and module view rendering are approved for the owning module.

Settings, Preferences, and Setup Blade files moved during the package proof; remaining view moves require their own approved package/rebuild plan. Account, Preferences, Settings, Setup, Notifications, and Roles active module views now use the layout-owned page header/grid path. Dashboard remains the reference module-owned blank main page. retired reference viewer and deferred platform tool views remain out of scope.

## 7. Database

Review goal:

Decide migration/schema ownership before Registry or module database work.

Questions:

- Which tables belong to core modules?
- Which tables belong to optional modules?
- Which tables are shared app/runtime infrastructure?
- Which tables are future Registry-owned?
- How should app-instance database ownership be expressed before multi-database switching exists?

Expected decisions:

- core module migration rules
- optional module migration rules
- database ownership status rules
- Registry schema deferment rules
- app-instance database ownership language

### Database Ownership Mapping

Status: Reviewed for current migrations, seeders, and factories.

The current `database/` folder describes the schema for one app-instance database. Future URL/domain resolution should select which app-instance database connection is active. It should not duplicate model classes or copy schema files per app instance.

Database ownership status vocabulary:

- `app-level framework schema`: Laravel/runtime infrastructure schema that is not module-owned.
- `stays temporarily`: schema remains in root migrations until adjacent ownership decisions are complete.
- `future module schema`: future target is module-owned schema under `Modules/<ModuleName>/Database/Migrations`.
- `deferred tool schema`: schema belongs to an internal/deferred tool boundary and must not block base Workspace planning.
- `package/external schema`: schema shape is controlled by an installed package, while module ownership applies to configuration, declarations, or seeded defaults.
- `transitional schema name`: current table name reflects earlier architecture vocabulary and must not drive permanent module naming.

Current schema ownership mapping:

| Current table/group | Actual ownership direction | Status | Future direction |
| --- | --- | --- | --- |
| `users` | Shared identity/user lifecycle schema across Account, Users, Roles, Auth, Notifications, Preferences, and transitional Filament access. | `stays temporarily` | Keep in current app-instance schema until identity and role assignment ownership are reviewed together. |
| Auth fields on `users`, `password_reset_tokens` | Auth Core Module schema. | `future module schema` | Future target is Auth-owned migrations; current root migrations stay in place until module migration loading is approved. |
| `sessions` | Laravel session infrastructure used by Auth/runtime. | `app-level framework schema` | Keep as framework schema unless session storage topology changes. |
| `user_mfa_methods`, `user_mfa_policies`, `mfa_recovery_codes` | Auth Core Module schema, including MFA. | `future module schema` | Future target is `Modules/Auth/Database/Migrations`; do not split MFA schema unless Auth ownership is reviewed again. |
| `permissions`, `roles`, `model_has_permissions`, `model_has_roles`, `role_has_permissions` | Roles Core Module package integration through Spatie. | `package/external schema` | Keep package schema; module-owned permission declarations remain with modules, while role presets/defaults belong to Roles. |
| `settings` | Settings Core Surface Module schema. | `future module schema` | Future target is `Modules/Settings/Database/Migrations`; scope should be resolved database/context driven. |
| `notifications` | Notifications Core Module schema. | `future module schema` | Future target is `Modules/Notifications/Database/Migrations`; records stay app-instance-local. |
| `platform_audit_logs` | Logging Core Module audit channel. | `transitional schema name` | Future target is Logging-owned schema. Current table name is not a module name. Audit history remains app-instance-local by default. |
| `central_error_logs` | Logging Core Module error channel/sink for app-instance-local detailed errors. | `transitional schema name` | Future target is Logging-owned schema. Current table name is not a Registry ownership claim; raw detailed errors stay app-instance-local by default. |
| `user_dashboard_layouts` | Dashboard/Preferences boundary schema. | `stays temporarily` | Future decision after Dashboard layout storage and Preferences ownership are reviewed together. |
| Preference/profile columns on `users` | Account, Users, and Preferences boundary schema. | `stays temporarily` | Keep with `users` until Preferences storage ownership is reviewed. |
| `security_requirement_groups`, `security_requirements` | Deferred `SecurityChecklist` module/tool schema. | `deferred tool schema` | Future target is `Modules/SecurityChecklist/Database/Migrations` only after tool ownership is approved. |
| `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs` | Laravel runtime infrastructure. | `app-level framework schema` | Keep as infrastructure schema unless deployment topology changes. |

Current seeder/factory mapping:

| Current file | Actual ownership direction | Status |
| --- | --- | --- |
| `DatabaseSeeder.php` | Local/default app-instance bootstrap. | Keep. |
| `PlatformRolesAndPermissionsSeeder.php` | Compatibility wrapper for Roles Core Module seed data. | Calls `Modules/Roles/Database/Seeders/Defaults.php`; keep until current app and tests stop depending on the legacy seeder name. |
| `SecurityRequirementSeeder.php` | Deferred `SecurityChecklist` module/tool seed data. | Not Core; not Registry-owned by default. |
| `UserFactory.php` | App-instance user test factory. | Keep until identity/user factory ownership is reviewed. |

Database rules:

- current migrations remain in `database/migrations` until module migration loading is approved
- future app instances should receive the same app schema through database connection/provisioning, not per-instance file copies
- do not add Registry schema to the app-instance database without a Registry database plan
- future module migrations should target `Modules/<ModuleName>/Database/Migrations` after module install/lifecycle behavior is approved
- core module migrations may remain in root migrations until there is a real benefit to relocating them
- table names with `platform_` or `central_` are transitional schema names and must not drive permanent module naming
- raw audit/error data remains app-instance-local by default
- Registry schema is separate future work and is not the default owner for raw app-instance audit/error data

Follow-up concerns:

- determine whether roles and permissions split into separate module/schema ownership or remain one Core Module family
- define app-instance provisioning rules before introducing a second database
- define Registry database ownership separately from app-instance schema
- define module migration execution before moving migrations into module folders

No schema files change as part of this planning review.

## 8. Tests

Review goal:

Decide test ownership before rewriting or moving more tests.

Questions:

- Which tests remain app-level feature/integration tests?
- Which tests should be module-local later?
- How should route/authorization matrix tests avoid unrelated heavy surfaces?
- How should deferred retired reference viewer tests be handled?
- What naming conventions should test files use?

Expected decisions:

- app-level test placement rules
- module test placement rules
- test ownership status rules
- deferred/stale test rules
- naming and command conventions

### Test Ownership Mapping

Status: Reviewed for current test layout.

The current test suite is app-level, with feature tests grouped by broad capability and a small browser smoke-test folder. Tests should continue to prove behavior and contracts, not implementation details or stale render paths.

Test ownership status vocabulary:

- `app-level integration test`: cross-feature or app-runtime behavior test that stays under root `tests/`.
- `future module test`: future target is a module-local test under `Modules/<ModuleName>/tests/...`.
- `design/component contract test`: UI primitive, pattern, Design contract, or component API evidence test.
- `deferred tool test`: test belongs to a deferred internal tool/module and must not block base Workspace planning.
- `transitional grouping`: current grouping exists for platform-era convenience and should split only when matching source ownership moves.

Current test folder mapping:

| Current folder | Actual ownership direction | Status | Future direction |
| --- | --- | --- | --- |
| `tests/Feature/Auth` | Auth Core Module behavior, including MFA. | `future module test` | Future target is `Modules/Auth/tests/...` after Auth source ownership moves. |
| `tests/Feature/Core/Runtime` | App-level runtime/context proof tests. | `app-level integration test` | Keep while Runtime remains the approved generic context proof location. |
| `tests/Feature/Logging` | Logging Core Module behavior across audit, error, and request logging. | `future module test` | Future target is `Modules/Logging/tests/...` after Logging source ownership moves. |
| `tests/Feature/Patterns` | Tier 2 pattern behavior and public API tests. | `design/component contract test` | Keep with Design/UI contract testing until pattern source ownership changes. |
| `tests/Feature/Platform` | Broad platform-era feature tests for account, users, settings, notifications, dashboard, security, modules, route authorization, and runtime security. | `transitional grouping` | Split only after matching code, routes, views, and module ownership are implemented. |
| `retired reference viewer tests` | retired reference viewer access, render, catalog, and governance tests. | `deferred tool test` | Defer alongside future rendered-evidence strategy; these tests must not block base Workspace/Core Module work. |
| `design/component contract tests` | Design/retired reference viewer support and file-shape tests. | `design/component contract test` | Future owner depends on Design contract and future rendered-evidence strategy decisions. |
| `tests/Unit` | Mixed unit coverage for helpers, logs, app frame structure, active-batch support, and retired reference viewer repositories. | `transitional grouping` | Relocate only after owners are approved; do not force a split before source ownership moves. |
| `tests/Browser` | Browser smoke coverage. | `app-level integration test` | Keep focused and minimal. |

Test placement rules:

- keep current app-level tests under `tests/Feature` and `tests/Unit` until module-local test conventions are approved
- future module-local tests should target `Modules/<ModuleName>/tests/...` only after module package testing conventions are approved
- do not update tests to match broken behavior
- do not use broad CSS/snapshot assertions as security or architecture evidence
- do not make the route authorization matrix render unrelated heavy/deferred surfaces
- retired reference viewer route/render/Definitions tests are deferred with future rendered-evidence strategy and must not drive core Workspace work
- route/security tests should assert security-relevant behavior, redirects, side effects, and authorization boundaries
- pattern/component tests should assert stable public API and semantics, not incidental markup where a behavior contract is clearer

Command convention:

- Docker test commands shared for PowerShell should be one-line commands.
- Avoid multiline Docker command blocks that rely on shell continuation behavior.
- When multiple suites are needed, either combine test paths into one `php artisan test` call or provide separate single-line commands.

Follow-up concerns:

- split `tests/Feature/Platform` only after the matching code/routes/views are split
- keep retired reference viewer tests out of the critical path until retired reference viewer is rebuilt as a module/tool
- review `tests/Unit` retired reference viewer and support-tool tests when `Design`, retired reference viewer, and developer-tool ownership is implemented

No test files move as part of this planning review.

## Immediate Next Step

The 1-8 baseline review structure is complete. The first scoped reorganization implementation pass was the Dashboard module package proof. Notifications is now the second stable module package proof and the first full Header Global Action self-containment proof.

Current implemented proof:

1. `Modules/Dashboard` owns the `/dashboard` route, controller, blank main view, package metadata, and module view path.
2. Dashboard default page copy is loaded from `Modules/Dashboard/resources/lang/en/dashboard.php` through module translation registration.
3. Existing Dashboard widget/grid/customization behavior is intentionally inactive and deferred for a from-scratch rebuild.
4. `Modules/Notifications` owns canonical `/notifications` routes, compatibility `/platform/notifications*` routes, controllers, service behavior, events, model, inbox view, header action view, unread badge, dropdown panel data, and realtime boot data.
5. `PackageLoader` is the runtime package loading path for static package definitions, loading Core packages first in dependency order and then enabled default-installed non-Core packages.
6. Header Area Navigation now renders Dashboard and Setup area entries from module `UiEntry` metadata instead of `config/navigation.php`; the Dashboard sidebar shows only the Dashboard title and Dashboard main link, and the Setup sidebar plus landing page render discovered `SetupNavigation` metadata.
7. `Modules/Settings` owns the Settings package routes, `/settings` landing page, Settings header global action target, page controller, settings store, sidebar builder, settings views, module language defaults, and module view path while keeping `/platform/settings*` compatibility stable. Notifications owns its own settings defaults page inside `Modules/Notifications`.
8. `Modules/Preferences` owns `/account/preferences`, the personal defaults controller, preference navigation builder, module view, and module language defaults while keeping `platform.account.preferences*` names stable.
9. `Modules/Setup` owns `/platform/setup`, the setup screen controller, setup navigation builder, setup landing view, `setup.view` aggregate ability, and module language defaults while keeping setup separate from Settings. `view-platform-setup` remains a compatibility delegate. `Modules/Notifications` now contributes its own setup page through `SetupNavigation`; stale docs, audit-log, error-log, and Staff Setup pages are no longer registered.
10. `Modules/Auth` owns login/logout, MFA challenge/enrollment/step-up, account MFA, password policy services, MFA models, Auth route files, Auth views, and module language defaults while preserving route names.
11. `Modules/Account` owns `/account`, account profile/contact update actions, `/account/settings` compatibility redirect behavior, the account controller, account views, account menu metadata, the Account header global action view, account menu data preparation, and module language defaults while calling Auth-owned password/MFA services.

Language and instance-setting note:

- Module defaults live with code under `Modules/<ModuleName>/resources/lang/*`.
- New copied modules start with `Modules/<ModuleName>/resources/lang/en/module.php` for package-level title and description strings.
- Domain-specific language files such as `dashboard.php`, `settings.php`, or `reports.php` are valid when a module needs more detailed language groups.
- Tenant or app-instance values such as display name, default locale, timezone, and future title overrides belong in database-backed settings after instance resolution is implemented.
- Settings > Localization should control locale/timezone and selected instance overrides later; it should not become a manual editor for every translation string.

Recommended next planning candidates:

1. plan Sidebar Navigation and Area Sidebar Replacement contribution contracts from `doc-review-2026-07-06-frame-contribution-readiness`
2. plan the Dashboard widget rebuild only after Dashboard contribution/storage contracts are reviewed
3. continue packaging remaining approved Core Modules such as Users and Logging only after each boundary is reviewed
4. define the `Design` contract namespace migration plan for `app/Surfaces`
5. defer retired reference viewer route/render cleanup until retired reference viewer is rebuilt as a module/tool

## Out Of Scope

- implementing file moves
- route migration
- module migration
- Registry implementation
- tenant database switching
- future rendered-evidence strategy
- updating `/docs/08-active/`

## Related

- [Registry, App Instance, Workspace, And Module Vocabulary Planning](registry-instance-workspace-module-vocabulary-planning.md)
- [Module Layout Convention Implementation Planning](module-layout-convention-implementation-planning.md)
- [Platform Context Route Reorganization Planning](platform-context-route-reorganization-planning.md)
