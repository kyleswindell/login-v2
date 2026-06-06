# Spacing Foundation Standard

## Purpose

Define spacing scale and ownership rules across components and layout patterns.

## Current Implementation

Login App uses a Tailwind-compatible, 8px-centered spacing model with smaller increments available for dense UI.

## UI Reference Route

`/platform/ui-reference/elements/spacing`

## Required Visible Examples

- spacing scale
- stack and gap wrapper
- form row
- action row
- table cell
- card grid

## Usage Rules

- Components own internal padding, icon gap, label gap, border, radius, min-height, and typography.
- Components must not ship with default external margins.
- Parent layouts own external spacing through gap, stack, grid, action row, form row, or table/list cell patterns.
- Use spacing to communicate grouping and hierarchy.

## Queued Gaps

- A named stack/gap helper class set is queued if repeated wrappers become noisy.

## Carbon Comparison Notes

Carbon spacing tokens and stack guidance support the same ownership principle: components should not rely on self-owned margins for layout.
