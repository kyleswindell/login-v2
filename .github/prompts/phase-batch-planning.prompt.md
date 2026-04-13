---
description: "Organize a finalized phase plan into dependency-ordered implementation batches with scoped deliverables, contracts, and sequencing. Use when a phase plan exists but batches are not yet defined or need reordering."
name: "Phase Batch Planning"
argument-hint: "Phase to organize, for example: Phase 3"
agent: "plan"
---
Organize the specified phase into dependency-ordered implementation batches and leave each batch implementation-ready whenever possible.

Execution guardrails:
- Prefer direct file edits in the VS Code editor.
- Do not use bash or scripted bulk search/replace to rewrite documentation unless explicitly requested.
- Keep edits minimal and scoped to the target phase planning docs, linked canonical docs, and relevant indexes.
- Shared-folder planning sessions default to read-only when another writable session is already active.
- Before editing, verify whether this planning session is read-only or writable, along with branch/worktree context and dirty state.
- If writable planning work must run in parallel with another writer, move it to a separate branch and separate worktree first.
- Before writing, summarize intended file-by-file changes; after writing, summarize exactly what changed.

Do the following:
1. Read the phase index, phase planning notes, and all linked canonical docs.
2. Identify all deliverables and required contracts from the phase goal.
3. Map dependency relationships between deliverables to determine safe sequencing.
4. Define or confirm batch boundaries (what must go first, what can go in parallel, what must come last).
5. For each batch, confirm: scope, required contracts before build, concrete code touchpoints, minimum test expectations, exit criteria, and doc sync requirements.
6. Decide implementation readiness for each batch (ready or not ready) and list exact missing details if not ready.
7. Flag any decisions still open that would block any batch from starting.
8. Confirm batch notes exist or identify which need to be created.

Readiness rule:
- Target outcome is that phase-batch-planning should leave each active or near-term batch ready for direct `/phase-batch-implementation`.
- Recommend `/phase-batch-development` only when a batch still lacks concrete implementation detail after planning, and list the specific gaps.

Output format:
- Phase Goal Summary
- Dependency Map
- Proposed Batch Sequence (with rationale)
- Per-Batch Scope And Contracts
- Per-Batch Implementation Readiness (ready / not ready with reasons)
- Open Decisions Blocking Implementation
- Batch Notes Status (exists / needs creation)

Change Summary:
- Planned file changes (before edits)
- Applied file changes (after edits)

Git close-out (required when edits were made):
1. Stage only the files changed for this task.
2. Commit with a clear summary of completed work.
3. Push to the current branch.
4. Report commit SHA and pushed branch in the final summary.
