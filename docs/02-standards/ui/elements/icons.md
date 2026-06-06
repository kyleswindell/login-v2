# Icons Foundation Standard

## Purpose

Icons communicate actions, status, or meaning at a glance inside dense product UI.

## Current Implementation

Heroicons remain the approved UI icon library unless a later decision record changes the dependency.

## UI Reference Route

`/platform/ui-reference/elements/icons`

## Required Visible Examples

- approved Heroicons table with name, category, size options, usage notes, and helper/import reference
- size examples for 16px, 20px, 24px, and 32px
- icon with text examples for leading icon, trailing icon, inline link, button, and menu item
- icon-only controls for default, hover, active, focus, disabled, and loading where used
- status icons for error, warning, success, info, and in-progress
- decorative versus meaningful icon examples
- icon-only button with tooltip/access name
- 44px or 48px hit target demonstration

## Token/Class/API Reference

Use Heroicons through existing Blade/icon helpers, app button/menu/link classes, and token-aware icon color. Example helpers include `x-layouts.nav-icon` and Heroicon SVG use in Blade components.

## Usage Guidance

Use 16px icons for most dense UI. Use 20px, 24px, or 32px only when surrounding layout requires a larger visual symbol. Icons should be monochrome, theme-aware, and match paired text unless semantic meaning requires a status color.

Avoid decorative icons that do not add meaning.

## Accessibility Notes

Interactive icon controls need a minimum 44px target. Decorative icons must be hidden from screen readers. Meaningful icons and icon-only buttons need accessible labels.

## Developer Notes

Add padding around icons to meet target size instead of scaling icons unnecessarily. Do not import Carbon icons without a separate decision record.

## Implementation Status

Implemented.

## Carbon Comparison Notes

Carbon icon usage informs sizing and accessibility expectations. Login App uses Heroicons, not Carbon icons.
