# Tier 1 - Toast And Inline Alert Contract

This document defines the canonical scope and intent for Tier 1 - Toast And Inline Alert Contract.

## Component Contract

### 1. Component Identity

- Component name: Toast Notification and Inline Alert
- Taxonomy path (L1/L2): Feedback And Status / Notifications
- Owner: Platform UI baseline owner

### 2. Intent And Theory

- Primary use case: immediate feedback for system/user actions.
- When to use: save confirmations, warnings, failures, policy notices.
- When not to use: persistent long-form instructional content.
- Interaction intent summary: fast feedback with semantic severity and predictable dismissal model.

### 2A. Implementation Form Decision

- Current implementation form: `Class/markup contract`
- Intended long-term direction: `promote to Blade component`
- Canonical consumption direction:
  - callers should declare feedback role first: toast or inline alert
  - callers should then declare descriptors such as semantic severity, dismissibility, title/summary, and supporting message
  - the long-term canonical entry point should be a Blade API that normalizes role, semantics, and accessibility defaults
- Transitional rule:
  - the existing class/markup contract remains valid until the Blade entry point exists
  - downstream work must not create shell-local feedback wrappers that duplicate toast or inline-alert behavior outside the canonical contract

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): semantic severity tokens shared with actions/status.
- Light theme behavior: preserve border/text contrast.
- Dark theme behavior: maintain readable contrast over darker surfaces.
- Density/size variants: inline full-width blocks and compact stacked toast cards.
- Allowed variants: `base` only.
- Allowed semantic subset:
  - Toast: `neutral`, `success`, `warning`, `danger`, `info`, `notice`
  - Inline Alert: `neutral`, `success`, `warning`, `danger`, `info`, `notice`

### 4. Behavior Rules

- Default behavior: feedback appears near action context.
- Minimal motion behavior: toast entry and dismiss may use a short baseline fade/slide transition when motion is allowed.
- Hover/focus/active behavior: dismiss controls remain visible and focusable.
- Disabled/loading behavior: not applicable.
- Error/warning/success behavior (if applicable): use only the allowed semantic subset defined above.
- Responsive behavior (desktop/tablet/mobile): toast stack aligns and does not block primary controls.

### 5. Accessibility Requirements

- Semantic structure required: `role="status"` for neutral updates, `role="alert"` for urgent failures.
- Keyboard interactions: dismiss button keyboard-triggerable.
- Focus-visible rules: visible focus on dismiss controls.
- Contrast requirements: WCAG 2.2 AA baseline.
- Screen reader behavior: live regions set to polite/assertive by severity.
- Reduced-motion behavior: baseline toast entry/exit motion must be minimal and disabled when reduced motion is requested.

### 6. Content Rules

- Label/content guidelines: short summary + one sentence detail.
- Error/help messaging rules: include actionable next step where possible.
- Localization notes: avoid cramped one-line assumptions.

### 7. Anti-Patterns

- Anti-pattern 1: toast with no severity distinction
- Anti-pattern 2: auto-dismiss critical error before user acknowledgement
- Anti-pattern 3: inline alert copy without clear action guidance
- Anti-pattern 4: inventing page-local feedback shells when the canonical toast/inline-alert contract already fits


## Related

- [UI UX Component Taxonomy And Coverage Matrix](../components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [UI UX Tier 1 UI Reference Implementation Checklist](../../../09-reference/ui/UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
