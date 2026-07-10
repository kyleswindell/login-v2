<!--
DOC-META
title: Error And Exception Handling Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/Error And Exception Handling Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines error categories, exception ownership, HTTP translation, logging, redaction, fail-open and fail-closed behavior, user-facing messages, and verification requirements.
-->

# Error And Exception Handling Standards

Parent: [Coding Standards Index](index.md)

This document defines how Login App 2.0 represents, reports, translates, and recovers from errors.

- [1. Purpose](#1-purpose)
- [2. Core Rule](#2-core-rule)
- [3. Failure Categories](#3-failure-categories)
  - [3.1. Validation Failure](#31-validation-failure)
  - [3.2. Authorization Denial](#32-authorization-denial)
  - [3.3. Business Rule Rejection](#33-business-rule-rejection)
  - [3.4. Conflict Or Concurrency Failure](#34-conflict-or-concurrency-failure)
  - [3.5. Dependency Failure](#35-dependency-failure)
  - [3.6. Unexpected Failure](#36-unexpected-failure)
- [4. Exception Classes](#4-exception-classes)
- [5. Domain And Application Exceptions](#5-domain-and-application-exceptions)
- [6. HTTP Translation](#6-http-translation)
- [7. User-Facing Messages](#7-user-facing-messages)
- [8. Logging Responsibility](#8-logging-responsibility)
- [9. Audit Versus Error Logging](#9-audit-versus-error-logging)
- [10. Fail-Closed Behavior](#10-fail-closed-behavior)
- [11. Fail-Open Behavior](#11-fail-open-behavior)
- [12. Broad Catch Rules](#12-broad-catch-rules)
- [13. External Dependencies](#13-external-dependencies)
- [14. Jobs And Commands](#14-jobs-and-commands)
- [15. Database Constraint Errors](#15-database-constraint-errors)
- [16. Security Incident Signals](#16-security-incident-signals)
- [17. Testing](#17-testing)
- [18. Stop Conditions](#18-stop-conditions)
- [19. Related](#19-related)

---

## 1. Purpose

Keep failures explicit, safe, observable, and useful without exposing secrets or internal implementation details.

---

## 2. Core Rule

A failure must have a clear category and owner.

The application should distinguish:

- expected business rejection
- authorization denial
- validation failure
- missing resource
- conflict or concurrency failure
- external dependency failure
- infrastructure failure
- unexpected programming error

Do not collapse unrelated failures into generic messages or boolean return values.

---

## 3. Failure Categories

### 3.1. Validation Failure

Use for malformed or incomplete input.

Owner:

- Form Request
- validator
- boundary DTO construction

Result:

- safe field-specific response
- no mutation
- no unnecessary error logging

### 3.2. Authorization Denial

Use when an authenticated or anonymous actor lacks permission.

Owner:

- policy
- gate
- middleware
- Core Access

Result:

- deny access
- avoid leaking whether protected resources exist when relevant
- audit or monitor sensitive denials when required

### 3.3. Business Rule Rejection

Use when input is valid but the requested operation is not allowed by the domain state.

Examples:

- account already deactivated
- export already completed
- assignment expired
- shipment cannot be changed after finalization

Use an explicit exception or result object.

### 3.4. Conflict Or Concurrency Failure

Use when current state changed or an operation conflicts with another operation.

Examples:

- stale version
- duplicate idempotency key
- unique constraint race
- locked resource

Return a safe conflict response where applicable.

### 3.5. Dependency Failure

Use when mail, storage, HTTP, queue, database, or another integration fails.

Preserve the original exception and translate only at an appropriate boundary.

### 3.6. Unexpected Failure

Unexpected failures must remain visible to logging and monitoring.

Do not catch and suppress programming errors.

---

## 4. Exception Classes

Use explicit exception classes when a failure category needs stable handling.

Examples:

- `AccessDenied`
- `ExportNotAllowed`
- `AssignmentExpired`
- `DuplicateWebhookDelivery`
- `RegistryKeyConflict`
- `ExternalServiceUnavailable`

Exception names should describe the problem, not the HTTP response.

Do not create one exception class for every message unless handling behavior differs.

---

## 5. Domain And Application Exceptions

Known domain/application exceptions should:

- contain safe structured context
- avoid raw secrets or restricted data
- expose a stable failure category
- support translation at HTTP, CLI, job, or API boundaries
- preserve cause when wrapping infrastructure exceptions

They should not directly render a response.

---

## 6. HTTP Translation

Translate application failures into HTTP responses at a centralized boundary where practical.

Examples:

- validation → `422`
- unauthenticated → `401`
- unauthorized → `403`
- missing resource → `404`
- conflict → `409`
- rate limit → `429`
- unexpected server failure → `500`

Do not expose stack traces, SQL, class names, tokens, paths, or internal exception messages to users.

---

## 7. User-Facing Messages

User-facing messages should be:

- safe
- clear
- specific enough to act on
- free of internal details
- compatible with later localization

Different internal failures may intentionally map to the same external message when disclosure would create a security risk.

---

## 8. Logging Responsibility

Log failures at the boundary that has enough context to act on them.

Avoid logging the same exception repeatedly at every layer.

A log should identify safe context such as:

- operation
- actor identifier
- target identifier
- scope
- request or correlation ID
- dependency
- retry state
- exception class

Do not log:

- passwords
- tokens
- secrets
- MFA material
- recovery codes
- authorization headers
- cookies
- private keys
- restricted payloads

---

## 9. Audit Versus Error Logging

Audit answers who did what and with what result.

Error logging answers what failed operationally.

A failed action may require both:

- audit event for the attempted security-sensitive action
- operational log for the infrastructure or application failure

Do not replace audit with ordinary logs.

Do not store operational stack traces in audit metadata.

---

## 10. Fail-Closed Behavior

Use fail-closed behavior for:

- authorization
- authentication
- MFA requirements
- recent-auth or elevation requirements
- tenant/workspace scope
- data classification
- export permission
- secret reveal
- webhook verification
- signed download validation

When the decision service fails, deny or halt unless a canonical standard explicitly defines another behavior.

---

## 11. Fail-Open Behavior

Fail-open behavior requires explicit documentation and justification.

Potential cases may include non-critical telemetry or optional analytics.

A fail-open path must state:

- why availability is more important than enforcement
- what data may be lost
- what monitoring applies
- what user impact exists
- why security is not weakened

---

## 12. Broad Catch Rules

Do not catch broad `Exception` or `Throwable` merely to continue.

A broad catch is acceptable only when it:

- forms a process boundary
- reports the failure
- performs required cleanup
- isolates one batch item from another
- implements documented fallback
- rethrows or records an explicit failure result

Do not use empty catch blocks.

---

## 13. External Dependencies

External calls should define:

- timeout
- retry behavior
- idempotency behavior
- safe error translation
- monitoring
- circuit or fallback behavior when needed
- sensitive payload handling

Do not keep database transactions open during slow external calls unless there is a documented reason.

---

## 14. Jobs And Commands

Jobs should throw on retryable failure so the queue can apply retry policy.

Permanent failures should be identified and handled intentionally.

Commands should:

- emit safe operator output
- use non-zero exit codes for failure
- avoid exposing secrets
- identify partial completion
- support dry-run for risky work when practical

---

## 15. Database Constraint Errors

Expected database constraint failures should be translated only when they represent a known race or business conflict.

Do not catch all database errors and report them as validation errors.

Unexpected database failures must remain observable.

---

## 16. Security Incident Signals

Certain failures may require monitoring or security notification:

- repeated login failures
- repeated MFA failures
- repeated denied access
- invalid webhook signatures
- expired or revoked token use
- restricted export attempts
- secret reveal failures
- cross-scope access attempts

Do not expose detection thresholds in user-facing messages.

---

## 17. Testing

Test:

- expected exception type
- safe external response
- correct status code
- authorization denial
- redaction
- logging or audit behavior where material
- retryable versus permanent failure
- transaction rollback
- fail-closed behavior

Do not assert only that “an exception occurred” when the category is part of the contract.

---

## 18. Stop Conditions

Stop before implementing error handling when:

- failure category is unclear
- a broad catch would hide multiple causes
- user-visible details may expose sensitive information
- fail-open versus fail-closed behavior is unresolved
- retryability is unknown
- duplicate logging is likely
- audit and operational logging responsibilities are confused

---

## 19. Related

- [Coding Standards](Coding%20Standards.md)
- [PHP And Laravel Style Standards](PHP%20And%20Laravel%20Style%20Standards.md)
- [Events Jobs And Queue Standards](Events%20Jobs%20And%20Queue%20Standards.md)
- [Transaction Concurrency And Idempotency Standards](Transaction%20Concurrency%20And%20Idempotency%20Standards.md)
- [Logging Standards](../logging/Logging%20Standards.md)
- [Coding Standards Index](index.md)