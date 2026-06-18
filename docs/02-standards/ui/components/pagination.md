---
title: Pagination
slug: pagination
api_layer: Component API
status: implemented-pending-review
system_maturity: complete
category: data-display
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/components/pagination
canonical_doc: docs/02-standards/ui/components/pagination.md
source_owner: /platform/ui-reference/components/pagination
blade_api:
  - x-ui.pagination
javascript_api:
  - initPagination
source_files:
  - resources/views/components/ui/pagination.blade.php
  - resources/views/platform/ui-reference/components/live-examples/pagination.blade.php
  - resources/js/ui-controls/pagination.js
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
  - 2x-grid
related_components:
  - button
  - icon-button
  - link
  - select
  - loading
  - inline-loading
  - data-table
related_patterns:
  - tables
  - data-list
  - search-results
  - forms
carbon_reference:
  - https://carbondesignsystem.com/components/pagination/usage/
  - https://carbondesignsystem.com/components/pagination/style/
  - https://carbondesignsystem.com/components/pagination/accessibility/
---

# Pagination Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Canonical Laravel paginator call](#41-canonical-laravel-paginator-call)
  - [4.2. Pagination bar with page-size selector](#42-pagination-bar-with-page-size-selector)
  - [4.3. Pagination nav](#43-pagination-nav)
  - [4.4. Explicit data contract](#44-explicit-data-contract)
  - [4.5. API surfaces](#45-api-surfaces)
  - [4.6. Props and options](#46-props-and-options)
  - [4.7. Data contract](#47-data-contract)
  - [4.8. Component-owned data attributes](#48-component-owned-data-attributes)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
  - [7.4. Helper and composition usage](#74-helper-and-composition-usage)
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

Pagination moves through segmented record sets and gives users controlled navigation across pages of data.

Canonical API owner: `/platform/ui-reference/components/pagination`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Pagination is the installed Login App 2.0 record-set navigation API. It owns page navigation semantics, previous/next controls, current-page treatment, disabled boundary controls, overflow menus, result count copy, optional page-size selection, pagination bar layout, pagination nav layout, size variants, focus styling, responsive behavior, and token-backed states. It does not own data querying, table layout, list layout, filtering, sorting, search state, empty-state messaging, route authorization, or server-side pagination logic.

### 1.1. Canonical API responsibilities:

- Render record-set navigation through `x-ui.pagination`.
- Use semantic navigation markup with an accessible label.
- Expose previous, next, current page, page number, overflow, and disabled boundary states.
- Support `variant="pagination"` as the bar-style pagination attached to tables or large record regions.
- Support `variant="pagination-nav"` as page-button navigation beneath pages, sections, lists, or other page-level content.
- Support `size="sm"`, `size="md"`, and `size="lg"`.
- Support optional page-size selection when the owning page allows users to change result count per page.
- Support optional page looping only when continuous cycling through pages makes sense.
- Preserve query-string state when filters, search, or sorting are active.
- Render loading/skeleton-adjacent states through approved Loading or Inline loading composition instead of local spinner markup.
- Consume Foundation Element APIs for color, spacing, typography, themes, icons, and 2x Grid where layout placement is proven.
- Prove pagination bar, pagination nav, page-size selector, page selector, disabled boundary, overflow menu, looping, empty/small-data boundary, loading/skeleton handoff, responsive, and developer implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Fetching data or calculating records. Controllers, query objects, or parent Patterns own data loading.
- Table column alignment, sorting, row density, zebra stripes, and row hover. Use Data table and Table toolbar Patterns.
- List or card result layout. Use Data list or Search results Patterns when installed.
- Search, filtering, and sorting controls. Use Search, Select, Table toolbar, and Pattern APIs.
- Empty-state content and recovery actions. Use Empty state or the owning Pattern when installed.
- Persistent loading, skeleton, or page-level progress. Use Loading, Inline loading, or the Loading Pattern.
- External spacing and placement. Parent Patterns own pagination location and surrounding layout.

## 2. Status and ownership

| Field                        | Value                                                                               |
| ---------------------------- | ----------------------------------------------------------------------------------- |
| Status                       | Implemented Pending Review                                                         |
| System maturity              | Complete                                                                            |
| API layer                    | Component API                                                                       |
| Component slug               | pagination                                                                          |
| Category                     | Data display                                                                        |
| Priority                     | Tier A - Baseline app development                                                   |
| UI Reference route           | `/platform/ui-reference/components/pagination`                                      |
| Canonical doc                | `docs/02-standards/ui/components/pagination.md`                                     |
| Source owner                 | `/platform/ui-reference/components/pagination`                                      |
| Blade API                    | `x-ui.pagination`                                                                   |
| JavaScript API               | `initPagination` private lifecycle initializer for overflow menus and UI Reference/local state examples |
| Source files                 | `resources/views/components/ui/pagination.blade.php`; `resources/views/platform/ui-reference/components/live-examples/pagination.blade.php`; `resources/js/ui-controls/pagination.js`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Icons, 2x Grid where composed in data layouts   |
| Carbon benchmark             | Carbon Pagination usage, style, and accessibility guidance                          |

`Implemented Pending Review` means the installed component, UI Reference page, canonical docs, and tests show Pagination as a data-navigation component with real API calls, state coverage, overflow behavior, page-size behavior, accessibility labels, and responsive rules.

## 3. Installed standard

Pagination is the standard way to navigate a segmented record set after a server-rendered or application-owned query returns more records than the current view displays.

### The installed standard is:

- Render pagination through `<x-ui.pagination>`.
- Use `variant="pagination"` when users need table-adjacent range, items-per-page, current-page selector, previous, and next controls.
- Use `variant="pagination-nav"` when users need page buttons below page, section, list, or page-level content.
- Use `size="sm"`, `size="md"`, or `size="lg"` to match surrounding table/list density.
- Use `showItemsPerPage` only when the owning page supports per-page changes.
- Use approved page-size options only.
- Show current page and total/page count information when that information is known.
- Use disabled previous/next controls at the first and last pages.
- Use overflow ellipsis buttons with menus when page counts exceed the rendered page-number window.
- Preserve active query parameters for search, filters, sorts, and page-size changes.
- Use links for page navigation when navigation changes the URL.
- Use buttons only when an installed client-side state owner updates the record set without route navigation.
- Do not render pagination for a single page unless the owning Pattern needs a stable footer and the controls are disabled/empty by design.
- Do not render empty, fake, or decorative page controls.
- Do not create local table-pagination bars, local page-size selectors, raw utility clusters, raw colors, local icons, or custom JavaScript for the same UI role.

Carbon alignment note: Carbon defines pagination as a control for dividing large content sets across pages and giving users control over how many items appear per page. Carbon also separates pagination from data table behavior, documents page navigation and page-size controls, and requires accessible names for page, previous, and next controls. Login App maps those principles to its own `x-ui.pagination` API, `ui-*` class namespace, app tokens, Laravel-friendly data contract, and UI Reference proof instead of adopting Carbon implementation classes directly.

## 4. Public API

### 4.1. Canonical Laravel paginator call

```blade
<x-ui.pagination
    :paginator="$users"
    label="Users pagination"
/>
```

### 4.2. Pagination bar with page-size selector

```blade
<x-ui.pagination
    :paginator="$users"
    label="Users pagination"
    variant="pagination"
    size="md"
    :show-items-per-page="true"
    :page-size-options="[10, 25, 50, 100]"
    page-size-name="per_page"
/>
```

The `variant="pagination"` bar must render the Carbon-aligned segment order below. Do not replace this with a grouped flex cluster or feature-local table footer.

1. Items-per-page segment: visible `Items per page:` label plus composed `x-ui.select inline no-label` page-size control.
2. Calculated range segment: `x–y of n items` using an en dash.
3. Page-selector segment: composed `x-ui.select inline no-label` current-page control plus `of n pages` copy.
4. Previous icon-button cell.
5. Next icon-button cell.

Pagination composes Select for both controls. Select owns the native select, visible chevron, internal value/icon spacing, focus, disabled, and read-only behavior. Pagination may pass native select data hooks through Select's `selectAttributes` API, but it must not render local select shells, local chevron icons, or pagination-owned select chrome classes.

### 4.3. Pagination nav

```blade
<x-ui.pagination
    label="Search results pagination"
    variant="pagination-nav"
    size="md"
    alignment="right"
    :current-page="3"
    :total-pages="12"
/>
```

### 4.4. Explicit data contract

Use explicit values only when a Laravel paginator object is not available.

```blade
<x-ui.pagination
    label="Search results pagination"
    variant="pagination-nav"
    :current-page="3"
    :total-pages="12"
    :page-size="25"
    :total-items="287"
/>
```

Use the Blade API instead of hand-building `<nav>`, page links, previous/next buttons, page-size controls, ellipses, or disabled boundary controls in feature views.

### 4.5. API surfaces

| API surface           | Installed value                                                                                            |
| --------------------- | ---------------------------------------------------------------------------------------------------------- |
| Blade API             | `x-ui.pagination`                                                                                          |
| JavaScript            | `initPagination` lifecycle initializer owns overflow menu behavior and interactive UI Reference/local pagination examples; feature data fetching remains parent-owned |
| Root semantic element | Component-owned navigation landmark, normally `<nav aria-label="...">`                                     |
| Page controls         | Links for URL navigation; buttons only when parent state owner handles client-side pagination              |
| Page-size selector    | Component-owned select composition when `showItemsPerPage` is enabled                                      |
| Data attributes       | Component-owned attributes documented below. Feature views must not invent pagination behavior attributes. |
| CSS namespace         | App-owned `ui-*` pagination classes documented by the component implementation                             |
| Source files          | `resources/views/components/ui/pagination.blade.php`; `resources/css/app.css`                              |

### 4.6. Props and options

| Prop/option                                                                  | Type                       | Default                                                          | Allowed values                                                                     | Required                             | Notes                                                                                                                                  |
| ---------------------------------------------------------------------------- | -------------------------- | ---------------------------------------------------------------- | ---------------------------------------------------------------------------------- | ------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------- |
| `paginator`                                                                  | `LengthAwarePaginator      | Paginator                                                        | null`                                                                              | `null`                               | Laravel paginator instance                                                                                                             | Preferred                                                                                                        | Preferred data source. Component reads current page, last page, total, per-page count, URLs, and query-string state. |
| `label`                                                                      | `string`                   | `Pagination`                                                     | Short accessible navigation label                                                  | No, but recommended                  | Use context-specific labels such as `Users pagination` when multiple paginated regions exist.                                          |
| `variant`                                                                    | `string`                   | `pagination`                                                     | `pagination`, `pagination-nav`; compatibility aliases `full`, `compact`            | No                                   | `pagination` renders the table-style bar; `pagination-nav` renders page-button navigation.                                             |
| `size`                                                                       | `string`                   | `md`                                                             | `sm`, `md`, `lg`                                                                   | No                                   | Controls container and icon button height. Match data-table density where possible.                                                    |
| `currentPage`                                                                | `current-page`             | `int                                                             | null`                                                                              | read from paginator                  | `1...lastPage` / Required only without `paginator`                                                                                     | Current active page.                                                                                             |
| `totalPages` / `total-pages` / `lastPage`                                    | `int`                      | `1`                                                              | `1...n`                                                                            | Required without paginator           | Total number of pages.                                                                                                                 |
| `pageSize` / `page-size` / `perPage`                                         | `int`                      | `25`                                                             | Approved page-size value                                                           | Required for page-size summary       | Number of records per page.                                                                                                            |
| `totalItems` / `total-items` / `total`                                       | `int`                      | `null`                                                           | `0...n`                                                                            | Required for known-total summary     | Total record count when known.                                                                                                         |
| `from`                                                                       | `int                       | null`                                                            | read from paginator                                                                | `0...n`                              | No                                                                                                                                     | First visible item number in the current page summary.                                                           |
| `to`                                                                         | `int                       | null`                                                            | read from paginator                                                                | `0...n`                              | No                                                                                                                                     | Last visible item number in the current page summary.                                                            |
| `previousUrl`                                                                | `previous-url`             | `string                                                          | null`                                                                              | read from paginator                  | Valid URL / Required without `paginator` when previous exists                                                                          | Null disables previous control.                                                                                  |
| `nextUrl`                                                                    | `next-url`                 | `string                                                          | null`                                                                              | read from paginator                  | Valid URL / Required without `paginator` when next exists                                                                              | Null disables next control.                                                                                      |
| `alignment`                                                                  | `string`                   | `right`                                                          | `left`, `right`                                                                    | No                                   | Applies to pagination nav placement under page or section content.                                                                     |
| `loop`                                                                       | `bool`                     | `false`                                                          | `true`, `false`                                                                    | No                                   | Allows next on last page and previous on first page only where continuous cycling makes sense.                                         |
| `window`                                                                     | `int`                      | `2`                                                              | `1`, `2`, `3`                                                                      | No                                   | Number of adjacent pages to show around current page before overflow ellipses.                                                         |
| `showItemsPerPage` / `show-items-per-page`                                   | `bool`                     | `true`                                                           | `true`, `false`                                                                    | No                                   | Enables page-size selector when supported by the owning route.                                                                         |
| `showItemRange` / `show-item-range`                                         | `bool`                     | `true`                                                           | `true`, `false`                                                                    | No                                   | Shows visible item range and total.                                                                                                    |
| `showPageSelector` / `show-page-selector`                                   | `bool`                     | `true`                                                           | `true`, `false`                                                                    | No                                   | Shows current-page select in the pagination bar.                                                                                       |
| `pageSizeOptions` / `page-size-options` / `array<int>` / `[10, 25, 50, 100]` | Approved positive integers | No                                                               | Keep options short and consistent across comparable views.                         |                                      |                                                                                                                                        |
| `pageSizes`                                                                  | `array<int>`               | `null`                                                           | Approved positive integers                                                         | No                                   | Carbon-compatible alias for `pageSizeOptions`; `pageSizeOptions` wins when both are supplied.                                          |
| `itemsPerPageText` / `items-per-page-text`                                   | `string`                   | `Items per page:`                                                | Localized label text                                                               | No                                   | Visible label for the page-size selector. Keep the colon unless localization requires different punctuation.                           |
| `backwardText` / `backward-text`                                             | `string`                   | `Previous page`                                                  | Accessible control text                                                            | No                                   | Accessible label for the previous-page control.                                                                                        |
| `forwardText` / `forward-text`                                               | `string`                   | `Next page`                                                      | Accessible control text                                                            | No                                   | Accessible label for the next-page control.                                                                                            |
| `pageNumberText` / `page-number-text`                                        | `string`                   | `Page number`                                                    | Accessible selector text                                                           | No                                   | Accessible label for the current-page select.                                                                                          |
| `pageSizeName` / `page-size-name` / `string` / `per_page`                    | Query parameter name       | No                                                               | Must match the controller/query contract.                                          |                                      |                                                                                                                                        |
| `pageName` / `page-name` / `string` / `page`                                 | Query parameter name       | No                                                               | Use Laravel default unless multiple paginated regions require distinct page names. |                                      |                                                                                                                                        |
| `preserveQuery` / `preserve-query` / `bool` / `true` / `true`, `false`       | No                         | Keeps filters, search, sort, and page size while changing pages. |                                                                                    |                                      |                                                                                                                                        |
| `loading`                                                                    | `bool`                     | `false`                                                          | `true`, `false`                                                                    | No                                   | Use only when the parent state owner can mark the record set pending. Prefer Loading/Inline loading composition for server navigation. |
| `disabled`                                                                   | `bool`                     | `false`                                                          | `true`, `false`                                                                    | No                                   | Disables all controls when the owning region is unavailable.                                                                           |
| `class`                                                                      | `string                    | null`                                                            | `null`                                                                             | Layout passthrough if supported      | No                                                                                                                                     | Parent Patterns may pass placement classes only. Do not use for color, typography, state, or behavior overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.7. Data contract

Preferred input is a Laravel paginator object. When explicit pagination data is used, the component must receive enough information to render accurate links and state.

| Field        | Required                           | Rule                                                                                         |
| ------------ | ---------------------------------- | -------------------------------------------------------------------------------------------- |
| Current page | Yes                                | Must be an integer greater than or equal to 1.                                               |
| Last page    | Required for `variant="pagination-nav"` and known-total `variant="pagination"` | Must be greater than or equal to current page.                                               |
| Previous URL | Required when previous page exists | Null or omitted disables the previous control.                                               |
| Next URL     | Required when next page exists     | Null or omitted disables the next control.                                                   |
| Page URLs    | Component-generated from base URL  | Preserve active route/query state where the parent provides it.                              |
| Total        | Required for full summary          | Use null only when the total is unknown and summary copy is adjusted.                        |
| Per page     | Required for page-size selector    | Must match one of the approved page-size options.                                            |
| Query state  | Pattern-owned                      | Preserve search, filters, sort, and page-size state unless intentionally reset by the route. |

### 4.8. Component-owned data attributes

| Data attribute                                    | Status                   | Owner     | Purpose                                                                                        |
| ------------------------------------------------- | ------------------------ | --------- | ---------------------------------------------------------------------------------------------- |
| `data-ui-component="pagination"`                  | Implemented when emitted | Component | Identifies the root component for testing and diagnostics.                                     |
| `data-ui-pagination-variant="pagination / pagination-nav"` | Implemented when emitted | Component | Exposes approved variant for tests and component-owned styling only.                           |
| `data-ui-pagination-size="sm / md / lg"`          | Implemented when emitted | Component | Exposes approved size for tests and component-owned styling only.                              |
| `data-ui-pagination-alignment="left / right"`     | Implemented when emitted | Component | Exposes approved nav alignment for tests and component-owned styling only.                      |
| `data-ui-pagination-current="{page}"`             | Implemented when emitted | Component | Identifies current page for diagnostics.                                                       |
| `data-ui-pagination-page`                         | Implemented when emitted | Component | Identifies page-number controls.                                                               |
| `data-ui-pagination-prev`                         | Implemented when emitted | Component | Identifies previous control.                                                                   |
| `data-ui-pagination-next`                         | Implemented when emitted | Component | Identifies next control.                                                                       |
| `data-ui-pagination-page-size`                    | Implemented when emitted | Component | Identifies page-size selector.                                                                 |
| `data-ui-pagination-page-select`                  | Implemented when emitted | Component | Identifies current-page selector in the pagination bar.                                        |
| `data-ui-pagination-page-size-form`               | Implemented when emitted | Component | Identifies the page-size segment form wrapper for diagnostics and interactive examples.        |
| `data-ui-pagination-range`                        | Implemented when emitted | Component | Identifies calculated range copy for interactive updates.                                      |
| `data-ui-pagination-total-pages-label`            | Implemented when emitted | Component | Identifies total-page copy for interactive updates.                                           |
| `data-ui-pagination-overflow`                     | Implemented when emitted | Component | Identifies the overflow ellipsis menu for hidden pages.                                        |
| `data-ui-pagination-interactive="true"`           | Implemented when emitted | Component | Enables local example state updates without route navigation.                                  |
| `data-ui-pagination-small-breakpoint="true"`      | Implemented when emitted | Component | Forces the UI Reference small-breakpoint proof state.                                          |
| Feature-local data attributes                     | Not allowed              | none      | Do not create local pagination state, loading, responsive, or interaction behavior attributes. |

## 5. Allowed variants, options, and modifiers

| Name                                 | Type                        | Status                                             | API                                                                               | Notes                                                                         |
| ------------------------------------ | --------------------------- | -------------------------------------------------- | --------------------------------------------------------------------------------- | ----------------------------------------------------------------------------- |
| Pagination bar                       | Variant                     | Implemented                                        | `variant="pagination"`                                                            | Shows items per page, item range, page selector, previous, and next.          |
| Pagination nav                       | Variant                     | Implemented                                        | `variant="pagination-nav"`                                                        | Shows previous/next, page numbers, selected page, and overflow menus.         |
| Small size                           | Size                        | Implemented                                        | `size="sm"`                                                                       | 32px controls; pair with extra-small or small table rows.                     |
| Medium size                          | Size                        | Implemented                                        | `size="md"`                                                                       | 40px controls; default.                                                       |
| Large size                           | Size                        | Implemented                                        | `size="lg"`                                                                       | 48px controls; pair with large or extra-large table rows.                     |
| Data table size pairing              | Composition rule            | Implemented / required proof                       | Data table `xs/sm/md/lg/xl` to Pagination `sm/sm/md/lg/lg`                       | Pagination does not expose extra-small or extra-large sizes directly.         |
| Page-size selector                   | Option                      | Implemented / required proof if source supports it | `showItemsPerPage`                                                                | Lets users change records per page when the route supports it.                |
| Page summary                         | Option                      | Implemented                                        | automatic from paginator or explicit data                                         | Shows visible range and total when known.                                     |
| Previous/next controls               | Control                     | Implemented                                        | automatic                                                                         | Boundary controls become disabled at first/last page.                         |
| Page-number controls                 | Control                     | Implemented                                        | `variant="pagination-nav"`                                                        | Current page is indicated and not presented as a normal navigation target.    |
| Overflow ellipsis menu               | State/control               | Implemented                                        | automatic with `window`                                                           | Opens hidden page options when skipped pages exist.                           |
| Page looping                         | Modifier                    | Implemented                                        | `loop`                                                                            | Continuous cycling at boundaries only when the content supports it.           |
| Disabled pagination                  | State                       | Implemented                                        | `disabled` or boundary state                                                      | Prevents navigation when the region is unavailable or at a boundary.          |
| Loading handoff                      | Composition                 | Implemented through Loading/Inline loading         | `loading` or parent composition                                                   | Use approved loading APIs, not local spinners.                                |
| Unknown-total pagination             | Mode                        | Gated                                              | none unless implemented                                                           | Requires copy and navigation proof for APIs that know only previous/next.     |
| Infinite scroll                      | Not owned                   | none                                               | Use a dedicated Pattern if installed; do not add infinite behavior to Pagination. |                                                                               |
| Jump-to-page input                   | Deferred                    | none                                               | Requires Number input, validation, keyboard, and URL-state proof.                 |                                                                               |
| First/last controls                  | Deferred unless implemented | none                                               | Requires API, icon labels, disabled states, and responsive proof.                 |                                                                               |
| Interactive local examples           | Lifecycle behavior          | Implemented / UI Reference only                    | `interactive`                                                                     | Updates example page/page-size state without owning parent data fetching.     |
| Custom page-size options per feature | Gated                       | `pageSizeOptions` with Pattern approval            | Use only when data type or performance requires different values.                 |                                                                               |

## 6. States

| State                 | Status                       | Implementation requirement                                                                                                                  |
| --------------------- | ---------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------- |
| Default               | Implemented                  | Renders approved variant, label, summary, controls, and density.                                                                            |
| Hover                 | Implemented                  | Token-backed hover treatment on interactive page, previous, next, and page-size controls.                                                   |
| Focus-visible         | Implemented                  | Token-backed focus ring visible on every interactive control in supported themes.                                                           |
| Active/pressed        | Implemented                  | Token-backed pressed state for page, previous, next, and selector controls where applicable.                                                |
| Current/selected page | Implemented                  | Current page is visually distinct and programmatically indicated with `aria-current="page"` or equivalent component-owned markup.           |
| Disabled previous     | Implemented                  | Previous control is disabled on the first page or when no previous URL exists.                                                              |
| Disabled next         | Implemented                  | Next control is disabled on the last page or when no next URL exists.                                                                       |
| Disabled all controls | Implemented                  | `disabled` prevents all pagination interaction when the parent region is unavailable.                                                       |
| Empty                 | Implemented / required proof | Do not render controls for zero results unless the Pattern requires a stable footer; render disabled/empty summary only when proven.        |
| Single page           | Implemented / required proof | Hide controls by default; stable disabled footer is Pattern-owned.                                                                          |
| Loading               | Composition-owned            | Use Loading or Inline loading for pending record sets. Pagination may expose disabled/pending controls but must not create a local spinner. |
| Skeleton              | Not owned                    | Skeleton belongs to Loading Pattern or data display Pattern, not Pagination itself.                                                         |
| Overflow              | Implemented                  | Ellipsis buttons open menus for skipped page ranges and hidden page options remain keyboard reachable.                                       |
| Responsive            | Implemented / required proof | Pagination bar preserves item range and previous/next controls on narrow screens; pagination nav avoids crowding through overflow menus.     |
| Page-size open/closed | Composition-owned            | If the selector uses Select, open/closed behavior belongs to Select.                                                                        |
| Error                 | Not owned                    | Query/load errors belong to Notification, Inline alert, or owning data Pattern.                                                             |
| Warning               | Not owned                    | Warning states belong to Notification or owning data Pattern.                                                                               |
| Success               | Not applicable               | Pagination does not communicate success.                                                                                                    |
| Validation            | Not applicable               | No validation unless future jump-to-page input is installed.                                                                                |
| Read-only             | Not applicable               | Use disabled state if navigation is unavailable.                                                                                            |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Pagination consumes Foundation Color, Spacing, Typography, Themes, Icons, and 2x Grid where pagination is composed into data layouts.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Icons.
- 2x Grid where pagination is placed with tables, lists, search results, or page regions.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                 |
| ----------- | ----------------------------------------------------------------------------------------------------------------------------- |
| Color       | Text, icon, border, selected/current page indicator, hover, active, disabled, focus, separator, and supported theme contrast. |
| Spacing     | Internal page-control padding, control gap, summary gap, selector gap, compact density, and responsive wrapping gap.          |
| Typography  | Page summary, page numbers, selector labels, button labels, and accessible visible text.                                      |
| Themes      | Light, dark, and inverse token resolution for controls, text, selected/current state, borders, and focus.                     |
| Icons       | Previous/next chevrons, selector affordances, and optional first/last icons only through the Icons Element.                   |
| 2x Grid     | Parent-owned placement with data tables, lists, search results, and page regions.                                             |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$layer` | Pagination container background | `ui-pagination` surface role | App layer palette | Same role / app value | Pagination surface follows the surrounding data layout layer. |
| `$border-subtle` | Pagination top/container border | `ui-pagination` border role | App border palette | Same role / app value | Table/list pagination borders share border-subtle mapping. |
| `$text-secondary`, `$text-disabled` | Page range and disabled nav text | Pagination summary/nav text roles | App text palette | Same role / app value | Text roles must not be local muted utilities. |
| `$icon-disabled` | Disabled previous/next icons | Pagination icon disabled role | App icon palette | Same role / app value | Icons inherit from component state. |
| `$layer-hover` | Nav hover background | Pagination nav hover role | App layer state palette | Same role / app value | Hover state shares layer hover mapping. |
| `$border-interactive` | Selected/current page indicator | Current page border/indicator role | App border-interactive palette | Same role / app value | Current/selected state must be semantic and accessible. |
| `$focus` | Page/nav focus treatment | Pagination link/button focus-visible | App focus palette | Same role / app value | Focus stays Color-owned. |

Pagination bar structure and spacing:

| Element / segment                    | Required structure / spacing                                                                                                  |
| ------------------------------------ | ----------------------------------------------------------------------------------------------------------------------------- |
| Pagination bar container             | 1px border; no extra internal grid gap; no trailing space after next control.                                                  |
| Items-per-page segment               | 16px / 1rem segment padding; right separator border; visible `Items per page:` label.                                          |
| Items-per-page inline select shell   | 8px / 0.5rem left spacing from label/value area; 16px / 1rem right spacing after the chevron area; no left border split.      |
| Calculated range segment             | 16px / 1rem left and right padding; copy renders `x–y of n items`.                                                            |
| Page-selector segment                | 16px / 1rem left and right segment padding; left separator border; copy renders `[page select] of n pages`.                   |
| Page-selector inline select shell    | 16px / 1rem left spacing before value; 8px / 0.5rem value-to-chevron and chevron-to-total-page-copy spacing.                  |
| Previous and next cells              | Fixed cell width equal to pagination height; left separator border on each cell; icon centered.                               |
| Select chevrons and prev/next icons  | 16px x 16px icon size; Select owns select chevrons; Pagination owns previous/next icons; icons inherit `currentColor`.        |
| Small pagination                     | 32px / 2rem control height.                                                                                                   |
| Medium pagination                    | 40px / 2.5rem control height.                                                                                                 |
| Large pagination                     | 48px / 3rem control height.                                                                                                   |

Data table size pairings:

| Data table row size | Pagination size |
| ------------------- | --------------- |
| `xs`                | `sm`            |
| `sm`                | `sm`            |
| `md`                | `md`            |
| `lg`                | `lg`            |
| `xl`                | `lg`            |

### 7.3. CSS namespace

Allowed component classes must use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-pagination
.ui-pagination-bar
.ui-pagination-left
.ui-pagination-right
.ui-pagination-page-size-segment
.ui-pagination-select-field
.ui-pagination-page-size-select-field
.ui-pagination-page-number-select-field
.ui-pagination-range-segment
.ui-pagination-page-select-segment
.ui-pagination-total-pages-label
.ui-pagination-nav-shell
.ui-pagination-controls
.ui-pagination-control-cell
.ui-pagination-list
.ui-pagination-item
.ui-pagination-control
.ui-pagination-page
.ui-pagination-overflow
.ui-pagination-overflow-menu
.ui-pagination-overflow-item
.ui-pagination-label
.ui-pagination-pagination
.ui-pagination-nav
.ui-pagination-sm
.ui-pagination-md
.ui-pagination-lg
.ui-pagination-disabled
.ui-pagination-responsive
.ui-pagination-small-breakpoint
```

Feature views must not create Bootstrap `.pagination`, local `.page-item`, local `.page-link`, raw utility clusters, arbitrary widths, hard-coded breakpoints, custom icons, custom focus rings, local table-pagination bars, or direct Carbon implementation classes for the same UI role.

### 7.4. Helper and composition usage

| Helper/API                         | Status                      | Allowed usage                                                                                                                                                |
| ---------------------------------- | --------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| `x-ui.pagination`                  | Implemented                 | Canonical record-set navigation API.                                                                                                                         |
| Laravel paginator                  | Preferred                   | Preferred data object for URL, current page, last page, total, and per-page data.                                                                            |
| `x-ui.select`                      | Internal/component-owned    | Required composition primitive for page-size and page-number controls. Pagination passes native select hooks through `selectAttributes` and does not own select chrome. |
| `x-ui.button` / `x-ui.icon-button` | Internal/component-owned    | May be used by the component implementation for previous/next controls where controls are buttons. Feature views should not compose raw pagination controls. |
| `x-ui.link`                        | Internal/component-owned    | May be used by the component implementation for page links where navigation changes URL.                                                                     |
| Native select / Select styling     | Component-owned composition | Items-per-page and current-page selectors in the pagination bar.                                                                                              |
| Loading                            | Pattern/component-owned     | Used by parent data region for pending loads or skeleton state.                                                                                              |
| Inline loading                     | Composition-owned           | Used near a refresh/action control, not as pagination decoration.                                                                                            |

## 8. Composition rules

- Place Pagination after the record set it controls.
- For data tables, place Pagination at the bottom of the table or table region through the Data table/Table toolbar Pattern.
- For search results, place Pagination after the results list and keep the result count summary nearby.
- Keep pagination connected to exactly one record set.
- Use one pagination component per independently paginated region.
- Use context-specific labels when multiple paginated regions exist on one page.
- Preserve search, filters, sort, and page-size query state when navigating between pages.
- Reset to page 1 when a filter, search term, sort context, or page size changes unless the owning Pattern documents a different behavior.
- Use pagination bar when a table or large record region needs item range, items-per-page, page selector, previous, and next controls.
- Use pagination nav when direct page-button access helps users move through page or section content.
- Use page-size selection only when server/query performance and layout support multiple page sizes.
- Do not mix different pagination sizes inside the same record-set region.
- Do not pair Pagination with infinite scroll for the same record set.
- Do not show both pagination nav page-number navigation and a jump-to-page input unless a future API explicitly supports the combination.
- Do not hide disabled previous/next controls if their presence helps users understand boundary position; use disabled state.
- Do not replace the installed overflow ellipsis menu with local hidden-page controls.
- Components own internal semantics, control styling, current-page treatment, disabled boundary states, overflow, and token-backed states.
- Parent Patterns own data fetching, empty states, error states, external spacing, filter/search integration, responsive layout placement, and workflow orchestration.

## 9. Selection guidance

### 9.1. Use when:

- A record set has more records than should be shown in one view.
- Loading the full record set at once would hurt performance, scanability, or page layout.
- Users need direct page navigation, previous/next navigation, or control over page size.
- The data set is a table, list, search result set, audit log, activity feed, or admin index where stable pages are useful.
- Users may need to copy/share/bookmark a paginated URL state.

### 9.2. Do not use when:

- All records can be shown clearly in one view.
- The content is a short static list.
- The experience is intentionally infinite scroll and a Pattern owns that behavior.
- The record set is filtered down to zero results; render an empty state instead of fake page links.
- Page navigation would interrupt a multi-step task better handled by tabs, wizard steps, or route navigation.
- The view is a carousel or media gallery; use the appropriate component/pattern.
- The feature only needs a “load more” control; use a dedicated Pattern if installed or a Button with Pattern-owned behavior.
- The page needs table layout, sorting, or row interaction rules; use Data table and Table toolbar Patterns in addition to Pagination.

### 9.3. Variant selection:

| Need                                  | Use                                                                                  |
| ------------------------------------- | ------------------------------------------------------------------------------------ |
| Table-adjacent paging with range copy | `variant="pagination"`                                                               |
| Known total and direct page access    | `variant="pagination-nav"`                                                           |
| Users need to choose records per page | `showItemsPerPage` with approved `pageSizeOptions`                                   |
| First page                            | Previous disabled, next enabled when more pages exist                                |
| Last page                             | Previous enabled, next disabled                                                      |
| Large page count                      | Pagination nav with overflow menu                                                    |
| Unknown total                         | Gated unknown-total mode or pagination bar previous/next only when implementation proves it |
| Pending record reload                 | Parent Loading/Inline loading composition plus disabled pagination controls          |
| Zero results                          | Empty state, not active pagination                                                   |

## 10. Accessibility contract

- Pagination must render as a navigation landmark with an accessible label.
- Use a context-specific label when the page has more than one pagination region.
- Every interactive page, previous, next, and page-size control must have a visible or programmatic name.
- Previous and next icon-only controls must expose accessible names such as `Previous page` and `Next page`.
- Numeric page controls must expose page context, not only the number, such as `Page 3`.
- The current page must be programmatically indicated with `aria-current="page"` or equivalent component-owned markup.
- Disabled boundary controls must be programmatically disabled or removed from the tab order according to the installed control type.
- Overflow ellipses are buttons that open hidden-page menus and must have accessible names.
- Page-size controls must use native Select semantics or the installed Select API styling.
- Page-size labels must identify what the selector changes and include the colon: `Items per page:`.
- Changing page size must preserve filters and sort state and should reset to page 1 unless the Pattern states otherwise.
- Keyboard users must be able to reach and operate every active control in logical order.
- Focus-visible treatment must be visible in supported light and dark themes.
- Focus should remain predictable after navigation. For full route navigation, the page load owns focus restoration. For client-side pagination, the parent Pattern must move focus or announce updates according to the data-region contract.
- Pending reloads must be communicated through Loading or Inline loading APIs when client-side updates occur.
- Do not rely on color alone to identify current, disabled, hover, or active states.
- Text and controls must maintain contrast in supported light and dark themes.
- Responsive collapse must not remove accessible names or trap controls off-screen.

## 11. Content contract

- Use sentence case.
- Use concrete result nouns in accessible labels when possible: `Users pagination`, `Invoices pagination`, `Search results pagination`.
- Use concise range copy: `1–25 of 287`.
- Use concise current-page copy in page summaries: `3 of 12 pages`.
- Use `Items per page:` for page-size labels unless the record type needs a clearer noun, such as `Invoices per page:`.
- Use `Previous` and `Next` for visible control labels when text is shown.
- Use `Previous page` and `Next page` for accessible names when the visible control is icon-only.
- Do not use vague labels such as `Go`, `Back`, `Forward`, or `More`.
- Do not expose backend pagination terms such as offset, cursor, SQL limit, or cursor token in UI copy.
- Do not display impossible ranges such as `1–0 of 0`.
- For zero results, show empty-state copy owned by the parent Pattern, not pagination summary copy.
- Keep page-size options short and predictable.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, local focus rings, or custom JavaScript.
- Do not use Bootstrap `.pagination`, `.page-item`, or `.page-link` classes for app-owned pagination.
- Do not use direct Carbon production class names.
- Do not create local table-pagination bars.
- Do not create local page-size selectors for paginated record sets.
- Do not create local ellipsis, page-window, current-page, previous, or next logic in feature views when the component can own it.
- Do not render fake page controls for zero-result or single-page views.
- Do not replace the installed overflow menu with fake, non-navigable, or feature-local ellipsis controls.
- Do not use pagination as a visual divider or footer decoration.
- Do not pair Pagination and infinite scroll for the same record set.
- Do not rely on color alone for current, disabled, or active state.
- Do not disable controls only visually.
- Do not use feature-local JavaScript to update query strings, focus, or record regions unless a Pattern explicitly owns client-side pagination. Use the installed `initPagination` initializer for component overflow behavior and UI Reference/local examples.
- Do not truncate page-size labels or current-page summaries so far that meaning is lost.
- Do not allow pagination controls to wrap into an unreadable order on small screens.
- Do not put Pagination above the record set as the only navigation unless a Pattern explicitly proves top-and-bottom pagination.

## 13. Deferred or gated capabilities

| Capability                                   | Status                              | Gate                                                                                                           |
| -------------------------------------------- | ----------------------------------- | -------------------------------------------------------------------------------------------------------------- |
| Unknown-total/cursor pagination              | Gated                               | Requires explicit data contract, copy rules, previous/next semantics, disabled states, and UI Reference proof. |
| Jump-to-page input                           | Deferred                            | Requires Number input, validation, submit behavior, error messaging, keyboard behavior, and route-state tests. |
| First/last page controls                     | Deferred unless already implemented | Requires icon/text labels, disabled states, responsive proof, and route-state tests.                           |
| Load more mode                               | Pattern-owned / Deferred            | Requires Data list/Search results Pattern ownership; do not add to Pagination without a new mode.              |
| Infinite scroll                              | Not owned                           | Requires a dedicated Pattern with loading, focus, announcement, and footer access rules.                       |
| Client-side data pagination controller       | Pattern-owned / Deferred            | Data fetching, loading announcements, and focus movement after a data reload remain Pattern-owned.             |
| Multiple independent paginators on one route | Gated                               | Requires distinct `pageName` values, labels, query-state handling, and UI Reference proof.                     |
| Custom page-size option sets                 | Gated                               | Requires performance/design justification and Pattern-level consistency review.                                |
| Custom pagination icons                      | Not allowed                         | Requires Icons Element update and UI Reference proof.                                                          |
| Custom density or control size               | Not allowed                         | Requires Spacing, Typography, and UI Reference updates.                                                        |

Future extensions require an updated Component standard and UI Reference proof before production use.

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

The Pagination page is a data-navigation component reference. The Live examples card should use a matrix or grouped examples rather than a simple scenario-only tab model. It must render production component examples for implemented states and explicit trigger conditions for deferred or gated capabilities.

### 15.1. Required Live examples internal sections:

| Required proof                 | Rendered behavior                                                                                                                                | Variants/options shown                                                                                          |
| ------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------------------------------- |
| Pagination bar sizes           | Known-total record set renders small, medium, and large pagination bars with items-per-page, range copy, page selector, previous, and next controls. | `variant="pagination"`, `size="sm"`, `size="md"`, `size="lg"`, Focus-visible, Hover, Active, Page summary |
| Pagination nav sizes           | Page navigation renders small, medium, and large nav controls with previous/next controls, page buttons, current-page indicator, and overflow menu. | `variant="pagination-nav"`, `size="sm"`, `size="md"`, `size="lg"`, Selected page, Overflow menu, Disabled boundary |
| Page-size selector             | Page-size selector renders with label, approved option values, query-state note, and reset-to-page-1 behavior.                                   | `showItemsPerPage`, `pageSizeOptions`, Select composition, Focus-visible, Disabled                              |
| Disabled prev/next             | First-page and last-page examples show disabled previous and disabled next controls.                                                             | Disabled previous, Disabled next, Boundary states, Accessible names                                             |
| Data table size pairings       | Pairing matrix and attached table example show `xs/sm/md/lg/xl` table rows mapped to `sm/sm/md/lg/lg` pagination.                               | Connected data table, `sm`, `md`, `lg`, no direct `xs` or `xl` pagination size                                  |
| Overflow menu behavior         | Large page count renders first/last nearby pages and an ellipsis button that opens a menu for hidden pages.                                     | Overflow menu, Open menu, Scrollable menu, Current page, Window size, Hidden-page links                         |
| Empty and single-page behavior | Zero-result and one-page data examples show empty/suppressed/disabled behavior without fake page links.                                          | Empty, Single page, Disabled/hidden controls, Parent empty-state note                                           |
| Loading/skeleton handoff       | Pending record reload shows disabled pagination plus approved Loading or Inline loading composition, not local spinner markup.                   | Loading handoff, Skeleton not owned, Disabled controls                                                          |
| Small-breakpoint responsive pagination | Narrow viewport example removes select controls while preserving total/range text and previous/next controls.                            | Selects removed, Range remains, Total remains, Previous/next remain usable                                      |
| Accessibility matrix           | Page proves nav label, page labels, previous/next accessible names, `aria-current`, disabled controls, ellipsis separators, and page-size label. | Navigation landmark, `aria-current`, Accessible names, Select label                                             |
| Developer implementation       | Canonical calls and props render as real code examples.                                                                                          | `x-ui.pagination`, `variant`, `size`, `showItemsPerPage`, `pageSizeOptions`, explicit data contract             |
| Deferred capabilities          | Page documents trigger conditions instead of fake controls.                                                                                      | Unknown-total mode, Jump-to-page input, First/last controls, Load more, Infinite scroll                         |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered variants, rendered states, page-size behavior, overflow behavior, accessibility labels, prohibited usage, deferred gates, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/pagination` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The pagination bar example renders items-per-page, item range, page selector, previous, and next controls.
- The pagination nav example renders previous/next controls, page numbers, current page, overflow behavior where applicable, and selected state.
- Small, medium, and large examples exist for both pagination bar and pagination nav.
- The page-size selector example renders a labelled selector with approved page-size options and the visible label `Items per page:`.
- The page selector text renders as `[page selector] of [total page count] pages`.
- Data table size pairings are documented and demonstrated where practical.
- Boundary examples render disabled previous on the first page and disabled next on the last page.
- Overflow examples render button-triggered ellipsis menus with hidden page links/options.
- Overflow menus close after selection, outside click, and Escape, and support keyboard movement.
- Empty and single-page examples do not render fake active page links.
- Loading examples use approved Loading or Inline loading composition and do not create a local spinner.
- Responsive examples preserve focus order and accessible names.
- The small-breakpoint example removes select controls and keeps item count, item range, previous, and next readable and usable.
- Accessibility examples prove navigation label, page labels, previous/next accessible names, current-page indication, disabled controls, and page-size label.
- Developer examples use `x-ui.pagination`, not placeholder comments or ad hoc markup.
- Tests assert stale scaffold labels, placeholder pending-correction copy, legacy reference sections, old tier paths, Bootstrap pagination classes, and direct Carbon implementation class prefixes remain absent from rendered approved examples.
- No generic placeholder content appears.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/pagination');

$response->assertOk();
$response->assertSee('Pagination');
$response->assertSee('x-ui.pagination');
$response->assertSee('variant="pagination"');
$response->assertSee('variant="pagination-nav"');
$response->assertSee('showItemsPerPage');
$response->assertSee('pageSizeOptions');
$response->assertSee('Users pagination');
$response->assertSee('Previous page');
$response->assertSee('Next page');
$response->assertSee('aria-current');
$response->assertSee('Items per page:');
$response->assertSee('Overflow');
$response->assertSee('Looping nav');
$response->assertSee('Disabled previous');
$response->assertSee('Disabled next');
$response->assertSee('Loading handoff');
$response->assertSee('Do not use Bootstrap');
$response->assertDontSee('Component-specific API ' . 'pending correction');
$response->assertDontSee('Live Examples ' . 'Card');
$response->assertDontSee('Reference ' . 'Examples');
$response->assertDontSee('Legacy Contract ' . 'Summary');
$response->assertDontSee('tier' . '-1');
$response->assertDontSee('tier' . '-2');
$response->assertDontSee('cds' . '--');
$response->assertDontSee('bx' . '--');
$response->assertDontSee('pagination pagination-sm');
$response->assertDontSee('page-item');
$response->assertDontSee('page-link');
$response->assertDontSee('TODO');
$response->assertDontSee('Generic ' . 'fallback');
```

## 17. Related APIs

| API                      | Route                                                                |
| ------------------------ | -------------------------------------------------------------------- |
| Button                   | `/platform/ui-reference/components/button`                           |
| Icon button              | `/platform/ui-reference/components/button`                           |
| Link                     | `/platform/ui-reference/components/link`                             |
| Select                   | `/platform/ui-reference/components/select`                           |
| Loading                  | `/platform/ui-reference/components/loading`                          |
| Inline loading           | `/platform/ui-reference/components/inline-loading`                   |
| Data table               | `/platform/ui-reference/components/data-table`                       |
| Tables Pattern           | `/platform/ui-reference/patterns/tables`                             |
| Data list pattern        | `/platform/ui-reference/patterns/data-list`                          |
| Search results pattern   | `/platform/ui-reference/patterns/search-results`                     |
| Forms pattern            | `/platform/ui-reference/patterns/forms`                              |
| Color element            | `/platform/ui-reference/elements/color`                              |
| Spacing element          | `/platform/ui-reference/elements/spacing`                            |
| Typography element       | `/platform/ui-reference/elements/typography`                         |
| Themes element           | `/platform/ui-reference/elements/themes`                             |
| Components overview      | `/platform/ui-reference/components`                                  |
| Canonical pagination doc | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fpagination.md` |
| Carbon pagination usage  | `https://carbondesignsystem.com/components/pagination/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Pagination usage, style, and accessibility guidance inform record-set navigation scope, page-size behavior, pagination/data-table separation, current-page treatment, previous/next naming, disabled controls, overflow behavior, and accessible labelling. Login App keeps its own Blade API, Laravel-friendly data contract, `ui-*` namespace, Foundation tokens, and UI Reference proof.
