<!--
DOC-META
title: Document Types Index
doc_type: index
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/doc-types/index.md
parent: docs/02-standards/documentation/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the controlled document-type system and dedicated packages for registered repository documentation types.
-->

# Document Types Index

Parent: [Documentation Standards Index](../index.md)

Use this index to navigate the controlled document-type system and its registered type packages.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
  - [2.1. Belongs Here](#21-belongs-here)
  - [2.2. Does Not Belong Here](#22-does-not-belong-here)
- [3. Documents](#3-documents)
- [4. Registered Type Packages](#4-registered-type-packages)
- [5. Transitional Types](#5-transitional-types)
- [6. Maintenance Notes](#6-maintenance-notes)
- [7. Related](#7-related)

## 1. Purpose

Route readers to:

- the definition of a document type;
- the standard governing the document-type registry;
- dedicated type packages;
- type-specific definitions and standards;
- transitional authority for types not yet migrated.

## 2. Scope

### 2.1. Belongs Here

This folder contains:

- common document-type rules;
- the controlled type registry;
- mature document-type packages;
- type-specific definitions;
- type-specific standards;
- type-specific agent guidance;
- package migration and compatibility rules.

### 2.2. Does Not Belong Here

This folder does not contain:

- copyable templates;
- general writing rules;
- branch-level documentation governance;
- project-specific documentation;
- implementation architecture or behavior;
- active issue or Project status;
- empty packages without a stable maintenance purpose.

## 3. Documents

| Document                                  | Purpose                                                                              | Status |
| ----------------------------------------- | ------------------------------------------------------------------------------------ | ------ |
| [README](README.md)                       | Explains the document-type package, registration model, and maintenance rules.       | active |
| [Document Type Definition](Definition.md) | Defines what a document type is and how it is classified.                            | active |
| [Document Type Standard](Standard.md)     | Governs document-type registration, packages, precedence, migration, and validation. | active |
| [Agents](AGENTS.md)                       | Provides agent guidance for the document-types package tree.                         | active |

## 4. Registered Type Packages

| Type         | Package                                | Purpose                                             | Status |
| ------------ | -------------------------------------- | --------------------------------------------------- | ------ |
| `definition` | [Definition Type](definition/index.md) | Defines and governs canonical definition documents. | active |

## 5. Transitional Types

Document types without a dedicated child package remain governed by:

- [Document Type Standards](../Document%20Type%20Standards.md)

That file is transitional for unmigrated types only.

When a type receives an accepted child package:

- the child `Definition.md` becomes authoritative for type meaning;
- the child `Standard.md` becomes authoritative for type-specific requirements;
- the legacy type section must be replaced, reduced to a compatibility pointer, or removed;
- this index must be updated.

## 6. Maintenance Notes

- Keep the registered-type table synchronized with accepted child packages.
- Do not list a type as migrated until its package is complete.
- Do not duplicate child definitions or standards in this index.
- Keep transitional authority explicit.
- Update templates, validation, and inbound links when a type package changes.
- Remove obsolete compatibility references after migration is complete.

## 7. Related

- [Document Types README](README.md)
- [Document Type Definition](Definition.md)
- [Document Type Standard](Standard.md)
- [Documentation Standards Index](../index.md)
- [Document Type Standards — Transitional Source](../Document%20Type%20Standards.md)
- [Documentation Templates](../../../09-reference/templates/docs/_index.md)