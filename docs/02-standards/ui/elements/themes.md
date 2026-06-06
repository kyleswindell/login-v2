# Themes Foundation Standard

## Purpose

Themes assign visual values to stable token roles so the same UI can render across light, muted, dark, and inverse contexts.

## Current Implementation

Login App 2.0 resolves theme behavior through root and scoped CSS variables for surfaces, text, borders, icons, actions, status, focus, and shadows.

## UI Reference Route

`/platform/ui-reference/elements/themes`

## Required Visible Examples

- static theme matrix for app default, White-equivalent, Gray 10-equivalent, Gray 90-equivalent, and Gray 100-equivalent contexts
- comparison cards for page background, layer, field, text, border, icon, link, focus, and support colors
- component preview matrix for button, form field, select/dropdown, table, card, modal, notification, and icon button
- layering examples for card on page, dropdown on card, modal on overlay, and nested panels
- inline theme examples for light page with dark shell/header, dark panel inside light page, and high-contrast moment
- approved custom token override table with reason, owner, and source file

## Token/Class/API Reference

Theme work should use scoped CSS variables, app surface classes, and component classes. Example owner files include `resources/css/app.css`, `resources/css/ui/theme-seed.css`, and UI Reference element example partials.

## Usage Guidance

Themes change token values, not token roles. Components must use theme-aware tokens for background, text, border, icon, focus, and support states.

Avoid hard-coded component colors and undocumented scoped overrides.

## Accessibility Notes

Every component must preserve focus visibility, semantic status meaning, and text/icon contrast across supported theme contexts.

## Developer Notes

Custom theme overrides must be documented with a reason, owner, and file location. Inline high-contrast moments are allowed only when they use approved inverse or scoped tokens.

## Implementation Status

Partial.

## Carbon Comparison Notes

Carbon's White, Gray 10, Gray 90, and Gray 100 themes inform the page structure. Login App uses equivalent app-defined contexts rather than Carbon values.
