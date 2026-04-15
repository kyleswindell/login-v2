# Auth And Authorization Foundation

This document defines the canonical scope and intent for Auth And Authorization Foundation.

## Purpose

Capture the Phase 1 planning work for platform authentication, tenant-auth separation, RBAC, super-admin behavior, and privileged access handoff.

## Implementation Status

Current status:

* authentication baseline is implemented and live on staging
* RBAC foundation is implemented and migrated on staging
* platform user management UI is implemented and live on staging
* tenant auth and privileged tenant handoff remain planned only

Canonical docs:

* [Authentication](../../../04-features/auth/authentication.md)
* [Platform Users And RBAC](../../../04-features/users/platform-users-and-rbac.md)
* Phase 1 Development Log

## Current Planning Direction

This note should absorb and refine the auth-related decisions from the main Phase 1 planning note.

Current direction:

* landlord/platform auth remains the first implemented auth context
* tenant auth remains a separate future context
* RBAC is the preferred baseline authorization model
* platform super-admin access into tenant contexts should use an auditable handoff flow

## Recommended Phase 1 Defaults

### Authentication baseline

Phase 1 should standardize Laravel's built-in web-auth patterns instead of introducing custom auth primitives.

Recommended defaults:

* session-backed browser authentication
* CSRF protection on all state-changing web requests
* Laravel password hashing defaults
* password reset flow
* password change flow
* optional email-verification readiness
* future MFA readiness without implementing it immediately

### Authorization baseline

Phase 1 should adopt RBAC as the baseline authorization model.

Recommended rule set:

* permissions are defined centrally
* roles are composed from permissions
* users receive roles rather than direct one-off permissions by default
* platform super-admin bypass is handled through a global policy rule
* landlord/platform roles remain separate from future tenant runtime roles

Recommended platform role vocabulary:

* `platform_super_admin`
* `platform_admin`
* `platform_operator`

Tenant roles should be treated as a separate authorization scope even if names are similar.

### Session policy

Recommended defaults:

* platform users authenticate only against the platform app/session domain
* tenant context is never inferred only from user role
* idle timeout and absolute timeout should be defined centrally
* `remember me` should be disabled by default for privileged platform users unless explicitly approved later
* password changes should revoke other active sessions
* privileged tenant-access handoff sessions should be visibly marked and time-limited

### Platform-to-tenant privileged access

For Phase 1, the preferred approach is not shared browser auth across platform and tenant panels.

Recommended model:

* the platform user authenticates normally to the landlord app
* the platform app verifies authority to access the target tenant
* the platform app issues a short-lived, single-use handoff token or signed entry flow
* the tenant app validates it, establishes a tenant-side privileged session, and records a full audit trail

This preserves convenience while keeping tenant access revocable and auditable.

### Global identity stance

Current recommended direction:

* platform identities remain the source of truth for platform admins
* normal tenant users remain tenant-local
* privileged platform identities may be mapped into tenant contexts in a controlled way when needed
* do not plan broad shared user-table behavior across all tenant databases in Phase 1

### Phase 1 base auth tables

Phase 1 should stay close to Laravel's defaults unless there is a clear architectural reason not to.

Recommended first implementation:

* `users`
* `password_reset_tokens`
* `roles`
* `permissions`
* `model_has_roles`
* `role_has_permissions`

Recommended stance:

* use the central `users` table for the internal platform/core-app identities in Phase 1
* do not introduce a separate `platform_users` table unless a concrete need appears
* use package-backed RBAC tables rather than custom role pivots
* keep tenant-runtime users out of scope for this database in Phase 1

Recommended `users` baseline should support:

* login identifier
* password hash
* active/inactive status
* email verification readiness
* invitation readiness if platform users become invite-only
* last-login metadata if we decide it belongs on the user row rather than only in audit logs

Recommended RBAC stance:

* keep the standard role and permission table names in the central Phase 1 database
* keep platform role naming in the permission/role data, not in table prefixes
* keep future tenant auth tables separate in future tenant databases rather than overloading the Phase 1 central schema now

## Naming Direction

Recommended permission naming:

* `platform.users.view`
* `platform.roles.manage`
* `platform.tenants.provision`
* `tenant.dashboard.view`
* `tenant.settings.update`

Recommended route naming:

* `platform.dashboard`
* `platform.users.index`
* `platform.tenants.show`
* `tenant.dashboard`

## Candidate Deliverables

This planning area should likely produce:

* platform auth specification
* platform role and permission vocabulary
* session policy note
* platform-to-tenant handoff design
* future tenant auth boundary note

## Questions To Resolve

* guards and providers for platform users versus future tenant users
* panel separation for platform and tenant authentication
* session policy for privileged platform users
* tenant access handoff token model
* whether invitation/registration exists for platform users at all

## Open Questions

Still worth deciding explicitly:

* whether platform users should be invited only, with no public registration flow
* whether the first implementation should use one guard with scoped user types or clearly separate platform and tenant guards from the beginning
* whether tenant privileged handoff should support route-specific destination targets in Phase 1
* whether impersonation is deferred entirely or designed as a later extension of the handoff model
* whether `users` should include explicit lifecycle columns such as `is_active`, `invited_at`, and `last_login_at` in Phase 1 or rely on audit logs first

## Related

* [Phase 1 Index](Phase%201%20Index.md)
* [Phase 1 - Platform Foundation Planning](Phase%201%20-%20Platform%20Foundation%20Planning.md)
* [Authentication](../../../04-features/auth/authentication.md)
* [Platform Users And RBAC](../../../04-features/users/platform-users-and-rbac.md)
* [Platform And Tenant Application Boundary](../../../03-architecture/platform-boundary.md)
