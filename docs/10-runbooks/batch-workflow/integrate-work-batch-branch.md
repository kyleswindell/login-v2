# Batch Workflow - Integrate Work Batch Branch

[Back to Batch Workflow](../batch-workflow.md)

### 2B. Integrate Work Batch Branch

Workflow entry point:
- `integrate-work-batch-branch`

Responsibilities:
- review a worker branch handoff artifact
- merge or cherry-pick one worker branch into the integration branch
- update `/docs/08-active/` to reflect the integrated implementation state
- own commit, push, and deploy-backed review-surface publication when required

Rules:
- one worker branch is integrated at a time
- the integrator is the only owner allowed to sync `change-queue.md`, `review.md`, `notes.md`, and worklog/index state for branch-based execution
- the integrator may also record `In Progress` when a worker assignment is formally active and later move that item to its next implementation outcome after integration
- if deploy-backed review is required, do not move the queue item into `Implemented Pending Review` until the integration commit is pushed and the required deploy succeeds
- if integration reveals additional conflicts or uncovered scope, record that explicitly before publishing review-ready status

---
