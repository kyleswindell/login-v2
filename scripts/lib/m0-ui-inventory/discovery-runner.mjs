/**
 * ============================================================================
 * File: scripts/lib/m0-ui-inventory/discovery-runner.mjs
 * Purpose: Run bounded UI discovery while preserving accepted prior evidence.
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
    issue29Support,
}) {
    const supportingCommands = issue29Support?.commands ?? {};
    const definitions = config.runtime_discovery ?? [];

    if (staticOnly) {
        return mergeSupportingEvidence({
            existing,
            definitions,
            supportingCommands,
            issue29Support,
            mode: "static_only_preserved",
        });
    }

    const commands = {};

    for (const definition of definitions) {
        const attempt = runOptional(repositoryRoot, definition.command);
        const { _stdout: privateStdout, ...currentAttempt } = attempt;
        const previous = existing?.commands?.[definition.key] ?? null;
        const imported = importedSuccess(definition.key, issue29Support);

        commands[definition.key] = {
            command: commandText(definition.command),
            current_attempt: currentAttempt,
            last_success:
                attempt.status === "passed"
                    ? compactSuccessfulPayload(definition.key, {
                          ...attempt,
                          _stdout: privateStdout,
                      })
                    : (previous?.last_success ?? imported),
            accepted_supporting_evidence:
                supportingCommands[definition.key] ?? null,
            preserved_prior_failure:
                attempt.status === "passed"
                    ? previous?.current_attempt?.status !== "passed"
                        ? (previous?.current_attempt ?? null)
                        : null
                    : (previous?.preserved_prior_failure ?? null),
        };
    }

    return {
        mode: "runtime_attempted_with_issue_29_support",
        collected_at: currentIsoTimestamp(),
        issue_29_support: compactSupportHeader(issue29Support),
        commands,
    };
}

function mergeSupportingEvidence({
    existing,
    definitions,
    supportingCommands,
    issue29Support,
    mode,
}) {
    const commands = {};

    for (const definition of definitions) {
        const previous = existing?.commands?.[definition.key] ?? null;
        commands[definition.key] = {
            command: commandText(definition.command),
            current_attempt: previous?.current_attempt ?? {
                status: "not_attempted_static_only",
                exit_code: null,
                started_at: null,
                stderr: "",
                stdout_summary: "",
            },
            last_success:
                previous?.last_success ??
                importedSuccess(definition.key, issue29Support),
            accepted_supporting_evidence:
                supportingCommands[definition.key] ?? null,
            preserved_prior_failure: previous?.preserved_prior_failure ?? null,
        };
    }

    return {
        mode,
        collected_at: existing?.collected_at ?? currentIsoTimestamp(),
        issue_29_support: compactSupportHeader(issue29Support),
        commands,
    };
}

function importedSuccess(key, issue29Support) {
    if (issue29Support?.status !== "accepted_baseline_match") {
        return null;
    }

    if (key === "route_list") {
        return {
            source: "issue_29_accepted_runtime_evidence",
            baseline_sha: issue29Support.baseline_sha,
            artifact_path: issue29Support.path,
            payload: issue29Support.routes,
        };
    }

    if (key === "module_list") {
        return {
            source: "issue_29_accepted_runtime_evidence",
            baseline_sha: issue29Support.baseline_sha,
            artifact_path: issue29Support.path,
            payload: issue29Support.modules,
        };
    }

    return null;
}

function compactSupportHeader(issue29Support) {
    return {
        status: issue29Support?.status ?? "unavailable",
        path: issue29Support?.path ?? null,
        baseline_sha: issue29Support?.baseline_sha ?? null,
        route_count: issue29Support?.routes?.length ?? 0,
        module_count: issue29Support?.modules?.length ?? 0,
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
            _stdout: "",
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
    const candidates = [
        root,
        root.replaceAll("\\", "/"),
        root.replaceAll("/", "\\"),
    ]
        .filter(Boolean)
        .filter(
            (candidate, index, values) => values.indexOf(candidate) === index,
        );
    let redacted = String(value ?? "");

    for (const candidate of candidates) {
        redacted = redacted.replaceAll(candidate, "<repository-root>");
    }

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
        source: "current_worktree_runtime_discovery",
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
        .map((route) => ({
            methods: normalizeMethods(route.method),
            uri: route.uri ?? null,
            name: route.name ?? null,
            action: route.action ?? null,
            middleware: Array.isArray(route.middleware)
                ? route.middleware.map(String).sort()
                : (route.middleware ?? null),
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

function normalizeMethods(value) {
    if (Array.isArray(value)) {
        return value.map(String).sort();
    }

    return String(value ?? "")
        .split("|")
        .map((entry) => entry.trim())
        .filter(Boolean)
        .sort();
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
