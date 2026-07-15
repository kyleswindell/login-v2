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
  - [FILE: `docs/02-standards/documentation/doc-types/AGENTS.md`](#file-docs02-standardsdocumentationdoc-typesagentsmd)
- [Git And Scope Rules](#git-and-scope-rules)
- [Stop Conditions](#stop-conditions)
- [Related](#related)

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
````

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

````

### FILE: `docs/02-standards/documentation/doc-types/index.md`

```md
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
````

### FILE: `docs/02-standards/documentation/doc-types/AGENTS.md`

````md
# AGENTS.md

## Folder Purpose

This folder owns the controlled document-type system for Login 2.0 documentation.

Use this file to guide Codex and other AI agents working within the `doc-types/` tree. This file is agent-facing routing guidance, not the canonical definition or standard for a document type.

Canonical truth remains in:

- `Definition.md`
- `Standard.md`
- the applicable child type package
- accepted documentation governance standards

## Ownership

This folder may contain:

- `README.md`
- `Definition.md`
- `Standard.md`
- `index.md`
- child document-type packages
- type-specific definitions and standards
- type-specific `AGENTS.md` files
- compatibility guidance for migrating legacy document-type rules

This folder must not contain:

- copyable document templates
- project planning
- product or feature documentation
- implementation architecture
- database contracts
- operational runbooks
- unrelated documentation standards
- active issue or Project status
- empty type packages created only for symmetry

If a requested change crosses this folder’s ownership boundary, stop and identify the correct documentation owner before editing.

## Required Reading Before Editing

Read:

1. `../../../../AGENTS.md`
2. `../../../AGENTS.md`
3. `../../AGENTS.md`
4. `../AGENTS.md`
5. `README.md`
6. `Definition.md`
7. `Standard.md`
8. `index.md`
9. the applicable child package files

Required standards:

- [How To Write Docs](../How%20To%20Write%20Docs.md)
- [Doc Governance](../Doc%20Governance.md)
- [Documentation Review Standards](../Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](../Implementation%20Status%20And%20Development%20Sync%20Standard.md)

Required references:

- [Documentation Templates](../../../09-reference/templates/docs/_index.md)
- [Document Type Standards — Transitional Source](../Document%20Type%20Standards.md)

Prefer targeted reads over loading unrelated document-type packages.

## Canonical Owners To Check

| Change Type                     | Canonical Owner                        |
| ------------------------------- | -------------------------------------- |
| Meaning of a document type      | applicable child `Definition.md`       |
| Type-specific requirements      | applicable child `Standard.md`         |
| Common type-system requirements | `Standard.md`                          |
| Registered type routing         | `index.md`                             |
| General writing requirements    | `../How To Write Docs.md`              |
| Branch and canonical ownership  | `../Doc Governance.md`                 |
| Copyable shape                  | `docs/09-reference/templates/docs/`    |
| Documentation review            | `../Documentation Review Standards.md` |
| Agent guidance                  | nearest applicable `AGENTS.md`         |

Do not leave durable type-system truth only in an `AGENTS.md` file.

## Document-Type Registration Rules

Do not register a new type unless:

- it represents a distinct durable documentation responsibility;
- it cannot be represented accurately by an existing controlled type;
- its classification rule is explicit;
- its normal branch or placement is defined;
- its canonical default is defined;
- its review requirements are defined;
- its template relationship is defined;
- its child package has a clear maintenance owner.

Do not create a document type merely because:

- a new topic exists;
- a different writing style is desired;
- a filename is common;
- one issue needs a temporary artifact;
- a folder would look more symmetrical.

## Child Package Rules

A mature child package contains:

- `Definition.md`
- `Standard.md`
- `README.md`
- `index.md`
- `AGENTS.md`

The copyable template remains under:

- `docs/09-reference/templates/docs/`

When a child package is added or changed:

- update the parent `index.md`;
- update applicable templates;
- update validation tooling when controlled values change;
- update documentation governance where branch or canonical ownership changes;
- retire competing legacy authority;
- update inbound links.

## File And Documentation Rules

- Preserve exact controlled `doc_type` values.
- Use singular lowercase child-folder names matching the controlled type.
- Use `Definition.md` for type meaning.
- Use `Standard.md` for enforceable requirements.
- Use `README.md` for package use and maintenance.
- Use `index.md` for routing.
- Keep type-specific rules out of the parent standard unless they apply to all types.
- Keep copyable content in templates, not standards.
- Do not duplicate complete legacy type sections after migration.
- Preserve transitional authority explicitly until migration is complete.
- Do not mark a package accepted without repository-owner authority.

## Testing And Verification

For documentation changes in this folder, run:

```text
npm run lint:docs:guardrails
git diff --check
````

Also verify manually that:

* every metadata path exists;
* parent and related links resolve;
* controlled type values are registered;
* child package status matches the parent index;
* definitions, standards, and templates do not duplicate one another;
* migrated legacy authority has been retired or bounded;
* filename and folder casing are correct.

Do not claim verification passed unless the commands ran successfully.

## Git And Scope Rules

Before editing:

* confirm the active issue branch and worktree;
* inspect for unrelated changes;
* stage only files within the accepted scope;
* do not overwrite concurrent documentation work;
* do not use `git add .` in a dirty worktree.

When reporting work, include:

* files changed;
* document types registered or migrated;
* standards or templates updated;
* validation run;
* remaining compatibility authority;
* unresolved governance questions.

## Stop Conditions

Stop and report when:

* the proposed type overlaps an existing type;
* the type’s durable responsibility is unclear;
* the correct normal branch is unresolved;
* canonical status cannot be determined;
* the package would duplicate another authority;
* a controlled metadata value would change without tooling review;
* a template and standard would conflict;
* a legacy type section would remain as competing authority;
* unrelated working-tree changes may be overwritten.

## Related

* [Document Types README](README.md)
* [Document Types Index](index.md)
* [Document Type Definition](Definition.md)
* [Document Type Standard](Standard.md)
* [How To Write Docs](../How%20To%20Write%20Docs.md)
* [Doc Governance](../Doc%20Governance.md)
* [Documentation Review Standards](../Documentation%20Review%20Standards.md)
* [Documentation Templates](../../../09-reference/templates/docs/_index.md)