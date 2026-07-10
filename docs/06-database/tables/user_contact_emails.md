# user_contact_emails

This document defines the canonical scope and intent for `user_contact_emails`.

## Table Scope

Store current-user contact-only email addresses.

## Columns

- `id`
- `user_id`
- `email`
- `normalized_email`
- `label`
- `verified_at`
- `created_at`
- `updated_at`

## Data Constraints

- `user_id` references `users.id` and cascades on delete.
- `normalized_email` is globally unique.
- rows are communication metadata only and must not be used for authentication.

## Related

- [Auth And RBAC Data Contract](../feature-contracts/auth-and-rbac.md)
