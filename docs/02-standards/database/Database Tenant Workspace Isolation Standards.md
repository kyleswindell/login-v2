<!--
DOC-META
title: Database Tenant Workspace Isolation Standards
doc_type: standard
status: active
owner: data
canonical: true
canonical_path: docs/02-standards/database/Database Tenant Workspace Isolation Standards.md
parent: docs/02-standards/database/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines database rules for tenant, workspace, account, customer, module, and scope isolation across Core, Platform, and Business Module data.
-->

# Database Tenant Workspace Isolation Standards

This document defines database isolation standards for tenant, workspace, account, customer, module, and scoped business data in Login App 2.0.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Core Rule](#3-core-rule)
- [4. Scope Types](#4-scope-types)
- [5. Scope Column Rules](#5-scope-column-rules)
- [6. Scoped Uniqueness](#6-scoped-uniqueness)
- [7. Foreign Key Scope Consistency](#7-foreign-key-scope-consistency)
- [8. Cross-Scope Query Rules](#8-cross-scope-query-rules)
- [9. Core Data Versus Business Data](#9-core-data-versus-business-data)
- [10. Platform Metadata Versus Business Records](#10-platform-metadata-versus-business-records)
- [11. Module Data Isolation](#11-module-data-isolation)
- [12. Access Control Target Scope](#12-access-control-target-scope)
- [13. Audit Scope](#13-audit-scope)
- [14. Testing Expectations](#14-testing-expectations)
- [15. Documentation Expectations](#15-documentation-expectations)
- [16. Stop Conditions](#16-stop-conditions)
- [17. Related](#17-related)

---

## 1. Purpose

Prevent cross-scope data leakage, ambiguous ownership, and unsafe query patterns.

Database schema must make scope visible, enforceable, and testable.

---

## 2. Scope

This standard applies to:

- tenant-scoped tables
- workspace-scoped tables
- account-scoped tables
- customer-scoped tables
- module-scoped tables
- user-owned records
- Core capability records with scoped targets
- Platform registry or contribution tables
- Business Module tables
- access-control assignments
- audit and monitoring records tied to scoped resources

---

## 3. Core Rule

Every scoped table must make scope explicit.

A table that stores scoped data must identify:

- the scope type
- the scope column or relationship
- scoped uniqueness rules
- query patterns
- access-control implications
- audit implications
- tests or verification for cross-scope denial

If the scope is unclear, do not create or modify the table yet.

---

## 4. Scope Types

Common scope types include:

| Scope       | Meaning                                               |
| ----------- | ----------------------------------------------------- |
| global      | System-wide and not tenant/workspace-specific.        |
| platform    | Platform-control-plane owned.                         |
| tenant      | Owned by or isolated to one tenant.                   |
| workspace   | Owned by or isolated to one workspace.                |
| account     | Owned by or isolated to one account/customer account. |
| customer    | Owned by or isolated to one customer record.          |
| user        | Owned by one user.                                    |
| module      | Owned by one Business Module or module instance.      |
| integration | Owned by an integration or service account.           |

Use the smallest accurate scope.

Do not use global tables for scoped business data unless the table explicitly models scoped targets.

---

## 5. Scope Column Rules

Scoped tables should include explicit scope columns or stable relationships to scoped owners.

Examples:

- `tenant_id`
- `workspace_id`
- `account_id`
- `customer_id`
- `module_key`
- `user_id`

If scope is inherited through a parent relationship, document the inheritance path in the table contract.

Do not rely on route parameters, session state, or UI context alone to determine record scope.

---

## 6. Scoped Uniqueness

Unique constraints for scoped data should include scope.

Examples:

- user email uniqueness may be global or scoped depending on identity model
- module setting keys may be unique per scope
- customer part numbers may be unique per customer or workspace
- registry entries may be unique by owner and key

Do not create global uniqueness constraints for scoped business facts unless global uniqueness is truly required.

---

## 7. Foreign Key Scope Consistency

Foreign keys should preserve scope consistency.

When a table references another scoped table:

- verify both records belong to the same tenant/workspace/account/customer scope
- enforce scope consistency through schema design where practical
- enforce remaining scope consistency in policies, services, or validation
- document scope inheritance in table docs

Avoid relationships that allow a child record to point across scopes unless explicitly allowed and audited.

---

## 8. Cross-Scope Query Rules

Queries against scoped tables must include the required scope unless the operation is explicitly global and authorized.

High-risk queries include:

- admin list views
- search
- exports
- reports
- background jobs
- dashboards
- API endpoints
- webhook processing
- audit/evidence lookups
- bulk operations

Do not implement broad queries first and filter scope later in memory.

---

## 9. Core Data Versus Business Data

Core tables may be global, scoped, or mixed depending on the capability.

Examples:

- Auth tables may be global to identity.
- Access assignments may target scoped resources.
- Audit events may be central but include scoped targets.
- Notifications may be user-scoped while type registry is global.
- Data governance records may classify scoped business data.

Business Module tables must not redefine Core-level tenant/workspace identity, auth, access, audit, or notification infrastructure.

---

## 10. Platform Metadata Versus Business Records

Platform tables may aggregate or render contributions from Core and Business Modules.

Platform tables should not become hidden owners of business records.

If a Platform table references module-owned data, document:

- source owner
- target owner
- scope
- read/write behavior
- whether Platform stores a copy, reference, projection, or registry entry

---

## 11. Module Data Isolation

Business Module data must declare its isolation model before schema is implemented.

A module table should identify:

- module owner
- scope owner
- tenant/workspace/account/customer relationship
- whether records are visible across modules
- whether records can be exported
- whether records are included in audit/data governance processes

Module migrations must not create ambiguous global tables for scoped business data.

---

## 12. Access Control Target Scope

Access-control data must identify the target scope of an assignment.

Assignments should be able to answer:

- who or what is the subject
- what target is being accessed
- which role or action applies
- which scope limits the assignment
- whether the assignment expires
- why the assignment exists
- whether the assignment is direct or group-derived

Do not store access-control assignments without enough scope to compute effective access safely.

---

## 13. Audit Scope

Audit and evidence records should include enough scope to reconstruct what happened.

Audit events should include:

- actor
- action
- target
- result
- target scope when applicable
- request/session/correlation identifiers when applicable
- redacted metadata

Central audit tables may store events for many scopes, but the scoped target must be explicit.

---

## 14. Testing Expectations

Scoped data changes should verify:

- allowed access within scope
- denied access outside scope
- scoped uniqueness
- scoped search/listing
- scoped exports when applicable
- background jobs do not cross scopes
- module-owned data does not bypass Core access rules

Do not test only successful admin paths.

---

## 15. Documentation Expectations

Scoped tables must document:

- scope type
- scope columns
- inherited scope path when applicable
- scoped uniqueness
- cross-scope risks
- access-control expectations
- data classification
- audit expectations

Update table docs and feature/database contracts when scope changes.

---

## 16. Stop Conditions

Stop before implementing scoped data when:

- the tenant/workspace/account model is unclear
- scope is inherited but not documented
- a table could accidentally mix tenant/workspace data
- a report/export/search would need cross-scope access
- scoped uniqueness is unclear
- access-control target scope is unclear
- audit target scope is unclear
- tests for denied cross-scope access cannot be identified

---

## 17. Related

- [Schema Design Standards](Schema%20Design%20Standards.md)
- [Database Table Contract Standards](Database%20Table%20Contract%20Standards.md)
- [Database Access Control Data Model Standards](Database%20Access%20Control%20Data%20Model%20Standards.md)
- [Database Audit And Evidence Standards](Database%20Audit%20And%20Evidence%20Standards.md)
- [Platform Boundary](../../03-architecture/platform-boundary.md)
- [Database Index](../../06-database/index.md)
- [Standards Index](../index.md)