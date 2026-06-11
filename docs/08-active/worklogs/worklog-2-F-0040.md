# Worklog 2-F-0040 - Component recovery sequencing

Date: 2026-06-09

## Queue Items

- P2-F-CQ-129 - Component recovery review and correction sequencing

## Summary

Implemented the P2-F-CQ-129 sequencing gate after Component UI Reference API proof sync. This pass does not approve or correct individual component pages; it makes the remaining recovery work explicit and ordered so future passes cannot skip from broad proof sync into starter work or leave unresolved Component pages hidden in the sync matrix.

## Changes

- Moved P2-F-CQ-129 to Implemented Pending Review.
- Made P2-F-CQ-077 Menu the next Ready To Implement correction.
- Moved Button correction behind Menu and Menu buttons behind Button.
- Added explicit blocked queue items P2-F-CQ-136 through P2-F-CQ-163 for the remaining unresolved Component API proof/recovery and disposition work.
- Added a P2-F-CQ-129 recovery sequence table to `docs/08-active/ui-implementation-sync.md`.
- Synced `checklist.md`, `notes.md`, and `review.md` so starter work remains blocked behind the component recovery queue rather than only the proof-sync gate.

## Recovery Order

1. Manual review pending: Breadcrumb, Tabs, Code snippet.
2. Correct next: Menu.
3. Correct after Menu: Button, then Menu buttons.
4. Continue through installed API proof pages.
5. Continue through needs-audit source/API pages.
6. Prove deferred or represented-by-pattern dispositions.
7. Resolve adjacent component ownership gaps.

## Validation

- `npm run lint:docs:guardrails` passed after unsandboxed rerun.
- The sandboxed guardrail attempt failed with the known Bash access-denied error; the passing run still reported existing WSL/rg permission warnings.

## Notes

- P2-F-CQ-129 is a sequencing and queue-normalization pass only.
- P2-F-CQ-077 is the next implementation item.
- P2-F-CQ-002 through P2-F-CQ-006 remain blocked until the component recovery queue reaches a starter-safe state.
