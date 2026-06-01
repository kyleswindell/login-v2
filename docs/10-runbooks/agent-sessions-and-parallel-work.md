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
| Separate branches plus separate worktrees, multiple writers | Yes | each writer gets isolated worktree |
| Separate worker branches/worktrees plus serialized integration | Yes | worker branches stay out of `/docs/08-active/`; one integrator owns queue state and staging |
| Concurrent `batch-start` / `work-batch` on shared `/docs/08-active/` | No | current active workspace is singleton |
| Concurrent review-ledger final writes without serialization | No | sequential IDs and shared index can collide |
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

Use this only when two sessions must both write at the same time.

Required:

1. create or choose a branch for each writable task
2. create a separate worktree for each writable branch
3. open each worktree in its own VS Code workspace or window
4. keep commit scope narrow and merge only after each task completes

Best fit:

* implementation work plus documentation work that both must edit files concurrently
* two unrelated writable tasks that cannot wait on each other

### Mode B1 — Parallel Batch Implementation With Serialized Integration

Use this when multiple queue items from the same active batch must be implemented in parallel without letting multiple writers mutate the singleton `/docs/08-active/` workspace.

Required:

1. keep one integrator session as the only writer of `/docs/08-active/`
2. give each implementation session its own branch and its own worktree
3. have each worker session implement one queue item at a time and record a handoff artifact in `.agents/batch-branch-handoffs/`
4. keep worker-branch commits out of `/docs/08-active/`
5. have the integrator merge or cherry-pick reviewable worker branches one at a time, then update the shared active workspace and staging state

Best fit:

* multiple ready queue items that touch mostly separate code paths
* batches that benefit from concurrent implementation but still require serialized queue state, review ledgers, and staging ownership

Not allowed:

* workers directly updating `change-queue.md`, `review.md`, or other `/docs/08-active/` files
* more than one integrator writing `/docs/08-active/` or owning staging at the same time

### Codex App Worktree Path

When using the Codex app, prefer the app's built-in Worktree mode and Handoff flow as the first-class path for writable isolation.

Important limitation:

* one branch may only be checked out in one worktree at a time

Use manual `git worktree` commands as the fallback path when:

* the Codex app worktree flow is unavailable
* the repo is being operated outside the Codex app
* a manual Git workflow is explicitly preferred for the session

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

## Shared-Folder Rules

When multiple sessions use the same folder:

* only the designated writable session may edit files
* planning sessions should prefer read-only planning output unless they are the active writer
* review and audit sessions should report findings, not apply fixes, unless the writable role is explicitly handed over
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
6. `/phase-batch-close-out` finalizes the reviewed and approved batch, syncs deferments and scope updates into parent phase planning docs, and marks the batch complete.
7. `/phase-close-out` performs full phase finalization after relevant batch close-outs are complete.

Sign-off rules:

* implementation completion is not the same as sign-off
* a batch should not be marked complete until review passes and phase-batch-close-out updates the docs
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

For branch-based parallel batch execution:

* worker sessions may record queue-item scope and branch ownership in advisory claims
* worker claims should reference the matching handoff artifact under `.agents/batch-branch-handoffs/`
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

* `doc-review-####` and `doc-sync-####` IDs are sequential
* `docs/11-ai/active-doc-reviews/index.md` is a shared registry file

Supported review-writing rule:

* multiple review writers may work in separate worktrees
* final review-file creation and ledger update must be serialized

Until a different ID-allocation model is adopted, do not treat concurrent review-ledger final writes as safe in one shared folder.

## Worktree And Docker Compose Setup

This section covers the concrete steps for creating a second writable worktree with its own Docker Compose stack. Each worktree gets an isolated working tree and an isolated runtime so two agents can implement simultaneously without sharing files or database state.

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

```bash
# Create a new branch and a separate working directory in one step
git worktree add ../login-v2-agent-b feature/b-[batch-name]

cd ../login-v2-agent-b

# Copy .env from the primary worktree and update port values
cp ../login-v2/.env .env
# Edit .env — change APP_PORT, VITE_PORT, FORWARD_DB_PORT, FORWARD_REDIS_PORT,
# FORWARD_MAILPIT_PORT, and FORWARD_MAILPIT_DASHBOARD_PORT to B-series values above.
# DB_DATABASE can stay the same — each stack runs its own Postgres container.

# Start the stack with a distinct project name so Docker keeps volumes separate
docker compose --project-name login-v2-b up --build

# Run migrations in the new stack
docker compose --project-name login-v2-b exec app php artisan migrate
```

Open the worktree folder in a separate VS Code window (`File → Open Folder → ../login-v2-agent-b`) so each agent session has its own editor context, terminal history, and file state.

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
cd ../login-v2-agent-b
docker compose --project-name login-v2-b down --volumes

cd ../login-v2
git worktree remove ../login-v2-agent-b
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
* allow same-folder planning, review, and audit sessions only in read-only mode
* move planning or documentation into its own branch and worktree only when it must edit concurrently with implementation

This matches the existing pattern where one implementation agent is active while other sessions prepare future planning, audit contracts, or review current work.

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
