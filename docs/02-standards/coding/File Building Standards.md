<!--
DOC-META
title: File Building Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/File Building Standards.md
parent: docs/02-standards/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines file ownership, file shape, layer placement, and construction expectations for source, view, style, script, database, test, and documentation files.
-->

# File Building Standards

This document defines how files should be placed, shaped, scoped, and reviewed in Login App 2.0.
- [1. Purpose](#1-purpose)
- [2. Core Rule](#2-core-rule)
- [3. Application Structure](#3-application-structure)
- [4. File Responsibility](#4-file-responsibility)
- [5. Starting From An Approved Stub](#5-starting-from-an-approved-stub)
- [6. Controllers](#6-controllers)
- [7. Form Requests](#7-form-requests)
- [8. Services And Actions](#8-services-and-actions)
- [9. Models](#9-models)
- [10. Policies And Gates](#10-policies-and-gates)
- [11. Middleware](#11-middleware)
- [12. Events, Listeners, Jobs, And Commands](#12-events-listeners-jobs-and-commands)
- [13. Views](#13-views)
- [14. CSS](#14-css)
- [15. JavaScript](#15-javascript)
- [16. Migrations](#16-migrations)
- [17. Seeders](#17-seeders)
- [18. Tests](#18-tests)
- [19. Documentation Files](#19-documentation-files)
- [20. File Archetypes](#20-file-archetypes)
- [21. Related](#21-related)

---

## 1. Purpose

Ensure files are built in the correct layer, with the correct responsibility, and with enough structure for developers and Codex agents to work safely during the refactor.

---

## 2. Core Rule

Before creating or moving a file, identify:

1. the owner layer
2. the file type
3. the canonical responsibility
4. the public contract
5. related tests
6. related documentation
7. stop conditions

If the owner or responsibility is unclear, do not create the file yet.

---

## 3. Application Structure

Use Laravel defaults unless the project has a documented reason to create a clearer ownership boundary.

Current ownership direction:

| Owner                 | Location                       |
| --------------------- | ------------------------------ |
| Core Capability       | `app/Core/*`                   |
| Platform Surface      | `app/Platform/*`               |
| Business Module       | `Modules/*`                    |
| Shared UI Components  | `resources/views/components/*` |
| Shared UI CSS         | `resources/css/*`              |
| Shared UI JS Controls | `resources/js/*`               |
| Documentation         | `docs/*`                       |
| Tests                 | `tests/*`                      |
| Stubs                 | `stubs/*`                      |

Do not create new top-level application folders without explicit approval or planning documentation.

---

## 4. File Responsibility

A file should have one primary reason to exist.

Avoid files that mix:

- routing and business logic
- validation and persistence
- authorization and rendering
- UI composition and domain mutation
- schema definition and data migration decisions
- documentation standards and planning backlog
- tests for unrelated capabilities

When a file grows to own multiple responsibilities, split by owner and purpose.

---

## 5. Starting From An Approved Stub

Before creating a new file, check whether an approved template exists under `stubs/`.

Use the closest matching stub when:

- the destination file matches the documented archetype
- the stub reflects the current framework and project conventions
- its generated structure is appropriate for the required responsibility

After copying or generating from a stub:

1. Replace every placeholder.
2. Remove optional sections that do not apply.
3. Add the file’s actual types, dependencies, contract, and behavior.
4. Confirm that no unresolved template tokens remain.
5. Format and validate the rendered file.
6. Run the applicable tests and build checks.

A generated file must not retain placeholder behavior, meaningless assertions, speculative methods, or comments that no longer describe the implementation.

Do not force a file into an unsuitable stub. Create the file directly when no approved archetype applies, then determine whether the resulting repeated shape justifies a new template.

## 6. Controllers

Controllers coordinate requests and responses.

Expected shape:

- receive request
- rely on middleware/policies/gates for authorization
- use Form Requests for validation when non-trivial
- call service/action/query/view-model objects
- return response/view/redirect/resource

Controllers should not own reusable business rules.

If a controller action needs a long explanation, move the behavior into a named service, action, query, policy, or form request and document that contract there.

---

## 7. Form Requests

Use Form Requests for validation that is:

- non-trivial
- reused
- security-sensitive
- data-boundary-sensitive
- likely to grow
- tied to file uploads, exports, IDs, or scoped resources

Form Requests may also clarify authorization when route-level checks are not enough.

Do not use Form Requests to hide business workflows that belong in services/actions.

---

## 8. Services And Actions

Use services or actions for reusable application behavior.

Place them under the owning layer:

- Core service for Core capability behavior
- Platform service for Platform surface/aggregation behavior
- Module service for Business Module behavior

Services/actions should:

- express one capability or workflow
- receive validated inputs
- enforce or call relevant authorization where appropriate
- handle transactions when needed
- emit audit/notification/events through owning Core capabilities
- be testable without a controller when practical

---

## 9. Models

Models should represent persistence and relationships.

Models may contain:

- casts
- relationships
- scopes
- accessors/mutators when appropriate
- simple persistence-related helpers

Models should not become broad service containers for workflows, authorization, rendering, or cross-cutting behavior.

---

## 10. Policies And Gates

Use policies/gates for authorization decisions.

Policies should be:

- explicit
- testable
- close to the resource/capability
- aware of tenant/workspace/resource scope when applicable

Do not hide permission decisions in Blade conditionals or controller branches only.

---

## 11. Middleware

Use middleware for request-level concerns such as:

- authentication
- MFA/recent-auth/elevation checks
- tenant/workspace context
- route tier checks
- security headers
- rate limits
- trusted proxy/context setup

Middleware should not own business workflows.

---

## 12. Events, Listeners, Jobs, And Commands

Use events for “something happened” signals.

Use listeners/jobs for asynchronous or side-effect behavior.

Use commands for CLI/operator workflows.

These files should:

- have explicit names
- avoid hidden coupling
- be idempotent when retried
- log/audit meaningful failures
- avoid leaking secrets or sensitive data
- be covered by tests when behavior is critical

---

## 13. Views

URL views should be thin.

Blade views may compose:

- layouts
- shell components
- patterns
- UI primitives
- view models or page data
- validated display data

Blade views must not own:

- authorization truth
- business mutations
- database query workflows
- audit dispatching
- data-protection decisions

Use comments sparingly. Shared UI Blade files may use required file/header comments and section comments when they clarify component ownership.

Do not leave commented-out markup or alternate implementations in templates.

---

## 14. CSS

CSS files should be placed by owner:

- base/reset/layer rules in base CSS folders
- tokens in token folders
- component CSS in component folders
- pattern CSS in pattern folders
- reference-only CSS in reference folders

Do not add broad global selectors to fix local component issues.

Do not bypass tokens for color, spacing, typography, motion, shadow, or z-index unless explicitly approved.

CSS files in the UI system should include required file/header comments and useful section comments.

---

## 15. JavaScript

JavaScript should enhance existing Blade/CSS behavior.

JS controls should be:

- small
- idempotent
- safe to initialize more than once
- scoped to clear selectors/data attributes
- separated from domain authorization or business policy
- covered by manual or automated verification when behavior matters

Do not introduce framework drift without approval.

---

## 16. Migrations

Migrations must be scoped and intentional.

Migrations should:

- use clear table and column names
- avoid destructive changes without explicit approval
- include indexes/constraints when needed
- consider rollback where practical
- avoid hiding data corrections in schema-only migrations
- be reflected in `docs/06-database/` when schema contracts change

---

## 17. Seeders

Seeders should create required baseline data, registries, permissions, and local/demo data only when appropriate.

Seeders must not hide behavior that belongs in application logic.

Permission/registry seeders should be deterministic and safe to rerun.

---

## 18. Tests

Tests should be placed by behavior type and owner.

Use:

- feature tests for user-visible workflows, route behavior, authorization, persistence, and integration behavior
- unit tests for isolated services, value objects, resolvers, policies, and utilities
- browser tests for real UI behavior when needed
- UI/component tests for component contracts and render states when applicable

Test names should describe behavior.

Do not delete or weaken tests to pass a task.

---

## 19. Documentation Files

New or materially rewritten docs must:

- include a `DOC-META` header
- use the correct template
- live under the correct canonical owner
- link to parent/index documents
- update indexes when added, moved, split, archived, or superseded

Use:

- [How To Write Docs](../documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](../documentation/Doc%20Governance.md)

---

## 20. File Archetypes

Detailed file archetype rules should live in a dedicated file archetype standard when created.

Until then, use this standard plus nearby existing files as the local shape reference.

Do not invent new file shapes when a nearby convention already exists.

---

## 21. Related

- [Coding Standards](Coding%20Standards.md)
- [Commenting Standards](Commenting%20Standards.md)
- [Testing Standards](Testing%20Standards.md)
- [How To Write Docs](../documentation/How%20To%20Write%20Docs.md)
- [Doc Governance](../documentation/Doc%20Governance.md)
- [Standards Index](../index.md)