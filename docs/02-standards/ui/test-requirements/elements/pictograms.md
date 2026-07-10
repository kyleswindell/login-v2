---
title: Pictograms Test Requirements
slug: pictograms
requirement_layer: foundation-element
element: Pictograms
status: deferred
priority: low
relative_path: docs/02-standards/ui/test-requirements/elements/pictograms.md
canonical_standard: docs/02-standards/ui/elements/pictograms.md
runtime_contract: resources/views/elements/pictograms/contract.php
rendered_evidence_route: null
---

# Pictograms Test Requirements

| Metadata | Value |
| --- | --- |
| Relative path | `docs/02-standards/ui/test-requirements/elements/pictograms.md` |
| Purpose | Guard the deferred pictogram API until an approved asset source, naming model, sizing model, and accessibility contract exist. |
| Requirement status | `deferred` |
| Owner | Foundation Element: Pictograms |
| Canonical standard | `docs/02-standards/ui/elements/pictograms.md` |
| Runtime contract | `resources/views/elements/pictograms/contract.php` |
| Rendered evidence route | `not installed` |

## Implementation enforcement mode

Initial implementation should support:

- `fail`: violations that are already approved as hard failures.
- `report-only`: known migration debt or broad scans that need baseline review.
- `deferred`: checks blocked by missing standards, browser strategy, or component ownership.

Do not fail broad consumer scans until existing legacy usage has either been migrated or baselined.

Report-only findings must be written to a stable baseline artifact before being promoted to hard failures. Tests should fail only when new unbaselined report-only findings are introduced or when a requirement explicitly marks the check as `fail`.

Tests must read the canonical standard and runtime contract before asserting hard-coded role names. If the standard and contract disagree, fail with a contract drift message instead of guessing.

## Purpose

Pictograms tests guard the deferred API until an approved asset source, naming model, sizing model, and accessibility contract exist.

## Source files

- Standard: `docs/02-standards/ui/elements/pictograms.md`
- Runtime contract: `resources/views/elements/pictograms/contract.php`
- Future asset source: Needs confirmation
- Consumer scan targets: `resources/views/components/**`, `resources/views/platform/**`, `resources/css/components/**`, `resources/css/patterns/**`
- Additional asset scan targets: `resources/images/**`, `resources/icons/**`, approved public asset folders, and build asset source folders where pictograms could be introduced. Do not scan compiled vendor/build output as source-of-truth unless a test explicitly targets published production assets.
- rendered evidence proof: `not installed`

## Required automated checks

- Verify the Pictograms contract remains deferred or blocked until an asset source is approved.
- Verify no public `<x-ui.pictogram>` component exists while the API is blocked.
- Verify no public pictogram asset source is installed without approval.

## Required governance checks

- Fail unapproved pictogram imports, classes, wrappers, or Blade components.
- Fail use of pictograms as substitute icons, empty-state art, onboarding art, or decorative illustration before approval.

## Required manual review proof

- Review Pictograms rendered evidence page for deferred status, blocked decision criteria, and future requirements.

## Failure conditions

- A public pictogram component appears before the API is approved.
- A feature or Pattern imports pictogram assets without an approved source.
- rendered evidence presents pictograms as usable production assets while the API remains blocked.

## Approved exceptions

- None approved for production usage, runtime imports, public components, asset sources, or consumer classes.
- Documentation-only references to future pictogram requirements are allowed when they do not expose production usage, install assets, import assets, or present pictograms as available UI.
- Approved icon SVG sources under the Icons Element are not pictograms and must not be failed by Pictograms tests unless they are presented as illustrative pictogram assets.

## Deferred / blocked checks

- Asset source, naming, size scale, clearance, color behavior, accessibility, and content rules are blocked until the Pictograms standard approves the public API.

## Implementation notes

- Keep checks as guards until the API changes disposition.
- Do not import Carbon pictograms or third-party pictograms without a standards update.
