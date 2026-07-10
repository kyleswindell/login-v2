<!--
DOC-META
title: Documentation Review Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/Documentation Review Standards.md
parent: docs/02-standards/documentation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines documentation review outcomes, ownership, type, metadata, link, structure, synchronization, runbook, and completion checks.
-->

# Documentation Review Standards

Parent: [Documentation Standards Index](index.md)
- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Core Review Rule](#3-core-review-rule)
- [4. Review Outcomes](#4-review-outcomes)
- [5. Documentation Impact Review](#5-documentation-impact-review)
- [6. Required Review Checks](#6-required-review-checks)
- [7. Branch Ownership Review](#7-branch-ownership-review)
- [8. Document Type Review](#8-document-type-review)
- [9. Metadata Review](#9-metadata-review)
- [10. Link Review](#10-link-review)
- [11. Index Review](#11-index-review)
- [12. Planning Review](#12-planning-review)
- [13. Decision Review](#13-decision-review)
- [14. Runbook Review](#14-runbook-review)
- [15. Reference And Agent Working Document Review](#15-reference-and-agent-working-document-review)
- [16. Structure And Split Review](#16-structure-and-split-review)
- [17. Template Review](#17-template-review)
- [18. Agent And Coding-Agent Review](#18-agent-and-coding-agent-review)
- [19. Implementation Synchronization Review](#19-implementation-synchronization-review)
- [20. Review Questions](#20-review-questions)
  - [20.1. Behavior And Operations](#201-behavior-and-operations)
  - [20.2. Data And Security](#202-data-and-security)
  - [20.3. Ownership](#203-ownership)
  - [20.4. Structure](#204-structure)
  - [20.5. Lifecycle](#205-lifecycle)
- [21. Completion Criteria](#21-completion-criteria)
- [22. Related](#22-related)

## 1. Purpose

Define how documentation changes are reviewed for accuracy, ownership, structure, synchronization, operational safety, and completion.

## 2. Scope

This standard applies to:

- documentation-only changes
- code changes with documentation impact
- standards
- architecture
- features
- flows
- database documentation
- planning
- matrices
- indexes
- references
- runbooks
- decisions
- release notes
- agent working documents
- templates
- folder `AGENTS.md` files when they affect documentation routing

Archived history is reviewed only when a task explicitly owns its classification, restoration, or cleanup.

## 3. Core Review Rule

A documentation change passes only when:

- the durable concept has one canonical owner
- the selected `doc_type` matches the responsibility
- the file lives in the correct branch
- current truth is accurate
- required links and indexes are current
- planning and implementation state agree
- non-canonical material does not compete with canonical owners
- the document is complete for its type

## 4. Review Outcomes

| Outcome             | Meaning                                                                       |
| ------------------- | ----------------------------------------------------------------------------- |
| Pass                | Accurate, correctly owned, linked, complete, and ready.                       |
| Pass with follow-up | Acceptable now; a non-blocking bounded follow-up is tracked.                  |
| Needs changes       | Required accuracy, ownership, type, link, safety, or completion work remains. |
| Not applicable      | The reviewed implementation has no documentation impact.                      |

Do not use `Pass with follow-up` to defer required documentation that must travel with the current change.

## 5. Documentation Impact Review

Ask whether the change affects:

- developer setup
- build or test behavior
- deployment or release
- queues, cron, scheduler, cache, storage, mail, or services
- troubleshooting, recovery, or incident response
- user, admin, tenant, workspace, or public behavior
- Core Capabilities
- Platform Surfaces
- Business Modules
- Shared UI
- architecture or ownership
- schema or data contracts
- authentication, access control, audit, monitoring, secrets, or data movement
- agent instructions, skills, or documentation governance

When none apply, the implementation or PR summary should state that there is no documentation impact.

## 6. Required Review Checks

Verify:

- purpose and scope are clear
- current status is accurate
- canonical ownership is correct
- `doc_type` is controlled and appropriate
- metadata is valid
- the correct template is used
- the document is reachable from an index
- the document links upward
- direct dependencies link laterally
- Markdown links are used
- no stale or legacy path was introduced
- no duplicate owner was introduced
- no unrelated cleanup was mixed in
- the document is narrowly scoped enough to maintain
- implementation or planning synchronization is complete

## 7. Branch Ownership Review

Use:

- [Doc Governance](Doc%20Governance.md)

Confirm:

| Branch                  | Review Expectation                    |
| ----------------------- | ------------------------------------- |
| `docs/01-decisions/`    | Elevated decision records only        |
| `docs/02-standards/`    | Enforceable requirements              |
| `docs/03-architecture/` | Accepted structure and boundaries     |
| `docs/04-features/`     | Canonical behavior                    |
| `docs/05-flows/`        | System execution paths                |
| `docs/06-database/`     | Schema and data contracts             |
| `docs/07-planning/`     | Planning intent and sequence          |
| `docs/09-reference/`    | Non-canonical support                 |
| `docs/10-runbooks/`     | Operator-executable procedures        |
| `docs/11-ai/`           | Non-canonical agent working documents |

If content spans branches, require a split or promotion.

## 8. Document Type Review

Use:

- [Document Type Standards](Document%20Type%20Standards.md)

Review:

- primary artifact responsibility
- normal branch
- canonical default
- required content
- prohibited content
- template
- lifecycle
- type-specific completion

Do not accept a document because its filename resembles a controlled type.

## 9. Metadata Review

Review:

| Field            | Question                                     |
| ---------------- | -------------------------------------------- |
| `title`          | Does it match the H1?                        |
| `doc_type`       | Does it match the artifact responsibility?   |
| `status`         | Does it reflect current lifecycle?           |
| `owner`          | Is it the smallest accurate owner?           |
| `canonical`      | Does the file actually own durable truth?    |
| `canonical_path` | Does it match the file path?                 |
| `parent`         | Is the correct index or hub identified?      |
| `template`       | Is the correct template referenced?          |
| `summary`        | Does it describe one primary responsibility? |

Metadata does not replace visible links.

## 10. Link Review

Review:

- upward parent link
- downward index link
- direct dependency links
- planning-to-canonical links
- canonical-to-active-planning links when useful
- decision-to-owner links
- runbook-to-standard links
- standard-to-template links
- supersession and replacement links

Confirm links are portable Markdown.

## 11. Index Review

When a child is added, moved, renamed, superseded, archived, or deleted:

- update the parent index
- remove stale entries
- keep descriptions concise
- preserve active navigation
- identify historical areas clearly
- avoid copying child content into the index

## 12. Planning Review

Confirm planning documents identify:

- current state
- target state
- scope and non-goals
- dependencies
- decisions and open questions
- implementation slices
- acceptance or exit criteria
- tests and verification
- affected canonical owners
- promotion targets
- GitHub issues

Confirm planning does not remain the final owner of implemented truth.

## 13. Decision Review

Confirm an elevated decision record:

- is durable or cross-cutting enough to justify elevation
- has status
- explains context
- states the decision
- states consequences
- links affected canonical owners
- identifies supersession when applicable

Confirm current-state docs were updated separately.

## 14. Runbook Review

Use:

- [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)

Confirm:

- real operational trigger
- authorized operator
- prerequisites
- environment identification
- safe ordered procedure
- objective verification
- failure handling
- rollback or explicit no-rollback rationale
- escalation
- evidence requirements
- completion criteria
- secret safety
- current commands
- absence of planning and historical status

Do not accept a checklist of future operational decisions as a runbook.

## 15. Reference And Agent Working Document Review

For `reference` and `agent-guidance` documents, confirm:

- `canonical: false` unless a narrowly justified exception exists
- provenance is identified when relevant
- intended canonical owner is linked
- no durable rule is stranded there
- promotion or closure path is clear
- secrets and sensitive evidence are absent

## 16. Structure And Split Review

Consider a split when:

- multiple owners are mixed
- multiple document types are mixed
- only one section is usually needed
- the file exceeds roughly 2,000 words or 300–400 lines and contains multiple responsibilities
- agent or human retrieval is unreliable
- repeated updates create broad merge conflicts

Confirm a split:

- preserves or replaces the old path intentionally
- creates coherent children
- updates indexes
- updates metadata
- avoids duplicated explanations
- assigns clear lifecycle states

## 17. Template Review

Templates live under:

- [Documentation Templates](../../09-reference/templates/docs/_index.md)

Confirm:

- the selected template matches [Document Type Standards](Document%20Type%20Standards.md)
- reusable shape belongs in the template
- durable requirements belong in standards
- no complete template body was copied into a standard
- changes to a reusable shape update both the template and governing standard when needed

## 18. Agent And Coding-Agent Review

When documentation affects agent behavior, review:

- root `AGENTS.md`
- scoped `AGENTS.md`
- `.agents/skills/`
- `docs/02-standards/coding-agents/`
- `docs/11-ai/`
- agent templates

Confirm:

- persistent rules live in `AGENTS.md`
- repeatable procedures live in skills
- durable policy lives in standards
- working drafts and reviews remain non-canonical
- agent convenience did not create duplicate canonical truth

## 19. Implementation Synchronization Review

Use:

- [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md)

Confirm:

- issue scope matches the docs change
- planning status is current
- canonical docs describe current implementation
- tests and verification are recorded
- known gaps are explicit
- release notes, decisions, database docs, or runbooks were updated when needed

## 20. Review Questions

### 20.1. Behavior And Operations

- Did behavior change?
- Did deployment, maintenance, recovery, or troubleshooting change?
- Is a runbook needed or outdated?
- Is the procedure executable and verified?

### 20.2. Data And Security

- Did schema, permissions, secrets, retention, exports, or evidence handling change?
- Does specialist review apply?
- Does the document expose sensitive information?

### 20.3. Ownership

- Is the branch correct?
- Is the type correct?
- Is another document already the owner?
- Does working material need promotion?

### 20.4. Structure

- Is the document reachable?
- Are indexes current?
- Should the file be split?
- Is an old path still needed as a hub?

### 20.5. Lifecycle

- Is status accurate?
- Is the document current, planned, superseded, or historical?
- Is a superseded file still appearing as active guidance?

## 21. Completion Criteria

Documentation review is complete when:

- ownership is correct
- type is correct
- metadata is valid
- content is accurate
- links and indexes are current
- type-specific requirements pass
- planning and implementation are synchronized
- non-canonical content has a promotion or closure path
- superseded content is retired
- required specialist review is complete
- guardrail results are recorded
- follow-up work is bounded and tracked

## 22. Related

- [Documentation Standards Index](index.md)
- [How To Write Docs](How%20To%20Write%20Docs.md)
- [Document Type Standards](Document%20Type%20Standards.md)
- [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)
- [Doc Governance](Doc%20Governance.md)
- [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md)
- [Implementation Status And Development Sync Standard](Implementation%20Status%20And%20Development%20Sync%20Standard.md)
