---
title: 2x Grid
slug: 2x-grid
api_layer: Foundation Element API
guide_status: implemented
system_maturity: partial
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/elements/2x-grid.md
carbon_reference:
  - https://carbondesignsystem.com/elements/2x-grid/overview/
  - https://carbondesignsystem.com/elements/2x-grid/usage/
related_elements:
  - spacing
  - color
  - themes
  - typography
related_patterns:
  - layout
  - dashboard-grid
  - app-shell
---

# 2x Grid Element API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Carbon-compatible breakpoint test set](#31-carbon-compatible-breakpoint-test-set)
  - [3.2. Installed gutter model](#32-installed-gutter-model)
  - [3.3. Installed alignment rule](#33-installed-alignment-rule)
- [4. Token API](#4-token-api)
- [5. CSS variable API](#5-css-variable-api)
- [6. Utility class/helper API](#6-utility-classhelper-api)
  - [6.1. Allowed utility families](#61-allowed-utility-families)
  - [6.2. Allowed Blade or Pattern helpers](#62-allowed-blade-or-pattern-helpers)
- [7. Allowed usage](#7-allowed-usage)
  - [7.1. Use when](#71-use-when)
  - [7.2. Avoid when](#72-avoid-when)
  - [7.3. App-specific selection guidance](#73-app-specific-selection-guidance)
- [8. Component and pattern consumers](#8-component-and-pattern-consumers)
- [9. Theme behavior](#9-theme-behavior)
- [10. State behavior](#10-state-behavior)
- [11. Prohibited usage](#11-prohibited-usage)
- [12. Deferred or gated capabilities](#12-deferred-or-gated-capabilities)
- [13. Implementation and Rendered Evidence Checklist](#13-implementation-and-ui-reference-checklist)
  - [13.1. Implementation checklist](#131-implementation-checklist)
  - [13.2. rendered evidence proof checklist](#132-ui-reference-proof-checklist)
- [14. Rendered evidence requirements](#14-ui-reference-requirements)
  - [14.1. Required live views](#141-required-live-views)
  - [14.2. Required page text](#142-required-page-text)
  - [14.3. Required API display](#143-required-api-display)
- [15. Testing and acceptance criteria](#15-testing-and-acceptance-criteria)
- [16. Related APIs](#16-related-apis)
- [17. References](#17-references)

## 1. API summary

2x Grid controls page-level structure, responsive regions, column spans, gutters, and app shell alignment.

2x Grid is a Foundation Element API. Component and Pattern APIs must consume it instead of redefining local values.

2x Grid is the installed layout-geometry standard for Login App 2.0. It defines how pages, major content regions, dashboards, and shell-adjacent surfaces align across viewport widths. It does not replace the Spacing Element API for local component relationships.

### 1.1. Canonical API responsibilities:

- Page-level grid geometry.
- Section-level responsive structure.
- Dashboard/widget placement.
- App shell content alignment.
- Column spans and responsive column count.
- Gutter and content padding rules.
- Fluid, fixed, and hybrid region selection.
- Grid-sensitive responsive test expectations.

### 1.2. Non-owned responsibilities:

- Local component padding.
- Inline text rhythm.
- Form-field internal spacing.
- Button/icon/table cell spacing.
- One-off feature layouts.

Use the 2x Grid Element when the geometry is part of the page or pattern contract. Use the Spacing Element when the spacing describes relationships inside a component or between local sibling elements.

## 2. Status and ownership

| Field              | Value                                                                                               |
| ------------------ | --------------------------------------------------------------------------------------------------- |
| Guide status       | Implemented                                                                                         |
| System maturity    | Partial                                                                                             |
| API layer          | Foundation Element API                                                                              |
| Element slug       | 2x-grid                                                                                             |
| Rendered evidence route | `not installed`                                                           |
| Canonical doc      | `docs/02-standards/ui/elements/2x-grid.md`                                                          |
| Primary consumers  | Page shell, layout patterns, dashboard patterns, data-heavy views, split views, side-panel patterns |
| Carbon benchmark   | Carbon 2x Grid overview and usage                                                                   |

`System maturity: Partial` means the app has an installed grid direction and known utilities, but the full reusable wrapper/component API is still being normalized through the rendered evidence and Pattern API docs.

## 3. Installed standard

Responsive page, section, dashboard, and widget geometry.

Login App 2.0 uses Carbon's 2x Grid principles as an 8px-compatible layout foundation, not as a direct clone of Carbon's full grid package. The installed standard is:

1. Use an 8px-centered mini-unit model for page-level geometry and repeated layout relationships.
2. Use documented layout utilities, wrappers, or Pattern APIs for page/section/dashboard geometry.
3. Use grid-aware wrappers for repeated layouts rather than feature-local row/column markup.
4. Use the Spacing Element API for component-local margins, padding, and gaps.
5. Test grid-sensitive views at Carbon-compatible breakpoint boundaries.
6. Keep visible key lines between headings, content regions, cards, tables, panels, and shell regions.
7. Preserve app shell alignment when global navigation, local navigation, side panels, dialogs, and floating overlays appear.

The installed standard supports three layout behaviors:

| Behavior       | Installed meaning                                                                     | Use when                                                                            |
| -------------- | ------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------- |
| Fluid grid     | Column count is fixed at a breakpoint while column width scales with available space. | Dashboards, data visualizations, tables, wide content regions, major page sections. |
| Fixed boxes    | Box size is selected from the sizing scale, then boxes tile and wrap as space allows. | Tiles, small cards, compact widgets, icon groups, repeated fixed-width summaries.   |
| Hybrid regions | One dimension is grid-fluid and the other is fixed or content-driven.                 | Headers, toolbars, side panels, menus, data tables, content panels.                 |

### 3.1. Carbon-compatible breakpoint test set

When grid alignment matters, test at these viewport widths.

| Breakpoint |            Width | Columns | Column size | Padding | Margin | Login App requirement                                                              |
| ---------- | ---------------: | ------: | ----------: | ------: | -----: | ---------------------------------------------------------------------------------- |
| Small      |  `320px / 20rem` |       4 |         25% |    16px |      0 | Content must remain readable and avoid horizontal overflow.                        |
| Medium     |  `672px / 42rem` |       8 |       12.5% |    16px |   16px | Two-column or split-region behavior may begin only when content remains usable.    |
| Large      | `1056px / 66rem` |      16 |       6.25% |    16px |   16px | Standard desktop page, dashboard, and app-shell alignment begins here.             |
| X-Large    | `1312px / 82rem` |      16 |       6.25% |    16px |   16px | Wider dashboard and data layouts may expand.                                       |
| Max        | `1584px / 99rem` |      16 |       6.25% |    16px |   24px | Max-width, left-aligned, or full-width behavior must match the owning Pattern API. |

Do not assume Tailwind's default breakpoint names are Carbon-compatible. If a view requires exact Carbon breakpoint behavior, the owning Pattern API must define the mapping explicitly.

### 3.2. Installed gutter model

| Gutter mode                               | Status                               | Installed guidance                                                                                          |
| ----------------------------------------- | ------------------------------------ | ----------------------------------------------------------------------------------------------------------- |
| Standard gutter                           | Implemented                          | Use for most page sections, dashboard cards, forms, and major content groups.                               |
| Gutterless                                | Implemented where needed             | Use only when content is closely related and the parent pattern still preserves readable alignment.         |
| Dense/condensed dashboard gutter          | Pattern-owned                        | Dashboard or tile patterns may use a denser gutter only when the pattern documents border/layer separation. |
| Carbon wide/narrow/condensed gutter modes | Not implemented as universal helpers | Do not expose these as global API until documented in this Element and proven in the rendered evidence.          |

### 3.3. Installed alignment rule

Type, component bodies, and content edges should align to the content/padding edge of the owning box, card, panel, or column. Do not place type directly on the gutter or use negative margins to fake alignment.

## 4. Token API

| Token/helper          | Variable or value                                                              | Allowed API/consumer                                    | Example                                                            |
| --------------------- | ------------------------------------------------------------------------------ | ------------------------------------------------------- | ------------------------------------------------------------------ |
| Mini unit             | `8px`-centered spacing model                                                   | Tailwind gap/padding utilities and app grid wrappers    | `grid gap-4 md:grid-cols-2 xl:grid-cols-4`                         |
| Breakpoint test set   | `320px`, `672px`, `1056px`, `1312px`, `1584px`                                 | rendered evidence tests, responsive QA, layout Pattern docs  | Test page geometry at all five widths when grid alignment matters. |
| Small grid            | 4 columns at `320px`                                                           | Page shell, compact layouts, mobile dashboard summaries | Single-column or 2-column local content depending on readability.  |
| Medium grid           | 8 columns at `672px`                                                           | Settings shells, split views, compact dashboard regions | `md:grid-cols-2` when content supports two columns.                |
| Large grid            | 16 columns at `1056px+`                                                        | Desktop page shell, dashboards, data/table regions      | `xl:grid-cols-4` dashboard summary cards.                          |
| Standard box padding  | 16px page/grid box padding baseline                                            | Page sections, grid boxes, cards, panels                | Align headings and text to the padded content edge.                |
| Standard gutter       | 32px total separation when two 16px padded boxes meet                          | Page sections, cards, dashboard modules                 | `gap-4` or pattern-owned equivalent when using 16px app spacing.   |
| Dashboard grid        | `--ui-dashboard-grid-row-size` / `--ui-dashboard-grid-gap`                     | `x-patterns.dashboard-grid`                             | `<x-patterns.dashboard-grid>...</x-patterns.dashboard-grid>`       |
| Content region        | Layout-owned max width and grid columns                                        | Page shell and pattern wrappers                         | `<section class="grid gap-4 xl:grid-cols-4">...</section>`         |
| Fluid content region  | Percentage-based columns inside an owning grid                                 | Dashboard, table, chart, wide card regions              | Data table container spans full content width.                     |
| Fixed box region      | Fixed-size boxes from an approved size scale                                   | Tiles, compact widgets, icon groups                     | Repeated cards tile and wrap without arbitrary widths.             |
| Hybrid region         | Fluid width with fixed/content-driven height, or fixed width with fluid height | Header, toolbar, side panel, menu, data table           | App shell header spans fluid width with fixed height.              |
| Aspect-ratio guidance | `1:1`, `2:1`, `2:3`, `3:2`, `4:3`, `16:9` where applicable                     | Tile, card, media, dashboard, chart patterns            | Use a documented ratio for repeated same-size tiles.               |

Only use Token API rows as installed standards where the related utility/component exists or the owning Pattern API documents it. If a new helper is needed, update this Element standard and the rendered evidence proof before using it in feature code.

## 5. CSS variable API

Use only the CSS variables and token aliases listed in the Token API table or the linked token standards. Do not introduce feature-local CSS variables for this Element without updating this standard.

Installed CSS variables:

| Variable                       | Status      | Owner                                   | Purpose                             | Allowed usage                |
| ------------------------------ | ----------- | --------------------------------------- | ----------------------------------- | ---------------------------- |
| `--ui-dashboard-grid-row-size` | Implemented | Dashboard Pattern API                   | Controls dashboard grid row rhythm. | Dashboard grid wrapper only. |
| `--ui-dashboard-grid-gap`      | Implemented | Dashboard Pattern API / 2x Grid Element | Controls dashboard grid item gap.   | Dashboard grid wrapper only. |

Rules:

- Do not create feature-local variables such as `--settings-grid-gap`, `--report-card-width`, or `--custom-shell-columns` unless the owning Element or Pattern standard is updated.
- Do not use CSS variables to bypass approved spacing, breakpoint, or layout wrappers.
- Do not encode arbitrary pixel values in Blade templates or feature-specific CSS files.
- If a variable becomes reusable across more than one feature, promote it to this Element standard or the owning Pattern API.

## 6. Utility class/helper API

Allowed utility classes, Blade helpers, and component wrappers are those listed in the Token API table and demonstrated by the Rendered evidence route.

### 6.1. Allowed utility families

Use these only in page, section, dashboard, shell, or Pattern-owned layout code:

| Utility family                                   | Status                          | Allowed use                                                                                                       |
| ------------------------------------------------ | ------------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| `grid` / `inline-grid`                           | Implemented                     | Establish page, section, dashboard, or pattern-owned grid structure.                                              |
| `grid-cols-*`                                    | Implemented                     | Define approved column counts in layout wrappers.                                                                 |
| Responsive grid prefixes such as `md:` and `xl:` | Implemented via Tailwind config | Step layout density at approved responsive boundaries. Do not assume exact Carbon parity without the Pattern doc. |
| `col-span-*`                                     | Implemented                     | Express approved content spans inside an owning grid.                                                             |
| `gap-*`                                          | Implemented                     | Apply approved layout spacing through the Spacing Element scale.                                                  |
| `auto-rows-*`                                    | Implemented where pattern-owned | Use for dashboard/widget grids only when documented.                                                              |
| `min-w-0` / overflow-safe utilities              | Implemented                     | Prevent text, tables, and nested components from forcing horizontal overflow.                                     |

### 6.2. Allowed Blade or Pattern helpers

| Helper/API                    | Status                      | Allowed use                                                                                 |
| ----------------------------- | --------------------------- | ------------------------------------------------------------------------------------------- |
| `<x-patterns.dashboard-grid>` | Implemented / Pattern-owned | Dashboard widgets and repeated metric cards.                                                |
| Page shell content wrapper    | Implemented / Pattern-owned | Main application content alignment.                                                         |
| Layout Pattern API wrappers   | Implemented as documented   | Reusable app layouts such as settings, dashboard, split view, shell, or panel compositions. |

Do not create local helpers that duplicate these responsibilities. Promote repeated layout code into the Pattern API instead.

## 7. Allowed usage

- Use when: defining page, section, dashboard, app-shell, or large content-region geometry.
- Avoid when: adding arbitrary row/column wrappers for local component spacing.
- Common app examples: dashboard widgets, settings shell, tables, split views, side panels, and modals.

### 7.1. Use when

Use the 2x Grid Element API when any of the following is true:

- A page needs responsive column structure.
- A section needs repeated aligned cards, panels, metrics, or widgets.
- A data-heavy view needs readable table/chart/card geometry.
- A layout must coordinate with the app shell, global nav, local nav, side panel, or modal.
- A dashboard or overview needs a consistent widget rhythm.
- A pattern needs to define fluid, fixed, or hybrid region behavior.
- Alignment must be preserved across several pages or workflows.

### 7.2. Avoid when

Do not use the 2x Grid Element API when the need is only:

- Padding inside a component.
- Gap between an icon and label.
- Margin between a label and input.
- Button group spacing.
- Inline text rhythm.
- Table cell padding.
- Modal footer button spacing.
- One-off visual tuning inside a feature.

Those cases belong to the Spacing Element or the owning Component API.

### 7.3. App-specific selection guidance

| Need                     | Use                                                                      |
| ------------------------ | ------------------------------------------------------------------------ |
| Page/shell geometry      | 2x Grid Element + Layout Pattern API                                     |
| Local component spacing  | Spacing Element API                                                      |
| Dashboard card placement | Dashboard Pattern API consuming 2x Grid                                  |
| Data table region width  | Data Table Component + table/data Pattern API                            |
| Form field grouping      | Form Pattern API + Spacing Element                                       |
| Side panel composition   | Side Panel/Overlay Pattern API consuming 2x Grid                         |
| Modal sizing/placement   | Modal Component/Overlay Pattern API; do not locally define grid behavior |

## 8. Component and pattern consumers

Components and Patterns must consume this Element through documented tokens, utilities, or wrappers. They must not hard-code alternate local values for the same role.

| Consumer                     | Must consume 2x Grid by                                                               | Must not do                                                   |
| ---------------------------- | ------------------------------------------------------------------------------------- | ------------------------------------------------------------- |
| Dashboard Pattern            | `x-patterns.dashboard-grid`, dashboard row/gap variables, approved responsive columns | Create feature-local card widths or row heights.              |
| App Shell Pattern            | Shell/content wrappers and documented responsive region behavior                      | Add local margins to align content with nav manually.         |
| Settings Layout Pattern      | Pattern-owned grid and section wrappers                                               | Use arbitrary Bootstrap rows or one-off split widths.         |
| Data Table Component/Pattern | Fluid content region, overflow-safe wrappers                                          | Let table width force page-level horizontal overflow.         |
| Tile/Card Patterns           | Fixed or fluid box sizing from this standard                                          | Use arbitrary card dimensions that break the repeated rhythm. |
| Modal/Side Panel Patterns    | Hybrid region rules and shell interaction constraints                                 | Define page-level grid behavior inside modal body content.    |
| Form Patterns                | Form-specific layout wrappers that consume grid/spacing standards                     | Use grid to patch field internals or label/input spacing.     |

If a Component needs layout behavior not defined here, create or update a Pattern API. Do not bury page-level geometry inside a Component API.

## 9. Theme behavior

This Element must remain valid in supported light, dark, inline, inverse, and high-contrast contexts when those contexts apply. Theme behavior is proven on the rendered evidence page.

2x Grid geometry is mostly theme-neutral. Theme behavior appears through the surfaces placed on the grid:

- Page background.
- Layer surfaces.
- Card and panel borders.
- Dashboard widget boundaries.
- Focus-visible outlines for interactive content inside grid regions.
- Skeleton/loading surfaces inside grid regions.
- High-contrast boundaries for condensed dashboard or tile layouts.

Requirements:

- Grid examples must remain readable in all supported app themes.
- Gutter and dense-grid examples must use border/layer tokens where separation is needed.
- Do not use background color differences alone to communicate grid structure.
- If inverse or inline theme contexts are used, the owning Pattern API must prove the grid region still preserves text contrast, focus visibility, and layer separation.

## 10. State behavior

Interactive states such as hover, active, selected, focus-visible, disabled, loading, and validation must use documented Element roles where applicable.

2x Grid does not own interactive state. It owns the geometry in which stateful Components and Patterns appear.

| State            | 2x Grid requirement                                                                                          |
| ---------------- | ------------------------------------------------------------------------------------------------------------ |
| Hover            | Hovered content must not shift grid columns, gutters, or page alignment.                                     |
| Active/pressed   | Pressed controls must not change layout geometry except where the owning Component explicitly animates size. |
| Selected/current | Selected tiles, rows, or cards must preserve grid alignment.                                                 |
| Focus-visible    | Focus rings must remain visible and must not be clipped by grid wrappers.                                    |
| Disabled         | Disabled components must retain their layout slot unless the owning Pattern explicitly removes them.         |
| Loading          | Skeletons and loading regions must preserve expected grid dimensions to prevent layout jump.                 |
| Validation       | Error/warning content must wrap or stack without breaking grid alignment or causing horizontal overflow.     |
| Empty            | Empty states must occupy an intentional grid region and not collapse page structure unexpectedly.            |

## 11. Prohibited usage

- Do not bypass this Element API with one-off raw values, local utility clusters, or custom design tokens.
- Use grid for page-level structure; use spacing tokens for local relationships inside components.
- Do not assume Bootstrap or ad hoc row/column layouts satisfy the app grid standard.
- Test at `320px`, `672px`, `1056px`, `1312px`, and `1584px` when grid alignment matters.
- Do not create feature-local media queries for layout without updating the owning Element or Pattern standard.
- Do not hard-code arbitrary card widths, panel widths, row heights, gutters, or column counts in feature views.
- Do not use negative margins to force type or components onto a column line.
- Do not hang type into gutters.
- Do not use grid wrappers to patch component-internal spacing.
- Do not place tables, charts, cards, or panels in a grid region that cannot handle overflow.
- Do not use screenshots as the only proof of grid behavior in the rendered evidence page.
- Do not treat Carbon 2x Grid as a direct package clone unless the app has explicitly installed and documented that package.

## 12. Deferred or gated capabilities

- No additional capability is approved without updating this Element standard and rendered evidence proof.

| Capability                                        | Status      | Gate                                                                                        |
| ------------------------------------------------- | ----------- | ------------------------------------------------------------------------------------------- |
| Global Carbon grid package clone                  | Deferred    | Requires implementation decision, app-wide migration plan, and rendered evidence proof.          |
| Universal wide/narrow/condensed gutter helper API | Deferred    | Requires token/class API, visual examples, and compatibility tests.                         |
| Custom app breakpoint set                         | Gated       | Requires documentation of mapping against Carbon-compatible widths and Tailwind config.     |
| User-resizable grid regions                       | Deferred    | Requires Pattern API, persistence rules, keyboard/mouse behavior, and accessibility review. |
| Masonry or asymmetric dashboard grids             | Deferred    | Requires dashboard Pattern API and responsive overflow contract.                            |
| Nested subgrid helper API                         | Deferred    | Requires browser support review, Pattern ownership, and rendered evidence examples.              |
| Feature-local layout variables                    | Not allowed | Promote to Element or Pattern API first.                                                    |

## 13. Implementation and Rendered Evidence Checklist

### 13.1. Implementation checklist

| Requirement                 | Standard expectation                                                                                                              |
| --------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source           | The standard names the approved token families, CSS variables, utility classes, helpers, source files, or explicit deferred gate. |
| Token/class/helper coverage | The durable Element API surface is listed for Component and Pattern consumers.                                                    |
| Theme/state behavior        | Theme, state, reduced-motion, accessibility, or interaction rules owned by the Element are defined.                               |
| Consumers                   | Component and Pattern consumers are named where they rely on this Element.                                                        |
| Prohibited usage            | Feature code, Components, and Patterns are told what they must not redefine locally.                                              |
| Tests                       | Route/content/API assertions are defined to prove the Element contract.                                                           |

### 13.2. rendered evidence proof checklist

| Requirement          | Visual proof expectation                                                                                            |
| -------------------- | ------------------------------------------------------------------------------------------------------------------- |
| Live examples        | The page renders examples with app CSS/JS, not screenshots only.                                                    |
| Token/API references | Token, class, helper, or API names appear with example usage.                                                       |
| Theme/state examples | Relevant theme contexts, variants, states, or gated disposition surfaces are visible.                               |
| Accessibility proof  | Contrast, focus, semantics, hit targets, reduced motion, or equivalent Element constraints are shown or documented. |
| Related APIs         | Consuming Components, Patterns, source files, and the canonical standard are linked.                                |
| Manual review        | The page provides enough rendered proof for visual review without opening source code first.                        |
## 14. Rendered evidence requirements

The rendered evidence page at `not installed` must prove this Element API with rendered examples using app CSS/JS, not screenshots only.

### 14.1. Required live views

| Live view                    | Required rendered behavior                                                                                                        | Required variants/options shown                                                      |
| ---------------------------- | --------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------ |
| Responsive grid visualizer   | Shows active content region, columns, gutters, margins, and padding. Includes a visual overlay or column cards.                   | Small, Medium, Large, X-Large, Max breakpoint labels; overlay on/off if implemented. |
| Breakpoint examples          | Shows the same content adapting across the Carbon-compatible breakpoint set.                                                      | 4-column small, 8-column medium, 16-column large/max behavior.                       |
| Column span matrix           | Shows full-width, half-width, quarter-width, sidebar/content, and dashboard-card spans.                                           | `col-span-*` or equivalent app wrapper examples.                                     |
| Gutter examples              | Shows standard gutter, gutterless/closely related content, and dense dashboard separation if implemented.                         | Standard, gutterless, dense dashboard/deferred where applicable.                     |
| Padding and margin alignment | Shows correct alignment of type and content to padding edge; shows prohibited misalignment as a labeled anti-example if useful.   | Correct alignment, incorrect/hard-coded alignment note.                              |
| Fluid/fixed/hybrid regions   | Shows dashboard/table fluid regions, fixed tile/card regions, and hybrid shell/panel regions.                                     | Fluid, fixed, hybrid.                                                                |
| App scaffold                 | Shows header, global/left nav region, local nav/side panel region, main content, right/floating panel, modal/dialog relationship. | Fixed panel, flexible/collapsed panel, floating panel/deferred if not implemented.   |
| Dashboard grid API           | Shows `<x-patterns.dashboard-grid>` or the current installed dashboard wrapper with real widget examples.                         | Row size and gap variable labels.                                                    |

### 14.2. Required page text

The page must include these implementation notes:

```text
Use the 2x Grid for page-level structure and alignment. Use spacing tokens for local relationships inside components.
```

```text
Do not assume Bootstrap or ad hoc row/column layouts satisfy the Login App 2.0 grid standard.
```

```text
When exact grid alignment matters, test at 320px, 672px, 1056px, 1312px, and 1584px.
```

```text
Carbon 2x Grid maps to Login App as an 8px-compatible layout foundation, not a Carbon column system clone.
```

### 14.3. Required API display

The rendered evidence page must show:

- Implementation status.
- System maturity.
- Token/helper table.
- CSS variable API table.
- Utility/helper API table.
- Allowed usage.
- Prohibited usage.
- Theme behavior.
- State behavior.
- Deferred/gated capabilities.
- Related Element, Component, and Pattern APIs.

## 15. Testing and acceptance criteria

- `not installed` returns `200` for authorized users.
- The route remains admin-only or development-only according to the app's rendered evidence access policy.
- The page renders live examples with app CSS/JS rather than screenshots only.
- The page shows token/class/helper API references, allowed usage, prohibited usage, accessibility constraints, and implementation status.
- The page includes the Carbon-compatible breakpoint set: `320px`, `672px`, `1056px`, `1312px`, and `1584px`.
- The page includes the mini unit and explains the app's 8px-compatible model.
- The page distinguishes page-level grid geometry from component-local spacing.
- The page distinguishes fluid, fixed, and hybrid region behavior.
- The page includes dashboard grid API references if the dashboard wrapper is installed.
- The page does not claim universal support for gutter modes, subgrid, masonry, custom breakpoints, or runtime-resizable regions unless those APIs are implemented.
- The page does not use generic fallback text, placeholder examples, or screenshot-only proof.
- Tests assert the presence of required live-view labels and key implementation notes.
- Tests assert prohibited usage guidance is visible.
- Tests assert related API links render.

## 16. Related APIs

| API                     | Route                                                           |
| ----------------------- | --------------------------------------------------------------- |
| Spacing element         | `not installed`                       |
| Color element           | `not installed`                         |
| Themes element          | `not installed`                        |
| Typography element      | `not installed`                    |
| Layout patterns         | `not installed`                        |
| Dashboard grid pattern  | `not installed`                |
| App shell pattern       | `not installed`                     |
| Canonical 2x Grid doc   | `/platform/docs?path=02-standards%2Fui%2Felements%2F2x-grid.md` |
| Carbon 2x Grid overview | `https://carbondesignsystem.com/elements/2x-grid/overview/`     |
| Carbon 2x Grid usage    | `https://carbondesignsystem.com/elements/2x-grid/usage/`        |

## 17. References

- [Foundation Elements Standards](index.md)
- [Component Standards Index](../components/index.md)
- [Pattern Standards Index](../patterns/index.md)
- [Carbon 2x Grid overview](https://carbondesignsystem.com/elements/2x-grid/overview/)
- [Carbon 2x Grid usage](https://carbondesignsystem.com/elements/2x-grid/usage/)

Carbon 2x Grid maps to Login App as an 8px-compatible layout foundation, not a Carbon column system clone.
