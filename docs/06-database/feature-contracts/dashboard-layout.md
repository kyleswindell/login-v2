# Dashboard Layout Data Contract

This document defines the canonical scope and intent for Dashboard Layout Data Contract.

## Table

- `user_dashboard_layouts`

## Stored Fields

- `id`
- `user_id` (unique)
- `layout` (JSON array of `{widget_key, position, column_span, is_visible}`)
- `is_locked`
- `created_at`
- `updated_at`

## Related

- [Dashboard](../../04-features/dashboard/dashboard.md)
