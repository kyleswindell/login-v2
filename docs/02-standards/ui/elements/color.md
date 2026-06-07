# Color Foundation Standard

## Purpose

Color defines semantic roles for palette, surfaces, text, icons, borders, actions, status, focus, loading, inverse, and high-contrast states across supported themes.

## Current Implementation

Login App 2.0 uses app-owned CSS variables such as `--ui-text-strong`, `--ui-surface`, `--ui-border-default`, `--ui-link-text`, `--ui-action-primary-bg`, `--ui-status-danger-bg`, `--ui-alert-danger-bg`, `--ui-focus-ring`, and `--ui-shadow-color`.

## UI Reference Route

`/platform/ui-reference/elements/color`

Token palette matrix: `/platform/ui-reference/elements/color/tokens`

## Required Visible Examples

- full app palette: neutral ramp, blue/action ramp, and support colors
- token role groups for text, link, icon, surface, field, border, status, alert, and skeleton/loading
- enabled, hover, active, selected, focus, and disabled state examples
- light and dark layering models with nested depth examples:
  - White-equivalent: background White, then G10, White, G10
  - Gray 10-equivalent: background G10, then White, G10, White
  - Gray 90-equivalent: background G90, then G80, G70, G60
  - Gray 100-equivalent: background G100, then G90, G80, G70
- app examples for alerts, form field, selected row, icon button, destructive action, and link
- high-contrast and inverse moments

## Token/Class/API Reference

Use app token variables and component classes, including `ui-button`, `ui-input`, `ui-inline-alert-*`, `ui-status-pill`, `ui-status-inline-*`, `ui-link`, and focus-visible treatment backed by `--ui-focus-ring`.

The Color Token Palette route owns the full role-family matrix for background, layer, layer accent, field, border, text, link, syntax, icon, support/status, focus, inverse, skeleton/loading, component aliases, and AI-token disposition.

## Usage Guidance

Use role-based color tokens, not raw hex values, for components and interaction states. Blue is reserved for primary actions and links. Support colors are reserved for semantic error, warning, success, information, and destructive meaning. Light theme layers alternate between White and G10; dark theme layers become one neutral step lighter with each nested depth.

Carbon's selected/active step logic is comparison guidance only. Login App implements state deltas through explicit role tokens and component classes.

## Accessibility Notes

Focus states are required on all interactive elements and must remain visible in every supported theme. Text and meaningful icons must meet contrast requirements. Disabled states may be lower emphasis, but they must remain distinguishable from enabled and selected states.

## Developer Notes

Do not use hover colors as static colors. Do not use support colors for decoration. High-contrast moments belong to Color, not Themes, because they change token context.

## Implementation Status

Guide status: Implemented. System maturity: Implemented.

## Carbon Comparison Notes

Carbon informs palette organization, layer logic, selected/active/focus state vocabulary, high-contrast treatment, and token-family completeness. Login App keeps app-owned token names and chooses values by design role, contrast, state behavior, layer logic, and accessibility first.

Carbon color values may be used when they are the best fit for those principles. They should not be copied blindly or rejected solely because they are Carbon values.
