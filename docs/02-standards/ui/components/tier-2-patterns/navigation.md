# Tier 2 Navigation Patterns

## Purpose

Define reusable navigation and page-heading patterns composed from Tier 1 primitives.

## Patterns

### Tab Panel System

- [ ] purpose: organizes peer content areas behind tab navigation
- [ ] Tier 1 components used: Button or Link baseline, Section / Panel baseline, Divider where applicable
- [ ] minimal interaction behavior: binds tabs to panels and supports keyboard navigation
- [ ] required states: default, hover, focus, active, disabled where applicable
- [ ] accessibility expectations: tab, tablist, and tabpanel semantics are present; arrow-key navigation is supported
- [ ] UI Reference requirement: visible with active, disabled, and overflow examples

### Page Title And Actions Row

- [ ] purpose: standardizes page-level title, subtitle, and action placement inside content areas
- [ ] Tier 1 components used: Stack / Flex baseline, Button, Link baseline, Divider where applicable
- [ ] minimal interaction behavior: supports optional subtitle, actions, and optional hierarchy-context slotting
- [ ] required states: default
- [ ] accessibility expectations: heading hierarchy is preserved and action labels are explicit
- [ ] UI Reference requirement: visible with and without breadcrumbs

### Sub-navigation Bar

- [ ] purpose: provides reusable section-level navigation below the primary shell
- [ ] Tier 1 components used: Link baseline, Button baseline where applicable, Divider, Stack / Flex baseline
- [ ] minimal interaction behavior: supports active-item indication and overflow-safe layout
- [ ] required states: default, hover, focus, active, disabled where applicable
- [ ] accessibility expectations: current item is programmatically identified and keyboard navigation is supported
- [ ] UI Reference requirement: visible with active and overflow examples

### Breadcrumbs

- [ ] purpose: presents hierarchical navigation context for the current surface
- [ ] Tier 1 components used: Link baseline, Icon baseline, Stack / Flex baseline
- [ ] minimal interaction behavior: supports hierarchy display and truncation rules
- [ ] required states: default, hover, focus, active for current item handling where applicable
- [ ] accessibility expectations: current page is identified and separator treatment is non-verbose for screen readers
- [ ] UI Reference requirement: visible in short and truncated examples

## Related

- [Boundary And Validation](boundary-and-validation.md)
- [Tier 2 Pattern Library Checklist](../Tier%202%20Pattern%20Library%20Checklist.md)
