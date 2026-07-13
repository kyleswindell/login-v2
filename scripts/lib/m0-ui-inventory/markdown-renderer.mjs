/**
 * ============================================================================
 * File: scripts/lib/m0-ui-inventory/markdown-renderer.mjs
 * Purpose: Render the canonical issue #30 document from reviewed artifacts only.
 * ============================================================================
 */

import { summarizeValues, uniqueSorted } from "./utilities.mjs";

export function renderInventoryMarkdown({
    observations,
    classifications,
    testTraces,
}) {
    const items = classifications.items;
    const traces = testTraces.test_traces;
    const standards = classifications.standard_reviews ?? [];
    const mismatched = items.filter(
        (item) =>
            Array.isArray(item.known_mismatches) &&
            item.known_mismatches.length > 0 &&
            !(
                item.known_mismatches.length === 1 &&
                item.known_mismatches[0] === "aligned"
            ),
    );
    const pendingSurfaces = items.filter(
        (item) => item._reviewed !== true || item._review_required === true,
    );
    const pendingTraces = traces.filter(
        (trace) => trace._reviewed !== true || trace._review_required === true,
    );
    const pendingStandards = standards.filter(
        (standard) =>
            standard._reviewed !== true || standard._review_required === true,
    );
    const sourceDiff = observations.baseline.ui_source_diff;
    const lines = [];

    lines.push("<!--");
    lines.push("DOC-META");
    lines.push("title: M0 UI Current-State Inventory");
    lines.push("doc_type: planning");
    lines.push("status: active");
    lines.push("owner: ui");
    lines.push("canonical: true");
    lines.push(
        "canonical_path: docs/07-planning/00-overview/m0-ui-current-state-inventory.md",
    );
    lines.push("parent: docs/07-planning/index.md");
    lines.push(
        "summary: Provides the pinned issue #30 inventory of material UI implementation surfaces, contracts, tests, standards, metadata, registration, provenance, contradictions, and target questions.",
    );
    lines.push("-->");
    lines.push("");
    lines.push("# M0 UI Current-State Inventory");
    lines.push("");
    lines.push("Parent: [Planning Index](../index.md)");
    lines.push("");
    lines.push("## 1. Purpose");
    lines.push("");
    lines.push(
        "Provide the authoritative implementation-first current-state UI inventory required by GitHub issue #30 and M0 Goal 02.",
    );
    lines.push("");
    lines.push(
        "This inventory records what exists at the pinned baseline and whether contract, test, standard, reference, registration, provenance, review, and metadata claims agree with implementation. It does not redesign UI, approve reuse readiness, rewrite contracts or standards, create missing tests, or select target paths.",
    );
    lines.push("");
    lines.push("## 2. Status And Baseline");
    lines.push("");
    lines.push(`- Inventory baseline commit: \`${observations.baseline.sha}\``);
    lines.push(
        `- Inventory baseline date: ${observations.baseline.committed_at}`,
    );
    lines.push(
        `- Inventory generated at: ${observations.generator.generated_at}`,
    );
    lines.push(
        `- Current branch HEAD at collection: \`${observations.baseline.current_head_at_collection}\``,
    );
    lines.push(
        `- Expected execution base when the package was prepared: \`${observations.baseline.expected_execution_base}\``,
    );
    lines.push(
        `- UI source changed between inventory baseline and expected execution base: ${sourceDiff.changed ? "yes" : "no"}`,
    );
    lines.push(`- UI-source comparison command: \`${sourceDiff.command}\``);
    lines.push(`- Material surface records: ${items.length}`);
    lines.push(
        `- Reviewed material surfaces: ${items.length - pendingSurfaces.length}/${items.length}`,
    );
    lines.push(`- Detailed UI test traces: ${traces.length}`);
    lines.push(
        `- Reviewed test traces: ${traces.length - pendingTraces.length}/${traces.length}`,
    );
    lines.push(
        `- Reviewed unique standards: ${standards.length - pendingStandards.length}/${standards.length}`,
    );
    lines.push(
        `- Surfaces with material mismatch evidence: ${mismatched.length}`,
    );
    lines.push("");
    lines.push(
        "The inventory baseline is immutable for issue #30. The execution-base commit is only the accepted `main` from which the issue branch was created.",
    );
    lines.push("");
    lines.push("## 3. Evidence Method");
    lines.push("");
    lines.push(
        "1. Read only the configured UI-specific Git roots at the pinned baseline.",
    );
    lines.push(
        "2. Read Git blobs through one batched object stream rather than one subprocess per file.",
    );
    lines.push(
        "3. Group files into material UI surfaces, component families, URL views, contributions, and independently governed controls.",
    );
    lines.push(
        "4. Keep generated observations separate from reviewed classifications and detailed test traces.",
    );
    lines.push(
        "5. Preserve reviewed values when observations are recollected and mark changed evidence for re-review.",
    );
    lines.push(
        "6. Preserve failed or unavailable runtime-discovery evidence instead of replacing it with `skipped`.",
    );
    lines.push(
        "7. Render this document only from persisted evidence artifacts without rescanning source.",
    );
    lines.push("");
    lines.push(
        "Implementation evidence is reviewed before contracts, tests, standards, references, examples, and rendered evidence. A file existing does not prove registration or reachability.",
    );
    lines.push("");
    lines.push("## 4. Evidence Artifacts");
    lines.push("");
    lines.push(
        "- `docs/07-planning/00-overview/evidence/m0-ui-current-state-observations.json` — deterministic generated observations.",
    );
    lines.push(
        "- `docs/07-planning/00-overview/evidence/m0-ui-current-state-classifications.json` — reviewed material-surface classifications.",
    );
    lines.push(
        "- `docs/07-planning/00-overview/evidence/m0-ui-current-state-test-traces.json` — reviewed UI surface-to-test traces; issue #32 retains complete suite ownership.",
    );
    lines.push("");
    lines.push(
        "The JSON classifications contain every required issue field. The compact tables below are deterministic projections for review.",
    );
    lines.push("");
    lines.push("## 5. Summary");
    lines.push("");
    lines.push("### Surface Types");
    lines.push("");
    lines.push(
        renderCountTable(summarizeValues(items, (item) => item.surface_type)),
    );
    lines.push("");
    lines.push("### Ownership Areas");
    lines.push("");
    lines.push(
        renderCountTable(summarizeValues(items, (item) => item.ownership_area)),
    );
    lines.push("");
    lines.push("### Contract Status");
    lines.push("");
    lines.push(
        renderCountTable(
            summarizeValues(items, (item) => item.contract_status),
        ),
    );
    lines.push("");
    lines.push("### Inventory Disposition");
    lines.push("");
    lines.push(
        renderCountTable(
            summarizeValues(items, (item) => item.inventory_disposition),
        ),
    );
    lines.push("");
    lines.push("### Test Status");
    lines.push("");
    lines.push(
        renderCountTable(summarizeValues(items, (item) => item.test_status)),
    );
    lines.push("");
    lines.push("## 6. Material UI Surface Inventory");
    lines.push("");

    for (const [surfaceType, typeItems] of groupBy(
        items,
        (item) => item.surface_type,
    )) {
        lines.push(`### \`${surfaceType}\``);
        lines.push("");
        lines.push(
            "| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |",
        );
        lines.push("| --- | --- | --- | --- | --- | --- | --- | --- | --- |");

        for (const item of typeItems) {
            lines.push(
                `| ${cell(item.ui_key)} | ${cell(item.current_slug)} | ${cell(`${item.ownership_area} / ${item.owner_key}`)} | ${cell(item.implementation_entry)} | ${cell(contractSummary(item))} | ${cell(`${item.test_status} / ${item.test_authority}`)} | ${cell(listSummary(item.known_mismatches))} | ${cell(item.inventory_disposition)} | ${cell(item.target_question)} |`,
            );
        }

        lines.push("");
    }

    lines.push("## 7. Standards And Metadata Evidence");
    lines.push("");
    lines.push(
        `- Surfaces with linked standards evidence: ${items.filter((item) => Array.isArray(item.standards_evidence) && item.standards_evidence.length > 0).length}`,
    );
    lines.push(
        `- Surfaces recording metadata evidence: ${items.filter((item) => item.metadata_evidence && typeof item.metadata_evidence === "object").length}`,
    );
    lines.push(
        `- Surfaces classified with \`standard_stale\`: ${items.filter((item) => item.known_mismatches?.includes("standard_stale")).length}`,
    );
    lines.push("");
    lines.push(
        "| Standard | Implementation | Contract | Reference / Example | Authority | Staleness Evidence | Moved Responsibilities |",
    );
    lines.push("| --- | --- | --- | --- | --- | --- | --- |");

    for (const standard of standards) {
        lines.push(
            `| ${cell(standard._standard_path)} | ${cell(standard.implementation_alignment)} | ${cell(standard.contract_alignment)} | ${cell(standard.reference_or_example_alignment)} | ${cell(standard.authority_state)} | ${cell(listSummary(standard.staleness_evidence))} | ${cell(listSummary(standard.moved_responsibilities))} |`,
        );
    }

    lines.push("");
    lines.push(
        "Standards and metadata findings are current-state evidence only. Final contract metadata, API/schema versioning, readiness, review-state, and durable standards policy remain assigned to Goals 04, 05, and 08.",
    );
    lines.push("");
    lines.push("## 8. UI Test Traceability");
    lines.push("");
    lines.push("| Surface UI Key | Test Path | Type | Result | Authority |");
    lines.push("| --- | --- | --- | --- | --- |");

    for (const trace of traces) {
        lines.push(
            `| ${cell(trace.surface_ui_key)} | ${cell(trace.test_path)} | ${cell(trace.test_type)} | ${cell(trace.current_result)} | ${cell(trace.test_authority)} |`,
        );
    }

    lines.push("");
    lines.push(
        "Issue #30 owns only the relationship between UI surfaces and their test evidence. Issue #32 owns complete test-suite execution, warnings, failure classification, and disposition.",
    );
    lines.push("");
    lines.push("## 9. Runtime Discovery");
    lines.push("");
    lines.push(
        "| Discovery | Current Attempt | Last Successful Evidence | Command |",
    );
    lines.push("| --- | --- | --- | --- |");

    for (const [key, evidence] of Object.entries(
        observations.discovery.commands ?? {},
    )) {
        lines.push(
            `| ${cell(key)} | ${cell(evidence.current_attempt?.status ?? "unknown")} | ${cell(evidence.last_success ? "present" : "absent")} | ${cell(evidence.command)} |`,
        );
    }

    lines.push("");
    lines.push("## 10. Required Later Routing");
    lines.push("");
    const targetQuestions = uniqueSorted(
        items
            .map((item) => item.target_question)
            .filter((value) => value && value !== "not_applicable"),
    );

    if (targetQuestions.length === 0) {
        lines.push("No unresolved target questions were recorded.");
    } else {
        for (const question of targetQuestions) {
            lines.push(`- ${question}`);
        }
    }

    lines.push("");
    lines.push("## 11. Review State");
    lines.push("");
    lines.push(`- Pending surface reviews: ${pendingSurfaces.length}`);
    lines.push(`- Pending standard reviews: ${pendingStandards.length}`);
    lines.push(`- Pending test-trace reviews: ${pendingTraces.length}`);
    lines.push(
        `- Orphaned prior surface reviews: ${classifications.orphaned_prior_records.length}`,
    );
    lines.push(
        `- Orphaned prior test traces: ${testTraces.orphaned_prior_traces.length}`,
    );
    lines.push("");
    lines.push(
        "Final acceptance requires all material surfaces and test traces to be reviewed, every mismatch to remain evidence-backed, and no target-state decision to be introduced by inventory tooling.",
    );

    return `${lines.join("\n")}\n`;
}

function renderCountTable(counts) {
    const lines = ["| Value | Count |", "| --- | ---: |"];

    for (const [value, count] of Object.entries(counts)) {
        lines.push(`| \`${value}\` | ${count} |`);
    }

    return lines.join("\n");
}

function groupBy(items, selector) {
    const groups = new Map();

    for (const item of items) {
        const key = selector(item);
        const group = groups.get(key) ?? [];
        group.push(item);
        groups.set(key, group);
    }

    return [...groups.entries()]
        .sort(([left], [right]) => String(left).localeCompare(String(right)))
        .map(([key, group]) => [
            key,
            group.sort((left, right) =>
                left._record_id.localeCompare(right._record_id),
            ),
        ]);
}

function contractSummary(item) {
    if (typeof item.contract_path === "string") {
        return `${item.contract_status}: ${item.contract_path}`;
    }

    return `${item.contract_status}: ${listSummary(item.contract_path)}`;
}

function listSummary(value) {
    if (!Array.isArray(value) || value.length === 0) {
        return "none";
    }

    return value.join(", ");
}

function cell(value) {
    const text = Array.isArray(value)
        ? value.join(", ")
        : value === null || value === undefined
          ? "unknown"
          : String(value);

    return text.replaceAll("|", "\\|").replaceAll("\n", "<br>");
}
