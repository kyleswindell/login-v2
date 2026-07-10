<!--
DOC-META
title: Secure Coding And Request Handling Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Secure Coding And Request Handling Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines secure Laravel request validation, authorization, workflow, output, redirect, mass-assignment, transaction, logging, and failure requirements.
-->

# Secure Coding And Request Handling Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Protected Workflow](#2-protected-workflow)
- [3. Request Validation](#3-request-validation)
- [4. HTTP Methods](#4-http-methods)
- [5. Authorization](#5-authorization)
- [6. Controllers And Actions](#6-controllers-and-actions)
- [7. Mass Assignment](#7-mass-assignment)
- [8. Output](#8-output)
- [9. Redirects And URLs](#9-redirects-and-urls)
- [10. Queries And Injection](#10-queries-and-injection)
- [11. Errors](#11-errors)
- [12. Transactions And Effects](#12-transactions-and-effects)
- [13. Secrets And Logs](#13-secrets-and-logs)
- [14. Testing](#14-testing)
- [15. Related](#15-related)

## 1. Purpose

Define secure implementation rules for browser routes, controllers, requests, actions, services, policies, views, jobs, and commands.

## 2. Protected Workflow

Use this sequence for sensitive writes:

    middleware
      -> FormRequest validation
      -> policy or target authorization
      -> action or service
      -> transaction
      -> after-commit audit and notification
      -> safe response

## 3. Request Validation

Every write must validate:

- allowed fields
- type and length
- enum values
- target identifiers
- file constraints
- state transition
- cross-scope references
- required reason or approval
- payload size

Reject unexpected fields for security-sensitive requests.

## 4. HTTP Methods

State-changing browser operations must not use GET.

Use POST, PATCH, PUT, or DELETE with CSRF protection.

Signed GET routes may deliver a file only when they remain read-only and reauthorize access.

## 5. Authorization

Authorization must run server side, check the specific action, check the specific target, check the resolved scope, revalidate after state changes when needed, and avoid relying on hidden UI.

Controllers should use policies or an approved Access boundary instead of inline role-name checks.

## 6. Controllers And Actions

Controllers should validate, authorize, delegate, and respond.

Actions or services own transaction boundaries, domain invariants, last-admin and self-escalation guards, separation-of-duty rules, and after-commit effects.

Avoid broad update methods for unrelated sensitive fields.

## 7. Mass Assignment

Use explicit DTOs, validated arrays, or individual assignments.

Do not pass unfiltered request payloads into persistence.

Security-sensitive fields require dedicated actions.

## 8. Output

Use escaped Blade output by default.

Do not render stored user or business data as raw HTML.

Rich text requires an approved sanitizer boundary and security review.

## 9. Redirects And URLs

Redirect targets must be route generated, allow-listed, same-origin when required, validated against protocol-relative and credential-bearing URLs, and prevented from path traversal.

Do not redirect directly to untrusted request input.

## 10. Queries And Injection

Use parameterized queries and framework query builders.

Dynamic identifiers, order clauses, file paths, command arguments, and template names require allow-list validation.

## 11. Errors

User-facing failures must not reveal stack traces, SQL, internal paths, secrets, authorization rationale that enables probing, or provider payloads.

Log safe context through Monitoring.

## 12. Transactions And Effects

Successful mutation audit and notification effects should occur after commit.

Rolled-back mutations must not leave successful audit evidence.

Retryable jobs and webhook processing must be idempotent.

## 13. Secrets And Logs

Redact sensitive keys before logging.

Do not log full request payloads on Auth, secret, file, export, API, or webhook surfaces.

## 14. Testing

Security-sensitive implementation requires allow, deny, wrong-target, wrong-scope, invalid-state, and secret-safety tests.

## 15. Related

- [Security Testing Standards](Security%20Testing%20Standards.md)
- [Access Control And Authorization Standards](Access%20Control%20And%20Authorization%20Standards.md)
- [Coding Standards Index](../coding/index.md)
- [Application Security Core Planning](../../07-planning/02-core-capabilities/security/application-security-core-planning.md)
