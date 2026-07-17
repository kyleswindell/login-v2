<!--
DOC-META
title: Tenancy
doc_type: architecture
status: active
owner: architecture
canonical: true
canonical_path: docs/03-architecture/tenancy.md
parent: docs/03-architecture/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines exclusive one-to-one Tenant and Instance ownership and the logical isolation contract for Tenant-owned state.
-->

# Tenancy

Parent: [Architecture Index](index.md)

## 1. Model

Login 2.0 uses exclusive one-to-one Tenant and Instance ownership:

```text
One Tenant -> One Instance
One Instance -> One Tenant
```

There is no multi-Tenant Instance in the current target model.

## 2. Isolation Contract

Each Instance must isolate:

- User Accounts and User Identity records
- authentication and MFA state
- roles, permissions, memberships, and assignments
- Module installation and activation state
- configuration and setup state
- business data
- notifications
- audit and operational history
- queued, scheduled, webhook, API, and integration activity

Shared application code, deployment infrastructure, or database infrastructure must not create shared Tenant authority or mutable Tenant state.

The final physical storage topology remains a later database and deployment decision. The logical isolation contract is mandatory regardless of topology.

## 3. Tenant Resolution

Tenant and Instance resolution must occur before Tenant-owned authentication, data access, Module evaluation, or Workspace assembly.

A resolver may use domain, hostname, registry metadata, or another accepted mechanism. Resolver values identify the Tenant and Instance but are not themselves the Tenant or Instance.

Unknown, inactive, suspended, or deactivated Tenant and Instance state must fail closed.

## 4. Workspace

Workspace availability is resolved for one authenticated User Account after Tenant and Instance resolution.

A User Account may have access to one or more Workspaces. Exactly one Workspace is active in a rendered context.

Workspace is not a persistent Tenant scope, database boundary, registry record, or authorization grant.

## 5. Internal Tenant

The Internal Tenant follows the same isolation contract as client Tenants.

Authorized Internal Tenant User Accounts may access the Global Administration Workspace. That Workspace does not collapse Internal Tenant data with client Tenant data.

## 6. Cross-Instance Administration

Global Administration or support operations must preserve:

- Internal Tenant Actor Principal
- Actor Machine and Network assurance when available
- Actor Instance scope
- target Tenant and Instance
- explicit authorization
- reason or support context when required
- Action, Target, Result, and audit evidence
- step-up authentication when required

No cross-Instance operation may rely on implicit shared session state or unscoped queries.

## 7. Lifecycle

Tenant deactivation deactivates its Instance and Accounts and blocks ordinary runtime activity.

Retention, legal hold, archival, export, erasure, and physical deletion are separate Data Governance and Data Protection decisions.

## 8. Related

- [ADR-0006](../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [ADR-0008](../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
- [Workspace Navigation And Frame Composition](workspace-navigation-and-frame-composition.md)
- [System Overview](system-overview.md)
- [Tenant, Instance, User Account, And Workspace Model](workspace-identity-model.md)
- [Auth Architecture](auth.md)
