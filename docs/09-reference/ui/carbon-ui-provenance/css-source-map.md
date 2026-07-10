---
title: CSS Source Map
slug: css-source-map
status: support-reference
api_layer: Support documentation
source_reference: reference/carbon-main/packages/styles/scss/components
---

# CSS Source Map

## Scope

This map covers canonical component CSS files under:

- `resources/css/components/*.css`
- `resources/css/components/ui-shell/*.css`

It excludes backup folders, backup monoliths, legacy CSS, and reference CSS.
Primitive CSS ownership is mapped separately in
[Primitive Source Map](primitive-source-map.md).

## Component CSS

| Local CSS                                              | Carbon SCSS source owner         | Classification         | Notes                                                                           |
| ------------------------------------------------------ | -------------------------------- | ---------------------- | ------------------------------------------------------------------------------- |
| `resources/css/components/accordion.css`               | `accordion/`                     | `direct`               | Carbon Accordion component styles.                                              |
| `resources/css/components/action.css`                  | `button/`                        | `app-semantic`         | App action abstraction over button/action primitives.                           |
| `resources/css/components/actionable-notification.css` | `notification/`                  | `direct`               | Carbon notification subvariant.                                                 |
| `resources/css/components/ai-label.css`                | `ai-label/`, `slug/`             | `direct`               | `slug/` is legacy context.                                                      |
| `resources/css/components/badge-indicator.css`         | `badge-indicator/`               | `direct`               | Carbon BadgeIndicator styles.                                                   |
| `resources/css/components/breadcrumb.css`              | `breadcrumb/`                    | `direct`               | Carbon Breadcrumb styles.                                                       |
| `resources/css/components/button-group.css`            | `button/`                        | `compatibility`        | App grouping bridge over Button styles.                                         |
| `resources/css/components/button.css`                  | `button/`                        | `direct`               | Carbon Button styles.                                                           |
| `resources/css/components/chat-button.css`             | `chat-button/`                   | `direct`               | Carbon ChatButton styles.                                                       |
| `resources/css/components/checkbox.css`                | `checkbox/`                      | `direct`               | Carbon Checkbox styles.                                                         |
| `resources/css/components/code-snippet.css`            | `code-snippet/`                  | `direct`               | Carbon CodeSnippet styles.                                                      |
| `resources/css/components/combo-box.css`               | `combo-box/`                     | `direct`               | Carbon ComboBox base styles.                                                    |
| `resources/css/components/combo-button.css`            | `combo-button/`                  | `direct`               | Carbon ComboButton styles.                                                      |
| `resources/css/components/contained-list.css`          | `contained-list/`                | `direct`               | Carbon ContainedList styles.                                                    |
| `resources/css/components/content-switcher.css`        | `content-switcher/`              | `direct`               | Carbon ContentSwitcher styles.                                                  |
| `resources/css/components/copy-button.css`             | `copy-button/`                   | `direct`               | Carbon CopyButton styles.                                                       |
| `resources/css/components/data-table-expandable.css`   | `data-table/`                    | `compatibility`        | DataTable split-file variant.                                                   |
| `resources/css/components/data-table-skeleton.css`     | `data-table/`                    | `compatibility`        | DataTable skeleton split-file variant.                                          |
| `resources/css/components/data-table-sort.css`         | `data-table/`                    | `compatibility`        | DataTable sort split-file variant.                                              |
| `resources/css/components/data-table-toolbar.css`      | `data-table/`                    | `compatibility`        | DataTable toolbar split-file variant.                                           |
| `resources/css/components/data-table.css`              | `data-table/`                    | `direct`               | Carbon DataTable styles.                                                        |
| `resources/css/components/date-picker.css`             | `date-picker/`                   | `direct`               | Carbon DatePicker base styles.                                                  |
| `resources/css/components/dialog.css`                  | `dialog/`                        | `direct`               | Carbon Dialog styles.                                                           |
| `resources/css/components/drawer.css`                  | `modal/`, `dialog/`              | `compatibility`        | Carbon has no one-to-one Drawer component in this package set.                  |
| `resources/css/components/dropdown.css`                | `dropdown/`                      | `direct`               | Carbon Dropdown base styles.                                                    |
| `resources/css/components/file-uploader.css`           | `file-uploader/`                 | `direct`               | Carbon FileUploader styles.                                                     |
| `resources/css/components/flatpickr.css`               | `date-picker/`                   | `compatibility`        | Third-party Flatpickr bridge owned through DatePicker.                          |
| `resources/css/components/fluid-combo-box.css`         | `fluid-combo-box/`               | `integrated-fluid`     | Carbon fluid ComboBox source.                                                   |
| `resources/css/components/fluid-date-picker.css`       | `fluid-date-picker/`             | `integrated-fluid`     | Carbon fluid DatePicker source.                                                 |
| `resources/css/components/fluid-dropdown.css`          | `fluid-dropdown/`                | `integrated-fluid`     | Carbon fluid Dropdown source.                                                   |
| `resources/css/components/fluid-list-box.css`          | `fluid-list-box/`                | `integrated-fluid`     | Carbon fluid ListBox source.                                                    |
| `resources/css/components/fluid-multi-select.css`      | `fluid-multiselect/`             | `integrated-fluid`     | Local spelling differs from Carbon folder name.                                 |
| `resources/css/components/fluid-number-input.css`      | `fluid-number-input/`            | `integrated-fluid`     | Carbon fluid NumberInput source.                                                |
| `resources/css/components/fluid-search.css`            | `fluid-search/`                  | `integrated-fluid`     | Carbon fluid Search source.                                                     |
| `resources/css/components/fluid-select.css`            | `fluid-select/`                  | `integrated-fluid`     | Carbon fluid Select source.                                                     |
| `resources/css/components/fluid-text-area.css`         | `fluid-text-area/`               | `integrated-fluid`     | Carbon fluid TextArea source.                                                   |
| `resources/css/components/fluid-text-input.css`        | `fluid-text-input/`              | `integrated-fluid`     | Carbon fluid TextInput source.                                                  |
| `resources/css/components/fluid-time-picker.css`       | `fluid-time-picker/`             | `integrated-fluid`     | Carbon fluid TimePicker source.                                                 |
| `resources/css/components/form-controls.css`           | `form/`, input component folders | `app-semantic`         | App grouping surface over form controls.                                        |
| `resources/css/components/form.css`                    | `form/`                          | `direct`               | Carbon Form styles.                                                             |
| `resources/css/components/icon-button.css`             | `button/`                        | `compatibility`        | Icon-only Button bridge.                                                        |
| `resources/css/components/icon-indicator.css`          | `icon-indicator/`                | `direct`               | Carbon IconIndicator styles.                                                    |
| `resources/css/components/index.css`                   | None                             | `no-carbon-equivalent` | App component CSS entrypoint.                                                   |
| `resources/css/components/inline-notification.css`     | `notification/`                  | `direct`               | Inline notification behavior.                                                   |
| `resources/css/components/inline-loading.css`          | `inline-loading/`                | `direct`               | Carbon InlineLoading styles.                                                    |
| `resources/css/components/inline-notification.css`     | `notification/`                  | `direct`               | Carbon notification subvariant.                                                 |
| `resources/css/components/link.css`                    | `link/`                          | `direct`               | Carbon Link styles.                                                             |
| `resources/css/components/list-box.css`                | `list-box/`                      | `direct`               | Carbon ListBox styles.                                                          |
| `resources/css/components/list.css`                    | `list/`                          | `direct`               | Carbon List styles.                                                             |
| `resources/css/components/loading.css`                 | `loading/`                       | `direct`               | Carbon Loading styles.                                                          |
| `resources/css/components/menu-button.css`             | `menu-button/`                   | `direct`               | Carbon MenuButton styles.                                                       |
| `resources/css/components/menu.css`                    | `menu/`                          | `direct`               | Carbon Menu styles.                                                             |
| `resources/css/components/modal.css`                   | `modal/`                         | `direct`               | Carbon Modal styles.                                                            |
| `resources/css/components/multi-select.css`            | `multiselect/`                   | `direct`               | Local spelling differs from Carbon folder name.                                 |
| `resources/css/components/notification.css`            | `notification/`                  | `direct`               | Carbon Notification styles.                                                     |
| `resources/css/components/number-input.css`            | `number-input/`                  | `direct`               | Carbon NumberInput base styles.                                                 |
| `resources/css/components/overflow-menu.css`           | `overflow-menu/`                 | `direct`               | Carbon OverflowMenu styles.                                                     |
| `resources/css/components/page-header.css`             | `page-header/`                   | `direct`               | Carbon PageHeader styles; distinct from app shell `ui-shell-page-*` namespaces. |
| `resources/css/components/pagination-nav.css`          | `pagination-nav/`                | `direct`               | Carbon PaginationNav styles.                                                    |
| `resources/css/components/pagination.css`              | `pagination/`                    | `direct`               | Carbon Pagination styles.                                                       |
| `resources/css/components/popover.css`                 | `popover/`                       | `direct`               | Carbon Popover styles.                                                          |
| `resources/css/components/progress-bar.css`            | `progress-bar/`                  | `direct`               | Carbon ProgressBar styles.                                                      |
| `resources/css/components/progress-indicator.css`      | `progress-indicator/`            | `direct`               | Carbon ProgressIndicator styles.                                                |
| `resources/css/components/radio-button.css`            | `radio-button/`                  | `direct`               | Carbon RadioButton styles.                                                      |
| `resources/css/components/search.css`                  | `search/`                        | `direct`               | Carbon Search base styles.                                                      |
| `resources/css/components/select.css`                  | `select/`                        | `direct`               | Carbon Select base styles.                                                      |
| `resources/css/components/shape-indicator.css`         | `shape-indicator/`               | `direct`               | Carbon ShapeIndicator styles.                                                   |
| `resources/css/components/slider.css`                  | `slider/`                        | `direct`               | Carbon Slider styles.                                                           |
| `resources/css/components/slug.css`                    | `slug/`, `ai-label/`             | `compatibility`        | Legacy Carbon AI label naming bridge.                                           |
| `resources/css/components/stack.css`                   | `stack/`                         | `direct`               | Carbon Stack styles.                                                            |
| `resources/css/components/status.css`                  | indicators, tags, notifications  | `app-semantic`         | App status abstraction over Carbon primitives.                                  |
| `resources/css/components/structured-list.css`         | `structured-list/`               | `direct`               | Carbon StructuredList styles.                                                   |
| `resources/css/components/tabs.css`                    | `tabs/`                          | `direct`               | Carbon Tabs styles.                                                             |
| `resources/css/components/tag.css`                     | `tag/`                           | `direct`               | Carbon Tag styles.                                                              |
| `resources/css/components/text-area.css`               | `text-area/`                     | `direct`               | Carbon TextArea base styles.                                                    |
| `resources/css/components/text-input.css`              | `text-input/`                    | `direct`               | Carbon TextInput base styles.                                                   |
| `resources/css/components/tile.css`                    | `tile/`                          | `direct`               | Carbon Tile styles.                                                             |
| `resources/css/components/time-picker.css`             | `time-picker/`                   | `direct`               | Carbon TimePicker base styles.                                                  |
| `resources/css/components/toast-notification.css`      | `notification/`                  | `direct`               | Carbon notification subvariant.                                                 |
| `resources/css/components/toggle.css`                  | `toggle/`                        | `direct`               | Carbon Toggle styles.                                                           |
| `resources/css/components/toggletip.css`               | `toggletip/`                     | `direct`               | Carbon Toggletip styles.                                                        |
| `resources/css/components/tooltip.css`                 | `tooltip/`                       | `direct`               | Carbon Tooltip styles.                                                          |
| `resources/css/components/tree-view.css`               | `treeview/`                      | `compatibility`        | Local spelling differs from Carbon folder name.                                 |
| `resources/css/components/ui-shell.css`                | `ui-shell/`                      | `direct`               | Carbon UIShell aggregate styles.                                                |

## Segmented UI Shell CSS

| Local CSS                                                      | Carbon SCSS source owner    | Classification  | Notes                                                                                                                                                                                                            |
| -------------------------------------------------------------- | --------------------------- | --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `resources/css/components/ui-shell/00-settings.css`            | `ui-shell/`                 | `direct`        | Local split of Carbon UIShell source.                                                                                                                                                                            |
| `resources/css/components/ui-shell/01-layout.css`              | `ui-shell/`                 | `direct`        | Local split of Carbon UIShell source.                                                                                                                                                                            |
| `resources/css/components/ui-shell/02-header.css`              | `ui-shell/`                 | `direct`        | Header segment.                                                                                                                                                                                                  |
| `resources/css/components/ui-shell/03-header-navigation.css`   | `ui-shell/`                 | `direct`        | Header navigation segment.                                                                                                                                                                                       |
| `resources/css/components/ui-shell/04-header-actions.css`      | `ui-shell/`                 | `direct`        | Header action segment.                                                                                                                                                                                           |
| `resources/css/components/ui-shell/05-header-panels.css`       | `ui-shell/`                 | `compatibility` | App panel structure over UIShell behavior.                                                                                                                                                                       |
| `resources/css/components/ui-shell/07-account-panel.css`       | `ui-shell/`                 | `compatibility` | App account panel over UIShell behavior.                                                                                                                                                                         |
| `resources/css/components/ui-shell/20-side-nav.css`            | `ui-shell/`                 | `direct`        | Side navigation segment.                                                                                                                                                                                         |
| `resources/css/components/ui-shell/21-side-nav-menu.css`       | `ui-shell/`                 | `direct`        | Side navigation menu segment.                                                                                                                                                                                    |
| `resources/css/components/ui-shell/22-side-nav-link.css`       | `ui-shell/`                 | `direct`        | Side navigation link segment.                                                                                                                                                                                    |
| `resources/css/components/ui-shell/23-side-nav-icon.css`       | `ui-shell/`                 | `direct`        | Side navigation icon segment.                                                                                                                                                                                    |
| `resources/css/components/ui-shell/30-switcher.css`            | `ui-shell/`                 | `direct`        | Switcher segment.                                                                                                                                                                                                |
| `resources/css/components/ui-shell/40-docs-variant.css`        | `ui-shell/`                 | `app-semantic`  | rendered evidence docs shell variant.                                                                                                                                                                            |
| `resources/css/components/ui-shell/41-page-header.css`         | `ui-shell/`, `page-header/` | `compatibility` | Historical shell/PageHeader split; current shell page title/header/tabs CSS lives in `resources/css/components/ui-shell/content.css` as `ui-shell-page-title`, `ui-shell-page-header`, and `ui-shell-page-tabs`. |
| `resources/css/components/ui-shell/50-blade-contract.css`      | `ui-shell/`                 | `compatibility` | Blade selector contract over UIShell.                                                                                                                                                                            |
| `resources/css/components/ui-shell/80-legacy-app-surfaces.css` | `ui-shell/`                 | `compatibility` | Existing app surface bridge.                                                                                                                                                                                     |
| `resources/css/components/ui-shell/90-accessibility.css`       | `ui-shell/`                 | `direct`        | Accessibility support for UIShell behavior.                                                                                                                                                                      |
| `resources/css/components/ui-shell/content.css`                | `ui-shell/`                 | `direct`        | UIShell content segment.                                                                                                                                                                                         |
| `resources/css/components/ui-shell/header-panel.css`           | `ui-shell/`                 | `direct`        | UIShell header panel segment.                                                                                                                                                                                    |
| `resources/css/components/ui-shell/header.css`                 | `ui-shell/`                 | `direct`        | UIShell header segment.                                                                                                                                                                                          |
| `resources/css/components/ui-shell/side-nav.css`               | `ui-shell/`                 | `direct`        | UIShell side navigation segment.                                                                                                                                                                                 |
| `resources/css/components/ui-shell/switcher.css`               | `ui-shell/`                 | `direct`        | UIShell switcher segment.                                                                                                                                                                                        |

## Notes For Later Review

- `resources/css/components/aspect-ratio.css` is no longer present as a
  canonical component file; current ownership appears under base CSS.
- Carbon `skeleton-styles/` belongs to the primitive/base layer unless a later
  accepted component source owns a skeleton-specific selector.
- Files classified `compatibility` or `app-semantic` need later rendered evidence
  visual/API review before they are treated as stable component contracts.
