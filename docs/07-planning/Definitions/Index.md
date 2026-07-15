<!--
DOC-META
title: Definitions Index
doc_type: index
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Definitions/Index.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes canonical reusable architecture definitions for Login 2.0.
-->

# Definitions Index

Parent: [Planning Index](../index.md)

Use this index to locate canonical reusable architecture definitions.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
  - [2.1. Belongs Here](#21-belongs-here)
  - [2.2. Does Not Belong Here](#22-does-not-belong-here)
- [3. Documents](#3-documents)
- [4. Subfolders](#4-subfolders)
- [5. Maintenance Notes](#5-maintenance-notes)
- [6. Related](#6-related)

## 1. Purpose

This folder owns canonical reusable architecture definitions for Login 2.0.

Each concept has one authoritative `Definition.md` that establishes:

* what the concept means;
* how responsibilities are classified;
* what the concept owns;
* what it must not own;
* permitted and prohibited dependencies;
* permanent, transitional, or proposed target status.

Definitions are independent of current physical implementation placement.

## 2. Scope

### 2.1. Belongs Here

This folder contains definitions for concepts that:

* are used across multiple repository or documentation areas;
* require one stable meaning;
* establish an ownership, classification, responsibility, or dependency boundary;
* must be consumed by planning, architecture, standards, implementation, or agent guidance.

### 2.2. Does Not Belong Here

This folder does not contain:

* implementation plans;
* migration plans;
* file inventories;
* feature behavior;
* execution flows;
* schema or data contracts;
* operational procedures;
* active issue or Project status;
* glossary entries that do not require a formal architecture boundary.

## 3. Documents

| Document                                     | Purpose                                                                              | Status |
| -------------------------------------------- | ------------------------------------------------------------------------------------ | ------ |
| [Core Definition](Core/Definition.md)        | Defines required and authoritative base-application ownership.                       | active |
| [Laravel Definition](Laravel/Definition.md)  | Defines Laravel as the application framework, runtime, and composition system.       | active |
| [Module Definition](Modules/Definition.md)   | Defines optional Module ownership, lifecycle, packaging, and dependency boundaries.  | active |
| [Surface Definition](Surfaces/Definition.md) | Defines Surfaces as assembled interaction boundaries rather than application owners. | active |
| [UI Definition](UI/Definition.md)            | Defines reusable presentation infrastructure and UI dependency boundaries.           | active |

## 4. Subfolders

Each concept subfolder contains one canonical `Definition.md`.

| Folder      | Purpose                                              |
| ----------- | ---------------------------------------------------- |
| `Core/`     | Core ownership and classification.                   |
| `Laravel/`  | Laravel framework and integration boundary.          |
| `Modules/`  | Module ownership, lifecycle, and packaging boundary. |
| `Surfaces/` | Surface interaction-boundary definition.             |
| `UI/`       | Reusable UI ownership and presentation boundary.     |

Concept subfolders do not require their own README, index, or AGENTS file unless later documentation growth justifies a separate package.

## 5. Maintenance Notes

* Keep this index current when definitions are added, moved, renamed, accepted, superseded, or removed.
* Every definition must use `docs/09-reference/templates/docs/_definition.md`.
* Every definition must identify this file as its metadata parent.
* Every definition must link visibly to this index using `../Index.md`.
* Do not duplicate definition content in this index.
* Do not create competing definitions for the same concept.
* Update consuming planning packages when a definition path or status changes.

## 6. Related

* [Planning Index](../index.md)
* [M0 Target Repository Architecture](../00-overview/m0-target-repository-architecture.md)
* [Definition Document Type](../../02-standards/documentation/doc-types/definitions/definition.md)
* [Definition Template](../../09-reference/templates/docs/_definition.md)