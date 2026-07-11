<!--
DOC-META
title: ADR-0007: Owner, Registry, And Identifier Key Conventions
doc_type: decision
status: active
owner: architecture
canonical: true
canonical_path: docs/01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md
parent: docs/01-decisions/index.md
template: docs/09-reference/templates/docs/_decision.md
summary: Records canonical ownership, registry, permission, route, notification, audit, configuration, job, event, listener, queue, and compatibility-key conventions.
-->

# ADR-0007: Owner, Registry, And Identifier Key Conventions

Parent: [Decisions Index](index.md)

## 1. Decision Status

Accepted

## 2. Dates

- Proposed: 2026-07-10
- Accepted, rejected, deprecated, or superseded: 2026-07-10

## 3. Decision Owner

- Owner: Login 2.0 architecture owner
- Required reviewers: repository owner; architecture reviewer; registry and configuration reviewer; security reviewer; UI-system reviewer
- Acceptance source: explicit repository-owner approval recorded in GitHub issue #28 and the associated pull request

## 4. Related Work

- GitHub issue: [#28 — Define owner-key and registry-key conventions](https://github.com/kyleswindell/login-v2/issues/28)
- Parent goal: [#17 — M0 Goal 01: Canonical vocabulary and ownership](https://github.com/kyleswindell/login-v2/issues/17)
- Prior decisions:
  - [ADR-0005: Core, Modules, And UI Ownership Taxonomy](adr-0005-core-modules-ui-ownership-taxonomy.md)
  - [ADR-0006: Tenant, Instance, Workspace, Principal, Actor, And Invocation Vocabulary](adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- Canonical standard: [Identifier And Key Standards](../02-standards/coding/Identifier%20And%20Key%20Standards.md)
- Planning matrix: [Core Service Build Plan Matrix](../07-planning/core-service-build-plan-matrix.md)
- Pull request: pending

## 5. Context

The repository currently uses inconsistent formats for owner keys, Module keys, permissions, routes, registry entries, notifications, audit events, configuration, jobs, events, listeners, queues, UI contracts, and compatibility aliases.

Several identifiers also conflate ownership, capability identity, physical placement, package identity, URL structure, or presentation labels. That ambiguity prevents deterministic discovery, collision handling, migration planning, and cross-owner contracts.

ADR-0005 established Core, Modules, and UI as source-of-truth ownership areas. ADR-0006 established Tenant, Instance, Workspace, Principal, Actor, and Invocation Channel vocabulary. Issue #28 now establishes the key system used across those accepted models.

## 6. Decision Drivers

- deterministic machine-readable identifiers
- separation of ownership from capability and package identity
- stable keys across physical moves and URL migrations
- predictable registry and contribution discovery
- explicit collision and uniqueness boundaries
- secure and reviewable permission and audit identifiers
- compatibility without allowing aliases to become competing canonical keys
- consistency across PHP, Laravel, Blade, Composer, configuration, queues, and documentation

## 7. Decision

### 7.1 Canonical Grammar

Internal key segments use lowercase ASCII snake case:

```text
[a-z][a-z0-9_]*
```

Hierarchical segments use a period:

```text
segment.segment_name.action
```

Canonical internal keys must not use:

- uppercase characters
- spaces
- hyphens
- slashes
- repeated periods
- leading or trailing periods
- physical folder or namespace prefixes unless the identifier family explicitly requires them

Do not derive canonical keys from physical folders, PHP namespaces, PHP classes, controller names, URLs, route paths, display labels, or Composer package names.

Framework-specific identifiers may retain their native syntax when they are stored separately rather than used as canonical internal keys. Examples include Composer package names, PHP namespaces, Blade aliases, URLs, and environment variables.

### 7.2 Ownership Fields

Ownership identity and key identity remain separate.

```text
ownership_area: core | module | ui
owner_key: identity | access | notifications | projects | ui
capability_key: users | roles | global_administration | projects
module_key: projects | quickbooks_sync
```

`ownership_area` identifies the source-of-truth ownership category established by ADR-0005.

`owner_key` identifies the precise owner responsible for behavior, state, contracts, review, and migration.

`capability_key` identifies a stable functional capability independent of physical owner or path.

`module_key` identifies an optional Module package independently from Composer package identity.

These fields must not be collapsed even when two values currently match.

### 7.3 Owner Keys

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

`Platform` is not an owner-key root.

### 7.4 Capability Keys

Capability keys are stable functional identifiers such as:

```text
users
roles
global_administration
audit
notifications
projects
```

Capability keys remain independent of owner keys so ownership may move without renaming the capability.

### 7.5 Module Keys

Module keys are globally unique snake-case identifiers such as:

```text
projects
quickbooks_sync
orders
calendar
```

Do not prefix Module keys with `module_`, `business_`, or `platform_`.

Composer package identity remains separate:

```text
module_key: projects
composer_package: parasolutions/login-projects
```

### 7.6 Registry Keys

A registry key identifies the registry or extension point.

Examples:

```text
ui.navigation
ui.contracts
settings.pages
setup.steps
dashboard.widgets
```

Registry keys are globally unique within the registry-key family.

### 7.7 Contribution Keys

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

Contribution keys must be unique within their registry.

### 7.8 UI Keys

Canonical UI machine keys use explicit type prefixes:

```text
component.modal
pattern.auth.challenge_form
layout.app
surface.global_administration.tenants
contract.data_table
```

Framework aliases remain separate:

```text
component_key: component.modal
blade_alias: x-ui.modal
```

`platform_surface_key` is retired. Use the precise family: `surface_key`, `ui_entry_key`, `contract_key`, `component_key`, `pattern_key`, or `layout_key`.

### 7.9 Permission Keys

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

Use common CRUD-style actions when they accurately describe the operation. Use domain verbs only when CRUD is insufficient.

Permission ownership remains a separate `owner_key`.

### 7.10 Route Names

Route names use capability-first dotted keys:

```text
users.index
users.update
projects.show
global_administration.tenants.update
```

Route names must not be derived from folder paths, controller namespaces, URL prefixes, or owner keys unless the capability itself uses that key.

URLs remain independently migratable.

### 7.11 Notification Type Keys

Notification type keys are domain-first dotted identifiers:

```text
security.service_account.credential_expiring
identity.user_account.suspended
projects.project_assigned
```

Notification ownership remains separate.

### 7.12 Audit Event Keys

Audit event keys are domain-first and use completed-event wording:

```text
auth.login_succeeded
identity.user_account_suspended
access.role_updated
data.export_downloaded
projects.project_archived
```

Audit-event ownership remains separate from the event key.

### 7.13 Configuration Namespaces

Configuration roots use the capability or Module key:

```text
identity.users.default_active
notifications.delivery.database
projects.retention_days
```

Do not use `platform.*` as a generic configuration root.

Environment variables and framework configuration filenames may use native conventions while mapping to canonical configuration keys.

### 7.14 Job Keys

Job identifiers use capability plus imperative operation:

```text
reports.generate
notifications.deliver
quickbooks_sync.import_customers
```

A job key identifies work, not the Actor or Invocation Channel.

### 7.15 Domain Event Keys

Domain event identifiers use capability plus completed-event wording:

```text
identity.user_account_suspended
projects.project_created
orders.order_submitted
```

### 7.16 Listener Keys

Stable listener identifiers use consumer owner plus handler purpose:

```text
notifications.send_user_suspension_notice
audit.record_project_archival
search.index_customer_created
```

A stable listener key is required only when registration, configuration, observability, ordering, retry policy, compatibility, or lifecycle management requires one.

### 7.17 Queue Keys

Logical queue keys identify broad operational lanes:

```text
default
notifications
exports
integrations
```

Provider-specific and environment-specific queue names map to these logical keys outside the canonical application vocabulary.

### 7.18 Compatibility Aliases

Compatibility aliases are one-way mappings from a legacy key to one canonical key.

Each alias must define:

- legacy key
- canonical key
- owning capability
- reason
- compatibility surface
- removal condition
- follow-up issue or migration owner

Aliases:

- must not be reused
- must not form chains
- must not be treated as equally canonical
- must not create ambiguous reverse lookup
- must fail explicitly when the target key no longer exists

Arbitrary invalid keys must be rejected. They must not be silently normalized into accepted keys.

### 7.19 Collision And Uniqueness

The following key families are globally unique within their own family:

- owner keys
- capability keys
- Module keys
- registry keys
- UI machine keys by UI key family
- permission keys
- route names
- notification type keys
- audit event keys
- configuration roots and full keys
- job keys
- domain event keys
- stable listener keys
- logical queue keys

Contribution keys are unique within their registry.

Uniqueness across different key families is not required, because the family is part of the identifier contract.

## 8. Scope And Boundaries

### Applies To

- Core capability definitions
- Modules and package manifests
- UI contracts, entries, Surfaces, and registries
- permissions and policies
- route names
- notification types
- audit events
- configuration
- jobs, events, listeners, and queues
- compatibility and migration maps
- documentation and test fixtures

### Does Not Apply To

- PHP class names
- PHP namespaces
- Composer package syntax
- Blade component aliases
- URLs and route paths
- database physical column names unless a schema standard adopts the same key
- user-facing labels

### Transition Boundary

Current keys may remain temporarily when mapped explicitly. New keys must follow this decision.

This decision does not authorize broad runtime renaming or compatibility-adapter implementation.

## 9. Alternatives Considered

### Alternative A — Prefix Every Key With Ownership Area

Not selected because ownership and key identity are separate, and ownership may change without changing capability identity.

### Alternative B — Use Hyphenated Keys Everywhere

Not selected because snake-case segments align with PHP arrays, configuration, database values, and existing application conventions while periods preserve hierarchy.

### Alternative C — Derive Keys From Classes, Paths, Or URLs

Not selected because physical placement and URLs are migratable implementation details.

### Alternative D — Use Composer Package Names As Module Keys

Not selected because package distribution identity and application Module identity answer different questions.

### Alternative E — Treat Aliases As Equal Canonical Keys

Not selected because it creates permanent ambiguity and collision risk.

## 10. Consequences

### Positive

- deterministic key generation and validation
- stable identifiers across physical moves
- explicit ownership and capability separation
- predictable registry and contribution lookup
- clearer permission and audit review
- bounded compatibility migrations
- simpler collision detection and testing

### Negative

- existing mixed-format keys require inventory and gradual migration
- several current `platform.*`, hyphenated, class-derived, or path-derived identifiers will need mappings
- some records require separate owner and capability fields instead of one overloaded string

### Security, Privacy, And Data

- permission and audit identifiers become easier to review and deny by default
- aliases cannot silently broaden authority
- configuration and queue keys avoid environment-specific leakage into canonical contracts
- user-facing or sensitive values must not be embedded in keys

### Operational And Migration

- no immediate runtime rename is required
- new work must use canonical formats
- later M0 goals own physical migration, compatibility adapters, and repository-wide enforcement
- the next available ADR identifier becomes ADR-0008

## 11. Implementation Implications

- key validation helpers and contract schemas
- registry collision detection
- permission and route inventories
- Module manifest normalization
- UI contract-key validation
- notification and audit-event registries
- configuration mapping
- job, event, listener, and queue observability
- compatibility alias registry
- migration tests and deprecation reporting

## 12. Canonical Documentation Updates

### Create

- `docs/01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md`
- `docs/02-standards/coding/Identifier And Key Standards.md`

### Update

- `docs/01-decisions/index.md`
- `docs/02-standards/coding/index.md`
- `docs/07-planning/core-service-build-plan-matrix.md`
- GitHub issue #28

### Bounded Follow-Up

Later work must inventory and disposition keys in:

- Core and Module definitions
- registries and contribution contracts
- permissions and policies
- route names
- notifications
- audit events
- configuration
- jobs, events, listeners, and queues
- UI contracts
- tests and documentation

## 13. Verification

Confirm:

- ADR identifier and filename are unique
- every example follows the canonical grammar
- ownership fields remain separate
- registry contribution uniqueness is explicit
- aliases are one-way and non-chained
- Platform is not used as a generic owner or configuration root
- issue #28 acceptance criteria and propagation targets are synchronized
- documentation guardrails pass

## 14. Supersession

### Supersedes

- no active ADR
- supersedes conflicting planning recommendations that conflate owner, capability, Module, package, URL, or physical path identity

### Superseded By

- None

## 15. Acceptance Or Rejection Record

- Outcome: Accepted
- Date: 2026-07-10
- Accepted or rejected by: Login 2.0 repository owner
- Evidence: explicit approval in GitHub issue #28 and the associated pull request
- Required follow-up: Goals 03, 07, 08, and 09; key inventory and compatibility migration issues

## 16. Related

- [Decisions Index](index.md)
- [Identifier And Key Standards](../02-standards/coding/Identifier%20And%20Key%20Standards.md)
- [Core Service Build Plan Matrix](../07-planning/core-service-build-plan-matrix.md)
- Related GitHub issue: [#28](https://github.com/kyleswindell/login-v2/issues/28)
