<!--
DOC-META
title: Core Users Development Planning
doc_type: planning
status: draft
owner: core
canonical: false
canonical_path: docs/07-planning/02-core-capabilities/auth-identity-access/users-development-planning.md
parent: docs/07-planning/00-overview/m1-core-system-development-register.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines the M1 target design for Core Users, including permanent human User Accounts, profile and email ownership, account lifecycle, suspension, invitations, onboarding, public interactions, and persistence requirements.
-->

# Core Users Development Planning

Parent: [M1 Core System Development Register](../../00-overview/m1-core-system-development-register.md)

## 1. Purpose

Define the target Core Users capability before production implementation.

Core Users owns the permanent human User Account and the Users-owned behavior required to create, identify, update, activate, deactivate, suspend, unsuspend, invite, and present human users.

This plan is target-system design. Existing implementation is reference evidence only and does not determine the target structure.

## 2. Accepted Ownership Boundary

Core Users owns:

- human User Accounts;
- User Identity attributes as a conceptual subset of one User Account;
- name, primary email, email-verification state, phone, and profile-image metadata;
- active/inactive participation state;
- active-account suspension state;
- invitations and invitation lifecycle;
- human-account creation and lifecycle behavior;
- Users-owned administrative and self-service profile behavior;
- Users-owned public Queries, Operations, and completed lifecycle Events.

Core Users does not own:

- passwords, temporary-password state, password reset, MFA, sessions, or authentication assurance;
- roles, permissions, groups, access assignments, or authorization policy;
- private rendered-experience Preferences;
- Notifications delivery state;
- Audit evidence;
- Security detections or policy;
- Non-Human Identity or Service Accounts;
- staff, HR, payroll, hourly-rate, or unrelated business attributes.

Auth owns authentication state. Access owns authorization state. Notifications owns delivery. Audit owns durable event-time evidence. Security may request Users-owned suspension but does not own User state.

## 3. User Account Model

A Human User is the person. A User Account is the permanent Instance-specific human Principal through which that person participates in Login 2.0.

`User Identity` is vocabulary for the identifying/profile subset of the User Account. It does not require a separate Model, table, persistence root, or lifecycle.

Conceptually:

```text
User Account
├── stable account identity
├── account participation state
├── active-only suspension state
└── User Identity attributes
    ├── first name
    ├── last name
    ├── primary email
    ├── email verification
    ├── phone
    └── profile image
```

No separate `user_identities` or `user_profiles` persistence is planned.

## 4. Account State And Suspension

User Account participation has exactly two states:

```text
active
inactive
```

An active User may additionally be suspended:

```text
active + not suspended
active + suspended
inactive
```

An inactive User cannot also be suspended.

Behavior:

| Condition          | Login / application use            | Normal active-user visibility |
| ------------------ | ---------------------------------- | ----------------------------- |
| Active             | Allowed subject to Auth and Access | Visible                       |
| Active + suspended | Blocked                            | Visible                       |
| Inactive           | Blocked                            | Hidden by default             |

Supported transitions:

```text
active ↔ inactive
active ↔ active + suspended
active + suspended → inactive
```

Activation always returns the account to active and unsuspended.

Deactivation clears the current suspension condition because suspension is not applicable to inactive accounts.

Suspension is intended for temporary administrative or Security containment, including suspected account compromise.

## 5. Permanent User Retention

Once a User Account has been created, supported application behavior must never physically delete it.

There is no:

```text
Delete User
users.delete
deleted User state
soft-deleted User lifecycle
```

Deactivation is the supported offboarding operation.

Inactive Users:

- remain permanently persisted;
- remain available for historical references and Audit attribution;
- are hidden from ordinary active-user lists and selectors;
- may be included explicitly through inactive/history filters;
- may be reactivated.

Direct SQL modification is outside the supported application lifecycle.

## 6. User Profile And Primary Email

Minimum Users-owned account information:

| Concept                    | Requirement            |
| -------------------------- | ---------------------- |
| Stable User Account ID     | Required and permanent |
| First name                 | Required               |
| Last name                  | Required               |
| Primary email              | Required and unique    |
| Primary email verification | Required state         |
| Active/inactive state      | Required               |
| Suspension state           | Required capability    |
| Phone                      | Optional               |
| Profile image reference    | Optional               |
| Created/updated timestamps | Required               |

A separate generic `name` field is not required when normal display name can be derived from first and last name.

An independently editable display/preferred name may be added later only when a concrete requirement exists.

The target Users design does not include additional contact-email records. The current `user_contact_emails` feature is deprecated from the target and may be reconsidered later if a real requirement emerges.

### 6.1 Primary Email

Primary email is:

- Users-owned identity/contact data;
- normalized for lookup and uniqueness;
- the initial login identifier consumed by Auth;
- unique within the Instance.

Changing primary email:

```text
Update Primary Email
        ↓
validate normalized uniqueness
        ↓
persist new email
        ↓
clear email verification
        ↓
start verification workflow
```

Email verification is not a User Account lifecycle state.

An active, unsuspended User with an unverified email may authenticate and use the application. The application must present a persistent required verification notification until verification succeeds.

Invitation acceptance verifies the invitation-bound primary email automatically.

## 7. Direct Administrator Account Creation

An authorized administrator may create a User Account without using an invitation.

Direct creation produces:

```text
active
unsuspended
primary email unverified
temporary password required
password replacement required
MFA enrollment required
```

The administrator may:

- supply a temporary password; or
- request an Auth-generated temporary password.

Both forms must satisfy Auth password policy.

Every administrator-established password is temporary and must be replaced at the User's first sign-in.

Generated or administrator-supplied temporary plaintext is shown once after successful creation using the approved one-time-secret modal pattern. Plaintext must not be retrievable after dismissal or stored in logs, Audit metadata, Monitoring, Notifications, or permanent application state.

First sign-in:

```text
temporary password accepted
        ↓
mandatory password replacement
        ↓
mandatory MFA enrollment
        ↓
MFA verification
        ↓
fully authenticated application session
```

Primary-email verification remains a non-blocking persistent requirement.

Administrator password reset for an existing User uses the same temporary-password pattern through Auth and does not alter active/inactive or suspension state.

## 8. User Invitations

An Invitation is Users-owned temporary operational state that exists before a User Account.

Creating an Invitation does not create a `users` record.

Invitation lifecycle:

```text
issued
├── accepted
├── revoked
└── expired
```

Rules:

- one usable outstanding Invitation per normalized email;
- no Invitation for an email already owned by a User Account;
- default Invitation validity is seven days;
- reissue rotates the secret, invalidates the previous link, and resets expiry;
- revoked, expired, or accepted Invitations cannot be reused;
- primary email is fixed to the invited address during acceptance;
- first and last name may be prefilled and edited during acceptance;
- token plaintext is never persisted;
- acceptance rechecks User email uniqueness at the account-creation boundary;
- simultaneous/repeated acceptance can create at most one User Account.

Invitation acceptance:

```text
validate invitation
        ↓
user confirms profile
        ↓
user establishes permanent password through Auth
        ↓
Users creates permanent active User Account
        ↓
primary email marked verified
        ↓
Invitation marked accepted
        ↓
mandatory MFA enrollment
        ↓
normal application use
```

The accepted User Account is created only when the acceptance workflow successfully reaches the account-creation boundary.

If an administrator directly creates an account for an email with an outstanding Invitation, the Invitation is superseded/revoked and its existing link becomes invalid.

Terminal Invitation records are temporary operational data. Durable issue/reissue/revoke/accept evidence belongs to Audit.

## 9. Action And Query Vocabulary

Use common CRUD and CRUD-adjacent action verbs whenever they accurately express the operation.

### 9.1 User Actions

```text
Create User
Get User
List Users
Search Users
Update User
Activate User
Deactivate User
Suspend User
Unsuspend User
```

There is no `Delete User`.

Ordinary profile fields use `Update User`. Behavior with independent workflow semantics uses its own precise action:

```text
Update Primary Email
Verify Primary Email
Resend Email Verification
```

### 9.2 Invitation Actions

```text
Create Invitation / Invite User
Get Invitation
List Invitations
Search Invitations
Reissue Invitation
Revoke Invitation
Accept Invitation
```

Invitation records are revoked rather than manually deleted.

## 10. Public Users Contracts

Not every Users Action needs a public Contract.

Users-owned administrative and self-service Delivery Adapters may call Users implementation directly. Public Contracts are required where another owner depends on a stable Users promise.

### 10.1 Queries

Users should expose narrow provider-owned Queries sufficient for:

| Consumer                 | Required Users information                             |
| ------------------------ | ------------------------------------------------------ |
| Auth                     | Find User by allowed login identifier                  |
| Auth                     | Current active/inactive and suspension state           |
| Access                   | Stable User Account reference and selectable identity  |
| Access                   | List/search Users for assignment and review            |
| Notifications            | Primary email and required addressing identity         |
| Workspace                | Minimal presentation identity                          |
| Other approved consumers | Stable Users-owned snapshot required by their behavior |

Public Query results must not expose Users Models or broad profile records when a narrower snapshot is sufficient.

### 10.2 Operations

Security may invoke Users-owned:

```text
Suspend User
```

and, where authorized:

```text
Unsuspend User
```

Security never writes Users state directly.

Other Users lifecycle Operations are public only if a later owner demonstrates a direct synchronous dependency.

### 10.3 Users Dependencies On Auth

Users consumes Auth-owned Operations for:

```text
establish temporary password
establish user-selected password
reset/set administrator temporary password
revoke sessions when required by lifecycle/security behavior
```

Exact Auth Contract names are deferred to Auth M1 planning.

## 11. Public Events

Publish meaningful completed facts rather than generic update noise.

Initial Users Event semantics:

```text
UserCreated
UserActivated
UserDeactivated
UserSuspended
UserUnsuspended
UserPrimaryEmailUpdated
UserPrimaryEmailVerified

InvitationIssued
InvitationReissued
InvitationRevoked
InvitationAccepted
```

Do not initially publish field-level Events such as:

```text
UserFirstNameUpdated
UserPhoneUpdated
UserProfileImageUpdated
```

unless an independent consumer later requires the completed fact.

Events announce completed facts. They do not replace synchronous interactions required for immediate Auth, Access, or Security correctness.

## 12. Authorization And Guardrails

Access determines whether an Actor may request a protected Users operation.

Users still enforces its own invariants.

Human administrative actions must not allow an administrator to:

- deactivate themselves;
- suspend themselves;
- use administrator temporary-password reset against themselves;
- use administrator MFA-reset behavior against themselves;
- create a duplicate primary email;
- create a User from an email already owned by another User;
- create a second outstanding Invitation for one email.

Self-service password and MFA changes use Auth self-service behavior.

### 12.1 Last Administrator

Ordinary human-admin deactivation or suspension must reject an operation that would leave the Instance with no usable effective administrator.

The exact effective-administrator Query belongs to Access.

Authorized automated Security suspension is allowed to fail secure and may suspend the last effective administrator if compromise is suspected. Recovery from that condition belongs to a later accepted break-glass/support design.

### 12.2 Recent Authentication

Human administrative operations requiring recent authentication / MFA step-up include:

```text
Activate User
Deactivate User
Suspend User
Unsuspend User
Update another User's primary email
administrator temporary-password reset
administrator MFA reset
administrator session revocation
```

Read/list/search, ordinary profile updates, and normal invitation administration do not require step-up by default.

## 13. Persistence Model

Core Users requires only:

```text
users
user_invitations
```

The target does not require:

```text
user_identities
user_profiles
user_contact_emails
user_lifecycle_history
user_suspension_history
user_activity_history
```

Users owns current authoritative state. Audit owns historical lifecycle evidence.

Passwords, temporary-password state, MFA, sessions, roles, permissions, Preferences, and notification delivery state remain in their own capability-owned persistence.

## 14. Reliability And Concurrency

Users must prevent:

- duplicate normalized User emails;
- duplicate usable Invitations for one email;
- two User Accounts being created from one Invitation;
- a User Account being created from an expired/revoked Invitation;
- direct creation and Invitation acceptance racing to create the same email;
- stale suspension or activation updates overwriting newer lifecycle state;
- partial successful account creation that leaves a User without the required Auth credential.

Exact transaction and locking mechanisms belong to implementation design.

## 15. Verification Direction

Future implementation proof should cover:

- permanent User Account retention;
- no supported delete path;
- unique normalized primary email;
- active/inactive transitions;
- suspension only on active Users;
- inactive Users hidden from default lists;
- suspended Users visible in active lists but unable to use the application;
- Security-triggered suspension;
- Auth rejection of inactive/suspended Users;
- direct administrator creation;
- administrator-supplied and generated temporary passwords;
- forced temporary-password replacement;
- first-sign-in MFA requirement;
- non-blocking persistent email-verification requirement;
- Invitation issue/reissue/revoke/expiry/acceptance;
- Invitation acceptance email verification;
- concurrency-safe Invitation acceptance;
- self-target administrative restrictions;
- last-administrator protection for ordinary human actions;
- public Contract boundaries;
- no cross-owner Model/table access;
- secret and PII redaction.

Exact `AC-*`, `PF-*`, fixtures, commands, and environments belong to later implementation issues.

## 16. Development Decomposition

Likely implementation slices:

1. Users target schema and database Contracts.
2. User Account persistence, lifecycle, and core Queries.
3. Administrative list/read/create/update/activate/deactivate behavior.
4. Suspension and Security/Auth integration.
5. Direct administrator creation and temporary-password onboarding.
6. Invitation persistence and lifecycle.
7. Invitation acceptance and MFA onboarding.
8. Self-service Users-owned profile and primary-email behavior.
9. Public Users Queries, Operations, and lifecycle Events.
10. Final documentation promotion and verification decomposition.

This is planning decomposition, not final implementation-order authority.

## 17. Documentation Promotion

After this plan is accepted:

- promote Users persistence into `docs/06-database/feature-contracts/users.md`;
- create planned table Contracts for `users` and `user_invitations`;
- synchronize Persistent Data Architecture with permanent User retention and conceptual-only User Identity;
- synchronize Schema Design Standards from stale Core Identity terminology to Core Users;
- synchronize Identifier And Key Standards from stale `identity` ownership examples to Users ownership;
- update the M1 Core System Development Register;
- supersede the older `users-module-implementation-planning.md` planning document;
- later Auth and Access M1 plans must consume the accepted Core Users boundary rather than the old Identity package assumptions.

The current `user_contact_emails` implementation/documentation remains current-state evidence until implementation removes the deprecated feature. It is not part of the target Users design.

## 18. Completion Criteria

Core Users M1 planning is complete when:

- User Account ownership and permanent-retention semantics are accepted;
- User Identity is confirmed as conceptual rather than separately persisted;
- target User fields are accepted;
- active/inactive and suspension semantics are accepted;
- direct administrator creation is accepted;
- temporary-password onboarding is accepted;
- email-verification behavior is accepted;
- Invitation lifecycle and acceptance are accepted;
- public Query/Operation/Event semantics are accepted;
- administrative guardrails and recent-auth requirements are accepted;
- Users target persistence is documented in `docs/06-database/`;
- stale canonical ownership terminology is synchronized;
- remaining decisions are implementation-level rather than system-design blockers.

After acceptance, M1 proceeds to the next system without implementing Core Users.

## 19. Related

- [M1 Core System Development Register](../../00-overview/m1-core-system-development-register.md)
- [Persistent Data Architecture](../../../03-architecture/persistent-data-architecture.md)
- [Public Contract And Interaction Model](../../../03-architecture/public-contract-and-interaction-model.md)
- [ADR-0006](../../../01-decisions/adr-0006-tenant-instance-workspace-principal-and-invocation-vocabulary.md)
- [Application Actions Services And Data Objects Standards](../../../02-standards/coding/Application%20Actions%20Services%20And%20Data%20Objects%20Standards.md)
- [Schema Design Standards](../../../02-standards/database/Schema%20Design%20Standards.md)
- [Users Data Contract](../../../06-database/feature-contracts/users.md)