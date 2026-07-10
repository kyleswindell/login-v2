---
title: Toggletip
slug: toggletip
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: overlays
priority: tier-b-common-reusable-component
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/toggletip.md
source_owner: not installed
blade_api:
  - x-ui.toggletip
javascript_api:
  - initToggletips exported from resources/js/ui-controls/toggletip.js
data_attributes:
  - data-ui-toggletip
  - data-ui-toggletip-trigger
  - data-ui-toggletip-panel
  - data-ui-toggletip-close
  - data-ui-toggletip-placement
source_files:
  - resources/views/components/ui/toggletip/index.blade.php
  - resources/js/ui-controls/toggletip.js
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
related_components:
  - button
  - icon-button
  - tooltip
  - popover
  - modal
  - notification
related_patterns:
  - forms
  - overlays-feedback
  - layout
carbon_reference:
  - https://carbondesignsystem.com/components/toggletip/usage/
  - https://carbondesignsystem.com/components/toggletip/style/
  - https://carbondesignsystem.com/components/toggletip/accessibility/
---

# Toggletip Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Props and options](#43-props-and-options)
  - [4.4. JavaScript API](#44-javascript-api)
  - [4.5. Initializer responsibilities:](#45-initializer-responsibilities)
  - [4.6. Data attribute contract](#46-data-attribute-contract)
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
  - [9.3. Selection matrix:](#93-selection-matrix)
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

Toggletip provides focusable, dismissible contextual help.

Canonical API owner: `not installed`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Toggletip is the installed Login App 2.0 disclosure-help overlay API. It owns the help trigger, open/closed disclosure behavior, dismiss behavior, focus return, optional close control, lightweight rich help content, placement, token-backed panel styling, and keyboard interaction. It does not own required page content, blocking confirmations, full workflow overlays, field validation messages, hover-only supplemental labels, menu actions, or page-level layout.

### 1.1. Canonical API responsibilities:

- Render contextual help through `x-ui.toggletip`.
- Use a focusable trigger, usually an icon button with an accessible label.
- Toggle the panel open with click, Enter, or Space.
- Dismiss the panel by activating the trigger again, pressing Escape, activating a close control when rendered, clicking outside, or tabbing away according to installed behavior.
- Return focus to the trigger when the panel closes from Escape or an internal close control.
- Keep interactive content inside the panel reachable in the page tab order.
- Support short text help and lightweight rich help such as links or a secondary action.
- Support approved placement values and auto-placement/collision behavior where installed.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, and icons.
- Prove open/closed, focus, dismissal, placement, reduced-motion, and content examples on the rendered evidence page.

### 1.2. Non-owned responsibilities:

- Required page instructions. Required information must be visible in the page, form, or helper text.
- Hover-only supplemental labels. Use Tooltip when the content is brief, non-interactive, and should appear on hover/focus.
- Blocking confirmations or decisions. Use Modal or Overlay/feedback Pattern APIs.
- Menus and contextual command lists. Use Menu.
- Field validation. Use the owning field component and Forms Pattern.
- Long help articles, onboarding flows, or multi-step guidance. Use a page, side panel, modal, or documentation pattern.
- External layout and spacing. Parent Patterns own placement around labels, fields, cards, page headers, and tables.

## 2. Status and ownership

| Field                        | Value                                                                                                                  |
| ---------------------------- | ---------------------------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                                           |
| System maturity              | Partial                                                                                                                |
| API layer                    | Component API                                                                                                          |
| Component slug               | `toggletip`                                                                                                            |
| Category                     | Overlays                                                                                                               |
| Priority                     | Tier B - Common reusable component                                                                                     |
| Rendered evidence route           | `not installed`                                                                          |
| Canonical doc                | `docs/02-standards/ui/components/toggletip.md`                                                                         |
| Source owner                 | `not installed`                                                                          |
| Blade API                    | `x-ui.toggletip`                                                                                                       |
| JavaScript API               | `initToggletips` from `resources/js/ui-controls/toggletip.js`                                                         |
| Data attributes              | App-owned `data-ui-toggletip*` attributes emitted by the component implementation                                      |
| Source files                 | `resources/views/components/ui/toggletip/index.blade.php`; `resources/js/ui-controls/toggletip.js`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons                                                                      |
| Carbon benchmark             | Carbon Toggletip usage, style, and accessibility guidance                                                              |

`Approved API` means component-specific rendered evidence examples exist, but this canonical standard must replace placeholder API text with the installed disclosure-help contract, explicit options, dismissal behavior, deferred gates, and regression requirements.

## 3. Installed standard

Toggletip now has component-specific rendered evidence examples that consume approved Foundation Elements.

### 3.1. The installed standard is:

- Render toggletips through `<x-ui.toggletip>`.
- Use toggletips for contextual help that opens intentionally, remains available for focusable content, and can be dismissed.
- Use the `label` prop to provide the trigger accessible name.
- Use the default information icon trigger unless an approved trigger slot is documented by the component implementation.
- Use concise body content in the default slot.
- Use one optional close control when the panel contains rich or interactive help.
- Use `placement="auto"` unless a local layout requires a specific approved placement.
- Use `aria-expanded` synchronization on the trigger and a stable relationship between trigger and panel.
- Keep the panel hidden when closed and visible/reachable when open.
- Use `initToggletips` for disclosure, Escape, outside-click, tab-away, placement, and focus-return behavior.
- Use app-owned `ui-*` classes and `data-ui-toggletip*` attributes emitted by the component.
- Do not create feature-local popover, tooltip, help-icon, or disclosure JavaScript for this role.

Carbon alignment note: Carbon separates toggletips from tooltips by activation and content. Tooltips are exposed on hover/focus for brief non-interactive supplemental information, while toggletips open on click or Enter and may contain interactive elements. Carbon also documents auto placement/collision behavior, specific top/right/bottom/left directions, and dismissal by trigger, Escape, or tabbing away. Login App maps those principles to its own `x-ui.toggletip`, `initToggletips`, internal icon components, app-owned data attributes, and `ui-*` class contract instead of adopting Carbon implementation classes directly.

## 4. Public API

### 4.1. Canonical calls

Use a simple toggletip for short contextual help near a label, heading, or setting.

```blade
<x-ui.toggletip label="About account status">
    Account status controls whether this user can sign in.
</x-ui.toggletip>
```

Use rich help when the user may need an inline link or lightweight secondary action.

```blade
<x-ui.toggletip
    label="About password rules"
    heading="Password requirements"
    placement="bottom"
    dismissible
>
    <p>
        Passwords must be at least 12 characters and include a mix of character types.
    </p>

    <x-ui.link href="{{ route('platform.docs.passwords') }}">
        View password policy
    </x-ui.link>
</x-ui.toggletip>
```

Use form assistance when contextual help belongs near a field label, while required guidance remains visible in helper text.

```blade
<div class="ui-field">
    <div class="ui-field-label-row">
        <label class="ui-field-label" for="tenant-domain">
            Tenant domain
        </label>

        <x-ui.toggletip label="About tenant domains" placement="right">
            Use the primary domain users will recognize when signing in.
        </x-ui.toggletip>
    </div>

    <p class="ui-field-helper" id="tenant-domain-helper">
        Enter the domain without https://.
    </p>

    <input
        id="tenant-domain"
        name="tenant_domain"
        type="text"
        class="ui-text-input"
        aria-describedby="tenant-domain-helper"
    >
</div>
```

Do not hand-build local help icons, popovers, or disclosure panels for this role.

### 4.2. API surfaces

| API surface           | Installed value                                                                                                        |
| --------------------- | ---------------------------------------------------------------------------------------------------------------------- |
| Blade API             | `x-ui.toggletip`                                                                                                       |
| JavaScript            | `initToggletips` exported from `resources/js/ui-controls/toggletip.js`                                                |
| Root semantic element | Focusable trigger plus disclosure panel                                                                                |
| Data attributes       | App-owned `data-ui-toggletip*` attributes emitted by the component implementation                                      |
| CSS namespace         | App-owned `ui-*` toggletip classes documented by this standard                                                         |
| Source files          | `resources/views/components/ui/toggletip/index.blade.php`; `resources/js/ui-controls/toggletip.js`; `resources/css/app.css` |

### 4.3. Props and options

| Prop/option   | Type            | Default                                          | Allowed values                                                                                 | Required | Notes                                                                                                          |
| ------------- | --------------- | ------------------------------------------------ | ---------------------------------------------------------------------------------------------- | -------- | -------------------------------------------------------------------------------------------------------------- |
| `label`       | `string`        | none                                             | Short accessible trigger label                                                                 | Yes      | Describes the help subject, not the icon shape.                                                                |
| Default slot  | Blade slot      | none                                             | Short text or lightweight rich help                                                            | Yes      | Keep concise. Required page content must remain visible outside the toggletip.                                 |
| `heading`     | `string / null` | `null`                                           | Short panel heading                                                                            | No       | Use for rich help or when panel content has more than one sentence.                                            |
| `placement`   | `string`        | `auto`                                           | `auto`, `top`, `right`, `bottom`, `left`, `top-start`, `top-end`, `bottom-start`, `bottom-end` | No       | `auto` is preferred. Mobile may force `bottom` when needed.                                                    |
| `align`       | `string`        | `center`                                         | `start`, `center`, `end`                                                                       | No       | Use only if the component implementation exposes it. Otherwise use placement values.                           |
| `dismissible` | `bool`          | `false` for simple text, `true` for rich content | `true`, `false`                                                                                | No       | Rich or interactive content should expose a close control.                                                     |
| `icon`        | `string`        | `information`                  | Internal icon alias/component                                                              | No       | Use the default information icon unless the component standard is extended.                                    |
| `disabled`    | `bool`          | `false`                                          | `true`, `false`                                                                                | No       | Disabled trigger cannot open the panel. Use sparingly.                                                         |
| `id`          | `string / null` | generated                                        | Unique DOM ID                                                                                  | No       | Use only when stable IDs are needed for tests.                                                                 |
| `class`       | `string / null` | `null`                                           | Layout passthrough if supported                                                                | No       | Parent Patterns may pass layout classes. Do not use for local color, typography, state, or behavior overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, JavaScript initializer, and rendered evidence proof before production use.

### 4.4. JavaScript API

`initToggletips` is the installed initializer for app-owned toggletip behavior.

```js
import { initToggletips } from './ui-controls/toggletips';

initToggletips();
```

### 4.5. Initializer responsibilities:

- Bind triggers and panels emitted by `x-ui.toggletip`.
- Toggle the panel from click, Enter, and Space.
- Synchronize `aria-expanded` with open/closed state.
- Keep closed panels hidden from pointer and keyboard interaction.
- Dismiss the panel when the trigger is activated again.
- Dismiss the panel on Escape.
- Dismiss the panel on outside click.
- Dismiss the panel when focus leaves the trigger and panel group according to installed tab-away behavior.
- Return focus to the trigger when closing from Escape or an internal close button.
- Respect disabled triggers.
- Apply placement and collision behavior owned by the component.
- Respect reduced-motion preferences for open/close transitions.

Feature code may call `initToggletips()` after injecting server-rendered toggletip markup. Feature code must not fork the initializer or attach undocumented toggletip behavior.

### 4.6. Data attribute contract

These attributes are app-owned implementation hooks. They are emitted by the Blade component and consumed by `initToggletips`.

| Data attribute                | Owner                | Purpose                                            |
| ----------------------------- | -------------------- | -------------------------------------------------- |
| `data-ui-toggletip`           | Component            | Root toggletip instance.                           |
| `data-ui-toggletip-trigger`   | Component/JavaScript | Focusable trigger that opens and closes the panel. |
| `data-ui-toggletip-panel`     | Component/JavaScript | Disclosure panel controlled by the trigger.        |
| `data-ui-toggletip-close`     | Component/JavaScript | Optional close control inside the panel.           |
| `data-ui-toggletip-placement` | Component/JavaScript | Installed placement value when emitted.            |

Do not author new `data-*` hooks for toggletip behavior in feature views. Additions require an update to the component, standard, initializer, and rendered evidence proof.

## 5. Allowed variants, options, and modifiers

| Name                            | Type         | Status                       | API                                                                        | Notes                                                                        |
| ------------------------------- | ------------ | ---------------------------- | -------------------------------------------------------------------------- | ---------------------------------------------------------------------------- |
| Contextual help                 | Variant      | Implemented                  | `x-ui.toggletip label="..."`                                               | Short help near labels, headings, settings, or terms.                        |
| Dismissible rich help           | Variant      | Implemented                  | `dismissible` with heading/content                                         | Use for help with links or lightweight secondary actions.                    |
| Form assistance                 | Composition  | Implemented                  | Toggletip adjacent to a field label                                        | Required field guidance still belongs in visible helper text.                |
| Default information trigger     | Trigger mode | Implemented                  | Default icon                                                               | Preferred trigger. Accessible label remains required.                        |
| Disabled trigger                | State        | Implemented                  | `disabled`                                                                 | Use only when the related control or context is unavailable.                 |
| Auto placement                  | Placement    | Implemented / required proof | `placement="auto"`                                                         | Preferred. Component avoids clipping where possible.                         |
| Top placement                   | Placement    | Implemented / required proof | `placement="top"`                                                          | Use only when layout requires it.                                            |
| Right placement                 | Placement    | Implemented / required proof | `placement="right"`                                                        | Use next to inline labels or controls when space allows.                     |
| Bottom placement                | Placement    | Implemented / required proof | `placement="bottom"`                                                       | Default mobile fallback.                                                     |
| Left placement                  | Placement    | Implemented / required proof | `placement="left"`                                                         | Use only when right side lacks space.                                        |
| Start/end placement             | Placement    | Implemented / required proof | `top-start`, `top-end`, `bottom-start`, `bottom-end`                       | Mirrors in RTL where supported.                                              |
| Heading                         | Option       | Implemented                  | `heading="..."`                                                            | Use for rich content or multi-sentence help.                                 |
| Close button                    | Option       | Implemented                  | `dismissible`                                                              | Rich content should include a visible close path.                            |
| Interactive content             | Composition  | Implemented with limits      | Slot content                                                               | Link or one lightweight secondary action only. Do not create mini workflows. |
| Custom trigger slot             | Gated        | Not public unless installed  | Requires accessibility, sizing, icon, and focus proof.                     |                                                                              |
| Hover-only toggletip            | Not allowed  | none                         | Use Tooltip for brief hover/focus-only content.                            |                                                                              |
| Persistent pinned help          | Deferred     | none                         | Requires Popover or Pattern-owned behavior.                                |                                                                              |
| Rich form controls inside panel | Not allowed  | none                         | Use Modal, Side panel, or a page section.                                  |                                                                              |
| Nested overlays                 | Not allowed  | none                         | Do not open Menu, Modal, Tooltip, or another Toggletip inside a toggletip. |                                                                              |

## 6. States

| State                      | Status                                         | Implementation requirement                                                                         |
| -------------------------- | ---------------------------------------------- | -------------------------------------------------------------------------------------------------- |
| Closed                     | Implemented                                    | Trigger shows `aria-expanded="false"` and panel is hidden from interaction.                        |
| Open                       | Implemented                                    | Trigger shows `aria-expanded="true"` and panel is visible.                                         |
| Hover                      | Implemented on trigger                         | Token-backed hover treatment for the trigger only. Hover alone must not be the only open behavior. |
| Focus-visible              | Implemented                                    | Trigger and internal interactive controls show visible focus in all supported themes.              |
| Active/pressed             | Implemented                                    | Trigger activation uses token-backed pressed treatment where installed.                            |
| Disabled trigger           | Implemented                                    | Disabled trigger cannot open the panel and must expose disabled state.                             |
| Dismissed by trigger       | Implemented                                    | Activating the trigger while open closes the panel.                                                |
| Dismissed by close button  | Implemented when `dismissible`                 | Close button hides the panel and returns focus to the trigger.                                     |
| Dismissed by Escape        | Implemented                                    | Escape closes the panel and returns focus to the trigger.                                          |
| Dismissed by outside click | Implemented                                    | Outside click closes the panel.                                                                    |
| Dismissed by tab-away      | Implemented                                    | Leaving the trigger/panel group closes the panel according to installed behavior.                  |
| Focus return               | Implemented                                    | Escape and close-button dismissal return focus to trigger.                                         |
| Reduced motion             | Implemented                                    | Open/close motion respects reduced-motion preferences.                                             |
| Placement flipped          | Implemented where collision handling exists    | Auto placement may choose available space to keep panel visible.                                   |
| RTL mirrored               | Implemented where placement supports start/end | Start/end placement mirrors without feature-local CSS.                                             |
| Loading                    | Not applicable                                 | Toggletip is help disclosure, not async status.                                                    |
| Validation                 | Not applicable                                 | Validation belongs to field components and Forms Pattern.                                          |
| Error/warning/success/info | Not applicable as component state              | Use semantic content and related component states. Toggletip itself is not a status alert.         |
| Read-only                  | Not applicable                                 | Toggletip is interactive disclosure. Use visible static help if interaction is unavailable.        |
| Empty                      | Not allowed                                    | Do not render a toggletip without useful panel content.                                            |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Toggletip consumes Foundation Color, Spacing, Typography, Themes, Motion, and Icons.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons.

2x Grid is parent-owned when toggletips are placed in forms, cards, tables, page headers, or settings layouts. Toggletip does not define grid placement by itself.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                                     |
| ----------- | ------------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Trigger icon/text, panel background, panel border, panel text, close control, hover, focus, disabled, and shadow/elevation roles where tokenized. |
| Spacing     | Trigger hit area, trigger-label gap, panel padding, heading/body spacing, action spacing, close-button inset, and arrow/offset placement.         |
| Typography  | Trigger accessible label is not visual by default; panel heading, body copy, link/action text, and compact help text.                             |
| Themes      | Light/dark/inverse token resolution for trigger, panel, focus, disabled, and interactive content.                                                 |
| Motion      | Productive open/close transition where installed; must respect reduced-motion preferences.                                                        |
| Icons       | Default information icon and optional close icon through the Icons Element standard.                                                              |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-toggletip
.ui-toggletip-trigger
.ui-toggletip-trigger-icon
.ui-toggletip-panel
.ui-toggletip-heading
.ui-toggletip-body
.ui-toggletip-actions
.ui-toggletip-close
.ui-toggletip-open
.ui-toggletip-disabled
.ui-toggletip-placement-auto
.ui-toggletip-placement-top
.ui-toggletip-placement-right
.ui-toggletip-placement-bottom
.ui-toggletip-placement-left
```

Feature views must not create local `toggletip-*`, `tooltip-*`, `popover-*`, `help-icon-*`, Bootstrap popover classes, raw utility clusters, arbitrary colors, arbitrary spacing, local SVG icons, custom focus rings, or component-local JavaScript for the same UI role.

## 8. Composition rules

- Use toggletips near the content they explain.
- Use a focusable trigger with an accessible label.
- The trigger must not be text-only hidden in copy unless a dedicated definition-style API is installed and documented.
- Activating the trigger opens the panel.
- Activating the trigger again closes the panel.
- Escape closes the panel and returns focus to the trigger.
- Outside click closes the panel.
- Tabbing away from the trigger/panel group closes the panel according to installed behavior.
- Interactive elements inside an open panel remain in normal tab order.
- Rich help content must stay lightweight: short text, one link, or one secondary action.
- Do not put form fields, uploaders, menus, tables, tabs, accordions, or nested overlays inside a toggletip.
- Do not use toggletips to hide content required to understand or complete the page.
- Required field instructions belong in visible helper text.
- Validation belongs in the owning field component, not in a toggletip.
- Use Tooltip instead of Toggletip for brief non-interactive content that should appear on hover/focus.
- Use Modal or Overlay/feedback Pattern for blocking, high-stakes, or multi-action help.
- Parent Patterns own grouping, external spacing, workflow orchestration, and page-level layout.
- Components own internal semantics, trigger/panel behavior, placement, dismissal, focus behavior, and token-backed states.

## 9. Selection guidance

### 9.1. Use when:

- Contextual help belongs near a control, label, heading, setting, or term.
- The help content should open intentionally and remain available until dismissed.
- The content includes a link or lightweight interactive element.
- A user may need extra detail without leaving the current task.
- The help is useful but not required to complete the task.

### 9.2. Do not use when:

- The information is required. Put required content directly on the page.
- The information is only a brief non-interactive phrase on hover/focus. Use Tooltip.
- The content is a command list. Use Menu.
- The content is validation or status feedback. Use field validation, Notification, or Inline loading.
- The content requires a user decision, confirmation, or workflow. Use Modal or Overlay/feedback Pattern.
- The content is long enough to need headings, sections, scrolling, or multiple actions. Use a page, side panel, modal, or documentation route.
- The layout is unclear without hidden help. Improve the page layout instead of adding an overlay.

### 9.3. Selection matrix:

| Need                                   | Use                                      |
| -------------------------------------- | ---------------------------------------- |
| Brief non-interactive hover/focus hint | Tooltip                                  |
| Focusable, dismissible contextual help | Toggletip                                |
| Contextual commands                    | Menu                                     |
| Blocking confirmation or decision      | Modal                                    |
| Form validation message                | Owning input component and Forms Pattern |
| System status or feedback              | Notification or Inline loading           |
| Long help or policy content            | Documentation page, Side panel, or Modal |
| Required task instruction              | Visible helper text or page copy         |

## 10. Accessibility contract

- The trigger must be keyboard focusable.
- The trigger must expose an accessible name through the `label` prop.
- The trigger accessible name must describe the help subject, not the icon shape.
- The trigger must synchronize `aria-expanded` with the actual panel state.
- The trigger should use `aria-controls` when the panel has a stable ID.
- The panel must be programmatically associated with the trigger by the installed component markup.
- Closed panels must not be reachable by keyboard or screen-reader virtual cursor as active disclosure content.
- Open panels must make interactive descendants reachable in normal tab order.
- Escape must close the panel.
- Trigger reactivation must close the panel.
- Outside click must close the panel.
- Tabbing away from the trigger/panel group must close the panel according to installed behavior.
- Closing by Escape or close button must return focus to the trigger.
- Close controls must have an accessible label such as `Close help`.
- Focus-visible treatment must be visible in all supported themes.
- Meaning must not rely on color alone.
- The panel must maintain contrast in supported light and dark themes.
- Reduced-motion preferences must be respected.
- Icon-only triggers must preserve minimum interactive target expectations from Button/Icon button guidance.
- Required instructions must not be available only inside a toggletip.
- Hover-only disclosure is prohibited for toggletip behavior.

## 11. Content contract

- Use sentence case.
- Keep trigger labels specific: `About account status`, `About tenant domains`, `About password rules`.
- Do not use trigger labels that describe the icon: `Info`, `Help icon`, `Question mark`.
- Keep panel copy short enough to scan.
- Use a heading when panel content includes more than one sentence, a link, or an action.
- Use concrete nouns and task-specific language.
- Use links sparingly and label them with their destination or purpose.
- Avoid repeating the visible field label unless the repetition clarifies the help subject.
- Do not put legal/policy-level content, full instructions, or multi-step procedures inside a toggletip.
- Do not use toggletip copy as the only place where an error, warning, or requirement is explained.
- Do not put primary actions inside a toggletip.
- If the help changes based on user state, render server-trusted copy and keep it concise.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, custom focus rings, or custom JavaScript.
- Do not create feature-local tooltip, toggletip, popover, disclosure, or help-icon components for the same UI role.
- Do not use Bootstrap popovers or direct Carbon production classes in app markup.
- Do not put required page content in hover-only disclosure.
- Do not put required page content only inside a toggletip.
- Do not use overlays to avoid designing a clear page layout.
- Do not use toggletips for validation, errors, warnings, success messages, or loading states.
- Do not put form fields, menus, tabs, accordions, tables, uploaders, or nested overlays inside a toggletip.
- Do not put primary workflow actions inside a toggletip.
- Do not use toggletips as navigation.
- Do not render a toggletip with empty or duplicate content.
- Do not rely on color alone for state or meaning.
- Do not invent local placement, collision, focus-return, or dismissal scripts.
- Do not show fake toggletip behavior in rendered evidence examples for deferred capabilities.

## 13. Deferred or gated capabilities

| Capability                        | Status      | Gate                                                                                                                             |
| --------------------------------- | ----------- | -------------------------------------------------------------------------------------------------------------------------------- |
| Custom trigger slot               | Gated       | Requires documented trigger contract, minimum target, accessible name, icon/label rules, focus behavior, and rendered evidence proof. |
| Definition-style inline toggletip | Deferred    | Requires text-trigger semantics, underline/border treatment, keyboard behavior, and content rules.                               |
| Persistent pinned help            | Deferred    | Requires Popover or Pattern-owned persistence behavior and focus management.                                                     |
| Rich action groups                | Deferred    | Use Modal, Side panel, or a page flow until a Pattern owns multi-action contextual help.                                         |
| Async content loading             | Deferred    | Requires loading, error, retry, focus, and announcement behavior.                                                                |
| Panel scrolling                   | Deferred    | Long content should move to a larger overlay or page.                                                                            |
| Nested overlays inside toggletip  | Not allowed | Use a larger Pattern-owned overlay instead.                                                                                      |
| Hover-only toggletip              | Not allowed | Use Tooltip for hover/focus-only supplemental text.                                                                              |
| Arbitrary placement offsets       | Not allowed | Requires implementation and rendered evidence proof.                                                                                  |
| Custom semantic colors            | Not allowed | Requires Color Element standard update and proof.                                                                                |

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

The Toggletip page is an overlay component reference page. The Live examples card should use focused examples, placement rows, state matrices, and dismissal behavior proof. It must not render fake controls for deferred capabilities.

### 15.1. Required Live examples internal sections:

| Required proof                   | Rendered behavior                                                                                                            | Variants/options shown                                                            |
| -------------------------------- | ---------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------- |
| Contextual help                  | Information trigger opens and closes a concise help panel near related content.                                              | Closed, Open, Focus-visible, Auto placement, Escape dismissal                     |
| Dismissible rich help            | Panel includes a heading, body copy, optional link/action, and visible close control.                                        | Heading, Dismissible, Close button, Focus return, Outside-click dismissal         |
| Form assistance                  | Toggletip sits beside a field label while required field guidance remains visible as helper text.                            | Field-label composition, Helper text separation, Right or bottom placement        |
| Placement behavior               | Toggletip examples render approved placements and avoid clipping where possible.                                             | Auto, Top, Right, Bottom, Left, Start/end placement, Mobile bottom fallback       |
| State matrix                     | Trigger and panel examples show installed interaction states.                                                                | Hover, Focus-visible, Active/pressed, Disabled trigger, Open, Closed              |
| Keyboard and dismissal proof     | Examples document and test click, Enter, Space, Escape, outside click, tab-away, and focus return.                           | Trigger activation, Escape, Outside click, Tab-away, Focus return                 |
| Reduced-motion proof             | Open/close behavior respects reduced-motion expectations.                                                                    | Reduced motion, Token-backed transition                                           |
| Developer implementation         | Canonical Blade calls and initializer usage render as real code examples.                                                    | `x-ui.toggletip`, `initToggletips`, `data-ui-toggletip*`, supported props/options |
| Prohibited and deferred examples | Page shows unsupported hover-only, nested overlay, long content, required-content, and custom-trigger cases as not approved. | Deferred gates, prohibited usage, approved alternatives                           |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered states, rendered variants/options, prohibited usage, deferred gates, JavaScript initializer requirements, data attribute contract, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- Developer examples use `x-ui.toggletip`, not placeholder comments or ad hoc markup.
- JavaScript examples reference `initToggletips` from `resources/js/ui-controls/toggletip.js`.
- The trigger exposes a clear accessible label.
- The trigger synchronizes `aria-expanded` with open/closed state.
- The page documents open, closed, hover, focus-visible, active/pressed, disabled trigger, dismissal, focus return, and reduced-motion states.
- Contextual help examples render concise, non-required help content.
- Rich help examples render heading, content, optional link/action, and close control.
- Form assistance examples keep required instructions visible outside the toggletip.
- Placement examples include auto, top, right, bottom, and left behavior.
- Dismissal examples document trigger reactivation, Escape, outside click, tab-away, close button, and focus return.
- Deferred examples render trigger conditions instead of fake persistent, async, nested, or hover-only toggletip controls.
- The page contains no generic placeholder content.
- Tests assert stale labels and legacy scaffolding remain absent when they are not part of approved UI copy.
- Tests assert no raw Bootstrap popover, hard-coded color, arbitrary local spacing, feature-local toggletip class system, local JavaScript disclosure controller, or direct Carbon production class is presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Toggletip');
$response->assertSee('x-ui.toggletip');
$response->assertSee('initToggletips');
$response->assertSee('data-ui-toggletip');
$response->assertSee('aria-expanded');
$response->assertSee('Contextual help');
$response->assertSee('Dismissible rich help');
$response->assertSee('Form assistance');
$response->assertSee('Placement behavior');
$response->assertSee('Keyboard and dismissal proof');
$response->assertSee('Reduced-motion proof');
$response->assertSee('Focus return');
$response->assertSee('Escape');
$response->assertSee('Outside click');
$response->assertSee('Tab-away');
$response->assertSee('Auto placement');
$response->assertSee('Disabled trigger');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('<li>None.</li>', false);
$response->assertDontSee('Use only documented props/options');
$response->assertDontSee('See rendered evidence developer implementation section');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('popover bs-popover');
$response->assertDontSee('dropdown-menu');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
```

## 17. Related APIs

| API                      | Route                                                               |
| ------------------------ | ------------------------------------------------------------------- |
| Button                   | `not installed`                          |
| Icon button              | `not installed`                     |
| Tooltip                  | `not installed`                         |
| Popover                  | `not installed`                         |
| Modal                    | `not installed`                           |
| Notification             | `not installed`                    |
| Forms pattern            | `not installed`                             |
| Overlay/feedback pattern | `not installed`                 |
| Layout Pattern           | `not installed`                            |
| Color element            | `not installed`                             |
| Spacing element          | `not installed`                           |
| Typography element       | `not installed`                        |
| Themes element           | `not installed`                            |
| Motion element           | `not installed`                            |
| Icons element            | `not installed`                             |
| Components overview      | `not installed`                                 |
| Canonical toggletip doc  | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Ftoggletip.md` |
| Carbon toggletip usage   | `https://carbondesignsystem.com/components/toggletip/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Toggletip usage, style, and accessibility guidance inform intentional click/keyboard disclosure, interactive panel content, auto placement, dismissal behavior, focusability, and tooltip/toggletip separation. Login App keeps its own Blade API, JavaScript initializer, internal icon standard, app-owned data attributes, `ui-*` class contract, and rendered evidence proof.