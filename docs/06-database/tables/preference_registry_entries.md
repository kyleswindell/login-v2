# preference_registry_entries

This document defines the canonical scope and intent for preference_registry_entries.

## Table Scope

Stores the synced DB projection of module-declared account/user preference pages.

## Columns

- `id`
- `key`
- `module_key`
- `group_key`
- `group_label`
- `label`
- `description`
- `route_name`
- `view_path`
- `icon`
- `access_mode`
- `access_value`
- `active_route_patterns_json`
- `group_sort_order`
- `sort_order`
- `tenant_eligible`
- `storage_scope`
- `storage_table`
- `is_active`
- `is_stale`
- `source_hash`
- `synced_at`
- `created_at`
- `updated_at`

## Data Constraints

- `key` is unique
- registry rows do not define executable routes or views
- preference values remain in their owning user/account tables

## Related

- [Module Contribution Registries](../feature-contracts/module-contribution-registries.md)
