# Batch Workflow - Responsibility And Enforcement

[Back to Batch Workflow](../batch-workflow.md)

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

### `work-batch-branch`
- executes one queue item on a dedicated worker branch/worktree
- records branch handoff state
- does not update `/docs/08-active/`

### `integrate-work-batch-branch`
- integrates one worker branch at a time
- syncs `/docs/08-active/` and deploy-backed reviewability state
- does not replace manual-review authority

### `batch-update-manual-review-status`
- captures review findings
- updates checklist and review state
- maintains change queue

### `batch-review-and-finalize`
- validates completion
- archives batch
- resets workspace
- reports whether parent planning/status sync is required next

### `review-docs-sync` + `implement-docs-sync-fix`
- synchronize canonical docs outside `/docs/08-active/` when a reviewed batch or phase changed parent planning truth
- keep roadmap, phase indices, deferments, and linked parent planning notes aligned with the reviewed implementation state

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
