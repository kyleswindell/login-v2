/**
 * Review one explicit issue #31 material record at a time.
 */

import { readFileSync, writeFileSync } from "node:fs";
import { resolve } from "node:path";
import { spawnSync } from "node:child_process";

const CLASSIFICATIONS_PATH =
    "docs/07-planning/00-overview/evidence/m0-persistent-data-current-state-classifications.json";
const RAW_PATH =
    "docs/07-planning/00-overview/evidence/m0-persistent-data-current-state-raw.json";
const CANONICAL_KEY_PATTERN = /^[a-z][a-z0-9_]*$/;
const METADATA_FIELDS = new Set([
    "_record_id",
    "_reviewed",
    "_review_note",
    "_review_required",
    "_source_hashes",
    "_generated_fingerprint",
    "_generator_schema_version",
]);
const SCOPE_FIELDS = [
    "tenant_scope",
    "instance_scope",
    "principal_scope",
    "resource_scope",
    "actor_scope",
    "target_tenant_or_instance_scope",
];

const root = run("git", ["rev-parse", "--show-toplevel"]).trim();
process.chdir(root);
const classifications = JSON.parse(readFileSync(CLASSIFICATIONS_PATH, "utf8"));
const raw = JSON.parse(readFileSync(RAW_PATH, "utf8"));
const generatedById = new Map(
    raw.material_record_seeds.map((item) => [item._record_id, item]),
);
const args = process.argv.slice(2);

if (args.length === 0) usage();

if (args[0] === "--list-pending") {
    listRecords(
        (item) => item._reviewed !== true || item._review_required === true,
    );
} else if (args[0] === "--list-investigate") {
    listRecords((item) => item.disposition === "investigate");
} else if (args[0] === "--show") {
    const item = findRecord(args[1]);
    console.log(JSON.stringify(item, null, 2));
} else if (args[0] === "--set") {
    setField(args[1], args[2], args[3]);
} else if (args[0] === "--add-contradiction") {
    addContradiction(args[1], args[2], args[3], args[4]);
} else if (args[0] === "--mark-reviewed") {
    markReviewed(args[1]);
} else if (args[0] === "--summary") {
    summary();
} else {
    usage();
}

function usage() {
    throw new Error(
        "Usage: --list-pending | --list-investigate | --show <record> | --set <record> <field> <json-value> | --add-contradiction <record> <code> <explanation> <evidence-json> | --mark-reviewed <record> | --summary",
    );
}

function listRecords(predicate) {
    const items = classifications.items.filter(predicate);
    for (const item of items) {
        console.log(
            `${item._record_id}\t${item.storage_identifier}\t${item.implementation_state}\t${item.disposition}\t${item._reviewed ? "reviewed" : "pending"}${item._review_required ? ":required" : ""}`,
        );
    }
    console.log(`Count: ${items.length}`);
}

function findRecord(identifier) {
    if (!identifier) throw new Error("A record identifier is required.");
    const matches = classifications.items.filter(
        (item) =>
            item._record_id === identifier ||
            item.storage_identifier === identifier,
    );
    if (matches.length !== 1) {
        throw new Error(
            matches.length === 0
                ? `Record not found: ${identifier}`
                : `Identifier is ambiguous: ${identifier}`,
        );
    }
    return matches[0];
}

function setField(identifier, field, jsonValue) {
    const item = findRecord(identifier);
    if (
        !classifications.required_fields.includes(field) &&
        !METADATA_FIELDS.has(field)
    ) {
        throw new Error(`Field is not part of the issue schema: ${field}`);
    }
    if (
        [
            "_record_id",
            "_source_hashes",
            "_generated_fingerprint",
            "_generator_schema_version",
        ].includes(field)
    ) {
        throw new Error(`${field} cannot be changed by the review helper.`);
    }
    let value;
    try {
        value = JSON.parse(jsonValue);
    } catch (error) {
        throw new Error(`Invalid JSON value: ${error.message}`);
    }
    const previous = item[field];
    item[field] = value;
    const failures = validateRecord(item, false);
    if (failures.length > 0) {
        item[field] = previous;
        throw new Error(`Invalid update: ${failures.join("; ")}`);
    }
    if (!field.startsWith("_")) {
        item._reviewed = false;
        item._review_required = true;
        item._review_note = `Reviewed field ${field} changed explicitly; record requires final review.`;
    }
    writeClassifications();
    console.log(`Updated ${item._record_id}.${field}.`);
}

function addContradiction(identifier, code, explanation, evidenceJson) {
    const item = findRecord(identifier);
    if (!classifications.controlled_values.contradiction_code.includes(code)) {
        throw new Error(`Invalid contradiction code: ${code}`);
    }
    let evidence;
    try {
        evidence = JSON.parse(evidenceJson);
    } catch (error) {
        throw new Error(`Invalid evidence JSON: ${error.message}`);
    }
    const evidenceFailures = validateEvidenceReference(
        evidence,
        "contradiction evidence",
    );
    if (evidenceFailures.length > 0)
        throw new Error(evidenceFailures.join("; "));
    if (item.known_contradictions.some((entry) => entry.code === code)) {
        throw new Error(
            `${item._record_id} already has contradiction code ${code}.`,
        );
    }
    item.known_contradictions.push({ code, explanation, evidence });
    item._reviewed = false;
    item._review_required = true;
    item._review_note = `Contradiction ${code} added explicitly; record requires final review.`;
    writeClassifications();
    console.log(`Added ${code} to ${item._record_id}.`);
}

function markReviewed(identifier) {
    const item = findRecord(identifier);
    const generated = generatedById.get(item._record_id);
    if (
        !generated ||
        generated._generated_fingerprint !== item._generated_fingerprint
    ) {
        throw new Error(
            `Cannot mark ${item._record_id} reviewed: generated fingerprint is stale.`,
        );
    }
    const failures = validateRecord(item, true);
    if (failures.length > 0) {
        throw new Error(
            `Cannot mark ${item._record_id} reviewed: ${failures.join("; ")}`,
        );
    }
    item._reviewed = true;
    item._review_required = false;
    item._review_note =
        "Reviewed against direct migration, source, contract, configuration, or planning evidence for issue #31.";
    writeClassifications();
    console.log(`Marked ${item._record_id} reviewed.`);
}

function validateRecord(item, finalReview) {
    const failures = [];
    for (const field of classifications.required_fields) {
        if (!(field in item)) failures.push(`missing ${field}`);
    }
    if (!item._record_id || !item.storage_identifier)
        failures.push("missing stable identity");
    for (const field of ["owner_key", "capability_key", "module_key"]) {
        if (!CANONICAL_KEY_PATTERN.test(String(item[field] ?? "")))
            failures.push(`invalid canonical ${field}`);
    }
    if (
        typeof item._generated_fingerprint !== "string" ||
        item._generated_fingerprint.length !== 64
    )
        failures.push("missing generated fingerprint");
    for (const [field, values] of [
        [
            "implementation_state",
            classifications.controlled_values.implementation_state,
        ],
        ["ownership_area", classifications.controlled_values.ownership_area],
        ["disposition", classifications.controlled_values.disposition],
    ]) {
        if (!values.includes(item[field])) failures.push(`invalid ${field}`);
    }
    for (const field of SCOPE_FIELDS) {
        const value = item[field];
        if (!value || typeof value !== "object")
            failures.push(`${field} must be an object`);
        else {
            if (
                !classifications.controlled_values.scope_state.includes(
                    value.state,
                )
            ) {
                failures.push(`invalid ${field}.state`);
            }
            if (!Array.isArray(value.evidence))
                failures.push(`${field}.evidence must be an array`);
            else
                validateEvidenceList(
                    value.evidence,
                    `${field}.evidence`,
                    failures,
                );
        }
    }
    for (const field of [
        "migration_or_planning_source",
        "key_and_relationship_evidence",
        "uniqueness_and_index_evidence",
        "lifecycle_and_deletion_evidence",
        "classification_evidence",
        "retention_and_erasure_evidence",
        "audit_evidence",
        "compatibility_evidence",
    ]) {
        if (!Array.isArray(item[field]))
            failures.push(`${field} must be an array`);
        else validateEvidenceList(item[field], field, failures);
    }
    if (!Array.isArray(item.known_contradictions)) {
        failures.push("known_contradictions must be an array");
    } else {
        for (const entry of item.known_contradictions) {
            if (
                !classifications.controlled_values.contradiction_code.includes(
                    entry.code,
                )
            ) {
                failures.push(`invalid contradiction ${entry.code}`);
            }
            if (
                typeof entry.explanation !== "string" ||
                entry.explanation.trim() === ""
            ) {
                failures.push(`contradiction ${entry.code} lacks explanation`);
            }
            failures.push(
                ...validateEvidenceReference(
                    entry.evidence,
                    `contradiction ${entry.code}`,
                ),
            );
        }
    }
    if (!(
        Array.isArray(item.contract_path) ||
        ["missing", "not_applicable"].includes(item.contract_path)
    )) {
        failures.push("invalid contract_path");
    }
    if (finalReview) {
        if (!item.migration_or_planning_source.length)
            failures.push("no direct source evidence");
        if (
            typeof item.target_question !== "string" ||
            item.target_question.trim() === ""
        ) {
            failures.push("target_question is empty");
        }
        if (typeof item.owner_key !== "string" || item.owner_key.trim() === "")
            failures.push("owner_key is empty");
        if (
            typeof item.capability_key !== "string" ||
            item.capability_key.trim() === ""
        )
            failures.push("capability_key is empty");
        if (
            typeof item.module_key !== "string" ||
            item.module_key.trim() === ""
        )
            failures.push("module_key is empty");
    }
    return failures;
}

function validateEvidenceList(values, label, failures) {
    for (const value of values)
        failures.push(...validateEvidenceReference(value, label));
}

function validateEvidenceReference(value, label) {
    const failures = [];
    if (!value || typeof value !== "object")
        return [`${label} contains non-object evidence`];
    for (const field of ["evidence_type", "path", "claim", "source_sha256"]) {
        if (typeof value[field] !== "string" || value[field].trim() === "") {
            failures.push(`${label} evidence missing ${field}`);
        }
    }
    if (!Number.isInteger(value.line_start) || value.line_start < 1)
        failures.push(`${label} evidence has invalid line_start`);
    if (!Number.isInteger(value.line_end) || value.line_end < value.line_start)
        failures.push(`${label} evidence has invalid line_end`);
    return failures;
}

function summary() {
    const items = classifications.items;
    const reviewed = items.filter((item) => item._reviewed === true).length;
    const pending = items.filter(
        (item) => item._reviewed !== true || item._review_required === true,
    ).length;
    const contradictions = items.filter(
        (item) => item.known_contradictions.length > 0,
    ).length;
    const investigate = items.filter(
        (item) => item.disposition === "investigate",
    ).length;
    const missingContracts = items.filter(
        (item) => item.contract_path === "missing",
    ).length;
    console.log(`Baseline: ${classifications.baseline.sha}`);
    console.log(`Records: ${items.length}`);
    console.log(`Reviewed: ${reviewed}`);
    console.log(`Pending: ${pending}`);
    console.log(`Contradiction-bearing: ${contradictions}`);
    console.log(`Investigate: ${investigate}`);
    console.log(`Missing contracts: ${missingContracts}`);
    console.log(
        `Orphaned reviewed records: ${classifications.orphaned_reviewed_records?.length ?? 0}`,
    );
}

function writeClassifications() {
    writeFileSync(
        resolve(CLASSIFICATIONS_PATH),
        `${JSON.stringify(classifications, null, 2)}\n`,
        "utf8",
    );
}

function run(command, args) {
    const result = spawnSync(command, args, {
        encoding: "utf8",
        windowsHide: true,
    });
    if (result.error) throw result.error;
    if (result.status !== 0) throw new Error(result.stderr.trim());
    return result.stdout;
}
