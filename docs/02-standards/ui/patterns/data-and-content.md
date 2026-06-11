---
title: Data and Content
slug: data-and-content
status: implemented-standard
api_layer: Pattern API
pattern_slug: data-and-content
category: Data and content
ui_reference_route: /platform/ui-reference/patterns/data-content
canonical_doc: docs/02-standards/ui/patterns/data-and-content.md
owner_route: /platform/ui-reference/patterns/data-content
consumed_elements:
  - color
  - spacing
  - typography
  - icons
  - motion
  - themes
  - 2x-grid
consumed_components:
  - list
  - structured-list
  - tile
  - tag
  - link
  - button
  - notification
related_patterns:
  - tables
  - forms
  - overlays-feedback
---

# Data and Content Pattern API Standard
- [1. API summary](#1-api-summary)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Pattern API](#4-pattern-api)
  - [4.1. Example calls](#41-example-calls)
- [5. Required composition](#5-required-composition)
- [6. Optional composition](#6-optional-composition)
- [7. Consumed Element APIs](#7-consumed-element-apis)
  - [7.1. Color](#71-color)
  - [7.2. Spacing and grid](#72-spacing-and-grid)
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
  - [15.1. Empty states](#151-empty-states)
  - [15.2. Metadata labels](#152-metadata-labels)
  - [15.3. Values](#153-values)
  - [15.4. Actions](#154-actions)
- [16. Prohibited usage](#16-prohibited-usage)
- [17. Deferred or gated capabilities](#17-deferred-or-gated-capabilities)
- [18. Implementation and UI Reference Checklist](#18-implementation-and-ui-reference-checklist)
  - [18.1. Implementation checklist](#181-implementation-checklist)
  - [18.2. UI Reference proof checklist](#182-ui-reference-proof-checklist)
- [19. UI Reference requirements](#19-ui-reference-requirements)
- [20. Testing and acceptance criteria](#20-testing-and-acceptance-criteria)
- [21. Related APIs](#21-related-apis)
- [22. References](#22-references)

## 1. API summary

Data and content patterns define reusable display structures for read-only records, summaries, empty states, metadata groups, and content lists.

Data and content is a Pattern API. It composes approved Foundation Element APIs and Component APIs into reusable information-display structures. Use this Pattern API instead of rebuilding local cards, summary blocks, empty states, metadata rows, or read-only detail groups for the same UI role.

Patterns are goal-oriented compositions. Components own reusable controls and local behavior. Elements own primitive tokens and visual roles. Feature modules own data loading, permissions, persistence, and business-specific branching.

## 2. Status and ownership

| Field              | Value                                               |
| ------------------ | --------------------------------------------------- |
| Status             | Implemented standard                                |
| API layer          | Pattern API                                         |
| Pattern slug       | data-and-content                                    |
| Category           | Data and content                                    |
| Owner route        | `/platform/ui-reference/patterns/data-content`      |
| Canonical path     | `docs/02-standards/ui/patterns/data-and-content.md` |
| UI Reference proof | `/platform/ui-reference/patterns/data-content`      |
| Source owner       | `/platform/ui-reference/patterns/data-content`      |

## 3. Installed standard

Use data and content patterns when a surface primarily presents information instead of editing it.

The installed standard covers:

- Key/value detail groups.
- Read-only record summaries.
- Identity summary cards.
- Data list items.
- Content section blocks.
- Empty state composition.
- Unavailable state composition.
- Metadata grouping.
- Optional action placement for read-only surfaces.
- Loading placeholders when the final content shape is known.

This Pattern API does not redefine primitive visual decisions. Color, spacing, typography, icons, motion, themes, and grid behavior must come from approved Foundation Element APIs. Child controls must come from approved Component APIs.

This Pattern API does not own feature-specific business behavior. Feature modules own permissions, data fetching, persistence, conditional branches, and workflow-specific copy.

## 4. Pattern API

The installed Pattern API includes these app-owned composition targets.

| Pattern API                           | Status                        | Purpose                                                                                    | Example                                                   |
| ------------------------------------- | ----------------------------- | ------------------------------------------------------------------------------------------ | --------------------------------------------------------- |
| `x-ui.patterns.key-value-display`     | Implemented / target standard | Display short read-only label/value relationships.                                         | Account metadata, audit fields, role details.             |
| `x-ui.patterns.data-list-item`        | Implemented / target standard | Render a repeated summary row or content item without table semantics.                     | Activity item, integration summary, small record preview. |
| `x-ui.patterns.identity-summary-card` | Implemented / target standard | Summarize a user, tenant, workspace, or entity identity.                                   | User card, tenant card, organization summary.             |
| Empty state composition               | Implemented standard          | Explain that no records or content exist yet and optionally provide one clear next action. | No users, no integrations, no audit events.               |
| Content section block                 | Implemented standard          | Group read-only text or content under a clear heading.                                     | About this workspace, billing notes, policy summary.      |

### 4.1. Example calls

```blade
<x-ui.patterns.key-value-display :items="$details" />
```

```blade
<x-ui.patterns.data-list-item
    title="Workspace created"
    meta="System event"
    href="/platform/audit/123"
/>
```

```blade
<x-ui.patterns.identity-summary-card
    title="Acme Workspace"
    subtitle="Production tenant"
    :meta="$workspaceMeta"
/>
```

```blade
<x-ui.patterns.empty-state
    title="No audit events yet"
    message="Events will appear here after activity is recorded."
    action-label="Refresh activity"
/>
```

If a named Blade wrapper is not yet installed for one of these targets, compose the pattern only through the documented approved Component and Element APIs and keep the markup local to the Pattern owner until the wrapper is formalized.

## 5. Required composition

Use these Component APIs as applicable. Do not replace them with local markup for the same UI role.

| Component API      | Required usage                                                                                           |
| ------------------ | -------------------------------------------------------------------------------------------------------- |
| List               | Use for content-only unordered or ordered lists.                                                         |
| Structured list    | Use for comparable read-only rows where a table is too heavy.                                            |
| Tile               | Use for compact content blocks, selectable summaries, or clickable cards when the Tile contract applies. |
| Tag                | Use for metadata, status, labels, and compact classifications.                                           |
| Link               | Use for navigation and trusted reference handoffs.                                                       |
| Button             | Use for explicit commands inside empty states or summary actions.                                        |
| Notification       | Use for system feedback, unavailable content notices, or non-blocking warnings.                          |
| Code snippet       | Use when the read-only content is exact implementation syntax.                                           |
| Loading / Skeleton | Use when the final layout shape is known and data is pending.                                            |

Use these Element APIs in every composition:

| Element API | Required usage                                                                      |
| ----------- | ----------------------------------------------------------------------------------- |
| Color       | Surfaces, text hierarchy, borders, status, focus, and state behavior.               |
| Spacing     | Internal grouping, section rhythm, metadata gaps, and stacked relationships.        |
| Typography  | Headings, labels, metadata, helper copy, body text, and code roles.                 |
| Icons       | Status, affordance, or empty-state support only when meaningful.                    |
| Motion      | Loading, disclosure, and transition behavior only when needed.                      |
| Themes      | Light, dark, layered, inline, inverse, and high-contrast contexts where applicable. |
| 2x Grid     | Page-level and section-level layout relationships.                                  |

## 6. Optional composition

Optional composition is allowed only when it supports the information-display goal.

| Optional composition       | Status                 | Rules                                                                                        |
| -------------------------- | ---------------------- | -------------------------------------------------------------------------------------------- |
| Empty state action         | Implemented standard   | Use one primary action only when there is a clear recovery or creation path.                 |
| Inline metadata tags       | Implemented standard   | Use approved Tag API; do not use color decoratively.                                         |
| Read-only grouped details  | Implemented standard   | Use key/value display or structured list semantics.                                          |
| Skeleton state             | Implemented standard   | Use only when the final content shape is known.                                              |
| Secondary inline action    | Allowed with restraint | Use Link or low-emphasis Button; keep the read-only hierarchy primary.                       |
| Help or documentation link | Allowed                | Use Link; do not use Button for reference navigation.                                        |
| Compact status marker      | Allowed                | Use Tag, Badge/Status if installed, or Notification when message-level feedback is required. |

## 7. Consumed Element APIs

### 7.1. Color

Use token-backed surface, text, border, status, focus, and skeleton roles.

Allowed examples:

- `--ui-surface`
- `--ui-surface-elevated`
- `--ui-layer-01`
- `--ui-layer-02`
- `--ui-text-primary`
- `--ui-text-secondary`
- `--ui-text-helper`
- `--ui-border-subtle-01`
- `--ui-focus-ring`
- status tokens through Tag or Notification APIs

Do not introduce feature-local colors for summary cards, empty states, list rows, or status labels.

Carbon color composition mapping:

| Pattern need | Carbon benchmark role | Login App owner to compose | Mapping rule |
| ------------ | --------------------- | -------------------------- | ------------ |
| Read-only detail/key-value content | Text, layer, border roles | Color Element + Typography Element | Use global text/surface/border roles; do not create local summary palettes. |
| Repeated record lists and selectable summaries | Structured list, Tile, Tree view, Data table row state roles | Owning Component standard | Hover, selected, current, disabled, and focus states remain child Component-owned. |
| Metadata and status chips | Tag token rows and support/status roles | Tag Component + Notification/Status APIs | Tags own compact labels; unresolved Tag all-color rows remain verification-gated. |
| Empty/unavailable states | Typography, Button, Link, Notification, Pictograms | Child Components + Pattern layout | Empty states compose text, optional pictogram, and one clear action without new colors. |
| Skeleton placeholders | `$skeleton-background`, `$skeleton-element` | Loading/Skeleton roles | Skeleton colors are Loading-owned; do not fake with local gray utilities. |
| Tables, filters, and search result regions | Data table, Search, Checkbox, Radio, Select, Dropdown, Tag, Pagination rows | Data Table and filter child Components | This Pattern may arrange data/content regions, but table/filter color state belongs to the child APIs. |

### 7.2. Spacing and grid

Use spacing and grid APIs for layout relationships.

Rules:

- Parent Pattern owns external spacing between composed sections.
- Child Components own their internal spacing.
- Read-only detail groups stack at narrow widths.
- Summary card grids must use approved grid wrappers or documented `grid`/`gap` utilities.
- Long values must wrap instead of causing horizontal overflow.
- Do not add local margins to child Components to force layout rhythm.

### 7.3. Typography

Use approved text roles for:

- Pattern title.
- Section heading.
- Key/value label.
- Key/value value.
- Metadata.
- Helper copy.
- Empty-state title.
- Empty-state message.
- Status copy.
- Code text where applicable.

Do not choose arbitrary font size, weight, color, or line-height for one-off summary blocks.

### 7.4. Icons

Use icons only when they clarify state, identity, affordance, or empty-state meaning.

Rules:

- Decorative icons must be hidden from assistive technology.
- Meaningful icons need accessible text or adjacent visible text.
- Status icons must be paired with status copy or Tag/Notification semantics.
- Do not source local icons outside the approved Icons Element API.

### 7.5. Motion

Use motion only for meaningful state change:

- Loading to loaded.
- Empty to populated.
- Optional disclosure inside an approved child Component.
- Transition of selected summary state where installed.

Do not add decorative animation to read-only content blocks.

### 7.6. Themes

Pattern examples must remain readable across supported theme contexts.

Rules:

- Use theme-aware layer, border, text, focus, and status tokens.
- Do not hard-code light-only card colors.
- Nested cards and rows must preserve layer contrast.
- Inverse or high-contrast examples require explicit UI Reference proof before production use.

## 8. Owned Component APIs

This Pattern API does not own child Component internals. It owns composition decisions around the approved Component APIs.

| Owned pattern responsibility | Description                                                                                    |
| ---------------------------- | ---------------------------------------------------------------------------------------------- |
| Key/value hierarchy          | Determines label/value order, wrapping, empty values, and grouping.                            |
| Metadata grouping            | Determines which metadata belongs inline, stacked, tagged, or hidden behind a related Pattern. |
| Empty state action placement | Determines whether an empty state gets no action, a Link, or one Button action.                |
| Summary-card composition     | Determines heading, body, metadata, tag, link, and action placement.                           |
| Read-only detail grouping    | Determines when to use key/value display, structured list, tile, or content section.           |
| Loading placeholder shape    | Determines whether a skeleton matches a list item, card, detail group, or section block.       |
| Unavailable state handling   | Determines when to show a Notification, empty state, unavailable row, or permission note.      |

Child Components still own focus, hover, disabled, validation, selected, loading, and local accessibility behavior defined by their own Component API standards.

## 9. Allowed variants and layout options

| Variant or layout option        | Status               | Use when                                                                         |
| ------------------------------- | -------------------- | -------------------------------------------------------------------------------- |
| Key-value detail                | Implemented standard | Display stable read-only facts with explicit labels.                             |
| Identity summary                | Implemented standard | Summarize a person, tenant, workspace, account, or entity.                       |
| Data list item                  | Implemented standard | Present repeated record summaries without aligned table comparison.              |
| Empty state                     | Implemented standard | Explain the absence of content and optionally provide one clear recovery action. |
| Content section                 | Implemented standard | Group read-only prose, notes, or documentation-style content.                    |
| Metadata tag row                | Implemented standard | Show compact categories, statuses, or attributes.                                |
| Unavailable state               | Implemented standard | Explain missing permissions, hidden records, or unavailable content.             |
| Skeleton placeholder            | Implemented standard | Show loading when the final content shape is known.                              |
| Selectable content grid         | Deferred / gated     | Requires Tile and selection-control review before adoption.                      |
| Drag/reorder content list       | Deferred             | Requires keyboard, persistence, and state contract.                              |
| Editable detail group           | Not this Pattern     | Use Form Pattern or field Component APIs.                                        |
| Sortable/filterable record list | Not this Pattern     | Use Table Pattern or Data table plus toolbar composition.                        |

## 10. State ownership

The Pattern owns high-level content states. Child Components own local interaction states.

| State               | Owner                     | Rules                                                                                       |
| ------------------- | ------------------------- | ------------------------------------------------------------------------------------------- |
| Empty               | Pattern                   | Explain what is missing and what happens next.                                              |
| Unavailable         | Pattern                   | Explain permission, dependency, or data availability boundary.                              |
| Loading placeholder | Pattern                   | Use skeleton only when final shape is known.                                                |
| Selected summary    | Pattern / child Component | Pattern owns selected-summary meaning; Tile/List/Structured list owns local selected state. |
| Current summary     | Pattern / child Component | Pattern owns current-record meaning; child Component owns focus/current styling.            |
| Error               | Pattern or Notification   | Use Notification when the message affects the whole content region.                         |
| Warning             | Pattern or Notification   | Use Notification or Tag according to message scope.                                         |
| Hover               | Child Component           | Do not style local hover at Pattern level unless the child API owns it.                     |
| Focus-visible       | Child Component           | Keep focus behavior in the child Component API.                                             |
| Disabled            | Child Component           | Use child Component disabled state; Pattern owns why the content is unavailable.            |
| Validation          | Not this Pattern          | Use Form Pattern and field Component APIs.                                                  |

## 11. Responsive behavior

Data and content patterns must remain readable at narrow widths.

Requirements:

- Read-only details stack at narrow widths.
- Key/value pairs may move from two-column to one-column layout.
- Long labels and values wrap instead of forcing horizontal overflow.
- Metadata tag rows wrap with consistent spacing.
- Summary cards collapse to a single-column scan.
- Empty states stay centered or aligned according to parent layout, not by local arbitrary margins.
- Data list items preserve action placement without overlapping text.
- Child Components retain their own responsive behavior.
- Pattern layout must use approved grid and spacing APIs.

## 12. Composition rules

- Patterns own grouping, external spacing, orchestration, and responsive composition.
- Child Components own their public APIs, local states, accessibility semantics, and internal spacing.
- Feature modules own business rules, permissions, data loading, persistence, and workflow-specific branching.
- Use semantic structures when relationships matter:
  - `dl` for key/value detail.
  - `ul` or `ol` for content lists.
  - `section` with headings for content blocks.
  - approved Component APIs for tiles, tags, notifications, links, and buttons.
- Do not compose clickable parents with nested interactive children unless the child Component standard explicitly permits it.
- Do not hide required instructions, errors, or recovery actions inside optional disclosure.
- Do not make an entire read-only summary interactive when only a specific link or action should be interactive.
- Do not use table-like alignment unless table behavior is actually required.
- Do not use status color without visible text or accessible status meaning.
- Keep content hierarchy scannable before adding actions.

## 13. Selection guidance

Use data and content patterns when:

- The surface primarily displays read-only records or summaries.
- Users need to scan metadata, status, and supporting detail.
- An empty, unavailable, or loading state needs a reusable composition.
- A feature needs a compact identity or record summary.
- A list of records does not require aligned columns, sorting, filtering, or pagination.
- A detail page needs grouped facts but no editing workflow.

Use Table Patterns when:

- Users compare values across aligned columns.
- Sorting, filtering, pagination, row selection, or bulk actions are central.
- The content is tabular by nature.

Use Form Patterns when:

- Users edit, validate, submit, or recover field-level data.
- Helper text, validation, and submission behavior are central to the task.

Use Tile Component/API when:

- A compact block itself is selectable, clickable, or part of a tile group.
- Tile focus, selection, or click behavior is required.

Use Structured list when:

- Users compare repeated row-like structures without a full table.
- Rows need consistent labels or columns but not advanced table behavior.

Use Notification when:

- The content state is system feedback, warning, failure, success, or blocking/unavailable message.

Use Link when:

- The user is navigating to related content, reference detail, or documentation.

Use Button when:

- The user triggers a command such as create, retry, refresh, dismiss, or open a workflow.

Do not use this Pattern when:

- The surface is an editing workflow.
- Column comparison is central.
- Sorting/filtering/pagination is required.
- The entire block behaves like a button without using Tile or Link semantics.
- A local feature invents status colors, card spacing, or ad hoc list rows.

## 14. Accessibility contract

Data and content patterns must preserve semantic relationships and readable structure.

Requirements:

- Preserve heading hierarchy.
- Use semantic lists or description lists when relationships matter.
- Provide non-color indicators for status and empty-state meaning.
- Do not rely on icon-only status without text or accessible label.
- Empty states must explain the state in text, not only visually.
- Actionable empty states must expose a clear accessible name for the action.
- Read-only key/value detail should use `dl`, `dt`, and `dd` when practical.
- Repeated content items should use `ul`/`li`, `ol`/`li`, Structured list, or Data table depending on semantics.
- Summary-card actions must be keyboard reachable in a logical order.
- Do not create duplicate interactive regions that confuse screen reader users.
- Loading placeholders must not trap focus or replace essential status messaging.
- Unavailable states must communicate the reason or safe next step when known.
- Theme and contrast requirements are inherited from consumed Element and Component APIs.

## 15. Content contract

Content must be concise, specific, and task-oriented.

### 15.1. Empty states

Empty-state titles must be specific.

Preferred:

- `No audit events yet`
- `No integrations connected`
- `No users match this search`

Avoid:

- `Nothing here`
- `No data`
- `Oops`
- `Start exploring`

Empty-state body copy must explain one of:

- what is missing,
- why it is missing,
- what will happen next,
- or what the user can do.

Empty states must not become marketing copy.

### 15.2. Metadata labels

Metadata labels must:

- be short,
- be stable,
- use sentence case,
- avoid punctuation unless needed,
- describe the value directly.

Preferred:

- `Created`
- `Last updated`
- `Owner`
- `Status`
- `Role`

Avoid:

- `Information`
- `Details`
- `Misc`
- `More`

### 15.3. Values

Values must:

- wrap safely,
- preserve important punctuation,
- display unavailable values consistently,
- avoid placeholder symbols unless documented.

Use `Not provided`, `Unavailable`, or `Unknown` only when the product meaning is clear.

### 15.4. Actions

Action labels must:

- be verb-led for commands,
- be link-style for navigation,
- name the target or result clearly.

Examples:

- `Create workspace`
- `Retry loading`
- `View audit log`
- `Manage integrations`

## 16. Prohibited usage

- Do not use tiles as ad hoc buttons without the Tile Component contract.
- Do not fake table behavior with static cards when sorting/filtering is needed.
- Do not create local card, status, list, or empty-state styles outside this Pattern API.
- Do not hard-code color, spacing, typography, focus, icon, or motion values.
- Do not use status color decoratively.
- Do not use Button for navigation where Link is the correct API.
- Do not use Link for commands that change state.
- Do not make disabled/unavailable content unexplained.
- Do not render empty states with vague titles such as `No data`.
- Do not put required task instructions only in a secondary detail pattern.
- Do not use this Pattern to avoid building a needed Table, Form, Tile, Notification, or Workflow Pattern.
- Do not add nested interactive controls inside a clickable container unless the child Component API explicitly permits it.

## 17. Deferred or gated capabilities

| Capability                        | Status   | Trigger condition                                                                  | Required before implementation                                             |
| --------------------------------- | -------- | ---------------------------------------------------------------------------------- | -------------------------------------------------------------------------- |
| Advanced selectable content grid  | Deferred | Users need selectable card/grid summaries with keyboard and screen reader support. | Tile review, selection-control review, state contract, UI Reference proof. |
| Drag/reorder content list         | Deferred | Users need to reorder read-only summaries.                                         | Keyboard drag model, persistence contract, motion/reduced-motion contract. |
| Bulk action content selection     | Deferred | Users need to select multiple content cards or list items for shared actions.      | Selection model, toolbar pattern, accessibility review.                    |
| Async incremental content loading | Gated    | Content loads page-by-page or section-by-section.                                  | Loading, error, retry, and focus-management contract.                      |
| Virtualized content list          | Deferred | Large record lists exceed normal DOM/rendering limits.                             | Performance, keyboard, screen reader, and scroll-position contract.        |
| Rich media content block          | Gated    | Product content requires image/video/media summaries.                              | Media accessibility, loading, fallback, and layout contract.               |

No deferred capability may be implemented locally inside a feature module. Add or update the Pattern standard and UI Reference proof first.

## 18. Implementation and UI Reference Checklist
### 18.1. Implementation checklist
| Requirement                | Standard expectation                                                                                                                      |
| -------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| Pattern API/source         | The standard names the canonical Pattern helper, layout partial, route/view surface, source files, or explicit deferred gate.             |
| Required composition       | Components and Elements the Pattern must coordinate are listed.                                                                           |
| Optional composition       | Optional slots, regions, actions, filters, summaries, overlays, or deferred sub-APIs are listed.                                          |
| State/responsive ownership | Loading, empty, error, blocked, validation, persistence, focus order, responsive, and overflow behavior owned by the Pattern are defined. |
| Accessibility/content      | Page/workflow semantics, heading structure, focus flow, status messaging, action labels, and non-color meaning are defined.               |
| Tests                      | Route/content/API assertions prove the Pattern and coordinated Component usage.                                                           |

### 18.2. UI Reference proof checklist
| Requirement            | Visual proof expectation                                                                                                           |
| ---------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| Live compositions      | The page renders production-like composed examples, not isolated primitive samples.                                                |
| Component coordination | Child Components show how they consume the Pattern layout and state ownership.                                                     |
| Element consumption    | Spacing, grid, typography, color, theme, icon, and motion use are shown at the Pattern level.                                      |
| Variants/states        | Required layout variants, responsive states, empty/loading/error/blocked states, or explicit gates are visible.                    |
| Related APIs           | Coordinated Components, consumed Elements, planned sub-APIs, source files, and canonical docs are linked.                          |
| Manual review          | The page provides enough rendered proof for visual review of composition, hierarchy, responsive behavior, and workflow boundaries. |
## 19. UI Reference requirements

The UI Reference page must render the approved Pattern page scaffold:

1. Purpose.
2. Use cases.
3. Pattern contract.
4. Live examples.
5. Related Elements, Components, and Patterns.

The UI Reference page must show rendered examples of the approved pattern compositions, not abstract notes only.

| Required proof              | Rendered behavior                                                                                                         | APIs shown                                                        |
| --------------------------- | ------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------- |
| Key-value detail            | A read-only detail group with short labels, wrapping values, and empty-value handling.                                    | Typography, Spacing, Color, `x-ui.patterns.key-value-display`.    |
| Identity summary card       | A compact entity/person/workspace summary with title, subtitle, metadata, and optional status tag.                        | Tile/Card composition, Tag, Link, Button where applicable.        |
| Data list item              | A repeated content item with title, metadata, optional status, and optional navigation link.                              | List or Structured list, Link, Tag.                               |
| Empty state                 | A specific empty state with title, message, and optional single action.                                                   | Button or Link, Icons where meaningful, Typography.               |
| Unavailable state           | A read-only blocked/unavailable state with reason and safe next step.                                                     | Notification, Link or Button where applicable.                    |
| Content section block       | A section of read-only explanatory content with heading hierarchy and proper spacing.                                     | Typography, Spacing, 2x Grid.                                     |
| Loading placeholder         | Skeleton or loading placeholder that matches the final content shape.                                                     | Loading/Skeleton, Motion, Themes.                                 |
| Pattern boundary comparison | Demonstrates when to use Data/content Pattern versus Table Pattern, Form Pattern, Tile, Structured list, or Notification. | Related API links and examples.                                   |
| Deferred capability gates   | Shows gated dispositions for selectable content grids, drag/reorder lists, and async incremental loading.                 | Deferred rows with trigger conditions; no fake complete examples. |

The page must link to this canonical standard and to consumed Element and Component standards.

Examples must use app-owned tokens, classes, helpers, and Blade components where available.

Deferred capabilities must appear as explicit gated disposition rows with trigger conditions, not as fake complete examples.

## 20. Testing and acceptance criteria

- `/platform/ui-reference/patterns/data-content` returns 200 for authorized users.
- The page renders live examples using app CSS/JS and app-owned Blade/component APIs where available.
- The page links to `docs/02-standards/ui/patterns/data-and-content.md`.
- The page shows the installed Pattern API, consumed Element APIs, consumed Component APIs, prohibited usage, deferred gates, and related APIs.
- Rendered examples include required composition markers for key/value detail, identity summary card, data list item, empty state, unavailable state, content section block, and loading placeholder.
- Rendered examples include consumed Component links for List, Structured list, Tile, Tag, Link, Button, Notification, and Loading/Skeleton where applicable.
- No Pattern example hard-codes Foundation Element decisions that already have approved APIs.
- No Pattern example uses local raw colors, arbitrary spacing, local icon sourcing, or one-off focus treatments.
- Deferred capabilities are represented with trigger conditions and prohibited local workarounds.
- The UI Reference page does not render fake advanced selectable grids, drag/reorder lists, bulk action selection, or virtualized content lists as implemented examples.
- The route does not contain placeholder language such as `Pattern-specific API pending correction`, `Component-specific API pending correction`, `Legacy Contract Summary`, or `Reference Examples`.
- The route does not link to deprecated `tier-1` or `tier-2` component docs paths.
- The route does not use direct Carbon production classes such as `cds--` or `bx--`.

## 21. Related APIs

| API                | Route                                               |
| ------------------ | --------------------------------------------------- |
| List               | `/platform/ui-reference/components/list`            |
| Structured list    | `/platform/ui-reference/components/structured-list` |
| Tile               | `/platform/ui-reference/components/tile`            |
| Tag                | `/platform/ui-reference/components/tag`             |
| Link               | `/platform/ui-reference/components/link`            |
| Button             | `/platform/ui-reference/components/button`          |
| Notification       | `/platform/ui-reference/components/notification`    |
| Loading            | `/platform/ui-reference/components/loading`         |
| Data table         | `/platform/ui-reference/components/data-table`      |
| Tables Pattern     | `/platform/ui-reference/patterns/tables`            |
| Forms Pattern      | `/platform/ui-reference/patterns/forms`             |
| Color Element      | `/platform/ui-reference/elements/color`             |
| Spacing Element    | `/platform/ui-reference/elements/spacing`           |
| Typography Element | `/platform/ui-reference/elements/typography`        |
| 2x Grid Element    | `/platform/ui-reference/elements/2x-grid`           |

## 22. References

- [Pattern Library Checklist](checklist.md)
- [Pattern Standards Index](index.md)
- [Component Standards](../components/index.md)
- [Foundation Elements Standards](../elements/index.md)
- [List Component Standard](../components/list.md)
- [Structured List Component Standard](../components/structured-list.md)
- [Tile Component Standard](../components/tile.md)
- [Tag Component Standard](../components/tag.md)
- [Link Component Standard](../components/link.md)
- [Button Component Standard](../components/button.md)
- [Notification Component Standard](../components/notification.md)
- [Data Table Component Standard](../components/data-table.md)
- Carbon Pattern guidance informs the goal-based composition model. Login App owns its own Pattern APIs, implementation gates, and UI Reference proof requirements.