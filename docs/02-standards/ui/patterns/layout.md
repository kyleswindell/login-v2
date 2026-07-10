---
title: Layout Patterns
slug: layout
api_layer: Pattern API
status: implemented-standard
system_maturity: partial
category: layout
priority: baseline-pattern-structure
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/patterns/layout.md
source_owner: not installed
pattern_family: layout
consumed_elements:
  - color
  - spacing
  - typography
  - icons
  - motion
  - themes
  - 2x-grid
owned_components:
  - button
  - link
  - notification
  - loading
  - inline-loading
  - tile
  - data-table
  - structured-list
  - list
related_patterns:
  - forms
  - data-and-content
  - feedback
  - overlays-and-actions
  - navigation
carbon_reference:
  - https://carbondesignsystem.com/patterns/overview/
  - https://carbondesignsystem.com/elements/2x-grid/usage/
---

# Layout Pattern API Standard
- [Layout Pattern API Standard](#layout-pattern-api-standard)
  - [1. API summary](#1-api-summary)
  - [2. Status and ownership](#2-status-and-ownership)
  - [3. Installed standard](#3-installed-standard)
  - [4. Pattern API](#4-pattern-api)
    - [4.1. Canonical Pattern classes](#41-canonical-pattern-classes)
    - [4.2. Page band](#42-page-band)
    - [4.3. Content section block](#43-content-section-block)
    - [4.4. Dashboard grid and widget shell](#44-dashboard-grid-and-widget-shell)
    - [4.5. Widget fallback states](#45-widget-fallback-states)
    - [4.6. Action row layout](#46-action-row-layout)
  - [5. Required composition](#5-required-composition)
  - [6. Optional composition](#6-optional-composition)
  - [7. Consumed Element APIs](#7-consumed-element-apis)
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
  - [Implementation and Rendered Evidence Checklist](#implementation-and-ui-reference-checklist)
    - [Implementation checklist](#implementation-checklist)
    - [rendered evidence proof checklist](#ui-reference-proof-checklist)
  - [19. Rendered evidence requirements](#19-ui-reference-requirements)
  - [20. Testing and acceptance criteria](#20-testing-and-acceptance-criteria)
  - [21. Related APIs](#21-related-apis)
  - [22. References](#22-references)

## 1. API summary

Layout patterns define page, section, dashboard, widget, and content-region structure using approved grid and spacing APIs.

Canonical API owner: `not installed`. Use this Pattern API instead of creating local page scaffolds, local grid systems, arbitrary card shells, one-off widget wrappers, custom breakpoints, or feature-specific layout rhythm for the same UI role.

Layout Patterns are the installed Login App 2.0 composition API for arranging pages and major content regions. They own page bands, content section blocks, dashboard grids, widget shells, widget span behavior, card grids, split content regions, local action rows, page-region loading/empty/error fallbacks, and responsive collapse order. They do not own primitive visual tokens, child Component internals, business rules, permissions, persistence, data fetching, route authorization, or workflow-specific branching.

Canonical Pattern responsibilities:

- Compose approved Foundation Element APIs into repeatable page and region structures.
- Compose approved Component APIs without redefining their internal spacing, states, styling, or semantics.
- Establish page rhythm, section hierarchy, dashboard density, widget shell behavior, and responsive collapse order.
- Own external spacing between content regions and child Components.
- Own page-region loading, empty-region fallback, widget error fallback, and responsive collapse state.
- Keep headings, landmarks, reading order, and action placement predictable.
- Prove page band, section block, dashboard grid, widget shell, widget spans, card grid, split content region, action row, fallback states, and responsive behavior on the rendered evidence page.

Non-owned responsibilities:

- Color, spacing, typography, icon sourcing, motion timing, theme behavior, and grid primitives. Use Foundation Element APIs.
- Button, Link, Notification, Loading, Tile, Data table, Structured list, List, and other Component internals. Child Components own their public APIs.
- Business rules, permissions, data loading, persistence, feature-specific branching, and route-specific content. Feature modules own those details.
- App shell right-panel behavior unless the UI shell Pattern/Component explicitly approves it.
- One-off CSS layout hacks created inside feature views.

Carbon alignment note: Carbon frames Patterns as reusable goal-oriented combinations of components and templates. Login App maps that principle to installed Pattern API contracts that define composition ownership, consumed Element APIs, child Component boundaries, responsive behavior, accessibility, content, rendered evidence proof, and tests rather than copying Carbon implementation classes directly.

## 2. Status and ownership

| Field                       | Value                                                                                                      |
| --------------------------- | ---------------------------------------------------------------------------------------------------------- |
| Status                      | Implemented standard                                                                                       |
| System maturity             | Partial                                                                                                    |
| API layer                   | Pattern API                                                                                                |
| Pattern slug                | `layout`                                                                                                   |
| Category                    | Layout                                                                                                     |
| Owner route                 | `not installed`                                                                   |
| rendered evidence proof          | `not installed`                                                                   |
| Canonical path              | `docs/02-standards/ui/patterns/layout.md`                                                                  |
| Source owner                | `not installed`                                                                   |
| Consumed Element APIs       | Color, Spacing, Typography, Icons, Motion, Themes, 2x Grid                                                 |
| Owned Component composition | Button, Link, Notification, Loading, Inline loading, Tile, Data table, Structured list, List as applicable |
| Related Pattern families    | Forms, Data and content, Feedback, Overlay and action, Navigation                                          |
| Carbon benchmark            | Carbon Patterns overview and 2x Grid usage guidance                                                        |

`Implemented standard` means the Layout Pattern API is approved as the composition contract for page, dashboard, widget, and content-region layout. Individual layout examples may still need manual review against this standard as the rendered evidence page and feature pages are corrected.

## 3. Installed standard

Use Layout Patterns for page-level structure, dashboards, widget grids, section blocks, split content regions, card grids, and responsive content areas.

The installed standard is:

- Use approved Foundation Grid and Spacing APIs for page and region relationships.
- Use approved Color, Typography, Themes, Icons, and Motion APIs where surfaces, headings, labels, status, loading, or transitions appear.
- Use the Pattern API classes documented here for page bands, section blocks, dashboard grids, widget shells, widget spans, card grids, split regions, and local action rows.
- Compose approved Components for controls, links, status messages, loading, data display, and content surfaces.
- Keep external spacing at the Pattern layer.
- Keep Component internals inside the Component layer.
- Keep business logic and feature-specific branching inside feature modules.
- Preserve semantic source order in every responsive collapse.
- Avoid horizontal overflow at page, section, grid, widget, and card-grid breakpoints.
- Provide page-region loading, empty, and error fallback examples for dashboard and widget layouts.
- Represent deferred capabilities as gated rows with trigger conditions, not fake complete UI.

Installed layout Pattern roles:

| Role                  | Installed use                                                                                 |
| --------------------- | --------------------------------------------------------------------------------------------- |
| Page band             | Defines full-width page rhythm, section grouping, and surface transitions.                    |
| Content section block | Defines a titled content region with optional intro, body, actions, and status/fallback area. |
| Dashboard grid        | Defines repeatable dashboard widget placement and responsive collapse behavior.               |
| Widget shell          | Defines reusable widget framing, heading, body, action area, and fallback states.             |
| Widget span classes   | Define approved column span behavior for dashboard widgets.                                   |
| Card grid             | Defines repeatable card/tile placement for content collections.                               |
| Split content region  | Defines primary/secondary content regions in semantic source order.                           |
| Action row layout     | Defines local action alignment for a page section or widget, without owning action semantics. |

## 4. Pattern API

### 4.1. Canonical Pattern classes

Use the installed app-owned Pattern classes instead of raw utility clusters or feature-local layout CSS.

| Pattern API                    | Type                 | Status                            | Purpose                                                                        |
| ------------------------------ | -------------------- | --------------------------------- | ------------------------------------------------------------------------------ |
| `.ui-pattern-page-band`        | Page region          | Implemented                       | Creates a major page band or page-level region.                                |
| `.ui-pattern-page-band-header` | Page region anatomy  | Implemented                       | Holds page/region heading, intro, and optional local actions.                  |
| `.ui-pattern-page-band-body`   | Page region anatomy  | Implemented                       | Holds the page band content.                                                   |
| `.ui-pattern-section`          | Section block        | Implemented                       | Creates a reusable content section with consistent heading/action/body rhythm. |
| `.ui-pattern-section-header`   | Section anatomy      | Implemented                       | Holds section title, intro, and local actions.                                 |
| `.ui-pattern-section-body`     | Section anatomy      | Implemented                       | Holds section content, Components, or nested Pattern-owned compositions.       |
| `.ui-pattern-dashboard-grid`   | Dashboard layout     | Implemented                       | Creates a responsive dashboard widget grid.                                    |
| `.ui-pattern-widget-shell`     | Widget shell         | Implemented                       | Creates the approved dashboard/widget container.                               |
| `.ui-pattern-widget-header`    | Widget anatomy       | Implemented                       | Holds widget heading, status, and local actions.                               |
| `.ui-pattern-widget-body`      | Widget anatomy       | Implemented                       | Holds widget content or data display Components.                               |
| `.ui-pattern-widget-footer`    | Widget anatomy       | Implemented                       | Holds supplemental actions, metadata, or links.                                |
| `.ui-pattern-widget-span-1`    | Widget span          | Implemented                       | One-column/default widget span.                                                |
| `.ui-pattern-widget-span-2`    | Widget span          | Implemented                       | Two-column widget span where the dashboard grid supports it.                   |
| `.ui-pattern-widget-span-3`    | Widget span          | Implemented / gated by grid width | Three-column widget span where the route proves wide layout behavior.          |
| `.ui-pattern-card-grid`        | Card/tile layout     | Implemented                       | Creates a responsive grid of cards, tiles, or compact content summaries.       |
| `.ui-pattern-card-grid-item`   | Card-grid anatomy    | Implemented                       | Wraps each card/tile item when the parent needs span or responsive behavior.   |
| `.ui-pattern-split-region`     | Split layout         | Implemented                       | Creates primary/secondary region structure.                                    |
| `.ui-pattern-split-primary`    | Split anatomy        | Implemented                       | Holds primary content in source order.                                         |
| `.ui-pattern-split-secondary`  | Split anatomy        | Implemented                       | Holds supporting content.                                                      |
| `.ui-pattern-action-row`       | Local layout         | Implemented                       | Aligns section/widget/page-local actions without redefining Button APIs.       |
| `.ui-pattern-action-row-start` | Local layout anatomy | Implemented                       | Holds leading helper/status/content in an action row.                          |
| `.ui-pattern-action-row-end`   | Local layout anatomy | Implemented                       | Holds trailing action Components.                                              |
| `.ui-pattern-region-loading`   | Fallback state       | Implemented                       | Hosts Loading/Inline loading for page-region pending states.                   |
| `.ui-pattern-region-empty`     | Fallback state       | Implemented                       | Hosts empty-region content and recovery actions.                               |
| `.ui-pattern-region-error`     | Fallback state       | Implemented                       | Hosts widget/region error fallback and recovery guidance.                      |

Any class not documented here is not public. If a feature needs another layout option, update the Pattern implementation, this standard, and the rendered evidence proof before use.

### 4.2. Page band

Use page bands for major vertical regions of a page or dashboard.

```blade
<section class="ui-pattern-page-band" aria-labelledby="workspace-overview-title">
    <div class="ui-pattern-page-band-header">
        <div>
            <p class="ui-eyebrow">Workspace</p>
            <h1 id="workspace-overview-title">Workspace overview</h1>
            <p class="ui-text-muted">Monitor access, usage, and recent account activity.</p>
        </div>

        <div class="ui-pattern-action-row-end">
            <x-ui.button semantic="primary">Create workspace</x-ui.button>
        </div>
    </div>

    <div class="ui-pattern-page-band-body">
        <!-- Pattern-owned section, dashboard, grid, or content composition. -->
    </div>
</section>
```

### 4.3. Content section block

Use content section blocks for a titled region inside a page band.

```blade
<section class="ui-pattern-section" aria-labelledby="access-summary-title">
    <div class="ui-pattern-section-header">
        <div>
            <h2 id="access-summary-title">Access summary</h2>
            <p class="ui-text-muted">Review current administrators and pending invitations.</p>
        </div>

        <div class="ui-pattern-action-row-end">
            <x-ui.button semantic="tertiary" size="sm">Invite admin</x-ui.button>
        </div>
    </div>

    <div class="ui-pattern-section-body">
        <!-- Approved data display Component or local content composition. -->
    </div>
</section>
```

### 4.4. Dashboard grid and widget shell

Use dashboard grid and widget shell APIs for dashboard surfaces and dashboard-like summaries.

```blade
<div class="ui-pattern-dashboard-grid" aria-label="Workspace metrics">
    <section class="ui-pattern-widget-shell ui-pattern-widget-span-1" aria-labelledby="active-users-widget-title">
        <div class="ui-pattern-widget-header">
            <h2 id="active-users-widget-title">Active users</h2>
            <x-ui.link href="/users">View users</x-ui.link>
        </div>

        <div class="ui-pattern-widget-body">
            <!-- Metric, chart substitute, list, tile, loading, or data display Component. -->
        </div>
    </section>

    <section class="ui-pattern-widget-shell ui-pattern-widget-span-2" aria-labelledby="activity-widget-title">
        <div class="ui-pattern-widget-header">
            <h2 id="activity-widget-title">Recent activity</h2>
        </div>

        <div class="ui-pattern-widget-body">
            <!-- Structured list, data table excerpt, list, loading, empty, or error state. -->
        </div>
    </section>
</div>
```

### 4.5. Widget fallback states

Use Pattern-owned fallback wrappers and approved child Components.

```blade
<section class="ui-pattern-widget-shell" aria-labelledby="sync-widget-title">
    <div class="ui-pattern-widget-header">
        <h2 id="sync-widget-title">Sync status</h2>
    </div>

    <div class="ui-pattern-widget-body ui-pattern-region-loading" aria-busy="true">
        <x-ui.inline-loading label="Loading sync status" />
    </div>
</section>
```

```blade
<section class="ui-pattern-widget-shell" aria-labelledby="invitations-widget-title">
    <div class="ui-pattern-widget-header">
        <h2 id="invitations-widget-title">Pending invitations</h2>
    </div>

    <div class="ui-pattern-widget-body ui-pattern-region-empty" role="status">
        <p>No invitations are waiting for review.</p>
        <x-ui.button semantic="tertiary" size="sm">Invite user</x-ui.button>
    </div>
</section>
```

```blade
<section class="ui-pattern-widget-shell" aria-labelledby="export-widget-title">
    <div class="ui-pattern-widget-header">
        <h2 id="export-widget-title">Export status</h2>
    </div>

    <div class="ui-pattern-widget-body ui-pattern-region-error">
        <x-ui.notification.inline kind="error" title="Export status unavailable">
            Refresh the page or try again later.
        </x-ui.notification.inline>
    </div>
</section>
```

### 4.6. Action row layout

Use action rows to align local actions without changing Button, Link, or Loading APIs.

```blade
<div class="ui-pattern-action-row">
    <div class="ui-pattern-action-row-start">
        <p class="ui-text-muted">Changes apply to the selected workspace.</p>
    </div>

    <div class="ui-pattern-action-row-end">
        <x-ui.button semantic="ghost" type="button">Cancel</x-ui.button>
        <x-ui.button semantic="primary" type="submit">Save changes</x-ui.button>
    </div>
</div>
```

## 5. Required composition

Layout Patterns must compose these approved Element and Component APIs when the relevant role appears.

| Composition area                                    | Required API                                                                                    |
| --------------------------------------------------- | ----------------------------------------------------------------------------------------------- |
| Page and section spacing                            | Spacing Element API                                                                             |
| Page and section columns                            | 2x Grid Element API                                                                             |
| Surfaces and status regions                         | Color and Theme Element APIs                                                                    |
| Headings, labels, helper text, and body copy        | Typography Element API                                                                          |
| Status, disclosure, loading, or action icons        | Icons Element API through approved Components only                                              |
| Loading, collapse, entry/exit, or state transitions | Motion Element API with reduced-motion support                                                  |
| Section and widget actions                          | Button and Link Components                                                                      |
| Region feedback                                     | Notification, Loading, Inline loading Components                                                |
| Dashboard summaries                                 | Tile, List, Structured list, Data table, Tag, Progress bar, or related Components as applicable |
| Code examples on rendered evidence page                  | Code snippet Component where installed                                                          |

Required source-order rules:

- Page-level heading appears before page-level actions in source order.
- Section heading appears before section body in source order.
- Widget heading appears before widget body in source order.
- Primary content appears before secondary content in split regions unless a route-specific accessibility review approves another order.
- Action rows preserve logical reading and tab order.

## 6. Optional composition

Optional compositions are installed only when the route proves the behavior and the child Components remain within their public APIs.

| Optional composition              | Status              | Rule                                                                                            |
| --------------------------------- | ------------------- | ----------------------------------------------------------------------------------------------- |
| Right panel region                | Gated               | Requires approved UI shell or layout owner behavior before production use.                      |
| Sticky local action row           | Gated               | Requires scroll, focus, overlap, responsive, and reduced-motion proof.                          |
| Dashboard widget empty fallback   | Implemented         | Use `.ui-pattern-region-empty` and approved Button/Link/Notification copy as needed.            |
| Dashboard widget error fallback   | Implemented         | Use `.ui-pattern-region-error` and Notification Component.                                      |
| Dashboard widget loading fallback | Implemented         | Use `.ui-pattern-region-loading` and Loading/Inline loading Component.                          |
| Responsive card grid              | Implemented         | Use `.ui-pattern-card-grid` with approved Tile/Card-like Components.                            |
| Split content region              | Implemented         | Use `.ui-pattern-split-region`, `.ui-pattern-split-primary`, and `.ui-pattern-split-secondary`. |
| Local action row                  | Implemented         | Use `.ui-pattern-action-row` with approved Button/Link Components.                              |
| Region-level notification         | Implemented         | Use Notification Component inside the Pattern-owned region.                                     |
| Nested layout pattern             | Gated by complexity | Only nest when it preserves semantic hierarchy and avoids card-in-card structure.               |

## 7. Consumed Element APIs

Layout Patterns consume Foundation Element APIs and must not redefine them locally.

| Element API | Layout usage                                                                                                                   |
| ----------- | ------------------------------------------------------------------------------------------------------------------------------ |
| Color       | Page/section/widget surfaces, text roles, borders, status regions, focus/support surfaces, and state behavior.                 |
| Spacing     | Page bands, section gaps, dashboard gaps, widget padding, card-grid gaps, split-region gaps, and action-row spacing.           |
| Typography  | Page headings, section headings, widget headings, labels, helper text, body copy, empty/error copy, and code where applicable. |
| Icons       | Only through approved child Components or Pattern-owned status/disclosure areas where the Icons Element allows it.             |
| Motion      | Loading, responsive transition, sticky/action-region changes, collapse/expand where approved, and reduced-motion behavior.     |
| Themes      | Light, dark, layered, and inverse contexts for page bands, widgets, fallbacks, and child Components.                           |
| 2x Grid     | Page columns, dashboard grid, widget spans, card grids, split regions, and responsive collapse behavior.                       |

Carbon color composition mapping:

| Pattern need | Carbon benchmark role | Login App owner to compose | Mapping rule |
| ------------ | --------------------- | -------------------------- | ------------ |
| Page, section, card, widget, and nested surfaces | `$background`, `$layer-*`, layer hover/active/selected rows | Color + Themes Elements | Layout chooses depth and grouping; color values come from global surface/layer roles. |
| Borders, dividers, and section separation | `$border-subtle-*`, `$border-strong-*` | Color Element | Layout borders use Color-owned roles only. |
| Empty/error/loading region composition | Notification, Loading, Button, Link, Tag rows | Feedback/Data and Content Patterns + child Components | Layout places states; child APIs own status/loading/action colors. |
| Widget action rows and page headers | Button, Link, Menu buttons, Tabs rows | Navigation Pattern + `x-shell.page-header`/`x-shell.page-title`/`x-shell.page-tabs` + child Components | Layout coordinates placement only. |
| Focus-visible inside layout regions | `$focus`, `$focus-inset`, `$focus-inverse` | Child interactive Components + Color Element | Layout does not define focus colors. |

Element restrictions:

- Do not create local color roles for one page or widget.
- Do not introduce arbitrary spacing values or local gap scales.
- Do not introduce feature-local heading sizes or text styles.
- Do not use local icon files or icon sets.
- Do not create custom animation timing for layout state changes.
- Do not create route-specific theme behavior.
- Do not create one-off grid breakpoints.

## 8. Owned Component APIs

Layout Patterns do not own Component internals. They own the composition boundary around approved Components.

| Owned composition responsibility | Pattern rule                                                                                                  |
| -------------------------------- | ------------------------------------------------------------------------------------------------------------- |
| External spacing                 | Layout owns spacing between child Components and regions. Child Components do not receive local margin hacks. |
| Grid placement                   | Layout owns page, section, dashboard, widget, card, and split-region grid placement.                          |
| Section hierarchy                | Layout owns headings, section wrappers, body regions, and local action placement.                             |
| Widget span behavior             | Layout owns which widgets span available dashboard columns.                                                   |
| Page region composition          | Layout owns how shell page-header placement, sections, widgets, empty states, loading states, and error states fit together. |
| Responsive collapse              | Layout owns collapse order and spacing between collapsed regions.                                             |
| Local action alignment           | Layout owns how Buttons/Links align in action rows; Button/Link own semantics and internal styling.           |
| Fallback placement               | Layout owns where Loading, Notification, empty copy, and recovery actions appear inside a region.             |

Child Component ownership remains unchanged:

| Component                | Child-owned responsibilities                                                                |
| ------------------------ | ------------------------------------------------------------------------------------------- |
| Button                   | Button semantics, variants, sizes, focus, loading, disabled, and icon behavior.             |
| Link                     | Navigation semantics, focus, visited/external behavior, and link styling.                   |
| Notification             | Semantic status, title/body, icon, live-region behavior, and message styling.               |
| Loading / Inline loading | Loading semantics, animation, labels, and reduced-motion behavior.                          |
| Tile                     | Tile semantics, surface, selection/clickable behavior where installed, and internal layout. |
| Data table               | Table semantics, sorting/filtering/pagination/row state where installed.                    |
| Structured list          | Structured row/column semantics and internal row/cell behavior.                             |
| List                     | Native list semantics, markers, density, and item spacing.                                  |

## 9. Allowed variants and layout options

| Variant/layout option   | Status                         | API                                      | Use when                                                                       | Do not use when                                                           |
| ----------------------- | ------------------------------ | ---------------------------------------- | ------------------------------------------------------------------------------ | ------------------------------------------------------------------------- |
| Standard page section   | Implemented                    | `.ui-pattern-section`                    | A page needs a titled content region with optional actions and body content.   | The content is a whole page band or dashboard grid.                       |
| Page band               | Implemented                    | `.ui-pattern-page-band`                  | A major page region needs consistent vertical rhythm and surface behavior.     | A smaller subsection is enough.                                           |
| Dashboard grid          | Implemented                    | `.ui-pattern-dashboard-grid`             | A page groups multiple widgets or summary regions.                             | Content is linear and should be read as one section.                      |
| Widget shell            | Implemented                    | `.ui-pattern-widget-shell`               | Dashboard widgets need consistent shell, heading, body, and fallback behavior. | The content is a full section or a simple card grid item.                 |
| Widget span 1           | Implemented                    | `.ui-pattern-widget-span-1`              | Default dashboard widget size.                                                 | Content needs larger comparison or chart area.                            |
| Widget span 2           | Implemented                    | `.ui-pattern-widget-span-2`              | Widget needs wider space for table/list/chart-like content.                    | The dashboard grid cannot support two columns at the current breakpoint.  |
| Widget span 3           | Implemented / width-gated      | `.ui-pattern-widget-span-3`              | Wide dashboard regions where the route proves large-layout behavior.           | Narrow/medium dashboards or dense summaries.                              |
| Card grid               | Implemented                    | `.ui-pattern-card-grid`                  | A set of tiles/cards should wrap responsively.                                 | Content needs row/column comparison or full table behavior.               |
| Split content region    | Implemented                    | `.ui-pattern-split-region`               | Primary content needs a supporting secondary region.                           | The secondary content is critical before primary content in source order. |
| Action row layout       | Implemented                    | `.ui-pattern-action-row`                 | Local actions need alignment with helper/status text.                          | The actions belong to a global shell or modal footer Pattern.             |
| Right panel region      | Gated                          | none or future `.ui-pattern-right-panel` | Requires UI shell right-panel approval.                                        | Feature views need a quick local sidebar.                                 |
| Sticky local action row | Gated                          | none or future sticky modifier           | Requires scroll/focus/overlap proof.                                           | Standard static action row is sufficient.                                 |
| Nested card structure   | Not allowed for page structure | none                                     | Use section/widget hierarchy instead.                                          | Do not nest cards inside cards to fake layout depth.                      |
| One-off breakpoint      | Not allowed                    | none                                     | Requires 2x Grid Element update before use.                                    | Feature-specific layout pressure.                                         |

## 10. State ownership

Layout Patterns own region-level states. Child Components own their internal states.

| State                   | Layout ownership                                     | Required behavior                                                                                                  |
| ----------------------- | ---------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------ |
| Default                 | Pattern-owned                                        | Page/section/widget/card-grid/split-region layout renders with approved grid and spacing.                          |
| Loading region          | Pattern-owned wrapper, Component-owned indicator     | Use `.ui-pattern-region-loading` and Loading/Inline loading. Apply `aria-busy` to the affected region when useful. |
| Empty region            | Pattern-owned wrapper                                | Use `.ui-pattern-region-empty` with concise empty copy and optional recovery action.                               |
| Widget error fallback   | Pattern-owned wrapper, Notification-owned message    | Use `.ui-pattern-region-error` and Notification Component.                                                         |
| Responsive collapse     | Pattern-owned                                        | Collapse in semantic source order without horizontal overflow.                                                     |
| Overflow                | Pattern-owned at region level                        | Prevent page overflow; child Components handle internal overflow.                                                  |
| Focus-visible           | Child Component-owned                                | Pattern must not suppress child Component focus styles or create custom focus rings.                               |
| Disabled                | Child Component/feature-owned                        | Layout may place disabled Components but does not define disabled behavior.                                        |
| Selected/current        | Child Component/Pattern-specific                     | Layout does not create selected/current state unless a child Component or route-specific Pattern owns it.          |
| Validation              | Forms Pattern-owned                                  | Layout can place validation regions but does not own validation semantics.                                         |
| Sticky/affixed          | Gated                                                | Requires Pattern proof before use.                                                                                 |
| Right panel open/closed | Gated / UI shell-owned                               | Requires UI shell right-panel approval.                                                                            |
| Motion/reduced motion   | Element/Pattern-owned where layout transitions exist | Use Motion Element timing and respect reduced-motion preferences.                                                  |

## 11. Responsive behavior

Layout Patterns must follow approved 2x Grid and Spacing decisions.

Responsive requirements:

- Collapse in semantic source order.
- Preserve source order and reading order.
- Keep headings associated with their content regions.
- Keep local actions after their heading/description in source order unless the route proves another accessible order.
- Avoid horizontal page overflow at every supported breakpoint.
- Avoid forcing child Components into widths below their documented minimum behavior.
- Preserve widget shell hierarchy when dashboard grids collapse.
- Preserve card-grid item order when cards wrap.
- Preserve split-region primary/secondary meaning when stacked.
- Keep sticky/gated regions out of production until overlap, focus, and scroll behavior is proved.
- Keep spacing consistent across adjacent page bands, sections, widgets, and fallback states.

Responsive collapse model:

| Pattern               | Wide behavior                                                             | Narrow behavior                                                                  |
| --------------------- | ------------------------------------------------------------------------- | -------------------------------------------------------------------------------- |
| Page band             | Full-width region with constrained content area if installed by Grid API. | Same source order; reduced vertical rhythm only through approved spacing tokens. |
| Content section block | Header/action/body may align horizontally where space allows.             | Header, intro, actions, then body stack in source order.                         |
| Dashboard grid        | Widgets use approved spans across available columns.                      | Widgets stack in source order and spans collapse predictably.                    |
| Widget shell          | Header/body/footer maintain internal rhythm.                              | Local actions wrap after heading/status without overlapping content.             |
| Card grid             | Cards/tiles fill approved grid columns.                                   | Cards stack or reduce column count without changing order.                       |
| Split content region  | Primary and secondary regions sit side by side where approved.            | Primary appears before secondary unless route-specific proof says otherwise.     |
| Action row            | Helper/status and actions align across a row.                             | Helper/status appears before actions; actions wrap without clipping.             |

## 12. Composition rules

- Use Layout Patterns for structure, rhythm, page grouping, dashboard placement, widget framing, and responsive composition.
- Use Components for individual controls, links, feedback messages, loading indicators, data display, and tiles.
- Use Feature modules for workflow-specific page content, permissions, business rules, data loading, persistence, and conditional branching.
- Patterns own grouping, external spacing, orchestration, region fallback placement, and responsive collapse.
- Child Components own their public APIs, local states, accessibility semantics, and internal spacing.
- Do not add external margins directly to child Components.
- Do not use local wrappers only to fix Component spacing. Fix the Pattern or use approved Pattern classes.
- Do not nest cards inside cards for page structure.
- Do not use Tile as a generic layout section unless Tile owns the content role.
- Do not use Data table to create page columns.
- Do not use dashboard widget shells for every content section. Use `.ui-pattern-section` for regular content regions.
- Do not create feature-local grids, breakpoints, or row/column utilities.
- Do not create local loading, empty, or error layouts when Pattern fallbacks exist.
- Do not place action rows in a way that changes the logical workflow order.
- Do not visually reorder content in a way that breaks reading order or keyboard order.
- Use deferred/gated rows for unapproved right panels, sticky actions, nested layout depth, and complex dashboard behavior.

## 13. Selection guidance

Use Layout Patterns when:

- A page needs repeated structure and rhythm.
- A feature needs a page band, titled section, dashboard grid, widget shell, card grid, split content region, or local action row.
- A dashboard needs consistent widget spans and fallback states.
- A region needs loading, empty, or error fallback placement.
- Multiple child Components need external spacing and responsive coordination.
- A feature needs to arrange content without redefining child Component internals.

Do not use Layout Patterns when:

- You only need a single control; use the relevant Component.
- You need a field layout or validation flow; use Forms Pattern.
- You need a modal, destructive confirmation, popover, or action flow; use Overlay and Action Patterns.
- You need table toolbar behavior or data operations; use Data and Content Patterns.
- You need global navigation or shell behavior; use Navigation Patterns or UI shell.
- You need a feature-specific workflow rule; document it in feature docs.
- You need only a visual style change; use the correct Element/Component API.

Selection matrix:

| Need                                   | Use                                               |
| -------------------------------------- | ------------------------------------------------- |
| Major page region                      | Page band                                         |
| Titled content block                   | Content section block                             |
| Dashboard metrics or summaries         | Dashboard grid + widget shell                     |
| Reusable dashboard widget              | Widget shell                                      |
| Responsive set of cards/tiles          | Card grid                                         |
| Primary content with supporting region | Split content region                              |
| Local section/widget actions           | Action row layout                                 |
| Region loading                         | Region loading fallback + Loading/Inline loading  |
| Region empty state                     | Region empty fallback                             |
| Region failure                         | Region error fallback + Notification              |
| Global shell sidebar/right panel       | Gated UI shell behavior, not local Layout Pattern |
| Sticky form footer/action row          | Gated sticky action behavior until proved         |

## 14. Accessibility contract

- Preserve heading order.
- Use semantic sectioning where a region has a heading.
- Use landmarks predictably and avoid overusing landmarks for small nested widgets.
- Use `aria-labelledby` to connect significant sections/widgets to their headings where appropriate.
- Use `aria-label` only when visible text cannot provide the region name.
- Keep DOM/source order aligned with visual reading order.
- Do not reorder content visually in a way that breaks keyboard or screen-reader order.
- Keep action rows in logical workflow order.
- Do not suppress child Component focus-visible behavior.
- Do not create local focus rings at the Pattern layer.
- Loading regions must expose pending state when content is being replaced or blocked.
- Empty states must be visible text, not only blank space.
- Error fallbacks must identify the failed region and provide a next step where possible.
- Sticky or affixed regions are gated until focus, scroll, zoom, overlap, and reduced-motion behavior are proved.
- Split regions must remain understandable when stacked.
- Dashboard widget headings must be specific enough for users navigating by headings or regions.

## 15. Content contract

- Use section titles that describe the content region.
- Use concise widget headings.
- Avoid vague headings such as `Overview`, `Details`, `Info`, or `More` when a specific region title is possible.
- Use helper/intro copy only when it clarifies the region purpose or next action.
- Keep widget headings short enough to scan.
- Keep empty-state copy specific to the missing content.
- Keep error fallback copy specific to the failed region.
- Use recovery actions only when the user can reasonably recover from the state.
- Do not use decorative cards for page sections.
- Do not create page rhythm with repeated empty headings or generic cards.
- Do not put feature-specific business instructions in the Pattern standard. Feature docs own workflow-specific content.

Recommended heading patterns:

| Region            | Preferred heading style                    |
| ----------------- | ------------------------------------------ |
| Page band         | `Workspace overview`                       |
| Section           | `Access summary`                           |
| Dashboard widget  | `Active users`                             |
| Empty state       | `No pending invitations`                   |
| Error fallback    | `Export status unavailable`                |
| Action row helper | `Changes apply to the selected workspace.` |

## 16. Prohibited usage

- Do not bypass Layout Patterns with one-off Blade wrappers, raw utility clusters, raw colors, arbitrary spacing, local breakpoints, local cards, or custom JavaScript.
- Do not nest cards inside cards for page structure.
- Do not add external margins to child Components.
- Do not create one-off grid breakpoints.
- Do not create feature-local dashboard grids, widget shells, split regions, card grids, or action rows.
- Do not create local loading, empty, or error fallback layouts when Pattern fallbacks exist.
- Do not redefine child Component internals inside layout wrappers.
- Do not force Components into widths below their documented responsive behavior.
- Do not use Tile, Data table, or Structured list as generic layout scaffolding.
- Do not visually reorder content in a way that breaks reading order.
- Do not use `order-*`, absolute positioning, sticky positioning, or transform hacks to solve layout without Pattern proof.
- Do not introduce direct Carbon production classes such as `cds--*` or `bx--*`.
- Do not introduce Bootstrap grid/card classes such as `.row`, `.col-*`, `.card`, `.container`, or `.container-fluid` as approved Pattern implementation.
- Do not create right-panel, sticky-action, nested-dashboard, or custom breakpoint behavior without a gated update and rendered evidence proof.
- Do not render placeholder copy such as `Pattern-specific API pending correction`, `Reference Examples`, `Legacy Contract Summary`, `Live Examples Card`, `Generic fallback`, or `TODO` on the implemented rendered evidence page.

## 17. Deferred or gated capabilities

No deferred capability blocks the installed Layout Pattern API for page bands, content sections, dashboard grids, widget shells, card grids, split regions, and local action rows. Future extensions require an updated Pattern standard and rendered evidence proof before production use.

| Capability                         | Status      | Trigger conditions before use                                                                                                                  |
| ---------------------------------- | ----------- | ---------------------------------------------------------------------------------------------------------------------------------------------- |
| Complex app-shell right panel      | Gated       | UI shell right-panel behavior is approved, focus/landmark/keyboard behavior is proved, responsive collapse is documented, and tests are added. |
| Sticky local action row            | Gated       | Scroll/zoom behavior, focus visibility, overlap avoidance, reduced-motion behavior, and mobile collapse are proved.                            |
| Persistent split panel             | Gated       | Source order, focus management, resize behavior, and UI shell ownership are documented.                                                        |
| Resizable dashboard widgets        | Deferred    | Requires pointer/keyboard resize behavior, persistence model, responsive fallback, and tests.                                                  |
| User-customizable dashboard layout | Deferred    | Requires persistence, drag/drop or reorder accessibility, reset behavior, and tests.                                                           |
| Nested dashboard grids             | Gated       | Requires semantic hierarchy proof, spacing proof, and no card-in-card structure.                                                               |
| Masonry/freeform card grid         | Not allowed | Requires new Grid Element behavior and accessibility review.                                                                                   |
| Route-specific breakpoint          | Not allowed | Requires 2x Grid Element update and rendered evidence proof.                                                                                        |
| Local surface variant              | Not allowed | Requires Color/Theme Element update and rendered evidence proof.                                                                                    |
| Pattern-owned right-side rail      | Gated       | Requires distinction from UI shell, split region, and overlay behavior.                                                                        |

## Implementation and Rendered Evidence Checklist
### Implementation checklist
| Requirement                | Standard expectation                                                                                                                      |
| -------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| Pattern API/source         | The standard names the canonical Pattern helper, layout partial, route/view surface, source files, or explicit deferred gate.             |
| Required composition       | Components and Elements the Pattern must coordinate are listed.                                                                           |
| Optional composition       | Optional slots, regions, actions, filters, summaries, overlays, or deferred sub-APIs are listed.                                          |
| State/responsive ownership | Loading, empty, error, blocked, validation, persistence, focus order, responsive, and overflow behavior owned by the Pattern are defined. |
| Accessibility/content      | Page/workflow semantics, heading structure, focus flow, status messaging, action labels, and non-color meaning are defined.               |
| Tests                      | Route/content/API assertions prove the Pattern and coordinated Component usage.                                                           |

### rendered evidence proof checklist
| Requirement        | Visual proof expectation                                                                                                           |
| ------------------ | ---------------------------------------------------------------------------------------------------------------------------------- |
| Live examples      | The rendered evidence renders Pattern-level workflow or composition examples using installed Component and Element APIs.                |
| Composition proof  | Required and optional child Components are shown in realistic Pattern-owned structure, spacing, and responsive contexts.           |
| State proof        | Pattern-owned loading, empty, error, blocked, validation, persistence, responsive, and overflow states are rendered when relevant. |
| Developer snippets | Examples show the canonical Pattern helper/partial/classes and child Component composition.                                        |
| Deferred gates     | Deferred Pattern sub-APIs show trigger conditions and prohibited workarounds instead of fake live examples.                        |
| Related APIs       | Related Elements, Components, and Patterns are linked.                                                                             |
| Manual review      | The page provides enough rendered proof for visual review of composition, hierarchy, responsive behavior, and workflow boundaries. |

## 19. Rendered evidence requirements

The rendered evidence page must render the approved five-card scaffold: Purpose, Use cases, Pattern contract, Live examples, and Related components and patterns.

The Layout Pattern page is a broad Pattern reference page. It should use rendered full-width examples, comparison grids, dashboard/widget matrices, responsive examples, fallback-state examples, and developer implementation snippets. It must not be abstract notes only.

Required Live examples:

| Required proof               | Rendered behavior                                                                                           | Variants/options shown                                                                         |
| ---------------------------- | ----------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------- |
| Page band                    | A page-level region renders heading, intro, optional actions, and body with approved spacing/grid behavior. | Page band, Header, Body, Action row                                                            |
| Content section block        | A titled section renders header/body/actions with predictable hierarchy.                                    | Standard section, Section header, Section body, Local actions                                  |
| Dashboard grid               | A dashboard grid renders multiple widget shells with approved gaps and responsive spans.                    | Dashboard grid, Widget span 1, Widget span 2, Width-gated span 3                               |
| Widget shell                 | A widget shell renders heading, body, footer/action area, and consistent internal rhythm.                   | Widget header, Widget body, Widget footer                                                      |
| Widget fallback states       | Widget loading, empty, and error states render with approved child Components.                              | Loading, Empty, Error, Notification, Inline loading                                            |
| Card grid                    | A responsive card/tile grid renders consistent item spacing and wrapping.                                   | Card grid, Grid item, Tile/Card composition                                                    |
| Split content region         | Primary and secondary regions render side by side and stack in semantic order.                              | Primary, Secondary, Responsive stack                                                           |
| Action row layout            | Local actions align with helper/status text while preserving Button/Link APIs.                              | Start content, End actions, Button group, Link                                                 |
| Responsive collapse          | Examples demonstrate semantic source-order collapse with no horizontal overflow.                            | Dashboard collapse, Split collapse, Action row wrap                                            |
| Right panel gated boundary   | Right-panel behavior appears as a gated disposition row, not a fake complete example.                       | Trigger conditions, UI shell dependency                                                        |
| Sticky action gated boundary | Sticky action behavior appears as a gated disposition row, not a fake complete example.                     | Trigger conditions, Scroll/focus proof                                                         |
| Element consumption          | Examples identify consumed Color, Spacing, Typography, Themes, Motion, Icons, and 2x Grid APIs.             | Foundation dependency proof                                                                    |
| Component composition        | Examples show approved child Components without redefining their internals.                                 | Button, Link, Notification, Loading, Tile/Data display as applicable                           |
| Developer implementation     | Canonical Pattern classes and Blade composition render as token-backed code snippets.                       | `ui-pattern-*` classes, approved Components, no local grids                                    |
| Prohibited usage proof       | The page calls out non-approved local patterns without rendering them as approved examples.                 | No Bootstrap grid/card, no direct Carbon classes, no one-off breakpoints, no component margins |

rendered evidence page requirements:

- Rendered examples must use app-owned Pattern classes, approved Element APIs, and approved Component APIs.
- Examples must show real layout compositions, not abstract notes only.
- Deferred capabilities must appear as explicit gated disposition rows with trigger conditions.
- The page must link to this canonical standard and consumed Element/Component standards.
- The page must not present local fallback wrappers as approved Pattern APIs.
- The page must not display stale placeholder copy.

## 20. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed Pattern API, states, variants/layout options, prohibited usage, deferred gates, and consumed Foundation Elements.
- Implemented Pattern APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Pattern contract, Live examples, and Related components and patterns cards render in that top-level order.
- Page band, content section block, dashboard grid, widget shell, widget span, card grid, split content region, and action row examples render visibly.
- Widget loading, empty, and error fallback examples render with approved child Components.
- Dashboard and card-grid examples demonstrate responsive collapse expectations.
- Split region examples preserve primary/secondary source order in responsive collapse.
- Action row examples preserve logical reading and tab order.
- Right panel and sticky action behavior are shown as gated unless approved and implemented.
- Rendered examples include required composition markers and consumed Component links.
- No Pattern example hard-codes Foundation Element decisions that already have approved APIs.
- No child Component receives local external margin hacks as part of approved implementation.
- No direct Carbon classes, Bootstrap grid/card classes, raw utility clusters, hard-coded colors, arbitrary spacing, local breakpoints, or custom JavaScript are presented as approved implementation.
- No generic placeholder content appears.

Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Layout');
$response->assertSee('Pattern contract');
$response->assertSee('Live examples');
$response->assertSee('ui-pattern-page-band');
$response->assertSee('ui-pattern-section');
$response->assertSee('ui-pattern-dashboard-grid');
$response->assertSee('ui-pattern-widget-shell');
$response->assertSee('ui-pattern-widget-span-1');
$response->assertSee('ui-pattern-widget-span-2');
$response->assertSee('ui-pattern-card-grid');
$response->assertSee('ui-pattern-split-region');
$response->assertSee('ui-pattern-action-row');
$response->assertSee('Widget fallback states');
$response->assertSee('Right panel gated boundary');
$response->assertSee('Sticky action gated boundary');
$response->assertSee('2x Grid');
$response->assertDontSee('Pattern-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('Generic fallback');
$response->assertDontSee('TODO');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('class="row');
$response->assertDontSee('class="col-');
$response->assertDontSee('class="card');
$response->assertDontSee('container-fluid');
```

For implementation tests, add page-specific assertions that rendered examples include real `ui-pattern-*` wrappers and approved child Components rather than only text labels or simulated layout notes.

## 21. Related APIs

| API                             | Route                                                                           |
| ------------------------------- | ------------------------------------------------------------------------------- |
| Pattern Library Checklist       | `/platform/docs?path=02-standards%2Fui%2Fpatterns%2Fchecklist.md`               |
| Pattern Boundary and Validation | `/platform/docs?path=02-standards%2Fui%2Fpatterns%2Fboundary-and-validation.md` |
| Form Patterns                   | `not installed`                                         |
| Data and Content Patterns       | `not installed`                              |
| Feedback Patterns               | `not installed`                                      |
| Overlay and Action Patterns     | `not installed`                          |
| Navigation Patterns             | `not installed`                                    |
| Notification and Toast Patterns | `not installed`                      |
| 2x Grid element                 | `not installed`                                       |
| Spacing element                 | `not installed`                                       |
| Color element                   | `not installed`                                         |
| Typography element              | `not installed`                                    |
| Icons element                   | `not installed`                                         |
| Motion element                  | `not installed`                                        |
| Themes element                  | `not installed`                                        |
| Button                          | `not installed`                                      |
| Link                            | `not installed`                                        |
| Notification                    | `not installed`                                |
| Loading                         | `not installed`                                     |
| Inline loading                  | `not installed`                              |
| Tile                            | `not installed`                                        |
| Data table                      | `not installed`                                  |
| Structured list                 | `not installed`                             |
| List                            | `not installed`                                        |
| Canonical layout doc            | `/platform/docs?path=02-standards%2Fui%2Fpatterns%2Flayout.md`                  |
| Carbon patterns overview        | `https://carbondesignsystem.com/patterns/overview/`                             |
| Carbon 2x Grid usage            | `https://carbondesignsystem.com/elements/2x-grid/usage/`                        |

## 22. References

- [Pattern Library Checklist](checklist.md)
- [Pattern Boundary And Validation](boundary-and-validation.md)
- [Component Standards](../components/index.md)
- [Component Implementation Checklist](../components/checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [2x Grid Element Standard](../elements/2x-grid.md)
- [Spacing Element Standard](../elements/spacing.md)
- Carbon Patterns overview informs the goal-oriented Pattern framing. Login App keeps its own Pattern API contracts, app-owned `ui-pattern-*` class namespace, Foundation Element consumption rules, Component ownership boundaries, route ownership, and rendered evidence proof requirements.
- Carbon 2x Grid usage informs the emphasis on layout helping users understand page structure, identify relevant content, and pursue the page objective. Login App keeps its own 2x Grid Element API and Pattern-specific layout proof.
