# Phase 2 - Implementation Batch 9

This document defines the canonical scope and intent for Phase 2 - Implementation Batch 9.

## Purpose

Implement a basic inter-tenant messaging foundation as an app query/support channel, not a real-time chat product.

## Implementation Status

Current status:

* drafted
* implementation-ready after hard gates are satisfied
* blocked until Batch C account ownership close-out is complete

Planning owner:

* [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)

Canonical owners:

* [Final Stack And UI Design Spec](../../../03-architecture/subsystems/final-stack-and-ui-boundary.md)
* [Inter-Tenant Messaging Contract](../../../04-features/tenants/inter-tenant-messaging-contract.md)

## Entry Gates

Batch 9 implementation may start only when all of the following are true:

* Batch C is complete and account ownership contracts are closed
* thread/message participant contract remains aligned with this planning note and canonical owner note
* implementation status remains synchronized across planning, canonical owner, and Phase 2 index notes

## Batch Goal

Deliver a minimal message-thread workflow for inter-tenant communication with a core architecture that can later support distinct messaging modules (project boards, support tickets, issue/update request threads, and lightweight contextual chat entry points).

## Locked Architecture Direction

Batch 9 uses one shared communication engine:

* `Thread` as the conversation container
* `Message` as immutable conversation entries
* `ThreadParticipant` as membership and role/visibility bridge

This is the core/base system for 2+ participants to communicate.

Module-specific messaging systems (support tickets, project boards, issue/update request flows) should not create separate parallel messaging engines. They should attach to the same core thread model using context linkage and module-specific orchestration.

## Core Data Contract (Planned)

Planned baseline entities:

* `threads`
  * id
  * subject
  * status (`open`, `pending`, `resolved`, `archived`)
  * context_type (nullable string; e.g. `support_ticket`, `project_item`, `issue_request`, `general`)
  * context_id (nullable string/uuid/int depending on module contract)
  * created_by_user_id
  * timestamps
* `thread_participants`
  * id
  * thread_id
  * user_id
  * role (`owner`, `member`, `observer`)
  * last_read_at
  * muted_at (nullable)
  * timestamps
* `messages`
  * id
  * thread_id
  * sender_user_id
  * body
  * message_type (`comment`, `status_update`, `system_event`)
  * metadata (json, nullable)
  * timestamps

Optional follow-on table (deferred unless required in Batch 9):

* `message_attachments`

## In Scope

* basic message thread model and message item model
* inter-tenant thread creation and reply workflow
* assignment/visibility permissions for tenant-side users
* basic list/detail views for thread inbox and thread conversation
* status model (open, pending, resolved, archived)
* audit + notification hooks for new messages and status transitions
* foundational architecture notes for future customer-to-tenant and tenant-to-platform expansion
* define a core messaging contract that other modules can plug into:
  * support/ticket module threads
  * project/messageboard module threads
  * issue/update-request module threads
  * optional contextual “open discussion” entry points from related records

## Module Integration Rule

Future modules integrate by attaching workflow context to an existing thread, not by replacing the core conversation model.

Expected pattern:

1. Module owns business workflow objects (ticket, issue, project artifact).
2. Module links object to `thread` via `context_type/context_id` (or equivalent join contract if later ADR changes this).
3. Conversation behavior (participants, replies, read state, audit + notifications) remains owned by core messaging.

This keeps messaging comparable to notifications as a foundational cross-module system.

## Out Of Scope

* instant-message UX (presence, typing indicators, read receipts)
* customer-facing messaging UI
* tenant-to-platform escalation workflow finalization
* SLA engine, automation routing, or ticketing replacement scope
* full module implementations for support desk, project boards, or issue tracker

## Required Deliverables

1. Messaging data model + migration contract.
2. Permission model for thread/message access and moderation.
3. Inter-tenant inbox and conversation views (basic but production-safe).
4. Notification and audit event coverage for create/reply/resolve actions.
5. Core messaging contract documented for module integration (support/project/issues).
6. Documented extension points for customer and platform workflows.
7. Documentation sync across planning/canonical/development notes.

## Verification

Verification focus:

* authorization isolation between tenant participants
* message create/reply flow with validation
* thread status transitions and history visibility
* notification/audit parity
* staging workflow validation with at least two tenant contexts
* module-integration design review proving future support/project/issue systems can reuse core messaging contracts

## Exit Criteria

This batch is complete when:

* inter-tenant message threads are operational end-to-end
* security boundaries and visibility permissions are verified
* messaging behavior is documented as non-chat support/query workflow
* core messaging contract is reusable by future support/project/issue modules without redesign
* future customer/tenant/platform path is documented without over-committing unresolved product decisions

## Related

* [Phase 2 Index](Phase%202%20Index.md)
* [Phase 2 - Implementation Batch C](Phase%202%20-%20Implementation%20Batch%20C.md)
* [Phase 2 - Final Stack And UI System Planning](Phase%202%20-%20Final%20Stack%20And%20UI%20System%20Planning.md)
* [Inter-Tenant Messaging Contract](../../../04-features/tenants/inter-tenant-messaging-contract.md)
