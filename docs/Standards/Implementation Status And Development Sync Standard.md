# Implementation Status And Development Sync Standard

## Purpose

Define the minimum documentation sync process that must happen as planned systems are implemented.

This standard exists to prevent planning notes, permanent system docs, and real code from drifting out of sync.

## Core Rule

When a planned system is implemented or materially changed:

* update the canonical system doc in the same work cycle
* update the linked planning note in the same work cycle
* update the relevant phase development log in the same work cycle

The work is not documentation-complete until those three layers agree on the current status.

## Required Documentation Layers

For any implemented system, keep these layers aligned:

* `Planning`: sequencing, intent, scope, open questions, and current implementation status
* `Canonical system doc`: current implementation, important files, data model, workflows, and known gaps
* `Development log`: chronological milestone record, what changed, staging status, and follow-up work

## Required Implementation Status Content

Planning notes and canonical system docs must state current status clearly enough to answer:

* is this still planned only?
* is it implemented in code?
* is it migrated or deployed on staging?
* is there a usable UI yet?
* what known gaps remain?

Recommended status headings:

* `Implementation Status`
* `Current Implementation`
* `Known Gaps`

## Required Linking Pattern

To keep the Obsidian graph usable:

* planning notes must link to the canonical system doc
* canonical system docs must link back to the source planning note
* phase development logs must link to both the planning note and canonical system doc
* index notes must be updated when a new canonical system doc or development log is added

## Required Development Logs

Each active implementation phase should maintain a development log branch under:

* `docs/V2 App/Development/`

Minimum expectation:

* one phase index note or development index
* one current phase log note

Each log entry should capture:

* date
* milestone or batch name
* implementation status
* relevant commit or deployment note when useful
* canonical docs touched
* follow-up work

## Review Rule

Before a phase batch is treated as complete, confirm:

* planning notes reflect the implemented state
* canonical docs reflect the implemented state
* the development log records the milestone
* indexes and graph links are updated

## Close-Out Gate

Before implementation work is considered complete, all of the following must be true:

* code done
* canonical doc updated
* planning note updated
* development log updated

## Commit Policy

Documentation sync must be committed in the same working session as the implementation work.

Required pattern:

* use a single commit that includes code plus documentation sync changes
* or, if separation is preferred, use a documentation-only follow-up commit in the same session immediately after the code commit

Do not leave implementation and documentation status updates uncommitted across sessions.

## Related

* [[Standards/Documentation Review Standards]] | [Documentation Review Standards](Documentation%20Review%20Standards.md)
* [[Documentation Standards/How To Write Docs]] | [How To Write Docs](../Documentation%20Standards/How%20To%20Write%20Docs.md)
* [[Codex/Codex Working Rules]] | [Codex Working Rules](../Codex/Codex%20Working%20Rules.md)
