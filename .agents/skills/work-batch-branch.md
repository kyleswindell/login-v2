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
- Prefer a dedicated Codex app project thread in Worktree mode when available; otherwise use the assigned dedicated worktree directly, including an explicitly bound spawned child-agent fallback when needed
- Do NOT update `/docs/08-active/`
- Do NOT move queue items between sections
- Update canonical code/docs required by the queue item
- Record handoff details in `.agents/batch-branch-handoffs/`
- Keep commits scoped to one queue item and one concern
- Keep worker worktrees lightweight: do not run full Docker Compose stacks, `composer install`, `npm install`, or `npm ci` in the worker lane unless the queue item genuinely requires local runtime verification there
- Prefer scoped verification that uses already-available dependencies, static checks, targeted file inspection, or integrator/staging validation after merge when full dependency installation would only create disposable worker artifacts

## Concurrency Preflight

Before writing:

- confirm current branch and worktree match the assigned queue item
- confirm this session is the dedicated worker thread/session for that branch/worktree, or a spawned child agent explicitly bound to that same assigned branch/worktree
- confirm this branch is not the shared integrator branch
- confirm another worker is not already using the same queue-item branch
- check `.agents/session-scope-claims.json` for overlapping writable claims when needed

Stop if:

- the queue item assignment is unclear
- the branch/worktree is not dedicated to this queue item
- the current session is still in the integrator thread or in a shared-folder thread without explicit worker worktree isolation
- the session would need to update `/docs/08-active/` directly

## Execution

1. Read the active batch context and targeted queue item.
2. Implement only the targeted queue item.
3. Run scoped verification.
   - Do not start `docker compose up` in a worker lane by default.
   - If dependencies are missing and full verification would create Docker volumes, `public/build/`, or large `storage/` artifacts in a disposable worker lane, either use a lighter verification path or record the limitation for the integrator.
   - If full worker-local dependency installation or Compose usage is necessary, record that in the handoff so cleanup is intentional.
4. Commit scoped changes on the worker branch.
5. Update `.agents/batch-branch-handoffs/<queue-id>.md` with:
   - branch
   - worktree
   - head SHA
   - files changed
   - tests run
   - generated dependency/runtime artifacts, if any
   - docs sync status
   - merge notes
   - status `ready_for_integration`

## Output

1. queue item implemented on worker branch
2. scoped commit(s) created
3. handoff artifact updated for integrator use
