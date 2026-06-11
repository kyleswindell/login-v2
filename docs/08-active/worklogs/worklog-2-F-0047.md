# Worklog 2-F-0047

## Summary

Implemented `P2-F-CQ-166` and `P2-F-CQ-167`.

This pass adds durable UI API Standards Preflight guidance and corrects the UI Reference sidebar disclosure behavior missed by the previous sidebar pass. Color and Typography now use button-driven disclosures with productive motion, reduced-motion handling, chevron state, focus behavior, and controlled panels. Components remain a flat alphabetical list, and the sidebar now has one shell-level scroll owner instead of a nested Component-list scrollbar.

## UI API Standards Preflight

| Field | Detail |
|---|---|
| Primary API | Navigation Pattern API for UI Reference sidebar navigation and disclosure behavior |
| Standards reviewed | `docs/02-standards/ui/patterns/navigation.md`; `docs/02-standards/ui/patterns/layout.md`; `docs/02-standards/ui/elements/motion.md`; `docs/02-standards/ui/elements/icons.md`; `docs/02-standards/ui/elements/spacing.md`; `docs/02-standards/ui/elements/typography.md`; `docs/02-standards/ui/elements/color.md`; `docs/02-standards/ui/elements/themes.md` |
| Related APIs consulted | Navigation owns current route context, sidebar composition, overflow, and collapse behavior; Layout owns shell scroll ownership and page frame behavior; Motion owns productive disclosure timing and reduced-motion expectations; Icons owns chevron state treatment; Color, Typography, Spacing, and Themes own token-backed visual treatment |
| Foundation Elements consumed | Color, Spacing, Typography, Icons, Motion, Themes |
| Source and live examples inspected | `resources/views/platform/ui-reference/partials/sidebar.blade.php`; `resources/js/ui-reference.js`; `resources/js/ui-controls/accordions.js`; `resources/css/app.css`; existing UI Reference sidebar tests |
| Motion, accessibility, and layout requirements | Disclosures require `button` triggers, `aria-expanded`, `aria-controls`, controlled panels, visible focus, chevron rotation, productive open/close motion, `prefers-reduced-motion` fallback, and one sidebar/page scroll owner |
| Visual review notes | Browser review should inspect the authenticated UI Reference sidebar locally. If the browser redirects to `/login`, authenticated feature coverage is the local proof surface and the item remains pending manual visual review. |

## Changes

- Added UI API Standards Preflight requirements to UI standards and resource-side AGENTS files.
- Replaced Color and Typography sidebar native disclosure markup with explicit button/panel disclosure markup and state markers.
- Added a UI Reference sidebar disclosure initializer with measured block-size open/close motion and reduced-motion behavior.
- Added CSS for sidebar disclosure panel motion, chevron rotation, hidden state, and reduced-motion override.
- Removed the nested Component-list scroll container and made the sidebar shell the single scroll owner.
- Added regression assertions for disclosure markers, reduced-motion source support, chevron open-state CSS, single scroll ownership, no nested Component scrollbar, alphabetical Component order, and stale group absence.

## Files Updated

- `docs/02-standards/ui/AGENTS.md`
- `resources/AGENTS.md`
- `resources/views/platform/ui-reference/AGENTS.md`
- `resources/views/platform/ui-reference/partials/AGENTS.md`
- `resources/views/components/ui/AGENTS.md`
- `resources/views/platform/ui-reference/partials/sidebar.blade.php`
- `resources/js/app.js`
- `resources/js/ui-reference.js`
- `resources/css/app.css`
- `tests/Feature/Platform/PlatformUiReferenceTest.php`
- `docs/08-active/change-queue.md`
- `docs/08-active/checklist.md`
- `docs/08-active/review.md`
- `docs/08-active/worklogs/index.md`

## Validation

- Passed: `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=authorized_users_can_view_ui_reference_workspace`.
- Passed: `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=foundation`.
- Passed: `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=component`.
- Passed: `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php`.
- Passed: `npm run build`.
  - Initial sandboxed run failed on Windows native Tailwind/Vite binary execution (`spawn EPERM` / oxide load); escalated rerun passed.
- Passed: `npm run lint:docs:guardrails`.
  - Initial sandboxed run failed on WSL/Bash access denial; escalated rerun passed with the existing WSL/rg permission warnings.
- Browser route check: attempted `http://localhost:8000/platform/ui-reference`; the protected route redirected to `/login`, so authenticated automated route/content coverage is the local proof surface and manual visual review remains pending.

## Review Surface

- `/platform/ui-reference`
- `/platform/ui-reference/elements/color`
- `/platform/ui-reference/elements/color/tokens`
- `/platform/ui-reference/elements/typography`
- `/platform/ui-reference/elements/typography/type-sets`
- `/platform/ui-reference/components`
