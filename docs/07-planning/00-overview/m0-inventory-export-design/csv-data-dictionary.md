<!--
DOC-META
title: M0 UI Inventory CSV Data Dictionary
doc_type: matrix
status: draft
owner: docs
canonical: false
canonical_path: docs/07-planning/00-overview/m0-inventory-export-design/csv-data-dictionary.md
parent: docs/07-planning/00-overview/m0-inventory-export-design/README.md
template: docs/09-reference/templates/docs/_planning.md
summary: Human-readable column, key, controlled-value, mapping, and ordering dictionary generated from csv-schema.json.
-->

# M0 UI Inventory CSV Data Dictionary

Parent: [M0 UI Inventory Export Design](README.md)

## 1. Purpose

This document is the human-readable projection of `csv-schema.json` version `0.2.0`.

The JSON schema owns exact file names, header order, types, nullability, keys, controlled values, source roles, JSON pointers, transformations, and deterministic ordering.

## 2. Global Conventions

| Concern | Rule |
| --- | --- |
| Encoding | UTF-8 without BOM |
| Delimiter | Comma |
| Line endings | LF |
| Headers | Exactly one lowercase `snake_case` header row |
| CSV booleans | `true` / `false` |
| SQLite booleans | `0` / `1` |
| Optional scalar absence | Empty field |
| Semantic absence | Preserve `unknown`, `absent`, and `not_applicable` |
| Arrays and objects | Normalize into child rows or use an explicitly typed `_json` column |
| Formula safety | Prefix formula-like free text with an apostrophe in CSV only |
| Paths | Repository-relative with `/` |
| Ordering | Exact file `sort_order` using ordinal string comparison |

## 3. Source Roles

| Role | Authority |
| --- | --- |
| `classifications` | Reviewed surface and standard judgments |
| `observations` | Generated supporting evidence |
| `test_traces` | Reviewed trace judgments |

### 3.1. Source Pointer Syntax

| Concern | Rule |
| --- | --- |
| Kind | `json_pointer_glob` |
| Literal segments | Use RFC 6901 segment decoding: ~0 represents ~ and ~1 represents /. |
| `*` | * matches exactly one array element or object member segment. |
| `**` | ** matches zero or more descendant segments. |
| Relative pointers | subject_id_pointer and evidence_pointers are evaluated relative to each record matched by record_pointer. |
| Evaluation | Evaluate every pattern only against its declared source_role; preserve source array order before deterministic output sorting. |

### 3.2. Source Reference Bindings

Only explicitly bound reviewed record families may emit `ui-source-references.csv` rows.

| Subject type | Source role | Record pointer | Subject ID | Evidence pointers |
| --- | --- | --- | --- | --- |
| `surface` | `classifications` | `/items/*` | pointer /_record_id | `/evidence_source/*`<br>`/icon_or_asset_dependencies/*/evidence_source/*`<br>`/metadata_evidence/evidence_source/*`<br>`/registration_evidence/*/evidence_source/*`<br>`/standards_evidence/*/evidence_source/*` |
| `standard` | `classifications` | `/standard_reviews/*` | transform standard_id_from__standard_path | `/evidence_source/*` |
| `test_trace` | `test_traces` | `/test_traces/*` | pointer /_trace_id | `/evidence_source/*` |
### 3.3. Evidence Token Parsing

`evidence_raw` preserves the complete accepted evidence token. Parsed fields are convenience projections and never replace the raw token.

| Rule | Evidence kind | Evidence value |
| --- | --- | --- |
| prefix path: | `path` | substring after path: |
| prefix path-pattern: | `path_pattern` | substring after path-pattern: |
| prefix observation: | `observation` | substring after observation: |
| prefix issue-<decimal issue number>: | `issue` | substring after the issue-qualified prefix; evidence_raw retains the issue number |
| prefix command: | `command` | substring after command: |
| prefix git: | `git` | substring after git: |
| prefix manual-review: or manual_review: | `manual_review` | substring after the matched prefix |
| otherwise | `other` | complete evidence_raw token |

## 4. Files


### 4.1. `inventory-export-manifest.csv`

One row per generated CSV other than the manifest itself.

Header:

```csv
export_id,inventory_type,inventory_baseline_sha,source_set_sha256,export_schema_version,export_file,row_count,exported_at_utc,generator_version,encoding,delimiter,line_ending,status
```

Primary key: `export_id + export_file`


Deterministic order: `export_file`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes | yes |  |  | derived | Deterministic export-run identifier. |
| `inventory_type` | `string` | yes |  |  | ui | derived: classifications /issue | Inventory domain represented by the export. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline. |
| `source_set_sha256` | `sha256` | yes |  |  |  | derived | Hash of the ordered source-role and source-artifact hash set. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Projection schema version. |
| `export_file` | `string` | yes | yes |  |  | derived | Generated CSV filename. |
| `row_count` | `integer` | yes |  |  |  | derived | Number of data rows excluding the header. |
| `exported_at_utc` | `utc_timestamp` | yes |  |  |  | derived | UTC export timestamp; excluded from byte-determinism comparisons. |
| `generator_version` | `string` | yes |  |  |  | derived | Exporter implementation version. |
| `encoding` | `string` | yes |  |  | utf-8 | derived | CSV text encoding. |
| `delimiter` | `string` | yes |  |  | comma | derived | Logical delimiter name. |
| `line_ending` | `string` | yes |  |  | lf | derived | Logical line-ending name. |
| `status` | `string` | yes |  |  | complete, partial, failed | derived | Completion state for this generated file. |

### 4.2. `inventory-export-sources.csv`

One row per Issue #30 source artifact used by an export.

Header:

```csv
export_id,source_id,source_role,source_artifact_path,source_artifact_sha256,source_schema_version,source_generator_schema_version,authoritative,required
```

Primary key: `source_id`


Deterministic order: `source_role, source_artifact_path`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic export-run identifier. |
| `source_id` | `string` | yes | yes |  |  | derived | Deterministic source-artifact identifier. |
| `source_role` | `string` | yes |  |  | classifications, observations, test_traces | derived | Role of the Issue #30 source artifact. |
| `source_artifact_path` | `string` | yes |  |  |  | derived | Repository-relative accepted source-artifact path. |
| `source_artifact_sha256` | `sha256` | yes |  |  |  | derived | SHA-256 digest of the source artifact. |
| `source_schema_version` | `integer` | yes |  |  |  | confirmed: classifications; observations; test_traces /schema_version | Accepted source artifact schema_version. |
| `source_generator_schema_version` | `integer` | no |  |  |  | confirmed: classifications; observations; test_traces /generator_schema_version | Accepted source artifact generator_schema_version when present. |
| `authoritative` | `boolean` | yes |  |  |  | derived | Whether the artifact owns reviewed judgments. |
| `required` | `boolean` | yes |  |  |  | derived | Whether the artifact is required for this projection. |

### 4.3. `ui-surfaces.csv`

One row per reviewed material UI surface.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,surface_id,ui_key,current_slug,surface_type,ownership_area,owner_key,capability_key,module_key,primary_blade_alias,implementation_entry,contract_status,carbon_provenance,test_status,test_authority,inventory_disposition,target_question,registration_evidence_json,public_api_evidence_json,contract_api_evidence_json,app_owned_deviations_json,lifecycle_claim_json,review_claim_json,accessibility_evidence_json,responsive_evidence_json,browser_evidence_json,source_fingerprint
```

Primary key: `surface_id`


Deterministic order: `surface_id`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `surface_id` | `string` | yes | yes |  |  | confirmed: classifications /items/*/_record_id | Stable accepted Issue #30 surface record ID. |
| `ui_key` | `string` | yes |  |  |  | confirmed: classifications /items/*/ui_key | Reviewed UI key or controlled semantic literal. |
| `current_slug` | `string` | yes |  |  |  | confirmed: classifications /items/*/current_slug | Reviewed current slug. |
| `surface_type` | `string` | yes |  |  | element, primitive, component, component_family, subcomponent, pattern, layout, shell, navigation, url_view, renderer, view_model, page_data, ui_contribution, compatibility_alias, css_control, javascript_control, icon_system, pictogram_system | confirmed: classifications /items/*/surface_type | Reviewed material surface type. |
| `ownership_area` | `string` | yes |  |  | core, module, ui, not_applicable, unknown | confirmed: classifications /items/*/ownership_area | Reviewed application ownership area. |
| `owner_key` | `string` | yes |  |  |  | confirmed: classifications /items/*/owner_key | Reviewed owner key. |
| `capability_key` | `string` | yes |  |  |  | confirmed: classifications /items/*/capability_key | Reviewed capability key. |
| `module_key` | `string` | yes |  |  |  | confirmed: classifications /items/*/module_key | Reviewed Module key or semantic literal. |
| `primary_blade_alias` | `string` | yes |  |  |  | derived: classifications; observations /items/*/blade_alias; /surfaces/*/blade_aliases; /surfaces/*/implementation_entry | Direct alias when scalar, implementation-entry alias when deterministically derivable, or semantic literal. |
| `implementation_entry` | `string` | yes |  |  |  | confirmed: classifications /items/*/implementation_entry | Primary repository-relative implementation entry. |
| `contract_status` | `string` | yes |  |  | present, missing, multiple, variation, unresolved, not_applicable, unknown | confirmed: classifications /items/*/contract_status | Reviewed current contract presence and condition. |
| `carbon_provenance` | `string` | yes |  |  | carbon_direct_port, carbon_api_adaptation, carbon_visual_reference, carbon_behavior_reference, app_owned, mixed, unknown, not_applicable | confirmed: classifications /items/*/carbon_provenance | Reviewed Carbon provenance classification. |
| `test_status` | `string` | yes |  |  | passing, failing, mixed, warning, not_run, missing, unknown, not_applicable | confirmed: classifications /items/*/test_status | Reviewed surface-level test result summary. |
| `test_authority` | `string` | yes |  |  | authoritative, partial, incidental, stale, unknown, not_applicable | confirmed: classifications /items/*/test_authority | Reviewed surface-level test-authority summary. |
| `inventory_disposition` | `string` | yes |  |  | retain, compatibility, duplicate, investigate | confirmed: classifications /items/*/inventory_disposition | Issue #30 inventory-only disposition. |
| `target_question` | `string` | yes |  |  |  | confirmed: classifications /items/*/target_question | Open target-state question retained for later ownership. |
| `registration_evidence_json` | `json_text` | yes |  |  |  | confirmed: classifications /items/*/registration_evidence | Canonical compact JSON for structured registration evidence. |
| `public_api_evidence_json` | `json_text` | yes |  |  |  | confirmed: classifications /items/*/public_api_evidence | Canonical compact JSON for structured public API evidence. |
| `contract_api_evidence_json` | `json_text` | yes |  |  |  | confirmed: classifications /items/*/contract_api_evidence | Canonical compact JSON for structured contract API evidence. |
| `app_owned_deviations_json` | `json_text` | yes |  |  |  | confirmed: classifications /items/*/app_owned_deviations | Canonical compact JSON for app-owned deviations. |
| `lifecycle_claim_json` | `json_text` | yes |  |  |  | confirmed: classifications /items/*/lifecycle_claim | Canonical compact JSON for lifecycle claims. |
| `review_claim_json` | `json_text` | yes |  |  |  | confirmed: classifications /items/*/review_claim | Canonical compact JSON for review claims. |
| `accessibility_evidence_json` | `json_text` | yes |  |  |  | confirmed: classifications /items/*/accessibility_evidence | Canonical compact JSON for accessibility evidence. |
| `responsive_evidence_json` | `json_text` | yes |  |  |  | confirmed: classifications /items/*/responsive_evidence | Canonical compact JSON for responsive evidence. |
| `browser_evidence_json` | `json_text` | yes |  |  |  | confirmed: classifications /items/*/browser_evidence | Canonical compact JSON for browser evidence. |
| `source_fingerprint` | `sha256` | yes |  |  |  | confirmed: classifications /items/*/_source_fingerprint | Reviewed source fingerprint used for staleness detection. |

### 4.4. `ui-surface-aliases.csv`

One row per normalized Blade alias.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,surface_alias_id,surface_id,alias_type,alias_value,is_primary
```

Primary key: `surface_alias_id`


Foreign keys:

- `surface_id` → `ui-surfaces.csv.surface_id`


Deterministic order: `surface_id, alias_type, alias_value`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `surface_alias_id` | `string` | yes | yes |  |  | derived | Deterministic alias relationship ID. |
| `surface_id` | `string` | yes |  | `ui-surfaces.surface_id` |  | confirmed: classifications /items/*/_record_id | Owning surface ID. |
| `alias_type` | `string` | yes |  |  | blade_alias | derived | Alias category. |
| `alias_value` | `string` | yes |  |  |  | derived: classifications /items/*/blade_alias | One normalized alias value. |
| `is_primary` | `boolean` | yes |  |  |  | derived | Whether this alias matches the deterministic primary alias. |

### 4.5. `ui-surface-files.csv`

One row per repository file associated with a reviewed surface.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,surface_file_id,surface_id,file_role,path,is_primary,exists_at_baseline,source_blob_oid,source_sha256
```

Primary key: `surface_file_id`


Foreign keys:

- `surface_id` → `ui-surfaces.csv.surface_id`


Deterministic order: `surface_id, file_role, path`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `surface_file_id` | `string` | yes | yes |  |  | derived | Deterministic surface-to-file relationship ID. |
| `surface_id` | `string` | yes |  | `ui-surfaces.surface_id` |  | confirmed: classifications /items/*/_record_id | Owning surface ID. |
| `file_role` | `string` | yes |  |  | implementation_entry, implementation_support, contract, reference, example, css, javascript, test | derived | Role of the repository file. |
| `path` | `string` | yes |  |  |  | derived: classifications /items/*/implementation_entry; /items/*/implementation_support_files/*; /items/*/contract_path/*; /items/*/reference_path/*; /items/*/example_paths/*; /items/*/css_paths/*; /items/*/javascript_paths/*; /items/*/test_paths/* | Repository-relative path using forward slashes. |
| `is_primary` | `boolean` | yes |  |  |  | derived | Whether this row is the implementation entry. |
| `exists_at_baseline` | `boolean` | yes |  |  |  | derived: observations /surfaces/*/implementation_entry; /surfaces/*/implementation_support_files | Whether observations confirm physical presence at the immutable baseline. |
| `source_blob_oid` | `string` | no |  |  |  | derived: observations /surfaces/*/**/object_sha | Git blob OID when available. |
| `source_sha256` | `sha256` | no |  |  |  | derived: observations /surfaces/*/**/source_sha256 | Source content SHA-256 when available. |

### 4.6. `ui-mismatches.csv`

One row per reviewed surface mismatch classification.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,mismatch_id,surface_id,mismatch_code
```

Primary key: `mismatch_id`


Foreign keys:

- `surface_id` → `ui-surfaces.csv.surface_id`


Deterministic order: `surface_id, mismatch_code`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `mismatch_id` | `string` | yes | yes |  |  | derived | Deterministic mismatch relationship ID. |
| `surface_id` | `string` | yes |  | `ui-surfaces.surface_id` |  | confirmed: classifications /items/*/_record_id | Owning surface ID. |
| `mismatch_code` | `string` | yes |  |  | aligned, contract_missing, contract_stale, implementation_stale, standard_stale, test_missing, test_stale, test_incomplete, reference_missing, reference_stale, example_missing, example_stale, registration_missing, registration_stale, duplicate_identity, owner_mismatch, blade_alias_mismatch, source_path_mismatch, dependency_mismatch, provenance_unknown, review_unknown, lifecycle_conflict, accessibility_evidence_missing, browser_evidence_missing, responsive_evidence_missing, investigate | derived: classifications /items/*/known_mismatches/* | Accepted Issue #30 mismatch classification. |

### 4.7. `ui-test-traces.csv`

One row per reviewed UI surface-to-test relationship.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,trace_id,surface_id,surface_ui_key,test_path,test_exists,test_type,current_result,test_authority,relationship_kind,relationship_value,accessibility_coverage_state,javascript_coverage_state,contract_fields_covered_count,rendered_states_covered_count,source_fingerprint
```

Primary key: `trace_id`


Foreign keys:

- `surface_id` → `ui-surfaces.csv.surface_id`


Deterministic order: `surface_id, test_path, trace_id`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `trace_id` | `string` | yes | yes |  |  | confirmed: test_traces /test_traces/*/_trace_id | Stable accepted Issue #30 trace ID. |
| `surface_id` | `string` | yes |  | `ui-surfaces.surface_id` |  | confirmed: test_traces /test_traces/*/_surface_record_id | Related surface record ID. |
| `surface_ui_key` | `string` | yes |  |  |  | confirmed: test_traces /test_traces/*/surface_ui_key | Surface UI key duplicated for filtering. |
| `test_path` | `string` | yes |  |  |  | confirmed: test_traces /test_traces/*/test_path | Repository-relative test path. |
| `test_exists` | `boolean` | yes |  |  |  | confirmed: test_traces /test_traces/*/test_exists | Whether the test exists at the immutable baseline. |
| `test_type` | `string` | yes |  |  | contract schema, API rendering, prop behavior, slot behavior, variant rendering, state rendering, class contract, accessibility, JavaScript behavior, browser, visual, snapshot, integration, incidental markup assertion, unknown | confirmed: test_traces /test_traces/*/test_type | Reviewed test type. |
| `current_result` | `string` | yes |  |  | passed, failed, warning, not_run, missing, unknown | confirmed: test_traces /test_traces/*/current_result | Reviewed current test result. |
| `test_authority` | `string` | yes |  |  | authoritative, partial, incidental, stale, unknown, not_applicable | confirmed: test_traces /test_traces/*/test_authority | Reviewed trace authority. |
| `relationship_kind` | `string` | yes |  |  | owner_local_test, exact_repository_path_reference, exact_blade_alias_reference, exact_ui_key_reference, exact_symbol_reference | confirmed: test_traces /test_traces/*/_relationship_evidence/kind | Semantic reason the test is linked to the surface. |
| `relationship_value` | `string` | yes |  |  |  | confirmed: test_traces /test_traces/*/_relationship_evidence/value | Exact path, alias, key, root, or symbol supporting the relationship. |
| `accessibility_coverage_state` | `string` | yes |  |  | present_claim, not_observed, unknown | confirmed: test_traces /test_traces/*/accessibility_behavior_covered | Categorical accessibility-coverage evidence state. |
| `javascript_coverage_state` | `string` | yes |  |  | present_claim, not_observed, unknown | confirmed: test_traces /test_traces/*/javascript_behavior_covered | Categorical JavaScript-coverage evidence state. |
| `contract_fields_covered_count` | `integer` | yes |  |  |  | derived: test_traces /test_traces/*/contract_fields_covered | Count of normalized contract-field coverage rows. |
| `rendered_states_covered_count` | `integer` | yes |  |  |  | derived: test_traces /test_traces/*/rendered_states_covered | Count of normalized rendered-state coverage rows. |
| `source_fingerprint` | `sha256` | yes |  |  |  | confirmed: test_traces /test_traces/*/_source_fingerprint | Reviewed trace source fingerprint. |

### 4.8. `ui-test-trace-coverage.csv`

One row per contract field or rendered state covered by a trace.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,coverage_id,trace_id,coverage_kind,coverage_value
```

Primary key: `coverage_id`


Foreign keys:

- `trace_id` → `ui-test-traces.csv.trace_id`


Deterministic order: `trace_id, coverage_kind, coverage_value`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `coverage_id` | `string` | yes | yes |  |  | derived | Deterministic trace coverage ID. |
| `trace_id` | `string` | yes |  | `ui-test-traces.trace_id` |  | confirmed: test_traces /test_traces/*/_trace_id | Owning trace ID. |
| `coverage_kind` | `string` | yes |  |  | contract_field, rendered_state | derived | Normalized coverage array category. |
| `coverage_value` | `string` | yes |  |  |  | derived: test_traces /test_traces/*/contract_fields_covered/*; /test_traces/*/rendered_states_covered/* | One covered field or rendered state. |

### 4.9. `ui-standards.csv`

One row per unique reviewed UI standard.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,standard_id,standard_path,standard_source_fingerprint,claimed_scope,implementation_alignment,contract_alignment,reference_or_example_alignment,authority_state
```

Primary key: `standard_id`


Deterministic order: `standard_path`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `standard_id` | `string` | yes | yes |  |  | derived | Deterministic stable ID derived from standard_path. |
| `standard_path` | `string` | yes |  |  |  | confirmed: classifications /standard_reviews/*/_standard_path | Repository-relative unique reviewed standard path. |
| `standard_source_fingerprint` | `sha256` | yes |  |  |  | confirmed: classifications /standard_reviews/*/_source_fingerprint | Reviewed standard source fingerprint. |
| `claimed_scope` | `string` | yes |  |  |  | confirmed: classifications /standard_reviews/*/claimed_scope | Reviewed scope claimed by the standard. |
| `implementation_alignment` | `string` | yes |  |  | aligned, partial, stale, not_applicable, unknown | confirmed: classifications /standard_reviews/*/implementation_alignment | Reviewed implementation alignment. |
| `contract_alignment` | `string` | yes |  |  | aligned, partial, stale, not_applicable, unknown | confirmed: classifications /standard_reviews/*/contract_alignment | Reviewed contract alignment. |
| `reference_or_example_alignment` | `string` | yes |  |  | aligned, partial, stale, not_applicable, unknown | confirmed: classifications /standard_reviews/*/reference_or_example_alignment | Reviewed reference/example alignment. |
| `authority_state` | `string` | yes |  |  | current_standard, mixed_authority, historical_or_rollout_guidance, stale, unknown | confirmed: classifications /standard_reviews/*/authority_state | Reviewed authority state. |

### 4.10. `ui-surface-standards.csv`

One row per reviewed surface-to-standard projection.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,surface_standard_id,surface_id,standard_id,standard_source_fingerprint
```

Primary key: `surface_standard_id`


Foreign keys:

- `surface_id` → `ui-surfaces.csv.surface_id`
- `standard_id` → `ui-standards.csv.standard_id`


Deterministic order: `surface_id, standard_id`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `surface_standard_id` | `string` | yes | yes |  |  | derived | Deterministic surface-to-standard relationship ID. |
| `surface_id` | `string` | yes |  | `ui-surfaces.surface_id` |  | confirmed: classifications /items/*/_record_id | Linked surface ID. |
| `standard_id` | `string` | yes |  | `ui-standards.standard_id` |  | derived: classifications /items/*/standards_evidence/*/standard_path | Linked unique standard ID. |
| `standard_source_fingerprint` | `sha256` | yes |  |  |  | confirmed: classifications /items/*/standards_evidence/*/standard_source_fingerprint | Fingerprint projected into the linked surface. |

### 4.11. `ui-standard-findings.csv`

One row per reviewed standard staleness or moved-responsibility finding.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,standard_finding_id,standard_id,finding_kind,finding_value
```

Primary key: `standard_finding_id`


Foreign keys:

- `standard_id` → `ui-standards.csv.standard_id`


Deterministic order: `standard_id, finding_kind, finding_value`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `standard_finding_id` | `string` | yes | yes |  |  | derived | Deterministic normalized standard finding ID. |
| `standard_id` | `string` | yes |  | `ui-standards.standard_id` |  | derived: classifications /standard_reviews/*/_standard_path | Owning unique standard ID. |
| `finding_kind` | `string` | yes |  |  | staleness_evidence, moved_responsibility | derived | Normalized standard finding category. |
| `finding_value` | `string` | yes |  |  |  | derived: classifications /standard_reviews/*/staleness_evidence/*; /standard_reviews/*/moved_responsibilities/* | One reviewed standard finding. |

### 4.12. `ui-metadata-evidence.csv`

One row per reviewed metadata field and surface, preserving both implementation and contract lanes.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,metadata_evidence_id,surface_id,metadata_field,implementation_present_count,implementation_absent_count,implementation_unknown_count,implementation_not_applicable_count,implementation_values_json,implementation_formats_json,implementation_present_paths_json,contract_present_count,contract_absent_count,contract_unknown_count,contract_not_applicable_count,contract_values_json,contract_formats_json,contract_present_paths_json,known_disagreement_json
```

Primary key: `metadata_evidence_id`


Foreign keys:

- `surface_id` → `ui-surfaces.csv.surface_id`


Deterministic order: `surface_id, metadata_field`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `metadata_evidence_id` | `string` | yes | yes |  |  | derived | Deterministic metadata field observation ID. |
| `surface_id` | `string` | yes |  | `ui-surfaces.surface_id` |  | confirmed: classifications /items/*/_record_id | Owning surface ID. |
| `metadata_field` | `string` | yes |  |  | human_readable_header, ui_key, blade_alias, implementation_path_reference, contract_path_reference, contract_schema_version, public_api_version, verification_commit, verification_timestamp, source_hash, contract_hash, last_updated | derived: classifications /items/*/metadata_evidence | Metadata field being evaluated. |
| `implementation_present_count` | `integer` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/implementation/present_count | Implementation lane present count. |
| `implementation_absent_count` | `integer` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/implementation/absent_count | Implementation lane absent count. |
| `implementation_unknown_count` | `integer` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/implementation/unknown_count | Implementation lane unknown count. |
| `implementation_not_applicable_count` | `integer` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/implementation/not_applicable_count | Implementation lane not applicable count. |
| `implementation_values_json` | `json_text` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/implementation/values | Canonical compact JSON for implementation values. |
| `implementation_formats_json` | `json_text` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/implementation/formats | Canonical compact JSON for implementation formats. |
| `implementation_present_paths_json` | `json_text` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/implementation/present_paths | Canonical compact JSON for implementation present paths. |
| `contract_present_count` | `integer` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/contract/present_count | Contract lane present count. |
| `contract_absent_count` | `integer` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/contract/absent_count | Contract lane absent count. |
| `contract_unknown_count` | `integer` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/contract/unknown_count | Contract lane unknown count. |
| `contract_not_applicable_count` | `integer` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/contract/not_applicable_count | Contract lane not applicable count. |
| `contract_values_json` | `json_text` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/contract/values | Canonical compact JSON for contract values. |
| `contract_formats_json` | `json_text` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/contract/formats | Canonical compact JSON for contract formats. |
| `contract_present_paths_json` | `json_text` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/{metadata_field}/contract/present_paths | Canonical compact JSON for contract present paths. |
| `known_disagreement_json` | `json_text` | yes |  |  |  | derived: classifications /items/*/metadata_evidence/known_disagreements/* | Canonical compact JSON for this field's known disagreement or null. |

### 4.13. `ui-dependencies.csv`

One row per reviewed lower-tier, component, icon, asset, or other dependency.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,dependency_id,surface_id,dependency_kind,dependency_target_surface_id,dependency_target_ui_key,dependency_path_or_value,dependency_payload_json
```

Primary key: `dependency_id`


Foreign keys:

- `surface_id` → `ui-surfaces.csv.surface_id`
- `dependency_target_surface_id` → `ui-surfaces.csv.surface_id`


Deterministic order: `surface_id, dependency_kind, dependency_target_surface_id, dependency_path_or_value`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `dependency_id` | `string` | yes | yes |  |  | derived | Deterministic dependency edge ID. |
| `surface_id` | `string` | yes |  | `ui-surfaces.surface_id` |  | confirmed: classifications /items/*/_record_id | Source surface ID. |
| `dependency_kind` | `string` | yes |  |  | lower_tier_surface, component, icon, asset, other | derived: classifications /items/*/lower_tier_dependencies/*; /items/*/icon_or_asset_dependencies/* | Normalized dependency category. |
| `dependency_target_surface_id` | `string` | no |  | `ui-surfaces.surface_id` |  | derived: classifications; observations /items/*/lower_tier_dependencies/*; /surfaces/*/blade_aliases/* | Resolved target surface ID when the dependency maps to another inventoried surface. |
| `dependency_target_ui_key` | `string` | no |  |  |  | derived: classifications /items/*/ui_key | Resolved target UI key when available. |
| `dependency_path_or_value` | `string` | no |  |  |  | derived: classifications /items/*/lower_tier_dependencies/*; /items/*/icon_or_asset_dependencies/* | Path, Blade alias, icon name, asset name, or unresolved dependency value. |
| `dependency_payload_json` | `json_text` | yes |  |  |  | derived: classifications /items/*/lower_tier_dependencies/*; /items/*/icon_or_asset_dependencies/* | Canonical compact JSON of the exact accepted dependency value. |

### 4.14. `ui-source-references.csv`

One row per exact accepted evidence token emitted by an explicit reviewed-record binding.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,source_reference_id,subject_type,subject_id,evidence_raw,evidence_kind,evidence_value,path,line_start,line_end,existence_state,source_blob_oid,source_sha256
```

Primary key: `source_reference_id`


Deterministic order: `subject_type, subject_id, evidence_raw, line_start, line_end`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `source_reference_id` | `string` | yes | yes |  |  | derived | Deterministic evidence reference ID. |
| `subject_type` | `string` | yes |  |  | surface, standard, test_trace | derived | Record family supported by the evidence. |
| `subject_id` | `string` | yes |  |  |  | derived | Identifier of the supported output record. |
| `evidence_raw` | `string` | yes |  |  |  | confirmed: classifications; test_traces /items/*/evidence_source/*; /items/*/registration_evidence/*/evidence_source/*; /standard_reviews/*/evidence_source/*; /test_traces/*/evidence_source/* | Complete accepted evidence-source token preserved without prefix loss. |
| `evidence_kind` | `string` | yes |  |  | path, path_pattern, observation, issue, command, git, manual_review, other | derived: classifications; test_traces /items/*/evidence_source/*; /items/*/registration_evidence/*/evidence_source/*; /standard_reviews/*/evidence_source/*; /test_traces/*/evidence_source/* | Parsed evidence-reference category. |
| `evidence_value` | `string` | yes |  |  |  | derived: classifications; test_traces /items/*/evidence_source/*; /items/*/registration_evidence/*/evidence_source/*; /standard_reviews/*/evidence_source/*; /test_traces/*/evidence_source/* | Exact accepted evidence-source value after the prefix. |
| `path` | `string` | no |  |  |  | derived: classifications; test_traces /items/*/evidence_source/*; /items/*/registration_evidence/*/evidence_source/*; /standard_reviews/*/evidence_source/*; /test_traces/*/evidence_source/* | Repository-relative path for path evidence. |
| `line_start` | `integer` | no |  |  |  | pending | Optional one-based evidence start line. |
| `line_end` | `integer` | no |  |  |  | pending | Optional one-based evidence end line. |
| `existence_state` | `string` | yes |  |  | present, absent, unknown, not_applicable | derived: observations /surfaces/*/** | Physical-source existence state where applicable. |
| `source_blob_oid` | `string` | no |  |  |  | derived: observations /surfaces/*/**/object_sha | Git blob OID when available. |
| `source_sha256` | `sha256` | no |  |  |  | derived: observations /surfaces/*/**/source_sha256 | Source SHA-256 when available. |
### 4.15. `ui-review-status.csv`

One row per independently reviewed surface, standard, or test trace.

Header:

```csv
export_id,inventory_baseline_sha,export_schema_version,review_status_id,subject_type,subject_id,reviewed,review_required,reviewer,reviewed_at_utc,review_note,source_fingerprint,review_source_role
```

Primary key: `review_status_id`


Deterministic order: `subject_type, subject_id`

| Column | Type | Required | PK | FK | Controlled values | Source mapping | Description |
| --- | --- | --- | --- | --- | --- | --- | --- |
| `export_id` | `string` | yes |  |  |  | derived | Deterministic identifier for one export run. |
| `inventory_baseline_sha` | `git_sha` | yes |  |  |  | derived: classifications; observations; test_traces /baseline_sha; /baseline/sha | Immutable Issue #30 evidence baseline commit SHA. |
| `export_schema_version` | `string` | yes |  |  |  | derived | Version of this CSV/SQLite projection schema. |
| `review_status_id` | `string` | yes | yes |  |  | derived | Deterministic review record ID. |
| `subject_type` | `string` | yes |  |  | surface, standard, test_trace | derived | Independently reviewed Issue #30 record family. |
| `subject_id` | `string` | yes |  |  |  | derived | Reviewed subject ID. |
| `reviewed` | `boolean` | yes |  |  |  | confirmed: classifications; test_traces /items/*/_reviewed; /standard_reviews/*/_reviewed; /test_traces/*/_reviewed | Whether the subject received human review. |
| `review_required` | `boolean` | yes |  |  |  | confirmed: classifications; test_traces /items/*/_review_required; /standard_reviews/*/_review_required; /test_traces/*/_review_required | Whether the subject currently requires review or re-review. |
| `reviewer` | `string` | no |  |  |  | derived: classifications; test_traces /reviewer | Artifact-level reviewer identifier. |
| `reviewed_at_utc` | `utc_timestamp` | no |  |  |  | derived: classifications; test_traces /reviewed_at | Artifact-level UTC review timestamp. |
| `review_note` | `string` | no |  |  |  | confirmed: classifications; test_traces /items/*/_review_note; /standard_reviews/*/_review_note; /test_traces/*/_review_note | Human review note retained across regeneration. |
| `source_fingerprint` | `sha256` | yes |  |  |  | confirmed: classifications; test_traces /items/*/_source_fingerprint; /standard_reviews/*/_source_fingerprint; /test_traces/*/_source_fingerprint | Reviewed source fingerprint. |
| `review_source_role` | `string` | yes |  |  | classifications, test_traces | derived | Reviewed artifact owning the review metadata. |

## 5. Stable Derived IDs

Derived IDs use the algorithm in `csv-schema.json`.

Natural keys:

| Record | Natural key |
| --- | --- |
| Source artifact | `source_role`, `source_artifact_path`, `source_artifact_sha256` |
| Surface alias | `surface_id`, `alias_type`, `alias_value` |
| Surface file | `surface_id`, `file_role`, `path` |
| Mismatch | `surface_id`, `mismatch_code` |
| Trace coverage | `trace_id`, `coverage_kind`, `coverage_value` |
| Standard | `standard_path` |
| Surface-standard link | `surface_id`, `standard_path` |
| Standard finding | `standard_id`, `finding_kind`, `finding_value` |
| Metadata evidence | `surface_id`, `metadata_field` |
| Dependency | `surface_id`, `dependency_kind`, target identity, canonical payload |
| Source reference | `subject_type`, `subject_id`, `evidence_raw`, line range |
| Review status | `subject_type`, `subject_id` |

## 6. Review Boundary

Independent review records exist only for:

```text
surface
standard
test_trace
```

All other records inherit the reviewed source record from which they are normalized.
