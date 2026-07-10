<!--
DOC-META
title: Logging Standards Index
doc_type: index
status: draft
owner: ops
canonical: true
canonical_path: docs/02-standards/logging/index.md
parent: docs/02-standards/index.md
template: docs/09-reference/templates/docs/_index.md
summary: Routes audit logging, operational monitoring, error logging, health, telemetry, alerting, and evidence requirements.
-->


# Logging Standards Index

Parent: [Standards Index](../index.md)

## 1. Purpose

Separate accountable audit evidence from operational errors and telemetry.

## 2. Standards

| Document | Purpose |
| --- | --- |
| [Logging Standards](Logging%20Standards.md) | Shared principles, channel selection, sensitive-data safety, correlation, and fallback. |
| [Audit Logging Standards](Audit%20Logging%20Standards.md) | Accountable human and service events, event shape, after-commit behavior, redaction, immutability, and retention. |
| [Monitoring And Alerting Standards](Monitoring%20And%20Alerting%20Standards.md) | Exceptions, error logs, failed jobs, health checks, operational telemetry, signals, alert routing, and deduplication. |

## 3. Decision Rule

Use Audit when the action matters for accountability, security, compliance, or business history.

Use Monitoring when the system failed, degraded, timed out, retried, or produced abnormal operational state.

One operation may write both.

## 4. Related

- [Security Standards Index](../security/index.md)
- [Digital Forensics Readiness And Evidence Handling Standards](../security/Digital%20Forensics%20Readiness%20And%20Evidence%20Handling%20Standards.md)
- [Threat Detection And Response Standards](../security/Threat%20Detection%20And%20Response%20Standards.md)
- [Logging Operations](../../10-runbooks/logging-operations.md)
