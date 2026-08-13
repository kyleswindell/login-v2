<!--
DOC-META
title: Zero Trust Security Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Zero Trust Security Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines explicit validation, least privilege, assume-breach behavior, context-aware access, time-bounded assurance, and continuous revalidation.
-->

# Zero Trust Security Standards

Parent: [Security Standards Index](index.md)

- [1. Purpose](#1-purpose)
- [2. Core Rule](#2-core-rule)
- [3. No Implicit Trust](#3-no-implicit-trust)
- [4. Least Privilege](#4-least-privilege)
- [5. Continuous Validation](#5-continuous-validation)
- [6. Assurance](#6-assurance)
- [7. Request Security Context](#7-request-security-context)
- [8. Assume Breach](#8-assume-breach)
- [9. Route Security Profiles](#9-route-security-profiles)
- [10. Service Identities](#10-service-identities)
- [11. Verification](#11-verification)
- [12. Related](#12-related)

## 1. Purpose

Apply Zero Trust principles as cross-cutting requirements rather than a standalone product or module.

## 2. Core Rule

Every protected action must be explicitly authenticated, authorized, scoped, context-aware, time-aware, auditable, and revalidated when sensitivity changes.

## 3. No Implicit Trust

Do not trust an actor or request merely because it is inside a private network, from an internal hostname, from a known device, from an administrator area, from a service account, from a previous trusted session, initiated by a background job, or associated with an existing notification.

## 4. Least Privilege

Grant only the actions, targets, scopes, and duration required.

Use separate permissions for view and export, normal and sensitive view, create and approve, manage and elevate, and human and API access.

## 5. Continuous Validation

Revalidate when accessing a new target, changing scope, performing a sensitive action, downloading or exporting, revealing or rotating a secret, activating elevated access, opening a notification action, using a signed link, or resuming a long-running job.

## 6. Assurance

Use risk-appropriate assurance:

- authenticated session
- MFA
- recent authentication
- phishing-resistant factor where required
- elevated access
- approval
- reason capture

Previous authentication does not create unlimited future trust.

## 7. Request Security Context

Security decisions should be able to consider applicable actor, actor type, session, authentication factors, recent-auth time, target, scope, route, environment, IP and user agent, data classification, operation risk, and policy source.

## 8. Assume Breach

Design for credential misuse and lateral movement by minimizing credential scope, rotating secrets, recording denials, detecting abnormal use, limiting export and bulk access, preserving evidence, supporting revocation, and avoiding broad internal bypasses.

## 9. Route Security Profiles

Every application route must be classified by one canonical Security profile once route-profile enforcement is applied. The canonical profile keys are:

```text
public
guest
authenticated
protected
administrative
sensitive
restricted_data
service
```

These keys follow the canonical internal identifier grammar. Profiles define minimum security prerequisites. An owner may require stronger controls than its profile baseline, but must not weaken the profile baseline.

### 9.1 `public`

No authenticated Principal is required. The route must not expose protected state merely because it is public.

Input validation, rate limiting, request-forgery protection for browser writes, and abuse resistance still apply where required.

### 9.2 `guest`

Interactive unauthenticated behavior intended specifically for a guest state, such as login, recovery entry, or another explicitly guest-only flow. An authenticated session may be rejected where route semantics require guest-only behavior.

Guest does not mean unprotected from rate limiting, enumeration resistance, request validation, or request-forgery controls.

### 9.3 `authenticated`

Requires a currently valid authenticated human session and applicable loginable or active account posture. It does not itself grant action authorization, target authorization, administrative authority, or export permission.

Authentication remains distinct from authorization.

### 9.4 `protected`

Requires the authenticated baseline plus explicit authorization for the requested action, target, and scope. Use this for ordinary protected application behavior where object or scope authorization is required.

A route profile does not replace the owner Policy or Core Access decision.

### 9.5 `administrative`

Requires the protected baseline plus explicit administrative authority and MFA-level authentication assurance. Administrative location, route prefix, navigation placement, or UI visibility does not establish this authority.

### 9.6 `sensitive`

Requires risk-appropriate action, target, and scope authorization plus MFA and recent authentication. Reason, approval, elevated access, Audit, and Monitoring apply when the owning requirement demands them.

`sensitive` may apply to high-risk self-service behavior as well as administrative behavior. Representative use cases include password or primary-email security changes, MFA disable or reset, recovery-code regeneration, secret reveal or rotation, and privileged access changes.

### 9.7 `restricted_data`

Uses the sensitive baseline plus explicit restricted-data movement or access controls. Applicable requirements include separate restricted-data or export authorization, DataProtection evaluation, reason where required, approval where required, accountable Audit evidence, Monitoring where required, and private or safe delivery controls.

`restricted_data` does not imply that ordinary view permission grants export permission.

### 9.8 `service`

Protected non-browser or machine-to-machine interaction. It requires applicable explicit machine, service, or request identity (or provider verification), scoped authorization, credential or signature protection, request validation, abuse and rate controls, and a revocation path.

Channel-specific replay protection and idempotency apply where required. Internal network origin is not authentication.

### 9.9 Orthogonal Security Dimensions

#### Invocation Channel

Core Runtime owns how execution entered:

```text
interactive_web
api_request
webhook_request
console_command
queued_job
event_consumer
scheduled_task
internal_system
```

Invocation Channel is not a Security profile. Do not duplicate API or webhook delivery as profile values.

```text
security profile: service
invocation channel: api_request

security profile: service
invocation channel: webhook_request

security profile: public
invocation channel: api_request
```

The last example may apply to a genuinely unauthenticated public API endpoint.

#### Signed URL

Signed URL validation is an integrity mechanism, not a Security profile. A signed URL does not authenticate the current Actor, authorize the current target, or establish scope.

```text
security profile: restricted_data
signed URL required: true

security profile: authenticated
signed URL required: true
```

The underlying behavior determines the profile. Do not create a signed-download profile.

#### Other Orthogonal Requirements

The following remain independently declared and enforced where applicable:

- CSRF or request-forgery protection;
- named rate limiting;
- replay protection;
- idempotency;
- owner Policy or target authorization;
- DataProtection;
- reason;
- approval;
- Audit; and
- Monitoring.

## 10. Service Identities

Machine identities require explicit owners, scopes, environments, credentials, and review.

Internal automation must not inherit implicit trust.

## 11. Verification

Verify sensitive route prerequisites, target and scope checks, recent-auth expiration, elevated-access expiration, signed-link reauthorization, service-account restrictions, notification action revalidation, and evidence for allow and deny decisions.

## 12. Related

- [Access Control And Authorization Standards](Access%20Control%20And%20Authorization%20Standards.md)
- [Identity And Account Security Standards](Identity%20And%20Account%20Security%20Standards.md)
- [Zero Trust Security Planning](../../07-planning/02-core-capabilities/security/zero-trust-security-planning.md)
