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

## Critical: Planning Notes Are Working Documents

Planning notes must be treated as living working documents, not frozen pre-implementation specifications.

During implementation, update the planning note whenever:

* significant implementation approach diverges from the plan (document the new approach and why)
* scope is adjusted (additions, deferrals, or stretches recorded)
* architectural decisions change (updated with new direction and rationale)
* unforeseen constraints or learnings emerge (recorded for next phase)

This prevents planning notes from becoming stale and ensures the planning artifact captures not just the original intent, but the actual journey and decisions made during implementation.

Failure to update planning notes during implementation causes:

* canonical docs and development logs to become the only source of truth for decisions
* loss of institutional knowledge about why paths were changed
* stale planning notes that are useless as reference for future phases

## Required Documentation Layers

For any implemented system, keep these layers aligned:

* `Planning`: sequencing, intent, scope, open questions, and current implementation status
* `Canonical system doc`: current implementation, important files, data model, workflows, and known gaps
* `Development log`: chronological milestone record, what changed, staging status, and follow-up work

Expected synchronization during implementation:

* Planning note is updated when significant divergence from the plan occurs or decisions change
* Development log is updated as work progresses and milestones complete
* Canonical system doc is updated when batch closes or major features ship

By phase closeout, all three should converge:

* Planning note reflects both original plan intent AND actual path taken, including variances and why
* Development log provides chronological work record and testing results
* Canonical system doc represents the final shipped implementation state

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

## Module Planning Contract Rule

For any new Phase 3+ module planning note, include a UI ownership declaration matrix before implementation starts.

Minimum required fields per surface:

* current owner
* target owner
* route owner at delivery
* required permissions/policies
* parity checks
* transitional alias/deprecation behavior

If a module note omits this matrix, implementation should not be treated as planning-complete.

## Close-Out Gate

Before implementation work is considered complete, all of the following must be true:

* planning note updated to reflect final decisions and any variances from original plan (planning notes are complete working artifacts, not frozen pre-implementation specs)
* code done
* canonical doc updated to represent final implementation
* development log updated with milestone completion and testing results

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
