# Pattern Test Requirements

## Purpose

This file defines layer-level Pattern test requirements. Per-pattern requirement files are not created in this pass.

## Required Test Coverage

Patterns must test:

- composition-level Element API consumption for Color, Themes, Spacing, Typography, Motion, Icons, and 2x Grid where relevant
- approved child Component usage and no local replacement of component-owned internals
- route/page-level semantics, landmarks, heading structure, accessible names, focus order, and status messaging
- responsive and layout behavior owned by the Pattern
- loading, empty, error, blocked, validation, persistence, and overflow behavior owned by the Pattern
- no raw colors, arbitrary spacing, raw type values, raw motion values, or local component-token substitutes in Pattern CSS or views
- rendered evidence proof for representative production-like compositions

## Pattern-Specific Focus Areas

- Forms: validation placement, field composition, error/helper text, action placement, and disabled/loading behavior.
- Navigation: shell composition, active/current state, skip links, responsive movement, and approved menu/search usage.
- Overlays and actions: modal/popover/menu coordination, focus entry/return, dismissal behavior, and action hierarchy.
- Feedback and notifications: status semantics, non-color cues, announcement behavior, and transient/persistent boundaries.
- Layout and data/content: grid rhythm, content hierarchy, responsive regions, table/detail composition, and empty/error states.

## Governance Boundaries

Pattern tests should fail when a Pattern:

- overrides component-owned internals to create unofficial variants
- redefines Element tokens locally
- composes unapproved Components for a behavior owned by another Pattern or Component
- uses layout-local scales instead of 2x Grid, Spacing, or Pattern-owned layout rules

## Executable Test Locations

Expected executable ownership paths:

- `owner-specific feature tests`
- future co-located Pattern source test folders if a Pattern implementation root is approved
- `tests/Unit/Ui/` for shared static governance helpers

Do not create executable tests from this requirements file alone.

## Status

Layer requirement status: `planned`.
