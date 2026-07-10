# Document Review 2026-07-01 ASVS Level 2 Security Baseline

## Review Pass
1

## Target
Canonical security standards against OWASP ASVS 5.0.0 Level 2 expectations, with Level 3 rigor for high-risk auth, admin, tenant isolation, and secret-handling areas.

## Review Type
Document Review

## Status
PARTIAL

## Purpose
Separate and organize the repo's ASVS Level 2 baseline in a canonical standards location, then review whether the current canonical security docs are aligned enough for enterprise penetration-test planning, including but not limited to MFA.

## Scope
- `docs/02-standards/index.md`
- `docs/02-standards/security/Security Standards.md`
- `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md`
- `docs/02-standards/security/OWASP ASVS Level 2 Baseline.md`
- `docs/02-standards/security/Identity And Account Security Standards.md`
- `docs/02-standards/security/Transport Session And Browser Security Standards.md`
- `docs/02-standards/security/Tenant Safety Standards.md`
- `docs/02-standards/logging/Logging Standards.md`
- `docs/11-ai/active-doc-reviews/index.md`
- `docs/11-ai/active-doc-reviews/doc-review-2026-07-01-asvs-level-2-security-baseline.md`

## Research Inputs
- OWASP Application Security Verification Standard project page
- OWASP ASVS 5.0.0 release artifacts
- OWASP ASVS 5.0.0 English CSV
- OWASP ASVS 5.0.0 V6 Authentication chapter
- Existing canonical security, logging, tenant-safety, and secure-delivery standards

## Findings

### Finding 1
- type: canonical-asvs-baseline-organization-gap
- location: `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md`
- issue: The repo referenced OWASP ASVS Level 2, but it did not separately define the adopted ASVS version, the fact that Level 2 includes applicable Level 1 and Level 2 requirements, the control-family organization, the Level 3 overlay rule, or the evidence expectations needed before a customer-facing ASVS alignment claim.
- required action: Add a dedicated canonical ASVS baseline standard and link it from the security standards root, the secure-delivery standard, and the standards index.
- decision state: resolved

### Finding 2
- type: asvs-evidence-matrix-gap
- location: canonical security standards and release-review process
- issue: The standards now define the ASVS baseline, but the repo does not yet have a release-scoped ASVS evidence matrix mapping every applicable ASVS 5.0.0 Level 1 and Level 2 requirement to implementation evidence, tests, non-applicability rationale, external control ownership, or accepted risk.
- required action: Create a scoped ASVS evidence matrix before external penetration testing, customer security review, or any claim that a release satisfies ASVS Level 2.
- constraints: Do not copy the full ASVS text into the repo. Use version-qualified ASVS IDs and link to official OWASP source artifacts.
- decision state: follow-up required

### Finding 3
- type: authentication-and-mfa-level-gap
- location: `docs/02-standards/security/Identity And Account Security Standards.md`, current MFA feature docs
- issue: The current MFA documentation is directionally aligned with ASVS authentication assurance because it treats MFA as explicit assurance, encrypts reusable secret material, hashes recovery codes, separates step-up from login assurance, and audits MFA events. However, ASVS Level 2 authentication readiness also requires broader evidence around password rules, breached-password checks, anti-automation, account enumeration resistance, and MFA enforcement for applicable access paths. High-risk Level 3 auth/admin surfaces should also plan for phishing-resistant or hardware-backed assurance, provider assurance validation, or an explicit risk decision when those controls are unavailable.
- required action: Extend the future ASVS evidence matrix and auth hardening work to cover password policy evidence, credential-stuffing defenses, suspicious-auth handling, tenant/role MFA policy enforcement, and Level 3 auth assurance decisions for privileged surfaces.
- constraints: Email OTP should not be represented as stronger assurance than TOTP or phishing-resistant factors. Provider sign-in should not be treated as MFA unless the provider-side assurance signal is validated.
- decision state: follow-up required

### Finding 4
- type: non-mfa-control-family-coverage-gap
- location: `docs/02-standards/security/*`, `docs/02-standards/logging/Logging Standards.md`, feature-specific standards
- issue: Current canonical docs cover several ASVS families at a high level, especially identity/MFA, transport/session/browser hardening, logging, tenant safety, and secure delivery. Several ASVS Level 2 families still need explicit applicability/evidence treatment before enterprise review: file handling, self-contained tokens, OAuth/OIDC details, API/web-service behavior, cryptography and data protection, WebRTC non-applicability, and business-logic anti-automation beyond login/MFA.
- required action: For each exposed capability, either add or link the canonical owner standard and include requirement-level evidence in the ASVS matrix. Mark unused families such as WebRTC or self-contained tokens as not applicable only when the scoped release truly does not expose that capability.
- decision state: follow-up required

### Finding 5
- type: secure-delivery-verification-gap
- location: `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md`, deployment and release runbooks
- issue: The secure-delivery standard requires authenticated security testing, dependency checks, secret scanning, and release verification, but the repo does not yet have a concrete ASVS release-gate runbook or reusable evidence package for penetration-test preparation.
- required action: Add a release/security verification runbook or checklist that ties SCA, secret scanning, authenticated DAST or equivalent manual testing, seeded accounts, tenant-boundary test data, dependency evidence, and production-hardening verification to ASVS evidence.
- decision state: follow-up required

## Summary
- The repo now has a dedicated canonical ASVS Level 2 baseline owner.
- The platform Security Checklist surface is the operational tracker for grouped readiness work, but it does not replace a full requirement-level ASVS evidence matrix.
- The canonical direction is OWASP ASVS 5.0.0 Level 2 by default, with Level 3 rigor for high-risk auth, admin, tenant isolation, and secret-handling areas.
- MFA is aligned as an explicit assurance boundary, but client/pentest readiness also requires broader authentication, authorization, tenant isolation, file/API/token, logging, delivery, and evidence work.
- The largest remaining gap is not one MFA behavior. It is the absence of a complete ASVS evidence matrix and release-gate package that a customer or penetration tester can review against.

## Unresolved Decisions
- Where the ASVS evidence matrix should live for active release work.
- Whether the first external-review target should be full ASVS Level 2 evidence across all applicable families or an auth/admin/tenant-focused subset first.
- Which high-risk auth/admin surfaces require Level 3 hardware-backed or phishing-resistant assurance before external client review.

## Implementation Status
implemented with follow-up needed

## Exit Criteria
- canonical ASVS Level 2 baseline doc exists and is linked from the security standards root, secure-delivery standard, and standards index
- review identifies remaining MFA and non-MFA ASVS readiness gaps
- follow-up work can proceed without rediscovering the ASVS baseline, control family ownership, or Level 3 overlay rule

## Resolution Notes
- Added `docs/02-standards/security/OWASP ASVS Level 2 Baseline.md`.
- Updated `docs/02-standards/security/Security Standards.md` to route ASVS adoption and external-review evidence through the new baseline doc.
- Updated `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` to delegate ASVS version, scope, overlays, organization, and evidence rules to the new baseline doc.
- Updated `docs/02-standards/index.md` to include the new ASVS baseline in the canonical security standards list.
- Added a database-backed Security Checklist UI plan and implementation path as the grouped operational readiness tracker; a full ASVS evidence matrix remains a follow-up.
