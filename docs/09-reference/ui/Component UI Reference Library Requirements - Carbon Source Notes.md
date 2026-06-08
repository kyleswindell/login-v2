# Component UI Reference Library Requirements - Carbon Source Notes

## Purpose

This reference note preserves the Carbon component coverage inputs used to shape the Login App 2.0 Components UI Reference requirements. It is non-canonical support. Canonical Login App rules live under `docs/02-standards/ui/components/`.

## Source Baseline

Carbon's component overview and component-specific usage pages were used as a completeness benchmark for the Login App Components catalog. Login App keeps its own visual system, route model, tokens, Blade components, JavaScript modules, and accessibility contracts.

Primary comparison sources:

- Carbon components overview: `https://carbondesignsystem.com/components/overview/components/`
- Carbon component accessibility status: `https://carbondesignsystem.com/components/overview/accessibility-status/`
- Carbon feature flags: `https://carbondesignsystem.com/components/overview/feature-flags/`
- Carbon Button: `https://carbondesignsystem.com/components/button/usage/`
- Carbon Text input: `https://carbondesignsystem.com/components/text-input/usage/`
- Carbon Dropdown: `https://carbondesignsystem.com/components/dropdown/usage/`
- Carbon Form: `https://carbondesignsystem.com/components/form/usage/`
- Carbon Data table: `https://carbondesignsystem.com/components/data-table/usage/`
- Carbon Modal: `https://carbondesignsystem.com/components/modal/usage/`
- Carbon Notification: `https://carbondesignsystem.com/components/notification/usage/`
- Carbon AI label: `https://carbondesignsystem.com/components/ai-label/usage/`
- Carbon UI shell header: `https://carbondesignsystem.com/components/UI-shell-header/usage/`
- Carbon UI shell left panel: `https://carbondesignsystem.com/components/UI-shell-left-panel/usage/`
- Carbon UI shell right panel: `https://carbondesignsystem.com/components/UI-shell-right-panel/usage/`

## Adopted App Requirements

The app adopted the Carbon-informed structure as an app-owned Component page contract:

- purpose
- use when
- do not use when
- live examples
- variants
- states
- anatomy
- behavior
- accessibility requirements
- content guidance
- developer implementation
- related Components and Patterns
- implementation status

## App-Specific Decisions

- Keep `/platform/ui-reference` as the route root.
- Keep flat `/platform/ui-reference/components/{component}` routes canonical.
- Label the UI Reference menu as `Components` and `Patterns`; tier vocabulary remains explanatory, not the primary menu label.
- Treat Foundation Elements as required inputs for all Component, Pattern, and later feature UI work.
- Do not copy Carbon visuals, token values, icon packages, pictograms, or React feature-flag behavior without a separate app decision.
