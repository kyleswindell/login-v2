---
title: Icons Test Requirements
slug: icons
requirement_layer: foundation-element
element: Icons
status: partial
priority: medium
relative_path: docs/02-standards/ui/test-requirements/elements/icons.md
canonical_standard: docs/02-standards/ui/elements/icons.md
runtime_contract: resources/views/elements/icons/contract.php
rendered_evidence_route: null
---

# Icons Test Requirements

| Metadata | Value |
| --- | --- |
| Relative path | `docs/02-standards/ui/test-requirements/elements/icons.md` |
| Purpose | Verify manifest-backed SVG icon rendering, internal icon source ownership, currentColor behavior, sizing, and API migration away from deprecated icon surfaces. |
| Requirement status | `partial` |
| Owner | Foundation Element: Icons |
| Canonical standard | `docs/02-standards/ui/elements/icons.md` |
| Runtime contract | `resources/views/elements/icons/contract.php` |
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

Icons tests verify manifest-backed SVG icon rendering, internal icon source ownership, currentColor behavior, sizing, and API migration away from deprecated icon surfaces.

## Source files

- Standard: `docs/02-standards/ui/elements/icons.md`
- Runtime contract: `resources/views/elements/icons/contract.php`
- Runtime config: `config/ui-icons.php`
- Generated manifest: `resources/views/components/icons/src/svg/manifest.php`
- SVG source files: `resources/views/components/icons/src/svg/**`
- Renderer: `resources/views/components/ui/icon/**`
- Legacy generated icon blades: `resources/views/components/icons/**/*.blade.php`, excluding `resources/views/components/icons/src/svg/**`
- Consumer scan targets: Blade views, Component examples, rendered evidence pages using icons
- rendered evidence proof: `not installed`

## Required automated checks

- Verify icon runtime config points at the approved internal SVG source and generated manifest.
- Verify required internal icon names exist in the manifest.
- Verify `<x-ui.icon>` renders `currentColor`, approved sizing, data attributes, and missing-icon contract.
- Verify deprecated consumer icon APIs and stale dynamic icon APIs do not reappear in migrated Blade consumers or rendered evidence examples.
- Verify the `size` prop controls rendered dimensions only. It must not perform runtime source-size selection; the generated manifest selects the default SVG source for each icon name.

## Required governance checks

- Fail `x-dynamic-component` usage for icons when the icon value can come from config, props, variables, or other dynamic sources.
- Fail non-standard icon names in config-driven and dynamic icon usage.
- Fail new `x-icons.*` usage in reusable components and new UI examples. Existing direct static `x-icons.*` usage may be tracked as legacy migration debt until the migration phase removes or wraps those usages.
- Fail `icons.*` dynamic aliases after `config/navigation.php` and component icon props are migrated to canonical manifest names.
- Fail inline SVG/icon copies in consumers when an internal icon exists.
- Fail icon color values that bypass adjacent text/action/status color through `currentColor` or approved component roles.
- Do not fail the existence of internal SVG source files required by the manifest generation process or approved renderer.

## Required manual review proof

- Review Icons rendered evidence examples for sizing, alignment, status icon usage, decorative icons, action icons, and missing-icon behavior.
- Confirm icon-only controls have accessible names and hit target proof through their owning Component requirements.
- Approved examples: `<x-ui.icon name="apps" />`, `<x-ui.icon name="notification" size="sm" />`, `<x-ui.icon name="settings--check" label="Security checklist" />`, and `<x-ui.icon name="chevron--down" decorative />`.
- Deprecated examples: `<x-dynamic-component :component="$icon" />`, `<x-layouts.nav-icon :icon="$icon" />`, `<x-icons.apps />` in new dynamic/component code, and `icon="icons.arrow-right"`.

## Failure conditions

- A consumer uses a deprecated icon API.
- An icon renders with hard-coded fill/stroke rather than `currentColor` unless the icon source requires a documented exception.
- An icon name appears in examples but is missing from the manifest.
- A consumer sets arbitrary SVG width/height instead of using the approved Icons API or the owning Component size contract.

## Approved exceptions

- `currentColor`, `aria-hidden`, and `focusable="false"` are allowed.
- Fixed SVG dimensions are allowed only in approved icon source files, manifest-backed renderer output, or an owning Component size contract where fixed geometry is required.
- Status icon color inheritance is allowed when the owning Component supplies visible status text or accessible status semantics.

## Deferred / blocked checks

- Pictograms remain separate and deferred.
- Full component-level icon hit target coverage belongs in Component tests.

## Implementation notes

- Element tests own manifest and renderer boundaries.
- Component tests own icon placement, accessible names, and behavior in context.
