<!--
DOC-META
title: Security Standards Index
doc_type: index
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/index.md
parent: docs/02-standards/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes canonical security, privacy, data-protection, assurance, deployment, evidence, and response standards.
-->


# Security Standards Index

Parent: [Standards Index](../index.md)
- [1. Purpose](#1-purpose)
- [2. Foundation](#2-foundation)
- [3. Identity, Access, And Scope](#3-identity-access-and-scope)
- [4. Application And Data Security](#4-application-and-data-security)
- [5. Delivery, Findings, And Testing](#5-delivery-findings-and-testing)
- [6. Detection, Evidence, And Response](#6-detection-evidence-and-response)
- [7. Compatibility Paths](#7-compatibility-paths)
- [8. Deferred Splits](#8-deferred-splits)
- [9. Promotion State](#9-promotion-state)
- [10. Related](#10-related)

## 1. Purpose

This folder owns enforceable security requirements.

The current consolidation separates broad legacy documents into focused owners without creating one file for every possible security subtopic.

## 2. Foundation

| Document                                                                                                                                          | Purpose                                                                                |
| ------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------- |
| [Security Standards](Security%20Standards.md)                                                                                                     | Security-wide principles, ownership, exceptions, and change classification.            |
| [OWASP ASVS Level 2 Baseline](OWASP%20ASVS%20Level%202%20Baseline.md)                                                                             | ASVS version, Level 2 applicability, Level 3 overlays, and evidence rules.             |
| [Application Security Verification And Secure Delivery Standards](Application%20Security%20Verification%20And%20Secure%20Delivery%20Standards.md) | Release evidence, verification, and production-promotion gates.                        |
| [Threat Modeling And Security Controls Standards](Threat%20Modeling%20And%20Security%20Controls%20Standards.md)                                   | Threat models, stable control IDs, traceability, and control evidence.                 |
| [Zero Trust Security Standards](Zero%20Trust%20Security%20Standards.md)                                                                           | Explicit validation, least privilege, context revalidation, and assume-breach posture. |

## 3. Identity, Access, And Scope

| Document                                                                                                                | Purpose                                                                                               |
| ----------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------- |
| [Identity And Account Security Standards](Identity%20And%20Account%20Security%20Standards.md)                           | Authentication, password, MFA, recovery, federation, linking, and identity abuse defenses.            |
| [Access Control And Authorization Standards](Access%20Control%20And%20Authorization%20Standards.md)                     | Permissions, roles, policies, scope, object authorization, elevated access, and separation of duties. |
| [Transport Session And Browser Security Standards](Transport%20Session%20And%20Browser%20Security%20Standards.md)       | HTTPS, proxies, sessions, cookies, browser headers, and CSP.                                          |
| [Tenant And Scope Isolation Standards](Tenant%20And%20Scope%20Isolation%20Standards.md)                                 | App-instance, tenant, workspace, customer, resource, job, export, and notification isolation.         |
| [API Webhook And Service Account Security Standards](API%20Webhook%20And%20Service%20Account%20Security%20Standards.md) | Machine identities, API tokens, webhooks, scopes, replay protection, and rate limits.                 |

## 4. Application And Data Security

| Document                                                                                                                | Purpose                                                                                               |
| ----------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------- |
| [Secure Coding And Request Handling Standards](Secure%20Coding%20And%20Request%20Handling%20Standards.md)               | Laravel request validation, write boundaries, output safety, object authorization, and safe failures. |
| [Security Testing Standards](Security%20Testing%20Standards.md)                                                         | Required positive, negative, scope, abuse, and release security testing.                              |
| [File Upload Download And Export Security Standards](File%20Upload%20Download%20And%20Export%20Security%20Standards.md) | Untrusted uploads, private storage, signed downloads, generated exports, and evidence.                |
| [Secrets Management Standards](Secrets%20Management%20Standards.md)                                                     | Credential storage, retrieval, rotation, one-time display, redaction, and leak response.              |
| [Data Protection And Data Loss Prevention Standards](Data%20Protection%20And%20Data%20Loss%20Prevention%20Standards.md) | Classification, movement, secure export, retention, erasure, redaction, and DLP decisions.            |
| [Privacy And Data Governance Standards](Privacy%20And%20Data%20Governance%20Standards.md)                               | Purpose, minimization, ownership, stewardship, privacy requests, retention intent, and quality.       |

## 5. Delivery, Findings, And Testing

| Document                                                                                                                                  | Purpose                                                                                            |
| ----------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------- |
| [Deployment Environment And Infrastructure Security Standards](Deployment%20Environment%20And%20Infrastructure%20Security%20Standards.md) | Environment contracts, infrastructure hardening, configuration, deployment, and database exposure. |
| [Software Supply Chain Security Standards](Software%20Supply%20Chain%20Security%20Standards.md)                                           | Dependency inventory, lockfiles, SBOMs, artifact integrity, licenses, and supply-chain evidence.   |
| [Vulnerability Management Standards](Vulnerability%20Management%20Standards.md)                                                           | Finding lifecycle, severity, ownership, accepted risk, remediation, retest, and release gates.     |
| [Offensive Security And Penetration Testing Standards](Offensive%20Security%20And%20Penetration%20Testing%20Standards.md)                 | Authorization, rules of engagement, safe environments, evidence, remediation, and retest.          |

## 6. Detection, Evidence, And Response

| Document                                                                                                                                  | Purpose                                                                                                     |
| ----------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------- |
| [Threat Detection And Response Standards](Threat%20Detection%20And%20Response%20Standards.md)                                             | Detection IDs, signal rules, severity, routing, playbooks, automation boundaries, and tuning.               |
| [Digital Forensics Readiness And Evidence Handling Standards](Digital%20Forensics%20Readiness%20And%20Evidence%20Handling%20Standards.md) | Correlation, evidence preservation, private evidence, manifests, hashing, legal hold, and chain of custody. |
| [Security Incident Response Standards](Security%20Incident%20Response%20Standards.md)                                                     | Incident governance, required response phases, evidence-first containment, and runbook coverage.            |
| [Logging Standards Index](../logging/index.md)                                                                                            | Audit logging, monitoring, alerting, and operational evidence standards.                                    |

## 7. Compatibility Paths

The following legacy paths are retained only as superseded pointers:

- [Tenant Safety Standards](Tenant%20Safety%20Standards.md)
- [Platform Production Server Policy](platform-production-server-policy.md)

Do not add new rules to compatibility pointers.

## 8. Deferred Splits

The following topics are intentionally consolidated until implementation complexity justifies separate standards:

- session management remains split between Identity and Transport standards
- security controls catalog remains inside Threat Modeling and Security Controls
- API, webhook, and service-account child standards remain in one parent
- dependency, SBOM, build-integrity, and license rules remain in Software Supply Chain Security
- deployment, infrastructure, environment, configuration, and database deployment remain in one deployment standard
- stewardship and data quality remain in Privacy and Data Governance
- forensics readiness, evidence handling, and audit-evidence requirements remain in one evidence standard

## 9. Promotion State

All files in this package are draft candidates.

Promote each to `active` only after:

- owner review
- conflict review
- verification review
- link and index validation
- affected planning synchronization
- explicit acceptance

## 10. Related

- [Standards Index](../index.md)
- [Documentation Standards Index](../documentation/index.md)
- [Logging Standards Index](../logging/index.md)
- [Runbook Index](../../10-runbooks/index.md)
- [Planning Index](../../07-planning/index.md)
