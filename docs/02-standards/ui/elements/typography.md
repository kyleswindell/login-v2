# Typography Foundation Standard

## Purpose

Define type roles, hierarchy, labels, helper text, error text, code text, and type color.

## Current Implementation

Login App uses app-owned typography utilities and UI Reference classes such as page titles, card titles, body copy, labels, helper text, and code samples.

## UI Reference Route

`/platform/ui-reference/elements/typography`

## Required Visible Examples

- page title
- section title
- card title
- table header
- body
- muted text
- label
- helper text
- error text
- code text

## Usage Rules

- Apply typography rules directly in rendered examples instead of only describing them.
- Type color uses text tokens, not action tokens.
- Running text should remain neutral.
- Action color belongs to links and controls.
- Component labels should use clear sentence case unless a component standard explicitly requires another treatment.

## Queued Gaps

- A complete type-role token table is queued after the current UI Reference foundation pass.

## Carbon Comparison Notes

Carbon typography informs the idea of role-based type tokens. Login App does not adopt IBM Plex-specific type sets by default.
