# Platform Control Plane Tenant Context Readiness Review

Review ID: `doc-review-2026-07-03-platform-control-plane-tenant-context-readiness`  
Date: 2026-07-03  
Type: Review-only governance audit  
Status: READY_FOR_IMPLEMENTATION  
Implementation status: not started  

## Scope

This review defines `Platform` as the internal Parasolutions control plane for tenant registry, provisioning, lifecycle, support, cross-tenant visibility, compliance, internal docs, security, runtime readiness, and module governance.

Platform is not a tenant. Platform is the control-plane environment that may manage tenants through explicit, audited workflows.

This pass does not change routes, controllers, models, migrations, UI, module files, config, or `/docs/08-active/`. Current `/dashboard` and `/platform/*` routes remain the active browser-facing app surface until a separate implementation plan defines aliases, tests, and migration order.

## Current Canonical Direction

Existing canonical direction already supports a control-plane interpretation:

- The platform context is the first internal instance of the shared core app with platform-only management capabilities layered on top: `docs/03-architecture/system-overview.md:12`.
- Platform administration is owned by Parasolutions, while tenant administration is owned per client instance and resolved from central domain metadata: `docs/03-architecture/system-overview.md:22`.
- Shared core capabilities should be reusable across platform and tenant contexts: `docs/03-architecture/system-overview.md:28`.
- The platform boundary defines platform-owned responsibilities as tenant registry, domain registry, provisioning lifecycle control, policy controls, centralized operational visibility, and support tooling: `docs/03-architecture/platform-boundary.md:27`, `docs/03-architecture/platform-boundary.md:28`, `docs/03-architecture/platform-boundary.md:30`.
- Tenancy is planned as central platform database plus isolated tenant databases and roles: `docs/03-architecture/tenancy.md:9`, `docs/03-architecture/tenancy.md:13`.
- The central platform database owns tenant identity, domains, provisioning state, and platform operations visibility: `docs/03-architecture/tenancy.md:20`.
- Tenant-local data and operational history belong in tenant-local databases: `docs/03-architecture/tenancy.md:24`.
- Platform-to-tenant access is already expected to be auditable and explicit: `docs/03-architecture/auth.md:52`.
- Current routes remain custom Blade under `/dashboard` and `/platform/...`: `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:18`.
- Shared core routes should not permanently depend on the word `platform`: `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:68`.

## Control Plane Target Model

The target model is:

| Layer | Purpose | Notes |
| --- | --- | --- |
| Platform control plane | Internal Parasolutions operations, support, provisioning, security, tenant lifecycle, compliance, runtime readiness, module governance | Not a tenant. May perform tenant-scoped operations only through explicit control-plane workflows. |
| Core | Reusable application capabilities that can run in platform context or tenant context | Includes dashboard, account, users/RBAC, settings, MFA, notifications, and other shared services when made context-neutral. |
| Tenant | Isolated customer/admin runtime backed by tenant-local database and PostgreSQL role | Owns tenant-local users, roles, settings, module data, audit history, and business records. |
| Modules | Packaged capabilities with explicit type, lifecycle, eligibility, permissions, views, setup, settings, and content ownership | Modules may be core, shared, tenant-eligible, or platform-management only. |

Platform may eventually perform Direct Control CRUD across tenants. That does not mean unrestricted cross-tenant writes. Every tenant-targeted operation must have a target tenant, platform actor, permission decision, audit event, sensitive-action reason where needed, and MFA step-up for privileged changes.

## Current Browser-Facing Route Inventory

| Route family | Current implementation | Classification | Future direction |
| --- | --- | --- | --- |
| `/dashboard` | `routes/web.php:44`, Livewire dashboard | `shared_core_candidate` | Keep current behavior, later make context-aware for platform and tenant. |
| `/account/*` | account routes under authenticated group | `shared_core_candidate` | User account settings should be context-aware and session-bound. |
| `/platform/users/*` | `routes/web.php:58` through `routes/web.php:65` | `tenant_eligible_later` | Staff/user management is shared core when scoped to context; platform user management remains current compatibility surface. |
| `/platform/administration/users` | `routes/web.php:67` through `routes/web.php:71` | `transitional_alias` | Keep as gate-checked alias until canonical route ownership is decided. |
| `/platform/setup/*` | `routes/web.php:73` through `routes/web.php:77` | mixed: `platform_control_plane_only` and `tenant_eligible_later` | Split future setup into tenant-local setup versus platform-control-plane setup. |
| `/platform/notifications` | notification routes around `routes/web.php:79` through `routes/web.php:88` | `shared_core_candidate` | Notification inbox is shared core when scoped to context; broadcast/channel context must be isolated. |
| `/platform/audit-logs` | audit viewer routes around `routes/web.php:90` through `routes/web.php:97` | `shared_core_candidate` with platform-management visibility | Tenant-local audit is shared core; cross-tenant audit visibility is platform control plane. |
| `/platform/error-logs` | error viewer routes around `routes/web.php:99` through `routes/web.php:106` | `platform_control_plane_only` initially, tenant-local later if needed | Central error visibility remains platform-only until tenant-local operational visibility is designed. |
| `/platform/security` | `routes/web.php:108` through `routes/web.php:110` | `platform_control_plane_only` | Security checklist and compliance evidence remain internal platform capabilities. |
| `/platform/settings/*` | `routes/web.php:112` through `routes/web.php:135` | mixed: `shared_core_candidate` and `platform_control_plane_only` | Split instance-local settings from platform-only settings before route migration. |
| `/platform/docs` | `routes/web.php:138` | `platform_control_plane_only` | Internal docs vault remains platform-only unless explicitly reclassified. |
| `/platform/ui-reference/*` | `routes/web.php:139` through `routes/web.php:175` | `platform_control_plane_only` for now | UI Reference should become a platform-management module package, not tenant runtime. |

## Route And Capability Classification

Classification rules for future implementation:

- `shared_core_candidate`: can run in platform context or tenant context after context, database, authorization, and audit boundaries exist.
- `platform_control_plane_only`: internal capability that manages or observes tenants, runtime, security, compliance, docs, or support and must not appear in tenant runtime by default.
- `tenant_eligible_later`: likely shared core, but must not move until data ownership and permission scope are defined.
- `transitional_alias`: route exists to preserve browser compatibility or current navigation while ownership converges.
- `docs_mismatch`: documentation or naming implies a different owner than implementation.

Current high-level split:

- Shared core candidates: dashboard, account, users/RBAC, settings where instance-local, notifications, tenant-local audit logs.
- Platform control plane only: tenant registry, provisioning, support operations, docs vault, security checklist, runtime readiness, UI Reference until packaged, cross-tenant audit/search, central error operations.
- Transitional aliases: `/platform/administration/*`, `/platform/operations/*`, and future old route names kept after canonical route migration.

## Direct Tenant Control Rules

Direct Control CRUD is the preferred long-term support model, with these constraints:

| Operation category | Allowed direction | Required safeguards |
| --- | --- | --- |
| Read-only tenant support visibility | Platform may view selected tenant state for support and diagnostics | tenant target, actor, permission, audit event, safe metadata only |
| Direct-edit tenant operations | Platform may edit tenant-local records through explicit workflows | tenant target, actor, permission, reason for sensitive edits, before/after summary, audit event, MFA step-up when privileged |
| Tenant lifecycle operations | Platform may create, suspend, reactivate, configure, and provision tenants | lifecycle policy, step-up for privileged changes, audit event, provisioning state, rollback/failure state |
| Tenant module operations | Platform may enable, disable, install, or configure eligible modules | module eligibility, tenant status, dependency checks, setup state, audit event |
| Forbidden operations | Platform must not silently mutate tenant data through implicit shared session or unscoped queries | fail closed if tenant context, permission, or audit context is missing |

Sensitive operations should require MFA step-up when they affect authentication, authorization, tenant lifecycle, data access, module availability, credentials, security policy, or external integration configuration.

Direct tenant operations should not reuse tenant user sessions invisibly. Platform actor identity and tenant target identity must both remain visible in audit evidence.

## Tenant Registry Expectations

The first tenant registry design should define:

- tenant key
- display name
- lifecycle status
- primary admin domain and alias domains
- database name or connection reference
- database role reference
- enabled modules and module setup state
- support access policy
- provisioning status
- last provisioning error or failure state
- created/updated actor metadata
- audit trail for lifecycle and support-access changes

This review does not implement the tenant registry. It defines the minimum owner data that route, module, support, and provisioning plans should expect.

## Findings

### PCC-F1: Platform is conceptually a control plane, but current route naming blurs shared core and platform management

- Classification: `docs_mismatch`
- Priority: P1
- References: `docs/03-architecture/system-overview.md:12`, `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:68`, `routes/web.php:58`, `routes/web.php:112`
- Risk: Shared core surfaces may continue to be built under `platform.*` route names and permissions, making tenant-context reuse harder.
- Expected future contract: Shared core route and permission contracts should be context-neutral, while platform-control-plane capabilities stay clearly platform-only.
- Current behavior: Users, settings, notifications, audit logs, and setup are mostly reachable under `/platform/*`.
- Recommended correction: Create a route/capability migration map before changing navigation. Preserve current URLs as aliases while defining canonical shared-core route names.

### PCC-F2: Direct tenant CRUD needs a first-class support operation contract before implementation

- Classification: `platform_control_plane_only`
- Priority: P1
- References: `docs/03-architecture/auth.md:52`, `docs/03-architecture/platform-boundary.md:30`
- Risk: Platform support CRUD could become unscoped cross-tenant writes if implemented as ordinary admin CRUD.
- Expected future contract: Every direct tenant operation carries tenant target, platform actor, authorization result, reason where required, audit event, and step-up status where sensitive.
- Current behavior: No tenant support operation contract exists yet.
- Recommended correction: Define a platform support operation model before adding tenant CRUD screens.

### PCC-F3: Tenant registry expectations exist in architecture but not as a concrete feature/data contract

- Classification: `tenant_eligible_later`
- Priority: P1
- References: `docs/03-architecture/platform-boundary.md:27`, `docs/03-architecture/tenancy.md:20`, `docs/05-flows/tenant-provisioning-flow.md`
- Risk: Route migration, module enablement, and provisioning work may invent incompatible tenant identity fields.
- Expected future contract: Tenant registry fields and lifecycle states are defined before tenant resolver, provisioning UI, or module installation flows.
- Current behavior: Tenant registry is described conceptually, but no detailed feature or database contract is implemented.
- Recommended correction: Draft tenant registry feature and database contracts before implementation.

### PCC-F4: Setup and settings route families mix platform-only and future tenant-local concerns

- Classification: `docs_mismatch`
- Priority: P2
- References: `routes/web.php:73`, `routes/web.php:112`, `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:44`, `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:45`
- Risk: Setup/settings UI changes may expose platform-management controls in tenant contexts later.
- Expected future contract: Tenant-local setup/settings and platform-control-plane setup/settings are distinct in capability ownership, even if they reuse components.
- Current behavior: Current setup/settings pages are platform-prefixed and include mixed concerns.
- Recommended correction: Classify each setup/settings page before moving navigation or route names.

### PCC-F5: Platform-management tools need an exclusion list before tenant-like contexts are introduced

- Classification: `platform_control_plane_only`
- Priority: P2
- References: `routes/web.php:108`, `routes/web.php:138`, `routes/web.php:139`, `docs/03-architecture/module-system.md`
- Risk: Internal docs, UI Reference, security checklist, runtime readiness, and future support tooling could leak into tenant runtime if only module visibility controls are used.
- Expected future contract: Platform-control-plane modules are excluded from tenant contexts by default and require explicit reclassification to become tenant-eligible.
- Current behavior: Module metadata already marks platform-management modules not tenant-eligible, but route ownership is still platform-prefixed and browser-visible in the current internal app.
- Recommended correction: Maintain a platform-management exclusion list and test it when tenant context exists.

### PCC-F6: Current route behavior must remain stable while ownership changes are planned

- Classification: `transitional_alias`
- Priority: P2
- References: `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:18`, `routes/web.php:28`, `routes/web.php:44`
- Risk: Premature route moves would break the current local review surface and invalidate navigation/security tests.
- Expected future contract: Route migration happens through compatibility aliases plus route authorization coverage.
- Current behavior: `/dashboard` and `/platform/*` are the active browser-facing app.
- Recommended correction: Do not move routes in the next step. First produce the migration map and target route names.

## Recommended Implementation Order

1. Create a shared-core versus platform-control-plane route and capability map.
2. Define tenant registry feature and database contracts.
3. Define platform support operation contracts for Direct Control CRUD.
4. Add platform-context-only resolver scaffolding without changing URLs.
5. Add tenant registry schema and platform-only tenant registry UI.
6. Add compatibility route aliases and route authorization tests before moving any shared-core route names.
7. Add tenant-context resolver and tenant database connection switching only after the platform-control-plane foundation is stable.
8. Resume header/sidebar/settings/setup navigation changes after route ownership and control-plane capability boundaries are explicit.

## Validation Performed

Reviewed:

- `docs/03-architecture/system-overview.md`
- `docs/03-architecture/platform-boundary.md`
- `docs/03-architecture/tenancy.md`
- `docs/03-architecture/auth.md`
- `docs/03-architecture/module-system.md`
- `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md`
- `routes/web.php`

This review did not run PHPUnit because no runtime behavior changed.

## Out Of Scope

- Route migration
- Tenant registry schema or UI
- Tenant resolver
- Tenant database switching
- Tenant provisioning implementation
- Platform support CRUD implementation
- Header/sidebar/settings/setup navigation changes
- Module install UI
- `/docs/08-active/` updates
