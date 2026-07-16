<!--
DOC-META
title: HTTP Delivery Adapter Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/HTTP-Delivery-Adapters/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines an HTTP Delivery Adapter as owner-local web or API transport integration for invoking owner-controlled behavior and producing HTTP responses.
-->

# HTTP Delivery Adapter Definition

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

An HTTP Delivery Adapter is owner-local web or API transport integration that receives an HTTP request, invokes owner-controlled behavior, and produces an HTTP response.

The working Technical Role label is:

```text
Http/
```

An HTTP Delivery Adapter is a specialization of Delivery Adapter and is not a Surface.

## 2. Classification Rule

An artifact is an HTTP Delivery Adapter when it primarily handles:

- route invocation;
- HTTP request parsing;
- request validation;
- Actor or invocation-context extraction;
- request-to-data translation;
- invocation of owner-controlled Actions or Queries;
- HTTP responses, redirects, status codes, or API representations;
- HTTP-specific failure translation.

## 3. Owns

An HTTP Delivery Adapter may own:

- controllers;
- Form Requests or equivalent request validators;
- API Resources or serializers;
- HTTP-specific middleware owned by the capability or Module;
- response and redirect selection;
- transport-specific tests and documentation.

## 4. Must Not Own

An HTTP Delivery Adapter must not own:

- application workflows;
- persistence policy;
- authoritative authorization policy;
- Surface composition;
- reusable UI infrastructure;
- Host Registry policy;
- another owner’s internals;
- channel-neutral Data Objects solely because HTTP currently consumes them.

## 5. Dependency Rules

An HTTP Delivery Adapter:

- may invoke owner-controlled Actions, Queries, Policies, and Contracts;
- may select or return an owner-specific Surface response;
- may use Laravel HTTP framework integration;
- must not be depended on by owner domain behavior;
- must not access another owner’s internals;
- must preserve authorization and validation boundaries;
- must keep API-specific representation within HTTP delivery.

## 6. Target Status

Status: permanent

HTTP Delivery Adapter is a permanent delivery specialization.

Default target placement is:

```text
app/Core/<Capability>/Http/
Modules/<Module>/src/Http/
```

Root `app/Http/` remains restricted to application-wide Laravel integration, base classes, global middleware, root registration, and bounded compatibility.

Final internal subdivisions, class names, namespaces, and casing remain Phase 5 authority. API delivery remains within HTTP delivery unless a later accepted decision separates it.

## 7. Accepted Decision

Status: accepted

Owner-specific web and API delivery remains beneath the Core capability or Module whose behavior it exposes.

Root Laravel HTTP folders remain limited to application-wide framework integration, base classes, global middleware, root registration, and bounded compatibility concerns.

## 8. Open Questions

The following details remain deferred:

- exact Controllers, Requests, Resources, and Middleware subdivisions;
- exact owner-local route filenames and internal route organization;
- exact API separation and representation naming;
- exact response and error standards;
- exact HTTP architecture proof.

## 9. Related

- [Definitions Index](../Index.md)
- [Delivery Adapter Definition](../Delivery-Adapters/Definition.md)
- [Surface Definition](../Surfaces/Definition.md)
- [Action Definition](../Actions/Definition.md)
- [Query Definition](../Queries/Definition.md)
- [Phase 2.4 Delivery Code Organization](../../Milestones/milestone-0/goal-3/phase-2/2-4-delivery-code-organization.md)
- [Phase 4.3 Delivery Adapter Placement](../../Milestones/milestone-0/goal-3/phase-4/4-3-delivery-adapter-placement.md)
- [Phase 4.4 Route Placement And Registration](../../Milestones/milestone-0/goal-3/phase-4/4-4-route-placement-and-registration.md)
- Related GitHub issues: #49, #51
