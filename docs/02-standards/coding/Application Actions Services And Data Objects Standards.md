<!--
DOC-META
title: Application Actions Services And Data Objects Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/Application Actions Services And Data Objects Standards.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines responsibilities and boundaries for actions, services, query objects, DTOs, page-data objects, value objects, enums, and related application-layer classes.
-->

# Application Actions Services And Data Objects Standards

Parent: [Coding Standards Index](index.md)

This document defines the application-object patterns used to keep controllers, models, views, and jobs focused.

- [1. Purpose](#1-purpose)
- [2. Core Rule](#2-core-rule)
- [3. Placement](#3-placement)
- [4. Actions](#4-actions)
  - [4.1. Action Characteristics](#41-action-characteristics)
  - [4.2. Actions Must Not](#42-actions-must-not)
- [5. Services](#5-services)
- [6. Query Objects](#6-query-objects)
- [7. DTOs](#7-dtos)
- [8. Page-Data Objects](#8-page-data-objects)
- [9. Value Objects](#9-value-objects)
- [10. Enums](#10-enums)
- [11. Result Objects](#11-result-objects)
- [12. Constructor Rules](#12-constructor-rules)
- [13. Input Rules](#13-input-rules)
- [14. Output Rules](#14-output-rules)
- [15. Authorization](#15-authorization)
- [16. Transactions](#16-transactions)
- [17. Audit And Notifications](#17-audit-and-notifications)
- [18. Error Behavior](#18-error-behavior)
- [19. Testing](#19-testing)
- [20. Stop Conditions](#20-stop-conditions)
- [21. Related](#21-related)

---

## 1. Purpose

Provide clear distinctions between:

- actions
- services
- query objects
- DTOs
- page-data objects
- value objects
- enums
- result objects

These patterns should make ownership and contracts explicit without creating unnecessary abstraction.

---

## 2. Core Rule

Create an application object only when it owns a meaningful, named responsibility.

Do not create classes solely to move lines out of another file.

Each object must have:

- one clear owner
- one clear purpose
- explicit inputs
- explicit outputs
- defined side effects
- defined failure behavior
- testable behavior when material

---

## 3. Placement

Place application objects under the layer that owns the behavior.

Examples:

- Core Auth action under `app/Core/Auth/`
- Core Access resolver under `app/Core/Access/`
- Platform Navigation builder under `app/Platform/Navigation/`
- Orders query under `Modules/Orders/`
- UI page data under the owning surface or module

Do not put all reusable objects under `app/Platform/`.

---

## 4. Actions

An action represents one command-style operation.

Examples:

- invite a user
- suspend an account
- assign a role
- rotate a secret
- request an export
- create a shipment

### 4.1. Action Characteristics

An action should:

- have a verb-oriented name
- accept validated or typed input
- perform one primary operation
- define its transaction boundary
- authorize or require authorization before mutation
- call audit, notifications, or events through their owners
- return an explicit result when the caller needs one

### 4.2. Actions Must Not

- implement unrelated operations
- own complex reusable read queries
- return controller responses
- read raw request data
- become generic service containers

---

## 5. Services

A service owns reusable capability behavior that does not fit one command-style operation.

Appropriate uses:

- effective access resolution
- audit event recording
- notification delivery decisions
- registry aggregation
- data classification decisions
- integration coordination

A service should remain cohesive.

Avoid broad names such as:

- `HelperService`
- `GeneralService`
- `CommonManager`
- `UtilityService`

Prefer names that identify the behavior:

- `EffectiveAccessResolver`
- `AuditEventRecorder`
- `NotificationDeliveryResolver`
- `PlatformNavigationBuilder`

---

## 6. Query Objects

A query object owns a reusable or complex read.

Use a query object when:

- filtering is substantial
- scope rules matter
- eager loading must be controlled
- pagination is required
- multiple callers need the same read
- a controller or Livewire component would otherwise build a large query

Query objects should not mutate data.

Authorization must occur before or as part of the query boundary according to the owner’s rules.

---

## 7. DTOs

A DTO defines a stable data shape crossing a boundary.

DTOs should:

- use explicit types
- prefer readonly properties
- be constructed from validated or trusted input
- avoid framework-specific behavior unless the boundary requires it
- avoid database persistence behavior
- avoid service resolution
- avoid hidden lazy loading

DTOs are useful when associative arrays would create fragile key-based contracts.

---

## 8. Page-Data Objects

A page-data object prepares data for one page or renderer.

It may include:

- display-ready values
- safe labels
- filters
- pagination metadata
- capability flags
- allowed actions
- section data
- already-redacted values

It must not:

- mutate data
- query the database lazily from Blade
- own authorization policy truth
- render HTML
- resolve services from the container

---

## 9. Value Objects

Use a value object when a value has a meaningful invariant or behavior.

Examples:

- permission key
- registry key
- money amount
- date range
- email address
- export purpose
- data-classification value

Value objects should:

- be immutable
- validate construction
- normalize intentionally
- compare by value
- expose domain-relevant operations only

Do not create value objects for every primitive value.

---

## 10. Enums

Use enums for stable code-controlled choices.

Enums are appropriate for:

- actor types
- lifecycle states
- trust decisions
- risk levels
- operation results
- fixed system categories

Enums are not appropriate when values:

- are user-configurable
- come from a registry
- require database-managed labels or ordering
- change without deployment
- require tenant-specific configuration

---

## 11. Result Objects

Use a result object when an operation can complete with several expected outcomes that are not exceptional.

A result may identify:

- success
- denied
- skipped
- duplicate
- expired
- validation-like business rejection
- follow-up requirement

Do not use result objects to hide unexpected errors that should be exceptions.

---

## 12. Constructor Rules

Constructors should establish valid object state.

Rules:

- inject required collaborators
- use readonly collaborators where practical
- avoid performing I/O
- avoid database queries
- avoid dispatching events
- avoid hidden container resolution
- fail early for invalid value-object state

---

## 13. Input Rules

Application objects should receive:

- validated scalar values
- DTOs
- value objects
- explicit models when record identity is already verified
- typed criteria objects

Avoid receiving:

- raw requests
- complete unfiltered arrays
- loosely defined mixed payloads
- global state
- session state inside reusable capability logic

---

## 14. Output Rules

Return the narrowest useful result.

Appropriate outputs:

- void
- model or entity
- DTO
- page-data object
- paginator
- collection with documented item type
- result object
- scalar or enum when sufficient

Do not return framework responses from reusable application objects.

---

## 15. Authorization

Authorization must occur before protected mutation or disclosure.

The action/service may:

- receive an already-authorized actor and target
- call a policy or gate
- call Core Access
- require an authorization context object

Do not make authorization optional through a nullable actor unless anonymous behavior is explicitly part of the contract.

---

## 16. Transactions

The object that owns the mutation should normally own the transaction boundary.

Do not distribute one logical transaction across controllers, listeners, and unrelated services without a clear coordinator.

Audit, events, jobs, and notifications that depend on committed state should respect after-commit behavior.

---

## 17. Audit And Notifications

Application objects should call capability-owned interfaces or services.

Do not:

- insert audit rows directly from every module
- create module-specific notification delivery infrastructure
- duplicate security redaction rules
- dispatch notifications before the underlying transaction is durable when that creates inconsistency

---

## 18. Error Behavior

Known business failures should use:

- explicit exceptions
- explicit result objects
- validation failures at the appropriate boundary

Unexpected infrastructure failures should remain visible to logging and monitoring.

Do not return `false` for multiple unrelated failure conditions.

---

## 19. Testing

Test objects according to their responsibility.

Actions:

- success
- authorization rejection
- transaction rollback
- required audit/events/notifications

Services:

- important decision branches
- boundary conditions
- failure behavior

DTOs/value objects/enums:

- construction
- normalization
- invalid states
- serialization when relevant

Query objects:

- scope
- filtering
- ordering
- pagination
- eager loading where material

---

## 20. Stop Conditions

Stop before creating an object when:

- it has no clear owner
- it duplicates an existing object
- its only purpose is shortening another file
- action versus service responsibility is unclear
- array shape remains unstable
- authorization ownership is unresolved
- transaction ownership is unresolved
- it would create a generic utility layer

---

## 21. Related

- [File Archetypes](File%20Archetypes.md)
- [PHP And Laravel Style Standards](PHP%20And%20Laravel%20Style%20Standards.md)
- [Transaction Concurrency And Idempotency Standards](Transaction%20Concurrency%20And%20Idempotency%20Standards.md)
- [Error And Exception Handling Standards](Error%20And%20Exception%20Handling%20Standards.md)
- [Coding Standards Index](index.md)