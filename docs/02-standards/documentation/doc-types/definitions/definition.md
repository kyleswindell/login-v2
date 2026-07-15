<!--
DOC-META
title: Definition Document Type
doc_type: definition
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/doc-types/definitions/definition.md
parent: docs/02-standards/documentation/doc-types/index.md
template: docs/09-reference/templates/docs/_definition.md
summary: Defines the purpose, required structure, ownership rules, and canonical-location requirements for definition documents.
-->

# Definition Document Type

Parent: [Document Types Index](../index.md)

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

A definition document establishes the stable meaning and boundary of one reusable repository concept.

It states:

* what the concept is;
* how to determine whether something belongs to it;
* what responsibilities it includes;
* what responsibilities it excludes;
* which dependencies are permitted or prohibited;
* whether the concept is permanent, transitional, compatibility-only, deprecated, or proposed.

A definition is independent of current physical placement. Folder names, namespaces, packages, routes, classes, and current implementation locations may support a definition but do not determine it.

## 2. Classification Rule

Use a definition document when a concept:

* is referenced from multiple repository or documentation areas;
* requires one stable and reusable meaning;
* has an ownership, classification, responsibility, or dependency boundary;
* must remain understandable independently of one implementation plan;
* is expected to be consumed by architecture, standards, planning, agent guidance, or implementation work.

Do not create a definition document merely because:

* a repository folder exists;
* a class or package has a name;
* a temporary planning label needs explanation;
* one issue uses a local term;
* a document needs a glossary entry.

Definitions that govern reusable architecture concepts live under:

```text
docs/07-planning/Definitions/<Concept>/Definition.md
```

A definition may live elsewhere only when another canonical documentation standard explicitly assigns that concept to a different definition root.

## 3. Owns

A definition document owns:

* the canonical meaning of its concept;
* the concept’s classification rule;
* authoritative included responsibilities;
* explicit excluded responsibilities;
* permitted and prohibited dependency directions;
* permanent or transitional target status;
* the concise accepted or proposed controlling statement;
* unresolved questions that could materially change the definition;
* links to governing decisions and consuming documents.

Every definition document must use the definition template:

```text
docs/09-reference/templates/docs/_definition.md
```

Every definition document must contain:

1. Definition
2. Classification Rule
3. Owns
4. Must Not Own
5. Dependency Rules
6. Target Status
7. Accepted Decision
8. Open Questions
9. Related

A definition may adapt the wording inside these sections to its concept, but it must preserve their responsibility.

## 4. Must Not Own

A definition document must not own:

* implementation sequencing;
* physical migration plans;
* file-by-file mappings;
* active issue or Project status;
* chronological work history;
* detailed repository-tree placement unless placement is intrinsic to the concept;
* feature behavior that belongs in feature documentation;
* execution flows that belong in flow documentation;
* schema or data contracts that belong in database documentation;
* implementation conventions that belong in standards;
* operational procedures;
* duplicated decision history already owned by an ADR.

A definition must not become a broad architecture plan or a substitute for an accepted decision record.

Planning, architecture, standards, README, index, and `AGENTS.md` files must link to the definition rather than reproduce it.

## 5. Dependency Rules

A definition document:

* may depend on accepted ADRs and canonical standards;
* may reference current implementation as evidence;
* may be consumed by multiple planning, architecture, standards, and agent-guidance documents;
* must remain understandable without loading every consuming document;
* must not derive meaning solely from current physical placement;
* must not conflict with a higher-authority accepted decision;
* must not mark a proposed definition accepted without explicit repository-owner authority.

When a definition and an implementation disagree:

* the definition describes the accepted target boundary;
* the implementation is classified as current, transitional, compatibility-only, or incorrect;
* migration remains owned by a separate accepted plan or issue.

## 6. Target Status

Status: permanent

`definition` is a permanent documentation type.

Canonical reusable architecture definitions are stored under:

```text
docs/07-planning/Definitions/
```

Each concept uses:

```text
docs/07-planning/Definitions/<Concept>/Definition.md
```

Concept folders remain focused on the definition itself unless additional accepted documentation is required.

Definition paths, metadata, titles, parent links, and filename casing must remain synchronized.

## 7. Accepted Decision

Status: accepted

Definition documents are the canonical source for reusable repository concepts that require stable classification, ownership, exclusion, dependency, and target-status rules.

Each defined concept has one authoritative `Definition.md`. Other documentation consumes that definition through links and must not create competing meanings.

Definition ownership is independent of physical implementation placement.

## 8. Open Questions

None.

New definition roots or alternative definition locations require an explicit documentation-governance decision.

## 9. Related

* [Document Types Index](../index.md)
* [Definition Template](../../../../09-reference/templates/docs/_definition.md)
* [Planning Documentation Standards](../../Planning%20Documentation%20Standards.md)
* [Decision Record Standards](../../Decision%20Record%20Standards.md)
* [Doc Governance](../../Doc%20Governance.md)
* [Definitions Root](../../../../07-planning/Definitions/)
* Related GitHub issue: #48
