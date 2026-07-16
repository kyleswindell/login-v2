<!--
DOC-META
title: Notification Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Notifications/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Notification as owner-specific communication content and channel intent produced by a capability or Module.
-->

# Notification Definition

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

A Notification is owner-specific communication content and channel intent produced by a Core capability or Module for delivery to an applicable recipient.

The Notification role describes the message or notification implementation owned by the behavior source. It does not redefine the Core Notifications capability or shared delivery infrastructure.

The working Technical Role label is:

```text
Notifications/
```

## 2. Classification Rule

An artifact is a Notification when it:

- represents one owner-specific communication;
- defines recipient-facing content or data;
- identifies permitted delivery channels or presentation;
- is triggered by owner-controlled behavior;
- delegates shared dispatch, preference, and infrastructure concerns to their accepted owners.

## 3. Owns

A Notification may own:

- owner-specific message intent;
- recipient-facing content and data;
- supported channel declarations;
- notification-specific subject or presentation data;
- references to owner-controlled routes or Actions when permitted;
- Notification-specific tests and documentation.

## 4. Must Not Own

A Notification must not own:

- application-wide notification infrastructure;
- global recipient preferences;
- shared channel transports;
- another owner’s behavior;
- broad workflow orchestration;
- authorization policy;
- generic templates unrelated to its owner;
- direct transport credentials or operational configuration.

## 5. Dependency Rules

A Notification:

- remains owned by the capability or Module that produces the communication;
- may depend on public shared notification contracts;
- may be dispatched by owner-controlled Actions, Jobs, or Listeners;
- must not access another owner’s internals;
- must preserve recipient preference, privacy, and delivery rules;
- must not cause Core to depend on optional Module notification implementations;
- may use UI-owned presentation infrastructure only where applicable.

## 6. Target Status

Status: permanent

Notification is a permanent shared Technical Role.

This definition does not require every owner to contain a `Notifications/` folder.

The distinction between owner-specific Notifications and the Core Notifications capability must remain explicit. Concrete Notification classes use `<ConditionOrFact>Notification`; stable notification type keys remain a separate domain-first identifier family.

## 7. Accepted Decision

Status: accepted

Owner-specific notification implementations remain beneath the Core capability or Module whose behavior produces them.

Shared notification delivery, preference, and infrastructure responsibilities remain with their applicable Core owners.

## 8. Open Questions

The following details remain deferred:

- exact channel-selection rules;
- exact template and localization ownership;
- exact preference-resolution boundary;
- exact queueing and delivery-proof requirements.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Job Definition](../Jobs/Definition.md)
- [Event Definition](../Events/Definition.md)
- [Phase 2.2 Secondary Organization Within Each Owner](../../Milestones/milestone-0/goal-3/phase-2/2-2-secondary-organization-within-each-owner.md)
- Related GitHub issue: #49
