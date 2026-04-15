# Event And Error Logging

This document defines the canonical scope and intent for Event And Error Logging.

## Purpose

Describe platform logging behavior for audit events and application error events.

## Implementation Status

Current status:

- implemented in code
- audit events are written for auth and related platform actions
- exception reporting writes error events into the central error log store

## Behavioral Scope

App 2.0 uses two logging stores:

- platform audit logs
- central error logs

## Runtime Components

Current behavior is implemented with:

- `App\Platform\Logging\PlatformLogger`
- `App\Http\Middleware\EnsureRequestId`
- exception reporting hook in `bootstrap/app.php`

## Platform Audit Logging Behavior

Audit logging captures intentional application events required for support, security, and operations review.

Examples:

- `auth.login_succeeded`
- `auth.login_failed`
- `auth.logout`

Audit log schema ownership:

- [Event And Error Logging Data Contract](../../06-database/feature-contracts/logging.md)

## Application Error Logging Behavior

Error logging captures application failures and exceptions.

Both logging stores use the same schema contract.

## Correlation Behavior

Each request gets an `X-Request-Id` used as correlation context across audit logs, error logs, and file logs.

## Timestamp Storage And Display

- `occurred_at` values are stored in UTC at rest
- timestamps render in signed-in user timezone when available
- platform timezone is fallback display context

## Operational Procedures

Operational runbook procedures and environment/state checks are canonicalized in:

- [Logging Operations Runbook](../../10-runbooks/logging-operations.md)

## Related

- [Features Index](../index.md)
- [Authentication](../auth/authentication.md)
- [Platform Notifications And Settings](../notifications/platform-notifications-and-settings.md)
- [System Overview](../../03-architecture/system-overview.md)
- [Logging Standards](../../02-standards/logging/Logging%20Standards.md)
