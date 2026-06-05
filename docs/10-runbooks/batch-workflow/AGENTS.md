# docs/10-runbooks/batch-workflow AGENTS.md

## Purpose

Focused lifecycle details for the canonical batch workflow. This folder exists to keep agents from loading the entire workflow when only one step is being executed.

## Read Order

1. Start with `../batch-workflow.md` to confirm the active workspace rule and choose the workflow step.
2. Open only the child runbook for the current workflow step:
   - `batch-start.md`
   - `work-batch.md`
   - `work-batch-branch.md`
   - `integrate-work-batch-branch.md`
   - `manual-review.md`
   - `review-and-finalize.md`
3. Open support files only when the step needs them:
   - `active-workspace.md` for file ownership, queue format, and worklog rules.
   - `state-models.md` for checklist or change-queue state transitions.
   - `commit-and-deployment.md` for review-ready commit, push, and deploy expectations.
   - `responsibility-and-enforcement.md` for ownership boundaries.

## Avoid

- Do not read every child runbook for a single workflow step.
- Do not edit `/docs/08-active/` while updating these static runbooks.
- Do not move product, architecture, schema, or planning truth into this runbook folder.
