# Start Batch

Initialize the active batch workspace in `/docs/08-active/` for a single new batch.

## Scope
- `/docs/08-active/`
  - `batch.md`
  - `checklist.md`
  - `notes.md`
  - `review.md`
  - `change-queue.md`
  - `/worklogs/`

Do NOT modify canonical docs outside `/docs/08-active/`.
Ignore `/docs/_archive/`.

---

## Goal
- Load one batch into the active workspace
- Reset active workspace files to clean batch-start state
- Initialize the worklog system
- Prepare the batch for `work-batch`

---

## Rules
- Initialize one batch only
- Do NOT perform implementation work
- Do NOT perform review or finalization work
- Do NOT expand scope beyond the selected batch
- Treat the source batch doc as the authority for scope and deliverables
- Keep `/docs/08-active/` aligned to the canonical workspace structure
- Reset active state before work begins so no prior batch residue remains
- Base batch deliverables must remain tracked in `batch.md` and `checklist.md`
- `change-queue.md` is reserved for review findings, follow-up items, and blocked/discovered work
- Do NOT create queue items from batch scope or deliverables during batch start
- If later implementation needs parallel worker branches, that branch-based execution may begin only after this singleton batch-start completes and an integrator owns the initialized `/docs/08-active/` workspace

## Concurrency Preflight

Before writing:

- confirm this session is the only writable owner of the shared `/docs/08-active/` workspace
- confirm another `batch-start` or `work-batch` session is not already active elsewhere
- confirm current branch and worktree path
- check `.agents/session-scope-claims.json` for conflicting advisory claims when available

Stop if:
- another writable session already owns the active batch workspace
- the current worktree/branch ownership is unclear
- the session is not allowed to take singleton ownership of `/docs/08-active/`

---

## Steps

### 1. Load the target batch
- Read the selected canonical batch planning doc
- Extract:
  - batch name
  - scope
  - out-of-scope
  - deliverables
  - validation surface
- Determine and write batch metadata:
  - phase number
  - batch letter
  - worklog prefix
- STOP if the batch source is ambiguous or spans multiple concerns

---

### 2. Reset the active workspace
- Clear prior active batch state from:
  - `batch.md`
  - `notes.md`
  - `review.md`
  - `change-queue.md`
- Reset `checklist.md` to the selected batch checklist only
- Clear prior work pass files from `/docs/08-active/worklogs/`
- Reset `/docs/08-active/worklogs/index.md`

Do NOT retain history in `/docs/08-active/`.

---

### 3. Initialize `batch.md`
- Write the loaded batch definition into `batch.md`
- Include:
  - batch name
  - batch metadata
  - objective
  - in-scope items
  - out-of-scope items
  - deliverables
  - validation surface

Keep `batch.md` limited to current-batch execution context only.

---

### 4. Initialize `checklist.md`
- Populate `checklist.md` from the canonical checklist
- Normalize to dual-state model:
  - Only top-level items have:
    - a checkbox
    - a `Status:` line
  - All nested items must be plain bullets (no checkboxes, no Status lines)
- Initialize all top-level items to:
  - [ ] (unchecked)
  - Status: not implemented
- Do NOT pre-mark any item as complete
- Do NOT create nested checkboxes

---

### 5. Initialize review state files
- Set `notes.md` to an empty current-batch notes state
- Set `change-queue.md` to the empty queue template with sections:
  - `Ready To Implement`
  - `In Progress`
  - `Implemented Pending Review`
  - `Blocked`
  - `Deferred`
  - `Passed Review`
  - `Closed`
- Add a short introduction block that explains:
  - the queue is agent-managed and implementation-ready, not a scratchpad
  - exploratory review discussion stays in chat until normalized
  - active queue items use stable IDs in the format `P<phase>-<batch>-CQ-###`
  - `In Progress` marks the queue item currently claimed by the writable `work-batch` owner
  - an unfinished `In Progress` item should be continued or explicitly reclassified before a new `Ready To Implement` item is claimed
- Future queue items should follow the documented minimal format:
  - one concise actionable bullet
  - a stable `ID:` line for active items
  - optional continuation lines such as `Iteration:`, `Scope:`, `Path Coverage:`, `Implemented in:`, `Follow-up To:`, and `Supersedes:` when they improve traceability
- Do NOT preload exploratory commentary or batch-scope prose into the queue template
- Set `review.md` to an initial batch review state that is not finalized

Initial review state must make clear:
- no manual review has been completed
- no final status has been earned

---

### 6. Initialize worklog system
- Ensure `/docs/08-active/worklogs/` exists
- Ensure `/docs/08-active/worklogs/index.md` exists
- Reset `index.md` to the empty current-batch index template
- Do NOT create any worklog files during batch start

---

### 7. Validate workspace readiness
- Confirm `/docs/08-active/` contains only the current batch state
- Confirm `/docs/08-active/worklogs/` contains:
  - `index.md`
  - no prior work pass files
- Confirm `change-queue.md` is empty and contains no active items
- Confirm the workspace is ready for `work-batch`

---

## Stop Conditions

STOP and report if:
- the target batch doc is missing
- batch scope is ambiguous
- checklist source is incomplete
- active workspace cannot be reset cleanly

---

## Output

1. batch loaded
2. active workspace reset status
3. files initialized
4. checklist loaded status
5. change queue initialized status
6. worklogs initialized status
7. whether the batch is ready for `work-batch`
