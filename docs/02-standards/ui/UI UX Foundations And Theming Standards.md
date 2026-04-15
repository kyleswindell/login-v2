# UI UX Foundations And Theming Standards

This document defines the canonical scope and intent for UI UX Foundations And Theming Standards.

## Purpose

Define foundational UI standards for color, typography, spacing, elevation, shape, motion, and accessibility.

This note is the canonical owner for foundational UI/UX token and theme rules.

## Design Principles

These principles govern all new UI work:

1. clarity over novelty
2. consistent behavior across surfaces
3. accessibility by default
4. meaningful hierarchy and emphasis
5. responsive parity across desktop and mobile
6. predictable interaction feedback

## Foundational Token System

### Spacing scale

Base unit: `8px`

Token set:

- `space-1 = 4px`
- `space-2 = 8px`
- `space-3 = 12px`
- `space-4 = 16px`
- `space-5 = 24px`
- `space-6 = 32px`
- `space-7 = 40px`
- `space-8 = 48px`
- `space-9 = 64px`

### Typography hierarchy

Required roles:

- Display
- Page title
- Section title
- Body large
- Body
- Caption
- Label/button

Canonical owner:

- [UI UX Typography Standards](UI%20UX%20Typography%20Standards.md)

### Shape and corners

Required corner scale:

- `radius-xs`
- `radius-sm`
- `radius-md`
- `radius-lg`
- `radius-xl`
- `radius-pill`

Default baseline for core components: `4px / 6px / 8px`.

### Elevation and layering

Required elevation layers:

- base surface
- raised card
- sticky header
- dropdown
- drawer/side panel
- modal
- toast/alert overlay

### Motion and interaction curves

Define all of the following:

- standard duration tokens (`fast`, `base`, `slow`)
- entry/exit curves
- reduced-motion fallback behavior

## Color And Theme Baseline

### Semantic token groups

Required groups:

- background (`canvas`, `surface`, `surface-muted`, `surface-elevated`)
- text (`primary`, `secondary`, `muted`, `inverse`)
- border (`subtle`, `default`, `strong`)
- action (`primary`, `secondary`, `ghost`)
- feedback (`success`, `info`, `warning`, `danger`, `notice`)
- focus (`ring`, `ring-offset`)

Canonical owner:

- [UI UX Color Token Standards](tokens/UI%20UX%20Color%20Token%20Standards.md)

Theme direction: neutral enterprise baseline with restrained accent.

### Light and dark theme requirements

Every semantic token must define:

1. light value
2. dark value
3. contrast check target
4. hover/active/disabled variants

Theme tokens must support future DB-backed palette storage and runtime substitution.

### Alert and state colors

Required states:

- success
- info
- warning
- danger
- disabled
- selected
- focus-visible

## Accessibility Baseline

Minimum target: WCAG 2.2 AA across all surfaces.

Required standards:

1. minimum text and non-text contrast
2. keyboard navigability for all interactive components
3. focus-visible styles with sufficient contrast
4. semantic markup, with ARIA only when needed
5. reduced-motion support
6. touch-target minimum sizing

## Related

- [UI UX Source Of Truth And Decision Log](UI%20UX%20Source%20Of%20Truth%20And%20Decision%20Log.md)
- [UI UX Color Token Standards](tokens/UI%20UX%20Color%20Token%20Standards.md)
- [UI UX Typography Standards](UI%20UX%20Typography%20Standards.md)
- [UI UX Iconography Standards](UI%20UX%20Iconography%20Standards.md)
- [UI UX Component Library Standards](components/UI%20UX%20Component%20Library%20Standards.md)
- [UI UX Source Of Truth Support Notes](../../09-reference/ui/UI%20UX%20Source%20Of%20Truth%20Support%20Notes.md)
