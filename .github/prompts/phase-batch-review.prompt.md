---
description: "Review a completed phase batch against the batch note, canonical docs, tests, and current diff. If review-clean, commit and push; otherwise report findings and stop."
name: "Phase Batch Review"
argument-hint: "Phase and batch target, or 'active', for example: Phase 2 Batch 11"
agent: "agent"
---
Review the specified phase batch before sign-off.

Execution guardrails:
- Prefer direct file edits in the VS Code editor for any review fixes or doc sync corrections.
- Do not use bash or scripted bulk search/replace to rewrite files unless explicitly requested.
- Confirm whether this review session is read-only or writable before any edits or git operations.
- Before writing, verify branch/worktree context, dirty state, and whether this session owns the writable role for the current folder.
- If another same-folder session is the active writer, stay read-only, report findings, and stop before edits, staging, or commit.
- Before writing, summarize intended file-by-file changes; after writing, summarize exactly what changed.

Do the following:
1. Confirm current operating mode and whether this review session is allowed to write in the current folder.
2. Read the phase index, target batch note, parent phase plan, and linked canonical owner docs.
3. Inspect the current diff or unpushed commit scope for the target batch.
4. Confirm that implementation matches the documented deliverables, constraints, and explicit exclusions.
5. Run the relevant tests or confirm the existing targeted test evidence is still valid.
6. Check that planning, canonical, and development-log docs were updated where required.
7. If findings remain, report them ordered by severity and stop before commit.
8. If the batch is review-clean, stage only the scoped files, commit with a clear summary, and push to the current branch.
9. If rendered UI review is required, report the exact branch that should be deployed to staging and stop short of close-out until manual QA is complete.
10. Report review outcome, commit SHA, pushed branch, and any remaining follow-up needed before close-out.

Output format:
- Findings
- Test results
- Doc sync status
- Review decision (blocked / approved for staging review / approved for close-out)
- Planned file changes (before edits)
- Applied file changes (after edits)

Rules:
- Findings come first when problems are found.
- Do not approve or commit mixed-scope changes; narrow the scope or stop.
- Do not mark the batch complete from review alone.
- Close-out still requires `/phase-batch-close-out` after review passes and manual QA is complete.