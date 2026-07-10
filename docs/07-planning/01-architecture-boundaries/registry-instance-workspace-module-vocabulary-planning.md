# Registry, App Instance, Workspace, And Module Vocabulary Planning

Status: Planning

## Purpose

Capture the working vocabulary decisions made while resetting the app structure discussion.

This planning note is not a final architecture contract. It records current terminology and sequencing intent so implementation does not continue mixing `platform`, `workspace`, `tenant`, `module`, and `control plane` language.

## Approved Root Rule

`app/` contains generic Laravel application runtime and shared application services.

`app/` must not use permanent folder names that are Parasolutions-specific, tenant-specific, workspace-specific, or control-plane-specific.

Specific business capability files should eventually belong to one of these places:

- shared app/core runtime when the code is framework-like or cross-cutting
- module package roots under `Modules/`
- database-held configuration and state
- canonical docs in the correct owner branch

## Approved Working Vocabulary

### Registry

`Registry` is the future central management system above app instances.

Registry is where Parasolutions will eventually connect or interface to:

- create app instances
- update app instances
- disable or suspend app instances
- map domains and URLs
- manage database connection targets or secret references
- view global audit logs
- view global error logs
- view global usage and statistics
- manage provisioning state
- manage global module availability
- manage support access policies

Registry is not implemented yet.

### App Instance

`App Instance` is one deployed/customer/local app environment.

An app instance owns or resolves:

- its app database
- accounts/users
- local settings
- enabled module state
- MFA state
- notifications
- business records
- local audit and error logs when scoped locally

Working communication labels:

- `Home App Instance` means the Parasolutions-owned app instance.
- `Client App Instance` means a customer-owned app instance.

The Home App Instance is special operationally because it belongs to Parasolutions. It should not be special in the base loading model unless a later Registry or internal-module decision makes it so.

### Workspace

`Workspace` is the user-facing assembled app experience inside an app instance.

The workspace is where users work after login. It includes rendered surfaces such as:

- dashboard
- account pages
- settings views
- setup views
- notifications
- future customers, projects, tasks, tracking, and related business pages

Workspace is not the database boundary. The app instance is the boundary.

A workspace is assembled from enabled modules and filtered by account permissions, account settings, preferences, app-instance settings, and module state.

### Frame And Shell

`Frame` is the approved canonical term for the persistent logged-in GUI structure inside a Workspace.

`Shell` is a reserved alias for existing implementation/code references only. New planning language should use `Frame` unless referring to current files, CSS hooks, data attributes, or legacy implementation names that already use `shell`.

Alias status:

| Term | Status | Usage |
| --- | --- | --- |
| `Frame` | Canonical | Use for the Workspace's persistent logged-in GUI structure. |
| `Shell` | Reserved implementation alias | Use only when referring to existing implementation names or migration compatibility. Do not use as the preferred product/planning term. |

Both terms are reserved. Do not reuse `Frame` or `Shell` for modules, app instances, Registry concepts, workspace surfaces, or ordinary content views.

Blade implementation may use conventional Laravel component names rather than the conceptual term. The approved mapping is:

| Concept | Blade implementation name |
| --- | --- |
| Frame | `<x-layouts.app>` |
| Header | `<x-layouts.app.frame.header>` |
| Sidebar | `<x-layouts.app.frame.sidebar>` |
| Main | `<x-shell.content>` currently; `Main` remains the product vocabulary. |

`x-layouts.app.frame.*` components are private adapters for the logged-in Workspace UI. They do not mean Registry, tenant, or the whole codebase.

### Workspace Frame Structure

The approved Workspace Frame structure is:

```text
Workspace
  Frame
    Header
      Menu Toggle
      Product Link
      Area Navigation
        Home
        Area entries
      Global Actions
        Search
        Settings Trigger
        Notification Trigger
          Notification Panel
        Account Panel
          Theme Switcher
          Account Module Triggers
          Sign Out Action

    Sidebar
      Area Title
      Side Navigation
        Navigation List
          Navigation Item
            Navigation Link
          Navigation Divider
          Navigation Group
            Group Trigger
            Group Panel
              Group Item
                Group Link

    Main
      Header
      Tabs
      Body
```

Current private layout-frame implementation names:

```text
Frame
  <x-layouts.app>

  Header
    <x-layouts.app.frame.header>

    Menu Toggle
      composed through x-shell.header.menu-button

    Product Link
      composed through x-shell.header.name

    Area Navigation
      composed through x-shell.header.navigation

      Home
        composed through x-shell.header.menu-item

      Area entries
        composed through x-shell.header.menu-item

    Global Actions
      <x-layouts.app.frame.header.actions>

      Search
        <x-layouts.app.frame.header.search>

      Settings Trigger
        module-owned header global action contribution

      Notification Trigger
        module-owned header global action contribution

        Notification Panel
          module-owned header global action view

      Account Panel
        <x-layouts.app.frame.header.account-menu>

        Theme Switcher
          rendered inside account menu

        Account Module Triggers
          rendered inside account menu

        Sign Out Action
          rendered inside account menu

  Sidebar
    <x-layouts.app.frame.sidebar>

    Area Title
      composed through x-shell.side-nav.header

    Side Navigation
      composed through x-shell.side-nav.items

      Navigation List
        composed through x-shell.side-nav.items

        Navigation Item
          <x-layouts.app.frame.nav-link>

          Navigation Link
            composed through x-shell.side-nav.link

        Navigation Divider
          <x-shell.side-nav.divider>

        Navigation Group
          <x-shell.side-nav.menu>

          Group Trigger
            composed through x-shell.side-nav.menu

          Group Panel
            composed through x-shell.side-nav.menu

            Group Item
              <x-shell.side-nav.menu-item>

              Group Link
                <x-shell.side-nav.menu-item>

  Main
    <x-shell.content>

    Header
      composed through x-shell.page-header

    Tabs
      composed through x-shell.page-tabs

    Body
      x-shell.content default slot
```

This is terminology and implementation naming guidance only. It does not require creating these Blade components in this pass.

### Area

`Area` is a top-level Workspace destination selected from Area Navigation.

An Area may provide:

- an Area Navigation entry
- an overview/home view
- Sidebar Area Title
- Side Navigation contents
- Main views

`Home` is the default authenticated Area. Its current implementation may render a dashboard-style overview, but `dashboard` is a view type and current route name, not the canonical Area name.

### Workspace Layout And Area Infrastructure

Workspace Layout and Area Infrastructure is not a module.

It owns the persistent rendered shape and assembly rules for an authenticated Workspace:

- Frame
- Header
- Area Navigation
- Global Actions
- Sidebar
- Main
- Area registry/resolution
- navigation aggregation and current-state resolution
- account panel/global action placement

This layer may consume module contributions, but it is not installed, enabled, disabled, or provisioned as a module. It is closer to Laravel layout/component architecture and currently maps to `x-layouts.app`, private `x-layouts.app.frame.*` adapters, and existing reusable `x-shell.*` primitives.

Area/navigation contribution contracts may later live in generic runtime/layout infrastructure or a narrowly named service, but they should not be forced into `Modules/Navigation` unless a later implementation decision proves module packaging is useful.

### Core Surface Modules

Core Surface Modules are required modules that provide shared Workspace surfaces. They are installed by default, enabled by default, and cannot be disabled or uninstalled.

They differ from Core Capability Modules because they primarily collect and render contributions from other modules instead of owning all of the underlying business behavior.

Agreed Core Surface Modules:

- `Dashboard` renders widgets contributed by modules.
- `Settings` renders settings contributed by modules.
- `Setup` renders setup steps and setup screens contributed by modules.
- `Preferences` renders account-specific preference contributions from modules.

Core Surface Modules may own routes, controllers, views, storage, registries, contribution contracts, tests, and docs for their respective surfaces.

Core Surface Modules must not claim ownership over every contribution they render. Contributing modules own their own settings, setup steps, preferences, widgets, navigation entries, permissions, and behavior.

Examples:

- `Modules/Settings` owns the Settings surface, settings registry, settings page aggregation, and settings storage framework.
- `Modules/Notifications` contributes notification default settings.
- `Modules/Auth` may later contribute authentication/security settings.
- `Modules/Dashboard` owns widget layout/registration surfaces.
- `Modules/Notifications` may contribute notification widgets.
- `Modules/Preferences` owns the Preferences surface and contribution contract.
- `Modules/Account` contributes account/user preference entries.

### Module

`Module` is a packaged capability that contributes functionality into a workspace or future Registry interface.

A module may contribute:

- routes
- controllers
- views
- settings pages
- setup pages
- permissions
- widgets
- navigation entries
- database tables
- seeders
- background jobs
- tests
- module-local docs

Core features should be treated as `Core Modules`: modules that are installed by default, enabled by default, and cannot be disabled or uninstalled.

Optional features should be treated as installable modules only after the module lifecycle path is designed.

### Core Modules

Core modules split into two groups:

- Core Capability Modules
- Core Surface Modules

Agreed Core Capability Modules:

- `Auth`
- `Account`
- `Users`
- `Roles`
- `Notifications`
- `Logging`

Agreed Core Surface Modules:

- `Dashboard`
- `Settings`
- `Setup`
- `Preferences`

Core modules are modules. The difference is lifecycle policy: they are installed by default, enabled by default, and cannot be disabled or uninstalled.

Core modules should use the same self-contained package layout as optional modules. The target package roots are:

```text
Modules/Auth
Modules/Account
Modules/Users
Modules/Roles
Modules/Notifications
Modules/Logging
Modules/Dashboard
Modules/Settings
Modules/Setup
Modules/Preferences
```

The folder shape is the same for core and optional modules. Core status is expressed through module lifecycle metadata, not through a separate filesystem location.

`app/Core` is not the home for Core Modules. `app/Core` is reserved for lower-level application engines, runtime primitives, and shared framework services that are not themselves capabilities.

Use this boundary:

- if the code owns or contributes routes, controllers, views, tables, permissions, settings, setup steps, events, jobs, tests, or user-visible capability, it belongs to a module package under `Modules/<ModuleName>`
- if the code is a primitive engine used by multiple modules and is not independently installed, configured, or exposed as a capability, it may belong under `app/Core`

Examples:

- `Modules/Auth` owns authentication capability
- `Modules/Notifications` owns notification capability
- `Modules/Logging` owns app-instance logging capability, including audit logs, error logs, security events, and runtime telemetry channels
- `app/Core/Modules` owns the generic module manifest/registry/package engine
- `app/Core/Runtime` owns narrow runtime/context primitives until instance resolution is designed

#### Auth

`Auth` owns authentication:

- login
- password authentication
- sessions
- MFA/TOTP
- recovery codes
- step-up
- auth throttling

MFA is part of Auth for now, not a separate core module.

#### Account

`Account` owns current-account self-service:

- my account
- profile/basic identity
- password change
- email change
- own MFA enrollment/reset where allowed
- own recovery codes
- own sessions later
- account menu self-service entries
- account-owned contributions into Preferences

`Account` does not own administrator user management, role assignment, permission management, login/session/MFA engines, or the Preferences surface/framework itself.

Account may render self-service MFA and recovery-code screens, but Auth owns the MFA engine, assurance, enrollment verification, recovery-code storage, step-up, rate limiting, and audit events.

Account may contribute preference fields or links, but Preferences is a Workspace surface/framework that can consume contributions from multiple modules.

#### Users

`Users` owns user/account administration:

- user list
- create/edit users
- activate/deactivate users
- delete users later if allowed
- admin MFA reset
- assigning/removing roles from a user by calling the Roles module boundary
- administrator-managed profile fields

#### Roles

`Roles` owns app-instance role and permission grouping:

- role list
- create/edit roles
- assigning permissions to roles
- role guardrails
- role templates and default role settings
- elevated-role assignment rules
- Spatie role/permission package integration

Canonical default role keys:

- `super_admin` -> Super Admin
- `admin` -> Admin
- `manager` -> Manager
- `user` -> User
- `default` -> Default

No `guest` role exists in this default set. Unauthenticated guests remain outside RBAC.

`Roles` does not own every permission declaration. Permissions are declared by the modules that introduce the relevant capabilities.

Current implementation note: module manifests now support structured permission definitions with stable permission keys, labels, descriptions, grouping metadata, elevated flags, destructive flags, action metadata, and default role preset intent. `Modules/Roles` now provides the first Roles & Permissions CRUD surface for protected system roles and custom roles. Roles-owned permissions have moved to canonical `roles.*` keys; legacy `platform.roles.view` and `platform.roles.manage` are migration inputs only.

Examples:

- `Users` declares user-management permissions.
- `Auth` declares authentication/security administration permissions when needed.
- Future `Projects` declares project permissions.
- Future `Tasks` declares task permissions.

`Roles` owns the system that groups those permissions into app-instance roles.

`Users` may assign roles to users through the Roles module boundary, but the role model, permission grouping, elevated-role guardrails, role presets, and default-role behavior are Roles ownership.

#### Notifications

`Notifications` owns notification runtime:

- notification records
- read/dismiss state
- delivery preferences
- notification inbox and bell behavior
- notification settings/default contributions

Notifications may contribute to Dashboard, Preferences, Settings, Setup, Navigation, Header / Global Actions, and Account Menu surfaces.

#### Logging

`Logging` owns app-instance logging framework behavior.

Logging writes to typed channels and sinks, not one combined log table.

Initial logging channels include:

- audit logs
- error logs
- security events
- runtime telemetry

Audit logs record tenant/app-instance-specific user, system, and security-relevant events such as sign-ins, MFA events, settings changes, user changes, permission changes, module changes, and business-record updates.

Error logs record operational failures such as exceptions, failed jobs, framework errors, runtime faults, integration failures, and infrastructure-facing failure context.

Detailed audit and error records belong inside the app instance database because they are part of the local history and may expose app-instance-specific or sensitive context.

Current tables remain transitional implementation details:

- `platform_audit_logs`
- `central_error_logs`

Registry-level audit and error visibility is future Registry work and should not be conflated with local logging ownership. Registry may later aggregate, search, or directly inspect app-instance logging history through explicit support/control workflows.

#### Registry Error Telemetry

Registry may later receive sanitized error telemetry for operational visibility. Registry telemetry may include safe fields such as app instance key, severity, error fingerprint, occurrence count, first/last seen timestamps, release/version, request ID, job name, status, and a safe error class.

Registry must not become the default raw error-log database for every app instance. Raw details may be inspected only through explicit audited support or Direct Control workflows that resolve the target app instance, enforce permissions, and apply MFA step-up where appropriate.

Current local `central_error_logs` behavior is transitional naming. Until Registry telemetry and support access are designed, it should be treated as app-instance-local detailed error storage, not as proof that all tenant/app-instance errors should be centralized.

### Deferred/Internal Modules

Deferred/Internal Modules are not Core Modules and should not be forced into Registry ownership by default.

They may be installed first into the Home App Instance for Parasolutions use. Later tenant eligibility should be decided per module.

Current deferred/internal module candidates:

- `DocsViewer`
- `SecurityChecklist`
- `retired reference viewer`

#### DocsViewer

`DocsViewer` owns the documentation navigation and Markdown viewing experience.

It should be treated as an optional/internal module candidate, not a Core Module and not Registry-owned by default.

Current implementation maps to the existing docs vault/viewer behavior. The module may later be tenant-eligible if an app instance needs its own internal documentation viewer.

#### SecurityChecklist

`SecurityChecklist` owns the security/readiness checklist UI, Definitions, evidence links, and status tracking.

It should be treated as a deferred/internal module candidate for now. It may become Registry-facing later, but that should be a separate decision after Registry boundaries, support access, and evidence aggregation are designed.

#### retired reference viewer

`retired reference viewer` owns the design-system reference viewer experience.

It is deferred until rebuilt through the module-template path and approved reference page design. It should not block base Workspace or Core Module work.

### Runtime Readiness

Runtime Readiness is a split responsibility.

The active runtime checker should run inside the resolved App Instance. It may inspect local runtime config, response headers, session posture, trusted proxy posture, HSTS posture, database transport posture, and optional deployed URL probes for that App Instance.

Registry must not become the default owner of raw runtime configuration or raw probe output. Future Registry visibility should consume sanitized summarized evidence only.

Allowed future Registry evidence:

- App Instance identity
- check name
- status
- timestamp
- target environment
- non-secret summary message
- non-secret evidence link or run identifier

Disallowed Registry evidence:

- raw environment values
- connection strings
- cookie values
- secrets or secret references
- raw response bodies
- full probe payloads
- detailed local error traces

Current `platform:security-runtime-check` behavior should be treated as app-instance-local runtime posture evidence. A future Registry operations view may aggregate summarized readiness status, but that is a separate implementation decision.

### Filament And Console Proof Paths

Filament is optional internal tooling. Console proof paths are transitional and should not be treated as product route ownership or product behavior evidence.

Current direction:

- Do not expand Filament into product Workspace UI.
- Do not use Filament for new Core Module, Workspace, Frame, Registry, notification, settings, DocsViewer, SecurityChecklist, or retired reference viewer product work.
- Do not treat `/console/*` proof paths as future route ownership.
- Keep the default proof-path posture disabled while proof paths remain installed.
- Keep Filament only when it has explicit internal-tooling, migration, inspection, or prototype value.
- Remove or narrow proof-route tests after app-owned or module-owned tests prove the actual product behavior.

Filament is not required for real-time notifications. Notification delivery and rendering belong to the Notifications Core Module and the approved Workspace Frame/global-action surfaces.

Concrete role-boundary and proof-path cleanup sequencing is tracked in [Filament Role Boundary And Console Proof Path Planning](filament-console-proof-retirement-planning.md).

### Permission Model

Permissions are module-owned capability declarations.

Each module declares the permissions it introduces.

Permission declarations should include readable labels, descriptions, owning group/module metadata, elevated/sensitive flags where needed, and default role preset intent. Roles consumes that metadata to group permissions and seed app-instance role presets; it does not own every permission value.

Current implementation note: route-matrix permissions, Gate-backed UI entry abilities, module owners, default role metadata, and the Roles write UI now have focused evidence. The Roles UI builds from structured permission metadata rather than raw permission strings.

Examples:

- `Users` declares permissions such as `users.view`, `users.create`, and `users.update`.
- Future `Projects` declares permissions such as `projects.view`, `projects.create`, and `projects.update`.
- Modules that contribute settings declare their own settings-related permissions.

Roles are app-instance-owned groupings of permissions.

Users receive roles.

Authorization checks permissions.

This keeps permission declarations DRY. Modules carry permission values, while each app instance decides which roles exist and which permissions those roles contain.

## Loading Model Direction

The intended future loading model is:

1. Resolve the request URL or domain.
2. Determine the app instance and database to use.
3. Authenticate against that app instance database.
4. Load the account, account type, permissions, settings, and preferences.
5. Load core modules.
6. Load enabled optional modules.
7. Assemble workspace surfaces from module contributions.
8. Render dashboard, navigation, settings, setup, widgets, and content filtered by permissions, settings, and preferences.

This is future direction. The current app still uses one configured database and one Home App Instance.

## Current Implementation State

Current implementation state:

- The app has one working app database.
- The current app should be treated as the Home App Instance.
- `dashboard` is the fixed default landing route for every app instance.
- `app/Core/Runtime` is a narrow generic runtime proof, not tenant switching.
- There is no Registry implementation.
- There is no domain-based database switching.
- There is no tenant registry.
- There is no app-instance schema.
- Current `/platform/*` routes remain transitional.
- retired reference viewer is deferred until rebuilt through the module-template path and reference page design.

## Naming Guardrails

Do not use these as permanent folder or class names without a separate decision:

- `control_plane`
- `tenant_workspace`
- `internal_workspace`
- `internal_workspace_core`
- `platform` as a generic app boundary

Use these as communication terms for now:

- Registry
- App Instance
- Home App Instance
- Client App Instance
- Workspace
- Frame
- Shell
- Area
- Module
- Core Module
- Workspace Surface
- Workspace Framework

## Next Decisions

Decision 1: Should Registry have its own dedicated interface later, or should the Home App Instance expose Registry management modules to authorized Parasolutions users?

Decision 2: Which current `/platform/*` surfaces are Home App Instance workspace surfaces, and which are future Registry/internal management surfaces?

Decision 3: What current route/view/controller folder names should remain transitional until aliases are defined?

Decision 4: What is the minimum base Home App Instance surface that must work before Registry planning continues?

Decision 5: When a second app database is actually needed, what is the smallest database-held Registry schema required for URL-to-database resolution?

Decision 6: Which current `/platform/*` files map to agreed core modules, and which map to workspace surfaces/frameworks?

Decision 7: Which existing `shell` implementation files and hooks should remain as reusable shell primitives, and which should eventually migrate to approved Frame terminology or private `x-layouts.app.frame.*` adapters?

## Out Of Scope

- implementing Registry
- adding app-instance tables
- adding tenant database switching
- route migration
- future rendered-evidence strategy
- control-plane naming
- module install UI
- changing dashboard as the default landing route

## Related

- [Platform Context Route Reorganization Planning](platform-context-route-reorganization-planning.md)
- [Workspace Identity Implementation Planning](workspace-identity-implementation-planning.md)
- [Module Layout Convention Implementation Planning](module-layout-convention-implementation-planning.md)
