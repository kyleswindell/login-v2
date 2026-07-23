<!--
DOC-META
title: Phase 5.10 Database Naming Boundary
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-10-database-naming-boundary.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the broad Model, table, migration, and ownership naming rules owned by Goal 3 and preserves detailed database authority for Goal 6.
-->

# Phase 5.10 Database Naming Boundary

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define the database-related naming rules required for repository architecture without prematurely designing the PostgreSQL schema owned by Goal 6.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Later authority: Goal 6 and canonical database standards

## 3. Goal 3 Rules

| Concern             | Phase 5 rule                                         |
| ------------------- | ---------------------------------------------------- |
| Eloquent Model      | Singular PascalCase semantic noun                    |
| Default table       | Plural snake case                                    |
| Migration filename  | Timestamp plus lowercase snake-case result           |
| Migration placement | With the owning Core capability or Module            |
| Ownership prefixes  | Not added automatically                              |
| Legacy names        | Explicit compatibility and migration record required |

Existing database standards already require plural snake-case tables, singular snake-case columns, explicit foreign keys, descriptive join tables, and no legacy `tbl` prefixes.

## 4. Model-To-Table Expectation

Use Laravel’s normal semantic relationship:

```text
UserAccount        -> user_accounts
NotificationEntry -> notification_entries
ShipmentLine       -> shipment_lines
```

Avoid redundant type names:

```text
UserAccountModel
NotificationTable
DatabaseShipmentLine
```

An explicit Model `$table` override requires a documented domain term, compatibility need, external schema, or Goal 6-approved exception.

## 5. Migration Filenames And Placement

Use:

```text
<timestamp>_<result>.php
```

Examples:

```text
2026_07_16_120000_create_user_contact_emails_table.php
2026_07_16_121000_add_type_key_to_notifications_table.php
2026_07_16_122000_create_module_contribution_registry_tables.php
```

Migration names describe one primary schema result rather than implementation mechanics.

Ownership is expressed primarily through placement and documentation:

```text
database/core/identity/migrations/
database/core/notifications/migrations/

Modules/Projects/database/migrations/
Modules/QuickBooksSync/database/migrations/
```

Do not automatically prefix tables with `core_`, `module_`, owner keys, capability keys, or package names merely to communicate ownership. A prefix may be accepted where it is part of the natural domain name or Goal 6 documents a material collision, compatibility, or database-design requirement.

## 6. Goal 6 Authority

Goal 6 retains detailed authority over:

- column names;
- primary keys;
- foreign keys;
- indexes;
- unique and check constraints;
- join-table naming and ordering;
- polymorphic columns;
- lifecycle and timestamp fields;
- scope columns;
- schema namespaces;
- PostgreSQL-specific exceptions;
- table-prefix requirements;
- legacy schema migration.

## 7. Accepted Decision

> Eloquent Model classes use singular PascalCase semantic nouns. Models must not use generic `Model`, `Record`, `Entity`, or `Database` prefixes or suffixes unless an external framework contract requires the exact name.
> The default table corresponding to an Eloquent Model uses plural snake case. Explicit table-name overrides require a documented domain, compatibility, external-schema, or Goal 6-approved reason.
> Laravel migration filenames use the framework timestamp prefix followed by a lowercase snake-case description of the resulting database change. Migration names should describe one primary result, such as `create_user_contact_emails_table` or `add_expires_at_to_api_tokens_table`.
> Migration ownership is expressed through owner-local placement. Core schema-lifecycle artifacts remain beneath `database/core/<capability-slug>/`; Module schema-lifecycle artifacts remain package-local beneath `Modules/<Module>/database/`.
> Table names must not receive automatic `core`, `module`, owner-key, capability-key, or package-name prefixes solely to communicate ownership. Prefixes may be accepted where they are part of the natural domain name or where Goal 6 documents a material collision, compatibility, or database-design requirement.
> Goal 3 does not determine detailed column, key, index, constraint, relationship, join-table, scope, lifecycle, schema, or database-specific naming. Those decisions remain owned by Goal 6 and the canonical database standards.
> Legacy database names may remain only through an explicit compatibility and migration record. Phase 5 naming does not authorize physical schema renaming.

## 8. Boundaries And Handoff

- Phase 5 does not create, rename, or move Models, migrations, tables, or schema objects.
- Goal 6 must reconcile detailed database standards with the accepted owner and Module identity model.
- Database changes require their own safety, migration, rollback, and documentation proofs.

## 9. Related

- [Folder And Namespace Naming](5-1-folder-and-namespace-naming.md)
- [Core Capability Naming](5-2-core-capability-naming.md)
- [Module Naming](5-3-module-naming.md)
- [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md)
- [Database Standards Index](../../../../../02-standards/database/index.md)
- [Schema Design Standards](../../../../../02-standards/database/Schema%20Design%20Standards.md)
- [Database Migration Standards](../../../../../02-standards/database/Database%20Migration%20Standards.md)
- [Phase 4 Database And Migration Placement](../phase-4/4-6-database-and-migration-placement.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
