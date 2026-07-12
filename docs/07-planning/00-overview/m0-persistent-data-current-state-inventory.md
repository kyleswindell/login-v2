<!--
DOC-META
title: M0 Persistent Data Current-State Inventory
doc_type: planning
status: active
owner: architecture
canonical: true
canonical_path: docs/07-planning/00-overview/m0-persistent-data-current-state-inventory.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Provides the pinned, evidence-backed Goal 02 inventory of current database tables, migration history, persistence boundaries, ownership and scope evidence, active planned persistent concepts, contradictions, and unresolved target questions.
-->

# M0 Persistent Data Current-State Inventory

Parent: [Planning Index](../index.md)

## 1. Purpose

Provide the authoritative current-state persistence inventory required by GitHub issue #31 and M0 Goal 02.

This document records source-controlled schema intent, registered migration boundaries, implemented tables, material persistence boundaries, active planned concepts, current ownership and scope evidence, compatibility, contradictions, and unresolved questions at one pinned baseline.

It does not select the Goal 06 target data model, change schema, execute migrations, or reopen ADR-0005, ADR-0006, or ADR-0007.

## 2. Status And Baseline

<!-- PERSISTENT-DATA-INVENTORY:BASELINE:START -->

- Inventory evidence baseline: `1d103f5fa47aab8c8adfba8ea134dd29540426fe`
- Baseline committed at: 2026-07-10T22:27:59-04:00
- Implementation branch base: `c002cf1f862f3e232623792e55e360a8378edeb8`
- Accepted main at package preparation: `bb76558adfe1bc9927bd2b34057dd82ee9a4d253`
- Generated at: 2026-07-11T18:21:48.746Z
- Evidence records source-controlled implementation at the pinned baseline; they do not assert deployed migration state.

<!-- PERSISTENT-DATA-INVENTORY:BASELINE:END -->

## 3. Scope And Non-Goals

<!-- PERSISTENT-DATA-INVENTORY:SCOPE:START -->

Inventory scope includes every source-controlled migration, registered and missing migration roots, implemented tables and complete chains, material pivots and compatibility storage, persistence-related models/factories/seeders/contracts/configuration/tests, active planned persistent concepts, and material framework/file/external boundaries.

Non-goals include selecting a Goal 06 target model, executing migrations, querying rows, changing schema/runtime/contracts/standards, treating Workspace as persistence, or recording secrets and reusable credentials.

<!-- PERSISTENT-DATA-INVENTORY:SCOPE:END -->

## 4. Evidence Method And Authority

<!-- PERSISTENT-DATA-INVENTORY:METHOD:START -->

Current implementation evidence is interpreted in migration/source, registration, constraints, models, owner declarations, contracts, factories/seeders/tests, planning, then corroborative runtime order. Conflicts are retained rather than resolved silently.

- Collection reads one pinned Git tree and one batched blob stream.
- Reviewed classifications remain separate from generated evidence seeds.
- Render-only mode reads the ledger, raw evidence, and reviewed classifications without Git, PHP, Laravel, or source scans.
- Issue #29 evidence is baseline-checked and used only as supporting context.

- `php artisan migrate:status --no-interaction --no-ansi`: Command exited with status 1.
- `php artisan config:show permission --no-ansi`: succeeded

<!-- PERSISTENT-DATA-INVENTORY:METHOD:END -->

## 5. Inventory Schema And Controlled Values

<!-- PERSISTENT-DATA-INVENTORY:SCHEMA:START -->

Required material fields: `migration_or_planning_source`, `storage_identifier`, `implementation_state`, `ownership_area`, `owner_key`, `capability_key`, `module_key`, `tenant_scope`, `instance_scope`, `principal_scope`, `resource_scope`, `actor_scope`, `target_tenant_or_instance_scope`, `key_and_relationship_evidence`, `uniqueness_and_index_evidence`, `lifecycle_and_deletion_evidence`, `classification_evidence`, `retention_and_erasure_evidence`, `audit_evidence`, `contract_path`, `compatibility_evidence`, `known_contradictions`, `disposition`, `target_question`.

Implementation states: `implemented`, `planned`, `compatibility`, `historical`, `superseded`, `unknown`.
Ownership areas: `core`, `module`, `ui`, `not_applicable`, `unknown`.
Scope states: `explicit`, `indirect`, `absent`, `contradictory`, `unknown`, `not_applicable`.
Dispositions: `retain`, `investigate`, `compatibility`, `duplicate`.

<!-- PERSISTENT-DATA-INVENTORY:SCHEMA:END -->

## 6. Generated Summary

<!-- PERSISTENT-DATA-INVENTORY:SUMMARY:START -->

| Measure                                | Count |
| -------------------------------------- | ----: |
| Migration roots                        |     9 |
| Registered roots present               |     1 |
| Registered roots missing               |     8 |
| Migrations                             |    22 |
| Fully parsed migrations                |    22 |
| Partial or dynamic migrations          |     0 |
| Up operations                          |    39 |
| Down operations                        |    39 |
| Implemented tables                     |    27 |
| Compatibility tables                   |     5 |
| Material pivots                        |     3 |
| Planned concepts                       |    55 |
| Boundaries                             |    16 |
| Material records                       |   103 |
| Reviewed records                       |   103 |
| Pending review                         |     0 |
| Contradiction-bearing records          |    88 |
| Investigate records                    |    83 |
| Missing table contracts                |    75 |
| Owner declarations explicitly compared |    21 |
| Owner mismatches                       |     0 |

<!-- PERSISTENT-DATA-INVENTORY:SUMMARY:END -->

## 7. Migration Ledger Summary

<!-- PERSISTENT-DATA-INVENTORY:MIGRATIONS:START -->

### Registered Migration Roots

| Root                                        | State                   | Exists | Migrations |
| ------------------------------------------- | ----------------------- | -----: | ---------: |
| `database/migrations`                       | registered              |    yes |         22 |
| `Modules/Account/database/migrations`       | registered_root_missing |     no |          0 |
| `Modules/Auth/database/migrations`          | registered_root_missing |     no |          0 |
| `Modules/Dashboard/database/migrations`     | registered_root_missing |     no |          0 |
| `Modules/Notifications/database/migrations` | registered_root_missing |     no |          0 |
| `Modules/Preferences/database/migrations`   | registered_root_missing |     no |          0 |
| `Modules/Roles/database/migrations`         | registered_root_missing |     no |          0 |
| `Modules/Settings/database/migrations`      | registered_root_missing |     no |          0 |
| `Modules/Setup/database/migrations`         | registered_root_missing |     no |          0 |

### Migration Ledger

| Migration                                                                                                | Registration |  Up | Down | Storage identifiers                                                                                                                              | Parse status |
| -------------------------------------------------------------------------------------------------------- | ------------ | --: | ---: | ------------------------------------------------------------------------------------------------------------------------------------------------ | ------------ |
| `database/migrations/0001_01_01_000000_create_users_table.php`                                           | registered   |   3 |    3 | `users`, `password_reset_tokens`, `sessions`                                                                                                     | complete     |
| `database/migrations/0001_01_01_000001_create_cache_table.php`                                           | registered   |   2 |    2 | `cache`, `cache_locks`                                                                                                                           | complete     |
| `database/migrations/0001_01_01_000002_create_jobs_table.php`                                            | registered   |   3 |    3 | `jobs`, `job_batches`, `failed_jobs`                                                                                                             | complete     |
| `database/migrations/2026_04_08_000001_create_platform_audit_logs_table.php`                             | registered   |   1 |    1 | `platform_audit_logs`                                                                                                                            | complete     |
| `database/migrations/2026_04_08_000002_create_central_error_logs_table.php`                              | registered   |   1 |    1 | `central_error_logs`                                                                                                                             | complete     |
| `database/migrations/2026_04_09_000001_create_permission_tables.php`                                     | registered   |   5 |    5 | `permissions`, `roles`, `model_has_permissions`, `model_has_roles`, `role_has_permissions`                                                       | complete     |
| `database/migrations/2026_04_09_000002_add_phase_one_lifecycle_columns_to_users_table.php`               | registered   |   1 |    1 | `users`                                                                                                                                          | complete     |
| `database/migrations/2026_04_09_000003_create_settings_table.php`                                        | registered   |   1 |    1 | `settings`                                                                                                                                       | complete     |
| `database/migrations/2026_04_09_000004_create_notifications_table.php`                                   | registered   |   1 |    1 | `notifications`                                                                                                                                  | complete     |
| `database/migrations/2026_04_09_000005_add_timezone_to_users_table.php`                                  | registered   |   1 |    1 | `users`                                                                                                                                          | complete     |
| `database/migrations/2026_04_10_000001_add_staff_profile_fields_to_users_table.php`                      | registered   |   1 |    1 | `users`                                                                                                                                          | complete     |
| `database/migrations/2026_04_12_220000_add_theme_preference_to_users_table.php`                          | registered   |   1 |    1 | `users`                                                                                                                                          | complete     |
| `database/migrations/2026_04_13_000001_create_user_dashboard_layouts_table.php`                          | registered   |   1 |    1 | `user_dashboard_layouts`                                                                                                                         | complete     |
| `database/migrations/2026_07_01_000001_create_mfa_tables.php`                                            | registered   |   3 |    3 | `user_mfa_methods`, `user_mfa_policies`, `mfa_recovery_codes`                                                                                    | complete     |
| `database/migrations/2026_07_01_000002_add_pending_secret_expiry_to_user_mfa_methods.php`                | registered   |   1 |    1 | `user_mfa_methods`                                                                                                                               | complete     |
| `database/migrations/2026_07_01_000003_create_security_requirements_tables.php`                          | registered   |   2 |    2 | `security_requirement_groups`, `security_requirements`                                                                                           | complete     |
| `database/migrations/2026_07_07_000001_create_roles_registry_metadata_tables.php`                        | registered   |   2 |    2 | `permission_registry_entries`, `role_metadata`                                                                                                   | complete     |
| `database/migrations/2026_07_07_000002_create_user_contact_emails_table.php`                             | registered   |   1 |    1 | `user_contact_emails`                                                                                                                            | complete     |
| `database/migrations/2026_07_07_000003_create_user_notification_preferences_table.php`                   | registered   |   1 |    1 | `user_notification_preferences`                                                                                                                  | complete     |
| `database/migrations/2026_07_08_000001_drop_in_app_enabled_from_user_notification_preferences_table.php` | registered   |   1 |    1 | `user_notification_preferences`                                                                                                                  | complete     |
| `database/migrations/2026_07_08_000002_add_type_key_to_notifications_table.php`                          | registered   |   1 |    1 | `notifications`                                                                                                                                  | complete     |
| `database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php`                   | registered   |   5 |    5 | `module_registry_entries`, `notification_registry_entries`, `settings_registry_entries`, `setup_registry_entries`, `preference_registry_entries` | complete     |

<!-- PERSISTENT-DATA-INVENTORY:MIGRATIONS:END -->

## 8. Implemented And Compatibility Storage

<!-- PERSISTENT-DATA-INVENTORY:IMPLEMENTED:START -->

### `cache`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `not_applicable`; owner `infrastructure`; capability `infrastructure`; Module `not_applicable`
- Scope: Tenant `not_applicable`; Instance `not_applicable`; Principal `not_applicable`; resource `not_applicable`; Actor `not_applicable`; target Tenant/Instance `not_applicable`
- Sources: `database/migrations/0001_01_01_000001_create_cache_table.php:11`
- Keys and relationships: cache final-state columns: expiration, key, value. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: key. Unique constraints: none recorded. Indexes: expiration.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No per-table contract exists for cache.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded cache evidence gaps?

### `cache_locks`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `not_applicable`; owner `infrastructure`; capability `infrastructure`; Module `not_applicable`
- Scope: Tenant `not_applicable`; Instance `not_applicable`; Principal `not_applicable`; resource `not_applicable`; Actor `not_applicable`; target Tenant/Instance `not_applicable`
- Sources: `database/migrations/0001_01_01_000001_create_cache_table.php:17`
- Keys and relationships: cache_locks final-state columns: expiration, key, owner. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: key. Unique constraints: none recorded. Indexes: expiration.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No per-table contract exists for cache_locks.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded cache_locks evidence gaps?

### `central_error_logs`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `monitoring`; capability `monitoring`; Module `not_applicable`
- Scope: Tenant `explicit`; Instance `absent`; Principal `explicit`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_04_08_000002_create_central_error_logs_table.php:11`
- Keys and relationships: central_error_logs final-state columns: context, created_at, environment, error_code, exception_class, file_path, fingerprint, handled, hostname, id, ip_address, line_number, message, method, occurred_at, release_version, request_id, route, service_name, severity, span_id, stack_trace, status_code, tenant_key, trace_id, updated_at, user_agent, user_id. Database foreign keys: user_id -> users.id (set_null).
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: none recorded. Indexes: tenant_key; occurred_at; environment; service_name; severity; request_id; trace_id; span_id; route; status_code; exception_class; error_code; fingerprint; handled; release_version; hostname.
- Lifecycle and deletion: Deletion behavior: set_null.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes set_null; retention and legal hold remain undocumented.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `docs/06-database/tables/central_error_logs.md`
- Compatibility: Feature contract references central_error_logs.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `failed_jobs`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `not_applicable`; owner `infrastructure`; capability `infrastructure`; Module `not_applicable`
- Scope: Tenant `not_applicable`; Instance `not_applicable`; Principal `not_applicable`; resource `not_applicable`; Actor `not_applicable`; target Tenant/Instance `not_applicable`
- Sources: `database/migrations/0001_01_01_000002_create_jobs_table.php:34`
- Keys and relationships: failed_jobs final-state columns: connection, exception, failed_at, id, payload, queue, uuid. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: uuid. Indexes: none recorded.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: Sensitive or credential/session-material field names are present; no values were collected.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No per-table contract exists for failed_jobs.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded failed_jobs evidence gaps?

### `job_batches`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `not_applicable`; owner `infrastructure`; capability `infrastructure`; Module `not_applicable`
- Scope: Tenant `not_applicable`; Instance `not_applicable`; Principal `not_applicable`; resource `not_applicable`; Actor `not_applicable`; target Tenant/Instance `not_applicable`
- Sources: `database/migrations/0001_01_01_000002_create_jobs_table.php:21`
- Keys and relationships: job_batches final-state columns: cancelled_at, created_at, failed_job_ids, failed_jobs, finished_at, id, name, options, pending_jobs, total_jobs. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: none recorded. Indexes: none recorded.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No per-table contract exists for job_batches.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded job_batches evidence gaps?

### `jobs`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `not_applicable`; owner `infrastructure`; capability `infrastructure`; Module `not_applicable`
- Scope: Tenant `not_applicable`; Instance `not_applicable`; Principal `not_applicable`; resource `not_applicable`; Actor `not_applicable`; target Tenant/Instance `not_applicable`
- Sources: `database/migrations/0001_01_01_000002_create_jobs_table.php:11`
- Keys and relationships: jobs final-state columns: attempts, available_at, created_at, id, payload, queue, reserved_at. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: none recorded. Indexes: queue.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: Sensitive or credential/session-material field names are present; no values were collected.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No per-table contract exists for jobs.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded jobs evidence gaps?

### `mfa_recovery_codes`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `auth`; capability `auth`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `explicit`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_01_000001_create_mfa_tables.php:41`
- Keys and relationships: mfa_recovery_codes final-state columns: code_hash, created_at, id, updated_at, used_at, user_id. Database foreign keys: user_id -> users.id (cascade).
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: none recorded. Indexes: user_id+used_at.
- Lifecycle and deletion: Deletion behavior: cascade.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: Feature contract references mfa_recovery_codes. mfa_recovery_codes is declared by the Core package key auth; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: `contract_missing` — No per-table contract exists for mfa_recovery_codes.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded mfa_recovery_codes evidence gaps?

### `model_has_permissions`

- Review: reviewed
- Implementation / disposition: `compatibility` / `compatibility`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `explicit`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_04_09_000001_create_permission_tables.php:50`
- Keys and relationships: model_has_permissions final-state columns: model_id, model_type, permission_id. Database foreign keys: permission_id -> permissions.id (cascade).
- Uniqueness and indexes: Final-state primary keys: permission_id+model_id+model_type. Unique constraints: none recorded. Indexes: model_id+model_type.
- Lifecycle and deletion: Deletion behavior: cascade.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: Configuration-driven package-compatible table identity is preserved. Feature contract references model_has_permissions. model_has_permissions is declared by the Core package key roles; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: `contract_missing` — No per-table contract exists for model_has_permissions.; `compatibility_unresolved` — The table uses configuration-driven package-compatible naming; removal or replacement timing is not selected.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded model_has_permissions evidence gaps?

### `model_has_roles`

- Review: reviewed
- Implementation / disposition: `compatibility` / `compatibility`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `explicit`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_04_09_000001_create_permission_tables.php:79`
- Keys and relationships: model_has_roles final-state columns: model_id, model_type, role_id. Database foreign keys: role_id -> roles.id (cascade).
- Uniqueness and indexes: Final-state primary keys: role_id+model_id+model_type. Unique constraints: none recorded. Indexes: model_id+model_type.
- Lifecycle and deletion: Deletion behavior: cascade.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: Configuration-driven package-compatible table identity is preserved. Feature contract references model_has_roles. model_has_roles is declared by the Core package key roles; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: `contract_missing` — No per-table contract exists for model_has_roles.; `compatibility_unresolved` — The table uses configuration-driven package-compatible naming; removal or replacement timing is not selected.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded model_has_roles evidence gaps?

### `module_registry_entries`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `modules`; capability `modules`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php:11`
- Keys and relationships: module_registry_entries final-state columns: category, created_at, default_enabled, default_state, dependencies_json, disableable, id, installed_by_default, is_active, is_stale, key, name, source_hash, synced_at, tenant_eligible, updated_at. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: key. Indexes: category; default_state; installed_by_default; default_enabled; disableable; tenant_eligible; is_active; is_stale; synced_at.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `docs/06-database/tables/module_registry_entries.md`
- Compatibility: Feature contract references module_registry_entries.
- Contradictions: `implemented_table_unclaimed` — module_registry_entries is created by a registered migration but is absent from ownedTables declarations.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded module_registry_entries evidence gaps?

### `notification_registry_entries`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `notifications`; capability `notifications`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php:29`
- Keys and relationships: notification_registry_entries final-state columns: action_route, audience, category, created_at, database_enabled, dedupe_window_seconds, default_severity, description, digest_eligible, email_eligible, grouping_key, id, is_active, is_stale, key, label, module_key, source_hash, synced_at, updated_at. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: key. Indexes: module_key; category; default_severity; audience; database_enabled; email_eligible; digest_eligible; grouping_key; is_active; is_stale; synced_at.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `docs/06-database/tables/notification_registry_entries.md`
- Compatibility: Feature contract references notification_registry_entries.
- Contradictions: `implemented_table_unclaimed` — notification_registry_entries is created by a registered migration but is absent from ownedTables declarations.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded notification_registry_entries evidence gaps?

### `notifications`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `notifications`; capability `notifications`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `explicit`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_04_09_000004_create_notifications_table.php:11`, `database/migrations/2026_07_08_000002_add_type_key_to_notifications_table.php:11`
- Keys and relationships: notifications final-state columns: action_url, body, created_at, delivery_channels, dismissed_at, id, metadata, module_key, notifiable_id, notifiable_type, read_at, severity, title, type_key, updated_at, uuid. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: uuid. Indexes: notifiable_type+notifiable_id; module_key; severity; read_at; dismissed_at; type_key.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `docs/06-database/tables/notifications.md`
- Compatibility: Feature contract references notifications. notifications is declared by the Core package key notifications; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `password_reset_tokens`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `auth`; capability `auth`; Module `not_applicable`
- Scope: Tenant `not_applicable`; Instance `not_applicable`; Principal `not_applicable`; resource `not_applicable`; Actor `not_applicable`; target Tenant/Instance `not_applicable`
- Sources: `database/migrations/0001_01_01_000000_create_users_table.php:21`
- Keys and relationships: password_reset_tokens final-state columns: created_at, email, token. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: email. Unique constraints: none recorded. Indexes: none recorded.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: Sensitive or credential/session-material field names are present; no values were collected.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: Feature contract references password_reset_tokens. password_reset_tokens is declared by the Core package key auth; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: `contract_missing` — No per-table contract exists for password_reset_tokens.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded password_reset_tokens evidence gaps?

### `permission_registry_entries`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_07_000001_create_roles_registry_metadata_tables.php:11`
- Keys and relationships: permission_registry_entries final-state columns: action, created_at, description, group_key, group_label, id, is_active, is_destructive, is_elevated, is_stale, key, label, module_key, permission_id, source_hash, synced_at, updated_at. Database foreign keys: permission_id -> permissions.id (set_null).
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: key. Indexes: module_key; group_key; action; is_elevated; is_destructive; is_active; is_stale; synced_at.
- Lifecycle and deletion: Deletion behavior: set_null.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes set_null; retention and legal hold remain undocumented.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: Feature contract references permission_registry_entries. permission_registry_entries is declared by the Core package key roles; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: `contract_missing` — No per-table contract exists for permission_registry_entries.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded permission_registry_entries evidence gaps?

### `permissions`

- Review: reviewed
- Implementation / disposition: `compatibility` / `compatibility`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_04_09_000001_create_permission_tables.php:22`
- Keys and relationships: permissions final-state columns: created_at, guard_name, id, name, updated_at. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: name+guard_name. Indexes: none recorded.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: Configuration-driven package-compatible table identity is preserved. Feature contract references permissions. permissions is declared by the Core package key roles; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: `contract_missing` — No per-table contract exists for permissions.; `compatibility_unresolved` — The table uses configuration-driven package-compatible naming; removal or replacement timing is not selected.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded permissions evidence gaps?

### `platform_audit_logs`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `audit`; capability `audit`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `explicit`; resource `explicit`; Actor `explicit`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_04_08_000001_create_platform_audit_logs_table.php:11`
- Keys and relationships: platform_audit_logs final-state columns: action, actor_id, actor_type, actor_user_id, created_at, event_type, id, ip_address, is_security_event, is_system_event, metadata, method, occurred_at, request_id, result, route, severity, subject_id, subject_type, trace_id, updated_at, user_agent. Database foreign keys: actor_user_id -> users.id (set_null).
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: none recorded. Indexes: occurred_at; event_type; action; actor_type; actor_id; subject_type; subject_id; result; severity; request_id; trace_id; route; is_system_event; is_security_event.
- Lifecycle and deletion: Deletion behavior: set_null.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes set_null; retention and legal hold remain undocumented.
- Audit: This table is the current Audit event store.
- Contract: `docs/06-database/tables/platform_audit_logs.md`
- Compatibility: Feature contract references platform_audit_logs.
- Contradictions: `scope_missing` — Current Audit columns do not explicitly separate acting Instance from target Tenant/Instance scope.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded platform_audit_logs evidence gaps?

### `preference_registry_entries`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `preferences`; capability `preferences`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php:99`
- Keys and relationships: preference_registry_entries final-state columns: access_mode, access_value, active_route_patterns_json, created_at, description, group_key, group_label, group_sort_order, icon, id, is_active, is_stale, key, label, module_key, route_name, sort_order, source_hash, storage_scope, storage_table, synced_at, tenant_eligible, updated_at, view_path. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: key. Indexes: module_key; group_key; route_name; access_mode; access_value; group_sort_order; sort_order; tenant_eligible; storage_scope; storage_table; is_active; is_stale; synced_at.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `docs/06-database/tables/preference_registry_entries.md`
- Compatibility: Feature contract references preference_registry_entries.
- Contradictions: `implemented_table_unclaimed` — preference_registry_entries is created by a registered migration but is absent from ownedTables declarations.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded preference_registry_entries evidence gaps?

### `role_has_permissions`

- Review: reviewed
- Implementation / disposition: `compatibility` / `compatibility`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_04_09_000001_create_permission_tables.php:108`
- Keys and relationships: role_has_permissions final-state columns: permission_id, role_id. Database foreign keys: permission_id -> permissions.id (cascade); role_id -> roles.id (cascade).
- Uniqueness and indexes: Final-state primary keys: permission_id+role_id. Unique constraints: none recorded. Indexes: none recorded.
- Lifecycle and deletion: Deletion behavior: cascade.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: Configuration-driven package-compatible table identity is preserved. Feature contract references role_has_permissions. role_has_permissions is declared by the Core package key roles; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: `contract_missing` — No per-table contract exists for role_has_permissions.; `compatibility_unresolved` — The table uses configuration-driven package-compatible naming; removal or replacement timing is not selected.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded role_has_permissions evidence gaps?

### `role_metadata`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `explicit`; resource `absent`; Actor `explicit`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_07_000001_create_roles_registry_metadata_tables.php:30`
- Keys and relationships: role_metadata final-state columns: created_at, created_by_user_id, description, id, is_assignable, is_default, is_deletable, is_protected, is_system, label, role_id, updated_at, updated_by_user_id. Database foreign keys: role_id -> roles.id (cascade); created_by_user_id -> users.id (set_null); updated_by_user_id -> users.id (set_null).
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: role_id. Indexes: is_system; is_default; is_protected; is_deletable; is_assignable.
- Lifecycle and deletion: Deletion behavior: cascade, set_null.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes cascade, set_null; retention and legal hold remain undocumented.
- Audit: Actor-related columns provide partial accountable-change evidence.
- Contract: `missing`
- Compatibility: Feature contract references role_metadata. role_metadata is declared by the Core package key roles; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: `contract_missing` — No per-table contract exists for role_metadata.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded role_metadata evidence gaps?

### `roles`

- Review: reviewed
- Implementation / disposition: `compatibility` / `compatibility`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_04_09_000001_create_permission_tables.php:31`
- Keys and relationships: roles final-state columns: created_at, guard_name, id, name, updated_at. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: name+guard_name. Indexes: none recorded.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: Configuration-driven package-compatible table identity is preserved. Feature contract references roles. roles is declared by the Core package key roles; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: `contract_missing` — No per-table contract exists for roles.; `compatibility_unresolved` — The table uses configuration-driven package-compatible naming; removal or replacement timing is not selected.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded roles evidence gaps?

### `security_requirement_groups`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_01_000003_create_security_requirements_tables.php:11`
- Keys and relationships: security_requirement_groups final-state columns: asvs_family, created_at, id, risk_level, slug, sort_order, summary, title, updated_at. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: slug. Indexes: asvs_family; risk_level; sort_order.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: Feature contract references security_requirement_groups.
- Contradictions: `contract_missing` — No per-table contract exists for security_requirement_groups.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded security_requirement_groups evidence gaps?

### `security_requirements`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `explicit`; resource `absent`; Actor `explicit`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_01_000003_create_security_requirements_tables.php:22`
- Keys and relationships: security_requirements final-state columns: alignment_status, asvs_refs, canonical_docs, created_at, evidence_links, group_id, id, last_reviewed_at, last_reviewed_by, notes, owner_user_id, priority, slug, summary, target_phase, title, updated_at, work_status. Database foreign keys: group_id -> security_requirement_groups.id (cascade); owner_user_id -> users.id (set_null); last_reviewed_by -> users.id (set_null).
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: slug. Indexes: alignment_status; work_status; priority; target_phase; group_id+alignment_status; group_id+work_status.
- Lifecycle and deletion: Deletion behavior: cascade, set_null.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes cascade, set_null; retention and legal hold remain undocumented.
- Audit: Actor-related columns provide partial accountable-change evidence.
- Contract: `missing`
- Compatibility: Feature contract references security_requirements.
- Contradictions: `contract_missing` — No per-table contract exists for security_requirements.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded security_requirements evidence gaps?

### `sessions`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `auth`; capability `auth`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `explicit`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/0001_01_01_000000_create_users_table.php:27`
- Keys and relationships: sessions final-state columns: id, ip_address, last_activity, payload, user_agent, user_id. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: none recorded. Indexes: user_id; last_activity.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: Sensitive or credential/session-material field names are present; no values were collected.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: sessions is declared by the Core package key auth; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: `contract_missing` — No per-table contract exists for sessions.; `model_relationship_unenforced` — sessions.user_id is indexed but the migration does not declare a database foreign key.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded sessions evidence gaps?

### `settings`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `settings`; capability `settings`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `absent`; Actor `explicit`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_04_09_000003_create_settings_table.php:11`
- Keys and relationships: settings final-state columns: created_at, data_type, group_key, id, is_encrypted, is_public, key, module_key, scope_id, scope_type, updated_at, updated_by, value_jsonb. Database foreign keys: updated_by -> users.id (set_null).
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: scope_type+scope_id+module_key+group_key+key. Indexes: scope_type; scope_id; module_key; group_key; data_type; is_encrypted; is_public.
- Lifecycle and deletion: Deletion behavior: set_null.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes set_null; retention and legal hold remain undocumented.
- Audit: Actor-related columns provide partial accountable-change evidence.
- Contract: `docs/06-database/tables/settings.md`
- Compatibility: Feature contract references settings. settings is declared by the Core package key settings; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `settings_registry_entries`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `settings`; capability `settings`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php:51`
- Keys and relationships: settings_registry_entries final-state columns: access_mode, access_value, active_route_patterns_json, created_at, description, group_key, group_label, group_sort_order, icon, id, is_active, is_stale, key, label, module_key, route_name, sort_order, source_hash, synced_at, tenant_eligible, updated_at, view_path. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: key. Indexes: module_key; group_key; route_name; access_mode; access_value; group_sort_order; sort_order; tenant_eligible; is_active; is_stale; synced_at.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `docs/06-database/tables/settings_registry_entries.md`
- Compatibility: Feature contract references settings_registry_entries.
- Contradictions: `implemented_table_unclaimed` — settings_registry_entries is created by a registered migration but is absent from ownedTables declarations.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded settings_registry_entries evidence gaps?

### `setup_registry_entries`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `setup`; capability `setup`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `absent`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php:75`
- Keys and relationships: setup_registry_entries final-state columns: access_mode, access_value, active_route_patterns_json, completion_key, created_at, description, icon, id, is_active, is_blocking, is_required, is_stale, key, label, module_key, route_name, sort_order, source_hash, synced_at, tenant_eligible, updated_at, view_path. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: key. Indexes: module_key; route_name; access_mode; access_value; sort_order; tenant_eligible; is_required; is_blocking; completion_key; is_active; is_stale; synced_at.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `docs/06-database/tables/setup_registry_entries.md`
- Compatibility: Feature contract references setup_registry_entries.
- Contradictions: `implemented_table_unclaimed` — setup_registry_entries is created by a registered migration but is absent from ownedTables declarations.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded setup_registry_entries evidence gaps?

### `user_contact_emails`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `identity`; capability `identity`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `explicit`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_07_000002_create_user_contact_emails_table.php:11`
- Keys and relationships: user_contact_emails final-state columns: created_at, email, id, label, normalized_email, updated_at, user_id, verified_at. Database foreign keys: user_id -> users.id (cascade).
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: normalized_email. Indexes: user_id+verified_at.
- Lifecycle and deletion: Deletion behavior: cascade.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `docs/06-database/tables/user_contact_emails.md`
- Compatibility: Feature contract references user_contact_emails.
- Contradictions: `implemented_table_unclaimed` — user_contact_emails is created by a registered migration but is absent from ownedTables declarations.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded user_contact_emails evidence gaps?

### `user_dashboard_layouts`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `dashboard`; capability `dashboard`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `explicit`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_04_13_000001_create_user_dashboard_layouts_table.php:11`
- Keys and relationships: user_dashboard_layouts final-state columns: created_at, id, is_locked, layout, updated_at, user_id. Database foreign keys: user_id -> users.id (cascade).
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: user_id. Indexes: none recorded.
- Lifecycle and deletion: Deletion behavior: cascade.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `docs/06-database/tables/user_dashboard_layouts.md`
- Compatibility: Feature contract references user_dashboard_layouts. user_dashboard_layouts is declared by the Core package key dashboard; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `user_mfa_methods`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `auth`; capability `auth`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `explicit`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_01_000001_create_mfa_tables.php:11`, `database/migrations/2026_07_01_000002_add_pending_secret_expiry_to_user_mfa_methods.php:11`
- Keys and relationships: user_mfa_methods final-state columns: confirmed_at, created_at, id, last_challenged_at, last_satisfied_at, pending_secret, pending_secret_expires_at, reset_at, reset_by_user_id, secret, type, updated_at, user_id. Database foreign keys: user_id -> users.id (cascade); reset_by_user_id -> users.id (set_null).
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: user_id+type. Indexes: type+confirmed_at.
- Lifecycle and deletion: Deletion behavior: cascade, set_null.
- Classification: Sensitive or credential/session-material field names are present; no values were collected.
- Retention and erasure: Foreign-key deletion behavior includes cascade, set_null; retention and legal hold remain undocumented.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: Feature contract references user_mfa_methods. user_mfa_methods is declared by the Core package key auth; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: `contract_missing` — No per-table contract exists for user_mfa_methods.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded user_mfa_methods evidence gaps?

### `user_mfa_policies`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `auth`; capability `auth`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `explicit`; resource `absent`; Actor `explicit`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_01_000001_create_mfa_tables.php:28`
- Keys and relationships: user_mfa_policies final-state columns: created_at, id, mfa_required, required_at, required_by_user_id, updated_at, updated_by_user_id, user_id. Database foreign keys: user_id -> users.id (cascade); required_by_user_id -> users.id (set_null); updated_by_user_id -> users.id (set_null).
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: user_id. Indexes: mfa_required.
- Lifecycle and deletion: Deletion behavior: cascade, set_null.
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes cascade, set_null; retention and legal hold remain undocumented.
- Audit: Actor-related columns provide partial accountable-change evidence.
- Contract: `missing`
- Compatibility: Feature contract references user_mfa_policies. user_mfa_policies is declared by the Core package key auth; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: `contract_missing` — No per-table contract exists for user_mfa_policies.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded user_mfa_policies evidence gaps?

### `user_notification_preferences`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `notifications`; capability `notifications`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `explicit`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/2026_07_07_000003_create_user_notification_preferences_table.php:11`, `database/migrations/2026_07_08_000001_drop_in_app_enabled_from_user_notification_preferences_table.php:15`
- Keys and relationships: user_notification_preferences final-state columns: created_at, digest_frequency, email_enabled, id, updated_at, user_id. Database foreign keys: user_id -> users.id (cascade).
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: user_id. Indexes: none recorded.
- Lifecycle and deletion: Deletion behavior: cascade, dropColumn('in_app_enabled').
- Classification: No canonical per-table data classification is established by migration source.
- Retention and erasure: Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `docs/06-database/tables/user_notification_preferences.md`
- Compatibility: Feature contract references user_notification_preferences. user_notification_preferences is declared by the Core package key notifications; a Modules path is transitional physical placement, not Module ownership.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `users`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `identity`; capability `identity`; Module `not_applicable`
- Scope: Tenant `absent`; Instance `absent`; Principal `indirect`; resource `absent`; Actor `absent`; target Tenant/Instance `absent`
- Sources: `database/migrations/0001_01_01_000000_create_users_table.php:11`, `database/migrations/2026_04_09_000002_add_phase_one_lifecycle_columns_to_users_table.php:11`, `database/migrations/2026_04_09_000005_add_timezone_to_users_table.php:11`, `database/migrations/2026_04_10_000001_add_staff_profile_fields_to_users_table.php:11`, `database/migrations/2026_04_12_220000_add_theme_preference_to_users_table.php:11`
- Keys and relationships: users final-state columns: created_at, default_language, direction, email, email_signature, email_verified_at, facebook, first_name, hourly_rate, id, is_active, is_administrator, is_staff_member, last_login_at, last_name, linkedin, name, password, phone, profile_image_path, remember_token, send_welcome_email, skype, theme_preference, timezone, updated_at. Database foreign keys: none.
- Uniqueness and indexes: Final-state primary keys: id. Unique constraints: email. Indexes: is_active.
- Lifecycle and deletion: No explicit retention lifecycle is established by the migration chain.
- Classification: Sensitive or credential/session-material field names are present; no values were collected.
- Retention and erasure: Retention, erasure, and legal-hold behavior are not established by migration source.
- Audit: No table-specific Audit requirement is established by migration source.
- Contract: `missing`
- Compatibility: Feature contract references users.
- Contradictions: `contract_missing` — No per-table contract exists for users.; `scope_missing` — The User Account row has no explicit Tenant or Instance key.; `planning_implementation_overlap` — Account, identity, profile, staff, and preference concerns are currently combined while active planning evaluates separation.
- Target question: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded users evidence gaps?

<!-- PERSISTENT-DATA-INVENTORY:IMPLEMENTED:END -->

## 9. Planned Persistent Concepts

<!-- PERSISTENT-DATA-INVENTORY:PLANNED:START -->

### `concept.access_group`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:188`
- Keys and relationships: Access groups are an explicit candidate data surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `planning_implementation_overlap` — Active planned persistence overlaps current implemented storage without selecting the target model.; `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access group?

### `concept.access_group_member`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:189`
- Keys and relationships: Access group membership is an explicit candidate association surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `planning_implementation_overlap` — Active planned persistence overlaps current implemented storage without selecting the target model.; `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access group member?

### `concept.access_policy`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:190`
- Keys and relationships: Access policies are an explicit candidate governance and scope surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `planning_implementation_overlap` — Active planned persistence overlaps current implemented storage without selecting the target model.; `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access policy?

### `concept.access_policy_approval`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:192`
- Keys and relationships: Access policy approvals are an explicit candidate accountable-decision surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `planning_implementation_overlap` — Active planned persistence overlaps current implemented storage without selecting the target model.; `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access policy approval?

### `concept.access_policy_constraint`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:191`
- Keys and relationships: Access policy constraints are an explicit candidate data surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `planning_implementation_overlap` — Active planned persistence overlaps current implemented storage without selecting the target model.; `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access policy constraint?

### `concept.access_review_campaign`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:194`
- Keys and relationships: Access review campaigns are an explicit candidate review-lifecycle surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `planning_implementation_overlap` — Active planned persistence overlaps current implemented storage without selecting the target model.; `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access review campaign?

### `concept.access_review_decision`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:196`
- Keys and relationships: Access review decisions are an explicit candidate accountable-evidence surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `planning_implementation_overlap` — Active planned persistence overlaps current implemented storage without selecting the target model.; `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access review decision?

### `concept.access_review_item`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:195`
- Keys and relationships: Access review items are an explicit candidate association surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `planning_implementation_overlap` — Active planned persistence overlaps current implemented storage without selecting the target model.; `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access review item?

### `concept.actor_attribution_envelope`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `audit`; capability `audit`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md:22`
- Keys and relationships: Audit Actor attribution must distinguish Principal, acting Instance, channel, action, target, and result.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement actor attribution envelope?

### `concept.api_token`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `auth`; capability `auth`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:138`
- Keys and relationships: API token metadata, prefix/hash, scope, expiry, rotation, and revocation require lifecycle persistence.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement api token?

### `concept.api_token_event`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `monitoring`; capability `monitoring`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:161`
- Keys and relationships: A dedicated high-volume API token event table is an explicit optional alternative to Audit.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement api token event?

### `concept.application_principal_reference`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `identity`; capability `identity`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:72`
- Keys and relationships: Application Principal references require a persistent mapping boundary.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement application principal reference?

### `concept.assurance_evidence`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:37`
- Keys and relationships: Assurance and attestation evidence requires its own lifecycle and classification.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement assurance evidence?

### `concept.audit_event`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `audit`; capability `audit`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `unknown`
- Sources: `docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md:423`
- Keys and relationships: A target audit_events surface remains planned and undecided.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `planning_implementation_overlap` — Active planned persistence overlaps current implemented storage without selecting the target model.; `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement audit event?

### `concept.audit_event_change`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `audit`; capability `audit`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `unknown`
- Sources: `docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md:424`
- Keys and relationships: Audit change-set rows are a distinct planned association surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement audit event change?

### `concept.backup_health_record`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `monitoring`; capability `monitoring`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/audit-monitoring-response/backup-recovery-planning.md:140`
- Keys and relationships: Backup health, freshness, verification, and restore evidence may require durable monitoring records.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement backup health record?

### `concept.consent_record`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_governance`; capability `data_governance`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:303`
- Keys and relationships: Consent records are an explicit candidate lifecycle surface for optional processing.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement consent record?

### `concept.credential_material`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md:78`
- Keys and relationships: Reusable credential material requires an approved protected storage boundary.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement credential material?

### `concept.credential_metadata`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:98`
- Keys and relationships: Credential metadata lifecycle must remain separate from reusable credential material.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement credential metadata?

### `concept.credential_reference`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md:167`
- Keys and relationships: Application persistence may store safe references to externally protected credential material.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement credential reference?

### `concept.data_asset_governance_record`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_governance`; capability `data_governance`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:231`
- Keys and relationships: Candidate data-asset governance records persist ownership, purpose, classification, and review metadata.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement data asset governance record?

### `concept.data_domain_registry`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_governance`; capability `data_governance`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:193`
- Keys and relationships: A candidate data-domain registry would persist ownership and governance metadata.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement data domain registry?

### `concept.data_quality_issue`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_governance`; capability `data_governance`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:411`
- Keys and relationships: Data quality issues are an explicit candidate remediation lifecycle surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement data quality issue?

### `concept.data_subject_registry`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_governance`; capability `data_governance`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:457`
- Keys and relationships: A consolidated data-subject table is a conditional storage alternative.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement data subject registry?

### `concept.deletion_erasure_evidence`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_governance`; capability `data_governance`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:33`
- Keys and relationships: Deletion and erasure decisions require accountable evidence without retaining erased content.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement deletion erasure evidence?

### `concept.elevated_access_session`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:193`
- Keys and relationships: Elevated access sessions are an explicit candidate lifecycle surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement elevated access session?

### `concept.evidence_chain_of_custody_entry`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `audit`; capability `audit`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/audit-monitoring-response/digital-forensics-readiness-planning.md:297`
- Keys and relationships: Chain-of-custody entries are a distinct candidate accountable lifecycle surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement evidence chain of custody entry?

### `concept.evidence_package`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `audit`; capability `audit`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/audit-monitoring-response/digital-forensics-readiness-planning.md:256`
- Keys and relationships: Evidence packages are an explicit candidate protected investigation surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement evidence package?

### `concept.evidence_package_item`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `audit`; capability `audit`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/audit-monitoring-response/digital-forensics-readiness-planning.md:279`
- Keys and relationships: Evidence package items are a distinct candidate association and integrity surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement evidence package item?

### `concept.export_artifact_metadata`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_protection`; capability `data_protection`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md:383`
- Keys and relationships: Generated export artifact references and expiry metadata require protected persistence.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement export artifact metadata?

### `concept.export_request`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_protection`; capability `data_protection`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `unknown`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md:91`
- Keys and relationships: Sensitive export request, approval, status, and audit metadata require lifecycle persistence.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement export request?

### `concept.health_check_result`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `monitoring`; capability `monitoring`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md:475`
- Keys and relationships: Health check results are an explicit planned Monitoring persistence surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement health check result?

### `concept.incident_case`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `unknown`
- Sources: `docs/07-planning/02-core-capabilities/audit-monitoring-response/incident-response-planning.md:183`
- Keys and relationships: Incident case lifecycle and accountable decisions are planned persistent evidence.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement incident case?

### `concept.legal_hold`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_governance`; capability `data_governance`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md:383`
- Keys and relationships: Legal-hold state must be represented separately from ordinary retention.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement legal hold?

### `concept.machine_identity`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:45`
- Keys and relationships: Machine Identity evidence is independent from NHI Principal identity.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement machine identity?

### `concept.network_context`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:123`
- Keys and relationships: Network Context evidence is planned separately from durable Principal identity.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement network context?

### `concept.network_identity`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:121`
- Keys and relationships: Network Identity evidence may accompany a human or non-human Principal.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement network identity?

### `concept.non_human_identity_principal`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `identity`; capability `identity`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:45`
- Keys and relationships: Non-Human Identity Principal persistence is planned separately from Machine Identity.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement non human identity principal?

### `concept.privacy_request`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_governance`; capability `data_governance`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `unknown`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:344`
- Keys and relationships: Privacy request lifecycle persistence is planned.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement privacy request?

### `concept.privacy_request_item`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_governance`; capability `data_governance`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `unknown`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:361`
- Keys and relationships: Privacy request items associate one request with governed assets and fulfillment outcomes.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement privacy request item?

### `concept.processing_purpose`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_governance`; capability `data_governance`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:263`
- Keys and relationships: Processing purposes are an explicit candidate registry surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement processing purpose?

### `concept.retention_policy_registry`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_governance`; capability `data_governance`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:50`
- Keys and relationships: Retention policy registry metadata and enforcement evidence require persistent ownership.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement retention policy registry?

### `concept.risk_acceptance`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/security/vulnerability-management-core-planning.md:294`
- Keys and relationships: Risk acceptance requires accountable expiry and approval evidence.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement risk acceptance?

### `concept.secret_metadata`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md:21`
- Keys and relationships: Secret metadata must be persisted without storing revealable values in ordinary application records.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement secret metadata?

### `concept.secret_rotation_event`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md:543`
- Keys and relationships: Secret rotation events are an explicit candidate lifecycle surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement secret rotation event?

### `concept.service_account_table`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:116`
- Keys and relationships: A dedicated service_accounts table remains the recommended but unaccepted storage alternative.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `duplicate_persistent_concept` — Active planning retains materially different Service Account storage alternatives.; `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement service account table?

### `concept.service_account_users_type`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:99`
- Keys and relationships: Extending users with a service type remains an open Service Account storage alternative.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `duplicate_persistent_concept` — Active planning retains materially different Service Account storage alternatives.; `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement service account users type?

### `concept.target_tenant_instance_scope`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `access`; capability `access`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:84`
- Keys and relationships: Affected Tenant and Instance scope must remain separate from Actor scope.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement target tenant instance scope?

### `concept.user_lifecycle_metadata`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `identity`; capability `identity`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/users-module-implementation-planning.md:291`
- Keys and relationships: A separate user lifecycle metadata table is an active conditional persistence option.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement user lifecycle metadata?

### `concept.vulnerability_asset`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/security/vulnerability-management-core-planning.md:254`
- Keys and relationships: Vulnerability asset inventory metadata is a planned persistence option.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement vulnerability asset?

### `concept.vulnerability_finding`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `unknown`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/security/vulnerability-management-core-planning.md:269`
- Keys and relationships: Vulnerability findings may become persistent when reporting requires it.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement vulnerability finding?

### `concept.webhook_delivery`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `explicit`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:424`
- Keys and relationships: Webhook delivery metadata, safe payload evidence, replay state, and processing status are a candidate persistence surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement webhook delivery?

### `concept.webhook_endpoint`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:405`
- Keys and relationships: Webhook endpoint identity and safe secret references are a candidate persistence surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement webhook endpoint?

### `concept.webhook_processing_attempt`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `monitoring`; capability `monitoring`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:451`
- Keys and relationships: Webhook processing attempts are a candidate retry and failure-evidence surface.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Classification remains a target data-governance question.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement webhook processing attempt?

### `concept.workload_identity_reference`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `identity`; capability `identity`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `explicit`; resource `unknown`; Actor `unknown`; target Tenant/Instance `not_applicable`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:68`
- Keys and relationships: Workload Identity references require a persistent mapping boundary.
- Uniqueness and indexes: No implemented keys, uniqueness, or indexes exist for this planned concept.
- Lifecycle and deletion: Planning establishes a material lifecycle question; implementation is not present.
- Classification: Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive.
- Retention and erasure: Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.
- Audit: Accountable lifecycle and Audit integration remain target implementation questions.
- Contract: `missing`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `contract_missing` — No implemented per-table contract applies to this planned concept.
- Target question: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement workload identity reference?

<!-- PERSISTENT-DATA-INVENTORY:PLANNED:END -->

## 10. Generated, Framework-Managed, File, And External Boundaries

<!-- PERSISTENT-DATA-INVENTORY:BOUNDARIES:START -->

### `boundary.backup_artifacts`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_protection`; capability `data_protection`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `not_applicable`; resource `explicit`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `docs/07-planning/02-core-capabilities/audit-monitoring-response/backup-recovery-planning.md:67`
- Keys and relationships: Backup artifacts remain outside ordinary application-created tables.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `lifecycle_or_deletion_unclear` — Lifecycle and deletion behavior is not fully established for this boundary.; `retention_or_erasure_missing` — Retention, erasure, and legal-hold evidence is incomplete for this boundary.
- Target question: Which owner, retention, erasure, access, and Audit controls govern backup artifacts?

### `boundary.database_cache`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `infrastructure`; capability `infrastructure`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `not_applicable`; resource `not_applicable`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `config/cache.php:18`
- Keys and relationships: The default cache store uses database persistence and the cache/cache_locks tables.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary classification depends on its consumers.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `boundary.database_connection_target`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `database`; capability `database`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `not_applicable`; resource `not_applicable`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `config/database.php:20`, `.env.example:31`
- Keys and relationships: The runtime connection fallback and canonical PostgreSQL direction require explicit reconciliation. The source-controlled example environment selects PostgreSQL while config/database.php retains a SQLite fallback.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary classification depends on its consumers.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `database_target_conflict` — Canonical PostgreSQL direction and the example environment differ from the SQLite fallback in runtime configuration.
- Target question: Which owner, retention, erasure, access, and Audit controls govern database connection target?

### `boundary.database_queue`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `infrastructure`; capability `infrastructure`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `not_applicable`; resource `not_applicable`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `config/queue.php:16`
- Keys and relationships: The default queue connection persists jobs, batches, and failures in database tables.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary classification depends on its consumers.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `boundary.database_sessions`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `auth`; capability `auth`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `indirect`; resource `not_applicable`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `config/session.php:21`
- Keys and relationships: The default session driver persists session payloads in the database.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `boundary.export_artifacts`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `data_protection`; capability `data_protection`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `indirect`; resource `explicit`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md:7`
- Keys and relationships: Generated exports require private storage, expiry, access, and erasure controls.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `lifecycle_or_deletion_unclear` — Lifecycle and deletion behavior is not fully established for this boundary.; `retention_or_erasure_missing` — Retention, erasure, and legal-hold evidence is incomplete for this boundary.
- Target question: Which owner, retention, erasure, access, and Audit controls govern export artifacts?

### `boundary.external_secret_manager`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `security`; capability `security`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `indirect`; resource `not_applicable`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md:598`
- Keys and relationships: An external secret manager is a candidate protected credential-material boundary.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `lifecycle_or_deletion_unclear` — Lifecycle and deletion behavior is not fully established for this boundary.; `retention_or_erasure_missing` — Retention, erasure, and legal-hold evidence is incomplete for this boundary.
- Target question: Which owner, retention, erasure, access, and Audit controls govern external secret manager?

### `boundary.file_cache`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `infrastructure`; capability `infrastructure`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `not_applicable`; resource `not_applicable`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `config/cache.php:50`
- Keys and relationships: Laravel can persist cache entries under the framework cache directory.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary classification depends on its consumers.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `boundary.file_sessions`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `auth`; capability `auth`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `indirect`; resource `not_applicable`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `config/session.php:54`
- Keys and relationships: Laravel can persist session payloads in framework session files.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `boundary.laravel_migration_repository`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `database`; capability `database`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `not_applicable`; resource `not_applicable`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `config/database.php:121`
- Keys and relationships: Laravel tracks applied migration names in its framework-managed migration repository.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary classification depends on its consumers.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `boundary.object_storage`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `data_protection`; capability `data_protection`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `not_applicable`; resource `explicit`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `config/filesystems.php:50`
- Keys and relationships: The S3 disk represents external object storage without recording credentials.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `boundary.private_filesystem`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `data_protection`; capability `data_protection`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `not_applicable`; resource `explicit`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `config/filesystems.php:35`
- Keys and relationships: The local disk maps to private application storage.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary classification depends on its consumers.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `boundary.profile_images`

- Review: reviewed
- Implementation / disposition: `planned` / `investigate`
- Ownership: `core`; owner `identity`; capability `identity`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `indirect`; resource `explicit`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `docs/07-planning/02-core-capabilities/auth-identity-access/users-module-implementation-planning.md:297`
- Keys and relationships: Profile-image file persistence has unresolved lifecycle, classification, and erasure evidence.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `lifecycle_or_deletion_unclear` — Lifecycle and deletion behavior is not fully established for this boundary.; `retention_or_erasure_missing` — Retention, erasure, and legal-hold evidence is incomplete for this boundary.
- Target question: Which owner, retention, erasure, access, and Audit controls govern profile images?

### `boundary.public_filesystem`

- Review: reviewed
- Implementation / disposition: `implemented` / `investigate`
- Ownership: `core`; owner `data_protection`; capability `data_protection`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `not_applicable`; resource `explicit`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `config/filesystems.php:41`
- Keys and relationships: The public disk maps to web-addressable application storage.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary classification depends on its consumers.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: `sensitive_storage_risk` — Public storage is material to protected-file review even though no sensitive contents were inspected.
- Target question: Which owner, retention, erasure, access, and Audit controls govern public filesystem?

### `boundary.redis_cache`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `infrastructure`; capability `infrastructure`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `not_applicable`; resource `not_applicable`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `config/cache.php:75`
- Keys and relationships: Laravel can use Redis as an external cache and lock boundary.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary classification depends on its consumers.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

### `boundary.redis_queue`

- Review: reviewed
- Implementation / disposition: `implemented` / `retain`
- Ownership: `core`; owner `infrastructure`; capability `infrastructure`; Module `not_applicable`
- Scope: Tenant `unknown`; Instance `unknown`; Principal `not_applicable`; resource `not_applicable`; Actor `unknown`; target Tenant/Instance `unknown`
- Sources: `config/queue.php:69`
- Keys and relationships: Laravel can use Redis as an external queue boundary.
- Uniqueness and indexes: This non-table boundary does not expose application-owned relational keys or indexes.
- Lifecycle and deletion: Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.
- Classification: The boundary classification depends on its consumers.
- Retention and erasure: Retention and erasure behavior is incomplete or consumer-specific.
- Audit: Boundary use may require Audit evidence; configuration alone does not prove it.
- Contract: `not_applicable`
- Compatibility: No compatibility evidence recorded.
- Contradictions: None recorded.
- Target question: No target change is selected by this inventory.

<!-- PERSISTENT-DATA-INVENTORY:BOUNDARIES:END -->

## 11. Contract Coverage And Ownership Reconciliation

<!-- PERSISTENT-DATA-INVENTORY:CONTRACTS:START -->

### Contract And Ownership Coverage

| Storage                         | Contract                                                   | Owner            | Ownership/contract contradictions |
| ------------------------------- | ---------------------------------------------------------- | ---------------- | --------------------------------- |
| `cache`                         | missing                                                    | `infrastructure` | `contract_missing`                |
| `cache_locks`                   | missing                                                    | `infrastructure` | `contract_missing`                |
| `central_error_logs`            | `docs/06-database/tables/central_error_logs.md`            | `monitoring`     | none                              |
| `failed_jobs`                   | missing                                                    | `infrastructure` | `contract_missing`                |
| `job_batches`                   | missing                                                    | `infrastructure` | `contract_missing`                |
| `jobs`                          | missing                                                    | `infrastructure` | `contract_missing`                |
| `mfa_recovery_codes`            | missing                                                    | `auth`           | `contract_missing`                |
| `model_has_permissions`         | missing                                                    | `access`         | `contract_missing`                |
| `model_has_roles`               | missing                                                    | `access`         | `contract_missing`                |
| `module_registry_entries`       | `docs/06-database/tables/module_registry_entries.md`       | `modules`        | `implemented_table_unclaimed`     |
| `notification_registry_entries` | `docs/06-database/tables/notification_registry_entries.md` | `notifications`  | `implemented_table_unclaimed`     |
| `notifications`                 | `docs/06-database/tables/notifications.md`                 | `notifications`  | none                              |
| `password_reset_tokens`         | missing                                                    | `auth`           | `contract_missing`                |
| `permission_registry_entries`   | missing                                                    | `access`         | `contract_missing`                |
| `permissions`                   | missing                                                    | `access`         | `contract_missing`                |
| `platform_audit_logs`           | `docs/06-database/tables/platform_audit_logs.md`           | `audit`          | none                              |
| `preference_registry_entries`   | `docs/06-database/tables/preference_registry_entries.md`   | `preferences`    | `implemented_table_unclaimed`     |
| `role_has_permissions`          | missing                                                    | `access`         | `contract_missing`                |
| `role_metadata`                 | missing                                                    | `access`         | `contract_missing`                |
| `roles`                         | missing                                                    | `access`         | `contract_missing`                |
| `security_requirement_groups`   | missing                                                    | `security`       | `contract_missing`                |
| `security_requirements`         | missing                                                    | `security`       | `contract_missing`                |
| `sessions`                      | missing                                                    | `auth`           | `contract_missing`                |
| `settings`                      | `docs/06-database/tables/settings.md`                      | `settings`       | none                              |
| `settings_registry_entries`     | `docs/06-database/tables/settings_registry_entries.md`     | `settings`       | `implemented_table_unclaimed`     |
| `setup_registry_entries`        | `docs/06-database/tables/setup_registry_entries.md`        | `setup`          | `implemented_table_unclaimed`     |
| `user_contact_emails`           | `docs/06-database/tables/user_contact_emails.md`           | `identity`       | `implemented_table_unclaimed`     |
| `user_dashboard_layouts`        | `docs/06-database/tables/user_dashboard_layouts.md`        | `dashboard`      | none                              |
| `user_mfa_methods`              | missing                                                    | `auth`           | `contract_missing`                |
| `user_mfa_policies`             | missing                                                    | `auth`           | `contract_missing`                |
| `user_notification_preferences` | `docs/06-database/tables/user_notification_preferences.md` | `notifications`  | none                              |
| `users`                         | missing                                                    | `identity`       | `contract_missing`                |

### Models, Factories, And Seeders

- Model `app/Models/CentralErrorLog.php`: explicit table Laravel convention; relationships none recorded; soft deletes no.
- Model `app/Models/PlatformAuditLog.php`: explicit table Laravel convention; relationships `actorUser:belongsTo`; soft deletes no.
- Model `app/Models/SecurityRequirement.php`: explicit table Laravel convention; relationships `group:belongsTo`, `owner:belongsTo`, `lastReviewedBy:belongsTo`; soft deletes no.
- Model `app/Models/SecurityRequirementGroup.php`: explicit table Laravel convention; relationships `requirements:hasMany`; soft deletes no.
- Model `app/Models/Setting.php`: explicit table Laravel convention; relationships `updatedBy:belongsTo`; soft deletes no.
- Model `app/Models/User.php`: explicit table Laravel convention; relationships `contactEmails:hasMany`, `notificationPreference:hasOne`, `mfaMethods:hasMany`, `totpMfaMethod:hasOne`, `mfaPolicy:hasOne`, `mfaRecoveryCodes:hasMany`; soft deletes no.
- Model `app/Models/UserDashboardLayout.php`: explicit table Laravel convention; relationships `user:belongsTo`; soft deletes no.
- Model `Modules/Account/Models/UserContactEmail.php`: explicit table `user_contact_emails`; relationships `user:belongsTo`; soft deletes no.
- Model `Modules/Auth/Models/MfaRecoveryCode.php`: explicit table Laravel convention; relationships `user:belongsTo`; soft deletes no.
- Model `Modules/Auth/Models/UserMfaMethod.php`: explicit table Laravel convention; relationships `user:belongsTo`, `resetBy:belongsTo`; soft deletes no.
- Model `Modules/Auth/Models/UserMfaPolicy.php`: explicit table Laravel convention; relationships `user:belongsTo`, `requiredBy:belongsTo`, `updatedBy:belongsTo`; soft deletes no.
- Model `Modules/Notifications/Models/Notification.php`: explicit table `notifications`; relationships `notifiable:morphTo`; soft deletes no.
- Model `Modules/Notifications/Models/UserNotificationPreference.php`: explicit table `user_notification_preferences`; relationships `user:belongsTo`; soft deletes no.
- Factory `database/factories/UserFactory.php`: associated model not explicitly resolved; secret-bearing values were not collected.
- Seeder `database/seeders/DatabaseSeeder.php`: safe structure and field names were inventoried; personal and credential values were not collected.
- Seeder `database/seeders/ModuleContributionRegistrySeeder.php`: safe structure and field names were inventoried; personal and credential values were not collected.
- Seeder `database/seeders/PlatformRolesAndPermissionsSeeder.php`: safe structure and field names were inventoried; personal and credential values were not collected.
- Seeder `database/seeders/SecurityRequirementSeeder.php`: safe structure and field names were inventoried; personal and credential values were not collected.
- Seeder `Modules/Roles/Database/Seeders/Defaults.php`: safe structure and field names were inventoried; personal and credential values were not collected.

### Ownership Declarations And Database Tests

- `central_error_logs` is declared by `logging` at `app/Core/Modules/Definitions.php:97`.
- `mfa_recovery_codes` is declared by `auth` at `Modules/Auth/Definition.php:37`.
- `model_has_permissions` is declared by `roles` at `Modules/Roles/Definition.php:112`.
- `model_has_roles` is declared by `roles` at `Modules/Roles/Definition.php:112`.
- `notifications` is declared by `notifications` at `Modules/Notifications/Definition.php:87`.
- `password_reset_tokens` is declared by `auth` at `Modules/Auth/Definition.php:37`.
- `permission_registry_entries` is declared by `roles` at `Modules/Roles/Definition.php:112`.
- `permissions` is declared by `roles` at `Modules/Roles/Definition.php:112`.
- `platform_audit_logs` is declared by `logging` at `app/Core/Modules/Definitions.php:97`.
- `role_has_permissions` is declared by `roles` at `Modules/Roles/Definition.php:112`.
- `role_metadata` is declared by `roles` at `Modules/Roles/Definition.php:112`.
- `roles` is declared by `roles` at `Modules/Roles/Definition.php:112`.
- `security_requirement_groups` is declared by `security_checklist` at `app/Core/Modules/Definitions.php:168`.
- `security_requirements` is declared by `security_checklist` at `app/Core/Modules/Definitions.php:168`.
- `sessions` is declared by `auth` at `Modules/Auth/Definition.php:37`.
- `settings` is declared by `settings` at `Modules/Settings/Definition.php:90`.
- `user_dashboard_layouts` is declared by `dashboard` at `Modules/Dashboard/Definition.php:41`.
- `user_mfa_methods` is declared by `auth` at `Modules/Auth/Definition.php:37`.
- `user_mfa_policies` is declared by `auth` at `Modules/Auth/Definition.php:37`.
- `user_notification_preferences` is declared by `notifications` at `Modules/Notifications/Definition.php:87`.
- `users` is declared by `users` at `app/Core/Modules/Definitions.php:61`.
- Database-related test evidence: `tests/Browser/AuthLoginSmoke.spec.js`.
- Database-related test evidence: `tests/Browser/NotificationTransport.spec.js`.
- Database-related test evidence: `tests/Feature/Auth/AuthorizationTest.php`.
- Database-related test evidence: `tests/Feature/Auth/LoginTest.php`.
- Database-related test evidence: `tests/Feature/Auth/MfaLoginTest.php`.
- Database-related test evidence: `tests/Feature/Auth/MfaStepUpTest.php`.
- Database-related test evidence: `tests/Feature/Platform/BroadcastChannelAuthorizationTest.php`.
- Database-related test evidence: `tests/Feature/Platform/ErrorLogViewerTest.php`.
- Database-related test evidence: `tests/Feature/Platform/ModuleContributionRegistryTest.php`.
- Database-related test evidence: `tests/Feature/Platform/NotificationServiceTest.php`.
- Database-related test evidence: `tests/Feature/Platform/PlatformAuditLogViewerTest.php`.
- Database-related test evidence: `tests/Feature/Platform/PlatformDashboardTest.php`.
- Database-related test evidence: `tests/Feature/Platform/PlatformModuleRegistryTest.php`.
- Database-related test evidence: `tests/Feature/Platform/PlatformNotificationsTest.php`.
- Database-related test evidence: `tests/Feature/Platform/PlatformRouteAuthorizationMatrixTest.php`.
- Database-related test evidence: `tests/Feature/Platform/PlatformSettingsTest.php`.
- Database-related test evidence: `tests/Feature/Platform/PlatformUserManagementTest.php`.
- Database-related test evidence: `tests/Feature/Platform/RolesModuleTest.php`.
- Database-related test evidence: `tests/Feature/Platform/SettingsServiceTest.php`.
- Database-related test evidence: `tests/Feature/Ui/NotificationPatternContractTest.php`.
- Database-related test evidence: `tests/Feature/Ui/NotificationToastContractTest.php`.
- Database-related test evidence: `tests/Unit/CentralErrorLogTest.php`.
- Database-related test evidence: `tests/Unit/PlatformAuditLogTest.php`.

<!-- PERSISTENT-DATA-INVENTORY:CONTRACTS:END -->

## 12. Scope, Identity, Actor, And Assurance Findings

<!-- PERSISTENT-DATA-INVENTORY:SCOPE-FINDINGS:START -->

| Storage                                   | Tenant         | Instance       | Principal      | Resource       | Actor          | Target Tenant/Instance |
| ----------------------------------------- | -------------- | -------------- | -------------- | -------------- | -------------- | ---------------------- |
| `boundary.backup_artifacts`               | unknown        | unknown        | not_applicable | explicit       | unknown        | unknown                |
| `boundary.database_cache`                 | unknown        | unknown        | not_applicable | not_applicable | unknown        | unknown                |
| `boundary.database_connection_target`     | unknown        | unknown        | not_applicable | not_applicable | unknown        | unknown                |
| `boundary.database_queue`                 | unknown        | unknown        | not_applicable | not_applicable | unknown        | unknown                |
| `boundary.database_sessions`              | unknown        | unknown        | indirect       | not_applicable | unknown        | unknown                |
| `boundary.export_artifacts`               | unknown        | unknown        | indirect       | explicit       | unknown        | unknown                |
| `boundary.external_secret_manager`        | unknown        | unknown        | indirect       | not_applicable | unknown        | unknown                |
| `boundary.file_cache`                     | unknown        | unknown        | not_applicable | not_applicable | unknown        | unknown                |
| `boundary.file_sessions`                  | unknown        | unknown        | indirect       | not_applicable | unknown        | unknown                |
| `boundary.laravel_migration_repository`   | unknown        | unknown        | not_applicable | not_applicable | unknown        | unknown                |
| `boundary.object_storage`                 | unknown        | unknown        | not_applicable | explicit       | unknown        | unknown                |
| `boundary.private_filesystem`             | unknown        | unknown        | not_applicable | explicit       | unknown        | unknown                |
| `boundary.profile_images`                 | unknown        | unknown        | indirect       | explicit       | unknown        | unknown                |
| `boundary.public_filesystem`              | unknown        | unknown        | not_applicable | explicit       | unknown        | unknown                |
| `boundary.redis_cache`                    | unknown        | unknown        | not_applicable | not_applicable | unknown        | unknown                |
| `boundary.redis_queue`                    | unknown        | unknown        | not_applicable | not_applicable | unknown        | unknown                |
| `cache`                                   | not_applicable | not_applicable | not_applicable | not_applicable | not_applicable | not_applicable         |
| `cache_locks`                             | not_applicable | not_applicable | not_applicable | not_applicable | not_applicable | not_applicable         |
| `central_error_logs`                      | explicit       | absent         | explicit       | absent         | absent         | absent                 |
| `concept.access_group`                    | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.access_group_member`             | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.access_policy`                   | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.access_policy_approval`          | unknown        | unknown        | explicit       | unknown        | explicit       | not_applicable         |
| `concept.access_policy_constraint`        | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.access_review_campaign`          | unknown        | unknown        | explicit       | unknown        | explicit       | not_applicable         |
| `concept.access_review_decision`          | unknown        | unknown        | explicit       | unknown        | explicit       | not_applicable         |
| `concept.access_review_item`              | unknown        | unknown        | explicit       | unknown        | explicit       | not_applicable         |
| `concept.actor_attribution_envelope`      | unknown        | unknown        | explicit       | unknown        | explicit       | not_applicable         |
| `concept.api_token`                       | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.api_token_event`                 | unknown        | unknown        | explicit       | unknown        | explicit       | not_applicable         |
| `concept.application_principal_reference` | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.assurance_evidence`              | unknown        | unknown        | explicit       | unknown        | explicit       | not_applicable         |
| `concept.audit_event`                     | unknown        | unknown        | unknown        | unknown        | explicit       | unknown                |
| `concept.audit_event_change`              | unknown        | unknown        | unknown        | unknown        | explicit       | unknown                |
| `concept.backup_health_record`            | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.consent_record`                  | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.credential_material`             | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.credential_metadata`             | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.credential_reference`            | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.data_asset_governance_record`    | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.data_domain_registry`            | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.data_quality_issue`              | unknown        | unknown        | unknown        | unknown        | explicit       | not_applicable         |
| `concept.data_subject_registry`           | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.deletion_erasure_evidence`       | unknown        | unknown        | unknown        | unknown        | explicit       | not_applicable         |
| `concept.elevated_access_session`         | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.evidence_chain_of_custody_entry` | unknown        | unknown        | unknown        | unknown        | explicit       | not_applicable         |
| `concept.evidence_package`                | unknown        | unknown        | unknown        | unknown        | explicit       | not_applicable         |
| `concept.evidence_package_item`           | unknown        | unknown        | unknown        | unknown        | explicit       | not_applicable         |
| `concept.export_artifact_metadata`        | unknown        | unknown        | unknown        | unknown        | unknown        | unknown                |
| `concept.export_request`                  | unknown        | unknown        | unknown        | unknown        | explicit       | unknown                |
| `concept.health_check_result`             | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.incident_case`                   | unknown        | unknown        | unknown        | unknown        | explicit       | unknown                |
| `concept.legal_hold`                      | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.machine_identity`                | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.network_context`                 | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.network_identity`                | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.non_human_identity_principal`    | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.privacy_request`                 | unknown        | unknown        | unknown        | unknown        | explicit       | unknown                |
| `concept.privacy_request_item`            | unknown        | unknown        | unknown        | unknown        | explicit       | unknown                |
| `concept.processing_purpose`              | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.retention_policy_registry`       | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.risk_acceptance`                 | unknown        | unknown        | unknown        | unknown        | explicit       | not_applicable         |
| `concept.secret_metadata`                 | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.secret_rotation_event`           | unknown        | unknown        | unknown        | unknown        | explicit       | not_applicable         |
| `concept.service_account_table`           | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.service_account_users_type`      | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.target_tenant_instance_scope`    | unknown        | unknown        | unknown        | unknown        | unknown        | unknown                |
| `concept.user_lifecycle_metadata`         | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.vulnerability_asset`             | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.vulnerability_finding`           | unknown        | unknown        | unknown        | unknown        | unknown        | not_applicable         |
| `concept.webhook_delivery`                | unknown        | unknown        | explicit       | unknown        | explicit       | not_applicable         |
| `concept.webhook_endpoint`                | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.webhook_processing_attempt`      | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `concept.workload_identity_reference`     | unknown        | unknown        | explicit       | unknown        | unknown        | not_applicable         |
| `failed_jobs`                             | not_applicable | not_applicable | not_applicable | not_applicable | not_applicable | not_applicable         |
| `job_batches`                             | not_applicable | not_applicable | not_applicable | not_applicable | not_applicable | not_applicable         |
| `jobs`                                    | not_applicable | not_applicable | not_applicable | not_applicable | not_applicable | not_applicable         |
| `mfa_recovery_codes`                      | absent         | absent         | explicit       | absent         | absent         | absent                 |
| `model_has_permissions`                   | absent         | absent         | absent         | explicit       | absent         | absent                 |
| `model_has_roles`                         | absent         | absent         | absent         | explicit       | absent         | absent                 |
| `module_registry_entries`                 | absent         | absent         | absent         | absent         | absent         | absent                 |
| `notification_registry_entries`           | absent         | absent         | absent         | absent         | absent         | absent                 |
| `notifications`                           | absent         | absent         | absent         | explicit       | absent         | absent                 |
| `password_reset_tokens`                   | not_applicable | not_applicable | not_applicable | not_applicable | not_applicable | not_applicable         |
| `permission_registry_entries`             | absent         | absent         | absent         | absent         | absent         | absent                 |
| `permissions`                             | absent         | absent         | absent         | absent         | absent         | absent                 |
| `platform_audit_logs`                     | absent         | absent         | explicit       | explicit       | explicit       | absent                 |
| `preference_registry_entries`             | absent         | absent         | absent         | absent         | absent         | absent                 |
| `role_has_permissions`                    | absent         | absent         | absent         | absent         | absent         | absent                 |
| `role_metadata`                           | absent         | absent         | explicit       | absent         | explicit       | absent                 |
| `roles`                                   | absent         | absent         | absent         | absent         | absent         | absent                 |
| `security_requirement_groups`             | absent         | absent         | absent         | absent         | absent         | absent                 |
| `security_requirements`                   | absent         | absent         | explicit       | absent         | explicit       | absent                 |
| `sessions`                                | absent         | absent         | explicit       | absent         | absent         | absent                 |
| `settings`                                | absent         | absent         | absent         | absent         | explicit       | absent                 |
| `settings_registry_entries`               | absent         | absent         | absent         | absent         | absent         | absent                 |
| `setup_registry_entries`                  | absent         | absent         | absent         | absent         | absent         | absent                 |
| `user_contact_emails`                     | absent         | absent         | explicit       | absent         | absent         | absent                 |
| `user_dashboard_layouts`                  | absent         | absent         | explicit       | absent         | absent         | absent                 |
| `user_mfa_methods`                        | absent         | absent         | explicit       | absent         | absent         | absent                 |
| `user_mfa_policies`                       | absent         | absent         | explicit       | absent         | explicit       | absent                 |
| `user_notification_preferences`           | absent         | absent         | explicit       | absent         | absent         | absent                 |
| `users`                                   | absent         | absent         | indirect       | absent         | absent         | absent                 |

<!-- PERSISTENT-DATA-INVENTORY:SCOPE-FINDINGS:END -->

## 13. Classification, Retention, Erasure, Export, And Audit Findings

<!-- PERSISTENT-DATA-INVENTORY:GOVERNANCE:START -->

- `boundary.backup_artifacts`: classification — The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.database_cache`: classification — The boundary classification depends on its consumers. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.database_connection_target`: classification — The boundary classification depends on its consumers. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.database_queue`: classification — The boundary classification depends on its consumers. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.database_sessions`: classification — The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.export_artifacts`: classification — The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.external_secret_manager`: classification — The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.file_cache`: classification — The boundary classification depends on its consumers. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.file_sessions`: classification — The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.laravel_migration_repository`: classification — The boundary classification depends on its consumers. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.object_storage`: classification — The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.private_filesystem`: classification — The boundary classification depends on its consumers. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.profile_images`: classification — The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.public_filesystem`: classification — The boundary classification depends on its consumers. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.redis_cache`: classification — The boundary classification depends on its consumers. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `boundary.redis_queue`: classification — The boundary classification depends on its consumers. Retention/erasure — Retention and erasure behavior is incomplete or consumer-specific. Audit — Boundary use may require Audit evidence; configuration alone does not prove it.
- `cache`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `cache_locks`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `central_error_logs`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes set_null; retention and legal hold remain undocumented. Audit — No table-specific Audit requirement is established by migration source.
- `concept.access_group`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.access_group_member`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.access_policy`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.access_policy_approval`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.access_policy_constraint`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.access_review_campaign`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.access_review_decision`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.access_review_item`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.actor_attribution_envelope`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.api_token`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.api_token_event`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.application_principal_reference`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.assurance_evidence`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.audit_event`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.audit_event_change`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.backup_health_record`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.consent_record`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.credential_material`: classification — Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.credential_metadata`: classification — Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.credential_reference`: classification — Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.data_asset_governance_record`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.data_domain_registry`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.data_quality_issue`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.data_subject_registry`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.deletion_erasure_evidence`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.elevated_access_session`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.evidence_chain_of_custody_entry`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.evidence_package`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.evidence_package_item`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.export_artifact_metadata`: classification — Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.export_request`: classification — Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.health_check_result`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.incident_case`: classification — Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.legal_hold`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.machine_identity`: classification — Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.network_context`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.network_identity`: classification — Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.non_human_identity_principal`: classification — Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.privacy_request`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.privacy_request_item`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.processing_purpose`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.retention_policy_registry`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.risk_acceptance`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.secret_metadata`: classification — Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.secret_rotation_event`: classification — Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.service_account_table`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.service_account_users_type`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.target_tenant_instance_scope`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.user_lifecycle_metadata`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.vulnerability_asset`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.vulnerability_finding`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.webhook_delivery`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.webhook_endpoint`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.webhook_processing_attempt`: classification — Classification remains a target data-governance question. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `concept.workload_identity_reference`: classification — Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive. Retention/erasure — Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan. Audit — Accountable lifecycle and Audit integration remain target implementation questions.
- `failed_jobs`: classification — Sensitive or credential/session-material field names are present; no values were collected. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `job_batches`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `jobs`: classification — Sensitive or credential/session-material field names are present; no values were collected. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `mfa_recovery_codes`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented. Audit — No table-specific Audit requirement is established by migration source.
- `model_has_permissions`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented. Audit — No table-specific Audit requirement is established by migration source.
- `model_has_roles`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented. Audit — No table-specific Audit requirement is established by migration source.
- `module_registry_entries`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `notification_registry_entries`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `notifications`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `password_reset_tokens`: classification — Sensitive or credential/session-material field names are present; no values were collected. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `permission_registry_entries`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes set_null; retention and legal hold remain undocumented. Audit — No table-specific Audit requirement is established by migration source.
- `permissions`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `platform_audit_logs`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes set_null; retention and legal hold remain undocumented. Audit — This table is the current Audit event store.
- `preference_registry_entries`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `role_has_permissions`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented. Audit — No table-specific Audit requirement is established by migration source.
- `role_metadata`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes cascade, set_null; retention and legal hold remain undocumented. Audit — Actor-related columns provide partial accountable-change evidence.
- `roles`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `security_requirement_groups`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `security_requirements`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes cascade, set_null; retention and legal hold remain undocumented. Audit — Actor-related columns provide partial accountable-change evidence.
- `sessions`: classification — Sensitive or credential/session-material field names are present; no values were collected. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `settings`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes set_null; retention and legal hold remain undocumented. Audit — Actor-related columns provide partial accountable-change evidence.
- `settings_registry_entries`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `setup_registry_entries`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.
- `user_contact_emails`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented. Audit — No table-specific Audit requirement is established by migration source.
- `user_dashboard_layouts`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented. Audit — No table-specific Audit requirement is established by migration source.
- `user_mfa_methods`: classification — Sensitive or credential/session-material field names are present; no values were collected. Retention/erasure — Foreign-key deletion behavior includes cascade, set_null; retention and legal hold remain undocumented. Audit — No table-specific Audit requirement is established by migration source.
- `user_mfa_policies`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes cascade, set_null; retention and legal hold remain undocumented. Audit — Actor-related columns provide partial accountable-change evidence.
- `user_notification_preferences`: classification — No canonical per-table data classification is established by migration source. Retention/erasure — Foreign-key deletion behavior includes cascade; retention and legal hold remain undocumented. Audit — No table-specific Audit requirement is established by migration source.
- `users`: classification — Sensitive or credential/session-material field names are present; no values were collected. Retention/erasure — Retention, erasure, and legal-hold behavior are not established by migration source. Audit — No table-specific Audit requirement is established by migration source.

<!-- PERSISTENT-DATA-INVENTORY:GOVERNANCE:END -->

## 14. Contradictions And Investigations

<!-- PERSISTENT-DATA-INVENTORY:CONTRADICTIONS:START -->

- `boundary.backup_artifacts` / `lifecycle_or_deletion_unclear`: Lifecycle and deletion behavior is not fully established for this boundary. (docs/07-planning/02-core-capabilities/audit-monitoring-response/backup-recovery-planning.md:67)
- `boundary.backup_artifacts` / `retention_or_erasure_missing`: Retention, erasure, and legal-hold evidence is incomplete for this boundary. (docs/07-planning/02-core-capabilities/audit-monitoring-response/backup-recovery-planning.md:67)
- `boundary.database_connection_target` / `database_target_conflict`: Canonical PostgreSQL direction and the example environment differ from the SQLite fallback in runtime configuration. (config/database.php:20)
- `boundary.export_artifacts` / `lifecycle_or_deletion_unclear`: Lifecycle and deletion behavior is not fully established for this boundary. (docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md:7)
- `boundary.export_artifacts` / `retention_or_erasure_missing`: Retention, erasure, and legal-hold evidence is incomplete for this boundary. (docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md:7)
- `boundary.external_secret_manager` / `lifecycle_or_deletion_unclear`: Lifecycle and deletion behavior is not fully established for this boundary. (docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md:598)
- `boundary.external_secret_manager` / `retention_or_erasure_missing`: Retention, erasure, and legal-hold evidence is incomplete for this boundary. (docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md:598)
- `boundary.profile_images` / `lifecycle_or_deletion_unclear`: Lifecycle and deletion behavior is not fully established for this boundary. (docs/07-planning/02-core-capabilities/auth-identity-access/users-module-implementation-planning.md:297)
- `boundary.profile_images` / `retention_or_erasure_missing`: Retention, erasure, and legal-hold evidence is incomplete for this boundary. (docs/07-planning/02-core-capabilities/auth-identity-access/users-module-implementation-planning.md:297)
- `boundary.public_filesystem` / `sensitive_storage_risk`: Public storage is material to protected-file review even though no sensitive contents were inspected. (config/filesystems.php:41)
- `cache` / `contract_missing`: No per-table contract exists for cache. (database/migrations/0001_01_01_000001_create_cache_table.php:11)
- `cache_locks` / `contract_missing`: No per-table contract exists for cache_locks. (database/migrations/0001_01_01_000001_create_cache_table.php:17)
- `concept.access_group` / `planning_implementation_overlap`: Active planned persistence overlaps current implemented storage without selecting the target model. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:188)
- `concept.access_group` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:188)
- `concept.access_group_member` / `planning_implementation_overlap`: Active planned persistence overlaps current implemented storage without selecting the target model. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:189)
- `concept.access_group_member` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:189)
- `concept.access_policy` / `planning_implementation_overlap`: Active planned persistence overlaps current implemented storage without selecting the target model. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:190)
- `concept.access_policy` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:190)
- `concept.access_policy_approval` / `planning_implementation_overlap`: Active planned persistence overlaps current implemented storage without selecting the target model. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:192)
- `concept.access_policy_approval` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:192)
- `concept.access_policy_constraint` / `planning_implementation_overlap`: Active planned persistence overlaps current implemented storage without selecting the target model. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:191)
- `concept.access_policy_constraint` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:191)
- `concept.access_review_campaign` / `planning_implementation_overlap`: Active planned persistence overlaps current implemented storage without selecting the target model. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:194)
- `concept.access_review_campaign` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:194)
- `concept.access_review_decision` / `planning_implementation_overlap`: Active planned persistence overlaps current implemented storage without selecting the target model. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:196)
- `concept.access_review_decision` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:196)
- `concept.access_review_item` / `planning_implementation_overlap`: Active planned persistence overlaps current implemented storage without selecting the target model. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:195)
- `concept.access_review_item` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:195)
- `concept.actor_attribution_envelope` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md:22)
- `concept.api_token` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:138)
- `concept.api_token_event` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:161)
- `concept.application_principal_reference` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:72)
- `concept.assurance_evidence` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:37)
- `concept.audit_event` / `planning_implementation_overlap`: Active planned persistence overlaps current implemented storage without selecting the target model. (docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md:423)
- `concept.audit_event` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md:423)
- `concept.audit_event_change` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md:424)
- `concept.backup_health_record` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/audit-monitoring-response/backup-recovery-planning.md:140)
- `concept.consent_record` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:303)
- `concept.credential_material` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md:78)
- `concept.credential_metadata` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:98)
- `concept.credential_reference` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md:167)
- `concept.data_asset_governance_record` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:231)
- `concept.data_domain_registry` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:193)
- `concept.data_quality_issue` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:411)
- `concept.data_subject_registry` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:457)
- `concept.deletion_erasure_evidence` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:33)
- `concept.elevated_access_session` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md:193)
- `concept.evidence_chain_of_custody_entry` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/audit-monitoring-response/digital-forensics-readiness-planning.md:297)
- `concept.evidence_package` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/audit-monitoring-response/digital-forensics-readiness-planning.md:256)
- `concept.evidence_package_item` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/audit-monitoring-response/digital-forensics-readiness-planning.md:279)
- `concept.export_artifact_metadata` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md:383)
- `concept.export_request` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md:91)
- `concept.health_check_result` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md:475)
- `concept.incident_case` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/audit-monitoring-response/incident-response-planning.md:183)
- `concept.legal_hold` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md:383)
- `concept.machine_identity` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:45)
- `concept.network_context` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:123)
- `concept.network_identity` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:121)
- `concept.non_human_identity_principal` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:45)
- `concept.privacy_request` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:344)
- `concept.privacy_request_item` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:361)
- `concept.processing_purpose` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:263)
- `concept.retention_policy_registry` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md:50)
- `concept.risk_acceptance` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/security/vulnerability-management-core-planning.md:294)
- `concept.secret_metadata` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md:21)
- `concept.secret_rotation_event` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md:543)
- `concept.service_account_table` / `duplicate_persistent_concept`: Active planning retains materially different Service Account storage alternatives. (docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:116)
- `concept.service_account_table` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:116)
- `concept.service_account_users_type` / `duplicate_persistent_concept`: Active planning retains materially different Service Account storage alternatives. (docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:99)
- `concept.service_account_users_type` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:99)
- `concept.target_tenant_instance_scope` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:84)
- `concept.user_lifecycle_metadata` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/users-module-implementation-planning.md:291)
- `concept.vulnerability_asset` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/security/vulnerability-management-core-planning.md:254)
- `concept.vulnerability_finding` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/security/vulnerability-management-core-planning.md:269)
- `concept.webhook_delivery` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:424)
- `concept.webhook_endpoint` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:405)
- `concept.webhook_processing_attempt` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md:451)
- `concept.workload_identity_reference` / `contract_missing`: No implemented per-table contract applies to this planned concept. (docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md:68)
- `failed_jobs` / `contract_missing`: No per-table contract exists for failed_jobs. (database/migrations/0001_01_01_000002_create_jobs_table.php:34)
- `job_batches` / `contract_missing`: No per-table contract exists for job_batches. (database/migrations/0001_01_01_000002_create_jobs_table.php:21)
- `jobs` / `contract_missing`: No per-table contract exists for jobs. (database/migrations/0001_01_01_000002_create_jobs_table.php:11)
- `mfa_recovery_codes` / `contract_missing`: No per-table contract exists for mfa_recovery_codes. (database/migrations/2026_07_01_000001_create_mfa_tables.php:41)
- `model_has_permissions` / `contract_missing`: No per-table contract exists for model_has_permissions. (database/migrations/2026_04_09_000001_create_permission_tables.php:50)
- `model_has_permissions` / `compatibility_unresolved`: The table uses configuration-driven package-compatible naming; removal or replacement timing is not selected. (database/migrations/2026_04_09_000001_create_permission_tables.php:50)
- `model_has_roles` / `contract_missing`: No per-table contract exists for model_has_roles. (database/migrations/2026_04_09_000001_create_permission_tables.php:79)
- `model_has_roles` / `compatibility_unresolved`: The table uses configuration-driven package-compatible naming; removal or replacement timing is not selected. (database/migrations/2026_04_09_000001_create_permission_tables.php:79)
- `module_registry_entries` / `implemented_table_unclaimed`: module_registry_entries is created by a registered migration but is absent from ownedTables declarations. (database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php:11)
- `notification_registry_entries` / `implemented_table_unclaimed`: notification_registry_entries is created by a registered migration but is absent from ownedTables declarations. (database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php:29)
- `password_reset_tokens` / `contract_missing`: No per-table contract exists for password_reset_tokens. (database/migrations/0001_01_01_000000_create_users_table.php:21)
- `permission_registry_entries` / `contract_missing`: No per-table contract exists for permission_registry_entries. (database/migrations/2026_07_07_000001_create_roles_registry_metadata_tables.php:11)
- `permissions` / `contract_missing`: No per-table contract exists for permissions. (database/migrations/2026_04_09_000001_create_permission_tables.php:22)
- `permissions` / `compatibility_unresolved`: The table uses configuration-driven package-compatible naming; removal or replacement timing is not selected. (database/migrations/2026_04_09_000001_create_permission_tables.php:22)
- `platform_audit_logs` / `scope_missing`: Current Audit columns do not explicitly separate acting Instance from target Tenant/Instance scope. (database/migrations/2026_04_08_000001_create_platform_audit_logs_table.php:11)
- `preference_registry_entries` / `implemented_table_unclaimed`: preference_registry_entries is created by a registered migration but is absent from ownedTables declarations. (database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php:99)
- `role_has_permissions` / `contract_missing`: No per-table contract exists for role_has_permissions. (database/migrations/2026_04_09_000001_create_permission_tables.php:108)
- `role_has_permissions` / `compatibility_unresolved`: The table uses configuration-driven package-compatible naming; removal or replacement timing is not selected. (database/migrations/2026_04_09_000001_create_permission_tables.php:108)
- `role_metadata` / `contract_missing`: No per-table contract exists for role_metadata. (database/migrations/2026_07_07_000001_create_roles_registry_metadata_tables.php:30)
- `roles` / `contract_missing`: No per-table contract exists for roles. (database/migrations/2026_04_09_000001_create_permission_tables.php:31)
- `roles` / `compatibility_unresolved`: The table uses configuration-driven package-compatible naming; removal or replacement timing is not selected. (database/migrations/2026_04_09_000001_create_permission_tables.php:31)
- `security_requirement_groups` / `contract_missing`: No per-table contract exists for security_requirement_groups. (database/migrations/2026_07_01_000003_create_security_requirements_tables.php:11)
- `security_requirements` / `contract_missing`: No per-table contract exists for security_requirements. (database/migrations/2026_07_01_000003_create_security_requirements_tables.php:22)
- `sessions` / `contract_missing`: No per-table contract exists for sessions. (database/migrations/0001_01_01_000000_create_users_table.php:27)
- `sessions` / `model_relationship_unenforced`: sessions.user_id is indexed but the migration does not declare a database foreign key. (database/migrations/0001_01_01_000000_create_users_table.php:27)
- `settings_registry_entries` / `implemented_table_unclaimed`: settings_registry_entries is created by a registered migration but is absent from ownedTables declarations. (database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php:51)
- `setup_registry_entries` / `implemented_table_unclaimed`: setup_registry_entries is created by a registered migration but is absent from ownedTables declarations. (database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php:75)
- `user_contact_emails` / `implemented_table_unclaimed`: user_contact_emails is created by a registered migration but is absent from ownedTables declarations. (database/migrations/2026_07_07_000002_create_user_contact_emails_table.php:11)
- `user_mfa_methods` / `contract_missing`: No per-table contract exists for user_mfa_methods. (database/migrations/2026_07_01_000001_create_mfa_tables.php:11)
- `user_mfa_policies` / `contract_missing`: No per-table contract exists for user_mfa_policies. (database/migrations/2026_07_01_000001_create_mfa_tables.php:28)
- `users` / `contract_missing`: No per-table contract exists for users. (database/migrations/0001_01_01_000000_create_users_table.php:11)
- `users` / `scope_missing`: The User Account row has no explicit Tenant or Instance key. (database/migrations/0001_01_01_000000_create_users_table.php:11)
- `users` / `planning_implementation_overlap`: Account, identity, profile, staff, and preference concerns are currently combined while active planning evaluates separation. (database/migrations/0001_01_01_000000_create_users_table.php:11)

<!-- PERSISTENT-DATA-INVENTORY:CONTRADICTIONS:END -->

## 15. Goal 06 Target Questions

<!-- PERSISTENT-DATA-INVENTORY:TARGET-QUESTIONS:START -->

- `boundary.backup_artifacts`: Which owner, retention, erasure, access, and Audit controls govern backup artifacts?
- `boundary.database_connection_target`: Which owner, retention, erasure, access, and Audit controls govern database connection target?
- `boundary.export_artifacts`: Which owner, retention, erasure, access, and Audit controls govern export artifacts?
- `boundary.external_secret_manager`: Which owner, retention, erasure, access, and Audit controls govern external secret manager?
- `boundary.profile_images`: Which owner, retention, erasure, access, and Audit controls govern profile images?
- `boundary.public_filesystem`: Which owner, retention, erasure, access, and Audit controls govern public filesystem?
- `cache`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded cache evidence gaps?
- `cache_locks`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded cache_locks evidence gaps?
- `concept.access_group`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access group?
- `concept.access_group_member`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access group member?
- `concept.access_policy`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access policy?
- `concept.access_policy_approval`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access policy approval?
- `concept.access_policy_constraint`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access policy constraint?
- `concept.access_review_campaign`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access review campaign?
- `concept.access_review_decision`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access review decision?
- `concept.access_review_item`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement access review item?
- `concept.actor_attribution_envelope`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement actor attribution envelope?
- `concept.api_token`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement api token?
- `concept.api_token_event`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement api token event?
- `concept.application_principal_reference`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement application principal reference?
- `concept.assurance_evidence`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement assurance evidence?
- `concept.audit_event`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement audit event?
- `concept.audit_event_change`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement audit event change?
- `concept.backup_health_record`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement backup health record?
- `concept.consent_record`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement consent record?
- `concept.credential_material`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement credential material?
- `concept.credential_metadata`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement credential metadata?
- `concept.credential_reference`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement credential reference?
- `concept.data_asset_governance_record`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement data asset governance record?
- `concept.data_domain_registry`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement data domain registry?
- `concept.data_quality_issue`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement data quality issue?
- `concept.data_subject_registry`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement data subject registry?
- `concept.deletion_erasure_evidence`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement deletion erasure evidence?
- `concept.elevated_access_session`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement elevated access session?
- `concept.evidence_chain_of_custody_entry`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement evidence chain of custody entry?
- `concept.evidence_package`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement evidence package?
- `concept.evidence_package_item`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement evidence package item?
- `concept.export_artifact_metadata`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement export artifact metadata?
- `concept.export_request`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement export request?
- `concept.health_check_result`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement health check result?
- `concept.incident_case`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement incident case?
- `concept.legal_hold`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement legal hold?
- `concept.machine_identity`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement machine identity?
- `concept.network_context`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement network context?
- `concept.network_identity`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement network identity?
- `concept.non_human_identity_principal`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement non human identity principal?
- `concept.privacy_request`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement privacy request?
- `concept.privacy_request_item`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement privacy request item?
- `concept.processing_purpose`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement processing purpose?
- `concept.retention_policy_registry`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement retention policy registry?
- `concept.risk_acceptance`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement risk acceptance?
- `concept.secret_metadata`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement secret metadata?
- `concept.secret_rotation_event`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement secret rotation event?
- `concept.service_account_table`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement service account table?
- `concept.service_account_users_type`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement service account users type?
- `concept.target_tenant_instance_scope`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement target tenant instance scope?
- `concept.user_lifecycle_metadata`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement user lifecycle metadata?
- `concept.vulnerability_asset`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement vulnerability asset?
- `concept.vulnerability_finding`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement vulnerability finding?
- `concept.webhook_delivery`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement webhook delivery?
- `concept.webhook_endpoint`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement webhook endpoint?
- `concept.webhook_processing_attempt`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement webhook processing attempt?
- `concept.workload_identity_reference`: What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement workload identity reference?
- `failed_jobs`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded failed_jobs evidence gaps?
- `job_batches`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded job_batches evidence gaps?
- `jobs`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded jobs evidence gaps?
- `mfa_recovery_codes`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded mfa_recovery_codes evidence gaps?
- `module_registry_entries`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded module_registry_entries evidence gaps?
- `notification_registry_entries`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded notification_registry_entries evidence gaps?
- `password_reset_tokens`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded password_reset_tokens evidence gaps?
- `permission_registry_entries`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded permission_registry_entries evidence gaps?
- `platform_audit_logs`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded platform_audit_logs evidence gaps?
- `preference_registry_entries`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded preference_registry_entries evidence gaps?
- `role_metadata`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded role_metadata evidence gaps?
- `security_requirement_groups`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded security_requirement_groups evidence gaps?
- `security_requirements`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded security_requirements evidence gaps?
- `sessions`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded sessions evidence gaps?
- `settings_registry_entries`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded settings_registry_entries evidence gaps?
- `setup_registry_entries`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded setup_registry_entries evidence gaps?
- `user_contact_emails`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded user_contact_emails evidence gaps?
- `user_mfa_methods`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded user_mfa_methods evidence gaps?
- `user_mfa_policies`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded user_mfa_policies evidence gaps?
- `users`: Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded users evidence gaps?

<!-- PERSISTENT-DATA-INVENTORY:TARGET-QUESTIONS:END -->

## 16. Verification And Review

<!-- PERSISTENT-DATA-INVENTORY:VERIFICATION:START -->

- Baseline consistency: `1d103f5fa47aab8c8adfba8ea134dd29540426fe` across ledger, raw evidence, classifications, and this projection.
- Migration coverage: 22 files, 39 up operations, 39 down operations.
- Material review: 103/103 reviewed; 0 pending.
- Deterministic commands:
    - `npm run inventory:m0:persistent-data:collect -- --baseline 1d103f5fa47aab8c8adfba8ea134dd29540426fe --with-runtime-discovery`
    - `npm run inventory:m0:persistent-data:collect -- --baseline 1d103f5fa47aab8c8adfba8ea134dd29540426fe --static-only`
    - `npm run inventory:m0:persistent-data:render -- --baseline 1d103f5fa47aab8c8adfba8ea134dd29540426fe`
    - `npm run lint:m0:persistent-data-inventory -- --baseline 1d103f5fa47aab8c8adfba8ea134dd29540426fe --fixtures`
- Runtime discovery:
- `php artisan migrate:status --no-interaction --no-ansi`: exit 1; Command exited with status 1.
- `php artisan config:show permission --no-ansi`: exit 0
- Fixture, formatting, documentation guardrail, and final diff results are command evidence in the pull request; rendering does not self-certify later commands.
- Repository-owner Architecture, Security, Data Governance, database ownership, ledger, chain, contract, and contradiction acceptance remains required.

<!-- PERSISTENT-DATA-INVENTORY:VERIFICATION:END -->
