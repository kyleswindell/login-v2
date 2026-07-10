<!--
DOC-META
title: Database Migration Standards
doc_type: standard
status: active
owner: data
canonical: true
canonical_path: docs/02-standards/database/Database Migration Standards.md
parent: docs/02-standards/database/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines safe Laravel and PostgreSQL migration rules for schema changes, data changes, backfills, rollbacks, ownership, and documentation sync.
-->

# Database Migration Standards

This document defines database migration standards for Login App 2.0.

These standards apply to Laravel migrations targeting PostgreSQL.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Core Rule](#3-core-rule)
- [4. PostgreSQL Standard](#4-postgresql-standard)
- [5. Migration Shape](#5-migration-shape)
- [6. Destructive Change Rule](#6-destructive-change-rule)
- [7. Additive-First Rule](#7-additive-first-rule)
- [8. Table Creation Rules](#8-table-creation-rules)
- [9. Foreign Key Rules](#9-foreign-key-rules)
- [10. Index Rules](#10-index-rules)
- [11. Data Migration And Backfill Rules](#11-data-migration-and-backfill-rules)
- [12. Seeder Rules](#12-seeder-rules)
- [13. Settings And Registry Migration Rules](#13-settings-and-registry-migration-rules)
- [14. Rollback Rules](#14-rollback-rules)
- [15. Documentation Sync](#15-documentation-sync)
- [16. Testing And Verification](#16-testing-and-verification)
- [17. Stop Conditions](#17-stop-conditions)
- [18. Related](#18-related)

---

## 1. Purpose

Keep database schema changes safe, reviewable, reversible where practical, and aligned with canonical database documentation.

Migrations must preserve data, protect tenant or workspace boundaries, and make schema intent clear before implementation.

---

## 2. Scope

This standard applies to:

- Laravel migration files
- schema changes
- index changes
- constraints
- data backfills
- registry table changes
- seeders that support required baseline data
- Core, Platform, and Business Module database changes

This standard does not apply to legacy Perfex `install.php` module installers except when reviewing historical reference material.

New Login App 2.0 database changes must use Laravel migrations.

---

## 3. Core Rule

Every database change must have a clear owner, a clear purpose, and a safe migration path.

Before creating a migration, identify:

- owning layer: Core, Platform, Business Module, UI, Ops, or Docs
- affected table or tables
- whether the change is schema-only, data-only, or both
- whether existing data must be preserved or transformed
- whether the change is reversible
- affected indexes, constraints, policies, tests, and docs

If the ownership or safety path is unclear, do not create the migration yet.

---

## 4. PostgreSQL Standard

PostgreSQL is the active database target for Login App 2.0.

Use PostgreSQL-compatible schema choices and avoid MySQL-only assumptions.

Rules:

- use PostgreSQL-compatible column types and indexes
- use `jsonb` only for metadata, extension points, snapshots, or flexible payloads
- do not use `jsonb` as a substitute for core relational structure
- avoid database enum types for values likely to change; prefer text/check constraints, lookup tables, registries, or application enums depending on ownership
- use timezone-aware timestamps where event time, audit time, security time, or operational time matters
- do not use floating point types for money, quantities requiring exact precision, or financial calculations
- avoid PostgreSQL extensions unless explicitly approved and documented
- do not assume a migration is safe for large tables without reviewing lock, backfill, and deployment impact

---

## 5. Migration Shape

A migration should have one primary purpose.

Good migration scopes:

- create one table and its indexes
- add a related group of columns to one table
- create a join table
- add required indexes for a specific query path
- add constraints for a specific integrity rule
- perform a clearly scoped data backfill

Avoid migrations that combine unrelated schema changes across multiple capabilities.

A migration name should describe the result, not the implementation mechanics.

Examples:

- `create_user_contact_emails_table`
- `add_type_key_to_notifications_table`
- `create_module_contribution_registry_tables`
- `add_expires_at_to_api_tokens_table`

---

## 6. Destructive Change Rule

Avoid destructive schema changes unless explicitly planned, backed up, and approved.

Destructive changes include:

- dropping tables
- dropping columns
- changing column types with possible data loss
- changing nullability when existing rows may violate the new constraint
- renaming keys or values used by application code
- deleting or rewriting production data
- changing uniqueness or foreign key behavior in a way that can reject existing data

When destructive change is required, the plan must identify:

- affected data
- backup or recovery path
- deployment order
- rollback or mitigation path
- verification steps
- affected canonical docs
- whether a runbook or release note is required

---

## 7. Additive-First Rule

Prefer additive migrations first.

Safer sequence for risky changes:

1. add new nullable column, table, index, or relationship
2. deploy code that writes both old and new structures if needed
3. backfill safely
4. verify reads and writes
5. switch reads to the new structure
6. remove old structure only after explicit cleanup approval

Do not collapse high-risk migration sequences into one irreversible migration.

---

## 8. Table Creation Rules

When creating a table, define:

- primary key strategy
- required ownership/scope columns
- foreign keys
- indexes
- unique constraints
- timestamps
- soft delete behavior when applicable
- status/lifecycle fields when applicable
- audit fields when applicable
- data classification implications when applicable

Business Module tables should include the required tenant, workspace, account, customer, or module scope according to the module contract.

Core tables should declare the Core capability that owns them.

Platform tables should not become hidden owners of business-module data.

---

## 9. Foreign Key Rules

Prefer explicit foreign keys for stable relationships.

Foreign keys should be used for:

- ownership
- scoped records
- join tables
- required parent-child relationships
- security-sensitive relationships
- audit-sensitive relationships
- data integrity boundaries

Avoid soft relationship columns where stable foreign keys are required.

Polymorphic relationships must be justified before use and should not be used for core security, access, finance, ownership, or data-protection boundaries unless explicitly documented.

---

## 10. Index Rules

Indexes should be designed around expected lookup paths.

Add indexes for:

- foreign keys
- scoped lookups
- unique keys
- status filters
- date-range queries
- audit/security event lookups
- token prefix lookups
- frequently filtered registry keys
- tenant/workspace/module scoped uniqueness

Avoid speculative indexes that do not support an identified query, constraint, or access pattern.

When adding indexes to large existing tables, consider deployment and lock impact before implementation.

---

## 11. Data Migration And Backfill Rules

Data backfills must be safe, idempotent where practical, and scoped.

Backfills should:

- avoid loading large tables into memory
- process records in chunks when needed
- be restartable when practical
- avoid destructive rewrites unless explicitly approved
- log or report failure paths when operationally useful
- preserve existing data
- define verification steps

Do not hide large operational data corrections inside an unrelated schema migration.

For complex or production-sensitive backfills, create a runbook or dedicated command instead of relying only on a migration.

---

## 12. Seeder Rules

Seeders should create required baseline data, registries, permissions, system defaults, or local/demo data when appropriate.

Seeders must be deterministic and safe to rerun.

Seeders must not hide required application behavior.

Permission, registry, and settings seeders must preserve stable keys after release.

Local/demo seeders must not be required for production correctness.

---

## 13. Settings And Registry Migration Rules

Settings, preference, registry, and contribution keys must be treated as stable public contracts once released.

Renaming keys requires explicit migration planning.

For setting or registry changes, define:

- owning capability or module
- stable key
- display label when applicable
- default value
- data type
- validation rules
- scope
- permission requirement
- audit requirement
- docs owner

Secret-bearing settings must follow Settings Data Governance and Secrets standards.

---

## 14. Rollback Rules

Rollback should be possible when practical, but rollback must not create unsafe data loss.

If a migration cannot be safely reversed, the migration should make that clear and the work summary should explain why.

Rollback for destructive production changes should be handled through planned recovery steps, not improvised after failure.

---

## 15. Documentation Sync

Update database documentation when migrations change schema or data contracts.

Potential docs to update:

- `docs/06-database/index.md`
- table docs under `docs/06-database/tables/`
- feature contracts under `docs/06-database/feature-contracts/`
- relevant Core, Platform, or Module planning docs
- canonical feature or architecture docs
- runbooks when operational steps are required

Use:

- [Schema Design Standards](Schema%20Design%20Standards.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)

---

## 16. Testing And Verification

Migration work should verify:

- migration runs successfully
- rollback works when practical
- affected tests pass
- expected indexes and constraints exist
- required defaults are applied
- nullable and non-nullable behavior is correct
- seeders or registries are safe to rerun
- affected application behavior still works
- database docs match the schema

For sensitive changes, also verify denied access, data scope, audit behavior, and protected data handling.

---

## 17. Stop Conditions

Stop before writing or running a migration when:

- ownership is unclear
- destructive impact is possible but not planned
- existing data may violate a new constraint
- a large table may be locked or rewritten
- a key rename could break existing references
- a sensitive setting or secret may be exposed
- tenant/workspace scope is unclear
- the rollback or recovery path is unknown
- database docs cannot be updated accurately

---

## 18. Related

- [Schema Design Standards](Schema%20Design%20Standards.md)
- [Settings Data Governance Standards](Settings%20Data%20Governance%20Standards.md)
- [Testing Standards](../coding/Testing%20Standards.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Database Index](../../06-database/index.md)
- [Standards Index](../index.md)