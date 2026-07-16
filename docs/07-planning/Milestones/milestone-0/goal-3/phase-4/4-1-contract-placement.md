<!--
DOC-META
title: Phase 4.1 Contract Placement
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/4-1-contract-placement.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records where public, cross-owner, internal, UI artifact, Registry, Extension Point, and delivery contracts belong.
-->

# Phase 4.1 Contract Placement

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)


## 1. Purpose

Define where contracts belong and distinguish contract ownership from implementation ownership.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 4 review
- Implementation state: target direction only
- Owning GitHub issue: #51
- Depends on: accepted Phases 1–3
- Downstream consumer: Decisions 4.2–4.12 and Phase 5

## 3. Accepted Placement

| Contract type                             | Default placement                                      |
| ----------------------------------------- | ------------------------------------------------------ |
| Core public or cross-owner contract       | `app/Core/<Capability>/Contracts/`                     |
| Module public contract                    | `Modules/<Module>/src/Contracts/`                      |
| Reusable UI runtime contract              | `app/UI/<Responsibility>/Contracts/`                   |
| UI artifact machine-readable contract     | Colocated `contract.php` in the owning artifact bundle |
| Host Registry or Extension Point contract | Host owner’s `Contracts/` role                         |
| Delivery-protocol contract                | Owner-local delivery role                              |
| Internal implementation abstraction       | Adjacent to the implementation role it supports        |

A contract belongs to the owner that makes, maintains, versions, and deprecates the promise.

## 4. Contract And Implementation Separation

Public and cross-owner contracts are deliberate boundaries. Concrete implementations remain in the applicable owner-local Technical Role.

```text
Provider owner
├── Contracts/
└── <ImplementationRole>/
```

Consumers depend on the provider-controlled contract and must not copy, redefine, or import the provider’s internal implementation.

An internal interface is not promoted into `Contracts/` merely because it is an interface. It remains adjacent to its implementation until it becomes a deliberate public or cross-owner boundary.

## 5. Host And Contribution Contracts

A Host owns:

- its Registry contract;
- its Extension Point contracts;
- Contribution validation requirements;
- compatibility and lifecycle requirements.

The Registry implementation remains in the Host’s `Registry/` role. Contributor implementations remain with the Contributor beneath `Contrib/<Host>/`.

## 6. UI Artifact Contracts

Reusable Components, Elements, Patterns, and Layouts keep `contract.php` beside their presentation source.

These contracts describe UI artifact APIs and do not replace Core or Module application-service contracts.

## 7. Prohibited Placement

Do not create generic contract roots such as:

```text
app/Contracts/
app/Shared/Contracts/
app/Platform/Contracts/
app/Surfaces/Contracts/
app/Common/Contracts/
Modules/<Module>/Contracts/
```

Module PHP contracts belong beneath `src/`.

Do not place concrete implementations in `Contracts/`.

## 8. Accepted Decision

> Login 2.0 places public and cross-owner contracts with the Core capability, Module, or UI responsibility that owns the promise. Core contracts live beneath `app/Core/<Capability>/Contracts/`; Module contracts live beneath `Modules/<Module>/src/Contracts/`; reusable UI runtime contracts live beneath `app/UI/<Responsibility>/Contracts/`; and machine-readable UI artifact contracts remain colocated with their owning presentation artifact. Host Registry and Extension Point contracts belong to the Host owner, while Registry implementation and Contributor implementation remain separate. Internal abstractions remain adjacent to their implementation role unless deliberately promoted into a public boundary. Consumers depend on owner-controlled contracts and must not import or duplicate another owner’s internal implementation.

## 9. Boundaries And Handoff

This decision does not settle final class, namespace, contract-family, Registry-contract subfolder, or alias naming. Phase 5 owns final naming.

## 10. Related

- [Implementation Placement](4-2-implementation-placement.md)
- [Dependency Direction](4-10-dependency-direction.md)
- [Cross-Owner Communication](4-11-cross-owner-communication.md)
- Related GitHub issue: #51
