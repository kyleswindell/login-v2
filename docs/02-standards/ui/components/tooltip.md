---
title: Tooltip
slug: tooltip
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: overlays
priority: tier-a-baseline-app-development
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/tooltip.md
source_owner: not installed
blade_api:
  - x-ui.tooltip
javascript_api: []
source_files:
  - resources/views/components/ui/tooltip/index.blade.php
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
  - toggletip
  - popover
  - modal
  - link
related_patterns:
  - forms
  - overlays-feedback
  - tables
carbon_reference:
  - https://carbondesignsystem.com/components/tooltip/usage/
  - https://carbondesignsystem.com/components/tooltip/style/
  - https://carbondesignsystem.com/components/tooltip/accessibility/
---

# Tooltip Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical icon-only button tooltip](#41-canonical-icon-only-button-tooltip)
  - [4.2. Canonical definition tooltip](#42-canonical-definition-tooltip)
  - [4.3. Disabled-control explanation pattern](#43-disabled-control-explanation-pattern)
  - [4.4. API surfaces](#44-api-surfaces)
  - [4.5. Props and options](#45-props-and-options)
  - [4.6. Component-owned data attributes](#46-component-owned-data-attributes)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
  - [7.4. Helper and composition usage](#74-helper-and-composition-usage)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
  - [9.3. Component selection:](#93-component-selection)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
  - [11.1. Examples:](#111-examples)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and Rendered Evidence Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. rendered evidence proof checklist](#142-ui-reference-proof-checklist)
- [15. Rendered evidence requirements](#15-ui-reference-requirements)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Tooltip provides short, non-interactive help when a user hovers over or focuses a trigger.

Canonical API owner: `not installed`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Tooltip is the installed Login App 2.0 non-interactive help overlay API. It owns short descriptive copy, hover/focus opening, Escape dismissal, positioning, tooltip surface styling, accessible description linkage, reduced-motion behavior, and icon-only/definition tooltip patterns. It does not own interactive disclosure, required content, persistent messages, menus, form validation, popovers, modal decisions, or page layout.

Tooltip anatomy: UI trigger, Caret tip, and Container.

### 1.1. Canonical API responsibilities:

- Render short non-interactive help through `x-ui.tooltip`.
- Associate tooltip text with the trigger as a description, not as the trigger’s primary name.
- Render a caret tip that visually associates the tooltip container with the trigger.
- Open on hover and keyboard focus.
- Close on blur, pointer leave, Escape, or disabled/unavailable trigger state according to the installed behavior.
- Keep focus on the trigger; tooltip content must not receive focus.
- Support approved placements when implementation proves collision and responsive behavior.
- Support icon-only button tooltip, definition tooltip, and disabled-control explanation patterns.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, and icons where trigger icons are rendered.
- Prove trigger, placement, open/closed, focus-visible, Escape, disabled-control explanation, reduced-motion, and developer implementation behavior on the rendered evidence page.

### 1.2. Non-owned responsibilities:

- Interactive content, links, buttons, form fields, or actions inside the overlay. Use Toggletip, Popover, Modal, or an owning Pattern.
- Required instructions or required page content. Put the content on the page.
- Persistent help, errors, warnings, success, or status messages. Use helper text, Notification, Forms Pattern, or the owning Pattern.
- Menu disclosure. Use Menu buttons or Popover where installed.
- Blocking decisions. Use Modal.
- External spacing and layout. Parent Patterns own placement around the trigger.

## 2. Status and ownership

| Field                        | Value                                                                      |
| ---------------------------- | -------------------------------------------------------------------------- |
| Status                       | Approved API                                                               |
| System maturity              | Partial                                                                    |
| API layer                    | Component API                                                              |
| Component slug               | tooltip                                                                    |
| Category                     | Overlays                                                                   |
| Priority                     | Tier A - Baseline app development                                          |
| Rendered evidence route           | `not installed`                                |
| Canonical doc                | `docs/02-standards/ui/components/tooltip.md`                               |
| Source owner                 | `not installed`                                |
| Blade API                    | `x-ui.tooltip`                                                             |
| JavaScript API               | No dedicated public JavaScript controller required for feature views       |
| Source files                 | `resources/views/components/ui/tooltip/index.blade.php`; `resources/css/app.css` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons                          |
| Carbon benchmark             | Carbon Tooltip usage, style, and accessibility guidance                    |

`Approved API` means the component exists, but the public API, non-interactive boundary, accessibility contract, placement rules, disabled-control explanation pattern, rendered evidence examples, and regression tests must be corrected so feature teams do not create local hover help or interactive tooltip implementations.

## 3. Installed standard

Tooltip is the standard for brief optional help that supplements a visible trigger.

### 3.1. The installed standard is:

- Render tooltips through `<x-ui.tooltip>`.
- Use tooltips only for short, nonessential, non-interactive help.
- Use tooltip copy to clarify a visible label, icon-only action, truncated label, or definition term.
- Use `text` or the default slot for concise tooltip content.
- Use `placement` only from the approved placement set.
- Keep tooltip content text-only or simple inline text.
- Do not place links, buttons, inputs, menus, checkboxes, radios, toggles, or any other focusable content inside a tooltip.
- Keep focus on the trigger while the tooltip is open.
- Use Toggletip or Popover when users must click, copy, read longer content, or interact with the overlay.
- Use visible helper text instead of Tooltip when the information is required to complete the task.
- Use Modal when the content blocks the user or requires a decision.
- Do not create local hover cards, local title-only help, local tooltip JavaScript, local ARIA, raw utility clusters, raw colors, local icons, or custom positioning for this role.

Carbon alignment note: Carbon distinguishes tooltips from toggletips and popovers by interaction model and content scope. Tooltips are contextual, helpful, nonessential, and non-interactive; they appear on hover or focus and can be dismissed with Escape. Login App maps those principles to its own `x-ui.tooltip` API, `ui-*` namespace, Foundation tokens, and rendered evidence proof instead of adopting Carbon implementation classes directly.

## 4. Public API

### 4.1. Canonical icon-only button tooltip

```blade
<x-ui.tooltip text="Edit workspace" placement="top">
    <x-ui.icon-button
        icon="edit"
        label="Edit workspace"
        semantic="ghost"
    />
</x-ui.tooltip>
```

### 4.2. Canonical definition tooltip

```blade
<x-ui.tooltip text="A workspace groups users, roles, and settings for one account." placement="top">
    <button type="button" class="ui-tooltip__definition-trigger">
        Workspace
    </button>
</x-ui.tooltip>
```

### 4.3. Disabled-control explanation pattern

Native disabled controls usually cannot receive focus, so the tooltip trigger must be a focusable wrapper or adjacent explanation trigger when the rendered evidence proves the pattern.

```blade
<x-ui.tooltip text="You need admin access to delete this workspace." placement="top" size="multi">
    <span class="ui-tooltip__disabled-trigger" tabindex="0">
        <x-ui.button semantic="danger" type="button" disabled>
            Delete workspace
        </x-ui.button>
    </span>
</x-ui.tooltip>
```

Use this pattern only when a visible disabled state needs a short explanation. For required guidance, use helper text or an inline message.

### 4.4. API surfaces

| API surface           | Installed value                                                                                                                                                    |
| --------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Blade API             | `x-ui.tooltip`                                                                                                                                                     |
| JavaScript            | No dedicated public JavaScript controller required for feature views. Any event handling, positioning, Escape dismissal, or collision behavior is component-owned. |
| Root semantic element | Component-owned tooltip surface associated to the trigger through `aria-describedby` or equivalent installed markup                                                |
| Trigger               | Default slot wraps exactly one trigger or approved disabled-control wrapper                                                                                        |
| Tooltip content       | `text` prop or default tooltip-content slot, limited to short non-interactive text                                                                                 |
| Data attributes       | Component-owned attributes documented below. Feature views must not invent tooltip behavior attributes.                                                            |
| CSS namespace         | App-owned `ui-*` tooltip classes documented by the component implementation                                                                                        |
| Source files          | `resources/views/components/ui/tooltip/index.blade.php`; `resources/css/app.css`                                                                                         |

### 4.5. Props and options

| Prop/option                                 | Type                | Default                    | Allowed values                                  | Required                                                                              | Notes                                                                                                                           |
| ------------------------------------------- | ------------------- | -------------------------- | ----------------------------------------------- | ------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------- |
| `text`                                      | `string / null`     | `null`                     | Short non-interactive help text                 | Required unless tooltip content slot is provided                                      | Preferred API for simple tooltip copy.                                                                                          |
| Default slot                                | `Htmlable / string` | none                       | Exactly one trigger element or approved wrapper | Yes                                                                                   | The trigger must be focusable unless using an approved disabled-control wrapper.                                                |
| Tooltip content slot                        | `string / null`     | `null`                     | Short inline text only                          | Required only when `text` is omitted                                                  | Do not include focusable or interactive elements.                                                                               |
| `placement`                                 | `string`            | `auto`                     | `auto`, `top`, `right`, `bottom`, `left`        | No                                                                                    | Auto placement is component-owned; mobile auto placement resolves below the trigger.                                             |
| `align`                                     | `string`            | `center`                   | `start`, `center`, `end`                        | No                                                                                    | Aligns the container and caret to keep the tooltip in view and attached to the trigger.                                          |
| `size`                                      | `string`            | `auto`                     | `auto`, `single`, `multi`, `definition`         | No                                                                                    | Single-line, multi-line, and definition sizing follow Tooltip structure rules.                                                   |
| `kind`                                      | `string`            | `default`                  | `default`, `definition`                         | No                                                                                    | Definition applies dotted underline trigger treatment and definition sizing.                                                     |
| `open`                                      | `bool`              | `false`                    | `true`, `false`                                 | No                                                                                    | rendered evidence proof state only unless a product surface explicitly owns an initially open tooltip.                                |
| `openDelay` / `open-delay` / `int / null`   | source default      | Approved millisecond value | No                                              | Gated unless source exposes timing as public API. Do not create local delay behavior. |                                                                                                                                 |
| `closeDelay` / `close-delay` / `int / null` | source default      | Approved millisecond value | No                                              | Gated unless source exposes timing as public API.                                     |                                                                                                                                 |
| `disabled`                                  | `bool`              | `false`                    | `true`, `false`                                 | No                                                                                    | Disables tooltip behavior, not necessarily the trigger.                                                                         |
| `id`                                        | `string / null`     | generated by component     | Valid document ID                               | No                                                                                    | Use when tests or describedby relationships need a stable ID.                                                                   |
| `class`                                     | `string / null`     | `null`                     | Layout passthrough if supported                 | No                                                                                    | Parent Patterns may pass placement classes only. Do not use for local color, typography, state, z-index, or behavior overrides. |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the rendered evidence proof before use.

### 4.6. Component-owned data attributes

| Data attribute                                            | Status                   | Owner     | Purpose                                                                                   |
| --------------------------------------------------------- | ------------------------ | --------- | ----------------------------------------------------------------------------------------- |
| `data-ui-component="tooltip"`                             | Implemented when emitted | Component | Identifies the root component for testing and diagnostics.                                |
| `data-ui-tooltip-trigger`                                 | Implemented when emitted | Component | Identifies the trigger for component-owned behavior.                                      |
| `data-ui-tooltip-content`                                 | Implemented when emitted | Component | Identifies the tooltip surface for component-owned behavior.                              |
| `data-ui-tooltip-caret`                                   | Implemented when emitted | Component | Identifies the caret tip that associates the container to the trigger.                    |
| `data-ui-tooltip-state="open / closed"`                   | Implemented when emitted | Component | Exposes open/closed state for tests and component-owned styling only.                     |
| `data-ui-tooltip-placement="auto / top / right / bottom / left"` | Implemented when emitted | Component | Exposes requested placement for tests and component-owned styling only.           |
| `data-ui-tooltip-resolved-placement`                      | Implemented when emitted | Component | Exposes resolved placement after auto/collision handling.                                |
| `data-ui-tooltip-align="start / center / end"`            | Implemented when emitted | Component | Exposes alignment for tests and component-owned styling only.                            |
| `data-ui-tooltip-size="single / multi / definition"`      | Implemented when emitted | Component | Exposes sizing contract for tests and component-owned styling only.                      |
| Feature-local data attributes                             | Not allowed              | none      | Do not create local tooltip state, positioning, timing, or dismissal behavior attributes. |

## 5. Allowed variants, options, and modifiers

| Name                         | Type      | Status                       | API                                          | Notes                                                                                          |
| ---------------------------- | --------- | ---------------------------- | -------------------------------------------- | ---------------------------------------------------------------------------------------------- |
| Icon-only button tooltip     | Scenario  | Implemented                  | `x-ui.tooltip` wrapping `x-ui.icon-button`   | Clarifies icon-only action labels. Accessible label still belongs to the Icon button.          |
| Definition tooltip           | Scenario  | Implemented                  | `x-ui.tooltip` wrapping a definition trigger | Defines a term or short concept. Trigger exists only to expose the definition.                 |
| Disabled-control explanation | Pattern   | Implemented / required proof | Focusable wrapper or adjacent trigger        | Required because native disabled controls are not focusable. Do not use for long instructions. |
| Truncated text tooltip       | Scenario  | Gated unless implemented     | `x-ui.tooltip` with text trigger             | Requires overflow proof and keyboard access.                                                   |
| Top placement                | Placement | Implemented                  | `placement="top"`                            | Default when there is room.                                                                    |
| Right placement              | Placement | Implemented / required proof | `placement="right"`                          | Use when top placement conflicts with layout.                                                  |
| Bottom placement             | Placement | Implemented / required proof | `placement="bottom"`                         | Use when top/right are not appropriate.                                                        |
| Left placement               | Placement | Implemented / required proof | `placement="left"`                           | Use when right placement conflicts with layout.                                                |
| Start/center/end alignment   | Modifier  | Gated unless implemented     | `align`                                      | Requires collision, RTL, and responsive proof.                                                 |
| Open on hover                | Behavior  | Implemented                  | automatic                                    | Pointer users can reveal help by hovering the trigger.                                         |
| Open on focus                | Behavior  | Implemented                  | automatic                                    | Keyboard users can reveal help by focusing the trigger.                                        |
| Escape dismissal             | Behavior  | Implemented                  | automatic                                    | Escape closes an open tooltip without moving focus.                                            |
| Click-to-open tooltip        | Behavior  | Not owned by Tooltip         | none                                         | Use Toggletip or Popover.                                                                      |
| Interactive tooltip content  | Mode      | Not allowed                  | none                                         | Use Toggletip, Popover, or Modal.                                                              |
| Rich content tooltip         | Mode      | Not allowed                  | none                                         | Use Toggletip or Popover.                                                                      |
| Required help tooltip        | Mode      | Not allowed                  | none                                         | Use visible helper text or page content.                                                       |
| Custom trigger icon          | Modifier  | Not allowed                  | none                                         | Use Icon button, Button, Link, or approved trigger component.                                  |
| Custom animation             | Modifier  | Not allowed                  | none                                         | Motion is component-owned and token-backed.                                                    |

## 6. States

| State                        | Status                       | Implementation requirement                                                                                        |
| ---------------------------- | ---------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| Closed                       | Implemented                  | Tooltip surface is hidden and does not obscure content.                                                           |
| Open on hover                | Implemented                  | Tooltip appears when pointer hovers the trigger and remains available according to hoverable/persistent behavior. |
| Open on focus                | Implemented                  | Tooltip appears when keyboard focus reaches the trigger.                                                          |
| Escape dismissed             | Implemented                  | Escape closes the tooltip while focus remains on the trigger.                                                     |
| Focus-visible trigger        | Implemented                  | Trigger focus styling remains visible in all supported themes.                                                    |
| Hover trigger                | Implemented                  | Trigger hover treatment belongs to the trigger component; tooltip surface uses token-backed overlay styling.      |
| Disabled tooltip             | Implemented                  | `disabled` prevents tooltip behavior.                                                                             |
| Disabled control explanation | Implemented / required proof | Uses focusable wrapper or adjacent trigger so keyboard users can access the explanation.                          |
| Placement/collision          | Implemented / required proof | Tooltip remains associated with the trigger and avoids viewport clipping where source supports it.                |
| Reduced motion               | Implemented                  | Tooltip entrance/exit behavior honors Foundation Motion and reduced-motion preferences.                           |
| Overflow/truncated           | Gated                        | Requires proof that truncated text can be exposed by mouse and keyboard without replacing required content.       |
| Loading                      | Not applicable               | Tooltip does not own loading. Use Inline loading or Loading for pending work.                                     |
| Validation                   | Not owned                    | Validation errors and helper text belong to field components and Forms Pattern.                                   |
| Success/warning/error/info   | Not owned                    | Status meaning belongs to Notification, helper text, Forms Pattern, or owning component.                          |
| Current/selected             | Not applicable               | Tooltip is not a selection control.                                                                               |
| Expanded/collapsed           | Not applicable               | Use Toggletip, Popover, or Disclosure when users control persistent expanded content.                             |
| Empty                        | Not applicable               | Do not render an empty tooltip. Provide text or do not render the component.                                      |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Tooltip consumes Foundation Color, Spacing, Typography, Themes, Motion, and Icons where trigger components render icons.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                                               |
| ----------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Tooltip surface, text, arrow/caret if installed, border/shadow if tokenized, focus-visible trigger through trigger component, and supported theme contrast. |
| Spacing     | Tooltip padding, trigger-to-tooltip offset, arrow/caret offset, compact line-height support, and viewport gap.                                              |
| Typography  | Tooltip body text size, line-height, wrapping, and definition trigger text treatment.                                                                       |
| Themes      | Light, dark, and inverse token resolution for surface, text, arrow/caret, focus, and trigger treatments.                                                    |
| Motion      | Entrance/exit opacity/transform where installed and reduced-motion fallback.                                                                                |
| Icons       | Icon-only triggers through Icon button; no tooltip-local icon set is approved.                                                                              |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$background-inverse` | Tooltip surface background | `ui-tooltip__surface`, inverse tooltip role | App inverse palette | Same role / app value | Tooltip uses the inverse surface role by default unless a later theme variant is documented. |
| `$text-inverse` | Tooltip text | `ui-tooltip__content` text role | App inverse text palette | Same role / app value | Tooltip text must remain readable on inverse surface. |
| `$border-interactive` | Definition tooltip hover underline/border | `ui-tooltip__definition-trigger:hover` | App border-interactive role | Same role / app value | Definition trigger styling stays token-backed. |
| `$focus` | Definition/trigger focus border | Trigger focus-visible state | App focus palette | Same role / app value | Focus may be owned by the trigger component, but value remains Color-owned. |

### 7.3. CSS namespace

Allowed component classes must use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-tooltip
.ui-tooltip__trigger
.ui-tooltip__content
.ui-tooltip__surface
.ui-tooltip__arrow
.ui-tooltip__definition-trigger
.ui-tooltip__disabled-trigger
.ui-tooltip--open
.ui-tooltip--closed
.ui-tooltip--top
.ui-tooltip--right
.ui-tooltip--bottom
.ui-tooltip--left
.ui-tooltip--align-start
.ui-tooltip--align-center
.ui-tooltip--align-end
.ui-tooltip--reduced-motion
```

Feature views must not create Bootstrap tooltip classes, local `tooltip-*` classes, raw utility clusters, arbitrary z-indexes, local arrows, local portals, local focus rings, local timing CSS, direct Carbon implementation classes, or one-off overlay JavaScript for the same UI role.

### 7.4. Helper and composition usage

| Helper/API         | Status                                       | Allowed usage                                                                                                |
| ------------------ | -------------------------------------------- | ------------------------------------------------------------------------------------------------------------ |
| `x-ui.tooltip`     | Implemented                                  | Canonical short non-interactive help overlay.                                                                |
| `x-ui.icon-button` | Implemented                                  | Most common icon-only trigger. Icon button still needs an accessible label.                                  |
| `x-ui.button`      | Implemented                                  | Trigger only when the tooltip supplements an action; the action label must remain clear without the tooltip. |
| `x-ui.link`        | Implemented when Link owns trigger semantics | Tooltip may supplement a link only if the link text remains understandable without it.                       |
| Toggletip          | Related component                            | Use for click/Enter disclosure and longer text-only help.                                                    |
| Popover            | Related component                            | Use for interactive or richer floating content.                                                              |
| Modal              | Related component                            | Use for blocking decisions or required tasks.                                                                |
| Forms Pattern      | Pattern-owned                                | Use visible helper/error text for required form guidance.                                                    |

## 8. Composition rules

- Wrap exactly one trigger or approved disabled-control wrapper.
- The trigger must be understandable without the tooltip.
- Tooltip copy supplements the trigger; it must not replace the trigger label.
- Keep tooltip content short and non-interactive.
- Keep focus on the trigger while the tooltip is open.
- Do not place focusable elements inside tooltip content.
- Do not use Tooltip for information users must read before proceeding.
- Do not use Tooltip for form error messages or required instructions.
- Use Toggletip when the user must intentionally open and read a small help disclosure.
- Use Popover when the floating content includes interactive controls, links, or richer content.
- Use Modal when the content requires a blocking decision or contained task.
- Use visible helper text when the information is needed to complete a form field.
- Use an approved disabled-control explanation pattern because native disabled controls cannot receive keyboard focus.
- Parent Patterns own trigger placement, external spacing, workflow context, and whether the help belongs inline instead.
- Component owns tooltip semantics, positioning, open/close behavior, Escape dismissal, surface styling, arrow/caret behavior, motion, and token-backed states.

## 9. Selection guidance

### 9.1. Use when:

- An icon-only button needs a short text description on hover and focus.
- A term or label needs a short definition that is helpful but nonessential.
- Truncated text needs a keyboard-accessible full-text reveal and the truncated content is not required page content.
- A disabled control needs a short explanation and the approved disabled-control explanation pattern is used.
- The help copy is brief enough to scan quickly and does not require interaction.

### 9.2. Do not use when:

- The information is required to complete the task.
- The content includes links, buttons, fields, or other interactive controls.
- The content is long, structured, or needs headings/lists.
- The user must click to open or intentionally keep the disclosure open; use Toggletip or Popover.
- The overlay blocks the user until a decision is made; use Modal.
- The content is validation, warning, success, error, or system status feedback.
- The tooltip is being used to compensate for unclear labels or poor layout.
- The trigger is not focusable and no approved keyboard-accessible wrapper exists.

### 9.3. Component selection:

| Need                               | Use                                                          |
| ---------------------------------- | ------------------------------------------------------------ |
| Short optional help on hover/focus | Tooltip                                                      |
| Icon-only action label support     | Tooltip plus Icon button accessible label                    |
| Click/Enter text disclosure        | Toggletip                                                    |
| Interactive floating content       | Popover                                                      |
| Required blocking decision         | Modal                                                        |
| Required form help                 | Visible helper text through Forms Pattern                    |
| Validation or status feedback      | Field error, Notification, Inline loading, or owning Pattern |
| Menu or action list                | Menu buttons/Menu                                            |

## 10. Accessibility contract

- Tooltip trigger must be keyboard focusable unless using an approved disabled-control wrapper pattern.
- Tooltip content must be associated with the trigger as a description through `aria-describedby` or equivalent component-owned markup.
- Tooltip content must not provide the trigger’s only accessible name.
- Tooltip content must not receive focus.
- Tooltip content must not include interactive controls.
- Tooltip appears on pointer hover and keyboard focus.
- Tooltip disappears when focus leaves the trigger or pointer leaves the active hover area according to the installed behavior.
- Escape closes an open tooltip without moving focus.
- Tooltip content must be dismissible, hoverable, and persistent enough to satisfy hover/focus accessibility expectations when it appears over other content.
- Trigger focus-visible treatment must remain visible while tooltip is open.
- Icon-only triggers require an accessible label from Icon button, independent of tooltip copy.
- Definition tooltip triggers exist only to receive focus/hover for a definition and must not behave like buttons that perform an action.
- Disabled native controls cannot be the only tooltip trigger because they are not focusable. Use an approved wrapper or adjacent trigger pattern.
- Tooltip content must maintain contrast in supported light and dark themes.
- Meaning must not rely on color alone.
- Reduced-motion preferences must be respected.
- Tooltip must not trap focus, move focus, or require a click to close.

## 11. Content contract

- Use sentence case.
- Keep copy short: one phrase or one brief sentence is preferred.
- Describe the help or meaning, not the mechanics of the tooltip.
- For icon-only actions, the tooltip text should match or closely reinforce the accessible action label.
- For definition tooltips, define the term directly.
- For disabled-control explanations, state the requirement or reason briefly.
- Avoid punctuation-heavy or multi-paragraph content.
- Avoid vague copy such as `More info`, `Help`, `Details`, or `Tooltip`.
- Do not include instructions that users must remember to complete the task.
- Do not include links, button labels, form instructions, validation errors, stack traces, internal IDs, or backend details.
- If the copy is longer than a short sentence, use Toggletip, Popover, visible helper text, or a page section.

### 11.1. Examples:

| Context                | Good tooltip copy                                                | Avoid                                                                    |
| ---------------------- | ---------------------------------------------------------------- | ------------------------------------------------------------------------ |
| Icon-only edit button  | `Edit workspace`                                                 | `Pencil`                                                                 |
| Definition term        | `A workspace groups users, roles, and settings for one account.` | `More information about workspaces and how they function in the system.` |
| Disabled delete button | `You need admin access to delete this workspace.`                | `Disabled`                                                               |
| Truncated label        | Full label text                                                  | `View full text`                                                         |

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, local focus rings, local z-indexes, or custom JavaScript.
- Do not create local tooltip markup, local positioning, local hover/focus listeners, local Escape listeners, or local collision behavior.
- Do not use Bootstrap tooltip classes, browser-only `title` attributes as the app tooltip standard, or direct Carbon production classes.
- Do not place required page content in Tooltip.
- Do not place interactive content inside Tooltip.
- Do not use Tooltip for form validation errors, warnings, success messages, or system status.
- Do not use Tooltip to hide instructions that should be visible.
- Do not use Tooltip as a Popover, Toggletip, Modal, Menu, Dropdown, or Toast.
- Do not use Tooltip to avoid writing clear button, link, field, table header, or icon-button labels.
- Do not rely on color alone for meaning.
- Do not render an empty tooltip.
- Do not use a non-focusable trigger unless the component or Pattern supplies a keyboard-accessible wrapper.
- Do not make disabled native controls the only tooltip trigger.
- Do not add custom placement values, custom widths, custom animations, or custom arrows outside the component API.

## 13. Deferred or gated capabilities

| Capability                                  | Status                       | Gate                                                                                                              |
| ------------------------------------------- | ---------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| Truncated text tooltip                      | Gated                        | Requires overflow detection/authoring rules, keyboard-accessible trigger, full-text copy, and rendered evidence proof. |
| Disabled-control explanation wrapper        | Implemented / required proof | Requires focusable wrapper semantics, disabled child control behavior, pointer/keyboard parity, and tests.        |
| Start/end alignment                         | Gated unless implemented     | Requires placement, collision, RTL, and responsive proof.                                                         |
| Collision-aware auto placement              | Deferred unless implemented  | Requires documented positioning behavior, viewport tests, scroll-container tests, and reduced-motion proof.       |
| Custom open/close delay props               | Gated                        | Requires source implementation, timing limits, hover/focus parity, and accessibility proof.                       |
| Rich text tooltip                           | Not allowed                  | Use Toggletip, Popover, or visible content.                                                                       |
| Interactive tooltip                         | Not allowed                  | Use Toggletip, Popover, or Modal.                                                                                 |
| Click-to-open tooltip                       | Not owned                    | Use Toggletip or Popover.                                                                                         |
| Tooltip groups or delegated global tooltips | Deferred                     | Requires event delegation contract, cleanup behavior, and tests.                                                  |
| Custom tooltip themes                       | Not allowed                  | Requires Color, Themes, and accessibility proof.                                                                  |
| Third-party tooltip package                 | Not allowed                  | Requires architectural approval and wrapper Component API proof before use.                                       |

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

The Tooltip page is a compact overlay component reference. The Live examples card should use grouped scenario examples plus a placement/state matrix. It must render production component examples for implemented behavior and explicit trigger conditions for gated capabilities.

| Required proof                       | Rendered behavior                                                                                                                                | Variants/options shown                                                                 |
| ------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------ | -------------------------------------------------------------------------------------- |
| Icon-only button tooltip             | Icon button has its own accessible label and reveals short tooltip copy on hover/focus.                                                          | Icon button trigger, Open, Closed, Focus-visible, Escape dismissal, Reduced motion     |
| Definition tooltip                   | Definition trigger reveals a short non-interactive definition on hover/focus.                                                                    | Definition trigger, `aria-describedby`, Open/closed, Escape dismissal                  |
| Disabled-control explanation pattern | Disabled button explanation is reachable by keyboard through the approved wrapper or adjacent trigger.                                           | Disabled trigger pattern, Focusable wrapper, Disabled child control, Short reason copy |
| Placement matrix                     | Tooltip renders approved placements without local placement classes.                                                                             | Top, Right, Bottom, Left; alignment gated if not implemented                           |
| Accessibility matrix                 | Page proves trigger focus, describedby linkage, non-focusable tooltip content, Escape dismissal, no interactive content, and hover/focus parity. | Focus-visible, Hover, Escape, Non-interactive content, Accessible names                |
| Content examples                     | Page contrasts good short tooltip copy with prohibited required/interactive/long content.                                                        | Icon label copy, Definition copy, Disabled reason copy, Long content prohibited        |
| Tooltip vs related overlays          | Page shows decision boundaries without fake controls.                                                                                            | Tooltip, Toggletip, Popover, Modal, helper text                                        |
| Reduced-motion behavior              | Tooltip entrance/exit uses Foundation Motion and reduced-motion fallback.                                                                        | Open/closed, Reduced motion                                                            |
| Deferred/gated capabilities          | Page documents trigger conditions instead of fake controls.                                                                                      | Truncated text tooltip, custom delay, collision-aware placement, alignment             |
| Developer implementation             | Canonical calls and props render as real code examples.                                                                                          | `x-ui.tooltip`, `text`, `placement`, disabled-control wrapper pattern                  |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered scenarios, rendered states, allowed options, prohibited usage, deferred gates, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The icon-only button tooltip example renders `x-ui.tooltip` with an `x-ui.icon-button` trigger and a short text tooltip.
- The definition tooltip example renders a keyboard-focusable definition trigger.
- The disabled-control explanation example renders a keyboard-accessible wrapper or adjacent trigger, not an inaccessible disabled-only trigger.
- Placement examples render top, right, bottom, and left placements when supported.
- Accessibility examples prove `aria-describedby` or equivalent association, focus-visible trigger behavior, Escape dismissal, non-focusable tooltip content, and no interactive content inside the tooltip.
- Content examples show short nonessential copy and reject long, required, or interactive content.
- Related overlay examples clarify when to use Toggletip, Popover, Modal, helper text, and Notification instead.
- Reduced-motion expectations are visible for open/closed behavior.
- Developer examples use `x-ui.tooltip`, not placeholder comments or ad hoc markup.
- Tests assert stale scaffold labels, placeholder pending-correction copy, legacy reference sections, old tier paths, Bootstrap tooltip classes, title-only tooltip examples, and direct Carbon implementation class prefixes remain absent from rendered approved examples.
- No generic placeholder content appears.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Tooltip');
$response->assertSee('x-ui.tooltip');
$response->assertSee('Icon-only button tooltip');
$response->assertSee('Definition tooltip');
$response->assertSee('Disabled-control explanation');
$response->assertSee('placement="top"');
$response->assertSee('placement="right"');
$response->assertSee('placement="bottom"');
$response->assertSee('placement="left"');
$response->assertSee('aria-describedby');
$response->assertSee('Escape dismissal');
$response->assertSee('non-interactive');
$response->assertSee('Toggletip');
$response->assertSee('Popover');
$response->assertSee('Modal');
$response->assertSee('Do not place interactive content inside Tooltip');
$response->assertDontSee('Component-specific API ' . 'pending correction');
$response->assertDontSee('Live Examples ' . 'Card');
$response->assertDontSee('Reference ' . 'Examples');
$response->assertDontSee('Legacy Contract ' . 'Summary');
$response->assertDontSee('tier' . '-1');
$response->assertDontSee('tier' . '-2');
$response->assertDontSee('cds' . '--');
$response->assertDontSee('bx' . '--');
$response->assertDontSee('data-bs-toggle="tooltip"');
$response->assertDontSee('bootstrap-tooltip');
$response->assertDontSee('title="');
$response->assertDontSee('TODO');
$response->assertDontSee('Generic ' . 'fallback');
```

## 17. Related APIs

| API                           | Route                                                             |
| ----------------------------- | ----------------------------------------------------------------- |
| Button                        | `not installed`                        |
| Icon button                   | `not installed`                        |
| Link                          | `not installed`                          |
| Toggletip                     | `not installed`                     |
| Popover                       | `not installed`                       |
| Modal                         | `not installed`                         |
| Notification                  | `not installed`                  |
| Forms pattern                 | `not installed`                           |
| Overlay and feedback patterns | `not installed`               |
| Tables Pattern                | `not installed`                          |
| Color element                 | `not installed`                           |
| Spacing element               | `not installed`                         |
| Typography element            | `not installed`                      |
| Themes element                | `not installed`                          |
| Motion element                | `not installed`                          |
| Components overview           | `not installed`                               |
| Canonical tooltip doc         | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Ftooltip.md` |
| Carbon tooltip usage          | `https://carbondesignsystem.com/components/tooltip/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Tooltip usage, style, and accessibility guidance inform tooltip scope, icon-only and definition tooltip patterns, hover/focus behavior, Escape dismissal, and the separation between Tooltip, Toggletip, and Popover. Login App keeps its own Blade API, `ui-*` namespace, Foundation tokens, and rendered evidence proof.
