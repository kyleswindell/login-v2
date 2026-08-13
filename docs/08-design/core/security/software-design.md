<!--
DOC-META
title: Core Security Software Design
doc_type: design
status: draft
owner: core
canonical: false
canonical_path: docs/08-design/core/security/software-design.md
parent: docs/08-design/index.md
template: docs/09-reference/templates/docs/_design.md
summary: Defines the target implementation design for Core Security cross-cutting application guardrails, request and browser protections, route-security classification, safe redirects, sensitive-context redaction, and security verification.
-->

# Core Security Software Design

Parent: [Software Design Index](../../index.md)

## 1. System Definition

### Purpose

Core Security owns cross-cutting application-security guardrails and security-control enforcement used consistently across Core, Modules, Delivery Adapters, and release verification.

Target owner:

```text
app/Core/Security/
App\Core\Security\
owner_key: security
```

Core Security owns:

* browser-response security headers;
* Content Security Policy composition;
* expected-HTTPS enforcement;
* trusted transport/proxy/host posture verification;
* route-security classification and coverage validation;
* safe redirect validation;
* request/context secret-safety redaction;
* application security verification checks;
* security-check orchestration;
* common security guardrails that do not belong to another domain owner.

Core Security does not own:

* authentication credentials, MFA, recovery, sessions, recent authentication, or step-up mechanisms;
* human User Account lifecycle;
* permissions, roles, policies, grants, effective access, or elevated-access state;
* data classification, masking, export policy, retention, or erasure;
* Audit storage or Audit query behavior;
* Monitoring failures, health state, Signals, or detections;
* Notification delivery;
* secret storage, reveal, rotation, revocation, or expiry;
* domain workflow invariants;
* infrastructure operations or deployment procedures.

Those responsibilities remain with Auth, Users, Access, DataProtection, Audit, Monitoring, Notifications, Security/Secrets, domain owners, and Operations respectively.

### Greenfield Rule

Current implementation may be reviewed for useful behavioral evidence, but it imposes no compatibility, preservation, migration, schema, or target-placement requirement on this design.

Obsolete proof-of-concept Security artifacts may be explicitly deleted during implementation when they conflict with the accepted target system.

---

## 2. Governing Requirements

Primary authority:

* `docs/07-planning/00-overview/m1-core-system-development-register.md`
* `docs/02-standards/security/Security Standards.md`
* `docs/02-standards/security/Secure Coding And Request Handling Standards.md`
* `docs/02-standards/security/Transport Session And Browser Security Standards.md`
* `docs/02-standards/security/Zero Trust Security Standards.md`
* `docs/02-standards/security/File Upload Download And Export Security Standards.md`
* `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md`
* `docs/02-standards/security/Threat Modeling And Security Controls Standards.md`
* `docs/07-planning/02-core-capabilities/security/application-security-core-planning.md`
* `docs/07-planning/02-core-capabilities/security/zero-trust-security-planning.md`
* `docs/03-architecture/public-contract-and-interaction-model.md`
* `docs/03-architecture/repository-architecture.md`
* `docs/08-design/foundation/core-runtime/software-design.md`
* `docs/08-design/foundation/application-registration/software-design.md`
* `docs/08-design/core/audit/software-design.md`
* `docs/08-design/core/monitoring/software-design.md`

The Security standards package currently remains draft. This SDD therefore defines the proposed implementation realization but does not promote unresolved Security policy into accepted canonical behavior.

Current implementation structure is reference evidence only.

---

## 3. Component Design

| Component                          | Responsibility                                                        | Target Path                                                              |
| ---------------------------------- | --------------------------------------------------------------------- | ------------------------------------------------------------------------ |
| `ResolveSafeRedirectInterface`     | Public safe-redirect Contract                                         | `app/Core/Security/Contracts/ResolveSafeRedirectInterface.php`           |
| `RedactSensitiveContextInterface`  | Public security-sensitive context-redaction Contract                  | `app/Core/Security/Contracts/RedactSensitiveContextInterface.php`        |
| `SecurityCheckInterface`           | Security release/runtime verification Extension Point                 | `app/Core/Security/Contracts/SecurityCheckInterface.php`                 |
| `SafeRedirectTarget`               | Validated redirect result                                             | `app/Core/Security/Data/SafeRedirectTarget.php`                          |
| `SensitiveContextData`             | Structured redaction input                                            | `app/Core/Security/Data/SensitiveContextData.php`                        |
| `RedactedContextData`              | Sanitized context result                                              | `app/Core/Security/Data/RedactedContextData.php`                         |
| `RedactionRuleData`                | One normalized security-redaction rule                                | `app/Core/Security/Data/RedactionRuleData.php`                           |
| `SecurityHeaderSet`                | Immutable response-header result                                      | `app/Core/Security/Data/SecurityHeaderSet.php`                           |
| `RouteSecurityProfileData`         | One route-protection profile                                          | `app/Core/Security/Data/RouteSecurityProfileData.php`                    |
| `SecurityCheckDefinitionData`      | Registered security-check definition                                  | `app/Core/Security/Data/SecurityCheckDefinitionData.php`                 |
| `SecurityCheckResult`              | One security-check result                                             | `app/Core/Security/Data/SecurityCheckResult.php`                         |
| `SecurityCheckStatus`              | Controlled check-result state                                         | `app/Core/Security/Enums/SecurityCheckStatus.php`                        |
| `RedactionScope`                   | Controlled redaction context                                          | `app/Core/Security/Enums/RedactionScope.php`                             |
| `SecurityHeaderResolver`           | Resolve security headers for one response                             | `app/Core/Security/Resolvers/SecurityHeaderResolver.php`                 |
| `SafeRedirectResolver`             | Validate and normalize safe redirect targets                          | `app/Core/Security/Resolvers/SafeRedirectResolver.php`                   |
| `SensitiveContextRedactor`         | Recursively apply Security redaction rules                            | `app/Core/Security/Redaction/SensitiveContextRedactor.php`               |
| `RedactionRuleRegistry`            | Hold accepted Security/Secrets redaction rules                        | `app/Core/Security/Registry/RedactionRuleRegistry.php`                   |
| `RouteSecurityProfileRegistry`     | Hold accepted route-security profiles                                 | `app/Core/Security/Registry/RouteSecurityProfileRegistry.php`            |
| `SecurityCheckRegistry`            | Hold accepted release/runtime security checks                         | `app/Core/Security/Registry/SecurityCheckRegistry.php`                   |
| `ApplySecurityHeadersMiddleware`   | Apply response security-header policy                                 | `app/Core/Security/Http/Middleware/ApplySecurityHeadersMiddleware.php`   |
| `RequireSecureTransportMiddleware` | Fail closed when HTTPS is required but absent                         | `app/Core/Security/Http/Middleware/RequireSecureTransportMiddleware.php` |
| `UnsafeRedirectTargetException`    | Unsafe redirect rejection                                             | `app/Core/Security/Exceptions/UnsafeRedirectTargetException.php`         |
| `InsecureTransportException`       | Expected-HTTPS enforcement failure                                    | `app/Core/Security/Exceptions/InsecureTransportException.php`            |
| `RunSecurityChecksCommand`         | Execute registered security verification                              | `app/Core/Security/Console/RunSecurityChecksCommand.php`                 |
| `SecurityServiceProvider`          | Security bindings, registries, route macro, and framework integration | `app/Core/Security/Providers/SecurityServiceProvider.php`                |
| `SecurityRegistrationDescriptor`   | Application Registration declaration                                  | `app/Core/Security/Registration/SecurityRegistrationDescriptor.php`      |

### Built-In Verification Checks

Initial checks:

```text
DebugDisabledCheck
TransportSecurityConfigurationCheck
TrustedProxyConfigurationCheck
SecurityHeaderConfigurationCheck
SessionCookieConfigurationCheck
RouteSecurityCoverageCheck
```

Target paths:

```text
app/Core/Security/Verification/Checks/
```

Do not create:

```text
SecurityManager
SecurityService
SecurityHelper
SecurityUtility
SecuritySupport
```

or another generic Security abstraction.

### Intentionally Deferred Components

Do not create yet:

```text
RequestSecurityContext
TrustDecisionService
risk scoring
trusted-device infrastructure
file-scanner adapter
quarantine scanner implementation
vulnerability-management persistence
supply-chain persistence
offensive-testing tooling
```

Those require later accepted requirements or subcapability designs.

---

## 4. Contracts And Interactions

### Safe Redirect Contract

Cross-owner code that must accept a redirect candidate from request or application input uses:

```php
interface ResolveSafeRedirectInterface
{
    public function resolve(string $candidate): SafeRedirectTarget;
}
```

The initial Contract permits:

* relative same-origin application paths;
* absolute URLs matching the current trusted application origin.

It rejects:

* protocol-relative URLs;
* credential-bearing URLs;
* non-HTTP(S) schemes;
* malformed URLs;
* control-character injection;
* host changes;
* unsafe path interpretation.

External redirects are not enabled by arbitrary caller input.

Any later approved external redirect requires an explicit Security-owned allow-list design rather than a caller-provided bypass.

Invalid input throws:

```text
UnsafeRedirectTargetException
```

The caller owns fallback or user-response behavior.

Security does not silently turn an unsafe redirect into an accepted target.

### Sensitive Context Redaction

Audit, Monitoring, exception handling, and other approved consumers may use:

```php
interface RedactSensitiveContextInterface
{
    public function redact(
        SensitiveContextData $context,
    ): RedactedContextData;
}
```

`SensitiveContextData` contains:

```text
scope
values
```

`RedactionScope` initially supports:

```text
request_body
query
headers
log_context
```

`RedactionScope::log_context` is the generic non-HTTP evidence/log context for Audit, Monitoring, exception reporting, and Security verification where applicable.

The redactor:

1. walks arrays recursively;
2. normalizes keys for matching;
3. replaces values for registered sensitive keys;
4. redacts prohibited security headers;
5. preserves field names where safe;
6. returns a new redacted result;
7. never mutates the original structure.

Baseline prohibited headers include:

```text
Authorization
Cookie
Set-Cookie
```

The complete credential/secret key catalog is extended by Security/Secrets.

DataProtection remains authoritative for semantic personal/business-data classification and masking. Security redaction does not replace DataProtection.

### Redaction Rules

Security owns Host Registry:

```text
security.redaction_rules
```

A Contribution provides `RedactionRuleData`.

Security/Secrets uses this Registry to add credential-specific rules without modifying Audit or Monitoring internals.

Core Security provides `RedactSensitiveContextInterface`. Audit consumes it before `AuditEvidenceRedactor`, and Monitoring consumes it before `MonitoringContextRedactor`. Security supplies credential/request redaction but does not absorb their semantic evidence rules.

Duplicate or contradictory normalized rules fail registration.

### Security Checks

Security exposes:

```php
interface SecurityCheckInterface
{
    public function evaluate(): SecurityCheckResult;
}
```

Security owns Host Registry:

```text
security.release_checks
```

Each Contribution identifies:

```text
contribution_key
owner_key
blocking
implementation
applicable control references
optional runbook reference
```

`SecurityCheckStatus` uses:

```text
satisfied
warning
unsatisfied
not_applicable
```

These are application security-check results and are distinct from repository workflow gate semantics.

`RunSecurityChecksCommand` uses signature:

```text
security:verify
```

Command result:

```text
all blocking checks satisfied/not applicable
    → exit 0

one or more blocking checks unsatisfied
    → non-zero exit

check execution error
    → non-zero exit
```

Warnings alone do not produce a failing exit status.

Check output must not contain secret values.

### Route Security Profiles

Every application route must eventually identify one accepted Security profile.

Security registers the route macro:

```text
securityProfile(<profile-key>)
```

The macro stores profile identity as route metadata.

`RouteSecurityProfileRegistry` resolves each key to `RouteSecurityProfileData`.

A profile may define applicable:

```text
required middleware aliases
CSRF expectation
required named rate limiter
signed-request requirement
policy-authorization requirement
sensitive-action Audit expectation
```

Security does not implement Auth or Access behavior merely because a profile requires it.

Example target relationship:

```text
route declares Security profile
        ↓
Security profile describes minimum prerequisites
        ↓
Auth supplies authentication/assurance middleware
Access supplies authorization behavior
owner supplies policy/target authorization
Security verifies required controls are actually present
```

The exact canonical profile-key vocabulary remains unresolved until the Security/Zero Trust standards are accepted.

### Rate Limiting

Core Security does not create a second rate-limiting framework.

Owners define named limiters using Laravel's native rate limiter when their behavior requires them.

Security profiles and security verification may require that a protected route references the applicable named limiter.

The owner of the protected behavior defines the actual abuse threshold.

---

## 5. Data And Persistence

Core Security owns no initial database tables.

Security guardrails are defined through:

```text
code
owner configuration
Application Registration
route metadata
security verification
```

Do not create database-backed:

```text
route security profiles
redaction rules
release checks
CSP directives
security headers
security-control execution behavior
```

merely to make them editable.

### Owner Configuration

Target configuration:

```text
app/Core/Security/config/security.php
```

It contains structural configuration for applicable:

```text
transport.expect_https
transport.trusted_proxies
transport.trusted_hosts

browser.headers
browser.csp
browser.hsts
browser.permissions_policy

redirect

redaction

verification

route_profiles
```

Application Registration loads this configuration beneath the canonical:

```text
security.*
```

configuration namespace.

Environment-specific values may map into these keys.

Exact environment-variable names are not defined by this SDD where current draft standards still use transitional naming.

### Settings Boundary

Runtime administrator-editable Security Settings are not introduced by the initial design.

When Core Settings is designed, Security may expose explicitly approved security-setting declarations.

Security defaults must not become dynamically weakenable merely because Settings infrastructure exists.

---

## 6. Delivery And Presentation

### Global HTTP Security

Core Security integrates with the Laravel HTTP pipeline.

`RequireSecureTransportMiddleware` runs before protected application route behavior.

When:

```text
security.transport.expect_https = true
```

and the trusted Laravel request context is not secure, Security rejects the request before application behavior executes.

It does not redirect an insecure authenticated request and thereby risk propagating unsafe transport state.

Exact final user-facing error rendering remains generic and contains no security-topology detail.

### Trusted Proxies And Hosts

Laravel integration must configure proxy and host trust from explicitly approved configuration.

Requirements:

* exact proxy IP/CIDR entries;
* no wildcard/all-network trust;
* only approved forwarded headers;
* host validation when application-layer host enforcement is required;
* scheme and client-address interpretation consistent with deployed topology.

Deployment infrastructure remains responsible for its own network/web-server enforcement.

### Security Headers

`ApplySecurityHeadersMiddleware` applies the result from `SecurityHeaderResolver`.

Required header families include:

```text
Content-Security-Policy
X-Content-Type-Options
Referrer-Policy
Permissions-Policy
frame protection
Strict-Transport-Security when safe
```

Fixed baseline:

```text
X-Content-Type-Options: nosniff
Referrer-Policy: strict-origin-when-cross-origin
```

CSP owns frame protection through `frame-ancestors`; `X-Frame-Options` may remain defense in depth where compatible.

HSTS is emitted only when:

* HSTS is enabled;
* the request is securely resolved;
* the configured deployment posture permits it.

The exact CSP directive allow-list, Permissions Policy, HSTS duration, and approved external origins must be accepted before implementation readiness.

### CSP

Security owns CSP composition.

CSP configuration must not be broadened automatically to make a failing frontend work.

UI, Blade, Livewire, Vite, realtime connections, and approved integrations must instead identify required origins/directives and prove them through browser verification.

New application code should avoid inline script/style requirements where practical.

### Browser Request Forgery

Core Security uses Laravel's native browser request-forgery protection.

Security does not implement a second CSRF system.

State-changing browser routes remain protected by the normal web request-forgery middleware unless an explicitly accepted webhook/integration boundary requires exclusion.

### Signed URLs

Security uses Laravel's native signed/temporary-signed URL mechanism for routes requiring cryptographic URL integrity.

A valid signature:

```text
does not grant authorization
does not grant current scope
does not replace authentication
```

Sensitive downloads must still reauthorize the current request against the owning resource.

### File Guardrails

Core Security defines cross-cutting file safety requirements but does not own file/domain workflows.

File-owning capabilities remain responsible for:

* FormRequest validation;
* expected MIME/type/size limits;
* resource authorization;
* file lifecycle;
* business meaning.

Security requires:

* no untrusted/sensitive files under public web storage;
* server-generated storage names;
* traversal-safe paths;
* private download authorization;
* safe response headers;
* signed expiry where required.

No malware-scanning dependency or scanner abstraction is introduced until a concrete high-risk upload workflow requires one.

### No Security Administration UI

The initial Core Security implementation has no database-backed or administrator-facing Security dashboard.

Security verification is exposed through:

```text
security:verify
```

and repository/deployment verification.

---

## 7. Security And Reliability

### Default Denial

Security guardrails fail closed for:

* insecure transport when HTTPS is required;
* unknown route Security profiles;
* unsafe redirect candidates;
* invalid signed URL requirements;
* structurally invalid redaction rules;
* blocking Security-check failures.

### Server-Side Enforcement

Client state must never establish Security authority.

Do not rely on:

* hidden navigation;
* hidden buttons;
* JavaScript checks;
* route location;
* administrator-looking URLs;
* prior session success;
* internal network location.

### Request Validation

Security-sensitive writes require:

```text
FormRequest
    ↓
explicit allowed fields
    ↓
type/length/state validation
    ↓
target/scope validation
    ↓
owner authorization
    ↓
owner Action
```

Core Security does not centralize domain FormRequests.

### Object Authorization

Security route classification establishes minimum prerequisites only.

It does not replace object-level authorization.

Protected owners remain responsible for checking the specific:

```text
actor
action
target
scope
```

through Core Access/public policy boundaries.

### State-Changing GET

State-changing browser routes are prohibited.

Security verification must include architecture/route tests covering known application route definitions.

### Secret Safety

Core Security redaction is a defense-in-depth boundary.

Raw credentials, session tokens, authorization headers, cookies, private keys, and other secret values must not be sent to Audit, Monitoring, security-check output, or application logs.

Security/Secrets owns the specialized credential rule catalog.

### Retry / Transaction / Idempotency

Core Security base guardrails own no database transaction.

Redirect validation, redaction, header generation, route classification, and security checks are deterministic and side-effect free except for:

* HTTP rejection;
* command output;
* framework registration.

No retry or idempotency mechanism is required.

---

## 8. Events And Operational Effects

### Audit

Core Security does not automatically Audit every rejected request.

Domain owners remain responsible for defining which security-sensitive actions and denials are Audit-worthy.

Security may provide Security-control context to Audit after Audit/Security reconciliation.

### Monitoring

Core Security does not turn every invalid request into a Monitoring Signal.

Monitoring may later consume aggregated or explicitly selected Security guardrail failures such as:

* repeated unsafe redirects;
* repeated invalid signed requests;
* transport-security failures;
* release-check failures.

Threat Detection remains a later Monitoring subcapability.

### Notifications

Core Security does not deliver Notifications.

When a later Security policy requires human attention, Core Notifications owns durable delivery.

### Security Check Contributions

Other owners may contribute release/security checks through:

```text
security.release_checks
```

The contributor owns the check's domain semantics.

Security owns:

* registration;
* execution;
* result normalization;
* blocking behavior.

### Redaction Contributions

Security/Secrets and other explicitly approved Security-owned subcapabilities may contribute rules through:

```text
security.redaction_rules
```

Consumers do not modify `SensitiveContextRedactor` directly to add domain-specific secrets.

### Application Registration

`SecurityRegistrationDescriptor` declares applicable:

* `SecurityServiceProvider`, followed explicitly by `SecretsServiceProvider`;
* Core Security `security.php` configuration and Security/Secrets `secrets.php` configuration;
* `RunSecurityChecksCommand`;
* `security.release_checks` Host Registry;
* `security.redaction_rules` Host Registry;
* `security.secret_definitions` Host Registry;
* built-in Security checks;
* Core Security built-in redaction rules;
* Security/Secrets credential redaction-rule Contributions;
* Security/Secrets `secrets.source_control` release-check Contribution;
* applicable Security/Secrets secret-definition infrastructure;
* other Security-owned framework registrations defined by this SDD.

There is exactly one Owner Registration Descriptor for `owner_key: security`. Security/Secrets is a Core Security subcapability, not a second registrable owner. The single descriptor remains declarative and may reference its implementation beneath `app/Core/Security/Secrets/`.

Provider order is explicit:

```text
SecurityServiceProvider
    before
SecretsServiceProvider
```

The parent provider establishes shared Security registries and Contracts that the Secrets subcapability consumes or extends. No separate owner dependency edge exists for Secrets.

No Security Provider is directly accumulated in root Provider configuration outside Application Registration.

### Core Runtime

Security may consume Runtime Invocation identifiers when producing safe Monitoring/Audit evidence.

Runtime identifiers never constitute authentication, authorization, or trust.

---

## 9. Implementation Manifest

| Change | Path | Archetype | Responsibility | Dependencies | Requirement Source | Verification | Compatibility |
| --- | --- | --- | --- | --- | --- | --- | --- |
| CREATE | `app/Core/Security/Contracts/ResolveSafeRedirectInterface.php` | Contract | Expose safe redirect resolution | `SafeRedirectTarget` | `docs/03-architecture/public-contract-and-interaction-model.md` | Safe redirect security test | None |
| CREATE | `app/Core/Security/Contracts/RedactSensitiveContextInterface.php` | Contract | Expose Security-sensitive context redaction | Sensitive and redacted context data | `docs/03-architecture/public-contract-and-interaction-model.md` | Sensitive context redactor test | None |
| CREATE | `app/Core/Security/Contracts/SecurityCheckInterface.php` | Contract | Define Security check Extension Point | Security check result | `docs/03-architecture/public-contract-and-interaction-model.md` | Security check Registry test | None |
| CREATE | `app/Core/Security/Data/SafeRedirectTarget.php` | Data Object | Represent a validated redirect target | None | `docs/02-standards/security/Secure Coding And Request Handling Standards.md` | Safe redirect security test | None |
| CREATE | `app/Core/Security/Data/SensitiveContextData.php` | Data Object | Carry structured redaction input | `RedactionScope` | `docs/02-standards/security/Security Standards.md` | Sensitive context redactor test | None |
| CREATE | `app/Core/Security/Data/RedactedContextData.php` | Data Object | Carry sanitized context output | `RedactionScope` | `docs/02-standards/security/Security Standards.md` | Sensitive context redactor test | None |
| CREATE | `app/Core/Security/Data/RedactionRuleData.php` | Data Object | Represent one redaction rule | None | `docs/02-standards/security/Security Standards.md` | Redaction Rule Registry test | None |
| CREATE | `app/Core/Security/Data/SecurityHeaderSet.php` | Data Object | Represent resolved response headers | None | `docs/02-standards/security/Transport Session And Browser Security Standards.md` | Browser Security headers test | None |
| CREATE | `app/Core/Security/Data/RouteSecurityProfileData.php` | Data Object | Represent one route-security mechanism profile | Route Security Profile Registry | `docs/02-standards/security/Zero Trust Security Standards.md` | Route security coverage test | None |
| CREATE | `app/Core/Security/Data/SecurityCheckDefinitionData.php` | Data Object | Represent one security-check Contribution | `SecurityCheckInterface` | `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` | Security Check Registry test | None |
| CREATE | `app/Core/Security/Data/SecurityCheckResult.php` | Data Object | Report one security-check result | `SecurityCheckStatus` | `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` | Security command test | None |
| CREATE | `app/Core/Security/Enums/SecurityCheckStatus.php` | Enum | Define security-check result states | None | `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` | Security command test | None |
| CREATE | `app/Core/Security/Enums/RedactionScope.php` | Enum | Define Security redaction scopes | None | `docs/02-standards/security/Security Standards.md` | Sensitive context redactor test | None |
| CREATE | `app/Core/Security/Resolvers/SecurityHeaderResolver.php` | Resolver | Resolve one response's security headers | Security configuration | `docs/02-standards/security/Transport Session And Browser Security Standards.md` | Security Header Resolver test | None |
| CREATE | `app/Core/Security/Resolvers/SafeRedirectResolver.php` | Resolver | Validate and normalize redirect candidates | Safe Redirect Contract | `docs/02-standards/security/Secure Coding And Request Handling Standards.md` | Safe redirect security test | None |
| CREATE | `app/Core/Security/Redaction/SensitiveContextRedactor.php` | Redactor | Apply Security redaction rules | Redaction Rule Registry | `docs/02-standards/security/Security Standards.md` | Sensitive context redactor test | None |
| CREATE | `app/Core/Security/Registry/RedactionRuleRegistry.php` | Registry | Hold accepted redaction rules | Redaction Rule data | `docs/03-architecture/public-contract-and-interaction-model.md` | Redaction Rule Registry test | None |
| CREATE | `app/Core/Security/Registry/RouteSecurityProfileRegistry.php` | Registry | Hold unresolved-vocabulary route-profile mechanisms | Route Security Profile data | `docs/03-architecture/public-contract-and-interaction-model.md` | Route security coverage test | None |
| CREATE | `app/Core/Security/Registry/SecurityCheckRegistry.php` | Registry | Hold accepted release checks | Security Check Contract | `docs/03-architecture/public-contract-and-interaction-model.md` | Security Check Registry test | None |
| CREATE | `app/Core/Security/Http/Middleware/ApplySecurityHeadersMiddleware.php` | Middleware | Apply resolved response headers | Security Header Resolver | `docs/02-standards/security/Transport Session And Browser Security Standards.md` | Apply Security headers middleware test | None |
| CREATE | `app/Core/Security/Http/Middleware/RequireSecureTransportMiddleware.php` | Middleware | Fail closed for insecure required transport | Security configuration | `docs/02-standards/security/Transport Session And Browser Security Standards.md` | Secure transport middleware test | None |
| CREATE | `app/Core/Security/Exceptions/UnsafeRedirectTargetException.php` | Exception | Signal unsafe redirect rejection | None | `docs/02-standards/security/Secure Coding And Request Handling Standards.md` | Safe redirect security test | None |
| CREATE | `app/Core/Security/Exceptions/InsecureTransportException.php` | Exception | Signal expected-HTTPS rejection | None | `docs/02-standards/security/Transport Session And Browser Security Standards.md` | Secure transport middleware test | None |
| CREATE | `app/Core/Security/Verification/Checks/DebugDisabledCheck.php` | Security Check | Verify debug mode is disabled | Security check Contract | `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` | Security command test | None |
| CREATE | `app/Core/Security/Verification/Checks/TransportSecurityConfigurationCheck.php` | Security Check | Verify transport configuration | Security check Contract | `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` | Security command test | None |
| CREATE | `app/Core/Security/Verification/Checks/TrustedProxyConfigurationCheck.php` | Security Check | Verify trusted proxy configuration | Security check Contract | `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` | Security command test | None |
| CREATE | `app/Core/Security/Verification/Checks/SecurityHeaderConfigurationCheck.php` | Security Check | Verify header configuration | Security check Contract | `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` | Security command test | None |
| CREATE | `app/Core/Security/Verification/Checks/SessionCookieConfigurationCheck.php` | Security Check | Verify session-cookie configuration | Security check Contract | `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` | Security command test | None |
| CREATE | `app/Core/Security/Verification/Checks/RouteSecurityCoverageCheck.php` | Security Check | Verify route security coverage | Route Profile Registry | `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` | Route security coverage test | None |
| CREATE | `app/Core/Security/Console/RunSecurityChecksCommand.php` | Command | Execute registered security checks | Security Check Registry | `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` | Security command test | None |
| CREATE | `app/Core/Security/Providers/SecurityServiceProvider.php` | Provider | Bind parent Security services and registries | Security owner artifacts | `docs/03-architecture/application-registration.md` | Security registration test | None |
| CREATE | `app/Core/Security/Secrets/Providers/SecretsServiceProvider.php` | Provider | Bind Secrets subcapability services after parent Security | Security registries and Secrets Contracts | `docs/03-architecture/application-registration.md` | Security registration test | None |
| CREATE | `app/Core/Security/Registration/SecurityRegistrationDescriptor.php` | Registration Descriptor | Declare the complete single Security owner composition | Security and Secrets owner artifacts | `docs/03-architecture/application-registration.md` | Security registration architecture proof | None |
| CREATE | `app/Core/Security/config/security.php` | Configuration | Define Core Security configuration | Laravel configuration | `docs/03-architecture/repository-architecture.md` | Security configuration test | None |
| CREATE | `app/Core/Security/Secrets/config/secrets.php` | Configuration | Define Secrets subcapability configuration | Laravel configuration | `docs/03-architecture/repository-architecture.md` | Secrets serialization/redaction test | None |
| MODIFY | `bootstrap/app.php` | Laravel integration | Configure trusted transport, hosts, and global middleware | Laravel HTTP pipeline | `docs/03-architecture/repository-architecture.md` | Security integration proof | None |
| DELETE | `app/Http/Middleware/ApplySecurityHeaders.php` | Obsolete proof-of-concept artifact | Remove superseded header middleware | None | `docs/03-architecture/repository-architecture.md` | Security route coverage test | Delete obsolete proof-of-concept artifact; no preservation requirement |
| DELETE | `app/Http/Middleware/ConfigureTrustedProxies.php` | Obsolete proof-of-concept artifact | Remove superseded proxy middleware | None | `docs/03-architecture/repository-architecture.md` | Secure transport test | Delete obsolete proof-of-concept artifact; no preservation requirement |
| DELETE | `app/Core/Modules/Definitions/RuntimeSecurity.php` | Obsolete proof-of-concept artifact | Remove superseded security metadata | None | `docs/03-architecture/repository-architecture.md` | Security registration architecture proof | Delete obsolete proof-of-concept artifact; no preservation requirement |
| CREATE | `app/Core/Security/__tests__/SafeRedirectResolverTest.php` | Test | Prove safe redirect resolution | Safe Redirect Resolver | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `app/Core/Security/__tests__/SensitiveContextRedactorTest.php` | Test | Prove Security context redaction | Sensitive Context Redactor | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `app/Core/Security/__tests__/SecurityHeaderResolverTest.php` | Test | Prove response header resolution | Security Header Resolver | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `app/Core/Security/__tests__/RequireSecureTransportMiddlewareTest.php` | Test | Prove required transport enforcement | Transport Middleware | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `app/Core/Security/__tests__/ApplySecurityHeadersMiddlewareTest.php` | Test | Prove header application | Header Middleware | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `app/Core/Security/__tests__/RedactionRuleRegistryTest.php` | Test | Prove redaction-rule registration | Redaction Rule Registry | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `app/Core/Security/__tests__/RouteSecurityProfileRegistryTest.php` | Test | Prove route-profile mechanism | Route Profile Registry | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `app/Core/Security/__tests__/SecurityCheckRegistryTest.php` | Test | Prove security-check registration | Security Check Registry | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `app/Core/Security/__tests__/RunSecurityChecksCommandTest.php` | Test | Prove security-check execution | Security command | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `app/Core/Security/__tests__/SecurityRegistrationTest.php` | Test | Prove one Security owner declaration and provider order | Security Registration Descriptor | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `tests/Feature/Security/TransportSecurityTest.php` | Test | Prove transport security | Security HTTP integration | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `tests/Feature/Security/BrowserSecurityHeadersTest.php` | Test | Prove browser headers | Security HTTP integration | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `tests/Feature/Security/RouteSecurityCoverageTest.php` | Test | Prove route coverage mechanism | Route Profile Registry | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `tests/Feature/Security/RequestForgeryProtectionTest.php` | Test | Prove native request-forgery protection | Laravel middleware | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `tests/Feature/Security/SafeRedirectSecurityTest.php` | Test | Prove redirect rejection behavior | Safe Redirect Resolver | `docs/02-standards/testing/index.md` | Targeted Security proof | None |
| CREATE | `tests/Feature/Security/SignedUrlSecurityTest.php` | Test | Prove signed URLs do not bypass authorization | Laravel signed URLs | `docs/02-standards/testing/index.md` | Targeted Security proof | None |

Core Security owns no initial persistence or administration UI.

---

## 10. Verification And Completion

Required proof must establish:

* HTTPS-required requests fail closed when transport is insecure;
* approved HTTPS requests succeed;
* trusted proxy configuration rejects wildcard trust;
* expected trusted-host restrictions are enforced where configured;
* `X-Content-Type-Options` is present;
* required Referrer Policy is present;
* configured CSP is present;
* configured Permissions Policy is present;
* HSTS appears only under approved secure conditions;
* `SecurityHeaderResolver` resolves response headers and is consumed by `ApplySecurityHeadersMiddleware`;
* unsafe redirect targets are rejected;
* same-origin redirect targets are accepted;
* protocol-relative redirects are rejected;
* credential-bearing redirect URLs are rejected;
* request/body/query/header/log context is recursively redacted;
* prohibited security headers are never retained in redacted context;
* duplicate/conflicting redaction rules fail;
* Security/Secrets can extend redaction without changing consumers;
* Audit and Monitoring consume `RedactSensitiveContextInterface` before their owner-specific redactors;
* unknown route Security profile fails verification;
* routes missing required Security classification fail coverage verification;
* required route middleware/rate limiting matches the accepted profile;
* state-changing browser GET routes are absent;
* Laravel request-forgery protection remains active on browser writes;
* signed-route validity does not bypass current authorization;
* duplicate Security-check contribution identities fail;
* blocking unsatisfied Security checks cause `security:verify` to exit non-zero;
* warnings do not incorrectly block verification;
* check output contains no secrets;
* Security has no database tables;
* exactly one Security owner registration exists for `owner_key: security`, declares both providers in order, and includes `security.secret_definitions`;
* Security does not absorb Auth, Access, DataProtection, Audit, Monitoring, Notifications, or Secrets ownership;
* obsolete conflicting proof-of-concept Security middleware/metadata is removed.

### Required Reconciliation Before Acceptance

1. **Security standards acceptance** — the applicable Security standards package is currently draft.
2. **Route Security profile vocabulary** — exact canonical profile keys remain unresolved between Application Security and Zero Trust planning.
3. **Auth integration** — exact authentication, MFA, and recent-auth middleware/Contract names must come from the later Core Auth design.
4. **Access integration** — exact authorization/profile requirements must come from the later Core Access design.
5. **Security/Secrets** — exact credential-sensitive redaction rule catalog must come from the next Secrets SDD.
6. **CSP policy** — exact CSP directives and approved third-party origins require accepted browser-security policy.
7. **Permissions Policy / HSTS** — exact directives and HSTS lifetime require accepted Security policy.
8. **Settings integration** — any dynamically configurable Security setting must wait for the Core Settings design.
9. **Audit/Monitoring reconciliation** — their owner-specific redactors should consume Core Security's security-sensitive redaction Contract where applicable while retaining their own semantic evidence rules.

### Implementation Ready

* [x] Core Security ownership is defined.
* [x] Auth/Access/DataProtection/Audit/Monitoring boundaries are defined.
* [x] browser-header architecture is defined.
* [x] secure-transport enforcement architecture is defined.
* [x] safe-redirect Contract is defined.
* [x] security-sensitive redaction Contract is defined.
* [x] release/security-check Extension Point is defined.
* [x] Security-check execution behavior is defined.
* [x] route-security profile mechanism is defined.
* [x] native CSRF/signed-link boundary is defined.
* [x] file-security ownership boundary is defined.
* [x] no persistence requirement exists.
* [x] Application Registration integration is defined.
* [x] proof-of-concept cleanup is identified.
* [x] implementation manifest is defined.
* [x] verification surfaces are defined.
* [ ] applicable Security standards are accepted.
* [ ] canonical route-profile vocabulary is accepted.
* [ ] Auth and Access profile requirements are reconciled.
* [ ] Security/Secrets redaction rules are reconciled.
* [ ] CSP, Permissions Policy, and HSTS policy values are accepted.
* [ ] later Settings/Audit/Monitoring dependencies are reconciled.
* [ ] no material design blocker remains.

**Design state: draft; the Core Security implementation architecture is defined, but final acceptance waits on Security-policy and downstream Contract reconciliation.**
