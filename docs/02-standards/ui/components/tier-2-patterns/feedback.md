# Tier 2 Feedback Patterns

## Purpose

Define reusable content-state feedback patterns composed from Tier 1 primitives.

## Patterns

### Empty State

- [ ] purpose: presents a reusable no-data or no-results pattern with a clear next action
- [ ] Tier 1 components used: Section / Panel baseline, Button, Link baseline, Icon baseline
- [ ] minimal interaction behavior: supports icon, explanation, and primary action with optional secondary action
- [ ] required states: default
- [ ] accessibility expectations: message and actions are announced clearly and remain understandable without icon meaning alone
- [ ] UI Reference requirement: visible for no-data and no-results variants

### Error State Block

- [ ] purpose: presents a reusable recoverable error surface inside page content
- [ ] Tier 1 components used: Inline alert baseline, Button, Link baseline, Section / Panel baseline
- [ ] minimal interaction behavior: supports diagnostic message and retry or recovery action slotting
- [ ] required states: default, error
- [ ] accessibility expectations: error message is announced appropriately and recovery actions are explicit
- [ ] UI Reference requirement: visible with retry and non-retry variants

### Success State Block

- [ ] purpose: presents a reusable success confirmation surface with optional follow-up action
- [ ] Tier 1 components used: Inline alert baseline, Button, Link baseline, Section / Panel baseline
- [ ] minimal interaction behavior: supports confirmation message and optional next-action slotting
- [ ] required states: default, success
- [ ] accessibility expectations: confirmation message remains understandable without color alone
- [ ] UI Reference requirement: visible with passive and action-oriented variants

### Skeleton Loader Pattern

- [ ] purpose: provides reusable layout-matching loading placeholders for Tier 2 surfaces
- [ ] Tier 1 components used: Spinner, Section / Panel baseline, Grid baseline, Stack / Flex baseline
- [ ] minimal interaction behavior: mirrors final layout structure without introducing feature logic
- [ ] required states: loading
- [ ] accessibility expectations: loading treatment is announced appropriately and decorative placeholders are hidden from assistive technology where needed
- [ ] UI Reference requirement: visible for table-adjacent, card, and form layouts where applicable

## Related

- [Boundary And Validation](boundary-and-validation.md)
- [Tier 2 Pattern Library Checklist](../Tier%202%20Pattern%20Library%20Checklist.md)
