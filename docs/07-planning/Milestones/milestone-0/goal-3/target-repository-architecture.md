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
- Acceptance state: Phases 1 through 5 accepted; Phase 6 decisions and package accepted with canonical reconciliation and final closeout validation pending; Phase 7 pending
- Current implementation state: target planning only
- Owning GitHub issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Current active Phase issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
- Next Phase issue: [#54](https://github.com/kyleswindell/login-v2/issues/54)
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

| Phase | Subject                                  | State                                                                  | Detailed planning                                               |
| ----- | ---------------------------------------- | ---------------------------------------------------------------------- | --------------------------------------------------------------- |
| 1     | Architecture boundaries                  | accepted                                                               | [Phase 1 Index](phase-1/index.md)                               |
| 2     | Repository organization                  | accepted                                                               | [Phase 2 Index](phase-2/index.md)                               |
| 3     | Target repository tree                   | accepted                                                               | [Phase 3 Index](phase-3/index.md)                               |
| 4     | Placement and dependency rules           | accepted                                                               | [Phase 4 Index](phase-4/index.md)                               |
| 5     | Naming conventions                       | accepted; canonical promotion validation pending                       | [Phase 5 Index](phase-5/index.md)                               |
| 6     | Representative validation                | decisions and package accepted; canonical reconciliation and closeout pending | [Phase 6 Index](phase-6/index.md)                          |
| 7     | Migration direction and final acceptance | pending                                                                | Issue [#54](https://github.com/kyleswindell/login-v2/issues/54) |

## 6. Accepted High-Level Architecture

### 6.1. Architecture Boundaries

Core, Modules, and UI are the source-of-truth application ownership areas.

- Core owns required base-application responsibilities.
- Modules own optional, cohesive, independently understandable feature packages.
- UI owns reusable presentation infrastructure.
- Laravel is the framework, runtime, and application-composition system rather than a competing application owner.
- Current `app/Platform` placement and `Platform`-prefixed identifiers are transitional and have no permanent ownership role.

Frame Surface terminology is restricted:

- a Frame Surface is a named compositional region of the persistent authenticated Frame;
- ordinary Products, Product Areas, Pages, destinations, and flows are not Frame Surfaces;
- Main is a route-owned content outlet rather than a Frame Surface;
- a Host owns an extensible feature;
- a Host-owned Registry defines and resolves Extension Points;
- Contributions remain owned by their Contributors;
- API, console, webhook, queue, scheduler, and background entry points are Delivery Adapters or Invocation Channels, not Frame Surfaces;
- generic `Surface/` and `Surfaces/` production roles are not target architecture.

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

#### Phase 3 result

Phase 3 establishes the permanent repository roots, direct `app/` branches, Core and Module structural patterns, artifact-owned presentation topology, hybrid test locations, supporting branches, and transitional or prohibited structures consumed by Phase 4.

### 6.4. Placement And Dependency Rules

Phase 4 decisions are accepted. The consolidated matrices and durable architecture promotion are drafted for final Phase 4 closeout.

#### Artifact placement

- Contracts remain with the owner that makes and maintains the promise.
- Internal abstractions remain adjacent to implementation unless deliberately promoted into a public boundary.
- Concrete implementation remains beneath the narrowest Core capability, Module, UI responsibility, Registry, Contribution, precise presentation role, or restricted Laravel integration concern.
- Delivery Adapters remain owner-local and delegate application behavior inward.
- Core and Module routes, configuration, runtime persistence, presentation, tests, and documentation remain owner-specific or package-local according to the accepted placement matrix.
- Core schema-lifecycle artifacts are grouped by capability beneath `database/core/`; Module schema-lifecycle artifacts remain package-local.
- meaningful folder boundaries default to distinct `README.md`, `index.md`, and `AGENTS.md` files where useful, with bounded omission rules.

Detailed placement:

- [Artifact Placement Matrix](phase-4/artifact-placement-matrix.md)

#### Application registration

Each registrable owner exposes an Owner Registration Descriptor. A deterministic Registration Compiler validates declarations, resolves accepted dependencies, and produces a Compiled Registration Manifest. One Root Application Registrar consumes that manifest and delegates to Typed Registrars, native framework or build APIs, or owner-local Providers.

Filesystem presence alone does not register a canonical artifact. Laravel and Vite retain their native runtime, cache, and build responsibilities.

Durable architecture:

- [Application Registration](../../../../03-architecture/application-registration.md)
- [Application Registration System Definition](../../../Definitions/Application-Registration/Definition.md)

#### Dependency direction and communication

- dependencies flow toward provider-owned public Contracts;
- Core remains independent of optional Modules;
- Module-to-Module dependencies are explicit, declared, public-Contract based, and acyclic;
- reusable UI does not depend on Core or Module domain implementation;
- owner-specific Product presentation and Delivery Adapters depend inward on owner behavior;
- Frame rendering consumes normalized Workspace and Core Navigation output and must not evaluate application policy;
- immediate commands use provider-owned public Contracts;
- immediate reads use provider-owned public Query Contracts;
- Events announce completed facts;
- Listeners react independently;
- Jobs represent deliberately deferred work;
- Host Extensions use Host-owned Extension Point Contracts and Contributor-owned Contributions;
- direct cross-owner concrete imports, Model or table access, generic shared services, and hidden registration are prohibited.

Detailed dependency and communication model:

- [Dependency And Communication Matrix](phase-4/dependency-and-communication-matrix.md)

#### Exceptions and enforcement

Exceptions are exact, bounded, owner-accepted, and nonprecedential. Unexpected mandatory failures do not create implicit permission to weaken a rule.

Later enforcement targets include prohibited paths, registration completeness, duplicate declarations, stale generated output, dependency direction, Core independence, Module dependency cycles, UI isolation, deterministic test discovery, and significant-folder documentation.

Promotion and future-work routing:

- [Durable Promotion Register](phase-4/durable-promotion-register.md)

#### Phase 5 handoff

Phase 5 retains final naming authority for folders, namespaces, classes, Contracts, routes, configuration, Events, Jobs, tests, fixtures, Contributions, descriptors, manifests, registrars, aliases, and generated output. Phase 5 must not reopen accepted Phase 4 ownership, placement, dependency, or communication rules.

### 6.5. Naming Conventions

Phase 5 Decisions 5.1–5.14 are accepted.

- Folder families follow native conventions; namespace-bearing PHP paths use exact PascalCase-to-namespace mapping.
- Core capabilities and Modules keep technical names, machine keys, folders, namespaces, packages, URLs, configuration roots, and labels as separate representations.
- Concrete PHP types use precise subjects and roles; repository interfaces use `Interface`; Data Object is the canonical project term.
- Actions, Queries, Resolvers, Coordinators, Handlers, delivery artifacts, Events, Listeners, Jobs, Notifications, Audit Events, tests, fixtures, and documentation use the patterns recorded in the Phase 5 matrices.
- Route names, URLs, configuration keys, class names, machine identifiers, and logical queues remain separate naming families.
- Compatibility is direct, one-way, non-chainable, bounded, verified, and transitional by default.
- Application Registration terms describe responsibilities; custom descriptors, compilers, manifests, registrars, commands, and files are conditional rather than mandatory wrappers.

Detailed naming:

- [Phase 5 Index](phase-5/index.md)
- [Naming Convention Matrix](phase-5/naming-convention-matrix.md)
- [Role Terminology Matrix](phase-5/role-terminology-matrix.md)
- [Module Identity Matrix](phase-5/module-identity-matrix.md)
- [Compatibility And Rename Register](phase-5/compatibility-and-rename-register.md)

### 6.6. Representative Validation

Phase 6 decisions and package are accepted. Canonical reconciliation, repository checks, and the Issue #53 Final Acceptance Record remain pending.

Representative examples:

- Settings — required Core capability, Settings Host, Product, and Navigation Contributor;
- Projects — optional Module, Product, and Navigation Contributor;
- Modal and Dialog — UI-owned reusable Component family;
- Sidebar Navigation Frame Surface — Workspace-aware composition hosted by Core Navigation and rendered by UI.

Phase 6 accepted:

- multiple available Workspaces with exactly one active Workspace in a rendered context;
- Global Administration as a Workspace;
- the persistent Frame and narrow Header and Sidebar Navigation Frame Surfaces;
- System, Product, Product Area, Page, and drill-down navigation;
- Core Navigation at `app/Core/Navigation/`, namespace `App\Core\Navigation\`, key `navigation`;
- owner-local `Contrib/Navigation/` paths;
- no permanent structural exception;
- verification-first proof requirements;
- twelve bounded later architecture guardrails.

Detailed validation:

- [Phase 6 Index](phase-6/index.md)
- [Phase 6 Durable Promotion Register](phase-6/durable-promotion-register.md)
- [ADR-0008](../../../../01-decisions/adr-0008-workspace-navigation-and-frame-surface-model.md)
- [Workspace Navigation And Frame Composition](../../../../03-architecture/workspace-navigation-and-frame-composition.md)

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

Accepted Goal 3 planning must be promoted to applicable durable owners.

Phase 4 and Phase 5 durable promotion targets include:

- [Repository Architecture](../../../../03-architecture/repository-architecture.md);
- [Application Registration](../../../../03-architecture/application-registration.md);
- [System Overview](../../../../03-architecture/system-overview.md);
- [Stack Overview](../../../../03-architecture/stack-overview.md);
- reusable architecture Definitions;
- [Repository Naming Standards](../../../../02-standards/coding/repository-naming-standards.md);
- specialist coding, database, and documentation standards identified by the [Phase 5 Durable Promotion Register](phase-5/durable-promotion-register.md).

Runtime registration tooling and automated enforcement remain later bounded implementation work.

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
- [Phase 4 Index](phase-4/index.md)
- [Phase 4 Artifact Placement Matrix](phase-4/artifact-placement-matrix.md)
- [Phase 4 Dependency And Communication Matrix](phase-4/dependency-and-communication-matrix.md)
- [Phase 4 Durable Promotion Register](phase-4/durable-promotion-register.md)
- [Phase 5 Naming Conventions Index](phase-5/index.md)
- [Phase 5 Durable Promotion Register](phase-5/durable-promotion-register.md)
- [Milestone 0 Planning Index](../index.md)
- GitHub parent issue: [#19](https://github.com/kyleswindell/login-v2/issues/19)
- Current Phase issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Next Phase issue: [#53](https://github.com/kyleswindell/login-v2/issues/53)
