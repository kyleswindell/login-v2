# MFA Implementation Planning

This document defines the canonical scope and intent for MFA Implementation Planning.

## Purpose

Plan the first local MFA implementation substrate for existing platform user accounts without tying the implementation to a temporary pre-alpha rollout policy.

## Implementation Status

Current status:

* planning drafted
* baseline local TOTP MFA enrollment, login challenge, per-user requirement, and administrator reset are implemented
* initial privileged step-up enforcement is implemented for account email/password changes and administrator MFA reset
* TOTP hardening for rate limits, pending setup expiry, reset cleanup, and audit secret-safety is implemented pending targeted Docker validation
* external provider sign-in is not implemented yet
* tenant-scoped MFA policy is not implemented yet

## Initial Scope

The first implementation should deliver:

* local TOTP authenticator-app enrollment for platform users
* login-time MFA challenge before final session issuance when policy requires MFA
* current-session MFA satisfaction tracking
* step-up satisfaction tracking for privileged actions, stored separately from login-time MFA satisfaction
* dedicated account email/password step-up prompts, with successful email/password changes consuming the step-up timestamp during pre-alpha testing
* administrator reset for recovery during pre-alpha testing
* audit events for MFA enrollment, challenge, satisfaction, rejection, requirement update, reset, and recovery-code use
* hashed single-use recovery-code storage with one-time display after successful enrollment
* rate limiting for failed MFA enrollment, login challenge, and step-up attempts
* 15-minute expiry for pending TOTP setup material

## Policy Boundary

MFA requirement evaluation should live behind a dedicated policy or assurance service.

The first implementation may use a simple pre-alpha source for testing, but the service contract must be able to accept later policy inputs:

* per-user MFA requirement
* role-based MFA requirement
* tenant policy requirement
* route, surface, or action step-up requirement
* provider-side assurance result from Microsoft, Google, or another identity provider

The policy result should distinguish at least:

* MFA not required
* enrollment required
* challenge required
* assurance satisfied

## Implementation Sequence

Recommended order:

1. Completed: add MFA data contract and migrations for enrollment state, encrypted TOTP secret material, pending setup state, audit support metadata, and future recovery-code hashes.
2. Completed: add an MFA assurance/policy service that evaluates current per-user policy and session assurance, with extension room for later route/action, tenant, and provider assurance inputs.
3. Completed: add Account suite enrollment flow with setup QR/manual key, TOTP confirmation, and safe audit logging.
4. Completed: add login challenge flow that holds pending authentication context until a required MFA challenge succeeds.
5. Completed: add administrator requirement toggle and reset from platform user management for pre-alpha recovery.
6. Completed: add privileged step-up guard for account email/password changes and administrator MFA reset.
7. Completed: add recovery-code issuance/display after enrollment and one-time recovery-code login challenge use.
8. Implemented pending targeted validation: harden TOTP with MFA attempt throttling, pending setup expiry, reset cleanup, and audit secret-safety tests.
9. Next: add self-service recovery-code regeneration after baseline recovery behavior has stabilized.

## Deferred Scope

Deferred from the first implementation:

* self-service recovery-code regeneration UX
* email or SMS one-time passcodes
* WebAuthn/passkeys
* Microsoft or Google sign-in implementation
* tenant-facing MFA policy administration
* broad production rollout policy decisions

## Related

* [Authentication](../04-features/auth/authentication.md)
* [Auth Core Implementation Planning](auth-core-implementation-planning.md)
* [Account Management And Settings](../04-features/account/account-management-and-settings.md)
* [Platform Users And RBAC](../04-features/users/platform-users-and-rbac.md)
* [MFA Enrollment And Challenge Flow](../05-flows/mfa-enrollment-and-challenge-flow.md)
* [Auth And RBAC Data Contract](../06-database/feature-contracts/auth-and-rbac.md)
* [Identity And Account Security Standards](../02-standards/security/Identity%20And%20Account%20Security%20Standards.md)
