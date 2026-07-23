<!--
DOC-META
title: Document Type Standard
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/doc-types/Standard.md
parent: docs/02-standards/documentation/doc-types/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines registration, package, precedence, metadata, migration, review, and validation requirements for controlled repository document types.
-->

# Document Type Standard

Parent: [Document Types Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Core Rules](#3-core-rules)
- [4. Type Registration](#4-type-registration)
- [5. Child Package Contract](#5-child-package-contract)
- [6. Definition, Standard, And Template Separation](#6-definition-standard-and-template-separation)
  - [`Definition.md`](#definitionmd)
  - [`Standard.md`](#standardmd)
  - [Template](#template)
- [7. Naming And Metadata](#7-naming-and-metadata)
- [8. Authority And Precedence](#8-authority-and-precedence)
- [9. Migration And Compatibility](#9-migration-and-compatibility)
- [10. Review And Validation](#10-review-and-validation)
- [11. Maintenance](#11-maintenance)
- [12. Related](#12-related)

## 1. Purpose

Define the enforceable rules for registering, structuring, documenting, migrating, reviewing, and validating controlled repository document types.

## 2. Scope

This standard applies to:

- the controlled `doc_type` vocabulary;
- the parent `doc-types/` package;
- dedicated child type packages;
- type definitions;
- type-specific standards;
- type-package README and index files;
- type-specific agent guidance;
- relationships between types and templates;
- migration from legacy document-type rules.

This standard does not define:

- general writing quality;
- branch ownership unrelated to document classification;
- product or implementation behavior;
- active issue or Project status;
- the complete copyable content of templates.

## 3. Core Rules

Every repository documentation file must:

- use one controlled primary `doc_type`;
- use the type matching its durable responsibility;
- follow the applicable parent and child type standards;
- live in the branch or location assigned by documentation governance;
- use the applicable template when one exists;
- preserve one primary canonical owner.

A type must not be introduced solely because:

- a new topic exists;
- a document uses a different layout;
- one issue needs a temporary artifact;
- a familiar filename is desired;
- a package tree would appear more complete.

## 4. Type Registration

A new controlled type requires:

- a unique singular lowercase identifier;
- a stable definition;
- an explicit classification rule;
- an identified normal branch or assigned location;
- a canonical default;
- lifecycle expectations;
- review requirements;
- an identified template or explicit statement that no dedicated template is required;
- a maintenance owner;
- validation-tooling review;
- repository-owner acceptance.

The type identifier must use:

```text
lowercase-kebab-case
````

The child folder must use the exact type identifier:

```text
docs/02-standards/documentation/doc-types/<doc_type>/
```

Registration is incomplete until:

* the child package exists;
* the parent index lists the type;
* controlled metadata validation accepts the value;
* applicable governance and templates are updated;
* competing legacy authority is retired or explicitly bounded.

## 5. Child Package Contract

A mature child package must contain:

```text
<doc_type>/
├── Definition.md
├── Standard.md
├── README.md
├── AGENTS.md
└── index.md
```

Responsibilities:

| File            | Responsibility                                                                            |
| --------------- | ----------------------------------------------------------------------------------------- |
| `Definition.md` | Stable type meaning, classification, ownership, exclusions, dependencies, and status.     |
| `Standard.md`   | Enforceable metadata, content, placement, lifecycle, review, and validation requirements. |
| `README.md`     | Package purpose, read order, folder contract, and maintenance.                            |
| `index.md`      | Routing, child-document status, and related owners.                                       |
| `AGENTS.md`     | Type-specific agent rules and stop conditions.                                            |

A child package may contain supporting documents only when they own a distinct type-specific responsibility.

Do not create generic `notes.md`, `misc.md`, or duplicate standards files.

## 6. Definition, Standard, And Template Separation

The following separation is mandatory:

### `Definition.md`

Answers:

* What is this document type?
* How is it classified?
* What does it own?
* What must it not own?
* How does it relate to adjacent types?

### `Standard.md`

Answers:

* What metadata is required?
* Where may the type live?
* Which sections or content are required?
* What is prohibited?
* How is the document reviewed and maintained?
* Which validation must pass?

### Template

Provides:

* copyable metadata shape;
* reusable headings;
* prompts or placeholders;
* structure required by the applicable standard.

Templates live beneath:

```text
docs/09-reference/templates/docs/
```

A template is non-canonical and must not become the only source of a type requirement.

## 7. Naming And Metadata

Parent package files use:

```text
README.md
Definition.md
Standard.md
AGENTS.md
index.md
```

Child package folders use the exact singular controlled type identifier.

Child package files use the same fixed filenames.

Every documentation file except runtime `AGENTS.md` must include valid `DOC-META`.

Type definitions use:

```yaml
doc_type: definition
template: docs/09-reference/templates/docs/_definition.md
```

Type standards use:

```yaml
doc_type: standard
template: docs/09-reference/templates/docs/_doc.md
```

README and index files use their corresponding controlled types and templates.

Metadata paths, visible parent links, canonical paths, and filename casing must agree.

## 8. Authority And Precedence

For a migrated document type, authority applies in this order:

1. accepted repository decisions;
2. documentation governance;
3. parent `doc-types/Standard.md`;
4. child `<doc_type>/Definition.md`;
5. child `<doc_type>/Standard.md`;
6. applicable template;
7. package README, index, and AGENTS guidance;
8. legacy compatibility documentation.

The child definition controls meaning.

The child standard controls type-specific requirements.

The parent standard controls rules shared by all document types.

Templates implement reusable shape but do not override standards.

## 9. Migration And Compatibility

Until all controlled types are migrated:

* `docs/02-standards/documentation/Document Type Standards.md` remains the compatibility authority for types without a dedicated child package;
* accepted child packages supersede corresponding legacy sections;
* the legacy file must not override a migrated child package;
* conflicting duplicated rules must be removed or converted into explicit pointers;
* inbound links must be updated during migration.

A migration is complete only when:

* the child package is accepted;
* the parent index is updated;
* validation accepts the type;
* templates are synchronized;
* legacy authority is retired;
* no active conflicting definition remains.

## 10. Review And Validation

Review must confirm:

* the type represents one durable responsibility;
* it does not overlap an existing type;
* its identifier and folder match;
* its normal location is explicit;
* canonical status is explicit;
* definition and standard responsibilities remain separate;
* templates do not silently define policy;
* legacy authority is bounded;
* indexes and links are current;
* controlled metadata tooling recognizes the type.

Required repository checks:

```text
npm run lint:docs:guardrails
git diff --check
```

Additional controlled-value or link validation must be run when available.

Do not claim validation passed unless the exact commands succeeded.

## 11. Maintenance

When changing a document type:

* update its definition when meaning or classification changes;
* update its standard when enforceable requirements change;
* update its template when reusable shape changes;
* update the parent index when status changes;
* update validation when controlled values change;
* update governance when branch or canonical ownership changes;
* update inbound links when paths change;
* retire obsolete compatibility authority.

Do not broaden a type through incidental edits to its README, index, template, or AGENTS file.

## 12. Related

* [Document Types README](README.md)
* [Document Types Index](index.md)
* [Document Type Definition](Definition.md)
* [Definition Document Type](definition/index.md)
* [Documentation Standards Index](../index.md)
* [How To Write Docs](../How%20To%20Write%20Docs.md)
* [Doc Governance](../Doc%20Governance.md)
* [Documentation Review Standards](../Documentation%20Review%20Standards.md)
* [Document Type Standards — Transitional Source](../Document%20Type%20Standards.md)
* [Documentation Templates](../../../09-reference/templates/docs/_index.md)