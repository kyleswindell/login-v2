---
title: Destructive Action
slug: common-actions-destructive-action
api_layer: Pattern API
status: approved-standard
system_maturity: standards-wireframe
category: common-actions
canonical_doc: docs/02-standards/ui/patterns/common-actions/destructive-action.md
source_owner: resources/views/components/patterns/common-actions/destructive-action
source_status: not implemented
---

# Destructive Action

## Purpose

Destructive Action defines the standard handling for actions that destroy, revoke, disable, reset, regenerate, or otherwise create sensitive or difficult-to-reverse consequences.

Delete is the clearest destructive action because it destroys an object and may be permanent. Carbon recommends warning users about negative consequences and using danger treatment or confirmation when needed.

## Use when

Use Destructive Action for:

- delete
- reset, when the reset affects sensitive, system-level, security, tenant, credential, or difficult-to-recover configuration
- revoke
- disable
- regenerate
- disconnect
- archive, only when treated as sensitive in the current context
- bulk destructive actions

## Do not use when

Do not use Destructive Action for:

- remove from a list when the object is not destroyed
- dismiss notification
- close modal
- cancel workflow
- clear field data
- ordinary form reset that only returns editable values to their last saved or applied state
- ordinary navigation

## Composed primitives

Destructive Action may compose:

- Confirmation Action
- Action Set
- `x-ui.button`
- menu item primitive
- `x-ui.modal`
- dialog primitive only after contract readiness is confirmed
- MFA step-up workflow
- audit metadata/event hook
- feedback primitive

## Behavioral requirements

### Severity

#### Low

Use when the action is easy to undo or recreate.

Requirements:

- danger styling may not be necessary
- confirmation may not be necessary
- success feedback may be lightweight

#### Moderate

Use when the action is not easily undone or affects multiple items.

Requirements:

- confirmation required
- consequence copy required
- explicit confirm label required

#### High

Use when the action is expensive to recover from, affects many items, affects access/security, or may cascade.

Requirements:

- confirmation required
- manual confirmation required
- MFA step-up may be required
- audit expectation required
- explicit consequence copy required

## Action-specific requirements

### Delete

- Destroys the object.
- Must not be used for simple detachment.
- Must clearly identify the object being deleted.
- Must define post-delete destination or UI removal behavior.

### Reset

- Reverts sensitive, system-level, security, tenant, credential, or difficult-to-recover configuration to saved/applied state or default configuration.
- Must state what values will change.
- Must not mean clear unless the result is actually emptying fields.
- Ordinary form reset belongs to Action Set or Form Actions Bar, not Destructive Action.

### Revoke

- Removes access, token, session, invitation, or credential.
- Should usually require confirmation.
- May require audit and MFA.

### Disable

- Turns off a user, module, policy, integration, or setting.
- Must explain downstream effects.
- May require confirmation when access, security, billing, or workflow impact exists.

### Regenerate

- Replaces a credential, token, secret, key, or generated resource.
- Must explain whether the previous value stops working.
- Usually requires confirmation.
- May require MFA and audit.

## Permission requirements

- Server-side authorization is mandatory.
- UI visibility must not be the enforcement layer.
- Permission-hidden vs disabled behavior must be documented per usage.

## Audit requirements

For sensitive destructive actions, the implementation must define:

- actor
- target object
- action name
- timestamp
- previous state when applicable
- resulting state when applicable
- source/context
- failure state when applicable

## MFA step-up requirements

MFA step-up should be considered when the action affects:

- authentication
- authorization
- credentials
- security policy
- account status
- financial/legal access
- tenant/module availability

## Loading requirements

Destructive actions that submit to the server must prevent duplicate submission and show pending state. Peer actions that conflict with the destructive request should be disabled while pending.

## Feedback requirements

After success:

- update or remove the affected UI
- provide success feedback
- return user to a logical safe location when the object no longer exists

After failure:

- preserve context
- restore the affected UI if it was optimistically removed
- provide a clear retry or recovery path

## Accessibility requirements

- Destructive meaning must not rely on color alone.
- Danger labels must be explicit.
- Confirmation dialogs must be accessible.
- Manual confirmation must be labeled and validated accessibly.

## Examples to prove

- Low-impact delete
- Moderate delete with confirmation
- High-impact delete with manual confirmation
- Revoke token
- Disable user
- Regenerate secret
- Bulk delete
- Failure recovery

## Testing requirements

Tests should assert:

- destructive labels are explicit
- severity is represented
- confirmation can be required
- manual confirmation can be required
- MFA/audit metadata expectations can be represented
- remove and delete are not treated as synonyms

## Open questions / implementation notes

- The first source implementation should support severity metadata without enforcing business policy in Blade.
- MFA and audit remain backend contracts; the visual pattern only documents and exposes the expected handoff.
