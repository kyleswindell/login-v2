# Authentication

This document defines the canonical scope and intent for Authentication.

## Purpose

Describe the current platform authentication baseline and its immediate Phase 1 boundaries.

## Implementation Status

Current status:

* implemented in code
* deployed on staging
* login and logout UI exist
* password reset and broader account recovery flows are still pending

## Current Scope

App 2.0 starts with a minimal first-party sign-in and sign-out flow.

Implemented routes:

* `GET /login`
* `POST /login`
* `GET /dashboard`
* `POST /logout`

Implemented Laravel pieces:

* `App\Http\Controllers\Auth\LoginController`
* `App\Http\Requests\Auth\LoginRequest`
* guest middleware around login routes
* auth middleware around dashboard/logout routes

Related docs:

* [Event And Error Logging](../logging/event-and-error-logging.md)
* [Logging Standards](../../02-standards/logging/Logging%20Standards.md)
* [Commenting Standards](../../02-standards/coding/Commenting%20Standards.md)
* [Auth And RBAC Data Contract](../../06-database/feature-contracts/auth-and-rbac.md)

## Current Behavior

* Guests can view the login form.
* Guests are redirected to `/login` if they request `/dashboard`.
* Authenticated users are redirected away from `/login`.
* Authenticated users can view the dashboard.
* Successful login regenerates the session.
* Logout invalidates the session and regenerates the CSRF token.
* Login success, login failure, and logout write platform audit events.
* Failed login attempts for an existing user email record that user as the audit-log subject while the actor remains unauthenticated/system context.
* Login validation is handled by a dedicated form request instead of inline controller rules.

## Near-Term Notes

This is intentionally not a full user-management or password-reset system yet. Filament panel authentication and tenant-specific authentication should be added after the platform/tenant boundary is clearer.

## Planned Security Baseline For Future Expansion

When OAuth, customer access, and tenant-facing sign-in are added, the baseline behavior should remain:

* federated sign-in is not enough by itself to grant authorization
* external identities must resolve through tenant policy, local account state, and company membership checks before session issuance
* matching email alone must not auto-link an external provider to an existing account
* enterprise tenants must be able to stay invitation-only even when external providers are enabled
* Microsoft work-account sign-in may be restricted to a specific connected Microsoft Entra tenant where tenant policy requires it
* MFA must be explicitly required or validated for protected surfaces; using Microsoft or Google as the sign-in provider does not by itself guarantee MFA
* privileged surfaces and privileged actions should support step-up authentication

## Related Security Standards

* [Identity And Account Security Standards](../../02-standards/security/Identity%20And%20Account%20Security%20Standards.md)

## Related

* [Features Index](../index.md)
* [Auth Architecture](../../03-architecture/auth.md)
* [Security Standards](../../02-standards/security/Security%20Standards.md)
