---
title: Blade Source Map
slug: blade-source-map
status: support-reference
api_layer: Support documentation
source_reference: reference/carbon-main/packages/react/src/components
---

# Blade Source Map

## Scope

This map covers canonical direct Blade component files under
`resources/views/components/ui/*.blade.php`.

It excludes generated icon payloads, rendered evidence example views, layout shell
composition files outside this direct UI component folder, and copied scratch
files.

## Component Blade Files

| Local Blade                                                                  | Carbon React source owner           | Classification  | Notes                                                        |
| ---------------------------------------------------------------------------- | ----------------------------------- | --------------- | ------------------------------------------------------------ |
| `resources/views/components/ui/accordion/index.blade.php`                    | `Accordion`, `AccordionItem`        | `direct`        | Carbon Accordion anatomy owner.                              |
| `resources/views/components/ui/breadcrumb/index.blade.php`                   | `Breadcrumb`, `BreadcrumbItem`      | `direct`        | Carbon Breadcrumb anatomy owner.                             |
| `resources/views/components/ui/button-set/index.blade.php`                   | `ButtonSet`                         | `direct`        | Carbon ButtonSet owner.                                      |
| `resources/views/components/ui/button-skeleton/index.blade.php`              | `Button`, skeleton components       | `compatibility` | Skeleton bridge for Button.                                  |
| `resources/views/components/ui/button/index.blade.php`                       | `Button`                            | `direct`        | Carbon Button owner.                                         |
| `resources/views/components/ui/chat-button-skeleton/index.blade.php`         | `ChatButton`, skeleton components   | `compatibility` | Skeleton bridge for ChatButton.                              |
| `resources/views/components/ui/chat-button/index.blade.php`                  | `ChatButton`                        | `direct`        | Carbon ChatButton owner.                                     |
| `resources/views/components/ui/checkbox-group/index.blade.php`               | `CheckboxGroup`                     | `direct`        | Carbon CheckboxGroup owner.                                  |
| `resources/views/components/ui/checkbox-skeleton/index.blade.php`            | `Checkbox`, skeleton components     | `compatibility` | Skeleton bridge for Checkbox.                                |
| `resources/views/components/ui/checkbox/index.blade.php`                     | `Checkbox`                          | `direct`        | Carbon Checkbox owner.                                       |
| `resources/views/components/ui/code-snippet/index.blade.php`                 | `CodeSnippet`                       | `direct`        | Carbon CodeSnippet owner.                                    |
| `resources/views/components/ui/combo-box/index.blade.php`                    | `ComboBox`                          | `direct`        | Carbon ComboBox owner.                                       |
| `resources/views/components/ui/combo-button/index.blade.php`                 | `ComboButton`                       | `direct`        | Carbon ComboButton owner.                                    |
| `resources/views/components/ui/contained-list-item/index.blade.php`          | `ContainedList`                     | `compatibility` | Item structure under ContainedList owner.                    |
| `resources/views/components/ui/contained-list/index.blade.php`               | `ContainedList`                     | `direct`        | Carbon ContainedList owner.                                  |
| `resources/views/components/ui/content-switcher/index.blade.php`             | `ContentSwitcher`                   | `direct`        | Carbon ContentSwitcher owner.                                |
| `resources/views/components/ui/copy-button/index.blade.php`                  | `CopyButton`                        | `direct`        | Carbon CopyButton owner.                                     |
| `resources/views/components/ui/danger-button/index.blade.php`                | `DangerButton`, `Button`            | `direct`        | Carbon DangerButton owner with Button foundation.            |
| `resources/views/components/ui/data-table/empty-state.blade.php`             | `DataTable`                         | `app-semantic`  | App empty-state addition over DataTable.                     |
| `resources/views/components/ui/data-table-skeleton/index.blade.php`          | `DataTableSkeleton`                 | `direct`        | Carbon DataTableSkeleton owner.                              |
| `resources/views/components/ui/data-table/toolbar/index.blade.php`           | `DataTable`                         | `compatibility` | Toolbar structure under DataTable owner.                     |
| `resources/views/components/ui/data-table/index.blade.php`                   | `DataTable`                         | `direct`        | Carbon DataTable owner.                                      |
| `resources/views/components/ui/date-picker-input/index.blade.php`            | `DatePickerInput`                   | `direct`        | Carbon DatePickerInput owner.                                |
| `resources/views/components/ui/date-picker-skeleton/index.blade.php`         | `DatePicker`, skeleton components   | `compatibility` | Skeleton bridge for DatePicker.                              |
| `resources/views/components/ui/date-picker/index.blade.php`                  | `DatePicker`                        | `direct`        | Carbon DatePicker owner.                                     |
| `resources/views/components/ui/drawer/index.blade.php`                       | `Modal`, `Dialog`                   | `compatibility` | Carbon React has no direct Drawer owner in this package set. |
| `resources/views/components/ui/dropdown-skeleton/index.blade.php`            | `Dropdown`, skeleton components     | `compatibility` | Skeleton bridge for Dropdown.                                |
| `resources/views/components/ui/dropdown/index.blade.php`                     | `Dropdown`                          | `direct`        | Carbon Dropdown owner.                                       |
| `resources/views/components/ui/file-uploader-button/index.blade.php`         | `FileUploader`                      | `compatibility` | Subpart under FileUploader owner.                            |
| `resources/views/components/ui/file-uploader-drop-container/index.blade.php` | `FileUploader`                      | `compatibility` | Subpart under FileUploader owner.                            |
| `resources/views/components/ui/file-uploader-item/index.blade.php`           | `FileUploader`                      | `compatibility` | Subpart under FileUploader owner.                            |
| `resources/views/components/ui/file-uploader-skeleton/index.blade.php`       | `FileUploader`, skeleton components | `compatibility` | Skeleton bridge for FileUploader.                            |
| `resources/views/components/ui/file-uploader/index.blade.php`                | `FileUploader`                      | `direct`        | Carbon FileUploader owner.                                   |
| `resources/views/components/ui/filename/index.blade.php`                     | `FileUploader`                      | `compatibility` | FileUploader filename subpart.                               |
| `resources/views/components/ui/filterable-multi-select/index.blade.php`      | `MultiSelect`, `ComboBox`           | `compatibility` | App split over Carbon selection components.                  |
| `resources/views/components/ui/form-group/index.blade.php`                   | `FormGroup`                         | `direct`        | Carbon FormGroup owner.                                      |
| `resources/views/components/ui/form-item/index.blade.php`                    | `FormItem`                          | `direct`        | Carbon FormItem owner.                                       |
| `resources/views/components/ui/form-label/index.blade.php`                   | `FormLabel`                         | `direct`        | Carbon FormLabel owner.                                      |
| `resources/views/components/ui/form/index.blade.php`                         | `Form`                              | `direct`        | Carbon Form owner.                                           |
| `resources/views/components/ui/icon-button/index.blade.php`                  | `IconButton`                        | `direct`        | Carbon IconButton owner.                                     |
| `resources/views/components/ui/icon-skeleton/index.blade.php`                | `SkeletonIcon`, `Icon`              | `compatibility` | Local filename differs from Carbon SkeletonIcon.             |
| `resources/views/components/ui/notification/inline.blade.php`                | `Notification`                      | `direct`        | Inline notification component.                               |
| `resources/views/components/ui/inline-loading/index.blade.php`               | `InlineLoading`                     | `direct`        | Carbon InlineLoading owner.                                  |
| `resources/views/components/ui/link/index.blade.php`                         | `Link`                              | `direct`        | Carbon Link owner.                                           |
| `resources/views/components/ui/loading/index.blade.php`                      | `Loading`                           | `direct`        | Carbon Loading owner.                                        |
| `resources/views/components/ui/menu-button/index.blade.php`                  | `MenuButton`                        | `direct`        | Carbon MenuButton owner.                                     |
| `resources/views/components/ui/menu-item/index.blade.php`                    | `Menu`                              | `compatibility` | Item structure under Menu owner.                             |
| `resources/views/components/ui/menu/index.blade.php`                         | `Menu`                              | `direct`        | Carbon Menu owner.                                           |
| `resources/views/components/ui/modal/index.blade.php`                        | `Modal`, `ComposedModal`            | `direct`        | Carbon Modal owner.                                          |
| `resources/views/components/ui/multi-select/index.blade.php`                 | `MultiSelect`                       | `direct`        | Carbon MultiSelect owner.                                    |
| `resources/views/components/ui/number-input-skeleton/index.blade.php`        | `NumberInput`, skeleton components  | `compatibility` | Skeleton bridge for NumberInput.                             |
| `resources/views/components/ui/number-input/index.blade.php`                 | `NumberInput`                       | `direct`        | Carbon NumberInput owner.                                    |
| `resources/views/components/ui/overflow-menu/index.blade.php`                | `OverflowMenu`                      | `direct`        | Carbon OverflowMenu owner.                                   |
| `resources/views/components/ui/pagination/index.blade.php`                   | `Pagination`                        | `direct`        | Carbon Pagination owner.                                     |
| `resources/views/components/ui/password-input/index.blade.php`               | `PasswordInput`, `TextInput`        | `direct`        | Carbon PasswordInput owner.                                  |
| `resources/views/components/ui/popover/index.blade.php`                      | `Popover`                           | `direct`        | Carbon Popover owner.                                        |
| `resources/views/components/ui/progress-bar/index.blade.php`                 | `ProgressBar`                       | `direct`        | Carbon ProgressBar owner.                                    |
| `resources/views/components/ui/progress-indicator/index.blade.php`           | `ProgressIndicator`                 | `direct`        | Carbon ProgressIndicator owner.                              |
| `resources/views/components/ui/progress-step/index.blade.php`                | `ProgressIndicator`                 | `compatibility` | Step subpart under ProgressIndicator owner.                  |
| `resources/views/components/ui/radio-button-group/index.blade.php`           | `RadioButtonGroup`                  | `direct`        | Carbon RadioButtonGroup owner.                               |
| `resources/views/components/ui/radio-button-skeleton/index.blade.php`        | `RadioButton`, skeleton components  | `compatibility` | Skeleton bridge for RadioButton.                             |
| `resources/views/components/ui/radio-button/index.blade.php`                 | `RadioButton`                       | `direct`        | Carbon RadioButton owner.                                    |
| `resources/views/components/ui/radio-group/index.blade.php`                  | `RadioButtonGroup`                  | `compatibility` | App alias over RadioButtonGroup.                             |
| `resources/views/components/ui/search-skeleton/index.blade.php`              | `Search`, skeleton components       | `compatibility` | Skeleton bridge for Search.                                  |
| `resources/views/components/ui/search/index.blade.php`                       | `Search`                            | `direct`        | Carbon Search owner.                                         |
| `resources/views/components/ui/searchable-select/index.blade.php`            | `ComboBox`, `ListBox`               | `compatibility` | App selection alias over ComboBox/ListBox concepts.          |
| `resources/views/components/ui/select-item-group/index.blade.php`            | `SelectItemGroup`                   | `direct`        | Carbon SelectItemGroup owner.                                |
| `resources/views/components/ui/select-item/index.blade.php`                  | `SelectItem`                        | `direct`        | Carbon SelectItem owner.                                     |
| `resources/views/components/ui/select-skeleton/index.blade.php`              | `Select`, skeleton components       | `compatibility` | Skeleton bridge for Select.                                  |
| `resources/views/components/ui/select/index.blade.php`                       | `Select`                            | `direct`        | Carbon Select owner.                                         |
| `resources/views/components/ui/slider-skeleton/index.blade.php`              | `Slider`, skeleton components       | `compatibility` | Skeleton bridge for Slider.                                  |
| `resources/views/components/ui/slider/index.blade.php`                       | `Slider`                            | `direct`        | Carbon Slider owner.                                         |
| `resources/views/components/ui/status-icon/index.blade.php`                  | `IconIndicator`, `ShapeIndicator`   | `app-semantic`  | App status subpart over Carbon indicators.                   |
| `resources/views/components/ui/status/index.blade.php`                       | indicators, `Tag`, `Notification`   | `app-semantic`  | App status abstraction.                                      |
| `resources/views/components/ui/structured-list-row/index.blade.php`          | `StructuredList`                    | `compatibility` | Row subpart under StructuredList owner.                      |
| `resources/views/components/ui/structured-list/index.blade.php`              | `StructuredList`                    | `direct`        | Carbon StructuredList owner.                                 |
| `resources/views/components/ui/switch/index.blade.php`                       | `Switch`                            | `direct`        | Carbon Switch owner.                                         |
| `resources/views/components/ui/tabs/index.blade.php`                         | `Tabs`, `Tab`, `TabContent`         | `direct`        | Carbon Tabs owner.                                           |
| `resources/views/components/ui/tag-group/index.blade.php`                    | `Tag`                               | `compatibility` | App grouping bridge over Tag.                                |
| `resources/views/components/ui/tag/index.blade.php`                          | `Tag`                               | `direct`        | Carbon Tag owner.                                            |
| `resources/views/components/ui/text-area-skeleton/index.blade.php`           | `TextArea`, skeleton components     | `compatibility` | Skeleton bridge for TextArea.                                |
| `resources/views/components/ui/text-area/index.blade.php`                    | `TextArea`                          | `direct`        | Carbon TextArea owner.                                       |
| `resources/views/components/ui/text-input-skeleton/index.blade.php`          | `TextInput`, skeleton components    | `compatibility` | Skeleton bridge for TextInput.                               |
| `resources/views/components/ui/text-input/index.blade.php`                   | `TextInput`                         | `direct`        | Carbon TextInput owner.                                      |
| `resources/views/components/ui/tile/index.blade.php`                         | `Tile`                              | `direct`        | Carbon Tile owner.                                           |
| `resources/views/components/ui/toast/index.blade.php`                        | `Notification`                      | `compatibility` | Toast notification alias.                                    |
| `resources/views/components/ui/toggle-skeleton/index.blade.php`              | `Toggle`, skeleton components       | `compatibility` | Skeleton bridge for Toggle.                                  |
| `resources/views/components/ui/toggle-small-skeleton/index.blade.php`        | `ToggleSmall`, skeleton components  | `compatibility` | Skeleton bridge for ToggleSmall.                             |
| `resources/views/components/ui/toggle/index.blade.php`                       | `Toggle`                            | `direct`        | Carbon Toggle owner.                                         |
| `resources/views/components/ui/toggletip/index.blade.php`                    | `Toggletip`                         | `direct`        | Carbon Toggletip owner.                                      |
| `resources/views/components/ui/tooltip/index.blade.php`                      | `Tooltip`                           | `direct`        | Carbon Tooltip owner.                                        |
| `resources/views/components/ui/tree-view/index.blade.php`                    | `TreeView`                          | `direct`        | Carbon TreeView owner.                                       |

## Notes For Later Review

- Local skeleton components should be checked against Carbon skeleton anatomy
  during the rendered evidence rebuild; this file only maps likely ownership.
- Files classified `compatibility` may still be correct long-term app APIs, but
  they need visual/API proof before being treated as final.
- Layout shell Blade files outside `resources/views/components/ui/` should be
  reviewed with UIShell once the shell source cleanup is accepted.
