# Transport Session And Browser Security Standards

This document defines the canonical scope and intent for Transport Session And Browser Security Standards.

## Purpose

Define the required runtime hardening baseline for HTTPS, cookies, sessions, database transport, proxy trust, and browser response protections.

## HTTPS And Proxy Standards

- Production and staging access that carries authenticated traffic must terminate over HTTPS.
- Trusted proxy behavior must be configured so the application can correctly determine secure requests, originating IPs, and forwarded host/protocol data in approved deployment topologies.
- Production should fail closed on missing transport-security prerequisites rather than silently accepting insecure fallback when the deployment is expected to be protected.

## Session And Cookie Standards

- Session cookies for authenticated surfaces must be `HttpOnly` and secure in production.
- Same-site behavior must be selected intentionally for the surface and must not be loosened without a documented cross-site requirement.
- Session lifetime and remember-me behavior must reflect the privilege level of the surface rather than convenience alone.
- Session state that contains privileged authentication context should be encrypted at rest when the framework session backend supports it.
- Session identifiers must be regenerated on authentication elevation and invalidated on logout or equivalent session termination.

## Browser Response Standards

- Production should send a deliberate security-header baseline rather than relying on server defaults.
- The baseline should cover transport enforcement, content-type sniffing prevention, referrer handling, and clickjacking/frame embedding posture.
- Content Security Policy should be rolled out intentionally and validated against actual application needs before full enforcement.
- Debug or diagnostic headers should not be exposed broadly on production user-facing responses.

## Data Transport Standards

- Production database connections should use encrypted transport where the selected database supports it.
- Cache, queue, and realtime transports that cross host or trust boundaries should use secured network paths and credentials appropriate to the environment.
- Internal service traffic should not be assumed safe merely because it is not internet-facing.

## Runtime Exposure Standards

- Production must run with debug output disabled.
- Error handling must fail safely without exposing stack traces, secrets, or internal configuration to end users.
- Production configuration must not inherit insecure local-development defaults without an explicit approved reason.

## Related

- [Security Standards](Security%20Standards.md)
- [Identity And Account Security Standards](Identity%20And%20Account%20Security%20Standards.md)
- [Platform Production Server Policy](platform-production-server-policy.md)
