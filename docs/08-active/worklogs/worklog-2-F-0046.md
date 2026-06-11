# Worklog 2-F-0046 - UI Reference Sidebar Menu Standards Correction

- Date: 2026-06-10
- Status: READY_FOR_REVIEW
- Queue items: P2-F-CQ-165

## Summary

Corrected the UI Reference sidebar menu structure to match current menu standards. Color and Typography now behave as independent dropdowns instead of permanently expanded nested sections, and Components now render as one flat alphabetical catalog list without old category group headings or legacy combined index surfaces in the primary sidebar.

## Changes

### Sidebar Menu

- Converted Color to a `details`/`summary` dropdown with Overview and Token Palette child links.
- Converted Typography to a `details`/`summary` dropdown with Overview and Type Sets child links.
- Set Color and Typography dropdowns to open only when their own overview or nested route is active.
- Replaced grouped Component sidebar sections with a flat alphabetical list generated from the Component catalog.
- Removed old Component category headings from the primary sidebar.
- Removed legacy combined Component sidebar links from the primary sidebar.

### Tests

- Added assertions for Color and Typography dropdown markers and closed-by-default state.
- Added assertions that active Color and Typography nested pages open their owning dropdown.
- Added assertions that Components render with a sidebar alphabetical-order marker.
- Added order checks for every Component catalog label in the sidebar.
- Added regression coverage blocking old Component sidebar group markers and legacy sidebar headings.

## Files Updated

- `resources/views/platform/ui-reference/partials/sidebar.blade.php`
- `tests/Feature/Platform/PlatformUiReferenceTest.php`
- `docs/08-active/change-queue.md`
- `docs/08-active/checklist.md`
- `docs/08-active/review.md`
- `docs/08-active/worklogs/index.md`

## Validation

- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=authorized_users_can_view_ui_reference_workspace`
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=tier_one_component_catalog_routes_are_discoverable`
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=foundation_element_catalog_routes_are_discoverable`
- `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php`
- `npm run build`
- `npm run lint:docs:guardrails`

Notes:

- The first parallel focused test attempt collided on the shared test database reset. The affected tests were rerun serially and passed.
- The first `npm run build` attempt hit the known sandbox restriction for the native Tailwind/Vite binary (`spawn EPERM`). The escalated rerun passed.
- The first docs guardrail attempt hit the known sandbox restriction for Bash startup. The escalated rerun passed with existing WSL/rg permission warnings.
- Browser route check reached the local app but redirected `/platform/ui-reference` to `/login`, as expected for a protected route. Authenticated sidebar proof is covered by the feature tests.

## Review Surface

- `/platform/ui-reference`
- `/platform/ui-reference/elements/color`
- `/platform/ui-reference/elements/color/tokens`
- `/platform/ui-reference/elements/typography`
- `/platform/ui-reference/elements/typography/type-sets`
- `/platform/ui-reference/components`
