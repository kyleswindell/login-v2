---
title: Tile
slug: tile
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: data-display
priority: tier-b-common-reusable-component
ui_reference_route: /platform/ui-reference/components/tile
canonical_doc: docs/02-standards/ui/components/tile.md
source_owner: /platform/ui-reference/components/tile
blade_api:
  - x-ui.tile
javascript_api: []
source_files:
  - resources/views/components/ui/tile.blade.php
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
  - 2x-grid
related_components:
  - button
  - icon-button
  - link
  - checkbox
  - radio-button
  - tag
  - structured-list
  - data-table
  - loading
  - inline-loading
related_patterns:
  - forms
  - cards
  - navigation
  - tables
  - search-results
carbon_reference:
  - https://carbondesignsystem.com/components/tile/usage/
  - https://carbondesignsystem.com/components/tile/style/
  - https://carbondesignsystem.com/components/tile/accessibility/
---

# Tile Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Static tile](#41-static-tile)
  - [4.2. Clickable tile](#42-clickable-tile)
  - [4.3. Selectable tile](#43-selectable-tile)
  - [4.4. Expandable tile](#44-expandable-tile)
  - [4.5. API surfaces](#45-api-surfaces)
  - [4.6. Props and options](#46-props-and-options)
  - [4.7. Slots](#47-slots)
  - [4.8. Component-owned data attributes](#48-component-owned-data-attributes)
  - [4.9. Variant contract](#49-variant-contract)
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

Tile presents compact static, clickable, selectable, or expandable content blocks for scanning and choosing related information.

Canonical API owner: `/platform/ui-reference/components/tile`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Tile is the installed Login App 2.0 compact content-block API. It owns tile surface styling, scan hierarchy, interactive affordance, selected/current treatment, expandable disclosure treatment, disabled behavior, focus-visible behavior, overflow handling, loading/skeleton handoff, density, responsive grid fit, and token-backed states. It does not own full data table behavior, card page layout, filter query orchestration, form validation policy, table row hover, sorting, pagination, or page-level workflow decisions.

### 1.1. Canonical API responsibilities:

- Render compact content blocks through `x-ui.tile`.
- Support static, clickable, selectable, and expandable tile variants where implemented.
- Make interactive tiles visibly operable and keyboard operable.
- Keep static tiles non-interactive while allowing approved child actions inside.
- Prevent nested interactive controls inside directly interactive tiles.
- Express selected/current state through approved component state and accessible semantics.
- Express expandable state through approved disclosure semantics.
- Support standard and compact density where implemented.
- Support empty, loading/skeleton-adjacent, disabled, overflow, focus-visible, selected/current, expanded/collapsed, and responsive behavior.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, icons, and 2x Grid.
- Prove static, clickable, selectable, expandable, disabled/deferred, density, state, accessibility, overflow, and developer implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Data table alignment, sorting, row selection, row hover, density, and pagination. Use Data table and Table toolbar Patterns.
- Full card layouts with rich media, long body copy, and page-level CTAs. Use Card Pattern if installed.
- Form field validation, required state, and error summaries. Use Forms Pattern, Checkbox, Radio button, and field APIs.
- Filter query state and result refreshing. Use Filters or Search results Patterns.
- Button hierarchy and modal/footer action placement. Use Button and Modal.
- Skeleton screen orchestration. Use Loading or the owning Pattern.
- External grid placement, grouping, and responsive layout. Parent Patterns own those concerns.

## 2. Status and ownership

| Field                        | Value                                                                                                                                                                |
| ---------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                                                                                         |
| System maturity              | Partial                                                                                                                                                              |
| API layer                    | Component API                                                                                                                                                        |
| Component slug               | tile                                                                                                                                                                 |
| Category                     | Data display                                                                                                                                                         |
| Priority                     | Tier B - Common reusable component                                                                                                                                   |
| UI Reference route           | `/platform/ui-reference/components/tile`                                                                                                                             |
| Canonical doc                | `docs/02-standards/ui/components/tile.md`                                                                                                                            |
| Source owner                 | `/platform/ui-reference/components/tile`                                                                                                                             |
| Blade API                    | `x-ui.tile`                                                                                                                                                          |
| JavaScript API               | No dedicated public JavaScript controller required for baseline static, clickable, and selectable behavior. Expandable behavior is component-owned when implemented. |
| Source files                 | `resources/views/components/ui/tile.blade.php`; `resources/css/app.css`                                                                                              |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons, 2x Grid                                                                                                           |
| Carbon benchmark             | Carbon Tile usage, style, and accessibility guidance                                                                                                                 |

`Approved API` means the installed component exists, but the canonical public API, state definitions, interactive semantics, disabled/deferred boundaries, UI Reference examples, and regression expectations must be corrected so feature teams do not create local tile surfaces, selectable cards, clickable panels, or expandable card controls.

## 3. Installed standard

Tile is the standard compact block for short scan-and-select content when a table is too heavy and a plain list is too weak.

### 3.1. The installed standard is:

- Render tile surfaces through `<x-ui.tile>`.
- Use `variant="static"` for non-interactive information blocks.
- Use `variant="clickable"` when the entire tile navigates or triggers one clear action.
- Use `variant="selectable"` when the entire tile represents one selectable option.
- Use `variant="expandable"` only when the installed component owns disclosure behavior.
- Use `density="standard"` for normal dashboard, settings, and option-grid content.
- Use `density="compact"` for dense option groups or constrained admin surfaces.
- Use `selected` only for selectable/current tile semantics, not decoration.
- Use `disabled` only for interactive tile variants where the unavailable state is meaningful.
- Use `href` for clickable navigation tiles.
- Use `button` or component-owned action semantics for clickable tiles that trigger local UI behavior.
- Keep child interactive controls out of clickable, selectable, and expandable tile trigger surfaces.
- Use static tiles when the tile contains links, buttons, menus, checkboxes, or other interactive children.
- Keep tile titles and descriptions concise.
- Use parent Patterns for tile grids, responsive columns, external spacing, data loading, and workflow orchestration.
- Do not create local density, border, hover, selected, row-hover, or card-like tile treatments.
- Do not use raw utility clusters, raw color values, arbitrary spacing, local icons, or custom JavaScript to create alternate tile behavior.

Carbon alignment note: Carbon defines base/static, clickable, selectable, and expandable tile roles and distinguishes non-interactive tiles that may contain child actions from interactive tiles that are directly actionable and should not contain nested interactive controls. Carbon has also added accessibility-focused changes that visually mark interactive tiles as operable and improve selectable icon treatment. Login App maps those principles to its own `x-ui.tile` API, `ui-*` namespace, app token model, and UI Reference proof instead of adopting Carbon implementation classes directly.

## 4. Public API

### 4.1. Static tile

```blade
<x-ui.tile
    variant="static"
    title="Workspace activity"
    description="Review recent account and user activity."
>
    <x-ui.tag tone="info">Updated today</x-ui.tag>
</x-ui.tile>
```

### 4.2. Clickable tile

```blade
<x-ui.tile
    variant="clickable"
    href="{{ route('admin.users.index') }}"
    title="Manage users"
    description="Review access, roles, and account status."
/>
```

### 4.3. Selectable tile

```blade
<x-ui.tile
    variant="selectable"
    name="plan"
    value="business"
    title="Business"
    description="For teams that need shared administration."
    :selected="$plan === 'business'"
/>
```

### 4.4. Expandable tile

```blade
<x-ui.tile
    variant="expandable"
    id="billing-details"
    title="Billing details"
    description="View account billing metadata."
>
    <x-slot:expanded>
        <dl class="ui-description-list">
            <div>
                <dt>Billing contact</dt>
                <dd>Accounting team</dd>
            </div>
            <div>
                <dt>Billing status</dt>
                <dd>Active</dd>
            </div>
        </dl>
    </x-slot:expanded>
</x-ui.tile>
```

Use the Blade API instead of hand-building cards, panels, selectable card inputs, whole-card links, local disclosure cards, or tile-like grid items in feature views.

### 4.5. API surfaces

| API surface           | Installed value                                                                                                                                                     |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Blade API             | `x-ui.tile`                                                                                                                                                         |
| JavaScript            | No dedicated public JavaScript controller required for static, clickable, or selectable baseline behavior. Expandable behavior is component-owned when implemented. |
| Root semantic element | Component-owned: `div`, `a`, `button`, or form-control wrapper depending on variant                                                                                 |
| Data attributes       | Component-owned attributes documented below. Feature views must not invent tile behavior attributes.                                                                |
| CSS namespace         | App-owned `ui-*` tile classes documented by the component implementation                                                                                            |
| Source files          | `resources/views/components/ui/tile.blade.php`; `resources/css/app.css`                                                                                             |

### 4.6. Props and options

| Prop/option   | Type            | Default    | Allowed values                                    | Required                                    | Notes                                                                                                                             |
| ------------- | --------------- | ---------- | ------------------------------------------------- | ------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------- |
| `variant`     | `string`        | `static`   | `static`, `clickable`, `selectable`, `expandable` | No                                          | Selects semantic tile behavior.                                                                                                   |
| `title`       | `string / null` | `null`     | Short sentence-case title                         | Recommended                                 | Preferred visible heading for scan hierarchy and accessible name.                                                                 |
| `description` | `string / null` | `null`     | Short supporting text                             | No                                          | Keep concise. Do not use for long body content.                                                                                   |
| `href`        | `string / null` | `null`     | Valid URL                                         | Required for link-style clickable tiles     | Use for navigation. Do not combine with child interactive controls.                                                               |
| `type`        | `string`        | `button`   | `button`, `submit`                                | No                                          | Applies only when clickable tile renders a button. Use `submit` only when the owning form intentionally submits through the tile. |
| `name`        | `string / null` | `null`     | Form field name                                   | Required for form-backed selectable tiles   | Use only when selectable tile participates in form submission.                                                                    |
| `value`       | `string / null` | `null`     | Form field value                                  | Required when `name` is used                | Must map to the owning form option value.                                                                                         |
| `selected`    | `bool`          | `false`    | `true`, `false`                                   | No                                          | Marks selectable/current state. Must be semantic, not decorative.                                                                 |
| `current`     | `bool`          | `false`    | `true`, `false`                                   | No                                          | Use for current navigation/detail state when selection is not a form value.                                                       |
| `expanded`    | `bool`          | `false`    | `true`, `false`                                   | No                                          | Initial expandable state where supported. Parent state may control it only through installed behavior.                            |
| `disabled`    | `bool`          | `false`    | `true`, `false`                                   | No                                          | Interactive variants only. Static tiles should not be disabled.                                                                   |
| `density`     | `string`        | `standard` | `standard`, `compact`                             | No                                          | Controls internal spacing and content density.                                                                                    |
| `icon`        | `string / null` | `null`     | Approved Heroicon alias/component                 | No                                          | Decorative or status-supporting icon only when Icons Element allows it. Do not rely on icon alone.                                |
| `meta`        | `string / null` | `null`     | Short metadata text                               | No                                          | Optional eyebrow/meta content, such as category or count.                                                                         |
| `loading`     | `bool`          | `false`    | `true`, `false`                                   | No                                          | Use only for local tile content pending states; prefer Pattern-owned skeleton/loading for grids.                                  |
| `id`          | `string / null` | `null`     | Valid document ID                                 | Required for controlled expandable examples | Used for aria relationships and tests.                                                                                            |
| `class`       | `string / null` | `null`     | Layout passthrough if supported                   | No                                          | Parent Patterns may pass placement classes only. Do not use for color, typography, border, hover, selected, or state overrides.   |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.7. Slots

| Slot         | Status                                      | Purpose                                             | Rules                                                                                                                          |
| ------------ | ------------------------------------------- | --------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------ |
| Default slot | Implemented                                 | Static body content or primary visible tile content | Keep concise. Static tiles may include approved child actions. Interactive tiles must not contain nested interactive controls. |
| `header`     | Gated unless implemented                    | Custom title/meta composition                       | Requires accessible naming proof. Prefer `title`, `meta`, and default slot.                                                    |
| `media`      | Deferred unless implemented                 | Image/illustration area                             | Requires aspect ratio, alt text, loading, and responsive proof.                                                                |
| `actions`    | Static tiles only / Pattern-owned           | Child links/buttons inside non-interactive tile     | Do not use inside clickable, selectable, or expandable trigger surfaces.                                                       |
| `expanded`   | Implemented / required proof for expandable | Content revealed by expandable tile                 | Must not include nested controls unless the implementation proves valid disclosure semantics and focus behavior.               |

### 4.8. Component-owned data attributes

| Data attribute                                                        | Status                   | Owner     | Purpose                                                                                      |
| --------------------------------------------------------------------- | ------------------------ | --------- | -------------------------------------------------------------------------------------------- |
| `data-ui-component="tile"`                                            | Implemented when emitted | Component | Identifies the root component for testing and diagnostics.                                   |
| `data-ui-tile-variant="static / clickable / selectable / expandable"` | Implemented when emitted | Component | Exposes approved variant for tests and component-owned styling only.                         |
| `data-ui-tile-density="standard / compact"`                           | Implemented when emitted | Component | Exposes density for tests and component-owned styling only.                                  |
| `data-ui-selected="true / false"`                                     | Implemented when emitted | Component | Exposes selected state for tests and component-owned styling only.                           |
| `data-ui-expanded="true / false"`                                     | Implemented when emitted | Component | Exposes expandable state for tests and component-owned styling only.                         |
| `data-ui-disabled="true / false"`                                     | Implemented when emitted | Component | Exposes disabled state for tests and component-owned styling only.                           |
| Feature-local data attributes                                         | Not allowed              | none      | Do not create local tile selection, expansion, loading, hover, or state behavior attributes. |

### 4.9. Variant contract

| Variant      | Status                       | Root behavior                                                                  | Use when                                                                  | Do not use when                                                                         |
| ------------ | ---------------------------- | ------------------------------------------------------------------------------ | ------------------------------------------------------------------------- | --------------------------------------------------------------------------------------- |
| `static`     | Implemented                  | Non-interactive container                                                      | Content needs compact visual grouping and may include child links/buttons | The entire tile should be one action or option                                          |
| `clickable`  | Implemented                  | Whole tile is one link or button                                               | The entire block navigates or triggers one clear action                   | Tile content contains nested links, buttons, menus, or form controls                    |
| `selectable` | Implemented / required proof | Whole tile is one option                                                       | Users choose one option from a set or mark a tile selected                | A checkbox/radio group would be clearer or exact form semantics are not installed       |
| `expandable` | Implemented / required proof | Whole tile reveals/hides additional content through component-owned disclosure | A small amount of secondary detail should be hidden until requested       | The hidden content contains a complex workflow, many controls, or required page content |

## 5. Allowed variants, options, and modifiers

| Name                              | Type          | Status                                            | API                                                                       | Notes                                                                  |
| --------------------------------- | ------------- | ------------------------------------------------- | ------------------------------------------------------------------------- | ---------------------------------------------------------------------- |
| Static tile                       | Variant       | Implemented                                       | `variant="static"`                                                        | Non-interactive content surface.                                       |
| Clickable tile                    | Variant       | Implemented                                       | `variant="clickable"` with `href` or button behavior                      | Whole tile is one action.                                              |
| Selectable tile                   | Variant       | Implemented / required proof                      | `variant="selectable"`, `selected`, `name`, `value`                       | Whole tile is one selectable option.                                   |
| Expandable tile                   | Variant       | Implemented / required proof                      | `variant="expandable"`, `expanded`, `expanded` slot                       | Reveals secondary content.                                             |
| Standard density                  | Density       | Implemented                                       | `density="standard"`                                                      | Default tile spacing and scan hierarchy.                               |
| Compact density                   | Density       | Implemented                                       | `density="compact"`                                                       | Dense option grids or constrained admin contexts.                      |
| Selected                          | State         | Implemented                                       | `selected`                                                                | For selectable/current options only.                                   |
| Current                           | State         | Implemented / required proof                      | `current`                                                                 | For current navigation/detail state where not form-backed.             |
| Disabled interactive tile         | State         | Implemented / required proof                      | `disabled`                                                                | Interactive variants only.                                             |
| Empty tile                        | State         | Implemented / required proof                      | default slot/title/description state                                      | Use only as Pattern-owned empty placeholder; do not fake content.      |
| Loading handoff                   | Composition   | Implemented through Loading/Inline loading        | `loading` or parent composition                                           | Use approved loading APIs; do not create local spinners.               |
| Skeleton tile                     | Composition   | Pattern-owned                                     | Loading Pattern or grid owner                                             | Tile does not own full skeleton screen orchestration.                  |
| Media tile                        | Modifier      | Deferred unless implemented                       | none                                                                      | Requires media slot, aspect ratio, alt text, and responsive proof.     |
| Tile group helper                 | Pattern-owned | Deferred                                          | none                                                                      | Parent grid/list Pattern owns grouping until `x-ui.tile-group` exists. |
| Multi-select tile group           | Gated         | selectable with checkbox semantics if implemented | Requires Checkbox semantics, group labelling, form submission, and tests. |                                                                        |
| Radio tile group                  | Gated         | selectable with radio semantics if implemented    | Requires Radio semantics, group labelling, keyboard model, and tests.     |                                                                        |
| Nested interactive clickable tile | Not allowed   | none                                              | Use static tile with child actions instead.                               |                                                                        |
| Custom density/border/hover       | Not allowed   | none                                              | Requires component and token updates.                                     |                                                                        |

## 6. States

| State              | Status                                                | Implementation requirement                                                                                                                         |
| ------------------ | ----------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| Default            | Implemented                                           | Renders approved variant, density, title/body hierarchy, and token-backed surface.                                                                 |
| Hover              | Implemented for interactive variants                  | Token-backed hover treatment only on clickable, selectable, and expandable tiles. Static tiles do not receive interactive hover.                   |
| Focus-visible      | Implemented for interactive variants                  | Whole interactive tile receives visible focus in supported themes. Child controls inside static tiles use their own focus styles.                  |
| Active/pressed     | Implemented for interactive variants                  | Token-backed pressed state for clickable/selectable/expandable activation.                                                                         |
| Selected/current   | Implemented / required proof                          | Selected/current treatment is visual and programmatic. Use `aria-current`, checked state, or equivalent component-owned markup as appropriate.     |
| Expanded           | Implemented / required proof                          | Expandable tile exposes expanded state and revealed content through component-owned disclosure semantics.                                          |
| Collapsed          | Implemented / required proof                          | Expandable tile hides secondary content while preserving accessible disclosure state.                                                              |
| Disabled           | Implemented / required proof for interactive variants | Disabled interactive tile is visibly unavailable and cannot be activated. Static disabled is not applicable.                                       |
| Empty              | Implemented / required proof                          | Empty tile state must be Pattern-owned and clearly identified; do not render blank decorative surfaces.                                            |
| Loading            | Composition-owned                                     | Use Loading or Inline loading for pending tile content or grid reloads. Tile may expose a disabled/pending surface but must not invent loading UI. |
| Skeleton           | Pattern-owned                                         | Use Loading Pattern or grid/list owner for skeleton tiles.                                                                                         |
| Error              | Not owned                                             | Use Notification, form error, or owning Pattern. Tile may contain error content but does not own error semantics.                                  |
| Warning            | Not owned                                             | Use Notification, Tag, or owning Pattern.                                                                                                          |
| Success            | Not owned                                             | Use Tag, Notification, or owning Pattern.                                                                                                          |
| Validation         | Not owned                                             | Selectable tile validation belongs to Forms Pattern and Checkbox/Radio semantics.                                                                  |
| Read-only          | Not applicable                                        | Use static tile for read-only content.                                                                                                             |
| Overflow/truncated | Implemented / required proof                          | Titles and descriptions wrap or truncate only through approved content rules; focus and actions must remain visible.                               |
| Responsive         | Implemented / required proof                          | Tiles fit parent grid/list rules without local breakpoints or arbitrary widths.                                                                    |
| Reduced motion     | Implemented where motion exists                       | Expand/collapse and hover/press transitions must honor reduced-motion preferences.                                                                 |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Tile consumes Foundation Color, Spacing, Typography, Themes, Motion, Icons, and 2x Grid.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons.
- 2x Grid.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                           |
| ----------- | ----------------------------------------------------------------------------------------------------------------------- |
| Color       | Surface, border, text, meta text, icon, hover, active, focus, selected/current, disabled, and supported theme contrast. |
| Spacing     | Internal padding, title/body gap, meta gap, icon gap, expanded content gap, compact density, and responsive wrapping.   |
| Typography  | Meta, title, body, supporting text, counts, and compact text hierarchy.                                                 |
| Themes      | Light, dark, and inverse token resolution for surface, border, text, focus, selected/current, and disabled states.      |
| Motion      | Hover/press transitions and expandable reveal/hide behavior with reduced-motion fallback.                               |
| Icons       | Optional component-owned affordance icons and approved decorative/status icons.                                         |
| 2x Grid     | Parent-owned tile grid placement, column spans, responsive behavior, and tile grouping.                                 |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$layer` | Base tile container surface | `ui-tile` surface role | App layer palette | Same role / app value | Tile surface must not use local card colors. |
| `$layer-hover` | Clickable tile hover surface | Clickable tile hover state | App layer state palette | Same role / app value | Hover shares global layer-hover mapping. |
| `$border-tile`, `$border-disabled`, `$border-inverse` | Clickable, disabled expandable, and selected tile borders | Tile border state roles | App border palette / component-owned tile alias | Same role / app value | `border-tile` may be component-owned but must map through Color standard. |
| `$icon-interactive` | Clickable tile icon | Tile affordance icon role | App icon/interactive palette | Same role / app value | Icons inherit from tile state. |
| `$text-primary`, `$text-secondary` | Title/body/meta text | Tile text roles | App text palette | Same role / app value | Text hierarchy stays Color/Typography-owned. |
| `$ai-aura-start`, `$ai-border-stop`, `$ai-drop-shadow` | AI tile presence | No baseline tile role until AI tile variant is approved | None | Not adopted | AI tokens remain gated. |

### 7.3. CSS namespace

Allowed component classes must use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-tile
.ui-tile__meta
.ui-tile__title
.ui-tile__description
.ui-tile__body
.ui-tile__icon
.ui-tile__action-icon
.ui-tile__expanded
.ui-tile__actions
.ui-tile--static
.ui-tile--clickable
.ui-tile--selectable
.ui-tile--expandable
.ui-tile--selected
.ui-tile--current
.ui-tile--expanded
.ui-tile--collapsed
.ui-tile--disabled
.ui-tile--loading
.ui-tile--empty
.ui-tile--density-standard
.ui-tile--density-compact
```

Feature views must not create Bootstrap card/tile classes, local `tile-*` classes, raw utility clusters, arbitrary borders, arbitrary shadows, local hover treatments, custom selected indicators, custom disclosure icons, direct Carbon implementation classes, or local grid breakpoints for the same UI role.

### 7.4. Helper and composition usage

| Helper/API               | Status                        | Allowed usage                                                                                     |
| ------------------------ | ----------------------------- | ------------------------------------------------------------------------------------------------- |
| `x-ui.tile`              | Implemented                   | Canonical tile surface API.                                                                       |
| `x-ui.button`            | Static tiles only             | Child actions inside static tiles. Do not nest inside clickable/selectable tile trigger surfaces. |
| `x-ui.link`              | Static tiles only             | Supporting links inside static tiles. Use clickable tile when the whole tile is one link.         |
| `x-ui.checkbox`          | Pattern-owned alternative     | Use for explicit multi-select forms when tile selection semantics are not installed.              |
| `x-ui.radio-button`      | Pattern-owned alternative     | Use for explicit single-select forms when radio tile semantics are not installed.                 |
| `x-ui.tag`               | Static content/status support | Short metadata/status inside tile content. Do not rely on tag color alone.                        |
| Loading / Inline loading | Composition-owned             | Pending content or save state near a tile; no local spinners.                                     |
| 2x Grid                  | Parent-owned                  | Tile layout, columns, wrapping, and external gaps.                                                |

## 8. Composition rules

- Use static tiles for compact content blocks that may contain multiple child actions.
- Use clickable tiles only when the entire tile has one destination or one command.
- Use selectable tiles only in an option group where each tile represents one choice.
- Use expandable tiles only for short secondary detail that belongs with the summary content.
- Do not put buttons, links, menus, checkboxes, radios, toggles, or form fields inside a clickable/selectable/expandable tile trigger surface.
- If a tile needs multiple actions, use a static tile with child Button/Link/Icon button components.
- If the content requires aligned columns, sorting, scanning many fields, or row actions, use Data table or Structured list instead.
- If the content is a full marketing/feature card with image, long body, and CTA, use Card Pattern if installed.
- Keep each tile focused on one object, choice, or summary.
- Keep title, description, meta, and status content short.
- Keep selected/current state semantic and connected to a real selection, current route, or current object.
- Disable interactive tiles only when the user can understand why the option is unavailable through surrounding context or helper text.
- Parent Patterns own tile group labels, grid columns, external spacing, loading/empty states, filter state, and responsive placement.
- Components own tile surface, internal spacing, interactive affordance, focus/hover/active/disabled states, selected/current treatment, expandable disclosure treatment, and token-backed styling.

## 9. Selection guidance

### 9.1. Use when:

- Users need to scan a small set of compact blocks.
- Users need to choose between visually comparable options.
- A dashboard, settings page, or index needs compact summary blocks.
- A block has one clear whole-tile action or destination.
- A block needs to reveal a small amount of directly related secondary content.
- A table would create unnecessary column alignment for simple content.

### 9.2. Do not use when:

- Users need aligned columns, sorting, pagination, or dense row scanning; use Data table.
- Users need simple text-only content without block affordance; use a list or Structured list.
- The block has many independent actions; use static tile, Card Pattern, or page layout instead of clickable tile.
- The content is long-form page content.
- The interaction is only decorative or visual emphasis.
- A native Checkbox or Radio button group would be clearer and more accessible.
- The tile would hide required page content behind expansion.
- The feature needs local density, border, selected, hover, or row-hover treatments.

### 9.3. Variant selection:

| Need                                   | Use                                                           |
| -------------------------------------- | ------------------------------------------------------------- |
| Compact read-only content block        | `variant="static"`                                            |
| Whole block navigates to detail        | `variant="clickable"` with `href`                             |
| Whole block triggers one local command | `variant="clickable"` with button behavior                    |
| Whole block represents one option      | `variant="selectable"`                                        |
| Whole block shows current item/state   | `selected` or `current` only when semantic                    |
| Summary reveals short detail           | `variant="expandable"`                                        |
| Multiple actions inside the block      | Static tile with child Button/Link components                 |
| Aligned records with sorting           | Data table, not Tile                                          |
| Rich card with media and CTA           | Card Pattern, not Tile unless Tile media variant is installed |

## 10. Accessibility contract

- Static tiles are not focusable unless they contain focusable child controls.
- Clickable tiles must use link semantics for navigation and button semantics for commands.
- Selectable tiles must expose selected state through installed form or ARIA semantics.
- Expandable tiles must expose expanded/collapsed state through installed disclosure semantics.
- Every interactive tile must have an accessible name from visible title text or an approved labelling mechanism.
- Interactive tiles must be reachable by keyboard in a logical order.
- Enter activates clickable tiles. Space activates button/selectable/disclosure behavior where native semantics require it.
- Focus-visible treatment must be visible around the operative tile surface in supported light and dark themes.
- Disabled interactive tiles must not be activatable by keyboard or pointer.
- Selected/current state must not rely on color alone.
- Expand/collapse affordance must not rely on icon shape alone; state must be programmatically exposed.
- Do not nest interactive controls inside an interactive tile. Use a static tile if child actions are required.
- Tile groups that represent options must have a visible group label and programmatic group semantics through the owning Pattern or form control API.
- Loading or refreshed tile regions must communicate pending state through Loading or Inline loading APIs when client-side updates occur.
- Overflow handling must not hide focusable controls or required state text.
- Text, border, icons, selected indicators, disabled states, and focus rings must maintain contrast in supported themes.
- Reduced-motion preferences must be respected for expandable reveal/hide transitions.

## 11. Content contract

- Use sentence case.
- Use short concrete titles.
- Use descriptions only when they help distinguish tiles.
- Keep tile title and description scannable.
- Use specific nouns for object tiles: `Users`, `Billing`, `Audit log`, `Workspace activity`.
- Use verb-led titles only when the tile itself is an action: `Manage users`, `Create workspace`, `Review activity`.
- Use metadata sparingly for counts, status, category, or date context.
- Do not duplicate the same label in title, description, and action text.
- Do not rely on icon-only meaning.
- For selectable tiles, make option labels clear enough to compare without reading long descriptions.
- For disabled tiles, use nearby helper or status copy when the reason is not obvious.
- For expandable tiles, title and collapsed description must explain what will be revealed.
- Avoid long body copy, marketing paragraphs, and dense lists inside compact tiles.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not create local card/tile CSS for borders, density, selected state, hover, focus, disabled, or expanded behavior.
- Do not use Bootstrap card classes or direct Carbon production classes for app-owned tiles.
- Do not put interactive children inside directly clickable, selectable, or expandable tile trigger surfaces.
- Do not use clickable tiles for blocks with multiple destinations.
- Do not use selectable tiles without a real selection/form/current-state contract.
- Do not use expandable tiles to hide required page content or complex workflows.
- Do not use tiles as a substitute for data tables when column alignment, sorting, or row actions matter.
- Do not create local tile grids with arbitrary breakpoints or spacing.
- Do not use selected/current styling as decoration.
- Do not rely on color alone for selected, disabled, current, warning, or status meaning.
- Do not create custom disclosure icons or expansion JavaScript.
- Do not render empty decorative tiles.
- Do not truncate tile content so far that the tile purpose or accessible name is lost.

## 13. Deferred or gated capabilities

| Capability                                        | Status                      | Gate                                                                                                                                       |
| ------------------------------------------------- | --------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------ |
| Media tile                                        | Deferred unless implemented | Requires media slot, aspect ratio, alt text rules, lazy-loading policy, responsive proof, and tests.                                       |
| Tile group helper                                 | Deferred / Pattern-owned    | Requires `x-ui.tile-group` API, group labels, keyboard expectations, grid behavior, and tests.                                             |
| Radio tile group                                  | Gated                       | Requires Radio button semantics, group labelling, arrow-key policy if applicable, form submission, selected state, and UI Reference proof. |
| Multi-select tile group                           | Gated                       | Requires Checkbox semantics, group labelling, form submission, selected state, and UI Reference proof.                                     |
| Expandable tile with interactive revealed content | Gated                       | Requires nested-focus model, disclosure semantics, pointer/text selection behavior, and UI Reference proof.                                |
| Disabled static tile                              | Not applicable              | Static tiles are read-only content; use unavailable content copy or parent empty/permission state instead.                                 |
| Skeleton tile component                           | Pattern-owned / Deferred    | Requires Loading Pattern ownership, grid loading policy, and reduced-motion proof.                                                         |
| Custom density                                    | Not allowed                 | Requires Spacing, Typography, and UI Reference updates.                                                                                    |
| Custom border/shadow treatment                    | Not allowed                 | Requires Color, Themes, and accessibility proof.                                                                                           |
| Custom selected icons                             | Not allowed                 | Requires Icons Element update and selectable semantics proof.                                                                              |
| Component-specific JavaScript initializer         | Deferred                    | Requires documented initializer, events, cleanup behavior, keyboard model, and tests.                                                      |

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

The Tile page is a compact content-block reference. The Live examples card should use grouped examples and state matrices rather than only a tabbed scenario scaffold. It must render production examples for implemented variants and explicit trigger conditions for deferred or gated capabilities.

### 15.1. Required Live examples internal sections:

| Required proof              | Rendered behavior                                                                                                                                       | Variants/options shown                                                                                          |
| --------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------- |
| Static tile                 | Non-interactive tile renders title, description, metadata/status content, and optional child action area without making the whole surface focusable.    | Static, Standard density, Compact density, Empty note, Child Button/Link in static only                         |
| Clickable tile              | Whole tile acts as one link or button, shows operable affordance, hover, focus-visible, active, disabled, and responsive behavior.                      | Clickable, `href`, Focus-visible, Hover, Active, Disabled, Overflow                                             |
| Selectable tile             | Option tile renders selected/unselected states and accessible selected semantics without relying on color alone.                                        | Selectable, Selected/current, Disabled, Standard density, Compact density                                       |
| Expandable tile             | Tile reveals and hides secondary content through component-owned disclosure behavior and reduced-motion-safe transition.                                | Expanded, Collapsed, Focus-visible, Reduced motion, Overflow                                                    |
| Disabled deferred           | Page distinguishes implemented interactive disabled state from gated/deferred disabled/static or unavailable-content scenarios.                         | Disabled interactive, Static disabled not applicable, Gated group-disabled note                                 |
| State matrix                | Matrix renders state coverage with production component code.                                                                                           | Default, Hover, Focus-visible, Active, Selected/current, Disabled, Empty, Loading handoff, Overflow, Responsive |
| Density and grid fit        | Examples show standard and compact density in parent-owned grid/list placement.                                                                         | Standard density, Compact density, 2x Grid placement, Responsive wrapping                                       |
| Nested interaction boundary | Page contrasts static tile with child actions against clickable/selectable tile where nested controls are prohibited.                                   | Static with child actions, Clickable no nested actions, Selectable no nested actions                            |
| Loading/skeleton handoff    | Pending tile content or tile grid reload uses Loading or Inline loading composition instead of local spinners.                                          | Loading handoff, Skeleton Pattern-owned, Disabled pending surface                                               |
| Accessibility matrix        | Page proves accessible names, keyboard activation, selected/current semantics, disclosure state, disabled behavior, and no nested interactive controls. | Link/button semantics, `aria-current` or selected equivalent, Expanded/collapsed, Disabled, Focus-visible       |
| Deferred capabilities       | Page documents trigger conditions instead of fake controls.                                                                                             | Media tile, tile group helper, radio tile group, multi-select tile group, interactive expanded content          |
| Developer implementation    | Canonical calls and props render as real code examples.                                                                                                 | `x-ui.tile`, `variant`, `title`, `description`, `href`, `selected`, `expanded`, `density`, slots                |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered variants, rendered states, density, accessibility boundaries, prohibited usage, deferred gates, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/tile` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The static tile example renders non-interactive content and may show approved child actions.
- The clickable tile example renders a whole-tile action with focus-visible, hover, active, disabled, and overflow behavior.
- The selectable tile example renders selected/unselected state and accessible selected semantics.
- The expandable tile example renders expanded/collapsed behavior through component-owned disclosure semantics.
- The disabled/deferred proof distinguishes implemented disabled interactive tiles from gated/deferred static-unavailable and group-disabled behavior.
- The state matrix renders default, hover, focus-visible, active, selected/current, disabled, empty, loading handoff, overflow, and responsive behavior.
- The density proof renders standard and compact densities.
- The nested interaction boundary proves static tiles may contain child actions and interactive tiles must not.
- Loading examples use approved Loading or Inline loading composition and do not create local spinners.
- Developer examples use `x-ui.tile`, not placeholder comments or ad hoc markup.
- Tests assert stale scaffold labels, placeholder pending-correction copy, legacy reference sections, old tier paths, Bootstrap card classes, and direct Carbon implementation class prefixes remain absent from rendered approved examples.
- No generic placeholder content appears.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/tile');

$response->assertOk();
$response->assertSee('Tile');
$response->assertSee('x-ui.tile');
$response->assertSee('variant="static"');
$response->assertSee('variant="clickable"');
$response->assertSee('variant="selectable"');
$response->assertSee('variant="expandable"');
$response->assertSee('density="standard"');
$response->assertSee('density="compact"');
$response->assertSee('Selected');
$response->assertSee('Expanded');
$response->assertSee('Collapsed');
$response->assertSee('Disabled interactive');
$response->assertSee('Do not put interactive children inside');
$response->assertSee('Loading handoff');
$response->assertDontSee('Component-specific API ' . 'pending correction');
$response->assertDontSee('Live Examples ' . 'Card');
$response->assertDontSee('Reference ' . 'Examples');
$response->assertDontSee('Legacy Contract ' . 'Summary');
$response->assertDontSee('tier' . '-1');
$response->assertDontSee('tier' . '-2');
$response->assertDontSee('cds' . '--');
$response->assertDontSee('bx' . '--');
$response->assertDontSee('card card-body');
$response->assertDontSee('TODO');
$response->assertDontSee('Generic ' . 'fallback');
```

## 17. Related APIs

| API                    | Route                                                          |
| ---------------------- | -------------------------------------------------------------- |
| Button                 | `/platform/ui-reference/components/button`                     |
| Icon button            | `/platform/ui-reference/components/button`                     |
| Link                   | `/platform/ui-reference/components/link`                       |
| Checkbox               | `/platform/ui-reference/components/checkbox`                   |
| Radio button           | `/platform/ui-reference/components/radio-button`               |
| Tag                    | `/platform/ui-reference/components/tag`                        |
| Structured list        | `/platform/ui-reference/components/structured-list`            |
| Data table             | `/platform/ui-reference/components/data-table`                 |
| Loading                | `/platform/ui-reference/components/loading`                    |
| Inline loading         | `/platform/ui-reference/components/inline-loading`             |
| Forms pattern          | `/platform/ui-reference/patterns/forms`                        |
| Cards pattern          | `/platform/ui-reference/patterns/cards`                        |
| Navigation Pattern     | `/platform/ui-reference/patterns/navigation`                   |
| Tables Pattern         | `/platform/ui-reference/patterns/tables`                       |
| Search results pattern | `/platform/ui-reference/patterns/search-results`               |
| Color element          | `/platform/ui-reference/elements/color`                        |
| Spacing element        | `/platform/ui-reference/elements/spacing`                      |
| Typography element     | `/platform/ui-reference/elements/typography`                   |
| Themes element         | `/platform/ui-reference/elements/themes`                       |
| Motion element         | `/platform/ui-reference/elements/motion`                       |
| 2x Grid element        | `/platform/ui-reference/elements/2x-grid`                      |
| Components overview    | `/platform/ui-reference/components`                            |
| Canonical tile doc     | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Ftile.md` |
| Carbon tile usage      | `https://carbondesignsystem.com/components/tile/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Tile usage, style, and accessibility guidance inform static/clickable/selectable/expandable role boundaries, interactive affordance, accessible selected/disclosure behavior, disabled treatment, and the prohibition against nested interactive controls inside directly interactive tiles. Login App keeps its own Blade API, `ui-*` namespace, Foundation tokens, and UI Reference proof.