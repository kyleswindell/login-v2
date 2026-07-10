<!--
DOC-META
title: Events Jobs And Queue Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/Events Jobs And Queue Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines event, listener, job, queue, retry, failure, payload, after-commit, scheduling, observability, and testing standards.
-->

# Events Jobs And Queue Standards

Parent: [Coding Standards Index](index.md)

This document defines asynchronous and event-driven implementation standards for Login App 2.0.

- [1. Purpose](#1-purpose)
- [2. Core Rule](#2-core-rule)
- [3. Events](#3-events)
- [4. Event Naming](#4-event-naming)
- [5. Event Payloads](#5-event-payloads)
- [6. Listeners](#6-listeners)
- [7. Jobs](#7-jobs)
- [8. Job Payloads](#8-job-payloads)
- [9. Retry Behavior](#9-retry-behavior)
- [10. Backoff And Timeouts](#10-backoff-and-timeouts)
- [11. Idempotency](#11-idempotency)
- [12. Transaction Relationship](#12-transaction-relationship)
- [13. Scheduling](#13-scheduling)
- [14. Failed Jobs](#14-failed-jobs)
- [15. Queue Selection](#15-queue-selection)
- [16. Notifications And Mail](#16-notifications-and-mail)
- [17. Webhooks And Integrations](#17-webhooks-and-integrations)
- [18. Observability](#18-observability)
- [19. Testing](#19-testing)
- [20. Stop Conditions](#20-stop-conditions)
- [21. Related](#21-related)

---

## 1. Purpose

Keep events descriptive, jobs retry-safe, payloads secure, failures observable, and queue behavior predictable.

---

## 2. Core Rule

Before adding an event, listener, or job, identify:

- owning capability or module
- reason asynchronous or event-driven behavior is needed
- payload
- transaction relationship
- retry and idempotency behavior
- failure owner
- monitoring and audit expectations
- tests

Do not use events or queues only to avoid a direct dependency that should be explicit.

---

## 3. Events

An event states that something happened.

Events should:

- use completed-action meaning
- have a clear owner
- contain stable, minimal data
- avoid hidden behavior assumptions
- avoid sensitive payloads
- be dispatched after commit when listeners require committed state

Examples:

- `UserInvited`
- `MfaMethodRemoved`
- `RoleAssigned`
- `ExportRequested`
- `ShipmentCreated`

---

## 4. Event Naming

Class names should be explicit and past-tense in meaning.

Persisted or audited event keys should be namespaced:

- `auth.login_succeeded`
- `identity.user_invited`
- `access.role_assigned`
- `data.export_requested`
- `orders.shipment_created`

Do not use vague names such as `Updated`, `Changed`, or `Processed` without identifying the subject.

---

## 5. Event Payloads

Prefer:

- stable identifiers
- scalar values
- enums
- DTOs
- safe snapshots where needed

Avoid:

- complete request objects
- service instances
- large model graphs
- raw secrets
- authorization headers
- cookies
- MFA material
- restricted payloads

Document serialization expectations for queued listeners.

---

## 6. Listeners

A listener owns one reaction.

Examples:

- queue a notification
- update a projection
- send integration work to a job
- record a monitoring signal

Listeners should:

- remain focused
- be idempotent where repeat delivery is possible
- avoid changing the original transaction unexpectedly
- queue expensive or remote work
- report failures safely

Do not hide essential primary business mutations only in listeners.

---

## 7. Jobs

A job owns asynchronous or retryable work.

Jobs should define:

- queue name when multiple queues exist
- timeout
- attempts
- backoff
- retryable failures
- permanent failures
- idempotency
- unique or locking behavior when required
- safe payload
- failure reporting

---

## 8. Job Payloads

Pass the smallest stable data needed.

Prefer IDs or DTOs over full serialized models when:

- records may change before execution
- scope must be revalidated
- payload size matters
- sensitive fields exist
- model relationships are unnecessary

Re-authorize or revalidate scope when a delayed job performs protected behavior.

---

## 9. Retry Behavior

Retry only when the failure may succeed later.

Retryable examples:

- temporary network failure
- rate limit
- transient database deadlock
- temporary storage failure

Permanent examples:

- invalid signature
- revoked token
- missing required configuration
- unsupported payload
- authorization denial
- invalid business state

Do not retry permanent failures indefinitely.

---

## 10. Backoff And Timeouts

Set explicit timeouts for external or long-running work.

Backoff should:

- be bounded
- avoid overwhelming dependencies
- account for rate limits
- remain observable

Do not use unbounded retries.

---

## 11. Idempotency

Jobs and queued listeners must be safe under duplicate delivery.

Use:

- unique constraints
- external delivery IDs
- operation records
- state checks
- idempotency keys
- locks where appropriate

Do not assume a queue guarantees exactly-once execution.

---

## 12. Transaction Relationship

When a job or event depends on newly committed state:

- dispatch after commit
- reload records during execution
- validate current state
- tolerate records being changed or removed before execution

Do not queue work that references data that may still roll back.

---

## 13. Scheduling

Scheduled commands/jobs should:

- be safe to run repeatedly
- avoid overlapping when overlap would create risk
- use locks or unique execution when needed
- process bounded batches
- report failures
- document required scheduler setup

Operational scheduling belongs in runbooks and deployment docs as applicable.

---

## 14. Failed Jobs

Failed jobs must be observable.

Define:

- failure logging
- monitoring signal
- audit requirement when security-sensitive
- retry or manual remediation path
- dead-letter or failed-job review process
- data retained in failure records

Do not include raw secrets in failed-job payloads.

---

## 15. Queue Selection

Use queue separation when workloads have materially different:

- priority
- latency
- timeout
- security
- resource consumption
- operational ownership

Do not create queues without an operational reason and deployment support.

---

## 16. Notifications And Mail

Notification/mail delivery should be queued when appropriate.

The durable notification record and the delivery attempt are separate concerns.

Required security or system notifications must not be silently dropped because an optional user delivery preference is disabled.

---

## 17. Webhooks And Integrations

Inbound webhooks should:

- verify signature
- verify freshness
- detect replay
- record delivery ID
- acknowledge duplicates safely
- queue substantive processing when appropriate

Outbound integration jobs should:

- use stable operation IDs
- define retries
- redact logs
- record result
- avoid duplicate remote effects

---

## 18. Observability

Record safe operational context:

- job name
- operation
- attempt
- queue
- target identifier
- scope
- correlation ID
- duration
- result

Do not log complete payloads by default.

---

## 19. Testing

Test:

- event dispatch
- after-commit behavior
- listener reaction
- job payload
- retryable failure
- permanent failure
- timeout/backoff configuration when material
- duplicate execution
- failed-job handling
- scope revalidation
- sensitive-data redaction

Use fakes only when they do not fake away the behavior under test.

---

## 20. Stop Conditions

Stop before adding asynchronous behavior when:

- synchronous behavior is sufficient and clearer
- job idempotency is unknown
- payload includes restricted data
- retry behavior is undefined
- failure ownership is unclear
- queue infrastructure does not support the workload
- a job may run before its transaction commits
- duplicate execution could create unsafe effects

---

## 21. Related

- [Transaction Concurrency And Idempotency Standards](Transaction%20Concurrency%20And%20Idempotency%20Standards.md)
- [Error And Exception Handling Standards](Error%20And%20Exception%20Handling%20Standards.md)
- [Application Actions Services And Data Objects Standards](Application%20Actions%20Services%20And%20Data%20Objects%20Standards.md)
- [Testing Standards](Testing%20Standards.md)
- [Coding Standards Index](index.md)