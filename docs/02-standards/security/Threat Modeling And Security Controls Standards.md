<!--
DOC-META
title: Threat Modeling And Security Controls Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Threat Modeling And Security Controls Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines threat-model triggers, stable threat and control IDs, traceability, control status, evidence, ownership, and release assessment.
-->

# Threat Modeling And Security Controls Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Threat-Model Triggers](#2-threat-model-triggers)
- [3. Threat Record](#3-threat-record)
- [4. Control Record](#4-control-record)
- [5. Identifier Stability](#5-identifier-stability)
- [6. Traceability](#6-traceability)
- [7. Control Status](#7-control-status)
- [8. Domain Ownership](#8-domain-ownership)
- [9. Release Assessment](#9-release-assessment)
- [10. Review](#10-review)
- [11. Maintenance](#11-maintenance)
- [12. Related](#12-related)

## 1. Purpose

Require security-sensitive work to identify threats, select controls, prove implementation, and maintain traceability.

## 2. Threat-Model Triggers

Create or update a threat model when work adds or materially changes authentication or recovery, authorization or scope, sensitive data or exports, file handling, APIs or webhooks, service accounts or integrations, secrets, public endpoints, privileged administration, deployment topology, audit or forensic evidence, or cross-instance support access.

## 3. Threat Record

A threat record should identify:

- stable threat ID
- asset
- actor or threat source
- entry point
- trust boundary
- abuse case
- preconditions
- impact
- affected scope
- selected controls
- residual risk
- owner
- status

## 4. Control Record

A control should identify:

- stable control ID
- title
- owner
- requirement
- preventive, detective, corrective, or recovery type
- implementation references
- tests
- audit evidence
- monitoring signal
- notification
- runbook
- applicability
- status
- accepted-risk reference

## 5. Identifier Stability

Use stable identifiers after they are referenced by code, tests, matrices, issues, or evidence.

Do not renumber or reuse retired IDs.

Recommended families may include `SEC-AUTH-*`, `SEC-ACCESS-*`, `SEC-DATA-*`, `SEC-FILE-*`, `SEC-SECRETS-*`, `SEC-DEPLOY-*`, `SEC-SUPPLY-*`, and `SEC-EVIDENCE-*`.

Exact numbering may be introduced with the first catalog.

## 6. Traceability

High-risk work should maintain:

    threat
      -> control
      -> implementation
      -> test
      -> audit event
      -> monitoring or detection
      -> notification
      -> runbook
      -> residual risk

Not every control requires every link, but omissions must be intentional.

## 7. Control Status

Use:

- planned
- implemented
- verified
- failing
- not applicable
- accepted risk
- superseded

A control must not be marked verified without evidence.

## 8. Domain Ownership

The domain owner defines threat semantics.

The Security capability owns cross-cutting guardrails and catalog consistency.

Audit and Monitoring own evidence storage and signals.

Runbooks own operator procedure.

## 9. Release Assessment

Release-impacting controls must identify blocking severity, required evidence, accepted-risk authority, expiration, and remediation issue.

A failed critical control blocks release unless an explicit authority accepts the risk.

## 10. Review

Threat models require review from affected domain and security owners.

Review must challenge missing trust boundaries, wrong-scope access, privilege escalation, sensitive data movement, recovery abuse, service identity misuse, evidence gaps, and unsafe failure behavior.

## 11. Maintenance

Update threat and control mappings when architecture changes, new attack surface appears, a finding is confirmed, an incident occurs, a control is replaced, or evidence no longer proves the control.

## 12. Related

- [Security Standards](Security%20Standards.md)
- [Threat Detection And Response Standards](Threat%20Detection%20And%20Response%20Standards.md)
- [Threat Modeling And Security Controls Planning](../../07-planning/02-core-capabilities/security/threat-modeling-security-controls-planning.md)
- [Threat-Control Traceability Matrix](../../07-planning/02-core-capabilities/security/threat-control-traceability-matrix.md)
