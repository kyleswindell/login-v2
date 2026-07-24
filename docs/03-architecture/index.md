<!--
DOC-META
title: Architecture Index
doc_type: index
status: active
owner: architecture
canonical: true
canonical_path: docs/03-architecture/index.md
parent: docs/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes canonical Login 2.0 system, repository, application-registration, public Contract, persistent-data, Workspace, Frame, navigation, stack, and tenancy architecture.
-->

# Architecture Index

Parent: [Documentation Index](../index.md)

## 1. Purpose

This branch is the canonical owner for system structure, architectural boundaries, repository topology, tenancy shape, runtime scope, stack structure, and other high-level design.

Behavior, workflow steps, schema details, implementation standards, planning, operations procedures, and active delivery state belong to their applicable documentation owners.

## 2. Architecture Documents

| Document                                                                                    | Owns                                                                                                                                                                                                                              |
| ------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [System Overview](system-overview.md)                                                       | High-level system, Tenant Instance, Workspace, Principal, execution, and application ownership model                                                                                                                              |
| [Repository Architecture](repository-architecture.md)                                       | Target repository topology, accepted naming relationships, owner-local artifact placement, dependency direction, presentation and test topology, supporting branches, exceptions, and transitional structures                     |
| [Application Registration](application-registration.md)                                     | Registration responsibilities, conditional custom-artifact naming, deterministic compilation, generated manifests, root composition, Typed Registrars, and native Laravel and Vite boundaries                                     |
| [Public Contract And Interaction Model](public-contract-and-interaction-model.md)           | Provider-owned public Contract families, synchronous and asynchronous interaction selection, boundary data, Host Registry handoff, rejection ownership, and the narrow Core Runtime boundary                                      |
| [Persistent Data Architecture](persistent-data-architecture.md)                             | Initial isolated Tenant Instance database boundary, persistent-concept ownership, identity and attribution boundaries, configuration categories, cross-owner persistence, durable Module data, and lifecycle and protection rules |
| [Workspace Navigation And Frame Composition](workspace-navigation-and-frame-composition.md) | Available and active Workspaces, persistent Frame, Frame Surfaces, Core Navigation, Product hierarchy, deep links, breadcrumbs, and shell composition                                                                             |
| [Stack Overview](stack-overview.md)                                                         | Application stack, framework, runtime, database, frontend, and deployment technology boundaries                                                                                                                                   |
| [Tenant, Instance, User Account, And Workspace Model](workspace-identity-model.md)          | Canonical identity, Tenant Instance, User Account, and Workspace relationships                                                                                                                                                    |
| [Tenancy](tenancy.md)                                                                       | Tenant and Instance isolation, resolution, and cross-scope architecture                                                                                                                                                           |

## 3. Reading Order

For broad architecture work:

1. read [System Overview](system-overview.md);
2. read [Workspace Navigation And Frame Composition](workspace-navigation-and-frame-composition.md) when Workspace switching, Frame composition, navigation hierarchy, Core Navigation, breadcrumbs, or shell regions are involved;
3. read [Repository Architecture](repository-architecture.md) when ownership, placement, folders, packages, resources, tests, dependencies, or migration topology are involved;
4. read [Application Registration](application-registration.md) when routes, Providers, views, Livewire aliases, commands, configuration, migrations, assets, Contributions, or deterministic application composition are involved;
5. read [Public Contract And Interaction Model](public-contract-and-interaction-model.md) when one owner invokes, reads from, reacts to, contributes to, registers with, or depends on another owner, or when Core Runtime scope is involved;
6. read [Persistent Data Architecture](persistent-data-architecture.md) when persistent ownership, database scope, identity persistence, Settings, Preferences, Setup, Installation, cross-owner data access, Module schema durability, lifecycle, retention, or protection is involved;
7. read [Stack Overview](stack-overview.md) for framework and technology boundaries;
8. read the applicable tenancy or workspace architecture document;
9. follow links to ADRs or standards only where the architecture document delegates authority.

Do not read every architecture document for a local change.

## 4. Authority Boundaries

- ADRs in `docs/01-decisions/` own accepted cross-cutting decisions and rationale.
- Standards in `docs/02-standards/` own mandatory implementation and review rules.
- This branch owns durable structural architecture.
- Features in `docs/04-features/` own capability behavior.
- Flows in `docs/05-flows/` own cross-capability sequences.
- Database documentation in `docs/06-database/` owns schema and persistence contracts.
- Planning in `docs/07-planning/` owns target analysis, sequencing, and unresolved decisions.
- Runbooks in `docs/10-runbooks/` own human operational procedures.

## 5. Maintenance Rules

- Keep architecture focused on structure, boundaries, and ownership.
- Do not duplicate detailed standards or implementation procedures.
- Link to the canonical ADR, standard, feature, database, planning, or runbook owner.
- Distinguish accepted target architecture from current transitional implementation.
- Update [Repository Architecture](repository-architecture.md) only after the applicable structural decision is accepted.
- Update [Application Registration](application-registration.md) only after the applicable composition decision is accepted.
- Preserve historical rationale in its owning ADR or planning package.

## 6. Related

- [Documentation Start](../00-start-here.md)
- [Decisions Index](../01-decisions/index.md)
- [Standards Index](../02-standards/index.md)
- [Database Index](../06-database/index.md)
- [Planning Index](../07-planning/index.md)
- [Goal 3 Target Repository Architecture](../07-planning/Milestones/milestone-0/goal-3/target-repository-architecture.md)
- [Phase 4 Placement And Dependency Rules Index](../07-planning/Milestones/milestone-0/goal-3/phase-4/index.md)
- [Phase 5 Naming Conventions Index](../07-planning/Milestones/milestone-0/goal-3/phase-5/index.md)
- [Phase 6 Representative Architecture Validation](../07-planning/Milestones/milestone-0/goal-3/phase-6/index.md)
- [Repository Naming Standards](../02-standards/coding/repository-naming-standards.md)
