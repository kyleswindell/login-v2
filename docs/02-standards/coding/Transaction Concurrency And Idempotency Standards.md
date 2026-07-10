<!--
DOC-META
title: Transaction Concurrency And Idempotency Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/Transaction Concurrency And Idempotency Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines transaction ownership, locking, concurrency control, idempotency, retry behavior, after-commit side effects, and duplicate-delivery protection.
-->

# Transaction Concurrency And Idempotency Standards

Parent: [Coding Standards Index](index.md)

This document defines safe mutation behavior for concurrent requests, jobs, commands, webhooks, and integrations.

- [1. Purpose](#1-purpose)
- [2. Core Rule](#2-core-rule)
- [3. Transaction Ownership](#3-transaction-ownership)
- [4. Transaction Scope](#4-transaction-scope)
- [5. Side Effects After Commit](#5-side-effects-after-commit)
- [6. Idempotency](#6-idempotency)
- [7. Idempotency Keys](#7-idempotency-keys)
- [8. Database-Enforced Deduplication](#8-database-enforced-deduplication)
- [9. Optimistic Concurrency](#9-optimistic-concurrency)
- [10. Pessimistic Locking](#10-pessimistic-locking)
- [11. Deadlocks](#11-deadlocks)
- [12. State Transitions](#12-state-transitions)
- [13. Webhook Idempotency](#13-webhook-idempotency)
- [14. Job Idempotency](#14-job-idempotency)
- [15. Command Idempotency](#15-command-idempotency)
- [16. External Calls](#16-external-calls)
- [17. Audit](#17-audit)
- [18. Testing](#18-testing)
- [19. Stop Conditions](#19-stop-conditions)
- [20. Related](#20-related)

---

## 1. Purpose

Prevent partial writes, duplicate effects, stale updates, race conditions, and inconsistent side effects.

---

## 2. Core Rule

Every multi-write or retryable operation must define:

- transaction owner
- concurrency risk
- idempotency behavior
- retry behavior
- side-effect timing
- failure behavior
- verification strategy

If those decisions are unknown, the mutation is not implementation-ready.

---

## 3. Transaction Ownership

The action or service that owns the logical mutation should normally own the database transaction.

Do not start transactions in controllers and complete them in unrelated services.

Keep transactions:

- explicit
- focused
- short
- limited to required database work

Avoid network calls, email delivery, remote APIs, or slow file operations inside a transaction.

---

## 4. Transaction Scope

Include all database writes that must succeed or fail together.

Examples:

- record plus child records
- assignment plus audit-linked metadata
- export request plus authorization snapshot
- shipment plus lines
- role assignment plus direct-exception metadata

Do not include unrelated writes merely because they occur in one request.

---

## 5. Side Effects After Commit

Events, jobs, notifications, audit writes, and integrations that depend on committed state should run after commit when required.

Never notify another system about data that may still roll back.

Use Laravel after-commit behavior or an equivalent explicit mechanism.

The owning capability must define whether audit failure blocks or follows the transaction.

---

## 6. Idempotency

An idempotent operation can be repeated without creating unintended duplicate effects.

Idempotency is required or strongly preferred for:

- webhook processing
- queued jobs
- scheduled commands
- integration synchronization
- payment-like or financial operations
- export generation
- registry seeders
- retryable API requests
- provisioning

---

## 7. Idempotency Keys

Use idempotency keys when callers may repeat the same logical request.

An idempotency record should identify:

- key
- operation
- scope
- actor or integration
- request fingerprint when applicable
- status
- result reference
- created and expiry timestamps

Keys must be scoped so unrelated callers cannot collide.

Do not trust a client-provided idempotency key without scope and operation context.

---

## 8. Database-Enforced Deduplication

Prefer database constraints for durable deduplication.

Examples:

- unique external event ID
- unique integration and delivery ID
- unique scope and registry key
- unique actor/operation/idempotency key
- unique module and contribution key

Application-only “check then insert” logic is vulnerable to races.

---

## 9. Optimistic Concurrency

Use optimistic concurrency when conflicts are uncommon and stale updates should be detected.

Possible mechanisms:

- version column
- updated-at comparison
- conditional update
- state-transition condition

On conflict:

- do not silently overwrite newer data
- return or record a conflict
- allow safe retry or user refresh where appropriate

---

## 10. Pessimistic Locking

Use row locks when concurrent mutation of the same records would violate invariants.

Keep locks:

- narrowly scoped
- consistently ordered
- inside short transactions

Do not lock broad table ranges unnecessarily.

Document high-risk locking paths and test them where practical.

---

## 11. Deadlocks

Database deadlocks may be retried when the operation is safe and idempotent.

Retry behavior should:

- use bounded attempts
- include backoff
- preserve the original operation context
- avoid duplicate external side effects
- remain observable

Do not retry every database exception blindly.

---

## 12. State Transitions

Important lifecycle transitions should use conditional updates or locks.

Examples:

- pending → processing
- active → suspended
- requested → generating → ready
- issued → revoked
- open → shipped → closed

Do not allow invalid transitions merely because a record can be updated.

---

## 13. Webhook Idempotency

Webhook processing must:

- verify signature before mutation
- check timestamp freshness
- reject replay when required
- record external delivery/event ID
- return safe duplicate acknowledgement
- process asynchronously when appropriate
- avoid duplicate business effects

Do not rely only on payload equality.

---

## 14. Job Idempotency

Jobs should tolerate retries.

A job should identify:

- target record or operation
- expected current state
- duplicate-completion behavior
- retryable failures
- permanent failures
- timeout and backoff
- lock or uniqueness needs

Do not serialize sensitive or unnecessarily large models into job payloads.

---

## 15. Command Idempotency

Scheduled and operator commands should be safe to rerun where practical.

Use:

- checkpoints
- bounded batches
- stable keys
- state transitions
- dry-run mode for risky work
- progress reporting
- explicit partial-failure behavior

---

## 16. External Calls

When a database mutation and external call must coordinate, define the consistency model.

Possible approaches:

- commit then queue external work
- durable outbox-like record
- retryable integration task
- compensation action
- explicit partial-completion state

Do not hold a database transaction open while waiting on an unreliable external service without a documented requirement.

---

## 17. Audit

Audit transaction-sensitive actions after durable success unless denied or failed attempts must also be recorded.

Audit metadata should distinguish:

- requested
- succeeded
- failed
- denied
- duplicate
- retried
- compensated

Never record a success event before the underlying mutation commits.

---

## 18. Testing

Test:

- rollback on failure
- duplicate request behavior
- duplicate webhook behavior
- duplicate job execution
- stale update conflict
- invalid lifecycle transition
- lock-sensitive path where practical
- after-commit dispatch
- safe retry
- unique constraint race where material

Use PostgreSQL when behavior depends on PostgreSQL locking, constraints, transactions, or SQL semantics.

---

## 19. Stop Conditions

Stop before implementing a mutation when:

- transaction owner is unclear
- partial completion is possible but undefined
- external calls occur inside an unbounded transaction
- duplicate delivery could create duplicate effects
- concurrency could violate ownership or financial/data integrity
- retry behavior is unclear
- side effects may run before commit
- tests cannot prove rollback or duplicate protection

---

## 20. Related

- [Application Actions Services And Data Objects Standards](Application%20Actions%20Services%20And%20Data%20Objects%20Standards.md)
- [Events Jobs And Queue Standards](Events%20Jobs%20And%20Queue%20Standards.md)
- [Error And Exception Handling Standards](Error%20And%20Exception%20Handling%20Standards.md)
- [Database Migration Standards](../database/Database%20Migration%20Standards.md)
- [Coding Standards Index](index.md)