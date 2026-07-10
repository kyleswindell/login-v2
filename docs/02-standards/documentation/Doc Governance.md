<!--
DOC-META
title: Doc Governance
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/documentation/Doc Governance.md
parent: docs/02-standards/documentation/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines canonical documentation ownership, branch classification, promotion, link, index, template, and lifecycle guardrails.
-->

# Doc Governance

Parent: [Documentation Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Core Rule](#3-core-rule)
- [4. Branch Ownership](#4-branch-ownership)
- [5. Document Type Classification](#5-document-type-classification)
- [6. Canonical And Non-Canonical Content](#6-canonical-and-non-canonical-content)
- [7. Metadata Governance](#7-metadata-governance)
- [8. Template Governance](#8-template-governance)
- [9. Path And Link Guardrails](#9-path-and-link-guardrails)
- [10. Index Governance](#10-index-governance)
- [11. Planning Governance](#11-planning-governance)
- [12. Reference And Research Governance](#12-reference-and-research-governance)
- [13. Agent Working Documentation Governance](#13-agent-working-documentation-governance)
- [14. Decision Governance](#14-decision-governance)
- [15. Runbook Governance](#15-runbook-governance)
- [16. File Scope Guardrails](#16-file-scope-guardrails)
- [17. Promotion](#17-promotion)
- [18. Supersession, Archival, And Deletion](#18-supersession-archival-and-deletion)
- [19. Enforcement](#19-enforcement)
- [20. Review Checklist](#20-review-checklist)
- [21. Related](#21-related)

## 1. Purpose

Define where documentation belongs, what each branch may own, and how documents are classified, promoted, linked, superseded, archived, or deleted.

## 2. Scope

This standard applies to active documentation under `docs/`.

It excludes:

- generated artifacts
- repository files outside documentation governance
- archived historical material unless it is being reviewed or restored

Non-canonical working documents under `docs/11-ai/` remain subject to ownership, safety, and promotion rules.

## 3. Core Rule

Every durable concept must have one canonical owner.

A document may summarize related concepts briefly, but it must link to the canonical owner rather than duplicate durable truth.

When content changes authority, promote or move it to the correct owner and retire the competing copy.

## 4. Branch Ownership

| Branch                  | Owns                                                                                   |
| ----------------------- | -------------------------------------------------------------------------------------- |
| `docs/01-decisions/`    | ADRs and elevated decision records                                                     |
| `docs/02-standards/`    | Enforceable rules, conventions, requirements, and implementation standards             |
| `docs/03-architecture/` | System structure, boundaries, ownership models, and long-lived technical design        |
| `docs/04-features/`     | Canonical user, admin, platform, system, and business behavior                         |
| `docs/05-flows/`        | System execution paths and workflow sequences                                          |
| `docs/06-database/`     | Schema, tables, constraints, indexes, relationships, and data contracts                |
| `docs/07-planning/`     | Sequencing, target state, implementation slices, open questions, and planning matrices |
| `docs/09-reference/`    | Non-canonical research, examples, source material, vendor references, and templates    |
| `docs/10-runbooks/`     | Repeatable operator-executable operational procedures                                  |
| `docs/11-ai/`           | Non-canonical agent-authored drafts, reviews, research, and promotion candidates       |

Other owner surfaces:

| Surface                     | Owns                                                 |
| --------------------------- | ---------------------------------------------------- |
| Root and scoped `AGENTS.md` | Persistent agent operating rules                     |
| `.agents/skills/`           | Repeatable executable agent workflows                |
| `.agents/memory/`           | Non-canonical repo-local agent memory                |
| `.agents/baselines/`        | Generic exportable agent starter material            |
| GitHub issues               | Current bounded work packets and acceptance criteria |
| GitHub Projects             | Current delivery status, priority, and sequencing    |

## 5. Document Type Classification

Select document type using:

- [Document Type Standards](Document%20Type%20Standards.md)

Branch and type must agree.

Examples:

- a `standard` normally belongs in `docs/02-standards/`
- a `runbook` normally belongs in `docs/10-runbooks/`
- a `reference` is non-canonical by default
- an `agent-guidance` document under `docs/11-ai/` does not replace `AGENTS.md` or a skill
- a matrix may live in the branch that owns the relationship represented by the matrix

Do not select a branch solely from a filename.

## 6. Canonical And Non-Canonical Content

Use `canonical: true` when the file is an accepted source of truth for its declared responsibility.

Use `canonical: false` when the file is:

- supporting research
- a template
- an example
- an agent-authored draft
- a review artifact
- a promotion candidate
- a release-context artifact that does not own current system truth
- a historical note

A non-canonical document may be accurate. It still must not compete with a canonical owner.

## 7. Metadata Governance

Every new or materially rewritten document must follow:

- [How To Write Docs](How%20To%20Write%20Docs.md)

The metadata must accurately identify:

- type
- lifecycle
- owner
- canonical status
- path
- parent
- template
- summary

Do not introduce custom fields or uncontrolled values without updating the documentation standards and relevant tooling.

## 8. Template Governance

Copyable templates live under:

- [Documentation Templates](../../09-reference/templates/docs/_index.md)

Rules:

- standards define when and why a template applies
- templates define reusable shape
- template content must not be copied in full into standards
- update the template when reusable shape changes
- update standards when usage rules change
- do not create a template for a one-off document
- keep templates non-canonical

## 9. Path And Link Guardrails

Use portable relative Markdown links for important cross-references.

Required behavior:

- active links point to current canonical paths
- detailed documents link upward
- indexes link downward
- directly related owners link laterally
- planning documents link to canonical promotion targets
- canonical docs link back to active planning when useful
- superseded files identify replacements
- moved files preserve old paths as concise hubs only when practical

Do not:

- rely on Obsidian-only links
- leave stale legacy paths active
- create orphan documents
- create duplicate documents for the same concept
- preserve a compatibility pointer indefinitely without a migration purpose

## 10. Index Governance

Every major branch must have an `index.md`.

A major subfolder should have an index when it contains multiple related children.

Indexes must:

- state scope
- list active children
- route to the correct owner
- identify historical or deprecated areas when needed
- remain concise
- avoid duplicating child content

Update the affected index when adding, moving, superseding, archiving, or deleting a child.

## 11. Planning Governance

Planning documents may own:

- target state
- sequencing
- decomposition
- implementation slices
- dependencies
- open questions
- migration and refactor intent
- issue traceability

Planning documents must not remain the final owner of implemented:

- architecture
- behavior
- schema
- standards
- operational procedures

When planning becomes accepted or implemented truth:

1. update the canonical owner
2. update the planning status
3. link planning and canonical owners
4. preserve useful variance or rationale
5. supersede or archive planning when its active purpose ends

## 12. Reference And Research Governance

`docs/09-reference/` may contain:

- research
- third-party documentation notes
- source reviews
- examples
- templates
- screenshots
- technical lookup material

Reference content must:

- identify provenance when relevant
- identify whether it is current or historical
- link to canonical owners
- avoid silently defining repository policy
- promote durable conclusions into the correct canonical branch

## 13. Agent Working Documentation Governance

`docs/11-ai/` is a non-canonical workspace for reviewable agent-authored material.

It may contain:

- documentation drafts
- review findings
- research
- promotion candidates
- structured handoff material for documentation review

It must not become:

- a standards branch
- an architecture branch
- a task board
- a status ledger
- a skill directory
- persistent agent memory
- a secret or evidence vault

Durable coding-agent policy belongs in:

- `docs/02-standards/coding-agents/`

Persistent operating rules belong in:

- `AGENTS.md`

Executable agent procedures belong in:

- `.agents/skills/`

## 14. Decision Governance

Keep local rationale in the canonical owner when the decision is narrow and current-state focused.

Elevate a decision to `docs/01-decisions/` when it:

- is cross-cutting
- is long-lived
- changes multiple owners
- supersedes a prior accepted decision
- needs explicit lifecycle status
- needs durable rationale beyond current-state docs

Decision records explain why.

Canonical owner documents describe what is true now.

## 15. Runbook Governance

Executable operational procedures belong in `docs/10-runbooks/`.

Use:

- [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)

Do not keep policy, planning, historical environment findings, agent workflow procedures, or task status inside active runbooks.

## 16. File Scope Guardrails

Split or reorganize a document when it:

- owns multiple canonical responsibilities
- mixes current truth with planning, research, review, and history
- requires different owners to maintain independent sections
- becomes difficult to retrieve or review reliably
- duplicates content elsewhere

When splitting:

- identify the new owners first
- preserve heavily linked paths as concise hubs when useful
- update metadata and indexes
- update inbound links where practical
- avoid maintaining two active copies

## 17. Promotion

Promotion moves accepted durable content into its canonical owner.

Promotion requires:

- an identified target
- accepted content
- removal of working-only commentary
- alignment with current terminology
- correct metadata
- updated indexes and links
- retirement of the source as an active authority

Promotion is not merely copying a working file into a canonical branch.

## 18. Supersession, Archival, And Deletion

Use `superseded` when a replacement exists.

Use `archived` when historical retention remains useful.

Delete when the file:

- duplicates another source
- contains no independent historical value
- is a compatibility alias with no remaining inbound-link need
- was created accidentally
- preserves a deprecated workflow that should not remain discoverable

A superseded pointer should be short and must identify the replacement.

## 19. Enforcement

Use review and automation where practical.

Potential checks include:

- missing metadata
- invalid controlled values
- stale links
- orphan documents
- mismatched canonical paths
- missing parent links
- wrong-branch placement
- duplicate concept owners
- active references to deprecated workflow paths
- runbooks without required sections
- non-canonical files marked canonical

Automation supports governance but does not replace ownership review.

## 20. Review Checklist

Verify:

- the concept has one owner
- branch and type are correct
- canonical status is accurate
- metadata is valid
- parent and related links are current
- indexes are updated
- planning does not own implemented truth
- reference and AI working documents are non-canonical
- runbooks are executable procedures
- agent rules and skills use their correct surfaces
- obsolete competing files were retired
- no unrelated cleanup was mixed into the change

## 21. Related

- [Documentation Standards Index](index.md)
- [How To Write Docs](How%20To%20Write%20Docs.md)
- [Document Type Standards](Document%20Type%20Standards.md)
- [Runbook Documentation Standards](Runbook%20Documentation%20Standards.md)
- [Obsidian Vault Structure Guide](Obsidian%20Vault%20Structure%20Guide.md)
- [Documentation Review Standards](Documentation%20Review%20Standards.md)
- [Coding Agent Standards](../coding-agents/index.md)
- [Documentation Templates](../../09-reference/templates/docs/_index.md)
