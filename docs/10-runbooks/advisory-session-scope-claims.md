# Advisory Session Scope Claims

This document defines the canonical scope and intent for advisory session scope claims.

## Purpose

Explain when to use the repo's advisory session-claim workflow, what it does, and what it does not do.

## Scope

Coordination guidance only. This runbook does not change the core safety rule that one shared working tree may have only one writable session at a time.

## Canonical State File

Advisory claim state for this repo is stored in:

* `.agents/session-scope-claims.json`

That file records intent only.

It is not:

* a file lock
* a write permission system
* proof that same-folder concurrent writes are safe

## When To Use Advisory Claims

Use advisory claims when a session needs visible ownership notes for a writable scope and another operator or agent may inspect, hand off, or coordinate around that scope.

Typical use cases:

* a writable session is starting and wants to declare its intended scope
* a second session needs to check whether an overlapping writable claim already exists
* a writable session is handing work off and should release or correct its claim
* multiple writable sessions are running in separate worktrees and need lightweight visibility into who owns which scope

For active batch execution:

* `batch-start` and `work-batch` should record the owned scope as the whole `/docs/08-active/` workspace
* a CQ item ID may be included only as descriptive context about the current focus

## When Not To Use Advisory Claims

Do not treat advisory claims as a substitute for the actual concurrency model.

Do not use them to justify:

* multiple writable sessions in the same shared folder
* concurrent `batch-start` or `work-batch` runs against the singleton `/docs/08-active/` workspace
* concurrent final writes to the review ledger and shared review index

If the work requires safe concurrent writes, use separate branches and separate worktrees per the parallel-work runbook.

## The Three Claim Skills

The advisory workflow uses three repo-local skills:

* `check-session-scope-conflicts`
* `claim-session-scope`
* `release-session-scope`

### `check-session-scope-conflicts`

Use before writable work when the session needs to inspect the advisory registry for overlapping scope claims.

Best fit:

* before starting a writable session in a shared repo
* before handing off writable ownership
* before starting a second writable session in a separate worktree that may touch nearby scope

### `claim-session-scope`

Use when a writable session is beginning and should record its intended scope, branch, worktree, and ownership note.

Best fit:

* writable implementation session startup
* writable documentation session startup in a separate worktree
* explicit handoff where the new writer becomes the active owner

### `release-session-scope`

Use when a writable session finishes, hands off, or discovers that its recorded claim is stale or inaccurate.

Best fit:

* writable session close-out
* branch/worktree handoff
* correcting stale or abandoned advisory entries

## Recommended Workflow

For writable coordination that benefits from visibility:

1. run `check-session-scope-conflicts`
2. if the planned scope is acceptable, run `claim-session-scope`
3. perform the scoped work using the correct branch, worktree, and workflow rules
4. run `release-session-scope` when the writable session closes out or hands off

## Relationship To Repo Safety Rules

Advisory claims complement the existing operating model. They do not replace it.

Still required:

* one writable session per shared working tree
* separate worktrees for concurrent writers
* serialized review-ledger final writes
* singleton ownership of `/docs/08-active/` batch-state updates

Not implied:

* a CQ item note inside an advisory claim does not create a supported item-level lock model for shared active-batch execution

## Related

* [Runbook Index](index.md)
* [Agent Sessions And Parallel Work](agent-sessions-and-parallel-work.md)
