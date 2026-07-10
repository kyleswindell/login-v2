# 2x Grid Element Tests

## Purpose

This folder owns co-located tests for the 2x Grid foundation element.

Current status: token and governance coverage. These tests verify installed breakpoint, container, grid column, gutter, margin, and utility ownership without asserting Pattern-specific layout composition.

## Carbon Files Reviewed

- `reference/carbon-main/packages/layout/__tests__/scss-test.js`
- `reference/carbon-main/packages/styles/__tests__/styles-test.js`

## Local Files Covered

- `resources/css/tokens/layout.css`
- `resources/css/base/grid.css`
- `resources/css/patterns/**/*.css`
- `resources/views/elements/2x-grid/contract.php`

## Local Standards Consulted

- `docs/02-standards/ui/elements/2x-grid.md`
- `docs/02-standards/ui/elements/spacing.md`
- `docs/02-standards/ui/test-requirements/elements/2x-grid.md`
- `docs/02-standards/ui/testing.md`

## Implemented Tests

- `TwoXGridTokenGovernanceTest.php` verifies standard/contract alignment, layout token exports, grid CSS token consumption, local replacement scale prevention, and report-only component media query usage.

## Report-Only Baselines

- `baselines/component-media-query-usage.php` tracks current component and Pattern media query usage without treating component-owned responsive behavior as a 2x Grid replacement scale.

## Carbon Assertion Coverage

| Carbon assertion family | Local status | Notes |
| --- | --- | --- |
| Breakpoint/layout exports | Covered | Local CSS variables are asserted directly. |
| Grid column/gutter/margin roles | Covered | Local grid source must consume approved layout tokens. |
| SCSS module helper behavior | Adapted | Login App uses CSS token files and utility classes, not Carbon Sass helpers. |

## Intentional Divergences

- CSS custom properties are not relied on inside media query conditions; literal media query breakpoints are allowed in the owning grid source.
- Pattern-specific layout composition is tested by Pattern requirements, not by 2x Grid.

## Drift Candidates Not Yet Enforced

- Full Pattern layout matrix coverage is deferred to Pattern tests.
- Browser visual regression for every breakpoint is deferred until a browser test strategy is approved.
