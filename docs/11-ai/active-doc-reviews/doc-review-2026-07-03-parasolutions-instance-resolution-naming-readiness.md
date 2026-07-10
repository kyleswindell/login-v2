# Parasolutions Instance Resolution And Naming Readiness Review

Review ID: `doc-review-2026-07-03-parasolutions-instance-resolution-naming-readiness`

Date: 2026-07-03

Type: Review-only governance audit

Status: PARTIAL

Implementation Status: implemented with follow-up needed

## Scope

This review resets the next implementation step around instance resolution, naming, and folder layout before further runtime reorganization.

The review covers:

- current generic runtime proof code under `app/Core/Runtime`
- module infrastructure under `app/Core/Modules` and `Modules/_Template`
- current visible route families in `routes/web.php`
- current navigation configuration and app layout data loading
- current login and MFA landing-route behavior
- current tests that encode the generic runtime proof
- canonical docs that describe platform context and workspace identity

This review does not implement code, routes, UI changes, migrations, module moves, or tenant database switching.

## Current Runtime Snapshot

The app still renders through the current installed URL and the current visible route surface:

- `/login`
- `/dashboard`
- `/account/*`
- `/platform/*`

The root route redirects authenticated users to `dashboard` and guests to `login` in `routes/web.php:25-29`.

Authenticated runtime routes currently include `/dashboard`, `/account/*`, `/platform/users/*`, `/platform/settings/*`, `/platform/notifications`, `/platform/audit-logs`, `/platform/error-logs`, `/platform/security`, `/platform/docs`, and `/platform/ui-reference/*` in `routes/web.php:43-177`.

The current static proof is implemented as `App\Core\Runtime\Resolver`. It returns a hard-coded Parasolutions runtime context with key `parasolutions`, name `Parasolutions`, and the current request or app URL in `app/Core/Runtime/Resolver.php`.

The resolver reads the URL from the current request host when available and falls back to `config('app.url')`.

The current tests intentionally prove that existing visible routes remain unchanged after the static proof: `/dashboard` redirects guests, authenticated users are redirected away from `/login` to `/dashboard`, and `/dashboard`, `/account`, and `/platform/users` render for a super admin in `tests/Feature/Core/Runtime/ResolutionTest.php`.

## Target Runtime Model

The next runtime model should resolve the current test URL into a configured Parasolutions app instance without hardcoding tenant-specific or workspace-specific behavior into long-lived `App/` architecture.

The resolved context should eventually provide:

- app URL or URL aliases
- display name
- config scope
- database connection target
- enabled modules
- permission scope

`App/` should consume that resolved context through generic services. It should not contain Parasolutions-specific, workspace-specific, or tenant-specific folders as final architecture.

Domain-based resolution is future work. The first proof should be a static test-server mapping for the current local/LAN URL.

## Naming And Folder Layout Review

Permanent naming for this narrow layer is approved as `Runtime`.

Prior `Workspace*` names were provisional and have been replaced by `app/Core/Runtime/Context.php` and `app/Core/Runtime/Resolver.php`.

Potential neutral naming options for review:

| Candidate term | Example classes | Strength | Risk |
| --- | --- | --- | --- |
| `Instance` | `InstanceContext`, `InstanceResolver`, `InstanceManifest` | Neutral for URL-resolved app runtime and works before true tenancy exists. | Could sound too infrastructure-oriented unless the docs define it clearly. |
| `Installation` | `InstallationContext`, `InstallationResolver`, `InstallationManifest` | Matches "current installed URL" language and avoids tenant/workspace overclaim. | May imply deployed app install rather than customer/internal runtime identity. |
| `AppContext` | `AppContext`, `AppContextResolver`, `AppManifest` | Simple and generic for `App/` consumption. | Broad name could become vague unless scoped tightly to URL resolution. |
| `Site` | `SiteContext`, `SiteResolver`, `SiteManifest` | Common for host/domain resolution. | May understate database/module/permission scope. |

No other namespace, folder, route group, config file, or service name should be renamed until the permanent direction is manually approved.

Temporary review labels such as `shared_workspace_candidate`, `control_plane_only`, `tenant_workspace_candidate`, or `transitional_platform_route` are acceptable for planning tables only. They must not become folder names, namespaces, route prefixes, or class names.

## Current Surface Classification

These are review labels only.

| Current surface | Review label | Notes |
| --- | --- | --- |
| `/login` | app-entry-auth | Should route through the resolved instance for post-auth landing, but visible URL can stay stable. |
| `/dashboard` | base-instance-landing, transitional-route | Current landing route; should remain initial Parasolutions landing until aliases are approved. |
| `/account/*` | base-instance-core | Account/MFA/preferences are core authenticated features and should consume resolved context later. |
| `/platform/users/*` | base-instance-core, transitional-platform-route | Current users/RBAC may become reusable core administration for the Parasolutions instance and future configured instances. |
| `/platform/settings/*` | mixed-instance-settings, transitional-platform-route | Needs page-by-page separation between instance settings and internal-only management settings. |
| `/platform/setup/*` | instance-setup-candidate, transitional-platform-route | Setup should stay separate from settings; final placement depends on approved navigation and module lifecycle rules. |
| `/platform/notifications` | base-instance-core, transitional-platform-route | Runtime access should come through the notification bell rather than main navigation. |
| `/platform/audit-logs` | mixed-audit-surface | Instance-local audit history and internal cross-instance audit visibility should not share implicit semantics forever. |
| `/platform/error-logs` | internal-operations-candidate | Central runtime error visibility is likely internal-only until tenant-local operational visibility is designed. |
| `/platform/docs` | deferred-internal-tool | Internal docs vault should not block the core Parasolutions instance recovery path. |
| `/platform/security` | deferred-internal-tool | Security checklist remains internal readiness tooling; not part of the minimum core workspace proof. |
| `/platform/ui-reference/*` | deferred-module | UI Reference should be removed from the recovery path until rebuilt through `_Template`/module packaging and the reference page design. |

## Findings

### F1: Static instance proof was named as workspace architecture

Priority: P1

Classification: naming_gap

Status: Implemented

References:

- `app/Core/Runtime/Resolver.php`
- `app/Core/Runtime/Context.php`
- `tests/Feature/Core/Runtime/ResolutionTest.php`

Risk:

The prior static proof hardened `Workspace*` terminology inside `App/Core`. That could have pushed the codebase toward workspace-specific architecture even though the clarified direction is generic request runtime resolution first.

Expected contract:

`App/` owns generic runtime services. Final architecture should not require workspace-specific folders or namespace names unless explicitly approved.

Current behavior:

The runtime proof now resolves one static Parasolutions runtime context from `App\Core\Runtime`. It does not expose workspace type, tenant type, status, landing route, database target, or module list.

Recommended correction:

Completed for the narrow runtime proof. Keep future taxonomy out of `App/` folder names until each naming decision is approved.

### F2: Parasolutions context is hardcoded instead of database-driven

Priority: P1

Classification: instance_config_gap

References:

- `app/Core/Runtime/Resolver.php`

Risk:

Hardcoding the Parasolutions runtime context in a resolver does not prove the desired long-term mechanism: URL/domain resolution through database-held records.

Expected contract:

The current test URL may stay static while there is only one workspace. When URL-based switching is needed, tenant or app-instance URL truth should be database-held, not Laravel config-held.

Current behavior:

The resolver derives URL from the request or `app.url`, then always returns the same Parasolutions context.

Recommended correction:

Do not add heavy config-held tenant data. Leave the resolver static while one workspace exists. When domain-based switching is needed, design the minimal database-backed lookup before adding URL or database switching behavior.

### F3: Login and MFA landing should keep dashboard as fixed fallback

Priority: P1

Classification: route_surface_gap

References:

- `app/Http/Controllers/Auth/LoginController.php:142-144`
- `app/Platform/Auth/Mfa/MfaLoginIssuer.php:27-51`
- `app/Platform/Auth/Mfa/MfaSession.php:19-27`
- `app/Platform/Auth/Mfa/MfaSession.php:49-55`
- `app/Platform/Auth/Mfa/MfaSession.php:161-166`

Risk:

Earlier planning implied landing could become context-configurable. The approved rule is that dashboard is the default landing route for every app instance.

Expected contract:

Post-login fallback should remain `dashboard` when there is no more specific intended URL.

Current behavior:

Login, MFA pending state, MFA issuance, and MFA step-up fallback all use `route('dashboard', absolute: false)` as the default.

Recommended correction:

No landing-route abstraction is needed. Keep the current dashboard fallback unless a later explicit decision changes this rule.

### F4: `/platform/*` is currently a mixed visible route prefix, not a reliable architecture boundary

Priority: P1

Classification: route_surface_gap

References:

- `routes/web.php:43-177`
- `docs/07-planning/platform-context-route-reorganization-planning.md`

Risk:

The current route prefix mixes core app functions, transitional aliases, internal tools, and deferred module surfaces. Treating `/platform/*` as a final architecture boundary would preserve the wrong split.

Expected contract:

Current visible routes should stay stable until aliases, context ownership, and tests are planned. Future route organization should follow approved context/instance/module naming, not the historical `/platform/*` prefix alone.

Current behavior:

Core candidates such as users, settings, notifications, account-adjacent MFA routes, and platform-management surfaces all coexist under `/platform/*`.

Recommended correction:

Keep current routes stable for now. Use a route classification map for planning only. Do not move or rename route families until the generic context name, route aliases, landing behavior, and focused route tests are approved.

### F5: Navigation is permission-filtered but not context-filtered

Priority: P1

Classification: navigation_context_gap

References:

- `config/navigation.php:3-117`
- `app/Platform/Navigation/PlatformNavigation.php:22-33`
- `app/Platform/Navigation/PlatformNavigation.php:40-55`
- `app/Platform/Shell/AppShellData.php:48-68`

Risk:

The current navigation can expose stale or deferred route families whenever the user has permission, regardless of whether the resolved context should show those surfaces.

Expected contract:

Navigation should eventually be built from current resolved context, enabled modules, permissions, and approved placement rules.

Current behavior:

Navigation is loaded from `config/navigation.php`, then filtered by role or ability. `AppShellData` merges `primaryBase` and `primaryAdmin` into header navigation. UI Reference is still configured as a primary admin item, and Notifications still appears in `primaryBase`.

Recommended correction:

For the recovery path, remove or hide deferred UI Reference rendering from current visible navigation after approval. Then add context-aware navigation only after the instance resolver and module enablement source are approved. Do not implement broad navigation redesign as part of this review.

### F6: Module package direction is useful, but not an instance-resolution substitute

Priority: P2

Classification: valid_boundary_with_gap

References:

- `Modules/_Template/module.php:14-24`
- `Modules/_Template/README.md:11-23`
- `app/Core/Modules/PackageDefinition.php:13-70`
- `app/Core/Modules/PackageRegistrar.php:20-28`
- `app/Core/Modules/PackageRegistrar.php:45-61`
- `app/Core/Modules/PackageRegistrar.php:88-121`

Risk:

The module package foundation solves single-parent module packaging, but it does not decide which app instance is active or which modules are enabled for that instance.

Expected contract:

Module packages provide installable capability units. Instance resolution decides which configured context is active and which module set applies.

Current behavior:

`Modules/_Template` provides a strong copy source and `PackageDefinition::defaults()` derives package metadata from the module folder name. `PackageRegistrar` can register package-local views, migrations, routes, and providers.

Recommended correction:

Keep `_Template` as the module-package proof. Do not roll UI Reference forward until the static Parasolutions instance resolution path is stable and the UI Reference module can be rebuilt from the template and reference page design.

### F7: Tests encode the current provisional names and route stability

Priority: P2

Classification: test_contract_gap

References:

- `tests/Feature/Core/Runtime/ResolutionTest.php`

Risk:

Current tests are useful for proving no route behavior changed and now encode the approved generic runtime context name.

Expected contract:

Tests should prove the generic runtime resolver and base route stability without pulling in stale UI Reference Definitions rendering.

Current behavior:

Tests prove the static Parasolutions runtime proof and route stability.

Recommended correction:

Keep this focused test contract. Add database-backed URL resolution tests only when that feature is actually designed.

## Valid Existing Boundaries

- The current visible route behavior is intentionally stable and should not be moved before alias and test coverage exists.
- `Modules/_Template` establishes the correct single-parent module package direction for future modules.
- `PackageDefinition::defaults()` avoids hardcoded module route/view/provider boilerplate for copied module packages.
- `PackageRegistrar` centralizes package-local route, view, migration, and provider registration.
- The current static proof resolves the request URL or configured app URL through the approved generic runtime resolver.

## Recommended Follow-Up Order

1. Restore a viewable Parasolutions base app surface.
   - Base views: dashboard, account, users, settings, notifications if enabled.
   - Do not include UI Reference in this recovery path.
2. Remove or hide deferred UI Reference from current rendered navigation until it is rebuilt as a module.
3. Review `/platform/*` route naming and folder layout separately before route aliases or moves.
4. Plan database-backed URL resolution only when a second database/context is actually needed.
5. Plan route aliases and context-aware navigation only after the base Parasolutions surface is stable.

## Implementation Planning Notes

The next implementation should be deliberately small:

- no tenant database switching
- no domain resolver beyond the current static runtime proof
- no route migration
- no control-plane implementation
- no UI Reference rebuild
- no module install UI

The first implementation should answer only:

1. Does the current URL resolve to the Parasolutions runtime context?
2. Which base modules/surfaces should render for that context?
3. Which stale/deferred surfaces should be absent from the current navigation?

## Validation Performed

Reviewed:

- `docs/03-architecture/platform-context-model.md`
- `docs/03-architecture/workspace-identity-model.md`
- `docs/07-planning/workspace-identity-implementation-planning.md`
- `docs/07-planning/platform-context-route-reorganization-planning.md`
- `docs/03-architecture/module-system.md`
- `app/Core/Runtime/*`
- `app/Core/Modules/PackageDefinition.php`
- `app/Core/Modules/PackageRegistrar.php`
- `app/Core/Modules/Definitions.php`
- `Modules/_Template/*`
- `routes/web.php`
- `config/navigation.php`
- `app/Platform/Navigation/PlatformNavigation.php`
- `app/Platform/Shell/AppShellData.php`
- `app/Http/Controllers/Auth/LoginController.php`
- `app/Platform/Auth/Mfa/MfaLoginIssuer.php`
- `app/Platform/Auth/Mfa/MfaSession.php`
- `tests/Feature/Core/Runtime/ResolutionTest.php`

No PHPUnit was run because this is a review-only documentation pass.

## Out Of Scope

- tenant database switching
- tenant registry
- domain resolver backed by database records
- control-plane implementation or naming
- route aliases
- route/controller/view moves
- permanent naming decisions
- UI Reference rebuild
- UI Reference render-test repair
- module install/enable UI
- `/docs/08-active/` updates
