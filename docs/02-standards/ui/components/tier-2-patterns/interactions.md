# Tier 2 Interaction Patterns

## Purpose

Define reusable control and interaction patterns composed from Tier 1 primitives.

## Patterns

### Search And Filter Bar

- [ ] purpose: standardizes a reusable control area for search, filters, and sort controls outside feature logic
- [ ] Tier 1 components used: input control baseline, Button, Badge baseline where applicable, Stack / Flex baseline, Divider where applicable
- [ ] minimal interaction behavior: supports search input, filter controls, sort controls, and clear/reset path
- [ ] required states: default, focus, active-filter, disabled, loading where applicable
- [ ] accessibility expectations: control labels are explicit and active filters are understandable without color alone
- [ ] UI Reference requirement: visible with search-only and search-plus-filter variants

### Date Filter / Date Range Pattern

- [ ] purpose: standardizes reusable date-based filtering for list, index, and reporting surfaces
- [ ] Tier 1 components used: input control baseline, Select baseline where applicable, Button, Stack / Flex baseline
- [ ] minimal interaction behavior: supports explicit start/end date visibility, optional preset selection, and clear/apply actions without feature-specific query logic
- [ ] required states: default, focus, active-filter, disabled where applicable
- [ ] accessibility expectations: date controls retain visible labels and the range relationship remains clear across breakpoints
- [ ] UI Reference requirement: visible with explicit range fields, preset options, and action placement

### Bulk Action Bar

- [ ] purpose: provides a reusable action surface that appears when items are selected
- [ ] Tier 1 components used: Button, Badge baseline, Inline alert baseline where applicable, Stack / Flex baseline
- [ ] minimal interaction behavior: appears only in selection-active state and exposes contextual actions
- [ ] required states: hidden, selection-active, disabled, loading where applicable
- [ ] accessibility expectations: selected-count messaging is explicit and action order remains keyboard safe
- [ ] UI Reference requirement: visible with zero-selection and selection-active examples

### Segmented Control

- [ ] purpose: standardizes compact option switching for a small set of peer choices
- [ ] Tier 1 components used: Button baseline, Badge baseline where applicable, Stack / Flex baseline
- [ ] minimal interaction behavior: supports single-select behavior and active-state indication
- [ ] required states: default, hover, focus, active, disabled
- [ ] accessibility expectations: option names are explicit and current selection is programmatically identifiable
- [ ] UI Reference requirement: visible with two-option and three-option examples

## Related

- [Boundary And Validation](boundary-and-validation.md)
- [Tier 2 Pattern Library Checklist](../Tier%202%20Pattern%20Library%20Checklist.md)
