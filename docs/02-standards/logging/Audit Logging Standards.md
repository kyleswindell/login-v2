<!--
DOC-META
title: Audit Logging Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/logging/Audit Logging Standards.md
parent: docs/02-standards/logging/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines accountable human and service events, stable names, event shape, after-commit recording, redaction, immutability, access, retention, and tests.
-->

# Audit Logging Standards

Parent: [Logging Standards Index](index.md)

## 1. Purpose

Record who or what performed a meaningful action, what was affected, the result, and the safe evidence required for accountability and reconstruction.

## 2. Event Semantics

The owning domain defines event key, trigger, subject and target, safe change set, reason, and business meaning.

Audit defines common storage and evidence rules.

## 3. Naming

Use stable domain-first event names:

    auth.login_succeeded
    identity.user_suspended
    access.role_updated
    data.export_downloaded
    secrets.rotated

Do not encode display labels into event keys.

## 4. Actor Types

Support applicable:

- user
- service
- system
- integration
- job
- console
- unknown

Non-human actors require stable identity and owner where applicable.

## 5. Event Shape

An event should support applicable event ID, occurred-at UTC, category, action, result, severity, actor type and ID, subject type and ID, target type and ID, request and correlation ID, session ID, route, command, job, service or integration, scope, reason, safe summary, redacted metadata, and safe change set.

## 6. Results

Use consistent results such as succeeded, failed, denied, skipped, and partial.

A failed expected authorization decision is not automatically an operational error.

## 7. After Commit

Successful mutation events must be recorded after commit.

Rolled-back changes must not leave successful audit events.

Failure and denial events may be recorded outside the mutation transaction when required.

## 8. Change Sets

Record only fields needed for accountability.

Mark sensitive fields and redact values.

Preserve safe display labels where raw values are prohibited.

## 9. Required Coverage

Audit applicable authentication and recovery, user lifecycle, permissions and policies, elevated access, settings and security-policy changes, sensitive view and export, secret lifecycle, service-account and token lifecycle, deployment approval and rollback, evidence access, privacy and retention workflows, and business-domain changes.

## 10. Immutability

Audit records must not be editable through normal application workflows.

Corrections should append explanatory evidence rather than rewrite history.

## 11. Access And Export

Audit access and export require explicit permissions and scope.

Sensitive evidence exports require private storage, recent authentication when applicable, and access audit.

## 12. Retention

Audit retention must preserve security and accountability needs while applying privacy and legal-hold rules.

## 13. Tests

Verify event shape, actor types, after-commit behavior, rollback behavior, redaction, denial coverage, immutability, scope, and evidence access.

## Related

- [Logging Standards](Logging%20Standards.md)
- [Digital Forensics Readiness And Evidence Handling Standards](../security/Digital%20Forensics%20Readiness%20And%20Evidence%20Handling%20Standards.md)
- [Audit And Monitoring Core Planning](../../07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md)
