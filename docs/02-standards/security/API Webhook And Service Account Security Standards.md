<!--
DOC-META
title: API Webhook And Service Account Security Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/API Webhook And Service Account Security Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines non-human identities, API credentials, scopes, request validation, throttling, webhook signing, replay protection, idempotency, evidence, and revocation.
-->

# API Webhook And Service Account Security Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Core Rule](#2-core-rule)
- [3. Service Accounts](#3-service-accounts)
- [4. API Tokens](#4-api-tokens)
- [5. Authentication Flow](#5-authentication-flow)
- [6. API Requests](#6-api-requests)
- [7. Rate Limits And Quotas](#7-rate-limits-and-quotas)
- [8. Inbound Webhooks](#8-inbound-webhooks)
- [9. Payload Storage](#9-payload-storage)
- [10. Outbound Webhooks](#10-outbound-webhooks)
- [11. Secrets](#11-secrets)
- [12. Audit And Monitoring](#12-audit-and-monitoring)
- [13. Tests](#13-tests)
- [Related](#related)

## 1. Purpose

Secure machine-to-machine access before APIs, webhooks, scheduled integrations, and service credentials expand.

## 2. Core Rule

Every machine interaction requires explicit identity, owner, purpose, environment, scoped access, protected credential, validated request, rate limit, audit evidence, monitoring, and a revocation path.

## 3. Service Accounts

A service account must:

- be distinguishable from a human user
- have an owner
- have a purpose
- have lifecycle state
- have environment and scope
- have review and expiry metadata
- be unable to use normal browser login unless explicitly approved
- avoid broad human roles by default

The persistence model may remain unresolved, but the security boundary is mandatory.

## 4. API Tokens

Generated tokens must be shown once, persist only prefix and hash when verification is sufficient, have owner and service account, have abilities or scopes, have expiry and revocation, record safe last-use metadata, and never appear in logs or exports.

Do not issue Super Admin machine tokens.

## 5. Authentication Flow

Token authentication must verify parseable format, prefix lookup, constant-time hash comparison, active token, active service account, expiry, environment, source restrictions where configured, rate limits, and scope and target authorization.

## 6. API Requests

API writes must:

- require JSON or documented content
- validate expected fields
- reject unknown fields when appropriate
- bound payload size
- enforce object-level scope
- support idempotency where duplicate processing is harmful
- use explicit versioning for public contracts
- avoid browser-session assumptions

## 7. Rate Limits And Quotas

Apply per-token and per-route controls.

Exports and restricted APIs require stricter limits.

Authentication failures and scope denials must be monitored.

## 8. Inbound Webhooks

Webhook receivers must:

- use HTTPS
- validate provider and endpoint status
- verify signature
- verify timestamp freshness
- prevent replay through event ID or nonce
- compare signatures in constant time
- limit payload size
- support idempotency
- return quickly
- process asynchronously
- record safe delivery metadata

## 9. Payload Storage

Prefer payload hash and selected safe metadata.

Store encrypted payload only when replay or diagnosis requires it and retention is approved.

## 10. Outbound Webhooks

Outbound webhooks must use approved HTTPS endpoints, sign payloads, include event ID and timestamp, send minimum required fields, retry with bounded backoff, stop after the maximum, log safe delivery evidence, and support disablement.

## 11. Secrets

Webhook and integration secrets follow Secrets Management Standards.

## 12. Audit And Monitoring

Record applicable service-account lifecycle, token creation, rotation, revocation, expiry, use, and denial, scope denial, webhook signature failure, replay rejection, processing result, and endpoint disablement.

Detect invalid-token spikes, source changes, rate spikes, stale accounts, owner gaps, rotation failures, signature failures, replay, and backlog.

## 13. Tests

Verify token hashing, shown-once behavior, status and expiry denial, object scope, rate limits, signature validation, replay rejection, idempotency, redaction, and audit evidence.

## Related

- [Secrets Management Standards](Secrets%20Management%20Standards.md)
- [Access Control And Authorization Standards](Access%20Control%20And%20Authorization%20Standards.md)
- [API Webhook And Service Account Security Planning](../../07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md)
- [Service Accounts And Machine Identity Planning](../../07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md)
