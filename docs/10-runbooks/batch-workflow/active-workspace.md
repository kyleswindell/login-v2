# Batch Workflow - Active Workspace

[Back to Batch Workflow](../batch-workflow.md)

## Active Workspace

The active batch workspace is:

`/docs/08-active/`

This directory represents the current batch state and must be used for all batch-related tracking.

Concurrency rule:

- `/docs/08-active/` is a singleton active workspace
- concurrent `batch-start` or `work-batch` execution is not supported under the current model, even when separate Git worktrees exist
- branch-based parallel implementation is allowed only when a single integrator owns `/docs/08-active/` and worker branches stay out of the active workspace
- use separate worktrees for other writable tasks only when those tasks do not require shared `/docs/08-active/` ownership at the same time

### Structure

/docs/08-active/
  batch.md
  checklist.md
  notes.md
  review.md
  change-queue.md
  /worklogs/
    index.md
    worklog-<phase>-<batch>-####.md

---

## File Responsibilities

### batch.md
Defines:
- batch name
- scope
- out-of-scope
- deliverables
- validation surface

Updated by:
- `batch-start` only

---

### checklist.md
Tracks:
- implementation coverage
- review state

Rules:
- each checklist item uses the dual-state model:
  - checkbox = review completion only
  - `Status:` line = implementation state only
- `work-batch` sets `Status` only
- `integrate-work-batch-branch` may set `Status` only when syncing worker-branch implementation into the active workspace
- `batch-update-manual-review-status` is the only authority to check items as complete (`passed review`)
- `checklist.md` remains the single source of truth for completion

---

### notes.md
Contains:
- decisions
- blockers
- risks
- follow-up items

Updated by:
- `work-batch`
- `integrate-work-batch-branch`
- `batch-update-manual-review-status`

---

### review.md
Represents:
- current review status
- open issues
- required fixes
- manual review state

Owned by:
- `work-batch` for factual implementation status only
- `integrate-work-batch-branch` for factual implementation status only when worker branches are being integrated
- `batch-update-manual-review-status`
- `batch-review-and-finalize`

---

### change-queue.md
Tracks:
- actionable issues discovered during review

Sections:
- Ready To Implement
- In Progress
- Implemented Pending Review
- Blocked
- Deferred
- Passed Review
- Closed

Owned by:
- `work-batch` for implementation-state transitions on targeted `Ready To Implement` items only
- `integrate-work-batch-branch` for implementation-state transitions when the implementation was produced on a worker branch
- `batch-update-manual-review-status` for review-state transitions and review-driven queue maintenance

Queue-state rules:
- `Ready To Implement` contains items that still require implementation work
- `In Progress` contains the queue item currently claimed by the active `work-batch` pass or by an integrator-recorded active worker-branch assignment
- move a targeted item from `Ready To Implement` to `In Progress` as soon as implementation work begins for that item
- in branch-based execution, the integrator records that `In Progress` claim when the worker assignment becomes active
- continue or explicitly reclassify an existing unfinished `In Progress` item before claiming a new `Ready To Implement` item in a later pass
- complete one claimed queue item at a time; do not move a second independently tracked item into `In Progress` until the current one reaches `Implemented Pending Review`, `Blocked`, or `Deferred`
- `Implemented Pending Review` contains items that were implemented in a completed work pass, are available on the required review surface, and are awaiting human confirmation
- local development can be the review surface when the reviewer is inspecting the same working tree; that local review does not require push or deploy
- an item confirmed on a local development surface must not move to `Passed Review` until the accepted implementation is committed
- if deployment is required for review, do not move an item into `Implemented Pending Review` until commit, push, and the canonical deploy all succeed
- if implementation is complete but the required deploy fails or cannot be completed, record that deploy gap in the worklog/review state and keep the queue item out of `Implemented Pending Review`
- the temporary active-batch UI Reference overlay may use a derived runtime manifest, but `change-queue.md` remains the canonical source of truth for which queue IDs are currently pending review
- a new adjacent finding on the same broad surface does not, by itself, prove an existing `Implemented Pending Review` item failed
- move an item from `Implemented Pending Review` back to `Ready To Implement` only when manual review directly shows that the same item's implemented outcome failed
- if manual review finds a separate uncovered path or adjacent gap, keep the implemented item in `Implemented Pending Review` and add a new `Ready To Implement` follow-up item instead

Manual-review classification rule:
- every review finding must be classified as one of:
  - confirmation of an existing implemented item
  - failure of an existing implemented item
  - new finding
- `batch-update-manual-review-status` must make that classification explicitly before moving queue items
- if the finding cannot be classified safely, stop and ask instead of guessing the queue transition

Queue item format:
- keep the main queue line as one concise actionable bullet
- exploratory discussion belongs in chat first and must be normalized before it enters the queue
- every active item in `Ready To Implement`, `In Progress`, or `Implemented Pending Review` should carry a stable `ID:` line using:
  - `P<phase>-<batch>-CQ-###`
  - example: `P2-A-CQ-001`
- the `ID:` line is the stable identity of the item and must not change when the item moves between queue sections
- if an item is reopened or refined, track that separately with `Iteration:` when needed instead of changing the ID
- when helpful, add short continuation lines directly below the item:
  - `ID:`
  - `Iteration:`
  - `Scope:`
  - `Path Coverage:`
  - `Implemented in:`
  - `Follow-up To:`
  - `Supersedes:`
- use continuation lines for traceability only; do not turn `change-queue.md` into a conversation log
- if a new finding comes from a longer review discussion, rewrite it into concise implementation-ready language before adding it to `Ready To Implement`

---

### /worklogs/

#### worklog-<phase>-<batch>-####.md

One file per work pass.

Example:
`worklog-2-A-0001.md`

Rules:
- sequential numbering
- never overwritten
- immutable history

#### index.md

Tracks all work passes.

---

## Worklog Format

Each worklog must include:

- Prompt Summary
- Scope
- Files Changed
- Targeted Change Queue IDs
- Queue Item Grouping Rationale
- Work Completed
- Checklist Impact
- Validation Performed
- Review Surface
- Issues Found
- Deferred Items
- Commit / Deploy
- Notes

---
