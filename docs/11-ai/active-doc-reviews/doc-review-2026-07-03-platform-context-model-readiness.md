# Platform Context Model Readiness Review

Review ID: `doc-review-2026-07-03-platform-context-model-readiness`  
Date: 2026-07-03  
Type: Review-only governance audit  
Status: PARTIAL  
Implementation status: implemented with follow-up needed  

## Implementation Notes

2026-07-03:

- Added canonical architecture owner `docs/03-architecture/platform-context-model.md`.
- Updated `docs/03-architecture/system-overview.md` and `docs/03-architecture/platform-boundary.md` to use the three-context model.
- Updated `docs/03-architecture/module-system.md` to clarify that tenant eligibility metadata is not runtime enforcement.
- Added planning owner `docs/07-planning/platform-context-route-reorganization-planning.md` with route/capability classification and sequencing.
- Remaining follow-up: workspace identity contract, route alias plan, context-aware navigation, Direct Control contract, tenant registry contract, and runtime implementation.

2026-07-03:

- Added canonical architecture owner `docs/03-architecture/workspace-identity-model.md`.
- Added planning owner `docs/07-planning/workspace-identity-implementation-planning.md`.
- Updated platform context, platform boundary, tenancy, and route reorganization planning docs to identify workspace identity as the next dependency.
- Remaining follow-up: static internal workspace identity proof, resolver stub, route alias plan, context-aware navigation, Direct Control contract, tenant registry contract, and runtime implementation.

2026-07-03:

- Added static internal workspace runtime proof under `App\Core\Workspace`.
- Registered a workspace context resolver that resolves the installed URL from an explicit request host or falls back to `config('app.url')`.
- Preserved current visible `/login`, `/dashboard`, `/account/*`, and `/platform/*` routing.
- Remaining follow-up: route alias plan, context-aware navigation, Direct Control contract, tenant registry contract, tenant database switching, and broader runtime implementation.

## Scope

This review determines how the current `/platform/*` browser surface should evolve when the app needs to support three distinct contexts:

- `control_plane`: Parasolutions-only administration, support, compliance, provisioning, runtime readiness, security, and module governance.
- `internal_workspace`: Parasolutions' own operational workspace for customers, projects, tasks, tracking, users, settings, notifications, and dashboards.
- `tenant_workspace`: future client-owned workspace using the same shared systems with tenant-local database, permissions, settings, and module state.

The review outcome is that Platform should become both:

- the control plane for managing tenant and system operations
- the owner of an internal workspace that uses the same shared workspace module model as future client workspaces

Platform itself is not a tenant. A Parasolutions internal workspace may behave like a workspace for business modules, but control-plane capabilities must remain separate from workspace runtime capabilities.

This pass does not change routes, controllers, models, migrations, UI, config, module behavior, or `/docs/08-active/`. Current `/dashboard`, `/account/*`, and `/platform/*` behavior remains unchanged until context contracts, route aliases, and tests are planned.

## Current Repo Configuration

Current architecture already points toward shared core plus platform-management separation:

- The platform context is the first internal instance of the shared core app with platform-only management capabilities layered on top: `docs/03-architecture/system-overview.md:12`.
- Shared core capabilities should be reusable across platform and tenant contexts: `docs/03-architecture/system-overview.md:28`.
- Platform-management capabilities stay platform-only: `docs/03-architecture/system-overview.md:29`.
- The platform boundary currently distinguishes `platform` context as shared core usage plus Parasolutions platform-management capabilities, and `tenant` context as shared core usage without cross-tenant platform-management capabilities: `docs/03-architecture/platform-boundary.md:11`, `docs/03-architecture/platform-boundary.md:12`.
- Tenancy is planned as a central platform database plus isolated tenant databases and tenant PostgreSQL roles: `docs/03-architecture/tenancy.md:9`, `docs/03-architecture/stack-overview.md:33`.
- Tenant-local application data and operational history belong in tenant-local databases: `docs/03-architecture/tenancy.md:24`.
- The controlled module model already separates core, shared, and internal platform-management capabilities: `docs/03-architecture/module-system.md:7`.
- Shared modules may be enabled for an app instance or future tenant context when setup and eligibility allow it: `docs/03-architecture/module-system.md:14`.
- Module UI entry metadata already tracks tenant eligibility, but there is no active runtime context resolver yet: `docs/03-architecture/module-system.md:80`.

Runtime currently remains single-context:

- `/dashboard` is the primary authenticated app route: `routes/web.php:44`.
- `/account/*` routes are authenticated account routes but still named with `platform.account.*`: `routes/web.php:47` through `routes/web.php:56`.
- Most administration and workspace-adjacent screens are still under `/platform/*`: `routes/web.php:58` through `routes/web.php:175`.
- `config/navigation.php` defines navigation groups that are permission-filtered but not context-filtered.
- `app/Platform/Navigation/PlatformNavigation.php` filters navigation by role and ability, not by `control_plane`, `internal_workspace`, or `tenant_workspace`.
- `app/Core/Modules/Definitions.php` marks several current core/shared surfaces as tenant-eligible while their current routes remain platform-prefixed.

## Target Context Model

| Context | Owner | Purpose | Data boundary | Module posture |
| --- | --- | --- | --- | --- |
| `control_plane` | Parasolutions | Tenant registry, provisioning, lifecycle, support, compliance, security, runtime readiness, module governance, internal docs, cross-workspace operations | Central platform/control-plane database and explicitly scoped support access to workspace data | Platform-management modules only by default |
| `internal_workspace` | Parasolutions | Parasolutions business operations such as customers, projects, tasks, tracking, workspace users, workspace settings, notifications, dashboards, and operational reporting | Workspace-local data boundary that should follow the same model as tenant workspace data, even if hosted inside Parasolutions infrastructure | Core/shared workspace modules enabled for Parasolutions |
| `tenant_workspace` | Client tenant | Client-owned runtime for the same shared workspace systems | Tenant-local database and tenant PostgreSQL role | Core/shared tenant-eligible modules only |

This model avoids treating all `/platform/*` capabilities as one thing. The control plane manages the system. Internal workspace and tenant workspace run business modules. Some primitives, services, and UI components can be shared across all contexts, but capabilities must declare which context may render and mutate them.

## Current Route And Module Classification

| Current route family | Current state | Classification | Notes |
| --- | --- | --- | --- |
| `/dashboard` | Authenticated dashboard route: `routes/web.php:44` | `shared_workspace_candidate`, `transitional_platform_route` | Dashboard should become context-aware and render control-plane or workspace content based on active context. |
| `/account/*` | Account settings, MFA, preferences: `routes/web.php:47` through `routes/web.php:56` | `shared_workspace_candidate` | Account identity and security are core/shared, but naming is still `platform.account.*`. |
| `/platform/users/*` | User management: `routes/web.php:58` through `routes/web.php:65` | `shared_workspace_candidate`, `tenant_workspace_candidate`, `transitional_platform_route` | Users/RBAC is tenant-eligible in the module definitions, but route naming remains platform-prefixed. Control-plane user management and workspace user management must later split by context. |
| `/platform/administration/users` | Compatibility alias: `routes/web.php:67` through `routes/web.php:71` | `transitional_platform_route` | Keep as compatibility route until canonical ownership changes are planned. |
| `/platform/setup/*` | Setup pages: `routes/web.php:73` through `routes/web.php:77` | mixed: `control_plane_only`, `shared_workspace_candidate`, `transitional_platform_route` | Setup must stay separate from settings. Future setup pages need context ownership before navigation changes. |
| `/platform/notifications` | Notification inbox and actions: `routes/web.php:79` through `routes/web.php:88` | `shared_workspace_candidate`, `tenant_workspace_candidate`, `transitional_platform_route` | Notification inbox is shared workspace behavior. Current navigation should eventually be bell-owned, not left-menu-owned. |
| `/platform/audit-logs` | Audit log viewer and aliases: `routes/web.php:90` through `routes/web.php:97` | mixed: `control_plane_only`, `shared_workspace_candidate` | Tenant-local audit is workspace behavior. Cross-tenant audit visibility and compliance evidence are control-plane behavior. |
| `/platform/error-logs` | Error log viewer and aliases: `routes/web.php:99` through `routes/web.php:106` | `control_plane_only` initially | Central runtime error visibility should remain control-plane until tenant-local operational visibility is intentionally designed. |
| `/platform/security` | Security checklist: `routes/web.php:108` through `routes/web.php:110` | `control_plane_only` | Security readiness and ASVS evidence are internal control-plane tools by default. |
| `/platform/settings/*` | Platform settings pages: `routes/web.php:112` through `routes/web.php:135` | mixed: `control_plane_only`, `shared_workspace_candidate`, `tenant_workspace_candidate`, `transitional_platform_route` | Instance/workspace-local settings need separation from platform-control-plane settings before UI or route migration. |
| `/platform/docs` | Docs vault: `routes/web.php:138` | `control_plane_only` | Internal docs vault stays platform/control-plane only unless explicitly packaged and enabled elsewhere later. |
| `/platform/ui-reference/*` | UI Reference: `routes/web.php:139` through `routes/web.php:175` | `control_plane_only` for runtime access; module-package candidate for code ownership | UI Reference should not require tenant runtime. It can be module-owned but remains internal/development/control-plane by default. |
| Future customers/projects/tasks/tracking routes | Not implemented | `shared_workspace_candidate`, `tenant_workspace_candidate`, `internal_workspace_candidate` | These should be designed as shared workspace modules, not platform-control-plane tools. |

Module definition alignment:

- `dashboard-shell`, `account`, `users-rbac`, `settings`, `audit-logging`, `notifications-infrastructure`, and `notification-inbox` already contain tenant-eligible surfaces in `app/Core/Modules/Definitions.php`.
- `docs-vault`, `ui-reference`, `security-checklist`, `runtime-readiness`, `setup-pages`, and `development-tools` are platform-management or internal modules and are not tenant-eligible by default.
- Current route names and navigation labels still frequently use `platform.*`, even for surfaces that are likely shared workspace candidates.
- Tenant eligibility metadata is evidence only today. It does not yet enforce context filtering at runtime.

## Internal Workspace Requirements

Parasolutions' internal workspace should be designed as the first workspace that uses shared business modules for Parasolutions' own operations.

Internal workspace requirements:

- It must be distinct from the control plane.
- It should be allowed to use shared modules such as customers, projects, tasks, tracking, workspace dashboards, workspace users, workspace settings, notifications, and workspace audit history.
- It should have an explicit workspace identity, even if the first implementation uses the existing local database.
- It should not silently inherit control-plane permissions or expose control-plane tools inside ordinary workspace navigation.
- It should use the same module eligibility model that tenant workspaces will use later.
- It should provide a realistic proving ground for shared workspace modules before customer tenant workspaces are implemented.

Business modules should not be placed under platform-control-plane ownership just because Parasolutions is the first user. Customers, projects, tasks, and tracking are shared workspace systems.

## Tenant Workspace Requirements

Tenant workspaces must eventually provide the client-owned version of shared workspace modules.

Tenant workspace requirements:

- Tenant identity resolves before tenant-local data access.
- Tenant-local data uses tenant-local database and tenant PostgreSQL role.
- Tenant-local users, roles, settings, MFA state, notifications, audit history, and business module data must not share mutable runtime tables with other tenants.
- Tenant-eligible modules must be enabled through tenant-local module state, not hardcoded platform navigation.
- Platform-management modules remain excluded unless explicitly reclassified.
- Tenant navigation must be context-filtered by tenant, enabled modules, account permissions, and tenant configuration.
- Shared business modules must not query unscoped global tables for tenant records.

The tenant workspace model should not be implemented by copying `/platform/*` routes or views. It needs a context-aware route and module contract first.

## Control Plane Direct Access Rules

The control plane may eventually view or manage workspace and tenant data, but only through explicit Direct Control workflows.

Direct Control rules:

- Every operation must name the target context: internal workspace or tenant workspace.
- Every operation must preserve the platform actor identity separately from the target workspace identity.
- Every sensitive operation must be permission-checked in the control-plane context.
- Every mutation must record an audit event with safe metadata.
- Sensitive support mutations should require a reason or support case reference.
- Privileged changes should require MFA step-up when they affect authentication, authorization, tenant lifecycle, module availability, credentials, security policy, or business-critical data.
- Control-plane reads should distinguish support visibility from ordinary workspace membership.
- Control-plane writes must never occur through implicit shared session state or unscoped model queries.
- Forbidden operations must fail closed when target context, actor, permission, audit, or step-up context is missing.

Direct Control is a bridge from `control_plane` to a specific workspace. It is not a reason to collapse workspace and platform concerns back into one route namespace.

## Findings

### PCMR-F1: Current `/platform/*` routing mixes control-plane tools with shared workspace candidates

- Classification: `transitional_platform_route`
- Priority: P1
- References: `routes/web.php:58`, `routes/web.php:73`, `routes/web.php:79`, `routes/web.php:90`, `routes/web.php:112`, `docs/03-architecture/system-overview.md:28`
- Risk: Future business modules may continue to be built as platform-control-plane screens, making internal workspace and tenant workspace reuse harder.
- Expected future contract: Shared workspace modules use context-aware routes and capabilities. Control-plane modules stay platform-only.
- Current behavior: Users, settings, setup, notifications, audit logs, and business-adjacent surfaces are still mostly routed through `/platform/*`.
- Recommended correction: Create a context classification map and route alias plan before moving or creating additional business-module routes.

### PCMR-F2: Platform needs an explicit internal workspace identity before Parasolutions business modules are added

- Classification: `instance_config_gap`
- Priority: P1
- References: `docs/03-architecture/system-overview.md:12`, `docs/03-architecture/platform-boundary.md:11`, `docs/03-architecture/platform-boundary.md:12`
- Risk: Parasolutions customers/projects/tasks/tracking data could become indistinguishable from control-plane data.
- Expected future contract: Parasolutions has an `internal_workspace` identity that uses shared workspace modules without being modeled as Platform itself or as a customer tenant.
- Current behavior: There is no explicit workspace identity contract. The current app is a single browser context.
- Recommended correction: Define workspace identity before business modules are implemented.

### PCMR-F3: Module tenant eligibility exists, but runtime rendering is not context-filtered

- Classification: `instance_config_gap`
- Priority: P1
- References: `docs/03-architecture/module-system.md:80`, `docs/03-architecture/module-system.md:111`, `app/Core/Modules/Definitions.php`, `app/Platform/Navigation/PlatformNavigation.php`
- Risk: Module definition metadata may create false confidence that tenant eligibility is enforced.
- Expected future contract: UI entries and routes are filtered by active context, enabled modules, account permissions, and tenant/workspace configuration.
- Current behavior: Module metadata records tenant eligibility, but route access and navigation are filtered by permissions and abilities, not active context.
- Recommended correction: Add context-aware navigation and route classification only after the context model and workspace identity contract are approved.

### PCMR-F4: Settings and setup need context separation before more pages are built

- Classification: `docs_mismatch`
- Priority: P2
- References: `routes/web.php:73`, `routes/web.php:112`, `docs/03-architecture/module-system.md:150`, `docs/03-architecture/module-system.md:151`
- Risk: Platform-control-plane settings, workspace settings, and setup workflows could remain blended in one UI area.
- Expected future contract: Setup remains separate from settings. Control-plane settings/setup and workspace settings/setup are different capabilities even when they reuse components.
- Current behavior: Current settings and setup routes are platform-prefixed and contain mixed current/future concerns.
- Recommended correction: Finish settings page pattern and component contracts, then classify settings/setup pages by context before redesigning navigation.

### PCMR-F5: Navigation is permission-filtered but not context-filtered

- Classification: `route_surface_gap`
- Priority: P2
- References: `config/navigation.php`, `app/Platform/Navigation/PlatformNavigation.php`, `app/Core/Modules/Definitions.php`
- Risk: A user with broad permissions could see inappropriate control-plane or workspace surfaces once more than one context exists.
- Expected future contract: Header actions, app sidebar entries, account menu entries, and module navigation are filtered by active context plus permissions and configuration.
- Current behavior: Navigation groups are configured and permission-filtered, but not evaluated against `control_plane`, `internal_workspace`, or `tenant_workspace`.
- Recommended correction: Plan context-aware navigation after route/context classification, not before.

### PCMR-F6: Platform-only tools need a durable exclusion rule before tenant workspace work begins

- Classification: `control_plane_only`
- Priority: P2
- References: `routes/web.php:108`, `routes/web.php:138`, `routes/web.php:139`, `docs/03-architecture/module-system.md:175`, `docs/03-architecture/module-system.md:181`
- Risk: Internal tools such as Docs Vault, UI Reference, Security Checklist, runtime readiness, support tooling, and tenant registry could leak into tenant workspaces if they are treated as ordinary modules.
- Expected future contract: Platform-management modules are excluded from tenant workspaces by default and require an explicit decision to become tenant-eligible.
- Current behavior: Module metadata generally reflects this, but runtime context filtering does not exist yet.
- Recommended correction: Add a platform-management exclusion test once context filtering exists.

### PCMR-F7: Direct Control requires an audited control-plane workflow, not normal workspace CRUD

- Classification: `control_plane_only`
- Priority: P1
- References: `docs/03-architecture/platform-boundary.md:27`, `docs/03-architecture/tenancy.md:20`, `docs/03-architecture/tenancy.md:24`
- Risk: Support or admin features could perform cross-tenant reads/writes without target context, actor identity, reason, audit, or MFA safeguards.
- Expected future contract: Control-plane access to workspace data uses explicit Direct Control workflows.
- Current behavior: Tenant registry and support operation contracts are not implemented.
- Recommended correction: Define Direct Control feature and audit contracts before tenant support CRUD screens.

## Recommended Implementation Order

1. Promote the accepted context model into canonical architecture docs.
2. Create a context classification map for existing route families, module surfaces, settings/setup pages, and navigation entries.
3. Define the workspace identity contract for `internal_workspace` and `tenant_workspace`.
4. Define route alias and naming strategy so current `/platform/*` behavior remains stable while canonical context-aware routes are introduced.
5. Define context-aware navigation rules for header actions, app sidebar entries, account menu entries, settings navigation, setup navigation, and module navigation.
6. Define platform-control-plane Direct Control operation contracts, including audit, reason, permission, target context, and MFA step-up expectations.
7. Define tenant registry feature and database contracts.
8. Only then begin planning shared business modules such as customers, projects, tasks, and tracking.

Route or view moves should not happen before the context model, aliases, and workspace identity contract are defined.

## Validation Performed

Reviewed:

- `docs/03-architecture/system-overview.md`
- `docs/03-architecture/platform-boundary.md`
- `docs/03-architecture/tenancy.md`
- `docs/03-architecture/stack-overview.md`
- `docs/03-architecture/module-system.md`
- `routes/web.php`
- `config/navigation.php`
- `app/Platform/Navigation/PlatformNavigation.php`
- `app/Core/Modules/Definitions.php`

No PHPUnit was run because this is a review-only documentation artifact and no runtime behavior changed.

## Out Of Scope

- Route migration
- Route alias implementation
- Tenant registry schema or UI
- Tenant resolver
- Workspace identity schema
- Tenant database switching
- Context-aware navigation implementation
- Settings/setup redesign
- Header menu redesign
- Shared business module implementation
- Direct Control CRUD implementation
- Module install UI
- `/docs/08-active/` updates
