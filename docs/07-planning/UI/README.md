<!--
DOC-META
title: UI
doc_type: readme
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/UI/README.md
parent: docs/07-planning/UI/Index.md
template: docs/09-reference/templates/docs/_readme.md
summary: Explains the purpose, required documents, reading order, and maintenance rules for the UI architecture documentation package.
-->

# UI

Parent: [UI Index](Index.md)

Use this README to understand the purpose, structure, and maintenance rules for the UI documentation package.

- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. Folder Contract](#3-folder-contract)
- [4. Required Files](#4-required-files)
- [5. Content Rules](#5-content-rules)
- [6. Maintenance](#6-maintenance)
- [7. Related](#7-related)

## 1. Purpose

This folder owns the architecture and planning documentation for the reusable UI system within Login 2.0.

The documents in this folder define:

* the UI ownership boundary;
* reusable presentation responsibilities;
* UI contract and dependency rules;
* reusable Elements, Components, Patterns, and Layouts;
* design tokens, icons, CSS, and JavaScript controls;
* UI placement, naming, implementation, and migration planning.

## 2. Read Order

Read this package in the following order:

1. `README.md` for package purpose and document rules.
2. [UI Definition](../Definitions/UI/Definition.md) for the authoritative UI boundary.
3. `Index.md` to locate additional UI documents.
4. Supporting documents only when their specific subject is required.

## 3. Folder Contract

This folder contains documentation for UI as an architecture ownership area.

Documents belong here when they primarily define or plan:

* reusable presentation infrastructure;
* UI Elements, Components, Patterns, and Layouts;
* design tokens and icons;
* reusable CSS and JavaScript controls;
* accessibility and interaction behavior;
* presentation-only contracts;
* UI tests, examples, references, and review requirements;
* UI-specific placement, naming, implementation, or migration work.

This folder does not own:

* routed Core or Module pages;
* feature-specific views and workflows;
* authorization or navigation resolution;
* persistence or domain behavior;
* generic delivery-Surface definitions;
* active GitHub issue or Project status.

No subfolders are created unless the UI document set grows beyond a practical flat structure and a later architecture decision authorizes subdivision.

## 4. Required Files

Every standardized architecture documentation package contains:

| File        | Purpose                                                          |
| ----------- | ---------------------------------------------------------------- |
| `README.md` | Explains how the package is organized and maintained.            |
| `AGENTS.md` | Provides agent-facing routing and folder-specific working rules. |
| `Index.md`  | Routes readers to the documents contained in the package.        |

The canonical UI definition is external to this package: [UI Definition](../Definitions/UI/Definition.md).

Additional documents may be added when they own a distinct UI subject that is not owned by the central [UI Definition](../Definitions/UI/Definition.md).

## 5. Content Rules

* Keep the [UI Definition](../Definitions/UI/Definition.md) authoritative for the UI boundary.
* Keep `Index.md` focused on routing and document status.
* Keep this README focused on package use and maintenance.
* Do not duplicate complete sections between package documents.
* Do not classify a file as UI-owned solely because it is Blade, CSS, JavaScript, or under `resources/`.
* Do not place routed or capability-specific behavior under UI ownership.
* Keep UI contracts presentation-only.
* Keep accepted target rules separate from transitional implementation state.
* Link detailed implementation and migration plans rather than copying their complete content.
* Promote durable cross-cutting decisions to the appropriate decision record.

## 6. Maintenance

Update this package when:

* the accepted UI boundary changes;
* a UI tier or contract family is added, removed, split, or reclassified;
* reusable layout or shell ownership changes;
* a supporting document is added, moved, superseded, or removed;
* a transitional rule becomes permanent or is retired;
* a related architecture decision changes;
* Goal 03 accepts a placement or naming rule affecting UI.

Keep metadata, parent links, document links, and lifecycle status current.

## 7. Related

* [UI Definition](../Definitions/UI/Definition.md)
* [UI Index](Index.md)
* [Planning Index](../index.md)
* [M0 Target Repository Architecture](../00-overview/m0-target-repository-architecture.md)
* [ADR-0005: Core, Modules, And UI Ownership Taxonomy](../../01-decisions/adr-0005-core-modules-ui-ownership-taxonomy.md)
