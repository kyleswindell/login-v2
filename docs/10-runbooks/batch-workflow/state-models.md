# Batch Workflow - State Models

[Back to Batch Workflow](../batch-workflow.md)

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
- implemented items are worked by `work-batch` or `work-batch-branch`
- `work-batch` may move targeted items only through implementation states:
  - `Ready To Implement`
  - `In Progress`
  - `Implemented Pending Review`
  - `Blocked`
  - `Deferred`
- `integrate-work-batch-branch` may move targeted items through those same implementation states when the code was produced on a worker branch and the active workspace is being synchronized by the integrator
- `In Progress` is the live claim state for the active `work-batch` owner or for an integrator-recorded active worker-branch assignment, not a general backlog bucket
- in branch-based parallel execution, worker-branch progress is tracked in branch handoff artifacts until the integrator updates the active queue
- if a pass ends with an unfinished `In Progress` item, the next `work-batch` pass must continue or explicitly reclassify that item before starting a new `Ready To Implement` item
- `batch-update-manual-review-status` owns review-state transitions such as:
  - `Passed Review`
  - `Closed`
- `Implemented Pending Review` is valid only when the item is actually reviewable on the required surface; if deployment is required, that means the deploy already succeeded
- local development may be the required review surface when review happens in the same working tree; accepted local-review work must be committed before it moves to `Passed Review`
- do not use queue item state or advisory claims as justification for multiple writers against the same active workspace
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
