<!--
DOC-META
title: Model Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Models/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Model as an owner-controlled representation of domain or persistent state and the invariants directly associated with that state.
-->

# Model Definition

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

A Model is an owner-controlled representation of domain or persistent state and the invariants directly associated with that state.

Within Laravel, a Model may include an Eloquent persistence model or another explicitly accepted domain-state representation.

The working Technical Role label is:

```text
Models/
```

## 2. Classification Rule

An artifact is a Model when it:

- represents owner-controlled state or identity;
- maps to persistent state or a domain-state concept;
- owns relationships or invariants intrinsic to that state;
- is not merely a transfer shape;
- is not primarily an application operation;
- remains within one explicit owner boundary.

## 3. Owns

A Model may own:

- state representation;
- persistence mapping when applicable;
- owner-controlled relationships;
- state-local invariants;
- casts or transformations intrinsic to the state;
- state-specific lifecycle behavior permitted by later standards;
- Model-specific tests and documentation.

## 4. Must Not Own

A Model must not own:

- HTTP or console transport behavior;
- broad application workflows;
- unrelated cross-owner coordination;
- reusable UI presentation;
- generic service-container access;
- another owner’s persistence;
- authorization policy that belongs in Policies;
- arbitrary helper behavior unrelated to represented state.

## 5. Dependency Rules

A Model:

- remains owned by the capability or Module that controls the state;
- may depend on owner-local value types and persistence support;
- must not depend on Delivery Adapters or Surfaces;
- must not expose another owner’s internals;
- must not create implicit optional Module dependencies;
- may be accessed by owner-controlled Actions, Queries, Policies, Jobs, and other permitted roles;
- must preserve database and privacy constraints owned by applicable canonical documentation.

## 6. Target Status

Status: permanent

Model is a permanent shared Technical Role.

This definition does not require every owner to contain a `Models/` folder.

The exact distinction between domain models, Eloquent models, aggregates, entities, and value objects remains subject to later coding and placement standards.

## 7. Accepted Decision

Status: accepted

Models remain beneath the owner and cohesive capability or Module whose state they represent.

Repository-wide `Models/` organization is not the target primary structure.

## 8. Open Questions

The following details remain deferred:

- exact domain-model versus Eloquent-model conventions;
- exact persistence relationship boundaries;
- exact model-event usage;
- exact aggregate and value-object vocabulary;
- exact namespace and naming standards.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Data Object Definition](../Data-Objects/Definition.md)
- [Policy Definition](../Policies/Definition.md)
- [Phase 2.2 Secondary Organization Within Each Owner](../../Milestones/milestone-0/goal-3/phase-2/2-2-secondary-organization-within-each-owner.md)
- Related GitHub issue: #49
