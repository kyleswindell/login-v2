---
title: Tabs
slug: tabs
api_layer: Component API
status: implemented-pending-manual-review
system_maturity: partial
category: navigation-and-disclosure
priority: tier-b-common-reusable-component
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/tabs.md
source_owner: not installed
blade_api:
  - x-ui.tabs
javascript_api:
  - initTabs exported from resources/js/ui-controls/tabs.js
data_attributes:
  - data-ui-tabs
  - data-ui-tabs-list
  - data-ui-tabs-tab
  - data-ui-tabs-panel
  - data-ui-tabs-dismiss
source_files:
  - resources/views/components/ui/tabs/index.blade.php
  - resources/js/ui-controls/tabs.js
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
related_components:
  - button
  - icon-button
  - breadcrumb
  - progress-indicator
  - menu
related_patterns:
  - navigation
  - layout
  - forms
  - overlays-feedback
carbon_reference:
  - https://carbondesignsystem.com/components/tabs/usage/
  - https://carbondesignsystem.com/components/tabs/style/
  - https://carbondesignsystem.com/components/tabs/accessibility/
---

# Tabs Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. `x-ui.tabs` props and options](#43-x-uitabs-props-and-options)
  - [4.4. Tab item data contract](#44-tab-item-data-contract)
  - [4.5. JavaScript API](#45-javascript-api)
  - [4.6. Initializer responsibilities:](#46-initializer-responsibilities)
  - [4.7. Data attribute contract](#47-data-attribute-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
  - [9.3. Variant selection:](#93-variant-selection)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and Rendered Evidence Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. rendered evidence proof checklist](#142-ui-reference-proof-checklist)
- [15. Rendered evidence requirements](#15-ui-reference-requirements)
  - [15.1. Required Live examples internal sections:](#151-required-live-examples-internal-sections)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Tabs switch between peer panels while keeping the user in the same task context.

Canonical API owner: `not installed`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Tabs is the installed Login App 2.0 peer-panel switching API. It owns tablist semantics, tab-panel relationships, selected and unselected states, keyboard navigation, activation mode, scrollable horizontal tablists, contained and line visual variants, optional icons, optional dismiss buttons, disabled tabs, vertical tab layout, and token-backed tab states. It does not own primary site navigation, breadcrumbs, linear progress, required workflow steps, page routing, table filtering, comparison views, or page-level layout.

### 1.1. Canonical API responsibilities:

- Render peer content switching through `x-ui.tabs`.
- Represent each tab and panel with stable IDs and matching ARIA relationships.
- Support line, contained, and vertical variants.
- Support automatic and manual activation modes.
- Support selected, unselected, hover, focus-visible, disabled, scrollable, and dismissible states.
- Support optional leading icons and icon-only tabs only when accessible names and tooltip behavior are provided.
- Support horizontal overflow through scrolling instead of wrapping.
- Initialize keyboard, selected-state, panel visibility, dismissible, and overflow behavior through `initTabs`.
- Consume Foundation Element APIs for color, spacing, typography, themes, and motion.
- Prove variants, item data, keyboard behavior, overflow, responsive handoff, and prohibited usage on the rendered evidence page.

### 1.2. Non-owned responsibilities:

- Primary app, section, or route navigation. Use Navigation Pattern or Breadcrumb where appropriate.
- Linear task progress or required sequential steps. Use Progress indicator.
- Switching mutually exclusive form choices. Use Radio, Select, or Content switcher when installed.
- Comparing two or more data sets side by side. Use Data table, cards, or Pattern-owned comparison layouts.
- Disclosure of one independent content block at a time. Use Accordion when installed.
- Menu or command disclosure. Use Menu.
- External spacing, page grid placement, card placement, modal placement, and workflow orchestration. Parent Patterns own those responsibilities.

## 2. Status and ownership

| Field                        | Value                                                                                                       |
| ---------------------------- | ----------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented - pending manual review                                                                         |
| System maturity              | Partial                                                                                                     |
| API layer                    | Component API                                                                                               |
| Component slug               | `tabs`                                                                                                      |
| Category                     | Navigation and disclosure                                                                                   |
| Priority                     | Tier B - Common reusable component                                                                          |
| Rendered evidence route           | `not installed`                                                                    |
| Canonical doc                | `docs/02-standards/ui/components/tabs.md`                                                                   |
| Source owner                 | `not installed`                                                                    |
| Blade API                    | `x-ui.tabs`                                                                                                 |
| JavaScript API               | `initTabs` from `resources/js/ui-controls/tabs.js`                                                          |
| Data attributes              | App-owned `data-ui-tabs*` attributes emitted by the component implementation                                |
| Source files                 | `resources/views/components/ui/tabs/index.blade.php`; `resources/js/ui-controls/tabs.js`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion                                                                  |
| Carbon benchmark             | Carbon Tabs usage, style, and accessibility guidance                                                        |

`Implemented - pending manual review` means the component API, JavaScript initializer, and Rendered evidence route exist, but this standard must make the installed Tabs contract explicit and replace placeholder language such as “Allowed variants: None” with the real installed variants, options, states, and gates.

## 3. Installed standard

Tabs has a corrected component-specific rendered evidence page with canonical app examples, rendered variants, and recovery assertions.

### 3.1. The installed standard is:

- Render tabbed peer panels through `<x-ui.tabs>`.
- Pass tab data through the `tabs` prop.
- Use stable tab IDs when panel state must persist or tests need deterministic selectors.
- Select one tab by default, usually the first enabled tab.
- Use `variant="line"` for flexible page, modal, card, or component sections.
- Use `variant="contained"` when the selected panel should read as a defined surface attached to the tablist.
- Use `orientation="vertical"` for stable-height panels where top-to-bottom scanning is more efficient.
- Use `activation="automatic"` only when each panel can render instantly without disruptive state loss.
- Use `activation="manual"` when panels are heavy, remote-loaded, form-like, or visually disruptive.
- Use horizontal scrolling for overflow. Do not wrap horizontal tabs onto multiple lines.
- Use dismissible tabs only for user-created or user-curated content.
- Use disabled tabs only when the tab may become available later.
- Hide permission-impossible tabs instead of disabling them.
- Use icons only when they reinforce clear tab labels.
- Use icon-only tabs only with accessible names and tooltip behavior.
- Initialize behavior with `initTabs`.
- Do not use raw utility clusters, raw colors, local icons, direct Carbon classes, or feature-local JavaScript to create tabs.

Carbon alignment note: Carbon positions tabs as related views within the same context, supports line, contained, and vertical treatments, documents scrollable overflow, icon and dismissible use cases, and expects keyboard/ARIA behavior where tablists, tabs, and panels remain properly related. Login App maps those principles to its own `x-ui.tabs`, `initTabs`, app-owned `data-ui-tabs*` attributes, and `ui-*` class contract instead of adopting Carbon implementation classes directly.

## 4. Public API

### 4.1. Canonical calls

Use array-driven tabs for the installed API.

```blade
@php
    $tabs = [
        [
            'id' => 'profile',
            'label' => 'Profile',
            'panel' => view('settings.partials.profile')->render(),
            'selected' => true,
        ],
        [
            'id' => 'security',
            'label' => 'Security',
            'panel' => view('settings.partials.security')->render(),
        ],
        [
            'id' => 'notifications',
            'label' => 'Notifications',
            'panel' => view('settings.partials.notifications')->render(),
        ],
    ];
@endphp

<x-ui.tabs :tabs="$tabs" variant="line" />
```

Use contained tabs when the panel should visually attach to the tablist.

```blade
<x-ui.tabs
    :tabs="$tenantTabs"
    variant="contained"
    activation="manual"
    aria-label="Tenant settings"
/>
```

Use vertical tabs when labels benefit from top-to-bottom scanning and panel height remains stable.

```blade
<x-ui.tabs
    :tabs="$adminTabs"
    variant="line"
    orientation="vertical"
    activation="manual"
    aria-label="Admin sections"
/>
```

Use dismissible tabs only for user-created or user-curated content.

```blade
@php
    $tabs = [
        [
            'id' => 'draft-103',
            'label' => 'Draft 103',
            'panel' => view('drafts.panels.edit', ['draft' => $draft])->render(),
            'dismissible' => true,
            'dismissLabel' => 'Close Draft 103',
        ],
    ];
@endphp

<x-ui.tabs :tabs="$tabs" variant="line" />
```

Use the Blade API instead of hand-building tablist, tab, panel, and keyboard behavior in feature views.

### 4.2. API surfaces

| API surface           | Installed value                                                                                             |
| --------------------- | ----------------------------------------------------------------------------------------------------------- |
| Blade API             | `x-ui.tabs`                                                                                                 |
| JavaScript            | `initTabs` exported from `resources/js/ui-controls/tabs.js`                                                 |
| Root semantic element | Tablist and paired tab panels emitted by the component                                                      |
| Data attributes       | `data-ui-tabs*` attributes emitted by the component implementation                                          |
| CSS namespace         | App-owned `ui-*` tabs classes documented by this standard                                                   |
| Source files          | `resources/views/components/ui/tabs/index.blade.php`; `resources/js/ui-controls/tabs.js`; `resources/css/app.css` |

### 4.3. `x-ui.tabs` props and options

| Prop/option       | Type            | Default                        | Allowed values                  | Required                                            | Notes                                                                                                          |
| ----------------- | --------------- | ------------------------------ | ------------------------------- | --------------------------------------------------- | -------------------------------------------------------------------------------------------------------------- |
| `tabs`            | `array`         | none                           | Tab item data contract entries  | Yes                                                 | Each item defines a tab and matching panel.                                                                    |
| `variant`         | `string`        | `line`                         | `line`, `contained`             | No                                                  | Use `line` for flexible sections; use `contained` for attached panel surfaces.                                 |
| `orientation`     | `string`        | `horizontal`                   | `horizontal`, `vertical`        | No                                                  | Vertical tabs require stable panel height and enough viewport width.                                           |
| `activation`      | `string`        | `automatic`                    | `automatic`, `manual`           | No                                                  | Manual activation waits for Enter or Space after arrow-key focus movement.                                     |
| `size`            | `string`        | `md`                           | `sm`, `md`, `lg`                | No                                                  | Use `sm` for compact regions, `md` for default app UI, `lg` for larger surfaces.                               |
| `selected`        | `string / null` | first enabled tab              | Tab item `id`                   | No                                                  | Selects an initial tab by ID. Item-level `selected` may also be used.                                          |
| `aria-label`      | `string / null` | inferred when possible         | Short tablist name              | Required when no visible heading labels the tablist | Use when more than one tablist appears on a page.                                                              |
| `aria-labelledby` | `string / null` | `null`                         | Existing heading ID             | No                                                  | Preferred when a visible heading labels the tablist.                                                           |
| `scrollable`      | `bool`          | `true` for horizontal overflow | `true`, `false`                 | No                                                  | Horizontal tabs scroll instead of wrapping.                                                                    |
| `class`           | `string / null` | `null`                         | Layout passthrough if supported | No                                                  | Parent Patterns may pass layout classes. Do not use for local color, typography, state, or behavior overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and rendered evidence proof before production use.

### 4.4. Tab item data contract

Each entry in the `tabs` prop must use this contract.

| Field            | Type            | Required                                                                     | Notes                                                                                                  |
| ---------------- | --------------- | ---------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------ |
| `id`             | `string`        | Strongly recommended                                                         | Stable unique tab ID. Required when selected state, dismissal, or tests need deterministic references. |
| `label`          | `string`        | Yes unless icon-only tab has `ariaLabel`                                     | Visible tab text. Use short panel descriptors.                                                         |
| `panel`          | `string         | \Illuminate\Contracts\Support\Htmlable`                                      | Yes                                                                                                    | Rendered panel content. Escape unsafe strings before passing. |
| `icon`           | `string / null` | No                                                                           | Internal icon alias/component. Use as a leading icon only.                                         |
| `ariaLabel`      | `string / null` | Required for icon-only tabs                                                  | Accessible tab name. Must describe the panel, not the icon.                                            |
| `tooltip`        | `string / null` | Required for icon-only production tabs when tooltip integration is installed | Tooltip text should match or clarify `ariaLabel`.                                                      |
| `secondaryLabel` | `string / null` | No                                                                           | Use only for contained tabs that need compact secondary context.                                       |
| `selected`       | `bool`          | No                                                                           | Selects this item by default. Only one tab may be selected.                                            |
| `disabled`       | `bool`          | No                                                                           | Visible unavailable tab. Hide permission-impossible tabs instead.                                      |
| `dismissible`    | `bool`          | No                                                                           | Use only for user-created or user-curated tabs.                                                        |
| `dismissLabel`   | `string / null` | Required when `dismissible` is true                                          | Accessible name for dismiss action, such as `Close Draft 103`.                                         |
| `href`           | `string / null` | Not public for installed client-side tabs                                    | Use Navigation Pattern for route navigation.                                                           |
| `badge`          | `string/int`    | No                                                                           | Deferred count/tag indicator value. Requires Tag or count-indicator integration and rendered evidence proof before production use. |

### 4.5. JavaScript API

`initTabs` is the installed initializer for app-owned tabs behavior.

```js
import { initTabs } from './ui-controls/tabs';

initTabs();
```

### 4.6. Initializer responsibilities:

- Bind tablists, tabs, panels, and dismiss controls emitted by `x-ui.tabs`.
- Synchronize `aria-selected`, `tabindex`, panel visibility, and selected state classes.
- Move focus across enabled tabs with arrow keys.
- Support Home and End when implemented by the initializer.
- Activate tabs automatically or manually based on the `activation` option.
- Activate manual tabs with Enter or Space.
- Keep disabled tabs out of interaction.
- Preserve focus behavior for dismissible tabs when a selected tab is closed.
- Support horizontal scroll affordances and vertical orientation.
- Respect reduced-motion preferences for any indicator or panel transitions.

Feature code may call `initTabs()` after injecting server-rendered tab markup into the page. Feature code must not fork the initializer, create local tab keyboard handlers, or add undocumented data attributes.

### 4.7. Data attribute contract

These attributes are app-owned implementation hooks. They are emitted by the Blade component and consumed by `initTabs`.

| Data attribute         | Owner                | Purpose                                         |
| ---------------------- | -------------------- | ----------------------------------------------- |
| `data-ui-tabs`         | Component            | Root tabs instance.                             |
| `data-ui-tabs-list`    | Component/JavaScript | Tablist container.                              |
| `data-ui-tabs-tab`     | Component/JavaScript | Individual tab control.                         |
| `data-ui-tabs-panel`   | Component/JavaScript | Panel associated with one tab.                  |
| `data-ui-tabs-dismiss` | Component/JavaScript | Optional dismiss control for user-created tabs. |

Do not author new `data-*` hooks for tabs behavior in feature views. Additions require an update to the component, standard, JavaScript initializer, and rendered evidence proof.

## 5. Allowed variants, options, and modifiers

| Name                               | Type        | Status                                        | API                                                                                      | Notes                                                                                    |
| ---------------------------------- | ----------- | --------------------------------------------- | ---------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------- |
| Line tabs                          | Variant     | Implemented                                   | `variant="line"`                                                                         | Flexible page, modal, card, or component sections.                                       |
| Contained tabs                     | Variant     | Implemented                                   | `variant="contained"`                                                                    | Tabs attached to a defined panel surface.                                                |
| Horizontal tabs                    | Orientation | Implemented                                   | `orientation="horizontal"`                                                               | Default. Overflow scrolls instead of wrapping.                                           |
| Vertical tabs                      | Orientation | Implemented                                   | `orientation="vertical"`                                                                 | Use when scanning benefits from vertical labels and panels remain stable.                |
| Automatic activation               | Mode        | Implemented                                   | `activation="automatic"`                                                                 | Arrow focus selects the tab immediately. Use for lightweight panels.                     |
| Manual activation                  | Mode        | Implemented                                   | `activation="manual"`                                                                    | Arrow focus moves only; Enter/Space selects. Use for heavier panels.                     |
| Scrollable horizontal tabs         | Modifier    | Implemented                                   | `scrollable`                                                                             | Required for overflow. Do not wrap tabs.                                                 |
| Disabled tab                       | State       | Implemented                                   | Item `disabled`                                                                          | Use only when the tab may become available later.                                        |
| Dismissible tab                    | Modifier    | Implemented                                   | gated by content                                                                         | Item `dismissible` / User-created or user-curated content only. Requires `dismissLabel`. |
| Leading icon                       | Modifier    | Implemented                                   | Item `icon`                                                                              | Use only when it reinforces the label.                                                   |
| Icon-only tab                      | Modifier    | Implemented / gated                           | Item `ariaLabel` plus icon and tooltip behavior                                          | Use sparingly; requires accessible name and tooltip.                                     |
| Secondary label                    | Composition | Implemented for contained tabs                | Item `secondaryLabel`                                                                    | Use for compact extra context, not full descriptions.                                    |
| Small                              | Size        | Implemented / required proof                  | `size="sm"`                                                                              | Compact cards, toolbars, or constrained panels.                                          |
| Medium                             | Size        | Implemented / required proof                  | `size="md"`                                                                              | Default app tab size.                                                                    |
| Large                              | Size        | Implemented / required proof                  | `size="lg"`                                                                              | Larger surfaces only when Pattern-owned.                                                 |
| Count/tag tab                      | Modifier    | Deferred                                      | none                                                                                     | Requires Tag or count-indicator integration and rendered evidence proof.                      |
| Route/navigation tab               | Gated       | Pattern-owned                                 | none                                                                                     | Use Navigation Pattern unless the tablist remains in-page and peer-panel based.          |
| Nested tabs                        | Gated       | none                                          | Requires Pattern approval to avoid navigation confusion.                                 |                                                                                          |
| Closable unsaved tab workflow      | Gated       | `dismissible` plus Pattern-owned confirmation | Requires unsaved-change confirmation and focus recovery rules.                           |                                                                                          |
| Multi-row horizontal tabs          | Not allowed | none                                          | Horizontal tabs must scroll instead of wrapping.                                         |                                                                                          |
| Icon mixed randomly with text tabs | Not allowed | none                                          | Do not mix icons into only some tabs unless each icon has consistent structural meaning. |                                                                                          |

## 6. States

| State                 | Status                                          | Implementation requirement                                                                                                    |
| --------------------- | ----------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------- |
| Default               | Implemented                                     | Renders one selected enabled tab and matching visible panel.                                                                  |
| Selected              | Implemented                                     | Selected tab exposes `aria-selected="true"`, active class, and visible panel.                                                 |
| Unselected            | Implemented                                     | Unselected tabs expose `aria-selected="false"` and hidden panels.                                                             |
| Hover                 | Implemented                                     | Token-backed hover treatment for enabled tabs.                                                                                |
| Focus-visible         | Implemented                                     | Token-backed focus treatment visible in all supported themes.                                                                 |
| Active/pressed        | Implemented                                     | Pointer or keyboard activation uses token-backed active treatment where installed.                                            |
| Disabled              | Implemented                                     | Disabled tabs are removed from interaction and do not switch panels.                                                          |
| Scrollable            | Implemented                                     | Horizontal overflow scrolls and preserves one-line tab layout.                                                                |
| Dismissible           | Implemented                                     | Dismiss control is keyboard reachable and has an accessible label.                                                            |
| Dismiss hover/focus   | Implemented where dismissible tabs are rendered | Close control states remain distinct from tab selection state.                                                                |
| Vertical              | Implemented                                     | Vertical tablist and panel remain on the same layer and do not become primary navigation.                                     |
| Icon-leading          | Implemented                                     | Icon reinforces label and mirrors correctly in RTL contexts.                                                                  |
| Icon-only             | Implemented / gated                             | Requires accessible name and tooltip behavior.                                                                                |
| Empty                 | Not allowed                                     | Do not render a tablist with fewer than two available tabs. Render the panel content directly.                                |
| Loading               | Not applicable                                  | Tabs switch peer panels; use Inline loading or Skeleton inside the panel when panel content is pending.                       |
| Error/warning/success | Not owned by Tabs                               | Use Notification, Tag, or panel content. A future Tag/count integration is deferred.                                           |
| Read-only             | Not applicable                                  | Tabs are navigation controls. Render static content instead if switching is not allowed.                                      |
| Validation            | Not applicable                                  | Validation belongs to fields/forms inside panels. Tabs may expose summaries only through a future Tag/Notification Pattern.   |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Tabs consumes Foundation Color, Spacing, Typography, Themes, and Motion.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.

2x Grid is parent-owned when tabs are placed in pages, panels, cards, modals, or shell layouts. Icons are consumed only when tab item icons or dismiss controls are rendered.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                                                              |
| ----------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Selected indicator, tab text, panel border/background, hover, focus, disabled, scroll affordances, and dismiss control states.                                             |
| Spacing     | Tab padding, tablist gap/stack, panel offset, contained panel inset, scroll affordance spacing, and vertical tab/panel gap.                                                |
| Typography  | Tab label, secondary label, icon-only tooltip text through Tooltip API, and panel heading relationships.                                                                   |
| Themes      | Light/dark/inverse token resolution for selected, unselected, hover, focus-visible, disabled, contained, and vertical states.                                              |
| Motion      | Short productive transitions for selected indicator, panel visibility, scroll affordance, and dismiss entry/exit where installed; must respect reduced-motion preferences. |
| Icons       | Internal icon components for leading tab icons, icon-only tabs, and dismiss controls when enabled.                                                                               |
| 2x Grid     | Parent Pattern placement for vertical tabs, page sections, cards, modals, and side panels.                                                                                 |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$border-interactive` | Line/vertical selected indicator | `ui-tabs-tab-selected`, selected indicator role | App border-interactive palette | Same role / app value | Selected indicators must not use arbitrary brand utilities. |
| `$text-secondary`, `$text-disabled` | Unselected and disabled tab labels | Tab label text roles | App text palette | Same role / app value | Tab text hierarchy stays Color/Typography-owned. |
| `$layer`, `$layer-accent`, `$button-disabled` | Contained selected/unselected/disabled tab backgrounds | Contained tab surface roles | App layer/action-disabled palettes | Same role / app value | Contained tabs use layer roles; disabled contained background maps to disabled action role only where installed. |
| `$layer-hover` | Vertical/contained hover surface | Tab hover state | App layer state palette | Same role / app value | Hover state shares layer hover mapping. |
| `$border-strong`, `$border-disabled` | Line tab hover and disabled borders | Tab border state roles | App border palette | Same role / app value | Border state values stay Color-owned. |
| `$focus` | Tab and dismiss control focus | Tab focus-visible state | App focus palette | Same role / app value | Focus must be preserved for tabs and dismiss controls. |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-tabs
.ui-tabs-line
.ui-tabs-contained
.ui-tabs-horizontal
.ui-tabs-vertical
.ui-tabs-list
.ui-tabs-tab
.ui-tabs-tab-selected
.ui-tabs-tab-disabled
.ui-tabs-tab-dismissible
.ui-tabs-tab-icon
.ui-tabs-tab-label
.ui-tabs-tab-secondary-label
.ui-tabs-tab-dismiss
.ui-tabs-panel
.ui-tabs-panel-active
.ui-tabs-scroll
.ui-tabs-sm
.ui-tabs-md
.ui-tabs-lg
```

Feature views must not create local `tabs-*`, `tab-*`, Bootstrap `.nav-tabs`, raw utility clusters, arbitrary hex colors, arbitrary spacing, local SVG icons, custom focus rings, direct Carbon classes, or component-local JavaScript for the same UI role.

## 8. Composition rules

- Render tabs only when two or more available peer panels exist.
- One tab is selected by default, usually the first enabled tab.
- Selecting a tab deselects the previously selected tab and updates the visible panel.
- Automatic tablists select when arrow focus moves.
- Manual tablists wait for Enter or Space after arrow focus moves.
- Horizontal tabs scroll instead of wrapping.
- Vertical tabs keep the tablist and panel on the same layer.
- Disabled tabs remain visible only when they may become available later.
- Permission-impossible tabs must be hidden instead of disabled.
- Dismissible tabs are allowed only for user-created or user-curated content.
- Dismissing the selected tab must move selection and focus to a predictable remaining tab.
- Icon-only tabs require accessible names and Tooltip Pattern behavior.
- Do not mix icon-only and text tabs in the same structural tablist unless the rendered evidence proves the combined pattern.
- Do not put unrelated workflows in sibling tabs.
- Do not use tabs for steps that must be completed in order.
- Do not use tabs for route-level navigation or site navigation.
- Parent Patterns own grouping, external spacing, page grid placement, modal/side-panel placement, and workflow orchestration.
- Components own internal semantics, selected state, keyboard behavior, panel visibility, scroll behavior, and token-backed states.

## 9. Selection guidance

### 9.1. Use when:

- Peer content panels belong to the same task context.
- Users can switch between panels without losing their place in the workflow.
- The content sections are related, parallel, and non-linear.
- The tab labels remain short enough to scan.
- A page, modal, card, or side panel needs local content switching without route navigation.

### 9.2. Do not use when:

- The control is primary navigation across app areas. Use Navigation Pattern.
- The control represents a user’s position in a required linear flow. Use Progress indicator.
- The control changes a small form value. Use Radio, Select, Checkbox, or Toggle.
- The control hides one-off supporting content. Use Accordion, Disclosure, or Help text when installed.
- The user must compare content side by side.
- Panels are unrelated or would be better as separate pages.
- Only one panel is available. Render the content directly.
- There are too many tabs to scan even with horizontal scrolling. Use a Pattern-owned index, page navigation, or filterable list.

### 9.3. Variant selection:

| Need                                                  | Use                          |
| ----------------------------------------------------- | ---------------------------- |
| Flexible page, modal, card, or component sections     | `variant="line"`             |
| Defined panel surface attached to the tablist         | `variant="contained"`        |
| Quick scanning with stable panel height               | `orientation="vertical"`     |
| Lightweight panel content                             | `activation="automatic"`     |
| Heavy, remote, form-like, or disruptive panel content | `activation="manual"`        |
| Overflowing horizontal labels                         | Scrollable horizontal tabs   |
| User-created or user-curated panels                   | Dismissible tabs             |
| Required ordered task progress                        | Progress indicator, not Tabs |
| Route-level navigation                                | Navigation Pattern, not Tabs |

## 10. Accessibility contract

- The tablist must use `role="tablist"`.
- Each tab must use `role="tab"`.
- Each panel must use `role="tabpanel"`.
- Each tab must have a unique ID.
- Each panel must have a unique ID.
- Each tab must reference its panel through `aria-controls`.
- Each panel must reference its tab through `aria-labelledby`.
- Exactly one tab is selected unless the tablist has no enabled tabs, which is not an approved production state.
- Selected tabs expose `aria-selected="true"` and are in the tab order.
- Unselected tabs expose `aria-selected="false"` and use roving `tabindex` behavior.
- Arrow keys move focus through enabled tabs.
- Home and End should move focus to the first and last enabled tabs when supported by the installed initializer.
- Enter and Space activate tabs in manual activation mode.
- Disabled tabs are removed from interaction and are not required to meet active-control contrast.
- The visible focus indicator must not be suppressed.
- Horizontal tablists use Left/Right arrows; vertical tablists use Up/Down arrows.
- RTL contexts must mirror horizontal arrow behavior where the installed initializer supports it.
- When tabbing away from the tablist, focus moves into the selected panel or to the next logical focusable control.
- Icon-only tabs require accessible names and Tooltip Pattern behavior.
- Dismiss controls require action-specific labels such as `Close Draft 103`.
- Dismissing a tab must preserve focus predictably.
- Do not rely on color alone for selected, disabled, hover, focus, or dismissible state.
- Maintain contrast in supported light and dark themes.

## 11. Content contract

- Use short labels that describe panel content.
- Use sentence case.
- Prefer nouns or noun phrases for tab labels: `Overview`, `Activity`, `Settings`, `Members`.
- Avoid verb-led command labels because tabs are peer-panel switches, not actions.
- Keep labels unique within the tablist.
- Avoid repeating the same term across every label. Move shared context to the tablist heading or surrounding page title.
- Use secondary labels only when compact additional context helps distinguish similar contained tabs.
- Keep secondary labels shorter than the primary label.
- Use icons only when they add recognition value.
- Do not mix icon tabs with non-icon tabs in the same list when icons are used for structure.
- Icon-only tab accessible labels must describe the panel content, not the icon.
- Dismissible tab close labels must include the tab name.
- Truncate only when the full label remains available through approved title text or Tooltip Pattern behavior.
- Do not use tabs labeled `Tab 1`, `Tab 2`, `More`, `Misc`, or `Other` unless those are actual user-facing names from a domain model.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, custom focus rings, or custom JavaScript.
- Do not create feature-local tabs, nav-tabs, segmented controls, or peer-panel switchers for the same UI role.
- Do not use Bootstrap `.nav-tabs`, `.nav-pills`, `.tab-content`, or direct Carbon production classes.
- Do not use tabs as primary navigation.
- Do not use tabs for progress, comparison, or required linear steps.
- Do not wrap horizontal tabs onto multiple lines; use horizontal scroll.
- Do not render fewer than two available tabs.
- Do not put unrelated workflows in sibling tabs.
- Do not use disabled tabs for permission-impossible content.
- Do not mix automatic activation with heavy or remote-loading panels.
- Do not use dismissible tabs for system-owned fixed sections.
- Do not use icon-only tabs without accessible names and tooltip behavior.
- Do not mix icon-only and text tabs unless the pattern is explicitly proven.
- Do not add route navigation to Tabs without Navigation Pattern approval.
- Do not add nested tabs without Pattern approval.
- Do not use arbitrary local badges, counts, colors, or status dots in tabs.
- Do not rely on color alone for selected, disabled, hover, focus, or dismissible state.

## 13. Deferred or gated capabilities

| Capability                           | Status                | Gate                                                                                                         |
| ------------------------------------ | --------------------- | ------------------------------------------------------------------------------------------------------------ |
| Count/tag tabs                       | Deferred              | Requires Tag or count-indicator integration, status semantics, overflow rules, and rendered evidence proof.       |
| Route-aware tabs                     | Gated / Pattern-owned | Requires Navigation Pattern approval and proof that the tabs are still peer panels in the same task context. |
| Nested tabs                          | Gated                 | Requires Pattern approval, heading hierarchy, keyboard proof, and visual separation rules.                   |
| Mixed icon-only and text tablists    | Gated                 | Requires accessibility review and rendered evidence proof.                                                        |
| Closable unsaved tab workflow        | Gated                 | Requires unsaved-change confirmation, focus recovery, and Pattern ownership.                                 |
| Async panel loading                  | Deferred              | Requires loading, error, retry, and focus-management semantics inside panels.                                |
| Drag-reorderable tabs                | Deferred              | Requires keyboard reordering, pointer behavior, persistence rules, and rendered evidence proof.                   |
| Multi-row tabs                       | Not allowed           | Horizontal tabs must scroll instead of wrapping.                                                             |
| Arbitrary status color tabs          | Not allowed           | Requires Color Element and status Tag integration updates.                                                   |
| Direct Carbon implementation classes | Not allowed           | Login App keeps app-owned Blade, JavaScript, and `ui-*` CSS APIs.                                            |

Future extensions require an updated Component standard and rendered evidence proof before production use.

## 14. Implementation and Rendered Evidence Checklist
### 14.1. Implementation checklist
| Requirement                | Standard expectation                                                                                                                               |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source          | The standard names the canonical Blade component, native/class API, JavaScript controller, CSS namespace, source files, or explicit deferred gate. |
| Variants/options/modifiers | Approved variants, options, sizes, density, layout modifiers, and deferred gates are listed.                                                       |
| States                     | Default, hover, focus-visible, active/pressed, disabled, loading, validation, selected, empty, or not-applicable states are defined as relevant.   |
| Accessibility/content      | Keyboard, focus, naming, ARIA, contrast, reduced-motion, label, helper, error, and copy requirements are defined.                                  |
| Element consumption        | Required Color, Spacing, Typography, Icons, Motion, Themes, and 2x Grid dependencies are named.                                                    |
| Tests                      | Source/API assertions and Rendered evidence route assertions block generic fallback content.                                                            |

### 14.2. rendered evidence proof checklist
| Requirement               | Visual proof expectation                                                                              |
| ------------------------- | ----------------------------------------------------------------------------------------------------- |
| Live examples             | The page renders production examples through the documented API or explicit native/class contract.    |
| Rendered variants/options | Every applicable supported variant, option, size, modifier, or deferred trigger condition is shown.   |
| Rendered states           | Required states are shown visually and with accessibility markers where relevant.                     |
| Developer implementation  | Real canonical calls and token-backed code snippets appear instead of placeholder comments.           |
| Related APIs              | Nearby Components, owning Patterns, consumed Elements, source files, and canonical docs are linked.   |
| Manual review             | The page provides enough rendered proof for visual review of behavior, layout, and state correctness. |
## 15. Rendered evidence requirements

The rendered evidence page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

The Tabs page is a scenario-driven component reference page. The Live examples card may use tabs, matrices, state tables, overflow examples, and keyboard examples. It must not render fake controls for deferred capabilities.

### 15.1. Required Live examples internal sections:

| Required proof                   | Rendered behavior                                                                                                                             | Variants/options shown                                                                                                   |
| -------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------ |
| Line tabs                        | Flexible tabs for peer sections in a page, modal, card, or component surface.                                                                 | Line, Horizontal, Scrollable line tabs, Overflow/scroll, Tabs with icons, Icon-leading, Icon-only tabs, Dismissible tabs |
| Contained tabs                   | Emphasized tabs attach to a panel for defined sub-page content areas.                                                                         | Contained, Secondary labels, Scrollable contained tabs, Dismissible tabs with icons                                      |
| Vertical tabs                    | Vertical tabs support quick scanning from top to bottom without replacing navigation.                                                         | Vertical grid-aware, Manual activation, Small breakpoint handoff                                                         |
| Activation behavior              | Automatic and manual activation render with clear keyboard expectations.                                                                      | Automatic activation, Manual activation, Enter/Space activation, Arrow focus movement                                    |
| State matrix                     | Production examples render approved tab states using token-backed classes.                                                                    | Selected, Unselected, Hover, Focus-visible, Disabled, Scrollable, Dismissible                                            |
| Keyboard and ARIA proof          | Examples expose required roles, relationships, focus behavior, and panel updates.                                                             | `role="tablist"`, `role="tab"`, `role="tabpanel"`, `aria-controls`, `aria-labelledby`, `aria-selected`, roving focus     |
| Dismissible behavior             | User-created tabs can be closed and focus recovers predictably.                                                                               | Dismissible, Dismiss label, Selected tab close, Unselected tab close                                                     |
| Responsive and overflow behavior | Horizontal tabs scroll instead of wrapping and vertical tabs hand off at small breakpoints.                                                   | Overflow scroll, Scroll affordances, No wrapping, Small breakpoint handoff                                               |
| Developer implementation         | Canonical calls, props, item data contract, initializer, and data attributes render as real code examples.                                    | `x-ui.tabs`, `tabs` prop, `variant`, `orientation`, `activation`, `initTabs`, `data-ui-tabs*`                            |
| Prohibited and deferred examples | The page shows unsupported primary navigation, progress, multi-row tabs, nested tabs, route tabs, and status tag/count indicators as not approved or gated. | Deferred gates, prohibited usage, approved alternatives                                                                  |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered variants, rendered states, option contract, prohibited usage, deferred gates, JavaScript initializer requirements, data attribute contract, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- Developer examples use `x-ui.tabs`, not placeholder comments or ad hoc markup.
- JavaScript examples reference `initTabs` from `resources/js/ui-controls/tabs.js`.
- The page documents the `tabs` item data contract.
- The page renders line, contained, and vertical variants.
- The page renders automatic and manual activation behavior.
- The page renders selected, unselected, hover, focus-visible, disabled, scrollable, and dismissible states.
- The page shows horizontal overflow scrolling and explicitly prohibits wrapping.
- The page includes icon-leading and icon-only examples with accessibility requirements.
- The page includes dismissible tabs only as user-created or user-curated content.
- ARIA examples show `role="tablist"`, `role="tab"`, `role="tabpanel"`, `aria-controls`, `aria-labelledby`, and `aria-selected`.
- Deferred examples render trigger conditions instead of fake count/tag tabs, route tabs, nested tabs, async panels, or drag-reorder tabs.
- The page contains no generic placeholder content.
- Tests assert stale labels and legacy scaffolding remain absent when they are not part of approved UI copy.
- Tests assert no raw Bootstrap tab markup, hard-coded color, arbitrary local spacing, feature-local tabs class system, local JavaScript tabs controller, or direct Carbon production class is presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Tabs');
$response->assertSee('x-ui.tabs');
$response->assertSee('initTabs');
$response->assertSee('data-ui-tabs');
$response->assertSee('role="tablist"', false);
$response->assertSee('role="tab"', false);
$response->assertSee('role="tabpanel"', false);
$response->assertSee('aria-controls', false);
$response->assertSee('aria-labelledby', false);
$response->assertSee('aria-selected', false);
$response->assertSee('Line tabs');
$response->assertSee('Contained tabs');
$response->assertSee('Vertical tabs');
$response->assertSee('Automatic activation');
$response->assertSee('Manual activation');
$response->assertSee('Scrollable');
$response->assertSee('Dismissible');
$response->assertSee('Icon-only tabs need accessible names');
$response->assertSee('Horizontal tabs scroll instead of wrapping');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('<li>None.</li>', false);
$response->assertDontSee('Use only documented props/options');
$response->assertDontSee('See rendered evidence developer implementation section');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('nav-tabs');
$response->assertDontSee('tab-content');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
```

## 17. Related APIs

| API                      | Route                                                          |
| ------------------------ | -------------------------------------------------------------- |
| Button                   | `not installed`                     |
| Icon button              | `not installed`                     |
| Breadcrumb               | `not installed`                 |
| Progress indicator       | `not installed`         |
| Menu                     | `not installed`                       |
| Select                   | `not installed`                     |
| Radio button             | `not installed`               |
| Navigation patterns      | `not installed`                   |
| Layout Pattern           | `not installed`                       |
| Forms pattern            | `not installed`                        |
| Overlay/feedback pattern | `not installed`            |
| Color element            | `not installed`                        |
| Spacing element          | `not installed`                      |
| Typography element       | `not installed`                   |
| Themes element           | `not installed`                       |
| Motion element           | `not installed`                       |
| Components overview      | `not installed`                            |
| Canonical tabs doc       | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Ftabs.md` |
| Carbon tabs usage        | `https://carbondesignsystem.com/components/tabs/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Tabs usage, style, and accessibility guidance inform related-view usage, line/contained/vertical treatment, scrollable overflow, selected/unselected styling, disabled and dismissible treatment, keyboard operation, and ARIA expectations. Login App keeps its own Blade API, JavaScript initializer, app-owned data attributes, `ui-*` class contract, and rendered evidence proof.
