# Platform Context Route Reorganization Planning

Status: Superseded
## Supersession Notice

ADR-0006 supersedes the `control_plane`, `internal_workspace`, and `tenant_workspace` runtime-context model. Global Administration is an authorized Surface within Internal Tenant Workspaces. Route migration remains deferred and must be replanned from the accepted vocabulary.

## Purpose

Sequence the route and capability reorganization needed after adopting the three-context model:

- `control_plane`
- `internal_workspace`
- `tenant_workspace`

This planning note does not move routes or change runtime behavior. It records the map that should guide later implementation.

## Default Direction

Current `/dashboard`, `/account/*`, and `/platform/*` routes remain stable until aliases, context ownership, and tests are planned.

Shared business modules such as customers, projects, tasks, and tracking should be built as shared workspace modules, not platform-control-plane tools.

Platform-management tools remain control-plane-only by default.

## Route And Capability Classification

| Current route family | Classification | Target direction |
| --- | --- | --- |
| `/dashboard` | `shared_workspace_candidate`, `transitional_platform_route` | Keep current route for now; later render dashboard content by active context. |
| `/account/*` | `shared_workspace_candidate` | Keep current route for now; later bind account settings and MFA to active authenticated context. |
| `/platform/users/*` | `shared_workspace_candidate`, `tenant_workspace_candidate`, `transitional_platform_route` | Split control-plane user administration from workspace user administration after workspace identity exists. |
| `/platform/settings/*` | `control_plane_only`, `shared_workspace_candidate`, `tenant_workspace_candidate`, `transitional_platform_route`, `docs_mismatch` | Classify each settings page before redesign; workspace settings and control-plane settings should be separate capabilities. |
| `/platform/setup/*` | `control_plane_only`, `shared_workspace_candidate`, `transitional_platform_route` | Keep setup separate from settings; classify setup pages before any navigation changes. |
| `/platform/notifications` | `shared_workspace_candidate`, `tenant_workspace_candidate`, `transitional_platform_route` | Treat notification inbox as workspace behavior; runtime navigation should be owned by the notification bell. |
| `/platform/audit-logs` | `control_plane_only`, `shared_workspace_candidate` | Tenant/workspace-local audit history is workspace behavior; cross-context audit visibility is control-plane behavior. |
| `/platform/error-logs` | `control_plane_only` | Keep central runtime error visibility in the control plane until tenant-local operational visibility is designed. |
| `/platform/docs` | `control_plane_only` | Keep internal documentation vault control-plane-only unless explicitly reclassified later. |
| `/platform/security` | `control_plane_only` | Keep security checklist and readiness evidence control-plane-only. |
| `retired reference viewer routes` | `control_plane_only`, `transitional_platform_route` | Keep retired reference viewer internal/control-plane-only for runtime access; module-package ownership may still be pursued without tenant exposure. |

## Implementation Sequence

1. Define the workspace identity contract for `internal_workspace` and `tenant_workspace`.
   - First runtime proof should be a static Parasolutions internal workspace identity before route aliases or tenant registry work.
2. Define route aliases and target route names while preserving current `/platform/*` behavior.
3. Add context-aware navigation rules for header actions, app sidebar, account menu, settings navigation, setup navigation, and module navigation.
4. Define Direct Control contracts for control-plane access into workspace data.
5. Define tenant registry feature and database contracts.
6. Plan shared business modules after the workspace identity and route direction are stable.

## Guardrails

- Do not move current routes before aliases and tests exist.
- Do not move current views before route ownership and module ownership agree.
- Do not treat `platform.*` route names as proof that a capability is control-plane-only.
- Do not treat module tenant eligibility metadata as runtime enforcement.
- Do not expose platform-management modules to tenant workspaces by default.

## Related

- [Platform Context Model](../03-architecture/platform-context-model.md)
- [Workspace Identity Model](../03-architecture/workspace-identity-model.md)
- [Platform Boundary](../03-architecture/platform-boundary.md)
- [Workspace Identity Implementation Planning](workspace-identity-implementation-planning.md)
- [Module System](../03-architecture/module-system.md)
