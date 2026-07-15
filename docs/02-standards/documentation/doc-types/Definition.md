<!--
DOC-META
title: Document Type Definition
doc_type: definition
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/doc-types/Definition.md
parent: docs/02-standards/documentation/doc-types/index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines a document type as the controlled classification of a repository document by its durable responsibility.
-->

# Document Type Definition

Parent: [Document Types Index](index.md)

- [1. Definition](#1-definition)
- [2. Classification Rule](#2-classification-rule)
- [3. Owns](#3-owns)
- [4. Must Not Own](#4-must-not-own)
- [5. Dependency Rules](#5-dependency-rules)
- [6. Target Status](#6-target-status)
- [7. Accepted Decision](#7-accepted-decision)
- [8. Open Questions](#8-open-questions)
- [9. Related](#9-related)
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

## 1. Definition

A document type is the controlled classification of a repository document according to its durable responsibility.

A document type identifies what kind of repository truth, guidance, planning, evidence, navigation, or procedure the document primarily owns.

The type is independent of:

- the document’s subject;
- its audience;
- its writing style;
- its length;
- its current filename;
- its presentation mode;
- the tool used to author or render it.

## 2. Classification Rule

A document receives the type whose responsibility best describes the document’s primary durable purpose.

Determine the type by asking:

1. What repository responsibility does this document own?
2. Which branch normally owns that responsibility?
3. Is the document canonical for that responsibility?
4. Which lifecycle and review rules apply?
5. Which reusable template, if any, matches its required shape?

A document must have one primary type.

A document may contain supporting material associated with other types, but it must not acquire multiple competing primary responsibilities.

Do not create or select a type merely because:

- the document addresses a new topic;
- it uses a different tone or layout;
- it contains a table, checklist, diagram, or example;
- one issue needs a temporary deliverable;
- a familiar filename exists.

## 3. Owns

The document-type system owns:

- the controlled type vocabulary;
- the meaning of each registered type;
- the classification rule for each type;
- each type’s normal documentation branch or assigned location;
- each type’s canonical default;
- type-specific lifecycle and review expectations;
- the relationship between a type and its copyable template;
- the required package structure for mature document types;
- migration and compatibility rules for legacy type authority.

A child document-type definition owns the stable meaning and boundary of one registered type.

## 4. Must Not Own

The document-type system must not own:

- the subject matter documented by an artifact;
- product or implementation behavior;
- architecture merely because an architecture document exists;
- schema merely because a database document exists;
- active issue or Project status;
- writing style or presentation mode;
- the complete reusable content of a template;
- branch ownership unrelated to documentation responsibilities;
- temporary labels that do not represent a durable document responsibility.

A document type must not become a substitute for the canonical owner of the content documented by an artifact.

## 5. Dependency Rules

The document-type system:

- depends on documentation governance for branch and canonical ownership;
- depends on metadata standards for controlled fields and lifecycle values;
- depends on child definitions for type-specific meaning;
- depends on child standards for type-specific requirements;
- may reference templates as reusable shapes;
- may be consumed by documentation indexes, review standards, agents, and validation tooling;
- must remain independent of one project, feature, or issue;
- must not derive type solely from physical placement or filename.

A copyable template may implement the shape required by a type, but the template does not define the type’s meaning or enforceable standard.

## 6. Target Status

Status: permanent

The controlled document-type system is a permanent part of Login 2.0 documentation governance.

Mature types use dedicated child packages beneath:

```text
docs/02-standards/documentation/doc-types/
````

Types not yet migrated may remain temporarily governed by the legacy document-type standard until their child packages are accepted.

## 7. Accepted Decision

Status: accepted

Repository documents are classified by one controlled primary document type representing their durable responsibility.

Each mature document type has:

* one authoritative type definition;
* one authoritative type-specific standard;
* one package README;
* one package index;
* scoped agent guidance;
* a separately maintained copyable template when reusable shape is required.

Document type, subject, physical placement, and presentation mode remain separate concepts.

## 8. Open Questions

The following migration questions remain:

* which existing controlled types require dedicated child packages;
* the order in which legacy type sections will be migrated;
* whether any current controlled types should be merged, renamed, or retired;
* which types require dedicated templates rather than shared templates.

These questions do not change the definition of a document type.

## 9. Related

* [Document Types README](README.md)
* [Document Types Index](index.md)
* [Document Type Standard](Standard.md)
* [Doc Governance](../Doc%20Governance.md)
* [Document Type Standards — Transitional Source](../Document%20Type%20Standards.md)
* [Documentation Templates](../../../09-reference/templates/docs/_index.md)
* [Definition Document Type](definition/Definition.md)
* Related GitHub issue: #48

````

### FILE: `docs/02-standards/documentation/doc-types/Standard.md`

```md
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