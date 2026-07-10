# Security Test Contract Audit

Date: 2026-07-02  
Status: IMPLEMENTED  
Implementation Status: implemented  
Type: Review-only governance audit

## Scope

This audit reviewed recent security-related tests and paired implementation surfaces added during the MFA, suspicious-auth, runtime-hardening, security-checklist, and authorization-matrix work.

Reviewed test surfaces:

- `tests/Feature/Auth/LoginTest.php`
- `tests/Feature/Auth/MfaLoginTest.php`
- `tests/Feature/Auth/MfaStepUpTest.php`
- `tests/Feature/Auth/AuthorizationTest.php`
- `tests/Feature/Platform/PlatformRouteAuthorizationMatrixTest.php`
- `tests/Feature/Platform/PlatformUserManagementTest.php`
- `tests/Feature/Platform/PlatformAccountTest.php`
- `tests/Feature/Platform/PlatformNotificationsTest.php`
- `tests/Feature/Platform/BroadcastChannelAuthorizationTest.php`
- `tests/Feature/Platform/PlatformSecurityHeadersTest.php`
- `tests/Feature/Platform/PlatformSecurityRuntimeCheckTest.php`
- `tests/Feature/Platform/PlatformSecurityChecklistTest.php`
- `tests/Feature/Platform/PlatformSettingsTest.php`
- `tests/Feature/Platform/PlatformAuditLogViewerTest.php`
- `tests/Feature/Platform/ErrorLogViewerTest.php`
- `tests/Unit/PlatformAuditLogTest.php`
- `tests/Unit/CentralErrorLogTest.php`

Reviewed paired implementation surfaces included auth controllers, MFA services, suspicious-auth detection, breached-password validation, security-header middleware, trusted-proxy/runtime checker code, security checklist update handling, platform route definitions, platform user MFA controls, and canonical security/checklist evidence wording.

## Review Notes

- The auth/MFA tests mostly assert real security behavior: delayed session issuance, no authentication before MFA, pending login cleanup, login-time MFA not satisfying account step-up, MFA rate limiting, recovery-code single use, and security audit events.
- The breached-password tests assert both report-only and enforced behavior, provider outage fail-closed behavior, suspicious-auth emission, and absence of submitted passwords/full hashes from audit metadata.
- The security-header tests assert concrete response headers, HTML-only `frame-ancestors`, HSTS gating, and session cookie flags.
- The route authorization matrix is materially better after the recent cleanup because allowed mutating cases now assert no validation errors and concrete side effects.
- No current use of the legacy `ui-notification-trigger` class was found; notification trigger assertions now rely on `data-notification-*` behavior hooks.
- `tests/Unit/PlatformAuditLogTest.php` and `tests/Unit/CentralErrorLogTest.php` are not security contract evidence. They verify timezone display conversion only.
- Local `php artisan route:list` could not be used from this UNC workspace because the available PHP process failed on missing `mb_split()` and fell back from the UNC path. Route coverage was reviewed by static route-file inspection instead.

## Findings

### F1 - Security checklist evidence links are not constrained to safe URL/path values

Priority: P1  
Classification: `coverage_gap`, implementation weakness  
Files:

- `app/Http/Controllers/Platform/SecurityChecklistController.php:111`
- `app/Http/Controllers/Platform/SecurityChecklistController.php:127`
- `resources/views/platform/security/show.blade.php:130`
- `docs/06-database/feature-contracts/security-requirements-checklist.md:75`
- `tests/Feature/Platform/PlatformSecurityChecklistTest.php:67`

The database contract says evidence links must store structured label and URL/path values only and must not store raw HTML or sensitive payloads. The controller currently validates evidence link URLs as arbitrary strings, trims them, stores them, and the view renders the stored value as an href. The test only verifies a normal link persists and that sensitive notes are excluded from audit metadata; it does not reject unsafe schemes or raw markup payloads.

Expected contract:

- Evidence link URLs should be limited to app-relative paths, approved docs paths, or explicitly allowed external `https://`/`http://` URLs.
- Unsafe schemes such as `javascript:`, `data:`, and raw HTML payloads should be rejected before storage.
- Tests should assert invalid evidence links do not persist and do not render.

Recommended correction:

- Add a dedicated evidence-link validation rule or normalizer.
- Add tests for rejecting `javascript:alert(1)`, `data:text/html,...`, raw HTML labels/URLs where applicable, and overlong/blank pairs.
- Keep audit metadata limited to changed fields and link counts.

### F2 - Route/action authorization matrix is not yet complete for all platform mutating routes

Priority: P1  
Classification: `coverage_gap`  
Files:

- `routes/web.php:79`
- `routes/web.php:81`
- `routes/web.php:82`
- `routes/web.php:115`
- `routes/web.php:117`
- `routes/web.php:119`
- `routes/web.php:121`
- `routes/web.php:124`
- `routes/web.php:126`
- `routes/web.php:128`
- `routes/web.php:130`
- `tests/Feature/Platform/PlatformRouteAuthorizationMatrixTest.php:167`
- `tests/Feature/Platform/PlatformRouteAuthorizationMatrixTest.php:246`
- `tests/Feature/Platform/PlatformSettingsTest.php:326`
- `tests/Feature/Platform/PlatformNotificationsTest.php:92`

The matrix now proves several important gates and side effects, but it is not a complete route/action authorization inventory. Static route inspection found platform mutating routes that are not covered by the matrix or are only partially covered elsewhere, including notification item read/dismiss routes and most settings subpage POST routes.

Expected contract:

- Every authenticated platform route should have explicit guest, unauthorized, and authorized expectations.
- Every mutating route should assert either no side effect on denial or the intended side effect on success.
- The matrix should be described as permission-gate evidence only, not final role-model or tenant-isolation completeness.

Recommended correction:

- Extend the matrix or add a generated route/action inventory helper for the missing mutating routes.
- Cover `/platform/notifications/{notification}/read`, `/platform/notifications/{notification}/dismiss`, and all `/platform/settings/*` POST routes.
- Keep tenant isolation and final role/permission redesign as separate future evidence.

### F3 - Email-change MFA step-up is implemented but not directly tested

Priority: P1  
Classification: `coverage_gap`  
Files:

- `app/Http/Controllers/Platform/AccountController.php:53`
- `app/Http/Controllers/Platform/AccountController.php:115`
- `docs/04-features/account/account-management-and-settings.md:71`
- `tests/Feature/Auth/MfaStepUpTest.php:16`
- `tests/Feature/Auth/MfaStepUpTest.php:54`
- `tests/Feature/Auth/MfaStepUpTest.php:96`

The account feature contract requires MFA step-up before changing email or password for MFA-enrolled users. The implementation checks both changed email and new password, but the tests exercise only password changes and admin MFA reset. A future regression could remove or bypass the email branch while the current step-up suite remains green.

Expected contract:

- An MFA-enrolled user attempting to change email without fresh step-up is redirected to `/mfa/step-up`.
- The email remains unchanged until step-up succeeds.
- A successful step-up allows exactly one account-security change and then consumes the step-up assurance.

Recommended correction:

- Add an enrolled-user email-change step-up test.
- Add a successful email-change-after-step-up test.
- Add an assertion that login-time MFA still does not satisfy the email-change step-up requirement.

### F4 - Secret-at-rest evidence is missing for encrypted TOTP material and hashed recovery codes

Priority: P1  
Classification: `coverage_gap`  
Files:

- `app/Models/UserMfaMethod.php:34`
- `app/Platform/Auth/Mfa/MfaManager.php:111`
- `app/Platform/Auth/Mfa/MfaManager.php:160`
- `tests/Feature/Auth/MfaLoginTest.php:70`
- `tests/Feature/Auth/MfaLoginTest.php:289`
- `tests/Feature/Platform/PlatformAccountTest.php:294`

The MFA tests prove enrollment, challenge, recovery-code display, and recovery-code single use. They do not directly inspect raw database storage to prove TOTP secrets are encrypted at rest and recovery codes are stored only as non-reversible hashes. This matters because the docs and ASVS evidence depend on secret-handling rigor, not just functional MFA behavior.

Expected contract:

- Raw `user_mfa_methods.secret` and `pending_secret` database values should not equal the generated TOTP secret material.
- Recovery-code table values should not equal displayed recovery codes or normalized recovery codes.
- Stored recovery-code hashes should still verify with `Hash::check(normalized_code, code_hash)`.

Recommended correction:

- Add DB-level assertions after enrollment and recovery-code generation.
- Check both pending-secret and confirmed-secret storage where practical.
- Keep functional challenge/recovery-code tests separate from secret-at-rest tests so failures are easier to diagnose.

### F5 - Trusted-proxy middleware behavior is not proven by request-level tests

Priority: P2  
Classification: `coverage_gap`  
Files:

- `app/Http/Middleware/ConfigureTrustedProxies.php:15`
- `app/Platform/Security/RuntimeSecurityConfig.php:62`
- `bootstrap/app.php:22`
- `tests/Feature/Platform/PlatformSecurityRuntimeCheckTest.php:44`
- `tests/Feature/Platform/PlatformSecurityRuntimeCheckTest.php:67`

The runtime tests cover trusted-proxy config parsing and readiness failure when proxy mode lacks configured proxies. They do not send requests with forwarded headers through the registered middleware to prove direct mode ignores forwarded headers and trusted-proxy mode honors only explicitly configured proxies.

Expected contract:

- `direct` mode should not let untrusted `X-Forwarded-*` headers affect request security, host, port, or client IP.
- `trusted_proxy` mode should honor forwarded headers only when the request comes through a configured proxy.
- Wildcard/all-network proxy declarations should remain rejected.

Recommended correction:

- Add request-level tests using `REMOTE_ADDR`, `X-Forwarded-Proto`, `X-Forwarded-Host`, `X-Forwarded-Port`, and `X-Forwarded-For`.
- Assert HSTS/security behavior follows the effective request security state only in trusted-proxy mode with explicit proxies.

### F6 - Runtime readiness failure assertions are too narrow for the configured failure scenario

Priority: P2  
Classification: `too_weak`  
Files:

- `tests/Feature/Platform/PlatformSecurityRuntimeCheckTest.php:23`
- `app/Platform/Security/RuntimeSecurityChecker.php:30`

The staging readiness test intentionally configures multiple missing hardening controls: debug enabled, security headers disabled, HSTS disabled, HTTPS not expected, trusted proxy mode without proxies, secure cookies off, session encryption off, SameSite not Lax, and database SSL disabled. The assertions only require a few failure labels in console output. The command could stop reporting several intended failures and still satisfy the test as long as one or two failures remain.

Expected contract:

- Staging/production readiness tests should assert every required hardening check status for the configured scenario.
- JSON output or direct `RuntimeSecurityChecker::check()` assertions should verify the named check statuses without relying only on console fragments.

Recommended correction:

- Add assertions for `security_headers`, `expect_https`, `hsts`, `session_encryption`, `session_same_site`, and `database_sslmode`.
- Keep the existing console output test as a smoke test, but use structured result assertions for the security contract.

### F7 - Some security-adjacent tests still assert presentation classes rather than security behavior

Priority: P3  
Classification: `implementation_coupled`  
Files:

- `tests/Feature/Platform/PlatformNotificationsTest.php:34`
- `tests/Feature/Platform/PlatformAuditLogViewerTest.php:34`
- `tests/Feature/Platform/PlatformAuditLogViewerTest.php:36`
- `tests/Feature/Platform/PlatformAccountTest.php:390`
- `tests/Feature/Platform/PlatformAccountTest.php:404`

The notification trigger issue was corrected to use stable `data-notification-*` hooks, but other security-adjacent tests still assert implementation classes such as UI action classes and icon-button classes. These may be useful UI migration checks, but they should not be treated as ASVS/security evidence.

Expected contract:

- Security tests should prefer authorization outcomes, ownership filtering, audit events, safe metadata, and data/ARIA behavior hooks.
- Pure presentation class checks should live in UI/component contract tests, not in security evidence summaries.

Recommended correction:

- Leave these assertions alone unless they are causing churn.
- Do not cite them as security evidence.
- If they remain necessary, classify them as UI contract checks in docs and test naming.

## Non-Findings / Valid Contracts

- `tests/Feature/Auth/LoginTest.php` proves progressive login does not expose a password field on the identifier step, does not authenticate on invalid credentials, records success/failure/throttle audit events, and hashes identifiers in suspicious-auth metadata.
- `tests/Feature/Auth/MfaLoginTest.php` proves required-but-unenrolled users are routed to enrollment before authentication, enrolled users are challenged before authentication, pending login state is cleared on success/expiry, recovery codes are single-use, and invalid MFA does not authenticate.
- `tests/Feature/Auth/MfaStepUpTest.php` proves login MFA does not satisfy account-security step-up and admin MFA reset requires fresh step-up for enrolled admins.
- `tests/Feature/Platform/PlatformUserManagementTest.php` proves non-super-admin managers cannot create/promote/manage super-admin users and that admin MFA reset clears the expected enrollment state and recovery codes.
- `tests/Feature/Platform/PlatformSecurityHeadersTest.php` proves the first-pass browser-header baseline and session cookie flags at the response level.
- `tests/Feature/Platform/BroadcastChannelAuthorizationTest.php` and the broadcast-auth case in `PlatformRouteAuthorizationMatrixTest.php` prove notification channel authorization is limited to the current user with notification-view permission.

## Recommended Follow-Up Order

1. Fix F1 first because it is a direct input validation/storage/rendering gap in a security-facing staff UI.
2. Add F3 and F4 tests next because they protect high-risk auth and secret-handling contracts.
3. Expand F2 route/action coverage before using the matrix as ASVS authorization evidence.
4. Add F5 and F6 runtime evidence tests before treating proxy readiness as deployment-verifiable.
5. Reclassify or move F7 presentation assertions when the UI test cleanup lane resumes.

## Correction Implementation Notes

- F1 implemented and validated: added dedicated evidence-link URL validation, normalized evidence-link input before storage, documented allowed URL/path forms, and added unsafe-link rejection tests.
- F2 implemented and validated: expanded platform route/action authorization evidence for notification item actions, settings POST routes, mutation denial side effects, mutation success side effects, and a platform mutating-route inventory guard.
- F3 implemented and validated: added direct email-change MFA step-up tests, successful email-change-after-step-up coverage, step-up consumption coverage, and login-MFA separation for email changes.
- F4 implemented and validated: added raw database assertions proving pending/confirmed TOTP secret material is encrypted at rest and recovery codes are stored as verifiable non-reversible hashes.
- F5 implemented and validated: added request-level trusted-proxy tests for direct mode, configured trusted-proxy mode, and unconfigured proxy requests.
- F6 implemented and validated: expanded runtime-readiness assertions to check every configured staging failure through structured checker output while keeping console output as a smoke test.
- F7 no code change required in this pass: reviewed canonical evidence wording and did not find overclaims that rely on presentation-class assertions as security evidence.

## Validation Performed

- Static review of the scoped tests and paired implementation.
- Static review of `routes/web.php` for route/action coverage.
- Static review of relevant canonical security/checklist evidence wording.
- Original audit pass made no code fixes.
- Correction pass added code, test, and canonical evidence updates for F1 through F6; F7 was handled as an evidence-classification note.
- PHP lint passed for the touched PHP files.
- User-provided Docker validation passed for the corrected security checklist, MFA, route/action authorization, notification/settings, security-header, and runtime-readiness tests. Latest provided security correction validation: 61 tests passed, 548 assertions.
- The latest user-provided baseline before correction work was passing, except for previously known unrelated UI header dropdown coverage that has been treated separately.
- Original attempted local `php artisan route:list` failed because the local PHP environment lacked `mb_split()` and the command fell back from the UNC workspace path.
