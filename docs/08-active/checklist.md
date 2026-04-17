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
  * [x] action-token naming aligns to current canonical terminology
  * [x] allowed variants: base, soft, outline, ghost
  * [x] size variants align to current canonical terminology
  * [x] states: default, hover, focus, active, disabled, loading
* [x] Icon Button
  * [x] states: default, hover, focus, active, disabled
  * [x] accessible label is required
  * Status note: canonical Heroicons source path normalized in shared action review surfaces (implemented, pending review)

### Input Controls Baseline

Contract owner:

* [Tier 1 - Input Controls Contract](../02-standards/ui/contracts/Tier%201%20-%20Input%20Controls%20Contract.md)

Checklist:

* [x] Text Input
* [x] Textarea
* [x] Select
* [x] Checkbox
* [x] Radio Group
* [x] Switch / Toggle
* [x] allowed variants: base only

Required support:

* [x] label
* [x] helper text
* [x] error text
* [x] disabled state
* [x] validation messaging
* [x] focus-visible treatment

### Badges And Status Baseline

Contract owner:

* [Tier 1 - Badges And Status Contract](../02-standards/ui/contracts/Tier%201%20-%20Badges%20And%20Status%20Contract.md)

Checklist:

* [x] Badge baseline
* [x] Status pill baseline
* [x] allowed variants: base, outline
* [x] single-line default rendering
* [x] icon and label alignment
* [x] text-first semantics, not color-only semantics

### Utility Primitives

Contract owner:

* [Tier 1 - Utility Primitives Contract](../02-standards/ui/contracts/Tier%201%20-%20Utility%20Primitives%20Contract.md)

Checklist:

* [x] Divider
* [x] Tooltip
  * [x] non-interactive only
  * [x] not treated as a popover replacement
* [x] Spinner
* [x] Icon baseline
  * Status note: shared navigation semantic icon keys now resolve through the approved Heroicons source path (implemented, pending review)
* [x] Label baseline
* [x] Link baseline
* [x] variant policy matches utility contract rules

## Tier 1B: Baseline Structural Shells And Baselines

### Table Baseline

Contract owner:

* [Tier 1 - Table Baseline Contract](../02-standards/ui/contracts/Tier%201%20-%20Table%20Baseline%20Contract.md)

Checklist:

* [x] page title/subtitle row
* [x] optional stats row
* [x] control row structure
* [x] rows selector
* [x] search placement
* [x] filter toggle placement
* [x] filter reset path
* [x] row action baseline
* [x] loading state
* [x] empty state inside table baseline
* [x] result summary
* [x] pagination controls inside table baseline
* [x] variant policy: not variant-bearing

### Drawer And Modal Baseline

Contract owner:

* [Tier 1 - Drawer And Modal Contract](../02-standards/ui/contracts/Tier%201%20-%20Drawer%20And%20Modal%20Contract.md)

Checklist:

* [x] Modal baseline
* [x] Drawer baseline
* [x] allowed variants: base only
* [x] selection rule between drawer and modal is explicit
* [x] Escape close
* [x] backdrop behavior documented
* [x] focus return to invoking control
* [x] scroll-lock behavior

### Toast And Inline Alert Baseline

Contract owner:

* [Tier 1 - Toast And Inline Alert Contract](../02-standards/ui/contracts/Tier%201%20-%20Toast%20And%20Inline%20Alert%20Contract.md)

Checklist:

* [x] Toast baseline
* [x] Inline alert baseline
* [x] allowed variants: base only
* [x] severity mapping is explicit
* [x] dismiss behavior is explicit
* [x] no raw JSON or ad hoc feedback block pattern

### Shell Navigation Baseline

Contract owner:

* [Tier 1 - Shell Navigation Contract](../02-standards/ui/contracts/Tier%201%20-%20Shell%20Navigation%20Contract.md)

Checklist:

* [x] Sidebar baseline
* [x] Header baseline
* [x] Account Menu baseline
* [x] Mobile Nav Dock baseline
  * Status note: mobile dock icon-label mismatch corrected for `Setup` and `Settings` (implemented, pending review)
* [x] allowed variants: base only
* [x] mobile behavior matches desktop intent
* [x] current-location and parent-context visibility are preserved

### Layout And Scaffolding Baseline

Contract owner:

* [Tier 1 - Layout And Scaffolding Contract](../02-standards/ui/contracts/Tier%201%20-%20Layout%20And%20Scaffolding%20Contract.md)

Checklist:

* [x] Container baseline
* [x] Grid baseline
* [x] Stack / Flex baseline
* [x] Section / Panel baseline
* [x] variant policy matches layout contract rules

## Cross-Cutting System Requirements

### Tokens

* [x] semantic color mapping is used
* [x] spacing scale is used
* [x] typography scale is used
* [x] radius scale is used
* [x] elevation and layering rules are used

### Interaction States

All interactive Tier 1 components must support applicable states:

* [x] default
* [x] hover
* [x] focus
* [x] active
* [x] disabled
* [x] loading where applicable

### Accessibility

* [x] keyboard navigation is supported where applicable
* [x] visible focus treatment is present
* [x] ARIA labeling is present where needed
* [x] icon-only controls have accessible labels
* [x] overlays return focus correctly

## UI Reference Validation

Applicable Tier 1 components must be represented in the UI reference workspace.

Checklist:

* [x] every Tier 1 component is visible where applicable
* [x] canonical variants are shown
* [x] required states are shown
* [x] interactions can be manually tested

## Batch A Exit Criteria

Batch A is complete only if:

* [x] all Tier 1 checklist items are complete
* [x] no Tier 2 patterns are mixed into Tier 1 scope
* [x] standards terminology matches current canonical docs
* [x] UI reference validation is complete
* [ ] manual visual review = PASS
* [ ] manual functional validation = PASS

## Related

* [UI UX Component Taxonomy And Coverage Matrix](../02-standards/ui/components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
* [UI UX Component Library Standards](../02-standards/ui/components/UI%20UX%20Component%20Library%20Standards.md)
* [UI Design System Standards](../02-standards/ui/UI%20Design%20System%20Standards.md)
* [Component Contracts Index](../02-standards/ui/contracts/Component%20Contracts%20Index.md)
