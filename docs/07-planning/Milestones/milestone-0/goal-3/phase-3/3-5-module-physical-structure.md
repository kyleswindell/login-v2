<!--
DOC-META
title: Phase 3.5 Module Physical Structure
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/3-5-module-physical-structure.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-3/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records the target independently distributable Module package structure, required package elements, sparse Technical Roles, local resources, and template disposition.
-->

# Phase 3.5 Module Physical Structure

Parent: [Phase 3 Target Repository Tree Index](index.md)

## 1. Purpose

This document records the standard physical package structure for optional Modules beneath `Modules/`.

## 2. Status

- Planning lifecycle: planned
- Acceptance state: accepted through repository-owner Phase 3 review
- Implementation state: target direction only
- Owning GitHub issue: #50
- Depends on: accepted Phase 1 Module boundary and Phase 2 organization

## 3. Current Evidence

The current `Modules/*` folders are application-area packages rather than independently distributable Composer packages:

- none has package-local Composer metadata;
- PHP source sits directly at the package root;
- packages contain both `Definition.php` and `module.php`;
- most packages lack local tests or substantial package documentation;
- `_Template/` creates a universal empty skeleton;
- generic folders such as `Services/`, `Support/`, `Header/`, and `Navigation/` do not follow the accepted role vocabulary.

Current packages remain evidence and are not accepted as the target Module catalog.

## 4. Target Package Pattern

```text
Modules/
└── <Module>/
    ├── composer.json
    ├── README.md
    ├── src/
    │   ├── Definition.php
    │   ├── Actions/
    │   ├── Queries/
    │   ├── Contracts/
    │   ├── Data/
    │   ├── Models/
    │   ├── Policies/
    │   ├── Events/
    │   ├── Listeners/
    │   ├── Jobs/
    │   ├── Notifications/
    │   ├── Providers/
    │   ├── Http/
    │   ├── Console/
    │   ├── Registry/
    │   ├── Surface/
    │   └── Contrib/
    │       └── <Host>/
    ├── config/
    ├── routes/
    ├── database/
    │   ├── migrations/
    │   ├── factories/
    │   └── seeders/
    ├── resources/
    │   ├── views/
    │   ├── css/
    │   ├── js/
    │   └── lang/
    ├── tests/
    │   ├── Unit/
    │   ├── Feature/
    │   ├── Contracts/
    │   ├── Architecture/
    │   ├── Fixtures/
    │   └── Support/
    └── docs/
```

The pattern is sparse. Optional branches exist only when the Module needs them.

## 5. Required Package Elements

| Element                      | Requirement                                                                                   |
| ---------------------------- | --------------------------------------------------------------------------------------------- |
| `composer.json`              | Package identity, PSR-4 autoloading, dependencies, compatibility, and development autoloading |
| `README.md`                  | Package orientation, purpose, installation expectations, dependencies, and links              |
| `src/`                       | Module-owned PHP source                                                                       |
| One formal Module definition | Canonical Module identity and lifecycle contract                                              |
| `tests/`                     | Module-owned verification appropriate to the package                                          |

The final definition class name remains Phase 5 authority.

## 6. One Canonical Definition Authority

The current combination:

```text
Definition.php
module.php
```

must not remain as two permanent authorities.

The target separates responsibilities:

```text
composer.json
→ package identity, autoloading, dependencies, and Composer metadata

src/Definition.php
→ Login 2.0 Module identity, lifecycle, compatibility, and Contribution contract

src/Providers/
→ Laravel registration when required
```

Existing root `module.php` files are transitional or compatibility-only.

## 7. PHP Roles Versus Package Branches

A Module’s `src/` directory contains PHP Technical Roles equivalent to those beneath `app/Core/<Capability>/`.

| Core                        | Module                           |
| --------------------------- | -------------------------------- |
| `app/Core/Audit/Actions/`   | `Modules/Example/src/Actions/`   |
| `app/Core/Audit/Models/`    | `Modules/Example/src/Models/`    |
| `app/Core/Audit/Http/`      | `Modules/Example/src/Http/`      |
| `app/Core/Audit/Providers/` | `Modules/Example/src/Providers/` |
| `app/Core/Audit/Surface/`   | `Modules/Example/src/Surface/`   |
| `app/Core/Audit/__tests__/` | `Modules/Example/tests/`         |

Package-root `routes/`, `config/`, `database/`, `resources/`, `tests/`, and `docs/` are package integration and support branches, not competing Technical Roles.

## 8. Package-Local Ownership

Module-owned artifacts remain package-local by default:

- configuration;
- routes;
- migrations, factories, and seeders;
- views and localization;
- Module-specific CSS and JavaScript;
- tests;
- package documentation;
- owner-local Delivery Adapters;
- owner-local Surfaces;
- Contributions to other Hosts.

Root application branches must not become the normal home of Module-owned artifacts.

## 9. Generic Current Roles

Current generic roles require later reclassification:

| Current folder        | Target interpretation                                                    |
| --------------------- | ------------------------------------------------------------------------ |
| `Services/`           | Actions, Queries, Contracts, Registry, or another accepted cohesive role |
| `Support/`            | Explicit owner responsibility or retirement                              |
| `Header/`             | Surface composition or Contribution to a Shell/Header Host               |
| `Navigation/`         | Host Registry, Surface composition, or Contribution                      |
| root `Http/`          | `src/Http/`                                                              |
| root `Models/`        | `src/Models/`                                                            |
| root `Providers/`     | `src/Providers/`                                                         |
| root `Notifications/` | `src/Notifications/` when these are notification implementations         |

## 10. Sparse Package Rule

A Module without database artifacts does not contain `database/`.

A Module without UI does not contain `resources/` or `Surface/`.

A Module without routes does not contain `routes/` or `Http/`.

Empty `.gitkeep` folders must not imply a universal Module skeleton.

## 11. `_Template/` Disposition

`Modules/_Template/` is not a Module.

Target direction:

```text
stubs/modules/
```

The replacement generator template must create:

- required package files;
- roles explicitly selected by the generator;
- no empty universal skeleton.

## 12. Tests And Documentation

Module-local tests remain at package root:

```text
Modules/<Module>/tests/
```

Package-local `docs/` is optional. Repository-wide canonical architecture, standards, feature, database, planning, and runbook truth remains under root `docs/`.

## 13. Current Catalog Boundary

The current:

```text
Account
Auth
Dashboard
Notifications
Preferences
Roles
Settings
Setup
```

remain implementation evidence.

Later disposition and migration work determines whether each becomes a Core capability, remains an optional Module, is split, becomes compatibility code, or is retired.

## 14. Accepted Decision

> Every permanent directory beneath `Modules/` represents one optional, independently understandable, versioned, installable, and distributable Composer package. A Module requires package-local Composer metadata, a README, PHP source beneath `src/`, one canonical Module definition, and Module-owned verification. Technical Roles are organized sparsely beneath `src/`. Configuration, routes, database artifacts, resources, tests, and package documentation remain package-local when required. Root `module.php` files and parallel definition authorities are transitional. Generic `Services`, `Support`, `Header`, and `Navigation` folders are not accepted target roles and must be reclassified. `Modules/_Template/` is not a Module and must move to generator-owned structure beneath `stubs/`. Acceptance of this package pattern does not accept the current `Modules/*` folders as the target Module catalog.

> A Module’s `src/` directory contains PHP Technical Roles equivalent to those beneath `app/Core/<Capability>/`. Package-root `routes/`, `config/`, `database/`, `resources/`, `tests/`, and `docs/` are package integration and support branches rather than competing Technical Roles. Their Core equivalents are determined through the base application’s supporting branches and Phase 4 placement rules.

## 15. Related

- [Phase 3 Index](index.md)
- [Core Physical Structure](3-4-core-physical-structure.md)
- [UI And Resource Structure](3-6-ui-and-resource-structure.md)
- [Test Folder Locations](3-9-test-folder-locations.md)
- Related GitHub issue: #50