<!--
DOC-META
title: Logging Standards
doc_type: standard
status: draft
owner: ops
canonical: true
canonical_path: docs/02-standards/logging/Logging Standards.md
parent: docs/02-standards/logging/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines shared audit and monitoring channel selection, correlation, sensitive-data safety, fallback, ownership, and completion requirements.
-->

# Logging Standards

Parent: [Logging Standards Index](index.md)

## 1. Purpose

Define shared rules for Audit and Monitoring without combining their responsibilities.

## 2. Channel Selection

Use Audit for accountable actions.

Use Monitoring for failures, health, and operational state.

Use both when an accountable action also failed unexpectedly.

## 3. Ownership

Domains own the meaning of their audit events.

Audit owns event storage, common shape, query behavior, redaction enforcement, and evidence access.

Monitoring owns error records, failed jobs, health, telemetry, detection inputs, and operational alerting.

## 4. Correlation

Use request and correlation identifiers across applicable audit, errors, jobs, notifications, exports, integrations, deployments, and evidence.

## 5. Sensitive Data

Never log raw passwords, MFA values or secrets, recovery codes, full tokens, private keys, authorization headers, cookies, secret-manager values, or unrestricted personal or business payloads.

## 6. Safe Context

Prefer IDs, stable event keys, safe labels, classifications, counts, fingerprints, status, result, request identifiers, and trace identifiers.

## 7. Fallback

Logging failures must not cause a second outage.

Use safe framework fallback channels when database-backed logging fails.

Fallback must preserve redaction.

## 8. Retention

Audit and Monitoring may require different retention.

Retention must consider evidence, privacy, incident, performance, and legal-hold requirements.

## 9. Access

Log and evidence access requires least privilege and target scope.

Detailed error logs and raw audit context remain app-instance-local by default.

## 10. Completion

A new security-sensitive workflow is incomplete until its required audit, monitoring, correlation, redaction, and tests are defined.

## Related

- [Audit Logging Standards](Audit%20Logging%20Standards.md)
- [Monitoring And Alerting Standards](Monitoring%20And%20Alerting%20Standards.md)
- [Audit And Monitoring Core Planning](../../07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md)
