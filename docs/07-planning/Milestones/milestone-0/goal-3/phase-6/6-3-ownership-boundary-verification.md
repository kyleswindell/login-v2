<!--
DOC-META
title: Phase 6.3 Ownership Boundary Verification
doc_type: planning
status: active
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/6-3-ownership-boundary-verification.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Verifies ownership boundaries for Settings, Projects, Modal and Dialog, and the Sidebar Navigation Frame Surface.
-->

# Phase 6.3 Ownership Boundary Verification

Parent: [Phase 6 Representative Architecture Validation Index](index.md)

## 1. Purpose

Verify that each representative example has one clear owner for behavior, reusable presentation, delivery, persistence, and extensibility.

This document consumes:

- [Phase 6.1 Representative Example Selections](6-1-representative-example-selections.md);
- [Phase 6.2 Representative Example Mappings](6-2-representative-example-mappings.md);
- [Phase 6.90 Workspace, Navigation Hierarchy, And Frame Surface Clarification](6-90-workspace-navigation-and-frame-surface-clarification.md);
- accepted [ADR-0008](../../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md).

It verifies ownership only. Placement and naming remain Phase 6.5 authority.

## 2. Status

- Planning lifecycle: active
- Acceptance state: accepted through repository-owner Phase 6 review; final closeout remains pending canonical reconciliation, repository checks, and the Issue #53 Final Acceptance Record
- Implementation state: ownership validation only
- Owning GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Depends on: Phase 6.1, Phase 6.2, Phase 6.90, and accepted Goal 3 ownership rules
- Architecture dependency: Frame Surface terminology is governed by accepted ADR-0008

## 3. Ownership Rules

1. Core, Modules, and UI remain the only source-of-truth ownership areas.
2. Workspace, Frame Surface, Host, Registry, Contributor, and Delivery Adapter describe roles or composition boundaries, not additional owner types.
3. Each material responsibility has one primary owner.
4. A Host owns its extension Contract, Registry, acceptance rules, and resolved result.
5. A Contributor retains ownership of its declaration, linked behavior, state, and authorization requirements.
6. UI owns reusable rendering and interaction, not application behavior or authorization.
7. Delivery remains owner-local and delegates inward.
8. Persistence remains with the owner of the underlying state.
9. Navigation visibility is a resolved result and does not transfer authority to Core Navigation or UI.

## 4. Ownership Matrix

| Example                          | Behavior                                                                          | Reusable presentation | Delivery                                                    | Persistence     | Extensibility and consumers                                                                                  |
| -------------------------------- | --------------------------------------------------------------------------------- | --------------------- | ----------------------------------------------------------- | --------------- | ------------------------------------------------------------------------------------------------------------ |
| Settings                         | Settings Core capability                                                          | UI                    | Settings-owned HTTP and Console adapters                    | Settings        | Settings hosts its own settings Registry and contributes Product navigation to Core Navigation               |
| Projects                         | Projects Module                                                                   | UI                    | Projects-owned HTTP and Console adapters                    | Projects        | Projects contributes Product navigation; it is not a Host unless a later Contract creates an extension scope |
| Modal and Dialog                 | UI interaction contract                                                           | UI                    | Not applicable                                              | None            | Core capabilities and Modules consume the public UI contract                                                 |
| Sidebar Navigation Frame Surface | Core Navigation Host resolves navigation; active Workspace supplies Product scope | UI                    | Authenticated app layout and restricted Laravel composition | None inherently | Workspaces, Core capabilities, Modules, Access, and application registration provide bounded inputs          |

## 5. Settings Boundary

Settings owns:

- settings behavior, state, validation, and authorization requirements;
- Settings public Contracts, Actions, Queries, Policies, and persistence;
- the Settings Registry and its Extension Point Contracts;
- acceptance, ordering, and resolution of settings Contributions;
- Settings routes, delivery adapters, views, and Product navigation declaration.

Settings performs two separate roles:

```text
Settings as Host
    -> owns Settings Registry and resolved settings Contributions

Settings as Navigation Contributor
    -> contributes the Settings Product and Product Areas
```

Settings does not own:

- reusable Frame or sidebar rendering;
- Core Navigation Registry behavior;
- another Contributor’s settings behavior;
- role or permission evaluation infrastructure;
- the Workspace itself.

## 6. Projects Boundary

Projects owns:

- Project behavior, state, authorization requirements, and lifecycle;
- Projects routes, delivery adapters, views, assets, tests, and documentation;
- its B-level Product declaration and C-level Product Areas;
- any contextual eligibility rules specific to Projects.

Projects does not own:

- Core Navigation;
- Workspace composition;
- reusable UI;
- Core permission evaluation;
- another owner’s Models, tables, or internal implementation.

Projects is a Navigation Contributor. It is not treated as a Host merely because it is a Module.

## 7. Modal And Dialog Boundary

UI owns:

- reusable Modal and Dialog contracts;
- Blade composition;
- styling and interaction controls;
- focus, dismissal, keyboard, and accessibility behavior;
- artifact-local tests and standards.

Consumers own:

- the reason the Modal opens;
- submitted behavior and validation;
- authorization;
- persistence;
- route and workflow outcomes.

Modal and Dialog have no application persistence or delivery ownership.

## 8. Sidebar Navigation Frame Surface Boundary

### 8.1. Workspace Responsibility

An active System Workspace supplies the B-level Product navigation scope rendered through the Sidebar Navigation Frame Surface.

A Workspace owns:

- its Product inclusion policy;
- default Product;
- Workspace-specific grouping or ordering constraints;
- the set of Products eligible for navigation resolution.

Workspace composition does not own Product behavior, navigation rendering, or permission evaluation.

### 8.2. Core Navigation Host

Core Navigation acts as the Host for Sidebar and Header navigation extension points.

Core Navigation owns:

- Product and Product Area Contribution Contracts;
- Registry validation and rejection;
- ordering, conflict, and fallback rules;
- active Product and Product Area resolution;
- current-route matching;
- final resolved navigation output.

Core Navigation must remain valid with no optional Module Contributions and must not depend on Contributor implementation.

### 8.3. Contributor Responsibility

Each Product owner contributes:

- Product identity and label;
- destination route;
- active-route patterns;
- Product Area declarations;
- declared permission requirements;
- contextual eligibility inputs permitted by the Host Contract.

The Contribution remains owned by the Product owner. Registration does not transfer Product behavior or state to Core Navigation.

### 8.4. Access And Permission Responsibility

Ownership is divided as follows:

| Responsibility                               | Owner                                |
| -------------------------------------------- | ------------------------------------ |
| Meaning of a protected operation             | Applicable Core capability or Module |
| Permission requirement declared by a Product | Product behavior owner               |
| Permission evaluation                        | Access/Permissions Core capability   |
| Role and permission assignments              | Applicable Roles/Access owner        |
| Module installation and enablement           | Core Module lifecycle                |
| Workspace Product inclusion                  | Workspace composition                |
| Final navigation visibility resolution       | Core Navigation Host                 |
| Rendering                                    | UI                                   |

Final Product visibility is resolved from:

```text
Workspace inclusion
AND capability or Module availability
AND valid Product Contribution
AND available destination
AND permission evaluation
AND contributor-owned contextual eligibility
```

Core Navigation owns this resolution process but does not own the underlying authorities.

### 8.5. UI And Delivery Responsibility

UI owns reusable sidebar rendering, responsive behavior, disclosure, focus, keyboard behavior, and accessibility.

The authenticated app layout:

- receives active Workspace and route context;
- invokes Core Navigation resolution;
- passes resolved navigation data to UI;
- renders the Frame.

The layout is a restricted composition adapter. It does not own navigation policy, Product behavior, or UI internals.

## 9. Persistence Boundary

| State                              | Persistence owner                                                       |
| ---------------------------------- | ----------------------------------------------------------------------- |
| Settings values                    | Settings                                                                |
| Project records                    | Projects                                                                |
| Permission definitions             | Declared by the behavior owner and registered through Access            |
| Roles and permission assignments   | Applicable Roles/Access owner                                           |
| Module installation and enablement | Core Module lifecycle                                                   |
| Workspace access or availability   | Applicable Workspace and Access owner                                   |
| Product navigation Contributions   | Declarative owner metadata unless a later Contract requires persistence |
| User navigation preference         | Future Core Workspace or Preferences owner if supported                 |
| Modal and Dialog                   | None                                                                    |
| Frame Surface                      | None                                                                    |
| Registry cache or compiled output  | Derived infrastructure, not canonical business state                    |

The Navigation Registry must not query Contributor tables or persist Contributor-owned state.

## 10. Ownership Findings

| Example                          | Finding                                                                                                                                                       |
| -------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Settings                         | Clear Core ownership; Host and Contributor roles are bounded and compatible                                                                                   |
| Projects                         | Clear Module ownership; Navigation Contributor role does not transfer behavior                                                                                |
| Modal and Dialog                 | Clear UI ownership; no delivery or persistence ambiguity                                                                                                      |
| Sidebar Navigation Frame Surface | Clear split among Workspace scope, Core Navigation resolution, Contributor declarations, Access evaluation, UI rendering, and restricted delivery composition |

No representative example requires:

- a fourth ownership area;
- a generic `Surface/` owner;
- Core ownership of optional Module behavior;
- UI ownership of application behavior;
- shared persistence across owners;
- delivery ownership of application behavior.

## 11. Accepted Decision

> Settings retains ownership of settings behavior, state, delivery, and its settings Registry while contributing Product navigation to Core Navigation.
>
> Projects retains ownership of Project behavior, state, delivery, and Product navigation Contributions. It is not a Host unless a later accepted Contract creates a bounded extension scope.
>
> Modal and Dialog remain UI-owned reusable presentation and interaction artifacts.
>
> The active Workspace supplies the B-level Product scope for the Sidebar Navigation Frame Surface. Core Navigation owns the Host Contracts, Registry, resolution, ordering, active-state, and fallback behavior. Product owners retain their Contributions and linked behavior. Access evaluates permissions, UI renders the resolved result, and the authenticated app layout remains a restricted composition adapter.
>
> Persistence remains with the owner of each underlying state. Navigation visibility is resolved from authoritative owner inputs and does not transfer ownership to Core Navigation or UI.

## 12. Phase 6.4 Handoff

Phase 6.4 must verify that the dependencies implied by these ownership boundaries are permitted, including:

- Contributors depending only on Core Navigation public Contracts;
- Core Navigation remaining independent of optional Module implementation;
- UI consuming only resolved presentation data;
- delivery adapters delegating inward;
- Access evaluating permissions without absorbing Product behavior;
- no cross-owner Model, table, or internal implementation access.

## 13. Related

- [Phase 6 Representative Architecture Validation Index](index.md)
- [Phase 6.1 Representative Example Selections](6-1-representative-example-selections.md)
- [Phase 6.2 Representative Example Mappings](6-2-representative-example-mappings.md)
- [Phase 6.90 Workspace, Navigation Hierarchy, And Frame Surface Clarification](6-90-workspace-navigation-and-frame-surface-clarification.md)
- [ADR-0008: Workspace, Navigation Hierarchy, And Frame Surface Model](../../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
- [Workspace Navigation And Frame Composition](../../../../../03-architecture/workspace-navigation-and-frame-composition.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Phase 4 Dependency And Communication Matrix](../phase-4/dependency-and-communication-matrix.md)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)