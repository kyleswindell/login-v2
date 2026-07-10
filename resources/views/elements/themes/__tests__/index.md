# Themes Element Tests

## Purpose

This folder owns co-located tests for the Themes foundation element.

Current status: token governance coverage. These tests verify theme entrypoints, role coverage, theme lifecycle state, and known component-local theme selector drift.

## Carbon Files Reviewed

- `reference/carbon-main/packages/themes/__tests__/scss-test.js`
- `reference/carbon-main/packages/styles/__tests__/styles-test.js`

## Local Files Covered

- `resources/css/tokens/themes/index.css`
- `resources/css/tokens/themes/white.css`
- `resources/css/tokens/themes/gray-10.css`
- `resources/css/tokens/themes/gray-90.css`
- `resources/css/tokens/themes/gray-100.css`
- `resources/css/components/**/*.css`
- `resources/views/elements/themes/contract.php`
- `docs/02-standards/ui/test-requirements/elements/themes.md`

## Local Standards Consulted

- `docs/02-standards/ui/elements/themes.md`
- `docs/02-standards/ui/elements/color.md`
- `docs/02-standards/ui/test-requirements/elements/themes.md`
- `docs/02-standards/ui/testing.md`

## Implemented Tests

- `ThemeTokenGovernanceTest.php` verifies standard/contract alignment, the supported white, gray-10, gray-90, and gray-100 theme family; required role tokens; light/dark scheme mapping; forced-colors accessibility context; and current theme override drift.

## Report-Only Baselines

- None. Current component-local theme selector drift is intentionally narrow and hard-coded until migrated or approved.

## Carbon Assertion Coverage

| Carbon assertion family | Local status | Notes |
| --- | --- | --- |
| Theme family availability | Covered | Login App maps Carbon white/g10/g90/g100 to local theme files. |
| Token availability | Covered | Required role families are asserted per theme. |
| Getter/mixin behavior | Not portable | Login App uses CSS source files, not Carbon Sass helpers. |
| Custom theme config | Not adopted | No local public custom theme API exists. |

## Intentional Divergences

- Login App resolves themes through `data-theme-resolved` and app-owned CSS variables.
- Theme examples can remain review-gated while the API lifecycle stays approved.

## Drift Candidates Not Yet Enforced

- `resources/css/components/time-picker.css` still contains component-local theme selectors and should eventually move that behavior into theme or component tokens.
