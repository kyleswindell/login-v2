# Worklog 2-F-0042 - Button component correction

Date: 2026-06-09

## Queue Items

- P2-F-CQ-079 - Button component correction

## Summary

Corrected the Button Component API proof surface so the page now demonstrates the documented broad Button standard with rendered variant, size, state, group, icon-only, content, and token/style role matrices.

## Changes

- Corrected Button size proof to use the installed `lg-expressive`, `xl`, and `2xl` size classes rather than local sizing hacks.
- Added loading support to `x-ui.icon-button` so icon-only pending states render through the canonical API.
- Added an icon-only state matrix for default, hover, focus-visible, pressed, disabled, and loading states.
- Added an explicit danger icon-only prohibition proof that directs destructive icon-only use toward labeled danger buttons.
- Updated Button catalog status and standard metadata to `Implemented - pending manual review`.
- Strengthened focused Button recovery tests to assert size classes, icon-only state markers, active/hover/focus markers, loading state, tooltip text, and danger icon-only prohibition.
- Synced the active queue so P2-F-CQ-079 is Implemented Pending Review and P2-F-CQ-093 Menu buttons is unblocked.

## Files Updated

- `app/Platform/UiReference/UiReferenceComponentDepthCatalog.php`
- `docs/02-standards/ui/components/button.md`
- `docs/08-active/change-queue.md`
- `docs/08-active/worklogs/worklog-2-F-0042.md`
- `resources/views/components/ui/icon-button.blade.php`
- `resources/views/platform/ui-reference/components/live-examples/button.blade.php`
- `tests/Feature/Platform/PlatformUiReferenceTest.php`

## Validation

- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=button_component_recovery` passed.
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=component` passed after the coupled Menu buttons flexible-layout test update.
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php` passed.
- `npm run build` passed after unsandboxed rerun; the sandboxed attempt failed on native Tailwind/Vite dependency access.
- `npm run lint:docs:guardrails` passed after unsandboxed rerun; the sandboxed attempt failed on Bash/WSL access and the passing run reported existing WSL/rg permission warnings.

## Review Surface

- Local authenticated route/content test for `/platform/ui-reference/components/button`.
- Manual review should confirm the Button page uses the broad matrix-heavy layout and that icon-only state examples are visibly differentiated without approving destructive icon-only actions.

## Next Queue Item

- P2-F-CQ-093 - Menu buttons component correction
