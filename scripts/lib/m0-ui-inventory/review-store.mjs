/**
 * ============================================================================
 * File: scripts/lib/m0-ui-inventory/review-store.mjs
 * Purpose: Preserve and validate reviewed issue #30 classifications and traces.
 * ============================================================================
 */

import {
    createSurfaceReviewSeed,
    createTestTraceSeed,
    summarizeTestAuthority,
    summarizeTestStatus,
} from "./schema.mjs";
import {
    currentIsoTimestamp,
    ensure,
    readJsonIfExists,
    sourceFingerprint,
    uniqueSorted,
    writeJsonAtomic,
} from "./utilities.mjs";

export function syncReviewArtifacts({
    observations,
    classificationsPath,
    testTracesPath,
}) {
    const existingClassifications = readJsonIfExists(classificationsPath);
    const existingTraces = readJsonIfExists(testTracesPath);
    assertCompatibleBaseline(
        existingClassifications,
        observations.baseline.sha,
        "classifications",
    );
    assertCompatibleBaseline(
        existingTraces,
        observations.baseline.sha,
        "test traces",
    );

    const existingByRecordId = new Map(
        (existingClassifications?.items ?? []).map((item) => [
            item._record_id,
            item,
        ]),
    );
    const nextItems = observations.surfaces.map((observation) => {
        const seed = createSurfaceReviewSeed(observation);
        const existing = existingByRecordId.get(observation.record_id);

        if (!existing) {
            return seed;
        }

        if (isUntouchedGeneratedSeed(existing, seed)) {
            return seed;
        }

        const changed =
            existing._source_fingerprint !== observation.source_fingerprint;

        return {
            ...seed,
            ...existing,
            _record_id: observation.record_id,
            _source_fingerprint: observation.source_fingerprint,
            _reviewed: changed ? false : existing._reviewed === true,
            _review_required: changed
                ? true
                : existing._review_required === true,
            _review_note: changed
                ? appendReviewNote(
                      existing._review_note,
                      "Source evidence changed. Reviewed values were preserved and require re-review.",
                  )
                : existing._review_note,
        };
    });

    const classifications = {
        schema_version: 1,
        issue: 30,
        baseline_sha: observations.baseline.sha,
        generated_from_observations_sha256: sourceFingerprint(observations),
        reviewer: existingClassifications?.reviewer ?? null,
        reviewed_at: existingClassifications?.reviewed_at ?? null,
        required_fields: observations.required_surface_fields,
        items: nextItems.sort((left, right) =>
            left._record_id.localeCompare(right._record_id),
        ),
        orphaned_prior_records: (existingClassifications?.items ?? [])
            .filter(
                (item) =>
                    !observations.surfaces.some(
                        (surface) => surface.record_id === item._record_id,
                    ),
            )
            .map((item) => item._record_id)
            .sort(),
    };

    const itemByRecordId = new Map(
        classifications.items.map((item) => [item._record_id, item]),
    );
    const candidateByPair = new Map();

    for (const observation of observations.surfaces) {
        for (const candidate of observation.test_candidates) {
            candidateByPair.set(
                `${observation.record_id}\0${candidate.path}`,
                candidate,
            );
        }
    }

    const existingTraceByPair = new Map(
        (existingTraces?.test_traces ?? []).map((trace) => [
            `${trace._surface_record_id}\0${trace.test_path}`,
            trace,
        ]),
    );
    const nextTraces = [];

    for (const [pair, candidate] of candidateByPair) {
        const [surfaceRecordId] = pair.split("\0");
        const surfaceReview = itemByRecordId.get(surfaceRecordId);

        if (!surfaceReview) {
            continue;
        }

        const seed = createTestTraceSeed(surfaceReview, candidate);
        const existing = existingTraceByPair.get(pair);

        if (!existing) {
            nextTraces.push(seed);
            continue;
        }

        if (isUntouchedGeneratedSeed(existing, seed)) {
            nextTraces.push(seed);
            continue;
        }

        const changed =
            existing._source_fingerprint !== seed._source_fingerprint;

        nextTraces.push({
            ...seed,
            ...existing,
            _trace_id: seed._trace_id,
            _surface_record_id: surfaceRecordId,
            _source_fingerprint: seed._source_fingerprint,
            surface_ui_key: surfaceReview.ui_key,
            _reviewed: changed ? false : existing._reviewed === true,
            _review_required: changed
                ? true
                : existing._review_required === true,
            _review_note: changed
                ? appendReviewNote(
                      existing._review_note,
                      "Test source evidence changed. Reviewed trace values were preserved and require re-review.",
                  )
                : existing._review_note,
        });
    }

    for (const item of classifications.items) {
        const traces = nextTraces.filter(
            (trace) => trace._surface_record_id === item._record_id,
        );
        item.test_paths = uniqueSorted(traces.map((trace) => trace.test_path));

        if (traces.length > 0 && item._reviewed !== true) {
            item.test_status = summarizeTestStatus(traces);
            item.test_authority = summarizeTestAuthority(traces);
        }
    }

    const testTraces = {
        schema_version: 1,
        issue: 30,
        baseline_sha: observations.baseline.sha,
        ownership_boundary:
            "Issue #30 owns UI surface-to-test traceability only. Issue #32 owns complete test-suite execution, warnings, failures, and disposition.",
        reviewer: existingTraces?.reviewer ?? null,
        reviewed_at: existingTraces?.reviewed_at ?? null,
        required_fields: observations.required_trace_fields,
        test_traces: nextTraces.sort((left, right) =>
            left._trace_id.localeCompare(right._trace_id),
        ),
        orphaned_prior_traces: (existingTraces?.test_traces ?? [])
            .filter(
                (trace) =>
                    !candidateByPair.has(
                        `${trace._surface_record_id}\0${trace.test_path}`,
                    ),
            )
            .map((trace) => trace._trace_id)
            .sort(),
    };

    writeJsonAtomic(classificationsPath, classifications);
    writeJsonAtomic(testTracesPath, testTraces);

    return { classifications, testTraces };
}

export function markSurfaceReviewed(classifications, recordId, note, reviewer) {
    const item = classifications.items.find(
        (candidate) => candidate._record_id === recordId,
    );
    ensure(item, `Unknown surface record: ${recordId}`);
    ensure(note && String(note).trim() !== "", "A review note is required.");

    item._reviewed = true;
    item._review_required = false;
    item._review_note = String(note).trim();
    classifications.reviewer =
        reviewer ?? classifications.reviewer ?? "repository-owner-review";
    classifications.reviewed_at = currentIsoTimestamp();
    return item;
}

export function markTraceReviewed(testTraces, traceId, note, reviewer) {
    const trace = testTraces.test_traces.find(
        (candidate) => candidate._trace_id === traceId,
    );
    ensure(trace, `Unknown test trace: ${traceId}`);
    ensure(note && String(note).trim() !== "", "A review note is required.");

    trace._reviewed = true;
    trace._review_required = false;
    trace._review_note = String(note).trim();
    testTraces.reviewer =
        reviewer ?? testTraces.reviewer ?? "repository-owner-review";
    testTraces.reviewed_at = currentIsoTimestamp();
    return trace;
}

export function setSurfaceField(classifications, recordId, field, value) {
    const item = classifications.items.find(
        (candidate) => candidate._record_id === recordId,
    );
    ensure(item, `Unknown surface record: ${recordId}`);
    ensure(
        !field.startsWith("_"),
        "Use review commands for tooling metadata fields.",
    );
    ensure(Object.hasOwn(item, field), `Unknown surface field: ${field}`);

    item[field] = value;
    item._reviewed = false;
    item._review_required = true;
    item._review_note = appendReviewNote(
        item._review_note,
        `Field ${field} changed and requires review.`,
    );
    return item;
}

export function setTraceField(testTraces, traceId, field, value) {
    const trace = testTraces.test_traces.find(
        (candidate) => candidate._trace_id === traceId,
    );
    ensure(trace, `Unknown test trace: ${traceId}`);
    ensure(
        !field.startsWith("_"),
        "Use review commands for tooling metadata fields.",
    );
    ensure(Object.hasOwn(trace, field), `Unknown trace field: ${field}`);

    trace[field] = value;
    trace._reviewed = false;
    trace._review_required = true;
    trace._review_note = appendReviewNote(
        trace._review_note,
        `Field ${field} changed and requires review.`,
    );
    return trace;
}

export function addMismatch(classifications, recordId, mismatch) {
    const item = classifications.items.find(
        (candidate) => candidate._record_id === recordId,
    );
    ensure(item, `Unknown surface record: ${recordId}`);
    item.known_mismatches = uniqueSorted([
        ...(Array.isArray(item.known_mismatches) ? item.known_mismatches : []),
        mismatch,
    ]);
    item._reviewed = false;
    item._review_required = true;
    return item;
}

export function summarizeSurfaceTests(classifications, testTraces, recordId) {
    const item = classifications.items.find(
        (candidate) => candidate._record_id === recordId,
    );
    ensure(item, `Unknown surface record: ${recordId}`);
    const traces = testTraces.test_traces.filter(
        (trace) => trace._surface_record_id === recordId,
    );

    item.test_paths = uniqueSorted(traces.map((trace) => trace.test_path));
    item.test_status = summarizeTestStatus(traces);
    item.test_authority = summarizeTestAuthority(traces);
    item._reviewed = false;
    item._review_required = true;
    item._review_note = appendReviewNote(
        item._review_note,
        "Surface-level test summary was recalculated from detailed traces and requires review.",
    );
    return item;
}

export function findSurface(classifications, identifier) {
    return classifications.items.find(
        (item) =>
            item._record_id === identifier ||
            item.ui_key === identifier ||
            item.implementation_entry === identifier,
    );
}

function assertCompatibleBaseline(artifact, baseline, label) {
    if (artifact === null) {
        return;
    }

    ensure(
        artifact.baseline_sha === baseline,
        `Existing ${label} target ${artifact.baseline_sha}; expected ${baseline}.`,
    );
}

function appendReviewNote(existing, addition) {
    const current = String(existing ?? "").trim();
    return current === "" ? addition : `${current} ${addition}`;
}

function isUntouchedGeneratedSeed(existing, seed) {
    return (
        existing._reviewed !== true &&
        existing._review_required === true &&
        existing._review_note === seed._review_note
    );
}
