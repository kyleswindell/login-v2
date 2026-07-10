<!--
DOC-META
title: Zero Trust Security Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Zero Trust Security Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines explicit validation, least privilege, assume-breach behavior, context-aware access, time-bounded assurance, and continuous revalidation.
-->

# Zero Trust Security Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Core Rule](#2-core-rule)
- [3. No Implicit Trust](#3-no-implicit-trust)
- [4. Least Privilege](#4-least-privilege)
- [5. Continuous Validation](#5-continuous-validation)
- [6. Assurance](#6-assurance)
- [7. Request Security Context](#7-request-security-context)
- [8. Assume Breach](#8-assume-breach)
- [9. Route Tiers](#9-route-tiers)
- [10. Service Identities](#10-service-identities)
- [11. Verification](#11-verification)
- [12. Related](#12-related)

## 1. Purpose

Apply Zero Trust principles as cross-cutting requirements rather than a standalone product or module.

## 2. Core Rule

Every protected action must be explicitly authenticated, authorized, scoped, context-aware, time-aware, auditable, and revalidated when sensitivity changes.

## 3. No Implicit Trust

Do not trust an actor or request merely because it is inside a private network, from an internal hostname, from a known device, from an administrator area, from a service account, from a previous trusted session, initiated by a background job, or associated with an existing notification.

## 4. Least Privilege

Grant only the actions, targets, scopes, and duration required.

Use separate permissions for view and export, normal and sensitive view, create and approve, manage and elevate, and human and API access.

## 5. Continuous Validation

Revalidate when accessing a new target, changing scope, performing a sensitive action, downloading or exporting, revealing or rotating a secret, activating elevated access, opening a notification action, using a signed link, or resuming a long-running job.

## 6. Assurance

Use risk-appropriate assurance:

- authenticated session
- MFA
- recent authentication
- phishing-resistant factor where required
- elevated access
- approval
- reason capture

Previous authentication does not create unlimited future trust.

## 7. Request Security Context

Security decisions should be able to consider applicable actor, actor type, session, authentication factors, recent-auth time, target, scope, route, environment, IP and user agent, data classification, operation risk, and policy source.

## 8. Assume Breach

Design for credential misuse and lateral movement by minimizing credential scope, rotating secrets, recording denials, detecting abnormal use, limiting export and bulk access, preserving evidence, supporting revocation, and avoiding broad internal bypasses.

## 9. Route Tiers

Routes should be classified by required protection, such as public, guest, authenticated, administrative, sensitive administrative, signed download, API, or webhook.

The tier establishes minimum controls; target authorization still applies.

## 10. Service Identities

Machine identities require explicit owners, scopes, environments, credentials, and review.

Internal automation must not inherit implicit trust.

## 11. Verification

Verify sensitive route prerequisites, target and scope checks, recent-auth expiration, elevated-access expiration, signed-link reauthorization, service-account restrictions, notification action revalidation, and evidence for allow and deny decisions.

## 12. Related

- [Access Control And Authorization Standards](Access%20Control%20And%20Authorization%20Standards.md)
- [Identity And Account Security Standards](Identity%20And%20Account%20Security%20Standards.md)
- [Zero Trust Security Planning](../../07-planning/02-core-capabilities/security/zero-trust-security-planning.md)
