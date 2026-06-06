# Grid Foundation Standard

## Purpose

Define responsive page, section, dashboard, and widget geometry for Login App 2.0.

## Current Implementation

The app uses Tailwind-compatible grids, section wrappers, dashboard grid contracts, and widget span examples. The accepted direction is an 8px-compatible foundation, not a direct Carbon 2x Grid clone.

## UI Reference Route

`/platform/ui-reference/elements/grid`

## Required Visible Examples

- 2x/8px-compatible spacing decision
- page content regions
- card grids
- dashboard widget grid

## Usage Rules

- Components use the region given to them; they do not create page layout through external margins.
- Parent layouts own page, section, card, table, form, and dashboard grid spacing.
- Fixed region dimensions should be declared by the owning pattern or layout standard.

## Queued Gaps

- A broader breakpoint and region matrix is queued for future layout hardening.

## Carbon Comparison Notes

Carbon's 2x Grid informs the 8px-compatible baseline and region thinking, but Login App does not adopt Carbon's exact grid package or IBM layout assets.
