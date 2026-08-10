<!--
DOC-META
title: Database Standards Index
doc_type: index
status: active
owner: data
canonical: true
canonical_path: docs/02-standards/database/index.md
parent: docs/02-standards/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Indexes database standards for PostgreSQL schema design, migrations, table contracts, scope isolation, access-control data, audit evidence, classification, settings, and registry data.
-->

# Database Standards Index

Parent: [Standards Index](../index.md)

This folder contains the active standards that govern PostgreSQL schema design, Laravel migrations, table contracts, data governance, database isolation, access-control data, audit/evidence data, settings, and registry-backed data for Login App 2.0.

- [1. Purpose](#1-purpose)
- [2. Folder Scope](#2-folder-scope)
- [3. Active Standards](#3-active-standards)
- [4. Recommended Reading Order](#4-recommended-reading-order)
- [5. Current Database Direction](#5-current-database-direction)
- [6. Table Documentation](#6-table-documentation)
- [7. Documentation Sync](#7-documentation-sync)
- [8. Maintenance Rules](#8-maintenance-rules)
- [9. Related](#9-related)

---

## 1. Purpose

Use this folder to answer:

- how PostgreSQL tables should be designed
- how Laravel migrations should be written and reviewed
- how table contracts under `docs/06-database/tables/` should be shaped
- how tenant, workspace, account, customer, module, and user scope should be represented
- how access-control data should model subjects, targets, roles, actions, assignments, elevation, and reviews
- how audit and evidence records should be shaped
- how sensitive data, retention, masking, deletion, anonymization, and export eligibility should be documented
- how settings, preferences, registries, and seeded data should be governed

---

## 2. Folder Scope

This folder owns database standards only.

It may contain:

- schema design standards
- migration standards
- table documentation contract standards
- data classification and retention standards
- tenant/workspace isolation standards
- access-control data model standards
- audit and evidence data standards
- settings data governance standards
- registry data standards

It must not contain:

- table documentation files
- feature behavior documentation
- application architecture docs
- implementation planning notes
- operational runbooks
- source research
- copyable templates
- migration files
- database seed data

Table documentation belongs in:

- [Database Tables Index](../../06-database/tables/index.md)

Database feature contracts belong in:

- `docs/06-database/feature-contracts/`

Planning belongs in:

- `docs/07-planning/`

Operational procedures belong in:

- `docs/10-runbooks/`

---

## 3. Active Standards

| Document                                                                                                                  | Purpose                                                                                                                                                                                                     |
| ------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [Database Migration Standards](Database%20Migration%20Standards.md)                                                       | Defines safe Laravel and PostgreSQL migration rules for schema changes, data changes, backfills, rollbacks, ownership, and documentation sync.                                                              |
| [Schema Design Standards](Schema%20Design%20Standards.md)                                                                 | Defines PostgreSQL schema design rules for table naming, keys, relationships, indexes, JSONB, scope, lifecycle fields, and data integrity.                                                                  |
| [Database Table Contract Standards](Database%20Table%20Contract%20Standards.md)                                           | Defines the required shape and content for table documentation under `docs/06-database/tables/`.                                                                                                            |
| [Database Tenant Workspace Isolation Standards](Database%20Tenant%20Workspace%20Isolation%20Standards.md)                 | Defines database rules for tenant, workspace, account, customer, Module, and scope isolation across Core capability and Module data.                                                                        |
| [Database Access Control Data Model Standards](Database%20Access%20Control%20Data%20Model%20Standards.md)                 | Defines database standards for IAM-style access-control data including subjects, targets, roles, actions, groups, assignments, elevation, reviews, and effective access.                                    |
| [Database Audit And Evidence Standards](Database%20Audit%20And%20Evidence%20Standards.md)                                 | Defines database standards for audit events, evidence records, actor/subject/target modeling, redaction, correlation, forensic readiness, retention, and evidence integrity.                                |
| [Database Data Classification And Retention Standards](Database%20Data%20Classification%20And%20Retention%20Standards.md) | Defines database standards for data classification, sensitive fields, retention, deletion, anonymization, masking, export eligibility, and audit-preserving lifecycle behavior.                             |
| [Settings Data Governance Standards](Settings%20Data%20Governance%20Standards.md)                                         | Defines governance rules for settings, preferences, registry-backed configuration, scoped configuration values, sensitive settings, and stable setting keys.                                                |
| [Database Registry Data Standards](Database%20Registry%20Data%20Standards.md)                                             | Defines database standards for registry-backed data including stable keys, ownership, contribution records, setup/settings/notification registries, seeders, lifecycle status, ordering, and documentation. |

---

## 4. Recommended Reading Order

For general database design work, read in this order:

1. [Schema Design Standards](Schema%20Design%20Standards.md)
2. [Database Migration Standards](Database%20Migration%20Standards.md)
3. [Database Table Contract Standards](Database%20Table%20Contract%20Standards.md)

For scoped business data, also read:

- [Database Tenant Workspace Isolation Standards](Database%20Tenant%20Workspace%20Isolation%20Standards.md)

For auth, identity, users, roles, permissions, service accounts, or elevated access, also read:

- [Database Access Control Data Model Standards](Database%20Access%20Control%20Data%20Model%20Standards.md)

For audit, monitoring, forensics, security events, or evidence records, also read:

- [Database Audit And Evidence Standards](Database%20Audit%20And%20Evidence%20Standards.md)

For sensitive data, exports, retention, erasure, masking, or anonymization, also read:

- [Database Data Classification And Retention Standards](Database%20Data%20Classification%20And%20Retention%20Standards.md)

For settings, preferences, setup entries, notification types, module registries, or seeded contribution metadata, also read:

- [Settings Data Governance Standards](Settings%20Data%20Governance%20Standards.md)
- [Database Registry Data Standards](Database%20Registry%20Data%20Standards.md)

---

## 5. Current Database Direction

Login App 2.0 uses PostgreSQL as the active database target.

Database design must support the current ownership model:

| Owner or integration boundary | Typical Database Responsibility                                                                                                                        |
| ----------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Core capability               | Auth, Identity, Access, Audit, Monitoring, Notifications, Settings, Preferences, Security, DataGovernance, DataProtection, and required system tables. |
| Module                        | Optional feature-owned tenant/workspace business tables.                                                                                               |
| UI                            | No application database ownership; reusable presentation infrastructure must not query or mutate domain data.                                          |
| Laravel integration           | No durable application ownership; framework persistence integration delegates to the applicable Core capability or Module.                             |
| Ops                           | Operational records, release/deployment metadata, or runbook-supported data when explicitly documented.                                                |

Host-owned Registry tables remain owned by the Host's Core capability or Module. Surface presentation, Delivery Adapters, and transitional `app/Platform/*` placement do not establish database ownership.

Do not let Module tables redefine Core Auth, Access, Audit, Notifications, Settings, Security, DataGovernance, or DataProtection infrastructure.

---

## 6. Table Documentation

Table contracts belong under:

- [Database Tables Index](../../06-database/tables/index.md)

When adding or changing a table, update the relevant table doc and database index in the same work cycle.

A table doc should identify:

- table owner
- scope
- columns
- relationships
- indexes and constraints
- sensitive fields
- classification
- retention/deletion behavior
- audit expectations
- related migrations, models, seeders, tests, and canonical docs

Use:

- [Database Table Contract Standards](Database%20Table%20Contract%20Standards.md)

---

## 7. Documentation Sync

Database work must stay synchronized with canonical docs.

Potential docs to update:

- [Database Index](../../06-database/index.md)
- [Database Tables Index](../../06-database/tables/index.md)
- `docs/06-database/feature-contracts/`
- relevant architecture docs
- relevant feature docs
- relevant planning docs
- relevant runbooks
- relevant security/data governance/data protection docs

Use:

- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)

---

## 8. Maintenance Rules

When adding or changing database standards:

- update this index in the same change
- add or update the document `DOC-META` header
- link the standard from [Standards Index](../index.md) when appropriate
- keep standards enforceable and concise
- avoid duplicating rules owned by coding, security, logging, documentation, or runbook standards
- use current Core, Module, UI, Laravel integration, Surface, Delivery Adapter, and Registry vocabulary
- keep PostgreSQL as the assumed database target unless a decision record changes it

When moving, splitting, or archiving database standards:

- preserve heavily linked paths as short hubs when practical
- update inbound links where practical
- update this index
- update [Standards Index](../index.md)
- ensure the replacement owner is obvious

---

## 9. Related

- [Standards Index](../index.md)
- [Coding Standards Index](../coding/index.md)
- [Documentation Standards Index](../documentation/index.md)
- [Database Index](../../06-database/index.md)
- [Database Tables Index](../../06-database/tables/index.md)
- [Testing Standards Index](../testing/index.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Start Here](../../00-start-here.md)
