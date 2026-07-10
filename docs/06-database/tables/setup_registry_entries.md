# setup_registry_entries

This document defines the canonical scope and intent for setup_registry_entries.

## Table Scope

Stores the synced DB projection of module-declared Setup screens.

## Columns

- `id`
- `key`
- `module_key`
- `label`
- `description`
- `route_name`
- `view_path`
- `icon`
- `access_mode`
- `access_value`
- `active_route_patterns_json`
- `sort_order`
- `tenant_eligible`
- `is_required`
- `is_blocking`
- `completion_key`
- `is_active`
- `is_stale`
- `source_hash`
- `synced_at`
- `created_at`
- `updated_at`

## Data Constraints

- `key` is unique
- setup completion records are not stored in this table
- registry rows do not define executable routes or views

## Related

- [Module Contribution Registries](../feature-contracts/module-contribution-registries.md)
