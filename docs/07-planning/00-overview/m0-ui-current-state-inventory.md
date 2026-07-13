<!--
DOC-META
title: M0 UI Current-State Inventory
doc_type: planning
status: active
owner: ui
canonical: true
canonical_path: docs/07-planning/00-overview/m0-ui-current-state-inventory.md
parent: docs/07-planning/index.md
summary: Provides the pinned issue #30 inventory of material UI implementation surfaces, contracts, tests, standards, metadata, registration, provenance, contradictions, and target questions.
-->

# M0 UI Current-State Inventory

Parent: [Planning Index](../index.md)

## 1. Purpose

Provide the authoritative implementation-first current-state UI inventory required by GitHub issue #30 and M0 Goal 02.

This inventory records what exists at the pinned baseline and whether contract, test, standard, reference, registration, provenance, review, and metadata claims agree with implementation. It does not redesign UI, approve reuse readiness, rewrite contracts or standards, create missing tests, or select target paths.

## 2. Status And Baseline

- Inventory baseline commit: `1d103f5fa47aab8c8adfba8ea134dd29540426fe`
- Inventory baseline date: 2026-07-10T22:27:59-04:00
- Inventory generated at: 2026-07-13T14:18:28.263Z
- Current branch HEAD at collection: `a6c1c720c8985247609a52eca7b9ac71218bac1d`
- Expected execution base when the package was prepared: `0ead8c7b1e0e6ba447a5da6376ff27884daabcc7`
- UI source changed between inventory baseline and expected execution base: no
- UI-source comparison command: `git diff --name-only 1d103f5fa47aab8c8adfba8ea134dd29540426fe 0ead8c7b1e0e6ba447a5da6376ff27884daabcc7 -- resources Modules app/Surfaces/Contracts app/Platform/Dashboard app/Platform/Navigation app/Platform/Shell app/Platform/Docs app/Livewire/Platform app/Http/Controllers/Platform app/Core/Modules/Definitions.php app/Core/Modules/Definitions app/Core/Modules/Manifest.php app/Core/Modules/UiEntry.php app/Core/Modules/UiEntryType.php app/Core/Modules/UiPlacement.php app/Core/Modules/PackageRegistrar.php app/Core/Modules/PackageLoader.php app/Core/Modules/Repository.php routes/web.php config/navigation.php vite.config.js tests/Feature/Ui tests/Feature/Patterns docs/02-standards/ui docs/09-reference/ui`
- Material surface records: 318
- Reviewed material surfaces: 318/318
- Detailed UI test traces: 85
- Reviewed test traces: 85/85
- Reviewed unique standards: 46/46
- Surfaces with material mismatch evidence: 216

The inventory baseline is immutable for issue #30. The execution-base commit is only the accepted `main` from which the issue branch was created.

## 3. Evidence Method

1. Read only the configured UI-specific Git roots at the pinned baseline.
2. Read Git blobs through one batched object stream rather than one subprocess per file.
3. Group files into material UI surfaces, component families, URL views, contributions, and independently governed controls.
4. Keep generated observations separate from reviewed classifications and detailed test traces.
5. Preserve reviewed values when observations are recollected and mark changed evidence for re-review.
6. Preserve failed or unavailable runtime-discovery evidence instead of replacing it with `skipped`.
7. Render this document only from persisted evidence artifacts without rescanning source.

Implementation evidence is reviewed before contracts, tests, standards, references, examples, and rendered evidence. A file existing does not prove registration or reachability.

## 4. Evidence Artifacts

- `docs/07-planning/00-overview/evidence/m0-ui-current-state-observations.json` — deterministic generated observations.
- `docs/07-planning/00-overview/evidence/m0-ui-current-state-classifications.json` — reviewed material-surface classifications.
- `docs/07-planning/00-overview/evidence/m0-ui-current-state-test-traces.json` — reviewed UI surface-to-test traces; issue #32 retains complete suite ownership.

The JSON classifications contain every required issue field. The compact tables below are deterministic projections for review.

## 5. Summary

### Surface Types

| Value | Count |
| --- | ---: |
| `component` | 99 |
| `component_family` | 2 |
| `css_control` | 9 |
| `element` | 6 |
| `icon_system` | 1 |
| `javascript_control` | 56 |
| `layout` | 5 |
| `navigation` | 7 |
| `pattern` | 45 |
| `pictogram_system` | 1 |
| `renderer` | 6 |
| `shell` | 8 |
| `ui_contribution` | 22 |
| `url_view` | 46 |
| `view_model` | 5 |

### Ownership Areas

| Value | Count |
| --- | ---: |
| `core` | 62 |
| `ui` | 228 |
| `unknown` | 28 |

### Contract Status

| Value | Count |
| --- | ---: |
| `missing` | 187 |
| `present` | 129 |
| `variation` | 2 |

### Inventory Disposition

| Value | Count |
| --- | ---: |
| `investigate` | 206 |
| `retain` | 112 |

### Test Status

| Value | Count |
| --- | ---: |
| `missing` | 280 |
| `not_run` | 38 |

## 6. Material UI Surface Inventory

### `component`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | accordion | ui / ui | resources/views/components/ui/accordion/index.blade.php | present: resources/views/components/ui/accordion/contract.php | not_run / partial | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed accordion mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-badge | ui / ui | resources/views/components/ui/badge/index.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed ui-badge mismatch evidence without changing current behavior in issue #30? |
| unknown | breadcrumb | ui / ui | resources/views/components/ui/breadcrumb/index.blade.php | present: resources/views/components/ui/breadcrumb/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed breadcrumb mismatch evidence without changing current behavior in issue #30? |
| unknown | button-set | ui / ui | resources/views/components/ui/button-set/index.blade.php | present: resources/views/components/ui/button-set/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed button-set mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-button-skeleton | ui / ui | resources/views/components/ui/button-skeleton/index.blade.php | present: resources/views/components/ui/button-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-button-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | button | ui / ui | resources/views/components/ui/button/index.blade.php | present: resources/views/components/ui/button/contract.php | not_run / partial | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed button mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-chat-button-skeleton | ui / ui | resources/views/components/ui/chat-button-skeleton/index.blade.php | present: resources/views/components/ui/chat-button-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-chat-button-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-chat-button | ui / ui | resources/views/components/ui/chat-button/index.blade.php | present: resources/views/components/ui/chat-button/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-chat-button mismatch evidence without changing current behavior in issue #30? |
| unknown | checkbox-group | ui / ui | resources/views/components/ui/checkbox-group/index.blade.php | present: resources/views/components/ui/checkbox-group/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed checkbox-group mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-checkbox-skeleton | ui / ui | resources/views/components/ui/checkbox-skeleton/index.blade.php | present: resources/views/components/ui/checkbox-skeleton/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-checkbox-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | checkbox | ui / ui | resources/views/components/ui/checkbox/index.blade.php | present: resources/views/components/ui/checkbox/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed checkbox mismatch evidence without changing current behavior in issue #30? |
| unknown | code-snippet | ui / ui | resources/views/components/ui/code-snippet/index.blade.php | present: resources/views/components/ui/code-snippet/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed code-snippet mismatch evidence without changing current behavior in issue #30? |
| unknown | combo-box | ui / ui | resources/views/components/ui/combo-box/index.blade.php | present: resources/views/components/ui/combo-box/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed combo-box mismatch evidence without changing current behavior in issue #30? |
| unknown | combo-button | ui / ui | resources/views/components/ui/combo-button/index.blade.php | present: resources/views/components/ui/combo-button/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed combo-button mismatch evidence without changing current behavior in issue #30? |
| unknown | contained-list-item | ui / ui | resources/views/components/ui/contained-list-item/index.blade.php | present: resources/views/components/ui/contained-list-item/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed contained-list-item mismatch evidence without changing current behavior in issue #30? |
| unknown | contained-list | ui / ui | resources/views/components/ui/contained-list/index.blade.php | present: resources/views/components/ui/contained-list/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed contained-list mismatch evidence without changing current behavior in issue #30? |
| unknown | content-switcher | ui / ui | resources/views/components/ui/content-switcher/index.blade.php | present: resources/views/components/ui/content-switcher/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed content-switcher mismatch evidence without changing current behavior in issue #30? |
| unknown | copy-button | ui / ui | resources/views/components/ui/copy-button/index.blade.php | present: resources/views/components/ui/copy-button/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed copy-button mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-danger-button | ui / ui | resources/views/components/ui/danger-button/index.blade.php | present: resources/views/components/ui/danger-button/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-danger-button mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-data-table-skeleton | ui / ui | resources/views/components/ui/data-table-skeleton/index.blade.php | present: resources/views/components/ui/data-table-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-data-table-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | data-table | ui / ui | resources/views/components/ui/data-table/index.blade.php | present: resources/views/components/ui/data-table/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed data-table mismatch evidence without changing current behavior in issue #30? |
| unknown | data-table-toolbar | ui / ui | resources/views/components/ui/data-table/toolbar/index.blade.php | present: resources/views/components/ui/data-table/toolbar/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed data-table-toolbar mismatch evidence without changing current behavior in issue #30? |
| unknown | date-picker-input | ui / ui | resources/views/components/ui/date-picker-input/index.blade.php | present: resources/views/components/ui/date-picker-input/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed date-picker-input mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-date-picker-skeleton | ui / ui | resources/views/components/ui/date-picker-skeleton/index.blade.php | present: resources/views/components/ui/date-picker-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-date-picker-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | date-picker | ui / ui | resources/views/components/ui/date-picker/index.blade.php | present: resources/views/components/ui/date-picker/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed date-picker mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-drawer | ui / ui | resources/views/components/ui/drawer/index.blade.php | present: resources/views/components/ui/drawer/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-drawer mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-dropdown-skeleton | ui / ui | resources/views/components/ui/dropdown-skeleton/index.blade.php | present: resources/views/components/ui/dropdown-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-dropdown-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | dropdown | ui / ui | resources/views/components/ui/dropdown/index.blade.php | present: resources/views/components/ui/dropdown/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed dropdown mismatch evidence without changing current behavior in issue #30? |
| unknown | file-uploader-button | ui / ui | resources/views/components/ui/file-uploader-button/index.blade.php | present: resources/views/components/ui/file-uploader-button/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed file-uploader-button mismatch evidence without changing current behavior in issue #30? |
| unknown | file-uploader-drop-container | ui / ui | resources/views/components/ui/file-uploader-drop-container/index.blade.php | present: resources/views/components/ui/file-uploader-drop-container/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed file-uploader-drop-container mismatch evidence without changing current behavior in issue #30? |
| unknown | file-uploader-item | ui / ui | resources/views/components/ui/file-uploader-item/index.blade.php | present: resources/views/components/ui/file-uploader-item/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed file-uploader-item mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-file-uploader-skeleton | ui / ui | resources/views/components/ui/file-uploader-skeleton/index.blade.php | present: resources/views/components/ui/file-uploader-skeleton/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-file-uploader-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | file-uploader | ui / ui | resources/views/components/ui/file-uploader/index.blade.php | present: resources/views/components/ui/file-uploader/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed file-uploader mismatch evidence without changing current behavior in issue #30? |
| unknown | filename | ui / ui | resources/views/components/ui/filename/index.blade.php | present: resources/views/components/ui/filename/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed filename mismatch evidence without changing current behavior in issue #30? |
| unknown | filterable-multi-select | ui / ui | resources/views/components/ui/filterable-multi-select/index.blade.php | present: resources/views/components/ui/filterable-multi-select/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed filterable-multi-select mismatch evidence without changing current behavior in issue #30? |
| unknown | form-group | ui / ui | resources/views/components/ui/form-group/index.blade.php | present: resources/views/components/ui/form-group/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed form-group mismatch evidence without changing current behavior in issue #30? |
| unknown | form-item | ui / ui | resources/views/components/ui/form-item/index.blade.php | present: resources/views/components/ui/form-item/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed form-item mismatch evidence without changing current behavior in issue #30? |
| unknown | form-label | ui / ui | resources/views/components/ui/form-label/index.blade.php | present: resources/views/components/ui/form-label/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed form-label mismatch evidence without changing current behavior in issue #30? |
| unknown | form | ui / ui | resources/views/components/ui/form/index.blade.php | present: resources/views/components/ui/form/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed form mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-grid-column | ui / ui | resources/views/components/ui/grid-column/index.blade.php | variation: resources/views/components/ui/grid-column/contract.blade.php | missing / unknown | reference_missing, source_path_mismatch, standard_stale | investigate | Which later owner resolves the reviewed ui-grid-column mismatch evidence without changing current behavior in issue #30? |
| unknown | grid | ui / ui | resources/views/components/ui/grid/index.blade.php | variation: resources/views/components/ui/grid/contract.blade.php | missing / unknown | investigate, reference_missing, source_path_mismatch, standard_stale | investigate | Which later owner resolves the reviewed grid mismatch evidence without changing current behavior in issue #30? |
| unknown | h-stack | ui / ui | resources/views/components/ui/h-stack/index.blade.php | present: resources/views/components/ui/h-stack/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed h-stack mismatch evidence without changing current behavior in issue #30? |
| unknown | icon-button | ui / ui | resources/views/components/ui/icon-button/index.blade.php | present: resources/views/components/ui/icon-button/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed icon-button mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-icon-skeleton | ui / ui | resources/views/components/ui/icon-skeleton/index.blade.php | present: resources/views/components/ui/icon-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-icon-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | icon | ui / ui | resources/views/components/ui/icon/index.blade.php | present: resources/views/components/ui/icon/contract.php | not_run / partial | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed icon mismatch evidence without changing current behavior in issue #30? |
| unknown | inline-loading | ui / ui | resources/views/components/ui/inline-loading/index.blade.php | present: resources/views/components/ui/inline-loading/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed inline-loading mismatch evidence without changing current behavior in issue #30? |
| unknown | link | ui / ui | resources/views/components/ui/link/index.blade.php | present: resources/views/components/ui/link/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed link mismatch evidence without changing current behavior in issue #30? |
| unknown | list-item | ui / ui | resources/views/components/ui/list-item/index.blade.php | present: resources/views/components/ui/list-item/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed list-item mismatch evidence without changing current behavior in issue #30? |
| unknown | loading | ui / ui | resources/views/components/ui/loading/index.blade.php | present: resources/views/components/ui/loading/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed loading mismatch evidence without changing current behavior in issue #30? |
| unknown | menu-button | ui / ui | resources/views/components/ui/menu-button/index.blade.php | present: resources/views/components/ui/menu-button/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed menu-button mismatch evidence without changing current behavior in issue #30? |
| unknown | menu-item | ui / ui | resources/views/components/ui/menu-item/index.blade.php | present: resources/views/components/ui/menu-item/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed menu-item mismatch evidence without changing current behavior in issue #30? |
| unknown | menu | ui / ui | resources/views/components/ui/menu/index.blade.php | present: resources/views/components/ui/menu/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed menu mismatch evidence without changing current behavior in issue #30? |
| unknown | modal | ui / ui | resources/views/components/ui/modal/index.blade.php | present: resources/views/components/ui/modal/contract.php | not_run / authoritative | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed modal mismatch evidence without changing current behavior in issue #30? |
| unknown | multi-select | ui / ui | resources/views/components/ui/multi-select/index.blade.php | present: resources/views/components/ui/multi-select/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed multi-select mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-number-input-skeleton | ui / ui | resources/views/components/ui/number-input-skeleton/index.blade.php | present: resources/views/components/ui/number-input-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-number-input-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | number-input | ui / ui | resources/views/components/ui/number-input/index.blade.php | present: resources/views/components/ui/number-input/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed number-input mismatch evidence without changing current behavior in issue #30? |
| unknown | ordered-list | ui / ui | resources/views/components/ui/ordered-list/index.blade.php | present: resources/views/components/ui/ordered-list/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ordered-list mismatch evidence without changing current behavior in issue #30? |
| unknown | overflow-menu | ui / ui | resources/views/components/ui/overflow-menu/index.blade.php | present: resources/views/components/ui/overflow-menu/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed overflow-menu mismatch evidence without changing current behavior in issue #30? |
| unknown | pagination-nav | ui / ui | resources/views/components/ui/pagination-nav/index.blade.php | present: resources/views/components/ui/pagination-nav/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed pagination-nav mismatch evidence without changing current behavior in issue #30? |
| unknown | pagination | ui / ui | resources/views/components/ui/pagination/index.blade.php | present: resources/views/components/ui/pagination/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed pagination mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-partials | ui / ui | resources/views/components/ui/partials/tile-content.blade.php | present: resources/views/components/ui/partials/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-partials mismatch evidence without changing current behavior in issue #30? |
| unknown | password-input | ui / ui | resources/views/components/ui/password-input/index.blade.php | present: resources/views/components/ui/password-input/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed password-input mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-patterns | ui / ui | unknown | present: resources/views/components/ui/patterns/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-patterns mismatch evidence without changing current behavior in issue #30? |
| unknown | popover | ui / ui | resources/views/components/ui/popover/index.blade.php | present: resources/views/components/ui/popover/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed popover mismatch evidence without changing current behavior in issue #30? |
| unknown | progress-bar | ui / ui | resources/views/components/ui/progress-bar/index.blade.php | present: resources/views/components/ui/progress-bar/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed progress-bar mismatch evidence without changing current behavior in issue #30? |
| unknown | progress-indicator | ui / ui | resources/views/components/ui/progress-indicator/index.blade.php | present: resources/views/components/ui/progress-indicator/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed progress-indicator mismatch evidence without changing current behavior in issue #30? |
| unknown | progress-step | ui / ui | resources/views/components/ui/progress-step/index.blade.php | present: resources/views/components/ui/progress-step/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed progress-step mismatch evidence without changing current behavior in issue #30? |
| unknown | radio-button-group | ui / ui | resources/views/components/ui/radio-button-group/index.blade.php | present: resources/views/components/ui/radio-button-group/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed radio-button-group mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-radio-button-skeleton | ui / ui | resources/views/components/ui/radio-button-skeleton/index.blade.php | present: resources/views/components/ui/radio-button-skeleton/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-radio-button-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | radio-button | ui / ui | resources/views/components/ui/radio-button/index.blade.php | present: resources/views/components/ui/radio-button/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed radio-button mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-search-skeleton | ui / ui | resources/views/components/ui/search-skeleton/index.blade.php | present: resources/views/components/ui/search-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-search-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | search | ui / ui | resources/views/components/ui/search/index.blade.php | present: resources/views/components/ui/search/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed search mismatch evidence without changing current behavior in issue #30? |
| unknown | searchable-select | ui / ui | resources/views/components/ui/searchable-select/index.blade.php | present: resources/views/components/ui/searchable-select/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed searchable-select mismatch evidence without changing current behavior in issue #30? |
| unknown | select-item-group | ui / ui | resources/views/components/ui/select-item-group/index.blade.php | present: resources/views/components/ui/select-item-group/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed select-item-group mismatch evidence without changing current behavior in issue #30? |
| unknown | select-item | ui / ui | resources/views/components/ui/select-item/index.blade.php | present: resources/views/components/ui/select-item/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed select-item mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-select-skeleton | ui / ui | resources/views/components/ui/select-skeleton/index.blade.php | present: resources/views/components/ui/select-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-select-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | select | ui / ui | resources/views/components/ui/select/index.blade.php | present: resources/views/components/ui/select/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed select mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-slider-skeleton | ui / ui | resources/views/components/ui/slider-skeleton/index.blade.php | present: resources/views/components/ui/slider-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-slider-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | slider | ui / ui | resources/views/components/ui/slider/index.blade.php | present: resources/views/components/ui/slider/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed slider mismatch evidence without changing current behavior in issue #30? |
| unknown | stack | ui / ui | resources/views/components/ui/stack/index.blade.php | present: resources/views/components/ui/stack/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed stack mismatch evidence without changing current behavior in issue #30? |
| unknown | structured-list-row | ui / ui | resources/views/components/ui/structured-list-row/index.blade.php | present: resources/views/components/ui/structured-list-row/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed structured-list-row mismatch evidence without changing current behavior in issue #30? |
| unknown | structured-list | ui / ui | resources/views/components/ui/structured-list/index.blade.php | present: resources/views/components/ui/structured-list/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed structured-list mismatch evidence without changing current behavior in issue #30? |
| unknown | switch | ui / ui | resources/views/components/ui/switch/index.blade.php | present: resources/views/components/ui/switch/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed switch mismatch evidence without changing current behavior in issue #30? |
| unknown | tabs | ui / ui | resources/views/components/ui/tabs/index.blade.php | present: resources/views/components/ui/tabs/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed tabs mismatch evidence without changing current behavior in issue #30? |
| unknown | tag | ui / ui | resources/views/components/ui/tag/index.blade.php | present: resources/views/components/ui/tag/contract.php | not_run / authoritative | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed tag mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-text-area-skeleton | ui / ui | resources/views/components/ui/text-area-skeleton/index.blade.php | present: resources/views/components/ui/text-area-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-text-area-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | text-area | ui / ui | resources/views/components/ui/text-area/index.blade.php | present: resources/views/components/ui/text-area/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed text-area mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-text-input-skeleton | ui / ui | resources/views/components/ui/text-input-skeleton/index.blade.php | present: resources/views/components/ui/text-input-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-text-input-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | text-input | ui / ui | resources/views/components/ui/text-input/index.blade.php | present: resources/views/components/ui/text-input/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed text-input mismatch evidence without changing current behavior in issue #30? |
| unknown | tile | ui / ui | resources/views/components/ui/tile/index.blade.php | present: resources/views/components/ui/tile/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed tile mismatch evidence without changing current behavior in issue #30? |
| unknown | time-picker | ui / ui | resources/views/components/ui/time-picker/index.blade.php | present: resources/views/components/ui/time-picker/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed time-picker mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-toggle-skeleton | ui / ui | resources/views/components/ui/toggle-skeleton/index.blade.php | present: resources/views/components/ui/toggle-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-toggle-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-toggle-small-skeleton | ui / ui | resources/views/components/ui/toggle-small-skeleton/index.blade.php | present: resources/views/components/ui/toggle-small-skeleton/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-toggle-small-skeleton mismatch evidence without changing current behavior in issue #30? |
| unknown | toggle | ui / ui | resources/views/components/ui/toggle/index.blade.php | present: resources/views/components/ui/toggle/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed toggle mismatch evidence without changing current behavior in issue #30? |
| unknown | toggletip | ui / ui | resources/views/components/ui/toggletip/index.blade.php | present: resources/views/components/ui/toggletip/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed toggletip mismatch evidence without changing current behavior in issue #30? |
| unknown | tooltip | ui / ui | resources/views/components/ui/tooltip/index.blade.php | present: resources/views/components/ui/tooltip/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed tooltip mismatch evidence without changing current behavior in issue #30? |
| unknown | tree-view | ui / ui | resources/views/components/ui/tree-view/index.blade.php | present: resources/views/components/ui/tree-view/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed tree-view mismatch evidence without changing current behavior in issue #30? |
| unknown | unordered-list | ui / ui | resources/views/components/ui/unordered-list/index.blade.php | present: resources/views/components/ui/unordered-list/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed unordered-list mismatch evidence without changing current behavior in issue #30? |
| unknown | v-stack | ui / ui | resources/views/components/ui/v-stack/index.blade.php | present: resources/views/components/ui/v-stack/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed v-stack mismatch evidence without changing current behavior in issue #30? |

### `component_family`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | dialog | ui / ui | resources/views/components/ui/dialog/body.blade.php | present: resources/views/components/ui/dialog/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed dialog mismatch evidence without changing current behavior in issue #30? |
| unknown | notification | ui / ui | resources/views/components/ui/notification/action-button.blade.php | present: resources/views/components/ui/notification/contract.php | not_run / authoritative | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed notification mismatch evidence without changing current behavior in issue #30? |

### `css_control`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | module-notifications-css-root | unknown / notifications | Modules/Notifications/resources/css/index.css | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed module-notifications-css-root mismatch evidence without changing current behavior in issue #30? |
| unknown | resources-css-base | ui / ui | resources/css/base/animation.css | missing: missing | not_run / partial | none | retain | not_applicable |
| unknown | resources-css-components | ui / ui | resources/css/components/accordion.css | missing: missing | not_run / partial | none | retain | not_applicable |
| unknown | resources-css-patterns | ui / ui | resources/css/patterns/account.css | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | resources-css-root | ui / ui | resources/css/legacy.css | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | resources-css-tokens | ui / ui | resources/css/tokens/components/index.css | missing: missing | not_run / partial | none | retain | not_applicable |
| unknown | resources-css-type | ui / ui | resources/css/type/fluid.css | missing: missing | not_run / partial | none | retain | not_applicable |
| unknown | app | ui / ui | resources/css/app.css | missing: missing | not_run / partial | none | retain | not_applicable |
| unknown | theme-seed | ui / ui | resources/css/ui/theme-seed.css | missing: missing | missing / unknown | none | retain | not_applicable |

### `element`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | color | ui / ui | resources/css/tokens/components/buttons.css | present: resources/views/elements/color/contract.php | not_run / partial | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed color mismatch evidence without changing current behavior in issue #30? |
| unknown | grid | ui / ui | resources/css/tokens/layout.css | present: resources/views/elements/grid/contract.php | not_run / partial | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed grid mismatch evidence without changing current behavior in issue #30? |
| unknown | motion | ui / ui | resources/css/tokens/motion.css | present: resources/views/elements/motion/contract.php | not_run / partial | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed motion mismatch evidence without changing current behavior in issue #30? |
| unknown | spacing | ui / ui | resources/css/tokens/spacing.css | present: resources/views/elements/spacing/contract.php | not_run / partial | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed spacing mismatch evidence without changing current behavior in issue #30? |
| unknown | themes | ui / ui | resources/css/tokens/themes/index.css | present: resources/views/elements/themes/contract.php | not_run / partial | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed themes mismatch evidence without changing current behavior in issue #30? |
| unknown | typography | ui / ui | resources/css/tokens/type/index.css | present: resources/views/elements/typography/contract.php | not_run / partial | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed typography mismatch evidence without changing current behavior in issue #30? |

### `icon_system`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | icons | ui / ui | resources/views/components/icons/icon-list.txt | present: resources/views/elements/icons/contract.php | not_run / partial | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed icons mismatch evidence without changing current behavior in issue #30? |

### `javascript_control`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | module-notifications-js-root | unknown / notifications | Modules/Notifications/resources/js/index.js | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed module-notifications-js-root mismatch evidence without changing current behavior in issue #30? |
| unknown | resources-js-internal | ui / ui | resources/js/internal/events.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | resources-js-root | ui / ui | resources/js/app.js | missing: missing | not_run / partial | none | retain | not_applicable |
| unknown | resources-js-ui-controls | ui / ui | resources/js/ui-controls/app-header-notifications.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | header-menu | unknown / notifications | Modules/Notifications/resources/js/header-menu.js | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed header-menu mismatch evidence without changing current behavior in issue #30? |
| unknown | runtime | unknown / notifications | Modules/Notifications/resources/js/runtime.js | missing: missing | not_run / authoritative | investigate | investigate | Which later owner resolves the reviewed runtime mismatch evidence without changing current behavior in issue #30? |
| unknown | dashboard-test-notification | ui / ui | resources/js/dashboard-test-notification.js | missing: missing | not_run / authoritative | none | retain | not_applicable |
| unknown | focus | ui / ui | resources/js/internal/focus.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | table-enhance | ui / ui | resources/js/table-enhance.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | accordions | ui / ui | resources/js/ui-controls/accordions.js | missing: missing | not_run / partial | none | retain | not_applicable |
| unknown | app-header-search | ui / ui | resources/js/ui-controls/app-header-search.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | checkboxes | ui / ui | resources/js/ui-controls/checkboxes.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | code-snippets | ui / ui | resources/js/ui-controls/code-snippets.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | combo-boxes | ui / ui | resources/js/ui-controls/combo-boxes.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | content-switchers | ui / ui | resources/js/ui-controls/content-switchers.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | data-table | ui / ui | resources/js/ui-controls/data-table.js | missing: missing | not_run / incidental | standard_stale | retain | not_applicable |
| unknown | date-picker | ui / ui | resources/js/ui-controls/date-picker.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | destructive-actions | ui / ui | resources/js/ui-controls/destructive-actions.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | actions | ui / ui | resources/js/ui-controls/dialog/actions.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | constants | ui / ui | resources/js/ui-controls/dialog/constants.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | controller | ui / ui | resources/js/ui-controls/dialog/controller.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | triggers | ui / ui | resources/js/ui-controls/dialog/triggers.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | dialog | ui / ui | resources/js/ui-controls/dialog.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | docs-tree | ui / ui | resources/js/ui-controls/docs-tree.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | dropdown-action-menus | ui / ui | resources/js/ui-controls/dropdown-action-menus.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | dropdowns | ui / ui | resources/js/ui-controls/dropdowns.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | file-uploader | ui / ui | resources/js/ui-controls/file-uploader.js | missing: missing | missing / unknown | standard_stale | retain | not_applicable |
| unknown | form-submit-state | ui / ui | resources/js/ui-controls/form-submit-state.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | inline-loading | ui / ui | resources/js/ui-controls/inline-loading.js | missing: missing | missing / unknown | standard_stale | retain | not_applicable |
| unknown | interaction-focus | ui / ui | resources/js/ui-controls/interaction-focus.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | loading | ui / ui | resources/js/ui-controls/loading.js | missing: missing | missing / unknown | standard_stale | retain | not_applicable |
| unknown | menus | ui / ui | resources/js/ui-controls/menus.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | motion | ui / ui | resources/js/ui-controls/motion.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | multiselects | ui / ui | resources/js/ui-controls/multiselects.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | notification | ui / ui | resources/js/ui-controls/notification.js | missing: missing | not_run / authoritative | standard_stale | retain | not_applicable |
| unknown | number-inputs | ui / ui | resources/js/ui-controls/number-inputs.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | pagination-nav | ui / ui | resources/js/ui-controls/pagination-nav.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | pagination | ui / ui | resources/js/ui-controls/pagination.js | missing: missing | missing / unknown | standard_stale | retain | not_applicable |
| unknown | phone-inputs | ui / ui | resources/js/ui-controls/phone-inputs.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | popovers | ui / ui | resources/js/ui-controls/popovers.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | search | ui / ui | resources/js/ui-controls/search.js | missing: missing | not_run / incidental | standard_stale | retain | not_applicable |
| unknown | searchable-selects | ui / ui | resources/js/ui-controls/searchable-selects.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | select-controls | ui / ui | resources/js/ui-controls/select-controls.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | side-nav | ui / ui | resources/js/ui-controls/side-nav.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | sliders | ui / ui | resources/js/ui-controls/sliders.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | structured-lists | ui / ui | resources/js/ui-controls/structured-lists.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | tabs | ui / ui | resources/js/ui-controls/tabs.js | missing: missing | missing / unknown | standard_stale | retain | not_applicable |
| unknown | tag | ui / ui | resources/js/ui-controls/tag.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | text-areas | ui / ui | resources/js/ui-controls/text-areas.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | text-inputs | ui / ui | resources/js/ui-controls/text-inputs.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | tiles | ui / ui | resources/js/ui-controls/tiles.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | toggles | ui / ui | resources/js/ui-controls/toggles.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | toggletip | ui / ui | resources/js/ui-controls/toggletip.js | missing: missing | missing / unknown | standard_stale | retain | not_applicable |
| unknown | tooltips | ui / ui | resources/js/ui-controls/tooltips.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | tree-views | ui / ui | resources/js/ui-controls/tree-views.js | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | ui-shell | ui / ui | resources/js/ui-controls/ui-shell.js | missing: missing | missing / unknown | standard_stale | retain | not_applicable |

### `layout`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | layouts-app-frame | ui / ui | resources/views/components/layouts/app/frame/nav-link.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed layouts-app-frame mismatch evidence without changing current behavior in issue #30? |
| unknown | layouts-app-frame-header | ui / ui | resources/views/components/layouts/app/frame/header/index.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed layouts-app-frame-header mismatch evidence without changing current behavior in issue #30? |
| unknown | layouts-app-partials | ui / ui | resources/views/components/layouts/app/partials/authenticated-main.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed layouts-app-partials mismatch evidence without changing current behavior in issue #30? |
| unknown | app | ui / ui | resources/views/components/layouts/app.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed app mismatch evidence without changing current behavior in issue #30? |
| unknown | nav-icon | ui / ui | resources/views/components/layouts/nav-icon.blade.php | missing: missing | not_run / incidental | contract_missing, investigate | investigate | Which later owner resolves the reviewed nav-icon mismatch evidence without changing current behavior in issue #30? |

### `navigation`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| docs-viewer.nav.primary | docs-viewer-nav-primary | core / docs-viewer | app/Core/Modules/Definitions.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed docs-viewer-nav-primary mismatch evidence without changing current behavior in issue #30? |
| logging.nav.audit-logs | logging-nav-audit-logs | core / logging | app/Core/Modules/Definitions.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed logging-nav-audit-logs mismatch evidence without changing current behavior in issue #30? |
| logging.nav.error-logs | logging-nav-error-logs | core / logging | app/Core/Modules/Definitions.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed logging-nav-error-logs mismatch evidence without changing current behavior in issue #30? |
| security-checklist.nav.primary | security-checklist-nav-primary | core / security-checklist | app/Core/Modules/Definitions.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed security-checklist-nav-primary mismatch evidence without changing current behavior in issue #30? |
| account.nav.index | account-nav-index | unknown / account | Modules/Account/Definition.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed account-nav-index mismatch evidence without changing current behavior in issue #30? |
| account.nav.preferences | account-nav-preferences | unknown / account | Modules/Account/Definition.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed account-nav-preferences mismatch evidence without changing current behavior in issue #30? |
| account.nav.security | account-nav-security | unknown / account | Modules/Account/Definition.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed account-nav-security mismatch evidence without changing current behavior in issue #30? |

### `pattern`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | patterns-account-action-row | ui / ui | resources/views/components/patterns/account/action-row/index.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed patterns-account-action-row mismatch evidence without changing current behavior in issue #30? |
| unknown | patterns-account-panel | ui / ui | resources/views/components/patterns/account/panel/index.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed patterns-account-panel mismatch evidence without changing current behavior in issue #30? |
| unknown | patterns-account-section-tabs | ui / ui | resources/views/components/patterns/account/section-tabs/index.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed patterns-account-section-tabs mismatch evidence without changing current behavior in issue #30? |
| unknown | patterns-account-settings-summary | ui / ui | resources/views/components/patterns/account/settings-summary/index.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed patterns-account-settings-summary mismatch evidence without changing current behavior in issue #30? |
| unknown | auth-challenge-form | ui / ui | resources/views/components/patterns/auth/challenge-form/index.blade.php | present: resources/views/components/patterns/auth/challenge-form/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed auth-challenge-form mismatch evidence without changing current behavior in issue #30? |
| unknown | common-actions-action-set | ui / ui | resources/views/components/patterns/common-actions/action-set/index.blade.php | present: resources/views/components/patterns/common-actions/action-set/contract.php | not_run / authoritative | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed common-actions-action-set mismatch evidence without changing current behavior in issue #30? |
| unknown | common-actions-bulk-actions | ui / ui | resources/views/components/patterns/common-actions/bulk-actions/index.blade.php | present: resources/views/components/patterns/common-actions/bulk-actions/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed common-actions-bulk-actions mismatch evidence without changing current behavior in issue #30? |
| unknown | common-actions-destructive-actions | ui / ui | resources/views/components/patterns/common-actions/destructive-actions/index.blade.php | present: resources/views/components/patterns/common-actions/destructive-actions/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed common-actions-destructive-actions mismatch evidence without changing current behavior in issue #30? |
| unknown | common-actions-empty-state-actions | ui / ui | resources/views/components/patterns/common-actions/empty-state-actions/index.blade.php | present: resources/views/components/patterns/common-actions/empty-state-actions/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed common-actions-empty-state-actions mismatch evidence without changing current behavior in issue #30? |
| unknown | common-actions-page-actions | ui / ui | resources/views/components/patterns/common-actions/page-actions/index.blade.php | present: resources/views/components/patterns/common-actions/page-actions/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed common-actions-page-actions mismatch evidence without changing current behavior in issue #30? |
| unknown | common-actions-recovery-actions | ui / ui | resources/views/components/patterns/common-actions/recovery-actions/index.blade.php | present: resources/views/components/patterns/common-actions/recovery-actions/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed common-actions-recovery-actions mismatch evidence without changing current behavior in issue #30? |
| unknown | common-actions-row-actions | ui / ui | resources/views/components/patterns/common-actions/row-actions/index.blade.php | present: resources/views/components/patterns/common-actions/row-actions/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed common-actions-row-actions mismatch evidence without changing current behavior in issue #30? |
| unknown | content-section-block | ui / ui | resources/views/components/patterns/content-section-block.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed content-section-block mismatch evidence without changing current behavior in issue #30? |
| unknown | dashboard-grid | ui / ui | resources/views/components/patterns/dashboard-grid.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed dashboard-grid mismatch evidence without changing current behavior in issue #30? |
| unknown | data-list-item | ui / ui | resources/views/components/patterns/data-list-item.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed data-list-item mismatch evidence without changing current behavior in issue #30? |
| unknown | date-range-filter | ui / ui | resources/views/components/patterns/date-range-filter.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed date-range-filter mismatch evidence without changing current behavior in issue #30? |
| unknown | dropdown-action-menu | ui / ui | resources/views/components/patterns/dropdown-action-menu.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed dropdown-action-menu mismatch evidence without changing current behavior in issue #30? |
| unknown | empty-state | ui / ui | resources/views/components/patterns/empty-state.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed empty-state mismatch evidence without changing current behavior in issue #30? |
| unknown | enhanced-data-table | ui / ui | resources/views/components/patterns/enhanced-data-table.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed enhanced-data-table mismatch evidence without changing current behavior in issue #30? |
| unknown | form-group | ui / ui | resources/views/components/patterns/form-group.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed form-group mismatch evidence without changing current behavior in issue #30? |
| unknown | form-section | ui / ui | resources/views/components/patterns/form-section.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed form-section mismatch evidence without changing current behavior in issue #30? |
| unknown | forms-actions | ui / ui | resources/views/components/patterns/forms/actions/index.blade.php | present: resources/views/components/patterns/forms/actions/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed forms-actions mismatch evidence without changing current behavior in issue #30? |
| unknown | forms-dialog | ui / ui | resources/views/components/patterns/forms/dialog/index.blade.php | present: resources/views/components/patterns/forms/dialog/contract.php | missing / unknown | contract_stale, investigate, lifecycle_conflict, reference_missing, source_path_mismatch, standard_stale | investigate | Which later owner resolves the reviewed forms-dialog mismatch evidence without changing current behavior in issue #30? |
| unknown | forms-page | ui / ui | resources/views/components/patterns/forms/page/index.blade.php | present: resources/views/components/patterns/forms/page/contract.php | missing / unknown | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed forms-page mismatch evidence without changing current behavior in issue #30? |
| unknown | forms-side-panel | ui / ui | resources/views/components/patterns/forms/side-panel/index.blade.php | present: resources/views/components/patterns/forms/side-panel/contract.php | missing / unknown | contract_stale, investigate, lifecycle_conflict, reference_missing, source_path_mismatch, standard_stale | investigate | Which later owner resolves the reviewed forms-side-panel mismatch evidence without changing current behavior in issue #30? |
| unknown | identity-summary-card | ui / ui | resources/views/components/patterns/identity-summary-card.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed identity-summary-card mismatch evidence without changing current behavior in issue #30? |
| unknown | inline-form-row | ui / ui | resources/views/components/patterns/inline-form-row.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed inline-form-row mismatch evidence without changing current behavior in issue #30? |
| unknown | key-value-display | ui / ui | resources/views/components/patterns/key-value-display/index.blade.php | present: resources/views/components/patterns/key-value-display/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed key-value-display mismatch evidence without changing current behavior in issue #30? |
| unknown | key-value-display | ui / ui | resources/views/components/patterns/key-value-display.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed key-value-display mismatch evidence without changing current behavior in issue #30? |
| unknown | patterns-notifications-actionable | ui / ui | resources/views/components/patterns/notifications/actionable/index.blade.php | missing: missing | not_run / authoritative | contract_missing, investigate | investigate | Which later owner resolves the reviewed patterns-notifications-actionable mismatch evidence without changing current behavior in issue #30? |
| unknown | patterns-notifications-callout | ui / ui | resources/views/components/patterns/notifications/callout/index.blade.php | missing: missing | not_run / authoritative | contract_missing, investigate | investigate | Which later owner resolves the reviewed patterns-notifications-callout mismatch evidence without changing current behavior in issue #30? |
| unknown | patterns-notifications-inline | ui / ui | resources/views/components/patterns/notifications/inline/index.blade.php | missing: missing | not_run / authoritative | contract_missing, investigate | investigate | Which later owner resolves the reviewed patterns-notifications-inline mismatch evidence without changing current behavior in issue #30? |
| unknown | patterns-notifications-modal | ui / ui | resources/views/components/patterns/notifications/modal/index.blade.php | missing: missing | not_run / partial | contract_missing, investigate | investigate | Which later owner resolves the reviewed patterns-notifications-modal mismatch evidence without changing current behavior in issue #30? |
| unknown | patterns-notifications-toast | ui / ui | resources/views/components/patterns/notifications/toast/index.blade.php | missing: missing | not_run / authoritative | contract_missing, investigate | investigate | Which later owner resolves the reviewed patterns-notifications-toast mismatch evidence without changing current behavior in issue #30? |
| unknown | page-title-actions-row | ui / ui | resources/views/components/patterns/page-title-actions-row.blade.php | missing: missing | not_run / partial | contract_missing, investigate | investigate | Which later owner resolves the reviewed page-title-actions-row mismatch evidence without changing current behavior in issue #30? |
| unknown | proof-note | ui / ui | resources/views/components/patterns/proof-note.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed proof-note mismatch evidence without changing current behavior in issue #30? |
| unknown | proof-review-banner | ui / ui | resources/views/components/patterns/proof-review-banner.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed proof-review-banner mismatch evidence without changing current behavior in issue #30? |
| unknown | proof-review-target | ui / ui | resources/views/components/patterns/proof-review-target.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed proof-review-target mismatch evidence without changing current behavior in issue #30? |
| unknown | search-filter-bar | ui / ui | resources/views/components/patterns/search-filter-bar.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed search-filter-bar mismatch evidence without changing current behavior in issue #30? |
| unknown | stat-card | ui / ui | resources/views/components/patterns/stat-card.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed stat-card mismatch evidence without changing current behavior in issue #30? |
| unknown | status-indicator | ui / ui | resources/views/components/patterns/status-indicator/index.blade.php | present: resources/views/components/patterns/status-indicator/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed status-indicator mismatch evidence without changing current behavior in issue #30? |
| unknown | sub-navigation-bar | ui / ui | resources/views/components/patterns/sub-navigation-bar.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed sub-navigation-bar mismatch evidence without changing current behavior in issue #30? |
| unknown | tag-group | ui / ui | resources/views/components/patterns/tag-group/index.blade.php | present: resources/views/components/patterns/tag-group/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed tag-group mismatch evidence without changing current behavior in issue #30? |
| unknown | validation-summary | ui / ui | resources/views/components/patterns/validation-summary.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed validation-summary mismatch evidence without changing current behavior in issue #30? |
| unknown | widget-shell | ui / ui | resources/views/components/patterns/widget-shell.blade.php | missing: missing | missing / unknown | contract_missing, investigate | investigate | Which later owner resolves the reviewed widget-shell mismatch evidence without changing current behavior in issue #30? |

### `pictogram_system`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | pictograms | ui / ui | resources/views/elements/pictograms/contract.php | present: resources/views/elements/pictograms/contract.php | not_run / partial | investigate, reference_missing, standard_stale | investigate | Which later owner resolves the reviewed pictograms mismatch evidence without changing current behavior in issue #30? |

### `renderer`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | audit-log-controller | core / audit_log_controller_php | app/Http/Controllers/Platform/AuditLogController.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | docs-controller | core / docs_controller_php | app/Http/Controllers/Platform/DocsController.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | error-log-controller | core / error_log_controller_php | app/Http/Controllers/Platform/ErrorLogController.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | platform-user-controller | core / platform_user_controller_php | app/Http/Controllers/Platform/PlatformUserController.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | security-checklist-controller | core / security_checklist_controller_php | app/Http/Controllers/Platform/SecurityChecklistController.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | dashboard-page | core / dashboard | app/Livewire/Platform/Dashboard/DashboardPage.php | missing: missing | missing / unknown | none | retain | not_applicable |

### `shell`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | ui-shell-content | ui / ui | resources/views/components/shell/content/index.blade.php | present: resources/views/components/shell/content/contract.php | not_run / authoritative | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-shell-content mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-shell-header | ui / ui | resources/views/components/shell/header/index.blade.php | present: resources/views/components/shell/header/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-shell-header mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-shell-page-header | ui / ui | resources/views/components/shell/page-header/index.blade.php | present: resources/views/components/shell/page-header/contract.php | not_run / authoritative | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-shell-page-header mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-shell-page-tabs | ui / ui | resources/views/components/shell/page-tabs/index.blade.php | present: resources/views/components/shell/page-tabs/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-shell-page-tabs mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-shell-page-title | ui / ui | resources/views/components/shell/page-title/index.blade.php | present: resources/views/components/shell/page-title/contract.php | not_run / authoritative | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-shell-page-title mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-shell-side-nav | ui / ui | resources/views/components/shell/side-nav/index.blade.php | present: resources/views/components/shell/side-nav/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-shell-side-nav mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-shell-skip-to-content | ui / ui | resources/views/components/shell/skip-to-content/index.blade.php | present: resources/views/components/shell/skip-to-content/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-shell-skip-to-content mismatch evidence without changing current behavior in issue #30? |
| unknown | ui-shell-switcher | ui / ui | resources/views/components/shell/switcher/index.blade.php | present: resources/views/components/shell/switcher/contract.php | missing / unknown | reference_missing, standard_stale | investigate | Which later owner resolves the reviewed ui-shell-switcher mismatch evidence without changing current behavior in issue #30? |

### `ui_contribution`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| docs-viewer.main.index | docs-viewer-main-index | core / docs-viewer | app/Core/Modules/Definitions.php | missing: missing | missing / unknown | none | retain | not_applicable |
| logging.main.audit-logs | logging-main-audit-logs | core / logging | app/Core/Modules/Definitions.php | missing: missing | missing / unknown | none | retain | not_applicable |
| logging.main.error-logs | logging-main-error-logs | core / logging | app/Core/Modules/Definitions.php | missing: missing | missing / unknown | none | retain | not_applicable |
| security-checklist.main.index | security-checklist-main-index | core / security-checklist | app/Core/Modules/Definitions.php | missing: missing | missing / unknown | none | retain | not_applicable |
| users.main.index | users-main-index | core / users | app/Core/Modules/Definitions.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | renders-on-dashboard | unknown / dashboard | app/Platform/Dashboard/RendersOnDashboard.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed renders-on-dashboard mismatch evidence without changing current behavior in issue #30? |
| unknown | widget-registry | unknown / dashboard | app/Platform/Dashboard/WidgetRegistry.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed widget-registry mismatch evidence without changing current behavior in issue #30? |
| unknown | development-tools-widget | unknown / dashboard | app/Platform/Dashboard/Widgets/DevelopmentToolsWidget.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed development-tools-widget mismatch evidence without changing current behavior in issue #30? |
| unknown | error-health-widget | unknown / dashboard | app/Platform/Dashboard/Widgets/ErrorHealthWidget.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed error-health-widget mismatch evidence without changing current behavior in issue #30? |
| unknown | platform-stats-widget | unknown / dashboard | app/Platform/Dashboard/Widgets/PlatformStatsWidget.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed platform-stats-widget mismatch evidence without changing current behavior in issue #30? |
| unknown | recent-audit-activity-widget | unknown / dashboard | app/Platform/Dashboard/Widgets/RecentAuditActivityWidget.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed recent-audit-activity-widget mismatch evidence without changing current behavior in issue #30? |
| unknown | security-readiness-widget | unknown / dashboard | app/Platform/Dashboard/Widgets/SecurityReadinessWidget.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed security-readiness-widget mismatch evidence without changing current behavior in issue #30? |
| unknown | system-notifications-widget | unknown / dashboard | app/Platform/Dashboard/Widgets/SystemNotificationsWidget.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed system-notifications-widget mismatch evidence without changing current behavior in issue #30? |
| account.main.index | account-main-index | unknown / account | Modules/Account/Definition.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed account-main-index mismatch evidence without changing current behavior in issue #30? |
| account.main.legacy-platform-directory | account-main-legacy-platform-directory | unknown / account | Modules/Account/Definition.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed account-main-legacy-platform-directory mismatch evidence without changing current behavior in issue #30? |
| account.main.security | account-main-security | unknown / account | Modules/Account/Definition.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed account-main-security mismatch evidence without changing current behavior in issue #30? |
| unknown | header-action | core / account | Modules/Account/resources/views/header/action.blade.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed header-action mismatch evidence without changing current behavior in issue #30? |
| unknown | header-action | core / notifications | Modules/Notifications/resources/views/header/action.blade.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed header-action mismatch evidence without changing current behavior in issue #30? |
| unknown | runtime-toasts | core / notifications | Modules/Notifications/resources/views/runtime/toasts.blade.php | missing: missing | not_run / authoritative | none | retain | not_applicable |
| settings.main.index | settings-main-index | unknown / settings | Modules/Settings/Definition.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed settings-main-index mismatch evidence without changing current behavior in issue #30? |
| settings.main.platform-index | settings-main-platform-index | unknown / settings | Modules/Settings/Definition.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed settings-main-platform-index mismatch evidence without changing current behavior in issue #30? |
| setup.main.index | setup-main-index | unknown / setup | Modules/Setup/Definition.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed setup-main-index mismatch evidence without changing current behavior in issue #30? |

### `url_view`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | settings-index | unknown / template | Modules/_Template/resources/views/settings/index.blade.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed settings-index mismatch evidence without changing current behavior in issue #30? |
| unknown | setup-index | unknown / template | Modules/_Template/resources/views/setup/index.blade.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed setup-index mismatch evidence without changing current behavior in issue #30? |
| unknown | index | core / account | Modules/Account/resources/views/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | security | core / account | Modules/Account/resources/views/security.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | account-mfa-enroll | core / auth | Modules/Auth/resources/views/account/mfa-enroll.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | account-mfa-recovery-codes | core / auth | Modules/Auth/resources/views/account/mfa-recovery-codes.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | login-password | core / auth | Modules/Auth/resources/views/login-password.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | login | core / auth | Modules/Auth/resources/views/login.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | mfa-challenge | core / auth | Modules/Auth/resources/views/mfa-challenge.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | mfa-enroll | core / auth | Modules/Auth/resources/views/mfa-enroll.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | mfa-step-up | core / auth | Modules/Auth/resources/views/mfa-step-up.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | index | core / dashboard | Modules/Dashboard/resources/views/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | account-index | core / notifications | Modules/Notifications/resources/views/account/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | account-preferences | core / notifications | Modules/Notifications/resources/views/account/preferences.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | index | core / notifications | Modules/Notifications/resources/views/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | settings-defaults | core / notifications | Modules/Notifications/resources/views/settings/defaults.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | setup-index | core / notifications | Modules/Notifications/resources/views/setup/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | account-index | core / preferences | Modules/Preferences/resources/views/account/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | personal-defaults | core / preferences | Modules/Preferences/resources/views/personal-defaults.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | create | core / roles | Modules/Roles/resources/views/create.blade.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed create mismatch evidence without changing current behavior in issue #30? |
| unknown | delete | core / roles | Modules/Roles/resources/views/delete.blade.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed delete mismatch evidence without changing current behavior in issue #30? |
| unknown | edit | core / roles | Modules/Roles/resources/views/edit.blade.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed edit mismatch evidence without changing current behavior in issue #30? |
| unknown | index | core / roles | Modules/Roles/resources/views/index.blade.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed index mismatch evidence without changing current behavior in issue #30? |
| unknown | permissions-index | core / roles | Modules/Roles/resources/views/permissions/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | show | core / roles | Modules/Roles/resources/views/show.blade.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed show mismatch evidence without changing current behavior in issue #30? |
| unknown | audit-logs | core / settings | Modules/Settings/resources/views/audit-logs.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | docs | core / settings | Modules/Settings/resources/views/docs.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | general-company-information | core / settings | Modules/Settings/resources/views/general-company-information.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | general-email | core / settings | Modules/Settings/resources/views/general-email.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | general-localization | core / settings | Modules/Settings/resources/views/general-localization.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | general-system-server-info | core / settings | Modules/Settings/resources/views/general-system-server-info.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | general-system-update | core / settings | Modules/Settings/resources/views/general-system-update.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | general | core / settings | Modules/Settings/resources/views/general.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | index | core / settings | Modules/Settings/resources/views/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | users | core / settings | Modules/Settings/resources/views/users.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | index | core / setup | Modules/Setup/resources/views/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | audit-logs-index | core / audit_logs | resources/views/platform/audit-logs/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | audit-logs-show | core / audit_logs | resources/views/platform/audit-logs/show.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | docs-index | core / docs | resources/views/platform/docs/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | error-logs-index | core / error_logs | resources/views/platform/error-logs/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | error-logs-show | core / error_logs | resources/views/platform/error-logs/show.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | security-index | core / security | resources/views/platform/security/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | security-show | core / security | resources/views/platform/security/show.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | users-create | core / users | resources/views/platform/users/create.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | users-edit | core / users | resources/views/platform/users/edit.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |
| unknown | users-index | core / users | resources/views/platform/users/index.blade.php | missing: missing | missing / unknown | none | retain | not_applicable |

### `view_model`

| UI Key | Slug | Ownership | Implementation | Contract | Tests | Mismatches | Disposition | Target Question |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| unknown | action-view-data | unknown / account | Modules/Account/Header/ActionViewData.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed action-view-data mismatch evidence without changing current behavior in issue #30? |
| unknown | menu-data-provider | unknown / account | Modules/Account/Header/MenuDataProvider.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed menu-data-provider mismatch evidence without changing current behavior in issue #30? |
| unknown | action-view-data | unknown / notifications | Modules/Notifications/Header/ActionViewData.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed action-view-data mismatch evidence without changing current behavior in issue #30? |
| unknown | panel-data-provider | unknown / notifications | Modules/Notifications/Header/PanelDataProvider.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed panel-data-provider mismatch evidence without changing current behavior in issue #30? |
| unknown | view-data | unknown / roles | Modules/Roles/Services/ViewData.php | missing: missing | missing / unknown | investigate | investigate | Which later owner resolves the reviewed view-data mismatch evidence without changing current behavior in issue #30? |

## 7. Standards And Metadata Evidence

- Surfaces with linked standards evidence: 149
- Surfaces recording metadata evidence: 318
- Surfaces classified with `standard_stale`: 141

| Standard | Implementation | Contract | Reference / Example | Authority | Staleness Evidence | Moved Responsibilities |
| --- | --- | --- | --- | --- | --- | --- |
| docs/02-standards/ui/components/accordion.md | partial | partial | partial | mixed_authority | The standard names installed Accordion source files but still declares the canonical API owner not installed at the pinned baseline. | none |
| docs/02-standards/ui/components/breadcrumb.md | partial | partial | partial | mixed_authority | The standard names installed Breadcrumb source files but still declares the canonical API owner not installed at the pinned baseline. | none |
| docs/02-standards/ui/components/button.md | partial | partial | partial | mixed_authority | The standard names installed Button source files but still declares the canonical API owner not installed at the pinned baseline. | none |
| docs/02-standards/ui/components/checkbox.md | partial | partial | partial | mixed_authority | The standard names installed Checkbox source files but still declares the canonical API owner not installed at the pinned baseline. | none |
| docs/02-standards/ui/components/code-snippet.md | partial | partial | partial | mixed_authority | The standard names installed Code snippet source files but still declares the canonical API owner not installed at the pinned baseline. | none |
| docs/02-standards/ui/components/combo-box.md | stale | stale | partial | stale | The standard classifies Combo box as a queued gap with no public API while pinned x-ui.combo-box implementation and contract sources exist. | none |
| docs/02-standards/ui/components/contained-list.md | partial | partial | partial | mixed_authority | The standard names installed Contained list source files but still declares the canonical API owner not installed at the pinned baseline. | none |
| docs/02-standards/ui/components/content-switcher.md | aligned | partial | partial | current_standard | none | none |
| docs/02-standards/ui/components/data-table.md | partial | partial | partial | mixed_authority | The standard names installed Data table sources but still declares the canonical API owner not installed at the pinned baseline. | none |
| docs/02-standards/ui/components/date-picker.md | aligned | partial | partial | current_standard | none | none |
| docs/02-standards/ui/components/dropdown.md | partial | partial | partial | mixed_authority | The standard identifies installed Dropdown sources while retaining a not-installed canonical owner placeholder. | none |
| docs/02-standards/ui/components/file-uploader.md | stale | partial | partial | mixed_authority | The standard describes no dedicated public Blade implementation and primarily CSS ownership while pinned file-uploader Blade and contract sources exist. | none |
| docs/02-standards/ui/components/form.md | aligned | partial | partial | current_standard | none | none |
| docs/02-standards/ui/components/index.md | partial | not_applicable | partial | current_standard | none | none |
| docs/02-standards/ui/components/inline-loading.md | partial | partial | partial | mixed_authority | The standard names installed Inline loading source but still declares the canonical API owner not installed at the pinned baseline. | none |
| docs/02-standards/ui/components/link.md | partial | partial | partial | mixed_authority | The standard names installed Link source while retaining a not-installed canonical owner and rendered-evidence placeholder. | none |
| docs/02-standards/ui/components/loading.md | partial | partial | partial | mixed_authority | The standard names installed Loading source while retaining not-installed owner and rendered-evidence placeholders. | none |
| docs/02-standards/ui/components/menu.md | partial | partial | partial | mixed_authority | The standard names installed Menu Blade, JavaScript, and CSS sources but declares the canonical API owner not installed. | none |
| docs/02-standards/ui/components/modal.md | partial | partial | partial | mixed_authority | The standard names installed Modal source while retaining a not-installed canonical owner and rendered-evidence route. | none |
| docs/02-standards/ui/components/notification.md | partial | partial | partial | mixed_authority | The standard names installed Notification family sources but declares the canonical API owner not installed. | none |
| docs/02-standards/ui/components/number-input.md | stale | partial | partial | mixed_authority | The standard lists CSS and not-installed source ownership while pinned Number input Blade and contract sources exist. | none |
| docs/02-standards/ui/components/pagination.md | partial | partial | partial | mixed_authority | The standard names installed Pagination Blade and JavaScript sources while retaining not-installed owner and route placeholders. | none |
| docs/02-standards/ui/components/popover.md | partial | partial | partial | mixed_authority | The standard names installed Popover sources but declares the canonical API owner not installed. | none |
| docs/02-standards/ui/components/progress-bar.md | stale | partial | partial | mixed_authority | The standard lists CSS and route-owned evidence as source while pinned Progress bar Blade and contract sources exist. | none |
| docs/02-standards/ui/components/progress-indicator.md | partial | partial | partial | mixed_authority | The standard names installed Progress indicator sources but declares the canonical API owner not installed. | none |
| docs/02-standards/ui/components/radio-button.md | partial | partial | partial | mixed_authority | The implemented standard names installed Radio button sources but declares the canonical API owner not installed. | none |
| docs/02-standards/ui/components/search.md | partial | partial | partial | mixed_authority | The standard names installed Search Blade and JavaScript sources while retaining not-installed owner and route placeholders. | none |
| docs/02-standards/ui/components/select.md | partial | partial | partial | mixed_authority | The standard names installed Select source while retaining a not-installed canonical owner and source placeholder. | none |
| docs/02-standards/ui/components/slider.md | partial | partial | partial | mixed_authority | The implemented Slider standard declares the canonical API owner not installed while pinned Slider source and contract exist. | none |
| docs/02-standards/ui/components/structured-list.md | partial | partial | partial | mixed_authority | The standard names installed Structured list sources while retaining not-installed owner and source placeholders. | none |
| docs/02-standards/ui/components/tabs.md | partial | partial | partial | mixed_authority | The standard names installed Tabs Blade and JavaScript sources but declares the canonical API owner not installed. | none |
| docs/02-standards/ui/components/tag.md | aligned | partial | partial | current_standard | none | none |
| docs/02-standards/ui/components/text-input.md | aligned | partial | partial | current_standard | none | none |
| docs/02-standards/ui/components/tile.md | aligned | partial | partial | current_standard | none | none |
| docs/02-standards/ui/components/toggle.md | stale | partial | partial | mixed_authority | The standard lists CSS and route-owned evidence as source while pinned Toggle Blade and contract sources exist. | none |
| docs/02-standards/ui/components/toggletip.md | partial | partial | partial | mixed_authority | The standard names installed Toggletip Blade and JavaScript sources but declares the canonical API owner not installed. | none |
| docs/02-standards/ui/components/tooltip.md | partial | partial | partial | mixed_authority | The standard names installed Tooltip source but declares the canonical API owner not installed. | none |
| docs/02-standards/ui/components/tree-view.md | partial | partial | partial | mixed_authority | The implemented Tree view standard names installed sources but declares the canonical API owner not installed. | none |
| docs/02-standards/ui/components/ui-shell.md | partial | not_applicable | partial | mixed_authority | The standard declares the canonical UI shell API owner not installed and omits the pinned ui-shell JavaScript control from its source posture. | none |
| docs/02-standards/ui/contract-file.md | partial | stale | partial | mixed_authority | The standard requires broader top-level testing and review sections that are absent from the normalized Defaults top-level keys., Current Surface profile contracts use a responsibility split that excludes rendered evidence, examples, scanner output, testing ownership, and manual readiness from normalized contracts. | Rendered evidence presentation and curated examples are owned by owner-local reference.php evidence., Testing results and scanner output are owned by test and inventory tooling rather than normalized contract defaults., Manual review and readiness status are evidence/review concerns outside the normalized callable API contract. |
| docs/02-standards/ui/elements/color.md | aligned | aligned | stale | mixed_authority | The standard claims a Color reference.php implementation, but that owner-local reference file is absent at the pinned baseline. | none |
| docs/02-standards/ui/elements/motion.md | aligned | partial | partial | current_standard | none | none |
| docs/02-standards/ui/elements/spacing.md | aligned | partial | partial | current_standard | none | none |
| docs/02-standards/ui/elements/themes.md | aligned | aligned | stale | mixed_authority | The standard claims a Themes reference.php implementation, but that owner-local reference file is absent at the pinned baseline. | none |
| docs/02-standards/ui/elements/typography.md | aligned | partial | partial | current_standard | none | none |
| docs/02-standards/ui/reference-file.md | aligned | aligned | partial | current_standard | none | none |

Standards and metadata findings are current-state evidence only. Final contract metadata, API/schema versioning, readiness, review-state, and durable standards policy remain assigned to Goals 04, 05, and 08.

## 8. UI Test Traceability

| Surface UI Key | Test Path | Type | Result | Authority |
| --- | --- | --- | --- | --- |
| unknown | resources/views/elements/pictograms/__tests__/index.md | visual | not_run | partial |
| unknown | resources/views/elements/icons/__tests__/IconElementGovernanceTest.php | accessibility | not_run | partial |
| unknown | resources/views/components/ui/tag/__tests__/TagCssGovernanceTest.php | visual | not_run | authoritative |
| unknown | resources/views/components/ui/accordion/__tests__/index.md | browser | not_run | partial |
| unknown | resources/views/elements/motion/__tests__/baselines/js-timing-findings.php | unknown | not_run | incidental |
| unknown | resources/views/components/ui/button/__tests__/ButtonCssGovernanceTest.php | visual | not_run | authoritative |
| unknown | resources/views/components/ui/accordion/__tests__/AccordionInteraction.spec.js | browser | not_run | authoritative |
| unknown | resources/views/components/ui/accordion/__tests__/AccordionInteraction.spec.js | browser | not_run | authoritative |
| unknown | resources/views/elements/motion/__tests__/MotionTokenGovernanceTest.php | accessibility | not_run | partial |
| unknown | resources/views/elements/motion/__tests__/baselines/js-timing-findings.php | unknown | not_run | incidental |
| unknown | resources/views/elements/spacing/__tests__/SpacingTokenGovernanceTest.php | class contract | not_run | partial |
| unknown | resources/views/components/ui/tag/__tests__/TagCssGovernanceTest.php | visual | not_run | partial |
| unknown | resources/views/components/ui/button/__tests__/ButtonCssGovernanceTest.php | visual | not_run | partial |
| unknown | tests/Feature/Ui/ShellPageHeaderComponentTest.php | accessibility | not_run | authoritative |
| unknown | tests/Feature/Ui/ShellPageHeaderComponentTest.php | accessibility | not_run | partial |
| unknown | resources/views/components/ui/button/__tests__/ButtonComponentTest.php | visual | not_run | authoritative |
| unknown | resources/views/elements/themes/__tests__/index.md | accessibility | not_run | incidental |
| unknown | tests/Feature/Patterns/CommonActions/ActionSetTest.php | accessibility | not_run | authoritative |
| unknown | resources/views/elements/themes/__tests__/index.md | accessibility | not_run | partial |
| unknown | resources/views/elements/color/__tests__/ColorTokenGovernanceTest.php | API rendering | not_run | authoritative |
| unknown | resources/views/components/ui/accordion/__tests__/fixtures/accordion.html | unknown | not_run | incidental |
| unknown | tests/Feature/Ui/ModalDialogCompileTest.php | JavaScript behavior | not_run | authoritative |
| unknown | resources/views/elements/__tests__/ElementContractSchemaTest.php | contract schema | not_run | partial |
| unknown | resources/views/elements/themes/__tests__/index.md | accessibility | not_run | incidental |
| unknown | resources/views/elements/__tests__/ElementContractSchemaTest.php | contract schema | not_run | partial |
| unknown | resources/views/elements/color/__tests__/index.md | visual | not_run | partial |
| unknown | resources/views/elements/typography/__tests__/index.md | visual | not_run | partial |
| unknown | resources/views/elements/color/__tests__/ColorTokenGovernanceTest.php | API rendering | not_run | partial |
| unknown | resources/views/components/ui/button/__tests__/ButtonCssGovernanceTest.php | visual | not_run | partial |
| unknown | resources/views/components/ui/accordion/__tests__/index.md | browser | not_run | partial |
| unknown | resources/views/elements/icons/__tests__/baselines/legacy-static-icon-usage.php | unknown | not_run | incidental |
| unknown | resources/views/elements/spacing/__tests__/baselines/component-spacing-geometry.php | accessibility | not_run | incidental |
| unknown | tests/Feature/Ui/ShellPageHeaderComponentTest.php | accessibility | not_run | authoritative |
| unknown | resources/views/elements/__tests__/ElementContractSchemaTest.php | contract schema | not_run | partial |
| unknown | tests/Feature/Ui/ModalDialogCompileTest.php | JavaScript behavior | not_run | authoritative |
| unknown | resources/views/elements/spacing/__tests__/index.md | accessibility | not_run | partial |
| unknown | resources/views/elements/spacing/__tests__/SpacingTokenGovernanceTest.php | class contract | not_run | partial |
| unknown | tests/Feature/Patterns/CommonActions/ActionSetTest.php | accessibility | not_run | partial |
| unknown | tests/Feature/Ui/NotificationPatternContractTest.php | JavaScript behavior | not_run | authoritative |
| unknown | resources/views/components/ui/tag/__tests__/TagCssGovernanceTest.php | visual | not_run | partial |
| unknown | resources/views/elements/icons/__tests__/index.md | API rendering | not_run | partial |
| unknown | resources/views/elements/__tests__/Support/CssTokenAudit.php | JavaScript behavior | not_run | incidental |
| unknown | resources/views/elements/icons/__tests__/IconElementGovernanceTest.php | accessibility | not_run | authoritative |
| unknown | tests/Feature/Ui/NotificationToastContractTest.php | JavaScript behavior | not_run | authoritative |
| unknown | resources/views/elements/themes/__tests__/ThemeTokenGovernanceTest.php | accessibility | not_run | authoritative |
| unknown | resources/views/elements/spacing/__tests__/baselines/component-margin-declarations.php | class contract | not_run | incidental |
| unknown | resources/views/elements/motion/__tests__/index.md | accessibility | not_run | partial |
| unknown | tests/Feature/Ui/NotificationToastContractTest.php | JavaScript behavior | not_run | authoritative |
| unknown | resources/views/elements/__tests__/ElementContractSchemaTest.php | contract schema | not_run | partial |
| unknown | tests/Feature/Ui/NotificationToastContractTest.php | JavaScript behavior | not_run | authoritative |
| unknown | tests/Feature/Ui/NotificationToastContractTest.php | JavaScript behavior | not_run | partial |
| unknown | resources/views/elements/grid/__tests__/TwoXGridTokenGovernanceTest.php | class contract | not_run | authoritative |
| unknown | tests/Feature/Ui/NotificationToastContractTest.php | JavaScript behavior | not_run | authoritative |
| unknown | resources/views/elements/themes/__tests__/ThemeTokenGovernanceTest.php | accessibility | not_run | partial |
| unknown | resources/views/elements/typography/__tests__/index.md | visual | not_run | partial |
| unknown | tests/Feature/Ui/NotificationPatternContractTest.php | JavaScript behavior | not_run | authoritative |
| unknown | resources/views/elements/grid/__tests__/index.md | browser | not_run | partial |
| unknown | resources/views/components/ui/tag/__tests__/TagComponentTest.php | accessibility | not_run | authoritative |
| unknown | tests/Feature/Ui/NotificationToastContractTest.php | JavaScript behavior | not_run | authoritative |
| unknown | resources/views/elements/themes/__tests__/index.md | accessibility | not_run | incidental |
| unknown | resources/views/elements/color/__tests__/index.md | visual | not_run | partial |
| unknown | resources/views/elements/typography/__tests__/TypographyTokenGovernanceTest.php | visual | not_run | authoritative |
| unknown | resources/views/elements/motion/__tests__/MotionTokenGovernanceTest.php | accessibility | not_run | partial |
| unknown | resources/views/elements/spacing/__tests__/index.md | accessibility | not_run | partial |
| unknown | resources/views/elements/spacing/__tests__/SpacingTokenGovernanceTest.php | class contract | not_run | authoritative |
| unknown | tests/Feature/Ui/NotificationPatternContractTest.php | JavaScript behavior | not_run | authoritative |
| unknown | resources/views/elements/spacing/__tests__/index.md | accessibility | not_run | partial |
| unknown | resources/views/elements/typography/__tests__/TypographyTokenGovernanceTest.php | visual | not_run | partial |
| unknown | tests/Feature/Ui/NotificationPatternContractTest.php | JavaScript behavior | not_run | partial |
| unknown | resources/views/elements/__tests__/ElementContractSchemaTest.php | contract schema | not_run | partial |
| unknown | resources/views/elements/grid/__tests__/index.md | browser | not_run | incidental |
| unknown | resources/views/elements/typography/__tests__/baselines/component-type-drift.php | class contract | not_run | incidental |
| unknown | resources/views/elements/color/__tests__/index.md | visual | not_run | incidental |
| unknown | resources/views/elements/spacing/__tests__/SpacingTokenGovernanceTest.php | class contract | not_run | partial |
| unknown | resources/views/elements/pictograms/__tests__/PictogramElementGovernanceTest.php | accessibility | not_run | authoritative |
| unknown | resources/views/elements/motion/__tests__/baselines/js-timing-findings.php | unknown | not_run | incidental |
| unknown | resources/views/elements/themes/__tests__/ThemeTokenGovernanceTest.php | accessibility | not_run | partial |
| unknown | resources/views/elements/motion/__tests__/MotionTokenGovernanceTest.php | accessibility | not_run | authoritative |
| unknown | resources/views/elements/motion/__tests__/index.md | accessibility | not_run | partial |
| unknown | tests/Feature/Ui/ShellPageHeaderComponentTest.php | accessibility | not_run | authoritative |
| unknown | resources/views/elements/icons/__tests__/index.md | API rendering | not_run | partial |
| unknown | resources/views/elements/spacing/__tests__/index.md | accessibility | not_run | partial |
| unknown | tests/Feature/Ui/NotificationPatternContractTest.php | JavaScript behavior | not_run | authoritative |
| unknown | resources/views/components/ui/accordion/__tests__/AccordionBladeContractTest.php | accessibility | not_run | authoritative |
| unknown | resources/views/elements/grid/__tests__/baselines/component-media-query-usage.php | class contract | not_run | incidental |

Issue #30 owns only the relationship between UI surfaces and their test evidence. Issue #32 owns complete test-suite execution, warnings, failure classification, and disposition.

## 9. Runtime Discovery

| Discovery | Current Attempt | Last Successful Evidence | Command |
| --- | --- | --- | --- |
| artisan_list | failed | absent | php artisan list --format=json |
| module_list | failed | present | php artisan platform:modules:list --json |
| route_list | failed | present | php artisan route:list --json |

## 10. Required Later Routing

- Which later owner resolves the reviewed accordion mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed account-main-index mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed account-main-legacy-platform-directory mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed account-main-security mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed account-nav-index mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed account-nav-preferences mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed account-nav-security mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed action-view-data mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed app mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed auth-challenge-form mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed breadcrumb mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed button mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed button-set mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed checkbox mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed checkbox-group mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed code-snippet mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed color mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed combo-box mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed combo-button mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed common-actions-action-set mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed common-actions-bulk-actions mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed common-actions-destructive-actions mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed common-actions-empty-state-actions mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed common-actions-page-actions mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed common-actions-recovery-actions mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed common-actions-row-actions mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed contained-list mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed contained-list-item mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed content-section-block mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed content-switcher mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed copy-button mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed create mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed dashboard-grid mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed data-list-item mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed data-table mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed data-table-toolbar mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed date-picker mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed date-picker-input mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed date-range-filter mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed delete mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed development-tools-widget mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed dialog mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed docs-viewer-nav-primary mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed dropdown mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed dropdown-action-menu mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed edit mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed empty-state mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed enhanced-data-table mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed error-health-widget mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed file-uploader mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed file-uploader-button mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed file-uploader-drop-container mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed file-uploader-item mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed filename mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed filterable-multi-select mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed form mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed form-group mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed form-item mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed form-label mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed form-section mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed forms-actions mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed forms-dialog mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed forms-page mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed forms-side-panel mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed grid mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed h-stack mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed header-action mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed header-menu mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed icon mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed icon-button mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed icons mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed identity-summary-card mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed index mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed inline-form-row mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed inline-loading mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed key-value-display mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed layouts-app-frame mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed layouts-app-frame-header mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed layouts-app-partials mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed link mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed list-item mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed loading mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed logging-nav-audit-logs mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed logging-nav-error-logs mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed menu mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed menu-button mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed menu-data-provider mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed menu-item mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed modal mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed module-notifications-css-root mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed module-notifications-js-root mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed motion mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed multi-select mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed nav-icon mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed notification mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed number-input mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ordered-list mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed overflow-menu mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed page-title-actions-row mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed pagination mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed pagination-nav mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed panel-data-provider mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed password-input mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed patterns-account-action-row mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed patterns-account-panel mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed patterns-account-section-tabs mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed patterns-account-settings-summary mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed patterns-notifications-actionable mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed patterns-notifications-callout mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed patterns-notifications-inline mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed patterns-notifications-modal mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed patterns-notifications-toast mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed pictograms mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed platform-stats-widget mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed popover mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed progress-bar mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed progress-indicator mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed progress-step mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed proof-note mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed proof-review-banner mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed proof-review-target mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed radio-button mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed radio-button-group mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed recent-audit-activity-widget mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed renders-on-dashboard mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed runtime mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed search mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed search-filter-bar mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed searchable-select mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed security-checklist-nav-primary mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed security-readiness-widget mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed select mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed select-item mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed select-item-group mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed settings-index mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed settings-main-index mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed settings-main-platform-index mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed setup-index mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed setup-main-index mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed show mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed slider mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed spacing mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed stack mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed stat-card mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed status-indicator mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed structured-list mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed structured-list-row mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed sub-navigation-bar mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed switch mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed system-notifications-widget mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed tabs mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed tag mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed tag-group mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed text-area mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed text-input mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed themes mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed tile mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed time-picker mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed toggle mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed toggletip mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed tooltip mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed tree-view mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed typography mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-badge mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-button-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-chat-button mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-chat-button-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-checkbox-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-danger-button mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-data-table-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-date-picker-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-drawer mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-dropdown-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-file-uploader-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-grid-column mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-icon-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-number-input-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-partials mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-patterns mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-radio-button-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-search-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-select-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-shell-content mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-shell-header mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-shell-page-header mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-shell-page-tabs mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-shell-page-title mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-shell-side-nav mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-shell-skip-to-content mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-shell-switcher mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-slider-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-text-area-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-text-input-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-toggle-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed ui-toggle-small-skeleton mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed unordered-list mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed v-stack mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed validation-summary mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed view-data mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed widget-registry mismatch evidence without changing current behavior in issue #30?
- Which later owner resolves the reviewed widget-shell mismatch evidence without changing current behavior in issue #30?

## 11. Review State

- Pending surface reviews: 0
- Pending standard reviews: 0
- Pending test-trace reviews: 0
- Orphaned prior surface reviews: 0
- Orphaned prior test traces: 0

Final acceptance requires all material surfaces and test traces to be reviewed, every mismatch to remain evidence-backed, and no target-state decision to be introduced by inventory tooling.
