<!--
DOC-META
title: Monitoring And Alerting Standards
doc_type: standard
status: draft
owner: ops
canonical: true
canonical_path: docs/02-standards/logging/Monitoring And Alerting Standards.md
parent: docs/02-standards/logging/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines error records, failed jobs, health checks, operational telemetry, signal severity, alert routing, deduplication, redaction, retention, and tests.
-->

# Monitoring And Alerting Standards

Parent: [Logging Standards Index](index.md)

## 1. Purpose

Record what failed, degraded, timed out, retried, or became operationally abnormal and route actionable alerts to the correct owners.

## 2. Monitoring Sources

Monitor applicable exceptions, application errors, failed jobs, queue backlog, scheduler failure, health checks, backup freshness, restore-drill status, mail and integration failures, realtime service health, deployment readiness, security detections, configuration drift, and resource pressure.

## 3. Error Record

An error should support applicable stable fingerprint, severity, message, exception class, safe location, environment, release or commit, request and correlation ID, actor when safe, route, job, command, or service, occurrence count, first and last seen, safe context, and status.

## 4. Redaction

Monitoring must exclude raw secrets, credentials, cookies, authorization headers, and unnecessary personal data.

Request redaction occurs before context is stored.

## 5. Severity

Monitoring uses the shared severity vocabulary defined by [Logging Standards](Logging%20Standards.md):

```text
informational
low
medium
high
critical
```

Use consistent severity based on availability impact, security impact, data impact, recurrence, and recoverability.

Severity represents the significance of the observed operational condition. It is not merely an exception class, framework log level, HTTP status, or whether an alert should be emitted.

Do not mark every exception high or critical. Do not create a second Monitoring-specific serialized severity scale.

## 6. Alerting

Alert only when an owner needs timely attention.

Alerting remains a separate decision based on whether an owner requires timely attention.

Alerts must identify source, severity, environment, owner, summary, evidence reference, runbook, deduplication key, and escalation.

## 7. Deduplication

Group repeated failures by stable fingerprint and window.

Avoid notification storms.

Preserve occurrence counts and timestamps.

## 8. Health Checks

A health check must identify check key, owner, target, expected condition, result, severity, last run, evidence, alert threshold, and runbook.

## 9. Failed Jobs

Record job identity, queue, attempts, correlation, safe failure, and final disposition.

Do not store sensitive job payloads.

## 10. Security Detection Boundary

Monitoring evaluates detection rules.

The owning security or domain capability defines containment.

Monitoring must not suspend users, rotate secrets, or revoke policies without an approved response action.

## 11. Persistence

Do not create new monitoring tables merely for dashboard convenience.

Persistence must support real triage, history, alert, or evidence needs.

## 12. Retention

Retain enough history for recurrence, investigation, and trend analysis while pruning sensitive detail intentionally.

## 13. Tests

Verify error capture, redaction, fallback, deduplication, alert routing, failed-job behavior, health thresholds, evidence links, and no notification storm.

## Related

- [Logging Standards](Logging%20Standards.md)
- [Threat Detection And Response Standards](../security/Threat%20Detection%20And%20Response%20Standards.md)
- [Logging Operations](../../10-runbooks/logging-operations.md)
- [Audit And Monitoring Core Planning](../../07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md)
