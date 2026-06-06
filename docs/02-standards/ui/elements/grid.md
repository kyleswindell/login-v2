# 2x Grid Foundation Standard

## Purpose

The 2x Grid controls page-level structure, alignment, columns, gutters, margins, and responsive layout behavior.

## Current Implementation

Login App uses a Tailwind-compatible, 8px-centered layout model with CSS Grid and utility classes. Carbon alignment is treated as a benchmark when page structure needs strict responsive review.

## UI Reference Route

`/platform/ui-reference/elements/grid`

Alias: `/platform/ui-reference/elements/2x-grid`

## Required Visible Examples

- responsive grid visualizer with columns, margins, padding, gutters, viewport indicator, and overlay affordance
- breakpoint examples for 320px, 672px, 1056px, 1312px, and 1584px
- 4-column, 8-column, and 16-column demonstrations
- full, half, quarter, sidebar/content, and dense dashboard spans
- gutterless, standard gutter, close-content, and separated-content examples
- padding and margin examples aligned to spacing tokens
- fluid, fixed, and hybrid box examples
- app scaffold with header, global side nav, local side nav, main content, right panel, and modal/dialog

## Token/Class/API Reference

Use approved grid utilities, CSS Grid classes, page shell components, and spacing tokens. Example classes include `grid`, `gap-*`, `xl:grid-cols-*`, and app pattern wrappers such as dashboard grid and widget shell.

## Usage Guidance

Use the grid for page-level structure and spacing tokens for local component relationships. Do not assume Bootstrap-style or ad hoc row/column layouts are grid-compliant.

Avoid arbitrary layout widths that break alignment across page regions.

## Accessibility Notes

Responsive layout changes must preserve source order, heading hierarchy, keyboard order, and visible focus position.

## Developer Notes

Test layouts at 320px, 672px, 1056px, 1312px, and 1584px when Carbon-style alignment matters. Components do not own page grid behavior.

## Implementation Status

Partial.

## Carbon Comparison Notes

Carbon's 2x Grid informs the breakpoint and column benchmark. Login App keeps its own Tailwind-compatible implementation.
