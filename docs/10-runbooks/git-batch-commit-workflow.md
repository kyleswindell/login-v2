# Git Batch Commit Workflow

## Purpose

Define the required git commit and push checkpoints for batch-based work so implementation stays organized, reviewable, and recoverable.

This workflow applies to all active-batch execution using `/docs/08-active/`.

---

## Core Rules

- One commit must map to one batch and one concern.
- Do not mix unrelated docs, code, cleanup, or future work in the same commit.
- Do not include unrelated staged or modified files.
- If unrelated issues are found during a batch, record them in `notes.md` and leave them out of the commit.
- `git status` must be reviewed before every commit.
- Batch work should produce multiple small, meaningful save points rather than one large commit.

---

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

Commit when the batch implementation is complete enough for review and manual visual validation.

Example message:

feat(batch-a): ready for review

Allowed scope:

* completed implementation
* required docs sync for the batch
* no unrelated cleanup

Purpose:

* marks the review candidate
* defines the exact review target

---

### 5. Review Fixes

If review or manual QA finds issues, commit only the fixes required to address them.

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

## Push Rules

### Push after review-ready checkpoint

Push the review candidate branch or commit before visual QA when staging deployment or shared review is required.

### Push after review-fix checkpoint

Push again after any fixes that must be revalidated.

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

---

## Final Rule

If a change cannot be described as one batch and one concern, it should not be committed yet.
