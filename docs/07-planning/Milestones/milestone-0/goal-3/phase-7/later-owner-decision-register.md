<!--
DOC-META
title: Phase 7 Later-Owner Decision Register
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/later-owner-decision-register.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/7-6-later-owner-decisions.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records bounded implementation and design decisions assigned to later owners after Goal 3 ownership and migration direction have been established.
-->

# Phase 7 Later-Owner Decision Register

Parent: [Phase 7.6 Later-Owner Decisions](7-6-later-owner-decisions.md)

## 1. Purpose

Record bounded implementation and design decisions assigned to later owners.

Each entry represents a matter whose architectural owner and direction are already established but whose exact implementation requires later accepted work.

Open entries do not block Goal 3 acceptance unless the register explicitly states otherwise.

## 2. Status

* Planning lifecycle: draft
* Register state: six open later-owner decisions
* Goal 3 ownership decisions remaining: none
* Implementation authorized: no
* Owning GitHub issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
* Governing policy: [Phase 7.6 Later-Owner Decisions](7-6-later-owner-decisions.md)

## 3. Register Rules

Each entry must:

* identify a stable decision ID;
* identify the already accepted owner;
* preserve the accepted current-to-target direction;
* state exactly what remains unresolved;
* define allowed and prohibited outcomes;
* identify governing sources;
* identify one later owner;
* define required proof;
* identify the work blocked by the open decision;
* preserve review authority;
* link accepted resolution evidence when closed.

No entry may be used to defer an unresolved Goal 3 ownership decision.

## 4. Open Later-Owner Decisions

| Decision ID  | Subject                                                    | Accepted owner and direction                                                                                                                                       | Decision remaining                                                                                                      | Allowed outcomes                                                                                                                      | Prohibited outcomes                                                                                                                       | Later owner                                                                   | Blocking scope                                                                     | Status |
| ------------ | ---------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- | ------ |
| `P7-LOD-001` | Internal decomposition of `Modules/Account/`               | Split across applicable Account, Identity, Auth, Access, Preferences, Security, and presentation owners; required behavior does not remain a Module                | Exact responsibility boundaries, public Contracts, class placement, and migration slices                                | Bounded owner-local decomposition consistent with accepted capability ownership                                                       | Retaining a mixed required `Modules/Account/` umbrella or recreating generic ownership                                                    | Applicable capability design and implementation issues; Goals 6, 7, 9, and 10 | Account migration and implementation work requiring exact responsibility placement | Open   |
| `P7-LOD-002` | Global Administration Workspace URL and route structure    | Global Administration is a Workspace; routes remain owner- and Product-specific; shared `/admin/*` is rejected                                                     | Exact URLs, route names, nesting, entry routes, navigation labels, and fallback behavior                                | One coherent Workspace route design preserving separate Product owners                                                                | Generic administration ownership, automatic `/platform/*` compatibility, or shared `/admin/*` umbrella                                    | Workspace, Navigation, and applicable Product route-design issue              | Global Administration routing, navigation wiring, and route-level verification     | Open   |
| `P7-LOD-003` | Core persistence migration organization                    | Core persistence remains capability-owned and Laravel-discoverable; optional Module artifacts remain package-local                                                 | Exact migration folder structure, naming, registration, rollback organization, factory placement, and seeder placement  | Goal 6-compliant owner-governed organization compatible with Laravel discovery                                                        | Shared table ownership, Module lifecycle ownership of Core schemas, or ownerless persistence placement                                    | Goal 6 and applicable persistence owners                                      | Physical persistence reorganization and migration implementation                   | Open   |
| `P7-LOD-004` | Target verification architecture                           | Verification becomes owner-local and cross-owner based on accepted requirements; accepted UI proof remains protected; current non-UI tests are historical evidence | Exact test directories, suites, commands, fixtures, database strategy, browser harness, and shared validation structure | Verification-first architecture with public-behavior proofs and explicit cross-owner checks                                           | Preserving obsolete behavior only because current tests expect it, weakening accepted UI proof, or using tests to invent architecture     | Goal 10 and applicable implementation owners                                  | New target-state test implementation, shared harnesses, and full-suite migration   | Open   |
| `P7-LOD-005` | M0 inventory tooling lifecycle                             | Accepted evidence remains immutable; current pinned-baseline tooling is not automatically a permanent live validator                                               | Which tools remain for reproduction, become durable validators, are archived, or are removed                            | Explicit per-tool retain, generalize, archive, or remove decision with evidence preservation                                          | Repinning accepted evidence, treating projections as authority, or silently converting issue-specific tooling into permanent architecture | Phase 7 reconciliation, Goal 10, repository tooling, and Goal 9 cleanup       | Final disposition and cleanup of repository and UI inventory tooling               | Open   |
| `P7-LOD-006` | Contract-level disposition under `app/Surfaces/Contracts/` | Generic Surface ownership is removed; Contracts survive only under a proven owner-specific responsibility                                                          | Whether an individual Contract survives, its owner, public shape, target path, verification, and removal sequence       | Rewrite under Navigation, Workspace, Dashboard, UI, or applicable Product owner when responsibility is proven; otherwise remove later | Retaining generic Surface as owner, preserving unused Contracts by default, or creating ownerless shared abstractions                     | Applicable Contract owner and Goal 9 cleanup                                  | Migration or removal of each specific current Surface Contract                     | Open   |

## 5. Detailed Decision Records

### `P7-LOD-001` — `Modules/Account/` Decomposition

* Accepted owner: applicable Account, Identity, Auth, Access, Preferences, Security, and presentation owners
* Accepted direction: Split
* Governing matrix row: `P7-MAP-017`
* Decision remaining:

  * exact responsibility allocation;
  * public Contract boundaries;
  * owner-local paths;
  * persistence ownership;
  * presentation ownership;
  * verification slices.
* Required proof:

  * architecture responsibility review;
  * dependency-direction validation;
  * security and authorization proof;
  * persistence-boundary proof;
  * target verification Contracts.
* Review authority: repository owner and applicable capability owners
* Resolution evidence:
* Status: Open

### `P7-LOD-002` — Global Administration Workspace Routes

* Accepted owner: Workspace, Navigation, and applicable Product owners
* Accepted direction: Replace current `/platform/*`; reject shared `/admin/*`
* Governing matrix row: `P7-MAP-031`
* Decision remaining:

  * exact route hierarchy;
  * exact route names;
  * Workspace entry;
  * Product route families;
  * navigation integration;
  * fallback behavior.
* Required proof:

  * route inventory and collision validation;
  * authorization proof;
  * Navigation Contract proof;
  * browser and manual UX review where applicable.
* Review authority: repository owner and Workspace or route-design authority
* Resolution evidence:
* Status: Open

### `P7-LOD-003` — Core Persistence Migration Organization

* Accepted owner: Goal 6 and applicable capability owners
* Accepted direction: owner-governed and Laravel-discoverable
* Governing matrix rows:

  * `P7-MAP-044`;
  * `P7-MAP-045`;
  * `P7-MAP-046`;
  * `P7-MAP-047`;
  * `P7-MAP-048`;
  * `P7-MAP-049`.
* Decision remaining:

  * exact Core migration organization;
  * registration and discovery;
  * factory and seeder organization;
  * rollback and ownership validation.
* Required proof:

  * PostgreSQL migration and rollback proof;
  * ownership and dependency validation;
  * retained-data and constraint review;
  * repository guardrails.
* Review authority: repository owner and Goal 6 persistence authority
* Resolution evidence:
* Status: Open

### `P7-LOD-004` — Target Verification Architecture

* Accepted owner: Goal 10 and applicable capability, Module, UI, and repository-tooling owners
* Accepted direction: replace current non-UI suite authority; retain accepted UI Contract proof
* Governing matrix rows:

  * `P7-MAP-050`;
  * `P7-MAP-051`;
  * `P7-MAP-052`.
* Decision remaining:

  * directory layout;
  * suite boundaries;
  * exact commands;
  * shared fixtures;
  * database strategy;
  * browser strategy;
  * architecture validation;
  * native-environment requirements.
* Required proof:

  * accepted verification architecture;
  * minimal vertical-slice self-proof;
  * deterministic repository validation;
  * protected UI verification baseline.
* Review authority: repository owner and Goal 10 verification authority
* Resolution evidence:
* Status: Open

### `P7-LOD-005` — M0 Inventory Tooling Lifecycle

* Accepted owner: repository tooling, Phase 7 reconciliation, Goal 10, and Goal 9 cleanup
* Accepted direction: preserve accepted evidence; classify tooling individually
* Governing matrix rows:

  * `P7-MAP-057`;
  * `P7-MAP-058`;
  * `P7-MAP-059`.
* Decision remaining:

  * historical reproduction requirements;
  * permanent guardrail candidates;
  * archival paths;
  * removal timing;
  * generalized target-state validation opportunities.
* Required proof:

  * evidence hash preservation;
  * authority separation;
  * deterministic output validation;
  * changed-path and cleanup verification.
* Review authority: repository owner and repository-tooling authority
* Resolution evidence:
* Status: Open

### `P7-LOD-006` — Surviving Surface Contracts

* Accepted owner: applicable Navigation, Workspace, Dashboard, UI, or Product owner
* Accepted direction: remove generic Surface ownership
* Governing matrix row: `P7-MAP-004`
* Decision remaining:

  * whether each Contract represents a surviving responsibility;
  * accepted owner;
  * target Contract shape;
  * target path;
  * verification;
  * removal sequence.
* Required proof:

  * current consumer evidence;
  * target owner acceptance;
  * public Contract tests where retained;
  * no-use proof and dependent cleanup validation where removed.
* Review authority: repository owner and applicable Contract owner
* Resolution evidence:
* Status: Open

## 6. Resolved Decisions

None.

| Decision ID | Resolution                        | Accepted owner | Resolution evidence | Accepted by | Accepted at |
| ----------- | --------------------------------- | -------------- | ------------------- | ----------- | ----------- |
| —           | No resolved later-owner decisions | —              | —                   | —           | —           |

## 7. Entry Template

```text
Decision ID:
Subject:
Accepted owner:
Accepted direction:
Decision remaining:
Allowed outcomes:
Prohibited outcomes:
Governing sources:
Later owner:
Required proof:
Blocking scope:
Review authority:
Status: open
Resolution:
Resolution evidence:
Accepted by:
Accepted at:
```

Use identifiers in this form:

```text
P7-LOD-007
P7-LOD-008
```

Identifiers must not be reused after resolution, withdrawal, or supersession.

## 8. Resolution Statuses

```text
Open
The accepted owner and direction are known, but the bounded detail remains unresolved.

Resolved
An accepted later source answers the decision and preserves Goal 3.

Superseded
A later accepted architecture decision replaced the decision boundary.

Withdrawn
The decision is no longer required and no implementation depends on it.
```

A status change must preserve historical context and resolution evidence.

## 9. Register Review Rules

Review this register when:

* a downstream issue needs one of the unresolved details;
* an accepted architecture source resolves an entry;
* Goal 6 establishes persistence organization;
* Goal 9 establishes migration or cleanup sequencing;
* Goal 10 establishes target verification architecture;
* a proposed implementation would exceed allowed outcomes;
* compatibility or architecture-exception evidence emerges;
* final Goal 3 reconciliation identifies an omitted later-owner decision.

Do not mark an entry resolved based only on implementation appearing in a branch.

Resolution requires accepted authority.

## 10. Validation

Before Phase 7.6 acceptance:

* confirm the six open decisions match the direction matrix;
* confirm each accepted owner and direction is explicit;
* confirm no entry defers Goal 3 ownership;
* confirm allowed and prohibited outcomes are bounded;
* confirm each later owner and blocking scope is explicit;
* confirm required proof and review authority are present;
* confirm no entry creates compatibility or an architecture exception;
* confirm no physical migration or implementation is authorized;
* run `npm run lint:docs:guardrails`;
* run `git diff --check`.

## 11. Acceptance Record

* Outcome:
* Date:
* Accepted or rejected by:
* Open later-owner decisions:
* Resolved later-owner decisions:
* Required corrections:
* Validation evidence:
* Downstream handoff:

## 12. Related

* [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)
* [Phase 7.2 Current-To-Target Placement Mappings](7-2-current-to-target-placement-mappings.md)
* [Phase 7.3 Migration Classification](7-3-migration-classification.md)
* [Phase 7.4 Compatibility Requirements](7-4-compatibility-requirements.md)
* [Phase 7.5 Intentional Architecture Exceptions](7-5-intentional-architecture-exceptions.md)
* [Phase 7.6 Later-Owner Decisions](7-6-later-owner-decisions.md)
* [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md)
* [Compatibility Register](compatibility-register.md)
* [Architecture Exception Register](architecture-exception-register.md)
* [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
* GitHub Phase 7 issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* GitHub parent Goal 3 issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
