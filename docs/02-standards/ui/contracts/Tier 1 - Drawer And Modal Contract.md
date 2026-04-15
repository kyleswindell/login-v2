# Tier 1 - Drawer And Modal Contract

This document defines the canonical scope and intent for Tier 1 - Drawer And Modal Contract.

## Component Contract

### 1. Component Identity

- Component name: Drawer and Modal
- Taxonomy path (L1/L2): Overlays And Progressive Disclosure / Overlay containers
- Owner: Platform UI baseline owner

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

### 7. Anti-Patterns

- Anti-pattern 1: modal without keyboard close path
- Anti-pattern 2: drawer with no focus target on open
- Anti-pattern 3: destructive action without explicit consequence language


## Related

- [UI UX Component Taxonomy And Coverage Matrix](../components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [UI UX Tier 1 UI Reference Implementation Checklist](../../../09-reference/ui/UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
