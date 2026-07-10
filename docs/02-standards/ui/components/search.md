---
title: Search
slug: search
status: implemented-pending-review
api_layer: Component API
category: Inputs
priority: Tier A - Baseline app development
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/search.md
source_owner: not installed
related_components:
  - text-input
  - button
  - data-table
  - tag
  - dropdown
related_patterns:
  - search
  - tables
  - navigation
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
  - motion
---

# Search Component API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed Search standard supports:](#31-the-installed-search-standard-supports)
- [4. Public API](#4-public-api)
  - [4.1. Props/options](#41-propsoptions)
  - [4.2. Data attributes](#42-data-attributes)
  - [4.3. CSS namespace](#43-css-namespace)
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
- [14. Implementation and Rendered Evidence Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. rendered evidence proof checklist](#142-ui-reference-proof-checklist)
- [15. Rendered evidence requirements](#15-ui-reference-requirements)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Search captures free-entry keywords for page, table, or component scope.

Canonical API owner: `not installed`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Search owns the input mechanism, icon treatment, clear action, field states, and scoped search semantics. Search does not own global search architecture, result ranking, suggestions, typeahead panels, saved searches, or table filtering logic. Those behaviors belong to Pattern APIs or feature services.

## 2. Status and ownership

| Field              | Value                                     |
| ------------------ | ----------------------------------------- |
| Status             | Approved API                              |
| API layer          | Component API                             |
| Component slug     | search                                    |
| Category           | Inputs                                    |
| Priority           | Tier A - Baseline app development         |
| Rendered evidence route | not installed  |
| Canonical doc      | docs/02-standards/ui/components/search.md |
| Source owner       | not installed  |

## 3. Installed standard

Search is the app-owned free-keyword input component for finding records, filtering visible results, or routing to a scoped result set.

### 3.1. The installed Search standard supports:

- Page search.
- Table search.
- Component-scoped search.
- Optional submit behavior.
- Optional active-change behavior.
- Clear action.
- Small, medium, and large sizes.
- Default and fluid widths.
- Expandable search.
- Disabled state.
- No-results feedback as a Pattern-owned result state.
- Helper text. Error, warning, loading, and no-results messaging belong to the owning result Pattern or data region.

Search must consume approved Foundation Elements and app-owned `ui-*` classes. Do not create local search inputs, local icon markup, local clear buttons, or feature-specific search field styling.

## 4. Public API

| API surface     | Installed value                                                                                                                  |
| --------------- | -------------------------------------------------------------------------------------------------------------------------------- |
| Blade           | `x-ui.search`                                                                                                                    |
| JavaScript      | `initSearchControls` for clear button visibility, Escape clearing, expandable behavior, and optional debounced active-change events |
| Data attributes | `data-ui-search`, `data-ui-search-input`, `data-ui-search-clear`, `data-ui-search-submit`, `data-ui-search-results-region`, `data-ui-search-expandable*` |
| Props/options   | Use the props documented in this standard                                                                                        |
| CSS namespace   | `ui-search`, `ui-search-field`, `ui-search-input`, `ui-search-icon`, `ui-search-clear`, `ui-search-expandable`, `ui-search-message` |
| Source files    | `resources/views/components/ui/search/index.blade.php`; `resources/js/ui-controls/search.js`; `resources/css/app.css`                 |

Example calls:

```blade
<x-ui.search
    name="q"
    label="Search users"
    placeholder="Search by name or email"
/>
```

```blade
<x-ui.search
    name="table_search"
    label="Search table"
    placeholder="Search records"
    scope="table"
    size="sm"
    clearable
    active
/>
```

```blade
<x-ui.search
    name="toolbar_search"
    label="Search table"
    placeholder="Search rows"
    variant="expandable"
    open-label="Open table search"
/>
```

### 4.1. Props/options

| Prop            | Type        | Default   | Allowed values                         | Notes                                                                                                                 |
| --------------- | ----------- | --------- | -------------------------------------- | --------------------------------------------------------------------------------------------------------------------- |
| `name`          | string      | required  | valid form field name                  | Submitted keyword field name.                                                                                         |
| `id`            | string/null | generated | valid id                               | Must associate the visible or hidden label with the input.                                                            |
| `label`         | string      | required  | text                                   | Required accessible name. May be visually hidden only when the surrounding context provides visible scope.            |
| `value`         | string/null | `null`    | text                                   | Current query value.                                                                                                  |
| `placeholder`   | string/null | `null`    | short hint                             | Placeholder may hint scope but must not replace the label.                                                            |
| `scope`         | string      | `page`    | `page`, `table`, `component`, `global` | Defines the search scope for content and accessibility copy. `global` is Pattern-owned unless installed by the shell. |
| `size`          | string      | `md`      | `sm`, `md`, `lg`                       | Maps to approved field heights and spacing.                                                                           |
| `variant`       | string      | `default` | `default`, `fluid`, `expandable`       | Use `fluid` when Search must fill a Pattern-owned container; use `expandable` for icon-triggered compact search.     |
| `style`         | string/null | `null`    | `default`, `fluid`, `expandable`       | Alias for `variant` when matching field API terminology.                                                            |
| `expanded`      | bool        | `false`   | `true`, `false`                        | Initial expanded state for expandable search. Filled expandable search opens by default.                             |
| `openLabel`     | string      | `Open search` | text                               | Accessible label for the collapsed expandable search trigger.                                                        |
| `collapseOnEscape` | bool     | `true`    | `true`, `false`                        | Allows Escape to collapse an empty expandable search after clearing.                                                  |
| `clearable`     | bool        | `true`    | `true`, `false`                        | Clear button appears when the input has a value.                                                                      |
| `active`        | bool        | `false`   | `true`, `false`                        | Runs change behavior as users type. Requires Pattern-owned results behavior.                                          |
| `debounce`      | int/null    | `300`     | milliseconds                           | Applies only when `active=true`.                                                                                      |
| `submit`        | bool        | `true`    | `true`, `false`                        | Submit behavior for standard form/search routes.                                                                      |
| `loading`       | bool        | `false`   | `true`, `false`                        | Compatibility only. Pending result UI belongs to the owning result Pattern or data region.                            |
| `disabled`      | bool        | `false`   | `true`, `false`                        | Uses native disabled behavior.                                                                                        |
| `readonly`      | bool        | `false`   | `true`, `false`                        | Use only to display an applied query that cannot be edited in that context.                                           |
| `readOnly`      | bool        | `false`   | `true`, `false`                        | Alias for `readonly`.                                                                                                 |
| `helper`        | string/null | `null`    | text                                   | Short guidance below the field.                                                                                       |
| `helperText`    | string/null | `null`    | text                                   | Alias for `helper`.                                                                                                   |
| `error` / `invalid` / `invalidText` | compatibility only | ignored | none | Error/invalid states are not Search states. Use the owning results Pattern for failed-request or empty-result messaging. |
| `warning` / `warn` / `warnText` | compatibility only | ignored | none | Warning states are not Search states. Do not render warning copy as Search field anatomy. |
| `resultsRegion` | string/null | `null`    | valid id                               | Region updated by search results; required for active async results.                                                  |
| `clearLabel`    | string      | `Clear search` | text                              | Accessible label for the clear button.                                                                                |
| `showLabel`     | bool        | `false`   | `true`, `false`                        | Shows the label for default search when surrounding context does not visually identify scope.                         |
| `attributes`    | array       | `[]`      | HTML attributes                        | Escape values and avoid local styling hooks.                                                                          |

### 4.2. Data attributes

| Attribute                       | Owner                      | Purpose                                                     |
| ------------------------------- | -------------------------- | ----------------------------------------------------------- |
| `data-ui-search`                | Root                       | Search component initialization target.                     |
| `data-ui-search-input`          | Input                      | Query field.                                                |
| `data-ui-search-clear`          | Clear button               | Clears the current query.                                   |
| `data-ui-search-submit`         | Submit button, if rendered | Submits the query explicitly.                               |
| `data-ui-search-results-region` | Root or input              | Associates the search field with an updated results region. |
| `data-ui-search-loading`        | Root                       | Compatibility marker only; result loading UI is Pattern-owned. |
| `data-ui-search-scope`          | Root                       | Documents page, table, component, or global scope.          |
| `data-ui-search-expandable`     | Root                       | Identifies expandable search behavior.                      |
| `data-ui-search-expanded`       | Root                       | Stores current expanded state for expandable search.         |
| `data-ui-search-expandable-trigger` | Button                  | Icon-only trigger that opens collapsed expandable search.    |

### 4.3. CSS namespace

Use only the app-owned Search namespace:

```css
.ui-search
.ui-search-field
.ui-search-input
.ui-search-icon
.ui-search-clear
.ui-search-submit
.ui-search-message
.ui-search-helper
.ui-search-fluid
.ui-search-expandable
.ui-search-expandable-trigger
.ui-search-sm
.ui-search-md
.ui-search-lg
```

Do not use direct Carbon production classes such as `cds--search` or `bx--search`.

## 5. Allowed variants, options, and modifiers

Search does not use decorative variants. It has installed usage scopes, sizes, state options, and behavior modifiers.

| Name                   | Type         | Status                   | API                                 | Use when                                                                                  |
| ---------------------- | ------------ | ------------------------ | ----------------------------------- | ----------------------------------------------------------------------------------------- |
| Page search            | Scope        | Implemented              | `scope="page"`                      | Searching content on the current page or routing to a page-level result set.              |
| Table search           | Scope        | Implemented              | `scope="table"`                     | Filtering or searching data in a table region. Table toolbar placement is Pattern-owned.  |
| Component search       | Scope        | Implemented              | `scope="component"`                 | Searching within a bounded component or panel.                                            |
| Global search          | Scope        | Gated / Pattern-owned    | `scope="global"`                    | Only when the app shell owns global search placement and routing.                         |
| Default width          | Variant      | Implemented              | `variant="default"`                 | Search uses content-fit or configured width.                                              |
| Fluid width            | Variant      | Implemented              | `variant="fluid"`                   | Search fills its parent region. Parent Pattern owns the layout width.                     |
| Expandable search      | Variant      | Implemented              | `variant="expandable"`              | Search can collapse to an icon-only trigger and expand into a focused field.              |
| Small                  | Size         | Implemented              | `size="sm"`                         | Dense table toolbar, compact cards, or utility surfaces.                                  |
| Medium                 | Size         | Implemented              | `size="md"`                         | Default app search field.                                                                 |
| Large                  | Size         | Implemented              | `size="lg"`                         | High-emphasis page search.                                                                |
| Clearable              | Modifier     | Implemented              | `clearable`                         | Users can remove the query with a clear button or Escape.                                 |
| Submit search          | Behavior     | Implemented              | `submit=true`                       | Search runs on form submission or Enter.                                                  |
| Active search          | Behavior     | Gated / Pattern-owned    | `active=true`                       | Results update as users type. Requires debounce, result status, and no-results behavior.  |
| No results             | Result state | Pattern-owned            | `resultsRegion` plus result message | The Search field may trigger this, but the results Pattern owns the rendered empty state. |
| Suggestions/typeahead  | Capability   | Deferred                 | none approved                       | Requires Pattern-owned result panel, keyboard behavior, and result navigation.            |
| Scoped filter selector | Composition  | Deferred / Pattern-owned | none approved                       | Requires Search Pattern and Filter Pattern ownership.                                     |
| AI-assisted search     | Capability   | Not implemented          | none approved                       | Requires approved AI feature, disclosure, explainability, and result trust contract.      |

## 6. States

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

| State           | Status         | Implementation requirement                                                                                           |
| --------------- | -------------- | -------------------------------------------------------------------------------------------------------------------- |
| Default         | Implemented    | Empty or prefilled input with search icon and accessible label.                                                      |
| Hover-capable   | Implemented    | Hover styling applies only to pointer-capable interactive affordances.                                               |
| Focus-visible   | Implemented    | Input and clear/submit controls show token-backed visible focus.                                                     |
| Active / filled | Implemented    | Entered query remains visible until submitted, changed, or cleared.                                                  |
| Clear available | Implemented    | Clear button appears only when the input has a value.                                                                |
| Clear pressed   | Implemented    | Clear button removes the value and returns focus according to component behavior.                                    |
| Disabled        | Implemented    | Native disabled input/control behavior.                                                                              |
| Expandable collapsed | Implemented | Icon-only trigger has an accessible name and opens the search field.                                                  |
| Expandable expanded | Implemented | Expanded input receives focus, preserves accessible labeling, and supports clear/Escape behavior.                      |
| Helper          | Implemented    | Short search scope or format guidance below the field.                                                               |
| Error           | Not applicable | Do not render invalid text, error icons, or validation spacing as Search anatomy.                                    |
| Warning         | Not applicable | Do not render warning text, warning icons, or validation spacing as Search anatomy.                                  |
| No results      | Pattern-owned  | Result region owns the no-results message and next-step guidance.                                                    |
| Success         | Not applicable | Search does not use success styling for ordinary results.                                                            |
| Empty           | Pattern-owned  | Empty result state belongs to the result list/table/pattern, not the field alone.                                    |

## 7. Token, class, and helper usage

Search consumes Foundation Element APIs through app-owned classes.

### 7.1. Foundation Elements consumed:

- Color
- Spacing
- Typography
- Themes
- Icons
- Motion, when active search, expandable search, or suggestion/result panels are implemented
- 2x Grid, when Search is placed in page headers, table toolbars, or responsive layouts

| Element API | Allowed usage                                                                                          |
| ----------- | ------------------------------------------------------------------------------------------------------ |
| Color       | Field, text, helper, placeholder, icon, focus, filled, and disabled tokens.                            |
| Spacing     | Field padding, icon spacing, clear-button spacing, helper spacing, and toolbar composition gaps.       |
| Typography  | Label, input text, helper text, and result-count messaging.                                           |
| Themes      | Search must remain readable in supported light, dark, inline, inverse, and high-contrast contexts.     |
| Icons       | Magnifying glass icon and clear icon use approved icon rules.                                          |
| Motion      | Loading and optional result-panel transitions must respect reduced-motion preferences.                 |
| 2x Grid     | Parent Patterns own alignment and width in headers, toolbars, and shells.                              |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$field` | Search field background | `ui-search-field`, `ui-search-input`, `--ui-field` | App field palette | Same role / app value | Shared field mapping with Text input, Select, and Dropdown. |
| `$border-strong` | Search field border-bottom | Search field border role | App border palette | Same role / app value | Do not style search borders locally. |
| `$text-primary`, `$text-placeholder`, `$text-disabled` | Filled value, placeholder, and disabled text | Search input text roles | App text palette | Same role / app value | Text roles follow Color/Typography standards. |
| `$icon-secondary`, `$icon-primary` | Search icon and clear icon | `ui-search-icon`, `ui-search-clear` | App icon palette | Same role / app value | Icons inherit currentColor from component state. |
| `$focus` | Focus field border/ring | `ui-search-field:focus-within`, `--ui-focus` | App focus palette | Same role / app value | Focus covers the full interactive control, including fluid search. |

Allowed helper classes and APIs:

```css
.ui-search
.ui-search-field
.ui-search-input
.ui-search-icon
.ui-search-clear
.ui-search-message
.ui-search-fluid
.ui-search-expandable
.ui-search-expandable-trigger
```

```blade
<x-ui.search ... />
```

Do not place raw SVG icons, feature-local spacing utilities, raw colors, or one-off clear-button scripts inside feature views.

## 8. Composition rules

- Use native search/input semantics first.
- Search owns the field, icon, clear action, expandable trigger, enabled/focus/filled/disabled states, helper text, and accessible labels.
- Parent Patterns own external spacing, toolbar placement, result layout, filter chips, suggestions panels, result counts, no-results empty states, and search routing.
- `Enter` submits the query when submit behavior is enabled.
- `Escape` clears the query when a query exists and the component is clearable.
- The clear button removes the query and must be keyboard reachable when visible.
- Active search must use debounce and must not issue unbounded network requests on every keystroke without a Pattern-owned performance contract.
- Search must not create horizontal overflow in table toolbars, page headers, or responsive surfaces.
- Search hover must not introduce a visible field background or border-color state; pointer hover over the editable field may only use the text-entry cursor.
- Fluid search must render as a distinct 64px field treatment with reserved right-side icon/control space and no icon overlap with the placeholder or entered value.
- A search field in a Data table toolbar must be composed by the table toolbar Pattern; the Search component does not own toolbar grouping.
- Failed search requests, warning messages, loading status, and no-results states belong to the owning results Pattern or data region, not Search field validation anatomy.
- Motion and state changes must use approved Foundation Motion and respect reduced-motion preferences where applicable.

Components own internal semantics and styling. Parent Patterns own grouping, external spacing, workflow orchestration, result rendering, and page-level layout.

## 9. Selection guidance

### 9.1. Use when:

- Users need to enter free keywords to find page, table, or component content.
- A page or dataset is large enough that scanning visible content is inefficient.
- A table, list, card grid, or catalog needs keyword narrowing.
- Users already know what they are looking for and can describe it with text.
- A route-level search should submit a query to a results page or scoped result region.

### 9.2. Do not use when:

- The user must choose from a short fixed set; use Select, Dropdown, Radio button, Checkbox, or Multiselect.
- The user is entering ordinary form data; use Text input.
- The UI is filtering by structured attributes only; use filter controls or a table toolbar Pattern.
- There is a small amount of content that is already visible in one view.
- Search suggestions, recent searches, typeahead results, or result panels are needed but no Pattern-owned API exists.
- The search field would replace clear navigation, category browsing, or visible table filters.

### 9.3. Selection boundaries:

| Need                                 | Use                                  |
| ------------------------------------ | ------------------------------------ |
| Free keyword query                   | Search                               |
| Ordinary single-line text value      | Text input                           |
| Short native option choice           | Select                               |
| Custom single known-option selection | Dropdown                             |
| Multiple visible choices             | Checkbox group                       |
| Multiple known options in compact UI | Multiselect, deferred until approved |
| Action menu                          | Menu buttons                         |
| Table query plus filters             | Table toolbar Pattern                |
| Result page behavior                 | Search Pattern                       |

## 10. Accessibility contract

- Search input must have an accessible name. A visible label is preferred; visually hidden labels are allowed only when surrounding UI clearly identifies the search scope.
- Use native `<input type="search">` or equivalent text input semantics.
- Use `role="search"` on the wrapping search region when it helps identify a distinct search area.
- `Enter` submits the query when submit behavior is installed.
- `Escape` clears the query when a value exists and clear behavior is installed.
- The clear button must be keyboard reachable when visible and must have an accessible name such as `Clear search`.
- Loading or active async result updates must announce meaningful status through the result Pattern or an associated status region.
- No-results messaging must be accessible in the result region and must not rely on color alone.
- Search icons are decorative unless they operate as a button.
- Icon-only submit or reveal controls require accessible labels and visible focus.
- Do not rely on placeholder text as the only label.
- Maintain contrast in supported light and dark themes.
- If suggestions or typeahead are added later, keyboard navigation, focus management, active descendant behavior, and result announcement must be documented before implementation.

## 11. Content contract

- Labels must name the search scope, such as `Search users`, `Search audit events`, or `Search table`.
- Placeholder text may hint what users can search for, such as `Search by name or email`.
- Placeholder text must stay short and must not replace the label.
- Use sentence case.
- Clear button accessible text should be direct, such as `Clear search`.
- Loading copy should identify what is pending, such as `Searching users`.
- No-results copy belongs to the result Pattern and should include a next step, such as clearing the search or checking spelling.
- Failed-search copy belongs to the owning results Pattern and should distinguish failed requests from empty results.
- Do not use vague labels such as `Search` alone when the page has multiple search fields or ambiguous scope.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not use Search for ordinary text input.
- Do not use Search for action menus, known-option selection, or structured filters.
- Do not rely on placeholder text as the only label.
- Do not hide a required search label when the surrounding context does not clearly identify the scope.
- Do not fake typeahead, suggestions, recent searches, or result panels without a Pattern-owned Search API.
- Do not use custom field chrome when the installed Search control satisfies the workflow.
- Do not create local clear-button behavior.
- Do not issue unbounded active-search network requests without debounce, status, and result handling.
- Do not use direct Carbon production classes such as `cds--search` or `bx--search`.

## 13. Deferred or gated capabilities

| Capability                  | Status                   | Gate                                                                                                        |
| --------------------------- | ------------------------ | ----------------------------------------------------------------------------------------------------------- |
| Global shell search         | Pattern-owned / gated    | Requires UI Shell or Global Search Pattern ownership, routing, shortcut behavior, and result page contract. |
| Active search results panel | Gated                    | Requires debounce, async status, keyboard navigation, no-results behavior, and result ownership.            |
| Focused search              | Deferred                 | Requires scoped result strategy and widened-search behavior.                                                |
| Search suggestions          | Deferred                 | Requires suggestion source, keyboard navigation, active option semantics, and result announcement.          |
| Recent searches             | Deferred                 | Requires privacy/storage policy and clear/remove behavior.                                                  |
| Typeahead/autocomplete      | Deferred                 | Requires accessible suggestion pattern and focus management.                                                |
| Scope filter inside search  | Deferred / Pattern-owned | Requires Search Pattern and Filter Pattern ownership.                                                       |
| AI-assisted search          | Not implemented          | Requires approved AI feature, explainability, trust, and result-disclosure standard.                        |
| Voice search                | Not implemented          | Requires input permission, privacy, and accessibility review.                                               |

## 14. Implementation and Rendered Evidence Checklist
### 14.1. Implementation checklist
| Requirement                | Standard expectation                                                                                                                               |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source          | The standard names the canonical Blade component, native/class API, JavaScript controller, CSS namespace, source files, or explicit deferred gate. |
| Variants/options/modifiers | Approved variants, options, sizes, density, layout modifiers, and deferred gates are listed.                                                       |
| States                     | Default, hover, focus-visible, active/pressed, filled, disabled, expandable, and not-applicable states are defined as relevant.                    |
| Accessibility/content      | Keyboard, focus, naming, ARIA, contrast, reduced-motion, label, helper, and copy requirements are defined.                                         |
| Element consumption        | Required Color, Spacing, Typography, Icons, Motion, Themes, and 2x Grid dependencies are named.                                                    |
| Tests                      | Source/API assertions and Rendered evidence route assertions block generic fallback content.                                                            |

### 14.2. rendered evidence proof checklist
| Requirement               | Visual proof expectation                                                                              |
| ------------------------- | ----------------------------------------------------------------------------------------------------- |
| Live examples             | The page renders production examples through the documented API or explicit native/class contract.    |
| Rendered variants/options | Every applicable supported variant, option, size, modifier, or deferred trigger condition is shown.   |
| Rendered states           | Required states are shown visually and with accessibility markers where relevant.                     |
| Developer implementation  | Real canonical calls and token-backed code snippets appear instead of placeholder comments.           |
| Related APIs              | Nearby Components, owning Patterns, consumed Elements, source files, and canonical docs are linked.   |
| Manual review             | The page provides enough rendered proof for visual review of behavior, layout, and state correctness. |
## 15. Rendered evidence requirements

The rendered evidence page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

The Live examples section may use grouped examples, state tables, or matrix sections rather than tabs if that better represents Search. Search examples must render production app markup rather than screenshots or fake controls.

| Required proof              | Rendered behavior                                                                                                  | Variants/options shown                                                  |
| --------------------------- | ------------------------------------------------------------------------------------------------------------------ | ----------------------------------------------------------------------- |
| Variants                    | Default, fluid, and expandable search render through the installed API.                                             | `variant="default"`, `variant="fluid"`, `variant="expandable"`          |
| Fluid search                | Standalone fluid search and filled fluid search render as 64px fields with correct icon/control reservation.        | `variant="fluid"`, Empty, Filled                                        |
| Expandable search behavior  | Collapsed icon-only trigger opens the search field, focuses the input, shows clear control when filled, and supports Escape clear/collapse. | Collapsed, expanded, filled, clear, toolbar placement                    |
| Sizing                      | Default small, medium, and large search examples plus separate fluid 64px example render with clear labels.        | `size="sm"`, `size="md"`, `size="lg"`, `variant="fluid"`                |
| States                      | Enabled, focus, filled, and disabled are shown as the only Search-owned states.                                    | Enabled, Focus, Filled, Disabled                                        |
| Context examples            | Global, page-level, component-level, and table-toolbar search contexts are shown without owning result rendering.   | `scope="global"`, `scope="page"`, `scope="component"`, `scope="table"`  |
| Search vs related APIs      | Demonstrates the boundary between Search, Text input, Select, Dropdown, Filter Pattern, and Table toolbar Pattern. | Related API comparison                                                  |
| Deferred/gated capabilities | Shows trigger conditions for suggestions, typeahead, active result panels, focused search, result panels, and AI-assisted search. | Deferred, gated, Pattern-owned                                      |

## 16. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page uses the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The page documents and renders `x-ui.search`.
- The page shows default search, fluid search, expandable search, sizing, enabled/focus/filled/disabled states, context examples, and clear behavior.
- The page shows a standalone fluid search section distinct from the sizing matrix.
- The page distinguishes Search from Text input, Select, Dropdown, Filter Pattern, and Table toolbar Pattern.
- Clear action examples include a keyboard-reachable clear button with an accessible name.
- Expandable search examples include collapsed, expanded, filled, clear, keyboard focus, and toolbar placement behavior.
- Fluid search examples show the 64px unified control, full-control focus boundary, right-side search icon placement, and reserved icon spacing.
- Hover on Search does not visibly change field background or border color.
- Error and warning examples are not rendered or documented as Search states.
- Active search, typeahead, suggestions, recent searches, focused search, global shell search, and AI-assisted search are not rendered as production controls unless their Pattern/API gates are completed.
- No generic fallback text appears.
- No placeholder API text appears.
- No deprecated tiered docs paths appear.

### 16.1. Suggested automated assertions:

```php
$response->assertOk();
$response->assertSee('x-ui.search');
$response->assertSee('data-ui-search');
$response->assertSee('Variants');
$response->assertSee('Expandable search behavior');
$response->assertSee('Sizing');
$response->assertSee('States');
$response->assertSee('Context examples');
$response->assertSee('Search vs related APIs');
$response->assertSee('Text input');
$response->assertSee('Dropdown');
$response->assertSee('Table toolbar Pattern');
$response->assertDontSee('Validation search');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Allowed variants, options, and modifiers</h2><ul><li>None</li></ul>', false);
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--search');
$response->assertDontSee('bx--search');
```

## 17. Related APIs

| API                | Route                                        |
| ------------------ | -------------------------------------------- |
| Text input         | not installed |
| Select             | not installed     |
| Dropdown           | not installed   |
| Data table         | not installed |
| Button             | not installed     |
| Icon               | not installed        |
| Tables Pattern     | not installed       |
| Search pattern     | not installed       |
| Navigation Pattern | not installed   |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- [Carbon Search usage](https://carbondesignsystem.com/components/search/usage/)
- [Carbon Search style](https://carbondesignsystem.com/components/search/style/)
- [Carbon Search accessibility](https://carbondesignsystem.com/components/search/accessibility/)
- [Carbon Search pattern](https://carbondesignsystem.com/patterns/search-pattern/)

Carbon Search informs the field anatomy, clear action, sizing, keyboard behavior, and search-pattern boundaries. Login App keeps its own Blade API, CSS namespace, result ownership, and Pattern gates.
