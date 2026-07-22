<!--
DOC-META
title: Phase 7 Durable Promotion Register
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/durable-promotion-register.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/7-7-architecture-rule-promotion.md
template: docs/09-reference/templates/docs/_planning.md
summary: Tracks promotion of accepted Goal 3 architecture rules into canonical repository documentation, standards, agent instructions, public Contracts, and automated guardrails.
-->

# Phase 7 Durable Promotion Register

Parent: [Phase 7.7 Architecture Rule Promotion](7-7-architecture-rule-promotion.md)

## 1. Purpose

Track every accepted Goal 3 rule that requires durable representation outside milestone planning.

This register distinguishes:

* immediate promotions required before Goal 3 acceptance;
* confirmation of already durable rules;
* later-owner canonical handoffs;
* automated enforcement that follows canonical documentation.

A rule is not durably promoted merely because it appears in Goal 3 planning.

## 2. Status

* Planning lifecycle: draft
* Register state: twelve open promotion records
* Canonical edits authorized: no
* Owning GitHub issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
* Governing policy: [Phase 7.7 Architecture Rule Promotion](7-7-architecture-rule-promotion.md)

## 3. Register Rules

Each entry must:

* state one durable rule;
* identify the Goal 3 source establishing it;
* identify one canonical owner;
* specify the promotion form;
* state whether it is required before Goal 3 acceptance;
* define validation;
* identify the promotion owner;
* identify prohibited drift;
* preserve acceptance evidence.

A validator or `AGENTS.md` instruction may enforce or summarize a rule but must not silently become its only canonical source.

## 4. Promotion Register

| Promotion ID  | Durable rule                                                                                                                                                                                                              | Current durable coverage                                                                                                                                                                     | Target canonical owner                                                                                                                                         | Promotion owner                                                                                  | Goal 3 treatment                                                                                                                                     | Status     |
| ------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------ | ---------------------------------------------------------------------------------------------------------------------------------------------------- | ---------- |
| `P7-PROM-001` | Required capabilities belong in Core; `Modules/` is reserved for optional, independently managed packages                                                                                                                 | Partial — ADR-0005 and root `AGENTS.md` establish the ownership taxonomy, Core independence, and optional Module requirements, but do not fully define the accepted Goal 3 physical topology | Proposed `docs/03-architecture/repository-architecture.md`, root `AGENTS.md`, and an applicable Module architecture or packaging standard                      | Goal 08, repository architecture owner, and Module lifecycle owner                               | Accept the Core/Module topology and hand off exact canonical topology promotion; ADR-0005 remains the ownership decision                             | Handed off |
| `P7-PROM-002` | Behavior and artifacts follow precise owners; generic Platform, Surface, Shared, Common, Support, Service, or Manager destinations are prohibited without an accepted precise meaning                                     | Partial — ADR-0005 retires Platform and Surface as ownership terms, but a complete owner-local placement and generic-name prohibition is not yet durable                                     | Proposed `docs/03-architecture/repository-architecture.md`, a Goal 08 repository placement and naming standard, and concise root `AGENTS.md` guidance          | Goal 08, repository architecture owner, and naming-standard owner                                | Accept the precise-owner rule and hand off the architecture summary, repeatable placement standard, and agent guidance                               | Handed off |
| `P7-PROM-003` | Application Registration compiles and routes owner declarations; Host Registries retain acceptance and resolution authority                                                                                               | Planning-only — no sufficient canonical Application Registration and Host-authority source currently exists                                                                                  | Proposed `docs/03-architecture/repository-architecture.md` and the future Goal 04 Application Registration canonical Contract                                  | Goal 04, Goal 08, Application Registration owner, and applicable Host owners                     | Accept the architectural division; hand off durable architecture promotion to Goal 08 and executable Contract design to Goal 04                      | Handed off |
| `P7-PROM-004` | The persistent Frame is limited to Global Header Navigation, Sidebar Navigation, and Main; UI renders normalized data while Workspace, Navigation, Access, Module lifecycle, and Product owners resolve application state | Partial — ADR-0005 and root `AGENTS.md` protect reusable UI ownership, but root `AGENTS.md` still presents `Shell` as one Core capability and requires bounded reconciliation                | Proposed `docs/03-architecture/repository-architecture.md`, applicable Goal 05 UI and Layout standards, root and scoped `AGENTS.md`, and accepted UI Contracts | Goal 05, Goal 08, UI owner, Workspace owner, Navigation owner, and repository architecture owner | Correct the current root `AGENTS.md` Shell contradiction before final Goal 3 acceptance; hand off detailed Frame and UI promotion to Goals 05 and 08 | Handed off |
| `P7-PROM-005` | Navigation visibility is not authorization                                                                                                                                                                                | Insufficient — current authorization rules exist, but the independence of navigation visibility and authorization is not stated clearly in durable architecture or agent instructions        | Proposed `docs/03-architecture/repository-architecture.md`, future Access and Navigation Contracts, and concise root or scoped `AGENTS.md` guidance            | Goals 07, 08, and 10; Navigation owner; Access owner; repository architecture owner              | Accept the separation rule and hand off canonical promotion, public Contract expression, and allowed-and-denied verification                         | Handed off |
| `P7-PROM-006` | Laravel root directories are restricted integration boundaries; owner-specific behavior remains owner-local                                                                                                               | Insufficient — current durable sources permit Laravel artifacts but do not define the accepted restrictions for `bootstrap/`, Providers, HTTP, Console, routes, and config                   | Proposed `docs/03-architecture/repository-architecture.md` and concise root `AGENTS.md` guidance                                                               | Goal 08, repository architecture owner, and Laravel integration owners                           | Accept the restricted-root rule and hand off one consolidated canonical Laravel-boundary section and corresponding agent guidance                    | Handed off |
| `P7-PROM-007` | Cross-owner collaboration uses public Contracts, Queries, Events, approved read models, or Contributions; private implementation and direct persistence access are prohibited                                             | Partial — ADR-0005 and root `AGENTS.md` establish public-contract Module dependencies and owner separation, but do not fully govern all Core-to-Core and persistence interactions            | Proposed `docs/03-architecture/repository-architecture.md`, future Goal 07 owner Contracts, root `AGENTS.md`, and Goal 10 dependency guardrails                | Goals 07, 08, and 10; repository architecture owner; applicable capability and Module owners     | Accept the full cross-owner rule and hand off canonical promotion, public Contract design, and deterministic dependency enforcement                  | Handed off |
| `P7-PROM-008` | Core Runtime remains narrow and does not become a service locator, configuration bag, Workspace owner, Product resolver, Navigation owner, Module-availability owner, or generic coordination layer                       | Planning-only — no durable source currently contains the full accepted Runtime responsibility and exclusion boundary                                                                         | Proposed `docs/03-architecture/repository-architecture.md` and a future Core Runtime canonical Contract                                                        | Goals 07 and 08, Runtime owner, and repository architecture owner                                | Accept the narrow Runtime boundary and hand off canonical architecture promotion and later public Contract design                                    | Handed off |
| `P7-PROM-009` | Persistence artifacts and data follow capability or Module ownership; shared consumption does not create shared ownership                                                                                                 | Partial planning and ownership coverage; detailed persistence organization remains intentionally assigned to Goal 06                                                                         | Goal 06 canonical persistence architecture and standards, with a concise repository-architecture summary and applicable persistence guardrails                 | Goal 06, applicable persistence owners, and Goal 10 for guardrails                               | Preserve the accepted Goal 3 ownership boundary and hand off detailed durable promotion to Goal 06                                                   | Handed off |
| `P7-PROM-010` | Accepted reusable UI public Contracts and their verification baselines remain protected; Product presentation remains Product-owned                                                                                       | Partial to strong — ADR-0005, root `AGENTS.md`, accepted UI Contracts, UI inventory, and current UI standards already establish substantial durable coverage                                 | Applicable `docs/02-standards/ui/` canonical sources, UI artifact Contracts, scoped `AGENTS.md`, and Goal 10 verification architecture                         | Goals 05 and 10, UI owner, and applicable Product owners                                         | Confirm existing protection, reconcile superseded terminology where necessary, and hand off detailed UI and verification promotion                   | Handed off |
| `P7-PROM-011` | Compatibility is opt-in and architecture exceptions require explicit acceptance; temporary migration states do not become target architecture                                                                             | Phase 7 planning-only as a consolidated migration rule; no permanent Goal 09 migration source yet owns it                                                                                    | Goal 09 canonical migration architecture or standard, with a concise repository-architecture summary                                                           | Goal 09 and repository architecture owner                                                        | Accept the Phase 7 policy and hand off compatibility implementation, exception handling, removal, and cleanup standards to Goal 09                   | Handed off |
| `P7-PROM-012` | Verification follows accepted owners and public behavior; current non-UI tests do not independently define target architecture                                                                                            | Partial — root `AGENTS.md` contains general test rules, but the accepted target verification ownership and historical-test authority rules remain Goal 10 work                               | Goal 10 canonical verification architecture and standards, with a concise repository-architecture summary and applicable `AGENTS.md` guidance                  | Goal 10, repository architecture owner, and applicable capability, Module, and UI owners         | Accept the verification ownership boundary and hand off exact suites, commands, fixtures, environments, and guardrails to Goal 10                    | Handed off |

## 5. Detailed Promotion Records

### `P7-PROM-001` — Core And Optional Module Topology

* Current accepted sources:

  * Goal 3 target architecture;
  * Phase 7 direction matrix rows `P7-MAP-009` and `P7-MAP-015` through `P7-MAP-024`.
* Target canonical owners:

  * `docs/03-architecture/repository-architecture.md`;
  * root `AGENTS.md`;
  * applicable Module architecture or packaging standard.
* Promotion requirement:

  * state required capability placement;
  * define optional Module qualification;
  * prohibit required-Core-as-Module scaffolding.
* Validation:

  * documentation reconciliation;
  * namespace and path guardrail proposal;
  * Module removability Contract in later implementation.
* Prohibited drift:

  * treating physical presence under `Modules/` as target authority;
  * converting Platform-management prototypes into Modules automatically.
* Status: Open
* Evidence:

### `P7-PROM-002` — Precise Ownership And Generic-Owner Prohibition

* Current accepted sources:

  * Goal 3 ownership model;
  * Phase 5 naming decisions;
  * Phase 7 matrix.
* Target canonical owners:

  * repository architecture;
  * repository naming standard;
  * root and applicable scoped `AGENTS.md`.
* Promotion requirement:

  * define owner-local placement;
  * distinguish shared use from shared ownership;
  * prohibit generic destination names without accepted semantics.
* Validation:

  * documentation terminology scan;
  * deterministic prohibited-path and prohibited-namespace guardrails where reliable.
* Prohibited drift:

  * creating renamed Platform or Surface buckets;
  * using `Support`, `Services`, or `Managers` to avoid ownership.
* Status: Open
* Evidence:

### `P7-PROM-003` — Application Registration And Host Authority

* Current accepted sources:

  * Goal 3 target architecture;
  * Phase 6 representative architecture;
  * matrix rows `P7-MAP-010` through `P7-MAP-012` and `P7-MAP-037`.
* Target canonical owners:

  * repository architecture;
  * Goal 4 Application Registration Contract.
* Promotion requirement:

  * distinguish declarations, compilation, framework registration, Host acceptance, and behavior ownership.
* Validation:

  * canonical documentation review;
  * later public Contract tests;
  * dependency-direction validation.
* Prohibited drift:

  * central registrar owning Product behavior;
  * Application Registration deciding authorization or Host ordering.
* Status: Open
* Evidence:

### `P7-PROM-004` — Frame, UI, And Product Ownership

* Current accepted sources:

  * Goal 3 target architecture;
  * Phase 6 accepted representative architecture;
  * matrix rows `P7-MAP-038` through `P7-MAP-043`.
* Target canonical owners:

  * repository architecture;
  * applicable UI architecture and Layout standards;
  * scoped UI `AGENTS.md`.
* Promotion requirement:

  * retain the narrow Frame;
  * preserve reusable UI ownership;
  * assign application-state resolution outside UI.
* Validation:

  * documentation reconciliation;
  * UI Contract checks;
  * browser and manual review in later implementation.
* Prohibited drift:

  * app Layout resolving permissions, Products, or Workspace state;
  * UI owning Product behavior.
* Status: Open
* Evidence:

### `P7-PROM-005` — Navigation Is Not Authorization

* Current accepted sources:

  * Goal 3 target architecture;
  * Phase 6 architecture validation.
* Target canonical owners:

  * repository architecture;
  * Access and Navigation public Contracts;
  * applicable `AGENTS.md`.
* Promotion requirement:

  * state the independence of rendering eligibility and authorization.
* Validation:

  * canonical documentation review;
  * later allowed and denied authorization tests;
  * Navigation Contract tests.
* Prohibited drift:

  * using hidden links as access control;
  * granting access because a Product is visible.
* Status: Open
* Evidence:

### `P7-PROM-006` — Restricted Laravel Integration Roots

* Current accepted sources:

  * Goal 3 target architecture;
  * matrix rows `P7-MAP-025` through `P7-MAP-037`.
* Target canonical owners:

  * repository architecture;
  * root `AGENTS.md`.
* Promotion requirement:

  * define permitted root integration responsibilities;
  * require owner-local feature behavior;
  * retain sparse composition entrypoints.
* Validation:

  * documentation review;
  * root-path ownership guardrails where deterministic.
* Prohibited drift:

  * re-centralizing owner behavior under root Controllers, Providers, routes, commands, or configuration.
* Status: Open
* Evidence:

### `P7-PROM-007` — Cross-Owner Public Boundaries

* Current accepted sources:

  * Goal 3 dependency rules;
  * matrix rows `P7-MAP-012`, `P7-MAP-037`, and `P7-MAP-049`.
* Target canonical owners:

  * repository architecture;
  * root `AGENTS.md`;
  * Goal 10 architecture guardrails;
  * public owner Contracts.
* Promotion requirement:

  * define permitted collaboration patterns;
  * prohibit private implementation and direct persistence access.
* Validation:

  * dependency checks;
  * namespace checks;
  * public Contract tests.
* Prohibited drift:

  * generic shared-owner abstractions;
  * direct Model or table access justified only by convenience.
* Status: Open
* Evidence:

### `P7-PROM-008` — Narrow Core Runtime

* Current accepted sources:

  * Phase 6 acceptance;
  * matrix row `P7-MAP-001`.
* Target canonical owners:

  * repository architecture;
  * Core Runtime public Contract.
* Promotion requirement:

  * define Runtime responsibilities and explicit non-responsibilities.
* Validation:

  * architecture documentation review;
  * dependency and Contract checks in Runtime implementation.
* Prohibited drift:

  * service locator;
  * configuration bag;
  * Workspace or Product resolution;
  * Module availability ownership.
* Status: Open
* Evidence:

### `P7-PROM-009` — Persistence Ownership

* Current accepted sources:

  * Goal 3 target architecture;
  * matrix rows `P7-MAP-044` through `P7-MAP-049`.
* Target canonical owners:

  * Goal 6 persistence architecture and standards;
  * repository architecture summary.
* Promotion requirement:

  * preserve capability and Module ownership;
  * define framework discovery without central ownership;
  * define cross-owner persistence boundaries.
* Validation:

  * Goal 6 reconciliation;
  * PostgreSQL and migration verification;
  * persistence guardrails.
* Prohibited drift:

  * shared ownership from shared consumption;
  * Module lifecycle deciding Core table ownership.
* Status: Open — later-owner handoff
* Evidence:

### `P7-PROM-010` — UI Contract Protection

* Current accepted sources:

  * accepted UI inventory and UI Contracts;
  * Goal 3 target architecture;
  * matrix rows `P7-MAP-038`, `P7-MAP-041`, `P7-MAP-042`, and `P7-MAP-051`.
* Target canonical owners:

  * applicable UI standards;
  * UI artifact Contracts;
  * scoped UI `AGENTS.md`;
  * Goal 10 protected verification architecture.
* Promotion requirement:

  * confirm existing protection;
  * reconcile any superseded terminology;
  * preserve owner boundaries.
* Validation:

  * UI documentation and Contract review;
  * accepted test and fixture hashes;
  * browser and accessibility review as applicable.
* Prohibited drift:

  * weakening accepted UI proof;
  * promoting Product presentation into reusable UI solely because it is reused.
* Status: Open — later-owner handoff
* Evidence:

### `P7-PROM-011` — Compatibility And Exceptions

* Current accepted sources:

  * Phase 7.4 compatibility requirements;
  * Phase 7.5 intentional architecture exceptions.
* Target canonical owners:

  * Goal 9 migration architecture or standard;
  * repository architecture summary.
* Promotion requirement:

  * define opt-in compatibility;
  * define explicit exception acceptance;
  * define bounded removal and review.
* Validation:

  * Goal 9 canonical-source review;
  * compatibility and exception register reconciliation.
* Prohibited drift:

  * silent aliases;
  * indefinite temporary architecture;
  * migration convenience becoming a permanent exception.
* Status: Open — later-owner handoff
* Evidence:

### `P7-PROM-012` — Verification Ownership

* Current accepted sources:

  * Phase 7 direction matrix rows `P7-MAP-050` through `P7-MAP-052`;
  * accepted verification-first direction.
* Target canonical owners:

  * Goal 10 verification architecture and standards;
  * repository architecture summary;
  * applicable `AGENTS.md`.
* Promotion requirement:

  * preserve owner-based public-behavior verification;
  * preserve accepted UI evidence;
  * distinguish historical tests from target authority.
* Validation:

  * Goal 10 acceptance;
  * verification architecture checks;
  * protected baseline controls.
* Prohibited drift:

  * tests inventing architecture;
  * current tests preserving rejected implementation by default;
  * weakening accepted UI verification.
* Status: Open — later-owner handoff
* Evidence:

## 6. Promotion Statuses

```text
Open
Promotion work or confirmation has not yet been completed.

Promoted
The rule was added to its durable canonical owner and accepted.

Confirmed
The existing durable source already represented the rule accurately.

Handed off
A later canonical owner accepted responsibility with explicit boundaries.

Superseded
A later accepted architecture decision replaced the rule.

Withdrawn
The rule no longer requires promotion.
```

Status changes must include evidence.

## 7. Goal 3 Acceptance Gate

Before final Goal 3 acceptance:

- `P7-PROM-001` through `P7-PROM-008` must have accepted downstream promotion handoffs;
- each record must identify current durable coverage;
- each record must identify one target canonical owner;
- each record must identify the Goal or owner responsible for promotion;
- prohibited drift must be explicit;
- direct contradictions in current higher-authority repository sources must be corrected or recorded as acceptance blockers;
- `P7-PROM-009` through `P7-PROM-012` must have explicit later-owner assignments;
- no private Project workflow may be represented as canonical repository authority.

Goal 3 acceptance does not require Goal 08 promotion implementation, new public Contracts, or automated guardrails to be complete.

Handed off
Phase 7 accepted the durable rule, its canonical destination, its downstream owner, and its prohibited drift. Promotion implementation remains downstream work.

## 8. Validation

Before Phase 7.7 acceptance:

* confirm all twelve durable rules are represented;
* confirm each entry has one canonical owner;
* confirm immediate versus later-owner status is correct;
* confirm promotion forms are explicit;
* confirm prohibited drift is recorded;
* confirm private workflow is excluded from automatic promotion;
* confirm no canonical repository edits are authorized by this register alone;
* run `npm run lint:docs:guardrails`;
* run `git diff --check`.

## 9. Acceptance Record

* Outcome:
* Date:
* Accepted or rejected by:
* Required-before-acceptance promotions:
* Later-owner promotion handoffs:
* Required corrections:
* Validation evidence:
* Downstream handoff:

## 10. Related

* [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)
* [Phase 7.2 Current-To-Target Placement Mappings](7-2-current-to-target-placement-mappings.md)
* [Phase 7.6 Later-Owner Decisions](7-6-later-owner-decisions.md)
* [Phase 7.7 Architecture Rule Promotion](7-7-architecture-rule-promotion.md)
* [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md)
* [Later-Owner Decision Register](later-owner-decision-register.md)
* [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
* [Repository Architecture](../../../../../03-architecture/repository-architecture.md)
* [Repository Naming Standards](../../../../../02-standards/coding/repository-naming-standards.md)
* GitHub Phase 7 issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* GitHub parent Goal 3 issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
