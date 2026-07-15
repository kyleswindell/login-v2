<!--
DOC-META
title: Definition Document Standard
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/doc-types/definition/Standard.md
parent: docs/02-standards/documentation/doc-types/definition/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines qualification, metadata, structure, placement, acceptance, review, validation, and maintenance requirements for definition documents.
-->

# Definition Document Standard

Parent: [Definition Document Type Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Qualification](#3-qualification)
- [4. Required Metadata](#4-required-metadata)
- [5. Required Structure](#5-required-structure)
  - [Definition](#definition)
  - [Classification Rule](#classification-rule)
  - [Owns](#owns)
  - [Must Not Own](#must-not-own)
  - [Dependency Rules](#dependency-rules)
  - [Target Status](#target-status)
  - [Accepted Decision](#accepted-decision)
  - [Open Questions](#open-questions)
  - [Related](#related)
- [6. Content Rules](#6-content-rules)
- [7. Placement And Naming](#7-placement-and-naming)
- [8. Linking And Dependencies](#8-linking-and-dependencies)
- [9. Status And Acceptance](#9-status-and-acceptance)
- [10. Review And Validation](#10-review-and-validation)
- [11. Maintenance](#11-maintenance)
- [12. Related](#12-related)

## 1. Purpose

Define the enforceable requirements for repository documents using:

```yaml
doc_type: definition
````

## 2. Scope

This standard applies to:

* reusable architecture concept definitions;
* document-type definitions;
* framework or repository concept definitions;
* other formal definitions assigned to a canonical owner by documentation governance.

This standard does not apply to:

* glossary entries;
* ordinary introductory sections;
* feature specifications;
* architecture plans;
* implementation standards;
* decision records;
* migration plans;
* temporary terminology notes.

## 3. Qualification

A document qualifies as a definition when it must establish one stable reusable concept and answer:

* What is the concept?
* How is it classified?
* What does it include?
* What does it exclude?
* Which dependencies or relationships apply?
* What is its target status?
* Is the controlling definition proposed or accepted?

A concept should not receive a standalone definition when:

* it appears in only one local document;
* a concise glossary entry is sufficient;
* its meaning is already owned by another canonical source;
* it is merely a physical folder or class name;
* it exists only for one temporary issue;
* the proposed document would primarily contain planning or implementation detail.

## 4. Required Metadata

A definition document must use:

```yaml
doc_type: definition
template: docs/09-reference/templates/docs/_definition.md
```

It must also provide accurate values for:

* `title`;
* `status`;
* `owner`;
* `canonical`;
* `canonical_path`;
* `parent`;
* `summary`.

A canonical accepted definition normally uses:

```yaml
status: active
canonical: true
```

A proposed definition must use an accurate draft lifecycle and must not claim accepted authority.

Metadata path, visible parent link, filename casing, and repository location must agree.

## 5. Required Structure

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

The exact prose may vary, but each section must preserve its assigned responsibility.

### Definition

State the stable meaning of the concept and distinguish it from adjacent concepts.

### Classification Rule

State the conditions used to determine whether something belongs within the definition.

### Owns

List authoritative inclusions, responsibilities, or characteristics.

### Must Not Own

List explicit exclusions and adjacent-owner boundaries.

### Dependency Rules

State permitted and prohibited dependency or relationship directions.

### Target Status

State whether the concept is permanent, transitional, compatibility-only, deprecated, or proposed.

### Accepted Decision

State the concise controlling definition and whether it is proposed or accepted.

### Open Questions

Include only unresolved questions that could materially change the definition.

Use `None.` when no such question remains.

### Related

Link to parent routing, governing decisions, standards, planning, architecture, and consuming documents.

## 6. Content Rules

A definition must:

* define one concept;
* remain concise enough to be reused broadly;
* separate meaning from current physical implementation;
* distinguish accepted rules from open questions;
* identify explicit exclusions;
* identify later owners for placement, naming, migration, or implementation questions;
* link to detailed supporting material rather than absorbing it.

A definition must not:

* become a complete implementation plan;
* duplicate an ADR’s full rationale;
* become a file inventory;
* own active delivery status;
* contain broad chronological history;
* use current placement as sole classification evidence;
* preserve multiple alternative definitions as equal active truth;
* attribute repository-owner acceptance without explicit authority.

## 7. Placement And Naming

Reusable architecture definitions normally live at:

```text
docs/07-planning/Definitions/<Concept>/Definition.md
```

Document-type definitions live at:

```text
docs/02-standards/documentation/doc-types/<doc_type>/Definition.md
```

An alternate location is permitted only when:

* another accepted documentation standard assigns the concept elsewhere;
* the alternate owner is explicit;
* no competing active definition remains;
* indexes and inbound links are updated.

Definition filenames use:

```text
Definition.md
```

Concept-folder naming must follow the applicable repository naming standard.

## 8. Linking And Dependencies

A definition must:

* link upward to its parent index;
* link to directly related definitions;
* link to governing ADRs when applicable;
* link to planning or migration owners for deferred work;
* link to its package README or consuming package when useful;
* use portable relative Markdown links for repository paths.

Consuming documents must link to the canonical definition rather than reproducing complete definition sections.

A definition may summarize an accepted decision but must not replace an ADR when durable rationale and decision history require one.

## 9. Status And Acceptance

Metadata lifecycle and the `Accepted Decision` section must remain consistent.

Use:

```text
Status: proposed
```

when repository-owner acceptance has not occurred.

Use:

```text
Status: accepted
```

only after explicit repository-owner acceptance.

Acceptance of a definition does not prove:

* implementation matches the definition;
* migration is complete;
* validation of dependent code has passed;
* every existing artifact has been classified.

Those claims require separate evidence.

## 10. Review And Validation

Review must confirm:

* the concept requires a formal definition;
* one canonical definition exists;
* classification is unambiguous;
* inclusions and exclusions do not overlap adjacent owners;
* dependency rules are explicit;
* physical placement does not silently determine meaning;
* proposed and accepted states are accurate;
* open questions are bounded;
* links and metadata are correct;
* no competing definition remains active.

Required repository checks:

```text
npm run lint:docs:guardrails
git diff --check
```

Also verify manually:

* required headings exist;
* parent and related links resolve;
* `canonical_path` matches the file;
* filename casing is correct;
* template and standard remain synchronized.

Do not claim validation passed unless the exact commands succeeded.

## 11. Maintenance

Update a definition when:

* concept meaning changes;
* classification changes;
* included or excluded responsibilities change;
* dependency rules change;
* target status changes;
* an open question is resolved;
* a governing decision supersedes the definition.

When reusable definition structure changes:

* update this standard;
* update the definition template;
* review existing canonical definitions;
* update documentation validation where applicable.

Do not rewrite an accepted definition merely to reflect physical migration that does not change the concept boundary.

## 12. Related

* [Definition Document Type README](README.md)
* [Definition Document Type Index](index.md)
* [Definition Document Definition](Definition.md)
* [Parent Document Type Standard](../Standard.md)
* [How To Write Docs](../../How%20To%20Write%20Docs.md)
* [Doc Governance](../../Doc%20Governance.md)
* [Documentation Review Standards](../../Documentation%20Review%20Standards.md)
* [Definition Template](../../../../09-reference/templates/docs/_definition.md)
* [Repository Definitions](../../../../07-planning/Definitions/Index.md)