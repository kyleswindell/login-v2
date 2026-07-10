<!--
DOC-META
title: System Overview
doc_type: architecture
status: active
owner: architecture
canonical: true
canonical_path: docs/03-architecture/system-overview.md
parent: docs/03-architecture/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines Login 2.0 as shared application code operating isolated one-Tenant Instances with User Account-specific Workspaces and authorized Global Administration.
-->

# System Overview

Parent: [Architecture Index](index.md)

## 1. System Model

Login 2.0 is one Laravel application codebase capable of operating isolated Tenant Instances.

Canonical ownership and runtime structure:

```text
Tenant
└── exclusively owns one Instance
    └── owns User Accounts
        └── each authenticated Account receives a resolved Workspace
```

One Tenant owns one Instance, and one Instance belongs to one Tenant.

An Instance is the logical data and configuration isolation boundary. Shared code or infrastructure does not imply shared Tenant state.

## 2. Internal Tenant

Parasolutions operates as the Internal Tenant and uses the same Instance, User Account, User Identity, and Workspace model as client Tenants.

Authorized Internal Tenant Workspaces may render a Global Administration Surface. Global Administration is not a separate Tenant, Instance, Workspace, or identity realm.

## 3. Workspace

Workspace is the User Account-specific runtime and user-experience scope assembled from:

- Tenant and Instance resolution
- Instance configuration and active Modules
- User Account access
- User Account personalization

Workspace is not a persistent data boundary.

## 4. Principal And Assurance Model

Human access uses a Tenant-owned User Account as the Principal.

Non-human access uses a Non-Human Identity such as a Service Account, Workload Identity, or Application Principal.

Machine Identity, Network Identity, and Network Context may accompany either human or non-human Principals as independent assurance context.

## 5. Execution Model

Actor attribution preserves:

- Principal
- Machine Identity when available
- Network Identity when available
- Network Context when applicable
- Invocation Channel
- Action
- Target
- Result
- Tenant Instance scope

Canonical Invocation Channels are:

- `interactive_web`
- `api_request`
- `webhook_request`
- `console_command`
- `queued_job`
- `event_consumer`
- `scheduled_task`
- `internal_system`

## 6. Ownership Boundaries

- Core owns required base-application behavior and contracts.
- Modules own optional distributable feature packages.
- UI owns reusable Elements, Components, Patterns, Layouts, CSS, JavaScript, icons, contracts, tests, and review evidence.
- Tenant and Instance state is isolated even when code and infrastructure are shared.
- Global Administration requires explicit authorization and preserves Actor and target Tenant Instance scope independently.

## 7. Related

- [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
- [ADR-0006: Tenant, Instance, Workspace, Principal, Actor, And Invocation Vocabulary](../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [Tenant, Instance, User Account, And Workspace Model](workspace-identity-model.md)
- [Tenancy](tenancy.md)
- [Module System](module-system.md)
- [Auth Architecture](auth.md)
