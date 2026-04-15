# Notifications And Settings Data Contract

This document defines the canonical scope and intent for Notifications And Settings Data Contract.

## Tables

- `settings`
- `notifications`

## Key Settings Fields

- `scope_type`
- `scope_id`
- `module_key`
- `group_key`
- `key`
- `value_jsonb`
- `data_type`
- `updated_by`

## Key Notification Fields

- `uuid`
- `notifiable_type`
- `notifiable_id`
- `module_key`
- `severity`
- `title`
- `body`
- `action_url`
- `read_at`
- `dismissed_at`
- `delivery_channels`
- `metadata`

## Migration Ownership

- `2026_04_09_000003_create_settings_table.php` owns settings persistence.
- `2026_04_09_000004_create_notifications_table.php` owns notifications persistence.

## Related

- [Platform Notifications And Settings](../../04-features/notifications/platform-notifications-and-settings.md)
