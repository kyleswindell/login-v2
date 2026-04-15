# Tier 1 - Table Baseline Contract

This document defines the canonical scope and intent for Tier 1 - Table Baseline Contract.

## Component Contract

### 1. Component Identity

- Component name: Data Table Baseline (general + logs)
- Taxonomy path (L1/L2): Data Display / Data grids
- Owner: Platform UI baseline owner

### 2. Intent And Theory

- Primary use case: Dense data review with structured filters and deterministic paging.
- When to use: Operational lists, audit/error logs, workspace configuration indexes.
- When not to use: Small one-off lists where cards are more readable.
- Interaction intent summary: predictable scan, filter, and navigate loops.

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): bordered table container, compact header row, semantic status tokens.
- Light theme behavior: clear row separators and actionable control visibility.
- Dark theme behavior: maintain legible row and header contrast.
- Density/size variants: Tier 1 uses standard density and rows-per-page options 10/25/50/100.

### 4. Behavior Rules

- Default behavior: tabular rendering with deterministic column headers.
- Hover/focus/active behavior: row hover highlight and explicit action button focus.
- Disabled/loading behavior: pagination controls can render disabled state.
- Error/warning/success behavior (if applicable): empty and no-match states included.
- Responsive behavior (desktop/tablet/mobile): horizontal overflow wrapper on narrow widths.

### 5. Accessibility Requirements

- Semantic structure required: native table semantics with `thead`/`tbody`.
- Keyboard interactions: focusable controls for filtering/paging/actions.
- Focus-visible rules: all paging/filter controls show visible focus.
- Contrast requirements: WCAG 2.2 AA baseline.
- Screen reader behavior: column headers and action labels remain explicit.
- Reduced-motion behavior: no motion dependency.

### 6. Content Rules

- Label/content guidelines: concise headers and predictable CTA labels.
- Error/help messaging rules: empty state copy should explain next action.
- Localization notes: allow for longer localized headers.

### 7. Anti-Patterns

- Anti-pattern 1: hidden filter state with no reset path
- Anti-pattern 2: pagination without rows-per-page control
- Anti-pattern 3: non-semantic div-based table replacement for primary data grids


## Related

- [UI UX Component Taxonomy And Coverage Matrix](../components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [UI UX Tier 1 UI Reference Implementation Checklist](../../../09-reference/ui/UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
