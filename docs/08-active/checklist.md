# Tier 1 Component Implementation Checklist

This document defines the canonical scope and intent for Tier 1 Component Implementation Checklist.

## Purpose

Define the implementation checklist for true Tier 1 UI primitives and baseline structural shells only.

This checklist is the implementation-facing companion to the Tier 1 taxonomy, UI design system standards, and current Tier 1 component contracts.

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

## Tier 1A: Primitive Components

### Buttons And Icon Buttons

Contract owner:

* [Tier 1 - Buttons And Icon Buttons Contract](../02-standards/ui/contracts/Tier%201%20-%20Buttons%20And%20Icon%20Buttons%20Contract.md)

Checklist:

* [x] Button
  Status: passed review
  Note: icon + text review examples refreshed in worklog `2-A-0004`; pending re-review
  - action-token naming aligns to current canonical terminology
  - allowed variants: base, soft, outline, ghost
  - size variants align to current canonical terminology
  - states: default, hover, focus, active, disabled, loading
* [x] Icon Button
  Status: passed review
  - states: default, hover, focus, active, disabled
  - accessible label is required

### Input Controls Baseline

Contract owner:

* [Tier 1 - Input Controls Contract](../02-standards/ui/contracts/Tier%201%20-%20Input%20Controls%20Contract.md)

Checklist:

* [x] Text Input
  Status: passed review
* [x] Textarea
  Status: passed review
* [x] Select
  Status: passed review
* [x] Checkbox
  Status: passed review
* [x] Radio Group
  Status: passed review
* [x] Switch / Toggle
  Status: passed review

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

* [Tier 1 - Badges And Status Contract](../02-standards/ui/contracts/Tier%201%20-%20Badges%20And%20Status%20Contract.md)

Checklist:

* [x] Badge baseline
  Status: passed review
* [x] Status pill baseline
  Status: passed review

Requirements:

* allowed variants: base, outline
* single-line default rendering
* icon and label alignment
* text-first semantics, not color-only semantics

### Utility Primitives

Contract owner:

* [Tier 1 - Utility Primitives Contract](../02-standards/ui/contracts/Tier%201%20-%20Utility%20Primitives%20Contract.md)

Checklist:

* [x] Divider
  Status: passed review
* [x] Tooltip
  Status: passed review
  - non-interactive only
  - not treated as a popover replacement
* [x] Spinner
  Status: passed review
* [x] Icon baseline
  Status: passed review
* [x] Label baseline
  Status: passed review
* [x] Link baseline
  Status: passed review

Requirements:

* variant policy matches utility contract rules

## Tier 1B: Baseline Structural Shells And Baselines

### Table Baseline

Contract owner:

* [Tier 1 - Table Baseline Contract](../02-standards/ui/contracts/Tier%201%20-%20Table%20Baseline%20Contract.md)

Checklist:

* [x] Table baseline
  Status: passed review
  Note: active sort-state visibility refreshed again in worklog `2-A-0007`; pending manual review.
  - page title/subtitle row
  - optional stats row
  - control row structure
  - rows selector
  - search placement
  - filter toggle placement
  - filter reset path
  - row action baseline
  - loading state
  - empty state inside table baseline
  - result summary
  - pagination controls inside table baseline
  - variant policy: not variant-bearing

### Drawer And Modal Baseline

Contract owner:

* [Tier 1 - Drawer And Modal Contract](../02-standards/ui/contracts/Tier%201%20-%20Drawer%20And%20Modal%20Contract.md)

Checklist:

* [x] Modal baseline
  Status: passed review
* [x] Drawer baseline
  Status: passed review

Requirements:

* allowed variants: base only
* selection rule between drawer and modal is explicit
* Escape close
* backdrop behavior documented
* focus return to invoking control
* scroll-lock behavior

### Toast And Inline Alert Baseline

Contract owner:

* [Tier 1 - Toast And Inline Alert Contract](../02-standards/ui/contracts/Tier%201%20-%20Toast%20And%20Inline%20Alert%20Contract.md)

Checklist:

* [x] Toast baseline
  Status: passed review
* [x] Inline alert baseline
  Status: passed review

Requirements:

* allowed variants: base only
* severity mapping is explicit
* dismiss behavior is explicit
* no raw JSON or ad hoc feedback block pattern

### Shell Navigation Baseline

Contract owner:

* [Tier 1 - Shell Navigation Contract](../02-standards/ui/contracts/Tier%201%20-%20Shell%20Navigation%20Contract.md)

Checklist:

* [x] Sidebar baseline
  Status: passed review
* [x] Header baseline
  Status: passed review
* [x] Account Menu baseline
  Status: passed review
* [x] Mobile Nav Dock baseline
  Status: passed review

Requirements:

* allowed variants: base only
* mobile behavior matches desktop intent
* current-location and parent-context visibility are preserved

### Layout And Scaffolding Baseline

Contract owner:

* [Tier 1 - Layout And Scaffolding Contract](../02-standards/ui/contracts/Tier%201%20-%20Layout%20And%20Scaffolding%20Contract.md)

Checklist:

* [x] Container baseline
  Status: passed review
* [x] Grid baseline
  Status: passed review
* [x] Stack / Flex baseline
  Status: passed review
* [x] Section / Panel baseline
  Status: passed review

Requirements:

* variant policy matches layout contract rules

## Cross-Cutting System Requirements

### Tokens

* [x] Tokens
  Status: passed review
  - semantic color mapping is used
  - spacing scale is used
  - typography scale is used
  - radius scale is used
  - elevation and layering rules are used

### Interaction States

All interactive Tier 1 components must support applicable states:

* [x] Interaction states
  Status: passed review
  - default
  - hover
  - focus
  - active
  - disabled
  - loading where applicable

### Accessibility

* [x] Accessibility
  Status: passed review
  - keyboard navigation is supported where applicable
  - visible focus treatment is present
  - ARIA labeling is present where needed
  - icon-only controls have accessible labels
  - overlays return focus correctly

## UI Reference Validation

Applicable Tier 1 components must be represented in the UI reference workspace.

Checklist:

* [ ] UI Reference Validation
  Status: implemented (pending manual review)
  - every Tier 1 component is visible where applicable
  - canonical variants are shown
  - required states are shown
  - interactions can be manually tested

## Batch A Exit Criteria

Batch A is complete only if:

* [ ] Batch A Exit Criteria
  Status: not implemented
  - all Tier 1 checklist items are complete
  - no Tier 2 patterns are mixed into Tier 1 scope
  - standards terminology matches current canonical docs
  - UI reference validation is complete
  - manual visual review = PASS
  - manual functional validation = PASS

## Related

* [UI UX Component Taxonomy And Coverage Matrix](../02-standards/ui/components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
* [UI UX Component Library Standards](../02-standards/ui/components/UI%20UX%20Component%20Library%20Standards.md)
* [UI Design System Standards](../02-standards/ui/UI%20Design%20System%20Standards.md)
* [Component Contracts Index](../02-standards/ui/contracts/Component%20Contracts%20Index.md)
