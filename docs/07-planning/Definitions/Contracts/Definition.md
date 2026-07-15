<!--
DOC-META
title: Contract Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Contracts/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Contract as an owner-controlled stable interface or data agreement governing permitted interaction within or across ownership boundaries.
-->

# Contract Definition

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

A Contract is an owner-controlled stable interface, protocol, or data agreement that defines permitted interaction within an owner or across an explicit ownership boundary.

The owner whose requirements the Contract expresses owns that Contract.

The working Technical Role label is:

```text
Contracts/
```

## 2. Classification Rule

An artifact is a Contract when it:

- defines behavior, data, or compatibility expected by callers or implementers;
- has one explicit owner;
- establishes a boundary more stable than one implementation;
- identifies permitted inputs, outputs, failures, or lifecycle expectations;
- is intentionally consumed or implemented through that boundary.

A PHP interface is not automatically a public cross-owner Contract.

## 3. Owns

A Contract may own:

- method or operation signatures;
- input and output expectations;
- data shape and compatibility rules;
- failure and rejection semantics;
- lifecycle expectations;
- public versus internal boundary classification;
- contract-specific tests and documentation.

## 4. Must Not Own

A Contract must not own:

- implementation behavior;
- framework registration;
- arbitrary interfaces without a stable responsibility;
- another owner’s requirements;
- hidden access to owner internals;
- generic cross-application dependency lookup;
- transport details unless the Contract specifically governs that transport.

## 5. Dependency Rules

A Contract:

- remains owned by the responsibility whose requirements it expresses;
- may be consumed across owners only when dependency direction permits;
- must not force Core to depend on optional Module implementations;
- must not expose owner internals;
- may be implemented by owner-controlled or permitted external implementations;
- must preserve declared compatibility and rejection behavior;
- may be bound through Laravel integration without transferring ownership.

## 6. Target Status

Status: permanent

Contract is a permanent shared Technical Role.

The existence of this definition does not require every owner to contain a `Contracts/` folder.

Final public/internal subdivisions, physical placement, and namespace conventions remain subject to later Goal 3 and Goal 4 decisions.

## 7. Accepted Decision

Status: accepted

Cross-owner interaction occurs through explicit public boundaries rather than direct access to another owner’s implementation.

Contracts remain with the owner whose policy and requirements they express.

## 8. Open Questions

The following details remain deferred:

- exact public versus internal folder structure;
- exact compatibility and versioning rules;
- exact interface, schema, and data-contract subdivisions;
- exact discovery and export requirements;
- exact contract-test standards.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Data Object Definition](../Data-Objects/Definition.md)
- [Registry Definition](../Registries/Definition.md)
- [Phase 2.3 Cross-Cutting Technical Code](../../Milestones/milestone-0/goal-3/phase-2/2-3-cross-cutting-technical-code.md)
- Related GitHub issue: #49
