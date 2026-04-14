# Tier 1 - Inputs Textarea Select Contract

## Component Contract

### 1. Component Identity

- Component name: Text Input, Textarea, Select
- Taxonomy path (L1/L2): Inputs And Forms / Inputs
- Owner: Platform UI baseline owner
- Status (`Draft`/`Proposed`/`Locked`): Proposed (`Ready For Review` in matrix)

### 2. Intent And Theory

- Primary use case: Capture structured and freeform data reliably.
- When to use: Configuration forms, settings forms, filtering forms.
- When not to use: One-click binary actions (use toggles/checkbox/radio when locked).
- Interaction intent summary: predictable field behavior with clear validation and assistive context.

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): shared form field container token with clear label/helper/error hierarchy.
- Light theme behavior: retain border and label contrast.
- Dark theme behavior: preserve field/background distinction.
- Density/size variants: standard default density for Tier 1.

### 4. Behavior Rules

- Default behavior: editable field with helper text support.
- Hover/focus/active behavior: visible focus border/ring.
- Disabled/loading behavior: disabled fields non-interactive but readable.
- Error/warning/success behavior (if applicable): inline field error + optional summary block.
- Responsive behavior (desktop/tablet/mobile): one and two-column layouts collapse without clipping.

### 5. Accessibility Requirements

- Semantic structure required: associated `label` and field IDs.
- Keyboard interactions: standard tab/shift-tab and native control keyboard support.
- Focus-visible rules: strong visible focus for all fields.
- Contrast requirements: WCAG 2.2 AA baseline.
- Screen reader behavior: errors linked via `aria-describedby`; invalid state via `aria-invalid`.
- Reduced-motion behavior: no required motion.

### 6. Content Rules

- Label/content guidelines: clear nouns for fields, concise helper text.
- Error/help messaging rules: describe what failed and how to fix.
- Localization notes: support longer translated labels and helper text.

### 7. Implementation Artifacts

- UI reference example path: `/platform/ui-reference/components/forms`
- Production component/view paths: settings/setup forms under `resources/views/platform/`
- JS behavior path (if any): optional client-side enhancements in `resources/js/app.js`
- Token/CSS path (if any): `resources/css/app.css`

### 8. Validation Checklist

- [x] meets WCAG 2.2 AA baseline
- [x] light/dark parity verified
- [x] responsive behavior verified
- [x] all required states implemented
- [x] keyboard and focus behavior verified
- [x] documentation updated in canonical notes

### 9. Anti-Patterns

- Anti-pattern 1: missing visible labels
- Anti-pattern 2: errors shown without field association
- Anti-pattern 3: disabled fields with unreadable contrast

### 10. Lock Record

- Lock date: pending
- Reviewers: pending
- Notes: move to `Locked` after shared form error pattern is approved across settings pages.

## Related

- [[V2 App/Reference/UI UX System/UI UX Component Taxonomy And Coverage Matrix]] | [UI UX Component Taxonomy And Coverage Matrix](../UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [[V2 App/Reference/UI UX System/UI UX Tier 1 UI Reference Implementation Checklist]] | [UI UX Tier 1 UI Reference Implementation Checklist](../UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
