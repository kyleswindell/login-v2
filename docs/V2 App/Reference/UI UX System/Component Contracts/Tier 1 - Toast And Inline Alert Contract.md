# Tier 1 - Toast And Inline Alert Contract

## Component Contract

### 1. Component Identity

- Component name: Toast Notification and Inline Alert
- Taxonomy path (L1/L2): Feedback And Status / Notifications
- Owner: Platform UI baseline owner
- Status (`Draft`/`Proposed`/`Locked`): Proposed (`Ready For Review` in matrix)

### 2. Intent And Theory

- Primary use case: immediate feedback for system/user actions.
- When to use: save confirmations, warnings, failures, policy notices.
- When not to use: persistent long-form instructional content.
- Interaction intent summary: fast feedback with semantic severity and predictable dismissal model.

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): semantic severity tokens shared with actions/status.
- Light theme behavior: preserve border/text contrast.
- Dark theme behavior: maintain readable contrast over darker surfaces.
- Density/size variants: inline full-width blocks and compact stacked toast cards.

### 4. Behavior Rules

- Default behavior: feedback appears near action context.
- Hover/focus/active behavior: dismiss controls remain visible and focusable.
- Disabled/loading behavior: not applicable.
- Error/warning/success behavior (if applicable): info/success/warning/danger set.
- Responsive behavior (desktop/tablet/mobile): toast stack aligns and does not block primary controls.

### 5. Accessibility Requirements

- Semantic structure required: `role="status"` for neutral updates, `role="alert"` for urgent failures.
- Keyboard interactions: dismiss button keyboard-triggerable.
- Focus-visible rules: visible focus on dismiss controls.
- Contrast requirements: WCAG 2.2 AA baseline.
- Screen reader behavior: live regions set to polite/assertive by severity.
- Reduced-motion behavior: avoid reliance on animated entrance/exit.

### 6. Content Rules

- Label/content guidelines: short summary + one sentence detail.
- Error/help messaging rules: include actionable next step where possible.
- Localization notes: avoid cramped one-line assumptions.

### 7. Implementation Artifacts

- UI reference example path: `/platform/ui-reference/patterns/overlays`
- Production component/view paths: alert/notification presentation surfaces in platform views
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

- Anti-pattern 1: toast with no severity distinction
- Anti-pattern 2: auto-dismiss critical error before user acknowledgement
- Anti-pattern 3: inline alert copy without clear action guidance

### 10. Lock Record

- Lock date: pending
- Reviewers: pending
- Notes: move to `Locked` after timing/dismiss policy is confirmed against notification standards.

## Related

- [[V2 App/Reference/UI UX System/UI UX Component Taxonomy And Coverage Matrix]] | [UI UX Component Taxonomy And Coverage Matrix](../UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [[V2 App/Reference/UI UX System/UI UX Tier 1 UI Reference Implementation Checklist]] | [UI UX Tier 1 UI Reference Implementation Checklist](../UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
