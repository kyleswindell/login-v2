# Realtime Notifications And Broadcasting

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

* [[V2 App/Features/Platform Notifications And Settings]] | [Platform Notifications And Settings](Platform%20Notifications%20And%20Settings.md)
* [[V2 App/Runbooks/Realtime Notifications And Reverb]] | [Realtime Notifications And Reverb](../Runbooks/Realtime%20Notifications%20And%20Reverb.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 4]] | [Phase 1 - Implementation Batch 4](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%204.md)
