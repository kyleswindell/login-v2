# API, Webhook, And Service Account Security Planning

Status: Planning

## Purpose

Plan secure machine-to-machine access for Login 2.0 before API tokens, webhook receivers, outbound webhooks, service accounts, external integrations, scheduled jobs, Microsoft Graph, QuickBooks, or future client APIs deepen.

This planning document does not create final standards, runbooks, schema, runtime folders, dashboards, or active batch state.

## Direction

API, webhook, and service-account security should not become a business module.

Do not create:

```text
Modules/API
Modules/Webhooks
Modules/ServiceAccounts
```

Final rule:

```text
Every machine-to-machine interaction must have an explicit identity, scoped access, protected secret, validated request, rate limit, audit trail, monitoring signal, and revocation path.
```

## Ownership

Use this ownership split:

| Owner | Responsibility |
| --- | --- |
| `app/Core/Auth` | Service account authentication, API token verification, token hashing, token creation/revocation, credential verification helper integration. |
| `app/Core/Auth/ServiceAccounts` | Optional future service account authentication/lifecycle support when machine identities become concrete. |
| `app/Core/Auth/ApiTokens` | Optional future API token model, token generation, prefix/hash verification, expiry, revocation, and last-use updates. |
| `app/Core/Identity` | Service account identity records if service accounts are identity-owned records; owner/contact/escalation metadata. |
| `app/Core/Access` | Service account groups, roles, policies, scopes, permissions, target scope, and effective access. |
| `app/Core/Security` | API route tiers, request guardrails, validation conventions, rate limits, replay/idempotency rules, webhook security posture. |
| `app/Core/Security/Api` | Optional future API request middleware, API route tiers, JSON request validation, payload limits, rate/quotas. |
| `app/Core/Security/Webhooks` | Optional future webhook signature validation, replay protection, idempotency, endpoint/delivery metadata, async processing guardrails. |
| `app/Core/Security/Secrets` | Webhook secrets, API token handling, rotation, redaction, leak handling, credential inventory. |
| `app/Core/Audit` | Service actor events, token creation/revocation, webhook delivery/receipt, API access and denial evidence. |
| `app/Core/Monitoring` | Token abuse, webhook failures, denied API spikes, replay attempts, high request volume, stale service account signals. |
| `app/Core/Notifications` | Token expiring, token leaked, webhook failing, service account disabled, stale owner alerts. |
| `app/Core/DataProtection` | Classify API/webhook payloads, exports, sensitive data movement, and DLP movement decisions. |
| `app/Core/Security/VulnerabilityManagement` | Hardcoded token findings, leaked token findings, vulnerable API surface findings, release gates. |

## Planned Source Documents

Content accepted from this planning pass should be promoted into the correct owner branches before implementation:

| Needed Document | Branch Responsibility | Purpose |
| --- | --- | --- |
| `docs/02-standards/security/api-webhook-service-account-security.md` | Standards | Parent machine-access rules for API tokens, service accounts, webhooks, scopes, validation, rate limits, and evidence. |
| `docs/02-standards/security/api-security.md` | Standards | Optional split for API route, request, versioning, schema, throttling, and documentation rules. |
| `docs/02-standards/security/webhook-security.md` | Standards | Optional split for inbound/outbound webhook signing, replay, idempotency, retries, and payload retention rules. |
| `docs/02-standards/security/service-accounts.md` | Standards | Optional split for non-human identity lifecycle, owner, purpose, access, credential, review, and audit rules. |
| `docs/10-runbooks/api-token-compromise.md` | Runbooks | Response procedure for leaked, abused, expired, or suspicious API tokens. |
| `docs/10-runbooks/webhook-secret-rotation.md` | Runbooks | Webhook signing secret rotation and provider coordination procedure. |

If standards need fewer files first, start with the combined parent standard and split the others later.

DLP and exfiltration direction is tracked in [DLP And Exfiltration Detection Planning](dlp-exfiltration-detection-planning.md). Machine-access APIs and webhooks should eventually evaluate sensitive response and payload movement through DataProtection before data leaves the application boundary.

## Human Users Versus Service Accounts

Do not use normal human accounts as integration identities.

Rules:

- never use a Super Admin user token for automation
- never issue API tokens that inherit all human permissions by default
- never use a normal browser-login account as a long-lived integration identity
- service accounts cannot log in through browser sessions unless a future decision explicitly approves it
- API machine access should start with service-account-only tokens, not user-owned personal API keys

Service account baseline:

```text
not a human
cannot use browser login
explicit owner
explicit purpose
environment
scoped access policies
hashed API tokens
disable/revoke path
auditable actor identity
```

## Identity Model

Two options remain possible:

| Option | Direction | Tradeoff |
| --- | --- | --- |
| `users.type = service` | Extends the existing User model with `human`, `service`, and `system` types. | Simpler with Laravel assumptions, but can leak browser-user assumptions into machine identities. |
| Dedicated `service_accounts` table | Models service accounts separately from human users. | Cleaner long-term boundary, more explicit Access subject handling. |

Recommendation while still planning:

```text
Use dedicated service account records unless implementation constraints prove `users.type = service` is materially safer.
```

Keep the Access subject resolver generic:

```text
Access subject = user | service_account | group | integration | system
```

## Candidate Tables

### `service_accounts`

```text
id
key
name
description
owner_user_id
purpose
environment
status
risk_level
allowed_ip_ranges nullable
expires_at nullable
last_used_at nullable
created_by
created_at
updated_at
disabled_at nullable
disabled_by nullable
```

### `api_tokens`

```text
id
tokenable_type
tokenable_id
name
prefix
token_hash
abilities_json
last_used_at
last_used_ip
last_used_user_agent
expires_at
revoked_at
revoked_by
created_by
created_at
updated_at
```

For MVP, only issue API tokens to service accounts.

### Optional `api_token_events`

Prefer Audit first. Add a dedicated high-volume event table only if Audit/Monitoring cannot support token telemetry safely.

```text
id
api_token_id
event_type
ip_address
user_agent
request_id
result
created_at
```

## Token Storage Rule

Store:

- token prefix
- token hash
- last-used metadata
- expiration
- status

Never store:

- raw token value

Generation pattern:

```text
login2_live_<prefix>_<secret>
```

Show the raw token once.

## API Authentication Flow

```text
Request arrives
  -> extract Authorization: Bearer token
  -> parse prefix
  -> look up token by prefix
  -> hash/constant-time compare submitted token
  -> check token not revoked
  -> check token not expired
  -> check service account active
  -> build ServiceActor security context
  -> apply rate limits
  -> apply Access policy
  -> execute action
  -> audit sensitive result
  -> update last-used metadata
  -> Monitoring checks for suspicious pattern
```

Do not use browser sessions for API service accounts.

## API Route Tiers

Add machine/API tiers to Security route classification:

| Tier | Scope | Baseline |
| --- | --- | --- |
| `API-0` | Public API docs or health, if any. | No sensitive data; rate limited. |
| `API-1` | Authenticated machine API. | Service token required; rate limited; JSON request validation; audit sensitive writes. |
| `API-2` | Scoped business API. | Service token; Access subject is service account; target scope required; object-level authorization. |
| `API-3` | Restricted data API. | Explicit restricted permission; DataProtection check; reason/request ID where appropriate; audit every restricted request/download/export. |
| `API-4` | Webhook receiver. | HMAC/OAuth/signature verification; replay protection; idempotency; dedicated delivery metadata; safe async processing. |

## API Request Validation

Every API write endpoint must:

- use FormRequest or equivalent request object
- validate JSON content type
- reject unexpected fields
- validate IDs against service account scope
- enforce request body size limit
- normalize enum/status values
- support idempotency where duplicate processing would be harmful

Potential future middleware:

```text
app/Core/Security/Api/Http/Middleware/EnsureJsonApiRequest.php
app/Core/Security/Api/Http/Middleware/LimitApiPayloadSize.php
app/Core/Security/Api/Http/Middleware/RequireApiIdempotencyKey.php
```

## API Authorization

Machine API access must check more than token validity:

```text
token belongs to active service account
service account has ability
service account has target scope
requested object belongs to target scope
data classification allows this action
```

Runtime check shape:

```php
$decision = $access->allows(
    actor: $serviceAccount,
    ability: 'orders.create',
    target: $customer,
    context: $apiRequestContext,
);
```

Service account management permissions:

```text
service_accounts.view
service_accounts.create
service_accounts.update
service_accounts.disable
service_accounts.rotate_tokens
service_accounts.revoke_tokens
service_accounts.audit
```

Business API permissions should be explicit:

```text
api.customers.read
api.orders.create
api.inventory.read
api.shipments.create
api.exports.create
```

Do not automatically map browser permissions to API permissions.

## Rate Limits And Quotas

Use both per-token and per-route controls.

Per-token examples:

```text
api:{token_id}:60/min
api:{service_account_id}:1000/hour
```

Per-route examples:

```text
/api/orders lower limit
/api/health higher limit
/api/exports very low limit
/webhooks/* provider-specific limit
```

Quota examples:

```text
requests per day
exports per day
records per export
failed auth attempts per hour
webhook retries per event
```

Potential future services:

```text
app/Core/Security/Api/Services/ApiRateLimitPolicy.php
app/Core/Security/Api/Services/ApiQuotaService.php
```

## API Versioning And Documentation

Use:

```text
routes/api.php
/api/v1/...
```

Do not expose unstable internal controllers as public APIs.

Future API reference path:

```text
docs/09-reference/api/v1.md
```

Every API endpoint should document:

```text
method
path
auth method
required permission
target/scope behavior
request schema
response schema
rate limit
audit behavior
errors
idempotency behavior
```

## Webhook Security

Inbound webhook baseline:

```text
HMAC signature verification
timestamp check
nonce/event ID replay prevention
constant-time comparison
idempotency
provider-specific validation
private secret storage
audit and monitoring
```

Webhook route flow:

```text
POST /webhooks/{provider}
  -> verify provider exists and is active
  -> read raw request body
  -> verify timestamp freshness
  -> verify HMAC signature using provider secret
  -> check event ID/idempotency key has not been processed
  -> store webhook delivery metadata
  -> queue processing job
  -> return 2xx quickly
  -> process async
  -> audit result
  -> monitor failures/retries
```

Do not do heavy business processing directly in the webhook request.

## Candidate Webhook Tables

### `webhook_endpoints`

```text
id
provider_key
name
description
status
secret_reference_id
signature_header
timestamp_header
event_id_header
allowed_ip_ranges nullable
created_by
created_at
updated_at
disabled_at nullable
```

### `webhook_deliveries`

```text
id
webhook_endpoint_id
provider_event_id
signature_valid
replay_detected
status
received_at
processed_at
failed_at
failure_reason
headers_redacted_json
payload_hash
payload_json nullable
created_at
updated_at
```

Payload storage decision:

| Payload Need | Direction |
| --- | --- |
| Sensitive payload and no replay/debug need | Store hash plus selected safe metadata only. |
| Replay/debug needed | Store encrypted payload, redact sensitive fields, apply retention policy. |

### `webhook_processing_attempts`

```text
id
webhook_delivery_id
attempt
status
started_at
finished_at
failure_reason
created_at
updated_at
```

## Webhook Verification Service

Potential future service:

```text
app/Core/Security/Webhooks/Services/WebhookSignatureVerifier.php
```

Responsibilities:

- build canonical payload
- compute HMAC
- constant-time compare
- validate timestamp tolerance
- validate nonce/event ID
- return typed result

Reject:

- missing signature
- invalid signature
- timestamp too old
- duplicate event already processed
- disabled endpoint
- payload too large
- unsupported content type

## Outbound Webhooks

If Login 2.0 later sends webhooks to clients:

- endpoint URL must be HTTPS
- sign payload with HMAC
- include event ID
- include timestamp
- include retry count
- send minimal payload
- retry with backoff
- stop after max attempts
- log delivery attempts
- allow endpoint disable

Potential tables:

```text
outbound_webhook_subscriptions
outbound_webhook_deliveries
outbound_webhook_attempts
```

Do not include secrets or full confidential payloads unless explicitly required and authorized.

## Secrets Integration

API tokens:

- generated once
- shown once
- stored as prefix plus hash
- rotate/revoke support

Webhook secrets:

- encrypted or vault-backed
- rotation support
- never logged
- never displayed after creation unless a vault-backed reveal flow exists

Service account credentials:

- stored as references or encrypted secrets
- owner required
- expiration/rotation policy required

Add secret types to Secrets Management planning:

```text
ApiToken
WebhookSecret
ServiceCredential
IntegrationCredential
```

## Audit Events

Service account events:

```text
service_account.created
service_account.updated
service_account.disabled
service_account.reenabled
service_account.owner_changed
service_account.access_policy_created
service_account.access_policy_revoked
```

API token events:

```text
api_token.created
api_token.rotated
api_token.revoked
api_token.expired
api_token.used
api_token.denied
api_token.leak_detected
```

API request events:

```text
api.request_denied
api.restricted_action_succeeded
api.export_requested
api.bulk_action_requested
api.scope_violation_denied
```

Webhook events:

```text
webhook.received
webhook.signature_failed
webhook.replay_rejected
webhook.processing_succeeded
webhook.processing_failed
webhook.endpoint_disabled
webhook.secret_rotated
```

Audit actor types:

```text
service_account
webhook_provider
integration
system
```

## Monitoring Detections

Planned detection keys:

```text
DET-API-001 repeated invalid API token attempts
DET-API-002 API token used after long inactivity
DET-API-003 API token used from new IP/user-agent
DET-API-004 API request rate spike
DET-API-005 API scope violation spike
DET-API-006 API token nearing expiration
DET-API-007 API token expired but still used

DET-WEBHOOK-001 invalid webhook signature spike
DET-WEBHOOK-002 webhook replay attempt
DET-WEBHOOK-003 webhook processing failures
DET-WEBHOOK-004 provider event backlog
DET-WEBHOOK-005 disabled endpoint received traffic

DET-SERVICE-001 service account used outside expected scope
DET-SERVICE-002 service account disabled but token used
DET-SERVICE-003 service account has no owner
DET-SERVICE-004 service account has stale access
DET-SERVICE-005 service account token unrotated beyond policy
```

Planned notification type keys:

```text
security.api.invalid_token_spike
security.api.scope_violation
security.api.token_expiring
security.webhook.signature_failure
security.webhook.replay_detected
security.webhook.processing_failed
security.service_account.stale_access
security.service_account.owner_missing
```

## Route And Surface Direction

| Surface | Target Route File | Visible URLs | Notes |
| --- | --- | --- | --- |
| API routes | `app/Core/Security/Api/Routes/api.php` or `routes/api.php` with Core ownership | `/api/v1/*` | Machine/API access only; no browser session assumptions. |
| Webhook receivers | `app/Core/Security/Webhooks/Routes/webhooks.php` | `/webhooks/{provider}` | Signature-verified inbound POST endpoints; async processing. |
| Service accounts admin | `app/Core/Auth/ServiceAccounts/Routes/admin-service-accounts.php` | future `/admin/security/service-accounts` | Admin surface after service account model exists. |

Do not build admin UI before enforcement exists.

Potential later UI:

```text
Admin
  Security
    Service accounts
    API tokens
    Webhooks
    API activity
```

Never show a raw token after creation.

## Optional App Folder Direction

```text
app/Core/Auth/ServiceAccounts/
  Actions/
  Data/
  Enums/
  Models/
  Services/
  Support/

app/Core/Auth/ApiTokens/
  Actions/
  Data/
  Enums/
  Models/
  Services/
  Http/Middleware/
  Support/

app/Core/Security/Api/
  Data/
  Enums/
  Http/Middleware/
  Services/
  Support/

app/Core/Security/Webhooks/
  Actions/
  Data/
  Enums/
  Http/
  Models/
  Services/
  Support/
```

First classes when implementation is approved:

```text
app/Core/Auth/ServiceAccounts/Models/ServiceAccount.php
app/Core/Auth/ApiTokens/Models/ApiToken.php
app/Core/Auth/ApiTokens/Services/ApiTokenService.php
app/Core/Auth/ApiTokens/Http/Middleware/AuthenticateApiToken.php
app/Core/Security/Webhooks/Services/WebhookSignatureVerifier.php
app/Core/Security/Webhooks/Http/Middleware/VerifyWebhookSignature.php
app/Core/Security/Api/Services/ApiRateLimitPolicy.php
```

## Test Planning

First tests:

```text
ApiTokenShownOnceTest
ApiTokenStoredHashedTest
ExpiredApiTokenDeniedTest
RevokedApiTokenDeniedTest
ServiceAccountDisabledDeniedTest
ServiceAccountScopePolicyTest
ApiObjectLevelAuthorizationTest
ApiRateLimitTest
WebhookSignatureVerificationTest
WebhookReplayRejectedTest
WebhookDuplicateDeliveryIdempotentTest
WebhookPayloadRedactionTest
WebhookProcessingQueuedTest
ApiTokenRotationAuditTest
```

Test matrix summary:

```text
token hash verification
expired/revoked token denial
service account status denial
object-level API scope checks
rate limits
webhook HMAC verification
replay rejection
idempotent processing
audit events
no raw token or secret logging
```

## Implementation Sequence

Do not build service accounts before:

- Audit actor model exists
- Security redaction exists
- Access resolver supports non-human subject
- Auth/token hashing conventions exist
- Monitoring can detect token/webhook abuse

Recommended sequence:

1. Promote the combined API/webhook/service-account security standard.
2. Promote API token compromise and webhook secret rotation runbooks.
3. Decide dedicated `service_accounts` table versus `users.type = service`.
4. Define service actor audit shape.
5. Define token generation, prefix/hash storage, expiry, revocation, and rotation rules.
6. Add service account access subject support.
7. Add API auth middleware and rate-limit policy.
8. Add webhook signature verifier and replay/idempotency checks.
9. Add audit events and monitoring detections.
10. Add admin UI surfaces only after enforcement exists.

## Transition Rules

- Do not build public REST APIs for every module.
- Do not build an OAuth/OIDC provider in the first slice.
- Do not build a complex API gateway inside Laravel.
- Do not build a full developer portal.
- Do not build UI for service accounts before token model security exists.
- Do not build webhook payload replay UI before payload retention classification exists.
- Do not issue user-owned personal API keys in the first implementation.
- Do not issue Super Admin API tokens.
- Do not store raw API tokens, webhook secrets, or provider credentials in logs, audit, monitoring, notifications, exports, or support views.

## Open Decisions

- Should service accounts use a dedicated `service_accounts` table or `users.type = service`?
- Should API tokens be generic `tokenable` records from day one or service-account-only records first?
- Which service account actions require owner approval, elevated access, recent auth, or MFA?
- Which API scopes are platform-level versus business-module-owned?
- Which webhook payloads can be stored, and which must be hash/metadata only?
- Which rate-limit and quota rules are default for the first machine API?
- Which service account events require persistent notifications?
- Should service account access reviews be part of the first Access Reviews implementation?

## Related

- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)
- [Service Accounts And Machine Identity Planning](service-accounts-machine-identity-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Threat Detection And Response Planning](threat-detection-response-planning.md)
- [Detection Use Case Matrix](detection-use-case-matrix.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
