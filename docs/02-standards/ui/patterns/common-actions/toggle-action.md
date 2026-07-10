---
title: Toggle Action
slug: common-actions-toggle-action
api_layer: Pattern API
status: approved-standard
system_maturity: standards-wireframe
category: common-actions
canonical_doc: docs/02-standards/ui/patterns/common-actions/toggle-action.md
source_owner: resources/views/components/patterns/common-actions/toggle-action
source_status: not implemented
---

# Toggle Action

## Purpose

Toggle Action defines enablement and binary state-change behavior for toggle controls, checkboxes, module controls, policies, and settings.

## Use when

Use Toggle Action when the user changes an on/off or enabled/disabled state.

Examples:

- enable module
- disable policy
- turn MFA requirement on
- opt into setting
- activate integration
- enable user access

## Do not use when

Do not use Toggle Action for:

- choosing one option from many
- navigation
- triggering unrelated commands
- destructive actions that require confirmation before state changes
- settings that need a full form submit unless represented as save-required toggles

## Composed primitives

Toggle Action may compose:

- `x-ui.toggle`
- checkbox primitive
- Form Actions Bar
- Confirmation Action
- Destructive Action
- feedback primitive

## Toggle modes

### Immediate toggle

Use when the state should save as soon as the user toggles.

Requirements:

- show pending/loading state
- prevent duplicate toggles while pending
- show success or failure feedback
- restore previous state on failure
- audit sensitive changes when required

### Save-required toggle

Use when the toggle is part of a larger form or configuration page.

Requirements:

- update local form state only
- mark form dirty
- save through Form Actions Bar
- reset must return to last saved state
- cancel must discard unsaved toggle changes

## Sensitive toggles

Some toggles may require confirmation.

Examples:

- disable user
- disable MFA
- turn off audit logging
- enable public access
- disable tenant/module
- change enforcement policy

Sensitive toggles may require:

- Confirmation Action
- Destructive Action
- MFA step-up
- audit expectation

## Content requirements

Labels must describe the state or setting clearly.

Preferred:

- Enable module
- Require MFA
- Allow public access
- Disable user

Avoid vague labels:

- On
- Off
- Active, unless paired with explicit setting label

## Permission requirements

- Disabled toggle must explain why it cannot be changed when the reason is not obvious.
- Hidden toggles should be used when the user should not know the setting exists.
- Backend permission enforcement is required.

## Loading requirements

Immediate toggles must define:

- pending visual state
- duplicate prevention
- success behavior
- failure rollback
- retry behavior

Save-required toggles rely on Form Actions Bar loading behavior.

## Feedback requirements

Immediate toggle success may use lightweight feedback.

Immediate toggle failure must explain:

- what failed
- whether state was restored
- what the user can do next

## Accessibility requirements

- Toggle must expose current state.
- Toggle label must be explicit.
- Pending state must be perceivable.
- Confirmation, if used, must be accessible.
- State must not be communicated by color alone.

## Examples to prove

- Immediate enable
- Immediate disable
- Immediate failure rollback
- Save-required toggle
- Dirty-state toggle
- Sensitive disable with confirmation
- MFA step-up-required toggle
- Permission-disabled toggle

## Testing requirements

Tests should assert:

- immediate vs save-required mode can be represented
- checked/current state renders
- disabled state renders
- loading/pending state renders
- confirmation handoff is possible
- failure rollback behavior is documented

## Open questions / implementation notes

- Toggle Action does not replace the Toggle Component; it defines command semantics around binary state changes.
- Module enable/disable flows remain future work until persisted module state exists.
