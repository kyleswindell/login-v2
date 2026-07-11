/**
 * Validate deterministic issue #31 persistence evidence, review, rendering, and fixtures.
 */

import { createHash } from "node:crypto";
import { existsSync, readFileSync } from "node:fs";
import { basename, resolve } from "node:path";
import { spawnSync } from "node:child_process";

const DEFAULT_BASELINE = "1d103f5fa47aab8c8adfba8ea134dd29540426fe";
const DOCUMENT_PATH =
    "docs/07-planning/00-overview/m0-persistent-data-current-state-inventory.md";
const LEDGER_PATH =
    "docs/07-planning/00-overview/evidence/m0-persistent-data-migration-ledger.json";
const RAW_PATH =
    "docs/07-planning/00-overview/evidence/m0-persistent-data-current-state-raw.json";
const CLASSIFICATIONS_PATH =
    "docs/07-planning/00-overview/evidence/m0-persistent-data-current-state-classifications.json";
const ISSUE_29_RAW =
    "docs/07-planning/00-overview/evidence/m0-repository-current-state-raw.json";
const GENERATOR_PATH =
    "scripts/generate-m0-persistent-data-current-state-inventory.mjs";
const FIXTURE_ROOT =
    "scripts/fixtures/m0-persistent-data-current-state-inventory";
const REQUIRED_OPERATION_FIELDS = [
    "sequence",
    "operation_type",
    "storage_identifier",
    "identifier_expression",
    "source_location",
    "columns",
    "primary_keys",
    "indexes",
    "unique_constraints",
    "foreign_keys",
    "deletion_behavior",
    "destructive_behavior",
    "raw_expression_summary",
];
const SCOPE_FIELDS = [
    "tenant_scope",
    "instance_scope",
    "principal_scope",
    "resource_scope",
    "actor_scope",
    "target_tenant_or_instance_scope",
];
const EVIDENCE_FIELDS = [
    "migration_or_planning_source",
    "key_and_relationship_evidence",
    "uniqueness_and_index_evidence",
    "lifecycle_and_deletion_evidence",
    "classification_evidence",
    "retention_and_erasure_evidence",
    "audit_evidence",
    "compatibility_evidence",
];

const args = parseArguments(process.argv.slice(2));
const root = run("git", ["rev-parse", "--show-toplevel"]).stdout.trim();
process.chdir(root);
const baseline = args.baseline ?? DEFAULT_BASELINE;
const failures = [];

for (const path of [
    DOCUMENT_PATH,
    LEDGER_PATH,
    RAW_PATH,
    CLASSIFICATIONS_PATH,
]) {
    if (!existsSync(path)) failures.push(`Missing artifact: ${path}`);
}
if (failures.length > 0) finish();

const document = readFileSync(DOCUMENT_PATH, "utf8");
const ledger = readJson(LEDGER_PATH);
const raw = readJson(RAW_PATH);
const classifications = readJson(CLASSIFICATIONS_PATH);
const issue29 = readJson(ISSUE_29_RAW);
const tree = readTree(baseline);
const treePaths = new Set(tree.map((entry) => entry.path));
const treeByPath = new Map(tree.map((entry) => [entry.path, entry]));

validateBaselines();
validateLedger();
validateMaterialRecords();
validateRendering();
validateRuntimePreservation();
validateSecurityBoundaries();

if (args.fixtures) validateFixtures();

finish();

function parseArguments(values) {
    const parsed = { baseline: null, fixtures: false };
    for (let index = 0; index < values.length; index += 1) {
        if (values[index] === "--baseline") parsed.baseline = values[++index];
        else if (values[index] === "--fixtures") parsed.fixtures = true;
        else throw new Error(`Unknown argument: ${values[index]}`);
    }
    return parsed;
}

function validateBaselines() {
    for (const [name, value] of [
        ["ledger", ledger.baseline?.sha],
        ["raw evidence", raw.baseline?.sha],
        ["classifications", classifications.baseline?.sha],
        ["issue #29 evidence", issue29.baseline?.sha],
    ]) {
        if (value !== baseline)
            failures.push(
                `${name} baseline is ${value ?? "missing"}; expected ${baseline}.`,
            );
    }
    if (!document.includes(baseline))
        failures.push("Canonical document does not show the pinned baseline.");
    const metadata = [ledger.baseline, raw.baseline, classifications.baseline];
    for (const key of [
        "sha",
        "committed_at",
        "ref",
        "current_head_at_generation",
        "accepted_main_at_package_preparation",
    ]) {
        const values = new Set(metadata.map((item) => item?.[key]));
        if (values.size !== 1)
            failures.push(`Baseline metadata differs for ${key}.`);
    }
}

function validateLedger() {
    const expectedMigrations = tree
        .filter((entry) => /(^|\/)migrations\/.*\.php$/i.test(entry.path))
        .map((entry) => entry.path)
        .sort((left, right) => {
            const byName = basename(left).localeCompare(basename(right));
            return byName || left.localeCompare(right);
        });
    const actualMigrations = ledger.migrations.map(
        (migration) => migration.migration_path,
    );
    compareLists(
        expectedMigrations,
        actualMigrations,
        "migration ledger coverage/order",
    );
    for (const duplicate of duplicates(actualMigrations))
        failures.push(`Duplicate migration ledger record: ${duplicate}`);
    const expectedRoots = new Set([
        "database/migrations",
        "Modules/Account/database/migrations",
        "Modules/Auth/database/migrations",
        "Modules/Dashboard/database/migrations",
        "Modules/Notifications/database/migrations",
        "Modules/Preferences/database/migrations",
        "Modules/Roles/database/migrations",
        "Modules/Settings/database/migrations",
        "Modules/Setup/database/migrations",
    ]);
    const actualRoots = new Set(
        ledger.migration_roots.map((root) => root.registered_root),
    );
    for (const root of expectedRoots)
        if (!actualRoots.has(root))
            failures.push(`Unrepresented registered migration root: ${root}`);
    for (const root of ledger.migration_roots) {
        if (
            !classifications.controlled_values.registration_state.includes(
                root.registration_state,
            )
        ) {
            failures.push(
                `Invalid root registration state: ${root.registered_root}`,
            );
        }
    }
    for (const migration of ledger.migrations) {
        for (const field of [
            "migration_path",
            "migration_name",
            "source_blob_oid",
            "source_sha256",
            "registered_root",
            "registration_state",
            "registration_evidence",
            "up_operations",
            "down_operations",
            "parse_status",
            "parse_notes",
        ]) {
            if (!(field in migration))
                failures.push(`${migration.migration_path} missing ${field}.`);
        }
        if (
            !classifications.controlled_values.registration_state.includes(
                migration.registration_state,
            )
        ) {
            failures.push(
                `${migration.migration_path} has invalid registration_state.`,
            );
        }
        if (
            !classifications.controlled_values.parse_status.includes(
                migration.parse_status,
            )
        ) {
            failures.push(
                `${migration.migration_path} has invalid parse_status.`,
            );
        }
        if (
            !Array.isArray(migration.up_operations) ||
            migration.up_operations.length === 0
        ) {
            failures.push(
                `${migration.migration_path} has no represented up operation.`,
            );
        }
        if (
            !Array.isArray(migration.down_operations) ||
            migration.down_operations.length === 0
        ) {
            failures.push(
                `${migration.migration_path} has no represented down operation.`,
            );
        }
        for (const operation of [
            ...(migration.up_operations ?? []),
            ...(migration.down_operations ?? []),
        ]) {
            for (const field of REQUIRED_OPERATION_FIELDS) {
                if (!(field in operation))
                    failures.push(
                        `${migration.migration_path} operation missing ${field}.`,
                    );
            }
            if (
                !operation.storage_identifier &&
                migration.parse_status === "complete"
            ) {
                failures.push(
                    `${migration.migration_path} omits an unresolved identifier without a partial/dynamic status.`,
                );
            }
            if (
                operation.unsupported_statements?.length > 0 &&
                migration.parse_status === "complete"
            ) {
                failures.push(
                    `${migration.migration_path} omits unsupported-operation status.`,
                );
            }
        }
        const entry = treeByPath.get(migration.migration_path);
        if (!entry) continue;
        if (entry.oid !== migration.source_blob_oid)
            failures.push(`${migration.migration_path} blob OID mismatch.`);
    }
    const migrationHashes = readBaselineHashes(
        ledger.migrations.map((migration) => migration.migration_path),
    );
    for (const migration of ledger.migrations) {
        if (
            migrationHashes.get(migration.migration_path) !==
            migration.source_sha256
        ) {
            failures.push(
                `${migration.migration_path} source SHA-256 mismatch.`,
            );
        }
    }
    const duplicateNames = duplicates(
        ledger.migrations.map((migration) => migration.migration_name),
    );
    compareLists(
        [...duplicateNames].sort(),
        [...(ledger.summary.duplicate_migration_names ?? [])].sort(),
        "duplicate migration-name summary",
    );
    const summaryUp = ledger.migrations.reduce(
        (sum, migration) => sum + migration.up_operations.length,
        0,
    );
    const summaryDown = ledger.migrations.reduce(
        (sum, migration) => sum + migration.down_operations.length,
        0,
    );
    if (summaryUp !== ledger.summary.up_operation_count)
        failures.push("Up-operation summary mismatch.");
    if (summaryDown !== ledger.summary.down_operation_count)
        failures.push("Down-operation summary mismatch.");
}

function validateMaterialRecords() {
    if (!Array.isArray(classifications.required_fields))
        failures.push("Missing required_fields schema.");
    if (!Array.isArray(classifications.items))
        failures.push("Missing classification items.");
    const storageIdentifiers = classifications.items.map(
        (item) => item.storage_identifier,
    );
    for (const duplicate of duplicates(storageIdentifiers))
        failures.push(`Duplicate storage identifier: ${duplicate}`);
    const recordIds = classifications.items.map((item) => item._record_id);
    for (const duplicate of duplicates(recordIds))
        failures.push(`Duplicate record id: ${duplicate}`);
    if ((classifications.orphaned_reviewed_records ?? []).length > 0)
        failures.push("Orphaned reviewed records require explicit treatment.");
    if (raw.material_record_seeds.length !== classifications.items.length)
        failures.push(
            "Generated and reviewed material-record counts disagree.",
        );
    const seedIds = new Set(
        raw.material_record_seeds.map((item) => item._record_id),
    );
    for (const recordId of recordIds)
        if (!seedIds.has(recordId))
            failures.push(`Stale reviewed record: ${recordId}`);

    const createdTables = new Set(
        ledger.migrations.flatMap((migration) =>
            migration.up_operations
                .filter(
                    (operation) =>
                        operation.operation_type === "create_table" &&
                        operation.storage_identifier,
                )
                .map((operation) => operation.storage_identifier),
        ),
    );
    const tableRecords = classifications.items.filter(
        (item) =>
            !item.storage_identifier.startsWith("concept.") &&
            !item.storage_identifier.startsWith("boundary."),
    );
    const tableIdentifiers = new Set(
        tableRecords.map((item) => item.storage_identifier),
    );
    for (const table of createdTables)
        if (!tableIdentifiers.has(table))
            failures.push(`Missing material table record: ${table}`);
    for (const item of tableRecords) {
        if (!createdTables.has(item.storage_identifier))
            failures.push(
                `Material table record lacks a create operation: ${item.storage_identifier}`,
            );
        const expectedChain = ledger.migrations
            .filter((migration) =>
                [...migration.up_operations, ...migration.down_operations].some(
                    (operation) =>
                        operation.storage_identifier ===
                        item.storage_identifier,
                ),
            )
            .map((migration) => migration.migration_path)
            .sort();
        const actualChain = item.migration_or_planning_source
            .filter((source) => source.evidence_type === "migration")
            .map((source) => source.path)
            .sort();
        compareLists(
            expectedChain,
            actualChain,
            `${item.storage_identifier} migration chain`,
        );
    }

    const evidencePaths = new Set();
    for (const item of classifications.items) {
        for (const path of Object.keys(item._source_hashes ?? {}))
            evidencePaths.add(path);
        for (const field of classifications.required_fields) {
            if (!(field in item))
                failures.push(
                    `${item._record_id} missing required field ${field}.`,
                );
        }
        for (const [field, values] of [
            [
                "implementation_state",
                classifications.controlled_values.implementation_state,
            ],
            [
                "ownership_area",
                classifications.controlled_values.ownership_area,
            ],
            ["disposition", classifications.controlled_values.disposition],
        ]) {
            if (!values.includes(item[field]))
                failures.push(`${item._record_id} has invalid ${field}.`);
        }
        for (const field of SCOPE_FIELDS) {
            const value = item[field];
            if (
                !value ||
                !classifications.controlled_values.scope_state.includes(
                    value.state,
                )
            ) {
                failures.push(`${item._record_id} has invalid ${field}.`);
            }
            collectEvidence(
                value?.evidence,
                item,
                `${field}.evidence`,
                evidencePaths,
            );
        }
        for (const field of EVIDENCE_FIELDS)
            collectEvidence(item[field], item, field, evidencePaths);
        if (!Array.isArray(item.known_contradictions)) {
            failures.push(
                `${item._record_id} known_contradictions is not an array.`,
            );
        } else {
            for (const contradiction of item.known_contradictions) {
                if (
                    !classifications.controlled_values.contradiction_code.includes(
                        contradiction.code,
                    )
                ) {
                    failures.push(
                        `${item._record_id} has invalid contradiction ${contradiction.code}.`,
                    );
                }
                collectEvidence(
                    [contradiction.evidence],
                    item,
                    `contradiction ${contradiction.code}`,
                    evidencePaths,
                );
            }
        }
        if (Array.isArray(item.contract_path)) {
            for (const path of item.contract_path) {
                if (!treePaths.has(path))
                    failures.push(
                        `${item._record_id} has invalid contract path ${path}.`,
                    );
            }
        } else if (
            !["missing", "not_applicable"].includes(item.contract_path)
        ) {
            failures.push(`${item._record_id} has invalid contract_path.`);
        }
        if (item._reviewed !== true)
            failures.push(`${item._record_id} is not reviewed.`);
        if (item._review_required === true)
            failures.push(`${item._record_id} still requires review.`);
    }

    const hashes = readBaselineHashes([...evidencePaths]);
    for (const item of classifications.items) {
        const refs = allEvidence(item);
        for (const ref of refs) {
            if (hashes.get(ref.path) !== ref.source_sha256) {
                failures.push(
                    `${item._record_id} source-hash mismatch for ${ref.path}.`,
                );
            }
        }
        for (const [path, hash] of Object.entries(item._source_hashes ?? {})) {
            if (hashes.get(path) !== hash)
                failures.push(
                    `${item._record_id} _source_hashes mismatch for ${path}.`,
                );
        }
    }
}

function collectEvidence(values, item, label, paths) {
    if (!Array.isArray(values)) {
        failures.push(`${item._record_id} ${label} is not an array.`);
        return;
    }
    for (const ref of values) {
        if (!ref || typeof ref !== "object") {
            failures.push(`${item._record_id} ${label} has invalid evidence.`);
            continue;
        }
        for (const field of [
            "evidence_type",
            "path",
            "claim",
            "source_sha256",
        ]) {
            if (typeof ref[field] !== "string" || ref[field].trim() === "") {
                failures.push(
                    `${item._record_id} ${label} evidence missing ${field}.`,
                );
            }
        }
        if (!Number.isInteger(ref.line_start) || ref.line_start < 1)
            failures.push(
                `${item._record_id} ${label} has invalid line_start.`,
            );
        if (!Number.isInteger(ref.line_end) || ref.line_end < ref.line_start)
            failures.push(`${item._record_id} ${label} has invalid line_end.`);
        if (!treePaths.has(ref.path))
            failures.push(
                `${item._record_id} references invalid baseline source path ${ref.path}.`,
            );
        else paths.add(ref.path);
    }
}

function allEvidence(item) {
    const refs = [];
    for (const field of EVIDENCE_FIELDS) refs.push(...(item[field] ?? []));
    for (const field of SCOPE_FIELDS)
        refs.push(...(item[field]?.evidence ?? []));
    for (const contradiction of item.known_contradictions ?? [])
        if (contradiction.evidence) refs.push(contradiction.evidence);
    return refs;
}

function validateRendering() {
    const markers = [
        "BASELINE",
        "SCOPE",
        "METHOD",
        "SCHEMA",
        "SUMMARY",
        "MIGRATIONS",
        "IMPLEMENTED",
        "PLANNED",
        "BOUNDARIES",
        "CONTRACTS",
        "SCOPE-FINDINGS",
        "GOVERNANCE",
        "CONTRADICTIONS",
        "TARGET-QUESTIONS",
        "VERIFICATION",
    ];
    for (const marker of markers) {
        const start = `<!-- PERSISTENT-DATA-INVENTORY:${marker}:START -->`;
        const end = `<!-- PERSISTENT-DATA-INVENTORY:${marker}:END -->`;
        if (
            document.split(start).length !== 2 ||
            document.split(end).length !== 2
        ) {
            failures.push(`Render marker missing or duplicated: ${marker}`);
        }
    }
    if (document.includes("Package scaffold"))
        failures.push(
            "Package scaffold text remains in the canonical document.",
        );
    for (const item of classifications.items) {
        if (!document.includes(`\`${item.storage_identifier}\``))
            failures.push(
                `Canonical document omits ${item.storage_identifier}.`,
            );
    }
}

function validateRuntimePreservation() {
    if (raw.runtime_discovery?.mode === "skipped")
        failures.push(
            "Runtime discovery evidence was replaced with skipped state.",
        );
    for (const command of raw.runtime_discovery?.commands ?? []) {
        for (const field of [
            "command",
            "attempted",
            "exit_code",
            "timed_out",
            "stdout_summary",
            "stderr_summary",
            "failure_reason",
        ]) {
            if (!(field in command))
                failures.push(`Runtime command missing ${field}.`);
        }
    }
}

function validateSecurityBoundaries() {
    const serialized = `${readFileSync(LEDGER_PATH, "utf8")}\n${readFileSync(RAW_PATH, "utf8")}\n${readFileSync(CLASSIFICATIONS_PATH, "utf8")}\n${document}`;
    const forbidden = [
        /-----BEGIN (?:RSA |EC |OPENSSH )?PRIVATE KEY-----/,
        /\bAKIA[0-9A-Z]{16}\b/,
        /\b(?:ghp|github_pat)_[A-Za-z0-9_]{20,}\b/,
        /\bDB_PASSWORD\s*=\s*[^\s$][^\s]*/i,
        /\bAWS_SECRET_ACCESS_KEY\s*=\s*[^\s$][^\s]*/i,
        /"(?:password|secret|access_token|refresh_token|private_key|recovery_code)"\s*:\s*"(?!\[redacted|unknown|not_applicable)[^"]{4,}"/i,
    ];
    for (const pattern of forbidden)
        if (pattern.test(serialized))
            failures.push(`Secret-like value detected by ${pattern}.`);
}

function validateFixtures() {
    const catalog = readJson(`${FIXTURE_ROOT}/cases.json`);
    const expectedFamilies = [
        "multiple-migrations-one-table",
        "create-alter-drop-chain",
        "dynamic-table-identifiers",
        "compound-indexes-and-unique-constraints",
        "foreign-keys-and-delete-behavior",
        "material-pivot-table",
        "duplicate-migration-names",
        "present-unregistered-migration-root",
        "unsupported-migration-operation",
        "planned-implemented-overlap",
        "reviewed-field-preservation",
        "runtime-discovery-failure-preservation",
        "same-basename-different-paths",
        "windows-and-posix-path-normalization",
    ];
    compareLists(
        expectedFamilies,
        catalog.fixtures.map((fixture) => fixture.id),
        "fixture catalog",
    );
    const result = spawnSync(
        process.execPath,
        [GENERATOR_PATH, "--fixture-root", resolve(FIXTURE_ROOT)],
        {
            cwd: process.cwd(),
            encoding: "utf8",
            windowsHide: true,
            timeout: 30_000,
        },
    );
    if (result.error || result.status !== 0) {
        failures.push(
            `Fixture execution failed: ${result.error?.message ?? result.stderr.trim()}`,
        );
    } else if (!result.stdout.includes("Fixture families passed: 14/14")) {
        failures.push(
            `Fixture execution returned an unexpected summary: ${result.stdout.trim()}`,
        );
    }
}

function readTree(commit) {
    const output = run("git", ["ls-tree", "-r", "-z", "--long", commit], {
        encoding: "buffer",
    }).stdout;
    return output
        .toString("utf8")
        .split("\0")
        .filter(Boolean)
        .map((line) => {
            const match = line.match(
                /^(\d+)\s+(\w+)\s+([0-9a-f]+)\s+(\d+)\t(.+)$/,
            );
            if (!match)
                throw new Error(`Unable to parse ls-tree record: ${line}`);
            return {
                oid: match[3],
                size: Number(match[4]),
                path: normalizePath(match[5]),
            };
        });
}

function readBaselineHashes(paths) {
    const unique = [...new Set(paths)].sort();
    const entries = unique.map((path) => treeByPath.get(path)).filter(Boolean);
    if (entries.length === 0) return new Map();
    const output = run("git", ["cat-file", "--batch"], {
        encoding: "buffer",
        input: `${entries.map((entry) => entry.oid).join("\n")}\n`,
        maxBuffer: 128 * 1024 * 1024,
    }).stdout;
    const hashes = new Map();
    let offset = 0;
    for (const entry of entries) {
        const headerEnd = output.indexOf(10, offset);
        const header = output.subarray(offset, headerEnd).toString("utf8");
        const size = Number(/\s(\d+)$/.exec(header)?.[1]);
        const start = headerEnd + 1;
        const content = output.subarray(start, start + size);
        hashes.set(
            entry.path,
            createHash("sha256").update(content).digest("hex"),
        );
        offset = start + size + 1;
    }
    return hashes;
}

function compareLists(expected, actual, label) {
    if (JSON.stringify(expected) !== JSON.stringify(actual)) {
        failures.push(
            `${label} mismatch. Expected ${JSON.stringify(expected)}, received ${JSON.stringify(actual)}.`,
        );
    }
}

function duplicates(values) {
    const counts = new Map();
    for (const value of values) counts.set(value, (counts.get(value) ?? 0) + 1);
    return [...counts.entries()]
        .filter(([, count]) => count > 1)
        .map(([value]) => value);
}

function readJson(path) {
    try {
        return JSON.parse(readFileSync(path, "utf8"));
    } catch (error) {
        failures.push(`Malformed JSON ${path}: ${error.message}`);
        return {};
    }
}

function normalizePath(value) {
    return String(value).replaceAll("\\", "/");
}

function run(command, commandArgs, options = {}) {
    const result = spawnSync(command, commandArgs, {
        cwd: process.cwd(),
        encoding:
            options.encoding === "buffer"
                ? undefined
                : (options.encoding ?? "utf8"),
        input: options.input,
        windowsHide: true,
        maxBuffer: options.maxBuffer ?? 32 * 1024 * 1024,
    });
    if (result.error) throw result.error;
    if (result.status !== 0)
        throw new Error(
            `${command} ${commandArgs.join(" ")} failed: ${String(result.stderr).trim()}`,
        );
    return result;
}

function finish() {
    if (failures.length > 0) {
        console.error(
            `Persistent-data inventory validation failed with ${failures.length} issue(s):`,
        );
        for (const failure of failures) console.error(`- ${failure}`);
        process.exit(1);
    }
    console.log(
        `Persistent-data inventory validation passed for baseline ${baseline}.`,
    );
    console.log(`Migration roots: ${ledger.summary.migration_root_count}`);
    console.log(`Migrations: ${ledger.summary.migration_count}`);
    console.log(
        `Operations: ${ledger.summary.up_operation_count} up / ${ledger.summary.down_operation_count} down`,
    );
    console.log(`Material records: ${classifications.items.length}`);
    console.log(
        `Reviewed records: ${classifications.items.filter((item) => item._reviewed).length}`,
    );
    if (args.fixtures) console.log("Fixture families: 14/14");
}
