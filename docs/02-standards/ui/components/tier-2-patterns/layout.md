# Tier 2 Layout Patterns

## Purpose

Define reusable layout and content-shell patterns composed from Tier 1 primitives.

## Patterns

### Split View

- [ ] purpose: standardizes a reusable list-and-detail content arrangement
- [ ] Tier 1 components used: Grid baseline, Section / Panel baseline, Divider where applicable
- [ ] minimal interaction behavior: supports coordinated list and detail regions with responsive fallback
- [ ] required states: default, loading where applicable, empty-detail where applicable
- [ ] accessibility expectations: region headings remain clear and reading order remains logical across breakpoints
- [ ] UI Reference requirement: visible in wide and narrow layouts

### Dashboard Grid

- [ ] purpose: standardizes reusable card-based summary layouts without feature-specific content
- [ ] Tier 1 components used: Grid baseline, Section / Panel baseline, Badge baseline, Icon baseline where applicable
- [ ] minimal interaction behavior: supports repeatable responsive placement, spacing rules, and an explicit reusable span model for supported widget sizes
- [ ] required states: default, loading where applicable
- [ ] accessibility expectations: card grouping and heading hierarchy remain clear
- [ ] UI Reference requirement: visible in single-row and multi-row examples

### Content Section Block

- [ ] purpose: standardizes a titled content block with consistent internal spacing
- [ ] Tier 1 components used: Section / Panel baseline, Divider where applicable, Stack / Flex baseline
- [ ] minimal interaction behavior: supports title, optional supporting text, and content slotting only
- [ ] required states: default
- [ ] accessibility expectations: heading hierarchy is preserved
- [ ] UI Reference requirement: visible with and without supporting text

### Widget Shell

- [ ] purpose: standardizes reusable dashboard widget anatomy and density rules without tying the shell to one module
- [ ] Tier 1 components used: Section / Panel baseline, Button or Icon Button where applicable, Badge baseline where applicable, Divider, Grid baseline, Stack / Flex baseline
- [ ] minimal interaction behavior: supports header, title, metadata, local actions, content sections, optional footer, and explicit span variants without feature-specific workflows
- [ ] required states: default, empty, loading, error where the widget contract requires them
- [ ] accessibility expectations: widget title hierarchy remains clear and local actions are explicitly labeled
- [ ] UI Reference requirement: visible with summary, list/activity, mixed-content, and explicit span examples

## Related

- [Boundary And Validation](boundary-and-validation.md)
- [Tier 2 Pattern Library Checklist](../Tier%202%20Pattern%20Library%20Checklist.md)
