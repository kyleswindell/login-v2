# Identity And Account Security Standards

This document defines the canonical scope and intent for Identity And Account Security Standards.

## Purpose

Define the required security baseline for authentication, external identity providers, account creation and linking, MFA assurance, and production credential handling.

## External Identity Standards

- External sign-in must use OIDC or OAuth flows that keep token exchange on the server side.
- Browser-based sign-in must use Authorization Code flow with PKCE, `state`, and `nonce`.
- Do not use implicit flow or password-style grant flows for user sign-in.
- Redirect URIs must be exact and environment-specific.
- Provider tokens and claims must be validated for issuer, audience, expiry, replay protection, and intended flow context before any local session is created.

## Identity Resolution Standards

- External provider identity must be keyed from stable provider identity claims, not from email alone.
- Treat email address as a user-facing attribute and possible discovery hint, not as a trusted linking key by itself.
- Automatic account linking from matching email alone is not allowed.
- Automatic account creation is not allowed unless the selected tenant access mode and account-creation policy explicitly allow it.
- Invitation-only and staff-created enrollment paths must remain available without requiring public self-registration.
- High-trust or enterprise tenants should default to invitation-only enrollment unless a stricter tenant-approved alternative is defined.

## Microsoft Entra Work Account Standards

- When a tenant requires Microsoft work-account sign-in, the app must be able to restrict sign-in to the allowed Microsoft Entra tenant boundary instead of accepting any Microsoft account.
- Tenant policy may require selected tenant-user surfaces to accept only work or school accounts from a specific connected Microsoft tenant.
- If a tenant requires stronger Microsoft-side controls, sign-in acceptance must depend on the required provider-side assurance being present rather than on the Microsoft brand alone.

## MFA And Assurance Standards

- Federated sign-in does not by itself prove MFA.
- MFA must be treated as an assurance requirement that is explicitly enforced or validated per sign-in surface and per privilege level.
- When provider-side MFA is required, the app must validate the provider result or policy outcome before granting access.
- When provider-side MFA cannot be required or trusted for the target surface, the app must use local MFA or step-up authentication before granting the protected access level.
- Privileged actions and privileged admin surfaces must support step-up authentication independent of how the base session was created.

## Login And Abuse Defense Standards

- Interactive login must apply anti-automation controls such as rate limiting, slowdown, or equivalent abuse defenses.
- Anti-automation decisions should consider both account-targeted and network-targeted abuse patterns rather than only one dimension.
- Failure responses must stay generic enough to avoid turning the login surface into an account-enumeration oracle.
- Suspicious login activity should be auditable and should support escalation to stronger assurance requirements when policy calls for it.

## Account Linking Standards

- Linking an external identity to an existing local account requires proof of control of the existing account or a valid invitation/approval path that is already bound to that account.
- A found email match may start a controlled linking flow, but it must not complete linking automatically.
- Linking, unlinking, provider-policy changes, and enrollment-mode changes must be auditable events.

## Secret And Credential Standards

- Do not hardcode secrets, client secrets, certificates, API keys, refresh tokens, or signing material in application code, committed config, fixtures, screenshots, or support docs.
- Production third-party credentials must be stored in a dedicated secret-management system with access control, auditability, and rotation support.
- General-purpose application settings storage must not be treated as approved production secret storage unless the storage path actually enforces encryption, access control, and rotation behavior suitable for secrets.
- For Microsoft-hosted production workloads, prefer managed identity where applicable. When managed identity is not available, prefer certificate-based credentials over long-lived client secrets.
- App registrations and credentials used only for user sign-in must remain logically separate from app registrations and credentials used for Microsoft Graph or other background API access when the scopes or blast radius differ materially.
- Third-party API permissions must follow least privilege and only the scopes required for the implemented feature set.
- Secrets must have ownership, rotation procedure, and expiry monitoring defined before production use.

## Logging And Exposure Standards

- Never log plaintext passwords, tokens, client secrets, certificate private keys, raw authorization codes, or full provider callback payloads.
- Security-relevant identity events must be recorded with enough metadata to audit the decision path without exposing secret material.

## Related

- [Security Standards](Security%20Standards.md)
- [Transport Session And Browser Security Standards](Transport%20Session%20And%20Browser%20Security%20Standards.md)
- [Tenant Safety Standards](Tenant%20Safety%20Standards.md)
- [Auth Architecture](../../03-architecture/auth.md)
- [Authentication](../../04-features/auth/authentication.md)
- [Customer Access And OAuth Flow](../../05-flows/customer-access-and-oauth-flow.md)
