# Customer Access And OAuth Flow

This document defines the canonical scope and intent for Customer Access And OAuth Flow.

Status: Planned (not implemented)

## Purpose

Define the planned customer/staff sign-in execution path with tenant access-mode controls.

## Inputs

- tenant access mode (`disabled`, `invite_only`, `open_enrollment`)
- sign-in surface (customer or staff)
- provider selection (local, Google, Microsoft)
- tenant provider policy and allowed sign-in surfaces
- optional tenant restriction for Microsoft Entra work-account sign-in
- required assurance level for the requested surface or action
- invitation, pre-created account, or approved enrollment context when account creation is gated

## Flow

1. User opens the planned tenant sign-in surface.
2. System resolves tenant boundary, tenant access mode, and allowed sign-in surfaces.
3. System checks the selected provider is globally allowed, tenant-enabled, and permitted for the requested surface.
4. If tenant policy requires Microsoft work-account restriction, system limits the allowed Microsoft identity boundary to the connected Microsoft Entra tenant that the policy allows.
5. User authenticates using local credentials or the selected OAuth provider.
6. System validates the callback, provider identity, replay protections, and required assurance level before any local session is issued.
7. System resolves the external identity using stable provider identity claims rather than email alone.
8. If a linked local account already exists, system continues with local account-state checks.
9. If no linked account exists but an existing local account has a matching email, system requires an explicit invitation, authenticated linking action, or other approved proof path before linking; system must not auto-link on email alone.
10. If no linked account exists and no approved linking path is available, system checks whether tenant access mode and provider policy allow account creation for this surface.
11. If account creation is not allowed, required invitation context is missing, tenant restriction fails, or required assurance is missing, system rejects access with no tenant session elevation.
12. If account creation is allowed, system creates or activates the allowed local account and membership within the tenant policy envelope.
13. System resolves customer company membership and role.
14. System enforces tenant boundary, membership, ownership, module policy, and visibility checks.
15. System creates a tenant session, records auditable identity and policy-decision events, and routes the user to the authorized destination.

## Outputs

- authenticated tenant session for authorized user
- rejected access when access mode, provider policy, tenant restriction, assurance requirement, invitation policy, or ownership checks fail
- auditable sign-in, linking, rejection, and visibility enforcement events

## Related

- [Authentication](../04-features/auth/authentication.md)
- [Identity And Account Security Standards](../02-standards/security/Identity%20And%20Account%20Security%20Standards.md)
- [OAuth And Customer Access Mode Planning](../07-planning/phases/phase-3/Phase 3 - OAuth And Customer Access Mode Planning.md)
