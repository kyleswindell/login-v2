# Tier 1 Component Implementation Checklist

This document defines the canonical scope and intent for Tier 1 Component Implementation Checklist.

## Purpose

Define the implementation checklist for true Tier 1 UI primitives and baseline structural shells only.

This checklist is the implementation-facing companion to the Tier 1 taxonomy, UI design system standards, and current Tier 1 component contracts.

It must also stay aligned with:

* [Tier 1 - Consumption And Composition Contract](../contracts/Tier%201%20-%20Consumption%20And%20Composition%20Contract.md)

## Tier Boundary

### Tier 1 Definition

Tier 1 is limited to:

* primitives
* form core inputs and validation blocks
* badge and status baseline
* table baseline
* drawer and modal baseline
* baseline shell/navigation structures
* baseline layout/scaffolding primitives

Tier 1 components are the lowest reusable layer that other patterns and features build from.

### Tier 2 Definition

Tier 2 is limited to reusable patterns composed from Tier 1, including higher-order navigation, content patterns, and workflow-oriented UI assemblies.

Tier 2 is not part of this checklist.

### Explicitly Excluded From Tier 1

The following are Tier 2 or higher and are excluded from this checklist:

* card
* empty state
* skeleton loader
* tabs
* breadcrumbs
* popover
* dropdown menu
* context menu
* button group and segmented controls
* list
* avatar
* progress bar
* pagination as a standalone pattern outside table baseline
* other pattern-level items composed from Tier 1

## Implementation Rules

* no business logic in Tier 1 components
* no feature-specific workflow behavior in Tier 1 components
* Tier 1 components must be reusable across multiple features
* Tier 1 components must use canonical tokens and current naming conventions
* Tier 1 components must support the required interaction states for their role
* Tier 1 components must be visible and testable in the UI reference workspace where applicable
* Tier 1 components must define a reusable consumption model before Tier 2 or feature work should depend on them

## Consumption And Composition Requirements

Every Tier 1 item must be reviewable not only visually, but also as a reusable building block.

At minimum, each Tier 1 item must have:

* a named role in common language
* an approved descriptor set
* a declared implementation form:
  * `Blade component`
  * `Class/markup contract`
  * `Hybrid`
  * `Missing abstraction`
* a canonical usage example
* explicit anti-drift expectations for Tier 2 and feature consumers

Tier 1 is not considered fully ready merely because UI Reference looks correct. It must also be consumable without forcing downstream work to copy snapshot markup or recreate styling from scratch.

## Tier 1A: Primitive Components

### Buttons And Icon Buttons

Contract owner:

* [Tier 1 - Buttons And Icon Buttons Contract](../contracts/Tier%201%20-%20Buttons%20And%20Icon%20Buttons%20Contract.md)

Checklist:

* [ ] Button
  Status: not implemented
  - action-token naming aligns to current canonical terminology
  - allowed variants: base, soft, outline, ghost
  - size variants align to current canonical terminology
  - states: default, hover, focus, active, disabled, loading
* [ ] Icon Button
  Status: not implemented
  - states: default, hover, focus, active, disabled
  - accessible label is required

### Input Controls Baseline

Contract owner:

* [Tier 1 - Input Controls Contract](../contracts/Tier%201%20-%20Input%20Controls%20Contract.md)

Checklist:

* [ ] Text Input
  Status: not implemented
* [ ] Textarea
  Status: not implemented
* [ ] Select
  Status: not implemented
* [ ] Checkbox
  Status: not implemented
* [ ] Radio Group
  Status: not implemented
* [ ] Switch / Toggle
  Status: not implemented

Requirements:

* allowed variants: base only
* required support:
  * label
  * helper text
  * error text
  * disabled state
  * validation messaging
  * focus-visible treatment

### Badges And Status Baseline

Contract owner:

* [Tier 1 - Badges And Status Contract](../contracts/Tier%201%20-%20Badges%20And%20Status%20Contract.md)

Checklist:

* [ ] Badge baseline
  Status: not implemented
* [ ] Status pill baseline
  Status: not implemented

Requirements:

* allowed variants: base, outline
* single-line default rendering
* icon and label alignment
* text-first semantics, not color-only semantics

### Utility Primitives

Contract owner:

* [Tier 1 - Utility Primitives Contract](../contracts/Tier%201%20-%20Utility%20Primitives%20Contract.md)

Checklist:

* [ ] Divider
  Status: not implemented
* [ ] Tooltip
  Status: not implemented
  - non-interactive only
  - not treated as a popover replacement
* [ ] Spinner
  Status: not implemented
* [ ] Icon baseline
  Status: not implemented
* [ ] Label baseline
  Status: not implemented
* [ ] Link baseline
  Status: not implemented

Requirements:

* variant policy matches utility contract rules

## Tier 1B: Baseline Structural Shells And Baselines

### Table Baseline

Contract owner:

* [Tier 1 - Table Baseline Contract](../contracts/Tier%201%20-%20Table%20Baseline%20Contract.md)

Checklist:

* [ ] Table baseline
  Status: not implemented
  - semantic table container
  - deterministic header row and body row structure
  - row hover and readability treatment
  - nested control focus visibility where controls exist
  - loading and empty/no-match presentation through the baseline table surface
  - horizontal overflow containment on narrow widths
  - variant policy: not variant-bearing

Boundary note:

* richer search/filter/sort orchestration, bulk actions, rows selectors, result summaries, and enhanced pagination-control assemblies belong to Tier 2 patterns rather than the Tier 1 table baseline

### Drawer And Modal Baseline

Contract owner:

* [Tier 1 - Drawer And Modal Contract](../contracts/Tier%201%20-%20Drawer%20And%20Modal%20Contract.md)

Checklist:

* [ ] Modal baseline
  Status: not implemented
* [ ] Drawer baseline
  Status: not implemented

Requirements:

* allowed variants: base only
* selection rule between drawer and modal is explicit
* Escape close
* backdrop behavior documented
* focus return to invoking control
* scroll-lock behavior

### Toast And Inline Alert Baseline

Contract owner:

* [Tier 1 - Toast And Inline Alert Contract](../contracts/Tier%201%20-%20Toast%20And%20Inline%20Alert%20Contract.md)

Checklist:

* [ ] Toast baseline
  Status: not implemented
* [ ] Inline alert baseline
  Status: not implemented

Requirements:

* allowed variants: base only
* severity mapping is explicit
* dismiss behavior is explicit
* no raw JSON or ad hoc feedback block pattern

### Shell Navigation Baseline

Contract owner:

* [Tier 1 - Shell Navigation Contract](../contracts/Tier%201%20-%20Shell%20Navigation%20Contract.md)

Checklist:

* [ ] Sidebar baseline
  Status: not implemented
* [ ] Header baseline
  Status: not implemented
* [ ] Account Menu baseline
  Status: not implemented
* [ ] Mobile Nav Dock baseline
  Status: not implemented

Requirements:

* allowed variants: base only
* mobile behavior matches desktop intent
* current-location and parent-context visibility are preserved

### Layout And Scaffolding Baseline

Contract owner:

* [Tier 1 - Layout And Scaffolding Contract](../contracts/Tier%201%20-%20Layout%20And%20Scaffolding%20Contract.md)

Checklist:

* [ ] Container baseline
  Status: not implemented
* [ ] Grid baseline
  Status: not implemented
* [ ] Stack / Flex baseline
  Status: not implemented
* [ ] Section / Panel baseline
  Status: not implemented

Requirements:

* variant policy matches layout contract rules

## Cross-Cutting System Requirements

### Tokens

* [ ] Tokens
  Status: not implemented
  - semantic color mapping is used
  - spacing scale is used
  - typography scale is used
  - radius scale is used
  - elevation and layering rules are used

### Interaction States

All interactive Tier 1 components must support applicable states:

* [ ] Interaction states
  Status: not implemented
  - default
  - hover
  - focus
  - active
  - disabled
  - loading where applicable

### Accessibility

* [ ] Accessibility
  Status: not implemented
  - keyboard navigation is supported where applicable
  - visible focus treatment is present
  - ARIA labeling is present where needed
  - icon-only controls have accessible labels
  - overlays return focus correctly

## UI Reference Validation

Applicable Tier 1 components must be represented in the UI reference workspace.

Checklist:

* [ ] UI Reference Validation
  Status: not implemented
  - every Tier 1 component is visible where applicable
  - canonical variants are shown
  - required states are shown
  - interactions can be manually tested

## Library Readiness Validation

Tier 1 must also be validated as a consumable library layer.

Checklist:

* [ ] Library Readiness Validation
  Status: not implemented
  - every Tier 1 item has an explicit implementation-form classification
  - every Tier 1 item has a canonical usage example
  - Tier 1 items intended for reuse are not represented only by demo-state snapshots
  - downstream Tier 2 and feature work can identify the correct Tier 1 building block without guessing

## Batch A Exit Criteria

Batch A is complete only if:

* [ ] Batch A Exit Criteria
  Status: not implemented
  - all Tier 1 checklist items are complete
  - no Tier 2 patterns are mixed into Tier 1 scope
  - standards terminology matches current canonical docs
  - UI reference validation is complete
  - library readiness validation is complete
  - manual visual review = PASS
  - manual functional validation = PASS

## Related

* [UI UX Component Taxonomy And Coverage Matrix](UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
* [UI UX Component Library Standards](UI%20UX%20Component%20Library%20Standards.md)
* [UI Design System Standards](../UI%20Design%20System%20Standards.md)
* [Component Contracts Index](../contracts/Component%20Contracts%20Index.md)
* [Tier 1 - Consumption And Composition Contract](../contracts/Tier%201%20-%20Consumption%20And%20Composition%20Contract.md)
