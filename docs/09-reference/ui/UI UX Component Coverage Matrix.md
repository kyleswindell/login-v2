# UI UX Component Coverage Matrix

This document defines the canonical scope and intent for UI UX Component Coverage Matrix.

## Purpose

Track execution progress for UI component implementation and review status.

This is a support tracker only. Canonical taxonomy references live in `02-standards/ui/components/UI UX Component Taxonomy And Coverage Matrix.md`.

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

## Update Workflow

For each component update:

1. update this matrix row status
2. update `/platform/ui-reference` example coverage
3. update canonical behavior note if contracts changed
4. record lock state in execution tracker notes

## Related

- [UI UX Component Taxonomy Standards](../../02-standards/ui/components/UI%20UX%20Component%20Taxonomy%20And%20Coverage%20Matrix.md)
- [Component Contracts Index](../../02-standards/ui/contracts/Component%20Contracts%20Index.md)
