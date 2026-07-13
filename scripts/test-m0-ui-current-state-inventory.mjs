/**
 * ============================================================================
 * File: scripts/test-m0-ui-current-state-inventory.mjs
 * Purpose: Fixture-test corrected Issue #30 grouping and evidence semantics.
 * ============================================================================
 */

import assert from "node:assert/strict";
import { mkdtempSync, readFileSync, rmSync } from "node:fs";
import { tmpdir } from "node:os";
import { join, resolve } from "node:path";
import process from "node:process";
import { collectDiscoveryEvidence } from "./lib/m0-ui-inventory/discovery-runner.mjs";
import { loadIssue29SupportingEvidence } from "./lib/m0-ui-inventory/issue29-support.mjs";
import { renderInventoryMarkdown } from "./lib/m0-ui-inventory/markdown-renderer.mjs";
import {
    markSurfaceReviewed,
    markTraceReviewed,
    syncReviewArtifacts,
} from "./lib/m0-ui-inventory/review-store.mjs";
import {
    PINNED_INVENTORY_BASELINE,
    REQUIRED_SURFACE_FIELDS,
    REQUIRED_TRACE_FIELDS,
} from "./lib/m0-ui-inventory/schema.mjs";
import { collectMaterialSurfaces } from "./lib/m0-ui-inventory/surface-collector.mjs";
import {
    readJson,
    sha256,
    stableStringify,
    sourceFingerprint,
    writeJsonAtomic,
} from "./lib/m0-ui-inventory/utilities.mjs";

const repositoryRoot = process.cwd();
const fixtureRoot = resolve(repositoryRoot, "scripts/fixtures/m0-ui-inventory");
const cases = readJson(resolve(fixtureRoot, "cases.json"));
const expected = readJson(resolve(fixtureRoot, "expected.json"));
const config = readJson(
    resolve(repositoryRoot, "scripts/m0-ui-inventory.config.json"),
);
const compactJsonFixture = {
    evidence: {
        formats: [],
        paths: ["resources/views/components/ui/foo/index.blade.php"],
        status: "present",
    },
    values: ["component.foo", "x-ui.foo"],
};
const compactJson = stableStringify(compactJsonFixture);
assert.deepEqual(JSON.parse(compactJson), compactJsonFixture);
assert.ok(
    compactJson.split(/\r?\n/).length <= 8,
    "Small deterministic evidence structures must remain compact and reviewable.",
);
const files = cases.files.map((file, index) => ({
    mode: "100644",
    type: "blob",
    object_sha: sha256(`${index}:${file.path}`).slice(0, 40),
    size: file.content === null ? 100 : Buffer.byteLength(file.content),
    path: file.path,
    content: file.content,
    source_sha256: file.content === null ? null : sha256(file.content),
}));
const discovery = {
    mode: "fixture",
    issue_29_support: {
        status: "accepted_baseline_match",
        path: "fixture.json",
        baseline_sha: PINNED_INVENTORY_BASELINE,
        route_count: 1,
        module_count: 2,
    },
    commands: {
        route_list: {
            current_attempt: { status: "failed" },
            last_success: {
                source: "issue_29_accepted_runtime_evidence",
                payload: [
                    {
                        methods: ["GET"],
                        uri: "notifications",
                        name: "notifications.index",
                        action: "NotificationsController@index",
                        middleware: ["web"],
                    },
                ],
            },
        },
        module_list: {
            current_attempt: { status: "failed" },
            last_success: {
                source: "issue_29_accepted_runtime_evidence",
                payload: [
                    { key: "notifications", type: "core", ui_entries: [] },
                    { key: "roles", type: "core", ui_entries: [] },
                ],
            },
        },
    },
};
const collection = collectMaterialSurfaces({ files, discovery, config });

assert.ok(collection.surfaces.length >= expected.minimum_surface_count);
assert.deepEqual(collection.unclaimed_material_files, []);
const weakRelationshipValues = new Set([
    "action",
    "defaults",
    "debounce",
    "delay",
    "index.css",
    "match",
    "matches",
    "security",
    "throttle",
    "users",
    "warning",
]);
const weakRelationships = collection.surfaces.flatMap((surface) =>
    surface.test_candidates.filter(
        (candidate) =>
            candidate.relationship_evidence.kind === "exact_symbol_reference" &&
            weakRelationshipValues.has(candidate.relationship_evidence.value),
    ),
);
assert.deepEqual(
    weakRelationships,
    [],
    "Generic filenames and words must not become semantic test relationships.",
);

for (const type of expected.required_surface_types) {
    assert.ok(
        collection.surfaces.some((surface) => surface.surface_type === type),
        `Missing required fixture type: ${type}`,
    );
}

const foo = collection.surfaces.find(
    (surface) => surface.declared_ui_key === "component.foo",
);
assert.ok(foo);
assert.equal(foo.contracts[0].identity.type, "component");
assert.notEqual(foo.contracts[0].identity.type, "bool");
assert.equal(foo.contracts[0].schema_version.value, 1);
assert.equal(foo.contracts[0].schema_version.source, "surface_profile_default");
assert.deepEqual(foo.public_api_evidence.props, ["disabled", "label", "type"]);

const grid = collection.surfaces.find(
    (surface) => surface.current_slug === "grid",
);
assert.equal(grid.contracts[0].path, expected.contract_variation_path);
assert.equal(grid.contracts[0].filename_variation, true);

for (const path of [
    "Modules/Notifications/Header/ActionViewData.php",
    "Modules/Notifications/Header/PanelDataProvider.php",
]) {
    const surface = collection.surfaces.find(
        (candidate) => candidate.implementation_entry === path,
    );
    assert.ok(surface, `Missing view-model surface: ${path}`);
    assert.equal(surface.surface_type, "view_model");
}

const dashboardPage = collection.surfaces.find(
    (surface) =>
        surface.implementation_entry ===
        "app/Livewire/Platform/Dashboard/DashboardPage.php",
);
assert.equal(dashboardPage.surface_type, "renderer");

for (const path of [
    "app/Platform/Dashboard/WidgetRegistry.php",
    "app/Platform/Dashboard/Widgets/PlatformStatsWidget.php",
    "app/Platform/Dashboard/RendersOnDashboard.php",
]) {
    assert.ok(
        collection.surfaces.some(
            (surface) => surface.implementation_entry === path,
        ),
        `Missing dashboard contribution surface: ${path}`,
    );
}

const notificationsView = collection.surfaces.find(
    (surface) =>
        surface.implementation_entry ===
        "Modules/Notifications/resources/views/index.blade.php",
);
assert.ok(
    notificationsView.test_candidates.some(
        (test) =>
            test.path === "tests/Feature/Ui/NotificationsViewTest.php" &&
            test.relationship_evidence.kind ===
                "exact_repository_path_reference",
    ),
);

for (const [surfacePath, testPath] of expected.forbidden_false_trace_pairs) {
    const surface = collection.surfaces.find(
        (candidate) => candidate.implementation_entry === surfacePath,
    );
    assert.ok(surface, `Missing fixture surface ${surfacePath}`);
    assert.ok(
        !surface.test_candidates.some((test) => test.path === testPath),
        `False trace link survived: ${surfacePath} -> ${testPath}`,
    );
}

const icons = collection.surfaces.find(
    (surface) => surface.surface_type === "icon_system",
);
assert.equal(icons.asset_group_summary.svg_count, 2);
assert.ok(icons.implementation_support_files.length < 10);

const observations = {
    schema_version: 2,
    generator_schema_version: 2,
    issue: 30,
    baseline: {
        sha: PINNED_INVENTORY_BASELINE,
        committed_at: "2026-07-10T22:27:59-04:00",
        immutable: true,
        expected_execution_base: config.expected_execution_base,
        current_head_at_collection: config.expected_execution_base,
        ui_source_diff: { changed: false, paths: [], command: "fixture diff" },
    },
    generator: { generated_at: "2026-07-12T00:00:00.000Z" },
    roots: {},
    required_surface_fields: REQUIRED_SURFACE_FIELDS,
    required_trace_fields: REQUIRED_TRACE_FIELDS,
    discovery,
    source_path_index: files.map((file) => file.path).sort(),
    surfaces: collection.surfaces,
    unclaimed_material_files: [],
    summary: {},
};
const temporaryRoot = mkdtempSync(join(tmpdir(), "m0-ui-correction-"));
const classificationsPath = join(temporaryRoot, "classifications.json");
const tracesPath = join(temporaryRoot, "traces.json");

try {
    let artifacts = syncReviewArtifacts({
        observations,
        classificationsPath,
        testTracesPath: tracesPath,
        resetReviews: true,
    });
    assert.ok(artifacts.classifications.items.every((item) => !item._reviewed));
    assert.ok(
        artifacts.testTraces.test_traces.every((trace) => !trace._reviewed),
    );

    const fooReview = artifacts.classifications.items.find(
        (item) => item._record_id === foo.record_id,
    );
    markSurfaceReviewed(
        artifacts.classifications,
        fooReview._record_id,
        "Fixture surface reviewed.",
        "fixture-reviewer",
    );
    const fooTrace = artifacts.testTraces.test_traces.find(
        (trace) => trace._surface_record_id === foo.record_id,
    );
    markTraceReviewed(
        artifacts.testTraces,
        fooTrace._trace_id,
        "Fixture trace relationship reviewed.",
        "fixture-reviewer",
    );
    writeJsonAtomic(classificationsPath, artifacts.classifications);
    writeJsonAtomic(tracesPath, artifacts.testTraces);

    artifacts = syncReviewArtifacts({
        observations,
        classificationsPath,
        testTracesPath: tracesPath,
    });
    assert.equal(
        artifacts.classifications.items.find(
            (item) => item._record_id === foo.record_id,
        )._reviewed,
        true,
    );

    const changedObservations = structuredClone(observations);
    const changedFoo = changedObservations.surfaces.find(
        (surface) => surface.record_id === foo.record_id,
    );
    changedFoo.source_fingerprint = sourceFingerprint({ changed: true });
    artifacts = syncReviewArtifacts({
        observations: changedObservations,
        classificationsPath,
        testTracesPath: tracesPath,
    });
    assert.equal(
        artifacts.classifications.items.find(
            (item) => item._record_id === foo.record_id,
        )._review_required,
        true,
    );

    const supportPath = join(temporaryRoot, "issue29.json");
    writeJsonAtomic(supportPath, {
        baseline: { sha: PINNED_INVENTORY_BASELINE },
        dynamic_runtime_evidence: {
            route_list: { status: "passed", exit_code: 0, command: "route" },
            module_list: { status: "passed", exit_code: 0, command: "module" },
        },
        material_items: [
            {
                source_kind: "runtime_route_dynamic",
                runtime_metadata: {
                    methods: ["GET"],
                    uri: "foo",
                    name: "foo.index",
                    action: "FooController@index",
                    middleware: ["web"],
                },
            },
            {
                source_kind: "runtime_module_dynamic",
                runtime_metadata: { key: "foo", type: "core" },
            },
        ],
    });
    const supportConfig = structuredClone(config);
    supportConfig.issue_29_supporting_evidence.raw_path = supportPath;
    const support = loadIssue29SupportingEvidence({
        repositoryRoot: temporaryRoot,
        config: supportConfig,
        baseline: PINNED_INVENTORY_BASELINE,
    });
    assert.equal(support.status, "accepted_baseline_match");
    assert.equal(support.routes.length, 1);
    assert.equal(support.modules.length, 1);

    const preserved = collectDiscoveryEvidence({
        repositoryRoot,
        config,
        staticOnly: true,
        existing: null,
        issue29Support: support,
    });
    assert.equal(
        preserved.commands.route_list.last_success.source,
        "issue_29_accepted_runtime_evidence",
    );

    const renderClassifications = structuredClone(artifacts.classifications);
    const renderTraces = structuredClone(artifacts.testTraces);
    for (const item of renderClassifications.items) {
        item._reviewed = true;
        item._review_required = false;
    }
    for (const trace of renderTraces.test_traces) {
        trace._reviewed = true;
        trace._review_required = false;
    }
    const markdown = renderInventoryMarkdown({
        observations: changedObservations,
        classifications: renderClassifications,
        testTraces: renderTraces,
    });
    assert.match(markdown, /# M0 UI Current-State Inventory/);
    assert.match(markdown, /Issue #32 owns complete test-suite execution/);
    assert.ok(markdown.endsWith("\n"));
    assert.ok(!markdown.endsWith("\n\n"));
    assert.ok(readFileSync(classificationsPath, "utf8").length > 0);
} finally {
    rmSync(temporaryRoot, { recursive: true, force: true });
}

console.log(
    [
        "Issue #30 correction fixture tests passed.",
        `Collected fixture surfaces: ${collection.surfaces.length}.`,
        "Verified section-aware contract parsing, false-link rejection,",
        "Module ViewData/DataProvider coverage, Dashboard contribution coverage,",
        "asset grouping, explicit review reset, review preservation,",
        "source-change invalidation, Issue #29 support import, and render-only output.",
    ].join("\n"),
);
