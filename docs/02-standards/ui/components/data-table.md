---
title: Data table
slug: data-table
api_layer: Component API
status: implemented-pending-review
system_maturity: partial
category: data-display
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/components/data-table
canonical_doc: docs/02-standards/ui/components/data-table.md
source_owner: /platform/ui-reference/components/data-table
blade_api:
  - x-ui.data-table
  - x-ui.data-table-toolbar
  - x-ui.data-table-empty-state
  - x-ui.data-table-skeleton
javascript_api: []
source_files:
  - resources/views/components/ui/data-table.blade.php
  - resources/views/components/ui/data-table-toolbar.blade.php
  - resources/views/components/ui/data-table-empty-state.blade.php
  - resources/views/components/ui/data-table-skeleton.blade.php
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
  - motion
  - 2x-grid
related_components:
  - pagination
  - search
  - checkbox
  - radio-button
  - button
  - menu-buttons
  - structured-list
  - list
  - tag
  - loading
related_patterns:
  - tables
  - navigation
  - data-content
  - page-layout
carbon_reference:
  - https://carbondesignsystem.com/components/data-table/usage/
  - https://carbondesignsystem.com/components/data-table/style/
  - https://carbondesignsystem.com/components/data-table/accessibility/
---

# Data table Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard supports:](#31-the-installed-standard-supports)
  - [3.2. The installed standard does not automatically approve:](#32-the-installed-standard-does-not-automatically-approve)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Props and options](#43-props-and-options)
  - [4.4. Column data contract](#44-column-data-contract)
  - [4.5. Row data contract](#45-row-data-contract)
  - [4.6. CSS namespace](#46-css-namespace)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
  - [9.3. Selection boundaries:](#93-selection-boundaries)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. UI Reference proof checklist](#142-ui-reference-proof-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
  - [15.1. The UI Reference page must also show:](#151-the-ui-reference-page-must-also-show)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Data table organizes comparable records into aligned columns.

Canonical API owner: `/platform/ui-reference/components/data-table`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Data table is the installed Login App 2.0 API for tabular record display, scan hierarchy, sortable columns, row actions, loading/empty/error table states, responsive overflow handling, and composition with table-adjacent controls. It does not own server queries, feature-specific filters, pagination state, export workflows, bulk-action business logic, or page-level layout.

### 1.1. Canonical API responsibilities:

- Render tabular records through approved data table markup, classes, and Blade components.
- Preserve native table semantics for comparable columnar data.
- Provide a consistent title, description, toolbar, header, body, row, cell, and optional footer/pagination composition model.
- Support approved density, sorting, row action, loading, empty, error, selected/current, disabled-action, and responsive overflow states.
- Compose with Search, Button, Checkbox, Radio button, Menu buttons, Loading, Tag, and Pagination APIs where those controls appear inside or near the table.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, icons, and 2x Grid.
- Prove table examples with production UI in the UI Reference page.

### 1.2. Non-owned responsibilities:

- Data fetching, server sorting, server filtering, server pagination, and export orchestration. These belong to feature controllers, Livewire views, or Pattern APIs.
- Form workflow logic. Use Form Patterns.
- Bulk-action business rules. Data table may render the selected/batch UI; the owning Pattern or feature handles the action.
- Page-level layout, external spacing, and placement. Parent Patterns own surrounding geometry.
- Spreadsheet-like editing or complex grid manipulation. Data table is not a spreadsheet replacement.

## 2. Status and ownership

| Field              | Value                                                                                                                                                                           |
| ------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Status             | Approved API                                                                                                                                                                    |
| API layer          | Component API                                                                                                                                                                   |
| Component slug     | data-table                                                                                                                                                                      |
| Category           | Data display                                                                                                                                                                    |
| Priority           | Tier A - Baseline app development                                                                                                                                               |
| UI Reference route | `/platform/ui-reference/components/data-table`                                                                                                                                  |
| Canonical doc      | `docs/02-standards/ui/components/data-table.md`                                                                                                                                 |
| Source owner       | `/platform/ui-reference/components/data-table`                                                                                                                                  |
| System maturity    | Partial                                                                                                                                                                         |
| Correction outcome | The page/API documents exact table examples, states, row sizes, toolbar sizing, sorting, row actions, loading, empty, error, responsive overflow, Pagination composition, and gated selection/expansion boundaries. |

## 3. Installed standard

Data table now has component-specific UI Reference examples that consume approved Foundation Elements.

The installed standard is a semantic table API for comparable records. A table must have a clear data purpose, a meaningful accessible name, stable column headers, readable row spacing, visible row hover/focus states where applicable, and explicit loading/empty/error states.

### 3.1. The installed standard supports:

- Default table structure.
- Sortable column headers.
- Five approved row sizes: `xs`, `sm`, `md`, `lg`, and `xl`.
- Backward-compatible standard and compact density aliases.
- Small and large toolbar size pairing.
- Optional table title and description.
- Optional table toolbar for global table actions.
- Optional Search composition.
- Optional Filter Pattern composition.
- Optional row actions using Button or Menu buttons.
- Optional selected/current row treatment.
- Loading and skeleton table states.
- Empty and error table states.
- Responsive horizontal overflow wrapper.
- Pagination composition through the Pagination Component.

### 3.2. The installed standard does not automatically approve:

- Arbitrary data-grid libraries.
- Spreadsheet editing.
- Nested tables.
- Local row-hover styles.
- Feature-local density systems.
- Feature-local selection/batch action implementations.
- Fake sortable headers that do not update state or expose the correct accessibility attributes.

## 4. Public API

### 4.1. Canonical calls

The reusable Blade API is required by this standard and must replace placeholder/generic table examples as the correction is implemented.

```blade
<x-ui.data-table
    title="Users"
    description="Manage users with access to this workspace."
    :columns="$columns"
    :rows="$rows"
/>
```

```blade
<x-ui.data-table
    title="Tenants"
    :columns="$columns"
    :rows="$rows"
    density="compact"
    sortable
/>
```

```blade
<x-ui.data-table
    title="Audit events"
    :columns="$columns"
    :rows="$rows"
    :loading="$isLoading"
    empty-title="No audit events"
    empty-description="Events appear here after activity is recorded."
/>
```

```blade
<x-ui.data-table :columns="$columns" :rows="$rows" row-actions>
    <x-slot:toolbar>
        <x-ui.data-table-toolbar>
            <x-ui.search name="users_search" label="Search users" />
            <x-ui.button semantic="ghost">Export</x-ui.button>
        </x-ui.data-table-toolbar>
    </x-slot:toolbar>
</x-ui.data-table>
```

Use the canonical API instead of hand-building feature-local table wrappers. If the implementation has not yet installed the Blade component, the UI Reference correction must install it or explicitly mark the missing reusable API as a blocking gap. Do not leave `Component-specific API pending correction` in the standard or rendered page.

### 4.2. API surfaces

| API surface           | Installed value                                                                                                                                                                                                                                                              |
| --------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Primary Blade API     | `x-ui.data-table`                                                                                                                                                                                                                                                            |
| Toolbar Blade API     | `x-ui.data-table-toolbar`                                                                                                                                                                                                                                                    |
| Empty state Blade API | `x-ui.data-table-empty-state`                                                                                                                                                                                                                                                |
| Skeleton Blade API    | `x-ui.data-table-skeleton`                                                                                                                                                                                                                                                   |
| JavaScript            | No dedicated baseline JavaScript controller is required for static rendering. Sorting, filtering, pagination, row expansion, or server updates are Pattern/feature-owned unless a table controller is explicitly installed and documented.                                   |
| Data attributes       | `data-ui-data-table`, `data-ui-data-table-toolbar`, `data-ui-data-table-row`, `data-ui-data-table-cell`, `data-ui-data-table-sort`, `data-ui-data-table-empty`, `data-ui-data-table-loading` where implemented by the component.                                             |
| Root semantic element | Native `<table>` inside an overflow-safe wrapper.                                                                                                                                                                                                                            |
| CSS namespace         | App-owned `ui-*` table classes documented by the component implementation.                                                                                                                                                                                                   |
| Source files          | `resources/views/components/ui/data-table.blade.php`; `resources/views/components/ui/data-table-toolbar.blade.php`; `resources/views/components/ui/data-table-empty-state.blade.php`; `resources/views/components/ui/data-table-skeleton.blade.php`; `resources/css/app.css` |

### 4.3. Props and options

| Prop/option        | Type            | Default           | Allowed values                     | Required    | Notes                                                                                                                                  |
| ------------------ | --------------- | ----------------- | ---------------------------------- | ----------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| `columns`          | `array`         | required          | Column config array                | Yes         | Defines header labels, keys, alignment, width hints, sortability, and optional cell type.                                              |
| `rows`             | `array`         | required          | Row data array                     | Yes         | Defines row values and optional row metadata.                                                                                          |
| `title`            | `string / null` | `null`            | Short table title                  | No          | Required unless the table is named by surrounding heading or `ariaLabel`.                                                              |
| `description`      | `string / null` | `null`            | Short supporting copy              | No          | Explains data source, scope, or freshness when useful.                                                                                 |
| `ariaLabel`        | `string / null` | `null`            | Accessible table name              | Conditional | Required when no visible title or external label names the table.                                                                      |
| `size`             | `string / null` | derived from density | `xs`, `sm`, `md`, `lg`, `xl`       | No          | Primary row-height API. Header row and body rows must match.                                                                           |
| `toolbarSize`      | `string / null` | derived from row size | `sm`, `lg`                         | No          | Toolbar height pairing. Small toolbars pair with `xs`/`sm`; large toolbars pair with `md`/`lg`/`xl`.                                   |
| `density`          | `string`        | `standard`        | `standard`, `compact`              | No          | Backward-compatible alias. `compact` maps to `sm`; `standard` maps to `md` unless `size` is set. Do not invent local density systems.   |
| `sortable`         | `bool`          | `false`           | `true`, `false`                    | No          | Enables sort affordance only for columns marked sortable. Requires accessible sort state handling.                                     |
| `sortBy`           | `string / null` | `null`            | Valid column key                   | No          | Current sorted column key.                                                                                                             |
| `sortDirection`    | `string / null` | `null`            | `asc`, `desc`, `null`              | No          | Current sort direction. Must update `aria-sort` when applicable.                                                                       |
| `loading`          | `bool`          | `false`           | `true`, `false`                    | No          | Renders skeleton rows or loading state. Prefer skeleton rows for table content.                                                        |
| `empty`            | `bool / null`   | derived from rows | `true`, `false`, `null`            | No          | Forces empty state if needed. Empty state must not render an empty tbody with no explanation.                                          |
| `emptyTitle`       | `string / null` | `null`            | Short empty-state title            | Conditional | Required when the empty state is rendered.                                                                                             |
| `emptyDescription` | `string / null` | `null`            | Short recovery or expectation copy | No          | Explain how rows appear or what the user can do next.                                                                                  |
| `error`            | `string / null` | `null`            | Short error message                | No          | Use when the table failed to load. Provide recovery when possible.                                                                     |
| `rowActions`       | `bool`          | `false`           | `true`, `false`                    | No          | Allows row action slot or configured row action menu. Actions must use Button or Menu buttons APIs.                                    |
| `selectable`       | `string / bool` | `false`           | `false`, `checkbox`, `radio`       | No          | Gated unless a canonical selection contract is implemented. Multi-select uses Checkbox; single-select uses Radio button.               |
| `pagination`       | `bool / slot`   | `false`           | `true`, `false`, slot/content      | No          | Composes Pagination below the table. Pagination owns page navigation controls.                                                         |
| `responsive`       | `string`        | `overflow`        | `overflow`                         | No          | Horizontal overflow is the default responsive treatment for dense data. Do not collapse columns into cards without a Pattern standard. |
| `striped`          | `bool`          | `false`           | `true`, `false`                    | No          | Zebra striping is deferred unless explicitly approved and proven.                                                                      |
| `class`            | `string / null` | `null`            | Layout passthrough if supported    | No          | Parent Patterns may pass layout classes. Do not use for local color, row-height, typography, border, or state overrides.               |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.4. Column data contract

```php
$columns = [
    [
        'key' => 'name',
        'label' => 'Name',
        'sortable' => true,
        'align' => 'start',
    ],
    [
        'key' => 'status',
        'label' => 'Status',
        'type' => 'status',
    ],
    [
        'key' => 'updated_at',
        'label' => 'Updated',
        'sortable' => true,
        'align' => 'end',
    ],
];
```

| Column key | Type            | Required | Notes                                                                 |
| ---------- | --------------- | -------- | --------------------------------------------------------------------- |
| `key`      | `string`        | Yes      | Maps the column to row data. Must be stable.                          |
| `label`    | `string`        | Yes      | Visible column header. Use one or two words where possible.           |
| `sortable` | `bool`          | No       | Set only when the sort behavior is implemented.                       |
| `align`    | `string`        | No       | `start`, `center`, `end`. Numeric values commonly use `end`.          |
| `type`     | `string / null` | No       | `text`, `numeric`, `date`, `status`, `actions`, or app-approved type. |
| `width`    | `string / null` | No       | Optional width hint. Do not use to force cramped content.             |
| `srLabel`  | `string / null` | No       | Optional screen-reader clarification if visible label is abbreviated. |

### 4.5. Row data contract

```php
$rows = [
    [
        'id' => 'tenant-001',
        'name' => 'Acme Workspace',
        'status' => 'Active',
        'updated_at' => '2026-06-08',
        'href' => route('platform.tenants.show', 'tenant-001'),
        'current' => false,
        'disabled' => false,
    ],
];
```

| Row key       | Type            | Required | Notes                                                                                                     |
| ------------- | --------------- | -------- | --------------------------------------------------------------------------------------------------------- |
| `id`          | `string / int`  | Yes      | Stable row key for DOM ids, selection, and testing.                                                       |
| Column values | mixed           | Yes      | Each configured column key should be represented unless a cell slot handles it.                           |
| `href`        | `string / null` | No       | Use only when row navigation is approved by the owning Pattern. Prefer explicit row actions for commands. |
| `current`     | `bool`          | No       | Marks the current or selected object in context. Must not rely on color alone.                            |
| `disabled`    | `bool`          | No       | Disables row-level actions, not table readability.                                                        |
| `actions`     | `array / null`  | No       | Row actions must render through Button or Menu buttons APIs.                                              |

### 4.6. CSS namespace

Allowed component classes are owned by the Data table API and must not be recreated locally.

```css
.ui-data-table
.ui-data-table-wrapper
.ui-data-table-header
.ui-data-table-title
.ui-data-table-description
.ui-data-table-toolbar
.ui-data-table-toolbar-sm
.ui-data-table-toolbar-lg
.ui-data-table-overflow
.ui-data-table-table
.ui-data-table-head
.ui-data-table-header-cell
.ui-data-table-sort-button
.ui-data-table-body
.ui-data-table-row
.ui-data-table-row-current
.ui-data-table-row-selected
.ui-data-table-cell
.ui-data-table-cell-actions
.ui-data-table-size-xs
.ui-data-table-size-sm
.ui-data-table-size-md
.ui-data-table-size-lg
.ui-data-table-size-xl
.ui-data-table-density-standard
.ui-data-table-density-compact
.ui-data-table-empty
.ui-data-table-error
.ui-data-table-skeleton
```

Do not use Carbon production class names such as `cds--data-table` or `bx--data-table` in Login App markup unless the app explicitly installs Carbon runtime CSS and documents that change.

## 5. Allowed variants, options, and modifiers

Data table has app-approved table modes and modifiers. It does not have decorative variants.

| Name                   | Type                          | Status                                     | API                                        | Use when                                                                                   | Do not use when                                                                  |
| ---------------------- | ----------------------------- | ------------------------------------------ | ------------------------------------------ | ------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------- |
| Default table          | Base mode                     | Approved API                               | `x-ui.data-table`                          | Records need aligned columns for scanning or comparison.                                   | Content is narrative or does not need column alignment.                          |
| Sortable table         | Behavior option               | Approved API                               | `sortable`, column `sortable=true`         | Users need to reorder by a meaningful column.                                              | Sorting is not implemented or would imply false precision.                       |
| Row size scale         | Size option                   | Approved API                               | `size="xs|sm|md|lg|xl"`                    | Row height must follow the approved 24/32/40/48/64px scale.                                | A feature wants a local row-height system.                                       |
| Toolbar size pairing   | Toolbar option                | Approved API                               | `toolbarSize="sm|lg"` / toolbar `size`     | Toolbar controls must pair with compact or standard row rhythm.                            | Small toolbars are paired with large rows or large toolbars with compact rows.   |
| Standard density       | Compatibility density         | Approved API                               | `density="standard"`                       | Existing callers need default admin table rhythm.                                          | New work can set `size="md"` directly.                                           |
| Compact density        | Compatibility density         | Approved API                               | `density="compact"`                        | Existing callers need dense admin rows or repeated management rows.                         | New work can set `size="sm"` directly.                                           |
| Table toolbar          | Composition option            | Approved API                               | `toolbar` slot / `x-ui.data-table-toolbar` | Global table search, filter, export, view, or settings actions exist.                      | The action belongs to an individual row.                                         |
| Row actions            | Composition option            | Approved API                               | `rowActions` / row action slot             | Each row has a small set of row-specific actions.                                          | The action applies to selected rows or the whole table.                          |
| Loading/skeleton table | State modifier                | Approved API                               | `loading` / `x-ui.data-table-skeleton`     | Table rows are loading or refreshing.                                                      | The entire page is unavailable; use a Pattern-owned page loading state.          |
| Empty table            | State modifier                | Approved API                               | `emptyTitle`, `emptyDescription`           | No records exist or current filters return no records.                                     | The table failed to load; use error state.                                       |
| Error table            | State modifier                | Approved API                               | `error`                                    | Data could not be loaded.                                                                  | Validation belongs to filters or forms outside the table.                        |
| Responsive overflow    | Layout modifier               | Approved API                               | `responsive="overflow"`                    | Dense columns exceed available width.                                                      | A simpler List, Structured list, or Tile layout would communicate better.        |
| Pagination composition | Related component composition | Implemented through Pagination API         | `pagination` / Pagination slot             | Data spans multiple pages.                                                                 | Data is small enough to show without paging.                                     |
| Checkbox row selection | Selection mode                | Gated                                      | `selectable="checkbox"`                    | Users need batch actions across multiple rows.                                             | A selection contract, batch action bar, and keyboard behavior are not installed. |
| Radio row selection    | Selection mode                | Gated                                      | `selectable="radio"`                       | Users must select exactly one row.                                                         | Single selection is better represented by a visible choice list or form control. |
| Expandable rows        | Expansion mode                | Gated                                      | `expandable` future option                 | Rows need optional supplementary detail.                                                   | Detail is required, complex, or better handled by a detail page/side panel.      |
| Zebra striping         | Visual modifier               | Deferred                                   | `striped` future option                    | Scanning horizontal data needs additional assistance and accessibility review approves it. | Used as decoration or as a substitute for hover/current/selected states.         |
| AI presence            | AI modifier                   | Do not implement until AI feature approved | none                                       | An approved AI-assisted data feature exists with explainability requirements.              | Speculative AI chrome is requested without a product-owned AI feature.           |

## 6. States

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

| State                    | Status         | Required implementation                                                                                                                                       |
| ------------------------ | -------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Default                  | Approved API   | Table renders title/description when provided, header row, body rows, and token-backed borders/surfaces.                                                      |
| Hover row                | Approved API   | Row hover uses table row hover token/classes to improve scanning. Hover does not imply clickability unless row interaction is installed.                      |
| Focus-visible            | Approved API   | Sort buttons, row actions, search, filters, checkboxes, menus, and pagination controls show visible focus.                                                    |
| Active/pressed           | Approved API   | Sort buttons, row action buttons, and toolbar controls expose pressed/active state where applicable.                                                          |
| Sorted ascending         | Approved API   | Sorted column shows visual indicator and `aria-sort="ascending"` when using native sortable headers.                                                          |
| Sorted descending        | Approved API   | Sorted column shows visual indicator and `aria-sort="descending"`.                                                                                            |
| Unsorted sortable column | Approved API   | Sort affordance appears on hover/focus or with app-approved persistent treatment.                                                                             |
| Current row              | Approved API   | Current row has a visual treatment and non-color cue where needed.                                                                                            |
| Selected row             | Gated          | Requires checkbox/radio selection contract. Must not be faked with row color alone.                                                                           |
| Disabled row action      | Approved API   | Disabled row actions use the Button/Menu buttons disabled contract. Row content remains readable.                                                             |
| Loading                  | Approved API   | Prefer skeleton rows over a spinner for table content.                                                                                                        |
| Empty                    | Approved API   | Empty state includes title and optional recovery/expectation copy.                                                                                            |
| Error                    | Approved API   | Error state explains loading failure and recovery when possible.                                                                                              |
| Responsive overflow      | Approved API   | Table remains semantically a table inside an overflow-safe wrapper.                                                                                           |
| Read-only                | Not applicable | Data tables are usually read-only display. Interactive controls inside rows own their own disabled/read-only state.                                           |
| Validation               | Not applicable | Validation belongs to table filters, forms, or editable-cell patterns. Data table does not own inline validation unless an editable grid Pattern is approved. |
| Editable cell            | Deferred       | Editable cells require a separate Pattern/API and are not approved by this standard.                                                                          |

## 7. Token, class, and helper usage

Data table consumes Foundation Color, Spacing, Typography, Themes, Icons, Motion, and 2x Grid tokens through `ui-data-table*` classes.

### 7.1. Foundation Elements consumed:

- Color
- Spacing
- Typography
- Themes
- Icons
- Motion
- 2x Grid

| Foundation Element | Allowed Data table usage                                                                                                              |
| ------------------ | ------------------------------------------------------------------------------------------------------------------------------------- |
| Color              | Table surface, header surface, row surface, row hover, selected/current row, borders, text, icon, focus, skeleton, and status tokens. |
| Spacing            | Header spacing, toolbar spacing, cell padding, row density, action spacing, and empty-state spacing.                                  |
| Typography         | Table title, description, column header text, cell text, helper/empty/error text, and status labels.                                  |
| Themes             | Table must remain readable in supported light, dark, inline, inverse, and high-contrast contexts.                                     |
| Icons              | Sort indicators, row action triggers, empty/error icons if approved, and status icons through Heroicons.                              |
| Motion             | Loading/skeleton and menu/toolbar interactions must respect reduced-motion preferences.                                               |
| 2x Grid            | Parent layouts place the table in page regions; table itself does not redefine page grid.                                             |

Carbon color role mapping:

Data table color alignment must follow the Color Element’s Carbon coverage and value mapping contract. Carbon’s Data table style rows are the coverage benchmark; Login App owns the production API and token names.

| Carbon token / role | Carbon responsibility | Login App token / API | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | -------------- | ---------- |
| `$layer` | Table header, row, toolbar, and AI table background | `ui-data-table`, `ui-data-table-toolbar`, `--ui-layer-01` / contextual layer role | Same role / app value unless theme map records same value | Table surfaces and toolbar surfaces consume the same contextual layer role at the same depth. |
| `$layer-accent`, `$layer-accent-hover` | Column header and zebra/hover accent surfaces | Data table header/row state classes using app layer-accent role when installed | Same role / app value or Not adopted if accent roles are not installed | Do not fake accent/zebra rows with local gray utilities. |
| `$layer-selected`, `$layer-selected-hover` | Selected row and selected-hover row surfaces | Data table selected/current row classes using selected layer roles | Same role / app value unless theme map records same value | Selected/current state must also include non-color structure or label where needed. |
| `$background-brand`, `$text-on-color` | Batch action bar surface and selected-row summary text | Batch action bar tokens/classes when batch actions are installed | Not adopted until batch actions are implemented | Batch actions remain gated; do not create feature-local batch bars. |
| `$border-subtle`, `$border-strong`, `$border-interactive` | Table dividers, row boundaries, focus/selection borders | Data table border classes using `--ui-border-*` | Same role / app value unless theme map records same value | Borders must come from Color Element roles and remain consistent with cards/forms/lists. |
| `$focus`, `$focus-inset` | Sort controls, row action controls, toolbar controls | Focus-visible treatment from owning Button/Menu/Search/Table controls | Same role / app value unless theme map records same value | Table focus styles must not be removed or tuned per feature. |
| `$skeleton-element`, `$skeleton-background` | Loading/skeleton table rows | `x-ui.data-table-skeleton` and Loading/Skeleton roles | Same role / app value once installed; current loading utilities until then | Loading placeholders must not be local gray blocks. |
| AI table tokens such as `$ai-aura-start-sm`, `$ai-aura-stop`, `$ai-border-*`, `$ai-drop-shadow`, `$ai-inner-shadow` | AI presence variants | No general Data table API until AI table variant is approved | Not adopted | Keep AI tokens gated; do not apply AI styling to ordinary tables. |

Allowed helpers/classes are the public Data table API classes documented above. Do not add feature-local classes that redefine row height, border color, hover color, focus treatment, sort icons, toolbar height, or loading skeleton colors.

## 8. Composition rules

- Use native table semantics first: `<table>`, `<thead>`, `<tbody>`, `<tr>`, `<th>`, and `<td>`.
- Provide a visible title or accessible label for every table.
- Use stable column headers. Do not hide required column context in tooltips only.
- Column headers own sort controls when sorting is installed.
- Sorting may be server-side or client-side, but the rendered state must match the actual current sort.
- If a column is sortable, update the visual indicator and `aria-sort` state.
- The table toolbar is reserved for global table actions such as search, filters, settings, export, create, or view controls.
- Row actions are functions for one specific row and must use Button or Menu buttons APIs.
- If a row action menu has fewer than three options, prefer visible icon buttons when the table density and accessibility contract allow it.
- Search inside a table toolbar composes the Search Component; the table does not redefine search behavior.
- Filtering is Pattern-owned. Data table may reserve the toolbar area for filters, but the filter state model belongs to the Filters/Table Pattern.
- Pagination is always composed below the related table region and is owned by the Pagination Component.
- Loading table content should use skeleton rows. Use spinner only for small local actions, not full table row loading.
- Empty states must explain why no rows appear or how rows will appear.
- Do not nest data tables inside data tables.
- Do not place dense data tables inside narrow cards or cramped sidebars unless a Pattern explicitly owns that responsive behavior.
- Tables may use horizontal overflow for dense columns. Do not collapse data into cards unless a responsive Pattern standard exists.
- Components own internal semantics and styling. Parent Patterns own grouping, external spacing, workflow orchestration, and page-level layout.

## 9. Selection guidance

### 9.1. Use when:

- Users need to scan, compare, or inspect structured records.
- Data has stable columns with values that align across rows.
- Users need sorting, row actions, status comparison, or paginated records.
- A record set belongs in the page’s main content area with enough width to avoid excessive truncation.

### 9.2. Do not use when:

- Content is narrative, instructional, or not comparable across rows.
- A List, Structured list, Tile, or Card composition communicates the content more clearly.
- The task requires spreadsheet-like editing, formula behavior, merged cells, freeform cell editing, or complex keyboard grid behavior.
- The table would be nested inside another table.
- The available width forces severe truncation of essential data.
- The feature only needs a small visible set of choices; use Checkbox, Radio button, Select, Dropdown, or Toggle as appropriate.

### 9.3. Selection boundaries:

- Use Data table when rows must align across multiple columns.
- Use Structured list when rows need comparable labels/values but not full table structure.
- Use List for content-only lists without column comparison.
- Use Tile/Card composition for object summaries or navigational cards.
- Use Pagination for paging controls; do not embed pagination logic into local table markup.

## 10. Accessibility contract

- Provide an accessible name for every table through visible title association, `aria-label`, or `aria-labelledby`.
- Use semantic table structure for tabular data.
- Use `<th scope="col">` for column headers.
- Use `<th scope="row">` only when row headers are semantically useful.
- Sortable headers must be keyboard reachable and activatable with Enter or Space.
- Sorted columns must expose the current sort state with `aria-sort`.
- Interactive controls inside cells must remain in the normal tab order and keep their own keyboard behavior.
- Row action buttons and menus must have specific accessible names such as `Edit Acme Workspace` rather than `Edit` when repeated across rows.
- Selection controls must use Checkbox or Radio button APIs and preserve group/row labeling.
- Empty, loading, and error states must provide text, not color-only or icon-only meaning.
- Focus must remain visible in light and dark themes.
- Horizontal overflow regions must remain keyboard accessible.
- Do not rely on row color alone to communicate selected, current, disabled, error, or warning meaning.

## 11. Content contract

- Use a table title that names what the rows have in common.
- Add a description when users need source, scope, freshness, or context.
- Use sentence case for titles, descriptions, column headers, toolbar actions, and empty/error copy.
- Keep column titles to one or two words where possible.
- If a column title must be abbreviated, provide a clear accessible label or tooltip according to the Tooltip standard.
- Use consistent data formatting inside each column.
- Align numeric values consistently, usually to the end side.
- Use explicit row action labels such as `Edit user`, `Deactivate tenant`, or `Open audit event`.
- Empty states should explain whether there is no data, no filtered result, or data is not available yet.
- Error states should explain the failure and provide recovery when available.
- Do not use table cell color as decoration.
- Do not include speculative API calls or placeholder data that looks production-ready but cannot be used.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, local row-hover styles, or custom JavaScript.
- Do not force body content into table structure when alignment is not needed.
- Do not create local density, border, focus, toolbar, skeleton, or row-hover treatments.
- Do not use Data table as a spreadsheet replacement.
- Do not nest data tables inside data tables.
- Do not place data tables in cramped containers where essential columns must be hidden or excessively truncated without a Pattern standard.
- Do not fake sorting by rendering sort icons without updating sort state and data order.
- Do not fake selection or batch actions without a documented selection contract.
- Do not render Pagination controls inside the table body.
- Do not use support colors decoratively inside cells.
- Do not use Carbon production class names directly unless Login App adopts the Carbon runtime and updates this standard.

## 13. Deferred or gated capabilities

| Capability                 | Status           | Gate                                                                                                                                    | Approved alternative today                                                 |
| -------------------------- | ---------------- | --------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------- |
| Checkbox row selection     | Gated            | Requires selection state contract, header checkbox indeterminate behavior, batch action bar, keyboard behavior, and UI Reference proof. | Use row actions or a separate Checkbox group Pattern.                      |
| Radio row selection        | Gated            | Requires single-select state contract and clear action ownership.                                                                       | Use Radio button group when the choices do not require full table columns. |
| Batch actions              | Gated            | Requires selected-row state, batch toolbar, cancel/deselect behavior, and destructive-action guidance.                                  | Use row actions or Pattern-owned management workflow.                      |
| Expandable rows            | Gated            | Requires expansion control, panel semantics, content boundary, loading behavior, and keyboard/focus behavior.                           | Link to a detail page, side panel, Modal, or Accordion where appropriate.  |
| Editable cells             | Deferred         | Requires full editable-grid Pattern, validation, keyboard, save/cancel, error, and undo behavior.                                       | Use forms, modals, or detail pages for editing.                            |
| Column resizing/reordering | Deferred         | Requires interaction, persistence, keyboard, and responsive behavior standards.                                                         | Use approved table layout only.                                            |
| Zebra striping             | Deferred         | Requires explicit scanning need and accessibility review.                                                                               | Use hover/current/selected states and clean spacing.                       |
| Sticky header/columns      | Deferred         | Requires overflow, keyboard, zoom, and responsive review.                                                                               | Keep table in main content with enough space.                              |
| AI presence                | Do not implement | Requires approved AI-assisted feature, AI label standard, explainability content, and legal/product review.                             | Use normal status, tag, or notification APIs.                              |

No deferred capability may be implemented locally. Future extensions require an updated Component standard and UI Reference proof.

## 14. Implementation and UI Reference Checklist
### 14.1. Implementation checklist
| Requirement                | Standard expectation                                                                                                                               |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source          | The standard names the canonical Blade component, native/class API, JavaScript controller, CSS namespace, source files, or explicit deferred gate. |
| Variants/options/modifiers | Approved variants, options, sizes, density, layout modifiers, and deferred gates are listed.                                                       |
| States                     | Default, hover, focus-visible, active/pressed, disabled, loading, validation, selected, empty, or not-applicable states are defined as relevant.   |
| Accessibility/content      | Keyboard, focus, naming, ARIA, contrast, reduced-motion, label, helper, error, and copy requirements are defined.                                  |
| Element consumption        | Required Color, Spacing, Typography, Icons, Motion, Themes, and 2x Grid dependencies are named.                                                    |
| Tests                      | Source/API assertions and UI Reference route assertions block generic fallback content.                                                            |

### 14.2. UI Reference proof checklist
| Requirement               | Visual proof expectation                                                                              |
| ------------------------- | ----------------------------------------------------------------------------------------------------- |
| Live examples             | The page renders production examples through the documented API or explicit native/class contract.    |
| Rendered variants/options | Every applicable supported variant, option, size, modifier, or deferred trigger condition is shown.   |
| Rendered states           | Required states are shown visually and with accessibility markers where relevant.                     |
| Developer implementation  | Real canonical calls and token-backed code snippets appear instead of placeholder comments.           |
| Related APIs              | Nearby Components, owning Patterns, consumed Elements, source files, and canonical docs are linked.   |
| Manual review             | The page provides enough rendered proof for visual review of behavior, layout, and state correctness. |
## 15. UI Reference requirements

The UI Reference page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

Data table is a broad, matrix-heavy component. Its Live examples card may use grouped sections, matrices, comparison grids, state tables, and full-width demonstrations instead of the simple Accordion-style tab-only model.

| Required proof                  | Rendered behavior                                                                                                                                           | Variants/options shown                                                                                                     |
| ------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------- |
| Basic sortable table            | Minimum viable semantic table with title, description, stable columns, several rows, and at least one real sortable column state.                           | Standard density, sortable ascending, sortable descending, unsorted sortable header, row hover, focus-visible sort control |
| Compact management table        | Dense admin table used for management lists. Header and body row density must match.                                                                        | Compact density, row actions, disabled row action, current row                                                             |
| Filterable toolbar table        | Table with global controls above the table body. Search and filters are visibly composed through their own APIs.                                            | Toolbar, Search composition, Filter Pattern handoff, primary/ghost toolbar action, responsive toolbar behavior             |
| Row actions table               | Table rows expose row-specific actions without making the whole row an ambiguous click target.                                                              | Inline icon actions, Menu button overflow action, focus-visible action, disabled action, accessible row-specific labels    |
| Loading table                   | Loading rows preserve table geometry while data is pending.                                                                                                 | Skeleton rows, loading label/status, reduced-motion-safe loading behavior                                                  |
| Empty table                     | Empty table explains why no rows appear and what happens next.                                                                                              | Empty title, empty description, optional recovery action, no-data vs no-filter-results wording                             |
| Error table                     | Table failure state communicates load failure and recovery.                                                                                                 | Error message, retry action when available, non-color error meaning                                                        |
| Responsive overflow table       | Dense columns remain in a semantic table inside an overflow-safe region.                                                                                    | Horizontal overflow wrapper, no column-to-card collapse, keyboard-reachable controls, 2x Grid placement note               |
| Pagination composition          | Pagination appears below the related table region and remains owned by the Pagination Component.                                                            | Pagination handoff, page-size selector if installed, disabled prev/next state                                              |
| Selection and batch-action gate | If not implemented, show trigger conditions rather than fake selectable UI. If implemented, render real checkbox/radio selection and batch action behavior. | Checkbox selection gated, radio selection gated, batch action bar gated, indeterminate header checkbox gate                |
| Expandable-row gate             | If not implemented, show trigger conditions rather than fake expandable rows. If implemented, render a real expansion control and panel.                    | Expandable rows gated, expandable + selectable gated, expanded loading skeleton gate                                       |

### 15.1. The UI Reference page must also show:

- Installed API table.
- Column and row data contracts.
- State matrix.
- Density comparison.
- Component/pattern ownership boundaries.
- Prohibited local workarounds.
- Foundation Elements consumed.
- Related Pagination, Search, Menu buttons, Checkbox, Radio button, Loading, List, and Structured list APIs.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/data-table` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The page does not contain `Component-specific API pending correction`.
- The page does not contain generic fallback component content.
- The page does not contain deprecated `tier-1` or `tier-2` canonical doc paths.
- The page shows `x-ui.data-table` or explicitly marks missing reusable Blade installation as a blocking correction.
- The page shows basic sortable table, compact management table, filterable toolbar table, row actions table, loading table, empty table, error table, responsive overflow table, pagination composition, selection/batch gate, and expandable-row gate.
- The page shows Standard density and Compact density.
- The page shows sorted ascending, sorted descending, and unsorted sortable states.
- The page shows loading/skeleton, empty, and error states.
- The page links to Pagination as the owner for paging controls.
- The page distinguishes Data table from List, Structured list, Tile/Card, Checkbox, Radio button, and Select/Dropdown-style selection controls.
- The page uses app-owned `ui-*` classes and does not use Carbon production classes such as `cds--data-table` or `bx--data-table`.
- The canonical doc link on the UI Reference page points to `docs/02-standards/ui/components/data-table.md`.

Suggested feature assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/data-table');

$response->assertOk();
$response->assertSee('Data table');
$response->assertSee('x-ui.data-table');
$response->assertSee('Basic sortable table');
$response->assertSee('Compact management table');
$response->assertSee('Filterable toolbar table');
$response->assertSee('Row actions table');
$response->assertSee('Loading table');
$response->assertSee('Empty table');
$response->assertSee('Error table');
$response->assertSee('Responsive overflow table');
$response->assertSee('Pagination composition');
$response->assertSee('Selection and batch-action gate');
$response->assertSee('Expandable-row gate');
$response->assertSee('Standard density');
$response->assertSee('Compact density');
$response->assertSee('sortable');
$response->assertSee('aria-sort');
$response->assertSee('Pagination');
$response->assertSee('Structured list');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('generic fallback');
$response->assertDontSee('tier-1/data-table.md');
$response->assertDontSee('tier-2/data-table.md');
```

## 17. Related APIs

| API                   | Route                                               | Relationship                                                                            |
| --------------------- | --------------------------------------------------- | --------------------------------------------------------------------------------------- |
| Pagination            | `/platform/ui-reference/components/pagination`      | Owns page navigation controls below table content.                                      |
| Search                | `/platform/ui-reference/components/search`          | Owns search input and clear/loading behavior used in table toolbar.                     |
| Checkbox              | `/platform/ui-reference/components/checkbox`        | Owns multi-select controls when row selection is implemented.                           |
| Radio button          | `/platform/ui-reference/components/radio-button`    | Owns single-select row controls when implemented.                                       |
| Button                | `/platform/ui-reference/components/button`          | Owns toolbar and row action buttons.                                                    |
| Menu buttons          | `/platform/ui-reference/components/menu-buttons`    | Owns row overflow and toolbar overflow action menus.                                    |
| Loading               | `/platform/ui-reference/components/loading`         | Owns loading family; Data table prefers skeleton rows for table content.                |
| Tag                   | `/platform/ui-reference/components/tag`             | Owns status/metadata tags inside cells.                                                 |
| Structured list       | `/platform/ui-reference/components/structured-list` | Alternative for comparable rows without full table behavior.                            |
| List                  | `/platform/ui-reference/components/list`            | Alternative for content-only lists.                                                     |
| Table patterns        | `/platform/ui-reference/patterns/tables`            | Own higher-level filter, bulk-action, server pagination, and data-management workflows. |
| Data/content patterns | `/platform/ui-reference/patterns/data-content`      | Own data page composition and object-detail workflows.                                  |
| Components overview   | `/platform/ui-reference/components`                 | Component catalog owner.                                                                |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- [Carbon Data table usage](https://carbondesignsystem.com/components/data-table/usage/)
- [Carbon Data table style](https://carbondesignsystem.com/components/data-table/style/)
- [Carbon Data table accessibility](https://carbondesignsystem.com/components/data-table/accessibility/)
