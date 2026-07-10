# Multi-Instance Platform Decoupling Readiness Audit

Review ID: `doc-review-2026-07-02-multi-instance-platform-decoupling-readiness`  
Date: 2026-07-02  
Type: Review-only governance audit  
Status: PARTIAL  
Implementation status: implemented with follow-up needed  

## Scope

This review evaluates whether Login App 2.0 can evolve from the current single `platform` instance into multiple independently configured app instances, starting with a minimal `platform-2` mirror proof.

This is not tenant-isolation implementation. The audit identifies platform singleton coupling, shared-core readiness gaps, config/database assumptions, and surfaces that should remain platform-only.

The minimal target is:

- same codebase
- `platform-1` and `platform-2` run as mirrors
- separate environment/configuration
- separate database
- separate users, roles, settings, MFA state, notifications, audit logs, and error logs
- no shared mutable app data except source code and deployment artifacts

## Current Planning Direction

Canonical direction already separates current reality from the future tenancy model:

- Tenancy is explicitly planned and not implemented yet: `docs/03-architecture/tenancy.md:5`.
- The planned model is a central platform database plus one isolated tenant database per tenant: `docs/03-architecture/tenancy.md:9`, `docs/03-architecture/tenancy.md:13`.
- Tenant runtime context is expected to boot from resolved tenant identity: `docs/03-architecture/tenancy.md:15`.
- The central platform database is intended to own tenant identity, domains, provisioning state, and platform operations visibility: `docs/03-architecture/tenancy.md:20`.
- Tenant-local data and operational history are intended to live in the tenant database: `docs/03-architecture/tenancy.md:24`.
- Tenant admin requests are expected to resolve by domain, initialize tenant database context, and fail closed for unknown or inactive tenant domains: `docs/03-architecture/tenancy.md:28`, `docs/03-architecture/tenancy.md:30`.
- The architecture boundary defines `platform` context as shared core plus platform-management capabilities and `tenant` context as shared core without cross-tenant platform-management capabilities: `docs/03-architecture/platform-boundary.md:11`, `docs/03-architecture/platform-boundary.md:12`.
- The route ownership plan says shared core routes should not permanently depend on the word `platform`: `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:68`.
- Current route families are still custom Blade under `/dashboard` and `/platform/...`: `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:18`.
- Long-term route direction keeps `/dashboard`, users, settings, notifications, audit logs, and error logs as shared-core candidates while docs, tenant registry, and platform-management operations stay platform-only: `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:76`, `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:82`, `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:83`, `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:84`.
- Tenant safety standards already prohibit hardcoded tenant domains, paths, and database names, and require tenant context in operational logs: `docs/02-standards/security/Tenant Safety Standards.md:11`, `docs/02-standards/security/Tenant Safety Standards.md:14`.

## Minimal Platform-2 Mirror Target

The first proof should not introduce full tenant resolution or a tenancy package. It should prove that a second internal app instance can run from the same source with separate mutable state.

Minimum proof requirements:

- separate `.env` or deployment environment for `platform-2`
- separate `APP_URL`, service name, and runtime ports
- separate database name and database role
- separate cache, Redis, queue, session, and broadcast namespace/configuration
- separate seeded users, roles, permissions, settings, MFA state, notifications, audit logs, and error logs
- separate local or deployment runbook showing how to migrate, seed, start, and verify both instances
- no shared mutable runtime state other than code and build artifacts

This proof should still be treated as an internal platform mirror. It must not claim customer tenant isolation.

## Reviewed Surfaces

Documentation reviewed:

- `docs/03-architecture/tenancy.md`
- `docs/03-architecture/platform-boundary.md`
- `docs/07-planning/phases/phase-1/Tenancy And Provisioning Foundation.md`
- `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md`
- `docs/02-standards/security/Tenant Safety Standards.md`

Implementation surfaces inspected:

- Routes and route names: `routes/web.php`, `routes/channels.php`
- Runtime config/env: `.env.example`, `docker-compose.yml`, `config/platform.php`, `config/database.php`, `config/cache.php`, `config/session.php`, `config/broadcasting.php`
- Permissions and gates: `database/seeders/PlatformRolesAndPermissionsSeeder.php`, `database/seeders/DatabaseSeeder.php`, `app/Providers/AppServiceProvider.php`
- Settings: `app/Platform/Settings/SettingsService.php`, `app/Models/Setting.php`, `database/migrations/2026_04_09_000003_create_settings_table.php`, `app/Http/Controllers/Platform/SettingsController.php`
- Auth/MFA/account surfaces through route wiring and controllers under `app/Http/Controllers/Platform/`
- Notifications, audit logs, error logs, and broadcast auth: `app/Platform/Notifications/NotificationService.php`, `app/Platform/Logging/PlatformLogger.php`, `app/Models/PlatformNotification.php`, `app/Models/PlatformAuditLog.php`, `app/Models/CentralErrorLog.php`, related migrations, and `app/Http/Controllers/Platform/BroadcastAuthController.php`
- Dashboard and navigation: `app/Platform/Dashboard/WidgetRegistry.php`, `app/Livewire/Platform/Dashboard/DashboardPage.php`, `app/Platform/Navigation/PlatformNavigation.php`, `config/navigation.php`
- Platform-only candidate surfaces: docs vault, UI Reference, security checklist, runtime readiness command, and setup pages

## Findings

### MIPD-F1: No first-class app instance context exists

Classification: `instance_config_gap`  
Priority: P1  

References:

- `.env.example:1`
- `.env.example:2`
- `.env.example:8`
- `config/platform.php:6`
- `config/platform.php:7`
- `config/platform.php:8`
- `app/Platform/Logging/PlatformLogger.php:73`

Risk:

Without a first-class app instance key/name, a `platform-2` mirror depends on ad hoc environment naming and database separation only. Logs, runtime checks, settings, broadcast channels, and operational support cannot reliably state which app instance produced an event.

Expected future contract:

Every running app instance should have a non-secret `instance_key`, display name, and role such as `internal_platform`, `platform_mirror`, or future `tenant_admin`. That context should be available to services, logs, audit/error records, runtime checks, and deployment runbooks.

Current behavior:

The environment exposes `APP_NAME`, `APP_SERVICE_NAME`, and `APP_URL`, but reviewed config does not define an application instance identity. `config/platform.php` currently owns security/runtime settings, not instance identity. Error logging has a `tenant_key` hook, but no runtime source for a platform instance key.

Recommended correction:

Add an instance identity contract before the platform-2 proof. Suggested non-secret config: `APP_INSTANCE_KEY`, `APP_INSTANCE_NAME`, and `APP_INSTANCE_ROLE`, surfaced through a small service or config helper. Include the instance key in audit/error runtime metadata and readiness output. Do not use this as tenant isolation; it is a deployment/runtime identity boundary for mirrored instances.

### MIPD-F2: Runtime data separation is not fully specified for a second instance

Classification: `database_boundary_gap`  
Priority: P1  

References:

- `.env.example:31`
- `.env.example:34`
- `.env.example:35`
- `.env.example:44`
- `.env.example:57`
- `.env.example:73`
- `docker-compose.yml:89`
- `docker-compose.yml:90`
- `config/database.php:20`
- `config/cache.php:115`
- `config/database.php:152`
- `config/session.php:132`
- `config/session.php:159`

Risk:

A second instance can use a separate database by changing `DB_DATABASE` and `DB_USERNAME`, but the proof target also requires separate cache, Redis, queues, sessions, and broadcast state. If two mirrors share Redis/Reverb/session cookies without unique prefixes and IDs, mutable runtime state can collide even with separate databases.

Expected future contract:

The platform-2 proof should define an explicit environment separation checklist for database, database user, cache prefix, Redis prefix, queue namespace, session cookie/name/domain, Reverb app ID/key/host/port, and service ports.

Current behavior:

Database configuration is environment-driven and Docker defaults to `platform_app`. Cache, Redis, and session defaults derive from `APP_NAME` unless explicit prefixes are supplied. Reverb defaults use `REVERB_APP_ID=platform-app`.

Recommended correction:

Create a platform-2 local/deployment runbook and `.env.platform-2.example` or documented variable matrix. Require unique mutable-state namespaces for `platform-1` and `platform-2`. Treat separate database alone as insufficient for the mirror proof.

### MIPD-F3: Shared-core surfaces are still routed and named as platform-only

Classification: `route_surface_gap`  
Priority: P1  

References:

- `routes/web.php:44`
- `routes/web.php:47`
- `routes/web.php:52`
- `routes/web.php:58`
- `routes/web.php:79`
- `routes/web.php:90`
- `routes/web.php:99`
- `routes/web.php:112`
- `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:68`
- `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:76`
- `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:86`

Risk:

The current route surface can operate in a second mirrored internal instance, but the naming implies users, settings, notifications, audit logs, error logs, and account settings are inherently platform-owned. That conflicts with the planned shared-core direction and will make later tenant/admin context reuse more expensive.

Expected future contract:

Shared-core app surfaces should be context-neutral at the contract layer. Platform-management routes should remain visibly platform-only. Route names, navigation keys, controllers, and gates should reflect whether a surface is shared instance-core or platform-management.

Current behavior:

`/dashboard` is context-neutral, but most authenticated app features are under `/platform/*` and named `platform.*`, including users, settings, notifications, audit logs, error logs, account routes, and MFA account routes. Docs already identify this as transitional and warn against permanently tying shared routes to `platform`.

Recommended correction:

Before building platform-2, create a route/capability ownership inventory that marks each route family as `shared_instance_core`, `platform_management`, or `deferred_tenantization`. Do not immediately rename all routes. Start by documenting ownership and adding tests or route metadata that prevent platform-only surfaces from being mistaken for shared-core surfaces.

### MIPD-F4: RBAC seed names are platform-prefixed across both shared and platform-only capabilities

Classification: `platform_singleton_coupling`  
Priority: P1  

References:

- `database/seeders/PlatformRolesAndPermissionsSeeder.php:15`
- `database/seeders/PlatformRolesAndPermissionsSeeder.php:16`
- `database/seeders/PlatformRolesAndPermissionsSeeder.php:25`
- `database/seeders/PlatformRolesAndPermissionsSeeder.php:41`
- `database/seeders/PlatformRolesAndPermissionsSeeder.php:50`
- `database/seeders/PlatformRolesAndPermissionsSeeder.php:57`
- `database/seeders/PlatformRolesAndPermissionsSeeder.php:68`
- `app/Providers/AppServiceProvider.php:62`
- `app/Providers/AppServiceProvider.php:71`
- `app/Providers/AppServiceProvider.php:114`

Risk:

Current role/permission scaffolding is acceptable for early testing and a direct platform-2 mirror, but it blurs shared-core permissions with platform-management permissions. If copied forward unchanged, future tenant-side RBAC would inherit platform-specific role names and gates.

Expected future contract:

RBAC should distinguish shared-core capabilities from platform-management capabilities. Platform-management permissions should never grant tenant-context access by implication. Shared-core permissions should be reusable across internal platform mirrors and future tenant admin contexts.

Current behavior:

Seeded permissions are `platform.*` across users, notifications, audit logs, error logs, settings, docs, UI Reference, and security checklist. Roles are `platform_super_admin`, `platform_admin`, `platform_operator`, and `platform_reviewer`. Gates use names such as `view-platform-users`, `view-platform-settings`, and `view-platform-security-checklist`.

Recommended correction:

Do not redesign RBAC now. For the next implementation pass, produce a permissions namespace map that classifies existing permissions as either shared-core provisional permissions or platform-management permissions. Keep the current names where needed for stability, but avoid adding more shared-core capability under platform-only names without an ownership note.

### MIPD-F5: Settings schema is promising, but the service defaults all settings to `platform`

Classification: `instance_config_gap`  
Priority: P2  

References:

- `database/migrations/2026_04_09_000003_create_settings_table.php:13`
- `database/migrations/2026_04_09_000003_create_settings_table.php:14`
- `database/migrations/2026_04_09_000003_create_settings_table.php:15`
- `database/migrations/2026_04_09_000003_create_settings_table.php:27`
- `app/Platform/Settings/SettingsService.php:13`
- `app/Platform/Settings/SettingsService.php:38`
- `app/Http/Controllers/Platform/SettingsController.php:272`
- `app/Http/Controllers/Platform/SettingsController.php:296`

Risk:

Settings can be isolated by using a separate database per mirror, but the application-level scope language remains `platform`. That is acceptable for current internal platform use, but it is not yet a reusable shared-core settings contract.

Expected future contract:

Settings should clearly separate instance-local settings from platform-management-only settings and future tenant-local settings. The scope names should be intentional and documented.

Current behavior:

The settings table has `scope_type`, `scope_id`, and `module_key`, which is a useful boundary seed. The service defaults `scopeType` to `platform`. Settings pages store user, docs, audit, notification, and email settings through that default.

Recommended correction:

For platform-2, document that settings are instance-local because the database is separate. In a later pass, add an explicit `instance` or `app_instance` scope strategy before treating settings as shared-core reusable.

### MIPD-F6: Operational logs and notifications are database-local, but not instance-aware

Classification: `platform_singleton_coupling`  
Priority: P2  

References:

- `database/migrations/2026_04_08_000001_create_platform_audit_logs_table.php:11`
- `database/migrations/2026_04_08_000002_create_central_error_logs_table.php:13`
- `app/Platform/Logging/PlatformLogger.php:31`
- `app/Platform/Logging/PlatformLogger.php:72`
- `app/Platform/Logging/PlatformLogger.php:73`
- `database/migrations/2026_04_09_000004_create_notifications_table.php:14`
- `database/migrations/2026_04_09_000004_create_notifications_table.php:15`
- `app/Platform/Notifications/NotificationService.php:126`
- `routes/channels.php:6`
- `app/Http/Controllers/Platform/BroadcastAuthController.php:16`

Risk:

With separate databases, audit logs, error logs, and notifications stay separate for platform-1 and platform-2. However, the records and broadcast channel names do not carry an instance identity. If operational tooling later aggregates records or shares Reverb infrastructure, instance provenance and channel separation become ambiguous.

Expected future contract:

Audit/error events and notification broadcast surfaces should be instance-aware. A future tenant context should include tenant key when present, but the mirror proof also needs an app instance key.

Current behavior:

Audit logs are in `platform_audit_logs` and do not have an instance or tenant key column. Central error logs include nullable `tenant_key`, but the logger only writes it if provided in context. Notifications are morph-scoped to the notifiable user. Broadcast authorization uses `App.Models.User.{id}` channel naming.

Recommended correction:

Add instance identity to operational context before or during platform-2 proof. At minimum, runtime check output and log metadata should state instance key. If shared Reverb is used, channel naming or Reverb app IDs must be instance-separated.

### MIPD-F7: Dashboard and navigation mix shared-core and platform-management capabilities

Classification: `route_surface_gap`  
Priority: P2  

References:

- `config/navigation.php:4`
- `config/navigation.php:13`
- `config/navigation.php:24`
- `config/navigation.php:30`
- `config/navigation.php:82`
- `config/navigation.php:89`
- `app/Platform/Dashboard/WidgetRegistry.php:64`
- `app/Platform/Dashboard/WidgetRegistry.php:68`
- `app/Providers/AppServiceProvider.php:42`
- `app/Filament/Widgets/SecurityReadinessWidget.php:21`

Risk:

The current shell can be mirrored, but dashboard widgets and navigation groups do not yet declare whether they are shared instance-core or platform-management. This increases the chance that internal-only surfaces such as docs vault, UI Reference, and security checklist leak into future tenant-like contexts.

Expected future contract:

Navigation and widgets should be selected by context capability: shared-core items appear in both platform and future tenant/admin contexts; platform-management items appear only in platform context.

Current behavior:

Navigation groups include Dashboard and Notifications beside Documentation Vault, UI Reference, Security Checklist, settings, setup pages, audit logs, and error logs. Widget defaults include `platform_stats`, `error_health`, `audit_activity`, `notifications_summary`, and `security_readiness`.

Recommended correction:

Add a capability classification map for navigation groups and dashboard widgets. Keep the current UI unchanged for the platform-2 mirror, but make ownership explicit before tenant admin surfaces are introduced.

### MIPD-F8: Platform-only surfaces are correctly platform-facing today, but need an exclusion contract

Classification: `platform_only_correct`  
Priority: P3  

References:

- `routes/web.php:108`
- `routes/web.php:138`
- `routes/web.php:139`
- `config/navigation.php:24`
- `config/navigation.php:30`
- `routes/console.php:21`
- `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:82`
- `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:83`
- `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:84`

Risk:

These surfaces are fine in the current internal platform and in a direct platform-2 mirror, but they should not be treated as shared-core features for future customer/tenant contexts.

Expected future contract:

Docs vault, UI Reference, security checklist, runtime readiness, future tenant registry/provisioning, and support handoff should remain platform-management capabilities unless explicitly reclassified.

Current behavior:

Security Checklist, docs vault, and UI Reference are routed under `/platform/*`. The runtime readiness command is platform-specific. Navigation gates these surfaces with platform permissions.

Recommended correction:

Document a platform-management exclusion list in the next implementation plan. The platform-2 mirror can keep these surfaces enabled as an internal mirror, but tenantization work should require explicit opt-in before exposing them outside platform context.

### MIPD-F9: Canonical tenant safety standards do not yet cover multi-instance runtime readiness

Classification: `docs_mismatch`  
Priority: P3  

References:

- `docs/02-standards/security/Tenant Safety Standards.md:11`
- `docs/02-standards/security/Tenant Safety Standards.md:14`
- `docs/03-architecture/platform-boundary.md:19`
- `docs/07-planning/phases/phase-2/Phase 2 - Route And Panel Ownership Map.md:169`

Risk:

The existing standards cover important tenant safety rules, but they do not yet define the intermediate platform-2 mirror readiness requirements: app instance identity, cache/session/broadcast separation, route capability classification, and mirrored-instance validation.

Expected future contract:

Canonical docs should distinguish three stages:

- multi-instance internal mirror readiness
- platform-management control-plane boundaries
- true tenant isolation and provisioning

Current behavior:

Tenant safety standards are concise and tenant-focused. The route ownership map says unclear panel ownership and route convergence are blockers, not fully implemented tenancy.

Recommended correction:

After this audit is accepted, update canonical architecture, standards, database, and runbook docs in a separate implementation pass. Do not fold this into the review-only audit.

### MIPD-F10: Full tenancy package rollout should remain deferred

Classification: `future_tenant_defer`  
Priority: P3  

References:

- `docs/03-architecture/tenancy.md:5`
- `docs/07-planning/phases/phase-1/Tenancy And Provisioning Foundation.md:15`
- `docs/07-planning/phases/phase-1/Tenancy And Provisioning Foundation.md:42`
- `docs/07-planning/phases/phase-1/Tenancy And Provisioning Foundation.md:51`
- `docs/07-planning/phases/phase-1/Tenancy And Provisioning Foundation.md:62`

Risk:

Jumping directly into a tenancy package or tenant resolver before proving basic mirrored-instance decoupling would mix too many risks: routing, database provisioning, support access, RBAC, and app-instance configuration.

Expected future contract:

The next implementation should prove two internal mirrors first. Full tenant resolver, tenant DB role provisioning, tenant domains, tenant-local modules, and support handoff should remain separate later work.

Current behavior:

Planning already says shared core comes first, later tenantization follows, and the platform instance should be treated as the first internal consumer of the shared core app.

Recommended correction:

Sequence the next pass as platform-2 mirror readiness, not tenantization. Treat a tenancy package decision as a later architecture decision once mirrored instance boundaries are validated.

## Valid Existing Boundaries

- Canonical docs do not claim tenant isolation exists today. Tenancy is explicitly planned and not implemented.
- The platform boundary doc already separates platform context from tenant context.
- The route ownership map already states that shared-core routes should not permanently depend on `platform`.
- Settings schema has `scope_type`, `scope_id`, and `module_key`, which gives future scoping room even though current defaults are platform-oriented.
- Error logs already include `tenant_key`, which can become useful once a real tenant context exists.
- Security checklist Definitions tracks authorization and tenant-boundary evidence as an open area rather than completed proof.
- Database separation is mostly environment-driven, which supports a mirror proof if the surrounding mutable runtime state is also separated.

## Recommended Follow-Up Order

1. Define app instance identity and runtime separation requirements.
   - Add config/runbook support for `platform-1` and `platform-2` instance keys, URLs, DBs, Redis/cache/session/broadcast namespaces, and ports.
   - Add runtime-readiness checks that report the active instance identity and warn when mirror-critical namespaces are missing.

2. Create a shared-core versus platform-management capability inventory.
   - Classify routes, route names, gates, nav items, widgets, settings groups, and seed permissions.
   - Keep existing names initially, but stop adding new shared-core capability without an ownership classification.

3. Plan a minimal platform-2 mirror proof.
   - Add a runbook and optional env sample.
   - Migrate and seed a second database.
   - Verify separate users, roles, MFA enrollment, settings, notifications, audit logs, and error logs.
   - Verify platform-1 cannot see platform-2 mutable data and vice versa.

4. Add operational provenance.
   - Include app instance identity in runtime checks, audit/error metadata where appropriate, and deployment verification output.
   - Decide whether audit table schema needs an `instance_key` column or whether database separation plus application logs is enough for the mirror phase.

5. Update canonical docs after implementation is approved.
   - Architecture: platform mirror stage and shared-core/control-plane classification.
   - Standards: multi-instance runtime separation rules.
   - Database: mirror proof database boundary and what remains unimplemented for true tenancy.
   - Runbooks: local/deployment platform-2 proof commands.

6. Defer true tenantization.
   - Do not add tenant resolver, tenant domain registry, tenant DB provisioning, customer tenant modules, or support handoff until the mirror proof is stable.

## Implementation Planning Notes

- The next implementation pass should likely be config/runbook/readiness work, not route renaming.
- Keep `platform-2` framed as an internal mirror proof.
- Do not claim ASVS tenant isolation, customer tenant readiness, or cross-tenant access prevention from this audit.
- Current role/permission names may remain temporarily platform-prefixed, but new shared-core work should be cataloged.
- Separate database is necessary but not sufficient; cache, Redis, queue, session, and broadcast state also need separation.
- Platform-only surfaces can remain enabled in the platform-2 mirror if the mirror is explicitly internal.

## Implementation Notes

2026-07-02 module-classification foundation:

- Added typed module definitions and a repository that classify current routes, permissions, navigation entries, dashboard widgets, settings groups, owned tables, commands, and setup routes as `core`, `shared`, or `platform_management`.
- Added ownership coverage tests so app-owned routes, navigation routes, dashboard widgets, and seeded platform permissions must have exactly one module owner.
- Added the read-only `platform:modules:list` command for safe Definitions inspection.
- Added the canonical Module System architecture doc and linked it from the architecture index.
- Partially addresses MIPD-F3, MIPD-F4, MIPD-F7, and MIPD-F8 by creating ownership evidence without changing runtime behavior.
- Leaves MIPD-F1, MIPD-F2, MIPD-F5, MIPD-F6, MIPD-F9, and MIPD-F10 as follow-up work for instance identity, runtime separation, persisted module state, operational provenance, canonical docs sync, and later tenancy sequencing.

## Validation Performed

Read-only review only. No code, config, migrations, tests, canonical owner docs, or `/docs/08-active/` files were modified for this audit.

Validation steps:

- Reviewed applicable docs governance instructions.
- Reviewed architecture, planning, and tenant safety docs listed above.
- Inspected route, config, seeder, settings, dashboard, navigation, notification, audit, error-log, and runtime-readiness surfaces with targeted text searches and scoped file reads.
- Confirmed no existing file named `doc-review-2026-07-02-multi-instance-platform-decoupling-readiness.md` was present before creating this artifact.

## Out Of Scope

- Tenant resolver implementation
- Tenant database provisioning
- Tenant domain registry
- Tenant support handoff
- Customer tenant modules
- Route renaming or route aliasing
- RBAC redesign
- Security Checklist Definitions updates
- Canonical architecture/standards/database/runbook updates
- Code, config, migration, or test changes
- `/docs/08-active/` changes
