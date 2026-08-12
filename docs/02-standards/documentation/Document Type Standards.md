<!--
DOC-META
title: Document Type Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/Document Type Standards.md
parent: docs/02-standards/documentation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines the controlled documentation type registry and the baseline ownership, content, lifecycle, template, and review contract for each document type.
-->

# Document Type Standards

Parent: [Documentation Standards Index](index.md)
- [1. Purpose](#1-purpose)
- [2. Core Rules](#2-core-rules)
- [3. Controlled Types](#3-controlled-types)
- [4. Type And Mode Distinction](#4-type-and-mode-distinction)
- [5. Registry Summary](#5-registry-summary)
- [6. `standard`](#6-standard)
  - [6.1. Purpose](#61-purpose)
  - [6.2. Required Content](#62-required-content)
  - [6.3. Prohibited Content](#63-prohibited-content)
  - [6.4. Review](#64-review)
- [7. `architecture`](#7-architecture)
  - [7.1. Purpose](#71-purpose)
  - [7.2. Required Content](#72-required-content)
  - [7.3. Prohibited Content](#73-prohibited-content)
  - [7.4. Review](#74-review)
- [8. `feature`](#8-feature)
  - [8.1. Purpose](#81-purpose)
  - [8.2. Required Content](#82-required-content)
  - [8.3. Prohibited Content](#83-prohibited-content)
  - [8.4. Review](#84-review)
- [9. `flow`](#9-flow)
  - [9.1. Purpose](#91-purpose)
  - [9.2. Required Content](#92-required-content)
  - [9.3. Prohibited Content](#93-prohibited-content)
  - [9.4. Review](#94-review)
- [10. `database`](#10-database)
  - [10.1. Purpose](#101-purpose)
  - [10.2. Required Content](#102-required-content)
  - [10.3. Prohibited Content](#103-prohibited-content)
  - [10.4. Review](#104-review)
- [11. `planning`](#11-planning)
  - [11.1. Purpose](#111-purpose)
  - [11.2. Required Content](#112-required-content)
  - [11.3. Prohibited Content](#113-prohibited-content)
  - [11.4. Lifecycle](#114-lifecycle)
  - [11.5. Review](#115-review)
- [`design`](#design)
  - [Purpose](#purpose)
  - [Required Content](#required-content)
  - [Prohibited Content](#prohibited-content)
  - [Review](#review)
- [12. `matrix`](#12-matrix)
  - [12.1. Purpose](#121-purpose)
  - [12.2. Required Content](#122-required-content)
  - [12.3. Prohibited Content](#123-prohibited-content)
  - [12.4. Canonical Status](#124-canonical-status)
  - [12.5. Review](#125-review)
- [13. `index`](#13-index)
  - [13.1. Purpose](#131-purpose)
  - [13.2. Required Content](#132-required-content)
  - [13.3. Prohibited Content](#133-prohibited-content)
  - [13.4. Review](#134-review)
- [14. `reference`](#14-reference)
  - [14.1. Purpose](#141-purpose)
  - [14.2. Required Content](#142-required-content)
  - [14.3. Prohibited Content](#143-prohibited-content)
  - [14.4. Canonical Status](#144-canonical-status)
  - [14.5. Review](#145-review)
- [15. `runbook`](#15-runbook)
  - [15.1. Purpose](#151-purpose)
  - [15.2. Required Content](#152-required-content)
  - [15.3. Prohibited Content](#153-prohibited-content)
  - [15.4. Review](#154-review)
- [16. `decision`](#16-decision)
  - [16.1. Purpose](#161-purpose)
  - [16.2. Required Content](#162-required-content)
  - [16.3. Prohibited Content](#163-prohibited-content)
  - [16.4. Review](#164-review)
- [17. `release-note`](#17-release-note)
  - [17.1. Purpose](#171-purpose)
  - [17.2. Required Content](#172-required-content)
  - [17.3. Prohibited Content](#173-prohibited-content)
  - [17.4. Canonical Status](#174-canonical-status)
  - [17.5. Review](#175-review)
- [18. `agent-guidance`](#18-agent-guidance)
  - [18.1. Purpose](#181-purpose)
  - [18.2. Normal Uses](#182-normal-uses)
  - [18.3. Prohibited Content](#183-prohibited-content)
  - [18.4. Canonical Status](#184-canonical-status)
  - [18.5. Review](#185-review)
- [`definition`](#definition)
  - [Purpose](#purpose)
  - [Normal Uses](#normal-uses)
  - [Prohibited Content](#prohibited-content)
  - [Canonical Status](#canonical-status)
  - [Review](#review)
- [19. Dedicated Type Standards](#19-dedicated-type-standards)
- [20. Type Review Checklist](#20-type-review-checklist)
- [21. Related](#21-related)

## 1. Purpose

Define the controlled `doc_type` registry and the minimum contract for each repository documentation type.

This standard answers:

- what each type is
- where it normally belongs
- whether it is canonical by default
- what it must contain
- what it must not contain
- which template normally applies
- what type-specific review must confirm

## 2. Core Rules

Every documentation file must:

- use one controlled `doc_type`
- have one primary responsibility
- live in the branch that owns that responsibility
- use the applicable template
- satisfy universal requirements in [How To Write Docs](How%20To%20Write%20Docs.md)
- satisfy branch rules in [Doc Governance](Doc%20Governance.md)

Do not create a new `doc_type` merely because a document has a new topic.

Do not use `doc_type` to describe writing style.

## 3. Controlled Types

Use one of:

- `standard`
- `architecture`
- `feature`
- `flow`
- `database`
- `planning`
- `design`
- `matrix`
- `index`
- `reference`
- `runbook`
- `decision`
- `release-note`
- `agent-guidance`

## 4. Type And Mode Distinction

A type identifies the artifact's durable role.

A mode identifies presentation.

Examples:

- an `architecture` document may combine explanation and reference
- a `feature` document may combine behavior reference and examples
- a `planning` document may include explanatory rationale and task-oriented implementation slices
- a `runbook` uses how-to presentation but has additional operational safety requirements
- a `reference` document may be exact without being canonical

## 5. Registry Summary

| `doc_type`       | Normal Branch                                    | Canonical Default                              | Normal Template                             |
| ---------------- | ------------------------------------------------ | ---------------------------------------------- | ------------------------------------------- |
| `standard`       | `docs/02-standards/`                             | Yes                                            | `_doc.md`                                   |
| `architecture`   | `docs/03-architecture/`                          | Yes                                            | `_architecture-note.md`                     |
| `feature`        | `docs/04-features/`                              | Yes                                            | `_feature-spec.md`                          |
| `flow`           | `docs/05-flows/`                                 | Yes                                            | `_doc.md`                                   |
| `database`       | `docs/06-database/`                              | Yes                                            | `_doc.md`                                   |
| `planning`       | `docs/07-planning/`                              | Yes for planning intent, not implemented truth | `_planning.md`                              |
| `design`         | `docs/08-design/`                                | Yes for accepted implementation design          | `_design.md`                                |
| `matrix`         | Owning branch                                    | Depends on matrix responsibility               | `_matrix.md`                                |
| `index`          | Any documentation branch                         | Yes for navigation                             | `_index.md`                                 |
| `reference`      | `docs/09-reference/`                             | No                                             | `_doc.md`                                   |
| `runbook`        | `docs/10-runbooks/`                              | Yes                                            | `_runbook.md`                               |
| `decision`       | `docs/01-decisions/`                             | Yes                                            | `_doc.md` until a dedicated template exists |
| `release-note`   | Release-document location selected by governance | No for durable system truth                    | `_release-note.md`                          |
| `agent-guidance` | Usually `docs/11-ai/`                            | No by default                                  | `_doc.md`                                   |

A document may live outside its normal branch only when the canonical owner clearly requires it.

## 6. `standard`

### 6.1. Purpose

Defines enforceable rules, constraints, conventions, requirements, and completion expectations.

### 6.2. Required Content

A standard must identify:

- purpose and scope
- applicable rules
- ownership boundaries
- required behavior
- prohibited behavior
- verification or review expectations
- maintenance implications
- related canonical owners

### 6.3. Prohibited Content

A standard must not primarily contain:

- implementation sequencing
- unresolved design proposals
- historical status
- task-specific acceptance criteria
- executable operational steps for one incident or maintenance task
- complete copyable templates

### 6.4. Review

Confirm that requirements are enforceable, durable, and not better owned by architecture, feature, database, planning, runbook, or agent skill documents.

## 7. `architecture`

### 7.1. Purpose

Defines long-lived system structure, boundaries, ownership, dependencies, and technical relationships.

### 7.2. Required Content

An architecture document should identify:

- scope
- components or boundaries
- ownership
- dependency direction
- data or control movement at an architectural level
- constraints
- accepted current state
- related decisions

### 7.3. Prohibited Content

It must not primarily contain:

- detailed feature acceptance criteria
- table-by-table schema contracts
- delivery sequencing
- operator procedures
- unresolved alternatives presented as current truth

### 7.4. Review

Confirm the document describes accepted structure rather than planned or historical structure.

## 8. `feature`

### 8.1. Purpose

Defines canonical user, admin, platform, system, or business capability behavior.

### 8.2. Required Content

A feature document should identify:

- actors
- purpose
- supported behavior
- inputs and outputs
- states
- successful behavior
- denied and failure behavior
- authorization and scope
- audit, notification, or monitoring implications
- known current limitations
- related architecture, flow, database, and planning documents

### 8.3. Prohibited Content

It must not become:

- an architecture owner
- a schema definition
- an implementation backlog
- an operator runbook
- a UI mockup-only document without behavior

### 8.4. Review

Confirm behavior is observable, current, and consistent with implementation.

## 9. `flow`

### 9.1. Purpose

Defines an execution path or workflow sequence across actors, services, states, or system boundaries.

### 9.2. Required Content

A flow document should identify:

- trigger
- participants
- preconditions
- ordered path
- branching conditions
- state changes
- failure paths
- outputs and side effects
- related feature and architecture owners

### 9.3. Prohibited Content

It must not primarily define:

- branch-level operating procedures for humans
- implementation sequencing
- complete feature behavior
- database schema

### 9.4. Review

Confirm the document describes system execution, not an operator runbook.

## 10. `database`

### 10.1. Purpose

Defines schema, table, column, key, constraint, index, relationship, retention, and data-contract truth.

### 10.2. Required Content

A database document should identify applicable:

- ownership
- table or object purpose
- keys and constraints
- columns and data types
- relationships
- indexes
- tenant or workspace scope
- lifecycle and retention
- migration or compatibility notes
- security classification
- related feature and architecture owners

### 10.3. Prohibited Content

It must not primarily contain:

- speculative schema without planned status
- feature behavior
- broad architecture
- executable database-maintenance procedures
- migration work sequencing

### 10.4. Review

Confirm schema truth matches migrations and database standards.

## 11. `planning`

### 11.1. Purpose

Defines implementation intent, sequencing, decomposition, migration plans, open questions, and issue traceability.

### 11.2. Required Content

A planning document should identify:

- current state
- target state
- scope and non-goals
- dependencies
- decisions and open questions
- implementation slices
- acceptance or exit criteria
- affected canonical owners
- tests and verification
- documentation promotion targets
- related GitHub issues

### 11.3. Prohibited Content

It must not remain the final owner of:

- implemented architecture
- feature behavior
- schema
- standards
- operational runbooks

### 11.4. Lifecycle

Planning may remain active while implementation is incomplete. When its purpose ends, mark it implemented, superseded, or archived and link to promoted owners.

### 11.5. Review

Confirm plans are distinguished from current truth and that promotion targets are explicit.

## `design`

### Purpose

Defines the accepted concrete implementation realization of canonical requirements before production implementation.

### Required Content

A design document must identify applicable:

- system identity, scope, and owner;
- governing canonical requirements;
- components and exact intended placement;
- public Contract realization and interactions;
- persistence implementation;
- delivery and presentation mapping;
- security and reliability design;
- Events and operational effects;
- implementation manifest;
- verification and design-readiness state.

### Prohibited Content

A design document must not:

- redefine architecture, feature behavior, schema, standards, or planning;
- use current implementation as target authority;
- own active delivery status;
- replace issue-specific acceptance criteria or verification contracts;
- present unresolved material alternatives as accepted design.

### Review

Confirm that the design is traceable to accepted requirements and complete enough for bounded implementation work without requiring new material system-design decisions.

## 12. `matrix`

### 12.1. Purpose

Defines structured cross-reference, traceability, ownership, dependency, sequence, coverage, or review data.

### 12.2. Required Content

A matrix must identify:

- purpose
- row and column meaning
- authoritative source inputs
- controlled values
- owner
- update trigger
- interpretation limits

### 12.3. Prohibited Content

A matrix must not silently become the only owner of:

- architecture
- behavior
- schema
- standards
- runbook procedures

### 12.4. Canonical Status

A matrix may be canonical for the structured relationship it owns while linking to canonical documents for the underlying concepts.

### 12.5. Review

Confirm cells are traceable, terminology is controlled, and the matrix does not replace detailed owner documents.

## 13. `index`

### 13.1. Purpose

Provides concise navigation and scope for a folder, branch, or document family.

### 13.2. Required Content

An index must:

- state folder purpose and scope
- list active children
- link upward to its parent
- route readers to the correct owner
- identify deprecated or historical areas when needed

### 13.3. Prohibited Content

An index must not become:

- a full planning document
- a standards summary duplicating child files
- a backlog
- a historical log

### 13.4. Review

Confirm navigation is complete, current, concise, and free of stale paths.

## 14. `reference`

### 14.1. Purpose

Provides non-canonical supporting information, research, examples, templates, vendor notes, source reviews, or technical lookup material.

### 14.2. Required Content

A reference document should identify:

- purpose
- source or provenance when relevant
- whether content is current or historical
- related canonical owners
- promotion target when durable rules are extracted

### 14.3. Prohibited Content

It must not silently own durable Login 2.0 truth.

### 14.4. Canonical Status

Use `canonical: false` by default.

### 14.5. Review

Confirm the document does not compete with architecture, feature, database, standards, planning, or runbook owners.

## 15. `runbook`

### 15.1. Purpose

Defines a repeatable operator-executable procedure for a known operational task or condition.

### 15.2. Required Content

A runbook must satisfy:

- [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)

At minimum it needs:

- use conditions
- prerequisites
- target environment
- ordered steps
- verification
- failure or rollback handling
- escalation
- completion criteria

### 15.3. Prohibited Content

It must not primarily be:

- policy
- architecture
- planning
- historical status
- a vague checklist
- an agent workflow

### 15.4. Review

Apply the dedicated runbook standard and template.

## 16. `decision`

### 16.1. Purpose

Records a durable elevated decision, its context, rationale, status, consequences, and replacement history.

### 16.2. Required Content

A decision record should identify:

- status
- context
- decision
- considered alternatives when useful
- consequences
- affected canonical owners
- supersession or replacement links

### 16.3. Prohibited Content

Do not create decision records for every local implementation choice.

Do not use a decision record as the only current-state system documentation.

### 16.4. Review

Confirm the decision is cross-cutting or durable enough to warrant elevation and that affected canonical owners describe current truth.

## 17. `release-note`

### 17.1. Purpose

Summarizes a release's notable changes, rollout implications, migration steps, cautions, and validation context.

### 17.2. Required Content

A release note should identify:

- release or version
- notable changes
- rollout or migration requirements
- compatibility impact
- operational cautions
- verification
- related issues, decisions, runbooks, and canonical docs

### 17.3. Prohibited Content

It must not replace canonical architecture, behavior, schema, standards, or runbooks.

### 17.4. Canonical Status

Release notes are canonical for release context, not for current system truth.

### 17.5. Review

Confirm all durable changes were also applied to their canonical owners.

## 18. `agent-guidance`

### 18.1. Purpose

Provides non-canonical agent-facing support material that is not a persistent repository rule and not an executable skill.

### 18.2. Normal Uses

Appropriate uses include:

- agent-authored review guidance
- temporary promotion candidates
- bounded agent-facing checklists under review
- support notes for an agent documentation task

### 18.3. Prohibited Content

Do not use `agent-guidance` for:

- persistent repository rules, which belong in `AGENTS.md`
- executable procedures, which belong in `.agents/skills/`
- coding-agent standards, which belong in `docs/02-standards/coding-agents/`
- canonical product, architecture, schema, or operational truth
- current delivery state

### 18.4. Canonical Status

Use `canonical: false` by default.

### 18.5. Review

Confirm the document has a review, promotion, or closure path and does not compete with instruction or canonical owners.

## `definition`

### Purpose

Define the responsibility, architecture area, capability, Module, UI area, Surface, Delivery Adapter, framework boundary, or repository concept.

### Normal Uses

(TODO)

### Prohibited Content

(TODO)

### Canonical Status

(TODO)

### Review

(TODO)

## 19. Dedicated Type Standards

Create a dedicated type-specific standard only when the type has substantial unique:

- governance
- lifecycle
- safety
- validation
- review
- promotion
- maintenance

Current dedicated standard:

- [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)

Potential future standards may include planning and decision records after focused review.

Do not create one standard file for every controlled type by default.

## 20. Type Review Checklist

For every new or materially rewritten document, verify:

- the `doc_type` is controlled
- the document's primary responsibility matches the selected type
- the branch matches the type and concept owner
- the `canonical` value is accurate
- the selected template is appropriate
- required type-specific content exists
- prohibited content was removed or linked to its owner
- lifecycle status is accurate
- parent and related links are current
- no competing owner was introduced

## 21. Related

- [Documentation Standards Index](index.md)
- [How To Write Docs](How%20To%20Write%20Docs.md)
- [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)
- [Doc Governance](Doc%20Governance.md)
- [Documentation Review Standards](Documentation%20Review%20Standards.md)
- [Documentation Templates](../../09-reference/templates/docs/_index.md)
