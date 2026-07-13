/**
 * ============================================================================
 * File: scripts/test-m0-ui-current-state-inventory.mjs
 * Purpose: Fixture-test corrected Issue #30 grouping and evidence semantics.
 * ============================================================================
 */

import assert from "node:assert/strict";
import { spawnSync } from "node:child_process";
import { mkdtempSync, readFileSync, rmSync } from "node:fs";
import { tmpdir } from "node:os";
import { join, resolve } from "node:path";
import process from "node:process";
import { collectDiscoveryEvidence } from "./lib/m0-ui-inventory/discovery-runner.mjs";
import { loadIssue29SupportingEvidence } from "./lib/m0-ui-inventory/issue29-support.mjs";
import { renderInventoryMarkdown } from "./lib/m0-ui-inventory/markdown-renderer.mjs";
import {
    markStandardReviewed,
    markSurfaceReviewed,
    markTraceReviewed,
    projectReviewedStandards,
    setStandardField,
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
    writeTextAtomic,
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

for (const slug of expected.copied_template_slugs) {
    const copied = collection.surfaces.find(
        (surface) => surface.current_slug === slug,
    );
    assert.ok(copied, `Missing copied-template fixture surface: ${slug}`);
    assert.equal(copied.contracts[0].template_copy, true);
    assert.equal(copied.contracts[0].identity_complete, false);
    assert.equal(copied.contracts[0].header_path_matches_actual, false);
    assert.ok(copied.contracts[0].identity.slug.trim() === "");
    assert.equal(copied.contracts[0].identity.type, "element");
    assert.deepEqual(
        copied.contracts[0].api.props,
        ["label", "slug", "type"],
        "Nested prop keys must not overwrite identity fields.",
    );
    for (const mismatch of [
        "contract_stale",
        "source_path_mismatch",
        "lifecycle_conflict",
    ]) {
        assert.ok(
            copied.generated_mismatches.includes(mismatch),
            `${slug} lacks ${mismatch}`,
        );
    }
    assert.equal(
        copied.contract_api_evidence.quality[0].declared_header_path,
        "docs/09-reference/ui/ui-contract-template.php",
    );
}

const pictograms = collection.surfaces.find(
    (surface) => surface.surface_type === "pictogram_system",
);
assert.equal(
    pictograms.implementation_entry,
    expected.pictogram_implementation_entry,
);
assert.equal(
    pictograms.asset_group_summary.representative_kind,
    "representative_svg",
);

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
    summary: {
        surface_type_counts: Object.fromEntries(
            [
                ...new Set(
                    collection.surfaces.map((surface) => surface.surface_type),
                ),
            ]
                .sort()
                .map((type) => [
                    type,
                    collection.surfaces.filter(
                        (surface) => surface.surface_type === type,
                    ).length,
                ]),
        ),
    },
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
    assert.ok(
        artifacts.classifications.standard_reviews.every(
            (standard) => !standard._reviewed,
        ),
    );
    assert.ok(
        !artifacts.classifications.items.some((item) =>
            Object.hasOwn(item, "_standard_path"),
        ),
        "Unique standard review seeds must remain separate from surface seeds.",
    );

    reviewFixtureStandards(artifacts.classifications);
    projectReviewedStandards(artifacts.classifications, observations);
    assert.ok(
        artifacts.classifications.items
            .find((item) => item._record_id === foo.record_id)
            .known_mismatches.includes("standard_stale"),
    );

    const contractStandard = artifacts.classifications.standard_reviews.find(
        (standard) =>
            standard._standard_path === "docs/02-standards/ui/contract-file.md",
    );
    setStandardField(
        artifacts.classifications,
        contractStandard._standard_path,
        "authority_state",
        "current_standard",
    );
    setStandardField(
        artifacts.classifications,
        contractStandard._standard_path,
        "contract_alignment",
        "aligned",
    );
    setStandardField(
        artifacts.classifications,
        contractStandard._standard_path,
        "staleness_evidence",
        [],
    );
    setStandardField(
        artifacts.classifications,
        contractStandard._standard_path,
        "moved_responsibilities",
        [],
    );
    markStandardReviewed(
        artifacts.classifications,
        contractStandard._standard_path,
        "Fixture confirmed a current projection without stale guidance.",
        "fixture-reviewer",
    );
    projectReviewedStandards(artifacts.classifications, observations);
    assert.ok(
        !artifacts.classifications.items
            .find((item) => item._record_id === foo.record_id)
            .known_mismatches.includes("standard_stale"),
        "Projection must remove standard_stale when reviewed stale evidence is removed.",
    );

    reviewFixtureContractStandard(artifacts.classifications);
    projectReviewedStandards(artifacts.classifications, observations);
    markAllFixtureReviews(artifacts);
    writeJsonAtomic(classificationsPath, artifacts.classifications);
    writeJsonAtomic(tracesPath, artifacts.testTraces);

    artifacts = syncReviewArtifacts({
        observations,
        classificationsPath,
        testTracesPath: tracesPath,
    });
    assert.equal(
        artifacts.classifications.standard_reviews.every(
            (standard) => standard._reviewed,
        ),
        true,
        "Reviewed standard values must survive unchanged recollection.",
    );

    const changedObservations = structuredClone(observations);
    const changedFoo = changedObservations.surfaces.find(
        (surface) => surface.record_id === foo.record_id,
    );
    const changedStandard = changedFoo.standard_candidates.find(
        (standard) =>
            standard.path === "docs/02-standards/ui/components/foo.md",
    );
    const changedStandardHash = sourceFingerprint({ changed: true });
    for (const surface of changedObservations.surfaces.filter((candidate) =>
        candidate.standard_candidates.some(
            (standard) => standard.path === changedStandard.path,
        ),
    )) {
        surface.standard_candidates.find(
            (standard) => standard.path === changedStandard.path,
        ).source_sha256 = changedStandardHash;
        surface.source_fingerprint = sourceFingerprint({
            previous: surface.source_fingerprint,
            changed_standard_path: changedStandard.path,
            changed_standard_hash: changedStandardHash,
        });
    }
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
    assert.equal(
        artifacts.classifications.standard_reviews.find(
            (standard) => standard._standard_path === changedStandard.path,
        )._review_required,
        true,
    );
    const unrelatedSurface = artifacts.classifications.items.find(
        (item) =>
            item.implementation_entry ===
            "Modules/Notifications/resources/views/index.blade.php",
    );
    assert.equal(
        unrelatedSurface._reviewed,
        true,
        "A changed standard must not invalidate unrelated reviewed surfaces.",
    );
    assert.ok(
        artifacts.testTraces.test_traces.every((trace) => trace._reviewed),
        "A standards-only change must not invalidate unrelated test traces.",
    );

    artifacts = syncReviewArtifacts({
        observations,
        classificationsPath,
        testTracesPath: tracesPath,
        resetReviews: true,
    });
    reviewFixtureStandards(artifacts.classifications);
    projectReviewedStandards(artifacts.classifications, observations);
    markAllFixtureReviews(artifacts);
    writeJsonAtomic(classificationsPath, artifacts.classifications);
    writeJsonAtomic(tracesPath, artifacts.testTraces);

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

    const markdown = renderInventoryMarkdown({
        observations,
        classifications: artifacts.classifications,
        testTraces: artifacts.testTraces,
    });
    assert.match(markdown, /# M0 UI Current-State Inventory/);
    assert.match(markdown, /Issue #32 owns complete test-suite execution/);
    assert.ok(markdown.endsWith("\n"));
    assert.ok(!markdown.endsWith("\n\n"));
    assert.ok(readFileSync(classificationsPath, "utf8").length > 0);

    const documentPath = join(temporaryRoot, "inventory.md");
    const configPath = join(temporaryRoot, "config.json");
    const validatorConfig = structuredClone(config);
    validatorConfig.outputs = {
        observations: join(temporaryRoot, "observations.json"),
        classifications: classificationsPath,
        test_traces: tracesPath,
        document: documentPath,
    };
    writeJsonAtomic(validatorConfig.outputs.observations, observations);
    writeJsonAtomic(configPath, validatorConfig);
    writeTextAtomic(documentPath, markdown);

    let validation = runFixtureValidator(configPath);
    assert.equal(
        validation.status,
        0,
        `Valid fixture artifacts must pass the validator.\n${validation.output}`,
    );

    const validClassifications = structuredClone(artifacts.classifications);
    const emptySlugClassifications = structuredClone(validClassifications);
    emptySlugClassifications.items[0].current_slug = "   ";
    writeJsonAtomic(classificationsPath, emptySlugClassifications);
    validation = runFixtureValidator(configPath);
    assert.notEqual(validation.status, 0);
    assert.match(validation.output, /current_slug must not be empty/);

    const unreviewedStandardClassifications =
        structuredClone(validClassifications);
    unreviewedStandardClassifications.standard_reviews[0]._reviewed = false;
    unreviewedStandardClassifications.standard_reviews[0]._review_required = true;
    writeJsonAtomic(classificationsPath, unreviewedStandardClassifications);
    validation = runFixtureValidator(configPath);
    assert.notEqual(validation.status, 0);
    assert.match(validation.output, /standard is not reviewed/);
    writeJsonAtomic(classificationsPath, validClassifications);
} finally {
    rmSync(temporaryRoot, { recursive: true, force: true });
}

console.log(
    [
        "Issue #30 correction fixture tests passed.",
        `Collected fixture surfaces: ${collection.surfaces.length}.`,
        "Verified section-aware contract parsing, false-link rejection,",
        "Module ViewData/DataProvider coverage, Dashboard contribution coverage,",
        "copied-template evidence, deterministic asset grouping, unique standard reviews,",
        "projection invalidation, validator rejection, Issue #29 support import, and rendering.",
    ].join("\n"),
);

function reviewFixtureStandards(classifications) {
    for (const standard of classifications.standard_reviews) {
        const isContractFile =
            standard._standard_path === "docs/02-standards/ui/contract-file.md";
        setStandardField(
            classifications,
            standard._standard_path,
            "implementation_alignment",
            isContractFile ? "partial" : "aligned",
        );
        setStandardField(
            classifications,
            standard._standard_path,
            "contract_alignment",
            isContractFile ? "stale" : "aligned",
        );
        setStandardField(
            classifications,
            standard._standard_path,
            "reference_or_example_alignment",
            "partial",
        );
        setStandardField(
            classifications,
            standard._standard_path,
            "authority_state",
            isContractFile ? "mixed_authority" : "current_standard",
        );
        setStandardField(
            classifications,
            standard._standard_path,
            "staleness_evidence",
            isContractFile
                ? [
                      "Required testing/review shape conflicts with normalized Defaults exclusions.",
                  ]
                : [],
        );
        setStandardField(
            classifications,
            standard._standard_path,
            "moved_responsibilities",
            isContractFile
                ? [
                      "Testing results and manual readiness moved outside normalized contracts.",
                  ]
                : [],
        );
        markStandardReviewed(
            classifications,
            standard._standard_path,
            `Reviewed fixture direct evidence for ${standard._standard_path}.`,
            "fixture-reviewer",
        );
    }
}

function reviewFixtureContractStandard(classifications) {
    const path = "docs/02-standards/ui/contract-file.md";
    setStandardField(
        classifications,
        path,
        "implementation_alignment",
        "partial",
    );
    setStandardField(classifications, path, "contract_alignment", "stale");
    setStandardField(
        classifications,
        path,
        "reference_or_example_alignment",
        "partial",
    );
    setStandardField(
        classifications,
        path,
        "authority_state",
        "mixed_authority",
    );
    setStandardField(classifications, path, "staleness_evidence", [
        "Required testing/review shape conflicts with normalized Defaults exclusions.",
    ]);
    setStandardField(classifications, path, "moved_responsibilities", [
        "Testing results and manual readiness moved outside normalized contracts.",
    ]);
    markStandardReviewed(
        classifications,
        path,
        "Reviewed fixture contract standard contradiction.",
        "fixture-reviewer",
    );
}

function markAllFixtureReviews(artifacts) {
    for (const item of artifacts.classifications.items) {
        markSurfaceReviewed(
            artifacts.classifications,
            item._record_id,
            `Reviewed fixture surface ${item._record_id}.`,
            "fixture-reviewer",
        );
    }

    for (const trace of artifacts.testTraces.test_traces) {
        markTraceReviewed(
            artifacts.testTraces,
            trace._trace_id,
            `Reviewed fixture trace ${trace._trace_id}.`,
            "fixture-reviewer",
        );
    }
}

function runFixtureValidator(configPath) {
    const result = spawnSync(
        process.execPath,
        [
            resolve(
                repositoryRoot,
                "scripts/check-m0-ui-current-state-inventory.mjs",
            ),
            "--config",
            configPath,
        ],
        { cwd: repositoryRoot, encoding: "utf8" },
    );

    return {
        status: result.status,
        output: `${result.stdout ?? ""}${result.stderr ?? ""}`,
    };
}
