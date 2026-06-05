# Review Docs Sync

Review implementation against canonical docs and write a docs-sync review artifact.

## Required Prompt Contract

- workflow: `review-docs-sync`
- target ID: implementation area, batch, or existing doc-sync ID
- allowed file scope: read target implementation/docs; write only `docs/11-ai/active-doc-reviews/`
- read path: target area, owning canonical docs, active review ledger
- stop condition: target missing, scope too broad, or review would become implementation
- validation path: review file plus ledger row only

Use `docs/10-runbooks/agent-token-efficiency.md` for read budgets.

## Required Input

The request must identify one implementation area, one batch, one parent planning/status sync target, or an existing doc-sync record for re-review.

Stop if the request is a standards/governance review rather than implementation-versus-doc drift.

## Read Scope

Read only:

- directly relevant code/UI files
- owning canonical docs under `/docs/02-standards/` through `/docs/07-planning/`
- `/docs/08-active/` only when the active batch is the target
- `docs/11-ai/active-doc-reviews/index.md`

Exclude `/docs/_archive/`.

## Write Scope

Write only:

- `docs/11-ai/active-doc-reviews/doc-sync-YYYY-MM-DD-<slug>.md`
- the matching row in `docs/11-ai/active-doc-reviews/index.md`

Do not edit implementation, canonical docs, planning notes, or active batch state.

## Review Checklist

Check for:

- implementation/documentation drift
- canonical ownership conflicts
- stale roadmap or phase status when reviewed implementation changed planning truth
- missing deferment handoff
- naming and terminology conflicts
- UI Reference or contract mismatch when UI is in scope

Treat implementation as source of truth unless it clearly violates an owning standard.

## Record Handling

- For a new review, create a date-plus-slug doc-sync file and add one ledger row.
- For an explicit re-review, update the existing file and ledger row.
- If no meaningful drift exists, still create or update the record, set status `CLOSED`, and record no findings.

## Stop Conditions

Stop if:

- the target spans unrelated implementation areas
- a correction is required before review can continue
- another writer owns the shared review ledger
- the review needs to become a canonical-doc or code edit

## Output

Report:

1. review artifact
2. ledger row changed
3. findings or no findings
4. implementation status
5. required next workflow, if any
