# Tier 2 Pattern Boundary And Validation

## Purpose

Define Tier 2 ownership boundaries, implementation rules, checklist format, shared constraints, UI Reference validation, and exit criteria.

## Tier Boundary

### Tier 1 Definition

Tier 1 is limited to primitives and baseline structural shells.

Tier 1 owns inputs, buttons, status primitives, table baseline, overlay baseline, shell navigation baseline, and baseline layout/scaffolding primitives.

### Tier 2 Definition

Tier 2 is limited to composed reusable patterns built from Tier 1.

Tier 2 owns app-wide assemblies such as navigation patterns, form patterns, feedback patterns, and higher-order content patterns that remain reusable across multiple features.

### Explicitly Excluded From Tier 2

The following are out of scope for Tier 2:

- Tier 1 primitives and baseline shells
- business logic
- model or API coupling
- feature-specific workflows
- one-off page compositions
- page- or module-specific UI

## Implementation Rules

- Tier 2 patterns must be built only from Tier 1 primitives and baseline shells.
- Tier 2 patterns must not duplicate primitive logic already owned by Tier 1.
- Tier 2 patterns must not introduce business logic, model coupling, or API coupling.
- Tier 2 patterns must not use custom styling outside the canonical token system.
- Tier 2 patterns may include only minimal reusable interaction behavior.
- Tier 2 patterns must support required states and accessibility expectations for their role.
- Tier 2 patterns must be rendered in the UI Reference patterns section.

## Pattern Checklist Format

Every Tier 2 pattern entry must define:

- purpose
- Tier 1 components used
- minimal required interaction behavior
- required states
- accessibility expectations
- UI Reference requirement

## Cross-Cutting System Constraints

### Interaction States

All Tier 2 patterns must support applicable states for their role:

- default
- hover
- focus
- active
- disabled
- loading where applicable

### Accessibility

- keyboard navigation is supported where applicable
- focus management is explicit for overlays and contextual surfaces
- ARIA roles and relationships are present where needed
- screen-reader compatibility is preserved across states and responsive layouts

### Composition Rules

- built strictly from Tier 1 primitives and baseline shells
- no direct styling outside the token system
- no duplication of primitive logic

## UI Reference Validation

Applicable Tier 2 patterns must be represented in the UI Reference patterns section.

Checklist:

- [ ] every Tier 2 pattern is visible where applicable
- [ ] required states are visible
- [ ] interactions can be manually tested
- [ ] examples demonstrate reusable pattern usage rather than feature behavior

## Batch B Exit Criteria

Batch B is complete only if:

- [ ] all Tier 2 patterns implemented
- [ ] all Tier 2 patterns built only from Tier 1
- [ ] UI Reference updated for all applicable Tier 2 patterns
- [ ] no feature logic introduced
- [ ] no Tier 1 primitives duplicated in Tier 2 implementations
- [ ] checklist fully complete
- [ ] manual visual review = PASS
- [ ] manual functional validation = PASS

## Related

- [Tier 2 Pattern Library Checklist](../Tier%202%20Pattern%20Library%20Checklist.md)
- [Tier 1 Component Implementation Checklist](../Tier%201%20Component%20Implementation%20Checklist.md)
