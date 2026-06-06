# Worklog 2-F-0016

## Status

READY_FOR_REVIEW

## Date

2026-06-06

## Queue Items

- P2-F-CQ-016 - Carbon component inventory and T1 disposition map
- P2-F-CQ-017 - UI Reference T1 component menu architecture
- P2-F-CQ-018 - Split existing combined T1 pages
- P2-F-CQ-019 - Missing input/control components
- P2-F-CQ-020 - Selection component depth pass
- P2-F-CQ-021 - Data display T1 expansion
- P2-F-CQ-022 - Navigation/action primitives depth pass
- P2-F-CQ-023 - Low-applicability Carbon items and future gates
- P2-F-CQ-024 - T1 route, test, docs, and handoff cleanup

## Scope

Implemented the Carbon-aligned T1 expansion as one grouped pass because the sidebar, overview, routing, and tests all depend on the same component catalog source. Carbon remains an inventory benchmark only; the UI Reference continues to use Login App 2.0 markup, tokens, and interaction rules.

## Files Updated

- `app/Platform/UiReference/UiReferenceComponentCatalog.php`
  - Added the single component catalog source for every Carbon component named in the manual review plan.
  - Added Login App dispositions, owner routes, groups, state lists, and usage rules.
- `app/Http/Controllers/Platform/UiReferenceController.php`
  - Added component catalog injection.
  - Added component overview and generic component route rendering.
  - Shared catalog data with every UI Reference page so sidebar and overview remain synchronized.
- `routes/web.php`
  - Added `/platform/ui-reference/components` and `/platform/ui-reference/components/{component}`.
  - Preserved legacy combined component routes for compatibility.
- `resources/views/platform/ui-reference/partials/sidebar.blade.php`
  - Replaced the primary three-link component navigation with a catalog-driven T1 Components menu.
  - Kept T2 Pattern Standards separate.
  - Moved old combined pages into legacy index links.
- `resources/views/platform/ui-reference/components/overview.blade.php`
  - Added the full Carbon component disposition matrix.
- `resources/views/platform/ui-reference/components/show.blade.php`
  - Added generated component pages with owner route, route name, disposition, state chips, usage rules, and implementation guidance.
  - Added concrete depth examples for number input, radio button, checkbox, pagination, structured list, tabs, menu, and UI shell pages.
- `resources/views/platform/ui-reference/overview.blade.php`
  - Pointed the workspace overview at the T1 component catalog and summarized disposition counts.
- `tests/Feature/Platform/PlatformUiReferenceTest.php`
  - Added catalog route/sidebar coverage for every cataloged entry.
  - Added focused assertions for the high-risk depth pages.
- `docs/08-active/change-queue.md`
  - Approved P2-F-CQ-008 through P2-F-CQ-011 from manual review.
  - Added and moved P2-F-CQ-016 through P2-F-CQ-024 to Implemented Pending Review.
- `docs/08-active/checklist.md`, `docs/08-active/notes.md`, and `docs/08-active/review.md`
  - Synced active batch state and review notes to the new T1 catalog model.

## Result

- Every Carbon component from the reviewed component menu now has a Login App 2.0 disposition and owner route.
- UI Reference has a primary T1 Components menu with one route per cataloged component family.
- Notifications remain a grouped T1 family by design.
- Low-applicability items such as AI label and code snippet are explicitly mapped with trigger conditions instead of speculative UI.
- T2 pages remain composition surfaces and no longer act as the only source for primitive ownership.

## Validation

- PASS: `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=carbon_aligned`
- PASS: `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php` after the Blade payload naming fix and number-input content correction.
- PASS: `npm run build` outside the sandbox after the sandboxed Vite run failed with Windows native-binary `spawn EPERM`.
- PASS: `npm run lint:docs:guardrails` outside the sandbox after the sandboxed Bash run failed with `E_ACCESSDENIED`; the script exited successfully while still emitting Windows/WSL `rg` path warnings.
- PASS: Browser review at `/platform/ui-reference/components`, `/platform/ui-reference/components/number-input`, `/platform/ui-reference/components/radio-button`, `/platform/ui-reference/components/structured-list`, `/platform/ui-reference/components/tabs`, and `/platform/ui-reference/components/menu`.

## Review Fix

- Fixed the T1 component overview disposition column so categorical badge labels keep one-line intrinsic sizing while owner route and implementation-scope columns absorb wrapping.
- Validation passed with `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=tier_one_component_catalog`.
- Browser verification confirmed all 42 disposition badges remain one line; `Represent As T2 Pattern` measured 148px inside a 180px disposition cell with no wrapping failures.
