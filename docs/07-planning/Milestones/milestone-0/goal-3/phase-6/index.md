<!--
DOC-META
title: Phase 6 Representative Architecture Validation Index
doc_type: index
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-6/index.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the accepted Phase 6 representative selections, mappings, ownership and dependency verification, proof requirements, guardrails, bounded corrections, promotion targets, and Phase 7 handoff.
-->

# Phase 6 Representative Architecture Validation Index

Parent: [Goal 3 Target Repository Architecture Index](../index.md)

- [1. Purpose](#1-purpose)
- [2. Authority And Scope](#2-authority-and-scope)
- [3. Phase Status](#3-phase-status)
- [4. Reading Order](#4-reading-order)
- [5. Decision Register](#5-decision-register)
- [6. Consolidated Deliverables](#6-consolidated-deliverables)
- [7. Accepted Validation Summary](#7-accepted-validation-summary)
- [8. Bounded Architecture Correction](#8-bounded-architecture-correction)
- [9. Proof And Guardrail Handoff](#9-proof-and-guardrail-handoff)
- [10. Deferred Decisions And Phase 7 Handoff](#10-deferred-decisions-and-phase-7-handoff)
- [11. Durable Promotion](#11-durable-promotion)
- [12. Validation And Closeout](#12-validation-and-closeout)
- [13. Related](#13-related)

## 1. Purpose

Phase 6 validates the accepted Goal 3 ownership, topology, placement, dependency, naming, testing, and documentation model against four representative examples.

This index routes the detailed validation package required by Issue #53 and records its accepted bounded correction.

## 2. Authority And Scope

Phase 6 consumes:

- accepted Goal 3 Phases 1 through 5;
- ADR-0005, ADR-0006, and ADR-0007;
- current implementation only as transitional evidence;
- applicable architecture, Definitions, UI, coding, testing, database, and documentation standards.

Phase 6 validates:

- Settings as a required Core capability and Product;
- Projects as an optional Module and Product;
- Modal and Dialog as a reusable UI Component family;
- Sidebar Navigation as a Workspace-aware Frame Surface hosted by Core Navigation and rendered by UI.

Phase 6 does not:

- implement or migrate the examples;
- design complete Settings or Projects behavior or schema;
- implement Workspace switching or Navigation registration;
- implement the selected guardrails;
- authorize compatibility removal;
- replace Phase 7 migration planning;
- treat navigation visibility as authorization.

## 3. Phase Status

- Planning lifecycle: active
- Decision state: Phase 6.1 through 6.8 and Phase 6.90 accepted through repository-owner Phase 6 review
- Architecture correction: ADR-0008, multiple available Workspaces, narrow Frame Surfaces, A–E+ navigation, and Core Navigation identity accepted
- Permanent structural exceptions: none
- Consolidated deliverables: accepted; canonical reconciliation applied by this closeout change set, with repository validation pending
- Implementation state: accepted target validation only
- Final Phase 6 closeout: pending repository documentation checks and the Issue #53 Final Acceptance Record
- Owning GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Downstream migration issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)

This index records accepted target decisions and canonical reconciliation. It does not claim runtime implementation, physical migration, guardrail execution, or final Issue #53 closeout.

## 4. Reading Order

For a complete Phase 6 review:

1. read this index;
2. read [Representative Example Selections](6-1-representative-example-selections.md);
3. use [Representative Example Mappings](6-2-representative-example-mappings.md) for target owner and location lookup;
4. read [Ownership Boundary Verification](6-3-ownership-boundary-verification.md);
5. read [Dependency Direction Verification](6-4-dependency-direction-verification.md);
6. read [Placement And Naming Verification](6-5-placement-and-naming-verification.md);
7. read [Preimplementation Proof Requirements](6-6-preimplementation-proof-requirements.md);
8. read [Architecture Guardrail Selection](6-7-architecture-guardrail-selection.md);
9. read [Model Acceptance And Corrections](6-8-model-acceptance-and-corrections.md);
10. read [Phase 6.90](6-90-workspace-navigation-and-frame-surface-clarification.md), ADR-0008, and Workspace Navigation And Frame Composition for the bounded correction;
11. use the [Durable Promotion Register](durable-promotion-register.md) for reconciliation and later-owner routing.

## 5. Decision Register

| Decision | Document                                                                                                                         | Accepted result                                                                                                                          |
| -------- | -------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| 6.1      | [Representative Example Selections](6-1-representative-example-selections.md)                                                    | Select Settings, Projects, Modal and Dialog, and Sidebar Navigation Frame Surface                                                        |
| 6.2      | [Representative Example Mappings](6-2-representative-example-mappings.md)                                                        | Every applicable material artifact has one target owner, location, registration boundary, test location, and documentation owner         |
| 6.3      | [Ownership Boundary Verification](6-3-ownership-boundary-verification.md)                                                        | Behavior, delivery, persistence, UI, Host, Contributor, Workspace, Access, and composition ownership remain distinct                     |
| 6.4      | [Dependency Direction Verification](6-4-dependency-direction-verification.md)                                                    | All required dependencies use accepted public Contracts, Contributions, Queries, delivery direction, and normalized UI data              |
| 6.5      | [Placement And Naming Verification](6-5-placement-and-naming-verification.md)                                                    | Settings, Projects, Modal, Dialog, Core Navigation, and `Contrib/Navigation/` have predictable target identities and locations           |
| 6.6      | [Preimplementation Proof Requirements](6-6-preimplementation-proof-requirements.md)                                              | Future changes require protected characterization or exact expected-nonpass proof before production implementation                       |
| 6.7      | [Architecture Guardrail Selection](6-7-architecture-guardrail-selection.md)                                                      | Twelve bounded architecture rules are selected for later automated enforcement                                                           |
| 6.8      | [Model Acceptance And Corrections](6-8-model-acceptance-and-corrections.md)                                                      | All examples fit; no permanent exception is required; one bounded Workspace, Frame Surface, and Navigation correction is accepted        |
| 6.90     | [Workspace, Navigation Hierarchy, And Frame Surface Clarification](6-90-workspace-navigation-and-frame-surface-clarification.md) | A User Account may access multiple Workspaces; one is active; Frame Surfaces are narrow shell regions; navigation follows A–E+ hierarchy |

## 6. Consolidated Deliverables

| Artifact                                                                                                                   | Responsibility                                                              |
| -------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------- |
| [Representative Example Mappings](6-2-representative-example-mappings.md)                                                  | Consolidated owner, path, registration, test, and documentation lookup      |
| [Ownership Boundary Verification](6-3-ownership-boundary-verification.md)                                                  | Primary ownership proof                                                     |
| [Dependency Direction Verification](6-4-dependency-direction-verification.md)                                              | Permitted and prohibited dependency proof                                   |
| [Placement And Naming Verification](6-5-placement-and-naming-verification.md)                                              | Target identity and location proof                                          |
| [Preimplementation Proof Requirements](6-6-preimplementation-proof-requirements.md)                                        | Future verification-design handoff                                          |
| [Architecture Guardrail Selection](6-7-architecture-guardrail-selection.md)                                                | Later automated-enforcement candidates                                      |
| [Model Acceptance And Corrections](6-8-model-acceptance-and-corrections.md)                                                | Phase result, classifications, exceptions, corrections, and Phase 7 handoff |
| [Durable Promotion Register](durable-promotion-register.md)                                                                | Reconciliation routing into long-lived owners                               |
| [ADR-0008](../../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)                           | Cross-cutting decision and partial ADR-0006 supersession                    |
| [Workspace Navigation And Frame Composition](../../../../../03-architecture/workspace-navigation-and-frame-composition.md) | Durable Workspace, Frame, navigation, and contribution architecture         |

## 7. Accepted Validation Summary

| Example                          | Accepted classification                                                              | Result                                                                             |
| -------------------------------- | ------------------------------------------------------------------------------------ | ---------------------------------------------------------------------------------- |
| Settings                         | Required Core capability, Settings Host, B-level Product, and Navigation Contributor | Fits without structural exception                                                  |
| Projects                         | Optional independently managed Module, B-level Product, and Navigation Contributor   | Fits without structural exception                                                  |
| Modal and Dialog                 | UI-owned reusable Component family                                                   | Fits; current parallel asset and stale Surface dependencies are migration concerns |
| Sidebar Navigation Frame Surface | Active-Workspace composition resolved by Core Navigation and rendered by UI          | Fits under the accepted bounded correction                                         |

The validation confirms:

- one primary owner for each material responsibility;
- Core independence from optional Modules;
- UI independence from Core and Module implementation;
- owner-local delivery and persistence;
- explicit Host, Registry, and Contribution inversion;
- predictable target roots, namespaces, keys, routes, configuration, tests, and documentation;
- no generic or unowned production area;
- no undeclared Module-to-Module dependency;
- no permanent architecture exception.

## 8. Bounded Architecture Correction

Phase 6 accepts:

- multiple available Workspaces for a User Account;
- exactly one active Workspace in a rendered interaction context;
- Global Administration as a Workspace rather than an ordinary Surface;
- a persistent Frame with named Global Header and Sidebar Navigation Frame Surfaces;
- Main as a content outlet rather than a Frame Surface;
- System A, Product B, Product Area C, Page D, and Drill-down E+ navigation;
- Core `Navigation` as the Host for Product and Product Area Contributions;
- target identity `app/Core/Navigation/`, `App\Core\Navigation\`, `navigation`, and owner-local `Contrib/Navigation/`;
- removal of broad owner-local `Surface/` and generic `Surfaces/` target roles.

The correction does not change Core, Module, or UI as the three source-of-truth ownership areas.

## 9. Proof And Guardrail Handoff

Phase 6.6 requires future issues to define:

- observable success and rejection behavior;
- protected characterization or exact expected-nonpass proof;
- fixtures, environments, commands, and expected initial result;
- unchanged final proof;
- manual or specialist review;
- architecture, registration, permission, persistence, browser, accessibility, and documentation proof where applicable.

Phase 6.7 selects twelve later guardrails covering:

- Core isolation from optional Modules;
- UI independence;
- public cross-owner mechanisms;
- Registry inversion;
- Module declaration integrity;
- path and namespace agreement;
- prohibited roots;
- explicit Contributions;
- delivery direction;
- persistence isolation;
- UI artifact ownership;
- deterministic test discovery.

The selected rules are requirements, not implemented checks.

## 10. Deferred Decisions And Phase 7 Handoff

The following remain later-owner decisions:

- exact Workspace switcher route, URL, session, restoration, and preference behavior;
- final Tenant Administration Workspace qualification;
- whether B-level Products also appear in the global header;
- exact Product and Product Area Contribution schemas;
- exact Navigation ordering, conflict, cache, and fallback APIs;
- exact UI-shell bundle paths and public Blade APIs;
- detailed Settings and Projects schema;
- guardrail tooling and implementation order.

Phase 7 owns:

- current-to-target path and namespace migration;
- Core extraction from transitional Modules;
- Module package migration;
- UI asset consolidation;
- broad Surface and `App\Surfaces` compatibility treatment;
- shell and navigation implementation migration;
- compatibility records and removal conditions;
- final Goal 3 reconciliation and acceptance.

## 11. Durable Promotion

The [Durable Promotion Register](durable-promotion-register.md) routes Phase 6 results to:

- ADR-0008, ADR-0006, and the Decisions Index;
- Workspace Navigation And Frame Composition;
- Workspace Identity Model, System Overview, Repository Architecture, and Architecture Index;
- Surface, Host, Registry, Contribution, Contributor, and related Definitions;
- Navigation Pattern and UI Shell standards;
- Testing and Feature Development Standards where incomplete;
- later architecture-test, registration-validation, UI-validation, and CI issues;
- Phase 7 migration planning;
- agent guidance after canonical promotion.

Promotion must establish one durable owner for each full rule and preserve Phase 6 as representative evidence and historical traceability.

## 12. Validation And Closeout

Before Phase 6 closeout, verify in the active Goal 3 worktree:

```text
npm run lint:docs:guardrails
git diff --check
```

Also confirm:

- all 11 Phase 6 files are linked and discoverable;
- metadata, titles, canonical paths, parents, and templates are valid;
- ADR-0008 is accepted and indexed;
- ADR-0006 records the exact partial supersession;
- the Architecture Index routes to Workspace Navigation And Frame Composition;
- broad Surface wording is reconciled across active Phase 2–5 documents and Definitions;
- Core Navigation identity is consistent across Phase 6, repository architecture, and applicable planning;
- Goal 3 Target Repository Architecture contains the accepted Phase 6 result;
- Goal 3 Index routes to this Phase package;
- proof and guardrail requirements are not presented as executed;
- deferred migration subjects are transferred to Phase 7;
- Issue #53 contains the final repository-owner acceptance record.

## 13. Related

- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Goal 3 Target Repository Architecture Index](../index.md)
- [Phase 5 Naming Conventions Index](../phase-5/index.md)
- [Durable Promotion Register](durable-promotion-register.md)
- [ADR-0008](../../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
- [Workspace Navigation And Frame Composition](../../../../../03-architecture/workspace-navigation-and-frame-composition.md)
- Related GitHub issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
