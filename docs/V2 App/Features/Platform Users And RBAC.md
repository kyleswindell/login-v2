# Platform Users And RBAC

## Purpose

Describe the current platform-user and role-based access control foundation for the internal platform instance.

## Implementation Status

Current status:

* implemented in code
* migrated on staging
* platform user management UI exists
* role and permission seeding is still incomplete
* tenant-scoped auth and tenant roles are still deferred

## Current Implementation

Phase 1 currently uses:

* Laravel's `users` table for platform identities
* Spatie Laravel Permission with default table names
* a platform super-admin Gate bypass
* active/inactive user status
* `last_login_at` and timezone capture on login
* platform user create/edit flows in the platform UI

Current platform user management surfaces:

* list users
* create users
* edit users
* assign roles
* activate or deactivate accounts

## Important Files

* `app/Http/Controllers/Auth/LoginController.php`
* `app/Http/Controllers/Platform/PlatformUserController.php`
* `app/Http/Requests/Platform/StorePlatformUserRequest.php`
* `app/Http/Requests/Platform/UpdatePlatformUserRequest.php`
* `app/Models/User.php`
* `app/Providers/AppServiceProvider.php`
* `resources/views/platform/users/`

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

## Permissions / Security

Current authorization model:

* RBAC is the baseline
* `platform_super_admin` bypasses through a global Gate rule
* direct UI access to platform user management requires the `manage-platform-users` ability
* inactive users are blocked from successful login

## Common Workflows

Current workflows:

* create a new platform user
* assign one or more platform roles
* deactivate a platform user without deleting them
* sign in and update `last_login_at` plus timezone on successful login

## Known Gaps

Current gaps:

* no formal first-pass role/permission seeders yet
* no password reset UI flow yet
* no tenant-auth boundary implementation yet

## Related

* [[V2 App/Features/Authentication]] | [Authentication](Authentication.md)
* [[V2 App/Planning/Phase 1/Auth And Authorization Foundation]] | [Auth And Authorization Foundation](../Planning/Phase%201/Auth%20And%20Authorization%20Foundation.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 1]] | [Phase 1 - Implementation Batch 1](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%201.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Implementation Batch 2]] | [Phase 1 - Implementation Batch 2](../Planning/Phase%201/Phase%201%20-%20Implementation%20Batch%202.md)
