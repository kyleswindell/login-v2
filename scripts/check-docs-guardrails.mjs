import { readdirSync, readFileSync, statSync } from "node:fs";
import { join, relative } from "node:path";

const root = process.cwd();

const checks = [
    {
        label: "Legacy /docs-v2/ markdown link target found",
        pattern: /\[[^\]]+\]\([^\)]*\/docs-v2\/[^\)]*\)/g,
    },
    {
        label: "Legacy docs/V2 App/ markdown link target found",
        pattern: /\[[^\]]+\]\([^\)]*docs\/V2(?: |%20)App\/[^\)]*\)/g,
    },
    {
        label: "Legacy wiki link found",
        pattern: /(?<!`)\[\[V1 App\/[^\]]*\]\](?!`)/g,
    },
];

const STANDARD_LINE_WARNING_THRESHOLD = 500;

function listFiles(directory) {
    const entries = readdirSync(directory);
    const files = [];

    for (const entry of entries) {
        const path = join(directory, entry);
        const relativePath = relative(root, path).replaceAll("\\", "/");

        if (
            relativePath === "docs/_archive" ||
            relativePath.startsWith("docs/_archive/")
        ) {
            continue;
        }

        if (statSync(path).isDirectory()) {
            files.push(...listFiles(path));
            continue;
        }

        files.push(path);
    }

    return files;
}

function lineNumberFor(content, index) {
    return content.slice(0, index).split(/\r?\n/).length;
}

function physicalLineCount(content) {
    if (content.length === 0) {
        return 0;
    }

    const lines = content.split(/\r?\n/);

    if (lines.at(-1) === "") {
        lines.pop();
    }

    return lines.length;
}

function docTypeFor(content) {
    const metadata = content.match(/<!--\s*\r?\nDOC-META\r?\n([\s\S]*?)-->/);

    if (metadata === null) {
        return null;
    }

    const docType = metadata[1].match(/^doc_type:\s*(.+?)\s*$/m);

    return docType?.[1] ?? null;
}

const docsFiles = listFiles(join(root, "docs"));
const files = [...docsFiles, join(root, "AGENTS.md")];

let failures = 0;
let warnings = 0;

for (const check of checks) {
    const matches = [];

    for (const file of files) {
        const content = readFileSync(file, "utf8");
        const pattern = new RegExp(check.pattern.source, check.pattern.flags);
        let match;

        while ((match = pattern.exec(content)) !== null) {
            const relativePath = relative(root, file).replaceAll("\\", "/");
            matches.push(
                `${relativePath}:${lineNumberFor(content, match.index)}:${match[0]}`,
            );
        }
    }

    if (matches.length > 0) {
        failures = 1;
        console.log(`[FAIL] ${check.label}`);
        console.log(matches.join("\n"));
    }
}

const oversizedStandards = [];

for (const file of docsFiles) {
    if (!file.endsWith(".md")) {
        continue;
    }

    const content = readFileSync(file, "utf8");

    if (docTypeFor(content) !== "standard") {
        continue;
    }

    const lineCount = physicalLineCount(content);

    if (lineCount <= STANDARD_LINE_WARNING_THRESHOLD) {
        continue;
    }

    const relativePath = relative(root, file).replaceAll("\\", "/");

    oversizedStandards.push(`${relativePath}: ${lineCount} lines`);
}

if (oversizedStandards.length > 0) {
    warnings += oversizedStandards.length;

    console.log(
        `[WARN] ${oversizedStandards.length} standard document(s) exceed ${STANDARD_LINE_WARNING_THRESHOLD} lines.`,
    );
    console.log(oversizedStandards.join("\n"));
    console.log(
        "Review these standards for unnecessary duplication or separable responsibilities.",
    );
}

if (failures !== 0) {
    console.log("Docs guardrail check failed.");
    process.exit(1);
}

if (warnings > 0) {
    console.log(`Docs guardrail check passed with ${warnings} warning(s).`);
} else {
    console.log("Docs guardrail check passed.");
}
