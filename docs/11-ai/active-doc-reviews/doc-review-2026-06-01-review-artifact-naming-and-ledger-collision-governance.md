# Document Review doc-review-2026-06-01-review-artifact-naming-and-ledger-collision-governance

## Review Pass
2

## Target
Review artifact naming and review-ledger collision governance across review skills and concurrency runbooks

## Review Type
Document Review

## Status
CLOSED

## Purpose
Replace future sequential review-artifact allocation with a merge-safer naming model that remains readable, sortable, and compatible with serialized review-ledger ownership in multi-worktree agent workflows.

## Scope
- `docs/11-ai/active-doc-reviews/index.md`
- `.agents/skills/review-document.md`
- `.agents/skills/review-docs-sync.md`
- `.agents/skills/implement-docs-fix.md`
- `.agents/skills/implement-docs-sync-fix.md`
- `docs/10-runbooks/agent-sessions-and-parallel-work.md`
- `docs/11-ai/active-doc-reviews/doc-review-2026-06-01-review-artifact-naming-and-ledger-collision-governance.md`

## Findings

### Finding 1
- type: sequential-review-artifact-collision
- location: `docs/11-ai/active-doc-reviews/index.md`, `.agents/skills/review-document.md`, `.agents/skills/review-docs-sync.md`
- issue: New review artifacts still depend on shared sequential numeric allocation, which creates avoidable filename collisions across parallel worktrees and makes later rebases repair review-file IDs instead of just merging scoped content.
- required action: Replace future `doc-review-####` and `doc-sync-####` allocation with a date-plus-slug naming model and document the same-day ordinal suffix rule for collisions.
- constraints: Preserve historical numeric files and rows as legacy records; do not rename archive history just to normalize the format.
- decision state: resolved

### Finding 2
- type: review-ledger-concurrency-overstatement
- location: `docs/10-runbooks/agent-sessions-and-parallel-work.md`
- issue: The concurrency note attributes review-ledger collisions primarily to sequential IDs, but the shared index remains a serialization point even after filename collisions are reduced. The rule should distinguish path-collision reduction from true multi-writer safety.
- required action: Update the concurrency guidance so it explains that date-plus-slug filenames reduce path collisions, while final review-file creation and `index.md` updates still require a single final writer.
- constraints: Keep the integrator/final-writer rule intact; do not imply that parallel review final writes are now safe.
- decision state: resolved

### Finding 3
- type: legacy-example-drift
- location: `.agents/skills/implement-docs-fix.md`, `.agents/skills/implement-docs-sync-fix.md`
- issue: The implementation skills still use numeric-only examples and route logic language, which would keep steering new work back toward the old allocation model even after the naming rule changes.
- required action: Update examples and routing language to accept the general `doc-review-*.md` / `doc-sync-*.md` patterns while preserving compatibility with legacy numeric records.
- constraints: Keep routing behavior unchanged; only normalize naming guidance and examples.
- decision state: resolved

## Summary
- The core problem is shared numeric allocation for new review artifacts, not the existence of historical numeric records.
- Date-plus-slug filenames reduce most cross-worktree path collisions without leaking worktree names into canonical history.
- The shared review index still requires serialized final writes even after the naming change.

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- new review artifact rules use date-plus-slug naming for future records
- legacy numeric review artifacts remain valid historical records
- review skills no longer instruct writers to allocate new sequential numeric review files
- concurrency guidance still requires serialized final review-ledger writes

## Resolution Notes
- Updated `docs/11-ai/active-doc-reviews/index.md` naming rules to preserve historical numeric records while switching new review artifacts to `YYYY-MM-DD` plus slug naming with optional same-day ordinal suffixes.
- Updated `.agents/skills/review-document.md` and `.agents/skills/review-docs-sync.md` so new review files derive a date-plus-slug filename instead of allocating the next sequential numeric ID.
- Updated `.agents/skills/implement-docs-fix.md` and `.agents/skills/implement-docs-sync-fix.md` examples so they accept the new naming model while remaining compatible with legacy numeric records.
- Updated `docs/10-runbooks/agent-sessions-and-parallel-work.md` so the concurrency rule now distinguishes reduced filename collisions from the still-serialized `index.md` final-write requirement.
- Re-review confirmed no remaining scoped drift in the touched naming-rule, review-skill, or concurrency-governance surfaces; future review artifacts now use the date-plus-slug model while final ledger writes remain serialized.
