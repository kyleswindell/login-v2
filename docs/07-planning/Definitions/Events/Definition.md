<!--
DOC-META
title: Event Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Events/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines an Event as an owner-defined fact that records or communicates that a meaningful application occurrence has happened.
-->

# Event Definition

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

An Event is an owner-defined fact that records or communicates that a meaningful application occurrence has completed or happened.

An Event belongs to the Core capability or Module that owns the occurrence and its meaning. It announces a fact to independent consumers; it is not a command requesting a required immediate result.

The working Technical Role label is:

```text
Events/
```

## 2. Classification Rule

An artifact is an Event when it:

- represents a completed or accepted occurrence;
- has one explicit owner;
- exposes a stable event contract;
- may be observed by one or more independent Listeners;
- does not require a Listener to complete the publisher’s synchronous operation;
- is meaningful beyond one private method call.

A mutable command, request, or arbitrary framework signal is not automatically an Event.

## 3. Owns

An Event may own:

- the meaning of the occurrence;
- event data required by permitted consumers;
- compatibility expectations;
- publication timing defined by its owner;
- sensitivity and serialization constraints;
- Event-specific tests and documentation.

## 4. Must Not Own

An Event must not own:

- follow-up behavior performed by Listeners;
- another owner’s state;
- a required synchronous command, result, or rejection path;
- hidden mutable implementation details;
- UI presentation;
- delivery transport;
- generic application-wide coordination without an explicit occurrence owner.

## 5. Dependency Rules

An Event:

- may be emitted by owner-controlled Actions, Models, Jobs, or other permitted behavior;
- may be consumed by owner-local or explicitly permitted cross-owner Listeners;
- requires cross-owner consumers to depend only on the public Event Contract;
- must not require consumers to access Event-owner internals;
- must not expose owner internals beyond the accepted Event contract;
- must not conceal a synchronous dependency that requires an immediate result or confirmed failure;
- may be dispatched through framework integration without transferring ownership.
- must not depend on Listeners
- must not depend on Delivery Adapters or Surfaces
- must preserve Module dependency and compatibility rules
- must not own persistence mutation
- must not own generic unbounded payloads
- must not own application workflow orchestration

## 6. Target Status

Status: permanent

Event is a permanent shared Technical Role.

This definition does not require every owner to contain an `Events/` folder.

Default target placement is:

```text
app/Core/<Capability>/Events/
Modules/<Module>/src/Events/
```

Event classes use `<CompletedFact>Event`. Event machine identifiers remain a separate capability-first completed-fact key family. Dispatch timing, transactional behavior, serialization, and compatibility remain later standards authority.

## 7. Accepted Decision

Status: accepted

Events remain owner-defined facts beneath the capability or Module that owns the occurrence.

They provide an explicit communication boundary for independent reactions without transferring behavior ownership or replacing a required synchronous Contract call.

## 8. Open Questions

The following details remain deferred:

- exact transactional dispatch rules;
- exact cross-owner event compatibility rules;
- exact serialization requirements;
- exact event-versioning strategy.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Listener Definition](../Listeners/Definition.md)
- [Contract Definition](../Contracts/Definition.md)
- [Job Definition](../Jobs/Definition.md)
- [Phase 2.2 Secondary Organization Within Each Owner](../../Milestones/milestone-0/goal-3/phase-2/2-2-secondary-organization-within-each-owner.md)
- [Phase 4.10 Dependency Direction](../../Milestones/milestone-0/goal-3/phase-4/4-10-dependency-direction.md)
- [Phase 4.11 Cross-Owner Communication](../../Milestones/milestone-0/goal-3/phase-4/4-11-cross-owner-communication.md)
- Related GitHub issues: #49, #51
