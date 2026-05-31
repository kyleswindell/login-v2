# UI UX Tier 1 UI Reference Implementation Checklist

This document defines the canonical scope and intent for UI UX Tier 1 UI Reference Implementation Checklist.

## Purpose

Define the concrete review checklist for Tier 1 components implemented in `/platform/ui-reference`.

This note is non-canonical support documentation for implementation/review workflow.

Canonical UI standards references:

- [UI Design System Standards](../../02-standards/ui/UI%20Design%20System%20Standards.md)
- [Component Contracts Index](../../02-standards/ui/contracts/Component%20Contracts%20Index.md)
- [Tier 1 - Consumption And Composition Contract](../../02-standards/ui/contracts/Tier%201%20-%20Consumption%20And%20Composition%20Contract.md)

## Implementation Status

Current status:

- Tier 1 views are implemented in `/platform/ui-reference`
- acceptance contracts are filled for the seven Tier 1 component groups
- matrix rows are set to `Ready For Review`
- final lock gates remain visual QA, accessibility verification, and library-readiness sign-off

## Important Limitation

This checklist proves UI Reference coverage and visible state behavior.

It does **not** by itself prove that Tier 1 is simple to consume as a reusable library. That question must be validated separately through the Tier 1 consumption/composition model.

Minimal automation policy:

- automated tests may confirm that canonical Tier 1 reference routes and known entry points still exist
- automated tests must not be treated as proof of full library ergonomics or abstraction quality

## Checklist

### Buttons and icon buttons

- UI view: `/platform/ui-reference/components/actions`
- [x] states: default, hover, focus, active, disabled, loading
- [x] light and dark theme parity
- [x] responsive wrapping and touch target sizing
- [x] accessibility proof: icon button labels, keyboard trigger, focus-visible

### Badges and status

- UI view: `/platform/ui-reference/components/status`
- [x] states: semantic variants plus soft and outline variants
- [x] light and dark theme parity
- [x] responsive usage in both inline and table contexts
- [x] accessibility proof: text labels not color-only signaling

### Inputs, textarea, select

- UI view: `/platform/ui-reference/components/forms`
- [x] states: default, focus, error, readonly, disabled
- [x] light and dark theme parity
- [x] responsive one-column and two-column layouts
- [x] accessibility proof: label association, error linkage, invalid state semantics

### Table baseline

- UI view: `/platform/ui-reference/patterns/tables`
- [x] states: filter open/close, rows-per-page, page selection, prev/next disable states, empty rows
- [x] light and dark theme parity
- [x] responsive overflow behavior for narrow widths
- [x] accessibility proof: table semantics, focusable controls, explicit action labels

### Drawer and modal baseline

- UI view: `/platform/ui-reference/patterns/tables` and `/platform/ui-reference/patterns/overlays-feedback`
- [x] states: open, close, contextual detail, destructive confirmation
- [x] light and dark theme parity
- [x] responsive container fit on narrow viewports
- [x] accessibility proof: dialog roles, escape behavior, focus handling patterns

### Toast and inline alert baseline

- UI view: `/platform/ui-reference/patterns/overlays-feedback`
- [x] states: info, success, warning, danger
- [x] light and dark theme parity
- [x] responsive toast stacking
- [x] accessibility proof: `role="status"`/`role="alert"` live region semantics

### Sidebar and account menu behavior

- UI view: `/platform/ui-reference/patterns/navigation`
- [x] states: desktop sticky, mobile toggle open/close, menu-context switching
- [x] light and dark theme parity
- [x] responsive behavior at desktop/mobile breakpoints
- [x] accessibility proof: toggle semantics, focus order, escape close behavior expectations

## Library-Readiness Companion Checks

Use this checklist alongside the canonical Tier 1 consumption contract.

- [ ] each Tier 1 reference surface points to a clear reusable entry point
- [ ] state snapshots are distinguishable from canonical production usage examples
- [ ] class/markup contracts are documented where no Blade component exists
- [ ] UI Reference is not being treated as the only definition of how a Tier 1 item is consumed

## Related

- [Component Contracts Index](../../02-standards/ui/contracts/Component%20Contracts%20Index.md)
- [UI UX Component Taxonomy And Coverage Matrix](../../02-standards/ui/components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
