# Review Document

Review one documentation target or tightly related owner set and write a structured review record.

## Required Prompt Contract

- workflow: `review-document`
- target ID: target file/set or existing doc-review ID
- allowed file scope: read target and governing docs; write only active doc-review artifacts
- read path: target, nearest AGENTS, applicable benchmark/standard, review ledger
- stop condition: target missing, repo-wide scope, third-party content, or implementation work required
- validation path: review file plus ledger row only

Use `docs/10-runbooks/agent-token-efficiency.md` for read budgets.

## Required Input

The request must identify:

- one file
- one tightly related document set with a common owner
- or an existing review record for re-review

Stop if the target is broad, ambiguous, vendor-owned, or actually a code/UI implementation issue.

## Read Scope

Read only:

- target document(s)
- nearest `AGENTS.md`
- `docs/11-ai/agent-skill-writing-benchmark.md` for agent instruction files
- directly relevant governing docs
- `docs/11-ai/active-doc-reviews/index.md`

Exclude `/docs/_archive/`.

## Write Scope

Write only:

- `docs/11-ai/active-doc-reviews/doc-review-YYYY-MM-DD-<slug>.md`
- the matching ledger row

Do not edit the reviewed target in this workflow.

## Review Checklist

Check for:

- wrong owner or branch responsibility
- missing procedure, stop condition, or output contract
- ambiguous write authority
- stale paths or naming
- conflicts with AGENTS, runbooks, standards, or benchmarks
- excessive scope that would force broad reads in future sessions

## Record Handling

- New records use date-plus-slug filenames.
- Re-reviews update the existing record and increment review pass.
- If no material findings exist, set status `CLOSED` and record no findings.

## Stop Conditions

Stop if:

- another writer owns the same ledger scope
- the document set is too broad for one review
- findings require implementation before the review can stay truthful

## Output

Report:

1. review artifact
2. ledger row changed
3. findings or no findings
4. implementation status
5. next required workflow, if any
