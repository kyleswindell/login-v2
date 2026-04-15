# settings

This document defines the canonical scope and intent for settings.

## Table Scope

Store scoped settings values by ownership context.

## Columns

- `id`
- `scope_type`
- `scope_id`
- `module_key`
- `group_key`
- `key`
- `value_jsonb`
- `data_type`
- `is_encrypted`
- `is_public`
- `updated_by`
- `created_at`
- `updated_at`

## Data Constraints

- uniqueness by `(scope_type, scope_id, module_key, group_key, key)`
- `value_jsonb` payload compatible with `data_type`

## Related

- [Notifications And Settings Contract](../feature-contracts/notifications-and-settings.md)
- [Settings Data Governance Standards](../../02-standards/database/Settings%20Data%20Governance%20Standards.md)
