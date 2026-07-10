<!--
DOC-META
title: Parallel Worktree Setup
doc_type: runbook
status: active
owner: ops
canonical: true
canonical_path: docs/10-runbooks/parallel-worktree-setup.md
parent: docs/10-runbooks/index.md
template: docs/09-reference/templates/docs/_runbook.md
summary: Defines manual branch and Git worktree creation, optional runtime isolation, handoff, integration, and cleanup for justified concurrent writable work.
-->

# Parallel Worktree Setup

Parent: [Runbook Index](index.md)

## Purpose

Create an isolated branch and working tree when concurrent writable work is justified.

## Use When

Use when:

- another writer owns the primary worktree
- the new task must proceed concurrently
- the scopes are independent
- shared-file writes can be serialized

Do not use for ordinary sequential work.

## Governing Standard

Read:

- [Agent Session Concurrency And Worktree Standards](../02-standards/coding-agents/Agent%20Session%20Concurrency%20And%20Worktree%20Standards.md)

## Prerequisites

Define:

    PRIMARY_REPO=<primary repository path>
    WORKTREE_ROOT=<worktree parent path>
    BRANCH=<new branch name>
    WORKTREE_PATH=<new worktree path>
    BASE_BRANCH=main

Confirm:

    git -C "$PRIMARY_REPO" status --short --branch
    git -C "$PRIMARY_REPO" worktree list

Stop if the primary worktree contains unknown changes relevant to the new task.

## Create A New Branch And Worktree

From a shell with Git:

    mkdir -p "$WORKTREE_ROOT"
    git -C "$PRIMARY_REPO" fetch origin
    git -C "$PRIMARY_REPO" worktree add -b "$BRANCH" "$WORKTREE_PATH" "origin/$BASE_BRANCH"

If the branch already exists:

    git -C "$PRIMARY_REPO" worktree add "$WORKTREE_PATH" "$BRANCH"

One branch may be checked out in only one worktree.

## Initialize The Worktree

Enter the worktree:

    cd "$WORKTREE_PATH"

Inspect:

    git status --short --branch
    git rev-parse HEAD

Copy local environment configuration only when authorized:

    cp "$PRIMARY_REPO/.env" .env

Do not commit `.env`.

## Optional Runtime Isolation

Use a unique Compose project name:

    COMPOSE_PROJECT=<unique-project-name>

Use unique host ports in the worktree `.env`.

Example port allocation:

| Service | Primary | Worker 1 | Worker 2 |
| --- | ---: | ---: | ---: |
| App | 8000 | 8001 | 8002 |
| Vite | 5173 | 5174 | 5175 |
| PostgreSQL | 5432 | 5433 | 5434 |
| Redis | 6379 | 6380 | 6381 |
| Mailpit SMTP | 1025 | 1026 | 1027 |
| Mailpit UI | 8025 | 8026 | 8027 |
| Reverb | 8080 | 8081 | 8082 |

Start only when required:

    docker compose --project-name "$COMPOSE_PROJECT" up --build -d

Run scoped verification.

Do not start a full worker stack when static checks or integration-lane testing are sufficient.

## Work Rules

The worktree owner must:

- implement only the assigned issue
- avoid unrelated cleanup
- avoid shared registry updates unless assigned
- run scoped verification
- commit reviewable work
- record handoff details

## Handoff

Record:

- issue
- branch
- worktree
- base SHA
- head SHA
- files changed
- tests run
- docs updated
- known conflicts
- runtime artifacts
- integration instructions

## Integration

In the integration worktree:

    git fetch origin
    git checkout "$BASE_BRANCH"
    git pull --ff-only origin "$BASE_BRANCH"

Review worker commits before merge or cherry-pick.

Run required verification after integration.

## Cleanup

Stop worker runtime when used:

    docker compose --project-name "$COMPOSE_PROJECT" down --volumes

From the primary repository:

    git -C "$PRIMARY_REPO" worktree remove "$WORKTREE_PATH"
    git -C "$PRIMARY_REPO" worktree prune

Delete the branch only after confirming it is merged or intentionally abandoned:

    git -C "$PRIMARY_REPO" branch -d "$BRANCH"

Use `-D` only with explicit authorization after preserving required work.

## Failure Handling

If worktree removal fails:

- inspect uncommitted changes
- stop running processes
- inspect ignored artifacts
- preserve required work
- use forced removal only when authorized

If a branch is already checked out elsewhere:

    git -C "$PRIMARY_REPO" worktree list

Locate and resolve the existing worktree rather than bypassing Git safety.

## Completion Criteria

The procedure is complete when:

- work is integrated or intentionally abandoned
- required verification passes
- worker runtime is stopped
- worktree is removed
- stale records are pruned
- advisory claims are released
- issue state is accurate

## Related

- [Multi-Device Repository Sync](multi-device-repository-sync.md)
- [Git Change Scope And Commit Standards](../02-standards/coding/Git%20Change%20Scope%20And%20Commit%20Standards.md)
