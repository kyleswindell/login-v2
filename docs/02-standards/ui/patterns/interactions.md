---
title: Interaction
slug: interactions
api_layer: Pattern API
status: implemented-standard
system_maturity: partial-family-standard
category: data-and-content-interactions
priority: baseline-pattern-composition
ui_reference_route: /platform/ui-reference/patterns/data-content
canonical_doc: docs/02-standards/ui/patterns/interactions.md
source_owner: /platform/ui-reference/patterns/data-content
pattern_api:
  - x-ui.patterns.search-filter-bar
  - toolbar-action-group
  - batch-action-row
  - filter-summary-row
  - local-control-cluster
consumed_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
  - motion
  - 2x-grid
consumed_components:
  - search
  - text-input
  - select
  - dropdown
  - checkbox
  - button
  - menu-buttons
  - pagination
  - data-table
  - tag
  - notification
  - loading
  - inline-loading
related_patterns:
  - data-and-content
  - tables
  - forms
  - table-toolbar
  - overlays-feedback
  - boundary-and-validation
carbon_reference:
  - https://carbondesignsystem.com/patterns/overview/
  - https://carbondesignsystem.com/patterns/search-pattern/
  - https://carbondesignsystem.com/patterns/filtering/
  - https://carbondesignsystem.com/components/data-table/usage/
---

# Interaction Pattern API Standard
- [Interaction Pattern API Standard](#interaction-pattern-api-standard)
  - [1. API summary](#1-api-summary)
  - [2. Status and ownership](#2-status-and-ownership)
  - [3. Installed standard](#3-installed-standard)
  - [4. Pattern API](#4-pattern-api)
    - [4.1. API surfaces](#41-api-surfaces)
    - [4.2. `x-ui.patterns.search-filter-bar`](#42-x-uipatternssearch-filter-bar)
    - [4.3. Search and filter bar composition](#43-search-and-filter-bar-composition)
    - [4.4. Toolbar action group composition](#44-toolbar-action-group-composition)
    - [4.5. Batch action row composition](#45-batch-action-row-composition)
    - [4.6. Filter summary row composition](#46-filter-summary-row-composition)
    - [4.7. Local control cluster composition](#47-local-control-cluster-composition)
    - [4.8. No-results recovery composition](#48-no-results-recovery-composition)
  - [5. Required composition](#5-required-composition)
  - [6. Optional composition](#6-optional-composition)
  - [7. Consumed Element APIs](#7-consumed-element-apis)
    - [7.1. Color](#71-color)
    - [7.2. Spacing and 2x Grid](#72-spacing-and-2x-grid)
    - [7.3. Typography](#73-typography)
    - [7.4. Icons](#74-icons)
    - [7.5. Motion](#75-motion)
    - [7.6. Themes](#76-themes)
  - [8. Owned Component APIs](#8-owned-component-apis)
  - [9. Allowed variants and layout options](#9-allowed-variants-and-layout-options)
  - [10. State ownership](#10-state-ownership)
  - [11. Responsive behavior](#11-responsive-behavior)
  - [12. Composition rules](#12-composition-rules)
  - [13. Selection guidance](#13-selection-guidance)
  - [14. Accessibility contract](#14-accessibility-contract)
  - [15. Content contract](#15-content-contract)
  - [16. Prohibited usage](#16-prohibited-usage)
  - [17. Deferred or gated capabilities](#17-deferred-or-gated-capabilities)
  - [Implementation and UI Reference Checklist](#implementation-and-ui-reference-checklist)
    - [Implementation checklist](#implementation-checklist)
    - [UI Reference proof checklist](#ui-reference-proof-checklist)
  - [19. UI Reference requirements](#19-ui-reference-requirements)
  - [20. Testing and acceptance criteria](#20-testing-and-acceptance-criteria)
  - [21. Related APIs](#21-related-apis)
  - [22. References](#22-references)

## 1. API summary

Interaction patterns define reusable control groups such as search, filter, batch action, toolbar, and local navigation behavior.

Canonical API owner: `/platform/ui-reference/patterns/data-content`. Use this Pattern API when multiple controls cooperate to change a page region, dataset, list, table, or local content view. Do not rebuild local search bars, filter clusters, batch-action rows, toolbar action groups, or filter summary rows for the same UI role.

Interaction is a Pattern API. It composes approved Foundation Element APIs and Component APIs into reusable control arrangements. It does not redefine text input, search, select, dropdown, checkbox, button, menu button, pagination, data table, loading, notification, tag, icon, color, spacing, typography, theme, motion, or grid primitives. Feature modules still own query rules, filter schemas, permissions, selected record IDs, data loading, persistence, result computation, and route-specific behavior.

Canonical API responsibilities:

- Compose coordinated controls that affect a shared page region or dataset.
- Define control ordering for search, filter, toolbar, batch action, pagination, summary, and local navigation regions.
- Define search and pagination handoff between controls and the affected result region.
- Define where active filters are summarized and how they are removed.
- Define when batch actions appear and how selected-count state is displayed.
- Define pending, no-results, and no-results recovery placement around affected results.
- Define responsive wrapping, collapse, and overflow rules for coordinated controls.
- Preserve logical keyboard order, labels, focus-visible behavior, and result-change announcements.
- Consume Foundation Element APIs for color, spacing, typography, themes, icons, motion, and 2x Grid.
- Prove search/filter bars, toolbar action groups, batch action rows, filter summaries, no-results recovery, and local control clusters on the UI Reference route.

Non-owned responsibilities:

- Feature-specific filter schemas, query parameters, sorting rules, saved-view data models, permissions, persistence, and URL synchronization.
- Child Component internals, props, validation states, icon rendering, local keyboard behavior, or internal spacing.
- Data table internals such as row rendering, column sorting, row expansion, and selection mechanics beyond Pattern-level action visibility.
- Arbitrary business labels or product policy copy.
- Local JavaScript controllers, raw AJAX behavior, polling, debounce timing, or loading state computation unless the owning feature or Component documents it.
- Broad table, form, or page-header composition outside the scoped interaction region.

Carbon alignment note: Carbon describes Patterns as reusable best-practice solutions for user goals. Carbon Search guidance treats search as discovery that often starts broad and narrows through filters. Carbon Filtering guidance distinguishes batch filters from instant filters and warns that multiple filter categories should remain visible instead of hidden in menus. Carbon Data table guidance places search, filtering, display settings, utilities, pagination, and batch actions around table data. Login App maps those principles to app-owned Pattern APIs, installed Components, Foundation Element tokens, and UI Reference proof rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                                                |
| ---------------------------- | -------------------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented standard                                                                                                 |
| System maturity              | Partial family standard                                                                                              |
| API layer                    | Pattern API                                                                                                          |
| Pattern slug                 | interactions                                                                                                         |
| Category                     | Data and content interactions                                                                                        |
| Owner route                  | `/platform/ui-reference/patterns/data-content`                                                                       |
| Canonical path               | `docs/02-standards/ui/patterns/interactions.md`                                                                      |
| UI Reference proof           | `/platform/ui-reference/patterns/data-content`                                                                       |
| Source owner                 | `/platform/ui-reference/patterns/data-content`                                                                       |
| Blade API                    | `x-ui.patterns.search-filter-bar` where installed; other entries are composition APIs unless wrappers are documented |
| JavaScript API               | None approved by this Pattern standard                                                                               |
| Data attributes              | None approved by this Pattern standard                                                                               |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Icons, Motion, 2x Grid                                                           |
| Carbon benchmark             | Carbon Patterns overview, Search pattern, Filtering pattern, and Data table guidance                                 |

`Implemented standard` means this Pattern contract is active for Login App 2.0 UI surfaces that coordinate search, filters, toolbar actions, batch actions, local controls, result feedback, and pagination.

`Partial family standard` means the Pattern family exists and can be used, but individual wrappers or advanced capabilities must remain classified as implemented, target standard, Pattern-owned, feature-owned, deferred, or gated as documented below.

## 3. Installed standard

Use interaction patterns when multiple controls cooperate to change a page region or dataset.

The installed standard is:

- Use `x-ui.patterns.search-filter-bar` when the installed wrapper exists for the route or UI Reference example.
- Use toolbar action group composition for global actions tied to a result set or region.
- Use batch action row composition only when selected items exist and the selection-owning Component or Pattern provides selected state.
- Use filter summary row composition when active filters, query text, or saved filter context should remain visible after controls move, wrap, or collapse.
- Use local control cluster composition for small, region-scoped controls that do not justify a full toolbar.
- Use Search/Text input, Select/Dropdown, Checkbox, Button, Menu buttons, Pagination, Data table, Tag, Loading, Inline loading, and Notification Components as applicable.
- Use Foundation Element APIs for visual primitives and responsive layout.
- Keep search/filter state readable even when controls wrap or collapse.
- Keep active filters visible outside menus through summary text or removable Tag components.
- Keep batch action rows visually and semantically tied to the selected result set.
- Place pagination after the affected dataset unless a route-specific Pattern documents top-and-bottom pagination.
- Place no-results feedback in the affected results region, not inside the toolbar alone.
- Parent feature modules own query execution, saved views, permissions, async behavior, route state, and persistence.
- Do not use local raw utility clusters, direct Carbon classes, Bootstrap toolbars/forms, custom JavaScript, or one-off control rows for interaction patterns.

Installed interaction compositions:

| Composition                   | Status                                      | Use                                                                                       |
| ----------------------------- | ------------------------------------------- | ----------------------------------------------------------------------------------------- |
| Search and filter bar         | Implemented / target wrapper                | Search, filters, apply/clear actions, and optional count summary for a dataset or region. |
| Toolbar action group          | Implemented standard                        | Region-level actions such as create, export, settings, or table display controls.         |
| Batch action row              | Implemented standard / data-state dependent | Actions that appear only after one or more items are selected.                            |
| Filter summary row            | Implemented standard                        | Active query/filter chips, result count, clear-all action, and applied-state visibility.  |
| Local control cluster         | Implemented standard                        | Small region-scoped sort/view/filter/action group that controls one local area.           |
| No-results recovery           | Implemented standard                        | Recovery guidance when search/filter criteria produce no results.                         |
| Saved filters                 | Gated / feature-owned data model            | Requires route-specific saved-view persistence and ownership.                             |
| Complex query builder         | Gated                                       | Requires feature-backed data model, parser, accessibility review, and UI Reference proof. |
| Drag/reorder toolbar behavior | Not owned by Interaction                    | Requires a dedicated Pattern and feature persistence model.                               |

## 4. Pattern API

### 4.1. API surfaces

| API surface                 | Installed value                                                           | Rule                                                                                                                                              |
| --------------------------- | ------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------- |
| Search/filter Blade wrapper | `x-ui.patterns.search-filter-bar` where installed                         | Use for canonical search/filter bar composition. If unavailable in a feature, compose only through the Pattern owner until wrapper is formalized. |
| Toolbar action group        | Composition API                                                           | Use installed Button, Icon button, Menu buttons, Link, and Tag APIs. Do not create a local toolbar Component.                                     |
| Batch action row            | Composition API                                                           | Show only when selection exists. Selection source remains Data table, Checkbox, or feature state.                                                 |
| Filter summary row          | Composition API                                                           | Show query/filter state with text, count, removable Tags, and clear action.                                                                       |
| Local control cluster       | Composition API                                                           | Use for narrow region controls that affect only one local content area.                                                                           |
| JavaScript API              | None approved                                                             | Feature modules may execute data changes, but this Pattern does not install a shared controller.                                                  |
| Data attributes             | None approved                                                             | Add only through a future documented behavior gate.                                                                                               |
| CSS namespace               | Pattern-owned `ui-pattern-interactions*` or documented owner classes only | Do not create feature-local toolbar/filter classes.                                                                                               |

### 4.2. `x-ui.patterns.search-filter-bar`

Use the installed wrapper when a result region needs a coordinated query field, filter controls, and clear/apply behavior.

```blade
<x-ui.patterns.search-filter-bar
    method="GET"
    action="{{ route('platform.users.index') }}"
    search-name="q"
    search-label="Search users"
    search-placeholder="Search by name or email"
    :filters="$filters"
    :active-filters="$activeFilters"
    result-count-label="{{ $users->total() }} users"
/>
```

If the wrapper is not available in a route, compose the same structure through the Data/content or Table toolbar Pattern owner. Do not create a local `search-filter-bar.blade.php` partial.

### 4.3. Search and filter bar composition

```blade
<form class="ui-pattern-interactions ui-pattern-interactions--search-filter" method="GET" action="{{ route('platform.users.index') }}">
    <div class="ui-pattern-interactions__controls">
        <x-ui.search
            name="q"
            label="Search users"
            placeholder="Search by name or email"
            value="{{ request('q') }}"
        />

        <x-ui.select
            name="status"
            label="Status"
            :options="$statusOptions"
            :selected="request('status')"
        />

        <x-ui.button type="submit" semantic="primary">
            Apply filters
        </x-ui.button>

        <x-ui.button type="button" semantic="ghost">
            Clear filters
        </x-ui.button>
    </div>
</form>
```

Use this structure when filters apply together on submit. Use instant filter updates only when a feature route owns async behavior, result announcements, and pending state.

### 4.4. Toolbar action group composition

```blade
<div class="ui-pattern-interactions ui-pattern-interactions--toolbar" aria-label="User table actions">
    <div class="ui-pattern-interactions__summary">
        <span class="ui-pattern-interactions__count">24 users</span>
    </div>

    <div class="ui-pattern-interactions__actions">
        <x-ui.button semantic="ghost" icon="heroicon-o-arrow-down-tray">
            Export
        </x-ui.button>

        <x-ui.button semantic="primary">
            Add user
        </x-ui.button>
    </div>
</div>
```

Toolbar actions must be region-level actions. Do not place unrelated page, account, or global shell actions into a dataset toolbar.

### 4.5. Batch action row composition

```blade
<div class="ui-pattern-interactions ui-pattern-interactions--batch" role="region" aria-label="Selected user actions">
    <p class="ui-pattern-interactions__selection-count">
        3 users selected
    </p>

    <div class="ui-pattern-interactions__actions">
        <x-ui.button semantic="ghost">
            Clear selection
        </x-ui.button>

        <x-ui.button semantic="danger-tertiary">
            Deactivate selected
        </x-ui.button>
    </div>
</div>
```

Batch action rows appear only when selection exists. Data table, Checkbox, or feature state owns the selected IDs and selection truth. Interaction Pattern owns placement, selected-count visibility, action order, and recovery boundaries.

### 4.6. Filter summary row composition

```blade
<div class="ui-pattern-interactions ui-pattern-interactions--filter-summary" aria-label="Active filters">
    <p class="ui-pattern-interactions__result-count">
        12 results for active users
    </p>

    <div class="ui-pattern-interactions__active-filters">
        <x-ui.badge status="neutral" size="sm" removable remove-label="Remove status filter">
            Status: active
        </x-ui.badge>

        <x-ui.badge status="neutral" size="sm" removable remove-label="Remove role filter">
            Role: administrator
        </x-ui.badge>
    </div>

    <x-ui.button semantic="ghost" type="button">
        Clear all filters
    </x-ui.button>
</div>
```

Filter summary must not be replaced by filter chips alone when active criteria would become ambiguous. Include a result count, query context, or summary text where practical.

### 4.7. Local control cluster composition

```blade
<div class="ui-pattern-interactions ui-pattern-interactions--local-controls" aria-label="Activity controls">
    <x-ui.select
        name="activity_sort"
        label="Sort activity"
        :options="$sortOptions"
        selected="newest"
    />

    <x-ui.button semantic="ghost" type="button">
        Refresh activity
    </x-ui.button>
</div>
```

Use a local control cluster only when controls affect one clearly bounded region. Use the broader search/filter bar or table toolbar when controls affect a larger dataset.

### 4.8. No-results recovery composition

```blade
<section class="ui-pattern-interactions__no-results" aria-live="polite">
    <h2>No users match these filters</h2>
    <p>Try removing a filter or changing the search term.</p>

    <x-ui.button semantic="secondary" type="button">
        Clear filters
    </x-ui.button>
</section>
```

No-results recovery belongs in the affected results region. It may be paired with the active filter summary above the dataset.

## 5. Required composition

Use these Component APIs as applicable. Do not replace them with local markup for the same UI role.

| Component API            | Required usage                                                                            |
| ------------------------ | ----------------------------------------------------------------------------------------- |
| Search                   | Use for query fields that search a dataset or page region.                                |
| Text input               | Use when the field is not a search query but is still text input.                         |
| Select / Dropdown        | Use for compact single-choice filtering, sorting, or display settings.                    |
| Checkbox                 | Use for independent filter options or row/bulk selection where applicable.                |
| Button                   | Use for apply, clear, create, export, refresh, and batch actions.                         |
| Menu buttons             | Use when toolbar actions collapse into a menu or when a disclosure menu is required.      |
| Pagination               | Use for paginated results and place it near the affected dataset.                         |
| Data table               | Use for tabular data, row selection, column actions, and table-specific composition.      |
| Tag / Badge              | Use for active filter chips, compact status, and filter summaries.                        |
| Notification             | Use for blocking or non-blocking feedback around failed search/filter actions.            |
| Loading / Inline loading | Use for pending search/filter/table updates where the final content or action is waiting. |
| Link                     | Use for reference/navigation handoffs, not commands.                                      |

Use these Element APIs in every interaction composition:

| Element API | Required usage                                                                                        |
| ----------- | ----------------------------------------------------------------------------------------------------- |
| Color       | Surfaces, borders, text, status, focus, active filters, selected counts, and no-results state.        |
| Spacing     | Control grouping, toolbar rhythm, filter row gaps, summary row gaps, and responsive stacking.         |
| Typography  | Labels, counts, summaries, no-results headings, helper text, and action labels.                       |
| Themes      | Light, dark, layered, and inverse compatibility for controls and dataset-adjacent surfaces.           |
| Icons       | Search, filter, menu, clear, export, settings, and status icons only through approved Component APIs. |
| Motion      | Collapse, menu, loading, and result-update transitions only through approved motion roles.            |
| 2x Grid     | Toolbar/content alignment, narrow-width stacking, and page-region relationships where layout matters. |

## 6. Optional composition

| Optional composition    | Status                                               | Rule                                                                                               |
| ----------------------- | ---------------------------------------------------- | -------------------------------------------------------------------------------------------------- |
| Saved filters           | Gated / feature-owned                                | Requires saved-view data model, naming, persistence, sharing rules, and route ownership.           |
| Bulk selection state    | Implemented when source Component provides selection | Pattern may place selected-count/action row; feature/Data table owns selected IDs.                 |
| Async loading indicator | Allowed with owner                                   | Use Loading or Inline loading. Feature owns async state and result refresh.                        |
| No-results feedback     | Implemented standard                                 | Explain why results are missing and provide one recovery path where practical.                     |
| Clear all filters       | Allowed                                              | Use Button; feature owns cleared query state and URL/data refresh.                                 |
| Export action           | Allowed                                              | Use Button/Menu buttons; feature owns permissions and export generation.                           |
| Column/display settings | Allowed / table-owned                                | Use Menu buttons or Data table Pattern; feature owns saved preferences if persisted.               |
| Result count summary    | Implemented standard                                 | Show current count near controls or summary row when the count helps orientation.                  |
| Filter category groups  | Allowed                                              | Use visible grouped controls for multiple categories; avoid hiding complex categories in one menu. |
| Collapsed overflow menu | Allowed with restraint                               | Use Menu buttons only when controls remain discoverable and active filters stay summarized.        |
| Retry action            | Allowed                                              | Use Button/Notification/Loading handoff when data refresh fails.                                   |
| Query builder           | Gated                                                | Requires feature-backed query model, parser, keyboard/accessibility proof, and tests.              |

## 7. Consumed Element APIs

### 7.1. Color

Use token-backed surface, text, border, status, selected-count, active-filter, focus, hover, pending, and no-results roles.

Rules:

- Use child Component color semantics for fields, buttons, tags, notifications, and loading.
- Use Pattern-owned surfaces only where the toolbar, summary, or batch row needs a visible region.
- Do not create feature-local filter colors or selected-count colors.
- Do not use color alone to show active filters, selected rows, pending state, or no-results status.

### 7.2. Spacing and 2x Grid

Use spacing and grid APIs for control relationships.

Rules:

- Pattern owns gaps between controls, toolbar sections, summary rows, and result regions.
- Child Components own their internal padding and element spacing.
- Controls align to the approved grid where they share a row with the dataset or page header.
- Long control clusters wrap into predictable rows at narrow widths.
- Batch rows and summary rows stay adjacent to the affected dataset.
- Do not use local `row`, `col`, arbitrary gap, or one-off margin utilities as Pattern API.

### 7.3. Typography

Use approved text roles for:

- Search and filter labels.
- Toolbar region labels.
- Selected-count text.
- Result-count summaries.
- Active filter summaries.
- No-results headings and recovery copy.
- Action labels.
- Helper text for complex filters.

Do not create local font sizes, weights, or muted text treatments for interaction regions.

### 7.4. Icons

Use icons only through installed child Components.

Rules:

- Search icons belong to Search.
- Filter, menu, export, refresh, settings, and clear icons belong to Button, Icon button, Menu buttons, or Tag remove controls.
- Decorative icons must be hidden from assistive technology by the child Component.
- Do not introduce local SVGs or icon-only controls without accessible names.

### 7.5. Motion

Use motion only for meaningful state changes:

- Control cluster collapse or menu disclosure.
- Loading to loaded result transitions.
- Batch action row entry/exit.
- No-results state transition after search/filter update.

Motion must use Foundation Motion roles and respect reduced-motion preferences. Feature-local keyframes or arbitrary durations are not approved.

### 7.6. Themes

Interaction patterns must remain readable and operable across supported themes.

Rules:

- Control, toolbar, summary, batch, and no-results surfaces must use theme-aware tokens.
- Active filter Tags and status feedback must preserve contrast in light and dark themes.
- Nested control areas must preserve layer contrast.
- Do not hard-code light-only toolbar or filter surfaces.

## 8. Owned Component APIs

This Pattern API does not own child Component internals. It owns orchestration and placement around approved Component APIs.

| Owned pattern responsibility | Description                                                                                         |
| ---------------------------- | --------------------------------------------------------------------------------------------------- |
| Control ordering             | Determines relative order of search, filters, summary, actions, pagination, and results.            |
| Filter summary placement     | Determines where active filters, query text, result count, and clear-all action appear.             |
| Batch-action visibility      | Determines when and where selected-count and batch actions appear.                                  |
| Search handoff               | Determines which region is affected by query changes and where pending/no-results feedback appears. |
| Pagination handoff           | Determines relationship between pagination controls and current query/filter state.                 |
| Toolbar action hierarchy     | Determines which actions are primary, secondary, menu-contained, or prohibited in a toolbar.        |
| Responsive wrapping          | Determines how control clusters wrap, collapse, or move into menus without hiding active state.     |
| Result feedback placement    | Determines where no-results, loading, retry, and count changes appear relative to controls.         |

Child Components still own local props, states, validation, focus-visible treatment, disabled behavior, internal spacing, semantics, and accessibility behavior defined by their Component standards.

## 9. Allowed variants and layout options

| Variant or layout option  | Status                                 | Use when                                                                                              |
| ------------------------- | -------------------------------------- | ----------------------------------------------------------------------------------------------------- |
| Search and filter bar     | Implemented standard                   | A dataset or region needs query plus filter controls.                                                 |
| Toolbar actions           | Implemented standard                   | A dataset or local region needs create/export/settings/utility actions.                               |
| Batch action row          | Implemented standard / state-dependent | One or more records are selected and shared actions apply to them.                                    |
| Filter summary            | Implemented standard                   | Query/filter state must remain visible after controls wrap, collapse, or apply.                       |
| Local control cluster     | Implemented standard                   | A small group of controls affects one bounded region.                                                 |
| No-results recovery       | Implemented standard                   | Search/filter criteria produce no records or content.                                                 |
| Instant filter update     | Allowed / feature-owned                | Single-category or lightweight filters can update immediately with accessible result announcements.   |
| Batch filter update       | Allowed / feature-owned                | Multiple categories or slow result refresh should wait for Apply filters.                             |
| Collapsed overflow menu   | Allowed with proof                     | Toolbar actions may collapse into Menu buttons if active state and primary actions stay discoverable. |
| Top-and-bottom pagination | Gated                                  | Requires long dataset proof and duplicate-control accessibility expectations.                         |
| Saved filters/views       | Gated / feature-owned                  | Requires data model, naming, persistence, sharing, and UI Reference proof.                            |
| Complex query builder     | Gated                                  | Requires feature-backed query model and accessibility proof.                                          |
| Drag/reorder controls     | Not owned by this Pattern              | Requires a separate reorder/list Pattern and feature persistence ownership.                           |
| Spreadsheet-like controls | Not allowed                            | Use a dedicated table/grid standard before production.                                                |

## 10. State ownership

Interaction patterns own cross-component states around controls and affected regions. Components own local states.

| State                | Pattern ownership                                                     | Component ownership                                | Feature ownership                                            |
| -------------------- | --------------------------------------------------------------------- | -------------------------------------------------- | ------------------------------------------------------------ |
| Default              | Places controls, summary, actions, results, and pagination.           | Renders each child control.                        | Provides initial data and defaults.                          |
| Query active         | Shows query text in search field and/or summary.                      | Search/Text input renders value.                   | Determines query parameter and result set.                   |
| Active filters       | Shows filter controls, summary Tags, result count, and clear action.  | Select/Checkbox/Tag/Button render local states.    | Determines filter schema, active values, and URL/data state. |
| Bulk selection       | Shows selected count and batch action row.                            | Data table/Checkbox owns selected control state.   | Owns selected IDs and permitted actions.                     |
| Pending              | Places Loading or Inline loading near controls/result region.         | Loading/Inline loading render pending UI.          | Owns async request state, debounce, and refresh behavior.    |
| No results           | Places no-results recovery in result region.                          | Button/Link/Notification render recovery controls. | Determines zero-count state and recovery route.              |
| Error                | Places failed-search/filter feedback and retry path.                  | Notification/Button render feedback/actions.       | Determines failure state and retry endpoint.                 |
| Disabled/unavailable | Places unavailable explanation or disables irrelevant control groups. | Child controls own disabled state.                 | Determines permissions and availability.                     |
| Overflow/collapsed   | Determines what wraps or moves to a menu.                             | Menu buttons render disclosure behavior.           | May determine available actions by role/context.             |
| Pagination active    | Places pagination with current query/filter context.                  | Pagination renders local controls.                 | Owns current page, per-page value, and result totals.        |
| Saved view active    | Gated / feature-owned                                                 | Select/Menu/Tag may render labels.                 | Owns saved view model, persistence, and selected view.       |

## 11. Responsive behavior

Interaction patterns define how composed controls stack, collapse, scroll, or remain fixed across supported breakpoints.

Installed responsive rules:

- Search and primary filters appear before secondary toolbar actions in reading and keyboard order.
- Controls may wrap into additional rows when width is constrained.
- Search fields may span the full available row at narrow widths.
- Filter controls may stack vertically when labels or values would become cramped.
- Toolbar actions may collapse into Menu buttons only when labels remain discoverable and the primary action remains available.
- Active filter summaries must remain visible even when the underlying filter controls collapse.
- Batch action rows must stay adjacent to the affected dataset and must not move above unrelated page content.
- Pagination remains near the affected result set and must not detach from active search/filter context.
- No-results recovery replaces or occupies the result region, not the control cluster.
- Horizontal scrolling is allowed only for the child Data table when that Component owns overflow. Control clusters must wrap or collapse instead.
- Sticky control regions are gated unless scroll, focus, and content-obscuring behavior are documented.

## 12. Composition rules

- Use interaction patterns for coordinated controls that affect one clearly identified region or dataset.
- Name the affected region through visible heading, accessible label, or surrounding page context.
- Keep search and filters close to the results they affect.
- Keep result counts close to search/filter context when counts help orientation.
- Keep active filters visible after controls apply, collapse, or move.
- Use batch action rows only when selected items exist.
- Keep batch destructive actions visually and textually explicit.
- Use one primary action per interaction region unless a parent Page header already owns the page primary action.
- Use Button semantics for apply, clear, refresh, export, create, and batch actions.
- Use Menu buttons for overflow actions and disclosure, not local dropdown markup.
- Use Tag removable behavior for active filter chips only when the Tag Component and parent feature can remove that filter accessibly.
- Use Notification or no-results recovery for failed or empty result states.
- Use Loading or Inline loading for pending result refresh or action execution.
- Keep control state synchronized with result state through feature-owned data; Pattern examples show placement only.
- Child Components own internal semantics, styling, local states, labels, and focus behavior.
- Parent Patterns own grouping, external spacing, orchestration, and responsive composition.
- Feature modules own business rules, permissions, data loading, persistence, query syntax, selected IDs, saved filters, and workflow-specific branching.

## 13. Selection guidance

Use Interaction patterns when:

- Multiple controls cooperate to change the same page region, list, table, or dataset.
- A search field and filters need shared layout, summary, result count, or no-results recovery.
- A toolbar needs actions tied to a specific content region or table.
- A table/list selection needs a selected-count row and batch actions.
- Active filters need visible summary and clear/remove behavior.
- Local controls need predictable order, wrapping, and accessibility relationships.

Do not use Interaction patterns when:

- One standalone control solves the UI problem; use the Component standard for that control.
- The control changes global shell navigation, page hierarchy, or account state; use Navigation/UI shell Patterns.
- The control is a form submission workflow; use Forms Pattern.
- The primary concern is displaying read-only content with no coordinated controls; use Data and Content Pattern.
- The behavior is route-specific query logic, permissions, saved-view persistence, or API request orchestration; keep it in the feature module.
- The desired behavior is a speculative query builder, saved view manager, or spreadsheet-like data editor with no approved use case.

Pattern selection:

| Need                                           | Use                                   |
| ---------------------------------------------- | ------------------------------------- |
| Search plus filters controlling one dataset    | Search and filter bar.                |
| Region-level actions for table/list/card set   | Toolbar action group.                 |
| Actions on selected rows/items                 | Batch action row.                     |
| Visible active filters and result count        | Filter summary row.                   |
| Small bounded controls for one panel/card/list | Local control cluster.                |
| Zero results after query/filter                | No-results recovery.                  |
| Long read-only record display                  | Data and Content Pattern.             |
| Editable workflow                              | Forms Pattern.                        |
| Tabular record operations                      | Data table + Table toolbar Pattern.   |
| Saved query/view library                       | Gated saved filters/views capability. |

## 14. Accessibility contract

- Controls must appear in logical keyboard order that matches the visual and workflow order.
- Every control must have a visible label or an accessible name supplied by its Component API.
- The affected result region must be identifiable through a visible heading, accessible label, or clear surrounding context.
- Search/filter result count changes should be announced where practical when results update asynchronously.
- Pending result updates must not silently remove focus or reset the user to the top of the page.
- Active filters must not be hidden without a visible summary.
- Removable filter tags must have accessible remove labels that identify the removed filter.
- Batch action rows must announce or display the selected count.
- Batch actions must remain keyboard reachable after selection changes.
- Clear selection and clear filters actions must be reachable without forcing pointer interaction.
- Destructive batch actions must use visible destructive labels and the Button danger contract.
- Collapsed overflow menus must be keyboard accessible through Menu buttons.
- No-results recovery must be announced or placed in the result region so screen-reader users understand the result change.
- Pagination must remain associated with the active query/filter context and must not reset focus unpredictably.
- Do not use color alone for active filters, selected state, result changes, pending state, or no-results state.
- Responsive wrapping must preserve reading order and group relationships.

## 15. Content contract

- Use clear, concrete filter labels.
- Use search labels that name the dataset, such as `Search users`, `Search audit events`, or `Search workspaces`.
- Use placeholder text only as supportive example text; never as the only search label.
- Use count labels that reflect the current result set, such as `24 users`, `12 results`, or `3 selected`.
- Use active filter labels that include the category when the value alone is ambiguous, such as `Status: active`.
- Use action labels that name the outcome: `Apply filters`, `Clear filters`, `Export users`, `Deactivate selected`.
- Avoid generic action labels such as `Apply`, `Submit`, `Go`, `Run`, or `Do it` when a specific action is available.
- Use no-results headings that name the affected content, such as `No users match these filters`.
- Use no-results recovery copy that suggests one useful next step.
- Keep toolbar labels short enough to remain scannable at narrow widths.
- Do not duplicate route-specific policy text inside the Pattern standard.
- Use Button, Link, Tag, Search, Select, and Notification content contracts for child Component copy.

## 16. Prohibited usage

- Do not bypass installed Component APIs with local input, select, checkbox, button, menu, tag, table, loading, notification, or pagination markup.
- Do not hard-code Foundation Element decisions such as colors, spacing, typography, icons, motion, grid columns, focus rings, or theme overrides.
- Do not create feature-local `search-filter-bar`, `toolbar`, `batch-actions`, `filter-summary`, or `control-cluster` wrappers for reusable Pattern roles.
- Do not make filter chips the only record of active filters when the active criteria would become ambiguous.
- Do not hide active filters inside a menu without a visible summary.
- Do not tie unrelated controls into one toolbar just for visual density.
- Do not place global app actions, page-primary actions, and dataset actions in the same toolbar without clear Pattern ownership.
- Do not show batch actions when no items are selected.
- Do not allow batch destructive actions without visible destructive copy.
- Do not use a dropdown/menu to hide multiple complex filter categories that should remain visible.
- Do not use custom JavaScript for filtering, batching, selection, debounce, saved views, or result announcements as Pattern API without a documented behavior gate.
- Do not use Bootstrap toolbars/forms, direct Carbon production classes, local raw utility clusters, or local icon sources.
- Do not present saved views, complex query builders, or advanced async behavior as installed examples before the feature-owned data model exists.
- Do not move route-specific query rules, permissions, selected IDs, or persistence rules into the Pattern standard.

## 17. Deferred or gated capabilities

| Capability                         | Status                                    | Gate                                                                                                                                             |
| ---------------------------------- | ----------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
| Saved filters/views                | Gated / feature-owned                     | Requires saved-view data model, naming rules, persistence ownership, sharing/visibility rules, route integration, UI Reference proof, and tests. |
| Complex query builder              | Gated                                     | Requires feature-backed query model, parser/serializer, validation, keyboard behavior, clear/reset model, and tests.                             |
| Async instant filtering controller | Deferred                                  | Requires documented data attributes, lifecycle, loading state, result announcements, cancellation/debounce behavior, error handling, and tests.  |
| Persistent toolbar preferences     | Gated / feature-owned                     | Requires preference model, permission rules, reset behavior, and route ownership.                                                                |
| Advanced column/display settings   | Pattern-owned by Data table/Table toolbar | Requires Data table proof, menu behavior, and feature preference ownership.                                                                      |
| Sticky search/filter toolbar       | Gated                                     | Requires scroll behavior, focus order, content-obscuring prevention, mobile proof, and tests.                                                    |
| Bulk selection across pages        | Gated / feature-owned                     | Requires selected-scope model, count accuracy, confirmation copy, permissions, and recovery behavior.                                            |
| Bulk destructive action flow       | Pattern-owned by confirmations/overlays   | Requires confirmation Pattern, Button danger contract, server action ownership, and tests.                                                       |
| Top-and-bottom pagination          | Gated                                     | Requires long-results use case, duplicate-control accessibility notes, and focus/order tests.                                                    |
| Drag/reorder controls              | Not owned by Interaction                  | Requires dedicated reorder Pattern, keyboard support, persistence model, and accessibility review.                                               |
| Spreadsheet-like editing grid      | Not approved                              | Requires separate grid/editing Pattern and data model ownership.                                                                                 |
| Custom filter chip colors          | Not allowed                               | Requires Color Element update and Tag Component proof.                                                                                           |

New reusable orchestration belongs in this Pattern doc only after at least one concrete app use case exists or the capability is explicitly queued with trigger conditions.

## Implementation and UI Reference Checklist
### Implementation checklist
| Requirement                | Standard expectation                                                                                                                      |
| -------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| Pattern API/source         | The standard names the canonical Pattern helper, layout partial, route/view surface, source files, or explicit deferred gate.             |
| Required composition       | Components and Elements the Pattern must coordinate are listed.                                                                           |
| Optional composition       | Optional slots, regions, actions, filters, summaries, overlays, or deferred sub-APIs are listed.                                          |
| State/responsive ownership | Loading, empty, error, blocked, validation, persistence, focus order, responsive, and overflow behavior owned by the Pattern are defined. |
| Accessibility/content      | Page/workflow semantics, heading structure, focus flow, status messaging, action labels, and non-color meaning are defined.               |
| Tests                      | Route/content/API assertions prove the Pattern and coordinated Component usage.                                                           |

### UI Reference proof checklist
| Requirement            | Visual proof expectation                                                                                                           |
| ---------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| Live compositions      | The page renders production-like composed examples, not isolated primitive samples.                                                |
| Component coordination | Child Components show how they consume the Pattern layout and state ownership.                                                     |
| Element consumption    | Spacing, grid, typography, color, theme, icon, and motion use are shown at the Pattern level.                                      |
| Variants/states        | Required layout variants, responsive states, empty/loading/error/blocked states, or explicit gates are visible.                    |
| Related APIs           | Coordinated Components, consumed Elements, planned sub-APIs, source files, and canonical docs are linked.                          |
| Manual review          | The page provides enough rendered proof for visual review of composition, hierarchy, responsive behavior, and workflow boundaries. |
## 19. UI Reference requirements

The UI Reference page must render the approved five-card scaffold: Purpose, Use cases, Pattern contract, Live examples, and Related components and patterns.

The Interaction proof may live on `/platform/ui-reference/patterns/data-content` as part of the Data/content family page. It must show rendered examples of approved pattern compositions, not abstract notes only.

Required Live examples internal sections:

| Required proof                    | Rendered behavior                                                                                                                                    | Variants/options shown                                                      |
| --------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------- |
| API status proof                  | Page states that Interaction is an implemented Pattern standard under Data/content and identifies `x-ui.patterns.search-filter-bar` where installed. | Implemented standard, Pattern-owned, feature-owned data behavior            |
| Search and filter bar             | Rendered query field, filter controls, apply/clear actions, result count, and affected region relationship.                                          | Search, Select/Dropdown, Checkbox, Apply filters, Clear filters             |
| Toolbar action group              | Rendered region-level actions with correct Button/Menu hierarchy and no unrelated controls.                                                          | Create, Export, Settings/Menu, Action hierarchy                             |
| Batch action row                  | Rendered selected-count row that appears only when selection exists.                                                                                 | Selected count, Clear selection, Batch action, Danger action boundary       |
| Filter summary row                | Rendered active filters with visible summary, removable Tags, clear-all action, and result count.                                                    | Active filters, Removable Tags, Clear all, Result count                     |
| Local control cluster             | Rendered compact local controls affecting one bounded region.                                                                                        | Sort, Refresh, Local filter, Region label                                   |
| No-results recovery               | Rendered no-results state tied to active query/filter context with one recovery action.                                                              | No results, Clear filters, Retry/search guidance                            |
| Pending/result update behavior    | Example documents loading placement and result-count update announcement expectations.                                                               | Loading, Inline loading, Result count, Live region note                     |
| Responsive behavior proof         | Examples show wrapping, stacking, and menu collapse without hiding active filters.                                                                   | Wrap, Stack, Collapse, Overflow menu                                        |
| Accessibility proof               | Examples show labels, keyboard order, affected-region relationship, selected count, removable filter labels, and result change announcements.        | Labels, Keyboard, `aria-live`, selected count, remove labels                |
| Content behavior proof            | Examples show concrete search/filter labels, count labels, specific action labels, and useful no-results copy.                                       | Search users, Apply filters, 3 selected, No users match these filters       |
| Boundary proof                    | Page distinguishes Pattern-owned composition from Component-owned controls and feature-owned query/data rules.                                       | Component boundary, Pattern boundary, Feature handoff                       |
| Prohibited usage proof            | Page calls out local toolbars, hidden active filters, unrelated dense controls, Bootstrap/Carbon classes, and fake saved views as prohibited.        | Local wrappers, Hidden filters, Bootstrap, Carbon classes, Fake saved views |
| Deferred gate proof               | Page shows trigger conditions for saved filters, complex query builders, async controllers, sticky toolbars, and bulk selection across pages.        | Saved filters, Query builder, Async, Sticky, Cross-page selection           |
| Foundation Elements proof         | Page links consumed Element APIs and shows token responsibilities.                                                                                   | Color, Spacing, Typography, Themes, Icons, Motion, 2x Grid                  |
| Developer implementation examples | Canonical composition examples render as real code examples and do not include placeholder text.                                                     | Search/filter bar, Toolbar, Batch row, Filter summary, Local controls       |

The page must link to this canonical standard and to consumed Element and Component standards. Deferred capabilities must appear as explicit gated disposition rows with trigger conditions, not fake complete examples. Examples must use app-owned tokens, classes, helpers, and Blade components where available.

## 20. Testing and acceptance criteria

- `/platform/ui-reference/patterns/data-content` returns 200 for authorized users.
- The page shows the installed Interaction Pattern API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Rendered examples include the required composition markers and consumed Component links.
- Implemented Pattern compositions render production-like examples.
- Deferred capabilities render trigger conditions instead of fake controls.
- No Pattern example hard-codes Foundation Element decisions that already have approved APIs.
- No Pattern example uses local raw colors, arbitrary spacing, local icon sourcing, one-off focus treatments, Bootstrap toolbars/forms, or direct Carbon classes.
- Search/filter examples show labels, result count, active filter summary, and affected-region relationship.
- Toolbar examples distinguish global page actions from dataset/region actions.
- Batch examples appear only with selected-count state.
- Filter summary examples do not make chips the only record of active filters.
- No-results examples appear in the affected result region with recovery copy.
- Responsive examples show wrapping/collapse without hiding active filters or primary actions.
- The route does not contain placeholder language such as `Pattern-specific API pending correction`, `Component-specific API pending correction`, `Legacy Contract Summary`, or `Reference Examples`.
- The route does not link to deprecated `tier-1` or `tier-2` component docs paths.
- The route does not present saved filters, complex query builders, cross-page bulk selection, or async controllers as installed unless the gated requirements are met.

Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/patterns/data-content');

$response->assertOk();
$response->assertSee('Interaction Pattern API');
$response->assertSee('x-ui.patterns.search-filter-bar');
$response->assertSee('Search and filter bar');
$response->assertSee('Toolbar action group');
$response->assertSee('Batch action row');
$response->assertSee('Filter summary row');
$response->assertSee('Local control cluster');
$response->assertSee('No-results recovery');
$response->assertSee('Active filters');
$response->assertSee('Result count');
$response->assertSee('Selected count');
$response->assertSee('Apply filters');
$response->assertSee('Clear filters');
$response->assertSee('Saved filters');
$response->assertSee('Gated');
$response->assertSee('Color');
$response->assertSee('Spacing');
$response->assertSee('Typography');
$response->assertSee('Themes');
$response->assertSee('Icons');
$response->assertSee('Motion');
$response->assertSee('2x Grid');
$response->assertDontSee('Pattern-specific API pending correction');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('Generic fallback');
$response->assertDontSee('TODO');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('btn btn-primary');
$response->assertDontSee('form-control');
$response->assertDontSee('dropdown-menu');
$response->assertDontSee('row col-');
```

## 21. Related APIs

| API                             | Route                                                                |
| ------------------------------- | -------------------------------------------------------------------- |
| Search                          | `/platform/ui-reference/components/search`                           |
| Text input                      | `/platform/ui-reference/components/text-input`                       |
| Select                          | `/platform/ui-reference/components/select`                           |
| Dropdown                        | `/platform/ui-reference/components/dropdown`                         |
| Checkbox                        | `/platform/ui-reference/components/checkbox`                         |
| Button                          | `/platform/ui-reference/components/button`                           |
| Menu buttons                    | `/platform/ui-reference/components/menu-buttons`                     |
| Pagination                      | `/platform/ui-reference/components/pagination`                       |
| Data table                      | `/platform/ui-reference/components/data-table`                       |
| Tag                             | `/platform/ui-reference/components/tag`                              |
| Notification                    | `/platform/ui-reference/components/notification`                     |
| Loading                         | `/platform/ui-reference/components/loading`                          |
| Inline loading                  | `/platform/ui-reference/components/inline-loading`                   |
| Link                            | `/platform/ui-reference/components/link`                             |
| Data and Content Pattern        | `/platform/ui-reference/patterns/data-content`                       |
| Tables Pattern                  | `/platform/ui-reference/patterns/tables`                             |
| Table toolbar planned gap       | `/platform/ui-reference/patterns/tables`                             |
| Forms Pattern                   | `/platform/ui-reference/patterns/forms`                              |
| Overlay and Feedback Pattern    | `/platform/ui-reference/patterns/overlays-feedback`                  |
| Boundary and validation Pattern | `/platform/ui-reference/patterns`                                    |
| Color Element                   | `/platform/ui-reference/elements/color`                              |
| Spacing Element                 | `/platform/ui-reference/elements/spacing`                            |
| Typography Element              | `/platform/ui-reference/elements/typography`                         |
| Themes Element                  | `/platform/ui-reference/elements/themes`                             |
| Icons Element                   | `/platform/ui-reference/elements/icons`                              |
| Motion Element                  | `/platform/ui-reference/elements/motion`                             |
| 2x Grid Element                 | `/platform/ui-reference/elements/2x-grid`                            |
| Canonical interactions doc      | `/platform/docs?path=02-standards%2Fui%2Fpatterns%2Finteractions.md` |
| Carbon search pattern           | `https://carbondesignsystem.com/patterns/search-pattern/`            |
| Carbon filtering pattern        | `https://carbondesignsystem.com/patterns/filtering/`                 |
| Carbon data table usage         | `https://carbondesignsystem.com/components/data-table/usage/`        |

## 22. References

- [Pattern Library Checklist](checklist.md)
- [Pattern Standards Index](index.md)
- [Component Standards](../components/index.md)
- [Foundation Elements Standards](../elements/index.md)
- [Search Component Standard](../components/search.md)
- [Dropdown Component Standard](../components/dropdown.md)
- [Data Table Component Standard](../components/data-table.md)
- [Pagination Component Standard](../components/pagination.md)
- [Tag Component Standard](../components/tag.md)
- [Button Component Standard](../components/button.md)
- [Loading Component Standard](../components/loading.md)
- [Boundary and Validation Pattern](boundary-and-validation.md)
- Carbon Patterns overview, Search Pattern, Filtering Pattern, and Data table guidance inform the goal-based composition model, broad-to-narrow search/filter behavior, batch-versus-instant filter decisions, visible multiple-filter categories, toolbar placement, batch action row behavior, and pagination/result-region relationships. Login App keeps its own Pattern APIs, Component APIs, Foundation Element token model, app-owned `ui-*` classes, feature-owned data behavior, and UI Reference proof.