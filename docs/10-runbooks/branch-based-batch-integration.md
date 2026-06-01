# Branch-Based Batch Integration

This document defines the canonical scope and intent for branch-based parallel batch execution.

## Purpose

Allow multiple writable implementation sessions to work on separate change-queue items at the same time without turning `/docs/08-active/` into a multi-writer workspace.

## Core Rule

Parallel implementation is allowed only when:

* each worker uses its own branch and its own worktree
* each worker owns one queue item at a time
* a single integrator session serializes:
  * `/docs/08-active/` updates
  * merge or cherry-pick decisions
  * staging deployment ownership
  * review-surface publication

## Roles

### Worker

The worker session:

* reads the active batch workspace for context
* implements one assigned queue item on a dedicated branch/worktree
* updates canonical code/docs required by that queue item
* does **not** edit `/docs/08-active/`
* writes a handoff artifact under `.agents/batch-branch-handoffs/`

### Integrator

The integrator session:

* remains the singleton writable owner of `/docs/08-active/`
* reviews worker handoff artifacts
* merges or cherry-picks worker branch commits
* updates active batch queue, notes, review state, checklist annotations, and worklogs
* owns push, staging deploy, and the move to `Implemented Pending Review`

## Canonical Handoff Artifact

Worker-to-integrator handoff files live under:

* `.agents/batch-branch-handoffs/`

Each queue item should have one handoff file keyed by queue ID.

Minimum contents:

* queue ID
* branch name
* worktree path
* base SHA
* current head SHA
* scope summary
* files changed
* tests run
* docs sync performed
* deploy/review expectations
* merge notes or known conflicts
* status (`draft`, `ready_for_integration`, `integrated`, `superseded`)

## Workflow

1. `batch-start` initializes `/docs/08-active/` as usual.
2. The integrator selects a queue item and creates or confirms the worker branch/worktree.
3. The worker executes `work-batch-branch` for that queue item.
4. The worker commits scoped changes on the worker branch and updates the handoff artifact.
5. The integrator executes `integrate-work-batch-branch`.
6. The integrator merges or cherry-picks the worker commits.
7. The integrator updates `/docs/08-active/` to reflect the actual implementation outcome.
8. If the integrated result is review-ready and needs staging, the integrator pushes and deploys it.
9. `batch-update-manual-review-status` and `batch-review-and-finalize` continue to own review closure and batch close-out.

## Queue Ownership

In this mode:

* workers may discuss or reference queue items
* workers do not move queue items between active sections in `/docs/08-active/`
* the integrator records the official transition into:
  * `In Progress`
  * `Implemented Pending Review`
  * `Blocked`
  * `Deferred`

This preserves one canonical queue writer even while implementation happens in parallel branches.

## Merge Strategy

Preferred order:

1. cherry-pick or merge worker implementation commits onto the integration branch
2. make a separate integrator state-sync commit for `/docs/08-active/` and handoff status when that keeps history clearer
3. push the integrated branch or `main` according to the active review flow

Do not bundle multiple worker queue items into one shared implementation commit.

## Staging Rule

Staging remains single-owner:

* only the integrator deploys the shared review surface
* multiple worker branches must not each deploy themselves to the same shared staging target at the same time

## Related

* [Batch Workflow](batch-workflow.md)
* [Agent Sessions And Parallel Work](agent-sessions-and-parallel-work.md)
* [Git Batch Commit Workflow](git-batch-commit-workflow.md)
