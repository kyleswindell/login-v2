---
title: 2x Grid Test Requirements
slug: 2x-grid
requirement_layer: foundation-element
element: 2x Grid
status: planned
priority: medium
relative_path: docs/02-standards/ui/test-requirements/elements/2x-grid.md
canonical_standard: docs/02-standards/ui/elements/2x-grid.md
runtime_contract: resources/views/elements/2x-grid/contract.php
rendered_evidence_route: null
---

# 2x Grid Test Requirements

| Metadata | Value |
| --- | --- |
| Relative path | `docs/02-standards/ui/test-requirements/elements/2x-grid.md` |
| Purpose | Verify approved grid, container, breakpoint, and layout roles and prevent layout-local replacement scales. |
| Requirement status | `planned` |
| Owner | Foundation Element: 2x Grid |
| Canonical standard | `docs/02-standards/ui/elements/2x-grid.md` |
| Runtime contract | `resources/views/elements/2x-grid/contract.php` |
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

2x Grid tests verify approved grid, container, breakpoint, and layout roles and prevent layout-local replacement scales.

## Scope boundaries

2x Grid tests own breakpoint token ownership, container role ownership, grid column/gutter/margin role ownership, and prevention of local replacement scales.

2x Grid tests do not own Pattern-specific layout composition, component internal geometry, or one-off flex/grid mechanics that do not create reusable layout scales.

## Source files

- Standard: `docs/02-standards/ui/elements/2x-grid.md`
- Related standard: `docs/02-standards/ui/elements/spacing.md`
- Runtime contract: `resources/views/elements/2x-grid/contract.php`
- Source CSS: `resources/css/base/grid.css`, `resources/css/tokens/layout.css`
- Consumer scan targets: `resources/css/patterns/**`, app layout views, rendered evidence layout examples
- rendered evidence proof: `not installed`

## Required automated checks

- Verify approved breakpoint, grid column, gutter, margin, and container roles are defined.
- Verify grid CSS consumes approved layout and spacing tokens.
- Verify rendered evidence examples use approved grid/container roles.

## Required governance checks

- Fail layout-local replacement scales for breakpoints, containers, gutters, or column counts.
- Fail Pattern or feature CSS that redefines grid behavior outside approved Pattern ownership.
- Verify layout composition does not override Pattern ownership or component internal spacing.
- Treat Pattern-owned layout composition as a Pattern responsibility. 2x Grid tests verify that Patterns consume approved grid/container/breakpoint roles; they do not own the Pattern composition contract itself.

## Required manual review proof

- Review 2x Grid rendered evidence examples for responsive columns, content regions, nested layout, and alignment.
- Confirm examples demonstrate Pattern-level layout rather than component-local layout hacks.

## Failure conditions

- A consumer creates local breakpoint/container/gutter variables that bypass 2x Grid.
- A component owns page layout responsibilities that belong to a Pattern.
- rendered evidence examples use arbitrary layout widths instead of approved roles.
- Failure examples include `--local-breakpoint-md`, `--feature-container-width`, `--dashboard-grid-columns`, repeated local `grid-template-columns` scales used as substitutes for approved grid roles, and media query breakpoints that do not reference approved breakpoint roles.

## Approved exceptions

- `0`, `100%`, `auto`, ordinary grid/flex mechanics, and media query syntax are allowed only when they do not create a local breakpoint, container, gutter, column, or layout scale.
- Approved breakpoint declarations are allowed in token/source files that own the 2x Grid or layout token API.
- Pattern-owned layout constants may be allowed when the Pattern requirement documents the role and source.

## Deferred / blocked checks

- Full Pattern layout matrix coverage is deferred to Pattern requirements.
- Browser visual regression for every breakpoint is not required until a browser test strategy is approved.

## Implementation notes

- Coordinate with Spacing tests so size-scale checks are not duplicated.
- Treat 2x Grid as layout governance, not component internal geometry.
- Do not fail every `display: grid`, `grid-template-columns`, or `gap` declaration. Tests must distinguish ordinary layout mechanics from local replacement scales.
