# AGENTS.md

## Folder Purpose

This folder owns canonical security, privacy, data-protection, secure-delivery, and security-assurance standards.

It does not own implementation sequencing, incident transcripts, executable procedures, architecture boundaries, database schemas, or security-tool output.

## Required Reading

Before editing this folder:

1. read root `AGENTS.md`
2. read `docs/AGENTS.md` if present
3. read `docs/02-standards/AGENTS.md` if present
4. read `index.md`
5. read only the standard that owns the requested concern
6. read the linked planning source when the standard is being promoted or materially changed

## Routing

| Concern | Canonical Owner |
| --- | --- |
| Security-wide principles and responsibility boundaries | `Security Standards.md` |
| ASVS applicability and evidence | `OWASP ASVS Level 2 Baseline.md` |
| Release assurance and secure delivery | `Application Security Verification And Secure Delivery Standards.md` |
| Authentication, identity proof, MFA, recovery, and linking | `Identity And Account Security Standards.md` |
| Authorization, scopes, elevated access, and separation of duties | `Access Control And Authorization Standards.md` |
| HTTPS, sessions, cookies, proxies, headers, and CSP | `Transport Session And Browser Security Standards.md` |
| App-instance, tenant, workspace, customer, and object isolation | `Tenant And Scope Isolation Standards.md` |
| Secure Laravel request and write patterns | `Secure Coding And Request Handling Standards.md` |
| Automated and manual security verification | `Security Testing Standards.md` |
| Uploads, downloads, private files, and generated exports | `File Upload Download And Export Security Standards.md` |
| Continuous validation and least privilege | `Zero Trust Security Standards.md` |
| Threat models, control IDs, traceability, and evidence | `Threat Modeling And Security Controls Standards.md` |
| Secrets, credentials, rotation, and redaction | `Secrets Management Standards.md` |
| Data classification, movement, export, retention, and DLP | `Data Protection And Data Loss Prevention Standards.md` |
| Privacy, purpose, stewardship, rights, and quality | `Privacy And Data Governance Standards.md` |
| APIs, webhooks, tokens, and service actors | `API Webhook And Service Account Security Standards.md` |
| Dependencies, lockfiles, SBOMs, and artifacts | `Software Supply Chain Security Standards.md` |
| Findings, accepted risk, remediation, and release gates | `Vulnerability Management Standards.md` |
| DAST, penetration tests, rules of engagement, and retest | `Offensive Security And Penetration Testing Standards.md` |
| Environments, infrastructure, configuration, database exposure, and deployment | `Deployment Environment And Infrastructure Security Standards.md` |
| Evidence readiness, correlation, private evidence, and chain of custody | `Digital Forensics Readiness And Evidence Handling Standards.md` |
| Detection signals, severity, notifications, playbooks, and containment boundaries | `Threat Detection And Response Standards.md` |
| Incident governance and required runbook coverage | `Security Incident Response Standards.md` |

Audit-event storage rules belong under `docs/02-standards/logging/`.

Operator-executable response procedures belong under `docs/10-runbooks/`.

## Authoring Rules

Security standards must:

- state enforceable requirements
- identify the owning capability
- distinguish current requirements from planned implementation
- identify verification and evidence expectations
- avoid prescribing unresolved physical namespaces or schemas
- avoid copying complete planning documents
- link to affected standards and planning sources
- exclude secrets, exploit payloads, production credentials, and restricted evidence

Do not mark a draft standard active until its rules and owner boundaries are accepted.

## Security Review

Require specialist review when a change affects:

- authentication or MFA
- authorization or scope isolation
- secrets or machine credentials
- sensitive exports or files
- privacy rights or data retention
- security logging or evidence
- deployment or infrastructure hardening
- vulnerability or release-gate policy
- offensive testing
- incident response

## Stop Conditions

Stop and ask when:

- planning sources conflict
- the standard would choose an unresolved schema or physical namespace
- the change weakens an existing control
- a rule cannot be verified
- the document would become an operational runbook
- the document would include restricted evidence
- an exception or accepted-risk authority is unclear
- multiple standards would own the same rule

## Related

- [Security Standards Index](index.md)
- [Documentation Standards Index](../documentation/index.md)
- [Logging Standards Index](../logging/index.md)
- [Runbook Index](../../10-runbooks/index.md)
