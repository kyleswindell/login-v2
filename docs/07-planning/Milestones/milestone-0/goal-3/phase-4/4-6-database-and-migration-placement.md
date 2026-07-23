<!--
DOC-META
title: Phase 4.6 Database And Migration Placement
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/4-6-database-and-migration-placement.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records owner-local runtime persistence placement, Core and Module schema-lifecycle locations, registration, and database-documentation boundaries.
-->

# Phase 4.6 Database And Migration Placement

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)


## 1. Purpose

Define where runtime persistence code and schema-lifecycle artifacts belong without deciding detailed schema design.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 4 review
- Implementation state: target direction only
- Owning GitHub issue: #51
- Detailed schema owner: Goal 6 and `docs/06-database/`

## 3. Runtime Data Implementation

Core runtime data code remains with the owning capability:

```text
app/Core/<Capability>/Models/
app/Core/<Capability>/Data/
app/Core/<Capability>/Queries/
```

Module runtime data code remains beneath package source:

```text
Modules/<Module>/src/Models/
Modules/<Module>/src/Data/
Modules/<Module>/src/Queries/
```

Other persistence roles follow the same owner-first rule. Root `app/Models/` and generic shared persistence layers are transitional or prohibited for new canonical work.

## 4. Schema-Lifecycle Artifacts

Core schema-lifecycle files are grouped by owner beneath the permanent root database branch:

```text
database/core/<Capability>/migrations/
database/core/<Capability>/factories/
database/core/<Capability>/seeders/
```

Module artifacts remain package-local:

```text
Modules/<Module>/database/migrations/
Modules/<Module>/database/factories/
Modules/<Module>/database/seeders/
```

Generic root migration, factory, and seeder locations are restricted to application bootstrap, genuinely cross-owner database infrastructure, root composition, and bounded compatibility.

## 5. Registration And Validation

Each registrable owner declares migration, factory, and seeder paths plus ordering dependencies.

The registration compiler validates:

- required paths;
- duplicate migration identifiers;
- unknown dependencies;
- dependency cycles;
- deterministic registration order.

Laravel remains responsible for migration and seeder execution.

## 6. Database Documentation

Human-readable schema, table, registry-data, and persistence contracts belong beneath `docs/06-database/`.

Phase 4 decides owner and placement only. It does not decide table design, keys, indexes, isolation strategy, or detailed migration content.

## 7. Accepted Decision

> Login 2.0 keeps runtime data implementation with the Core capability or Module that owns the state and behavior. Core Models, Data objects, Queries, and other persistence implementation live beneath `app/Core/<Capability>/<TechnicalRole>/`; Module runtime data implementation lives beneath `Modules/<Module>/src/<TechnicalRole>/`. Root `app/Models/` and generic shared persistence layers are transitional or prohibited for new canonical work.
>
> Core schema-lifecycle artifacts are grouped by owner beneath `database/core/<Capability>/migrations/`, `factories/`, and `seeders/`. Module schema-lifecycle artifacts remain package-local beneath `Modules/<Module>/database/`. Generic root database folders are restricted to application bootstrap, genuinely cross-owner database infrastructure, root composition, and bounded compatibility.
>
> Each registrable owner declares its migration, factory, and seeder paths and ordering dependencies through the application registration descriptor. The registration compiler validates required paths, duplicate identifiers, dependency order, and registration completeness, while Laravel remains responsible for migration and seeder execution. Human-readable schema and table contracts belong beneath `docs/06-database/`. Detailed schema design remains Goal 6 authority.

## 8. Boundaries And Handoff

Final folder names, namespaces, factory conventions, seeder conventions, and migration naming remain Phase 5 authority.

## 9. Related

- [Implementation Placement](4-2-implementation-placement.md)
- [Configuration Placement](4-5-configuration-placement.md)
- [Documentation Placement](4-9-documentation-placement.md)
- Related GitHub issue: #51
