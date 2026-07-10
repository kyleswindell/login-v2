# ASVS Level 2 Evidence Matrix

This document is a supporting evidence matrix for OWASP ASVS 5.0.0 Level 1 and Level 2 review.

## Purpose

Track requirement-level ASVS evidence, applicability decisions, open gaps, and follow-up implementation work for Login App 2.0.

This matrix supports the canonical [OWASP ASVS Level 2 Baseline](../../02-standards/security/OWASP%20ASVS%20Level%202%20Baseline.md). It does not define rules by itself.

## Source

- Baseline: OWASP ASVS 5.0.0.
- Source artifact: official OWASP ASVS 5.0.0 English CSV.
- Requirement IDs use the version-qualified format recommended by OWASP, such as `v5.0.0-6.3.1`.
- This repository stores app-owned summaries and evidence notes, not a copy of the full ASVS requirement text.

## Status Model

- `aligned`: current docs/code/tests provide sufficient evidence for the scoped release.
- `partial`: some evidence exists, but more implementation, tests, documentation, or manual review is required.
- `lacking`: no sufficient implementation or evidence exists.
- `not_applicable`: not applicable to the scoped release.
- `accepted_risk`: applicable but deferred with an explicit risk decision.

## Current Scope

This first pass covers authentication, password, login-abuse, route/action permission-gate evidence, runtime-hardening, and security logging evidence. The full ASVS Level 2 matrix must expand this file until every applicable Level 1 and Level 2 requirement is mapped before any external claim of ASVS Level 2 alignment.

## Authentication And Login-Abuse Evidence

| ASVS ref | Area | App-owned expectation | Applicability | Alignment | Evidence | Gap or next action |
| --- | --- | --- | --- | --- | --- | --- |
| `v5.0.0-2.4.1` | Anti-automation | Protect application functions from excessive automated use that can cause abuse, quota exhaustion, or denial of service. | Applicable | partial | `App\Platform\Auth\Login\LoginAttemptLimiter`; `App\Platform\Auth\Mfa\MfaAttemptLimiter`; `tests/Feature/Auth/LoginTest.php`; `tests/Feature/Auth/MfaLoginTest.php`; `tests/Feature/Auth/MfaStepUpTest.php` | Broaden beyond auth to future expensive tenant, file, API, and notification actions. |
| `v5.0.0-6.1.1` | Authentication documentation | Document login abuse defenses, rate-limit thresholds, adaptive response posture, and malicious lockout avoidance. | Applicable | partial | [Identity And Account Security Standards](../../02-standards/security/Identity%20And%20Account%20Security%20Standards.md); [Authentication](../../04-features/auth/authentication.md); [Login Authentication Flow](../../05-flows/login-authentication-flow.md) | Add release-level evidence after Docker tests pass and manual review confirms behavior. |
| `v5.0.0-6.1.2` | Password documentation | Define context-specific words that cannot be used in local passwords. | Applicable before production | partial | [Identity And Account Security Standards](../../02-standards/security/Identity%20And%20Account%20Security%20Standards.md); `App\Platform\Auth\Password\LocalPasswordPolicy`; `App\Platform\Auth\Password\NotCommonOrContextualPassword` | Add tenant-specific blocked-word source when tenant-managed local accounts are introduced. |
| `v5.0.0-6.2.1` | Password length | Enforce local password minimum length appropriate for the account surface. | Applicable | aligned | `App\Platform\Auth\Password\LocalPasswordPolicy::MIN_LENGTH`; account settings and platform user requests use the shared rule. | Recheck when password reset and tenant-account creation are implemented. |
| `v5.0.0-6.2.2` | Password change | Allow users with local passwords to change their own password. | Applicable | aligned | `App\Http\Controllers\Platform\AccountController`; `tests/Feature/Auth/MfaStepUpTest.php`; [Account Password Change Flow](../../05-flows/account-password-change-flow.md) | None for current local-account scope. |
| `v5.0.0-6.2.3` | Password change verification | Require current password and new password for local password change. | Applicable | aligned | `current_password` validation in `AccountController`; account password-change tests. | None for current local-account scope. |
| `v5.0.0-6.2.4` | Common passwords | Reject passwords from a common-password deny list appropriate to the password policy. | Applicable before production | partial | `NotCommonOrContextualPassword`; `tests/Feature/Platform/PlatformAccountTest.php`; `tests/Feature/Platform/PlatformUserManagementTest.php` | Expand the deny list or choose a package/corpus-backed list before production. |
| `v5.0.0-6.2.5` | Password composition | Do not require arbitrary composition rules such as mandatory uppercase, number, or symbol counts. | Applicable | aligned | `LocalPasswordPolicy` uses minimum length plus deny-list/context checks without composition requirements. | Recheck when tenant-specific password policy configuration is added. |
| `v5.0.0-6.2.6` | Password masking | Render password fields as masked inputs while allowing approved reveal behavior. | Applicable | partial | Auth/login views use project password input behavior; platform/account forms use password fields. | Add rendered-view evidence for every local password field. |
| `v5.0.0-6.2.7` | Password managers and paste | Do not block paste, browser helpers, or password managers. | Applicable | partial | No current code intentionally blocks paste or password managers. | Add browser/manual evidence for local password fields. |
| `v5.0.0-6.2.8` | Exact password verification | Verify the password as supplied without truncation or case transformation. | Applicable | partial | `Hash::check($password, $user->password)` in `LoginController`; long-password login test coverage. | Add broader mixed-character create/change/login test evidence before external review. |
| `v5.0.0-6.2.9` | Long password support | Permit passwords of at least 64 characters. | Applicable | aligned | `LocalPasswordPolicy`; account password update and login coverage for a 64-character password. | Recheck when password reset and tenant-account creation are implemented. |
| `v5.0.0-6.2.10` | No forced periodic rotation | Do not force periodic password rotation. | Applicable | aligned | No periodic password-expiry mechanism exists. | Recheck when account policy features are added. |
| `v5.0.0-6.2.11` | Context-specific words | Enforce the documented context-specific password word deny list. | Applicable before production | partial | `NotCommonOrContextualPassword` rejects user name parts, email-local parts, and Login App product markers; feature tests cover account and platform-user contexts. | Add tenant-specific blocked-word source when tenant-managed local accounts are introduced. |
| `v5.0.0-6.2.12` | Breached passwords | Check new or changed passwords against a breached-password source. | Applicable before production | partial | `App\Platform\Auth\Password\BreachedPasswordChecker`; `App\Platform\Auth\Password\HibpBreachedPasswordChecker`; `App\Platform\Auth\Password\BreachedPasswordRule`; `tests/Feature/Platform/PlatformAccountTest.php` | Decide production mode and whether customer policy requires replacing HIBP with a local corpus provider. |
| `v5.0.0-6.3.1` | Credential stuffing and brute force | Implement controls documented for credential stuffing and brute-force prevention. | Applicable | partial | `LoginAttemptLimiter` protects password attempts per identifier/IP and IP; `MfaAttemptLimiter` protects challenge attempts; `SuspiciousAuthMonitor` emits audit-only detections for repeated throttles, password spray, inactive-user probes, MFA rate-limit repeats, and repeated breached-password findings. | Add manual review evidence and tune thresholds after staging traffic assumptions are known. |
| `v5.0.0-6.3.2` | Default accounts | Ensure default accounts are absent or disabled. | Applicable | partial | Local review account is explicitly documented for local/staging review only. | Add production seed/deploy evidence proving no default enabled admin account ships. |
| `v5.0.0-6.3.3` | MFA or multiple factors | Require MFA or appropriate multiple authentication factors for applicable access. | Applicable | partial | Local TOTP MFA, recovery codes, admin reset, and step-up are implemented for platform users; tests prove email/password step-up separation and encrypted/hashed MFA secret storage evidence. | Add role/tenant policy enforcement and provider-assurance evidence before external review. |
| `v5.0.0-6.3.4` | Authentication pathway consistency | Document every authentication path and enforce consistent security controls across paths. | Applicable | partial | Progressive login and temporary legacy `POST /login` path both route through `LoginController::attemptLogin`. | Remove or explicitly retire compatibility `POST /login`; add OAuth/OIDC paths when implemented. |
| `v5.0.0-16.3.1` | Authentication event logging | Log successful and unsuccessful authentication operations with safe metadata. | Applicable | partial | `auth.login_succeeded`, `auth.login_failed`, `auth.login_throttled`, `auth.suspicious_activity_detected`, `auth.password_breached_detected`, `auth.password_breach_check_failed`, MFA challenge/satisfaction/rejection/rate-limit events. | Confirm retention/access controls and expand logging inventory for final ASVS evidence. |

## Transport, Session, Browser, And Runtime Evidence

| ASVS ref | Area | App-owned expectation | Applicability | Alignment | Evidence | Gap or next action |
| --- | --- | --- | --- | --- | --- | --- |
| `v5.0.0-V3` | Session management | Maintain session cookie, lifecycle, and authenticated-session controls appropriate for platform access. | Applicable | partial | `config/session.php`; `bootstrap/app.php`; `tests/Feature/Auth/LoginTest.php`; `tests/Feature/Platform/PlatformSecurityHeadersTest.php`; `tests/Feature/Platform/PlatformSecurityRuntimeCheckTest.php`; `php artisan platform:security-runtime-check`; [Transport Session And Browser Security Standards](../../02-standards/security/Transport%20Session%20And%20Browser%20Security%20Standards.md) | Capture deployed runtime-check output for `SESSION_SECURE_COOKIE=true`, `SESSION_ENCRYPT=true`, trusted proxy correctness, login session regeneration, and logout invalidation. |
| `v5.0.0-V7` | Error handling and runtime exposure | Keep production runtime output and error responses from exposing stack traces, secrets, or diagnostic internals. | Applicable | partial | `config/app.php`; `bootstrap/app.php`; `php artisan platform:security-runtime-check`; [Transport Session And Browser Security Standards](../../02-standards/security/Transport%20Session%20And%20Browser%20Security%20Standards.md); [Platform Production Server Policy](../../02-standards/security/platform-production-server-policy.md) | Capture deployed proof for `APP_DEBUG=false`, exception rendering, and operational log access boundaries. |
| `v5.0.0-V12` | Browser response protections | Send a deliberate browser-header baseline that prevents MIME sniffing, clickjacking/frame embedding, excess referrer leakage, and unnecessary browser feature exposure. | Applicable | partial | `App\Http\Middleware\ApplySecurityHeaders`; `config/platform.php`; `tests/Feature/Platform/PlatformSecurityHeadersTest.php`; `tests/Feature/Platform/PlatformSecurityRuntimeCheckTest.php`; `php artisan platform:security-runtime-check --url=...`; [Transport Session And Browser Security Standards](../../02-standards/security/Transport%20Session%20And%20Browser%20Security%20Standards.md) | Add tested broad CSP only after route-level asset and integration validation; keep current CSP limited to `frame-ancestors 'none'`. |
| `v5.0.0-V13` | Secure configuration and transport posture | Document and verify production-only HTTPS/HSTS, secure cookies, session encryption, trusted proxy, database TLS, and runtime-hardening configuration. | Applicable | partial | `.env.example`; `config/platform.php`; `config/session.php`; `config/database.php`; `App\Http\Middleware\ApplySecurityHeaders`; `App\Platform\Security\RuntimeSecurityChecker`; `tests/Feature/Platform/PlatformSecurityHeadersTest.php`; `tests/Feature/Platform/PlatformSecurityRuntimeCheckTest.php`; [Deployment](../../10-runbooks/deployment.md); [Server Readiness](../../10-runbooks/server-readiness.md) | Capture actual staging/production command output and server review evidence for proxy settings, HTTPS/HSTS enablement, database TLS posture, and final production env values. |

## Authorization, RBAC, And Tenant Isolation Evidence

| ASVS ref | Area | App-owned expectation | Applicability | Alignment | Evidence | Gap or next action |
| --- | --- | --- | --- | --- | --- | --- |
| `v5.0.0-V8` | Authorization and access control | Enforce explicit permission-gated access to platform administration routes and prevent lower-privilege managers from escalating themselves or others into super-admin authority. | Applicable | partial | `App\Providers\AppServiceProvider`; `App\Platform\Auth\PlatformUserAccess`; `app/Http/Controllers/Platform/*`; `tests/Feature/Platform/PlatformRouteAuthorizationMatrixTest.php`; `tests/Feature/Platform/PlatformUserManagementTest.php`; `tests/Feature/Platform/PlatformSettingsTest.php`; `tests/Feature/Platform/PlatformSecurityChecklistTest.php`; [Platform Users And RBAC](../../04-features/users/platform-users-and-rbac.md) | Route/action permission-gate evidence now covers current platform mutating routes with side-effect assertions and an inventory guard; redesign final role/permission policy and implement tenant-boundary evidence before tenant launch. |
| `v5.0.0-V14` | Tenant isolation and data boundary | Keep tenant-scoped data and administrative access isolated by tenant boundary once tenant runtime surfaces are implemented. | Applicable before tenant launch | lacking | [Tenant Safety Standards](../../02-standards/security/Tenant%20Safety%20Standards.md); [Platform Users And RBAC](../../04-features/users/platform-users-and-rbac.md); current docs identify tenant-scoped auth and tenant roles as deferred. | Implement and test tenant database, tenant role, tenant admin domain, and cross-tenant access boundaries before tenant launch. |

## Next Expansion Targets

- Secret-handling and data-protection rows from V11 and V14.
- Secure delivery rows from V13 and V15.
- API, file, token, OAuth/OIDC, and WebRTC applicability rows.
