# Tier 1 - Buttons And Icon Buttons Contract

This document defines the canonical scope and intent for Tier 1 - Buttons And Icon Buttons Contract.

## Component Contract

### 1. Component Identity

- Component name: Button and Icon Button
- Taxonomy path (L1/L2): Inputs And Forms / Form actions
- Owner: Platform UI baseline owner

### 2. Intent And Theory

- Primary use case: Trigger primary and secondary user actions with clear semantic priority.
- When to use: Form actions, row actions, toolbar actions, contextual icon-only controls.
- When not to use: Navigation links, passive status display, long-form content links.
- Interaction intent summary: Preserve consistent action hierarchy and predictable affordance across themes and breakpoints.

### 2A. Implementation Form Decision

- Current implementation form: `Class/markup contract`
- Intended long-term direction: `promote to Blade component`
- Canonical consumption direction:
  - downstream callers should think in descriptors first: semantic, variant, size, loading, disabled, icon-only
  - the long-term canonical entry point should be a Blade API that maps those descriptors to the current Tier 1 styling and behavior
- Transitional rule:
  - until the Blade entry point exists, the documented class contract remains valid
  - new Tier 2 or feature work must not invent alternate action wrapper structures beyond the canonical button or icon-button markup

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): semantic action tokens map through the current design system classes:
  - `primary -> ui-action-primary`
  - `neutral -> ui-action`
  - `success -> ui-action-success`
  - `warning -> ui-action-warning`
  - `danger -> ui-action-danger`
  - `notice -> ui-action-notice`
  - `info -> ui-action-info`
- `outline` and `ghost` are variants, not semantic roles.
- variant mapping:
  - `base` uses the semantic action class directly
  - `soft` uses the semantic action class with reduced-intensity treatment
  - `outline` uses `ui-action-outline`
  - `ghost` uses `ui-action-ghost`
- Secondary-priority actions use neutral semantic actions with `outline` or `ghost` variants; `secondary` is not a separate token family.
- Radius uses canonical token names such as `radius-sm`, `radius-md`, and `radius-lg` rather than raw numeric values.
- Light theme behavior: Preserve stronger contrast than pastel soft variants.
- Dark theme behavior: Maintain visible border and fill distinction for default, soft, and outline.
- Density/size variants: `xs`, `sm`, `md`, `lg`, `xl`.
- Allowed variants: `base`, `soft`, `outline`, `ghost`.
- Allowed semantic subset: `primary`, `neutral`, `success`, `warning`, `danger`, `info`, `notice`.
- Variant constraint: `outline` and `ghost` are neutral-emphasis variants in Tier 1 and must not redefine semantic severity.

### 4. Behavior Rules

- Default behavior: Button and icon button trigger action on click/enter/space.
- Hover/focus/active behavior: clear hover fill/border and visible focus ring.
- Disabled/loading behavior: disabled blocks interaction; loading preserves width and indicates busy state.
- Error/warning/success behavior (if applicable): semantic variants match alert/status mapping.
- Responsive behavior (desktop/tablet/mobile): wraps action rows without clipping and preserves touch targets.

### 5. Accessibility Requirements

- Semantic structure required: `button` for actions, `a` for navigation.
- Keyboard interactions: Tab focus and enter/space trigger.
- Focus-visible rules: high-contrast ring against both themes.
- Contrast requirements: WCAG 2.2 AA baseline.
- Screen reader behavior: icon buttons require `aria-label`.
- Reduced-motion behavior: avoid motion dependency for state comprehension.

### 6. Content Rules

- Label/content guidelines: verbs first (`Save`, `Delete`, `Apply`).
- Error/help messaging rules: destructive labels must be explicit.
- Localization notes: avoid fixed-width assumptions for translated labels.

### 7. Anti-Patterns

- Anti-pattern 1: icon-only button without `aria-label`
- Anti-pattern 2: color-only differentiation between destructive and neutral actions
- Anti-pattern 3: placing two competing primary actions in one action row
- Anti-pattern 4: recreating button semantics from raw utilities or shell-local classes when the canonical action contract should be used


## Related

- [UI UX Component Taxonomy And Coverage Matrix](../components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [UI UX Tier 1 UI Reference Implementation Checklist](../../../09-reference/ui/UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
