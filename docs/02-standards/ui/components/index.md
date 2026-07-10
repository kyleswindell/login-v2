# Component API Standards
- [1. Component Matrix](#1-component-matrix)
- [2. Component Build-Order Tiers](#2-component-build-order-tiers)
- [3. Component Page Contract](#3-component-page-contract)
- [4. Foundation Element Dependency](#4-foundation-element-dependency)
- [5. Component Checklist Template](#5-component-checklist-template)
  - [5.1. Implementation checklist](#51-implementation-checklist)
  - [5.2. rendered evidence proof checklist](#52-ui-reference-proof-checklist)
- [6. Component contract.php File](#6-component-contractphp-file)
- [7. Related](#7-related)

Component standards define primitive and baseline reusable UI APIs. The rendered evidence labels this layer as **Components**.

Use this index for day-to-day lookup. The owning `components/{component}.md` file remains the full API standard.

Current installed Component Blade source lives under `resources/views/components/ui/{component}/index.blade.php`, with related partials beside the parent folder. Treat deleted flat files such as `resources/views/components/ui/{component}.blade.php` as stale references unless they still exist in the working tree.

## 1. Component Matrix

| Component          | Disposition            | Public API / surface                                                                         | Approved variants/options summary                                                                                                        | Rendered evidence route                                     |
| ------------------ | ---------------------- | -------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------ |
| Accordion          | Approved API           | `x-ui.accordion`, `initAccordions`                                                           | default/contained, compact, scrollable, multiple/single-open                                                                             | `not installed`          |
| AI label           | Do not implement       | No public API approved                                                                       | gated until product AI decision                                                                                                          | `not installed`           |
| Breadcrumb         | Approved API           | `x-ui.breadcrumb`                                                                            | small/medium, overflow, current-page-listed                                                                                              | `not installed`         |
| Button             | Approved API           | `x-ui.button`, `x-ui.icon-button`                                                            | primary, secondary, tertiary, ghost, danger, sizes, groups, icon usage                                                                   | `not installed`             |
| Checkbox           | Approved API           | `x-ui.checkbox` or native-plus-`ui-*` class API                                              | checked, unchecked, indeterminate, disabled, readonly, validation                                                                        | `not installed`           |
| Code snippet       | Approved API           | `x-ui.code-snippet`                                                                          | single-line, multi-line, highlighted tokens, copy disposition                                                                            | `not installed`       |
| Combo box          | Queued gap             | No public API approved                                                                       | typed filtering, clear control, custom-value gate, keyboard contract                                                                     | `not installed`          |
| Contained list     | Approved API           | `x-ui.contained-list`, `x-ui.contained-list-item`                                            | on-page/disclosed, small/medium/large rows, linked/current/status/empty rows                                                             | `not installed`     |
| Content switcher   | Approved API           | `x-ui.content-switcher`, `initContentSwitchers`                                              | default, compact, icon with label, disabled, local panel, no-panel mode                                                                  | `not installed`   |
| Data table         | Approved API           | `x-ui.data-table`, `x-ui.data-table.toolbar`                                                 | row sizes, sortable, toolbar, row actions, loading, empty, error, responsive overflow, pagination composition; selection/expansion gated | `not installed`         |
| Date picker        | Approved API           | `x-ui.date-picker`, `x-ui.date-picker-input`, `x-ui.date-picker-skeleton`, `initDatePickers` | simple input, single calendar, range calendar, skeleton, validation, disabled/readonly                                                   | `not installed`        |
| Dropdown           | Approved API           | `x-ui.dropdown`                                                                              | known-option menu selection, validation, disabled/readonly                                                                               | `not installed`           |
| File uploader      | Approved API           | `x-ui.file-uploader`                                                                         | button upload, validation, disabled; drag/drop deferred                                                                                  | `not installed`      |
| Form               | Represented by pattern | Forms Pattern owner                                                                          | component catalog disposition; composition-owned form behavior                                                                           | `not installed`               |
| Inline loading     | Approved API           | `x-ui.inline-loading`                                                                        | action pending, local save pending, polite status                                                                                        | `not installed`     |
| Link               | Approved API           | `x-ui.link`                                                                                  | inline, external/help, icon-leading/trailing, disabled treatment                                                                         | `not installed`               |
| List               | Approved API           | native `ul`/`ol`/`li` plus approved list class/content contract                              | ordered, unordered, nested boundary, content-list guidance                                                                               | `not installed`               |
| Loading            | Approved API           | `x-ui.loading`                                                                               | large, small, overlay, page, component, section, modal, side-panel, tile, inline                                                         | `not installed`            |
| Menu               | Approved API           | `x-ui.menu` / item/menu behavior surface                                                     | action item, divider, shortcut, submenu boundary, danger, selected, sizes                                                                | `not installed`               |
| Menu buttons       | Approved API           | `x-ui.menu-button`, `x-ui.combo-button`, `x-ui.overflow-menu`                                | menu button, combo button, overflow menu, sizes, ghost                                                                                   | `not installed`       |
| Modal              | Approved API           | `x-ui.modal` where installed                                                                 | confirmation, form, detail, destructive, sizes, focus behavior                                                                           | `not installed`              |
| Multiselect        | Approved API           | `x-ui.multi-select`; `x-ui.filterable-multi-select`                                          | default, filterable, selected count, select all, disabled/read-only, validation                                                          | `not installed`        |
| Notification       | Approved API           | `x-ui.notification.inline`, `x-ui.notification.toast`, notification family partials          | success, error, warning, info, actionable, persistent handoff                                                                            | `not installed`       |
| Number input       | Approved API           | `x-ui.number-input`                                                                          | min/max/step, increment/decrement, validation, compact/fluid                                                                             | `not installed`       |
| Pagination         | Approved API           | `x-ui.pagination`                                                                            | pagination bar, pagination nav, page size, page selector, looping, overflow                                                              | `not installed`         |
| Popover            | Approved API           | `x-ui.popover`                                                                               | placement, alignment, size, caret, closeable, open, disabled                                                                             | `not installed`            |
| Progress bar       | Approved API           | `x-ui.progress-bar`                                                                          | determinate, indeterminate disposition, completion states                                                                                | `not installed`       |
| Progress indicator | Approved API           | `x-ui.progress-indicator`, `x-ui.progress-step`                                              | horizontal/vertical, current, complete, error, disabled                                                                                  | `not installed` |
| Radio button       | Approved API           | `x-ui.radio-button`, `x-ui.radio-group`                                                      | vertical/horizontal group, selected, disabled, readonly, validation                                                                      | `not installed`       |
| Search             | Approved API           | `x-ui.search`                                                                                | page search, table search, clear action, loading/no-results                                                                              | `not installed`             |
| Select             | Approved API           | `x-ui.select`                                                                                | native short selection, validation, disabled/readonly                                                                                    | `not installed`             |
| Slider             | Approved API           | `x-ui.slider`                                                                                | single/range, visible value, exact input, endpoints, sizes, validation                                                                   | `not installed`             |
| Structured list    | Approved API           | `x-ui.structured-list`, `x-ui.structured-list-row`                                           | default, selectable, condensed, selected/focus/disabled/skeleton                                                                         | `not installed`    |
| Tabs               | Approved API           | `x-ui.tabs`                                                                                  | line, contained, vertical, scrollable, icons, secondary labels, dismissible                                                              | `not installed`               |
| Tag                | Approved API           | `x-ui.tag`; grouping is composed by Pattern API `x-patterns.tag-group`                       | metadata, dismissible filters, selectable choices, operational disclosure                                                                | `not installed`                |
| Text input         | Approved API           | `x-ui.text-input` or native-plus-`ui-*` class API                                            | default, password/search handoff, readonly, disabled, validation                                                                         | `not installed`         |
| Tile               | Approved API           | `x-ui.tile`                                                                                  | static, clickable, selectable, expandable, disabled disposition                                                                          | `not installed`               |
| Toggle             | Approved API           | `x-ui.toggle`                                                                                | on, off, disabled, readonly, helper text                                                                                                 | `not installed`             |
| Toggletip          | Approved API           | `x-ui.toggletip`                                                                             | contextual help, dismissible rich help, form assistance                                                                                  | `not installed`          |
| Tooltip            | Approved API           | `x-ui.tooltip`                                                                               | icon-only, definition, disabled-control explanation                                                                                      | `not installed`            |
| Tree view          | Approved API           | `x-ui.tree-view`, tree-node hooks, `initTreeViews`                                           | expandable/collapsible, selected/current, search/filter handoff, async gate                                                              | `not installed`          |
| UI shell           | Represented by pattern | Navigation/Layout Pattern owner                                                              | component catalog disposition; header, left panel, right panel composition                                                               | `not installed`           |

## 2. Component Build-Order Tiers

Build-order tiers define dependency order for implementation and rendered evidence rebuild work. They are not navigation tiers. rendered evidence navigation may group pages by Foundation Elements, Components, Patterns, or source inventory, but implementation and review must progress from lower dependency tiers to higher dependency tiers.

Tier assignment is based on component composition depth:

- Tier 1 components have no component children.
- Tier 2 components may depend only on Tier 1 components.
- Tier 3 components may depend on Tier 1 and Tier 2 components.
- Tier 4 components may depend on Tier 1 through Tier 3 components and usually represent complex component families.
- Tier 5 surfaces are shell/layout-scale compositions and should generally be owned by layout or pattern systems, not primitive Component API work.

Foundation Elements are Tier 0 dependencies and are not counted as Component pages:

| Tier | Owner               | Scope                                                                |
| ---- | ------------------- | -------------------------------------------------------------------- |
| 0    | Foundation Elements | Color, themes, spacing, typography, icons, motion, layering, tokens. |

Components use these dependency tiers:

| Tier | Role                                       | Components / source surfaces                                                                                                                                                                                                                                                                                                                                                                                       | Dependency rule                                                                                                                                      |
| ---- | ------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ---------------------------------------------------------------------------------------------------------------------------------------------------- |
| 1    | Leaf primitives with no component children | Tag, Button, Checkbox, Form label, Icon, Link, List item, Loading, Menu item, Popover, Progress bar, Radio button, Select item, Select item group, Stack, H-stack, V-stack, Structured list row, Switch, Tag, Text area, Text input, Tile, Toggle, Tooltip, Progress step, Filename, File uploader drop container.                                                                                                 | Must render with only Foundation Element dependencies.                                                                                               |
| 2    | Simple composites using Tier 1 only        | Accordion, Breadcrumb, Button set, Chat button, Checkbox group, Contained list item, Content switcher, Copy button, Danger button, Date picker input, Dropdown, File uploader button, File uploader item, Form item, Form group, Icon button, Inline loading, Menu, Notification, Number input, Ordered list, Password input, Pagination nav, Radio button group, Search, Select, Tabs, Toggletip, Unordered list. | May depend on Tier 1 components only.                                                                                                                |
| 3    | Composed controls and overlays             | Code snippet, Combo button, Contained list, Date picker, Dialog, Drawer, Menu button, Modal, Multi-select, Overflow menu, Pagination, Progress indicator, Searchable select, Slider, Structured list, Time picker.                                                                                                                                                                                                 | May depend on Tier 1 and Tier 2 components.                                                                                                          |
| 4    | Complex component families                 | Combo box, Data table, File uploader, Filterable multi-select, Form, Tree view.                                                                                                                                                                                                                                                                                                                                    | May depend on Tier 1 through Tier 3 components and may require JavaScript/controller behavior, internal child APIs, or coordinated state management. |
| 5    | Shell and application-level compositions   | UI shell, app shell, header, side nav, switcher, page header, page title, page tabs, dashboard shell, documentation shell.                                                                                                                                                                                                                                                                                         | Must be documented as shell/layout systems or Patterns, not atomic component prerequisites.                                                          |

Patterns are not Component build-order tiers. Login patterns, form patterns, data and content patterns, overlay and feedback patterns, navigation and action patterns, layout and dashboard patterns, widget content patterns, starter catalogs, and archetype proofs consume stable Component APIs after component dependencies are ready.

Skeletons are not standalone visible reference pages. A skeleton component inherits the parent component's tier and is documented as a state or example under that parent. For example, Button skeleton belongs under Button, Date picker skeleton belongs under Date picker, Data table skeleton belongs under Data table, File uploader skeleton belongs under File uploader, and Toggle skeleton belongs under Toggle.

Visible Component pages are public developer decision surfaces. Hidden source surfaces include subcomponents, variants, helpers, skeletons, aliases, and internal implementation parts. rendered evidence overview tracking should distinguish visible page readiness from hidden dependency readiness.

Some installed source folders may remain as compatibility aliases, internal child APIs, or migration surfaces even when they are not intended to become top-level visible Component pages. Examples include skeleton folders, Data table internal render pieces, Notification family partials, Dialog partials, Pagination nav internals, `partials`, `patterns`, and `example`.

## 3. Component Page Contract

Every Component rendered evidence page must render:

1. Purpose
2. Use cases
3. Component contract
4. Live examples
5. Related components and patterns

Broad Components may use matrices, grouped examples, size scales, state tables, tabs, or full-width examples inside Live examples. The page must still prove actual installed APIs.

## 4. Foundation Element Dependency

Components must consume Foundation Elements for color, spacing, grid, typography, icons, motion, and themes. Components own internal spacing and primitive behavior; parent Patterns own external layout and composition.

Implementation-facing Component test criteria live in [Component Test Requirements](../test-requirements/components.md). Component tests must verify exact Element consumption for the owning Component contract.

## 5. Component Checklist Template

Every Component standard must include `## Implementation and Rendered Evidence Checklist`.

### 5.1. Implementation checklist

| Requirement                | Standard expectation                                                                                                                           |
| -------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source          | Name the canonical Blade component, native/class API, JavaScript controller, CSS namespace, source files, or explicit deferred gate.           |
| Variants/options/modifiers | List approved variants, options, sizes, density, layout modifiers, and deferred gates.                                                         |
| States                     | Define default, hover, focus-visible, active/pressed, disabled, loading, validation, selected, empty, or not-applicable states as relevant.    |
| Accessibility/content      | Define keyboard, focus, naming, ARIA, contrast, reduced-motion, label, helper, error, and copy requirements.                                   |
| Element consumption        | Name required Color, Spacing, Typography, Icons, Motion, Themes, and 2x Grid dependencies.                                                     |
| Build-order dependencies   | Name the component build tier, required lower-tier components, hidden subcomponents, skeleton ownership, and blocked lower-tier prerequisites. |
| Tests                      | Define source/API assertions and Rendered evidence route assertions that block generic fallback content.                                            |

### 5.2. rendered evidence proof checklist

| Requirement               | Visual proof expectation                                                                                                        |
| ------------------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| Live examples             | Render production examples through the documented API or explicit native/class contract.                                        |
| Rendered variants/options | Show every applicable supported variant, option, size, modifier, or deferred trigger condition.                                 |
| Rendered states           | Show required states visually and with accessibility markers where relevant.                                                    |
| Developer implementation  | Show real canonical calls and token-backed code snippets, not placeholder comments.                                             |
| Related APIs              | Link nearby Components, owning Patterns, consumed Elements, source files, and canonical docs.                                   |
| Manual review             | Provide enough rendered proof for visual review of behavior, layout, and state correctness.                                     |
| Dependency readiness      | Show whether required lower-tier live examples are approved, blocked, missing, or not applicable before marking the page ready. |

## 6. Component contract.php File

Every approved UI standard should have a `contract.php` in the final rollout state, regardless of whether it has a visible rendered evidence page. The rollout is still in progress. Until a component has a real `contract.php`, the installed Blade folder and existing `docs.php` metadata remain the transitional source inventory for Blade API, variants, sizes, states, dependencies, examples, testing expectations, lifecycle, and graduated enforcement.

Canonical contract:

- [UI contract.php File](../contract-file.md)

Blank template:

- [UI contract.php Template](../../../09-reference/ui/ui-contract-template.php)

Legacy `docs.php` files may remain temporarily during migration, but new or migrated component contracts must use the structured `contract.php` shape. Missing `contract.php` is a migration backlog item, not by itself evidence that an installed Blade component is stale. Having a contract does not make a surface strict; only approved contracts may opt into strict enforcement.

## 7. Related

- [UI Standards Index](../index.md)
- [UI API Registry](../api-registry.md)
- [Foundation Elements](../elements/index.md)
- [Component Test Requirements](../test-requirements/components.md)
- [Pattern API Standards](../patterns/index.md)
- [Component checklist](checklist.md)
