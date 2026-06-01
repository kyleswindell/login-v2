# Work Batch Branch

Implement one assigned change-queue item on a dedicated branch/worktree without modifying `/docs/08-active/`.

## Required Inputs

- `/docs/08-active/batch.md`
- `/docs/08-active/checklist.md`
- `/docs/08-active/change-queue.md`
- targeted queue item ID
- `.agents/batch-branch-handoffs/<queue-id>.md`

## Rules

- Work on one queue item only
- Use a dedicated branch and dedicated worktree
- Do NOT update `/docs/08-active/`
- Do NOT move queue items between sections
- Update canonical code/docs required by the queue item
- Record handoff details in `.agents/batch-branch-handoffs/`
- Keep commits scoped to one queue item and one concern

## Concurrency Preflight

Before writing:

- confirm current branch and worktree match the assigned queue item
- confirm this branch is not the shared integrator branch
- confirm another worker is not already using the same queue-item branch
- check `.agents/session-scope-claims.json` for overlapping writable claims when needed

Stop if:

- the queue item assignment is unclear
- the branch/worktree is not dedicated to this queue item
- the session would need to update `/docs/08-active/` directly

## Execution

1. Read the active batch context and targeted queue item.
2. Implement only the targeted queue item.
3. Run scoped verification.
4. Commit scoped changes on the worker branch.
5. Update `.agents/batch-branch-handoffs/<queue-id>.md` with:
   - branch
   - worktree
   - head SHA
   - files changed
   - tests run
   - docs sync status
   - merge notes
   - status `ready_for_integration`

## Output

1. queue item implemented on worker branch
2. scoped commit(s) created
3. handoff artifact updated for integrator use
