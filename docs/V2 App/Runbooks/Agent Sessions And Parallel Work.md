# Agent Sessions And Parallel Work

## Purpose

Define the safe operating model for running multiple agent sessions against Login V2 without overlapping writes, silent file overwrites, or ambiguous handoff state.

## Planning Source

* [[V2 App/Planning/Phase 0/Git Remote And Multi-Device Workflow]] | [Git Remote And Multi-Device Workflow](../Planning/Phase%200/Git%20Remote%20And%20Multi-Device%20Workflow.md)

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

If any of these are unclear, do not start writing.

## Shared-Folder Rules

When multiple sessions use the same folder:

* only the designated writable session may edit files
* planning sessions should prefer read-only planning output unless they are the active writer
* review and audit sessions should report findings, not apply fixes, unless the writable role is explicitly handed over
* do not treat uncommitted local changes as completed work until the writer closes out or explicitly hands off the state

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

Do not rely on this as protection. It documents intent only.

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
* `docs/V2 App/Planning/Phase X/Phase X Index.md` — both batches update implementation status sections
* `docs/V2 App/Development/Phase X Development Log.md` — both batches append log entries; append-only merges are usually conflict-free if entries are dated

## Before Initial Commit

If a repository has not reached its first commit yet, git worktree is not available as a practical isolation tool.

In that case, the only safe default is still one writable session per folder until the repository has a usable commit history.

This repository is already beyond that stage, so separate worktrees are available when needed.

## Recommended Default For This Repo

For current Login V2 work:

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

* [[V2 App/Runbooks/Runbook Index]] | [Runbook Index](Runbook%20Index.md)
* [[V2 App/Planning/Phase 0/Git Remote And Multi-Device Workflow]] | [Git Remote And Multi-Device Workflow](../Planning/Phase%200/Git%20Remote%20And%20Multi-Device%20Workflow.md)
* [[Standards/Implementation Status And Development Sync Standard]] | [Implementation Status And Development Sync Standard](../../Standards/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
* [[Codex/Codex Working Rules]] | [Codex Working Rules](../../Codex/Codex%20Working%20Rules.md)