# Integrate Work Batch Branch

Integrate one worker branch into the canonical active batch state and shared review surface.

## Required Inputs

- `/docs/08-active/batch.md`
- `/docs/08-active/checklist.md`
- `/docs/08-active/change-queue.md`
- `/docs/08-active/review.md`
- `/docs/08-active/notes.md`
- `/docs/08-active/worklogs/index.md`
- worker handoff file under `.agents/batch-branch-handoffs/`

## Rules

- This skill is the singleton writer for `/docs/08-active/` in branch-based parallel mode
- Integrate one queue item at a time
- Prefer running in the integrator project thread on the local `main` worktree
- Review the worker handoff before merging
- Update active workspace state only after the worker changes are actually integrated
- Own push, staging deploy, and move to `Implemented Pending Review` when reviewability requires deployment

## Concurrency Preflight

Before writing:

- confirm this session owns `/docs/08-active/`
- confirm this session is the integrator thread/session rather than a worker thread
- confirm no other integrator is active
- confirm the worker branch head SHA matches the handoff artifact

Stop if:

- `/docs/08-active/` ownership is unclear
- the current session is a worker-thread/worktree context instead of the integrator lane
- the worker handoff is incomplete
- the integration target or merge base is ambiguous

## Execution

1. Read the worker handoff artifact.
2. Merge or cherry-pick the worker branch commit(s).
3. Update:
   - `change-queue.md`
   - `review.md`
   - `notes.md`
   - `checklist.md` status lines when needed
   - `worklogs/index.md`
   - a new active worklog under `/docs/08-active/worklogs/`
4. Push and deploy when the integrated result is review-ready and requires staging.
5. Mark the handoff artifact `integrated` or `superseded`.

## Output

1. worker branch integrated
2. active workspace synchronized
3. review surface publication status recorded
