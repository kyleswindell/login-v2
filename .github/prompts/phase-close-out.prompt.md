---
description: "Close out a full phase after batch close-outs are complete. Sync final implementation status, deferments, canonical docs, indexes, and phase-level documentation state."
name: "Phase Close-Out"
argument-hint: "Phase target, for example: Phase 2"
agent: "plan"
---
Close out the specified full phase.

Execution guardrails:
- Prefer direct file edits in the VS Code editor.
- Do not use bash or scripted bulk search/replace to rewrite documentation unless explicitly requested.
- Confirm whether this close-out session is read-only or writable before any edits or git operations.
- Before writing, verify branch/worktree context, dirty state, and whether this session owns the writable role for the current folder.
- If another same-folder session is the active writer, stay read-only, report what remains for close-out, and stop before edits, staging, or commit.
- Before writing, summarize intended file-by-file changes; after writing, summarize exactly what changed.

Do the following:
1. Confirm the target phase and verify all intended phase batches have passed `/phase-batch-close-out` or are explicitly deferred.
2. Read the phase index, phase planning owner notes, canonical owner docs, development log, and relevant indexes.
3. Confirm phase-level review and QA posture is complete enough for final sign-off, or explicitly record remaining exceptions.
4. Verify phase implementation status sections reflect reality: complete, partially complete, deferred-forward, or blocked.
5. Aggregate and route any remaining out-of-scope or deferred work into the correct future phase or future-planning note.
6. Update phase planning notes, canonical owner docs, development log, and indexes so final phase status is unambiguous.
7. If close-out changes were required, stage only scoped files, commit with a clear summary, and push to the current branch.
8. Report final phase close-out status, commit SHA, pushed branch, and remaining cross-phase follow-up.

Output format:
- Close-out target
- Review and QA status
- Final phase implementation status
- Deferred or follow-up items
- Docs updated
- Planned file changes (before edits)
- Applied file changes (after edits)

Rules:
- This is the only workflow step that should mark a full phase complete.
- If required batches are not yet closed out, stop and run `/phase-batch-close-out` first for the missing batches.
- If manual QA is still pending at phase level, record that explicitly and do not mark the phase complete.