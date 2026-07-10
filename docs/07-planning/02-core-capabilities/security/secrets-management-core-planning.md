# Secrets Management Core Planning

Status: Planning

## Purpose

Plan Secrets Management as a dedicated `Core/Security/Secrets` sub-capability before Auth hardening, integration credentials, release gates, secret inventory, or app-visible secret administration expand.

Secrets Management is not a business module and should not be implemented as `Modules/Secrets`.

Initial implementation should be a security baseline, not an internal vault and not a dashboard-first build.

## Target Ownership

```text
app/Core/Security/Secrets
```

Secrets Management owns:

- secret inventory metadata
- secret type and storage-kind vocabulary
- storage reference rules
- secret redaction patterns
- reveal, copy, download, rotate, and revoke guardrails
- rotation and expiry policy
- secret health-check planning
- leak-detection and release-gate inputs
- future vault integration boundary

Secrets Management does not own:

- raw production vault storage
- Auth workflows
- user lifecycle records
- Access policy engine
- Audit storage
- Monitoring storage
- domain-specific integration meaning
- business module records

Ownership rule:

```text
DataProtection = how sensitive app data is classified, masked, exported, retained, erased, and protected.
Secrets = how credentials that authenticate systems, services, workloads, integrations, or privileged flows are inventoried, redacted, revealed, rotated, and health-checked.
```

Secrets are a special restricted data class because misuse can grant access to another system or privileged app surface.

## Source Model

Use two separate inputs:

```text
Secrets-management security model
  -> lifecycle, access, rotation, storage, auditing, health, and release gates

Secret/API-key UI patterns
  -> safe admin behavior for creation, reveal, copy, rotation, and confirmation flows
```

Do not treat UI pattern guidance as the backend security architecture. The backend plan must own least privilege, strong storage rules, redaction, rotation, monitoring, and audit evidence.

## What Counts As A Secret

### Auth-Owned Secrets

Examples:

- password hashes
- password reset tokens
- invitation tokens
- remember tokens
- session identifiers
- TOTP secrets
- MFA recovery codes
- future WebAuthn credential material

Handling intent:

| Value | Storage Rule |
| --- | --- |
| passwords | hash only |
| password reset tokens | hash only |
| invitation tokens | hash only |
| recovery codes | hash only |
| TOTP secrets | encrypted |
| sessions | server-side storage; never logged raw |
| remember tokens | restricted; never logged raw |

Auth owns the flows and verification behavior. Secrets Management owns handling rules, redaction patterns, reveal/display policy, and tests that prevent Auth secret leakage.

### App/System Secrets

Examples:

- `APP_KEY`
- database credentials
- mail credentials
- queue/cache credentials
- backup encryption keys
- webhook signing secrets
- build/deploy tokens
- CI/CD tokens

Handling intent:

- store in environment, vault, or host secret store
- never commit
- never expose in UI
- never store in normal app tables
- redact from logs, debug output, monitoring records, audit records, and error pages

### Integration And Business Module Secrets

Examples:

- QuickBooks credentials
- Microsoft Graph credentials
- OAuth refresh tokens
- external API keys
- webhook secrets
- client-specific integration credentials
- future service account tokens

Handling intent:

- prefer vault reference
- otherwise use encrypted application storage only when the app must read the value later
- access through a resolver service only
- require rotation policy
- audit reveal, copy, use, rotation, and revocation without storing raw values

Business modules own why a credential exists and what domain it connects to. Secrets Management owns how the credential is protected and handled.

## Storage Decision Rule

Use this rule:

```text
Can the app verify without reading the value?
  -> hash it.

Must the app read and use the value later?
  -> encrypt it or store a vault reference.

Is it infrastructure/deployment-only?
  -> keep it outside the application database.

Is it generated for the user once?
  -> show it once, then store only hash/fingerprint/prefix where possible.
```

Examples:

| Value | Handling |
| --- | --- |
| Password | hash |
| Recovery code | hash |
| Password reset token | hash |
| Invitation token | hash |
| TOTP secret | encrypt |
| OAuth refresh token | encrypt or vault reference |
| Webhook signing secret | encrypt or vault reference |
| App-generated API token | show once, store prefix and hash |
| Service account credential | encrypt, vault reference, or prefix plus hash depending verification need |
| Integration credential | encrypt or vault reference |
| `APP_KEY` | environment/secret store only |
| `DB_PASSWORD` | environment/secret store only |

Do not encrypt every column by default. Encrypting fields affects search, indexing, support workflows, debugging, and migration complexity. Restrict field encryption to values the app must later read and that cannot be stored as a hash or external reference.

## Target Folder Shape

Long-term target:

```text
app/Core/Security/Secrets/
  Actions/
  Contracts/
  Data/
  Enums/
  Events/
  Http/
  Models/
  Policies/
  Queries/
  Services/
  Support/
  Routes/
```

Candidate classes:

```text
Actions/RegisterSecretReference.php
Actions/RotateSecret.php
Actions/RevokeSecret.php
Actions/RevealSecret.php
Actions/CopySecretValue.php
Actions/RecordSecretUse.php
Actions/RunSecretHealthChecks.php

Contracts/SecretStore.php
Contracts/SecretResolver.php
Contracts/SecretRedactor.php
Contracts/RotatesSecrets.php

Data/SecretReferenceData.php
Data/SecretValue.php
Data/SecretRotationResult.php
Data/SecretHealthCheckResult.php
Data/SecretRevealContext.php

Enums/SecretType.php
Enums/SecretStorageKind.php
Enums/SecretStatus.php
Enums/SecretRiskLevel.php
Enums/SecretRotationStatus.php

Services/SecretInventory.php
Services/SecretValueResolver.php
Services/SecretRedactionService.php
Services/SecretRotationService.php
Services/SecretHealthService.php
Services/SecretLeakScanner.php
Services/VaultSecretStore.php

Support/SecretFingerprint.php
Support/SecretDisplayValue.php
Support/SecretRedactionPatterns.php
```

MVP should create only what is needed for the security baseline:

- `app/Core/Security/Secrets/Enums`
- `app/Core/Security/Secrets/Services/SecretRedactionService.php`
- `app/Core/Security/Secrets/Services/SecretInventory.php`
- `app/Core/Security/Secrets/Support/SecretRedactionPatterns.php`

Do not start with a persistent admin dashboard.

## Access Model

Future permission vocabulary:

```text
secrets.view
secrets.view_metadata
secrets.reveal
secrets.rotate
secrets.revoke
secrets.audit
secrets.health.view
secrets.accept_risk
```

Sensitive secret operations require:

```text
auth
identity.active
auth.mfa
auth.recent
secrets.reveal or secrets.rotate or secrets.revoke
```

Access Control owns permission evaluation and policy enforcement. Secrets Management defines which actions are sensitive and which guardrails they require.

## Admin UI Intent

Future admin route:

```text
/admin/security/secrets
```

This surface should not exist until the baseline produces real inventory, rotation, and health-check evidence.

Secret lists must show metadata only:

- name
- type
- owner
- environment
- storage kind
- status
- last rotated
- expires
- last used
- risk
- actions

Never show raw secret values in tables.

Secret detail should show:

- summary metadata
- consumers
- rotation state
- access history
- health checks
- audit history

Reveal flow should be a dedicated confirmation path:

```text
User clicks Reveal
  -> require permission
  -> require recent authentication
  -> show warning
  -> require confirmation
  -> reveal briefly
  -> provide copy action
  -> close automatically
  -> audit reveal and copy
```

Recommended warning copy:

```text
Only reveal this secret in a private environment. Anyone who can see your screen or clipboard may be able to use this credential.
```

Generated secrets should prefer one-time display. If the system can avoid storing the raw value, store only a prefix, fingerprint, and hash.

## Redaction Baseline

Secrets Management should be the canonical source for secret-like redaction patterns consumed by Security, Audit, Monitoring, and DataProtection helpers.

Initial redaction keys:

```text
password
password_confirmation
current_password
token
secret
api_key
access_token
refresh_token
authorization
cookie
set-cookie
mfa_secret
otp
recovery_code
private_key
client_secret
webhook_secret
```

Redaction rules must apply before request context, audit metadata, monitoring records, exception reports, or notification payloads are persisted.

## Integration With Core Capabilities

### Core/Auth

Auth owns authentication flows. Secrets Management owns secret handling policy and leak-prevention checks.

Auth-aligned tests should cover:

- TOTP secret encrypted at rest
- recovery codes stored hashed
- recovery codes shown once
- password reset tokens stored hashed
- no Auth secret appears in Audit or Monitoring metadata

### Core/Access

Access owns who can view metadata, reveal values, rotate, revoke, audit, or accept risk.

Secrets Management defines the action vocabulary and sensitivity requirements.

### Core/DataProtection

DataProtection classifies secrets as restricted data.

Default handling intent:

```text
classification = restricted
export_allowed = false
masking_required = true
audit_level = high
```

DataProtection owns export, masking, classification, retention, and erasure policy. Secrets Management owns credential-specific handling and reveal/rotation guardrails.

### Core/Security

Core/Security owns the broader guardrail boundary:

- route tiers
- request redaction
- safe redirects
- signed URLs
- upload/download guardrails
- release checks

Secrets Management provides the credential-specific redaction patterns, leak scanner inputs, and secret release-gate checks.

### Core/Audit

Audit records lifecycle and access events without raw values.

Event examples:

```text
secrets.registered
secrets.revealed
secrets.copied
secrets.rotated
secrets.revoked
secrets.expired
secrets.health_check_failed
secrets.access_denied
secrets.risk_accepted
```

Audit metadata may include:

- secret reference ID
- secret type
- storage kind
- fingerprint
- actor
- reason
- environment
- result
- request/session context

Audit metadata must not include:

- raw secret value
- full token
- full private key
- full authorization header
- raw session cookie
- raw recovery code

### Core/Monitoring

Monitoring owns operational detection and health state:

- expired secrets
- rotation failures
- health-check failures
- failed vault reads
- secret reveal spikes
- unexpected secret access attempts
- suspected leaked secret findings

Monitoring should trigger persistent notifications for required security events such as expiration, failed rotation, vault unavailability, or leak detection.

### Core/Notifications

Notifications delivers required security/system notices. Future notification types may include:

```text
security.secret.expiring
security.secret.expired
security.secret.rotation_failed
security.secret.rotated
security.secret.revealed
security.secret.leak_detected
```

Persistent security notifications must not be fully user-disableable. Users may control optional future email/digest channels only after those channels exist.

### Core/VulnerabilityManagement

Secrets are a vulnerability-management input.

Finding types should include:

```text
hardcoded_secret
committed_env_file
exposed_api_key
expired_secret
unrotated_secret
secret_in_log
secret_in_exception_context
public_storage_secret
weak_secret_rotation
```

Release gates may block promotion when:

- `.env` is committed
- `APP_KEY` appears in repository files
- known token or secret patterns appear in code
- raw authorization or cookie headers appear in error evidence
- a critical secret leak finding is open and unaccepted

## Candidate Data Projection

Do not store raw secret values in application registry tables.

The first implementation may remain code/config/runbook-only. A future database projection may add metadata tables when inventory, stale detection, expiry reporting, or dashboard review requires persistence.

Candidate future table:

```text
secret_references
```

Candidate metadata:

- key
- name
- description
- type
- owner key
- environment
- storage kind
- storage reference
- fingerprint
- status
- risk level
- last rotated timestamp
- expiry timestamp
- last used timestamp
- created by
- timestamps

Candidate storage kinds:

```text
env
vault
encrypted_database
hash_only
generated_once
external_platform
```

Candidate future rotation table:

```text
secret_rotation_events
```

Use Audit first for access events. Add a separate `secret_access_events` table only if high-volume operational analytics prove Audit is not enough.

Any final schema must be promoted to `docs/06-database` before implementation.

## Implementation Sequence

### 1. Planning And Standards Alignment

- Add `Core/Security/Secrets` to the core service matrix.
- Promote final handling rules into security standards before code work.
- Keep operational rotation/recovery procedures in runbooks.
- Keep schema contracts in database docs only when persistence is approved.

### 2. Security Baseline

- Add redaction pattern definitions.
- Add secret handling decision rules.
- Add release-check expectations for committed env files and obvious secret leakage.
- Add no-raw-secret assertions for Audit and Monitoring evidence.

### 3. Auth Secret Hardening

- Verify encrypt-vs-hash treatment for existing Auth secrets.
- Verify one-time display expectations for recovery codes and generated secrets.
- Verify Auth secret values cannot enter audit, monitoring, notifications, or generic export paths.

### 4. Inventory Metadata

- Add a lightweight inventory contract for known app/system/integration secrets.
- Track owner, type, storage kind, environment, risk, expiry, and rotation expectations.
- Keep raw values outside the inventory.

### 5. Access And Reveal Guardrails

- Define `secrets.*` permissions.
- Require MFA/recent-authentication for reveal, rotation, revoke, and risk acceptance.
- Add reveal/copy/rotation audit semantics.

### 6. Rotation And Health Checks

- Add rotation status and expiry windows.
- Add health-check result contracts.
- Wire Monitoring and required Notifications only after real check evidence exists.

### 7. Optional Admin UI

- Build `/admin/security/secrets` only after inventory and check evidence exist.
- Use metadata-first list/detail views.
- Use dedicated confirmation flows for reveal, copy, revoke, rotate, and risk acceptance.

### 8. Optional Vault Integration

- Add a `SecretStore` contract only when external vault or environment-store integration is scoped.
- Do not build an internal vault by default.

## Test Planning

Expected first coverage:

- secret redaction patterns remove known keys from request/audit/monitoring context
- `APP_KEY`, database passwords, authorization headers, cookies, recovery codes, and TOTP secrets do not appear in logs, audit metadata, monitoring records, notifications, or debug evidence
- Auth TOTP secrets are encrypted when the app must read them later
- recovery, reset, invitation, and one-time tokens are hashed when only verification is needed
- generated API tokens are shown once and stored as prefix plus hash when implemented
- reveal, rotate, revoke, and risk-acceptance actions require recent authentication and MFA when implemented
- reveal/copy/rotate/revoke events audit safe metadata only
- release checks detect committed env files or obvious secret patterns when release gates are implemented

## Transition Rules

- Do not create `Modules/Secrets`.
- Do not build an internal Laravel vault as the first implementation.
- Do not store infrastructure secrets in normal app database tables.
- Do not show secret values in tables.
- Do not allow ordinary settings forms to edit production secrets without a dedicated secret flow.
- Do not rely on hidden UI controls as the security boundary.
- Do not put production secrets in docs, tickets, screenshots, seeders, factories, tests, or example config.
- Do not persist raw secret values in Audit, Monitoring, Notifications, release evidence, or support views.
- Do not create a secrets dashboard before redaction, inventory, storage rules, release checks, and Auth hardening have a baseline.

## Open Decisions

- Which redaction patterns are mandatory for the first security baseline?
- Which Auth secret storage checks should be implemented before moving Auth under `app/Core/Auth`?
- Should `secret_references` be added immediately after inventory metadata exists, or remain code/config-only until dashboard review is needed?
- Which operations require both MFA and `auth.recent` in the first Access integration?
- Which secret finding blocks the first release gate: committed `.env`, `APP_KEY` pattern, authorization header leakage, or critical scanner result?
- Which external vault or host secret store should be supported first, if any?

## Out Of Scope

- implementing `app/Core/Security/Secrets` in this pass
- building a secrets admin dashboard in this pass
- building an internal vault in this pass
- adding final database schema in this pass
- changing deployment secret storage in this pass
- editing `/docs/08-active/`

## Related

- [Core Service Build Plan Matrix](core-service-build-plan-matrix.md)
- [Core Capability Package Migration Planning](core-capability-package-migration-planning.md)
- [Application Security Core Planning](application-security-core-planning.md)
- [Data Protection Core Planning](data-protection-core-planning.md)
- [Auth Core Implementation Planning](auth-core-implementation-planning.md)
- [Access Control Implementation Planning](access-control-implementation-planning.md)
- [Audit And Monitoring Core Planning](audit-monitoring-core-planning.md)
- [Vulnerability Management Core Planning](vulnerability-management-core-planning.md)
- [Incident Response Planning](incident-response-planning.md)
- [Backup And Recovery Planning](backup-recovery-planning.md)
- [Service Accounts And Machine Identity Planning](service-accounts-machine-identity-planning.md)
- [API, Webhook, And Service Account Security Planning](api-webhook-service-account-security-planning.md)
