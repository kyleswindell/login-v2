---
title: Spacing Test Requirements
slug: spacing
requirement_layer: foundation-element
element: Spacing
status: planned
priority: high
relative_path: docs/02-standards/ui/test-requirements/elements/spacing.md
canonical_standard: docs/02-standards/ui/elements/spacing.md
runtime_contract: resources/views/elements/spacing/contract.php
rendered_evidence_route: null
---

# Spacing Test Requirements

| Metadata | Value |
| --- | --- |
| Relative path | `docs/02-standards/ui/test-requirements/elements/spacing.md` |
| Purpose | Verify adopted Carbon spacing and layout rhythm, approved size-scale use, and prevention of arbitrary consumer spacing. |
| Requirement status | `planned` |
| Owner | Foundation Element: Spacing |
| Canonical standard | `docs/02-standards/ui/elements/spacing.md` |
| Runtime contract | `resources/views/elements/spacing/contract.php` |
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

Spacing tests verify adopted Carbon spacing and layout rhythm, approved size-scale use, and prevention of arbitrary consumer spacing.

## Source files

- Standard: `docs/02-standards/ui/elements/spacing.md`
- Related standard: `docs/02-standards/ui/elements/2x-grid.md`
- Runtime contract: `resources/views/elements/spacing/contract.php`
- Token sources: `resources/css/tokens/spacing.css`, `resources/css/tokens/layout.css`
- Consumer scan targets: `resources/css/components/**`, `resources/css/patterns/**`, layout Blade views
- rendered evidence proof: `not installed`

## Required automated checks

- Verify adopted Carbon spacing, fluid spacing, layout, and container values match approved token source values.
- Verify spacing tokens load before component token files and component CSS.
- Verify approved size-scale usage for component dimensions where the Spacing standard owns the scale.
- Verify icon-specific dimensions are not asserted here and are instead covered by Icons requirements.

## Required governance checks

- Classify margin, padding, gap, inset, width, height, block-size, inline-size, min/max size, and layout spacing values before failing them.
- Fail values in those properties only when they represent arbitrary spacing, a local reusable scale, or consumer-owned layout rhythm outside documented structural geometry.
- Initial CSS declaration scans may hard-fail local spacing scales in directories with no legacy baseline. Directories with known legacy utility or arbitrary spacing usage should run in `report-only` mode until a baseline artifact exists or migration is complete.
- Fail component-owned external margins unless the owning Pattern or Component standard approves them.
- Verify component internal spacing and parent external spacing ownership is preserved.
- Do not classify icon SVG width/height, intrinsic media dimensions, ARIA/visually-hidden helper geometry, or component-required square hit targets as spacing unless they establish reusable spacing or layout rhythm.

## Required manual review proof

- Review spacing scale examples, stack/gap examples, grid rhythm examples, and layout spacing proofs in rendered evidence.
- Confirm examples demonstrate internal versus external spacing ownership.

## Failure conditions

- A consumer introduces arbitrary spacing or size values outside approved structural geometry.
- A component owns external layout spacing that should belong to a Pattern.
- A layout creates a local replacement scale instead of using Spacing or 2x Grid roles.
- A consumer promotes one-off geometry into a token or variable without an approved reusable role.
- Failure examples include `--card-gap-sm`, `--dashboard-spacing-md`, `--local-stack-gap`, and repeated `gap: 17px` or `padding: 22px` used as local layout rhythm.

## Approved exceptions

- `0`, `100%`, `auto`, `none`, `inherit`, grid/flex mechanics, media query breakpoints, transforms, and keyframe percentages are allowed.
- Approved `1px` borders and separators are allowed where they represent structural lines, not spacing scale values.
- Carbon structural geometry such as carets, handles, spinners, and fixed affordance dimensions may be allowed when documented by the owning Component requirement.

## Deferred / blocked checks

- Exhaustive per-component geometry parity is deferred to component-owned tests.
- Pattern-specific layout rhythm checks are deferred to Pattern requirements.

## Implementation notes

- Start with consumer scans that classify declarations by property and value category.
- Avoid converting every literal into a token; only promote values that represent reusable roles.
