<!--
DOC-META
title: Laravel
doc_type: readme
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/temp/Laravel/README.md
parent: docs/07-planning/temp/Laravel/Index.md
template: docs/09-reference/templates/docs/_readme.md
summary: Explains the temporary planning package used to define Laravel integration, root-folder roles, owner-local conventions, and migration direction during Goal 03.
-->

# Laravel

Parent: [Laravel Index](Index.md)

Use this README to understand the temporary Laravel planning package.

- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. Folder Contract](#3-folder-contract)
- [4. Required Files](#4-required-files)
- [5. Content Rules](#5-content-rules)
- [6. Maintenance](#6-maintenance)
- [7. Related](#7-related)

## 1. Purpose

This folder temporarily owns Goal 03 planning for Laravel’s role in the target repository architecture.

The canonical Laravel definition is stored separately.

This package may develop:

* root Laravel folder roles;
* application-wide framework integration rules;
* owner-local Laravel conventions;
* bootstrap and registration patterns;
* artifact placement and dependency rules;
* naming conventions;
* migration and compatibility direction.

## 2. Read Order

Read this package in the following order:

1. `README.md` for the package purpose and temporary status.
2. [Laravel Definition](../../Definitions/Laravel/Definition.md) for the governing framework boundary.
3. `Index.md` to locate temporary planning documents.
4. Supporting documents only when their specific subject is required.

## 3. Folder Contract

This folder contains temporary Laravel architecture planning while Goal 03 determines permanent repository roles and documentation owners.

Documents belong here when they:

* depend on the Laravel definition;
* analyze Laravel framework integration or root folders;
* distinguish application-wide integration from owner-specific artifacts;
* address placement, naming, registration, migration, or compatibility;
* do not yet have an accepted permanent documentation owner.

This folder does not own:

* the canonical Laravel definition;
* Core, Module, UI, or Surface definitions;
* feature behavior;
* implementation code;
* permanent architecture after promotion;
* unrelated temporary notes.

The folder must be reconciled, promoted, or removed before Goal 03 final acceptance.

## 4. Required Files

This temporary package contains:

| File        | Purpose                                                   |
| ----------- | --------------------------------------------------------- |
| `README.md` | Explains the temporary package and its maintenance rules. |
| `Index.md`  | Routes readers to temporary Laravel planning documents.   |
| `AGENTS.md` | Guides agents working inside the temporary package.       |

The governing definition is maintained at:

* `docs/07-planning/Definitions/Laravel/Definition.md`

## 5. Content Rules

* Do not duplicate the Laravel definition.
* Preserve Core, Module, and UI ownership.
* Treat Laravel as framework and composition infrastructure, not an application owner.
* Prefer Laravel-native conventions within owner-first boundaries.
* Do not make root Laravel folders generic homes for owner-specific code.
* Do not present proposed folder placement as accepted architecture.
* Keep current implementation, target state, and migration direction separate.
* Promote durable accepted content to its permanent owner.

## 6. Maintenance

Update this package when:

* a Laravel planning document is added, moved, promoted, superseded, or removed;
* a root-folder role is proposed or accepted;
* owner-local Laravel conventions are accepted;
* a permanent documentation owner is established;
* temporary material is promoted or retired.

Before Goal 03 closes:

* promote durable Laravel architecture;
* update affected indexes and links;
* remove superseded temporary documents;
* remove this package if it no longer owns active planning.

## 7. Related

* [Laravel Definition](../../Definitions/Laravel/Definition.md)
* [Laravel Index](Index.md)
* [Planning Index](../../index.md)
* [M0 Target Repository Architecture](../../00-overview/m0-target-repository-architecture.md)
