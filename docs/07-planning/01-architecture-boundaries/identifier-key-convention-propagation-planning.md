# Identifier Key Convention Propagation Planning

Status: Active planning inventory

## Purpose

Track propagation of [ADR-0007](../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md) and [Identifier And Key Standards](../../02-standards/coding/Identifier%20And%20Key%20Standards.md) without treating documentation acceptance as authorization for runtime renaming.

Issue #28 aligns the canonical documentation contract. Runtime, route, schema, package, alias-adapter, and broad source migrations remain deferred to their owning GitHub issues and milestones.

## Disposition Vocabulary

| Disposition | Meaning |
| --- | --- |
| aligned | Canonical documentation now uses the accepted contract. |
| compatibility-only | Existing runtime value may remain temporarily but is not canonical for new work. |
| follow-up issue | A later bounded issue must inventory or migrate the runtime surface. |
| retain | Framework-native or physical identity remains separate and unchanged. |
| supersede | Conflicting planning advice is replaced by ADR-0007 and the canonical standard. |

## Propagation Inventory

| Key family | Current examples or condition | Canonical target | Affected files or owners | Compatibility need | Migration owner | Blocking issue or milestone | Disposition |
| --- | --- | --- | --- | --- | --- | --- | --- |
| Ownership identity | `owner layer`; capability, package, and owner names used interchangeably | separate `ownership_area`, `owner_key`, `capability_key`, and optional `module_key` | registry standards, manifests, future Core and Module definitions | Existing columns may require mapping | Architecture and registry owners | M0 acceptance complete; runtime migration deferred | aligned in canonical docs; follow-up issue for source/schema |
| Owner keys | `core.<owner>`, `module.<owner>`, or `platform.*` roots | one snake-case owner segment such as `identity`, `access`, or `projects` | capability definitions, registries, configuration | Explicit one-way aliases where released values exist | Owning capability plus registry infrastructure | Future capability/package migration | compatibility-only |
| Capability keys | Functional identity inferred from physical owner | stable functional key such as `users`, `roles`, or `global_administration` | permissions, routes, settings, feature contracts | Preserve released capability identifiers | Owning Core capability or Module | Per-capability implementation issue | aligned in docs; follow-up issue for runtime |
| Module keys | Composer package or prefixed values such as `module.projects` | independent snake-case key such as `projects` or `quickbooks_sync` | Module manifests and package loader | Package name remains separate; legacy keys may need aliases | Module/package registry owner | Physical package loader migration | compatibility-only |
| Registry contributions | Single vague stable key or owner-derived target | `(registry_key, contribution_key)` with duplicate rejection | registry projections, sync services, seeders | Released pair renames require explicit aliases | Registry infrastructure and contributing owner | Future registry schema/runtime issue | aligned in database standard; runtime deferred |
| UI keys | `platform_surface_key`, Blade alias, or source path treated as API identity | precise `component_key`, `pattern_key`, `layout_key`, `surface_key`, `ui_entry_key`, or `contract_key` | UI API registry and component contract tooling | Keep current Blade aliases and paths separate | UI owner | Bounded UI registry migration | deprecated for new work; follow-up issue |
| Permission keys | legacy `platform.*` or owner/path-derived names | capability-first keys such as `users.roles.update` | Access, permission definitions, route authorization | One-way aliases or assignment migration may be required | Access plus capability owner | Per-capability permission migration | compatibility-only |
| Route names | physical owner, URL prefix, or controller-derived names | capability-first names such as `users.index` | route declarations, links, tests | Existing route names remain until bounded migration | Owning capability or Module | Route migration timing remains open | retain current runtime; follow-up issue |
| Notification types | direct producer strings or ownership conflation | domain-first keys such as `identity.user_account.suspended` | Notifications registry and domain producers | Persisted historical type keys may require aliases | Domain owner plus Notifications | Notification registry migration | aligned in docs; follow-up issue |
| Audit events | mixed action tense or source-path vocabulary | completed-event keys such as `access.role_updated` | Audit catalog and domain producers | Historical evidence must remain interpretable | Domain owner plus Audit | Audit foundation and catalog work | aligned in docs; follow-up issue |
| Configuration | generic `platform.*` roots | capability or Module roots such as `notifications.delivery.database` | configuration definitions and settings registries | Environment variables and framework filenames remain separate | Owning capability or Module | Per-capability configuration migration | compatibility-only |
| Jobs | class, queue, Actor, or channel used as identity | imperative work key such as `reports.generate` | jobs, scheduling, observability | Existing class names remain framework-native | Job-owning capability or Module | Bounded async-runtime issue | aligned in standard; runtime deferred |
| Domain events | PHP class name treated as canonical event identity | completed-event key such as `projects.project_created` | event catalogs, dispatchers, consumers | PHP class names remain separate | Event-owning domain | Bounded event-contract issue | aligned in standard; runtime deferred |
| Listeners | every PHP listener assumed to need persistence | consumer owner plus purpose only when stable identity is required | registration, retry, ordering, observability | Ordinary PHP listener classes need no alias | Consuming owner | Bounded listener lifecycle issue | aligned in standard |
| Logical queues | provider/environment queue name used as app vocabulary | broad key such as `default`, `notifications`, `exports`, or `integrations` | queue configuration and deployment mapping | Physical queue names remain operational configuration | Ops plus job owner | Queue topology implementation | retain physical mapping; canonical logical key deferred |
| Compatibility aliases | two-way aliases, chains, or silent normalization | one-way `legacy_key -> canonical_key` with owner, reason, surface, removal condition, and migration issue | all released key registries | Required only for real released incompatibilities | Owning key family | Per-family migration issue | aligned in docs; adapters deferred |

## Issue #28 Documentation Alignment

Completed in issue #28:

- ADR-0007 and the canonical Identifier and Key Standards
- Decisions and Coding Standards indexes
- Core Service Build Plan Matrix accepted-key section
- Database Registry Data Standards identity and duplicate rules
- Events, Jobs, and Queue Standards key-family terminology
- UI API Registry identity and alias rules
- this propagation inventory

## Deferred Runtime Work

Issue #28 does not authorize:

- database migrations or registry column renames
- route-name or URL changes
- permission assignment migration
- config-key renames
- Module/package loader changes
- Blade alias or component source-path renames
- notification, audit, job, event, listener, or queue runtime adapters
- arbitrary normalization of invalid keys

Each later implementation issue must name the affected key family, inventory released values, define compatibility and rollback behavior, and verify collisions before changing runtime state.

## Related

- [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
- [ADR-0006: Tenant, Instance, Workspace, Principal, Actor, And Invocation Vocabulary](../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [ADR-0007: Owner, Registry, And Identifier Key Conventions](../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Identifier And Key Standards](../../02-standards/coding/Identifier%20And%20Key%20Standards.md)
- [Core Service Build Plan Matrix](../core-service-build-plan-matrix.md)
- Related GitHub issue: [#28](https://github.com/kyleswindell/login-v2/issues/28)
