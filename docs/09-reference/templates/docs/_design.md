<!--
DOC-META
title: Software Design Document Template
doc_type: reference
status: active
owner: docs
canonical: false
canonical_path: docs/09-reference/templates/docs/_design.md
parent: docs/09-reference/templates/docs/_index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Provides the reusable structure for implementation-ready Software Design Documents.
-->

# Software Design Document Template

Use this template for documents under `docs/08-design/`.

```md
<!--
DOC-META
title: <System> Software Design
doc_type: design
status: draft
owner: <owner>
canonical: false
canonical_path: docs/08-design/<owner>/<system>/software-design.md
parent: docs/08-design/index.md
template: docs/09-reference/templates/docs/_design.md
summary: Defines the implementation-ready technical design for <system>.
-->

# <System> Software Design

Parent: [Software Design Index](../../index.md)

## 1. System Definition

### Purpose

### Scope

### Non-Goals

### Concepts, State, And Lifecycle

## 2. Governing Requirements

| Source     | Requirement Used |
| ---------- | ---------------- |
| `docs/...` | ...              |

## 3. Component Design

| Component | Archetype | Responsibility | Dependencies | Target Path |
| --------- | --------- | -------------- | ------------ | ----------- |
| ...       | ...       | ...            | ...          | `...`       |

## 4. Contracts And Interactions

### Public Contracts

### Interaction / Sequence Design

Add Mermaid diagrams where useful.

## 5. Data And Persistence

### Canonical Database Contracts

### Models, Queries, And Migrations

### Transactions And Constraints

## 6. Delivery And Presentation

### Routes And Delivery Adapters

### UI / Presentation

### Registration And Configuration

## 7. Security And Reliability

### Authentication And Authorization

### Validation And Abuse Cases

### Transactions, Concurrency, Retry, And Idempotency

## 8. Events And Operational Effects

### Events, Listeners, And Jobs

### Audit

### Monitoring

### Notifications

## 9. Implementation Manifest

| Change | Path  | Archetype | Responsibility | Requirement Source | Verification |
| ------ | ----- | --------- | -------------- | ------------------ | ------------ |
| CREATE | `...` | ...       | ...            | `docs/...`         | ...          |

## 10. Verification And Completion

### Required Proof

- ...

### Manual Or Specialist Review

- ...

### Remaining Blockers

- None.

### Implementation Ready

- [ ] Governing requirements are complete and non-conflicting.
- [ ] Component and Contract design is complete.
- [ ] Persistence and reliability design is complete where applicable.
- [ ] Security boundaries are complete.
- [ ] Implementation manifest is complete.
- [ ] Verification surfaces are defined.
- [ ] No material design decision remains unresolved.