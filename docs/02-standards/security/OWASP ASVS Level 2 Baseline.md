<!--
DOC-META
title: OWASP ASVS Level 2 Baseline
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/OWASP ASVS Level 2 Baseline.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines adoption, applicability, evidence, Level 2 requirements, and risk-based Level 3 overlays for OWASP ASVS 5.0.0.
-->

# OWASP ASVS Level 2 Baseline

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Version](#2-version)
- [3. Default Level](#3-default-level)
- [4. Level 3 Overlays](#4-level-3-overlays)
- [5. Applicability](#5-applicability)
- [6. Evidence Status](#6-evidence-status)
- [7. Control-Family Ownership](#7-control-family-ownership)
- [8. Evidence Matrix](#8-evidence-matrix)
- [9. Maintenance](#9-maintenance)
- [10. External Source](#10-external-source)
- [11. Related](#11-related)

## 1. Purpose

Define how Login 2.0 uses OWASP Application Security Verification Standard as its application-security verification baseline.

## 2. Version

The adopted baseline is OWASP ASVS 5.0.0.

Requirement references must include the version:

    v5.0.0-<chapter>.<section>.<requirement>

Do not copy the full ASVS text into this repository. Use official release artifacts as the requirement source.

## 3. Default Level

The default target is Level 2.

A scoped release must address every applicable Level 1 and Level 2 requirement through pass evidence, not-applicable rationale, externally controlled evidence, or explicit accepted risk.

A release must not claim ASVS Level 2 alignment without requirement-level evidence.

## 4. Level 3 Overlays

Use risk-based Level 3 rigor for applicable:

- privileged administration
- app-instance, tenant, workspace, and customer isolation
- MFA, recovery, and elevated access
- external identity and account linking
- secrets and machine credentials
- restricted exports and files
- audit, forensic, and incident evidence
- production deployment and release gates

Level 3 overlay does not make every Level 3 requirement universally applicable.

## 5. Applicability

Each requirement must identify applicability, owner, implementation reference, test or verification, evidence, current result, and accepted-risk reference when applicable.

Not applicable must describe why the capability is absent or out of scope.

## 6. Evidence Status

Use:

- pass
- fail
- not applicable
- externally controlled
- deferred with accepted risk
- not assessed

Do not use broad labels such as secure, complete, or enterprise-ready as requirement evidence.

## 7. Control-Family Ownership

| ASVS Area                                | Primary Repository Owners                                 |
| ---------------------------------------- | --------------------------------------------------------- |
| Encoding, validation, and business logic | Secure coding, feature contracts, and tests               |
| Web frontend and browser                 | Transport and browser standards, UI standards             |
| API and web services                     | API, webhook, and service-account standards               |
| File handling                            | File upload/download/export standards                     |
| Authentication                           | Identity and account security                             |
| Sessions                                 | Identity and transport standards                          |
| Authorization                            | Access and scope-isolation standards                      |
| OAuth and OIDC                           | Identity and account security                             |
| Cryptography and secrets                 | Secrets and data-protection standards                     |
| Secure communication                     | Transport and deployment standards                        |
| Configuration                            | Deployment and secure-delivery standards                  |
| Data protection                          | Data protection, privacy, logging, and database standards |
| Secure coding and architecture           | Coding, architecture, and threat-model standards          |
| Logging and error handling               | Logging standards and evidence standards                  |

## 8. Evidence Matrix

Maintain the supporting requirement-level matrix under `docs/09-reference/security/`.

The matrix is evidence support, not the canonical source of security rules.

## 9. Maintenance

Review the adopted version when OWASP publishes a later stable release.

Version migration requires change review, identifier mapping, applicability review, evidence-gap assessment, planning and issue creation, and explicit adoption.

## 10. External Source

Official project page:

    https://owasp.org/www-project-application-security-verification-standard/

## 11. Related

- [Application Security Verification And Secure Delivery Standards](Application%20Security%20Verification%20And%20Secure%20Delivery%20Standards.md)
- [Security Testing Standards](Security%20Testing%20Standards.md)
- [ASVS Level 2 Evidence Matrix](../../09-reference/security/asvs-level-2-evidence-matrix.md)
