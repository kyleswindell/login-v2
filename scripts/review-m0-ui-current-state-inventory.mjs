/**
 * ============================================================================
 * File: scripts/review-m0-ui-current-state-inventory.mjs
 * Purpose: Assist explicit review of issue #30 surfaces and UI test traces.
 * ============================================================================
 */

import { resolve } from "node:path";
import process from "node:process";
import { discoverRepositoryRoot } from "./lib/m0-ui-inventory/git-batch-reader.mjs";
import {
    addMismatch,
    findSurface,
    markSurfaceReviewed,
    markTraceReviewed,
    setSurfaceField,
    setTraceField,
    summarizeSurfaceTests,
    syncReviewArtifacts,
} from "./lib/m0-ui-inventory/review-store.mjs";
import {
    MISMATCH_CLASSIFICATIONS,
    TEST_AUTHORITIES,
    TEST_RESULTS,
    TEST_TYPES,
} from "./lib/m0-ui-inventory/schema.mjs";
import {
    ensure,
    parseArguments,
    parseCliValue,
    readJson,
    stableStringify,
    writeJsonAtomic,
} from "./lib/m0-ui-inventory/utilities.mjs";

const args = parseArguments(process.argv.slice(2));
const [command, ...positionals] = args._;
const repositoryRoot = discoverRepositoryRoot();
process.chdir(repositoryRoot);

const config = readJson(
    resolve(
        repositoryRoot,
        args.config ?? "scripts/m0-ui-inventory.config.json",
    ),
);
const observationsPath = resolve(repositoryRoot, config.outputs.observations);
const classificationsPath = resolve(
    repositoryRoot,
    config.outputs.classifications,
);
const testTracesPath = resolve(repositoryRoot, config.outputs.test_traces);
const observations = readJson(observationsPath);

if (command === "sync") {
    const { classifications, testTraces } = syncReviewArtifacts({
        observations,
        classificationsPath,
        testTracesPath,
        resetReviews: args.reset_reviews === true,
    });

    console.log(
        [
            `Surface classifications: ${classifications.items.length}.`,
            `UI test traces: ${testTraces.test_traces.length}.`,
            `Classifications: ${config.outputs.classifications}`,
            `Test traces: ${config.outputs.test_traces}`,
        ].join("\n"),
    );
    process.exit(0);
}

const classifications = readJson(classificationsPath);
const testTraces = readJson(testTracesPath);

switch (command) {
    case "list":
        listSurfaces(classifications, args);
        break;

    case "show": {
        const identifier = positionals[0];
        ensure(
            identifier,
            "Usage: review ... show <record-id|ui-key|implementation-path>",
        );
        const item = findSurface(classifications, identifier);
        ensure(item, `No surface matched ${identifier}.`);
        const observation = observations.surfaces.find(
            (candidate) => candidate.record_id === item._record_id,
        );
        const traces = testTraces.test_traces.filter(
            (trace) => trace._surface_record_id === item._record_id,
        );
        console.log(
            stableStringify({ observation, review: item, test_traces: traces }),
        );
        break;
    }

    case "set": {
        const [recordId, field, rawValue] = positionals;
        ensure(
            recordId && field && rawValue !== undefined,
            "Usage: review ... set <record-id> <field> <json-or-string-value>",
        );
        const item = setSurfaceField(
            classifications,
            recordId,
            field,
            parseCliValue(rawValue),
        );
        writeJsonAtomic(classificationsPath, classifications);
        console.log(stableStringify(item));
        break;
    }

    case "add-mismatch": {
        const [recordId, mismatch] = positionals;
        ensure(
            recordId && mismatch,
            "Usage: review ... add-mismatch <record-id> <classification>",
        );
        ensure(
            MISMATCH_CLASSIFICATIONS.has(mismatch),
            `Unknown mismatch classification: ${mismatch}`,
        );
        const item = addMismatch(classifications, recordId, mismatch);
        writeJsonAtomic(classificationsPath, classifications);
        console.log(stableStringify(item));
        break;
    }

    case "mark-reviewed": {
        const recordId = positionals[0];
        ensure(
            recordId,
            'Usage: review ... mark-reviewed <record-id> --note "..."',
        );
        const item = markSurfaceReviewed(
            classifications,
            recordId,
            args.note,
            args.reviewer,
        );
        writeJsonAtomic(classificationsPath, classifications);
        console.log(stableStringify(item));
        break;
    }

    case "list-traces":
        listTraces(testTraces, args);
        break;

    case "show-trace": {
        const traceId = positionals[0];
        const trace = testTraces.test_traces.find(
            (candidate) => candidate._trace_id === traceId,
        );
        ensure(trace, `Unknown trace: ${traceId}`);
        console.log(stableStringify(trace));
        break;
    }

    case "set-trace": {
        const [traceId, field, rawValue] = positionals;
        ensure(
            traceId && field && rawValue !== undefined,
            "Usage: review ... set-trace <trace-id> <field> <json-or-string-value>",
        );
        const value = parseCliValue(rawValue);
        validateTraceControlledField(field, value);
        const trace = setTraceField(testTraces, traceId, field, value);
        writeJsonAtomic(testTracesPath, testTraces);
        console.log(stableStringify(trace));
        break;
    }

    case "mark-trace-reviewed": {
        const traceId = positionals[0];
        ensure(
            traceId,
            'Usage: review ... mark-trace-reviewed <trace-id> --note "..."',
        );
        const trace = markTraceReviewed(
            testTraces,
            traceId,
            args.note,
            args.reviewer,
        );
        writeJsonAtomic(testTracesPath, testTraces);
        console.log(stableStringify(trace));
        break;
    }

    case "summarize-tests": {
        const recordId = positionals[0];
        ensure(recordId, "Usage: review ... summarize-tests <record-id>");
        const item = summarizeSurfaceTests(
            classifications,
            testTraces,
            recordId,
        );
        writeJsonAtomic(classificationsPath, classifications);
        console.log(stableStringify(item));
        break;
    }

    default:
        throw new Error(
            [
                "Unknown or missing review command.",
                "Commands:",
                "  sync [--reset-reviews]",
                "  list [--pending] [--type TYPE] [--mismatch CODE]",
                "  show <record-id|ui-key|implementation-path>",
                "  set <record-id> <field> <json-or-string-value>",
                "  add-mismatch <record-id> <classification>",
                '  mark-reviewed <record-id> --note "..." [--reviewer NAME]',
                "  list-traces [--pending] [--surface RECORD_ID]",
                "  show-trace <trace-id>",
                "  set-trace <trace-id> <field> <json-or-string-value>",
                '  mark-trace-reviewed <trace-id> --note "..." [--reviewer NAME]',
                "  summarize-tests <record-id>",
            ].join("\n"),
        );
}

function listSurfaces(artifact, options) {
    const items = artifact.items
        .filter((item) =>
            options.pending
                ? item._reviewed !== true || item._review_required === true
                : true,
        )
        .filter((item) =>
            options.type ? item.surface_type === options.type : true,
        )
        .filter((item) =>
            options.mismatch
                ? item.known_mismatches?.includes(options.mismatch)
                : true,
        );

    for (const item of items) {
        console.log(
            [
                item._record_id,
                `type=${item.surface_type}`,
                `ui_key=${String(item.ui_key)}`,
                `reviewed=${item._reviewed === true && item._review_required !== true}`,
                `mismatches=${(item.known_mismatches ?? []).join(",") || "none"}`,
            ].join("\t"),
        );
    }

    console.log(`Matched ${items.length} surface(s).`);
}

function listTraces(artifact, options) {
    const traces = artifact.test_traces
        .filter((trace) =>
            options.pending
                ? trace._reviewed !== true || trace._review_required === true
                : true,
        )
        .filter((trace) =>
            options.surface
                ? trace._surface_record_id === options.surface
                : true,
        );

    for (const trace of traces) {
        console.log(
            [
                trace._trace_id,
                `surface=${trace._surface_record_id}`,
                `path=${trace.test_path}`,
                `reviewed=${trace._reviewed === true && trace._review_required !== true}`,
                `result=${trace.current_result}`,
                `authority=${trace.test_authority}`,
            ].join("\t"),
        );
    }

    console.log(`Matched ${traces.length} trace(s).`);
}

function validateTraceControlledField(field, value) {
    if (field === "test_type") {
        ensure(TEST_TYPES.has(value), `Invalid test_type: ${value}`);
    }

    if (field === "current_result") {
        ensure(TEST_RESULTS.has(value), `Invalid current_result: ${value}`);
    }

    if (field === "test_authority") {
        ensure(TEST_AUTHORITIES.has(value), `Invalid test_authority: ${value}`);
    }
}
