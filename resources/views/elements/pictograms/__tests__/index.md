# Pictograms Element Tests

## Purpose

This folder owns co-located tests for the Pictograms foundation element.

Current status: deferred API guard. These tests verify pictograms remain planned and blocked until an asset-library decision approves a source, wrapper, and production usage contract.

## Carbon Files Reviewed

- `reference/carbon-main/packages/elements/src/__tests__/PublicAPI-test.js`
- Carbon pictogram usage, library, and code guidance referenced by `docs/02-standards/ui/elements/pictograms.md`

## Local Files Covered

- `resources/views/elements/pictograms/contract.php`
- `resources/views/components/**`
- `resources/views/livewire/**`
- `resources/views/platform/**`
- `resources/css/components/**`
- `resources/css/patterns/**`
- `docs/02-standards/ui/test-requirements/elements/pictograms.md`

## Local Standards Consulted

- `docs/02-standards/ui/elements/pictograms.md`
- `docs/02-standards/ui/elements/icons.md`
- `docs/02-standards/ui/test-requirements/elements/pictograms.md`
- `docs/02-standards/ui/testing.md`

## Implemented Tests

- `PictogramElementGovernanceTest.php` verifies standard/contract alignment, blocked lifecycle state, absence of a public pictogram component or asset source, and no production source claims `x-ui.pictogram`, `ui-pictogram*`, or pictogram asset sources.

## Report-Only Baselines

- None. Pictograms remain deferred; production usage is not approved.

## Carbon Assertion Coverage

| Carbon assertion family | Local status | Notes |
| --- | --- | --- |
| Public API stability | Covered as deferred guard | The test protects absence of a public local API. |
| Asset library behavior | Not adopted | Carbon pictogram assets are not approved locally. |
| Sizing guidance | Documented only | The standard reserves sizing variables; production source is not installed. |

## Intentional Divergences

- Login App does not currently adopt Carbon pictogram assets.
- Pictogram examples may describe disposition, but production feature code must not render fake pictograms.

## Drift Candidates Not Yet Enforced

- Future pictogram implementation needs an explicit asset decision, registry/wrapper contract, theme proof, and visual/accessibility tests.
