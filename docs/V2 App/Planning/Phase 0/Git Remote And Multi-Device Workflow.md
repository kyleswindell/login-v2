# Git Remote And Multi-Device Workflow

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

* [[V2 App/Runbooks/Agent Sessions And Parallel Work]] | [Agent Sessions And Parallel Work](../../Runbooks/Agent%20Sessions%20And%20Parallel%20Work.md)

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

A manual checkout or lock file may be used only as an advisory note. It does not protect files from concurrent local edits.

## Related

* [[V2 App/Planning/Phase 0/Phase 0 Index]] | [Phase 0 Index](Phase%200%20Index.md)
* [[V2 App/Planning/Phase 0/Deployment Workflow]] | [Deployment Workflow](Deployment%20Workflow.md)
* [[V2 App/Runbooks/Agent Sessions And Parallel Work]] | [Agent Sessions And Parallel Work](../../Runbooks/Agent%20Sessions%20And%20Parallel%20Work.md)
