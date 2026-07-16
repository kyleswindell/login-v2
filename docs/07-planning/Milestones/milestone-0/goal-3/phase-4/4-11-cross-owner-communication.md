<!--
DOC-META
title: Phase 4.11 Cross-Owner Communication
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/4-11-cross-owner-communication.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records approved synchronous, asynchronous, query, job, adapter, and Host Registry communication between owners.
-->

# Phase 4.11 Cross-Owner Communication

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)


## 1. Purpose

Define how owners communicate without importing internal implementation or using undocumented shared state.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 4 review
- Implementation state: target direction only
- Owning GitHub issue: #51
- Depends on: Decisions 4.1 and 4.10

## 3. Communication Matrix

| Need | Preferred method |
| --- | --- |
| Immediate command with required result | Provider-owned public Contract invoking owner behavior |
| Immediate read | Provider-owned public Query Contract |
| Stable data exchange | Provider-owned Contract or Data object |
| Announce a completed fact | Event |
| Deferred or retryable execution | Job through an accepted public boundary |
| Extend a Host-owned feature | Host Contract plus Contributor-owned `Contrib/<Host>/` |
| Translate external system or protocol | Owner-controlled Delivery Adapter or owner-specific integration implementation |
| Compose boot-time registration | Owner descriptor and root registrar |

## 4. Communication Rules

The provider owns the public contract, result shape, lifecycle, compatibility, and implementation binding.

Use synchronous contracts when the caller requires an immediate result or confirmed failure.

Use events for completed facts whose consumers react independently. Events must not hide a required synchronous dependency.

Use jobs for deliberately deferred, retryable, or operationally isolated work. Jobs must not obscure ownership.

Use Host Registries and Extension Point contracts for extensible features. Contributors retain owner-local implementations and must not mutate Host internals.

Queries do not grant direct access to another owner’s Models, repositories, or tables.

## 5. Prohibited Communication

Do not use the following as undocumented cross-owner channels:

- direct concrete-class imports;
- cross-owner Model or table access;
- generic shared services;
- static helpers;
- global mutable state;
- facades or service-location by concrete class;
- arbitrary boot-time side effects;
- consumer-owned copies of provider behavior.

Module-to-Module calls require a declared dependency unless an accepted event or Host Extension Point is intentionally designed to avoid direct package coupling.

## 6. Accepted Decision

> Login 2.0 owners communicate through explicit provider-controlled public boundaries rather than by importing another owner’s internal implementation, reading its persistence directly, or relying on undocumented global state. Immediate commands and reads use public Contracts that expose owner-controlled Actions, Queries, or another explicitly defined owner-controlled operation. The provider owns the Contract, result shape, compatibility requirements, and implementation binding; the consumer depends only on that public boundary.
>
> Events communicate completed facts to independent consumers and must not replace synchronous communication when the caller requires an immediate result or confirmed failure. Jobs represent deliberately deferred, retryable, or operationally isolated execution and remain owned by the capability or Module performing the work. Delivery Adapters and owner-specific integration implementations translate external systems and protocols while delegating to owner behavior.
>
> Extensible features use Host-owned Registries and Extension Point Contracts. Contributors retain their implementation beneath owner-local `Contrib/<Host>/` structure and submit Contributions through the accepted registration system. Direct cross-owner concrete imports, cross-owner Model or table access, generic shared services, static helpers, service-location by concrete class, and hidden boot-time registration are prohibited.

## 7. Boundaries And Handoff

Phase 5 owns final contract, event, job, Registry, Contribution, and descriptor naming. Later implementation work owns runtime tooling and verification.

## 8. Related

- [Dependency Direction](4-10-dependency-direction.md)
- [Contract Placement](4-1-contract-placement.md)
- [Exceptions And Future Enforcement](4-12-exceptions-and-future-enforcement.md)
- [Dependency And Communication Matrix](dependency-and-communication-matrix.md)
- [Application Registration System Definition](../../../../Definitions/Application-Registration/Definition.md)
- Related GitHub issue: #51
