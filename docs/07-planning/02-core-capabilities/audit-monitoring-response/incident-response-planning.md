# Incident Response Planning

Status: Planning

## Purpose

Plan the incident-response documentation and system support needed before security operations, account compromise handling, privileged-access incidents, data exposure response, MFA recovery abuse, and emergency patching mature.

Incident response is operations-led. It should not become a business module and should not start as an app-visible incident dashboard.

## Ownership Boundary

Runbooks own repeatable response procedures.

Core capabilities provide evidence and controls:

| Owner | Responsibility |
| --- | --- |
| `Core/Security` | route/security guardrails, release checks, secure-delivery controls |
| `Core/Security/Secrets` | secret rotation, leak indicators, reveal/copy/rotation evidence |
| `Core/Security/VulnerabilityManagement` | vulnerability findings, accepted risk, emergency patch triggers |
| `Core/Auth` | password/MFA/session controls and account recovery mechanics |
| `Core/Identity` | user lifecycle, suspension, deactivation, account status |
| `Core/Access` | role/policy/elevated-access review and revocation |
| `Core/DataProtection` | data sensitivity, exposure scope, export/retention/erasure constraints |
| `Core/Audit` | accountable event evidence, forensic timelines, evidence package metadata, chain-of-custody support |
| `Core/Monitoring` | exceptions, failed jobs, health checks, security anomaly signals, operational evidence sources |
| `Core/Monitoring/ThreatDetection` | detection signals and detection-use-case evidence |
| `Core/Monitoring/ThreatResponse` | response playbook mapping and case metadata later |
| `Core/Notifications` | required persistent security notices |

Incident response does not own Auth, Access, Audit, Monitoring, Secrets, or Vulnerability Management storage. It coordinates their evidence and operations.

Threat Detection and Response direction is tracked in [Threat Detection And Response Planning](threat-detection-response-planning.md) and [Detection Use Case Matrix](detection-use-case-matrix.md). TDR turns evidence into signals and playbook links; incident response runbooks define the human operating procedure.

Cloud and deployment hardening direction is tracked in [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md). Incident response should consume deployment rollback, configuration drift, public exposure, backup failure, and emergency deployment evidence when incidents involve production release or runtime posture.

Digital forensics readiness is tracked in [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md) and the [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md). Incident response runbooks should preserve evidence before containment actions delete files, revoke tokens, reset MFA, suspend users, or rotate secrets.

## Required Runbook Set

Parent runbook:

```text
docs/10-runbooks/incident-response.md
```

Task-specific runbooks to create before production maturity:

```text
docs/10-runbooks/account-compromise.md
docs/10-runbooks/privileged-access-incident.md
docs/10-runbooks/suspected-data-exposure.md
docs/10-runbooks/mfa-reset-and-recovery.md
docs/10-runbooks/emergency-security-patch.md
docs/10-runbooks/dependency-patching.md
docs/10-runbooks/secret-rotation.md
docs/10-runbooks/threat-detection-response.md
docs/10-runbooks/forensic-evidence-collection.md
docs/10-runbooks/incident-evidence-preservation.md
docs/10-runbooks/security-timeline-reconstruction.md
docs/10-runbooks/chain-of-custody.md
docs/10-runbooks/log-export-for-investigation.md
```

Runbook naming should stay consistent before creation. Existing planning notes sometimes use `secrets-rotation`; use `secret-rotation` unless a runbook naming decision chooses otherwise.

## Incident Types

Initial incident categories:

- account compromise
- privileged access misuse
- suspected data exposure
- MFA reset or recovery abuse
- secret exposure or rotation failure
- critical vulnerability or emergency patch
- suspicious export or mass access
- production security misconfiguration
- notification/audit/monitoring failure during a security event

## Minimum Response Capabilities

Account compromise response needs:

- suspend or restrict the affected user
- revoke sessions and remember tokens
- reset password
- reset or re-enroll MFA through Auth-owned flows
- review role/group/policy assignments
- review audit history
- notify security/admin owners
- document containment and recovery actions

Privileged-access incident response needs:

- identify Super Admin, elevated access, direct policy exception, or role escalation use
- revoke elevated sessions or risky assignments
- preserve audit evidence
- review last-admin guardrail state
- notify security/admin owners
- track follow-up access review

Suspected data exposure response needs:

- identify affected data class through DataProtection
- identify subject/resource scope through Audit and domain owners
- preserve evidence without exporting raw secrets or unnecessary PII
- stop further exposure
- notify required owners/users through Notifications where appropriate
- record remediation and follow-up controls

Secret exposure response needs:

- identify storage kind and owners through Secrets Management
- revoke or rotate the secret
- invalidate related sessions/tokens if applicable
- audit the rotation and access history
- add vulnerability findings when a leak or weak rotation process is confirmed

Evidence preservation flow:

```text
detection signal or incident report
  -> create investigation/evidence package when needed
  -> freeze relevant logs/time window
  -> add actor/session/resource timeline
  -> preserve audit, monitoring, error, export, file, and deployment metadata
  -> apply legal hold if needed
  -> continue containment actions
  -> record evidence access/export
  -> generate post-incident report
```

Containment actions should not erase evidence prematurely. Before deleting an export file, revoking a token, suspending a user, resetting MFA, rotating a secret, or rolling back a deployment, runbooks should identify the evidence to preserve and the redaction rules that apply.

## Standards To Promote

The following standards should be created or split from broader existing standards before implementation relies on them:

- secure coding
- security testing
- tenant and scope isolation
- file upload/download security
- audit logging
- monitoring and alerting
- secrets management
- session management

Standards own rules. This planning file only tracks why those standards are needed.

## Implementation Sequence

### 1. Runbook Inventory

- Create the parent incident-response runbook.
- Create the first task runbooks for account compromise, privileged access, suspected data exposure, MFA reset/recovery, emergency patching, dependency patching, and secret rotation.
- Keep procedures operational and avoid product behavior rules in runbooks.

### 2. Evidence Mapping

- Map each incident type to required Audit events, Monitoring signals, notification types, and operator actions.
- Identify required evidence fields that are safe to store.
- Confirm raw secrets and unnecessary sensitive values are excluded from evidence.
- Map each incident type to detection use cases when automated or queryable detection is expected.

### 3. Control Mapping

- Map each incident type to controls in Auth, Identity, Access, DataProtection, Secrets, Vulnerability Management, and Notifications.
- Identify missing controls that block a complete response.

### 4. Detection And Playbook Mapping

- Map `account-compromise` to failed login, failed MFA, recovery code, and inactive-login detections.
- Map `privileged-access-incident` to denied-access spike, self-escalation, last-admin guard, direct exception, and Super Admin assignment detections.
- Map `suspected-data-exposure` to restricted export, export spike, unusual download, and expired link detections.
- Map `secret-leak` to secret reveal and secret reveal spike detections.
- Map `failed-backup` and `critical-vulnerability` to Monitoring and Vulnerability Management detections.

### 5. App-Visible Support Review

- Defer incident dashboards until runbooks and evidence sources exist.
- Consider app-visible incident records only if operators need workflow state that cannot be managed through runbooks, audit queries, monitoring, and vulnerability findings.

## Test Planning

Future implementation tests should prove:

- compromised users can be suspended and sessions revoked
- privileged access changes are auditable
- sensitive incident evidence is redacted
- forensic timelines can reconstruct actor/session/request/target activity
- evidence access and export are audited
- evidence package hashes and manifests are stable
- legal hold prevents evidence pruning where configured
- MFA reset/recovery events are audited
- secret rotation events are audited without raw values
- critical vulnerability/emergency patch decisions can be audited
- required persistent security notifications cannot be disabled by personal preferences
- detection signals map to response runbooks
- high-risk response actions require permissions and recent-auth/MFA where configured

## Transition Rules

- Do not create `Modules/IncidentResponse`.
- Do not build an incident dashboard before runbooks, evidence sources, and owner responsibilities exist.
- Do not build forensic evidence package UI before request correlation, evidence fields, redaction, retention, private export, and access rules exist.
- Do not create security case workflows before detection signals and runbook mappings exist.
- Do not store raw secrets, full tokens, raw cookies, MFA codes, recovery codes, exploit payloads, or unnecessary PII in incident evidence.
- Do not treat monitoring errors as audit events by default.
- Do not treat audit history as an operational ticketing workflow.
- Do not let containment actions destroy evidence before required metadata is preserved.

## Open Decisions

- Which incident runbook must be created first?
- Which incident types require persistent notifications on day one?
- Which incident response actions require `auth.recent`, MFA, or elevated access?
- Should incident response ever receive app-visible records, or stay runbook/evidence-only until production operations prove the need?
- Which operator role or group owns security incident response before a formal team model exists?
- Which response playbooks must be mapped before first detection rules are implemented?

## Out Of Scope

- implementing incident-response code in this pass
- creating runbooks in this planning file
- creating incident database tables in this pass
- editing `/docs/08-active/`

## Related

- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md)
- [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md)
