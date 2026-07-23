<!--
DOC-META
title: Console Delivery Adapter Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Console-Delivery-Adapters/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Console Delivery Adapter as owner-local command-line transport integration for invoking owner-controlled behavior and returning console results.
-->

# Console Delivery Adapter Definition

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

A Console Delivery Adapter is owner-local command-line transport integration that parses console input, invokes owner-controlled behavior, and returns console output and an exit result.

The working Technical Role label is:

```text
Console/
```

A Console Delivery Adapter is a specialization of Delivery Adapter.

## 2. Classification Rule

An artifact is a Console Delivery Adapter when it primarily handles:

- command registration or invocation;
- arguments and option parsing;
- interactive or non-interactive console input;
- Actor or execution-context extraction when applicable;
- invocation of owner-controlled Actions or Queries;
- console output and exit codes;
- console-specific failure translation.

## 3. Owns

A Console Delivery Adapter may own:

- owner-specific Artisan commands;
- console input parsing;
- command-specific validation;
- output formatting;
- progress and confirmation behavior;
- exit-code selection;
- console-specific tests and documentation.

## 4. Must Not Own

A Console Delivery Adapter must not own:

- application workflows;
- persistence policy;
- authoritative authorization policy;
- scheduler-wide policy;
- another owner’s internals;
- reusable UI presentation;
- broad application bootstrap;
- behavior solely because it is invoked from a command.

## 5. Dependency Rules

A Console Delivery Adapter:

- may invoke owner-controlled Actions, Queries, Policies, and Contracts;
- may use Laravel console framework integration;
- must not be depended on by owner domain behavior;
- must not access another owner’s internals;
- must preserve authorization, safety, and operational requirements;
- must separate application-wide scheduler registration from owner-specific command behavior.

## 6. Target Status

Status: permanent

Console Delivery Adapter is a permanent delivery specialization.

Default target placement is:

```text
app/Core/<Capability>/Console/
Modules/<Module>/src/Console/
```

Root `app/Console/` remains restricted to application-wide Laravel integration, base console artifacts, global registration, and bounded compatibility.

Console command classes use `<Verb><Subject>Command`. Namespaces, scheduler relationships, Artisan signatures, and internal subdivisions remain later standards and implementation authority.

## 7. Accepted Decision

Status: accepted

Owner-specific commands remain with the Core capability or Module whose behavior they expose.

A command parses console input, invokes owner-controlled behavior, formats output, and returns an exit result without absorbing the underlying application workflow.

## 8. Open Questions

The following details remain deferred:

- exact command naming conventions;
- exact descriptor fields and Typed Registrar command registration;
- exact scheduling boundaries and schedule-registration naming;
- exact interactive-command restrictions;
- exact console verification requirements.

## 9. Related

- [Definitions Index](../Index.md)
- [Delivery Adapter Definition](../Delivery-Adapters/Definition.md)
- [Action Definition](../Actions/Definition.md)
- [Query Definition](../Queries/Definition.md)
- [Job Definition](../Jobs/Definition.md)
- [Phase 2.4 Delivery Code Organization](../../Milestones/milestone-0/goal-3/phase-2/2-4-delivery-code-organization.md)
- [Phase 4.3 Delivery Adapter Placement](../../Milestones/milestone-0/goal-3/phase-4/4-3-delivery-adapter-placement.md)
- [Phase 4.4 Route Placement And Registration](../../Milestones/milestone-0/goal-3/phase-4/4-4-route-placement-and-registration.md)
- Related GitHub issues: #49, #51
