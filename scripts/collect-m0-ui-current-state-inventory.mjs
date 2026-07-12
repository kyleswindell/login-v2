/**
 * ============================================================================
 * File: scripts/collect-m0-ui-current-state-inventory.mjs
 * Purpose: Collect deterministic implementation-first issue #30 observations.
 * ============================================================================
 */

import { spawnSync } from "node:child_process";
import { relative, resolve } from "node:path";
import process from "node:process";
import {
    assertAllowedWorktree,
    assertCommitAvailable,
    commitDate,
    currentHead,
    discoverRepositoryRoot,
    hydrateScopedFiles,
    listScopedTree,
} from "./lib/m0-ui-inventory/git-batch-reader.mjs";
import { collectDiscoveryEvidence } from "./lib/m0-ui-inventory/discovery-runner.mjs";
import { collectMaterialSurfaces } from "./lib/m0-ui-inventory/surface-collector.mjs";
import {
    PINNED_INVENTORY_BASELINE,
    REQUIRED_SURFACE_FIELDS,
    REQUIRED_TRACE_FIELDS,
} from "./lib/m0-ui-inventory/schema.mjs";
import {
    commandText,
    currentIsoTimestamp,
    ensure,
    normalizePath,
    parseArguments,
    readJson,
    readJsonIfExists,
    summarizeValues,
    writeJsonAtomic,
} from "./lib/m0-ui-inventory/utilities.mjs";

const args = parseArguments(process.argv.slice(2));
const repositoryRoot = discoverRepositoryRoot();
process.chdir(repositoryRoot);

const configPath = resolve(
    repositoryRoot,
    args.config ?? "scripts/m0-ui-inventory.config.json",
);
const config = readJson(configPath);
const baseline = args.baseline ?? config.inventory_baseline;

ensure(
    baseline === PINNED_INVENTORY_BASELINE,
    `Issue #30 inventory baseline must remain ${PINNED_INVENTORY_BASELINE}; received ${baseline}.`,
);
ensure(
    config.inventory_baseline === PINNED_INVENTORY_BASELINE,
    "The configuration inventory baseline does not match the issue #30 pinned baseline.",
);

assertCommitAvailable(repositoryRoot, baseline);
assertCommitAvailable(repositoryRoot, config.expected_execution_base);

if (!args.allow_extra_changes) {
    assertAllowedWorktree(repositoryRoot, config);
}

const uiSourceDiff = inspectUiSourceDiff(repositoryRoot, config);
ensure(
    uiSourceDiff.changed === false,
    [
        `UI source changed between the pinned inventory baseline ${baseline}`,
        `and expected execution base ${config.expected_execution_base}.`,
        ...uiSourceDiff.paths.map((path) => `- ${path}`),
        "Stop. Do not repin or continue without explicit repository-owner approval.",
    ].join("\n"),
);

const treeEntries = listScopedTree(repositoryRoot, baseline, config);
const files = hydrateScopedFiles(repositoryRoot, treeEntries, config);
const observationsPath = resolve(repositoryRoot, config.outputs.observations);
const priorObservations = readJsonIfExists(observationsPath);
const discovery = collectDiscoveryEvidence({
    repositoryRoot,
    config,
    staticOnly: Boolean(args.static_only),
    existing:
        priorObservations?.baseline?.sha === baseline
            ? priorObservations.discovery
            : null,
});
const collection = collectMaterialSurfaces({ files, discovery, config });
const generatedAt = currentIsoTimestamp();
const generatorCommand = commandText([
    "node",
    "scripts/collect-m0-ui-current-state-inventory.mjs",
    ...process.argv.slice(2),
]);
const observations = {
    schema_version: 1,
    issue: 30,
    baseline: {
        sha: baseline,
        committed_at: commitDate(repositoryRoot, baseline),
        immutable: true,
        expected_execution_base: config.expected_execution_base,
        current_head_at_collection: currentHead(repositoryRoot),
        ui_source_diff: uiSourceDiff,
    },
    generator: {
        path: "scripts/collect-m0-ui-current-state-inventory.mjs",
        config_path: normalizePath(relative(repositoryRoot, configPath)),
        command: generatorCommand,
        generated_at: generatedAt,
        static_only: Boolean(args.static_only),
        collection_mode: "scoped_git_tree_and_batched_blob_read",
    },
    roots: {
        scoped_roots: config.scoped_roots,
        selected_tree_entry_count: treeEntries.length,
        readable_text_file_count: files.filter((file) => file.content !== null)
            .length,
        grouped_asset_file_count: files.filter((file) =>
            file.path.endsWith(".svg"),
        ).length,
    },
    required_surface_fields: REQUIRED_SURFACE_FIELDS,
    required_trace_fields: REQUIRED_TRACE_FIELDS,
    discovery,
    source_path_index: files.map((file) => file.path).sort(),
    surfaces: collection.surfaces,
    unclaimed_material_files: collection.unclaimed_material_files,
    summary: {
        material_surface_count: collection.surfaces.length,
        surface_type_counts: summarizeValues(
            collection.surfaces,
            (surface) => surface.surface_type,
        ),
        generated_mismatch_counts: summarizeValues(
            collection.surfaces.flatMap((surface) =>
                surface.generated_mismatches.map((mismatch) => ({ mismatch })),
            ),
            (entry) => entry.mismatch,
        ),
        unclaimed_material_file_count:
            collection.unclaimed_material_files.length,
    },
};

writeJsonAtomic(observationsPath, observations);

console.log(
    [
        `Issue #30 observations collected from ${baseline}.`,
        `Scoped Git entries: ${treeEntries.length}.`,
        `Material UI surfaces: ${collection.surfaces.length}.`,
        `Unclaimed material candidates: ${collection.unclaimed_material_files.length}.`,
        `Observations: ${config.outputs.observations}`,
        "Reviewed classifications and test traces were not modified.",
    ].join("\n"),
);

function inspectUiSourceDiff(root, settings) {
    const command = [
        "git",
        "diff",
        "--name-only",
        settings.inventory_baseline,
        settings.expected_execution_base,
        "--",
        ...settings.ui_source_diff_roots,
    ];
    const result = spawnSync(command[0], command.slice(1), {
        cwd: root,
        encoding: "utf8",
        maxBuffer: 64 * 1024 * 1024,
        windowsHide: true,
    });

    if (result.error) {
        throw result.error;
    }

    ensure(
        result.status === 0,
        `Unable to compare UI source baselines:\n${String(result.stderr ?? "").slice(0, 4000)}`,
    );

    const paths = result.stdout
        .split(/\r?\n/)
        .map(normalizePath)
        .filter(Boolean)
        .sort();

    return {
        changed: paths.length > 0,
        paths,
        command: commandText(command),
    };
}
