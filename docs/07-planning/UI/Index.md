<!--
DOC-META
title: UI Index
doc_type: index
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/UI/Index.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the architecture, contract, implementation, review, and migration documents for the reusable UI system.
-->

# UI Index

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

This folder routes the architecture and planning documentation for the reusable UI system within Login 2.0. It supports reusable presentation contracts, tiers, placement, review, implementation, and migration planning while the canonical ownership boundary remains external in the [UI Definition](../Definitions/UI/Definition.md).

## 2. Scope

### 2.1. Belongs Here

UI-specific architecture and planning documents belong here when they address reusable Elements, Components, Patterns, and Layouts; design tokens and icons; reusable CSS and JavaScript controls; accessibility and interaction behavior; presentation-only contracts; tests and review requirements; or UI placement, naming, implementation, and migration work.

### 2.2. Does Not Belong Here

Routed Core or Module pages, feature-specific views and workflows, authorization or navigation resolution, persistence or domain behavior, generic Surface definitions, and active GitHub issue or Project status belong with their respective canonical owners.

## 3. Documents

| Document                                              | Purpose                                                                                         | Status |
| ----------------------------------------------------- | ----------------------------------------------------------------------------------------------- | ------ |
| [README](README.md)                                   | Explains the UI documentation package, reading order, required files, and maintenance rules.    | active |
| [UI Definition](../Definitions/UI/Definition.md)      | Defines UI ownership, classification, presentation boundaries, dependencies, and target status. | active |
| [AGENTS](AGENTS.md)                                   | Provides agent-facing routing and folder-specific working rules.                                | active |

## 4. Subfolders

No subfolders currently exist.

## 5. Maintenance Notes

* Keep this index current when child documents are added, moved, split, archived, or superseded.
* Do not duplicate child document content in this index.
* Use this index for routing and discovery.

## 6. Related

* [Planning Index](../index.md)
* [UI Definition](../Definitions/UI/Definition.md)
* [M0 Target Repository Architecture](../00-overview/m0-target-repository-architecture.md)
