<!--
DOC-META
title: Definition Document Type Index
doc_type: index
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/doc-types/definition/index.md
parent: docs/02-standards/documentation/doc-types/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes the definition document-type definition, standard, package guidance, template, and canonical repository definitions.
-->

# Definition Document Type Index

Parent: [Document Types Index](../index.md)

Use this index to navigate the `definition` document-type package.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
  - [2.1. Belongs Here](#21-belongs-here)
  - [2.2. Does Not Belong Here](#22-does-not-belong-here)
- [3. Documents](#3-documents)
- [4. Subfolders](#4-subfolders)
- [5. Maintenance Notes](#5-maintenance-notes)
- [6. Related](#6-related)

## 1. Purpose

Route readers to the authoritative meaning and enforceable requirements for documents using:

```yaml
doc_type: definition
```

## 2. Scope

### 2.1. Belongs Here

This folder contains:

* the definition of the `definition` document type;
* type-specific standards;
* package guidance;
* package routing;
* type-specific agent instructions.

### 2.2. Does Not Belong Here

This folder does not contain:

* individual repository concept definitions;
* copyable templates;
* architecture plans;
* feature or database documentation;
* glossary collections;
* active issue or Project status.

## 3. Documents

| Document                                        | Purpose                                                                      | Status |
| ----------------------------------------------- | ---------------------------------------------------------------------------- | ------ |
| [README](README.md)                             | Explains package purpose, read order, and maintenance.                       | active |
| [Definition Document Definition](Definition.md) | Defines the meaning and classification of a definition document.             | active |
| [Definition Document Standard](Standard.md)     | Defines metadata, structure, placement, review, and validation requirements. | active |
| [Agents](AGENTS.md)                             | Provides type-specific agent guidance and stop conditions.                   | active |

## 4. Subfolders

No subfolders currently exist.

Supporting material should be added only when it owns a distinct definition-type responsibility that does not belong in `Definition.md` or `Standard.md`.

## 5. Maintenance Notes

* Keep this index synchronized with package files.
* Do not duplicate the type definition or standard here.
* Keep links to the template and repository definition roots current.
* Update status when the package lifecycle changes.
* Do not add individual concept definitions to this package.

## 6. Related

* [Document Types Index](../index.md)
* [Definition Template](../../../../09-reference/templates/docs/_definition.md)
* [Repository Definitions](../../../../07-planning/Definitions/Index.md)
* [Doc Governance](../../Doc%20Governance.md)
* [Documentation Review Standards](../../Documentation%20Review%20Standards.md)
* Related GitHub issue: #48