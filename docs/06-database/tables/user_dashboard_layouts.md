# user_dashboard_layouts

This document defines the canonical scope and intent for user_dashboard_layouts.

## Ownership

- central platform database

## Purpose

Persist each authenticated user's dashboard widget layout and lock state for the app-owned dashboard workspace.

## Columns

- `id`
- `user_id`
- `layout`
- `is_locked`
- `created_at`
- `updated_at`

## Constraints And Notes

- `user_id` is unique so each user has at most one saved dashboard layout row
- `user_id` references `users.id` and cascades on delete
- `layout` stores the ordered widget slot payload used by `DashboardPage`
- `is_locked` defaults to `true`

## Related

- [Dashboard Layout Data Contract](../feature-contracts/dashboard-layout.md)
- [Dashboard](../../04-features/dashboard/dashboard.md)
- [Dashboard Subsystem](../../03-architecture/subsystems/dashboard.md)
