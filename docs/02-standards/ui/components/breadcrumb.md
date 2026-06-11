---
title: Breadcrumb
slug: breadcrumb
api_layer: Component API
status: implemented-pending-manual-review
system_maturity: implemented
category: navigation-and-disclosure
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/components/breadcrumb
canonical_doc: docs/02-standards/ui/components/breadcrumb.md
source_owner: /platform/ui-reference/components/breadcrumb
blade_api:
  - x-ui.breadcrumb
javascript_api:
  - initMenus
source_files:
  - resources/views/components/ui/breadcrumb.blade.php
  - resources/js/ui-controls/menus.js
  - resources/js/ui-controls.js
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
  - 2x-grid
related_components:
  - menu-buttons
  - tooltip
  - progress-indicator
  - tabs
  - ui-shell
related_patterns:
  - navigation
  - layout
planned_patterns:
  - navigation-shell
  - layout
carbon_reference:
  - https://carbondesignsystem.com/components/breadcrumb/usage/
  - https://carbondesignsystem.com/components/breadcrumb/style/
  - https://carbondesignsystem.com/components/breadcrumb/accessibility/
---

# Breadcrumb Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Props and options](#43-props-and-options)
  - [4.4. Item data contract](#44-item-data-contract)
  - [4.5. Data attributes](#45-data-attributes)
  - [4.6. CSS namespace](#46-css-namespace)
  - [4.7. JavaScript API](#47-javascript-api)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed helper surfaces:](#72-allowed-helper-surfaces)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
  - [9.3. Use alternatives:](#93-use-alternatives)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. UI Reference proof checklist](#142-ui-reference-proof-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
  - [15.1. Required live examples and option proof:](#151-required-live-examples-and-option-proof)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Breadcrumbs show a user where the current view sits in the app information architecture.

Canonical API owner: `/platform/ui-reference/components/breadcrumb`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Breadcrumb is the installed Login App 2.0 orientation and parent-navigation API. It owns breadcrumb trail semantics, hierarchy order, link styling, separator treatment, current-page treatment, truncation/overflow behavior, and overflow-menu handoff. It does not own primary navigation, wizard progress, tabbed peer-view switching, previous-page history behavior, or app-shell navigation structure.

### 1.1. Canonical API responsibilities:

- Render location-based breadcrumb trails for nested app pages.
- Preserve hierarchy from the highest useful parent toward the current location.
- Render each parent page as an interactive link.
- Optionally list the current page as non-interactive text when page context is unclear.
- Render small or medium breadcrumb sizing through the component API.
- Truncate long breadcrumb trails through the installed overflow-menu handoff.
- Preserve single-line layout; breadcrumbs must not wrap to a second line.
- Expose the breadcrumb as a named navigation landmark.
- Consume Foundation Element tokens for text, link, spacing, focus, icon, motion, and theme behavior.

### 1.2. Non-owned responsibilities:

- Primary navigation. Use UI shell, header, side navigation, or Pattern-owned navigation APIs.
- Task progress. Use Progress indicator.
- Peer view switching. Use Tabs or Content switcher.
- Previous-page history. Breadcrumbs describe hierarchy, not browser history.
- Page title ownership. Page header or page content owns the visible title.
- Feature-local overflow menus. Overflow behavior is owned by the Menu/Menu buttons API handoff.

## 2. Status and ownership

| Field                        | Value                                                                                                                                             |
| ---------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Implemented - pending manual review                                                                                                               |
| System maturity              | Implemented                                                                                                                                       |
| API layer                    | Component API                                                                                                                                     |
| Component slug               | breadcrumb                                                                                                                                        |
| Category                     | Navigation and disclosure                                                                                                                         |
| Priority                     | Tier A - Baseline app development                                                                                                                 |
| UI Reference route           | `/platform/ui-reference/components/breadcrumb`                                                                                                    |
| Canonical doc                | `docs/02-standards/ui/components/breadcrumb.md`                                                                                                   |
| Source owner                 | `/platform/ui-reference/components/breadcrumb`                                                                                                    |
| Blade API                    | `x-ui.breadcrumb`                                                                                                                                 |
| JavaScript API               | `initMenus` for overflow-menu behavior only                                                                                                       |
| Source files                 | `resources/views/components/ui/breadcrumb.blade.php`; `resources/js/ui-controls/menus.js`; `resources/js/ui-controls.js`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons, 2x Grid                                                                                        |
| Carbon benchmark             | Carbon Breadcrumb usage, style, and accessibility guidance                                                                                        |

`Implemented - pending manual review` means the installed component route, visual examples, and API contract exist, but source paths, prop aliases, overflow behavior, accessibility, and docs-path alignment still require final manual verification before the component is marked fully reviewed.

## 3. Installed standard

Breadcrumb has a corrected component-specific UI Reference page with canonical app examples, rendered options, and recovery assertions.

### The installed standard is:

- Render breadcrumbs through `<x-ui.breadcrumb>`.
- Use breadcrumb for secondary hierarchy orientation in nested information architecture.
- Prefer location-based breadcrumbs. The trail should represent the app hierarchy, not the user's browser history.
- Start at the highest useful parent and progress toward the current page location.
- By default, stop at the previous page and do not list the current page when the page already has a clear title.
- Include the current page only when the page title is absent, hidden, ambiguous, or the current location is otherwise unclear.
- When the current page is listed, render it as the final item and do not make it an interactive link.
- Use small breadcrumbs in page headers, compact regions, and condensed breakpoints.
- Use medium breadcrumbs when the breadcrumb carries more orientation weight or appears at the top of a page without a page title.
- Keep breadcrumb text on one line. Use overflow behavior instead of wrapping.
- When overflow is enabled at larger widths, keep the first home/top breadcrumb for as long as possible and preserve final page context when possible. Move middle links into the overflow menu.
- At small widths, render the overflow control first followed by one final breadcrumb item instead of forcing the row or containing card wider than the viewport.
- Use the installed Menu/Menu buttons handoff for the overflow trigger and menu behavior.
- Keep separators visual only. They are not interactive and should not be announced as navigable content.
- Keep all styling token-backed and theme-aware.

Carbon alignment note: Carbon treats breadcrumb as secondary navigation, supports small and medium sizes, recommends not listing the current page by default, allows the current page when context is unclear, uses overflow instead of wrapping, and places breadcrumbs above the page title under the header/navigation area.

## 4. Public API

### 4.1. Canonical calls

```blade
<x-ui.breadcrumb :items="$items" />
```

```blade
<x-ui.breadcrumb :items="$items" size="sm" overflow />
```

```blade
<x-ui.breadcrumb
    :items="$items"
    size="md"
    :current="$currentPage"
    overflow
/>
```

Use the Blade API instead of hand-building breadcrumb markup in feature views.

### 4.2. API surfaces

| API surface      | Installed value                                                                                                                      |
| ---------------- | ------------------------------------------------------------------------------------------------------------------------------------ |
| Blade            | `x-ui.breadcrumb`                                                                                                                    |
| JavaScript       | `initMenus` exported from `resources/js/ui-controls/menus.js` for overflow menu behavior                                             |
| Root landmark    | `nav[aria-label="Breadcrumb"]`                                                                                                       |
| List semantics   | Ordered list preferred for hierarchy; unordered list accepted only if the installed component owns that semantic choice consistently |
| Overflow trigger | Installed menu/overflow trigger API with accessible name such as `More breadcrumbs`                                                  |
| Data attributes  | Use only data attributes documented by the Component API. Feature views must not invent breadcrumb behavior attributes.              |
| Props/options    | Use only documented props/options.                                                                                                   |
| CSS namespace    | Use the app-owned `ui-*` namespace documented by the component implementation.                                                       |
| Source files     | `resources/views/components/ui/breadcrumb.blade.php`; `resources/js/ui-controls/menus.js`; `resources/css/app.css`                   |

### 4.3. Props and options

| Prop/option  | Type                    | Default           | Allowed values                        | Required | Notes                                                                                                                                     |
| ------------ | ----------------------- | ----------------- | ------------------------------------- | -------- | ----------------------------------------------------------------------------------------------------------------------------------------- |
| `items`      | `array`                 | none              | Breadcrumb item configuration array   | Yes      | Parent pages only by default. Items should be ordered from highest useful parent to deepest parent.                                       |
| `size`       | `string`                | `md`              | `sm`, `md`                            | No       | `sm` is for page headers, compact regions, and condensed breakpoints. `md` is the default when no page title/header gives strong context. |
| `overflow`   | `bool`                  | `false`           | `true`, `false`                       | No       | Enables installed overflow behavior for long trails. Do not wrap breadcrumbs.                                                             |
| `current`    | `array / string / null` | `null`            | Current page item or label            | No       | Include only when title/context is unclear. Render non-interactive with `aria-current="page"`.                                            |
| `ariaLabel`  | `string`                | `Breadcrumb`      | Short landmark label                  | No       | Override only when more than one breadcrumb navigation landmark appears on the page.                                                      |
| `maxVisible` | `int / null`            | installed default | positive integer                      | No       | Use only when the visible count needs a reviewed override. Otherwise rely on the default fluid overflow rules.                             |
| `class`      | `string / null`         | `null`            | layout class passthrough if supported | No       | Parent Patterns own external spacing. Do not use this for local color, typography, or behavior changes.                                   |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.4. Item data contract

The preferred `items` payload should be explicit and stable.

```php
$items = [
    [
        'label' => 'Platform',
        'href' => route('platform.dashboard'),
    ],
    [
        'label' => 'Settings',
        'href' => route('platform.settings.index'),
    ],
];

$currentPage = [
    'label' => 'Workspace access',
];
```

| Item key     | Type            | Required                  | Allowed values                    | Notes                                                                                                |
| ------------ | --------------- | ------------------------- | --------------------------------- | ---------------------------------------------------------------------------------------------------- |
| `label`      | `string`        | Yes                       | Short page/entity label           | Must clearly reflect the destination or current location.                                            |
| `href`       | `string / null` | Required for parent items | Valid app URL                     | Parent breadcrumb items must be links. Current page item must not be a link.                         |
| `icon`       | `string / null` | No                        | Approved icon alias if supported  | Avoid icons unless a documented app pattern requires them. Breadcrumbs are primarily text.           |
| `current`    | `bool`          | No                        | `true`, `false`                   | Prefer the top-level `current` prop if installed. Current item must render last and non-interactive. |
| `attributes` | `array / null`  | No                        | Safe HTML attributes if supported | Do not use for local styling, custom JavaScript, or overriding accessibility semantics.              |

Do not pass task steps, tab names, actions, filters, statuses, or arbitrary back-stack labels as breadcrumb items.

### 4.5. Data attributes

Because breadcrumb itself is mostly semantic HTML, feature code should need few or no breadcrumb-owned data attributes. Data attributes are allowed only when installed by the component API.

| Attribute                                                    | Element          | Owner                  | Purpose                                                              |
| ------------------------------------------------------------ | ---------------- | ---------------------- | -------------------------------------------------------------------- |
| `data-ui-component="breadcrumb"`                             | Root             | Component              | Identifies the rendered UI component family if installed.            |
| `data-ui-breadcrumb`                                         | Root             | Component              | Identifies one breadcrumb instance if installed.                     |
| `data-ui-breadcrumb-overflow-trigger`                        | Overflow trigger | Component/Menu handoff | Identifies the overflow trigger if installed.                        |
| `data-ui-menu`, `data-ui-menu-trigger`, `data-ui-menu-panel` | Overflow handoff | Menu/Menu buttons API  | Used only when overflow renders through the installed menu behavior. |

Feature code must not create local breadcrumb JavaScript behavior. If overflow behavior is missing or incomplete, update the Menu/Menu buttons API or Breadcrumb component API rather than adding feature-local handlers.

### 4.6. CSS namespace

Allowed component classes should remain inside the app-owned `ui-*` namespace.

Expected allowed classes:

```css
.ui-breadcrumb
.ui-breadcrumb-list
.ui-breadcrumb-item
.ui-breadcrumb-link
.ui-breadcrumb-current
.ui-breadcrumb-separator
.ui-breadcrumb-overflow
.ui-breadcrumb-sm
.ui-breadcrumb-md
```

If the installed class names differ, the UI Reference developer implementation section and this standard must be updated together.

Do not create feature-local `breadcrumb-*`, Bootstrap breadcrumb overrides, raw utility clusters, or component-specific color/spacing classes for the same UI role.

### 4.7. JavaScript API

Breadcrumb links do not require JavaScript. JavaScript is required only when overflow renders a menu.

Canonical overflow initializer:

```js
import { initMenus } from './ui-controls/menus';

initMenus();
```

The overflow handoff owns:

- Opening and closing the overflow menu.
- Keeping `aria-expanded` synchronized on the overflow trigger.
- Managing Escape dismissal.
- Handling outside-click dismissal.
- Preserving or returning focus according to the installed Menu/Menu buttons contract.
- Keeping the overflow trigger keyboard reachable.

Do not create local menu behavior for breadcrumb overflow.

## 5. Allowed variants, options, and modifiers

Breadcrumb has no semantic tone variants such as primary, secondary, success, warning, or danger. It does have installed size and behavior options. Only the options below are allowed for Login App 2.0 feature work.

| Name                       | Type             | Status              | API                                           | Use when                                                                                            | Do not use when                                                                    |
| -------------------------- | ---------------- | ------------------- | --------------------------------------------- | --------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- |
| Medium                     | Size             | Implemented         | `size="md"`                                   | The page has no strong page header/title context or the breadcrumb carries more orientation weight. | The breadcrumb is inside a compact page header or condensed breakpoint.            |
| Small                      | Size             | Implemented         | `size="sm"`                                   | Breadcrumb appears in a page header, compact region, or condensed breakpoint.                       | The breadcrumb is the main orientation element above content without a page title. |
| Current page omitted       | Default behavior | Implemented         | no `current` prop                             | Page title is visible and clearly identifies the current location.                                  | Page title is absent, hidden, ambiguous, or not enough to orient the user.         |
| Current page listed        | Modifier         | Implemented         | `current` prop or installed item current flag | Current location is unclear without the final label.                                                | The page already has a clear visible title directly after the breadcrumb.          |
| Overflow/truncated         | Modifier         | Implemented         | `overflow`                                    | The trail cannot fit on one line or has more than the approved visible link count.                  | The trail is short and fits cleanly.                                               |
| Overflow with current page | Modifier         | Implemented         | `overflow` with `current`                     | A long trail needs truncation and the current page must be listed for context.                      | The current page is already clear from the title.                                  |
| Location-based trail       | Type             | Implemented default | ordered `items`                               | Breadcrumb should represent the app information architecture.                                       | The feature is trying to show the user's session history.                          |
| Path-based trail           | Type             | Deferred            | none                                          | Only if a product-owned history trail requirement is approved.                                      | Normal app hierarchy and page headers.                                             |

Not installed or not approved:

| Capability                       | Status      | Reason                                                                                   |
| -------------------------------- | ----------- | ---------------------------------------------------------------------------------------- |
| Semantic color variants          | Not allowed | Breadcrumbs are navigation/orientation, not status or action feedback.                   |
| Disabled breadcrumb links        | Not allowed | Parent links should be valid destinations. Current page is static text, not disabled UI. |
| Multi-line breadcrumb wrapping   | Not allowed | Use overflow/truncation instead.                                                         |
| Breadcrumb as progress steps     | Not allowed | Use Progress indicator.                                                                  |
| Breadcrumb as primary navigation | Not allowed | Use UI shell/navigation patterns.                                                        |
| Custom separators                | Deferred    | Requires component standard and accessibility review.                                    |

## 6. States

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

| State                | Status                                           | Implementation requirement                                                                                              |
| -------------------- | ------------------------------------------------ | ----------------------------------------------------------------------------------------------------------------------- |
| Default              | Implemented                                      | Parent breadcrumbs render as links in hierarchy order.                                                                  |
| Hover                | Implemented                                      | Link hover uses token-backed link state styling and may underline according to installed style.                         |
| Focus-visible        | Implemented                                      | Every link and overflow trigger must show a visible token-backed focus state.                                           |
| Active               | Implemented where browser/app link state applies | Link activation must not remove focus visibility before navigation.                                                     |
| Overflow menu closed | Implemented                                      | Overflow trigger is reachable when rendered and reports collapsed state if `aria-expanded` is used.                     |
| Overflow menu open   | Implemented                                      | Menu appears from the overflow trigger, exposes middle breadcrumb links, and closes through Menu/Menu buttons behavior. |
| Current page listed  | Implemented                                      | Final item is non-interactive text with `aria-current="page"`.                                                          |
| Truncated            | Implemented                                      | First two and final two page links remain visible when possible; middle items move into the overflow menu.              |
| Disabled             | Not applicable                                   | Breadcrumb links are valid navigation links. Current page is static text, not disabled.                                 |
| Loading              | Not applicable                                   | Breadcrumb does not own loading. Page or shell Patterns own loading.                                                    |
| Validation           | Not applicable                                   | Breadcrumb does not own validation.                                                                                     |
| Empty                | Not applicable                                   | Do not render an empty breadcrumb. Omit the component if no useful hierarchy exists.                                    |
| Read-only            | Not applicable                                   | Non-current breadcrumb items are links; current page is static text when listed.                                        |

## 7. Token, class, and helper usage

Breadcrumb consumes Foundation Color, Spacing, Typography, Themes, Motion, Icons, and 2x Grid where applicable.

### 7.1. Foundation Elements consumed:

- Color
- Spacing
- Typography
- Themes
- Motion
- Icons
- 2x Grid

| Foundation Element | Allowed usage                                                                                                                                                                |
| ------------------ | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Color              | Link text, current-page text, separator color, overflow trigger color, hover/focus states, and theme-aware contrast.                                                         |
| Spacing            | Internal item spacing, separator spacing, overflow trigger spacing, and compact/medium size rhythm. Parent Patterns own external spacing.                                    |
| Typography         | Small and medium breadcrumb text roles. Labels must use app text roles rather than arbitrary text sizes.                                                                     |
| Themes             | Breadcrumb must remain readable in supported light, dark, inline, inverse, and high-contrast contexts.                                                                       |
| Motion             | Overflow menu open/close behavior uses installed Menu/Menu buttons motion and respects reduced-motion preferences.                                                           |
| Icons              | Separator and overflow icons are decorative unless the overflow trigger requires an accessible name. Decorative separators/icons must not be announced as navigable content. |
| 2x Grid            | Page/header placement and responsive behavior are owned by layout Patterns consuming the 2x Grid Element API.                                                                |

### 7.2. Allowed helper surfaces:

```blade
<x-ui.breadcrumb :items="$items" />
<x-ui.breadcrumb :items="$items" size="sm" />
<x-ui.breadcrumb :items="$items" overflow />
<x-ui.breadcrumb :items="$items" :current="$currentPage" overflow />
```

Do not hard-code link color, separator spacing, focus ring, typography size, menu motion, or overflow icon treatment in feature views.

## 8. Composition rules

- Breadcrumbs are secondary navigation. They supplement, but never replace, primary navigation.
- Breadcrumbs should appear near the top-left of the page content region, below the app shell/header/navigation and above the page title when a title is present.
- Default trails start at the highest useful parent and stop at the previous page.
- When the current page is listed, it is the last item and is plain text with `aria-current="page"`.
- Overflow starts after four listed page links, or five when the current page is listed, unless the installed component exposes a reviewed override.
- Overflow keeps useful parent context and final page context visible at larger widths, with middle links in a menu.
- Small breakpoints collapse overflow examples to the overflow trigger followed by one final breadcrumb, and the overflow menu must contain the prior breadcrumb links that were hidden at that breakpoint.
- The overflow trigger opens a menu and closes on Escape, outside click, or the installed Menu/Menu buttons dismissal behavior.
- Breadcrumbs must remain single-line. Use overflow/truncation before wrapping.
- Parent Patterns own external spacing, page header composition, shell placement, and responsive breakpoints.
- Breadcrumb owns internal semantics, item/link rendering, separator rendering, current-page treatment, and overflow handoff.
- Do not compose actions, toggles, filters, tabs, progress steps, or status chips inside Breadcrumb.

## 9. Selection guidance

### 9.1. Use when:

- Users need orientation inside a nested information architecture.
- The current page is at least two hierarchy levels deep.
- Users may need to navigate quickly to a parent page.
- A page header or content region benefits from secondary hierarchy context.
- Small breadcrumbs need to pair with a page title in a header.
- Medium breadcrumbs need to carry orientation above content when the title is absent or less prominent.
- Middle overflow is needed because the first link and last two page links cannot fit on one line.

### 9.2. Do not use when:

- The product has only single-level navigation.
- The control is meant to show a task sequence, wizard steps, onboarding progress, or completion progress.
- The UI should switch between peer views inside the current page.
- The page needs primary navigation or local section navigation.
- The desired behavior is browser-history back navigation.
- The trail would need to wrap onto a second line to fit.
- The current page would be rendered as a clickable link to itself.

### 9.3. Use alternatives:

| Need                            | Use instead                                              |
| ------------------------------- | -------------------------------------------------------- |
| Task progress or wizard steps   | Progress indicator                                       |
| Peer page/view switching        | Tabs or Content switcher                                 |
| Primary app navigation          | UI shell or navigation Pattern                           |
| Secondary in-page navigation    | Pattern-owned local navigation or section links          |
| Action menu                     | Menu buttons or Overflow menu API                        |
| Comparable hierarchical content | Tree view if approved, Structured list, or page sections |

## 10. Accessibility contract

- Use a `nav` landmark with `aria-label="Breadcrumb"`.
- Use list semantics so assistive technology conveys the hierarchy as a group of ordered locations.
- Each parent breadcrumb is a real link and is keyboard reachable with `Tab`.
- Breadcrumb links activate with `Enter` through normal link behavior.
- The current page, when listed, uses `aria-current="page"` and is not a link.
- The current page text must remain readable and contrast-compliant. It is static text, not disabled UI.
- Separators are visual only and must not be keyboard reachable or announced as navigable content.
- The overflow trigger needs an accessible name such as `More breadcrumbs`.
- The overflow trigger uses `aria-haspopup="menu"` and synchronized `aria-expanded` when the installed Menu/Menu buttons API uses those attributes.
- The overflow trigger must be reachable in the tab order when overflow is rendered.
- Overflow menu links must render through the installed Menu item contract, be keyboard reachable, and activate like normal links.
- Escape closes the overflow menu through the installed Menu/Menu buttons behavior.
- Focus behavior for overflow open/close must follow the Menu/Menu buttons accessibility contract.
- Do not hide required navigation context behind hover-only UI.

## 11. Content contract

- Keep each breadcrumb label short and entity-specific.
- Use labels that match the destination page or object name.
- Move from the highest useful parent toward the current location.
- Do not include every possible ancestor if doing so creates clutter; use the highest useful parent and overflow when needed.
- Do not use generic labels such as `Back`, `Previous`, `Details`, or `Page`.
- Do not include verbs or action labels. Breadcrumb items are destinations, not actions.
- List the current page only when the visible page title is absent, hidden, ambiguous, or otherwise insufficient.
- When the current page is listed, keep it short and non-interactive.
- Prefer stable information-architecture labels over session-history labels.
- Do not use breadcrumb labels for status, validation, filters, or progress copy.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not use breadcrumbs for task progress or wizard steps.
- Do not use breadcrumbs as primary navigation.
- Do not use breadcrumbs for single-level navigation.
- Do not use breadcrumbs for browser-history back behavior.
- Do not wrap breadcrumbs onto a second line.
- Do not make the current page an interactive link when it is listed.
- Do not treat the current page as disabled UI. It is static text and must remain readable.
- Do not create disabled breadcrumb links.
- Do not put actions, menus, filters, toggles, status badges, or form controls inside breadcrumb trails.
- Do not invent a feature-local overflow menu. Use the installed Menu/Menu buttons API handoff.
- Do not import local separator icons or override separator behavior without updating this Component standard and UI Reference proof.

## 13. Deferred or gated capabilities

| Capability                                                          | Status      | Gate                                                                       |
| ------------------------------------------------------------------- | ----------- | -------------------------------------------------------------------------- |
| Path-based breadcrumbs                                              | Deferred    | Requires product-approved session-history behavior and consistency rules.  |
| Custom separator styles                                             | Deferred    | Requires design/system owner approval and accessibility review.            |
| Dynamic responsive breadcrumb compression beyond installed small-breakpoint overflow | Deferred | Requires updated component API, tests, and UI Reference proof.             |
| Multiple breadcrumb landmarks on one page                           | Gated       | Requires unique `ariaLabel` values and page-level accessibility review.    |
| Icon-leading breadcrumb items                                       | Gated       | Requires approved navigation pattern and icon accessibility review.        |
| Disabled breadcrumb links                                           | Not allowed | Parent items must link to valid destinations; current item is static text. |
| Breadcrumb as progress indicator                                    | Not allowed | Use Progress indicator.                                                    |

Future extensions require an updated Component standard and UI Reference proof before implementation.

## 14. Implementation and UI Reference Checklist
### 14.1. Implementation checklist
| Requirement                | Standard expectation                                                                                                                               |
| -------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| Public API/source          | The standard names the canonical Blade component, native/class API, JavaScript controller, CSS namespace, source files, or explicit deferred gate. |
| Variants/options/modifiers | Approved variants, options, sizes, density, layout modifiers, and deferred gates are listed.                                                       |
| States                     | Default, hover, focus-visible, active/pressed, disabled, loading, validation, selected, empty, or not-applicable states are defined as relevant.   |
| Accessibility/content      | Keyboard, focus, naming, ARIA, contrast, reduced-motion, label, helper, error, and copy requirements are defined.                                  |
| Element consumption        | Required Color, Spacing, Typography, Icons, Motion, Themes, and 2x Grid dependencies are named.                                                    |
| Tests                      | Source/API assertions and UI Reference route assertions block generic fallback content.                                                            |

### 14.2. UI Reference proof checklist
| Requirement               | Visual proof expectation                                                                              |
| ------------------------- | ----------------------------------------------------------------------------------------------------- |
| Live examples             | The page renders production examples through the documented API or explicit native/class contract.    |
| Rendered variants/options | Every applicable supported variant, option, size, modifier, or deferred trigger condition is shown.   |
| Rendered states           | Required states are shown visually and with accessibility markers where relevant.                     |
| Developer implementation  | Real canonical calls and token-backed code snippets appear instead of placeholder comments.           |
| Related APIs              | Nearby Components, owning Patterns, consumed Elements, source files, and canonical docs are linked.   |
| Manual review             | The page provides enough rendered proof for visual review of behavior, layout, and state correctness. |
## 15. UI Reference requirements

The UI Reference page must render the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.

The Breadcrumb page may use a compact matrix layout instead of Accordion-style tabs because Breadcrumb is primarily a size/option component, not a scenario-heavy disclosure component.

### 15.1. Required live examples and option proof:

| Required proof        | Rendered behavior                                                                                                       | Options shown                                                                                                                 |
| --------------------- | ----------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------- |
| Small size            | Small breadcrumbs pair with page headers and condensed breakpoints.                                                     | Default small trail; closed interactive truncated menu; small with current page listed; closed interactive truncated menu with current page listed.     |
| Medium size           | Medium breadcrumbs are the default when there is no page header or when the breadcrumb carries more orientation weight. | Default medium trail; closed interactive truncated menu; medium with current page listed; closed interactive truncated menu with current page listed. |
| Overflow behavior     | Long trail keeps key ancestors visible and moves middle links into an overflow menu.                                    | First two and final two links visible when possible; middle links in menu; overflow trigger has accessible name.              |
| Current page behavior | Current page appears only when context requires it and is non-interactive.                                              | `aria-current="page"`; final item static text; no self-link.                                                                  |
| Single-line behavior  | Long labels or narrow viewports use truncation/overflow rather than wrapping.                                           | No second line; labels remain readable or safely truncated.                                                                   |
| Accessibility proof   | Landmark, list semantics, focus-visible links, overflow trigger, and menu behavior are visible/testable.                | `nav[aria-label="Breadcrumb"]`; link focus; overflow open/closed state.                                                       |

The page must include the installed API, states, options, prohibited usage, deferred gates, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/breadcrumb` returns 200 for authorized users.
- The page uses the approved five-card scaffold: Purpose, Use cases, Component contract, Live examples, and Related components and patterns.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The page renders small and medium breadcrumb examples.
- Truncated menu examples render closed by default and open through the installed menu trigger behavior.
- Truncated menu examples have a small-breakpoint handoff that keeps the overflow trigger and final breadcrumb visible without widening the page.
- The page renders default, overflow/truncated, current page listed, and overflow with current page listed examples for both sizes.
- Breadcrumb trails render inside a named `nav` landmark.
- Breadcrumb items render as list items.
- Parent breadcrumb items render as links.
- The current page, when listed, renders last, uses `aria-current="page"`, and is not a link.
- The overflow trigger is keyboard reachable and has an accessible name.
- Overflow behavior uses the installed Menu/Menu buttons API rather than local JavaScript.
- Breadcrumbs do not wrap to a second line in the reference examples.
- The page distinguishes Breadcrumb from Progress indicator, Tabs, UI shell/navigation, and Menu buttons.
- No generic fallback text, placeholder developer comments, raw colors, arbitrary spacing, Bootstrap breadcrumb markup, or feature-local overflow behavior appears.

### 16.1. Suggested automated assertions:

```php
$response->assertOk();
$response->assertSee('x-ui.breadcrumb');
$response->assertSee('Small size');
$response->assertSee('Medium size');
$response->assertSee('Truncated menu');
$response->assertSee('Current page listed');
$response->assertSee('aria-current="page"', false);
$response->assertSee('nav');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Bootstrap breadcrumb');
```

## 17. Related APIs

| API                             | Route                                                                 |
| ------------------------------- | --------------------------------------------------------------------- |
| Components overview             | `/platform/ui-reference/components`                                   |
| Menu buttons / overflow menu    | `/platform/ui-reference/components/menu-buttons`                      |
| Tooltip                         | `/platform/ui-reference/components/tooltip`                           |
| Progress indicator              | `/platform/ui-reference/components/progress-indicator`                |
| Tabs                            | `/platform/ui-reference/components/tabs`                              |
| UI shell                        | `/platform/ui-reference/components/ui-shell`                          |
| Navigation pattern              | `/platform/ui-reference/patterns/navigation`                          |
| Layout pattern                  | `/platform/ui-reference/patterns/layout`                              |
| Planned navigation shell API    | See [UI API Registry](../api-registry.md)                             |
| Planned page header API         | See [UI API Registry](../api-registry.md)                             |
| Color element                   | `/platform/ui-reference/elements/color`                               |
| Spacing element                 | `/platform/ui-reference/elements/spacing`                             |
| Typography element              | `/platform/ui-reference/elements/typography`                          |
| Themes element                  | `/platform/ui-reference/elements/themes`                              |
| Icons element                   | `/platform/ui-reference/elements/icons`                               |
| Canonical breadcrumb doc        | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Fbreadcrumb.md`  |
| Carbon breadcrumb usage         | `https://carbondesignsystem.com/components/breadcrumb/usage/`         |
| Carbon breadcrumb style         | `https://carbondesignsystem.com/components/breadcrumb/style/`         |
| Carbon breadcrumb accessibility | `https://carbondesignsystem.com/components/breadcrumb/accessibility/` |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Breadcrumb usage, style, and accessibility guidance inform the hierarchy, size, current-page, overflow, keyboard, and landmark rules. Login App keeps its own Blade API, CSS namespace, token values, overflow handoff, and route ownership.
