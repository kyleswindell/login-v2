<!--
DOC-META
title: M0 Persistent Data Current Implementation Snapshot
doc_type: planning
status: draft
owner: core
canonical: true
canonical_path: docs/07-planning/00-overview/m0-persistent-data-current-state-inventory.md
parent: docs/07-planning/index.md
template: docs/09-reference/templates/docs/_planning.md
summary: Provides a current implementation snapshot of source-controlled persistence surfaces at the pinned M0 baseline for rewrite planning; it is non-authoritative for migration semantics, does not prove deployed schema state, is not the Goal 06 target model, and has known completeness limitations.
-->

# M0 Persistent Data Current Implementation Snapshot

> **Current implementation snapshot**
>
> - non-authoritative for migration semantics
> - not proof of deployed schema state
> - not the Goal 06 target data model
> - known parser and completeness limitations apply
> - records source-controlled implementation evidence only at the pinned baseline

Parent: [Planning Index](../index.md)

## 1. Purpose And Limitations

This document preserves a bounded current-state planning aid for the backend rewrite. It identifies source-controlled table names, planned persistent concepts, non-table persistence boundaries, ownership interpretations, contract gaps, contradictions, and questions that Goal 06 must resolve.

The snapshot is useful for finding relevant source material and avoiding rediscovery. It does not define accepted schema, migration order, deployed state, data ownership, retention policy, or target design. Direct migrations, configuration, active canonical planning, accepted decisions, and database contracts remain the appropriate sources for those concerns.

Issue #29 inventories broader repository and runtime surfaces and intentionally leaves detailed persistence discovery to issue #31. This document supplies that bounded persistence view without retaining the one-off generator, generated evidence, or review machinery used during discovery.

## 2. Snapshot Provenance

- Owning issue: #31
- Related repository inventory: #29
- Parent goal: #18
- Immutable evidence baseline: `1d103f5fa47aab8c8adfba8ea134dd29540426fe`
- Baseline commit time: `2026-07-10T22:27:59-04:00`
- Narrowing source: issue #31 branch head `9cc1843649ba3efec93ac2ea1146bee88a16a88a`
- Evidence boundary: source-controlled migrations, configuration, database contracts, and active planning present at the immutable baseline

The original discovery process used a custom parser. Because its operation-level interpretation and generated-artifact coherence were not reliable enough to retain, this snapshot intentionally records identifiers and direct source paths only. It omits inferred final columns, keys, indexes, foreign keys, operation conditions, rollback behavior, and migration-chain completeness.

## 3. Implemented And Compatibility Storage Summary

The labels below are planning interpretations at the pinned baseline. `implemented` means a source-controlled migration names the storage surface. `compatibility` identifies framework/package-compatible access tables whose long-term disposition remains unresolved. Owner labels are routing interpretations, not accepted Goal 06 ownership decisions.

- `cache` — implemented; infrastructure; source: `database/migrations/0001_01_01_000001_create_cache_table.php`; table contract: missing; gaps: `contract_missing`.
- `cache_locks` — implemented; infrastructure; source: `database/migrations/0001_01_01_000001_create_cache_table.php`; table contract: missing; gaps: `contract_missing`.
- `central_error_logs` — implemented; Core Monitoring; source: `database/migrations/2026_04_08_000002_create_central_error_logs_table.php`; contract: `docs/06-database/tables/central_error_logs.md`; gaps: none recorded.
- `failed_jobs` — implemented; infrastructure; source: `database/migrations/0001_01_01_000002_create_jobs_table.php`; table contract: missing; gaps: `contract_missing`.
- `job_batches` — implemented; infrastructure; source: `database/migrations/0001_01_01_000002_create_jobs_table.php`; table contract: missing; gaps: `contract_missing`.
- `jobs` — implemented; infrastructure; source: `database/migrations/0001_01_01_000002_create_jobs_table.php`; table contract: missing; gaps: `contract_missing`.
- `mfa_recovery_codes` — implemented; Core Auth; source: `database/migrations/2026_07_01_000001_create_mfa_tables.php`; table contract: missing; gaps: `contract_missing`.
- `model_has_permissions` — compatibility; Core Access; source: `database/migrations/2026_04_09_000001_create_permission_tables.php`; table contract: missing; gaps: `contract_missing`, `compatibility_unresolved`.
- `model_has_roles` — compatibility; Core Access; source: `database/migrations/2026_04_09_000001_create_permission_tables.php`; table contract: missing; gaps: `contract_missing`, `compatibility_unresolved`.
- `module_registry_entries` — implemented; Core Modules; source: `database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php`; contract: `docs/06-database/tables/module_registry_entries.md`; gaps: `implemented_table_unclaimed`.
- `notification_registry_entries` — implemented; Core Notifications; source: `database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php`; contract: `docs/06-database/tables/notification_registry_entries.md`; gaps: `implemented_table_unclaimed`.
- `notifications` — implemented; Core Notifications; sources: `database/migrations/2026_04_09_000004_create_notifications_table.php`, `database/migrations/2026_07_08_000002_add_type_key_to_notifications_table.php`; contract: `docs/06-database/tables/notifications.md`; gaps: none recorded.
- `password_reset_tokens` — implemented; Core Auth; source: `database/migrations/0001_01_01_000000_create_users_table.php`; table contract: missing; gaps: `contract_missing`.
- `permission_registry_entries` — implemented; Core Access; source: `database/migrations/2026_07_07_000001_create_roles_registry_metadata_tables.php`; table contract: missing; gaps: `contract_missing`.
- `permissions` — compatibility; Core Access; source: `database/migrations/2026_04_09_000001_create_permission_tables.php`; table contract: missing; gaps: `contract_missing`, `compatibility_unresolved`.
- `platform_audit_logs` — implemented; Core Audit; source: `database/migrations/2026_04_08_000001_create_platform_audit_logs_table.php`; contract: `docs/06-database/tables/platform_audit_logs.md`; gaps: `scope_missing`.
- `preference_registry_entries` — implemented; Core Preferences; source: `database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php`; contract: `docs/06-database/tables/preference_registry_entries.md`; gaps: `implemented_table_unclaimed`.
- `role_has_permissions` — compatibility; Core Access; source: `database/migrations/2026_04_09_000001_create_permission_tables.php`; table contract: missing; gaps: `contract_missing`, `compatibility_unresolved`.
- `role_metadata` — implemented; Core Access; source: `database/migrations/2026_07_07_000001_create_roles_registry_metadata_tables.php`; table contract: missing; gaps: `contract_missing`.
- `roles` — compatibility; Core Access; source: `database/migrations/2026_04_09_000001_create_permission_tables.php`; table contract: missing; gaps: `contract_missing`, `compatibility_unresolved`.
- `security_requirement_groups` — implemented; Core Security; source: `database/migrations/2026_07_01_000003_create_security_requirements_tables.php`; table contract: missing; gaps: `contract_missing`.
- `security_requirements` — implemented; Core Security; source: `database/migrations/2026_07_01_000003_create_security_requirements_tables.php`; table contract: missing; gaps: `contract_missing`.
- `sessions` — implemented; Core Auth; source: `database/migrations/0001_01_01_000000_create_users_table.php`; table contract: missing; gaps: `contract_missing`, `model_relationship_unenforced`.
- `settings` — implemented; Core Settings; source: `database/migrations/2026_04_09_000003_create_settings_table.php`; contract: `docs/06-database/tables/settings.md`; gaps: none recorded.
- `settings_registry_entries` — implemented; Core Settings; source: `database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php`; contract: `docs/06-database/tables/settings_registry_entries.md`; gaps: `implemented_table_unclaimed`.
- `setup_registry_entries` — implemented; Core Setup; source: `database/migrations/2026_07_08_000003_create_module_contribution_registry_tables.php`; contract: `docs/06-database/tables/setup_registry_entries.md`; gaps: `implemented_table_unclaimed`.
- `user_contact_emails` — implemented; Core Identity; source: `database/migrations/2026_07_07_000002_create_user_contact_emails_table.php`; contract: `docs/06-database/tables/user_contact_emails.md`; gaps: `implemented_table_unclaimed`.
- `user_dashboard_layouts` — implemented; Core Dashboard; source: `database/migrations/2026_04_13_000001_create_user_dashboard_layouts_table.php`; contract: `docs/06-database/tables/user_dashboard_layouts.md`; gaps: none recorded.
- `user_mfa_methods` — implemented; Core Auth; sources: `database/migrations/2026_07_01_000001_create_mfa_tables.php`, `database/migrations/2026_07_01_000002_add_pending_secret_expiry_to_user_mfa_methods.php`; table contract: missing; gaps: `contract_missing`.
- `user_mfa_policies` — implemented; Core Auth; source: `database/migrations/2026_07_01_000001_create_mfa_tables.php`; table contract: missing; gaps: `contract_missing`.
- `user_notification_preferences` — implemented; Core Notifications; sources: `database/migrations/2026_07_07_000003_create_user_notification_preferences_table.php`, `database/migrations/2026_07_08_000001_drop_in_app_enabled_from_user_notification_preferences_table.php`; contract: `docs/06-database/tables/user_notification_preferences.md`; gaps: none recorded.
- `users` — implemented; Core Identity; sources: `database/migrations/0001_01_01_000000_create_users_table.php`, `database/migrations/2026_04_09_000002_add_phase_one_lifecycle_columns_to_users_table.php`, `database/migrations/2026_04_09_000005_add_timezone_to_users_table.php`, `database/migrations/2026_04_10_000001_add_staff_profile_fields_to_users_table.php`, `database/migrations/2026_04_12_220000_add_theme_preference_to_users_table.php`; table contract: missing; gaps: `contract_missing`, `scope_missing`, `planning_implementation_overlap`.

## 4. Planned Persistent Concepts

These names are planning vocabulary, not selected tables. Every concept below lacks an accepted table contract at this snapshot. Goal 06 may combine, rename, replace, or reject them.

### 4.1 Access Control

Source: `docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md`

- `concept.access_group`
- `concept.access_group_member`
- `concept.access_policy`
- `concept.access_policy_approval`
- `concept.access_policy_constraint`
- `concept.access_review_campaign`
- `concept.access_review_decision`
- `concept.access_review_item`
- `concept.elevated_access_session`

The first eight concepts overlap existing access implementation and carry `planning_implementation_overlap`; all nine carry `contract_missing`.

### 4.2 Audit, Monitoring, Response, And Recovery

- `concept.actor_attribution_envelope`, `concept.audit_event`, `concept.audit_event_change`, and `concept.health_check_result` — source: `docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md`.
- `concept.backup_health_record` — source: `docs/07-planning/02-core-capabilities/audit-monitoring-response/backup-recovery-planning.md`.
- `concept.evidence_chain_of_custody_entry`, `concept.evidence_package`, and `concept.evidence_package_item` — source: `docs/07-planning/02-core-capabilities/audit-monitoring-response/digital-forensics-readiness-planning.md`.
- `concept.incident_case` — source: `docs/07-planning/02-core-capabilities/audit-monitoring-response/incident-response-planning.md`.

All carry `contract_missing`; `concept.audit_event` also carries `planning_implementation_overlap` with current audit storage.

### 4.3 Data Governance And Protection

- `concept.consent_record`, `concept.data_asset_governance_record`, `concept.data_domain_registry`, `concept.data_quality_issue`, `concept.data_subject_registry`, `concept.deletion_erasure_evidence`, `concept.privacy_request`, `concept.privacy_request_item`, `concept.processing_purpose`, and `concept.retention_policy_registry` — source: `docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md`.
- `concept.export_artifact_metadata`, `concept.export_request`, and `concept.legal_hold` — source: `docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md`.

All carry `contract_missing`.

### 4.4 Service Accounts, APIs, Webhooks, And Machine Identity

- `concept.api_token`, `concept.api_token_event`, `concept.service_account_table`, `concept.service_account_users_type`, `concept.webhook_delivery`, `concept.webhook_endpoint`, and `concept.webhook_processing_attempt` — source: `docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md`.
- `concept.application_principal_reference`, `concept.assurance_evidence`, `concept.credential_metadata`, `concept.machine_identity`, `concept.network_context`, `concept.network_identity`, `concept.non_human_identity_principal`, `concept.target_tenant_instance_scope`, and `concept.workload_identity_reference` — source: `docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md`.

All carry `contract_missing`. The two service-account alternatives also carry `duplicate_persistent_concept` and require one accepted direction.

### 4.5 Secrets And Vulnerability Management

- `concept.credential_material`, `concept.credential_reference`, `concept.secret_metadata`, and `concept.secret_rotation_event` — source: `docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md`.
- `concept.risk_acceptance`, `concept.vulnerability_asset`, and `concept.vulnerability_finding` — source: `docs/07-planning/02-core-capabilities/security/vulnerability-management-core-planning.md`.

All carry `contract_missing`.

### 4.6 User Lifecycle

- `concept.user_lifecycle_metadata` — source: `docs/07-planning/02-core-capabilities/auth-identity-access/users-module-implementation-planning.md`; gap: `contract_missing`.

## 5. Non-Table Persistence Boundaries

These boundaries identify configuration or planning surfaces that Goal 06 and related capabilities must account for. They do not imply application-owned relational tables.

- `boundary.backup_artifacts` — planned; Core Data Protection; source: `docs/07-planning/02-core-capabilities/audit-monitoring-response/backup-recovery-planning.md`; gaps: `lifecycle_or_deletion_unclear`, `retention_or_erasure_missing`.
- `boundary.database_cache` — implemented configuration; infrastructure; source: `config/cache.php`; gaps: none recorded.
- `boundary.database_connection_target` — implemented configuration; Core Database; sources: `config/database.php`, `.env.example`; gap: `database_target_conflict`.
- `boundary.database_queue` — implemented configuration; infrastructure; source: `config/queue.php`; gaps: none recorded.
- `boundary.database_sessions` — implemented configuration; Core Auth; source: `config/session.php`; gaps: none recorded.
- `boundary.export_artifacts` — planned; Core Data Protection; source: `docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md`; gaps: `lifecycle_or_deletion_unclear`, `retention_or_erasure_missing`.
- `boundary.external_secret_manager` — planned; Core Security; source: `docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md`; gaps: `lifecycle_or_deletion_unclear`, `retention_or_erasure_missing`.
- `boundary.file_cache` — implemented configuration; infrastructure; source: `config/cache.php`; gaps: none recorded.
- `boundary.file_sessions` — implemented configuration; Core Auth; source: `config/session.php`; gaps: none recorded.
- `boundary.laravel_migration_repository` — implemented configuration; Core Database; source: `config/database.php`; gaps: none recorded.
- `boundary.object_storage` — implemented configuration; Core Data Protection; source: `config/filesystems.php`; gaps: none recorded.
- `boundary.private_filesystem` — implemented configuration; Core Data Protection; source: `config/filesystems.php`; gaps: none recorded.
- `boundary.profile_images` — planned; Core Identity; source: `docs/07-planning/02-core-capabilities/auth-identity-access/users-module-implementation-planning.md`; gaps: `lifecycle_or_deletion_unclear`, `retention_or_erasure_missing`.
- `boundary.public_filesystem` — implemented configuration; Core Data Protection; source: `config/filesystems.php`; gap: `sensitive_storage_risk`.
- `boundary.redis_cache` — implemented configuration; infrastructure; source: `config/cache.php`; gaps: none recorded.
- `boundary.redis_queue` — implemented configuration; infrastructure; source: `config/queue.php`; gaps: none recorded.

## 6. Contract, Ownership, And Scope Gaps

The snapshot exposes planning work; it does not resolve it.

- Table contracts exist for 12 of the 32 named table surfaces. Missing contracts require Goal 06 disposition, but infrastructure or package-managed tables may need a different documentation owner rather than one contract per table.
- `implemented_table_unclaimed` marks tables present in migrations but not yet reconciled with the earlier database-contract inventory at the pinned baseline.
- `compatibility_unresolved` marks access-control storage whose package compatibility and target replacement strategy remain open.
- `scope_missing` marks storage whose tenant, instance, principal, resource, or actor scope is not sufficiently established by the retained sources.
- `model_relationship_unenforced` marks an application-level relationship that should not be mistaken for a database-enforced constraint.
- Owner and capability labels route review only. Architecture, Data Governance, database ownership, and planning reviewers must accept any durable target ownership.
- Planned concepts remain planning inputs until Goal 06 selects target entities and `docs/06-database/` owns accepted schema contracts.

## 7. Contradictions And Goal 06 Questions

### 7.1 Contradiction Codes

- `contract_missing` — no accepted table contract was identified at the pinned baseline.
- `compatibility_unresolved` — compatibility storage may be retained, adapted, or replaced.
- `implemented_table_unclaimed` — migration evidence and the earlier contract inventory were not reconciled.
- `scope_missing` — required data scope or attribution is not established.
- `planning_implementation_overlap` — planned vocabulary overlaps current implementation without an accepted mapping.
- `duplicate_persistent_concept` — planning presents competing persistence alternatives.
- `model_relationship_unenforced` — a source relationship does not establish a database constraint.
- `database_target_conflict` — default and testing database targets differ and require environment-aware interpretation.
- `lifecycle_or_deletion_unclear` — lifecycle behavior for a non-table boundary remains open.
- `retention_or_erasure_missing` — retention, erasure, or legal-hold handling is not established.
- `sensitive_storage_risk` — a public storage boundary requires explicit classification and access review before sensitive use.

### 7.2 Open Goal 06 Questions

1. Which current tables should be retained, replaced, combined, split, or treated only as framework/package compatibility surfaces?
2. What Core or Module owner, tenant or instance scope, actor attribution, and resource scope should each accepted target entity have?
3. Which planned concepts are target entities, embedded value objects, audit evidence, configuration, or rejected alternatives?
4. Which table contracts must be created or revised in `docs/06-database/`, and which infrastructure tables should be documented through another canonical owner?
5. How should current access-control and audit storage map to the accepted target vocabulary without assuming one-to-one migration?
6. What classification, retention, erasure, export, legal-hold, encryption, and Audit requirements apply to each accepted target entity and non-table boundary?
7. Which file, object-storage, backup, export, cache, queue, session, secret-manager, and migration-repository boundaries require explicit ownership and operational controls?
8. What evidence is required from deployed environments before any migration plan may claim actual schema or data state?

These are unresolved planning questions. Their answers require accepted Goal 06 work and promotion into the appropriate decision, architecture, database, feature, flow, standard, or runbook owner.

## 8. Appropriate Uses And Prohibited Interpretations

Appropriate uses:

- locate source-controlled migrations and configuration relevant to rewrite planning;
- identify current storage names and planning vocabulary that require disposition;
- route contract, ownership, scope, lifecycle, retention, and security review;
- seed bounded Goal 06 discovery without repeating the issue #31 repository scan.

Prohibited interpretations:

- a statement of migration operation order or correctness;
- a final-state column, key, index, uniqueness, or foreign-key specification;
- evidence of successful rollback or condition handling;
- evidence of the schema or data present in any deployed environment;
- an accepted mapping from current storage to the Goal 06 target model;
- a substitute for canonical database contracts or accepted architecture decisions.

## 9. Review And Promotion

Before this draft snapshot is accepted, repository-owner Architecture, Data Governance, database-ownership, and planning review must confirm that the retained labels are useful and are not mistaken for target decisions. Any accepted target schema or migration direction must be promoted to its canonical owner; this snapshot should remain a bounded baseline reference rather than an active schema ledger.

Related GitHub issues: #18, #29, #31
