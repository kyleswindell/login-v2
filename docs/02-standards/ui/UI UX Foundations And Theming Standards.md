# UI UX Foundations And Theming Standards

This document defines the canonical scope and intent for UI UX Foundations And Theming Standards.

## Purpose

Define foundational UI standards for color, typography, spacing, elevation, shape, motion, and accessibility.

This note is the canonical owner for foundational UI/UX semantic roles, Tier 1 variant model, and required state model.

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

### Canonical Semantic Set

The canonical Tier 1 semantic set is:

- `primary`
- `neutral`
- `success`
- `warning`
- `danger`
- `info`
- `notice`

Meaning rules:

- `primary` = default high-emphasis action or highlighted primary state
- `neutral` = non-destructive default baseline state
- `success` = positive completion or healthy state
- `warning` = caution requiring attention
- `danger` = destructive or failing state
- `info` = informational system context
- `notice` = policy, announcement, or non-error attention state that should remain distinct from warning and info

This semantic set applies across Tier 1 buttons, badges/status, toast, and inline alert usage. Components may use only an explicit subset of this set as defined by their own Tier 1 contract.

### Semantic token groups

Required groups:

- background (`canvas`, `surface`, `surface-muted`, `surface-elevated`)
- text (`primary`, `secondary`, `muted`, `inverse`)
- border (`subtle`, `default`, `strong`)
- action semantics (`primary`, `neutral`)
- action variants (`base`, `soft`, `outline`, `ghost`)
- feedback (`success`, `info`, `warning`, `danger`, `notice`)
- focus (`ring`, `ring-offset`)

### Action token mapping baseline

Use the following rule everywhere:

1. semantic action roles are `primary`, `neutral`, `success`, `warning`, `danger`, `info`, and `notice`
2. `secondary` describes emphasis priority, not a separate semantic token family
3. `ghost` and `outline` are variants, not semantic roles
4. secondary-emphasis actions map to neutral-family action tokens in the design system rather than a standalone `secondary` token family

Canonical owner:

- [UI UX Color Token Standards](tokens/UI%20UX%20Color%20Token%20Standards.md)

Theme direction: neutral enterprise baseline with restrained accent.

### Tier 1 Variant Model

The global Tier 1 variant model is:

- `base`
- `soft`
- `outline`
- `ghost`

Variant intent:

- `base` = default filled or primary surface treatment for the chosen semantic role
- `soft` = reduced-intensity treatment using subtle semantic surfaces
- `outline` = bordered treatment with transparent or minimal fill
- `ghost` = minimal-chrome treatment with transparent background and no persistent border

Variants are defined once here. Components may use only an explicit subset of this variant model as defined by their own Tier 1 contract.

Tier 1 use rule:

1. `ghost` and `outline` are never semantic roles
2. `ghost` is action-only in Tier 1 unless a later contract explicitly expands it
3. `soft` and `ghost` are not available to non-action Tier 1 surfaces unless a component contract explicitly allows them

### Light and dark theme requirements

Every semantic token must define:

1. light value
2. dark value
3. contrast check target
4. hover/active/disabled variants

Theme tokens must support future DB-backed palette storage and runtime substitution.

### Alert and state colors

Required states:

- `default`
- `hover`
- `active`
- `disabled`
- `focus`
- `selected`

### Required State Model

The required Tier 1 state model for all semantics is:

- `default`
- `hover`
- `active`
- `disabled`
- `focus`
- `selected`

State rules:

1. every semantic role must define all six states
2. the same state model applies to action surfaces and non-action semantic surfaces
3. components may ignore non-applicable interactive rendering, but the semantic token/state mapping must still exist canonically
4. `selected` is required for persistent picked/current-state surfaces and must not be replaced by `active`

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
