<!--
DOC-META
title: Definition Name
doc_type: definition
status: draft
owner: architecture
canonical: true
canonical_path: docs/path/to/Definition.md
parent: docs/path/to/Index.md
template: docs/09-reference/templates/docs/_definition.md
summary: One sentence describing the responsibility or architecture boundary defined by this document.
-->

# Definition Name

Parent: [Section Name Index](Index.md)

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

Define the responsibility, architecture area, capability, Module, UI area, Surface, Delivery Adapter, framework boundary, or repository concept.

State what distinguishes it from adjacent ownership areas.

## 2. Classification Rule

State the conditions used to determine whether a responsibility belongs within this definition.

Include any conditions that may appear contradictory but do not change the classification.

## 3. Owns

This definition owns:

* ...
* ...

List authoritative behavior, state, contracts, infrastructure, presentation, persistence, lifecycle, review, or documentation responsibilities as applicable.

## 4. Must Not Own

This definition must not own:

* ...
* ...

List responsibilities that belong to adjacent architecture areas or would create an ambiguous or generic ownership boundary.

## 5. Dependency Rules

This definition:

* may depend on ...
* may expose ...
* must remain independent of ...
* must not depend on ...

State both permitted and prohibited dependency directions.

Do not use physical proximity or shared use as dependency justification.

## 6. Target Status

Status: permanent | transitional | compatibility-only | deprecated | proposed

Describe:

* whether this definition is part of the permanent target architecture;
* whether its current physical implementation matches the target;
* which later architecture phase or implementation goal owns unresolved placement or migration.

## 7. Accepted Decision

Status: proposed | accepted

Summarize the controlling decision in one or two paragraphs.

Do not mark the decision accepted without explicit repository-owner authority.

## 8. Open Questions

* ...

Record only unresolved questions that could materially change this definition.

Assign placement, naming, migration, implementation, or verification questions to their later owning phase or goal when they do not change the boundary itself.

Use `None` when no open question remains.

## 9. Related

* [Section Name README](README.md)
* [Section Name Index](Index.md)
* [Related Decision](../path/to/decision.md)
* [Related Architecture](../path/to/architecture.md)
* Related GitHub issue: #...
