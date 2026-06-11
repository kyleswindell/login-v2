# Worklog 2-F-0028

Status: READY_FOR_REVIEW
Date: 2026-06-08

## Scope

- P2-F-CQ-118 - UI standards API-contract rewrite

## Changes

- Rewrote Foundation Element standards in `docs/02-standards/ui/elements/{element}.md` as installed Element API contracts.
- Rewrote Component standards in `docs/02-standards/ui/components/{component}.md` as installed Component API contracts using current UI Reference catalog metadata.
- Rewrote Pattern standards in `docs/02-standards/ui/patterns/{pattern}.md` as installed composition/API contracts.
- Updated UI standards indexes, checklists, and folder-level `AGENTS.md` guidance to define API-contract expectations, flat-file defaults, deferred/gated behavior, and UI Reference proof requirements.
- Reclassified `docs/02-standards/ui/contracts/` as transitional source material and updated the contract index accordingly.
- Added a focused UI Reference feature test that asserts Element, Component, and Pattern docs expose required API-contract sections.

## Validation

- Passed:
  - `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=ui_standards_docs_use_api_contract_sections`
  - `npm run lint:docs:guardrails`
  - targeted terminology/path scans for old `components/tier-1`, `components/tier-2-patterns`, and `canonical contracts` wording

Notes:

- `npm run lint:docs:guardrails` required approved escalation because Bash was denied in the sandbox; the escalated run completed successfully with existing WSL/rg permission warnings after the guardrail reported `Docs guardrail check passed`.
