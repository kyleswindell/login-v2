# Auth And RBAC Data Contract

This document defines the canonical scope and intent for Auth And RBAC Data Contract.

## Tables

- `users`
- `password_reset_tokens`
- `roles`
- `permissions`
- `permission_registry_entries`
- `model_has_roles`
- `model_has_permissions`
- `role_has_permissions`
- `role_metadata`
- `user_contact_emails`
- `user_mfa_methods`
- `user_mfa_policies`
- `mfa_recovery_codes`

## Lifecycle Columns On `users`

- `is_active`
- `last_login_at`
- `timezone`

## MFA Data Contract

Initial platform-account MFA implementation uses dedicated MFA storage rather than overloading profile fields.

Implemented data shape:

- `user_mfa_methods` stores one TOTP method per user with encrypted confirmed secret material, encrypted pending setup material, pending setup expiry, confirmation timestamp, reset actor and timestamp, and challenge/satisfaction support timestamps.
- `user_mfa_policies` stores the per-user `mfa_required` flag plus requirement and latest-update actor metadata.
- `mfa_recovery_codes` stores hashed single-use recovery-code material only. Plaintext recovery codes are generated after successful MFA enrollment, shown once through session state, and never persisted.

Session data, not only database rows, owns current MFA satisfaction and step-up timestamps. Cache-backed rate-limit state owns short-lived MFA attempt throttling. Database fields may support audit, support, and enrollment state, but must not be treated as proof that a specific browser session has satisfied MFA.

## Staff Profile Columns On `users`

- `first_name`
- `last_name`
- `hourly_rate`
- `phone`
- `facebook`
- `linkedin`
- `skype`
- `default_language`
- `email_signature`
- `direction`
- `send_welcome_email`
- `is_administrator`
- `is_staff_member`
- `profile_image_path`

## User Contact Email Columns

`user_contact_emails` stores current-user contact-only email addresses. These rows are communication metadata only and must not be used for authentication.

- `user_id`
- `email`
- `normalized_email`
- `label`
- `verified_at`
- timestamps

## Permission Registry Columns

`permission_registry_entries` stores imported module-declared permission metadata while Spatie tables remain the runtime authorization store.

- `key`
- `permission_id`
- `module_key`
- `group_key`
- `group_label`
- `action`
- `label`
- `description`
- `is_elevated`
- `is_destructive`
- `is_active`
- `is_stale`
- `source_hash`
- `synced_at`
- timestamps

## Role Metadata Columns

`role_metadata` stores role UI metadata and guardrail state for Spatie roles.

- `role_id`
- `label`
- `description`
- `is_system`
- `is_default`
- `is_protected`
- `is_deletable`
- `is_assignable`
- `created_by_user_id`
- `updated_by_user_id`
- timestamps

## Migration Ownership

- `2026_04_10_000001_add_staff_profile_fields_to_users_table.php` owns staff-profile field expansion on `users`.
- `2026_07_07_000001_create_roles_registry_metadata_tables.php` owns permission registry and role metadata tables.
- `2026_07_07_000002_create_user_contact_emails_table.php` owns contact-only account email storage.

## Related

- [Authentication](../../04-features/auth/authentication.md)
- [Platform Users And RBAC](../../04-features/users/platform-users-and-rbac.md)
- [MFA Enrollment And Challenge Flow](../../05-flows/mfa-enrollment-and-challenge-flow.md)
