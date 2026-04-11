# Platform Notifications And Settings

## Purpose

Describe the current shared notifications and settings foundation for the platform app.

## Implementation Status

Current status:

* implemented in code
* Reverb and Echo realtime notifications are deployed on staging and validated
* header recent-notifications preview is live on staging with realtime updates
* notifications inbox UI is live on staging with realtime updates
* settings table and service are migrated on staging
* dashboard and header unread-count surfaces are live on staging
* settings UI, selective Setup pages, and the Setup/Settings sidebar shell are implemented in code and pending staging deploy

## Current Implementation

Phase 1 currently includes:

* a shared `settings` table and settings service
* a shared `notifications` table and notification service
* unread notification count surfaced on the dashboard shell
* a header recent-notifications preview of the five latest notifications with hover-open and click-to-pin behavior
* database-first notification persistence
* queued notification broadcast events for created and updated notifications
* a notifications inbox page
* notification mark-read, mark-all-read, and dismiss actions
* Setup sidebar shell with a Setup-triggered slide interaction
* selective Setup landing pages for notifications, docs, audit logs, error logs, and platform users
* Settings second-column panel and page set for general, notifications, audit logs, docs, and users
* a General settings section with pages for platform general, company information, localization, email, system update, and system/server info
* settings writes routed through `SettingsService` with audit logging

Current services:

* `App\Platform\Settings\SettingsService`
* `App\Platform\Notifications\NotificationService`

Supported notification actions in code:

* send to a notifiable model
* mark read
* dismiss

Current settings groupings in code:

* General
* Platform Notifications
* Audit Logs
* Documentation Vault
* Platform Users

## Important Files

* `app/Models/Setting.php`
* `app/Models/PlatformNotification.php`
* `app/Platform/Settings/SettingsService.php`
* `app/Platform/Notifications/NotificationService.php`
* `app/Events/PlatformNotificationCreated.php`
* `app/Events/PlatformNotificationUpdated.php`
* `app/Http/Controllers/Platform/BroadcastAuthController.php`
* `app/Http/Controllers/Platform/NotificationController.php`
* `app/Http/Controllers/Platform/SettingsController.php`
* `database/migrations/2026_04_09_000003_create_settings_table.php`
* `database/migrations/2026_04_09_000004_create_notifications_table.php`
* `config/broadcasting.php`
* `config/reverb.php`
* `routes/channels.php`
* `resources/js/app.js`
* `resources/js/setup-sidebar.js`
* `resources/views/platform/setup/`
* `resources/views/platform/notifications/index.blade.php`
* `resources/views/platform/settings/_sidebar.blade.php`
* `resources/views/platform/settings/_general-tabs.blade.php`
* `resources/views/platform/settings/general.blade.php`
* `resources/views/platform/settings/general-company-information.blade.php`
* `resources/views/platform/settings/general-localization.blade.php`
* `resources/views/platform/settings/general-email.blade.php`
* `resources/views/platform/settings/general-system-update.blade.php`
* `resources/views/platform/settings/general-system-server-info.blade.php`
* `resources/views/platform/settings/notifications.blade.php`
* `resources/views/platform/settings/audit-logs.blade.php`
* `resources/views/platform/settings/docs.blade.php`
* `resources/views/platform/settings/users.blade.php`

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

Current settings and docs access behavior:

* settings writes are audited
* docs viewer access is additionally constrained by the configured docs access scope

## Known Gaps

Current gaps:

* no non-database delivery channels yet
* no notification receipts or fan-out tables yet
* notification defaults are still limited to a first-pass set of platform-wide options

## Related

* [[V2 App/Planning/Phase 1/Logging Notifications And Options Foundation]] | [Logging Notifications And Options Foundation](../Planning/Phase%201/Logging%20Notifications%20And%20Options%20Foundation.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 1]] | [Phase 1 - Implementation Batch 1](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 3]] | [Phase 1 - Implementation Batch 3](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%203.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 4]] | [Phase 1 - Implementation Batch 4](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%204.md)
* [[V2 App/Features/Realtime Notifications And Broadcasting]] | [Realtime Notifications And Broadcasting](Realtime%20Notifications%20And%20Broadcasting.md)
* [[V2 App/Features/Event And Error Logging]] | [Event And Error Logging](Event%20And%20Error%20Logging.md)
