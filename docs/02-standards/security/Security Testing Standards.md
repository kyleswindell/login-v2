<!--
DOC-META
title: Security Testing Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Security Testing Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines required automated, manual, staged, negative, abuse, scope, and evidence-based security testing.
-->

# Security Testing Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Test Perspectives](#2-test-perspectives)
- [3. Required Security Assertions](#3-required-security-assertions)
- [4. Negative Tests](#4-negative-tests)
- [5. Auth And Identity](#5-auth-and-identity)
- [6. Access And Scope](#6-access-and-scope)
- [7. Data, Files, And Exports](#7-data-files-and-exports)
- [8. API And Webhooks](#8-api-and-webhooks)
- [9. Deployment And Supply Chain](#9-deployment-and-supply-chain)
- [10. Manual Review](#10-manual-review)
- [11. Test Integrity](#11-test-integrity)
- [12. Evidence](#12-evidence)
- [13. Related](#13-related)

## 1. Purpose

Define the minimum security verification required before security-sensitive changes are accepted or released.

## 2. Test Perspectives

Where applicable, test:

- unauthenticated guest
- authenticated non-privileged user
- correctly privileged user
- wrong target
- wrong scope
- inactive or suspended identity
- stale or insufficient assurance
- service account
- expired or revoked credential
- malformed and oversized input

## 3. Required Security Assertions

Security tests should verify route prerequisites, object-level authorization, scope isolation, CSRF and method safety, state-transition guards, MFA and recent-auth requirements, session invalidation, secure headers, safe redirects, file and export controls, secret redaction, audit evidence, monitoring behavior, rate limits, idempotency, and replay protection where applicable.

## 4. Negative Tests

Each sensitive allow path must have meaningful deny coverage.

A test that proves only the privileged success path is incomplete.

## 5. Auth And Identity

Verify enumeration resistance, account-state denial, throttling, password policy, MFA challenge and throttling, recovery-code single use, recent-auth separation, session regeneration and invalidation, and safe audit metadata.

## 6. Access And Scope

Verify permission denial, object denial, wrong customer or workspace denial, direct-ID denial, self-escalation guards, last-admin guards, elevated-access expiry, separation-of-duty rules, and notification-action reauthorization.

## 7. Data, Files, And Exports

Verify view does not imply export, restricted export controls, private storage, signed-link expiry, download reauthorization, file-type and size validation, generated filename safety, public-path denial, and redacted logs and evidence.

## 8. API And Webhooks

Verify raw token shown once, token hash verification, revoked and expired denial, service-account status, scope and object authorization, rate limits, JSON and payload limits, webhook signature, timestamp freshness, replay denial, idempotent processing, and secret-safe evidence.

## 9. Deployment And Supply Chain

Verify applicable lockfile consistency, dependency audits, secret scans, artifact identity, migration review, runtime security checks, environment posture, service health, and rollback or recovery readiness.

## 10. Manual Review

Manual review is required when automation cannot fully assess complex authorization, CSP behavior, browser and realtime behavior, sensitive workflow usability, destructive recovery, offensive findings, evidence handling, or production infrastructure.

## 11. Test Integrity

Tests must assert behavior, not merely implementation structure.

Do not weaken a security test to match insecure behavior.

A deferred or failing control must produce a tracked issue or accepted risk.

## 12. Evidence

Record commands, environment, revision, test scope, results, failures, manual reviewer, evidence location, and accepted risk.

Do not store restricted exploit details in public test output.

## 13. Related

- [OWASP ASVS Level 2 Baseline](OWASP%20ASVS%20Level%202%20Baseline.md)
- [Application Security Verification And Secure Delivery Standards](Application%20Security%20Verification%20And%20Secure%20Delivery%20Standards.md)
- [Offensive Security And Penetration Testing Standards](Offensive%20Security%20And%20Penetration%20Testing%20Standards.md)
- [Testing Standards Index](../testing/index.md)
