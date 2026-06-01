# Document Review 0031

## Review Pass
3

## Target
`docs/02-standards/security/Security Standards.md`, `docs/03-architecture/auth.md`, `docs/04-features/auth/authentication.md`, and `docs/05-flows/customer-access-and-oauth-flow.md`

## Review Type
Document Review

## Status
CLOSED

## Purpose
Establish a canonical baseline for external identity, OAuth account linking, MFA enforcement boundaries, and production secret-handling expectations before Phase 3 OAuth implementation begins.

## Scope
- `docs/02-standards/index.md`
- `docs/02-standards/security/Security Standards.md`
- `docs/02-standards/security/Identity And Account Security Standards.md`
- `docs/03-architecture/auth.md`
- `docs/04-features/auth/authentication.md`
- `docs/05-flows/customer-access-and-oauth-flow.md`
- `docs/11-ai/active-doc-reviews/index.md`
- `docs/11-ai/active-doc-reviews/doc-review-0031.md`

## Findings

### Finding 1
- type: external-identity-standards-gap
- location: `docs/02-standards/security/Security Standards.md`
- issue: The current security standards prohibit hardcoded secrets and cover generic input/output handling, but they do not define baseline rules for OAuth/OIDC flow selection, external identity trust boundaries, account linking, invitation-only enforcement, or production secret storage for third-party integrations.
- required action: Add a dedicated canonical security standards document for identity and account security, then link it from the standards index and the general security standards page.
- constraints: Keep standards ownership limited to rules only. Do not move feature behavior or flow sequencing into the standards branch.
- decision state: resolved

### Finding 2
- type: mfa-assurance-boundary-gap
- location: `docs/03-architecture/auth.md`, `docs/04-features/auth/authentication.md`
- issue: The current architecture and feature docs do not state clearly enough that federated sign-in does not automatically inherit MFA assurance, and they do not define how tenant-scoped Entra requirements, local MFA, and privileged step-up should relate to one another.
- required action: Update auth architecture and authentication feature docs so MFA assurance is treated as an explicit requirement to validate or enforce, not an automatic property of using Microsoft or Google as an identity provider.
- constraints: Keep architecture focused on boundaries and responsibility separation, and keep feature docs focused on behavioral expectations rather than low-level implementation detail.
- decision state: resolved

### Finding 3
- type: account-linking-and-enrollment-gap
- location: `docs/05-flows/customer-access-and-oauth-flow.md`
- issue: The planned OAuth flow names provider selection and tenant access-mode controls, but it does not define the high-risk decision points that govern invitation-only enrollment, external-account linking, email-match handling, tenant allowlists, or rejection paths when MFA/policy requirements are not met.
- required action: Expand the planned customer OAuth flow so it reflects enterprise-safe account creation and linking rules, including explicit rejection of automatic email-only linking and explicit enforcement of tenant/provider policy before session issuance.
- constraints: Keep this branch focused on ordered execution flow only. Do not introduce schema contracts or planning backlog content here.
- decision state: resolved

## Summary
- The repo already has a sound Phase 3 planning direction for Google and Microsoft sign-in, tenant access modes, and customer-company membership.
- The main canonical gap is not planning scope but security baseline clarity: the current docs do not yet define what must be true before an OAuth sign-in is allowed to create or link a local account.
- MFA enforcement needs to be documented as an assurance boundary. A Microsoft or Google login is not enough by itself for enterprise-grade claims unless the app requires and validates the right provider-side signals or adds local MFA.

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- the standards branch defines a canonical baseline for external identity, account linking, MFA assurance, and secret storage
- auth architecture states that federated login and MFA assurance are separate concerns
- the authentication feature doc reflects current state and planned assurance boundaries without overstating implementation status
- the customer OAuth flow documents enterprise-safe linking, enrollment, and rejection paths

## Resolution Notes
- Added `docs/02-standards/security/Identity And Account Security Standards.md` and linked it from the standards index and general security standards page so external identity, MFA assurance, account linking, and production credential handling now have a canonical rules home.
- Updated `docs/03-architecture/auth.md` so the auth boundary now distinguishes provider authentication from local authorization, treats MFA assurance as a separate requirement, and allows policy-bound Microsoft Entra tenant restrictions.
- Updated `docs/04-features/auth/authentication.md` so the current implemented baseline remains accurate while the planned security expansion notes now define the expected behavior for federated sign-in, invitation-only operation, account linking, Entra tenant restriction, and step-up requirements.
- Expanded `docs/05-flows/customer-access-and-oauth-flow.md` so the planned flow now includes tenant/provider policy checks, Entra tenant restriction, assurance validation, explicit anti-auto-linking behavior, gated account creation, and auditable rejection paths.
- Re-review found no remaining branch-ownership drift in the scoped standards, architecture, feature, or flow updates.
