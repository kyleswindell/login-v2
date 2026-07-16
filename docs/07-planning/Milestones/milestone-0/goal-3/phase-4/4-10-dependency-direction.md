<!--
DOC-META
title: Phase 4.10 Dependency Direction
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/4-10-dependency-direction.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records permitted and prohibited dependency directions among Core, Modules, UI, Surfaces, Delivery Adapters, and Laravel integration.
-->

# Phase 4.10 Dependency Direction

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)


## 1. Purpose

Define the allowed and prohibited dependency model among accepted architecture owners and integration boundaries.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 4 review
- Implementation state: target direction only
- Owning GitHub issue: #51
- Depends on: Decisions 4.1–4.9

## 3. Dependency Matrix

| Consumer                 | Allowed dependency                                                                        | Prohibited dependency                                               |
| ------------------------ | ----------------------------------------------------------------------------------------- | ------------------------------------------------------------------- |
| Core capability          | Own internals; another Core capability’s public Contracts; accepted external dependencies | Another Core capability’s internals; optional Module implementation |
| Module                   | Core public Contracts; approved UI APIs; declared external dependencies                   | Core internals; undeclared packages                                 |
| Module                   | Another Module’s public Contracts through a declared package dependency                   | Another Module’s internal implementation                            |
| UI infrastructure        | UI-owned APIs and framework presentation APIs                                             | Core or Module domain implementation                                |
| Core or Module Surface   | Its owner’s behavior and approved UI APIs                                                 | Another owner’s internal Surface or implementation                  |
| Delivery Adapter         | Its owner’s accepted application boundary                                                 | Another owner’s internals; behavior implemented in the adapter      |
| Root Laravel integration | Framework APIs and accepted public registration boundaries                                | Owner-specific behavior or internal implementation                  |

## 4. Direction Rules

Primary inward direction:

```text
Delivery Adapter or Surface
→ owner public or internal application boundary
→ owner implementation
```

Cross-owner direction:

```text
Consumer
→ provider-owned public Contract
→ provider implementation
```

Core must remain operable without optional Modules. Modules may depend on Core; Core must not depend on optional Modules.

Module-to-Module dependencies require an explicit public contract and declared package dependency. Dependency cycles are prohibited.

Reusable UI does not depend on Core or Module domain implementation. Owner-specific Surfaces may depend on their own owner and reusable UI.

Events, jobs, Registries, Contributions, and service-container bindings remain subject to the same dependency rules.

## 5. Accepted Decision

> Login 2.0 dependencies flow toward stable, owner-controlled public boundaries and must not cross directly into another owner’s internal implementation. A Core capability may depend on its own implementation and on another Core capability’s public Contracts, but not on that capability’s private Technical Roles. Modules may depend on Core public Contracts, approved UI APIs, external package dependencies, and another Module’s public Contracts only when the Module dependency is explicitly declared. Core must not depend on optional Modules, and undeclared or cyclic Module dependencies are prohibited.
>
> Reusable UI infrastructure may depend on UI-owned APIs and framework presentation APIs, but must not depend on Core or Module domain implementation. Owner-specific Surfaces may depend on their own owner’s behavior and on reusable UI APIs. Delivery Adapters depend inward on their owner’s Contracts, Actions, Queries, Policies, Data objects, and workflows; application behavior must not depend outward on delivery implementation.
>
> Root Laravel integration may compose and register owners through accepted public registration boundaries, but it must not absorb owner-specific behavior. Events, jobs, Registries, Contributions, and service-container bindings must not conceal direct internal coupling. Cross-owner concrete implementation dependencies, dependency cycles, and dependencies that make Core require an optional Module are prohibited unless an exact bounded exception is accepted under Decision 4.12.

## 6. Boundaries And Handoff

Decision 4.11 defines allowed communication methods. Decision 4.12 defines exceptions and future enforcement. Phase 5 owns final namespace and dependency-declaration naming.

## 7. Related

- [Contract Placement](4-1-contract-placement.md)
- [Cross-Owner Communication](4-11-cross-owner-communication.md)
- [Exceptions And Future Enforcement](4-12-exceptions-and-future-enforcement.md)
- Related GitHub issue: #51
