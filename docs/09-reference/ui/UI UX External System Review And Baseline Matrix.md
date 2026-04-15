# UI UX External System Review And Baseline Matrix

This document defines the canonical scope and intent for UI UX External System Review And Baseline Matrix.

## Purpose

Capture comparison notes between Material and Carbon guidance as support input for Login App 2.0 UI standards work.

This note is research support only and does not serve as canonical policy.

## Reference Scope

Reviewed systems:

- Material guidance (`m2.material.io`, with `m1.material.io` references when JS extraction is limited)
- IBM Carbon Design System guidance (tokens, accessibility, enterprise interaction patterns)

## Comparative Observations

### Foundational alignment

Both systems emphasize:

1. token-driven design systems over ad hoc values
2. explicit light/dark theming models
3. consistent spacing and typography systems
4. accessibility-first interaction defaults
5. predictable component behavior patterns

### Comparative tendencies

Material patterns are generally stronger for:

- responsive layout flow examples
- motion communication patterns
- interaction affordance clarity in common app flows

Carbon patterns are generally stronger for:

- enterprise-scale token governance
- component-level accessibility detail
- dense operational surface patterns

## Candidate Decision Areas (Research Inputs)

Potential areas where canonical standards may need explicit decisions:

1. spacing and typography token structure
2. elevation and layer model
3. interaction-state semantics
4. table/form/overlay behavior baselines
5. navigation and action placement consistency
6. feedback timing and notification semantics

These items are retained as research prompts, not rule statements.

## Baseline Context Notes

Historical baseline context captured from prior research:

1. accessibility target discussion centered on WCAG 2.2 AA
2. typography and color direction discussions referenced dedicated standards notes
3. corner-radius and iconography discussions converged on a conservative enterprise baseline
4. theming discussions included future DB-backed token storage concepts

## External References

Material references:

- https://m2.material.io
- https://m2.material.io/inline-tools/typography/
- https://m1.material.io/
- https://m1.material.io/style/color.html
- https://m1.material.io/style/typography.html
- https://m1.material.io/layout/metrics-keylines.html
- https://m1.material.io/layout/responsive-ui.html
- https://m1.material.io/motion/duration-easing.html
- https://m1.material.io/usability/accessibility.html

Carbon references:

- https://carbondesignsystem.com/elements/color/overview/
- https://carbondesignsystem.com/elements/themes/overview/
- https://carbondesignsystem.com/elements/2x-grid/overview/
- https://carbondesignsystem.com/elements/spacing/overview/
- https://carbondesignsystem.com/elements/icons/usage/
- https://v10.carbondesignsystem.com/components/data-table/usage/
- https://v10.carbondesignsystem.com/components/text-input/usage/
- https://v10.carbondesignsystem.com/components/notification/usage/
- https://v10.carbondesignsystem.com/patterns/empty-states-pattern/
- https://v10.carbondesignsystem.com/guidelines/accessibility/overview/

## Related

- [UI UX Source Of Truth And Decision Log](../../02-standards/ui/UI%20UX%20Source%20Of%20Truth%20And%20Decision%20Log.md)
- [UI UX Foundations And Theming Standards](../../02-standards/ui/UI%20UX%20Foundations%20And%20Theming%20Standards.md)
- [UI Design System Standards](../../02-standards/ui/UI%20Design%20System%20Standards.md)
