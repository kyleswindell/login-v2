<!--
DOC-META
title: Phase 3 Target Repository Tree Index
doc_type: index
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/index.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the accepted Phase 3 repository-tree decisions and summarizes the target root, application, Core, Module, resource, test, supporting, transitional, and prohibited structures.
-->

# Phase 3 Target Repository Tree Index

Parent: [Goal 3 Target Repository Architecture Index](../index.md)

Use this index to navigate the accepted Phase 3 target-tree decisions.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Status](#3-status)
- [4. Documents](#4-documents)
- [5. Accepted Target Tree](#5-accepted-target-tree)
- [6. Accepted Decision Summary](#6-accepted-decision-summary)
  - [6.1. Target Top-Level Branches](#61-target-top-level-branches)
  - [6.2. Target `app/` Branches](#62-target-app-branches)
  - [6.3. Conventional Laravel Folder Roles](#63-conventional-laravel-folder-roles)
  - [6.4. Core Physical Structure](#64-core-physical-structure)
  - [6.5. Module Physical Structure](#65-module-physical-structure)
  - [6.6. UI And Resource Structure](#66-ui-and-resource-structure)
  - [6.7. Supporting Repository Branches](#67-supporting-repository-branches)
  - [6.8. Transitional And Prohibited Branches](#68-transitional-and-prohibited-branches)
  - [6.9. Test Folder Locations](#69-test-folder-locations)
- [7. Phase 4 Handoff](#7-phase-4-handoff)
- [8. Phase 3 Closeout](#8-phase-3-closeout)
- [9. Maintenance Notes](#9-maintenance-notes)
- [10. Related](#10-related)

## 1. Purpose

Phase 3 translates the accepted architecture boundaries and owner-first organization model into one concrete target repository tree.

The Phase 3 package defines:

- permanent repository-root branches;
- permanent direct children of `app/`;
- restricted conventional Laravel integration folders;
- the Core capability structure;
- the Module package structure;
- the artifact-owned UI and resource structure;
- supporting repository branches;
- transitional, compatibility-only, deprecated, generated, and prohibited locations;
- owner-local and repository-wide test locations.

Phase 3 defines topology and structural patterns. It does not move files, change namespaces, implement compatibility, or decide detailed artifact placement.

## 2. Scope

Phase 3 owns the major branches and structural patterns needed by Phase 4.

Phase 3 does not own:

- mapping every current file;
- detailed route, configuration, migration, view, asset, or test placement;
- dependency-direction rules;
- final folder, namespace, class, route, or file naming;
- physical migration;
- compatibility implementation;
- detailed Module catalog disposition;
- detailed database design.

## 3. Status

- Planning lifecycle: active
- Decision state: Decisions 3.1 through 3.9 accepted through repository-owner review
- Final Phase 3 acceptance: pending Issue #50 closeout
- Implementation state: target direction only
- Owning GitHub issue: [#50](https://github.com/kyleswindell/login-v2/issues/50)
- Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Downstream consumer: [#51](https://github.com/kyleswindell/login-v2/issues/51)

## 4. Documents

| Decision | Document                                                                            | Accepted result                                                                                       |
| -------- | ----------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------- |
| 3.1      | [Target Top-Level Branches](3-1-target-top-level-branches.md)                       | Seventeen permanent repository-root directories with bounded responsibilities                         |
| 3.2      | [Target `app/` Branches](3-2-target-app-branches.md)                                | `Core/` and `UI/` owner roots plus restricted `Http/`, `Console/`, and `Providers/` integration roots |
| 3.3      | [Conventional Laravel Folder Roles](3-3-conventional-laravel-folder-roles.md)       | Conventional roles remain owner-local unless required for bounded global integration                  |
| 3.4      | [Core Physical Structure](3-4-core-physical-structure.md)                           | Sparse `app/Core/<Capability>/<TechnicalRole>/` topology                                              |
| 3.5      | [Module Physical Structure](3-5-module-physical-structure.md)                       | Independently distributable Composer packages with PHP source beneath `src/`                          |
| 3.6      | [UI And Resource Structure](3-6-ui-and-resource-structure.md)                       | Artifact-owned presentation bundles colocating Blade, CSS, JavaScript, contracts, and tests           |
| 3.7      | [Supporting Repository Branches](3-7-supporting-repository-branches.md)             | Bounded roles for database, tests, config, routes, docs, agents, stubs, scripts, and operations       |
| 3.8      | [Transitional And Prohibited Branches](3-8-transitional-and-prohibited-branches.md) | Explicit non-target lifecycle, reclassification, compatibility, and prohibition rules                 |
| 3.9      | [Test Folder Locations](3-9-test-folder-locations.md)                               | Hybrid owner-local and repository-wide test topology                                                  |

## 5. Accepted Target Tree

The target tree is a structural pattern. Optional branches appear only when required by their owner.

```text
/
├── .agents/
├── .docker/
├── .github/
├── app/
│   ├── Core/
│   │   └── <Capability>/
│   │       ├── <TechnicalRole>/
│   │       └── __tests__/
│   ├── UI/
│   │   └── <Responsibility>/
│   │       ├── <TechnicalRole>/
│   │       └── __tests__/
│   ├── Http/
│   ├── Console/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
├── docs/
├── Modules/
│   └── <Module>/
│       ├── composer.json
│       ├── README.md
│       ├── src/
│       │   ├── Definition.php
│       │   └── <TechnicalRole>/
│       ├── config/
│       ├── routes/
│       ├── database/
│       ├── resources/
│       ├── tests/
│       └── docs/
├── ops/
├── public/
├── resources/
│   ├── css/
│   │   ├── app.css
│   │   └── base/
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── components/
│       │   ├── ui/
│       │   ├── patterns/
│       │   └── layouts/
│       ├── elements/
│       ├── core/
│       ├── errors/
│       └── vendor/
├── routes/
├── scripts/
├── storage/
├── stubs/
└── tests/
```

The tree does not require empty structural skeletons.

## 6. Accepted Decision Summary

### 6.1. Target Top-Level Branches

> Login 2.0 retains seventeen permanent repository-root directories: `.agents/`, `.docker/`, `.github/`, `app/`, `bootstrap/`, `config/`, `database/`, `docs/`, `Modules/`, `ops/`, `public/`, `resources/`, `routes/`, `scripts/`, `storage/`, `stubs/`, and `tests/`. Each branch owns one bounded repository function and does not create a peer application owner. Generated dependency, build, test-report, and runtime output directories are not canonical repository branches. Generic root ownership branches such as `Platform/`, `Surfaces/`, `Shared/`, `Common/`, `Helpers/`, and `Utilities/` are prohibited. Acceptance of a root branch does not accept every current child path, artifact, or name beneath it.

### 6.2. Target `app/` Branches

> Login 2.0 organizes permanent PHP application source beneath two owner roots: `app/Core/` for required Core capabilities and `app/UI/` for reusable UI-owned PHP and runtime infrastructure. Optional Modules remain independently packaged beneath the repository-root `Modules/` branch. Conventional root Laravel folders may remain directly beneath `app/` only as restricted application-wide framework integration boundaries accepted through Decision 3.3. Surface, Registry, Delivery Adapter, Model, Rule, Livewire, and similar technical responsibilities remain beneath their explicit owner and do not create peer `app/` ownership branches. `app/Platform/`, `app/Surfaces/`, and `app/Support/` are transitional and prohibited for new canonical work.

### 6.3. Conventional Laravel Folder Roles

> Login 2.0 retains `app/Http/`, `app/Console/`, and `app/Providers/` as permanent but restricted application-wide Laravel integration boundaries. They may contain root framework integration, base artifacts, global registration, and bounded compatibility code, but they must not become default owners of capability- or Module-specific behavior. Models, Rules, Jobs, Events, Listeners, Policies, Notifications, Livewire components, and similar conventional Laravel roles remain valid only beneath their explicit Core, Module, or UI owner. Existing root folders for those roles are transitional or compatibility-only, are prohibited destinations for new canonical work, and may remain temporarily only through a bounded accepted exception.

### 6.4. Core Physical Structure

> Each permanent directory directly beneath `app/Core/` represents one cohesive required base-application capability. Core capability code is organized sparsely beneath that capability using the accepted shared Technical Role vocabulary. The default structure is `app/Core/<Capability>/<TechnicalRole>/`, with additional role-local grouping only when required by the capability contract. Login 2.0 does not use repository-wide Core technical-layer folders or generic `Shared`, `Common`, `Helpers`, `Utilities`, `Services`, or `Infrastructure` branches. Broadly used required responsibilities must belong to an explicitly named Core capability, reusable UI runtime infrastructure belongs to `app/UI/`, and global Laravel integration remains in the restricted root integration folders. Current `app/Core/Modules/` and `app/Core/Runtime/` content must be evaluated as cohesive Core capabilities, while exact artifact placement and final capability naming remain Phase 4 and Phase 5 authority.

### 6.5. Module Physical Structure

> Every permanent directory beneath `Modules/` represents one optional, independently understandable, versioned, installable, and distributable Composer package. A Module requires package-local Composer metadata, a README, PHP source beneath `src/`, one canonical Module definition, and Module-owned verification. Technical Roles are organized sparsely beneath `src/`. Configuration, routes, database artifacts, resources, tests, and package documentation remain package-local when required. Root `module.php` files and parallel definition authorities are transitional. Generic `Services`, `Support`, `Header`, and `Navigation` folders are not accepted target roles and must be reclassified. `Modules/_Template/` is not a Module and must move to generator-owned structure beneath `stubs/`. Acceptance of this package pattern does not accept the current `Modules/*` folders as the target Module catalog.

A Module’s `src/` directory contains PHP Technical Roles equivalent to those beneath `app/Core/<Capability>/`. Package-root `routes/`, `config/`, `database/`, `resources/`, `tests/`, and `docs/` are package integration and support branches rather than competing Technical Roles. Their Core equivalents are determined through the base application’s supporting branches and Phase 4 placement rules.

### 6.6. UI And Resource Structure

> Login 2.0 uses artifact-owned presentation bundles. A reusable UI Component, Element, Pattern, or Layout colocates its Blade or presentation implementation, CSS, JavaScript, machine-readable contract, targeted tests, partials, and internal support beneath one owner-visible source folder. Category-level CSS and JavaScript aggregators explicitly compose those bundles, while `resources/css/app.css` and `resources/js/app.js` remain the primary Vite entrypoints. Core-owned and Module-owned presentation follows the same colocation principle within its owner boundary. Truly application-wide base CSS, JavaScript bootstrap, framework overrides, error views, and vendor overrides may remain in bounded root integration locations. Separate parallel component trees beneath `resources/css` and `resources/js` are transitional and are not the target model. Final filenames, aliases, import conventions, and detailed artifact placement remain Phase 4 and Phase 5 authority.

### 6.7. Supporting Repository Branches

> Login 2.0 retains `database/`, `tests/`, `config/`, `routes/`, `docs/`, `.agents/`, `stubs/`, `scripts/`, and `ops/` as permanent supporting repository branches. Each branch has one bounded repository responsibility and supports explicit Core, Module, UI, or Laravel integration owners without becoming an application owner itself. Root `tests/` is limited to cross-owner, system, browser, architecture, compatibility, repository, and shared test infrastructure under the accepted hybrid test-location model. Root `config/`, `routes/`, and `database/` provide base-application and Laravel integration rather than absorbing owner-specific responsibility. `docs/` remains canonical documentation authority, `.agents/` remains noncanonical execution guidance, `stubs/` owns generator inputs, `scripts/` owns executable repository automation, and `ops/` owns machine-consumed operational assets. Human operational procedures remain in `docs/10-runbooks/`, and no additional generic support root is introduced without a separately accepted repository responsibility.

### 6.8. Transitional And Prohibited Branches

> Login 2.0 treats `app/Platform/`, `app/Surfaces/`, `app/Support/`, root owner-specific `app/Models/`, `app/Rules/`, and `app/Livewire/`, the current direct-root Module PHP layout, `Modules/_Template/`, parallel CSS and JavaScript component trees, legacy \platform`-named presentation paths`, and legacy Platform planning packages as transitional or compatibility-only. They are prohibited destinations for new canonical work and must be reclassified into the accepted Core, Module, UI, Laravel integration, resource-bundle, test, documentation, script, stub, or operations structure. Generic ownership branches such as `Platform`, `Surfaces`, `Shared`, `Common`, `Helpers`, `Utilities`, `Services`, and `Support` are prohibited at repository, application-owner, Core, and Module levels. Historical evidence remains unchanged, and no transitional branch may be removed until ownership, target placement, compatibility, verification, documentation, and repository-owner acceptance requirements are satisfied.

### 6.9. Test Folder Locations

> Login 2.0 uses owner-local test colocation where one capability, Module, UI artifact, or bounded Laravel integration area clearly owns the behavior under test. Core capabilities and application-owned PHP areas may use a root-local `__tests__/` package; reusable UI bundles may use artifact-local or category-local `__tests__/`; independently distributable Modules use package-root `tests/`. The repository-root `tests/` branch remains permanent for cross-owner integration, system, browser, architecture, compatibility, repository, and shared test-infrastructure concerns. Tests must not be centralized merely by technical type, and test-runner configuration must eventually prove deterministic discovery across every accepted location.

## 7. Phase 4 Handoff

Phase 4 retains authority for:

- exact contract and implementation placement;
- detailed HTTP, console, webhook, presenter, renderer, ViewModel, and PageData placement;
- Core route-file placement and registration;
- configuration placement and publication;
- Core migration, factory, seeder, and data-access placement;
- exact view and asset placement within the accepted bundle model;
- detailed test placement and deterministic discovery;
- documentation placement;
- dependency direction and cross-owner communication;
- placement exceptions and future guardrails.

Phase 4 must not reopen the accepted Phase 3 branches or structural patterns.

## 8. Phase 3 Closeout

Phase 3 closeout requires:

- [x] Decisions 3.1 through 3.9 are accepted by the repository owner.
- [X] the Goal 3 target-architecture artifact contains the concise accepted Phase 3 result;
- [X] the Goal 3 and Milestone 0 indexes route to the Phase 3 package;
- [X] required durable architecture and standards promotion is created or explicitly assigned;
  - [X] - Created at: [Durable Promotion Register](durable-promotion-register.md)
- [X] stale conflicting topology terminology is removed or marked transitional;
- [X] `npm run lint:docs:guardrails` passes;
- [X] `git diff --check` passes;
- [X] the repository owner completes the Issue #50 Final Acceptance Record.

## 9. Maintenance Notes

- Keep this index concise and routing focused.
- Detailed reasoning remains in the numbered decision documents.
- Do not perform physical migration through this planning package.
- Do not add empty decision files or universal structural skeletons.
- Record corrective decisions explicitly rather than silently rewriting accepted history.
- Update the Phase 3 state only when Issue #50 and repository documentation agree.

## 10. Related

- [Goal 3 Index](../index.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Phase 2 Repository Organization Index](../phase-2/index.md)
- GitHub Phase 3 issue: [#50](https://github.com/kyleswindell/login-v2/issues/50)
- GitHub Phase 4 issue: [#51](https://github.com/kyleswindell/login-v2/issues/51)
