# Platform Users And RBAC

This document defines the canonical scope and intent for Platform Users And RBAC.

## Purpose

Describe the current platform-user and role-based access control foundation for the internal platform instance.

## Implementation Status

Current status:

* implemented in code
* migrated on staging
* platform user management UI exists
* richer staff profile management and selective setup flow are live on staging
* first-pass role and permission seeding updates are live on staging
* Phase 2 Batch 5 selected platform users as the first shared admin Filament migration candidate
* first Filament migration resource is implemented locally at `/console/platform-users`
* target app-owned migration route is implemented locally at `/platform/administration/users`
* shell navigation points to `/platform/administration/users`, and that target route now resolves to app-owned `/platform/users`
* direct `/console/platform-users` access is now controlled by `CONSOLE_PROOF_PATHS_ENABLED` (default off) with fallback redirect to `/platform/users`
* current Blade `/platform/users/*` routes remain compatibility paths for full parity validation
* Filament create/edit flows persist password changes, role assignments, activation state, and staff profile fields
* tenant-scoped auth and tenant roles are still deferred

## Current Implementation

Phase 1 currently uses:

* Laravel identities with Spatie Permission-backed RBAC
* a platform super-admin Gate bypass
* active/inactive user status
* `last_login_at` and timezone capture on login
* platform user create/edit flows in the platform UI
* expanded staff profile fields
* a dedicated Platform Users setup page for onboarding and default-role guidance

Current platform user management surfaces:

* list users
* create staff members
* edit staff members
* assign roles
* set a password on create and update a password while editing
* review grouped permissions by feature in the staff form
* activate or deactivate accounts
* search, paginate, and resize the users list entry count from the UI

## Phase 2 Batch 5 Owner Target

Batch 5 targets platform user management as the first shared admin Filament migration candidate.

Migration requirements:

* preserve the current Blade `/platform/users/*` routes until Filament create/edit/list behavior matches the existing workflow
* route target: `/platform/administration/users`
* transitional Filament proof path: `/console/platform-users` (direct access only; not required by shell-target routing; redirects to app-owned path when proof access is disabled)
* keep `manage-platform-users` as the owner gate
* preserve current staff profile fields, activation state, welcome-email flag, and role assignment behavior
* keep validation and business behavior aligned with the existing request/model/RBAC contracts

## Important Files

* `app/Http/Controllers/Auth/LoginController.php`
* `app/Http/Controllers/Platform/PlatformUserController.php`
* `app/Http/Requests/Platform/StorePlatformUserRequest.php`
* `app/Http/Requests/Platform/UpdatePlatformUserRequest.php`
* `app/Filament/Resources/PlatformUsers/PlatformUserResource.php`
* `app/Filament/Resources/PlatformUsers/Pages/ManagePlatformUsers.php`
* `app/Models/User.php`
* `app/Providers/AppServiceProvider.php`
* `resources/views/platform/users/`
* `resources/views/platform/setup/users.blade.php`
* `resources/js/table-enhance.js`

## Data Dependencies

Data contract ownership for auth and RBAC entities lives in:

* [Auth And RBAC Data Contract](../../06-database/feature-contracts/auth-and-rbac.md)

## Permissions / Security

Current authorization model:

* RBAC is the baseline
* `platform_super_admin` bypasses through a global Gate rule
* direct read access to platform user list and setup guidance uses the `view-platform-users` ability
* create, edit, role assignment, and activation changes remain behind the `manage-platform-users` ability
* direct UI access to notifications and audit logs uses seeded permission-backed gates
* inactive users are blocked from successful login

Current seeded roles and permissions:

* roles: `platform_super_admin`, `platform_admin`, `platform_operator`, `platform_reviewer`
* permissions: `platform.users.view`, `platform.users.manage`, `platform.ui-reference.view`, `platform.docs.view`, `platform.notifications.view`, `platform.audit-logs.view`, `platform.error-logs.view`, `platform.settings.view`, `platform.settings.manage`

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
* Phase 2 Batch 5 still needs final compatibility-route retirement decisions before the Blade path can be removed from daily support

## Related

* [Features Index](../index.md)
* [Authentication](../auth/authentication.md)
* [Auth Architecture](../../03-architecture/auth.md)
* [Security Standards](../../02-standards/security/Security%20Standards.md)
