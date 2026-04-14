# Tier 1 - Badges And Status Contract

## Component Contract

### 1. Component Identity

- Component name: Badge and Status Pill
- Taxonomy path (L1/L2): Data Display / Indicators
- Owner: Platform UI baseline owner
- Status (`Draft`/`Proposed`/`Locked`): Proposed (`Ready For Review` in matrix)

### 2. Intent And Theory

- Primary use case: Represent state/severity in dense surfaces (tables, cards, list rows).
- When to use: Operational health, workflow state, risk level, review state.
- When not to use: Primary CTA or standalone action controls.
- Interaction intent summary: quick recognition without relying solely on color.

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): semantic fills/outlines with uppercase compact labels and rounded pill shape.
- Light theme behavior: maintain readable text and border contrast.
- Dark theme behavior: keep subtle background tint with clear text contrast.
- Density/size variants: standard compact pill; optional outline variant.

### 4. Behavior Rules

- Default behavior: passive indicator with no click behavior.
- Hover/focus/active behavior: only interactive when explicitly implemented as filter chip.
- Disabled/loading behavior: muted token and lower emphasis.
- Error/warning/success behavior (if applicable): must map to shared semantic colors.
- Responsive behavior (desktop/tablet/mobile): wraps cleanly in row/action groups.

### 5. Accessibility Requirements

- Semantic structure required: text content must be explicit.
- Keyboard interactions: none unless interactive chip variant is used.
- Focus-visible rules: required only for interactive chip variant.
- Contrast requirements: WCAG 2.2 AA baseline.
- Screen reader behavior: meaning conveyed in text label, not color.
- Reduced-motion behavior: no motion required.

### 6. Content Rules

- Label/content guidelines: use short, domain-specific terms (`active`, `blocked`, `review`).
- Error/help messaging rules: avoid ambiguous terms.
- Localization notes: keep labels concise for tight table cells.

### 7. Implementation Artifacts

- UI reference example path: `/platform/ui-reference/components/status`
- Production component/view paths: tables and cards across `resources/views/platform/*`
- JS behavior path (if any): none required for passive variant
- Token/CSS path (if any): `resources/css/app.css`

### 8. Validation Checklist

- [x] meets WCAG 2.2 AA baseline
- [x] light/dark parity verified
- [x] responsive behavior verified
- [x] all required states implemented
- [x] keyboard and focus behavior verified
- [x] documentation updated in canonical notes

### 9. Anti-Patterns

- Anti-pattern 1: using only color with no text label
- Anti-pattern 2: overloading one color token with multiple unrelated meanings
- Anti-pattern 3: excessively long status labels that break table rhythm

### 10. Lock Record

- Lock date: pending
- Reviewers: pending
- Notes: move to `Locked` after status semantics review in operations tables.

## Related

- [[V2 App/Reference/UI UX System/UI UX Component Taxonomy And Coverage Matrix]] | [UI UX Component Taxonomy And Coverage Matrix](../UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [[V2 App/Reference/UI UX System/UI UX Tier 1 UI Reference Implementation Checklist]] | [UI UX Tier 1 UI Reference Implementation Checklist](../UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
