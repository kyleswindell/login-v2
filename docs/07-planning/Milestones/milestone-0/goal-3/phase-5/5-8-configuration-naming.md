<!--
DOC-META
title: Phase 5.8 Configuration Naming
doc_type: planning
status: planned
owner: architecture
canonical: true
canonical_path: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/5-8-configuration-naming.md
parent: docs/07-planning/Milestones/milestone-0/goal-3/phase-5/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Records owner-aware configuration filenames, dotted keys, environment variables, runtime-setting boundaries, and compatibility aliases.
-->

# Phase 5.8 Configuration Naming

Parent: [Phase 5 Naming Conventions Index](index.md)

## 1. Purpose

Define configuration names that reveal ownership while keeping Laravel configuration separate from runtime-editable settings, preferences, operational state, and secrets.

## 2. Status

- Acceptance state: accepted through repository-owner Phase 5 review
- Implementation state: target direction only
- Owning GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
- Depends on: Decision 5.3, ADR-0007, and Phase 4 configuration placement

## 3. Naming Matrix

| Concern                        | Pattern                                       | Example                                       |
| ------------------------------ | --------------------------------------------- | --------------------------------------------- |
| Config directory               | Exact lowercase `config/`                     | `Modules/Projects/config/`                    |
| PHP config filename            | Lowercase snake case                          | `quickbooks_sync.php`                         |
| Config root                    | Applicable owner, capability, or `module_key` | `notifications.*`                             |
| Nested key                     | Lowercase snake-case segment                  | `delivery.retry_limit`                        |
| Environment variable           | Upper snake case                              | `QUICKBOOKS_SYNC_CLIENT_ID`                   |
| Framework environment variable | Native Laravel name                           | `APP_ENV`, `DB_CONNECTION`                    |
| Compatibility alias            | One legacy key to one canonical key           | `legacy_notifications.*` to `notifications.*` |

## 4. Owner-Local Examples

```text
app/Core/Notifications/config/notifications.php
app/Core/Identity/config/identity.php
Modules/Projects/config/projects.php
Modules/QuickBooksSync/config/quickbooks_sync.php
```

Canonical keys:

```text
identity.users.default_active
notifications.delivery.database
notifications.delivery.retry_limit
projects.retention_days
quickbooks_sync.import.batch_size
```

Environment mappings:

```text
NOTIFICATIONS_DELIVERY_RETRY_LIMIT
PROJECTS_RETENTION_DAYS
QUICKBOOKS_SYNC_CLIENT_ID
QUICKBOOKS_SYNC_CLIENT_SECRET
```

## 5. Rules

- The default owner configuration filename matches the applicable canonical `owner_key` or `module_key`.
- An additional file may use a precise bounded concern name when one owner file becomes materially broad.
- Nested keys describe configuration values rather than implementation classes.
- Environment variables are read through configuration files rather than directly throughout application code.
- Secrets may be mapped from environment variables but must not be committed as configuration values.
- Laravel and infrastructure variables may retain their native established names.
- Tenant settings, User preferences, runtime feature state, and other persisted application state are not Laravel configuration.
- The reserved `Platform` placeholder does not authorize `platform.*` as a canonical configuration root.

Prefer positive Boolean names where practical:

```text
enabled
require_mfa
allow_exports
```

Avoid ambiguous negatives:

```text
disable_checks
not_required
```

Generic names such as `settings.php`, `module.php`, `common.php`, `shared.php`, `platform.php`, and generic `services.php` are prohibited unless a framework-owned configuration file has that exact established meaning.

## 6. Accepted Decision

> Configuration directories use the exact lowercase name `config`.
>
> PHP configuration filenames use lowercase snake case. The default owner configuration filename matches the applicable canonical `owner_key` or `module_key`, such as `identity.php`, `notifications.php`, `projects.php`, or `quickbooks_sync.php`.
>
> Canonical configuration roots use the applicable capability or Module key. Nested configuration keys use lowercase snake-case segments joined through Laravel dot notation.
>
> Configuration names must describe the owned concern and value. Generic filenames or roots such as `settings`, `module`, `services`, `common`, `shared`, and `platform` are prohibited unless a framework-owned configuration file has that exact established meaning.
>
> Environment variables use upper snake case. Owner-specific variables normally begin with the uppercase owner or Module key. Laravel and infrastructure variables may retain their established framework-native names.
>
> Application code reads environment variables only through configuration files. Secrets may be mapped from environment variables but must not be committed as configuration values.
>
> Tenant settings, User preferences, runtime-editable operational state, feature enablement, and other persisted application state are not Laravel configuration.
>
> Configuration filenames, canonical keys, environment variables, runtime settings, and display labels remain separate naming families.
>
> Compatibility aliases map one legacy configuration key directly to one canonical key. Aliases must not chain, must not remain equally canonical, and must define a removal condition and migration owner.

## 7. Boundaries And Handoff

- Phase 5 does not merge or relocate configuration files.
- Runtime settings and preferences remain with their owning Core capability or Module and applicable data-governance standards.
- Secret-management and deployment mechanisms remain separate operational authority.
- Decision 5.13 governs compatibility mappings.

## 8. Related

- [Module Naming](5-3-module-naming.md)
- [Compatibility And Rename Rules](5-13-compatibility-and-rename-rules.md)
- [ADR-0007](../../../../../01-decisions/adr-0007-owner-registry-and-identifier-key-conventions.md)
- [Phase 4 Configuration Placement](../phase-4/4-5-configuration-placement.md)
- [Settings Data Governance Standards](../../../../../02-standards/database/Settings%20Data%20Governance%20Standards.md)
- Related GitHub issue: [#52](https://github.com/kyleswindell/login-v2/issues/52)
