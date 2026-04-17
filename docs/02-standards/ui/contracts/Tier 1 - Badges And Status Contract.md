# Tier 1 - Badges And Status Contract

This document defines the canonical scope and intent for Tier 1 - Badges And Status Contract.

## Component Contract

### 1. Component Identity

- Component name: Badge and Status Pill
- Taxonomy path (L1/L2): Data Display / Indicators
- Owner: Platform UI baseline owner

### 2. Intent And Theory

- Primary use case: Represent state/severity in dense surfaces (tables, cards, list rows).
- When to use: Operational health, workflow state, risk level, review state.
- When not to use: Primary CTA or standalone action controls.
- Interaction intent summary: quick recognition without relying solely on color.

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): semantic fills/outlines with uppercase compact labels and rounded pill shape.
- Light theme behavior: maintain readable text and border contrast.
- Dark theme behavior: keep subtle background tint with clear text contrast.
- Density/size variants: standard compact pill.
- Allowed variants: `base`, `outline`.
- Allowed semantic subset: `neutral`, `success`, `warning`, `danger`, `info`, `notice`.

### 4. Behavior Rules

- Default behavior: passive indicator with no click behavior.
- Hover/focus/active behavior: no interactive behavior in Tier 1 passive badge/status usage.
- Disabled/loading behavior: muted token and lower emphasis.
- Error/warning/success behavior (if applicable): must map to shared semantic colors.
- Responsive behavior (desktop/tablet/mobile): wraps cleanly in row/action groups while each pill remains one-line.

### 5. Accessibility Requirements

- Semantic structure required: text content must be explicit.
- Keyboard interactions: none for Tier 1 passive usage.
- Focus-visible rules: not applicable for Tier 1 passive usage.
- Contrast requirements: WCAG 2.2 AA baseline.
- Screen reader behavior: meaning conveyed in text label, not color.
- Reduced-motion behavior: no motion required.

### 6. Content Rules

- Label/content guidelines: use short, domain-specific terms (`active`, `blocked`, `review`).
- Error/help messaging rules: avoid ambiguous terms.
- Localization notes: keep labels concise for tight table cells.

### 7. Anti-Patterns

- Anti-pattern 1: using only color with no text label
- Anti-pattern 2: overloading one color token with multiple unrelated meanings
- Anti-pattern 3: excessively long status labels that break table rhythm

## Tier Boundary Note

Interactive chips and other clickable filter-token patterns are outside Tier 1 passive badge/status scope unless a later contract explicitly introduces them.


## Related

- [UI UX Component Taxonomy And Coverage Matrix](../components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [UI UX Tier 1 UI Reference Implementation Checklist](../../../09-reference/ui/UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
