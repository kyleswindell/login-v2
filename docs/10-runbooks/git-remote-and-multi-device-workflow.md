# Git Remote And Multi-Device Workflow

This document defines the canonical scope and intent for Git Remote And Multi-Device Workflow.

## Purpose

Document the intended Git workflow for multi-device development and deployment.

## Current Direction

Preferred model:

* local machines push to GitHub
* GitHub acts as the source of truth
* the DigitalOcean server pulls from GitHub for deployment

This is preferred over using the server itself as the primary Git remote.

## Current Status

Configured remote:

* `origin`: `git@github.com:kyleswindell/login-v2.git`

Resolved:

* GitHub SSH now works in both Git Bash and WSL
* `main` has been pushed successfully
* upstream tracking has been established
* the server deploy user can authenticate to GitHub with a dedicated deploy key
* concurrent local agent workflow is now documented for same-folder and multi-worktree use

Canonical owner:

* [Platform Production Server Policy](../02-standards/security/platform-production-server-policy.md)

## Recommended Resolution

Preferred options:

1. continue using SSH for GitHub from local machines
2. keep GitHub as the source of truth for multi-device work

Recommended long-term direction:

* use SSH for GitHub if available

## Workflow Expectation

The intended normal workflow should be:

1. work locally
2. commit locally
3. push to GitHub
4. pull or deploy from GitHub to the server with the server deploy key

## Concurrent Agent Sessions

Preferred local rule:

* one writable session per working tree

When multiple sessions share the same local repo folder:

* one session may edit files
* other sessions should stay read-only and limit themselves to planning, review, audit, or research

When multiple sessions must both write:

* use a separate branch per writable task
* use a separate git worktree per writable task
* treat GitHub as the synchronization point before merge or handoff

When using the Codex app:

* prefer the app's built-in Worktree mode as the first-class writable-isolation path
* treat manual `git worktree` as the fallback path
* remember that one branch may only be checked out in one worktree at a time
* coordinate owned scope separately from worktree creation; worktrees provide isolation, not claim visibility

A manual checkout or lock file may be used only as an advisory note. It does not protect files from concurrent local edits.

## Agent Delivery Flow

Recommended prompt flow for planned work:

1. phase planning or phase batch planning establishes the scope and sequencing
2. batch development planning is optional when a batch still needs a delivery-ready implementation slice
3. phase batch implementation performs the scoped changes and prepares review handoff
4. phase batch review validates the diff against docs and tests before commit and push
5. phase close-out is the only step that should mark a batch or phase complete after review and manual QA

This keeps implementation, review, and final sign-off separate so a batch is not treated as complete just because code exists in the working tree.

## Related

* [Deployment Workflow](deployment-workflow.md)
* [Server Bootstrap](server-bootstrap.md)
* [Phase 0 Index](../07-planning/phases/phase-0/Phase 0 Index.md)
