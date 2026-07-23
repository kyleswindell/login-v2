<!--
DOC-META
title: Policy Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Policies/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Policy as owner-controlled authorization logic that decides whether an Actor may perform an operation on a protected resource or responsibility.
-->

# Policy Definition

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

A Policy is owner-controlled authorization logic that decides whether an Actor may perform an operation on a protected resource, Model, capability, or Module responsibility.

A Policy belongs to the owner of the protected behavior or state.

The working Technical Role label is:

```text
Policies/
```

## 2. Classification Rule

An artifact is a Policy when it:

- evaluates permission for one owner-controlled responsibility;
- uses Actor, Principal, role, scope, ownership, state, or contextual inputs;
- produces an authorization decision;
- is invoked before protected behavior is exposed or executed;
- remains separate from transport and presentation.

Validation, business rules, and feature availability are not automatically authorization Policies.

## 3. Owns

A Policy may own:

- authorization decisions;
- ability-specific permission rules;
- resource- and state-sensitive authorization;
- owner-controlled access conditions;
- denial behavior expressed through its contract;
- Policy-specific tests and documentation.

## 4. Must Not Own

A Policy must not own:

- HTTP responses or redirects;
- UI visibility as the sole authorization enforcement;
- application workflows;
- persistence mutation;
- another owner’s authorization rules;
- authentication or assurance establishment;
- generic feature configuration;
- transport-specific actor extraction.

## 5. Dependency Rules

A Policy:

- may depend on public Actor, Principal, ownership, and state contracts;
- may inspect owner-controlled Models or data required for authorization;
- must not depend on Delivery Adapters or Surfaces;
- must not access another owner’s internals;
- must remain authoritative even when UI hides an unavailable action;
- may be invoked by Actions, Queries, Delivery Adapters, or framework authorization integration;
- must preserve Core and Module dependency direction.

## 6. Target Status

Status: permanent

Policy is a permanent shared Technical Role.

The existence of this definition does not require every owner to contain a `Policies/` folder.

Exact gate, policy-class, middleware, and assurance relationships remain subject to later security and coding standards.

## 7. Accepted Decision

Status: accepted

Authorization policy remains with the Core capability or Module that owns the protected behavior.

Delivery Adapters and Surfaces may invoke or reflect Policy decisions but must not become the authoritative Policy owner.

## 8. Open Questions

The following details remain deferred:

- exact Policy naming conventions;
- exact gate versus Policy usage;
- exact assurance-step-up relationship;
- exact cross-owner authorization contracts;
- exact static and test enforcement.

## 9. Related

- [Definitions Index](../Index.md)
- [Technical Role Definition](../Technical-Roles/Definition.md)
- [Model Definition](../Models/Definition.md)
- [Action Definition](../Actions/Definition.md)
- [Phase 2.4 Delivery Code Organization](../../Milestones/milestone-0/goal-3/phase-2/2-4-delivery-code-organization.md)
- Related GitHub issue: #49
