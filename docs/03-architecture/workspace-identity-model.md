<!--
DOC-META
title: Tenant, Instance, User Account, And Workspace Model
doc_type: architecture
status: active
owner: architecture
canonical: true
canonical_path: docs/03-architecture/workspace-identity-model.md
parent: docs/03-architecture/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines one-to-one Tenant and Instance ownership, Tenant-owned User Accounts and User Identity records, and User Account-specific runtime Workspaces.
-->

# Tenant, Instance, User Account, And Workspace Model

Parent: [Architecture Index](index.md)

> Compatibility note: the existing filename is retained temporarily to avoid broad link migration. Workspace is not an identity or persistent container.

## 1. Canonical Structure

```text
Tenant
└── exclusively owns one Instance
    └── owns User Accounts
        └── each User Account contains one User Identity
            └── each authenticated Account receives a resolved Workspace
```

Cardinality:

```text
Tenant 1 -- 1 Instance
Instance 1 -- many User Accounts
User Account 1 -- 1 User Identity
User Account 1 -- 1 resolved Workspace per active authenticated runtime
```

There is no multi-Tenant Instance in the current target model.

## 2. Tenant

Tenant is the organization or group that exclusively owns one Instance and its Tenant-specific application state.

A Tenant is not a Workspace, User Account, domain, database connection, role, group, or ordinary customer business record.

## 3. Instance

Instance is the logical isolation boundary containing Tenant-specific application state:

- Module installation and activation state
- configuration and setup state
- User Accounts and access assignments
- business data
- notifications
- audit records
- operational records

An Instance may use shared application code or infrastructure while preserving isolated state.

Deactivating a Tenant deactivates its Instance and associated User Accounts. Ordinary authentication and runtime operations must fail closed.

## 4. User Account And User Identity

A User Account is the Tenant-owned, Instance-specific human Principal and participation record.

A User Identity is the identifying and profile subset of that one Account.

A person participating in multiple Tenants has separate Accounts and separate User Identity records. Similar profile data does not establish a cross-Tenant identity relationship.

## 5. Workspace Resolution

A Workspace is resolved for one authenticated User Account from:

1. Tenant and Instance resolution
2. Instance configuration
3. active Modules and setup state
4. User Account lifecycle and authentication assurance
5. roles, permissions, memberships, assignments, and resource restrictions
6. settings, preferences, and presentation state

The resolved Workspace determines available Surfaces, navigation, Actions, resources, data, and presentation.

Workspace is not:

- a database boundary
- a stored Tenant container
- a persistent organization record
- a Principal
- an authorization grant

## 6. Internal Tenant And Global Administration

The Internal Tenant follows the same model.

```text
Internal Tenant Instance
└── User Account
    └── resolved Workspace
        ├── ordinary Tenant Surfaces
        └── Global Administration Surface when authorized
```

Global Administration preserves the Internal Tenant Actor scope and the target Tenant and Instance scope independently.

## 7. Resolution Order

Target runtime order:

1. resolve Tenant and Instance from the accepted resolver
2. reject unknown or inactive Tenant/Instance state
3. authenticate the User Account or Non-Human Identity against the resolved Instance
4. resolve Account lifecycle and authorization state
5. load Instance configuration and active Modules
6. assemble the User Account-specific Workspace
7. render or execute only authorized Surfaces and Actions

## 8. Deferred Implementation

This architecture does not select:

- Tenant or Instance table design
- database-per-Instance versus another enforceable storage topology
- domain resolver implementation
- User Account and User Identity table shape
- Global Administration packaging
- route migration
- cross-Tenant federation

## 9. Related

- [ADR-0006](../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [System Overview](system-overview.md)
- [Tenancy](tenancy.md)
- [Auth Architecture](auth.md)
