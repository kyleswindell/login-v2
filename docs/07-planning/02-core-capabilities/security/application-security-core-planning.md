# Application Security Core Planning

Status: Planning draft

## Purpose

Plan `app/Core/Security` as the narrow cross-cutting application-security guardrail capability before route protection, request handling, upload/download safety, browser hardening, secure logging, security tests, and release checks are expanded across core capabilities and business modules.

This document owns implementation sequencing and intent only. Final standards, architecture contracts, feature behavior contracts, schema contracts, and runbooks must be promoted to their owning docs before implementation.

## Direction

Application security should not become a root `Modules/ApplicationSecurity` package and should not become a catch-all "Security module."

Target model:

```text
Core/Security owns cross-cutting application guardrails.
Core/Auth owns authentication.
Core/Identity owns user lifecycle.
Core/Access owns authorization and effective access.
Core/DataProtection owns data classification and data movement rules.
Core/Audit owns accountability evidence.
Core/Monitoring owns operational failures and anomaly detection.
Core/Notifications owns durable user/admin alerts.
Settings owns configurable security defaults.
Platform/Shell applies shell-level presentation and navigation.
Business modules own domain workflows and must satisfy the security contract.
```

Application security is enforced through a chain:

```text
route middleware
  -> FormRequest validation
  -> policy/gate authorization
  -> Core/Access effective-access resolver
  -> action/service domain invariants
  -> Core/DataProtection for sensitive data movement
  -> Core/Audit after commit
  -> Core/Monitoring for failures/anomalies
  -> Core/Notifications for inbox-worthy alerts
  -> tests proving allowed and denied paths
```

DLP and exfiltration direction is tracked in [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md). Application Security owns safe route, signed URL, payload, upload, and download guardrails that DataProtection DLP policies may require.

Digital forensics readiness is tracked in [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md) and the [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md). Application Security should provide request correlation, route security context, safe redaction, signed download validation, and sensitive action markers that Audit/Forensics can use when reconstructing incidents.

## Current Baseline

Current useful foundations:

- security standards exist under `docs/02-standards/security`
- transport, session, proxy, browser-header, ASVS, and delivery-gate standards exist
- runtime security middleware and checks exist in transitional app/platform locations
- authentication, MFA, Roles, Notifications, Settings, and Account tests already prove parts of the security surface
- package/module manifests can declare permissions, routes, UI entries, settings, preferences, notifications, and registry contributions
- current `security-checklist` and `runtime-security` vocabulary exists, but it is not yet cleanly separated into core guardrails versus internal checklist tooling

Missing planning boundary:

- no dedicated `app/Core/Security` target for cross-cutting guardrails
- no route security profile registry
- no standard sensitive-route contract
- no centralized safe redirect/signed URL validation plan
- no request payload redaction service boundary
- no upload security hook/quarantine planning boundary
- no first-class `tests/Feature/Security` planning target
- no application security release-check service boundary

## Core/Security Owns

`app/Core/Security` should own:

- security response header policy services
- Content Security Policy definition support
- HTTPS/trusted-proxy enforcement helpers where not already pure middleware/config
- safe redirect validation
- signed URL validation helpers for sensitive downloads
- route security profile classification and profile-registry planning
- request payload redaction rules used by logging, monitoring, and exception handling
- secure file upload scanning/quarantine hooks
- security release checklist services
- vulnerability-management lifecycle helpers for asset inventory, findings, risk scoring, release gates, and risk acceptance
- app-security verification helpers used by tests and runbooks

`app/Core/Security` should not own:

- password login, MFA, sessions, recovery, recent authentication, or trusted devices
- user lifecycle, invitation, suspension, or deactivation
- roles, groups, permissions, policies, or effective access
- data classification, masking, exports, retention, or erasure
- audit event storage or audit query UI
- central error logs, failed jobs, health checks, or anomaly records
- notification delivery or notification type registry
- business module workflow rules

## Target Structure

Candidate physical structure:

```text
app/Core/Security/
  Actions/
    RunSecurityReleaseChecks.php
    ValidateSignedDownload.php
    ClassifyRouteSecurityProfile.php
  Contracts/
    SecurityCheck.php
    SecurityHeaderPolicy.php
    RequestPayloadRedactor.php
  Data/
    SecurityCheckResult.php
    SecurityHeaderSet.php
    RouteSecurityProfileDefinition.php
    RequestSecurityContext.php
  Enums/
    SecurityCheckStatus.php
    SecurityHeaderPolicyName.php
    RequestRiskLevel.php
  Http/
    Middleware/
      AddSecurityHeaders.php
      EnforceHttps.php
      PreventUnsafeRedirects.php
      RedactSensitiveRequestContext.php
      RequireRouteSecurityProfileControls.php
  Services/
    SecurityHeaderService.php
    ContentSecurityPolicyService.php
    RouteSecurityProfileRegistry.php
    SafeRedirectService.php
    RequestPayloadRedactionService.php
    SecurityChecklistService.php
    UploadSecurityService.php
  Support/
    SecurityHeaders.php
    RouteSecurityProfiles.php
    SafeRedirect.php
    RedactedRequestValue.php
  Routes/
    admin-security.php
```

This is a target shape, not a commitment to create every file in the first implementation batch.

## Route Security Profiles

Application Security consumes the canonical route-security profile vocabulary from [Zero Trust Security Standards](../../../02-standards/security/Zero%20Trust%20Security%20Standards.md). This planning document does not own the vocabulary.

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

Profiles establish minimum trust, assurance, and authorization prerequisites. Owner Policies, DataProtection, Audit, Monitoring, reason, and approval requirements remain independently declared where applicable.

Signed URL validation is an orthogonal route-integrity requirement. API and webhook delivery are Invocation Channels with channel-specific controls; protected machine endpoints typically use the `service` profile.

Representative classifications include:

- `sensitive`: assigning or removing high privilege, resetting MFA for another user, changing an Access policy, and changing a security setting;
- `restricted_data`: restricted export or download.

Not every administrative route is sensitive.

## Controller, Action, And Service Security Rule

Standard protected workflow:

```text
Controller
  -> middleware authenticates broad route access
  -> FormRequest validates input
  -> policy authorizes specific action and target
  -> Action performs transaction
  -> Audit records after commit
  -> Monitoring/Notifications run after commit when needed
```

Controllers may:

- receive the request
- use a FormRequest
- call `authorize()`
- call one action or query/view-model boundary
- redirect or respond

Controllers should not:

- directly mutate several models for a sensitive workflow
- decide permission logic manually
- write audit rows manually
- send security notifications manually
- generate sensitive exports inline

Actions own workflow integrity:

- transaction boundary
- domain invariants
- last-admin guardrails
- separation-of-duty guardrails
- audit-after-commit behavior
- notification-after-commit behavior

Services own reusable domain logic:

- effective access resolution
- data classification and redaction
- export generation
- session revocation
- MFA verification
- safe redirect and signed download validation

## Request Handling And State Changes

FormRequest classes should be required for every write action.

Examples:

```text
app/Core/Identity/Http/Requests/InviteUserRequest.php
app/Core/Identity/Http/Requests/SuspendUserRequest.php
app/Core/Access/Http/Requests/CreateAccessPolicyRequest.php
app/Core/DataProtection/Http/Requests/CreateDataExportRequest.php
Modules/Customers/Http/Requests/StoreCustomerRequest.php
Modules/Inventory/Http/Requests/AdjustInventoryRequest.php
```

Validation must protect against:

- unexpected fields
- invalid enum values
- overly long strings
- invalid file types
- invalid target IDs
- cross-scope references
- forbidden status transitions
- missing reasons for sensitive actions

State-changing browser actions must not use GET.

Not allowed:

```text
GET /admin/users/{user}/suspend
GET /admin/access/policies/{policy}/revoke
GET /notifications/{notification}/dismiss
GET /exports/{export}/download-and-delete
```

Expected shape:

```text
POST /admin/users/{user}/suspend
DELETE /admin/access/policies/{policy}
PATCH /notifications/{notification}/dismiss
GET /exports/{export}/download only for signed expiring downloads
```

## Output And Blade Safety

Blade escaped output remains the default.

Rules:

- use `{{ $value }}` by default
- avoid `{!! $value !!}`
- do not render stored user/customer/order/admin text as raw HTML
- centralize rich text sanitization before any rich text feature is approved
- do not allow raw HTML from database content in ordinary admin or business views

High-risk fields:

- customer notes
- order notes
- shipment notes
- notification titles and bodies
- audit summaries
- admin comments
- settings descriptions
- package/module descriptions

If rich text is approved later, plan a `Core/Security` sanitizer boundary and store sanitized output separately when needed.

## Authorization And Object-Level Security

Navigation filtering is not a security control. Every protected resource action needs:

```text
Can the user perform this action?
Can the user perform it on this specific target?
```

Examples:

```text
customers.view + customer:123
orders.approve + order:987
shipments.confirm + shipment:456
users.suspend + user:91
access.policy.revoke + policy:55
```

Policy pattern:

```php
$this->authorize('update', $customer);
```

The policy can then delegate to `Core/Access`:

```php
return $access->allows(
    user: $user,
    ability: 'customers.update',
    target: $customer,
);
```

## Mass Assignment And Over-Posting

Sensitive actions should be split instead of handled by broad update methods.

Preferred:

```text
UpdateUserProfile
UpdateUserEmail
SuspendUser
DeactivateUser
ResetUserMfa
ForcePasswordReset
AssignUserToGroup
CreateAccessPolicy
```

Avoid:

```text
UpdateUserEverything
```

Control chain:

- FormRequest validates only allowed fields
- DTO maps only allowed fields
- Action writes only allowed fields
- sensitive fields require separate actions
- sensitive actions require separate permissions and guardrails

## Uploads And Downloads

Storage should distinguish public assets from private/sensitive files.

Recommended disks:

```text
public
private
exports
imports
quarantine
```

Upload rules:

- validate file size
- validate MIME type and extension
- store untrusted uploads outside public web root
- generate server-side filenames
- never trust original filenames
- scan or quarantine high-risk uploads later
- authorize every download
- audit sensitive file downloads

Download rules:

- sensitive downloads use signed, expiring links
- export downloads stay under DataProtection export policy
- public storage is only for intentionally public assets
- generated export files are private and short-lived

## Rate Limiting And Abuse Resistance

Rate limits should protect enumeration, brute force, spam, and operational abuse.

Initial rate limiter names:

```text
auth.login
auth.password_reset
auth.mfa
auth.recovery_code
identity.invitation
data.export
admin.bulk_action
```

First surfaces:

- login attempts
- password reset requests
- MFA challenge attempts
- recovery code attempts
- invite resend
- email verification resend
- export creation
- bulk actions
- future API endpoints

## Session Security Coordination

Auth owns session mechanics, but Security owns cross-cutting route/session posture requirements.

Important session markers:

```text
authenticated_at
mfa_satisfied_at
recent_auth_at
elevated_access_until
active_elevated_role_id
password_confirmed_at
trusted_device_id
```

Rules:

- rotate session ID after login
- rotate session ID after privilege elevation
- revoke sessions when a user is suspended or deactivated
- revoke sessions after admin-forced password reset when policy requires it
- require recent authentication for MFA disable, password change, security settings, elevated access, and restricted exports
- expire elevated sessions quickly

Do not treat old MFA satisfaction as enough for dangerous admin actions.

## Security Headers And CSP

This belongs in `Core/Security`, with standards owned by `docs/02-standards/security`.

Baseline headers to plan:

```text
Content-Security-Policy
X-Content-Type-Options: nosniff
Referrer-Policy
Permissions-Policy
X-Frame-Options or CSP frame-ancestors
Strict-Transport-Security in production HTTPS
```

CSP should be designed early because the UI uses Blade, Vite assets, JavaScript components, icons, dialogs, and compiled CSS/JS.

Avoid inline scripts and styles in new components whenever practical.

## Error Handling And Request Redaction

Security should own request redaction rules consumed by Monitoring, Audit, and exception handling.

Do not log:

- passwords
- MFA codes
- TOTP secrets
- recovery codes
- password reset tokens
- invitation tokens
- session IDs
- remember tokens
- API tokens
- raw Authorization headers
- full sensitive export contents

Initial redaction keys:

```text
password
password_confirmation
current_password
token
otp
code
recovery_code
secret
authorization
api_key
mfa_secret
```

Monitoring owns the error record. Audit owns security/accountability evidence. Security owns redaction rules that help both avoid storing unsafe values.

## Dependency And Supply Chain Security

Planning direction:

- Composer and npm lockfiles must be committed and reviewed
- dependency advisories should block release when critical/high risks are unaccepted
- abandoned packages require explicit review
- new packages require owner and justification
- dependency patching needs a runbook before production maturity
- security tooling should cover Composer and npm

Expected future runbooks:

- dependency patching
- security release checklist
- authenticated DAST or browser-driven security review

Software supply-chain direction is tracked separately in [Software Supply Chain Security Planning](software-supply-chain-security-planning.md). That plan owns dependency inventory, SBOM metadata, lockfile policy, build artifact identity, release evidence, and supply-chain release gates.

Offensive security direction is tracked separately in [Offensive Security And Penetration Testing Planning](offensive-security-penetration-testing-planning.md). That plan owns authorized testing scope, test perspectives, staging/DAST expectations, evidence handling, retest requirements, and attacker-perspective validation of critical controls.

Vulnerability-management direction is tracked separately in [Vulnerability Management Core Planning](vulnerability-management-core-planning.md). That plan owns finding lifecycle, asset inventory metadata, risk scoring, accepted risk, release-blocking policy, and patch cadence.

Secrets-management direction is tracked separately in [Secrets Management Core Planning](secrets-management-core-planning.md). That plan owns credential-specific redaction patterns, secret inventory metadata, reveal/copy/rotation guardrails, and future vault integration boundaries.

This Application Security plan owns the broader `Core/Security` guardrail boundary.

## Security Testing Direction

Add a dedicated security feature test target when implementation begins:

```text
tests/Feature/Security/
  AuthenticationSecurityTest.php
  MfaSecurityTest.php
  AuthorizationSecurityTest.php
  AdminRouteProtectionTest.php
  SensitiveExportSecurityTest.php
  FileDownloadSecurityTest.php
  UserLifecycleSecurityTest.php
  AccessPolicySecurityTest.php
  SecurityHeadersTest.php
  CsrfAndMethodSafetyTest.php
```

Security tests should cover at least:

- guest denied
- authenticated non-privileged denied
- privileged allowed
- wrong target denied
- state-changing GET blocked or absent
- CSRF applies to browser writes
- sensitive route requires recent authentication where required
- object-level policy enforced
- unsafe redirect rejected
- signed download expires
- headers present on HTML responses

## Business Module Security Contract

Every business module should eventually include:

```text
Modules/{Module}/Definitions/{Module}Permissions.php
Modules/{Module}/Definitions/{Module}DataAssets.php
Modules/{Module}/Policies/*
Modules/{Module}/Http/Requests/*
Modules/{Module}/Actions/*
Modules/{Module}/tests/Feature/Security/*
```

Required module security doc:

```text
Modules/{Module}/docs/security.md
```

Template:

```text
# {Module} Security

## Data classification
## Permissions
## Sensitive actions
## Export/download behavior
## Audit events
## Access scopes
## Abuse cases
## Required tests
```

The `_Template` package should include this once the business-module template is updated.

## Zero Trust And Cybersecurity Review Backlog

Zero Trust direction is tracked in [Zero Trust Security Planning](zero-trust-security-planning.md). Application Security consumes the canonical route-security profiles, plans request-security-context support when needed, applies sensitive route trust decisions, and delegates to Auth, Access, DataProtection, Audit, Monitoring, and Notifications.

Threat modeling and security controls direction is tracked in [Threat Modeling And Security Controls Planning](threat-modeling-security-controls-planning.md) and the [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md). Application Security should consume that work for route, request, redirect, upload/download, FormRequest, policy, and release-check coverage.

Threat Detection and Response direction is tracked in [Threat Detection And Response Planning](threat-detection-response-planning.md) and the [Detection Use Case Matrix](detection-use-case-matrix.md). Application Security should produce route/request/security-control evidence that Monitoring can use for unsafe redirect attempts, state-changing method anomalies, upload rejection spikes, and release-check failures.

Digital forensics readiness is tracked in [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md) and the [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md). Application Security should treat request IDs, correlation IDs, session IDs, route security profiles, and redacted request context as evidence-enabling controls rather than dashboard-only details.

Cloud and deployment hardening direction is tracked in [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md). Application Security owns app-level production safety checks such as HTTPS/trusted proxy assumptions, security headers, public exposure checks, storage exposure checks, safe deployment configuration checks, and release-gate integration.

API, webhook, and service-account security direction is tracked in [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md). API and webhook delivery are Invocation Channels, not route-security profiles. Application Security plans request-validation guardrails, payload limits, idempotency and replay conventions, rate-limit posture, and webhook-verification guardrails; protected machine endpoints typically consume the `service` profile, while Auth owns token verification and Access owns policy decisions.

Software supply-chain direction is tracked in [Software Supply Chain Security Planning](software-supply-chain-security-planning.md). Application Security should consume that work for dependency review expectations, release checks, lockfile drift detection, third-party script posture, and package-owner justification.

Offensive security direction is tracked in [Offensive Security And Penetration Testing Planning](offensive-security-penetration-testing-planning.md). Application Security should consume that work for forced browsing, IDOR, MFA bypass, export bypass, notification action abuse, upload/download abuse, DAST staging, and security-test evidence expectations.

Broader cybersecurity topics are tracked in [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md).

## Implementation Sequence

### 1. Standards And Planning Alignment

- Link this planning direction from the core capability migration plan.
- Align route/request controls with the threat-control traceability matrix before implementation batches claim security completeness.
- Keep rules in `docs/02-standards/security`.
- Keep runbook operations in `docs/10-runbooks`.
- Keep feature behavior in `docs/04-features` when a concrete Security or checklist surface is approved.

### 2. Core/Security Boundary

- Introduce `app/Core/Security` namespace and service boundary.
- Move or wrap runtime security header/check behavior behind `Core/Security` when a scoped code batch owns it.
- Keep current middleware and runtime-check compatibility until tests protect migration.

### 3. Route Security Profiles

- Consume the canonical route-security profiles from [Zero Trust Security Standards](../../../02-standards/security/Zero%20Trust%20Security%20Standards.md) and define profile declarations where implementation requires them.
- Add route security profile coverage, unclassified-route detection, and minimum-profile-control verification.
- Add conventions for MFA and recent-authentication requirements on `sensitive` and `restricted_data` routes according to Auth and owner requirements.

### 4. Request And Controller Contract

- Require FormRequest classes for write actions.
- Require policy authorization for protected controller actions.
- Add tests that prove direct URL access is denied even when navigation is hidden.
- Add no-state-changing-GET checks.

### 5. Redaction And Safe URL Helpers

- Add request payload redaction service.
- Consume secret-like redaction patterns from `Core/Security/Secrets` once the Secrets Management baseline exists.
- Add safe redirect validation.
- Add signed download validation helpers for DataProtection export flows.
- Wire redaction into Monitoring/Audit only through scoped implementation batches.

### 6. Upload, Download, And Export Safety

- Plan upload storage and quarantine conventions.
- Keep DataProtection as the owner of export policy.
- Add private storage and signed URL tests for sensitive downloads.

### 7. Security Tests And Release Checks

- Create `tests/Feature/Security` for cross-cutting security assertions.
- Add security release checklist service only after the standards and runbook shape are accepted.
- Add dependency audit and static analysis gates through runbooks or CI planning.
- Add offensive-security test targets for Auth, Access, DataProtection, Notifications, upload/download, and error/secret leakage after the offensive testing standard is promoted.
- Use the vulnerability-management plan to define which findings block merge/deploy and how accepted risk expires.

### 8. Business Module Template

- Update `_Template` only after the module/package vocabulary decision is accepted.
- Add module security doc, FormRequest, policy, data asset, permission, and security test placeholders.

## Test Planning

Expected tests once implemented:

- security headers are applied to HTML responses
- HSTS only appears when configured and request context is secure
- `sensitive` routes require risk-appropriate authorization, MFA, recent authentication, and any owner-specific controls
- write routes have FormRequest validation coverage
- protected controllers use policy authorization
- normal users cannot access hidden admin URLs directly
- state-changing GET routes are absent
- unsafe redirect targets are rejected
- request payload redaction removes secrets from monitoring/audit context
- signed URLs for restricted downloads expire and protect integrity; the underlying `restricted_data` route still requires authorization
- upload validation rejects disallowed size/type/extension
- route security profile registry can detect unclassified routes and support minimum-profile-control verification

## Transition Rules

- Do not create `Modules/ApplicationSecurity`.
- Do not make `Core/Security` own Auth, Identity, Access, DataProtection, Audit, Monitoring, or Notifications behavior.
- Do not treat Security Checklist as the same thing as app security enforcement.
- Do not add route/security DB rows that introduce executable behavior.
- Do not rely on hidden navigation as authorization.
- Do not allow state-changing GET routes.
- Do not add broad CSP enforcement without rendered route testing.
- Do not add security packages without owner, justification, and dependency review.
- Do not run sensitive exports or downloads through public storage.
- Do not make Application Security own raw secret storage, reveal flows, rotation workflows, or vault integration details.

## Open Decisions

- Should `runtime-security` static metadata be folded into `app/Core/Security` immediately or kept as compatibility metadata until package vocabulary is renamed?
- What is the first source of route-security profile declarations: route metadata, manifest contribution, code registry, or tests only?
- Should route security profiles be projected to a registry table later, or remain code/test-only?
- Which existing middleware should move first: security headers, trusted proxy, HTTPS enforcement, or request redaction?
- What minimum release checks block production promotion before CI is mature?
- Which vulnerability-management release gate should be first: Composer audit, npm audit, route policy coverage, or security runtime check?
- Which secrets-management release gate should be first: committed env file detection, `APP_KEY` pattern detection, authorization/cookie leakage checks, or scanner-backed secret findings?
- Should Security Checklist remain an internal tool, or eventually become a view over Core/Security, Audit, Monitoring, and deployment evidence?

## Out Of Scope

- implementing `app/Core/Security` in this pass
- rewriting existing middleware in this pass
- changing production deployment checks in this pass
- adding CI security scanners in this pass
- defining final standards in this planning document
- editing `/docs/08-active/`

## Related

- [Core Capability Package Migration Planning](core-capability-package-migration-planning.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)
- [Threat Modeling And Security Controls Planning](threat-modeling-security-controls-planning.md)
- [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [Digital Forensics Readiness Planning](digital-forensics-readiness-planning.md)
- [Forensic Evidence Source Matrix](forensic-evidence-source-matrix.md)
- [Cloud And Deployment Hardening Planning](cloud-deployment-hardening-planning.md)
- [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md)
- [Zero Trust Security Planning](zero-trust-security-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
- [Incident Response Planning](incident-response-planning.md)
- [Security Standards](../02-standards/security/Security%20Standards.md)
- [Application Security Verification And Secure Delivery Standards](../02-standards/security/Application%20Security%20Verification%20And%20Secure%20Delivery%20Standards.md)
- [Transport Session And Browser Security Standards](../02-standards/security/Transport%20Session%20And%20Browser%20Security%20Standards.md)
