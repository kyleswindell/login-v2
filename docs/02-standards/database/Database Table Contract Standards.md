<!--
DOC-META
title: Database Table Contract Standards
doc_type: standard
status: active
owner: data
canonical: true
canonical_path: docs/02-standards/database/Database Table Contract Standards.md
parent: docs/02-standards/database/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines the required shape and content for database table documentation under docs/06-database/tables.
-->

# Database Table Contract Standards

This document defines the required contract shape for database table documentation in Login App 2.0.

Use this standard when creating or updating table docs under `docs/06-database/tables/`.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Core Rule](#3-core-rule)
- [4. Required Table Doc Location](#4-required-table-doc-location)
- [5. Required DOC-META Header](#5-required-doc-meta-header)
- [6. Required Sections](#6-required-sections)
- [7. Table Owner](#7-table-owner)
- [8. Table Scope](#8-table-scope)
- [9. Column Documentation](#9-column-documentation)
- [10. Relationship Documentation](#10-relationship-documentation)
- [11. Index And Constraint Documentation](#11-index-and-constraint-documentation)
- [12. Lifecycle Documentation](#12-lifecycle-documentation)
- [13. Security And Classification Documentation](#13-security-and-classification-documentation)
- [14. Audit And Monitoring Documentation](#14-audit-and-monitoring-documentation)
- [15. Related Code Documentation](#15-related-code-documentation)
- [16. Related Docs](#16-related-docs)
- [17. Table Doc Review Checklist](#17-table-doc-review-checklist)
- [18. Stop Conditions](#18-stop-conditions)
- [19. Related](#19-related)

---

## 1. Purpose

Ensure every database table has a clear owner, purpose, scope, fields, constraints, security classification, lifecycle behavior, and documentation trail.

Table docs should make it possible for developers, reviewers, and Codex agents to understand what a table owns without reading every migration and model first.

---

## 2. Scope

This standard applies to documentation for:

- Core capability tables
- Module tables
- Host-owned Registry tables
- settings and preferences tables
- audit, monitoring, security, and evidence tables
- join tables
- lookup/reference tables
- operational tables

This standard governs table documentation, not migration implementation. Migration implementation is governed by:

- [Database Migration Standards](Database%20Migration%20Standards.md)
- [Schema Design Standards](Schema%20Design%20Standards.md)

---

## 3. Core Rule

Every table document must answer:

- what owns this table
- why this table exists
- what records it stores
- how records are scoped
- which fields are sensitive
- which relationships and constraints matter
- how records are created, updated, retained, deleted, or archived
- which code and docs depend on the table

If those answers are unknown, the table contract is incomplete.

---

## 4. Required Table Doc Location

Table docs belong under:

- `docs/06-database/tables/`

A table named `user_contact_emails` should generally have a table doc named:

- `docs/06-database/tables/user_contact_emails.md`

Update the database table index when adding a new table doc:

- [Database Tables Index](../../06-database/tables/index.md)

---

## 5. Required DOC-META Header

Every new or materially rewritten table document must include a `DOC-META` header.

Use values appropriate to the table.

Example fields:

| Field       | Expected Value                                                           |
| ----------- | ------------------------------------------------------------------------ |
| `doc_type`  | `database`                                                               |
| `status`    | `draft`, `active`, `planned`, `implemented`, `superseded`, or `archived` |
| `owner`     | usually `data`, `core`, `platform`, or `module`                          |
| `canonical` | `true` for table contracts                                               |
| `template`  | `docs/09-reference/templates/docs/_doc.md`                               |

---

## 6. Required Sections

Every table doc should include these sections when applicable.

| Section                     | Purpose                                                                               |
| --------------------------- | ------------------------------------------------------------------------------------- |
| Purpose                     | Why the table exists.                                                                 |
| Status                      | Current lifecycle of the documented table.                                            |
| Table Owner                 | Owning layer, capability, surface, or module.                                         |
| Table Scope                 | Global, platform, tenant, workspace, account, user, customer, module, or other scope. |
| Columns                     | Field list with purpose and sensitivity.                                              |
| Relationships               | Foreign keys and dependent records.                                                   |
| Indexes And Constraints     | Uniqueness, lookup paths, and integrity rules.                                        |
| Lifecycle                   | Creation, update, archival, deletion, retention, and anonymization behavior.          |
| Security And Classification | Sensitive fields, PII, secrets, masking, export rules, and access risks.              |
| Audit And Monitoring        | Audit events or monitoring signals tied to the table.                                 |
| Seed And Registry Behavior  | Seeders, registry defaults, stable keys, and baseline records.                        |
| Related Code                | Models, migrations, seeders, services, policies, tests, routes, or jobs.              |
| Related Docs                | Canonical docs, planning docs, standards, and runbooks.                               |
| Open Questions              | Unresolved design or migration questions.                                             |

Do not add empty boilerplate sections when they do not apply, but do not omit important ownership, scope, security, or lifecycle content.

---

## 7. Table Owner

Every table doc must identify the owning layer.

Use one of:

- Core capability
- Module

Also identify the specific capability or Module. Ops, Data, Security, Docs, and Tests may describe repository workflow or stewardship responsibilities, but they do not replace the application owner. UI and Laravel integration do not own durable application data. Surface, Delivery Adapter, and Registry are technical responsibilities beneath the application owner, not table-owner categories. A Host-owned Registry table remains owned by the Host's Core capability or Module; Surface presentation does not own persisted contribution data.

Examples:

| Table                           | Owner                      |
| ------------------------------- | -------------------------- |
| `user_mfa_methods`              | Core Auth / Core Identity  |
| `roles`                         | Core Access                |
| `audit_events`                  | Core Audit                 |
| `notification_registry_entries` | Core Notifications         |
| `module_registry_entries`       | Core Module Lifecycle Host Registry |
| `customers`                     | Customers Module            |

Transitional Platform-named tables must not silently become owners of Module domain data.

Module tables must not redefine Core Auth, Access, Audit, Notifications, Security, Settings, or DataProtection infrastructure.

---

## 8. Table Scope

Every table doc must describe record scope.

Common scope types:

- global
- platform
- tenant
- workspace
- account
- user
- customer
- module
- integration
- system

For scoped tables, document:

- required scope columns
- scoped uniqueness rules
- expected query scope
- cross-scope access risks
- whether scope is enforced by foreign keys, queries, policies, or both

If a table stores scoped business data but lacks explicit scope, the doc must call that out as a design risk or open question.

---

## 9. Column Documentation

Document columns with enough detail to understand intent and risk.

Recommended shape:

| Column     | Type       | Nullable | Purpose             | Classification | Notes                          |
| ---------- | ---------- | -------- | ------------------- | -------------- | ------------------------------ |
| `id`       | bigint     | no       | Primary key.        | internal       | Internal identity.             |
| `user_id`  | foreign id | no       | Owning user.        | confidential   | FK to `users`.                 |
| `metadata` | jsonb      | yes      | Extension metadata. | internal       | Not core relational structure. |

Column docs should identify:

- purpose
- nullability meaning
- default behavior
- sensitivity classification
- whether the field is user-controlled
- whether the field is exported, masked, redacted, or audited
- any validation or allowed values

Do not document columns only by repeating the migration type.

---

## 10. Relationship Documentation

Document relationships that affect integrity, scope, access, retention, or lifecycle.

Include:

- parent table
- child table
- relationship type
- required or optional
- delete behavior
- scope implications
- owner

Avoid vague statements such as “related to users.” Identify the actual relationship and its constraints.

---

## 11. Index And Constraint Documentation

Document indexes and constraints that matter.

Include:

- primary key
- foreign keys
- unique constraints
- scoped uniqueness
- lookup indexes
- status/date indexes
- token prefix indexes
- check constraints
- performance-sensitive indexes

Explain why important compound indexes exist.

Do not treat indexes as implementation trivia when they enforce ownership, access, scope, or expected query behavior.

---

## 12. Lifecycle Documentation

Document record lifecycle when it matters.

Include:

- creation source
- update source
- archival behavior
- soft delete behavior
- hard delete behavior
- anonymization behavior
- retention period
- restoration behavior
- cleanup process

Do not rely on `created_at` and `updated_at` alone to explain meaningful lifecycle state.

Use explicit lifecycle fields where needed.

---

## 13. Security And Classification Documentation

Every table doc should identify sensitive fields.

Use classifications from the data governance/data protection model:

- public
- internal
- confidential
- restricted

Document whether the table includes:

- personal data
- authentication data
- MFA data
- access control data
- audit/security data
- secret-bearing values
- exportable data
- regulated or high-risk data

Restricted or secret-bearing data must document masking, redaction, encryption, hashing, reveal, export, and audit expectations.

---

## 14. Audit And Monitoring Documentation

Document audit or monitoring expectations when table records affect important system behavior.

At minimum, consider audit expectations for:

- user lifecycle records
- MFA/security records
- roles and access assignments
- service accounts and API tokens
- settings changes
- secret-bearing values
- export/download records
- data governance/protection records
- destructive or administrative changes

Do not store audit expectations only in implementation code.

---

## 15. Related Code Documentation

Every table doc should list important related code when known.

Useful references:

- migration files
- model classes
- factories
- seeders
- services/actions
- policies/gates
- form requests
- controllers/routes
- tests
- jobs/events/listeners
- registry definitions

This section should help reviewers locate implementation quickly. It should not duplicate implementation details.

---

## 16. Related Docs

Link related canonical docs.

Common links:

- database feature contract
- feature doc
- architecture doc
- planning doc
- migration standard
- schema standard
- security/data standard
- runbook when operational behavior applies

Planning docs may be linked while active, but table docs should represent current table truth.

---

## 17. Table Doc Review Checklist

Before accepting a table doc, verify:

- owner is explicit
- scope is explicit
- sensitive columns are identified
- lifecycle behavior is documented
- relationships are clear
- constraints and indexes are meaningful
- related migrations and models are listed
- related canonical docs are linked
- planning docs do not remain the only source of durable truth
- table index is updated

---

## 18. Stop Conditions

Stop before creating or approving a table doc when:

- the table owner is unclear
- scope is unclear
- sensitive fields are unknown
- retention or deletion behavior is unknown
- foreign key behavior is unclear
- table purpose overlaps another table
- table docs would contradict migrations or schema standards
- a planning doc is being treated as final schema truth

---

## 19. Related

- [Database Migration Standards](Database%20Migration%20Standards.md)
- [Schema Design Standards](Schema%20Design%20Standards.md)
- [Database Data Classification And Retention Standards](Database%20Data%20Classification%20And%20Retention%20Standards.md)
- [Database Tenant Workspace Isolation Standards](Database%20Tenant%20Workspace%20Isolation%20Standards.md)
- [Database Index](../../06-database/index.md)
- [Database Tables Index](../../06-database/tables/index.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Standards Index](../index.md)
