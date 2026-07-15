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
- may consume public read contracts from other owners when permitted;
- must not depend on Delivery Adapters or Surfaces;
- must not access another owner’s internals;
- may return Data Objects or other explicit result types;
- must preserve owner-controlled authorization, privacy, and visibility rules.

## 6. Target Status

Status: permanent

Query is a permanent shared Technical Role for Core capabilities and Modules.

This definition does not require every owner to contain a `Queries/` folder.

Final placement, namespaces, and naming conventions remain subject to later Goal 3 phases.

## 7. Accepted Decision

Status: accepted

Queries provide the shared read-oriented role beneath an explicit owner and cohesive capability or Module.

They remain distinct from Actions, Delivery Adapters, and Surface presentation.

## 8. Open Questions

The following details remain deferred:

- exact Query naming conventions;
- exact result-object conventions;
- exact pagination and filtering standards;
- exact caching rules;
- exact static enforcement of read-only behavior.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Action Definition](../Actions/Definition.md)
- [Data Object Definition](../Data-Objects/Definition.md)
- [Phase 2.2 Secondary Organization Within Each Owner](../../Milestones/milestone-0/goal-3/phase-2/2-2-secondary-organization-within-each-owner.md)
- Related GitHub issue: #49
