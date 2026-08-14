<!--
DOC-META
title: Core Auth Software Design
doc_type: design
status: draft
owner: core
canonical: false
canonical_path: docs/08-design/core/auth/software-design.md
parent: docs/08-design/index.md
template: docs/09-reference/templates/docs/_design.md
summary: Defines the target implementation design for Core Auth local password authentication, temporary credentials, password recovery, TOTP MFA, recovery codes, sessions, authentication assurance, recent authentication, throttling, and cross-owner authentication Contracts.
-->

# Core Auth Software Design

Parent: [Software Design Index](../../index.md)

## 1. System Definition

### Purpose

Core Auth owns the mechanisms that prove a human User Account's identity and establish, maintain, strengthen, and revoke its authenticated application session.

Target owner:

```text
app/Core/Auth/
App\Core\Auth\
owner_key: auth
```

Core Auth owns:

* local password credentials and verification;
* temporary-password establishment and required replacement;
* password policy enforcement and password hashing;
* breached-password validation;
* password-reset token lifecycle and recovery;
* TOTP MFA enrollment and verification;
* MFA recovery codes;
* authentication requirement state;
* pending login state;
* fully authenticated browser sessions;
* authentication assurance;
* recent authentication and step-up authentication;
* Auth-owned session invalidation;
* login, password, MFA, and recovery throttling;
* Auth-owned Audit event semantics;
* Auth-owned completed Events;
* Auth-owned browser Delivery Adapters.

Core Auth does not own:

* human User Account identity, name, primary email, profile, activation, suspension, deactivation, or Invitations;
* roles, permissions, groups, grants, authorization policy, administrative authority, or elevated-access authorization;
* route-security profile definitions;
* generic credential protection, secret-redaction policy, or secret-storage strategy;
* Audit persistence;
* Monitoring persistence or Signals;
* Notification delivery;
* data classification, masking, export, retention, or erasure;
* reusable UI;
* Non-Human Identity or Service Accounts;
* API-token authentication;
* provider-specific OAuth/OIDC/SSO;
* WebAuthn/passkeys/security keys in the initial implementation.

Those responsibilities remain with Users, Access, Security, Security/Secrets, Audit, Monitoring, Notifications, DataProtection, UI, and future accepted owners respectively.

### Authentication Principle

```text
Users
    → identifies the human User Account
    → owns whether the account may participate

Auth
    → proves control of accepted authentication factors
    → establishes authentication assurance

Access
    → decides what the authenticated Principal may do
```

Authentication does not grant authorization.

MFA increases authentication assurance but does not grant permission.

### Initial Authentication Methods

The initial target supports:

```text
password
    knowledge factor

TOTP authenticator application
    possession factor

recovery code
    one-time recovery factor for a normal MFA challenge
```

The initial normal fully authenticated local User therefore uses:

```text
password
    +
TOTP
```

where MFA enrollment is required by the User's Auth requirement state.

TOTP is accepted as the initial MFA mechanism but is not treated as phishing-resistant authentication.

Recovery codes are accepted for normal MFA recovery/challenge behavior but are not accepted for recent-authentication step-up.

### Initial Scope

The initial Core Auth implementation includes:

* local human browser authentication;
* progressive identifier/password login;
* temporary password replacement;
* mandatory initial MFA enrollment where required;
* TOTP challenge;
* recovery-code fallback for normal MFA challenge;
* password reset;
* database-backed Laravel sessions;
* session revocation;
* authentication assurance;
* recent authentication;
* Security profile middleware integration;
* Auth Audit production;
* Auth Monitoring integration for unexpected failures;
* Auth security Notification requirements;
* Security/Secrets integration.

### Explicit Deferrals

Do not implement initially:

```text
WebAuthn
passkeys
hardware security keys
OIDC
SSO
social login
API tokens
service-account authentication
Non-Human Identity authentication
trusted-device bypass
risk-based automatic lockout
remember-me persistent login
phishing-resistant assurance tiers
```

The initial schema and public Contracts must not prevent those later extensions, but speculative columns or abstractions are not created solely for them.

### Greenfield Rule

Current `Modules/Auth` implementation is reference evidence only.

It imposes no target requirement for:

* package structure;
* namespace;
* Services;
* classes;
* routes;
* database schema;
* package dependencies;
* logging design;
* compatibility preservation.

The target system is designed from accepted architecture, standards, planning, Users, and the reconciled foundation.

---

## 2. Governing Requirements

Primary authority:

* `docs/07-planning/00-overview/m1-core-system-development-register.md`
* `docs/07-planning/02-core-capabilities/users/users-development-planning.md`
* `docs/08-design/core/users/software-design.md`
* `docs/02-standards/security/Identity And Account Security Standards.md`
* `docs/02-standards/security/Transport Session And Browser Security Standards.md`
* `docs/02-standards/security/Zero Trust Security Standards.md`
* `docs/02-standards/security/Secrets Management Standards.md`
* `docs/03-architecture/persistent-data-architecture.md`
* `docs/03-architecture/public-contract-and-interaction-model.md`
* `docs/03-architecture/application-registration.md`
* `docs/02-standards/database/Schema Design Standards.md`
* `docs/02-standards/coding/Application Actions Services And Data Objects Standards.md`
* `docs/02-standards/coding/Transaction Concurrency And Idempotency Standards.md`
* `docs/08-design/foundation/core-runtime/software-design.md`
* `docs/08-design/foundation/application-registration/software-design.md`
* `docs/08-design/core/security/software-design.md`
* `docs/08-design/core/security/secrets/software-design.md`
* `docs/08-design/core/audit/software-design.md`
* `docs/08-design/core/monitoring/software-design.md`

### Human Account Owner

Older planning references to a separate Core Identity lifecycle owner are superseded.

The target is:

```text
Core Users
    → human User Account
    → primary email
    → active / inactive state
    → suspension state
    → Invitations

Core Auth
    → authentication credentials
    → factors
    → recovery
    → sessions
    → assurance
```

Core Auth consumes Users-owned public Contracts and does not create a separate Identity capability.

---

## 3. Component Design

### Public Contracts

Core Auth exposes:

| Contract                                | Purpose                                                                           | Primary Consumers                                |
| --------------------------------------- | --------------------------------------------------------------------------------- | ------------------------------------------------ |
| `EstablishTemporaryPasswordInterface`   | Establish a new User's initial temporary password and Auth requirements           | Users                                            |
| `EstablishInitialPasswordInterface`     | Establish a User-selected initial permanent password during Invitation acceptance | Users                                            |
| `ResetUserToTemporaryPasswordInterface` | Reset an existing User to a temporary password                                    | Users                                            |
| `RevokeUserSessionsInterface`           | Revoke Auth sessions for one User                                                 | Users, Security                                  |
| `ResetUserMfaInterface`                 | Reset current MFA material and require re-enrollment                              | Users                                            |
| `GetAuthenticationAssuranceInterface`   | Resolve current authenticated-session assurance                                   | Access, DataProtection, sensitive Core consumers |

Target:

```text
app/Core/Auth/Contracts/
```

No public Contract exposes:

* Auth Models;
* password hashes;
* TOTP ciphertext;
* recovery-code hashes;
* reset-token hashes;
* Laravel session payloads;
* internal pending-login state;
* Laravel Guard internals.

### Actions

Initial mutation/operation Actions:

```text
BeginLoginAction
VerifyLoginPasswordAction
CompleteLoginAction
LogoutAction

EstablishTemporaryPasswordAction
EstablishInitialPasswordAction
ResetUserToTemporaryPasswordAction
ChangePasswordAction

RequestPasswordResetAction
CompletePasswordResetAction

BeginTotpEnrollmentAction
ConfirmTotpEnrollmentAction
VerifyMfaChallengeAction
RegenerateRecoveryCodesAction
ResetUserMfaAction

CompleteRecentAuthenticationAction
RevokeUserSessionsAction
```

Target:

```text
app/Core/Auth/Actions/
```

Each Action owns one primary operation.

Do not create broad grouping abstractions such as:

```text
AuthService
AuthenticationService
MfaService
PasswordService
LoginService
AuthManager
```

merely to collect behavior.

### Data Objects

Required Data Objects include:

```text
EstablishTemporaryPasswordData
TemporaryPasswordResult

EstablishInitialPasswordData
ResetUserToTemporaryPasswordData
RevokeUserSessionsData
ResetUserMfaData

PendingAuthenticationState
LoginProgressResult

TotpEnrollmentResult
RecoveryCodesResult

AuthenticationAssuranceSnapshot
```

Target:

```text
app/Core/Auth/Data/
```

### Enums

Initial enums:

```text
PendingAuthenticationStage
MfaMethodType
MfaChallengeMethod
SessionRevocationReason
```

Target:

```text
app/Core/Auth/Enums/
```

`MfaMethodType` initially contains:

```text
totp
```

`MfaChallengeMethod` initially contains:

```text
totp
recovery_code
```

Future factor types require accepted design rather than speculative enum values.

### Persistence Models

Core Auth initially owns:

```text
UserPasswordCredential
UserAuthenticationRequirement
UserMfaMethod
MfaRecoveryCode
PasswordResetToken
```

Target:

```text
app/Core/Auth/Models/
```

Laravel's database session storage remains framework-backed Auth persistence and does not require an Eloquent `Session` Model merely for symmetry.

### Laravel Authentication Integration

Core Auth owns narrow Laravel integration:

```text
LaravelAuthUserProvider
SessionAuthenticatable
```

Target:

```text
app/Core/Auth/Laravel/
```

`LaravelAuthUserProvider` implements the Laravel user-provider boundary required by the web session guard.

`SessionAuthenticatable` is an Auth-owned Laravel adapter representing the minimum authenticated identity required by the framework.

It is not the authoritative User Account Model.

### MFA Implementation

Target components:

```text
TotpAuthenticator
TotpProvisioningUriBuilder
```

Target:

```text
app/Core/Auth/Mfa/
```

`TotpAuthenticator`:

* generates TOTP secrets;
* verifies TOTP codes;
* applies the accepted verification window;
* delegates to an approved standards-compliant implementation;
* does not implement custom cryptographic primitives.

The concrete TOTP package is an implementation dependency selection, not Auth system architecture.

If implementation requires introducing a new direct dependency, that dependency still requires normal repository approval.

### Password Components

Target:

```text
PasswordValidator
TemporaryPasswordGenerator
BreachedPasswordCheckerInterface
```

under:

```text
app/Core/Auth/Password/
```

`BreachedPasswordCheckerInterface` is an internal Auth implementation boundary rather than a public cross-owner Contract.

It exposes only the minimum result needed to distinguish:

```text
not_compromised
compromised
unavailable
```

The concrete checker/provider is an implementation selection.

No raw password or full password hash may cross that provider boundary.

### Session Components

Target:

```text
PendingAuthenticationStore
AuthenticationAssuranceResolver
UserSessionRevoker
```

Paths:

```text
app/Core/Auth/Session/PendingAuthenticationStore.php
app/Core/Auth/Resolvers/AuthenticationAssuranceResolver.php
app/Core/Auth/Session/UserSessionRevoker.php
```

### Rate Limiting

Target:

```text
LoginAttemptLimiter
MfaAttemptLimiter
PasswordResetAttemptLimiter
RecentAuthenticationAttemptLimiter
```

under:

```text
app/Core/Auth/RateLimiting/
```

All use Laravel's native rate-limiting infrastructure.

Auth does not create another general rate-limiting framework.

### Middleware

Auth-owned middleware:

```text
EnsureLoginableAccountMiddleware
RequireMfaAssuranceMiddleware
RequireRecentAuthenticationMiddleware
RequirePendingAuthenticationMiddleware
```

Target:

```text
app/Core/Auth/Http/Middleware/
```

Canonical aliases:

```text
auth.loginable
auth.mfa
auth.recent
auth.pending
```

Laravel's normal:

```text
auth
guest
```

middleware remains the authenticated/guest session boundary.

### Provider And Registration

Create:

```text
app/Core/Auth/Providers/AuthServiceProvider.php
```

`AuthServiceProvider` implements `RegistrationDescriptorInterface`.

It is Auth's single owner registration declaration and owns:

* Auth public Contract bindings;
* Laravel custom User Provider integration;
* Auth middleware aliases;
* Auth routes;
* Auth migrations;
* Auth views;
* Auth Events/listeners where required;
* Security/Secrets Contributions;
* Auth configuration.

No separate `AuthRegistrationDescriptor` is required unless later implementation proves a distinct descriptor responsibility.

---

## 4. Contracts And Interactions

### Users Dependencies

Auth consumes:

```text
FindUserByLoginIdentifierInterface
GetUserAccountStateInterface
```

from Core Users.

Auth never imports the Users Model or queries the Users table directly.

The Users login snapshot supplies only the stable account identity and normalized login identifier required by Auth.

The account-state snapshot provides the Users-owned state required to determine:

```text
active
suspended
```

Auth permits normal authentication only when:

```text
active = true
suspended = false
```

Primary-email verification is not a loginability condition.

### Establish Temporary Password

```php
interface EstablishTemporaryPasswordInterface
{
    public function establish(
        EstablishTemporaryPasswordData $data,
    ): TemporaryPasswordResult;
}
```

Input:

```text
userAccountId
optional suppliedPassword: SecretValue
```

Behavior:

1. reject if a password credential already exists;
2. if a human supplied the password, validate normal password policy and breached-password policy;
3. if Auth generates the password, generate a high-entropy temporary value and do not perform breached-human-password checking;
4. persist only the password hash;
5. establish the User's Auth requirement state;
6. set password replacement required;
7. set MFA enrollment required;
8. return plaintext only through a transient `TemporaryPasswordResult`.

Generated temporary passwords are never persisted raw.

### Establish Initial Permanent Password

```php
interface EstablishInitialPasswordInterface
{
    public function establish(
        EstablishInitialPasswordData $data,
    ): void;
}
```

Input:

```text
userAccountId
password: SecretValue
```

Behavior:

1. reject if a password credential already exists;
2. apply the full human-supplied password policy;
3. require the password to pass breached-password checking;
4. persist only the hash;
5. create Auth requirement state;
6. do not require password replacement;
7. require MFA enrollment.

This is the synchronous Auth interaction used during Users-owned Invitation acceptance.

### Cross-Owner Transaction Participation

Direct User creation and Invitation acceptance are Users-owned logical mutations.

Required Users state and initial Auth credential must succeed or fail together.

```text
Users Action
    ↓
Users opens PostgreSQL transaction
    ↓
Users creates/locks required Users state
    ↓
Auth initial-credential Contract
    ↓
Auth writes Auth-owned rows inside the existing transaction
    ↓
Users completes Users-owned state
    ↓
Users commits
```

For:

```text
EstablishTemporaryPasswordInterface
EstablishInitialPasswordInterface
```

Auth:

* participates in the active same-database transaction;
* does not independently commit it;
* throws/rejects on credential failure;
* does not dispatch success Events, Audit evidence, or Notifications before the Users transaction commits.

Users remains transaction owner for User creation and Invitation acceptance.

Standalone Auth operations own their own transactions.

### Reset Existing User To Temporary Password

```php
interface ResetUserToTemporaryPasswordInterface
{
    public function reset(
        ResetUserToTemporaryPasswordData $data,
    ): TemporaryPasswordResult;
}
```

Behavior:

1. lock target Auth requirement state;
2. validate a human-supplied temporary password or generate a high-entropy one;
3. apply breached-password checking only when a human supplied the password;
4. replace the password hash;
5. set password replacement required;
6. leave existing MFA method state unchanged;
7. invalidate active password-reset tokens;
8. revoke all existing authenticated sessions;
9. commit;
10. record safe Audit evidence;
11. return generated plaintext once when Auth generated it.

Administrator password reset does not automatically reset MFA.

### Revoke User Sessions

```php
interface RevokeUserSessionsInterface
{
    public function revoke(
        RevokeUserSessionsData $data,
    ): void;
}
```

Initial reasons:

```text
user_deactivated
user_suspended
password_reset
password_changed
mfa_reset
security_response
administrator_request
```

Auth owns session invalidation.

The caller owns authorization for the higher-level operation.

### Reset User MFA

```php
interface ResetUserMfaInterface
{
    public function reset(
        ResetUserMfaData $data,
    ): void;
}
```

Behavior:

1. lock target Auth state;
2. invalidate current TOTP enrollment;
3. invalidate recovery codes;
4. require MFA re-enrollment;
5. revoke authenticated sessions;
6. invalidate current recent-authentication state;
7. commit;
8. record safe Audit evidence;
9. request required security Notification when Notifications is available.

### Authentication Assurance Contract

```php
interface GetAuthenticationAssuranceInterface
{
    public function current(): AuthenticationAssuranceSnapshot;
}
```

The snapshot contains:

```text
userAccountId
fullyAuthenticated
mfaRequired
mfaSatisfied
mfaSatisfiedAt nullable
recentAuthenticationSatisfied
recentAuthenticatedAt nullable
```

It contains no:

* password material;
* factor secret;
* recovery material;
* permission;
* role;
* administrative-authority state;
* DataProtection classification.

Consumers do not calculate assurance freshness independently.

### Registration Dependency Semantics

Runtime public Contract dependencies and Application Registration ordering dependencies are different graphs.

The Auth/Users runtime relationship is legitimately bidirectional:

```text
Auth
    → Users login/account-state Contracts

Users
    → Auth credential/session Contracts
```

This does not create a registration dependency cycle.

Owner descriptor `dependencies` are declared only when registration/composition ordering actually requires one owner to be registered before another.

Bindings must not eagerly resolve runtime collaborators merely to manufacture ordering.

---

## 5. Authentication Flow

### Laravel Session Boundary

The web guard remains Laravel's normal session-based authentication mechanism.

Core Auth supplies the required user-provider adapter.

```text
Laravel session guard
    ↓
LaravelAuthUserProvider
    ↓
Users public Contracts
    +
Auth credential state
    ↓
SessionAuthenticatable
```

`SessionAuthenticatable` contains only framework-required authentication identity/credential behavior.

It must not become a second Users Model.

### Password Verification Does Not Complete Login

Password acceptance is not equivalent to completed login when further requirements remain.

The flow is:

```text
password verification
    ↓
Auth resolves remaining authentication requirements
    ↓
pending Auth state
    ↓
required password replacement / MFA enrollment / MFA challenge
    ↓
CompleteLoginAction
    ↓
fully authenticated Laravel session
```

Only `CompleteLoginAction` establishes the full authenticated session.

### Progressive Login

Identifier stage:

```text
GET /login
    ↓
POST identifier
    ↓
normalize identifier
    ↓
store bounded pending identifier state
    ↓
show password stage
```

The identifier stage does not disclose User existence.

Password stage:

```text
pending identifier
    ↓
Users login lookup
    ↓
Users account-state lookup
    ↓
password verification
    ↓
remaining Auth requirement resolution
```

Unknown identifiers and invalid credentials use enumeration-resistant external behavior.

Where required to avoid material timing distinction, Auth performs a timing-safe dummy password verification path for unknown Users.

### Pending Authentication State

Pending state is server-side session state, not a fully authenticated Principal.

It contains:

```text
normalizedLoginIdentifier
userAccountId nullable
stage
startedAt
expiresAt
```

It must never contain:

```text
raw password
password hash
TOTP secret
submitted TOTP
recovery code
reset token
roles
permissions
```

Initial stages:

```text
password_required
password_change_required
mfa_enrollment_required
mfa_challenge_required
```

Pending authentication expires after a bounded configured duration.

The initial design uses:

```text
15 minutes
```

for pending login/enrollment progression unless a narrower enrollment-specific lifetime is established in the database Contract.

### Requirement Resolution

After valid password verification:

```text
account inactive or suspended
    → reject login

password replacement required
    → password_change_required

MFA enrollment required
    → mfa_enrollment_required

confirmed TOTP exists
    → mfa_challenge_required

otherwise, when MFA is not required
    → complete login
```

An inconsistent state that would silently bypass required MFA fails closed.

### Direct-Created User First Login

```text
temporary password accepted
    ↓
required permanent password replacement
    ↓
MFA enrollment
    ↓
TOTP confirmation
    ↓
recovery codes shown once
    ↓
full authenticated session
```

### Invitation-Accepted User First Login

```text
permanent password already established
    ↓
MFA enrollment
    ↓
TOTP confirmation
    ↓
recovery codes shown once
    ↓
full authenticated session
```

---

## 6. Passwords And Recovery

### Password Policy

Human-supplied local passwords must:

* contain at least 12 characters;
* accept at least 64 characters;
* avoid arbitrary composition requirements;
* reject approved common/context-specific passwords;
* pass breached-password checking in production.

Auth-generated high-entropy temporary passwords are exempt from breached-human-password checking.

Password hashing uses an approved memory-hard framework-supported password hasher.

The exact hash driver/cost configuration is an implementation/configuration choice governed by accepted security standards and environment policy.

### Breached-Password Checking

Production behavior is:

```text
human-supplied password
    ↓
normal password validation
    ↓
BreachedPasswordCheckerInterface
    ├── not_compromised → continue
    ├── compromised     → reject
    └── unavailable     → reject / fail closed
```

Apply breached-password checking to:

* Invitation-acceptance passwords;
* required first-login permanent password replacement;
* self-service password changes;
* password reset;
* administrator-supplied temporary passwords.

Do not perform breached-password lookup:

* during ordinary login verification;
* for Auth-generated high-entropy temporary passwords.

No raw password or complete password hash may be sent to the checker/provider.

### Password Reset Request

`RequestPasswordResetAction`:

1. applies identifier/network throttling;
2. returns enumeration-resistant public behavior;
3. resolves the User internally;
4. does not issue a usable reset for a non-loginable User;
5. revokes any prior usable reset token;
6. generates a high-entropy token;
7. persists only its one-way token hash;
8. sets expiry to 30 minutes;
9. commits;
10. requests secret-safe reset delivery through Notifications.

Public response behavior does not reveal:

* whether a User exists;
* whether the User is active;
* whether the User is suspended;
* whether a token was created;
* whether email delivery was attempted.

### Password Reset Token Rules

```text
lifetime:
    30 minutes

usable tokens per User:
    at most one

new request:
    revokes prior usable token

successful use:
    marks token consumed

reuse:
    prohibited
```

### Password Reset Completion

`CompletePasswordResetAction`:

1. hashes the submitted token for lookup;
2. locks the reset-token row;
3. rejects unknown, expired, used, or revoked tokens;
4. locks target Auth requirement state;
5. rechecks Users account state;
6. validates the new password;
7. enforces breached-password checking;
8. replaces the password hash;
9. clears password-change requirement;
10. consumes the reset token;
11. revokes any other reset tokens;
12. commits;
13. revokes all authenticated sessions;
14. records safe Audit evidence;
15. requests required security Notification.

Password reset does not reset MFA.

The User must satisfy normal MFA on the next login.

---

## 7. MFA And Recent Authentication

### TOTP Storage And Exposure

TOTP uses:

```text
storage_kind:
    encrypted_owner_storage

exposure_policy:
    one_time
```

Meaning:

* Auth persists encrypted TOTP ciphertext;
* Auth may decrypt it internally when required to verify TOTP;
* the User may receive the raw provisioning secret only during the active enrollment flow;
* after enrollment is confirmed, no normal application route may reveal or copy the raw TOTP secret.

`one_time` controls user-facing/raw-output exposure, not the owning Auth capability's internal cryptographic use.

### TOTP Enrollment

`BeginTotpEnrollmentAction`:

1. requires the applicable pending/login or protected enrollment context;
2. generates a TOTP secret;
3. immediately encrypts it through `SecretCipherInterface`;
4. persists ciphertext only;
5. records the enrollment expiry;
6. returns provisioning material transiently.

`TotpEnrollmentResult` contains:

```text
manualSecret: SecretValue
provisioningUri: SecretValue
expiresAt
```

The provisioning URI is secret-bearing because it embeds the TOTP secret.

Enrollment responses use no-store browser handling.

Expired or abandoned unconfirmed enrollment material is invalidated and a new secret is generated for a later enrollment.

### TOTP Confirmation

`ConfirmTotpEnrollmentAction`:

1. validates enrollment state;
2. locks Auth requirement and method state;
3. rejects expired enrollment;
4. decrypts the stored TOTP secret internally;
5. verifies the submitted TOTP;
6. marks the method confirmed;
7. clears enrollment expiry;
8. clears MFA enrollment requirement;
9. generates recovery codes;
10. persists only recovery-code hashes;
11. commits;
12. returns recovery-code plaintext once;
13. records safe Audit evidence.

### Recovery Codes

Initial recovery-code set:

```text
10 codes
```

Each code is:

* generated from cryptographically secure randomness;
* displayed once;
* stored only as a password-style hash;
* single-use.

Recovery-code verification:

1. locks applicable unused recovery-code rows;
2. checks the submitted normalized code;
3. marks exactly one matching code used;
4. cannot allow concurrent reuse;
5. commits;
6. records safe Audit evidence.

Recovery codes may satisfy the normal MFA recovery/challenge path.

They may not satisfy recent-authentication step-up.

### Normal MFA Challenge

Normal login with confirmed MFA:

```text
password accepted
    ↓
mfa_challenge_required
    ↓
TOTP
        OR
recovery code
    ↓
MFA assurance satisfied
    ↓
CompleteLoginAction
```

Login-time MFA does not establish recent authentication.

### Recent Authentication

Recent authentication requires:

```text
current password
    +
currently enrolled confirmed TOTP
```

Recovery codes are not accepted.

Login-time MFA satisfaction is not accepted as recent-authentication evidence.

Successful recent authentication:

1. verifies the current password;
2. verifies the currently enrolled confirmed TOTP;
3. applies recent-authentication throttling;
4. regenerates the session identifier;
5. sets `recent_authenticated_at = now`;
6. does not change roles, permissions, or Access state.

### Recent-Authentication Lifetime

Recent authentication is valid for:

```text
15 minutes
```

Auth owns the freshness calculation.

Target configuration:

```text
auth.recent_auth.minutes = 15
```

Consumers do not reimplement timestamp arithmetic.

### Security Profile Integration

| Security Profile  | Auth Requirements                                                                  |
| ----------------- | ---------------------------------------------------------------------------------- |
| `public`          | none                                                                               |
| `guest`           | native `guest` where applicable                                                    |
| `authenticated`   | `auth`, `auth.loginable`                                                           |
| `protected`       | `auth`, `auth.loginable`; Access supplies authorization                            |
| `administrative`  | `auth`, `auth.loginable`, `auth.mfa`; Access supplies administrative authority     |
| `sensitive`       | `auth`, `auth.loginable`, `auth.mfa`, `auth.recent`; Access supplies authorization |
| `restricted_data` | same Auth baseline as `sensitive`; Access/DataProtection supply remaining controls |
| `service`         | no human Auth middleware; future machine-identity owner                            |

Auth does not own Security profile identity.

Auth middleware never grants Access permission.

---

## 8. Sessions, Security, And Reliability

### Completing Login

`CompleteLoginAction`:

1. requires all pending requirements satisfied;
2. rechecks Users loginable state;
3. establishes the Laravel authenticated session;
4. regenerates the session identifier;
5. records Auth assurance session state;
6. sets MFA-satisfied timestamp when applicable;
7. leaves recent-authentication timestamp unset;
8. clears pending-authentication state;
9. records `auth.login_succeeded`;
10. publishes applicable completed Auth Event.

### Authenticated Account-State Revalidation

Every human route profile requiring authentication includes:

```text
auth
auth.loginable
```

`EnsureLoginableAccountMiddleware`:

1. reads authenticated User Account ID;
2. calls `GetUserAccountStateInterface`;
3. rejects inactive/suspended state;
4. invalidates the current session;
5. clears assurance state;
6. produces safe evidence.

This fails closed even if asynchronous/bulk session revocation has not yet completed.

### Session Revocation

Auth owns database-session invalidation.

Required revocation includes:

* User suspension;
* User deactivation;
* password reset;
* administrator temporary-password reset;
* MFA reset;
* explicit security response.

Self-service password change:

* revokes other sessions;
* retains the current session;
* regenerates the current session identifier;
* clears recent-auth state after the password-change operation.

### Logout

Logout:

1. invalidates authenticated session state;
2. invalidates/regenerates session storage as required;
3. clears pending Auth state;
4. clears assurance state;
5. records safe Audit evidence.

Logout is POST.

### Enumeration Resistance

Login and password-recovery surfaces must not disclose User existence through materially different:

* messages;
* status behavior;
* redirect behavior;
* response content;
* timing;
* reset-request responses.

Safe internal Audit evidence may distinguish actual internal outcome.

### Secret Handling

Auth contributes definitions to:

```text
security.secret_definitions
```

At minimum:

```text
auth.password
auth.temporary_password
auth.totp_secret
auth.recovery_code
auth.password_reset_token
```

Storage:

| Secret               | Storage                   |
| -------------------- | ------------------------- |
| password             | `hash_only`               |
| temporary password   | `hash_only`               |
| TOTP secret          | `encrypted_owner_storage` |
| recovery code        | `hash_only`               |
| password-reset token | `hash_only`               |

Auth never persists:

```text
raw password
temporary-password plaintext
TOTP plaintext
submitted OTP
recovery-code plaintext
reset-token plaintext
authorization header
session cookie
```

### Rate Limiting

Login rate limiting uses both:

```text
normalized identifier + client network dimension
network-only dimension
```

Raw email addresses are not included in rate-limit keys.

Identifier keys use a safe one-way fingerprint suitable for rate-limit lookup.

MFA throttling is scoped to:

```text
User Account
+
network dimension
+
challenge purpose
```

Purposes include:

```text
login_challenge
login_enrollment
recent_authentication
```

Rate limiting does not create durable User lifecycle state.

### Suspicious Authentication

Initial suspicious-auth handling is evidence-first.

It must not automatically:

* suspend Users;
* lock Users;
* revoke all sessions;
* notify Users;
* alter MFA policy

without a separately accepted response policy.

### Expected Rejections

Expected Auth rejection includes:

```text
invalid credentials
inactive account
suspended account
expired pending login
expired MFA enrollment
invalid TOTP
invalid recovery code
used recovery code
expired reset token
used reset token
compromised proposed password
breached-password checker unavailable during enforced password establishment
throttled request
missing recent authentication
```

Expected rejection is not automatically an operational Monitoring failure.

Unexpected infrastructure failure may be recorded through Monitoring.

---

## 9. Events And Operational Effects

### Audit

Auth records accountable authentication facts through:

```text
RecordAuditEventInterface
```

Auth supplies:

* event key;
* Result;
* Severity;
* target when applicable;
* safe Auth evidence.

Audit supplies Runtime correlation.

### Pre-Authentication Actor Attribution

Before authentication succeeds, Auth must not falsely claim that the attempted User Account is the Actor.

For failed or rejected pre-authentication attempts:

```text
Actor Principal:
    absent

known claimed User Account:
    may be recorded as Target

unknown claimed User Account:
    Target absent
```

Do not invent Principal types such as:

```text
anonymous
guest
unknown
external
```

Do not persist the raw claimed login identifier in Audit metadata.

A known target User Account does not imply that User was the Actor.

Once authentication succeeds, the authenticated User Account may be attributed as Actor.

### Auth Audit Vocabulary

Initial events:

| Event Key                              | Result      | Default Severity |
| -------------------------------------- | ----------- | ---------------- |
| `auth.login_succeeded`                 | `succeeded` | `informational`  |
| `auth.login_failed`                    | `failed`    | `low`            |
| `auth.login_throttled`                 | `denied`    | `low`            |
| `auth.logout`                          | `succeeded` | `informational`  |
| `auth.password_changed`                | `succeeded` | `medium`         |
| `auth.password_reset_requested`        | `succeeded` | `informational`  |
| `auth.password_reset_completed`        | `succeeded` | `high`           |
| `auth.mfa_enrollment_started`          | `succeeded` | `informational`  |
| `auth.mfa_enabled`                     | `succeeded` | `medium`         |
| `auth.mfa_reset`                       | `succeeded` | `high`           |
| `auth.mfa_challenge_passed`            | `succeeded` | `informational`  |
| `auth.mfa_challenge_failed`            | `failed`    | `low`            |
| `auth.recovery_code_used`              | `succeeded` | `medium`         |
| `auth.recovery_codes_regenerated`      | `succeeded` | `medium`         |
| `auth.recent_authentication_satisfied` | `succeeded` | `informational`  |
| `auth.sessions_revoked`                | `succeeded` | `medium`         |

Context may justify a higher severity.

### Completed Auth Events

Initial completed-fact Events:

```text
LoginSucceeded
UserLoggedOut
PasswordChanged
PasswordResetCompleted
MfaEnrolled
MfaReset
RecoveryCodeUsed
UserSessionsRevoked
```

Target:

```text
app/Core/Auth/Events/
```

Events contain no raw credential or factor material.

### Monitoring

Expected bad credentials, invalid MFA, expired reset tokens, and ordinary throttling do not individually create operational Signals.

Unexpected Auth infrastructure failures may be submitted to Monitoring through its public Contract.

### Notifications

Auth owns why a security notification is required.

Notifications owns:

* durable notification state;
* delivery;
* retries;
* channels;
* recipient delivery state.

Required Auth notification semantics include applicable:

```text
password reset delivery
password changed
password reset completed
MFA enabled
MFA reset
recovery code used
recovery codes regenerated
high-risk session revocation
```

### Password-Reset Secret Delivery

Auth generates the reset token and persists only its hash.

The accepted target delivery model is:

```text
Auth generates reset token
    ↓
Auth persists only token hash + lifecycle
    ↓
Auth submits secret-bearing transient delivery request to Notifications
    ↓
Notifications immediately protects the ephemeral secret payload
    ↓
durable queue work contains delivery reference only
    ↓
Notifications decrypts only at final delivery composition
    ↓
email is sent
    ↓
ephemeral secret delivery payload is destroyed
```

Durable Notification history must never contain:

```text
raw reset token
reset URL containing the raw token
decrypted secret payload
```

The protected transient delivery payload must expire no later than the reset token:

```text
30 minutes
```

and should be removed earlier once delivery/retry no longer requires it.

The exact Notifications-owned public Contract is defined by the later Notifications SDD.

### Security / Secrets

Auth consumes:

```text
SecretCipherInterface
SecretValue
```

and contributes Auth-owned secret definitions.

Auth does not create another secret-protection framework.

### Access

Auth does not depend on Access to authenticate a User.

Access later consumes:

```text
GetAuthenticationAssuranceInterface
```

for operations requiring assurance.

### DataProtection

DataProtection later consumes Auth assurance for restricted operations and classifies Auth-owned sensitive persistence.

Ownership of Auth credential mechanics remains with Auth.

---

## 10. Data And Persistence

### Initial Tables

Core Auth initially requires:

```text
user_password_credentials
user_authentication_requirements
user_mfa_methods
mfa_recovery_codes
password_reset_tokens
sessions
```

Do not add automatic owner prefixes solely because the tables belong to Auth.

### `user_password_credentials`

Required concepts:

```text
user_id
password_hash
password_changed_at
created_at
updated_at
```

Rules:

* one row per local-password User;
* `user_id` references Users;
* raw password never persisted;
* the same row stores temporary and permanent password hashes;
* password-change requirement belongs to Auth requirement state rather than the credential row.

### `user_authentication_requirements`

Required concepts:

```text
user_id
password_change_required_at nullable
mfa_enrollment_required_at nullable
created_at
updated_at
```

This is Auth's user-scoped mutation/locking anchor.

### `user_mfa_methods`

Initial concepts:

```text
id
user_id
type
secret_ciphertext
confirmed_at nullable
enrollment_expires_at nullable
last_used_at nullable
created_at
updated_at
```

Initial type:

```text
totp
```

Rules:

* reusable secret stored only as ciphertext;
* no raw TOTP secret persisted;
* unconfirmed enrollment expires;
* confirmed method has no user-facing reveal path;
* future WebAuthn columns are not pre-created.

### `mfa_recovery_codes`

Required concepts:

```text
id
user_id
code_hash
used_at nullable
created_at
```

Rules:

* raw code never persisted;
* regeneration invalidates prior unused set;
* code is single-use.

### `password_reset_tokens`

Required concepts:

```text
id
user_id
token_hash
expires_at
used_at nullable
revoked_at nullable
created_at
```

Rules:

* token hash unique;
* at most one usable token per User;
* expiry = 30 minutes from issuance;
* new issuance revokes prior usable token;
* raw token never persisted.

### `sessions`

Auth uses Laravel's database session persistence.

Required framework state includes applicable:

```text
id
user_id nullable
ip_address nullable
user_agent nullable
payload
last_activity
```

Pending guest Auth sessions may have no authenticated User ID.

Production session persistence must follow Transport Session security requirements.

### No Persistent MFA Challenge Table

The initial browser Auth design does not create:

```text
mfa_challenges
```

Short-lived login and recent-auth progression uses bounded server-side session state.

### No Remember Token Initially

Persistent remember-me behavior is deferred.

Do not place `remember_token` back onto the Users table.

### Auth Transaction Ordering

After initial credential establishment, User-scoped Auth mutation locks:

```text
user_authentication_requirements
```

before related Auth rows.

Examples:

```text
password reset:
requirements
    → password credential
    → reset token

MFA confirmation/reset:
requirements
    → MFA method
    → recovery codes

recovery-code use:
requirements
    → unused recovery-code rows
```

### Required Database Contracts

Before implementation readiness:

```text
docs/06-database/feature-contracts/auth.md

docs/06-database/tables/user_password_credentials.md
docs/06-database/tables/user_authentication_requirements.md
docs/06-database/tables/user_mfa_methods.md
docs/06-database/tables/mfa_recovery_codes.md
docs/06-database/tables/password_reset_tokens.md
docs/06-database/tables/sessions.md
```

Exact columns, types, constraints, indexes, retention, and FK behavior belong there.

### Migration Placement

```text
database/core/Auth/migrations/
database/core/Auth/factories/
```

---

## 11. Delivery And Presentation

### HTTP Placement

```text
app/Core/Auth/Http/Controllers/
app/Core/Auth/Http/Requests/
app/Core/Auth/Http/Middleware/
app/Core/Auth/routes/
```

### Controllers

Initial controllers:

```text
LoginController
PendingPasswordChangeController
MfaEnrollmentController
MfaChallengeController
PasswordResetController
PasswordController
RecentAuthenticationController
RecoveryCodesController
LogoutController
```

Controllers delegate Auth behavior inward and do not manipulate Auth persistence directly.

### Guest / Pending Routes

| Method | Route                     | Name                          | Security Profile |
| ------ | ------------------------- | ----------------------------- | ---------------- |
| GET    | `/login`                  | `login`                       | `guest`          |
| POST   | `/login/identify`         | `login.identify`              | `guest`          |
| GET    | `/login/password`         | `login.password`              | `guest`          |
| POST   | `/login/password`         | `login.password.store`        | `guest`          |
| GET    | `/login/password/change`  | `login.password-change`       | `guest`          |
| POST   | `/login/password/change`  | `login.password-change.store` | `guest`          |
| GET    | `/mfa/enroll`             | `mfa.enroll`                  | `guest`          |
| POST   | `/mfa/enroll`             | `mfa.enroll.confirm`          | `guest`          |
| GET    | `/mfa/challenge`          | `mfa.challenge`               | `guest`          |
| POST   | `/mfa/challenge`          | `mfa.challenge.verify`        | `guest`          |
| GET    | `/forgot-password`        | `password.request`            | `guest`          |
| POST   | `/forgot-password`        | `password.email`              | `guest`          |
| GET    | `/reset-password/{token}` | `password.reset`              | `guest`          |
| POST   | `/reset-password`         | `password.update`             | `guest`          |

Pending password/MFA routes additionally require:

```text
auth.pending
```

and the expected pending stage.

### Authenticated Routes

| Method | Route                              | Name                                         | Security Profile |
| ------ | ---------------------------------- | -------------------------------------------- | ---------------- |
| POST   | `/logout`                          | `logout`                                     | `authenticated`  |
| GET    | `/auth/recent`                     | `auth.recent.challenge`                      | `authenticated`  |
| POST   | `/auth/recent`                     | `auth.recent.verify`                         | `authenticated`  |
| GET    | `/account/security/password`       | `account.security.password`                  | `sensitive`      |
| PATCH  | `/account/security/password`       | `account.security.password.update`           | `sensitive`      |
| POST   | `/account/security/recovery-codes` | `account.security.recovery-codes.regenerate` | `sensitive`      |

The recent-authentication challenge itself requires current authentication, loginability, and MFA assurance but cannot require `auth.recent` because it establishes that state.

### Administrator Auth Operations

Administrator temporary-password reset and MFA reset remain Users-owned administration workflows.

Users invokes Auth's public Operations rather than Auth creating duplicate administrative User-management pages.

### Views

```text
resources/views/core/auth/
```

Initial presentation:

```text
login identifier
login password
required password replacement
MFA enrollment
MFA challenge
recovery codes one-time display
forgot password
reset password
recent authentication
self-service password change
```

Secret-bearing responses use:

```text
Cache-Control: no-store
```

and never place secret material into URLs, flash state, analytics, or browser-persistent application storage.

---

## 12. Application Registration

`AuthServiceProvider` is Auth's one registration declaration.

It declares applicable:

```text
owner_key: auth
ownership_area: core

registrations:
  - AuthServiceProvider
  - public Contract bindings
  - Laravel Auth provider integration
  - middleware aliases
  - routes
  - migrations
  - views
  - Events/listeners where applicable
  - Auth configuration
  - security.secret_definitions Contributions
```

### Dependency Semantics

Auth runtime use of Users public Contracts does not automatically create a registration dependency.

Users runtime use of Auth public Contracts does not automatically create a registration dependency.

Registration dependencies exist only when composition ordering is required.

The registration graph must therefore remain acyclic even though the runtime Contract graph includes:

```text
Users ↔ Auth
```

Neither Provider may eagerly resolve the other owner solely to force bootstrap order.

Auth is not directly added to root Laravel bootstrap composition outside Application Registration.

---

## 13. Implementation Manifest

| Change | Path                                                                | Archetype                                 | Responsibility                                                 | Dependencies                        | Requirement Source                    | Verification                       | Compatibility                                                          |
| ------ | ------------------------------------------------------------------- | ----------------------------------------- | -------------------------------------------------------------- | ----------------------------------- | ------------------------------------- | ---------------------------------- | ---------------------------------------------------------------------- |
| CREATE | `app/Core/Auth/Contracts/EstablishTemporaryPasswordInterface.php`   | Operation Contract                        | Establish temporary User credential and Auth requirements      | Secrets public types                | Users/Auth boundary                   | Users/Auth transaction proof       | None                                                                   |
| CREATE | `app/Core/Auth/Contracts/EstablishInitialPasswordInterface.php`     | Operation Contract                        | Establish Invitation-acceptance permanent credential           | Secrets public types                | Users/Auth boundary                   | Invitation credential proof        | None                                                                   |
| CREATE | `app/Core/Auth/Contracts/ResetUserToTemporaryPasswordInterface.php` | Operation Contract                        | Reset existing User to temporary credential                    | Auth state                          | Identity/account security             | Admin password-reset proof         | None                                                                   |
| CREATE | `app/Core/Auth/Contracts/RevokeUserSessionsInterface.php`           | Operation Contract                        | Revoke User sessions                                           | Session persistence                 | Transport/session security            | Session revocation proof           | None                                                                   |
| CREATE | `app/Core/Auth/Contracts/ResetUserMfaInterface.php`                 | Operation Contract                        | Reset User MFA and require enrollment                          | Auth MFA state                      | Identity/account security             | MFA reset proof                    | None                                                                   |
| CREATE | `app/Core/Auth/Contracts/GetAuthenticationAssuranceInterface.php`   | Query/Technical Contract                  | Expose current session assurance                               | Auth session state                  | Zero Trust                            | Assurance Contract proof           | None                                                                   |
| CREATE | `app/Core/Auth/Data/*.php`                                          | Data Object family                        | Define explicit Auth operation/result/snapshot data            | Auth public/internal types          | Public Contract architecture          | Targeted Auth proof                | None                                                                   |
| CREATE | `app/Core/Auth/Enums/*.php`                                         | Enum family                               | Define stable Auth state/value vocabularies                    | None                                | Auth requirements                     | Enum/state proof                   | None                                                                   |
| CREATE | `app/Core/Auth/Models/UserPasswordCredential.php`                   | Model                                     | Persist password hash                                          | Users stable ID                     | Persistent Data Architecture          | Password persistence proof         | None                                                                   |
| CREATE | `app/Core/Auth/Models/UserAuthenticationRequirement.php`            | Model                                     | Persist required password/MFA progression                      | Users stable ID                     | Users/Auth design                     | Requirement-state proof            | None                                                                   |
| CREATE | `app/Core/Auth/Models/UserMfaMethod.php`                            | Model                                     | Persist encrypted TOTP method state                            | Secret cipher                       | Identity/account security             | MFA persistence proof              | None                                                                   |
| CREATE | `app/Core/Auth/Models/MfaRecoveryCode.php`                          | Model                                     | Persist single-use recovery-code hashes                        | Users stable ID                     | Identity/account security             | Recovery-code proof                | None                                                                   |
| CREATE | `app/Core/Auth/Models/PasswordResetToken.php`                       | Model                                     | Persist 30-minute reset-token lifecycle                        | Users stable ID                     | Identity/account security             | Password-reset proof               | None                                                                   |
| CREATE | `app/Core/Auth/Actions/*.php`                                       | Action family                             | Implement Auth operations defined by this SDD                  | Provider-owned Contracts            | Auth requirements                     | Targeted Auth proof                | None                                                                   |
| CREATE | `app/Core/Auth/Laravel/LaravelAuthUserProvider.php`                 | Laravel Adapter                           | Resolve Auth session identity through Users/Auth boundaries    | Users Contracts, Auth credential    | Laravel integration                   | User-provider proof                | None                                                                   |
| CREATE | `app/Core/Auth/Laravel/SessionAuthenticatable.php`                  | Laravel Adapter                           | Present minimal framework authentication identity              | Auth provider                       | Public Contract architecture          | Adapter architecture proof         | None                                                                   |
| CREATE | `app/Core/Auth/Mfa/TotpAuthenticator.php`                           | MFA Adapter                               | Generate/verify TOTP through approved implementation           | TOTP implementation                 | Identity/account security             | TOTP vector proof                  | None                                                                   |
| CREATE | `app/Core/Auth/Mfa/TotpProvisioningUriBuilder.php`                  | Builder                                   | Build secret-bearing provisioning URI                          | TOTP secret                         | Identity/account security             | Provisioning proof                 | None                                                                   |
| CREATE | `app/Core/Auth/Password/PasswordValidator.php`                      | Validator                                 | Apply one Auth password policy                                 | Breached-password checker           | Identity/account security             | Password-policy proof              | None                                                                   |
| CREATE | `app/Core/Auth/Password/TemporaryPasswordGenerator.php`             | Generator                                 | Generate high-entropy temporary credentials                    | CSPRNG                              | Secrets standard                      | Temporary-password proof           | None                                                                   |
| CREATE | `app/Core/Auth/Password/BreachedPasswordCheckerInterface.php`       | Internal Contract                         | Isolate compromised-password lookup behavior                   | Concrete checker adapter            | Identity/account security             | Breach-check failure-mode proof    | None                                                                   |
| CREATE | `app/Core/Auth/Session/PendingAuthenticationStore.php`              | Session component                         | Manage bounded pre-auth state                                  | Laravel session                     | Identity/account security             | Pending-auth proof                 | None                                                                   |
| CREATE | `app/Core/Auth/Session/UserSessionRevoker.php`                      | Session component                         | Revoke User database sessions                                  | Laravel session storage             | Transport/session security            | Session revocation proof           | None                                                                   |
| CREATE | `app/Core/Auth/Resolvers/AuthenticationAssuranceResolver.php`       | Resolver                                  | Resolve MFA and 15-minute recent-auth state                    | Auth session                        | Zero Trust                            | Assurance proof                    | None                                                                   |
| CREATE | `app/Core/Auth/RateLimiting/*.php`                                  | Rate limiter family                       | Apply Auth abuse throttling                                    | Laravel RateLimiter                 | Identity/account security             | Throttling proof                   | None                                                                   |
| CREATE | `app/Core/Auth/Http/Middleware/*.php`                               | Middleware family                         | Enforce loginable/MFA/recent/pending Auth prerequisites        | Users/Auth Contracts                | Zero Trust                            | Security profile integration proof | None                                                                   |
| CREATE | `app/Core/Auth/Http/Controllers/*.php`                              | Controller family                         | Deliver Auth browser flows                                     | Auth Actions                        | Repository architecture               | Browser Auth proof                 | None                                                                   |
| CREATE | `app/Core/Auth/Http/Requests/*.php`                                 | Form Request family                       | Validate Auth transport input safely                           | Auth routes                         | Secure request standards              | Validation/leakage proof           | None                                                                   |
| CREATE | `app/Core/Auth/Events/*.php`                                        | Event family                              | Publish safe completed Auth facts                              | Auth snapshots                      | Public Contract architecture          | After-commit Event proof           | None                                                                   |
| CREATE | `app/Core/Auth/Providers/AuthServiceProvider.php`                   | Provider and Registration Descriptor      | Bind/declare Auth framework integration                        | Application Registration            | Application Registration architecture | Auth registration proof            | None                                                                   |
| CREATE | `app/Core/Auth/routes/web.php`                                      | Route                                     | Declare Auth routes and canonical Security profiles            | Auth Controllers, Security profiles | Zero Trust                            | Route-profile proof                | None                                                                   |
| CREATE | `app/Core/Auth/config/auth.php`                                     | Configuration                             | Define Auth-owned structural/security values                   | Laravel configuration               | Repository architecture               | Auth configuration proof           | None                                                                   |
| MODIFY | `config/auth.php`                                                   | Laravel configuration                     | Configure Auth-owned custom User Provider/web guard            | Auth Laravel adapter                | Auth SDD                              | User-provider proof                | None                                                                   |
| CREATE | `resources/views/core/auth/`                                        | View family                               | Render Auth browser surfaces                                   | Auth Controllers, UI patterns       | Repository architecture               | Browser/manual visual proof        | None                                                                   |
| CREATE | `database/core/Auth/migrations/`                                    | Migration family                          | Materialize accepted Auth database Contracts                   | `/06-database` Contracts            | Persistent Data Architecture          | PostgreSQL migration proof         | None                                                                   |
| CREATE | `database/core/Auth/factories/`                                     | Factory family                            | Supply Auth test data                                          | Auth Models                         | Persistent Data Architecture          | Targeted Auth proof                | None                                                                   |
| CREATE | `docs/06-database/feature-contracts/auth.md`                        | Database Contract                         | Define exact Auth persistence behavior                         | Auth requirements                   | Persistent Data Architecture          | Documentation validation           | None                                                                   |
| CREATE | `docs/06-database/tables/user_password_credentials.md`              | Database Contract                         | Define password credential table                               | Auth requirements                   | Schema standards                      | Documentation validation           | None                                                                   |
| CREATE | `docs/06-database/tables/user_authentication_requirements.md`       | Database Contract                         | Define authentication-requirement table                        | Auth requirements                   | Schema standards                      | Documentation validation           | None                                                                   |
| CREATE | `docs/06-database/tables/user_mfa_methods.md`                       | Database Contract                         | Define MFA method table                                        | Auth requirements                   | Schema standards                      | Documentation validation           | None                                                                   |
| CREATE | `docs/06-database/tables/mfa_recovery_codes.md`                     | Database Contract                         | Define recovery-code table                                     | Auth requirements                   | Schema standards                      | Documentation validation           | None                                                                   |
| CREATE | `docs/06-database/tables/password_reset_tokens.md`                  | Database Contract                         | Define 30-minute reset-token table                             | Auth requirements                   | Schema standards                      | Documentation validation           | None                                                                   |
| CREATE | `docs/06-database/tables/sessions.md`                               | Database Contract                         | Define Auth-owned database sessions                            | Auth requirements                   | Schema standards                      | Documentation validation           | None                                                                   |
| DELETE | `Modules/Auth/`                                                     | Obsolete proof-of-concept artifact family | Remove obsolete Module implementation after target replacement | None                                | Repository architecture               | Architecture/static proof          | Delete obsolete proof-of-concept artifact; no preservation requirement |

No concrete TOTP or breached-password provider dependency is mandated by this SDD.

If implementation requires a new external package or service dependency, normal repository dependency approval remains required.

---

## 14. Verification And Completion

Required proof must establish:

### Ownership

* Auth is Core-owned;
* Users owns human account lifecycle;
* Access owns authorization;
* Security owns route-profile definitions;
* Security/Secrets owns credential-protection rules;
* no cross-owner Model/table access exists.

### Login And User State

* active unsuspended Users can authenticate;
* suspended Users cannot authenticate;
* inactive Users cannot authenticate;
* unverified primary email is non-blocking;
* pending login is not a fully authenticated session;
* password verification alone cannot bypass required password replacement/MFA;
* full login rechecks Users state;
* session ID regenerates on completed login.

### Passwords

* 12-character minimum;
* at least 64 characters accepted;
* no arbitrary composition requirement;
* human-supplied passwords receive breached-password checking in production;
* compromised passwords are rejected;
* checker unavailability fails closed during enforced human password establishment/change;
* login does not perform breached-password lookup;
* Auth-generated high-entropy temporary passwords are exempt from breached-password checking;
* raw passwords never persist.

### Password Recovery

* reset token lifetime is exactly 30 minutes;
* at most one usable token exists per User;
* new request revokes prior usable token;
* token is single-use;
* raw token is never persisted;
* successful reset revokes sessions;
* successful reset does not reset MFA;
* reset request remains enumeration resistant.

### MFA

* TOTP is stored as encrypted owner storage;
* User sees raw TOTP provisioning material only during active enrollment;
* confirmed TOTP has no reveal/copy path;
* Auth may internally decrypt confirmed TOTP for verification;
* recovery codes are shown once and hashed;
* recovery code is single-use;
* recovery codes can satisfy normal MFA recovery;
* recovery codes cannot satisfy recent authentication.

### Recent Authentication

* requires current password;
* requires enrolled confirmed TOTP;
* does not accept recovery code;
* login-time MFA does not count;
* successful step-up regenerates session identifier;
* recent authentication remains valid exactly 15 minutes;
* consumers do not calculate freshness independently.

### Security Profiles

* `authenticated` consumes Auth session/loginability;
* `administrative` adds MFA;
* `sensitive` adds recent authentication;
* `restricted_data` preserves Access/DataProtection ownership;
* Auth assurance never grants permission.

### Sessions

* logout invalidates current session;
* suspension/deactivation fails closed;
* password reset revokes all sessions;
* administrator temporary-password reset revokes all sessions;
* MFA reset revokes all sessions;
* self-service password change revokes other sessions and rotates current session.

### Audit

* pre-auth failed attempts may have no Principal Actor;
* no fake anonymous/guest Principal type is created;
* known attempted account may be Target rather than Actor;
* unknown claimed account has no target;
* raw claimed identifier is not stored;
* Auth supplies Result and Severity;
* Audit supplies Runtime correlation;
* no raw credentials/factors enter Audit.

### Notifications

* Auth persists only reset-token hash;
* password-reset delivery uses protected ephemeral secret delivery;
* queue work contains only a delivery reference;
* durable Notification history does not contain raw token/reset URL;
* ephemeral payload expires no later than 30 minutes.

### Application Registration

* Auth and Users may depend on each other's runtime public Contracts;
* runtime relationships do not create automatic descriptor dependencies;
* registration dependency graph remains acyclic;
* Auth Provider does not eagerly resolve Users merely for bootstrap ordering.

### Database

* all Auth table Contracts are accepted;
* PostgreSQL constraints enforce required lifecycle/uniqueness;
* no persistent MFA-challenge table exists initially;
* no remember token is placed on Users.

### Required Reconciliation Before Acceptance

1. **Auth database Contracts** — exact `/06-database/` feature/table Contracts must be accepted.
2. **Identity And Account Security Standard acceptance** — remains draft after the accepted policy synchronization.
3. **Transport Session And Browser Security Standard acceptance** — remains draft.
4. **Secrets Management Standard acceptance** — remains draft after the accepted TOTP exposure synchronization.
5. **Notifications design** — define the exact Notifications-owned secret-bearing ephemeral-delivery Contract implementing the accepted reset-delivery semantics.
6. **Access design** — consume Auth assurance and finalize protected/administrative/sensitive authorization integration.
7. **Users reconciliation** — after this Auth SDD is accepted, replace the Users SDD's generic Auth placeholders with the accepted Auth Contract names and transaction behavior.
8. **Concrete password/TOTP implementation selection** — implementation may select suitable implementations behind the fixed Auth boundaries; any new repository dependency still requires explicit approval.
9. **No material design blocker remains.**

### Explicit Non-Blockers

The following are intentionally deferred:

* WebAuthn/passkeys;
* hardware security keys;
* OIDC/SSO;
* social login;
* trusted devices;
* remember-me authentication;
* API tokens;
* Service Accounts;
* Non-Human Identity;
* phishing-resistant enforcement;
* risk scoring;
* automatic suspicious-login containment.

### Implementation Ready

* [x] Core Auth ownership is defined.
* [x] Users/Auth/Access ownership split is defined.
* [x] temporary-password behavior is defined.
* [x] Invitation initial-password behavior is defined.
* [x] progressive login is defined.
* [x] full-session issuance is defined.
* [x] TOTP enrollment/challenge is defined.
* [x] recovery-code behavior is defined.
* [x] recent authentication is defined as password + TOTP.
* [x] recent authentication lasts 15 minutes.
* [x] recovery codes are excluded from recent-auth step-up.
* [x] password-reset lifetime is 30 minutes.
* [x] breached-password production policy is defined.
* [x] pre-auth Audit attribution is defined.
* [x] Application Registration dependency semantics are defined.
* [x] TOTP storage/exposure semantics are defined.
* [x] password-reset Notification delivery semantics are defined.
* [x] session-revocation behavior is defined.
* [x] Security profile integration is defined.
* [x] implementation manifest is defined.
* [x] verification surfaces are defined.
* [ ] canonical Auth database Contracts are accepted.
* [ ] applicable draft Security standards are accepted.
* [ ] Notifications public delivery Contract is designed.
* [ ] Access integration is designed.
* [ ] accepted Auth Contracts are synchronized back into Users.
* [ ] no material design blocker remains.

**Design state: draft; the initial Core Auth system behavior and foundation interactions are defined, including the accepted recent-authentication, password-recovery, breached-password, Audit-attribution, registration-dependency, TOTP-exposure, and password-reset-delivery decisions.**
