---
title: Navigation Action
slug: common-actions-navigation-action
api_layer: Pattern API
status: approved-standard
system_maturity: standards-wireframe
category: common-actions
canonical_doc: docs/02-standards/ui/patterns/common-actions/navigation-action.md
source_owner: resources/views/components/patterns/common-actions/navigation-action
source_status: not implemented
---

# Navigation Action

## Purpose

Navigation Action defines links that behave like actions because they initiate task-oriented movement to another page, setup flow, detail view, or settings area.

Navigation Action does not own active/current state. Active/current state belongs to navigation and layout patterns.

## Use when

Use Navigation Action when the user is moving somewhere to complete or inspect a task.

Examples:

- Open setup
- View details
- Go to settings
- Manage users
- Configure MFA
- Review audit log
- Return to dashboard

## Do not use when

Do not use Navigation Action for:

- saving data
- deleting data
- submitting a form
- toggling a setting
- opening a menu without navigation
- actions that mutate state before navigation

## Composed primitives

Navigation Action may compose:

- `x-ui.link`
- `x-ui.button` only when the destination is exposed through a control that must behave as a button
- `x-ui.icon`
- card/list item primitives
- breadcrumb/nav primitives when applicable

## Behavioral requirements

### Link vs button

Use a link when activating the control changes location.

Use a button when activating the control performs a command.

If a button performs a command and then navigates after success, document the command pattern instead of Navigation Action.

### Labels

Labels must describe destination or task.

Preferred:

- View details
- Open setup
- Go to security settings
- Configure integration
- Review activity

Avoid:

- Click here
- Learn more, unless used in content marketing or documentation context
- Manage, when a more specific destination exists

### External navigation

External navigation must indicate when the user leaves the app if the destination is not obvious.

### Current state

Current/active state must be handled by navigation patterns, not this pattern.

## Permission requirements

- Hide links to destinations the user should not know exist.
- Disable or show unavailable state only when the user can know the destination exists but cannot currently access it.
- Access must still be enforced server-side.

## Loading requirements

Navigation links usually do not require loading state.

Loading may be used when:

- the link starts a setup session
- a route must be generated
- permissions are being resolved
- a command must complete before navigation

If mutation occurs first, this pattern must hand off to the relevant command action pattern.

## Feedback requirements

Navigation Action usually does not own feedback.

Feedback belongs to the destination page unless the navigation fails before leaving the current page.

## Accessibility requirements

- Links must have meaningful accessible names.
- Icon-only navigation actions require accessible labels.
- External links must be announced where appropriate.
- Keyboard and focus behavior must follow link expectations.

## Examples to prove

- View details link
- Open setup action
- Go to settings link
- Configure integration link
- Icon + text navigation action
- Icon-only navigation action
- Permission-hidden destination
- External destination

## Testing requirements

Tests should assert:

- navigation renders as link by default
- accessible label is present
- icon-only navigation requires a label
- active/current state is not owned by this pattern
- disabled/hidden permission behavior is documented
- mutation-before-navigation is excluded or handed off

## Open questions / implementation notes

- This pattern does not replace Navigation Pattern ownership of menus, sidebars, breadcrumbs, current state, or route hierarchy.
- The first implementation should be limited to task-oriented links inside action regions.
