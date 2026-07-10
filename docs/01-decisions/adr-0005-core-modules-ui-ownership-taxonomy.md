<!--
DOC-META
title: ADR-0005: Core, Modules, And UI Ownership Taxonomy
doc_type: decision
status: draft
owner: architecture
canonical: true
canonical_path: docs/01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md
parent: docs/01-decisions/index.md
template: docs/09-reference/templates/docs/_decision.md
summary: Proposes Core, Modules, and UI as the three canonical source-of-truth ownership areas for Login 2.0.
-->

# ADR-0005: Core, Modules, And UI Ownership Taxonomy

Parent: [Decisions Index](index.md)

## 1. Decision Status

Proposed

## 2. Dates

- Proposed: 2026-07-10
- Accepted, rejected, deprecated, or superseded:

## 3. Decision Owner

- Owner: Login 2.0 architecture owner
- Required reviewers: repository owner; architecture reviewer; UI-system reviewer
- Acceptance source: explicit approval recorded on GitHub issue #1 and the associated pull request

## 4. Related Work

- GitHub issue: [#1 — Confirm Core, Modules, and UI ownership taxonomy](https://github.com/kyleswindell/login-v2/issues/1)
- Parent goal: [#17 — M0 Goal 01: Canonical vocabulary and ownership](https://github.com/kyleswindell/login-v2/issues/17)
- Planning document: [M0 Repository Convergence Planning](../07-planning/00-overview/m0-repository-convergence-planning.md)
- Planning matrix: [Core Service Build Plan Matrix](../07-planning/core-service-build-plan-matrix.md)
- Pull request:
- Prior decisions: none active; archived ADRs remain historical until separately reviewed
- Affected canonical owners:
  - `docs/03-architecture/`
  - `docs/02-standards/coding/`
  - `docs/02-standards/ui/`
  - `docs/07-planning/core-service-build-plan-matrix.md`
  - root and folder-level `AGENTS.md`
  - future route, registry, permission, notification, audit, Module, and database contracts

## 5. Context

The repository currently uses terms such as `core module`, `platform module`, `platform surface`, `business module`, `package`, `feature`, and `UI system` for responsibilities that are not equivalent.

This ambiguity causes several problems:

- physical placement is mistaken for architectural ownership
- required base functionality is confused with optional Modules
- reusable UI is confused with application composition
- package and registry mechanics are treated as ownership
- `Platform` overlaps both Core composition and UI presentation
- later topology, contract, data, dependency, and migration work cannot rely on stable owner terms

M0 requires one source-of-truth ownership taxonomy before target topology, key conventions, contract placement, persistent-data ownership, standards promotion, and migration sequencing can be accepted.

## 6. Decision Drivers

- one primary owner for every material responsibility
- clear separation of required base application, optional features, and reusable UI
- Core independence from optional Modules
- scalable Module installation, updates, rollout, and assignment
- explicit Module-to-Module dependency and extension contracts
- separation of ownership from physical placement
- separation of ownership from packaging and registry mechanics
- compatibility with Laravel and Composer conventions

## 7. Decision

Login 2.0 will use three canonical source-of-truth ownership areas:

1. **Core**
2. **Modules**
3. **UI**

These terms describe authoritative responsibility. They do not directly define physical repository paths, navigation categories, package types, or GitHub Project classifications.

`Platform` will not remain a peer source-of-truth owner. Responsibilities currently described as Platform will be redistributed to Core or UI according to their actual responsibility.

### 7.1 Core

**Core** owns all required base-application behavior, state, coordination, infrastructure, and contracts that must exist when no optional Modules are installed.

Core includes:

- authoritative system capabilities
- application-wide coordination and composition
- Module lifecycle and contribution infrastructure
- required shell, navigation, dashboard, setup, and registry behavior
- required internal operational tooling
- public contracts consumed by Modules
- Core-owned presentation adapters and URL surfaces
- required base-application persistence and lifecycle rules

Representative Core areas include Auth, Identity, Access, Security, DataGovernance, DataProtection, Audit, Monitoring, Notifications, Settings, Preferences, Shell, Navigation, Dashboard, Setup, Registries, Module lifecycle, and contribution discovery.

Core does not own:

- optional feature sets that may be omitted from an application instance
- reusable UI Elements, Components, Patterns, or Layouts
- Module-specific records, workflows, or extension behavior

A responsibility is Core when it defines required base-application behavior or state that Modules must consume rather than recreate.

### 7.2 Modules

A **Module** is an optional, cohesive, mostly self-contained feature set that may be installed, enabled, assigned, updated, disabled, or omitted for an individual application instance without breaking Core.

Modules may be business-oriented, operational, administrative, analytical, or otherwise feature-specific.

Every Module must:

- be an independently versioned Composer package
- be independently installable and distributable
- have a stable package identity and formal Module definition
- declare compatible Core requirements
- declare Module dependencies and version constraints
- declare extension relationships and contribution points
- provide its own feature behavior, data, routes, policies, tests, documentation, and presentation where applicable
- remain optional relative to the base application

A Module may require and extend another Module when the relationship is explicit, version constrained, declared in Composer, declared in the Module definition, validated before installation or enablement, and based on public contracts.

Examples:

- Projects requires and extends Tasks
- Orders requires and extends Customers
- Orders requires and extends Quotes
- Events requires and extends Calendar

Extension means contribution through published contracts, events, registries, actions, relationships, page sections, tabs, widgets, or other explicit extension points. It does not mean unrestricted access to another Module's internal implementation.

Composer owns package installation and version resolution. Login 2.0 owns runtime enablement, application-instance assignment, tenant or workspace assignment, dependency validation, activation order, extension registration, disable protection, and uninstall protection.

### 7.3 UI

**UI** owns the reusable application interface system:

- Elements
- Components
- Patterns
- Layouts
- design tokens
- icons
- reusable CSS
- reusable JavaScript interaction controls
- UI contracts
- UI-specific tests
- UI reference and review evidence

UI does not own authorization decisions, route behavior, database access, domain queries or mutations, Core policy or lifecycle truth, Module behavior or state, or Module discovery.

A file under `resources/` is not automatically UI-owned. Ownership follows responsibility rather than physical location.

## 8. Ownership And Physical Placement

Ownership and repository placement are separate concepts.

| Artifact | Likely physical location | Owner |
| --- | --- | --- |
| User administration URL view | `resources/views/admin/users/` | Core/Identity |
| Shared data-table component | `resources/views/components/ui/` | UI |
| Orders list view | Module package views | Orders Module |
| Module registry service | Core application infrastructure | Core |
| Reusable form-actions pattern | `resources/views/components/patterns/` | UI |

Goal 03 will define the target folder and namespace model. This decision defines responsibility only.

## 9. Ownership And Packaging

Ownership answers who owns authoritative behavior, state, contracts, review, and dependency rules.

Packaging answers how code is grouped, installed, versioned, registered, enabled, disabled, and distributed.

A package is not a fourth owner type.

Core and UI may contain package-shaped implementation units when registration, isolation, or distribution provides a real benefit. Modules must be independently distributable Composer packages because their lifecycle is optional and instance-controlled.

## 10. Dependency Direction

```text
Modules -> Core
Modules -> UI
Core presentation -> UI
```

Rules:

- Core must operate when no Modules are installed.
- Core must not import or require Module implementation.
- Modules may consume Core public contracts.
- Modules may use UI Elements, Components, Patterns, and Layouts.
- Core presentation may use UI.
- Core business and system logic must remain independent of Blade, CSS, JavaScript, and UI contracts.
- UI must not depend on Core or Module domain implementation.
- Module-to-Module dependencies must be explicit, versioned, declared, and contract-based.
- Core discovers Module contributions through Core-owned contracts and registries.
- A composed feature may involve multiple owners, but every distinct responsibility has one primary owner.

## 11. Terminology Mapping

| Current or ambiguous term | Accepted use |
| --- | --- |
| `Core` | Required base-application behavior, state, coordination, and infrastructure. |
| `Core Capability` | A distinct capability within Core. |
| `Platform` | Retired as a peer owner; replace with a precise Core area or UI responsibility. |
| `Platform Surface` | Retired as an ownership term. |
| `Module` | Optional, independently distributable Composer feature package. |
| `Business Module` | A business-oriented subtype of Module. |
| `Shared UI` | Descriptive name for the reusable UI system; canonical owner label is `UI`. |
| `UI system` | Elements, Components, Patterns, Layouts, tokens, icons, CSS, JavaScript, contracts, and tests owned by UI. |
| `Resources` | Laravel repository location, not an owner type. |
| `Surface` | Rendered destination or interface, not a primary owner. |
| `Package` | Packaging and distribution mechanism, not an owner. |
| `Feature` | Unit of behavior or product functionality, not an owner. |
| `Integration` | Behavior owned by Core or a Module, or a Module when optional and self-contained. |
| `Internal tool` | Core when required; Module when optional and independently installable. |
| `core module` | Replace with the precise Core area. |
| `platform module` / `platform_management` | Replace with the precise Core area or optional Module classification. |

## 12. Alternatives Considered

### Alternative A — Retain Core, Platform, Modules, And UI

Not selected because Platform overlaps Core application coordination and UI presentation, while `Surface` implies UI ownership.

### Alternative B — Use Core, Modules, And Resources

Not selected because `resources/` is a physical Laravel location rather than a source-of-truth owner.

### Alternative C — Use Package As The Universal Owner

Not selected because packaging and ownership answer different questions.

### Alternative D — Restrict Modules To Business Domains

Not selected because optional cohesive features may be operational, administrative, analytical, or otherwise non-business.

## 13. Consequences

### Positive

- three non-overlapping source-of-truth owners
- required base behavior is separated from optional packages
- UI ownership is independent of Laravel folder placement
- current Platform responsibilities can be classified by actual responsibility
- Module installation and rollout can scale through Composer
- Module families can compose through explicit dependency and extension contracts

### Negative

- current planning and code use Platform terminology that must be reconciled
- several current `Modules/*` packages are actually Core responsibilities
- Module packaging and runtime lifecycle infrastructure must become more formal
- independent distribution requires versioning, repositories, dependency management, and deployment controls

### Security, Privacy, And Data

- required Auth, Identity, Access, Security, DataGovernance, DataProtection, Audit, and Monitoring behavior remains Core
- optional Modules cannot redefine required base security or governance controls
- UI cannot make authorization, classification, retention, or data-access decisions
- Module dependency and extension contracts can be reviewed explicitly

### Operational And Migration

- no immediate runtime change is authorized
- current folders, routes, tables, manifests, and registries may remain during transition
- future migrations must preserve compatibility explicitly
- Module installation and updates should occur through controlled deployment workflows
- tenants on one deployed application instance normally execute the same installed Module version, while enablement and assignment may vary

## 14. Implementation Implications

- future Core folder and namespace organization
- Module Composer package structure
- Module definitions and lifecycle
- Module dependency and extension contracts
- private package registries and distribution
- UI ownership and contract placement
- folder-level `AGENTS.md`

This decision does not directly authorize migrations or runtime changes.

Required follow-up:

- issue #27 for scope and actor vocabulary
- issue #28 for owner, Module, registry, dependency, and extension-key conventions
- Goal 03 for target topology and naming
- Goal 07 for cross-owner and cross-Module contracts
- Goal 09 for migration and compatibility

## 15. Canonical Documentation Updates

### Create

- `docs/01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md`

### Update After Acceptance

- `docs/01-decisions/index.md`
- `docs/07-planning/00-overview/m0-repository-convergence-planning.md`
- `docs/07-planning/core-service-build-plan-matrix.md`
- affected architecture planning and indexes
- affected coding, UI, testing, and documentation standards
- root and folder-level `AGENTS.md`
- GitHub issue and Project classifications where Platform ownership remains

### Supersede Or Archive

- no active decision record is superseded
- ambiguous planning terminology should be normalized or retained with explicit compatibility notes
- archived ADRs remain historical

## 16. Verification

Confirm that:

- the decision identifier and filename are unique
- the Decisions Index lists the proposal
- document metadata and decision lifecycle agree
- Core, Modules, and UI definitions are distinct
- Platform is no longer used as a peer source-of-truth owner
- Module packaging, dependency, and extension requirements are explicit
- ownership and physical placement remain distinct
- ownership and packaging remain distinct
- documentation guardrails pass
- canonical owners are updated before issue #1 closes

## 17. Supersession

### Supersedes

- None

### Superseded By

- None

### Transition Plan

Treat existing Platform, core-module, platform-module, and generic module terminology as transitional until accepted follow-up work normalizes it. Do not remove current compatibility structures through this decision-only change.

## 18. Acceptance Or Rejection Record

Complete this section when the proposal is resolved.

- Outcome:
- Date:
- Accepted or rejected by:
- Evidence:
- Required follow-up:

## 19. Related

- [Decisions Index](index.md)
- [M0 Repository Convergence Planning](../07-planning/00-overview/m0-repository-convergence-planning.md)
- [Core Service Build Plan Matrix](../07-planning/core-service-build-plan-matrix.md)
- Related GitHub issue: [#1](https://github.com/kyleswindell/login-v2/issues/1)
