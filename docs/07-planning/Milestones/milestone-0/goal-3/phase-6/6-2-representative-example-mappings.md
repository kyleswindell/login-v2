<!--
DOC-META
title: Phase 6.2 Representative Example Mappings
doc_type: planning
status: active
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/6-2-representative-example-mappings.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Maps the Settings Core capability, Projects Module, Modal and Dialog UI bundle, and Sidebar Navigation Frame Surface to their target ownership, placement, registration, test, and documentation boundaries.
-->

# Phase 6.2 Representative Example Mappings

Parent: [Phase 6 Representative Architecture Validation Index](index.md)

## 1. Purpose

Map the four Phase 6 representative examples to target owners, locations, registration boundaries, dependencies, tests, and documentation.

This mapping applies the accepted Goal 3 architecture and the bounded correction recorded by [Phase 6.90](6-90-workspace-navigation-and-frame-surface-clarification.md) and [ADR-0008](../../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md).

## 2. Status

- Planning lifecycle: active
- Acceptance state: accepted through repository-owner Phase 6 review; final closeout remains pending canonical reconciliation, repository checks, and the Issue #53 Final Acceptance Record
- Implementation state: target mapping only
- Owning GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Depends on: [Phase 6.1 Representative Example Selections](6-1-representative-example-selections.md), Phase 6.90, and accepted Goal 3 Phases 1 through 5
- Selected examples: Settings, Projects, Modal and Dialog, Sidebar Navigation Frame Surface

## 3. Mapping Rules

1. Identify the owner before the Technical Role or path.
2. Use sparse owner-local roles; do not create empty structural folders.
3. Treat current placement as evidence, not target authority.
4. Register behavior through explicit owner declarations rather than filesystem discovery.
5. Keep package-local documentation subordinate to canonical repository documentation.
6. Do not use generic `Surface/`, `Surfaces/`, `Services/`, `Shared/`, or `Platform/` target folders.
7. Use `Frame Surface` only for named compositional regions of the persistent Frame.

## 4. Representative Mapping Summary

| Example                          | Classification                                   | Primary owner                    | Target result                                                               |
| -------------------------------- | ------------------------------------------------ | -------------------------------- | --------------------------------------------------------------------------- |
| Settings                         | Required Core capability and B-class Product     | Settings                         | Core-owned behavior, state, delivery, presentation, and Settings Registry   |
| Projects                         | Optional Module and B-class Product              | Projects Module                  | Independently packaged, package-local capability                            |
| Modal and Dialog                 | Reusable UI Component family                     | UI                               | Artifact-owned Blade, contract, assets, tests, and standards                |
| Sidebar Navigation Frame Surface | Frame composition and navigation extension point | Core Navigation Host; UI renders | Host-owned resolution of owner-local Product and Product Area Contributions |

## 5. Settings Core Capability

### 5.1. Identity

| Representation               | Target                           |
| ---------------------------- | -------------------------------- |
| Capability                   | Settings                         |
| Owner key                    | `settings`                       |
| PHP root                     | `app/Core/Settings/`             |
| Namespace                    | `App\Core\Settings\`             |
| Route and configuration root | `settings.*`                     |
| Database lifecycle           | `database/core/settings/`        |
| Views                        | `resources/views/core/settings/` |

The current `Modules/Settings/` location is transitional.

### 5.2. Artifact Mapping

| Concern                   | Target                                                                                                                     | Boundary                                                                             |
| ------------------------- | -------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------ |
| Public behavior           | `Contracts/`, `Actions/`, `Queries/`, and `Data/` beneath `app/Core/Settings/`                                             | Cross-owner use requires Settings-owned public Contracts                             |
| State and policy          | `Models/` and `Policies/`                                                                                                  | Consumers must not access Models or persistence directly                             |
| Settings extension model  | Settings-owned `Contracts/` and `Registry/`; contributor-owned `Contrib/Settings/`                                         | Settings validates and resolves Contributions without absorbing contributor behavior |
| Delivery and registration | `Http/`, `routes/`, optional `Providers/`, and owner registration                                                          | Delivery delegates inward and does not own Settings behavior                         |
| Configuration             | `app/Core/Settings/config/settings.php`                                                                                    | Deployment configuration remains separate from persisted runtime settings            |
| Database lifecycle        | `database/core/settings/{migrations,factories,seeders}/` as required                                                       | Goal 6 owns detailed schema                                                          |
| Product presentation      | `resources/views/core/settings/` and precise owner-local PageData, ViewModel, Presenter, or Navigation roles when required | Settings is a Product in the Default Workspace, not a Workspace or generic Surface   |
| Sidebar contribution      | `app/Core/Settings/Contrib/<FrameNavigationHost>/`                                                                         | Declares the Settings Product and Product Areas through the Host contract            |
| Tests                     | `app/Core/Settings/__tests__/`; cross-owner and browser proof in `tests/`                                                  | Each test is discovered once                                                         |
| Documentation             | Applicable architecture, feature, flow, database, planning, and runbook branches                                           | No package-local document replaces canonical truth                                   |

### 5.3. Result

Settings fits as a required Core capability and Product without a `Surface/` Technical Role or structural exception.

## 6. Projects Module

### 6.1. Identity

| Representation               | Target                                             |
| ---------------------------- | -------------------------------------------------- |
| Display name and key         | `Projects`; `projects`                             |
| Package root                 | `Modules/Projects/`                                |
| Namespace                    | `Parasolutions\Modules\Projects\` mapped to `src/` |
| Composer package             | `parasolutions/module-projects`                    |
| Route and configuration root | `projects.*`                                       |
| Definition                   | `ProjectsModuleDefinition`                         |

### 6.2. Artifact Mapping

| Concern              | Target                                                                                                            | Boundary                                                                         |
| -------------------- | ----------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------- |
| Package declaration  | `composer.json`, `src/Definition.php`, and `README.md`                                                            | Definition is declarative; Composer owns package loading                         |
| Public behavior      | `src/Contracts/`, `Actions/`, `Queries/`, and `Data/`                                                             | Other owners depend on public Contracts, not concrete implementation             |
| State and policy     | `src/Models/` and `Policies/`                                                                                     | Models and tables remain package-internal                                        |
| Optional roles       | Owner-local `Events/`, `Listeners/`, `Jobs/`, `Notifications/`, `Registry/`, or `Providers/` only when required   | Sparse roles; no generic coordination layer                                      |
| Delivery             | `src/Http/`, optional `Console/`, and `routes/`                                                                   | Root routes and delivery folders do not own Projects behavior                    |
| Configuration        | `config/projects.php`                                                                                             | Environment inputs map through configuration                                     |
| Database lifecycle   | `database/{migrations,factories,seeders}/` as required                                                            | Package-local; Goal 6 owns detailed schema                                       |
| Product presentation | `resources/views/`, package assets, and precise PageData, ViewModel, Presenter, or Navigation roles when required | Projects is a Product, not a Workspace or Frame Surface                          |
| Sidebar contribution | `src/Contrib/<FrameNavigationHost>/`                                                                              | Declares the Projects Product and Product Areas through the Host contract        |
| Tests                | `tests/`                                                                                                          | Package-aware deterministic discovery                                            |
| Documentation        | `README.md`, package `docs/`, and applicable canonical repository branches                                        | Package docs explain Projects without becoming repository architecture authority |

### 6.3. Result

Projects fits as an independently managed optional Module and Product. No `src/Surface/` folder is required.

## 7. Modal And Dialog UI Bundle

### 7.1. Target Bundles

```text
resources/views/components/ui/modal/
resources/views/components/ui/dialog/
```

### 7.2. Artifact Mapping

| Concern                | Target                                                                        | Boundary                                                          |
| ---------------------- | ----------------------------------------------------------------------------- | ----------------------------------------------------------------- |
| Blade and contract     | Artifact-local implementation and `contract.php`                              | Reusable presentation only                                        |
| CSS and JavaScript     | Colocated within the owning artifact bundle                                   | Deterministic ordered composition; no parallel unowned asset tree |
| Partials and internals | Colocated bounded support inside the owning bundle                            | Must not become global support                                    |
| Tests                  | Artifact-local `__tests__/`; root tests only for genuine cross-artifact proof | Contract, rendering, interaction, and accessibility               |
| Standards and evidence | Applicable UI Component standards and rendered evidence                       | Documentation and examples do not replace contracts or tests      |

Modal and Dialog do not own routes, authorization, persistence, feature configuration, or application behavior. Any current dependency on `App\Surfaces` is transitional and must not become target authority.

### 7.3. Result

The UI bundle fits without structural exception.

## 8. Sidebar Navigation Frame Surface

### 8.1. Identity And Ownership

The Sidebar Navigation Frame Surface is a named region of the persistent Frame. It renders navigation resolved for the active Workspace and Product.

Ownership is divided deliberately:

- the Core Navigation Host owns the Surface Contracts, Registry, resolution, ordering, fallback, and active-state model;
- each Core capability or Module owns its Product and Product Area Contributions;
- Access and the applicable behavior owner retain authorization;
- UI owns reusable sidebar rendering and interaction;
- Phase 6.5 resolves the Host identity as the Core Navigation capability at `app/Core/Navigation/` with namespace `App\Core\Navigation\`.

It is not owned by Projects or Settings and does not justify an owner-local `Surface/` folder.

### 8.2. Artifact Mapping

| Concern                                  | Owner and target                                                                                 | Boundary                                                                                     |
| ---------------------------------------- | ------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------- |
| Frame Surface and Contribution Contracts | Core Navigation, in its public `Contracts/` role                                                 | Defines accepted Product and Product Area declarations without exposing Host internals       |
| Registry and resolver                    | Core Navigation, in `Registry/` and precise resolution roles                                     | Validates, filters, orders, selects, and exposes resolved navigation                         |
| Workspace composition input              | Applicable Workspace owner and Core composition                                                  | Determines the available Product set; Workspace selection does not grant authorization       |
| Product Contributions                    | Owner-local `Contrib/<FrameNavigationHost>/`                                                     | Contributors retain identity, labels, routes, active patterns, and Product Area declarations |
| Authorization filtering                  | Access and the destination behavior owner                                                        | Hiding or showing a link does not replace route authorization                                |
| Rendering                                | UI shell and Navigation Pattern implementation                                                   | UI consumes resolved data and must not inspect owner implementation                          |
| Tests                                    | Host-local contract and resolver tests; UI-local rendering tests; root cross-owner/browser tests | Proves resolution, active state, accessibility, fallback, and isolation                      |
| Documentation                            | Workspace/Frame architecture and Navigation/UI-shell standards                                   | Phase 6 defers updates to existing canonical files until final reconciliation                |

### 8.3. Navigation Model

| Class | Term         | Sidebar treatment                                             |
| ----- | ------------ | ------------------------------------------------------------- |
| A     | System       | Not rendered in the sidebar; belongs in Global Actions        |
| B     | Product      | Persistent authorized Product entries                         |
| C     | Product Area | One visible nested level for the active Product               |
| D     | Page         | Main content and breadcrumbs, not persistent shell navigation |
| E+    | Drill-down   | Page-local or contextual navigation only                      |

The Home Product is active by default in the Default Workspace. Navigating to Settings or Projects activates that Product and reveals its Product Areas while retaining access to sibling Products.

### 8.4. Result

The Sidebar Navigation Frame Surface fits the accepted Frame model. Phase 6.5 resolves the Host as Core Navigation at `app/Core/Navigation/`; this does not authorize `app/Surfaces/` or another generic owner.

## 9. Dependency And Registration Summary

Permitted direction:

```text
Settings or Projects
    -> Frame navigation public Contract
    -> owner-local Product Contribution

Core Navigation Host
    -> validated Contribution declarations
    -> resolved navigation data

UI
    -> resolved navigation data
    -> reusable shell rendering
```

Prohibited direction:

```text
Core Navigation Host -X-> Projects or Settings implementation
UI -X-> Core or Module implementation
Contributor -X-> Host Registry internals
Frame Surface -X-> Product behavior, persistence, or authorization ownership
Core -X-> optional Projects implementation
```

Settings, Projects, and UI declare their registrable artifacts. The application-registration process validates and composes those declarations without request-time filesystem scanning.

## 10. Later-Owner Boundaries

This mapping does not decide:

- the final Core capability name or path owning Frame navigation;
- Workspace selection storage or URL behavior;
- exact Contribution schemas and resolver classes;
- detailed Settings or Projects schemas;
- complete Product and Product Area inventories;
- exact Blade, Livewire, JavaScript, or responsive APIs;
- physical migration or compatibility aliases;
- final canonical-document reconciliation.

## 11. Accepted Decision

> Settings maps to a required Core capability and Product. Projects maps to an optional independently managed Module and Product. Modal and Dialog map to artifact-owned reusable UI bundles. Sidebar Navigation maps to a Host-owned Frame Surface rendered by UI from owner-local Product Contributions.
>
> The examples require no Projects- or Settings-owned `Surface/` role, no generic Surface owner, and no dependency from Core or UI to optional Module implementation.
>
> Phase 6.5 resolves the Sidebar Navigation Host as Core Navigation at `app/Core/Navigation/`, using namespace `App\Core\Navigation\` and the `navigation` key family.

## 12. Phase 6 Handoff

- Phase 6.3 verifies the ownership boundaries recorded here.
- Phase 6.4 verifies dependency direction.
- Phase 6.5 validates and records the Core Navigation Host identity, placement, and naming.
- Phases 6.6 and 6.7 define future proofs and guardrails.
- Phase 6.8 records fit, exceptions, corrections, and later-owner decisions.

## 13. Related

- [Phase 6 Representative Architecture Validation Index](index.md)
- [Phase 6.1 Representative Example Selections](6-1-representative-example-selections.md)
- [Phase 6.90 Workspace, Navigation Hierarchy, And Frame Surface Clarification](6-90-workspace-navigation-and-frame-surface-clarification.md)
- [ADR-0008: Workspace, Navigation Hierarchy, And Frame Surface Model](../../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
- [Workspace Navigation And Frame Composition](../../../../../03-architecture/workspace-navigation-and-frame-composition.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Phase 4 Artifact Placement Matrix](../phase-4/artifact-placement-matrix.md)
- [Phase 4 Dependency And Communication Matrix](../phase-4/dependency-and-communication-matrix.md)
- [Phase 5 Naming Conventions Index](../phase-5/index.md)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)