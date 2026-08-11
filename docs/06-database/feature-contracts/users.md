<!--
DOC-META
title: Users Data Contract
doc_type: database
status: draft
owner: core
canonical: false
canonical_path: docs/06-database/feature-contracts/users.md
parent: docs/06-database/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines the planned Core Users persistence boundary for permanent human User Accounts and temporary User Invitations.
-->

# Users Data Contract

Parent: [Database Index](../index.md)

## 1. Purpose

Define the target persistent data owned by Core Users.

Core Users stores permanent human User Accounts and temporary User Invitations.

This contract does not own authentication credentials, MFA, sessions, authorization state, Preferences, Notification delivery state, Audit evidence, or Non-Human Identity.

## 2. Status

- Target lifecycle: planned
- Implementation state: not yet implemented as the accepted target
- Authoritative application owner: Core Users
- Tenant/Instance scope: the configured isolated Tenant Instance database

## 3. Target Tables

Core Users requires:

```text
users
user_invitations
```

The target does not include:

```text
user_identities
user_profiles
user_contact_emails
user_lifecycle_history
user_suspension_history
user_activity_history
```

`User Identity` is a conceptual subset of one User Account rather than a separate persistent entity.

The current `user_contact_emails` feature is deprecated from the target Users design. Its current table and documentation remain implementation evidence until the deprecated feature is physically removed.

## 4. `users`

`users` stores one permanent human User Account per record.

It owns:

- stable User Account identity;
- first and last name;
- primary email and normalized email;
- primary-email verification state;
- active/inactive participation state;
- current active-account suspension state;
- optional phone;
- optional profile-image reference;
- normal record timestamps.

A User Account is never hard-deleted or soft-deleted through supported application behavior.

Inactive Users remain permanently persisted.

## 5. `user_invitations`

`user_invitations` stores temporary onboarding state before a User Account exists.

It owns:

- intended primary email;
- normalized intended email;
- optional first/last-name prefill;
- one-time invitation-token hash;
- issuance and expiry;
- issued/accepted/revoked/expired lifecycle;
- optional relationship to the User Account created by successful acceptance.

An Invitation is not a User Account.

No `users` row exists merely because an Invitation has been issued.

## 6. Cross-Owner Exclusions

Core Users tables must not store:

```text
password
temporary-password plaintext
password-reset state
remember tokens
MFA methods
MFA recovery material
authentication sessions
roles
permissions
groups
access assignments
notification delivery state
private UI preferences
service-account/NHI records
```

Those values remain with their authoritative owners.

Cross-owner behavior uses provider-owned public Contracts rather than direct Users table access.

## 7. Core Invariants

### User Accounts

- User Account ID is permanent and never reused.
- Primary email is normalized and unique within the Instance.
- User Accounts are either active or inactive.
- Suspension is valid only while a User Account is active.
- Inactive Users cannot remain suspended.
- Activation returns a User to active and unsuspended.
- Deactivation clears the current suspension state.
- Changing primary email clears verification.
- Supported application behavior never deletes a User Account.

### Invitations

- Only one usable outstanding Invitation may exist for one normalized email.
- No outstanding Invitation may target an email already owned by a User Account.
- Invitation plaintext tokens are never persisted.
- Default Invitation lifetime is seven days.
- Reissue invalidates the previous token and starts a new seven-day validity period.
- Accepted, revoked, and expired Invitations are unusable.
- Successful acceptance creates at most one permanent User Account.
- Invitation acceptance verifies the resulting User primary email.
- Direct User creation supersedes any outstanding Invitation for the same email.

## 8. Relationships

```text
user_invitations.accepted_user_id
    → users.id
```

The relationship is optional until acceptance.

Users-owned records must not rely on cascading deletion from `users`, because User Accounts are permanent.

Other owners may reference stable `users.id` when architecture permits a durable identity foreign key. Such references do not transfer ownership or allow direct behavioral access.

## 9. Classification And Retention

### `users`

Classification: confidential.

Sensitive content includes:

- name;
- primary email;
- phone;
- profile-image reference;
- suspension reason where present.

User Account records are permanently retained by supported application behavior.

### `user_invitations`

Classification:

- confidential for identifying/profile information;
- restricted for invitation-token hash material.

Invitation records are temporary operational data.

Accepted, revoked, and expired Invitation records may be pruned after the accepted operational retention period. Durable evidence of invitation lifecycle actions belongs to Core Audit.

The exact terminal Invitation retention duration must be finalized before M2 implementation.

## 10. Audit Expectations

Core Audit should preserve evidence for:

```text
User created
User activated
User deactivated
User suspended
User unsuspended
User primary email updated
User primary email verified
Invitation issued
Invitation reissued
Invitation revoked
Invitation accepted
```

Users tables store current authoritative state, not lifecycle-history records.

## 11. Related

- [Users Table](../tables/users.md)
- [User Invitations Table](../tables/user_invitations.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)
- [Core Users Development Planning](../../07-planning/02-core-capabilities/auth-identity-access/users-development-planning.md)
- [Schema Design Standards](../../02-standards/database/Schema%20Design%20Standards.md)
- [Database Data Classification And Retention Standards](../../02-standards/database/Database%20Data%20Classification%20And%20Retention%20Standards.md)