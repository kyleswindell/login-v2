# Document Review 0029

## Review Pass
3

## Target
Current platform RBAC suitability for least-privilege read-only review access across admin and super-admin surfaces used during staging review

## Review Type
Document Review

## Status
CLOSED

## Purpose
Determine whether the current role and permission model can safely support AI-agent or internal reviewer access to admin-level review surfaces without granting write-capable super-admin authority, and identify the minimum structural changes needed if it cannot.

## Scope
- `database/seeders/PlatformRolesAndPermissionsSeeder.php`
- `app/Providers/AppServiceProvider.php`
- `app/Platform/Navigation/PlatformNavigation.php`
- `app/Http/Controllers/Platform/PlatformUserController.php`
- `app/Http/Controllers/Platform/SettingsController.php`
- `app/Http/Controllers/Platform/UiReferenceController.php`
- `app/Http/Controllers/Platform/PlatformSetupController.php`
- `app/Models/User.php`
- `routes/web.php`
- `tests/Feature/Auth/AuthorizationTest.php`
- `tests/Feature/Platform/PlatformUserManagementTest.php`
- `tests/Feature/Platform/PlatformSettingsTest.php`
- `tests/Feature/Platform/PlatformUiReferenceTest.php`
- `tests/Feature/Platform/DocsRepositoryViewerTest.php`
- `tests/Feature/Platform/PlatformSetupPagesTest.php`
- `docs/04-features/users/platform-users-and-rbac.md`
- `docs/04-features/workspace/platform-workspace-and-documentation-vault.md`
- `docs/07-planning/phases/phase-1/Auth And Authorization Foundation.md`

## Findings

### Finding 1
- type: coarse-read-write-permission-collapsing
- location: `database/seeders/PlatformRolesAndPermissionsSeeder.php`, `app/Providers/AppServiceProvider.php`, `app/Http/Controllers/Platform/SettingsController.php`, `app/Http/Controllers/Platform/PlatformUserController.php`
- issue: The current permission catalog is too coarse for least-privilege review access. Platform users and settings each expose only one capability, `platform.users.manage` and `platform.settings.manage`, and both the GET and POST surfaces are tied to those same manage gates. That means any account allowed to inspect settings or user-management surfaces is automatically granted write-capable authority.
- required action: Split read and write capabilities for the admin surfaces that need review access. At minimum, introduce `platform.users.view` and `platform.settings.view`, use them on read-only index/detail/setup surfaces, and reserve `*.manage` for state-changing routes only.
- constraints: Preserve the existing super-admin bypass. Keep write routes explicitly gated behind `manage` abilities and do not let a new reviewer role inherit mutation paths accidentally.
- decision state: resolved

### Finding 2
- type: ui-reference-hard-coded-to-role-not-permission
- location: `app/Http/Controllers/Platform/UiReferenceController.php`, `app/Platform/Navigation/PlatformNavigation.php`, `tests/Feature/Platform/PlatformUiReferenceTest.php`, `docs/04-features/workspace/platform-workspace-and-documentation-vault.md`
- issue: The UI Reference workspace is currently guarded by a hard-coded `platform_super_admin` role check in both navigation and controller logic. This bypasses the permission model entirely and prevents a least-privilege review account from using the canonical proof surfaces unless it is elevated to super admin.
- required action: Replace the hard-coded role requirement with an explicit permission-backed gate, such as `platform.ui-reference.view`, and keep the surface limited to trusted internal reviewers by role assignment rather than by super-admin-only code.
- constraints: Preserve the current restriction that ordinary platform staff should not see the proof workspace by default. Do not collapse UI Reference into the broader docs-vault permission, because the proof workspace is a separate review surface.
- decision state: resolved

### Finding 3
- type: missing-functional-reviewer-role
- location: `database/seeders/PlatformRolesAndPermissionsSeeder.php`, `docs/04-features/users/platform-users-and-rbac.md`, `docs/07-planning/phases/phase-1/Auth And Authorization Foundation.md`
- issue: The current role set only offers `platform_super_admin`, `platform_admin`, and `platform_operator`. None of those represent a pure internal reviewer. `platform_admin` currently inherits all seeded permissions, including user and settings management, while `platform_operator` is too narrow for staging review of admin surfaces.
- required action: Add a dedicated least-privilege internal review role, preferably named by responsibility rather than by implementation consumer. A name like `platform_reviewer` is preferable to an AI-specific role name because both humans and agents can use it. Seed it with read-only review permissions only.
- recommended permission set:
  - `platform.docs.view`
  - `platform.notifications.view`
  - `platform.audit-logs.view`
  - `platform.error-logs.view`
  - `platform.users.view`
  - `platform.settings.view`
  - `platform.ui-reference.view`
- constraints: Do not use `platform_super_admin` for AI review accounts. Do not create an `ai_agent` role that encodes an execution mechanism rather than an authorization responsibility.
- decision state: resolved

### Finding 4
- type: review-surface-routing-and-navigation-need-view-manage-split
- location: `routes/web.php`, `app/Platform/Navigation/PlatformNavigation.php`, `app/Http/Controllers/Platform/PlatformSetupController.php`, `app/Models/User.php`
- issue: Even if the new permissions exist, the current route and navigation model still assumes that settings and user-management access is always manage-capable. Setup pages such as `/platform/setup/users` also inherit `manage-platform-users`, which blocks reviewer access to the related read-only setup guidance. Console-panel access is likewise tied to a narrow set of current permissions and would need intentional review of whether the reviewer should access any proof-only panel surfaces.
- required action: Re-map the read-only admin surfaces to view gates, keep create/edit/update/toggle endpoints under manage gates, and decide explicitly which setup pages belong in the reviewer role. Review console-panel access separately; do not grant it implicitly unless a reviewer genuinely needs those panel-only proof surfaces.
- constraints: Keep route ownership stable. Do not widen console access beyond what the review workflow actually requires.
- decision state: resolved

## Summary
- The current staging account behavior is explained by the current RBAC model, not by a misconfigured user. The implementation is intentionally coarse: settings and users are manage-only, while UI Reference is super-admin-only.
- That model is not suitable for AI-agent review access if the goal is least privilege.
- The project already points toward the cleaner direction. The Phase 1 auth planning note recommends `platform.users.view` naming, and the existing docs/logs/notifications surfaces already use `*.view` permissions successfully.
- The correct fix is not to mint an AI-specific super-admin account. The correct fix is to introduce a reviewer-class role plus the missing `view` permissions and route/gate splits for the admin review surfaces.

## Unresolved Decisions
- whether settings review should remain one broad `platform.settings.view` permission or eventually split into narrower read-only settings domains
- whether `/platform/setup/users` should be available to reviewers by `platform.users.view` or remain a manage-only onboarding surface
- whether any console-proof surfaces should be visible to the reviewer role, or whether the app-owned routes and UI Reference pages are sufficient

## Implementation Status
implemented

## Exit Criteria
- the project has an explicit decision on whether to add a dedicated reviewer role for least-privilege internal review access
- the missing view/manage split is identified for platform users, platform settings, and UI Reference
- the recommendation is documented clearly enough that a future implementation pass can update the seeder, gates, routes, navigation, and tests without inventing policy on the fly

## Resolution Notes
- Added a dedicated `platform_reviewer` role plus explicit `platform.users.view`, `platform.settings.view`, and `platform.ui-reference.view` permissions in the RBAC seed.
- Split the read-only and write-capable gates so settings and users no longer require write permissions just to render review surfaces.
- Replaced the UI Reference hard-coded super-admin check with a permission-backed gate and navigation entry.
- Updated the scoped feature and planning docs so the new reviewer model and permission vocabulary are canonical.
- Added feature coverage proving that the reviewer role can access the intended GET review surfaces while remaining blocked from state-changing settings and user-management flows.
- Re-review passed after the scoped auth and platform feature suite confirmed reviewer read access and write-path denial behavior.
