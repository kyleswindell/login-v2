# Offensive Security And Penetration Testing Planning

Status: Planning

## Purpose

Plan offensive security and penetration testing as a controlled security validation discipline for Login 2.0.

This document owns implementation sequencing and intent only. Final standards, runbooks, architecture contracts, CI contracts, schema contracts, authorized testing procedures, and release commands must be promoted into their owning docs before implementation.

## Direction

Offensive security is not a business module and should not be implemented as `Modules/PenTesting`, `Modules/OffensiveSecurity`, or `Modules/RedTeam`.

Offensive security should validate whether critical controls actually work by simulating attacker behavior under approved scope, safe test data, private evidence handling, remediation ownership, retesting, and release-gate impact.

Optional later runtime support:

```text
app/Core/Security/OffensiveTesting
```

Start docs/checks/evidence-first. Do not build exploit tooling, attack automation, or a dashboard before the findings workflow and Vulnerability Management integration exist.

## Boundary

Keep the distinction clear:

| Area | Purpose |
| --- | --- |
| Vulnerability Management | Find, prioritize, remediate, accept, and report vulnerabilities continuously. |
| Penetration Testing | Validate exploitability and business impact through controlled simulated attacks. |
| Red Teaming | Emulate realistic adversary behavior to test detection, response, and resilience. |
| DAST | Test a running app or API from the outside for exploitable behavior and misconfiguration. |
| Breach and Attack Simulation | Automated recurring simulation of attack paths and control failures. |

Offensive testing is a testing and evidence source that feeds Vulnerability Management. It does not replace finding lifecycle, severity, accepted risk, remediation ownership, or release blocking.

## Ownership Split

| Owner | Responsibility |
| --- | --- |
| `app/Core/Security` | Offensive testing standards, scope rules, route/security test readiness, DAST/staging guardrails, evidence rules, and allowed test boundaries. |
| `app/Core/Security/OffensiveTesting` | Optional later scope metadata, test evidence contracts, DAST/pen-test planning inputs, retest tracking support, and test readiness checks. |
| `app/Core/Security/VulnerabilityManagement` | Pen test findings, DAST findings, severity/risk scoring, remediation tracking, accepted risk, release blocking, and retest status where persisted. |
| `app/Core/Audit` | Test window approvals, test account activity where relevant, evidence access, remediation decisions, finding lifecycle evidence, and release exceptions. |
| `app/Core/Monitoring` | Test signals, detection validation, anomaly tuning, false-positive analysis, and purple-team feedback. |
| `app/Core/Notifications` | Critical finding alerts, remediation due alerts, retest required alerts, and blocked release alerts. |
| `app/Core/Security/Deployment` | Staging readiness, scan-safe configuration, rollback/restore readiness, and production testing change-control support. |
| `app/Core/DataProtection` | Safe test data rules, evidence classification, private evidence storage, and no real confidential data unless explicitly approved. |
| `Modules/*` | Business-flow abuse cases, object-level authorization tests, scope bypass tests, export/download abuse tests, and module-specific security tests. |

## Authorized Test Perspectives

### Black-Box App Test

Tester has:

- public app URL
- no source code
- no credentials, or only a normal test user

Purpose:

- public exposure testing
- login abuse
- forced browsing
- rate limiting
- generic web application weaknesses

Use after staging is deployed.

### Gray-Box App Test

Tester has:

- test credentials for multiple roles
- role/scope descriptions
- API docs if API exists
- test data map

Purpose:

- broken access control
- role/scope bypass
- IDOR
- customer/workspace isolation
- export/download authorization
- notification action revalidation

This is the most valuable perspective for a Laravel SaaS-style app.

### White-Box App Test

Tester has:

- source code access
- architecture docs
- route list
- permission registry
- data asset registry
- test credentials
- seeded database

Purpose:

- deeper design flaw review
- mass assignment paths
- missing policy checks
- unsafe services/actions
- secrets/logging issues
- audit/monitoring gaps

Use internally during build and before major releases.

## Authorized Environments

| Environment | Authorized Use |
| --- | --- |
| Local | Developer-only exploratory tests with safe dummy data and no production secrets. |
| Testing/CI | Automated security tests; no external offensive scans unless CI explicitly allows it. |
| Staging | DAST, gray-box, and controlled pen testing with production-like config, masked/fake data, and safe mail/notification handling. |
| Production | No destructive testing by default; only approved low-impact verification or emergency testing under incident/change approval. |

Core rule:

```text
No offensive testing against production unless explicitly approved, scoped, scheduled, logged, and supported by rollback/incident-response coverage.
```

## Rules Of Engagement

Penetration testing preparation belongs in `docs/10-runbooks/penetration-test-preparation.md`.

Required checklist:

- test owner
- test window
- environment
- approved source IPs, if applicable
- approved accounts
- approved targets/routes
- out-of-scope systems
- data safety rules
- rate limits and denial-of-service boundaries
- notification/mail handling
- rollback plan
- backup freshness
- incident contact
- logging enabled
- monitoring watch enabled

Out-of-scope by default:

- destructive database deletion
- denial-of-service or load exhaustion
- production data exfiltration
- production secret retrieval
- social engineering employees
- testing third-party systems without permission
- attacking client/customer infrastructure

## First App-Specific Test Scope

First offensive test coverage should prioritize:

1. Authentication and MFA
2. Authorization and object-level access
3. Admin route protection
4. Account/User lifecycle abuse
5. Access Control/RBAC escalation
6. Data export/download abuse
7. Notification action abuse
8. File upload/download abuse
9. Session and recent-auth bypass
10. Error/log/secret leakage

## Authentication And MFA

Test objectives:

- login brute force resistance
- MFA-required route enforcement
- MFA challenge bypass attempts
- recovery-code misuse
- password reset token reuse
- suspended/deactivated login blocking
- session fixation protection

Findings map to Auth, Identity, Audit, Monitoring, and Notifications.

## Authorization And Object-Level Access

Test objectives:

- force-browse admin routes
- modify URL IDs to access another user/customer/workspace record
- submit unauthorized role IDs
- bypass hidden UI controls
- use stale notification/action links after access changes
- test customer/workspace/module scope boundaries

Findings map to Access, Security, Audit, and business modules.

## Admin And Elevated Access

Test objectives:

- self-escalation attempt
- last Super Admin removal
- direct access exception abuse
- role/policy change without recent auth
- elevated session reuse after expiry
- separation-of-duties bypass

Findings map to Access, Auth, Identity, Audit, and Monitoring.

## Data Export And Download

Test objectives:

- view permission used as export permission
- signed URL reuse after expiry
- direct download from private storage
- changing export ID in URL
- confidential export without audit
- public storage leak

Findings map to DataProtection, Access, Security, Audit, and Monitoring.

## Notification Action Abuse

Test objectives:

- access notification action after role revoked
- use another user's notification ID
- dismiss/read notifications across users
- notification payload exposes sensitive data
- notification action URL bypasses policy

Findings map to Notifications, Access, DataProtection, and Audit.

## File Upload And Download

Test objectives:

- upload invalid MIME/extension
- upload executable or script-like content
- path traversal in filenames
- oversized upload
- private file direct access
- unauthorized file download

Findings map to Security, DataProtection, and Monitoring.

## Error, Log, And Secret Leakage

Test objectives:

- stack trace exposure
- `.env` exposure
- private storage exposure
- raw token/password/MFA code in logs
- audit row contains raw secret
- debug config in staging/production

Findings map to Security, Secrets, Audit, Monitoring, and Deployment.

## DAST Planning

DAST should run against:

- staging only by default
- production-like config
- fake or masked data
- safe test accounts
- mail sandbox or restricted mail
- adjusted rate limits only when explicitly approved

DAST output should feed:

- Vulnerability Management
- Offensive Testing metadata if persistence is later needed
- Audit
- Notifications for critical findings or blocked release

Do not run noisy scanners against production without a formal window.

Operational DAST procedure belongs in `docs/10-runbooks/dast-scan-staging.md`.

## Purple-Team Direction

Full red-team work is deferred, but purple-team-style review is useful for validating detection and response.

Use this flow later:

```text
Offensive test
  -> Detection signal
  -> Audit evidence
  -> Notification
  -> Runbook
  -> Control improvement
  -> Retest
```

Use purple-team reviews for:

- account compromise
- privileged access misuse
- data export abuse
- secret leakage
- service-account token compromise

Operational purple-team procedure belongs in `docs/10-runbooks/purple-team-review.md` later.

## Findings Model

Do not create a separate findings table if Vulnerability Management already owns findings.

Add source values to the Vulnerability Management model when implemented:

```text
penetration_test
red_team_exercise
dast_scan
manual_security_review
breach_attack_simulation
```

Finding metadata should support:

- test ID
- test type
- environment
- scope
- methodology
- evidence path
- reproduction summary
- business impact
- affected routes
- affected permissions
- affected data assets
- recommended fix
- retest required
- retest status

Store sensitive evidence privately.

## Finding Lifecycle

Use this lifecycle:

```text
Found
  -> Triaged
  -> Assigned
  -> Fix planned
  -> Fixed
  -> Ready for retest
  -> Retested passed
  -> Closed
```

If not fixed:

```text
Found
  -> Triaged
  -> Accepted risk
  -> Expiration set
  -> Review required
```

For critical/high findings:

- release blocked unless accepted by an authorized owner
- notification required
- audit required
- retest required before closure

## Evidence Handling

Pen test evidence can contain sensitive data.

Rules:

- store reports and evidence in private storage
- classify evidence as Restricted or Confidential
- do not attach raw secrets
- redact tokens and session IDs
- link evidence to the finding
- limit access to security/admin owners
- audit evidence downloads

DataProtection owns classification and safe data handling. Secrets owns secret redaction and rotation requirements. Audit owns evidence access logging.

## Release Gate Integration

Security release checklist targets:

- no open critical/high pen test findings unless accepted risk exists
- critical/high pen test findings require retest before closure
- DAST scan completed for staging before major release when the gate is enabled
- Auth, Access, and DataProtection offensive test cases pass
- business module security tests pass
- evidence stored privately
- accepted risks have owner, reason, expiration, and mitigation

Release gate finding keys:

- `offensive.open_critical_finding`
- `offensive.open_high_finding`
- `offensive.retest_required`
- `offensive.evidence_missing`
- `offensive.scope_not_approved`

## Monitoring, Notifications, And Audit

Monitoring signals:

- `DET-OFFSEC-001` open critical/high pen-test finding blocks release
- `DET-OFFSEC-002` retest required before closure
- `DET-OFFSEC-003` offensive evidence missing or stored unsafely
- `DET-OFFSEC-004` DAST scan failure on staging
- `DET-OFFSEC-005` offensive test scope is not approved

Notification type candidates:

- `security.offensive.release_blocked`
- `security.offensive.retest_required`
- `security.offensive.evidence_missing`
- `security.offensive.dast_failed`
- `security.offensive.scope_not_approved`

Audit event candidates:

- `offensive_test.approved`
- `offensive_test.started`
- `offensive_test.completed`
- `offensive_test.finding_recorded`
- `offensive_test.finding_accepted_risk`
- `offensive_test.retest_requested`
- `offensive_test.retest_passed`
- `offensive_test.retest_failed`
- `offensive_test.evidence_accessed`

## Optional Runtime Structure

Add only after docs/checks exist and persistence is needed:

```text
app/Core/Security/OffensiveTesting/
  Actions/
  Data/
  Enums/
  Models/
  Queries/
  Services/
  Support/
```

Potential classes:

- `RegisterSecurityTest`
- `RecordPenTestFinding`
- `AttachSecurityTestEvidence`
- `MarkFindingReadyForRetest`
- `RecordRetestResult`
- `SecurityTestScope`
- `SecurityTestEvidence`
- `OffensiveTestFinding`
- `RetestResult`
- `OffensiveTestingRegistry`
- `SecurityTestScopeService`
- `OffensiveTestingEvidenceService`
- `RetestTrackingService`

MVP should use Vulnerability Management findings with a source such as `penetration_test` or `dast_scan`.

## Business Module Template Requirements

When the business module template is updated, add lightweight offensive-security guidance:

```text
Modules/_Template/docs/offensive-security.md
Modules/_Template/docs/abuse-cases.md
Modules/_Template/tests/Feature/Security/OffensiveSecurityTest.php
```

Each business module should define:

- module abuse cases
- object-level access tests
- scope bypass tests
- export/download abuse tests
- bulk action abuse tests
- notification/action abuse tests
- file upload/download abuse tests, if applicable

Example for Orders:

- approve order without permission
- approve order outside customer scope
- change order status by tampering hidden field
- access another customer's order by ID
- export orders with view-only permission
- replay approval request

## Implementation Sequence

### 1. Docs Baseline

- Add this planning source.
- Promote accepted rules into offensive security standards and runbook targets.
- Add matrix rows for ownership, configuration, data, tests, and sequencing.

### 2. Matrix And Vulnerability Support

- Add finding source enum values to Vulnerability Management planning.
- Add offensive test/retest metadata expectations.
- Add private evidence storage rules.
- Add business module template requirements.

### 3. First Tests

First tests to plan:

- `AdminRouteForcedBrowsingTest`
- `ObjectLevelAuthorizationBypassTest`
- `ExportPermissionBypassTest`
- `NotificationActionAuthorizationTest`
- `FileDownloadAuthorizationTest`
- `MfaBypassRouteTest`
- `RecentAuthBypassTest`
- `LastSuperAdminGuardBypassTest`

### 4. DAST Staging

- define staging environment profile
- seed fake/masked data
- approve scan window
- store scan result in private storage
- import findings into Vulnerability Management
- track remediation/retest

## Standards And Runbooks To Add Later

Standards candidates:

- `docs/02-standards/security/offensive-security-and-penetration-testing.md`
- `docs/02-standards/security/security-testing.md`
- `docs/02-standards/security/environment-management.md`

Runbook candidates:

- `docs/10-runbooks/penetration-test-preparation.md`
- `docs/10-runbooks/penetration-test-remediation.md`
- `docs/10-runbooks/security-testing-and-penetration-review.md`
- `docs/10-runbooks/dast-scan-staging.md`
- `docs/10-runbooks/purple-team-review.md`

## Test Planning

Expected implementation coverage:

- test scope authorization
- staging-only default for DAST
- private evidence storage
- DAST report ingestion if persistence exists
- pen test finding source values
- retest status
- critical finding release block
- accepted risk owner/reason/expiration
- business module abuse-case coverage

## Transition Rules

- Do not create `Modules/PenTesting`, `Modules/OffensiveSecurity`, or `Modules/RedTeam`.
- Do not build exploit tooling inside Laravel.
- Do not add attack automation from the admin panel.
- Do not run production attack simulation without formal approval.
- Do not build an offensive testing dashboard before the findings workflow exists.
- Do not create a separate findings system outside Vulnerability Management.
- Do not run DAST against production by default.
- Do not store raw secrets or real customer data in evidence.

## Open Decisions

- Should offensive testing stay runbook/report-only until Vulnerability Management persistence exists?
- Which release gate should come first: DAST staging, Auth/Access/DataProtection offensive tests, or critical pen-test finding block?
- Which test perspective is required before the first production release: gray-box, white-box, or both?
- Where should pen test evidence live before a formal evidence store exists?
- Who can approve production low-impact verification?
- Which Vulnerability Management source values should be implemented first?
- Should retest status live entirely in Vulnerability Management, or in optional `OffensiveTesting` support tables later?

## Related

- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
- [Threat Modeling And Security Controls Planning](threat-modeling-security-controls-planning.md)
- [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md)
