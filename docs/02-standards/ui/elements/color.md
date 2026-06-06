# Color Foundation Standard

## Purpose

Color defines semantic roles for surfaces, text, icons, borders, actions, status, focus, and loading states across supported themes.

## Current Implementation

Login App 2.0 uses CSS custom properties such as `--ui-text-strong`, `--ui-surface`, `--ui-border-default`, `--ui-action-primary-bg`, `--ui-status-danger-bg`, and `--ui-shadow-panel`. Current names may remain as accepted aliases unless a later token migration is approved.

## UI Reference Route

`/platform/ui-reference/elements/color`

## Required Visible Examples

- app default, White-equivalent, Gray 10-equivalent, Gray 90-equivalent, and Gray 100-equivalent theme swatches
- rendered examples for background, layer, field, border, text, link, icon, support/status, focus, and skeleton/loading token groups
- page background, first layer, second layer, third layer, and nested card/modal/dropdown layering
- enabled, hover, active, selected, focus, and disabled states
- error, warning, success, info, required field, destructive action, and status badge examples
- button, link, alert, form field, table row selection, status tag, and icon button examples
- high-contrast moments including light component on dark background, dark shell on light page, and inverse tooltip-style surface

## Token/Class/API Reference

Use semantic CSS variables through component classes and utilities. Examples include `class="ui-button"`, `class="ui-input"`, `class="ui-status"`, `style="color: var(--ui-text-strong)"`, and `style="background: var(--ui-surface)"`.

## Usage Guidance

Use role-based color tokens, not raw hex values. Blue is reserved for primary actions and links. Support colors are reserved for semantic error, warning, success, and information states. Hover, active, selected, focus, and disabled states must use state tokens or approved component classes, not static reused hover colors.

Avoid using action colors for running text, status colors as decoration, or hard-coded color values in components.

## Accessibility Notes

Focus states are required for interactive elements. Text and meaningful icons must meet contrast requirements in every supported theme. Disabled-state contrast may be lower, but disabled controls must remain visually identifiable and not imply interactivity.

## Developer Notes

`text-primary` means primary content hierarchy, not primary blue action color. Prefer existing component classes before adding new color utilities. If a theme layer requires a different hover delta, document the token or class that owns the behavior.

## Implementation Status

Implemented.

## Carbon Comparison Notes

Carbon's color model informs the role/theme structure. Login App keeps its own token names, values, and visual direction.
