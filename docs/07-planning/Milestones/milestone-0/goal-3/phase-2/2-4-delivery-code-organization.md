<!--
DOC-META
title: Phase 2.4 Delivery Code Organization
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/2-4-delivery-code-organization.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the accepted organization of web, API, console, webhook, and UI-presentation delivery code beneath its behavior owner.
-->

# Phase 2.4 Delivery Code Organization

Parent: [Phase 2 Repository Organization Index](index.md)

## 1. Purpose

This document records how Login 2.0 organizes controllers, requests, API resources, presenters, ViewModels, PageData, console adapters, webhook adapters, and other channel-specific entry points.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 2 review
- Implementation state: target direction only
- Owning GitHub issue: #49
- Parent decisions: Phase 2.1 through Phase 2.3

## 3. Core Principle

> Delivery code belongs with the owner of the behavior it exposes.

Delivery channels do not become application owners.

## 4. Accepted Decision

> Delivery adapters are organized beneath the Core capability or Module that owns the behavior they expose. Web, API, console, webhook, and other channel-specific code handles transport, validation, invocation, and response concerns while delegating application behavior to owner-controlled Actions, Queries, contracts, and workflows. UI-specific presentation objects belong to the owner’s `Surface/`, while API and other channel-specific representations remain with their delivery channel. Root Laravel delivery folders are reserved for application-wide framework integration, base classes, global middleware, root registration, and bounded compatibility concerns. Every multi-owner endpoint retains one explicit composition owner, and delivery code must not become an independent application owner.

## 5. Delivery Organization

Conceptually:

```text
Owner
└── Capability or Module
    └── Delivery channel
```

Examples:

```text
Core/Settings/
├── Http/
├── Console/
├── Webhooks/
└── Surface/
```

```text
Modules/Notifications/
├── Http/
├── Console/
├── Webhooks/
└── Surface/
```

Exact paths remain later decisions.

## 6. Web And API Delivery

Owner-specific controllers, requests, and API resources remain with the capability or Module whose behavior they expose.

```text
Core/Settings/Http/
├── Controllers/
├── Requests/
└── Resources/
```

Root Laravel HTTP folders may retain global middleware, base classes, root registration, and bounded compatibility integration.

They must not become the permanent owner of capability-specific behavior.

## 7. HTTP Delivery Versus UI Surface

`Http/` owns:

- route invocation;
- request validation;
- actor-context extraction;
- request-to-data translation;
- response and redirect behavior;
- transport-specific error translation.

`Surface/` owns:

- owner-specific page composition;
- Surface-specific navigation;
- PageData;
- ViewModels;
- Surface-specific presenters;
- selection of UI-owned layouts and components.

Typical flow:

```text
HTTP request
    ↓
HTTP adapter
    ↓
Owner Action or Query
    ↓
Surface PageData or ViewModel
    ↓
UI-owned layout and components
```

The HTTP adapter does not own business behavior. The Surface does not own HTTP transport policy.

## 8. Presentation Object Classification

UI-specific presentation objects belong beneath the owner’s `Surface/`.

API-specific representations remain with API or HTTP delivery.

Channel-neutral data belongs in owner-controlled roles such as:

```text
Data/
Queries/
Contracts/
```

It does not belong in a delivery folder merely because one channel consumes it.

## 9. Console And Webhook Delivery

Owner-specific Artisan commands remain with the behavior owner.

A command may parse input, invoke an owner Action or Query, format output, and return an exit result. It must not contain the underlying application workflow.

Webhook adapters remain with the owner responsible for the integration or behavior.

They may validate signatures, translate payloads, acknowledge transport, and handle channel-specific errors while delegating application behavior.

## 10. Registry, Contribution, Surface, And Delivery

These roles remain independent.

```text
Core/Settings/
├── Registry/
├── Surface/
└── Http/

Modules/Notifications/
├── Contrib/
│   └── Settings/
└── Http/
```

- Settings Registry resolves contributions.
- Settings Surface presents the experience.
- Settings HTTP receives web requests.
- Notifications contribution exposes Notifications-owned behavior.
- Notifications HTTP exposes Notifications-owned delivery.

Participation in one page does not merge ownership.

## 11. Multi-Owner Endpoints

An endpoint that consumes several owners still has one explicit composition owner.

A Dashboard endpoint may consume Audit, Notifications, Orders, and Preferences, but it belongs to the Dashboard capability and consumes public contracts from those owners.

The composition owner controls response behavior, failure handling, use-case composition, and presentation orchestration.

## 12. Thin-Adapter Rule

Delivery adapters may own transport parsing, channel validation, invocation, response formatting, and transport-specific failure translation.

They must not own:

- business rules;
- persistence policy;
- authoritative authorization policy;
- another owner’s internals;
- reusable UI infrastructure;
- capability lifecycle;
- Host Registry policy beyond invoking its public contract.

“Thin” describes responsibility, not line count.

## 13. Root Laravel Integration

Root Laravel delivery locations remain valid only for bounded application-wide integration, such as:

```text
app/Http/Middleware/
app/Http/Controllers/Controller.php
app/Console/
routes/
```

Owner-specific artifacts must not remain there merely because Laravel generated them there.

## 14. Required Effects

This decision requires:

- delivery code to follow behavior ownership;
- Surface presentation to remain distinct from HTTP delivery;
- channel-neutral data to remain outside delivery;
- multi-owner endpoints to retain one composition owner;
- root Laravel folders to remain bounded;
- adapters to delegate application behavior.

## 15. Boundaries

Decision 2.4 does not decide exact delivery paths, route-file placement, final casing, webhook subdivision, or framework registration details.

Those decisions belong to later Goal 3 phases.

## 16. Documentation Impact

Reflect this decision in:

- the Phase 2 index;
- the Goal 3 target-architecture artifact;
- the Phase 3 target tree;
- Phase 4 placement and dependency rules;
- applicable Feature Specs;
- Surface and delivery-role definitions.

## 17. Verification

Confirm that representative web, API, console, and webhook artifacts have:

- one behavior owner;
- one delivery role;
- one public invocation boundary;
- one presentation classification where applicable.

## 18. Related

- [Phase 2 Repository Organization Index](index.md)
- [Phase 2.3 Cross-Cutting Technical Code](2-3-cross-cutting-technical-code.md)
- [Phase 2.90 Surface, Host, And Registry Reclassification](2-90-surface-host-registry-reclassification.md)
- GitHub issue: #49
