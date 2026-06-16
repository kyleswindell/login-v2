# Component API Standards
- [1. Component Matrix](#1-component-matrix)
- [2. Component Page Contract](#2-component-page-contract)
- [3. Foundation Element Dependency](#3-foundation-element-dependency)
- [4. Component Checklist Template](#4-component-checklist-template)
  - [4.1. Implementation checklist](#41-implementation-checklist)
  - [4.2. UI Reference proof checklist](#42-ui-reference-proof-checklist)
- [5. Related](#5-related)

Component standards define primitive and baseline reusable UI APIs. The UI Reference labels this layer as **Components**.

Use this index for day-to-day lookup. The owning `components/{component}.md` file remains the full API standard.

## 1. Component Matrix

| Component          | Disposition            | Public API / surface                                          | Approved variants/options summary                                             | UI Reference route                                     |
| ------------------ | ---------------------- | ------------------------------------------------------------- | ----------------------------------------------------------------------------- | ------------------------------------------------------ |
| Accordion          | Approved API           | `x-ui.accordion`, `initAccordions`                            | default/contained, compact, scrollable, multiple/single-open                  | `/platform/ui-reference/components/accordion`          |
| AI label           | Do not implement       | No public API approved                                        | gated until product AI decision                                               | `/platform/ui-reference/components/ai-label`           |
| Breadcrumb         | Approved API           | `x-ui.breadcrumb`                                             | small/medium, overflow, current-page-listed                                   | `/platform/ui-reference/components/breadcrumb`         |
| Button             | Approved API           | `x-ui.button`, `x-ui.icon-button`                             | primary, secondary, tertiary, ghost, danger, sizes, groups, icon usage        | `/platform/ui-reference/components/button`             |
| Checkbox           | Approved API           | `x-ui.checkbox` or native-plus-`ui-*` class API               | checked, unchecked, indeterminate, disabled, readonly, validation             | `/platform/ui-reference/components/checkbox`           |
| Code snippet       | Approved API           | `x-ui.code-snippet`                                           | single-line, multi-line, highlighted tokens, copy disposition                 | `/platform/ui-reference/components/code-snippet`       |
| Contained list     | Approved API           | `x-ui.contained-list`, `x-ui.contained-list-item`              | on-page/disclosed, small/medium/large rows, linked/current/status/empty rows  | `/platform/ui-reference/components/contained-list`     |
| Content switcher   | Approved API           | `x-ui.content-switcher`, `initContentSwitchers`                | default, compact, icon with label, disabled, local panel, no-panel mode       | `/platform/ui-reference/components/content-switcher`   |
| Data table         | Approved API           | `x-ui.data-table`, `x-ui.data-table-toolbar`                  | row sizes, sortable, toolbar, row actions, loading, empty, error, responsive overflow, pagination composition; selection/expansion gated | `/platform/ui-reference/components/data-table`         |
| Date picker        | Approved API           | `x-ui.date-picker`, `data-ui-date-range-picker`, `data-ui-time-picker` | native date, date-time, range calendar, time picker, validation, disabled/readonly | `/platform/ui-reference/components/date-picker`        |
| Dropdown           | Approved API           | `x-ui.dropdown`                                               | known-option menu selection, validation, disabled/readonly                    | `/platform/ui-reference/components/dropdown`           |
| File uploader      | Approved API           | `x-ui.file-uploader`                                          | button upload, validation, disabled; drag/drop deferred                       | `/platform/ui-reference/components/file-uploader`      |
| Form               | Represented by pattern | Forms Pattern owner                                           | component catalog disposition; composition-owned form behavior                | `/platform/ui-reference/components/form`               |
| Inline loading     | Approved API           | `x-ui.inline-loading`                                         | action pending, local save pending, polite status                             | `/platform/ui-reference/components/inline-loading`     |
| Link               | Approved API           | `x-ui.link`                                                   | inline, external/help, icon-leading/trailing, disabled treatment              | `/platform/ui-reference/components/link`               |
| List               | Approved API           | native `ul`/`ol`/`li` plus approved list class/content contract | ordered, unordered, nested boundary, content-list guidance                    | `/platform/ui-reference/components/list`               |
| Loading            | Approved API           | `x-ui.loading`                                                | large, small, overlay, page, component, section, modal, side-panel, tile, inline | `/platform/ui-reference/components/loading`            |
| Menu               | Approved API           | `x-ui.menu` / item/menu behavior surface                      | action item, divider, shortcut, submenu boundary, danger, selected, sizes     | `/platform/ui-reference/components/menu`               |
| Menu buttons       | Approved API           | `x-ui.menu-button`, `x-ui.combo-button`, `x-ui.overflow-menu` | menu button, combo button, overflow menu, sizes, ghost                        | `/platform/ui-reference/components/menu-buttons`       |
| Modal              | Approved API           | `x-ui.modal` where installed                                  | confirmation, form, detail, destructive, sizes, focus behavior                | `/platform/ui-reference/components/modal`              |
| Multiselect        | Approved API           | `x-ui.multiselect`                                            | filterable, selected display, clear/select all, loading, empty, validation    | `/platform/ui-reference/components/multiselect`        |
| Notification       | Approved API           | notification/toast/status surfaces                            | success, error, warning, info, actionable, persistent handoff                 | `/platform/ui-reference/components/notification`       |
| Number input       | Approved API           | `x-ui.number-input`                                           | min/max/step, increment/decrement, validation, compact/fluid                  | `/platform/ui-reference/components/number-input`       |
| Pagination         | Approved API           | `x-ui.pagination`                                             | pagination bar, pagination nav, page size, page selector, looping, overflow   | `/platform/ui-reference/components/pagination`         |
| Popover            | Approved API           | `x-ui.popover`                                                | placement, alignment, size, caret, closeable, open, disabled                  | `/platform/ui-reference/components/popover`            |
| Progress bar       | Approved API           | `x-ui.progress-bar`                                           | determinate, indeterminate disposition, completion states                     | `/platform/ui-reference/components/progress-bar`       |
| Progress indicator | Approved API           | `x-ui.progress-indicator`, `x-ui.progress-step`               | horizontal/vertical, current, complete, error, disabled                       | `/platform/ui-reference/components/progress-indicator` |
| Radio button       | Approved API           | `x-ui.radio-button`, `x-ui.radio-group`                       | vertical/horizontal group, selected, disabled, readonly, validation           | `/platform/ui-reference/components/radio-button`       |
| Search             | Approved API           | `x-ui.search`                                                 | page search, table search, clear action, loading/no-results                   | `/platform/ui-reference/components/search`             |
| Select             | Approved API           | `x-ui.select`                                                 | native short selection, validation, disabled/readonly                         | `/platform/ui-reference/components/select`             |
| Slider             | Approved API           | `x-ui.slider`, `x-ui.range-slider`                            | single/range, visible value, exact input, endpoints, sizes, validation        | `/platform/ui-reference/components/slider`             |
| Structured list    | Approved API           | `x-ui.structured-list`, `x-ui.structured-list-row`            | default, selectable, condensed, selected/focus/disabled/skeleton              | `/platform/ui-reference/components/structured-list`    |
| Tabs               | Approved API           | `x-ui.tabs`                                                   | line, contained, vertical, scrollable, icons, secondary labels, dismissible   | `/platform/ui-reference/components/tabs`               |
| Tag                | Approved API           | `x-ui.tag`                                                    | metadata, status, removable/filter, semantic                                  | `/platform/ui-reference/components/tag`                |
| Text input         | Approved API           | `x-ui.text-input` or native-plus-`ui-*` class API             | default, password/search handoff, readonly, disabled, validation              | `/platform/ui-reference/components/text-input`         |
| Tile               | Approved API           | `x-ui.tile`                                                   | static, clickable, selectable, expandable, disabled disposition               | `/platform/ui-reference/components/tile`               |
| Toggle             | Approved API           | `x-ui.toggle`                                                 | on, off, disabled, readonly, helper text                                      | `/platform/ui-reference/components/toggle`             |
| Toggletip          | Approved API           | `x-ui.toggletip`                                              | contextual help, dismissible rich help, form assistance                       | `/platform/ui-reference/components/toggletip`          |
| Tooltip            | Approved API           | `x-ui.tooltip`                                                | icon-only, definition, disabled-control explanation                           | `/platform/ui-reference/components/tooltip`            |
| Tree view          | Approved API           | `x-ui.tree-view`, tree-node hooks, `initTreeViews`             | expandable/collapsible, selected/current, search/filter handoff, async gate   | `/platform/ui-reference/components/tree-view`          |
| UI shell           | Represented by pattern | Navigation/Layout Pattern owner                               | component catalog disposition; header, left panel, right panel composition    | `/platform/ui-reference/components/ui-shell`           |

## 2. Component Page Contract

Every Component UI Reference page must render:

1. Purpose
2. Use cases
3. Component contract
4. Live examples
5. Related components and patterns

Broad Components may use matrices, grouped examples, size scales, state tables, tabs, or full-width examples inside Live examples. The page must still prove actual installed APIs.

## 3. Foundation Element Dependency

Components must consume Foundation Elements for color, spacing, grid, typography, icons, motion, and themes. Components own internal spacing and primitive behavior; parent Patterns own external layout and composition.

## 4. Component Checklist Template

Every Component standard must include `## Implementation and UI Reference Checklist`.

### 4.1. Implementation checklist

| Requirement                | Standard expectation                                                                                                                        |
| -------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source          | Name the canonical Blade component, native/class API, JavaScript controller, CSS namespace, source files, or explicit deferred gate.        |
| Variants/options/modifiers | List approved variants, options, sizes, density, layout modifiers, and deferred gates.                                                      |
| States                     | Define default, hover, focus-visible, active/pressed, disabled, loading, validation, selected, empty, or not-applicable states as relevant. |
| Accessibility/content      | Define keyboard, focus, naming, ARIA, contrast, reduced-motion, label, helper, error, and copy requirements.                                |
| Element consumption        | Name required Color, Spacing, Typography, Icons, Motion, Themes, and 2x Grid dependencies.                                                  |
| Tests                      | Define source/API assertions and UI Reference route assertions that block generic fallback content.                                         |

### 4.2. UI Reference proof checklist

| Requirement               | Visual proof expectation                                                                        |
| ------------------------- | ----------------------------------------------------------------------------------------------- |
| Live examples             | Render production examples through the documented API or explicit native/class contract.        |
| Rendered variants/options | Show every applicable supported variant, option, size, modifier, or deferred trigger condition. |
| Rendered states           | Show required states visually and with accessibility markers where relevant.                    |
| Developer implementation  | Show real canonical calls and token-backed code snippets, not placeholder comments.             |
| Related APIs              | Link nearby Components, owning Patterns, consumed Elements, source files, and canonical docs.   |
| Manual review             | Provide enough rendered proof for visual review of behavior, layout, and state correctness.     |

## 5. Related

- [UI Standards Index](../index.md)
- [UI API Registry](../api-registry.md)
- [Foundation Elements](../elements/index.md)
- [Pattern API Standards](../patterns/index.md)
- [Component checklist](checklist.md)
