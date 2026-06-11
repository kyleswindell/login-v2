# Worklog 2-F-0027

Status: READY_FOR_REVIEW
Date: 2026-06-08

## Scope

- P2-F-CQ-117 - UI standards component and pattern path realignment

## Changes

- Flattened Component standards from `docs/02-standards/ui/components/tier-1/` into `docs/02-standards/ui/components/{component}.md`.
- Moved Pattern standards from `docs/02-standards/ui/components/tier-2-patterns/` into `docs/02-standards/ui/patterns/{pattern}.md`.
- Renamed the Component and Pattern checklist hubs to `components/checklist.md` and `patterns/checklist.md`.
- Added `docs/02-standards/ui/patterns/AGENTS.md` and updated UI standards read guidance.
- Updated UI standards indexes, checklists, pattern boundary guidance, and supporting reference links to the new folder model.
- Updated UI Reference component catalog doc metadata so Component pages link to the new canonical doc paths.
- Normalized current UI Reference labels and disposition badges from T1/T2 terminology to Components/Patterns.

## Validation

- Passed:
  - `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=component`
  - `npm run lint:docs:guardrails`

Notes:

- `npm run lint:docs:guardrails` required approved escalation because Bash was denied in the sandbox; the escalated run completed successfully with existing WSL/rg permission warnings after the guardrail reported `Docs guardrail check passed`.
