<!--
DOC-META
title: Document Types
doc_type: readme
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/doc-types/README.md
parent: docs/02-standards/documentation/doc-types/index.md
template: docs/09-reference/templates/docs/_readme.md
summary: Explains the controlled document-type system, package structure, registration model, and maintenance rules for repository documentation types.
-->

# Document Types

Parent: [Document Types Index](index.md)

Use this README to understand the purpose, structure, and maintenance rules for the repository document-type system.

- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. Folder Contract](#3-folder-contract)
- [4. Required Files](#4-required-files)
- [5. Child Package Contract](#5-child-package-contract)
- [6. Content Rules](#6-content-rules)
- [7. Maintenance](#7-maintenance)
- [8. Related](#8-related)

## 1. Purpose

This folder owns the controlled document-type system for Login 2.0 documentation.

It establishes:

- what a document type represents;
- how document types are defined and registered;
- the rules shared by all document types;
- the required structure of mature document-type packages;
- how type-specific definitions, standards, templates, and agent guidance relate;
- how legacy document-type rules are migrated into dedicated packages.

A document type classifies a document by its durable repository responsibility. It does not classify the document merely by topic, writing style, audience, or physical filename.

## 2. Read Order

Read this package in the following order:

1. `README.md` for package purpose and organization.
2. [Document Type Definition](Definition.md) for the meaning and classification of a document type.
3. [Document Type Standard](Standard.md) for registry, package, metadata, migration, and validation rules.
4. `index.md` to locate registered document-type packages.
5. The applicable child package for type-specific requirements.
6. The applicable copyable template under `docs/09-reference/templates/docs/`.

## 3. Folder Contract

This folder contains:

- the parent document-type definition;
- the standard governing the controlled type system;
- routing and package documentation;
- one child package for each document type that has been migrated into the package system.

Documents belong here when they define or govern:

- document-type meaning;
- controlled type registration;
- type-specific documentation requirements;
- type-specific metadata, placement, lifecycle, review, or validation;
- relationships among definitions, standards, and templates;
- migration from legacy document-type rules.

This folder does not own:

- general documentation-writing rules;
- branch-level documentation governance;
- implementation architecture;
- feature or flow documentation;
- project planning;
- active delivery status;
- copyable templates;
- agent workflows unrelated to documentation types.

Cross-cutting documentation rules remain in the documentation standards root.

## 4. Required Files

The parent document-types package contains:

| File            | Purpose                                                                         |
| --------------- | ------------------------------------------------------------------------------- |
| `README.md`     | Explains the package purpose, organization, and maintenance rules.              |
| `Definition.md` | Defines what a document type is and how it is classified.                       |
| `Standard.md`   | Governs registration, package structure, precedence, migration, and validation. |
| `index.md`      | Routes readers to registered document-type packages.                            |
| `AGENTS.md`     | Guides agents working within the package tree.                                  |

## 5. Child Package Contract

A mature document-type package contains:

| File            | Purpose                                                                                        |
| --------------- | ---------------------------------------------------------------------------------------------- |
| `Definition.md` | Defines the document type’s meaning, classification, ownership, exclusions, and relationships. |
| `Standard.md`   | Defines enforceable requirements for documents using the type.                                 |
| `README.md`     | Explains how the type package is organized and maintained.                                     |
| `index.md`      | Routes readers to the package documents and supporting material.                               |
| `AGENTS.md`     | Provides type-specific agent guidance.                                                         |

A copyable template remains under:

```text
docs/09-reference/templates/docs/
```

The template is not duplicated inside the document-type package.

A child package is created only when the document type has:

* a stable classification;
* meaningful type-specific requirements;
* an identified maintenance owner;
* enough durable content to justify dedicated routing.

Do not create empty packages solely for structural symmetry.

## 6. Content Rules

* Keep `Definition.md` focused on what a document type is.
* Keep `Standard.md` focused on enforceable system-wide requirements.
* Keep each child `Definition.md` focused on one document type.
* Keep each child `Standard.md` focused on requirements for that type.
* Keep templates copyable and non-canonical.
* Keep README files focused on package use and maintenance.
* Keep indexes focused on routing and status.
* Do not duplicate complete type standards in the parent registry.
* Do not create competing definitions for the same type.
* Do not classify a document by subject when its durable responsibility indicates another type.
* Do not preserve migrated legacy sections as competing authority.

## 7. Maintenance

Update this package when:

* a document type is registered, renamed, deprecated, superseded, or removed;
* a type receives a dedicated child package;
* a legacy type section is migrated;
* a type’s normal branch, canonical default, or template changes;
* a child definition or standard changes;
* validation tooling adopts or changes controlled type rules.

When migrating a type:

1. create and accept its child package;
2. update this package index;
3. update the applicable template;
4. update documentation governance and validation;
5. replace or retire competing legacy authority;
6. update inbound links.

## 8. Related

* [Document Types Index](index.md)
* [Document Type Definition](Definition.md)
* [Document Type Standard](Standard.md)
* [Documentation Standards Index](../index.md)
* [Doc Governance](../Doc%20Governance.md)
* [Document Type Standards — Transitional Source](../Document%20Type%20Standards.md)
* [Documentation Templates](../../../09-reference/templates/docs/_index.md)
* [Repository Definitions](../../../07-planning/Definitions/Index.md)