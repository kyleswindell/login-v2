<!--
DOC-META
title: Section Name README
doc_type: readme
status: draft
owner: docs
canonical: true
canonical_path: docs/path/to/README.md
parent: docs/path/to/Index.md
template: docs/09-reference/templates/docs/_readme.md
summary: One sentence describing the documentation package and how it should be used.
-->

# Section Name

Parent: [Section Name Index](Index.md)

Use this README to understand the purpose, structure, and maintenance rules for this documentation package.

- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. Folder Contract](#3-folder-contract)
- [4. Required Files](#4-required-files)
- [5. Content Rules](#5-content-rules)
- [6. Maintenance](#6-maintenance)
- [7. Related](#7-related)

## 1. Purpose

Explain what this documentation package defines, why it exists, and which repository responsibilities it supports.

## 2. Read Order

Read this package in the following order:

1. `README.md` for package purpose and usage.
2. `Definition.md` for the authoritative definition and ownership boundary.
3. `Index.md` to locate additional documents.
4. Supporting documents only when their specific subject is required.

## 3. Folder Contract

This folder owns documentation for one clearly defined architecture area, capability, Module, UI area, Surface, Delivery Adapter, framework boundary, or repository responsibility.

Documents in this folder must:

* use the terminology accepted by repository architecture decisions;
* keep ownership separate from physical placement;
* identify authoritative responsibilities and prohibited responsibilities;
* distinguish permanent target rules from transitional implementation state;
* link to detailed supporting documents rather than duplicating them;
* avoid acting as an issue tracker, implementation log, or status board.

No subfolder is required unless the documented area grows beyond a practical flat document set and a later architecture decision authorizes subdivision.

## 4. Required Files

Every standardized documentation package must contain:

| File            | Purpose                                                                               |
| --------------- | ------------------------------------------------------------------------------------- |
| `README.md`     | Explains how the package is organized and maintained.                                 |
| `Definition.md` | Defines the documented area, its ownership boundary, dependencies, and target status. |
| `Index.md`      | Routes readers to all documents in the package.                                       |

Additional documents may be added only when they own a distinct subject that does not belong in `Definition.md`.

## 5. Content Rules

* Keep `Definition.md` authoritative for the package boundary.
* Keep `Index.md` focused on routing and document status.
* Keep this README focused on package usage and maintenance.
* Do not duplicate full sections across package files.
* Do not preserve superseded terminology without an explicit compatibility note.
* Do not treat current folder placement as proof of target ownership.
* Promote cross-cutting durable decisions to the appropriate decision record.
* Link implementation plans and migration plans without making them the definition owner.

## 6. Maintenance

Update this package when:

* its ownership boundary changes;
* a supporting document is added, moved, superseded, or removed;
* a transitional rule becomes permanent or is retired;
* a related architecture decision changes;
* the repository structure changes the package’s canonical location.

Keep metadata, parent links, related links, and document status current.

## 7. Related

* [Section Name Index](Index.md)
* [Section Name Definition](Definition.md)
* [Parent Planning Index](../index.md)
