# Work Batch

Execute the currently loaded batch in `/docs/08-active/`.

## Required Inputs

- `/docs/08-active/batch.md`
- `/docs/08-active/checklist.md`
- `/docs/08-active/change-queue.md`
- `/docs/08-active/review.md`
- `/docs/08-active/notes.md`
- `/docs/08-active/worklogs/index.md`

## Rules

- Work only within the scope defined in `batch.md`
- Do NOT expand scope
- Do NOT introduce new rules, variants, tokens, or feature logic unless the batch explicitly allows it
- Write implementation changes only to canonical docs/code paths required by the batch
- Maintain branch responsibility boundaries
- If a required dependency is missing or ambiguous, STOP and record it in `notes.md`
- Do NOT mark checklist items as complete
- Do NOT archive or reset `/docs/08-active/`
- Follow `docs/10-runbooks/git-batch-commit-workflow.md` for all commits
- Follow `docs/10-runbooks/deployment.md` and `docs/10-runbooks/staging-deployment.md` for staging deployment behavior when manual review output is required
- Base batch deliverables are tracked in `batch.md` and `checklist.md`
- `change-queue.md` is reserved for review findings, follow-up items, and blocked or discovered work
- If the batch needs parallel queue-item implementation across multiple writers, stop and use the branch-based `work-batch-branch` plus `integrate-work-batch-branch` path instead of turning this shared active workspace into a multi-writer flow
- If the batch uses the temporary active-batch UI Reference review overlay, keep the derived runtime manifest synchronized with the current queue state before the pass is treated as review-ready

## Concurrency Preflight

Before writing:

- confirm this session is the intended writable owner of the current batch workspace
- confirm current branch and worktree path
- confirm another writable session is not already executing `batch-start` or `work-batch` for the same `/docs/08-active/` state
- check `.agents/session-scope-claims.json` for conflicting advisory claims when available
- treat active batch execution ownership as ownership of the whole `/docs/08-active/` workspace rather than of an individual queue item

Stop if:
- writable ownership of `/docs/08-active/` is unclear
- another session already owns the same active batch scope
- the current worktree/branch context is inconsistent with the intended writable task

---

## Execution

### 1. Read active batch state
- Read `batch.md`
- Read `checklist.md`
- Read `change-queue.md`
- Read `review.md`
- Read `notes.md`
- Read `/docs/08-active/worklogs/index.md`
- Use them as the source of truth for scope, deliverables, and queued implementation work

---

### 2. Execute only in-scope work
- Complete the batch incrementally
- Do not start unrelated cleanup
- Do not fix adjacent issues unless they block the batch
- If base batch implementation work remains, complete that before processing `change-queue.md`
- If `change-queue.md` already contains an unfinished `In Progress` item, continue or explicitly reclassify that item before selecting a new `Ready To Implement` item
- Once base batch implementation work is complete, process `change-queue.md` items in `Ready To Implement`
- Treat `In Progress` as the explicit claim marker for the currently targeted queue item
- If the pass builds Tier 2 patterns or feature UI from Tier 1, complete a Tier 1 consumption preflight before coding:
  - identify the exact Tier 1 building blocks being consumed
  - name whether each one is a `Blade component`, `Class/markup contract`, or `Hybrid`
  - confirm the canonical entry point is explicit in current standards/reference material
  - stop and record a blocker if the needed Tier 1 item is represented only by demo-state markup or otherwise behaves like a `Missing abstraction`
- For a targeted shared UI/system surface, identify the relevant render/update paths before implementing
  - examples: server-rendered markup, realtime/client-injected markup, toast/overlay variants, related full-index surfaces
  - do not assume one path represents the whole shared surface unless the batch docs already make that boundary explicit

---

### 3. Create a new worklog (REQUIRED)

Create a new file under:

`/docs/08-active/worklogs/worklog-<phase-number>-<batch-letter>-####.md`

Determine the next ID from `/docs/08-active/worklogs/index.md`:
- if entries exist, increment the highest existing ID for the current batch
- if no entries exist, start at `0001`

Example:
`worklog-2-A-0001.md`

The worklog must include:
- Prompt Summary
- Scope
- Files Changed
- Work Completed
- Checklist Impact
- Change Queue Impact
- Issues Found
- Deferred Items
- Commit / Deploy Status
- Notes

Do NOT overwrite or reuse previous worklogs.

---

### 4. Update worklog index (REQUIRED)

Update:

`/docs/08-active/worklogs/index.md`

Add a new row for this pass including:
- ID
- Date
- Pass Goal
- Status:
  - `IN_PROGRESS`
  - `PARTIAL`
  - `READY_FOR_REVIEW`
  - `BLOCKED`
- Commit status (`Yes` / `No`)
- Deploy status (`Yes` / `No`)
- Optional note

Do NOT modify previous rows except to correct factual errors.

---

### 5. Record findings

Update `notes.md` with:
- decisions made
- blockers
- risks
- follow-up items outside current pass scope

---

### 6. Update checklist (ANNOTATION ONLY)

- Do NOT check items as complete
- Only update top-level items
- Set Status to one of:
  - implemented (pending manual review)
  - blocked (with reason)
  - deferred
- Do NOT add or modify nested checklist items
- Do NOT introduce additional checkboxes

---

### 7. Process change queue items

If base batch implementation is complete, process `change-queue.md` items in `Ready To Implement`.

For each targeted item:
- if a prior pass already left that item in `In Progress`, continue or explicitly reclassify it before touching a new queue item
- move it to `In Progress` before implementation edits tied to that item begin so the queue records the active claim immediately
- attempt implementation
- update it to one of:
  - `Implemented Pending Review`
  - `Blocked`
  - `Deferred`
- finish or explicitly park that claimed item before moving any additional `Ready To Implement` item into `In Progress`
- use `In Progress` only if work started but did not complete in this pass
- record outcome in the current worklog
- if a parallel render/update path for the same targeted surface is discovered and not fixed in the same pass, add a separate follow-up queue item before calling the pass review-ready
- use `Implemented Pending Review` only when the item is actually reviewable at the end of the pass; if manual review depends on staging or another deployed surface, that means commit, push, and the required deploy all completed successfully
- if implementation is complete but the required deploy cannot be completed in the same pass, do not leave the item in `Implemented Pending Review`; record the deploy gap in the worklog/review state and use `Blocked` when the pass ends with a real deployment blocker
- preserve existing `ID:` lines when moving targeted items between queue sections
- preserve existing queue metadata lines such as `Scope:`, `Path Coverage:`, `Follow-up To:`, and `Supersedes:` when moving items
- assign the next sequential queue ID in the current batch if a new active item is created and no stable ID already exists
- add or update `Implemented in:` with the current worklog ID when that improves traceability for the targeted item
- if the targeted item affects the temporary active-batch UI Reference review overlay, synchronize the derived runtime manifest after queue-state edits and before review-ready verification or publication

Do NOT set any item to:
- `Passed Review`
- `Closed`

If new issues are discovered:
- add them to the appropriate section in `change-queue.md`
- keep new adjacent findings separate from already-implemented targeted items unless the new finding directly proves the targeted item's own outcome failed
- write new findings as concise implementation-ready queue items, not as copied chat fragments or long exploratory notes
- include an `ID:` line on each new active queue item

Do NOT remove existing items unless they were explicitly resolved in this pass and their status is updated accordingly.

---

### 8. Update review state (LIMITED)

Update `review.md` only to reflect:
- current status (typically `PARTIAL`)
- newly discovered issues

Do NOT:
- mark `PASS`
- clear issues
- finalize review state

---

### 9. Commit and deploy when appropriate

If the work pass:
- includes visual or interaction changes requiring manual review, AND
- is complete enough to be reviewed

then:
- stage only scoped files
- commit using `docs/10-runbooks/git-batch-commit-workflow.md`
- push the commit
- deploy using the canonical staging deployment workflow in `docs/10-runbooks/staging-deployment.md`
- record commit and deployment details in the worklog
- move targeted queue items to `Implemented Pending Review` only after the deploy succeeds when that deploy is required for review

Deployment preconditions:
- the pass is actually reviewable
- the required deployment path is available from the current execution environment
- if the deployment path or privileges are unavailable, STOP after push and report the missing precondition instead of improvising a deploy path

Do NOT:
- include unrelated files
- mix concerns in one commit
- deploy incomplete or blocked work

---

## Stop Conditions

STOP and report if:
- scope is ambiguous
- required standards/contracts are missing
- implementation would require new rules or tokens
- `batch.md` and `checklist.md` conflict

---

## Completion Criteria

A work pass is complete only when:
- in-scope tasks for the pass are finished
- a new worklog file is created and populated
- `worklogs/index.md` is updated
- `notes.md` reflects findings
- `checklist.md` is annotated
- targeted `change-queue.md` items are updated to an implementation outcome state
- any queue item claimed in this pass was moved into `In Progress` before implementation work began
- those queue outcomes match the real reviewability state of the pass, including deploy status when review depends on a deployed surface

If visual review is required:
- commit must be created
- changes must be pushed
- deployment must be completed
- targeted queue items cannot remain in `Implemented Pending Review` unless that deployment completed

---

## Output

1. files changed  
2. worklog file created  
3. worklog index updated  
4. progress made  
5. checklist annotations applied  
6. change queue items updated  
7. blockers or risks  
8. commit + deployment status  
9. whether another work pass is required or manual review should proceed
