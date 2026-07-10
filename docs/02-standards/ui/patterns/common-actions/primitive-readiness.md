---
title: Common Actions Primitive Readiness
slug: common-actions-primitive-readiness
api_layer: Pattern readiness checklist
status: approved-standard
system_maturity: standards-wireframe
category: common-actions
canonical_doc: docs/02-standards/ui/patterns/common-actions/primitive-readiness.md
source_owner: resources/views/components/patterns/common-actions
source_status: not implemented
---

# Common Actions Primitive Readiness

## Purpose

This checklist identifies which approved UI primitives may be used when implementing Common Actions patterns.

It is not a Pattern API and does not introduce new visual styles. It records dependency readiness so Common Actions implementation does not build on undocumented primitive behavior.

## Readiness rule

Before implementing a Common Actions pattern, confirm every composed primitive has:

- documented public props
- declared variants and states
- documented accessibility requirements
- reference examples
- tests or planned tests
- known lifecycle status

Do not implement Common Actions source helpers on top of undocumented primitive APIs.

## Current readiness map

| Primitive | Required by | Contract ready | Notes |
| --- | --- | --- | --- |
| Button | Action Set, Form Actions Bar, Confirmation Action, Destructive Action, Inline Row Actions | Yes | Strongest dependency. Must support primary, secondary, ghost, danger, disabled, loading, and icon use. |
| Link | Action Set, Navigation Action, Form Actions Bar | Usable with caution | Contract and examples exist, but the component standard is pending correction. Use for navigation, not commands. |
| Icon | Action Set, Overflow Actions, Inline Row Actions, Navigation Action | Yes, as an Element API | Use `x-ui.icon` through the manifest-backed Icons element standard. Do not add icon aliases or standalone action icon APIs. |
| Modal | Confirmation Action, Destructive Action | Usable with caution | Contract exists and focus/accessibility expectations are documented, but the standard is pending correction. |
| Dialog | Confirmation Action, Destructive Action | No | Do not depend on `x-ui.dialog` until its public API contract and standard are documented. Use Modal for current planning. |
| Menu | Overflow Actions, Inline Row Actions | Usable with caution | Contract and examples exist, but the standard is pending manual review. Must support keyboard navigation, disabled items, and destructive item handoff before implementation. |
| Toggle | Toggle Action | Usable with caution | Correct on/off setting primitive. Contract exists, but the standard is pending correction. |
| Switch | None for Common Actions | No | `x-ui.switch` is a content-switcher child option, not an on/off setting control. Do not use it for Toggle Action. |
| Checkbox | Toggle Action, Confirmation Action manual confirmation | Yes | Contract and examples exist; use for independent selections and manual confirmation inputs. |
| Tooltip | Copy feedback, icon-only help, disabled reasons | Usable with caution | Non-interactive help only. Contract exists, but standard is pending correction. |
| Toggletip | Disabled reasons, longer contextual help | Usable with caution | Interactive help disclosure. Contract exists, but standard is pending correction. |

## Implementation sequence guidance

Implement Action Set first because it depends primarily on Button, Link, and Icon.

Defer source implementation for Confirmation Action, Destructive Action, Toggle Action, Overflow Actions, and Inline Row Actions until the relevant primitive correction/manual-review work is accepted or explicitly scoped.

## Related APIs

- [Common Actions](index.md)
- [Button Component](../../components/button.md)
- [Link Component](../../components/link.md)
- [Menu Component](../../components/menu.md)
- [Modal Component](../../components/modal.md)
- [Toggle Component](../../components/toggle.md)
- [Checkbox Component](../../components/checkbox.md)
- [Tooltip Component](../../components/tooltip.md)
- [Toggletip Component](../../components/toggletip.md)
- [Icons Element](../../elements/icons.md)
