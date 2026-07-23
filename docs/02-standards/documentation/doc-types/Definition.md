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
```

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