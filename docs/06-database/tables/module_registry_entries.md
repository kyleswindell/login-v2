# module_registry_entries

This document defines the canonical scope and intent for module_registry_entries.

## Table Scope

Stores the synced DB projection of module manifest identity and lifecycle metadata.

## Columns

- `id`
- `key`
- `name`
- `category`
- `default_state`
- `installed_by_default`
- `default_enabled`
- `disableable`
- `tenant_eligible`
- `dependencies_json`
- `is_active`
- `is_stale`
- `source_hash`
- `synced_at`
- `created_at`
- `updated_at`

## Data Constraints

- `key` is unique
- stale rows are preserved when manifest declarations are removed
- executable module behavior remains code-owned by module manifests

## Related

- [Module Contribution Registries](../feature-contracts/module-contribution-registries.md)
