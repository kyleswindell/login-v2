<!--
DOC-META
title: Schema Design Standards
doc_type: standard
status: active
owner: data
canonical: true
canonical_path: docs/02-standards/database/Schema Design Standards.md
parent: docs/02-standards/database/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines PostgreSQL schema design rules for table naming, keys, relationships, indexes, JSONB, scope, lifecycle fields, and data integrity.
-->

# Schema Design Standards

This document defines schema design standards for Login App 2.0.

These standards apply to PostgreSQL-backed Laravel schema design across Core Capabilities, Platform Surfaces, and Business Modules.

- [1. Purpose](#1-purpose)
- [2. Core Rule](#2-core-rule)
- [3. Naming Rules](#3-naming-rules)
- [4. Ownership And Scope](#4-ownership-and-scope)
- [5. Primary Key Rules](#5-primary-key-rules)
- [6. Foreign Key Rules](#6-foreign-key-rules)
- [7. Join Table Rules](#7-join-table-rules)
- [8. Column Type Rules](#8-column-type-rules)
- [9. JSONB Rules](#9-jsonb-rules)
- [10. Status And Lifecycle Fields](#10-status-and-lifecycle-fields)
- [11. Timestamp Rules](#11-timestamp-rules)
- [12. Soft Delete Rules](#12-soft-delete-rules)
- [13. Index Design](#13-index-design)
- [14. Constraint Rules](#14-constraint-rules)
- [15. Money And Numeric Rules](#15-money-and-numeric-rules)
- [16. Settings And Registry Tables](#16-settings-and-registry-tables)
- [17. Audit And History](#17-audit-and-history)
- [18. Documentation Sync](#18-documentation-sync)
- [19. Stop Conditions](#19-stop-conditions)
- [20. Related](#20-related)

---

## 1. Purpose

Keep database schema explicit, relational, secure, scoped, and maintainable.

The schema should make ownership, relationships, lifecycle state, and query paths clear without relying on hidden application conventions.

---

## 2. Core Rule

Design schema around durable relationships and clear ownership.

Use relational structure for core data.

Use flexible structures only for metadata, snapshots, extension points, or payloads that are intentionally not part of the core relational model.

---

## 3. Naming Rules

Use:

- plural snake_case table names
- singular snake_case column names
- explicit foreign key names
- stable key names for settings, registries, and event types
- descriptive join table names
- no legacy `tbl` prefixes
- no vague table names such as `data`, `items`, `records`, or `values`

Examples:

- `users`
- `user_contact_emails`
- `user_mfa_methods`
- `module_registry_entries`
- `notification_registry_entries`
- `customer_locations`
- `shipment_lines`

Do not use legacy Perfex table naming for new Login App 2.0 tables.

---

## 4. Ownership And Scope

Every table should have a clear owner.

| Table Type                                       | Typical Owner                             |
| ------------------------------------------------ | ----------------------------------------- |
| Authentication and sessions                      | Core Auth                                 |
| Users and identity lifecycle                     | Core Identity                             |
| Roles, permissions, groups, access reviews       | Core Access                               |
| Audit events and evidence                        | Core Audit                                |
| Monitoring, health, and detection signals        | Core Monitoring                           |
| Notifications and notification state             | Core Notifications                        |
| Settings and preferences                         | Core Settings / Core Preferences          |
| Data classification and protection               | Core DataGovernance / Core DataProtection |
| Shell, navigation, setup, UI reference metadata  | Platform                                  |
| Customers, orders, shipments, inventory, reports | Business Modules                          |

Scoped business data must include the correct tenant, workspace, account, customer, or module scope.

Unique constraints for scoped data should usually include the scope column.

Do not rely on application code alone to prevent cross-scope collisions when a database constraint can enforce the rule.

---

## 5. Primary Key Rules

Use the existing project convention for primary keys unless an explicit decision changes it.

Do not introduce UUIDs, composite primary keys, or alternate primary key strategies without a documented reason.

If an external stable identifier is needed, store it as a separate unique column instead of replacing the internal primary key by default.

---

## 6. Foreign Key Rules

Prefer explicit foreign keys for stable relationships.

Use foreign keys for:

- required ownership
- resource scope
- join tables
- parent-child relationships
- access-sensitive relationships
- audit-sensitive relationships
- data integrity boundaries

Use nullable foreign keys only when the relationship is genuinely optional.

Do not use soft relationship columns where stable foreign keys are required.

Avoid polymorphic relationships for security, access, finance, ownership, or data-protection boundaries unless explicitly documented and approved.

---

## 7. Join Table Rules

Use join tables for many-to-many relationships.

Join tables should:

- use clear table names
- include foreign keys to both sides
- include unique constraints to prevent duplicate relationships
- include timestamps when relationship history or maintenance matters
- include metadata only when the relationship itself owns that metadata

Do not hide many-to-many relationships in comma-separated strings, JSON arrays, or loosely typed metadata.

---

## 8. Column Type Rules

Use PostgreSQL-appropriate types.

General rules:

- use booleans for true/false state
- use integers or numeric precision for quantities and exact values
- do not use floating point for money or exact calculations
- use text for long content
- use bounded strings when validation or business rules define a meaningful maximum
- use timestamp with timezone behavior for event, audit, security, and operational times
- use `jsonb` only for metadata, snapshots, extension points, or flexible payloads
- avoid PostgreSQL extensions unless explicitly approved and documented

For email and other case-insensitive values, define normalization rules in application code and constraints before relying on a database extension.

---

## 9. JSONB Rules

`jsonb` is allowed for:

- metadata
- audit snapshots
- external payload snapshots
- registry extension data
- flexible UI/reference configuration
- data that is intentionally not queried as core relational structure

`jsonb` is not allowed as the primary home for:

- ownership relationships
- permissions
- lifecycle status
- core business facts
- financial allocations
- tenant/workspace scope
- stable settings that require validation and search
- records that need strong foreign keys

If a `jsonb` field becomes frequently queried, filtered, validated, or joined, promote the structure into relational columns or a related table.

---

## 10. Status And Lifecycle Fields

Use explicit lifecycle fields when records move through meaningful states.

Status values should be:

- stable
- documented
- validated
- tested
- indexed when used for filtering

Avoid vague status values such as `active` when the real lifecycle has distinct states like `invited`, `active`, `suspended`, `deactivated`, `pending_deletion`, and `deleted`.

Avoid database enum types for lifecycle values that may change. Prefer application enums plus validation, check constraints, lookup tables, or registries based on how stable and user-configurable the values are.

---

## 11. Timestamp Rules

Use timestamps consistently.

Tables should generally include timestamps when records are created or updated by the application.

Use explicit timestamp columns for lifecycle events when they matter, such as:

- invited_at
- accepted_at
- verified_at
- suspended_at
- deactivated_at
- revoked_at
- expires_at
- last_used_at
- archived_at

Do not overload `updated_at` to represent lifecycle events.

Use timezone-aware semantics for security, audit, token, notification, and operational time.

---

## 12. Soft Delete Rules

Use soft deletes only when the application needs recoverability, lifecycle history, or references from other records.

Do not use soft deletes as a substitute for lifecycle state.

Security, audit, identity, and data-retention behavior may require explicit lifecycle fields instead of simple soft delete behavior.

When soft deletes affect uniqueness, define the expected uniqueness behavior clearly before implementation.

---

## 13. Index Design

Design indexes around actual access patterns.

Index:

- foreign keys
- scoped lookup columns
- unique keys
- frequently filtered status columns
- date-range query columns
- token prefix columns
- registry keys
- settings keys
- audit/security event lookup fields
- tenant/workspace/module scoped uniqueness

Avoid speculative indexes without an identified query path or constraint.

For compound indexes, order columns by scope and lookup pattern.

---

## 14. Constraint Rules

Use database constraints to enforce durable integrity.

Use constraints for:

- required relationships
- uniqueness
- non-null values
- stable check constraints
- scoped uniqueness
- valid ownership boundaries

Do not enforce critical integrity only in UI or controller logic when the database can enforce it safely.

---

## 15. Money And Numeric Rules

Do not store money or exact business quantities in floating point columns.

Use either:

- integer minor units when values are always in one currency or fixed unit
- numeric precision when fractional precision is required and documented

Document currency, precision, rounding, and allocation rules in the canonical feature or database contract before implementing financial schema.

---

## 16. Settings And Registry Tables

Settings and registry tables must use stable keys.

Settings and registry keys should include:

- owner capability or module
- scope
- type
- default behavior
- validation expectations
- permission expectations
- audit expectations when values change

Secret-bearing settings must use encrypted storage and masked output.

Do not store environment-only secrets in database settings unless explicitly required and protected by Secrets standards.

---

## 17. Audit And History

Do not rely only on mutable table state for audit-worthy changes.

Use Core Audit for audit records.

Schema that supports audit or history should clearly separate:

- current state
- historical event records
- snapshots
- evidence metadata
- operational logs

Audit tables should be append-oriented unless a retention or correction process explicitly owns mutation.

---

## 18. Documentation Sync

Schema changes must update database documentation.

Update:

- table docs under `docs/06-database/tables/`
- feature contracts under `docs/06-database/feature-contracts/`
- relevant architecture or feature docs
- relevant planning docs
- runbooks when operational migration or backfill steps exist

---

## 19. Stop Conditions

Stop before designing schema when:

- the canonical owner is unclear
- tenant/workspace/account scope is unclear
- a relationship could be polymorphic but security or integrity matters
- lifecycle values are unstable
- JSONB is being used to avoid modeling core structure
- financial precision rules are unknown
- a destructive migration would be needed
- required indexes or constraints are not understood
- documentation owner is unknown

---

## 20. Related

- [Database Migration Standards](Database%20Migration%20Standards.md)
- [Settings Data Governance Standards](Settings%20Data%20Governance%20Standards.md)
- [Database Index](../../06-database/index.md)
- [Database Tables Index](../../06-database/tables/index.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Standards Index](../index.md)