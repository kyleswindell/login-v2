<!--
DOC-META
title: Phase 6.4 Dependency Direction Verification
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/6-4-dependency-direction-verification.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Verifies that the four representative examples use permitted public Contracts, Contributions, delivery boundaries, UI dependencies, and persistence access.
-->

# Phase 6.4 Dependency Direction Verification

Parent: [Phase 6 Representative Architecture Validation Index](index.md)

## 1. Purpose

Verify that the ownership boundaries accepted in [Phase 6.3](6-3-ownership-boundary-verification.md) can operate without prohibited imports, optional-Module requirements, delivery inversion, UI-to-application coupling, or cross-owner persistence access.

## 2. Status

- Planning lifecycle: draft
- Acceptance state: proposed for repository-owner Phase 6 review
- Implementation state: dependency validation only
- Owning GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Depends on: Phase 6.3 and accepted Goal 3 dependency rules
- Provisional dependency: Frame Surface terminology remains subject to ADR-0008 acceptance

## 3. Required Dependency Matrix

| Consumer                          | Provider                                                                      | Permitted boundary                                                  | Result     |
| --------------------------------- | ----------------------------------------------------------------------------- | ------------------------------------------------------------------- | ---------- |
| Settings                          | Core Navigation                                                               | Navigation Extension Point Contract                                 | Allowed    |
| Projects                          | Core Navigation                                                               | Navigation Extension Point Contract                                 | Allowed    |
| Settings or Projects              | Access/Permissions                                                            | Permission declaration Contract                                     | Allowed    |
| Core Navigation                   | Workspace composition                                                         | Public Workspace Contract or resolved Data Object                   | Allowed    |
| Core Navigation                   | Access/Permissions                                                            | Public permission-evaluation Contract                               | Allowed    |
| Core Navigation                   | Module lifecycle                                                              | Public availability Query or resolved Data Object                   | Allowed    |
| Core Navigation Registry          | Product Contributors                                                          | Validated Contribution values only                                  | Allowed    |
| Settings Registry                 | Settings Contributors                                                         | Validated settings Contribution values only                         | Allowed    |
| Settings or Projects presentation | UI                                                                            | Published UI Component, Pattern, Layout, and asset APIs             | Allowed    |
| Delivery Adapter                  | Its owning behavior                                                           | Owner-local Actions, Queries, Policies, Contracts, and Data Objects | Allowed    |
| Authenticated composition adapter | Workspace, Core Navigation, and UI                                            | Public Contracts and UI render data                                 | Allowed    |
| UI                                | Core or Module implementation                                                 | None                                                                | Prohibited |
| Core                              | Optional Projects implementation                                              | None                                                                | Prohibited |
| Any owner                         | Another owner’s Models, tables, repositories, or internal configuration state | None                                                                | Prohibited |

## 4. Navigation Resolution Chain

```text
Workspace composition
    -> active Workspace and eligible Product scope

Product owners
    -> owner-local Contributions targeting Core Navigation Contracts

Access and Module lifecycle
    -> authoritative permission and availability results

Core Navigation
    -> validates and resolves navigation

Authenticated composition adapter
    -> maps resolved output to UI render data

UI
    -> renders Frame navigation
```

Rules:

- Core Navigation must not import Contributor implementation.
- Contribution registration does not prove that an optional Module is active for the current Instance.
- Navigation visibility does not replace route or Action authorization.
- Workspace composition and Core Navigation may depend on one another only through an accepted acyclic public boundary; the composition adapter may invoke both in sequence.

## 5. Settings Host Chain

```text
Settings Contributor
    -> Settings Extension Point Contract

Application registration
    -> routes validated declarations

Settings Registry
    -> validates and resolves Contributions
```

Settings must remain operational without optional Module Contributions. Its Registry must not import Contributor implementation, persistence, or authorization policy.

## 6. UI And Delivery Boundaries

UI may consume normalized render data and expose interaction events or callbacks. It must not depend on Workspace, Navigation, Settings, Projects, Access, route, or persistence implementation.

Settings and Projects delivery adapters depend inward on their own behavior. Application behavior must not depend outward on controllers, requests, routes, layouts, views, or protocol resources.

The authenticated app layout is a restricted composition adapter. It may invoke public Workspace and Navigation Contracts and pass normalized data to UI, but it does not own resolution or rendering rules.

## 7. Prohibited Edges

```text
Core -> optional Projects implementation
Core Navigation -> Contributor internals
Contributor -> Host Registry implementation
UI -> Core or Module implementation
Owner behavior -> Delivery Adapter
Any owner -> another owner’s Models or tables
Registration infrastructure -> owner behavior
Owner behavior -> registration compiler or compiled manifest
```

## 8. Findings

- All representative interactions fit the accepted public Contract, Contribution, Query, UI, and delivery rules.
- No Module-to-Module dependency is required.
- No dependency exception is required.
- The earlier broad Surface terminology requires reconciliation, but the underlying dependency inversion remains valid.

## 9. Proposed Decision

> The representative examples use permitted dependency direction. Settings and Projects depend on Core Navigation and Access through public Contracts. Core Navigation consumes validated Contributions and authoritative Core results without importing optional Module implementation. UI consumes normalized render data only. Delivery adapters depend inward on their owning behavior, and no owner accesses another owner’s persistence internals.
>
> No dependency exception or new communication mechanism is required.

## 10. Phase 6.5 Handoff

Phase 6.5 must confirm that each accepted boundary has one predictable physical location, namespace, and naming family without introducing generic ownership folders or unnecessary nesting.

## 11. Related

- [Phase 6.2 Representative Example Mappings](6-2-representative-example-mappings.md)
- [Phase 6.3 Ownership Boundary Verification](6-3-ownership-boundary-verification.md)
- [Phase 6.90 Workspace, Navigation Hierarchy, And Frame Surface Clarification](6-90-workspace-navigation-and-frame-surface-clarification.md)
- [Phase 4 Dependency And Communication Matrix](../phase-4/dependency-and-communication-matrix.md)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
