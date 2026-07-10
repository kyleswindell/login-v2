# Workspace Identity Implementation Planning

Status: Superseded
## Supersession Notice

ADR-0006 supersedes the persistent workspace-identity and three-context assumptions in this plan. Workspace is now a User Account-specific runtime resolution, not a stored identity or data boundary. Any future runtime implementation must be replanned from ADR-0006.

## Purpose

Sequence implementation of workspace identity after the three-context model and before route aliases, context-aware navigation, tenant registry, tenant database switching, or shared business modules.

This planning note does not add schema, routes, config, UI, tenant registry, or tenant database switching.

## Default Direction

The current runtime proof is a generic Parasolutions runtime context:

- key: `parasolutions`
- name: `Parasolutions`
- url: current request URL or configured app URL

This proof is not workspace identity. It exists only so current request-context code has neutral naming while the app remains a single configured workspace.

Current `/dashboard`, `/account/*`, and `/platform/*` routes remain stable until workspace identity, aliases, and tests are planned.

Business modules such as customers, projects, tasks, and tracking must wait until workspace identity is available.

## Implementation Sequence

1. Canonical docs contract. Implemented.
2. Generic Parasolutions runtime context proof. Implemented.
3. Workspace identity proof. Deferred until the app needs an actual workspace identity boundary.
4. Route alias plan.
5. Context-aware navigation plan.
6. Tenant registry and database contract.
7. Tenant database switching.

## Guardrails

- Do not implement tenant database switching before the workspace identity resolver exists.
- Do not build shared business modules as control-plane tools.
- Do not expose platform-management modules through workspace identity.
- Do not treat the generic Parasolutions runtime context proof as workspace identity or tenant isolation.
- Do not move current routes before alias and authorization coverage exists.

## Related

- [Workspace Identity Model](../03-architecture/workspace-identity-model.md)
- [Platform Context Model](../03-architecture/platform-context-model.md)
- [Platform Context Route Reorganization Planning](platform-context-route-reorganization-planning.md)
