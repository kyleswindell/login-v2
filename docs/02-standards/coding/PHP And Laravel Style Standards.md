<!--
DOC-META
title: PHP And Laravel Style Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/PHP And Laravel Style Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines PHP and Laravel style requirements for strict types, native typing, dependency injection, container use, facades, configuration, time, exceptions, mass assignment, and framework conventions.
-->

# PHP And Laravel Style Standards

Parent: [Coding Standards Index](index.md)

This document defines PHP and Laravel-specific implementation standards for Login App 2.0.

- [1. Purpose](#1-purpose)
- [2. Strict Types](#2-strict-types)
- [3. Formatting](#3-formatting)
- [4. Native Types](#4-native-types)
- [5. Readonly And Immutability](#5-readonly-and-immutability)
- [6. Dependency Injection](#6-dependency-injection)
- [7. Service Container Use](#7-service-container-use)
- [8. Facades](#8-facades)
- [9. Configuration And Environment](#9-configuration-and-environment)
- [10. Request Data](#10-request-data)
- [11. Mass Assignment](#11-mass-assignment)
- [12. Arrays](#12-arrays)
- [13. Collections](#13-collections)
- [14. Date And Time](#14-date-and-time)
- [15. Exceptions](#15-exceptions)
- [16. Transactions](#16-transactions)
- [17. Models](#17-models)
- [18. Route And Controller Style](#18-route-and-controller-style)
- [19. User-Facing Strings](#19-user-facing-strings)
- [20. Static Analysis And Linting](#20-static-analysis-and-linting)
- [21. Stop Conditions](#21-stop-conditions)
- [22. Related](#22-related)

---

## 1. Purpose

Keep PHP code explicit, typed, testable, and aligned with Laravel conventions without allowing framework convenience to hide ownership or dependencies.

Use [Repository Naming Standards](repository-naming-standards.md) for folder, namespace, declared-type, Technical Role, delivery-artifact, configuration, route, test, and compatibility naming.

---

## 2. Strict Types

New PHP source files should use:

`declare(strict_types=1);`

Use strict types in:

- classes
- interfaces
- traits
- enums
- migrations
- seeders
- tests
- configuration-support PHP files when compatible

A missing strict-types declaration requires a documented framework or tooling constraint.

---

## 3. Formatting

Follow the repository’s configured formatter and existing Laravel conventions.

Rules:

- one class, interface, trait, or enum per source file
- explicit imports
- remove unused imports
- avoid fully qualified names inside method bodies when a normal import is clearer
- use trailing commas in multiline arrays and argument lists when supported
- keep methods focused
- avoid deeply nested conditionals
- use early returns when they improve readability
- do not mass-format unrelated files during scoped work

Do not introduce a new formatter or style tool without approval.

---

## 4. Native Types

Prefer native types for:

- method parameters
- return values
- properties
- constructor-promoted properties
- enum-backed values

Use PHPDoc only when native PHP cannot fully express:

- generic collection types
- array shapes
- template types
- framework magic
- conditional or covariant contracts

Avoid `mixed` when a more specific type is known.

Avoid nullable values when absence is not a valid state.

---

## 5. Readonly And Immutability

Prefer readonly or immutable state for:

- Data Objects
- value objects
- event payloads
- query criteria
- page-data objects
- stable configuration objects

Do not use immutability where framework hydration or persistence requires mutation, but keep mutation boundaries explicit.

---

## 6. Dependency Injection

Required collaborators should normally use constructor injection.

Prefer:

- explicit interfaces or classes
- constructor-promoted properties
- readonly collaborators where practical

Avoid:

- resolving services from the container inside business logic
- static service locators
- hidden global dependencies
- constructing infrastructure clients directly inside application services

Method injection is acceptable for framework-managed entry points when it keeps scope clear.

---

## 7. Service Container Use

Use the container to register and resolve application dependencies at framework boundaries.

Appropriate container use:

- service providers
- controllers
- commands
- jobs
- framework callbacks
- tests

Inappropriate container use:

- calling `app()` throughout domain/application logic
- resolving dependencies conditionally as hidden branches
- using the container to avoid defining a proper constructor contract

---

## 8. Facades

Laravel facades are acceptable at framework boundaries and for conventional Laravel integration.

Reusable Core, UI, or Module behavior should prefer explicit collaborators when:

- the dependency affects tests
- the dependency controls time
- the dependency performs I/O
- the dependency affects security
- the dependency has multiple implementations
- the behavior needs isolation

Do not ban facades mechanically. Use them intentionally.

---

## 9. Configuration And Environment

Read environment variables only from configuration files.

Application code must use `config()` rather than `env()`.

Rules:

- define clear config keys
- provide safe defaults when appropriate
- do not commit secrets
- do not use config files as runtime-editable settings
- document configuration that affects setup, deployment, security, or operations
- keep environment-specific behavior outside domain logic where practical

---

## 10. Request Data

Do not pass raw request payloads directly into models or services.

Use:

- Form Request validation
- `$request->validated()`
- DTO construction
- explicit field mapping
- normalized input objects

Do not use `$request->all()` for persistence.

---

## 11. Mass Assignment

Mass assignment must be intentional.

Rules:

- define allowed model attributes or explicit guarded behavior
- pass only validated, expected fields
- do not expose security, ownership, status, or audit fields to arbitrary assignment
- set server-owned values explicitly

Ownership and scope fields should not be trusted from unverified client input.

---

## 12. Arrays

Use arrays for genuinely flexible or local data.

Use a DTO, value object, enum, or typed object when:

- the shape crosses a boundary
- the shape is reused
- keys are stable
- static analysis would benefit
- the array has domain meaning
- mistakes in keys would be high-risk

Document array shapes with PHPDoc when arrays remain appropriate.

---

## 13. Collections

Use Laravel collections when they improve readability and remain bounded.

Do not:

- load large datasets only to transform them in memory
- hide N+1 queries inside collection callbacks
- use collections to avoid database filtering or aggregation
- return collections when a paginator, cursor, stream, or dedicated result object is more appropriate

---

## 14. Date And Time

Use consistent application time behavior.

Rules:

- use timezone-aware timestamps for events, security, audit, and operational records
- use Carbon or Laravel-supported date objects consistently
- freeze time in tests involving expiry, scheduling, retention, MFA, tokens, or lifecycle transitions
- avoid scattering direct current-time calls through logic that must be deterministic
- inject or centralize clock behavior when time control materially improves correctness

Do not use local machine timezone assumptions for persisted system events.

---

## 15. Exceptions

Use explicit exceptions for known failure categories.

Do not catch broad `Throwable` or `Exception` unless the code:

- translates the error at a boundary
- performs required cleanup
- records safe operational context
- retries or degrades intentionally
- rethrows or returns a documented result

Never swallow exceptions silently.

Preserve the original exception when wrapping infrastructure failures.

---

## 16. Transactions

Multi-write mutations should define transaction boundaries explicitly.

Rules:

- keep transaction scope focused
- avoid remote network calls inside database transactions when practical
- dispatch dependent events, notifications, or audit operations after commit when required
- do not report success before the transaction commits
- define failure and retry behavior

Use:

- [Transaction Concurrency And Idempotency Standards](Transaction%20Concurrency%20And%20Idempotency%20Standards.md)

---

## 17. Models

Follow Laravel model conventions while preserving ownership boundaries.

Rules:

- use casts for persistent type conversion
- use relationships for relational structure
- use scopes for reusable query constraints
- keep models from becoming broad workflow services
- protect mass assignment
- do not hide security-sensitive behavior in model events without explicit documentation

---

## 18. Route And Controller Style

Routes should:

- use stable names
- use appropriate HTTP verbs
- declare middleware intentionally
- avoid state-changing GET requests
- remain grouped by owner and security tier

Controllers should coordinate, not implement the full workflow.

---

## 19. User-Facing Strings

Do not expose internal exception messages, class names, SQL details, stack traces, secrets, or sensitive identifiers to users.

User-facing messages should be:

- clear
- safe
- actionable when possible
- localized later without requiring architectural rewrites

---

## 20. Static Analysis And Linting

Use existing repository tools when configured.

Potential checks include:

- Laravel Pint
- PHPStan or Larastan
- PHPUnit or Pest
- Blade formatting
- JavaScript/CSS linting
- documentation guardrails

Do not claim static analysis passed unless the configured command was run.

Do not introduce new tooling without explicit approval.

---

## 21. Stop Conditions

Stop before implementation when:

- a dependency cannot be injected cleanly
- environment and database-backed configuration are being mixed
- raw request input would control protected fields
- time behavior is ambiguous
- a broad exception catch would hide failures
- a transaction includes unsafe external side effects
- framework convenience would bypass Core/Platform/Module ownership

---

## 22. Related

- [Coding Standards](Coding%20Standards.md)
- [File Archetypes](File%20Archetypes.md)
- [Repository Naming Standards](repository-naming-standards.md)
- [Application Actions Services And Data Objects Standards](Application%20Actions%20Services%20And%20Data%20Objects%20Standards.md)
- [Error And Exception Handling Standards](Error%20And%20Exception%20Handling%20Standards.md)
- [Transaction Concurrency And Idempotency Standards](Transaction%20Concurrency%20And%20Idempotency%20Standards.md)
- [Coding Standards Index](index.md)