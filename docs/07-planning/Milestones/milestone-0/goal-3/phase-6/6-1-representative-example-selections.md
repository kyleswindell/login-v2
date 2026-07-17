<!--
DOC-META
title: Phase 6.1 Representative Example Selections
doc_type: planning
status: active
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/6-1-representative-example-selections.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Selects the Settings Core capability, Projects Module, Modal and Dialog UI bundle, and Sidebar Navigation Frame Surface as the four representative examples used to validate the Goal 3 repository architecture.
-->

# Phase 6.1 Representative Example Selections

Parent: [Phase 6 Representative Architecture Validation Index](index.md)

## 1. Purpose

Select one representative example for each architecture area required by Goal 3 Phase 6:

- one required Core capability;
- one optional Module;
- one reusable UI responsibility;
- one Frame Surface and its composition model.

The examples must be substantial enough to validate ownership, placement, dependency direction, naming, registration, tests, and documentation without expanding Phase 6 into implementation or migration planning.

## 2. Status

- Planning lifecycle: active
- Selection state: accepted through repository-owner Phase 6 review
- Final Phase 6 acceptance: pending documentation reconciliation
- Implementation state: target validation only
- Owning GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Depends on: accepted Goal 3 Phases 1 through 5 and the bounded clarification recorded by Phase 6.90
- Downstream decision: Phase 6.2 maps each selected example

## 3. Selection Requirements

Each selected example must:

1. represent one required Phase 6 architecture area;
2. have a clear accepted owner or composition boundary;
3. exercise multiple material artifact families;
4. expose meaningful placement and dependency questions;
5. use accepted Goal 3 naming rules;
6. be realistic enough to inform later refactor and implementation issues;
7. fit the accepted architecture without inventing unnecessary structural rules;
8. remain representative rather than exhaustive;
9. distinguish current implementation evidence from target authority;
10. avoid making product, schema, migration, or implementation decisions owned elsewhere.

A selected example does not need to be fully implemented in its target form.

Current physical placement may provide evidence, but it does not establish target ownership or placement.

## 4. Selected Examples

| Architecture area          | Selected example                  | Target classification                                     | Primary validation value                                                                                                                                                |
| -------------------------- | --------------------------------- | --------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Required Core capability   | Settings                          | Required Core capability and B-level Product              | Exercises required behavior, configuration, runtime state, authorization, registration, presentation, Host Registry ownership, and Product navigation contribution      |
| Optional Module            | Projects                          | Optional independently managed Module and B-level Product | Exercises Module identity, package-local ownership, declared dependencies, persistence, routes, tests, documentation, presentation, and optional lifecycle              |
| Reusable UI responsibility | Modal and Dialog Component bundle | UI-owned reusable Component family                        | Exercises Blade contracts, CSS, JavaScript, accessibility, deterministic asset composition, targeted tests, and reusable consumption                                    |
| Frame composition          | Sidebar Navigation Frame Surface  | Core Navigation-hosted Frame Surface rendered by UI       | Exercises Workspace Product scope, Product and Product Area Contributions, permission and Module availability inputs, active navigation resolution, and shell rendering |

## 5. Settings Core Capability

### 5.1. Selection Rationale

Settings is selected as the representative required Core capability because the base application requires authoritative configuration and runtime setting behavior regardless of which optional Modules are installed.

It can exercise applicable:

- public Contracts;
- Actions and Queries;
- Data Objects;
- Models and persistence;
- Policies and authorization;
- Host Registry and Extension Point responsibilities;
- routes and HTTP delivery;
- owner-local configuration;
- Core database lifecycle artifacts;
- Core-owned Product presentation;
- Product and Product Area navigation Contributions;
- tests;
- canonical documentation.

Settings also provides a useful boundary between:

- Laravel deployment configuration;
- persisted runtime settings;
- User preferences;
- Module-owned settings Contributions;
- secrets and environment inputs.

### 5.2. Classification Boundary

Settings is a Core capability because:

- required application behavior depends on it;
- Core must remain valid without optional Modules;
- Modules may consume Settings public Contracts or contribute through accepted Settings Extension Points;
- Settings retains authority over its Registry, validation, persistence, and resolution rules;
- a Module does not become the Settings owner merely because it provides Module-specific settings.

Settings is also a Navigation Contributor because it declares the Settings Product and Product Areas through Core Navigation’s public Extension Point Contract.

Current implementation beneath `Modules/Settings/` is transitional evidence and does not establish target Module ownership.

### 5.3. Validation Value

Settings tests whether the accepted model can distinguish:

- Core-owned configuration from root Laravel configuration;
- persisted settings from configuration files;
- Host-owned Registry behavior from Contributor-owned Contributions;
- Settings behavior from HTTP delivery and Product presentation;
- Settings Registry ownership from Core Navigation Host ownership;
- Core schema ownership from Goal 6 detailed database authority.

## 6. Projects Module

### 6.1. Selection Rationale

Projects is selected as the representative optional Module because it is a cohesive business capability that can be installed, enabled, assigned, updated, disabled, or omitted without invalidating required Core behavior.

It is substantial enough to exercise applicable:

- Module identity;
- Composer package ownership;
- package-local source;
- public Contracts;
- Actions and Queries;
- Data Objects and Models;
- Policies;
- Events, Listeners, Jobs, or Notifications;
- HTTP and Console Delivery Adapters;
- Module routes;
- Module configuration;
- Module database lifecycle;
- Module-owned presentation;
- Product and Product Area navigation Contributions;
- Module tests;
- Module documentation;
- dependencies on Core and UI.

### 6.2. Accepted Representative Identity

The representative Projects identity is:

```text
Display name:        Projects
module_key:          projects
Package root:        Modules/Projects/
PHP namespace:       Parasolutions\Modules\Projects\
Composer package:    parasolutions/module-projects
Route-name root:     projects.*
Configuration root:  projects.*
Documentation title: Projects Module
Formal definition:   ProjectsModuleDefinition
```

These representations are related but remain separate naming families.

The selection of Projects for Phase 6 validates the accepted Module identity model. It does not implement the package, select its complete product scope, define its schema, or authorize migration.

### 6.3. Classification Boundary

Projects is Module-owned because:

- it represents optional cohesive feature behavior;
- Core remains operational without it;
- it can own its behavior, state, routes, presentation, tests, and documentation;
- dependencies on Core and UI can be expressed through public Contracts;
- it can be independently packaged and versioned;
- it does not redefine required Core invariants.

Projects contributes its B-level Product and applicable C-level Product Areas to Core Navigation. It does not own the Sidebar Navigation Frame Surface or Core Navigation Registry.

Projects must not own required authentication, authorization infrastructure, Settings infrastructure, Notifications infrastructure, Audit infrastructure, Core Navigation, Workspace composition, or reusable UI merely because it consumes those responsibilities.

## 7. Modal And Dialog UI Bundle

### 7.1. Selection Rationale

The Modal and Dialog Component family is selected as the reusable UI example because it exercises a complete presentation-only bundle rather than a simple static Blade fragment.

The example includes applicable:

- public Blade aliases;
- machine-readable Component contracts;
- Blade implementation;
- reusable CSS;
- reusable JavaScript controls;
- focus management;
- keyboard and dismissal behavior;
- semantic dialog and alert-dialog behavior;
- accessibility labels and relationships;
- targeted rendering and interaction tests;
- examples and reference documentation;
- deterministic asset composition;
- compatibility inputs.

### 7.2. Classification Boundary

Modal and Dialog are UI-owned because:

- their primary responsibility is reusable presentation and interaction;
- they render data and state supplied by consumers;
- they do not own routes, authorization, persistence, or domain decisions;
- they may be consumed by Core and Module presentation;
- they must not depend on Core or Module implementation.

A Projects or Settings workflow may use a Modal, but that use does not transfer Modal ownership to Projects or Settings.

### 7.3. Validation Value

The bundle tests whether Goal 3 can:

- colocate UI-owned implementation, Contract, CSS, JavaScript, and tests;
- distinguish UI runtime behavior from owner-specific workflow behavior;
- preserve explicit asset composition;
- reject parallel unowned CSS and JavaScript trees as target placement;
- prevent UI dependencies on application-owner implementation.

## 8. Sidebar Navigation Frame Surface

### 8.1. Selection Rationale

The Sidebar Navigation Frame Surface is selected because it validates the most significant shared composition boundary exposed by the representative Core and Module examples.

It exercises the relationship among:

- an active System Workspace;
- the Workspace’s eligible B-level Product scope;
- Core Navigation Host Contracts and Registry;
- owner-local Product and Product Area Contributions;
- Access/Permissions evaluation;
- Core Module lifecycle availability;
- active Product and current-route resolution;
- UI-owned shell rendering.

This example validates composition across owners without converting the Frame Surface into an owner or generic implementation folder.

### 8.2. Classification Boundary

The Sidebar Navigation Frame Surface is a named region of the persistent authenticated Frame.

Responsibilities remain divided:

- the active Workspace supplies the eligible B-level Product scope and default Product;
- Core Navigation owns Product and Product Area Extension Point Contracts, Registry validation, ordering, active-state resolution, and fallback;
- Settings, Projects, and other Product owners retain their Contributions and linked behavior;
- Access/Permissions owns permission evaluation;
- Core Module lifecycle owns optional Module availability;
- UI owns reusable sidebar rendering, responsive behavior, disclosure, focus, keyboard behavior, and accessibility;
- the authenticated app layout remains a restricted composition adapter.

The Sidebar Navigation Frame Surface does not own:

- Product behavior;
- Workspace identity or access;
- permission meaning or evaluation;
- Module lifecycle;
- routes or HTTP validation;
- persistence;
- reusable UI internals;
- Contributor implementation.

A Frame Surface is not a fourth ownership area, a route, a Page, a Flow, a Registry, or a generic `Surface/` Technical Role.

### 8.3. Validation Value

The Sidebar Navigation Frame Surface tests whether Goal 3 can distinguish:

- Workspace composition from navigation resolution;
- Host-owned Registry behavior from Contributor-owned declarations;
- navigation visibility from route authorization;
- application data from normalized UI render data;
- Frame composition from Product presentation;
- reusable shell rendering from Core Navigation policy;
- Product ownership from shared navigation ownership.

## 9. Relationship Among The Examples

The examples form the following representative composition model:

```text
Active Workspace
    -> supplies eligible Product scope

Settings and Projects
    -> contribute Product and Product Area declarations

Core Navigation
    -> validates and resolves Sidebar Navigation

UI
    -> renders the Sidebar Navigation Frame Surface

Modal and Dialog
    -> remain reusable UI consumed where required
```

Settings remains an independent required Core example and separately acts as a Host for settings Contributions.

Projects may consume Settings public Contracts or declare a Settings Contribution only when a later accepted Projects product Contract requires that integration. Phase 6 does not assume a Projects Settings Contribution merely to connect the examples.

The required dependency direction is:

```text
Projects Module -> Core public Contracts
Projects Module -> Core Navigation Extension Point Contract
Projects Module -> UI public APIs

Settings -> Core Navigation Extension Point Contract
Settings -> UI public APIs

Core Navigation -> Workspace public Contract
Core Navigation -> Access permission-evaluation Contract
Core Navigation -> Module lifecycle availability Contract
Core Navigation -> validated Product Contributions

UI -> normalized render data only
```

The prohibited reverse direction is:

```text
Core -> Projects implementation
Core Navigation -> Contributor implementation
UI -> Core or Module implementation
Contributor -> Host Registry implementation
Owner behavior -> Delivery Adapter
Any owner -> another owner's Models or tables
```

## 10. Alternatives Not Selected

### 10.1. QuickBooks Sync

QuickBooks Sync remains a valid representative Module identity and may be used in later integration or packaging validation.

Projects is selected for Phase 6 because it can exercise a broader general-purpose Module shape without requiring Phase 6 to assume external-service credentials, remote synchronization behavior, webhook protocols, or vendor-specific reliability requirements.

This selection does not reject QuickBooks Sync as a future Module.

### 10.2. Projects Surface

Projects does not qualify as a separate Workspace or Frame Surface.

Its Product overview, Pages, Product Areas, routes, presentation, and local navigation remain Projects-owned Module responsibilities inside the active Workspace. Projects contributes navigation declarations but does not own shared Frame composition.

### 10.3. Settings Surface

Settings does not require a separate Workspace or owner-specific Surface.

Settings is a Product within the Default Workspace. Its active Product state may expose Settings Product Areas in the Sidebar Navigation Frame Surface without transferring navigation ownership to Settings.

### 10.4. Header Navigation Frame Surface

Header Navigation is also a valid Frame Surface, but Sidebar Navigation is selected because the accepted persistent sidebar directly exercises B-level Product entries and one C-level Product Area layer.

Whether B-level Product links are also rendered in the header remains a later Navigation and UI decision.

### 10.5. Simpler UI Components

A simple Component such as Button or Tag would validate only a narrower Blade and styling boundary.

Modal and Dialog provide stronger evidence because they include reusable runtime behavior, accessibility, JavaScript, composition, compatibility, and targeted testing concerns.

## 11. Selection Boundaries

Phase 6.1 does not:

- implement or move any example;
- define the complete Projects feature Contract;
- define detailed Settings schema;
- select the complete Product and Product Area inventory;
- create a Projects Composer package;
- define exact Module dependency versions;
- define the exact Navigation Contribution schema;
- define Workspace switcher routing or persistence;
- migrate Modal or Dialog assets;
- create architecture tests or guardrails;
- accept compatibility aliases;
- replace current implementation evidence with target-state claims.

The selected examples are architecture-validation subjects only.

## 12. Accepted Decision

> Goal 3 Phase 6 validates the accepted repository architecture against four representative examples:
>
> - Settings as the required Core capability and Product;
> - Projects as the optional Module and Product;
> - the Modal and Dialog Component family as the reusable UI responsibility;
> - the Sidebar Navigation Frame Surface as the shared Workspace-aware composition boundary.
>
> The examples are substantial enough to exercise ownership, package identity, placement, dependency direction, registration, configuration, persistence, presentation, tests, documentation, preimplementation proofs, and future architecture guardrails.
>
> Settings remains a required Core owner and Settings Host while contributing Product navigation. Projects remains an optional independently managed Module and Navigation Contributor. Modal and Dialog remain reusable UI-owned Components. Core Navigation hosts Sidebar Navigation resolution, while the active Workspace supplies Product scope and UI renders the resolved Frame Surface.
>
> Current physical implementation may provide evidence but does not establish target authority. Selection does not authorize implementation, migration, schema design, compatibility work, or complete product design.

## 13. Phase 6.2 Handoff

Phase 6.2 must map each selected example across applicable:

- identity;
- Contracts;
- implementation;
- Delivery Adapters;
- routes and registration;
- configuration;
- database lifecycle;
- views and assets;
- tests;
- documentation.

The mapping must:

- use sparse Technical Roles;
- identify one owner and target location for each material artifact;
- distinguish Product behavior from reusable UI;
- distinguish Workspace scope, Navigation Host resolution, Frame Surface rendering, and HTTP delivery;
- preserve later Goal authority;
- record current placement only as evidence or migration input.

## 14. Related

- [Phase 6 Representative Architecture Validation Index](index.md)
- [Phase 6.2 Representative Example Mappings](6-2-representative-example-mappings.md)
- [Phase 6.90 Workspace, Navigation Hierarchy, And Frame Surface Clarification](6-90-workspace-navigation-and-frame-surface-clarification.md)
- [ADR-0008: Workspace, Navigation Hierarchy, And Frame Surface Model](../../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
- [Workspace Navigation And Frame Composition](../../../../../03-architecture/workspace-navigation-and-frame-composition.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Phase 4 Artifact Placement Matrix](../phase-4/artifact-placement-matrix.md)
- [Phase 4 Dependency And Communication Matrix](../phase-4/dependency-and-communication-matrix.md)
- [Phase 5 Module Identity Matrix](../phase-5/module-identity-matrix.md)
- [Phase 5 Naming Convention Matrix](../phase-5/naming-convention-matrix.md)
- [Module Definition](../../../../Definitions/Modules/Definition.md)
- [UI Definition](../../../../Definitions/UI/Definition.md)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)