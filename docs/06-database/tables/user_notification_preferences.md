# user_notification_preferences

This document defines the canonical scope and intent for `user_notification_preferences`.

## Table Scope

Store personal notification delivery preferences for the current user account.

## Columns

- `id`
- `user_id`
- `email_enabled`
- `digest_frequency`
- `created_at`
- `updated_at`

## Data Constraints

- `user_id` references `users.id`, is unique, and cascades on delete.
- `email_enabled` defaults to `false`.
- `digest_frequency` defaults to `never`.

## Related

- [Notifications And Settings Data Contract](../feature-contracts/notifications-and-settings.md)
