# Phase 1 - Implementation Batch 1

This document defines the canonical scope and intent for Phase 1 - Implementation Batch 1.

## Purpose

Deliver the first Phase 1 execution batch for shared-core foundation setup.

## Implementation Status

Current status:

- implemented in code
- migrated on staging
- foundational data and service layer completed
- dedicated admin UI for some surfaces followed in later batches

Canonical docs:

- [Authentication](../../../04-features/auth/authentication.md)
- [Event And Error Logging](../../../04-features/logging/event-and-error-logging.md)
- [Platform Users And RBAC](../../../04-features/users/platform-users-and-rbac.md)
- [Platform Notifications And Settings](../../../04-features/notifications/platform-notifications-and-settings.md)

## Batch Goal

Establish the first stable shared-core foundation for identities, RBAC, settings, notifications, and logging integration hooks.

## In Scope

- RBAC package setup and baseline integration
- settings persistence baseline delivery
- notifications persistence baseline delivery
- foundational service layer delivery
- baseline tests for authorization and persistence

## Out Of Scope

- tenancy provisioning runtime
- tenant auth model
- content and business-module domain delivery
- notification fan-out beyond in-app persistence

## Recommended Order

1. Install and configure RBAC package.
2. Deliver RBAC baseline migrations.
3. Deliver settings persistence baseline.
4. Deliver notifications persistence baseline.
5. Deliver baseline services for settings and notifications.
6. Add tests for role/permission, bypass behavior, settings persistence, and notification persistence.
7. Run migrations and tests.
8. Deploy and run server migration step.

## Data Contract Reference

Schema, table, and migration contract details are canonicalized in:

- [Auth And RBAC Data Contract](../../../06-database/feature-contracts/auth-and-rbac.md)
- [Notifications And Settings Data Contract](../../../06-database/feature-contracts/notifications-and-settings.md)
- [Phase 1 Batch 1 Foundation Schema Contract](../../../06-database/phase-1-batch-1-foundation-schema-contract.md)

## Related

- [Phase 1 Index](Phase%201%20Index.md)
- [Phase 1 - Platform Foundation Planning](Phase%201%20-%20Platform%20Foundation%20Planning.md)
- [Auth And Authorization Foundation](Auth%20And%20Authorization%20Foundation.md)
- [Logging Notifications And Options Foundation](Logging%20Notifications%20And%20Options%20Foundation.md)
