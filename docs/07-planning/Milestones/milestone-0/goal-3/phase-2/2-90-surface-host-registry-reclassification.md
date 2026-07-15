<!--
DOC-META
title: Phase 2.90 Surface, Host, And Registry Reclassification
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/2-90-surface-host-registry-reclassification.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-2/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Corrects the earlier Surface classification by separating UI presentation from Host-owned Registry and contribution responsibilities.
-->

# Phase 2.90 Surface, Host, And Registry Reclassification

Parent: [Phase 2 Repository Organization Index](index.md)

## 1. Purpose

This document records a corrective Phase 2 decision separating UI presentation from extension Registry and contribution responsibilities.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 2 review
- Implementation state: documentation correction and target direction only
- Owning GitHub issue: #49
- Affected prior work: Phase 1 Surface definition and related planning language
- Required synchronization: pending

## 3. Problem

Earlier discussion used `Surface` for both:

1. UI presentation and interaction;
2. Host-owned extension points, Registry assembly, and contributions.

These responsibilities have different owners and must remain separate.

## 4. Accepted Terminology

| Concept | Responsibility |
| --- | --- |
| Host | Core capability or Module that owns an extensible feature |
| Registry | Host-owned mechanism that declares, validates, collects, orders, and exposes contributions |
| Extension Point | Named contract or insertion point exposed by the Registry |
| Contribution | Another owner’s declaration or implementation targeting a Host extension point |
| Contributor | Core capability or Module that owns and supplies a Contribution |
| Surface | Owner-specific UI presentation and interaction layer |
| UI | Reusable components, layouts, controls, and visual infrastructure used by Surfaces |

## 5. Surface

A Surface may own:

- owner-specific page composition;
- Surface-specific navigation;
- PageData;
- ViewModels;
- Surface-specific presenters;
- selection of UI-owned layouts and components;
- owner-specific interaction flow.

A Surface may consume resolved output from a Host Registry.

A Surface is not:

- a Registry;
- an extension point;
- a contribution mechanism;
- reusable UI infrastructure;
- a generic delivery owner;
- the owner of another capability’s behavior.

## 6. Host And Registry

A Host owns an extensible feature.

Its Registry may:

- define extension points;
- validate contributions;
- collect and order contributions;
- apply filtering and availability rules;
- expose the resolved result to the Host.

Every Registry requires one explicit Host.

A Registry must not become a generic service locator.

## 7. Contributor And Contribution

A Contributor retains ownership of the behavior it exposes.

The working organization is:

```text
Contrib/<Host>/
```

Example:

```text
Core/Preferences/Contrib/Settings/
Modules/Notifications/Contrib/Settings/
```

`Contrib/` contains owner-local declarations or implementations targeting extension points exposed by another Host.

Final casing, file naming, and contribution schema remain later decisions.

## 8. Settings Example

```text
Core/
└── Settings/
    ├── Registry/
    │   ├── Contracts/
    │   ├── ExtensionPoints/
    │   └── SettingsRegistry.php
    └── Surface/
        ├── Pages/
        ├── Navigation/
        └── ViewModels/
```

The Registry validates and resolves Settings contributions.

The Surface presents the Settings destination and renders resolved output through UI-owned layouts and components.

## 9. Corrected Relationship

```text
Contributor-owned behavior
    ↓
Contributor-owned Contrib/<Host>/
    ↓
Host-owned Registry
    ↓
Optional owner-specific Surface
    ↓
UI-owned reusable infrastructure
```

Registry, Surface, and Contribution may cooperate without sharing architectural identity.

## 10. Independence Rules

An owner may have:

- a Registry and a Surface;
- a Registry without a Surface;
- a Surface without a Registry;
- neither.

A background Host may expose a Registry without UI.

An isolated page may have a Surface without external contributions.

API, console, webhook, and background entry points are delivery adapters or channels, not Surfaces.

## 11. Required Surface Correction

The Surface definition must state:

> A Surface is a rendered UI presentation and interaction layer through which Core- or Module-owned behavior is presented. A Surface may consume assembled data from a Host Registry, but it is not itself the Registry, an extension point, or a contribution mechanism. UI owns reusable presentation infrastructure; the Surface owner owns Surface-specific composition; the applicable Core capability or Module owns the behavior being presented.

Planning and issue language that uses Surface to mean Host, Registry, extension boundary, or delivery channel must be reconciled.

This correction does not reopen Core, Module, UI, or Laravel ownership.

## 12. Accepted Host And Contribution Rule

> A Core capability or Module may act as a Host by exposing a Registry containing explicit extension points. Other owners contribute to that Host through owner-local `Contrib/<Host>/` integration. The Host Registry validates and assembles contributions. A separate optional Surface presents the assembled result through UI-owned reusable infrastructure.

## 13. Documentation Impact

Create or update definitions for:

- Surface;
- Host;
- Registry;
- Extension Point;
- Contribution;
- Contributor.

Update:

- the Phase 2 index;
- the Goal 3 target-architecture artifact;
- the existing Surface definition;
- affected Phase 1 summaries;
- later tree, placement, naming, and migration documents;
- stale planning or issue language.

## 14. Boundaries

This decision does not define:

- Registry implementation or discovery;
- contribution manifest schema;
- ordering algorithm;
- authorization implementation;
- final `Contrib/` naming;
- exact physical paths or namespaces.

Those concerns require later accepted planning.

## 15. Verification

Confirm that:

- Surface is used only for UI presentation and interaction;
- every Registry has one explicit Host;
- Contributions remain owned by their Contributors;
- `Contrib/<Host>/` targets a Host Registry;
- delivery channels are not classified as Surfaces;
- UI retains reusable presentation ownership;
- contradictory documentation is identified for synchronization.

## 16. Related

- [Phase 2 Repository Organization Index](index.md)
- [Phase 2.2 Secondary Organization Within Each Owner](2-2-secondary-organization-within-each-owner.md)
- [Phase 2.4 Delivery Code Organization](2-4-delivery-code-organization.md)
- GitHub issue: #49
