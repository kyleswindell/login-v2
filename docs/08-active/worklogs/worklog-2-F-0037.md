# Worklog 2-F-0037

## Summary

Implemented P2-F-CQ-132 through P2-F-CQ-134 for the updated UI standards reconciliation pass.

The pass reconciled the numbered UI standards with the durable API registry, folder indexes, active implementation sync, and queue sequencing. The standards remain the target API contracts; active implementation state remains in `docs/08-active/`.

## Queue Items

- P2-F-CQ-132 - UI standards registry and index reconciliation
- P2-F-CQ-133 - Substantial UI standards update audit
- P2-F-CQ-134 - UI implementation sync refresh from updated standards

## Changes

- Updated `docs/02-standards/ui/api-registry.md` and `components/index.md` so newly promoted target APIs are marked `Approved API`: Contained list, List, Multiselect, Popover, Slider/Range slider, and Tree view.
- Kept still-gated/disposition-only APIs explicit: Pictograms remains asset/API gated, AI label remains do-not-implement, Content switcher remains deferred, and Form/UI shell remain represented by Pattern owners.
- Removed stale deleted-token-folder guidance from `docs/02-standards/ui/AGENTS.md`.
- Normalized stale planned-route references in Component and Pattern standards to current owner routes or registry-gap language.
- Corrected malformed Markdown tables in promoted Component standards by replacing union `|` values with `/` separators.
- Refreshed `docs/08-active/ui-implementation-sync.md` so missing source APIs are tracked as implementation work, not hidden behind registry disposition.
- Added P2-F-CQ-135 as the next ready installation pass and blocked P2-F-CQ-128/P2-F-CQ-129 until newly approved APIs are installed or mapped.

## Validation

- Targeted stale route/deleted-token scan passed for active standards and implementation sync.
- Targeted promoted API disposition scan passed for registry and component index.
- Targeted malformed table scan passed for touched promoted Component standards.
- `npm run lint:docs:guardrails` passed after escalated rerun; the sandboxed attempt failed with the known Bash access denial.

## Notes

- Registry entries are durable target inventory only. Source/proof status for newly approved APIs is tracked in `docs/08-active/ui-implementation-sync.md`.
- P2-F-CQ-135 must run before UI Reference proof sync resumes.
