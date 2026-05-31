# Tier 1 - Table Baseline Contract

This document defines the canonical scope and intent for Tier 1 - Table Baseline Contract.

## Component Contract

### 1. Component Identity

- Component name: Data Table Baseline (general + logs)
- Taxonomy path (L1/L2): Data Display / Data grids
- Owner: Platform UI baseline owner

### 2. Intent And Theory

- Primary use case: Baseline semantic table rendering for structured data with predictable scan behavior.
- When to use: Operational lists, audit/error logs, workspace configuration indexes that need a native table baseline.
- When not to use: richer filter, sort, bulk-action, or advanced-control experiences that have crossed into Tier 2 pattern territory.
- Interaction intent summary: preserve readable, semantic tabular structure as the primitive baseline; advanced data-grid orchestration belongs to a higher tier.

### 2A. Tier Boundary Decision

- Current implementation form: `Hybrid`
- Intended long-term direction: `revalidate Tier 1 boundary`
- Tier 1 table baseline includes:
  - semantic table container
  - header row and body row structure
  - row hover/readability treatment
  - empty state slot
  - horizontal overflow containment on narrow widths
- Tier 1 table baseline does not own:
  - advanced filter panel orchestration
  - rich sort control treatment as a reusable interaction pattern
  - bulk action workflows
  - enhanced pagination or data-grid control assemblies
- Those richer interaction layers should be treated as Tier 2 patterns, not assumed to be part of the primitive baseline.

### 3. Visual Rules

- Token usage (color, spacing, type, radius, elevation): bordered table container, compact header row, semantic status tokens.
- Light theme behavior: clear row separators and actionable control visibility.
- Dark theme behavior: maintain legible row and header contrast.
- Density/size variants: Tier 1 uses standard density and rows-per-page options 10/25/50/100.
- Allowed variants: not variant-bearing.

### 4. Behavior Rules

- Default behavior: tabular rendering with deterministic column headers.
- Hover/focus/active behavior: row hover highlight and explicit focus on nested controls.
- Disabled/loading behavior: any nested controls may render disabled state, but advanced control orchestration is outside the Tier 1 baseline.
- Error/warning/success behavior (if applicable): empty and no-match states may be rendered through a simple table-adjacent content slot.
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

- Anti-pattern 1: treating an enhanced filter/sort toolbar as if it were part of the primitive table contract
- Anti-pattern 2: non-semantic div-based table replacement for primary data grids
- Anti-pattern 3: assuming Tier 1 table baseline alone solves richer Tier 2 data-grid interaction needs


## Related

- [UI UX Component Taxonomy And Coverage Matrix](../components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [UI UX Tier 1 UI Reference Implementation Checklist](../../../09-reference/ui/UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
