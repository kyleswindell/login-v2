# Calendar Data Contract

This document defines the canonical scope and intent for Calendar Data Contract.

## Tables

- `calendar_entries`
- `calendar_entry_types`

## `calendar_entries` Fields

- `title`
- `source_type`
- `source_id`
- `status` (`active`, `draft`, `cancelled`)
- `start_at`
- `end_at`
- `all_day`
- `owner_user_id`
- `tenant_id`
- `metadata`
- timestamps

## `calendar_entry_types` Fields

- `key`
- `label`
- `color`
- `visible_by_default`
- `owning_module`
- timestamps

## Related

- [Calendar And CalendarEntry Contract](../../04-features/calendar/calendar-and-calendar-entry-contract.md)
