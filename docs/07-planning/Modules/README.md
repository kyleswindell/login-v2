<!--
DOC-META
title: Modules
doc_type: readme
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Modules/README.md
parent: docs/07-planning/Modules/Index.md
template: docs/09-reference/templates/docs/_readme.md
summary: Explains the purpose, required documents, reading order, and maintenance rules for the Modules architecture documentation package.
-->

# Modules

Parent: [Modules Index](Index.md)

Use this README to understand the purpose, structure, and maintenance rules for the Modules documentation package.

- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. Folder Contract](#3-folder-contract)
- [4. Required Files](#4-required-files)
- [5. Content Rules](#5-content-rules)
- [6. Maintenance](#6-maintenance)
- [7. Related](#7-related)

## 1. Purpose

This folder owns the architecture and planning documentation for optional Modules within Login 2.0.

A Module is a cohesive feature set with an independent lifecycle that may be installed, enabled, assigned, updated, disabled, or omitted without breaking Core.

The documents in this folder define:

* the Module ownership boundary;
* the mandatory Composer-package target state;
* Module lifecycle and dependency rules;
* Module extension and contribution rules;
* Module repository organization and placement;
* Module implementation and migration planning.

## 2. Read Order

Read this package in the following order:

1. `README.md` for package purpose and document rules.
2. [Module Definition](../Definitions/Modules/Definition.md) for the authoritative Module boundary.
3. `Index.md` to locate additional Module documents.
4. Supporting documents only when their specific subject is required.

## 3. Folder Contract

This folder contains documentation for Modules as an architecture ownership area.

Documents belong here when they primarily define or plan:

* optional feature ownership;
* Module package structure;
* Module lifecycle and compatibility;
* Module dependencies and extensions;
* Module contracts and contributions;
* Module-specific placement and naming;
* Module implementation or migration work.

This folder does not own:

* required Core capabilities;
* reusable UI-system definitions;
* generic delivery-Surface definitions;
* Laravel integration rules that are not Module-specific;
* individual Module product behavior that belongs in feature documentation;
* active GitHub issue or Project status.

No subfolders are created unless the Modules document set grows beyond a practical flat structure and a later architecture decision authorizes subdivision.

## 4. Required Files

Every standardized architecture documentation package contains:

| File        | Purpose                                                          |
| ----------- | ---------------------------------------------------------------- |
| `README.md` | Explains how the package is organized and maintained.            |
| `AGENTS.md` | Provides agent-facing routing and folder-specific working rules. |
| `Index.md`  | Routes readers to the documents contained in the package.        |

The canonical Module definition is external to this package: [Module Definition](../Definitions/Modules/Definition.md).

Additional documents may be added when they own a distinct Module architecture subject that is not owned by the central [Module Definition](../Definitions/Modules/Definition.md).

Individual Module documentation packages are defined separately from this architecture-area package.

## 5. Content Rules

* Keep the [Module Definition](../Definitions/Modules/Definition.md) authoritative for the Module boundary.
* Keep `Index.md` focused on routing and document status.
* Keep this README focused on package use and maintenance.
* Do not duplicate complete sections between package documents.
* Do not classify required base behavior as a Module because it is package-shaped.
* Do not classify a folder as Module-owned solely because it exists under `Modules/`.
* Keep Module ownership separate from Composer identity, folder name, namespace, route prefix, display name, and `module_key`.
* Treat independent Composer packaging as the mandatory target state.
* Keep accepted target rules separate from transitional implementation state.
* Link detailed implementation and migration plans rather than copying their complete content.
* Promote durable cross-cutting decisions to the appropriate decision record.

## 6. Maintenance

Update this package when:

* the accepted Module boundary changes;
* the mandatory Module package contract changes;
* Module dependency or extension rules change;
* a supporting document is added, moved, superseded, or removed;
* a transitional rule becomes permanent or is retired;
* a related architecture decision changes;
* Goal 03 accepts a repository placement or naming rule affecting Modules.

Keep metadata, parent links, document links, and lifecycle status current.

## 7. Related

* [Module Definition](../Definitions/Modules/Definition.md)
* [Modules Index](Index.md)
* [Planning Index](../index.md)
* [M0 Target Repository Architecture](../00-overview/m0-target-repository-architecture.md)
* [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
* [ADR-0007: Owner, Registry, And Identifier Key Conventions](../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
