<!--
DOC-META
title: Application Security Verification And Secure Delivery Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines application security verification, release evidence, secure-delivery checks, release gates, and production-promotion requirements.
-->

# Application Security Verification And Secure Delivery Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Verification Baseline](#2-verification-baseline)
- [3. Release Source](#3-release-source)
- [4. Required Release Evidence](#4-required-release-evidence)
- [5. Release Gates](#5-release-gates)
- [6. Security-Sensitive Change Evidence](#6-security-sensitive-change-evidence)
- [7. Dependency And Supply Chain](#7-dependency-and-supply-chain)
- [8. Staged Security Verification](#8-staged-security-verification)
- [9. Production Promotion](#9-production-promotion)
- [10. Accepted Risk](#10-accepted-risk)
- [11. Completion Criteria](#11-completion-criteria)
- [12. Related](#12-related)

## 1. Purpose

Define the required verification and secure-delivery baseline for repository changes, release candidates, staged environments, and production promotion.

## 2. Verification Baseline

- OWASP ASVS 5.0.0 Level 2 is the default application-verification baseline.
- High-risk administrative, identity, scope-isolation, secret, export, and evidence surfaces require documented Level 3 overlays where applicable.
- OWASP Top 10 language may support communication but does not replace concrete requirements.
- Security acceptance must identify exact controls, tests, evidence, and residual risk.

## 3. Release Source

Every deployable revision must:

- originate from committed repository state
- have an identifiable commit SHA
- use reviewed lockfiles
- use reproducible dependency installation
- produce identifiable build artifacts
- exclude local-only files and credentials
- link to the owning issue or release record

Production servers must not become the sole source of application code or configuration truth.

## 4. Required Release Evidence

A release evidence bundle should identify:

- commit SHA
- dependency lockfile state
- migration set
- frontend build result
- automated test result
- security test result
- dependency and secret scan result
- ASVS applicability updates
- runtime security-check result
- deployment target
- approvals and accepted risks
- rollback or recovery reference

Evidence must not include secret values.

## 5. Release Gates

Production promotion must stop when:

- a known critical vulnerability is unresolved
- a high vulnerability violates the approved gate and lacks valid accepted risk
- secret scanning finds a likely exposed credential
- required tests fail
- lockfiles or build inputs are inconsistent
- migrations are not reviewed
- debug posture is enabled
- HTTPS, proxy, cookie, or header checks fail
- required rollback or recovery is unavailable
- required runbooks do not exist
- required security evidence is missing

## 6. Security-Sensitive Change Evidence

Changes affecting Auth, Identity, Access, Data Protection, Security, Audit, Monitoring, Notifications, files, secrets, integrations, or deployment must include:

- positive authorized behavior
- negative unauthorized behavior
- wrong-target or wrong-scope behavior
- secret and evidence safety
- applicable audit events
- applicable monitoring behavior
- applicable rollback or recovery

## 7. Dependency And Supply Chain

Release review must cover Composer, npm, Docker and base-image inputs, CI actions, build tooling, third-party scripts, abandoned packages, lockfile drift, known advisories, and SBOM requirements when enabled.

## 8. Staged Security Verification

Meaningful user-facing or security-sensitive releases should use staged verification that exercises:

- guest behavior
- authenticated non-privileged behavior
- privileged behavior
- target and scope boundaries
- MFA or recent-auth requirements
- file and export behavior
- application headers and session posture
- expected audit and monitoring evidence

Authenticated DAST or equivalent browser-driven review should be used when the surface and risk justify it.

## 9. Production Promotion

Before promotion, verify from the deployed surface:

- `APP_DEBUG=false`
- HTTPS detection is correct
- trusted proxy configuration is bounded
- secure session cookies are active
- session encryption is active when required
- HSTS is enabled only for confirmed HTTPS coverage
- baseline headers are present
- long-lived services are healthy
- migrations are current
- secrets resolve through approved storage

## 10. Accepted Risk

A release exception must identify the finding, affected release and environment, severity, owner, compensating controls, expiration, approval, and remediation issue.

Expired accepted risk re-blocks the release.

## 11. Completion Criteria

Secure delivery is complete when required evidence exists, gates pass, residual risks are accepted, the deployed revision is identifiable, runtime posture is verified, and operational recovery remains available.

## 12. Related

- [OWASP ASVS Level 2 Baseline](OWASP%20ASVS%20Level%202%20Baseline.md)
- [Security Testing Standards](Security%20Testing%20Standards.md)
- [Software Supply Chain Security Standards](Software%20Supply%20Chain%20Security%20Standards.md)
- [Vulnerability Management Standards](Vulnerability%20Management%20Standards.md)
- [Deployment Environment And Infrastructure Security Standards](Deployment%20Environment%20And%20Infrastructure%20Security%20Standards.md)
- [Application Security Core Planning](../../07-planning/02-core-capabilities/security/application-security-core-planning.md)
