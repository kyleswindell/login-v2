# Tier 2 Pattern Library Checklist

This document defines the canonical scope and intent for Tier 2 Pattern Library Checklist.

## Purpose

Define the implementation checklist for reusable Tier 2 UI patterns composed from Tier 1 primitives.

This checklist is the implementation-facing companion to the component taxonomy, Tier 1 checklist, and current UI component library standards.

## Tier Boundary

### Tier 1 Definition

Tier 1 is limited to primitives and baseline structural shells.

Tier 1 owns inputs, buttons, status primitives, table baseline, overlay baseline, shell navigation baseline, and baseline layout/scaffolding primitives.

### Tier 2 Definition

Tier 2 is limited to composed reusable patterns built from Tier 1.

Tier 2 owns app-wide assemblies such as navigation patterns, form patterns, feedback patterns, and higher-order content patterns that remain reusable across multiple features.

### Explicitly Excluded From Tier 2

The following are out of scope for this checklist:

* Tier 1 primitives and baseline shells
* business logic
* model or API coupling
* feature-specific workflows
* one-off page compositions
* page- or module-specific UI

## Implementation Rules

* Tier 2 patterns must be built only from Tier 1 primitives and baseline shells
* Tier 2 patterns must not duplicate primitive logic already owned by Tier 1
* Tier 2 patterns must not introduce business logic, model coupling, or API coupling
* Tier 2 patterns must not use custom styling outside the canonical token system
* Tier 2 patterns may include only minimal reusable interaction behavior
* Tier 2 patterns must support required states and accessibility expectations for their role
* Tier 2 patterns must be rendered in the UI Reference patterns section

## Pattern Checklist Format

Every Tier 2 pattern entry must define:

* purpose
* Tier 1 components used
* minimal required interaction behavior
* required states
* accessibility expectations
* UI Reference requirement

## Tier 2A: Form Patterns

### Form Group

* [ ] purpose: standard field wrapper for label, control, helper text, and error text
* [ ] Tier 1 components used: Label baseline, input control baseline, Link baseline where applicable
* [ ] minimal interaction behavior: associates label, help, and error content with the control; preserves validation visibility
* [ ] required states: default, focus, disabled, error
* [ ] accessibility expectations: programmatic label association, error text association, helper text association
* [ ] UI Reference requirement: visible with helper and error examples

### Form Section

* [ ] purpose: groups related fields under a shared title and optional description
* [ ] Tier 1 components used: Section / Panel baseline, Label baseline, Divider where applicable
* [ ] minimal interaction behavior: supports grouped content and consistent spacing only
* [ ] required states: default
* [ ] accessibility expectations: section heading hierarchy is preserved
* [ ] UI Reference requirement: visible with title, description, and grouped fields

### Inline Form Row

* [ ] purpose: aligns label and control horizontally when space allows, with responsive fallback
* [ ] Tier 1 components used: Grid baseline, Stack / Flex baseline, Label baseline, input control baseline
* [ ] minimal interaction behavior: switches cleanly between horizontal and stacked layout
* [ ] required states: default, focus, disabled, error
* [ ] accessibility expectations: label association remains intact across breakpoints
* [ ] UI Reference requirement: visible in desktop and narrow-width examples

### Form Actions Bar

* [ ] purpose: standardizes placement and grouping for form actions
* [ ] Tier 1 components used: Button, Divider where applicable, Stack / Flex baseline
* [ ] minimal interaction behavior: preserves primary, secondary, and destructive action grouping and alignment
* [ ] required states: default, disabled, loading where applicable
* [ ] accessibility expectations: tab order follows visual priority; destructive actions remain clearly labeled
* [ ] UI Reference requirement: visible with primary, secondary, and destructive actions

### Validation Summary

* [ ] purpose: provides a form-level error summary for multi-error cases
* [ ] Tier 1 components used: Inline alert baseline, Link baseline, Section / Panel baseline where applicable
* [ ] minimal interaction behavior: lists validation errors and supports link-to-field behavior
* [ ] required states: default, error
* [ ] accessibility expectations: summary is announced appropriately and links move focus predictably
* [ ] UI Reference requirement: visible with multiple linked field errors

## Tier 2B: Data And Content Patterns

### Enhanced Data Table

* [ ] purpose: extends the Tier 1 table baseline with reusable advanced controls
* [ ] Tier 1 components used: Table baseline, Button, input control baseline, Badge baseline, Modal or Drawer baseline where applicable
* [ ] minimal interaction behavior: supports filters, bulk actions, row selection, and column visibility toggle without feature logic
* [ ] required states: default, loading, empty, selection-active
* [ ] accessibility expectations: row selection is keyboard reachable, table semantics are preserved, control labels are explicit
* [ ] UI Reference requirement: visible with filter, selection, and empty-state examples

### Data List Item

* [ ] purpose: standardizes a reusable list row with title, supporting metadata, and optional actions
* [ ] Tier 1 components used: Section / Panel baseline, Badge baseline, Button or Icon Button, Link baseline
* [ ] minimal interaction behavior: supports action slotting and metadata alignment only
* [ ] required states: default, hover, focus where interactive, disabled where applicable
* [ ] accessibility expectations: interactive rows or actions expose clear labels and focus order
* [ ] UI Reference requirement: visible with and without trailing actions

### Stat Card

* [ ] purpose: presents a reusable metric summary with optional supporting trend indicator
* [ ] Tier 1 components used: Section / Panel baseline, Badge baseline, Icon baseline where applicable
* [ ] minimal interaction behavior: supports metric, label, and optional trend display only
* [ ] required states: default, loading where applicable
* [ ] accessibility expectations: metric label relationship remains clear to assistive technology
* [ ] UI Reference requirement: visible in single-card and grouped-card layouts

### Key Value Display

* [ ] purpose: presents label and value pairs in a reusable read-only display pattern
* [ ] Tier 1 components used: Grid baseline, Stack / Flex baseline, Label baseline, Divider where applicable, Link baseline where applicable
* [ ] minimal interaction behavior: supports responsive stacking and consistent label/value alignment
* [ ] required states: default
* [ ] accessibility expectations: reading order remains logical across layouts
* [ ] UI Reference requirement: visible in stacked and multi-column examples

## Tier 2C: Navigation Patterns

### Tab Panel System

* [ ] purpose: organizes peer content areas behind tab navigation
* [ ] Tier 1 components used: Button or Link baseline, Section / Panel baseline, Divider where applicable
* [ ] minimal interaction behavior: binds tabs to panels and supports keyboard navigation
* [ ] required states: default, hover, focus, active, disabled where applicable
* [ ] accessibility expectations: tab, tablist, and tabpanel semantics are present; arrow-key navigation is supported
* [ ] UI Reference requirement: visible with active, disabled, and overflow examples

### Page Title And Actions Row

* [ ] purpose: standardizes page-level title, subtitle, and action placement inside content areas
* [ ] Tier 1 components used: Stack / Flex baseline, Button, Link baseline, Divider where applicable
* [ ] minimal interaction behavior: supports optional subtitle, actions, and optional hierarchy-context slotting
* [ ] required states: default
* [ ] accessibility expectations: heading hierarchy is preserved and action labels are explicit
* [ ] UI Reference requirement: visible with and without breadcrumbs

### Sub-navigation Bar

* [ ] purpose: provides reusable section-level navigation below the primary shell
* [ ] Tier 1 components used: Link baseline, Button baseline where applicable, Divider, Stack / Flex baseline
* [ ] minimal interaction behavior: supports active-item indication and overflow-safe layout
* [ ] required states: default, hover, focus, active, disabled where applicable
* [ ] accessibility expectations: current item is programmatically identified and keyboard navigation is supported
* [ ] UI Reference requirement: visible with active and overflow examples

### Breadcrumbs

* [ ] purpose: presents hierarchical navigation context for the current surface
* [ ] Tier 1 components used: Link baseline, Icon baseline, Stack / Flex baseline
* [ ] minimal interaction behavior: supports hierarchy display and truncation rules
* [ ] required states: default, hover, focus, active for current item handling where applicable
* [ ] accessibility expectations: current page is identified and separator treatment is non-verbose for screen readers
* [ ] UI Reference requirement: visible in short and truncated examples

## Tier 2D: Feedback Patterns

### Empty State

* [ ] purpose: presents a reusable no-data or no-results pattern with a clear next action
* [ ] Tier 1 components used: Section / Panel baseline, Button, Link baseline, Icon baseline
* [ ] minimal interaction behavior: supports icon, explanation, and primary action with optional secondary action
* [ ] required states: default
* [ ] accessibility expectations: message and actions are announced clearly and remain understandable without icon meaning alone
* [ ] UI Reference requirement: visible for no-data and no-results variants

### Error State Block

* [ ] purpose: presents a reusable recoverable error surface inside page content
* [ ] Tier 1 components used: Inline alert baseline, Button, Link baseline, Section / Panel baseline
* [ ] minimal interaction behavior: supports diagnostic message and retry or recovery action slotting
* [ ] required states: default, error
* [ ] accessibility expectations: error message is announced appropriately and recovery actions are explicit
* [ ] UI Reference requirement: visible with retry and non-retry variants

### Success State Block

* [ ] purpose: presents a reusable success confirmation surface with optional follow-up action
* [ ] Tier 1 components used: Inline alert baseline, Button, Link baseline, Section / Panel baseline
* [ ] minimal interaction behavior: supports confirmation message and optional next-action slotting
* [ ] required states: default, success
* [ ] accessibility expectations: confirmation message remains understandable without color alone
* [ ] UI Reference requirement: visible with passive and action-oriented variants

### Skeleton Loader Pattern

* [ ] purpose: provides reusable layout-matching loading placeholders for Tier 2 surfaces
* [ ] Tier 1 components used: Spinner, Section / Panel baseline, Grid baseline, Stack / Flex baseline
* [ ] minimal interaction behavior: mirrors final layout structure without introducing feature logic
* [ ] required states: loading
* [ ] accessibility expectations: loading treatment is announced appropriately and decorative placeholders are hidden from assistive technology where needed
* [ ] UI Reference requirement: visible for table-adjacent, card, and form layouts where applicable

## Tier 2E: Overlay And Action Patterns

### Confirm Dialog

* [ ] purpose: standardizes short confirmation flows for reversible or destructive actions
* [ ] Tier 1 components used: Modal baseline, Button, Inline alert baseline where applicable
* [ ] minimal interaction behavior: supports title, message, confirm, cancel, and destructive emphasis rules
* [ ] required states: default, focus, disabled, loading where applicable
* [ ] accessibility expectations: focus trap, focus return, explicit destructive labeling
* [ ] UI Reference requirement: visible for standard and destructive confirmations

### Form Modal

* [ ] purpose: standardizes short-form editing inside a modal container
* [ ] Tier 1 components used: Modal baseline, input control baseline, Label baseline, Button, Inline alert baseline, Stack / Flex baseline
* [ ] minimal interaction behavior: supports field layout, validation display, and submission-state presentation without feature logic
* [ ] required states: default, focus, error, disabled, loading
* [ ] accessibility expectations: overlay focus management is preserved and validation messaging is programmatically associated
* [ ] UI Reference requirement: visible with default and validation-error examples

### Drawer Form

* [ ] purpose: standardizes contextual editing inside a drawer container
* [ ] Tier 1 components used: Drawer baseline, input control baseline, Label baseline, Button, Inline alert baseline, Stack / Flex baseline
* [ ] minimal interaction behavior: supports side-panel editing, validation display, and submission-state presentation without feature logic
* [ ] required states: default, focus, error, disabled, loading
* [ ] accessibility expectations: overlay focus management is preserved and heading plus close action are explicit
* [ ] UI Reference requirement: visible with default and validation-error examples

### Popover

* [ ] purpose: presents anchored contextual content that is richer than a tooltip and lighter than a modal
* [ ] Tier 1 components used: Button or Link baseline, Section / Panel baseline, Divider where applicable
* [ ] minimal interaction behavior: supports anchored positioning, open and close behavior, and focus-safe dismissal
* [ ] required states: default, open, focus
* [ ] accessibility expectations: trigger relationship is explicit and keyboard dismissal is supported
* [ ] UI Reference requirement: visible with text-only and action-list variants

### Dropdown Action Menu

* [ ] purpose: standardizes compact grouped actions behind a trigger control
* [ ] Tier 1 components used: Button or Icon Button, Link baseline, Divider, Section / Panel baseline
* [ ] minimal interaction behavior: supports grouped actions, keyboard navigation, and dismissal behavior
* [ ] required states: default, open, hover, focus, disabled where applicable
* [ ] accessibility expectations: menu semantics are present where appropriate and active descendant or focus movement is keyboard safe
* [ ] UI Reference requirement: visible with grouped and destructive action examples

### Context Menu

* [ ] purpose: provides an alternate action-entry surface for advanced pointer-driven interaction
* [ ] Tier 1 components used: Button or Icon Button, Link baseline, Divider, Section / Panel baseline
* [ ] minimal interaction behavior: supports context-triggered opening and the same action model as dropdown action menus
* [ ] required states: default, open, hover, focus
* [ ] accessibility expectations: equivalent keyboard-accessible actions remain available outside right-click interaction
* [ ] UI Reference requirement: visible with pointer and keyboard-accessible entry examples

## Tier 2F: Interaction Patterns

### Search And Filter Bar

* [ ] purpose: standardizes a reusable control area for search, filters, and sort controls outside feature logic
* [ ] Tier 1 components used: input control baseline, Button, Badge baseline where applicable, Stack / Flex baseline, Divider where applicable
* [ ] minimal interaction behavior: supports search input, filter controls, sort controls, and clear/reset path
* [ ] required states: default, focus, active-filter, disabled, loading where applicable
* [ ] accessibility expectations: control labels are explicit and active filters are understandable without color alone
* [ ] UI Reference requirement: visible with search-only and search-plus-filter variants

### Bulk Action Bar

* [ ] purpose: provides a reusable action surface that appears when items are selected
* [ ] Tier 1 components used: Button, Badge baseline, Inline alert baseline where applicable, Stack / Flex baseline
* [ ] minimal interaction behavior: appears only in selection-active state and exposes contextual actions
* [ ] required states: hidden, selection-active, disabled, loading where applicable
* [ ] accessibility expectations: selected-count messaging is explicit and action order remains keyboard safe
* [ ] UI Reference requirement: visible with zero-selection and selection-active examples

### Segmented Control

* [ ] purpose: standardizes compact option switching for a small set of peer choices
* [ ] Tier 1 components used: Button baseline, Badge baseline where applicable, Stack / Flex baseline
* [ ] minimal interaction behavior: supports single-select behavior and active-state indication
* [ ] required states: default, hover, focus, active, disabled
* [ ] accessibility expectations: option names are explicit and current selection is programmatically identifiable
* [ ] UI Reference requirement: visible with two-option and three-option examples

## Tier 2G: Layout Patterns

### Split View

* [ ] purpose: standardizes a reusable list-and-detail content arrangement
* [ ] Tier 1 components used: Grid baseline, Section / Panel baseline, Divider where applicable
* [ ] minimal interaction behavior: supports coordinated list and detail regions with responsive fallback
* [ ] required states: default, loading where applicable, empty-detail where applicable
* [ ] accessibility expectations: region headings remain clear and reading order remains logical across breakpoints
* [ ] UI Reference requirement: visible in wide and narrow layouts

### Dashboard Grid

* [ ] purpose: standardizes reusable card-based summary layouts without feature-specific content
* [ ] Tier 1 components used: Grid baseline, Section / Panel baseline, Badge baseline, Icon baseline where applicable
* [ ] minimal interaction behavior: supports repeatable responsive placement and spacing rules only
* [ ] required states: default, loading where applicable
* [ ] accessibility expectations: card grouping and heading hierarchy remain clear
* [ ] UI Reference requirement: visible in single-row and multi-row examples

### Content Section Block

* [ ] purpose: standardizes a titled content block with consistent internal spacing
* [ ] Tier 1 components used: Section / Panel baseline, Divider where applicable, Stack / Flex baseline
* [ ] minimal interaction behavior: supports title, optional supporting text, and content slotting only
* [ ] required states: default
* [ ] accessibility expectations: heading hierarchy is preserved
* [ ] UI Reference requirement: visible with and without supporting text

## Cross-Cutting System Constraints

### Interaction States

All Tier 2 patterns must support applicable states for their role:

* [ ] default
* [ ] hover
* [ ] focus
* [ ] active
* [ ] disabled
* [ ] loading where applicable

### Accessibility

* [ ] keyboard navigation is supported where applicable
* [ ] focus management is explicit for overlays and contextual surfaces
* [ ] ARIA roles and relationships are present where needed
* [ ] screen-reader compatibility is preserved across states and responsive layouts

### Composition Rules

* [ ] built strictly from Tier 1 primitives and baseline shells
* [ ] no direct styling outside the token system
* [ ] no duplication of primitive logic

## UI Reference Validation

Applicable Tier 2 patterns must be represented in the UI Reference patterns section.

Checklist:

* [ ] every Tier 2 pattern is visible where applicable
* [ ] required states are visible
* [ ] interactions can be manually tested
* [ ] examples demonstrate reusable pattern usage rather than feature behavior

## Batch B Exit Criteria

Batch B is complete only if:

* [ ] all Tier 2 patterns implemented
* [ ] all Tier 2 patterns built only from Tier 1
* [ ] UI Reference updated for all applicable Tier 2 patterns
* [ ] no feature logic introduced
* [ ] no Tier 1 primitives duplicated in Tier 2 implementations
* [ ] checklist fully complete
* [ ] manual visual review = PASS
* [ ] manual functional validation = PASS


## Addendum 1 - Tier 2 Notification and Toast Pattern Standards

## Purpose

Define the canonical Tier 2 patterns for:
- Toast notifications (ephemeral feedback)
- Persistent notifications (inbox/system events)
- Inline validation and alert behavior

This document ensures:
- clear separation between feedback types
- consistent UX across the application
- alignment with Tier 1 primitives and token system
- prevention of feature-level drift into reusable patterns

---

## Tier Boundary

### Tier 1
- primitives (buttons, inputs, badges, etc.)
- tokens (color, spacing, typography)
- accessibility foundations

### Tier 2 (This Document)
- reusable patterns:
  - toast
  - notification item
  - notification list
  - timestamp display
  - avatar display
  - action affordances

### Tier 3
- feature modules:
  - notification center
  - messaging
  - project/event updates
  - persistence and business logic

---

## Pattern Separation

### 1. Toast Notifications (Ephemeral)

#### Purpose
Provide immediate, short-lived feedback.

#### Use Cases
- success messages
- quick informational alerts
- temporary warnings
- non-persistent system feedback

#### Rules
- not persisted
- not stored in notification system
- auto-dismiss with timeout
- may include optional action
- must be dismissible

#### Structure
- semantic icon/status
- single concise message
- optional action (max 1)
- dismiss control

#### Behavior
- animate in (fade/slide)
- animate out (fade/slide)
- stack vertically
- pause dismissal on hover if interactive

#### Example


✔ Profile updated successfully
⚠ Deadline is tomorrow — View

---

### 2. Persistent Notifications

#### Purpose
Represent system events that require user awareness or later reference.

#### Use Cases
- new messages
- task assignments
- project/event updates
- mentions
- deadlines
- async failures

#### Rules
- persisted in notification system
- must support read/unread state
- may trigger a toast preview
- full interaction happens in notification UI

#### Content Structure



Actor + action + subject + context



#### Examples
- Kevin Morris sent you a new message in Project Apex
- Project Apex was updated
- Task "Final QA Review" is due tomorrow

#### Fields

- actor (user or system)
- event type
- subject/entity
- optional context/location
- timestamp (absolute)
- relative time
- read/unread state
- optional primary action

---

### 3. Inline Validation and Alerts

#### Purpose
Provide local, contextual feedback within a page.

#### Use Cases
- form validation errors
- missing required fields
- invalid input
- same-page warnings

#### Rules
- tied to a specific field or section
- not persisted
- should not create notifications
- should not use toast if context is clear

#### Behavior

- scroll to error location
- focus input
- apply error styling
- replay error/danger animation

#### Toast Usage
Only use toast if:
- error is off-screen
- context is unclear
- system-level failure occurred

---

## Timestamp Standard

### Required
- relative time (primary)
- absolute timestamp (secondary)

### Display Rules
- show relative time inline
- show full timestamp on hover or detail

Examples:
- 2m ago
- 3h ago
- Yesterday
- (hover) 2026-04-15 14:32

---

## Avatar Standard

### Rules
- show profile image if available
- fallback to circular initial avatar
- must match header account avatar style

### Fallback Format
- circle
- background color
- uppercase initial

---

## Action Behavior

### Rules
- maximum one primary action per notification
- action labels must be short:
  - View
  - Open
  - Reply
  - Review

### Interaction
- clicking the notification body may act as primary action
- button is optional if behavior is obvious

---

## Toast vs Notification Policy

### Toast Only
- quick success feedback
- temporary info
- non-critical warnings
- local user actions

### Notification + Optional Toast
- messages
- assignments
- updates
- deadlines
- async failures

---

## Visual / Interaction Standards

### Toast
- subtle animation only
- no excessive motion
- must not block primary workflow

### Notification
- consistent layout
- clear hierarchy
- semantic color usage

### Inline Alerts
- minimal and contextual
- must not disrupt layout unnecessarily

---

## Non-Persisting Alert Format

For lightweight alerts:

- single-line message
- optional action
- dismiss option
- no metadata overload

Example:


File uploaded successfully
Project updated — View



---

## Composition Rules

- Tier 2 patterns must use Tier 1 primitives only
- no direct styling outside token system
- no duplication of primitive behavior
- patterns must be reusable across features

---

## Exclusions

The following are NOT part of Tier 2 patterns:

- feature-specific notification logic
- persistence rules
- domain-specific UI (user management, messaging, etc.)

---

## Validation

A Tier 2 notification system is valid only if:

- toast behavior is consistent and non-persistent
- notification structure follows canonical format
- inline validation does not create unnecessary notifications
- timestamp and avatar standards are applied
- no overlap or confusion exists between systems

---

## Future Integration

These patterns will be consumed by Tier 3 Feature Modules:

- Notification Center
- Messaging systems
- Project/event updates
- Task management

---


## Related

* [Tier 1 Component Implementation Checklist](Tier%201%20Component%20Implementation%20Checklist.md)
* [UI UX Component Library Standards](UI%20UX%20Component%20Library%20Standards.md)
* [UI UX Component Taxonomy And Coverage Matrix](UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
* [UI Design System Standards](../UI%20Design%20System%20Standards.md)
