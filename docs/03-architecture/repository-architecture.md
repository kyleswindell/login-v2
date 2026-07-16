<!--
DOC-META
title: Repository Architecture
doc_type: architecture
status: active
owner: architecture
canonical: true
canonical_path: docs/03-architecture/repository-architecture.md
parent: docs/03-architecture/index.md
template: docs/09-reference/templates/docs/_architecture-note.md
summary: Defines the accepted target repository topology, owner-local artifact placement, application registration, dependency direction, presentation and test locations, supporting branches, exceptions, and transitional structures.
-->

# Repository Architecture

Parent: [Architecture Index](index.md)

## 1. Purpose

This document is the canonical architecture owner for the accepted target repository topology and structural placement model of Login 2.0.

It defines permanent branches, owner-local artifact placement, application-composition boundaries, dependency direction, presentation and test topology, and structural exceptions.

It does not map every current file, perform migration, define final names, implement registration tooling, or replace detailed standards and owner Contracts.

## 2. Status And Scope

- Target architecture: accepted through Goal 3 Phase 5
- Current implementation: transitional
- Naming model: accepted through Goal 3 Phase 5
- Representative validation: pending Goal 3 Phase 6
- Migration direction: pending Goal 3 Phase 7
- Automated enforcement: later bounded implementation and verification work

This document owns:

- repository-root and direct `app/` branches;
- Core, Module, UI, and restricted Laravel physical patterns;
- default Contract, implementation, Delivery Adapter, route, configuration, database, presentation, test, and documentation placement;
- the Application Registration System architecture summary;
- dependency direction and cross-owner communication boundaries;
- transitional, compatibility-only, prohibited, and exception structures.

Detailed placement rows remain in the Goal 3 Phase 4 matrices. General naming rules are owned by [Repository Naming Standards](../02-standards/coding/repository-naming-standards.md), while specialist standards retain their domain detail.

This document does not own feature behavior, detailed schema design, physical migration, or implementation.

## 3. Architecture Principles

Login 2.0 uses owner-first, capability-first organization.

Application responsibilities belong first to:

1. Core;
2. an optional Module;
3. UI;
4. a bounded application-wide Laravel integration boundary.

Technical Roles such as Surface, Delivery Adapter, Registry, Action, Query, Contract, Model, Policy, Job, Event, Listener, Notification, Rule, and Livewire implementation remain beneath an explicit owner.

Broad use does not create generic ownership. Framework conventions do not transfer application ownership. Registration does not transfer ownership.

## 4. Target Repository Tree

The target tree is sparse. Optional branches exist only when required.

```text
/
├── .agents/
├── .docker/
├── .github/
├── app/
│   ├── Core/<Capability>/
│   │   ├── <TechnicalRole>/
│   │   ├── routes/
│   │   ├── config/
│   │   └── __tests__/
│   ├── UI/<Responsibility>/
│   │   ├── <TechnicalRole>/
│   │   └── __tests__/
│   ├── Http/
│   ├── Console/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
│   └── core/<Capability>/
├── docs/
├── Modules/
│   └── <Module>/
│       ├── composer.json
│       ├── README.md
│       ├── src/<TechnicalRole>/
│       ├── config/
│       ├── routes/
│       ├── database/
│       ├── resources/
│       ├── tests/
│       └── docs/
├── ops/
├── public/
├── resources/
│   ├── css/app.css
│   ├── js/app.js
│   └── views/
│       ├── components/
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

Support-branch labels shown here reflect accepted Phase 4 placement direction. Phase 5 retains final naming and casing authority.

Acceptance of a branch does not accept every current child path, artifact, or name beneath it.

## 5. Root Branch Responsibilities

| Root         | Responsibility                                                                                                             |
| ------------ | -------------------------------------------------------------------------------------------------------------------------- |
| `.agents/`   | Repository-local agent skills and bounded execution guidance                                                               |
| `.docker/`   | Container definitions, initialization, and container support                                                               |
| `.github/`   | GitHub workflows, templates, ownership metadata, and automation                                                            |
| `app/`       | Base-application PHP source and bounded Laravel integration                                                                |
| `bootstrap/` | Laravel bootstrap and required cache structure                                                                             |
| `config/`    | Laravel framework, application-wide composition, shared infrastructure, bootstrap, and bounded compatibility configuration |
| `database/`  | Core schema-lifecycle artifacts, application-wide database integration, root composition, and bounded cross-owner support  |
| `docs/`      | Canonical repository documentation                                                                                         |
| `Modules/`   | Optional independently distributable packages                                                                              |
| `ops/`       | Machine-consumed operational and deployment assets                                                                         |
| `public/`    | Public web root and assets requiring direct public access                                                                  |
| `resources/` | Presentation source and primary asset entrypoints                                                                          |
| `routes/`    | Application-wide route entrypoints, owner-route registration, global infrastructure, and bounded compatibility             |
| `scripts/`   | Repository validation, generation, maintenance, and orchestration                                                          |
| `storage/`   | Laravel runtime state and tracked placeholders                                                                             |
| `stubs/`     | Generator and scaffolding inputs                                                                                           |
| `tests/`     | Cross-owner and repository-wide verification                                                                               |

Generated dependencies, build outputs, reports, manifests, and runtime artifacts are neither canonical repository branches nor application owners.

## 6. Application Source Structure

Permanent direct children of `app/` are:

```text
app/
├── Core/
├── UI/
├── Http/
├── Console/
└── Providers/
```

- `Core/` owns required base-application capabilities.
- `UI/` owns reusable UI PHP and runtime infrastructure.
- `Http/`, `Console/`, and `Providers/` are restricted application-wide Laravel integration boundaries.
- Optional Modules remain beneath repository-root `Modules/`.
- Owner-specific Laravel artifacts follow their Core, Module, or UI owner.

Root Laravel integration folders must not become default feature owners.

## 7. Core Capability Structure

Every permanent direct child of `app/Core/` represents one cohesive required capability.

```text
app/Core/<Capability>/
├── <TechnicalRole>/
├── routes/
├── config/
└── __tests__/
```

Structure is sparse. A capability contains only the roles and support branches it needs.

Each direct capability owner has one explicit identity record. Its PascalCase folder and namespace name, snake_case owner or capability keys, non-PHP slug, and documentation title remain separate representations.

Runtime persistence implementation remains owner-local:

```text
app/Core/<Capability>/Models/
app/Core/<Capability>/Data/
app/Core/<Capability>/Queries/
```

Core schema-lifecycle artifacts are grouped beneath:

```text
database/core/<Capability>/migrations/
database/core/<Capability>/factories/
database/core/<Capability>/seeders/
```

A Host owns its Registry and public Registry or Extension Point Contracts:

```text
app/Core/Dashboard/Contracts/
app/Core/Dashboard/Registry/
```

A Contributor owns its Contribution:

```text
app/Core/Audit/Contrib/Dashboard/
```

Do not create generic Core branches such as:

```text
app/Core/Models/
app/Core/Services/
app/Core/Support/
app/Core/Shared/
app/Core/Common/
app/Core/Infrastructure/
```

## 8. Module Package Structure

Every permanent directory beneath `Modules/` represents one optional Composer package.

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

A Module must be independently understandable, versioned, installable, distributable, explicit about dependencies, and locally verifiable.

A Module uses a PascalCase folder, the namespace `Parasolutions\Modules\<Module>\`, the Composer package `parasolutions/module-<module-slug>`, and its snake_case `module_key` as the default route-name and configuration root. These identities remain separate.

Its `src/` roles correspond to roles beneath `app/Core/<Capability>/`. Package-root support branches are not competing Technical Roles.

Module-to-Module dependencies require explicit public Contracts, declared package dependencies, and an acyclic dependency graph.

`Modules/_Template/` is not a Module; generator templates belong beneath `stubs/`.

## 9. Contract, Implementation, And Delivery Placement

A Contract belongs to the owner that makes and maintains the promise.

Default public Contract placement is:

```text
app/Core/<Capability>/Contracts/
Modules/<Module>/src/Contracts/
app/UI/<Responsibility>/Contracts/
```

A machine-readable UI artifact `contract.php` remains colocated with its presentation artifact.

Internal abstractions remain adjacent to the implementation role they support unless deliberately promoted into a public or cross-owner Contract.

Concrete implementation belongs beneath the narrowest owner and Technical Role that owns the behavior.

Delivery Adapters remain with the owner of the behavior they expose:

```text
app/Core/<Capability>/Http/
app/Core/<Capability>/Console/
Modules/<Module>/src/Http/
Modules/<Module>/src/Console/
```

Controllers, requests, middleware, commands, webhook handlers, protocol resources, presenters, renderers, ViewModels, and PageData own channel or presentation concerns and delegate application behavior inward.

Owner behavior must not depend outward on Delivery Adapters or Surfaces.

## 10. Routes, Configuration, And Application Registration

Core route definitions remain owner-local beneath the Core capability. Module routes remain package-local.

Root `routes/` contains only application-wide entrypoints, composition, global infrastructure, compatibility, and owner-route registration.

Configuration remains owner-specific:

- Core capability configuration remains beneath its owner;
- Module configuration remains beneath `Modules/<Module>/config/`;
- UI runtime configuration remains beneath its UI responsibility where required;
- root `config/` remains restricted to framework, application-wide composition, shared infrastructure, bootstrap, and compatibility.

Tenant settings, User preferences, editable operational state, and secrets are not Laravel configuration.

Each registrable owner exposes one explicit owner-controlled registration declaration. The architecture retains the terms Owner Registration Descriptor, Registration Compiler, Compiled Registration Manifest, Root Application Registrar, and Typed Registrar, but those responsibilities do not require one custom PHP class or wrapper per term.

A formal Module Definition, owner-local Provider, immutable Data Object, native framework integration, or dedicated descriptor may fulfill the applicable responsibility. When custom artifacts are independently justified, they follow the conditional names defined by [Repository Naming Standards](../02-standards/coding/repository-naming-standards.md).

See [Application Registration](application-registration.md) for the canonical registration architecture.

## 11. UI And Resource Structure

Login 2.0 uses artifact-owned presentation bundles.

A Component, Element, Pattern, or Layout colocates its applicable implementation, CSS, JavaScript, machine-readable Contract, tests, partials, and internal support.

```text
resources/views/components/ui/button/
├── index.blade.php
├── button.css
├── button.js
├── contract.php
└── __tests__/
```

Reusable UI artifacts remain UI-owned.

Core-owned presentation belongs beneath:

```text
resources/views/core/<Capability>/
```

Module-owned presentation remains package-local beneath:

```text
Modules/<Module>/resources/
```

Category aggregators explicitly and deterministically compose owner-declared bundles.

`resources/css/app.css` and `resources/js/app.js` remain the primary Vite entrypoints and composition roots.

Missing assets, duplicate declarations, unregistered imports, and stale generated composition must fail later validation. Uncontrolled glob discovery must not obscure CSS order or JavaScript initialization.

`public/` contains only assets requiring direct public access and is not the normal editable source owner.

## 12. Database, Test, And Documentation Placement

Runtime data code remains with the Core capability or Module that owns the state and behavior.

Generic root database lifecycle folders remain restricted to application bootstrap, genuinely cross-owner infrastructure, root composition, and bounded compatibility.

Human-readable schema and table Contracts remain beneath `docs/06-database/`. Detailed schema design remains Goal 6 authority.

Tests live as close as practical to the smallest clear owner:

```text
app/Core/<Capability>/__tests__/
app/UI/<Responsibility>/__tests__/
app/Http/__tests__/
app/Console/__tests__/
app/Providers/__tests__/
resources/views/**/__tests__/
Modules/<Module>/tests/
tests/
```

Root `tests/` remains for cross-owner integration, system and browser behavior, architecture, compatibility, repository rules, and shared test infrastructure.

Every accepted test location must be discovered deterministically in local and CI execution before physical movement.

Canonical documentation follows document type and authority rather than source adjacency.

Most meaningful repository folders default to:

```text
README.md
index.md
AGENTS.md
```

This is not a mandatory empty skeleton. One or more files may be omitted when the folder is deep and standardized, fully governed by an ancestor, generated, redundant, intentionally navigation-free, or deliberately excluded from scoped agent guidance. Omissions must not leave ownership, navigation, or execution requirements ambiguous.

## 13. Dependency Direction And Cross-Owner Communication

Dependencies flow toward stable provider-owned public boundaries.

- Core may depend on another Core capability’s public Contracts but not its internals.
- Core must not depend on optional Modules.
- Modules may depend on Core public Contracts and approved UI APIs.
- Module-to-Module dependencies require explicit public Contracts and declared package dependencies.
- reusable UI must not depend on Core or Module domain implementation;
- owner-specific Surfaces may depend on their owner’s behavior and reusable UI;
- Delivery Adapters depend inward on owner behavior;
- root Laravel integration may compose owners through public registration boundaries but must not absorb owner behavior.

Communication method follows interaction need:

| Need                                   | Boundary                                                                                      |
| -------------------------------------- | --------------------------------------------------------------------------------------------- |
| Immediate state-changing result        | Provider-owned public Contract exposing an owner-controlled Action or other defined operation |
| Immediate read                         | Provider-owned public Query Contract                                                          |
| Stable boundary values                 | Provider-owned Data Object                                                                    |
| Completed fact                         | Event                                                                                         |
| Independent reaction                   | Listener                                                                                      |
| Deferred, retryable, or scheduled work | Job                                                                                           |
| External invocation translation        | Owner-controlled Delivery Adapter                                                             |
| Extensible Host feature                | Host Extension Point Contract and Contributor-owned Contribution                              |
| Build or bootstrap composition         | Owner Registration Descriptor and Application Registration System                             |

Events and Jobs must not hide a required synchronous dependency.

Direct cross-owner concrete imports, Model or table access, generic shared services, static helpers, service location by concrete class, and hidden boot-time registration are prohibited.

## 14. Host, Registry, Contribution, And Registration Boundaries

A Host owns:

- its extensible feature;
- Registry;
- Registry and Extension Point Contracts;
- Contribution validation;
- ordering and resolution.

A Contributor retains its Contribution implementation beneath its own owner boundary.

The Application Registration System may validate and route a declared Contribution to a known Host Registry. It does not become the Registry.

`Contrib/<Host>/` is reserved for explicit Host Extension Point Contributions and is not a general route, view, command, configuration, or asset registration location.

## 15. Exceptions And Future Enforcement

A structural or dependency exception is permitted only for an exact framework, vendor, compatibility, migration, serialized-identifier, persisted-reference, or capability-specific constraint that cannot reasonably follow the accepted default.

Every exception records:

- governing rule;
- responsible owner;
- exact scope;
- permanent or transitional status;
- verified reason;
- permitted deviation;
- prohibited expansion;
- compatibility effect;
- required verification;
- repository-owner acceptance;
- objective removal condition and migration owner when transitional.

Exceptions are nonprecedential.

An unexpected mandatory architecture, dependency, discovery, or validation failure is a failure, not implicit permission to weaken a rule or create an exception.

Later enforcement should cover prohibited paths, registration completeness, duplicate declarations, stale generated output, dependency direction, Core independence, Module dependency cycles, UI isolation, test discovery, and significant-folder documentation.

## 16. Transitional And Prohibited Structures

Known transitional or compatibility-only locations include:

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

They establish no target ownership, must not receive new canonical work, and remain only while responsibilities are reclassified or compatibility is verified.

Do not introduce generic repository, application, Core, or Module ownership branches named:

```text
Platform/
Surfaces/
Shared/
Common/
Support/
Services/
Helpers/
Utilities/
Infrastructure/
```

Historical evidence may retain former paths and terminology when clearly identified as historical.

## 17. Compatibility And Migration

A non-target path may remain compatibility-only when removal would break a verified Contract such as serialized class names, framework configuration, package integration, discovery, routes, migrations, deployment integration, persisted identifiers, or external integrations.

Each exception must satisfy Section 15.

Removal requires accepted ownership and placement, resolved compatibility, passing verification, updated documentation, and repository-owner authorization.

## 18. Deferred Authority

Phase 5 accepted the folder, namespace, class, route, configuration, event, job, test, fixture, documentation, compatibility, and conditional Application Registration naming model.

Phase 6 owns representative architecture validation.

Phase 7 owns coarse current-to-target mappings, compatibility direction, and final Goal 3 acceptance.

Detailed schema remains Goal 6 authority. Complete verification architecture and runtime registration tooling remain later bounded work.

## 19. Related

- [Architecture Index](index.md)
- [Application Registration](application-registration.md)
- [System Overview](system-overview.md)
- [Stack Overview](stack-overview.md)
- [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
- [ADR-0007: Owner, Registry, And Identifier Key Conventions](../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Goal 3 Target Repository Architecture](../07-planning/Milestones/milestone-0/goal-3/target-repository-architecture.md)
- [Phase 4 Placement And Dependency Rules Index](../07-planning/Milestones/milestone-0/goal-3/phase-4/index.md)
- [Phase 4 Artifact Placement Matrix](../07-planning/Milestones/milestone-0/goal-3/phase-4/artifact-placement-matrix.md)
- [Phase 4 Dependency And Communication Matrix](../07-planning/Milestones/milestone-0/goal-3/phase-4/dependency-and-communication-matrix.md)
- [Phase 5 Naming Conventions Index](../07-planning/Milestones/milestone-0/goal-3/phase-5/index.md)
- [Repository Naming Standards](../02-standards/coding/repository-naming-standards.md)
