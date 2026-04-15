# Auth And RBAC Data Contract

This document defines the canonical scope and intent for Auth And RBAC Data Contract.

## Tables

- `users`
- `password_reset_tokens`
- `roles`
- `permissions`
- `model_has_roles`
- `model_has_permissions`
- `role_has_permissions`

## Lifecycle Columns On `users`

- `is_active`
- `last_login_at`
- `timezone`

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

## Migration Ownership

- `2026_04_10_000001_add_staff_profile_fields_to_users_table.php` owns staff-profile field expansion on `users`.

## Related

- [Authentication](../../04-features/auth/authentication.md)
- [Platform Users And RBAC](../../04-features/users/platform-users-and-rbac.md)
