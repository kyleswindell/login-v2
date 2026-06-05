# Git Batch Commit Workflow - Scope Hygiene And Stop Conditions

[Back to Git Batch Commit Workflow](../git-batch-commit-workflow.md)

## What Must Not Be Committed Together

Do not combine in one commit:

* multiple batches
* Tier 1 and Tier 2 implementation
* docs-only cleanup and feature implementation
* review fixes and new feature work
* unrelated working tree changes

---

## Required Git Hygiene Before Each Commit

* Review `git status`
* Review staged diff
* Confirm commit scope matches the current batch and concern
* Confirm no unrelated files are staged
* Confirm the commit message names the actual work completed

---

## Batch Commit Message Pattern

Use this format where practical:

<type>(<batch>): <scope>

Examples:

feat(batch-a): implement button and icon button
feat(batch-a): implement shell navigation baseline
fix(batch-a): address review feedback

For docs-only lifecycle checkpoints:

docs: initialize Phase 2 Batch A
chore: finalize Phase 2 Batch A

---

## Stop Conditions

Do not commit yet if:

* batch scope is still ambiguous
* unrelated files are staged
* review findings are not yet resolved
* the batch is mixing work from another phase or batch
* `/docs/08-active/` does not reflect the current state accurately
* the commit would combine unrelated queue items without a recorded grouping rationale
* the only reason to push is implementation iteration that can still be reviewed locally

---

## Final Rule
