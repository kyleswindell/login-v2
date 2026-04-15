# Platform Notifications And Settings

This document defines the canonical scope and intent for Platform Notifications And Settings.

## Purpose

Describe the current shared notifications and settings foundation for the platform app.

## Implementation Status

Current status:

* implemented in code
* Reverb and Echo realtime notifications are deployed on staging and validated
* header recent-notifications preview is live on staging with realtime updates
* notifications inbox UI is live on staging with realtime updates
* settings service is migrated on staging
* dashboard and header unread-count surfaces are live on staging
* settings UI, selective Setup pages, and the Setup/Settings sidebar shell are live on staging
* Phase 2 Batch 5 keeps notifications custom/Echo-backed until realtime parity criteria are met
* Phase 2 Batch 5 keeps settings on the current Blade workflow until grouped Filament page ownership is defined
* target administration routes are implemented locally at `/platform/administration/notifications` and `/platform/administration/settings`
* dismissed notifications are retained in the database but hidden from the inbox and unread counts
* dashboard includes a permission-gated temporary test-notification action for Batch 5 review

## Current Implementation

Phase 1 currently includes:

* shared settings and notifications services
* unread notification count surfaced on the dashboard shell
* a header recent-notifications preview of the five latest notifications with hover-open and click-to-pin behavior
* persisted notification state
* queued notification broadcast events for created and updated notifications
* a notifications inbox page
* notification mark-read, mark-all-read, and dismiss actions
* a temporary dashboard test-notification action for review workflows
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
* dismiss and hide from the visible inbox

Current settings groupings in code:

* General
* Platform Notifications
* Audit Logs
* Documentation Vault
* Platform Users

## Phase 2 Batch 5 Owner Target

Batch 5 keeps settings and notifications conservative while the platform-users migration proves the shared admin owner pattern.

Owner targets:

* settings remain hybrid/custom Blade until grouped Filament page ownership is defined
* notifications inbox and header preview remain custom Blade plus Echo because live unread counts, preview state, inbox updates, and toast behavior are the critical contract
* shell and realtime fallback links use `/platform/administration/notifications` while existing notification action routes remain under `/platform/notifications/*`
* setup navigation can use `/platform/administration/settings` while editable settings forms remain under `/platform/settings/*`
* any later Filament or Livewire migration must preserve `NotificationService`, `SettingsService`, audit logging, permissions, and Reverb/Echo delivery behavior
* the dashboard test-notification action is temporary review tooling and should be removed or replaced by formal notification testing/admin tooling after Batch 5 sign-off

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

## Data Dependencies

Data contract ownership for settings and notifications lives in:

* [Notifications And Settings Data Contract](../../06-database/feature-contracts/notifications-and-settings.md)

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
* no Batch 5 Filament settings or notifications owner implementation exists yet because custom Blade/Echo remains the selected owner for this batch

## Related

* [Features Index](../index.md)
* [Realtime Notifications And Broadcasting](realtime-notifications-and-broadcasting.md)
* [Event And Error Logging](../logging/event-and-error-logging.md)
* [Dashboard Subsystem](../../03-architecture/subsystems/dashboard.md)
* [Logging Standards](../../02-standards/logging/Logging%20Standards.md)
* [Notification Read And Dismiss Flow](../../05-flows/notification-read-and-dismiss-flow.md)
