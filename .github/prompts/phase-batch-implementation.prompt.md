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
- Confirm whether the session is operating in writable mode or read-only mode before any edits.
- Before writing, verify branch/worktree context, dirty state, and whether another writable same-folder session is already active.
- If another same-folder session is already the writer, stay read-only and stop before edits unless this task is moved into a separate branch and separate worktree.
- Before writing, summarize intended file-by-file changes; after writing, summarize exactly what changed.

Do the following:
1. Confirm current operating mode and whether this session is allowed to write in the current folder.
2. Read the phase index and confirm which batch is currently active.
3. Read the batch note, the phase planning parent, and linked canonical owner docs.
4. Confirm current repo state: what is done, what is uncommitted, what is next.
5. Identify the next dependency-safe implementation slice — do not re-plan or re-implement completed items.
6. Implement code changes (routes, requests, services, policies, migrations, views, components as required).
7. Run relevant tests and confirm passing.
8. Sync documentation updates in the same work cycle.
9. Report what was completed, what is still open, and what the next slice is.

Rules:
- Never re-plan completed items.
- Never skip test execution for implemented changes.
- Never defer doc sync to a separate session.
- Never begin same-folder concurrent writes when another writable session is already active.
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
