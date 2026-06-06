# Spacing Foundation Standard

## Purpose

Spacing controls layout rhythm and relationships between UI elements.

## Current Implementation

Login App uses a Tailwind-compatible, 8px-centered spacing model with documented spacing aliases `$spacing-01` through `$spacing-13`.

## UI Reference Route

`/platform/ui-reference/elements/spacing`

## Required Visible Examples

- full spacing scale from `$spacing-01` through `$spacing-13` with rem, px, and utility/helper mapping
- margin examples for top, right, bottom, left, horizontal, and vertical spacing
- padding examples for card, form group, section, and dense table contexts
- stack examples for vertical, horizontal, small, medium, large, form field group, and button group spacing
- relationship examples for label/input, input/helper, heading/content, card title/body, card/card, and section/section
- density examples for dense admin table, standard form, and spacious help panel

## Token/Class/API Reference

Use spacing tokens, Tailwind spacing utilities, and parent layout helpers such as stack, grid, gap, form row, action row, and dashboard/widget patterns.

## Usage Guidance

Use spacing tokens for margin, padding, and gaps. Components own internal spacing; parent layouts own external spacing. Smaller spacing indicates close relationship; larger spacing separates sections and creates hierarchy.

Avoid arbitrary pixel values unless a documented exception owns the exact value.

## Accessibility Notes

Spacing must preserve readable grouping, tappable targets, and visible focus outlines. Dense layouts still need enough room for errors, helper text, and keyboard focus.

## Developer Notes

Components must not ship with unpredictable default external margins. Compose external spacing through parent stack, gap, grid, action-row, or form-row patterns.

## Implementation Status

Implemented.

## Carbon Comparison Notes

Carbon's spacing scale informs the token structure. Login App keeps its own utility mapping and existing layout conventions.
