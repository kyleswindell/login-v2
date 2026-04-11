# Platform Users And RBAC

## Purpose

Describe the current platform-user and role-based access control foundation for the internal platform instance.

## Implementation Status

Current status:

* implemented in code
* migrated on staging
* platform user management UI exists
* richer staff profile management and selective setup flow are implemented in code and pending staging deploy
* first-pass role and permission seeding updates are implemented in code and pending staging deploy
* tenant-scoped auth and tenant roles are still deferred

## Current Implementation

Phase 1 currently uses:

* Laravel's `users` table for platform identities
* Spatie Laravel Permission with default table names
* a platform super-admin Gate bypass
* active/inactive user status
* `last_login_at` and timezone capture on login
* platform user create/edit flows in the platform UI
* expanded staff profile fields stored on `users`
* a dedicated Platform Users setup page for onboarding and default-role guidance

Current platform user management surfaces:

* list users
* create staff members
* edit staff members
* assign roles
* review grouped permissions by feature in the staff form
* activate or deactivate accounts
* search, paginate, and resize the users table entry count from the UI

## Important Files

* `app/Http/Controllers/Auth/LoginController.php`
* `app/Http/Controllers/Platform/PlatformUserController.php`
* `app/Http/Requests/Platform/StorePlatformUserRequest.php`
* `app/Http/Requests/Platform/UpdatePlatformUserRequest.php`
* `app/Models/User.php`
* `app/Providers/AppServiceProvider.php`
* `database/migrations/2026_04_10_000001_add_staff_profile_fields_to_users_table.php`
* `resources/views/platform/users/`
* `resources/views/platform/setup/users.blade.php`
* `resources/js/table-enhance.js`

## Data / Tables

Current Phase 1 auth and RBAC tables:

* `users`
* `password_reset_tokens`
* `roles`
* `permissions`
* `model_has_roles`
* `model_has_permissions`
* `role_has_permissions`

Current lifecycle columns on `users`:

* `is_active`
* `last_login_at`
* `timezone`

Current staff profile columns on `users`:

* `first_name`
* `last_name`
* `hourly_rate`
* `phone`
* `facebook`
* `linkedin`
* `skype`
* `default_language`
* `email_signature`
* `direction`
* `send_welcome_email`
* `is_administrator`
* `is_staff_member`
* `profile_image_path`

## Permissions / Security

Current authorization model:

* RBAC is the baseline
* `platform_super_admin` bypasses through a global Gate rule
* direct UI access to platform user management requires the `manage-platform-users` ability
* direct UI access to notifications and audit logs uses seeded permission-backed gates
* inactive users are blocked from successful login

Current seeded roles and permissions:

* roles: `platform_super_admin`, `platform_admin`, `platform_operator`
* permissions: `platform.users.manage`, `platform.docs.view`, `platform.notifications.view`, `platform.audit-logs.view`, `platform.error-logs.view`, `platform.settings.manage`

## Common Workflows

Current workflows:

* create a new staff member with profile details, activation state, and welcome-email preference
* assign one or more platform roles
* review effective permissions grouped by feature while editing a staff account
* deactivate a platform user without deleting them
* sign in and update `last_login_at` plus timezone on successful login

## Known Gaps

Current gaps:

* no password reset UI flow yet
* no tenant-auth boundary implementation yet
* the permissions tab is still an informational grouped view driven by installed permissions, not a full direct per-capability assignment matrix

## Related

* [[V2 App/Features/Authentication]] | [Authentication](Authentication.md)
* [[V2 App/Planning/Phase 1/Auth And Authorization Foundation]] | [Auth And Authorization Foundation](../Planning/Phase%201/Auth%20And%20Authorization%20Foundation.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 1]] | [Phase 1 - Implementation Batch 1](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 2]] | [Phase 1 - Implementation Batch 2](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%202.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 3]] | [Phase 1 - Implementation Batch 3](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%203.md)
