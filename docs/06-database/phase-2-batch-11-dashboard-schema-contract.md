# Phase 2 Batch 11 Dashboard Schema Contract

This document defines the canonical scope and intent for Phase 2 Batch 11 Dashboard Schema Contract.

## Purpose

Canonical schema extraction for Phase 2 Batch 11 dashboard persistence.

## Table Contract

`user_dashboard_layouts`

| Column | Type | Notes |
|---|---|---|
| `id` | bigint, PK | |
| `user_id` | bigint, FK -> `users.id` | one layout row per user |
| `layout` | json | array payload with widget configuration |
| `is_locked` | boolean | lock state for edit/reorder mode |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |

## Constraints

- unique constraint on `user_id`
- foreign key from `user_id` to `users.id`

## Related

- [Dashboard Layout Data Contract](feature-contracts/dashboard-layout.md)
- [Phase 2 - Implementation Batch 11](../07-planning/phases/phase-2/Phase%202%20-%20Implementation%20Batch%2011.md)
