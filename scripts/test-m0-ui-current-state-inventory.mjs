/**
 * ============================================================================
 * File: scripts/test-m0-ui-current-state-inventory.mjs
 * Purpose: Fixture-test issue #30 grouping, contracts, review, and rendering.
 * ============================================================================
 */

import assert from "node:assert/strict";
import { mkdtempSync, readFileSync, rmSync } from "node:fs";
import { tmpdir } from "node:os";
import { join, resolve } from "node:path";
import process from "node:process";
import { collectDiscoveryEvidence } from "./lib/m0-ui-inventory/discovery-runner.mjs";
import { renderInventoryMarkdown } from "./lib/m0-ui-inventory/markdown-renderer.mjs";
import {
    markSurfaceReviewed,
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
const files = cases.files.map((file, index) => ({
    mode: "100644",
    type: "blob",
    object_sha: sha256(`${index}:${file.path}`).slice(0, 40),
    size: file.content === null ? 100 : Buffer.byteLength(file.content),
    path: file.path,
    content: file.content,
    source_sha256: file.content === null ? null : sha256(file.content),
}));
const collection = collectMaterialSurfaces({
    files,
    discovery: { mode: "fixture", commands: {} },
    config,
});

assert.ok(
    !collection.surfaces.some(
        (surface) => surface.implementation_entry === "vite.config.js",
    ),
    "Vite configuration must remain build evidence, not a UI control surface.",
);
assert.ok(
    !collection.unclaimed_material_files.includes("vite.config.js"),
    "Vite configuration must not be reported as an unclaimed UI material file.",
);
const unresolvedContribution = collection.surfaces.find(
    (surface) =>
        surface.declared_ui_key === "account.main.legacy-platform-directory",
);
assert.equal(
    unresolvedContribution.ownership_candidate.ownership_area,
    "unknown",
);
assert.ok(unresolvedContribution.generated_mismatches.includes("investigate"));

assert.ok(
    collection.surfaces.length >= expected.minimum_surface_count,
    `Expected at least ${expected.minimum_surface_count} surfaces.`,
);

for (const fragment of expected.required_record_fragments) {
    assert.ok(
        collection.surfaces.some((surface) =>
            surface.record_id.includes(fragment),
        ),
        `Missing fixture surface fragment: ${fragment}`,
    );
}

const grid = collection.surfaces.find(
    (surface) =>
        surface.current_slug === "grid" && surface.surface_type === "component",
);
assert.ok(grid, "Grid component was not collected.");
assert.equal(grid.contracts[0].path, expected.contract_variation_path);
assert.equal(grid.contracts[0].filename_variation, true);

const fooComponent = collection.surfaces.find(
    (surface) => surface.declared_ui_key === "component.foo",
);
const fooPattern = collection.surfaces.find(
    (surface) => surface.declared_ui_key === "pattern.foo",
);
assert.ok(
    fooComponent && fooPattern,
    "Path-name collision fixture surfaces are missing.",
);
assert.notEqual(fooComponent.record_id, fooPattern.record_id);
assert.deepEqual(fooComponent.public_api_evidence.props, [
    "disabled",
    "label",
    "type",
]);
assert.ok(
    !fooComponent.public_api_evidence.props.includes("resolvedLabel"),
    "Local fallback variables must not be promoted to public Blade props.",
);
assert.ok(
    !collection.surfaces.some(
        (surface) =>
            surface.implementation_entry ===
            "resources/views/components/ui/foo/__tests__/FooInteraction.spec.js",
    ),
    "A test file must not be inventoried as a JavaScript control.",
);
assert.ok(
    fooComponent.test_candidates.some(
        (candidate) =>
            candidate.path ===
            "resources/views/components/ui/foo/__tests__/FooInteraction.spec.js",
    ),
    "The interaction spec must remain linked as test evidence.",
);

const dialog = collection.surfaces.find(
    (surface) => surface.current_slug === "dialog",
);
assert.equal(dialog.surface_type, "component_family");
assert.ok(dialog.blade_aliases.includes("x-ui.dialog.root"));
assert.ok(dialog.blade_aliases.includes("x-ui.dialog.title"));
assert.deepEqual(dialog.contracts[0].subcomponents, ["x-ui.dialog.root"]);
assert.deepEqual(dialog.contract_api_evidence.comparison.shared_props, [
    "open",
]);
assert.ok(
    dialog.implementation_support_files.includes(
        "resources/views/components/ui/dialog/partials/description.blade.php",
    ),
);
assert.ok(
    !collection.surfaces.some((surface) =>
        surface.record_id.includes(
            "resources:views:components:ui:dialog:partials",
        ),
    ),
    "Private partials must remain support files of their explicit parent bundle.",
);

for (const slug of ["standalone-one", "standalone-two"]) {
    assert.ok(
        collection.surfaces.some(
            (surface) =>
                surface.surface_type === "pattern" &&
                surface.current_slug === slug,
        ),
        `Missing standalone root Pattern: ${slug}`,
    );
}
assert.ok(
    !collection.surfaces.some(
        (surface) =>
            surface.surface_type === "pattern" &&
            surface.current_slug === "patterns",
    ),
    "Independent root Patterns must not be collapsed into one directory record.",
);

const color = collection.surfaces.find(
    (surface) => surface.current_slug === "color",
);
assert.equal(color.implementation_entry, "resources/css/ui/theme-seed.css");

const observations = {
    schema_version: 1,
    issue: 30,
    baseline: {
        sha: PINNED_INVENTORY_BASELINE,
        committed_at: "2026-07-10T22:27:59-04:00",
        immutable: true,
        expected_execution_base: config.expected_execution_base,
        current_head_at_collection: config.expected_execution_base,
        ui_source_diff: {
            changed: false,
            paths: [],
            command: "fixture diff",
        },
    },
    generator: {
        generated_at: "2026-07-11T00:00:00.000Z",
    },
    roots: {},
    required_surface_fields: REQUIRED_SURFACE_FIELDS,
    required_trace_fields: REQUIRED_TRACE_FIELDS,
    discovery: {
        mode: "fixture",
        commands: {},
    },
    source_path_index: files.map((file) => file.path).sort(),
    surfaces: collection.surfaces,
    unclaimed_material_files: [],
    summary: {},
};

const temporaryRoot = mkdtempSync(join(tmpdir(), "m0-ui-inventory-"));
const classificationsPath = join(temporaryRoot, "classifications.json");
const tracesPath = join(temporaryRoot, "traces.json");

try {
    let artifacts = syncReviewArtifacts({
        observations,
        classificationsPath,
        testTracesPath: tracesPath,
    });
    const unreviewedPattern = artifacts.classifications.items.find(
        (item) => item._record_id === fooPattern.record_id,
    );
    const regeneratedObservations = structuredClone(observations);
    const regeneratedPattern = regeneratedObservations.surfaces.find(
        (surface) => surface.record_id === fooPattern.record_id,
    );
    regeneratedPattern.generated_mismatches = ["investigate"];
    artifacts = syncReviewArtifacts({
        observations: regeneratedObservations,
        classificationsPath,
        testTracesPath: tracesPath,
    });
    const refreshedPattern = artifacts.classifications.items.find(
        (item) => item._record_id === fooPattern.record_id,
    );
    assert.ok(!unreviewedPattern.known_mismatches.includes("investigate"));
    assert.deepEqual(refreshedPattern.known_mismatches, ["investigate"]);
    assert.equal(refreshedPattern.inventory_disposition, "investigate");

    const record = artifacts.classifications.items.find(
        (item) => item._record_id === fooComponent.record_id,
    );
    record.owner_key = "reviewed_ui_owner";
    markSurfaceReviewed(
        artifacts.classifications,
        record._record_id,
        "Fixture review completed.",
        "fixture-reviewer",
    );
    writeJsonAtomic(classificationsPath, artifacts.classifications);

    artifacts = syncReviewArtifacts({
        observations,
        classificationsPath,
        testTracesPath: tracesPath,
    });
    const preserved = artifacts.classifications.items.find(
        (item) => item._record_id === fooComponent.record_id,
    );
    assert.equal(preserved.owner_key, "reviewed_ui_owner");
    assert.equal(preserved._reviewed, true);

    const changedObservations = structuredClone(observations);
    const changedSurface = changedObservations.surfaces.find(
        (surface) => surface.record_id === fooComponent.record_id,
    );
    changedSurface.source_fingerprint = sourceFingerprint({ changed: true });
    artifacts = syncReviewArtifacts({
        observations: changedObservations,
        classificationsPath,
        testTracesPath: tracesPath,
    });
    const marked = artifacts.classifications.items.find(
        (item) => item._record_id === fooComponent.record_id,
    );
    assert.equal(marked.owner_key, "reviewed_ui_owner");
    assert.equal(marked._reviewed, false);
    assert.equal(marked._review_required, true);

    const priorFailure = {
        mode: "runtime_attempted",
        commands: {
            route_list: {
                command: "php artisan route:list --json",
                current_attempt: { status: "failed" },
                last_success: null,
            },
        },
    };
    const preservedFailure = collectDiscoveryEvidence({
        repositoryRoot,
        config,
        staticOnly: true,
        existing: priorFailure,
    });
    assert.deepEqual(preservedFailure, priorFailure);

    const discoveryConfig = structuredClone(config);
    discoveryConfig.runtime_discovery = [
        {
            key: "redaction_fixture",
            command: [
                process.execPath,
                "-e",
                "process.stderr.write(process.cwd()); process.exit(1);",
            ],
        },
    ];
    const redactedDiscovery = collectDiscoveryEvidence({
        repositoryRoot: repositoryRoot.replaceAll("\\", "/"),
        config: discoveryConfig,
        staticOnly: false,
        existing: null,
    });
    const redactedAttempt =
        redactedDiscovery.commands.redaction_fixture.current_attempt;
    assert.equal(redactedAttempt.status, "failed");
    assert.ok(!Object.hasOwn(redactedAttempt, "_stdout"));
    assert.ok(!redactedAttempt.stderr.includes(repositoryRoot));
    assert.match(redactedAttempt.stderr, /<repository-root>/);

    const renderingClassifications = structuredClone(artifacts.classifications);
    for (const item of renderingClassifications.items) {
        item._reviewed = true;
        item._review_required = false;
    }
    const renderingTraces = structuredClone(artifacts.testTraces);
    for (const trace of renderingTraces.test_traces) {
        trace._reviewed = true;
        trace._review_required = false;
    }
    const markdown = renderInventoryMarkdown({
        observations: changedObservations,
        classifications: renderingClassifications,
        testTraces: renderingTraces,
    });
    assert.match(markdown, /# M0 UI Current-State Inventory/);
    assert.match(markdown, /Issue #32 owns complete test-suite execution/);

    assert.ok(
        readFileSync(classificationsPath, "utf8").includes("reviewed_ui_owner"),
    );
} finally {
    rmSync(temporaryRoot, { recursive: true, force: true });
}

console.log(
    [
        "Issue #30 fixture tests passed.",
        `Collected fixture surfaces: ${collection.surfaces.length}.`,
        "Verified path-name collisions, contract variations, family grouping,",
        "review preservation, changed-source re-review, failed discovery preservation,",
        "discovery path redaction, private stdout omission,",
        "and repository-independent rendering.",
    ].join("\n"),
);
