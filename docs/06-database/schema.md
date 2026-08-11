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
- [module_registry_entries](tables/module_registry_entries.md)
- [notification_registry_entries](tables/notification_registry_entries.md)
- [settings_registry_entries](tables/settings_registry_entries.md)
- [setup_registry_entries](tables/setup_registry_entries.md)
- [preference_registry_entries](tables/preference_registry_entries.md)
- [user_contact_emails](tables/user_contact_emails.md)
- [user_notification_preferences](tables/user_notification_preferences.md)
- [user_dashboard_layouts](tables/user_dashboard_layouts.md)
- [users](tables/users.md)
- [user_invitations](tables/user_invitations.md)

## Feature Contracts

- [Auth And RBAC](feature-contracts/auth-and-rbac.md)
- [Event And Error Logging](feature-contracts/logging.md)
- [Notifications And Settings](feature-contracts/notifications-and-settings.md)
- [Module Contribution Registries](feature-contracts/module-contribution-registries.md)
- [Inter-Tenant Messaging](feature-contracts/inter-tenant-messaging.md)
- [Users Data Contract](feature-contracts/users.md)

## Related

- [Database Index](index.md)
