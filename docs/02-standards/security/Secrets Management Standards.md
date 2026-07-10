<!--
DOC-META
title: Secrets Management Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Secrets Management Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines secret classification, approved storage, hashing, encryption, references, one-time display, access, rotation, expiry, redaction, leak handling, and evidence.
-->

# Secrets Management Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Secret Types](#2-secret-types)
- [3. Storage Decision](#3-storage-decision)
- [4. Source Control](#4-source-control)
- [5. One-Time Display](#5-one-time-display)
- [6. Access](#6-access)
- [7. Reveal And Copy](#7-reveal-and-copy)
- [8. Rotation And Expiry](#8-rotation-and-expiry)
- [9. Redaction](#9-redaction)
- [10. Compromise](#10-compromise)
- [11. Service Accounts And Integrations](#11-service-accounts-and-integrations)
- [12. Tests](#12-tests)
- [13. Related](#13-related)

## 1. Purpose

Protect credentials and reusable secret material throughout creation, storage, access, use, rotation, revocation, logging, evidence, and disposal.

## 2. Secret Types

Treat applicable values as secrets:

- application keys
- database credentials
- API tokens
- OAuth client secrets and refresh tokens
- webhook secrets
- TOTP secrets
- private keys and certificates
- integration credentials
- backup encryption keys
- service-account credentials
- session and remember-token values

## 3. Storage Decision

Use:

- hash when only verification is needed
- encryption when the app must retrieve the value
- external secret reference when an approved vault owns the value
- environment or host secret storage for infrastructure-only values

Do not use general settings storage as secret storage without appropriate encryption, access control, and rotation.

## 4. Source Control

Never commit raw secrets, production `.env` files, private keys, credential exports, secret-bearing screenshots, or copied provider configuration.

Secret scanning must cover repository and release-candidate state.

## 5. One-Time Display

Generated verification credentials should be displayed once when possible.

Persist prefix, fingerprint, hash, owner, purpose, creation time, expiry, and rotation state.

Do not persist the raw value when only later verification is needed.

## 6. Access

Secret access requires explicit permission, target scope, reason when high risk, MFA or recent authentication when required, private response, audit evidence, and no caching in public or browser-persistent storage.

## 7. Reveal And Copy

Reveal or copy must minimize display duration, avoid full-page rendering, prevent accidental log capture, record safe access evidence, avoid notification payload disclosure, and support policy-based denial.

## 8. Rotation And Expiry

Every production secret must have owner, purpose, rotation procedure, expiry or review cadence, dependent systems, rollback or overlap strategy, failure notification, and compromise response.

Long-lived secrets without ownership are prohibited.

## 9. Redaction

Redact secrets from request logs, exception context, audit metadata, monitoring, notifications, exports, support views, test output, CI artifacts, and evidence packages.

Redaction must handle headers, cookies, payload keys, query strings, and provider-specific credential forms.

## 10. Compromise

Suspected exposure requires preservation of safe evidence, revocation or rotation, dependent credential review, session or token invalidation when applicable, finding or incident record, audit, notification, and history review.

Do not include the leaked value in the response record.

## 11. Service Accounts And Integrations

Machine credentials must remain separate from human login credentials and follow least privilege.

## 12. Tests

Verify raw values are not persisted, encryption or hash use is correct, reveal requires authorization, rotation preserves required continuity, revoked credentials fail, expiry signals work, and logs and evidence are redacted.

## 13. Related

- [API Webhook And Service Account Security Standards](API%20Webhook%20And%20Service%20Account%20Security%20Standards.md)
- [Digital Forensics Readiness And Evidence Handling Standards](Digital%20Forensics%20Readiness%20And%20Evidence%20Handling%20Standards.md)
- [Secrets Management Core Planning](../../07-planning/02-core-capabilities/security/secrets-management-core-planning.md)
