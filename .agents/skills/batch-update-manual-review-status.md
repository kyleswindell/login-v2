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
- Treat clear, mappable manual-review feedback as sufficient authorization to execute this workflow; do not pause just to confirm that review-state mutation should happen
- Treat `Implemented Pending Review` as a deployed, reviewable state when deployment is required for the relevant surface
- Treat local development as a valid review surface only when the reviewer inspected the same working tree; accepted local-review work must already have a scoped implementation commit before moving it to `Passed Review`
- Keep exploratory review discussion in chat until it can be normalized safely into queue language
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
- the requested review-state change depends on an item that is known to be undeployed on the required review surface
- the requested pass transition depends on locally reviewed implementation that is still uncommitted
- the update would require a new decision about scope or wording that the user has not actually made yet
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
- Classify each review finding before moving queue items:
  - confirmation of an existing implemented item
  - failure of an existing implemented item
  - new finding
- Treat a new adjacent finding as a new queue item by default
- Normalize exploratory or conversational review input into concise implementation-ready queue language before writing it into `change-queue.md`
- Do not paste long chat commentary verbatim into the queue
- Preserve existing `ID:` lines for any item that is being moved rather than replaced
- Move items from:
  - `Implemented Pending Review` → `Passed Review` if confirmed
  - `Implemented Pending Review` → back to `Ready To Implement` only if the review evidence directly shows that same item's scoped implemented outcome failed
- Move items from `Passed Review` → `Closed` if no further action is required
- Move items to `Deferred` if out of scope
- If review finds an uncovered parallel path or adjacent gap on the same broad surface, keep the implemented item in `Implemented Pending Review` and add a separate `Ready To Implement` follow-up item
- Do not process an undeployed item as `Implemented Pending Review`; if the deploy gap is known, stop for clarification or correct the queue state only when the request explicitly asks for that bookkeeping correction
- Assign the next sequential queue ID in the current batch to each truly new queue item
- Add `Follow-up To:` or `Path Coverage:` continuation lines when they materially improve traceability for a new finding
- Do NOT delete items; only move them between sections
- If the changed queue state affects the temporary active-batch UI Reference review overlay, synchronize the derived runtime manifest in the same workflow step so runtime review IDs are regenerated from the new queue state immediately

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
