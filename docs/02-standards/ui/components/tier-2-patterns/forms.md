# Tier 2 Form Patterns

## Purpose

Define reusable Tier 2 form patterns composed from Tier 1 primitives.

## Patterns

### Form Group

- [ ] purpose: standard field wrapper for label, control, helper text, and error text
- [ ] Tier 1 components used: Label baseline, input control baseline, Link baseline where applicable
- [ ] minimal interaction behavior: associates label, help, and error content with the control; preserves validation visibility
- [ ] required states: default, focus, disabled, error
- [ ] accessibility expectations: programmatic label association, error text association, helper text association
- [ ] UI Reference requirement: visible with helper and error examples

### Form Section

- [ ] purpose: groups related fields under a shared title and optional description
- [ ] Tier 1 components used: Section / Panel baseline, Label baseline, Divider where applicable
- [ ] minimal interaction behavior: supports grouped content and consistent spacing only
- [ ] required states: default
- [ ] accessibility expectations: section heading hierarchy is preserved
- [ ] UI Reference requirement: visible with title, description, and grouped fields

### Inline Form Row

- [ ] purpose: aligns label and control horizontally when space allows, with responsive fallback
- [ ] Tier 1 components used: Grid baseline, Stack / Flex baseline, Label baseline, input control baseline
- [ ] minimal interaction behavior: switches cleanly between horizontal and stacked layout
- [ ] required states: default, focus, disabled, error
- [ ] accessibility expectations: label association remains intact across breakpoints
- [ ] UI Reference requirement: visible in desktop and narrow-width examples

### Form Actions Bar

- [ ] purpose: standardizes placement and grouping for form actions
- [ ] Tier 1 components used: Button, Divider where applicable, Stack / Flex baseline
- [ ] minimal interaction behavior: preserves primary, secondary, and destructive action grouping and alignment
- [ ] required states: default, disabled, loading where applicable
- [ ] accessibility expectations: tab order follows visual priority; destructive actions remain clearly labeled
- [ ] UI Reference requirement: visible with primary, secondary, and destructive actions

### Validation Summary

- [ ] purpose: provides a form-level error summary for multi-error cases
- [ ] Tier 1 components used: Inline alert baseline, Link baseline, Section / Panel baseline where applicable
- [ ] minimal interaction behavior: lists validation errors and supports link-to-field behavior
- [ ] required states: default, error
- [ ] accessibility expectations: summary is announced appropriately and links move focus predictably
- [ ] UI Reference requirement: visible with multiple linked field errors

## Related

- [Boundary And Validation](boundary-and-validation.md)
- [Tier 2 Pattern Library Checklist](../Tier%202%20Pattern%20Library%20Checklist.md)
