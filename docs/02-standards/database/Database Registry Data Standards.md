<!--
DOC-META
title: Database Registry Data Standards
doc_type: standard
status: active
owner: data
canonical: true
canonical_path: docs/02-standards/database/Database Registry Data Standards.md
parent: docs/02-standards/database/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines database standards for registry-backed data including stable keys, ownership, contribution records, setup/settings/notification registries, seeders, lifecycle status, ordering, and documentation.
-->

# Database Registry Data Standards

This document defines database standards for registry-backed data in Login App 2.0.

Registry tables support contributed capabilities, modules, settings, preferences, setup entries, notification types, navigation entries, and other discoverable system metadata.

---

## Purpose

Keep registry data stable, owner-aware, deterministic, documented, and safe to seed or update.

Registries should make system contributions discoverable without turning registry tables into ungoverned configuration dumps.

---

## Scope

This standard applies to database-backed registries such as:

- module registries
- setup registries
- settings registries
- preference registries
- notification type registries
- navigation contribution registries
- UI/reference registries
- capability contribution registries
- integration registries

This standard applies to registry schema, seeders, keys, lifecycle states, documentation, and review expectations.

---

## Core Rule

Every registry entry must have a stable identity, `ownership_area`, `owner_key`, purpose, lifecycle state, and documentation owner.

If a registry entry cannot identify its owner or purpose, it should not be stored.

---

## Registry Versus Setting

Use the distinction consistently.

| Type           | Meaning                                                                                 |
| -------------- | --------------------------------------------------------------------------------------- |
| Registry entry | Defines that a capability, contribution, type, setup item, or configurable item exists. |
| Setting        | Stores an actual configuration value.                                                   |
| Preference     | Stores a user-owned default or experience choice.                                       |
| Runtime state  | Stores changing system state, not registry metadata.                                    |

Do not store runtime state in registry tables.

Do not store user-editable values in registry tables unless the registry explicitly owns editable metadata.

---

## Required Registry Fields

Registry entries should generally define:

- `registry_key`
- `contribution_key`
- `ownership_area`
- `owner_key`
- `capability_key` or `module_key` when applicable
- display label
- description
- lifecycle status
- enabled/disabled/default state when applicable
- sort order when rendered
- contribution source
- route/action/handler reference when applicable
- permission key when applicable
- documentation link
- version or migration marker when applicable
- metadata only when needed

Use `jsonb` metadata only for extension data, not core registry fields that must be queried, filtered, or validated.

---

## Stable Key Rules

Registry keys and contribution keys are durable contracts after release.

Keys must be:

- stable
- descriptive
- correctly identified as a registry or owner-prefixed contribution
- safe to reference from code, docs, seeders, and tests
- migrated intentionally if renamed

Examples:

- `registry_key: notification.types`
- `registry_key: setup.steps`
- `registry_key: settings.pages`
- `registry_key: ui.navigation`
- `contribution_key: notifications.security_mfa_changed`
- `contribution_key: security.setup_overview`
- `contribution_key: identity.user_defaults`
- `contribution_key: projects.index`

The canonical identity of a contribution is the pair:

```text
(registry_key, contribution_key)
```

Registry keys are globally unique within the registry-key family. Contribution keys are unique within their registry. Storage and sync implementations must reject duplicate canonical pairs rather than silently replacing an existing contribution.

Renaming either part of a released contribution identity requires explicit migration planning and a one-way compatibility alias that follows [Identifier And Key Standards](../coding/Identifier%20And%20Key%20Standards.md). Arbitrary invalid keys must not be silently normalized.

---

## Owner Rules

Every registry entry must identify its owner.

Every entry must store or resolve these fields separately:

```text
ownership_area: core | module | ui
owner_key: <globally unique owner key>
```

Use `capability_key` for stable functional identity and `module_key` for an optional Module when applicable. Do not collapse these fields even when their values currently match.

The registry may aggregate contributions, but ownership remains with the contributing Core capability, Module, or UI owner. Registry infrastructure must not become the hidden owner of contributed behavior.

---

## Lifecycle Status Rules

Registry entries should support lifecycle status when they may change over time.

Common statuses:

- draft
- active
- disabled
- deprecated
- removed
- unavailable

When a contribution can be installed, enabled, disabled, or unavailable, document what each state means.

Do not overload a single boolean when lifecycle states have different meanings.

---

## Enabled, Disabled, And Unavailable

Use these meanings consistently.

| State       | Meaning                                                                                          |
| ----------- | ------------------------------------------------------------------------------------------------ |
| enabled     | Available and active for the relevant scope.                                                     |
| disabled    | Known but intentionally turned off for the relevant scope.                                       |
| unavailable | Not available because prerequisites, license, module install, environment, or policy is missing. |
| deprecated  | Still present but should not be used for new behavior.                                           |
| removed     | No longer available except historical references.                                                |

Do not use disabled to mean unavailable.

---

## Sort And Display Rules

Registry entries that render in UI should define deterministic ordering.

Display metadata may include:

- label
- description
- group
- category
- icon key
- route key
- sort order
- visibility conditions
- permission key

Display metadata should not replace route authorization or business logic.

---

## Seeder Rules

Registry seeders must be deterministic and safe to rerun.

Seeder rules:

- use canonical registry and contribution keys
- update existing rows by the complete canonical pair
- reject duplicate canonical pairs
- do not delete entries without explicit cleanup plan
- do not seed real secrets
- keep sort order stable
- preserve deprecated entries when historical references need them

Registry seeders should be reviewed as contract changes, not disposable setup scripts.

---

## Module Contribution Rules

Business Modules may contribute registry entries.

A Module contribution should identify:

- `ownership_area: module`
- `owner_key`
- `module_key`
- contribution type
- `registry_key`
- owner-prefixed `contribution_key`
- route/action/handler
- permission requirement
- lifecycle state
- setup/settings relationship when applicable
- docs link

Modules must not contribute registry entries that bypass Core Access, Audit, Settings, Notifications, Security, or DataProtection requirements.

---

## Settings, Preferences, And Notification Registries

Settings registries should define setting availability and metadata. They should not store the actual setting value.

Preference registries should define available preference types. They should not store actual user preference values.

Notification registries should define notification types. They should not store notification delivery state.

Actual values and state belong in their own tables.

---

## Metadata Rules

Registry metadata should remain small and intentional.

Use metadata for:

- extension fields
- optional UI hints
- integration-specific details
- non-core display data

Do not place essential lookup keys, permissions, lifecycle status, owner, or display labels only inside metadata when they need to be queried or governed.

---

## Documentation Expectations

Registry tables and entries should be documented.

Update:

- table docs under `docs/06-database/tables/`
- feature contracts under `docs/06-database/feature-contracts/`
- capability docs
- module docs
- setup/settings/notification docs when applicable
- planning docs while active

Registry docs should explain the difference between registry metadata and runtime state.

---

## Testing Expectations

Registry changes should verify:

- seeders are idempotent
- keys remain stable
- entries are not duplicated
- entries are visible only when permissions allow
- enabled/disabled/unavailable behavior works
- deprecated entries do not appear where they should not
- registry-backed UI renders expected entries
- module contributions are scoped correctly

---

## Stop Conditions

Stop before adding or changing registry data when:

- owner is unclear
- key naming is unclear
- lifecycle states are unclear
- registry is being used for runtime state
- registry metadata is replacing authorization or business logic
- key rename has no migration plan
- seeded values may duplicate existing rows
- documentation owner is unclear
- tests cannot identify idempotency or visibility expectations

---

## Related

- [ADR-0007: Owner, Registry, And Identifier Key Conventions](../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Identifier And Key Standards](../coding/Identifier%20And%20Key%20Standards.md)
- [Settings Data Governance Standards](Settings%20Data%20Governance%20Standards.md)
- [Database Table Contract Standards](Database%20Table%20Contract%20Standards.md)
- [Schema Design Standards](Schema%20Design%20Standards.md)
- [Database Migration Standards](Database%20Migration%20Standards.md)
- [Database Index](../../06-database/index.md)
- [Standards Index](../index.md)
