# Batch Workflow

## Purpose

Define the canonical workflow for executing, reviewing, and finalizing batch-based work using `/docs/08-active/`.

This workflow ensures:
- consistent execution
- clear separation of responsibilities
- traceable implementation history
- deterministic review and validation

---

## Active Workspace

The active batch workspace is:

`/docs/08-active/`

This directory represents the current batch state and must be used for all batch-related tracking.

Concurrency rule:

- `/docs/08-active/` is a singleton active workspace
- concurrent `batch-start` or `work-batch` execution is not supported under the current model, even when separate Git worktrees exist
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
- `batch-update-manual-review-status` for review-state transitions and review-driven queue maintenance

Queue-state rules:
- `Ready To Implement` contains items that still require implementation work
- `Implemented Pending Review` contains items that were implemented in a completed work pass and are awaiting human confirmation
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
- when helpful, add short continuation lines directly below the item:
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
- Work Completed
- Checklist Impact
- Issues Found
- Deferred Items
- Commit / Deploy
- Notes

---

## Workflow Phases

### 1. Start Batch

Workflow entry point:
- `batch-start`

- initialize `/docs/08-active/`
- load batch scope
- reset working files
- load checklist
- initialize the `change-queue.md` lifecycle sections

---

### 2. Work Batch

Workflow entry point:
- `work-batch`

Responsibilities:
- execute scoped implementation
- create a new worklog file
- update worklog index
- update notes.md
- annotate checklist.md (not complete)
- update review.md with factual status only
- commit/push/deploy when the pass is review-ready and manual visual review is required

Rules:
- do not expand scope
- set checklist `Status` only
- do not mark checklist items complete
- do not finalize batch
- for shared UI or system surfaces, identify the relevant render/update paths before calling the pass review-ready
- examples of parallel paths include:
  - server-rendered markup
  - realtime or client-injected markup
  - toast or overlay variants
  - full-index or detail views for the same system
- if one of those paths is intentionally not updated in the pass, record it explicitly as a follow-up item instead of implying full surface completion
- preserve existing queue metadata lines when moving items between sections
- add or update `Implemented in:` when that improves traceability for a targeted item

---

### 3. Manual Review

Workflow entry point:
- `batch-update-manual-review-status`

Responsibilities:
- process human review input
- move `change-queue.md` items through the review lifecycle
- update review.md
- update checklist.md (`passed review` checkbox authority)
- confirm which items require additional work

Rules:
- classify each review finding before changing queue state:
  - existing item confirmed
  - existing item failed
  - new finding
- treat exploratory chat or review commentary as source material, not as queue-ready text
- normalize new findings into concise implementation-ready queue language before writing them into `change-queue.md`
- do not reopen an `Implemented Pending Review` item unless the review evidence directly maps to that same item's scoped implemented outcome
- if the review reveals a separate gap on an uncovered path, keep the existing item pending review and open a new `Ready To Implement` item for the uncovered gap

---

### 4. Additional Work Passes

- driven by change-queue.md
- executed via `work-batch`
- repeat until review issues resolved

---

### 5. Review and Finalize Batch

Workflow entry point:
- `batch-review-and-finalize`

Conditions:
- all checklist items complete
- no open issues
- manual review = PASS
- functional review = PASS

Actions:
- commit final state
- archive /`docs/08-active/` to:
  `/docs/11-ai/_archive/batches/<date-name>/`
- reset `/docs/08-active/`

---

## Checklist State Model

Each checklist item has two fields:

- checkbox = review completion only
- `Status:` line = implementation state only

Allowed `Status:` values:

- not implemented
- deferred
- implemented
- implemented (pending agent review)
- implemented (pending manual review)
- blocked

Rules:
- `work-batch` sets `Status` only
- `batch-update-manual-review-status` is the only authority to check items as complete (`passed review`)
- `checklist.md` remains the single source of truth for completion

---

## Checklist Structure Rules

- Only top-level checklist items may contain:
  - a checkbox
  - a `Status:` line
- The required top-level pattern is:
  - `- [ ] <item label>` or `- [x] <item label>`
  - immediately followed by `  Status: <allowed value>`
- Nested items must be plain bullet points only
- No nested checkboxes allowed
- No nested `Status:` lines allowed
- Checklist completion is determined only by top-level items
- Checklist structure must not be altered during batch execution

---

## Change Queue Rules

- initialized empty by `batch-start`
- populated by `batch-update-manual-review-status`
- implemented items are worked by `work-batch`
- `work-batch` may move targeted items only through implementation states:
  - `Ready To Implement`
  - `In Progress`
  - `Implemented Pending Review`
  - `Blocked`
  - `Deferred`
- `batch-update-manual-review-status` owns review-state transitions such as:
  - `Passed Review`
  - `Closed`
- contains only actionable items
- issues move through these sections only:
  - `Ready To Implement`
  - `In Progress`
  - `Implemented Pending Review`
  - `Blocked`
  - `Deferred`
  - `Passed Review`
  - `Closed`
- drives future work passes

---

## Commit and Deployment

Follow:
`docs/10-runbooks/git-batch-commit-workflow.md`
`docs/10-runbooks/deployment.md`

Rules:
- one commit = one concern
- no unrelated files
- commit only when work is scoped and ready
- when a `work-batch` pass is review-ready and manual visual review is required, commit, push, and deployment are required parts of that workflow step
- do not stop for a second approval if the user explicitly requested the active `work-batch` step
- stop only if a documented deployment precondition is missing or the canonical deploy path is unavailable from the current execution environment

---

## Workflow Responsibility Model

### `batch-start`
- initializes `/docs/08-active/`
- loads batch scope
- resets active workspace state

### `work-batch`
- executes implementation
- records work
- annotates checklist
- does not finalize or approve

### `batch-update-manual-review-status`
- captures review findings
- updates checklist and review state
- maintains change queue

### `batch-review-and-finalize`
- validates completion
- archives batch
- resets workspace

---

## Enforcement Rules

- only one agent modifies canonical docs or code per session
- do not mix batch execution with review
- do not bypass `/docs/08-active/`
- do not skip workflow steps
- do not implement unresolved standards decisions

---

## Final Rule

If a change cannot be clearly tied to:
- the current batch
- a specific checklist item
- a single concern

do not implement it.
