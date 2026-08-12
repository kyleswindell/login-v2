<!--
DOC-META
title: Software Design Documentation Standard
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/Software Design Documentation Standard.md
parent: docs/02-standards/documentation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines ownership, required content, readiness, organization, review, and synchronization requirements for pre-implementation Software Design Documents.
-->

# Software Design Documentation Standard

Parent: [Documentation Standards Index](index.md)

## 1. Purpose

Define how Software Design Documents convert accepted Login 2.0 requirements into implementation-ready technical blueprints.

SDDs live under `docs/08-design/` and use `doc_type: design`.

## 2. Ownership

An SDD owns the concrete implementation realization of accepted requirements.

It may define:

- components, classes, and responsibilities;
- exact intended paths and namespaces;
- public Contract realization;
- dependencies and interactions;
- persistence realization;
- delivery and presentation mapping;
- security enforcement;
- transactions, concurrency, retries, and idempotency;
- Events, Listeners, Jobs, Audit, Monitoring, and Notifications integration;
- registration and configuration;
- implementation manifests;
- verification surfaces.

It must not redefine canonical architecture, behavior, flows, schema, standards, or planning.

When an upstream requirement is missing or contradictory, resolve it in the owning canonical document before finalizing the SDD.

## 3. Required Content

Every full SDD must cover applicable:

1. **System Definition** — purpose, owner, scope, non-goals, concepts, state, and lifecycle.
2. **Governing Requirements** — canonical decisions, standards, architecture, behavior, flows, database Contracts, and accepted planning.
3. **Component Design** — implementation components, responsibilities, dependencies, and exact intended placement.
4. **Contracts And Interactions** — public Contracts, typed boundaries, provider/consumer relationships, sequences, and data movement.
5. **Data And Persistence** — Models, migrations, Queries, constraints, transactions, and persistence implementation.
6. **Delivery And Presentation** — routes, middleware, requests, Controllers, commands, UI, APIs, schedulers, and other Delivery Adapters.
7. **Security And Reliability** — authentication, authorization, validation, abuse cases, transactions, rollback, concurrency, retries, and idempotency.
8. **Events And Operational Effects** — Events, Listeners, Jobs, Audit, Monitoring, Notifications, and after-commit effects.
9. **Implementation Manifest** — exact expected repository artifacts and their responsibilities.
10. **Verification And Completion** — required proof surfaces, success/rejection behavior, review requirements, unresolved blockers, and completion state.

Sections may be marked not applicable with a concise reason.

Do not omit a required concern merely because its design is unresolved.

## 4. Implementation Manifest

The implementation manifest must identify each expected material artifact with applicable:

| Field              | Requirement                                                       |
| ------------------ | ----------------------------------------------------------------- |
| Path               | Exact intended repository path                                    |
| Artifact           | File or artifact family                                           |
| Archetype          | Action, Query, Contract, Model, migration, Controller, test, etc. |
| Responsibility     | One primary responsibility                                        |
| Change             | Create, modify, delete, or retain                                 |
| Dependencies       | Required internal or public dependencies                          |
| Requirement source | Canonical requirement authorizing it                              |
| Verification       | Expected proof surface                                            |
| Compatibility      | Preservation or migration requirement                             |

Do not create components solely for structural symmetry or anticipated future use.

## 5. Diagrams

Use diagrams when ordering, state, ownership, data movement, or component interaction would otherwise be ambiguous.

Applicable forms include:

- component/dependency diagrams;
- sequence diagrams;
- state diagrams;
- data-flow diagrams;
- implementation-oriented ERDs.

Prefer editable Mermaid source.

A diagram supplements written Contracts; it must not be the only source of a critical requirement.

## 6. Design Readiness

An SDD is implementation-ready only when:

- governing requirements are accepted and non-conflicting;
- ownership and dependency direction are explicit;
- required public Contracts are defined;
- persistence realization is defined;
- security and authorization enforcement are defined;
- transaction and concurrency behavior are defined where applicable;
- delivery and registration are defined;
- the implementation manifest is complete;
- verification surfaces are defined;
- no material design blocker remains.

A later implementation issue must be able to establish bounded `AC-*` and verification requirements without inventing system design.

## 7. Implementation Synchronization

Implementation must not silently diverge from an accepted SDD.

Material changes to ownership, public Contracts, schema realization, security, transaction design, asynchronous boundaries, or compatibility require design reconciliation.

After implementation, keep the SDD aligned with material accepted implementation structure without turning it into a status ledger or worklog.

## 8. Review

Before accepting an SDD, verify:

- one clear implementation owner exists for every material responsibility;
- all material design choices trace to accepted requirements;
- no competing canonical owner was created;
- exact implementation placement is defined;
- security and reliability boundaries are complete;
- diagrams agree with written design;
- the implementation manifest is complete;
- no unresolved material decision remains.

Use the [Software Design Template](../../09-reference/templates/docs/_design.md).