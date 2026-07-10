<!--
DOC-META
title: Threat Detection And Response Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Threat Detection And Response Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines detection IDs, source evidence, rules, severity, signal lifecycle, alert routing, playbook mapping, automation limits, tuning, and testing.
-->

# Threat Detection And Response Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Detection Record](#2-detection-record)
- [3. Source Evidence](#3-source-evidence)
- [4. Severity](#4-severity)
- [5. Signal Lifecycle](#5-signal-lifecycle)
- [6. Notifications](#6-notifications)
- [7. Response Playbooks](#7-response-playbooks)
- [8. Automation Boundaries](#8-automation-boundaries)
- [9. False Positives And Tuning](#9-false-positives-and-tuning)
- [10. Initial Priority](#10-initial-priority)
- [11. Evidence](#11-evidence)
- [12. Tests](#12-tests)
- [13. Related](#13-related)

## 1. Purpose

Turn normalized Audit and Monitoring evidence into bounded security signals and mapped response actions.

Do not build a SIEM or SOAR clone inside the application.

## 2. Detection Record

A detection use case must identify:

- stable ID
- threat
- source evidence
- grouping key
- threshold or trigger
- window
- severity
- owner
- required evidence
- notification
- response playbook
- allowed automation
- required manual action
- tests
- status

## 3. Source Evidence

Detections may consume audit events, monitoring events, failed jobs, health checks, data movement events, vulnerability findings, supply-chain checks, deployment checks, and external safe summaries.

Do not store raw secrets or unrestricted payloads.

## 4. Severity

Use:

- informational
- low
- medium
- high
- critical

Severity must reflect actual impact and confidence rather than alert visibility.

## 5. Signal Lifecycle

When persisted, use:

- new
- triaged
- investigating
- contained
- resolved
- false positive
- accepted risk

Do not mark a signal resolved without evidence.

## 6. Notifications

Critical and high signals require durable routing to approved owners.

Personal preferences must not disable mandatory security notifications.

Deduplicate repeated signals within the active detection window.

## 7. Response Playbooks

Each high-risk detection should link to an existing runbook.

Playbook metadata should identify required permission, MFA or recent-auth requirement, manual steps, automation limits, and audit events.

## 8. Automation Boundaries

Low-risk automation may create a signal, create a notification, link a runbook, apply approved throttling, or expire a generated export.

High-risk actions such as suspending users, revoking broad access, or rotating secrets require manual approval until explicit automated-response controls exist.

Owning capabilities execute containment.

## 9. False Positives And Tuning

A detection must have tuning owner, threshold rationale, false-positive handling, review cadence, and evidence of changed thresholds.

Do not suppress a signal without preserving the tuning decision.

## 10. Initial Priority

First implementation should remain narrow and may include:

- failed-login spike
- failed-MFA spike
- denied-access spike
- sensitive-export spike
- critical failed job or health signal

## 11. Evidence

A signal must retain enough safe context for triage without becoming a duplicate raw log store.

## 12. Tests

Verify trigger and non-trigger windows, deduplication, severity, routing, playbook mapping, false-positive state, automation boundaries, and no raw sensitive metadata.

## 13. Related

- [Threat Modeling And Security Controls Standards](Threat%20Modeling%20And%20Security%20Controls%20Standards.md)
- [Security Incident Response Standards](Security%20Incident%20Response%20Standards.md)
- [Monitoring And Alerting Standards](../logging/Monitoring%20And%20Alerting%20Standards.md)
- [Threat Detection And Response Planning](../../07-planning/02-core-capabilities/audit-monitoring-response/threat-detection-response-planning.md)
- [Detection Use Case Matrix](../../07-planning/02-core-capabilities/audit-monitoring-response/detection-use-case-matrix.md)
