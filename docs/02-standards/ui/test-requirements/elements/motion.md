---
title: Motion Test Requirements
slug: motion
requirement_layer: foundation-element
element: Motion
status: partial
priority: medium
relative_path: docs/02-standards/ui/test-requirements/elements/motion.md
canonical_standard: docs/02-standards/ui/elements/motion.md
runtime_contract: resources/views/elements/motion/contract.php
rendered_evidence_route: null
---

# Motion Test Requirements

| Metadata | Value |
| --- | --- |
| Relative path | `docs/02-standards/ui/test-requirements/elements/motion.md` |
| Purpose | Verify adopted Carbon durations/easings, reduced-motion behavior, and prevention of raw motion timing in consumers. |
| Requirement status | `partial` |
| Owner | Foundation Element: Motion |
| Canonical standard | `docs/02-standards/ui/elements/motion.md` |
| Runtime contract | `resources/views/elements/motion/contract.php` |
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

Motion tests verify adopted Carbon durations/easings, reduced-motion behavior, and prevention of raw motion timing in consumers.

## Source files

- Standard: `docs/02-standards/ui/elements/motion.md`
- Runtime contract: `resources/views/elements/motion/contract.php`
- Token sources: `resources/css/tokens/motion.css`
- Consumer scan targets: `resources/css/base/**`, `resources/css/components/**`, `resources/css/patterns/**`, `resources/js/ui-controls/**`
- Controller scan note: `resources/js/ui-controls/**` exists and remains in scope, but JavaScript controller timing governance is `needs-confirmation` until controller-level requirements define owned timing APIs.
- rendered evidence proof: `not installed`

## Required automated checks

- Verify adopted duration tokens and easing roles match approved Carbon values.
- Verify motion token aliases expose productive standard, entrance, and exit roles where installed.
- Verify animated surfaces that affect spatial movement, visibility, loading/progress perception, or state comprehension include `prefers-reduced-motion: reduce` coverage.
- Verify motion is not required to understand state.

## Required governance checks

- Fail raw transition or animation duration values in consumers unless narrowly approved. Motion token source files are excluded when they define approved duration roles.
- Fail raw easing values such as `ease`, `linear`, and `cubic-bezier(...)` in consumers unless mapped to approved Motion roles. Motion token source files are excluded when they define approved easing roles.
- Report JavaScript timing constants in `resources/js/ui-controls/**` and inline UI scripts unless the timing is clearly an animation duration/easing duplicate. Hard failure for JavaScript timing is deferred until controller-level timing ownership is approved.
- Classify color-only or outline-only transitions separately from transform, opacity, position, height, width, or layout motion.

## Required manual review proof

- Review Motion rendered evidence examples for productive movement, loading/progress behavior, and reduced-motion guidance.
- Confirm state remains understandable when motion is reduced.

## Failure conditions

- A consumer hard-codes transition or animation timing.
- An animated surface lacks reduced-motion coverage.
- Motion alone communicates status, selection, loading, error, or completion.
- Spatial movement, visibility changes, loading/progress perception, or state comprehension relies on motion without reduced-motion coverage.

## Approved exceptions

- `none`, `0s`, `0ms`, keyframe percentages, transform mechanics, and reduced-motion overrides are allowed.
- Motion token source files may define raw duration and easing values when mapped into approved Motion roles.
- Carbon structural animation values for spinner or progress geometry may be approved when the owning Component requirement documents the value and reason.

## Deferred / blocked checks

- Expressive motion remains gated until approved by the Motion standard.
- Full JavaScript timing governance is deferred until controller-level test requirements are written.

## Implementation notes

- Categorize skeleton, loading, progress, overlay, and disclosure motion separately.
- Avoid broad path allowlists; use property/value-specific exceptions.
