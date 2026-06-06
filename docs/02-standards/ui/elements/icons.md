# Iconography Foundation Standard

## Purpose

Define how UI icons communicate action, status, navigation, and affordance meaning.

## Current Implementation

Heroicons are the default app icon library.

## UI Reference Route

`/platform/ui-reference/elements/icons`

## Required Visible Examples

- 16px inline icon
- 20px action icon
- 44px touch target
- decorative versus semantic icon usage
- icon and text center alignment

## Usage Rules

- Do not import Carbon icons without a separate decision record.
- Icons are monochrome and inherit text, action, or status color.
- Icons paired with text should center-align with the text row.
- Interactive icon targets must provide an accessible label.
- Decorative icons must be hidden from assistive technology.

## Queued Gaps

- A common Heroicon mapping table is queued for later component-family depth passes.

## Carbon Comparison Notes

Carbon icon guidance informs sizing, touch target, color, and alignment rules. Login App uses Heroicons rather than the Carbon icon package.
