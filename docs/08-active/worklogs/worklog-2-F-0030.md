# Worklog 2-F-0030 - Motion Foundation Element UI Proof Correction

## Queue Items

- P2-F-CQ-120 - Motion Foundation Element UI proof correction

## Scope

Corrected the Motion Foundation Element standard, catalog metadata, UI Reference proof, and focused Foundation assertions so the page matches the installed Motion API contract.

## Changes

- Normalized Motion related Pattern metadata to current canonical Pattern standards and routes.
- Updated the Motion catalog live-example labels so expressive motion is represented as a gate, not an installed demo.
- Rebuilt the Motion UI Reference example partial:
  - productive motion examples remain implemented examples
  - expressive motion is a gated capability card
  - Button, Menu, Toast, Loading, and Accordion proof uses installed app APIs or explicit owner labels
  - Accordion proof uses `x-ui.accordion` instead of native `<details>`
  - Pattern-owned modal, shell, and route motion are shown as current Pattern gates
  - reduced-motion proof shows default and reduced/static examples plus the `prefers-reduced-motion` selector
- Strengthened focused Foundation tests to reject fake expressive demos, stale app-shell routes, native details accordion proof, and missing reduced-motion markers.

## Validation

- Passed: `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php --filter=foundation`
- Passed: `docker compose exec -T app php artisan test tests/Feature/Platform/PlatformUiReferenceTest.php`
- Passed: `npm run build`
- Passed: `npm run lint:docs:guardrails`
- Browser review attempted at `/platform/ui-reference/elements/motion`; the protected route redirected to `/login`, so authenticated automated route/content coverage is the local review surface for this pass.

## Review Surface

- Local authenticated automated UI Reference route coverage.
- Manual browser review target: `/platform/ui-reference/elements/motion`.
