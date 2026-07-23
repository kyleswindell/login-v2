<!--
DOC-META
title: Phase 7.6 Later-Owner Decisions
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/7-6-later-owner-decisions.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines which implementation and design details may be assigned to later owners without reopening accepted Goal 3 ownership, placement, dependency, or migration direction.
-->

# Phase 7.6 Later-Owner Decisions

Parent: [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)

## 1. Purpose

Define which unresolved implementation and design details may be assigned to later Goals, issues, capability owners, Module owners, UI owners, repository-tooling owners, or operational owners.

A later-owner decision is a bounded detail whose:

* architectural owner is already accepted;
* target direction is already accepted;
* governing constraints are already known;
* resolution does not block Goal 3 acceptance.

Later-owner assignment preserves the accepted Goal 3 architecture. It does not authorize the later owner to reconsider ownership, create a generic destination, introduce compatibility, or establish an architecture exception without separate review.

## 2. Status

* Planning lifecycle: draft
* Decision state: proposed for repository-owner Phase 7 review
* Implementation state: planning only
* Later implementation authorized: no
* Register: [Later-Owner Decision Register](later-owner-decision-register.md)
* Owning GitHub issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
* Depends on:

  * accepted Goal 3 Phases 1 through 6;
  * Phase 7.1 mapping scope;
  * reconciled Phase 7.2 direction matrix;
  * Phase 7.3 migration classification;
  * Phase 7.4 compatibility requirements;
  * Phase 7.5 intentional architecture exceptions.

## 3. Later-Owner Policy

A matter may be assigned to a later owner only when all of the following are true:

1. the responsible architectural owner is established;
2. the accepted current-to-target direction is established;
3. the unresolved matter concerns implementation detail rather than ownership;
4. permitted and prohibited outcomes are understandable;
5. the decision can be resolved within a bounded later issue;
6. deferral does not require compatibility or an architecture exception;
7. Goal 3 acceptance does not depend on selecting the exact implementation now.

The default rule is:

```text
Later owners may refine implementation.
Later owners may not reopen accepted architecture.
```

## 4. Qualifying Later-Owner Decisions

A later-owner decision may include:

* exact internal class decomposition;
* exact owner-local folder organization;
* detailed public Contract shape within accepted boundaries;
* exact Laravel-discoverable migration organization;
* exact route hierarchy within an accepted Product or Workspace owner;
* exact target test-suite layout;
* exact verification commands;
* detailed migration sequence;
* temporary implementation adapters that do not create accepted compatibility;
* tooling archival or generalization timing;
* exact cleanup issue boundaries;
* whether a potentially surviving current Contract is rewritten under its proven owner.

These matters remain subject to the applicable canonical architecture, naming, security, persistence, UI, and verification standards.

## 5. Matters That Cannot Be Deferred As Later-Owner Decisions

The following require Goal 3 resolution or another accepted architecture decision and must not be hidden in this register:

* whether a responsibility belongs to Core, a Module, UI, Delivery, persistence, or repository tooling;
* whether required application behavior may remain under `Modules/`;
* whether generic Platform, Surface, Shared, Common, Support, Service, or Manager ownership is permitted;
* whether cross-owner private implementation access is allowed;
* whether Application Registration or a Host Registry owns behavior;
* whether Navigation visibility establishes authorization;
* whether the Frame owns Product behavior;
* whether compatibility is required;
* whether the target architecture may be intentionally violated;
* whether persistent data ownership changes;
* whether accepted UI public Contracts may be broken;
* whether obsolete code may be deleted without separate cleanup authorization.

An unresolved matter that could produce materially different owners or dependency directions is not a later-owner detail.

## 6. Register Contract

Every later-owner decision must contain:

| Field               | Requirement                                                                       |
| ------------------- | --------------------------------------------------------------------------------- |
| Decision ID         | Stable identifier such as `P7-LOD-001`                                            |
| Subject             | Exact unresolved implementation or design matter                                  |
| Accepted owner      | Capability, Module, UI, repository, or operational owner already established      |
| Accepted direction  | Target direction that may not be reopened                                         |
| Decision remaining  | Exact detail the later owner must resolve                                         |
| Allowed outcomes    | Bounded outcomes consistent with Goal 3                                           |
| Prohibited outcomes | Results that would reopen or violate Goal 3                                       |
| Governing sources   | Accepted architecture, standard, matrix row, or planning source                   |
| Later owner         | Goal, issue, or named ownership area accountable for resolution                   |
| Required proof      | Documentation, automated, manual, security, persistence, UI, or operational proof |
| Blocking scope      | Work that cannot proceed until the later decision is accepted                     |
| Review authority    | Authority required to accept the later decision                                   |
| Status              | Open, resolved, superseded, or withdrawn                                          |
| Resolution evidence | Accepted issue, document, PR, or repository source when resolved                  |

## 7. Initial Later-Owner Decisions

Phase 7 identifies these initial later-owner decisions:

1. internal decomposition of `Modules/Account/`;
2. exact Global Administration Workspace URL and route structure;
3. exact Core migration folder organization;
4. exact target verification architecture, test layout, and commands;
5. final archival, generalization, or removal treatment for M0 inventory tooling;
6. contract-level disposition of any responsibility currently under `app/Surfaces/Contracts/` that is proven to survive.

These decisions do not block Goal 3 because their owners and architectural constraints are established.

## 8. Decision Boundaries

### 8.1. `Modules/Account/` Decomposition

Accepted direction:

* the current package does not remain a required Module;
* responsibilities divide among Account, Identity, Auth, Access, Preferences, Security, and presentation owners;
* current `App\Modules\Account\` structure is not preserved.

The later owners may decide:

* exact class boundaries;
* public Contracts;
* owner-local folder structure;
* migration sequence;
* verification slices.

They may not recreate a mixed Account umbrella that owns unrelated capability behavior.

### 8.2. Global Administration Workspace Routes

Accepted direction:

* Global Administration is a Workspace;
* the shared `/admin/*` umbrella is rejected;
* routes follow accepted owner and Product boundaries;
* current `/platform/*` routes require no compatibility by default.

The later owner may decide:

* exact URL segments;
* route names;
* nesting;
* navigation labels;
* Workspace entry and fallback routes.

The later owner may not use URL convenience to create a new generic administration owner.

### 8.3. Core Migration Organization

Accepted direction:

* Core persistence artifacts remain owner-governed;
* migrations remain Laravel-discoverable;
* optional Module migrations remain package-local;
* central table ownership does not belong to Module lifecycle.

Goal 6 may decide:

* exact Core migration folders;
* naming;
* registration;
* rollback organization;
* owner-local factory and seeder placement.

Goal 6 may not create shared persistence ownership merely because Laravel discovers files centrally.

### 8.4. Target Verification Architecture

Accepted direction:

* the current non-UI suite is historical evidence rather than target authority;
* accepted UI Contract proof remains protected;
* verification follows owners and accepted public behavior;
* verification-first sequencing applies.

Goal 10 may decide:

* exact test folders;
* naming;
* commands;
* suites;
* shared fixtures;
* database and browser harnesses;
* cross-owner validation structure.

Goal 10 may not preserve obsolete behavior solely because a current test expects it.

### 8.5. M0 Inventory Tooling Lifecycle

Accepted direction:

* accepted reviewed evidence remains immutable historical evidence;
* generated projections remain non-authoritative;
* pinned-baseline collection tooling is not automatically a permanent live validator;
* durable target-state guardrails may be retained or rewritten.

The later owner may decide whether each tool is:

* retained for historical reproduction;
* generalized into durable validation;
* archived;
* removed through bounded cleanup.

The later owner may not regenerate accepted evidence under the same identity against a different baseline.

### 8.6. Surviving Surface Contracts

Accepted direction:

* generic Surface is not a target owner;
* `app/Surfaces/Contracts/` is removed by default;
* a Contract survives only when concrete responsibility and a valid owner are proven.

The later owner may decide:

* whether a specific Contract has surviving value;
* its exact public shape;
* its owner-local name and path;
* its verification;
* its migration and removal sequence.

The later owner may not retain a Contract under a generic Surface owner merely to avoid classifying it.

## 9. Allowed Resolution Outcomes

A later decision may resolve to:

* one bounded implementation design;
* one accepted public Contract;
* one precise owner-local path;
* one verified route or URL structure;
* one accepted migration organization;
* one target verification structure;
* one tooling lifecycle classification;
* removal when no surviving responsibility is proven.

A resolution must remain consistent with:

* the current-to-target direction matrix;
* the migration classification;
* compatibility policy;
* architecture-exception policy;
* canonical repository standards.

## 10. Prohibited Resolution Outcomes

A later decision must not:

* create a new generic ownership layer;
* preserve Platform or Surface as permanent architecture;
* treat required Core behavior as an optional Module;
* move owner behavior into Application Registration;
* move Product behavior into UI;
* use Navigation as authorization;
* create direct cross-owner implementation dependencies without accepted authority;
* add compatibility without a compatibility-register entry;
* add an architecture deviation without an exception-register entry;
* weaken accepted UI Contracts;
* repin immutable inventory evidence;
* authorize physical migration beyond the later issue’s accepted scope.

## 11. Resolution Requirements

Before a later-owner decision may be marked resolved:

1. the accepted Goal 3 boundary is cited;
2. the decision remaining is answered explicitly;
3. allowed and prohibited outcomes are reconciled;
4. affected owners and paths are identified;
5. acceptance criteria are observable;
6. proof and required environment are defined;
7. compatibility implications are reviewed;
8. architecture-exception implications are reviewed;
9. documentation synchronization is identified;
10. repository-owner or delegated canonical-owner acceptance is recorded as required.

Implementation evidence does not substitute for an accepted design decision when the decision controls public architecture.

## 12. Relationship To Readiness

An open later-owner decision blocks only work that depends on that exact detail.

It does not block:

* Goal 3 acceptance;
* unrelated capability design;
* unrelated migration planning;
* durable architecture-rule promotion;
* reconciliation of already accepted ownership and direction.

A downstream issue is not ready when it would need to invent the unresolved detail.

The later-owner register must identify that blocking scope precisely.

## 13. Relationship To Other Phase 7 Artifacts

| Artifact                           | Responsibility                                                                |
| ---------------------------------- | ----------------------------------------------------------------------------- |
| Current-to-target direction matrix | Establishes owner and migration direction                                     |
| Migration classification           | Defines the architectural relationship                                        |
| Compatibility register             | Records required continuity obligations                                       |
| Architecture exception register    | Records accepted deviations                                                   |
| Later-owner decision register      | Records bounded implementation detail assigned to a known owner               |
| Durable promotion register         | Records rules that should become permanent canonical standards                |
| Goal 9                             | Owns migration sequencing, compatibility implementation, removal, and cleanup |
| Goal 10                            | Owns target verification architecture and quality controls                    |

A later-owner record must not duplicate another register’s authority.

## 14. Proposed Decision

Accept the Phase 7 later-owner policy as follows:

* only implementation and design detail with established ownership may be deferred;
* deferred decisions may not reopen Goal 3 architecture;
* each decision must define allowed and prohibited outcomes;
* each decision must identify one later owner and its blocking scope;
* compatibility and architecture exceptions remain separately governed;
* the six initial later-owner decisions are accepted as non-blocking for Goal 3;
* implementation remains subject to a later accepted issue and verification Contract.

## 15. Validation

Before acceptance:

* confirm every registered decision has an accepted owner and direction;
* confirm no registered subject could materially change Goal 3 ownership;
* confirm allowed and prohibited outcomes are explicit;
* confirm blocking scope is bounded;
* confirm compatibility and architecture-exception matters remain separate;
* confirm all six matrix later-owner decisions appear in the register;
* confirm no physical migration or implementation is authorized;
* run `npm run lint:docs:guardrails`;
* run `git diff --check`.

## 16. Acceptance Record

* Outcome: Accepted
* Open later-owner decisions: P7-LOD-001 through P7-LOD-006
* Resolved later-owner decisions: None
* Goal 3 blocking decisions: None
* Required corrections: None
* Downstream handoff: Phase 7.7 architecture-rule promotion

## 17. Related

* [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)
* [Phase 7.2 Current-To-Target Placement Mappings](7-2-current-to-target-placement-mappings.md)
* [Phase 7.3 Migration Classification](7-3-migration-classification.md)
* [Phase 7.4 Compatibility Requirements](7-4-compatibility-requirements.md)
* [Phase 7.5 Intentional Architecture Exceptions](7-5-intentional-architecture-exceptions.md)
* [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md)
* [Compatibility Register](compatibility-register.md)
* [Architecture Exception Register](architecture-exception-register.md)
* [Later-Owner Decision Register](later-owner-decision-register.md)
* [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
* GitHub Phase 7 issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* GitHub parent Goal 3 issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
