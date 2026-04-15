# Inter-Tenant Messaging Contract

This document defines the canonical scope and intent for Inter-Tenant Messaging Contract.

Status: Planned (not implemented)

## Purpose

Define the planned messaging foundation contract for inter-tenant communication workflows using one shared thread/message engine.

This note is the canonical planned-system owner for Thread, ThreadParticipant, and Message behavior contracts.

## Implementation Status

Current status:

* contract defined
* not implemented in the current repo
* Batch 9 implementation blocked until Batch 8 account ownership close-out is complete

Planning source:

* [Phase 2 - Implementation Batch 9](../../07-planning/phases/phase-2/Phase%202%20-%20Implementation%20Batch%209.md)

## Data Dependencies

Data contract ownership for messaging entities lives in:

* [Inter-Tenant Messaging Data Contract](../../06-database/feature-contracts/inter-tenant-messaging.md)

Architecture ownership for messaging engine and module integration boundaries lives in:

* [Inter-Tenant Messaging Subsystem](../../03-architecture/subsystems/inter-tenant-messaging.md)

## Authorization Contract

* thread visibility is participant-scoped
* non-participants cannot read or reply to thread content
* moderation/status actions require explicit permission contracts
* tenant-boundary isolation remains mandatory before ownership checks

## Behavioral Scope Contract

In scope for the planned foundation:

* support/query style threaded conversation
* status transitions (`open`, `pending`, `resolved`, `archived`)
* inbox and thread detail workflow
* audit and notification hooks on create/reply/status changes

Out of scope for this planned foundation:

* realtime chat presence/typing
* SLA automation and ticketing orchestration
* customer-facing messaging UI

## Verification Contract

Verification should confirm:

* participant-only access for thread and message views
* create/reply validation paths
* status transition integrity
* audit and notification parity
* staging validation across at least two tenant contexts

## Related

* [Features Index](../index.md)
* [Inter-Tenant Messaging Data Contract](../../06-database/feature-contracts/inter-tenant-messaging.md)
* [Inter-Tenant Messaging Subsystem](../../03-architecture/subsystems/inter-tenant-messaging.md)
