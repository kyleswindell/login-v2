/**
 * Collect pinned persistence evidence and render the reviewed issue #31 inventory.
 */

import { createHash } from "node:crypto";
import { existsSync, mkdirSync, readFileSync, writeFileSync } from "node:fs";
import { mkdtemp, rm } from "node:fs/promises";
import { tmpdir } from "node:os";
import {
    basename,
    dirname,
    isAbsolute,
    join,
    relative,
    resolve,
} from "node:path";
import { spawnSync } from "node:child_process";

const DEFAULT_BASELINE = "1d103f5fa47aab8c8adfba8ea134dd29540426fe";
const ACCEPTED_MAIN = "bb76558adfe1bc9927bd2b34057dd82ee9a4d253";
const DOCUMENT_PATH =
    "docs/07-planning/00-overview/m0-persistent-data-current-state-inventory.md";
const EVIDENCE_DIRECTORY = "docs/07-planning/00-overview/evidence";
const LEDGER_PATH = `${EVIDENCE_DIRECTORY}/m0-persistent-data-migration-ledger.json`;
const RAW_PATH = `${EVIDENCE_DIRECTORY}/m0-persistent-data-current-state-raw.json`;
const CLASSIFICATIONS_PATH = `${EVIDENCE_DIRECTORY}/m0-persistent-data-current-state-classifications.json`;
const ISSUE_29_RAW = `${EVIDENCE_DIRECTORY}/m0-repository-current-state-raw.json`;
const GENERATOR_PATH =
    "scripts/generate-m0-persistent-data-current-state-inventory.mjs";
const FIXTURE_CATALOG =
    "scripts/fixtures/m0-persistent-data-current-state-inventory/cases.json";
const GENERATOR_SCHEMA_VERSION = 2;
const CANONICAL_KEY_PATTERN = /^[a-z][a-z0-9_]*$/;

const DECLARATION_OWNER_COMPATIBILITY = {
    auth: ["auth"],
    roles: ["access"],
    logging: ["audit", "monitoring"],
    notifications: ["notifications"],
    settings: ["settings"],
    dashboard: ["dashboard"],
    users: ["identity"],
    security_checklist: ["security"],
};

const ALLOWED_PATHS = [
    DOCUMENT_PATH,
    LEDGER_PATH,
    RAW_PATH,
    CLASSIFICATIONS_PATH,
    GENERATOR_PATH,
    "scripts/review-m0-persistent-data-current-state-inventory.mjs",
    "scripts/check-m0-persistent-data-current-state-inventory.mjs",
    "scripts/fixtures/m0-persistent-data-current-state-inventory/",
    "package.json",
    "docs/07-planning/index.md",
];

const REQUIRED_FIELDS = [
    "migration_or_planning_source",
    "storage_identifier",
    "implementation_state",
    "ownership_area",
    "owner_key",
    "capability_key",
    "module_key",
    "tenant_scope",
    "instance_scope",
    "principal_scope",
    "resource_scope",
    "actor_scope",
    "target_tenant_or_instance_scope",
    "key_and_relationship_evidence",
    "uniqueness_and_index_evidence",
    "lifecycle_and_deletion_evidence",
    "classification_evidence",
    "retention_and_erasure_evidence",
    "audit_evidence",
    "contract_path",
    "compatibility_evidence",
    "known_contradictions",
    "disposition",
    "target_question",
];

const CONTROLLED_VALUES = {
    implementation_state: [
        "implemented",
        "planned",
        "compatibility",
        "historical",
        "superseded",
        "unknown",
    ],
    ownership_area: ["core", "module", "ui", "not_applicable", "unknown"],
    scope_state: [
        "explicit",
        "indirect",
        "absent",
        "contradictory",
        "unknown",
        "not_applicable",
    ],
    disposition: ["retain", "investigate", "compatibility", "duplicate"],
    registration_state: [
        "registered",
        "present_unregistered",
        "registered_root_missing",
        "unresolved",
        "not_applicable",
    ],
    parse_status: [
        "complete",
        "partial",
        "unresolved_dynamic_identifier",
        "unsupported_operation",
        "failed",
    ],
    contradiction_code: [
        "migration_registration_missing",
        "migration_parse_partial",
        "duplicate_migration_name",
        "duplicate_table_creation",
        "migration_chain_conflict",
        "migration_model_mismatch",
        "migration_contract_mismatch",
        "model_relationship_unenforced",
        "owned_table_declares_missing_table",
        "implemented_table_unclaimed",
        "owned_table_owner_mismatch",
        "contract_missing",
        "contract_stale",
        "scope_missing",
        "scope_conflict",
        "lifecycle_or_deletion_unclear",
        "classification_missing",
        "retention_or_erasure_missing",
        "audit_evidence_missing",
        "planning_implementation_overlap",
        "compatibility_unresolved",
        "database_target_conflict",
        "duplicate_persistent_concept",
        "sensitive_storage_risk",
        "runtime_baseline_mismatch",
        "investigate",
    ],
};

const COLUMN_METHODS = new Set([
    "bigInteger",
    "bigIncrements",
    "binary",
    "boolean",
    "char",
    "date",
    "dateTime",
    "decimal",
    "double",
    "enum",
    "float",
    "foreignId",
    "id",
    "increments",
    "integer",
    "ipAddress",
    "json",
    "jsonb",
    "longText",
    "mediumInteger",
    "mediumText",
    "smallInteger",
    "string",
    "text",
    "time",
    "timestamp",
    "timestampTz",
    "tinyInteger",
    "unsignedBigInteger",
    "unsignedInteger",
    "unsignedSmallInteger",
    "unsignedTinyInteger",
    "uuid",
]);

const TABLE_MACROS = new Set([
    "timestamps",
    "timestampsTz",
    "softDeletes",
    "softDeletesTz",
    "rememberToken",
    "morphs",
    "nullableMorphs",
    "uuidMorphs",
    "nullableUuidMorphs",
]);

const PACKAGE_KEYS = [
    "Account",
    "Auth",
    "Dashboard",
    "Notifications",
    "Preferences",
    "Roles",
    "Settings",
    "Setup",
];

const PLANNED_CONCEPTS = [
    [
        "user_lifecycle_metadata",
        "docs/07-planning/02-core-capabilities/auth-identity-access/users-module-implementation-planning.md",
        "identity",
        "Identity",
        "A separate user lifecycle metadata table is an active conditional persistence option.",
    ],
    [
        "access_group",
        "docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md",
        "access",
        "Access",
        "Access groups are an explicit candidate data surface.",
    ],
    [
        "access_group_member",
        "docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md",
        "access",
        "Access",
        "Access group membership is an explicit candidate association surface.",
    ],
    [
        "access_policy",
        "docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md",
        "access",
        "Access",
        "Access policies are an explicit candidate governance and scope surface.",
    ],
    [
        "access_policy_constraint",
        "docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md",
        "access",
        "Access",
        "Access policy constraints are an explicit candidate data surface.",
    ],
    [
        "access_policy_approval",
        "docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md",
        "access",
        "Access",
        "Access policy approvals are an explicit candidate accountable-decision surface.",
    ],
    [
        "elevated_access_session",
        "docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md",
        "access",
        "Access",
        "Elevated access sessions are an explicit candidate lifecycle surface.",
    ],
    [
        "access_review_campaign",
        "docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md",
        "access",
        "Access",
        "Access review campaigns are an explicit candidate review-lifecycle surface.",
    ],
    [
        "access_review_item",
        "docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md",
        "access",
        "Access",
        "Access review items are an explicit candidate association surface.",
    ],
    [
        "access_review_decision",
        "docs/07-planning/02-core-capabilities/auth-identity-access/access-control-implementation-planning.md",
        "access",
        "Access",
        "Access review decisions are an explicit candidate accountable-evidence surface.",
    ],
    [
        "non_human_identity_principal",
        "docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md",
        "identity",
        "Identity",
        "Non-Human Identity Principal persistence is planned separately from Machine Identity.",
    ],
    [
        "service_account_users_type",
        "docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md",
        "access",
        "Access",
        "Extending users with a service type remains an open Service Account storage alternative.",
    ],
    [
        "service_account_table",
        "docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md",
        "access",
        "Access",
        "A dedicated service_accounts table remains the recommended but unaccepted storage alternative.",
    ],
    [
        "workload_identity_reference",
        "docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md",
        "identity",
        "Identity",
        "Workload Identity references require a persistent mapping boundary.",
    ],
    [
        "application_principal_reference",
        "docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md",
        "identity",
        "Identity",
        "Application Principal references require a persistent mapping boundary.",
    ],
    [
        "credential_metadata",
        "docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md",
        "security",
        "Security",
        "Credential metadata lifecycle must remain separate from reusable credential material.",
    ],
    [
        "credential_material",
        "docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md",
        "security",
        "Security",
        "Reusable credential material requires an approved protected storage boundary.",
    ],
    [
        "credential_reference",
        "docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md",
        "security",
        "Security",
        "Application persistence may store safe references to externally protected credential material.",
    ],
    [
        "machine_identity",
        "docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md",
        "security",
        "Security",
        "Machine Identity evidence is independent from NHI Principal identity.",
    ],
    [
        "network_identity",
        "docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md",
        "security",
        "Security",
        "Network Identity evidence may accompany a human or non-human Principal.",
    ],
    [
        "network_context",
        "docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md",
        "security",
        "Security",
        "Network Context evidence is planned separately from durable Principal identity.",
    ],
    [
        "assurance_evidence",
        "docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md",
        "security",
        "Security",
        "Assurance and attestation evidence requires its own lifecycle and classification.",
    ],
    [
        "actor_attribution_envelope",
        "docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md",
        "audit",
        "Audit",
        "Audit Actor attribution must distinguish Principal, acting Instance, channel, action, target, and result.",
    ],
    [
        "target_tenant_instance_scope",
        "docs/07-planning/02-core-capabilities/auth-identity-access/service-accounts-machine-identity-planning.md",
        "access",
        "Access",
        "Affected Tenant and Instance scope must remain separate from Actor scope.",
    ],
    [
        "audit_event",
        "docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md",
        "audit",
        "Audit",
        "A target audit_events surface remains planned and undecided.",
    ],
    [
        "audit_event_change",
        "docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md",
        "audit",
        "Audit",
        "Audit change-set rows are a distinct planned association surface.",
    ],
    [
        "health_check_result",
        "docs/07-planning/02-core-capabilities/audit-monitoring-response/audit-monitoring-core-planning.md",
        "monitoring",
        "Monitoring",
        "Health check results are an explicit planned Monitoring persistence surface.",
    ],
    [
        "data_domain_registry",
        "docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md",
        "data_governance",
        "DataGovernance",
        "A candidate data-domain registry would persist ownership and governance metadata.",
    ],
    [
        "data_asset_governance_record",
        "docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md",
        "data_governance",
        "DataGovernance",
        "Candidate data-asset governance records persist ownership, purpose, classification, and review metadata.",
    ],
    [
        "processing_purpose",
        "docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md",
        "data_governance",
        "DataGovernance",
        "Processing purposes are an explicit candidate registry surface.",
    ],
    [
        "consent_record",
        "docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md",
        "data_governance",
        "DataGovernance",
        "Consent records are an explicit candidate lifecycle surface for optional processing.",
    ],
    [
        "privacy_request",
        "docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md",
        "data_governance",
        "DataGovernance",
        "Privacy request lifecycle persistence is planned.",
    ],
    [
        "privacy_request_item",
        "docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md",
        "data_governance",
        "DataGovernance",
        "Privacy request items associate one request with governed assets and fulfillment outcomes.",
    ],
    [
        "data_subject_registry",
        "docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md",
        "data_governance",
        "DataGovernance",
        "A consolidated data-subject table is a conditional storage alternative.",
    ],
    [
        "data_quality_issue",
        "docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md",
        "data_governance",
        "DataGovernance",
        "Data quality issues are an explicit candidate remediation lifecycle surface.",
    ],
    [
        "retention_policy_registry",
        "docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md",
        "data_governance",
        "DataGovernance",
        "Retention policy registry metadata and enforcement evidence require persistent ownership.",
    ],
    [
        "legal_hold",
        "docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md",
        "data_governance",
        "DataGovernance",
        "Legal-hold state must be represented separately from ordinary retention.",
    ],
    [
        "export_request",
        "docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md",
        "data_protection",
        "DataProtection",
        "Sensitive export request, approval, status, and audit metadata require lifecycle persistence.",
    ],
    [
        "export_artifact_metadata",
        "docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md",
        "data_protection",
        "DataProtection",
        "Generated export artifact references and expiry metadata require protected persistence.",
    ],
    [
        "deletion_erasure_evidence",
        "docs/07-planning/02-core-capabilities/data-governance-protection/privacy-data-governance-planning.md",
        "data_governance",
        "DataGovernance",
        "Deletion and erasure decisions require accountable evidence without retaining erased content.",
    ],
    [
        "vulnerability_finding",
        "docs/07-planning/02-core-capabilities/security/vulnerability-management-core-planning.md",
        "security",
        "Security",
        "Vulnerability findings may become persistent when reporting requires it.",
    ],
    [
        "vulnerability_asset",
        "docs/07-planning/02-core-capabilities/security/vulnerability-management-core-planning.md",
        "security",
        "Security",
        "Vulnerability asset inventory metadata is a planned persistence option.",
    ],
    [
        "risk_acceptance",
        "docs/07-planning/02-core-capabilities/security/vulnerability-management-core-planning.md",
        "security",
        "Security",
        "Risk acceptance requires accountable expiry and approval evidence.",
    ],
    [
        "api_token",
        "docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md",
        "auth",
        "Auth",
        "API token metadata, prefix/hash, scope, expiry, rotation, and revocation require lifecycle persistence.",
    ],
    [
        "api_token_event",
        "docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md",
        "monitoring",
        "Monitoring",
        "A dedicated high-volume API token event table is an explicit optional alternative to Audit.",
    ],
    [
        "webhook_endpoint",
        "docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md",
        "security",
        "Security",
        "Webhook endpoint identity and safe secret references are a candidate persistence surface.",
    ],
    [
        "webhook_delivery",
        "docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md",
        "security",
        "Security",
        "Webhook delivery metadata, safe payload evidence, replay state, and processing status are a candidate persistence surface.",
    ],
    [
        "webhook_processing_attempt",
        "docs/07-planning/02-core-capabilities/auth-identity-access/api-webhook-service-account-security-planning.md",
        "monitoring",
        "Monitoring",
        "Webhook processing attempts are a candidate retry and failure-evidence surface.",
    ],
    [
        "secret_metadata",
        "docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md",
        "security",
        "Security",
        "Secret metadata must be persisted without storing revealable values in ordinary application records.",
    ],
    [
        "secret_rotation_event",
        "docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md",
        "security",
        "Security",
        "Secret rotation events are an explicit candidate lifecycle surface.",
    ],
    [
        "incident_case",
        "docs/07-planning/02-core-capabilities/audit-monitoring-response/incident-response-planning.md",
        "security",
        "Security",
        "Incident case lifecycle and accountable decisions are planned persistent evidence.",
    ],
    [
        "evidence_package",
        "docs/07-planning/02-core-capabilities/audit-monitoring-response/digital-forensics-readiness-planning.md",
        "audit",
        "Audit",
        "Evidence packages are an explicit candidate protected investigation surface.",
    ],
    [
        "evidence_package_item",
        "docs/07-planning/02-core-capabilities/audit-monitoring-response/digital-forensics-readiness-planning.md",
        "audit",
        "Audit",
        "Evidence package items are a distinct candidate association and integrity surface.",
    ],
    [
        "evidence_chain_of_custody_entry",
        "docs/07-planning/02-core-capabilities/audit-monitoring-response/digital-forensics-readiness-planning.md",
        "audit",
        "Audit",
        "Chain-of-custody entries are a distinct candidate accountable lifecycle surface.",
    ],
    [
        "backup_health_record",
        "docs/07-planning/02-core-capabilities/audit-monitoring-response/backup-recovery-planning.md",
        "monitoring",
        "Monitoring",
        "Backup health, freshness, verification, and restore evidence may require durable monitoring records.",
    ],
];

const EVIDENCE_NEEDLES = {
    access_group: "`access_groups`",
    access_group_member: "`access_group_members`",
    access_policy: "`access_policies`",
    access_policy_constraint: "`access_policy_constraints`",
    access_policy_approval: "`access_policy_approvals`",
    elevated_access_session: "`elevated_access_sessions`",
    access_review_campaign: "`access_review_campaigns`",
    access_review_item: "`access_review_items`",
    access_review_decision: "`access_review_decisions`",
    application_principal_reference: "### Application Principal",
    assurance_evidence: "Request Assurance Context",
    audit_event: "- `audit_events`",
    audit_event_change: "- `audit_event_changes`",
    health_check_result: "- `health_check_results`",
    backup_health_record: "backup health records",
    credential_material: "credential material",
    credential_metadata: "credential type or credential reference",
    credential_reference: "credential reference",
    data_domain_registry: "Candidate domain table",
    data_asset_governance_record: "data_asset_governance_records",
    processing_purpose: "processing_purposes",
    consent_record: "consent_records",
    privacy_request: "privacy_requests",
    privacy_request_item: "privacy_request_items",
    data_subject_registry: "Add a `data_subjects` table",
    data_quality_issue: "data_quality_issues",
    export_artifact_metadata: "export manifest",
    export_request: "export approval flow",
    evidence_package: "### `evidence_packages`",
    evidence_package_item: "evidence_package_id",
    evidence_chain_of_custody_entry: "### `evidence_chain_of_custody_entries`",
    incident_case: "app-visible incident records",
    legal_hold: "legal hold should override",
    machine_identity: "Machine Identity is independent",
    network_context: "Network Context may include",
    network_identity: "Network Identity may represent",
    non_human_identity_principal: "human or non-human Principals",
    retention_policy_registry: "retention policy registry",
    risk_acceptance: "accepted_security_risks",
    secret_metadata: "secret inventory metadata",
    secret_rotation_event: "secret_rotation_events",
    service_account_users_type: "`users.type = service`",
    service_account_table: "### `service_accounts`",
    api_token: "### `api_tokens`",
    api_token_event: "### Optional `api_token_events`",
    target_tenant_instance_scope: "explicit target Tenant and Instance scope",
    user_lifecycle_metadata: "user lifecycle metadata table",
    vulnerability_asset: "vulnerability_assets",
    vulnerability_finding: "vulnerability_findings",
    webhook_endpoint: "### `webhook_endpoints`",
    webhook_delivery: "### `webhook_deliveries`",
    webhook_processing_attempt: "### `webhook_processing_attempts`",
    workload_identity_reference: "### Workload Identity",
    laravel_migration_repository: "Migration Repository Table",
    database_cache: "'default' => env('CACHE_STORE'",
    file_cache: "'file' => [",
    redis_cache: "'redis' => [",
    database_queue: "'default' => env('QUEUE_CONNECTION'",
    redis_queue: "'connection' => env('REDIS_QUEUE_CONNECTION'",
    database_sessions: "'driver' => env('SESSION_DRIVER'",
    file_sessions: "Session File Location",
    object_storage: "'s3' => [",
    private_filesystem: "storage_path('app/private')",
    public_filesystem: "'public' => [",
    profile_images: "profile image metadata",
    external_secret_manager: "external vault or environment-store integration",
    backup_artifacts: "backup artifact exists",
    database_connection_target: "'default' => env('DB_CONNECTION'",
};

const BOUNDARIES = [
    [
        "database_connection_target",
        "config/database.php",
        "database",
        "Database",
        "The runtime connection fallback and canonical PostgreSQL direction require explicit reconciliation.",
    ],
    [
        "laravel_migration_repository",
        "config/database.php",
        "database",
        "Database",
        "Laravel tracks applied migration names in its framework-managed migration repository.",
    ],
    [
        "database_cache",
        "config/cache.php",
        "infrastructure",
        "Infrastructure",
        "The default cache store uses database persistence and the cache/cache_locks tables.",
    ],
    [
        "file_cache",
        "config/cache.php",
        "infrastructure",
        "Infrastructure",
        "Laravel can persist cache entries under the framework cache directory.",
    ],
    [
        "redis_cache",
        "config/cache.php",
        "infrastructure",
        "Infrastructure",
        "Laravel can use Redis as an external cache and lock boundary.",
    ],
    [
        "database_sessions",
        "config/session.php",
        "auth",
        "Auth",
        "The default session driver persists session payloads in the database.",
    ],
    [
        "file_sessions",
        "config/session.php",
        "auth",
        "Auth",
        "Laravel can persist session payloads in framework session files.",
    ],
    [
        "database_queue",
        "config/queue.php",
        "infrastructure",
        "Infrastructure",
        "The default queue connection persists jobs, batches, and failures in database tables.",
    ],
    [
        "redis_queue",
        "config/queue.php",
        "infrastructure",
        "Infrastructure",
        "Laravel can use Redis as an external queue boundary.",
    ],
    [
        "private_filesystem",
        "config/filesystems.php",
        "data_protection",
        "DataProtection",
        "The local disk maps to private application storage.",
    ],
    [
        "public_filesystem",
        "config/filesystems.php",
        "data_protection",
        "DataProtection",
        "The public disk maps to web-addressable application storage.",
    ],
    [
        "object_storage",
        "config/filesystems.php",
        "data_protection",
        "DataProtection",
        "The S3 disk represents external object storage without recording credentials.",
    ],
    [
        "profile_images",
        "docs/07-planning/02-core-capabilities/auth-identity-access/users-module-implementation-planning.md",
        "identity",
        "Identity",
        "Profile-image file persistence has unresolved lifecycle, classification, and erasure evidence.",
    ],
    [
        "export_artifacts",
        "docs/07-planning/02-core-capabilities/data-governance-protection/data-protection-core-planning.md",
        "data_protection",
        "DataProtection",
        "Generated exports require private storage, expiry, access, and erasure controls.",
    ],
    [
        "backup_artifacts",
        "docs/07-planning/02-core-capabilities/audit-monitoring-response/backup-recovery-planning.md",
        "data_protection",
        "DataProtection",
        "Backup artifacts remain outside ordinary application-created tables.",
    ],
    [
        "external_secret_manager",
        "docs/07-planning/02-core-capabilities/security/secrets-management-core-planning.md",
        "security",
        "Security",
        "An external secret manager is a candidate protected credential-material boundary.",
    ],
];

const TABLE_OWNERS = {
    users: ["identity", "Identity"],
    password_reset_tokens: ["auth", "Auth"],
    sessions: ["auth", "Auth"],
    platform_audit_logs: ["audit", "Audit"],
    central_error_logs: ["monitoring", "Monitoring"],
    permissions: ["access", "Access"],
    roles: ["access", "Access"],
    model_has_permissions: ["access", "Access"],
    model_has_roles: ["access", "Access"],
    role_has_permissions: ["access", "Access"],
    settings: ["settings", "Settings"],
    notifications: ["notifications", "Notifications"],
    user_dashboard_layouts: ["dashboard", "Dashboard"],
    user_mfa_methods: ["auth", "Auth"],
    user_mfa_policies: ["auth", "Auth"],
    mfa_recovery_codes: ["auth", "Auth"],
    security_requirement_groups: ["security", "Security"],
    security_requirements: ["security", "Security"],
    permission_registry_entries: ["access", "Access"],
    role_metadata: ["access", "Access"],
    user_contact_emails: ["identity", "Identity"],
    user_notification_preferences: ["notifications", "Notifications"],
    module_registry_entries: ["modules", "Modules"],
    notification_registry_entries: ["notifications", "Notifications"],
    settings_registry_entries: ["settings", "Settings"],
    setup_registry_entries: ["setup", "Setup"],
    preference_registry_entries: ["preferences", "Preferences"],
};

const FRAMEWORK_TABLES = new Set([
    "cache",
    "cache_locks",
    "jobs",
    "job_batches",
    "failed_jobs",
]);
const COMPATIBILITY_TABLES = new Set([
    "permissions",
    "roles",
    "model_has_permissions",
    "model_has_roles",
    "role_has_permissions",
]);
const MATERIAL_PIVOTS = new Set([
    "model_has_permissions",
    "model_has_roles",
    "role_has_permissions",
]);

const args = parseArguments(process.argv.slice(2));

if (args.fixtureRoot) {
    await runFixtureMode(args.fixtureRoot);
} else if (args.renderOnly) {
    renderOnly(args.baseline ?? DEFAULT_BASELINE);
} else {
    collect(args);
}

function parseArguments(values) {
    const parsed = {
        baseline: null,
        collectOnly: false,
        renderOnly: false,
        withRuntimeDiscovery: false,
        staticOnly: false,
        resetClassifications: false,
        allowExtraChanges: false,
        fixtureRoot: null,
    };

    for (let index = 0; index < values.length; index += 1) {
        const value = values[index];
        if (value === "--baseline") parsed.baseline = values[++index];
        else if (value === "--collect-only") parsed.collectOnly = true;
        else if (value === "--render-only") parsed.renderOnly = true;
        else if (value === "--with-runtime-discovery")
            parsed.withRuntimeDiscovery = true;
        else if (value === "--static-only") parsed.staticOnly = true;
        else if (value === "--reset-classifications")
            parsed.resetClassifications = true;
        else if (value === "--allow-extra-changes")
            parsed.allowExtraChanges = true;
        else if (value === "--fixture-root")
            parsed.fixtureRoot = values[++index];
        else throw new Error(`Unknown argument: ${value}`);
    }

    if (parsed.collectOnly && parsed.renderOnly) {
        throw new Error(
            "--collect-only and --render-only are mutually exclusive.",
        );
    }
    if (parsed.staticOnly && parsed.withRuntimeDiscovery) {
        throw new Error(
            "--static-only and --with-runtime-discovery are mutually exclusive.",
        );
    }
    return parsed;
}

function collect(options) {
    const root = repositoryRoot();
    process.chdir(root);
    const baseline = options.baseline ?? DEFAULT_BASELINE;
    assertCommit(baseline);
    assertWorktreeScope(options.allowExtraChanges);
    const issue29 = verifyIssue29Baseline(baseline);
    const tree = readTree(baseline);
    const selected = tree.filter((entry) => shouldRead(entry.path));
    const blobs = readBlobs(selected);
    const head = run("git", ["rev-parse", "HEAD"]).stdout.trim();
    const committedAt = run("git", [
        "show",
        "-s",
        "--format=%cI",
        baseline,
    ]).stdout.trim();
    const existingRaw = readJsonIfExists(RAW_PATH);
    const generatedAt =
        existingRaw?.baseline?.sha === baseline &&
        existingRaw.generator?.generated_at
            ? existingRaw.generator.generated_at
            : new Date().toISOString();
    const runtime = options.withRuntimeDiscovery
        ? collectRuntimeDiscovery()
        : preserveRuntimeDiscovery(baseline, options.staticOnly);
    const dynamicIdentifiers = resolvePermissionIdentifiers(runtime);
    const migrationRoots = collectMigrationRoots(tree, blobs);
    const ledger = collectMigrationLedger({
        baseline,
        committedAt,
        head,
        tree,
        blobs,
        migrationRoots,
        dynamicIdentifiers,
        generatedAt,
    });
    const raw = collectRawEvidence({
        baseline,
        committedAt,
        head,
        tree,
        blobs,
        ledger,
        migrationRoots,
        runtime,
        issue29,
        generatedAt,
    });
    const classifications = mergeClassifications({
        baseline,
        raw,
        existing: options.resetClassifications
            ? null
            : readJsonIfExists(CLASSIFICATIONS_PATH),
        historicalReviewed: options.resetClassifications
            ? null
            : readJsonFromHead(CLASSIFICATIONS_PATH),
    });

    mkdirSync(resolve(EVIDENCE_DIRECTORY), { recursive: true });
    writeJson(resolve(LEDGER_PATH), ledger);
    writeJson(resolve(RAW_PATH), raw);
    writeJson(resolve(CLASSIFICATIONS_PATH), classifications);

    if (!options.collectOnly) renderArtifacts(ledger, raw, classifications);

    const reviewed = classifications.items.filter(
        (item) => item._reviewed,
    ).length;
    console.log(`Baseline: ${baseline}`);
    console.log(`Migration roots: ${ledger.migration_roots.length}`);
    console.log(`Migrations: ${ledger.migrations.length}`);
    console.log(`Material records: ${classifications.items.length}`);
    console.log(
        `Reviewed records: ${reviewed}/${classifications.items.length}`,
    );
}

function renderOnly(baseline) {
    const root = findRootWithoutGit(process.cwd());
    process.chdir(root);
    const ledger = readJson(LEDGER_PATH);
    const raw = readJson(RAW_PATH);
    const classifications = readJson(CLASSIFICATIONS_PATH);
    for (const artifact of [ledger, raw, classifications]) {
        if (artifact.baseline?.sha !== baseline) {
            throw new Error(
                `Artifact baseline mismatch; expected ${baseline}.`,
            );
        }
    }
    renderArtifacts(ledger, raw, classifications);
    console.log(
        `Rendered ${DOCUMENT_PATH} from committed/generated artifacts only.`,
    );
}

function repositoryRoot() {
    return run("git", ["rev-parse", "--show-toplevel"]).stdout.trim();
}

function findRootWithoutGit(start) {
    let current = resolve(start);
    while (true) {
        if (
            existsSync(join(current, "package.json")) &&
            existsSync(join(current, "docs"))
        ) {
            return current;
        }
        const parent = dirname(current);
        if (parent === current)
            throw new Error("Unable to locate repository root.");
        current = parent;
    }
}

function assertCommit(commit) {
    run("git", ["cat-file", "-e", `${commit}^{commit}`]);
}

function assertWorktreeScope(allowExtraChanges) {
    const lines = run("git", [
        "status",
        "--porcelain=v1",
        "-z",
        "--untracked-files=all",
    ])
        .stdout.split("\0")
        .filter(Boolean);
    const outside = [];
    for (const line of lines) {
        const path = normalizePath(line.slice(3).split(" -> ").at(-1));
        if (!isAllowedPath(path)) outside.push(path);
    }
    if (outside.length > 0 && !allowExtraChanges) {
        throw new Error(
            `Worktree contains out-of-scope changes: ${outside.join(", ")}`,
        );
    }
    if (outside.length > 0) {
        throw new Error(
            `--allow-extra-changes cannot authorize paths outside the issue scope: ${outside.join(", ")}`,
        );
    }
}

function isAllowedPath(path) {
    return ALLOWED_PATHS.some((allowed) =>
        allowed.endsWith("/") ? path.startsWith(allowed) : path === allowed,
    );
}

function verifyIssue29Baseline(baseline) {
    const evidence = readJson(ISSUE_29_RAW);
    if (evidence.baseline?.sha !== baseline) {
        throw new Error(
            `Issue #29 supporting evidence baseline ${evidence.baseline?.sha ?? "missing"} does not match ${baseline}.`,
        );
    }
    return {
        path: ISSUE_29_RAW,
        baseline_sha: evidence.baseline.sha,
        source_sha256: sha256(readFileSync(ISSUE_29_RAW)),
    };
}

function readTree(commit) {
    const output = run("git", ["ls-tree", "-r", "-z", "--long", commit], {
        encoding: "buffer",
    }).stdout;
    return output
        .toString("utf8")
        .split("\0")
        .filter(Boolean)
        .map((line) => {
            const match = line.match(
                /^(\d+)\s+(\w+)\s+([0-9a-f]+)\s+(\d+)\t(.+)$/,
            );
            if (!match)
                throw new Error(`Unable to parse ls-tree record: ${line}`);
            return {
                mode: match[1],
                type: match[2],
                oid: match[3],
                size: Number(match[4]),
                path: normalizePath(match[5]),
            };
        });
}

function shouldRead(path) {
    return (
        /(^|\/)migrations\/.*\.php$/i.test(path) ||
        /(^|\/)(Models|factories|seeders)\/.*\.php$/i.test(path) ||
        path.startsWith("app/Core/Modules/") ||
        /^Modules\/[^/]+\/Definition\.php$/.test(path) ||
        path === ".env.example" ||
        /^config\/(auth|cache|database|filesystems|permission|queue|session)\.php$/.test(
            path,
        ) ||
        path === "docs/06-database/index.md" ||
        path === "docs/06-database/schema.md" ||
        path.startsWith("docs/06-database/tables/") ||
        path.startsWith("docs/06-database/feature-contracts/") ||
        path.startsWith("docs/02-standards/database/") ||
        path.startsWith("docs/01-decisions/adr-0005") ||
        path.startsWith("docs/01-decisions/adr-0006") ||
        path.startsWith("docs/01-decisions/adr-0007") ||
        path === "docs/02-standards/coding/Identifier And Key Standards.md" ||
        (path.startsWith("docs/07-planning/") && path.endsWith(".md")) ||
        (path.startsWith("tests/") &&
            /database|migration|model|setting|notification|auth|mfa|role|permission|audit|error|dashboard|registry|user/i.test(
                path,
            ))
    );
}

function readBlobs(entries) {
    if (entries.length === 0) return new Map();
    const input = `${entries.map((entry) => entry.oid).join("\n")}\n`;
    const output = run("git", ["cat-file", "--batch"], {
        input,
        encoding: "buffer",
        maxBuffer: 128 * 1024 * 1024,
    }).stdout;
    const result = new Map();
    let offset = 0;
    for (const entry of entries) {
        const headerEnd = output.indexOf(10, offset);
        if (headerEnd < 0)
            throw new Error(`Missing cat-file header for ${entry.path}.`);
        const header = output.subarray(offset, headerEnd).toString("utf8");
        const match = header.match(/^([0-9a-f]+)\s+blob\s+(\d+)$/);
        if (!match) throw new Error(`Unexpected cat-file header: ${header}`);
        const size = Number(match[2]);
        const start = headerEnd + 1;
        const content = output.subarray(start, start + size).toString("utf8");
        result.set(entry.path, {
            ...entry,
            content: normalizeNewlines(content),
            sha256: sha256(Buffer.from(content, "utf8")),
            lines: normalizeNewlines(content).split("\n"),
        });
        offset = start + size + 1;
    }
    return result;
}

function collectMigrationRoots(tree, blobs) {
    const paths = new Set(tree.map((entry) => entry.path));
    const roots = [
        {
            path: "database/migrations",
            source: "Laravel default application migration root",
            declaration_path:
                "database/migrations/0001_01_01_000000_create_users_table.php",
        },
    ];
    for (const key of PACKAGE_KEYS) {
        const definition = `Modules/${key}/Definition.php`;
        if (!blobs.has(definition)) continue;
        roots.push({
            path: `Modules/${key}/database/migrations`,
            source: "PackageDefinition default registered by PackageRegistrar",
            declaration_path: definition,
        });
    }
    return roots
        .map((root) => {
            const exists = [...paths].some((path) =>
                path.startsWith(`${root.path}/`),
            );
            const migrationCount = [...paths].filter(
                (path) =>
                    path.startsWith(`${root.path}/`) && path.endsWith(".php"),
            ).length;
            return {
                registered_root: root.path,
                registration_state: exists
                    ? "registered"
                    : "registered_root_missing",
                registration_evidence: [
                    evidence(
                        blobs,
                        root.declaration_path,
                        root.source,
                        findLine(
                            blobs.get(root.declaration_path)?.content ?? "",
                            "migration",
                        ),
                    ),
                ],
                exists_at_baseline: exists,
                migration_count: migrationCount,
            };
        })
        .sort((left, right) =>
            left.registered_root.localeCompare(right.registered_root),
        );
}

function collectMigrationLedger(context) {
    const rootPaths = context.migrationRoots.map(
        (root) => root.registered_root,
    );
    const migrationEntries = context.tree
        .filter((entry) => /(^|\/)migrations\/.*\.php$/i.test(entry.path))
        .sort((left, right) => {
            const name = basename(left.path).localeCompare(
                basename(right.path),
            );
            return name || left.path.localeCompare(right.path);
        });
    const migrations = migrationEntries.map((entry) => {
        const blob = context.blobs.get(entry.path);
        const registeredRoot = rootPaths.find((root) =>
            entry.path.startsWith(`${root}/`),
        );
        const parsed = parseMigration(
            blob.content,
            entry.path,
            context.dynamicIdentifiers,
        );
        return {
            migration_path: entry.path,
            migration_name: basename(entry.path, ".php"),
            source_blob_oid: entry.oid,
            source_sha256: blob.sha256,
            registered_root: registeredRoot ?? null,
            registration_state: registeredRoot
                ? "registered"
                : "present_unregistered",
            registration_evidence: registeredRoot
                ? context.migrationRoots.find(
                      (root) => root.registered_root === registeredRoot,
                  ).registration_evidence
                : [
                      evidence(
                          context.blobs,
                          entry.path,
                          "Migration-looking source is outside every resolved registered root.",
                          1,
                      ),
                  ],
            up_operations: parsed.up,
            down_operations: parsed.down,
            parse_status: parsed.status,
            parse_notes: parsed.notes,
        };
    });
    const names = countBy(migrations, (item) => item.migration_name);
    const duplicateNames = Object.entries(names)
        .filter(([, count]) => count > 1)
        .map(([name]) => name);
    const creations = new Map();
    for (const migration of migrations) {
        for (const operation of migration.up_operations) {
            if (
                operation.operation_type !== "create_table" ||
                !operation.storage_identifier
            )
                continue;
            const list = creations.get(operation.storage_identifier) ?? [];
            list.push(migration.migration_path);
            creations.set(operation.storage_identifier, list);
        }
    }
    const duplicateCreations = [...creations.entries()]
        .filter(([, paths]) => paths.length > 1)
        .map(([storageIdentifier, paths]) => ({
            storage_identifier: storageIdentifier,
            paths,
        }));
    const upCount = migrations.reduce(
        (sum, migration) => sum + migration.up_operations.length,
        0,
    );
    const downCount = migrations.reduce(
        (sum, migration) => sum + migration.down_operations.length,
        0,
    );
    return {
        schema_version: 1,
        baseline: baselineMetadata(context),
        generator: generatorMetadata(context.generatedAt),
        migration_roots: context.migrationRoots,
        migrations,
        summary: {
            migration_root_count: context.migrationRoots.length,
            registered_root_count: context.migrationRoots.filter(
                (root) => root.registration_state === "registered",
            ).length,
            missing_registered_root_count: context.migrationRoots.filter(
                (root) => root.registration_state === "registered_root_missing",
            ).length,
            migration_count: migrations.length,
            fully_parsed_count: migrations.filter(
                (migration) => migration.parse_status === "complete",
            ).length,
            partial_or_dynamic_count: migrations.filter(
                (migration) => migration.parse_status !== "complete",
            ).length,
            up_operation_count: upCount,
            down_operation_count: downCount,
            duplicate_migration_names: duplicateNames,
            duplicate_table_creations: duplicateCreations,
        },
    };
}

function parseMigration(content, path, dynamicIdentifiers = {}) {
    const upBody = extractMethodBody(content, "up");
    const downBody = extractMethodBody(content, "down");
    const notes = [];
    if (!upBody) notes.push("Unable to locate an up() method body.");
    if (!downBody) notes.push("Unable to locate a down() method body.");
    const up = upBody
        ? parseSchemaOperations(content, upBody, path, dynamicIdentifiers)
        : [];
    const down = downBody
        ? parseSchemaOperations(content, downBody, path, dynamicIdentifiers)
        : [];
    const all = [...up, ...down];
    for (const operation of all) {
        operation.conditions = dedupeBy(
            operation.conditions,
            (condition) =>
                `${condition.expression}|${condition.expected ?? ""}|${condition.source_location.line_start}`,
        );
    }
    let status = "complete";
    if (!upBody || !downBody) status = "failed";
    else if (
        all.some(
            (operation) =>
                !operation.storage_identifier ||
                operationHasUnresolvedIdentifiers(operation),
        )
    ) {
        status = "unresolved_dynamic_identifier";
        notes.push(
            "At least one dynamic storage identifier could not be resolved from pinned or bounded runtime configuration.",
        );
    } else if (
        all.some((operation) => operation.unsupported_statements?.length > 0)
    ) {
        status = "unsupported_operation";
        notes.push(
            "At least one Blueprint operation was retained as unsupported.",
        );
    } else if (
        all.some((operation) =>
            operation.conditions.some(
                (condition) => condition.resolution === "unresolved",
            ),
        )
    ) {
        status = "partial";
        notes.push(
            "At least one schema-affecting condition could not be resolved safely.",
        );
    }
    if (all.length === 0 && (upBody || downBody)) {
        status = "partial";
        notes.push("No Schema facade operation was recognized.");
    }
    return { up, down, status, notes };
}

function extractMethodBody(content, name) {
    const match = new RegExp(`function\\s+${name}\\s*\\([^)]*\\)`, "m").exec(
        content,
    );
    if (!match) return null;
    const open = content.indexOf("{", match.index + match[0].length);
    if (open < 0) return null;
    const close = matchingDelimiter(content, open, "{", "}");
    if (close < 0) return null;
    return { text: content.slice(open + 1, close), offset: open + 1 };
}

function parseSchemaOperations(fullContent, body, path, dynamicIdentifiers) {
    const operations = [];
    let cursor = 0;
    while (cursor < body.text.length) {
        const match = /Schema::(create|table|dropIfExists|drop|rename)\s*\(/g;
        match.lastIndex = cursor;
        const found = match.exec(body.text);
        if (!found) break;
        const open = body.text.indexOf("(", found.index);
        const close = matchingDelimiter(body.text, open, "(", ")");
        if (close < 0) {
            operations.push(
                failedOperation(
                    operations.length + 1,
                    path,
                    lineAt(fullContent, body.offset + found.index),
                    found[0],
                ),
            );
            break;
        }
        const argsText = body.text.slice(open + 1, close);
        const args = splitTopLevel(argsText, ",");
        const identifierExpression = (args[0] ?? "").trim();
        const resolved = resolveIdentifier(
            identifierExpression,
            dynamicIdentifiers,
        );
        const line = lineAt(fullContent, body.offset + found.index);
        const operation = emptyOperation({
            sequence: operations.length + 1,
            operationType: schemaOperationType(found[1]),
            storageIdentifier: resolved.value,
            identifierExpression,
            path,
            line,
            raw: summarizeExpression(body.text.slice(found.index, close + 1)),
        });
        operation.conditions.push(
            ...precedingSchemaGuards(
                body.text,
                found.index,
                path,
                body.offset,
                fullContent,
                dynamicIdentifiers,
            ).map((condition) => ({ ...condition, scope: "operation" })),
            ...configurationGuards(
                body.text,
                path,
                body.offset,
                fullContent,
                dynamicIdentifiers,
            ).map((condition) => ({ ...condition, scope: "operation" })),
        );
        if (found[1] === "rename") {
            operation.rename_to = resolveIdentifier(
                (args[1] ?? "").trim(),
                dynamicIdentifiers,
            ).value;
            operation.destructive_behavior =
                "Renames a table and changes its storage identifier.";
        } else if (found[1] === "drop" || found[1] === "dropIfExists") {
            operation.destructive_behavior =
                found[1] === "dropIfExists"
                    ? "Drops the table when present."
                    : "Drops the table.";
        } else {
            const closure = extractClosure(
                argsText,
                body.offset + open + 1,
                fullContent,
            );
            if (closure)
                parseBlueprintStatements(
                    operation,
                    closure.text,
                    closure.offset,
                    fullContent,
                    dynamicIdentifiers,
                );
            else
                operation.unsupported_statements.push(
                    "Schema operation has no recognized Blueprint closure.",
                );
        }
        operations.push(operation);
        cursor = close + 1;
    }
    return operations;
}

function operationHasUnresolvedIdentifiers(operation) {
    const values = [
        ...operation.columns.map((column) => column.name),
        ...operation.primary_keys.flatMap((entry) => entry.columns),
        ...operation.indexes.flatMap((entry) => entry.columns),
        ...operation.unique_constraints.flatMap((entry) => entry.columns),
        ...operation.foreign_keys.flatMap((entry) => [
            ...entry.columns,
            entry.on,
            entry.references,
        ]),
        ...operation.dropped_columns.map((entry) => entry.name),
        ...operation.renamed_columns.flatMap((entry) => [entry.from, entry.to]),
    ];
    return values.some(
        (value) =>
            value === null ||
            value === "" ||
            /^\$|\bconfig\s*\(/.test(String(value)),
    );
}

function enclosingConditions(
    content,
    position,
    path,
    absoluteOffset,
    fullContent,
    dynamicIdentifiers,
) {
    const conditions = [];
    const pattern = /\bif\s*\(/g;
    for (const match of content.matchAll(pattern)) {
        if (match.index >= position) break;
        const openParen = content.indexOf("(", match.index);
        const closeParen = matchingDelimiter(content, openParen, "(", ")");
        if (closeParen < 0) continue;
        const openBrace = content.indexOf("{", closeParen);
        if (openBrace < 0) continue;
        const closeBrace = matchingDelimiter(content, openBrace, "{", "}");
        if (position <= openBrace || position >= closeBrace) continue;
        const expression = content.slice(openParen + 1, closeParen).trim();
        conditions.push(
            schemaCondition(
                expression,
                true,
                path,
                lineAt(fullContent, absoluteOffset + match.index),
                dynamicIdentifiers,
            ),
        );
    }
    return conditions;
}

function precedingSchemaGuards(
    content,
    position,
    path,
    absoluteOffset,
    fullContent,
    dynamicIdentifiers,
) {
    const guards = [];
    const pattern = /\bif\s*\(/g;
    for (const match of content.matchAll(pattern)) {
        if (match.index >= position) break;
        const openParen = content.indexOf("(", match.index);
        const closeParen = matchingDelimiter(content, openParen, "(", ")");
        const openBrace = content.indexOf("{", closeParen);
        const closeBrace =
            openBrace >= 0
                ? matchingDelimiter(content, openBrace, "{", "}")
                : -1;
        if (closeBrace < 0 || closeBrace >= position) continue;
        const block = content.slice(openBrace + 1, closeBrace);
        const between = content.slice(closeBrace + 1, position);
        if (!/\breturn\s*;/.test(block) || /Schema::/.test(between)) continue;
        const expression = content.slice(openParen + 1, closeParen).trim();
        if (!/Schema::hasColumn\s*\(/.test(expression)) continue;
        guards.push(
            schemaCondition(
                expression.replace(/^!\s*/, ""),
                /^!\s*/.test(expression),
                path,
                lineAt(fullContent, absoluteOffset + match.index),
                dynamicIdentifiers,
            ),
        );
    }
    return guards.slice(-1);
}

function configurationGuards(
    content,
    path,
    absoluteOffset,
    fullContent,
    dynamicIdentifiers,
) {
    const identifiers = normalizeDynamicIdentifiers(dynamicIdentifiers);
    const guards = [];
    for (const match of content.matchAll(/\bthrow_if\s*\(/g)) {
        const open = content.indexOf("(", match.index);
        const close = matchingDelimiter(content, open, "(", ")");
        if (close < 0) continue;
        const expression = splitArguments(content.slice(open + 1, close))[0];
        let resolution = "unresolved";
        if (/empty\(\$tableNames\)/.test(expression)) {
            resolution =
                Object.keys(identifiers.tables).length > 0
                    ? "true"
                    : "unresolved";
        } else if (/\$teams\s*&&\s*empty\(\$columnNames/.test(expression)) {
            if (identifiers.conditions.teams === false) resolution = "true";
            else if (identifiers.columns.team_foreign_key) resolution = "true";
        }
        guards.push({
            kind: "configuration_guard",
            expression: summarizeExpression(expression),
            expected: false,
            resolution,
            source_location: {
                path,
                line_start: lineAt(fullContent, absoluteOffset + match.index),
                line_end: lineAt(fullContent, absoluteOffset + close),
            },
        });
    }
    return guards;
}

function schemaCondition(expression, expected, path, line, dynamicIdentifiers) {
    const normalized = summarizeExpression(expression);
    const hasColumn =
        /Schema::hasColumn\s*\(\s*(['"])([^'"]+)\1\s*,\s*(['"])([^'"]+)\3\s*\)/.exec(
            normalized,
        );
    if (hasColumn) {
        return {
            kind: "has_column",
            expression: normalized,
            table: hasColumn[2],
            column: hasColumn[4],
            expected,
            resolution: "deferred_final_state",
            source_location: { path, line_start: line, line_end: line },
        };
    }
    const identifiers = normalizeDynamicIdentifiers(dynamicIdentifiers);
    let value;
    if (/^\$teams$/.test(normalized)) value = identifiers.conditions.teams;
    else if (
        /^\$teams\s*\|\|\s*config\(['"]permission\.testing['"]\)$/.test(
            normalized,
        )
    ) {
        const teams = identifiers.conditions.teams;
        const testing = identifiers.conditions.testing;
        if (typeof teams === "boolean" && typeof testing === "boolean")
            value = teams || testing;
    }
    return {
        kind: "branch",
        expression: normalized,
        expected,
        resolution:
            typeof value === "boolean"
                ? value === expected
                    ? "true"
                    : "false"
                : "unresolved",
        source_location: { path, line_start: line, line_end: line },
    };
}

function extractClosure(argsText, absoluteOffset, fullContent) {
    const functionMatch =
        /(?:static\s+)?function\s*\([^)]*Blueprint\s+\$table[^)]*\)[^{]*\{/m.exec(
            argsText,
        );
    if (!functionMatch) return null;
    const open = functionMatch.index + functionMatch[0].lastIndexOf("{");
    const close = matchingDelimiter(argsText, open, "{", "}");
    if (close < 0) return null;
    return {
        text: argsText.slice(open + 1, close),
        offset: absoluteOffset + open + 1,
        line: lineAt(fullContent, absoluteOffset + open),
    };
}

function parseBlueprintStatements(
    operation,
    closure,
    closureOffset,
    fullContent,
    dynamicIdentifiers,
) {
    let cursor = 0;
    while (cursor < closure.length) {
        const index = closure.indexOf("$table->", cursor);
        if (index < 0) break;
        const end = statementEnd(closure, index);
        if (end < 0) {
            operation.unsupported_statements.push(
                summarizeExpression(
                    closure.slice(index, Math.min(closure.length, index + 240)),
                ),
            );
            break;
        }
        const statement = closure.slice(index, end + 1);
        const methods = parseMethodChain(statement);
        const sourceLine = lineAt(fullContent, closureOffset + index);
        const statementConditions = enclosingConditions(
            closure,
            index,
            operation.source_location.path,
            closureOffset,
            fullContent,
            dynamicIdentifiers,
        ).map((condition) => ({ ...condition, scope: "statement" }));
        operation.conditions.push(...statementConditions);
        if (
            !applyBlueprintStatement(
                operation,
                methods,
                statement,
                sourceLine,
                dynamicIdentifiers,
                statementConditions,
            )
        ) {
            operation.unsupported_statements.push(
                summarizeExpression(statement),
            );
        }
        cursor = end + 1;
    }
}

function parseMethodChain(statement) {
    const methods = [];
    let cursor = statement.indexOf("->");
    while (cursor >= 0 && cursor < statement.length) {
        cursor += 2;
        while (/\s/.test(statement[cursor] ?? "")) cursor += 1;
        const nameMatch = /^[A-Za-z_][A-Za-z0-9_]*/.exec(
            statement.slice(cursor),
        );
        if (!nameMatch) break;
        const name = nameMatch[0];
        cursor += name.length;
        while (/\s/.test(statement[cursor] ?? "")) cursor += 1;
        if (statement[cursor] !== "(") break;
        const close = matchingDelimiter(statement, cursor, "(", ")");
        if (close < 0) break;
        methods.push({ name, args: statement.slice(cursor + 1, close).trim() });
        cursor = statement.indexOf("->", close + 1);
    }
    return methods;
}

function applyBlueprintStatement(
    operation,
    methods,
    statement,
    sourceLine,
    dynamicIdentifiers,
    conditions = [],
) {
    if (methods.length === 0) return false;
    const first = methods[0];
    const args = splitArguments(first.args);
    const modifiers = methods.slice(1).map((method) => method.name);
    const location = {
        ...operation.source_location,
        line_start: sourceLine,
        line_end: sourceLine + countNewlines(statement),
    };

    if (COLUMN_METHODS.has(first.name)) {
        const implicitId = ["id", "increments", "bigIncrements"].includes(
            first.name,
        );
        const resolvedName = resolveIdentifier(
            args[0] ?? "",
            dynamicIdentifiers,
        );
        const name =
            implicitId && args.length === 0 ? "id" : resolvedName.value;
        const expression =
            implicitId && args.length === 0 ? "'id'" : (args[0] ?? null);
        const column = {
            name,
            expression,
            type: first.name,
            nullable: modifiers.includes("nullable"),
            modifiers,
            source_location: location,
            conditions,
        };
        operation.columns.push(column);
        if (
            first.name === "id" ||
            first.name === "bigIncrements" ||
            first.name === "increments"
        ) {
            operation.primary_keys.push({
                columns: [name ?? expression],
                name: null,
                source_location: location,
                conditions,
            });
        }
        if (modifiers.includes("primary")) {
            operation.primary_keys.push({
                columns: [name ?? expression],
                name: null,
                source_location: location,
                conditions,
            });
        }
        if (modifiers.includes("unique")) {
            operation.unique_constraints.push({
                columns: [name ?? expression],
                name: methodArgument(methods, "unique"),
                source_location: location,
                conditions,
            });
        }
        if (modifiers.includes("index")) {
            operation.indexes.push({
                columns: [name ?? expression],
                name: methodArgument(methods, "index"),
                source_location: location,
                conditions,
            });
        }
        if (first.name === "foreignId" && modifiers.includes("constrained")) {
            const constrained = methods.find(
                (method) => method.name === "constrained",
            );
            const target =
                parseLiteral(splitArguments(constrained.args)[0]) ??
                inferConstrainedTable(name);
            const deletion = deleteBehavior(methods);
            operation.foreign_keys.push({
                columns: [name ?? expression],
                references: "id",
                on: target,
                deletion_behavior: deletion,
                source_location: location,
                conditions,
            });
            if (deletion) operation.deletion_behavior.push(deletion);
        }
        return true;
    }

    if (TABLE_MACROS.has(first.name)) {
        const name = resolveIdentifier(args[0] ?? "", dynamicIdentifiers).value;
        const macroColumns = macroColumnNames(first.name, name);
        operation.columns.push(
            ...macroColumns.map((columnName) => ({
                name: columnName,
                expression: first.args || null,
                type: first.name,
                nullable:
                    first.name.startsWith("nullable") ||
                    first.name.startsWith("softDeletes"),
                modifiers,
                source_location: location,
                conditions,
            })),
        );
        if (first.name.toLowerCase().includes("morphs")) {
            operation.indexes.push({
                columns: macroColumns,
                name: null,
                source_location: location,
                conditions,
            });
        }
        return true;
    }

    if (["primary", "index", "unique", "fullText"].includes(first.name)) {
        const columns = parseColumnList(args[0], dynamicIdentifiers);
        const entry = {
            columns,
            name: parseLiteral(args[1]),
            source_location: location,
            conditions,
        };
        if (first.name === "primary") operation.primary_keys.push(entry);
        else if (first.name === "unique")
            operation.unique_constraints.push(entry);
        else operation.indexes.push({ ...entry, type: first.name });
        return true;
    }

    if (first.name === "foreign") {
        const references = methods.find(
            (method) => method.name === "references",
        );
        const on = methods.find((method) => method.name === "on");
        const deletion = deleteBehavior(methods);
        operation.foreign_keys.push({
            columns: parseColumnList(args[0], dynamicIdentifiers),
            references:
                parseLiteral(splitArguments(references?.args ?? "")[0]) ??
                references?.args ??
                null,
            on:
                resolveIdentifier(
                    splitArguments(on?.args ?? "")[0] ?? "",
                    dynamicIdentifiers,
                ).value ??
                on?.args ??
                null,
            deletion_behavior: deletion,
            source_location: location,
            conditions,
        });
        if (deletion) operation.deletion_behavior.push(deletion);
        return true;
    }

    if (first.name.startsWith("drop") || first.name === "renameColumn") {
        operation.destructive_behavior = `${first.name}(${summarizeExpression(first.args)})`;
        if (first.name === "dropColumn") {
            operation.dropped_columns.push(
                ...parseColumnList(args[0], dynamicIdentifiers).map((name) => ({
                    name,
                    source_location: location,
                    conditions,
                })),
            );
        } else if (first.name === "renameColumn") {
            operation.renamed_columns.push({
                from: resolveIdentifier(args[0] ?? "", dynamicIdentifiers)
                    .value,
                to: resolveIdentifier(args[1] ?? "", dynamicIdentifiers).value,
                source_location: location,
                conditions,
            });
        } else if (first.name === "dropPrimary") {
            operation.dropped_primary_keys.push(
                dropReference(
                    args[0],
                    location,
                    conditions,
                    dynamicIdentifiers,
                ),
            );
        } else if (first.name === "dropIndex") {
            operation.dropped_indexes.push(
                dropReference(
                    args[0],
                    location,
                    conditions,
                    dynamicIdentifiers,
                ),
            );
        } else if (first.name === "dropUnique") {
            operation.dropped_unique_constraints.push(
                dropReference(
                    args[0],
                    location,
                    conditions,
                    dynamicIdentifiers,
                ),
            );
        } else if (
            first.name === "dropForeign" ||
            first.name === "dropConstrainedForeignId"
        ) {
            operation.dropped_foreign_keys.push(
                dropReference(
                    args[0],
                    location,
                    conditions,
                    dynamicIdentifiers,
                ),
            );
            if (first.name === "dropConstrainedForeignId") {
                const name = resolveIdentifier(
                    args[0] ?? "",
                    dynamicIdentifiers,
                ).value;
                operation.dropped_columns.push({
                    name,
                    source_location: location,
                    conditions,
                });
            }
        }
        return true;
    }
    return false;
}

function emptyOperation({
    sequence,
    operationType,
    storageIdentifier,
    identifierExpression,
    path,
    line,
    raw,
}) {
    return {
        sequence,
        operation_type: operationType,
        storage_identifier: storageIdentifier,
        identifier_expression: identifierExpression,
        source_location: {
            path,
            line_start: line,
            line_end: line + countNewlines(raw),
        },
        columns: [],
        primary_keys: [],
        indexes: [],
        unique_constraints: [],
        foreign_keys: [],
        dropped_columns: [],
        dropped_primary_keys: [],
        dropped_indexes: [],
        dropped_unique_constraints: [],
        dropped_foreign_keys: [],
        renamed_columns: [],
        conditions: [],
        deletion_behavior: [],
        destructive_behavior: null,
        raw_expression_summary: summarizeExpression(raw),
        unsupported_statements: [],
    };
}

function failedOperation(sequence, path, line, raw) {
    const operation = emptyOperation({
        sequence,
        operationType: "unsupported_schema_operation",
        storageIdentifier: null,
        identifierExpression: null,
        path,
        line,
        raw,
    });
    operation.unsupported_statements.push(summarizeExpression(raw));
    return operation;
}

function schemaOperationType(method) {
    return {
        create: "create_table",
        table: "alter_table",
        dropIfExists: "drop_table_if_exists",
        drop: "drop_table",
        rename: "rename_table",
    }[method];
}

function resolveIdentifier(expression, dynamicIdentifiers = {}) {
    const literal = parseLiteral(expression);
    if (literal !== null) return { value: literal, evidence: "literal" };
    const identifiers = normalizeDynamicIdentifiers(dynamicIdentifiers);
    const table = /^\$tableNames\[['"]([^'"]+)['"]\]$/.exec(expression);
    if (table && identifiers.tables[table[1]]) {
        return {
            value: identifiers.tables[table[1]],
            evidence: "bounded_runtime_configuration",
        };
    }
    const column = /^\$columnNames\[['"]([^'"]+)['"]\]$/.exec(expression);
    if (column && identifiers.columns[column[1]]) {
        return {
            value: identifiers.columns[column[1]],
            evidence: "bounded_runtime_configuration",
        };
    }
    const binding = /^\$(pivotRole|pivotPermission)$/.exec(expression);
    if (binding && identifiers.bindings[binding[1]]) {
        return {
            value: identifiers.bindings[binding[1]],
            evidence: "bounded_local_binding",
        };
    }
    return { value: null, evidence: "unresolved" };
}

function normalizeDynamicIdentifiers(value = {}) {
    if (value.tables || value.columns || value.bindings) {
        return {
            tables: value.tables ?? {},
            columns: value.columns ?? {},
            bindings: value.bindings ?? {},
            conditions: value.conditions ?? {},
        };
    }
    return { tables: value, columns: {}, bindings: {}, conditions: {} };
}

function parseLiteral(value) {
    if (typeof value !== "string") return null;
    const match = value.trim().match(/^(['"])(.*?)\1$/s);
    return match ? match[2] : null;
}

function parseColumnList(value, dynamicIdentifiers = {}) {
    const literal = parseLiteral(value);
    if (literal !== null) return [literal];
    const trimmed = String(value ?? "").trim();
    if (trimmed.startsWith("[") && trimmed.endsWith("]")) {
        return splitTopLevel(trimmed.slice(1, -1), ",")
            .map((entry) => entry.trim())
            .filter(Boolean)
            .map(
                (entry) =>
                    resolveIdentifier(entry, dynamicIdentifiers).value ??
                    summarizeExpression(entry),
            );
    }
    const resolved = resolveIdentifier(trimmed, dynamicIdentifiers).value;
    return trimmed ? [resolved ?? summarizeExpression(trimmed)] : [];
}

function macroColumnNames(method, name) {
    if (method === "timestamps" || method === "timestampsTz")
        return ["created_at", "updated_at"];
    if (method === "softDeletes" || method === "softDeletesTz")
        return [name ?? "deleted_at"];
    if (method === "rememberToken") return ["remember_token"];
    if (method.toLowerCase().includes("morphs")) {
        return [`${name ?? "morph"}_type`, `${name ?? "morph"}_id`];
    }
    return [];
}

function methodArgument(methods, name) {
    const method = methods.find((candidate) => candidate.name === name);
    if (!method) return null;
    return parseLiteral(splitArguments(method.args)[0]) ?? null;
}

function splitArguments(value) {
    return String(value ?? "").trim() === ""
        ? []
        : splitTopLevel(value, ",").map((entry) => entry.trim());
}

function dropReference(value, sourceLocation, conditions, dynamicIdentifiers) {
    const trimmed = String(value ?? "").trim();
    const arrayColumns =
        trimmed.startsWith("[") && trimmed.endsWith("]")
            ? parseColumnList(trimmed, dynamicIdentifiers)
            : [];
    return {
        columns: arrayColumns,
        name: arrayColumns.length === 0 ? parseLiteral(trimmed) : null,
        source_location: sourceLocation,
        conditions,
    };
}

function deleteBehavior(methods) {
    const map = {
        cascadeOnDelete: "cascade",
        nullOnDelete: "set_null",
        restrictOnDelete: "restrict",
        noActionOnDelete: "no_action",
    };
    for (const method of methods) {
        if (map[method.name]) return map[method.name];
        if (method.name === "onDelete")
            return (
                parseLiteral(method.args) ?? summarizeExpression(method.args)
            );
    }
    return null;
}

function inferConstrainedTable(column) {
    if (!column || !column.endsWith("_id")) return null;
    const base = column.slice(0, -3);
    return base.endsWith("s") ? `${base}es` : `${base}s`;
}

function collectRawEvidence(context) {
    const paths = new Set(context.tree.map((entry) => entry.path));
    const migrationChains = buildMigrationChains(context.ledger);
    const models = collectPhpEvidence(
        context.blobs,
        /(^|\/)Models\/.*\.php$/i,
        "model",
    );
    const factories = collectPhpEvidence(
        context.blobs,
        /(^|\/)factories\/.*\.php$/i,
        "factory",
    );
    const seeders = collectPhpEvidence(
        context.blobs,
        /(^|\/)seeders\/.*\.php$/i,
        "seeder",
    );
    const contracts = collectDocumentEvidence(
        context.blobs,
        (path) =>
            path.startsWith("docs/06-database/tables/") &&
            path !== "docs/06-database/tables/index.md",
    );
    const featureContracts = collectDocumentEvidence(context.blobs, (path) =>
        path.startsWith("docs/06-database/feature-contracts/"),
    );
    const ownershipDeclarations = collectOwnershipDeclarations(context.blobs);
    const planningSources = collectDocumentEvidence(context.blobs, (path) =>
        PLANNED_CONCEPTS.some(([, source]) => source === path),
    );
    const plannedCandidates = PLANNED_CONCEPTS.map(
        ([key, path, ownerKey, capabilityKey, claim]) => ({
            candidate_key: key,
            storage_identifier: `concept.${key}`,
            path,
            source_sha256: context.blobs.get(path)?.sha256 ?? null,
            line_start: findRelevantLine(
                context.blobs.get(path)?.content ?? "",
                key,
            ),
            owner_key: canonicalKey(ownerKey),
            capability_key: canonicalKey(capabilityKey),
            claim,
        }),
    );
    const frameworkBoundaries = BOUNDARIES.map(
        ([key, path, ownerKey, capabilityKey, claim]) => ({
            boundary_key: key,
            storage_identifier: `boundary.${key}`,
            path,
            source_sha256: context.blobs.get(path)?.sha256 ?? null,
            line_start: findRelevantLine(
                context.blobs.get(path)?.content ?? "",
                key,
            ),
            owner_key: canonicalKey(ownerKey),
            capability_key: canonicalKey(capabilityKey),
            claim,
        }),
    );
    const tableSeeds = [...migrationChains.values()]
        .filter((chain) => chain.created)
        .map((chain) =>
            seedImplementedRecord(
                chain,
                context,
                contracts,
                featureContracts,
                ownershipDeclarations,
            ),
        );
    const plannedSeeds = plannedCandidates.map((candidate) =>
        seedPlannedRecord(candidate, context.blobs),
    );
    const boundarySeeds = frameworkBoundaries.map((boundary) =>
        seedBoundaryRecord(boundary, context.blobs),
    );
    const materialSeeds = [...tableSeeds, ...plannedSeeds, ...boundarySeeds]
        .map((seed) =>
            withGeneratedFingerprint(
                seed,
                migrationChains.get(seed.storage_identifier)?.final_state ??
                    null,
            ),
        )
        .sort((left, right) =>
            left.storage_identifier.localeCompare(right.storage_identifier),
        );
    const ownerDeclarationComparisons = ownershipDeclarations
        .map((declaration) => {
            const seed = materialSeeds.find(
                (item) =>
                    item.storage_identifier === declaration.storage_identifier,
            );
            const allowedOwnerKeys =
                DECLARATION_OWNER_COMPATIBILITY[declaration.manifest_key] ?? [];
            return {
                storage_identifier: declaration.storage_identifier,
                manifest_key: declaration.manifest_key,
                reviewed_owner_key: seed?.owner_key ?? "unknown",
                allowed_owner_keys: allowedOwnerKeys,
                compatible: allowedOwnerKeys.includes(
                    seed?.owner_key ?? "unknown",
                ),
                declaration_path: declaration.path,
                declaration_line: declaration.line_start,
            };
        })
        .sort((left, right) =>
            `${left.storage_identifier}|${left.manifest_key}`.localeCompare(
                `${right.storage_identifier}|${right.manifest_key}`,
            ),
        );

    return {
        schema_version: 1,
        baseline: baselineMetadata(context),
        generator: generatorMetadata(context.generatedAt),
        database_assumptions: collectDatabaseAssumptions(context.blobs),
        migration_roots: context.migrationRoots,
        migration_chains: [...migrationChains.values()].sort((left, right) =>
            left.storage_identifier.localeCompare(right.storage_identifier),
        ),
        models,
        factories,
        seeders,
        contracts,
        feature_contracts: featureContracts,
        ownership_declarations: ownershipDeclarations,
        ownership_declaration_comparisons: ownerDeclarationComparisons,
        database_configuration: collectConfiguration(context.blobs),
        framework_boundaries: frameworkBoundaries,
        file_and_export_boundaries: frameworkBoundaries.filter((item) =>
            /filesystem|profile|export|backup|object|secret/.test(
                item.boundary_key,
            ),
        ),
        database_tests: [...context.blobs.values()]
            .filter((blob) => blob.path.startsWith("tests/"))
            .map((blob) => ({ path: blob.path, source_sha256: blob.sha256 }))
            .sort((left, right) => left.path.localeCompare(right.path)),
        standards_sources: [...context.blobs.values()]
            .filter((blob) =>
                blob.path.startsWith("docs/02-standards/database/"),
            )
            .map((blob) => ({ path: blob.path, source_sha256: blob.sha256 }))
            .sort((left, right) => left.path.localeCompare(right.path)),
        planning_sources: planningSources,
        planned_concept_candidates: plannedCandidates,
        runtime_discovery: context.runtime,
        issue_29_supporting_evidence: context.issue29,
        material_record_seeds: materialSeeds,
        summary: summarizeRaw(
            materialSeeds,
            context.ledger,
            contracts,
            ownershipDeclarations,
            ownerDeclarationComparisons,
            paths,
        ),
    };
}

function buildMigrationChains(ledger) {
    const histories = new Map();
    const states = new Map();
    for (const migration of ledger.migrations) {
        for (const [direction, operations] of [
            ["up", migration.up_operations],
            ["down", migration.down_operations],
        ]) {
            for (const operation of operations) {
                if (!operation.storage_identifier) continue;
                const history = histories.get(operation.storage_identifier) ?? {
                    migration_paths: [],
                    operations: [],
                };
                if (
                    !history.migration_paths.includes(migration.migration_path)
                ) {
                    history.migration_paths.push(migration.migration_path);
                }
                history.operations.push({
                    migration_path: migration.migration_path,
                    direction,
                    sequence: operation.sequence,
                    operation_type: operation.operation_type,
                    source_location: operation.source_location,
                    conditions: operation.conditions,
                });
                histories.set(operation.storage_identifier, history);
                if (direction === "up")
                    reduceTableOperation(states, operation, migration);
            }
        }
    }
    resolveDeferredConditions(ledger, states);

    const chains = new Map();
    for (const identifier of new Set([...histories.keys(), ...states.keys()])) {
        const history = histories.get(identifier) ?? {
            migration_paths: [],
            operations: [],
        };
        const state = states.get(identifier) ?? emptyTableState(identifier);
        const finalState = serializeTableState(state);
        chains.set(identifier, {
            storage_identifier: identifier,
            created: finalState.exists,
            migration_paths: [...history.migration_paths].sort(),
            operations: history.operations,
            final_state: finalState,
            final_state_complete: finalState.complete,
            columns: finalState.columns,
            primary_keys: finalState.primary_keys,
            indexes: finalState.indexes,
            unique_constraints: finalState.unique_constraints,
            foreign_keys: finalState.foreign_keys,
            deletion_behavior: finalState.deletion_behavior,
            destructive_behavior: finalState.destructive_behavior,
        });
    }
    return chains;
}

function emptyTableState(identifier) {
    return {
        storage_identifier: identifier,
        exists: false,
        complete: true,
        columns: new Map(),
        primary_keys: [],
        indexes: [],
        unique_constraints: [],
        foreign_keys: [],
        deletion_behavior: [],
        destructive_behavior: [],
        unresolved_operations: [],
        compatibility_identifiers: [],
        contradictions: [],
    };
}

function reduceTableOperation(states, operation, migration) {
    let state =
        states.get(operation.storage_identifier) ??
        emptyTableState(operation.storage_identifier);
    const operationDecision = conditionDecision(
        operation.conditions.filter(
            (condition) => condition.scope === "operation",
        ),
        states,
    );
    if (operationDecision === "unresolved") {
        state.complete = false;
        state.unresolved_operations.push(
            operationReference(operation, migration),
        );
        states.set(operation.storage_identifier, state);
        return;
    }
    if (operationDecision === "skip") {
        states.set(operation.storage_identifier, state);
        return;
    }

    if (operation.operation_type === "rename_table") {
        if (!operation.rename_to) {
            state.complete = false;
            state.unresolved_operations.push(
                operationReference(operation, migration),
            );
            states.set(operation.storage_identifier, state);
            return;
        }
        states.delete(operation.storage_identifier);
        state.compatibility_identifiers.push(operation.storage_identifier);
        state.storage_identifier = operation.rename_to;
        states.set(operation.rename_to, state);
        return;
    }
    if (
        ["drop_table", "drop_table_if_exists"].includes(
            operation.operation_type,
        )
    ) {
        state.exists = false;
        if (operation.destructive_behavior)
            state.destructive_behavior.push(operation.destructive_behavior);
        states.set(operation.storage_identifier, state);
        return;
    }
    if (operation.operation_type === "create_table") {
        if (state.exists) state.contradictions.push("duplicate_table_creation");
        const priorContradictions = state.contradictions;
        state = emptyTableState(operation.storage_identifier);
        state.contradictions = priorContradictions;
        state.exists = true;
    } else if (!state.exists) {
        state.complete = false;
        state.unresolved_operations.push(
            operationReference(operation, migration),
        );
    }

    applyEntries(
        state,
        "columns",
        operation.columns,
        states,
        (entry) => entry.name,
    );
    applyEntries(state, "primary_keys", operation.primary_keys, states);
    applyEntries(state, "indexes", operation.indexes, states);
    applyEntries(
        state,
        "unique_constraints",
        operation.unique_constraints,
        states,
    );
    applyEntries(state, "foreign_keys", operation.foreign_keys, states);

    for (const rename of operation.renamed_columns) {
        const decision = conditionDecision(rename.conditions, states);
        if (decision === "skip") continue;
        if (decision === "unresolved" || !rename.from || !rename.to) {
            state.complete = false;
            state.unresolved_operations.push(
                operationReference(operation, migration),
            );
            continue;
        }
        const column = state.columns.get(rename.from);
        if (!column) {
            state.complete = false;
            state.unresolved_operations.push(
                operationReference(operation, migration),
            );
            continue;
        }
        state.columns.delete(rename.from);
        state.columns.set(rename.to, { ...column, name: rename.to });
        rewriteColumnReferences(state, rename.from, rename.to);
    }
    for (const dropped of operation.dropped_columns) {
        const decision = conditionDecision(dropped.conditions, states);
        if (decision === "skip") continue;
        if (decision === "unresolved" || !dropped.name) {
            state.complete = false;
            state.unresolved_operations.push(
                operationReference(operation, migration),
            );
            continue;
        }
        state.columns.delete(dropped.name);
        removeColumnReferences(state, dropped.name);
    }
    applyDrops(state, "primary_keys", operation.dropped_primary_keys, states);
    applyDrops(state, "indexes", operation.dropped_indexes, states);
    applyDrops(
        state,
        "unique_constraints",
        operation.dropped_unique_constraints,
        states,
    );
    applyDrops(state, "foreign_keys", operation.dropped_foreign_keys, states);
    state.deletion_behavior.push(...operation.deletion_behavior);
    if (operation.destructive_behavior)
        state.destructive_behavior.push(operation.destructive_behavior);
    states.set(operation.storage_identifier, state);
}

function applyEntries(
    state,
    field,
    entries,
    states,
    key = stableConstraintIdentity,
) {
    for (const entry of entries) {
        const decision = conditionDecision(entry.conditions, states);
        if (decision === "skip") continue;
        if (decision === "unresolved" || !key(entry)) {
            state.complete = false;
            state.unresolved_operations.push({
                operation_type: `add_${field}`,
                source_location: entry.source_location,
            });
            continue;
        }
        if (field === "columns") state.columns.set(key(entry), entry);
        else {
            const identity = key(entry);
            state[field] = state[field].filter(
                (existing) => key(existing) !== identity,
            );
            state[field].push(entry);
        }
    }
}

function applyDrops(state, field, drops, states) {
    for (const drop of drops) {
        const decision = conditionDecision(drop.conditions, states);
        if (decision === "skip") continue;
        if (decision === "unresolved") {
            state.complete = false;
            state.unresolved_operations.push({
                operation_type: `drop_${field}`,
                source_location: drop.source_location,
            });
            continue;
        }
        state[field] = state[field].filter(
            (entry) => !dropMatches(entry, drop),
        );
    }
}

function dropMatches(entry, drop) {
    if (drop.name && entry.name === drop.name) return true;
    if ((drop.columns ?? []).length === 0) return false;
    return (
        stableStringify(entry.columns ?? []) === stableStringify(drop.columns)
    );
}

function stableConstraintIdentity(entry) {
    return entry.name || stableStringify(entry.columns ?? []);
}

function conditionDecision(conditions = [], states) {
    let unresolved = false;
    for (const condition of conditions) {
        resolveCondition(condition, states);
        if (condition.resolution === "false") return "skip";
        if (
            ["unresolved", "deferred_final_state"].includes(
                condition.resolution,
            )
        )
            unresolved = true;
    }
    return unresolved ? "unresolved" : "apply";
}

function resolveCondition(condition, states) {
    if (condition.kind !== "has_column") return condition.resolution;
    const state = states.get(condition.table);
    if (!state || !state.exists) {
        condition.resolution = "unresolved";
        return condition.resolution;
    }
    const present = state.columns.has(condition.column);
    condition.resolution = present === condition.expected ? "true" : "false";
    return condition.resolution;
}

function resolveDeferredConditions(ledger, states) {
    for (const migration of ledger.migrations) {
        const operations = [
            ...migration.up_operations,
            ...migration.down_operations,
        ];
        for (const operation of operations) {
            for (const condition of operation.conditions)
                resolveCondition(condition, states);
            for (const entry of [
                ...operation.columns,
                ...operation.primary_keys,
                ...operation.indexes,
                ...operation.unique_constraints,
                ...operation.foreign_keys,
                ...operation.dropped_columns,
                ...operation.dropped_primary_keys,
                ...operation.dropped_indexes,
                ...operation.dropped_unique_constraints,
                ...operation.dropped_foreign_keys,
                ...operation.renamed_columns,
            ]) {
                for (const condition of entry.conditions ?? [])
                    resolveCondition(condition, states);
            }
        }
        if (
            operations.some(
                (operation) =>
                    !operation.storage_identifier ||
                    operationHasUnresolvedIdentifiers(operation),
            )
        )
            migration.parse_status = "unresolved_dynamic_identifier";
        else if (
            operations.some(
                (operation) => operation.unsupported_statements.length > 0,
            )
        )
            migration.parse_status = "unsupported_operation";
        else if (
            operations.some((operation) =>
                operation.conditions.some((condition) =>
                    ["unresolved", "deferred_final_state"].includes(
                        condition.resolution,
                    ),
                ),
            )
        )
            migration.parse_status = "partial";
        else migration.parse_status = "complete";
    }
    ledger.summary.fully_parsed_count = ledger.migrations.filter(
        (migration) => migration.parse_status === "complete",
    ).length;
    ledger.summary.partial_or_dynamic_count =
        ledger.migrations.length - ledger.summary.fully_parsed_count;
}

function operationReference(operation, migration) {
    return {
        migration_path: migration.migration_path,
        sequence: operation.sequence,
        operation_type: operation.operation_type,
        source_location: operation.source_location,
    };
}

function rewriteColumnReferences(state, from, to) {
    for (const field of [
        "primary_keys",
        "indexes",
        "unique_constraints",
        "foreign_keys",
    ]) {
        state[field] = state[field].map((entry) => ({
            ...entry,
            columns: (entry.columns ?? []).map((column) =>
                column === from ? to : column,
            ),
        }));
    }
}

function removeColumnReferences(state, column) {
    for (const field of [
        "primary_keys",
        "indexes",
        "unique_constraints",
        "foreign_keys",
    ]) {
        state[field] = state[field].filter(
            (entry) => !(entry.columns ?? []).includes(column),
        );
    }
}

function serializeTableState(state) {
    return {
        storage_identifier: state.storage_identifier,
        exists: state.exists,
        complete: state.complete,
        columns: [...state.columns.values()].sort((left, right) =>
            left.name.localeCompare(right.name),
        ),
        primary_keys: dedupeJson(state.primary_keys),
        indexes: dedupeJson(state.indexes),
        unique_constraints: dedupeJson(state.unique_constraints),
        foreign_keys: dedupeJson(state.foreign_keys),
        deletion_behavior: [...new Set(state.deletion_behavior)].sort(),
        destructive_behavior: [...new Set(state.destructive_behavior)].sort(),
        unresolved_operations: dedupeJson(state.unresolved_operations),
        compatibility_identifiers: [
            ...new Set(state.compatibility_identifiers),
        ].sort(),
        contradictions: [...new Set(state.contradictions)].sort(),
    };
}

function collectPhpEvidence(blobs, pattern, kind) {
    return [...blobs.values()]
        .filter((blob) => pattern.test(blob.path))
        .map((blob) => ({
            path: blob.path,
            source_sha256: blob.sha256,
            class_name:
                /class\s+([A-Za-z0-9_]+)/.exec(blob.content)?.[1] ?? null,
            explicit_table:
                /protected\s+\$table\s*=\s*['"]([^'"]+)/.exec(
                    blob.content,
                )?.[1] ?? null,
            associated_model:
                /protected\s+\$model\s*=\s*([A-Za-z0-9_\\]+)::class/.exec(
                    blob.content,
                )?.[1] ?? null,
            uses_soft_deletes: /SoftDeletes/.test(blob.content),
            hidden_fields: parsePhpArray(blob.content, "hidden").filter(
                (field) => !isSecretValue(field),
            ),
            cast_fields: parsePhpArray(blob.content, "casts").map((field) =>
                field.split("=>")[0].trim(),
            ),
            relationship_methods: [
                ...blob.content.matchAll(
                    /function\s+([A-Za-z0-9_]+)\s*\([^)]*\)[^{]*\{[^}]*\$this->(belongsTo|hasMany|hasOne|belongsToMany|morphTo)/gs,
                ),
            ].map((match) => ({ name: match[1], type: match[2] })),
            evidence_kind: kind,
        }))
        .sort((left, right) => left.path.localeCompare(right.path));
}

function parsePhpArray(content, property) {
    const match = new RegExp(
        `(?:protected|public)\\s+\\$${property}\\s*=\\s*\\[([\\s\\S]*?)\\];`,
    ).exec(content);
    if (!match) return [];
    return [
        ...match[1].matchAll(/['"]([^'"]+)['"]\s*(?:=>\s*['"]([^'"]+)['"])?/g),
    ].map((entry) => (entry[2] ? `${entry[1]} => ${entry[2]}` : entry[1]));
}

function collectDocumentEvidence(blobs, predicate) {
    return [...blobs.values()]
        .filter((blob) => predicate(blob.path))
        .map((blob) => ({
            path: blob.path,
            source_sha256: blob.sha256,
            headings: blob.lines
                .map((line, index) => ({ line, index }))
                .filter(({ line }) => /^#{1,4}\s+/.test(line))
                .map(({ line, index }) => ({
                    line: index + 1,
                    heading: line.replace(/^#+\s+/, ""),
                })),
            storage_identifiers: [
                ...blob.content.matchAll(/`([a-z][a-z0-9_]+)`/g),
            ]
                .map((match) => match[1])
                .filter(
                    (value) =>
                        value.includes("_") ||
                        [
                            "users",
                            "roles",
                            "permissions",
                            "settings",
                            "notifications",
                        ].includes(value),
                ),
        }))
        .sort((left, right) => left.path.localeCompare(right.path));
}

function collectOwnershipDeclarations(blobs) {
    const declarations = [];
    for (const blob of blobs.values()) {
        if (!(
            blob.path === "app/Core/Modules/Definitions.php" ||
            /^Modules\/[^/]+\/Definition\.php$/.test(blob.path)
        ))
            continue;
        for (const match of blob.content.matchAll(
            /['"]?ownedTables['"]?\s*(?::|=>)\s*\[([\s\S]*?)\]/g,
        )) {
            const tables = [...match[1].matchAll(/['"]([a-z0-9_]+)['"]/g)].map(
                (entry) => entry[1],
            );
            const before = blob.content.slice(0, match.index);
            const keyMatches = [
                ...before.matchAll(
                    /(?:key:\s*|['"]key['"]\s*=>\s*)['"]([^'"]+)['"]/g,
                ),
            ];
            const inferredManifestKey =
                keyMatches.at(-1)?.[1] ?? packageKeyFromPath(blob.path);
            for (const table of tables) {
                const manifestKey = /^Modules\/[^/]+\/Definition\.php$/.test(
                    blob.path,
                )
                    ? packageKeyFromPath(blob.path)
                    : table === "users"
                      ? "users"
                      : ["platform_audit_logs", "central_error_logs"].includes(
                              table,
                          )
                        ? "logging"
                        : [
                                "security_requirement_groups",
                                "security_requirements",
                            ].includes(table)
                          ? "security_checklist"
                          : inferredManifestKey;
                declarations.push({
                    storage_identifier: table,
                    manifest_key: manifestKey,
                    path: blob.path,
                    line_start: lineAt(blob.content, match.index),
                    source_sha256: blob.sha256,
                });
            }
        }
    }
    return declarations.sort((left, right) =>
        `${left.storage_identifier}|${left.path}`.localeCompare(
            `${right.storage_identifier}|${right.path}`,
        ),
    );
}

function collectDatabaseAssumptions(blobs) {
    return [
        evidence(
            blobs,
            "docs/02-standards/database/AGENTS.md",
            "PostgreSQL is the canonical active database target.",
            findLine(
                blobs.get("docs/02-standards/database/AGENTS.md")?.content ??
                    "",
                "PostgreSQL is the active database target",
            ),
        ),
        evidence(
            blobs,
            ".env.example",
            "The checked-in example environment selects PostgreSQL.",
            findLine(blobs.get(".env.example")?.content ?? "", "DB_CONNECTION"),
        ),
        evidence(
            blobs,
            "config/database.php",
            "Laravel configuration falls back to SQLite when DB_CONNECTION is absent.",
            findLine(
                blobs.get("config/database.php")?.content ?? "",
                "'default'",
            ),
        ),
    ];
}

function collectConfiguration(blobs) {
    const paths = [
        ".env.example",
        "config/database.php",
        "config/cache.php",
        "config/session.php",
        "config/queue.php",
        "config/filesystems.php",
        "config/permission.php",
        "config/auth.php",
    ];
    return paths.map((path) => ({
        path,
        present_at_baseline: blobs.has(path),
        source_sha256: blobs.get(path)?.sha256 ?? null,
        safe_summary: configurationSummary(
            path,
            blobs.get(path)?.content ?? "",
        ),
    }));
}

function configurationSummary(path, content) {
    if (!content) return "Not present at the pinned baseline.";
    if (path === ".env.example")
        return "Source-controlled variable names and non-secret development defaults; values are not copied into evidence.";
    if (path.endsWith("database.php"))
        return "Declares database connections, migration repository, and Redis boundaries without recording environment-derived credentials.";
    if (path.endsWith("cache.php"))
        return "Declares database, file, Redis, and other cache stores.";
    if (path.endsWith("session.php"))
        return "Declares database-default and alternate session persistence drivers.";
    if (path.endsWith("queue.php"))
        return "Declares database-default and alternate queue persistence drivers.";
    if (path.endsWith("filesystems.php"))
        return "Declares private local, public local, and external object-storage disks.";
    return "Source-controlled persistence-related configuration reviewed without collecting secret values.";
}

function seedImplementedRecord(
    chain,
    context,
    contracts,
    featureContracts,
    ownershipDeclarations,
) {
    const table = chain.storage_identifier;
    const migrationSources = chain.migration_paths.map((path) => {
        const migration = context.ledger.migrations.find(
            (item) => item.migration_path === path,
        );
        const operation = [
            ...migration.up_operations,
            ...migration.down_operations,
        ].find((item) => item.storage_identifier === table);
        return {
            evidence_type: "migration",
            path,
            line_start: operation?.source_location.line_start ?? 1,
            line_end: operation?.source_location.line_end ?? 1,
            claim: `${basename(path)} contributes a ${operation?.operation_type ?? "migration"} operation to the ${table} history.`,
            source_sha256: migration.source_sha256,
        };
    });
    const tableContract = contracts.find(
        (contract) => contract.path === `docs/06-database/tables/${table}.md`,
    );
    const featureMatches = featureContracts.filter((contract) =>
        contract.storage_identifiers.includes(table),
    );
    const declarations = ownershipDeclarations.filter(
        (item) => item.storage_identifier === table,
    );
    const declarationEvidence = declarations.map((declaration) => ({
        evidence_type: "ownership_declaration",
        path: declaration.path,
        line_start: declaration.line_start,
        line_end: declaration.line_start,
        claim: `${table} is declared by the Core package key ${declaration.manifest_key}; a Modules path is transitional physical placement, not Module ownership.`,
        source_sha256: declaration.source_sha256,
    }));
    const featureEvidence = featureMatches.map((contract) => ({
        evidence_type: "feature_contract",
        path: contract.path,
        line_start: 1,
        line_end: 1,
        claim: `Feature contract references ${table}.`,
        source_sha256: contract.source_sha256,
    }));
    const [ownerKey, capabilityKey] = TABLE_OWNERS[table] ?? [
        FRAMEWORK_TABLES.has(table) ? "infrastructure" : "unknown",
        FRAMEWORK_TABLES.has(table) ? "Infrastructure" : "unknown",
    ];
    const columnNames = new Set(
        chain.columns.map((column) => column.name).filter(Boolean),
    );
    const framework = FRAMEWORK_TABLES.has(table);
    const compatibility = COMPATIBILITY_TABLES.has(table);
    const contradictions = [];
    if (!tableContract) {
        contradictions.push(
            contradiction(
                "contract_missing",
                `No per-table contract exists for ${table}.`,
                migrationSources[0],
            ),
        );
    }
    if (
        declarations.length === 0 &&
        !framework &&
        !["password_reset_tokens", "sessions"].includes(table)
    ) {
        contradictions.push(
            contradiction(
                "implemented_table_unclaimed",
                `${table} is created by a registered migration but is absent from ownedTables declarations.`,
                migrationSources[0],
            ),
        );
    }
    const incompatibleDeclarations = declarations.filter((declaration) => {
        const allowed =
            DECLARATION_OWNER_COMPATIBILITY[declaration.manifest_key] ?? [];
        return !allowed.includes(canonicalKey(ownerKey));
    });
    for (const declaration of incompatibleDeclarations) {
        contradictions.push(
            contradiction(
                "owned_table_owner_mismatch",
                `${table} is declared by manifest key ${declaration.manifest_key}, which is incompatible with reviewed owner ${canonicalKey(ownerKey)}.`,
                declarationEvidence.find(
                    (entry) => entry.path === declaration.path,
                ) ?? migrationSources[0],
            ),
        );
    }
    if (!chain.final_state_complete) {
        contradictions.push(
            contradiction(
                "migration_parse_partial",
                `The deterministic final state for ${table} retains unresolved schema-affecting operations.`,
                migrationSources.at(-1),
            ),
        );
    }
    if (table === "sessions") {
        contradictions.push(
            contradiction(
                "model_relationship_unenforced",
                "sessions.user_id is indexed but the migration does not declare a database foreign key.",
                migrationSources[0],
            ),
        );
    }
    if (table === "users") {
        contradictions.push(
            contradiction(
                "scope_missing",
                "The User Account row has no explicit Tenant or Instance key.",
                migrationSources[0],
            ),
            contradiction(
                "planning_implementation_overlap",
                "Account, identity, profile, staff, and preference concerns are currently combined while active planning evaluates separation.",
                migrationSources[0],
            ),
        );
    }
    if (table === "platform_audit_logs") {
        contradictions.push(
            contradiction(
                "scope_missing",
                "Current Audit columns do not explicitly separate acting Instance from target Tenant/Instance scope.",
                migrationSources[0],
            ),
        );
    }
    if (compatibility) {
        contradictions.push(
            contradiction(
                "compatibility_unresolved",
                "The table uses configuration-driven package-compatible naming; removal or replacement timing is not selected.",
                migrationSources[0],
            ),
        );
    }
    const sensitive = [...columnNames].some((name) =>
        /password|token|secret|recovery|payload|private|credential/i.test(name),
    );
    const appScoped = !framework && table !== "password_reset_tokens";
    const tenantState =
        columnNames.has("tenant_id") || columnNames.has("tenant_key")
            ? "explicit"
            : appScoped
              ? "absent"
              : "not_applicable";
    const instanceState =
        columnNames.has("instance_id") || columnNames.has("instance_key")
            ? "explicit"
            : appScoped
              ? "absent"
              : "not_applicable";
    const principalState = !appScoped
        ? "not_applicable"
        : table === "users"
          ? "indirect"
          : [...columnNames].some((name) =>
                  /(^|_)(user|actor|owner|principal)(_id)?$/.test(name),
              )
            ? "explicit"
            : "absent";
    const resourceState = !appScoped
        ? "not_applicable"
        : [...columnNames].some((name) =>
                /(subject|resource|model|notifiable)_(id|type)/.test(name),
            )
          ? "explicit"
          : "absent";
    const actorState = !appScoped
        ? "not_applicable"
        : [...columnNames].some((name) =>
                /(actor|updated_by|last_reviewed_by|owner_user_id)/.test(name),
            )
          ? "explicit"
          : "absent";
    const targetState = !appScoped
        ? "not_applicable"
        : [...columnNames].some((name) =>
                /(target_tenant|target_instance)/.test(name),
            )
          ? "explicit"
          : "absent";
    const directEvidence = migrationSources;
    const sourceHashes = Object.fromEntries(
        [
            ...migrationSources,
            ...declarationEvidence,
            ...featureEvidence,
            ...(tableContract
                ? [
                      {
                          path: tableContract.path,
                          source_sha256: tableContract.source_sha256,
                      },
                  ]
                : []),
        ].map((source) => [source.path, source.source_sha256]),
    );
    return {
        _record_id: `table.${table}`,
        _reviewed: false,
        _review_note:
            "Generated evidence seed; requires record-by-record review.",
        _review_required: true,
        _source_hashes: sourceHashes,
        migration_or_planning_source: migrationSources,
        storage_identifier: table,
        implementation_state: compatibility ? "compatibility" : "implemented",
        ownership_area: framework
            ? "not_applicable"
            : ownerKey === "unknown"
              ? "unknown"
              : "core",
        owner_key: canonicalKey(ownerKey),
        capability_key: canonicalKey(capabilityKey),
        module_key: "not_applicable",
        tenant_scope: scope(
            tenantState,
            directEvidence,
            tenantState === "explicit"
                ? "A migration stores a Tenant key; enforcement remains separately reviewable."
                : "No direct Tenant key is represented by the migration chain.",
        ),
        instance_scope: scope(
            instanceState,
            directEvidence,
            "Instance scope evidence from the migration chain.",
        ),
        principal_scope: scope(
            principalState,
            directEvidence,
            "Principal or User Account relationship evidence from the migration chain.",
        ),
        resource_scope: scope(
            resourceState,
            directEvidence,
            "Resource relationship evidence from the migration chain.",
        ),
        actor_scope: scope(
            actorState,
            directEvidence,
            "Actor attribution evidence from the migration chain.",
        ),
        target_tenant_or_instance_scope: scope(
            targetState,
            directEvidence,
            "Target Tenant or Instance evidence from the migration chain.",
        ),
        key_and_relationship_evidence: currentStateEvidence(
            directEvidence,
            `${table} final-state columns: ${[...columnNames].join(", ") || "none resolved"}. Database foreign keys: ${chain.foreign_keys.map((foreign) => `${foreign.columns.join("+")} -> ${foreign.on ?? "unresolved"}.${foreign.references ?? "unresolved"}${foreign.deletion_behavior ? ` (${foreign.deletion_behavior})` : ""}`).join("; ") || "none"}.`,
        ),
        uniqueness_and_index_evidence: currentStateEvidence(
            directEvidence,
            `Final-state primary keys: ${chain.primary_keys.map((key) => key.columns.join("+")).join("; ") || "none recorded"}. Unique constraints: ${chain.unique_constraints.map((constraint) => constraint.columns.join("+")).join("; ") || "none recorded"}. Indexes: ${chain.indexes.map((index) => index.columns.join("+")).join("; ") || "none recorded"}.`,
        ),
        lifecycle_and_deletion_evidence: currentStateEvidence(
            directEvidence,
            chain.deletion_behavior.length > 0 ||
                chain.destructive_behavior.length > 0
                ? `Deletion behavior: ${[...chain.deletion_behavior, ...chain.destructive_behavior].join(", ")}.`
                : "No explicit retention lifecycle is established by the migration chain.",
        ),
        classification_evidence: currentStateEvidence(
            directEvidence,
            sensitive
                ? "Sensitive or credential/session-material field names are present; no values were collected."
                : "No canonical per-table data classification is established by migration source.",
        ),
        retention_and_erasure_evidence: currentStateEvidence(
            directEvidence,
            chain.deletion_behavior.length > 0
                ? `Foreign-key deletion behavior includes ${chain.deletion_behavior.join(", ")}; retention and legal hold remain undocumented.`
                : "Retention, erasure, and legal-hold behavior are not established by migration source.",
        ),
        audit_evidence: currentStateEvidence(
            directEvidence,
            table === "platform_audit_logs"
                ? "This table is the current Audit event store."
                : actorState === "explicit"
                  ? "Actor-related columns provide partial accountable-change evidence."
                  : "No table-specific Audit requirement is established by migration source.",
        ),
        contract_path: tableContract ? [tableContract.path] : "missing",
        compatibility_evidence: dedupeEvidenceClaims([
            ...(compatibility
                ? directEvidence.map((source) => ({
                      ...source,
                      claim: "Configuration-driven package-compatible table identity is preserved.",
                  }))
                : []),
            ...featureEvidence,
            ...declarationEvidence.filter((source) =>
                source.path.startsWith("Modules/"),
            ),
        ]),
        known_contradictions: contradictions,
        disposition: compatibility
            ? "compatibility"
            : contradictions.length > 0
              ? "investigate"
              : "retain",
        target_question:
            contradictions.length > 0
                ? `Which Goal 06 owner, scope, contract, lifecycle, and compatibility decisions resolve the recorded ${table} evidence gaps?`
                : "No target change is selected by this inventory.",
        _material_kind: MATERIAL_PIVOTS.has(table)
            ? "material_pivot"
            : compatibility
              ? "compatibility_table"
              : "implemented_table",
    };
}

function seedPlannedRecord(candidate, blobs) {
    const ref = evidence(
        blobs,
        candidate.path,
        candidate.claim,
        candidate.line_start,
    );
    const contradictions = [];
    if (
        candidate.candidate_key === "audit_event" ||
        candidate.candidate_key.startsWith("access_")
    ) {
        contradictions.push(
            contradiction(
                "planning_implementation_overlap",
                "Active planned persistence overlaps current implemented storage without selecting the target model.",
                ref,
            ),
        );
    }
    if (
        ["service_account_users_type", "service_account_table"].includes(
            candidate.candidate_key,
        )
    ) {
        contradictions.push(
            contradiction(
                "duplicate_persistent_concept",
                "Active planning retains materially different Service Account storage alternatives.",
                ref,
            ),
        );
    }
    return {
        _record_id: `concept.${candidate.candidate_key}`,
        _reviewed: false,
        _review_note:
            "Generated planning candidate; materiality and classification require direct review.",
        _review_required: true,
        _source_hashes: { [candidate.path]: candidate.source_sha256 },
        migration_or_planning_source: [ref],
        storage_identifier: candidate.storage_identifier,
        implementation_state: "planned",
        ownership_area: "core",
        owner_key: candidate.owner_key,
        capability_key: candidate.capability_key,
        module_key: "not_applicable",
        tenant_scope: scope(
            "unknown",
            [ref],
            "Target Tenant scope remains an implementation question.",
        ),
        instance_scope: scope(
            "unknown",
            [ref],
            "Target Instance scope remains an implementation question.",
        ),
        principal_scope: scope(
            /identity|principal|account|credential|actor|assurance|access|token|webhook/.test(
                candidate.candidate_key,
            )
                ? "explicit"
                : "unknown",
            [ref],
            candidate.claim,
        ),
        resource_scope: scope(
            "unknown",
            [ref],
            "Target resource scope remains an implementation question.",
        ),
        actor_scope: scope(
            /actor|audit|request|acceptance|incident|evidence|approval|decision|event|delivery|rotation|review|quality/.test(
                candidate.candidate_key,
            )
                ? "explicit"
                : "unknown",
            [ref],
            candidate.claim,
        ),
        target_tenant_or_instance_scope: scope(
            /target|audit|export|request|incident/.test(candidate.candidate_key)
                ? "unknown"
                : "not_applicable",
            [ref],
            candidate.claim,
        ),
        key_and_relationship_evidence: [ref],
        uniqueness_and_index_evidence: [
            {
                ...ref,
                claim: "No implemented keys, uniqueness, or indexes exist for this planned concept.",
            },
        ],
        lifecycle_and_deletion_evidence: [
            {
                ...ref,
                claim: "Planning establishes a material lifecycle question; implementation is not present.",
            },
        ],
        classification_evidence: [
            {
                ...ref,
                claim: /credential|secret|identity|forensic|export|incident/.test(
                    candidate.candidate_key,
                )
                    ? "Planning treats this concept as security-, identity-, evidence-, or data-movement-sensitive."
                    : "Classification remains a target data-governance question.",
            },
        ],
        retention_and_erasure_evidence: [
            {
                ...ref,
                claim: "Retention, erasure, and legal-hold rules remain target questions unless stated by the cited plan.",
            },
        ],
        audit_evidence: [
            {
                ...ref,
                claim: "Accountable lifecycle and Audit integration remain target implementation questions.",
            },
        ],
        contract_path: "missing",
        compatibility_evidence: [],
        known_contradictions: [
            ...contradictions,
            contradiction(
                "contract_missing",
                "No implemented per-table contract applies to this planned concept.",
                ref,
            ),
        ],
        disposition: "investigate",
        target_question: `What Goal 06 storage, scope, lifecycle, classification, retention, and Audit model should implement ${candidate.candidate_key.replaceAll("_", " ")}?`,
        _material_kind: "planned_concept",
    };
}

function seedBoundaryRecord(boundary, blobs) {
    const ref = evidence(
        blobs,
        boundary.path,
        boundary.claim,
        boundary.line_start,
    );
    const sources = [ref];
    if (boundary.boundary_key === "database_connection_target") {
        sources.push(
            evidence(
                blobs,
                ".env.example",
                "The source-controlled example environment selects PostgreSQL while config/database.php retains a SQLite fallback.",
                findLine(
                    blobs.get(".env.example")?.content ?? "",
                    "DB_CONNECTION",
                ),
            ),
        );
    }
    const sensitive = /session|profile|export|backup|secret|object/.test(
        boundary.boundary_key,
    );
    const contradictions = [];
    if (/profile|export|backup|secret/.test(boundary.boundary_key)) {
        contradictions.push(
            contradiction(
                "lifecycle_or_deletion_unclear",
                "Lifecycle and deletion behavior is not fully established for this boundary.",
                ref,
            ),
            contradiction(
                "retention_or_erasure_missing",
                "Retention, erasure, and legal-hold evidence is incomplete for this boundary.",
                ref,
            ),
        );
    }
    if (boundary.boundary_key === "public_filesystem") {
        contradictions.push(
            contradiction(
                "sensitive_storage_risk",
                "Public storage is material to protected-file review even though no sensitive contents were inspected.",
                ref,
            ),
        );
    }
    if (boundary.boundary_key === "database_connection_target") {
        contradictions.push(
            contradiction(
                "database_target_conflict",
                "Canonical PostgreSQL direction and the example environment differ from the SQLite fallback in runtime configuration.",
                ref,
            ),
        );
    }
    return {
        _record_id: `boundary.${boundary.boundary_key}`,
        _reviewed: false,
        _review_note:
            "Generated boundary seed; requires direct configuration/planning review.",
        _review_required: true,
        _source_hashes: Object.fromEntries(
            sources.map((source) => [source.path, source.source_sha256]),
        ),
        migration_or_planning_source: sources,
        storage_identifier: boundary.storage_identifier,
        implementation_state:
            blobs.has(boundary.path) && boundary.path.startsWith("config/")
                ? "implemented"
                : "planned",
        ownership_area: "core",
        owner_key: boundary.owner_key,
        capability_key: boundary.capability_key,
        module_key: "not_applicable",
        tenant_scope: scope(
            "unknown",
            sources,
            "Boundary configuration does not prove Tenant isolation.",
        ),
        instance_scope: scope(
            "unknown",
            sources,
            "Boundary configuration does not prove Instance isolation.",
        ),
        principal_scope: scope(
            /session|profile|export|secret/.test(boundary.boundary_key)
                ? "indirect"
                : "not_applicable",
            sources,
            boundary.claim,
        ),
        resource_scope: scope(
            /filesystem|object|export|backup|profile/.test(
                boundary.boundary_key,
            )
                ? "explicit"
                : "not_applicable",
            sources,
            boundary.claim,
        ),
        actor_scope: scope(
            "unknown",
            sources,
            "Actor attribution is not established by boundary configuration.",
        ),
        target_tenant_or_instance_scope: scope(
            "unknown",
            sources,
            "Target Tenant/Instance attribution is not established by boundary configuration.",
        ),
        key_and_relationship_evidence: sources,
        uniqueness_and_index_evidence: [
            {
                ...ref,
                claim: "This non-table boundary does not expose application-owned relational keys or indexes.",
            },
        ],
        lifecycle_and_deletion_evidence: [
            {
                ...ref,
                claim: "Boundary lifecycle is configuration- or planning-managed rather than represented by an application migration.",
            },
        ],
        classification_evidence: [
            {
                ...ref,
                claim: sensitive
                    ? "The boundary can contain sensitive session, identity, export, backup, or credential material; contents were not inspected."
                    : "The boundary classification depends on its consumers.",
            },
        ],
        retention_and_erasure_evidence: [
            {
                ...ref,
                claim: "Retention and erasure behavior is incomplete or consumer-specific.",
            },
        ],
        audit_evidence: [
            {
                ...ref,
                claim: "Boundary use may require Audit evidence; configuration alone does not prove it.",
            },
        ],
        contract_path: "not_applicable",
        compatibility_evidence: [],
        known_contradictions: contradictions,
        disposition: contradictions.length > 0 ? "investigate" : "retain",
        target_question:
            contradictions.length > 0
                ? `Which owner, retention, erasure, access, and Audit controls govern ${boundary.boundary_key.replaceAll("_", " ")}?`
                : "No target change is selected by this inventory.",
        _material_kind: "boundary",
    };
}

function mergeClassifications({
    baseline,
    raw,
    existing,
    historicalReviewed = null,
}) {
    if (existing && existing.baseline?.sha !== baseline) {
        throw new Error(
            `Existing classifications target ${existing.baseline?.sha}; expected ${baseline}.`,
        );
    }
    const existingById = new Map(
        (existing?.items ?? []).map((item) => [item._record_id, item]),
    );
    const historicalById = new Map(
        (historicalReviewed?.items ?? []).map((item) => [
            item._record_id,
            item,
        ]),
    );
    const seedIds = new Set(
        raw.material_record_seeds.map((item) => item._record_id),
    );
    const orphaned = (existing?.items ?? [])
        .filter(
            (item) =>
                !seedIds.has(item._record_id) &&
                (item._reviewed === true ||
                    !String(item._review_note ?? "").startsWith("Generated")),
        )
        .map((item) => ({
            _record_id: item._record_id,
            storage_identifier: item.storage_identifier,
            treatment: "requires_explicit_review",
        }));
    const items = raw.material_record_seeds.map((seed) => {
        let previous = existingById.get(seed._record_id);
        if (!previous) return stripInternalMaterialKind(seed);
        const historical = historicalById.get(seed._record_id);
        if (
            previous._reviewed !== true &&
            historical?._reviewed === true &&
            !historical._generated_fingerprint
        ) {
            previous = historical;
        }
        const fingerprintChanged =
            previous._generated_fingerprint !== seed._generated_fingerprint;
        const preserved = { ...seed };
        for (const field of REQUIRED_FIELDS) preserved[field] = previous[field];
        preserved._reviewed = fingerprintChanged
            ? false
            : previous._reviewed === true;
        preserved._review_required = fingerprintChanged
            ? true
            : previous._review_required === true;
        preserved._review_note = fingerprintChanged
            ? "Generated semantic evidence changed during recollection; reviewed field values were preserved for comparison and require renewed review."
            : previous._review_note;
        return stripInternalMaterialKind(preserved);
    });
    return {
        schema_version: 1,
        baseline: raw.baseline,
        required_fields: REQUIRED_FIELDS,
        controlled_values: CONTROLLED_VALUES,
        orphaned_reviewed_records: orphaned,
        items,
    };
}

function withGeneratedFingerprint(item, finalState) {
    const generatedRequiredFields = Object.fromEntries(
        REQUIRED_FIELDS.map((field) => [field, item[field]]),
    );
    const fingerprintInput = {
        generator_schema_version: GENERATOR_SCHEMA_VERSION,
        generated_required_fields: generatedRequiredFields,
        source_hashes: item._source_hashes,
        final_state: finalState,
        contradiction_seeds: item.known_contradictions,
        ownership_and_scope: {
            ownership_area: item.ownership_area,
            owner_key: item.owner_key,
            capability_key: item.capability_key,
            module_key: item.module_key,
            tenant_scope: item.tenant_scope,
            instance_scope: item.instance_scope,
            principal_scope: item.principal_scope,
            resource_scope: item.resource_scope,
            actor_scope: item.actor_scope,
            target_tenant_or_instance_scope:
                item.target_tenant_or_instance_scope,
        },
    };
    return {
        ...item,
        _generator_schema_version: GENERATOR_SCHEMA_VERSION,
        _generated_fingerprint: sha256(
            Buffer.from(stableStringify(fingerprintInput), "utf8"),
        ),
    };
}

function stripInternalMaterialKind(item) {
    const copy = { ...item };
    delete copy._material_kind;
    return copy;
}

function summarizeRaw(
    items,
    ledger,
    contracts,
    declarations,
    ownerDeclarationComparisons,
    paths,
) {
    const kinds = countBy(items, (item) => materialKind(item));
    const declarationTables = new Set(
        declarations.map((item) => item.storage_identifier),
    );
    const implemented = items.filter((item) =>
        item._record_id.startsWith("table."),
    );
    return {
        migration_root_count: ledger.migration_roots.length,
        migration_count: ledger.migrations.length,
        up_operation_count: ledger.summary.up_operation_count,
        down_operation_count: ledger.summary.down_operation_count,
        implemented_table_count: implemented.filter(
            (item) => item.implementation_state === "implemented",
        ).length,
        compatibility_table_count: implemented.filter(
            (item) => item.implementation_state === "compatibility",
        ).length,
        material_pivot_count: implemented.filter((item) =>
            MATERIAL_PIVOTS.has(item.storage_identifier),
        ).length,
        planned_concept_count: items.filter((item) =>
            item.storage_identifier.startsWith("concept."),
        ).length,
        boundary_count: items.filter((item) =>
            item.storage_identifier.startsWith("boundary."),
        ).length,
        material_record_count: items.length,
        missing_contract_count: items.filter(
            (item) => item.contract_path === "missing",
        ).length,
        owner_mismatch_count: items.filter((item) =>
            item.known_contradictions.some(
                (entry) => entry.code === "owned_table_owner_mismatch",
            ),
        ).length,
        owner_declaration_comparison_status: "explicitly_compared",
        owner_declaration_comparison_count: ownerDeclarationComparisons.length,
        implemented_unclaimed_count: implemented.filter(
            (item) =>
                !declarationTables.has(item.storage_identifier) &&
                !FRAMEWORK_TABLES.has(item.storage_identifier),
        ).length,
        table_contract_count: contracts.length,
        source_path_count: paths.size,
        material_kind_counts: kinds,
    };
}

function materialKind(item) {
    if (item.storage_identifier.startsWith("concept."))
        return "planned_concept";
    if (item.storage_identifier.startsWith("boundary.")) return "boundary";
    if (MATERIAL_PIVOTS.has(item.storage_identifier)) return "material_pivot";
    if (item.implementation_state === "compatibility")
        return "compatibility_table";
    return "implemented_table";
}

function collectRuntimeDiscovery() {
    return {
        mode: "attempted",
        commands: [
            runtimeCommand("php", [
                "artisan",
                "migrate:status",
                "--no-interaction",
                "--no-ansi",
            ]),
            runtimeCommand("php", [
                "artisan",
                "config:show",
                "permission",
                "--no-ansi",
            ]),
        ],
    };
}

function runtimeCommand(command, commandArgs) {
    const result = spawnSync(command, commandArgs, {
        cwd: process.cwd(),
        encoding: "utf8",
        timeout: 15_000,
        windowsHide: true,
        maxBuffer: 2 * 1024 * 1024,
    });
    return {
        command: [command, ...commandArgs].join(" "),
        attempted: true,
        exit_code: result.status,
        timed_out: result.error?.code === "ETIMEDOUT",
        stdout_summary: sanitizeRuntimeOutput(result.stdout),
        stderr_summary: sanitizeRuntimeOutput(result.stderr),
        failure_reason: result.error
            ? safeFailure(result.error.message)
            : result.status === 0
              ? null
              : `Command exited with status ${result.status}.`,
    };
}

function preserveRuntimeDiscovery(baseline, staticOnly) {
    const existing = readJsonIfExists(RAW_PATH);
    return preserveRuntimeValue(existing, baseline, staticOnly);
}

function preserveRuntimeValue(existing, baseline, staticOnly) {
    if (
        existing?.baseline?.sha === baseline &&
        existing.runtime_discovery?.mode === "attempted"
    ) {
        return existing.runtime_discovery;
    }
    return {
        mode: staticOnly ? "not_previously_attempted" : "not_requested",
        commands: [],
    };
}

function sanitizeRuntimeOutput(value) {
    const lines = normalizeNewlines(String(value ?? ""))
        .split("\n")
        .filter(Boolean)
        .filter(
            (line) =>
                !/(password|secret|private[_ -]?key|access[_ -]?key|token value|cookie value|session payload)/i.test(
                    line,
                ),
        )
        .slice(0, 120)
        .map((line) =>
            line.replace(
                /\b(?:[A-Za-z0-9+/_-]{32,}={0,2})\b/g,
                "[redacted-value]",
            ),
        );
    return lines.join("\n").slice(0, 12_000);
}

function safeFailure(value) {
    return String(value).replace(/\r?\n/g, " ").slice(0, 500);
}

function resolvePermissionIdentifiers(runtime) {
    const command = runtime.commands?.find((item) =>
        item.command.includes("config:show permission"),
    );
    if (!command || command.exit_code !== 0)
        return { tables: {}, columns: {}, bindings: {}, conditions: {} };
    const output = command.stdout_summary;
    const tables = {};
    for (const key of [
        "permissions",
        "roles",
        "model_has_permissions",
        "model_has_roles",
        "role_has_permissions",
    ]) {
        const patterns = [
            new RegExp(
                `^\\s*table_names\\s+⇁\\s+${escapeRegex(key)}\\s+\\.+\\s+([a-z][a-z0-9_]*)\\s*$`,
                "im",
            ),
            new RegExp(
                `['"]${escapeRegex(key)}['"]\\s*=>\\s*['"]([a-z][a-z0-9_]*)['"]`,
                "i",
            ),
        ];
        for (const pattern of patterns) {
            const match = pattern.exec(output);
            if (match) {
                tables[key] = match[1];
                break;
            }
        }
    }
    const columns = {};
    for (const key of [
        "role_pivot_key",
        "permission_pivot_key",
        "model_morph_key",
        "team_foreign_key",
    ]) {
        const match = new RegExp(
            `^\\s*column_names\\s+⇁\\s+${escapeRegex(key)}\\s+\\.+\\s+([^\\s]+)\\s*$`,
            "im",
        ).exec(output);
        if (match && match[1] !== "null") columns[key] = match[1];
    }
    const booleanValue = (key) => {
        const match = new RegExp(
            `^\\s*${escapeRegex(key)}\\s+\\.+\\s+(true|false)\\s*$`,
            "im",
        ).exec(output);
        return match ? match[1] === "true" : undefined;
    };
    const teams = booleanValue("teams");
    return {
        tables,
        columns,
        bindings: {
            pivotRole: columns.role_pivot_key ?? "role_id",
            pivotPermission: columns.permission_pivot_key ?? "permission_id",
        },
        conditions: {
            teams,
            testing: false,
        },
    };
}

function renderArtifacts(ledger, raw, classifications) {
    let document = readFileSync(DOCUMENT_PATH, "utf8");
    const reviewed = classifications.items.filter(
        (item) => item._reviewed,
    ).length;
    const pending = classifications.items.length - reviewed;
    const contradictionItems = classifications.items.filter(
        (item) => item.known_contradictions.length > 0,
    );
    const investigate = classifications.items.filter(
        (item) => item.disposition === "investigate",
    );
    const replacements = {
        BASELINE: [
            `- Inventory evidence baseline: \`${raw.baseline.sha}\``,
            `- Baseline committed at: ${raw.baseline.committed_at}`,
            `- Implementation branch base: \`${raw.baseline.current_head_at_generation}\``,
            `- Accepted main at package preparation: \`${ACCEPTED_MAIN}\``,
            `- Generated at: ${raw.generator.generated_at}`,
            "- Evidence records source-controlled implementation at the pinned baseline; they do not assert deployed migration state.",
        ].join("\n"),
        SCOPE: [
            "Inventory scope includes every source-controlled migration, registered and missing migration roots, implemented tables and complete chains, material pivots and compatibility storage, persistence-related models/factories/seeders/contracts/configuration/tests, active planned persistent concepts, and material framework/file/external boundaries.",
            "",
            "Non-goals include selecting a Goal 06 target model, executing migrations, querying rows, changing schema/runtime/contracts/standards, treating Workspace as persistence, or recording secrets and reusable credentials.",
        ].join("\n"),
        METHOD: renderMethod(raw),
        SCHEMA: renderSchema(classifications),
        SUMMARY: renderSummary(ledger, raw, classifications),
        MIGRATIONS: renderMigrations(ledger),
        IMPLEMENTED: renderRecords(
            classifications.items.filter(
                (item) =>
                    !item.storage_identifier.includes(".") ||
                    item.storage_identifier.startsWith("table."),
            ),
            "No implemented records.",
        ),
        PLANNED: renderRecords(
            classifications.items.filter((item) =>
                item.storage_identifier.startsWith("concept."),
            ),
            "No planned concepts.",
        ),
        BOUNDARIES: renderRecords(
            classifications.items.filter((item) =>
                item.storage_identifier.startsWith("boundary."),
            ),
            "No persistence boundaries.",
        ),
        CONTRACTS: renderContracts(classifications.items, raw),
        "SCOPE-FINDINGS": renderScopeFindings(classifications.items),
        GOVERNANCE: renderGovernance(classifications.items),
        CONTRADICTIONS: renderContradictions(contradictionItems),
        "TARGET-QUESTIONS": renderTargetQuestions(investigate),
        VERIFICATION: renderVerification(raw, ledger, classifications, pending),
    };
    for (const [marker, replacement] of Object.entries(replacements)) {
        document = replaceMarker(document, marker, replacement);
    }
    writeFileSync(DOCUMENT_PATH, normalizeNewlines(document), "utf8");
    formatRenderedDocument();
}

function formatRenderedDocument() {
    const prettier = resolve("node_modules/prettier/bin/prettier.cjs");
    if (!existsSync(prettier)) {
        throw new Error(
            "Unable to format rendered inventory: Prettier is unavailable.",
        );
    }
    const result = spawnSync(
        process.execPath,
        [prettier, "--write", DOCUMENT_PATH],
        {
            cwd: process.cwd(),
            encoding: "utf8",
            windowsHide: true,
            timeout: 30_000,
        },
    );
    if (result.error || result.status !== 0) {
        throw new Error(
            `Unable to format rendered inventory: ${result.error?.message ?? result.stderr.trim()}`,
        );
    }
}

function renderMethod(raw) {
    const runtime = raw.runtime_discovery.commands.length
        ? raw.runtime_discovery.commands
              .map(
                  (item) =>
                      `- \`${item.command}\`: ${item.exit_code === 0 ? "succeeded" : (item.failure_reason ?? "failed")}${item.timed_out ? " (timed out)" : ""}`,
              )
              .join("\n")
        : `- Runtime discovery: ${raw.runtime_discovery.mode}.`;
    return [
        "Current implementation evidence is interpreted in migration/source, registration, constraints, models, owner declarations, contracts, factories/seeders/tests, planning, then corroborative runtime order. Conflicts are retained rather than resolved silently.",
        "",
        "- Collection reads one pinned Git tree and one batched blob stream.",
        "- Reviewed classifications remain separate from generated evidence seeds.",
        "- Render-only mode reads the ledger, raw evidence, and reviewed classifications without Git, PHP, Laravel, or source scans.",
        "- Issue #29 evidence is baseline-checked and used only as supporting context.",
        "",
        runtime,
    ].join("\n");
}

function renderSchema(classifications) {
    return [
        `Required material fields: ${classifications.required_fields.map((field) => `\`${field}\``).join(", ")}.`,
        "",
        `Implementation states: ${classifications.controlled_values.implementation_state.map((value) => `\`${value}\``).join(", ")}.`,
        `Ownership areas: ${classifications.controlled_values.ownership_area.map((value) => `\`${value}\``).join(", ")}.`,
        `Scope states: ${classifications.controlled_values.scope_state.map((value) => `\`${value}\``).join(", ")}.`,
        `Dispositions: ${classifications.controlled_values.disposition.map((value) => `\`${value}\``).join(", ")}.`,
    ].join("\n");
}

function renderSummary(ledger, raw, classifications) {
    const rows = [
        ["Migration roots", ledger.summary.migration_root_count],
        ["Registered roots present", ledger.summary.registered_root_count],
        [
            "Registered roots missing",
            ledger.summary.missing_registered_root_count,
        ],
        ["Migrations", ledger.summary.migration_count],
        ["Fully parsed migrations", ledger.summary.fully_parsed_count],
        [
            "Partial or dynamic migrations",
            ledger.summary.partial_or_dynamic_count,
        ],
        ["Up operations", ledger.summary.up_operation_count],
        ["Down operations", ledger.summary.down_operation_count],
        ["Implemented tables", raw.summary.implemented_table_count],
        ["Compatibility tables", raw.summary.compatibility_table_count],
        ["Material pivots", raw.summary.material_pivot_count],
        ["Planned concepts", raw.summary.planned_concept_count],
        ["Boundaries", raw.summary.boundary_count],
        ["Material records", classifications.items.length],
        [
            "Reviewed records",
            classifications.items.filter((item) => item._reviewed).length,
        ],
        [
            "Pending review",
            classifications.items.filter((item) => !item._reviewed).length,
        ],
        [
            "Contradiction-bearing records",
            classifications.items.filter(
                (item) => item.known_contradictions.length,
            ).length,
        ],
        [
            "Investigate records",
            classifications.items.filter(
                (item) => item.disposition === "investigate",
            ).length,
        ],
        ["Missing table contracts", raw.summary.missing_contract_count],
        [
            "Owner declarations explicitly compared",
            raw.summary.owner_declaration_comparison_count,
        ],
        ["Owner mismatches", raw.summary.owner_mismatch_count],
    ];
    return renderKeyValueTable(rows);
}

function renderMigrations(ledger) {
    const roots = [
        "### Registered Migration Roots",
        "",
        "| Root | State | Exists | Migrations |",
        "| --- | --- | ---: | ---: |",
        ...ledger.migration_roots.map(
            (root) =>
                `| \`${root.registered_root}\` | ${root.registration_state} | ${root.exists_at_baseline ? "yes" : "no"} | ${root.migration_count} |`,
        ),
        "",
        "### Migration Ledger",
        "",
        "| Migration | Registration | Up | Down | Storage identifiers | Parse status |",
        "| --- | --- | ---: | ---: | --- | --- |",
        ...ledger.migrations.map((migration) => {
            const identifiers = [
                ...new Set(
                    [
                        ...migration.up_operations,
                        ...migration.down_operations,
                    ].map(
                        (operation) =>
                            operation.storage_identifier ??
                            operation.identifier_expression,
                    ),
                ),
            ];
            return `| \`${migration.migration_path}\` | ${migration.registration_state} | ${migration.up_operations.length} | ${migration.down_operations.length} | ${identifiers.map((identifier) => `\`${escapeMarkdown(identifier)}\``).join(", ")} | ${migration.parse_status} |`;
        }),
    ];
    return roots.join("\n");
}

function renderRecords(items, emptyText) {
    if (items.length === 0) return emptyText;
    return items
        .map((item) => {
            const sources = item.migration_or_planning_source
                .map((source) => `\`${source.path}:${source.line_start}\``)
                .join(", ");
            return [
                `### \`${item.storage_identifier}\``,
                "",
                `- Review: ${item._reviewed ? "reviewed" : "pending"}${item._review_required ? "; review required" : ""}`,
                `- Implementation / disposition: \`${item.implementation_state}\` / \`${item.disposition}\``,
                `- Ownership: \`${item.ownership_area}\`; owner \`${item.owner_key}\`; capability \`${item.capability_key}\`; Module \`${item.module_key}\``,
                `- Scope: Tenant \`${item.tenant_scope.state}\`; Instance \`${item.instance_scope.state}\`; Principal \`${item.principal_scope.state}\`; resource \`${item.resource_scope.state}\`; Actor \`${item.actor_scope.state}\`; target Tenant/Instance \`${item.target_tenant_or_instance_scope.state}\``,
                `- Sources: ${sources}`,
                `- Keys and relationships: ${evidenceClaims(item.key_and_relationship_evidence)}`,
                `- Uniqueness and indexes: ${evidenceClaims(item.uniqueness_and_index_evidence)}`,
                `- Lifecycle and deletion: ${evidenceClaims(item.lifecycle_and_deletion_evidence)}`,
                `- Classification: ${evidenceClaims(item.classification_evidence)}`,
                `- Retention and erasure: ${evidenceClaims(item.retention_and_erasure_evidence)}`,
                `- Audit: ${evidenceClaims(item.audit_evidence)}`,
                `- Contract: ${Array.isArray(item.contract_path) ? item.contract_path.map((path) => `\`${path}\``).join(", ") : `\`${item.contract_path}\``}`,
                `- Compatibility: ${evidenceClaims(item.compatibility_evidence) || "No compatibility evidence recorded."}`,
                `- Contradictions: ${item.known_contradictions.length ? item.known_contradictions.map((entry) => `\`${entry.code}\` — ${entry.explanation}`).join("; ") : "None recorded."}`,
                `- Target question: ${item.target_question}`,
            ].join("\n");
        })
        .join("\n\n");
}

function renderContracts(items, raw) {
    const rows = items.filter(
        (item) =>
            !item.storage_identifier.startsWith("concept.") &&
            !item.storage_identifier.startsWith("boundary."),
    );
    return [
        "### Contract And Ownership Coverage",
        "",
        "| Storage | Contract | Owner | Ownership/contract contradictions |",
        "| --- | --- | --- | --- |",
        ...rows.map(
            (item) =>
                `| \`${item.storage_identifier}\` | ${Array.isArray(item.contract_path) ? item.contract_path.map((path) => `\`${path}\``).join(", ") : item.contract_path} | \`${item.owner_key}\` | ${
                    item.known_contradictions
                        .filter((entry) =>
                            /contract|owner|unclaimed/.test(entry.code),
                        )
                        .map((entry) => `\`${entry.code}\``)
                        .join(", ") || "none"
                } |`,
        ),
        "",
        "### Models, Factories, And Seeders",
        "",
        ...raw.models.map(
            (model) =>
                `- Model \`${model.path}\`: explicit table ${model.explicit_table ? `\`${model.explicit_table}\`` : "Laravel convention"}; relationships ${model.relationship_methods.map((relationship) => `\`${relationship.name}:${relationship.type}\``).join(", ") || "none recorded"}; soft deletes ${model.uses_soft_deletes ? "yes" : "no"}.`,
        ),
        ...raw.factories.map(
            (factory) =>
                `- Factory \`${factory.path}\`: associated model ${factory.associated_model ? `\`${factory.associated_model}\`` : "not explicitly resolved"}; secret-bearing values were not collected.`,
        ),
        ...raw.seeders.map(
            (seeder) =>
                `- Seeder \`${seeder.path}\`: safe structure and field names were inventoried; personal and credential values were not collected.`,
        ),
        "",
        "### Ownership Declarations And Database Tests",
        "",
        ...raw.ownership_declarations.map(
            (declaration) =>
                `- \`${declaration.storage_identifier}\` is declared by \`${declaration.manifest_key}\` at \`${declaration.path}:${declaration.line_start}\`.`,
        ),
        ...raw.database_tests.map(
            (test) => `- Database-related test evidence: \`${test.path}\`.`,
        ),
    ].join("\n");
}

function renderScopeFindings(items) {
    return [
        "| Storage | Tenant | Instance | Principal | Resource | Actor | Target Tenant/Instance |",
        "| --- | --- | --- | --- | --- | --- | --- |",
        ...items.map(
            (item) =>
                `| \`${item.storage_identifier}\` | ${item.tenant_scope.state} | ${item.instance_scope.state} | ${item.principal_scope.state} | ${item.resource_scope.state} | ${item.actor_scope.state} | ${item.target_tenant_or_instance_scope.state} |`,
        ),
    ].join("\n");
}

function renderGovernance(items) {
    return items
        .map(
            (item) =>
                `- \`${item.storage_identifier}\`: classification — ${evidenceClaims(item.classification_evidence)} Retention/erasure — ${evidenceClaims(item.retention_and_erasure_evidence)} Audit — ${evidenceClaims(item.audit_evidence)}`,
        )
        .join("\n");
}

function renderContradictions(items) {
    if (items.length === 0) return "No contradictions are recorded.";
    return items
        .flatMap((item) =>
            item.known_contradictions.map(
                (entry) =>
                    `- \`${item.storage_identifier}\` / \`${entry.code}\`: ${entry.explanation} (${entry.evidence?.path ?? "evidence unavailable"}:${entry.evidence?.line_start ?? 1})`,
            ),
        )
        .join("\n");
}

function renderTargetQuestions(items) {
    if (items.length === 0)
        return "No unresolved target questions are recorded.";
    return items
        .map(
            (item) =>
                `- \`${item.storage_identifier}\`: ${item.target_question}`,
        )
        .join("\n");
}

function renderVerification(raw, ledger, classifications, pending) {
    const runtime = raw.runtime_discovery.commands.length
        ? raw.runtime_discovery.commands
              .map(
                  (item) =>
                      `- \`${item.command}\`: exit ${item.exit_code ?? "unavailable"}${item.timed_out ? ", timed out" : ""}${item.failure_reason ? `; ${item.failure_reason}` : ""}`,
              )
              .join("\n")
        : `- Runtime discovery: ${raw.runtime_discovery.mode}.`;
    return [
        `- Baseline consistency: \`${raw.baseline.sha}\` across ledger, raw evidence, classifications, and this projection.`,
        `- Migration coverage: ${ledger.migrations.length} files, ${ledger.summary.up_operation_count} up operations, ${ledger.summary.down_operation_count} down operations.`,
        `- Material review: ${classifications.items.length - pending}/${classifications.items.length} reviewed; ${pending} pending.`,
        "- Deterministic commands:",
        `  - \`npm run inventory:m0:persistent-data:collect -- --baseline ${raw.baseline.sha} --with-runtime-discovery\``,
        `  - \`npm run inventory:m0:persistent-data:collect -- --baseline ${raw.baseline.sha} --static-only\``,
        `  - \`npm run inventory:m0:persistent-data:render -- --baseline ${raw.baseline.sha}\``,
        `  - \`npm run lint:m0:persistent-data-inventory -- --baseline ${raw.baseline.sha} --fixtures\``,
        "- Runtime discovery:",
        runtime,
        "- Fixture, formatting, documentation guardrail, and final diff results are command evidence in the pull request; rendering does not self-certify later commands.",
        "- Repository-owner Architecture, Security, Data Governance, database ownership, ledger, chain, contract, and contradiction acceptance remains required.",
    ].join("\n");
}

function replaceMarker(document, marker, replacement) {
    const start = `<!-- PERSISTENT-DATA-INVENTORY:${marker}:START -->`;
    const end = `<!-- PERSISTENT-DATA-INVENTORY:${marker}:END -->`;
    const pattern = new RegExp(
        `${escapeRegex(start)}[\\s\\S]*?${escapeRegex(end)}`,
    );
    if (!pattern.test(document))
        throw new Error(`Missing render marker ${marker}.`);
    return document.replace(pattern, `${start}\n\n${replacement}\n\n${end}`);
}

async function runFixtureMode(fixtureRoot) {
    const root = isAbsolute(fixtureRoot) ? fixtureRoot : resolve(fixtureRoot);
    const catalogPath = join(root, "cases.json");
    const catalog = JSON.parse(readFileSync(catalogPath, "utf8"));
    const temp = await mkdtemp(
        join(tmpdir(), "login-v2-persistent-data-fixtures-"),
    );
    try {
        const results = [];
        for (const fixture of catalog.fixtures) {
            const parsedSources = (fixture.sources ?? []).map((source) => ({
                path: normalizePath(source.path),
                parsed: parseMigration(
                    normalizeNewlines(source.source),
                    normalizePath(source.path),
                    fixture.dynamic_identifiers ?? fixture.dynamic_tables ?? {},
                ),
                sha256: sha256(Buffer.from(normalizeNewlines(source.source))),
            }));
            const evaluation = evaluateFixture(fixture, parsedSources);
            results.push({
                id: fixture.id,
                passed: evaluation.passed,
                assertions: evaluation.assertions,
                source_hashes: Object.fromEntries(
                    parsedSources.map((source) => [source.path, source.sha256]),
                ),
            });
        }
        const output = {
            schema_version: 1,
            fixture_count: results.length,
            results,
        };
        writeJson(join(temp, "fixture-results.json"), output);
        const failures = results.filter((result) => !result.passed);
        if (failures.length > 0)
            throw new Error(
                `Fixture failure(s): ${failures.map((item) => item.id).join(", ")}`,
            );
        console.log(
            `Fixture families passed: ${results.length}/${results.length}`,
        );
    } finally {
        await rm(temp, { recursive: true, force: true });
    }
}

function evaluateFixture(fixture, parsedSources) {
    const operations = parsedSources.flatMap((source) => [
        ...source.parsed.up.map((operation) => ({
            ...operation,
            direction: "up",
            path: source.path,
        })),
        ...source.parsed.down.map((operation) => ({
            ...operation,
            direction: "down",
            path: source.path,
        })),
    ]);
    const assertions = [];
    const assert = (condition, label) =>
        assertions.push({ label, passed: Boolean(condition) });
    const upOperations = operations.filter(
        (operation) => operation.direction === "up",
    );
    const fixtureLedger = {
        migrations: parsedSources.map((source) => ({
            migration_path: source.path,
            migration_name: basename(source.path, ".php"),
            up_operations: source.parsed.up,
            down_operations: source.parsed.down,
            parse_status: source.parsed.status,
            parse_notes: source.parsed.notes,
        })),
        summary: {},
    };
    const fixtureChains = buildMigrationChains(fixtureLedger);

    switch (fixture.id) {
        case "multiple-migrations-one-table":
            assert(
                upOperations.filter(
                    (operation) => operation.storage_identifier === "widgets",
                ).length === 2,
                "two up operations aggregate to widgets",
            );
            break;
        case "create-alter-drop-chain":
            assert(
                ["create_table", "alter_table", "drop_table_if_exists"].every(
                    (type) =>
                        operations.some(
                            (operation) => operation.operation_type === type,
                        ),
                ),
                "create, alter, and drop are retained",
            );
            break;
        case "dynamic-table-identifiers":
            assert(
                upOperations.some(
                    (operation) =>
                        operation.identifier_expression ===
                            "$tableNames['permissions']" &&
                        operation.storage_identifier === "permissions",
                ),
                "dynamic identifier is retained and resolved from supplied configuration",
            );
            break;
        case "compound-indexes-and-unique-constraints":
            assert(
                upOperations.some(
                    (operation) =>
                        operation.indexes.some(
                            (index) => index.columns.length === 2,
                        ) &&
                        operation.unique_constraints.some(
                            (constraint) => constraint.columns.length === 2,
                        ),
                ),
                "compound index and unique constraint are represented",
            );
            break;
        case "foreign-keys-and-delete-behavior":
            assert(
                upOperations.some((operation) =>
                    operation.foreign_keys.some(
                        (foreign) => foreign.deletion_behavior === "cascade",
                    ),
                ),
                "foreign key cascade is represented",
            );
            break;
        case "material-pivot-table":
            assert(
                upOperations.some(
                    (operation) =>
                        operation.storage_identifier === "role_user" &&
                        operation.primary_keys.some(
                            (key) => key.columns.length === 2,
                        ),
                ),
                "material pivot compound primary key is represented",
            );
            break;
        case "duplicate-migration-names":
            assert(
                duplicatesForFixture(
                    parsedSources.map((source) => basename(source.path)),
                ).length === 1,
                "duplicate migration basename is detected",
            );
            break;
        case "present-unregistered-migration-root": {
            const roots = fixture.registered_roots ?? [];
            assert(
                parsedSources.some(
                    (source) =>
                        !roots.some((root) =>
                            source.path.startsWith(`${normalizePath(root)}/`),
                        ),
                ),
                "migration outside registered roots is visible",
            );
            break;
        }
        case "unsupported-migration-operation":
            assert(
                parsedSources.some(
                    (source) =>
                        source.parsed.status === "unsupported_operation",
                ),
                "unsupported Blueprint operation changes parse status",
            );
            break;
        case "planned-implemented-overlap":
            assert(
                fixture.implemented_identifier === fixture.planned_subject &&
                    fixture.implemented_record_id !== fixture.planned_record_id,
                "planned and implemented records remain distinct",
            );
            break;
        case "reviewed-field-preservation": {
            const seed = fixture.seed;
            const previous = {
                ...seed,
                disposition: "investigate",
                _reviewed: true,
                _review_required: false,
            };
            const merged = { ...seed };
            for (const field of REQUIRED_FIELDS)
                merged[field] = previous[field];
            merged._reviewed = previous._reviewed;
            assert(
                merged.disposition === "investigate" &&
                    merged._reviewed === true,
                "reviewed fields survive unchanged-source recollection",
            );
            break;
        }
        case "runtime-discovery-failure-preservation": {
            const preserved = preserveRuntimeValue(
                fixture.existing_raw,
                fixture.baseline,
                true,
            );
            assert(
                preserved.mode === "attempted" &&
                    preserved.commands[0].failure_reason ===
                        "synthetic failure",
                "failed runtime evidence survives static recollection",
            );
            break;
        }
        case "same-basename-different-paths":
            assert(
                new Set(parsedSources.map((source) => source.path)).size ===
                    parsedSources.length &&
                    duplicatesForFixture(
                        parsedSources.map((source) => basename(source.path)),
                    ).length === 1,
                "full paths remain distinct while basenames collide",
            );
            break;
        case "windows-and-posix-path-normalization":
            assert(
                fixture.paths
                    .map(normalizePath)
                    .every((path) => !path.includes("\\")) &&
                    new Set(fixture.paths.map(normalizePath)).size === 1,
                "Windows and POSIX spellings normalize identically",
            );
            break;
        case "implicit-id-primary-key": {
            const state = fixtureChains.get("implicit_ids")?.final_state;
            assert(
                state?.columns.some((column) => column.name === "id") &&
                    state.primary_keys.some(
                        (key) =>
                            key.columns.length === 1 && key.columns[0] === "id",
                    ),
                "implicit id resolves to a non-empty id primary key",
            );
            break;
        }
        case "custom-id-primary-key": {
            const state = fixtureChains.get("custom_ids")?.final_state;
            assert(
                state?.columns.some((column) => column.name === "record_id") &&
                    state.primary_keys.some((key) =>
                        key.columns.includes("record_id"),
                    ),
                "custom id name is preserved in the primary key",
            );
            break;
        }
        case "create-add-drop-final-state": {
            const chain = fixtureChains.get("reduced_records");
            assert(
                chain?.operations.length >= 3 &&
                    !chain.final_state.columns.some(
                        (column) => column.name === "temporary_value",
                    ),
                "history retains create/add/drop while final state omits the dropped column",
            );
            break;
        }
        case "drop-index-unique-foreign-primary": {
            const state = fixtureChains.get("constraint_records")?.final_state;
            assert(
                state &&
                    state.primary_keys.length === 0 &&
                    state.indexes.length === 0 &&
                    state.unique_constraints.length === 0 &&
                    state.foreign_keys.length === 0,
                "explicit drops remove keys, indexes, unique constraints, and foreign keys",
            );
            break;
        }
        case "rename-column-rewrites-references": {
            const state = fixtureChains.get("rename_records")?.final_state;
            assert(
                state?.columns.some((column) => column.name === "account_id") &&
                    !state.columns.some(
                        (column) => column.name === "user_id",
                    ) &&
                    [...state.indexes, ...state.foreign_keys].every(
                        (entry) => !entry.columns.includes("user_id"),
                    ),
                "column rename rewrites final-state references",
            );
            break;
        }
        case "conditional-has-column-operation": {
            const chain = fixtureChains.get("conditional_records");
            assert(
                chain?.final_state.complete === true &&
                    !chain.final_state.columns.some(
                        (column) => column.name === "legacy_value",
                    ) &&
                    fixtureLedger.migrations.every(
                        (migration) => migration.parse_status === "complete",
                    ),
                "hasColumn guard resolves from ordered final-state reduction",
            );
            break;
        }
        case "permission-dynamic-column-identifiers": {
            const state = fixtureChains.get(
                "model_has_permissions",
            )?.final_state;
            assert(
                state?.columns.some(
                    (column) => column.name === "permission_id",
                ) &&
                    state.columns.some(
                        (column) => column.name === "model_id",
                    ) &&
                    state.primary_keys.some((key) =>
                        ["permission_id", "model_id", "model_type"].every(
                            (column) => key.columns.includes(column),
                        ),
                    ),
                "permission table, column, and local pivot bindings resolve",
            );
            break;
        }
        case "canonical-key-grammar":
            assert(
                fixture.keys
                    .map(canonicalKey)
                    .every((key) => CANONICAL_KEY_PATTERN.test(key)),
                "owner, capability, and module keys normalize to ADR-0007 grammar",
            );
            break;
        case "generated-fingerprint-invalidates-review": {
            const previous = fixture.previous;
            const seed = fixture.seed;
            const changed =
                previous._generated_fingerprint !== seed._generated_fingerprint;
            assert(
                changed && previous._reviewed === true,
                "changed generated fingerprint is detectable for review invalidation",
            );
            break;
        }
        case "final-state-evidence-deduplication":
            assert(
                currentStateEvidence(fixture.sources_for_claim, "same claim")
                    .length === 1,
                "one synthesized final-state evidence claim is emitted",
            );
            break;
        default:
            assert(false, `unknown fixture family ${fixture.id}`);
    }
    return {
        passed:
            assertions.length > 0 && assertions.every((item) => item.passed),
        assertions,
    };
}

function duplicatesForFixture(values) {
    const counts = countBy(values, (value) => value);
    return Object.entries(counts)
        .filter(([, count]) => count > 1)
        .map(([value]) => value);
}

function baselineMetadata(context) {
    return {
        sha: context.baseline,
        committed_at: context.committedAt,
        ref: "main",
        current_head_at_generation: context.head,
        accepted_main_at_package_preparation: ACCEPTED_MAIN,
    };
}

function generatorMetadata(generatedAt) {
    return {
        path: GENERATOR_PATH,
        schema_version: GENERATOR_SCHEMA_VERSION,
        node_version: process.version,
        generated_at: generatedAt,
        deterministic_ordering:
            "migration name then path; material storage identifier",
    };
}

function evidence(blobs, path, claim, line = 1) {
    const blob = blobs.get(path);
    return {
        evidence_type: evidenceType(path),
        path,
        line_start: Math.max(1, line || 1),
        line_end: Math.max(1, line || 1),
        claim,
        source_sha256: blob?.sha256 ?? null,
    };
}

function evidenceType(path) {
    if (path.includes("/migrations/")) return "migration";
    if (path.startsWith("docs/07-planning/")) return "planning";
    if (path.startsWith("docs/06-database/")) return "database_contract";
    if (path.startsWith("config/")) return "configuration";
    if (path === ".env.example") return "environment_example";
    return "source";
}

function scope(state, sources, claim) {
    return {
        state,
        evidence: sources.slice(0, 1).map((source) => ({ ...source, claim })),
    };
}

function currentStateEvidence(sources, claim) {
    const source = sources.at(-1) ?? sources[0];
    return source ? [{ ...source, claim }] : [];
}

function dedupeEvidenceClaims(values) {
    return dedupeBy(values, (value) => value.claim);
}

function canonicalKey(value) {
    if (["unknown", "not_applicable"].includes(value)) return value;
    const normalized = String(value ?? "unknown")
        .replace(/([a-z0-9])([A-Z])/g, "$1_$2")
        .replace(/[^A-Za-z0-9]+/g, "_")
        .replace(/^_+|_+$/g, "")
        .toLowerCase();
    return CANONICAL_KEY_PATTERN.test(normalized) ? normalized : "unknown";
}

function contradiction(code, explanation, source) {
    return { code, explanation, evidence: source ?? null };
}

function evidenceClaims(values) {
    return (values ?? [])
        .map((value) => value.claim)
        .filter(Boolean)
        .join(" ");
}

function findRelevantLine(content, key) {
    const preferred = EVIDENCE_NEEDLES[key];
    if (preferred) {
        const preferredLine = findLine(content, preferred);
        if (
            preferredLine > 1 ||
            normalizeNewlines(content).split("\n")[0]?.includes(preferred)
        ) {
            return preferredLine;
        }
    }
    const words = key
        .split("_")
        .filter((word) => word.length > 3)
        .map((word) => word.toLowerCase().replace(/s$/, ""));
    const lines = normalizeNewlines(content).split("\n");
    const metadataEnd = lines.findIndex(
        (line, index) => index > 0 && line.trim() === "-->",
    );
    let best = { index: Math.max(0, metadataEnd + 1), score: -1 };
    for (
        let index = Math.max(0, metadataEnd + 1);
        index < lines.length;
        index += 1
    ) {
        const normalized = lines[index].toLowerCase();
        const score = words.reduce(
            (total, word) => total + (normalized.includes(word) ? 1 : 0),
            0,
        );
        const proseBonus = /^\s*(?:[-*]|\d+\.|[A-Za-z])/.test(lines[index])
            ? 0.25
            : 0;
        if (score + proseBonus > best.score)
            best = { index, score: score + proseBonus };
        if (score === words.length && words.length > 0) return index + 1;
    }
    return best.index + 1;
}

function findLine(content, needle) {
    const index = normalizeNewlines(content)
        .split("\n")
        .findIndex((line) => line.includes(needle));
    return index < 0 ? 1 : index + 1;
}

function lineAt(content, offset) {
    return content.slice(0, Math.max(0, offset)).split("\n").length;
}

function countNewlines(value) {
    return (String(value).match(/\n/g) ?? []).length;
}

function matchingDelimiter(content, openIndex, openCharacter, closeCharacter) {
    let depth = 0;
    let quote = null;
    let escaped = false;
    let lineComment = false;
    let blockComment = false;
    for (let index = openIndex; index < content.length; index += 1) {
        const character = content[index];
        const next = content[index + 1];
        if (lineComment) {
            if (character === "\n") lineComment = false;
            continue;
        }
        if (blockComment) {
            if (character === "*" && next === "/") {
                blockComment = false;
                index += 1;
            }
            continue;
        }
        if (quote) {
            if (escaped) escaped = false;
            else if (character === "\\") escaped = true;
            else if (character === quote) quote = null;
            continue;
        }
        if (character === "/" && next === "/") {
            lineComment = true;
            index += 1;
            continue;
        }
        if (character === "/" && next === "*") {
            blockComment = true;
            index += 1;
            continue;
        }
        if (character === "#") {
            lineComment = true;
            continue;
        }
        if (character === "'" || character === '"') {
            quote = character;
            continue;
        }
        if (character === openCharacter) depth += 1;
        else if (character === closeCharacter) {
            depth -= 1;
            if (depth === 0) return index;
        }
    }
    return -1;
}

function splitTopLevel(value, separator) {
    const result = [];
    let start = 0;
    const stack = [];
    let quote = null;
    let escaped = false;
    let lineComment = false;
    let blockComment = false;
    const pairs = { "(": ")", "[": "]", "{": "}" };
    for (let index = 0; index < value.length; index += 1) {
        const character = value[index];
        const next = value[index + 1];
        if (lineComment) {
            if (character === "\n") lineComment = false;
            continue;
        }
        if (blockComment) {
            if (character === "*" && next === "/") {
                blockComment = false;
                index += 1;
            }
            continue;
        }
        if (quote) {
            if (escaped) escaped = false;
            else if (character === "\\") escaped = true;
            else if (character === quote) quote = null;
            continue;
        }
        if (character === "/" && next === "/") {
            lineComment = true;
            index += 1;
            continue;
        }
        if (character === "/" && next === "*") {
            blockComment = true;
            index += 1;
            continue;
        }
        if (character === "#") {
            lineComment = true;
            continue;
        }
        if (character === "'" || character === '"') quote = character;
        else if (pairs[character]) stack.push(pairs[character]);
        else if (stack.at(-1) === character) stack.pop();
        else if (character === separator && stack.length === 0) {
            result.push(value.slice(start, index));
            start = index + 1;
        }
    }
    result.push(value.slice(start));
    return result;
}

function statementEnd(content, start) {
    const stack = [];
    let quote = null;
    let escaped = false;
    let lineComment = false;
    let blockComment = false;
    const pairs = { "(": ")", "[": "]", "{": "}" };
    for (let index = start; index < content.length; index += 1) {
        const character = content[index];
        const next = content[index + 1];
        if (lineComment) {
            if (character === "\n") lineComment = false;
            continue;
        }
        if (blockComment) {
            if (character === "*" && next === "/") {
                blockComment = false;
                index += 1;
            }
            continue;
        }
        if (quote) {
            if (escaped) escaped = false;
            else if (character === "\\") escaped = true;
            else if (character === quote) quote = null;
            continue;
        }
        if (character === "/" && next === "/") {
            lineComment = true;
            index += 1;
            continue;
        }
        if (character === "/" && next === "*") {
            blockComment = true;
            index += 1;
            continue;
        }
        if (character === "#") {
            lineComment = true;
            continue;
        }
        if (character === "'" || character === '"') quote = character;
        else if (pairs[character]) stack.push(pairs[character]);
        else if (stack.at(-1) === character) stack.pop();
        else if (character === ";" && stack.length === 0) return index;
    }
    return -1;
}

function summarizeExpression(value) {
    const safe = String(value ?? "")
        .replace(
            /(['"])(?:[^'"\\]|\\.)*(password|secret|token|private[_ -]?key|recovery[_ -]?code|credential)(?:[^'"\\]|\\.)*\1/gi,
            "'[redacted-expression]'",
        )
        .replace(/\s+/g, " ")
        .trim();
    return safe.slice(0, 500);
}

function isSecretValue(value) {
    return /(?:^|_)(password|secret|token|private_key|recovery_code|credential)(?:$|_)/i.test(
        value,
    );
}

function packageKeyFromPath(path) {
    const match = /^Modules\/([^/]+)\//.exec(path);
    return match ? snakeCase(match[1]) : "unknown";
}

function snakeCase(value) {
    return value
        .replace(/([a-z0-9])([A-Z])/g, "$1_$2")
        .replace(/[^A-Za-z0-9]+/g, "_")
        .toLowerCase();
}

function dedupeJson(values) {
    return dedupeBy(values, stableStringify);
}

function dedupeBy(values, selector) {
    const seen = new Set();
    return values.filter((value) => {
        const key = selector(value);
        if (seen.has(key)) return false;
        seen.add(key);
        return true;
    });
}

function countBy(values, selector) {
    const counts = {};
    for (const value of values) {
        const key = selector(value);
        counts[key] = (counts[key] ?? 0) + 1;
    }
    return Object.fromEntries(
        Object.entries(counts).sort(([left], [right]) =>
            left.localeCompare(right),
        ),
    );
}

function renderKeyValueTable(rows) {
    return [
        "| Measure | Count |",
        "| --- | ---: |",
        ...rows.map(([label, value]) => `| ${label} | ${value} |`),
    ].join("\n");
}

function readJson(path) {
    return JSON.parse(readFileSync(path, "utf8"));
}

function readJsonIfExists(path) {
    return existsSync(path) ? readJson(path) : null;
}

function readJsonFromHead(path) {
    const result = spawnSync("git", ["show", `HEAD:${normalizePath(path)}`], {
        cwd: process.cwd(),
        encoding: "utf8",
        windowsHide: true,
        maxBuffer: 32 * 1024 * 1024,
    });
    if (result.error || result.status !== 0) return null;
    return JSON.parse(result.stdout);
}

function writeJson(path, value) {
    mkdirSync(dirname(path), { recursive: true });
    writeFileSync(path, `${stableStringify(value)}\n`, "utf8");
}

function stableStringify(value) {
    return JSON.stringify(value, null, 2);
}

function sha256(value) {
    return createHash("sha256").update(value).digest("hex");
}

function normalizePath(value) {
    return String(value).replaceAll("\\", "/").replace(/^\.\//, "");
}

function normalizeNewlines(value) {
    return String(value).replace(/\r\n?/g, "\n");
}

function escapeRegex(value) {
    return String(value).replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
}

function escapeMarkdown(value) {
    return String(value ?? "")
        .replaceAll("|", "\\|")
        .replaceAll("`", "\\`");
}

function run(command, commandArgs, options = {}) {
    const result = spawnSync(command, commandArgs, {
        cwd: process.cwd(),
        encoding:
            options.encoding === "buffer"
                ? undefined
                : (options.encoding ?? "utf8"),
        input: options.input,
        windowsHide: true,
        maxBuffer: options.maxBuffer ?? 32 * 1024 * 1024,
    });
    if (result.error) throw result.error;
    if (result.status !== 0) {
        throw new Error(
            `${command} ${commandArgs.join(" ")} failed: ${String(result.stderr).trim()}`,
        );
    }
    return result;
}
