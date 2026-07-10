---
title: Common Actions
slug: common-actions
api_layer: Pattern API
status: approved-standard
system_maturity: standards-wireframe
category: common-actions
priority: tier-b-common-reusable-pattern
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/patterns/common-actions/index.md
source_owner: resources/views/components/patterns/common-actions
source_status: partially implemented
consumed_elements:
  - color
  - spacing
  - typography
  - icons
  - motion
consumed_components:
  - button
  - link
  - icon
  - menu
  - modal
  - checkbox
  - toggle
  - tooltip
  - toggletip
  - notification
carbon_reference:
  - https://carbondesignsystem.com/patterns/common-actions/
---

# Common Actions

## Purpose

Common Actions define the standard behavior, wording, hierarchy, permission handling, loading behavior, and feedback expectations for repeated user actions across Login App 2.0.

These patterns do not introduce new visual primitives. They compose approved UI components such as buttons, links, icons, menus, modals, toggles, checkboxes, feedback primitives, and form controls.

## Source alignment

This pattern family follows Carbon's Common Actions guidance: actions that appear repeatedly across workflows should be applied consistently and should not change meaning based on context. Login App keeps its own app-owned Pattern APIs, Blade components, Element token model, and rendered evidence proof.

## Pattern family

- [Action Set](action-set.md)
- [Form Actions Bar](form-actions-bar.md)
- [Confirmation Action](confirmation-action.md)
- [Destructive Action](destructive-action.md)
- [Overflow Actions](overflow-actions.md)
- [Inline Row Actions](inline-row-actions.md)
- [Toggle Action](toggle-action.md)
- [Navigation Action](navigation-action.md)

## Future implementation shape

The future source root is:

```text
resources/views/components/patterns/common-actions/
```

Planned Blade APIs are:

- `x-patterns.common-actions.action-set`
- `x-patterns.common-actions.form-actions-bar`
- `x-patterns.common-actions.confirmation-action`
- `x-patterns.common-actions.destructive-action`
- `x-patterns.common-actions.overflow-actions`
- `x-patterns.common-actions.inline-row-actions`
- `x-patterns.common-actions.toggle-action`
- `x-patterns.common-actions.navigation-action`

The first implemented source slice is `x-patterns.common-actions.action-set`. Existing transitional helpers such as `x-patterns.form-actions-bar` and `x-patterns.dropdown-action-menu` remain unchanged until a later implementation pass maps or migrates them.

## Action vocabulary

| Action | Meaning | Notes |
| --- | --- | --- |
| Add | Insert or associate an object with a list, set, or system. | May be primary, secondary, or low-emphasis depending on page importance. |
| Cancel | Stop the current action or flow. | Must not imply saved changes. |
| Clear | Remove field data, filter data, or selections. | Distinct from reset. |
| Close | Dismiss a surface such as a modal, toast, menu, or panel. | Should not be used as a standard text button when an icon-only close affordance is expected. |
| Copy | Copy a value or object. | Requires post-click copied feedback. |
| Delete | Destroy an object. | Destructive. May require confirmation. |
| Edit | Change data, values, or state. | May appear as a button, icon action, inline action, or menu item. |
| Next | Advance to the next step in a sequence. | Usually used in workflows, steppers, and setup flows. |
| Refresh | Reload a view, object, list, or data set. | Use when current data may be unsynced. |
| Remove | Detach an object from a list or item without destroying it. | Must not be confused with delete. |
| Reset | Revert values to the last saved or applied state. | Typically lower emphasis than save or apply. |

## Required distinctions

### Delete vs Remove

Use **delete** when the object is destroyed.

Use **remove** when the object is detached from a list, group, relationship, or selection but still exists elsewhere.

### Reset vs Clear

Use **reset** when values return to their last saved or applied state.

Use **clear** when field values, filters, or selections are emptied.

### Close vs Cancel

Use **close** to dismiss a surface.

Use **cancel** to stop an in-progress action or flow.

### Command vs Navigation

Use a command action when the user is asking the system to do something.

Use a navigation action when the user is moving to another page, setup flow, detail view, or settings area.

## Shared requirements

### Primitive API contract readiness

Before implementing a Common Actions pattern, confirm that each composed primitive has an API contract ready.

A primitive is ready when:

- its public props are documented
- supported variants and states are declared
- accessibility requirements are documented
- reference examples exist
- tests exist or are planned
- lifecycle status is known

Do not build a Common Actions pattern on top of an undocumented primitive API.

### Composition

Common Action patterns must compose approved UI primitives.

Allowed primitives include:

- `x-ui.button`
- `x-ui.link`
- `x-ui.icon`
- menu and dropdown primitives
- modal primitives
- dialog primitives only after their public API contract is documented
- toggle and checkbox primitives
- tooltip and toggletip primitives
- notification and feedback primitives

Common Action patterns must not redefine core button, link, menu, modal, or toggle styles.

### Hierarchy

- One primary action is allowed per local action group unless a specific pattern allows otherwise.
- Secondary actions must not visually compete with the primary action.
- Danger actions must be visually and semantically distinct.
- Reset, cancel, clear, and close actions should usually be lower emphasis.

### Permissions

Patterns must define whether unauthorized actions are hidden, disabled, or visible with explanation.

Default rule:

- Hide actions the user should not know exist.
- Disable actions the user may know exist but cannot currently perform due to state.
- Disabled actions should provide an accessible reason when the reason is not obvious.
- Server-side permission enforcement is always required.

### Loading

Actions that submit, save, delete, regenerate, revoke, refresh, or retry may enter a loading state.

Loading actions must:

- prevent duplicate submission
- preserve accessible label or status
- communicate pending state
- recover gracefully on failure

### Feedback

Actions that mutate state must hand off to an approved feedback pattern.

Feedback may include:

- inline status
- toast or notification
- modal error
- form error
- page-level status
- list animation or row removal

### Action failure and errors

Common Actions must define what happens when an action fails.

Failure feedback must:

- explain what happened
- preserve user context where possible
- provide a clear recovery path
- avoid leaving the UI in an uncertain pending state
- hand off to the approved feedback pattern for the context

Failure feedback may appear as:

- inline form error
- inline row status
- notification
- modal error
- page-level error

Patterns must not silently fail.

### Copy feedback

Copy actions must provide immediate copied feedback after activation.

Allowed feedback includes:

- copied tooltip
- inline copied state
- approved lightweight notification

Copy actions must not leave the user guessing whether the value was copied.

### Audit and security

Sensitive actions may require:

- confirmation
- manual confirmation
- MFA step-up
- audit log expectation
- permission checks
- server-side validation

The visual pattern must not be the only enforcement layer.

## Not Common Actions

The following are not Common Actions patterns:

- Header menu pattern
- App sidebar pattern
- Settings page pattern
- Setup page pattern
- Account settings pattern
- Validation/status feedback
- Notification system
- Settings/setup landing pages
- Module navigation contribution

Notification actions such as mark read, dismiss, archive, or retry should reuse Inline Row Actions or Overflow Actions.

## Documentation requirements for child patterns

Each child doc must include:

- Purpose
- Use when
- Do not use when
- Composed primitives
- Behavioral requirements
- Accessibility requirements
- Permission requirements
- Loading requirements
- Feedback requirements
- Examples to prove
- Testing requirements
- Open questions or implementation notes

## Related APIs

- [Action Set](action-set.md)
- [Form Actions Bar](form-actions-bar.md)
- [Confirmation Action](confirmation-action.md)
- [Destructive Action](destructive-action.md)
- [Overflow Actions](overflow-actions.md)
- [Inline Row Actions](inline-row-actions.md)
- [Toggle Action](toggle-action.md)
- [Navigation Action](navigation-action.md)
- [Primitive Readiness](primitive-readiness.md)
- [Forms Pattern](../forms.md)
- [Overlays And Actions Pattern](../overlays-and-actions.md)
- [Navigation Pattern](../navigation.md)
- [Feedback Pattern](../feedback.md)
- [Button Component](../../components/button.md)
- [Link Component](../../components/link.md)
- [Menu Component](../../components/menu.md)
- [Modal Component](../../components/modal.md)

## References

- [Carbon Common Actions](https://carbondesignsystem.com/patterns/common-actions/)
