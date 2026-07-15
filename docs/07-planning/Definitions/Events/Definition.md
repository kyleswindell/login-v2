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

An Event is an owner-defined fact that records or communicates that a meaningful application occurrence has happened.

The Event belongs to the Core capability or Module whose behavior produced the occurrence.

The working Technical Role label is:

```text
Events/
```

## 2. Classification Rule

An artifact is an Event when it:

- represents a completed or recognized occurrence;
- has one explicit owner;
- communicates defined event data;
- may be consumed by permitted Listeners;
- does not itself command a future operation;
- has stable meaning independent of one Listener.

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

- side-effect execution;
- Listener behavior;
- transport-specific delivery;
- application workflow orchestration;
- another owner’s state;
- arbitrary mutable context;
- generic unbounded payloads;
- persistence mutation.

## 5. Dependency Rules

An Event:

- may be emitted by owner-controlled Actions, Models, Jobs, or other permitted behavior;
- may be consumed by owner-local or explicitly permitted cross-owner Listeners;
- must not depend on Listeners;
- must not depend on Delivery Adapters or Surfaces;
- must not expose owner internals beyond the accepted event contract;
- must preserve Module dependency and compatibility rules;
- may be dispatched through framework integration without transferring ownership.

## 6. Target Status

Status: permanent

Event is a permanent shared Technical Role.

This definition does not require every owner to contain an `Events/` folder.

Exact synchronous, queued, transactional, and cross-owner event rules remain subject to later standards.

## 7. Accepted Decision

Status: accepted

Events remain owner-defined artifacts beneath the capability or Module that owns the occurrence.

They provide an explicit communication boundary without transferring ownership of behavior to consumers.

## 8. Open Questions

The following details remain deferred:

- exact event naming conventions;
- exact transactional dispatch rules;
- exact cross-owner event compatibility rules;
- exact serialization requirements;
- exact event-versioning strategy.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Listener Definition](../Listeners/Definition.md)
- [Job Definition](../Jobs/Definition.md)
- [Phase 2.2 Secondary Organization Within Each Owner](../../Milestones/milestone-0/goal-3/phase-2/2-2-secondary-organization-within-each-owner.md)
- Related GitHub issue: #49
