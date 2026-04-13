---
description: "Start or continue implementation of the currently active phase batch. Reads repo state, confirms active batch, executes the next dependency-safe code slice, and prepares review handoff after tests and doc sync."
name: "Phase Batch Implementation"
argument-hint: "Phase and batch, or 'active' to auto-detect from repo state, for example: Phase 2 Batch 4"
agent: "agent"
---
Start or continue implementation of the specified phase batch.

Default assumption: if the batch note already defines clear contracts, dependencies, touchpoints, tests, and doc sync expectations, implement directly without requiring `/phase-batch-development` first.

Execution guardrails:
- Prefer direct file edits in the VS Code editor for both code and docs.
- Do not use bash or scripted bulk search/replace to rewrite files unless explicitly requested.
- Keep edits minimal and scoped to the active batch's implementation slice.
- Confirm whether the session is operating in writable mode or read-only mode before any edits.
- Before writing, verify branch/worktree context, dirty state, and whether another writable same-folder session is already active.
- If another same-folder session is already the writer, stay read-only and stop before edits unless this task is moved into a separate branch and separate worktree.
- Before writing, summarize intended file-by-file changes; after writing, summarize exactly what changed.

Do the following:
1. Confirm current operating mode and whether this session is allowed to write in the current folder.
2. Read the phase index and confirm which batch is currently active.
3. Read the batch note, the phase planning parent, and linked canonical owner docs.
4. Decide whether the batch is already delivery-ready for implementation or whether planning gaps still block safe execution.
5. Confirm current repo state: what is done, what is uncommitted, what is next.
6. If the batch is delivery-ready, identify the next dependency-safe implementation slice — do not re-plan or re-implement completed items.
7. If the batch is not delivery-ready, stop before code edits and recommend `/phase-batch-development` with explicit reasons tied to the missing planning detail.
8. Implement code changes (routes, requests, services, policies, migrations, views, components as required) only when the batch is delivery-ready.
9. Run relevant tests and confirm passing.
10. Sync documentation updates in the same work cycle.
11. Prepare review handoff: summarize completed work, tests run, docs synced, remaining open items, and the exact scoped files that should be reviewed next.

Rules:
- Never re-plan completed items.
- Never require `/phase-batch-development` when the batch note is already implementation-ready.
- Only recommend `/phase-batch-development` when one or more concrete planning gaps block safe implementation, such as missing contracts, unresolved dependencies, unclear code touchpoints, missing test expectations, or ambiguous doc sync scope.
- Never skip test execution for implemented changes.
- Never defer doc sync to a separate session.
- Never begin same-folder concurrent writes when another writable session is already active.
- If blockers are found (missing contracts, open decisions), report them and stop rather than guess.

Output after completion:
- Delivery-readiness decision
- What was implemented
- Test results
- Docs updated
- Remaining open items in this batch
- Planned file changes (before edits)
- Applied file changes (after edits)
- Recommended review target and review handoff notes

If implementation is paused in favor of `/phase-batch-development`, report:
- Why the batch is not yet delivery-ready
- The specific missing planning details that require batch development work
- The exact recommendation to run `/phase-batch-development` first

Normal next step after implementation:
1. Run `/phase-batch-review` for this batch.
2. Do not mark the batch complete from implementation alone.
3. Do not commit or push from implementation unless the user explicitly overrides the standard review-first flow.
4. Leave a clear review handoff summary in the final response.
