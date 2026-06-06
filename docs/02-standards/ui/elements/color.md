# Color Foundation Standard

## Purpose

Define semantic color token namespaces for content, icons, borders, surfaces, actions, statuses, and shadows.

## Current Implementation

The app already uses CSS variables such as `--ui-text-strong`, `--ui-surface`, `--ui-border-default`, `--ui-action-primary-bg`, and `--ui-status-danger-bg`.

## UI Reference Route

`/platform/ui-reference/elements/color`

## Required Visible Examples

- light and dark text tokens
- surface tokens
- action tokens
- status tokens
- border and shadow tokens

## Usage Rules

- Use semantic tokens instead of hard-coded component colors.
- Text hierarchy tokens and action intent tokens are separate namespaces.
- `text-primary` means primary content hierarchy, not primary blue action color.
- Primary blue belongs to action and link treatment, not neutral running text.

## Queued Gaps

- Current aliases such as `--ui-text-strong` may remain until a later migration approves renaming.

## Carbon Comparison Notes

Carbon color tokens inform the token architecture. Login App keeps its own semantic token names and values.
