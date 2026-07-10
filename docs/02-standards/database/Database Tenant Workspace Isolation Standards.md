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
summary: Defines database rules for one-to-one Tenant and Instance isolation, Account and resource scope, Module data, Global Administration, and audit evidence.
-->

# Database Tenant Workspace Isolation Standards

Parent: [Database Standards Index](index.md)

> Compatibility note: the existing filename is retained temporarily. Workspace is not a persistent database scope.

## 1. Purpose

Prevent cross-Tenant and cross-Instance data leakage, ambiguous ownership, and unsafe query patterns.

Database design must make Instance, Account, resource, and cross-Instance administrative scope enforceable and testable.

## 2. Core Model

```text
Tenant 1 -- 1 Instance
Instance 1 -- many User Accounts
User Account 1 -- 1 User Identity
```

One Instance must not contain mutable state owned by multiple Tenants.

Workspace is resolved at runtime and must not be modeled as a general persistent ownership container.

## 3. Scoped Table Contract

A scoped table must identify:

- owning capability
- Tenant and Instance relationship
- direct or inherited scope path
- Account or NHI relationship when applicable
- Target resource scope
- scoped uniqueness
- query patterns
- authorization implications
- audit implications
- cross-scope denial tests

If scope is unclear, do not create or modify the table.

## 4. Canonical Scope Types

Common persistent scope types include:

| Scope | Meaning |
| --- | --- |
| `global` | Truly application-wide reference or infrastructure data that is not Tenant-owned. |
| `tenant_instance` | Owned by exactly one Tenant and its one Instance. |
| `user_account` | Owned by or associated with one User Account in one Instance. |
| `nhi` | Owned by or associated with one Non-Human Identity in one Instance. |
| `customer` | Owned by one customer business record inside one Instance. |
| `resource` | Owned by a specific capability resource inside one Instance. |
| `module` | Owned by a Module while still scoped to the applicable Instance. |
| `integration` | Owned by an integration relationship or NHI inside one Instance. |
| `global_administration` | Cross-Instance administrative metadata with explicit Actor and target Instance scope. |

Do not use `workspace` as a generic persistent scope type.

Do not use bare `account` when `user_account`, customer account, or billing account could be confused.

## 5. Scope Columns And Relationships

Use explicit columns or stable relationships such as:

- `tenant_id`
- `instance_id`
- `user_account_id`
- `non_human_identity_id`
- `customer_id`
- `resource_id`
- `module_key`

The final schema may infer Tenant from a one-to-one Instance relationship, but contracts must still state both conceptual owners.

If scope is inherited, document the complete path.

Do not rely on route parameters, session state, Workspace state, or UI context alone.

## 6. User Account And User Identity

User Accounts and User Identity records belong to one Instance.

A human with access to multiple Tenants has separate Account and User Identity records.

Database design must not create a canonical global person row that automatically links Tenant Accounts.

Matching email, phone, name, or external directory value must not create cross-Tenant joins or authorization.

Global uniqueness for human profile fields requires a separate explicit decision and must not imply shared identity.

## 7. Non-Human Identity

NHI records must state their permitted Instance scope.

Service Account, Workload Identity, and Application Principal persistence may differ, but none may silently authorize another Instance.

Machine Identity is independent assurance context and must not be forced into the NHI owner hierarchy.

## 8. Scoped Uniqueness

Unique constraints for Tenant-owned data must include or inherit Instance scope.

Examples:

- User Account login identifiers may be unique within one Instance
- Module setting keys may be unique per Instance
- business identifiers may be unique per Instance, customer, or resource
- NHI keys may be unique per Instance
- registry entries may be unique by owner and key

Do not create global uniqueness solely to infer shared human identity.

## 9. Foreign-Key Scope Consistency

When one scoped record references another:

- verify both belong to the same Instance unless the relationship is explicitly cross-Instance
- enforce consistency through schema where practical
- enforce remaining consistency through policies, services, and validation
- document inherited scope
- audit allowed cross-Instance relationships

Avoid relationships that permit accidental cross-Instance references.

## 10. Query Isolation

Queries against Tenant-owned data must begin from the resolved Instance.

High-risk queries include:

- administration lists
- search
- exports
- reports
- dashboards
- background jobs
- event consumers
- scheduled tasks
- APIs
- webhooks
- audit and evidence lookups
- bulk operations

Do not query broadly and filter later in memory.

## 11. Global Administration Data

Global Administration may store central registry, provisioning, lifecycle, support, compliance, or operations metadata.

It must not become the hidden owner of Tenant business records.

Cross-Instance records must identify:

- Actor Tenant and Instance
- target Tenant and Instance
- Action or operation type
- purpose or support context
- read, write, copy, projection, or reference behavior
- audit requirements
- retention and data-classification requirements

Raw Tenant data must not be copied centrally by default.

## 12. Core And Module Data

Core and Module tables may be Tenant-Instance-scoped, Account-scoped, NHI-scoped, or resource-scoped.

Modules must not redefine Tenant, Instance, User Account, User Identity, Auth, Access, Audit, Notification, or NHI infrastructure.

Each Module table must document:

- Module owner
- Instance scope
- Account or NHI associations
- resource ownership
- visibility to other Modules
- export and governance requirements
- audit expectations

## 13. Access-Control Data

Access assignments must answer:

- which Principal is the subject
- which Action or permission applies
- which target resource is affected
- which Tenant and Instance limit the assignment
- whether the assignment expires
- why it exists
- whether it is direct or derived

Do not store assignments without enough scope to compute effective access safely.

## 14. Audit And Evidence Data

Audit records must include enough information to reconstruct:

- Principal
- Machine Identity reference when available
- Network Identity reference when available
- Network Context when applicable
- Invocation Channel
- Action
- Target
- Result
- Actor Tenant and Instance
- target Tenant and Instance when different
- correlation identifiers
- redacted metadata

Workspace may be recorded as runtime context but is not the ownership boundary.

## 15. Lifecycle

Tenant and Instance deactivation must block ordinary mutation and authentication paths.

Database retention, archival, legal hold, erasure, and deletion must be explicit and must not be inferred from deactivation alone.

## 16. Tests

Scoped data changes must verify:

- allowed access within one Instance
- denied access to another Instance
- User Account isolation
- NHI isolation
- scoped uniqueness
- search, aggregate, export, and report isolation
- queue, event, and schedule revalidation
- Global Administration target scope
- Module data cannot bypass Core isolation
- Workspace is not used as persistent authorization scope

## 17. Documentation

Table contracts must document:

- Tenant and Instance owner
- scope columns or inherited path
- Account, NHI, customer, resource, and Module associations
- uniqueness
- cross-Instance risk
- authorization
- data classification
- audit
- lifecycle
- compatibility names

## 18. Stop Conditions

Stop when:

- Tenant and Instance ownership is unclear
- a design permits multiple Tenants in one Instance
- User Account or User Identity could cross Instance boundaries
- Workspace is treated as persistent ownership
- scope inheritance is undocumented
- reports or exports require unbounded cross-Instance access
- uniqueness would create implicit global identity
- Global Administration target scope is missing
- denied cross-scope tests cannot be identified

## 19. Related

- [ADR-0006](../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [Schema Design Standards](Schema%20Design%20Standards.md)
- [Database Table Contract Standards](Database%20Table%20Contract%20Standards.md)
- [Database Access Control Data Model Standards](Database%20Access%20Control%20Data%20Model%20Standards.md)
- [Database Audit And Evidence Standards](Database%20Audit%20And%20Evidence%20Standards.md)
- [Tenant And Scope Isolation Standards](../security/Tenant%20And%20Scope%20Isolation%20Standards.md)
- [Tenancy](../../03-architecture/tenancy.md)
