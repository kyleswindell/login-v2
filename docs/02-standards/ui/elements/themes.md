# Themes Foundation Standard

## Purpose

Themes assign visual values to stable token roles so the same component markup can render across app default, light, muted-light, dark, and dark-base contexts.

## Current Implementation

Login App 2.0 resolves theme behavior through root and scoped CSS variables for color, spacing, typography, and component/global roles.

## UI Reference Route

`/platform/ui-reference/elements/themes`

## Required Visible Examples

- theme terms: Theme, Token, Role, Value
- applied matrix for app default, White-equivalent, Gray 10-equivalent, Gray 90-equivalent, and Gray 100-equivalent contexts
- token role/value table showing the same roles across light and dark values
- component preview matrix for button, icon button, form field, table row, and notification
- token categories: Color, Spacing, Typography, Global/component-specific
- link to Color for high-contrast and inverse moments

## Token/Class/API Reference

Use stable token roles and resolved theme values. Do not change a role between themes. Component classes must consume theme-aware tokens rather than hard-coded theme-specific values.

## Usage Guidance

Themes change token values, not token roles. A custom theme starts from the default token map and overrides approved values with documented owner, reason, and source file.

## Accessibility Notes

Every supported theme must preserve contrast, focus visibility, semantic feedback meaning, and usable disabled states.

## Developer Notes

Themes do not own interaction-state or high-contrast rules; those are Color rules. Themes own token role/value inheritance and theme-wide override governance.

## Implementation Status

Guide status: Implemented. System maturity: Partial.

## Carbon Comparison Notes

Carbon's theme terms and four-theme model inform organization. Login App uses equivalent contexts and app-owned values, not Carbon Sass configuration.
