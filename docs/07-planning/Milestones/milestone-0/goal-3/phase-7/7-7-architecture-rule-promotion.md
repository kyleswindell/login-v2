<!--
DOC-META
title: Phase 7.7 Architecture Rule Promotion
doc_type: planning
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/7-7-architecture-rule-promotion.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-7/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines how accepted Goal 3 architecture decisions are promoted from milestone planning into durable canonical repository documentation, agent instructions, standards, and automated guardrails.
-->

# Phase 7.7 Architecture Rule Promotion

Parent: [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)

## 1. Purpose

Identify accepted Goal 3 architecture rules that must remain enforceable after milestone planning is complete.

Promotion moves a durable rule from planning evidence into one or more permanent repository authorities such as:

* canonical architecture documentation;
* canonical coding, naming, UI, persistence, migration, or verification standards;
* root or scoped `AGENTS.md` instructions;
* public owner Contracts;
* deterministic repository guardrails.

Planning documents remain historical decision evidence. They must not become the only active source for rules that future implementation and Codex sessions are expected to follow.

## 2. Status

* Planning lifecycle: draft
* Decision state: proposed for repository-owner Phase 7 review
* Implementation state: planning only
* Canonical-source edits authorized: no
* Bounded reconciliation corrections: permitted only through explicit repository-owner direction
* Register: [Durable Promotion Register](durable-promotion-register.md)
* Owning GitHub issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* Parent GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
* Depends on:

  * accepted Goal 3 Phases 1 through 6;
  * reconciled Phase 7.2 direction matrix;
  * Phase 7.3 migration classification;
  * Phase 7.4 compatibility requirements;
  * Phase 7.5 architecture-exception policy;
  * Phase 7.6 later-owner decisions.

## 3. Promotion Policy

A Goal 3 rule requires durable promotion when it:

* governs future repository placement;
* determines ownership;
* constrains dependency direction;
* defines a public architectural boundary;
* prohibits a recurring invalid pattern;
* affects future scaffolding or generation;
* must guide Codex before repository writes;
* should be enforceable through deterministic validation;
* remains applicable after Goal 3 planning closes.

The default rule is:

```text
Durable architecture rules must not remain planning-only.
```

Promotion does not mean copying the full planning discussion into permanent documentation.

The durable source should contain:

* the accepted rule;
* the scope where it applies;
* permitted exceptions;
* prohibited patterns;
* links to the authoritative owner where appropriate;
* validation or review expectations.

Historical rationale may remain in Goal 3 planning.

## 4. Promotion Destinations

### 4.1. Canonical Architecture Documentation

Use canonical architecture documentation for:

* ownership model;
* Core and Module topology;
* dependency direction;
* integration boundaries;
* Application Registration;
* Host Registries and Contributions;
* Frame and presentation ownership;
* cross-owner collaboration;
* permitted Laravel roots.

Primary target:

```text
docs/03-architecture/repository-architecture.md
```

Additional capability-specific architecture sources may own detailed rules when a capability has a separately accepted canonical document.

### 4.2. Canonical Standards

Use standards for repeatable implementation rules such as:

* directory and namespace naming;
* owner-local placement;
* prohibited generic names;
* file archetypes;
* delivery-artifact placement;
* persistence naming and organization;
* test and fixture naming;
* UI Contract structure.

Known target:

```text
docs/02-standards/coding/repository-naming-standards.md
```

Use applicable UI, persistence, and verification standards for their respective concerns rather than duplicating those rules in the general repository architecture.

### 4.3. `AGENTS.md`

Use root or scoped `AGENTS.md` files for concise instructions that agents must apply before writing repository code.

Appropriate rules include:

* required Core behavior does not belong in optional Modules;
* generic Platform or Surface owners are prohibited;
* owner-local placement is required;
* root Laravel directories are restricted integration boundaries;
* accepted UI public Contracts must not be weakened;
* cross-owner private implementation dependencies are prohibited;
* current transitional placement is not target authority.

`AGENTS.md` should reference canonical sources rather than reproduce extensive architecture documentation.

### 4.4. Automated Guardrails

Use deterministic validation when a rule can be checked reliably without inventing architecture.

Potential checks include:

* prohibited namespace or directory patterns;
* required Module package boundaries;
* invalid cross-owner dependencies;
* root placement restrictions;
* generic owner directories;
* stale Platform or Surface scaffolding;
* required public Contract placement;
* documentation metadata and links.

A validator should enforce an accepted rule. It must not become the source that defines the rule.

### 4.5. Public Owner Contracts

Use public Contracts when a rule governs runtime collaboration between owners.

Examples:

* Navigation Contributions;
* Dashboard Contributions;
* Settings Contributions;
* public Queries;
* Events;
* read models;
* owner Registration Descriptors.

A Contract is not a replacement for canonical architecture documentation. It is an executable expression of an accepted boundary.

## 5. Promotion Forms

Each register entry must use one or more of these forms:

```text
Canonical documentation
Canonical standard
Agent instruction
Automated guardrail
Public Contract
Later-owner canonical handoff
```

### Canonical documentation

The rule is added to or verified in an accepted architecture source.

### Canonical standard

The rule becomes a repeatable implementation convention.

### Agent instruction

A concise repository-writing instruction is added to the applicable `AGENTS.md`.

### Automated guardrail

A deterministic checker enforces the rule.

### Public Contract

An accepted owner boundary expresses the rule in executable form.

### Later-owner canonical handoff

The rule belongs to a canonical source that will be established by Goal 5, 6, 9, 10, or another accepted owner.

A later-owner handoff must identify the rule, owner, destination category, and prohibited drift.

## 6. Promotion Versus Reconciliation

Promotion does not always require a new rule.

A register entry may resolve as:

```text
Create
No durable source currently contains the accepted rule.

Update
A durable source exists but is incomplete or uses superseded terminology.

Confirm existing
The rule is already represented accurately and requires only reconciliation evidence.

Replace
A durable source expresses a conflicting or obsolete rule and must be corrected.

Later-owner handoff
The durable canonical owner will be established by a later Goal or issue.
```

Do not duplicate a rule across several sources without assigning one source as the canonical owner.

Other sources should summarize and link.

## 7. Required Durable Rules

The following Goal 3 decisions require durable representation.

### 7.1. Core And Optional Module Topology

Durable rule:

* required application capabilities belong in `app/Core/<Capability>/`;
* `Modules/<Module>/` is reserved for optional, cohesive, independently managed Composer packages;
* disabling or removing an optional Module must not break required Core behavior;
* current package placement does not establish target Module status.

### 7.2. Precise Owner-Local Placement

Durable rule:

* behavior, Delivery, presentation, persistence, configuration, tests, and Contributions follow their accepted owner;
* generic Platform, Surface, Shared, Common, Support, Service, or Manager destinations are not valid permanent owners without a separately accepted precise meaning;
* reuse does not create shared ownership.

### 7.3. Application Registration And Host Authority

Durable rule:

* owners declare registration needs;
* Application Registration validates, compiles, and routes declarations;
* restricted Laravel registrars perform framework integration;
* Host Registries retain acceptance and resolution authority;
* Application Registration does not own Product behavior, authorization policy, or Host ordering decisions.

### 7.4. Frame, UI, And Product Ownership

Durable rule:

* the persistent Frame is limited to Global Header Navigation, Sidebar Navigation, and the Main content outlet;
* UI owns reusable rendering Contracts;
* Workspace, Navigation, Access, Module lifecycle, and Product owners resolve application state;
* UI must not become the owner of Product behavior or authorization.

### 7.5. Navigation And Authorization Separation

Durable rule:

* Navigation visibility is not authorization;
* hidden navigation does not prove denial;
* visible navigation does not grant access;
* route, policy, capability, and object-level authorization remain owner-controlled.

### 7.6. Restricted Laravel Integration Roots

Durable rule:

* `bootstrap/`, `app/Providers/`, `app/Http/`, `app/Console/`, `routes/`, and `config/` remain Laravel integration boundaries;
* root placement is permitted only for genuinely application-wide adaptation or sparse composition;
* owner-specific behavior remains owner-local.

### 7.7. Cross-Owner Collaboration

Durable rule:

* cross-owner use occurs through public Contracts, Queries, Events, approved read models, or accepted Contribution mechanisms;
* direct access to another owner’s private implementation or persistence is prohibited unless separately accepted;
* consumption does not transfer ownership.

### 7.8. Core Runtime Boundary

Durable rule:

* Core Runtime owns narrowly bounded runtime context, initialization, readiness abstractions, and request-neutral runtime state;
* Core Runtime must not become a service locator, configuration bag, Workspace owner, Product resolver, Module-availability owner, or generic coordination layer.

### 7.9. Persistence Ownership

Durable rule:

* Models, migrations, factories, seeders, declarations, tables, and persistence Contracts follow the capability or Module that owns the data;
* shared consumption does not create shared table ownership;
* exact Core persistence organization remains Goal 6 authority.

### 7.10. UI Contract Protection

Durable rule:

* accepted UI Elements, Components, Patterns, Layouts, aliases, tokens, JavaScript APIs, interaction behavior, accessibility requirements, examples, and verification baselines remain protected;
* Product presentation may use UI Contracts but remains Product-owned;
* reuse alone does not promote feature presentation into reusable UI.

### 7.11. Compatibility And Architecture Exceptions

Durable rule:

* compatibility is evidence-based and opt-in;
* no accepted compatibility entry means no compatibility obligation;
* target architecture applies unless an intentional exception is explicitly accepted;
* temporary migration states do not become permanent architecture.

Detailed implementation and cleanup belong to Goal 9.

### 7.12. Verification Ownership

Durable rule:

* target verification follows accepted owners and public behavior;
* accepted UI verification remains protected;
* historical non-UI tests do not independently define target architecture;
* exact verification structure and commands remain Goal 10 authority.

This promotes the architecture boundary without prematurely selecting Goal 10’s detailed implementation.

## 8. Matters That Must Not Be Promoted

Do not promote:

* superseded current-state Platform or Surface structure;
* current `App\Modules\` namespace usage;
* `/platform/*` route structure;
* the rejected shared `/admin/*` concept;
* obsolete manifest formats;
* current non-UI implementation details;
* temporary migration adapters;
* issue-specific cleanup sequencing;
* unresolved later-owner details;
* private ChatGPT Project workflow as repository authority;
* generated inventory observations as accepted target architecture.

A private workflow rule requires a separate accepted repository update before it becomes durable repository behavior.

## 9. Register Contract

Every durable promotion entry must contain:

| Field                             | Requirement                                                           |
| --------------------------------- | --------------------------------------------------------------------- |
| Promotion ID                      | Stable identifier such as `P7-PROM-001`                               |
| Durable rule                      | Concise accepted rule                                                 |
| Current accepted source           | Goal 3 source establishing the rule                                   |
| Target canonical owner            | Durable document, standard, instruction, Contract, or guardrail owner |
| Promotion form                    | Create, update, confirm, replace, or later-owner handoff              |
| Required before Goal 3 acceptance | Yes or no                                                             |
| Validation                        | Documentation, guardrail, Contract, or review proof                   |
| Promotion owner                   | Goal, issue, or repository owner responsible                          |
| Prohibited drift                  | Outcomes the promotion must not permit                                |
| Status                            | Open, promoted, confirmed, handed off, superseded, or withdrawn       |
| Evidence                          | Accepted commit, PR, document, or handoff                             |

## 10. Required-Before-Acceptance Promotion Handoffs

Before final Goal 3 acceptance, each immediate architecture rule must have:

- its current durable coverage reviewed;
- one target canonical owner;
- one promotion owner;
- the required promotion form identified;
- prohibited drift recorded;
- an accepted downstream handoff;
- any direct contradiction in a higher-authority current repository source corrected or recorded as an acceptance blocker.

Phase 7 does not require Goal 08 promotion implementation to be completed.

The following records require accepted handoffs before Goal 3 acceptance:

- `P7-PROM-001` — Core and optional Module topology;
- `P7-PROM-002` — precise owner-local placement;
- `P7-PROM-003` — Application Registration and Host authority;
- `P7-PROM-004` — Frame, UI, and Product ownership;
- `P7-PROM-005` — Navigation and authorization separation;
- `P7-PROM-006` — restricted Laravel integration roots;
- `P7-PROM-007` — cross-owner public boundaries;
- `P7-PROM-008` — narrow Core Runtime.

Detailed canonical-document, standard, instruction, Contract, and guardrail implementation remains Goal 08 or the separately identified capability owner’s work.

## 11. Downstream Promotion Owners

The following may remain accepted handoffs when their canonical owner is explicitly assigned:

* Goal 04 owns detailed Application Registration Contracts.
* Goal 05 owns detailed UI and Frame standards.
* Goal 07 owns cross-capability runtime Contracts.
* Goal 08 owns durable architecture, standards, instructions, and promotion reconciliation.
* Goal 10 owns architecture and dependency guardrails.

A handoff must preserve the accepted Goal 3 boundary.

It must not leave the rule ownerless.

## 12. Promotion Validation

A promotion is complete only when:

1. the durable source exists;
2. the accepted rule is represented accurately;
3. superseded terminology is removed or clearly historical;
4. the canonical owner is explicit;
5. related `AGENTS.md` instructions link to the canonical source where needed;
6. applicable guardrails enforce the rule without redefining it;
7. cross-document links resolve;
8. no conflicting durable rule remains;
9. validation passes;
10. acceptance evidence is recorded.

A planning link alone is not durable promotion.

## 13. Relationship To Phase 7 Reconciliation

Phase 7.8 must confirm that every durable rule has an accepted promotion destination and downstream owner. It must also identify any direct contradiction in current higher-authority repository sources.

Goal 3 acceptance does not require Goal 08 implementation to be complete.

## 14. Proposed Decision

Required-before-acceptance promotion handoffs:

* durable architecture rules must not remain planning-only;
* canonical sources own rules; instructions and validators reference or enforce them;
* only concise active rules are promoted;
* historical rationale remains in planning;
* private Project workflow is not promoted automatically;
* Immediate topology, placement, dependency, Frame, Navigation, Laravel-boundary, and Runtime rules require confirmed durable coverage or an accepted promotion handoff before Goal 3 acceptance.
* persistence, UI, migration, and verification details may use explicit later-owner canonical handoffs;
* all promotions are tracked in the durable-promotion register.

## 15. Validation

Required-before-acceptance promotion handoffs:

* confirm every durable Goal 3 rule appears in the register;
* confirm immediate rules have exact canonical destinations;
* confirm later-owner handoffs identify one owner;
* confirm no private workflow is represented as canonical;
* confirm instructions and guardrails do not replace canonical rule ownership;
* confirm prohibited current-state structures are not promoted;
* confirm no canonical edits are authorized solely by this planning document;
* run `npm run lint:docs:guardrails`;
* run `git diff --check`.

## 16. Acceptance Record

* Outcome: Accepted
* Accepted promotion policy: Durable Goal 3 rules require confirmed canonical coverage or an explicit accepted downstream handoff
* Confirmed durable promotions: P7-PROM-001 through P7-PROM-007
* Accepted later-owner handoffs: P7-PROM-008 through P7-PROM-012
* Required corrections: ADR-0005 Shell clarification and promotion-register reconciliation completed
* Downstream handoff: Phase 7.8 Goal 3 artifact reconciliation

## 17. Related

* [Phase 7 Migration Direction And Goal 3 Acceptance Index](index.md)
* [Phase 7.2 Current-To-Target Placement Mappings](7-2-current-to-target-placement-mappings.md)
* [Phase 7.3 Migration Classification](7-3-migration-classification.md)
* [Phase 7.4 Compatibility Requirements](7-4-compatibility-requirements.md)
* [Phase 7.5 Intentional Architecture Exceptions](7-5-intentional-architecture-exceptions.md)
* [Phase 7.6 Later-Owner Decisions](7-6-later-owner-decisions.md)
* [Current-To-Target Direction Matrix](current-to-target-direction-matrix.md)
* [Durable Promotion Register](durable-promotion-register.md)
* [Goal 3 Target Repository Architecture](../target-repository-architecture.md)
* [Repository Architecture](../../../../../03-architecture/repository-architecture.md)
* [Repository Naming Standards](../../../../../02-standards/coding/repository-naming-standards.md)
* GitHub Phase 7 issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
* GitHub parent Goal 3 issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
