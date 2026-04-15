# Logging Operations

This document defines the canonical scope and intent for Logging Operations.

## Purpose

Define operational procedures for platform audit/error log viewing surfaces and transitional operational route behavior.

## Operational Surfaces

- `/platform/audit-logs`
- `/platform/error-logs`
- `/platform/error-logs/{log}`
- `/platform/operations/audit-logs`
- `/platform/operations/error-logs`

## Transitional Proof-Path Control

- direct `/console/*` proof-path access is controlled by `CONSOLE_PROOF_PATHS_ENABLED`
- default is off
- when disabled, fallback redirects route operators to app-owned `/platform/*` log surfaces

## Operational Checks

1. Confirm route gate permissions for audit and error log operators.
2. Confirm `/platform/operations/*` routes resolve to app-owned operational log views.
3. Confirm proof-path control behavior for `/console/*` with current flag value.
4. Confirm large message/stack-trace rendering remains usable in operational views.

## Related

- [Realtime Notifications And Reverb](realtime-notifications-and-reverb.md)
- [Deployment Workflow](deployment-workflow.md)
- [Event And Error Logging](../04-features/logging/event-and-error-logging.md)
