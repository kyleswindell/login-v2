---
title: Color Test Requirements
slug: color
requirement_layer: foundation-element
element: Color
status: partial
priority: high
relative_path: docs/02-standards/ui/test-requirements/elements/color.md
canonical_standard: docs/02-standards/ui/elements/color.md
runtime_contract: resources/views/elements/color/contract.php
rendered_evidence_route: null
---

# Color Test Requirements

| Metadata | Value |
| --- | --- |
| Relative path | `docs/02-standards/ui/test-requirements/elements/color.md` |
| Purpose | Verify adopted Carbon color roles, Login App semantic token ownership, and consumer compliance with the approved Color API. |
| Requirement status | `partial` |
| Owner | Foundation Element: Color |
| Canonical standard | `docs/02-standards/ui/elements/color.md` |
| Runtime contract | `resources/views/elements/color/contract.php` |
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

Color tests verify adopted Carbon color roles, Login App semantic token ownership, and consumer compliance with the approved Color API.

## Source files

- Standard: `docs/02-standards/ui/elements/color.md`
- Related standard: `docs/02-standards/ui/elements/tokens.md`
- Runtime contract: `resources/views/elements/color/contract.php`
- Token sources: `resources/css/tokens/palette/**`, `resources/css/tokens/themes/**`, `resources/css/tokens/semantic/**`, `resources/css/tokens/components/**`
- Consumer scan targets: `resources/css/components/**`, `resources/css/patterns/**`, Blade views using local color classes or inline styles
- rendered evidence proof: `not installed`, `not installed`

## Required automated checks

- Verify adopted Carbon core token families are represented by app token sources.
- Verify required semantic roles for background, layer, layer accent, field, border, text, link, syntax, icon, support, focus, and miscellaneous color roles.
- Verify only approved Carbon component color token owners define component color token files: Button, Content Switcher, Notification, and Tag.
- Verify Status, UI shell, and any other installed component token files are classified as core-token consumers, structural/component non-color tokens, or drift unless their owning standards explicitly approve component color token ownership.
- Verify rendered evidence token data does not list unapproved component token files as approved source files.

## Required governance checks

- Fail raw hex, RGB, HSL, and named color values in consumers. Approved token source files are excluded when those values are mapped into Element roles or approved component roles.
- Fail direct primitive palette usage in consumers, including primitive `--ui-gray-*`, `--ui-blue-*`, `--ui-red-*`, `--ui-green-*`, `--ui-yellow-*`, `--ui-purple-*`, `--ui-orange-*`, `--ui-white`, and `--ui-black` tokens.
- Flag Tailwind color utility classes such as `text-slate-*`, `bg-slate-*`, `border-slate-*`, `text-white`, and similar color utilities when used as production UI styling outside approved migration or baseline exceptions.
- Fail component color token files or imports outside approved component token owners. Do not treat `status.css` or `ui-shell.css` as approved Carbon component color token owners unless the standards are updated.
- Verify semantic support colors are not used as decoration without text, icon, ARIA, or state semantics.
- Verify focus, text, border, layer, field, link, icon, and status roles consume Color-owned roles.

## Required manual review proof

- Review Color overview, token tables, layering examples, interaction state examples, and theme examples in rendered evidence.
- Confirm token swatches and resolved values come from token sources, not hard-coded reference markup.

## Failure conditions

- A consumer uses raw color or primitive palette tokens directly.
- A new component color token file appears without approval.
- rendered evidence advertises an unapproved token family as approved.
- A semantic color communicates meaning without a non-color cue.
- After migration or baseline promotion, prohibited examples include feature Blade/CSS using raw hex colors, Tailwind color utilities, direct primitive palette tokens, decorative support colors, or component color tokens outside the owning component.

## Approved exceptions

- Primitive palette values are allowed inside approved token source files where mapped into semantic Element or approved Component roles.
- `transparent`, `currentColor`, `inherit`, and forced-colors keywords are allowed unless a specific Color requirement forbids them.
- Border widths such as `1px` belong to Spacing or component geometry tests; Color tests only govern the color value used by borders.
- Mask gradients may use black only when the value is used as mask alpha, not visible UI color.
- Approved token source files include palette, theme, semantic, and approved component token sources. Consumer scans must not fail these source files for defining raw values that are mapped into roles.

## Deferred / blocked checks

- Initial Blade utility-class color scans may run in `report-only` mode until current legacy usage is migrated or baselined.
- Full visual parity for every adopted component state is deferred to component-owned tests.
- Data visualization palettes are deferred until a chart/data visualization Pattern API exists.

## Implementation notes

- Element tests own global Color bypass prevention.
- Component tests own exact state-by-state token consumption for a specific component.
