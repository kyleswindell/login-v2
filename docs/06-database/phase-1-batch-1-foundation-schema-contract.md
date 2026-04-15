# Phase 1 Batch 1 Foundation Schema Contract

This document defines the canonical scope and intent for Phase 1 Batch 1 Foundation Schema Contract.

## Purpose

Canonical schema extraction for Phase 1 Batch 1 shared-core foundation.

## Core Table Families

- RBAC tables: `roles`, `permissions`, `model_has_roles`, `role_has_permissions`
- settings tables: `settings`
- notification tables: `notifications`

## Supporting Tables (pre-existing)

- `password_reset_tokens`
- `platform_audit_logs`
- `central_error_logs`
- Laravel support tables already migrated in baseline setup

## Optional User Lifecycle Columns (decision reference)

Candidate user lifecycle columns reviewed in this phase:

- `is_active`
- `last_login_at`
- `invited_at`

## Related

- [Auth And RBAC Data Contract](feature-contracts/auth-and-rbac.md)
- [Notifications And Settings Data Contract](feature-contracts/notifications-and-settings.md)
- [Phase 1 - Implementation Batch 1](../07-planning/phases/phase-1/Phase%201%20-%20Implementation%20Batch%201.md)
