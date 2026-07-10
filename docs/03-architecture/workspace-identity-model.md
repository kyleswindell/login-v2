# Workspace Identity Model

This document defines the canonical architecture contract for workspace identity.

## Purpose

Define the runtime identity used by workspace-scoped capabilities before route aliases, context-aware navigation, tenant registry, tenant database switching, or shared business modules are implemented.

## Workspace Identity

`workspace_identity` is the active identity for workspace-scoped runtime capabilities.

Workspace-scoped capabilities include workspace users, roles, settings, enabled modules, notifications, audit history, dashboards, and future business modules such as customers, projects, tasks, and tracking.

The `control_plane` context does not have a workspace runtime identity. It may access workspace data only through explicit Direct Control workflows.

## Workspace Types

| Type | Owner | Purpose |
| --- | --- | --- |
| `internal_workspace` | Parasolutions | Parasolutions' own operational workspace for shared business modules and workspace-local operations |
| `tenant_workspace` | Client tenant | Client-owned workspace runtime for shared business modules with tenant-local data boundaries |

The default Parasolutions internal workspace identity is:

| Attribute | Value |
| --- | --- |
| key | `parasolutions` |
| type | `internal_workspace` |
| display name | `Parasolutions` |
| status | `active` |

This default identity remains an architecture target. It is not implemented as runtime schema or seeded database data.

The current runtime proof is intentionally smaller: the app resolves the current request to a generic Parasolutions runtime context with key `parasolutions`, name `Parasolutions`, and the current request or app URL. It does not claim workspace identity, tenant identity, tenant isolation, or database switching.

## Required Identity Attributes

A workspace identity must define:

- key
- type
- display name
- owner
- lifecycle status
- database boundary
- module-state scope
- settings scope
- user/RBAC scope
- notification scope
- audit scope

These attributes are architecture concepts. This document does not define database columns or migrations.

## Boundary Rules

Workspace-local users, roles, settings, module state, notifications, audit history, dashboards, and business records must resolve through the active workspace identity once runtime context resolution exists.

`internal_workspace` and `tenant_workspace` should use the same shared workspace module model. Platform-management modules remain excluded from workspace runtime by default.

The control plane must not silently use the internal workspace identity. Control-plane access into workspace data must preserve both the control-plane actor and the target workspace identity.

## Current Runtime State

Workspace identity runtime resolution is not implemented yet.

The current installed app URL resolves only to a generic Parasolutions runtime context. That proof exists to keep request-context naming generic while the app remains a single configured workspace backed by the current database.

Current `/dashboard`, `/account/*`, and `/platform/*` routes remain stable. No visible `control_plane` route layer exists yet. Route aliases, context-aware navigation, tenant registry, and tenant database switching remain future work.

## Related

- [Platform Context Model](platform-context-model.md)
- [Platform Boundary](platform-boundary.md)
- [Tenancy](tenancy.md)
- [Platform Context Route Reorganization Planning](../07-planning/platform-context-route-reorganization-planning.md)
- [Workspace Identity Implementation Planning](../07-planning/workspace-identity-implementation-planning.md)
