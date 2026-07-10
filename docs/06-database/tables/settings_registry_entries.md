# settings_registry_entries

This document defines the canonical scope and intent for settings_registry_entries.

## Table Scope

Stores the synced DB projection of module-declared Settings pages.

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
- `is_active`
- `is_stale`
- `source_hash`
- `synced_at`
- `created_at`
- `updated_at`

## Data Constraints

- `key` is unique
- registry rows do not define executable routes or views
- settings values remain stored in `settings`

## Related

- [Module Contribution Registries](../feature-contracts/module-contribution-registries.md)
- [settings](settings.md)
