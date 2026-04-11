---
description: "Start or continue implementation of the currently active phase batch. Reads repo state, confirms active batch, and executes the next dependency-safe code slice with tests and doc sync."
name: "Phase Batch Implementation"
argument-hint: "Phase and batch, or 'active' to auto-detect from repo state, for example: Phase 2 Batch 4"
agent: "agent"
---
Start or continue implementation of the specified phase batch.

Execution guardrails:
- Prefer direct file edits in the VS Code editor for both code and docs.
- Do not use bash or scripted bulk search/replace to rewrite files unless explicitly requested.
- Keep edits minimal and scoped to the active batch's implementation slice.
- Before writing, summarize intended file-by-file changes; after writing, summarize exactly what changed.

Do the following:
1. Read the phase index and confirm which batch is currently active.
2. Read the batch note, the phase planning parent, and linked canonical owner docs.
3. Confirm current repo state: what is done, what is uncommitted, what is next.
4. Identify the next dependency-safe implementation slice — do not re-plan or re-implement completed items.
5. Implement code changes (routes, requests, services, policies, migrations, views, components as required).
6. Run relevant tests and confirm passing.
7. Sync documentation updates in the same work cycle.
8. Report what was completed, what is still open, and what the next slice is.

Rules:
- Never re-plan completed items.
- Never skip test execution for implemented changes.
- Never defer doc sync to a separate session.
- If blockers are found (missing contracts, open decisions), report them and stop rather than guess.

Output after completion:
- What was implemented
- Test results
- Docs updated
- Remaining open items in this batch
- Planned file changes (before edits)
- Applied file changes (after edits)

Git close-out (required when edits were made):
1. Stage only the files changed for this task.
2. Commit with a clear summary of completed work.
3. Push to the current branch.
4. Report commit SHA and pushed branch in the final summary.
