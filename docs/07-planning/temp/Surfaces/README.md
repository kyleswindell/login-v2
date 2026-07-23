<!--
DOC-META
title: Surfaces
doc_type: readme
status: draft
owner: architecture
canonical: false
canonical_path: docs/07-planning/temp/Surfaces/README.md
parent: docs/07-planning/temp/Surfaces/Index.md
template: docs/09-reference/templates/docs/_readme.md
summary: Explains the temporary planning package used to develop Surface architecture, placement, naming, and migration rules during Goal 03.
-->

# Surfaces

Parent: [Surfaces Index](Index.md)

Use this README to understand the temporary Surfaces planning package.

- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. Folder Contract](#3-folder-contract)
- [4. Required Files](#4-required-files)
- [5. Content Rules](#5-content-rules)
- [6. Maintenance](#6-maintenance)
- [7. Related](#7-related)

## 1. Purpose

This folder temporarily owns Goal 03 planning for Surface architecture that has not yet reached a permanent repository or documentation location.

The canonical Surface definition is stored separately because it applies across multiple architecture and documentation areas.

This package may develop:

* Surface classifications;
* Surface composition rules;
* Surface-specific placement;
* delivery and presentation adapter boundaries;
* Surface naming conventions;
* representative Surface examples;
* migration direction for current Surface-related code and documentation.

## 2. Read Order

Read this package in the following order:

1. `README.md` for package purpose and temporary status.
2. [Surface Definition](../../Definitions/Surfaces/Definition.md) for the authoritative definition.
3. `Index.md` to locate temporary planning documents.
4. Supporting documents only when their specific subject is required.

## 3. Folder Contract

This folder contains temporary planning material for Surfaces while Goal 03 determines their permanent documentation and repository organization.

Documents belong here when they:

* depend on the accepted Surface definition;
* address Surface-specific placement, naming, composition, or migration;
* do not yet have an accepted permanent owner;
* are required to complete a later Goal 03 phase.

This folder does not own:

* the canonical Surface definition;
* Core, Module, or UI definitions;
* durable architecture after its permanent owner is accepted;
* implementation code;
* active GitHub issue or Project status;
* unrelated temporary notes.

The folder must be reconciled, promoted, or removed before Goal 03 final acceptance.

## 4. Required Files

This temporary package contains:

| File        | Purpose                                                   |
| ----------- | --------------------------------------------------------- |
| `README.md` | Explains the temporary package and its maintenance rules. |
| `Index.md`  | Routes readers to temporary Surface planning documents.   |
| `AGENTS.md` | Guides agents working within the temporary package.       |

The authoritative definition is maintained separately at:

* `docs/07-planning/Definitions/Surfaces/Definition.md`

## 5. Content Rules

* Do not duplicate the canonical Surface definition.
* Link to the definition when classification or ownership rules are needed.
* Keep temporary planning clearly marked as proposed, unresolved, or transitional.
* Do not present proposed physical placement as accepted architecture.
* Do not use `Surface` as a fourth source-of-truth owner.
* Keep Core, Module, and UI ownership explicit.
* Do not use this folder as a general notes or staging area.
* Promote accepted durable content to its final owner rather than leaving it under `temp/`.

## 6. Maintenance

Update this package when:

* a Surface planning document is added, moved, superseded, or removed;
* a proposed rule becomes accepted;
* a permanent documentation owner is established;
* Goal 03 accepts Surface placement or naming;
* temporary material is promoted or retired.

Before Goal 03 closes:

* promote durable Surface architecture;
* update all affected indexes and links;
* remove superseded temporary documents;
* remove this package if it no longer owns active planning.

## 7. Related

* [Surface Definition](../../Definitions/Surfaces/Definition.md)
* [Surfaces Index](Index.md)
* [Planning Index](../../index.md)
* [M0 Target Repository Architecture](../../00-overview/m0-target-repository-architecture.md)
