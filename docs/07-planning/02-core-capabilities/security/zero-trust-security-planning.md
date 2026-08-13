# Zero Trust Security Planning

Status: Planning

## Purpose

Plan Zero Trust as a cross-cutting security architecture standard for Login 2.0.

Zero Trust should not become a business module, a dashboard-first feature, or a standalone `app/Core/ZeroTrust` capability. It should govern how Auth, Identity, Access, DataProtection, Security, Audit, Monitoring, Notifications, Secrets, and future service identities work together.

Planning rule:

```text
Every protected action must be explicitly authenticated, authorized, scoped, risk-aware, time-aware, logged, and revalidated when the context becomes sensitive.
```

## Ownership Boundary

Zero Trust standard:

```text
docs/02-standards/security/zero-trust.md
```

Enforcement support:

```text
app/Core/Security
```

Identity proof:

```text
app/Core/Auth
app/Core/Identity
```

Permission and scope:

```text
app/Core/Access
```

Data sensitivity:

```text
app/Core/DataProtection
```

Evidence:

```text
app/Core/Audit
```

Detection:

```text
app/Core/Monitoring
```

Alerts:

```text
app/Core/Notifications
```

Secrets and nonhuman credentials:

```text
app/Core/Security/Secrets
```

Do not create:

```text
Modules/ZeroTrust
app/Core/ZeroTrust
```

Optional `app/Core/Security/ZeroTrust` support classes may be added later only if they reduce duplication in route sensitivity, request security context, or trust-decision handling.

## Zero Trust Assumptions

Use these assumptions across protected app behavior:

```text
Logged in does not mean trusted.
MFA passed does not authorize every action.
Visible navigation does not grant permission.
Assigned role does not imply unlimited scope.
Internal app requests are not inherently safe.
Background jobs are not inherently trusted.
Previous access does not guarantee current access.
```

Each protected request should ask:

- Who is making the request?
- Is their identity and session still trustworthy?
- What action are they trying to perform?
- What resource or data is involved?
- How sensitive is that resource?
- Is the action normal for this user, role, source, and session?
- Should this require MFA, recent authentication, elevation, reason, approval, audit, monitoring, or notification?
- Should access be denied?

## Principles

### Continuous Monitoring And Validation

Do not validate only at login. Validate again at sensitive route, sensitive action, sensitive data, elevated access, export, secret reveal, and session-risk boundaries.

Core mapping:

| Owner | Zero Trust Responsibility |
| --- | --- |
| Auth | MFA state, recent-auth state, session age, session rotation, trusted-device future state |
| Identity | active/suspended/deactivated status and user security posture |
| Access | per-action authorization, per-resource scope checks, elevated access validation |
| DataProtection | classification and sensitive data movement rules |
| Audit | allowed/denied sensitive action evidence |
| Monitoring | unusual auth/access/export/secret/elevated-use patterns |
| Notifications | required security notices |

### Least Privilege

Access should be scoped to the minimum needed action, target, context, duration, and review expectation.

Access model direction:

```text
Subject -> Target -> Role -> Actions -> Context -> Duration -> Review
```

Core/Access should support:

- standing access
- temporary access
- direct exception access
- elevated access session
- expiration
- reason
- approval
- review

Avoid:

- permanent Super Admin everywhere
- permanent direct user exceptions
- global access by default
- role assignment without scope where scope is needed
- view permission implying export permission

### Breach Assumption

Assume accounts, sessions, service tokens, or privileged access can be compromised.

If a user account is compromised:

- MFA should reduce takeover risk.
- recent authentication should protect sensitive changes.
- scoped access should limit blast radius.
- export permissions should prevent mass data movement.
- audit should show what happened.
- monitoring should flag unusual behavior.
- notifications should alert required owners.
- incident runbooks should define response.

If an admin account is compromised:

- elevated access should be time-limited.
- self-escalation should be blocked.
- last Super Admin protections should exist.
- privileged access actions should be audited.
- direct policy changes should trigger review or notification.

If a service account or API token is compromised:

- token should be scoped.
- token should be rotatable and revokable.
- service actor should be audit-visible.
- abnormal service behavior should be monitored.

## Pillars

### Identity

Protected requests should evaluate current identity state, not only session existence.

Baseline protected stack:

```text
auth
identity.active
auth.mfa when required
policy/resource authorization
auth.recent when sensitive
elevated session when privileged
```

### Devices

Do not overbuild device management first. Start with app-session device signals.

Future trusted-device model:

```text
trusted_devices
  user_id
  device_hash
  name
  browser/user-agent summary
  last_used_at
  expires_at
  revoked_at
```

Trusted devices should be:

- time-limited
- revokable
- audited
- invalidated after password or MFA reset when policy says so

Initial uses:

- new-device login notification
- suspicious login monitoring
- account-compromise review
- session revocation UI
- later MFA relaxation only if approved

### Networks

For this Laravel app, network segmentation maps to application-layer route segmentation.

Route security profiles are defined by [Zero Trust Security Standards](../../../02-standards/security/Zero%20Trust%20Security%20Standards.md); this planning document consumes rather than owns that vocabulary:

| Profile | Minimum posture |
| --- | --- |
| `public` | No authenticated Principal; no protected state exposure; applicable validation, request-forgery, rate, and abuse controls remain required. |
| `guest` | Explicit interactive guest behavior; may reject authenticated sessions; applicable enumeration, validation, request-forgery, and rate controls remain required. |
| `authenticated` | Valid authenticated human session and applicable active-account posture; no action or target authority is implied. |
| `protected` | Authenticated baseline plus action, target, and scope authorization. |
| `administrative` | Protected baseline plus explicit administrative authority and MFA-level assurance. |
| `sensitive` | Risk-appropriate authorization plus MFA and recent authentication; owner requirements may add reason, approval, elevated access, Audit, or Monitoring. |
| `restricted_data` | Sensitive baseline plus restricted-data movement or access controls, DataProtection, and separate export authorization where applicable. |
| `service` | Protected machine-to-machine interaction with explicit identity or provider verification, scoped authorization, request validation, rate or abuse controls, and revocation. |

API and webhook delivery are Invocation Channels, signed URLs are integrity mechanisms, and request-forgery protection, rate limiting, replay protection, idempotency, owner authorization, DataProtection, reason, approval, Audit, and Monitoring remain orthogonal requirements.

### Applications And Workloads

Applications, APIs, jobs, and internal services should not receive implicit trust.

Rules:

- Controllers do not trust hidden UI controls.
- Services do not trust that controllers already checked access.
- Jobs do not act on sensitive data without an explicit service/job actor.
- Notifications do not trust stale action links.
- Exports do not trust prior view permission.
- APIs and webhooks do not trust network origin alone.

Protected workflow direction:

```text
Route middleware
  -> FormRequest validation
  -> Policy/Gate authorization
  -> Action domain guardrails
  -> Access resolver for ability and target
  -> DataProtection check for sensitive movement
  -> Audit after commit
  -> Monitoring/notification on high-risk or abnormal behavior
```

Background job direction:

```text
Job actor = job/service/integration
Job action = explicit
Job scope = explicit
Job audit = required for sensitive work
```

### Data

Data controls should be based on classification and movement, not only record visibility.

Core/DataProtection should define:

- classification
- sensitive fields
- redaction/masking
- secure exports
- retention
- erasure

Core/Access should distinguish:

- view permission
- view sensitive permission
- export permission
- export sensitive permission
- approve restricted export

Core/Monitoring should detect:

- bulk export spikes
- repeated denied export attempts
- abnormal record access volume
- secret reveal spikes
- elevated access outside normal patterns

## Trust Decision Language

Sensitive actions need more than allow/deny.

Candidate enum:

```php
enum TrustDecision: string
{
    case Allow = 'allow';
    case Deny = 'deny';
    case RequireMfa = 'require_mfa';
    case RequireRecentAuth = 'require_recent_auth';
    case RequireElevation = 'require_elevation';
    case RequireApproval = 'require_approval';
    case AllowAndAudit = 'allow_and_audit';
    case AllowAndNotify = 'allow_and_notify';
}
```

Candidate sensitive actions:

- change password
- change email
- disable MFA
- generate recovery codes
- reset another user's MFA
- assign Super Admin
- create access policy
- reveal secret
- download export
- bulk delete
- approve order
- adjust inventory

## Request Security Context

Zero Trust support may use a shared request context under `app/Core/Security` if it reduces duplicated checks.

Candidate data object:

```php
final readonly class RequestSecurityContext
{
    public function __construct(
        public int $userId,
        public string $userStatus,
        public bool $mfaSatisfied,
        public ?string $mfaSatisfiedAt,
        public ?string $recentAuthAt,
        public ?string $ipAddress,
        public ?string $userAgent,
        public ?string $trustedDeviceId,
        public ?string $activeElevatedRoleId,
        public array $riskSignals = [],
    ) {}
}
```

Candidate support structure:

```text
app/Core/Security/ZeroTrust/
  Data/RequestSecurityContext.php
  Enums/TrustDecision.php
  Services/RequestSecurityContextResolver.php
  Services/TrustDecisionService.php
  Support/SensitiveRoutePolicy.php
```

Only create this structure if implementation proves it has a real runtime job.

## Auth And Session Updates

Auth should plan for:

- `mfa_satisfied_at`
- `recent_auth_at`
- `session_rotated_at`
- `active_elevated_role_id`
- `elevated_access_expires_at`
- `trusted_device_id`
- future `risk_score` or `risk_flags`

Sensitive actions requiring recent authentication should include:

- change password
- change email
- disable MFA
- generate recovery codes
- reset another user's MFA
- create or revoke access policy
- assign elevated role
- reveal secret
- create sensitive export
- delete/deactivate user

Step-up authentication should be selective and explainable, not constant.

## Access Control Updates

RBAC alone is not enough for Zero Trust.

Core/Access should combine:

- RBAC: users, groups, roles, permissions
- policy/scoping: subject, target, role, action
- context: data classification, time/session state, MFA, recent auth, elevated session, source/risk signal
- JIT/elevated access: temporary access, expiration, reason, approval
- review: access review, stale access, direct exceptions

The resolver should evolve toward:

```php
$access->allows(
    user: $user,
    ability: 'orders.approve',
    target: $order,
    context: $requestSecurityContext,
);
```

Do not design the resolver so narrowly that it can only answer role membership.

## Audit And Monitoring Updates

Candidate audit events:

```text
access.allowed_sensitive
access.denied
auth.recent_auth_required
auth.recent_auth_completed
auth.mfa_step_up_required
access.elevated_activated
access.elevated_expired
data.export_requested
data.export_downloaded
secrets.revealed
security.trust_decision_denied
security.trust_decision_step_up
```

Candidate monitoring rules:

- repeated denied admin route access
- repeated failed MFA
- repeated failed recent-auth prompts
- export spike
- secret reveal spike
- elevated access outside normal hours
- user views many customer records unusually fast
- access policy changes followed by export

Audit should store accountable evidence. Monitoring should detect patterns. Notifications should alert required owners. Incident runbooks should define response.

## UI And UX Intent

Zero Trust friction should be visible enough to explain why it is happening.

Recent auth copy:

```text
Confirm it is you to continue.
This action changes sensitive security settings and requires recent authentication.
```

Elevated access banner:

```text
Elevated access active
Role: Access Administrator
Expires in: 24 minutes
Reason: Review access policy issue
End session
```

Denied access copy:

```text
You do not have access to this resource.
```

Sensitive export copy:

```text
This export contains confidential data.
Provide a reason before continuing. The export and download will be audited.
```

Do not leak detailed authorization internals in user-facing denial messages. Put detail in audit/admin tooling for authorized reviewers.

## Implementation Sequence

### 1. Standard And Vocabulary

- Consume [Zero Trust Security Standards](../../../02-standards/security/Zero%20Trust%20Security%20Standards.md) for default deny, continuous validation, least privilege, breach assumption, route-security profiles, trust decisions, and step-up rules.

### 2. Route Security Profiles

- Align Application Security with the canonical route-security profiles.
- Identify the first concrete `sensitive` actions and `restricted_data` movement or access actions.
- Avoid relying on hidden navigation as security.

### 3. Request Security Context

- Define `RequestSecurityContext` only when multiple guards/services need shared context.
- Keep initial fields small and practical.

### 4. Recent Auth And MFA Step-Up

- Apply recent-authentication requirements to `sensitive` and `restricted_data` routes and actions according to the accepted Auth and owner requirements.
- Require MFA or re-challenge where policy says the session proof is not strong enough.

### 5. Context-Aware Access Resolver

- Let Access resolver accept context even if it only uses basic fields initially.
- Keep view/export and standard/restricted action separation.

### 6. Audit And Monitoring

- Audit sensitive allow/deny/step-up/elevated decisions after transaction boundaries are clear.
- Add monitoring signals for repeated denials, export spikes, secret reveal spikes, and abnormal elevated access.

### 7. Elevated Sessions

- Add elevated-session expiration.
- Show an explicit elevated-access banner.
- Audit activation, expiration, and end-session events.

### 8. Future Device And Service Actor Support

- Add trusted devices only after base MFA/recent-auth flows stabilize.
- Add service actors only after service-account and machine-identity decisions are resolved.

## MVP Baseline

Practical Zero Trust baseline:

- `auth`, `identity.active`, and `auth.mfa` middleware where appropriate
- `auth.recent` for sensitive actions
- policy checks for every protected route
- view/export permission separation
- signed private exports
- audit after sensitive actions
- deny direct self-escalation
- block last Super Admin removal
- monitor denied access and export spikes
- revalidate notification action links against current access
- scope service actors when introduced

## Test Planning

Expected future tests:

- `ZeroTrustRequestContextTest`
- `SensitiveRouteStepUpTest`
- `ElevatedAccessExpirationTest`
- `DeniedAccessAuditTest`
- `ExportRequiresRecentAuthTest`
- `SecretRevealRequiresRecentAuthTest`
- `NotificationActionRevalidatesAccessTest`
- `ServiceActorScopeTest`

## Transition Rules

- Do not create `Modules/ZeroTrust`.
- Do not create `app/Core/ZeroTrust`.
- Do not build a Zero Trust dashboard.
- Do not treat login as permanent trust.
- Do not treat MFA as authorization.
- Do not treat role assignment as unlimited scope.
- Do not let view permissions imply export permissions.
- Do not let background jobs or service actors bypass policy/audit requirements.
- Do not add risk scoring before deterministic route-security profiles, step-up rules, audit events, and monitoring baselines exist.

## Open Decisions

- Which concrete actions first consume `sensitive`?
- Which concrete actions first consume `restricted_data`?
- Which actions require MFA re-challenge instead of only recent password confirmation?
- Should `RequestSecurityContext` be introduced immediately or after route-security profiles and recent-auth rules exist?
- What is the first trust decision beyond allow/deny worth implementing?
- Which access-denied and step-up events should be audited on day one?
- Which monitoring signals should be created first?

## Out Of Scope

- implementing Zero Trust code in this pass
- changing the Zero Trust standard outside an accepted canonical-policy update
- creating risk scoring in this pass
- creating trusted-device behavior in this pass
- creating service-account/API-token behavior in this pass
- editing `/docs/08-active/`

## Related

- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)
- [Threat Modeling And Security Controls Planning](threat-modeling-security-controls-planning.md)
- [Threat-Control Traceability Matrix](threat-control-traceability-matrix.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Incident Response Planning](incident-response-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Service Accounts And Machine Identity Planning](service-accounts-machine-identity-planning.md)
