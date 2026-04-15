# Schema

This document defines the canonical scope and intent for Schema.

## Purpose

Canonical schema and table ownership hub.

## Ownership Baseline

- current platform baseline tables live in the central platform database
- planned tenant runtime tables will live in tenant databases once tenancy runtime is implemented
- tenant and platform data remain isolated by design

## Table Docs

- [platform_audit_logs](tables/platform_audit_logs.md)
- [central_error_logs](tables/central_error_logs.md)
- [settings](tables/settings.md)
- [notifications](tables/notifications.md)
- [user_dashboard_layouts](tables/user_dashboard_layouts.md)

## Feature Contracts

- [Auth And RBAC](feature-contracts/auth-and-rbac.md)
- [Event And Error Logging](feature-contracts/logging.md)
- [Notifications And Settings](feature-contracts/notifications-and-settings.md)
- [Inter-Tenant Messaging](feature-contracts/inter-tenant-messaging.md)

## Related

- [Database Index](index.md)
