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
summary: Defines accountable Action events using Principal-based Actor attribution, machine and network assurance, Invocation Channel, scope, redaction, immutability, and tests.
-->

# Audit Logging Standards

Parent: [Logging Standards Index](index.md)

## 1. Purpose

Record who or what performed or initiated a meaningful Action, what was affected, the result, the Tenant Instance scope, and the safe evidence required for accountability and reconstruction.

## 2. Event Semantics

The owning capability defines:

- Action key and meaning
- Target meaning
- trigger conditions
- safe change set
- reason requirements
- business context

Audit defines the common evidence envelope and storage rules.

## 3. Naming

Use stable domain-first Action names:

```text
auth.login_succeeded
identity.user_account_suspended
access.role_updated
data.export_downloaded
secrets.rotated
```

Do not encode display labels into event keys.

## 4. Actor

Actor is the full attributed operation initiator:

```text
Actor
├── Principal
├── Machine Identity
├── Network Identity
└── Network Context
```

The Principal type must be one of the applicable persistent identity categories:

- `user_account`
- `service_account`
- `workload`
- `application`
- `system`

A named System Actor requires a stable key and bounded purpose.

Do not classify these as Principal or Actor types:

- job
- console
- API
- webhook
- scheduler
- event
- route
- IP address

Those belong to Invocation Channel or other execution metadata.

Absence of an attributed Principal is permitted when the event occurs before authentication or another authoritative Principal attribution has been established.

Do not invent Principal types such as:

- `anonymous`
- `guest`
- `unknown`
- `external`

For a pre-authentication attempt:

- Principal type and ID may be absent;
- a safely resolved User Account may be the Target without being attributed as Actor;
- an unresolved claimed account produces no User Account Target;
- the raw claimed login identifier must not be stored merely to compensate for missing Principal attribution.

A known Target does not imply that the Target was the Actor.

When the event semantics require an attributed Principal and one should already exist, missing attribution remains an integration error.

## 5. Invocation Channel

Record the immediate applicable Invocation Channel:

- `interactive_web`
- `api_request`
- `webhook_request`
- `console_command`
- `queued_job`
- `event_consumer`
- `scheduled_task`
- `internal_system`

A channel does not replace Principal attribution and does not grant authority.

## 6. Event Shape

An audit event should support applicable:

- event ID
- occurred-at UTC
- category
- Action
- Result
- severity
- Principal type and ID when an Actor Principal has been authoritatively attributed
- User Account, NHI, or System Actor stable key
- Machine Identity reference and safe assurance snapshot
- Network Identity reference and verification state
- Network Context
- Invocation Channel
- Subject and Target type and ID
- Actor Tenant and Instance scope
- target Tenant and Instance scope when different
- request, trace, and correlation identifiers
- session ID when applicable
- route, command, job, event, or webhook metadata
- reason or support-case reference
- safe summary
- redacted metadata
- safe change set

Do not store raw credentials, private keys, reusable tokens, authorization headers, cookies, MFA material, or secret-bearing certificates.

## 7. Severity

Audit uses the shared severity vocabulary defined by [Logging Standards](Logging%20Standards.md):

```text
informational
low
medium
high
critical
```

The domain owner that defines the Audit event semantics supplies the event severity. Audit validates the value, persists it, and exposes it through Audit evidence and query Contracts.

Audit must not infer severity solely from Result, event key, `is_security_event`, HTTP status, Monitoring severity, or framework logging level.

Valid examples:

```text
secrets.secret_revealed
result: succeeded
severity: high

auth.login_failed
result: failed
severity: low

security.control_disabled
result: succeeded
severity: critical
```

A successful event may be high or critical. A failed or denied event may be informational or low.

`is_security_event` and severity are independent:

```text
is_security_event
    = security classification

severity
    = significance
```

Result and severity are independent:

```text
result
    = outcome

severity
    = significance
```

Audit severity must not itself route alerts. Monitoring and Threat Detection own operational or security attention and alert-triggering behavior.

## 8. Results

Use consistent values such as:

- succeeded
- failed
- denied
- skipped
- partial

A failed expected authorization decision is not automatically an operational error.

## 9. Scope

Tenant-owned events must identify Tenant and Instance.

Workspace may be recorded as resolved runtime context, but must not replace Tenant and Instance scope.

Global Administration events must preserve:

- Internal Tenant Actor scope
- target Tenant
- target Instance
- explicit cross-Instance Action and Target

## 10. Causal Attribution

When an operation continues asynchronously, retain applicable correlation and initiating Principal evidence while attributing the current execution to its actual Principal.

Example:

```text
Current Principal: export-worker Workload Identity
Invocation Channel: queued_job
Initiating User Account: 42
Action: report.generated
```

Do not overwrite the current Actor with the original User Account when a Workload Identity performs the operation.

## 11. After Commit

Successful mutation events must be recorded after commit.

Rolled-back changes must not leave successful audit events.

Failure and denial events may be recorded outside the mutation transaction when required.

## 12. Change Sets And Redaction

Record only fields required for accountability.

Mark sensitive fields and redact values.

Preserve safe display labels where raw values are prohibited.

## 13. Required Coverage

Audit applicable:

- authentication and recovery
- User Account lifecycle
- roles, permissions, policies, and elevated access
- Global Administration
- settings and security-policy changes
- sensitive reads and exports
- secret and credential lifecycle
- NHI lifecycle
- API and webhook access
- queued, scheduled, event-consumer, and console execution
- deployment approval and rollback
- evidence access
- privacy and retention workflows
- business-domain mutations

## 14. Immutability

Audit records must not be editable through normal application workflows.

Corrections should append explanatory evidence rather than rewrite history.

## 15. Access, Export, And Retention

Audit access and export require explicit permissions and Tenant Instance scope.

Sensitive evidence exports require private storage, recent authentication when applicable, and access audit.

Retention must preserve security and accountability needs while applying privacy, erasure, and legal-hold rules.

## 16. Tests

Verify:

- event shape
- Principal type
- Machine and Network assurance separation
- Invocation Channel
- Tenant and Instance scope
- cross-Instance Global Administration attribution
- after-commit and rollback behavior
- redaction
- denial coverage
- immutability
- evidence access
- jobs and commands are not stored as Principal types
- legitimate pre-authentication evidence with no attributed Principal
- known attempted User Account represented as Target rather than Actor
- unresolved claimed account producing no fabricated Principal or Target
- no anonymous/guest/unknown Principal type used as a substitute for absent attribution

## 17. Related

- [ADR-0006](../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [Logging Standards](Logging%20Standards.md)
- [Tenant And Scope Isolation Standards](../security/Tenant%20And%20Scope%20Isolation%20Standards.md)
- [Digital Forensics Readiness And Evidence Handling Standards](../security/Digital%20Forensics%20Readiness%20And%20Evidence%20Handling%20Standards.md)
- [Audit And Monitoring Core Planning](../../07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md)
