---
title: JS Source Map
slug: js-source-map
status: support-reference
api_layer: Support documentation
source_reference: reference/carbon-main/packages/react/src/components
---

# JS Source Map

## Scope

This map covers canonical UI JavaScript entrypoints:

- `resources/js/app.js`
- `resources/js/ui-controls.js`
- `resources/js/ui-controls/*.js`

It maps JavaScript by behavior ownership, not by implementation parity. Carbon
React source is a behavior/anatomy reference only; current app JavaScript is
plain app-owned JavaScript.

## JavaScript Files

| Local JS                                            | Carbon behavior owner             | Classification         | Notes                                                                 |
| --------------------------------------------------- | --------------------------------- | ---------------------- | --------------------------------------------------------------------- |
| `resources/js/app.js`                               | None                              | `no-carbon-equivalent` | App bootstrap entrypoint.                                             |
| `resources/js/ui-controls.js`                       | None                              | `no-carbon-equivalent` | App UI-control initializer registry.                                  |
| `resources/js/ui-controls/accordions.js`            | `Accordion`                       | `direct`               | Accordion disclosure behavior owner.                                  |
| `resources/js/ui-controls/checkboxes.js`            | `Checkbox`, `CheckboxGroup`       | `direct`               | Checkbox behavior owner.                                              |
| `resources/js/ui-controls/code-snippets.js`         | `CodeSnippet`, `CopyButton`       | `direct`               | CodeSnippet copy behavior owner.                                      |
| `resources/js/ui-controls/combo-boxes.js`           | `ComboBox`                        | `direct`               | ComboBox behavior owner.                                              |
| `resources/js/ui-controls/content-switchers.js`     | `ContentSwitcher`                 | `direct`               | ContentSwitcher selection behavior owner.                             |
| `resources/js/ui-controls/date-picker.js`           | `DatePicker`, `DatePickerInput`   | `direct`               | DatePicker behavior owner; Flatpickr is an implementation dependency. |
| `resources/js/ui-controls/dropdown-action-menus.js` | `Dropdown`, `Menu`                | `compatibility`        | App composed action-menu behavior.                                    |
| `resources/js/ui-controls/dropdowns.js`             | `Dropdown`                        | `direct`               | Dropdown behavior owner.                                              |
| `resources/js/ui-controls/file-uploader.js`         | `FileUploader`                    | `direct`               | FileUploader behavior owner.                                          |
| `resources/js/ui-controls/filter-panels.js`         | None                              | `app-semantic`         | App filter-panel behavior.                                            |
| `resources/js/ui-controls/interaction-focus.js`     | None                              | `app-semantic`         | App focus/interaction helper.                                         |
| `resources/js/ui-controls/menus.js`                 | `Menu`, `MenuButton`              | `direct`               | Menu behavior owner.                                                  |
| `resources/js/ui-controls/multiselects.js`          | `MultiSelect`                     | `direct`               | MultiSelect behavior owner.                                           |
| `resources/js/ui-controls/number-inputs.js`         | `NumberInput`                     | `direct`               | NumberInput behavior owner.                                           |
| `resources/js/ui-controls/pagination.js`            | `Pagination`, `PaginationNav`     | `direct`               | Pagination behavior owner.                                            |
| `resources/js/ui-controls/phone-inputs.js`          | None                              | `no-carbon-equivalent` | App-specific input helper.                                            |
| `resources/js/ui-controls/popovers.js`              | `Popover`                         | `direct`               | Popover behavior owner.                                               |
| `resources/js/ui-controls/search.js`                | `Search`                          | `direct`               | Search behavior owner.                                                |
| `resources/js/ui-controls/searchable-selects.js`    | `ComboBox`, `ListBox`             | `compatibility`        | App searchable-select behavior.                                       |
| `resources/js/ui-controls/select-controls.js`       | `Select`, `ListBox`, `Dropdown`   | `compatibility`        | Shared app select-control behavior.                                   |
| `resources/js/ui-controls/selectable-options.js`    | None                              | `app-semantic`         | App helper for selectable option state.                               |
| `resources/js/ui-controls/sliders.js`               | `Slider`                          | `direct`               | Slider behavior owner.                                                |
| `resources/js/ui-controls/structured-lists.js`      | `StructuredList`                  | `direct`               | StructuredList behavior owner.                                        |
| `resources/js/ui-controls/table-search.js`          | `DataTable`, `Search`             | `compatibility`        | App composition over DataTable and Search behavior.                   |
| `resources/js/ui-controls/tabs.js`                  | `Tabs`                            | `direct`               | Tabs behavior owner.                                                  |
| `resources/js/ui-controls/tag.js`                   | `Tag`                             | `direct`               | Tag behavior owner.                                                   |
| `resources/js/ui-controls/text-areas.js`            | `TextArea`                        | `direct`               | TextArea behavior owner.                                              |
| `resources/js/ui-controls/text-inputs.js`           | `TextInput`, `PasswordInput`      | `direct`               | TextInput behavior owner.                                             |
| `resources/js/ui-controls/theme-mode.js`            | `Theme`                           | `app-semantic`         | App theme-mode switching over Carbon theme concepts.                  |
| `resources/js/ui-controls/tiles.js`                 | `Tile`, `TileGroup`               | `direct`               | Tile behavior owner.                                                  |
| `resources/js/ui-controls/toggles.js`               | `Toggle`, `ToggleSmall`, `Switch` | `direct`               | Toggle/Switch behavior owner.                                         |
| `resources/js/ui-controls/tooltips.js`              | `Tooltip`, `Toggletip`            | `direct`               | Tooltip/Toggletip behavior owner.                                     |
| `resources/js/ui-controls/tree-views.js`            | `TreeView`                        | `direct`               | TreeView behavior owner.                                              |
| `resources/js/ui-controls/ui-shell.js`              | `UIShell`                         | `direct`               | UIShell behavior owner.                                               |

## Notes For Later Review

- This file does not prove Carbon behavior parity. It only identifies likely
  behavior ownership for later rendered evidence and accessibility review.
- Carbon React behavior should be consulted later for keyboard, focus, ARIA,
  disclosure, overlay, and selection-state questions.
- `app.js` and `ui-controls.js` should stay app-owned bootstrap surfaces even
  when individual control modules map to Carbon component behavior.
