# Identity And Users Core Capability Implementation Planning

Status: Planning draft

## Purpose

Plan the Users administration surface inside the core Identity capability before implementing the larger Access Control capability.

Identity must become a stable core capability package because Access Control needs users as subjects for groups, access policies, direct exceptions, and effective access views. This document owns implementation sequencing and intent only. Final behavior, schema, and architecture contracts must be promoted to their owning docs before code implementation.

## Current Baseline

Current user-management behavior exists, but it is not packaged behind an Identity-owned capability.

Implemented today:

- static package metadata declares a `users` core capability from `app/Core/Modules/Definitions.php`
- privileged user routes live in `routes/web.php` under `/platform/users`
- privileged user controllers live in `app/Http/Controllers/Platform`
- privileged user requests live in `app/Http/Requests/Platform`
- user management views live in `resources/views/platform/users`
- user defaults settings are handled by `Modules/Settings/Http/Controllers/PageController.php`
- user defaults settings render through `Modules/Settings/resources/views/users.blade.php`
- setup page `/platform/setup/users` is intentionally not registered
- permissions are still `platform.users.view` and `platform.users.manage`
- Gates are still `view-platform-users` and `manage-platform-users` in `AppServiceProvider`
- role assignment is delegated through `Modules/Roles/Services/UserRoleAssignmentWriter`
- MFA requirement/reset actions are in platform user controllers but call Auth-owned MFA services
- password changes for managed users call Auth-owned password policy and Auth notification types
- Account owns current-user self-service account pages under `Modules/Account`

This is a workable transition state, but Access Control should not build policy subjects, group membership, or effective access views on top of these transitional platform-owned surfaces.

## Target Direction

Create `app/Core/Identity` as the core identity lifecycle capability before implementing Access Control Groups, Policies, or Effective Access.

Target capability direction:

```text
app/Core/Identity/
  Actions/
  Data/
  Enums/
  Events/
  Http/Controllers
  Http/Requests
  Models/
  Policies/
  Queries/
  Services
  Support/
  ViewModels/
  Routes/account.php
  Routes/admin-users.php
```

The `User` Eloquent model should remain in `app/Models/User`. It is the Laravel authenticatable model used by guards, factories, password resets, notifications, and package integrations. Identity-adjacent records such as user profile, security state, invitations, lifecycle history, and session metadata should live under `app/Core/Identity/Models` when those records are introduced.

## Owner Boundaries

### Identity / Users Owns

- privileged user list, detail, create, update, deactivate/reactivate, and future delete/deprovision flows
- administrator-managed user profile fields
- active/inactive account state
- user lifecycle defaults settings
- Users-owned setup guidance, only where there is real setup work
- user selector/query services for other packages
- user status and lifecycle labels
- CRUD permissions for user administration
- coordination with Roles for role assignment
- coordination with Auth for password/MFA/security mechanics
- user detail surfaces that later display effective access from Access Control

### Account Owns

- current authenticated user's self-service account page
- profile photo, personal details, phone/contact details, and contact-only emails for the current user
- account menu and account tab suite
- current-user password update entry point while delegating mechanics to Auth
- current-user MFA entry points while delegating mechanics to Auth

Account must not own administrator user management, role assignment, activation state for other users, or user lifecycle defaults.

### Auth Owns

- login identity proof
- password hashing and password policy services
- MFA enrollment/challenge/reset mechanics
- session assurance and MFA step-up
- security notifications for password/MFA changes

Target owner is `app/Core/Auth`. Users may render privileged controls for password/MFA administration, but Auth remains the owner of mechanics and validation.

Auth vs Identity split:

```text
Identity = account exists, profile, status, lifecycle, invitation, suspension, deactivation
Auth     = login, logout, password, MFA, sessions, recovery, recent authentication
```

Examples:

- invite user: Identity
- accept invitation: Identity plus Auth password/MFA setup
- change password: Auth
- suspend user: Identity plus Auth session revocation
- deactivate user: Identity plus Access/Auth revocation
- reset MFA: Auth, initiated from Identity admin UI
- view user security posture: Identity reads Auth summary

### Data Protection Owns

Target owner is `app/Core/DataProtection`.

DataProtection should classify user PII, contact-only email metadata, identity lifecycle records, invitation records, deactivation/anonymization outputs, and export/retention behavior. Identity owns the records and workflows; DataProtection owns the cross-cutting data-handling rules.

### Application Security Owns

Target owner is `app/Core/Security`.

Application Security should provide route-tier, request validation, request redaction, safe redirect, upload/download, and release-check guardrails for Identity-owned user administration. Identity owns the user lifecycle workflows.

### Roles Owns

- role definitions and role metadata
- permission catalog and permission registry
- role assignment guardrails
- user role assignment writer
- role assignment notifications

Users may include role assignment controls, but role assignment mutations must continue to call Roles-owned services.

### Settings Owns

- Settings shell, sidebar, and settings contribution aggregation
- generic settings value storage service

Identity/Users should own user defaults settings behavior and declare the settings page. Settings should render it as a package-contributed settings page.

### Setup Owns

- Setup shell and setup contribution aggregation

Identity/Users should own Users setup content if a setup screen is reintroduced. Setup should render it as a package-contributed setup screen.

### Access Control Owns Later

- access groups
- access policies
- direct assignment exception model
- effective access resolver
- access reviews

Identity/Users should expose stable user subject/query contracts that Access Control can consume.

## Account Interface

The same `users` table backs both Account and Users, so the boundary must be behavioral rather than table-only.

Account actions are self-service:

- user can update their own profile photo
- user can update their own personal details
- user can update their own contact details
- user can manage their own contact-only emails
- user can update their own password after Auth-owned checks
- user can manage their own MFA enrollment through Auth-owned flows

Users actions are privileged administration:

- privileged actor can create users
- privileged actor can update another user's administrator-managed fields
- privileged actor can activate/deactivate users
- privileged actor can assign roles through Roles
- privileged actor can require/reset MFA through Auth
- privileged actor can set or reset a managed user's password through Auth policy
- privileged actor can delete or deprovision users only after explicit guardrails exist

Conflict rule:

If a field appears in both Account and Users, the context decides ownership:

- current user editing self: Account route/controller/request
- privileged actor editing target user: Users route/controller/request

Users must not reuse Account forms for privileged administration because the authorization, audit, notification, and step-up rules differ.

## Settings And Setup Ownership

### User Defaults Settings

Current user defaults:

- `users.default_role`
- `users.default_active`

Target:

- Identity/Users declares a `SettingsPage` UI entry for user defaults.
- Identity/Users owns the controller/request behavior for reading and updating user defaults.
- Settings continues to aggregate and render package-contributed settings pages.
- Settings value storage may remain in the shared `settings` table.
- User defaults route may keep `/platform/settings/users` as compatibility until route aliases are planned.

This route should eventually require Users-owned permissions, not broad Settings update permissions alone.

### Users Setup

Current `/platform/setup/users` is not registered and tests assert it is deprecated.

Target:

- Do not reintroduce a Users setup page just for symmetry.
- Reintroduce Users setup only if it has real setup content, such as first-admin readiness, default lifecycle configuration, invite/enrollment readiness, or initial role policy review.
- If reintroduced, Identity/Users declares a `SetupScreen` UI entry and Setup aggregates it.

## Permission Direction

Current permissions are transitional:

- `platform.users.view`
- `platform.users.manage`

Target Users permissions should be Identity-owned and CRUD-shaped:

- `users.view`
- `users.create`
- `users.update`
- `users.delete`
- `users.activate`
- `users.roles.update`
- `users.security.update`
- `users.settings.view`
- `users.settings.update`
- `users.manage`

`users.manage` should act as the elevated umbrella permission for Users-owned administration.

Migration inputs:

- `platform.users.view` -> `users.view`
- `platform.users.manage` -> `users.manage`

Temporary Gates:

- `view-platform-users` delegates to `users.view` or `users.manage`
- `manage-platform-users` delegates to `users.manage`

Open permission question:

Decide whether `users.roles.update` and `users.security.update` are required immediately, or whether the first package pass keeps role assignment and security administration under `users.update` plus Roles/Auth guardrails.

## Route Direction

Keep browser URLs stable initially:

- `/platform/users`
- `/platform/users/create`
- `/platform/users/{user}/edit`
- `/platform/users/{user}`
- `/platform/users/{user}/toggle-active`
- `/platform/users/{user}/mfa-requirement`
- `/platform/users/{user}/mfa-reset`
- `/platform/administration/users`
- `/platform/settings/users`

Move ownership before changing URLs:

- route definitions move into `app/Core/Identity/Routes/admin-users.php`
- route names may remain compatible during the first pass
- canonical future route names should be reviewed before implementation

Do not introduce route aliases until compatibility tests are planned.

## Data Direction

This planning document does not define canonical schema changes.

Current data surfaces:

- `users`
- `user_contact_emails`, owned by Account for contact-only email metadata
- `user_mfa_methods`, `user_mfa_policies`, `mfa_recovery_codes`, owned by Auth
- Spatie role assignment pivots, owned through Roles package integration
- `settings` rows with `group_key = users`

Potential future Users-owned additions:

- user lifecycle metadata table, if deprovisioning/deletion needs richer state than `users.is_active`
- user invitation/enrollment records, if invite-based onboarding is implemented
- user deletion/deprovision request records, if delete is governed or reversible

DataProtection alignment:

- user email, phone, profile image metadata, contact-only emails, invitation records, and lifecycle history should be classified before broad export or admin reporting surfaces are added
- deactivation should preserve audit subject references while allowing approved anonymization of selected PII
- hard delete should not be the default when audit integrity depends on the identity record
- Identity should not expose user PII through generic exports until DataProtection export and redaction rules exist
- contact-only emails remain communication metadata and must not become authentication identities

Do not add new tables in the first Identity/Users foundation slice unless the behavior requires them.

## Identity Capability Foundation

The first implementation slice should establish Identity-owned Users administration without redesigning access control. It is not the full Users product ambition; lifecycle, invitation, deprovisioning, session administration, and access governance need their own reviewed implementation slices.

Scope:

1. Create Identity capability metadata for Users administration.
2. Move static users manifest ownership from `app/Core/Modules/Definitions.php` to the accepted package/catalog location for `app/Core/Identity`.
3. Declare Users-owned permissions and migration mapping from legacy `platform.users.*`.
4. Move user routes into `app/Core/Identity/Routes/admin-users.php` while preserving current URLs and route behavior.
5. Move privileged user controllers/requests into `app/Core/Identity/Http`.
6. Move `resources/views/platform/users` into `resources/views/admin/users` or Identity-owned views only if view ownership and tests are updated in the same pass.
7. Move user defaults settings behavior from Settings controller/view into Users.
8. Declare user defaults as a Users-owned SettingsPage contribution.
9. Keep role assignment delegated to Roles.
10. Keep MFA/password mechanics delegated to Auth.
11. Keep `App\Models\User` in place.
12. Keep `/platform/setup/users` unregistered unless a real Users setup screen is approved.

## Implementation Sequence

### 1. Plan Users Capability Boundary

Complete this planning pass and follow with owner docs:

- architecture boundary for Users as a core identity lifecycle capability
- feature contract for privileged user administration
- database contract updates only if needed
- route/permission transition plan

### 2. Implement Identity Capability Foundation

Package the current user administration behavior under Identity with minimal behavior change.

Acceptance intent:

- current user-management tests continue passing
- current URLs continue working
- Users permissions are canonical and Identity-owned
- legacy `platform.users.*` assignments migrate
- Settings users defaults are Users-owned contributions
- Account behavior remains unchanged

### 3. Implement Access Control Shell

After Identity has a stable Users administration boundary:

- Access Control can link to Users as a subject owner
- Access Control overview can aggregate user lifecycle/access summaries
- no groups or policies are required yet

### 4. Implement Groups

Use Users-owned subject/query services for group membership.

### 5. Implement Policies

Policies can reference user subjects, group subjects, and Roles-owned role definitions.

### 6. Implement Effective Access

Effective access can safely display on Users-owned user detail surfaces once Users and policy data are stable.

## Delete And Deprovision Planning

Current implementation does not provide privileged user delete.

Before adding delete:

- decide hard delete vs soft delete vs deprovision
- block deleting self
- block deleting or deprovisioning the last effective `users.manage` or `roles.manage` administrator
- preserve audit history
- preserve DataProtection retention and anonymization rules
- decide what happens to notifications, role assignments, contact emails, MFA rows, and future policy/group membership
- require confirmation and reason for destructive deprovisioning

Initial recommendation:

Use deactivate/deprovision first. Add hard delete only if a durable data retention policy requires it.

## Access Control Prerequisites

Access Control needs the Identity capability to provide:

- stable user subject selector
- active/inactive filtering
- user detail route target
- user lifecycle labels
- user permission vocabulary
- safe service boundary for direct assignment transition
- place to render effective access for a user

Therefore:

```text
Identity/Users boundary before Access Control Groups/Policies/EffectiveAccess.
Access Control planning can proceed now.
Access Control shell can start after the Identity/Users foundation is stable.
```

## Test Planning

Expected Identity/Users tests:

- canonical `users.*` permissions are declared
- legacy `platform.users.*` assignments migrate
- `users.manage` satisfies Users CRUD/admin abilities
- current `/platform/users` routes remain compatible
- unauthorized users cannot view or mutate privileged user administration
- create user persists profile/admin fields and password through Auth policy
- update user persists allowed fields
- activation/deactivation guardrails remain enforced
- role assignment still goes through Roles writer and notifications
- password changes still emit Auth-owned notifications
- MFA requirement/reset still delegate to Auth services and enforce step-up
- user defaults settings are rendered from Users-owned settings contribution
- `/platform/setup/users` remains absent unless explicitly reintroduced
- Account self-service routes continue to update only the authenticated user

Physical migration tests should also verify:

- `App\Models\User` remains the authenticatable model
- Identity-owned routes load from `app/Core/Identity/Routes/*`
- privileged user controllers delegate to actions/services instead of holding workflow logic
- Account self-service behavior remains separated from privileged Users administration

## Open Decisions

- Should the canonical owner/package key be `users` or `identity`?
- Should privileged password reset be separated from general user update immediately?
- Which Users CRUD permissions should be first-class in the first package pass?
- Should deprovisioning be a distinct action from delete?
- Should user defaults remain under `/platform/settings/users` or gain a canonical `/settings/users` route when aliases are planned?
- Should a Users setup page return, and what real setup requirement would justify it?
- Which user fields are administrator-managed versus self-service only?
- How should future invite/enrollment flows interact with create-user behavior?
- Which user PII fields can be anonymized during deprovisioning without breaking audit, access, notification, or business record integrity?

## Out Of Scope

- implementing Users in this pass
- implementing Access Control in this pass
- moving `App\Models\User`
- creating a root `Modules/Users` endpoint as the final architecture
- changing current URLs
- adding group or policy tables
- replacing Spatie role assignments
- adding user hard delete before deprovision policy is approved
- editing `/docs/08-active/`

## Related

- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Application Structure Baseline Planning](application-structure-baseline-planning.md)
- [Module Layout Convention Implementation Planning](module-layout-convention-implementation-planning.md)
- [Core Capability Package Migration Planning](core-capability-package-migration-planning.md)
- [Platform Users And RBAC](../04-features/users/platform-users-and-rbac.md)
- [Account Management And Settings](../04-features/account/account-management-and-settings.md)
- [Auth And RBAC Data Contract](../06-database/feature-contracts/auth-and-rbac.md)
