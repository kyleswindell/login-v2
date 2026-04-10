# Platform Notifications And Settings

## Purpose

Describe the current shared notifications and settings foundation for the platform app.

## Implementation Status

Current status:

* implemented in code
* notifications inbox UI is implemented in code and pending staging deploy
* settings table and service are migrated on staging
* dashboard and header unread-count surfaces are live on staging
* no dedicated settings UI yet

## Current Implementation

Phase 1 currently includes:

* a shared `settings` table and settings service
* a shared `notifications` table and notification service
* unread notification count surfaced on the dashboard shell
* database-first notification persistence
* a notifications inbox page
* notification mark-read, mark-all-read, and dismiss actions

Current services:

* `App\Platform\Settings\SettingsService`
* `App\Platform\Notifications\NotificationService`

Supported notification actions in code:

* send to a notifiable model
* mark read
* dismiss

## Important Files

* `app/Models/Setting.php`
* `app/Models/PlatformNotification.php`
* `app/Platform/Settings/SettingsService.php`
* `app/Platform/Notifications/NotificationService.php`
* `app/Http/Controllers/Platform/NotificationController.php`
* `database/migrations/2026_04_09_000003_create_settings_table.php`
* `database/migrations/2026_04_09_000004_create_notifications_table.php`
* `resources/views/platform/notifications/index.blade.php`

## Data / Tables

Current settings table:

* `settings`

Current notifications table:

* `notifications`

Key settings fields:

* `scope_type`
* `scope_id`
* `module_key`
* `group_key`
* `key`
* `value_jsonb`
* `data_type`
* `updated_by`

Key notification fields:

* `uuid`
* `notifiable_type`
* `notifiable_id`
* `module_key`
* `severity`
* `title`
* `body`
* `action_url`
* `read_at`
* `dismissed_at`
* `delivery_channels`
* `metadata`

## Logging / Observability

Phase 1 planning expects settings changes and notification events to remain auditable as these surfaces gain fuller UI workflows.

## Known Gaps

Current gaps:

* no settings management screen yet
* no non-database delivery channels yet
* no notification receipts or fan-out tables yet

## Related

* [[V2 App/Planning/Phase 1/Logging Notifications And Options Foundation]] | [Logging Notifications And Options Foundation](../Planning/Phase%201/Logging%20Notifications%20And%20Options%20Foundation.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 1]] | [Phase 1 - Implementation Batch 1](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 3]] | [Phase 1 - Implementation Batch 3](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%203.md)
* [[V2 App/Features/Event And Error Logging]] | [Event And Error Logging](Event%20And%20Error%20Logging.md)
