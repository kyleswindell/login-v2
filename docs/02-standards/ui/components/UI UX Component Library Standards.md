# UI UX Component Library Standards

This document defines the canonical scope and intent for UI UX Component Library Standards.

## Purpose

Define the component inventory, behavior contracts, and UX consistency rules for Login App 2.0.

This note references the canonical component inventory and contract landscape. Tier 1 semantic roles, state models, and explicit token mappings are owned by the foundations and color-token standards; per-component subsets and allowed variants are owned by the Tier 1 contracts.

## Component Categories

Core categories:

1. Shell and navigation
2. Inputs and forms
3. Data display
4. Feedback and status
5. Overlays and progressive disclosure
6. Content scaffolding (cards, sections, empty states)

## Component Behavior Standards

### Drawers, side panels, and modals

Selection rules:

1. Use drawers/side panels for contextual detail and editing while preserving page context.
2. Use modals for short, blocking decisions requiring immediate confirmation.
3. Use full page flows for high-complexity or high-impact tasks.

Required behavior:

- Escape closes dismissible overlays.
- Backdrop close behavior is explicit and documented.
- Focus trap returns focus to the invoking control.
- Body scroll lock is applied for modal overlays.

### Tables and data grids

Required behavior:

- stable sorting states
- explicit filter controls and reset path
- rows-per-page and pagination controls
- loading and empty states
- row-level and bulk actions defined per table

### Forms and validation

Required behavior:

- inline field validation
- submit-level summary for multi-error cases
- clear required/optional labeling
- disabled states and busy/loading states
- confirmation patterns for destructive edits

### Empty states

Required behavior:

- clear reason why no data is present
- primary next action
- optional secondary recovery action
- avoid dead-end copy

### Toasts and feedback timing

Required behavior:

- severity mapping to semantic tokens
- timeouts by severity and urgency
- manual dismiss for persistent/error states
- no stacked toast spam for repeated events

### Badges and status pills

Required behavior:

- semantic roles must resolve through shared status mappings
- status pills render single-line by default in standard table/card/filter contexts
- icon and label stay horizontally aligned
- text label is mandatory for semantic status (no icon-only semantic status)

## UX Consistency Rules

### Navigation hierarchy

- define primary, secondary, and contextual navigation layers
- users should always know current location and parent context
- mobile navigation interactions must match desktop intent

### Action placement

- primary action appears in a consistent location for each screen type
- secondary actions are grouped and visually lower emphasis
- destructive actions are separated from default action groups

### Destructive action patterns

- clear destructive label (not generic "Save")
- confirmation required for high-impact actions
- irrecoverable operations include explicit warning copy

### Feedback timing

- immediate visual acknowledgment on click/tap
- load states visible for operations longer than a brief threshold
- completion feedback via toast or inline state update

## Component Documentation Requirements

Every component standard must include:

1. base example
2. light and dark variant
3. disabled/hover/focus/active states
4. responsive example
5. accessibility notes

Documentation expectation:

- each component section includes:
1. theory/intent summary
2. behavior rules
3. concrete implementation example(s)
4. anti-patterns where relevant

Per-component contract resources:

- [UI UX Component Acceptance Contract Template](../contracts/UI%20UX%20Component%20Acceptance%20Contract%20Template.md)
- [Component Contracts Index](../contracts/Component%20Contracts%20Index.md)
- [UI UX Tier 1 UI Reference Implementation Checklist](../../../09-reference/ui/UI%20UX%20Tier%201%20UI%20Reference%20Implementation%20Checklist.md)
- [UI UX Status And Badge Production Rollout Checklist](../../../09-reference/ui/UI%20UX%20Status%20And%20Badge%20Production%20Rollout%20Checklist.md)

## Planning Source

- [Phase 2 - UI UX System Baseline Planning](../../../07-planning/phases/phase-2/Phase%202%20-%20UI%20UX%20System%20Baseline%20Planning.md)

## Related

- [UI UX Foundations And Theming Standards](../UI%20UX%20Foundations%20And%20Theming%20Standards.md)
- [UI UX Source Of Truth And Decision Log](../UI%20UX%20Source%20Of%20Truth%20And%20Decision%20Log.md)
- [Agent Sessions And Parallel Work](../../../10-runbooks/agent-sessions-and-parallel-work.md)
