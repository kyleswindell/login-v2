# Customer Access And OAuth Flow

This document defines the canonical scope and intent for Customer Access And OAuth Flow.

Status: Planned (not implemented)

## Purpose

Define the planned customer/staff sign-in execution path with tenant access-mode controls.

## Inputs

- tenant access mode (`disabled`, `invite_only`, `open_enrollment`)
- sign-in surface (customer or staff)
- provider selection (local, Google, Microsoft)

## Flow

1. User opens the planned tenant sign-in surface.
2. System checks tenant access mode and allowed sign-in surfaces.
3. System checks the selected provider is globally allowed and tenant-enabled.
4. User authenticates using local credentials or the selected OAuth provider.
5. System resolves customer company membership and role.
6. System enforces membership, ownership, and visibility checks.
7. System creates a tenant session and routes the user to the authorized destination.

## Outputs

- authenticated tenant session for authorized user
- rejected access when mode/provider/ownership checks fail
- auditable sign-in and visibility enforcement events

## Related

- [Authentication](../04-features/auth/authentication.md)
- [OAuth And Customer Access Mode Planning](../07-planning/phases/phase-3/Phase 3 - OAuth And Customer Access Mode Planning.md)
