# Work Batch

Execute the current `/docs/08-active/` batch through the canonical batch workflow.

## Required Prompt Contract

- workflow: `work-batch`
- target ID: current batch plus targeted CQ ID(s), when applicable
- allowed file scope: batch-owned active files plus directly required canonical/code files
- read path: active batch state, targeted prior worklog only when needed, directly affected files
- stop condition: unclear scope, ownership, queue state, review surface, deployment path, or standards contract
- validation path: tests/checks required by the targeted batch item

Use `docs/10-runbooks/agent-token-efficiency.md` for read budgets and prompt hygiene.

## Required Reads

- `/docs/08-active/batch.md`
- `/docs/08-active/checklist.md`
- `/docs/08-active/change-queue.md`
- `/docs/08-active/review.md`
- `/docs/08-active/notes.md`
- `/docs/08-active/worklogs/index.md`
- only targeted prior worklogs needed for the current CQ item

## Rules

- Work only inside the active batch scope.
- Do not expand scope, introduce new rules/tokens, or fix adjacent issues unless they block the batch.
- Preserve branch responsibility boundaries.
- Do not mark checklist items complete; annotate only top-level status.
- Do not archive or reset `/docs/08-active/`.
- Use local dev as the default review surface unless shared review is required.
- Follow git/deploy runbooks only when the pass is reviewable and deployment is required.

## Concurrency Preflight

Before writing:

- confirm this session owns the active batch workspace
- confirm branch and worktree path
- check `.agents/session-scope-claims.json` when available
- treat `/docs/08-active/` as one singleton workspace, not per-CQ locks

Stop if writable ownership is unclear or another writer owns the same active workspace.

## Execution Checklist

1. Read active batch state and identify the exact target CQ item or base batch task.
2. Continue any unfinished `In Progress` item before claiming another item.
3. Move a targeted `Ready To Implement` CQ item to `In Progress` before implementation edits.
4. Implement only the targeted work.
5. Create one new immutable worklog using the next ID from `worklogs/index.md`.
6. Update `worklogs/index.md`, `notes.md`, `review.md`, and checklist annotations to match actual state.
7. Move targeted CQ items to `Implemented Pending Review`, `Blocked`, or `Deferred`.
8. Commit/push/deploy only when required by the review surface and allowed by the runbooks.

## Worklog Requirements

Each pass creates `/docs/08-active/worklogs/worklog-<phase>-<batch>-####.md` with:

- Prompt Summary
- Scope
- Files Changed
- Targeted Change Queue IDs
- Queue Item Grouping Rationale
- Work Completed
- Checklist Impact
- Change Queue Impact
- Validation Performed
- Review Surface
- Issues Found
- Deferred Items
- Commit / Deploy Status
- Notes

## Stop Conditions

Stop and report if:

- scope or ownership is ambiguous
- `batch.md`, `checklist.md`, and `change-queue.md` conflict
- a required standards/contract owner is missing
- a reviewable item needs unavailable deployment credentials or path
- the task needs parallel writers in the same active workspace

## Output

Report:

1. workflow executed
2. files changed
3. worklog created
4. CQ/checklist/review state changed
5. validation performed
6. commit, push, and deploy status
7. blockers or next required workflow
