# Threat Detection And Response Planning

Status: Planning

## Purpose

Plan Threat Detection and Response as the operational layer that turns security evidence into detection signals, notifications, response playbooks, containment actions, and follow-up improvements.

This is not a business module, not a Laravel SIEM clone, and not a dashboard-first feature. This planning document defines how existing Core capabilities should work together before app-visible security operations surfaces are built.

## Direction

Threat Detection and Response should follow this chain:

```text
Core/Audit
  -> records normalized security evidence

Core/Monitoring
  -> detects suspicious signals, anomalies, failed jobs, health issues, and threat patterns

Core/Audit / Forensics
  -> preserves correlated evidence and reconstructs timelines

Core/Notifications
  -> alerts required users, admins, and security owners

Core/Auth / Identity / Access / DataProtection / Secrets
  -> perform containment and remediation actions

Runbooks
  -> define human response workflow

Security docs/tests
  -> prove detections and responses exist
```

Implementation rule:

```text
Threat
  -> detection use case
  -> audit/monitoring signal
  -> notification/escalation
  -> response playbook
  -> test
```

## Ownership

| Owner | Responsibility |
| --- | --- |
| `app/Core/Audit` | Immutable evidence, actor/subject/target/change-set, security event catalog, sensitive action trail. |
| `app/Core/Audit/Forensics` | Timeline reconstruction, evidence package metadata, evidence manifests, chain-of-custody metadata, and evidence export support after Audit/Monitoring foundations exist. |
| `app/Core/Monitoring` | Threat signals, anomaly rules, detection use cases, incident candidates, alert severity, health/error/failed-job context. |
| `app/Core/Monitoring/ThreatDetection` | Detection rule registry, signal rules, detection severity/status, detection windows, correlation helpers. |
| `app/Core/Monitoring/ThreatResponse` | Response playbook registry, security case metadata later, response orchestration records later. |
| `app/Core/Notifications` | Alert delivery, persistent security notifications, escalation notices. |
| `app/Core/Security` | Detection/control catalog alignment, route/release coverage checks, security-control traceability. |
| `app/Core/Auth` | Session revocation, password reset requirements, MFA challenge lock/re-enrollment, trusted-device revocation later. |
| `app/Core/Identity` | User suspension, deactivation, account status review. |
| `app/Core/Access` | Elevated-session revocation, policy/role review, direct exception removal, access review requirements. |
| `app/Core/DataProtection` | Export expiration, signed link revocation, exposure scope, data review requirements. |
| `app/Core/Security/Secrets` | Secret revocation, rotation-required state, reveal blocking, leak handling. |
| `docs/10-runbooks` | Human response workflow, containment procedure, recovery, evidence handling, post-incident review. |

Monitoring may orchestrate or recommend response. Domain owners execute containment and remediation actions.

## Do Not Build

Do not create:

```text
Modules/ThreatDetection
Modules/ThreatDetectionResponse
Modules/TDR
Modules/SOC
```

Do not build:

- a full SIEM clone
- a full SOAR automation engine
- a machine-learning anomaly system
- XDR integrations before local event shape is stable
- security case dashboards before detections exist
- automatic user suspension for every suspicious signal
- noisy alerting for every failed login

## IBM Concept Mapping

Use external security-platform vocabulary as planning context, not as a mandate to build every tool in the app:

| Security Concept | Login 2.0 Implementation |
| --- | --- |
| SIEM | Normalized audit/security/monitoring event stream and future export. |
| SOAR | Response playbook registry plus controlled response actions. |
| ITDR | Auth, Identity, Access, MFA, privilege escalation, and login-behavior detections. |
| UEBA/UBA | Threshold and baseline-based anomaly rules for users and service actors. |
| DDR/DLP | Sensitive data access, export, download, and exfiltration-style detections. |
| XDR | Future export/forwarding of app events to external security tools. |
| EDR/NDR/IDS/IPS | Infrastructure/vendor layer; the app should emit useful signals only. |
| Threat hunting | Queryable audit and monitoring evidence for suspicious patterns. |
| Forensics | Preserved incident evidence, timelines, actor/subject/target records. |

## Event Pipeline

First pipeline direction:

```text
Domain action occurs
  -> Core/Audit records event after commit
  -> Core/Monitoring consumes audit/operational event
  -> detection rules evaluate event/window
  -> detection signal or finding is created
  -> Core/Notifications alerts owner/admin/security role
  -> optional response action is recommended or executed
  -> runbook/case is linked
```

Recommended event flow after Audit and Monitoring foundations exist:

```text
AuditEventRecorded
  -> AnalyzeSecurityEventJob
  -> DetectionRuleRegistry
  -> DetectionSignalService
  -> NotificationService
  -> optional ResponseOrchestrator
```

Detection should not run all correlation synchronously inside the user request. Use events and jobs where possible.

## Normalized Security Event Shape

Detection requires consistent telemetry. Audit and Monitoring planning should support these fields where applicable:

```text
event_id
occurred_at
category
action
result
severity

actor_type
actor_id
actor_display

subject_type
subject_id
subject_display

target_type
target_id
target_display

ip_address
user_agent
session_id
request_id
trace_id

route_name
http_method
url_path

environment
service_name
job_id
queue

data_classification
risk_level
metadata
```

Detection rules need enough safe context to answer:

```text
who
what
where
when
result
resource
scope
classification
session/request context
```

Do not store raw secrets, submitted MFA codes, raw passwords, recovery codes, full token values, full cookies, full private keys, or unnecessary sensitive payload values.

## Detection Categories

Initial categories:

| Category | Examples |
| --- | --- |
| `AUTH` | Brute force, failed MFA spike, recovery code abuse, suspicious login, new device login, disabled MFA. |
| `IDENTITY` | Suspicious user creation, suspension/deactivation misuse, MFA reset abuse, last Super Admin protection triggered. |
| `ACCESS` | Repeated denied access, privilege escalation attempt, direct access exception, Super Admin assignment, elevated access anomaly, separation-of-duties conflict attempt. |
| `DATA` | Export spike, sensitive download spike, view/export bypass attempt, cross-customer access attempt, sensitive field access spike. |
| `DLP` | Restricted export, export/download/view spikes, session/response exfiltration thresholds, cross-scope sensitive access, public export exposure. |
| `SECRETS` | Secret reveal, reveal spike, expired secret used, failed secret access, secret leak finding. |
| `APPLICATION` | CSRF-like method anomaly, unsafe redirect attempt, file upload rejection spike, validation abuse spike. |
| `API` | Invalid token spike, expired/revoked token use, scope violation spike, high request volume, unusual token source. |
| `WEBHOOK` | Invalid signature spike, replay attempt, processing failure, provider backlog, disabled endpoint traffic. |
| `SERVICE_ACCOUNT` | Service account used outside expected scope, disabled account used, missing owner, stale access, token unrotated beyond policy. |
| `OPERATIONS` | Failed jobs, backup check failed, health check failed, queue stalled, mail delivery failed. |
| `OFFENSIVE` | Open critical/high pen-test finding, retest required, unsafe/missing evidence, DAST failure, unapproved test scope. |
| `SUPPLY_CHAIN` | Critical package finding, lockfile drift, SBOM failure, secret scan failure, artifact mismatch, scanner unavailable, accepted risk expired, abandoned package detected. |
| `VULNERABILITY` | Critical finding detected, accepted risk expired, release blocked, scanner/check failed. |

Cloud and deployment hardening direction is tracked in [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md). TDR should consume deployment readiness failures, backup failures, TLS expiry, public exposure findings, configuration drift signals, and release-blocking vulnerability findings as Monitoring signals after those checks exist.

API, webhook, and service-account security direction is tracked in [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md). TDR should consume invalid API tokens, scope violations, webhook signature failures, replay attempts, stale service accounts, and token rotation failures as Monitoring signals after machine-access surfaces exist.

Offensive security direction is tracked in [Offensive Security And Penetration Testing Planning](offensive-security-penetration-testing-planning.md). TDR should consume open critical/high pen-test findings, retest-required states, unsafe or missing evidence, DAST staging failures, and unapproved test-scope signals after offensive security workflow exists.

Software supply-chain direction is tracked in [Software Supply Chain Security Planning](software-supply-chain-security-planning.md). TDR should consume critical package findings, lockfile drift, SBOM failures, detect-secrets failures, artifact integrity mismatches, scanner failures, expired accepted supply-chain risks, and abandoned package signals after supply-chain checks exist.

DLP and exfiltration direction is tracked in [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md). TDR should consume DLP movement decisions, export/download events, sensitive view counts, API/webhook response evaluations, notification redaction events, storage exposure checks, and cross-scope sensitive access denials after DataProtection and Audit baselines exist.

Digital forensics readiness is tracked in [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md) and the [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md). TDR should keep detection evidence correlated by request, session, actor, subject, target, and time range so response runbooks can reconstruct what happened without relying on dashboards after the fact.

## First Detection Rules

First implementation should be narrow:

```text
DET-AUTH-001 failed login spike
DET-AUTH-002 failed MFA spike
DET-ACCESS-001 denied admin/access spike
DET-DATA-002 export spike
DET-DLP-007 session exfiltration threshold exceeded
DET-OPS-001 failed job or critical health signal
```

These rules are enough to validate the pipeline without pretending the app has a mature SOC system.

## Severity Model

Use a small severity model:

```text
info
low
medium
high
critical
```

Suggested meaning:

| Severity | Meaning |
| --- | --- |
| `critical` | Active data exposure, successful privilege escalation, confirmed compromise, secret leak, backup failure during active incident. |
| `high` | Repeated MFA failures, Super Admin assignment, restricted export, elevated access misuse, critical vulnerability finding. |
| `medium` | Repeated denied access, failed reset spike, large export, unusual login. |
| `low` | Single denied access, single failed login, noncritical health warning. |
| `info` | Normal security-sensitive event worth visibility. |

## Status Model

Detection signals or cases should eventually use:

```text
new
triaged
investigating
contained
resolved
false_positive
accepted_risk
```

This supports investigation, containment, remediation, recovery, false-positive tuning, and post-incident improvement.

## Response Playbooks

First response playbook keys:

```text
account-compromise
privileged-access-incident
suspected-data-exposure
secret-leak
failed-backup
critical-vulnerability
```

Playbook metadata should map:

```text
playbook key
label
runbook path
detection keys
manual steps
allowed automated actions
required permissions
recent-auth/MFA requirement
audit event keys
```

## Response Action Boundaries

Allowed automation should start conservative:

| Automation Level | Examples | First-Build Rule |
| --- | --- | --- |
| Low risk | Create persistent notification, mark signal new, link runbook, require review, expire generated export file, throttle repeated requests. | Can be automated after tests and audit coverage exist. |
| Medium risk | Revoke elevated session, require recent auth, force MFA re-challenge, disable export download link. | Prefer manual approval until response evidence is mature. |
| High risk | Suspend user, revoke all sessions, revoke access policy, rotate secret. | Manual approval only for MVP. |

Every response action must be executed by the owning Core capability and audited.

## Notification Types

Planned persistent notification type keys:

```text
security.detection.critical
security.detection.high
security.auth.failed_mfa_spike
security.access.denied_spike
security.access.privilege_change
security.data.export_spike
security.data.restricted_export
security.secrets.reveal_spike
security.ops.backup_failed
security.vulnerability.release_blocked
```

Notification routing:

| Severity | Routing |
| --- | --- |
| Critical | Notify security owners/admins immediately. Persistent inbox required. Future email if configured. |
| High | Persistent inbox required. Future email/digest depending policy. |
| Medium | Persistent inbox or dashboard summary depending detection type. |
| Low/Info | Audit only or dashboard only unless configured. |

Persistent security notifications are durable system records and must not be disabled by personal notification preferences.

## Optional Folder Direction

Minimal first folder:

```text
app/Core/Monitoring/ThreatDetection/
  Data/
  Enums/
  Queries/
  Services/
  Support/
```

Later response/case folder:

```text
app/Core/Monitoring/ThreatResponse/
  Actions/
  Data/
  Enums/
  Models/
  Queries/
  Services/
```

Keep first implementation lightweight: rule registry, detection DTOs, query services, severity/status enums, and notification bridging.

## Optional Persistence

Do not add tables until there is a clear triage/reporting/UI need. Start with Audit and Monitoring queries.

If persistence is needed later:

| Table | Purpose |
| --- | --- |
| `detection_signals` | Persisted detection signal/finding records. |
| `security_cases` | Triage/case workflow records. |
| `security_case_events` | Timeline of evidence, notes, status changes, and response actions. |

Candidate `detection_signals` fields:

```text
id
key
category
severity
status
title
summary
source_type
source_id
actor_type
actor_id
subject_type
subject_id
target_type
target_id
window_started_at
window_ended_at
count
risk_score
metadata
created_at
updated_at
resolved_at
```

## Admin Surface Direction

Delay UI until Audit and Monitoring foundations exist and first detection signals are real.

Potential future surface:

```text
Admin
  Security
    Overview
    Detection signals
    Security cases
    Response playbooks
    Detection rules
```

First usable signal table columns:

```text
Severity
Signal
Category
Actor
Subject
Target
Count
Window
Status
Created
Actions
```

## Implementation Sequence

### 1. Planning Baseline

- Create this planning document.
- Create [Detection Use Case Matrix](detection-use-case-matrix.md).
- Add detection IDs and response playbook keys.
- Map high-risk threats to audit events and runbooks.
- Update the Core Service Build Plan Matrix.

### 2. Event Readiness

- Ensure Audit event shape includes actor, subject, target, result, IP, session, route, request, and trace context where applicable.
- Ensure sensitive Auth, Access, DataProtection, Secrets, and Vulnerability events write after commit.
- Ensure Monitoring can query audit events by action, category, time, actor, and target.
- Ensure Notifications can send required security alerts.

### 3. First Detection Rules

Implement only:

```text
DET-AUTH-001 failed login spike
DET-AUTH-002 failed MFA spike
DET-ACCESS-001 denied admin/access spike
DET-DATA-002 export spike
DET-OPS-001 failed job or critical health signal
```

### 4. Response Playbooks

Add runbook links for:

```text
account-compromise
privileged-access-incident
suspected-data-exposure
failed-backup
critical-vulnerability
```

### 5. Admin UI

Only after signals exist:

- detection signals table
- signal detail
- runbook link
- triage status
- related audit events

## Test Planning

First tests:

- failed MFA spike creates a detection signal
- denied access spike creates a detection signal
- export spike creates a detection signal
- secret reveal signal can be generated once Secrets exists
- backup failure signal can be generated once backup checks exist
- high/critical detection creates a persistent notification
- detection maps to a runbook
- response playbook maps to detection
- response action is audited
- high-risk automated response requires permission and recent auth or manual approval

## Transition Rules

- Do not create `Modules/ThreatDetectionResponse`.
- Do not build a dashboard before signals, runbooks, and evidence exist.
- Do not run correlation-heavy detection synchronously in user requests.
- Do not treat every failed login as a security incident.
- Do not notify noisily for low-value events.
- Do not store raw secrets or unnecessary sensitive values in detection metadata.
- Do not let Monitoring own Auth, Identity, Access, DataProtection, Secrets, or Vulnerability remediation mechanics.
- Do not automate high-risk containment without explicit approval controls, audit evidence, and tests.

## Open Decisions

- Should the first detection implementation persist `detection_signals`, or derive signals from Audit/Monitoring queries until a UI exists?
- Which first runbook should be promoted before detection signals exist?
- Which users/groups are initial security owners for critical/high notifications?
- Should detection rules be code-only, manifest-declared, DB-projected, or mixed?
- Which high-risk response actions require recent auth, MFA, elevated access, or two-person approval?
- What is the first SIEM/export boundary after internal event shape stabilizes?

## Related

- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Threat Modeling And Security Controls Planning](threat-modeling-security-controls-planning.md)
- [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md)
- [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md)
- [Incident Response Planning](incident-response-planning.md)
- [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md)
- [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Zero Trust Security Planning](zero-trust-security-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
