-- ============================================================================
-- File: sqlite-schema.sql
-- Purpose: SQLite projection for the reviewed UI inventory export design.
-- Source: Generated from the same schema metadata as csv-schema.json.
-- ============================================================================

PRAGMA foreign_keys = ON;

CREATE TABLE "inventory_export_manifest" (
    "export_id" TEXT NOT NULL,
    "inventory_type" TEXT NOT NULL CHECK ("inventory_type" IN ('ui')),
    "inventory_baseline_sha" TEXT NOT NULL,
    "source_schema_version" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "source_artifact_path" TEXT NOT NULL,
    "source_artifact_sha256" TEXT NOT NULL,
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

CREATE TABLE "ui_surfaces" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "source_schema_version" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "surface_id" TEXT NOT NULL PRIMARY KEY,
    "ui_key" TEXT,
    "current_slug" TEXT,
    "surface_type" TEXT,
    "ownership_area" TEXT,
    "owner_key" TEXT,
    "capability_key" TEXT,
    "module_key" TEXT,
    "blade_alias" TEXT,
    "implementation_entry" TEXT,
    "contract_status" TEXT,
    "registration_summary" TEXT,
    "public_api_summary" TEXT,
    "contract_api_summary" TEXT,
    "carbon_provenance" TEXT,
    "app_owned_deviation_summary" TEXT,
    "lifecycle_claim" TEXT,
    "review_claim" TEXT,
    "accessibility_summary" TEXT,
    "responsive_summary" TEXT,
    "browser_summary" TEXT,
    "test_status" TEXT,
    "test_authority" TEXT,
    "inventory_disposition" TEXT,
    "target_question" TEXT,
    "source_fingerprint" TEXT NOT NULL
);

CREATE TABLE "ui_surface_files" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "source_schema_version" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "surface_file_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "file_role" TEXT NOT NULL CHECK ("file_role" IN ('implementation_entry', 'implementation_support', 'contract', 'reference', 'example', 'proof', 'css', 'javascript', 'test', 'asset', 'icon', 'pictogram', 'registration', 'route', 'other')),
    "path" TEXT NOT NULL,
    "is_primary" TEXT NOT NULL CHECK ("is_primary" IN ('true', 'false')),
    "exists_at_baseline" TEXT NOT NULL CHECK ("exists_at_baseline" IN ('true', 'false')),
    "registration_state" TEXT,
    "source_blob_oid" TEXT,
    "source_sha256" TEXT,
    "notes" TEXT,
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id")
);

CREATE INDEX "idx_ui_surface_files_surface_id" ON "ui_surface_files" ("surface_id");

CREATE TABLE "ui_mismatches" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "source_schema_version" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "mismatch_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "mismatch_code" TEXT NOT NULL CHECK ("mismatch_code" IN ('aligned', 'contract_missing', 'contract_stale', 'implementation_stale', 'standard_stale', 'test_missing', 'test_stale', 'test_incomplete', 'reference_missing', 'reference_stale', 'example_missing', 'example_stale', 'registration_missing', 'registration_stale', 'duplicate_identity', 'owner_mismatch', 'blade_alias_mismatch', 'source_path_mismatch', 'dependency_mismatch', 'provenance_unknown', 'review_unknown', 'lifecycle_conflict', 'accessibility_evidence_missing', 'browser_evidence_missing', 'responsive_evidence_missing', 'investigate')),
    "explanation" TEXT NOT NULL,
    "evidence_source_reference_id" TEXT,
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id"),
    FOREIGN KEY ("evidence_source_reference_id") REFERENCES "ui_source_references" ("source_reference_id")
);

CREATE INDEX "idx_ui_mismatches_surface_id" ON "ui_mismatches" ("surface_id");
CREATE INDEX "idx_ui_mismatches_evidence_source_reference_id" ON "ui_mismatches" ("evidence_source_reference_id");

CREATE TABLE "ui_test_traces" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "source_schema_version" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "trace_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "surface_ui_key" TEXT,
    "test_path" TEXT NOT NULL,
    "test_exists" TEXT NOT NULL CHECK ("test_exists" IN ('true', 'false')),
    "test_type" TEXT,
    "current_result" TEXT,
    "test_authority" TEXT,
    "accessibility_behavior_covered" TEXT CHECK ("accessibility_behavior_covered" IN ('true', 'false')),
    "javascript_behavior_covered" TEXT CHECK ("javascript_behavior_covered" IN ('true', 'false')),
    "contract_fields_covered_count" INTEGER NOT NULL,
    "rendered_states_covered_count" INTEGER NOT NULL,
    "evidence_source_reference_id" TEXT,
    "source_fingerprint" TEXT NOT NULL,
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id"),
    FOREIGN KEY ("evidence_source_reference_id") REFERENCES "ui_source_references" ("source_reference_id")
);

CREATE INDEX "idx_ui_test_traces_surface_id" ON "ui_test_traces" ("surface_id");
CREATE INDEX "idx_ui_test_traces_evidence_source_reference_id" ON "ui_test_traces" ("evidence_source_reference_id");

CREATE TABLE "ui_test_trace_coverage" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "source_schema_version" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "coverage_id" TEXT NOT NULL PRIMARY KEY,
    "trace_id" TEXT NOT NULL,
    "coverage_kind" TEXT NOT NULL CHECK ("coverage_kind" IN ('contract_field', 'rendered_state', 'accessibility_behavior', 'javascript_behavior')),
    "coverage_value" TEXT NOT NULL,
    FOREIGN KEY ("trace_id") REFERENCES "ui_test_traces" ("trace_id")
);

CREATE INDEX "idx_ui_test_trace_coverage_trace_id" ON "ui_test_trace_coverage" ("trace_id");

CREATE TABLE "ui_standards_evidence" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "source_schema_version" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "standard_evidence_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "standard_path" TEXT NOT NULL,
    "claimed_scope" TEXT,
    "implementation_alignment" TEXT NOT NULL CHECK ("implementation_alignment" IN ('aligned', 'partial', 'misaligned', 'stale', 'unknown', 'not_applicable')),
    "contract_alignment" TEXT NOT NULL CHECK ("contract_alignment" IN ('aligned', 'partial', 'misaligned', 'stale', 'unknown', 'not_applicable')),
    "reference_or_example_alignment" TEXT NOT NULL CHECK ("reference_or_example_alignment" IN ('aligned', 'partial', 'misaligned', 'stale', 'unknown', 'not_applicable')),
    "authority_state" TEXT NOT NULL CHECK ("authority_state" IN ('canonical', 'active_guidance', 'mixed', 'historical', 'superseded', 'unknown')),
    "staleness_evidence" TEXT,
    "evidence_source_reference_id" TEXT,
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id"),
    FOREIGN KEY ("evidence_source_reference_id") REFERENCES "ui_source_references" ("source_reference_id")
);

CREATE INDEX "idx_ui_standards_evidence_surface_id" ON "ui_standards_evidence" ("surface_id");
CREATE INDEX "idx_ui_standards_evidence_evidence_source_reference_id" ON "ui_standards_evidence" ("evidence_source_reference_id");

CREATE TABLE "ui_metadata_evidence" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "source_schema_version" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "metadata_evidence_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "metadata_field" TEXT NOT NULL CHECK ("metadata_field" IN ('human_readable_header', 'ui_key', 'blade_alias', 'implementation_path_reference', 'contract_path_reference', 'contract_schema_version', 'public_api_version', 'verification_commit', 'verification_timestamp', 'source_hash', 'contract_hash', 'last_updated')),
    "presence_state" TEXT NOT NULL CHECK ("presence_state" IN ('present', 'absent', 'unknown', 'not_applicable')),
    "observed_value" TEXT,
    "observed_format" TEXT,
    "agreement_state" TEXT NOT NULL CHECK ("agreement_state" IN ('aligned', 'disagrees', 'partial', 'unknown', 'not_applicable')),
    "known_disagreement" TEXT,
    "evidence_source_reference_id" TEXT,
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id"),
    FOREIGN KEY ("evidence_source_reference_id") REFERENCES "ui_source_references" ("source_reference_id")
);

CREATE INDEX "idx_ui_metadata_evidence_surface_id" ON "ui_metadata_evidence" ("surface_id");
CREATE INDEX "idx_ui_metadata_evidence_evidence_source_reference_id" ON "ui_metadata_evidence" ("evidence_source_reference_id");

CREATE TABLE "ui_dependencies" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "source_schema_version" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "dependency_id" TEXT NOT NULL PRIMARY KEY,
    "surface_id" TEXT NOT NULL,
    "dependency_kind" TEXT NOT NULL CHECK ("dependency_kind" IN ('lower_tier_surface', 'component', 'pattern', 'layout', 'blade_alias', 'css', 'javascript', 'icon', 'pictogram', 'asset', 'registration', 'module_contribution', 'other')),
    "dependency_target_surface_id" TEXT,
    "dependency_target_ui_key" TEXT,
    "dependency_path_or_value" TEXT,
    "relationship" TEXT,
    "required_state" TEXT NOT NULL CHECK ("required_state" IN ('required', 'optional', 'conditional', 'unknown')),
    "resolution_state" TEXT NOT NULL CHECK ("resolution_state" IN ('resolved', 'missing', 'stale', 'ambiguous', 'unknown', 'not_applicable')),
    "evidence_source_reference_id" TEXT,
    FOREIGN KEY ("surface_id") REFERENCES "ui_surfaces" ("surface_id"),
    FOREIGN KEY ("dependency_target_surface_id") REFERENCES "ui_surfaces" ("surface_id"),
    FOREIGN KEY ("evidence_source_reference_id") REFERENCES "ui_source_references" ("source_reference_id")
);

CREATE INDEX "idx_ui_dependencies_surface_id" ON "ui_dependencies" ("surface_id");
CREATE INDEX "idx_ui_dependencies_dependency_target_surface_id" ON "ui_dependencies" ("dependency_target_surface_id");
CREATE INDEX "idx_ui_dependencies_evidence_source_reference_id" ON "ui_dependencies" ("evidence_source_reference_id");

CREATE TABLE "ui_source_references" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "source_schema_version" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "source_reference_id" TEXT NOT NULL PRIMARY KEY,
    "subject_type" TEXT NOT NULL CHECK ("subject_type" IN ('surface', 'surface_file', 'mismatch', 'test_trace', 'standard_evidence', 'metadata_evidence', 'dependency', 'review_status')),
    "subject_id" TEXT NOT NULL,
    "evidence_type" TEXT NOT NULL CHECK ("evidence_type" IN ('implementation', 'contract', 'registration', 'test', 'standard', 'reference', 'example', 'route', 'css', 'javascript', 'asset', 'provenance', 'git', 'generated_observation', 'manual_review', 'other')),
    "path" TEXT,
    "line_start" INTEGER,
    "line_end" INTEGER,
    "claim" TEXT,
    "exists_at_baseline" TEXT NOT NULL CHECK ("exists_at_baseline" IN ('true', 'false')),
    "source_blob_oid" TEXT,
    "source_sha256" TEXT
);

CREATE TABLE "ui_review_status" (
    "export_id" TEXT NOT NULL,
    "inventory_baseline_sha" TEXT NOT NULL,
    "source_schema_version" TEXT NOT NULL,
    "export_schema_version" TEXT NOT NULL,
    "review_status_id" TEXT NOT NULL PRIMARY KEY,
    "subject_type" TEXT NOT NULL CHECK ("subject_type" IN ('surface', 'test_trace', 'standard_evidence', 'metadata_evidence', 'dependency', 'mismatch')),
    "subject_id" TEXT NOT NULL,
    "reviewed" TEXT NOT NULL CHECK ("reviewed" IN ('true', 'false')),
    "review_required" TEXT NOT NULL CHECK ("review_required" IN ('true', 'false')),
    "reviewer" TEXT,
    "reviewed_at_utc" TEXT,
    "review_note" TEXT,
    "source_fingerprint" TEXT NOT NULL,
    "stale_reason" TEXT,
    "pending_reason" TEXT
);
