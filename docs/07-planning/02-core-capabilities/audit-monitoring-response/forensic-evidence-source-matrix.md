# Forensic Evidence Source Matrix

Status: Planning matrix

## Purpose

Track planned evidence sources that support digital forensics readiness, incident evidence preservation, timeline reconstruction, chain-of-custody planning, and evidence package exports.

This matrix is a planning artifact. It does not replace audit contracts, monitoring contracts, schema contracts, runbooks, implementation tickets, or legal procedures.

## Matrix Columns

| Column | Meaning |
| --- | --- |
| Source ID | Stable planning key for the evidence source. |
| Source | System or capability that produces the evidence. |
| Evidence Examples | Events, records, files, logs, or metadata that may be preserved. |
| Owner | Core capability, platform surface, business module, or operations owner. |
| Required Fields | Fields needed for reconstruction and correlation. |
| Redaction / Handling | Sensitive-value handling expectation. |
| Retention / Export | Planning expectation for retention or investigation export. |
| First Tests | Initial implementation coverage target. |
| Status | Planned, implemented, tested, failing, accepted-risk, deferred, or not-applicable. |

## App Evidence Sources

| Source ID | Source | Evidence Examples | Owner | Required Fields | Redaction / Handling | Retention / Export | First Tests | Status |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| `FE-AUTH-001` | Auth events | login success/failure, MFA pass/fail, password reset, recovery code use, session creation/revocation, trusted device changes | Auth, Audit | actor, subject user, session, IP, user agent, route, request/correlation ID, result, occurred_at_utc | never store passwords, MFA codes, recovery codes, raw reset tokens, raw cookies, or remember tokens | queryable by actor/session/time; export redacted JSONL | auth event timeline includes request/session/IP | Planned |
| `FE-IDENTITY-001` | Identity/user lifecycle | user created/invited, profile changed, status changed, suspended/deactivated/reactivated, contact emails changed | Identity, Audit | actor, subject user, changed fields, previous/new safe values, request/correlation ID, result | redact unnecessary PII; preserve enough status/profile delta for reconstruction | queryable by subject user and actor | user lifecycle evidence has safe change set | Planned |
| `FE-ACCESS-001` | Access changes and denials | role/group/policy changes, access denied, effective access source, elevated access activation/revocation, direct exceptions, last-admin guard | Access, Audit, Monitoring | actor, subject, target, permission/policy/role, scope, reason, route, request/correlation ID, result | do not store raw submitted secrets; preserve permission and policy IDs | queryable by actor, subject, policy, role, scope | privileged-access timeline reconstructs change path | Planned |
| `FE-DATA-001` | Data protection and DLP | export requested/approved/created/downloaded/revoked, sensitive fields accessed/exported, DLP violations, erasure/retention actions | DataProtection, Audit, Monitoring | actor, data asset, classification, movement type, record count, export/file ID, reason, approval, request/correlation ID | redact payload values; include counts, fields, classifications, and file metadata | private export metadata; evidence package may include hashes and manifests | data export evidence excludes raw restricted data unless scoped | Planned |
| `FE-SECRETS-001` | Secrets and credentials | secret revealed/copied/rotated/revoked, API token created/revoked, webhook secret rotated, secret leak findings | Security/Secrets, Auth, Audit, Monitoring | actor, secret reference, token prefix/fingerprint, owner, action, reason, request/correlation ID | never store raw secret, token, webhook secret, private key, or credential value | evidence export uses references/fingerprints only | no raw secret in evidence package | Planned |
| `FE-MON-001` | Monitoring and detection | central error logs, failed jobs, health failures, detection signals, anomaly findings | Monitoring | source, severity, fingerprint, job/check key, actor if available, request/correlation ID, environment, occurred_at_utc | redact exception context and request payloads | queryable by request ID, correlation ID, time, severity | monitoring event joins timeline by request/correlation ID | Planned |
| `FE-NOTIF-001` | Notifications | security notification created/read/dismissed, high-risk notification delivery, delivery failures | Notifications, Audit | notification type, recipient, actor if any, subject/target, action URL target, request/correlation ID | redact notification payload values; preserve type and target metadata | export notification metadata, not full sensitive payload by default | notification evidence links to related security event | Planned |
| `FE-DEPLOY-001` | Deployment and release evidence | deployment events, release gates, config changes, rollback events, artifact hashes | Security/Deployment, SupplyChain, Audit, Monitoring | environment, release ID, commit SHA, artifact hash, actor/service, result, occurred_at_utc | do not include raw environment secrets | store evidence privately; export manifests/hashes | deployment timeline includes artifact identity | Planned |
| `FE-SUPPLY-001` | Supply chain evidence | dependency findings, SBOM evidence, lockfile drift, compromised package response, scanner results | SupplyChain, Vulnerability Management, Monitoring | package, ecosystem, version, finding ID, severity, accepted risk, release ID | redact private advisory details if needed; never include secrets from scanner output | private evidence bundle; export summary plus hashes | supply-chain finding links to release evidence | Planned |
| `FE-BUSINESS-001` | Business module evidence | domain creates/updates/deletes, approvals, exports, generated files, jobs, notifications | Business modules, Audit | actor, subject/target resource, before/after safe values, scope, request/correlation ID, result | redact sensitive fields by DataProtection rules | business modules declare evidence sources in security/forensics docs | module evidence declaration exists before high-risk features | Planned |

## External And Server Evidence Sources

| Source ID | Source | Evidence Examples | Owner | Required Fields | Redaction / Handling | Retention / Export | First Tests | Status |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| `FE-EXT-001` | Web server logs | access logs, error logs, status codes, request paths, source IPs | Operations, Monitoring | timestamp, IP, method, path, status, request ID where available | avoid query strings with sensitive values; redact if exported | runbook-owned export; not collected into Laravel by default | request ID present in app and web logs where feasible | Planned |
| `FE-EXT-002` | PHP/Laravel logs | application logs, exception traces, warning logs | Monitoring, Operations | timestamp, environment, level, fingerprint, request/correlation ID | redact payloads, tokens, cookies, Authorization headers | export via runbook; app records safe central error summaries | exception evidence redacts request context | Planned |
| `FE-EXT-003` | Queue and scheduler logs | worker failures, retry attempts, scheduler output | Monitoring, Operations | job ID, queue, command/job class, timestamps, failure reason, correlation ID if inherited | redact job payloads and credentials | export via runbook; failed job summaries queryable | failed job evidence links to triggering request where possible | Planned |
| `FE-EXT-004` | Database logs | connection failures, slow/error logs, migration evidence where available | Operations, Monitoring | timestamp, database, user/role, result, query fingerprint when safe | do not export raw SQL containing sensitive values unless scoped/redacted | runbook-owned access; not normal app export | DB evidence handling documented before production | Planned |
| `FE-EXT-005` | Backup logs | backup success/failure, restore drill status, backup metadata | Backup/Recovery, Monitoring | timestamp, backup ID, storage target, result, size, hash if available | do not expose backup contents; store metadata only | backup/restore runbooks own export | backup evidence links to incident timeline | Planned |
| `FE-EXT-006` | Mail logs | notification/email delivery failures, sender events | Notifications, Operations | recipient reference, message type, provider ID, result, timestamp | redact message body and sensitive recipient data when possible | export metadata only unless incident scope requires more | mail evidence excludes sensitive body by default | Planned |
| `FE-EXT-007` | WAF/CDN logs | blocked requests, rate-limit events, source reputation, edge request IDs | Operations, Security, Monitoring | timestamp, source IP, rule ID, path, request ID if propagated | redact URLs/query strings as needed | future integration; runbook-owned first | deferred until WAF/CDN exists | Deferred |
| `FE-EXT-008` | SIEM/security event export | forwarded audit/monitoring/security summaries | Monitoring, Security | event IDs, correlation IDs, exported_at, target system, result | export safe summaries only; keep raw secrets excluded | future integration after event shape stabilizes | deferred until SIEM export is in scope | Deferred |

## Timeline Reconstruction Requirements

Every source that can participate in a timeline should support, where applicable:

```text
occurred_at_utc
source
event_key
actor
subject
target
result
route/job/source
ip
session_id
request_id
correlation_id
summary
evidence_reference
```

## Source Maintenance Rules

- Add evidence source rows before implementing high-risk Auth, Identity, Access, DataProtection, Security, Audit, Monitoring, Notifications, Secrets, SupplyChain, Vulnerability Management, or business-module workflows.
- Keep source IDs stable once referenced by tests, runbooks, evidence packages, or code comments.
- Do not add a source to evidence packages until redaction and access rules are clear.
- Do not collect raw server logs inside Laravel just to satisfy this matrix.
- Keep formal evidence package persistence deferred until investigation workflow requires it.

## Related

- [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md)
- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Incident Response Planning](incident-response-planning.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Software Supply Chain Security Planning](software-supply-chain-security-planning.md)
