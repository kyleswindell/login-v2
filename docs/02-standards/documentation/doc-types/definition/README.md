<!--
DOC-META
title: Definition Document Type
doc_type: readme
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/doc-types/definition/README.md
parent: docs/02-standards/documentation/doc-types/definition/index.md
template: docs/09-reference/templates/docs/_readme.md
summary: Explains the definition document-type package, read order, folder contract, and maintenance requirements.
-->

# Definition Document Type

Parent: [Definition Document Type Index](index.md)

Use this README to understand the purpose, structure, and maintenance rules for the `definition` document type.

- [1. Purpose](#1-purpose)
- [2. Read Order](#2-read-order)
- [3. Folder Contract](#3-folder-contract)
- [4. Required Files](#4-required-files)
- [5. Content Rules](#5-content-rules)
- [6. Maintenance](#6-maintenance)
- [7. Related](#7-related)

## 1. Purpose

This folder defines and governs repository documents using:

```yaml
doc_type: definition
```

A definition document establishes the stable meaning and boundary of one reusable repository concept.

This package separates:

* the meaning of a definition document;
* enforceable definition-document requirements;
* package navigation and maintenance;
* type-specific agent guidance;
* the copyable definition template.

## 2. Read Order

Read this package in the following order:

1. `README.md` for package purpose and use.
2. [Definition Document Definition](Definition.md) for the type’s meaning and classification.
3. [Definition Document Standard](Standard.md) for metadata, structure, placement, review, and maintenance requirements.
4. `index.md` for package routing.
5. [Definition Template](../../../../09-reference/templates/docs/_definition.md) when creating a definition document.

## 3. Folder Contract

This folder contains documentation governing the `definition` document type.

It owns:

* the meaning of a definition document;
* qualification and classification rules;
* required definition-document structure;
* metadata and placement requirements;
* acceptance and review requirements;
* maintenance and validation rules.

It does not contain:

* repository concept definitions themselves;
* architecture planning;
* feature definitions;
* glossary entries;
* copyable templates;
* active issue or Project status.

Reusable repository concept definitions remain with their assigned canonical definition roots.

## 4. Required Files

This package contains:

| File            | Purpose                                                    |
| --------------- | ---------------------------------------------------------- |
| `README.md`     | Explains package purpose, read order, and maintenance.     |
| `Definition.md` | Defines the `definition` document type.                    |
| `Standard.md`   | Defines enforceable requirements for definition documents. |
| `index.md`      | Routes readers to package documents and related owners.    |
| `AGENTS.md`     | Provides type-specific agent guidance.                     |

The copyable template is maintained separately at:

```text
docs/09-reference/templates/docs/_definition.md
```

## 5. Content Rules

* Keep `Definition.md` focused on type meaning.
* Keep `Standard.md` focused on enforceable requirements.
* Keep the template focused on reusable shape.
* Do not place repository-specific concept definitions in this package.
* Do not use a definition document as a broad architecture plan.
* Do not use a definition document as a glossary merely because it defines a term.
* Do not duplicate accepted decision history already owned by an ADR.
* Do not mark a proposed concept accepted without repository-owner authority.

## 6. Maintenance

Update this package when:

* the definition type’s classification changes;
* required definition sections change;
* canonical definition locations change;
* definition metadata rules change;
* review or validation requirements change;
* the definition template changes;
* a competing definition-document authority is found.

Changes to reusable shape must update both the standard and template.

## 7. Related

* [Definition Document Type Index](index.md)
* [Definition Document Definition](Definition.md)
* [Definition Document Standard](Standard.md)
* [Document Types README](../README.md)
* [Document Type Standard](../Standard.md)
* [Definition Template](../../../../09-reference/templates/docs/_definition.md)
* [Repository Definitions](../../../../07-planning/Definitions/Index.md)