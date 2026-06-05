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

The active batch workspace is `/docs/08-active/`. It is a singleton active workspace. Concurrent `batch-start` or `work-batch` execution against that shared workspace is not supported.

For full workspace file ownership, queue format, and worklog rules, see [Active Workspace](batch-workflow/active-workspace.md).

---

## Read Path

Open only the workflow detail for the step being executed:

- [Start Batch](batch-workflow/batch-start.md) for `batch-start` initialization.
- [Work Batch](batch-workflow/work-batch.md) for singleton active-batch implementation passes.
- [Work Batch Branch](batch-workflow/work-batch-branch.md) for dedicated worker branch execution.
- [Integrate Work Batch Branch](batch-workflow/integrate-work-batch-branch.md) for integrator-owned branch merge and active-workspace sync.
- [Manual Review](batch-workflow/manual-review.md) for `batch-update-manual-review-status` queue and checklist review updates.
- [Additional Work Passes](batch-workflow/additional-work-passes.md) for repeated queue-driven implementation cycles.
- [Review And Finalize Batch](batch-workflow/review-and-finalize.md) for active workspace closure.

Use supporting rules only when needed:

- [State Models](batch-workflow/state-models.md) for checklist and change-queue state rules.
- [Commit And Deployment](batch-workflow/commit-and-deployment.md) for review-ready commit, push, and deploy expectations.
- [Responsibility And Enforcement](batch-workflow/responsibility-and-enforcement.md) for workflow ownership boundaries and final enforcement rules.

---

## Related Runbooks

- [Git Batch Commit Workflow](git-batch-commit-workflow.md)
- [Deployment](deployment.md)
- [Branch-Based Batch Integration](branch-based-batch-integration.md)
- [Agent Sessions And Parallel Work](agent-sessions-and-parallel-work.md)

---

## Final Rule

If a change cannot be clearly tied to:
- the current batch
- a specific checklist item
- a single concern

do not implement it.
