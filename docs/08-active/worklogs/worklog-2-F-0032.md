# Worklog 2-F-0032

## Summary

Implemented `P2-F-CQ-121 - Remaining component standards review correction`.

This pass corrected remaining Component API standards blockers found during review so the docs can drive UI Reference and implementation work more reliably.

## Scope

- Corrected malformed Markdown tables in Component standards by normalizing union-style values to slash-separated text and restoring consistent table column counts.
- Moved the full Tabs API contract back to `docs/02-standards/ui/components/tabs.md`.
- Replaced the accidental Tabs copy in `docs/02-standards/ui/components/tag.md` with a Tag API standard that owns the Tag/Badge/Status boundary.
- Updated deferred AI label and Content switcher docs so they do not show `Component-specific API pending correction` as an example call.
- Updated component docs to route planned table-toolbar, page-header, filters/search-filter, and scheduling references through current Pattern owner routes.
- Updated `docs/02-standards/ui/api-registry.md` so planned Pattern APIs remain visible as registry gaps with known references and current owner routes.
- Updated `docs/02-standards/ui/AGENTS.md` to point agents to the current UI standards index.
- Added grouped follow-up API installation queue items for standards-defined public APIs that implementation still needs to catch up to.

## Validation

- Targeted component table scan: passed.
- Component file/H1/frontmatter identity scan: passed.
- Stale planned Pattern route scan: passed.
- Stale UI standards guidance scan: passed.
- Deferred placeholder check confirmed AI label and Content switcher no longer render placeholder example calls.

## Review Surface

- Canonical standards docs under `docs/02-standards/ui/components/`.
- UI API registry under `docs/02-standards/ui/api-registry.md`.
- Active queue entries `P2-F-CQ-121` through `P2-F-CQ-127`.
