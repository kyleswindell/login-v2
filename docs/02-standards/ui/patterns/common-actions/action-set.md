---
title: Action Set
slug: common-actions-action-set
api_layer: Pattern API
status: implemented-pending-review
system_maturity: first-slice-implemented
category: common-actions
canonical_doc: docs/02-standards/ui/patterns/common-actions/action-set.md
source_owner: resources/views/components/patterns/common-actions/action-set
source_status: implemented
rendered_evidence_route: null
---

# Action Set

## Purpose

Action Set defines the standard grouping, ordering, and hierarchy rules for related actions.

This pattern does not introduce new button styling. It establishes how common actions should appear together.

## Use when

Use Action Set when a user is presented with two or more related actions in the same local decision area.

Examples:

- Save / Cancel
- Continue / Back
- Submit / Reset
- Delete / Cancel
- Retry / Dismiss
- Copy / Regenerate
- View / Edit

## Do not use when

Do not use Action Set for:

- app navigation
- sidebar navigation
- header menus
- standalone links
- unrelated buttons that happen to be near each other
- table row action clusters, which should use Inline Row Actions
- menus of secondary actions, which should use Overflow Actions

## Composed primitives

Action Set may compose:

- `x-ui.button`
- `x-ui.link`
- `x-ui.icon`
- approved layout primitives if available

It must not define custom visual button variants.

## Behavioral requirements

### Hierarchy

- Prefer one primary action per action set.
- Cancel, reset, and clear must not be primary actions by default.
- Close should generally not appear as a text button inside Action Set. Close belongs to dismissible surfaces and should use the approved close icon affordance unless a surface-specific pattern says otherwise.
- Danger actions may be present, but must not be visually confused with primary continuation actions.
- If a destructive action is the main action, the set must make the consequence clear through label, variant, and surrounding context.

### Ordering

Default order:

- Secondary or cancel action first.
- Primary or confirming action last.

For destructive confirmation contexts:

- Cancel first.
- Destructive confirm last.

For inline compact contexts, follow Inline Row Actions ordering rules instead.

### Labels

Labels must use action-specific verbs.

Preferred:

- Save
- Save changes
- Continue
- Cancel
- Reset
- Delete user
- Revoke token

Avoid vague labels:

- OK
- Yes
- No
- Submit, unless the form has no clearer action-specific verb

## Permission requirements

- Hidden actions must not leave visual gaps that imply missing functionality.
- Disabled actions must include a reason when the reason is not obvious.
- Permission-disabled actions must still be protected server-side.

## Loading requirements

When any action in the set is loading:

- Prevent duplicate trigger of that action.
- Consider disabling peer actions that would conflict.
- Preserve the user's understanding of what is happening.

## Feedback requirements

Action Set does not own success or error feedback.

The calling pattern must hand feedback off to:

- Form Actions Bar
- Confirmation Action
- Destructive Action
- notification pattern
- inline status pattern
- page-level status pattern

## Accessibility requirements

- Each action must have an accessible name.
- Icon-only actions require accessible labels.
- Disabled actions must remain understandable.
- Keyboard order must match visual order.

## Examples to prove

- Primary / secondary set
- Save / cancel set
- Continue / back set
- Reset / apply set
- Danger / cancel set
- Disabled action with reason
- Loading action
- Icon + text action
- Icon-only action with accessible name

## Testing requirements

Tests should assert:

- approved primitives can be composed inside the pattern
- labels render correctly
- disabled state is preserved
- loading state is preserved
- danger action can be represented
- no custom action-specific styling is required

## Open questions / implementation notes

- Future implementation should decide whether the public helper wraps slot content only or also exposes named action slots.
- Do not create a generic action-name abstraction until real feature usage proves it is needed.
