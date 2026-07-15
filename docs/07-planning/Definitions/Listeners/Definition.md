<!--
DOC-META
title: Listener Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Listeners/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Listener as owner-controlled event-consumption logic that reacts to one or more accepted Events.
-->

# Listener Definition

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

A Listener is owner-controlled event-consumption logic that reacts to one or more accepted Events.

A Listener belongs to the owner of the behavior it performs in response, not automatically to the owner of the Event it consumes.

The working Technical Role label is:

```text
Listeners/
```

## 2. Classification Rule

An artifact is a Listener when it:

- consumes an explicit Event contract;
- performs one bounded reaction;
- belongs to one explicit behavior owner;
- may invoke owner-controlled Actions, Jobs, or Notifications;
- can be understood independently from Event transport mechanics.

## 3. Owns

A Listener may own:

- one bounded reaction to an Event;
- event-to-owner-behavior translation;
- invocation of owner-controlled follow-up behavior;
- listener-specific retry or failure behavior when applicable;
- Listener-specific tests and documentation.

## 4. Must Not Own

A Listener must not own:

- the Event definition;
- unrelated reactions;
- another owner’s internal implementation;
- transport-specific HTTP or console behavior;
- generic application orchestration;
- hidden dependency on optional Modules;
- reusable UI presentation;
- authorization policy unrelated to its owner’s behavior.

## 5. Dependency Rules

A Listener:

- may depend on the Event’s public contract;
- may invoke behavior owned by the Listener’s owner;
- must not depend on Event-owner internals;
- must respect Core and Module dependency direction;
- must not cause Core to depend on an optional Module Event implementation;
- may be queued when later standards permit;
- must preserve idempotency and failure expectations defined by applicable implementation contracts.

## 6. Target Status

Status: permanent

Listener is a permanent shared Technical Role.

This definition does not require every owner to contain a `Listeners/` folder.

Exact listener registration, queueing, retry, and ordering behavior remains subject to later standards.

## 7. Accepted Decision

Status: accepted

Listeners are organized beneath the Core capability or Module that owns the reaction they perform.

Event ownership and Listener ownership may differ without permitting direct access to either owner’s internals.

## 8. Open Questions

The following details remain deferred:

- exact Listener naming conventions;
- exact queueing and retry defaults;
- exact listener-ordering behavior;
- exact idempotency requirements;
- exact cross-owner Event subscription rules.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Event Definition](../Events/Definition.md)
- [Job Definition](../Jobs/Definition.md)
- [Phase 2.3 Cross-Cutting Technical Code](../../Milestones/milestone-0/goal-3/phase-2/2-3-cross-cutting-technical-code.md)
- Related GitHub issue: #49
