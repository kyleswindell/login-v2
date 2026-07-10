---
title: Typography Test Requirements
slug: typography
requirement_layer: foundation-element
element: Typography
status: partial
priority: high
relative_path: docs/02-standards/ui/test-requirements/elements/typography.md
canonical_standard: docs/02-standards/ui/elements/typography.md
runtime_contract: resources/views/elements/typography/contract.php
rendered_evidence_route: null
---

# Typography Test Requirements

| Metadata | Value |
| --- | --- |
| Relative path | `docs/02-standards/ui/test-requirements/elements/typography.md` |
| Purpose | Verify adopted type roles, token-backed text properties, and prevention of raw typography decisions in consumers. |
| Requirement status | `partial` |
| Owner | Foundation Element: Typography |
| Canonical standard | `docs/02-standards/ui/elements/typography.md` |
| Runtime contract | `resources/views/elements/typography/contract.php` |
| Rendered evidence route | `not installed`; `not installed` |

## Implementation enforcement mode

Initial implementation should support:

- `fail`: violations that are already approved as hard failures.
- `report-only`: known migration debt or broad scans that need baseline review.
- `deferred`: checks blocked by missing standards, browser strategy, or component ownership.

Do not fail broad consumer scans until existing legacy usage has either been migrated or baselined.

Report-only findings must be written to a stable baseline artifact before being promoted to hard failures. Tests should fail only when new unbaselined report-only findings are introduced or when a requirement explicitly marks the check as `fail`.

Tests must read the canonical standard and runtime contract before asserting hard-coded role names. If the standard and contract disagree, fail with a contract drift message instead of guessing.

## Purpose

Typography tests verify adopted type roles, token-backed text properties, and prevention of raw typography decisions in consumers.

## Source files

- Standard: `docs/02-standards/ui/elements/typography.md`
- Runtime contract: `resources/views/elements/typography/contract.php`
- Token sources: `resources/css/type/**`, `resources/css/tokens/type/**`
- Source note: both paths currently exist and stay in scope; `resources/css/tokens/type/**` is the token entrypoint path.
- Consumer scan targets: `resources/css/components/**`, `resources/css/patterns/**`, text-bearing Blade views
- rendered evidence proof: `not installed`, `not installed`

## Required automated checks

- Verify adopted type role properties for font family, font size, font weight, line height, and letter spacing.
- Verify type token files define required productive and expressive role variables.
- Verify type utilities or classes emit CSS custom property based values where applicable.
- Verify rendered evidence type sets render the adopted role matrix.

## Required governance checks

- CSS consumer scans should fail raw `font-family`, `font-size`, `font-weight`, `line-height`, and `letter-spacing` declarations outside approved token/source files and documented structural exceptions.
- Blade utility-class typography scans should initially run in `report-only` mode unless the target directory has completed migration away from utility typography classes.
- Promotion from `report-only` to `fail` should happen per directory or component family, not globally.
- Report or fail utility typography classes such as `text-sm`, `text-xs`, `text-2xl`, `font-medium`, `font-semibold`, `leading-6`, and `tracking-*` according to migration status.
- Fail undefined local typography variables with raw fallbacks.
- Verify text-bearing Components consume approved type roles instead of local visual values.

## Required manual review proof

- Review Typography overview and type-set pages for hierarchy, role naming, code text, labels, helper text, and expressive/productive examples.
- Confirm examples do not rely on inline raw font styles.

## Failure conditions

- A consumer hard-codes type properties instead of using approved type roles.
- A local type variable is introduced without an owning standard.
- A rendered evidence example displays role names that are not installed in token sources.

## Approved exceptions

- `inherit`, `normal`, `none`, and `0` are allowed where they preserve browser or parent text behavior.
- `font: inherit` is allowed for buttons, links, icon buttons, form controls, and other controls that intentionally inherit the surrounding text contract.
- Structural line-height values are allowed in icon-only, square-control, or non-text alignment contexts when they do not establish a text role.
- Visually hidden text may use structural sizing when required by accessibility helpers.
- Source token files may define raw values for adopted type roles.

## Deferred / blocked checks

- Full visual and accessibility review of all type examples remains separate from static token scans.
- IBM Plex adoption and additional display roles remain gated until approved by the Typography standard.

## Implementation notes

- Element tests should flag raw type drift globally.
- Component tests should assert the exact type role each component consumes.
