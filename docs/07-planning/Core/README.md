<!--
DOC-META
title: Core
doc_type: readme
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Core/README.md
parent: docs/07-planning/Core/Index.md
template: docs/09-reference/templates/docs/_readme.md
summary: Explains the purpose, required documents, reading order, and maintenance rules for the Core architecture documentation package.
-->

# Core

Parent: [Core Index](Index.md)

Use this README to understand the purpose, structure, and maintenance rules for the Core documentation package.

- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. Folder Contract](#3-folder-contract)
- [4. Required Files](#4-required-files)
- [5. Content Rules](#5-content-rules)
- [6. Maintenance](#6-maintenance)
- [7. Related](#7-related)

## 1. Purpose

This folder owns the architecture and planning documentation for Core within Login 2.0.

Core represents the required and authoritative base application that must operate without optional Modules.

The documents in this folder define:

* the Core ownership boundary;
* Core capabilities and responsibilities;
* Core contracts and dependency rules;
* Core repository organization and placement;
* Core implementation and migration planning.

## 2. Read Order

Read this package in the following order:

1. `README.md` for the package purpose and document rules.
2. `Definition.md` for the authoritative Core boundary.
3. `Index.md` to locate additional Core documents.
4. Supporting documents only when their specific subject is required.

## 3. Folder Contract

This folder contains documentation owned by Core as an architecture area.

Documents belong here when they primarily define or plan:

* required base-application capabilities;
* application-wide coordination or lifecycle;
* contracts consumed by optional Modules;
* Core-owned persistence or infrastructure;
* Core-owned delivery and presentation behavior;
* Core-specific implementation or migration work.

This folder does not own:

* optional Module definitions or implementation plans;
* reusable UI-system definitions;
* generic delivery-Surface definitions;
* Laravel framework integration rules that are not Core-specific;
* active GitHub issue or Project status.

No subfolders are created unless the Core document set grows beyond a practical flat structure and a later architecture decision authorizes subdivision.

## 4. Required Files

Every standardized architecture documentation package contains:

| File            | Purpose                                                                    |
| --------------- | -------------------------------------------------------------------------- |
| `README.md`     | Explains how the package is organized and maintained.                      |
| `Definition.md` | Defines the package’s ownership boundary, dependencies, and target status. |
| `Index.md`      | Routes readers to the documents contained in the package.                  |

Additional documents may be added when they own a distinct Core subject that does not belong in `Definition.md`.

## 5. Content Rules

* Keep `Definition.md` authoritative for the Core boundary.
* Keep `Index.md` focused on routing and document status.
* Keep this README focused on package use and maintenance.
* Do not duplicate complete sections between package documents.
* Do not classify a responsibility as Core solely because it is shared.
* Do not treat physical placement or package shape as ownership proof.
* Keep accepted target rules separate from transitional implementation state.
* Link supporting implementation and migration plans rather than copying their complete content.
* Promote durable cross-cutting decisions to the appropriate decision record.

## 6. Maintenance

Update this package when:

* the accepted Core boundary changes;
* a Core capability is added, removed, split, or reclassified;
* a supporting document is added, moved, superseded, or removed;
* a transitional rule becomes permanent or is retired;
* a related architecture decision changes;
* Goal 03 accepts a new repository placement or naming rule affecting Core.

Keep metadata, parent links, document links, and lifecycle status current.

## 7. Related

* [Core Definition](../Definitions/Core/Definition.md)
* [Core Index](Index.md)
* [Planning Index](../index.md)
* [M0 Target Repository Architecture](../00-overview/m0-target-repository-architecture.md)
* [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
