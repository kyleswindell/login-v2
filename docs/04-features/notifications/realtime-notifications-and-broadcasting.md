# Realtime Notifications And Broadcasting

This document defines the canonical scope and intent for Realtime Notifications And Broadcasting.

## Purpose

Describe the current Reverb and Echo architecture for live platform notifications.

## Implementation Status

Current status:

* implemented in code
* deployed on staging
* staging Reverb, queue worker, and Apache websocket proxy are configured and validated
* platform users only
* header preview, inbox, and unread counts are wired for realtime updates
* toast notifications are wired for newly created unread notifications

## Current Implementation

The current realtime notifications architecture includes:

* Laravel Reverb as the websocket server
* Laravel Echo in the Vite frontend
* a private per-user broadcast channel:
  * `private-App.Models.User.{id}`
* explicit notification broadcast events:
  * `notification.created`
  * `notification.updated`
* queued broadcast delivery through the normal queue pipeline

The current frontend listens for realtime events and updates:

* header unread summary
* header recent-notifications preview
* notifications inbox page
* toast stack for newly created unread notifications

## Important Files

* `app/Events/PlatformNotificationCreated.php`
* `app/Events/PlatformNotificationUpdated.php`
* `app/Http/Controllers/Platform/BroadcastAuthController.php`
* `app/Platform/Notifications/NotificationService.php`
* `config/broadcasting.php`
* `config/reverb.php`
* `routes/channels.php`
* `resources/js/app.js`

## Channel Contract

Current private channel:

* `App.Models.User.{id}`

Current auth rule:

* authenticated user ID must match the channel ID
* user must have `platform.notifications.view`

## Known Gaps

Current gaps:

* no tenant-facing realtime channels yet
* no browser-native notifications
* no realtime error-log streaming

## Related

* [Features Index](../index.md)
* [Platform Notifications And Settings](platform-notifications-and-settings.md)
* [Dashboard Subsystem](../../03-architecture/subsystems/dashboard.md)
* [Notifications And Settings Data Contract](../../06-database/feature-contracts/notifications-and-settings.md)
* [Platform Production Server Policy](../../02-standards/security/platform-production-server-policy.md)
