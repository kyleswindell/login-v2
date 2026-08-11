<!--
DOC-META
title: users
doc_type: database
status: planned
owner: core
canonical: true
canonical_path: docs/06-database/tables/users.md
parent: docs/06-database/tables/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines the planned permanent Core Users table for human User Accounts, profile identity, participation state, suspension, and primary-email verification.
-->

# `users`

Parent: [Database Tables Index](index.md)

## 1. Purpose

Store the permanent human User Account owned by Core Users.

A User Account is never deleted through supported application behavior. Offboarding is represented by deactivation.

`User Identity` does not have a separate table. Its identifying/profile attributes are stored as Users-owned attributes of this record.

## 2. Status

- Target lifecycle: planned
- Application owner: Core Users
- Record scope: one human User Account inside the isolated Tenant Instance
- Classification: confidential

## 3. Planned Columns

| Column               | Type                     | Nullable | Classification | Purpose                                                               |
| -------------------- | ------------------------ | -------: | -------------- | --------------------------------------------------------------------- |
| `id`                 | bigint                   |       no | internal       | Permanent internal User Account identifier.                           |
| `first_name`         | varchar                  |       no | confidential   | User first name.                                                      |
| `last_name`          | varchar                  |       no | confidential   | User last name.                                                       |
| `email`              | varchar                  |       no | confidential   | Primary User email as presented by the application.                   |
| `normalized_email`   | varchar                  |       no | confidential   | Normalized primary email used for lookup and uniqueness.              |
| `email_verified_at`  | timestamp with time zone |      yes | internal       | Time the current primary email was verified.                          |
| `is_active`          | boolean                  |       no | internal       | Whether the User Account participates in normal active-user behavior. |
| `deactivated_at`     | timestamp with time zone |      yes | internal       | Most recent transition to inactive state.                             |
| `suspended_at`       | timestamp with time zone |      yes | internal       | Current suspension start time when the active User is suspended.      |
| `suspension_reason`  | text                     |      yes | confidential   | Current administrative/security suspension reason.                    |
| `phone`              | varchar                  |      yes | confidential   | Optional primary phone/contact value.                                 |
| `profile_image_path` | varchar                  |      yes | confidential   | Optional approved profile-image storage reference.                    |
| `created_at`         | timestamp with time zone |       no | internal       | User Account creation time.                                           |
| `updated_at`         | timestamp with time zone |       no | internal       | Last current-state update time.                                       |

The table does not contain:

```text
password
remember_token
last_login_at
MFA fields
role/permission fields
administrator/staff flags
Preferences
hourly-rate/business attributes
additional contact emails
soft-delete fields
```

## 4. Constraints

Required integrity:

- `id` is the primary key.
- `normalized_email` is unique.
- `email` and `normalized_email` are required.
- inactive Users must not contain active suspension state;
- active Users must have `deactivated_at = null`;
- inactive Users must have a meaningful `deactivated_at`;
- `suspended_at` may be populated only when `is_active = true`;
- `suspension_reason` is required when `suspended_at` is populated;
- `suspension_reason` is null when the account is not suspended.

Exact check-constraint syntax belongs to implementation.

## 5. Lifecycle

### Direct Administrator Creation

Initial state:

```text
is_active = true
deactivated_at = null
suspended_at = null
suspension_reason = null
email_verified_at = null
```

Auth separately establishes the temporary password, forced password replacement, and first-sign-in MFA requirement.

### Invitation Acceptance

Initial state:

```text
is_active = true
deactivated_at = null
suspended_at = null
suspension_reason = null
email_verified_at = acceptance time
```

The accepted Invitation proves possession of the primary email.

### Deactivate

```text
is_active = false
deactivated_at = current time
suspended_at = null
suspension_reason = null
```

### Activate

```text
is_active = true
deactivated_at = null
suspended_at = null
suspension_reason = null
```

### Suspend

Allowed only while active:

```text
suspended_at = current time
suspension_reason = required reason
```

### Unsuspend

```text
suspended_at = null
suspension_reason = null
```

### Primary Email Update

Changing `email` / `normalized_email` requires:

```text
email_verified_at = null
```

until the new address completes verification.

## 6. Deletion And Retention

Supported application behavior must never:

- hard-delete a User Account;
- soft-delete a User Account;
- recycle a User Account ID;
- cascade-delete a User Account because another record changes.

Inactive Users remain permanently persisted and become hidden from normal active-user query results.

Future DataGovernance/DataProtection requirements may govern masking or anonymization of particular PII fields, but the permanent User Account identity and historical reference must remain.

## 7. Indexes

Required:

- primary key on `id`;
- unique index/constraint on `normalized_email`;
- index supporting normal active/inactive User filtering.

Additional search indexes should be added only for accepted query paths.

## 8. Relationships

Other Core capabilities or Modules may reference stable `users.id` where accepted architecture permits a durable identity relationship.

A foreign key to `users.id`:

- does not transfer ownership;
- does not authorize direct Users mutation;
- must not use cascading User deletion.

Cross-owner behavioral reads/writes use Core Users public Contracts.

## 9. Security And Export

Confidential fields must be protected from unauthorized disclosure.

Normal User snapshots should expose only the fields required by the consuming Contract.

Generic exports must not automatically expose all profile/contact fields.

Suspension reasons may contain security-sensitive administrative context and must not appear in unrestricted UI, logs, or generic public responses.

## 10. Audit And Monitoring

Audit should preserve material changes including:

```text
created
activated
deactivated
suspended
unsuspended
primary email updated
primary email verified
```

The table itself is current-state truth and is not a lifecycle-history ledger.

Monitoring may observe failed or anomalous Users operations but does not own User state.

## 11. Related

- [Users Data Contract](../feature-contracts/users.md)
- [User Invitations](user_invitations.md)
- [Core Users Development Planning](../../07-planning/02-core-capabilities/users/users-development-planning.md)
- [Persistent Data Architecture](../../03-architecture/persistent-data-architecture.md)
