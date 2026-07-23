<!--
DOC-META
title: Phase 4.3 Delivery Adapter Placement
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/4-3-delivery-adapter-placement.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records owner-local placement for HTTP, API, console, webhook, queue, listener, presenter, renderer, ViewModel, and PageData adapters.
-->

# Phase 4.3 Delivery Adapter Placement

Parent: [Phase 4 Placement And Dependency Rules Index](index.md)


## 1. Purpose

Define where channel-specific delivery artifacts belong without making delivery the behavior owner.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 4 review
- Implementation state: target direction only
- Owning GitHub issue: #51
- Depends on: Decisions 4.1–4.2

## 3. Default Placement

| Adapter                                            | Core placement                             | Module placement                         |
| -------------------------------------------------- | ------------------------------------------ | ---------------------------------------- |
| HTTP, API, requests, owner middleware, webhooks    | `app/Core/<Capability>/Http/`              | `Modules/<Module>/src/Http/`             |
| Console commands                                   | `app/Core/<Capability>/Console/`           | `Modules/<Module>/src/Console/`          |
| Queued jobs                                        | Owner-local `Jobs/`                        | Module `src/Jobs/`                       |
| Event listeners                                    | Owner-local `Listeners/`                   | Module `src/Listeners/`                  |
| Owner-specific UI presenters, ViewModels, PageData | Owner-local `Surface/`                     | Module `src/Surface/`                    |
| Reusable rendering infrastructure                  | `app/UI/<Responsibility>/<TechnicalRole>/` | Not Module-owned unless package-specific |

Root `app/Http/` and `app/Console/` remain restricted to application-wide framework integration, base classes, global middleware, registration, and bounded compatibility.

## 4. Adapter Responsibility

Delivery Adapters may own:

- channel-specific input and normalization;
- transport validation;
- authorization handoff;
- invocation;
- serialization and response selection;
- acknowledgement;
- retry or failure translation.

They delegate application behavior to owner-controlled Actions, Queries, Policies, Contracts, and workflows.

Channel-independent validation, policy, persistence orchestration, and business workflow do not belong in adapters.

## 5. Surface Distinction

Interactive web delivery may involve both an HTTP adapter and an owner-specific Surface.

```text
HTTP adapter
→ owner behavior
→ owner Surface
→ reusable UI
```

A controller is not automatically a Surface. A Surface is not automatically a controller. Livewire is normally owner-specific Surface implementation rather than an HTTP owner.

## 6. Dependency Direction

Adapters depend inward on their owner’s application boundary. Owner behavior must not depend outward on controllers, requests, commands, views, or framework response objects.

## 7. Accepted Decision

> Login 2.0 places Delivery Adapters with the Core capability or Module whose behavior they expose. Core HTTP and console adapters live beneath `app/Core/<Capability>/Http/` and `app/Core/<Capability>/Console/`; Module adapters live beneath `Modules/<Module>/src/Http/` and `Modules/<Module>/src/Console/`; queued, scheduled, listener, and webhook adapters remain with the owner of the invoked behavior. Controllers, requests, middleware, commands, webhook handlers, API transformers, jobs, presenters, renderers, ViewModels, and PageData objects own only channel-specific concerns and delegate application behavior to owner-controlled boundaries. Owner-specific UI presentation belongs to the owner’s Surface role, while reusable presentation infrastructure remains UI-owned. Root `app/Http/` and `app/Console/` are restricted application-wide Laravel integration rather than default feature owners.

## 8. Boundaries And Handoff

Route and registration mechanics remain Decision 4.4 authority. Configuration and discovery remain Decision 4.5 authority. Presentation resources remain Decision 4.7 authority.

## 9. Related

- [Implementation Placement](4-2-implementation-placement.md)
- [Route Placement And Registration](4-4-route-placement-and-registration.md)
- [Cross-Owner Communication](4-11-cross-owner-communication.md)
- Related GitHub issue: #51
