# Review Document

Review one documentation target or one tightly related documentation scope and produce a structured `doc-review-####.md` record.

## Goal

Perform a direct document review against repo standards, governance rules, and the applicable benchmark.

This skill:
- performs the review directly
- does NOT modify canonical docs
- does NOT implement fixes
- writes review artifacts only under `docs/11-ai/active-doc-reviews/`

---

## Required Input

The request must identify:
- one target file
- or one tightly related document set with a clear common owner

Valid examples:
- one runbook
- one skill file
- one standards note
- one doc plus its immediately coupled index or template

Resolve review state via:
- `docs/11-ai/active-doc-reviews/index.md`

Stop if:
- no target is identified
- the requested scope is repo-wide or too broad to review reliably in one pass
- the target is third-party or vendor-owned content

---

## Scope

Read:
- the target document(s)
- `docs/11-ai/agent-skill-writing-benchmark.md` when the target is an agent instruction file
- directly relevant governing docs only

Write:
- one `docs/11-ai/active-doc-reviews/doc-review-####.md` file
- the matching row in `docs/11-ai/active-doc-reviews/index.md`

Exclude:
- `docs/_archive/`
- vendor or dependency documentation unless the user explicitly asks to audit it as reference only

Do NOT write:
- canonical docs under `docs/01-decisions/` through `docs/10-runbooks/`
- `.agents/skills/*` target files themselves

---

## Rules

- Do NOT implement fixes in this skill
- Do NOT redesign the system
- Do NOT expand scope beyond the requested owner area
- Do NOT create duplicate review records for the same in-progress pass unless the existing record is intentionally superseded
- Keep findings tied to:
  - correctness
  - ownership
  - ambiguity
  - inconsistency
  - missing procedure or safeguards
- If the target is actually a code or UI implementation issue, STOP and route to the appropriate batch or implementation workflow

## Concurrency Preflight

Before creating or updating a review record:

- confirm current branch and worktree path
- confirm whether another review writer is already preparing a new `doc-review-####` entry
- check `.agents/session-scope-claims.json` for conflicting advisory claims when available

Stop if:
- the intended review scope is already actively claimed by another writable review session
- a concurrent review writer would create or update the shared review ledger at the same time without coordination
- the review should remain read-only and no review-file write is actually required

---

## Review Method

### 1. Confirm the target and review type

- verify the exact file or tightly related file set
- identify the governing standards or benchmark for that target
- stop if the target is too broad for one review record

### 2. Read the governing context

Load only the smallest set of governing material required to audit the target, such as:
- branch ownership rules
- relevant runbook
- relevant benchmark
- active review ledger conventions

### 3. Audit the document

Check for:
- incorrect scope or ownership
- missing procedural steps
- missing stop conditions
- conflicting rules
- stale path or naming references
- unclear write authority
- output contracts that are missing or unenforceable

### 4. Determine whether this is a new review or re-review

If the request references an existing `doc-review-####`:
- update the existing review file
- increment `Review Pass`
- update the existing index row

Otherwise:
- create a new `doc-review-####.md`
- determine the next sequential ID from the review index
- add a new index row

### 5. Record findings only

Create findings that include:
- type
- location
- issue
- required action
- constraints
- decision state

If no meaningful findings exist:
- still create or update the review record
- set `Status = CLOSED`
- record `none` under Findings or explain that no material gaps were found in `Resolution Notes`

---

## Output File Structure

Use this structure:

```md
# Document Review <ID>

## Review Pass
1

## Target
<file or scoped area>

## Review Type
Document Review

## Status
OPEN

## Purpose
<short description>

## Scope
- <paths reviewed>

## Findings

### Finding 1
- type:
- location:
- issue:
- required action:
- constraints:
- decision state:

## Summary
- benchmark alignment:
- workflow alignment:
- readiness:

## Unresolved Decisions
- none

## Implementation Status
not started

## Exit Criteria
- <review-specific closure checks>

## Resolution Notes
- none
```

---

## Index Update

Update `docs/11-ai/active-doc-reviews/index.md` with:
- ID
- Date
- Target
- Type = `Docs Review`
- Status
- Implementation Status
- concise Notes

Do NOT modify unrelated rows.

---

## Final Rule

If the review target is too broad, under-specified, or not repo-owned, STOP and narrow the scope before creating misleading review output.
