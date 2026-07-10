# Motion Element Tests

## Purpose

This folder owns co-located tests for the Motion foundation element.

Current status: provisional token governance coverage. These tests verify Carbon duration/easing token families, reduced-motion guards, and categorized raw motion drift.

## Carbon Files Reviewed

- `reference/carbon-main/packages/motion/__tests__/motion-test.js`
- `reference/carbon-main/packages/styles/__tests__/styles-test.js`

## Local Files Covered

- `resources/css/tokens/motion.css`
- `resources/css/base/skeleton.css`
- `resources/css/base/transform.css`
- `resources/css/components/**/*.css`
- `resources/views/elements/motion/contract.php`
- `docs/02-standards/ui/test-requirements/elements/motion.md`

## Local Standards Consulted

- `docs/02-standards/ui/elements/motion.md`
- `docs/02-standards/ui/test-requirements/elements/motion.md`
- `docs/02-standards/ui/testing.md`

## Implemented Tests

- `MotionTokenGovernanceTest.php` verifies standard/contract alignment, motion token exports, meaningful reduced-motion safeguards, provisional lifecycle state, categorized raw motion declarations, and report-only JavaScript timing findings.

## Report-Only Baselines

- `baselines/js-timing-findings.php` tracks current JavaScript timing findings until controller timing ownership is approved.

## Carbon Assertion Coverage

| Carbon assertion family | Local status | Notes |
| --- | --- | --- |
| Public duration/easing exports | Covered | Local CSS variables are asserted directly. |
| Unknown easing helper errors | Not portable | Login App does not expose a motion helper function. |
| SCSS module variable snapshot | Adapted | Local explicit token assertions replace snapshots. |
| Reduced-motion behavior | Partially covered | Source guards are asserted for key animated surfaces. |

## Intentional Divergences

- Component-specific animation geometry is not over-tokenized automatically.
- Motion remains provisional until token cleanup and accessibility review finish.

## Drift Candidates Not Yet Enforced

- Skeleton, loading, and progress animations still contain raw durations that are categorized until an app-approved motion-token cleanup is scoped.
