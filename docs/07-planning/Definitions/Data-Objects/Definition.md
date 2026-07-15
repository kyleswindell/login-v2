<!--
DOC-META
title: Data Object Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Data-Objects/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Data Object as an explicit owner-controlled structured value used to transfer command, query, result, or boundary data.
-->

# Data Object Definition

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

A Data Object is an explicit owner-controlled structured value used to transfer command input, Query criteria, resolved results, or other boundary data.

A Data Object communicates data meaning without becoming the owner of the behavior that uses it.

The working Technical Role label is:

```text
Data/
```

## 2. Classification Rule

An object is a Data Object when it:

- represents one explicit data shape;
- has defined fields and meaning;
- crosses a method, operation, layer, or ownership boundary;
- is not primarily a persistence entity;
- is not primarily a behavior coordinator;
- exists to make structured data explicit and reviewable.

An arbitrary associative array is not automatically a Data Object.

## 3. Owns

A Data Object may own:

- named fields;
- field-level type and presence expectations;
- boundary-specific data meaning;
- construction or validation limited to its own shape;
- safe serialization when required;
- compatibility expectations;
- Data Object-specific tests and documentation.

## 4. Must Not Own

A Data Object must not own:

- application workflows;
- persistence lifecycle;
- HTTP or console transport policy;
- authorization decisions;
- service-container access;
- broad unrelated behavior;
- another owner’s data semantics;
- hidden database access.

## 5. Dependency Rules

A Data Object:

- remains owned by the capability, Module, or boundary whose data meaning it expresses;
- may be used by Actions, Queries, Contracts, Delivery Adapters, or Surfaces when permitted;
- must not depend on Delivery Adapters;
- should avoid dependency on persistence implementation unless it is explicitly a persistence-facing object;
- must not expose another owner’s internals;
- must preserve sensitive-data and serialization constraints defined by its owner.

## 6. Target Status

Status: permanent

Data Object is a permanent shared Technical Role.

The existence of this definition does not require every owner to contain a `Data/` folder.

Exact mutability, construction, validation, serialization, and naming conventions remain subject to later standards.

## 7. Accepted Decision

Status: accepted

Core capabilities and Modules may use owner-local Data Objects for explicit command data, Query criteria, resolved results, and other stable transfer shapes.

Data Objects remain distinct from Models, Actions, Queries, and Delivery Adapters.

## 8. Open Questions

The following details remain deferred:

- exact DTO naming conventions;
- exact immutability requirements;
- exact validation boundaries;
- exact serialization rules;
- exact command-data and result-data subdivisions.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Contract Definition](../Contracts/Definition.md)
- [Model Definition](../Models/Definition.md)
- [Query Definition](../Queries/Definition.md)
- Related GitHub issue: #49
