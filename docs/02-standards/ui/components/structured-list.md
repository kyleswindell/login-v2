---
title: Structured list
slug: structured-list
api_layer: Component API
status: implemented-pending-review
system_maturity: complete
category: data-display
priority: tier-c-contextual-or-deferred
ui_reference_route: /platform/ui-reference/components/structured-list
canonical_doc: docs/02-standards/ui/components/structured-list.md
source_owner: /platform/ui-reference/components/structured-list
blade_api:
  - x-ui.structured-list
native_api:
  - table
  - caption
  - thead
  - tbody
  - tr
  - th
  - td
javascript_api:
  - initStructuredLists
source_files:
  - resources/views/components/ui/structured-list.blade.php
  - resources/views/platform/ui-reference/components/live-examples/structured-list.blade.php
  - resources/js/ui-controls/structured-lists.js
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - 2x-grid
related_components:
  - list
  - contained-list
  - data-table
  - tile
  - checkbox
  - radio-button
  - link
  - loading
  - inline-loading
related_patterns:
  - forms
  - tables
  - layout
  - overlays-feedback
carbon_reference:
  - https://carbondesignsystem.com/components/structured-list/usage/
  - https://carbondesignsystem.com/components/structured-list/style/
  - https://carbondesignsystem.com/components/structured-list/accessibility/
  - https://carbondesignsystem.com/components/structured-list/code/
---

# Structured list Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Markup and class contract](#43-markup-and-class-contract)
  - [4.4. Alignment contract](#44-alignment-contract)
  - [4.5. Density contract](#45-density-contract)
  - [4.6. Selection contract](#46-selection-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
  - [7.4. Helper ownership](#74-helper-ownership)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
  - [9.3. Variant selection:](#93-variant-selection)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. UI Reference proof checklist](#142-ui-reference-proof-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
  - [15.1. Required Live examples internal sections:](#151-required-live-examples-internal-sections)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Structured list compares rich rows where a full data table would be excessive.

Canonical API owner: `/platform/ui-reference/components/structured-list`. Use this Component API instead of creating local markup, styling, density, alignment, selection, skeleton, or responsive behavior for the same UI role.

Structured list is the installed Login App 2.0 API for compact row/column comparison where users need more structure than a simple List but do not need Data table functionality. It owns simple table semantics, column headers, row headers, rich row content, density, alignment, row separators, selected/current presentation where composed with native controls, loading/empty states, wrapping/overflow behavior, and responsive layout. It does not own sorting, filtering, pagination, bulk actions, column resizing, row expansion, editable cells, drag-and-drop, row action menus, or deep data-table workflows.

### 1.1. Canonical API responsibilities:

- Render structured comparison through native table semantics and app-owned `ui-structured-list*` classes.
- Use column headers when rows compare repeated properties.
- Use row headers when each row has a primary subject.
- Support default and condensed density.
- Support hang and flush alignment where the installed CSS proves both modes.
- Support selectable rows only through visible native radio controls and the installed selectable structured-list helper.
- Keep hidden selection controls, custom keyboard grids, and multi-selection gated unless a later API proves them.
- Preserve readable wrapping for rich row content.
- Provide empty and loading/skeleton states for data-backed structured lists.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, and 2x Grid where placement is relevant.
- Prove default, condensed, selectable, selected, focus, disabled, empty, loading/skeleton, overflow, responsive, and implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Aligned data with sorting, filtering, pagination, bulk actions, row actions, or large record sets. Use Data table.
- Simple body-content bullets or numbered content. Use List.
- Compact card/sidebar row groups with inline actions. Use Contained list only when its deferred/gated API is accepted and proved.
- Clickable card-like rows or dashboard surfaces. Use Tile.
- Navigation menus, disclosure menus, tree navigation, or tabular keyboard grids. Use Menu, Tree view, Tabs, or Data table where those APIs own the behavior.
- Form field validation. Use field Components and Forms Pattern.
- External spacing, page placement, data fetching, sorting, filtering, selection persistence, and workflow orchestration. Parent Patterns own those responsibilities.

Carbon alignment note: Carbon treats Structured list as a row/column comparison component with column headers, rich rows, default and condensed height sizes, hang and flush alignment, and an optional selectable mode. Carbon also notes that flush alignment is not paired with selectable functionality. Login App maps those completeness principles to native table markup, app-owned `ui-*` classes, visible native selection controls, Foundation tokens, and route-owned UI Reference proof rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                                          |
| ---------------------------- | -------------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented Pending Review                                                                                     |
| System maturity              | Complete                                                                                                       |
| API layer                    | Component API                                                                                                  |
| Component slug               | `structured-list`                                                                                              |
| Category                     | Data display                                                                                                   |
| Priority                     | Tier C - Contextual or deferred                                                                                |
| UI Reference route           | `/platform/ui-reference/components/structured-list`                                                            |
| Canonical doc                | `docs/02-standards/ui/components/structured-list.md`                                                           |
| Source owner                 | `/platform/ui-reference/components/structured-list`                                                            |
| Blade API                    | `x-ui.structured-list`                                                                                        |
| Native API                   | `<table>` with `<caption>`, `<thead>`, `<tbody>`, `<tr>`, `<th>`, and `<td>`                                   |
| JavaScript API               | `initStructuredLists` for selectable full-row click and arrow-key movement                                     |
| Source files                 | `resources/views/components/ui/structured-list.blade.php`; `resources/views/platform/ui-reference/components/live-examples/structured-list.blade.php`; `resources/js/ui-controls/structured-lists.js`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, 2x Grid where composed in layouts                                  |
| Carbon benchmark             | Carbon Structured list usage, style, code, and accessibility guidance                                          |

`Implemented Pending Review` means the installed Blade API, UI Reference examples, JavaScript behavior, CSS contract, and tests are in place and ready for manual review against this standard.

## 3. Installed standard

Structured list is represented through the installed `x-ui.structured-list` Blade API, which renders native table markup and app-owned classes. Feature views should use that API instead of local table/list markup for this UI role.

### 3.1. The installed standard is:

- Render the baseline component with `<x-ui.structured-list>`, which emits `<table class="ui-structured-list">`.
- Include a visible or visually hidden `<caption>` that names the comparison.
- Use `<thead>` and `<th scope="col">` when columns compare repeated properties.
- Use `<th scope="row">` for the primary subject of each data row.
- Use `<tbody>` for all data rows.
- Use `.ui-structured-list` as the required root class for app-owned table layout, typography, borders, density, alignment, state, theme, and responsive behavior.
- Use `.ui-structured-list-condensed` only for short, dense administrative comparisons.
- Use `.ui-structured-list-hang` for the default hanging alignment where row content aligns under the header structure.
- Use `.ui-structured-list-flush` only for non-selectable structured lists where the UI Reference proves the layout.
- Use `.ui-structured-list-selectable` only when rows include visible native radio or checkbox controls and the UI Reference proves selection behavior.
- Keep native controls as the selection source of truth. The JavaScript helper may add full-row click and arrow-key movement, but it must keep checked state, selected row state, and disabled state synchronized.
- Use `.ui-structured-list-row-selected` only as a visual companion to a checked native control or current-row state.
- Use empty-state copy instead of rendering an empty table as the only feedback.
- Use skeleton rows or Loading/Inline loading composition for data-backed loading states.
- Keep the component non-sortable and non-paginated.
- Parent Patterns own external spacing, responsive columns, data loading, selection persistence, form submission, and workflow orchestration.

## 4. Public API

### 4.1. Canonical calls

Default structured list:

```blade
<x-ui.structured-list
    caption="Workspace access"
    :columns="[
        ['key' => 'workspace', 'label' => 'Workspace'],
        ['key' => 'role', 'label' => 'Role'],
        ['key' => 'status', 'label' => 'Status'],
    ]"
    :rows="$rows"
/>
```

Rendered structure:

```blade
<table class="ui-structured-list ui-structured-list-hang">
    <caption class="sr-only">Workspace access summary</caption>
    <thead class="ui-structured-list-head">
        <tr class="ui-structured-list-row">
            <th class="ui-structured-list-header" scope="col">Workspace</th>
            <th class="ui-structured-list-header" scope="col">Role</th>
            <th class="ui-structured-list-header" scope="col">Status</th>
        </tr>
    </thead>
    <tbody class="ui-structured-list-body">
        <tr class="ui-structured-list-row">
            <th class="ui-structured-list-cell ui-structured-list-row-header" scope="row">
                Acme admin
            </th>
            <td class="ui-structured-list-cell">Owner</td>
            <td class="ui-structured-list-cell">Active</td>
        </tr>
        <tr class="ui-structured-list-row">
            <th class="ui-structured-list-cell ui-structured-list-row-header" scope="row">
                Field operations
            </th>
            <td class="ui-structured-list-cell">Editor</td>
            <td class="ui-structured-list-cell">Pending review</td>
        </tr>
    </tbody>
</table>
```

Condensed structured list:

```blade
<table class="ui-structured-list ui-structured-list-hang ui-structured-list-condensed">
    <caption class="sr-only">API token details</caption>
    <thead class="ui-structured-list-head">
        <tr class="ui-structured-list-row">
            <th class="ui-structured-list-header" scope="col">Token</th>
            <th class="ui-structured-list-header" scope="col">Scope</th>
            <th class="ui-structured-list-header" scope="col">Expires</th>
        </tr>
    </thead>
    <tbody class="ui-structured-list-body">
        <tr class="ui-structured-list-row">
            <th class="ui-structured-list-cell ui-structured-list-row-header" scope="row">
                Reporting export
            </th>
            <td class="ui-structured-list-cell">Read only</td>
            <td class="ui-structured-list-cell">June 30, 2026</td>
        </tr>
    </tbody>
</table>
```

Selectable structured list with visible native controls:

```blade
<table class="ui-structured-list ui-structured-list-hang ui-structured-list-selectable">
    <caption class="sr-only">Choose a workspace</caption>
    <thead class="ui-structured-list-head">
        <tr class="ui-structured-list-row">
            <th class="ui-structured-list-header ui-structured-list-selection-cell" scope="col">
                <span class="sr-only">Select</span>
            </th>
            <th class="ui-structured-list-header" scope="col">Workspace</th>
            <th class="ui-structured-list-header" scope="col">Plan</th>
            <th class="ui-structured-list-header" scope="col">Status</th>
        </tr>
    </thead>
    <tbody class="ui-structured-list-body">
        <tr class="ui-structured-list-row ui-structured-list-row-selected">
            <td class="ui-structured-list-cell ui-structured-list-selection-cell">
                <input
                    class="ui-radio"
                    type="radio"
                    name="workspace"
                    value="acme-admin"
                    checked
                    aria-labelledby="workspace-acme-label"
                >
            </td>
            <th id="workspace-acme-label" class="ui-structured-list-cell ui-structured-list-row-header" scope="row">
                Acme admin
            </th>
            <td class="ui-structured-list-cell">Enterprise</td>
            <td class="ui-structured-list-cell">Active</td>
        </tr>
    </tbody>
</table>
```

Empty state:

```blade
<div class="ui-structured-list-empty" role="status">
    No matching workspaces were found.
</div>
```

Use `x-ui.structured-list` and its emitted native table structure instead of hand-building comparison rows with raw tables, grids, cards, utility clusters, or local CSS in feature views.

### 4.2. API surfaces

| API surface         | Installed value                                                                                      |
| ------------------- | ---------------------------------------------------------------------------------------------------- |
| Blade component     | `x-ui.structured-list`                                                                               |
| Root native element | `<table>` for structured row/column comparison                                                       |
| Header elements     | `<caption>`, `<thead>`, `<th scope="col">`                                                           |
| Row elements        | `<tbody>`, `<tr>`, `<th scope="row">`, `<td>`                                                        |
| Selection controls  | Visible native radio/checkbox controls composed with approved Radio button or Checkbox APIs          |
| JavaScript          | `initStructuredLists` for selectable full-row click, Space, ArrowDown, and ArrowUp behavior          |
| Data attributes     | `data-ui-structured-list*` hooks for size, alignment, background, selectable rows, radios, and state |
| CSS namespace       | App-owned `ui-structured-list*` classes documented by this standard and the component implementation |
| Source owner        | `/platform/ui-reference/components/structured-list`                                                  |
| Token ownership     | Foundation Color, Spacing, Typography, Themes, Motion, and 2x Grid where composed in layouts         |

### 4.3. Markup and class contract

| API                                  | Type                | Status                                            | Required                                         | Notes                                                                          |
| ------------------------------------ | ------------------- | ------------------------------------------------- | ------------------------------------------------ | ------------------------------------------------------------------------------ |
| `<table>`                            | Native element      | Implemented                                       | Required                                         | Use only when row/column structure is meaningful.                              |
| `<caption>`                          | Native element      | Implemented                                       | Required                                         | Visible or visually hidden table name.                                         |
| `<thead>`                            | Native element      | Implemented                                       | Required when columns are present                | Use column headers for repeated properties.                                    |
| `<tbody>`                            | Native element      | Implemented                                       | Required                                         | Contains data rows.                                                            |
| `<tr>`                               | Native element      | Implemented                                       | Required                                         | Row wrapper.                                                                   |
| `<th scope="col">`                   | Native element      | Implemented                                       | Required for column headers                      | Header copy must be short and clear.                                           |
| `<th scope="row">`                   | Native element      | Implemented                                       | Required for row subject                         | Identifies each row’s primary item.                                            |
| `<td>`                               | Native element      | Implemented                                       | Required for supporting cells                    | Contains short text, small metadata, or approved inline Components.            |
| `.ui-structured-list`                | Root class          | Implemented                                       | Required                                         | Base layout, spacing, border, typography, state, and theme contract.           |
| `.ui-structured-list-head`           | Structural class    | Implemented / required proof                      | Optional                                         | Header section styling.                                                        |
| `.ui-structured-list-body`           | Structural class    | Implemented / required proof                      | Optional                                         | Body section styling.                                                          |
| `.ui-structured-list-row`            | Structural class    | Implemented                                       | Required on rows when using app styles           | Applies row separator, spacing, wrapping, and state styling.                   |
| `.ui-structured-list-header`         | Structural class    | Implemented                                       | Required on column headers when using app styles | Applies header typography and alignment.                                       |
| `.ui-structured-list-cell`           | Structural class    | Implemented                                       | Required on body cells when using app styles     | Applies row text styling and responsive behavior.                              |
| `.ui-structured-list-row-header`     | Structural class    | Implemented                                       | Required for row subject cells                   | Applies row-subject typography.                                                |
| `.ui-structured-list-hang`           | Alignment modifier  | Implemented / required proof                      | Optional                                         | Default alignment for richer row content.                                      |
| `.ui-structured-list-flush`          | Alignment modifier  | Implemented / required proof                      | Optional                                         | Non-selectable flush alignment only.                                           |
| `.ui-structured-list-condensed`      | Density modifier    | Implemented / required proof                      | Optional                                         | Dense structured comparison.                                                   |
| `.ui-structured-list-selectable`     | Mode modifier       | Implemented / required proof with native controls | Optional                                         | Requires visible radio/checkbox controls. Not compatible with flush alignment. |
| `.ui-structured-list-selection-cell` | Structural class    | Implemented / required proof                      | Required for selectable rows                     | Houses visible native selection control.                                       |
| `.ui-structured-list-row-selected`   | State class         | Implemented / required proof                      | Optional                                         | Visual companion to checked native control or current state.                   |
| `.ui-structured-list-row-current`    | State class         | Implemented / required proof                      | Optional                                         | Visual companion to a current row when the row represents current context.     |
| `.ui-structured-list-row-disabled`   | State class         | Implemented / required proof                      | Optional                                         | Visual support only; disabled semantics come from child controls.              |
| `.ui-structured-list-empty`          | Empty state class   | Implemented / required proof                      | Optional                                         | Use instead of an empty table alone.                                           |
| `.ui-structured-list-skeleton`       | Loading state class | Implemented / required proof                      | Optional                                         | Use for data-backed loading rows.                                              |

Any class, attribute, prop, or behavior not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.4. Alignment contract

| Alignment | Status                       | API                         | Use when                                                             | Do not use when                                                               |
| --------- | ---------------------------- | --------------------------- | -------------------------------------------------------------------- | ----------------------------------------------------------------------------- |
| Hang      | Implemented / required proof | `.ui-structured-list-hang`  | Rows contain richer text, multiple lines, or selectable composition. | A simple flush comparison is clearer and non-selectable.                      |
| Flush     | Implemented / required proof | `.ui-structured-list-flush` | Non-selectable rows need tighter alignment to the container edge.    | The structured list is selectable or rows contain complex multi-line content. |

### 4.5. Density contract

| Density   | Status                       | API                                                           | Use when                                                                                              | Do not use when                                                            |
| --------- | ---------------------------- | ------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------- |
| Default   | Implemented                  | `.ui-structured-list` without `.ui-structured-list-condensed` | Default row comparison, richer text, status summaries, and admin detail views.                        | A dense, short metadata comparison is required.                            |
| Condensed | Implemented / required proof | `.ui-structured-list-condensed`                               | Short rows in dense admin surfaces, side panels, card-adjacent summaries, or compact detail sections. | Rows contain long text, multiple paragraphs, or complex inline Components. |

### 4.6. Selection contract

| Selection model              | Status                                            | API                                                                   | Rule                                                                                               |
| ---------------------------- | ------------------------------------------------- | --------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------- |
| Non-selectable               | Implemented                                       | Base structured list                                                  | Default mode. Rows are static comparison content.                                                  |
| Single select                | Implemented / required proof with native controls | Radio button inside `.ui-structured-list-selection-cell`              | Use when one row must be chosen. Native radio owns keyboard and selection semantics.               |
| Multi-select                 | Gated / Pattern-owned                             | Checkbox inside `.ui-structured-list-selection-cell` only when proved | Requires bulk action and selection-state ownership before use.                                     |
| Clickable row selection      | Gated                                             | none                                                                  | Do not make entire rows clickable until keyboard, focus, label, and state behavior are documented. |
| Hidden control row selection | Not allowed                                       | none                                                                  | Selection controls must be visible or replaced by an approved installed API.                       |

## 5. Allowed variants, options, and modifiers

| Name                         | Type             | Status                                            | API                                                                                | Notes                                                                |
| ---------------------------- | ---------------- | ------------------------------------------------- | ---------------------------------------------------------------------------------- | -------------------------------------------------------------------- |
| Default structured list      | Variant          | Implemented                                       | `.ui-structured-list`                                                              | Standard row/column comparison.                                      |
| Condensed structured list    | Density          | Implemented / required proof                      | `.ui-structured-list-condensed`                                                    | Dense rows with short content.                                       |
| Hang alignment               | Alignment        | Implemented / required proof                      | `.ui-structured-list-hang`                                                         | Default richer layout alignment.                                     |
| Flush alignment              | Alignment        | Implemented / required proof                      | `.ui-structured-list-flush`                                                        | Non-selectable flush layout.                                         |
| Non-selectable rows          | Mode             | Implemented                                       | base table                                                                         | Default.                                                             |
| Selectable rows              | Mode/composition | Implemented / required proof with native controls | `.ui-structured-list-selectable` plus visible radio/checkbox                       | Not compatible with flush alignment.                                 |
| Single-select rows           | Composition      | Implemented / required proof                      | Radio button child control                                                         | Native radio owns selection.                                         |
| Multi-select rows            | Composition      | Gated / Pattern-owned                             | Checkbox child control when approved                                               | Requires bulk action and state ownership.                            |
| Row selected                 | State            | Implemented / required proof                      | `.ui-structured-list-row-selected` plus checked control                            | Visual state must match native control state.                        |
| Row current                  | State            | Implemented / required proof                      | `.ui-structured-list-row-current` or `aria-current` on child link where applicable | Current is not the same as selected.                                 |
| Row disabled                 | State            | Implemented / required proof                      | `.ui-structured-list-row-disabled` plus disabled child controls                    | Disabled semantics belong to child controls.                         |
| Empty state                  | State            | Implemented / required proof                      | `.ui-structured-list-empty`                                                        | Do not render an empty table as complete UI.                         |
| Loading/skeleton             | State            | Implemented / required proof                      | `.ui-structured-list-skeleton` or Loading/Inline loading composition               | Use only while data-backed rows are pending.                         |
| Rich row content             | Content option   | Implemented / required proof                      | Text, small metadata, and approved inline Components inside cells                  | Keep content concise and scannable.                                  |
| Row actions                  | Mode             | Not owned by Structured list                      | none                                                                               | Use Data table, Contained list, or Pattern-owned action composition. |
| Sorting/filtering/pagination | Mode             | Not owned by Structured list                      | none                                                                               | Use Data table.                                                      |
| Zebra striping               | Visual modifier  | Gated                                             | none                                                                               | Requires token role, contrast proof, and UI Reference proof.         |
| Custom borders/density       | Modifier         | Not allowed                                       | none                                                                               | Use installed classes only.                                          |

## 6. States

| State              | Status                                                     | Implementation requirement                                                                                                                                              |
| ------------------ | ---------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Default            | Implemented                                                | Renders caption, column headers, row headers, cells, row separators, and token-backed typography/spacing.                                                               |
| Hover              | Implemented only for interactive child controls if present | Static rows do not require hover. Selectable controls or links own hover behavior. Do not add local row-hover styles.                                                   |
| Focus-visible      | Implemented through interactive children                   | Tables and static rows are not focusable. Native radio/checkbox/link/button children must show token-backed focus-visible treatment.                                    |
| Active/pressed     | Not applicable to static rows                              | Native controls inside selectable rows own active/pressed state.                                                                                                        |
| Selected           | Implemented / required proof with visible native controls  | Use checked radio/checkbox state plus `.ui-structured-list-row-selected` visual treatment. Do not use selected state without a real selection control or Pattern owner. |
| Current            | Implemented / required proof                               | Use only when a row represents the current object/context. Current is not bulk selection.                                                                               |
| Disabled           | Implemented / required proof through child controls        | Disabled semantics come from child controls; row class may provide visual support only.                                                                                 |
| Loading/skeleton   | Implemented / required proof                               | Data-backed lists may show skeleton rows or Loading/Inline loading composition with accessible pending text.                                                            |
| Empty              | Implemented / required proof                               | Show visible empty-state copy instead of a visually empty structured list.                                                                                              |
| Overflow/wrapping  | Implemented / required proof                               | Cell content wraps predictably; long headers wrap/truncate only through installed behavior with full text available where needed.                                       |
| Responsive         | Implemented / required proof                               | Structured list adapts to narrow containers without losing row/header relationships.                                                                                    |
| Read-only          | Implemented as default static mode                         | Non-selectable structured lists are static comparison content.                                                                                                          |
| Validation         | Pattern-owned                                              | Use Forms Pattern and field APIs for validation; structured lists may show validation summaries only through parent Pattern composition.                                |
| Expanded/collapsed | Not applicable                                             | Use Accordion, Tree view, or Data table expansion when approved.                                                                                                        |
| Open/closed        | Not applicable                                             | Use Menu, Popover, Tooltip, Toggletip, or Modal for open/closed surfaces.                                                                                               |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Structured list consumes Foundation Color, Spacing, Typography, Themes, Motion, and 2x Grid where composed in layouts.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion where loading/skeleton or state transitions exist.
- 2x Grid where structured lists align inside page sections, cards, side panels, or responsive layouts.

Structured list does not expose an icon API. Icons may appear only through approved child Components or parent Patterns.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                                        |
| ----------- | ---------------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Header text, row text, muted text, row separators, selected row surface, current row treatment, disabled text, skeleton surface, and theme contrast. |
| Spacing     | Cell padding, row height, condensed row height, header gap, alignment offsets, row separator placement, and responsive stack gaps.                   |
| Typography  | Column headers, row headers, body cells, metadata, wrapping, truncation boundary, and code-snippet examples on the UI Reference page.                |
| Themes      | Light/dark token resolution for surfaces, text, borders, selected/current state, disabled state, and loading state.                                  |
| Motion      | Short productive transitions for loading/skeleton or selected/current state when installed; reduced-motion support required.                         |
| 2x Grid     | Parent placement, max width, responsive columns, and alignment with form/detail layouts.                                                             |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$border-subtle` | Row divider | `ui-structured-list-row` divider role | App border palette | Same role / app value | Dividers share global subtle-border mapping. |
| `$text-secondary`, `$text-disabled` | Row text and disabled row text | Structured list text roles | App text palette | Same role / app value | Structured list text does not define local muted colors. |
| `$layer` | With-background header/row surface | Structured list surface role | App layer palette | Same role / app value | Background variant uses layer roles only. |
| `$layer-hover`, `$layer-selected` | Selectable row hover and selected surfaces | Selectable structured-list state roles | App layer state palette | Same role / app value | Selectable rows share Tree view/Data table layer state logic. |
| `$focus` | Selectable row focus | Row focus-visible state | App focus palette | Same role / app value | Focus applies only to interactive/selectable rows. |
| `$skeleton-background`, `$skeleton-element` | Loading placeholders where installed | Loading/Skeleton API composed into list | App skeleton palette | Same role / app value | Structured list composes skeleton roles; it does not invent loading colors. |

### 7.3. CSS namespace

Allowed component classes should use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-structured-list
.ui-structured-list-head
.ui-structured-list-body
.ui-structured-list-row
.ui-structured-list-header
.ui-structured-list-cell
.ui-structured-list-row-header
.ui-structured-list-hang
.ui-structured-list-flush
.ui-structured-list-condensed
.ui-structured-list-selectable
.ui-structured-list-selection-cell
.ui-structured-list-row-selected
.ui-structured-list-row-current
.ui-structured-list-row-disabled
.ui-structured-list-empty
.ui-structured-list-skeleton
```

Feature views must not create `structured-list-*`, Bootstrap table variants, raw utility clusters, arbitrary borders, local density, custom row hover, custom selection colors, local skeleton animation, or component-local responsive behavior for the same UI role.

### 7.4. Helper ownership

| Helper/API                | Status                   | Rule                                                                                             |
| ------------------------- | ------------------------ | ------------------------------------------------------------------------------------------------ |
| `x-ui.structured-list`    | Installed                | Use for structured row/column comparison, density, alignment, selectable, empty, and skeleton states. |
| Native table markup       | Implemented              | Use for baseline structured row/column comparison.                                               |
| Checkbox Component        | Related Component        | Use for visible multi-select controls only when the parent Pattern owns multi-select behavior.   |
| Radio button Component    | Related Component        | Use for visible single-select controls in selectable structured lists.                           |
| Link Component            | Related Component        | Use for navigational inline content inside cells. Link owns focus and visited/external behavior. |
| Loading or Inline loading | Related Component        | Use when a parent Pattern chooses a loading indicator instead of skeleton rows.                  |
| Data table                | Related Component        | Use when sorting, filtering, pagination, row actions, or bulk actions are needed.                |

## 8. Composition rules

- Use Structured list only when row/column comparison is meaningful.
- Use List when content is simple body copy without repeated columns.
- Use Data table when users need sorting, filtering, pagination, bulk actions, row menus, or large datasets.
- Use `x-ui.structured-list` so native table semantics and app-owned class/state contracts stay centralized.
- Include a caption for every structured list, even when visually hidden.
- Include column headers when repeated row fields need comparison.
- Use row headers for the primary subject of each row.
- Keep row content concise enough to scan.
- Keep the number of columns low. Use Data table when the structure becomes too wide or dense.
- Use condensed density only for short rows.
- Use flush alignment only for non-selectable rows.
- Use selectable mode only with visible native controls and approved Checkbox/Radio button styling.
- Keep selected visual state synchronized with native checked state.
- Do not make entire rows clickable outside the installed selectable structured-list behavior.
- Do not place row action menus, inline edit controls, expandable panels, or bulk toolbars inside baseline Structured list.
- Use empty-state copy when no rows exist.
- Use skeleton rows or Loading/Inline loading when data-backed rows are pending.
- Parent Patterns own external spacing, page columns, data loading, selection persistence, form submission, bulk actions, and workflow orchestration.
- Components own internal semantics, density, alignment, row/cell styling, state styling, wrapping, and theme behavior.

## 9. Selection guidance

### 9.1. Use when:

- Users need to compare a small set of rich rows across repeated fields.
- The content is structured enough for columns but does not need full Data table behavior.
- Rows have a clear primary subject and a small number of supporting values.
- Detail pages, setup summaries, permission reviews, configuration summaries, or admin comparisons need a compact structured layout.
- A single row needs to be selected and native radio controls are visible and sufficient.

### 9.2. Do not use when:

- Users need sorting, filtering, pagination, column resizing, bulk actions, row actions, or large datasets; use Data table.
- Content is plain bullets, instructions, or body copy; use List.
- Content is a compact contained row group with inline actions; use Contained list only when its API is accepted and proved.
- Content should behave like clickable cards; use Tile.
- Rows form navigation, menus, tabs, or tree hierarchy; use the correct navigation/shell Component.
- A feature needs local density, borders, zebra striping, row hover, custom selected colors, or arbitrary responsive behavior.

### 9.3. Variant selection:

| Need                                      | Use                                                                |
| ----------------------------------------- | ------------------------------------------------------------------ |
| Small comparison with standard row height | Default structured list                                            |
| Dense comparison with short values        | Condensed structured list                                          |
| Rich row content or selectable rows       | Hang alignment                                                     |
| Tight non-selectable comparison           | Flush alignment                                                    |
| Single row choice                         | Selectable structured list with visible Radio button controls      |
| Multiple row choices                      | Data table selection or gated structured-list multi-select Pattern |
| Empty result                              | `.ui-structured-list-empty` visible message                        |
| Pending rows                              | Skeleton rows or Loading/Inline loading composition                |
| Full data operations                      | Data table                                                         |
| Simple body content                       | List                                                               |

## 10. Accessibility contract

- Use native table semantics for structured row/column comparison.
- Every structured list must include a `<caption>` that names the content. The caption may be visually hidden when the surrounding heading already provides visible context.
- Column headers must use `<th scope="col">`.
- Row headers must use `<th scope="row">`.
- Do not replace table semantics with `div` grids unless a future implementation fully documents equivalent roles, labels, keyboard behavior, and screen-reader behavior.
- Static rows are not focusable.
- Selectable rows must include visible native radio or checkbox controls.
- Radio or checkbox controls must have accessible names tied to the row subject.
- Focus-visible treatment belongs to the interactive child control and must be visible in supported themes.
- Do not use `aria-selected` without a real selection pattern and keyboard behavior.
- Do not use `role="grid"` unless the component implements grid keyboard interaction.
- Do not use row-click selection outside the installed selectable structured-list helper with keyboard parity and a documented focus model.
- Disabled row styling must not be the only disabled signal; child controls must provide native disabled semantics.
- Empty states must be visible text, not only an empty table.
- Loading states must expose pending status through accessible text or a Pattern-owned busy region.
- Meaning must not rely on color alone.
- Long cell content must wrap or be disclosed without clipping essential information.
- Responsive behavior must preserve the relationship between row subjects, headers, and values.

## 11. Content contract

- Use sentence case.
- Keep column headers short and clear, preferably one or two words.
- Use row headers as concrete nouns that identify the row subject.
- Keep row content concise enough to scan.
- Avoid more than three short paragraphs in a row; move long content to a detail page, Accordion, or dedicated section.
- Keep values parallel within a column.
- Do not mix unrelated data types in the same column.
- Use consistent date, status, and count formats within the same structured list.
- Avoid vague headers such as `Info`, `Details`, or `Other` when a more specific label exists.
- Do not use the component for prose-only content that would be clearer as a List or paragraphs.
- When row selection is available, the row subject must make the selection outcome clear.
- Truncated or wrapped header text must preserve meaning; if truncation is installed, the full header must be available through an approved disclosure pattern.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not bypass `x-ui.structured-list` with fake structured-list components, one-off tables, or local row APIs in feature code.
- Do not use direct Carbon production classes such as `cds--*` or `bx--*`.
- Do not use Bootstrap `.table`, `.table-striped`, `.table-hover`, `.list-group`, or feature-local structured-list classes for app-owned Structured list behavior.
- Do not force body content into table structure when alignment is not needed.
- Do not create local density, border, zebra stripe, row-hover, selected-row, or responsive treatments.
- Do not use Structured list when Data table owns the required behavior.
- Do not use Structured list as a navigation menu, listbox, tree, tablist, or sortable grid.
- Do not make rows clickable without visible controls and keyboard parity.
- Do not hide native selection controls.
- Do not pair flush alignment with selectable rows.
- Do not place row action menus or bulk toolbars inside baseline Structured list.
- Do not truncate essential row content without an approved disclosure path.
- Do not render placeholder copy such as `Component-specific API pending correction` or `Allowed variants: None` on the implemented UI Reference page.

## 13. Deferred or gated capabilities

No deferred capability blocks the installed `x-ui.structured-list` API. Future extensions still require an updated Component standard and UI Reference proof before production use.

| Capability                                           | Status                                                         | Gate                                                                                                        |
| ---------------------------------------------------- | -------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------- |
| Dedicated row subcomponent                           | Deferred unless later installed                                | Requires row/header/cell slot contract, responsive behavior, and tests.                                     |
| Custom clickable row selection outside installed selectable rows | Gated                                             | Requires keyboard parity, focus model, visible state, accessible names, and tests.                          |
| Hidden-control selectable rows                       | Not allowed                                                    | Selection controls must remain visible unless a future component installs an equivalent accessible pattern. |
| Multi-select structured list                         | Gated / Pattern-owned                                          | Requires Checkbox composition, selection count, bulk action ownership, persistence, and tests.              |
| Sortable/filterable/paginated structured list        | Not owned by Structured list                                   | Use Data table.                                                                                             |
| Row actions                                          | Pattern-owned / use Data table or Contained list               | Requires action placement, keyboard behavior, responsive behavior, and tests.                               |
| Expandable rows                                      | Deferred / use Accordion or Data table expansion when approved | Requires disclosure semantics, keyboard behavior, and UI Reference proof.                                   |
| Zebra striping                                       | Gated                                                          | Requires Color/Theme proof, contrast review, row state interaction rules, and tests.                        |
| Custom column widths                                 | Gated                                                          | Requires responsive proof and owner contract.                                                               |
| Virtualized long structured list                     | Not owned by Structured list                                   | Use Data table or a future Pattern with performance/accessibility proof.                                    |

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

The Structured list page is a data-display component reference page. It should use grouped examples, density comparison, alignment comparison, state tables, selection-boundary examples, empty/loading proof, responsive proof, and developer implementation examples. It does not need to force every example into the Accordion-style tab model.

### 15.1. Required Live examples internal sections:

| Required proof                      | Rendered behavior                                                                                                           | Variants/options shown                                                                          |
| ----------------------------------- | --------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------- |
| Default structured list             | A native table-based structured list renders caption, column headers, row headers, cells, separators, and standard spacing. | Default density, Hang alignment, Non-selectable                                                 |
| Condensed list                      | A dense comparison renders with shorter row height and short content only.                                                  | Condensed density, Standard state                                                               |
| Alignment comparison                | Hang and flush alignment render side by side with usage notes.                                                              | Hang, Flush, Flush non-selectable boundary                                                      |
| Selectable structured list          | Rows render visible native selection controls and selected visual state.                                                    | Selectable, Radio button, Selected row, Focus-visible                                           |
| Selected/focus/disabled state table | State examples render using production markup and token-backed classes.                                                     | Selected, Current, Focus-visible, Disabled, Hover boundary                                      |
| Empty state                         | No-row state renders visible empty copy instead of an empty table.                                                          | Empty                                                                                           |
| Loading/skeleton state              | Pending data renders skeleton rows or Loading/Inline loading composition with accessible pending text.                      | Loading, Skeleton, `aria-busy` relationship where applicable                                    |
| Rich row content                    | Rows prove row headers, short supporting text, status values, dates, and wrapping behavior.                                 | Rich row, Multi-line content, Header/value alignment                                            |
| Overflow and responsive behavior    | Narrow container examples preserve row/header/value relationships without clipping essential content.                       | Wrapping, Responsive, Narrow width                                                              |
| Data table boundary                 | A comparison example explains when sorting/filtering/pagination moves the feature to Data table.                            | Structured list vs Data table                                                                   |
| Developer implementation            | Canonical native calls and class contracts render as token-backed code snippets.                                            | `<table>`, `<caption>`, `<thead>`, `<tbody>`, `<th>`, `<td>`, `ui-structured-list*` classes     |
| Prohibited usage proof              | The page calls out non-approved local patterns without rendering them as approved examples.                                 | No direct Carbon classes, no Bootstrap table/list groups, no fake Blade API, no local row hover |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered density options, rendered alignment options, rendered state examples, content rules, prohibited usage, deferred gates, related API links, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/structured-list` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The Component contract card includes Anatomy and States first, followed by Behavior, Developer implementation, Content guidance, and Accessibility requirements.
- The default structured list example renders native `<table>`, `<caption>`, `<thead>`, `<tbody>`, `<th>`, and `<td>` elements with app-owned `ui-structured-list*` classes.
- The condensed example renders `.ui-structured-list-condensed`.
- The alignment comparison renders hang and flush examples and states that flush is non-selectable.
- The selectable example uses visible native radio or checkbox controls and does not rely on row-click-only behavior.
- The selected/focus/disabled examples keep state synchronized with child Component semantics.
- The empty example renders visible empty-state copy.
- The loading/skeleton example renders pending rows or Loading/Inline loading composition with accessible pending text.
- The responsive example preserves row/header/value relationships at narrow widths.
- The Data table boundary is visible.
- Developer examples use native table markup and app-owned classes, not placeholder comments or ad hoc grid/list markup.
- No generic placeholder content appears.
- No direct Carbon classes, Bootstrap tables/list groups, raw utility clusters, hard-coded colors, local density, local borders, local row hover, or custom JavaScript are presented as approved implementation.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/structured-list');

$response->assertOk();
$response->assertSee('Structured list');
$response->assertSee('ui-structured-list');
$response->assertSee('ui-structured-list-condensed');
$response->assertSee('ui-structured-list-hang');
$response->assertSee('ui-structured-list-flush');
$response->assertSee('ui-structured-list-selectable');
$response->assertSee('Default structured list');
$response->assertSee('Selectable structured list');
$response->assertSee('Condensed list');
$response->assertSee('Selected/focus/disabled');
$response->assertSee('Empty state');
$response->assertSee('Loading/skeleton');
$response->assertSee('Data table boundary');
$response->assertSee('<table', false);
$response->assertSee('<caption', false);
$response->assertSee('<thead', false);
$response->assertSee('<tbody', false);
$response->assertSee('scope="col"', false);
$response->assertSee('scope="row"', false);
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Allowed variants: None');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('Generic fallback');
$response->assertDontSee('TODO');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('class="table table');
$response->assertDontSee('class="list-group');
$response->assertDontSee('btn btn-primary');
```

For implementation tests, add page-specific assertions that rendered examples include real native table elements rather than only text labels or simulated div-only rows.

## 17. Related APIs

| API                           | Route                                                                     |
| ----------------------------- | ------------------------------------------------------------------------- |
| Components overview           | `/platform/ui-reference/components`                                       |
| List                          | `/platform/ui-reference/components/list`                                  |
| Contained list                | `/platform/ui-reference/components/contained-list`                        |
| Data table                    | `/platform/ui-reference/components/data-table`                            |
| Tile                          | `/platform/ui-reference/components/tile`                                  |
| Checkbox                      | `/platform/ui-reference/components/checkbox`                              |
| Radio button                  | `/platform/ui-reference/components/radio-button`                          |
| Link                          | `/platform/ui-reference/components/link`                                  |
| Loading                       | `/platform/ui-reference/components/loading`                               |
| Inline loading                | `/platform/ui-reference/components/inline-loading`                        |
| Forms pattern                 | `/platform/ui-reference/patterns/forms`                                   |
| Tables Pattern                | `/platform/ui-reference/patterns/tables`                                  |
| Layout Pattern                | `/platform/ui-reference/patterns/layout`                                  |
| Overlay and feedback patterns | `/platform/ui-reference/patterns/overlays-feedback`                       |
| Color element                 | `/platform/ui-reference/elements/color`                                   |
| Spacing element               | `/platform/ui-reference/elements/spacing`                                 |
| Typography element            | `/platform/ui-reference/elements/typography`                              |
| Motion element                | `/platform/ui-reference/elements/motion`                                  |
| Themes element                | `/platform/ui-reference/elements/themes`                                  |
| 2x Grid element               | `/platform/ui-reference/elements/2x-grid`                                 |
| Canonical structured list doc | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fstructured-list.md` |
| Carbon structured list usage  | `https://carbondesignsystem.com/components/structured-list/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Structured list usage, style, code, and accessibility guidance inform row/column anatomy, default and condensed density, hang and flush alignment, selectable boundaries, row content guidance, and accessibility concerns. Login App keeps its own native markup contract, app-owned `ui-*` class namespace, Foundation Element token model, route ownership, and UI Reference proof requirements.
