# Threat Modeling And Security Controls Planning

Status: Planning

## Purpose

Plan threat modeling as the bridge between architecture decisions and enforceable security controls.

This planning document does not create final security standards, runbooks, schema, code, dashboards, or active batch state. It defines the implementation direction needed before Core Security, Auth, Access, DataProtection, Audit, Monitoring, Notifications, Vulnerability Management, and business modules can claim mature security coverage.

## Direction

Threat modeling should become a required planning input for core capabilities and business modules. It should not become a business module, a dashboard-first feature, or a standalone `Modules/ThreatModeling` package.

The first implementation direction is:

```text
capability or module scope
  -> data flows and trust boundaries
  -> threat and abuse cases
  -> security controls
  -> tests
  -> audit events
  -> monitoring signals
  -> notifications
  -> runbooks
  -> release evidence
```

## Ownership

| Owner | Responsibility |
| --- | --- |
| `app/Core/Security` | Security control catalog, threat-control traceability helpers, route tiers, sensitive route definitions, release checks, safe redirects, headers, redaction integration, upload/download guardrails. |
| `app/Core/Auth` | Authentication, MFA, recovery, recent-auth, session and credential proof controls. |
| `app/Core/Identity` | User lifecycle, account state, suspension/deactivation, profile/account subject semantics. |
| `app/Core/Access` | Roles, groups, permissions/actions, policies, effective access, elevated access, access reviews, object-level access controls. |
| `app/Core/DataGovernance` | Data domains, owners/stewards, processing purposes, privacy-right behavior, retention policy intent, consent metadata, and data quality expectations. |
| `app/Core/DataProtection` | Data classification, sensitive fields, exports, downloads, retention, erasure, data movement controls. |
| `app/Core/DataProtection/Dlp` | Data movement vocabulary, DLP policy decisions, export risk evaluation, redaction/downgrade decisions, and DLP violation metadata. |
| `app/Core/Audit` | Accountable event evidence, actor/subject/target/change-set shape, redaction-safe audit records. |
| `app/Core/Audit/Forensics` | Forensic timeline reconstruction, evidence package metadata, evidence hashing, chain-of-custody metadata, and evidence export support. |
| `app/Core/Monitoring` | Exceptions, failed jobs, health checks, anomaly signals, detection findings. |
| `app/Core/Monitoring/ThreatDetection/DataExfiltration` | Exfiltration-style detection signals for sensitive exports, downloads, views, responses, sessions, and cross-scope access. |
| `app/Core/Notifications` | Required user/operator notification delivery for inbox-worthy security and workflow events. |
| `app/Core/Security/OffensiveTesting` | Authorized testing scope, staging/DAST readiness, private evidence rules, retest support, and attacker-perspective validation planning. |
| `app/Core/Security/SupplyChain` | Dependency inventory, SBOM metadata, lockfile drift, build artifact identity, supply-chain release evidence, and supply-chain release gates. |
| `app/Core/Security/VulnerabilityManagement` | Vulnerability findings, accepted risk, dependency and scanner inputs, release-blocking policy. |
| Runbooks | Operational response, containment, recovery, evidence handling, and manual assessment procedures. |
| Business modules | Domain-specific assets, entry points, abuse cases, object scopes, and business-impact semantics. |

Core Security coordinates the control catalog and traceability model, but it does not own every domain threat or every enforcing service.

## Planned Source Documents

Content accepted from this planning pass should be promoted into the correct owner branches before implementation:

| Needed Document | Branch Responsibility | Purpose |
| --- | --- | --- |
| `docs/02-standards/security/threat-modeling-and-controls.md` | Standards | Required threat model process, control traceability rules, and release expectations. |
| `docs/02-standards/security/security-controls.md` | Standards | Canonical control ID format, control categories, ownership, and evidence requirements. |
| [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md) | Planning | Working planning matrix that maps initial threats to controls, tests, audit, monitoring, notifications, and runbooks. |
| [Detection Use Case Matrix](detection-use-case-matrix.md) | Planning | Working planning matrix that maps high-risk threats to detection use cases, signals, notifications, playbooks, and tests. |
| `docs/10-runbooks/security-control-assessment.md` | Runbooks | Manual/automated control assessment procedure once control evidence exists. |

## Threat Modeling Process

Each core capability and business module should eventually follow this process before implementation is considered ready:

1. Define system scope.
2. Identify assets and sensitive data.
3. Draw data flows and trust boundaries.
4. Identify actors, entry points, and abuse cases.
5. Select preventive, detective, and corrective controls.
6. Map controls to tests.
7. Map high-risk controls to audit events, monitoring signals, notifications, and runbooks.
8. Track unresolved risks as open decisions or accepted-risk candidates.

## Threat Categories

Initial categories:

| Category | Scope |
| --- | --- |
| `AUTH` | Login, MFA, password, recovery, sessions, recent-auth, passkeys/SSO later. |
| `IDENTITY` | User lifecycle, suspension, deactivation, invitations, account ownership. |
| `ACCESS` | Roles, groups, permissions, policies, object scope, elevated access, reviews. |
| `DATA` | Classification, sensitive fields, exports, downloads, retention, erasure, DLP signals. |
| `SECRETS` | Secret storage, reveal, copy, rotation, expiry, leak prevention, redaction. |
| `APPLICATION` | Routes, requests, validation, redirects, CSRF, XSS, uploads, headers. |
| `MONITORING` | Detection, alerting, failed jobs, anomaly signals, security event summaries. |
| `OPERATIONS` | Deployment, backup, recovery, incident response, evidence handling. |

## Security Control Catalog

Security controls should use stable IDs:

```text
CTRL-{AREA}-{NUMBER}
```

Initial control candidates:

| Control | Summary |
| --- | --- |
| `CTRL-AUTH-001` | MFA is required for admin access where configured. |
| `CTRL-AUTH-002` | Recent authentication is required for sensitive account and security actions. |
| `CTRL-AUTH-003` | Sessions are revoked or blocked on suspension/deactivation. |
| `CTRL-ACCESS-001` | Every protected route requires policy/gate authorization. |
| `CTRL-ACCESS-002` | Object-level access includes target/scope checks. |
| `CTRL-ACCESS-003` | Last Super Admin removal is blocked. |
| `CTRL-ACCESS-004` | Self-escalation is blocked. |
| `CTRL-ACCESS-005` | Direct access exceptions require reason and audit evidence. |
| `CTRL-DATA-001` | View and export permissions are separate. |
| `CTRL-DATA-002` | Restricted exports use private storage and signed expiring links. |
| `CTRL-DATA-003` | Sensitive fields are redacted in audit and monitoring output. |
| `CTRL-GOV-001` | Governed data assets declare owner, steward, purpose, classification, retention intent, and privacy-right behavior before sensitive workflows are built on them. |
| `CTRL-GOV-002` | Privacy request and data quality workflows route to the owning domain action and record audit evidence. |
| `CTRL-DLP-001` | Confidential and restricted data movement is evaluated by DLP policy before export, download, API, webhook, or notification delivery. |
| `CTRL-DLP-002` | DLP movement violations and exfiltration thresholds create audit evidence and Monitoring signal targets. |
| `CTRL-SEC-001` | State-changing GET routes are not allowed. |
| `CTRL-SEC-002` | FormRequest validation is required for write actions. |
| `CTRL-SEC-003` | Safe redirect validation is required. |
| `CTRL-SEC-004` | Security headers are applied to web responses. |
| `CTRL-AUDIT-001` | Sensitive actions write audit events after commit. |
| `CTRL-AUDIT-002` | Audit events do not contain raw secrets. |
| `CTRL-AUDIT-003` | Service actors are supported in audit evidence. |
| `CTRL-AUDIT-004` | Security-sensitive evidence includes request/session/correlation fields needed for forensic reconstruction. |
| `CTRL-FORENSICS-001` | Formal evidence packages record hashes, manifests, access/export events, and chain-of-custody metadata. |
| `CTRL-MON-001` | Failed jobs are reportable. |
| `CTRL-MON-002` | Repeated access denials create anomaly signals. |
| `CTRL-MON-003` | Export spikes create anomaly signals. |
| `CTRL-VULN-001` | Critical/high unaccepted findings block release. |
| `CTRL-VULN-002` | Accepted risk requires owner, reason, and expiration. |

## Traceability Matrix

The planning matrix should track:

| Column | Meaning |
| --- | --- |
| Threat ID | Stable planning ID, such as `THR-AUTH-001`. |
| Threat | Plain-language abuse case or failure mode. |
| Affected capability | Owning core capability or business module. |
| Affected data | Data assets or sensitive records involved. |
| Entry point | Route, command, job, webhook, UI, import, or integration entry point. |
| Trust boundary | Boundary crossed by the request or data flow. |
| Risk level | Planning risk label. |
| Preventive controls | Controls that block or reduce the threat. |
| Detective controls | Controls that detect the threat or failure. |
| Corrective controls | Controls that contain, recover, or remediate. |
| Enforced by | Middleware, policy, service, job, release gate, or runbook owner. |
| Tests | Required test categories. |
| Audit events | Accountable event evidence. |
| Monitoring signals | Operational or security detection signals. |
| Notifications | Required user/operator notifications. |
| Runbook | Response procedure when the threat materializes. |
| Status | Planned, implemented, tested, failing, accepted-risk, deferred, or not-applicable. |
| Owner | Core capability, Module, UI, Laravel integration, or operations owner; Surface, Delivery Adapter, and Registry remain technical responsibilities beneath that owner. |

The active planning artifact is [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md).

## Required Threat Model Files

Planned feature-level threat model files:

```text
docs/04-features/auth/threat-model.md
docs/04-features/users/threat-model.md
docs/04-features/security/threat-model.md
docs/04-features/access-control/threat-model.md
docs/04-features/data-protection/threat-model.md
docs/04-features/logging/threat-model.md
docs/04-features/notifications/threat-model.md
```

The business module template should eventually include:

```text
Modules/_Template/docs/security.md
Modules/_Template/docs/threat-model.md
Modules/_Template/docs/controls.md
```

## Threat Model Template

Each threat model should cover:

```text
Scope
Assets
Actors
Entry Points
Trust Boundaries
Data Flows
Threats
Controls
Detection
Tests
Open Decisions
```

## App Folder Direction

Optional future support code belongs under Core Security, not under a business module:

```text
app/Core/Security/Controls/
  Data/
  Enums/
  Services/
  Support/

app/Core/Security/ThreatModeling/
  Data/
  Enums/
  Services/
  Support/
```

The first code should be small: value objects, control catalog readers, matrix/evidence helpers, and release-check support. Do not build a control dashboard before real enforcement and evidence exist.

## Optional Persistence

Persistence is deferred until there is a real UI, evidence lifecycle, or stale-control need:

| Optional Table | Purpose |
| --- | --- |
| `security_control_entries` | Synced control catalog projection. |
| `security_control_evidence` | Evidence snapshots from checks, tests, audits, and runbooks. |
| `threat_model_entries` | Structured threat metadata if Markdown planning becomes insufficient. |
| `threat_control_mappings` | Durable mapping from threats to controls and evidence. |
| `threat_detection_use_cases` | Detection and response use cases for Monitoring/SIEM integration. |

DB rows must not introduce executable behavior. They may project code/docs-owned definitions and evidence.

## Release Gate Direction

Future security release checks should include:

- every protected route has a route tier
- every write route has FormRequest validation
- every protected controller action has policy/gate coverage
- every high-risk action maps to an audit event
- every high-risk evidence source maps to request/session/correlation fields or an explicit not-applicable reason
- every high-risk threat maps to at least one test
- every high-risk threat maps to at least one detection use case or an explicit not-applicable reason
- every data export maps to a DataProtection export control
- every confidential or restricted data movement maps to a DLP control, audit event, and monitoring signal target
- every security-sensitive notification action revalidates Access
- every business module has a threat model
- every critical control has an offensive test target or an explicit not-applicable reason
- every supply-chain release has dependency inventory, lockfile review, SBOM/artifact evidence, and no unaccepted critical supply-chain finding
- every critical/high unaccepted vulnerability blocks release
- every accepted risk has owner, reason, and expiration

Possible future commands:

```text
php artisan security:controls
php artisan security:threats
php artisan security:routes
php artisan security:audit-events
```

## Security Control Assessment

A future `/admin/security/controls` surface may show control posture after enforcement exists.

Potential columns:

| Column | Meaning |
| --- | --- |
| Control | Control ID and label. |
| Owner | Core capability or business owner. |
| Status | Planned, implemented, tested, failing, accepted-risk, deferred, or not-applicable. |
| Evidence | Tests, audit samples, monitoring checks, or runbook evidence. |
| Last checked | Last evidence refresh time. |
| Source | Standard, planning matrix, code registry, test, or runbook. |
| Related threats | Threat IDs covered by the control. |
| Runbook | Response or assessment procedure. |

This surface is deferred. It should display evidence from real enforcement/check systems, not become the system itself.

## Implementation Sequence

Threat-control planning should be inserted before the Security foundation implementation:

1. Confirm vocabulary and owner decisions.
2. Promote architecture/docs boundaries.
3. Establish the threat-modeling and security control baseline.
4. Build Audit foundation.
5. Build Security foundation.
6. Promote Zero Trust standard and trust-decision planning.
7. Build Secrets Management baseline.
8. Build Vulnerability Management process baseline.
9. Continue Identity, Auth, Access, DataGovernance, DataProtection, Notifications, Settings/Preferences, Monitoring, Platform, and business-module work.

## Transition Rules

- Do not create `Modules/ThreatModeling`.
- Do not create a dashboard before controls, signals, evidence, runbooks, and tests exist.
- Do not make Core Security own Auth, Access, DataGovernance, DataProtection, Audit, Monitoring, Notifications, Vulnerability Management, or domain-specific business semantics.
- Do not treat a threat model as implementation proof unless tests and evidence are mapped.
- Do not treat a threat as operationally covered unless detection, notification/escalation, runbook, and test coverage are mapped or explicitly marked not applicable.
- Do not treat an audit log as a notification or a monitoring signal.
- Do not treat an activity feed as a security notification.
- Do not store threat-control lifecycle state in `/docs/08-active/`.

## Open Decisions

- What is the first promoted control catalog: only route/write/audit controls, or the broader Auth/Access/Data/Security/Audit/Monitoring/Vulnerability set?
- Should control catalog definitions begin as Markdown only, PHP value objects, or both?
- Should the first release gate be route tier coverage, FormRequest coverage, policy coverage, audit-event coverage, or dependency audit?
- Should control assessment remain runbook-only until production, or should it gain internal UI after first evidence checks exist?
- Which threat model files are mandatory before the next Auth, Users, Access, DataGovernance, or DataProtection implementation batch?

## Related

- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Zero Trust Security Planning](zero-trust-security-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Privacy And Data Governance Planning](privacy-data-governance-planning.md)
- [Data Domain Governance Matrix](data-domain-governance-matrix.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md)
- [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
- [Incident Response Planning](incident-response-planning.md)
