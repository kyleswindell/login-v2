<!--
DOC-META
title: Core Index
doc_type: index
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/Core/Index.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the architecture, capability, implementation, and migration documents owned by Core.
-->

# Core Index

Parent: [Planning Index](../index.md)

Use this index to navigate the documents in this folder.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
  - [2.1. Belongs Here](#21-belongs-here)
  - [2.2. Does Not Belong Here](#22-does-not-belong-here)
- [3. Documents](#3-documents)
- [4. Subfolders](#4-subfolders)
- [5. Maintenance Notes](#5-maintenance-notes)
- [6. Related](#6-related)

## 1. Purpose

This folder routes the architecture and planning documentation for Core within Login 2.0. It supports Core-specific capability, contract, placement, implementation, and migration planning while the canonical ownership boundary remains external in the [Core Definition](../Definitions/Core/Definition.md).

## 2. Scope

### 2.1. Belongs Here

Core-specific architecture and planning documents belong here when they address required base-application capabilities; application-wide coordination or lifecycle; contracts consumed by optional Modules; Core-owned persistence, infrastructure, delivery, or presentation; or Core implementation and migration work.

### 2.2. Does Not Belong Here

Optional Module definitions, reusable UI-system definitions, generic Surface definitions, non-Core Laravel integration rules, implemented feature, flow, or schema truth, and active GitHub issue or Project status belong with their respective canonical owners.

## 3. Documents

| Document                                                   | Purpose                                                                                        | Status |
| ---------------------------------------------------------- | ---------------------------------------------------------------------------------------------- | ------ |
| [README](README.md)                                        | Explains the Core documentation package, reading order, required files, and maintenance rules. | active |
| [Core Definition](../Definitions/Core/Definition.md)       | Defines Core ownership, classification, dependencies, and target status.                       | active |
| [AGENTS](AGENTS.md)                                        | Provides agent-facing routing and folder-specific working rules.                               | active |

## 4. Subfolders

No subfolders currently exist.

## 5. Maintenance Notes

* Keep this index current when child documents are added, moved, split, archived, or superseded.
* Do not duplicate child document content in this index.
* Use this index for routing and discovery.

## 6. Related

* [Planning Index](../index.md)
* [Core Definition](../Definitions/Core/Definition.md)
* [M0 Target Repository Architecture](../00-overview/m0-target-repository-architecture.md)
