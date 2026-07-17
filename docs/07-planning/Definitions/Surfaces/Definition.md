<!--
DOC-META
title: Frame Surface Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Surfaces/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Frame Surface as a named compositional region of the persistent authenticated Frame and supersedes broad owner-specific Surface and generic Surface-folder meanings.
-->

# Frame Surface Definition

Parent: [Definitions Index](../Index.md)

> Compatibility note: the existing `Surfaces/` documentation path is retained until Phase 7 determines whether a physical documentation-path rename is warranted. The canonical concept defined here is **Frame Surface**.

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

A **Frame Surface** is a named compositional region of the persistent authenticated Frame whose content is selected or contributed for the active Workspace and rendered through UI-owned shell infrastructure.

A Frame Surface defines one bounded composition contract:

- region identity and location;
- accepted contribution family;
- ordering and conflict rules;
- availability and filtering inputs;
- active-state inputs;
- fallback behavior;
- normalized output consumed by UI rendering.

A Frame Surface is not a source-of-truth application owner.

The initial Frame Surfaces are:

1. Global Header Navigation Surface;
2. Sidebar Navigation Surface.

The Main Content Outlet is not a Frame Surface. It renders route-owned Product Pages, workflows, and deeper content.

## 2. Classification Rule

A region qualifies as a Frame Surface only when:

- it is part of the persistent authenticated Frame rather than one Product Page;
- its content can vary by active Workspace, authorization, Module state, active Product, or accepted Contributions;
- one Core Host owns its composition Contract and resolved output;
- reusable UI owns rendering and interaction;
- Product owners and Contributors retain their behavior and declarations.

A Page, destination, Product Area, workflow, form, Blade view, Livewire class, controller, or Module overview is not a Frame Surface merely because it renders UI.

The lowercase visual-design word “surface” for backgrounds, layers, and token roles is unrelated and remains valid.

## 3. Owns

A Frame Surface composition contract may own:

- one canonical region identity;
- accepted Contribution types;
- ordering and collision rules;
- availability and filtering inputs;
- active-state inputs;
- fallback behavior;
- normalized resolved presentation data;
- composition-specific documentation and verification.

For the initial Navigation Frame Surfaces, Core Navigation owns the Extension Point Contracts, Registry, validation, ordering, current-state resolution, and fallback.

UI owns the reusable header, sidebar, navigation, menu, breadcrumb, responsive, focus, keyboard, and accessibility rendering APIs used to present the result.

## 4. Must Not Own

A Frame Surface must not own:

- Product behavior;
- Core or Module persistence;
- routes or request validation;
- route, Action, resource, or target authorization;
- Workspace identity or access;
- permission meaning or evaluation;
- Module lifecycle;
- Contributor implementation;
- reusable UI Components, Patterns, Layouts, CSS, or JavaScript;
- Main-content Page behavior;
- application-wide service location;
- arbitrary delivery or registration behavior;
- another owner’s Contribution.

A Frame Surface is not:

- a fourth application owner alongside Core, Modules, and UI;
- a generic `Surface/` or `Surfaces/` production folder;
- a Product, Product Area, Page, or flow;
- a Host Registry by itself;
- a route or invocation channel;
- a replacement for authorization.

## 5. Dependency Rules

The accepted direction is:

```text
Workspace scope and authoritative Core inputs
    + Contributor-owned declarations
    -> Host-owned Registry validation and resolution
    -> normalized Frame Surface output
    -> UI-owned rendering
```

Rules:

- Contributors depend only on the Host’s public Extension Point Contract.
- A Core Host must not depend on optional Contributor implementation.
- UI consumes normalized render data and must not import Core or Module implementation.
- Navigation visibility does not replace route or Action authorization.
- Application behavior must not depend on Frame rendering.
- Delivery Adapters may invoke public resolution and select an applicable response, but they do not own Frame Surface policy.
- Application Registration may validate and route declarations but does not replace the Host Registry.

## 6. Target Status

Status: permanent.

Frame Surface is a permanent architecture concept.

The following are not canonical target destinations:

```text
app/Surfaces/
app/Core/<Capability>/Surface/
Modules/<Module>/src/Surface/
```

Presentation-specific PHP uses a precise role such as `PageData/`, `ViewModels/`, `Presenters/`, `Renderers/`, `Data/`, `Queries/`, or `Navigation/` only when justified.

Existing `Surface`, `Shell`, `Platform`, or related identifiers may remain transitional only through an accepted compatibility record.

## 7. Accepted Decision

Status: accepted through ADR-0008 and Goal 3 Phase 6.

A User Account may access one or more Workspaces; one is active in a rendered context. The active Workspace supplies high-level Product scope. Core Navigation resolves Product and Product Area Contributions for the named Header and Sidebar Navigation Frame Surfaces. UI renders the result. Main remains a route-owned content outlet.

The earlier broad use of Surface for owner-specific Pages, destinations, areas, flows, or generic presentation folders is superseded.

The retained boundaries from the former definition remain operative:

- Frame Surface does not own behavior, persistence, authorization, delivery, Registry responsibility, Contribution ownership, or reusable UI;
- Host, Registry, Extension Point, Contribution, Contributor, Delivery Adapter, Core, Module, UI, and Laravel integration remain separate concepts;
- APIs, console commands, webhooks, queues, schedulers, and background entry points remain Delivery Adapters or Invocation Channels rather than Frame Surfaces.

## 8. Open Questions

The following implementation details remain deferred and do not change this definition:

- exact Product and Product Area Contribution schemas;
- exact ordering, conflict, availability, cache, and fallback APIs;
- exact Workspace switcher route, URL, session, persistence, and restoration behavior;
- exact UI shell Blade, CSS, JavaScript, responsive, and accessibility APIs;
- exact compatibility treatment and removal sequence for existing Surface identifiers;
- whether the `Definitions/Surfaces/` documentation path is later renamed;
- exact automated architecture, registration, browser, accessibility, and manual-review proof.

## 9. Related

- [Definitions Index](../Index.md)
- [ADR-0008](../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
- [Workspace Navigation And Frame Composition](../../../03-architecture/workspace-navigation-and-frame-composition.md)
- [Repository Architecture](../../../03-architecture/repository-architecture.md)
- [Host Definition](../Hosts/Definition.md)
- [Registry Definition](../Registries/Definition.md)
- [Contribution Definition](../Contributions/Definition.md)
- [Phase 2.90 Surface, Host, And Registry Reclassification](../../Milestones/milestone-0/goal-3/phase-2/2-90-surface-host-registry-reclassification.md)
- [Phase 6.90 Workspace, Navigation Hierarchy, And Frame Surface Clarification](../../Milestones/milestone-0/goal-3/phase-6/6-90-workspace-navigation-and-frame-surface-clarification.md)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
