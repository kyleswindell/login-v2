# notification_registry_entries

This document defines the canonical scope and intent for notification_registry_entries.

## Table Scope

Stores the synced DB projection of module-declared notification type metadata.

## Columns

- `id`
- `key`
- `module_key`
- `label`
- `description`
- `category`
- `default_severity`
- `audience`
- `action_route`
- `database_enabled`
- `email_eligible`
- `digest_eligible`
- `grouping_key`
- `dedupe_window_seconds`
- `is_active`
- `is_stale`
- `source_hash`
- `synced_at`
- `created_at`
- `updated_at`

## Data Constraints

- `key` is unique
- stale rows are preserved when notification type declarations are removed
- `notifications.type_key` may reference a registry-backed type key but remains nullable for direct delivery tooling

## Related

- [Module Contribution Registries](../feature-contracts/module-contribution-registries.md)
- [notifications](notifications.md)
