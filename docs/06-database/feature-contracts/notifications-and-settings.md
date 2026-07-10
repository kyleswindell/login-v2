# Notifications And Settings Data Contract

This document defines the canonical scope and intent for Notifications And Settings Data Contract.

## Tables

- `settings`
- `notifications`
- `user_notification_preferences`
- `notification_registry_entries`
- `settings_registry_entries`

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
- `type_key`
- `severity`
- `title`
- `body`
- `action_url`
- `read_at`
- `dismissed_at`
- `delivery_channels`
- `metadata`

## User Notification Preference Fields

`user_notification_preferences` stores personal notification delivery preferences for the current user account.

- `user_id`
- `email_enabled`
- `digest_frequency`
- timestamps

## Persistence Rules

- Persistent in-app/database notification delivery is represented by rows in `notifications`.
- Registry-backed domain notifications store their module-owned notification type in `type_key`.
- Module-declared notification type metadata is synced into `notification_registry_entries`.
- Module-declared Settings pages are synced into `settings_registry_entries`.
- Direct delivery tooling may leave `type_key` null.
- Ephemeral session flashes, inline feedback, modal-result messages, and short toasts do not create `notifications` rows.
- User preferences do not suppress persistent notification rows, unread counts, header state, or inbox visibility.
- `email_enabled` and `digest_frequency` are stored preference values for future email/digest delivery only until an email/digest subsystem exists.

## Notification Settings Keys

Notifications uses the `settings` table under the `notifications` group for delivery defaults.

- `default_severity` provides the default notification severity when a persistent producer omits severity.
- `max_per_user` controls per-notifiable retention pruning after a persistent notification is created.
- Invalid or missing `default_severity` falls back to `info`.
- Invalid or missing `max_per_user` falls back to the runtime default limit.

## Migration Ownership

- `2026_04_09_000003_create_settings_table.php` owns settings persistence.
- `2026_04_09_000004_create_notifications_table.php` owns notifications persistence.
- `2026_07_07_000003_create_user_notification_preferences_table.php` owns personal notification preference persistence.
- `2026_07_08_000001_drop_in_app_enabled_from_user_notification_preferences_table.php` removes obsolete in-app persistence opt-out state.
- `2026_07_08_000002_add_type_key_to_notifications_table.php` adds nullable registry-backed notification type ownership.
- `2026_07_08_000003_create_module_contribution_registry_tables.php` adds module contribution registry projections.

## Related

- [Platform Notifications And Settings](../../04-features/notifications/platform-notifications-and-settings.md)
