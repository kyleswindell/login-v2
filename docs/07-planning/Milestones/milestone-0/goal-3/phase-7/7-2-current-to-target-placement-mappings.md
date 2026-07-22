<!--
DOC-META
title: Phase 7.2 Current-To-Target Placement Mappings
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/7-2-current-to-target-placement-mappings.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines how material current repository patterns will be mapped to accepted Goal 3 owners, target structures, migration dispositions, preservation bases, and later implementation owners.
-->

# Phase 7.2 Current-To-Target Placement Mappings

Parent: [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)

## 1. Purpose

Create the architectural direction map from the current repository to the accepted Goal 3 target architecture.

For each material current pattern, Phase 7.2 identifies:

* its current responsibility;
* its accepted target owner;
* its target structural pattern;
* its migration disposition;
* any concrete preservation basis;
* the later Goal or issue responsible for implementation.

The mapping remains pattern-based. It does not define file-by-file moves, implementation order, compatibility adapters, or physical migration steps.

## 2. Status

* Planning lifecycle: draft
* Decision state: proposed for repository-owner Phase 7 review
* Implementation state: planning only
* Physical migration authorized: no
* Main deliverable: [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md)
* Owning GitHub issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
* Depends on:

  * accepted Goal 3 Phases 1 through 6;
  * accepted Phase 7.1 mapping scope;
  * accepted Goal 2 current-state evidence;
  * current accepted repository state on `main`.

## 3. Authority And Evidence

Target direction comes from accepted:

* ADRs;
* canonical architecture;
* repository and coding standards;
* Goal 3 placement, dependency, naming, and validation decisions;
* repository-owner decisions.

Current repository structure and Goal 2 inventories provide evidence of what exists.

Current placement does not establish permanent ownership.

Where current implementation conflicts with the accepted architecture, the matrix records the accepted target rather than preserving the current structure.

## 4. Deliverables

Phase 7.2 produces two related artifacts.

### 4.1. Placement-Mapping Decision

This document records:

* the mapping method;
* required coverage;
* treatment of mixed areas;
* major mapping conclusions;
* unresolved review subjects;
* acceptance criteria.

### 4.2. Direction Matrix

`current-to-target-direction-matrix.md` is the primary lookup artifact.

Each row uses the fields accepted in Phase 7.1:

| Field                              | Purpose                                                                                 |
| ---------------------------------- | --------------------------------------------------------------------------------------- |
| Mapping ID                         | Stable Phase 7 reference                                                                |
| Current pattern and responsibility | What currently exists and what it performs                                              |
| Target owner and pattern           | Accepted owner and structural destination                                               |
| Disposition                        | Retain, move, rename, split, merge, extract, replace, remove later, or decision blocked |
| Preservation basis                 | UI contract, tooling, behavior/evidence, external or persisted dependency, or none      |
| Later owner                        | Goal, issue, capability, Module, UI owner, or migration work responsible for follow-up  |
| Notes                              | Material qualification or blocker only                                                  |

The decision document must not duplicate the complete matrix.

## 5. Mapping Method

For each material current pattern:

1. identify the responsibility represented by the current code or repository area;
2. compare that responsibility with the accepted Goal 3 ownership model;
3. assign the accepted target owner;
4. identify the target structural pattern;
5. assign a controlled migration disposition;
6. record preservation only when supported by an accepted basis;
7. assign detailed design or implementation to the appropriate later owner.

Mixed current areas must be divided until each row has one understandable target direction.

Several current paths may share one row when they have the same:

* responsibility;
* target owner;
* target pattern;
* disposition;
* preservation basis;
* later owner.

## 6. Default Treatment

Current non-UI application implementation is disposable by default.

The normal result is:

```text
Disposition: replace, split, extract, move, rename, or remove later
Preservation basis: none
Compatibility requirement: none
```

Accepted UI public contracts remain protected unless a later authorized UI decision changes them.

Required behavior, security constraints, architecture evidence, and useful repository tooling may be preserved even when the current implementation is replaced.

Phase 7.2 records direction only. It does not authorize deletion or replacement.

## 7. Required Mapping Coverage

The direction matrix must cover material patterns in the following areas.

### 7.1. Core And Transitional Application Areas

Review applicable:

* `app/Platform/`;
* `app/Core/`;
* `app/Surfaces/`;
* generic Shared, Common, Support, Services, or Managers areas;
* current Auth, Access, Settings, Preferences, Navigation, Dashboard, Setup, and Global Administration responsibilities.

The matrix must separate required Core behavior from presentation, optional behavior, Laravel integration, and obsolete transitional structure.

### 7.2. Modules And Optional Functionality

Review applicable:

* current Module packages;
* required Core responsibilities currently implemented as Modules;
* optional functionality currently placed in required application areas;
* Module lifecycle and package infrastructure;
* Module-owned routes, configuration, persistence, presentation, tests, and documentation.

Required Core behavior must not remain Module-owned merely because it currently exists under `Modules/`.

### 7.3. Laravel Integration

Review applicable:

* `bootstrap/`;
* `app/Http/`;
* `app/Console/`;
* `app/Providers/`;
* `routes/`;
* `config/`;
* application registration and package-loading mechanisms.

Restricted Laravel integration may compose owners through public boundaries. It must not become the owner of application behavior.

### 7.4. UI, Presentation, And Frame Composition

Review applicable:

* accepted reusable UI Elements, Components, Patterns, and Layouts;
* shell and navigation implementation;
* Frame composition;
* Product and Page presentation;
* feature-owned views and assets;
* duplicate or transitional CSS and JavaScript;
* UI contracts, references, examples, and tests.

Accepted UI public contracts are preserved by default.

Feature-specific presentation remains owned by the applicable Core capability or Module.

### 7.5. Persistence

Review applicable:

* root Models and generic persistence roles;
* Core-owned persistence;
* Module-owned persistence;
* root migrations and seeders;
* Core schema-lifecycle groupings;
* Module package-local database artifacts.

Phase 7.2 records structural ownership direction only.

Detailed schema, relationship, constraint, and data-migration decisions remain Goal 6 authority.

### 7.6. Tests And Verification

Review applicable:

* owner-local Core tests;
* Module package tests;
* UI artifact tests;
* Delivery Adapter tests;
* root integration, browser, architecture, compatibility, and repository-rule tests;
* test discovery and shared test infrastructure.

Tests may be retained as behavior evidence even when their implementation coupling requires later replacement.

### 7.7. Documentation, Scripts, And Tooling

Review applicable:

* canonical documentation;
* package-local documentation;
* repository instructions;
* development and build configuration;
* inventory and evidence tooling;
* documentation guardrails;
* generators and validators;
* obsolete or historical workflow scripts.

Useful repository tooling should be retained or deliberately migrated rather than discarded with obsolete application code.

## 8. Deeper-Review Areas

The following areas require targeted discussion before their matrix rows are accepted:

1. `app/Platform/`, `app/Core/`, and `app/Surfaces/`;
2. current Module packages and optional functionality outside proper Module boundaries;
3. Laravel bootstrap, Providers, route composition, and application registration;
4. shell, navigation, reusable UI, and owner-specific presentation overlap;
5. root Models, database lifecycle structure, and persistence ownership;
6. owner-local versus root test placement;
7. useful repository tooling versus obsolete application-specific scripts;
8. administrative route-prefix direction.

Routine rows that clearly map to retain, replace, move, extract, or remove later do not require separate repository-owner discussion.

## 9. Unresolved And Blocked Mappings

A row uses `decision blocked` only when the accepted target owner or pattern cannot yet be determined.

The row must identify:

* the exact unresolved question;
* why Goal 3 cannot resolve it from accepted authority;
* the later Goal or explicit decision owner;
* the temporary planning treatment.

A blocked decision must not be hidden through a generic target such as:

* Shared;
* Common;
* Platform;
* Services;
* Support;
* Surface.

The current `/platform/*` administrative route family remains a review subject until an accepted route-prefix direction is identified or explicitly transferred to a later owner.

## 10. Major Expected Directions

The detailed matrix remains subject to targeted review, but Phase 7 begins with these accepted expectations:

* `app/Platform/` is transitional and must be divided by actual responsibility;
* required behavior maps to accepted Core capabilities;
* optional cohesive behavior maps to independently managed Modules;
* reusable UI remains UI-owned;
* Product and Page presentation remains owner-local;
* Frame composition uses Workspace, Core Navigation, restricted app composition, and UI rendering boundaries;
* conventional Laravel folders remain restricted integration boundaries;
* generic ownerless roots are not permanent targets;
* persistence moves toward Core- or Module-local ownership, subject to Goal 6;
* tests move toward the smallest clear owner, with root tests reserved for cross-owner proof;
* useful repository tooling is retained or deliberately migrated;
* compatibility is exceptional rather than the default.

## 11. Excluded Detail

Phase 7.2 does not define:

* individual file destinations;
* exact class or namespace rename lists;
* migration waves;
* implementation order;
* compatibility-adapter design;
* route redirect tables;
* schema transformations;
* record-level data migration;
* UI redesign;
* test rewrites;
* cleanup commands.

Those belong to later Goals and bounded implementation issues.

## 12. Proposed Decision

Accept the current-to-target placement process as follows:

1. use the Phase 7.1 pattern-level scope;
2. map every material current repository pattern;
3. split mixed areas by responsibility and target owner;
4. treat non-UI implementation as disposable by default;
5. protect accepted UI public contracts;
6. preserve useful tooling, required behavior, and evidence where justified;
7. record compatibility only for concrete obligations;
8. assign detailed design and implementation to later owners;
9. use the direction matrix as the primary migration lookup artifact;
10. exclude physical migration and implementation sequencing from Goal 3.

## 13. Validation

Before Phase 7.2 acceptance:

* confirm all required mapping categories are represented;
* confirm each matrix row has one target direction or explicit blocker;
* confirm mixed areas are divided appropriately;
* confirm every row uses an accepted disposition;
* confirm preservation has a concrete basis;
* confirm compatibility entries are exceptional and evidence-backed;
* confirm accepted UI contracts remain protected;
* confirm detailed later-goal work is not absorbed into Goal 3;
* confirm the matrix remains reviewable and pattern-based;
* run `npm run lint:docs:guardrails`;
* run `git diff --check`.

## 14. Acceptance Record

* Outcome:
* Date:
* Accepted or rejected by:
* Accepted mapping artifact:
* Accepted major directions:
* Blocked mappings:
* Required corrections:
* Evidence:
* Downstream handoff:

## 15. Related

* [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)
* [Phase 7.1 Current-To-Target Mapping Scope](7-1-current-to-target-mapping-scope.md)
* [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md)
* [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
* [Goal 3 Index](../index.md)
* [Phase 6 Representative Architecture Validation Index](../phase-6/index.md)
* [Repository Architecture](../../../../../03-architecture/repository-architecture.md)
* [Application Registration](../../../../../03-architecture/application-registration.md)
* [Workspace Navigation And Frame Composition](../../../../../03-architecture/workspace-navigation-and-frame-composition.md)
* [Repository Naming Standards](../../../../../02-standards/coding/repository-naming-standards.md)
* [Testing Standards](../../../../../02-standards/coding/Testing%20Standards.md)
* [M0 Repository Current-State Inventory](../../../../00-overview/m0-repository-current-state-inventory.md)
* [M0 UI Current-State Inventory](../../../../00-overview/m0-ui-current-state-inventory.md)
* [M0 Persistent Data Current-State Inventory](../../../../00-overview/m0-persistent-data-current-state-inventory.md)
* GitHub Phase 7 issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* GitHub parent Goal 3 issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
