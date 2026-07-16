<!--
DOC-META
title: Identifier And Key Standards
doc_type: standard
status: active
owner: architecture
canonical: true
canonical_path: docs/02-standards/coding/Identifier And Key Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines canonical ownership, capability, Module, registry, permission, route, notification, audit, configuration, job, event, listener, queue, UI, and compatibility key conventions.
-->

# Identifier And Key Standards

Parent: [Coding Standards Index](index.md)

## 1. Purpose

Provide deterministic, stable, collision-safe machine identifiers across Core, Modules, UI, registries, permissions, routes, notifications, audit events, configuration, jobs, events, listeners, queues, and compatibility mappings.

This standard implements [ADR-0007](../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md).

## 2. Canonical Grammar

Internal key segments use lowercase ASCII snake case:

```text
[a-z][a-z0-9_]*
```

Hierarchical segments use periods:

```text
segment.segment_name.action
```

Canonical internal keys must not use uppercase characters, spaces, hyphens, slashes, repeated periods, leading periods, or trailing periods.

Do not derive canonical keys from physical folders, PHP namespaces, PHP classes, controller names, URLs, route paths, display labels, or Composer package names.

Framework-native identifiers may retain their own syntax when stored separately, including Composer packages, PHP namespaces, Blade aliases, URLs, and environment variables.

## 3. Ownership And Identity Fields

Keep these fields distinct:

```text
ownership_area: core | module | ui
owner_key: identity | access | notifications | projects | ui
capability_key: users | roles | global_administration | projects
module_key: projects | quickbooks_sync
```

- `ownership_area` identifies Core, Module, or UI ownership.
- `owner_key` identifies the precise source-of-truth owner.
- `capability_key` identifies stable functional behavior.
- `module_key` identifies an optional Module independently from package identity.

Do not collapse these fields even when values match.

## 4. Owner Keys

Owner keys are globally unique within the owner-key family and use one snake-case segment.

Examples:

```text
auth
identity
access
security
audit
notifications
data_governance
data_protection
supply_chain
offensive_testing
projects
ui
```

Do not prefix owner keys with `core`, `module`, `platform`, or a folder name.

`Platform` is not a canonical owner-key root.

## 5. Capability Keys

Capability keys are stable functional identifiers independent of ownership and physical placement.

Examples:

```text
users
roles
global_administration
audit
notifications
projects
```

A capability may move between physical locations without changing its key.

## 6. Module And Package Keys

Module keys are globally unique snake-case identifiers.

Examples:

```text
projects
quickbooks_sync
orders
calendar
```

Do not prefix Module keys with `module_`, `business_`, or `platform_`.

Keep Composer package identity separate:

```text
module_key: projects
composer_package: parasolutions/module-projects
```

A future `package_key` must not duplicate `module_key` unless it identifies a materially different packaging concept.

## 7. Registry And Contribution Keys

A registry key identifies a registry or extension point.

Examples:

```text
ui.navigation
ui.contracts
settings.pages
setup.steps
dashboard.widgets
```

Registry keys are globally unique within the registry-key family.

A contribution key identifies one contribution inside a registry and is owner-prefixed.

Examples:

```text
projects.index
notifications.header_bell
identity.user_defaults
```

The canonical contribution identity is:

```text
(registry_key, contribution_key)
```

Contribution keys are unique within their registry.

Registries must reject duplicate canonical contribution identities. They must not silently replace an existing contribution.

## 8. UI Keys

Canonical UI machine keys use explicit family prefixes:

```text
component.modal
pattern.auth.challenge_form
layout.app
surface.global_administration.tenants
contract.data_table
```

Keep framework aliases separate:

```text
component_key: component.modal
blade_alias: x-ui.modal
```

Retire `platform_surface_key`. Use `surface_key`, `ui_entry_key`, `contract_key`, `component_key`, `pattern_key`, or `layout_key` according to the actual family.

## 9. Permission Keys

Permission keys use:

```text
<capability>.<action>
<capability>.<subresource>.<action>
```

Examples:

```text
users.view
users.create
users.update
users.roles.update
projects.archive
```

Use common CRUD-style actions when accurate. Use domain verbs only when CRUD is insufficient.

Permission ownership remains a separate `owner_key`.

Do not derive permissions from route names, controllers, policies, or UI labels.

## 10. Route Names

Route names are capability-first dotted keys.

Examples:

```text
users.index
users.update
projects.show
global_administration.tenants.update
```

Route names must not be derived from folder paths, controller namespaces, URL prefixes, or owner keys unless the capability itself uses that key.

URLs remain independently migratable.

## 11. Notification Type Keys

Notification type keys are domain-first dotted identifiers.

Examples:

```text
security.service_account.credential_expiring
identity.user_account.suspended
projects.project_assigned
```

Store notification ownership separately.

## 12. Audit Event Keys

Audit event keys are domain-first and use completed-event wording.

Examples:

```text
auth.login_succeeded
identity.user_account_suspended
access.role_updated
data.export_downloaded
projects.project_archived
```

Store audit-event ownership separately.

## 13. Configuration Namespaces

Configuration roots use the capability or Module key.

Examples:

```text
identity.users.default_active
notifications.delivery.database
projects.retention_days
```

Do not use `platform.*` as a generic configuration root.

Environment variables and framework configuration filenames may use native syntax while mapping to canonical configuration keys.

## 14. Jobs, Events, Listeners, And Queues

Job identifiers use capability plus imperative operation:

```text
reports.generate
notifications.deliver
quickbooks_sync.import_customers
```

Domain-event identifiers use capability plus completed-event wording:

```text
identity.user_account_suspended
projects.project_created
orders.order_submitted
```

Stable listener identifiers use consumer owner plus handler purpose:

```text
notifications.send_user_suspension_notice
audit.record_project_archival
search.index_customer_created
```

A stable listener key is required only when registration, configuration, observability, ordering, retry policy, compatibility, or lifecycle management requires one.

Logical queue keys identify broad operational lanes:

```text
default
notifications
exports
integrations
```

Map provider-specific and environment-specific queue names outside the canonical application vocabulary.

A job, event, listener, or queue key identifies execution behavior or infrastructure. It does not identify the Actor or Invocation Channel.

Application Registration metadata references these existing canonical identifier families. It must keep owner identity, artifact family, and canonical artifact identity separate rather than manufacturing competing `registration.*` route, configuration, event, job, contribution, or asset keys.

## 15. Collision And Uniqueness Rules

These key families are globally unique within their own family:

- owner keys
- capability keys
- Module keys
- registry keys
- UI keys within each UI family
- permission keys
- route names
- notification type keys
- audit event keys
- configuration roots and full keys
- job keys
- domain-event keys
- stable listener keys
- logical queue keys

Contribution keys are unique within their registry.

Uniqueness across different families is not required because the family is part of the identifier contract.

Registries and validation tooling must reject duplicate canonical keys rather than silently replace earlier registrations.

## 16. Compatibility Aliases

Compatibility aliases are one-way mappings from one legacy key to one canonical key.

Each alias must define:

- legacy key
- canonical key
- owning capability
- reason
- compatibility surface
- removal condition
- follow-up issue or migration owner

Aliases must not be reused, chained, presented as equally canonical, or create ambiguous reverse lookup.

An alias must fail explicitly when its canonical target no longer exists.

Reject arbitrary invalid keys. Do not silently normalize them into accepted keys.

## 17. Validation

New or changed key definitions must verify:

- grammar
- family
- uniqueness boundary
- owner relationship
- compatibility status
- no forbidden `platform.*` ownership root
- no dependency on physical path, class, URL, or display label

Tests should cover representative valid and invalid examples and duplicate registration behavior.

## 18. Migration Rules

Existing incompatible keys may remain temporarily when documented through an explicit compatibility mapping.

Do not perform repository-wide renaming opportunistically.

Each migration must identify affected configuration, routes, permissions, registries, UI contracts, notifications, audit events, jobs, events, listeners, queues, tests, and documentation.

New work must use canonical keys immediately unless a documented compatibility constraint prevents it.

## 19. Examples

Core example:

```text
ownership_area: core
owner_key: identity
capability_key: users
permission_key: users.update
route_name: users.update
audit_event_key: identity.user_account_updated
config_key: identity.users.default_active
```

Module example:

```text
ownership_area: module
owner_key: projects
module_key: projects
composer_package: parasolutions/module-projects
permission_key: projects.update
route_name: projects.update
registry_key: ui.navigation
contribution_key: projects.index
```

### Invalid Examples

| Invalid value                  | Reason                                                    |
| ------------------------------ | --------------------------------------------------------- |
| `Platform.Roles`               | Uppercase characters and a retired generic Platform root. |
| `data-governance.export`       | Hyphenated internal segment.                              |
| `core.identity`                | Ownership-area prefix embedded in an owner key.           |
| `module.projects`              | Ownership-area prefix embedded in a Module key.           |
| `projects..archive`            | Repeated period.                                          |
| `.users.view`                  | Leading period.                                           |
| `users.view.`                  | Trailing period.                                          |
| `projects/archive`             | Slash used inside a canonical internal key.               |
| `parasolutions/login-projects` | Composer package identity used as a Module key.           |
| `platform_surface_key`         | Retired ambiguous UI-key family.                          |

Framework-native values such as `x-ui.modal`, `/platform/roles`, `App\\Core\\Identity`, and `PARASOLUTIONS_API_KEY` remain valid only in their separate alias, path, namespace, or environment-variable fields. They are not canonical internal keys.

## 20. Prohibited Practices

Do not:

- overload one key with ownership, capability, package, route, and presentation meaning
- prefix all keys with ownership area
- use `platform` as a generic owner or configuration root
- derive keys from classes, paths, URLs, or labels
- use aliases as competing canonical identities
- silently accept duplicate registry contributions
- silently normalize arbitrary invalid keys
- use hyphenated internal key segments
- rename keys without compatibility and propagation review

## 21. Related

- [ADR-0005](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
- [ADR-0006](../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [ADR-0007](../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Events Jobs And Queue Standards](Events%20Jobs%20And%20Queue%20Standards.md)
- [Repository Naming Standards](repository-naming-standards.md)
- [Feature Development Standards](Feature%20Development%20Standards.md)
- [Core Service Build Plan Matrix](../../07-planning/core-service-build-plan-matrix.md)
