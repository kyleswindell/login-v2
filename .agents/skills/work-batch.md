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

- Enter this workflow only when the user explicitly requests `work-batch`, asks to implement an already selected batch item, or provides a paste-ready work-batch prompt. Methodology, diagnosis, review, planning, and "what should we do?" prompts remain read-only until implementation is explicitly requested.
- Work only inside the active batch scope.
- Do not expand scope, introduce new rules/tokens, or fix adjacent issues unless they block the batch.
- Preserve branch responsibility boundaries.
- Use the narrowest validation path that proves the targeted contract before running broader suites.
- Before a large grouped CQ pass, state the grouping rationale and validation strategy. If one UI surface fails twice, stop for root-cause review before another correction pass.
- Do not mark checklist items complete; annotate only top-level status.
- Do not archive or reset `/docs/08-active/`.
- Use local dev as the default review surface unless shared review is required.
- Follow git/deploy runbooks only when the pass is reviewable and deployment is required.

## Validation Selection

Validation must scale with the targeted change.

- Validation matrix:
  - docs or instruction-only: docs guardrail or targeted text/link checks only
  - single UI route/component/partial: named `--filter` test plus source assertions
  - shared JS lifecycle, global CSS, catalogs, routes, or generated assets: focused tests plus build and browser review
  - final batch review: full integration files only when the final gate requires them
- Start with the most specific test, static check, or browser route that covers the touched behavior.
- Run a broader file, suite, build, or docs guardrail only when one of these is true:
  - the targeted queue item explicitly requires it
  - the change affects shared routing, catalogs, lifecycle initialization, generated assets, or cross-page contracts
  - the focused check cannot prove the behavior
  - the pass is being prepared for a final review gate that requires broader regression proof
- Do not rerun broad suites just because a worklog, notes file, or review annotation changed after already-passing source validation; run the docs guardrail only when the changed docs are inside its responsibility.
- If a known broad test file is expensive, prefer `--filter` or a named test method for iterative work and run the full file at most once at the end when justified.
- Record why any broad validation was run. If it times out or is slow, record the observed duration and the narrower command future agents should start with.
- Avoid broad negative HTML assertions against an entire route response when the rule applies to one partial, component, or region. Scope the assertion to the owning source file or a stable container marker.

For UI Reference work:

- Treat `tests/Feature/Platform/PlatformUiReferenceTest.php` as broad integration coverage. It renders many UI Reference routes and can take minutes.
- For sidebar-only changes, start with the focused sidebar/workspace test filter and source-level assertions for the sidebar partial.
- Run the full UI Reference test file only after shared catalog/routing/lifecycle changes or as a final justified regression gate.
- Before authenticated local browser review, run `php artisan local:ready` or `npm run local:ready` so the review user and `public/hot` are normalized. Do not repeatedly restart, cache-bust, or move `public/hot` during iteration; use the local browser review runbook if the readiness command reports a broken service.

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

Worklogs record final validation, material caveats, and durable findings only. Do not narrate every failed attempt, cache-bust, restart, temporary hot-file move, or repeated environment workaround; move recurring operational facts into a runbook instead.

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
