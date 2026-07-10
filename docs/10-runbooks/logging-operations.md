<!--
DOC-META
title: Logging Operations
doc_type: runbook
status: active
owner: ops
canonical: true
canonical_path: docs/10-runbooks/logging-operations.md
parent: docs/10-runbooks/index.md
template: docs/09-reference/templates/docs/_runbook.md
summary: Defines authorized audit and error-log inspection, triage, evidence handling, escalation, and service-log diagnostics.
-->

# Logging Operations

Parent: [Runbook Index](index.md)

## Purpose

Inspect audit and error evidence, classify operational findings, preserve safe evidence, and escalate actionable failures.

## Operational Surfaces

Application routes may include:

- `/platform/operations/audit-logs`
- `/platform/operations/error-logs`
- `/platform/error-logs/{log}`

Use the current route list to confirm exact paths:

    php artisan route:list --path=platform

## Prerequisites

- authorized operator account
- required route permissions
- correct environment
- incident or issue identifier when investigation is material
- secure evidence destination
- understanding of sensitive-data restrictions

## Audit Log Review

Use audit logs to answer:

- who acted
- what action occurred
- what target was affected
- what scope applied
- when it happened
- whether the result succeeded or failed

Verify object-level and tenant/workspace scope.

Do not use audit logs as authorization to access unrelated records.

## Error Log Review

Use error logs to identify:

- exception type
- message
- timestamp
- request or correlation identifier
- affected route or job
- actor and scope when safely available
- recurrence
- deployment or release context

Do not copy full stack traces into public issues.

## Server Application Logs

From the application root:

    tail -n 200 storage/logs/laravel.log

For focused search:

    rg -n "<correlation-id-or-exception>" storage/logs

## Service Logs

Reverb:

    journalctl -u platform-reverb -n 200 --no-pager

Queue worker:

    journalctl -u platform-queue-worker -n 200 --no-pager

Apache:

    sudo tail -n 200 /var/log/apache2/error.log

PHP-FPM:

    journalctl -u php8.3-fpm -n 200 --no-pager

## Triage

Classify the finding:

- expected denied action
- validation failure
- application defect
- infrastructure failure
- security event
- privacy or data event
- queue or service failure
- transient external dependency failure
- unknown

Record severity and affected scope.

## Evidence Handling

Retain only what is required:

- timestamp
- environment
- release or commit
- route or job
- correlation identifier
- sanitized error summary
- affected scope
- reproduction steps
- operator actions

Redact:

- passwords
- tokens
- session values
- private keys
- personal data not needed for investigation
- customer payloads
- secret configuration

## Escalation

Escalate immediately when:

- unauthorized access may have occurred
- cross-tenant or cross-workspace data exposure is suspected
- credentials or secrets appear in logs
- destructive data change occurred
- repeated failures affect availability
- evidence preservation is required
- the operator cannot safely classify the event

Do not alter or delete relevant evidence while escalation is pending.

## Corrective Action

Use the appropriate issue or incident process.

Do not apply speculative production fixes from the log viewer.

After a fix:

- deploy through the approved procedure
- verify the original failure path
- verify no new errors
- update canonical docs or runbooks when the procedure changed

## Completion Criteria

Log review is complete when:

- the finding is classified
- affected scope is understood
- sensitive evidence is protected
- issue or incident tracking exists when required
- corrective action is assigned
- verification or escalation is recorded

## Related

- [Realtime Notifications And Reverb](realtime-notifications-and-reverb.md)
- [Staging Deployment](staging-deployment.md)
- [Scheduler Operations](scheduler-operations.md)
