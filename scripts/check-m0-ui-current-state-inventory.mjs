/**
 * ============================================================================
 * File: scripts/check-m0-ui-current-state-inventory.mjs
 * Purpose: Validate issue #30 evidence completeness, traceability, and review.
 * ============================================================================
 */

import { resolve } from "node:path";
import process from "node:process";
import {
    CARBON_PROVENANCE_VALUES,
    CONTRACT_STATUSES,
    INVENTORY_DISPOSITIONS,
    MISMATCH_CLASSIFICATIONS,
    OWNERSHIP_AREAS,
    PINNED_INVENTORY_BASELINE,
    REQUIRED_SURFACE_FIELDS,
    REQUIRED_TRACE_FIELDS,
    SURFACE_TYPES,
    TEST_AUTHORITIES,
    TEST_RESULTS,
    TEST_STATUSES,
    TEST_TYPES,
    summarizeTestAuthority,
    summarizeTestStatus,
} from "./lib/m0-ui-inventory/schema.mjs";
import {
    ensure,
    parseArguments,
    readJson,
    sourceFingerprint,
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
const observations = readJson(
    resolve(repositoryRoot, config.outputs.observations),
);
const classifications = readJson(
    resolve(repositoryRoot, config.outputs.classifications),
);
const testTraces = readJson(
    resolve(repositoryRoot, config.outputs.test_traces),
);

const errors = [];
const sourcePaths = new Set(observations.source_path_index ?? []);
const observationById = new Map(
    observations.surfaces.map((surface) => [surface.record_id, surface]),
);
const reviewById = new Map(
    classifications.items.map((item) => [item._record_id, item]),
);

check(
    config.inventory_baseline === PINNED_INVENTORY_BASELINE,
    `Config baseline must equal ${PINNED_INVENTORY_BASELINE}.`,
);
check(
    observations.baseline.sha === PINNED_INVENTORY_BASELINE,
    `Observation baseline must equal ${PINNED_INVENTORY_BASELINE}.`,
);
check(
    classifications.baseline_sha === PINNED_INVENTORY_BASELINE,
    `Classification baseline must equal ${PINNED_INVENTORY_BASELINE}.`,
);
check(
    testTraces.baseline_sha === PINNED_INVENTORY_BASELINE,
    `Test-trace baseline must equal ${PINNED_INVENTORY_BASELINE}.`,
);
check(
    observations.baseline.expected_execution_base ===
        config.expected_execution_base,
    "Observation expected execution base does not match config.",
);
check(
    observations.baseline.ui_source_diff?.changed === false,
    "UI source differs between the pinned inventory baseline and expected execution base.",
);
check(
    classifications.generated_from_observations_sha256 ===
        sourceFingerprint(observations),
    "Classifications are not synchronized to the current observations artifact.",
);
check(
    arraysEqual(observations.required_surface_fields, REQUIRED_SURFACE_FIELDS),
    "Observation required surface fields disagree with the issue schema.",
);
check(
    arraysEqual(observations.required_trace_fields, REQUIRED_TRACE_FIELDS),
    "Observation required trace fields disagree with the issue schema.",
);
check(
    (observations.unclaimed_material_files ?? []).length === 0,
    `Unclaimed material files remain: ${(observations.unclaimed_material_files ?? []).join(", ")}`,
);
check(
    (classifications.orphaned_prior_records ?? []).length === 0,
    `Orphaned prior surface reviews remain: ${(classifications.orphaned_prior_records ?? []).join(", ")}`,
);
check(
    (testTraces.orphaned_prior_traces ?? []).length === 0,
    `Orphaned prior test traces remain: ${(testTraces.orphaned_prior_traces ?? []).join(", ")}`,
);
check(
    String(testTraces.ownership_boundary ?? "").includes("Issue #32"),
    "Test trace artifact must preserve the issue #32 ownership boundary.",
);

for (const observation of observations.surfaces) {
    check(
        reviewById.has(observation.record_id),
        `Missing review for ${observation.record_id}.`,
    );
}

for (const item of classifications.items) {
    validateSurface(item);
}

const tracePairs = new Set();

for (const trace of testTraces.test_traces) {
    validateTrace(trace);
    const pair = `${trace._surface_record_id}\0${trace.test_path}`;
    check(!tracePairs.has(pair), `Duplicate surface/test trace pair: ${pair}`);
    tracePairs.add(pair);
}

validateDuplicateUiKeys();

if (errors.length > 0) {
    console.error(
        [
            "Issue #30 inventory validation failed:",
            ...errors.map((error) => `- ${error}`),
        ].join("\n"),
    );
    process.exit(1);
}

console.log(
    [
        "Issue #30 inventory validation passed.",
        `Material surfaces: ${classifications.items.length}.`,
        `Reviewed UI test traces: ${testTraces.test_traces.length}.`,
        `Pinned inventory baseline: ${PINNED_INVENTORY_BASELINE}.`,
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
        `${item._record_id} has invalid inventory_disposition.`,
    );
    check(
        CARBON_PROVENANCE_VALUES.has(item.carbon_provenance),
        `${item._record_id} has invalid carbon_provenance.`,
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
        `${item._record_id} current_slug must be a string.`,
    );
    check(
        Array.isArray(item.known_mismatches),
        `${item._record_id} known_mismatches must be an array.`,
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
            `${item._record_id} cannot combine aligned with another mismatch.`,
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

    check(
        Array.isArray(item.standards_evidence),
        `${item._record_id} standards_evidence must be an array.`,
    );

    for (const standard of item.standards_evidence ?? []) {
        check(
            typeof standard.standard_path === "string",
            `${item._record_id} standard evidence lacks standard_path.`,
        );
        validatePathField(
            item._record_id,
            "standards_evidence.standard_path",
            standard.standard_path,
        );
    }

    check(
        item.metadata_evidence !== null &&
            typeof item.metadata_evidence === "object",
        `${item._record_id} metadata_evidence must be structured.`,
    );

    for (const metadataField of [
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
            Object.hasOwn(item.metadata_evidence ?? {}, metadataField),
            `${item._record_id} metadata_evidence is missing ${metadataField}.`,
        );
    }

    const traces = testTraces.test_traces.filter(
        (trace) => trace._surface_record_id === item._record_id,
    );
    const tracePaths = uniqueSorted(traces.map((trace) => trace.test_path));
    check(
        arraysEqual(uniqueSorted(item.test_paths ?? []), tracePaths),
        `${item._record_id} test_paths do not exactly match detailed traces.`,
    );

    if (traces.length === 0) {
        check(
            ["missing", "unknown", "not_applicable"].includes(item.test_status),
            `${item._record_id} has no traces but test_status is ${item.test_status}.`,
        );
        check(
            ["unknown", "not_applicable"].includes(item.test_authority),
            `${item._record_id} has no traces but test_authority is ${item.test_authority}.`,
        );
    } else {
        check(
            item.test_status === summarizeTestStatus(traces),
            `${item._record_id} test_status disagrees with detailed traces.`,
        );
        check(
            item.test_authority === summarizeTestAuthority(traces),
            `${item._record_id} test_authority disagrees with detailed traces.`,
        );
    }
}

function validateTrace(trace) {
    for (const field of REQUIRED_TRACE_FIELDS) {
        check(
            Object.hasOwn(trace, field),
            `${trace._trace_id} is missing ${field}.`,
        );
    }

    const surface = reviewById.get(trace._surface_record_id);
    check(
        Boolean(surface),
        `${trace._trace_id} references an unknown surface.`,
    );
    check(trace._reviewed === true, `${trace._trace_id} is not reviewed.`);
    check(
        trace._review_required !== true,
        `${trace._trace_id} still requires review.`,
    );
    check(
        trace.surface_ui_key === surface?.ui_key,
        `${trace._trace_id} surface_ui_key does not match its material surface.`,
    );
    check(
        TEST_TYPES.has(trace.test_type),
        `${trace._trace_id} has invalid test_type.`,
    );
    check(
        TEST_RESULTS.has(trace.current_result),
        `${trace._trace_id} has invalid current_result.`,
    );
    check(
        TEST_AUTHORITIES.has(trace.test_authority),
        `${trace._trace_id} has invalid test_authority.`,
    );
    check(
        trace.test_exists === true,
        `${trace._trace_id} does not resolve to an existing test.`,
    );
    validatePathField(trace._trace_id, "test_path", trace.test_path);
}

function validateDuplicateUiKeys() {
    const byKey = new Map();

    for (const item of classifications.items) {
        if (["unknown", "not_applicable", "missing"].includes(item.ui_key)) {
            continue;
        }

        const matches = byKey.get(item.ui_key) ?? [];
        matches.push(item);
        byKey.set(item.ui_key, matches);
    }

    for (const [uiKey, items] of byKey) {
        if (items.length < 2) {
            continue;
        }

        for (const item of items) {
            check(
                item.known_mismatches.includes("duplicate_identity") &&
                    ["duplicate", "investigate"].includes(
                        item.inventory_disposition,
                    ),
                `Duplicate UI key ${uiKey} is not explicitly classified on ${item._record_id}.`,
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

    for (const path of value ?? []) {
        validatePathField(recordId, field, path, options);
    }
}

function validatePathField(recordId, field, value, options = {}) {
    const allowed = new Set(options.allow ?? []);

    if (allowed.has(value)) {
        return;
    }

    check(
        typeof value === "string",
        `${recordId} ${field} must be a string path.`,
    );
    check(
        sourcePaths.has(value),
        `${recordId} ${field} does not resolve at baseline: ${value}`,
    );
}

function arraysEqual(left, right) {
    return JSON.stringify(left) === JSON.stringify(right);
}

function check(condition, message) {
    if (!condition) {
        errors.push(message);
    }
}
