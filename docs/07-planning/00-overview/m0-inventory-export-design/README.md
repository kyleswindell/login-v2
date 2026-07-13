---
title: M0 Inventory Export Design
version: 0.1
status: design-only
scope: External inventory export design package
canonical: false
last_reviewed: 2026-07-13
---

# M0 Inventory Export Design

## Purpose

This folder defines the planned CSV and SQLite projection model for large Login 2.0 inventories.

The projections are intended to make accepted reviewed inventory data easier to:

- filter in Excel;
- query with SQLite;
- inspect through bounded Codex commands;
- compare across exports;
- validate without loading an entire large JSON artifact.

This package is a design aid only. It is not canonical repository documentation and does not replace accepted reviewed JSON or concise Markdown inventory artifacts.

## Authority Model

Use the following authority order:

1. Current repository-owner instruction.
2. Applicable repository `AGENTS.md` files when this folder is used inside a repository worktree.
3. Accepted GitHub issue scope and acceptance criteria.
4. Accepted reviewed JSON inventory artifacts.
5. This folder's `AGENTS.md`.
6. This README and `csv-data-dictionary.md`.
7. Generated CSV and SQLite projections.
8. Inference.

CSV and SQLite outputs are disposable, rebuildable projections. They must never become independently editable sources of truth.

## Current Phase

This package is currently **design-only**.

Before Issue #30 is accepted and merged, it is safe to prepare:

- header-only CSV files;
- `csv-schema.json`;
- CSV data mappings;
- SQLite schema design;
- fixtures;
- expected validation rules;
- query examples.

Do not populate final CSV rows or build a canonical SQLite projection from an unaccepted Issue #30 branch.

## Expected Folder Contents

```text
m0-inventory-export-design/
├── AGENTS.md
├── README.md
├── csv-data-dictionary.md
├── csv-schema.json
├── inventory-export-manifest.csv
├── headers/
│   ├── ui-surfaces.csv
│   ├── ui-surface-files.csv
│   ├── ui-mismatches.csv
│   ├── ui-test-traces.csv
│   ├── ui-test-trace-coverage.csv
│   ├── ui-standards-evidence.csv
│   ├── ui-metadata-evidence.csv
│   ├── ui-dependencies.csv
│   ├── ui-source-references.csv
│   └── ui-review-status.csv
├── sqlite-schema.sql
├── query-examples.sql
└── fixtures/
    ├── sample-reviewed-ui-inventory.json
    └── expected-csv/
```

The remaining files may be created manually during the design phase.

## CSV File Rules

Every CSV must use:

```text
Encoding: UTF-8 without BOM
Delimiter: comma
Line endings: LF
Header row: exactly one
Header names: lowercase snake_case
Quoting: RFC 4180-compatible
Final newline: required
Ordering: deterministic
```

Additional rules:

- Header-only CSV files are valid during design.
- Do not repeat the header row within a file.
- Do not use row numbers as identifiers.
- Treat IDs, hashes, SHAs, paths, and timestamps as text.
- Normalize arrays into child CSVs instead of using semicolon- or pipe-delimited cells.
- Use empty cells only for absent optional scalar values.
- Preserve controlled semantic values such as `unknown`, `not_applicable`, and `absent`.
- Repository paths must be relative, use `/`, and never contain workstation or UNC paths.
- Free-text exports intended for Excel must neutralize formula-like values beginning with `=`, `+`, `-`, or `@`.

## Projection Model

```text
Accepted reviewed JSON
    authoritative structured inventory

Compact Markdown
    human-readable reviewed projection

Normalized CSV
    spreadsheet and interchange projection

SQLite
    generated local query projection
```

SQLite should be generated from accepted reviewed JSON or validated CSVs and must remain disposable and replaceable.

Do not commit a binary SQLite database as the authoritative inventory.

## Stable Identity

Use the accepted stable source record ID when one exists.

Generated child IDs must be deterministic and based on stable natural keys, for example:

```text
surface_file_id = hash(surface_id + file_role + path)
mismatch_id = hash(surface_id + mismatch_code + evidence_reference)
dependency_id = hash(surface_id + dependency_kind + target)
metadata_evidence_id = hash(surface_id + metadata_field + evidence_reference)
```

Unchanged source data must produce unchanged IDs.

## Recommended Export Workflow

After Issue #30 is accepted:

1. Read only the accepted reviewed JSON artifacts.
2. Validate the source schema and baseline.
3. Export normalized CSVs.
4. Validate headers, keys, foreign keys, controlled values, row counts, and ordering.
5. Generate the SQLite query database.
6. Verify CSV and SQLite counts agree with the accepted JSON.
7. Run bounded query fixtures.
8. Delete and rebuild the SQLite database to prove reproducibility.
9. Keep CSV and SQLite projections separate from reviewed authority.

## Minimum Validation Expectations

Future tooling should fail when:

- a required header is missing or reordered;
- a primary key is blank or duplicated;
- a foreign key does not resolve;
- a controlled value is invalid;
- a repository path is absolute or uses `\\`;
- a child record has no parent;
- a manifest row count differs from the CSV row count;
- repeated exports from identical source data differ;
- formula-like free text is not neutralized for Excel;
- secret-bearing, runtime-only, `.env`, log, storage, credential, or row-level data appears;
- CSV or SQLite content diverges from the accepted reviewed JSON.

## Excel Import

Use:

```text
Data → From Text/CSV
```

Import IDs, hashes, commit SHAs, blob OIDs, repository paths, and timestamps as text.

Avoid opening by double-click when validating data integrity because Excel may alter values.

## Future Repository Integration

When the design is ready to become repository tooling:

- create a dedicated GitHub issue;
- create a dedicated branch and local-disk worktree;
- keep the accepted reviewed JSON as authority;
- add read-only export and query commands;
- keep generated SQLite output ignored;
- preserve Issue #30 review values and baseline;
- do not modify UI implementation or accepted inventory findings;
- require repository-owner acceptance before merge.

## Non-Goals

This folder does not:

- redesign Issue #30's accepted schema;
- convert accepted JSON to JSONL;
- create a general-purpose analytics platform;
- replace repository contracts or planning documents;
- select UI lifecycle or readiness decisions;
- define Issue #32 test dispositions;
- define the Goal 06 target data model;
- authorize repository or GitHub mutations.
