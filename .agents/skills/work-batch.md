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

## Concurrency Preflight

Before writing:

- confirm this session is the intended writable owner of the current batch workspace
- confirm current branch and worktree path
- confirm another writable session is not already executing `batch-start` or `work-batch` for the same `/docs/08-active/` state
- check `.agents/session-scope-claims.json` for conflicting advisory claims when available

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
- Once base batch implementation work is complete, process `change-queue.md` items in `Ready To Implement`

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
- move it to `In Progress` when work begins
- attempt implementation
- update it to one of:
  - `Implemented Pending Review`
  - `Blocked`
  - `Deferred`
- use `In Progress` only if work started but did not complete in this pass
- record outcome in the current worklog

Do NOT set any item to:
- `Passed Review`
- `Closed`

If new issues are discovered:
- add them to the appropriate section in `change-queue.md`

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

If visual review is required:
- commit must be created
- changes must be pushed
- deployment must be completed

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
