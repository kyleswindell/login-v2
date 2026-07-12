/**
 * ============================================================================
 * File: scripts/lib/m0-ui-inventory/discovery-runner.mjs
 * Purpose: Run bounded read-only Laravel discovery and preserve prior evidence.
 * ============================================================================
 */

import { spawnSync } from "node:child_process";
import {
    commandText,
    currentIsoTimestamp,
    sanitizeCommandOutput,
} from "./utilities.mjs";

export function collectDiscoveryEvidence({
    repositoryRoot,
    config,
    staticOnly,
    existing,
}) {
    if (staticOnly) {
        return (
            existing ?? {
                mode: "static_only_no_prior_evidence",
                commands: {},
            }
        );
    }

    const commands = {};

    for (const definition of config.runtime_discovery) {
        const attempt = runOptional(repositoryRoot, definition.command);
        const { _stdout: _privateStdout, ...currentAttempt } = attempt;
        const previous = existing?.commands?.[definition.key] ?? null;

        commands[definition.key] = {
            command: commandText(definition.command),
            current_attempt: currentAttempt,
            last_success:
                attempt.status === "passed"
                    ? compactSuccessfulPayload(definition.key, attempt)
                    : (previous?.last_success ?? null),
            preserved_prior_failure:
                attempt.status === "passed"
                    ? previous?.current_attempt?.status !== "passed"
                        ? (previous?.current_attempt ?? null)
                        : null
                    : (previous?.preserved_prior_failure ?? null),
        };
    }

    return {
        mode: "runtime_attempted",
        collected_at: currentIsoTimestamp(),
        commands,
    };
}

function runOptional(repositoryRoot, command) {
    const [executable, ...args] = command;
    const startedAt = currentIsoTimestamp();
    const result = spawnSync(executable, args, {
        cwd: repositoryRoot,
        encoding: "utf8",
        maxBuffer: 64 * 1024 * 1024,
        windowsHide: true,
        timeout: 120_000,
    });

    if (result.error) {
        return {
            status:
                result.error.code === "ETIMEDOUT" ? "timed_out" : "unavailable",
            exit_code: null,
            started_at: startedAt,
            stderr: sanitizeDiscoveryOutput(
                result.error.message,
                repositoryRoot,
            ),
            stdout_summary: "",
        };
    }

    return {
        status: result.status === 0 ? "passed" : "failed",
        exit_code: result.status,
        started_at: startedAt,
        stderr: sanitizeDiscoveryOutput(result.stderr, repositoryRoot),
        stdout_summary:
            result.status === 0
                ? summarizeOutput(result.stdout)
                : sanitizeDiscoveryOutput(result.stdout, repositoryRoot),
        _stdout: result.stdout ?? "",
    };
}

function sanitizeDiscoveryOutput(value, repositoryRoot, maxLength = 4000) {
    const root = String(repositoryRoot ?? "");
    const normalizedRoot = root.replaceAll("\\", "/");
    const nativeWindowsRoot = root.replaceAll("/", "\\");
    const escapedRoots = [root, normalizedRoot, nativeWindowsRoot]
        .filter(Boolean)
        .filter(
            (candidate, index, values) => values.indexOf(candidate) === index,
        )
        .map((candidate) => candidate.replace(/[.*+?^${}()|[\]\\]/g, "\\$&"));
    const rootPattern =
        escapedRoots.length > 0
            ? new RegExp(escapedRoots.join("|"), "gi")
            : null;
    const redacted = rootPattern
        ? String(value ?? "").replace(rootPattern, "<repository-root>")
        : String(value ?? "");

    return sanitizeCommandOutput(redacted, maxLength);
}

function compactSuccessfulPayload(key, attempt) {
    let parsed = null;

    try {
        parsed = JSON.parse(attempt._stdout);
    } catch {
        parsed = null;
    }

    const payload =
        key === "route_list"
            ? compactRoutes(parsed)
            : key === "artisan_list"
              ? compactCommands(parsed)
              : key === "module_list"
                ? compactModules(parsed)
                : parsed;

    return {
        collected_at: attempt.started_at,
        exit_code: attempt.exit_code,
        payload,
    };
}

function compactRoutes(payload) {
    if (!Array.isArray(payload)) {
        return [];
    }

    return payload
        .filter((route) => {
            const name = String(route.name ?? "");
            const uri = String(route.uri ?? "");
            return (
                name !== "" ||
                uri.startsWith("platform/") ||
                uri.startsWith("account/") ||
                uri.startsWith("settings/") ||
                uri.startsWith("setup") ||
                uri === "/"
            );
        })
        .map((route) => ({
            method: route.method ?? null,
            uri: route.uri ?? null,
            name: route.name ?? null,
            action: route.action ?? null,
            middleware: route.middleware ?? null,
        }))
        .sort((left, right) =>
            `${left.name ?? ""}\0${left.uri ?? ""}`.localeCompare(
                `${right.name ?? ""}\0${right.uri ?? ""}`,
            ),
        );
}

function compactCommands(payload) {
    const commands = Array.isArray(payload?.commands) ? payload.commands : [];

    return commands
        .filter((command) => {
            const name = String(command.name ?? "");
            return (
                name.startsWith("platform:") ||
                name.startsWith("modules:") ||
                name.startsWith("local:") ||
                name.startsWith("active-batch-review:")
            );
        })
        .map((command) => ({
            name: command.name ?? null,
            description: command.description ?? null,
        }))
        .sort((left, right) =>
            String(left.name).localeCompare(String(right.name)),
        );
}

function compactModules(payload) {
    const modules = Array.isArray(payload?.modules) ? payload.modules : [];

    return modules
        .map((module) => ({
            key: module.key ?? null,
            name: module.name ?? null,
            type: module.type ?? null,
            enabled: module.enabled ?? null,
            routes: module.routes ?? null,
            ui_entries: module.ui_entries ?? null,
            views: module.views ?? null,
        }))
        .sort((left, right) =>
            String(left.key).localeCompare(String(right.key)),
        );
}

function summarizeOutput(value) {
    const text = String(value ?? "");

    try {
        const parsed = JSON.parse(text);
        return Array.isArray(parsed)
            ? `JSON array with ${parsed.length} item(s).`
            : `JSON object with ${Object.keys(parsed ?? {}).length} top-level key(s).`;
    } catch {
        return sanitizeCommandOutput(text, 500);
    }
}
