<!--
DOC-META
title: user_invitations
doc_type: database
status: draft
owner: core
canonical: false
canonical_path: docs/06-database/tables/user_invitations.md
parent: docs/06-database/tables/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines the planned temporary Core Users invitation table used before creation of a permanent User Account.
-->

# `user_invitations`

Parent: [Database Tables Index](index.md)

## 1. Purpose

Store temporary Core Users onboarding Invitations before a permanent User Account exists.

An Invitation is not a User Account and does not create a `users` row until successful acceptance reaches the account-creation boundary.

## 2. Status

- Target lifecycle: planned
- Application owner: Core Users
- Record scope: one proposed human User inside the isolated Tenant Instance
- Classification: confidential with restricted token-hash material

## 3. Planned Columns

| Column             | Type                     | Nullable | Classification | Purpose                                             |
| ------------------ | ------------------------ | -------: | -------------- | --------------------------------------------------- |
| `id`               | bigint                   |       no | internal       | Invitation identifier.                              |
| `email`            | varchar                  |       no | confidential   | Intended primary email address.                     |
| `normalized_email` | varchar                  |       no | confidential   | Normalized email used for lookup and uniqueness.    |
| `first_name`       | varchar                  |      yes | confidential   | Optional administrator-provided onboarding prefill. |
| `last_name`        | varchar                  |      yes | confidential   | Optional administrator-provided onboarding prefill. |
| `token_hash`       | varchar                  |       no | restricted     | Hash of the current one-time Invitation secret.     |
| `status`           | varchar                  |       no | internal       | Current Invitation lifecycle state.                 |
| `issued_at`        | timestamp with time zone |       no | internal       | Current token issuance/reissuance time.             |
| `expires_at`       | timestamp with time zone |       no | internal       | Current Invitation expiry time.                     |
| `accepted_at`      | timestamp with time zone |      yes | internal       | Successful acceptance time.                         |
| `revoked_at`       | timestamp with time zone |      yes | internal       | Administrative revocation time.                     |
| `accepted_user_id` | bigint foreign key       |      yes | internal       | Permanent User Account created by acceptance.       |
| `created_at`       | timestamp with time zone |       no | internal       | Invitation record creation time.                    |
| `updated_at`       | timestamp with time zone |       no | internal       | Last lifecycle update time.                         |

## 4. Status Values

Stable planned values:

```text
issued
accepted
revoked
expired
```

`issued` means the Invitation is potentially usable but acceptance must still verify:

- token;
- `expires_at`;
- current email availability;
- current Invitation status.

Expiry must never be inferred from status alone during acceptance.

## 5. Constraints

Required integrity:

- `id` is the primary key;
- `token_hash` is unique;
- only one `issued` Invitation may exist for one `normalized_email`;
- `accepted_user_id` is unique when populated;
- `accepted_user_id` references `users.id`;
- the relationship must not cascade-delete the User;
- `expires_at` must be later than `issued_at`;
- `accepted` requires `accepted_at` and `accepted_user_id`;
- `accepted` cannot also be revoked;
- `revoked` requires `revoked_at` and cannot have `accepted_user_id`;
- `issued` has no accepted or revoked terminal values;
- `expired` cannot have accepted or revoked terminal values.

Exact database constraint syntax belongs to implementation.

## 6. Invitation Creation

Creating an Invitation:

```text
status = issued
issued_at = current time
expires_at = issued_at + 7 days
accepted_at = null
revoked_at = null
accepted_user_id = null
```

No User Account is created.

Invitation creation must reject:

- an email already owned by a User Account;
- a second usable `issued` Invitation for the same normalized email.

## 7. Reissue

Reissue applies only to an outstanding Invitation.

Reissue:

```text
generate new one-time secret
replace token_hash
issued_at = current time
expires_at = issued_at + 7 days
status remains issued
```

The previous plaintext Invitation link becomes invalid immediately.

Token plaintext is never persisted.

## 8. Revoke

Revocation:

```text
status = revoked
revoked_at = current time
```

A revoked Invitation cannot be accepted.

A later Invitation for the same email is a new Invitation record.

## 9. Expire

An Invitation is invalid after `expires_at` even if background lifecycle processing has not yet changed its persisted status.

When expiry is materialized:

```text
status = expired
```

An expired Invitation cannot be accepted.

A later Invitation for the same email is a new Invitation record.

## 10. Accept

Acceptance must revalidate:

```text
status = issued
token is valid
current time < expires_at
email is not owned by another User Account
```

Successful acceptance atomically/effectively results in:

```text
create one permanent User Account
mark its primary email verified
status = accepted
accepted_at = current time
accepted_user_id = created User Account ID
```

Repeated or concurrent submissions must not create multiple User Accounts.

If account creation or required initial Auth credential establishment fails, the workflow must not report successful acceptance or leave a half-created usable account.

## 11. Direct User Creation Collision

If an administrator directly creates a User Account for the same normalized email while an Invitation is outstanding:

```text
User Account creation succeeds
        ↓
outstanding Invitation becomes revoked/superseded
        ↓
old Invitation token is unusable
```

The User Account follows direct-creation onboarding rules rather than Invitation-acceptance rules.

## 12. Retention

Invitation records are temporary operational persistence.

They are not permanent identity or Audit records.

Accepted, revoked, and expired Invitations may be pruned after the accepted operational retention period.

The exact terminal retention duration must be finalized before M2 implementation.

Durable evidence of issue, reissue, revoke, and acceptance belongs to Core Audit.

## 13. Security

`token_hash` is restricted.

Rules:

- plaintext Invitation tokens are never persisted;
- plaintext tokens are never written to logs, Audit metadata, Monitoring, exceptions, or generic debug output;
- Invitation data must not expose token hashes to normal UI;
- email/name fields are confidential;
- unsuccessful validation must not disclose unnecessary account-existence details to unauthenticated callers.

## 14. Audit And Monitoring

Audit should preserve:

```text
Invitation issued
Invitation reissued
Invitation revoked
Invitation accepted
```

Expiration does not require a public Event or Audit entry merely because time elapsed unless a later operational requirement needs one.

Monitoring may observe failed Invitation processing but does not own Invitation state.

## 15. Related

- [Users Data Contract](../feature-contracts/users.md)
- [Users](users.md)
- [Core Users Development Planning](../../07-planning/02-core-capabilities/auth-identity-access/users-development-planning.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)