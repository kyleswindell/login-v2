# Dashboard Customization Flow

This document defines the canonical scope and intent for Dashboard Customization Flow.

## Purpose

Define the ordered execution path for user-controlled dashboard customization.

## Inputs

* authenticated user context
* current dashboard layout state
* widget visibility and ordering changes

## Flow

1. Authenticated user opens `/dashboard`.
2. System loads the default layout when no saved layout exists, or the saved layout when one exists.
3. User enters customization mode from the dashboard toolbar.
4. User reorders widgets and/or changes widget visibility.
5. System validates the requested widget state against the current user's permissions.
6. System persists the updated layout for the current user.
7. System returns the dashboard to the updated locked or visible state.
8. If the user chooses reset, system clears the saved layout and restores the default configuration.

## Outputs

* persisted per-user dashboard layout
* restored default layout on reset
* permission-safe widget visibility state

## Related

* [Dashboard](../04-features/dashboard/dashboard.md)
* [Platform Notifications And Settings](../04-features/notifications/platform-notifications-and-settings.md)
