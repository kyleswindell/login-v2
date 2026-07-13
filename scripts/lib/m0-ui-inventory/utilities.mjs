/**
 * ============================================================================
 * File: scripts/lib/m0-ui-inventory/utilities.mjs
 * Purpose: Shared deterministic helpers for the issue #30 UI inventory tools.
 * ============================================================================
 */

import { createHash } from "node:crypto";
import {
    existsSync,
    mkdirSync,
    readFileSync,
    renameSync,
    writeFileSync,
} from "node:fs";
import { dirname, resolve } from "node:path";

export function normalizePath(value) {
    return String(value ?? "")
        .replaceAll("\\", "/")
        .replace(/^\.\//, "")
        .replace(/\/{2,}/g, "/");
}

export function sha256(value) {
    return createHash("sha256").update(value).digest("hex");
}

export function sourceFingerprint(value) {
    return sha256(stableStringify(value));
}

export function stableStringify(value, spacing = 2) {
    return `${stringifyCompact(sortRecursively(value), spacing)}\n`;
}

function stringifyCompact(value, spacing, depth = 0) {
    if (value === null || typeof value !== "object") {
        return JSON.stringify(value);
    }

    const compact = JSON.stringify(value);

    if (
        compact.length <= 160 ||
        (Array.isArray(value) &&
            value.every((item) => item === null || typeof item !== "object") &&
            compact.length <= 240)
    ) {
        return compact;
    }

    const indent = typeof spacing === "number" ? " ".repeat(spacing) : spacing;
    const currentIndent = indent.repeat(depth);
    const childIndent = indent.repeat(depth + 1);

    if (Array.isArray(value)) {
        return [
            "[",
            value
                .map(
                    (item) =>
                        `${childIndent}${stringifyCompact(item, spacing, depth + 1)}`,
                )
                .join(",\n"),
            `${currentIndent}]`,
        ].join("\n");
    }

    return [
        "{",
        Object.entries(value)
            .map(
                ([key, child]) =>
                    `${childIndent}${JSON.stringify(key)}: ${stringifyCompact(child, spacing, depth + 1)}`,
            )
            .join(",\n"),
        `${currentIndent}}`,
    ].join("\n");
}

export function sortRecursively(value) {
    if (Array.isArray(value)) {
        return value.map(sortRecursively);
    }

    if (value !== null && typeof value === "object") {
        return Object.fromEntries(
            Object.entries(value)
                .sort(([left], [right]) => left.localeCompare(right))
                .map(([key, child]) => [key, sortRecursively(child)]),
        );
    }

    return value;
}

export function readJson(path) {
    return JSON.parse(readFileSync(path, "utf8"));
}

export function readJsonIfExists(path) {
    return existsSync(path) ? readJson(path) : null;
}

export function writeJsonAtomic(path, value) {
    const absolutePath = resolve(path);
    mkdirSync(dirname(absolutePath), { recursive: true });
    const temporaryPath = `${absolutePath}.tmp-${process.pid}`;
    writeFileSync(temporaryPath, stableStringify(value), "utf8");
    renameSync(temporaryPath, absolutePath);
}

export function writeTextAtomic(path, value) {
    const absolutePath = resolve(path);
    mkdirSync(dirname(absolutePath), { recursive: true });
    const temporaryPath = `${absolutePath}.tmp-${process.pid}`;
    writeFileSync(temporaryPath, value, "utf8");
    renameSync(temporaryPath, absolutePath);
}

export function uniqueSorted(values) {
    return [
        ...new Set(values.filter((value) => value !== null && value !== "")),
    ].sort((left, right) => String(left).localeCompare(String(right)));
}

export function arrayDifference(left, right) {
    const rightSet = new Set(right);
    return left.filter((value) => !rightSet.has(value));
}

export function parseCliValue(value) {
    if (value === undefined) {
        return null;
    }

    try {
        return JSON.parse(value);
    } catch {
        return value;
    }
}

export function parseArguments(values) {
    const parsed = { _: [] };

    for (let index = 0; index < values.length; index += 1) {
        const value = values[index];

        if (!value.startsWith("--")) {
            parsed._.push(value);
            continue;
        }

        const key = value.slice(2).replaceAll("-", "_");
        const next = values[index + 1];

        if (next === undefined || next.startsWith("--")) {
            parsed[key] = true;
            continue;
        }

        parsed[key] = next;
        index += 1;
    }

    return parsed;
}

export function makeRecordId(surfaceType, identity) {
    const normalizedIdentity = normalizePath(identity || "unknown");
    const readable = normalizedIdentity
        .replace(/[^a-zA-Z0-9._/-]+/g, "-")
        .replaceAll("/", ":")
        .slice(0, 120);

    return `${surfaceType}:${readable}:${sha256(normalizedIdentity).slice(0, 10)}`;
}

export function makeTraceId(surfaceRecordId, testPath) {
    return `trace:${sha256(`${surfaceRecordId}\0${normalizePath(testPath)}`).slice(0, 20)}`;
}

export function sanitizeCommandOutput(value, maxLength = 4000) {
    return String(value ?? "")
        .replace(
            /(APP_KEY|PASSWORD|TOKEN|SECRET|PRIVATE_KEY|CLIENT_SECRET)\s*=\s*[^\s]+/gi,
            "$1=[REDACTED]",
        )
        .slice(0, maxLength);
}

export function commandText(command) {
    return command
        .map((part) =>
            /^[A-Za-z0-9_./:@=-]+$/.test(part) ? part : JSON.stringify(part),
        )
        .join(" ");
}

export function compilePatterns(patterns) {
    return patterns.map((pattern) => new RegExp(pattern));
}

export function matchesAny(path, patterns) {
    return patterns.some((pattern) => pattern.test(path));
}

export function isPathWithinAllowedScope(path, allowedPaths) {
    const normalized = normalizePath(path);

    return allowedPaths.some((allowedPath) => {
        const allowed = normalizePath(allowedPath).replace(/\/$/, "");
        return normalized === allowed || normalized.startsWith(`${allowed}/`);
    });
}

export function ensure(condition, message) {
    if (!condition) {
        throw new Error(message);
    }
}

export function currentIsoTimestamp() {
    return new Date().toISOString();
}

export function summarizeValues(items, selector) {
    const counts = new Map();

    for (const item of items) {
        const value = selector(item);
        counts.set(value, (counts.get(value) ?? 0) + 1);
    }

    return Object.fromEntries(
        [...counts.entries()].sort(([left], [right]) =>
            String(left).localeCompare(String(right)),
        ),
    );
}
