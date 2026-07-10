---
title: Form Actions Bar
slug: common-actions-form-actions-bar
api_layer: Pattern API
status: approved-standard
system_maturity: standards-wireframe
category: common-actions
canonical_doc: docs/02-standards/ui/patterns/common-actions/form-actions-bar.md
source_owner: resources/views/components/patterns/common-actions/form-actions-bar
source_status: not implemented
---

# Form Actions Bar

## Purpose

Form Actions Bar defines the expected placement, grouping, and behavior for form-level actions.

It is a form-specific application of Action Set.

## Use when

Use Form Actions Bar for actions that apply to the full form or editable page section.

Examples:

- Save / Cancel
- Save changes / Reset
- Apply / Reset
- Continue / Back
- Submit / Cancel

## Do not use when

Do not use Form Actions Bar for:

- per-field actions
- table row actions
- card actions
- modal footer actions unless the modal contains a form and follows this pattern intentionally
- navigation-only links

## Composed primitives

Form Actions Bar may compose:

- Action Set
- `x-ui.button`
- `x-ui.link`
- form status or feedback primitives
- loading indicator primitives

## Behavioral requirements

### Save-required behavior

When form changes require explicit save:

- modified state must be clear
- save action must submit all relevant changes
- cancel must stop editing or return to the previous safe state
- reset must return values to the last saved or applied state

### Dirty state

The pattern must define how dirty state is represented.

Allowed approaches:

- always visible actions
- actions enabled only after changes
- sticky dirty-state bar
- inline unsaved changes status

Dirty state must not rely on color alone.

### Loading state

During save or submit:

- prevent duplicate submission
- preserve form state until success
- show pending state on the submitting action
- avoid allowing conflicting actions

### Post-save behavior

After successful save:

- hand off to approved success feedback
- clear dirty state
- keep the user in context unless the workflow requires navigation
- update visible saved data

After failed save:

- preserve user-entered values
- show the failure in an appropriate feedback pattern
- provide a clear recovery path

## Action requirements

### Save

- Must describe what is being saved when ambiguity exists.
- May use `Save`, `Save changes`, or a domain-specific verb.

### Cancel

- Stops the current edit flow.
- Must warn if canceling would discard unsaved changes.

### Reset

- Reverts to last saved or applied state.
- Must not be used to mean "clear all fields."

### Submit

- Use only when no more specific action verb exists.

## Permission requirements

- Hidden actions must not leave visual gaps in the form footer.
- Disabled actions must include a reason when the reason is not obvious.
- Server-side authorization remains mandatory.

## Loading requirements

Loading is owned by the submit/save action and must prevent duplicate submission. Peer actions that would conflict with the pending request should be disabled until the request completes or fails.

## Feedback requirements

Form Actions Bar may provide a feedback region, but it does not own feedback styling. Feedback must use approved form, notification, inline loading, or status patterns.

## Accessibility requirements

- Form action region must be reachable by keyboard.
- Loading and save status must be announced when needed.
- Error recovery must not require pointer-only interaction.
- Sticky behavior must not obscure content or controls.

## Examples to prove

- Basic save / cancel
- Save changes with dirty state
- Save loading
- Save success handoff
- Save failure handoff
- Reset to saved values
- Cancel with unsaved changes warning
- Continue / back workflow

## Testing requirements

Tests should assert:

- save/cancel actions render in expected order
- dirty-state attributes/classes render when provided
- loading state is supported
- reset is separate from clear
- feedback slot/region can render
- children remain approved UI primitives

## Open questions / implementation notes

- Existing `x-patterns.form-actions-bar` remains transitional until a future pass maps or migrates it into this family.
- Sticky action bars remain gated by Forms Pattern proof.
