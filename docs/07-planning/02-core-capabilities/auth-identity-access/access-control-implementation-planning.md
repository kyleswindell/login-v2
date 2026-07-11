# Access Control Implementation Planning

Status: Planning draft

## Purpose

Plan the larger Access Control system around the current Roles package without collapsing Roles, Users, Auth, Audit, Monitoring, and Notifications into one oversized owner.

This document owns implementation sequencing and intent only. Final architecture contracts, feature behavior contracts, schema contracts, and runbooks must be promoted to their owning docs before implementation.

## Direction

Use `app/Core/Access` for the governed IAM area, while keeping existing identity, audit, notification, and platform presentation owners independent.

Target logical package direction:

```text
app/Core/Access/
  Overview
  Groups
  Policies
  EffectiveAccess
  ElevatedAccess
  Reviews

app/Core/Auth/
app/Core/Identity/
app/Core/DataProtection/
app/Core/Audit/
app/Core/Notifications/
app/Core/Settings/
app/Platform/
```

Access Control is the area owner and policy-orchestration owner. It is not the owner of every access-adjacent record, and it should not be treated as a business module.

## Current Baseline

Current implemented foundation:

- Users exists as static package metadata and transitional platform user-management routes, but not yet under `app/Core/Identity`.
- `Modules/Roles` currently owns role/action bundles, role metadata, role CRUD, permission catalog visibility, role guardrails, and Spatie role/permission package integration. Target owner is `app/Core/Access`.
- Package manifests declare structured permission definitions with labels, descriptions, group metadata, action metadata, elevated flags, destructive flags, and default role preset intent.
- `permission_registry_entries` projects package-declared permission metadata while Spatie permission tables remain runtime authorization storage.
- `role_metadata` stores role UI and guardrail state.
- User role assignment is still direct user-to-role assignment, but current user-management surfaces call the Roles-owned assignment boundary.
- Roles sends persistent notifications for user role assignment changes.
- Current authorization is global action based. It does not model policy target, resource scope, group inheritance, reason, expiration, approval, or access review state.
- Workspace identity and tenant-local authorization boundaries are not implemented yet.

Current model:

```text
User -> Role -> Permissions
```

Target model:

```text
Subject -> Target -> Role -> Actions
```

Where:

- `Subject` means user, group, and later service account or integration identity. API, webhook, and service-account security direction is tracked in [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md); Access must not let machine actors inherit broad browser-user permissions by default.
- `Target` means global app, workspace, customer, business module, customer plus business module, resource group, environment, or specific resource.
- `Role` means a named bundle of action permissions.
- `Actions` are package-declared permissions and operations.

## Owner Boundaries

### Access Control Owns

- Access Control area shell and overview.
- Group records and group membership initially.
- Access policy builder and access policy records.
- Effective access resolver orchestration.
- Direct-assignment exception handling once direct assignments become policy-backed.
- Access review planning and first implementation.
- Elevated access activation surface coordination.
- Access Control navigation aggregation.

### Roles Owns

- Role CRUD.
- Role metadata and guardrails.
- Permission catalog and permission registry sync.
- Role permission assignment.
- Role presets and default role bootstrap.
- Elevated/destructive role and permission metadata.
- Spatie role/permission integration.

Roles must remain independently bounded during transition. Access Control policies may reference roles, and the eventual physical owner may be `app/Core/Access`, but policy orchestration must not blur role-definition guardrails with policy assignment workflows.

### Users Owns

- Administrator-managed user lifecycle.
- User profile and account state that belongs to the user record.
- User detail surfaces that consume effective access data.
- User status such as active/inactive.

Users may display access data, but it should not own policy evaluation or role definitions.

### Auth Owns

- Authentication.
- Password policy and password changes.
- MFA enrollment, reset, challenge, and step-up.
- Session assurance.
- Re-authentication required by elevated access activation.

Access Control may request `app/Core/Auth` step-up, but Auth remains the authority for session assurance.

### Data Protection Owns

- Data classification.
- Sensitive-field metadata.
- Secure export rules and approval requirements.
- Masking and redaction standards.
- Retention and erasure rules.
- Sensitive data handling metadata consumed by Access Control policies.

Access Control may enforce DataProtection handling rules through permissions, policy constraints, recent-authentication requirements, MFA requirements, export approval requirements, and access reviews. DataProtection remains the owner of data-handling rules.

### Application Security Owns

- Route security tiers.
- Sensitive route classification guardrails.
- Request payload redaction.
- Safe redirect and signed URL validation helpers.
- App-security test and release-check conventions.

Access Control owns authorization decisions. Application Security owns the cross-cutting route/request guardrails that help prove protected Access Control surfaces are not exposed accidentally.

### Audit Owns

- Durable audit and event evidence.
- Audit log views and retention behavior once Audit is promoted.

Access Control should emit audit-worthy events, but Audit owns the evidence store and audit UI.

### Notifications Owns

- Persistent user-addressed notifications.
- Notification type registry and delivery.

Access Control and Roles may trigger notifications for access changes, but Notifications owns inbox state and delivery.

## UI Area Plan

Visible Access Control area:

```text
Access Control
- Overview
- Users
- Groups
- Roles
- Permissions / Actions
- Access Policies
- Elevated Access
- Access Reviews
- Audit Log
```

Screen ownership:

| Screen | Owner | Notes |
| --- | --- | --- |
| Overview | Access Control | Aggregates risk, exceptions, direct assignments, stale reviews, and recent changes. |
| Users | Identity/Users | Consumes effective access summaries from Access Control. |
| Groups | Access Control | First group CRUD and membership surface. |
| Roles | Roles | Existing Roles package surface. |
| Permissions / Actions | Roles | Read-only action catalog from permission registry. |
| Access Policies | Access Control | Subject-target-role assignment builder. |
| Elevated Access | Access Control/Auth boundary | Access Control owns activation UX; Auth owns MFA/step-up/session assurance. |
| Access Reviews | Access Control | Review campaigns, findings, and remediation workflow. |
| Audit Log | Audit | Access Control links into Audit-owned evidence. |

Navigation parent does not imply code ownership. The Access Control area can aggregate links owned by multiple packages.

## Data Direction

This planning document does not define canonical schema. Expected future database contracts should be created in `docs/06-database/` before implementation.

Candidate data surfaces:

- `access_groups`
- `access_group_members`
- `access_policies`
- `access_policy_constraints`
- `access_policy_approvals`
- `elevated_access_sessions`
- `access_review_campaigns`
- `access_review_items`
- `access_review_decisions`

Initial policy records should be able to represent:

```text
subject_type
subject_id
target_type
target_id
role_id
assignment_source
reason
expires_at
requires_approval
status
created_by_user_id
approved_by_user_id
timestamps
```

The exact schema belongs to the future data contract.

Spatie tables should remain the package-backed runtime authorization foundation during transition. Access policies add governance, inheritance, and scope; they should not force an immediate rewrite of Spatie integration.

DataProtection alignment:

- resource targets should be able to reference a data asset or classification when the policy governs sensitive records
- export rights should be modeled separately from view rights
- `view_sensitive` and `export_sensitive` style actions should remain explicit, not implied by generic view/update permissions
- restricted data actions may require Auth-owned recent authentication, MFA, elevated access activation, or approval
- Access Review scope should eventually support reviewing who can view, export, approve, or administer restricted data assets

DLP and exfiltration direction is tracked in [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md). Access decides whether an actor may perform a sensitive movement; DataProtection decides the DLP handling requirement for that movement; Monitoring detects abnormal movement patterns.

## Runtime Direction

The eventual access check shape should support:

```php
$access->for($user)->can('projects.update')->on($project);
```

The shared non-UI resolver contracts may eventually belong under `app/Core/Access` once multiple packages need the same decision engine.

Candidate shared runtime concepts:

- `AccessSubject`
- `AccessTarget`
- `AccessAction`
- `AccessDecision`
- `EffectiveAccessResult`
- `AccessPolicyResolver`
- `AccessTargetResolver`

These are not implementation commitments yet. They are the expected contract family to review before policy-scoped authorization is wired into business modules.

## Implementation Sequence

### 0. Contract Alignment

Before code:

1. Update architecture docs to introduce `app/Core/Access` as the core access capability and policy engine area.
2. Update feature docs to distinguish Roles, Groups, Policies, and Effective Access.
3. Add database contracts for group, policy, and effective-access support tables.
4. Decide route and permission names for Access Control-owned surfaces without adding new `platform.*` permission keys.
5. Plan and package the Users core capability boundary so Access Control has a stable subject owner.
6. Align with DataProtection on the first sensitive data actions, export actions, classification references, and access review scope.
7. Align with Application Security on route tiers, sensitive admin route requirements, no-state-changing-GET checks, and route protection tests.
8. Align with Zero Trust on context-aware access checks, time-bound/elevated access, recent-authentication requirements, and trust-decision outcomes.

### 1. Users Capability Prerequisite

Create the Users capability package foundation before implementing Access Control Groups, Policies, or Effective Access.

Initial prerequisite scope:

- Users-owned package metadata and canonical `users.*` permissions.
- Current user administration routes/controllers/requests owned by Users while preserving URLs.
- User defaults settings declared by Users as a SettingsPage contribution.
- Role assignment still delegated to Roles.
- Password and MFA mechanics still delegated to Auth.
- `App\Models\User` remains shared in place.

This gives Access Control a stable user subject owner, user selector/query boundary, user detail target, and permission vocabulary.

### 2. Access Control Capability Shell

Create `app/Core/Access` as the core access capability.

Initial scope:

- Access Control overview route and blank/summary view.
- Package metadata and navigation contribution.
- Canonical capability-first permissions such as `access.view` and `access.manage` under ADR-0007.
- Links to existing Users, Roles, Permissions, and future Groups/Policies sections.

This step should not change existing role assignment behavior.

### 3. Groups Foundation

Add group records and membership management.

Initial scope:

- group list
- group detail
- create/edit group metadata
- add/remove users
- owner or steward metadata if approved
- no policy enforcement yet beyond preparing inheritance

Groups should be the preferred assignment path, but direct role assignment remains available during transition.

### 4. Access Policy Foundation

Add subject-target-role policy records.

Initial scope:

- subject type: group and direct user
- target type: global/internal workspace only, unless workspace identity is implemented first
- role selection from Roles package
- reason and optional expiration
- active/expired status
- policy detail and review page

This establishes:

```text
Group -> Policy -> Role -> Permissions
User direct exception -> Policy -> Role -> Permissions
```

### 5. Effective Access Resolver

Add a read-only resolver before broad mutation flows depend on it.

Initial questions it must answer:

- Who has access?
- What can they do?
- Where can they do it?
- Why do they have it?
- Did it come from a group, direct exception, or system role?
- Does it expire?

Initial surfaces:

- user effective access tab or panel
- group effective access tab
- role usage detail
- policy effective actions preview

### 6. Direct Assignment Transition

Move direct user role assignment toward policy-backed direct exceptions.

Transition rule:

- Existing direct Spatie role assignments remain compatible.
- New direct assignment UX should require reason and optional expiration once policy-backed direct exceptions exist.
- Direct user assignments should be visually tagged as exceptions.
- Group assignments should be the default path.

The target should be:

```text
Direct user assignment = Access policy with subject_type=user
Group assignment = Access policy with subject_type=group
```

### 7. Scoped Targets

Introduce target scopes only after the target owners exist.

Recommended order:

1. global/internal workspace
2. business module
3. customer
4. customer plus business module
5. resource group
6. specific resource
7. environment/location if a real business module needs it

Do not fake customer, project, or resource scopes before those domain records exist.

### 8. Elevated Access Activation

Add elevated access activation after policy assignment and effective access are stable.

Activation intent:

- user has assigned elevated role or policy
- user chooses to activate
- Auth-owned step-up/MFA is required
- reason is required
- session duration is explicit
- elevated session state is visible in the app shell
- elevated actions are audit-worthy

This replaces silently active elevated privileges for flows that require just-in-time elevation.

### 9. Separation Of Duties

Add conflict rules after policies and effective access exist.

Initial rule types:

- user cannot request and approve the same workflow
- user cannot approve their own elevated access
- user cannot assign themselves higher access without approval
- user cannot hold conflicting finance, billing, or security roles for the same target

Hard conflicts should block save. Soft conflicts may warn and require review.

### 10. Access Reviews

Add access reviews after groups, policies, and effective access are stable.

Initial review targets:

- direct exceptions
- elevated roles
- expired or soon-expiring policies
- users with broad/global access
- groups without owners
- roles with no members
- policies without recent review

Reviews should consume effective access data rather than recomputing their own access model.

## Transition Rules

- Do not make Roles a child surface that loses its role-definition guardrails.
- Do not move existing Roles code into `app/Core/Access` until a scoped migration batch owns compatibility, routes, views, and tests.
- Do not make Access Control own Auth, Identity/Users, Audit, or Notifications records.
- Do not add new `platform.*` permission keys.
- Keep current URLs stable until route aliases and compatibility tests are planned.
- Do not add scoped policy checks to business modules before target resolution exists.
- Do not make database rows define executable route, view, or permission behavior.
- Keep `super_admin` global bypass until a replacement elevation and break-glass model is explicitly designed.
- Keep existing Spatie-backed checks working while policy-scoped authorization is introduced incrementally.

## Suggested Permissions

Final permission vocabulary must be reviewed before implementation.

Potential Access Control permissions:

- `access.view`
- `access.groups.view`
- `access.groups.create`
- `access.groups.update`
- `access.groups.delete`
- `access.policies.view`
- `access.policies.create`
- `access.policies.update`
- `access.policies.delete`
- `access.elevated.view`
- `access.elevated.activate`
- `access.reviews.view`
- `access.reviews.manage`
- `access.manage`

ADR-0007 resolves the namespace as `access.*`. Runtime permission migration remains a separate implementation issue.

## Test Planning

Expected tests by phase:

- package metadata and route ownership for Access Control
- no new `platform.*` permissions
- Access Control overview navigation aggregates package-owned child entries
- groups can be created, updated, assigned members, and removed when safe
- group membership does not directly mutate role definitions
- policies reference Roles-owned roles
- policy preview shows final effective actions before save
- effective access resolver explains source, role, action, target, and expiration
- direct assignments are tagged as exceptions
- expired policies stop contributing effective access
- elevated activation requires Auth-owned step-up
- separation-of-duties hard conflicts block save
- access reviews consume effective access output
- existing Roles tests continue passing
- existing user role assignment compatibility remains intact during transition

## Open Decisions

- Should the owner/package key be `access-control` or `access`?
- Should group ownership/stewardship be required at creation?
- Which target types are allowed before workspace identity is implemented?
- How long should direct assignment compatibility remain visible?
- Should direct user assignment require expiration immediately, or only for elevated/global access?
- Which elevated roles require activation instead of being active for the full session?
- What is the first separation-of-duties rule worth enforcing?
- Which DataProtection classification/export policy contract must exist before resource-scoped access policies govern sensitive business data?
- Which Audit promotion milestone must land before access audit history becomes a first-class page?

## Immediate Next Planning Step

Create or update the canonical owner docs before implementation:

1. Architecture: Access Control capability boundary and access engine relationship.
2. Planning: Users capability boundary and package foundation implementation.
3. Features: Access Control area behavior, groups, policies, effective access, elevated access, and reviews.
4. Database: group, policy, elevated session, and review table contracts.
5. Planning: first implementation batch slicing for Identity/Users foundation, then Access Control shell plus Groups foundation.

## Out Of Scope

- implementing Access Control in this pass
- changing existing Roles behavior
- migrating direct Spatie assignments
- adding customer/project/resource scoped checks
- replacing the global `super_admin` bypass
- implementing Audit package promotion
- editing `/docs/08-active/`

## Related

- [Application Structure Baseline Planning](application-structure-baseline-planning.md)
- [Zero Trust Security Planning](zero-trust-security-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Service Accounts And Machine Identity Planning](service-accounts-machine-identity-planning.md)
- [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md)
- [Core Capability Package Migration Planning](core-capability-package-migration-planning.md)
- [Module Layout Convention Implementation Planning](module-layout-convention-implementation-planning.md)
- [Registry, App Instance, Workspace, And Module Vocabulary Planning](registry-instance-workspace-module-vocabulary-planning.md)
- [Workspace Identity Implementation Planning](workspace-identity-implementation-planning.md)
- [Platform Users And RBAC](../04-features/users/platform-users-and-rbac.md)
- [Auth And RBAC Data Contract](../06-database/feature-contracts/auth-and-rbac.md)
