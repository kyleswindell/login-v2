/**
 * ============================================================================
 * File: scripts/check-m0-ui-current-state-inventory.mjs
 * Purpose: Validate corrected Issue #30 evidence and semantic traceability.
 * ============================================================================
 */

import { readFileSync, statSync } from "node:fs";
import { resolve } from "node:path";
import process from "node:process";
import {
    CARBON_PROVENANCE_VALUES,
    CONTRACT_STATUSES,
    createStandardProjection,
    INVENTORY_DISPOSITIONS,
    MISMATCH_CLASSIFICATIONS,
    OWNERSHIP_AREAS,
    PINNED_INVENTORY_BASELINE,
    REQUIRED_SURFACE_FIELDS,
    REQUIRED_TRACE_FIELDS,
    STANDARD_ALIGNMENT_VALUES,
    STANDARD_AUTHORITY_STATES,
    standardReviewRequiresStale,
    standardSourceFingerprint,
    SURFACE_TYPES,
    TEST_AUTHORITIES,
    TEST_RESULTS,
    TEST_STATUSES,
    TEST_TYPES,
    TRACE_RELATIONSHIP_KINDS,
    summarizeTestAuthority,
    summarizeTestStatus,
} from "./lib/m0-ui-inventory/schema.mjs";
import {
    parseArguments,
    readJson,
    sourceFingerprint,
    stableStringify,
    uniqueSorted,
} from "./lib/m0-ui-inventory/utilities.mjs";

const args = parseArguments(process.argv.slice(2));
const repositoryRoot = process.cwd();
const config = readJson(
    resolve(
        repositoryRoot,
        args.config ?? "scripts/m0-ui-inventory.config.json",
    ),
);
const paths = {
    observations: resolve(repositoryRoot, config.outputs.observations),
    classifications: resolve(repositoryRoot, config.outputs.classifications),
    test_traces: resolve(repositoryRoot, config.outputs.test_traces),
    document: resolve(repositoryRoot, config.outputs.document),
};
const observations = readJson(paths.observations);
const classifications = readJson(paths.classifications);
const testTraces = readJson(paths.test_traces);
const errors = [];
const sourcePaths = new Set(observations.source_path_index ?? []);
const observationById = new Map(
    observations.surfaces.map((surface) => [surface.record_id, surface]),
);
const reviewById = new Map(
    classifications.items.map((item) => [item._record_id, item]),
);
const standardCandidatesByPath = new Map(
    observations.surfaces.flatMap((surface) =>
        surface.standard_candidates.map((candidate) => [
            candidate.path,
            candidate,
        ]),
    ),
);
const standardReviewByPath = new Map(
    (classifications.standard_reviews ?? []).map((review) => [
        review._standard_path,
        review,
    ]),
);

check(
    config.inventory_baseline === PINNED_INVENTORY_BASELINE,
    "Config baseline mismatch.",
);
check(
    observations.baseline.sha === PINNED_INVENTORY_BASELINE,
    "Observation baseline mismatch.",
);
check(
    classifications.baseline_sha === PINNED_INVENTORY_BASELINE,
    "Classification baseline mismatch.",
);
check(
    testTraces.baseline_sha === PINNED_INVENTORY_BASELINE,
    "Test-trace baseline mismatch.",
);
check(
    observations.schema_version === 2,
    "Corrected observations must use schema version 2.",
);
check(
    classifications.schema_version === 2,
    "Corrected classifications must use schema version 2.",
);
check(
    testTraces.schema_version === 2,
    "Corrected test traces must use schema version 2.",
);
check(
    observations.baseline.expected_execution_base ===
        config.expected_execution_base,
    "Observation execution base does not match config.",
);
check(
    observations.baseline.ui_source_diff?.changed === false,
    "UI source differs between baseline and execution base.",
);
check(
    classifications.generated_from_observations_sha256 ===
        sourceFingerprint(observations),
    "Classifications are not synchronized to observations.",
);
check(
    arraysEqual(observations.required_surface_fields, REQUIRED_SURFACE_FIELDS),
    "Observation surface fields disagree with Issue #30.",
);
check(
    arraysEqual(observations.required_trace_fields, REQUIRED_TRACE_FIELDS),
    "Observation trace fields disagree with Issue #30.",
);
check(
    (observations.unclaimed_material_files ?? []).length === 0,
    `Unclaimed material files remain: ${(observations.unclaimed_material_files ?? []).join(", ")}`,
);
check(
    (classifications.orphaned_prior_records ?? []).length === 0,
    "Orphaned prior surface reviews remain.",
);
check(
    (classifications.orphaned_prior_standard_reviews ?? []).length === 0,
    "Orphaned prior standard reviews remain.",
);
check(
    (testTraces.orphaned_prior_traces ?? []).length === 0,
    "Orphaned prior test traces remain.",
);
check(
    String(testTraces.ownership_boundary ?? "").includes("Issue #32"),
    "Test artifact does not preserve Issue #32 ownership.",
);
validateIssue29Support();
validateCoverage();
validateArtifactLimits();

for (const observation of observations.surfaces) {
    check(
        reviewById.has(observation.record_id),
        `Missing review for ${observation.record_id}.`,
    );
}

for (const [standardPath] of standardCandidatesByPath) {
    check(
        standardReviewByPath.has(standardPath),
        `Missing standard review for ${standardPath}.`,
    );
}

for (const review of classifications.standard_reviews ?? []) {
    validateStandardReview(review);
}

check(
    [...standardCandidatesByPath].some(([standardPath]) => {
        const review = standardReviewByPath.get(standardPath);
        return [
            review?.implementation_alignment,
            review?.contract_alignment,
            review?.reference_or_example_alignment,
        ].some((value) => value !== "unknown");
    }),
    "All linked standards still have wholly unknown alignment evidence.",
);
validateContractFileContradiction();

for (const item of classifications.items) {
    validateSurface(item);
}

const tracePairs = new Set();
const traceCountByPath = new Map();

for (const trace of testTraces.test_traces) {
    validateTrace(trace);
    const pair = `${trace._surface_record_id}\0${trace.test_path}`;
    check(!tracePairs.has(pair), `Duplicate surface/test trace pair: ${pair}`);
    tracePairs.add(pair);
    traceCountByPath.set(
        trace.test_path,
        (traceCountByPath.get(trace.test_path) ?? 0) + 1,
    );
}

for (const [path, count] of traceCountByPath) {
    check(
        count <= 20,
        `${path} is linked to ${count} surfaces; review for broad false associations.`,
    );
}

validateDuplicateUiKeys();

if (errors.length > 0) {
    console.error(
        [
            "Issue #30 corrected inventory validation failed:",
            ...errors.map((error) => `- ${error}`),
        ].join("\n"),
    );
    process.exit(1);
}

console.log(
    [
        "Issue #30 corrected inventory validation passed.",
        `Material surfaces: ${classifications.items.length}.`,
        `Reviewed UI test traces: ${testTraces.test_traces.length}.`,
        `Reviewed unique standards: ${classifications.standard_reviews.length}.`,
        `Pinned inventory baseline: ${PINNED_INVENTORY_BASELINE}.`,
        `Combined artifact bytes: ${artifactMetrics().bytes}.`,
        `Combined artifact lines: ${artifactMetrics().lines}.`,
    ].join("\n"),
);

function validateSurface(item) {
    const observation = observationById.get(item._record_id);
    check(
        Boolean(observation),
        `Review has no observation: ${item._record_id}.`,
    );

    for (const field of REQUIRED_SURFACE_FIELDS) {
        check(
            Object.hasOwn(item, field),
            `${item._record_id} is missing ${field}.`,
        );
    }

    check(item._reviewed === true, `${item._record_id} is not reviewed.`);
    check(
        item._review_required !== true,
        `${item._record_id} still requires review.`,
    );
    check(
        item._source_fingerprint === observation?.source_fingerprint,
        `${item._record_id} source fingerprint is stale.`,
    );
    check(
        SURFACE_TYPES.has(item.surface_type),
        `${item._record_id} has invalid surface_type.`,
    );
    check(
        OWNERSHIP_AREAS.has(item.ownership_area),
        `${item._record_id} has invalid ownership_area.`,
    );
    check(
        CONTRACT_STATUSES.has(item.contract_status),
        `${item._record_id} has invalid contract_status.`,
    );
    check(
        INVENTORY_DISPOSITIONS.has(item.inventory_disposition),
        `${item._record_id} has invalid disposition.`,
    );
    check(
        CARBON_PROVENANCE_VALUES.has(item.carbon_provenance),
        `${item._record_id} has invalid provenance.`,
    );
    check(
        TEST_STATUSES.has(item.test_status),
        `${item._record_id} has invalid test_status.`,
    );
    check(
        TEST_AUTHORITIES.has(item.test_authority),
        `${item._record_id} has invalid test_authority.`,
    );
    check(
        typeof item.ui_key === "string",
        `${item._record_id} ui_key must be a string.`,
    );
    check(
        typeof item.current_slug === "string",
        `${item._record_id} slug must be a string.`,
    );
    check(
        typeof item.current_slug === "string" &&
            item.current_slug.trim() !== "",
        `${item._record_id} current_slug must not be empty.`,
    );
    check(
        item.target_question === null ||
            (typeof item.target_question === "string" &&
                item.target_question.trim() !== ""),
        `${item._record_id} target_question must not be blank.`,
    );
    check(
        Array.isArray(item.known_mismatches),
        `${item._record_id} mismatches must be an array.`,
    );

    for (const mismatch of item.known_mismatches ?? []) {
        check(
            MISMATCH_CLASSIFICATIONS.has(mismatch),
            `${item._record_id} has invalid mismatch ${mismatch}.`,
        );
    }

    if (item.known_mismatches?.includes("aligned")) {
        check(
            item.known_mismatches.length === 1,
            `${item._record_id} combines aligned with another mismatch.`,
        );
    }

    validatePathField(
        item._record_id,
        "implementation_entry",
        item.implementation_entry,
        {
            allow: ["unknown", "not_applicable"],
        },
    );
    validatePathList(
        item._record_id,
        "implementation_support_files",
        item.implementation_support_files,
    );
    validatePathValue(item._record_id, "contract_path", item.contract_path, {
        allow: ["missing", "not_applicable", "unknown"],
    });
    validatePathValue(item._record_id, "reference_path", item.reference_path, {
        allow: ["missing", "not_applicable", "unknown"],
    });
    validatePathList(item._record_id, "example_paths", item.example_paths);
    validatePathList(item._record_id, "css_paths", item.css_paths);
    validatePathList(
        item._record_id,
        "javascript_paths",
        item.javascript_paths,
    );

    if (
        ["icon_system", "pictogram_system"].includes(item.surface_type) &&
        (observation?.asset_group_summary?.member_count ?? 0) > 0
    ) {
        check(
            typeof item.implementation_entry === "string" &&
                item.implementation_entry.trim() !== "" &&
                item.implementation_entry !== "unknown",
            `${item._record_id} asset group requires a pinned implementation entry.`,
        );
    }

    check(
        Array.isArray(item.standards_evidence),
        `${item._record_id} standards_evidence must be an array.`,
    );
    for (const standard of item.standards_evidence ?? []) {
        check(
            typeof standard.standard_path === "string",
            `${item._record_id} standard lacks path.`,
        );
        validatePathField(
            item._record_id,
            "standards_evidence.standard_path",
            standard.standard_path,
        );
    }
    const expectedStandards = (observation?.standard_candidates ?? []).map(
        (candidate) =>
            createStandardProjection(
                candidate,
                standardReviewByPath.get(candidate.path),
            ),
    );
    check(
        stableStringify(item.standards_evidence ?? []) ===
            stableStringify(expectedStandards),
        `${item._record_id} standards_evidence differs from reviewed projection.`,
    );
    const expectsStandardStale = (observation?.standard_candidates ?? []).some(
        (candidate) =>
            standardReviewRequiresStale(
                standardReviewByPath.get(candidate.path),
            ),
    );
    check(
        item.known_mismatches?.includes("standard_stale") ===
            expectsStandardStale,
        `${item._record_id} standard_stale mismatch disagrees with reviewed standards.`,
    );

    const copiedTemplateContracts = (observation?.contracts ?? []).filter(
        (contract) => contract.template_copy === true,
    );
    if (copiedTemplateContracts.length > 0) {
        check(
            item.contract_status === "present",
            `${item._record_id} copied template contract must remain physically present.`,
        );
        for (const mismatch of ["contract_stale", "source_path_mismatch"]) {
            check(
                item.known_mismatches?.includes(mismatch),
                `${item._record_id} copied template contract lacks ${mismatch}.`,
            );
        }
    }
    if (
        item.surface_type === "pattern" &&
        (observation?.contracts ?? []).some(
            (contract) =>
                contract.identity?.type === "element" ||
                contract.identity?.group === "Foundation Elements",
        )
    ) {
        check(
            item.known_mismatches?.includes("lifecycle_conflict"),
            `${item._record_id} Pattern with Element identity lacks lifecycle_conflict.`,
        );
    }

    check(
        item.metadata_evidence && typeof item.metadata_evidence === "object",
        `${item._record_id} metadata evidence must be structured.`,
    );
    for (const field of [
        "human_readable_header",
        "ui_key",
        "blade_alias",
        "implementation_path_reference",
        "contract_path_reference",
        "contract_schema_version",
        "public_api_version",
        "verification_commit",
        "verification_timestamp",
        "source_hash",
        "contract_hash",
        "last_updated",
        "known_disagreements",
        "evidence_source",
    ]) {
        check(
            Object.hasOwn(item.metadata_evidence ?? {}, field),
            `${item._record_id} metadata is missing ${field}.`,
        );
    }

    const traces = testTraces.test_traces.filter(
        (trace) => trace._surface_record_id === item._record_id,
    );
    const tracePaths = uniqueSorted(traces.map((trace) => trace.test_path));
    check(
        arraysEqual(uniqueSorted(item.test_paths ?? []), tracePaths),
        `${item._record_id} test_paths disagree with traces.`,
    );

    if (traces.length === 0) {
        check(
            ["missing", "unknown", "not_applicable"].includes(item.test_status),
            `${item._record_id} has no traces but status=${item.test_status}.`,
        );
        check(
            ["unknown", "not_applicable"].includes(item.test_authority),
            `${item._record_id} has no traces but authority=${item.test_authority}.`,
        );
    } else {
        check(
            item.test_status === summarizeTestStatus(traces),
            `${item._record_id} test status disagrees with traces.`,
        );
        check(
            item.test_authority === summarizeTestAuthority(traces),
            `${item._record_id} test authority disagrees with traces.`,
        );
    }
}

function validateStandardReview(review) {
    const candidate = standardCandidatesByPath.get(review._standard_path);
    check(
        Boolean(candidate),
        `Standard review is not linked: ${review._standard_path}.`,
    );
    check(
        review._reviewed === true,
        `${review._standard_path} standard is not reviewed.`,
    );
    check(
        review._review_required !== true,
        `${review._standard_path} standard still requires review.`,
    );
    check(
        review._source_fingerprint ===
            (candidate ? standardSourceFingerprint(candidate) : null),
        `${review._standard_path} standard source fingerprint is stale.`,
    );
    check(
        typeof review.claimed_scope === "string" &&
            review.claimed_scope.trim() !== "",
        `${review._standard_path} standard claimed_scope is blank.`,
    );
    for (const field of [
        "implementation_alignment",
        "contract_alignment",
        "reference_or_example_alignment",
    ]) {
        check(
            STANDARD_ALIGNMENT_VALUES.has(review[field]),
            `${review._standard_path} standard has invalid ${field}.`,
        );
    }
    check(
        STANDARD_AUTHORITY_STATES.has(review.authority_state),
        `${review._standard_path} standard has invalid authority_state.`,
    );
    check(
        Array.isArray(review.staleness_evidence),
        `${review._standard_path} staleness_evidence must be an array.`,
    );
    check(
        Array.isArray(review.moved_responsibilities),
        `${review._standard_path} moved_responsibilities must be an array.`,
    );
    check(
        Array.isArray(review.evidence_source) &&
            review.evidence_source.includes(`path:${review._standard_path}`),
        `${review._standard_path} standard lacks direct path evidence.`,
    );
    check(
        [
            review.implementation_alignment,
            review.contract_alignment,
            review.reference_or_example_alignment,
        ].some((value) => value !== "unknown"),
        `${review._standard_path} standard alignments remain wholly unknown.`,
    );
}

function validateContractFileContradiction() {
    const path = "docs/02-standards/ui/contract-file.md";
    const review = standardReviewByPath.get(path);
    check(Boolean(review), `${path} requires a reviewed contradiction record.`);
    check(
        ["mixed_authority", "stale"].includes(review?.authority_state),
        `${path} must record mixed or stale authority.`,
    );
    check(
        (review?.staleness_evidence?.length ?? 0) > 0,
        `${path} lacks staleness evidence.`,
    );
    check(
        (review?.moved_responsibilities?.length ?? 0) > 0,
        `${path} lacks moved-responsibility evidence.`,
    );
}

function validateTrace(trace) {
    for (const field of REQUIRED_TRACE_FIELDS) {
        check(
            Object.hasOwn(trace, field),
            `${trace._trace_id} is missing ${field}.`,
        );
    }

    const surface = reviewById.get(trace._surface_record_id);
    const observation = observationById.get(trace._surface_record_id);
    check(
        Boolean(surface),
        `${trace._trace_id} references an unknown surface.`,
    );
    check(
        Boolean(observation),
        `${trace._trace_id} references an unknown observation.`,
    );
    check(trace._reviewed === true, `${trace._trace_id} is not reviewed.`);
    check(
        trace._review_required !== true,
        `${trace._trace_id} still requires review.`,
    );
    check(
        trace.surface_ui_key === surface?.ui_key,
        `${trace._trace_id} UI key does not match surface.`,
    );
    check(
        TEST_TYPES.has(trace.test_type),
        `${trace._trace_id} has invalid test_type.`,
    );
    check(
        TEST_RESULTS.has(trace.current_result),
        `${trace._trace_id} has invalid result.`,
    );
    check(
        TEST_AUTHORITIES.has(trace.test_authority),
        `${trace._trace_id} has invalid authority.`,
    );
    check(
        trace.test_exists === true,
        `${trace._trace_id} does not resolve to an existing test.`,
    );
    validatePathField(trace._trace_id, "test_path", trace.test_path);

    const relationship = trace._relationship_evidence;
    check(
        Boolean(relationship),
        `${trace._trace_id} lacks relationship evidence.`,
    );
    check(
        TRACE_RELATIONSHIP_KINDS.has(relationship?.kind),
        `${trace._trace_id} has invalid relationship kind.`,
    );
    validateRelationship(trace, observation, relationship);
}

function validateRelationship(trace, observation, relationship) {
    if (!observation || !relationship) return;
    const value = String(relationship.value ?? "");

    if (relationship.kind === "owner_local_test") {
        check(
            trace.test_path.startsWith(`${value}/__tests__/`),
            `${trace._trace_id} owner-local relationship is invalid.`,
        );
        return;
    }

    if (relationship.kind === "exact_repository_path_reference") {
        const validPaths = new Set([
            observation.implementation_entry,
            ...observation.implementation_support_files,
            ...observation.contracts.map((contract) => contract.path),
        ]);
        check(
            validPaths.has(value),
            `${trace._trace_id} references a path outside its surface.`,
        );
        return;
    }

    if (relationship.kind === "exact_blade_alias_reference") {
        check(
            observation.blade_aliases.includes(value),
            `${trace._trace_id} references an unrelated Blade alias.`,
        );
        return;
    }

    if (relationship.kind === "exact_ui_key_reference") {
        check(
            observation.declared_ui_key === value,
            `${trace._trace_id} references an unrelated UI key.`,
        );
        return;
    }

    if (relationship.kind === "exact_symbol_reference") {
        check(
            value.length >= 5,
            `${trace._trace_id} symbol relationship is too generic.`,
        );
        check(
            !["index", "main", "page", "show", "edit", "create"].includes(
                value.toLowerCase(),
            ),
            `${trace._trace_id} uses a prohibited generic symbol.`,
        );
    }
}

function validateCoverage() {
    const counts = observations.summary?.surface_type_counts ?? {};
    for (const type of config.required_coverage?.surface_types_any_of ?? []) {
        check(
            (counts[type] ?? 0) > 0,
            `Required material surface type ${type} was not collected.`,
        );
    }

    const collectedPaths = new Set(
        observations.surfaces.flatMap((surface) => [
            surface.implementation_entry,
            ...surface.implementation_support_files,
        ]),
    );

    for (const pattern of config.required_coverage?.required_path_patterns ??
        []) {
        const regex = new RegExp(pattern);
        check(
            [...collectedPaths].some((path) => regex.test(path)),
            `Required presentation path pattern was not represented: ${pattern}`,
        );
    }
}

function validateIssue29Support() {
    const support = observations.discovery?.issue_29_support;
    check(
        support?.status === "accepted_baseline_match",
        "Accepted Issue #29 supporting evidence was not loaded.",
    );
    check(
        support?.baseline_sha === PINNED_INVENTORY_BASELINE,
        "Issue #29 support baseline mismatch.",
    );
    check((support?.route_count ?? 0) > 0, "Issue #29 route support is empty.");
    check(
        (support?.module_count ?? 0) > 0,
        "Issue #29 Module support is empty.",
    );
    check(
        Boolean(observations.discovery?.commands?.route_list?.last_success),
        "No successful route evidence is available.",
    );
    check(
        Boolean(observations.discovery?.commands?.module_list?.last_success),
        "No successful Module evidence is available.",
    );
}

function validateArtifactLimits() {
    const metrics = artifactMetrics();
    const limits = config.artifact_limits ?? {};

    for (const key of [
        "observations",
        "classifications",
        "test_traces",
        "document",
    ]) {
        const metric = metrics.by_artifact[key];
        const limit = limits[key];
        if (!limit || !metric) continue;
        check(
            metric.bytes <= limit.max_bytes,
            `${key} is ${metric.bytes} bytes; limit=${limit.max_bytes}.`,
        );
        check(
            metric.lines <= limit.max_lines,
            `${key} is ${metric.lines} lines; limit=${limit.max_lines}.`,
        );
    }

    check(
        metrics.bytes <= limits.combined_max_bytes,
        `Combined artifacts are ${metrics.bytes} bytes; limit=${limits.combined_max_bytes}.`,
    );
    check(
        metrics.lines <= limits.combined_max_lines,
        `Combined artifacts are ${metrics.lines} lines; limit=${limits.combined_max_lines}.`,
    );
}

function artifactMetrics() {
    const byArtifact = {};
    let bytes = 0;
    let lines = 0;

    for (const [key, path] of Object.entries(paths)) {
        const content = readFileSync(path, "utf8");
        const metric = {
            bytes: statSync(path).size,
            lines: content.split(/\r?\n/).length,
        };
        byArtifact[key] = metric;
        bytes += metric.bytes;
        lines += metric.lines;
    }

    return { bytes, lines, by_artifact: byArtifact };
}

function validateDuplicateUiKeys() {
    const byKey = new Map();
    for (const item of classifications.items) {
        if (["unknown", "not_applicable", "missing"].includes(item.ui_key))
            continue;
        const matches = byKey.get(item.ui_key) ?? [];
        matches.push(item);
        byKey.set(item.ui_key, matches);
    }

    for (const [uiKey, items] of byKey) {
        if (items.length < 2) continue;
        for (const item of items) {
            check(
                item.known_mismatches.includes("duplicate_identity") &&
                    ["duplicate", "investigate"].includes(
                        item.inventory_disposition,
                    ),
                `Duplicate UI key ${uiKey} is not classified on ${item._record_id}.`,
            );
        }
    }
}

function validatePathValue(recordId, field, value, options = {}) {
    if (Array.isArray(value)) {
        validatePathList(recordId, field, value, options);
        return;
    }
    validatePathField(recordId, field, value, options);
}

function validatePathList(recordId, field, value, options = {}) {
    check(Array.isArray(value), `${recordId} ${field} must be an array.`);
    for (const path of value ?? [])
        validatePathField(recordId, field, path, options);
}

function validatePathField(recordId, field, value, options = {}) {
    const allowed = new Set(options.allow ?? []);
    if (allowed.has(value)) return;
    check(
        typeof value === "string" && value !== "",
        `${recordId} ${field} must be a path.`,
    );
    if (typeof value === "string" && value !== "") {
        check(
            sourcePaths.has(value),
            `${recordId} ${field} path is absent from pinned source: ${value}`,
        );
    }
}

function arraysEqual(left, right) {
    return JSON.stringify(left) === JSON.stringify(right);
}

function check(condition, message) {
    if (!condition) errors.push(message);
}
