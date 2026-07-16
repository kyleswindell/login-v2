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
summary: Routes canonical Login 2.0 system, repository, application-registration, stack, tenancy, and workspace architecture.
-->

# Architecture Index

Parent: [Documentation Index](../index.md)

## 1. Purpose

This branch is the canonical owner for system structure, architectural boundaries, repository topology, tenancy shape, runtime scope, stack structure, and other high-level design.

Behavior, workflow steps, schema details, implementation standards, planning, operations procedures, and active delivery state belong to their applicable documentation owners.

## 2. Architecture Documents

| Document                                                                           | Owns                                                                                                                                                                                                          |
| ---------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [System Overview](system-overview.md)                                              | High-level system, Tenant Instance, Workspace, Principal, execution, and application ownership model                                                                                                          |
| [Repository Architecture](repository-architecture.md)                              | Target repository topology, accepted naming relationships, owner-local artifact placement, dependency direction, presentation and test topology, supporting branches, exceptions, and transitional structures |
| [Application Registration](application-registration.md)                            | Registration responsibilities, conditional custom-artifact naming, deterministic compilation, generated manifests, root composition, Typed Registrars, and native Laravel and Vite boundaries                 |
| [Stack Overview](stack-overview.md)                                                | Application stack, framework, runtime, database, frontend, and deployment technology boundaries                                                                                                               |
| [Tenant, Instance, User Account, And Workspace Model](workspace-identity-model.md) | Canonical identity, Tenant Instance, User Account, and Workspace relationships                                                                                                                                |
| [Tenancy](tenancy.md)                                                              | Tenant and Instance isolation, resolution, and cross-scope architecture                                                                                                                                       |

## 3. Reading Order

For broad architecture work:

1. read [System Overview](system-overview.md);
2. read [Repository Architecture](repository-architecture.md) when ownership, placement, folders, packages, resources, tests, dependencies, or migration topology are involved;
3. read [Application Registration](application-registration.md) when routes, Providers, views, Livewire aliases, commands, configuration, migrations, assets, Contributions, or deterministic application composition are involved;
4. read [Stack Overview](stack-overview.md) for framework and technology boundaries;
5. read the applicable tenancy or workspace architecture document;
6. follow links to ADRs or standards only where the architecture document delegates authority.

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
- [Repository Naming Standards](../02-standards/coding/repository-naming-standards.md)
