/**
 * ============================================================================
 * File: scripts/render-m0-ui-current-state-inventory.mjs
 * Purpose: Render issue #30 Markdown from persisted reviewed evidence only.
 * ============================================================================
 */

import { resolve } from "node:path";
import process from "node:process";
import { renderInventoryMarkdown } from "./lib/m0-ui-inventory/markdown-renderer.mjs";
import {
    ensure,
    parseArguments,
    readJson,
    writeTextAtomic,
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

ensure(
    observations.baseline.sha === classifications.baseline_sha &&
        observations.baseline.sha === testTraces.baseline_sha,
    "Cannot render issue #30: evidence artifact baselines disagree.",
);

if (!args.allow_pending) {
    const pendingSurfaces = classifications.items.filter(
        (item) => item._reviewed !== true || item._review_required === true,
    );
    const pendingTraces = testTraces.test_traces.filter(
        (trace) => trace._reviewed !== true || trace._review_required === true,
    );

    ensure(
        pendingSurfaces.length === 0 && pendingTraces.length === 0,
        `Cannot render final inventory with ${pendingSurfaces.length} pending surface review(s) and ${pendingTraces.length} pending test trace(s).`,
    );
}

const markdown = renderInventoryMarkdown({
    observations,
    classifications,
    testTraces,
});
writeTextAtomic(resolve(repositoryRoot, config.outputs.document), markdown);

console.log(
    `Rendered ${config.outputs.document} from persisted evidence only.`,
);
