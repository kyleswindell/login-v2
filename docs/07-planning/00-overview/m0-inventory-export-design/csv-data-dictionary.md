---
title: CSV Data Dictionary
version: 0.1
status: design-only
scope: M0 UI inventory export projections
canonical: false
last_reviewed: 2026-07-13
---

# CSV Data Dictionary

## 1. Purpose

This document defines the planned normalized CSV schema for the accepted M0 UI inventory.

The CSV files are convenience projections for spreadsheet filtering, bounded automation, and SQLite import. They are not authoritative inventory records. The accepted reviewed JSON remains the structured source of truth.

## 2. Global Conventions

### 2.1 Common Provenance Columns

Every data CSV begins with:

| Column | Type | Required | Meaning |
| --- | --- | --- | --- |
| `export_id` | text | yes | Stable identifier for one export run. |
| `inventory_baseline_sha` | text | yes | Immutable inventory baseline commit SHA. |
| `source_schema_version` | integer | yes | Schema version of the accepted reviewed source artifact. |
| `export_schema_version` | integer | yes | Schema version of the CSV projection. |

### 2.2 Format

| Rule | Value |
| --- | --- |
| Encoding | UTF-8 without BOM |
| Delimiter | comma |
| Line endings | LF |
| Header row | exactly one |
| Header style | lowercase `snake_case` |
| Quoting | RFC 4180-compatible |
| Final newline | required |
| Ordering | deterministic |

### 2.3 Scalar Values

| Kind | Representation |
| --- | --- |
| Boolean | `true` or `false` |
| Timestamp | UTC ISO 8601, for example `2026-07-13T13:51:55Z` |
| Optional absent scalar | empty cell |
| Unknown semantic state | `unknown` |
| Non-applicable semantic state | `not_applicable` |
| Explicit absence | `absent` |
| Hashes and SHAs | text |
| Repository paths | repository-relative with `/` |

Do not use `NULL`, `N/A`, `-`, `?`, `1`, `0`, `yes`, or `no` as generic replacements.

### 2.4 Arrays

Arrays must be normalized into child rows. Do not store ordinary arrays as pipe-, semicolon-, or JSON-delimited values unless a later accepted schema explicitly authorizes a JSON-valued text column.

### 2.5 Excel Safety

Free-text values beginning with `=`, `+`, `-`, or `@` must be neutralized in the CSV projection to prevent formula execution. The accepted reviewed JSON retains the original text.

## 3. `inventory-export-manifest.csv`

One row per generated CSV.

Header:

```csv
export_id,inventory_type,inventory_baseline_sha,source_schema_version,export_schema_version,source_artifact_path,source_artifact_sha256,export_file,row_count,exported_at_utc,generator_version,encoding,delimiter,line_ending,status
```

| Column | Type | Required | Key | Notes |
| --- | --- | --- | --- | --- |
| `export_id` | text | yes | PK component | Identifies the export run. |
| `inventory_type` | text | yes |  | Expected value: `ui`. |
| `inventory_baseline_sha` | text | yes |  | Immutable baseline SHA. |
| `source_schema_version` | integer | yes |  | Accepted source schema version. |
| `export_schema_version` | integer | yes |  | CSV schema version. |
| `source_artifact_path` | text | yes |  | Repository-relative accepted JSON source. |
| `source_artifact_sha256` | text | yes |  | SHA-256 of the source artifact. |
| `export_file` | text | yes | PK component | Relative CSV path. |
| `row_count` | integer | yes |  | Data rows, excluding header. |
| `exported_at_utc` | timestamp | yes |  | UTC export timestamp. |
| `generator_version` | text | yes |  | Exporter implementation version. |
| `encoding` | text | yes |  | `utf-8`. |
| `delimiter` | text | yes |  | `comma`. |
| `line_ending` | text | yes |  | `lf`. |
| `status` | enum | yes |  | `complete`, `partial`, or `failed`. |

Recommended unique key: `export_id + export_file`.

## 4. `ui-surfaces.csv`

One row per material UI surface.

Header:

```csv
export_id,inventory_baseline_sha,source_schema_version,export_schema_version,surface_id,ui_key,current_slug,surface_type,ownership_area,owner_key,capability_key,module_key,blade_alias,implementation_entry,contract_status,registration_summary,public_api_summary,contract_api_summary,carbon_provenance,app_owned_deviation_summary,lifecycle_claim,review_claim,accessibility_summary,responsive_summary,browser_summary,test_status,test_authority,inventory_disposition,target_question,source_fingerprint
```

Primary key: `surface_id`.

| Column | Type | Required | Notes |
| --- | --- | --- | --- |
| `surface_id` | text | yes | Stable accepted reviewed record ID. |
| `ui_key` | text | yes | May be `unknown`; never substitutes for `surface_id`. |
| `current_slug` | text | yes | Current observed slug or controlled unknown value. |
| `surface_type` | enum | yes | Accepted Issue #30 surface type. |
| `ownership_area` | enum | yes | `core`, `module`, `ui`, `unknown`, or `not_applicable`. |
| `owner_key` | text | yes | Accepted key or controlled unknown value. |
| `capability_key` | text | yes | Accepted key or controlled unknown value. |
| `module_key` | text | yes | Actual optional Module key or `not_applicable`. |
| `blade_alias` | text | yes | Alias or controlled unknown/non-applicable value. |
| `implementation_entry` | text | yes | Repository-relative primary implementation entry. |
| `contract_status` | enum | yes | Surface-level contract summary. |
| `registration_summary` | text | yes | Compact reviewed registration result. |
| `public_api_summary` | text | yes | Compact implementation API summary. |
| `contract_api_summary` | text | yes | Compact contract API summary. |
| `carbon_provenance` | enum | yes | Accepted provenance value. |
| `app_owned_deviation_summary` | text | no | Compact app-owned deviation summary. |
| `lifecycle_claim` | text | yes | Current lifecycle claim or controlled unknown value. |
| `review_claim` | text | yes | Current review claim or controlled unknown value. |
| `accessibility_summary` | text | yes | Surface-level evidence summary. |
| `responsive_summary` | text | yes | Surface-level evidence summary. |
| `browser_summary` | text | yes | Surface-level evidence summary. |
| `test_status` | enum | yes | Surface-level test summary. |
| `test_authority` | enum | yes | Surface-level authority summary. |
| `inventory_disposition` | enum | yes | `retain`, `compatibility`, `duplicate`, or `investigate`. |
| `target_question` | text | no | Unresolved target question. |
| `source_fingerprint` | text | yes | Stable reviewed source fingerprint. |

Deterministic ordering: `surface_id`.

## 5. `ui-surface-files.csv`

One row per repository file associated with a surface.

Header:

```csv
export_id,inventory_baseline_sha,source_schema_version,export_schema_version,surface_file_id,surface_id,file_role,path,is_primary,exists_at_baseline,registration_state,source_blob_oid,source_sha256,notes
```

Primary key: `surface_file_id`.

Foreign key: `surface_id -> ui-surfaces.surface_id`.

| Column | Type | Required | Notes |
| --- | --- | --- | --- |
| `surface_file_id` | text | yes | Deterministic child ID. |
| `surface_id` | text | yes | Owning surface. |
| `file_role` | enum | yes | Relationship of file to surface. |
| `path` | text | yes | Repository-relative path using `/`. |
| `is_primary` | boolean | yes | Whether this is the primary file for the role. |
| `exists_at_baseline` | boolean | yes | Whether path resolves at pinned baseline. |
| `registration_state` | enum | yes | Reviewed registration state. |
| `source_blob_oid` | text | no | Git blob OID when available. |
| `source_sha256` | text | no | SHA-256 when available. |
| `notes` | text | no | Compact explanation. |

Suggested `file_role` values:

```text
implementation_entry
implementation_support
contract
reference
example
proof
css
javascript
test
asset
icon
pictogram
registration
route
other
```

Deterministic ordering: `surface_id, file_role, path`.

## 6. `ui-mismatches.csv`

One row per mismatch classification.

Header:

```csv
export_id,inventory_baseline_sha,source_schema_version,export_schema_version,mismatch_id,surface_id,mismatch_code,explanation,evidence_source_reference_id
```

Primary key: `mismatch_id`.

Foreign keys:

```text
surface_id -> ui-surfaces.surface_id
evidence_source_reference_id -> ui-source-references.source_reference_id
```

| Column | Type | Required | Notes |
| --- | --- | --- | --- |
| `mismatch_id` | text | yes | Deterministic child ID. |
| `surface_id` | text | yes | Owning surface. |
| `mismatch_code` | enum | yes | Issue #30 controlled mismatch code. |
| `explanation` | text | yes | Concise reviewed explanation. |
| `evidence_source_reference_id` | text | no | Supporting evidence reference. |

Controlled mismatch values:

```text
aligned
contract_missing
contract_stale
implementation_stale
standard_stale
test_missing
test_stale
test_incomplete
reference_missing
reference_stale
example_missing
example_stale
registration_missing
registration_stale
duplicate_identity
owner_mismatch
blade_alias_mismatch
source_path_mismatch
dependency_mismatch
provenance_unknown
review_unknown
lifecycle_conflict
accessibility_evidence_missing
browser_evidence_missing
responsive_evidence_missing
investigate
```

Rules:

- `aligned` cannot coexist with another mismatch for the same surface.
- Do not create a synthetic `none` row.

Deterministic ordering: `surface_id, mismatch_code, mismatch_id`.

## 7. `ui-test-traces.csv`

One row per surface-to-test relationship.

Header:

```csv
export_id,inventory_baseline_sha,source_schema_version,export_schema_version,trace_id,surface_id,surface_ui_key,test_path,test_exists,test_type,current_result,test_authority,accessibility_behavior_covered,javascript_behavior_covered,contract_fields_covered_count,rendered_states_covered_count,evidence_source_reference_id,source_fingerprint
```

Primary key: `trace_id`.

Foreign keys:

```text
surface_id -> ui-surfaces.surface_id
evidence_source_reference_id -> ui-source-references.source_reference_id
```

| Column | Type | Required | Notes |
| --- | --- | --- | --- |
| `trace_id` | text | yes | Accepted trace ID. |
| `surface_id` | text | yes | Related surface record. |
| `surface_ui_key` | text | yes | Reviewed UI key value at export time. |
| `test_path` | text | yes | Repository-relative path. |
| `test_exists` | boolean | yes | Whether the source exists at baseline. |
| `test_type` | enum | yes | Accepted trace type. |
| `current_result` | enum | yes | Includes `not_run` when applicable. |
| `test_authority` | enum | yes | `authoritative`, `partial`, `incidental`, `stale`, or `unknown`. |
| `accessibility_behavior_covered` | text | yes | Reviewed trace summary. |
| `javascript_behavior_covered` | text | yes | Reviewed trace summary. |
| `contract_fields_covered_count` | integer | yes | Count of child coverage rows. |
| `rendered_states_covered_count` | integer | yes | Count of child coverage rows. |
| `evidence_source_reference_id` | text | no | Supporting source reference. |
| `source_fingerprint` | text | yes | Stable trace fingerprint. |

Deterministic ordering: `surface_id, test_path, trace_id`.

## 8. `ui-test-trace-coverage.csv`

One row per detailed test coverage value.

Header:

```csv
export_id,inventory_baseline_sha,source_schema_version,export_schema_version,coverage_id,trace_id,coverage_kind,coverage_value
```

Primary key: `coverage_id`.

Foreign key: `trace_id -> ui-test-traces.trace_id`.

| Column | Type | Required | Notes |
| --- | --- | --- | --- |
| `coverage_id` | text | yes | Deterministic child ID. |
| `trace_id` | text | yes | Parent trace. |
| `coverage_kind` | enum | yes | Coverage category. |
| `coverage_value` | text | yes | One covered field, state, or behavior. |

Controlled `coverage_kind` values:

```text
contract_field
rendered_state
accessibility_behavior
javascript_behavior
```

Deterministic ordering: `trace_id, coverage_kind, coverage_value`.

## 9. `ui-standards-evidence.csv`

One row per standard-to-surface relationship.

Header:

```csv
export_id,inventory_baseline_sha,source_schema_version,export_schema_version,standard_evidence_id,surface_id,standard_path,claimed_scope,implementation_alignment,contract_alignment,reference_or_example_alignment,authority_state,staleness_evidence,evidence_source_reference_id
```

Primary key: `standard_evidence_id`.

Foreign keys:

```text
surface_id -> ui-surfaces.surface_id
evidence_source_reference_id -> ui-source-references.source_reference_id
```

| Column | Type | Required | Notes |
| --- | --- | --- | --- |
| `standard_evidence_id` | text | yes | Deterministic child ID. |
| `surface_id` | text | yes | Related surface. |
| `standard_path` | text | yes | Repository-relative standard path. |
| `claimed_scope` | text | yes | Standard's claimed governance scope. |
| `implementation_alignment` | enum | yes | Reviewed alignment. |
| `contract_alignment` | enum | yes | Reviewed alignment. |
| `reference_or_example_alignment` | enum | yes | Reviewed alignment. |
| `authority_state` | enum | yes | Reviewed authority state. |
| `staleness_evidence` | text | no | Concise evidence of staleness. |
| `evidence_source_reference_id` | text | no | Supporting source reference. |

Suggested alignment values:

```text
aligned
partial
misaligned
stale
unknown
not_applicable
```

Suggested authority values:

```text
canonical
active_guidance
mixed
historical
superseded
unknown
```

Deterministic ordering: `surface_id, standard_path`.

## 10. `ui-metadata-evidence.csv`

Long-form metadata evidence: one row per metadata field per surface.

Header:

```csv
export_id,inventory_baseline_sha,source_schema_version,export_schema_version,metadata_evidence_id,surface_id,metadata_field,presence_state,observed_value,observed_format,agreement_state,known_disagreement,evidence_source_reference_id
```

Primary key: `metadata_evidence_id`.

Foreign keys:

```text
surface_id -> ui-surfaces.surface_id
evidence_source_reference_id -> ui-source-references.source_reference_id
```

| Column | Type | Required | Notes |
| --- | --- | --- | --- |
| `metadata_evidence_id` | text | yes | Deterministic child ID. |
| `surface_id` | text | yes | Related surface. |
| `metadata_field` | enum | yes | Reviewed metadata field. |
| `presence_state` | enum | yes | Presence result. |
| `observed_value` | text | no | Current observed value. |
| `observed_format` | text | no | Current observed format. |
| `agreement_state` | enum | yes | Cross-source agreement result. |
| `known_disagreement` | text | no | Concise explanation. |
| `evidence_source_reference_id` | text | no | Supporting source reference. |

Controlled metadata fields:

```text
human_readable_header
ui_key
blade_alias
implementation_path_reference
contract_path_reference
contract_schema_version
public_api_version
verification_commit
verification_timestamp
source_hash
contract_hash
last_updated
```

Controlled presence values:

```text
present
absent
unknown
not_applicable
```

Controlled agreement values:

```text
aligned
disagrees
partial
unknown
not_applicable
```

Deterministic ordering: `surface_id, metadata_field`.

## 11. `ui-dependencies.csv`

One row per dependency edge.

Header:

```csv
export_id,inventory_baseline_sha,source_schema_version,export_schema_version,dependency_id,surface_id,dependency_kind,dependency_target_surface_id,dependency_target_ui_key,dependency_path_or_value,relationship,required_state,resolution_state,evidence_source_reference_id
```

Primary key: `dependency_id`.

Foreign keys:

```text
surface_id -> ui-surfaces.surface_id
dependency_target_surface_id -> ui-surfaces.surface_id
evidence_source_reference_id -> ui-source-references.source_reference_id
```

| Column | Type | Required | Notes |
| --- | --- | --- | --- |
| `dependency_id` | text | yes | Deterministic edge ID. |
| `surface_id` | text | yes | Source surface. |
| `dependency_kind` | enum | yes | Dependency category. |
| `dependency_target_surface_id` | text | no | Related inventoried target. |
| `dependency_target_ui_key` | text | no | Target UI key when available. |
| `dependency_path_or_value` | text | no | Path, alias, asset, or unresolved value. |
| `relationship` | text | yes | Concise relationship description. |
| `required_state` | enum | yes | Required/optional state. |
| `resolution_state` | enum | yes | Resolution result. |
| `evidence_source_reference_id` | text | no | Supporting source reference. |

Suggested dependency kinds:

```text
lower_tier_surface
component
pattern
layout
blade_alias
css
javascript
icon
pictogram
asset
registration
module_contribution
other
```

Controlled `required_state`: `required`, `optional`, `conditional`, or `unknown`.

Controlled `resolution_state`: `resolved`, `missing`, `stale`, `ambiguous`, `unknown`, or `not_applicable`.

At least one of `dependency_target_surface_id` or `dependency_path_or_value` must be populated.

Deterministic ordering: `surface_id, dependency_kind, dependency_target_surface_id, dependency_path_or_value`.

## 12. `ui-source-references.csv`

Generic evidence table.

Header:

```csv
export_id,inventory_baseline_sha,source_schema_version,export_schema_version,source_reference_id,subject_type,subject_id,evidence_type,path,line_start,line_end,claim,exists_at_baseline,source_blob_oid,source_sha256
```

Primary key: `source_reference_id`.

| Column | Type | Required | Notes |
| --- | --- | --- | --- |
| `source_reference_id` | text | yes | Deterministic evidence ID. |
| `subject_type` | enum | yes | Related record family. |
| `subject_id` | text | yes | Related record ID. |
| `evidence_type` | enum | yes | Evidence category. |
| `path` | text | yes | Repository-relative path. |
| `line_start` | integer | no | Stable 1-based line when available. |
| `line_end` | integer | no | Stable 1-based line when available. |
| `claim` | text | yes | Concise evidence claim. |
| `exists_at_baseline` | boolean | yes | Whether source resolves at baseline. |
| `source_blob_oid` | text | no | Git blob OID. |
| `source_sha256` | text | no | SHA-256. |

Suggested `subject_type` values:

```text
surface
surface_file
mismatch
test_trace
standard_evidence
metadata_evidence
dependency
review_status
```

Suggested `evidence_type` values:

```text
implementation
contract
registration
test
standard
reference
example
route
css
javascript
asset
provenance
git
generated_observation
manual_review
other
```

Line numbers are 1-based. Leave unavailable line numbers empty; never use `0` for unknown.

Deterministic ordering: `subject_type, subject_id, path, line_start`.

## 13. `ui-review-status.csv`

One row per reviewed subject.

Header:

```csv
export_id,inventory_baseline_sha,source_schema_version,export_schema_version,review_status_id,subject_type,subject_id,reviewed,review_required,reviewer,reviewed_at_utc,review_note,source_fingerprint,stale_reason,pending_reason
```

Primary key: `review_status_id`.

| Column | Type | Required | Notes |
| --- | --- | --- | --- |
| `review_status_id` | text | yes | Deterministic review record ID. |
| `subject_type` | enum | yes | Reviewed record family. |
| `subject_id` | text | yes | Reviewed record ID. |
| `reviewed` | boolean | yes | Current reviewed state. |
| `review_required` | boolean | yes | Whether renewed review is required. |
| `reviewer` | text | no | Reviewer identity. |
| `reviewed_at_utc` | timestamp | no | Empty when `reviewed=false`. |
| `review_note` | text | no | Concise review note. |
| `source_fingerprint` | text | yes | Reviewed source fingerprint. |
| `stale_reason` | text | no | Reason prior review is stale. |
| `pending_reason` | text | no | Reason review remains pending. |

Suggested `subject_type` values:

```text
surface
test_trace
standard_evidence
metadata_evidence
dependency
mismatch
```

Rules:

- `reviewed_at_utc` must be empty when `reviewed=false`.
- Changed evidence may preserve reviewed values but should set `review_required=true`.
- Orphaned records remain visible until explicitly resolved.

Deterministic ordering: `subject_type, subject_id`.

## 14. Stable ID Requirements

Never use row numbers.

Preferred sources:

1. Existing accepted stable reviewed record ID.
2. Existing accepted trace ID.
3. Deterministic child ID derived from stable natural keys.

Examples:

```text
surface_file_id = hash(surface_id + file_role + path)
mismatch_id = hash(surface_id + mismatch_code + evidence_reference)
coverage_id = hash(trace_id + coverage_kind + coverage_value)
standard_evidence_id = hash(surface_id + standard_path)
metadata_evidence_id = hash(surface_id + metadata_field + evidence_reference)
dependency_id = hash(surface_id + dependency_kind + target)
source_reference_id = hash(subject_type + subject_id + evidence_type + path + line_start + claim)
review_status_id = hash(subject_type + subject_id)
```

The chosen algorithm must be documented and versioned.

## 15. Minimum Schema Validation

The future validator must fail when:

- required headers are missing, duplicated, or reordered;
- a primary key is blank or duplicated;
- a foreign key does not resolve;
- a controlled value is invalid;
- a boolean is not lowercase `true` or `false`;
- a timestamp is not valid UTC ISO 8601;
- a SHA-256 is not 64 hexadecimal characters;
- a path is absolute or contains `\\`;
- a child row lacks its parent;
- `aligned` coexists with another mismatch;
- manifest row counts do not match actual data rows;
- two exports from identical source data differ;
- row ordering is nondeterministic;
- formula-like free text is not neutralized for Excel;
- secret-bearing or runtime-only content is exported;
- SQLite row counts diverge from the validated CSV or accepted reviewed JSON.

## 16. SQLite Mapping Guidance

Use table names matching CSV base names with underscores:

```text
inventory_export_manifest
ui_surfaces
ui_surface_files
ui_mismatches
ui_test_traces
ui_test_trace_coverage
ui_standards_evidence
ui_metadata_evidence
ui_dependencies
ui_source_references
ui_review_status
```

SQLite should enforce:

- primary keys;
- foreign keys;
- controlled-value checks where practical;
- uniqueness constraints;
- text storage for IDs, hashes, SHAs, paths, and timestamps.

The SQLite database is generated, ignored, disposable, and never independently edited.
