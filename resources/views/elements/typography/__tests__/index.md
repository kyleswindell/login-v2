# Typography Element Tests

## Purpose

This folder owns co-located tests for the Typography foundation element.

Current status: provisional token governance coverage. These tests verify type source entrypoints, required type token families, and categorized component typography drift.

## Carbon Files Reviewed

- `reference/carbon-main/packages/type/__tests__/scss-test.js`
- `reference/carbon-main/packages/styles/__tests__/styles-test.js`

## Local Files Covered

- `resources/css/type/index.css`
- `resources/css/type/tokens.css`
- `resources/css/components/**/*.css`
- `resources/views/elements/typography/contract.php`
- `docs/02-standards/ui/test-requirements/elements/typography.md`

## Local Standards Consulted

- `docs/02-standards/ui/elements/typography.md`
- `docs/02-standards/ui/test-requirements/elements/typography.md`
- `docs/02-standards/ui/testing.md`

## Implemented Tests

- `TypographyTokenGovernanceTest.php` verifies standard/contract alignment, type import order, representative type tokens, provisional lifecycle state, categorized raw type declarations in component CSS, and report-only Blade/component typography baselines.

## Report-Only Baselines

- `baselines/blade-typography-utilities.php` tracks current Blade typography utility usage by source bucket until migration or baseline promotion.
- `baselines/component-type-drift.php` tracks current component and Pattern raw typography declarations as migration inventory.

## Carbon Assertion Coverage

| Carbon assertion family | Local status | Notes |
| --- | --- | --- |
| Type token CSS properties | Covered | Representative local type variables are asserted. |
| CSS custom property fallback behavior | Partially covered | Component declarations are expected to consume local type variables. |
| Sass mixins | Not portable | Login App uses CSS variables and utilities, not Carbon Sass mixins. |

## Intentional Divergences

- Login App preserves its own font stack while using Carbon-style type role tokens.
- Typography remains provisional until visual and accessibility review finishes.

## Drift Candidates Not Yet Enforced

- Shell, status, badge, slug, form, list box, loading, modal, number input, overflow menu, and progress indicator still contain raw type values that are categorized and item-baselined as current cleanup drift.
