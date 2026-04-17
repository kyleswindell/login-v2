# UI UX Component Taxonomy Standards

This document defines the canonical scope and intent for UI UX Component Taxonomy Standards.

## Purpose

Define canonical component taxonomy, naming conventions, and priority tiers for Login App 2.0 UI standards.

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

Tier 3 in this taxonomy is the UI-facing subset of the broader architecture-owned Feature Module layer.

This taxonomy names Tier 3 UI surfaces and pattern classes only. Canonical Tier 3 implementation structure, ownership, and composition rules are owned by the architecture checklist.

- chat/timeline surfaces
- advanced data visual shells
- specialized module-only interaction patterns

## Related

- [UI UX Component Library Standards](UI%20UX%20Component%20Library%20Standards.md)
- [Feature Modules Alignment Checklist](../../../03-architecture/feature-modules-alignment-checklist.md)
- [UI UX Component Acceptance Contract Template](../contracts/UI%20UX%20Component%20Acceptance%20Contract%20Template.md)
- [UI UX Component Coverage Matrix](../../../09-reference/ui/UI%20UX%20Component%20Coverage%20Matrix.md)
