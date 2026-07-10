# Cybersecurity Review Backlog Planning

Status: Planning

## Purpose

Track remaining cybersecurity topics that need deeper review before they become standards, runbooks, architecture contracts, feature behavior, schema, or implementation batches.

This document is a planning index. It does not create security rules, operational procedures, or app-visible features by itself.

## Current Coverage Baseline

The current core planning set already covers the Laravel app essentials:

- Auth and MFA
- Identity and user lifecycle
- Access Control
- Zero Trust planning
- Threat Modeling and Security Controls planning
- Threat Detection and Response planning
- Cloud and Deployment Hardening planning
- API, Webhook, and Service Account Security planning
- Software Supply Chain Security planning
- Offensive Security and Penetration Testing planning
- DLP and Exfiltration Detection planning
- Digital Forensics Readiness planning
- Privacy and Data Governance planning
- DataProtection
- Application Security
- Secrets Management
- Vulnerability Management
- Audit and Monitoring
- Notifications
- Incident Response
- Backup and Recovery
- Service Accounts and Machine Identity

Remaining review work should deepen the cybersecurity model around assumptions, controls, operations, evidence, and future integrations rather than creating more business modules.

## Review Priority

No top-priority cybersecurity topics are currently waiting for first-pass source planning. Remaining work is promotion into standards, runbooks, schema contracts, feature contracts, implementation plans, and deferred future topics.

## Deferred Topics

These topics are useful later but should not receive deep planning until product scope demands them:

- AI security
- managed SOC/MDR operations
- cyber insurance
- cyber range exercises
- endpoint security beyond admin workstation policy
- physical security

## Zero Trust Review Status

Zero Trust has been promoted into [Zero Trust Security Planning](zero-trust-security-planning.md).

Remaining promotion work:

- create `docs/02-standards/security/zero-trust.md`
- promote accepted route tier vocabulary into standards
- decide the first `auth.recent` and MFA step-up actions
- decide whether `RequestSecurityContext` is needed in the first implementation
- add tests for sensitive route step-up, denied access audit, export/secret recent-auth, notification action revalidation, and service actor scope

## Threat Modeling Review Status

Threat modeling and security controls have been promoted into [Threat Modeling And Security Controls Planning](threat-modeling-security-controls-planning.md) and the initial [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md).

Remaining promotion work:

- create `docs/02-standards/security/threat-modeling-and-controls.md`
- create `docs/02-standards/security/security-controls.md`
- create `docs/10-runbooks/security-control-assessment.md`
- decide the first control catalog implementation shape: Markdown only, PHP value objects, or both
- require high-risk Auth, Identity, Access, DataProtection, Security, Audit, Monitoring, Notifications, Secrets, and Vulnerability Management work to map threats to controls, tests, audit, monitoring, notifications, and runbooks

Threat modeling should create a traceable matrix:

```text
Threat
  -> Control
  -> Detection
  -> Audit event
  -> Notification
  -> Incident runbook
  -> Test coverage
```

Initial threat categories:

- authentication bypass
- MFA bypass or reset abuse
- role escalation
- object-level authorization bypass
- tenant/customer scope bypass
- sensitive export bypass
- public file exposure
- secret leakage
- service account abuse
- malicious or vulnerable dependency
- suspicious data access volume

This should feed Application Security standards, Security Testing standards, Monitoring, Audit, Incident Response, and Vulnerability Management. New detailed planning should happen in the promoted threat-modeling documents rather than expanding this backlog section.

## Threat Detection And Response Review Status

Threat detection and response has been promoted into [Threat Detection And Response Planning](threat-detection-response-planning.md) and the initial [Detection Use Case Matrix](detection-use-case-matrix.md).

Remaining promotion work:

- create `docs/02-standards/security/threat-detection-and-response.md`
- create `docs/10-runbooks/threat-detection-response.md`
- decide whether first detection implementation derives signals from Audit/Monitoring queries or persists `detection_signals`
- decide first security owner/audience routing for critical and high detection notifications
- keep SIEM/SOAR/XDR-style integrations deferred until internal event shape and signal rules stabilize

Threat detection and response should clarify the boundary:

```text
Core/Audit records accountable evidence.
Core/Monitoring detects suspicious or broken behavior.
Core/Notifications alerts required owners.
Runbooks define response.
Vulnerability Management records findings and accepted risk where applicable.
```

Future external integrations to leave room for:

- SIEM event forwarding
- SOAR automation
- identity threat detection and response
- user/entity behavior analytics
- data loss prevention tooling
- intrusion detection or DDoS provider signals

Do not build these integrations until Monitoring and Audit event shape are stable. New detailed planning should happen in the promoted TDR documents rather than expanding this backlog section.

## Cloud And Deployment Security Review Status

Cloud, infrastructure, and deployment security has been promoted into [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md).

Remaining promotion work:

- create `docs/02-standards/security/deployment-security.md`
- create `docs/02-standards/security/infrastructure-hardening.md`
- create `docs/02-standards/security/environment-management.md`
- create `docs/02-standards/security/configuration-management.md`
- create `docs/10-runbooks/production-deployment-security.md`
- create `docs/10-runbooks/server-hardening.md`
- create `docs/10-runbooks/deployment-rollback.md`
- create `docs/10-runbooks/configuration-drift-review.md`
- decide whether first deployment readiness implementation stays runbook/checklist-only or adds app-level checks

Review should cover:

- server hardening
- TLS/HTTPS and reverse proxy configuration
- trusted proxy behavior
- database exposure
- storage permissions
- queue workers
- cron/scheduler security
- deployment secrets
- backup storage
- staging versus production isolation
- admin workstation expectations

Likely future docs:

```text
docs/02-standards/security/deployment-security.md
docs/10-runbooks/server-hardening.md
docs/10-runbooks/production-deployment-security.md
```

New detailed planning should happen in the promoted deployment-hardening document rather than expanding this backlog section.

## API, Webhook, And Service-Account Review Status

API, webhook, and service-account security has been promoted into [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md).

Remaining promotion work:

- create `docs/02-standards/security/api-webhook-service-account-security.md`
- create `docs/10-runbooks/api-token-compromise.md`
- create `docs/10-runbooks/webhook-secret-rotation.md`
- decide dedicated `service_accounts` table versus `users.type = service`
- decide first service-account-only API token scope
- keep user-owned personal API keys, Super Admin API tokens, OAuth provider work, and developer portal work deferred

This review should build on [Service Accounts And Machine Identity Planning](service-accounts-machine-identity-planning.md).

Review should cover:

- API token issuance and storage
- webhook signing and replay protection
- service actor identity
- least-privilege scopes
- token rotation and expiry
- integration-specific credentials
- failed authentication monitoring
- service-account audit evidence

Likely future standards:

```text
docs/02-standards/security/api-webhook-service-account-security.md
docs/02-standards/security/api-security.md
docs/02-standards/security/webhook-security.md
docs/02-standards/security/service-accounts.md
```

New detailed planning should happen in the promoted API/webhook/service-account document rather than expanding this backlog section.

## Software Supply Chain Security Review Status

Software supply chain security has been promoted into [Software Supply Chain Security Planning](software-supply-chain-security-planning.md).

Remaining promotion work:

- create `docs/02-standards/security/software-supply-chain-security.md`
- create `docs/02-standards/security/dependency-management.md`
- create `docs/02-standards/security/sbom-and-artifact-inventory.md`
- create `docs/02-standards/security/build-artifact-integrity.md`
- create `docs/02-standards/security/dependency-license-policy.md`
- create `docs/10-runbooks/supply-chain-incident-response.md`
- create `docs/10-runbooks/compromised-package-response.md`
- create `docs/10-runbooks/sbom-generation.md`
- create `docs/10-runbooks/build-artifact-rollback.md`
- decide the first supply-chain release gate: Composer audit, npm audit, lockfile drift, SBOM generation, detect-secrets, build artifact evidence, or a combined release evidence bundle

This review should broaden vulnerability management beyond package CVEs into dependency inventory, lockfiles, provenance, Docker/base images, CI/CD, build artifacts, SBOMs, third-party scripts, secret scanning, and release evidence.

New detailed planning should happen in the promoted supply-chain document rather than expanding this backlog section.

## Offensive Security Review Status

Offensive security and penetration testing has been promoted into [Offensive Security And Penetration Testing Planning](offensive-security-penetration-testing-planning.md).

Remaining promotion work:

- create `docs/02-standards/security/offensive-security-and-penetration-testing.md`
- create `docs/10-runbooks/penetration-test-preparation.md`
- create `docs/10-runbooks/penetration-test-remediation.md`
- create `docs/10-runbooks/security-testing-and-penetration-review.md`
- create `docs/10-runbooks/dast-scan-staging.md`
- decide the first offensive security baseline: standards/runbooks only, Auth/Access/DataProtection offensive tests, DAST staging, or Vulnerability Management finding-source support
- keep production offensive testing denied by default unless explicitly approved, scoped, scheduled, logged, and supported by rollback/incident-response coverage

New detailed planning should happen in the promoted offensive security document rather than expanding this backlog section.

## DLP And Exfiltration Detection Review Status

DLP and exfiltration detection has been promoted into [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md).

Remaining promotion work:

- create `docs/02-standards/security/data-loss-prevention.md`
- create `docs/10-runbooks/suspected-data-exfiltration.md`
- decide the first DLP baseline: export/download enforcement, data movement vocabulary, audit events, monitoring signals, or a combined baseline
- keep DLP policy under DataProtection and exfiltration signals under Monitoring

New detailed planning should happen in the promoted DLP document rather than expanding this backlog section.

## Digital Forensics Readiness Review Status

Digital forensics readiness has been promoted into [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md) and the [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md).

Remaining promotion work:

- create `docs/02-standards/security/digital-forensics-readiness.md`
- create `docs/02-standards/security/evidence-handling.md`
- create `docs/02-standards/security/audit-evidence-model.md`
- create `docs/10-runbooks/forensic-evidence-collection.md`
- create `docs/10-runbooks/incident-evidence-preservation.md`
- create `docs/10-runbooks/security-timeline-reconstruction.md`
- create `docs/10-runbooks/chain-of-custody.md`
- create `docs/10-runbooks/log-export-for-investigation.md`
- decide the first forensics baseline: request correlation only, timeline query support, evidence package DTOs, private evidence export, or a combined baseline
- keep forensic evidence ownership under Audit, with Monitoring, Security, DataProtection, Access, Notifications, and Incident Response support

New detailed planning should happen in the promoted forensics documents rather than expanding this backlog section.

## Privacy And Data Governance Review Status

Privacy and data governance have been promoted into [Privacy And Data Governance Planning](privacy-data-governance-planning.md) and the [Data Domain Governance Matrix](data-domain-governance-matrix.md).

Remaining promotion work:

- create `docs/02-standards/security/privacy-and-data-governance.md`
- create `docs/02-standards/security/data-stewardship.md` if the owner/steward model enters implementation
- create `docs/02-standards/security/data-quality-and-integrity.md` if data quality issue workflows enter implementation
- create `docs/10-runbooks/privacy-request-handling.md`
- create `docs/10-runbooks/data-correction-request.md`
- create `docs/10-runbooks/data-erasure-request.md`
- create `docs/10-runbooks/data-retention-review.md`
- decide whether `app/Core/DataGovernance` starts as runtime manifest definitions or DB-backed registry projection
- decide whether the first privacy request MVP supports app users only or app users plus customer contacts
- keep DataGovernance responsible for policy/ownership/purpose/rights/quality, with DataProtection responsible for enforcement

New detailed planning should happen in the promoted privacy/governance documents rather than expanding this backlog section.

## Implementation Rules

- Do not create new business modules for these topics.
- Do not create dashboards before controls, signals, evidence, runbooks, and tests exist.
- Do not add AI/SOC/MDR/forensics tooling until Audit, Monitoring, and Incident Response have stable contracts.
- Do not make standards or runbooks from this backlog without promoting the content into the correct branch.
- Do not use this backlog as final architecture, behavior, schema, standards, or operational truth.

## Related

- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Threat Modeling And Security Controls Planning](threat-modeling-security-controls-planning.md)
- [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md)
- [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md)
- [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md)
- [Privacy And Data Governance Planning](privacy-data-governance-planning.md)
- [Data Domain Governance Matrix](data-domain-governance-matrix.md)
- [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md)
- [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md)
- [Zero Trust Security Planning](zero-trust-security-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Incident Response Planning](incident-response-planning.md)
- [Backup And Recovery Planning](backup-recovery-planning.md)
- [Service Accounts And Machine Identity Planning](service-accounts-machine-identity-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
