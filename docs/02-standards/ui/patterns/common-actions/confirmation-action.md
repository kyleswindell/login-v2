---
title: Confirmation Action
slug: common-actions-confirmation-action
api_layer: Pattern API
status: approved-standard
system_maturity: standards-wireframe
category: common-actions
canonical_doc: docs/02-standards/ui/patterns/common-actions/confirmation-action.md
source_owner: resources/views/components/patterns/common-actions/confirmation-action
source_status: not implemented
---

# Confirmation Action

## Purpose

Confirmation Action defines the standard confirmation behavior for actions that require user review before execution.

This pattern usually composes the Modal primitive. A separate Dialog primitive may be used only after its public API contract and standard are documented.

## Use when

Use Confirmation Action when an action has consequences that require explicit user review.

Examples:

- delete item
- revoke access
- reset configuration
- disable account
- regenerate token
- discard unsaved changes
- remove multiple selected items

## Do not use when

Do not use Confirmation Action when:

- the action is easy to undo
- the action has no meaningful consequence
- confirmation would create unnecessary friction
- the action is already safely reversible inline

## Composed primitives

Confirmation Action may compose:

- `x-ui.modal`
- dialog primitive only after contract readiness is confirmed
- Action Set
- `x-ui.button`
- `x-ui.icon`
- feedback primitives
- form input primitive for manual confirmation

## Behavioral requirements

### Confirmation levels

#### Low impact

- May not require confirmation.
- Use when the action is trivial to undo or recreate.

#### Moderate impact

- Requires a confirmation dialog.
- Explain what will happen.
- Confirm button label must repeat the action.

#### High impact

- Requires a confirmation dialog.
- Requires manual confirmation, such as typing the resource name.
- Explain irreversible or expensive consequences.

Carbon defines low, moderate, and high-impact deletion levels. Login App uses that impact model as the basis for confirmation severity across destructive and sensitive actions.

## Content requirements

Confirmation copy must include:

- what action will happen
- what object is affected
- whether the result can be undone
- what the user should do next if unsure

Avoid vague confirmation labels:

- Yes
- OK
- Confirm

Preferred confirmation labels:

- Delete user
- Revoke access
- Reset settings
- Disable account
- Regenerate token

Cancel labels should usually be:

- Cancel
- Keep editing
- Go back

## Permission requirements

- Do not render confirmation affordances for actions the user is not allowed to know exist.
- Disabled confirmation triggers must explain state-based unavailability when the reason is not obvious.
- Authorization must be enforced server-side after confirmation.

## Focus requirements

- Focus moves into the dialog when opened.
- Initial focus should land on the safest reasonable control.
- Escape and close behavior must be intentional.
- Focus returns to the trigger after cancel or close.
- After successful confirmation, focus must move to a logical next location.

## Loading requirements

After confirmation:

- confirming action may enter loading state
- duplicate submissions must be prevented
- cancel/close behavior during loading must be defined

## Feedback requirements

After success:

- close dialog unless the next step requires staying inside it
- hand off to success feedback
- update or remove affected UI

After failure:

- keep the dialog open if retry is possible
- explain what failed
- preserve user context
- provide retry or cancel path

## Accessibility requirements

- Dialog must have accessible title and description.
- Confirm and cancel controls must be keyboard accessible.
- Manual confirmation input must have label and validation text.
- Irreversible warnings must not rely on color alone.

## Examples to prove

- Basic confirmation
- Cancel confirmation
- Destructive confirmation
- High-impact manual confirmation
- Loading confirmation
- Confirmation failure
- Discard unsaved changes

## Testing requirements

Tests should assert:

- title and description render
- confirm and cancel labels are explicit
- danger confirmation can render
- manual confirmation can be required
- loading state is supported
- focus-management hooks/attributes are present where applicable

## Open questions / implementation notes

- Multi-step confirmation remains gated until a high-risk feature requires it.
- Confirmation logic must not replace server-side validation, authorization, or audit.
