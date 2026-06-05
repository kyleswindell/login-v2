# Git Batch Commit Workflow - Commit Checkpoints

[Back to Git Batch Commit Workflow](../git-batch-commit-workflow.md)

## Required Commit Checkpoints

### 1. Batch Initialized

Create a checkpoint after `/docs/08-active/` has been loaded for a new batch and before implementation starts.

Example message:

docs: initialize Phase 2 Batch A


Allowed scope:

* `/docs/08-active/*` only

Purpose:

* preserves the assigned batch state
* creates a clean restart point before implementation

---

### 2. Pre-Implementation Baseline

Confirm the working tree is clean or intentionally scoped before implementation begins.

Example message:

chore: baseline before Phase 2 Batch A implementation

Allowed scope:

* only if a real baseline note or scoped prep change is required
* otherwise this checkpoint may be a verified clean working tree with no commit

Purpose:

* prevents unrelated changes from leaking into the batch
* establishes a known-good starting point

---

### 3. Incremental Implementation Save Points

Commit implementation in small, scoped units.

These save points are local or branch-history checkpoints by default. They do not require server push or deployment unless the current workflow explicitly needs shared review or environment-specific validation.

Example messages:

feat(batch-a): implement button and icon button
feat(batch-a): implement input controls
feat(batch-a): implement table baseline

Allowed scope:

* one logical implementation unit only
* only files directly touched for that unit

Purpose:

* keeps history reviewable
* creates safe rollback points
* reduces review complexity

---

### 4. Batch Ready For Review

Commit when the batch implementation is complete enough for shared review and manual visual validation.

Use local development verification first. If review will happen on the local development surface, the reviewer may inspect the scoped working tree before the review commit exists. After local review accepts the queue item or tightly coupled queue-item group, create the scoped commit before the work is marked passed review.

Push and deploy this checkpoint only when manual review requires a shared staging/server surface or when the behavior cannot be validated locally.

Example message:

feat(batch-a): ready for review

Allowed scope:

* completed implementation
* required docs sync for the batch
* no unrelated cleanup

Purpose:

* marks the review candidate
* defines the exact review target
* records the accepted local-review target before review state is closed

---

### 5. Review Fixes

If review or manual QA finds issues, commit only the fixes required to address them.

Use local verification for review fixes first. Push and deploy the fix checkpoint only when the reviewer needs the shared surface updated or the original failure was staging/server-specific.

If the fix is reviewed locally, commit the accepted fix before the related queue item is moved to `Passed Review`.

Example message:

fix(batch-a): address review feedback

Allowed scope:

* only files needed to resolve review findings

Purpose:

* keeps review corrections isolated
* prevents new work from being mixed into a review-fix pass

---

### 6. Batch Finalized

Commit after batch close-out is complete and `/docs/08-active/` has been reset.

Example message:

chore: finalize Phase 2 Batch A

Allowed scope:

* `/docs/08-active/*`
* close-out docs updates directly required by the workflow

Purpose:

* preserves final batch review state
* marks the transition back to a clean active workspace

---
