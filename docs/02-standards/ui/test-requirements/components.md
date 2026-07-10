# Component Test Requirements

## Purpose

This file defines layer-level Component test requirements. Per-component requirement files are not created in this pass.

## Required Test Coverage

Components must test:

- exact consumption of required Element APIs: Color, Themes, Spacing, Typography, Motion, Icons, and 2x Grid where relevant
- public Blade, class, JavaScript, and data attribute contracts
- public variants, sizes, densities, modifiers, and options from the owning Component standard
- default, hover, focus-visible, active/pressed, disabled, loading, validation, selected, empty, and skeleton states where applicable
- keyboard behavior, ARIA semantics, naming, focus management, status messaging, and reduced-motion behavior
- no raw values, primitive palette usage, raw type values, raw motion values, or unapproved local tokens in component CSS
- rendered evidence examples proving canonical calls, state coverage, and related APIs

## Adopted Carbon Parity

Component tests should compare against Carbon component tests only for adopted concepts. React-only implementation details do not become Login App requirements unless the owning Component standard adopts the behavior.

For component color tokens, only Button, Content switcher, Notification, and Tag may use Carbon component-token families unless the Token Governance and Color standards are updated first.

## Governance Boundaries

Component tests own exact local consumption. Element tests own global bypass prevention.

A Component test should fail when the component:

- uses a token outside its approved Element or component-token API
- invents a local variant, local token, or local state not documented by the Component standard
- renders stale rendered evidence examples that no longer match the installed source
- bypasses lower-tier Components that own the primitive behavior

## Executable Test Locations

Expected executable ownership path:

- `resources/views/components/ui/{component}/__tests__/`

Shared route or catalog coverage may remain in:

- `owner-specific feature tests`
- `tests/Unit/Ui/`

Do not create executable tests from this requirements file alone.

## Status

Layer requirement status: `planned`.
