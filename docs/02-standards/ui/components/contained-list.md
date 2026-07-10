---
title: Contained list
slug: contained-list
status: implemented-standard
api_layer: Component API
category: Data display
priority: Tier B - Common reusable component
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/contained-list.md
source_owner: not installed
blade_api:
  - x-ui.contained-list
  - x-ui.contained-list-item
javascript_api: []
data_attributes: []
source_files:
  - resources/views/components/ui/contained-list/index.blade.php
  - resources/views/components/ui/contained-list-item/index.blade.php
  - resources/css/app.css
carbon_reference:
  - https://carbondesignsystem.com/components/contained-list/usage/
  - https://carbondesignsystem.com/components/contained-list/style/
  - https://carbondesignsystem.com/components/contained-list/accessibility/
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
  - motion
related_components:
  - structured-list
  - list
  - data-table
  - tile
  - accordion
  - button
  - icon-button
  - link
related_patterns:
  - data-content
  - overlays-feedback
---

# Contained list Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. `x-ui.contained-list` props and options](#43-x-uicontained-list-props-and-options)
  - [4.4. `x-ui.contained-list-item` props and options](#44-x-uicontained-list-item-props-and-options)
  - [4.5. Item data contract](#45-item-data-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
  - [9.3. Selection matrix:](#93-selection-matrix)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Rendered evidence requirements](#14-ui-reference-requirements)
  - [14.1. Required Live examples:](#141-required-live-examples)
  - [14.2. Required rendered evidence assertions](#142-required-ui-reference-assertions)
    - [14.2.1. The page must show:](#1421-the-page-must-show)
    - [14.2.2. The page must not show:](#1422-the-page-must-not-show)
- [15. Testing and acceptance criteria](#15-testing-and-acceptance-criteria)
  - [15.1. Suggested feature test assertions:](#151-suggested-feature-test-assertions)
- [16. Related APIs](#16-related-apis)
- [17. References](#17-references)

## 1. API summary

Contained list organizes related repeated rows inside a bounded surface such as a page region, sidebar, drawer, disclosure region, compact panel, or contextual review area.

Canonical API owner: `not installed`. Use this Component API instead of creating local repeated-row markup, local card-list styling, or local row-action behavior for the same UI role.

Contained list is the installed Login App 2.0 bounded row-list API. It owns the list container, heading/header region, repeated row structure, row dividers, row density, row metadata, optional row icons, optional row-level actions, empty/loading/error states, and token-backed contained-surface behavior. It does not own table comparison, bulk selection, sorting, pagination, complex filtering, hierarchical trees, accordion disclosure, page-level navigation, or feature-specific business behavior.

### 1.1. Canonical API responsibilities:

- Render bounded repeated row groups through `x-ui.contained-list` and `x-ui.contained-list-item`.
- Support simple read-only rows, linked rows, row actions, status rows, metadata, icons, and empty states.
- Support on-page and disclosed contained-list variants.
- Provide consistent row spacing, dividers, title/header treatment, and bounded-surface styling.
- Preserve native link/button behavior for interactive rows and row actions.
- Consume Foundation Element APIs for color, spacing, typography, themes, icons, and motion where applicable.
- Prove variants, row content, row actions, states, accessibility behavior, and alternatives on the rendered evidence page.

### 1.2. Non-owned responsibilities:

- Full data comparison, multi-column headers, sorting, pagination, bulk selection, and table tooling. Use Data table.
- Multi-column label/value comparison where table behavior is too heavy but row comparison is required. Use Structured list.
- Content-only documentation lists. Use List.
- Object cards with rich previews, large media, or independent card actions. Use Tile/Card composition.
- Optional disclosure of repeated content. Use Accordion.
- Tree or nested hierarchy. Use Tree view or a Pattern-owned navigation/data structure.
- Search/filter query behavior and virtualized/large-row performance. Contained list may compose with Search/Filter Pattern entry points, but query state and filtering behavior remain Pattern-owned.

## 2. Status and ownership

| Field                        | Value                                                                                                                                            |
| ---------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
| Status                       | Implemented standard                                                                                                                             |
| API layer                    | Component API                                                                                                                                    |
| Component slug               | `contained-list`                                                                                                                                 |
| Category                     | Data display                                                                                                                                     |
| Priority                     | Tier B - Common reusable component                                                                                                               |
| Rendered evidence route           | `not installed`                                                                                               |
| Canonical doc                | `docs/02-standards/ui/components/contained-list.md`                                                                                              |
| Source owner                 | `not installed`                                                                                               |
| Blade API                    | `x-ui.contained-list`; `x-ui.contained-list-item`                                                                                                |
| JavaScript API               | None required for installed contained-list behavior                                                                                              |
| Data attributes              | None required for installed behavior                                                                                                             |
| Source files                 | `resources/views/components/ui/contained-list/index.blade.php`; `resources/views/components/ui/contained-list-item/index.blade.php`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Icons, Motion where interactive or transitional states appear                                                |
| Carbon benchmark             | Carbon Contained list usage, style, and accessibility guidance                                                                                   |

`Implemented standard` means this component is approved as the expected production standard for bounded repeated row groups. The rendered evidence page must render production examples and implementation guidance, not a deferred catalog entry.

## 3. Installed standard

Use Contained list when related repeated rows need to sit inside a bounded surface and remain lighter than a table.

### 3.1. The installed standard is:

- Render the container through `<x-ui.contained-list>`.
- Render explicit row children through `<x-ui.contained-list-item>` or pass an approved `items` array to the list component.
- Use a visible title or accessible label for every contained list.
- Use semantic list structure for non-interactive row groups.
- Use native links for navigational rows.
- Use native buttons or approved Button/Icon button APIs for row actions.
- Keep row content structurally consistent inside the same contained list.
- Use on-page contained lists for persistent page regions, cards, sidebars, or panels.
- Use disclosed contained lists for compact row sets inside drawer, disclosure, popover-like, or elevated surfaces.
- Use sticky headers only inside a constrained scrolling parent that owns the scroll region.
- Compose search/filter through a header action entry point or a nearby Search/Filter Pattern control; Contained list does not own query behavior.
- Use row icons only when they improve scanability or communicate real row status.
- Use row actions only when actions belong to each row and do not require table-level bulk behavior.
- Use approved empty, loading, warning, error, disabled, selected/current, and read-only states when relevant.
- Use app-owned `ui-*` classes and approved Component APIs only.
- Do not use local utility clusters, local icons, arbitrary spacing, or fake table/list hybrids for contained-list behavior.

Carbon alignment note: Carbon describes contained lists as a way to organize related content in smaller UI spaces such as cards, sidebars, and disclosure situations, with a header column of information, multiple item rows, inline actions, and interactive elements. Login App maps that guidance to its own `x-ui.contained-list`, `x-ui.contained-list-item`, `ui-*` class namespace, internal icon standard, Element tokens, and rendered evidence proof.

## 4. Public API

### 4.1. Canonical calls

Use explicit item children when row content needs custom Blade composition.

```blade
<x-ui.contained-list title="Recent activity" variant="on-page">
    <x-ui.contained-list-item
        title="Profile updated"
        description="Kyle Swindell changed account settings."
        meta="Today at 9:42 AM"
        icon="user"
    />

    <x-ui.contained-list-item
        title="Password reset"
        description="A password reset email was sent."
        meta="Yesterday"
        status="info"
        icon="locked"
    />
</x-ui.contained-list>
```

Use the `items` data contract when row data is assembled in PHP.

```blade
<x-ui.contained-list
    title="Recent files"
    variant="on-page"
    size="md"
    :items="$recentFiles"
/>
```

Use linked rows only when the entire row is one navigation target.

```blade
<x-ui.contained-list title="Related records" variant="disclosed">
    <x-ui.contained-list-item
        title="Acme Tenant"
        description="Active workspace"
        href="{{ route('tenants.show', $tenant) }}"
        icon="apps"
    />
</x-ui.contained-list>
```

Use row actions when each row has a small, row-owned command.

```blade
<x-ui.contained-list title="Invitations" variant="on-page">
    <x-ui.contained-list-item
        title="laura@example.com"
        description="Invited as Admin"
        meta="Pending"
        status="warning"
    >
        <x-slot:actions>
            <x-ui.button semantic="ghost" size="sm" type="submit" form="resend-invite-42">
                Resend
            </x-ui.button>

            <x-ui.icon-button
                icon="close"
                label="Cancel invitation for laura@example.com"
                semantic="ghost"
                size="sm"
            />
        </x-slot:actions>
    </x-ui.contained-list-item>
</x-ui.contained-list>
```

Use the empty state when a bounded list has no rows.

```blade
<x-ui.contained-list
    title="Recent activity"
    empty-title="No activity yet"
    empty-description="Activity will appear here after users make changes."
/>
```

### 4.2. API surfaces

| API surface           | Installed value                                                                                                                                  |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
| Container Blade API   | `x-ui.contained-list`                                                                                                                            |
| Row Blade API         | `x-ui.contained-list-item`                                                                                                                       |
| JavaScript            | No dedicated JavaScript controller required for installed behavior                                                                               |
| Root semantic element | Section/region plus list semantics, depending on title and context                                                                               |
| Data attributes       | None required for installed behavior. Feature views must not invent contained-list behavior attributes.                                          |
| CSS namespace         | App-owned `ui-*` contained-list classes documented by the component implementation                                                               |
| Source files          | `resources/views/components/ui/contained-list/index.blade.php`; `resources/views/components/ui/contained-list-item/index.blade.php`; `resources/css/app.css` |

### 4.3. `x-ui.contained-list` props and options

| Prop/option                              | Type     | Default   | Allowed values         | Required                              | Notes                                                         |
| ---------------------------------------- | -------- | --------- | ---------------------- | ------------------------------------- | ------------------------------------------------------------- |
| `title`                                  | `string / null` | `null`                 | Short list title                      | Required unless `ariaLabel` or `labelledBy` is provided       | Prefer a visible title.                                                         |
| `ariaLabel`                              | `string / null` | `null`                 | Short accessible label                | Required when no visible title exists                         | Use only when a visible title is not appropriate.                               |
| `labelledBy`                             | `string / null` | `null`                 | ID of external heading                | Optional                                                      | Use when a parent heading labels the list.                                      |
| `items`                                  | `array / null`  | `null`                 | Item data contract entries            | Optional                                                      | Use for data-driven row rendering.                                              |
| `variant`                                | `string` | `on-page` | `on-page`, `disclosed` | Optional                              | Defines surface treatment.                                    |
| `size`                                   | `string` | `md`      | `sm`, `md`, `lg`, `xl` | Optional                              | Controls row density. Do not mix row sizes inside one list.   |
| `description`                            | `string / null` | `null`                 | Short helper text                     | Optional                                                      | Use when the list purpose needs additional context.                             |
| `titleIcon` / `title-icon`               | `string / null` | `null`                 | Internal icon component name      | Optional                                                      | Decorative list-title icon. Must not replace title text.                        |
| `headerActionLabel` / `header-action-label` | `string / null` | `null`              | Short accessible label                | Optional                                                      | Renders one compact header icon action for list-local search/filter entry points or similar actions. |
| `headerActionIcon` / `header-action-icon` | `string / null` | `search` | Internal icon component name | Optional                                                      | Icon for the header action.                                                      |
| `headerActionHref` / `header-action-href` | `string / null` | `null`              | URL / route                           | Optional                                                      | When provided, the header action is a link; otherwise it is a button.            |
| `insetDividers` / `inset-dividers`       | `bool`   | `false`  | `true`, `false`        | Optional                              | Insets row dividers to avoid rule-line collisions near adjacent components.      |
| `stickyHeader` / `sticky-header`         | `bool`   | `false`  | `true`, `false`        | Optional / constrained                | Use only when the parent context owns scrolling and keyboard/screen-reader behavior remains clear. |
| `emptyTitle` / `empty-title`             | `string / null` | `null`                 | Short empty-state title               | Optional                                                      | Required when the list can be empty in normal use.                              |
| `emptyDescription` / `empty-description` | `string / null` | `null`                 | Short empty-state body                | Optional                                                      | Explain how rows appear or what the user can do next.                           |
| `loading`                                | `bool`   | `false`   | `true`, `false`        | Optional                              | Shows pending row state through approved loading composition. |
| `status`                                 | `string / null` | `null`                 | `info`, `success`, `warning`, `error` | Optional                                                      | Use only for list-level status, not decoration.                                 |
| `class`                                  | `string / null` | `null`                 | Layout passthrough if supported       | Optional                                                      | Parent Patterns may pass layout classes. Do not use for local visual overrides. |

### 4.4. `x-ui.contained-list-item` props and options

| Prop/option    | Type       | Default | Allowed values                        | Required                                | Notes                                                      |
| -------------- | ---------- | ------- | ------------------------------------- | --------------------------------------- | ---------------------------------------------------------- |
| `title`        | `string`   | none    | Short row label                       | Yes                                     | Main row text.                                             |
| `description`  | `string / null` | `null`                                | Short secondary row text                | Optional                                                   | Keep structurally consistent across the list.                                                               |
| `meta`         | `string / null` | `null`                                | Date, count, label, or compact metadata | Optional                                                   | Use consistently; do not overload with long copy.                                                           |
| `href`         | `string / null` | `null`                                | Approved route/URL                      | Optional                                                   | Makes the row a single navigational target. Do not combine whole-row link with conflicting nested controls. |
| `icon`         | `string / null` | `null`                                | Internal icon alias/component       | Optional                                                   | Decorative by default unless status semantics require text support.                                         |
| `status`       | `string / null` | `null`                                | `info`, `success`, `warning`, `error`   | Optional                                                   | Use for real semantic state only.                                                                           |
| `actionItems` / item `actions` | `array` | `[]`                                  | Approved row action entries             | Optional                                                   | Data-driven row actions render Button or Icon button APIs. Rows with actions are not whole-row links.       |
| `current`      | `bool`     | `false` | `true`, `false`                       | Optional                                | Marks the current row within this list context.            |
| `selected`     | `bool`     | `false` | `true`, `false`                       | Optional                                | Use only when the contained list owns row selection.       |
| `disabled`     | `bool`     | `false` | `true`, `false`                       | Optional                                | Use when the row or row action may become available later. |
| `actions` slot | Blade slot | empty   | Approved Button/Icon button/Menu APIs | Optional                                | Use for row-owned commands.                                |
| Default slot   | Blade slot | empty   | Additional row body content           | Optional                                | Keep row body compact and structurally consistent.         |

### 4.5. Item data contract

When `items` is passed to `x-ui.contained-list`, each item must use this shape.

| Field         | Type     | Required | Notes                                            |
| ------------- | -------- | -------- | ------------------------------------------------ |
| `title`       | `string` | Yes      | Main row label.                                  |
| `description` | `string / null` | No                                               | Secondary text.                                                                                                              |
| `meta`        | `string / null` | No                                               | Compact metadata.                                                                                                            |
| `href`        | `string / null` | No                                               | Whole-row navigation.                                                                                                        |
| `icon`        | `string / null` | No                                               | Approved icon alias.                                                                                                         |
| `status`      | `string / null` | No                                               | `info`, `success`, `warning`, or `error`.                                                                                    |
| `current`     | `bool`   | No       | Current row marker.                              |
| `selected`    | `bool`   | No       | Selection marker when supported by the workflow. |
| `disabled`    | `bool`   | No       | Unavailable row marker.                          |
| `actions`     | `array / null`  | No                                               | Row action data only when the component implementation supports action rendering. Prefer explicit slots for complex actions. |

Any option not listed here is not public. If a feature needs another contained-list option, update the component implementation, this standard, and rendered evidence proof before production use.

## 5. Allowed variants, options, and modifiers

| Name                     | Type              | Status      | API                                              | Notes                                                                   |
| ------------------------ | ----------------- | ----------- | ------------------------------------------------ | ----------------------------------------------------------------------- |
| On-page contained list   | Variant           | Implemented | `variant="on-page"`                              | Persistent page region, card, sidebar, or panel list.                   |
| Disclosed contained list | Variant           | Implemented | `variant="disclosed"`                            | Compact list inside drawer, disclosure, or elevated contextual surface. |
| Small rows               | Size              | Implemented | `size="sm"`                                      | Dense sidebars, compact panels, and short metadata rows.                |
| Medium rows              | Size              | Implemented | `size="md"`                                      | Default row density.                                                    |
| Large rows               | Size              | Implemented | `size="lg"`                                      | Rows with more readable secondary detail.                               |
| Extra large rows         | Size              | Implemented | `size="xl"`                                      | On-page rows that need 64px row height for richer but still concise content. |
| Read-only rows           | Mode              | Implemented | No `href` or actions                             | Static row list.                                                        |
| Linked rows              | Mode              | Implemented | `href`                                           | Whole row is one navigational target.                                   |
| Inline row actions       | Composition       | Implemented | `actions` slot                                   | Use Button/Icon button/Menu APIs.                                       |
| Data-driven row actions  | Composition       | Implemented | item `actions` / `actionItems`                   | Renders approved Button/Icon button controls from row data.             |
| Row icons                | Composition       | Implemented | `icon`                                           | Decorative or status-supported icons only.                              |
| List title decorators    | Composition       | Implemented | `titleIcon`, `headerActionLabel`                 | Header title icon plus one compact header action.                       |
| Row metadata             | Composition       | Implemented | `meta`                                           | Dates, counts, short labels, or compact secondary details.              |
| Inset row dividers       | Modifier          | Implemented | `insetDividers`                                  | Use where extended dividers would collide visually with nearby rules.   |
| Empty state              | State/composition | Implemented | `emptyTitle`, `emptyDescription`                 | Do not render blank bounded surfaces.                                   |
| List-level status        | State             | Implemented | `status`                                         | Use only for actual list state.                                         |
| Row-level status         | State             | Implemented | item `status`                                    | Use only for actual row state.                                          |
| Current row              | State             | Implemented | `current`                                        | Marks current row in this bounded context.                              |
| Selected row             | State             | Gated       | `selected`                                       | Use only when selection model is documented for the feature.            |
| Sticky header            | Implemented / constrained | `stickyHeader` / `sticky-header` | Use only when a parent scroll region owns scrolling and focus behavior remains clear. |
| Search/filter composition | Pattern-owned composition | `headerActionLabel`; nearby Search/Filter Pattern controls | Contained list may show the entry point or sit below a persistent search/filter control, but query behavior is Pattern-owned. |
| Bulk selection           | Not allowed       | none        | Use Data table.                                  |
| Sorting/pagination       | Not allowed       | none        | Use Data table.                                  |
| Deep hierarchy           | Not allowed       | none        | Use Tree view or Pattern-owned structure.        |
| Multi-column comparison  | Not allowed       | none        | Use Structured list or Data table.               |

## 6. States

| State              | Status                                   | Implementation requirement                                                                       |
| ------------------ | ---------------------------------------- | ------------------------------------------------------------------------------------------------ |
| Default            | Implemented                              | Renders title/header and repeated rows with token-backed surface, text, spacing, and dividers.   |
| Read-only          | Implemented                              | Rows expose text/metadata without interactive controls.                                          |
| Hover              | Implemented for interactive rows/actions | Token-backed hover treatment only for linked rows or row controls.                               |
| Focus-visible      | Implemented for interactive rows/actions | Native link/button focus remains visible in all themes.                                          |
| Active/pressed     | Implemented for interactive rows/actions | Uses native link/button activation and token-backed active treatment.                            |
| Disabled           | Implemented                              | Disabled row/action appears unavailable and does not activate.                                   |
| Loading            | Implemented                              | Uses approved loading/skeleton/placeholder composition without fake rows.                        |
| Empty              | Implemented                              | Shows approved empty title/body instead of blank container.                                      |
| Error              | Implemented                              | Uses semantic status and recovery copy only for real list-level or row-level errors.             |
| Warning            | Implemented                              | Uses semantic status and explanatory copy only for real warnings.                                |
| Success            | Implemented                              | Uses semantic status only for meaningful completed row/list state.                               |
| Info               | Implemented                              | Uses semantic status only for meaningful informational row/list state.                           |
| Current            | Implemented                              | Marks current row in a bounded set without implying table selection.                             |
| Selected           | Gated                                    | Requires documented selection model; use Data table for bulk or multi-row workflows.             |
| Validation         | Not applicable by default                | Validation belongs to form controls or Forms Pattern, unless a row action opens/owns validation. |
| Expanded/collapsed | Not applicable                           | Use Accordion for row disclosure.                                                                |
| Sorted/paginated   | Not applicable                           | Use Data table.                                                                                  |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Contained list consumes Foundation Color, Spacing, Typography, Themes, Icons, and Motion where interactive or transitional states appear.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Icons.
- Motion, only when interactive row state or loading/transition behavior requires it.

### 7.2. Allowed token roles

| Foundation Element | Allowed usage                                                                                                                     |
| ------------------ | --------------------------------------------------------------------------------------------------------------------------------- |
| Color              | Surface, text, divider, hover, focus, active, disabled, selected/current, status, and icon roles.                                 |
| Spacing            | Header padding, row padding, icon gap, metadata gap, action gap, divider placement, empty-state spacing.                          |
| Typography         | List title, row title, description, metadata, status copy, empty-state copy.                                                      |
| Themes             | Light/dark/layered surface behavior for on-page and disclosed contexts.                                                           |
| Icons              | Approved row icons, status icons, and row action icons.                                                                           |
| Motion             | Productive hover/focus/active transitions and loading/empty transitions where installed; must respect reduced-motion preferences. |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-contained-list
.ui-contained-list-on-page
.ui-contained-list-disclosed
.ui-contained-list-header
.ui-contained-list-header-actions
.ui-contained-list-header-sticky
.ui-contained-list-title
.ui-contained-list-title-icon
.ui-contained-list-description
.ui-contained-list-body
.ui-contained-list-inset-dividers
.ui-contained-list-item
.ui-contained-list-item-link
.ui-contained-list-item-content
.ui-contained-list-item-icon
.ui-contained-list-item-title
.ui-contained-list-item-description
.ui-contained-list-item-meta
.ui-contained-list-item-actions
.ui-contained-list-empty
.ui-contained-list-loading
.ui-contained-list-sm
.ui-contained-list-md
.ui-contained-list-lg
.ui-contained-list-current
.ui-contained-list-selected
.ui-contained-list-disabled
.ui-contained-list-status-info
.ui-contained-list-status-success
.ui-contained-list-status-warning
.ui-contained-list-status-error
```

Feature views must not create local `contained-list-*`, `card-list-*`, `panel-list-*`, raw utility clusters, arbitrary hex colors, arbitrary spacing, local SVG icons, custom focus rings, or component-local JavaScript for the same UI role.

## 8. Composition rules

- A contained list must have a visible title, `ariaLabel`, or `labelledBy`.
- Use semantic list structure for non-interactive rows.
- Use native links for linked rows.
- Use native buttons or approved Button/Icon button APIs for row actions.
- Do not put nested interactive controls inside a whole-row link.
- If a row has multiple actions, do not make the whole row clickable.
- Keep row structure consistent inside the same list.
- Use dividers and row spacing owned by this component; do not add local row borders.
- Parent Patterns own external spacing, placement, workflow orchestration, surrounding surface, and page-level layout.
- A contained list must not replace Data table behavior when users need sorting, column headers, pagination, selection, bulk actions, or complex comparison.
- A contained list must not replace Structured list when the primary need is comparison across multiple fields.
- A contained list must not replace List when the content is simple text-only documentation.
- A contained list must not replace Tile/Card composition when each item needs independent card structure, rich media, or multiple independent actions.
- A contained list must not become a navigation menu unless a Navigation Pattern owns that behavior.
- Sticky headers and scrollable row bodies require a constrained parent scroll region and rendered evidence proof before use.
- Search/filter behavior remains Pattern-owned; Contained list may expose a header action entry point or sit below a Search/Filter control.
- Empty and loading states must preserve the list title/context.

## 9. Selection guidance

### 9.1. Use when:

- A bounded card, sidebar, drawer, disclosure region, compact panel, or contextual review area needs repeated rows.
- Rows share a consistent content structure.
- The list is lighter than a Data table and does not require sorting, pagination, bulk selection, or complex comparison.
- Each row may include a simple link, simple metadata, a simple status, or one to two row-owned actions.
- A compact activity list, recent files list, invitation list, notification summary, related-record list, or contextual object list is needed.

### 9.2. Do not use when:

- Rows need multiple column headers, sorting, pagination, bulk actions, or complex comparison; use Data table.
- Rows need structured multi-field comparison without table tooling; use Structured list.
- Content is a plain documentation list; use List.
- Each item is a full object summary with richer layout or media; use Tile/Card composition.
- Content is optional disclosure; use Accordion.
- Rows are hierarchical or deeply nested; use Tree view or a Pattern-owned hierarchy.
- The list is really primary navigation; use Navigation Pattern APIs.
- The workflow requires local search/filter behavior, virtualization, or large-row performance before those capabilities are approved.
- The component would contain long paragraphs or mixed row structures that are hard to scan.

### 9.3. Selection matrix:

| Need                                              | Use                                           |
| ------------------------------------------------- | --------------------------------------------- |
| Compact bounded row list                          | Contained list                                |
| Plain text bullets or ordered list                | List                                          |
| Comparable rows with multiple fields              | Structured list                               |
| Table behavior, bulk actions, sorting, pagination | Data table                                    |
| Rich object summaries                             | Tile/Card composition                         |
| Optional disclosure rows                          | Accordion                                     |
| Primary navigation                                | Navigation Pattern                            |
| Nested hierarchy                                  | Tree view or Pattern-owned hierarchy          |
| Short row list inside drawer/card/sidebar         | Contained list, usually `variant="disclosed"` |
| Persistent page/card row list                     | Contained list, usually `variant="on-page"`   |

## 10. Accessibility contract

- Use semantic list structure for non-interactive row groups.
- Associate the list title with the list using a visible heading, `aria-label`, or `aria-labelledby`.
- Use native anchors for linked rows.
- Use native buttons or approved Button/Icon button APIs for row actions.
- Keep every interactive row, button, link, toggle, or icon button keyboard reachable.
- `Tab` moves through interactive row controls in visual order.
- `Enter` activates links and buttons according to native behavior.
- `Space` activates buttons according to native behavior.
- Whole-row links must not contain nested buttons or links.
- If row actions exist, each action must have an accessible name that includes the row target when needed.
- Icon-only row actions require accessible labels and tooltip behavior when the Icon button API requires it.
- Decorative icons must be hidden from assistive technology.
- Semantic status icons must be paired with text or an accessible status label.
- Do not rely on color alone for status, selected/current, disabled, or row meaning.
- Maintain contrast in supported light and dark themes.
- Preserve visible focus for rows and inline actions.
- Empty and loading states must preserve the list label/context.
- Scrollable contained-list regions are gated and must not trap keyboard or screen reader users.

## 11. Content contract

- Use a short list title, preferably one to three words.
- Use sentence case for list titles and row text.
- Use row titles that identify the row object or event.
- Keep row descriptions short and structurally consistent.
- Use metadata for dates, counts, status labels, or compact secondary facts.
- Use row action labels that name the action and, where needed, the row target.
- Avoid vague row actions such as `Go`, `More`, or `Open` when a specific action label is available.
- Use status text only for actual row state, not decoration.
- Do not place multiple paragraphs inside one row.
- Do not mix unrelated content types in one contained list.
- Empty-state copy should explain why the list is empty or what creates rows.
- Loading copy should make the pending region understandable.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not create feature-local `contained-list-*`, `panel-list-*`, `card-list-*`, or row-list class systems.
- Do not copy Carbon contained-list production classes into feature views.
- Do not fake a contained-list component by styling cards, rows, tables, or lists with local utility clusters.
- Do not use contained list when List, Structured list, Data table, Tile/Card composition, Accordion, Tree view, or a Pattern-owned layout is the clearer owner.
- Do not put sorting, pagination, bulk selection, or multi-column table behavior in Contained list.
- Do not nest buttons or links inside whole-row links.
- Do not use icons as the only status indicator.
- Do not render blank containers when the list is empty.
- Do not put long-form content or mixed row structures in a contained list.
- Do not add search/filter behavior, virtualization, row reordering, or custom scroll containers without the owning Pattern or standard proof.
- Do not use contained list as primary navigation.

## 13. Deferred or gated capabilities

| Capability                        | Status                 | Gate                                                                                         |
| --------------------------------- | ---------------------- | -------------------------------------------------------------------------------------------- |
| Sticky header with scrolling rows | Implemented / constrained | Requires parent-owned scroll region plus focus, keyboard, screen-reader, height, and responsive proof. |
| Search/filter behavior            | Pattern-owned          | Search query state, filtering, empty states, and persistence belong to Search/Filter Pattern ownership. |
| Bulk row selection                | Not allowed            | Use Data table.                                                                              |
| Sorting and pagination            | Not allowed            | Use Data table.                                                                              |
| Virtualized rows                  | Deferred               | Requires performance, focus, screen-reader, and loading-state proof.                         |
| Drag-and-drop row reordering      | Deferred               | Requires keyboard equivalent, reorder announcements, motion rules, and persistence behavior. |
| Nested contained lists            | Gated                  | Requires Pattern proof that hierarchy is not better served by Tree view or Accordion.        |
| Expandable row disclosure         | Not allowed by default | Use Accordion unless a new contained-list disclosure variant is approved.                    |
| Complex inline forms inside rows  | Not allowed by default | Use Forms Pattern or Drawer/Modal handoff.                                                   |
| Custom status palettes            | Not allowed            | Requires Color/Icon/Status standard update.                                                  |

Future extensions require an updated Component standard and rendered evidence proof before production use.

## 14. Rendered evidence requirements

The rendered evidence page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

The Contained list page must render production examples through the documented API. It must not read as a deferred catalog page.

### 14.1. Required Live examples:

| Required proof            | Rendered behavior                                                                                                                                              | Variants/options shown                         |
| ------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------- |
| On-page contained list    | A persistent bounded list renders with title, rows, metadata, dividers, and token-backed surface treatment.                                                    | On-page, Medium rows, Read-only rows, Metadata |
| Disclosed contained list  | A compact list renders inside a drawer/disclosure/elevated context without redefining overlay styles.                                                          | Disclosed, Small rows, Compact content         |
| Linked rows               | Whole-row links render with native link behavior and visible focus.                                                                                            | Linked row, Hover, Focus-visible, Active       |
| Row actions               | Rows render approved Button/Icon button actions without nested interactive conflicts.                                                                          | Row actions, Icon button, Disabled action      |
| Row icons                 | Rows render non-interactive icons and status icons through approved icon APIs with supporting text.                                                            | With icons, Status icons                       |
| Interactive items and actions | Rows with actions render controls as the interaction target instead of nesting controls inside a whole-row link.                                           | With interactive items and actions             |
| List title decorators     | Header title decorators and one compact header action render through approved icon/button APIs.                                                               | With list title decorators                     |
| Inset row dividers        | Inset row dividers are available when adjacent components would otherwise create converging rule lines.                                                        | Inset dividers                                 |
| Status rows               | Row-level and list-level semantic states render with text plus icon/state treatment.                                                                           | Info, Success, Warning, Error                  |
| Empty and loading states  | Empty and loading examples preserve title/context and avoid fake blank rows.                                                                                   | Empty, Loading                                 |
| Size scale                | Approved row sizes render with consistent density.                                                                                                             | Small, Medium, Large, Extra large              |
| Accessibility example     | The page demonstrates labeling, keyboard order, focus visibility, icon labeling, and non-color status cues.                                                    | Labelled list, Keyboard order, Icon labels     |
| Selection and current row | The page documents current row behavior and gates selection unless a feature has an approved model.                                                            | Current, Selected gated                        |
| Alternatives matrix       | The page distinguishes Contained list from List, Structured list, Data table, Tile/Card composition, Accordion, Tree view, and Navigation.                     | Selection guidance                             |
| Search/filter composition | Header action and persistent Search/Filter Pattern composition render without making Contained list own query behavior. | Header action, persistent search field         |
| Scrolling and sticky header | A constrained parent scroll region proves sticky header behavior without trapping focus or redefining page scroll. | Sticky header, scrollable rows                 |
| Deferred gates            | Search/filter behavior, virtualization, drag reorder, nested lists, and expandable rows render as gated disposition rows, not fake production controls. | Gated capabilities                             |

The page must include canonical Blade examples for `x-ui.contained-list`, `x-ui.contained-list-item`, item data, linked rows, row actions, empty states, and status rows. It must link to this canonical standard and to consumed Element and Component standards.

### 14.2. Required rendered evidence assertions

#### 14.2.1. The page must show:

- `Implemented standard`
- `x-ui.contained-list`
- `x-ui.contained-list-item`
- `On-page contained list`
- `Disclosed contained list`
- `Linked rows`
- `Row actions`
- `Empty state`
- `Loading state`
- `Status rows`
- `Use Data table when sorting, pagination, bulk actions, or complex comparison are required`
- `Use Structured list when rows need comparable multi-field structure`
- `Use List for content-only documentation lists`

#### 14.2.2. The page must not show:

- `No production public API is approved`
- `Do not call x-ui.contained-list`
- `Component-specific API pending correction`
- Fake local contained-list markup presented as approved
- Unsupported gated variants rendered as production UI

## 15. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The page presents `x-ui.contained-list` and `x-ui.contained-list-item` as the production API.
- The page includes on-page, disclosed, linked row, row action, status row, empty, loading, and size examples.
- The page distinguishes Contained list from List, Structured list, Data table, Tile/Card composition, Accordion, Tree view, and Navigation.
- The page links to this canonical doc using `docs/02-standards/ui/components/contained-list.md`; do not link to a deprecated `tier-1` path.
- The page contains no generic placeholder content.
- Tests assert stale deferred-only language and legacy scaffold labels remain absent when they are not part of approved UI copy.
- Tests assert no raw Bootstrap list group, hard-coded color, arbitrary local spacing, feature-local contained-list class system, local JavaScript row controller, or direct Carbon production class is presented as approved.

### 15.1. Suggested feature test assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Contained list');
$response->assertSee('Implemented standard');
$response->assertSee('x-ui.contained-list');
$response->assertSee('x-ui.contained-list-item');
$response->assertSee('On-page contained list');
$response->assertSee('Disclosed contained list');
$response->assertSee('Linked rows');
$response->assertSee('Row actions');
$response->assertSee('Empty state');
$response->assertSee('Loading state');
$response->assertSee('Status rows');
$response->assertSee('Structured list');
$response->assertSee('Data table');
$response->assertSee('List');
$response->assertSee('Tile/Card composition');
$response->assertSee('Accordion');
$response->assertDontSee('No production public API is approved');
$response->assertDontSee('Do not call x-ui.contained-list');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('list-group');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
```

## 16. Related APIs

| API                            | Route                                                                    |
| ------------------------------ | ------------------------------------------------------------------------ |
| Components overview            | `not installed`                                      |
| List                           | `not installed`                                 |
| Structured list                | `not installed`                      |
| Data table                     | `not installed`                           |
| Tile                           | `not installed`                                 |
| Accordion                      | `not installed`                            |
| Button                         | `not installed`                               |
| Icon button                    | `not installed`                               |
| Link                           | `not installed`                                 |
| Loading                        | `not installed`                              |
| Search                         | `not installed`                               |
| Data/content patterns          | `not installed`                           |
| Overlays and feedback patterns | `not installed`                      |
| Color element                  | `not installed`                                  |
| Spacing element                | `not installed`                                |
| Typography element             | `not installed`                             |
| Themes element                 | `not installed`                                 |
| Icons element                  | `not installed`                                  |
| Motion element                 | `not installed`                                 |
| Canonical contained list doc   | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fcontained-list.md` |
| Carbon contained list usage    | `https://carbondesignsystem.com/components/contained-list/usage/`        |

## 17. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Contained list usage, style, and accessibility guidance informs bounded-surface list usage, on-page/disclosed list expectations, row content, inline actions, interactive elements, status/accessibility considerations, and size/state coverage. Login App keeps its own Blade API, internal icon standard, app-owned `ui-*` class contract, Element token model, and rendered evidence proof.
