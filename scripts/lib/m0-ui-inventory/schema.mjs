/**
 * ============================================================================
 * File: scripts/lib/m0-ui-inventory/schema.mjs
 * Purpose: Controlled issue #30 inventory schemas and review seed factories.
 * ============================================================================
 */

import { makeTraceId, sourceFingerprint, uniqueSorted } from "./utilities.mjs";

export const PINNED_INVENTORY_BASELINE =
    "1d103f5fa47aab8c8adfba8ea134dd29540426fe";

export const REQUIRED_SURFACE_FIELDS = [
    "ui_key",
    "current_slug",
    "surface_type",
    "ownership_area",
    "owner_key",
    "capability_key",
    "module_key",
    "blade_alias",
    "implementation_entry",
    "implementation_support_files",
    "registration_evidence",
    "contract_path",
    "contract_status",
    "reference_path",
    "example_paths",
    "css_paths",
    "javascript_paths",
    "icon_or_asset_dependencies",
    "lower_tier_dependencies",
    "public_api_evidence",
    "contract_api_evidence",
    "standards_evidence",
    "metadata_evidence",
    "carbon_provenance",
    "app_owned_deviations",
    "lifecycle_claim",
    "review_claim",
    "accessibility_evidence",
    "responsive_evidence",
    "browser_evidence",
    "test_paths",
    "test_status",
    "test_authority",
    "known_mismatches",
    "inventory_disposition",
    "target_question",
    "evidence_source",
];

export const REQUIRED_TRACE_FIELDS = [
    "surface_ui_key",
    "test_path",
    "test_exists",
    "test_type",
    "contract_fields_covered",
    "rendered_states_covered",
    "accessibility_behavior_covered",
    "javascript_behavior_covered",
    "current_result",
    "test_authority",
    "evidence_source",
];

export const SURFACE_TYPES = new Set([
    "element",
    "primitive",
    "component",
    "component_family",
    "subcomponent",
    "pattern",
    "layout",
    "shell",
    "navigation",
    "url_view",
    "renderer",
    "view_model",
    "page_data",
    "ui_contribution",
    "compatibility_alias",
    "css_control",
    "javascript_control",
    "icon_system",
    "pictogram_system",
]);

export const OWNERSHIP_AREAS = new Set([
    "core",
    "module",
    "ui",
    "not_applicable",
    "unknown",
]);

export const CONTRACT_STATUSES = new Set([
    "present",
    "missing",
    "multiple",
    "variation",
    "unresolved",
    "not_applicable",
    "unknown",
]);

export const MISMATCH_CLASSIFICATIONS = new Set([
    "aligned",
    "contract_missing",
    "contract_stale",
    "implementation_stale",
    "standard_stale",
    "test_missing",
    "test_stale",
    "test_incomplete",
    "reference_missing",
    "reference_stale",
    "example_missing",
    "example_stale",
    "registration_missing",
    "registration_stale",
    "duplicate_identity",
    "owner_mismatch",
    "blade_alias_mismatch",
    "source_path_mismatch",
    "dependency_mismatch",
    "provenance_unknown",
    "review_unknown",
    "lifecycle_conflict",
    "accessibility_evidence_missing",
    "browser_evidence_missing",
    "responsive_evidence_missing",
    "investigate",
]);

export const INVENTORY_DISPOSITIONS = new Set([
    "retain",
    "compatibility",
    "duplicate",
    "investigate",
]);

export const CARBON_PROVENANCE_VALUES = new Set([
    "carbon_direct_port",
    "carbon_api_adaptation",
    "carbon_visual_reference",
    "carbon_behavior_reference",
    "app_owned",
    "mixed",
    "unknown",
    "not_applicable",
]);

export const TEST_TYPES = new Set([
    "contract schema",
    "API rendering",
    "prop behavior",
    "slot behavior",
    "variant rendering",
    "state rendering",
    "class contract",
    "accessibility",
    "JavaScript behavior",
    "browser",
    "visual",
    "snapshot",
    "integration",
    "incidental markup assertion",
    "unknown",
]);

export const TEST_RESULTS = new Set([
    "passed",
    "failed",
    "warning",
    "not_run",
    "missing",
    "unknown",
]);

export const TEST_STATUSES = new Set([
    "passing",
    "failing",
    "mixed",
    "warning",
    "not_run",
    "missing",
    "unknown",
    "not_applicable",
]);

export const TEST_AUTHORITIES = new Set([
    "authoritative",
    "partial",
    "incidental",
    "stale",
    "unknown",
    "not_applicable",
]);

export function createSurfaceReviewSeed(observation) {
    const contractPaths = observation.contracts.map(
        (contract) => contract.path,
    );
    const contractStatus =
        contractPaths.length === 0
            ? "missing"
            : contractPaths.length > 1
              ? "multiple"
              : observation.contracts[0].filename_variation
                ? "variation"
                : "present";

    const testPaths = uniqueSorted(
        observation.test_candidates.map((candidate) => candidate.path),
    );

    return {
        _record_id: observation.record_id,
        _source_fingerprint: observation.source_fingerprint,
        _reviewed: false,
        _review_required: true,
        _review_note:
            "Generated seed. Review every field against the pinned implementation-first evidence order.",
        ui_key: observation.declared_ui_key ?? "unknown",
        current_slug: observation.current_slug ?? "unknown",
        surface_type: observation.surface_type,
        ownership_area:
            observation.ownership_candidate?.ownership_area ?? "unknown",
        owner_key: observation.ownership_candidate?.owner_key ?? "unknown",
        capability_key:
            observation.ownership_candidate?.capability_key ?? "unknown",
        module_key:
            observation.ownership_candidate?.module_key ?? "not_applicable",
        blade_alias:
            observation.blade_aliases.length === 1
                ? observation.blade_aliases[0]
                : observation.blade_aliases.length > 1
                  ? observation.blade_aliases
                  : "not_applicable",
        implementation_entry: observation.implementation_entry,
        implementation_support_files: observation.implementation_support_files,
        registration_evidence: observation.registration_evidence,
        contract_path: contractPaths.length === 0 ? "missing" : contractPaths,
        contract_status: contractStatus,
        reference_path:
            observation.reference_paths.length === 0
                ? "missing"
                : observation.reference_paths,
        example_paths: observation.example_paths,
        css_paths: observation.css_paths,
        javascript_paths: observation.javascript_paths,
        icon_or_asset_dependencies: observation.icon_or_asset_dependencies,
        lower_tier_dependencies: observation.lower_tier_dependencies,
        public_api_evidence: observation.public_api_evidence,
        contract_api_evidence: observation.contract_api_evidence,
        standards_evidence: observation.standard_candidates.map((standard) => ({
            standard_path: standard.path,
            claimed_scope: standard.claimed_scope ?? "unknown",
            implementation_alignment: "unknown",
            contract_alignment: "unknown",
            reference_or_example_alignment: "unknown",
            authority_state: standard.authority_state ?? "unknown",
            staleness_evidence: [],
            evidence_source: standard.evidence_source,
        })),
        metadata_evidence: observation.metadata_evidence,
        carbon_provenance: "unknown",
        app_owned_deviations: [],
        lifecycle_claim: observation.lifecycle_claim ?? "unknown",
        review_claim: observation.review_claim ?? "unknown",
        accessibility_evidence: observation.accessibility_evidence,
        responsive_evidence: observation.responsive_evidence,
        browser_evidence: observation.browser_evidence,
        test_paths: testPaths,
        test_status: testPaths.length === 0 ? "missing" : "not_run",
        test_authority: testPaths.length === 0 ? "unknown" : "unknown",
        known_mismatches: observation.generated_mismatches,
        inventory_disposition:
            observation.generated_mismatches.length > 0
                ? "investigate"
                : "retain",
        target_question: observation.target_question ?? "not_applicable",
        evidence_source: observation.evidence_source,
    };
}

export function createTestTraceSeed(surfaceReview, candidate) {
    return {
        _trace_id: makeTraceId(surfaceReview._record_id, candidate.path),
        _surface_record_id: surfaceReview._record_id,
        _source_fingerprint: sourceFingerprint(candidate),
        _reviewed: false,
        _review_required: true,
        _review_note:
            "Generated trace seed. Review coverage, result, and authority without duplicating issue #32 suite ownership.",
        surface_ui_key: surfaceReview.ui_key,
        test_path: candidate.path,
        test_exists: candidate.exists,
        test_type: candidate.test_type ?? "unknown",
        contract_fields_covered: candidate.contract_fields_covered ?? [],
        rendered_states_covered: candidate.rendered_states_covered ?? [],
        accessibility_behavior_covered:
            candidate.accessibility_behavior_covered ?? "unknown",
        javascript_behavior_covered:
            candidate.javascript_behavior_covered ?? "unknown",
        current_result: candidate.current_result ?? "not_run",
        test_authority: candidate.test_authority ?? "unknown",
        evidence_source: candidate.evidence_source ?? [
            `path:${candidate.path}`,
        ],
    };
}

export function summarizeTestStatus(traces) {
    if (traces.length === 0) {
        return "missing";
    }

    const results = new Set(traces.map((trace) => trace.current_result));

    if (results.has("failed") && results.size > 1) {
        return "mixed";
    }

    if (results.has("failed")) {
        return "failing";
    }

    if (results.has("warning")) {
        return results.size > 1 ? "mixed" : "warning";
    }

    if (results.size === 1 && results.has("passed")) {
        return "passing";
    }

    if (results.has("passed")) {
        return "mixed";
    }

    if (results.size === 1 && results.has("not_run")) {
        return "not_run";
    }

    if (results.size === 1 && results.has("missing")) {
        return "missing";
    }

    return "unknown";
}

export function summarizeTestAuthority(traces) {
    if (traces.length === 0) {
        return "unknown";
    }

    const authorities = new Set(traces.map((trace) => trace.test_authority));

    if (authorities.size === 1) {
        return [...authorities][0];
    }

    if (authorities.has("stale") && authorities.size === 1) {
        return "stale";
    }

    if (authorities.has("authoritative")) {
        return "partial";
    }

    if (authorities.has("partial")) {
        return "partial";
    }

    if (authorities.has("incidental")) {
        return "incidental";
    }

    if (authorities.has("stale")) {
        return "stale";
    }

    return "unknown";
}
