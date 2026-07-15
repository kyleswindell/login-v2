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
summary: Defines the accepted target repository topology, application owner roots, Core and Module patterns, presentation bundles, test locations, supporting branches, and transitional structures.
-->

# Repository Architecture

Parent: [Architecture Index](index.md)

## 1. Purpose

This document is the canonical architecture owner for the accepted target repository topology of Login 2.0.

It defines permanent branches and structural ownership patterns. It does not map every current file, perform migration, or decide detailed placement and naming owned by later Goal 3 phases.

## 2. Status And Scope

- Target architecture: accepted through Goal 3 Phase 3
- Current implementation: transitional
- Detailed placement and dependencies: pending Phase 4
- Final naming: pending Phase 5
- Migration direction: pending Phase 7

This document owns:

- repository-root and direct `app/` branches;
- Core and Module physical patterns;
- presentation-bundle and test-location patterns;
- supporting-branch responsibilities;
- transitional, compatibility-only, and prohibited structures.

It does not own feature behavior, schema design, exact artifact placement, dependency rules, naming, or physical migration.

## 3. Architecture Principles

Login 2.0 uses owner-first, capability-first organization.

Application responsibilities belong first to:

1. Core;
2. an optional Module;
3. UI;
4. a bounded application-wide Laravel integration boundary.

Technical Roles such as Surface, Delivery Adapter, Registry, Action, Query, Contract, Model, Policy, Job, Event, Listener, Notification, Rule, and Livewire implementation remain beneath an explicit owner.

Broad use does not create generic ownership.

## 4. Target Repository Tree

The target tree is sparse. Optional branches exist only when required.

```text
/
├── .agents/
├── .docker/
├── .github/
├── app/
│   ├── Core/<Capability>/<TechnicalRole>/
│   ├── UI/<Responsibility>/<TechnicalRole>/
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

Acceptance of a branch does not accept every current child path, artifact, or name beneath it.

## 5. Root Branch Responsibilities

| Root | Responsibility |
| --- | --- |
| `.agents/` | Repository-local agent skills and bounded execution guidance |
| `.docker/` | Container definitions, initialization, and container support |
| `.github/` | GitHub workflows, templates, ownership metadata, and automation |
| `app/` | Base-application PHP source and bounded Laravel integration |
| `bootstrap/` | Laravel bootstrap and required cache structure |
| `config/` | Root Laravel and base-application configuration |
| `database/` | Base-application database integration and cross-owner support |
| `docs/` | Canonical repository documentation |
| `Modules/` | Optional independently distributable packages |
| `ops/` | Machine-consumed operational and deployment assets |
| `public/` | Public web root and publishable assets |
| `resources/` | Presentation source and primary asset entrypoints |
| `routes/` | Root route registration and bounded global routes |
| `scripts/` | Repository validation, generation, maintenance, and orchestration |
| `storage/` | Laravel runtime state and tracked placeholders |
| `stubs/` | Generator and scaffolding inputs |
| `tests/` | Cross-owner and repository-wide verification |

Generated dependencies, build outputs, reports, and runtime artifacts are not canonical repository branches.

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
app/Core/<Capability>/<TechnicalRole>/
app/Core/<Capability>/__tests__/
```

Structure is sparse. A capability contains only the roles it needs.

A Host owns its Registry:

```text
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

Its `src/` roles correspond to roles beneath `app/Core/<Capability>/`. Package-root support branches are not competing Technical Roles.

`Modules/_Template/` is not a Module; generator templates belong beneath `stubs/`.

## 9. UI And Resource Structure

Login 2.0 uses artifact-owned presentation bundles.

A Component, Element, Pattern, or Layout colocates its applicable implementation, CSS, JavaScript, machine-readable contract, tests, partials, and internal support.

```text
resources/views/components/ui/button/
├── index.blade.php
├── button.css
├── button.js
├── contract.php
└── __tests__/
```

Category aggregators explicitly and deterministically compose bundles.

`resources/css/app.css` and `resources/js/app.js` remain the primary Vite entrypoints and composition roots.

Core-owned and Module-owned presentation follows the same colocation principle within its owner boundary.

## 10. Test Locations

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

Deterministic local and CI discovery must be proven before tests move.

## 11. Transitional And Prohibited Structures

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

## 12. Compatibility And Migration

A non-target path may remain compatibility-only when removal would break a verified contract such as serialized class names, framework configuration, package integration, discovery, routes, migrations, deployment integration, persisted identifiers, or external integrations.

Each exception must record:

- exact path and owner;
- dependency requiring retention;
- permitted deviation and prohibited expansion;
- verification;
- removal condition;
- migration owner.

Removal requires accepted ownership and placement, resolved compatibility, passing verification, updated documentation, and repository-owner authorization.

## 13. Deferred Authority

Phase 4 owns exact placement, dependency direction, cross-owner communication, exceptions, and future enforcement.

Phase 5 owns final folder, namespace, class, route, configuration, event, job, test, fixture, aggregator, alias, and compatibility naming.

This document must not decide those details prematurely.

## 14. Related

- [Architecture Index](index.md)
- [System Overview](system-overview.md)
- [Stack Overview](stack-overview.md)
- [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
- [Goal 3 Target Repository Architecture](../07-planning/Milestones/milestone-0/goal-3/target-repository-architecture.md)
- [Phase 3 Target Repository Tree Index](../07-planning/Milestones/milestone-0/goal-3/phase-3/index.md)
