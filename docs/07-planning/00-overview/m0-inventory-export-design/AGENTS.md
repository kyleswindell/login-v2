# AGENTS.md

## Scope

This file governs `docs/07-planning/00-overview/m0-inventory-export-design/` and all descendant files.

The folder owns a design-only CSV and disposable SQLite projection contract for the accepted Issue #30 UI inventory.

## Authority

Apply these sources in order:

1. Current repository-owner instruction.
2. Root `AGENTS.md`.
3. `docs/AGENTS.md`.
4. `docs/07-planning/AGENTS.md`.
5. Accepted Issue #30 reviewed artifacts for source truth.
6. This file.
7. `csv-schema.json`.
8. `README.md`.
9. `csv-data-dictionary.md`.
10. Fixtures and generated projections.
11. Merged PR #46 and closed Issue #45 for acceptance history only.
12. Inference.

Reviewed Issue #30 JSON remains authoritative. CSV and SQLite are replaceable projections.

## Baselines

Keep these distinct:

```text
Issue #30 immutable evidence baseline:
1d103f5fa47aab8c8adfba8ea134dd29540426fe

Accepted Issue #30 repository source snapshot:
75d1d52c92ff3e0f068903e6903c94aabb009195

Untouched Issue #45 package baseline:
580dcc01ad03ea39990a533b3bb763d87a153039

Accepted export-design merge:
92fdecdfcac2b159dc2c6c21b935075f7e3e2783
```

Do not repin the immutable evidence baseline when later `main` changes. The accepted export-design merge records design acceptance, not a replacement inventory baseline.

## Current State

Schema version `0.2.0` was accepted through PR #46 and merged at `92fdecdfcac2b159dc2c6c21b935075f7e3e2783`.

This folder contains the accepted design contract, header definitions, fixtures, expected fixture projections, and SQLite DDL. It does not prove that a production exporter, validator command, SQLite builder, bounded query command, or generated inventory database exists.

Permitted work under a new bounded issue or explicitly authorized task:

- maintain design documentation, `csv-schema.json`, generated definitions, and fixtures;
- correct internal inconsistencies without changing reviewed Issue #30 truth;
- implement exporter, validator, SQLite-builder, or query tooling when that implementation is explicitly in scope;
- update routing documentation when package status or discoverability changes.

Required boundaries:

- accepted Issue #30 reviewed JSON remains authoritative;
- observations remain generated supporting evidence;
- CSV and SQLite remain generated, disposable projections;
- generated CSV or SQLite content must not be manually edited as source truth;
- projection output must not be reverse-imported to overwrite reviewed JSON;
- do not claim operational tooling exists unless it is verified on current `main`;
- do not generalize this UI-specific projection to repository, persistent-data, or complete test-suite inventories without explicit scope.

Forbidden work:

- committing a generated binary SQLite database;
- recording secrets, runtime data, sessions, logs, credentials, or storage contents;
- using projections to override accepted reviewed values;
- converting accepted JSON to JSONL without a separately accepted design change.

## Source Roles

Use exactly:

```text
classifications
observations
test_traces
```

`classifications` owns reviewed surface and standard judgments.

`test_traces` owns reviewed trace judgments.

`observations` contains generated supporting evidence and must not override reviewed values.

## Required Table Set

Use exactly:

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

Do not restore `ui-standards-evidence.csv`.

## Schema Authority

Within this package:

1. update the intended design in `csv-schema.json`;
2. generate header CSVs from the schema;
3. generate `csv-data-dictionary.md` from the schema;
4. generate `sqlite-schema.sql` from the schema;
5. update fixtures;
6. update README only when package workflow or meaning changes.

Do not maintain competing header, SQL, or dictionary definitions by hand.

## CSV Rules

Use:

```text
UTF-8 without BOM
comma delimiter
LF line endings
exactly one header row
lowercase snake_case headers
RFC 4180-compatible quoting
final newline
deterministic ordering
```

Use lowercase `true` and `false` in CSV.

Use an empty field only for an absent optional scalar.

Preserve `unknown`, `absent`, and `not_applicable` as distinct semantic values.

Normalize arrays into child rows unless a column is explicitly typed `json_text`. Columns ending in `_json` must contain valid deterministic compact JSON.

Neutralize formula-like free text beginning with `=`, `+`, `-`, or `@` in CSV only.

## Mapping Rules

Each column definition must state:

```text
source_roles
source_json_pointers
mapping_status
transformation
```

Allowed mapping states:

```text
confirmed
derived
pending
not_applicable
```

Do not silently invent source fields, review records, dependency states, mismatch explanations, or authority values.

## Identity Rules

Preserve accepted surface and trace IDs.

Derived IDs must follow the algorithm declared in `csv-schema.json`.

Never derive identity from:

- row position;
- export timestamp;
- workstation path;
- nondeterministic enumeration;
- spreadsheet formatting.

## Review Records

Only these record families receive independent review rows:

```text
surface
standard
test_trace
```

Metadata evidence, dependencies, mismatches, aliases, and surface-standard links inherit the owning reviewed record and must not receive invented review state.

## Standards

Store each unique reviewed standard once in `ui-standards.csv`.

Link surfaces through `ui-surface-standards.csv`.

Normalize `staleness_evidence` and `moved_responsibilities` through `ui-standard-findings.csv`.

Use the accepted Issue #30 standard alignment and authority vocabularies exactly.

## Test Traces

Preserve semantic relationship evidence through:

```text
relationship_kind
relationship_value
```

Keep accessibility and JavaScript coverage as categorical states.

Normalize only:

```text
contract_fields_covered
rendered_states_covered
```

Do not convert categorical coverage evidence to booleans.

## Evidence References

A subject may have multiple source references.

Use `ui-source-references.csv` rows rather than one evidence foreign-key column on every table.

Repository paths must be relative and use `/`. Never write local worktree, drive-letter, or UNC paths into package files or fixtures.

## SQLite

SQLite uses a single-export replacement model.

Requirements:

- `PRAGMA foreign_keys = ON`;
- append mode unsupported;
- boolean storage uses `INTEGER` with `0` or `1`;
- source schema versions use `INTEGER`;
- IDs, hashes, SHAs, paths, timestamps, and JSON use `TEXT`;
- primary and foreign keys match `csv-schema.json`;
- controlled values use `CHECK` constraints where practical.

The database is generated, disposable, ignored, and never authoritative.

## Validation

Before staging:

- parse every JSON file;
- verify UTF-8 without BOM;
- verify LF endings and final newline;
- verify every expected CSV exists;
- verify header order against `csv-schema.json`;
- verify no duplicate headers;
- verify every primary and foreign-key column exists;
- verify foreign-key targets exist;
- verify controlled values against Issue #30;
- verify SQLite tables and columns against the schema;
- verify no obsolete table or fixture remains;
- verify no unsupported review subject exists;
- verify no absolute or workstation-specific path exists;
- run `git diff --check`;
- verify every changed path remains under this folder.

## Git Safety

Use the branch and worktree strategy explicitly approved for the current issue or task. Do not recreate or reuse the historical Issue #45 worktree or branch.

Stage explicit paths only and do not include unrelated changes.

Treat merged PR #46 and closed Issue #45 as acceptance history. New writable work requires a new bounded issue or explicit repository-owner task scope.

## Stop Conditions

Stop and report when:

- the current branch, task baseline, or accepted package version is unexpected;
- another writer has uncommitted or concurrent changes in the package;
- accepted Issue #30 source shape conflicts with this design;
- a mapping cannot be represented without loss;
- a stable natural key cannot be established;
- controlled vocabulary conflicts with accepted Issue #30;
- another writer changes the package concurrently;
- a change would escape the allowed package path;
- sensitive, runtime-only, or workstation-specific content would be recorded;
- CSV or SQLite would become independently editable authority.
