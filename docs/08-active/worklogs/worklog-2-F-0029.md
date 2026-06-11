# Worklog 2-F-0029

Status: READY_FOR_REVIEW
Date: 2026-06-08

## Scope

- P2-F-CQ-119 - Foundation 2x Grid canonical slug cleanup

## Changes

- Updated `UiReferenceElementCatalog` so `2x-grid` is the canonical Foundation Element slug and `grid` remains a compatibility alias.
- Updated canonical Element, Component, Pattern, and spacing links to use `/platform/ui-reference/elements/2x-grid` and `docs/02-standards/ui/elements/2x-grid.md`.
- Removed the duplicate `docs/02-standards/ui/elements/grid.md` standard.
- Updated UI Reference tests so `/platform/ui-reference/elements/2x-grid` is the canonical route and `/platform/ui-reference/elements/grid` remains a compatibility route.
- Synced active queue language for P2-F-CQ-042 so it no longer describes `grid.md` as canonical.

## Validation

- Passed:
  - `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=foundation`
  - `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=ui_standards_docs_use_api_contract_sections`
  - `npm run lint:docs:guardrails`
  - targeted scans for stale `grid.md`, `/elements/grid`, and `elements%2Fgrid` canonical references

Notes:

- `/platform/ui-reference/elements/grid` intentionally remains covered as a compatibility alias in the focused Foundation test.
- `npm run lint:docs:guardrails` required approved escalation because Bash was denied in the sandbox; the escalated run completed successfully with existing WSL/rg permission warnings after the guardrail reported `Docs guardrail check passed`.
