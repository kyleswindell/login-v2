# Document Review 0032

## Review Pass
3

## Target
Current repo security posture against OWASP ASVS-oriented expectations, current OWASP cheat-sheet guidance, Laravel 13 security defaults, and modern secure-by-design software expectations.

## Review Type
Document Review

## Status
CLOSED

## Purpose
Deepen the repo's current security review beyond OAuth and MFA planning so the next canonical security pass can address the highest-value implications for an enterprise customer and a future penetration-test baseline.

## Scope
- `app/Http/Controllers/Auth/LoginController.php`
- `app/Platform/Settings/SettingsService.php`
- `bootstrap/app.php`
- `config/session.php`
- `config/database.php`
- `.env.example`
- `composer.json`
- `package.json`
- `docs/02-standards/security/Security Standards.md`
- `docs/02-standards/security/Identity And Account Security Standards.md`
- `docs/02-standards/security/Transport Session And Browser Security Standards.md`
- `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md`
- `docs/02-standards/security/platform-production-server-policy.md`
- `docs/02-standards/logging/Logging Standards.md`
- `docs/11-ai/active-doc-reviews/index.md`
- `docs/11-ai/active-doc-reviews/doc-review-0032.md`

## Research Inputs
- OWASP ASVS 5.0 project page
- OWASP Authentication Cheat Sheet
- OWASP Credential Stuffing Prevention Cheat Sheet
- OWASP Session Management Cheat Sheet
- OWASP Authorization Cheat Sheet
- OWASP Logging Cheat Sheet
- OWASP Secure Headers Project
- OWASP Software Supply Chain Security Cheat Sheet
- OWASP Vulnerable Dependency Management Cheat Sheet
- OWASP Server-Side Request Forgery Prevention Cheat Sheet
- Laravel 13 authentication, hashing, encryption, CSRF, session, validation, and request docs
- NIST SP 800-218 SSDF
- CISA Secure by Design guidance

## Findings

### Finding 1
- type: login-anti-automation-gap
- location: `app/Http/Controllers/Auth/LoginController.php:25-71`
- issue: The current login path validates credentials and logs failures, but it does not apply a visible per-account/per-IP rate limiter, progressive delay, or other anti-automation control around credential stuffing and password spraying. Current OWASP authentication and credential-stuffing guidance, plus Laravel's own authentication guidance, treat login throttling as baseline rather than optional hardening.
- required action: Add canonical standards and implementation requirements for login rate limiting, suspicious-auth telemetry, lockout/slowdown behavior, and MFA escalation after abuse signals. The eventual implementation should key throttling at least by login identifier plus IP or network context, and it should avoid turning error behavior into an account-enumeration side channel.
- constraints: Keep failure messaging generic. Do not replace invitation-only or MFA policy with rate limiting; these are complementary controls.
- decision state: resolved

### Finding 2
- type: secret-storage-implementation-gap
- location: `app/Platform/Settings/SettingsService.php:34-60`, `docs/02-standards/security/Identity And Account Security Standards.md`
- issue: The repo now documents that production third-party credentials must live in dedicated secret management, but the current settings service still stores values directly in `value_jsonb` even when `is_encrypted` is set. That means the current implementation path is not safe for storing Microsoft Graph credentials, OAuth client secrets, certificate material, refresh tokens, or comparable production secrets.
- required action: Define and implement a hard separation between normal configurable settings and secret-backed settings. Secrets should resolve from a real secret manager or encrypted secret store with controlled access, rotation support, and auditability. The `is_encrypted` flag should not imply protection that the current implementation does not actually provide.
- constraints: Do not paper over this by allowing sensitive production credentials to remain in general-purpose settings rows. Any temporary fallback needs explicit scope limits and migration planning.
- decision state: resolved

### Finding 3
- type: session-and-transport-hardening-gap
- location: `config/session.php:35-50`, `config/session.php:172-202`, `config/database.php:87-100`, `.env.example:39-43`
- issue: The current session and database configuration support secure deployment, but they do not set a strong production-safe baseline by default. Session encryption is off by default, secure-cookie behavior is not forced in config, and PostgreSQL TLS is only `prefer` rather than a stricter production requirement. For an enterprise review, these become configuration-risk findings even if local development intentionally runs looser defaults.
- required action: Add explicit production standards and deployment requirements for HTTPS-only cookies, trusted proxy handling, session-hardening expectations, database TLS requirements, and environment-specific secure defaults. Production should fail closed on missing transport-security prerequisites rather than silently accepting weaker modes.
- constraints: Preserve local-development ergonomics, but make the production path unambiguous and enforceable.
- decision state: resolved

### Finding 4
- type: browser-security-headers-gap
- location: `bootstrap/app.php:16-18`
- issue: The inspected application bootstrap appends request-ID middleware, but there is no visible app-level security-header middleware or documented baseline for CSP, HSTS, `X-Content-Type-Options`, `Referrer-Policy`, frame protections, or related browser hardening. OWASP secure-header guidance and modern pen-test baselines usually treat this as a first-pass control surface.
- required action: Define a canonical response-header baseline and implement environment-appropriate middleware for production and staging, including a rollout path for CSP in report-only mode before enforcement if needed.
- constraints: Avoid copying generic header lists without validating impact on Filament, Livewire, Vite assets, and Reverb-related surfaces. Treat CSP as an application integration task, not a one-line toggle.
- decision state: resolved

### Finding 5
- type: secure-software-delivery-gap
- location: `composer.json`, `package.json`, current canonical security standards set
- issue: The repo depends on Composer and npm packages, but the current canonical security baseline reviewed in this pass does not yet define a secure software delivery contract for dependency monitoring, secret scanning, SBOM generation, vulnerability triage, authenticated DAST, or release-gate security verification. OWASP 2025 and NIST SSDF both push this from "nice to have" into expected producer behavior.
- required action: Add repo-level standards or runbooks for dependency audit cadence, automated SCA, secret scanning, authenticated web-app testing, and ASVS-aligned release verification. For this app, that should include authenticated scans across distinct privilege levels and tenant contexts, not just anonymous homepage checks.
- constraints: Keep the first pass practical. The goal is a usable minimum secure-delivery baseline, not an aspirational control catalog with no owner.
- decision state: resolved

## Summary
- The repo's current security posture is directionally good on boundary awareness, centralized logging, and planned OAuth/MFA policy separation.
- The biggest implications for meeting an OWASP-style enterprise standard are now less about adding one feature and more about closing system-level gaps: anti-automation controls, real secret handling, production-safe transport/session defaults, browser response hardening, and repeatable secure-delivery verification.
- For a customer like Toyota, those gaps are likely to be more visible in security review and penetration-test reporting than purely UI-level or convenience-auth issues.

## Unresolved Decisions
- none

## Implementation Status
implemented

## Exit Criteria
- canonical docs define a repo-level secure-delivery baseline in addition to auth and secret-storage rules
- auth standards and implementation include login anti-automation requirements
- production deployment standards define stricter session, cookie, proxy, and database transport expectations
- a future implementation pass can map these findings into code, deployment, and validation work without rediscovering the research

## Resolution Notes
- Added `docs/02-standards/security/Transport Session And Browser Security Standards.md` so HTTPS, proxy trust, cookie/session hardening, browser header baseline, and runtime exposure rules now have a canonical standards owner.
- Added `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` so OWASP ASVS-oriented verification, authenticated security testing, dependency and secret scanning, and release-gate expectations now have a canonical standards owner.
- Updated `docs/02-standards/security/Identity And Account Security Standards.md` so login anti-automation controls and the prohibition against treating general-purpose settings storage as approved production secret storage are now explicit.
- Updated `docs/02-standards/logging/Logging Standards.md` so auth abuse, MFA, identity-linking, and security-policy events are now part of the expected audit-log surface.
- Updated `docs/02-standards/security/platform-production-server-policy.md` and the standards index/security root so the new production-hardening and secure-delivery standards are linked into the canonical navigation path.
- Re-review found no remaining scoped drift in the new standards ownership, secure-delivery baseline, or production-hardening guidance added in this pass.
