<!--
DOC-META
title: Multi-Device Repository Sync
doc_type: runbook
status: active
owner: ops
canonical: true
canonical_path: docs/10-runbooks/multi-device-repository-sync.md
parent: docs/10-runbooks/index.md
template: docs/09-reference/templates/docs/_runbook.md
summary: Defines safe branch synchronization and handoff when Login 2.0 work moves between development devices.
-->

# Multi-Device Repository Sync

Parent: [Runbook Index](index.md)

## Purpose

Safely transfer active repository work between development devices through GitHub.

## Prerequisites

- GitHub remote configured
- correct SSH or credential configuration
- known working branch
- no unowned local changes
- authorization to commit and push

## Before Leaving The Current Device

Inspect:

    git status --short --branch
    git diff
    git diff --staged

Run required verification.

Stage explicit paths and commit:

    git add <explicit-paths>
    git commit -m "<scoped message>"

Push:

    git push -u origin <branch>

Record:

- branch
- head SHA
- issue
- verification
- uncommitted local-only work

Do not switch devices with required work existing only as uncommitted files.

## On The Next Device

Inspect the local repository:

    git status --short --branch

Stop if it contains unknown changes.

Fetch:

    git fetch origin --prune

Check out the branch:

    git checkout <branch>

Update with fast-forward only:

    git pull --ff-only origin <branch>

Verify:

    git rev-parse HEAD
    git status --short --branch

## Continuing Work

Before editing:

- confirm the expected commit
- confirm the issue scope
- confirm no other device is still writing the same branch
- confirm local dependencies and environment state

## Returning To Main

After reviewed work is merged:

    git checkout main
    git pull --ff-only origin main
    git branch -d <branch>

Delete the remote branch only when authorized and no longer needed.

## Failure Handling

If `pull --ff-only` fails:

- do not use a merge pull automatically
- fetch and inspect divergence
- determine which device owns unpublished work
- rebase or merge only with explicit intent
- preserve both histories before resolving

If SSH fails:

- test the configured GitHub host
- verify the key and agent
- do not place private keys in the repository

## Stop Conditions

Stop when:

- the local working tree is dirty with unknown work
- the branch diverged unexpectedly
- another device may still be writing
- a force push would be required
- credentials or remote identity are uncertain

## Completion Criteria

Sync is complete when:

- expected branch is checked out
- expected head commit is present
- working tree is understood
- issue scope is known
- no concurrent device writer remains

## Related

- [Parallel Worktree Setup](parallel-worktree-setup.md)
- [Git Change Scope And Commit Standards](../02-standards/coding/Git%20Change%20Scope%20And%20Commit%20Standards.md)
