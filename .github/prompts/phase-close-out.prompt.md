---
description: "Close out a completed phase batch or full phase after review and manual QA. Sync implementation status, deferments, indexes, and final documentation state."
name: "Phase Close-Out"
argument-hint: "Phase target or phase plus batch, for example: Phase 2 Batch 11 or Phase 2"
agent: "plan"
---
Close out the specified phase batch or full phase.

Execution guardrails:
- Prefer direct file edits in the VS Code editor.
- Do not use bash or scripted bulk search/replace to rewrite documentation unless explicitly requested.
- Confirm whether this close-out session is read-only or writable before any edits or git operations.
- Before writing, verify branch/worktree context, dirty state, and whether this session owns the writable role for the current folder.
- If another same-folder session is the active writer, stay read-only, report what remains for close-out, and stop before edits, staging, or commit.
- Before writing, summarize intended file-by-file changes; after writing, summarize exactly what changed.

Do the following:
1. Confirm whether the target is a specific batch or an entire phase.
2. Read the target batch note or phase index, linked canonical docs, development log, and relevant indexes.
3. Confirm review passed and manual QA or visual review has been completed, or explicitly record the remaining exception if close-out cannot proceed.
4. Verify implementation status sections reflect reality: complete, in progress, deferred, or blocked.
5. Move any newly discovered out-of-scope or deferred work into the correct future batch, phase, or future-planning note.
6. Update planning notes, canonical owner docs, development log, and indexes so the target's final status is unambiguous.
7. If close-out changes were required, stage only the scoped files, commit with a clear summary, and push to the current branch.
8. Report the final close-out state, commit SHA, pushed branch, and any remaining follow-up work.

Output format:
- Close-out target
- Review and QA status
- Final implementation status
- Deferred or follow-up items
- Docs updated
- Planned file changes (before edits)
- Applied file changes (after edits)

Rules:
- This is the only workflow step that should mark a phase batch or full phase complete.
- If review has not passed, stop and send the work back to `/phase-batch-review` or `/phase-batch-implementation`.
- If manual QA is still pending, record that explicitly and do not mark the target complete.