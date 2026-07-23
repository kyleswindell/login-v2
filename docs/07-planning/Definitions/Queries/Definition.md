<!--
DOC-META
title: Query Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Queries/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Query as an owner-controlled read-oriented operation that retrieves or resolves application data without changing authoritative state.
-->

# Query Definition

Parent: [Definitions Index](../Index.md)

- [1. Definition](#1-definition)
- [2. Classification Rule](#2-classification-rule)
- [3. Owns](#3-owns)
- [4. Must Not Own](#4-must-not-own)
- [5. Dependency Rules](#5-dependency-rules)
- [6. Target Status](#6-target-status)
- [7. Accepted Decision](#7-accepted-decision)
- [8. Open Questions](#8-open-questions)
- [9. Related](#9-related)

## 1. Definition

A Query is an owner-controlled read-oriented operation that retrieves, filters, calculates, or resolves application data without intentionally changing authoritative application state.

A Query belongs to the Core capability or Module that owns the data meaning and read policy.

When another owner requires an immediate read result, it communicates through a provider-owned public Query Contract. The consumer does not import the Query implementation or read the provider’s Models, repositories, or tables directly.

The working Technical Role label is:

```text
Queries/
```

## 2. Classification Rule

An operation is a Query when it:

- represents one explicit read intent;
- returns owner-controlled data or a defined result;
- applies read authorization or visibility policy;
- may compose owner-local read sources;
- does not intentionally perform a state-changing use case.

Incidental framework behavior such as logging or cache reads does not by itself make a Query state changing.

## 3. Owns

A Query may own:

- one read operation;
- filtering, sorting, projection, and aggregation;
- read-specific authorization or visibility enforcement;
- owner-local read composition;
- explicit input and result contracts;
- read-performance behavior;
- Query-specific tests and documentation.

## 4. Must Not Own

A Query must not own:

- application state-changing operations;
- HTTP or console transport concerns;
- UI layout or Surface composition;
- another owner’s internal implementation;
- generic repository-wide data access;
- persistence mutation hidden inside a read operation;
- unrelated read use cases.

## 5. Dependency Rules

A Query:

- may depend on owner-controlled Models, Contracts, and read infrastructure;
- may consume public Query Contracts from other owners when permitted;
- may be called across an ownership boundary only through a provider-owned public Contract;
- must not require consumers to import its concrete implementation;
- must not depend on Delivery Adapters or Surfaces;
- must not expose another owner’s Models, repositories, tables, or internal query implementation;
- may return provider-owned Data Objects or other explicit result types;
- must preserve owner-controlled authorization, privacy, and visibility rules.

## 6. Target Status

Status: permanent

Query is a permanent shared Technical Role for Core capabilities and Modules.

This definition does not require every owner to contain a `Queries/` folder.

Default target placement is:

```text
app/Core/<Capability>/Queries/
Modules/<Module>/src/Queries/
```

Concrete Query classes use `<ReadVerb><Subject>Query`. Query criteria use `<Subject>Criteria`; explicit results use `<Subject>Result` or a more precise semantic name.

## 7. Accepted Decision

Status: accepted

Queries provide the shared read-oriented role beneath an explicit owner and cohesive capability or Module.

They remain distinct from Actions, Delivery Adapters, and Surface presentation. Cross-owner immediate reads use provider-owned public Query Contracts and explicit result types rather than direct persistence access.

## 8. Open Questions

The following details remain deferred:

- exact pagination and filtering implementation standards;
- exact result compatibility and serialization rules;
- exact pagination and filtering standards;
- exact caching rules;
- exact static enforcement of read-only behavior.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Action Definition](../Actions/Definition.md)
- [Contract Definition](../Contracts/Definition.md)
- [Data Object Definition](../Data-Objects/Definition.md)
- [Phase 2.2 Secondary Organization Within Each Owner](../../Milestones/milestone-0/goal-3/phase-2/2-2-secondary-organization-within-each-owner.md)
- [Phase 4.10 Dependency Direction](../../Milestones/milestone-0/goal-3/phase-4/4-10-dependency-direction.md)
- [Phase 4.11 Cross-Owner Communication](../../Milestones/milestone-0/goal-3/phase-4/4-11-cross-owner-communication.md)
- Related GitHub issues: #49, #51
