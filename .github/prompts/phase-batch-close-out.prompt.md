---
description: "Close out a reviewed and QA-approved phase batch. Sync parent phase planning docs, deferments, implementation status, and batch-level handoff notes before final phase close-out."
name: "Phase Batch Close-Out"
argument-hint: "Phase and batch target, for example: Phase 2 Batch 11"
agent: "plan"
---
Close out the specified phase batch after review and manual QA approval.

Execution guardrails:
- Prefer direct file edits in the VS Code editor.
- Do not use bash or scripted bulk search/replace to rewrite documentation unless explicitly requested.
- Confirm whether this close-out session is read-only or writable before any edits or git operations.
- Before writing, verify branch/worktree context, dirty state, and whether this session owns the writable role for the current folder.
- If another same-folder session is the active writer, stay read-only, report what remains for close-out, and stop before edits, staging, or commit.
- Before writing, summarize intended file-by-file changes; after writing, summarize exactly what changed.

Do the following:
1. Confirm the target phase and batch and verify this batch has already passed `/phase-batch-review`.
2. Confirm manual QA or visual review status and record the result in the batch-level status trail.
3. Read the phase index, target batch note, parent phase planning note, and related development log sections.
4. Update batch implementation status and close-out notes in planning docs.
5. Sync batch-level scope changes, deliverable changes, deferments, and unresolved follow-ups into the parent phase planning docs.
6. Ensure deferred items are explicitly routed to the correct future batch, phase, or future-planning note.
7. Confirm this batch's section in phase-level close-out tracking is updated so final `/phase-close-out` can aggregate all batches cleanly.
8. If staging visual review happened on a non-main branch, confirm the approved work has been promoted to `main` and staging has been restored to `main` or immediately redeployed from promoted `main`.
9. If close-out changes were required, stage only scoped files, commit with a clear summary, and push to the current branch.
10. Report final batch close-out status, commit SHA, pushed branch, and remaining phase-level follow-up.

Output format:
- Close-out target
- Review and QA status
- Batch implementation status
- Batch-to-phase sync updates
- Deferred or follow-up items
- Docs updated
- Planned file changes (before edits)
- Applied file changes (after edits)

Rules:
- This is the only workflow step that should mark a phase batch complete.
- If review has not passed, stop and send the work back to `/phase-batch-review` or `/phase-batch-implementation`.
- If manual QA is still pending, record that explicitly and do not mark the batch complete.
- Keep phase-level final sign-off for `/phase-close-out`.