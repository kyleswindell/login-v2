<!--
DOC-META
title: Implementation Status And Development Sync Standard
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/Implementation Status And Development Sync Standard.md
parent: docs/02-standards/documentation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines how GitHub issues, planning documents, implementation, canonical documentation, review evidence, and operational procedures remain synchronized.
-->

# Implementation Status And Development Sync Standard

Parent: [Documentation Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Core Rule](#3-core-rule)
- [4. Source Roles](#4-source-roles)
- [5. Planning Documents Are Working Owners Of Intent](#5-planning-documents-are-working-owners-of-intent)
- [6. Required Synchronization Layers](#6-required-synchronization-layers)
- [7. Required Status Content](#7-required-status-content)
- [8. Controlled Status Terms](#8-controlled-status-terms)
- [9. Linking Pattern](#9-linking-pattern)
- [10. Documentation Sync Triggers](#10-documentation-sync-triggers)
  - [Developer And Operations](#developer-and-operations)
  - [Product And Administration](#product-and-administration)
  - [Architecture And Ownership](#architecture-and-ownership)
  - [Data And Security](#data-and-security)
  - [Agent And Documentation System](#agent-and-documentation-system)
- [11. Promotion Mapping](#11-promotion-mapping)
- [12. Readiness Before Implementation](#12-readiness-before-implementation)
- [13. Sync During Work](#13-sync-during-work)
- [14. Close-Out Gate](#14-close-out-gate)
- [15. GitHub Issue Expectations](#15-github-issue-expectations)
- [16. Pull Request And Work Summary Expectations](#16-pull-request-and-work-summary-expectations)
- [17. Commit Scope](#17-commit-scope)
- [18. Runbook Synchronization](#18-runbook-synchronization)
- [19. Agent Instruction Synchronization](#19-agent-instruction-synchronization)
- [20. Review](#20-review)
- [21. Completion Criteria](#21-completion-criteria)
- [22. Related](#22-related)

## 1. Purpose

Define the minimum synchronization required when planned systems are implemented, materially changed, superseded, or retired.

This standard exists so contributors and agents can answer:

- what was requested
- what was planned
- what is implemented now
- what changed from the plan
- what remains incomplete
- where durable truth lives
- what verification and review occurred

## 2. Scope

This standard applies to work affecting:

- Core capabilities
- Modules
- UI
- Laravel integration
- owner-specific Surfaces, Delivery Adapters, and Host-owned Registries
- architecture
- feature behavior
- flows
- database schema and contracts
- security and data handling
- setup, deployment, operations, or runbooks
- documentation standards and templates
- coding-agent standards, instructions, and skills

It applies to code and documentation-only work when current implementation or canonical ownership changes.

## 3. Core Rule

When a planned or documented system is implemented or materially changed, synchronize the relevant sources in the same work cycle.

At minimum, align:

- GitHub issue or authorized task
- GitHub Project status when used
- planning document when one exists
- canonical owner document
- PR, commit, or work summary
- applicable runbook, decision, release note, or database contract

The work is not documentation-complete until these sources agree.

## 4. Source Roles

| Source                         | Role                                                                        |
| ------------------------------ | --------------------------------------------------------------------------- |
| GitHub issue                   | Bounded work packet, acceptance criteria, dependencies, and task discussion |
| GitHub Project                 | Priority, delivery status, phase, risk, and sequencing                      |
| Pull request                   | Reviewable implementation evidence and merge context                        |
| Commit history                 | Versioned repository change history                                         |
| Planning document              | Target state, sequence, decomposition, open questions, and variance         |
| Canonical owner document       | Current durable architecture, behavior, schema, standard, or procedure      |
| ADR                            | Durable cross-cutting decision rationale and lifecycle                      |
| Release note                   | Release-specific rollout, migration, and caution context                    |
| Runbook                        | Current operator-executable procedure                                       |
| `docs/11-ai/` working artifact | Non-canonical draft, review, research, or promotion candidate               |

Do not use one source to replace responsibilities owned by another.

## 5. Planning Documents Are Working Owners Of Intent

Planning documents may change while implementation is active.

Update planning when:

- implementation diverges materially
- scope is added, split, deferred, or removed
- dependencies change
- a decision is accepted
- an open question is resolved
- a planned slice becomes implemented
- canonical ownership changes
- the plan is superseded

Planning remains canonical for planning intent, but not for implemented architecture, behavior, schema, standards, or runbooks.

## 6. Required Synchronization Layers

| Layer                   | Must Answer                                            |
| ----------------------- | ------------------------------------------------------ |
| Issue or task           | What was requested and accepted?                       |
| Project                 | What is the current delivery state and priority?       |
| Planning                | What was intended, changed, deferred, or remains open? |
| Canonical docs          | What is true now?                                      |
| Implementation evidence | What changed and what verification passed?             |
| Operations              | What operator procedure changed?                       |

Not every change needs every layer. Each applicable layer must be reviewed explicitly.

## 7. Required Status Content

Planning and canonical documents must state enough current status to answer applicable questions:

- planned only?
- partially implemented?
- implemented in code?
- migrated?
- deployed?
- usable UI?
- automated tests?
- manual review?
- operational procedure established?
- known gaps?
- owning issue?

Use headings such as:

- `## Status`
- `## Implementation Status`
- `## Current Implementation`
- `## Target State`
- `## Known Gaps`
- `## Related GitHub Issues`
- `## Tests And Verification`
- `## Docs To Promote Or Update`

Avoid vague terms such as “mostly done.”

## 8. Controlled Status Terms

Use documentation lifecycle values defined in:

- [How To Write Docs](How%20To%20Write%20Docs.md)

Do not use document metadata as a replacement for detailed implementation status when the distinction matters.

## 9. Linking Pattern

Use these relationships:

- issue → planning and canonical docs when useful
- planning → affected canonical owners
- canonical owner → active planning while useful
- PR → issue and documentation impact
- ADR → affected canonical owners
- release note → ADRs and runbooks
- runbook → governing standards and current operational owner
- `docs/11-ai/` artifact → intended canonical promotion target

Metadata parent fields do not replace visible links.

## 10. Documentation Sync Triggers

### Developer And Operations

- setup
- build
- tests
- deployment
- release
- queues
- cron or scheduler
- cache
- storage
- mail
- services
- troubleshooting
- backup
- recovery
- incident response

### Product And Administration

- user or admin workflow
- tenant or workspace behavior
- public behavior
- settings
- navigation
- dashboard
- setup surfaces

### Architecture And Ownership

- Core capability boundary
- Module boundary
- UI boundary
- Laravel integration boundary
- owner-specific Surface, Delivery Adapter, or Host-owned Registry responsibility
- route, controller, action, service, policy, view, registry, or renderer ownership

### Data And Security

- schema
- migrations
- sync payloads
- settings or config
- permissions
- authentication
- MFA
- sessions
- audit
- monitoring
- logging
- exports
- DLP
- retention
- secrets
- tokens
- webhooks
- service accounts
- evidence handling

### Agent And Documentation System

- `AGENTS.md`
- `.agents/skills/`
- coding-agent standards
- documentation standards
- templates
- planning organization
- document-type contracts
- agent working-document promotion

When no trigger applies, the work summary should state that there is no documentation impact.

## 11. Promotion Mapping

When planned or working content becomes durable, promote it to:

| Durable Truth                    | Owner                              |
| -------------------------------- | ---------------------------------- |
| Cross-cutting decision           | `docs/01-decisions/`               |
| Rule or requirement              | `docs/02-standards/`               |
| Architecture                     | `docs/03-architecture/`            |
| Behavior                         | `docs/04-features/`                |
| System flow                      | `docs/05-flows/`                   |
| Schema or data contract          | `docs/06-database/`                |
| Planning intent                  | `docs/07-planning/`                |
| Supporting reference or template | `docs/09-reference/`               |
| Operational procedure            | `docs/10-runbooks/`                |
| Agent working draft or review    | `docs/11-ai/` until promotion      |
| Persistent agent rule            | Root or scoped `AGENTS.md`         |
| Repeatable agent workflow        | `.agents/skills/`                  |
| Coding-agent policy              | `docs/02-standards/coding-agents/` |

After promotion:

- update source status
- link to the promoted owner
- remove duplicated durable text
- archive or delete the source when its working purpose ends

## 12. Readiness Before Implementation

Before implementing from a plan or issue, confirm:

- outcome and acceptance criteria
- owning layer
- canonical owner documents
- scope and non-goals
- dependencies
- accepted decisions
- verification
- documentation sync targets
- manual or specialist review
- approval for destructive, security-sensitive, data, or deployment work

Use the coding implementation readiness owner when applicable:

- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)

## 13. Sync During Work

Update documentation during implementation when:

- the approach changes materially
- a decision is accepted
- scope changes
- a blocker changes the plan
- a planned slice is implemented
- a new canonical owner is established
- a runbook procedure changes
- an issue's acceptance criteria change

Keep sync scoped to the current issue.

Do not mix broad cleanup into unrelated implementation work.

## 14. Close-Out Gate

Before closing work, confirm:

- accepted implementation scope is complete
- planning is accurate
- canonical docs reflect current truth
- status and known gaps are explicit
- indexes are current
- tests and verification are recorded
- required runbooks are current
- required decisions and release notes exist
- no durable truth remains only in planning, issue comments, PR text, or agent working documents
- GitHub Project status is accurate when used

Code-complete is not documentation-complete.

## 15. GitHub Issue Expectations

Issues should contain:

- requested outcome
- acceptance criteria
- scope and non-goals
- dependencies
- canonical owner links
- verification
- review requirements

When implementation changes scope materially:

- update the issue
- record the accepted variance
- update affected planning
- promote durable decisions

Do not leave durable architecture, behavior, schema, or policy only in issue comments.

## 16. Pull Request And Work Summary Expectations

A PR or work summary should identify:

- issue
- scope completed
- files changed
- behavior changed
- docs updated
- tests and verification
- manual review
- known gaps
- follow-up work

When no docs changed, explain why.

PR text is evidence, not the canonical owner of system truth.

## 17. Commit Scope

Acceptable patterns:

- one scoped implementation commit including required docs
- one implementation commit followed by one documentation-sync commit in the same work cycle
- one documentation-only commit for documentation issues

Do not:

- leave required documentation updates across sessions without an owner
- stage unrelated documentation cleanup
- use `git add .` in a dirty working tree without explicit authorization and verified scope

## 18. Runbook Synchronization

When operational behavior changes:

- update the governing standard when the rule changes
- update the runbook when the executable procedure changes
- update architecture when service structure changes
- update planning when future work changes
- update release notes when rollout impact changes

Do not store historical deployment evidence inside the current runbook.

Use:

- [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)

## 19. Agent Instruction Synchronization

When agent behavior changes, review:

- root `AGENTS.md`
- scoped `AGENTS.md`
- `.agents/skills/`
- `docs/02-standards/coding-agents/`
- documentation templates
- `docs/11-ai/` working artifacts

Do not leave persistent rules only in `docs/11-ai/`.

Do not copy canonical product or technical truth into skills.

## 20. Review

Before treating synchronization as complete, review:

- issue accuracy
- Project status
- planning accuracy
- canonical owner accuracy
- implementation evidence
- runbook accuracy
- known gaps
- indexes and links
- required ADRs
- required release notes
- required agent instructions
- tests and manual review evidence

Use:

- [Documentation Review Standards](Documentation%20Review%20Standards.md)

## 21. Completion Criteria

Synchronization is complete when:

- applicable sources agree
- canonical owners describe current truth
- planning records current intent and remaining work
- issue and Project state are accurate
- implementation evidence is available
- operational procedures are current
- working documents have been promoted or retained with a clear status
- no competing active authority remains
- required review passed

## 22. Related

- [Documentation Standards Index](index.md)
- [How To Write Docs](How%20To%20Write%20Docs.md)
- [Document Type Standards](Document%20Type%20Standards.md)
- [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)
- [Doc Governance](Doc%20Governance.md)
- [Documentation Review Standards](Documentation%20Review%20Standards.md)
- [Agent Implementation Checklist](../coding/Agent%20Implementation%20Checklist.md)
- [Coding Agent Standards](../coding-agents/index.md)
