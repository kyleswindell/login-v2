<!--
DOC-META
title: Identity And Account Security Standards
doc_type: standard
status: draft
owner: security
canonical: true
canonical_path: docs/02-standards/security/Identity And Account Security Standards.md
parent: docs/02-standards/security/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines authentication, password, MFA, recovery, federation, account-linking, assurance, and identity-abuse requirements.
-->

# Identity And Account Security Standards

Parent: [Security Standards Index](index.md)
- [1. Purpose](#1-purpose)
- [2. Ownership Boundary](#2-ownership-boundary)
- [3. Login](#3-login)
- [4. Passwords](#4-passwords)
- [5. MFA](#5-mfa)
- [6. Recovery](#6-recovery)
- [7. Recent Authentication And Step-Up](#7-recent-authentication-and-step-up)
- [8. External Identity](#8-external-identity)
- [9. Account Linking](#9-account-linking)
- [10. Enterprise Identity](#10-enterprise-identity)
- [11. Suspicious Authentication](#11-suspicious-authentication)
- [12. Session Coordination](#12-session-coordination)
- [13. Verification](#13-verification)
- [14. Related](#14-related)

## 1. Purpose

Define the security baseline for proving identity, establishing authenticated sessions, enrolling and recovering factors, linking external identities, and defending account surfaces from abuse.

## 2. Ownership Boundary

- Auth owns login, passwords, MFA, recovery, sessions, recent authentication, and future federation.
- Users owns human User Account lifecycle, Invitations, primary identity/profile state, activation, suspension, and deactivation.
- Access owns authorization after authentication succeeds.
- Account or other Product presentation may own self-service entry points while calling Auth and Users public boundaries.

MFA does not grant permission.

Authentication assurance and authorization remain separate.

## 3. Login

Login must:

- rate-limit by account-oriented and network-oriented dimensions
- avoid user-enumeration responses
- block non-loginable Users-owned account states
- rotate the session identifier after successful authentication
- require MFA before full session issuance when policy requires it
- record safe success, failure, throttle, and rejection evidence
- never log submitted credentials or factors

## 4. Passwords

Local password rules must:

- use the shared password policy
- require at least 12 characters
- allow at least 64 characters
- avoid arbitrary composition rules
- reject approved common and context-specific values
- use a memory-hard password hashing algorithm supported by the framework
- separate breached-password checking behind an Auth-owned boundary
- never send the raw password or full hash to an external provider
- never log provider payloads or matching password-derived material

Production breached-password checking is enforced for human-supplied passwords when they are established or changed, including:

- Invitation acceptance
- required first-login password replacement
- self-service password change
- password reset
- administrator-supplied temporary passwords

An Auth-generated cryptographically high-entropy temporary password does not require breached-human-password checking.

Ordinary login verification does not perform breached-password lookup.

When production breached-password checking is enforced and the checker is unavailable, password establishment or change fails closed.

## 5. MFA

MFA policy must distinguish:

- not required
- enrollment required
- challenge required
- assurance satisfied
- recent step-up required

TOTP is an acceptable baseline possession factor. High-risk surfaces should plan phishing-resistant factors.

MFA secrets must be encrypted when reusable. Recovery codes must be hashed, shown once, and single-use.

Enrollment, challenge, failure, reset, disablement, recovery, and policy changes must be auditable.

## 6. Recovery

Recovery must:

- prove control through an approved path
- avoid bypassing Users lifecycle and Access controls
- expire pending artifacts
- invalidate used artifacts
- notify the affected user for high-risk recovery actions
- require recent authentication for self-service factor regeneration when available
- preserve evidence without storing raw codes or tokens

Local password-reset tokens:

- expire 30 minutes after issuance
- permit at most one usable token per User Account
- are single-use
- are replaced/revoked when a new usable token is issued
- are persisted only as a non-reversible verification value
- revoke existing authenticated sessions after successful password reset
- do not automatically reset MFA after successful password reset

## 7. Recent Authentication And Step-Up

For the initial local Auth implementation, recent authentication requires:

```text
current password verification
    +
currently enrolled confirmed TOTP verification
```

Successful recent authentication remains valid for 15 minutes.

The following do not satisfy recent authentication:

* login-time MFA satisfaction
* an existing MFA-satisfied timestamp by itself
* recovery codes
* session age alone

Recovery codes remain a recovery mechanism for normal MFA challenge behavior and are not accepted as recent-authentication step-up.

Successful recent authentication should regenerate the current session identifier.

Require recent authentication or stronger step-up for applicable:

- password or primary email changes
- MFA disablement or reset
- recovery-code regeneration
- elevated-access activation
- Super Admin assignment
- restricted export
- secret reveal
- critical security configuration changes

Recent authentication proves authentication assurance only. It does not grant authorization or elevated access.

## 8. External Identity

External sign-in must use Authorization Code flow with PKCE where applicable and must validate state, nonce, issuer, audience, expiry, signature, intended tenant or provider boundary, and replay protection.

Do not use implicit or password grant flows for browser sign-in.

Provider identity must use stable provider identifiers, not email alone.

## 9. Account Linking

Email match alone must not complete linking.

Linking requires proof of the current local account, a bound invitation or approved administrative flow, explicit audit evidence, and safe notification when risk warrants it.

## 10. Enterprise Identity

An enterprise provider must enforce the configured provider and tenant boundary.

Provider branding alone is not assurance.

Provider-side MFA must be validated when it is required. Otherwise, use local MFA or step-up.

## 11. Suspicious Authentication

Detection may begin in audit-only mode.

Audit-only detection must not automatically lock accounts, revoke sessions, notify users, or force assurance changes without an accepted response policy.

Detection metadata must use safe identifiers and deduplicate repeated signals.

## 12. Session Coordination

Session mechanics must follow Transport Session And Browser Security Standards.

Suspension, deactivation, password reset, MFA reset, and compromise response must define session invalidation behavior.

## 13. Verification

Tests must cover enumeration resistance, inactive identity denial, rate limiting, MFA challenge state, factor throttling, recovery-code single use, recent-auth separation, secret-safe audit metadata, account-linking proof, and provider tenant restrictions.

## 14. Related

- [Access Control And Authorization Standards](Access%20Control%20And%20Authorization%20Standards.md)
- [Transport Session And Browser Security Standards](Transport%20Session%20And%20Browser%20Security%20Standards.md)
- [Secrets Management Standards](Secrets%20Management%20Standards.md)
- [Auth Core Implementation Planning](../../07-planning/02-core-capabilities/auth-identity-access/auth-core-implementation-planning.md)
