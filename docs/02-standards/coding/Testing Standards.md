<!--
DOC-META
title: Testing Standards
doc_type: standard
status: active
owner: docs
canonical: true
canonical_path: docs/02-standards/coding/Testing Standards.md
parent: docs/02-standards/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines testing expectations for Core capabilities, Modules, UI, Laravel integration, owner-specific technical responsibilities, security boundaries, documentation, and manual review.
-->

# Testing Standards

This document defines testing and verification expectations for Login App 2.0.
- [1. Purpose](#1-purpose)
- [2. Core Rule](#2-core-rule)
  - [2.1. Verification-First Contract](#21-verification-first-contract)
- [3. Current Testing Direction](#3-current-testing-direction)
- [4. Test Types](#4-test-types)
- [5. Test Templates](#5-test-templates)
- [6. Required Test Coverage Areas](#6-required-test-coverage-areas)
- [7. Core Capability Testing](#7-core-capability-testing)
- [8. Product Presentation, Frame Surface, Delivery Adapter, And Registry Testing](#8-product-presentation-frame-surface-delivery-adapter-and-registry-testing)
- [9. Module Testing](#9-module-testing)
- [10. UI Testing](#10-ui-testing)
- [11. Database And Migration Testing](#11-database-and-migration-testing)
- [12. Security Testing](#12-security-testing)
- [13. Documentation Verification](#13-documentation-verification)
- [14. Manual Verification](#14-manual-verification)
- [15. Test Naming](#15-test-naming)
- [16. Test Data](#16-test-data)
- [17. Failing Tests](#17-failing-tests)
- [18. Work Summary Expectations](#18-work-summary-expectations)
- [19. Related](#19-related)

---

## 1. Purpose

Ensure code, documentation, security boundaries, UI behavior, and refactor work are verified with the narrowest reliable proof.

---

## 2. Core Rule

Every behavior change needs verification.

Verification may be automated, manual, or both, but it must be stated clearly in the work summary or PR.

Do not claim tests passed unless they were run successfully.

If tests cannot be run, state why and identify the minimum verification command or manual review still needed.

### 2.1. Verification-First Contract

Before production implementation, map each acceptance criterion to an automated, manual, browser, documentation, native-platform, or specialist proof.

Record observable success and rejection behavior, fixtures and actors, environment, exact command or procedure, expected initial result, required final result, protected baseline, non-goals, and review authority.

Use characterization tests when accepted current behavior must be preserved. For new or corrected behavior, use the smallest proof that executes correctly and demonstrates the exact missing behavior. Only the predeclared missing-behavior result may be treated as expected nonpass.

Syntax, fixture, dependency, application-boot, discovery, tooling, database, and environment failures are failures. They are not expected nonpass.

Protect accepted tests and fixtures from weakening, skipping, deletion, or material rewrite without an accepted verification-contract revision. The same targeted proof must pass unchanged after implementation.

---

## 3. Current Testing Direction

This repo has automated tests and should continue expanding coverage around critical flows.

Prefer automated tests for:

- auth
- MFA
- access control
- user lifecycle
- audit
- monitoring
- notifications
- settings/preferences
- security headers
- route authorization
- data boundaries
- exports/downloads
- UI component contracts
- module registry/contribution behavior
- business workflows as modules are introduced

Manual verification remains required for design-sensitive UI, visual spacing, layout hierarchy, and workflows that do not yet have automated coverage.

---

## 4. Test Types

| Type                 | Use For                                                                                                             |
| -------------------- | ------------------------------------------------------------------------------------------------------------------- |
| Unit tests           | Isolated services, value objects, resolvers, policies, helpers, and pure logic.                                     |
| Feature tests        | Routes, controllers, middleware, auth/access behavior, persistence, jobs/events, and user-visible workflows.        |
| Browser tests        | Real UI behavior, interactive flows, JavaScript behavior, visual review support, and regression-sensitive screens.  |
| UI/component tests   | Blade component contracts, render states, props, slots, variants, accessibility attributes, and reference examples. |
| Documentation checks | Metadata, links, indexes, templates, status, and docs guardrails.                                                   |
| Manual review        | Design-sensitive UI, visual alignment, user acceptance, screenshots, and environment-specific behavior.             |

Use the narrowest test that proves the behavior.

---

## 5. Test Templates

Approved test templates are maintained under `stubs/tests/`.

Test templates may use `markTestIncomplete()` where meaningful assertions require feature-specific implementation. Such markers are scaffolding only.

A test file is not complete while it contains:

- unresolved stub placeholders
- `markTestIncomplete()` for required behavior
- unconditional passing assertions
- placeholder fixtures
- tests that do not exercise observable behavior

Remove inapplicable scaffolded tests and replace applicable incomplete tests with focused assertions before considering the implementation complete.

---

## 6. Required Test Coverage Areas

Add or update tests when a change affects:

- login/logout
- MFA/recent-auth/elevation
- password/security flows
- user lifecycle
- roles, permissions, policies, or access checks
- route protection
- audit events
- monitoring/error handling
- notifications
- settings/preferences
- data governance/protection
- exports, downloads, file access, or data movement
- service accounts/API/webhooks
- security headers or middleware
- database schema behavior
- registry/contribution behavior
- UI component public contracts
- Module workflows

For access-sensitive behavior, test both allowed and denied paths.

---

## 7. Core Capability Testing

Core capability tests should verify:

- authorization boundaries
- data boundaries
- audit behavior
- failure modes
- expected events/notifications
- service/action behavior
- route or command behavior when applicable
- docs/contract impact when behavior changes

Do not only test happy paths for Core security or data behavior.

---

## 8. Product Presentation, Frame Surface, Delivery Adapter, And Registry Testing

Test each technical responsibility beneath its actual owner:

- Product presentation tests verify owner-specific Pages, interaction, access controls, and empty/error states;
- Frame Surface tests verify Workspace-aware composition, normalized Core Navigation output, current state, fallback, accessibility, responsive behavior, and UI independence;
- Delivery Adapter tests verify transport or invocation behavior, validation, authorization integration, delegation, and failure handling;
- Registry tests verify Host-owned Extension Point contracts plus Contribution validation, collection, ordering, resolution, and exposure;
- cross-owner tests verify that Contributions remain owned by their Contributors.

Do not use presentation or Frame Surface tests to make UI responsible for Registry discovery, Contribution assembly, permission evaluation, Module lifecycle, or domain behavior. APIs, console commands, webhooks, queues, schedulers, and background entry points are Delivery Adapters or Invocation Channels, not Frame Surfaces.

---

## 9. Module Testing

Module tests should verify:

- module-owned business workflows
- tenant/workspace/customer scoping
- module routes and views
- module use of Core Access, Audit, Notifications, Settings, Security, and DataProtection
- allowed and denied access
- module registry/contribution behavior when applicable

Modules must not test by bypassing Core authorization or data boundaries.

---

## 10. UI Testing

UI tests should verify public component contracts.

Test when changing:

- props
- slots
- variants
- sizes
- state classes
- accessibility attributes
- generated IDs
- JS behavior
- CSS class structure
- contract.php
- reference.php
- UI Reference examples

Design-sensitive changes still require manual visual review.

Codex must not treat passing tests as visual approval for spacing, hierarchy, or interaction design.

---

## 11. Database And Migration Testing

When schema changes, verify:

- migration runs
- rollback when practical
- indexes and constraints
- required defaults
- nullable/non-nullable behavior
- seeders or registries
- existing tests that depend on affected tables

Update `docs/06-database/` when schema contracts change.

---

## 12. Security Testing

Security-sensitive changes require explicit verification.

Test or manually verify:

- unauthenticated access is blocked
- unauthorized access is denied
- allowed access still works
- sensitive fields are redacted
- protected files are not public
- state-changing actions are not GET-only
- rate limits apply where required
- security headers apply where required
- audit records are written when required
- secrets are not logged or exposed

---

## 13. Documentation Verification

Documentation changes should verify:

- `DOC-META` headers exist where required
- parent/index links are current
- child documents are linked from indexes
- important references use Markdown links
- templates are referenced, not duplicated
- planning docs link to canonical owner docs
- canonical docs link back to active planning when relevant
- status fields are current
- stale `/docs/08-active/` active-workflow language was not reintroduced

Run docs guardrail scripts when available.

---

## 14. Manual Verification

Use manual verification when automated tests are insufficient or unavailable.

Manual verification should state:

- environment
- page/route/command tested
- user role or actor
- steps performed
- expected result
- actual result
- screenshots or notes when useful
- unresolved manual review needs

Manual visual review is required for UI changes involving spacing, layout, hierarchy, visual tone, or interaction feel.

---

## 15. Test Naming

Use behavior-focused names.

- Test classes use `<SubjectOrBehavior>Test`.
- Test methods use `test_<context>_<expected_outcome>` or another explicit context-and-condition form.
- Browser tests use `<Flow>BrowserTest`.
- Architecture tests use `<BoundaryOrRule>ArchitectureTest`.
- Contract tests use `<Subject>ContractTest`.
- Dataset names use snake_case.
- PHP fixture classes use `<Subject>Fixture`.
- Non-PHP fixture filenames use descriptive lowercase kebab-case by default.

Prefer:

- `test_admin_can_view_security_checklist`
- `test_user_without_permission_cannot_export_customer_data`
- `test_mfa_challenge_is_required_for_sensitive_action`

Avoid vague names:

- `test_it_works`
- `test_page`
- `test_user`
- `test_success`

---

## 16. Test Data

Test data should be explicit and minimal.

Do not use production data.

Do not include real secrets, tokens, passwords, customer data, or private information in fixtures.

Use factories, seeders, or local fixtures appropriate to the test layer.

---

## 17. Failing Tests

If a test fails:

- identify whether the failure is in scope
- fix in-scope failures before considering work complete
- report out-of-scope failures separately
- do not weaken tests to pass
- do not delete tests unless the behavior is intentionally removed and docs are updated

---

## 18. Work Summary Expectations

Every implementation summary or PR should state:

- tests run
- result
- tests not run and why
- manual verification performed
- manual review still needed
- docs updated or why no docs update was needed

---

## 19. Related

- [Coding Standards](Coding%20Standards.md)
- [File Building Standards](File%20Building%20Standards.md)
- [Feature Development Standards](Feature%20Development%20Standards.md)
- [Repository Naming Standards](repository-naming-standards.md)
- [Documentation Review Standards](../documentation/Documentation%20Review%20Standards.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Runbook Index](../../10-runbooks/index.md)
- [Repository Architecture](../../03-architecture/repository-architecture.md)
- [Workspace Navigation And Frame Composition](../../03-architecture/workspace-navigation-and-frame-composition.md)
- [Phase 6 Preimplementation Proof Requirements](../../07-planning/Milestones/milestone-0/goal-3/phase-6/6-6-preimplementation-proof-requirements.md)
