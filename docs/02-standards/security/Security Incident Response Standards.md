<!--
DOC-META
title: Security Incident Response Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Security Incident Response Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines incident governance, classification, roles, evidence-first response phases, containment authority, communications, recovery, and required runbook coverage.
-->

# Security Incident Response Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Incident Categories](#2-incident-categories)
- [3. Roles](#3-roles)
- [4. Response Phases](#4-response-phases)
- [5. Evidence First](#5-evidence-first)
- [6. Severity](#6-severity)
- [7. Containment](#7-containment)
- [8. Communications](#8-communications)
- [9. Recovery](#9-recovery)
- [10. Required Runbooks](#10-required-runbooks)
- [11. Post-Incident Review](#11-post-incident-review)
- [12. Exercises](#12-exercises)
- [13. Tests And Evidence](#13-tests-and-evidence)
- [14. Related](#14-related)

## 1. Purpose

Define requirements that security incident runbooks and response actions must satisfy.

This standard does not contain incident-specific executable steps.

## 2. Incident Categories

Initial categories include account compromise, privileged-access misuse, suspected data exposure, suspected data exfiltration, MFA recovery abuse, secret exposure, API or service-account compromise, critical vulnerability, supply-chain compromise, deployment misconfiguration, and security logging or monitoring failure.

## 3. Roles

Every incident must identify:

- incident owner
- technical owner
- evidence owner
- communications owner
- approval authority
- escalation owner
- recovery owner

One person may hold multiple roles in a small team, but the responsibilities must remain explicit.

## 4. Response Phases

Runbooks must cover applicable:

1. detection or report
2. triage
3. classification and severity
4. evidence preservation
5. containment
6. eradication or remediation
7. recovery
8. verification
9. communication
10. post-incident review
11. follow-up controls

## 5. Evidence First

Preserve required metadata before actions that may destroy or alter evidence.

Examples include token revocation, user suspension, MFA reset, export deletion, secret rotation, and deployment rollback.

## 6. Severity

Use a documented severity based on confirmed or suspected compromise, affected data, privilege, scope, availability, recoverability, regulatory or contractual impact, and evidence confidence.

## 7. Containment

Containment must identify owner authority, minimize additional harm, preserve evidence, avoid unnecessary data access, record actions, and use Auth, Identity, Access, Data Protection, Secrets, Deployment, or another owning capability.

Monitoring must not directly own domain remediation.

## 8. Communications

Communications must be authorized, accurate, need-to-know, privacy-safe, coordinated, and recorded.

Do not promise legal or regulatory conclusions without appropriate authority.

## 9. Recovery

Recovery requires known-good state, restored security controls, verified credentials, verified access, restored services and data, heightened monitoring when required, user or owner notification where applicable, and closure evidence.

## 10. Required Runbooks

Before production maturity, maintain runbooks for applicable incident response, account compromise, privileged-access incident, suspected data exposure, suspected data exfiltration, MFA reset and recovery, secret rotation, API-token compromise, critical vulnerability and emergency patch, supply-chain incident, forensic evidence collection, log export, and backup and recovery.

## 11. Post-Incident Review

Review timeline, root and contributing causes, control failures, detection quality, response effectiveness, evidence gaps, recovery, documentation and runbook changes, and follow-up issues and owners.

## 12. Exercises

Run tabletop or operational exercises appropriate to risk and maturity.

## 13. Tests And Evidence

High-risk response actions require permission, assurance, audit, notification, and recovery testing where implemented.

## 14. Related

- [Runbook Index](../../10-runbooks/index.md)
- [Digital Forensics Readiness And Evidence Handling Standards](Digital%20Forensics%20Readiness%20And%20Evidence%20Handling%20Standards.md)
- [Threat Detection And Response Standards](Threat%20Detection%20And%20Response%20Standards.md)
- [Incident Response Planning](../../07-planning/02-core-capabilities/audit-monitoring-response/incident-response-planning.md)
