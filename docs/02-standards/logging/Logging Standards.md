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

## 4. Shared Severity

### Controlled Values

Use exactly these serialized values:

```text
informational
low
medium
high
critical
```

### Ordering

Significance increases:

```text
informational
    ↓
low
    ↓
medium
    ↓
high
    ↓
critical
```

### Meaning

- `informational`: Routine or expected evidence with ordinary accountability or operational significance.
- `low`: Limited security, data, privilege, availability, or operational significance.
- `medium`: Material significance with bounded potential or actual impact.
- `high`: Serious security, data, privilege, availability, or operational significance with substantial potential or actual impact.
- `critical`: Exceptional significance involving or enabling severe compromise, catastrophic data impact, system-wide loss of control, prolonged critical unavailability, or an equivalent emergency condition.

### Required Semantic Separation

Severity describes significance.

It does **not** describe:

- whether an operation succeeded;
- whether an operation failed;
- whether an event is security-related;
- whether an alert must be sent;
- an HTTP status code; or
- a framework logging level.

These are separate concerns:

```text
result
    = what happened?

severity
    = how significant is this evidence or condition?

classification
    = what kind of evidence/condition is this?

alerting
    = does an owner require timely attention?
```

### Cross-System Rule

Audit and Monitoring use these exact serialized values. Security detection standards use the same serialized vocabulary where detection severity is represented.

This does not require one shared PHP enum across capability owners. Provider-owned implementations may define their own typed enums so long as the serialized canonical values remain identical.

## 5. Correlation

Use request and correlation identifiers across applicable audit, errors, jobs, notifications, exports, integrations, deployments, and evidence.

## 6. Sensitive Data

Never log raw passwords, MFA values or secrets, recovery codes, full tokens, private keys, authorization headers, cookies, secret-manager values, or unrestricted personal or business payloads.

## 7. Safe Context

Prefer IDs, stable event keys, safe labels, classifications, counts, fingerprints, status, result, request identifiers, and trace identifiers.

## 8. Fallback

Logging failures must not cause a second outage.

Use safe framework fallback channels when database-backed logging fails.

Fallback must preserve redaction.

## 9. Retention

Audit and Monitoring may require different retention.

Retention must consider evidence, privacy, incident, performance, and legal-hold requirements.

## 10. Access

Log and evidence access requires least privilege and target scope.

Detailed error logs and raw audit context remain app-instance-local by default.

## 11. Completion

A new security-sensitive workflow is incomplete until its required audit, monitoring, correlation, redaction, and tests are defined.

## Related

- [Audit Logging Standards](Audit%20Logging%20Standards.md)
- [Monitoring And Alerting Standards](Monitoring%20And%20Alerting%20Standards.md)
- [Audit And Monitoring Core Planning](../../07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md)
