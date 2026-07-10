---
title: Tile
slug: tile
api_layer: Component API
status: implemented-pending-review
system_maturity: implemented
category: data-display
priority: tier-b-common-reusable-component
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/tile.md
source_owner: not installed
blade_api:
  - x-ui.tile
javascript_api:
  - initTiles
source_files:
  - resources/views/components/ui/tile/index.blade.php
  - resources/js/ui-controls/tiles.js
  - resources/js/ui-controls.js
  - resources/js/app.js
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

# Tile Component Standard

Tile presents compact static, clickable, selectable, or expandable content blocks for scanning and choosing related information. Use `x-ui.tile`; do not hand-build tile-like cards, selectable card inputs, whole-card links, or local disclosure surfaces.

## 1. Ownership

Tile owns:

- static/base tile surfaces
- clickable whole-tile links or commands
- selectable single-select and multi-select tiles
- expandable tiles with full-container toggle
- expandable tiles with internal interactive elements and a bottom-right expansion button
- token-backed layer, border, hover, active, selected, disabled, focus, and expanded/collapsed states
- the component JavaScript initializer `initTiles`

Parent Patterns own external grid placement, group labels, responsive orchestration, data loading, workflow state, and complex card/media composition.

## 2. Public API

```blade
<x-ui.tile
    variant="static"
    title="Workspace activity"
    description="Review recent account and user activity."
/>

<x-ui.tile
    variant="clickable"
    href="{{ route('admin.users.index') }}"
    title="Manage users"
    description="Review access, roles, and account status."
/>

<x-ui.tile
    variant="selectable"
    name="plan"
    value="business"
    selection-mode="single"
    title="Business"
    description="For teams that need shared administration."
    selected
/>

<x-ui.tile
    variant="expandable"
    id="billing-details"
    title="Billing details"
    description="View account billing metadata."
>
    <x-slot name="details">...</x-slot>
</x-ui.tile>

<x-ui.tile
    variant="expandable"
    title="Integration details"
    description="Internal controls keep their own targets."
    interactive
    expand-button-label="Expand integration details"
>
    <x-slot name="actions">...</x-slot>
    <x-slot name="details">...</x-slot>
</x-ui.tile>
```

## 3. Props

| Prop | Default | Allowed values | Notes |
| --- | --- | --- | --- |
| `variant` | `static` | `static`, `base`, `clickable`, `selectable`, `expandable` | `base` resolves to app-owned `static`. |
| `title` | `null` | string | Preferred visible label. |
| `description` | `null` | string | Short supporting text. |
| `href` | `null` | URL | Link-style clickable tile. |
| `type` | `button` | `button`, `submit` | Button-style clickable tile. |
| `name` | `null` | string | Selectable form field name. |
| `value` | `null` | string | Selectable form field value. |
| `selectionMode` | `single` | `single`, `multiple` | Radio-style or checkbox-style selectable tile. |
| `selected` | `false` | boolean | Semantic selected state. |
| `current` | `false` | boolean | Current navigation/detail state; emits current semantics when applicable. |
| `expanded` | `false` | boolean | Initial expandable state. |
| `disabled` | `false` | boolean | Interactive variants only. |
| `density` | `standard` | `standard`, `compact` | Internal spacing density. |
| `icon` | `null` | approved icon component | Decorative/status support only. |
| `meta` | `null` | string | Short metadata. |
| `loading` | `false` | boolean | Local pending state handoff. |
| `interactive` | `false` | boolean | Expandable-only mode that allows internal links/buttons and uses a bottom-right expansion control. |
| `expandButtonLabel` | `Toggle tile details` | string | Accessible label for interactive expandable toggle. |

Supported slots are the default content slot, `actions` for static or interactive expandable child controls, and `details` for expandable secondary content.

## 4. Variant Rules

| Variant | Required behavior |
| --- | --- |
| Static/base | Non-interactive tile. May contain approved child links or buttons because the tile itself is not a target. |
| Clickable | Entire tile is one link or one button. It must not contain independent nested controls. |
| Selectable | Entire tile represents one option. Single-select uses radio-style icons; multi-select uses checkbox-style icons. Icons remain visible in enabled state. |
| Expandable | Full tile trigger expands/collapses secondary content when no internal interactive elements are present. |
| Expandable with interactive elements | Internal links/buttons remain independent. Only the bottom-right expansion button toggles details. |

Clickable, selectable, and expandable tiles must use the feature-flag accessibility border treatment as the current standard, not as an optional variant.

## 5. Color And Layer Tokens

Tiles are their own layer surface and remain on the same visual plane as page content. They default to the first component surface layer, `--ui-layer-01`, and may be moved to the next contextual layer only by an owning parent surface or Pattern API. They must not use drop shadows.

| Role | Token |
| --- | --- |
| Container background | `$layer` through `--ui-layer-*` |
| Text | `$text-primary` |
| Secondary text | `$text-secondary` |
| Interactive border / feature flag border | `$border-tile` |
| Selected border | `$border-inverse` |
| Disabled border | `$border-disabled` |
| Focus border | `$focus` |
| Hover background | `$layer-hover` |
| Active background | `$layer-active` |
| Selected background | same `$layer` as enabled tile |
| Selected hover background | `$layer-hover` |
| Clickable icon | `$icon-interactive` |
| Selectable/expandable icon | `$icon-primary` |
| Disabled icon | `$icon-disabled` |

Contextual layer tokens must resolve according to the layer where the tile is placed. Do not set Tile to Layer 02 globally to compensate for card-heavy rendered evidence wrappers; fix the parent surface depth instead.

## 6. Structure

| Element | Property | Size | Token |
| --- | --- | ---: | --- |
| Container | `min-height` | 64px / 4rem | - |
| Container | `min-width` | 128px / 8rem | - |
| Content padding | all sides | 16px / 1rem | `$spacing-05` |
| Clickable icon | size | 20px | - |
| Selectable icon | size | 16px | - |
| Expandable icon | size | 16px | - |

Tile title typography defaults to `$body-compact-01`: 14px / 0.875rem, regular / 400.

## 7. Interaction

- Clickable tile activates from the full container.
- Selectable single-select groups allow only one selected tile at a time.
- Selectable multi-select groups allow any number of selected tiles.
- Selectable tiles update visual state and form value together.
- `Enter` and `Space` activate/toggle selectable tiles.
- Expandable tiles without internal controls expand/collapse from the full tile trigger.
- Expandable tiles with internal controls expand/collapse only from the bottom-right button.
- `Esc` closes an expanded tile and returns focus to the expansion trigger.
- Disabled interactive tiles are not pointer- or keyboard-operable.
- Reduced-motion preferences must disable nonessential transitions.

## 8. Accessibility

- Clickable tiles render as `a` or `button` as appropriate.
- Selectable tiles expose radio or checkbox semantics and `aria-checked`.
- Expandable triggers expose `aria-expanded` and `aria-controls`.
- Current clickable tiles expose current route context.
- Focus state must be visible on the operative target: tile container for clickable/selectable/full-trigger expandable tiles, expansion button for interactive expandable tiles, and child controls for static or interactive expandable content.
- Selected/current state cannot rely on color alone.
- Do not hide required information inside an expandable tile.
- Do not put interactive children inside clickable, selectable, or full-trigger expandable surfaces.

## 9. Layout And Groups

Tile groups are used when tiles have a strong relationship. Parent Patterns own group semantics and placement.

- Standard layout is the default: tiles have the same height and width.
- Vertical masonry may vary tile height while keeping consistent width.
- Horizontal masonry may vary tile width while keeping each row coherent.
- Tile groups usually flow horizontally from left to right.
- Tile groups should align to the grid and use consistent spacing.
- Tile groups should match variants. Do not mix different tile variants in one group unless the example explicitly demonstrates the boundary.

Grid proportion guidance:

| Percentage | XL 1600-1200 | L 1200-992 | M 992-768 | S 768-576 | XS 576-0 |
| --- | --- | --- | --- | --- | --- |
| 100% | Supported | Supported | Supported | Supported | Supported |
| 1/2 | Supported | Supported | Supported | Supported | Supported |
| 2/3 | Supported | Supported | Supported | Supported | Not recommended |
| 1/3 | Supported | Supported | Supported | Supported | Not recommended |
| 1/4 | Supported | Supported | Supported | Supported | Not recommended |
| 1/6 | Supported | Supported | Not recommended | Not recommended | Not recommended |

## 10. Prohibited Usage

- Do not bypass `x-ui.tile` with raw utility clusters, raw color values, local borders, local shadows, or custom JavaScript.
- Do not use Bootstrap card classes or direct Carbon implementation classes.
- Do not use drop shadows for tile elevation.
- Do not use clickable tiles for blocks with multiple destinations.
- Do not use selected/current styling as decoration.
- Do not truncate tile content so far that the tile purpose or accessible name is lost.
- Do not create custom selected icons or expansion icons.
- Do not use tiles as a substitute for data tables when column alignment, sorting, or row actions matter.

## 11. Deferred Or Pattern-Owned Capabilities

| Capability | Status | Gate |
| --- | --- | --- |
| Media tile | Deferred | Requires media slot, aspect ratio, alt text rules, lazy-loading policy, responsive proof, and tests. |
| Tile group helper | Pattern-owned | Requires `x-ui.tile-group` API, group labels, keyboard expectations, grid behavior, and tests. |
| AI presence | Gated | Requires AI presence standards, explainability disclosure, and token coverage. |
| Skeleton tile component | Pattern-owned / deferred | Requires Loading Pattern ownership, grid loading policy, and reduced-motion proof. |
| Custom density | Not allowed | Requires Spacing, Typography, and rendered evidence updates. |
| Custom border/shadow treatment | Not allowed | Requires Color, Themes, and accessibility proof. |

## 12. Rendered evidence requirements

The Tile rendered evidence page must render:

- approved variant tabs for base tile, clickable tile, selectable tile, expandable tile, and expandable tile with interactive elements
- applicable states inside each variant tab before live examples
- base tile
- clickable tile
- selectable tile
- expandable tile
- expandable tile with interactive elements
- disabled clickable, selectable, expandable, and interactive expandable states
- focused clickable, selectable, expandable, internal CTA, and expansion-button states
- single-select tile group
- multi-select tile group
- a separate layout section with tabs for standard, vertical masonry, and horizontal masonry layout
- grid proportion table
- boundary table for deferred or pattern-owned capabilities
- developer implementation snippets using `x-ui.tile`

## 13. Acceptance Criteria

- Tiles render with correct `$layer` background treatment.
- Interactive tile borders are visible.
- Base, clickable, selectable, expandable, and expandable-with-interactive variants are implemented.
- Clickable tile activates from the full container and has a bottom-right arrow icon.
- Clickable tile does not allow internal independent CTAs.
- Selectable single-select and multi-select examples work.
- Single-select tiles use radio-style icons.
- Multi-select tiles use checkbox-style icons.
- Selectable icons appear in enabled state.
- Selected selectable tiles only change the border and selection control; they do not add a custom selected background.
- Expandable tile without internal interactive elements toggles from the full container.
- Expandable tile with internal interactive elements toggles only from the bottom-right button.
- Expandable tile with interactive elements does not apply full-container hover or focus treatment; only internal controls and the expansion button show interactive states.
- Internal CTAs inside expandable tiles keep separate click targets.
- Disabled state is visually distinct and removes interaction.
- Focus state is visible for clickable, selectable, expandable, and interactive expandable expansion controls.
- Standard, vertical masonry, horizontal masonry, and grid proportion examples are present.
- Tile groups do not mix variants unless the example is explicitly about boundaries.
- Tile container minimum height is 64px and minimum width is 128px.
- Content padding follows `$spacing-05`.
- Examples do not use drop shadows.
- Documentation reflects the full tile component family.

## 14. Related APIs

| API | Route |
| --- | --- |
| Button | `not installed` |
| Icon button | `not installed` |
| Link | `not installed` |
| Checkbox | `not installed` |
| Radio button | `not installed` |
| Tag | `not installed` |
| Structured list | `not installed` |
| Data table | `not installed` |
| Loading | `not installed` |
| Inline loading | `not installed` |
| Forms pattern | `not installed` |
| Cards pattern | `not installed` |
| Navigation Pattern | `not installed` |
| Tables Pattern | `not installed` |
| Search results pattern | `not installed` |
| Color element | `not installed` |
| Spacing element | `not installed` |
| Typography element | `not installed` |
| Themes element | `not installed` |
| Motion element | `not installed` |
| 2x Grid element | `not installed` |

## 15. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Tile usage, style, and accessibility guidance inform static/clickable/selectable/expandable role boundaries, interactive affordance, accessible selected/disclosure behavior, disabled treatment, and the prohibition against nested interactive controls inside directly interactive tiles. Login App keeps its own Blade API, `ui-*` namespace, Foundation tokens, and rendered evidence proof.
