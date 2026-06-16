---
title: List
slug: list
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: data-display
priority: tier-b-common-reusable-component
ui_reference_route: /platform/ui-reference/components/list
canonical_doc: docs/02-standards/ui/components/list.md
source_owner: /platform/ui-reference/components/list
blade_api: []
native_api:
  - ul
  - ol
  - li
javascript_api: []
source_files:
  - resources/css/app.css
  - route-owned UI Reference view for /platform/ui-reference/components/list
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - 2x-grid
related_components:
  - link
  - data-table
  - structured-list
  - contained-list
  - tile
  - code-snippet
  - loading
  - inline-loading
related_patterns:
  - forms
  - layout
carbon_reference:
  - https://carbondesignsystem.com/components/list/usage/
  - https://carbondesignsystem.com/components/list/style/
  - https://carbondesignsystem.com/components/list/code/
  - https://carbondesignsystem.com/components/list/accessibility/
---

# List Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Markup and class contract](#43-markup-and-class-contract)
  - [4.4. Variant contract](#44-variant-contract)
  - [4.5. Density contract](#45-density-contract)
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
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. UI Reference proof checklist](#142-ui-reference-proof-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

List presents ordered or unordered body content as a vertical, scannable group.

Canonical API owner: `/platform/ui-reference/components/list`. Use this Component API instead of creating local markup, styling, density, marker behavior, or body-content list variants for the same UI role.

List is the installed Login App 2.0 body-list API. It owns native list semantics, ordered and unordered variants, marker styling, item spacing, compact density, nested hierarchy spacing, long-content wrapping, empty/loading presentation for data-backed lists, current/focus treatment when items contain approved interactive children, and token-backed typography/color behavior. It does not own table structure, sortable data, selection controls, navigation menus, tree navigation, contained row actions, or page-level layout.

### 1.1. Canonical API responsibilities:

- Render simple related body content through native `<ul>`, `<ol>`, and `<li>` elements.
- Apply the app-owned `ui-list` class namespace for marker, density, spacing, wrapping, state, and theme behavior.
- Use unordered lists for peer items that do not depend on sequence.
- Use ordered lists for instructions, ordered priority, ranked content, or any sequence where item position changes meaning.
- Preserve readable vertical layout and marker alignment across supported themes and responsive widths.
- Support standard and compact density through documented classes only.
- Support nested lists only for simple hierarchy where two visible levels are enough to understand the content.
- Keep interactive children owned by their own Component APIs, such as Link, Button, Checkbox, or Toggle.
- Consume Foundation Element APIs for color, spacing, typography, themes, and 2x Grid where placement is relevant.
- Prove ordered, unordered, nested, content-only, density, loading, empty, current/focus, overflow, responsive, and developer implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Complex tabular data, sorting, filtering, column alignment, or row selection. Use Data table.
- Label/value row comparison. Use Structured list when that API is installed for the needed structure.
- Bordered or container-owned item groups. Use Contained list only when its deferred/gated API is accepted and proved.
- Clickable cards or dashboard surfaces. Use Tile.
- Application navigation, menu behavior, or shell hierarchy. Use Breadcrumb, Tabs, Menu, Menu buttons, or UI shell as appropriate.
- Expandable/collapsible hierarchy. Use Accordion or Tree view when the approved component owns the behavior.
- External spacing, page columns, and section placement. Parent Patterns own layout.

Carbon alignment note: Carbon treats List as related vertical content with unordered and ordered variants, native list semantics, nested hierarchy, vertical alignment, wrapping long content, and no component-level keyboard behavior unless list items contain interactive controls. Login App maps those completeness principles to native Blade markup and app-owned `ui-*` classes rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                               |
| ---------------------------- | --------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                        |
| System maturity              | Partial                                                                                             |
| API layer                    | Component API                                                                                       |
| Component slug               | `list`                                                                                              |
| Category                     | Data display                                                                                        |
| Priority                     | Tier B - Common reusable component                                                                  |
| UI Reference route           | `/platform/ui-reference/components/list`                                                            |
| Canonical doc                | `docs/02-standards/ui/components/list.md`                                                           |
| Source owner                 | `/platform/ui-reference/components/list`                                                            |
| Blade API                    | No dedicated `x-ui.list` Blade component is documented as installed                                 |
| Native API                   | `<ul>`; `<ol>`; `<li>`                                                                              |
| JavaScript API               | None required for baseline list behavior                                                            |
| Source files                 | `resources/css/app.css`; route-owned UI Reference view for `/platform/ui-reference/components/list` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, 2x Grid where list placement is relevant                        |
| Carbon benchmark             | Carbon List usage, style, code, and accessibility guidance                                          |

`Approved API` means the installed route and examples exist, but the canonical standard, UI Reference proof, and tests must be corrected so List is documented as a native semantic body-content component with explicit variants, density, states, and composition boundaries instead of placeholder API text.

## 3. Installed standard

List is represented by native semantic elements and app-owned classes. Do not invent a Blade component call unless a later accepted queue item installs and documents one.

### The installed standard is:

- Render unordered content with `<ul class="ui-list ui-list-unordered">`.
- Render ordered content with `<ol class="ui-list ui-list-ordered">`.
- Render every item as a direct `<li>` child of the current list.
- Use `.ui-list` as the required root class for app-owned marker, spacing, typography, wrapping, and theme behavior.
- Use `.ui-list-compact` only when the surrounding Pattern explicitly needs denser body content.
- Use nested native lists inside the parent `<li>` when hierarchy is required.
- Keep nested hierarchy shallow. Two visible levels are the installed boundary for component proof.
- Use en dash markers for level 1 unordered list items and square markers for level 2 unordered list items.
- Use numbers for level 1 ordered list items and letters for level 2 ordered list items.
- Keep markers top-aligned with the first line of wrapped item text.
- Keep markers visible for body-content lists unless an approved Pattern owns a different semantic structure.
- Let long list item content wrap under the item text area while preserving readable marker alignment.
- Use empty-state copy instead of rendering an empty `<ul>` or `<ol>`.
- Use skeleton rows or Inline loading/Loading composition for data-backed loading states.
- Use `aria-current` only on an interactive child when a list item represents the current page, step, or context.
- Do not use `aria-selected`, `role="listbox"`, `role="menu"`, or `role="tree"` on the baseline List API.
- Do not create local marker icons, local row-hover styles, local borders, or local density classes.
- Parent Patterns own external spacing, column layout, section headings, empty-state placement, and workflow orchestration.

## 4. Public API

### 4.1. Canonical calls

Unordered body list:

```blade
<ul class="ui-list ui-list-unordered">
    <li>Confirm the workspace owner.</li>
    <li>Review the invited administrators.</li>
    <li>Save the access changes.</li>
</ul>
```

Ordered sequence:

```blade
<ol class="ui-list ui-list-ordered">
    <li>Create the workspace.</li>
    <li>Invite the first administrator.</li>
    <li>Confirm billing details.</li>
</ol>
```

Compact list:

```blade
<ul class="ui-list ui-list-unordered ui-list-compact">
    <li>Updated tenant status</li>
    <li>Synced owner permissions</li>
    <li>Queued audit export</li>
</ul>
```

Nested list:

```blade
<ul class="ui-list ui-list-unordered">
    <li>
        Workspace requirements
        <ul class="ui-list ui-list-unordered ui-list-nested">
            <li>Owner email is verified.</li>
            <li>At least one administrator is active.</li>
        </ul>
    </li>
    <li>Billing contact is complete.</li>
</ul>
```

Nested ordered list:

```blade
<ol class="ui-list ui-list-ordered">
    <li>Review tenant identity.</li>
    <li>
        Confirm routing policy.
        <ol class="ui-list ui-list-ordered ui-list-nested">
            <li>Verify the primary domain.</li>
            <li>Confirm the fallback route.</li>
        </ol>
    </li>
    <li>Save the configuration.</li>
</ol>
```

Current link item:

```blade
<ul class="ui-list ui-list-unordered">
    <li>
        <a class="ui-link" href="/settings/profile" aria-current="page">
            Profile settings
        </a>
    </li>
    <li>
        <a class="ui-link" href="/settings/security">
            Security settings
        </a>
    </li>
</ul>
```

Use the native API and `ui-list` classes instead of hand-building marker, spacing, typography, or state styles in feature views.

### 4.2. API surfaces

| API surface         | Installed value                                                                           |
| ------------------- | ----------------------------------------------------------------------------------------- |
| Blade component     | No dedicated `x-ui.list` helper is documented as installed                                |
| Root native element | `<ul>` for unordered lists; `<ol>` for ordered lists                                      |
| Item native element | `<li>` as a direct child of the active list                                               |
| JavaScript          | No dedicated JavaScript controller required                                               |
| Data attributes     | No public data attributes for baseline List behavior                                      |
| CSS namespace       | App-owned `ui-list*` classes documented by this standard and the component implementation |
| Source owner        | `/platform/ui-reference/components/list`                                                  |
| Token ownership     | Foundation Color, Spacing, Typography, Themes, and 2x Grid where composed in layouts      |

### 4.3. Markup and class contract

| API                  | Type                          | Status                       | Required                       | Notes                                                                                         |
| -------------------- | ----------------------------- | ---------------------------- | ------------------------------ | --------------------------------------------------------------------------------------------- |
| `<ul>`               | Native element                | Implemented                  | Required for unordered variant | Use when item order does not change meaning.                                                  |
| `<ol>`               | Native element                | Implemented                  | Required for ordered variant   | Use when sequence, rank, or instruction order changes meaning.                                |
| `<li>`               | Native element                | Implemented                  | Required for every item        | Do not replace with `div`, `span`, or button-like wrappers.                                   |
| `.ui-list`           | Root class                    | Implemented                  | Required                       | Base marker, spacing, typography, wrapping, and theme contract.                               |
| `.ui-list-unordered` | Variant class                 | Implemented                  | Required on unordered root     | Applies unordered marker contract.                                                            |
| `.ui-list-ordered`   | Variant class                 | Implemented                  | Required on ordered root       | Applies ordered marker and number alignment contract.                                         |
| `.ui-list-compact`   | Density modifier              | Implemented                  | Optional                       | Use only for dense supporting content, not long reading content.                              |
| `.ui-list-nested`    | Nested modifier               | Implemented / required proof | Optional                       | Use on child lists where the implementation requires nested spacing.                          |
| `.ui-list-empty`     | Empty state class             | Implemented / required proof | Optional                       | Use for visible empty-state message, not for hiding an empty list.                            |
| `.ui-list-skeleton`  | Loading state class           | Implemented / required proof | Optional                       | Use only for data-backed loading rows. Pair with screen-reader loading text.                  |
| `.ui-list-current`   | Current state class           | Implemented                  | required proof                 | Optional / Visual companion to `aria-current` on the interactive child.                       |
| `.ui-list-disabled`  | Disabled state class          | Implemented / required proof | Optional                       | Visual state only. Disabled semantics must come from the child Component API.                 |
| `start`              | Native ordered-list attribute | Implemented                  | Optional                       | Use only when an ordered sequence continues from a prior sequence.                            |
| `reversed`           | Native ordered-list attribute | Gated                        | Optional                       | Requires UI Reference proof before production use because number order affects comprehension. |
| `type`               | Native ordered-list attribute | Not public                   | No                             | Marker style is owned by the component CSS contract, not feature views.                       |
| `role`               | ARIA                          | Not needed by default        | No                             | Use native list semantics. Add ARIA only if a documented CSS change removes native semantics. |

Any class, attribute, or behavior not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.4. Variant contract

| Variant      | Status                       | API                                                  | Use when                                                                   | Do not use when                                                          |
| ------------ | ---------------------------- | ---------------------------------------------------- | -------------------------------------------------------------------------- | ------------------------------------------------------------------------ |
| Unordered    | Implemented                  | `<ul class="ui-list ui-list-unordered">`             | Items are peers, attributes, requirements, notes, or body-content bullets. | The sequence, rank, or step number changes meaning.                      |
| Ordered      | Implemented                  | `<ol class="ui-list ui-list-ordered">`               | Items are steps, ranking, priority, or ordered instructions.               | Items are equal-priority peers.                                          |
| Nested       | Implemented / required proof | Child `<ul>` or `<ol>` inside a parent `<li>`        | A simple second-level hierarchy clarifies the parent item.                 | The content needs disclosure, deep hierarchy, or keyboard tree behavior. |
| Content-only | Implemented                  | Native list with text and optional inline components | The list supports body copy, requirements, summaries, or instructions.     | The list is a navigation menu, action menu, or selectable data grid.     |

### 4.5. Density contract

| Density  | Status                       | API                                   | Use when                                                                                                 | Do not use when                                                                 |
| -------- | ---------------------------- | ------------------------------------- | -------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------- |
| Standard | Implemented                  | `.ui-list` without `.ui-list-compact` | Default body content, instructions, summaries, and help text.                                            | A dense adjacent control group requires tighter supporting text.                |
| Compact  | Implemented / required proof | `.ui-list-compact`                    | Short supporting lists inside cards, metadata panels, table-adjacent summaries, or dense admin surfaces. | Long reading content, instructional flows, or nested lists with long item text. |

## 5. Allowed variants, options, and modifiers

| Name                        | Type          | Status                        | API                                                           | Notes                                                                     |
| --------------------------- | ------------- | ----------------------------- | ------------------------------------------------------------- | ------------------------------------------------------------------------- |
| Unordered list              | Variant       | Implemented                   | `<ul class="ui-list ui-list-unordered">`                      | Peer items without required order.                                        |
| Ordered list                | Variant       | Implemented                   | `<ol class="ui-list ui-list-ordered">`                        | Sequential, ranked, or instruction content.                               |
| Standard density            | Density       | Implemented                   | `.ui-list`                                                    | Default list density.                                                     |
| Compact density             | Density       | Implemented / required proof  | `.ui-list-compact`                                            | Dense supporting content only.                                            |
| Nested boundary             | Composition   | Implemented / required proof  | Child list inside `<li>`                                      | Simple second-level hierarchy.                                            |
| Content-only list           | Composition   | Implemented                   | Text and inline child components inside `<li>`                | Default content model for body lists.                                     |
| Link list item              | Composition   | Implemented                   | `li > a.ui-link` or Link Component output                     | Link owns interaction and focus. List owns item spacing.                  |
| Current item                | State         | Implemented / required proof  | `aria-current` on child link plus optional `.ui-list-current` | Current is not selection.                                                 |
| Disabled item               | State         | Implemented / required proof  | Child disabled API plus optional `.ui-list-disabled`          | Static unavailable text should usually be omitted or explained.           |
| Empty state                 | State         | Implemented / required proof  | `.ui-list-empty` visible message                              | Do not render empty list markup as the only state.                        |
| Loading/skeleton            | State         | Implemented / required proof  | `.ui-list-skeleton` or Loading/Inline loading composition     | Use only while data-backed list content is pending.                       |
| Two-digit ordered alignment | Modifier      | Implemented / required proof  | Component-owned ordered-list CSS                              | Keeps 10+ item markers readable without feature-local CSS.                |
| Reversed ordering           | Native option | Gated                         | `reversed`                                                    | Requires specific UI Reference proof before use.                          |
| Custom marker icons         | Modifier      | Not allowed                   | none                                                          | List does not expose an icon marker API.                                  |
| Selectable list             | Mode          | Not owned by List             | none                                                          | Use Checkbox, Radio button, Data table, or a Pattern-owned selection API. |
| Interactive tree            | Mode          | Deferred / separate component | none                                                          | Use Tree view only when its API is accepted and proved.                   |
| Bordered contained rows     | Mode          | Deferred / separate component | none                                                          | Use Contained list only when its API is accepted and proved.              |
| Horizontal item layout      | Modifier      | Not allowed for body lists    | none                                                          | Separate lists may sit in grid columns, but items stay vertical.          |

## 6. States

| State              | Status                                          | Implementation requirement                                                                                                   |
| ------------------ | ----------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------- |
| Default            | Implemented                                     | Renders native list semantics, approved marker style, body typography, item spacing, and wrapping.                           |
| Hover              | Not owned by static List                        | Static list items do not hover. If an item contains Link or Button, that child Component owns hover treatment.               |
| Focus-visible      | Implemented through interactive children        | Root lists are not focusable. Links, buttons, or controls inside items must show token-backed focus-visible treatment.       |
| Active/pressed     | Not owned by static List                        | Child Components own active/pressed behavior. Do not add list-level pressed styling.                                         |
| Current            | Implemented / required proof                    | Use `aria-current` on the interactive child and optional `.ui-list-current` for the visual current item.                     |
| Selected           | Pattern-owned / not baseline List               | Do not use List as a listbox or selectable grid. Use approved selection controls or Data table.                              |
| Disabled           | Implemented / required proof for child controls | Disabled semantics must come from the child Component API. `.ui-list-disabled` may only provide token-backed visual support. |
| Loading/skeleton   | Implemented / required proof                    | Data-backed lists may show skeleton rows or Loading/Inline loading composition with `aria-busy` or equivalent status text.   |
| Empty              | Implemented / required proof                    | Show visible empty-state copy. Do not render an empty list with no user-facing explanation.                                  |
| Overflow/wrapping  | Implemented / required proof                    | Long content wraps across lines while preserving marker and text alignment. Truncation is not the default.                   |
| Responsive         | Implemented / required proof                    | Items remain vertical; parent Grid or Pattern may place separate list groups side by side.                                   |
| Read-only          | Not applicable                                  | List content is static by default; read-only is a form/input state.                                                          |
| Validation         | Not applicable                                  | Validation belongs to fields/forms. A list may display validation guidance but does not own validation state.                |
| Expanded/collapsed | Not applicable                                  | Use Accordion or Tree view for disclosure hierarchy.                                                                         |
| Open/closed        | Not applicable                                  | Use Menu, Menu buttons, Tooltip, Toggletip, Popover, or Modal for open/closed UI surfaces.                                   |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

List consumes Foundation Color, Spacing, Typography, Themes, and 2x Grid where composed in layouts.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- 2x Grid where separate list groups are placed in columns or responsive page sections.

List does not expose an icon API or motion API. Icons and motion may appear only through approved child Components or parent Patterns that consume the Icons and Motion Element standards directly.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                            |
| ----------- | ---------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Item text, marker color, current item text, disabled text, skeleton surface, and theme-sensitive contrast.                               |
| Spacing     | Item gap, nested indentation, compact density, marker-to-content gap, and responsive group spacing when delegated by the parent Pattern. |
| Typography  | Body text size, line height, regular weight, wrapping behavior, and ordered-marker alignment.                                            |
| Themes      | Light/dark token resolution for text, markers, disabled state, current state, and skeleton state.                                        |
| 2x Grid     | Page, card, form, or content-section placement when multiple list groups align to layout columns.                                        |

### 7.3. CSS namespace

Allowed component classes should use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-list
.ui-list-unordered
.ui-list-ordered
.ui-list-compact
.ui-list-nested
.ui-list-item
.ui-list-current
.ui-list-disabled
.ui-list-empty
.ui-list-skeleton
```

Feature views must not create `list-*`, Bootstrap `.list-group` patterns, raw utility clusters, arbitrary marker colors, arbitrary indentation, custom focus rings, local skeleton animation, or component-local row-hover treatments for the same UI role.

### 7.4. Helper ownership

| Helper/API                | Status                   | Rule                                                                                    |
| ------------------------- | ------------------------ | --------------------------------------------------------------------------------------- |
| `x-ui.list`               | Not installed / deferred | Do not call until a future Component standard installs it.                              |
| `x-ui.code-snippet`       | Related Component        | Use for developer examples on the UI Reference page, not for production list rendering. |
| Link Component            | Related Component        | Use for links inside list items. Link owns focus, hover, and visited/external behavior. |
| Loading or Inline loading | Related Component        | Use when a parent Pattern chooses a loading indicator instead of skeleton rows.         |

## 8. Composition rules

- Use native list semantics first. Do not recreate list structure with `div`, `span`, grid rows, or table markup.
- Choose unordered lists for equal-priority content and ordered lists for sequence-sensitive content.
- Keep body-content list items vertical. Do not place items horizontally as a local layout trick.
- Separate list groups may be placed side by side only by a parent Pattern using the approved Grid rules.
- Place nested lists inside the parent `<li>` so assistive technologies preserve hierarchy.
- Keep nested lists to the installed two-level boundary unless a future standard proves deeper hierarchy.
- Keep item content concise enough to scan. Long content must wrap instead of widening the component or forcing overflow.
- Use Link for navigational text inside an item. List must not own link styling or keyboard behavior.
- Use Button only when a list item includes a command approved by the parent Pattern. List must not become an action toolbar.
- Use Checkbox or Radio button when each item needs explicit user selection. List must not become a selectable listbox.
- Use Loading/Inline loading or skeleton rows for pending data. Do not render stale sample items as loading placeholders.
- Use visible empty-state copy for no results, no requirements, or no available items.
- Parent Patterns own headings, captions, empty-state placement, external spacing, responsive columns, workflow context, and page-level layout.
- Components own internal list semantics, markers, item spacing, wrapping, density, and token-backed state styling.

## 9. Selection guidance

### 9.1. Use when:

- Users need to scan a simple related set of body-content items.
- Items are short requirements, notes, included features, constraints, summaries, or instructional steps.
- Content has one clear list structure and does not need sorting, filtering, row selection, or multiple aligned columns.
- The content is part of a card, form helper area, page section, empty state, onboarding instruction, or policy summary.
- A sequence needs numbered steps or ranked order.

### 9.2. Do not use when:

- Content requires aligned columns, sorting, filtering, pagination, bulk actions, or row selection; use Data table.
- Content compares labels and values in row form; use Structured list when that API is the installed fit.
- Content needs bordered or titled row containers; use Contained list only when its deferred/gated API is accepted.
- Content is card-like and needs a clickable surface; use Tile.
- Items are selectable options; use Checkbox, Radio button, Toggle, Select, Dropdown, or an approved Pattern.
- Items form a navigation menu; use Menu, Menu buttons, UI shell, Breadcrumb, or Tabs as appropriate.
- Items form an expandable hierarchy; use Accordion or Tree view when the approved API owns that behavior.
- A feature needs local density, borders, row hover, marker icons, or arbitrary indentation.

### Variant selection:

| Need                                            | Use                                                               |
| ----------------------------------------------- | ----------------------------------------------------------------- |
| Equal-priority bullets                          | Unordered list                                                    |
| Step-by-step instructions                       | Ordered list                                                      |
| Ranked or priority order                        | Ordered list                                                      |
| Short dense supporting metadata                 | Compact unordered list                                            |
| Simple parent/child body hierarchy              | Nested list                                                       |
| Current page or current step inside a link list | `aria-current` on the child link plus optional `.ui-list-current` |
| No available items                              | Visible empty-state copy with `.ui-list-empty`                    |
| Data is loading                                 | Skeleton rows or Loading/Inline loading composition               |
| Complex row comparison                          | Structured list or Data table                                     |
| Selection                                       | Checkbox, Radio button, or Data table selection                   |

## 10. Accessibility contract

- Lists must use native `<ul>`, `<ol>`, and `<li>` semantics.
- Do not apply `role="menu"`, `role="listbox"`, `role="tree"`, `role="tablist"`, or `aria-selected` to baseline List markup.
- Root lists are not focusable.
- Static list items are not keyboard-operable.
- If an item contains a link, button, checkbox, radio, toggle, or another control, that child Component owns keyboard behavior, focus-visible treatment, disabled semantics, and accessible name.
- Use `aria-current="page"`, `aria-current="step"`, or another valid current value only on the interactive child that represents the current context.
- Use `aria-busy="true"` or equivalent Pattern-owned status text when data-backed lists are loading and the loading state needs announcement.
- Empty states must be visible text, not only an empty list element.
- Disabled visual treatment must not be the only indication that an interactive child is unavailable; child Components must provide the correct disabled or aria-disabled behavior.
- Meaning must not rely on marker color, current color, or disabled color alone.
- Focus-visible treatment must be visible in supported themes for interactive children.
- Long list item content must wrap without clipping or truncating essential information.
- If implementation CSS removes native marker/list semantics, the component implementation must restore list semantics in the approved API and prove screen-reader behavior before use.

## 11. Content contract

- Use sentence case.
- Keep list items grammatically parallel.
- Start ordered instruction items with verbs when the list is procedural.
- Keep unordered items as peer concepts; do not imply sequence through writing if order does not matter.
- Avoid mixing full sentences, fragments, and commands in the same list unless the content model requires it.
- Use consistent punctuation across items.
- Keep item text concise enough to scan.
- Let longer text wrap; do not truncate body-list content by default.
- Avoid more than two visible levels of nesting. Rewrite as sections, Accordion, or Structured list when hierarchy becomes deeper.
- Do not use a list when a paragraph is clearer.
- Do not use a table only to create visual alignment for body content that does not need columns.
- Current and disabled item text must explain the actual state or destination; do not rely on marker or color changes alone.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local marker icons, or custom JavaScript.
- Do not create a fake `x-ui.list` or `x-ui.list-item` API in feature code.
- Do not use `div` or `span` structures for body-content lists.
- Do not use direct Carbon production classes such as `cds--*` or `bx--*`.
- Do not use Bootstrap `.list-group` or `.list-group-item` classes for app-owned lists.
- Do not use raw list utility clusters to define marker style, indentation, density, or theme behavior.
- Do not create local density, border, or row-hover treatments.
- Do not hide markers for body-content lists unless an approved Pattern owns an alternate semantic structure.
- Do not use List as a menu, listbox, tree, tablist, or sortable data grid.
- Do not use List for complex data that needs aligned columns, sorting, filtering, pagination, or bulk selection.
- Do not force body content into table structure when alignment is not needed.
- Do not use horizontal list items for body-content lists.
- Do not use icons as custom markers through List.
- Do not create state-only local CSS for current, disabled, loading, empty, focus, or responsive behavior.
- Do not render placeholder copy such as `Component-specific API pending correction` or `Allowed variants: None` on the implemented UI Reference page.

## 13. Deferred or gated capabilities

No deferred capability blocks the installed native/class List API. Future extensions still require an updated Component standard and UI Reference proof before production use.

| Capability                                 | Status                          | Gate                                                                                      |
| ------------------------------------------ | ------------------------------- | ----------------------------------------------------------------------------------------- |
| Dedicated `x-ui.list` Blade component      | Deferred unless later installed | Requires public props, slots, class mapping, accessibility proof, and tests.              |
| Dedicated `x-ui.list-item` Blade component | Deferred unless later installed | Requires item slot contract, child Component boundaries, state mapping, and tests.        |
| Selectable list/listbox behavior           | Not owned by List               | Use Checkbox, Radio button, Multiselect when implemented, or Data table selection.        |
| Drag-and-drop or reorderable list          | Deferred / Pattern-owned        | Requires keyboard reordering, announcements, persistence model, and UI Reference proof.   |
| Virtualized long list                      | Deferred / Pattern-owned        | Requires performance owner, screen-reader strategy, focus restoration, and loading proof. |
| Deep expandable hierarchy                  | Deferred / separate component   | Use Tree view only when its approved API exists.                                          |
| Bordered contained rows                    | Deferred / separate component   | Use Contained list only when its approved API exists.                                     |
| Custom marker icons                        | Gated                           | Requires Icons Element approval, marker semantics proof, and theme proof.                 |
| Reversed ordered list                      | Gated                           | Requires UI Reference proof showing comprehension and number alignment.                   |

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

The List page is a data-display component reference page. It should use grouped examples, variant comparison, density comparison, state tables, nested boundary proof, content behavior proof, responsive/grid proof, and developer implementation examples. It does not need to force every example into the Accordion-style tab model.

### Required Live examples internal sections:

| Required proof            | Rendered behavior                                                                                      | Variants/options shown                                                                             |
| ------------------------- | ------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------------------- |
| Basic unordered list      | A native unordered list renders with app-owned markers, spacing, text color, typography, and wrapping. | Unordered, standard density, default state                                                         |
| Basic ordered list        | A native ordered list renders sequence-sensitive content with number alignment.                        | Ordered, standard density, default state                                                           |
| Variant comparison        | Ordered and unordered variants render side by side with purpose labels.                                | Unordered vs Ordered                                                                               |
| Density comparison        | Standard and compact density render with the same content for comparison.                              | Standard, Compact                                                                                  |
| Nested boundary           | A parent item renders a second-level nested list with approved indentation and marker behavior.        | Nested unordered, nested ordered where useful, two-level boundary                                  |
| Content-only guidance     | Body-content examples show requirements, short notes, and procedural steps without row actions.        | Text-only items, inline Link where appropriate                                                     |
| Current and focus item    | A link list shows current-page treatment and focus-visible behavior through the Link Component.        | Current, Focus-visible, Link child behavior                                                        |
| Disabled item             | A list item containing an unavailable child control shows disabled treatment through the child API.    | Disabled child control, optional `.ui-list-disabled` visual support                                |
| Empty state               | A data-backed list with no items renders visible empty copy instead of an empty root list.             | Empty                                                                                              |
| Loading/skeleton state    | A data-backed list renders token-backed skeleton rows or Loading/Inline loading composition.           | Loading, Skeleton, `aria-busy` or equivalent status text                                           |
| Overflow and wrapping     | A long item wraps below the text area without clipping, truncating, or breaking marker alignment.      | Multi-line item, two-digit ordered item                                                            |
| Responsive/grid placement | Separate list groups align to approved Grid columns while each list keeps vertical item flow.          | Standard list groups, compact list groups, responsive wrap                                         |
| Developer implementation  | Canonical native calls and class contracts render as token-backed code snippets.                       | `<ul>`, `<ol>`, `<li>`, `.ui-list`, variant classes, density/state classes                         |
| Prohibited usage proof    | The page calls out non-approved local patterns without rendering them as approved examples.            | No direct Carbon classes, no Bootstrap list groups, no fake `x-ui.list`, no local marker utilities |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered variants, rendered density options, rendered states, content rules, prohibited usage, deferred gates, related API links, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/list` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The Component contract card includes Anatomy and States first, followed by Behavior, Developer implementation, Content guidance, and Accessibility requirements.
- The unordered list example renders native `<ul>` and `<li>` semantics with `ui-list` classes.
- The ordered list example renders native `<ol>` and `<li>` semantics with `ui-list` classes.
- The density comparison renders standard and compact list examples.
- The nested boundary example renders a child list inside a parent list item.
- The state examples render current/focus, disabled, empty, loading/skeleton, overflow/wrapping, and responsive behavior.
- Current item examples use `aria-current` on an interactive child, not `aria-selected` on the list item.
- Loading examples include skeleton rows or Loading/Inline loading composition with accessible status behavior.
- Empty examples render visible empty-state copy and do not present an empty root list as complete UI.
- Developer examples use native `<ul>`, `<ol>`, and `<li>` markup with app-owned `ui-list` classes.
- The UI Reference page does not present `x-ui.list` as an installed public API unless this standard is updated.
- The UI Reference page does not present direct Carbon classes, Bootstrap list groups, raw utility clusters, or local marker CSS as approved implementation.
- No generic placeholder content appears.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/list');

$response->assertOk();
$response->assertSee('List');
$response->assertSee('Purpose');
$response->assertSee('Use cases');
$response->assertSee('Component contract');
$response->assertSee('Live examples');
$response->assertSee('Related components and patterns');
$response->assertSee('Anatomy');
$response->assertSee('States');
$response->assertSee('Behavior');
$response->assertSee('Developer implementation');
$response->assertSee('Content guidance');
$response->assertSee('Accessibility requirements');
$response->assertSee('ui-list');
$response->assertSee('ui-list-unordered');
$response->assertSee('ui-list-ordered');
$response->assertSee('ui-list-compact');
$response->assertSee('Nested boundary');
$response->assertSee('Empty state');
$response->assertSee('Loading/skeleton');
$response->assertSee('aria-current');
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
$response->assertDontSee('class="list-group');
$response->assertDontSee('class="list-disc');
```

For implementation tests, add page-specific assertions that the rendered examples include real `ul`, `ol`, and `li` elements rather than only text labels.

## 17. Related APIs

| API                 | Route                                                          |
| ------------------- | -------------------------------------------------------------- |
| Components overview | `/platform/ui-reference/components`                            |
| Link                | `/platform/ui-reference/components/link`                       |
| Data table          | `/platform/ui-reference/components/data-table`                 |
| Structured list     | `/platform/ui-reference/components/structured-list`            |
| Contained list      | `/platform/ui-reference/components/contained-list`             |
| Tile                | `/platform/ui-reference/components/tile`                       |
| Code snippet        | `/platform/ui-reference/components/code-snippet`               |
| Loading             | `/platform/ui-reference/components/loading`                    |
| Inline loading      | `/platform/ui-reference/components/inline-loading`             |
| Accordion           | `/platform/ui-reference/components/accordion`                  |
| Tree view           | `/platform/ui-reference/components/tree-view`                  |
| Forms pattern       | `/platform/ui-reference/patterns/forms`                        |
| Layout Pattern      | `/platform/ui-reference/patterns/layout`                       |
| Color element       | `/platform/ui-reference/elements/color`                        |
| Spacing element     | `/platform/ui-reference/elements/spacing`                      |
| Typography element  | `/platform/ui-reference/elements/typography`                   |
| Themes element      | `/platform/ui-reference/elements/themes`                       |
| 2x Grid element     | `/platform/ui-reference/elements/2x-grid`                      |
| Canonical list doc  | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Flist.md` |
| Carbon list usage   | `https://carbondesignsystem.com/components/list/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon List usage, style, code, and accessibility guidance inform unordered/ordered variants, native semantic structure, nested hierarchy, typography, vertical alignment, wrapping, and accessibility boundaries. Login App keeps its own native Blade markup contract, app-owned `ui-*` class namespace, Foundation Element token model, route ownership, and UI Reference proof requirements.
