# Tier 1 - Drawer And Modal Contract

## Component Contract

### 1. Component Identity

- Component name: Drawer and Modal
- Taxonomy path (L1/L2): Overlays And Progressive Disclosure / Overlay containers
- Owner: Platform UI baseline owner
- Status (`Draft`/`Proposed`/`Locked`): Proposed (`Ready For Review` in matrix)

### 2. Intent And Theory

- Primary use case: Context-preserving detail (drawer) and blocking confirmation (modal).
- When to use: log detail inspection, destructive confirmation, concise focused tasks.
- When not to use: large multi-step flows requiring full page context.
- Interaction intent summary: preserve task continuity while preventing accidental destructive actions.

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): elevated containers with consistent header/action regions.
- Light theme behavior: visible border and separation from backdrop.
- Dark theme behavior: high-contrast surface over dimmed backdrop.
- Density/size variants: right-side drawer and centered modal baseline.

### 4. Behavior Rules

- Default behavior: open by explicit trigger, close by close action.
- Hover/focus/active behavior: close/confirm controls maintain visible focus.
- Disabled/loading behavior: submit action can enter loading state.
- Error/warning/success behavior (if applicable): destructive modal uses danger semantics.
- Responsive behavior (desktop/tablet/mobile): drawer and modal remain readable within viewport.

### 5. Accessibility Requirements

- Semantic structure required: `role="dialog"`, `aria-modal="true"`, labeled title.
- Keyboard interactions: Escape close; tab cycles through interactive content.
- Focus-visible rules: visible focus for close and primary action controls.
- Contrast requirements: WCAG 2.2 AA baseline.
- Screen reader behavior: title and context announced on open.
- Reduced-motion behavior: transitions are optional and non-essential.

### 6. Content Rules

- Label/content guidelines: clear action verbs and explicit destructive language.
- Error/help messaging rules: include consequence summary for destructive actions.
- Localization notes: support longer titles and descriptions.

### 7. Implementation Artifacts

- UI reference example path: `/platform/ui-reference/patterns/overlays` and `/platform/ui-reference/patterns/tables`
- Production component/view paths: table log drawer templates and any destructive confirm modal templates
- JS behavior path (if any): `resources/js/app.js`
- Token/CSS path (if any): `resources/css/app.css`

### 8. Validation Checklist

- [x] meets WCAG 2.2 AA baseline
- [x] light/dark parity verified
- [x] responsive behavior verified
- [x] all required states implemented
- [x] keyboard and focus behavior verified
- [x] documentation updated in canonical notes

### 9. Anti-Patterns

- Anti-pattern 1: modal without keyboard close path
- Anti-pattern 2: drawer with no focus target on open
- Anti-pattern 3: destructive action without explicit consequence language

### 10. Lock Record

- Lock date: pending
- Reviewers: pending
- Notes: move to `Locked` once focus trap and return-focus behavior is validated across production overlays.

## Related

- [[V2 App/Reference/UI UX System/UI UX Component Taxonomy And Coverage Matrix]] | [UI UX Component Taxonomy And Coverage Matrix](../UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [[V2 App/Reference/UI UX System/UI UX Tier 1 UI Reference Implementation Checklist]] | [UI UX Tier 1 UI Reference Implementation Checklist](../UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
