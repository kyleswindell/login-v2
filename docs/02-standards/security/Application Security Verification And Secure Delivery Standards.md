# Application Security Verification And Secure Delivery Standards

This document defines the canonical scope and intent for Application Security Verification And Secure Delivery Standards.

## Purpose

Define the required verification and secure-delivery baseline for the application repository, release process, and staged environments.

## Verification Baseline

- The application should target OWASP ASVS Level 2 as the default verification baseline for normal authenticated and unauthenticated app behavior.
- Privileged admin surfaces, tenant isolation boundaries, secret handling, and authentication assurance controls should be implemented and reviewed with Level 3 rigor where the risk is materially higher.
- OWASP Top 10 is a risk-language aid, not the acceptance contract by itself.
- Security acceptance should be expressed in concrete verification requirements rather than in broad claims such as "secure" or "enterprise-ready".

## Secure Delivery Standards

- Every deployable revision must come from committed repository state.
- Dependency lockfiles must be committed and treated as part of the reviewed release artifact.
- Dependency updates must be auditable and should be checked for known security advisories before release.
- Secret scanning should run against repository state and release candidate state before production promotion.
- Release verification should include authenticated security testing, not only anonymous homepage checks.
- Security testing must exercise at least guest, authenticated non-privileged, and privileged surfaces that exist in the scoped release.
- Where tenant-aware behavior exists, security verification should cover tenant boundary behavior rather than only platform-admin behavior.

## Release Gate Standards

- Known critical vulnerabilities in shipped dependencies or deploy configuration must block production release until accepted through an explicit risk decision.
- Security-sensitive changes should include tests or validation artifacts that prove the intended control, especially for auth, authorization, tenancy, logging, secrets, and file-handling behavior.
- Production promotion should require verification that debug and local-development shortcuts are disabled.
- Production promotion should require verification that secrets, OAuth credentials, API credentials, and certificates resolve from approved secret storage rather than from ad hoc local values.

## Supply Chain Standards

- Prefer the smallest practical dependency set for the required feature scope.
- New packages must have a clear owner and justification.
- Security tooling should cover both Composer and npm dependency surfaces.
- The delivery process should be able to produce or derive a software bill of materials when enterprise review requires it.

## Security Testing Standards

- Authenticated DAST or equivalent browser-driven security verification should be part of the staged release review path for meaningful user-facing changes.
- Penetration-test preparation should include seeded test accounts and scoped environments that allow reviewers to exercise representative privilege levels safely.
- Security regression checks should be repeatable so the same core auth, session, access-control, and tenant-isolation assertions can be rerun after fixes or upgrades.

## Related

- [Security Standards](Security%20Standards.md)
- [Identity And Account Security Standards](Identity%20And%20Account%20Security%20Standards.md)
- [Transport Session And Browser Security Standards](Transport%20Session%20And%20Browser%20Security%20Standards.md)
- [Platform Production Server Policy](platform-production-server-policy.md)
