<!--
DOC-META
title: Core Security Secrets Software Design
doc_type: design
status: draft
owner: core
canonical: false
canonical_path: docs/08-design/core/security/secrets/software-design.md
parent: docs/08-design/index.md
template: docs/09-reference/templates/docs/_design.md
summary: Defines the target implementation design for Security Secrets credential handling, storage decisions, reversible protection, redaction, one-time exposure, lifecycle guardrails, inventory definitions, health requirements, and release verification.
-->

# Core Security Secrets Software Design

Parent: [Software Design Index](../../../index.md)

## 1. System Definition

### Purpose

Core Security / Secrets defines the reusable security mechanisms and handling requirements for credentials and reusable secret material.

Target owner:

```text
app/Core/Security/Secrets/
App\Core\Security\Secrets\
```

Parent capability:

```text
Core Security
owner_key: security
```

Secrets owns:

* secret-type vocabulary;
* approved storage-kind vocabulary;
* storage-decision requirements;
* reversible secret-value protection;
* secret-definition inventory metadata;
* one-time-display requirements;
* reveal/copy guardrails;
* rotation, revocation, expiry, and review requirements;
* credential-specific redaction rules;
* secret-health requirements;
* secret-safe release verification;
* future external secret-store integration boundary.

Secrets does **not** own:

* password, MFA, session, recovery, or authentication workflows;
* User or Non-Human Identity lifecycle;
* permissions or authorization decisions;
* the business meaning of integration credentials;
* Audit storage;
* Monitoring storage or Signals;
* Notification delivery;
* data-classification policy;
* infrastructure secret-store operations;
* an internal application vault.

### Ownership Model

```text
Domain owner
    → why the credential exists
    → domain lifecycle/workflow
    → domain persistence where applicable

Security / Secrets
    → how secret material may be stored
    → how retrievable values are protected
    → how values may be exposed
    → redaction
    → rotation/revocation/expiry requirements
    → health/release requirements
```

Examples:

```text
Auth
    owns TOTP enrollment and verification
Security / Secrets
    owns requirement that retrievable TOTP material is encrypted

Auth
    owns recovery-code verification
Security / Secrets
    owns requirement that verification-only recovery codes are hashed

Integration owner
    owns OAuth/provider workflow
Security / Secrets
    owns protection and handling requirements for refresh tokens
```

### Greenfield Rule

Current implementation may be reviewed for useful behavioral evidence, but it imposes no compatibility, preservation, migration, schema, or target-placement requirement on this design.

Obsolete proof-of-concept Secrets handling may be deleted during implementation where it conflicts with the accepted target model.

---

## 2. Governing Requirements

Primary authority:

* `docs/07-planning/00-overview/m1-core-system-development-register.md`
* `docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md`
* `docs/02-standards/security/Secrets Management Standards.md`
* `docs/02-standards/security/Security Standards.md`
* `docs/02-standards/security/Zero Trust Security Standards.md`
* `docs/02-standards/security/API Webhook And Service Account Security Standards.md`
* `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md`
* `docs/03-architecture/public-contract-and-interaction-model.md`
* `docs/03-architecture/persistent-data-architecture.md`
* `docs/08-design/core/security/software-design.md`
* `docs/08-design/core/audit/software-design.md`
* `docs/08-design/core/monitoring/software-design.md`
* `docs/08-design/foundation/application-registration/software-design.md`

The Secrets Management standard currently remains `status: draft`. It must be accepted before this SDD is finalized.

The initial implementation is a Secrets security foundation. It does not create a generic credential database, internal vault, or Secrets administration dashboard.

---

## 3. Component Design

| Component                         | Responsibility                                 | Target Path                                                                  |
| --------------------------------- | ---------------------------------------------- | ---------------------------------------------------------------------------- |
| `SecretCipherInterface`           | Public reversible-protection Contract          | `app/Core/Security/Secrets/Contracts/SecretCipherInterface.php`              |
| `SecretDefinitionData`            | One owner-controlled secret definition         | `app/Core/Security/Secrets/Data/SecretDefinitionData.php`                    |
| `SecretRotationPolicyData`        | Rotation/expiry/review requirements            | `app/Core/Security/Secrets/Data/SecretRotationPolicyData.php`                |
| `SecretHealthPolicyData`          | Define secret-health requirement metadata without depending on Monitoring implementation | `app/Core/Security/Secrets/Data/SecretHealthPolicyData.php` |
| `SecretOperationRequirementsData` | Reveal/copy/rotate/revoke prerequisites        | `app/Core/Security/Secrets/Data/SecretOperationRequirementsData.php`         |
| `EncryptedSecretValue`            | Safe encrypted-string representation           | `app/Core/Security/Secrets/Data/EncryptedSecretValue.php`                    |
| `SecretFingerprint`               | Safe high-entropy secret fingerprint/prefix    | `app/Core/Security/Secrets/Data/SecretFingerprint.php`                       |
| `SecretType`                      | Secret category vocabulary                     | `app/Core/Security/Secrets/Enums/SecretType.php`                             |
| `SecretStorageKind`               | Approved storage strategy                      | `app/Core/Security/Secrets/Enums/SecretStorageKind.php`                      |
| `SecretExposurePolicy`            | Secret display/reveal policy                   | `app/Core/Security/Secrets/Enums/SecretExposurePolicy.php`                   |
| `SecretOperation`                 | Sensitive secret operations                    | `app/Core/Security/Secrets/Enums/SecretOperation.php`                        |
| `SecretHealthSeverity`            | Security/Secrets typed representation of shared health severity | `app/Core/Security/Secrets/Enums/SecretHealthSeverity.php` |
| `SecretValue`                     | Non-serializable in-memory raw secret wrapper  | `app/Core/Security/Secrets/ValueObjects/SecretValue.php`                     |
| `LaravelSecretCipher`             | Laravel-backed reversible string encryption    | `app/Core/Security/Secrets/Encryption/LaravelSecretCipher.php`               |
| `SecretFingerprintResolver`       | Generate permitted prefix/fingerprint evidence | `app/Core/Security/Secrets/Resolvers/SecretFingerprintResolver.php`          |
| `SecretDefinitionRegistry`        | Host Registry for owner secret definitions     | `app/Core/Security/Secrets/Registry/SecretDefinitionRegistry.php`            |
| `SecretRedactionRules`            | Built-in credential redaction definitions      | `app/Core/Security/Secrets/Definitions/SecretRedactionRules.php`             |
| `SecretSourceControlCheck`        | Blocking source/release secret-safety check    | `app/Core/Security/Secrets/Verification/Checks/SecretSourceControlCheck.php` |
| `SecretsServiceProvider`          | Bind Secrets runtime services after parent Security registration | `app/Core/Security/Secrets/Providers/SecretsServiceProvider.php` |

`SecretHealthSeverity` contains exactly:

```text
informational
low
medium
high
critical
```

It is a provider-local enum using the shared serialized severity vocabulary.

It does not import:

```text
MonitoringSeverity
Monitoring contracts
Monitoring models
```

No generic:

```text
SecretManager
SecretsService
SecretsHelper
VaultService
CredentialManager
```

is introduced.

---

## 4. Contracts And Interactions

### Secret Definition Registry

Secrets owns Host Registry:

```text
security.secret_definitions
```

Owners contribute definitions through Application Registration.

The Contribution identity provides the stable secret-definition identity.

Example:

```text
registry_key: security.secret_definitions
contribution_key: auth.totp_secret
```

A `SecretDefinitionData` contains:

```text
ownerKey
secretType
storageKind
purpose
safeStorageReference
exposurePolicy
rotationPolicy
healthPolicy
operationRequirements
```

`safeStorageReference` may identify only a safe storage location or configuration identity such as:

```text
Auth-owned encrypted field
configuration key
environment-variable name
external-secret reference name
```

It must never contain the raw value.

### Secret Types

`SecretType` initially supports:

```text
application_key
database_credential
api_token
oauth_client_secret
oauth_refresh_token
webhook_secret
totp_secret
private_key
integration_credential
backup_encryption_key
service_account_credential
session_material
other
```

Secret type does not transfer workflow ownership to Security/Secrets.

### Storage Decision

`SecretStorageKind`:

```text
hash_only
encrypted_owner_storage
external_reference
host_environment
```

Rules:

```text
verification only
    → hash_only

application must retrieve the secret later
    → encrypted_owner_storage
      or external_reference

infrastructure/deployment only
    → host_environment
      or external_reference
```

`encrypted_owner_storage` means:

> The owner stores the encrypted ciphertext in its own persistence.

Security/Secrets does **not** require all encrypted secrets to live in a central Secrets table.

Examples:

```text
Auth TOTP secret
    → Auth-owned field
    → encrypted_owner_storage

recovery code
    → Auth-owned field
    → hash_only

OAuth refresh token
    → integration-owned field
    → encrypted_owner_storage or external_reference

DB password
    → host_environment or external_reference
```

General Settings storage is not an approved raw-secret store.

### Reversible Secret Protection

Owners that must retrieve secret material consume:

```php
interface SecretCipherInterface
{
    public function encrypt(
        SecretValue $value,
    ): EncryptedSecretValue;

    public function decrypt(
        EncryptedSecretValue $value,
    ): SecretValue;
}
```

`LaravelSecretCipher` wraps Laravel's string-encryption Contract rather than implementing another cryptographic system.

Laravel 13's `StringEncrypter` provides dedicated `encryptString()` and `decryptString()` operations for non-serialized strings.

Security/Secrets therefore does not define:

* its own cipher;
* its own encryption format;
* key derivation;
* custom cryptographic primitives.

### SecretValue

`SecretValue` exists only to make raw-value handling explicit.

It must:

* hold the raw value privately;
* expose it only through an explicit method;
* not implement `Stringable`;
* redact its value from debug output;
* reject serialization;
* reject JSON serialization;
* never be placed into Events, Jobs, Notifications, session data, or cache payloads.

Example conceptual API:

```php
final class SecretValue
{
    public function reveal(): string;

    public function __debugInfo(): array;
}
```

`__debugInfo()` must never expose the value.

### EncryptedSecretValue

`EncryptedSecretValue` contains ciphertext only.

It may cross owner persistence boundaries because it is not plaintext secret material.

It must not imply that encrypted material is safe for:

* logs;
* Audit metadata;
* Notifications;
* URLs;
* user-visible output.

### Hashing Boundary

Security/Secrets defines **when** a value must use hash-only storage.

It does not define one generic hashing algorithm for all secret types.

The owning capability selects an approved verification mechanism appropriate to the credential.

For example, password hashing remains Auth behavior; Secrets does not replace Laravel/Auth password hashing with a generic token hasher.

### Exposure Policy

`SecretExposurePolicy`:

```text
never
one_time
controlled_reveal
```

Meaning:

**never**

The raw value must never be rendered through an application UI after initial ingestion/generation.

**one_time**

The raw generated value may be returned once during its creation flow and must not be retrievable afterward.

**controlled_reveal**

A retrievable value may be revealed only through an explicitly protected operation.

### Secret Operations

`SecretOperation`:

```text
reveal
copy
rotate
revoke
```

Each supported operation has `SecretOperationRequirementsData` defining applicable:

```text
allowed
requiresMfa
requiresRecentAuthentication
requiresReason
auditRequired
```

Security/Secrets defines these sensitivity requirements.

Auth later supplies authentication-assurance Contracts.

Access later supplies permission/target authorization.

The owner performing the operation remains responsible for:

```text
authentication
authorization
target scope
domain/provider operation
transaction/remote effect
Audit call timing
```

Consumers obtain the immutable requirements for `reveal`, `copy`, `rotate`, or `revoke` from the registered `SecretDefinitionData` and its `SecretOperationRequirementsData`. Those requirements describe `allowed`, `requiresMfa`, `requiresRecentAuthentication`, `requiresReason`, and `auditRequired`; they do not authorize an Actor.

Auth and Access later enforce assurance, permission, and target scope. The credential/domain owner performs the provider/domain operation, transaction or remote side effect, and Audit timing. An unsupported operation is rejected because its definition reports `allowed = false`.

No Secrets authorization Policy is required for this structural lookup.

---

## 5. One-Time Secret Handling

Generated verification credentials should use one-time display whenever later retrieval is unnecessary.

Target sequence:

```text
owner generates high-entropy value
        ↓
raw value enters SecretValue
        ↓
owner derives required hash
        ↓
optional safe prefix/fingerprint
        ↓
raw SecretValue returned in successful creation response once
        ↓
raw value discarded
```

Persist only applicable:

```text
hash
prefix
fingerprint
owner
purpose
created_at
expires_at
rotation/revocation state
```

Never persist the raw value merely so the UI can display it again.

Typical uses:

```text
generated API token
recovery credential
one-time setup credential
future Service Account token
```

A value classified `one_time` must not later be converted into `controlled_reveal` without an accepted design change.

---

## 6. Fingerprints And Safe Display

`SecretFingerprintResolver` is used only for high-entropy generated secrets where the owning definition explicitly permits fingerprinting.

It returns:

```text
safe prefix
SHA-256 fingerprint
```

The fingerprint is identification evidence, not an authentication credential.

Do not fingerprint:

* human passwords;
* submitted MFA values;
* recovery-code plaintext;
* other low-entropy or user-selected secrets;

merely to make them searchable.

Safe display example:

```text
prefix: sk_live_ab12…
fingerprint: 8f21…
```

The complete raw secret is never used as a display label.

---

## 7. Redaction

Security/Secrets is the canonical credential-specific source for Security's redaction-rule registry.

It contributes to:

```text
security.redaction_rules
```

defined by Core Security.

Initial mandatory normalized keys:

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

Redaction must apply before data enters:

```text
Audit metadata
Monitoring context
exception context
Notifications
support output
test output
CI evidence
release evidence
```

Security owns the redaction engine.

Security/Secrets owns credential-specific rules.

Audit and Monitoring retain their own evidence-specific semantic minimization.

DataProtection retains personal/business-data classification and masking.

---

## 8. Rotation, Revocation, Expiry, And Health

### Rotation Policy

`SecretRotationPolicyData` defines applicable:

```text
rotationRequired
rotationIntervalDays
expiryRequired
expiryIntervalDays
reviewIntervalDays
overlapStrategyRequired
rollbackProcedureRequired
```

Every production secret definition must identify:

* owner;
* purpose;
* rotation procedure;
* expiry or review cadence;
* dependent systems;
* failure handling;
* compromise response.

Long-lived production secrets without ownership are prohibited.

### Rotation Ownership

Security/Secrets defines rotation requirements.

It does **not** generically rotate external provider credentials.

Example:

```text
QuickBooks integration owner
    → performs provider credential rotation

Security/Secrets
    → requires approved protection
    → requires overlap/rollback where necessary
    → requires safe Audit evidence
    → requires health/expiry behavior
```

This avoids a generic Secrets component becoming an integration orchestrator.

### Revocation

A definition declaring `revoke` support must identify the owner that can actually invalidate the credential.

Revoked credentials must fail subsequent owner verification/use.

Security/Secrets does not simulate revocation by merely hiding a value.

### Expiry

Expiry is enforced by the credential owner or external store.

Security/Secrets defines the expiry requirements and health thresholds.

### Health Policy

`SecretHealthPolicyData` describes Security-owned requirements:

```text
healthCheckRequired
expiryWarningDays
rotationWarningDays
failureSeverity: SecretHealthSeverity
runbookReference
```

Security/Secrets defines:

* whether a secret requires health observation;
* warning thresholds;
* the required failure significance;
* the applicable runbook reference.

It does not own:

* health-check execution;
* Monitoring occurrences;
* Monitoring Signals;
* alert delivery.

Security/Secrets does not import Core Monitoring's:

```text
HealthCheckInterface
HealthCheckDefinitionData
MonitoringSeverity
HealthCheckRegistry
```

and `SecurityRegistrationDescriptor` does not declare `monitoring` as an owner dependency.

This preserves the dependency direction:

```text
Monitoring
    → Security

Security
    ↛ Monitoring
```

For a concrete credential owned by another capability, that capability may independently consume:

* its Security/Secrets definition; and
* Monitoring's public health-check Extension Point

when its own accepted design legitimately depends on both.

That credential owner maps:

```text
SecretHealthSeverity serialized value
    ↓ one-to-one canonical severity value
MonitoringSeverity serialized value
```

without making the PHP enum types cross-owner dependencies.

If a future Security-owned secret itself requires dynamic Monitoring integration, that requirement must be designed through a non-cyclic consumer/integration boundary rather than by adding a Security → Monitoring dependency.

The initial Security/Secrets foundation does not create such an adapter.

---

## 9. Data And Persistence

### Initial Security/Secrets Persistence

Core Security/Secrets owns **no initial database tables**.

Secret inventory is code/registration metadata through:

```text
security.secret_definitions
```

Secret material remains:

```text
hash
    → owner persistence

encrypted ciphertext
    → owner persistence

external reference
    → owner persistence/configuration

infrastructure secret
    → environment/host/external secret store
```

This avoids creating a second credential source of truth.

### No Central Raw Secret Store

Do not create:

```text
secret_values
credentials
vault_entries
encrypted_secrets
```

as a generic application-owned raw-secret database.

### Future Persistent Inventory

A future persistent `secret_references` projection may be introduced only when a real requirement exists for:

* dynamic managed secret inventory;
* expiry review;
* rotation workflow state;
* administration;
* stale-reference detection;
* external-vault coordination.

That expansion requires:

```text
accepted /06-database Contract
updated Secrets SDD
explicit lifecycle/retention design
```

It is not part of the initial Secrets implementation.

---

## 10. Delivery And Presentation

### No Initial Secrets Dashboard

The initial implementation has no:

```text
/admin/security/secrets
```

surface.

A Secrets administration UI is justified only after real persistent inventory and lifecycle behavior exist.

### Owner-Local Secret Operations

Owner-specific workflows may later expose:

```text
generate
reveal
copy
rotate
revoke
```

when their domain behavior requires them.

They must use the Security/Secrets definition and protection Contracts.

### One-Time Response

A one-time secret may appear only in the successful response that generates it.

The response must:

```text
be authenticated/authorized as required
use private transport
use Cache-Control: no-store
avoid browser-persistent application storage
avoid URLs/query strings
avoid redirect parameters
avoid session flash storage
avoid Notification payloads
```

### Controlled Reveal

A controlled reveal must use a dedicated protected request.

Recommended request shape:

```text
POST owner-specific reveal endpoint
    ↓
Auth assurance
    ↓
Access authorization
    ↓
registered SecretDefinitionData requirements lookup
    ↓
owner retrieves ciphertext/reference
    ↓
SecretCipherInterface if applicable
    ↓
brief response containing raw value
    ↓
safe Audit evidence
```

Do not expose raw secret material through:

```text
GET query parameters
resource-list responses
HTML tables
generic settings pages
JSON serialization of domain Models
```

### Copy

Copy uses the same protected exposure path as reveal.

A UI copy control must not create a weaker server-side secret retrieval path.

Whether a distinct `copy` Audit event is required is defined by the applicable owner secret definition.

---

## 11. Security And Reliability

### Fail Closed

Secrets operations fail closed when:

* ciphertext cannot be decrypted;
* the secret definition is unknown;
* storage kind is incompatible with the requested operation;
* reveal/copy is prohibited;
* required rotation/revocation handling is unavailable;
* required Auth/Access assurance cannot be established.

### Secret Material In Asynchronous Work

Raw `SecretValue` must never be placed into:

```text
queued Jobs
Events
Notifications
session storage
cache payloads
Audit payloads
Monitoring payloads
```

Asynchronous work stores or receives only an owner-owned reference and resolves required credential material inside the execution boundary.

### Logging

Do not log:

```text
SecretValue
decrypted strings
authorization headers
cookies
private keys
raw provider credentials
```

Failures identify only safe:

```text
owner
secret definition
storage kind
operation
fingerprint/reference
result
```

### Decryption Failure

Decryption failure:

1. fails the requested operation;
2. does not expose ciphertext/plaintext details;
3. permits the concrete credential owner or a later accepted integration to record safe Monitoring evidence where appropriate;
4. preserves accountable Audit evidence only when the attempted operation itself is Audit-worthy.

### Transactions

The base Secrets subsystem owns no persistence transaction.

Credential-owning capabilities own their transaction boundaries.

For rotations involving remote providers:

```text
owner defines remote operation ordering
owner defines overlap period
owner defines rollback
owner defines idempotency/retry behavior
Security/Secrets supplies required guardrails
```

No generic rotation transaction is invented across unrelated providers.

---

## 12. Release And Source-Control Verification

Secrets contributes a blocking Security check through:

```text
security.release_checks
```

Contribution key:

```text
secrets.source_control
```

Implementation:

```text
SecretSourceControlCheck
```

The baseline check inspects committed release-source state for high-confidence prohibited secret material, including applicable:

* committed production `.env` material;
* private-key material;
* raw application-key assignments outside approved examples;
* other accepted high-confidence credential patterns.

It must:

* inspect committed source rather than arbitrary local untracked files;
* avoid outputting matched secret values;
* report only safe file/path/rule evidence;
* fail the Security verification gate for blocking findings;
* support explicitly approved fixture/example exclusions.

Broader scanner/tool integration may be added later through a separate accepted dependency/tooling decision.

Secrets does not introduce a third-party scanner dependency through this SDD.

---

## 13. Events And Operational Effects

### Core Security

Secrets contributes:

```text
security.secret_definitions
security.redaction_rules
security.release_checks
```

through Application Registration.

Core Security consumes the credential redaction rules and release check.

### Auth

Auth consumes:

```text
SecretCipherInterface
SecretDefinitionData
SecretStorageKind requirements
SecretExposurePolicy requirements
```

for applicable credential material.

Auth retains:

* password hashing;
* reset/recovery workflows;
* MFA workflows;
* session behavior;
* verification semantics.

Exact Auth interactions are reconciled during the later Auth SDD.

### Access

Access owns permission evaluation.

Secrets definitions establish which operations require:

```text
MFA
recent authentication
reason
explicit target authorization
```

Exact Access/permission Contracts are reconciled later.

### Audit

Credential owners record applicable secret lifecycle/access facts through Core Audit's public Contract.

Audit evidence may contain:

```text
secret definition identity
owner
secret type
storage kind
safe fingerprint/reference
operation
reason
result
Runtime correlation
```

It must never contain raw secret material.

### Monitoring

Monitoring already depends on Core Security and may record applicable secret-related failures when a concrete producer or later accepted integration supplies safe evidence through Monitoring's public Contract.

Examples include:

* decryption/read failure;
* credential expiry condition;
* rotation failure;
* external secret-store failure;
* health-check failures;
* leak/security detection.

Security/Secrets itself does not depend on Monitoring implementation or register Monitoring health checks merely by declaring `SecretHealthPolicyData`.

Secrets does not create a second health or Signal store.

### Notifications

Notifications later delivers required:

```text
expiry
rotation failure
vault/store failure
suspected leak
```

attention.

Secrets defines when attention is mandatory; Notifications owns delivery.

### DataProtection

DataProtection may classify secret-bearing evidence as restricted and apply broader handling requirements.

Secrets remains authoritative for credential-specific exposure and redaction rules.

### Application Registration

There is no independent Secrets owner registration. Parent `SecurityRegistrationDescriptor` is the one declarative owner registration for `owner_key: security` and declares:

* `SecretsServiceProvider`;
* `security.secret_definitions` Host Registry;
* Secrets configuration;
* credential redaction Contributions to `security.redaction_rules`;
* `secrets.source_control` Contribution to `security.release_checks`.

```text
SecurityRegistrationDescriptor
    owner_key = security
        ↓
Application Registration
        ↓
SecurityServiceProvider
        ↓
SecretsServiceProvider
        ↓
Security-owned registries and Secrets contributions available
```

`SecretsServiceProvider` binds `SecretCipherInterface`, initializes and binds `SecretDefinitionRegistry`, and provides Secrets runtime/subcapability services after registration. It performs no independent owner discovery and does not implement a separate registration-descriptor Contract.

No Secrets Provider is directly accumulated in root Laravel bootstrap composition.

---

## 14. Configuration

Target owner configuration:

```text
app/Core/Security/Secrets/config/secrets.php
```

Application Registration loads it beneath:

```text
security.secrets.*
```

Configuration may define:

```text
source-control verification rules
approved example/fixture exclusions
fingerprint display length
default rotation review expectations
```

It must never contain:

```text
raw secret values
production credentials
private keys
tokens
```

Secret values continue to come from their approved owner-specific storage mechanism.

---

## 15. Implementation Manifest

| Change | Path | Archetype | Responsibility | Dependencies | Requirement Source | Verification | Compatibility |
| --- | --- | --- | --- | --- | --- | --- | --- |
| CREATE | `app/Core/Security/Secrets/Contracts/SecretCipherInterface.php` | Contract | Expose reversible secret protection | Secret value data | `docs/03-architecture/public-contract-and-interaction-model.md` | Laravel secret cipher test | None |
| CREATE | `app/Core/Security/Secrets/Data/SecretDefinitionData.php` | Data Object | Define one immutable owner secret definition and operation lookup | Secret policy and operation requirements data | `docs/02-standards/security/Secrets Management Standards.md` | Secret definition Registry test | None |
| CREATE | `app/Core/Security/Secrets/Data/SecretRotationPolicyData.php` | Data Object | Define rotation, expiry, and review requirements | None | `docs/02-standards/security/Secrets Management Standards.md` | Secret storage-kind test | None |
| CREATE | `app/Core/Security/Secrets/Data/SecretHealthPolicyData.php` | Data Object | Define secret-health requirements without a Monitoring implementation dependency | `SecretHealthSeverity` | `docs/02-standards/security/Secrets Management Standards.md`; `docs/02-standards/logging/Logging Standards.md` | Secret definition Registry test | None |
| CREATE | `app/Core/Security/Secrets/Data/SecretOperationRequirementsData.php` | Data Object | Define immutable structural operation requirements | `SecretOperation` | `docs/02-standards/security/Secrets Management Standards.md` | Secret operation requirements test | None |
| CREATE | `app/Core/Security/Secrets/Data/EncryptedSecretValue.php` | Data Object | Represent encrypted ciphertext | None | `docs/02-standards/security/Secrets Management Standards.md` | Laravel secret cipher test | None |
| CREATE | `app/Core/Security/Secrets/Data/SecretFingerprint.php` | Data Object | Represent safe secret fingerprint evidence | None | `docs/02-standards/security/Secrets Management Standards.md` | Secret fingerprint Resolver test | None |
| CREATE | `app/Core/Security/Secrets/Enums/SecretType.php` | Enum | Define secret categories | None | `docs/02-standards/security/Secrets Management Standards.md` | Secret definition Registry test | None |
| CREATE | `app/Core/Security/Secrets/Enums/SecretStorageKind.php` | Enum | Define approved storage strategies | None | `docs/02-standards/security/Secrets Management Standards.md` | Secret storage-kind test | None |
| CREATE | `app/Core/Security/Secrets/Enums/SecretExposurePolicy.php` | Enum | Define secret exposure modes | None | `docs/02-standards/security/Secrets Management Standards.md` | Secret leakage prevention test | None |
| CREATE | `app/Core/Security/Secrets/Enums/SecretOperation.php` | Enum | Define sensitive secret operations | None | `docs/02-standards/security/Secrets Management Standards.md` | Secret operation requirements test | None |
| CREATE | `app/Core/Security/Secrets/Enums/SecretHealthSeverity.php` | Enum | Define Security-owned secret-health severity using the shared serialized vocabulary | None | `docs/02-standards/logging/Logging Standards.md` | Secret definition Registry test | None |
| CREATE | `app/Core/Security/Secrets/ValueObjects/SecretValue.php` | Value Object | Hold non-serializable raw secret material | None | `docs/02-standards/security/Secrets Management Standards.md` | Secret value test | None |
| CREATE | `app/Core/Security/Secrets/Encryption/LaravelSecretCipher.php` | Cipher implementation | Encrypt and decrypt through Laravel | `SecretCipherInterface`, Laravel encryption | `docs/02-standards/security/Secrets Management Standards.md` | Laravel secret cipher test | None |
| CREATE | `app/Core/Security/Secrets/Resolvers/SecretFingerprintResolver.php` | Resolver | Generate safe secret evidence | `SecretFingerprint` | `docs/02-standards/security/Secrets Management Standards.md` | Secret fingerprint Resolver test | None |
| CREATE | `app/Core/Security/Secrets/Registry/SecretDefinitionRegistry.php` | Registry | Accept owner secret definitions | Secret Definition data | `docs/03-architecture/public-contract-and-interaction-model.md` | Secret definition Registry test | None |
| CREATE | `app/Core/Security/Secrets/Definitions/SecretRedactionRules.php` | Contribution | Provide credential redaction definitions | Security Redaction Rule Registry | `docs/02-standards/security/Secrets Management Standards.md` | Secret redaction rules test | None |
| CREATE | `app/Core/Security/Secrets/Verification/Checks/SecretSourceControlCheck.php` | Security Check | Detect committed high-confidence secret material | Security Check Contract | `docs/02-standards/security/Application Security Verification And Secure Delivery Standards.md` | Source-control check test | None |
| CREATE | `app/Core/Security/Secrets/Providers/SecretsServiceProvider.php` | Provider | Bind Secrets contracts, Registry, and runtime services | Parent Security registries, Secrets Contracts | `docs/03-architecture/application-registration.md` | Security registration proof | None |
| CREATE | `app/Core/Security/Secrets/config/secrets.php` | Configuration | Define Secrets structural configuration | Laravel configuration | `docs/03-architecture/repository-architecture.md` | Secrets serialization/redaction test | None |
| CREATE | `app/Core/Security/Secrets/__tests__/SecretDefinitionRegistryTest.php` | Test | Prove definition registration | Secret Definition Registry | `docs/02-standards/testing/index.md` | Targeted Secrets proof | None |
| CREATE | `app/Core/Security/Secrets/__tests__/SecretStorageKindTest.php` | Test | Prove storage decision rules | Secret Storage Kind | `docs/02-standards/testing/index.md` | Targeted Secrets proof | None |
| CREATE | `app/Core/Security/Secrets/__tests__/SecretValueTest.php` | Test | Prove raw-value serialization safety | Secret Value | `docs/02-standards/testing/index.md` | Targeted Secrets proof | None |
| CREATE | `app/Core/Security/Secrets/__tests__/LaravelSecretCipherTest.php` | Test | Prove reversible protection | Laravel Secret Cipher | `docs/02-standards/testing/index.md` | Targeted Secrets proof | None |
| CREATE | `app/Core/Security/Secrets/__tests__/SecretFingerprintResolverTest.php` | Test | Prove permitted fingerprinting | Secret Fingerprint Resolver | `docs/02-standards/testing/index.md` | Targeted Secrets proof | None |
| CREATE | `app/Core/Security/Secrets/__tests__/SecretOperationRequirementsTest.php` | Test | Prove structural, non-authorizing operation lookup | Secret Definition data | `docs/02-standards/testing/index.md` | Targeted Secrets proof | None |
| CREATE | `app/Core/Security/Secrets/__tests__/SecretRedactionRulesTest.php` | Test | Prove credential redaction Contributions | Secret Redaction Rules | `docs/02-standards/testing/index.md` | Targeted Secrets proof | None |
| CREATE | `app/Core/Security/Secrets/__tests__/SecretSourceControlCheckTest.php` | Test | Prove safe blocking source-control check | Secret Source Control Check | `docs/02-standards/testing/index.md` | Targeted Secrets proof | None |
| CREATE | `app/Core/Security/Secrets/__tests__/SecretsRegistrationTest.php` | Test | Prove Security-owned Secrets registration | Security Registration Descriptor | `docs/02-standards/testing/index.md` | Targeted Secrets proof | None |
| CREATE | `tests/Feature/Security/SecretsRedactionIntegrationTest.php` | Test | Prove Security redaction integration | Security redaction Contract | `docs/02-standards/testing/index.md` | Targeted Secrets proof | None |
| CREATE | `tests/Feature/Security/SecretLeakagePreventionTest.php` | Test | Prove secret non-leakage | Secrets owner artifacts | `docs/02-standards/testing/index.md` | Targeted Secrets proof | None |

The initial implementation has no Secrets-owned database or administration UI. Obsolete proof-of-concept secret helpers or unsafe storage paths are deleted only when a bounded implementation issue identifies each target; they have no preservation requirement. Later Auth and Access tests prove their domain-specific use of the Secrets Contracts.

---

## 16. Verification And Completion

Required proof must establish:

* `security.secret_definitions` accepts valid owner definitions;
* duplicate secret-definition Contribution identities fail;
* registration metadata never contains raw values;
* every definition has owner and purpose;
* storage kind follows the accepted handling rules;
* verification-only definitions cannot request controlled reveal;
* `SecretValue` cannot be serialized;
* `SecretValue` debug output is redacted;
* `SecretValue` is never implicitly stringified;
* reversible secret encryption/decryption works through `SecretCipherInterface`;
* ciphertext does not equal plaintext;
* decryption failure fails closed;
* one-time values need not be stored raw;
* controlled reveal cannot be used when exposure policy is `never` or `one_time`;
* operation requirements are obtained structurally from `SecretDefinitionData` and do not make an authorization decision;
* no Secrets operation-requirements authorization Policy class exists;
* exactly one owner registration exists for `owner_key: security`;
* no independent Secrets registration descriptor exists;
* `SecretsServiceProvider` is registered through `SecurityRegistrationDescriptor`;
* `SecretHealthSeverity` serializes exactly to:

  * `informational`
  * `low`
  * `medium`
  * `high`
  * `critical`;
* `SecretHealthPolicyData` imports no Monitoring-owned type;
* Security/Secrets has no owner registration dependency on `monitoring`;
* Monitoring may still depend on `security`;
* no circular Application Registration owner dependency exists between `security` and `monitoring`;
* concrete third-party capability health checks may consume both provider-owned Contracts only when that capability's own design declares those dependencies;
* passwords/tokens/cookies/private-key fields are covered by credential redaction rules;
* Secrets redaction rules integrate into Core Security without changing Audit/Monitoring implementations;
* high-confidence committed-secret fixtures make `SecretSourceControlCheck` fail;
* source-control check output never prints the secret;
* approved clean repository fixtures pass;
* Secrets owns no initial database;
* Secrets owns no initial administration UI;
* Security/Secrets does not absorb Auth, Access, Audit, Monitoring, Notifications, or integration-domain behavior.

### Required Reconciliation Before Acceptance

1. **Secrets Management Standard acceptance** — currently `draft`.
2. **Core Security acceptance** — parent Security Contracts and registries must be accepted.
3. **Auth design** — confirm exact Auth secret definitions and reversible-encryption versus hash-only usage.
4. **Access/Auth assurance design** — resolve exact MFA/recent-auth/permission Contracts for controlled reveal, rotate, revoke, and other sensitive operations.
5. **Notifications design** — exact mandatory expiry/rotation/leak attention delivery.
6. **DataProtection design** — final restricted-data classification and evidence handling.
7. **Source-control scanning policy** — accept the precise blocking pattern/fixture-exclusion Contract before implementation verification is frozen.

The Security/Monitoring dependency direction is resolved: Security/Secrets owns only health requirement metadata and does not import Monitoring Contracts.

### Explicit Non-Blockers

The following are intentionally **not** blockers:

* selection of an external vault vendor;
* Secrets administration dashboard;
* persistent `secret_references` table;
* Service Account implementation;
* OAuth/provider-specific rotation adapters;
* third-party secret-scanner dependency.

Those require later concrete consumers and separate accepted design expansion.

### Implementation Ready

* [x] Security/Secrets ownership is defined.
* [x] secret-type vocabulary is defined.
* [x] storage-decision vocabulary is defined.
* [x] owner-storage boundary is defined.
* [x] reversible encryption Contract is defined.
* [x] raw-value in-memory behavior is defined.
* [x] one-time exposure behavior is defined.
* [x] controlled reveal/copy guardrails are defined.
* [x] rotation/revocation ownership boundary is defined.
* [x] expiry/health requirements are defined.
* [x] credential-specific redaction integration is defined.
* [x] release-check integration is defined.
* [x] initial persistence boundary is defined.
* [x] no initial UI requirement exists.
* [x] Application Registration integration is defined.
* [x] implementation manifest is defined.
* [x] verification surfaces are defined.
* [x] secret-health severity is defined without a Monitoring type dependency.
* [x] Security → Monitoring dependency cycle is prohibited and removed.
* [x] Monitoring health execution remains Monitoring-owned.
* [x] Monitoring ownership and dependency direction are reconciled.
* [ ] Secrets Management standard is accepted.
* [ ] Core Security registry Contracts are accepted.
* [ ] Auth secret usage is reconciled.
* [ ] Access/Auth assurance Contracts are reconciled.
* [ ] Notifications/DataProtection dependencies are reconciled.
* [ ] source-control scanning policy is accepted.
* [ ] no material design blocker remains.

**Design state: draft; the Security / Secrets foundation is defined without creating a central credential database or internal vault, and is ready for foundation reconciliation after the remaining policy/consumer Contracts are settled.**
