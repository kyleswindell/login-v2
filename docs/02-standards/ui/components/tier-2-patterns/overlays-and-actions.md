# Tier 2 Overlay And Action Patterns

## Purpose

Define reusable overlay and compact action patterns composed from Tier 1 primitives.

## Patterns

### Confirm Dialog

- [ ] purpose: standardizes short confirmation flows for reversible or destructive actions
- [ ] Tier 1 components used: Modal baseline, Button, Inline alert baseline where applicable
- [ ] minimal interaction behavior: supports title, message, confirm, cancel, and destructive emphasis rules
- [ ] required states: default, focus, disabled, loading where applicable
- [ ] accessibility expectations: focus trap, focus return, explicit destructive labeling
- [ ] UI Reference requirement: visible for standard and destructive confirmations

### Form Modal

- [ ] purpose: standardizes short-form editing inside a modal container
- [ ] Tier 1 components used: Modal baseline, input control baseline, Label baseline, Button, Inline alert baseline, Stack / Flex baseline
- [ ] minimal interaction behavior: supports field layout, validation display, and submission-state presentation without feature logic
- [ ] required states: default, focus, error, disabled, loading
- [ ] accessibility expectations: overlay focus management is preserved and validation messaging is programmatically associated
- [ ] UI Reference requirement: visible with default and validation-error examples

### Drawer Form

- [ ] purpose: standardizes contextual editing inside a drawer container
- [ ] Tier 1 components used: Drawer baseline, input control baseline, Label baseline, Button, Inline alert baseline, Stack / Flex baseline
- [ ] minimal interaction behavior: supports side-panel editing, validation display, and submission-state presentation without feature logic
- [ ] required states: default, focus, error, disabled, loading
- [ ] accessibility expectations: overlay focus management is preserved and heading plus close action are explicit
- [ ] UI Reference requirement: visible with default and validation-error examples

### Popover

- [ ] purpose: presents anchored contextual content that is richer than a tooltip and lighter than a modal
- [ ] Tier 1 components used: Button or Link baseline, Section / Panel baseline, Divider where applicable
- [ ] minimal interaction behavior: supports anchored positioning, open and close behavior, and focus-safe dismissal
- [ ] required states: default, open, focus
- [ ] accessibility expectations: trigger relationship is explicit and keyboard dismissal is supported
- [ ] UI Reference requirement: visible with text-only and action-list variants

### Dropdown Action Menu

- [ ] purpose: standardizes compact grouped actions behind a trigger control
- [ ] Tier 1 components used: Button or Icon Button, Link baseline, Divider, Section / Panel baseline
- [ ] minimal interaction behavior: supports grouped actions, keyboard navigation, outside-click and escape dismissal behavior, and unclipped overlay layering
- [ ] required states: default, open, hover, focus, disabled where applicable
- [ ] accessibility expectations: menu semantics are present where appropriate and active descendant or focus movement is keyboard safe
- [ ] UI Reference requirement: visible with grouped and destructive action examples

### Context Menu

- [ ] purpose: provides an alternate action-entry surface for advanced pointer-driven interaction
- [ ] Tier 1 components used: Button or Icon Button, Link baseline, Divider, Section / Panel baseline
- [ ] minimal interaction behavior: supports context-triggered opening and the same action model as dropdown action menus
- [ ] required states: default, open, hover, focus
- [ ] accessibility expectations: equivalent keyboard-accessible actions remain available outside right-click interaction
- [ ] UI Reference requirement: visible with pointer and keyboard-accessible entry examples

## Related

- [Boundary And Validation](boundary-and-validation.md)
- [Tier 2 Pattern Library Checklist](../Tier%202%20Pattern%20Library%20Checklist.md)
