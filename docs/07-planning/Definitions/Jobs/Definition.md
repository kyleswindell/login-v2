<!--
DOC-META
title: Job Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Jobs/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Job as owner-controlled deferred or queueable work that executes a bounded application responsibility outside the initiating call.
-->

# Job Definition

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

A Job is owner-controlled deliberately deferred, retryable, scheduled, or queueable work that executes a bounded application responsibility outside the initiating call.

A Job belongs to the Core capability or Module whose behavior it executes. It is not a substitute for a synchronous Contract call when the initiator requires an immediate result or confirmed failure.

The working Technical Role label is:

```text
Jobs/
```

## 2. Classification Rule

An artifact is a Job when it:

- represents one bounded unit of deferred work;
- may execute asynchronously, later, or through a queue;
- has explicit input and failure expectations;
- invokes owner-controlled behavior;
- can be retried or monitored according to applicable operational rules.

A class is not a Job merely because it can run in the background.

## 3. Owns

A Job may own:

- one bounded deferred-execution unit;
- deferred-execution orchestration;
- queue-specific retry, timeout, uniqueness, or failure metadata;
- invocation of owner-controlled Actions, Queries, or another explicitly defined owner-controlled operation;
- Job-specific serialization data;
- Job-specific tests and documentation.

## 4. Must Not Own

A Job must not own:

- unrelated application workflows;
- another owner’s internals;
- a required immediate result hidden behind deferred execution;
- transport parsing unrelated to execution;
- generic queue infrastructure;
- authorization policy unrelated to the owner’s behavior;
- arbitrary service-container lookup;
- multiple unrelated units of work.

## 5. Dependency Rules

A Job:

- may depend on owner-controlled Actions, Contracts, Models, and persistence;
- may consume public Contracts from other owners when dependency rules permit;
- must not depend on Delivery Adapters or Surfaces;
- must not access another owner’s internals;
- must not obscure a synchronous cross-owner dependency by dispatching a Job;
- must preserve authorization, idempotency, retry, timeout, ordering, and failure requirements.
- must preserve privacy and lifecycle requirements.
- may emit Events or Notifications when owned behavior requires.
- must comply with queue and operational standards.
- must not own reusable UI presentation.
- must not own authoritative scheduling policy unless assigned.
- must not own hidden persistent state unrelated to its operation.

## 6. Target Status

Status: permanent

Job is a permanent shared Technical Role.

This definition does not require every owner to contain a `Jobs/` folder.

Default target placement is:

```text
app/Core/<Capability>/Jobs/
Modules/<Module>/src/Jobs/
```

Job classes use `<ImperativeOperation>Job`. Job keys and logical queue keys remain separate machine-identifier families. Retry, timeout, serialization, uniqueness, batching, and scheduling remain later standards authority.

## 7. Accepted Decision

Status: accepted

Jobs remain beneath the owner and cohesive capability or Module whose deferred behavior they execute.

Framework queue registration does not transfer Job ownership to Laravel integration. Jobs are used for intentionally deferred or isolated execution, not to conceal a required immediate cross-owner result.

## 8. Open Questions

The following details remain deferred:

- exact queue and priority rules;
- exact retry, timeout, and backoff standards;
- exact idempotency requirements;
- exact scheduler-to-Job relationship.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Action Definition](../Actions/Definition.md)
- [Event Definition](../Events/Definition.md)
- [Notification Definition](../Notifications/Definition.md)
- [Contract Definition](../Contracts/Definition.md)
- [Listener Definition](../Listeners/Definition.md)
- [Phase 2.2 Secondary Organization Within Each Owner](../../Milestones/milestone-0/goal-3/phase-2/2-2-secondary-organization-within-each-owner.md)
- [Phase 4.10 Dependency Direction](../../Milestones/milestone-0/goal-3/phase-4/4-10-dependency-direction.md)
- [Phase 4.11 Cross-Owner Communication](../../Milestones/milestone-0/goal-3/phase-4/4-11-cross-owner-communication.md)
- Related GitHub issues: #49, #51
