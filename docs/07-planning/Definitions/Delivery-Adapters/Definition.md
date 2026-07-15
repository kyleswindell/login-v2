<!--
DOC-META
title: Delivery Adapter Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Delivery-Adapters/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Delivery Adapter as owner-local channel integration that translates external invocation into owner-controlled behavior and responses.
-->

# Delivery Adapter Definition

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

A Delivery Adapter is owner-local integration code that receives or emits communication through a specific invocation channel and translates that channel into owner-controlled application behavior or output.

Delivery Adapter types may include:

- HTTP and API adapters;
- console adapters;
- webhook adapters;
- queue or message-consumer adapters;
- scheduler or background invocation adapters;
- other channel-specific entry points.

A Delivery Adapter belongs to the Core capability or Module whose behavior it exposes.

A Delivery Adapter is not an application owner and is not a Surface.

## 2. Classification Rule

An artifact is a Delivery Adapter when its primary responsibility is one or more of:

- accepting channel-specific input;
- validating transport or channel format;
- extracting actor or invocation context;
- translating input into owner-controlled data;
- invoking an owner Action, Query, workflow, or public contract;
- translating owner output into a channel-specific response;
- acknowledging or rejecting channel delivery;
- translating failures into channel-specific behavior.

Channel-neutral behavior does not belong in a Delivery Adapter.

UI-specific presentation composition belongs to a Surface.

## 3. Owns

A Delivery Adapter may own:

- transport parsing;
- channel-specific validation;
- request, command, payload, or message translation;
- actor and invocation-context extraction;
- invocation of owner-controlled behavior;
- response selection and formatting;
- status, redirect, exit-code, or acknowledgement behavior;
- channel-specific failure translation;
- delivery-specific documentation and verification.

Specific Delivery Adapter roles may define additional bounded responsibilities.

## 4. Must Not Own

A Delivery Adapter must not own:

- authoritative business or system rules;
- persistence policy;
- authoritative authorization policy;
- capability or Module lifecycle;
- another owner’s internal implementation;
- reusable UI infrastructure;
- Surface-specific composition;
- Host Registry contracts or contribution resolution;
- behavior solely because the adapter invokes it;
- generic cross-owner coordination without one explicit composition owner.

A controller, command, webhook handler, or consumer must not become the owner of the application behavior it exposes.

## 5. Dependency Rules

A Delivery Adapter:

- may depend on public behavior exposed by its owner;
- may invoke owner-controlled Actions, Queries, workflows, and contracts;
- may use framework integration required for its channel;
- may select or return an applicable owner-specific Surface response;
- must not access another owner’s internals;
- must not be depended on by owner domain or system behavior;
- must not move transport-specific concerns into channel-neutral contracts;
- must preserve authorization and lifecycle rules defined by the behavior owner.

Application-wide framework registration may remain in Laravel integration while owner-specific delivery behavior remains with its owner.

## 6. Target Status

Status: permanent

Delivery Adapter is a permanent architecture concept.

Working physical roles may include:

```text
Http/
Console/
Webhooks/
```

Final physical labels, placement, casing, and namespaces remain subject to Goal 3 Phases 3 through 5.

API delivery may remain within HTTP delivery unless a later accepted decision establishes a distinct role.

## 7. Accepted Decision

Status: accepted

Delivery adapters are organized beneath the Core capability or Module that owns the behavior they expose.

They handle channel-specific transport, validation, invocation, and response concerns while delegating application behavior to owner-controlled Actions, Queries, contracts, and workflows.

A multi-owner endpoint or interaction still requires one explicit composition owner.

## 8. Open Questions

The following details remain deferred:

- final folder names for webhook and background adapters;
- exact separation of HTTP and API delivery;
- exact placement of route files;
- exact framework registration boundaries;
- exact subordinate roles for Controllers, Requests, Resources, Commands, and Consumers;
- channel-specific verification standards.

These questions belong to Goal 3 placement, naming, and validation phases.

## 9. Related

- [Definitions Index](../Index.md)
- [Surface Definition](../Surfaces/Definition.md)
- [Goal 3 Target Repository Architecture](../../Milestones/milestone-0/goal-3/target-repository-architecture.md)
- [Phase 2.4 Delivery Code Organization](../../Milestones/milestone-0/goal-3/phase-2/2-4-delivery-code-organization.md)
- Related GitHub issue: #49
