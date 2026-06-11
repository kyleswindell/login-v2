# Worklog 2-F-0043 - Menu buttons component correction

Date: 2026-06-09

## Queue Items

- P2-F-CQ-093 - Menu buttons component correction

## Summary

Corrected the Menu buttons Component API and UI Reference proof surface so Menu button, Combo button, and Overflow menu render as distinct installed APIs with closed interactive examples, explicit state/anatomy proof, size alignment, width rules, keyboard behavior, and canonical developer snippets.

## Changes

- Updated `x-ui.menu-button` to expose documented `type`, `variant`, `placement`, loading, size, and menu-button data markers while delegating behavior to `x-ui.menu`.
- Updated `x-ui.combo-button` to expose a primary action plus split menu trigger with documented data hooks, loading/disabled handling, and placement support.
- Updated `x-ui.overflow-menu` to expose icon-only overflow behavior with accessible naming, tooltip text, placement support, and overflow data markers.
- Added menu-button, combo-button, and overflow-menu CSS namespaces to the shared component style surface.
- Added a Menu buttons live-example matrix covering variant purposes, base options, trigger styles, size scale, placement/width rules, states/keyboard behavior, content boundaries, and token-backed developer implementation examples.
- Updated the Menu buttons catalog to use the flexible matrix live-example view and mark the page as `Implemented - pending manual review`.
- Updated the Menu buttons standard so `x-ui.combo-button` is an approved installed API instead of a gated placeholder.
- Strengthened focused Menu buttons recovery tests to assert installed API markers, size/width behavior, keyboard rules, base variants, developer examples, and no generic fallback text.
- Synced active batch state so P2-F-CQ-093 is Implemented Pending Review and P2-F-CQ-136 Link is the next Ready To Implement item.

## Files Updated

- `app/Platform/UiReference/UiReferenceComponentDepthCatalog.php`
- `docs/02-standards/ui/components/menu-buttons.md`
- `docs/08-active/change-queue.md`
- `docs/08-active/checklist.md`
- `docs/08-active/notes.md`
- `docs/08-active/review.md`
- `docs/08-active/ui-implementation-sync.md`
- `docs/08-active/worklogs/index.md`
- `docs/08-active/worklogs/worklog-2-F-0043.md`
- `resources/css/app.css`
- `resources/views/components/ui/combo-button.blade.php`
- `resources/views/components/ui/menu-button.blade.php`
- `resources/views/components/ui/overflow-menu.blade.php`
- `resources/views/platform/ui-reference/components/live-examples/menu-buttons.blade.php`
- `tests/Feature/Platform/PlatformUiReferenceTest.php`

## Validation

- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=menu_buttons_component_recovery` passed.
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=component_public_api_wrappers` passed.
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=component` passed.
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php` passed.
- `npm run build` passed after unsandboxed rerun; the sandboxed attempt failed on native Tailwind/Vite dependency access.
- `npm run lint:docs:guardrails` passed after unsandboxed rerun; the sandboxed attempt failed on Bash/WSL access and the passing run reported existing WSL/rg permission warnings.

## Review Surface

- Local authenticated route/content test for `/platform/ui-reference/components/menu-buttons`.
- Manual review should confirm base Menu button, Combo button, and Overflow menu examples start closed and interactive, while open-state examples are scoped as explicit proof.

## Next Queue Item

- P2-F-CQ-136 - Link component API proof and recovery
