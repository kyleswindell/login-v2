# CSS Extraction Map

This map tracks the current app.css extraction path. It is implementation-local orientation, not canonical UI standards or active batch state.

## Current Ownership

| Area | Owner | Status |
| --- | --- | --- |
| Tailwind seed overrides | `resources/css/ui/theme-seed.css` | Extracted |
| Palette tokens | `resources/css/tokens/palette/` | Extracted |
| Spacing tokens | `resources/css/tokens/spacing.css` | Extracted |
| Motion tokens | `resources/css/tokens/motion.css` | Extracted from Carbon motion package |
| Theme role tokens | `resources/css/tokens/themes/` | Extracted |
| Type package | `resources/css/type/` with compatibility shim at `resources/css/tokens/type/index.css` | Populated from Carbon Type package; preserves the app font stack; duplicate `app.css` type block removed after comparison with `backup-app.css` |
| Component tokens | `resources/css/tokens/components/` | Extracted and expanding |
| Semantic aliases | `resources/css/tokens/semantic/` | Extracted and expanding |
| Document defaults | `resources/css/base/document.css` | Extracted |
| Typography application | `resources/css/base/typography.css` | Extracted |
| Legacy utility compatibility | `resources/css/base/compatibility.css` | Extracted; temporary bridge |
| Animation primitives | `resources/css/base/animation.css` | Populated; duplicate `app.css` `ui-spin` keyframe removed after comparison with `backup-app.css` |
| Accordion | `resources/css/components/accordion.css` | Extracted; duplicate `app.css` block removed |
| Breadcrumb | `resources/css/components/breadcrumb.css` | Extracted; duplicate `app.css` block removed |
| Status / legacy badge | `resources/css/components/status.css` | Extracted; duplicate `app.css` block removed |
| Tag | `resources/css/components/tag.css` and `resources/css/reference/tag-reference.css` | Extracted; duplicate `app.css` block removed |
| Tooltip | `resources/css/components/tooltip.css` | Carbon SCSS-aligned component owner; duplicate `app.css` block removed after comparison with `backup-app.css` |
| Button/action foundation | `resources/css/components/button.css`, `icon-button.css`, `copy-button.css`, `action.css` | Carbon SCSS-aligned component owner; duplicate `app.css` action/button blocks removed; `action.css` kept as compatibility only |
| Form foundation and primitive controls | `resources/css/components/form.css`, `text-input.css`, `text-area.css`, `number-input.css`, `checkbox.css`, `radio-button.css`, `toggle.css`, `search.css` | Carbon SCSS-aligned component owners; duplicate `app.css` primitive form/control blocks removed; `form-controls.css` kept as compatibility only |
| Selection/list foundations | `resources/css/components/list-box.css`, `select.css`, `dropdown.css`, `multiselect.css`, `combo-box.css`, `searchable-select.css` | Carbon SCSS-aligned component owners; duplicate `app.css` selection/list blocks removed |
| Button group | `resources/css/components/button-group.css` | Carbon SCSS-aligned component owner; duplicate `app.css` block removed after comparison with `backup-app.css` |
| Link | `resources/css/components/link.css` | Carbon SCSS-aligned component owner; duplicate `app.css` block removed after comparison with `backup-app.css` |
| List | `resources/css/components/list.css` | Carbon SCSS-aligned component owner; duplicate `app.css` block removed after comparison with `backup-app.css` |
| Loading | `resources/css/components/loading.css` and `resources/css/reference/loading-reference.css` | Carbon SCSS-aligned component owner; duplicate `app.css` component block removed after comparison with `backup-app.css`; UI reference scaffolding moved to reference owner |
| Tabs | `resources/css/components/tabs.css` | Carbon SCSS-aligned component owner; duplicate `app.css` block removed after comparison with `backup-app.css` |
| Tile | `resources/css/components/tile.css` | Carbon SCSS-aligned component owner; duplicate `app.css` block removed after comparison with `backup-app.css` |
| Badge indicator | `resources/css/components/badge-indicator.css` | Imported with status/indicator components; no rendered `ui-badge-indicator*` API found yet |
| Content switcher | `resources/css/components/content-switcher.css` | Carbon SCSS-aligned component owner; duplicate `app.css` block removed after comparison with `backup-app.css` |
| Code snippet | `resources/css/components/code-snippet.css` | Carbon SCSS-aligned component owner; duplicate `app.css` shell/base blocks removed after comparison with `backup-app.css` |
| Contained list | `resources/css/components/contained-list.css` | Carbon SCSS-aligned component owner; duplicate `app.css` block removed after comparison with `backup-app.css` |
| Popover | `resources/css/components/popover.css` | Carbon SCSS-aligned component owner; duplicate `app.css` block removed after comparison with `backup-app.css` |
| Menu / overflow menu | `resources/css/components/menu.css`, `menu-button.css`, `overflow-menu.css`, and `resources/css/reference/menu-reference.css` | Carbon SCSS-aligned component owners; duplicate `app.css` menu block removed after comparison with `backup-app.css`; UI reference proof styles moved to reference owner |
| Notification / inline alert / toast | `resources/css/components/notification.css`, `inline-alert.css`, `toast.css` | Carbon SCSS-aligned component owners; duplicate `app.css` feedback/runtime blocks removed after comparison with `backup-app.css` |
| Structured list | `resources/css/components/structured-list.css` | Carbon SCSS-aligned component owner; duplicate `app.css` block removed after comparison with `backup-app.css` |
| Data table / table compatibility | `resources/css/components/data-table.css` and `table.css` | Carbon SCSS-aligned data-table owner plus compatibility table selectors; duplicate `app.css` blocks removed after comparison with `backup-app.css` |
| Pagination / pagination nav | `resources/css/components/pagination.css` and `pagination-nav.css` | Carbon SCSS-aligned component owners; duplicate `app.css` block removed after comparison with `backup-app.css` |
| Date picker / Flatpickr / time picker | `resources/css/components/date-picker.css`, `date-picker-input.css`, `flatpickr.css`, `time-picker.css` | Carbon SCSS-aligned component owners; duplicate `app.css` date/time blocks removed after comparison with `backup-app.css` |
| Shared scrollbar utility | `resources/css/base/compatibility.css` | Shared utility moved out of feedback block because it is used beyond notifications |

## Component File Inventory

The component import list in `resources/css/app.css` now follows dependency-first order. Files marked as compatibility bridges should not become the long-term owner for one-to-one Carbon component behavior.

| Group | Canonical files | Compatibility / aggregator files |
| --- | --- | --- |
| Button/action foundation | `button.css`, `icon-button.css`, `copy-button.css`, `combo-button.css`, `button-group.css` | `action.css` |
| Form foundation | `form.css` | `form-controls.css` |
| Primitive controls | `text-input.css`, `text-area.css`, `number-input.css`, `checkbox.css`, `radio-button.css`, `toggle.css`, `search.css`, `file-uploader.css`, `slider.css` | `radio.css` |
| Selection/list foundations | `list-box.css`, `select.css`, `dropdown.css`, `multiselect.css`, `combo-box.css`, `searchable-select.css` | None |
| Floating/overlay foundations | `popover.css`, `tooltip.css`, `toggletip.css`, `dialog.css`, `modal.css`, `drawer.css` | None |
| Composed actions | `menu.css`, `menu-button.css`, `overflow-menu.css`, `combo-button.css` | None |
| Content/status | `link.css`, `list.css`, `tag.css`, `status.css`, `notification.css`, `inline-alert.css`, `toast.css`, `code-snippet.css`, `contained-list.css`, `content-switcher.css`, `structured-list.css`, `tabs.css`, `tile.css`, `treeview.css` | `tree-view.css` |
| Loading/progress | `loading.css`, `inline-loading.css`, `progress-bar.css`, `progress-indicator.css` | None |
| Data components | `data-table.css`, `pagination.css`, `pagination-nav.css` | `table.css` |
| Date picker | `date-picker.css`, `date-picker-input.css`, `flatpickr.css` | None |
| App shell | Component primitives remain in their specific files | `shell.css` |

## App.css Pending Sections

| Section | Target |
| --- | --- |
| Action/button selectors | Base action/icon/copy rules extracted; `combo-button.css` still pending; keep `action.css` as compatibility only |
| Form/control selectors | Primitive controls and selection controls extracted; date/time field overrides still pending; keep `form-controls.css` as compatibility only |
| Date picker selectors | Completed for current duplicate `app.css` date-picker, date-picker-input, Flatpickr, and time-picker families |
| Code snippet selectors | Completed for current duplicate `app.css` code-snippet families |
| Table and pagination selectors | Completed for current duplicate `app.css` data-table, table compatibility, pagination, and pagination-nav families |
| Notification selectors | Completed for current duplicate `app.css` notification, inline-alert, and toast families |
| Shell/navigation/overlay selectors | Specific overlay/menu/component files first; keep `shell.css` for app shell/layout compatibility |
| Dashboard/widget/card selectors | `resources/css/patterns/dashboard.css` or component files by owning API |
| UI Reference proof selectors | `resources/css/reference/*.css` |

## Pass Rules

1. Move one selector family at a time.
2. Keep public `ui-*` APIs stable unless the owning standard changes.
3. Move reusable values into `tokens/*`; keep rendering rules in `base/*`, `components/*`, `patterns/*`, or `reference/*`.
4. Remove the matching legacy block from `app.css` in the same pass.
5. Run a token reference scan and `npm run build` before calling the pass complete.
