# Agent Sessions And Parallel Work

This document defines the canonical scope and intent for Agent Sessions And Parallel Work.

## Purpose

Define the safe operating model for running multiple agent sessions against Login App 2.0 without overlapping writes, silent file overwrites, or ambiguous handoff state.

## Planning Source

* [Git Remote And Multi-Device Workflow](git-remote-and-multi-device-workflow.md)

## Current Status

* active workflow guidance
* adopted for local same-machine agent sessions
* no enforcement tooling required by default
* default active-batch operating shape is one runtime batch worker plus one integrator/doc-review/change-queue writer

## Core Rule

One writable agent session per working tree.

If multiple sessions are pointed at the same local repository folder:

* one session may be writable
* all other sessions must stay read-only and limit themselves to planning, review, audit, or research

If multiple sessions must write concurrently:

* create a separate branch per writable session
* create a separate git worktree per writable session
* merge or rebase only after each session closes out its scoped work

## Why Git Alone Is Not Enough

Git does not provide a Perforce-style checkout lock for normal local files.

Git can detect divergent history and merge conflicts after the fact, but it does not stop two local sessions from editing the same file in the same working tree at the same time.

Implications:

* a manual checkout file or lock note is advisory only
* same-folder concurrent writes are unsafe even when each session intends to touch different files
* documentation index notes and shared planning notes are common conflict points during parallel sessions

## Supported Operating Modes

### Support Matrix

| Mode | Supported | Notes |
|---|---|---|
| Shared folder, single writer | Yes | default safe mode |
| Shared folder, multiple read-only sessions | Yes | one writer only |
| Separate branches plus separate worktrees, multiple writers | Exception only | use only when the work cannot wait and each writer has isolated scope |
| One worker branch/worktree plus serialized integration | Yes | default active-batch parallel shape; worker stays out of `/docs/08-active/`; one integrator owns queue state and staging |
| Multiple worker branches/worktrees plus serialized integration | Exception only | requires explicit operator approval; keep temporary and bounded |
| Concurrent `batch-start` / `work-batch` on shared `/docs/08-active/` | No | current active workspace is singleton |
| Concurrent review-ledger final writes without serialization | No | shared index writes and same-day slug collisions still need one final writer |
| Multiple non-`main` staging review branches at once | No | staging has one active owner at a time |

### Mode A — Shared Folder, Single Writer

Use this as the default workflow.

Allowed:

* Session A implements code and documentation in the shared folder
* Sessions B and C review code, audit docs, inspect architecture, or plan future batches in the same folder

Not allowed:

* Session B or C editing files while Session A is still the active writable session in that same folder

Best fit:

* one implementation agent
* one or more planning or review agents
* same-machine workflow where the shared folder is already open in VS Code

### Mode B — Separate Branches And Separate Worktrees

Use this only when two sessions must both write at the same time and the work cannot be safely serialized.

Required:

1. create or choose a branch for each writable task
2. create a separate worktree for each writable branch
3. open each worktree in its own VS Code workspace or window
4. keep commit scope narrow and merge only after each task completes

Best fit:

* implementation work plus documentation work that both must edit files concurrently
* two unrelated writable tasks that cannot wait on each other

Default constraint:

* for routine repo work, prefer one writable implementation session plus one read-only planning/review session instead of opening multiple writers

### Mode B1 — Parallel Batch Implementation With Serialized Integration

Use this when one queue item from the active batch should be implemented in an isolated runtime worker while a separate integrator keeps ownership of `/docs/08-active/`, review state, and deployment coordination.

Default cap:

* one runtime batch worker
* one integrator/doc-review/change-queue writer

Multiple runtime workers are an exception, not the default. Use more than one worker only when the operator explicitly approves a temporary parallel burst and the queue items are independent enough to justify the coordination cost.

Required:

1. keep one integrator session as the only writer of `/docs/08-active/`
2. give the runtime worker its own branch and its own worktree
3. have the worker session implement one queue item at a time and record a handoff artifact in `.agents/batch-branch-handoffs/`
4. keep worker-branch commits out of `/docs/08-active/`
5. have the integrator merge or cherry-pick reviewable worker branches one at a time, then update the shared active workspace and staging state

Best fit:

* one ready queue item that needs runtime implementation while review/change-queue writing continues separately
* batches where serialized queue state, review ledgers, and staging ownership matter more than maximizing parallel throughput

Not allowed:

* workers directly updating `change-queue.md`, `review.md`, or other `/docs/08-active/` files
* more than one integrator writing `/docs/08-active/` or owning staging at the same time

### Codex App Worktree Path

When using the Codex app, prefer the app's built-in Project Thread plus Worktree mode and Handoff flow as the first-class path for writable isolation.

Recommended shape for long-lived parallel writable work:

* one integrator project thread in the local `main` worktree
* one worker project thread for the active runtime queue item, created with Codex app Worktree mode
* the worker thread owns implementation and handoff updates only
* the integrator thread owns `/docs/08-active/`, push, deploy, and final merge/promotion

Default lane selection:

1. Use one Codex app project thread in Worktree mode for the current worker lane when the app tooling can create or attach it.
2. Use manually provisioned Git worktrees only as a fallback when Codex app Worktree mode is unavailable, cannot attach the worker lane, or the operator explicitly requests manual worktrees.
3. Do not create manual worker worktrees just to make the folder path predictable. Codex-managed worktrees are intentionally created under `$CODEX_HOME/worktrees` and are eligible for Codex cleanup behavior.

For branch-based active batch work in this repo, the preferred integrator entrypoint is:

* execute `orchestrate-work-batch-branches` only when a worker lane needs to be provisioned or attached

That keeps the orchestration contract in a skill file instead of forcing the operator to restate worker-start instructions manually.

Use spawned child agents inside a thread for bounded sidecar tasks such as:

* read-only codebase exploration
* scoped verification
* narrowly owned implementation on disjoint files inside an already-owned worker thread

If the app tooling cannot attach a real worker project thread to an already-provisioned dedicated worktree, a spawned child agent is an acceptable worker fallback only when all of the following stay true:

* the child agent is explicitly bound to the assigned dedicated branch/worktree
* it performs queue-item implementation only in that dedicated worktree
* it does not edit `/docs/08-active/`
* it completes the full worker lifecycle:
  * scoped verification
  * scoped worker commit when reviewable
  * handoff artifact update to `ready_for_integration` when appropriate

Do not treat unbound child agents or same-session shared-folder writes as equivalent to this fallback.

Important limitation:

* one branch may only be checked out in one worktree at a time

Use manual `git worktree` commands as the fallback path when:

* the Codex app worktree flow is unavailable
* a Codex-managed worker thread cannot be attached or targeted cleanly
* the repo is being operated outside the Codex app
* a manual Git workflow is explicitly preferred for the session

### Codex App Settings Baseline

Current baseline for this repo:

* `approval_policy = "on-failure"` is acceptable; keep approvals scoped and do not broaden them just to make multi-agent work easier
* `sandbox_mode = "workspace-write"` is acceptable; writable isolation comes from separate worktrees, not from broadening sandbox access
* `desktop.reviewDelivery = "detached"` is acceptable and fits review-heavy workflows
* `desktop.worktree-keep-count = 5` is currently sufficient for one integrator plus one Codex-managed worker thread, with room for cleanup overlap

Recommended checks before relying on longer-running background work:

* verify the Codex desktop app can keep running while the machine sleeps or the session is unfocused if you expect multi-hour background work
* keep browser/plugin notifications enabled enough to notice worker completion and integration-ready handoffs
* if an explicitly approved burst keeps more than one Codex-managed worker worktree alive, raise `desktop.worktree-keep-count` intentionally instead of letting the app prune older worktrees unexpectedly

No repo-local setting should assume that background continuation makes same-folder multi-writer edits safe. The branch/worktree ownership rules still apply.

### Worker Dependency Footprint

The worker lane should stay lightweight by default.

Do not run full dependency installation or a full Docker Compose stack inside the disposable worker worktree unless the queue item genuinely requires local runtime verification there. This repo mounts `vendor/` and `node_modules/` as Docker named volumes to keep dependency trees out of disposable worktree folders, but full Compose runs can still create Docker volumes plus ignored runtime artifacts such as `public/build/` and `storage/` files.

Preferred worker verification order:

1. Use already-available dependencies in the worker worktree when present.
2. Run scoped static checks, diff checks, targeted file inspection, or tests that do not require installing full dependencies.
3. Defer full build/test/browser verification to the integrator lane after cherry-pick or to staging after deploy when that is sufficient for review.
4. Install worker-local dependencies only when the queue item cannot be responsibly handed off without them.

If a worker lane must install dependencies or generate large ignored runtime artifacts, record that in the handoff so cleanup is intentional. For manual fallback worktrees, run `docker compose --project-name <worker-project> down --volumes` when a worker-local Compose stack was used, then remove the worktree with `git worktree remove --force <path>` after integration when those artifacts are no longer needed.

### Mode C — Multi-Machine Branch Workflow

When sessions are split across machines, GitHub remains the source of truth.

Required:

* commit locally
* push to GitHub
* pull or fetch before starting follow-up work elsewhere

This mode still follows the same rule: one writable session per working tree.

## Startup Checklist

Before any session starts editing:

1. confirm whether this session is read-only or writable
2. confirm the current branch and worktree path
3. confirm whether the working tree is clean or already contains in-progress changes
4. confirm the last stable commit or push point that this session can rely on
5. confirm whether another writable session is already active for this same folder
6. confirm the scope this session owns before making edits
7. if this session will write, confirm whether an advisory scope claim already exists in `.agents/session-scope-claims.json`

For `batch-start` or `work-batch`, the owned scope is the whole `/docs/08-active/` workspace. A queue item ID may be recorded as the current focus, but it does not narrow the writable ownership boundary.

For `work-batch-branch`, the worker-owned scope is the queue-item implementation plus its handoff artifact. It does not include `/docs/08-active/`.

For `integrate-work-batch-branch`, the owned scope includes `/docs/08-active/`, the integration branch, and any deploy-backed review surface needed to publish the integrated result.

If any of these are unclear, do not start writing.

If a session began as read-only planning, research, review, or audit and later becomes ready to write:

1. stop before editing
2. confirm whether another writable session already owns the current shared folder
3. if another writer is active, move the new writable work onto a separate branch and separate worktree or keep the session read-only
4. do not treat the intent to touch different files as sufficient protection in the same folder

## Shared-Folder Rules

When multiple sessions use the same folder:

* only the designated writable session may edit files
* planning sessions should prefer read-only planning output unless they are the active writer
* review and audit sessions should report findings, not apply fixes, unless the writable role is explicitly handed over
* if a planning, research, review, or audit session shifts from read-only to writable while another writer is active, it must stop and move to its own branch/worktree before editing
* do not treat uncommitted local changes as completed work until the writer closes out or explicitly hands off the state
* do not split active-batch queue items across same-folder writers by treating `In Progress` or advisory claims as per-item locks
* when branch-based parallel execution is in use, only the integrator may update `/docs/08-active/` or own shared staging deployment

## Delivery Flow And Sign-Off Gates

Recommended workflow for planned phase work:

1. `/phase-planning` defines or realigns the phase scope.
2. `/phase-batch-planning` sequences dependency-safe batches and parallel windows.
3. `/phase-batch-development` creates an implementation-ready delivery plan when the batch still needs a concrete build slice.
4. `/phase-batch-implementation` performs the scoped code and doc changes, runs tests, and prepares a review handoff.
5. `/phase-batch-review` compares the implementation against the batch note, canonical docs, tests, and diff. If clean, it commits and pushes. If not, it reports findings and returns the batch to implementation.
6. `/phase-batch-close-out` finalizes the reviewed and approved batch, determines whether the reviewed batch changed parent planning truth, and when it did, runs the scoped docs sync path against the owning planning docs before the batch is treated as fully synchronized:
   - `review-docs-sync`
   - `implement-docs-sync-fix`
   Typical targets include the current phase index, parent phase notes, deferment lanes, and other directly affected planning docs.
7. `/phase-close-out` performs full phase finalization after relevant batch close-outs are complete and uses the same scoped docs sync path when phase-wide status, roadmap state, or forward deferments changed:
   - `review-docs-sync`
   - `implement-docs-sync-fix`

Sign-off rules:

* implementation completion is not the same as sign-off
* a batch should not be marked complete until review passes and phase-batch-close-out updates the docs through the scoped docs sync workflow when parent planning truth changed
* a phase should not be marked complete until intended batches are batch-closed-out or explicitly deferred forward
* deferments discovered during review or close-out must be written into the appropriate future batch, future phase, or future-planning note

Manual visual review note:

* if rendered UI review requires staging, do not merge to `main` only to make the shared staging URL available
* instead, commit and push the review-clean branch, deploy that branch to staging for temporary QA, then promote to `main` only after the review is approved
* once review is complete, restore staging to `main` unless the approved branch is being promoted immediately

## Handoff Checklist

Before the writable session is handed off or another writable session begins:

1. summarize the active task scope
2. record whether the session stopped at clean commit state or with intentional uncommitted work
3. identify the last stable commit SHA or pushed branch state when available
4. note any files or notes that remain mid-edit
5. state whether the next session should continue in the same worktree or move to a separate worktree

## Advisory Session Registry

A checkout file or lock note may be used only as a coordination aid.

If used, keep it lightweight:

* active writable session name
* branch name
* worktree path
* owned scope
* expected close-out or handoff time

For active batch execution:

* record the owned scope as `/docs/08-active/`
* use queue item IDs only as descriptive context about the current focus
* do not treat a CQ item reference as permission for two writers to divide one active batch workspace

For branch-based batch execution with the default one-worker/integrator shape:

* the worker session may record queue-item scope and branch ownership in advisory claims
* the worker claim should reference the matching handoff artifact under `.agents/batch-branch-handoffs/`
* only the integrator claim should cover `/docs/08-active/` or staging ownership

Do not rely on this as protection. It documents intent only.

Canonical advisory claim state for this repo:

* `.agents/session-scope-claims.json`

Canonical advisory workflow note:

* [Advisory Session Scope Claims](advisory-session-scope-claims.md)

Use that file only for visibility:

* it is not a lock
* it does not make same-folder concurrent writes safe
* stale claims must be released or corrected when a writable session closes out

## Review Ledger Concurrency Rule

The review ledger has its own collision risk because:

* review artifacts still share one registry file: `docs/11-ai/active-doc-reviews/index.md`
* even with date-plus-slug filenames, two writers can still choose the same same-day slug for the same target
* `docs/11-ai/active-doc-reviews/index.md` is a shared registry file

Supported review-writing rule:

* one doc-review/change-queue writer should own final review-file creation and ledger updates
* additional review sessions should stay read-only unless the operator explicitly hands off write ownership
* final review-file creation and ledger update must be serialized

Date-plus-slug filenames reduce path collisions, but they do not make concurrent ledger final writes safe in one shared folder.

## Manual Worktree And Docker Compose Setup

This section covers the fallback path for creating a second writable worktree with its own Docker Compose stack. Prefer Codex app Worktree mode before this manual path when the app can create or attach the worker lane cleanly. Each manual worktree gets an isolated working tree and an isolated runtime so two agents can implement simultaneously without sharing files or database state.

### Port Convention

Each worktree `.env` must use non-conflicting port values. The docker-compose.yml already reads all ports from `.env` variables, so only the `.env` needs to change per worktree.

| Service | Primary — Agent A | Agent B | Agent C |
|---|---|---|---|
| `APP_PORT` | 8000 | 8001 | 8002 |
| `VITE_PORT` | 5173 | 5174 | 5175 |
| `FORWARD_DB_PORT` | 5432 | 5433 | 5434 |
| `FORWARD_REDIS_PORT` | 6379 | 6380 | 6381 |
| `FORWARD_MAILPIT_PORT` | 1025 | 1026 | 1027 |
| `FORWARD_MAILPIT_DASHBOARD_PORT` | 8025 | 8026 | 8027 |

### Create A Worktree

From the primary repo root in WSL or Git Bash:

For this repo, manually provisioned worker worktrees must live under the repo-specific worktree root:

```text
C:\Users\kswin\Desktop\Work 2023\8. Login V2.worktrees
```

Do not create new worker worktrees directly under `C:\Users\kswin\Desktop\Work 2023`. Existing handoff records may reference older parent-folder worktrees as historical state; do not treat those paths as the current provisioning convention.

```bash
# Create a new branch and a separate working directory in one step
mkdir -p "../8. Login V2.worktrees"
git worktree add "../8. Login V2.worktrees/login-v2-agent-b" feature/b-[batch-name]

cd "../8. Login V2.worktrees/login-v2-agent-b"

# Copy .env from the primary worktree and update port values
cp "../../8. Login V2/.env" .env
# Edit .env — change APP_PORT, VITE_PORT, FORWARD_DB_PORT, FORWARD_REDIS_PORT,
# FORWARD_MAILPIT_PORT, and FORWARD_MAILPIT_DASHBOARD_PORT to B-series values above.
# DB_DATABASE can stay the same — each stack runs its own Postgres container.

# Start the stack with a distinct project name so Docker keeps volumes separate
docker compose --project-name login-v2-b up --build

# Run migrations in the new stack
docker compose --project-name login-v2-b exec app php artisan migrate
```

Open the worktree folder in a separate VS Code window (`File → Open Folder → ../8. Login V2.worktrees/login-v2-agent-b`) so each agent session has its own editor context, terminal history, and file state.

### Merge Back And Clean Up

When the agent-B batch is complete and pushed:

```bash
# In the primary worktree
git fetch origin
git merge feature/b-[batch-name]

# Resolve any conflicts (see common conflict files below), run tests, then push
docker compose exec app php artisan test
git push

# Tear down the agent-B stack and remove the worktree
cd "../8. Login V2.worktrees/login-v2-agent-b"
docker compose --project-name login-v2-b down --volumes

cd "../../8. Login V2"
git worktree remove "../8. Login V2.worktrees/login-v2-agent-b"
git branch -d feature/b-[batch-name]
```

### Common Conflict Files At Merge

Even with isolated worktrees these files are frequently edited by more than one batch and should be resolved intentionally at merge time rather than accepted blindly:

* `routes/web.php` — every batch that adds routes touches this file; keep each branch's additions in separate route blocks to make the merge mechanical
* `app/Providers/AppServiceProvider.php` — service registrations, gates, and widget registrations accumulate here
* `docs/07-planning/phases/phase-X/Phase X Index.md` — both batches update implementation status sections
* `docs/08-active/worklogs/worklog-<phase>-<batch>-####.md` and `docs/08-active/worklogs/index.md` — active batch history and its shared index are append/update points that require intentional merge handling

## Before Initial Commit

If a repository has not reached its first commit yet, git worktree is not available as a practical isolation tool.

In that case, the only safe default is still one writable session per folder until the repository has a usable commit history.

This repository is already beyond that stage, so separate worktrees are available when needed.

## Recommended Default For This Repo

For current Login App 2.0 work:

* keep one writable implementation session in the shared repo folder
* allow one doc-review/change-queue writing session only when it is the designated writer for that workflow state
* keep other same-folder planning, review, and audit sessions in read-only mode
* move planning or documentation into its own branch and worktree only when it must edit concurrently with implementation and the operator explicitly accepts the added coordination cost
* if a read-only session becomes ready to write while the implementation session is still active, stop and fork that work into its own branch/worktree instead of editing in place

This repo should normally run with one batch work agent and one doc-review/change-queue writer. Broader parallelism is available only as an exception for clearly independent work.

## Examples

Safe:

* Session A implements Phase 2 Batch work in the shared folder
* Session B reviews the batch note and canonical docs in the shared folder without editing
* Session C prepares future Phase planning in notes or chat output only

Also safe:

* Session A implements code in the main shared folder
* Session B edits future planning docs in a separate branch and separate worktree

Unsafe:

* Session A edits `SESSION_INIT_PROMPTS.md` in the shared folder
* Session B edits a planning note in the same shared folder at the same time because both assume they are touching different files

## Related

* [Runbook Index](index.md)
* [Git Remote And Multi-Device Workflow](git-remote-and-multi-device-workflow.md)
* [Advisory Session Scope Claims](advisory-session-scope-claims.md)
* [Branch-Based Batch Integration](branch-based-batch-integration.md)
* [Implementation Status And Development Sync Standard](../02-standards/documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
* Codex Working Rules | [Codex Working Rules](../00-start-here.md)
