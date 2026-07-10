<!--
DOC-META
title: Agent Working Documentation And Promotion Standards
doc_type: standard
status: active
owner: ai
canonical: true
canonical_path: docs/02-standards/coding-agents/Agent Working Documentation And Promotion Standards.md
parent: docs/02-standards/coding-agents/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines the non-canonical purpose of docs/11-ai, requirements for agent-authored working documentation and review artifacts, and the process for promoting accepted content into canonical documentation owners.
-->

# Agent Working Documentation And Promotion Standards

Parent: [Coding Agent Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Ownership Model](#3-ownership-model)
- [4. Approved Uses Of `docs/11-ai/`](#4-approved-uses-of-docs11-ai)
- [5. Prohibited Uses Of `docs/11-ai/`](#5-prohibited-uses-of-docs11-ai)
- [6. Working Artifact Types](#6-working-artifact-types)
- [7. Recommended Folder Direction](#7-recommended-folder-direction)
- [8. Working Artifact Requirements](#8-working-artifact-requirements)
- [9. Review States](#9-review-states)
- [10. Creation Rules](#10-creation-rules)
- [11. Agent Maintenance Rules](#11-agent-maintenance-rules)
- [12. Canonical Promotion](#12-canonical-promotion)
- [13. Direct Canonical Updates](#13-direct-canonical-updates)
- [14. Review Requirements](#14-review-requirements)
- [15. Working Documentation Versus Memory](#15-working-documentation-versus-memory)
- [16. Working Documentation Versus Skills](#16-working-documentation-versus-skills)
- [17. Working Documentation Versus Standards](#17-working-documentation-versus-standards)
- [18. Status And Traceability](#18-status-and-traceability)
- [19. Archiving And Retention](#19-archiving-and-retention)
- [20. Superseded Authority Files](#20-superseded-authority-files)
- [21. Security And Privacy](#21-security-and-privacy)
- [22. Stop Conditions](#22-stop-conditions)
- [23. Maintenance](#23-maintenance)
- [24. Related](#24-related)

## 1. Purpose

Define how coding agents may create and maintain non-canonical working documentation before that content is reviewed, normalized, and promoted into its canonical owner.

This standard gives `docs/11-ai/` one clear responsibility:

> `docs/11-ai/` is the reviewable working-documentation and analysis workspace for agent-authored material that is not yet canonical.

It must not also own permanent standards, final architecture, implementation status, reusable skills, or repository memory.

## 2. Scope

This standard applies to:

- agent-authored documentation drafts
- canonical-document promotion candidates
- documentation review artifacts
- documentation audit findings
- source-analysis notes
- agent-produced research used for documentation work
- proposed documentation corrections
- documentation synchronization proposals
- superseded AI documentation artifacts
- archived agent documentation work

It does not apply to:

- current implementation scope
- delivery status
- canonical standards
- accepted architecture
- feature contracts
- database contracts
- operational runbooks
- `AGENTS.md`
- skills
- repo-local agent memory
- implementation source files

## 3. Ownership Model

| Information                                  | Owner                   |
| -------------------------------------------- | ----------------------- |
| Current task and acceptance criteria         | GitHub issue            |
| Active delivery state                        | GitHub Project          |
| Durable standards                            | `docs/02-standards/`    |
| Accepted architecture                        | `docs/03-architecture/` |
| Feature behavior                             | `docs/04-features/`     |
| Execution flows                              | `docs/05-flows/`        |
| Database truth                               | `docs/06-database/`     |
| Planning and sequencing                      | `docs/07-planning/`     |
| Reference material and templates             | `docs/09-reference/`    |
| Operational procedures                       | `docs/10-runbooks/`     |
| Non-canonical agent working docs and reviews | `docs/11-ai/`           |
| Persistent agent operating rules             | `AGENTS.md`             |
| Repeatable agent workflows                   | `.agents/skills/`       |
| Non-canonical agent memory                   | `.agents/memory/`       |

`docs/11-ai/` must not compete with any canonical branch.

## 4. Approved Uses Of `docs/11-ai/`

Approved content includes:

- draft replacement text for a canonical document
- cross-document review findings
- documentation normalization proposals
- unresolved documentation ownership analysis
- source comparison notes
- promotion-ready document candidates
- temporary documentation synchronization records
- AI-governance review artifacts
- evidence supporting a documentation change
- rejected or superseded agent-authored proposals
- archived historical agent documentation work

A working artifact should exist only when maintaining it outside chat provides clear review, traceability, or promotion value.

## 5. Prohibited Uses Of `docs/11-ai/`

Do not use `docs/11-ai/` for:

- canonical coding standards
- canonical agent standards
- final architecture
- final feature behavior
- final database contracts
- final runbooks
- active issue state
- active GitHub Project state
- permanent workflow instructions
- skills
- source templates
- general agent memory
- secrets or credentials
- raw production or customer-sensitive data
- duplicate permanent copies of promoted content
- unbounded agent scratch notes with no review or promotion purpose

If content is already durable and its owner is known, write it directly to the canonical owner when the work packet authorizes that change.

## 6. Working Artifact Types

Recommended working artifact categories are:

| Category | Purpose                                                             |
| -------- | ------------------------------------------------------------------- |
| Draft    | Candidate content intended for a named canonical document.          |
| Review   | Findings from reviewing one or more existing documents.             |
| Research | Source analysis used to support a future documentation decision.    |
| Proposal | A recommended structural or ownership change not yet accepted.      |
| Handoff  | A concise documentation work summary for another reviewer or agent. |
| Archive  | Closed, superseded, rejected, or historically retained material.    |

Do not create additional categories without a distinct recurring need.

## 7. Recommended Folder Direction

The target structure should move toward:

    docs/11-ai/
    ├── AGENTS.md
    ├── index.md
    ├── drafts/
    ├── reviews/
    ├── research/
    ├── handoffs/
    └── _archive/

Existing folders may remain during migration, but every retained folder must map clearly to one approved category.

Do not perform a broad folder migration solely to satisfy this standard. Move content through scoped review issues.

## 8. Working Artifact Requirements

Every working artifact must identify:

- the source issue or authorized task
- its working-artifact type
- the intended canonical owner
- the intended promotion target, when known
- its current review state
- unresolved questions
- the minimum action needed for promotion or closure

Use the normal documentation metadata required by the documentation standards.

For non-canonical files:

- `canonical` must be `false`
- `canonical_path` must identify the current file path
- `status` should reflect the working document’s current lifecycle
- the summary must state that the document is non-canonical

Include a body section near the beginning:

    ## Working Artifact Status

    - Source issue:
    - Artifact type:
    - Intended canonical owner:
    - Promotion target:
    - Review state:
    - Blocking questions:

Do not invent unsupported `DOC-META` fields.

## 9. Review States

Use these working review states:

- drafting
- ready-for-review
- changes-requested
- accepted-for-promotion
- promoted
- rejected
- superseded
- archived

These values describe the working artifact only.

They do not replace GitHub Project status or canonical document lifecycle status.

## 10. Creation Rules

Before creating a working artifact:

1. identify the source issue or task
2. confirm the content is not already canonical
3. identify the likely canonical owner
4. confirm a file provides more value than chat-only discussion
5. select the correct working-artifact type
6. choose a bounded filename
7. define the promotion or closure path

Do not create generic files such as:

    notes.md
    context.md
    updates.md
    decisions.md
    current-status.md

Prefer names that identify the reviewed subject and artifact purpose.

## 11. Agent Maintenance Rules

An agent may maintain a working artifact only within the authorized issue scope.

When updating one:

- preserve its source issue
- keep the intended canonical owner current
- separate confirmed findings from unresolved questions
- remove superseded draft text
- avoid copying unrelated canonical content
- record review outcomes concisely
- keep the artifact promotion-focused
- do not convert it into an implementation worklog

When the source issue changes scope materially, create or update the appropriate issue rather than silently broadening the artifact.

## 12. Canonical Promotion

Promotion means translating accepted working content into the correct canonical owner.

Promotion is not merely moving the file unchanged.

Before promotion:

- confirm the target owner
- confirm the target document type
- resolve blocking questions
- remove working-only commentary
- align terminology with current standards
- verify links and parent indexes
- verify implementation status claims
- obtain required human or specialist review

During promotion:

1. update or create the canonical document
2. add or update `DOC-META`
3. update parent indexes
4. update inbound links when necessary
5. remove duplicated working content
6. mark the working artifact `promoted`
7. archive or delete the working artifact according to retention needs

Do not leave the working artifact as a second active authority.

## 13. Direct Canonical Updates

An agent may update canonical documentation directly when:

- the work packet explicitly authorizes it
- the canonical owner is known
- the required behavior or decision is accepted
- the change does not require unresolved judgment
- applicable documentation standards are followed
- required review is available

Use `docs/11-ai/` first when:

- ownership is unresolved
- multiple documents need comparative review
- proposed content requires human acceptance
- source material needs normalization
- the change is an audit finding rather than an accepted correction
- the agent is producing a promotion candidate for later review

Do not require an unnecessary working artifact for every small canonical correction.

## 14. Review Requirements

Review should confirm:

- the source issue is identified
- the intended canonical owner is correct
- findings are supported
- proposed changes do not cross ownership boundaries
- deprecated terminology is removed
- active status claims are accurate
- the promotion target is viable
- canonical content is not duplicated
- sensitive information is absent
- the working artifact has a clear closure path

A review artifact must distinguish:

- confirmed defect
- recommended improvement
- open question
- rejected suggestion
- accepted promotion content

## 15. Working Documentation Versus Memory

Use `.agents/memory/` for:

- operator preferences
- recurring repository gotchas
- compact continuity notes
- non-canonical open loops

Use `docs/11-ai/` for:

- reviewable documentation drafts
- structured documentation audits
- source comparison
- promotion candidates
- findings requiring human review

A memory note should be concise and agent-oriented.

A working documentation artifact should be reviewable by a human as a document.

Do not maintain the same content in both places.

## 16. Working Documentation Versus Skills

Use a skill when the content defines a repeatable procedure.

Use a working document when the content records:

- a particular review
- a particular draft
- a particular research result
- a particular promotion candidate

When a repeated procedure emerges from several working artifacts, promote the procedure into a skill or standard.

Do not leave workflow instructions embedded in old review files.

## 17. Working Documentation Versus Standards

A standard defines durable rules.

A `docs/11-ai/` artifact may propose a standard, but it must not operate as the standard after acceptance.

When a proposal becomes durable:

1. create or update the canonical standard
2. update the standards index
3. update applicable `AGENTS.md`
4. update related skills
5. supersede or archive the working proposal

The following belong in standards rather than `docs/11-ai/`:

- instruction-surface ownership
- skill-writing requirements
- agent side-effect policy
- working-document promotion rules
- mandatory review or validation requirements

## 18. Status And Traceability

GitHub issues and GitHub Projects own active delivery state.

Working artifacts may reference issue status but must not recreate a parallel delivery board.

Do not use `docs/11-ai/` as:

- an active queue
- an implementation task board
- a replacement for issue dependencies
- a replacement for Project status
- a chronological commit ledger

Use Git history and GitHub issue history for delivery traceability.

Use working artifacts only for their documentation and review purpose.

## 19. Archiving And Retention

Archive a working artifact when:

- it was promoted and its review history remains useful
- it was rejected but the reasoning remains useful
- it was superseded
- it records a completed documentation audit
- it is retained for governance traceability

Delete a working artifact when:

- it contains no useful independent review history
- its content was fully promoted
- it was created accidentally
- it duplicates another retained artifact
- retention would create confusion

Archived files must remain non-canonical.

Do not keep obsolete files in active working folders.

## 20. Superseded Authority Files

When an existing `docs/11-ai/` file contains durable standards:

1. identify the canonical replacement
2. promote accepted rules
3. remove obsolete or deprecated workflow rules
4. update inbound links
5. replace the old file with a short superseded pointer when path preservation is useful
6. otherwise archive or delete it

Do not continue updating both the old and new files.

## 21. Security And Privacy

Do not store in working documentation:

- passwords
- tokens
- private keys
- unredacted secrets
- production credentials
- raw customer records
- unnecessary personal data
- private vulnerability evidence
- offensive-security payloads that require restricted storage

Use redacted examples and approved private evidence storage where required.

A documentation workspace is not a secure evidence vault.

## 22. Stop Conditions

Stop and request review when:

- the canonical owner is unclear
- promotion would cross documentation branches
- a proposal changes architecture or schema without an accepted decision
- the artifact contains sensitive information
- two working artifacts compete for the same purpose
- an old file may still be treated as authoritative
- broad link rewrites are required
- the proposed promotion changes implemented behavior claims
- the working artifact has no clear promotion or closure path

Report:

- the conflicting files
- the likely canonical owner
- the unresolved decision
- the minimum review needed to continue

## 23. Maintenance

When changing this standard:

- update [Coding Agent Standards Index](index.md)
- update this folder’s `AGENTS.md`
- update `docs/11-ai/AGENTS.md`
- update `docs/11-ai/index.md`
- update documentation governance standards when their ownership changes
- update relevant agent skills
- review old `docs/11-ai/` governance files for promotion or archival
- run applicable documentation guardrails

## 24. Related

- [Coding Agent Standards Index](index.md)
- [Agent Instruction Surface And Skill Authoring Standards](Agent%20Instruction%20Surface%20And%20Skill%20Authoring%20Standards.md)
- [Documentation Standards Index](../documentation/index.md)
- [How To Write Docs](../documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](../documentation/Doc%20Governance.md)
- [Documentation Review Standards](../documentation/Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)