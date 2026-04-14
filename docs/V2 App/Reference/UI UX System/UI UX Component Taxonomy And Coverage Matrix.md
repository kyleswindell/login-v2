# UI UX Component Taxonomy And Coverage Matrix

## Purpose

Define the canonical component taxonomy, naming conventions, implementation priority tiers, and current coverage matrix for Login V2.

## Implementation Status

Current status:

- taxonomy and naming rules created
- priority tiers defined
- baseline coverage matrix initialized
- Tier 1 acceptance contracts are now filled for first-pass review
- Tier 1 UI reference implementation checklist is now defined
- Tier 1 matrix rows are advanced to `Ready For Review` where implementation coverage exists

## Taxonomy Structure

Use `L1 / L2 / Component` classification.

### L1 Shell And Navigation

- L2 Global shell: app header, app sidebar, mobile nav dock, account menu
- L2 Navigation controls: breadcrumbs, tabs, step nav, pagination nav
- L2 Menus: dropdown menu, context menu, nested menu

### L1 Inputs And Forms

- L2 Inputs: text input, textarea, select, checkbox, radio, toggle
- L2 Form scaffolding: label, helper text, error text, fieldset, form section
- L2 Form actions: submit row, destructive confirm row

### L1 Data Display

- L2 Data grids: table, sortable header, filter row, rows-per-page, empty table state
- L2 Indicators: badge, tag, status pill, progress indicator
- L2 Content blocks: card, metric card, list item

### L1 Feedback And Status

- L2 Notifications: toast, inline alert, banner
- L2 Loading: spinner, skeleton, loading row/button state
- L2 Validation feedback: field error, form summary, success confirmation

### L1 Overlays And Progressive Disclosure

- L2 Overlay containers: drawer, side panel, modal
- L2 Confirmation: confirm modal, danger confirm pattern
- L2 Detail surfaces: log drawer, preview panel

### L1 Messaging And Timeline

- L2 Conversation: chat bubble, chat header/footer, composer
- L2 Timeline: activity row, event metadata row

## Naming Conventions

1. Prefix UI primitives with `ui-`.
2. Keep semantic names over visual names (for example `ui-status-success`, not `ui-green-pill`).
3. Prefer role tokens over hard-coded variants (`--color-action-primary`, not direct hex in component markup).
4. Use `is-*` state utility classes only for transient JS state hooks when needed.

## Priority Tiers

### Tier 1 (Implement first)

- buttons and icon buttons
- badges/status pills
- form core inputs and validation blocks
- table baseline (sort/filter/pagination/empty)
- toast and inline alerts
- drawer/modal baseline
- shell navigation baseline (sidebar/mobile dock/account menu)

### Tier 2

- tabs and breadcrumbs
- advanced filter patterns
- cards/metric panels refinements
- loading skeleton variants
- empty-state pattern library

### Tier 3

- chat/timeline surfaces
- advanced data visual shells
- specialized module-only interaction patterns

## Coverage Matrix

Status values:

- `Not Started`
- `In Progress`
- `Ready For Review`
- `Locked`

| Component | L1 | Required States | A11y Checks | UI Reference | Production | Priority |
|---|---|---|---|---|---|---|
| Button | Inputs And Forms | default, hover, focus, active, disabled, loading | contrast, focus-visible, keyboard trigger | Ready For Review | In Progress | Tier 1 |
| Icon Button | Inputs And Forms | default, hover, focus, active, disabled | aria-label, focus-visible, touch target | Ready For Review | In Progress | Tier 1 |
| Badge / Status Pill | Data Display | default, subtle, outline, disabled | contrast and semantic meaning | Locked | In Progress | Tier 1 |
| Text Input | Inputs And Forms | default, focus, error, disabled, readonly | label association, error announcement | Ready For Review | In Progress | Tier 1 |
| Textarea | Inputs And Forms | default, focus, error, disabled | label association, resize behavior | Ready For Review | In Progress | Tier 1 |
| Select | Inputs And Forms | default, focus, error, disabled | label association, keyboard nav | Ready For Review | In Progress | Tier 1 |
| Checkbox | Inputs And Forms | default, focus, checked, disabled, error | label target, keyboard toggle | Not Started | In Progress | Tier 1 |
| Radio | Inputs And Forms | default, focus, selected, disabled, error | group semantics, keyboard nav | Not Started | In Progress | Tier 1 |
| Toggle | Inputs And Forms | default, focus, on, off, disabled | role/state announcement | Not Started | In Progress | Tier 1 |
| Form Validation Block | Inputs And Forms | default, error summary, success | error linking and reading order | Not Started | In Progress | Tier 1 |
| Data Table | Data Display | default, sorting, filtering, empty, loading | table semantics, header associations | Ready For Review | In Progress | Tier 1 |
| Pagination Controls | Shell And Navigation | default, hover, focus, disabled | keyboard and screen reader labels | Ready For Review | In Progress | Tier 1 |
| Drawer | Overlays | open, close, loading, error | focus trap, escape, return focus | Ready For Review | In Progress | Tier 1 |
| Modal | Overlays | open, close, confirm, danger | focus trap, escape, aria modal | Ready For Review | In Progress | Tier 1 |
| Toast Notification | Feedback And Status | info, success, warning, danger, dismiss | live-region behavior, timing | Ready For Review | In Progress | Tier 1 |
| Inline Alert | Feedback And Status | info, success, warning, danger | role and reading order | Ready For Review | In Progress | Tier 1 |
| Sidebar / Mobile Dock | Shell And Navigation | expanded, collapsed, active route | keyboard nav, focus order | Ready For Review | In Progress | Tier 1 |
| Account Dropdown | Shell And Navigation | closed, open, active item | focus and escape handling | Ready For Review | In Progress | Tier 1 |
| Tabs | Shell And Navigation | default, active, focus, disabled | role=tablist keyboard nav | Not Started | Not Started | Tier 2 |
| Breadcrumbs | Shell And Navigation | default, active crumb | aria-current semantics | Not Started | Not Started | Tier 2 |
| Empty State | Feedback And Status | default, action-focused variant | decorative media accessibility | Not Started | In Progress | Tier 2 |
| Loading Skeleton | Feedback And Status | default, reduced motion | reduced motion compliance | Not Started | Not Started | Tier 2 |
| Chat Bubble | Messaging And Timeline | incoming, outgoing, meta, attachment | reading order, labels | Not Started | Not Started | Tier 3 |
| Timeline Row | Messaging And Timeline | default, expanded, contextual actions | semantic event ordering | Not Started | Not Started | Tier 3 |

## Required Update Workflow

For each component update:

1. update this matrix row status
2. update `/platform/ui-reference` example coverage
3. update canonical behavior note if contracts changed
4. record lock state in decision log

## Related

- [[V2 App/Reference/UI UX System/UI UX Component Library Standards]] | [UI UX Component Library Standards](UI%20UX%20Component%20Library%20Standards.md)
- [[V2 App/Reference/UI UX System/UI UX Component Acceptance Contract Template]] | [UI UX Component Acceptance Contract Template](UI%20UX%20Component%20Acceptance%20Contract%20Template.md)
- [[V2 App/Reference/UI UX System/UI UX Source Of Truth And Decision Log]] | [UI UX Source Of Truth And Decision Log](UI%20UX%20Source%20Of%20Truth%20And%20Decision%20Log.md)
