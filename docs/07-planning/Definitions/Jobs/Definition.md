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

A Job is owner-controlled deferred or queueable work that executes a bounded application responsibility outside the initiating call.

A Job belongs to the Core capability or Module whose behavior it performs.

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

- deferred-execution orchestration;
- queue-facing input;
- retry and failure metadata when applicable;
- invocation of owner-controlled Actions or services;
- idempotency handling assigned to the Job;
- Job-specific tests and documentation.

## 4. Must Not Own

A Job must not own:

- HTTP, console, or webhook transport handling;
- broad unrelated workflows;
- another owner’s internals;
- reusable UI presentation;
- arbitrary service-container lookup;
- authoritative scheduling policy unless assigned;
- hidden persistent state unrelated to its operation.

## 5. Dependency Rules

A Job:

- may depend on owner-controlled Actions, Contracts, Models, and persistence;
- may consume public contracts from other owners when dependency rules permit;
- must not depend on Delivery Adapters or Surfaces;
- must not access another owner’s internals;
- must preserve authorization, privacy, idempotency, and lifecycle requirements;
- may emit Events or Notifications when owned behavior requires;
- must comply with queue and operational standards.

## 6. Target Status

Status: permanent

Job is a permanent shared Technical Role.

This definition does not require every owner to contain a `Jobs/` folder.

Exact queue assignment, retry, timeout, uniqueness, serialization, and observability rules remain subject to later standards.

## 7. Accepted Decision

Status: accepted

Jobs remain beneath the owner and cohesive capability or Module whose deferred behavior they execute.

Framework queue registration does not transfer Job ownership to Laravel integration.

## 8. Open Questions

The following details remain deferred:

- exact Job naming conventions;
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
- Related GitHub issue: #49
