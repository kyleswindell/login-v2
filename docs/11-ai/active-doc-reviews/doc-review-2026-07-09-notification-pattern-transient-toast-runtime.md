# Notification Pattern And Transient Toast Runtime Review

Date: 2026-07-09
Status: IMPLEMENTED_PENDING_REVIEW
Implementation status: implemented

## Scope

Review and align notification ownership with Carbon notification pattern guidance, then implement the smallest runtime proof for non-persistent action-feedback toasts.

## Source Alignment

Carbon separates notification status from notification type. The app should preserve that split:

- Status: informational, success, warning, error.
- Types: inline, toast, actionable, callout, banner, notification panel, modal.

## Ownership Decision

- `Modules/Notifications` owns persisted notification records, delivery, realtime events, bell/panel/inbox behavior, and transient toast dispatch.
- `x-ui.notification.*` owns Tier 1 visual primitives.
- `x-patterns.notifications.*` owns Tier 2 pattern composition when a reusable usage wrapper is helpful.
- Modal notification pattern already exists and is excluded from this pass.

## Implemented

- Added `Modules/Notifications/Services/TransientToasts.php` for non-persistent toast payloads and session flash messages.
- Added a Notifications module provider binding for the transient toast service.
- Added a runtime toast mount that renders toast templates through `x-ui.notification.toast` independently of the notification bell.
- Added Tier 2 wrappers for inline, toast, actionable, and callout notification patterns.
- Constrained the callout wrapper to guidance-oriented kinds instead of success/error task feedback.
- Added tests for transient toasts and notification pattern composition.

## Deferred

- Banner pattern remains deferred until a supported primitive/placement contract is approved.
- Generic notification panel pattern remains deferred; the current notification panel remains Notifications module-owned feature UI.
- Modal notification pattern review/update remains out of scope.
- Broader adoption of transient toast helpers in feature controllers is a later usage pass.

## Validation

- Static PHP syntax validation should be run for touched PHP files.
- Focused tests should cover transient toast helpers, notification pattern wrappers, and existing notification service behavior.
