# AGENTS.md

## Scope

This file governs `m0-inventory-export-design/` and all descendant files.

This folder is an external design package for normalized CSV and SQLite projections of accepted Login 2.0 inventory data.

It is not canonical repository documentation and does not authorize repository or GitHub changes.

## Authority

Apply these sources in order:

1. Current repository-owner instruction.
2. Applicable repository `AGENTS.md` files when this folder is used inside a repository worktree.
3. Accepted GitHub issue scope and acceptance criteria.
4. Accepted reviewed inventory JSON artifacts.
5. This file.
6. `README.md`.
7. `csv-data-dictionary.md`.
8. Fixtures and generated convenience projections.
9. Inference.

This file adds folder-specific rules. It does not override repository security, worktree, branch, staging, PR, merge, or owner-acceptance requirements.

## Current Mode

The current mode is **design-only** unless the repository owner explicitly authorizes implementation.

Allowed design work includes:

- creating header-only CSV files;
- drafting `csv-schema.json`;
- drafting SQLite DDL;
- drafting fixtures;
- drafting query examples;
- documenting mappings and controlled values;
- validating internal consistency of the design package.

Do not populate final export rows from an unaccepted Issue #30 branch.

## Source Of Truth

Accepted reviewed JSON remains the structured source of truth.

Markdown remains the human-readable reviewed projection.

CSV and SQLite are generated convenience projections.

Never:

- treat CSV as independently editable authority;
- treat SQLite as independently editable authority;
- reverse-import ad hoc CSV edits into accepted reviewed JSON;
- infer accepted inventory findings from spreadsheet formatting;
- overwrite reviewed source data from generated projections.

## Repository And Worktree Safety

If this package is later used for writable repository work:

- use a dedicated issue branch;
- use a dedicated local-disk worktree;
- verify the repository root and origin;
- verify the branch start and current `origin/main`;
- verify the worktree is clean;
- read all applicable repository `AGENTS.md` files;
- apply files only after branch/worktree verification;
- do not modify the coordination checkout or another issue worktree;
- do not switch, stash, reset, clean, overwrite, relocate, or remove another issue's work;
- do not merge, close issues, update parent checklists, delete branches, or remove worktrees without explicit repository-owner acceptance.

## File Creation Rules

Expected design files may include:

```text
csv-schema.json
inventory-export-manifest.csv
headers/*.csv
sqlite-schema.sql
query-examples.sql
fixtures/**
```

Do not create additional file families without documenting why they are needed.

Header-only CSVs are permitted.

Every CSV must have exactly one header row.

## CSV Rules

Use:

```text
Encoding: UTF-8 without BOM
Delimiter: comma
Line endings: LF
Quoting: RFC 4180-compatible
Header names: lowercase snake_case
Final newline: required
Ordering: deterministic
```

Do not:

- use row numbers as identifiers;
- repeat headers inside a file;
- embed workstation or UNC paths;
- use `\\` in repository paths;
- collapse arrays into semicolon- or pipe-delimited cells;
- use multiline CSV cells unless explicitly approved;
- use `NULL`, `N/A`, `-`, or `?` as generic missing values;
- use spreadsheet formulas or executable cell content;
- include secrets, `.env` values, logs, runtime rows, credentials, session contents, or storage contents.

## Identity And Relationships

Prefer existing accepted stable record IDs.

Generated child IDs must be deterministic and derived from stable natural keys.

Every child row must resolve to a valid parent.

Every foreign key must be validated before SQLite generation.

Do not silently invent UI keys, owners, Module keys, aliases, review states, mismatches, provenance, or dispositions.

## Normalization

Normalize one-to-many values into child tables.

Examples:

- surface files;
- mismatches;
- test coverage values;
- standards evidence;
- metadata evidence;
- dependencies;
- source references;
- review records.

Do not place JSON arrays into ordinary CSV cells when a child table can represent the relationship.

## Determinism

Repeated export from identical accepted reviewed JSON must produce byte-identical CSV content, except for explicitly separated run metadata.

Use stable headers, column order, IDs, row ordering, quoting, newline behavior, and normalization rules.

Run-level timestamps belong in the manifest, not repeated across every row unless required by an accepted schema.

## Excel Safety

Treat IDs, hashes, SHAs, paths, and timestamps as text.

Neutralize free-text values beginning with `=`, `+`, `-`, or `@`.

The CSV projection may prefix an apostrophe for Excel safety. The accepted reviewed JSON must retain the original value.

## SQLite Rules

SQLite must be generated from validated accepted JSON or validated CSVs.

The database must be:

- disposable;
- rebuildable;
- ignored by Git;
- never manually edited;
- excluded from canonical authority;
- validated against source counts and foreign keys.

Do not commit a binary SQLite file as the source of truth.

## Validation Expectations

Before claiming the design is ready, verify:

- every expected CSV has one valid header row;
- headers match `csv-data-dictionary.md`;
- column names are unique;
- primary keys and foreign keys are defined;
- controlled values are documented;
- deterministic ordering is documented;
- empty, unknown, absent, and not-applicable semantics are distinct;
- path rules are explicit;
- Excel formula protection is explicit;
- secret-bearing content is prohibited;
- SQLite table names and relationships match the CSV design;
- fixtures cover valid and invalid cases.

## Change Discipline

When updating the design:

1. Update `csv-data-dictionary.md` first.
2. Update `csv-schema.json` to match.
3. Update header-only CSVs.
4. Update SQLite DDL.
5. Update fixtures.
6. Update README only when package use or workflow changes.

Do not change column names, key semantics, or controlled values silently.

Increment `export_schema_version` when a change is not backward-compatible.

## Handoff Expectations

A future Codex implementation task must use:

1. a short Plan-mode prompt;
2. the accepted GitHub issue;
3. applicable repository `AGENTS.md`;
4. this folder's design documents;
5. an approved ExecPlan;
6. a separate execution phase;
7. an independent read-only review.

Do not paste the entire data dictionary into a one-shot implementation prompt.

## Stop Conditions

Stop and report when:

- Issue #30's accepted reviewed source schema is unavailable or changed unexpectedly;
- a required mapping cannot be represented without loss;
- a stable ID cannot be established;
- a foreign key is ambiguous;
- a controlled value conflicts with accepted Issue #30 vocabulary;
- implementation would require modifying accepted reviewed findings;
- repository scope or authority is unclear;
- secret-bearing or runtime-only content would be exported;
- CSV or SQLite would become independently editable authority.
