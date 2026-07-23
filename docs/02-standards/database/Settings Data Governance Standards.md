<!--
DOC-META
title: Settings Data Governance Standards
doc_type: standard
status: active
owner: data
canonical: true
canonical_path: docs/02-standards/database/Settings Data Governance Standards.md
parent: docs/02-standards/database/index.md
template: docs/09-reference/templates/docs/_doc.md
summary: Defines governance rules for settings, preferences, registry-backed configuration, scoped configuration values, sensitive settings, and stable setting keys.
-->

# Settings Data Governance Standards

This document defines governance standards for settings, preferences, and registry-backed configuration data in Login App 2.0.

- [1. Purpose](#1-purpose)
- [2. Scope](#2-scope)
- [3. Core Rule](#3-core-rule)
- [4. Settings Versus Preferences](#4-settings-versus-preferences)
- [5. Required Setting Metadata](#5-required-setting-metadata)
- [6. Key Stability Rule](#6-key-stability-rule)
- [7. Scope Rules](#7-scope-rules)
- [8. Value Type Rules](#8-value-type-rules)
- [9. Sensitive And Secret-Bearing Settings](#9-sensitive-and-secret-bearing-settings)
- [10. Defaults And Fallbacks](#10-defaults-and-fallbacks)
- [11. Validation Rules](#11-validation-rules)
- [12. Permissions And Access](#12-permissions-and-access)
- [13. Audit And Monitoring](#13-audit-and-monitoring)
- [14. Setup And Settings UI Rules](#14-setup-and-settings-ui-rules)
- [15. Registry And Seeder Rules](#15-registry-and-seeder-rules)
- [16. Documentation Sync](#16-documentation-sync)
- [17. Stop Conditions](#17-stop-conditions)
- [18. Related](#18-related)

---

## 1. Purpose

Keep settings stable, scoped, validated, permission-aware, auditable, and safe to display.

Settings must not become an ungoverned key/value dumping ground.

---

## 2. Scope

This standard applies to:

- application settings
- platform settings
- Core capability settings
- Module settings
- user preferences
- notification preferences
- registry-backed configuration
- setup/settings UI entries
- sensitive or secret-bearing configuration stored in the database

This standard does not replace Secrets standards for secret lifecycle, rotation, reveal, copy, or vault behavior.

---

## 3. Core Rule

Every setting must have an explicit owner, scope, type, validation rule, default behavior, and access rule.

Do not create settings that are only understood by one view, one controller, or one seed file.

---

## 4. Settings Versus Preferences

Use the distinction consistently.

| Type               | Meaning                                                                                                  |
| ------------------ | -------------------------------------------------------------------------------------------------------- |
| Setting            | Administrative or system configuration that affects behavior beyond a single user.                       |
| Preference         | User-owned default or display/delivery preference that affects that user’s experience.                   |
| Registry entry     | System-defined contribution, capability, module, setup, notification, or settings metadata.              |
| Environment config | Deployment/runtime value owned by environment files or infrastructure, not editable in app UI.           |
| Secret             | Sensitive credential or token requiring encryption, redaction, rotation, and restricted reveal behavior. |

Do not store environment-only secrets as ordinary settings.

---

## 5. Required Setting Metadata

Every setting or setting group should define:

- stable key
- owner capability or module
- scope type
- scope identifier when applicable
- value type
- default value or default resolver
- validation rules
- allowed values when constrained
- permission required to view
- permission required to edit
- audit behavior
- sensitivity classification
- UI surface where edited
- documentation owner

If a setting lacks an owner or validation rule, it should not ship.

---

## 6. Key Stability Rule

Setting keys are stable contracts after release.

Renaming a setting key requires explicit migration planning.

A setting rename plan must define:

- old key
- new key
- owner
- migration path
- compatibility period if needed
- fallback behavior
- audit or logging expectations
- docs to update
- cleanup plan

Do not silently rename keys in code without a migration path.

---

## 7. Scope Rules

Setting ownership must remain explicit by scope.

Common scopes may include:

- global
- platform
- workspace
- tenant
- account
- module
- user

Scoped settings must not leak across boundaries.

Uniqueness should include the correct scope and key.

Do not rely on UI routing alone to enforce setting scope.

---

## 8. Value Type Rules

Settings should use clear value types.

Supported value types should be explicit and validated.

Examples:

- boolean
- integer
- string
- enum-like string
- decimal
- array
- object
- JSON payload
- encrypted string
- encrypted JSON

Use flexible JSON only when the setting genuinely owns structured configuration.

Do not use JSON to avoid defining stable settings that require validation, permissions, or UI controls.

---

## 9. Sensitive And Secret-Bearing Settings

Secret-bearing settings must use protected storage and masked output.

Sensitive settings include:

- API keys
- webhook secrets
- OAuth secrets
- integration tokens
- SMTP credentials
- private keys
- recovery material
- credentials
- any value that would create account, tenant, system, or data access if exposed

Rules:

- never display raw secret values by default
- never log raw secret values
- never expose raw secret values in validation errors
- never seed real secret values
- encrypt values the application must read later
- hash values the application only needs to verify
- use masked placeholders in operator-facing views
- require explicit approval, recent auth, or elevated access for reveal/copy behavior when reveal is allowed
- audit reveal, copy, create, update, revoke, and rotate actions when applicable

Secret lifecycle behavior should be owned by Secrets standards and Core Security/Secrets planning.

---

## 10. Defaults And Fallbacks

Defaults must be documented and deterministic.

A default may come from:

- config file
- environment value
- database default
- registry entry
- capability default resolver
- module default resolver

Do not create hidden fallback chains that are only discoverable by reading multiple unrelated files.

If fallback behavior exists, document the order clearly.

---

## 11. Validation Rules

Settings must be validated before storage.

Validation should cover:

- data type
- required/nullable state
- allowed values
- numeric ranges
- string length
- URL/email/host formats
- JSON shape
- permission to change
- scope ownership
- sensitivity classification

Do not rely on front-end validation alone.

---

## 12. Permissions And Access

Settings must be permission-gated.

Define separately when applicable:

- who can view the setting
- who can edit the setting
- who can reveal or copy sensitive values
- who can reset to default
- who can manage settings for another scope

UI visibility is not authorization.

Controllers, actions, policies, or Core Access checks must enforce permissions.

---

## 13. Audit And Monitoring

Audit significant setting changes.

At minimum, audit:

- security settings changes
- notification delivery settings changes
- access/auth settings changes
- integration settings changes
- secret-bearing setting create/update/reveal/copy/revoke/rotate actions
- settings that affect tenant/workspace behavior
- settings that affect data movement, exports, webhooks, or APIs

Audit metadata should include:

- actor
- target scope
- setting key
- old value classification or redacted summary
- new value classification or redacted summary
- result
- reason when required

Do not audit raw secret values.

Monitoring should capture repeated failed setting updates, validation failures, or suspicious reveal/copy patterns when applicable.

---

## 14. Setup And Settings UI Rules

A visible Setup or Settings entry must not ship until it has meaningful content.

Do not create visible stub pages with no editable fields or useful read-only status.

Settings UI should show:

- label
- description
- current value or masked value
- validation errors
- default behavior when useful
- sensitivity warning when applicable
- permission-aware actions
- audit-sensitive change confirmation when needed

Settings UI must not be the only place where settings behavior exists.

---

## 15. Registry And Seeder Rules

Registry and settings seeders must be deterministic and safe to rerun.

Seeded settings or registry entries should define stable keys.

Do not seed real secrets.

Do not remove or rename seeded keys without migration planning.

Do not use seeders as the only documentation for available settings.

---

## 16. Documentation Sync

Settings changes must update documentation when they affect behavior.

Potential docs to update:

- canonical feature doc
- setup/settings feature doc
- table docs under `docs/06-database/`
- settings registry docs
- module planning docs
- security/secrets docs
- runbooks when operational setup changes

Every released setting should be discoverable through documentation or a registry reference.

---

## 17. Stop Conditions

Stop before adding or changing a setting when:

- the owner is unclear
- the scope is unclear
- validation is unclear
- permission behavior is unclear
- the setting may contain a secret
- the setting affects data movement or security
- the key rename path is not planned
- default/fallback behavior is unclear
- the UI would expose a stub or meaningless setting
- docs cannot be updated accurately

---

## 18. Related

- [Schema Design Standards](Schema%20Design%20Standards.md)
- [Database Migration Standards](Database%20Migration%20Standards.md)
- [Settings Table](../../06-database/tables/settings.md)
- [Implementation Status And Development Sync Standard](../documentation/Implementation%20Status%20And%20Development%20Sync%20Standard.md)
- [Standards Index](../index.md)
