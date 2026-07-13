/**
 * ============================================================================
 * File: scripts/lib/m0-ui-inventory/review-store.mjs
 * Purpose: Preserve explicit Issue #30 reviews and support correction resets.
 * ============================================================================
 */

import {
    createStandardProjection,
    createStandardReviewSeed,
    createSurfaceReviewSeed,
    createTestTraceSeed,
    standardReviewRequiresStale,
    summarizeTestAuthority,
    summarizeTestStatus,
} from "./schema.mjs";
import {
    currentIsoTimestamp,
    ensure,
    readJsonIfExists,
    sourceFingerprint,
    stableStringify,
    uniqueSorted,
    writeJsonAtomic,
} from "./utilities.mjs";

export function syncReviewArtifacts({
    observations,
    classificationsPath,
    testTracesPath,
    resetReviews = false,
}) {
    const existingClassifications = resetReviews
        ? null
        : readJsonIfExists(classificationsPath);
    const existingTraces = resetReviews
        ? null
        : readJsonIfExists(testTracesPath);
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
    const standardCandidates = uniqueStandardCandidates(observations);
    const existingStandardByPath = new Map(
        (existingClassifications?.standard_reviews ?? []).map((review) => [
            review._standard_path,
            review,
        ]),
    );
    const nextStandardReviews = standardCandidates.map((candidate) => {
        const seed = createStandardReviewSeed(candidate);
        const existing = existingStandardByPath.get(candidate.path);

        if (!existing || isUntouchedGeneratedSeed(existing, seed)) {
            return seed;
        }

        const changed =
            existing._source_fingerprint !== seed._source_fingerprint;

        return {
            ...seed,
            ...existing,
            _standard_path: candidate.path,
            _source_fingerprint: seed._source_fingerprint,
            claimed_scope: seed.claimed_scope,
            evidence_source: seed.evidence_source,
            _reviewed: changed ? false : existing._reviewed === true,
            _review_required: changed
                ? true
                : existing._review_required === true,
            _review_note: changed
                ? appendReviewNote(
                      existing._review_note,
                      "Pinned standard source changed. Re-review this standard and its linked surfaces.",
                  )
                : existing._review_note,
        };
    });

    const existingByRecordId = new Map(
        (existingClassifications?.items ?? []).map((item) => [
            item._record_id,
            item,
        ]),
    );
    const nextItems = observations.surfaces.map((observation) => {
        const seed = createSurfaceReviewSeed(observation);
        const existing = existingByRecordId.get(observation.record_id);

        if (!existing || isUntouchedGeneratedSeed(existing, seed)) {
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
                      "Source evidence changed. Reviewed values were preserved but require re-review.",
                  )
                : existing._review_note,
        };
    });

    const classifications = {
        schema_version: 2,
        generator_schema_version: 2,
        correction_reason:
            resetReviews === true
                ? "PR #44 systemic trace, parser, coverage, and evidence-size correction"
                : (existingClassifications?.correction_reason ?? null),
        issue: 30,
        baseline_sha: observations.baseline.sha,
        generated_from_observations_sha256: sourceFingerprint(observations),
        reviewer: resetReviews
            ? null
            : (existingClassifications?.reviewer ?? null),
        reviewed_at: resetReviews
            ? null
            : (existingClassifications?.reviewed_at ?? null),
        required_fields: observations.required_surface_fields,
        standard_reviews: nextStandardReviews.sort((left, right) =>
            left._standard_path.localeCompare(right._standard_path),
        ),
        items: nextItems.sort((left, right) =>
            left._record_id.localeCompare(right._record_id),
        ),
        orphaned_prior_records: resetReviews
            ? []
            : (existingClassifications?.items ?? [])
                  .filter(
                      (item) =>
                          !observations.surfaces.some(
                              (surface) =>
                                  surface.record_id === item._record_id,
                          ),
                  )
                  .map((item) => item._record_id)
                  .sort(),
        orphaned_prior_standard_reviews: resetReviews
            ? []
            : (existingClassifications?.standard_reviews ?? [])
                  .filter(
                      (review) =>
                          !standardCandidates.some(
                              (candidate) =>
                                  candidate.path === review._standard_path,
                          ),
                  )
                  .map((review) => review._standard_path)
                  .sort(),
    };

    projectReviewedStandards(classifications, observations);

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

        if (!existing || isUntouchedGeneratedSeed(existing, seed)) {
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
            _relationship_evidence: seed._relationship_evidence,
            surface_ui_key: surfaceReview.ui_key,
            _reviewed: changed ? false : existing._reviewed === true,
            _review_required: changed
                ? true
                : existing._review_required === true,
            _review_note: changed
                ? appendReviewNote(
                      existing._review_note,
                      "Test relationship or source evidence changed. Reviewed values were preserved but require re-review.",
                  )
                : existing._review_note,
        });
    }

    for (const item of classifications.items) {
        const traces = nextTraces.filter(
            (trace) => trace._surface_record_id === item._record_id,
        );
        item.test_paths = uniqueSorted(traces.map((trace) => trace.test_path));

        if (item._reviewed !== true) {
            item.test_status = summarizeTestStatus(traces);
            item.test_authority = summarizeTestAuthority(traces);
        }
    }

    const testTraces = {
        schema_version: 2,
        generator_schema_version: 2,
        correction_reason:
            resetReviews === true
                ? "PR #44 systemic false-link correction"
                : (existingTraces?.correction_reason ?? null),
        issue: 30,
        baseline_sha: observations.baseline.sha,
        ownership_boundary:
            "Issue #30 owns UI surface-to-test traceability only. Issue #32 owns complete test-suite execution, warnings, failures, and disposition.",
        reviewer: resetReviews ? null : (existingTraces?.reviewer ?? null),
        reviewed_at: resetReviews
            ? null
            : (existingTraces?.reviewed_at ?? null),
        required_fields: observations.required_trace_fields,
        test_traces: nextTraces.sort((left, right) =>
            left._trace_id.localeCompare(right._trace_id),
        ),
        orphaned_prior_traces: resetReviews
            ? []
            : (existingTraces?.test_traces ?? [])
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
    ensure(
        trace._relationship_evidence?.kind,
        "A trace cannot be reviewed without semantic relationship evidence.",
    );
    trace._reviewed = true;
    trace._review_required = false;
    trace._review_note = String(note).trim();
    testTraces.reviewer =
        reviewer ?? testTraces.reviewer ?? "repository-owner-review";
    testTraces.reviewed_at = currentIsoTimestamp();
    return trace;
}

export function markStandardReviewed(
    classifications,
    standardPath,
    note,
    reviewer,
) {
    const review = findStandardReview(classifications, standardPath);
    ensure(review, `Unknown standard: ${standardPath}`);
    ensure(note && String(note).trim() !== "", "A review note is required.");
    review._reviewed = true;
    review._review_required = false;
    review._review_note = String(note).trim();
    classifications.reviewer =
        reviewer ?? classifications.reviewer ?? "repository-owner-review";
    classifications.reviewed_at = currentIsoTimestamp();
    return review;
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

export function setStandardField(classifications, standardPath, field, value) {
    const review = findStandardReview(classifications, standardPath);
    ensure(review, `Unknown standard: ${standardPath}`);
    ensure(
        !field.startsWith("_"),
        "Use review commands for tooling metadata fields.",
    );
    ensure(Object.hasOwn(review, field), `Unknown standard field: ${field}`);
    review[field] = value;
    review._reviewed = false;
    review._review_required = true;
    review._review_note = appendReviewNote(
        review._review_note,
        `Field ${field} changed and requires review.`,
    );
    return review;
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
        "Surface test summary was recalculated and requires review.",
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

export function findStandardReview(classifications, standardPath) {
    return (classifications.standard_reviews ?? []).find(
        (review) => review._standard_path === standardPath,
    );
}

export function projectReviewedStandards(classifications, observations) {
    const reviewByPath = new Map(
        (classifications.standard_reviews ?? []).map((review) => [
            review._standard_path,
            review,
        ]),
    );
    const itemById = new Map(
        classifications.items.map((item) => [item._record_id, item]),
    );
    const changedRecordIds = [];

    for (const observation of observations.surfaces) {
        const item = itemById.get(observation.record_id);
        if (!item) continue;
        const projection = observation.standard_candidates.map((candidate) =>
            createStandardProjection(
                candidate,
                reviewByPath.get(candidate.path),
            ),
        );
        const requiresStale = observation.standard_candidates.some(
            (candidate) =>
                standardReviewRequiresStale(reviewByPath.get(candidate.path)),
        );
        const mismatches = uniqueSorted([
            ...(item.known_mismatches ?? []).filter(
                (mismatch) => mismatch !== "standard_stale",
            ),
            ...(requiresStale ? ["standard_stale"] : []),
        ]);
        const changed =
            stableStringify(item.standards_evidence ?? []) !==
                stableStringify(projection) ||
            stableStringify(item.known_mismatches ?? []) !==
                stableStringify(mismatches);

        item.standards_evidence = projection;
        item.known_mismatches = mismatches;

        if (changed) {
            item._reviewed = false;
            item._review_required = true;
            item._review_note = appendReviewNote(
                item._review_note,
                "Reviewed standards projection changed and requires surface re-review.",
            );
            changedRecordIds.push(item._record_id);
        }
    }

    return uniqueSorted(changedRecordIds);
}

function assertCompatibleBaseline(artifact, baseline, label) {
    if (artifact === null) return;
    ensure(
        artifact.baseline_sha === baseline,
        `Existing ${label} target ${artifact.baseline_sha}; expected ${baseline}.`,
    );
}

function appendReviewNote(existing, addition) {
    const current = String(existing ?? "").trim();
    return current === "" ? addition : `${current} ${addition}`;
}

function uniqueStandardCandidates(observations) {
    const candidates = new Map();

    for (const surface of observations.surfaces) {
        for (const candidate of surface.standard_candidates) {
            const existing = candidates.get(candidate.path);
            ensure(
                !existing || existing.source_sha256 === candidate.source_sha256,
                `Conflicting pinned source hashes for ${candidate.path}.`,
            );
            candidates.set(candidate.path, candidate);
        }
    }

    return [...candidates.values()].sort((left, right) =>
        left.path.localeCompare(right.path),
    );
}

function isUntouchedGeneratedSeed(existing, seed) {
    return (
        existing._reviewed !== true &&
        existing._review_required === true &&
        existing._review_note === seed._review_note
    );
}
