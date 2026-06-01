# Batch Branch Handoffs

Use this directory for worker-to-integrator handoff artifacts during branch-based parallel batch execution.

## Purpose

These files let a worker branch report a queue item's implementation state without writing to `/docs/08-active/`.

## Naming

One file per queue item:

* `P<phase>-<batch>-CQ-###.md`

Example:

* `P2-B-CQ-005.md`

## Minimum Fields

* `Queue ID`
* `Status`
* `Branch`
* `Worktree`
* `Base SHA`
* `Head SHA`
* `Scope`
* `Files Changed`
* `Tests Run`
* `Docs Sync`
* `Review Surface`
* `Merge Notes`

## Status Values

* `draft`
* `ready_for_integration`
* `integrated`
* `superseded`

## Rules

* Workers may update these files.
* Integrators may update status after merge or replacement.
* These files do not replace `/docs/08-active/`.
* Queue-state transitions remain integrator-owned.
