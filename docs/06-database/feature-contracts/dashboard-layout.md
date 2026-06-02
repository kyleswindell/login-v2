# Dashboard Layout Data Contract

This document defines the canonical scope and intent for Dashboard Layout Data Contract.

## Table

- `user_dashboard_layouts`

## Stored Fields

- `id`
- `user_id` (unique)
- `layout` (JSON array of `{widget_key, position, column_span, row_span, is_visible}`)
- `is_locked`

## Contract Notes

- `widget_key` is the stable saved identity for each dashboard widget
- `position` is the persisted user-specific render order for the visible or hidden widget list
- `column_span` and `row_span` are validated placement metadata, not ad hoc page-local slot names
- `is_visible` records whether the widget is currently rendered for that signed-in user's saved layout
- saved layout rows are reconciled against the current widget registry so unknown widgets, invalid spans, and new defaults are normalized safely on load
- `created_at`
- `updated_at`

## Related

- [Dashboard](../../04-features/dashboard/dashboard.md)
