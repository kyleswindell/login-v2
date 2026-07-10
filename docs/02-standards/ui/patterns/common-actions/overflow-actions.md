---
title: Overflow Actions
slug: common-actions-overflow-actions
api_layer: Pattern API
status: approved-standard
system_maturity: standards-wireframe
category: common-actions
canonical_doc: docs/02-standards/ui/patterns/common-actions/overflow-actions.md
source_owner: resources/views/components/patterns/common-actions/overflow-actions
source_status: not implemented
---

# Overflow Actions

## Purpose

Overflow Actions define how secondary, contextual, or lower-frequency actions are grouped into a menu.

## Use when

Use Overflow Actions when:

- actions are secondary to the main task
- space is limited
- row, page, card, or header actions need grouping
- actions need logical grouping
- destructive or sensitive actions are available but should not dominate the interface

Examples:

- Edit
- Duplicate
- Archive
- Remove
- Delete
- Revoke
- Refresh
- View details

## Do not use when

Do not use Overflow Actions when:

- the primary action should be immediately visible
- the action is required to complete the current flow
- only one obvious action exists
- hiding the action would reduce discoverability for a frequent workflow

## Composed primitives

Overflow Actions may compose:

- menu / dropdown primitive
- `x-ui.button`
- `x-ui.icon`
- Confirmation Action
- Destructive Action
- tooltip/toggletip primitive for disabled reasons

## Variants

### Row overflow

Used in tables, lists, and repeated records.

### Page overflow

Used for page-level secondary actions.

### Header overflow

Used for contextual actions in a page/header region.

### Card overflow

Used for secondary card-level actions.

## Behavioral requirements

### Grouping

Actions should be grouped by purpose:

- common non-destructive actions
- state-changing actions
- destructive or sensitive actions

Destructive actions should be visually and semantically separated when possible.

### Hierarchy

Primary page actions should not be hidden in overflow unless the page pattern explicitly requires it.

### Permission behavior

Use hidden when:

- the user should not know the action exists
- exposing the action would reveal unavailable features or sensitive capability

Use disabled when:

- the user may know the action exists
- the action is temporarily unavailable due to state
- the user needs to understand why it cannot be used

Disabled actions should include accessible explanation when the reason is not obvious.

### Destructive actions

Destructive menu items must:

- use destructive wording
- use danger treatment if supported by the menu primitive
- trigger Confirmation Action when required
- satisfy Destructive Action requirements

## Content requirements

Menu item labels must be action-specific.

Preferred:

- Edit user
- Revoke access
- Delete token
- View details

Acceptable in row context when target is obvious:

- Edit
- Revoke
- Delete
- View

Avoid:

- Manage
- More
- Options, except as accessible trigger text for the menu itself

## Loading requirements

Overflow-triggered actions that mutate state follow the same loading requirements as their underlying action type. The menu should close or remain open according to the child menu/menu-button contract and the action feedback model.

## Feedback requirements

Overflow Actions do not own feedback. The selected action must hand off to the correct feedback, confirmation, destructive, inline row, or page-level pattern.

## Accessibility requirements

- Menu trigger must have an accessible name.
- Keyboard navigation must be supported.
- Disabled menu items must be announced correctly.
- Destructive menu items must not rely on color alone.

## Examples to prove

- Row overflow
- Page overflow
- Header overflow
- Grouped actions
- Disabled action with reason
- Permission-hidden action
- Destructive action in overflow
- Overflow with confirmation handoff

## Testing requirements

Tests should assert:

- trigger renders with accessible name
- grouped actions render
- destructive item can be represented
- disabled item can include reason
- confirmation handoff is possible
- hidden unauthorized actions do not render

## Open questions / implementation notes

- Existing `x-patterns.dropdown-action-menu` remains the transitional source candidate for this pattern.
- The first implementation pass should avoid duplicating Menu/Menu button keyboard behavior.
