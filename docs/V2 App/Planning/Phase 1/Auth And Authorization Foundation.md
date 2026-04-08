# Auth And Authorization Foundation

## Purpose

Capture the Phase 1 planning work for platform authentication, tenant-auth separation, RBAC, super-admin behavior, and privileged access handoff.

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

## Related

* [[V2 App/Planning/Phase 1/Phase 1 Index]] | [Phase 1 Index](Phase%201%20Index.md)
* [[V2 App/Planning/Phase 1/Phase 1 - Platform Foundation Planning]] | [Phase 1 - Platform Foundation Planning](Phase%201%20-%20Platform%20Foundation%20Planning.md)
* [[V2 App/Features/Authentication]] | [Authentication](../../Features/Authentication.md)
* [[V2 App/Architecture/Platform And Tenant Application Boundary]] | [Platform And Tenant Application Boundary](../../Architecture/Platform%20And%20Tenant%20Application%20Boundary.md)
