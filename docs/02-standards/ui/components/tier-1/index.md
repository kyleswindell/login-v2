# Tier 1 Component Standards

Tier 1 component standards define the durable expectations for primitive UI components. The UI Reference labels this layer as **Components** so product developers can find the working component library without needing tier vocabulary.

Each implemented Component page must render final Login App examples, link back to its canonical standard, and define the approved component contract for downstream Pattern and feature work.

## Page Display Contract

Every Component page must visibly include:

- purpose
- use when
- do not use when
- live examples
- variants
- states
- anatomy
- behavior
- accessibility requirements
- content guidance
- developer implementation
- related components and patterns
- implementation status

Implemented Component pages must also visibly show default examples, supported variants or colors, focus, disabled, hover-capable default behavior, applicable error/warning/success/info states, applicable loading or read-only states, spacing and padding behavior, implementation owner, and queued gaps.

Generic fallback content is allowed only for `Queued Gap`, `Deferred`, `Do not implement`, `App-specific exception`, or `Not Applicable Yet` components. Implemented pages must show page-specific examples or remain marked as implementation-pending.

## Foundation Element Dependency

Components must consume Foundation Elements instead of redefining base visual decisions. Component and Pattern work must use approved Element standards for color tokens, spacing, grid, typography, icons, motion, and themes.

Do not introduce local component colors, arbitrary spacing, one-off typography, local icon sourcing, or custom motion timing when an Element standard exists.

## Spacing Contract

Components own internal padding, icon gap, label gap, border, radius, min-height, and typography. Parent layouts own external spacing through gap, stack, grid, action row, form row, table cell, or list row patterns.

## Component Docs

Each component doc in this folder links to the UI Reference owner route for that component.

## Component Page Intro Text

Each Component page should include this contract statement:

> This page shows the approved application implementation of this component. Use the documented variants, states, and helper APIs shown here. If a feature requires behavior not represented here, update the component contract or compose a higher-level Pattern instead of modifying the component locally.
