/**
 * ============================================================================
 * File: scripts/lib/m0-ui-inventory/issue29-support.mjs
 * Purpose: Import compact accepted Issue #29 runtime evidence for Issue #30.
 * ============================================================================
 */

import { existsSync } from "node:fs";
import { resolve } from "node:path";
import { ensure, readJson, uniqueSorted } from "./utilities.mjs";

export function loadIssue29SupportingEvidence({
    repositoryRoot,
    config,
    baseline,
}) {
    const relativePath = config.issue_29_supporting_evidence?.raw_path;

    if (!relativePath) {
        return {
            status: "not_configured",
            path: null,
            baseline_sha: null,
            routes: [],
            modules: [],
            commands: {},
        };
    }

    const absolutePath = resolve(repositoryRoot, relativePath);

    if (!existsSync(absolutePath)) {
        return {
            status: "missing",
            path: relativePath,
            baseline_sha: null,
            routes: [],
            modules: [],
            commands: {},
        };
    }

    const artifact = readJson(absolutePath);
    const artifactBaseline = artifact?.baseline?.sha ?? null;

    ensure(
        artifactBaseline === baseline,
        [
            "Issue #29 supporting evidence baseline mismatch.",
            `Expected: ${baseline}`,
            `Found: ${artifactBaseline ?? "missing"}`,
            `Artifact: ${relativePath}`,
            "Stop. Do not import runtime evidence from another baseline.",
        ].join("\n"),
    );

    const items = Array.isArray(artifact.material_items)
        ? artifact.material_items
        : [];
    const routes = items
        .filter((item) => item.source_kind === "runtime_route_dynamic")
        .map((item) => compactRoute(item.runtime_metadata))
        .filter(Boolean)
        .sort(compareRoutes);
    const modules = items
        .filter((item) => item.source_kind === "runtime_module_dynamic")
        .map((item) => compactModule(item.runtime_metadata))
        .filter(Boolean)
        .sort((left, right) =>
            String(left.key ?? "").localeCompare(String(right.key ?? "")),
        );

    return {
        status: "accepted_baseline_match",
        path: relativePath,
        baseline_sha: artifactBaseline,
        routes,
        modules,
        commands: compactCommandSummary(artifact.dynamic_runtime_evidence),
    };
}

function compactRoute(value) {
    if (!value || typeof value !== "object") {
        return null;
    }

    return {
        methods: normalizeStringList(value.methods ?? value.method),
        uri: value.uri ?? null,
        name: value.name ?? null,
        action: value.action ?? null,
        middleware: normalizeStringList(value.middleware),
    };
}

function compactModule(value) {
    if (!value || typeof value !== "object") {
        return null;
    }

    return {
        key: value.key ?? null,
        name: value.name ?? null,
        type: value.type ?? null,
        enabled: value.enabled ?? null,
        routes: value.routes ?? null,
        ui_entries: value.ui_entries ?? null,
        views: value.views ?? null,
    };
}

function compactCommandSummary(value) {
    if (!value || typeof value !== "object") {
        return {};
    }

    return Object.fromEntries(
        Object.entries(value)
            .map(([key, entry]) => [
                key,
                {
                    status: entry?.status ?? "unknown",
                    exit_code: entry?.exit_code ?? null,
                    command: entry?.command ?? null,
                },
            ])
            .sort(([left], [right]) => left.localeCompare(right)),
    );
}

function normalizeStringList(value) {
    if (Array.isArray(value)) {
        return uniqueSorted(value.map(String));
    }

    if (typeof value === "string" && value !== "") {
        return uniqueSorted(value.split("|").map((entry) => entry.trim()));
    }

    return [];
}

function compareRoutes(left, right) {
    return `${left.name ?? ""}\0${left.uri ?? ""}`.localeCompare(
        `${right.name ?? ""}\0${right.uri ?? ""}`,
    );
}
