# Phase 1 - Implementation Batch 4

This document defines the canonical scope and intent for Phase 1 - Implementation Batch 4.

## Purpose

Capture the first realtime-notifications implementation pass for the platform shell.

## Implementation Status

Current status:

* implemented in code
* deployed on staging
* staging Reverb, queue worker, and Apache proxy setup applied and validated

Canonical docs:

* [Platform Notifications And Settings](../../../04-features/notifications/platform-notifications-and-settings.md)
* [Realtime Notifications And Broadcasting](../../../04-features/notifications/realtime-notifications-and-broadcasting.md)
* [Platform Workspace And Documentation Vault](../../../04-features/workspace/platform-workspace-and-documentation-vault.md)
* Phase 1 Development Log

## Batch Goal

Move platform notifications from refresh-based UI updates to a Reverb and Echo realtime architecture.

## Deliverables

Batch 4 should leave the repo with:

* Reverb broadcasting configuration
* private user-channel authorization
* notification created and updated broadcast events
* Echo client wiring in the app shell
* realtime header and inbox updates
* toast notifications for new unread notifications
* staging runbook and server config templates

## Related

* [Phase 1 Index](Phase%201%20Index.md)
* [Realtime Notifications And Reverb](../../../10-runbooks/realtime-notifications-and-reverb.md)
