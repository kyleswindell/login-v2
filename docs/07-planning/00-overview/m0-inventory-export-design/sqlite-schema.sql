-- ============================================================================
-- File: sqlite-schema.sql
-- Purpose: Disposable single-export SQLite projection for the accepted Issue #30 UI inventory.
-- Source: Generated from csv-schema.json version 0.2.0.
-- ============================================================================

PRAGMA foreign_keys = ON;

-- Replace the database for each export. Append mode is intentionally unsupported.

CREATE TABLE "inventory_export_manifest" (
    "export_id" TEXT NOT NULL,
    "inventory_type" TEXT NOT NULL CHECK ("inventory_type" IN ('ui')),
    "inventory_baseline_sha" TEXT NOT NULL,
    "source_set_sha256" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "export_file" TEXT NOT NULL,
    "row_count" INTEGER NOT NULL,
    "exported_at_utc" TEXT NOT NULL,
    "generator_version" TEXT NOT NULL,
    "encoding" TEXT NOT NULL CHECK ("encoding" IN ('utf-8')),
    "delimiter" TEXT NOT NULL CHECK ("delimiter" IN ('comma')),
    "line_ending" TEXT NOT NULL CHECK ("line_ending" IN ('lf')),
    "status" TEXT NOT NULL CHECK ("status" IN ('complete', 'partial', 'failed')),
    PRIMARY KEY ("export_id", "export_file")
);

CREATE TABLE "inventory_export_sources" (
    "export_id" TEXT NOT NULL,
    "source_id" TEXT NOT NULL PRIMARY KEY,
    "source_role" TEXT NOT NULL CHECK ("source_role" IN ('classifications', 'observations', 'test_traces')),
    "source_artifact_path" TEXT NOT NULL,
    "source_artifact_sha256" TEXT NOT NULL,
    "source_schema_version" INTEGER NOT NULL,
    "source_generator_schema_version" INTEGER,
    "authoritative" INTEGER NOT NULL CHECK ("authoritative" IN (0, 1)),
    "required" INTEGER NOT NULL CHECK ("required" IN (0, 1))
);

CREATE TABLE "ui_surfaces" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "surface_id" TEXT NOT NULL PRIMARY KEY,
    "ui_key" TEXT NOT NULL,
    "current_slug" TEXT NOT NULL,
    "surface_type" TEXT NOT NULL CHECK ("surface_type" IN ('element', 'primitive', 'component', 'component_family', 'subcomponent', 'pattern', 'layout', 'shell', 'navigation', 'url_view', 'renderer', 'view_model', 'page_data', 'ui_contribution', 'compatibility_alias', 'css_control', 'javascript_control', 'icon_system', 'pictogram_system')),
    "ownership_area" TEXT NOT NULL CHECK ("ownership_area" IN ('core', 'module', 'ui', 'not_applicable', 'unknown')),
    "owner_key" TEXT NOT NULL,
    "capability_key" TEXT NOT NULL,
    "module_key" TEXT NOT NULL,
    "primary_blade_alias" TEXT NOT NULL,
    "implementation_entry" TEXT NOT NULL,
    "contract_status" TEXT NOT NULL CHECK ("contract_status" IN ('present', 'missing', 'multiple', 'variation', 'unresolved', 'not_applicable', 'unknown')),
    "carbon_provenance" TEXT NOT NULL CHECK ("carbon_provenance" IN ('carbon_direct_port', 'carbon_api_adaptation', 'carbon_visual_reference', 'carbon_behavior_reference', 'app_owned', 'mixed', 'unknown', 'not_applicable')),
    "test_status" TEXT NOT NULL CHECK ("test_status" IN ('passing', 'failing', 'mixed', 'warning', 'not_run', 'missing', 'unknown', 'not_applicable')),
    "test_authority" TEXT NOT NULL CHECK ("test_authority" IN ('authoritative', 'partial', 'incidental', 'stale', 'unknown', 'not_applicable')),
    "inventory_disposition" TEXT NOT NULL CHECK ("inventory_disposition" IN ('retain', 'compatibility', 'duplicate', 'investigate')),
    "target_question" TEXT NOT NULL,
    "registration_evidence_json" TEXT NOT NULL,
    "public_api_evidence_json" TEXT NOT NULL,
    "contract_api_evidence_json" TEXT NOT NULL,
    "app_owned_deviations_json" TEXT NOT NULL,
    "lifecycle_claim_json" TEXT NOT NULL,
    "review_claim_json" TEXT NOT NULL,
    "accessibility_evidence_json" TEXT NOT NULL,
    "responsive_evidence_json" TEXT NOT NULL,
    "browser_evidence_json" TEXT NOT NULL,
    "source_fingerprint" TEXT NOT NULL
);

CREATE TABLE "ui_surface_aliases" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "surface_alias_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "alias_type" TEXT NOT NULL CHECK ("alias_type" IN ('blade_alias')),
    "alias_value" TEXT NOT NULL,
    "is_primary" INTEGER NOT NULL CHECK ("is_primary" IN (0, 1)),
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id")
);

CREATE INDEX "idx_ui_surface_aliases_surface_id" ON "ui_surface_aliases" ("surface_id");

CREATE TABLE "ui_surface_files" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "surface_file_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "file_role" TEXT NOT NULL CHECK ("file_role" IN ('implementation_entry', 'implementation_support', 'contract', 'reference', 'example', 'css', 'javascript', 'test')),
    "path" TEXT NOT NULL,
    "is_primary" INTEGER NOT NULL CHECK ("is_primary" IN (0, 1)),
    "exists_at_baseline" INTEGER NOT NULL CHECK ("exists_at_baseline" IN (0, 1)),
    "source_blob_oid" TEXT,
    "source_sha256" TEXT,
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id")
);

CREATE INDEX "idx_ui_surface_files_surface_id" ON "ui_surface_files" ("surface_id");

CREATE TABLE "ui_mismatches" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "mismatch_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "mismatch_code" TEXT NOT NULL CHECK ("mismatch_code" IN ('aligned', 'contract_missing', 'contract_stale', 'implementation_stale', 'standard_stale', 'test_missing', 'test_stale', 'test_incomplete', 'reference_missing', 'reference_stale', 'example_missing', 'example_stale', 'registration_missing', 'registration_stale', 'duplicate_identity', 'owner_mismatch', 'blade_alias_mismatch', 'source_path_mismatch', 'dependency_mismatch', 'provenance_unknown', 'review_unknown', 'lifecycle_conflict', 'accessibility_evidence_missing', 'browser_evidence_missing', 'responsive_evidence_missing', 'investigate')),
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id")
);

CREATE INDEX "idx_ui_mismatches_surface_id" ON "ui_mismatches" ("surface_id");

CREATE TABLE "ui_test_traces" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "trace_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "surface_ui_key" TEXT NOT NULL,
    "test_path" TEXT NOT NULL,
    "test_exists" INTEGER NOT NULL CHECK ("test_exists" IN (0, 1)),
    "test_type" TEXT NOT NULL CHECK ("test_type" IN ('contract schema', 'API rendering', 'prop behavior', 'slot behavior', 'variant rendering', 'state rendering', 'class contract', 'accessibility', 'JavaScript behavior', 'browser', 'visual', 'snapshot', 'integration', 'incidental markup assertion', 'unknown')),
    "current_result" TEXT NOT NULL CHECK ("current_result" IN ('passed', 'failed', 'warning', 'not_run', 'missing', 'unknown')),
    "test_authority" TEXT NOT NULL CHECK ("test_authority" IN ('authoritative', 'partial', 'incidental', 'stale', 'unknown', 'not_applicable')),
    "relationship_kind" TEXT NOT NULL CHECK ("relationship_kind" IN ('owner_local_test', 'exact_repository_path_reference', 'exact_blade_alias_reference', 'exact_ui_key_reference', 'exact_symbol_reference')),
    "relationship_value" TEXT NOT NULL,
    "accessibility_coverage_state" TEXT NOT NULL CHECK ("accessibility_coverage_state" IN ('present_claim', 'not_observed', 'unknown')),
    "javascript_coverage_state" TEXT NOT NULL CHECK ("javascript_coverage_state" IN ('present_claim', 'not_observed', 'unknown')),
    "contract_fields_covered_count" INTEGER NOT NULL,
    "rendered_states_covered_count" INTEGER NOT NULL,
    "source_fingerprint" TEXT NOT NULL,
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id")
);

CREATE INDEX "idx_ui_test_traces_surface_id" ON "ui_test_traces" ("surface_id");

CREATE TABLE "ui_test_trace_coverage" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "coverage_id" TEXT NOT NULL PRIMARY KEY,
    "trace_id" TEXT NOT NULL,
    "coverage_kind" TEXT NOT NULL CHECK ("coverage_kind" IN ('contract_field', 'rendered_state')),
    "coverage_value" TEXT NOT NULL,
    FOREIGN KEY ("trace_id") REFERENCES "ui_test_traces" ("trace_id")
);

CREATE INDEX "idx_ui_test_trace_coverage_trace_id" ON "ui_test_trace_coverage" ("trace_id");

CREATE TABLE "ui_standards" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "standard_id" TEXT NOT NULL PRIMARY KEY,
    "standard_path" TEXT NOT NULL,
    "standard_source_fingerprint" TEXT NOT NULL,
    "claimed_scope" TEXT NOT NULL,
    "implementation_alignment" TEXT NOT NULL CHECK ("implementation_alignment" IN ('aligned', 'partial', 'stale', 'not_applicable', 'unknown')),
    "contract_alignment" TEXT NOT NULL CHECK ("contract_alignment" IN ('aligned', 'partial', 'stale', 'not_applicable', 'unknown')),
    "reference_or_example_alignment" TEXT NOT NULL CHECK ("reference_or_example_alignment" IN ('aligned', 'partial', 'stale', 'not_applicable', 'unknown')),
    "authority_state" TEXT NOT NULL CHECK ("authority_state" IN ('current_standard', 'mixed_authority', 'historical_or_rollout_guidance', 'stale', 'unknown'))
);

CREATE TABLE "ui_surface_standards" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "surface_standard_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "standard_id" TEXT NOT NULL,
    "standard_source_fingerprint" TEXT NOT NULL,
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id"),
    FOREIGN KEY ("standard_id") REFERENCES "ui_standards" ("standard_id")
);

CREATE INDEX "idx_ui_surface_standards_surface_id" ON "ui_surface_standards" ("surface_id");
CREATE INDEX "idx_ui_surface_standards_standard_id" ON "ui_surface_standards" ("standard_id");

CREATE TABLE "ui_standard_findings" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "standard_finding_id" TEXT NOT NULL PRIMARY KEY,
    "standard_id" TEXT NOT NULL,
    "finding_kind" TEXT NOT NULL CHECK ("finding_kind" IN ('staleness_evidence', 'moved_responsibility')),
    "finding_value" TEXT NOT NULL,
    FOREIGN KEY ("standard_id") REFERENCES "ui_standards" ("standard_id")
);

CREATE INDEX "idx_ui_standard_findings_standard_id" ON "ui_standard_findings" ("standard_id");

CREATE TABLE "ui_metadata_evidence" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "metadata_evidence_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "metadata_field" TEXT NOT NULL CHECK ("metadata_field" IN ('human_readable_header', 'ui_key', 'blade_alias', 'implementation_path_reference', 'contract_path_reference', 'contract_schema_version', 'public_api_version', 'verification_commit', 'verification_timestamp', 'source_hash', 'contract_hash', 'last_updated')),
    "implementation_present_count" INTEGER NOT NULL,
    "implementation_absent_count" INTEGER NOT NULL,
    "implementation_unknown_count" INTEGER NOT NULL,
    "implementation_not_applicable_count" INTEGER NOT NULL,
    "implementation_values_json" TEXT NOT NULL,
    "implementation_formats_json" TEXT NOT NULL,
    "implementation_present_paths_json" TEXT NOT NULL,
    "contract_present_count" INTEGER NOT NULL,
    "contract_absent_count" INTEGER NOT NULL,
    "contract_unknown_count" INTEGER NOT NULL,
    "contract_not_applicable_count" INTEGER NOT NULL,
    "contract_values_json" TEXT NOT NULL,
    "contract_formats_json" TEXT NOT NULL,
    "contract_present_paths_json" TEXT NOT NULL,
    "known_disagreement_json" TEXT NOT NULL,
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id")
);

CREATE INDEX "idx_ui_metadata_evidence_surface_id" ON "ui_metadata_evidence" ("surface_id");

CREATE TABLE "ui_dependencies" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "dependency_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "dependency_kind" TEXT NOT NULL CHECK ("dependency_kind" IN ('lower_tier_surface', 'component', 'icon', 'asset', 'other')),
    "dependency_target_surface_id" TEXT,
    "dependency_target_ui_key" TEXT,
    "dependency_path_or_value" TEXT,
    "dependency_payload_json" TEXT NOT NULL,
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id"),
    FOREIGN KEY ("dependency_target_surface_id") REFERENCES "ui_surfaces" ("surface_id")
);

CREATE INDEX "idx_ui_dependencies_surface_id" ON "ui_dependencies" ("surface_id");
CREATE INDEX "idx_ui_dependencies_dependency_target_surface_id" ON "ui_dependencies" ("dependency_target_surface_id");

CREATE TABLE "ui_source_references" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "source_reference_id" TEXT NOT NULL PRIMARY KEY,
    "subject_type" TEXT NOT NULL CHECK ("subject_type" IN ('surface', 'surface_alias', 'surface_file', 'mismatch', 'test_trace', 'standard', 'surface_standard', 'standard_finding', 'metadata_evidence', 'dependency', 'review_status')),
    "subject_id" TEXT NOT NULL,
    "evidence_kind" TEXT NOT NULL CHECK ("evidence_kind" IN ('path', 'path_pattern', 'observation', 'issue', 'command', 'git', 'manual_review', 'other')),
    "evidence_value" TEXT NOT NULL,
    "path" TEXT,
    "line_start" INTEGER,
    "line_end" INTEGER,
    "existence_state" TEXT NOT NULL CHECK ("existence_state" IN ('present', 'absent', 'unknown', 'not_applicable')),
    "source_blob_oid" TEXT,
    "source_sha256" TEXT
);

CREATE TABLE "ui_review_status" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "review_status_id" TEXT NOT NULL PRIMARY KEY,
    "subject_type" TEXT NOT NULL CHECK ("subject_type" IN ('surface', 'standard', 'test_trace')),
    "subject_id" TEXT NOT NULL,
    "reviewed" INTEGER NOT NULL CHECK ("reviewed" IN (0, 1)),
    "review_required" INTEGER NOT NULL CHECK ("review_required" IN (0, 1)),
    "reviewer" TEXT,
    "reviewed_at_utc" TEXT,
    "review_note" TEXT,
    "source_fingerprint" TEXT NOT NULL,
    "review_source_role" TEXT NOT NULL CHECK ("review_source_role" IN ('classifications', 'test_traces'))
);
