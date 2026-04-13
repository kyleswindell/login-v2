# Inter-Tenant Messaging Contract

## Purpose

Define the canonical messaging foundation contract for inter-tenant communication workflows using one shared thread/message engine.

This note is the canonical system owner for Thread, ThreadParticipant, and Message behavior contracts.

## Implementation Status

Current status:

* contract defined
* Batch 9 implementation blocked until Batch 8 account ownership close-out is complete

Planning source:

* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 9]] | [Phase 2 - Implementation Batch 9](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%209.md)

## Core Architecture Contract

Messaging uses one shared communication engine:

* `Thread` as conversation container
* `ThreadParticipant` as membership and role bridge
* `Message` as immutable message record

Module-specific workflows attach context to this core model rather than creating separate messaging engines.

## Data Contract

Required baseline entities:

* `threads`
  * subject, status, context_type, context_id, created_by_user_id, timestamps
* `thread_participants`
  * thread_id, user_id, role, last_read_at, muted_at, timestamps
* `messages`
  * thread_id, sender_user_id, body, message_type, metadata, timestamps

Optional deferred entity:

* `message_attachments`

## Module Integration Contract

Module integration pattern:

1. module owns its business record (ticket/project item/issue)
2. module links to messaging via context fields
3. messaging engine owns participants, replies, read state, audit hooks, and notifications

## Authorization Contract

* thread visibility is participant-scoped
* non-participants cannot read or reply to thread content
* moderation/status actions require explicit permission contracts
* tenant-boundary isolation remains mandatory before ownership checks

## Behavioral Scope Contract

In scope for the foundation:

* support/query style threaded conversation
* status transitions (`open`, `pending`, `resolved`, `archived`)
* inbox and thread detail workflow
* audit and notification hooks on create/reply/status changes

Out of scope for this foundation:

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

* [[V2 App/Planning/Phase 2/Phase 2 - Implementation Batch 9]] | [Phase 2 - Implementation Batch 9](../Planning/Phase%202/Phase%202%20-%20Implementation%20Batch%209.md)
* [[V2 App/Planning/Phase 2/Phase 2 - Final Stack And UI System Planning]] | [Phase 2 - Final Stack And UI System Planning](../Planning/Phase%202/Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [[V2 App/Architecture/V2 Final Stack And UI Design Spec]] | [V2 Final Stack And UI Design Spec](../Architecture/V2%20Final%20Stack%20And%20UI%20Design%20Spec.md)
* [[V2 App/Features/Feature Index]] | [Feature Index](Feature%20Index.md)
