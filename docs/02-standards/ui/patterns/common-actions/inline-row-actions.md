---
title: Inline Row Actions
slug: common-actions-inline-row-actions
api_layer: Pattern API
status: approved-standard
system_maturity: standards-wireframe
category: common-actions
canonical_doc: docs/02-standards/ui/patterns/common-actions/inline-row-actions.md
source_owner: resources/views/components/patterns/common-actions/inline-row-actions
source_status: not implemented
---

# Inline Row Actions

## Purpose

Inline Row Actions define compact actions for table rows, list items, structured lists, notification rows, and repeated records.

## Use when

Use Inline Row Actions for actions tied to a single visible row or item.

Examples:

- View
- Edit
- Dismiss
- Archive
- Retry
- Revoke
- Remove
- Delete

## Do not use when

Do not use Inline Row Actions for:

- page-level actions
- bulk actions
- full-form submit actions
- settings navigation
- primary workflow progression
- actions requiring detailed explanation before click

## Composed primitives

Inline Row Actions may compose:

- `x-ui.button`
- `x-ui.link`
- `x-ui.icon`
- tooltip/toggletip primitive
- Overflow Actions
- Confirmation Action
- Destructive Action

## Behavioral requirements

### Density

Inline Row Actions must remain compact and scannable.

Allowed forms:

- text-only
- icon + text
- icon-only with accessible label
- first actions visible with remaining actions in overflow

### Action count

Recommended:

- one to three visible inline actions
- move additional secondary actions to Overflow Actions
- move destructive actions to overflow or require confirmation when risk is meaningful

### Ordering

Preferred order:

- View
- Edit
- Retry
- Archive / Dismiss / Remove
- Revoke / Delete

Destructive actions should generally appear last or inside overflow unless they are the sole action and clearly contextualized.

### Notification rows

Notification actions should reuse Inline Row Actions.

Examples:

- Mark read
- Dismiss
- View details

Notifications do not define their own action family. Notification row actions reuse Inline Row Actions or Overflow Actions.

## Permission requirements

- Row-specific permissions must be evaluated per row.
- Hidden vs disabled behavior must be consistent across rows.
- Disabled actions should explain state-based reasons where practical.

## Loading requirements

Inline actions that mutate the row must:

- prevent duplicate action
- preserve row identity during loading
- define optimistic or non-optimistic update behavior
- recover visibly on failure

## Feedback requirements

After success:

- update row state
- remove row only when the item is actually gone from the current view
- use inline, toast, or page-level feedback as appropriate

After failure:

- keep the row visible
- show clear failure feedback
- allow retry when appropriate

Carbon's action guidance includes failure expectations: users should understand what happened and have a path to continue.

## Accessibility requirements

- Icon-only actions require accessible names.
- Row actions must be keyboard reachable.
- Action target must be clear to screen reader users.
- Focus must move predictably if a row is removed.
- Confirmation must be accessible for destructive row actions.

## Examples to prove

- Text row actions
- Icon + text row actions
- Icon-only row actions
- Row action with overflow
- Retry loading
- Archive success
- Dismiss notification
- Revoke with confirmation
- Delete with confirmation

## Testing requirements

Tests should assert:

- accessible names are required for icon-only actions
- multiple actions render in stable order
- overflow handoff is possible
- destructive handoff is possible
- loading row action is supported
- removed row focus behavior is documented

## Open questions / implementation notes

- The source implementation should support notification rows without creating a notification-specific action pattern.
- Table/list focus recovery should be proved with real row-removal examples before strict enforcement.
