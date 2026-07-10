---
title: Tree view
slug: tree-view
status: implemented
api_layer: Component API
system_maturity: standard
category: data-display
priority: tier-c-contextual-component
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/tree-view.md
source_owner: not installed
blade_api:
  - x-ui.tree-view
javascript_api:
  - initTreeViews
data_attributes:
  - data-ui-component="tree-view"
  - data-ui-tree-view
  - data-ui-tree-node
  - data-ui-tree-node-id
  - data-ui-tree-expanded
  - data-ui-tree-selected
  - data-ui-tree-active
source_files:
  - resources/views/components/ui/tree-view/index.blade.php
  - resources/js/ui-controls/tree-views.js
  - resources/css/app.css
  - not installed
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
  - 2x-grid
related_components:
  - accordion
  - breadcrumb
  - checkbox
  - data-table
  - structured-list
  - search
  - ui-shell
  - menu-buttons
related_patterns:
  - data-content
  - navigation
  - forms
carbon_reference:
  - https://carbondesignsystem.com/components/tree-view/usage/
  - https://carbondesignsystem.com/components/tree-view/style/
  - https://carbondesignsystem.com/components/tree-view/accessibility/
  - https://carbondesignsystem.com/components/tree-view/code/
---

# Tree view Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. Installed production rules:](#31-installed-production-rules)
  - [3.2. Installed modes:](#32-installed-modes)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Props and options](#43-props-and-options)
  - [4.4. Node data contract](#44-node-data-contract)
  - [4.5. Data attribute contract](#45-data-attribute-contract)
  - [4.6. Class contract](#46-class-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Allowed token roles](#71-allowed-token-roles)
  - [7.2. CSS namespace](#72-css-namespace)
  - [7.3. Helper usage](#73-helper-usage)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use Tree view when:](#91-use-tree-view-when)
  - [9.2. Do not use Tree view when:](#92-do-not-use-tree-view-when)
  - [9.3. Component selection:](#93-component-selection)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Rendered evidence requirements](#14-ui-reference-requirements)
  - [14.1. Required Live examples internal sections:](#141-required-live-examples-internal-sections)
- [15. Testing and acceptance criteria](#15-testing-and-acceptance-criteria)
  - [15.1. Suggested automated assertions:](#151-suggested-automated-assertions)
- [16. Related APIs](#16-related-apis)
- [17. References](#17-references)

## 1. API summary

Tree view displays nested hierarchical data that users can browse, expand, collapse, and optionally select inside a bounded page region.

Canonical API owner: `not installed`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Tree view is the installed Login App 2.0 hierarchy-browse Component API. It owns tree semantics, node rendering, branch and leaf behavior, expand/collapse behavior, selected and active node treatment, optional node icons, keyboard navigation, focus management inside the tree, token-backed indentation, and tree-specific accessibility rules. It does not own global app navigation, breadcrumbs, tabular comparison, one-level disclosure, feature-specific data loading, persistence, permission rules, or external page layout.

### 1.1. Canonical API responsibilities:

- Render hierarchical browse controls through `x-ui.tree-view`.
- Render branch and leaf nodes from a stable node data contract.
- Preserve branch expand/collapse state through documented props or controlled state.
- Preserve selected and active node state without relying on color alone.
- Provide keyboard navigation across visible tree nodes.
- Use app-owned `ui-tree-view*` classes and documented `data-ui-tree-*` attributes.
- Support text-only nodes and icon-bearing nodes with consistent alignment.
- Support small and extra-small density for bounded hierarchy regions.
- Preserve visible focus, hover, active, selected, expanded, collapsed, disabled, loading, and empty states.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, icons, and 2x Grid.
- Prove branch, leaf, expansion, selection, active state, density, keyboard, accessibility, and implementation behavior on the rendered evidence page.

### 1.2. Non-owned responsibilities:

- Primary product navigation or app information architecture. Use UI shell and Navigation Pattern.
- Route hierarchy and current-page trail. Use Breadcrumb.
- One-level optional disclosure. Use Accordion.
- Horizontally comparable records. Use Data table.
- Flat comparable row content without hierarchy behavior. Use Structured list.
- Multi-select filters, bulk selection, and checkbox groups. Use Checkbox and the owning Pattern unless Tree view multi-select is explicitly enabled.
- Lazy loading, search inside tree, drag-and-drop ordering, persistence, and feature-specific action results. Feature modules and Patterns own those behaviors.
- External spacing, region headings, page layout, filter placement, and workflow orchestration. Parent Patterns own those decisions.

Carbon alignment note: Carbon defines Tree view as a nested hierarchy with branch nodes, leaf nodes, and caret controls for expanding or collapsing children. Carbon accessibility guidance emphasizes built-in keyboard operation, and Carbon code guidance separates active/selected state in its controllable implementation. Login App maps those principles to `x-ui.tree-view`, app-owned `ui-*` classes, documented node data, Foundation Element tokens, and rendered evidence proof rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                                                                                                                                                                             |
| ---------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented standard                                                                                                                                                                                                                              |
| System maturity              | Standard                                                                                                                                                                                                                                          |
| API layer                    | Component API                                                                                                                                                                                                                                     |
| Component slug               | tree-view                                                                                                                                                                                                                                         |
| Category                     | Data display                                                                                                                                                                                                                                      |
| Priority                     | Tier C - Contextual component                                                                                                                                                                                                                     |
| Rendered evidence route           | `not installed`                                                                                                                                                                                                     |
| Canonical doc                | `docs/02-standards/ui/components/tree-view.md`                                                                                                                                                                                                    |
| Source owner                 | `not installed`                                                                                                                                                                                                     |
| Blade API                    | `x-ui.tree-view`                                                                                                                                                                                                                                  |
| JavaScript API               | `initTreeViews`                                                                                                                                                                                                                                   |
| Data attributes              | `data-ui-component="tree-view"`; `data-ui-tree-view`; `data-ui-tree-node`; `data-ui-tree-node-id`; `data-ui-tree-expanded`; `data-ui-tree-selected`; `data-ui-tree-active`                                                                        |
| Props/options                | `nodes`, `selected`, `active`, `expanded`, `selectionMode`, `size`, `showIcons`, `label`, `emptyText`                                                                                                                                             |
| Source files                 | `resources/views/components/ui/tree-view/index.blade.php`; `resources/js/ui-controls/tree-views.js`; `resources/css/app.css`; `not installed` |
| CSS namespace                | App-owned `ui-tree-view*` classes                                                                                                                                                                                                                 |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons, 2x Grid                                                                                                                                                                                        |
| Carbon benchmark             | Carbon Tree view usage, style, accessibility, and code guidance                                                                                                                                                                                   |

`Implemented standard` means the canonical documentation defines the finished expected API and the rendered evidence page must prove the installed behavior with production examples. It must not present Tree view as deferred catalog content.

## 3. Installed standard

The installed standard is the `x-ui.tree-view` Blade Component API with a documented node data contract and optional JavaScript initializer for keyboard and expand/collapse behavior.

Use Tree view when a bounded page region needs to expose a nested hierarchy with more than one practical level and users need to browse, expand/collapse branches, or select one node. The component is appropriate for local hierarchies such as nested folders, permission categories, content taxonomies, documentation outlines, object trees, or feature-local browse panels.

### 3.1. Installed production rules:

- Render trees through `<x-ui.tree-view>`.
- Pass a stable `nodes` array with unique node IDs.
- Use branch nodes when a node has children.
- Use leaf nodes when a node has no children.
- Use `expanded` to control initially open branch IDs.
- Use `selected` for the persisted selected value.
- Use `active` for current keyboard/application focus when that state must be distinct from selected state.
- Use `selectionMode="single"` by default.
- Use `selectionMode="none"` for browse-only trees where nodes only expand/collapse.
- Use `selectionMode="multi"` only in Pattern-approved workflows that explicitly require multi-selection and prove keyboard behavior.
- Use `showIcons` only when icons clarify node type and remain consistent within comparable levels.
- Use `size="sm"` by default and `size="xs"` only in dense bounded panels where rendered evidence proves readability.
- Keep all expansion, selection, and active-state behavior synchronized with documented ARIA/state attributes.
- Keep keyboard navigation inside the tree consistent across all tree examples.
- Use Feature or Pattern ownership for data loading, persistence, search, lazy loading, row details, and actions triggered by node selection.
- Do not use Tree view for product navigation, task progress, single-level disclosure, tabular comparison, or decorative indentation.
- Do not build tree-like nested lists locally outside this API.

### 3.2. Installed modes:

| Mode                     | Status                            | Use                                                                    |
| ------------------------ | --------------------------------- | ---------------------------------------------------------------------- |
| Default tree             | Implemented                       | Hierarchical browse with branch and leaf nodes.                        |
| Text-only nodes          | Implemented                       | Hierarchy where labels are sufficient.                                 |
| Icon nodes               | Implemented                       | Hierarchy where node type benefits from consistent icons.              |
| Single-select tree       | Implemented                       | One selected node drives detail, preview, or local state.              |
| Browse-only tree         | Implemented                       | Nodes expand/collapse without selection.                               |
| Multi-select tree        | Implemented with Pattern approval | Multiple selected nodes are required and Checkbox is insufficient.     |
| Small tree               | Implemented                       | Default compact application hierarchy.                                 |
| Extra-small tree         | Implemented                       | Dense hierarchy inside constrained panels.                             |
| Async/lazy-loaded branch | Gated                             | Requires Loading, error, retry, persistence, and focus behavior proof. |
| Drag-and-drop tree       | Gated                             | Requires dedicated keyboard and accessibility design.                  |

## 4. Public API

### 4.1. Canonical calls

```blade
<x-ui.tree-view
    :nodes="$nodes"
    selected="workspace.security.policies"
    :expanded="['workspace', 'workspace.security']"
    label="Workspace settings"
/>
```

```blade
<x-ui.tree-view
    :nodes="$nodes"
    selection-mode="none"
    size="xs"
    label="Documentation outline"
/>
```

```blade
<x-ui.tree-view
    :nodes="$nodes"
    selected="media.images.hero"
    :expanded="$expandedNodeIds"
    show-icons
    label="Media library"
/>
```

Use the Blade API instead of hand-building nested tree markup in feature views.

### 4.2. API surfaces

| API surface               | Installed value                                                                                                                                                            |
| ------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Blade API                 | `x-ui.tree-view`                                                                                                                                                           |
| Optional internal partial | `x-ui.tree-node` or component-private recursive partial, if implementation uses one                                                                                        |
| JavaScript                | `initTreeViews` for keyboard navigation, expand/collapse synchronization, and controlled state hooks                                                                       |
| Root semantic element     | Tree root with `role="tree"` when custom semantics are used                                                                                                                |
| Node semantic element     | Node rows with `role="treeitem"` when custom semantics are used                                                                                                            |
| Data attributes           | `data-ui-component="tree-view"`, `data-ui-tree-view`, `data-ui-tree-node`, `data-ui-tree-node-id`, `data-ui-tree-expanded`, `data-ui-tree-selected`, `data-ui-tree-active` |
| CSS namespace             | `ui-tree-view*`                                                                                                                                                            |
| Source files              | `resources/views/components/ui/tree-view/index.blade.php`; `resources/js/ui-controls/tree-views.js`; `resources/css/app.css`  |

### 4.3. Props and options

| Prop/option                        | Type     | Default               | Allowed values                      | Required                                    | Notes                                                                                  |
| ---------------------------------- | -------- | --------------------- | ----------------------------------- | ------------------------------------------- | -------------------------------------------------------------------------------------- |
| `nodes`                            | `array`  | none                  | Node data contract                  | Yes                                         | Stable hierarchical node array.                                                        |
| `label`                            | `string` | none                  | Accessible tree label               | Yes unless an owning region labels the tree | Use concise region-specific label.                                                     |
| `selected`                         | `string  | null`                 | `null`                              | Node ID                                     | No                                                                                     | Selected node ID for single selection.                                         |
| `active`                           | `string  | null`                 | selected node or first visible node | Node ID                                     | No                                                                                     | Active/focused node when controlled separately.                                |
| `expanded`                         | `array`  | `[]`                  | Array of node IDs                   | No                                          | Branch IDs initially or currently expanded.                                            |
| `selectionMode` / `selection-mode` | `string` | `single`              | `none`, `single`, `multi`           | No                                          | Multi-select requires Pattern approval.                                                |
| `size`                             | `string` | `sm`                  | `sm`, `xs`                          | No                                          | `xs` is for dense bounded panels only.                                                 |
| `showIcons` / `show-icons`         | `bool`   | `false`               | `true`, `false`                     | No                                          | Use only when node type icons are meaningful and consistent.                           |
| `emptyText` / `empty-text`         | `string` | `No items available.` | Short empty message                 | No                                          | Used when nodes array is empty. Pattern may own richer empty state.                    |
| `disabled`                         | `bool`   | `false`               | `true`, `false`                     | No                                          | Disables interaction for the full tree only when required. Prefer node-level disabled. |
| `class`                            | `string  | null`                 | `null`                              | Layout passthrough if supported             | No                                                                                     | Parent Patterns may pass layout classes only; not local state/color overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and rendered evidence proof before use.

### 4.4. Node data contract

Every node must provide a stable `id` and `label`. Branch nodes include `children`. Leaf nodes omit `children` or provide an empty array.

```php
$nodes = [
    [
        'id' => 'workspace',
        'label' => 'Workspace',
        'icon' => 'apps',
        'expanded' => true,
        'selected' => false,
        'active' => false,
        'disabled' => false,
        'children' => [
            [
                'id' => 'workspace.security',
                'label' => 'Security',
                'icon' => 'settings--check',
                'children' => [
                    [
                        'id' => 'workspace.security.policies',
                        'label' => 'Policies',
                        'selected' => true,
                    ],
                ],
            ],
        ],
    ],
];
```

| Node key   | Type     | Required | Rule                                                                            |
| ---------- | -------- | -------- | ------------------------------------------------------------------------------- |
| `id`       | `string` | Yes      | Stable unique ID. Do not derive from visible label alone.                       |
| `label`    | `string` | Yes      | Visible node label.                                                             |
| `children` | `array   | null`    | No                                                                              | Presence of child nodes makes the node a branch.                             |
| `icon`     | `string  | null`    | No                                                                              | Internal icon alias/component. Requires consistent alignment.            |
| `expanded` | `bool`   | No       | Node-level initial expansion state. May be overridden by prop-level `expanded`. |
| `selected` | `bool`   | No       | Node-level selected state. May be overridden by prop-level `selected`.          |
| `active`   | `bool`   | No       | Node-level active state. May be overridden by prop-level `active`.              |
| `disabled` | `bool`   | No       | Disabled node cannot be selected or activated.                                  |
| `href`     | `string  | null`    | No                                                                              | Link-style node behavior requires Pattern approval and Link boundary review. |
| `meta`     | `array   | null`    | No                                                                              | Feature data only. Must not alter component rendering unless documented.     |

### 4.5. Data attribute contract

| Attribute                       | Status      | Purpose                                                  |
| ------------------------------- | ----------- | -------------------------------------------------------- |
| `data-ui-component="tree-view"` | Implemented | Identifies the component root for diagnostics and tests. |
| `data-ui-tree-view`             | Implemented | Marks a tree root for initializer behavior.              |
| `data-ui-tree-node`             | Implemented | Marks a rendered node row.                               |
| `data-ui-tree-node-id`          | Implemented | Stores stable node ID for state synchronization.         |
| `data-ui-tree-expanded`         | Implemented | Mirrors branch expanded/collapsed state.                 |
| `data-ui-tree-selected`         | Implemented | Mirrors selected state.                                  |
| `data-ui-tree-active`           | Implemented | Mirrors active/focused node state.                       |

Feature views must not invent additional `data-ui-tree-*` attributes without updating this standard.

### 4.6. Class contract

| Class                           | Type      | Status                                              | Purpose                                                               |
| ------------------------------- | --------- | --------------------------------------------------- | --------------------------------------------------------------------- |
| `ui-tree-view`                  | Root      | Implemented                                         | Tree root wrapper.                                                    |
| `ui-tree-view--sm`              | Size      | Implemented                                         | Default compact tree size.                                            |
| `ui-tree-view--xs`              | Size      | Implemented                                         | Extra-small dense tree.                                               |
| `ui-tree-view--with-icons`      | Modifier  | Implemented                                         | Icon-bearing node alignment.                                          |
| `ui-tree-view--disabled`        | State     | Implemented                                         | Full-tree disabled treatment.                                         |
| `ui-tree-view__list`            | Element   | Implemented                                         | Root or child list container.                                         |
| `ui-tree-view__item`            | Element   | Implemented                                         | Node list item wrapper.                                               |
| `ui-tree-view__node`            | Element   | Implemented                                         | Interactive node row.                                                 |
| `ui-tree-view__node-button`     | Element   | Implemented                                         | Branch expand/collapse and activation target when rendered as button. |
| `ui-tree-view__node-label`      | Element   | Implemented                                         | Visible node label.                                                   |
| `ui-tree-view__node-icon`       | Element   | Implemented                                         | Optional node icon.                                                   |
| `ui-tree-view__caret`           | Element   | Implemented                                         | Branch expansion indicator.                                           |
| `ui-tree-view__children`        | Element   | Implemented                                         | Child node container.                                                 |
| `ui-tree-view__empty`           | Element   | Implemented                                         | Empty hierarchy fallback.                                             |
| `ui-tree-view__loading`         | Element   | Implemented for component-local branch loading only | Use only with gated async branch behavior.                            |
| `ui-tree-view__node--branch`    | Node type | Implemented                                         | Node has children.                                                    |
| `ui-tree-view__node--leaf`      | Node type | Implemented                                         | Node has no children.                                                 |
| `ui-tree-view__node--expanded`  | State     | Implemented                                         | Branch is expanded.                                                   |
| `ui-tree-view__node--collapsed` | State     | Implemented                                         | Branch is collapsed.                                                  |
| `ui-tree-view__node--selected`  | State     | Implemented                                         | Node is selected.                                                     |
| `ui-tree-view__node--active`    | State     | Implemented                                         | Node is active/current focus target.                                  |
| `ui-tree-view__node--disabled`  | State     | Implemented                                         | Node is disabled.                                                     |

Feature views must not create additional `tree-*`, `nested-list-*`, local `ui-tree-*`, Bootstrap, or Carbon classes for the same role. New classes require source implementation, this standard update, rendered evidence proof, and tests.

## 5. Allowed variants, options, and modifiers

| Name                         | Type      | Status           | API                                                      | Use when                                                                           | Do not use when                                               |
| ---------------------------- | --------- | ---------------- | -------------------------------------------------------- | ---------------------------------------------------------------------------------- | ------------------------------------------------------------- |
| Default tree                 | Variant   | Implemented      | `x-ui.tree-view`                                         | Users need nested hierarchy browse.                                                | A single-level disclosure is enough.                          |
| Text-only nodes              | Variant   | Implemented      | default nodes                                            | Labels are enough to distinguish node type.                                        | Node types must be visually differentiated.                   |
| Icon nodes                   | Variant   | Implemented      | `show-icons` and node `icon`                             | Icons clarify node type consistently.                                              | Icons are decorative or inconsistent across comparable nodes. |
| Small size                   | Size      | Implemented      | `size="sm"`                                              | Default tree density.                                                              | Dense panel needs `xs`.                                       |
| Extra-small size             | Size      | Implemented      | `size="xs"`                                              | Constrained panels with dense hierarchies.                                         | Touch target/readability would suffer.                        |
| Browse-only                  | Mode      | Implemented      | `selectionMode="none"`                                   | Tree is used only to expand/collapse and reveal hierarchy.                         | Selection drives detail or state.                             |
| Single select                | Mode      | Implemented      | `selectionMode="single"`                                 | One node drives detail, preview, navigation, or filter.                            | Multiple nodes must be selected.                              |
| Multi-select                 | Mode      | Pattern-approved | `selectionMode="multi"`                                  | A hierarchy requires multiple selected nodes and Checkbox groups are insufficient. | A flat multi-select set would work.                           |
| Branch node                  | Node type | Implemented      | node with `children`                                     | Node has child nodes.                                                              | Node has no children.                                         |
| Leaf node                    | Node type | Implemented      | node without `children`                                  | Node is terminal.                                                                  | Node can expand.                                              |
| Expanded branch              | State     | Implemented      | node `expanded`; `expanded` prop; `aria-expanded="true"` | Children are visible.                                                              | Leaf node.                                                    |
| Collapsed branch             | State     | Implemented      | absence of expanded state; `aria-expanded="false"`       | Children are hidden.                                                               | Leaf node.                                                    |
| Selected node                | State     | Implemented      | `selected` prop or node `selected`                       | Node is the selected value.                                                        | Active focus only.                                            |
| Active node                  | State     | Implemented      | `active` prop or node `active`                           | Current keyboard/application focus differs from selected.                          | Selected state is enough.                                     |
| Disabled node                | State     | Implemented      | node `disabled`                                          | Node is unavailable.                                                               | Node needs to remain selectable.                              |
| Async branch loading         | Modifier  | Gated            | none until approved                                      | Child nodes load after branch expansion.                                           | All nodes are available at render time.                       |
| Drag-and-drop ordering       | Modifier  | Gated            | none                                                     | Product requires hierarchy reordering.                                             | Basic browse/selection.                                       |
| Tree as app navigation       | Usage     | Not allowed      | none                                                     | Never.                                                                             | Use UI shell and Breadcrumb.                                  |
| Tree as one-level disclosure | Usage     | Not allowed      | none                                                     | Never.                                                                             | Use Accordion or visible sections.                            |

## 6. States

| State                        | Status                            | Implementation requirement                                                                      |
| ---------------------------- | --------------------------------- | ----------------------------------------------------------------------------------------------- |
| Default                      | Implemented                       | Renders a readable hierarchy with app-owned classes and no local feature styling.               |
| Hover                        | Implemented                       | Node hover uses token-backed surface/text treatment where pointer hover is available.           |
| Focus-visible                | Implemented                       | Active node has visible focus in every supported theme.                                         |
| Active                       | Implemented                       | Active node identifies current keyboard/application target and may differ from selected.        |
| Selected                     | Implemented                       | Selected node is visually clear and announced without relying on color alone.                   |
| Expanded branch              | Implemented                       | Branch exposes `aria-expanded="true"` and visible child nodes.                                  |
| Collapsed branch             | Implemented                       | Branch exposes `aria-expanded="false"` and hides child nodes.                                   |
| Leaf node                    | Implemented                       | Leaf node does not expose expand/collapse affordance.                                           |
| Disabled                     | Implemented                       | Disabled node cannot be selected or activated and has token-backed disabled treatment.          |
| Browse-only                  | Implemented                       | Tree can reveal hierarchy without selected state.                                               |
| Empty                        | Implemented                       | Empty hierarchy renders short empty text or a Pattern-owned empty state.                        |
| Loading                      | Gated                             | Async branch loading requires Loading handoff, retry/error behavior, and focus rules.           |
| Error                        | Gated                             | Async branch error requires retry and recovery behavior.                                        |
| Read-only                    | Not applicable by default         | Use browse-only mode or data display; Tree view is interactive hierarchy by default.            |
| Validation                   | Not applicable by default         | Tree view is not a form validation component unless a Pattern owns a selection workflow.        |
| Success/warning/info         | Not applicable                    | Use Notification or status Pattern for outcome messaging.                                       |
| Expanded/collapsed animation | Implemented                       | Uses Motion tokens and respects reduced-motion preferences.                                     |
| Overflow/truncated           | Implemented through content rules | Labels may truncate only when full value remains available through approved accessible handoff. |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Tree view consumes Foundation Color, Spacing, Typography, Themes, Motion, Icons, and 2x Grid where composed into page or panel layout.

Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons.
- 2x Grid.

### 7.1. Allowed token roles

| Element API | Allowed usage                                                                                                                                     |
| ----------- | ------------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Node text, caret icon, optional node icon, selected surface, active/focus treatment, disabled state, hover, borders, and theme-specific contrast. |
| Spacing     | Node indentation, parent/child nesting, control-label gaps, node padding, dense hierarchy spacing, and bounded region relationships.              |
| Typography  | Node labels, optional group labels, empty text, dense hierarchy text, and truncation behavior.                                                    |
| Themes      | Light, dark, inverse, and layered token resolution for all states.                                                                                |
| Motion      | Expand/collapse timing, caret rotation, state transitions, and reduced-motion behavior.                                                           |
| Icons       | Caret and optional node-type icons from the approved icon set.                                                                                    |
| 2x Grid     | Placement in panels, drawers, cards, and page regions through Pattern-owned layout.                                                               |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$layer` | Tree node/background surface | `ui-tree-view__node` surface role | App layer palette | Same role / app value | Tree nodes share layer surface roles with menus and selectable lists. |
| `$layer-hover`, `$layer-selected` | Node hover and selected backgrounds | Tree node state roles | App layer state palette | Same role / app value | State roles must match Structured list/Data table selectable surfaces. |
| `$border-interactive` | Selected node border-left | Tree selected indicator role | App border-interactive palette | Same role / app value | Selected/current indicators use shared interactive border role. |
| `$text-secondary`, `$text-disabled` | Node label and disabled label | Tree label text roles | App text palette | Same role / app value | Tree text does not define local muted colors. |
| `$icon-primary`, `$icon-secondary`, `$icon-disabled` | Caret/node icons by state | Tree icon roles | App icon palette | Same role / app value | Caret rotation uses Motion; color uses Icon roles. |
| `$focus` | Focusable node treatment | Tree node focus-visible state | App focus palette | Same role / app value | Focus applies to interactive tree items. |

### 7.2. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation.

```css
.ui-tree-view
.ui-tree-view--sm
.ui-tree-view--xs
.ui-tree-view--with-icons
.ui-tree-view--disabled
.ui-tree-view__list
.ui-tree-view__item
.ui-tree-view__node
.ui-tree-view__node-button
.ui-tree-view__node-label
.ui-tree-view__node-icon
.ui-tree-view__caret
.ui-tree-view__children
.ui-tree-view__empty
.ui-tree-view__loading
.ui-tree-view__node--branch
.ui-tree-view__node--leaf
.ui-tree-view__node--expanded
.ui-tree-view__node--collapsed
.ui-tree-view__node--selected
.ui-tree-view__node--active
.ui-tree-view__node--disabled
```

Feature views must not use direct Carbon production classes such as `cds--tree-view`, `cds--tree-node`, `bx--tree-view`, or `bx--tree-node`. Feature views must not create local nested-list classes, raw indentation utilities, arbitrary caret icons, hard-coded focus rings, or custom tree JavaScript.

### 7.3. Helper usage

| Helper/mechanism        | Status                             | Rule                                                                                             |
| ----------------------- | ---------------------------------- | ------------------------------------------------------------------------------------------------ |
| `x-ui.tree-view`        | Approved                           | Required Blade API for tree rendering.                                                           |
| `initTreeViews`         | Approved                           | Initializes keyboard navigation and expansion synchronization where static markup is not enough. |
| Node array contract     | Approved                           | Required input data shape for hierarchy rendering.                                               |
| Laravel route helpers   | Approved with Pattern ownership    | Use only when a node navigates and Link boundary is documented.                                  |
| `aria-expanded`         | Required for branches              | Must match visible expanded/collapsed state.                                                     |
| `aria-selected`         | Required for selectable nodes      | Must match selected state.                                                                       |
| `aria-disabled`         | Required for disabled custom nodes | Must match disabled state when native disabled is not available.                                 |
| `data-ui-tree-*`        | Approved                           | Use only documented attributes.                                                                  |
| Local ARIA tree widgets | Not allowed                        | Use the component API; do not create custom ARIA trees locally.                                  |

## 8. Composition rules

- Use Tree view only inside a bounded page region, panel, card, drawer, or Pattern-owned browse surface.
- Use the component for hierarchies with more than one practical level.
- Keep branch and leaf behavior visually distinct.
- Keep node labels visible and scannable.
- Keep child nodes visually nested under their parent through token-backed indentation.
- Keep caret controls tied to expandable branch nodes only.
- Do not show a caret on leaf nodes.
- Use selected state when a node selection drives detail, preview, filter, or local page state.
- Use active state when keyboard focus or current application target must be distinct from selected state.
- Use browse-only mode when nodes expand/collapse but no node is selected.
- Do not place arbitrary nested form fields, buttons, menus, inputs, or tooltips inside node labels unless a Pattern owns the composite behavior.
- Do not use Tree view as the primary product navigation shell.
- Do not replace Breadcrumb with Tree view.
- Do not replace Accordion for simple one-level disclosure.
- Do not replace Data table for horizontally scannable record comparison.
- Parent Patterns own external spacing, headings, filters, empty states, loading states, persistence, route/data actions, and workflow orchestration.
- Components own internal node semantics, node rendering, node focus, expand/collapse behavior, selected/active state presentation, and hierarchy spacing.

## 9. Selection guidance

### 9.1. Use Tree view when:

- Users need to browse a nested hierarchy with more than one practical level.
- Branch nodes need expand/collapse behavior.
- Leaf nodes need clear selection, activation, or browse behavior.
- The hierarchy is too dense or repetitive for visible sections.
- Accordion would only support a shallow disclosure model.
- Data table would force a false column structure.
- UI shell navigation is inappropriate because the hierarchy is local to a page, panel, or workflow.

### 9.2. Do not use Tree view when:

- The hierarchy has only one level; use Accordion, visible sections, Structured list, or Data table.
- The content is app-wide product navigation; use UI shell navigation and Breadcrumb.
- Users need to compare row attributes across columns; use Data table.
- Users need to choose from a small visible set; use Checkbox, Radio button, Tile, or Structured list.
- Users need command groups; use Menu buttons.
- Users need nested form fields; use Forms Pattern and visible field groups.
- Users need task progress; use Progress indicator when installed.
- The goal is only to indent text; use headings, lists, or layout Patterns.

### 9.3. Component selection:

| Need                                            | Use                           |
| ----------------------------------------------- | ----------------------------- |
| Nested local hierarchy with expandable branches | Tree view                     |
| One-level reveal/hide content                   | Accordion                     |
| App route hierarchy/current location            | Breadcrumb plus UI shell      |
| Primary product navigation                      | UI shell / Navigation Pattern |
| Tabular row comparison                          | Data table                    |
| Comparable non-tabular row content              | Structured list               |
| Small independent multi-select choices          | Checkbox                      |
| Exactly one visible choice                      | Radio button                  |
| Long flat option list                           | Select                        |

## 10. Accessibility contract

- Tree view must use the installed component API rather than local ARIA tree markup.
- The tree root must have an accessible label through the `label` prop, `aria-label`, `aria-labelledby`, or an owning region that clearly labels the tree.
- When custom tree semantics are used, the root must expose `role="tree"`.
- When custom tree semantics are used, nodes must expose `role="treeitem"`.
- Branch nodes must expose `aria-expanded="true"` or `aria-expanded="false"`.
- Leaf nodes must not expose `aria-expanded`.
- Selectable nodes must expose selected state through `aria-selected` or an equivalent native/ARIA contract.
- Disabled nodes must expose disabled state through `aria-disabled` or an equivalent native/ARIA contract.
- The tree must provide a predictable keyboard model for visible nodes.
- Tab moves focus into and out of the tree.
- Up and Down Arrow move between visible nodes.
- Right Arrow expands a collapsed branch or moves into an expanded branch according to the installed interaction model.
- Left Arrow collapses an expanded branch or returns focus to the parent branch according to the installed interaction model.
- Enter or Space activates or selects the focused node according to the installed selection mode.
- Focus-visible treatment must be visible in all supported themes.
- Selected and active states must not rely on color alone.
- Disabled nodes must maintain readable contrast and clear non-interactive state.
- Expand/collapse animation must respect reduced-motion preferences.
- If Tree view is composed inside a modal, drawer, or panel, that parent Pattern owns focus entry, dismissal, and focus return.
- Screen reader behavior must be tested for branch, leaf, expanded, collapsed, selected, active, and disabled states.

## 11. Content contract

- Use sentence case for node labels.
- Branch labels summarize the child nodes they contain.
- Leaf labels describe the destination or item clearly.
- Labels must be short, concrete, and scannable.
- Avoid vague node names such as `More`, `Other`, `Details`, or `Items` when a specific label is available.
- Use consistent grammar and label patterns at the same hierarchy level.
- Long labels may truncate only when the full value remains available through an approved accessible handoff.
- If node icons are used, use them consistently across comparable nodes at the same hierarchy level.
- Do not mix text-only and icon-bearing nodes in a way that breaks label alignment.
- Do not use icon decoration to create false hierarchy.
- Empty text must be short and specific, such as `No folders available.`

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not present Tree view as deferred or as only a future target in this standards doc.
- Do not create local expandable nested lists and call them Tree view.
- Do not use Tree view for primary product navigation.
- Do not use Tree view for wizard steps or progress.
- Do not use Tree view for one-level disclosure.
- Do not use Tree view for tabular data comparison.
- Do not use nested accordions as a local substitute for Tree view.
- Do not place unrelated controls into a tree node for visual density.
- Do not use direct Carbon production classes such as `cds--tree-view`, `cds--tree-node`, `bx--tree-view`, or `bx--tree-node`.
- Do not introduce local ARIA tree roles without using the installed tree API and its keyboard model.
- Do not hard-code indentation, caret rotation, selected colors, focus rings, or disabled states.
- Do not render fake controls for gated capabilities such as lazy loading, drag-and-drop, or tree search.

## 13. Deferred or gated capabilities

The standard Tree view API is implemented. The following advanced capabilities remain gated because they require additional product behavior, persistence, and accessibility proof.

| Capability                | Status           | Gate or trigger condition                                                                                   | Local workaround allowed?       |
| ------------------------- | ---------------- | ----------------------------------------------------------------------------------------------------------- | ------------------------------- |
| Search/filter inside tree | Gated            | Requires query behavior, result highlighting, empty results, keyboard behavior, and Pattern ownership.      | No.                             |
| Lazy-loaded child nodes   | Gated            | Requires Loading, error, retry, expanded-state persistence, and focus behavior.                             | No.                             |
| Async branch error/retry  | Gated            | Requires Notification/Loading handoff, retry action, and announcement behavior.                             | No.                             |
| Drag-and-drop ordering    | Gated            | Requires keyboard reordering model, pointer model, announcement behavior, persistence, and tests.           | No.                             |
| Link-navigation nodes     | Gated            | Requires Link boundary review, route behavior, current-state mapping, and Breadcrumb/UI shell relationship. | No.                             |
| Rich node content         | Gated            | Requires composition rules for badges, counts, menus, and descriptions inside nodes.                        | No.                             |
| Multi-select tree         | Pattern-approved | Requires a real workflow that cannot be represented by Checkbox groups and full accessibility proof.        | No local custom implementation. |
| Virtualized tree          | Gated            | Requires focus, screen reader, scroll, active descendant, and performance review.                           | No.                             |
| Context menus on nodes    | Gated            | Requires Menu buttons ownership, focus return, keyboard behavior, and selected/active state rules.          | No.                             |

Future extensions require an updated Component standard and rendered evidence proof before production use.

## 14. Rendered evidence requirements

The rendered evidence page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

The Tree view page is a behavior-heavy component reference page. The Live examples card should use scenario sections, keyboard notes, state matrices, hierarchy examples, implementation examples, and related-boundary comparisons rather than a placeholder deferred page.

### 14.1. Required Live examples internal sections:

| Required proof                    | Rendered behavior                                                                                                                                      | Variants/options shown                                                              |
| --------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------- |
| API status proof                  | Page states Tree view is an implemented standard and shows the installed Blade, JS, data attribute, and class APIs.                                    | `x-ui.tree-view`, `initTreeViews`, `ui-tree-view`                                   |
| Default hierarchy                 | Tree renders branch nodes, leaf nodes, caret controls, expanded/collapsed branches, and nested child indentation.                                      | Branch, Leaf, Expanded, Collapsed, Caret                                            |
| Text-only tree                    | Tree renders labels without icons and preserves alignment.                                                                                             | Text-only nodes, Small size                                                         |
| Icon tree                         | Tree renders consistent node icons and caret alignment.                                                                                                | Icon nodes, `show-icons`, Small size                                                |
| Size/density matrix               | Small and extra-small sizes render with readable labels and focus treatment.                                                                           | `sm`, `xs`, Focus-visible                                                           |
| Selection state matrix            | Selected and active states render separately and without color-only meaning.                                                                           | Selected, Active, Default, Hover                                                    |
| Browse-only tree                  | Tree expands/collapses without selected node state.                                                                                                    | `selectionMode="none"`, Expanded/collapsed                                          |
| Disabled node                     | Disabled node renders with non-interactive behavior and accessible disabled state.                                                                     | Disabled branch, Disabled leaf                                                      |
| Empty tree                        | Empty hierarchy renders short empty text or Pattern-owned empty state handoff.                                                                         | Empty                                                                               |
| Keyboard behavior proof           | Page documents and demonstrates Tab, Arrow, Enter, and Space behavior.                                                                                 | Keyboard, Focus, Active descendant/active node                                      |
| Accessibility proof               | Page shows labels, roles, `aria-expanded`, selected state, disabled state, visible focus, non-color-only meaning, and reduced-motion expectations.     | `role="tree"`, `role="treeitem"`, `aria-expanded`, `aria-selected`, `aria-disabled` |
| Selection guidance matrix         | Page distinguishes Tree view from Accordion, Breadcrumb, UI shell, Data table, Structured list, Checkbox, Radio button, and Select.                    | Tree view, Accordion, Breadcrumb, UI shell, Data table                              |
| Prohibited usage proof            | Page shows product navigation, one-level disclosure, tabular comparison, nested accordions, local ARIA trees, and direct Carbon classes as prohibited. | Boundary examples, Prohibited usage                                                 |
| Deferred gate proof               | Page shows gated conditions for tree search, lazy loading, drag-and-drop, rich node content, virtualization, and context menus.                        | Gated capabilities                                                                  |
| Foundation Elements proof         | Page shows consumed Foundation Elements and token responsibilities.                                                                                    | Color, Spacing, Typography, Themes, Motion, Icons, 2x Grid                          |
| Developer implementation examples | Canonical `x-ui.tree-view` calls and node data contracts render as real code examples.                                                                 | Blade call, Node data, Data attributes                                              |

The page must not display generic fallback/reference sections or placeholder developer comments. It must not represent the component as deferred. It must show the actual installed/expected API, rendered hierarchy examples, state behavior, keyboard behavior, accessibility behavior, prohibited usage, gated advanced capabilities, and consumed Foundation Elements.

## 15. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples.
- Gated APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The page identifies Tree view as `Implemented standard` and does not present Tree view as deferred.
- The page shows `x-ui.tree-view`, `initTreeViews`, documented `data-ui-tree-*` attributes, and `ui-tree-view` classes.
- The page renders default hierarchy, text-only, icon-bearing, selected, active, expanded, collapsed, disabled, browse-only, empty, small, and extra-small examples.
- The page documents keyboard behavior for Tab, Up Arrow, Down Arrow, Right Arrow, Left Arrow, Enter, and Space.
- The page documents `role="tree"`, `role="treeitem"`, `aria-expanded`, `aria-selected`, `aria-disabled`, accessible label, visible focus, and non-color-only state requirements.
- The page distinguishes Tree view from Accordion, Breadcrumb, UI shell, Data table, Structured list, Checkbox, Radio button, Select, and Menu buttons.
- The page documents gated behavior for tree search/filtering, lazy loading, async branch errors, drag-and-drop, rich node content, virtualization, and context menus.
- Tests assert no generic placeholder content appears.
- Tests assert stale labels such as `Component-specific API pending correction`, `Deferred status`, `No production Tree view API is approved`, `reserved future target`, `Live Examples Card`, `Reference Examples`, and `Legacy Contract Summary` remain absent.
- Tests assert no `tier-1`, `tier-2`, direct Carbon production class names, Bootstrap collapse/tree classes, hard-coded colors, arbitrary local indentation, local icons, custom feature JavaScript, or local ARIA tree examples are presented as approved.

### 15.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Tree view');
$response->assertSee('Implemented standard');
$response->assertSee('x-ui.tree-view');
$response->assertSee('initTreeViews');
$response->assertSee('ui-tree-view');
$response->assertSee('data-ui-tree-node');
$response->assertSee('Default hierarchy');
$response->assertSee('Text-only tree');
$response->assertSee('Icon tree');
$response->assertSee('Selected');
$response->assertSee('Active');
$response->assertSee('Expanded');
$response->assertSee('Collapsed');
$response->assertSee('Disabled');
$response->assertSee('Browse-only');
$response->assertSee('role=&quot;tree&quot;', false);
$response->assertSee('aria-expanded');
$response->assertSee('aria-selected');
$response->assertSee('Tab');
$response->assertSee('Arrow');
$response->assertSee('Color');
$response->assertSee('Spacing');
$response->assertSee('Typography');
$response->assertSee('Themes');
$response->assertSee('Motion');
$response->assertSee('Icons');
$response->assertSee('2x Grid');
$response->assertDontSee('Deferred status');
$response->assertDontSee('No production Tree view API is approved');
$response->assertDontSee('reserved future target');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--tree-view');
$response->assertDontSee('bx--tree-view');
```

## 16. Related APIs

| API                            | Route                                                                |
| ------------------------------ | -------------------------------------------------------------------- |
| Components overview            | `not installed`                                  |
| Accordion                      | `not installed`                        |
| Breadcrumb                     | `not installed`                       |
| Data table                     | `not installed`                       |
| Structured list                | `not installed`                  |
| Checkbox                       | `not installed`                         |
| Radio button                   | `not installed`                     |
| Search                         | `not installed`                           |
| Select                         | `not installed`                           |
| Menu buttons                   | `not installed`                     |
| UI shell                       | `not installed`                         |
| Navigation pattern             | `not installed`                         |
| Data/content patterns          | `not installed`                       |
| Forms pattern                  | `not installed`                              |
| Color element                  | `not installed`                              |
| Spacing element                | `not installed`                            |
| Typography element             | `not installed`                         |
| Themes element                 | `not installed`                             |
| Motion element                 | `not installed`                             |
| Icons element                  | `not installed`                              |
| 2x Grid element                | `not installed`                            |
| Canonical tree view doc        | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Ftree-view.md`  |
| Carbon tree view usage         | `https://carbondesignsystem.com/components/tree-view/usage/`         |
| Carbon tree view accessibility | `https://carbondesignsystem.com/components/tree-view/accessibility/` |

## 17. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Tree view usage guidance informs branch, leaf, caret, nested hierarchy, and related-component boundaries. Login App keeps its own `x-ui.tree-view` API, `ui-*` namespace, node data contract, Foundation Element tokens, and rendered evidence proof.
- Carbon Tree view accessibility guidance informs keyboard operation, focus expectations, ARIA tree/treeitem behavior, expanded/collapsed state, selected state, and screen reader testing requirements.
- Carbon Tree view code guidance informs the distinction between selected and active state in controllable implementations; Login App defines those roles directly in this standard.