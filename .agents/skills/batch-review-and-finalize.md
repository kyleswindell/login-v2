# Review and Finalize Batch

Review the active batch in `/docs/08-active/`, determine final status, and perform close-out actions if the batch passes all gates.

## Scope
- `/docs/08-active/`
  - `batch.md`
  - `checklist.md`
  - `notes.md`
  - `review.md`
  - `change-queue.md`
  - `/worklogs/`

Do NOT modify canonical docs or code during this step.  
Ignore `/docs/_archive/`.

---

## Goal
- Validate that the batch is complete, correct, and ready for closure
- Update `review.md` to reflect final truth
- Enforce manual review gates
- Archive and reset the active workspace if and only if the batch passes

---

## Rules
- Do NOT expand scope
- Do NOT introduce new work
- Do NOT silently fix issues
- Use `checklist.md`, `review.md`, and `change-queue.md` as source of truth
- Treat any checklist item not in `passed review` or approved `deferred` state as a blocker
- Only finalize when manual review gates pass
- Do NOT modify or rewrite worklog files; they are immutable history

---

## Steps

### 1. Validate checklist completion
- Confirm each required checklist item is in one of:
  - `passed review`
  - `deferred` (with explicit approval recorded)
- If any item is still:
  - not implemented
  - implemented
  - implemented (pending agent review)
  - implemented (pending manual review)
  - blocked
  then the batch cannot pass

---

### 2. Validate change queue state
- Read `change-queue.md`
- Confirm no active items remain in:
  - `Ready To Implement`
  - `In Progress`
  - `Implemented Pending Review`
  - `Blocked`
- Remaining items may only be in:
  - `Deferred`
  - `Passed Review`
  - `Closed`

If active items remain -> batch cannot pass

---

### 3. Validate review state
- Read `review.md`
- Confirm:
  - no unresolved issues
  - no required fixes remain
  - no blockers recorded in `notes.md`

If issues remain -> status must be `PARTIAL` or `FAIL`

---

### 4. Validate manual review gates

Manual gates must be confirmed:

- Visual: PASS  
- Functional: PASS  

If either is not PASS -> batch cannot be finalized

---

### 5. Determine final status

Set in `review.md`:

- PASS -> all conditions met
- PARTIAL -> validation incomplete or issues remain
- FAIL -> incorrect implementation or major issues

Update:
- Status
- Issues (if any)
- Required Fixes (if any)
- Manual Review section

---

### 6. Final commit (if PASS)

If status = PASS:

- Stage only scoped `/docs/08-active/` files
- Commit:
  - `chore: finalize <batch name>`
- Push changes

Do NOT include unrelated files.

---

### 7. Archive batch (if PASS)

Move `/docs/08-active/` contents to:

/docs/11-ai/_archive/batches/<date-name>/

Preserve:
- `batch.md`
- `checklist.md`
- `notes.md`
- `review.md`
- `change-queue.md`
- `/worklogs/`

Archive must be read-only and never reused as working input.

---

### 8. Reset active workspace (if PASS)

After archiving:

- clear `notes.md`
- clear `review.md`
- clear `change-queue.md`
- reset `checklist.md`
- clear or replace `batch.md`
- remove all worklog pass files from `/docs/08-active/worklogs/`
- reset `/docs/08-active/worklogs/index.md`

Ensure `/docs/08-active/` contains no residual data from the completed batch.

---

## Stop Conditions

Do NOT finalize if:
- checklist is incomplete
- change queue contains active items
- manual review is not PASS
- unresolved issues exist
- implementation does not match scope

---

## Output

1. final status (PASS / PARTIAL / FAIL)  
2. checklist completion status  
3. change queue status  
4. manual review status  
5. whether commit was performed  
6. whether archive was created  
7. whether `/docs/08-active/` was reset  
8. remaining issues (if not PASS)
