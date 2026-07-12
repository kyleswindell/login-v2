/**
 * ============================================================================
 * File: scripts/lib/m0-ui-inventory/git-batch-reader.mjs
 * Purpose: Read the pinned UI-only Git tree with one tree query and one batch.
 * ============================================================================
 */

import { spawnSync } from "node:child_process";
import { extname } from "node:path";
import {
    compilePatterns,
    ensure,
    matchesAny,
    normalizePath,
    sha256,
} from "./utilities.mjs";

export function discoverRepositoryRoot(cwd = process.cwd()) {
    const result = runGit(cwd, ["rev-parse", "--show-toplevel"]);
    return normalizePath(result.stdout.trim());
}

export function assertCommitAvailable(repositoryRoot, commit) {
    runGit(repositoryRoot, ["cat-file", "-e", `${commit}^{commit}`]);
}

export function currentHead(repositoryRoot) {
    return runGit(repositoryRoot, ["rev-parse", "HEAD"]).stdout.trim();
}

export function commitDate(repositoryRoot, commit) {
    return runGit(repositoryRoot, [
        "show",
        "-s",
        "--format=%cI",
        commit,
    ]).stdout.trim();
}

export function listScopedTree(repositoryRoot, commit, config) {
    const result = spawnSync(
        "git",
        ["ls-tree", "-r", "-z", "-l", commit, "--", ...config.scoped_roots],
        {
            cwd: repositoryRoot,
            encoding: "buffer",
            maxBuffer: 128 * 1024 * 1024,
            windowsHide: true,
        },
    );

    ensureGitResult(result, "git ls-tree");

    const excludePatterns = compilePatterns(config.exclude_patterns);
    const modulePatterns = compilePatterns(config.module_include_patterns);

    return result.stdout
        .toString("utf8")
        .split("\0")
        .filter(Boolean)
        .map(parseTreeEntry)
        .filter((entry) => !matchesAny(entry.path, excludePatterns))
        .filter((entry) =>
            entry.path.startsWith("Modules/")
                ? matchesAny(entry.path, modulePatterns)
                : true,
        )
        .sort((left, right) => left.path.localeCompare(right.path));
}

export function hydrateScopedFiles(repositoryRoot, entries, config) {
    const textExtensions = new Set(config.text_extensions);
    const readableEntries = entries.filter((entry) => {
        const extension = extensionFor(entry.path);
        return (
            textExtensions.has(extension) &&
            Number(entry.size ?? 0) <= config.max_text_bytes &&
            !entry.path.endsWith(".svg")
        );
    });

    const contentByObject = readObjectsBatch(repositoryRoot, readableEntries);

    return entries.map((entry) => {
        const content = contentByObject.get(entry.object_sha) ?? null;

        return {
            ...entry,
            content,
            source_sha256: content === null ? null : sha256(content),
        };
    });
}

export function assertAllowedWorktree(repositoryRoot, config) {
    const result = runGit(repositoryRoot, [
        "status",
        "--porcelain=v1",
        "-z",
        "--untracked-files=all",
    ]);

    const entries = result.stdout.split("\0").filter(Boolean);
    const unexpected = [];

    for (const entry of entries) {
        const statusAndPath = entry.slice(0, 3);
        const path = normalizePath(entry.slice(3));
        const allowed = config.allowed_worktree_paths.some((allowedPath) => {
            const normalizedAllowed = normalizePath(allowedPath).replace(
                /\/$/,
                "",
            );
            return (
                path === normalizedAllowed ||
                path.startsWith(`${normalizedAllowed}/`)
            );
        });

        if (!allowed) {
            unexpected.push(`${statusAndPath}${path}`);
        }
    }

    ensure(
        unexpected.length === 0,
        [
            "Issue #30 tooling found changes outside the approved package scope:",
            ...unexpected.map((entry) => `- ${entry}`),
            "Use a clean issue branch. Do not force-reset or delete unrelated work.",
        ].join("\n"),
    );
}

function readObjectsBatch(repositoryRoot, entries) {
    if (entries.length === 0) {
        return new Map();
    }

    const input = Buffer.from(
        `${entries.map((entry) => entry.object_sha).join("\n")}\n`,
        "utf8",
    );
    const result = spawnSync("git", ["cat-file", "--batch"], {
        cwd: repositoryRoot,
        input,
        encoding: "buffer",
        maxBuffer: 256 * 1024 * 1024,
        windowsHide: true,
    });

    ensureGitResult(result, "git cat-file --batch");

    const output = result.stdout;
    const contents = new Map();
    let offset = 0;

    for (const entry of entries) {
        const lineEnd = output.indexOf(10, offset);
        ensure(lineEnd >= 0, `Missing batch header for ${entry.path}.`);

        const header = output.subarray(offset, lineEnd).toString("utf8");
        const match = header.match(/^([0-9a-f]+)\s+(\w+)\s+(\d+)$/);
        ensure(
            match !== null,
            `Unexpected batch header for ${entry.path}: ${header}`,
        );

        const size = Number(match[3]);
        const contentStart = lineEnd + 1;
        const contentEnd = contentStart + size;
        ensure(
            contentEnd <= output.length,
            `Truncated batch content for ${entry.path}.`,
        );

        contents.set(
            entry.object_sha,
            output.subarray(contentStart, contentEnd).toString("utf8"),
        );
        offset = contentEnd + 1;
    }

    return contents;
}

function parseTreeEntry(value) {
    const match = value.match(/^(\d+)\s+(\w+)\s+([0-9a-f]+)\s+(-|\d+)\t(.+)$/);
    ensure(match !== null, `Unable to parse Git tree entry: ${value}`);

    return {
        mode: match[1],
        type: match[2],
        object_sha: match[3],
        size: match[4] === "-" ? null : Number(match[4]),
        path: normalizePath(match[5]),
    };
}

function extensionFor(path) {
    if (path.endsWith(".blade.php")) {
        return ".blade.php";
    }

    return extname(path).toLowerCase();
}

function runGit(repositoryRoot, args) {
    const result = spawnSync("git", args, {
        cwd: repositoryRoot,
        encoding: "utf8",
        maxBuffer: 128 * 1024 * 1024,
        windowsHide: true,
    });

    ensureGitResult(result, `git ${args.join(" ")}`);
    return result;
}

function ensureGitResult(result, command) {
    if (result.error) {
        throw result.error;
    }

    ensure(
        result.status === 0,
        `${command} failed:\n${String(result.stderr ?? result.stdout ?? "").slice(0, 4000)}`,
    );
}
