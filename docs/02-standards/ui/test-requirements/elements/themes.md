---
title: Themes Test Requirements
slug: themes
requirement_layer: foundation-element
element: Themes
status: partial
priority: high
relative_path: docs/02-standards/ui/test-requirements/elements/themes.md
canonical_standard: docs/02-standards/ui/elements/themes.md
runtime_contract: resources/views/elements/themes/contract.php
rendered_evidence_route: null
---

# Themes Test Requirements

| Metadata | Value |
| --- | --- |
| Relative path | `docs/02-standards/ui/test-requirements/elements/themes.md` |
| Purpose | Verify supported theme contexts, stable role resolution, and prevention of component-local theme patches. |
| Requirement status | `partial` |
| Owner | Foundation Element: Themes |
| Canonical standard | `docs/02-standards/ui/elements/themes.md` |
| Runtime contract | `resources/views/elements/themes/contract.php` |
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

Themes tests verify supported theme contexts, stable role resolution, and prevention of component-local theme patches.

## Source files

- Standard: `docs/02-standards/ui/elements/themes.md`
- Related standard: `docs/02-standards/ui/elements/color.md`
- Runtime contract: `resources/views/elements/themes/contract.php`
- Token sources: `resources/css/tokens/themes/**`
- Consumer scan targets: `resources/css/components/**`, `resources/css/patterns/**`, theme-aware Blade examples
- rendered evidence proof: `not installed`

## Required automated checks

- Verify supported theme files exist and are imported: white, gray-10, gray-90, gray-100, and forced-colors where installed.
- Verify supported themes expose consistent role keys for adopted Color roles.
- Verify each theme declares the correct `--ui-color-scheme` value.
- Verify rendered evidence theme examples resolve values through token roles.

## Required governance checks

- Fail component-local `[data-theme-resolved]` or theme-specific patches unless explicitly approved.
- Allow `[data-theme-resolved]` usage inside approved rendered evidence proof surfaces, theme test fixtures, or documented theme-context APIs.
- Allow component-owned `@media (forced-colors: active)` rules when they use forced-colors keywords and preserve accessibility. They are not component-local theme patches unless they redefine app theme roles.
- Approved theme-context APIs may include the app layout shell, auth background shell, rendered evidence theme proof surfaces, and documented theme selector/test fixtures.
- Fail raw light-only or dark-only values in component and pattern consumers.
- Fail theme overrides that redefine component semantics instead of changing token values.

## Required manual review proof

- Review theme comparison examples for forms, data surfaces, notifications, and auth/sign-in examples where present.
- Confirm text, borders, focus, field, and layer roles remain readable across supported theme contexts.

## Failure conditions

- A supported theme is missing an adopted role key.
- Theme files resolve a role to an undocumented value source.
- A component adds local theme patches without an approved exception.
- rendered evidence theme examples use hard-coded values instead of token roles.

## Approved exceptions

- `color-scheme` declarations are allowed in theme source files.
- Forced-colors keywords are allowed inside forced-colors source rules.
- `inherit`, `transparent`, and `currentColor` are allowed for theme-aware inheritance.

## Deferred / blocked checks

- Full high-contrast custom override coverage is blocked until the accessibility/browser support expectations are approved.
- Product/app theme switching behavior is gated by the Themes standard. This does not block the existing rendered evidence selector used as a proof surface.

## Implementation notes

- Theme tests should compare role keys across themes before checking individual values.
- Component-specific inverse behavior belongs in component tests after the Theme requirement approves the context.
