# notifications

This document defines the canonical scope and intent for notifications.

## Ownership

- central platform database baseline

## Key Columns

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

## Constraints And Notes

- severity and module keys follow canonical feature contracts
- read/dismiss states are stored per notification row

## Related

- [Notifications And Settings Contract](../feature-contracts/notifications-and-settings.md)
