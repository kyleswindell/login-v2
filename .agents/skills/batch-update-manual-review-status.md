# Update Manual Review Status

Update the active batch after human manual review feedback.

## Scope
- `/docs/08-active/`
  - `review.md`
  - `checklist.md`
  - `notes.md`
  - `change-queue.md`
  - `/worklogs/`

## Goal
Convert manual review feedback into structured batch state updates and maintain the change queue lifecycle.

## Rules
- Do not modify `batch.md`
- Do not modify canonical docs or code
- Only update `/docs/08-active/`
- Treat human review feedback as source input
- Do not modify or delete existing worklog files
- Do not overwrite historical entries
- Separate:
  - new findings
  - confirmed fixes
  - deferred items

## Stop Conditions

Stop and ask for clarification if:

- the human review feedback is ambiguous about pass versus fail
- a referenced checklist item cannot be matched to a current top-level checklist item
- a finding cannot be mapped safely into the current change-queue lifecycle
- the feedback mixes approval and new-finding signals in a way that would require guessing the intended state transition
- the request is actually asking for implementation work rather than review-state mutation

## Execution

### 1. Update change queue

Update `change-queue.md` using the lifecycle sections:

- Ready To Implement
- In Progress
- Implemented Pending Review
- Blocked
- Deferred
- Passed Review
- Closed

Rules:
- Add new issues from review into `Ready To Implement`
- Move items from:
  - `Implemented Pending Review` → `Passed Review` if confirmed
  - `Implemented Pending Review` → back to `Ready To Implement` if failed
- Move items from `Passed Review` → `Closed` if no further action is required
- Move items to `Deferred` if out of scope
- Do NOT delete items; only move them between sections

---

### 2. Update review status

Update `review.md`:

- current status (`PARTIAL` or `FAIL`)
- list of open issues
- required fixes
- manual review results:
  - Visual: PASS / FAIL
  - Functional: PASS / FAIL

Do NOT set `PASS` unless all review items are resolved.

---

### 3. Update checklist (FINAL AUTHORITY)

- This agent is the ONLY one allowed to check items as complete
- Only operate on top-level items
- `Status:` must remain an implementation-state field only

For each reviewed item:
- If pass:
  - mark checkbox [x]
  - set Status: implemented
- If fail:
  - leave checkbox [ ]
  - set Status: implemented (pending manual review)

- Do NOT modify nested bullets
- Do NOT introduce additional checkboxes
- Do NOT use `passed review` or `requires updates (see change-queue)` as `Status:` values

---

### 4. Update notes

Update `notes.md` with:
- summary of review findings
- decisions made
- follow-up items for next work pass

---

### 5. Link to worklogs

- Do NOT edit worklog files
- Reference relevant worklog IDs in `notes.md` if needed for traceability

---

## Output

1. files updated  
2. change queue updated  
3. checklist items confirmed  
4. review status updated  
5. remaining open issues  
6. whether another work pass is required
