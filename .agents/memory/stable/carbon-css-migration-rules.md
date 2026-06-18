# Carbon CSS Migration Rules

Status: stable agent operating memory.

## Hard Boundary

- Do not touch `resources/css/app.css` during Carbon component source mapping or manual component translation.
- Do not touch `resources/css/backup-app.css`.
- Do not extract selectors from `app.css` into standalone component files.
- Do not use `app.css` as source material for Carbon component files.
- Do not paste Carbon source files into comments.
- Do not create fake selector stubs.
- Do not create documentation artifacts disguised as CSS.
- Do not treat `resources/css/tokens/*` and `resources/css/base/*` as only a dedupe check; treat them as ownership layers.

## Expected Workflow

1. Read the manually completed Carbon-derived token/theme files to match translation style.
2. Read Carbon source first:
   - `reference/carbon-main/packages/styles/scss/components/*`
3. Map each target `resources/css/components/*.css` file to its Carbon SCSS source equivalent before writing implementation CSS.
4. Translate Carbon SCSS manually into real project CSS.
5. Map Carbon Sass variables and theme tokens to existing `--ui-*` tokens.
6. Before adding a raw value in component CSS, stop and classify the concern by ownership.
7. General color configuration belongs in `resources/css/tokens/*`, not in component CSS.
8. Overall document, base element, global reset, typography application, and shared primitive behavior belongs in `resources/css/base/*`, not in component CSS.
9. If a Carbon component translation appears to need a raw color, determine whether:
   - an existing palette/theme/semantic/component token should be used;
   - a new token should be added to the proper `resources/css/tokens/*` owner;
   - or the value is truly component-local and should remain in the component file.
10. If a Carbon component translation appears to need base element styling, determine whether it belongs in an existing `base/*` file or a new base file before putting it in a component file.
11. Component CSS should consume variables and base primitives; it should own component structure, layout, state selectors, variants, and behavior-specific rendering.
12. Keep component rendering rules in `resources/css/components/*`.
13. Compare against Blade/app behavior only after the Carbon-derived standalone CSS exists.

## Separate Later Workflow: Blade/API Review

React source is not part of the component CSS translation workflow.

Use `reference/carbon-main/packages/react/src/components/*` later, in a separate Blade/API review workflow, to compare Carbon component APIs, rendered structure, props, ARIA behavior, state attributes, and composition patterns against the Laravel Blade components.

Do not translate React or TypeScript source into CSS. Do not list React source in component CSS file mapping headers. React source may be referenced only after the Carbon-derived CSS layer exists and the work explicitly switches to Blade/API review.

## Organization Ownership Model

Think by ownership first, not by whether something already exists.

If translating Carbon SCSS introduces a raw value, classify it before writing it:

- Color values: default to `resources/css/tokens/*`.
- Theme role values: default to `resources/css/tokens/themes/*`.
- Component-specific reusable color values: default to `resources/css/tokens/components/*`.
- App semantic aliases: default to `resources/css/tokens/semantic/*`.
- Spacing scale values: default to `resources/css/tokens/spacing.css`.
- Motion duration/easing values: default to `resources/css/tokens/motion.css`.
- Type scale/weight/style values: default to `resources/css/type/*`.
- Document defaults, element-level defaults, global resets, shared keyframes, and compatibility bridges: default to `resources/css/base/*`.
- Component selectors, component layout, component variants, and component state rendering: default to `resources/css/components/*`.

Current known owners:

| Existing owner | Responsibility | Component translation rule |
| --- | --- | --- |
| `resources/css/tokens/palette/base-colors.css` | Core Carbon color palette values | Use palette tokens indirectly through theme/component/semantic tokens; do not redefine raw colors in components. |
| `resources/css/tokens/themes/*` | Carbon theme role tokens for white, gray-10, gray-90, gray-100 | Use existing theme role variables; do not define theme role values in components. |
| `resources/css/tokens/components/buttons.css` | Button component color tokens | Button CSS must consume these tokens and must not duplicate button color values. |
| `resources/css/tokens/components/tags.css` | Tag component color/radius tokens | Tag CSS must consume these tokens and must not duplicate tag color values. |
| `resources/css/tokens/components/status.css` | Status component color tokens | Status CSS must consume these tokens and must not duplicate status colors. |
| `resources/css/tokens/components/notifications.css` | Notification component color tokens | Notification CSS must consume these tokens and must not duplicate notification colors. |
| `resources/css/tokens/components/content-switcher.css` | Content switcher component tokens | Content switcher CSS must consume these tokens. |
| `resources/css/tokens/semantic/app-aliases.css` | App semantic aliases over Carbon tokens | Reuse aliases when they intentionally represent app semantics; do not recreate aliases in components. |
| `resources/css/tokens/spacing.css` | Carbon spacing scale | Use spacing variables or resolved spacing values consistently; do not define a parallel spacing scale. |
| `resources/css/tokens/motion.css` | Carbon motion durations/easings | Use motion variables; do not duplicate duration/easing literals unless the Carbon component requires a one-off value. |
| `resources/css/type/*` and `resources/css/tokens/type/index.css` | Carbon type translation while preserving app font families | Component CSS should use type tokens/classes; do not redefine font families. |
| `resources/css/base/document.css` | Document-level theme application | Components must not own body/html/background defaults. |
| `resources/css/base/animation.css` | Shared keyframes only | Add shared keyframes here when truly reusable; components only apply animation. |
| `resources/css/base/compatibility.css` | Temporary legacy compatibility bridges | Do not add new compatibility bridges unless explicitly approved. |

## Current Correction Rule

The standalone component files polluted with `app.css` extraction or Carbon source dumps must first be erased and replaced with clean Carbon source mappings only. Real CSS translation should then proceed one component at a time from Carbon source.

## Carbon SCSS Component Source Map

Every component CSS file must map to Carbon SCSS only. React and Web Component sources are reserved for the later Blade/API workflow.

Status values:

- `direct`: one-to-one Carbon SCSS component translation.
- `integrated-fluid`: direct component translation that also folds in a Carbon `fluid-*` SCSS folder.
- `compatibility`: app compatibility or naming bridge; implement only after the owning direct component exists.
- `aggregator`: organizational wrapper; implement only when explicitly needed after owned files exist.
- `app-semantic`: app-level semantic component backed by Carbon primitives or tokens.
- `base-owned`: Carbon SCSS belongs in `resources/css/base/*`, not a component file.

| Target CSS | Carbon SCSS source | Dependency bucket | Status | Ownership notes |
| --- | --- | --- | --- | --- |
| `accordion.css` | `accordion/_index.scss`, `accordion/_accordion.scss` | content/navigation/status | direct | Consume theme, motion, spacing, and type tokens. |
| `action.css` | None | action/button foundation | aggregator | No Carbon equivalent; do not implement until button/action files exist and compatibility is approved. |
| `ai-label.css` | `ai-label/_index.scss`, `ai-label/_ai-label.scss`; legacy context: `slug/*` | content/navigation/status | direct | Consume theme/type/motion tokens; do not create `slug.css` unless compatibility is required. |
| `aspect-ratio.css` | `aspect-ratio/_index.scss`, `aspect-ratio/_aspect-ratio.scss` | layout/shell/tree | direct | Layout utility component; no color ownership expected. |
| `badge-indicator.css` | `badge-indicator/_index.scss`, `badge-indicator/_badge-indicator.scss` | content/navigation/status | direct | Color values belong in tokens if reusable. |
| `breadcrumb.css` | `breadcrumb/_index.scss`, `breadcrumb/_breadcrumb.scss`, `breadcrumb/_css.scss` | content/navigation/status | direct | Consume link/theme/type/motion tokens. |
| `button-group.css` | `button/*` | action/button foundation | compatibility | Button set/group layout only; colors stay in button tokens. |
| `button.css` | `button/_index.scss`, `button/_button.scss`, `button/_mixins.scss`, `button/_tokens.scss`, `button/_vars.scss` | action/button foundation | direct | Consume `tokens/components/buttons.css`, theme, motion, spacing, and type tokens. |
| `chat-button.css` | `chat-button/_index.scss`, `chat-button/_chat-button.scss` | action/button foundation | direct | Consume button/theme tokens; route any chat-specific colors through component tokens if reusable. |
| `checkbox.css` | `checkbox/_index.scss`, `checkbox/_checkbox.scss` | form primitives | direct | Consume form, theme, focus, spacing, and type tokens. |
| `code-snippet.css` | `code-snippet/_index.scss`, `code-snippet/_code-snippet.scss`, `code-snippet/_mixins.scss` | content/navigation/status | direct | Route skeleton/shared code colors through tokens/base if reusable. |
| `combo-box.css` | `combo-box/_index.scss`, `combo-box/_combo-box.scss`; `fluid-combo-box/*` | selection/list foundations | integrated-fluid | Depends on list-box and form primitives. |
| `combo-button.css` | `combo-button/_index.scss`, `combo-button/_combo-button.scss` | action/button foundation | direct | Depends on button/menu behavior; colors consume button/theme tokens. |
| `contained-list.css` | `contained-list/_index.scss`, `contained-list/_contained-list.scss` | content/navigation/status | direct | Consume layer/theme/type tokens. |
| `content-switcher.css` | `content-switcher/_index.scss`, `content-switcher/_content-switcher.scss`, `content-switcher/_tokens.scss` | content/navigation/status | direct | Consume `tokens/components/content-switcher.css`; add missing reusable values there. |
| `copy-button.css` | `copy-button/_index.scss`, `copy-button/_copy-button.scss` | action/button foundation | direct | Depends on button/tooltip behavior; shared feedback colors go through tokens. |
| `data-table.css` | `data-table/_index.scss`, `data-table/_data-table.scss`, `data-table/_mixins.scss`, `data-table/_vars.scss` | data/date/time | direct | Consume layer/theme/type/spacing tokens; shared table aliases belong in tokens if reusable. |
| `date-picker-input.css` | `date-picker/*` | data/date/time | compatibility | Naming bridge after `date-picker.css`; do not duplicate DatePicker implementation. |
| `date-picker.css` | `date-picker/_index.scss`, `date-picker/_date-picker.scss`, `date-picker/_flatpickr.scss`; `fluid-date-picker/*` | data/date/time | integrated-fluid | Owns DatePicker selectors; Flatpickr bridge may be split to `flatpickr.css`. |
| `dialog.css` | `dialog/_index.scss`, `dialog/_dialog.scss` | floating/overlay/actions | direct | Shared overlay base values belong in base/tokens. |
| `drawer.css` | None; app-specific over `modal/*` and `dialog/*` | floating/overlay/actions | compatibility | Implement only after modal/dialog exist. |
| `dropdown.css` | `dropdown/_index.scss`, `dropdown/_dropdown.scss`; `fluid-dropdown/*` | selection/list foundations | integrated-fluid | Depends on list-box/form primitives. |
| `file-uploader.css` | `file-uploader/_index.scss`, `file-uploader/_file-uploader.scss` | form primitives | direct | Consume form/button/theme tokens. |
| `flatpickr.css` | `date-picker/_flatpickr.scss` | data/date/time | compatibility | Third-party bridge after `date-picker.css`; no app date input duplication. |
| `form-controls.css` | None; app organization over form primitives | form primitives | aggregator | Do not implement until primitive controls exist. |
| `form.css` | `form/_index.scss`, `form/_form.scss` | form primitives | direct | Labels/helper/error shared form structure; consume type/theme tokens. |
| `icon-button.css` | `button/*` | action/button foundation | compatibility | Icon-only button selectors after `button.css`; colors consume button tokens. |
| `icon-indicator.css` | `icon-indicator/_index.scss`, `icon-indicator/_icon-indicator.scss`, `icon-indicator/_tokens.scss` | content/navigation/status | direct | Component indicator colors belong in component tokens if reusable. |
| `inline-alert.css` | `notification/*` | content/navigation/status | compatibility | App naming over Carbon inline notification after `notification.css`. |
| `inline-loading.css` | `inline-loading/_index.scss`, `inline-loading/_inline-loading.scss`, `inline-loading/_keyframes.scss` | feedback/loading/progress | direct | Shared keyframes belong in `base/animation.css`. |
| `link.css` | `link/_index.scss`, `link/_link.scss` | content/navigation/status | direct | Consume theme/link/type/motion tokens. |
| `list-box.css` | `list-box/_index.scss`, `list-box/_list-box.scss`; `fluid-list-box/*` | selection/list foundations | integrated-fluid | Foundation for dropdown/select/multiselect/combo-box. |
| `list.css` | `list/_index.scss`, `list/_list.scss` | content/navigation/status | direct | Consume type/spacing tokens. |
| `loading.css` | `loading/_index.scss`, `loading/_loading.scss`, `loading/_animation.scss`, `loading/_functions.scss`, `loading/_vars.scss` | feedback/loading/progress | direct | Shared keyframes belong in `base/animation.css`. |
| `menu-button.css` | `menu-button/_index.scss`, `menu-button/_menu-button.scss` | floating/overlay/actions | direct | Depends on button/menu. |
| `menu.css` | `menu/_index.scss`, `menu/_menu.scss` | floating/overlay/actions | direct | Depends on popover/menu-button where applicable. |
| `modal.css` | `modal/_index.scss`, `modal/_modal.scss` | floating/overlay/actions | direct | Shared overlay/body-lock concerns belong in base if reusable. |
| `multiselect.css` | `multiselect/_index.scss`, `multiselect/_multiselect.scss`; `fluid-multiselect/*` | selection/list foundations | integrated-fluid | Depends on list-box/form/tag behavior. |
| `notification.css` | `notification/_index.scss`, `_inline-notification.scss`, `_toast-notification.scss`, `_actionable-notification.scss`, `_mixins.scss`, `_tokens.scss` | content/navigation/status | direct | Consume `tokens/components/notifications.css`; add missing reusable values there. |
| `number-input.css` | `number-input/_index.scss`, `number-input/_number-input.scss`; `fluid-number-input/*` | form primitives | integrated-fluid | Consume form/button/theme tokens. |
| `overflow-menu.css` | `overflow-menu/_index.scss`, `overflow-menu/_overflow-menu.scss` | floating/overlay/actions | direct | Depends on menu/popover. |
| `page-header.css` | `page-header/_index.scss`, `page-header/_page-header.scss` | layout/shell/tree | direct | Layout and type tokens; page-level color aliases belong in tokens/base. |
| `pagination-nav.css` | `pagination-nav/_index.scss`, `_pagination-nav.scss`, `_mixins.scss` | data/date/time | direct | Depends on button/link concepts; consume theme/type tokens. |
| `pagination.css` | `pagination/_index.scss`, `_pagination.scss`, `_unstable_pagination.scss` | data/date/time | direct | Depends on select/button concepts; consume form/theme tokens. |
| `popover.css` | `popover/_index.scss`, `popover/_popover.scss` | floating/overlay/actions | direct | Foundation for tooltip/toggletip/menu overlays. |
| `progress-bar.css` | `progress-bar/_index.scss`, `progress-bar/_progress-bar.scss` | feedback/loading/progress | direct | Consume theme/status tokens; route reusable colors to tokens. |
| `progress-indicator.css` | `progress-indicator/_index.scss`, `_progress-indicator.scss` | feedback/loading/progress | direct | Consume status/theme/type tokens. |
| `radio-button.css` | `radio-button/_index.scss`, `radio-button/_radio-button.scss` | form primitives | direct | Consume form/theme/focus tokens. |
| `radio.css` | None; app naming over `radio-button.css` | form primitives | compatibility | Implement only after `radio-button.css`. |
| `search.css` | `search/_index.scss`, `search/_search.scss`; `fluid-search/*` | form primitives | integrated-fluid | Consume form/theme/motion tokens. |
| `searchable-select.css` | None; app naming over `combo-box/*` and `list-box/*` | selection/list foundations | compatibility | Implement only after combo-box/list-box. |
| `select.css` | `select/_index.scss`, `select/_select.scss`; `fluid-select/*` | selection/list foundations | integrated-fluid | Depends on form/list-box concepts. |
| `shape-indicator.css` | `shape-indicator/_index.scss`, `_shape-indicator.scss` | content/navigation/status | direct | Indicator colors belong in component/status tokens if reusable. |
| `shell.css` | None; app naming over `ui-shell/*` | layout/shell/tree | compatibility | Implement only after `ui-shell.css`. |
| `slider.css` | `slider/_index.scss`, `slider/_slider.scss` | form primitives | direct | Consume form/theme tokens; route track colors through tokens if reusable. |
| `stack.css` | `stack/_index.scss`, `stack/_stack.scss` | layout/shell/tree | direct | Spacing/layout utility; consume spacing tokens. |
| `status.css` | None; app semantic over Carbon indicators/tag/notification tokens | content/navigation/status | app-semantic | Consume `tokens/components/status.css`; do not duplicate status colors. |
| `structured-list.css` | `structured-list/_index.scss`, `_structured-list.scss`, `_mixins.scss` | data/date/time | direct | Consume layer/theme/type tokens. |
| `table.css` | None; app naming over `data-table.css` | data/date/time | compatibility | Implement only after `data-table.css`. |
| `tabs.css` | `tabs/_index.scss`, `tabs/_tabs.scss`, `tabs/_vars.scss` | content/navigation/status | direct | Consume layer/theme/type/motion tokens. |
| `tag.css` | `tag/_index.scss`, `tag/_tag.scss`, `tag/_mixins.scss`, `tag/_tokens.scss` | content/navigation/status | direct | Consume `tokens/components/tags.css`; do not duplicate tag colors. |
| `text-area.css` | `text-area/_index.scss`, `text-area/_text-area.scss`; `fluid-text-area/*` | form primitives | integrated-fluid | Consume form/type/theme tokens. |
| `text-input.css` | `text-input/_index.scss`, `text-input/_text-input.scss`; `fluid-text-input/*` | form primitives | integrated-fluid | Consume form/type/theme tokens. |
| `tile.css` | `tile/_index.scss`, `tile/_tile.scss` | content/navigation/status | direct | Consume layer/theme/focus tokens. |
| `time-picker.css` | `time-picker/_index.scss`, `time-picker/_time-picker.scss`; `fluid-time-picker/*` | data/date/time | integrated-fluid | Depends on form/select concepts. |
| `toast.css` | `notification/*` | content/navigation/status | compatibility | App naming over Carbon toast notification after `notification.css`. |
| `toggle.css` | `toggle/_index.scss`, `toggle/_toggle.scss` | form primitives | direct | Consume form/theme/focus tokens. |
| `toggletip.css` | `toggletip/_index.scss`, `toggletip/_toggletip.scss` | floating/overlay/actions | direct | Depends on popover/tooltip concepts. |
| `tooltip.css` | `tooltip/_index.scss`, `tooltip/_tooltip.scss` | floating/overlay/actions | direct | Depends on popover; consume motion/theme tokens. |
| `tree-view.css` | None; app naming over `treeview.css` | layout/shell/tree | compatibility | Implement only after `treeview.css`. |
| `treeview.css` | `treeview/_index.scss`, `treeview/_treeview.scss` | layout/shell/tree | direct | Consume layer/theme/type/motion tokens. |
| `ui-shell.css` | `ui-shell/_index.scss`, `_ui-shell.scss`, `_mixins.scss`, `_functions.scss` | layout/shell/tree | direct | Shell layout; route app page defaults to base if needed. |

Base-owned Carbon SCSS:

| Carbon SCSS source | Owner | Rule |
| --- | --- | --- |
| `skeleton-styles/*` | `resources/css/base/*` | Shared skeleton behavior only; component files may apply skeleton classes but should not own shared skeleton primitives. |
