---
title: Carbon Test Coverage Matrix
slug: carbon-test-coverage-matrix
status: support-reference
api_layer: Support documentation
source_reference:
  - reference/carbon-main/packages/react/src/components
  - reference/carbon-main/packages/themes/__tests__
  - reference/carbon-main/packages/styles/__tests__
  - reference/carbon-main/packages/type/__tests__
  - reference/carbon-main/packages/motion/__tests__
  - reference/carbon-main/packages/layout/__tests__
  - reference/carbon-main/packages/elements/src/__tests__
  - reference/carbon-main/packages/colors/__tests__
reviewed_on: 2026-07-02
---

# Carbon Test Coverage Matrix

## Purpose

This support reference inventories Carbon test coverage across React components and foundation packages so Login App component and element tests can be created deliberately. It does not approve Carbon parity by itself and does not make Carbon behavior local truth. Local tests must enforce only the installed Login App standard, then record Carbon discrepancies for standards review before implementation.

The inventory covers:

- `reference/carbon-main/packages/react/src/components/**/*test*`
- `reference/carbon-main/packages/themes/__tests__`
- `reference/carbon-main/packages/styles/__tests__`
- `reference/carbon-main/packages/type/__tests__`
- `reference/carbon-main/packages/motion/__tests__`
- `reference/carbon-main/packages/layout/__tests__/scss-test.js`
- `reference/carbon-main/packages/elements/src/__tests__`
- `reference/carbon-main/packages/colors/__tests__`

## Test Creation Instructions

For every local Component or Foundation Element review:

1. Create or update `resources/views/components/ui/{component}/__tests__/index.md` or `resources/views/elements/{element}/__tests__/index.md`.
2. List every Carbon test file reviewed for the owner, including adjacent `*-test.js` files and nested `__tests__` files.
3. Convert portable Carbon expectations into Login App tests only when the owning standard already adopts that behavior.
4. Add PHP `*Test.php` files for Blade contracts, public props, source ownership, static governance, data attributes, semantic markup, ARIA pairing, classes, and non-interactive states.
5. Add Playwright `*.spec.js` files for browser-only behavior: click, keyboard, focus, visibility, overlays, input value sync, sorting/filtering, selection, dismissal, and JavaScript state.
6. Record React-only items, Carbon-only APIs, and implementation mismatches as drift candidates. Do not add failing tests for those items until the Login App standard adopts them.
7. Do not port Carbon snapshots directly. Replace snapshots with explicit app-owned contract assertions.
8. Do not mark a component approved because pilot tests pass. Approval requires local standard alignment, automated coverage for adopted behavior, and manual visual/accessibility review.

## Coverage Families

| Family            | Carbon evidence                                                                                         | Expected local handling                                                                                                 |
| ----------------- | ------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------- |
| Render            | Snapshots, prop spread, custom class, root element, child element, data-testid, static class assertions | PHP Blade contract tests. Prefer explicit selectors, roles, classes, data attributes, and rendered text over snapshots. |
| A11y              | Axe, Accessibility Checker, role, aria, label, screen-reader checks                                     | PHP for static ARIA pairing and roles; Playwright plus approved accessibility tooling for browser a11y scans.           |
| Keyboard/focus    | Tab order, Enter, Space, Escape, arrows, Home/End, focus return, blur                                   | Playwright tests using real browser events and visible/focused assertions.                                              |
| Interaction/state | Click, open/close, toggle, selected, checked, sorting, filtering, menu, pagination, dismissal           | Playwright behavior tests plus PHP initial-state contracts.                                                             |
| Forms/values      | Value, checked, invalid, readonly, disabled, required, helper, label, placeholder, name                 | PHP render tests and Playwright value/state sync tests.                                                                 |
| Skeleton/loading  | Skeleton components, loading placeholders, count/open/flush skeleton props                              | PHP tests for approved skeleton APIs; drift candidate when no local skeleton exists.                                    |
| Static/export     | Public API, exports, helper functions, tokens, SCSS entrypoints                                         | Static governance tests only when the source, manifest, or docs are the product surface.                                |
| React-only        | Rerender, callbacks, render props, hooks, context, refs, controlled/uncontrolled React behavior         | Document as not portable unless Login App has an equivalent Blade, JavaScript, or route contract.                       |

## React Component Matrix

Counts are owner-level summaries extracted from 232 Carbon React component test files across 114 owner folders. `Carbon tests` is the number of test cases found from `it(...)` / `test(...)` declarations. Family assignment is a review aid; final component work must still read the named Carbon files before enforcing behavior.

| Carbon owner        | Files | Carbon tests | Families present                                                                                           | Initial Login App target                             |
| ------------------- | ----: | -----------: | ---------------------------------------------------------------------------------------------------------- | ---------------------------------------------------- |
| Accordion           |     3 |           33 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | accordion                                            |
| AILabel             |     1 |           18 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | No approved local API                                |
| AISkeleton          |     1 |            3 | Forms/values, Keyboard/focus, React-only, Render, Skeleton/loading                                         | No approved local API                                |
| AspectRatio         |     1 |            5 | A11y, Forms/values, Keyboard/focus, React-only, Render                                                     | Foundation/base utility                              |
| BadgeIndicator      |     1 |            4 | Forms/values, Interaction/state, React-only, Render                                                        | badge; status; status-icon                           |
| Breadcrumb          |     3 |           19 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | breadcrumb                                           |
| Button              |     2 |           20 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | button; button-skeleton; button variants             |
| ButtonSet           |     1 |           12 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Static/export                         | button-set                                           |
| ChatButton          |     2 |            7 | A11y, Forms/values, Keyboard/focus, React-only, Render, Skeleton/loading                                   | chat-button                                          |
| Checkbox            |     2 |           29 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | checkbox                                             |
| CheckboxGroup       |     1 |           23 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | checkbox-group                                       |
| ClassPrefix         |     1 |            1 | Forms/values, Keyboard/focus, React-only, Render                                                           | Not portable; app uses `ui-*` namespace              |
| CodeSnippet         |     2 |           20 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading, Static/export | code-snippet                                         |
| ComboBox            |     1 |          109 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading, Static/export | combo-box                                            |
| ComboButton         |     1 |           12 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | combo-button                                         |
| ComposedModal       |     3 |           66 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | modal                                                |
| ContainedList       |     1 |           19 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | contained-list                                       |
| ContentSwitcher     |     1 |           10 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | content-switcher                                     |
| ContextMenu         |     1 |            2 | A11y, Interaction/state, Keyboard/focus, React-only, Render                                                | No approved local API                                |
| Copy                |     1 |            8 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | copy-button                                          |
| CopyButton          |     1 |            7 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | copy-button                                          |
| DangerButton        |     1 |            5 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                        | danger-button                                        |
| DataTable           |    30 |          213 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading, Static/export | data-table family                                    |
| DataTableSkeleton   |     1 |           11 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | data-table-skeleton                                  |
| DatePicker          |     2 |           74 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | date-picker                                          |
| Dialog              |     1 |           25 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | dialog                                               |
| Disclosure          |     1 |            5 | A11y, Interaction/state, Keyboard/focus, React-only, Render                                                | No direct API; informs disclosure components         |
| Dropdown            |     1 |           38 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading, Static/export | dropdown                                             |
| ErrorBoundary       |     1 |            3 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | No local UI API                                      |
| ExpandableSearch    |     1 |           11 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | search                                               |
| FeatureFlags        |     1 |           17 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                        | No local UI API                                      |
| FileUploader        |     6 |           67 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading, Static/export | file-uploader family                                 |
| FluidComboBox       |     2 |           17 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading, Static/export | combo-box fluid mode                                 |
| FluidDatePicker     |     2 |            5 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | date-picker fluid mode                               |
| FluidDropdown       |     2 |           15 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading, Static/export | dropdown fluid mode                                  |
| FluidForm           |     1 |            5 | A11y, Forms/values, Keyboard/focus, React-only, Render                                                     | form                                                 |
| FluidMultiSelect    |     3 |            6 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading, Static/export | multi-select/filterable-multi-select fluid mode      |
| FluidNumberInput    |     2 |            4 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                      | number-input fluid mode                              |
| FluidSearch         |     2 |            4 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                      | search fluid mode                                    |
| FluidSelect         |     2 |            3 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                      | select fluid mode                                    |
| FluidTextArea       |     2 |           14 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | text-area fluid mode                                 |
| FluidTextInput      |     3 |           22 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | text-input/password-input fluid mode                 |
| FluidTimePicker     |     2 |            9 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | time-picker fluid mode                               |
| Form                |     1 |            2 | Forms/values, Keyboard/focus, React-only, Render                                                           | form                                                 |
| FormGroup           |     1 |            6 | Forms/values, Keyboard/focus, React-only, Render                                                           | form-group                                           |
| FormItem            |     1 |            2 | A11y, Forms/values, Keyboard/focus, React-only, Render                                                     | form-item                                            |
| FormLabel           |     1 |            3 | A11y, Forms/values, Keyboard/focus, React-only, Render                                                     | form-label                                           |
| Grid                |     5 |           43 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                        | 2x-grid element                                      |
| Heading             |     1 |            7 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                        | typography element / heading standard                |
| Icon                |     1 |            1 | Forms/values, Keyboard/focus, React-only, Render, Skeleton/loading                                         | icon; icon-skeleton                                  |
| IconButton          |     1 |           10 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | icon-button                                          |
| IconIndicator       |     1 |            5 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                        | status-icon                                          |
| IdPrefix            |     1 |            1 | Forms/values, Keyboard/focus, React-only, Render                                                           | Not portable unless ID prefix policy is adopted      |
| InlineCheckbox      |     1 |            2 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | checkbox                                             |
| InlineLoading       |     1 |           10 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                      | inline-loading                                       |
| Layer               |     2 |            6 | Forms/values, Keyboard/focus, React-only, Render                                                           | themes element                                       |
| Layout              |     1 |           10 | Forms/values, Keyboard/focus, React-only, Render                                                           | spacing / layout primitives                          |
| LayoutDirection     |     2 |            4 | Forms/values, Keyboard/focus, React-only, Render                                                           | No local direction API yet                           |
| Link                |     1 |           16 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | link                                                 |
| ListBox             |     6 |           31 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | select/combo-box/multi-select internals              |
| ListItem            |     1 |            3 | A11y, Forms/values, Keyboard/focus, React-only, Render                                                     | list-item                                            |
| Loading             |     1 |            8 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | loading                                              |
| Menu                |     1 |           30 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | menu                                                 |
| MenuButton          |     1 |           15 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | menu-button                                          |
| Modal               |     1 |           62 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | modal                                                |
| ModalWrapper        |     1 |           12 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                        | modal                                                |
| MultiSelect         |     4 |          148 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading, Static/export | multi-select; filterable-multi-select                |
| Notification        |     1 |           38 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | notification                                         |
| NumberInput         |     2 |          138 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | number-input                                         |
| OrderedList         |     1 |            6 | A11y, Forms/values, Keyboard/focus, React-only, Render                                                     | ordered-list                                         |
| OverflowMenu        |     2 |           34 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Static/export                   | overflow-menu                                        |
| OverflowMenuItem    |     1 |           18 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | menu-item                                            |
| OverflowMenuV2      |     1 |            4 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | overflow-menu future candidate                       |
| PageHeader          |     1 |           46 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Static/export                   | page-header or pattern; verify approved API          |
| Pagination          |     3 |           54 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | pagination                                           |
| PaginationNav       |     1 |           17 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | pagination-nav                                       |
| Popover             |     1 |           33 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | popover                                              |
| Portal              |     1 |            2 | Keyboard/focus, React-only, Render                                                                         | No public API unless overlay portal is approved      |
| PrimaryButton       |     1 |            3 | Forms/values, Keyboard/focus, React-only, Render                                                           | button variant                                       |
| ProgressBar         |     1 |           11 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | progress-bar                                         |
| ProgressIndicator   |     2 |           24 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | progress-indicator                                   |
| RadioButton         |     2 |           16 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | radio-button                                         |
| RadioButtonGroup    |     1 |           27 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | radio-button-group                                   |
| RadioTile           |     1 |           19 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | tile/radio tile candidate                            |
| Search              |     1 |           25 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | search                                               |
| SecondaryButton     |     1 |            4 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | button variant                                       |
| Select              |     1 |           45 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | select                                               |
| SelectItem          |     1 |            7 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                        | select-item                                          |
| SelectItemGroup     |     1 |            7 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                        | select-item-group                                    |
| ShapeIndicator      |     1 |            5 | Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                        | status-icon / shape-indicator candidate              |
| SkeletonIcon        |     1 |            1 | Forms/values, Keyboard/focus, React-only, Render, Skeleton/loading                                         | icon-skeleton                                        |
| SkeletonPlaceholder |     1 |            1 | Forms/values, Keyboard/focus, React-only, Render, Skeleton/loading                                         | No standalone API unless skeleton primitive approved |
| SkeletonText        |     1 |            2 | Forms/values, Keyboard/focus, React-only, Render, Skeleton/loading                                         | No standalone API unless skeleton primitive approved |
| Slider              |     2 |           93 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | slider                                               |
| Stack               |     1 |            6 | Forms/values, Keyboard/focus, React-only, Render                                                           | stack                                                |
| StructuredList      |     2 |           38 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading, Static/export | structured-list                                      |
| Switch              |     2 |           15 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | switch; toggle                                       |
| TabContent          |     1 |            2 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | tabs                                                 |
| Tabs                |     3 |           60 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | tabs                                                 |
| Tag                 |     1 |           33 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading, Static/export | tag                                                  |
| Text                |     2 |            6 | Forms/values, Keyboard/focus, React-only, Render                                                           | typography element                                   |
| TextArea            |     1 |           41 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | text-area                                            |
| TextInput           |     4 |           92 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | text-input                                           |
| Theme               |     1 |            8 | Forms/values, Keyboard/focus, React-only, Render, Static/export                                            | themes element                                       |
| Tile                |     1 |           40 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | tile                                                 |
| TileGroup           |     1 |           13 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | tile group candidate                                 |
| TimePicker          |     1 |           23 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | time-picker                                          |
| Toggle              |     2 |           15 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | toggle                                               |
| ToggleSmall         |     1 |            3 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render, Skeleton/loading                | toggle variant / toggle-small-skeleton               |
| Toggletip           |     1 |           37 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | toggletip                                            |
| Tooltip             |     2 |           24 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | tooltip                                              |
| TreeView            |     2 |           58 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | tree-view                                            |
| UIShell             |    30 |          188 | A11y, Forms/values, Interaction/state, Keyboard/focus, React-only, Render                                  | shell/app layout and navigation patterns             |
| UnorderedList       |     1 |            4 | Forms/values, Keyboard/focus, React-only, Render                                                           | unordered-list                                       |

## Carbon Component Folders Without Independent Test Owner Rows

These Carbon component folders do not have their own direct owner row in the React matrix. Some are covered by parent component tests; others are reference gaps that require direct source review before local test creation.

| Carbon folder         | Coverage note                                                                                                                        |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------ |
| AccordionItem         | Covered inside Accordion tests.                                                                                                      |
| BreadcrumbItem        | Covered inside Breadcrumb tests.                                                                                                     |
| DatePickerInput       | Review through DatePicker tests and source before local coverage.                                                                    |
| FlexGrid              | Review through Grid tests and source before local coverage.                                                                          |
| FluidDatePickerInput  | Review through FluidDatePicker tests and source before local coverage.                                                               |
| FluidTimePickerSelect | Review through FluidTimePicker tests and source before local coverage.                                                               |
| HideAtBreakpoint      | No independent Carbon test row found; treat as reference gap.                                                                        |
| Icons                 | No independent Carbon React component test row found; local icon coverage should use icon registry and generated manifest contracts. |
| PasswordInput         | Covered through TextInput password input tests.                                                                                      |
| Plex                  | No independent Carbon test row found; treat as reference evidence only unless typography standards adopt it.                         |
| Tab                   | Covered through Tabs tests.                                                                                                          |
| TimePickerSelect      | Review through TimePicker tests and source before local coverage.                                                                    |

## Foundation Package Matrix

| Carbon package test                                 |            Carbon tests | Families present                                                 | Initial Login App target                                  | Expected local behavior                                                                                                                                          |
| --------------------------------------------------- | ----------------------: | ---------------------------------------------------------------- | --------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `packages/themes/__tests__/scss-test.js`            |                       7 | SCSS build, public API, tokens                                   | `resources/views/elements/themes`; theme token CSS        | Verify theme maps, fallback behavior, custom theme values, and property prefix handling only where Login App exposes equivalent theme tokens or build contracts. |
| `packages/styles/__tests__/compat-test.js`          |                       6 | SCSS build, public API, tokens, compatibility, static exports    | CSS build/reference governance                            | Track compatibility expectations as reference evidence. Do not enforce Carbon v10/v11 compatibility unless Login App standards explicitly adopt it.              |
| `packages/styles/__tests__/styles-test.js`          |                       4 | SCSS build, public API, tokens, snapshots, static exports        | CSS entrypoint/build governance                           | Verify app CSS entrypoints, independent imports, and config overrides only for local build surfaces. Replace snapshots with explicit source/build assertions.    |
| `packages/type/__tests__/scss-test.js`              |                       2 | SCSS build, public API, type tokens, static exports              | `resources/views/elements/typography`; type token CSS     | Verify emitted type token properties and CSS custom properties for local typography tokens.                                                                      |
| `packages/motion/__tests__/motion-test.js`          |                       4 | SCSS build, public API, motion tokens, snapshots, static exports | `resources/views/elements/motion`; motion token CSS       | Verify known duration/easing tokens and unknown-token rejection only if local helpers expose that behavior.                                                      |
| `packages/layout/__tests__/scss-test.js`            | 5 dynamic export groups | SCSS build, public API, layout tokens, static exports            | `resources/views/elements/2x-grid`; spacing/layout tokens | Verify spacing, fluid spacing, container, icon size, and layout scale token availability where local layout tokens expose comparable contracts.                  |
| `packages/elements/src/__tests__/PublicAPI-test.js` |                       1 | Public API, snapshots, static exports                            | Foundation Element public API governance                  | Treat as source-governance evidence for local element registry/API stability. Do not snapshot the entire app export surface.                                     |
| `packages/colors/__tests__/colors-test.js`          |                       2 | Color tokens, snapshots, static exports                          | `resources/views/elements/color`; color token CSS         | Verify color and hover color token availability against app-approved palette names.                                                                              |
| `packages/colors/__tests__/scss-test.js`            |                       1 | SCSS build, public API, color tokens, snapshots, static exports  | `resources/views/elements/color`; color token CSS         | Verify local SCSS/CSS color token entrypoint integrity if the build exposes a comparable API.                                                                    |

## Required Local Index Template

Each local `__tests__/index.md` should use this structure:

```markdown
# {Surface} Tests

## Purpose

This folder owns co-located tests for `{surface}`.

Current status: pilot coverage only / partial coverage / approved coverage.

## Carbon Files Reviewed

- `reference/carbon-main/...`

## Local Files Covered

- `resources/views/components/ui/{surface}/index.blade.php`
- `resources/js/...` when behavior is installed
- `docs/02-standards/ui/...`

## Local Standards Consulted

- `docs/02-standards/ui/...`

## Implemented Tests

- PHP tests...
- Browser tests...

## Carbon Assertion Coverage

| Carbon assertion family | Local status                                               | Notes |
| ----------------------- | ---------------------------------------------------------- | ----- |
| Render                  | Covered / partially covered / not covered                  | ...   |
| A11y                    | Covered / partially covered / not covered                  | ...   |
| Keyboard/focus          | Covered / partially covered / not covered                  | ...   |
| Interaction/state       | Covered / partially covered / not covered                  | ...   |
| Forms/values            | Covered / partially covered / not covered                  | ...   |
| Skeleton/loading        | Covered / partially covered / not covered / no local API   | ...   |
| Static/export           | Covered / partially covered / not covered / not applicable | ...   |
| React-only              | Not portable                                               | ...   |

## Intentional Divergences

- ...

## Drift Candidates Not Yet Enforced

- ...
```

## High-Risk Owners

These Carbon owners have broad test surfaces and should not be represented by one smoke test:

| Owner               | Reason                                                                                                                                |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------------- |
| DataTable           | 30 files and 213 parsed tests across table structure, toolbar, selection, expansion, sorting, filtering, tools, and state derivation. |
| UIShell             | 30 files and 188 parsed tests across header, side nav, switcher, panels, skip link, and shell subcomponents.                          |
| MultiSelect         | 4 files and 148 parsed tests across filtering, sorting, selection, keyboard, and listbox internals.                                   |
| NumberInput         | 2 files and 138 parsed tests across value parsing, min/max, increment/decrement, disabled/invalid states, and skeleton.               |
| ComboBox            | 1 file and 109 parsed tests across filtering, selection, keyboard, menu, value, and accessibility.                                    |
| Slider              | 2 files and 93 parsed tests across drag/keyboard/value behavior, ranges, bounds, disabled state, and skeleton.                        |
| DatePicker          | 2 files and 74 parsed tests across calendar, input, date value, disabled/invalid state, and skeleton.                                 |
| Modal/ComposedModal | 4 files and 128 parsed tests across focus trap, dismissal, open/close, header/footer/body composition, and accessibility.             |

These surfaces need behavior-family test files or clearly separated tests inside the same co-located folder. Do not collapse them into one catch-all test file.
