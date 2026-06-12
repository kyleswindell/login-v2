# Worklog 2-F-0041 - Menu component correction

Date: 2026-06-09

## Queue Items

- P2-F-CQ-077 - Menu component correction

## Summary

Corrected the Menu Component API and UI Reference proof surface so Menu examples are normal closed, interactive controls by default, while static proof panels demonstrate item states, sizing, placement, checkable roles, submenu hooks, and title behavior without hiding reference-page helper content.

Follow-up review on 2026-06-12 corrected remaining Menu surface issues: the UI Reference page now shows visible menu proof panels for the primary examples instead of mostly closed triggers, disabled menu items receive a visibly distinct state, static submenu proof panels start collapsed, submenu rows no longer auto-expand from focus alone, and RTL submenu keyboard/placement behavior mirrors to the visual left side.

## Changes

- Updated `x-ui.menu` to support the documented API aliases and props: `triggerIcon`, `triggerVariant`, `placement`, `disabled`, `id`, and `menuLabel`.
- Changed `x-ui.menu` to default closed state and expose `data-ui-menu-open`, trigger, panel, placement, size, and accessibility attributes for proof and behavior testing.
- Updated `x-ui.menu-item` to expose documented role/state hooks for normal, disabled, danger, selected, checkable, shortcut, and submenu-boundary items.
- Updated menu JavaScript controls to open/close the component root state and handle `menuitem`, `menuitemcheckbox`, and `menuitemradio` focus targets.
- Added static proof panel support to the shared Component sample renderer so Menu page state/anatomy proofs do not force open the interactive menu.
- Corrected Menu catalog examples for contextual action, row action, grouped/selected state, sizing, alignment, truncation/title, and icon-only trigger proof.
- Fixed the Menu standard item data table to avoid malformed Markdown pipe syntax.
- Strengthened focused Menu recovery tests to assert closed examples, roles, placement, sizing, checkable roles, submenu hooks, title text, and no forced-open menu state.
- Follow-up strengthened submenu behavior so opening a parent menu or focusing a submenu row does not expand the child panel, while pointer/click/arrow interaction still opens it.
- Follow-up tightened disabled item CSS and RTL submenu placement/keyboard handling.
- Synced the active queue so P2-F-CQ-077 is Implemented Pending Review and P2-F-CQ-079 Button is the next Ready To Implement correction.

## Files Updated

- `app/Platform/UiReference/UiReferenceComponentDepthCatalog.php`
- `docs/02-standards/ui/components/menu.md`
- `docs/08-active/change-queue.md`
- `docs/08-active/checklist.md`
- `docs/08-active/notes.md`
- `docs/08-active/review.md`
- `docs/08-active/ui-implementation-sync.md`
- `docs/08-active/worklogs/index.md`
- `docs/08-active/worklogs/worklog-2-F-0041.md`
- `resources/css/app.css`
- `resources/js/ui-controls/menus.js`
- `resources/views/components/ui/menu.blade.php`
- `resources/views/components/ui/menu-item.blade.php`
- `resources/views/platform/ui-reference/components/examples/sample.blade.php`
- `tests/Feature/Platform/PlatformUiReferenceTest.php`

## Validation

- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=menu_component_recovery` passed.
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=component_public_api_wrappers` passed.
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=component` passed.
- `npm run build` passed after unsandboxed rerun; the sandboxed attempt failed on native Tailwind dependency access.
- `npm run lint:docs:guardrails` passed after unsandboxed rerun; the sandboxed attempt failed on Bash/WSL access and the passing run reported existing WSL/rg permission warnings.

## Review Surface

- Local authenticated route/content tests for `/platform/ui-reference/components/menu`.
- Manual review should confirm the Menu page renders closed interactive controls by default and uses static proof panels only for item-state/anatomy proof.

## Next Queue Item

- P2-F-CQ-079 - Button component correction
