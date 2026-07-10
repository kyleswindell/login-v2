<!--
DOC-META
title: Planning Documentation Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/Planning Documentation Standards.md
parent: docs/02-standards/documentation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines planning-document ownership, structure, lifecycle, issue traceability, implementation-slice, decision, promotion, synchronization, and close-out requirements.
-->

# Planning Documentation Standards

Parent: [Documentation Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Definition](#3-definition)
- [4. Core Rules](#4-core-rules)
- [5. Planning Document Categories](#5-planning-document-categories)
  - [5.1. Roadmap And Sequence Planning](#51-roadmap-and-sequence-planning)
  - [5.2. Capability Or Subsystem Planning](#52-capability-or-subsystem-planning)
  - [5.3. Migration Or Refactor Planning](#53-migration-or-refactor-planning)
  - [5.4. Implementation-Slice Planning](#54-implementation-slice-planning)
  - [5.5. Planning Matrix](#55-planning-matrix)
- [6. Required Metadata](#6-required-metadata)
- [7. Planning Lifecycle](#7-planning-lifecycle)
- [8. Required Planning Content](#8-required-planning-content)
  - [8.1. Purpose](#81-purpose)
  - [8.2. Status](#82-status)
  - [8.3. Scope](#83-scope)
  - [8.4. Non-Goals](#84-non-goals)
  - [8.5. Current State](#85-current-state)
  - [8.6. Target State](#86-target-state)
  - [8.7. Requirements And Constraints](#87-requirements-and-constraints)
  - [8.8. Ownership And Promotion Targets](#88-ownership-and-promotion-targets)
  - [8.9. Dependencies](#89-dependencies)
  - [8.10. Decisions And Open Questions](#810-decisions-and-open-questions)
  - [8.11. Implementation Slices](#811-implementation-slices)
  - [8.12. Tests And Verification](#812-tests-and-verification)
  - [8.13. Documentation Synchronization](#813-documentation-synchronization)
  - [8.14. Completion And Exit Criteria](#814-completion-and-exit-criteria)
- [9. Current State And Target State Discipline](#9-current-state-and-target-state-discipline)
- [10. Planning And GitHub Issues](#10-planning-and-github-issues)
- [11. Planning And GitHub Projects](#11-planning-and-github-projects)
- [12. Readiness For Implementation](#12-readiness-for-implementation)
- [13. Variance During Implementation](#13-variance-during-implementation)
- [14. Planning-To-Canonical Promotion](#14-planning-to-canonical-promotion)
- [15. Security, Privacy, And Operational Planning](#15-security-privacy-and-operational-planning)
- [16. Supersession And Archival](#16-supersession-and-archival)
- [17. Planning Review](#17-planning-review)
- [18. Completion Criteria](#18-completion-criteria)
- [19. Related](#19-related)

## 1. Purpose

Define how planning documents capture implementation intent, sequencing, decomposition, dependencies, open questions, and promotion targets without becoming competing owners of implemented architecture, behavior, schema, standards, runbooks, or delivery status.

This standard applies the baseline `planning` contract from:

- [Document Type Standards](Document%20Type%20Standards.md)

## 2. Scope

This standard applies to:

- roadmap and sequence-control documents
- capability and subsystem planning
- architecture-boundary planning
- migration and refactor planning
- implementation decomposition
- implementation-slice planning
- planning matrices when planning intent is their primary subject
- planning documents that prepare GitHub issues
- planning documents that coordinate promotion into canonical owners

This standard does not govern:

- active delivery status, which belongs in GitHub Projects
- bounded implementation acceptance criteria, which belong in GitHub issues
- durable decisions, which may require decision records
- implemented system truth, which belongs in canonical owner documents
- operator procedures, which belong in runbooks
- agent execution workflows, which belong in `.agents/skills/`

## 3. Definition

A planning document defines intended future work or controlled change.

It may answer:

- what exists now
- what should exist
- why the change is needed
- what is in scope
- what is excluded
- what must happen first
- how work should be divided
- which decisions remain open
- which canonical documents must change
- how completion will be verified

A planning document is canonical for its accepted planning intent.

It is not automatically canonical for the implemented result.

## 4. Core Rules

Planning documents must:

- distinguish current state from target state
- separate accepted direction from unresolved questions
- identify scope and non-goals
- identify dependencies and sequencing constraints
- identify affected canonical owners
- identify implementation slices or issue boundaries when applicable
- identify verification and review expectations
- identify documentation promotion and synchronization targets
- remain aligned with material implementation changes

Planning documents must not:

- replace GitHub issues as bounded work packets
- replace GitHub Projects as active delivery-state owners
- remain the final owner of implemented architecture, behavior, schema, standards, or runbooks
- present unresolved options as accepted direction
- record sensitive credentials or production-only data
- become chronological implementation logs
- preserve deprecated batch or active-workspace systems as current workflow

## 5. Planning Document Categories

Use the smallest planning category that fits the work.

### 5.1. Roadmap And Sequence Planning

Use for:

- broad delivery order
- capability dependency order
- milestone grouping
- release or maturity sequencing
- deferred lanes

Keep roadmap documents high-level.

Do not place detailed implementation acceptance criteria in roadmap documents.

### 5.2. Capability Or Subsystem Planning

Use for:

- one Core Capability
- one Platform Surface
- one Business Module
- one Shared UI system
- one cross-cutting technical subsystem

This category may define target ownership, boundaries, dependencies, implementation slices, and promotion targets.

### 5.3. Migration Or Refactor Planning

Use for:

- replacing an existing implementation
- moving ownership
- changing data shape
- retiring compatibility behavior
- staged adoption

It must identify:

- source state
- target state
- compatibility requirements
- migration sequence
- rollback or recovery implications
- removal criteria

### 5.4. Implementation-Slice Planning

Use when a larger plan must be decomposed into GitHub issues.

It should identify:

- slice outcome
- owner
- dependencies
- accepted boundaries
- verification
- canonical documents affected
- specialist review

The GitHub issue becomes the executable work packet.

### 5.5. Planning Matrix

Use `doc_type: matrix` when the primary artifact is structured cross-reference data.

A planning matrix may be canonical for:

- order
- ownership mapping
- dependency mapping
- coverage
- documentation requirements
- issue decomposition

It must link to detailed planning and canonical owners instead of replacing them.

## 6. Required Metadata

Planning documents must normally use:

- `doc_type: planning`
- an accurate owner
- `canonical: true` for accepted planning intent
- `template: docs/09-reference/templates/docs/_planning.md`

Use `canonical: false` when the file is only:

- a proposed draft awaiting review
- supporting research
- an agent-authored promotion candidate
- a temporary comparison artifact

Draft planning may use `status: draft`.

Accepted but unimplemented planning normally uses `status: planned` or `active`, depending on whether it is an accepted target or an actively maintained planning owner.

## 7. Planning Lifecycle

Use documentation lifecycle values from:

- [How To Write Docs](How%20To%20Write%20Docs.md)

Apply them as follows:

| Metadata Status | Planning Meaning                                                           |
| --------------- | -------------------------------------------------------------------------- |
| `draft`         | Proposed planning content that is incomplete or not accepted               |
| `planned`       | Accepted future direction that is not implemented                          |
| `active`        | Current planning owner for ongoing or multi-slice work                     |
| `implemented`   | The planned outcome is reflected in implementation and canonical docs      |
| `superseded`    | Replaced by another plan, issue set, decision, or implementation direction |
| `archived`      | Historical context only                                                    |

Metadata status describes the document lifecycle.

GitHub Project status describes delivery state.

Do not copy Project status into planning metadata.

## 8. Required Planning Content

A materially complete planning document should identify the following information, using headings appropriate to its scope.

### 8.1. Purpose

State the planning outcome and why the document exists.

### 8.2. Status

State:

- planning lifecycle
- current implementation state
- whether the plan is accepted
- whether implementation issues exist
- material known gaps

### 8.3. Scope

State:

- included capabilities
- affected users, operators, or systems
- target ownership
- affected environments
- relevant compatibility scope

### 8.4. Non-Goals

State what the plan intentionally does not own.

Non-goals prevent agents and contributors from broadening implementation slices.

### 8.5. Current State

Describe only the current facts needed to understand the change.

Link to canonical owners for full current truth.

Do not duplicate large architecture, feature, or database documents.

### 8.6. Target State

Describe the intended outcome clearly enough to guide issue decomposition.

Distinguish:

- accepted target
- optional future enhancement
- unresolved alternative

### 8.7. Requirements And Constraints

Identify applicable:

- architectural constraints
- security requirements
- privacy and data-governance requirements
- database constraints
- compatibility requirements
- operational requirements
- accessibility requirements
- performance requirements
- vendor or platform constraints

Link to canonical standards.

### 8.8. Ownership And Promotion Targets

Identify the canonical owners that must be created or updated.

Use current ownership:

- decisions → `docs/01-decisions/`
- standards → `docs/02-standards/`
- architecture → `docs/03-architecture/`
- features → `docs/04-features/`
- flows → `docs/05-flows/`
- database → `docs/06-database/`
- planning → `docs/07-planning/`
- references and templates → `docs/09-reference/`
- runbooks → `docs/10-runbooks/`
- agent working documents → `docs/11-ai/`
- persistent agent rules → `AGENTS.md`
- agent workflows → `.agents/skills/`

### 8.9. Dependencies

Identify:

- prerequisite issues
- required decisions
- required canonical documentation
- external systems
- migrations
- operational readiness
- review dependencies

Distinguish blocking dependencies from informative relationships.

### 8.10. Decisions And Open Questions

For each decision or question, identify:

- owner
- required-by point
- affected implementation slices
- accepted resolution when available
- whether a decision record is required

Do not leave resolved cross-cutting decisions only in planning.

Use:

- [Decision Record Standards](Decision%20Record%20Standards.md)

### 8.11. Implementation Slices

Each slice should be bounded enough to become one issue or a tightly coordinated issue set.

A slice should identify:

- outcome
- owner layer and specific owner
- scope
- non-goals
- dependencies
- canonical documents
- security and data impact
- transaction or reliability impact
- tests and verification
- manual or specialist review
- completion evidence

Do not use the planning document as the active task checklist after the issue exists.

### 8.12. Tests And Verification

Identify planned:

- automated tests
- migration verification
- browser review
- accessibility review
- security review
- performance checks
- operational exercises
- documentation guardrails

Verification must be specific enough to inform issue acceptance criteria.

### 8.13. Documentation Synchronization

Identify:

- canonical documents to create
- canonical documents to update
- templates to update
- indexes to update
- working documents to promote
- documents to supersede, archive, or delete

### 8.14. Completion And Exit Criteria

State when:

- planning is complete
- implementation may begin
- each slice is complete
- the plan may become `implemented`
- the plan should be superseded or archived

## 9. Current State And Target State Discipline

Planning documents must not blur current and future behavior.

Use explicit sections:

- `## Current State`
- `## Target State`

When useful, add:

- `## Transition State`
- `## Compatibility State`
- `## Known Gaps`

Do not write future behavior in the present tense unless it is clearly labeled as target state.

## 10. Planning And GitHub Issues

GitHub issues own:

- bounded requested outcome
- acceptance criteria
- current task discussion
- dependencies
- implementation evidence
- review requirements

Planning documents own:

- broader decomposition
- sequencing rationale
- target-state context
- cross-issue dependencies
- promotion targets
- plan variance

When an issue is created:

- link it from the relevant planning document when useful
- link relevant planning and canonical docs from the issue
- avoid duplicating the complete issue body in planning

When issue scope changes materially:

- update the issue
- update the plan when the larger planning truth changes
- promote durable decisions

## 11. Planning And GitHub Projects

GitHub Projects own:

- workflow status
- priority
- phase or milestone fields
- risk fields
- dependency tracking when configured
- delivery sequencing

Planning documents may explain sequencing rationale.

They must not recreate a parallel active-delivery board.

Do not use planning documents as:

- inboxes
- active queues
- issue status ledgers
- current assignee trackers
- commit logs

## 12. Readiness For Implementation

A planning slice is ready to become an implementation issue only when applicable:

- outcome is clear
- owner is clear
- scope and non-goals are clear
- dependencies are resolved or explicitly blocking
- required decisions are accepted
- canonical owners are identified
- security and data boundaries are identified
- transaction and reliability boundaries are identified
- verification is defined
- review requirements are defined
- stop conditions are identifiable

Use:

- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)

Do not label unresolved design work as Codex-delegable implementation.

## 13. Variance During Implementation

Update planning when implementation materially changes:

- target architecture
- ownership
- dependency order
- scope
- compatibility
- schema direction
- security requirements
- operational requirements
- issue decomposition
- canonical promotion targets

Do not update planning for every minor implementation detail.

Record meaningful variance, not a chronological worklog.

## 14. Planning-To-Canonical Promotion

When planning becomes durable truth:

1. update the correct canonical owner
2. remove working-only language
3. update related indexes
4. update the planning status
5. link to the promoted owner
6. preserve useful rationale and variance
7. remove duplicated durable content from planning

Planning may retain concise implementation context after promotion.

It must not remain the only description of implemented behavior.

## 15. Security, Privacy, And Operational Planning

Planning must identify specialist review when work affects:

- authentication
- authorization
- tenant or workspace isolation
- secrets
- service accounts
- webhooks
- sensitive exports
- audit evidence
- monitoring
- retention or erasure
- destructive migrations
- backup and recovery
- incident response
- production deployment

Do not embed credentials, secrets, raw customer data, or restricted evidence.

## 16. Supersession And Archival

Supersede a planning document when:

- a newer plan replaces its direction
- an accepted decision invalidates it
- issue decomposition materially replaces its structure
- implementation takes a different accepted path

Archive a planning document when:

- it is historical only
- it remains useful for migration or delivery history
- no active work depends on it

Delete it when:

- it has no independent value
- it duplicates a current plan
- it preserves a deprecated workflow without useful history
- retention would create confusion

Do not keep superseded plans in active navigation without clear labeling.

## 17. Planning Review

Review planning for:

- correct owner and branch
- accurate current state
- clear target state
- explicit non-goals
- resolved versus open decisions
- dependency clarity
- bounded implementation slices
- issue and Project ownership boundaries
- security and data review
- verification
- promotion targets
- lifecycle accuracy
- absence of implementation-status duplication
- absence of obsolete workflow ownership

## 18. Completion Criteria

Planning documentation is complete when:

- its purpose is clear
- current and target states are distinct
- scope and non-goals are explicit
- ownership is identified
- dependencies are classified
- decisions and open questions are traceable
- implementation slices are bounded
- verification is defined
- canonical promotion targets are listed
- issue and Project boundaries are respected
- status is accurate
- indexes and related links are current

## 19. Related

- [Documentation Standards Index](index.md)
- [How To Write Docs](How%20To%20Write%20Docs.md)
- [Document Type Standards](Document%20Type%20Standards.md)
- [Decision Record Standards](Decision%20Record%20Standards.md)
- [Doc Governance](Doc%20Governance.md)
- [Documentation Review Standards](Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Planning Template](../../09-reference/templates/docs/_planning.md)
- [Planning Index](../../07-planning/index.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
