# Phase 1 - Implementation Batch 3

## Purpose

Translate the existing logging, notifications, and RBAC foundations into usable platform-admin surfaces.

This batch should close the immediate gap between foundation tables/services and the first real admin workflows that depend on them.

## Implementation Status

Current status:

* implemented in code
* validated locally with passing tests
* pending staging deploy
* settings UI remains out of scope for this batch
* error log viewer remains deferred

Canonical docs:

* [[V2 App/Features/Platform Notifications And Settings]] | [Platform Notifications And Settings](../../Features/Platform%20Notifications%20And%20Settings.md)
* [[V2 App/Features/Event And Error Logging]] | [Event And Error Logging](../../Features/Event%20And%20Error%20Logging.md)
* [[V2 App/Features/Platform Users And RBAC]] | [Platform Users And RBAC](../../Features/Platform%20Users%20And%20RBAC.md)
* [[V2 App/Development/Phase 1 Development Log]] | [Phase 1 Development Log](../../Development/Phase%201%20Development%20Log.md)

## Batch Goal

Make the current Phase 1 platform shell operationally useful by exposing notification and audit visibility inside the app while normalizing first-pass RBAC seeding.

## In Scope

### Notifications

This batch includes:

* notifications inbox UI
* unread and dismissed state visibility
* mark-read action
* mark-all-read action
* dismiss action
* notification access limited to the signed-in user

### Audit Logs

This batch includes:

* platform audit log list UI
* filters for event type, actor, result, and severity
* actor lookups through the current platform user relation

### RBAC Seed Cleanup

This batch includes:

* first-pass seeded roles
* first-pass seeded permissions
* permission-backed gates for notifications and audit logs
* a seeded default catalog that can be reused in local and staging environments

## Out Of Scope

Do not pull these into Batch 3:

* settings management UI
* error log viewer UI
* external notification channels
* tenant-specific audit or notification surfaces
* full role/permission administration UI

## Deliverables

Batch 3 should leave the repo with:

* a usable notifications page
* a usable audit log page
* seeded platform roles and permissions
* updated canonical docs and planning status

## Next Follow-Up

Once this batch is deployed and verified on staging, the next recommended Phase 1 work is:

1. settings UI
2. staged operational visibility for errors
3. further admin workflow refinement where staging feedback shows real gaps

## Related

* [[V2 App/Planning/Phase 1/Phase 1 Index]] | [Phase 1 Index](Phase%201%20Index.md)
* [[V2 App/Planning/Phase 1/Logging Notifications And Options Foundation]] | [Logging Notifications And Options Foundation](Logging%20Notifications%20And%20Options%20Foundation.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 2]] | [Phase 1 - Implementation Batch 2](Phase%201%20-%20Implementation%20Batch%202.md)
* [[V2 App/Development/Phase 1 Development Log]] | [Phase 1 Development Log](../../Development/Phase%201%20Development%20Log.md)
