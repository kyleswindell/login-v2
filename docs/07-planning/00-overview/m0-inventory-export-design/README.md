<!--
DOC-META
title: M0 UI Inventory Export Design
doc_type: planning
status: planned
owner: docs
canonical: false
canonical_path: docs/07-planning/00-overview/m0-inventory-export-design/README.md
parent: docs/07-planning/00-overview/m0-ui-current-state-inventory.md
template: docs/09-reference/templates/docs/_planning.md
summary: Defines a design-only normalized CSV and disposable SQLite projection for the accepted Issue #30 UI inventory.
-->

# M0 UI Inventory Export Design

Parent: [M0 UI Current-State Inventory](../m0-ui-current-state-inventory.md)

## 1. Purpose

This folder defines a design-only projection model for querying the accepted Issue #30 UI inventory without loading the complete reviewed JSON artifacts for every bounded question.

The projection targets:

- deterministic normalized CSV files for spreadsheet and interchange use;
- a generated disposable SQLite database for bounded local queries;
- explicit source lineage back to accepted Issue #30 artifacts;
- preservation of reviewed authority in JSON rather than CSV or SQLite.

The package does not implement an exporter. It defines the contract a later tooling issue may implement.

## 2. Baselines

| Baseline | Commit |
| --- | --- |
| Immutable Issue #30 evidence baseline | `1d103f5fa47aab8c8adfba8ea134dd29540426fe` |
| Accepted repository source snapshot | `75d1d52c92ff3e0f068903e6903c94aabb009195` |
| Untouched external-package baseline | `580dcc01ad03ea39990a533b3bb763d87a153039` |
| Accepted export-design merge | `92fdecdfcac2b159dc2c6c21b935075f7e3e2783` |
| Export design schema | `0.2.0` |

The immutable evidence baseline identifies the repository state inventoried by Issue #30. The accepted repository source snapshot identifies the merged artifacts and tooling from which a future exporter reads.

## 3. Source Authority

The required source roles are:

| Source role | Artifact | Authority |
| --- | --- | --- |
| `classifications` | `docs/07-planning/00-overview/evidence/m0-ui-current-state-classifications.json` | Reviewed surface and unique-standard judgments |
| `observations` | `docs/07-planning/00-overview/evidence/m0-ui-current-state-observations.json` | Generated supporting implementation evidence |
| `test_traces` | `docs/07-planning/00-overview/evidence/m0-ui-current-state-test-traces.json` | Reviewed surface-to-test judgments |

Reviewed JSON remains authoritative. Observations remain generated evidence. CSV and SQLite are replaceable projections and must never be edited as independent truth.

## 4. Projection Model

```text
accepted classifications JSON ─┐
accepted observations JSON ────┼─> validated normalized CSV ─> disposable SQLite
accepted test-traces JSON ─────┘
```

The concise Issue #30 Markdown inventory remains the primary human-readable review projection.

## 5. Required CSV Set

```text
inventory-export-manifest.csv
inventory-export-sources.csv

ui-surfaces.csv
ui-surface-aliases.csv
ui-surface-files.csv
ui-mismatches.csv

ui-test-traces.csv
ui-test-trace-coverage.csv

ui-standards.csv
ui-surface-standards.csv
ui-standard-findings.csv

ui-metadata-evidence.csv
ui-dependencies.csv
ui-source-references.csv
ui-review-status.csv
```

`csv-schema.json` is the machine-readable design authority for headers, column order, types, controlled values, keys, source roles, JSON pointers, transformations, and deterministic ordering.

`csv-data-dictionary.md` is generated from the same schema for human review.

## 6. Normalization Rules

Normalize:

- multiple Blade aliases into `ui-surface-aliases.csv`;
- surface file collections into `ui-surface-files.csv`;
- mismatch arrays into `ui-mismatches.csv`;
- test contract-field and rendered-state arrays into `ui-test-trace-coverage.csv`;
- unique standards into `ui-standards.csv`;
- surface-standard relationships into `ui-surface-standards.csv`;
- standard staleness and moved-responsibility arrays into `ui-standard-findings.csv`;
- dependencies into `ui-dependencies.csv`;
- multiple evidence sources into `ui-source-references.csv`;
- independently reviewed surfaces, standards, and traces into `ui-review-status.csv`.

Some Issue #30 values are structured records rather than simple relationships. Columns ending in `_json` explicitly store deterministic compact JSON to preserve those exact source values. A JSON-valued column is never presented as an ordinary scalar.
### 6.1. Evidence-Source Bindings

`ui-source-references.csv` emits rows only for explicitly bound reviewed record families:

- `surface` from `classifications.items`;
- `standard` from `classifications.standard_reviews`;
- `test_trace` from `test_traces.test_traces`.

The source binding registry in `csv-schema.json` identifies the record pointer, subject-ID rule, and allowed evidence pointers for each family. Recursive discovery does not choose evidence ownership.

Every row preserves the complete accepted token in `evidence_raw`. Parsed `evidence_kind` and `evidence_value` columns are convenience fields only. For example:

```text
evidence_raw  = issue-29:route-list
evidence_kind = issue
evidence_value = route-list
```

The issue qualifier remains part of identity. Source-reference IDs are derived from `subject_type`, `subject_id`, `evidence_raw`, `line_start`, and `line_end`.

The schema uses an explicit JSON Pointer glob grammar. `*` matches one segment and `**` matches zero or more descendant segments; each pattern is evaluated only against its declared source role.

## 7. CSV Format

Every CSV uses:

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

CSV booleans are lowercase `true` and `false`.

An empty field means an optional scalar has no value. Controlled semantic states such as `unknown`, `absent`, and `not_applicable` remain explicit values.

Free-text values beginning with `=`, `+`, `-`, or `@` are prefixed with an apostrophe in CSV only to prevent spreadsheet formula execution. Accepted JSON retains the original value.

## 8. Stable Identity

Accepted `surface_id` and `trace_id` values are preserved.

Derived IDs use:

```text
prefix + ":" + first 20 lowercase hexadecimal characters of
SHA-256(UTF-8(compact JSON of the ordered natural-key array))
```

The exact natural key for every derived record is stated in `csv-schema.json`.

Row numbers, timestamps, workstation paths, and mutable file ordering must not influence IDs.

## 9. Determinism

For identical source bytes, export schema version, and generator version:

- all data CSVs must be byte-identical;
- IDs must be identical;
- rows must follow the declared `sort_order`;
- JSON-valued cells must use deterministic compact JSON;
- the SQLite rebuild must produce equivalent row content and query results.

`exported_at_utc` is run metadata and is excluded from byte-determinism comparison of the manifest.

## 10. SQLite Model

SQLite is:

- generated;
- disposable;
- ignored by Git;
- replaced for every export;
- never manually edited;
- never authoritative;
- configured with `PRAGMA foreign_keys = ON`.

Append mode is not supported.

SQLite stores:

- IDs, hashes, SHAs, paths, timestamps, and JSON as `TEXT`;
- schema versions and counts as `INTEGER`;
- booleans as `INTEGER` constrained to `0` or `1`.

The committed `sqlite-schema.sql` must match `csv-schema.json`.

## 11. Fixtures

The fixture package contains:

```text
fixtures/
├── README.md
├── source/
│   ├── classifications.json
│   ├── observations.json
│   └── test-traces.json
├── expected-csv/
└── invalid/
```

Fixtures cover:

- scalar, multiple, and non-applicable Blade aliases;
- one standard linked to multiple surfaces;
- staleness evidence and moved responsibilities;
- trace relationship evidence;
- `present_claim`, `not_observed`, and `unknown` coverage states;
- multiple evidence sources;
- surface and unresolved dependency targets;
- reviewed surface, standard, and trace records;
- invalid foreign keys, paths, controlled values, and spreadsheet formula handling.

Fixtures are design examples. They are not accepted Issue #30 records.

## 12. Validation Requirements

A future implementation must reject:

- missing, duplicate, or reordered headers;
- blank or duplicate primary keys;
- unresolved foreign keys;
- unsupported controlled values;
- source schema versions represented as strings;
- CSV booleans other than lowercase `true` or `false`;
- SQLite booleans other than `0` or `1`;
- malformed UTC timestamps;
- malformed SHA-256 values;
- absolute or backslash repository paths;
- unsupported review subject types;
- unmarked array/object content in ordinary scalar columns;
- unneutralized formula-like free text;
- secrets, `.env` values, logs, credentials, sessions, storage contents, or runtime row data.

## 13. Current State And Target State

### Current state

Schema version `0.2.0` was accepted through PR #46 and merged at `92fdecdfcac2b159dc2c6c21b935075f7e3e2783`.

The repository contains the accepted design contract, header definitions, fixtures, expected fixture CSV projections, and SQLite DDL. It does not currently contain a production exporter, validator command, SQLite builder, bounded query command, or generated inventory database.

Accepted Issue #30 reviewed JSON remains authoritative. CSV and SQLite remain replaceable projections.

### Target state

A separately scoped tooling issue may implement a read-only exporter, validator, SQLite builder, and bounded query commands using the accepted design.

Future tooling must preserve the authority boundary, deterministic identity rules, explicit source bindings, fixtures, and validation requirements defined here unless a later accepted issue explicitly changes the design.

## 14. Non-Goals

This package does not:

- modify accepted Issue #30 artifacts or reviewed values;
- claim that production exporter or query tooling already exists;
- generate or commit final production CSV rows as repository truth;
- commit a SQLite database;
- convert accepted JSON to JSONL;
- define Issue #32 complete test-suite dispositions;
- select Goal 06 persistence architecture;
- generalize this UI projection contract to unrelated inventory domains.

## 15. Maintenance And Future Implementation

Before changing the accepted design or implementing tooling:

1. use a bounded GitHub issue or explicitly authorized repository-owner task;
2. read this folder's `AGENTS.md`, this README, and `csv-schema.json`;
3. distinguish the immutable Issue #30 evidence baseline from the current implementation branch start;
4. compare all source mappings with accepted Issue #30 artifacts;
5. verify controlled values against `scripts/lib/m0-ui-inventory/schema.mjs`;
6. verify headers, SQLite DDL, keys, controlled values, and fixtures against `csv-schema.json`;
7. preserve reviewed JSON as authority and projections as disposable output;
8. run documentation, diff, and implementation-specific validation before acceptance;
9. never commit a generated binary SQLite database.
