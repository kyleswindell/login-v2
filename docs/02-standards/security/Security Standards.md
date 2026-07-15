<!--
DOC-META
title: Security Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Security Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines security-wide principles, ownership boundaries, exception handling, evidence expectations, and completion requirements.
-->

# Security Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Core Principles](#2-core-principles)
- [3. Responsibility Boundaries](#3-responsibility-boundaries)
- [4. Security-Sensitive Change Classification](#4-security-sensitive-change-classification)
- [5. Server-Side Enforcement](#5-server-side-enforcement)
- [6. Secret And Sensitive Data Safety](#6-secret-and-sensitive-data-safety)
- [7. Exceptions And Accepted Risk](#7-exceptions-and-accepted-risk)
- [8. Evidence](#8-evidence)
- [9. Completion Criteria](#9-completion-criteria)
- [10. Related](#10-related)

## 1. Purpose

Define the security rules that apply across Core capabilities, Modules, UI, Laravel integration, owner-specific Surfaces, Delivery Adapters, Host-owned Registries, operational tooling, and deployment environments.

## 2. Core Principles

All security-sensitive work must apply:

- explicit authentication
- least-privilege authorization
- object and scope validation
- secure defaults
- defense in depth
- fail-safe denial
- minimum necessary data exposure
- secret-safe logging
- auditable sensitive actions
- verified recovery
- evidence-backed release decisions

Security controls must be enforceable in server-side behavior. Navigation, hidden buttons, and client-side checks are not authorization controls.

## 3. Responsibility Boundaries

| Owner            | Security Responsibility                                                                |
| ---------------- | -------------------------------------------------------------------------------------- |
| Auth             | Authentication, passwords, MFA, recovery, sessions, and recent authentication          |
| Identity         | User lifecycle, invitations, status, account identity, and deprovisioning coordination |
| Access           | Permissions, roles, groups, policies, effective access, elevated access, and reviews   |
| Data Governance  | Purpose, ownership, stewardship, privacy rights, quality, and retention intent         |
| Data Protection  | Classification, redaction, masking, export, DLP, retention execution, and erasure      |
| Security         | Route, request, browser, file, secret, release, and control guardrails                 |
| Audit            | Accountable event evidence and forensic timeline support                               |
| Monitoring       | Errors, failed jobs, health, telemetry, detections, and operational signals            |
| Notifications    | Durable security and operational alert delivery                                        |
| Operations       | Infrastructure, deployment, backup, restoration, and incident procedures               |
| Modules          | Domain authorization, data declarations, audit semantics, and secure workflows         |

A capability must not silently absorb another owner's security responsibility.

## 4. Security-Sensitive Change Classification

Treat a change as security-sensitive when it affects:

- login, MFA, sessions, recovery, or federation
- user lifecycle
- authorization, roles, policies, or scope
- sensitive data, exports, files, or retention
- secrets or machine credentials
- audit or monitoring evidence
- request validation, redirects, or browser protections
- APIs, webhooks, integrations, or service accounts
- deployment, infrastructure, dependencies, or artifacts
- incident, vulnerability, or offensive-testing workflows

Security-sensitive work requires identified threats, required tests, evidence, and review.

## 5. Server-Side Enforcement

Required enforcement includes:

- middleware for broad route prerequisites
- request validation for all writes
- policy or equivalent object-level authorization
- capability-owned invariants in actions or services
- Data Protection checks for sensitive movement
- after-commit audit for successful mutations
- safe failure logging
- explicit notification routing for inbox-worthy security events

## 6. Secret And Sensitive Data Safety

Never store or expose plaintext passwords, submitted MFA values, TOTP setup secrets, recovery codes, full API tokens, session cookies, authorization headers, private keys, webhook secrets, OAuth client secrets, or unnecessary restricted personal data.

Use identifiers, fingerprints, hashes, redacted values, and approved secret references.

## 7. Exceptions And Accepted Risk

An exception must identify:

- violated requirement
- scope
- owner
- justification
- compensating controls
- evidence
- expiration
- remediation plan
- approving authority

Critical and high-risk exceptions must expire.

An exception must not silently change a standard.

## 8. Evidence

Security completion requires evidence appropriate to the change, including automated tests, manual review, configuration checks, runtime checks, scan output, audit records, restore or incident exercises, release evidence, or accepted-risk records.

Evidence must be stored privately when it contains sensitive findings.

## 9. Completion Criteria

Security work is complete when owner boundaries are respected, allow and deny paths are verified, object and scope checks pass, secrets and sensitive values are excluded, audit and monitoring expectations are met, required runbooks exist, release gates pass, open risks are explicitly accepted or remediated, and canonical docs reflect current truth.

## 10. Related

- [Security Standards Index](index.md)
- [OWASP ASVS Level 2 Baseline](OWASP%20ASVS%20Level%202%20Baseline.md)
- [Security Testing Standards](Security%20Testing%20Standards.md)
- [Logging Standards Index](../logging/index.md)
