# Git Batch Commit Workflow - Push And Parallel Branches

[Back to Git Batch Commit Workflow](../git-batch-commit-workflow.md)

## Push Rules

### Push after review-ready checkpoint

Push the review candidate branch or commit before visual QA when staging deployment or shared review is required.

If local development verification is sufficient and no shared review URL is needed yet, keep the work local through implementation iteration. After local review accepts the scoped queue item or tightly coupled queue-item group, create the local commit before the review state is marked passed; push only when the work needs publication.

### Push after review-fix checkpoint

Push again after any fixes that must be revalidated.

Do not push every local fix attempt. Push when the fix is ready for shared revalidation or server-specific confirmation.

### Push after finalization

Push the final batch state after `/docs/08-active/` is reset and close-out is complete.

---

## Parallel Branch Path

When branch-based parallel batch execution is in use, worker branches and the integrator branch have different commit responsibilities.

### Worker Branch Implementation Commits

Rules:

* one worker branch commit must map to one queue item and one concern
* worker branch commits must not include `/docs/08-active/*`
* worker branch commits may include the matching handoff artifact under `.agents/batch-branch-handoffs/` when that artifact is part of the worker handoff
* worker branch commits should publish enough validation state that the integrator can review and merge without reconstructing the pass

Example messages:

feat(p2-b-cq-005): restore dashboard widget tall spans
fix(p2-b-cq-017): normalize phone input formatting

### Integrator State-Sync Commits

Rules:

* one integrator commit must map to one integrated queue item or one tightly related integration concern
* integrator commits own `/docs/08-active/*` state reconciliation
* integrator commits may include handoff status updates, integration-branch notes, and deploy/reviewability state
* if deployment is required for review, the integrator commit is not review-ready until push and deploy succeed

Example messages:

docs(batch-b): sync p2-b-cq-005 integration state
fix(batch-b): publish p2-b-cq-017 for staging review

---
