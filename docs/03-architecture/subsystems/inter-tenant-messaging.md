# Inter-Tenant Messaging Subsystem

This document defines the canonical scope and intent for Inter-Tenant Messaging Subsystem.

Status: Planned (not implemented)

## Purpose

Define the planned inter-tenant messaging subsystem architecture boundary and shared-engine ownership model.

## Shared Engine Model

Planned messaging uses one shared engine:

* `Thread` as the conversation container
* `ThreadParticipant` as membership and role bridge
* `Message` as immutable message record

Feature and module workflows attach context to this shared engine instead of building parallel messaging engines.

## Integration Boundary

Planned module integration boundary:

1. module owns its business record
2. module links to messaging via context fields
3. messaging subsystem owns participant membership, replies, read state, audit hooks, and notification hooks

## Data Boundary

The planned messaging schema ownership is defined in:

* [Inter-Tenant Messaging Data Contract](../../06-database/feature-contracts/inter-tenant-messaging.md)

## Related

* [Architecture Index](../index.md)
* [Tenancy](../tenancy.md)
* [Inter-Tenant Messaging Feature](../../04-features/tenants/inter-tenant-messaging-contract.md)
