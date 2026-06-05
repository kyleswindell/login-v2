# Branch-Based Batch Integration

This document defines the canonical scope and intent for branch-based batch execution with serialized integration.

## Purpose

Allow one isolated runtime worker to implement a change-queue item while a separate integrator owns `/docs/08-active/`, review state, staging, and final merge/promotion.

Multiple runtime workers are an exception, not the default. Use them only after explicit operator approval for a temporary, bounded parallel burst.

## Core Rule

Branch-based worker implementation is allowed only when:

* the worker uses its own branch and its own worktree
* the worker owns one queue item at a time
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
2. The integrator may execute `orchestrate-work-batch-branches` to create or attach the worker lane for the selected ready queue item.
3. The worker executes `work-batch-branch` for that queue item.
4. The worker commits scoped changes on the worker branch and updates the handoff artifact.
5. The integrator executes `integrate-work-batch-branch`.
6. The integrator merges or cherry-picks the worker commits.
7. The integrator updates `/docs/08-active/` to reflect the actual implementation outcome.
8. If the integrated result is review-ready and needs staging, the integrator pushes and deploys it.
9. `batch-update-manual-review-status` and `batch-review-and-finalize` continue to own review closure and batch close-out.

## Preferred Codex App Orchestration

Preferred path when the Codex app is available:

1. Keep one integrator project thread on the local `main` worktree.
2. Use `orchestrate-work-batch-branches` to create or attach one worker project thread for the assigned queue item in Worktree mode.
3. Run `work-batch-branch` inside the worker thread.
4. Use the handoff artifact as the durable worker-to-integrator coordination surface.
5. Run `integrate-work-batch-branch` only in the integrator thread.

Prefer a dedicated worker project thread for long-lived ownership visibility. If the available Codex tooling cannot attach that project thread to the already-provisioned dedicated worktree, a spawned child agent is an acceptable worker fallback only when it is explicitly bound to the assigned dedicated branch/worktree and still completes the full `work-batch-branch` contract:

* implement only the assigned queue item
* do not edit `/docs/08-active/`
* run scoped verification
* create a scoped worker commit when reviewable
* update the matching handoff artifact

This fallback preserves the real safety boundary when the edits still occur only inside the dedicated worker worktree.

## Operator Entry Point

The operator should not have to hand-author a long orchestration prompt.

Preferred trigger:

* ask the integrator session to execute `orchestrate-work-batch-branches` for the current ready queue item
* natural-language equivalent accepted in this repo:
  `Start branch-based batch execution: create a worker branch/worktree for the current ready queue item and keep /docs/08-active integrator-owned.`

That workflow should own:

* worker lane creation/attachment
* worker branch/worktree assignment
* handoff-file seeding
* optional worker-start handoff when explicitly requested

The operator should only need to specify exceptions such as:

* which ready queue items to include or exclude
* whether more than one worker lane is explicitly approved for a temporary burst
* whether worker execution should begin immediately or stop after lane setup
* whether existing worker lanes should be reused

## Queue Ownership

In this mode:

* the worker may discuss or reference queue items
* worker lanes do not move queue items between active sections in `/docs/08-active/`
* the integrator records the official transition into:
  * `In Progress`
  * `Implemented Pending Review`
  * `Blocked`
  * `Deferred`

This preserves one canonical queue writer while implementation happens in an isolated branch.

## Merge Strategy

Preferred order:

1. cherry-pick or merge the worker implementation commit onto the integration branch
2. make a separate integrator state-sync commit for `/docs/08-active/` and handoff status when that keeps history clearer
3. push the integrated branch or `main` according to the active review flow

Do not bundle multiple worker queue items into one shared implementation commit.

## Staging Rule

Staging remains single-owner:

* only the integrator deploys the shared review surface
* worker branches must not deploy themselves to the same shared staging target

## Related

* [Batch Workflow](batch-workflow.md)
* [Agent Sessions And Parallel Work](agent-sessions-and-parallel-work.md)
* [Git Batch Commit Workflow](git-batch-commit-workflow.md)
