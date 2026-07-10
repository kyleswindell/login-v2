<!--
DOC-META
title: Offensive Security And Penetration Testing Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Offensive Security And Penetration Testing Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines authorization, rules of engagement, target environments, test perspectives, evidence safety, finding handoff, remediation, retest, and release impact.
-->

# Offensive Security And Penetration Testing Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Authorization](#2-authorization)
- [3. Environments](#3-environments)
- [4. Rules Of Engagement](#4-rules-of-engagement)
- [5. Test Perspectives](#5-test-perspectives)
- [6. Test Accounts And Data](#6-test-accounts-and-data)
- [7. DAST](#7-dast)
- [8. Evidence](#8-evidence)
- [9. Findings](#9-findings)
- [10. Remediation And Retest](#10-remediation-and-retest)
- [11. Production Safety](#11-production-safety)
- [12. Release Impact](#12-release-impact)
- [13. Completion](#13-completion)
- [14. Related](#14-related)

## 1. Purpose

Govern authorized attacker-perspective testing without creating unsafe production testing, uncontrolled exploit activity, or public evidence exposure.

## 2. Authorization

Every offensive test requires owner, objective, target, environment, scope, exclusions, time window, allowed techniques, stop conditions, communication path, evidence location, and cleanup owner.

Unapproved testing is prohibited.

## 3. Environments

Use isolated or staging environments by default.

Production testing is denied by default and requires explicit approval, scope, scheduling, monitoring, recovery, and incident coordination.

## 4. Rules Of Engagement

Define targets, credentials and roles, data handling, destructive actions, denial-of-service restrictions, social-engineering restrictions, third-party restrictions, rate limits, evidence collection, and emergency stop.

## 5. Test Perspectives

Where applicable, test unauthenticated, normal authenticated, privileged, wrong-object, wrong-scope, inactive identity, compromised session, service account, API and webhook, file and export, and deployment and configuration perspectives.

## 6. Test Accounts And Data

Use approved seeded accounts and safe test data.

Do not use real customer records unless explicitly required and protected.

## 7. DAST

Authenticated DAST requires an approved target, scanner configuration, seeded accounts, rate and safety limits, expected report, private evidence, triage, and cleanup.

A failed required scan may block release.

## 8. Evidence

Evidence must be private and redacted.

Do not place working exploit payloads, credentials, restricted screenshots, or raw personal data in public issues.

## 9. Findings

All validated findings follow Vulnerability Management Standards.

Duplicate findings should reference the canonical finding.

## 10. Remediation And Retest

High and critical findings require retest before closure.

Retest must verify the original attack path and relevant regressions.

## 11. Production Safety

Stop testing when availability degrades, unintended data changes occur, scope is uncertain, third-party systems are affected, evidence exposes secrets, or incident conditions arise.

## 12. Release Impact

Open critical or high findings affect release according to the vulnerability and secure-delivery standards.

## 13. Completion

Testing is complete when evidence is stored safely, findings are triaged, cleanup is complete, affected credentials are rotated when needed, and retest requirements are tracked.

## 14. Related

- [Security Testing Standards](Security%20Testing%20Standards.md)
- [Vulnerability Management Standards](Vulnerability%20Management%20Standards.md)
- [Offensive Security And Penetration Testing Planning](../../07-planning/02-core-capabilities/security/offensive-security-penetration-testing-planning.md)
