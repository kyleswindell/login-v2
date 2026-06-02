# Dashboard Customization Flow

This document defines the canonical scope and intent for Dashboard Customization Flow.

## Purpose

Define the ordered execution path for user-controlled dashboard customization.

## Inputs

* authenticated user context
* current dashboard layout state
* widget visibility and ordering changes

## Flow

1. Reviewer or operator opens the Layout + Dashboard UI Reference proof surface to inspect the customization contract on dummy widgets first.
2. Proof surface loads browser-local review state so lock/unlock, reorder, hide/show, restore, and reset can be exercised without touching the live user record.
3. Authenticated user opens `/dashboard`.
4. System loads the default layout when no saved layout exists, or the saved layout when one exists.
5. User enters customization mode from the dashboard toolbar.
6. User reorders widgets and/or changes widget visibility.
7. System validates the requested widget state against the current user's permissions and the current widget-registry placement contract.
8. System persists the updated layout for the current user using stable widget identity plus validated placement metadata.
9. System returns the dashboard to the updated locked or visible state.
10. If the user chooses reset, system clears the saved layout and restores the default configuration.

## Outputs

* browser-local proof state on the UI Reference review surface
* persisted per-user dashboard layout on the live dashboard
* restored default layout on reset
* permission-safe widget visibility state

## Related

* [Dashboard](../04-features/dashboard/dashboard.md)
* [Platform Notifications And Settings](../04-features/notifications/platform-notifications-and-settings.md)
