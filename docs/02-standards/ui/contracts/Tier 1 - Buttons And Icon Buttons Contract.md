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

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): semantic action tokens (`primary`, `success`, `warning`, `danger`, `notice`, `info`, `ghost`) with 4/6/8 radius system and medium weight labels.
- Light theme behavior: Preserve stronger contrast than pastel soft variants.
- Dark theme behavior: Maintain visible border and fill distinction for default, soft, and outline.
- Density/size variants: `xs`, `sm`, `md`, `lg`, `xl`.

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


## Related

- [UI UX Component Taxonomy And Coverage Matrix](../components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [UI UX Tier 1 UI Reference Implementation Checklist](../../../09-reference/ui/UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
