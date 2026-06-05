# Batch Workflow - Commit And Deployment

[Back to Batch Workflow](../batch-workflow.md)

## Commit and Deployment

Follow:
`docs/10-runbooks/git-batch-commit-workflow.md`
`docs/10-runbooks/deployment.md`
`docs/10-runbooks/local-dev.md`

Rules:
- one commit = one concern
- no unrelated files
- commit only when work is scoped and ready
- use local development verification before server or staging deployment when local validation can prove the change
- local development review may happen before a commit when the reviewer is inspecting the same working tree
- once local review accepts a queue item or tightly coupled queue-item group, create the scoped commit before marking that work as passed review
- document grouped queue-item commits with the targeted IDs, grouping rationale, affected files, validation, and review surface
- when a `work-batch` pass is review-ready and manual visual review requires a shared URL, commit, push, and deployment are required parts of that workflow step
- do not push or deploy implementation micro-steps to the server when local validation is sufficient and the work is not yet review-ready
- if deployment is required for review and the deploy does not complete, the pass is not review-ready and targeted queue items must not be left in `Implemented Pending Review`
- do not stop for a second approval if the user explicitly requested the active `work-batch` step
- stop only if a documented deployment precondition is missing or the canonical deploy path is unavailable from the current execution environment

---
