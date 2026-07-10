# Spacing Element Tests

## Purpose

This folder owns co-located tests for the Spacing foundation element.

Current status: token governance coverage. These tests verify the Carbon-comparable spacing, fluid spacing, layout, container, size, and icon-size token families and their load order.

## Carbon Files Reviewed

- `reference/carbon-main/packages/layout/__tests__/scss-test.js`
- `reference/carbon-main/packages/styles/__tests__/styles-test.js`

## Local Files Covered

- `resources/css/tokens/spacing.css`
- `resources/css/tokens/layout.css`
- `resources/css/tokens/index.css`
- `resources/css/app.css`
- `resources/views/elements/spacing/contract.php`
- `docs/02-standards/ui/test-requirements/elements/spacing.md`

## Local Standards Consulted

- `docs/02-standards/ui/elements/spacing.md`
- `docs/02-standards/ui/elements/2x-grid.md`
- `docs/02-standards/ui/test-requirements/elements/spacing.md`
- `docs/02-standards/ui/testing.md`

## Implemented Tests

- `SpacingTokenGovernanceTest.php` verifies standard/contract alignment, exported spacing/layout token families, component load order, approved consumer boundaries, focused raw spacing drift, and report-only Blade/component spacing inventories.

## Report-Only Baselines

- `baselines/blade-spacing-utilities.php` tracks current Blade spacing utility usage by source bucket until migration or baseline promotion.
- `baselines/component-margin-declarations.php` tracks current component margin declarations as migration inventory.
- `baselines/component-spacing-geometry.php` tracks current component spacing and geometry declarations as migration inventory.

## Carbon Assertion Coverage

| Carbon assertion family | Local status | Notes |
| --- | --- | --- |
| Spacing scale exports | Covered | Local CSS variables are asserted directly. |
| Fluid spacing exports | Covered | Local aliases are asserted directly. |
| Container/icon/layout exports | Covered | Local layout token families are asserted directly. |
| SCSS module variable snapshots | Adapted | Login App has CSS token files, not Carbon Sass exports. |

## Intentional Divergences

- Component geometry is not automatically over-tokenized. Structural Carbon geometry may remain literal when documented by the owning component test.

## Drift Candidates Not Yet Enforced

- Broad component spacing literal cleanup is intentionally deferred to per-component tests so the suite does not force one token per numeric value.
