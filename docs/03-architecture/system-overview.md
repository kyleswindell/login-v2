<!--
DOC-META
title: System Overview
doc_type: architecture
status: active
owner: architecture
canonical: true
canonical_path: docs/03-architecture/system-overview.md
parent: docs/03-architecture/index.md
template: docs/09-reference/templates/docs/_architecture-note.md
summary: Defines Login 2.0 as shared application code operating isolated one-Tenant Instances with Tenant-owned User Accounts, multiple available Workspaces, one active Workspace, explicit application owners, and authorized Global Administration.
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
        └── each authenticated Account may access one or more Workspaces
            └── exactly one Workspace is active in a rendered context
```

One Tenant owns one Instance, and one Instance belongs to one Tenant.

An Instance is the logical data and configuration isolation boundary. Shared code or infrastructure does not imply shared Tenant state.

## 2. Internal Tenant

Parasolutions operates as the Internal Tenant and uses the same Instance, User Account, User Identity, Workspace, Principal, and Actor model as client Tenants.

Authorized Internal Tenant User Accounts may access the Global Administration Workspace.

Global Administration is not a separate Tenant, Instance, identity realm, application owner, or repository root.

## 3. Workspace And Frame

A Workspace is a named top-level rendered experience available to an authenticated User Account.

A User Account may have one or more available Workspaces. Exactly one Workspace is active for a rendered interaction context.

The active Workspace supplies high-level Product scope and Frame composition. The persistent Frame provides the global header, sidebar, Main Content Outlet, skip-link behavior, landmarks, and responsive disclosure.

Workspace is not a persistent data boundary or authorization grant. Named Frame Surfaces are compositional regions, not application owners or generic presentation folders. Main is a content outlet rather than a Frame Surface.

## 4. Principal And Assurance Model

Human access uses a Tenant-owned User Account as the Principal.

Non-human access uses a Non-Human Identity such as a Service Account, Workload Identity, or Application Principal.

Machine Identity, Network Identity, and Network Context may accompany either human or non-human Principals as independent assurance context.

## 5. Execution Model

Actor attribution preserves:

- Principal;
- Machine Identity when available;
- Network Identity when available;
- Network Context when applicable;
- Invocation Channel;
- Action;
- Target;
- Result;
- Tenant Instance scope.

Canonical Invocation Channels are:

- `interactive_web`;
- `api_request`;
- `webhook_request`;
- `console_command`;
- `queued_job`;
- `event_consumer`;
- `scheduled_task`;
- `internal_system`.

Invocation Channels describe how work enters or executes. They do not create application ownership.

## 6. Application Ownership

Login 2.0 uses three application source-of-truth owners:

| Owner | Responsibility |
| --- | --- |
| Core | Required base-application capabilities, contracts, state, coordination, and lifecycle behavior |
| Modules | Optional, cohesive, independently understandable and distributable feature packages |
| UI | Reusable Elements, Components, Patterns, Layouts, presentation contracts, and reusable UI runtime infrastructure |

Laravel provides the framework, runtime, and application-composition boundaries. It is not a competing application owner.

A Frame Surface is a named compositional region of the persistent Frame. A Registry is owned by the Host capability or Module it extends. Delivery Adapters expose owner behavior through HTTP, console, webhook, queue, scheduler, or other invocation channels without owning that behavior. Product Pages remain owned by their Core capability or Module, while UI owns reusable Frame rendering.

Cross-owner synchronous behavior uses provider-owned public Contracts. Events communicate completed facts to independent consumers, Jobs represent deliberately deferred work, and Host Contributions extend explicit Host-owned Extension Points.

## 7. Repository Architecture

The accepted target repository structure organizes:

- required capabilities beneath `app/Core/`, including Core Navigation at `app/Core/Navigation/`;
- reusable UI PHP and runtime infrastructure beneath `app/UI/`;
- optional packages beneath repository-root `Modules/`;
- application-wide Laravel integration beneath restricted root `app/Http/`, `app/Console/`, and `app/Providers/`;
- presentation source through owner-visible artifact bundles;
- tests beside their smallest clear owner, with repository-wide suites retained at root;
- owner-controlled registration descriptors composed through a deterministic Application Registration System.

Current `app/Platform`, peer `app/Surfaces`, generic support branches, direct-root Module PHP layouts, and parallel component CSS and JavaScript trees are transitional rather than target architecture.

See [Repository Architecture](repository-architecture.md) for the canonical repository topology, package patterns, artifact placement, dependency direction, resource structure, test locations, supporting branches, and transitional paths.

See [Application Registration](application-registration.md) for descriptor ownership, deterministic compilation, generated manifests, root registration, Typed Registrars, and the distinction between application composition and Host Registries.

## 8. Tenant And Scope Boundaries

- Tenant and Instance state remains isolated even when code and infrastructure are shared.
- Workspace determines the active top-level rendered experience for one User Account; route and Action authorization remain separately enforced.
- Global Administration requires explicit authorization.
- Actor scope and target Tenant Instance scope remain independently attributable.
- Modules and UI do not bypass Core access, security, audit, data-protection, or lifecycle responsibilities.

## 9. Related

- [Repository Architecture](repository-architecture.md)
- [Application Registration](application-registration.md)
- [Workspace Navigation And Frame Composition](workspace-navigation-and-frame-composition.md)
- [Stack Overview](stack-overview.md)
- [Tenant, Instance, User Account, And Workspace Model](workspace-identity-model.md)
- [Tenancy](tenancy.md)
- [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
- [ADR-0006: Tenant, Instance, Workspace, Principal, Actor, And Invocation Vocabulary](../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [ADR-0007: Owner, Registry, And Identifier Key Conventions](../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [ADR-0008: Workspace, Navigation Hierarchy, And Frame Surface Model](../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
