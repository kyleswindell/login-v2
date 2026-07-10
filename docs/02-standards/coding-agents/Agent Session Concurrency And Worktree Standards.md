<!--
DOC-META
title: Agent Session Concurrency And Worktree Standards
doc_type: standard
status: active
owner: ai
canonical: true
canonical_path: docs/02-standards/coding-agents/Agent Session Concurrency And Worktree Standards.md
parent: docs/02-standards/coding-agents/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines writable-session ownership, worktree isolation, advisory scope claims, shared-resource serialization, handoff, and cleanup requirements for coding-agent work.
-->

# Agent Session Concurrency And Worktree Standards

Parent: [Coding Agent Standards Index](index.md)

## 1. Purpose

Define the safe concurrency model for human and coding-agent sessions working in the Login 2.0 repository.

This standard promotes durable governance formerly mixed into operational runbooks. It does not define a batch system or active documentation workspace.

## 2. Core Rule

One writable session may own one working tree at a time.

Multiple sessions may inspect the same working tree when:

- only one session writes
- all other sessions remain read-only
- read-only sessions do not create memory, review, planning, or documentation files in that working tree
- writable ownership is handed off explicitly before another session edits

Touching different files does not make concurrent writes safe in one working tree.

## 3. Supported Modes

| Mode | Supported | Requirement |
| --- | --- | --- |
| One writer in one working tree | Yes | Default mode |
| One writer plus read-only sessions in the same working tree | Yes | Read-only sessions must not edit |
| Multiple writers in separate branches and worktrees | Yes, when justified | Each writer has explicit scope and isolated worktree |
| Multiple writers in one working tree | No | Stop and isolate the work |
| Multiple sessions writing one shared registry or index concurrently | No | Serialize final writes |
| Multiple branches deploying to one shared staging target concurrently | No | One staging owner at a time |

## 4. Session Classification

Before work begins, classify the session as:

- read-only
- writable
- integrator
- deployment owner
- specialist reviewer

A read-only session becoming writable must stop before editing and confirm:

- current branch
- current worktree path
- working-tree state
- existing writer
- owned file scope
- required branch or worktree isolation

## 5. Writable Ownership

A writable owner must identify:

- task or issue
- branch
- worktree
- allowed files or directories
- shared files that require serialization
- expected handoff state
- whether commit, push, Project updates, or deployment are authorized

Writable ownership is procedural coordination, not a Git lock.

## 6. Worktree Isolation

Use a separate branch and worktree when:

- another writer already owns the primary worktree
- work must proceed concurrently
- the tasks are independent enough to merge safely
- shared files can be serialized
- the coordination cost is justified

Do not create a worktree merely to avoid discussing scope.

Use:

- [Parallel Worktree Setup](../../10-runbooks/parallel-worktree-setup.md)

## 7. Codex Worktree Use

Codex-managed worktrees and manually created Git worktrees provide file isolation.

They do not automatically provide:

- issue ownership
- file-scope ownership
- deployment ownership
- conflict prevention on shared indexes
- permission to commit, push, merge, or deploy

Use the product-supported worktree path when available. Use manual Git worktrees when the product path is unavailable or explicit manual control is required.

## 8. Advisory Scope Claims

Advisory claims may record:

- session name
- branch
- worktree
- issue
- owned scope
- expected handoff
- expiration or review time

The repository claim file may be:

- `.agents/session-scope-claims.json`

Claims are not:

- file locks
- write permissions
- proof that same-folder writes are safe
- substitutes for branches and worktrees
- substitutes for issue assignment

A stale claim must be corrected or removed.

## 9. Shared-Resource Serialization

Serialize writes to shared resources such as:

- branch indexes
- decision identifier registries
- review registries
- planning matrices
- shared staging
- release state
- migration sequence files
- root routing files

The final writer must inspect the latest branch state before updating a shared resource.

## 10. Branch Scope

Each writable branch should map to:

- one issue or tightly coupled issue set
- one primary concern
- one explicit owner
- one reviewable outcome

Do not use a worker branch to perform unrelated cleanup.

Do not combine independent worker scopes into one implementation commit.

## 11. Handoff

A writable handoff must identify:

- task or issue
- branch
- worktree
- base commit
- current head commit
- files changed
- verification run
- documentation synchronized
- known conflicts
- remaining work
- whether the worktree is clean
- next authorized action

Do not treat uncommitted changes as durable handoff evidence unless the recipient is explicitly taking ownership of the same worktree.

## 12. Merge And Integration

Before integration:

- fetch the latest target branch
- inspect worker commits
- inspect changed files
- review shared-file conflicts
- run required verification after integration
- update the issue and canonical docs as authorized

Only the designated integration owner should resolve competing shared-state updates.

## 13. Shared Staging

One branch owns shared staging at a time.

Before deploying a review branch:

- identify the staging owner
- identify the branch
- record the prior staging branch or commit
- define restoration to the normal staging source
- prevent another deployment until ownership is released

Advisory claims do not override this rule.

## 14. Runtime And Dependency Footprint

Disposable worker worktrees should remain lightweight.

Prefer:

1. existing dependencies
2. static checks
3. targeted tests
4. integration-lane runtime verification
5. worker-local dependency installation only when required

When a worktree creates Docker volumes or large ignored artifacts, record and remove them during cleanup.

## 15. Cleanup

After integration or abandonment:

- confirm no uncommitted work is needed
- stop worktree-specific services
- remove worktree-specific Docker volumes when created
- remove the worktree
- prune stale worktree records
- delete the branch only after confirming it is merged or intentionally abandoned
- release advisory claims
- update handoff or issue state

## 16. Prohibited Practices

Do not:

- run concurrent writers in one working tree
- treat issue assignment as a file lock
- treat advisory claims as enforcement
- let workers modify shared registries without coordination
- let multiple branches own shared staging
- broaden permissions to make concurrency easier
- create worktrees without a cleanup owner
- allow an unbound child agent to write outside its assigned worktree
- preserve deprecated batch-workflow assumptions

## 17. Stop Conditions

Stop when:

- another writer owns the same working tree
- scope overlaps materially
- branch or worktree identity is unclear
- the target branch is not known
- shared-file ownership is unresolved
- staging ownership is unresolved
- merge consequences are unclear
- uncommitted work may be overwritten
- cleanup would remove unreviewed work

## 18. Related

- [Coding Agent Standards Index](index.md)
- [Agent Context And Retrieval Standards](Agent%20Context%20And%20Retrieval%20Standards.md)
- [Repo-Local Agent Memory Standards](Repo-Local%20Agent%20Memory%20Standards.md)
- [Git Change Scope And Commit Standards](../coding/Git%20Change%20Scope%20And%20Commit%20Standards.md)
- [Parallel Worktree Setup](../../10-runbooks/parallel-worktree-setup.md)
- [Multi-Device Repository Sync](../../10-runbooks/multi-device-repository-sync.md)
