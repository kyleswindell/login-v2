# Tier 1 - Input Controls Contract

This document defines the canonical scope and intent for Tier 1 - Input Controls Contract.

## Component Contract

### 1. Component Identity

- Component name: Text Input, Textarea, Select, Checkbox, Radio Group, Switch / Toggle
- Taxonomy path (L1/L2): Inputs And Forms / Inputs
- Owner: Platform UI baseline owner

### 2. Intent And Theory

- Primary use case: Capture structured, freeform, and binary/selectable data reliably.
- When to use: Configuration forms, settings forms, filtering forms, and boolean/choice inputs.
- When not to use: One-click action triggers that do not collect or change field state.
- Interaction intent summary: predictable field behavior with clear validation and assistive context.

### 2A. Implementation Form Decision

- Current implementation form: `Class/markup contract`
- Intended long-term direction: `keep as class/markup contract` for native controls, with a clearer wrapper contract
- Canonical wrapper contract:
  - text input / textarea / select:
    - field wrapper
    - visible label
    - control element
    - optional helper copy
    - optional error copy
  - checkbox:
    - selectable row wrapper
    - native checkbox control
    - visible option label
    - optional helper copy
  - radio group:
    - fieldset wrapper
    - legend or screen-reader-only group label
    - repeated selectable option rows
    - optional group-level helper or error copy
  - switch / toggle:
    - row wrapper with visible setting label
    - optional helper copy
    - native switch input with track/thumb structure
- Transitional rule:
  - UI Reference may demonstrate review states, but snapshot examples do not replace the required wrapper structure above

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): shared form field and control tokens with clear label/helper/error hierarchy.
- Light theme behavior: retain border and label contrast.
- Dark theme behavior: preserve field/background distinction.
- Density/size variants: standard default density for Tier 1.
- Allowed variants: `base` only.

### 4. Behavior Rules

- Default behavior: editable field or selectable control with helper text support.
- Hover/focus/active behavior: visible focus border/ring or checked-state affordance as appropriate to the control.
- Disabled/loading behavior: disabled fields and controls are non-interactive but readable.
- Error/warning/success behavior (if applicable): inline field error + optional summary block.
- Responsive behavior (desktop/tablet/mobile): one and two-column layouts collapse without clipping.

### 5. Accessibility Requirements

- Semantic structure required: associated `label` and field IDs or explicit control labeling for grouped controls.
- Keyboard interactions: standard tab/shift-tab and native control keyboard support, including radio and checkbox semantics.
- Focus-visible rules: strong visible focus for all fields.
- Contrast requirements: WCAG 2.2 AA baseline.
- Screen reader behavior: errors linked via `aria-describedby`; invalid state via `aria-invalid`.
- Reduced-motion behavior: no required motion.

### 6. Content Rules

- Label/content guidelines: clear nouns for fields and explicit option labels for selectable controls.
- Error/help messaging rules: describe what failed and how to fix.
- Localization notes: support longer translated labels and helper text.

### 7. Anti-Patterns

- Anti-pattern 1: missing visible labels
- Anti-pattern 2: errors shown without field association
- Anti-pattern 3: disabled fields or controls with unreadable contrast
- Anti-pattern 4: copying large form example blocks when only the canonical field wrapper contract is needed


## Related

- [UI UX Component Taxonomy And Coverage Matrix](../components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [UI UX Tier 1 UI Reference Implementation Checklist](../../../09-reference/ui/UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
