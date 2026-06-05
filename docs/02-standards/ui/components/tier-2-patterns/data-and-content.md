# Tier 2 Data And Content Patterns

## Purpose

Define reusable data display and content summary patterns composed from Tier 1 primitives.

## Patterns

### Enhanced Data Table

- [ ] purpose: extends the Tier 1 table baseline with reusable advanced controls
- [ ] Tier 1 components used: Table baseline, Button, input control baseline, Badge baseline, Modal or Drawer baseline where applicable
- [ ] minimal interaction behavior: supports filters, bulk actions, row selection, and column visibility toggle without feature logic
- [ ] required states: default, loading, empty, selection-active
- [ ] accessibility expectations: row selection is keyboard reachable, table semantics are preserved, control labels are explicit
- [ ] UI Reference requirement: visible with filter, selection, and empty-state examples

### Data List Item

- [ ] purpose: standardizes a reusable list row with title, supporting metadata, and optional actions
- [ ] Tier 1 components used: Section / Panel baseline, Badge baseline, Button or Icon Button, Link baseline
- [ ] minimal interaction behavior: supports action slotting and metadata alignment only
- [ ] required states: default, hover, focus where interactive, disabled where applicable
- [ ] accessibility expectations: interactive rows or actions expose clear labels and focus order
- [ ] UI Reference requirement: visible with and without trailing actions

### Stat Card

- [ ] purpose: presents a reusable metric summary with optional supporting trend indicator
- [ ] Tier 1 components used: Section / Panel baseline, Badge baseline, Icon baseline where applicable
- [ ] minimal interaction behavior: supports metric, label, and optional trend display only
- [ ] required states: default, loading where applicable
- [ ] accessibility expectations: metric label relationship remains clear to assistive technology
- [ ] UI Reference requirement: visible in single-card and grouped-card layouts

### Identity Summary Card

- [ ] purpose: standardizes avatar, name, metadata, status, and optional actions for internal account/operator summaries
- [ ] Tier 1 components used: Section / Panel baseline, Badge baseline, Icon baseline where applicable, Button, Link baseline
- [ ] minimal interaction behavior: supports identity header, supporting metadata, optional status, and optional follow-up action placement only
- [ ] required states: default, loading where applicable
- [ ] accessibility expectations: identity labeling remains explicit and action labels are unambiguous
- [ ] UI Reference requirement: visible with avatar fallback, metadata, status, and optional action examples

### Key Value Display

- [ ] purpose: presents label and value pairs in a reusable read-only display pattern
- [ ] Tier 1 components used: Grid baseline, Stack / Flex baseline, Label baseline, Divider where applicable, Link baseline where applicable
- [ ] minimal interaction behavior: supports responsive stacking and consistent label/value alignment
- [ ] required states: default
- [ ] accessibility expectations: reading order remains logical across layouts
- [ ] UI Reference requirement: visible in stacked and multi-column examples

## Related

- [Boundary And Validation](boundary-and-validation.md)
- [Tier 2 Pattern Library Checklist](../Tier%202%20Pattern%20Library%20Checklist.md)
