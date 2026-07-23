<!--
DOC-META
title: Phase 4 Placement And Dependency Rules Index
doc_type: index
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-4/index.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the accepted Phase 4 placement, registration, dependency, communication, documentation, exception, promotion, and future-enforcement results.
-->

# Phase 4 Placement And Dependency Rules Index

Parent: [Goal 3 Target Repository Architecture Index](../index.md)

- [1. Purpose](#1-purpose)
- [2. Authority And Scope](#2-authority-and-scope)
- [3. Phase Status](#3-phase-status)
- [4. Reading Order](#4-reading-order)
- [5. Decision Register](#5-decision-register)
- [6. Consolidated Deliverables](#6-consolidated-deliverables)
- [7. Accepted Architecture Summary](#7-accepted-architecture-summary)
  - [7.1. Artifact Placement](#71-artifact-placement)
  - [7.2. Application Registration](#72-application-registration)
  - [7.3. Dependency Direction](#73-dependency-direction)
  - [7.4. Cross-Owner Communication](#74-cross-owner-communication)
  - [7.5. Documentation And Exceptions](#75-documentation-and-exceptions)
- [8. Definition Synchronization](#8-definition-synchronization)
- [9. Durable Promotion](#9-durable-promotion)
- [10. Downstream Handoffs](#10-downstream-handoffs)
  - [Phase 5 — Naming](#phase-5--naming)
  - [Phase 6 — Representative Validation](#phase-6--representative-validation)
  - [Phase 7 — Migration And Final Goal Acceptance](#phase-7--migration-and-final-goal-acceptance)
  - [Later Goals And Issues](#later-goals-and-issues)
- [11. Closeout Readiness](#11-closeout-readiness)
  - [11.1. Planning Completeness](#111-planning-completeness)
  - [11.2. Repository Reconciliation And Validation](#112-repository-reconciliation-and-validation)
- [12. Final Acceptance Record Requirements](#12-final-acceptance-record-requirements)
- [13. Related](#13-related)

## 1. Purpose

Phase 4 translates the accepted Goal 3 ownership model, repository organization, and target tree into practical rules for:

- locating Contracts and implementations;
- locating Delivery Adapters, routes, configuration, persistence, views, assets, tests, and documentation;
- registering owner-controlled artifacts;
- controlling dependency direction;
- selecting cross-owner communication mechanisms;
- documenting bounded exceptions;
- identifying architecture rules that require later enforcement.

This index routes the accepted decision documents, consolidated matrices, reusable Definitions, durable architecture promotion, and downstream handoffs.

## 2. Authority And Scope

Phase 4 consumes:

- accepted Phase 1 architecture boundaries;
- accepted Phase 2 repository organization and reusable architecture vocabulary;
- accepted Phase 3 target repository tree;
- ADR-0005, ADR-0006, and ADR-0007;
- current repository evidence only where it reveals a material placement, dependency, registration, or compatibility concern.

Phase 4 does not:

- reopen accepted Phase 1 through Phase 3 decisions;
- define final folder, namespace, class, key, route, alias, descriptor, manifest, registrar, test, or fixture names;
- map every current file;
- perform physical moves or namespace migrations;
- implement the Application Registration System;
- implement architecture guardrails;
- define detailed database schemas;
- define the complete verification architecture;
- implement contract-discovery tooling.

## 3. Phase Status

- Planning lifecycle: active
- Decision state: Decisions 4.1 through 4.12 accepted through repository-owner review
- Planning deliverables: complete for closeout reconciliation
- Implementation state: accepted target direction only
- Repository application state: must be verified from the active Goal 3 branch during closeout
- Automated validation state: not recorded as complete by this index
- Final Phase 4 acceptance: pending the Issue #51 Final Acceptance Record
- Owning GitHub issue: [#51](https://github.com/kyleswindell/login-v2/issues/51)
- Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Downstream naming issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)

This index does not attribute repository application, validation, or final issue acceptance until those actions are verified.

## 4. Reading Order

For a complete Phase 4 review:

1. read this index;
2. read the [Goal 3 Target Repository Architecture](../target-repository-architecture.md);
3. use the [Artifact Placement Matrix](artifact-placement-matrix.md) to classify artifact ownership and target location;
4. use the [Dependency And Communication Matrix](dependency-and-communication-matrix.md) to classify dependency edges and communication methods;
5. read the applicable Decision 4.1 through 4.12 document;
6. read the applicable reusable [Definition](../../../../Definitions/Index.md);
7. read [Application Registration](../../../../../03-architecture/application-registration.md) when registration, discovery, routing, Providers, commands, migrations, views, Livewire aliases, assets, or Contributions are involved;
8. use the [Durable Promotion Register](durable-promotion-register.md) for canonical documentation and future-enforcement routing.

## 5. Decision Register

| Decision | Document                                                                       | Accepted result                                                                                                                               |
| -------- | ------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------------------------------------------- |
| 4.1      | [Contract Placement](4-1-contract-placement.md)                                | Public and cross-owner Contracts remain provider-owned; internal abstractions remain adjacent unless deliberately promoted                    |
| 4.2      | [Implementation Placement](4-2-implementation-placement.md)                    | Concrete implementation remains beneath the narrowest accepted Core, Module, UI, Registry, Contribution, precise presentation role, or restricted Laravel owner |
| 4.3      | [Delivery Adapter Placement](4-3-delivery-adapter-placement.md)                | Delivery Adapters remain owner-local, own channel concerns only, and delegate behavior inward                                                 |
| 4.4      | [Route Placement And Registration](4-4-route-placement-and-registration.md)    | Routes remain owner-local and registrable artifacts use a deterministic Application Registration System                                       |
| 4.5      | [Configuration Placement](4-5-configuration-placement.md)                      | Configuration remains owner-specific; root configuration is restricted; runtime settings remain owner-controlled data                         |
| 4.6      | [Database And Migration Placement](4-6-database-and-migration-placement.md)    | Runtime persistence remains owner-local; Core schema lifecycle is owner-grouped and Module schema lifecycle remains package-local             |
| 4.7      | [View And Asset Placement](4-7-view-and-asset-placement.md)                    | Reusable presentation remains UI-owned; capability and Module presentation remains owner-specific; assets use deterministic composition       |
| 4.8      | [Test Placement](4-8-test-placement.md)                                        | Tests remain with the smallest clear owner or artifact; root tests remain cross-owner and repository-wide                                     |
| 4.9      | [Documentation Placement](4-9-documentation-placement.md)                      | Canonical documentation follows document authority; meaningful folders default to distinct README, index, and AGENTS responsibilities         |
| 4.10     | [Dependency Direction](4-10-dependency-direction.md)                           | Dependencies flow toward provider-owned public boundaries; Core remains independent of optional Modules                                       |
| 4.11     | [Cross-Owner Communication](4-11-cross-owner-communication.md)                 | Contracts, Queries, Events, Listeners, Jobs, Delivery Adapters, and Host Contributions are selected by interaction need                       |
| 4.12     | [Exceptions And Future Enforcement](4-12-exceptions-and-future-enforcement.md) | Exceptions are exact, bounded, owner-accepted, and nonprecedential; later guardrail targets are explicit                                      |

## 6. Consolidated Deliverables

| Artifact                                                                               | Responsibility                                                                                                                         | Phase 4 state                                         |
| -------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------- |
| [Artifact Placement Matrix](artifact-placement-matrix.md)                              | Structured owner, target-path, registration, prohibited-destination, and Phase 5 naming lookup                                         | Complete for closeout review                          |
| [Dependency And Communication Matrix](dependency-and-communication-matrix.md)          | Allowed and prohibited dependency edges, communication selection, coupling prohibitions, and registration-versus-Registry distinctions | Complete for closeout review                          |
| [Durable Promotion Register](durable-promotion-register.md)                            | Routes accepted results to architecture, standards, Definitions, agent guidance, and future enforcement                                | Complete for closeout review                          |
| [Definitions Index](../../../../Definitions/Index.md)                                  | Routes reusable owner, role, delivery, extension, and Application Registration definitions                                             | Synchronization must be verified in the active branch |
| [Repository Architecture](../../../../../03-architecture/repository-architecture.md)   | Durable target topology, placement, dependency, test, presentation, exception, and transition architecture                             | Promotion must be verified in the active branch       |
| [Application Registration](../../../../../03-architecture/application-registration.md) | Durable descriptor, compiler, manifest, registrar, native-framework, and Host Registry architecture                                    | Creation must be verified in the active branch        |

The matrices are canonical for their structured Phase 4 relationships after final owner acceptance. They do not replace the detailed decision documents, Definitions, architecture, or later standards.

### Phase 6 correction

ADR-0008 and Phase 6.90 supersede only the broad owner-specific Surface interpretation in Phase 4. Where a Phase 4 document or matrix uses Surface for ordinary Product Pages, destinations, areas, flows, PageData, ViewModels, Presenters, Renderers, or a generic `Surface/` role, interpret that responsibility as owner-specific Product presentation using the narrowest precise role. Frame Surface is reserved for named persistent-Frame regions. Core Navigation at `app/Core/Navigation/` hosts Product and Product Area Contributions through owner-local `Contrib/Navigation/` paths.

All other accepted Phase 4 placement, delivery, persistence, registration, dependency, communication, documentation, exception, and significant-folder rules remain unchanged.

## 7. Accepted Architecture Summary

### 7.1. Artifact Placement

Every artifact remains with the narrowest explicit owner of its promise, behavior, state, delivery, presentation, extension, or repository responsibility.

Default PHP patterns are:

```text
app/Core/<Capability>/<TechnicalRole>/
app/UI/<Responsibility>/<TechnicalRole>/
Modules/<Module>/src/<TechnicalRole>/
```

Package support artifacts remain in accepted package-root branches. Application-wide Laravel integration remains restricted to bounded root integration branches.

Generic ownership or implementation destinations such as `Shared`, `Common`, `Helpers`, `Utilities`, generic `Services`, generic `Support`, `Platform`, `Surface`, and `Surfaces` are prohibited for new canonical work.

### 7.2. Application Registration

Each registrable owner exposes an Owner Registration Descriptor.

A deterministic Registration Compiler:

1. validates declarations;
2. detects missing, duplicate, conflicting, cyclic, unknown, and stale registration;
3. resolves accepted dependencies;
4. produces a Compiled Registration Manifest.

One Root Application Registrar consumes that manifest and delegates to Typed Registrars, native Laravel, Livewire, Blade, or Vite integration, or owner-local Providers.

Filesystem presence alone does not register a canonical artifact. Laravel and Vite retain their native runtime, cache, and build responsibilities.

The Application Registration System is not a Host Registry, Laravel service container, Module Definition, or unrestricted filesystem-discovery mechanism.

### 7.3. Dependency Direction

- Core may depend on another Core capability’s public Contracts but not its internals.
- Core must not depend on optional Modules.
- Modules may depend on Core public Contracts and approved UI APIs.
- Module-to-Module dependencies require explicit public Contracts, declared package dependencies, and an acyclic dependency graph.
- reusable UI must not depend on Core or Module domain implementation;
- owner-specific Product presentation may depend on its own owner and reusable UI;
- Frame rendering consumes normalized Workspace and Core Navigation data and must not evaluate application policy;
- Delivery Adapters depend inward on owner behavior;
- owner behavior must not depend outward on Delivery Adapters or Frame rendering;
- root Laravel integration may compose owners through accepted registration boundaries but must not absorb owner behavior.

### 7.4. Cross-Owner Communication

| Interaction need                                 | Accepted mechanism                                                                                         |
| ------------------------------------------------ | ---------------------------------------------------------------------------------------------------------- |
| Immediate state-changing result                  | Provider-owned public Contract exposing an owner-controlled Action or another explicitly defined operation |
| Immediate read                                   | Provider-owned public Query Contract                                                                       |
| Stable boundary data                             | Provider-owned Data Object                                                                                 |
| Completed fact                                   | Provider-owned Event                                                                                       |
| Independent reaction                             | Consumer-owned Listener                                                                                    |
| Deferred, retryable, scheduled, or isolated work | Owner-controlled Job                                                                                       |
| External invocation translation                  | Owner-controlled Delivery Adapter or owner-specific integration implementation                             |
| Extensible Host feature                          | Host-owned Extension Point Contract and Contributor-owned Contribution                                     |
| Framework or build composition                   | Owner Registration Descriptor and Application Registration System                                          |

Events and Jobs must not conceal a required synchronous dependency.

Direct cross-owner concrete imports, Model or table access, generic shared services, static helpers, service location by concrete class, and hidden boot-time registration are prohibited.

### 7.5. Documentation And Exceptions

Canonical documentation follows document type and authority.

Most meaningful repository folders default to:

```text
README.md
index.md
AGENTS.md
```

The default may be omitted where deep standardized content, complete inherited guidance, generation, redundancy, intentional lack of navigation, or deliberate exclusion of scoped agent guidance makes one or more files unnecessary. Omissions must not leave ownership, navigation, or execution requirements ambiguous.

Placement and dependency exceptions require:

- an exact governing rule;
- one responsible owner;
- exact scope;
- permanent or transitional status;
- verified reason;
- permitted deviation;
- prohibited expansion;
- compatibility effect;
- required verification;
- repository-owner acceptance;
- an objective removal condition and migration owner when transitional.

An unexpected mandatory failure is not implicit authorization to weaken a rule or create an exception.

## 8. Definition Synchronization

Phase 4 requires synchronized reusable Definitions for:

- Actions;
- Queries;
- Contracts;
- Data Objects;
- Events;
- Listeners;
- Jobs;
- Providers;
- Delivery Adapters;
- HTTP Delivery Adapters;
- Console Delivery Adapters;
- Registries;
- Contributions;
- the Application Registration System.

The synchronized Definitions establish reusable meaning and boundaries. They do not implement runtime tooling or replace detailed owner Contracts and standards.

The active branch must be checked to confirm that the Definition files and [Definitions Index](../../../../Definitions/Index.md) contain the accepted Phase 4 updates before closeout.

## 9. Durable Promotion

Phase 4 establishes durable architecture promotion for:

- [Repository Architecture](../../../../../03-architecture/repository-architecture.md);
- [Application Registration](../../../../../03-architecture/application-registration.md);
- [System Overview](../../../../../03-architecture/system-overview.md);
- [Stack Overview](../../../../../03-architecture/stack-overview.md);
- the [Goal 3 Target Repository Architecture](../target-repository-architecture.md);
- Goal 3, Phase 4, Definitions, and Architecture indexes;
- Decision 4.11 terminology cleanup.

The durable architecture must distinguish accepted target state from current implemented state.

Coding, documentation, database, and agent-guidance standards remain explicit later-promotion work unless repository-owner scope separately authorizes those updates.

Registration tooling, architecture tests, dependency checks, asset validation, test-discovery checks, and documentation guardrails remain later implementation work. Phase 4 records those requirements but does not claim they exist or pass.

## 10. Downstream Handoffs

### Phase 5 — Naming

Phase 5 owns final names for:

- folders and namespaces;
- Core capabilities, Modules, and Technical Roles;
- Contracts and implementations;
- routes, configuration, Events, Jobs, commands, and middleware;
- tests, fixtures, and support artifacts;
- Extension Points, Registries, Contributions, and Contributors;
- Owner Registration Descriptors;
- Registration Compiler, Compiled Registration Manifest, Root Application Registrar, and Typed Registrars;
- aliases, view namespaces, asset bundles, aggregators, and generated output.

Phase 5 must not reopen accepted Phase 4 ownership, placement, dependency, or communication rules.

### Phase 6 — Representative Validation

Phase 6 validates the combined architecture through representative Core, Module, UI, Surface, Delivery Adapter, Registry, Contribution, registration, presentation, persistence, test, and documentation examples.

### Phase 7 — Migration And Final Goal Acceptance

Phase 7 owns coarse current-to-target mapping, compatibility direction, migration constraints, unresolved exceptions, and final Goal 3 acceptance.

### Later Goals And Issues

- Goal 6 owns detailed database schema design.
- standards-promotion work owns enforceable coding, documentation, database, and agent-guidance reconciliation;
- registration implementation work owns architecture, smallest vertical slice, compiler, manifest, registrar, cache, and native runtime proof;
- verification-architecture work owns complete suite discovery and enforcement;
- migration issues own physical moves and namespace changes.

## 11. Closeout Readiness

### 11.1. Planning Completeness

- [x] Decisions 4.1 through 4.12 are accepted.
- [x] Individual decision documents are drafted.
- [x] The Artifact Placement Matrix is drafted.
- [x] The Dependency And Communication Matrix is drafted.
- [x] The Durable Promotion Register is drafted.
- [x] Required reusable Definition updates are identified and drafted.
- [x] Durable architecture creation and updates are drafted.
- [x] Phase 5, Phase 6, Phase 7, Goal 6, standards, implementation, and enforcement handoffs are classified.
- [x] No material placement or dependency decision remains unassigned.

### 11.2. Repository Reconciliation And Validation

The following must be completed or explicitly reconciled during closeout:

- [X] verify the exact Phase 4 files present in the active Goal 3 branch;
- [X] verify the final index replaces all placeholder proposed-decision wording;
- [X] verify the consolidated matrices and promotion register contain no unresolved owner decision;
- [X] verify synchronized Definition files and the Definitions Index are present;
- [X] verify durable architecture files and indexes contain the accepted Phase 4 promotion;
- [X] review the final changed-file list for scope and shared-file collisions;
- [X] run `npm run lint:docs:guardrails`;
- [X] run `git diff --check`;
- [X] preserve exact command, environment, working-directory, exit-code, and output-hash evidence;
- [X] complete the Issue #51 Final Acceptance Record through explicit repository-owner action.

A failed mandatory validation is a failure. It is not authorization to weaken a decision, modify a Definition merely to satisfy the check, or silently omit a required artifact.

## 12. Final Acceptance Record Requirements

Issue #51 closeout must record:

| Field                                          | Required closeout evidence                                                              |
| ---------------------------------------------- | --------------------------------------------------------------------------------------- |
| Status                                         | Explicit final Phase 4 state                                                            |
| Reviewer                                       | Repository owner                                                                        |
| Review date                                    | Exact review date                                                                       |
| Accepted placement matrix                      | Exact path and accepted revision                                                        |
| Accepted dependency matrix                     | Exact path and accepted revision                                                        |
| Accepted communication rules                   | Decision 4.11 and matrix sections                                                       |
| Accepted exception policy                      | Decision 4.12 and durable architecture section                                          |
| Architecture rules requiring later enforcement | Durable Promotion Register enforcement rows                                             |
| Remaining bounded decisions                    | Phase 5, Phase 6, Phase 7, Goal 6, standards, implementation, and verification handoffs |
| Validation                                     | Exact commands, environment, exit codes, and evidence hashes                            |
| Result                                         | Explicit repository-owner acceptance or identified blocker                              |

Agents may prepare this evidence but may not attribute repository-owner review or acceptance to themselves.

## 13. Related

- [Goal 3 Index](../index.md)
- [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
- [Phase 3 Target Repository Tree Index](../phase-3/index.md)
- [Artifact Placement Matrix](artifact-placement-matrix.md)
- [Dependency And Communication Matrix](dependency-and-communication-matrix.md)
- [Durable Promotion Register](durable-promotion-register.md)
- [Definitions Index](../../../../Definitions/Index.md)
- [Application Registration System Definition](../../../../Definitions/Application-Registration/Definition.md)
- [Repository Architecture](../../../../../03-architecture/repository-architecture.md)
- [Application Registration](../../../../../03-architecture/application-registration.md)
- [System Overview](../../../../../03-architecture/system-overview.md)
- [Stack Overview](../../../../../03-architecture/stack-overview.md)
- GitHub Phase 4 issue: [#51](https://github.com/kyleswindell/login-v2/issues/51)
- GitHub Phase 5 issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
