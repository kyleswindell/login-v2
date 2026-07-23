<!--
DOC-META
title: File Archetypes
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/File Archetypes.md
parent: docs/02-standards/coding/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines expected ownership, responsibilities, shape, verification, and stop conditions for common source, UI, database, test, and documentation file types.
-->

# File Archetypes

Parent: [Coding Standards Index](index.md)

This document defines the expected shape and responsibility of common files in Login App 2.0.

Use it before creating, moving, or materially refactoring a file.

- [1. Purpose](#1-purpose)
- [2. Core Rule](#2-core-rule)
- [3. Ownership Layers](#3-ownership-layers)
- [4. Shared PHP File Baseline](#4-shared-php-file-baseline)
- [5. Stub Availability](#5-stub-availability)
- [6. Controller](#6-controller)
  - [6.1. Owns](#61-owns)
  - [6.2. May Use](#62-may-use)
  - [6.3. Must Not Own](#63-must-not-own)
  - [6.4. Verification](#64-verification)
- [7. Form Request](#7-form-request)
  - [7.1. Owns](#71-owns)
  - [7.2. Must Not Own](#72-must-not-own)
  - [7.3. Required Characteristics](#73-required-characteristics)
  - [7.4. Verification](#74-verification)
- [8. Action](#8-action)
  - [8.1. Owns](#81-owns)
  - [8.2. Must Not Own](#82-must-not-own)
  - [8.3. Naming](#83-naming)
  - [8.4. Verification](#84-verification)
- [9. Service](#9-service)
  - [9.1. Owns](#91-owns)
  - [9.2. Must Not Become](#92-must-not-become)
  - [9.3. Placement](#93-placement)
- [10. Query Object](#10-query-object)
  - [10.1. Owns](#101-owns)
  - [10.2. Must Not Own](#102-must-not-own)
  - [10.3. Naming](#103-naming)
  - [10.4. Verification](#104-verification)
- [11. DTO](#11-dto)
  - [11.1. Appropriate Boundaries](#111-appropriate-boundaries)
  - [11.2. Rules](#112-rules)
- [12. Page Data Or View Model](#12-page-data-or-view-model)
  - [12.1. Owns](#121-owns)
  - [12.2. Must Not Own](#122-must-not-own)
- [13. Value Object](#13-value-object)
  - [13.1. Rules](#131-rules)
- [14. Enum](#14-enum)
- [15. Model](#15-model)
  - [15.1. May Own](#151-may-own)
  - [15.2. Must Not Own](#152-must-not-own)
- [16. Policy Or Gate](#16-policy-or-gate)
  - [16.1. Must Answer](#161-must-answer)
  - [16.2. Rules](#162-rules)
- [17. Middleware](#17-middleware)
- [18. Event](#18-event)
  - [18.1. Rules](#181-rules)
- [19. Listener](#19-listener)
  - [19.1. Rules](#191-rules)
- [20. Job](#20-job)
  - [20.1. Required Characteristics](#201-required-characteristics)
- [21. Console Command](#21-console-command)
  - [21.1. Rules](#211-rules)
- [22. Exception](#22-exception)
  - [22.1. Rules](#221-rules)
- [23. Service Provider](#23-service-provider)
  - [23.1. May Own](#231-may-own)
  - [23.2. Must Not Own](#232-must-not-own)
- [24. Configuration File](#24-configuration-file)
  - [24.1. Rules](#241-rules)
- [25. API Resource Or Serializer](#25-api-resource-or-serializer)
  - [25.1. Rules](#251-rules)
- [26. Migration](#26-migration)
- [27. Seeder](#27-seeder)
  - [27.1. Rules](#271-rules)
- [28. Factory](#28-factory)
  - [28.1. Rules](#281-rules)
- [29. Blade URL View](#29-blade-url-view)
  - [29.1. May Own](#291-may-own)
  - [29.2. Must Not Own](#292-must-not-own)
- [30. UI Primitive](#30-ui-primitive)
  - [30.1. Rules](#301-rules)
- [31. UI Pattern](#31-ui-pattern)
- [32. CSS File](#32-css-file)
- [33. JavaScript UI Control](#33-javascript-ui-control)
- [34. Feature Test](#34-feature-test)
- [35. Unit Test](#35-unit-test)
- [36. Browser Test](#36-browser-test)
- [37. Documentation File](#37-documentation-file)
- [38. Stop Conditions](#38-stop-conditions)
- [39. Related](#39-related)

---

## 1. Purpose

Give developers and Codex a deterministic way to answer:

- what kind of file is being created
- where it belongs
- what responsibility it may own
- what responsibility it must not own
- what tests or documentation must accompany it
- when implementation should stop for clarification

---

## 2. Core Rule

Before creating or changing a file, identify:

1. owning layer
2. file archetype
3. public or internal contract
4. allowed responsibilities
5. forbidden responsibilities
6. required dependencies
7. required verification
8. required documentation sync

Do not create a file simply because a similar filename exists elsewhere.

Use nearby files as implementation references only after confirming they represent the current architecture direction.

---

## 3. Ownership Layers

| Owner or integration boundary | Current location                                                    | Responsibility                                                                                                                |
| ----------------------------- | ------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------- |
| Core capability               | `app/Core/*`                                                        | Required base-application behavior, state, coordination, infrastructure, and contracts.                                      |
| Module                        | `Modules/*`                                                         | Optional, cohesive feature workflows and data.                                                                                |
| UI                            | `resources/views/components/*`, `resources/css/*`, `resources/js/*` | Reusable UI primitives, patterns, shell components, styling, behavior, contracts, and tests.                                 |
| Laravel integration           | Applicable Laravel framework locations                              | Application-wide bootstrap, registration, and thin framework adaptation.                                                     |
| Database                      | `database/*`                                                        | Migrations, seeders, and factories under the applicable application owner.                                                    |
| Tests                         | `tests/*`                                                           | Automated behavioral verification under the applicable application owner.                                                    |
| Documentation                 | `docs/*`                                                            | Canonical standards, architecture, behavior, flows, data contracts, planning, reference, and runbooks.                        |

After choosing an owner, classify the file's technical responsibility separately, such as Surface, Delivery Adapter, Registry, Action, Query, or Contract. Existing `app/Platform/*` paths are transitional current placement only, establish no target ownership, and are not a destination for new canonical work.

---

## 4. Shared PHP File Baseline

New PHP source files should generally:

- begin with `<?php`
- use `declare(strict_types=1);`
- declare the correct namespace
- use explicit imports
- use native parameter, property, and return types
- avoid broad file-header comments
- avoid unused imports
- avoid commented-out implementations
- preserve one primary responsibility
- follow existing repository formatting
- include PHPDoc only where native types cannot express the contract adequately

Exceptions require a documented framework or tooling reason.

---

## 5. Stub Availability

Approved source templates are maintained under `stubs/`.

| Archetype             | Stub                                          |
| --------------------- | --------------------------------------------- |
| Action                | `stubs/archetypes/action.stub`                |
| Service               | `stubs/archetypes/service.stub`               |
| Query                 | `stubs/archetypes/query.stub`                 |
| DTO                   | `stubs/archetypes/dto.stub`                   |
| Page data             | `stubs/archetypes/page-data.stub`             |
| Value object          | `stubs/archetypes/value-object.stub`          |
| Enum                  | `stubs/archetypes/enum.stub`                  |
| Result                | `stubs/archetypes/result.stub`                |
| Application exception | `stubs/archetypes/application-exception.stub` |

Framework-bound files, tests, and UI bundles have additional templates documented in [`stubs/README.md`](../../../stubs/README.md).

The presence of a stub does not make an archetype appropriate. Select the archetype from the file’s responsibility first, then use the corresponding template.

---

## 6. Controller

### 6.1. Owns

- request coordination
- invoking validated application behavior
- returning responses, redirects, views, or resources
- route-specific response decisions

### 6.2. May Use

- Form Requests
- policies and gates
- actions
- services
- query objects
- page-data or view-model objects
- API resources

### 6.3. Must Not Own

- reusable business rules
- complex validation
- hidden authorization
- large query construction
- cross-system transactions
- audit or notification rules that exist nowhere else

### 6.4. Verification

- route access
- successful response
- validation failure
- authorization denial
- expected persistence or side effects

---

## 7. Form Request

### 7.1. Owns

- request validation
- request-specific authorization when appropriate
- validated input normalization that belongs at the HTTP boundary

### 7.2. Must Not Own

- business workflows
- database transactions
- notification delivery
- audit pipelines
- unrelated service orchestration

### 7.3. Required Characteristics

- explicit rules
- explicit authorization behavior
- safe validation messages
- protection against cross-scope IDs
- file validation when uploads are accepted

### 7.4. Verification

- valid input
- invalid input
- unauthorized input
- boundary values
- tenant or workspace scope where applicable

---

## 8. Action

An action represents one command-style operation.

Examples:

- invite a user
- assign a role
- revoke an API token
- create a shipment
- request a protected export

### 8.1. Owns

- one mutation or business operation
- transaction coordination for that operation
- calling policies, services, audit, notifications, or events as required

### 8.2. Must Not Own

- unrelated commands
- broad read-model construction
- controller response formatting
- persistent global state

### 8.3. Naming

Use verb-oriented names:

- `InviteUser`
- `AssignRole`
- `RevokeServiceAccountToken`
- `RequestCustomerExport`

### 8.4. Verification

Test success, expected rejection, transaction behavior, and required side effects.

---

## 9. Service

A service owns reusable behavior for a capability, surface, or module.

### 9.1. Owns

- reusable application behavior
- coordination across focused collaborators
- capability-level rules that do not fit one command-style action

### 9.2. Must Not Become

- a generic utility dumping ground
- an unbounded “manager” class
- a replacement for policies, DTOs, queries, or actions
- a hidden service locator

### 9.3. Placement

Place the service under the layer that owns the behavior.

Do not place new canonical services under transitional `app/Platform/`; place them with the owning Core capability or Module.

---

## 10. Query Object

A query object owns a reusable or complex read.

### 10.1. Owns

- one query intent
- eager-loading decisions
- filters
- sorting
- pagination or bounded result behavior
- read-side projections

### 10.2. Must Not Own

- mutations
- authorization truth
- notification or audit side effects
- unrelated query modes

### 10.3. Naming

Use result- or intent-oriented names:

- `ListPlatformUsers`
- `FindEffectiveAccess`
- `GetSecurityReadinessSummary`
- `SearchCustomerOrders`

### 10.4. Verification

Test filtering, ordering, scope, empty results, access boundaries, and pagination.

---

## 11. DTO

A data transfer object describes data crossing a boundary.

### 11.1. Appropriate Boundaries

- controller to action
- action to service
- service to event
- query to renderer
- integration payload to application
- application to API resource

### 11.2. Rules

- prefer immutable or readonly state
- use explicit property types
- validate or construct from trusted normalized input
- avoid embedding service behavior
- avoid becoming an alternate model
- avoid loosely typed arrays when a stable shape exists

---

## 12. Page Data Or View Model

A page-data object prepares a stable read contract for a view.

### 12.1. Owns

- display-ready values
- grouped view state
- labels and safe presentation metadata
- pagination/filter state
- already-authorized actions or capabilities

### 12.2. Must Not Own

- database mutation
- authorization policy truth
- route behavior
- HTML generation
- hidden service resolution

URL views should consume page data rather than building complex application state directly.

---

## 13. Value Object

A value object represents a meaningful concept and enforces an invariant.

Examples:

- email address
- permission key
- money amount
- date range
- registry key
- export reason

### 13.1. Rules

- prefer immutable state
- validate during construction
- compare by value
- avoid database or framework dependencies unless necessary
- do not create value objects for simple values with no meaningful invariant

---

## 14. Enum

Use an enum for stable application-controlled choices.

Appropriate uses:

- lifecycle states
- result types
- risk levels
- actor types
- trust decisions

Do not use an enum for:

- user-configurable choices
- registry-managed values
- values expected to change without a deployment
- database records requiring labels, ordering, ownership, or metadata

Enums must be documented when they define a durable behavior contract.

---

## 15. Model

A model represents persistence, relationships, casts, and record-oriented behavior.

### 15.1. May Own

- relationships
- casts
- scopes
- accessors and mutators
- small persistence-related invariants
- lifecycle helpers closely tied to the record

### 15.2. Must Not Own

- broad workflows
- controller behavior
- cross-capability orchestration
- authorization decisions that belong in policies
- view preparation
- unrelated service behavior

Mass assignment must use explicit allowed attributes or intentional guarded behavior.

Do not pass raw request arrays directly to model creation or update methods.

---

## 16. Policy Or Gate

A policy or gate owns an authorization decision.

### 16.1. Must Answer

- who is acting
- what action is requested
- which target is affected
- which scope applies
- why access is allowed or denied

### 16.2. Rules

- test allowed and denied paths
- avoid role-name checks scattered across the application
- use Core Access where broader effective-access resolution is required
- do not rely on hidden UI controls as authorization

---

## 17. Middleware

Middleware owns request-level cross-cutting behavior.

Appropriate uses:

- authentication
- MFA or recent-auth requirements
- elevation requirements
- tenant/workspace context
- security headers
- rate limiting
- trusted proxy configuration
- route-tier enforcement

Middleware must not own business workflows or persistence-heavy feature behavior.

---

## 18. Event

An event describes something that happened.

### 18.1. Rules

- use past-tense or completed-action meaning
- use explicit stable event keys when persisted or audited
- keep payloads minimal
- avoid passing full models when stable identifiers or DTOs are safer
- avoid sensitive payloads
- dispatch after commit when listeners depend on committed data

Examples:

- `UserInvited`
- `RoleAssigned`
- `ExportRequested`
- `NotificationCreated`

---

## 19. Listener

A listener reacts to an event.

### 19.1. Rules

- own one reaction
- remain idempotent when repeat delivery is possible
- queue expensive or external work
- avoid changing the original transaction unexpectedly
- log and monitor meaningful failures
- avoid hidden security-sensitive behavior

---

## 20. Job

A job owns retryable or asynchronous work.

### 20.1. Required Characteristics

- idempotent behavior
- bounded payload
- explicit timeout
- explicit retry/backoff strategy
- safe failure behavior
- no raw secrets in serialized payloads
- observable failure path
- clear ownership

Test duplicate execution and failure behavior when the job is important.

---

## 21. Console Command

A command owns an operator or scheduled CLI workflow.

### 21.1. Rules

- parse and validate input
- call services/actions rather than duplicate business logic
- use clear exit codes
- provide safe output
- avoid printing secrets
- support dry-run mode for risky operations when practical
- document operational use in a runbook when repeated

---

## 22. Exception

An exception represents a known failure category or unexpected failure.

### 22.1. Rules

- use explicit exception classes for known domain/application failures
- preserve the original exception when translating infrastructure failures
- do not expose sensitive internal details to users
- do not use exceptions for normal branching when a result type is clearer
- centralize HTTP translation where practical

---

## 23. Service Provider

A service provider registers framework bindings and boots integrations.

### 23.1. May Own

- container bindings
- event registration
- policy registration
- package/framework bootstrapping
- configuration integration

### 23.2. Must Not Own

- business workflows
- data backfills
- request-specific behavior
- expensive runtime work during every request

---

## 24. Configuration File

Configuration files define environment-resolved application configuration.

### 24.1. Rules

- environment variables are read in config files
- application code uses `config()`
- defaults are explicit
- secrets are not committed
- config keys are stable and documented
- configuration does not replace database-backed settings when runtime editing is required

---

## 25. API Resource Or Serializer

An API resource controls externally exposed fields.

### 25.1. Rules

- expose only intentional fields
- respect permissions and data classification
- avoid serializing complete models automatically
- use stable response shapes
- document versioning and compatibility expectations
- redact or omit confidential and restricted fields

---

## 26. Migration

A migration owns one coherent schema or data transition.

Use:

- [Database Migration Standards](../database/Database%20Migration%20Standards.md)
- [Schema Design Standards](../database/Schema%20Design%20Standards.md)

Do not combine unrelated schema changes.

Do not perform destructive changes without an explicit safety and recovery plan.

---

## 27. Seeder

A seeder creates deterministic baseline, registry, permission, or development data.

### 27.1. Rules

- safe to rerun
- stable keys
- no real secrets
- no production customer data
- no hidden business behavior
- explicit environment expectations

---

## 28. Factory

A factory creates synthetic test or development records.

### 28.1. Rules

- generate valid defaults
- allow explicit state overrides
- avoid accidental external side effects
- avoid real personal or secret data
- keep scoped ownership explicit

---

## 29. Blade URL View

A URL view composes a page.

### 29.1. May Own

- layouts
- shell components
- patterns
- UI primitives
- display-ready page data
- safe conditional rendering

### 29.2. Must Not Own

- database queries
- business mutations
- authorization truth
- audit dispatching
- complex data transformation

Use required Blade file-header and section comments.

---

## 30. UI Primitive

A UI primitive is a domain-free baseline component.

### 30.1. Rules

- no routes
- no database access
- no auth or policy logic
- no business terminology
- public props and slots documented in `contract.php`
- reference behavior documented in `reference.php`
- Blade, CSS, JS, tests, contract, and reference kept aligned
- required file/header comments present

Manual visual review is required for design-sensitive changes.

---

## 31. UI Pattern

A UI pattern composes primitives into a reusable workflow or layout structure.

Patterns may own reusable composition but must not become generic containers for domain behavior.

Patterns must not redefine primitive APIs or styling.

---

## 32. CSS File

CSS should live under the correct base, token, component, pattern, shell, or reference owner.

Rules:

- use required file/header comments
- use meaningful section comments
- prefer tokens
- avoid broad global selectors for local problems
- avoid one-off values when an existing token applies
- keep component and pattern styling aligned with the corresponding Blade contract

---

## 33. JavaScript UI Control

A UI control enhances Blade/CSS behavior.

Rules:

- small and focused
- idempotent initialization
- safe when initialized more than once
- scoped selectors or data attributes
- no authorization truth
- no hidden business policy
- accessible keyboard and state behavior
- aligned with component contracts and manual review

---

## 34. Feature Test

A feature test verifies externally meaningful application behavior.

Use for:

- routes
- middleware
- policies
- persistence
- workflows
- jobs and events
- rendered responses
- allowed and denied access

Feature tests should use PostgreSQL when behavior depends on PostgreSQL semantics.

---

## 35. Unit Test

A unit test verifies isolated behavior.

Use for:

- value objects
- enums
- resolvers
- pure services
- policies
- formatters
- query-building decisions that can be isolated safely

Do not over-mock the behavior being tested.

---

## 36. Browser Test

A browser test verifies real interactive behavior.

Use for:

- JavaScript interaction
- form workflows
- modal/dialog behavior
- focus management
- navigation
- critical visual-state regressions

Browser tests do not replace manual visual approval.

---

## 37. Documentation File

New or materially rewritten docs must:

- include `DOC-META`
- use the correct template
- live under the correct canonical branch
- link to a parent/index
- update affected indexes
- use portable Markdown links
- avoid duplicated canonical truth

---

## 38. Stop Conditions

Stop before creating or moving a file when:

- the owning layer is unclear
- two archetypes appear equally valid
- the file would cross Core, Module, UI, or Laravel integration boundaries
- a new abstraction has no repeated use
- a design-sensitive UI decision is unspecified
- a schema/security/data boundary is unresolved
- required tests cannot be identified
- the change would overwrite unrelated work

---

## 39. Related

- [Coding Standards](Coding%20Standards.md)
- [File Building Standards](File%20Building%20Standards.md)
- [Commenting Standards](Commenting%20Standards.md)
- [Testing Standards](Testing%20Standards.md)
- [Agent Implementation Checklist](Agent%20Implementation%20Checklist.md)
- [Coding Standards Index](index.md)
