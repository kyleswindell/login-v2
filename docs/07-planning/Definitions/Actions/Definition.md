<!--
DOC-META
title: Action Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Actions/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines an Action as an owner-controlled application operation or use case that changes state or coordinates behavior.
-->

# Action Definition

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

An Action is an owner-controlled application operation or use case that changes state, performs a meaningful command, or coordinates behavior required to complete one explicit outcome.

An Action belongs to the Core capability or Module whose policy and behavior it executes.

When another owner requires an immediate state-changing result or confirmed failure, it communicates through a provider-owned public Contract. The consumer does not import the Action implementation directly.

The working Technical Role label is:

```text
Actions/
```

## 2. Classification Rule

An operation is an Action when it:

- represents one explicit application intent;
- performs or coordinates state-changing behavior;
- enforces or invokes owner-controlled policy;
- may coordinate multiple owner-local collaborators;
- exposes a stable invocation boundary to Delivery Adapters or other permitted callers.

A class is not an Action merely because it has a public method or performs work.

## 3. Owns

An Action may own:

- orchestration of one application operation;
- transaction or consistency boundaries when applicable;
- invocation of owner-controlled policies and persistence;
- owner-local coordination;
- explicit input and result contracts;
- operation-specific failure behavior;
- Action-specific tests and documentation.

## 4. Must Not Own

An Action must not own:

- HTTP, console, webhook, or other transport parsing;
- reusable UI presentation;
- generic unrelated helper methods;
- another owner’s internal implementation;
- read-only retrieval that is more accurately a Query;
- framework bootstrap or registration;
- multiple unrelated use cases.

## 5. Dependency Rules

An Action:

- may depend on owner-controlled Contracts, Models, Policies, and persistence;
- may invoke public Contracts of other owners when dependency rules permit;
- may be called across an ownership boundary only through a provider-owned public Contract;
- must not require consumers to import its concrete implementation;
- must not depend on Delivery Adapters or Surfaces;
- must not access another owner’s internals;
- may emit owner-defined Events for completed facts;
- may dispatch owner-defined Jobs or Notifications when execution is deliberately deferred;
- must not replace a required immediate result with an Event or Job;
- must preserve the authorization and lifecycle rules of its owner.

## 6. Target Status

Status: permanent

Action is a permanent shared Technical Role for Core capabilities and Modules.

The existence of this definition does not require every owner to contain an `Actions/` folder.

Default target placement is:

```text
app/Core/<Capability>/Actions/
Modules/<Module>/src/Actions/
```

Concrete Action classes use `<Verb><Subject>Action`; the folder and namespace role remains `Actions`.

## 7. Accepted Decision

Status: accepted

Core capabilities and Modules use the same sparse Action role.

Actions remain beneath the owner whose behavior they execute. Delivery Adapters and owner-specific Surfaces may invoke Actions, but they do not absorb Action behavior. Cross-owner synchronous invocation uses a provider-owned public Contract rather than a concrete Action import.

## 8. Open Questions

The following details remain deferred:

- exact transaction-boundary standards;
- exact command-data conventions;
- exact internal invocation and binding conventions;
- exact static enforcement of Action placement.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Query Definition](../Queries/Definition.md)
- [Contract Definition](../Contracts/Definition.md)
- [Delivery Adapter Definition](../Delivery-Adapters/Definition.md)
- [Phase 2.2 Secondary Organization Within Each Owner](../../Milestones/milestone-0/goal-3/phase-2/2-2-secondary-organization-within-each-owner.md)
- [Phase 4.10 Dependency Direction](../../Milestones/milestone-0/goal-3/phase-4/4-10-dependency-direction.md)
- [Phase 4.11 Cross-Owner Communication](../../Milestones/milestone-0/goal-3/phase-4/4-11-cross-owner-communication.md)
- Related GitHub issues: #49, #51
