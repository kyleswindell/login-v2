<!--
DOC-META
title: Goal 3 Target Repository Architecture
doc_type: planning
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/target-repository-architecture.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Consolidates the accepted high-level Goal 3 repository architecture and routes readers to the detailed Phase planning that owns each decision.
-->

# Goal 3 Target Repository Architecture

Parent: [Goal 3 Target Repository Architecture Index](index.md)

## 1. Purpose

Goal 3 defines the target repository architecture that later refactor and implementation work must follow.

This document is the concise Goal 3 synthesis artifact. It records the accepted high-level result of each Phase and routes readers to the detailed Phase planning that owns supporting decisions, evidence, examples, and closeout records.

Goal 3 defines the destination. It does not perform the physical repository migration.

## 2. Status

- Planning lifecycle: active
- Acceptance state: Phase 1 accepted; Phase 2 accepted; Phase 3 decisions accepted with final Phase 3 closeout pending; Phases 4 through 7 pending
- Current implementation state: target planning only
- Owning GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Current active Phase issue: [#50](https://github.com/kyleswindell/login-v2/issues/50)
- Next Phase issue: [#51](https://github.com/kyleswindell/login-v2/issues/51)
- Final Goal 3 acceptance: pending

## 3. Scope

Goal 3 establishes:

- responsibility ownership;
- primary repository organization;
- target repository branches and structural patterns;
- artifact placement;
- dependency direction;
- naming conventions;
- representative architecture validation;
- current-to-target migration direction;
- compatibility requirements and structural exceptions.

Goal 3 does not:

- move or rename current files;
- perform namespace or Composer migration;
- implement compatibility adapters;
- define detailed database schemas;
- implement contract-discovery tooling;
- define the complete verification architecture;
- rebuild Core capabilities, Modules, or UI.

## 4. Authority And Reading Model

This document summarizes accepted Goal 3 direction.

Detailed authority remains with:

- the applicable Phase index;
- the numbered Phase decision documents;
- accepted ADRs and definitions;
- the governing GitHub issue and repository-owner acceptance record.

Use the [Goal 3 Index](index.md) to locate the current Phase package.

## 5. Phase Register

| Phase | Subject                                  | State                                | Detailed planning                                               |
| ----- | ---------------------------------------- | ------------------------------------ | --------------------------------------------------------------- |
| 1     | Architecture boundaries                  | accepted                             | [Phase 1 Index](phase-1/index.md)                               |
| 2     | Repository organization                  | accepted                             | [Phase 2 Index](phase-2/index.md)                               |
| 3     | Target repository tree                   | decisions accepted; closeout pending | [Phase 3 Index](phase-3/index.md)                               |
| 4     | Placement and dependency rules           | pending                              | Issue [#51](https://github.com/kyleswindell/login-v2/issues/51) |
| 5     | Naming conventions                       | pending                              | Issue [#52](https://github.com/kyleswindell/login-v2/issues/52) |
| 6     | Representative validation                | pending                              | Issue [#53](https://github.com/kyleswindell/login-v2/issues/53) |
| 7     | Migration direction and final acceptance | pending                              | Issue [#54](https://github.com/kyleswindell/login-v2/issues/54) |

## 6. Accepted High-Level Architecture

### 6.1. Architecture Boundaries

Core, Modules, and UI are the source-of-truth application ownership areas.

- Core owns required base-application responsibilities.
- Modules own optional, cohesive, independently understandable feature packages.
- UI owns reusable presentation infrastructure.
- Laravel is the framework, runtime, and application-composition system rather than a competing application owner.
- Current `app/Platform` placement and `Platform`-prefixed identifiers are transitional and have no permanent ownership role.

Surface terminology is restricted:

- a Surface is an owner-specific UI presentation and interaction layer;
- a Host owns an extensible feature;
- a Host-owned Registry defines and resolves Extension Points;
- Contributions remain owned by their Contributors;
- API, console, webhook, queue, scheduler, and background entry points are Delivery Adapters or invocation channels, not Surfaces.

Detailed boundary planning:

- [Phase 1 Index](phase-1/index.md)
- [Phase 2.90 Surface, Host, And Registry Reclassification](phase-2/2-90-surface-host-registry-reclassification.md)

### 6.2. Repository Organization

Login 2.0 uses owner-first, capability-first organization.

Classification proceeds in this order:

1. identify the owner;
2. identify the cohesive capability, Module, UI responsibility, or Laravel integration concern;
3. identify the Technical Role.

Core capabilities and Modules use the same sparse Technical Role vocabulary. Role definitions establish meaning and boundaries but do not require universal folder presence.

Cross-cutting use does not create cross-cutting ownership. Delivery Adapters remain with the owner of the behavior they expose. Actual structural exceptions require bounded repository-owner acceptance.

Detailed organization planning:

- [Phase 2 Repository Organization Index](phase-2/index.md)

### 6.3. Target Repository Tree

The accepted target tree is a sparse structural pattern:

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

Optional branches appear only when required by the applicable capability, Module, UI artifact, or integration boundary.

#### Permanent root responsibilities

| Root         | Responsibility                                                  |
| ------------ | --------------------------------------------------------------- |
| `.agents/`   | Repository-local agent guidance and reusable agent support      |
| `.docker/`   | Container image, initialization, and container-specific support |
| `.github/`   | GitHub workflows, templates, ownership metadata, and automation |
| `app/`       | Base-application PHP source and bounded Laravel integration     |
| `bootstrap/` | Laravel bootstrap source and framework cache structure          |
| `config/`    | Root Laravel and base-application configuration                 |
| `database/`  | Base-application database integration and cross-owner support   |
| `docs/`      | Canonical repository documentation system                       |
| `Modules/`   | Optional independently distributable Module packages            |
| `ops/`       | Machine-consumed operational and deployment assets              |
| `public/`    | Public web root and publishable public assets                   |
| `resources/` | Base-application presentation source and entrypoints            |
| `routes/`    | Root route registration and bounded global routes               |
| `scripts/`   | Executable repository and deployment automation                 |
| `storage/`   | Laravel runtime state and required tracked placeholders         |
| `stubs/`     | Generator and scaffolding inputs                                |
| `tests/`     | Cross-owner and repository-wide verification                    |

Acceptance of a root branch does not accept every current child path, artifact, or name beneath it.

#### Permanent `app/` branches

```text
app/
├── Core/
├── UI/
├── Http/
├── Console/
└── Providers/
```

- `Core/` and `UI/` are application owner roots.
- `Http/`, `Console/`, and `Providers/` are permanent but restricted application-wide Laravel integration boundaries.
- Models, Rules, Jobs, Events, Listeners, Policies, Notifications, Livewire components, Surfaces, Registries, and Delivery Adapters remain beneath their explicit owner.

#### Core capability pattern

```text
app/Core/<Capability>/<TechnicalRole>/
app/Core/<Capability>/__tests__/
```

Every direct child of `app/Core/` represents one cohesive required capability. Technical Roles are sparse. Generic Core branches such as `Shared/`, `Common/`, `Services/`, `Support/`, `Helpers/`, `Utilities/`, and `Infrastructure/` are prohibited.

#### Module package pattern

```text
Modules/<Module>/
├── composer.json
├── README.md
├── src/
│   ├── Definition.php
│   └── <TechnicalRole>/
├── config/
├── routes/
├── database/
├── resources/
├── tests/
└── docs/
```

Every permanent `Modules/*` entry represents one optional, independently understandable, versioned, installable, and distributable Composer package.

A Module’s `src/` Technical Roles correspond to the roles beneath `app/Core/<Capability>/`. Package-root support branches are package integration surfaces rather than competing Technical Roles.

`Modules/_Template/` is not a Module and belongs beneath generator-owned `stubs/` structure.

#### UI and resource pattern

Login 2.0 uses artifact-owned presentation bundles.

A reusable UI Component, Element, Pattern, or Layout colocates its applicable:

- Blade or presentation implementation;
- CSS;
- JavaScript;
- machine-readable contract;
- targeted tests;
- partials;
- internal support.

Category-level CSS and JavaScript aggregators explicitly compose bundles. `resources/css/app.css` and `resources/js/app.js` remain the primary Vite entrypoints.

Core-owned and Module-owned presentation follows the same colocation principle within its owner boundary.

#### Hybrid test pattern

Tests live as close as practical to the smallest cohesive owner or artifact they verify:

```text
app/Core/<Capability>/__tests__/
app/UI/<Responsibility>/__tests__/
app/Http/__tests__/
app/Console/__tests__/
app/Providers/__tests__/
resources/views/**/__tests__/
Modules/<Module>/tests/
```

Repository-root `tests/` remains for cross-owner integration, system, browser, architecture, compatibility, repository, and shared test infrastructure.

Deterministic local and CI discovery across every accepted location must be proven before test migration.

#### Transitional and prohibited locations

Current non-target locations include:

```text
app/Platform/
app/Surfaces/
app/Support/
app/Models/
app/Rules/
app/Livewire/
Modules/_Template/
resources/views/platform/
resources/views/livewire/platform/
resources/css/components/
resources/css/patterns/
resources/css/tokens/
resources/css/type/
resources/css/ui/
resources/js/ui-controls/
resources/js/internal/
```

They are transitional or compatibility-only, prohibited for new canonical work, and require later owner assignment, compatibility proof, verification, documentation updates, and repository-owner acceptance before removal.

Generic ownership branches such as `Platform`, `Surfaces`, `Shared`, `Common`, `Helpers`, `Utilities`, `Services`, and `Support` are prohibited at repository, application-owner, Core, and Module levels.

Detailed topology planning:

- [Phase 3 Target Repository Tree Index](phase-3/index.md)

#### Phase 3 handoff

Phase 4 retains authority for:

- exact contract and implementation placement;
- route placement and registration;
- configuration placement;
- database artifact placement;
- detailed view and asset placement;
- detailed test placement and discovery;
- documentation placement;
- dependency direction;
- cross-owner communication;
- placement exceptions and later enforcement.

Phase 5 retains final naming authority.

### 6.4. Placement And Dependency Rules

Pending Phase 4.

Phase 4 will define:

- artifact placement;
- contract and implementation locations;
- Delivery Adapter placement;
- route and configuration placement;
- data, view, asset, test, and documentation placement;
- permitted dependencies;
- accepted cross-owner communication methods;
- placement and dependency exceptions;
- future static enforcement candidates.

### 6.5. Naming Conventions

Pending Phase 5.

Phase 5 will define names for:

- folders and namespaces;
- capabilities and Modules;
- classes and delivery artifacts;
- routes and configuration;
- events, jobs, tests, fixtures, and documentation;
- compatibility and rename behavior.

### 6.6. Representative Validation

Pending Phase 6.

Phase 6 will apply the accepted model to representative Core, Module, UI, Surface, Registry, Delivery Adapter, test, and documentation examples and identify required future architecture proofs.

### 6.7. Migration And Compatibility Direction

Pending Phase 7.

Phase 7 will document:

- coarse current-to-target mappings;
- compatibility requirements;
- intentional structural exceptions;
- later-Goal decision handoffs;
- durable documentation-promotion targets;
- final Goal 3 repository-owner acceptance.

## 7. Required Final Outcome

Goal 3 is complete when future work can determine, without reopening repository architecture:

- who owns a responsibility;
- where its contracts and implementation belong;
- which dependencies are allowed;
- how its repository artifacts are named;
- what compatibility or migration treatment applies;
- what automated, manual, or specialist proof later implementation must provide.

## 8. Documentation Promotion

Accepted Goal 3 planning must eventually be promoted to applicable durable owners, including:

- architecture documentation;
- repository standards;
- capability and Module contracts;
- definitions;
- `AGENTS.md` files and repository-agent skills where persistent execution rules are required;
- later verification and migration planning.

This planning document remains a concise historical and routing synthesis rather than the sole permanent owner of every durable rule.

## 9. Verification And Exit Criteria

Goal 3 acceptance requires:

- [ ] all seven Phases are accepted;
- [ ] Phase results agree and use accepted vocabulary;
- [ ] the target tree, placement, dependency, and naming models are complete;
- [ ] representative examples fit without unresolved structural ambiguity;
- [ ] migration direction, compatibility requirements, and exceptions are documented;
- [ ] later-Goal decisions are explicitly handed off;
- [ ] required durable documentation is created or assigned;
- [ ] documentation guardrails pass;
- [ ] final repository-owner acceptance is recorded in Issue #19.

## 10. Related

- [Goal 3 Index](index.md)
- [Phase 1 Index](phase-1/index.md)
- [Phase 2 Index](phase-2/index.md)
- [Phase 3 Index](phase-3/index.md)
- [Milestone 0 Planning Index](../index.md)
- GitHub parent issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Current Phase issue: [#50](https://github.com/kyleswindell/login-v2/issues/50)
- Next Phase issue: [#51](https://github.com/kyleswindell/login-v2/issues/51)
