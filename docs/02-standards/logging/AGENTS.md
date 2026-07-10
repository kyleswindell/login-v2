# AGENTS.md

## Folder Purpose

This folder owns canonical audit logging, operational monitoring, error logging, health, telemetry, and alerting standards.

Audit answers who or what performed an accountable action.

Monitoring answers what failed, degraded, or looks abnormal.

## Required Reading

1. Read `index.md`.
2. Read `Audit Logging Standards.md` for accountability events.
3. Read `Monitoring And Alerting Standards.md` for errors, failed jobs, health, telemetry, and operational signals.
4. Read security evidence and response standards when the change is security-sensitive.

## Avoid

- Do not combine audit and error records into one conceptual store.
- Do not log secrets or raw sensitive payloads.
- Do not use audit rows as an incident ticket system.
- Do not treat every exception as an audit event.
- Do not make feature packages invent independent logging schemas.
- Do not place executable log-review procedures here.

## Related

- [Logging Standards Index](index.md)
- [Security Standards Index](../security/index.md)
- [Logging Operations](../../10-runbooks/logging-operations.md)
