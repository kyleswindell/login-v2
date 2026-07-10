# Auth Core Implementation Planning

Status: Planning draft

## Purpose

Plan `app/Core/Auth` as the core authentication capability before Auth is moved out of root `Modules/Auth` and before Identity, Access Control, elevated access, passkeys, trusted devices, service accounts, OAuth, or SSO deepen.

This document owns sequencing and intent only. Final feature behavior, schema contracts, architecture contracts, and runbooks must be promoted to their owning docs before implementation.

## Direction

Use this split:

```text
Core/Auth
  proves identity
  owns password, MFA, session validity, recent authentication, trusted devices, recovery, and future passkeys/SSO

Core/Identity
  owns user lifecycle, invitation, provisioning, profile, status, and account state

Core/Access
  owns authorization, groups, roles, permissions, policies, effective access, and elevated access

Core/Audit
  owns auth event evidence, identity lifecycle evidence, access decision evidence, and service/module audit events
```

Core rule:

```text
Authentication proves the user is who they claim to be.
Authorization decides what that authenticated user can do.
MFA strengthens authentication, but it does not replace authorization.
```

## Current Baseline

Current implementation:

- `Modules/Auth` owns login/logout routes, MFA challenge/enrollment/step-up, account MFA routes, password policy, Auth services, MFA models, Auth views, and Auth notification types.
- Local password authentication exists.
- Progressive login flow exists.
- TOTP authenticator-app MFA exists.
- Recovery-code storage and use exist for the current baseline.
- Session-backed MFA satisfaction and separate privileged step-up satisfaction exist.
- Suspicious-auth detection is audit-only.
- OAuth, passkeys/WebAuthn, trusted devices, service accounts, and API tokens are not implemented.

Current gap:

- Auth is implemented as a root module package, but it is a core security capability.
- Current TOTP is true MFA and a good baseline, but it is not phishing-resistant MFA.
- Future design must support multiple authentication methods without hard-coding all MFA around one TOTP secret.

## Auth Owns

`app/Core/Auth` should own:

- login and logout
- local password verification and policy
- password reset tokens and recovery flows
- MFA methods
- TOTP enrollment and challenge
- recovery codes
- MFA challenge state
- trusted devices
- remember tokens
- session rotation and invalidation
- recent-authentication state
- step-up authentication
- login throttling and anti-automation checks
- authentication event audit emission
- authentication security notifications
- future WebAuthn/passkeys/security keys
- future OIDC/SSO provider authentication
- future service account authentication and API tokens, if approved

Auth should not own:

- user lifecycle or provisioning
- role assignment
- permissions
- access policies
- effective access decisions
- business module authorization
- data classification, masking, redaction, export, retention, or erasure policy

DataProtection classifies Auth-owned secrets and tokens as restricted data and defines cross-cutting handling rules for encryption, hashing, redaction, export exclusion, and retention. Auth owns the mechanics and validation of authentication factors.

Secrets Management defines credential-specific storage, redaction, one-time display, reveal/copy, rotation, and leak-prevention expectations for Auth-owned secrets. Auth still owns password, MFA, recovery, session, and token mechanics.

Application Security provides route-tier, request-redaction, security-header, and release-check guardrails that Auth routes and flows must satisfy. Auth still owns authentication mechanics.

## Auth Factor Model

Initial factor classification:

```text
password
  knowledge factor

TOTP authenticator app
  possession factor

password + TOTP
  true MFA
```

Current TOTP classification:

```text
Stronger than password-only
True MFA
Good MVP baseline
Appropriate for current local platform accounts
Not phishing-resistant
Must be wrapped with session, audit, recovery, notification, and risk controls
Must leave room for WebAuthn/passkeys/security keys later
```

Future phishing-resistant factor direction:

```text
WebAuthn/passkeys/security keys
  public-key authentication
  origin-bound challenge signing
  required later for Super Admin or elevated access if approved
```

## Target Structure

```text
app/Core/Auth/
  Actions/
    AttemptLogin.php
    CompleteLogin.php
    LogoutUser.php
    StartPasswordReset.php
    CompletePasswordReset.php
    ChangePassword.php
    EnrollTotpMethod.php
    ConfirmTotpMethod.php
    DisableMfaMethod.php
    VerifyMfaChallenge.php
    GenerateRecoveryCodes.php
    RevokeRememberTokens.php
  Data/
    LoginAttemptData.php
    LoginResult.php
    MfaChallengeResult.php
    PasswordResetData.php
    RecentAuthenticationState.php
  Enums/
    AuthEventType.php
    AuthFactorType.php
    LoginResultStatus.php
    MfaMethodType.php
    MfaChallengeStatus.php
  Events/
    LoginAttempted.php
    LoginSucceeded.php
    LoginFailed.php
    UserLoggedOut.php
    PasswordChanged.php
    PasswordResetCompleted.php
    MfaMethodEnrolled.php
    MfaChallengePassed.php
    MfaChallengeFailed.php
  Http/
    Controllers/
    Middleware/
    Requests/
  Models/
    MfaMethod.php
    MfaChallenge.php
    RecoveryCode.php
    TrustedDevice.php
    PasswordResetRequest.php
  Notifications/
  Policies/
  Services/
    LoginService.php
    PasswordService.php
    MfaService.php
    TotpService.php
    RecoveryCodeService.php
    TrustedDeviceService.php
    RecentAuthenticationService.php
    SessionHardeningService.php
    LoginRiskService.php
  Support/
  Routes/
    auth.php
```

Folder names are target structure, not immediate implementation requirements.

## Login Flow Direction

Target runtime flow:

```text
POST /login
  validate login input
  rate-limit by identifier and IP
  resolve user by allowed identifier
  ask Identity for lifecycle state
  block inactive/non-loginable states
  verify password
  rotate session ID
  determine MFA requirement
  if MFA required, create pending MFA challenge
  redirect to MFA challenge
  verify TOTP or recovery code
  mark MFA satisfied in session
  record audit event
  send security notification when appropriate
  redirect to intended page
```

Session state should distinguish:

```text
authenticated_user_id
mfa_satisfied_at
recent_auth_at
elevated_auth_until
```

Do not treat "password accepted" as "fully signed in" when MFA is required.

## Required Middleware Boundaries

Target middleware vocabulary:

```text
auth
  Laravel authenticated user exists

identity.active
  user lifecycle status permits sign-in and app use

auth.mfa
  required MFA is satisfied for the current session

auth.password_current
  password is not expired and no forced reset is pending

auth.recent
  user recently re-authenticated for sensitive action

access.elevated
  elevated session is active for high-risk workflows
```

Auth owns authentication middleware and recent-authentication state. Access owns elevated authorization semantics and may depend on Auth step-up.

## Identity Dependency

Auth depends on Identity for user lifecycle state.

Auth should block normal login for:

```text
invited
suspended
deactivated
pending_deletion
deleted
locked_until not expired
force_password_reset, except reset flow
```

Example split:

```text
Invite user
  Identity

Accept invitation
  Identity plus Auth password/MFA setup

Change password
  Auth

Suspend user
  Identity plus Auth session revocation

Deactivate user
  Identity plus Access/Auth revocation

Reset MFA
  Auth, initiated from Identity admin UI

View user security posture
  Identity reads Auth summary
```

## Access Dependency

Authorization must be checked after authentication succeeds.

Runtime flow:

```text
Request comes in
  Laravel session resolves user
  Core/Auth confirms authentication
  Core/Identity confirms user status is active
  Core/Auth confirms MFA challenge is satisfied when required
  Controller/policy asks Core/Access for authorization
  Core/Access checks effective access
  Core/Audit records sensitive success or denial events
```

MFA does not grant permission. It only increases assurance that the actor is the account holder.

## MFA Roadmap

### Phase 1 Baseline

- password plus local TOTP
- one-time recovery codes stored as hashes
- session revocation support
- recent-authentication middleware

### Phase 2 Hardening

- trusted devices
- administrator-enforced MFA policy
- login risk signals
- security notifications
- self-service recovery-code regeneration after baseline recovery behavior stabilizes

### Phase 3 Phishing-Resistant MFA

- WebAuthn/passkeys
- hardware security keys
- require phishing-resistant MFA for Super Admin and elevated access if approved

### Phase 4 Federation And Machine Identity

- OIDC/SSO if needed
- service account authentication
- API tokens or machine identity if needed

## High-Priority Additions Around Existing MFA

### Recovery Codes

Current recovery-code baseline exists and should remain a first-class Auth concern.

Target rules:

- generate after successful MFA enrollment
- show plaintext once
- store only hashes
- allow one-time use
- audit use
- notify user after use
- support self-service regeneration only behind recent authentication

### Recent Authentication

Require recent authentication before sensitive actions:

- change password
- change email
- disable MFA
- generate recovery codes
- activate elevated access
- assign Super Admin
- delete, suspend, or deactivate users
- export sensitive data

### MFA Enforcement Policy

Move toward policy-driven MFA:

```text
optional
required for all users
required for admins
required for elevated access
future phishing-resistant requirement for Super Admin
```

### Security Notifications

Auth should emit durable security notifications for:

- new login where appropriate
- new device where trusted-device support exists
- password changed
- MFA enabled
- MFA disabled
- recovery code used
- failed MFA threshold reached
- account locked

### Audit Events

Auth should emit audit events for:

```text
auth.login_succeeded
auth.login_failed
auth.logout
auth.password_changed
auth.password_reset_requested
auth.password_reset_completed
auth.mfa_enabled
auth.mfa_disabled
auth.mfa_challenge_passed
auth.mfa_challenge_failed
auth.recovery_code_used
auth.trusted_device_added
auth.trusted_device_revoked
```

## Data Direction

Canonical schema belongs in future `docs/06-database/` contracts.

Current tables should remain compatible until a migration plan exists:

- `user_mfa_methods`
- `user_mfa_policies`
- `mfa_recovery_codes`
- `password_reset_tokens`
- `sessions`

Future Auth data model should support:

```text
mfa_methods
  user_id
  type: totp | webauthn | recovery_code | backup_code
  name
  secret_encrypted
  public_key
  credential_id
  transports
  last_used_at
  confirmed_at
  disabled_at

mfa_challenges
  user_id
  method_id
  type
  status
  ip_address
  user_agent
  passed_at
  failed_at
  expires_at

recovery_codes
  user_id
  code_hash
  used_at

trusted_devices
  user_id
  device_hash
  name
  ip_address
  user_agent
  last_used_at
  expires_at
  revoked_at
```

Do not create a separate `auth_events` table unless a future schema decision proves it is needed. Auth events should write through Core/Audit.

DataProtection alignment:

- TOTP secrets, provider credentials, OAuth refresh tokens, service account secrets, and integration credentials are restricted data and should be encrypted if the app must read them later.
- Passwords, recovery codes, invitation tokens, password reset tokens, and one-time verification tokens should be hashed when the app only needs verification.
- Auth secret values must be excluded from generic exports and logs.
- Auth audit metadata should store event context and safe labels, not raw submitted factors or reusable secrets.
- Retention rules should prune temporary Auth data such as password reset tokens, pending challenges, expired trusted devices, and expired sessions without damaging audit evidence.

Secrets Management alignment:

- recovery codes and generated API tokens should use one-time display patterns where possible.
- generated reusable tokens should store a prefix/fingerprint and hash rather than a retrievable raw value when the app only needs verification.
- TOTP and integration credentials must use encrypted storage or vault references when the app must read them later.
- Auth secret leak checks should prevent raw passwords, TOTP secrets, recovery codes, reset tokens, authorization headers, and cookies from entering Audit, Monitoring, Notifications, support views, or export flows.

## Implementation Sequence

### 1. Architecture Alignment

- Promote Auth planning from root `Modules/Auth` to `app/Core/Auth`.
- Document Auth vs Identity vs Access boundaries.
- Keep route and URL compatibility.

### 2. Core/Auth Package Boundary

- Introduce `app/Core/Auth` namespace and target route/service/action boundaries.
- Move behavior in scoped slices rather than one broad rename.
- Keep current `Modules/Auth` compatibility until tests protect the migration.

### 3. Existing MFA Hardening Completion

- Confirm targeted Docker validation for TOTP throttling, pending setup expiry, reset cleanup, and audit secret-safety.
- Keep recovery codes first-class.
- Plan self-service recovery-code regeneration behind recent authentication.

### 4. Recent Authentication Expansion

- Standardize `auth.recent`.
- Apply to password, email, MFA disable/regenerate, elevated access activation, sensitive user administration, and sensitive export surfaces.
- Align first recent-auth and MFA step-up targets with [Zero Trust Security Planning](zero-trust-security-planning.md).

### 5. Policy-Driven MFA

- Promote MFA requirement evaluation behind an Auth-owned assurance policy boundary.
- Add admin/elevated access MFA policy inputs.
- Keep room for future tenant/provider assurance inputs.

### 6. WebAuthn/Passkey Readiness

- Refactor data/contracts so methods are typed and not hard-coded to TOTP only.
- Do not implement passkeys until the baseline local MFA and admin recovery flows are stable.

### 7. Future Federation And Machine Identity

- Plan OIDC/SSO after customer/tenant access policy is stable.
- Plan service accounts/API tokens only after Access and Audit can govern non-human actors.
- Track service-account and machine-identity scope in [Service Accounts And Machine Identity Planning](service-accounts-machine-identity-planning.md).
- Track API token, webhook, and machine-access security in [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md).

## Test Planning

Expected tests:

- Auth remains separate from Identity user lifecycle mutations
- inactive/suspended/deactivated users cannot complete login
- password verification does not create full session when MFA is required
- MFA challenge satisfaction is session-backed
- login-time MFA does not satisfy recent-auth requirements
- recovery codes are shown once, stored hashed, and single-use
- recent authentication gates sensitive actions
- Auth emits audit events through Core/Audit
- Auth emits security notifications through Core/Notifications
- no secrets, TOTP codes, recovery codes, passwords, raw tokens, or provider secret payloads are stored in audit metadata
- Auth restricted data is excluded from generic export flows and classified through DataProtection metadata when that capability exists
- future typed MFA method contracts can represent TOTP and WebAuthn without schema redesign

## Transition Rules

- Do not treat Auth as a business module.
- Do not put user lifecycle/provisioning in Auth.
- Do not put authorization decisions in Auth.
- Do not hard-code all future MFA around a single `totp_secret` on `users`.
- Do not treat successful password verification as full authentication when MFA is required.
- Do not store reusable secrets or submitted auth factors in audit logs.
- Do not expose Auth secrets through generic data export or support-view paths.
- Do not assume federated sign-in grants authorization.
- Do not implement passkeys before current MFA recovery, recent-authentication, audit, and notification behavior are stable.

## Open Decisions

- What should be the first implementation slice for moving `Modules/Auth` into `app/Core/Auth`?
- Should current `user_mfa_methods` be evolved in place or replaced by a generalized `mfa_methods` table later?
- Which roles or permissions require MFA immediately?
- Which actions require `auth.recent` in the first expansion?
- When should self-service recovery-code regeneration be enabled?
- What is the first phishing-resistant MFA requirement: Super Admin, elevated access, or both?
- Should trusted devices be added before WebAuthn/passkeys?
- Which OIDC/SSO providers should be planned first after local Auth stabilizes?

## Out Of Scope

- implementing Auth changes in this pass
- moving `Modules/Auth` in this pass
- implementing WebAuthn/passkeys in this pass
- implementing OIDC/SSO in this pass
- adding service account/API token authentication in this pass
- editing `/docs/08-active/`

## Related

- [Core Capability Package Migration Planning](core-capability-package-migration-planning.md)
- [Zero Trust Security Planning](zero-trust-security-planning.md)
- [MFA Implementation Planning](mfa-implementation-planning.md)
- [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Service Accounts And Machine Identity Planning](service-accounts-machine-identity-planning.md)
- [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Authentication](../04-features/auth/authentication.md)
- [Auth And RBAC Data Contract](../06-database/feature-contracts/auth-and-rbac.md)
- [MFA Enrollment And Challenge Flow](../05-flows/mfa-enrollment-and-challenge-flow.md)
