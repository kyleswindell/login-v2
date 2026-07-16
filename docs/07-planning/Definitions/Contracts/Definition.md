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

The provider whose promise, policy, or compatibility requirements the Contract expresses owns that Contract. Consumers do not redefine the provider’s Contract.

An interface used only inside one implementation role remains adjacent to that implementation unless it is deliberately promoted into a stable public or cross-owner boundary.

The working Technical Role label is:

```text
Contracts/
```

## 2. Classification Rule

An artifact is a Contract when it:

- defines behavior, data, or compatibility expected by callers or implementers;
- has one explicit provider owner;
- establishes a boundary more stable than one implementation;
- identifies permitted inputs, outputs, failures, rejection, or lifecycle expectations;
- is intentionally consumed or implemented through that boundary;
- identifies whether the boundary is internal, owner-public, or cross-owner.

A PHP interface is not automatically a public cross-owner Contract. Broad use alone does not promote an internal abstraction into `Contracts/`.

## 3. Owns

A Contract may own:

- method or operation signatures;
- input and output expectations;
- data shape and compatibility rules;
- failure and rejection semantics;
- lifecycle, compatibility, deprecation, and rejection expectations;
- public versus internal boundary classification;
- accepted implementation-binding requirements without owning implementation behavior;
- contract-specific tests and documentation.

## 4. Must Not Own

A Contract must not own:

- concrete implementation behavior;
- framework registration;
- arbitrary interfaces without a stable responsibility;
- consumer-owned copies of another provider’s promise;
- another owner’s requirements;
- hidden access to owner internals;
- generic cross-application dependency lookup;
- transport details unless the Contract specifically governs that transport.

## 5. Dependency Rules

A Contract:

- remains owned by the provider whose promise and requirements it expresses;
- may be consumed across owners only when dependency direction permits;
- is the required dependency target for cross-owner synchronous calls;
- must not force Core to depend on optional Module implementations;
- must not expose owner internals or require a concrete implementation import;
- may be implemented by owner-controlled or permitted external implementations;
- must preserve declared compatibility, deprecation, failure, and rejection behavior;
- may be bound through Laravel integration without transferring ownership;
- keeps Host Registry and Extension Point Contracts with the Host owner.

## 6. Target Status

Status: permanent

Contract is a permanent shared Technical Role.

The existence of this definition does not require every owner to contain a `Contracts/` folder.

Default target placement is:

```text
app/Core/<Capability>/Contracts/
Modules/<Module>/src/Contracts/
app/UI/<Responsibility>/Contracts/
```

Machine-readable UI artifact contracts such as `contract.php` remain colocated with the owning presentation artifact. Internal abstractions remain adjacent to their implementation role unless deliberately promoted.

Final contract-family, class, interface, schema, namespace, and public/internal subdivision naming remain Phase 5 or owner-specific contract authority.

## 7. Accepted Decision

Status: accepted

Cross-owner interaction occurs through explicit provider-owned public boundaries rather than direct access to another owner’s implementation.

Contracts remain with the provider whose promise, policy, and compatibility requirements they express. Consumers depend on the Contract, not a copied declaration or concrete implementation. Host Registry and Extension Point Contracts remain Host-owned.

## 8. Open Questions

The following details remain deferred:

- exact public versus internal namespace and folder subdivisions;
- exact compatibility, deprecation, and versioning standards;
- exact interface, schema, and data-contract family naming;
- exact discovery and export requirements;
- exact contract-test standards.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Data Object Definition](../Data-Objects/Definition.md)
- [Registry Definition](../Registries/Definition.md)
- [Phase 2.3 Cross-Cutting Technical Code](../../Milestones/milestone-0/goal-3/phase-2/2-3-cross-cutting-technical-code.md)
- [Phase 4.1 Contract Placement](../../Milestones/milestone-0/goal-3/phase-4/4-1-contract-placement.md)
- [Phase 4.10 Dependency Direction](../../Milestones/milestone-0/goal-3/phase-4/4-10-dependency-direction.md)
- [Phase 4.11 Cross-Owner Communication](../../Milestones/milestone-0/goal-3/phase-4/4-11-cross-owner-communication.md)
- Related GitHub issues: #49, #51
