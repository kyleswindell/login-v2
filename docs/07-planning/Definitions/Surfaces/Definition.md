<!--
DOC-META
title: Surface Definition
doc_type: definition
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Surfaces/Definition.md
parent: docs/07-planning/Definitions/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a Surface as an owner-specific UI presentation and interaction layer through which Core- or Module-owned behavior is presented.
-->

# Surface Definition

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

A Surface is an owner-specific UI presentation and interaction layer through which Core- or Module-owned application behavior is presented to a user or operator.

A Surface provides a coherent interface context, such as a page, destination, area, or multi-step interaction flow.

The applicable Core capability or Module owns the behavior being presented. UI owns the reusable presentation infrastructure used to render the Surface.

A Surface may consume resolved output from a Host-owned Registry, but it is not itself:

* the Host;
* the Registry;
* an extension point;
* a contribution mechanism;
* a delivery channel;
* a source-of-truth application owner.

## 2. Classification Rule

An interface qualifies as a Surface when it provides:

* a recognizable UI destination or interaction context;
* a defined user or operator audience;
* a coherent presentation and interaction model;
* owner-specific composition of behavior or content;
* presentation through UI-owned reusable layouts, components, patterns, Elements, or controls.

A Surface may span multiple routes, views, sections, or interaction steps when they form one coherent UI experience.

A single route, Blade view, controller, component, layout, or form is not automatically a Surface.

The following are not Surfaces:

* APIs;
* console commands;
* webhooks;
* background jobs;
* queue consumers;
* scheduled processes;
* other non-UI invocation channels.

Those are delivery adapters or channels and are classified separately.

A capability or Module may have:

* a Surface and a Registry;
* a Surface without a Registry;
* a Registry without a Surface;
* neither.

The presence of one does not imply the presence or ownership of the other.

## 3. Owns

A Surface may own:

* owner-specific page and interaction composition;
* Surface-specific navigation composition;
* presentation of owner-controlled application behavior;
* Surface-specific PageData;
* Surface-specific ViewModels;
* Surface-specific presenters or renderers;
* selection and arrangement of UI-owned layouts and components;
* interaction flow within the Surface;
* presentation of resolved Host Registry output;
* Surface-specific documentation;
* Surface-specific browser, accessibility, and manual-review requirements.

Examples may include:

* the authenticated Dashboard Surface;
* the Settings Surface;
* the Account Surface;
* the Global Administration Surface;
* an owner-specific setup or onboarding Surface.

The presence of a Surface does not transfer ownership of the presented behavior from its Core capability or Module.

## 4. Must Not Own

A Surface must not own:

* authoritative business or system behavior;
* Core or Module state;
* persistence rules;
* authoritative authorization policy;
* reusable UI infrastructure;
* application-wide UI Elements, Components, Patterns, Layouts, tokens, or controls;
* Host Registry contracts;
* extension-point definitions;
* contribution discovery;
* contribution validation;
* contribution ordering or resolution;
* another owner’s contributed behavior;
* Module lifecycle or discovery;
* HTTP request validation;
* route invocation;
* API response policy;
* console input handling;
* webhook transport handling;
* behavior solely because it is visible through the Surface;
* another owner’s internal implementation.

A Surface is not:

* a fourth application ownership area alongside Core, Modules, and UI;
* automatically a top-level repository branch;
* synonymous with a Host;
* synonymous with a Registry;
* synonymous with a route or Blade view;
* synonymous with an invocation channel;
* a substitute for Core, Module, UI, or Laravel integration ownership.

## 5. Dependency Rules

A Surface:

* remains owned by the Core capability or Module whose UI presentation it composes;
* may invoke owner-controlled Actions, Queries, workflows, and public contracts;
* may depend on UI-owned reusable presentation contracts and infrastructure;
* may consume resolved output from a Registry owned by the same Host;
* may present contributions supplied by other owners after they have been validated and resolved by the Host Registry;
* may receive transport-neutral data from an applicable delivery adapter;
* must not access another owner’s internal implementation;
* must not discover, validate, order, or resolve contributions independently of the Host Registry;
* must not move authoritative behavior into presentation code;
* must preserve authorization and lifecycle rules defined by the behavior owner;
* must remain independent of HTTP, API, console, webhook, or other transport-specific policy.

Core or Module domain and system behavior must not depend on Surface implementation.

UI-owned reusable infrastructure must not depend on a capability- or Module-specific Surface.

Delivery adapters may invoke owner behavior and select an applicable Surface response, but delivery code and Surface presentation remain separate responsibilities.

## 6. Target Status

Status: permanent

Surface is a permanent architecture concept representing owner-specific UI presentation and interaction.

Surface is not a permanent source-of-truth ownership area alongside Core, Modules, and UI.

The working technical-role vocabulary may represent Surface-specific code beneath:

```text
Surface/
```

The exact physical placement, namespace, internal subfolders, and naming rules remain owned by later Goal 3 repository-tree, placement, and naming decisions.

API, console, webhook, queue, scheduler, and background entry points are permanently excluded from the Surface definition and remain delivery adapters or invocation channels.

The previous use of Surface as a general assembled interaction boundary or extension Registry is superseded.

## 7. Accepted Decision

Status: accepted

A Surface is an owner-specific UI presentation and interaction layer through which Core- or Module-owned behavior is presented.

The Surface owner controls Surface-specific composition, presentation data, navigation composition, and interaction flow. UI controls the reusable presentation infrastructure used by the Surface. The applicable Core capability or Module retains ownership of the behavior, state, contracts, authorization, persistence, and lifecycle being presented.

A Host may expose a Registry containing explicit extension points. Other owners may supply Contributions through their own contribution integration. The Host Registry validates and resolves those Contributions. A separate Surface may then present the resolved result.

The accepted relationship is:

```text
Contributor-owned behavior
    ↓
Contributor-owned contribution
    ↓
Host-owned Registry
    ↓
Optional owner-specific Surface
    ↓
UI-owned reusable presentation infrastructure
```

This decision corrects the earlier definition of Surface as an assembled interaction boundary that could include APIs, console commands, webhooks, or Registry responsibilities.

It does not reopen the accepted Core, Module, UI, Laravel integration, or transitional `app/Platform` boundaries.

## 8. Open Questions

No open question remains about the architectural meaning of Surface.

The following implementation details remain deferred and do not change this definition:

* exact physical placement of Surface-specific artifacts;
* exact Surface namespace conventions;
* exact internal organization of Pages, PageData, ViewModels, presenters, and navigation composition;
* criteria for when a capability or Module requires a dedicated `Surface/` role;
* final naming and casing conventions;
* exact browser, accessibility, and manual-review proof required for each Surface.

These decisions belong to later Goal 3 phases and applicable capability or Module contracts.

## 9. Related

* [Definitions Index](../Index.md)
* [Goal 3 Target Repository Architecture](../../Milestones/milestone-0/goal-3/target-repository-architecture.md)
* [Phase 2 Repository Organization Index](../../Milestones/milestone-0/goal-3/phase-2/index.md)
* [Phase 2.90 Surface, Host, And Registry Reclassification](../../Milestones/milestone-0/goal-3/phase-2/2-90-surface-host-registry-reclassification.md)
* [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
* [ADR-0006: Tenant, Instance, Workspace, Principal, And Invocation Vocabulary](../../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
* [ADR-0007: Owner, Registry, And Identifier Key Conventions](../../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
* Related GitHub issue: #48
* Corrective planning issue: #49
