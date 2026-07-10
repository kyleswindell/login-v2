# Color Element Tests

## Purpose

This folder owns co-located tests for the Color foundation element.

Current status: token governance coverage. These tests verify installed palette, semantic alias, component-token, and raw-value classification rules. They do not approve final visual parity for every component color state.

## Carbon Files Reviewed

- `reference/carbon-main/packages/colors/__tests__/colors-test.js`
- `reference/carbon-main/packages/colors/__tests__/scss-test.js`
- `reference/carbon-main/packages/themes/__tests__/scss-test.js`
- `reference/carbon-main/packages/styles/__tests__/styles-test.js`

## Local Files Covered

- `resources/css/tokens/index.css`
- `resources/css/tokens/palette/index.css`
- `resources/css/tokens/palette/base-colors.css`
- `resources/css/tokens/semantic/index.css`
- `resources/css/tokens/semantic/app-aliases.css`
- `resources/css/tokens/components/index.css`
- `resources/css/components/**/*.css`
- `resources/views/elements/color/contract.php`
- `docs/02-standards/ui/test-requirements/elements/color.md`

## Local Standards Consulted

- `docs/02-standards/ui/elements/color.md`
- `docs/02-standards/ui/elements/themes.md`
- `docs/02-standards/ui/elements/tokens.md`
- `docs/02-standards/ui/test-requirements/elements/color.md`
- `docs/02-standards/ui/testing.md`

## Implemented Tests

- `ColorTokenGovernanceTest.php` verifies standard/contract alignment, palette and semantic token entrypoints, representative Carbon palette tokens, Carbon-approved component-token imports, direct primitive palette-token usage, categorized raw color drift in component CSS, and report-only Blade color utility baselines.

## Report-Only Baselines

- `baselines/component-token-file-drift.php` tracks Status/UI shell component token files until standards promote or migrate them.
- `baselines/blade-color-utilities.php` tracks current Blade color utility usage by source bucket until migration or baseline promotion.

## Carbon Assertion Coverage

| Carbon assertion family | Local status | Notes |
| --- | --- | --- |
| Color token exports | Covered | Uses explicit token assertions instead of Carbon snapshots. |
| Hover color exports | Covered | Representative hover tokens are asserted. |
| SCSS public API snapshot | Adapted | Local CSS entrypoints are asserted; no SCSS snapshot is ported. |
| Component color consumption | Partially covered | Current raw values and primitive palette-token references must be categorized or fixed. Full component parity is per-component work. |

## Intentional Divergences

- Login App exposes app-owned `--ui-*` token names instead of Carbon `--cds-*` names.
- Component color token files are limited to Carbon's Button, Content switcher, Notification, and Tag families.
- Raw primitive values are allowed only in palette/theme token source files or documented structural categories.

## Drift Candidates Not Yet Enforced

- `resources/css/tokens/components/status.css` and `resources/css/tokens/components/ui-shell.css` are current drift under the Carbon component-token ownership rule.
- Several component CSS files still contain raw shadow fallbacks, black icon fill fallbacks, skeleton color fallbacks, or mask-gradient black values.
- Some adopted components still need deeper core-token cleanup before per-state visual parity can be enforced.
