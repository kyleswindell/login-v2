# Icons Foundation Standard

## Purpose

Icons communicate actions, status, navigation, and affordances at a glance inside dense product UI.

## Current Implementation

Heroicons remain the approved UI icon library unless a later decision record changes the dependency.

## UI Reference Route

`/platform/ui-reference/elements/icons`

## Required Visible Examples

- approved Heroicons table with category, size, and helper reference
- size matrix for 16px, 20px, 24px, and 32px icons
- icon-with-text examples for leading, trailing, inline link, button, and menu item
- icon-only controls for default, hover, active, focus, disabled, and loading states
- status, decorative, and meaningful icon examples
- 44px icon-only hit target

## Token/Class/API Reference

Icons should use `currentColor` through app classes, text tokens, action tokens, or status tokens. Use `x-heroicon-*` components and app control classes rather than importing a second icon set.

## Usage Guidance

Use 16px and 20px icons with 14px and 16px text. Use 24px and 32px only for larger controls, panels, or visual anchors. Icons paired with text must align vertically centered with the label.

## Accessibility Notes

Decorative icons must be hidden from assistive tech. Meaningful icons and icon-only buttons need accessible names. Interactive icon controls need at least a 44px target.

## Developer Notes

Do not import Carbon icons without a separate decision record. Do not use icons as decoration when they do not add meaning.

## Implementation Status

Guide status: Implemented. System maturity: Partial.

## Carbon Comparison Notes

Carbon informs icon sizing, pairing, and accessibility expectations. Login App uses Heroicons and app token colors.
