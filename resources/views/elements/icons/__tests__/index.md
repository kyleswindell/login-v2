# Icons Element Tests

## Purpose

This folder owns co-located tests for the Icons foundation element.

Current status: manifest governance coverage. These tests verify the manifest-backed `x-ui.icon` API, required generated icon names, currentColor behavior, and removal of deprecated root-level icon blades.

## Carbon Files Reviewed

- `reference/carbon-main/packages/elements/src/__tests__/PublicAPI-test.js`
- `reference/carbon-main/packages/react/src/components/Icon/__tests__/Icon-test.js`
- `reference/carbon-main/packages/react/src/components/SkeletonIcon/__tests__/SkeletonIcon-test.js`

## Local Files Covered

- `config/ui-icons.php`
- `resources/views/components/ui/icon/index.blade.php`
- `resources/views/components/icons/src/svg/manifest.php`
- `resources/views/elements/icons/contract.php`
- `docs/02-standards/ui/test-requirements/elements/icons.md`

## Local Standards Consulted

- `docs/02-standards/ui/elements/icons.md`
- `docs/02-standards/ui/test-requirements/elements/icons.md`
- `docs/02-standards/ui/testing.md`

## Implemented Tests

- `IconElementGovernanceTest.php` verifies standard/contract alignment, manifest configuration, required manifest icons, rendered icon contract, missing icon behavior, deprecated dynamic icon API removal, report-only legacy static icon usage, and manifest-backed contract dependencies.

## Report-Only Baselines

- `baselines/legacy-static-icon-usage.php` tracks any remaining legacy static icon API use while dynamic/config-driven icon APIs remain hard failures.

## Carbon Assertion Coverage

| Carbon assertion family | Local status | Notes |
| --- | --- | --- |
| Icon render contract | Covered | Local Blade output owns classes, data attributes, sizing, and currentColor. |
| Public API stability | Covered | Manifest config and renderer contract are asserted. |
| Skeleton icon | Not covered here | Skeleton rendering belongs to component/icon-skeleton tests. |
| React props/ref behavior | Not portable | Login App uses Blade and config-driven rendering. |

## Intentional Divergences

- Login App uses exact generated manifest names and does not support `icons.*`, `x-icons.*`, or name aliases.
- `x-ui.status-icon` remains separate for handcrafted status glyphs.

## Drift Candidates Not Yet Enforced

- Some component CSS still has black icon fill fallbacks categorized by the Color element tests.
