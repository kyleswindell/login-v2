# Notification Read And Dismiss Flow

This document defines the canonical scope and intent for Notification Read And Dismiss Flow.

## Purpose

Define the ordered execution path for reading and dismissing platform notifications from header and inbox surfaces.

## Inputs

* authenticated user context
* notification state for the current user
* header preview or inbox interaction

## Flow

1. Authenticated user opens the header preview or notifications inbox.
2. System loads visible notifications for the current user and current unread counts.
3. User opens a notification or explicitly marks it as read.
4. System updates read state for the current user and refreshes visible unread counts.
5. User optionally dismisses a notification from the inbox.
6. System retains the notification record but hides the dismissed notification from the visible inbox and unread counters.
7. System reflects the updated state in the header preview, inbox surface, and dashboard summary where applicable.

## Outputs

* updated read state
* updated dismissal state
* synchronized unread counts across current platform surfaces

## Related

* [Platform Notifications And Settings](../04-features/notifications/platform-notifications-and-settings.md)
* [Realtime Notifications And Broadcasting](../04-features/notifications/realtime-notifications-and-broadcasting.md)
