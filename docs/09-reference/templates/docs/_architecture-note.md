<!--
DOC-META
title: Architecture Note Title
doc_type: architecture
status: draft
owner: architecture
canonical: true
canonical_path: docs/03-architecture/path-to-document.md
parent: docs/03-architecture/index.md
template: docs/09-reference/templates/docs/_architecture-note.md
summary: One sentence describing the architecture boundary, structure, or ownership model this document owns.
-->

# Architecture Note Title

Parent: [Architecture Index](../index.md)

- [1. Purpose](#1-purpose)
- [2. Status](#2-status)
- [3. Scope](#3-scope)
  - [3.1. In Scope](#31-in-scope)
  - [3.2. Out of Scope](#32-out-of-scope)
- [4. Current Architecture](#4-current-architecture)
- [5. Target Architecture](#5-target-architecture)
- [6. Ownership And Boundaries](#6-ownership-and-boundaries)
- [7. Key Components](#7-key-components)
- [8. Integration Points](#8-integration-points)
- [9. Data And Persistence](#9-data-and-persistence)
- [10. Permissions / Security](#10-permissions--security)
- [11. Operational Considerations](#11-operational-considerations)
- [12. Decisions](#12-decisions)
- [13. Open Questions](#13-open-questions)
- [14. Related](#14-related)

## 1. Purpose

State the structural ownership, boundary, or architecture intent in one to two sentences.

## 2. Status

Status: draft | active | planned | implemented | superseded | archived

## 3. Scope

### 3.1. In Scope

List the architecture boundaries, systems, folders, or ownership decisions this document owns.

### 3.2. Out of Scope

List related responsibilities this document does not own.

## 4. Current Architecture

Describe what exists today.

## 5. Target Architecture

Describe the intended architecture when different from the current state.

## 6. Ownership And Boundaries

Identify ownership boundaries.

| Area    | Owner                               | Responsibility       | Notes           |
| ------- | ----------------------------------- | -------------------- | --------------- |
| Example | Core / Platform / Module / UI / Ops | What this area owns. | Boundary notes. |

## 7. Key Components

List important code, services, folders, configuration, or integration points.

| Component | Path           | Purpose           |
| --------- | -------------- | ----------------- |
| Example   | `app/Core/...` | Why this matters. |

## 8. Integration Points

Describe important integrations, dependencies, events, registries, routes, jobs, or external systems.

## 9. Data And Persistence

List relevant tables, config keys, storage paths, queues, payloads, or data contracts.

## 10. Permissions / Security

Describe access control, sensitive data, audit, monitoring, tenant/workspace isolation, or security boundaries.

## 11. Operational Considerations

Describe setup, deployment, scheduler, queue, cache, backup, recovery, or monitoring concerns when applicable.

## 12. Decisions

Record local architecture decisions. Elevate durable cross-cutting decisions to `docs/01-decisions/`.

## 13. Open Questions

Track unresolved decisions or architecture risks.

## 14. Related

- [Architecture Index](../index.md)