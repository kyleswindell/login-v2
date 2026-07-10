# Service Accounts And Machine Identity Planning

Status: Planning

## Purpose

Plan service accounts, machine identity, API tokens, integration actors, and non-human access before API/integration authentication is implemented.

This capability is not a business module. It is a cross-cutting Auth, Identity, Access, Secrets, Audit, Monitoring, and Vulnerability Management concern.

## Ownership Boundary

| Owner | Responsibility |
| --- | --- |
| `Core/Auth` | service authentication mechanisms, token verification, credential rotation mechanics |
| `Core/Identity` | service account identity record, owner, lifecycle state, contact/escalation metadata |
| `Core/Access` | scoped permissions, policies, roles, groups, resource boundaries, least privilege |
| `Core/Security/Secrets` | credential storage rules, token hash/prefix handling, secret inventory, rotation policy |
| `Core/Audit` | service actor events and accountable use history |
| `Core/Monitoring` | anomalous service use, failed authentication spikes, stale/unused service identities |
| `Core/Notifications` | required alerts for credential expiry, rotation failure, abnormal use, or disabled service accounts |
| `Core/VulnerabilityManagement` | exposed token findings, weak rotation findings, stale service account risk |

Do not model machine identity as a normal human user without an explicit lifecycle and audit decision.

## Initial Service Account Model

Each service or machine identity should eventually have:

- stable key
- display name
- description/purpose
- owner user or owner group
- environment
- status
- credential type
- allowed scopes/actions
- resource constraints
- expiry or review date
- rotation policy
- last used timestamp
- created by
- disabled/revoked timestamp

Open schema decision:

```text
users.type = service
```

or

```text
service_accounts
```

Do not decide this through implementation drift. Resolve it through Auth, Identity, Access, Audit, and database planning before code.

## Credential Handling

Credential types may include:

- generated API token
- personal access token equivalent, if approved
- service account client secret
- OAuth client credential
- webhook signing secret
- integration refresh token
- future certificate/private key material

Storage rules:

- generated tokens should be shown once and stored as prefix plus hash when only verification is needed
- credentials the app must use later should be encrypted or stored as vault references
- infrastructure-only secrets should stay in environment/vault/host secret store
- raw credentials must not enter Audit, Monitoring, Notifications, support views, docs, tests, seeders, factories, or screenshots

Secrets Management owns the handling rules. Auth owns verification and authentication flow.

## Access Model

Service accounts should default to least privilege:

- no broad inherited human role by default
- explicit scope/resource boundaries
- no interactive login unless explicitly approved
- no MFA bypass by pretending to be a human user
- no Super Admin service account without a separate decision
- no shared ownerless service account

Sensitive operations require:

- explicit service account permission
- owner/reason metadata
- audit event
- rotation or expiry policy
- review cadence

## Audit And Monitoring

Audit must support non-human actors.

Service account audit events should include:

- actor type: service
- service account key or ID
- owner
- action
- target
- result
- credential ID or fingerprint where safe
- request/source context where safe

Monitoring should detect:

- failed service authentication spikes
- service account used from unexpected source
- stale service account
- token nearing expiry
- token rotation failure
- disabled account usage attempt
- abnormal volume or route use

## Notification Intent

Future persistent notification types may include:

```text
security.service_account.created
security.service_account.disabled
security.service_account.credential_expiring
security.service_account.rotation_failed
security.service_account.unusual_use_detected
security.service_account.stale_review_due
```

These are required system/security notifications and should not be user-disableable in the inbox.

## API And Webhook Review Dependency

Broader API, webhook, and integration security direction is tracked in [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md).

Do not implement API tokens, webhook receivers, webhook senders, or external integration credentials only from this service-account plan. The API/webhook/service-account security plan defines request authentication, signing, replay protection, rate limits, retries, payload redaction, failure handling, token storage, and event/audit expectations before those surfaces deepen.

Zero Trust direction is tracked in [Zero Trust Security Planning](zero-trust-security-planning.md). Service and machine identities should use scoped permissions, explicit actors, credential rotation, no implicit internal trust, and audit-visible activity.

## Implementation Sequence

### 1. Planning Decision

- Decide whether service accounts use `users.type = service` or a dedicated table.
- Define service actor audit shape before API token implementation.
- Define token storage and rotation rules through Secrets Management.

### 2. Minimal Identity Contract

- Add service account lifecycle states.
- Add owner/contact metadata.
- Add disabled/revoked behavior.

### 3. Auth Credential Contract

- Define token/client credential verification.
- Store generated credentials safely.
- Add rotation and expiry metadata.
- Align API token and webhook security with [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md).

### 4. Access Contract

- Define scoped permissions and resource constraints.
- Prevent broad human-role inheritance unless explicitly approved.
- Add review requirements for privileged service accounts.

### 5. Audit, Monitoring, And Notifications

- Add service actor audit events.
- Add monitoring signals for stale, failed, expired, or abnormal service usage.
- Add required notification types for owners/security admins.

## Test Planning

Future implementation tests should prove:

- service accounts cannot use normal interactive login unless explicitly approved
- generated tokens are shown once and stored as prefix plus hash
- disabled service account credentials fail
- service account actions audit actor type `service`
- service accounts cannot receive broad admin access by default
- service account credentials are not logged or exported
- stale/expiring credentials can create Monitoring signals and required notifications

## Transition Rules

- Do not create `Modules/ServiceAccounts`.
- Do not implement service/API tokens before Auth, Identity, Access, Audit, and Secrets boundaries are agreed.
- Do not share human user assumptions silently with service accounts.
- Do not store raw API tokens or client secrets.
- Do not create ownerless service accounts.
- Do not allow service accounts to bypass object-level authorization.

## Open Decisions

- Should service accounts be represented by `users.type = service` or a dedicated `service_accounts` table?
- Which service authentication method comes first?
- Which service account actions require owner approval or elevated access?
- What is the first rotation/expiry policy?
- Which service account events require persistent notifications?
- Should service account access reviews be part of the first Access Reviews implementation?

## Out Of Scope

- implementing service accounts in this pass
- implementing API tokens in this pass
- choosing final database schema in this planning file
- creating OAuth/OIDC client credential flows in this pass
- editing `/docs/08-active/`

## Related

- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Cybersecurity Review Backlog Planning](cybersecurity-review-backlog-planning.md)
- [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md)
- [Zero Trust Security Planning](zero-trust-security-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Identity And Users Core Capability Implementation Planning](users-module-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Secrets Management Core Planning](secrets-management-core-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
