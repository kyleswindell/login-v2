---
title: Toggle
slug: toggle
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: selection-controls
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/components/toggle
canonical_doc: docs/02-standards/ui/components/toggle.md
source_owner: /platform/ui-reference/components/toggle
blade_api: []
native_api:
  - label
  - input[type="checkbox"]
  - role="switch"
javascript_api: []
source_files:
  - resources/css/app.css
  - route-owned UI Reference view for /platform/ui-reference/components/toggle
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - 2x-grid
related_components:
  - checkbox
  - radio-button
  - content-switcher
  - button
  - notification
  - inline-loading
  - tooltip
  - toggletip
related_patterns:
  - forms
  - overlays-feedback
  - tables
  - layout
carbon_reference:
  - https://carbondesignsystem.com/components/toggle/usage/
  - https://carbondesignsystem.com/components/toggle/style/
  - https://carbondesignsystem.com/components/toggle/accessibility/
  - https://carbondesignsystem.com/components/toggle/code/
---

# Toggle Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. Default immediate setting:](#42-default-immediate-setting)
  - [4.3. Disabled setting:](#43-disabled-setting)
  - [4.4. Setting with status message:](#44-setting-with-status-message)
  - [4.5. API surfaces](#45-api-surfaces)
  - [4.6. Markup and attribute contract](#46-markup-and-attribute-contract)
  - [4.7. Size contract](#47-size-contract)
  - [4.8. Label and state text contract](#48-label-and-state-text-contract)
- [5. Allowed variants, options, and modifiers](#5-allowed-variants-options-and-modifiers)
- [6. States](#6-states)
- [7. Token, class, and helper usage](#7-token-class-and-helper-usage)
  - [7.1. Foundation Elements consumed:](#71-foundation-elements-consumed)
  - [7.2. Allowed token roles](#72-allowed-token-roles)
  - [7.3. CSS namespace](#73-css-namespace)
  - [7.4. Helper ownership](#74-helper-ownership)
- [8. Composition rules](#8-composition-rules)
- [9. Selection guidance](#9-selection-guidance)
  - [9.1. Use when:](#91-use-when)
  - [9.2. Do not use when:](#92-do-not-use-when)
  - [9.3. Variant selection:](#93-variant-selection)
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
  - [11.1. Recommended label/state patterns:](#111-recommended-labelstate-patterns)
- [12. Prohibited usage](#12-prohibited-usage)
- [13. Deferred or gated capabilities](#13-deferred-or-gated-capabilities)
- [14. Implementation and UI Reference Checklist](#14-implementation-and-ui-reference-checklist)
  - [14.1. Implementation checklist](#141-implementation-checklist)
  - [14.2. UI Reference proof checklist](#142-ui-reference-proof-checklist)
- [15. UI Reference requirements](#15-ui-reference-requirements)
  - [15.1. Required Live examples internal sections:](#151-required-live-examples-internal-sections)
- [16. Testing and acceptance criteria](#16-testing-and-acceptance-criteria)
  - [16.1. Suggested automated assertions:](#161-suggested-automated-assertions)
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Toggle controls immediate on/off settings.

Canonical API owner: `/platform/ui-reference/components/toggle`. Use this Component API instead of creating local markup, styling, animation, labels, state text, ARIA behavior, or settings-control behavior for the same UI role.

Toggle is the installed Login App 2.0 binary immediate-setting API. It owns the on/off switch control, visible label association, selected/unselected state, state text where space permits, helper/status text, disabled behavior, token-backed focus treatment, reduced-motion behavior for the switch transition, and immediate-setting selection guidance. It does not own multi-select choices, mutually exclusive option groups, deferred submit workflows, view switching, destructive confirmations, permission explanations, async persistence orchestration, or page-level form layout.

### 1.1. Canonical API responsibilities:

- Render immediate binary settings through native checkbox semantics styled as a switch.
- Use `role="switch"` on the checkbox input when the implementation exposes switch semantics.
- Preserve native checked/unchecked state with the `checked` attribute.
- Keep the toggle label stable when the value changes.
- Use state text such as `On` and `Off` where space permits so meaning does not rely on color alone.
- Use helper text when users need context about what the setting changes.
- Use disabled state for unavailable settings caused by permissions, dependencies, or plan limits.
- Treat read-only toggle behavior as gated unless the implementation proves a non-editable but perceivable switch pattern without local JavaScript hacks.
- Treat warning/error messaging as helper/status composition around the control, not as custom switch colors.
- Apply setting changes immediately. If a submit button is required to apply the choice, use Checkbox, Radio button, Select, or a Forms Pattern instead.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, and 2x Grid where placement is relevant.
- Prove immediate setting, selected/unselected, focus-visible, disabled, helper text, validation/status boundary, responsive, reduced-motion, and implementation behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Independent or multi-select choices that are submitted later. Use Checkbox and Forms Pattern.
- Exactly one choice from a visible group. Use Radio button.
- Switching between peer views or content panels. Use Tabs or Content switcher.
- Opening or closing disclosure surfaces. Use Button, Accordion, Modal, Toggletip, or Menu buttons as appropriate.
- Destructive actions or irreversible state changes. Use Button plus confirmation Pattern.
- Field-level validation and form submission orchestration. Use field Components and Forms Pattern.
- Async save/persistence, optimistic updates, rollback, and failure messaging. Parent Patterns own the workflow and may compose Notification.
- External spacing, grid placement, field grouping, and page-level layout. Parent Patterns own layout.

Carbon alignment note: Carbon defines Toggle as a binary control for immediate on/off changes, distinguishes default and small sizes, expects default toggles to show label and state text, uses redundant state information so meaning is not color-only, documents focus, disabled, read-only, and skeleton states, and requires keyboard operation. Login App maps those completeness principles to native checkbox/switch markup, app-owned `ui-*` classes, Foundation tokens, and route-owned UI Reference proof rather than adopting Carbon implementation classes directly.

## 2. Status and ownership

| Field                        | Value                                                                                                 |
| ---------------------------- | ----------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                          |
| System maturity              | Partial                                                                                               |
| API layer                    | Component API                                                                                         |
| Component slug               | `toggle`                                                                                              |
| Category                     | Selection controls                                                                                    |
| Priority                     | Tier A - Baseline app development                                                                     |
| UI Reference route           | `/platform/ui-reference/components/toggle`                                                            |
| Canonical doc                | `docs/02-standards/ui/components/toggle.md`                                                           |
| Source owner                 | `/platform/ui-reference/components/toggle`                                                            |
| Blade API                    | No dedicated `x-ui.toggle` Blade component is documented as installed                                 |
| Native API                   | `<input type="checkbox" role="switch">` with associated `<label>`/text and app-owned classes          |
| JavaScript API               | No dedicated JavaScript controller required for baseline checked/unchecked behavior                   |
| Source files                 | `resources/css/app.css`; route-owned UI Reference view for `/platform/ui-reference/components/toggle` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, 2x Grid where composed in layouts                         |
| Carbon benchmark             | Carbon Toggle usage, style, code, and accessibility guidance                                          |

`Approved API` means the installed route and examples exist, but the canonical standard, UI Reference page, and tests must be corrected so Toggle is documented as an immediate binary setting control with explicit native semantics, labels, state text, states, validation/status boundaries, and prohibited usage instead of placeholder API text.

## 3. Installed standard

Toggle is represented by a native checkbox input styled as a switch and wrapped in app-owned classes. Do not invent a Blade component call unless a later accepted queue item installs and documents one.

### 3.1. The installed standard is:

- Render each toggle as one native `<input type="checkbox">` associated with one stable label.
- Add `role="switch"` when the implementation intends switch semantics instead of generic checkbox semantics.
- Use `.ui-toggle` as the required field/root class for app-owned layout, spacing, typography, state, theme, and responsive behavior.
- Use `.ui-toggle-input` on the native checkbox input.
- Use `.ui-toggle-control`, `.ui-toggle-track`, and `.ui-toggle-handle` only as visual affordance classes tied to the native input.
- Use `.ui-toggle-label` for the stable setting label.
- Use `.ui-toggle-state` for visible `On`/`Off` state text where space permits.
- Use `.ui-toggle-helper` for optional explanation.
- Use `.ui-toggle-message` with semantic modifier classes for warning/error/status copy around the control where the parent workflow requires it.
- Use `checked` to express the on state.
- Use `disabled` to express unavailable settings.
- Do not use Toggle for choices that require a submit button to apply.
- Do not change the label text when the value changes. Only the checked state and state text may change.
- Keep the control non-destructive and reversible without additional confirmation.
- Keep async saving, failure recovery, optimistic update, and rollback behavior Pattern-owned.
- Parent Patterns own grouping, external spacing, persistence, helper/error placement, and workflow orchestration.

## 4. Public API

### 4.1. Canonical calls

### 4.2. Default immediate setting:

```blade
<label class="ui-toggle" for="email-notifications">
    <span class="ui-toggle-content">
        <span class="ui-toggle-label">Email notifications</span>
        <span id="email-notifications-helper" class="ui-toggle-helper">
            Send account and security updates by email.
        </span>
    </span>

    <input
        id="email-notifications"
        class="ui-toggle-input"
        type="checkbox"
        role="switch"
        name="email_notifications"
        value="1"
        aria-describedby="email-notifications-helper"
        checked
    >

    <span class="ui-toggle-control" aria-hidden="true">
        <span class="ui-toggle-track"></span>
        <span class="ui-toggle-handle"></span>
    </span>

    <span class="ui-toggle-state" aria-hidden="true">On</span>
</label>
```

### 4.3. Disabled setting:

```blade
<label class="ui-toggle ui-toggle-disabled" for="audit-export">
    <span class="ui-toggle-content">
        <span class="ui-toggle-label">Audit export</span>
        <span id="audit-export-helper" class="ui-toggle-helper">
            This setting is managed by your workspace owner.
        </span>
    </span>

    <input
        id="audit-export"
        class="ui-toggle-input"
        type="checkbox"
        role="switch"
        name="audit_export"
        value="1"
        aria-describedby="audit-export-helper"
        disabled
    >

    <span class="ui-toggle-control" aria-hidden="true">
        <span class="ui-toggle-track"></span>
        <span class="ui-toggle-handle"></span>
    </span>

    <span class="ui-toggle-state" aria-hidden="true">Off</span>
</label>
```

### 4.4. Setting with status message:

```blade
<div class="ui-toggle-field ui-toggle-field-danger">
    <label class="ui-toggle" for="two-factor-required">
        <span class="ui-toggle-content">
            <span class="ui-toggle-label">Require two-factor authentication</span>
            <span id="two-factor-required-helper" class="ui-toggle-helper">
                Applies immediately to all active administrators.
            </span>
        </span>

        <input
            id="two-factor-required"
            class="ui-toggle-input"
            type="checkbox"
            role="switch"
            name="two_factor_required"
            value="1"
            aria-describedby="two-factor-required-helper two-factor-required-message"
        >

        <span class="ui-toggle-control" aria-hidden="true">
            <span class="ui-toggle-track"></span>
            <span class="ui-toggle-handle"></span>
        </span>

        <span class="ui-toggle-state" aria-hidden="true">Off</span>
    </label>

    <p id="two-factor-required-message" class="ui-toggle-message ui-toggle-message-danger">
        This setting could not be saved. Try again.
    </p>
</div>
```

Use the native API and `ui-toggle*` classes instead of hand-building switch tracks, custom focus rings, local state colors, or local JavaScript in feature views.

### 4.5. API surfaces

| API surface      | Installed value                                                                              |
| ---------------- | -------------------------------------------------------------------------------------------- |
| Blade component  | No dedicated `x-ui.toggle` helper is documented as installed                                 |
| Root/control API | Native `<input type="checkbox" role="switch">` associated with label text                    |
| JavaScript       | No dedicated JavaScript controller required for baseline on/off behavior                     |
| Data attributes  | No public data attributes for baseline Toggle behavior                                       |
| CSS namespace    | App-owned `ui-toggle*` classes documented by this standard and the component implementation  |
| Source owner     | `/platform/ui-reference/components/toggle`                                                   |
| Token ownership  | Foundation Color, Spacing, Typography, Themes, Motion, and 2x Grid where composed in layouts |

### 4.6. Markup and attribute contract

| API                        | Type                 | Status                       | Required                                 | Notes                                                                                                                                                                  |
| -------------------------- | -------------------- | ---------------------------- | ---------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `<input type="checkbox">`  | Native input         | Implemented                  | Required                                 | Stores checked/unchecked state.                                                                                                                                        |
| `role="switch"`            | ARIA role            | Implemented                  | required proof                           | Required for switch semantics / Do not hard-code `aria-checked`; the checked state should come from the native input unless a future JS/button implementation owns it. |
| `checked`                  | Native attribute     | Implemented                  | Optional                                 | Expresses selected/on state.                                                                                                                                           |
| `disabled`                 | Native attribute     | Implemented                  | Optional                                 | Use for unavailable settings.                                                                                                                                          |
| `name`                     | Native attribute     | Implemented                  | Required in forms                        | Needed when form submission still records the setting.                                                                                                                 |
| `value`                    | Native attribute     | Implemented                  | Required in forms                        | Use a stable value such as `1`.                                                                                                                                        |
| `aria-describedby`         | ARIA relationship    | Implemented                  | Required when helper/message text exists | Points to helper, warning, error, or status copy.                                                                                                                      |
| `.ui-toggle`               | Root class           | Implemented                  | Required                                 | Base layout and state contract.                                                                                                                                        |
| `.ui-toggle-field`         | Field wrapper        | Implemented / required proof | Optional                                 | Use when helper/error/status message sits outside the label.                                                                                                           |
| `.ui-toggle-content`       | Structural class     | Implemented / required proof | Optional                                 | Groups label and helper text.                                                                                                                                          |
| `.ui-toggle-label`         | Label text class     | Implemented                  | Required                                 | Stable setting name.                                                                                                                                                   |
| `.ui-toggle-helper`        | Helper text class    | Implemented / required proof | Optional                                 | Explains the setting’s effect.                                                                                                                                         |
| `.ui-toggle-input`         | Input class          | Implemented                  | Required                                 | Native checkbox/switch input.                                                                                                                                          |
| `.ui-toggle-control`       | Visual control class | Implemented                  | Required                                 | Visual switch container.                                                                                                                                               |
| `.ui-toggle-track`         | Visual track class   | Implemented                  | Required                                 | Visual track only; not the semantic input.                                                                                                                             |
| `.ui-toggle-handle`        | Visual handle class  | Implemented                  | Required                                 | Visual handle only; not the semantic input.                                                                                                                            |
| `.ui-toggle-state`         | State text class     | Implemented                  | required proof                           | Required for default size where space permits / Visible `On`/`Off` text. Mark `aria-hidden` because state is programmatic.                                             |
| `.ui-toggle-small`         | Size modifier        | Gated unless route proves it | Optional                                 | Compact toggle for dense inline contexts. Requires redundant state proof.                                                                                              |
| `.ui-toggle-disabled`      | State class          | Implemented                  | required proof                           | Optional / Visual companion to native `disabled`.                                                                                                                      |
| `.ui-toggle-readonly`      | State class          | Gated                        | Optional                                 | Requires a proven read-only pattern. Native checkbox does not support `readonly`.                                                                                      |
| `.ui-toggle-field-warning` | Status wrapper       | Implemented / required proof | Optional                                 | Warning copy around the control, not custom switch color alone.                                                                                                        |
| `.ui-toggle-field-danger`  | Status wrapper       | Implemented / required proof | Optional                                 | Error/status copy around the control, not custom switch color alone.                                                                                                   |
| `.ui-toggle-message`       | Message class        | Implemented / required proof | Optional                                 | Helper/error/warning/status message associated with the input.                                                                                                         |

Any class, attribute, prop, or behavior not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the UI Reference proof before use.

### 4.7. Size contract

| Size    | Status                                       | API                | Use when                                                                                                                      | Do not use when                                                                    |
| ------- | -------------------------------------------- | ------------------ | ----------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------- |
| Default | Implemented                                  | `.ui-toggle`       | Forms, settings pages, preference panels, and full-width content where visible label and state text fit.                      | Dense table rows or compact inline metadata where the label/state text cannot fit. |
| Small   | Gated unless proved by the UI Reference page | `.ui-toggle-small` | Dense inline settings where the surrounding text already labels the control and redundant state treatment is still available. | The setting is critical, ambiguous, or missing a persistent accessible label.      |

Small Toggle must not be treated as installed until the route proves size, target, redundant state, focus, disabled, and responsive behavior. If compact behavior is not installed, use the default Toggle or a Checkbox/Pattern-owned layout.

### 4.8. Label and state text contract

| Text area     | Status                       | Rule                                                                                                                                                        |
| ------------- | ---------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Label         | Implemented                  | Required and stable. Names the setting. Do not change it to indicate state.                                                                                 |
| State text    | Implemented / required proof | Use `On` and `Off` or equally clear two-state text where space permits. Mark visual state text `aria-hidden` when the input exposes state programmatically. |
| Helper text   | Implemented / required proof | Optional. Explains consequence, scope, dependency, or timing.                                                                                               |
| Warning text  | Implemented / required proof | Optional. Explain recoverable risk or dependency. Do not use color alone.                                                                                   |
| Error text    | Implemented / required proof | Optional. Explain failed save or invalid setting state. Pair with Notification for broader workflow failure.                                                |
| Dynamic label | Not allowed                  | Do not change the setting label from `Alerts` to `Alerts on` / `Alerts off`.                                                                                |

## 5. Allowed variants, options, and modifiers

| Name                      | Type                        | Status                       | API                                                                  | Notes                                                                                         |
| ------------------------- | --------------------------- | ---------------------------- | -------------------------------------------------------------------- | --------------------------------------------------------------------------------------------- |
| Default toggle            | Size/variant                | Implemented                  | `.ui-toggle`                                                         | Primary installed toggle. Shows label and state text where space permits.                     |
| Small toggle              | Size/variant                | Gated unless proved          | `.ui-toggle-small`                                                   | Compact context only; requires redundant state and accessibility proof.                       |
| Off                       | State                       | Implemented                  | unchecked input                                                      | Setting is off.                                                                               |
| On                        | State                       | Implemented                  | `checked`                                                            | Setting is on.                                                                                |
| Helper text               | Content option              | Implemented / required proof | `.ui-toggle-helper` and `aria-describedby`                           | Explains setting scope or effect.                                                             |
| Warning message           | Status composition          | Implemented / required proof | `.ui-toggle-field-warning`, `.ui-toggle-message-warning`             | Use for recoverable risk/dependency.                                                          |
| Error message             | Status composition          | Implemented / required proof | `.ui-toggle-field-danger`, `.ui-toggle-message-danger`               | Use for failed save or invalid state.                                                         |
| Disabled                  | State                       | Implemented                  | `disabled` plus `.ui-toggle-disabled`                                | Use for unavailable settings.                                                                 |
| Read-only                 | State                       | Gated                        | `.ui-toggle-readonly` only after proof                               | Native checkbox has no `readonly`; use disabled/static summary until a proven pattern exists. |
| Loading/saving            | State                       | Pattern-owned / gated        | none                                                                 | Async persistence belongs to parent Pattern; use Inline loading or Notification nearby.       |
| Grouped toggles           | Composition                 | Pattern-owned                | fieldset/list/form layout                                            | Parent Pattern owns grouping and external spacing.                                            |
| Toggle with submit button | Not allowed for Toggle role | none                         | Use Checkbox/Radio/Select and Forms Pattern when submit is required. |                                                                                               |
| Destructive toggle        | Not allowed                 | none                         | Use Button plus confirmation for destructive/irreversible actions.   |                                                                                               |
| Custom icons              | Modifier                    | Not allowed                  | none                                                                 | Toggle does not expose an icon API.                                                           |
| Custom color semantics    | Modifier                    | Not allowed                  | none                                                                 | Toggle on/off colors are owned by Color and the component implementation.                     |

## 6. States

| State                  | Status                                             | Implementation requirement                                                                                                                                                    |
| ---------------------- | -------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Default                | Implemented                                        | Renders stable label, switch input, visual control, state text where space permits, and token-backed spacing/typography.                                                      |
| Unselected/off         | Implemented                                        | Native input is unchecked and visual/state text communicates `Off`.                                                                                                           |
| Selected/on            | Implemented                                        | Native input uses `checked` and visual/state text communicates `On`.                                                                                                          |
| Hover                  | Implemented / required proof                       | Token-backed hover treatment on pointer-capable devices; must not be used as static styling.                                                                                  |
| Focus-visible          | Implemented / required proof                       | Native input shows token-backed focus-visible treatment around the switch control in supported themes.                                                                        |
| Active/pressed         | Implemented / required proof                       | Toggle handle/track may show token-backed pressed feedback while activation occurs.                                                                                           |
| Disabled               | Implemented                                        | Native `disabled`; not editable or submitted as active user input without Pattern-owned hidden value handling. Helper text should explain why when the reason is not obvious. |
| Read-only              | Gated                                              | Use only after the implementation proves non-editable switch semantics without local JavaScript hacks. Native checkbox `readonly` is not valid.                               |
| Error/danger           | Implemented as status composition / required proof | Use associated message text for failed save or invalid state. Do not rely on switch color alone.                                                                              |
| Warning                | Implemented as status composition / required proof | Use associated message text for dependency or recoverable risk. Do not rely on switch color alone.                                                                            |
| Helper text            | Implemented / required proof                       | Associated with `aria-describedby` when it adds context.                                                                                                                      |
| Group-level validation | Pattern-owned                                      | Forms Pattern owns grouped error summaries and fieldset validation. Individual toggle messages stay close to the control.                                                     |
| Loading/saving         | Pattern-owned / gated                              | Use Inline loading or Notification near the setting while an async save is pending. Do not add local spinner or fake disabled behavior inside Toggle.                         |
| Empty                  | Not applicable                                     | Do not render an unlabeled toggle. Omit the component when no setting exists.                                                                                                 |
| Expanded/collapsed     | Not applicable                                     | Toggle does not disclose content. Use Accordion, Toggletip, or Modal where disclosure is required.                                                                            |
| Open/closed            | Not applicable                                     | Toggle is not an overlay or menu trigger.                                                                                                                                     |
| Current                | Not applicable                                     | Toggle represents a setting value, not the current page or route.                                                                                                             |
| Overflow/wrapping      | Implemented / required proof                       | Long labels/helper text wrap without clipping; state text remains readable.                                                                                                   |
| Responsive             | Implemented / required proof                       | Label, control, state text, and helper text remain associated and usable in narrow containers.                                                                                |
| Reduced motion         | Implemented / required proof where motion exists   | Handle movement and state transitions must respect reduced-motion preferences.                                                                                                |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Toggle consumes Foundation Color, Spacing, Typography, Themes, Motion, and 2x Grid where composed in layouts.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- 2x Grid where toggle fields align inside forms, settings pages, cards, tables, or admin panels.

Toggle does not expose an icon API. Small-toggle redundant state may use a component-owned mark/tick only if the implementation proves it as part of the Toggle API.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                                                  |
| ----------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Label text, helper text, state text, off track, on track, handle, disabled state, warning/error message, and focus-visible treatment.                          |
| Spacing     | Label/control gap, helper/message gap, state text gap, toggle control dimensions, grouped toggle spacing when delegated by a Pattern, and responsive wrapping. |
| Typography  | Label text, state text, helper text, warning/error text, and code-snippet examples on the UI Reference page.                                                   |
| Themes      | Light/dark token resolution for label, state text, track, handle, disabled, warning/error, focus, and helper text.                                             |
| Motion      | Productive handle movement, track transition, and reduced-motion behavior where transitions exist.                                                             |
| 2x Grid     | Parent placement in form rows, settings panels, table-adjacent controls, and responsive layouts.                                                               |

### 7.3. CSS namespace

Allowed component classes should use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-toggle
.ui-toggle-field
.ui-toggle-content
.ui-toggle-label
.ui-toggle-helper
.ui-toggle-input
.ui-toggle-control
.ui-toggle-track
.ui-toggle-handle
.ui-toggle-state
.ui-toggle-small
.ui-toggle-disabled
.ui-toggle-readonly
.ui-toggle-field-warning
.ui-toggle-field-danger
.ui-toggle-message
.ui-toggle-message-warning
.ui-toggle-message-danger
```

Feature views must not create `toggle-*`, Bootstrap form-switch patterns, raw utility clusters, arbitrary on/off colors, local focus rings, local animation timing, custom icon sources, or component-local async behavior for the same UI role.

### 7.4. Helper ownership

| Helper/API             | Status                                     | Rule                                                                                                |
| ---------------------- | ------------------------------------------ | --------------------------------------------------------------------------------------------------- |
| `x-ui.toggle`          | Not installed / deferred                   | Do not call until a future Component standard installs it.                                          |
| Native checkbox switch | Implemented                                | Use as the baseline immediate setting control.                                                      |
| Checkbox Component     | Related Component                          | Use when a choice is independent, may be part of a multi-select group, or requires submit to apply. |
| Radio button Component | Related Component                          | Use when exactly one visible option must be selected.                                               |
| Content switcher       | Related Component / installed API          | Use only when switching displayed content, not changing a setting.                                  |
| Inline loading         | Related Component                          | Use near the setting when async saving needs local pending feedback.                                |
| Notification           | Related Component                          | Use for failed save, permission, or workflow-level feedback.                                        |
| Tooltip/Toggletip      | Related Component                          | Use only for supplemental explanation; do not hide required setting meaning there.                  |

## 8. Composition rules

- Use Toggle only for binary settings that apply immediately.
- Use a stable, visible label for every default toggle.
- Use visible state text where space permits.
- Keep state text separate from the label.
- Do not change the label when the state changes.
- Use helper text when the setting has scope, consequence, dependency, or timing that is not obvious.
- Use disabled state when the setting is unavailable because of permissions, subscription, dependency, or system policy.
- Explain disabled settings with helper text when the reason is not visible nearby.
- Use warning/error message composition for dependency risks, failed saves, or invalid setting states.
- Use Notification for workflow-level save failures or messages that are not directly tied to one toggle.
- Keep destructive or irreversible changes out of Toggle. Use Button plus confirmation.
- Keep asynchronous persistence, optimistic updates, retries, rollback, and polling Pattern-owned.
- Do not use Toggle for deferred-submit forms. Use Checkbox, Radio button, Select, or Dropdown with a submit Button.
- Do not use Toggle for multiple visible options. Use Radio button, Checkbox, Select, or Dropdown depending on the selection model.
- Do not use Toggle to switch views. Use Tabs or Content switcher.
- Parent Patterns own grouping, form rows, external spacing, page layout, persistence, and workflow orchestration.
- Components own internal semantics, label association, switch visuals, state styling, helper/message styling, and token-backed states.

## 9. Selection guidance

### 9.1. Use when:

- A setting has exactly two states.
- The change applies immediately after the user switches it.
- The change is reversible without confirmation.
- Users understand the consequence from the label and nearby helper text.
- The setting controls a preference, notification, feature flag, permission, display option, or system behavior that does not require a separate submit action.

### 9.2. Do not use when:

- The choice requires a submit button to apply; use Checkbox, Radio button, Select, or Forms Pattern.
- The action is destructive, irreversible, or requires confirmation; use Button plus Modal/confirmation Pattern.
- Users need to choose one option from more than two choices; use Radio button or Select.
- Users can select multiple options from a visible set; use Checkbox.
- The control switches between views or panels; use Tabs or Content switcher.
- The setting needs lengthy explanation hidden behind hover-only UI.
- The feature needs local colors, custom switch dimensions, custom icons, or custom JavaScript to work.

### 9.3. Variant selection:

| Need                               | Use                                                                         |
| ---------------------------------- | --------------------------------------------------------------------------- |
| Standard settings page or form row | Default Toggle                                                              |
| Dense inline setting               | Small Toggle only if installed/proved; otherwise default Toggle or Checkbox |
| Immediate reversible setting       | Toggle                                                                      |
| Deferred-submit preference         | Checkbox with Forms Pattern                                                 |
| One of multiple visible options    | Radio button                                                                |
| Multiple independent choices       | Checkbox                                                                    |
| View switcher                      | Tabs or Content switcher                                                    |
| Destructive state change           | Button plus confirmation                                                    |
| Save failure near one setting      | Toggle error message plus Notification if workflow-level                    |

## 10. Accessibility contract

- Use a native checkbox input for baseline Toggle behavior.
- Use `role="switch"` only when switch semantics are intended and tested.
- Every toggle must have an accessible name from a stable label.
- The label must not change when the state changes.
- The checked state must be programmatically available through the native checked state and switch role.
- Do not hard-code `aria-checked` on a native checkbox unless a future button/JavaScript switch implementation owns state synchronization.
- Default toggles should show visible state text such as `On` and `Off` where space permits.
- Visual state text should be `aria-hidden` when the native input already exposes state programmatically.
- Small toggles must provide redundant state information through a component-owned visual mark and programmatic state before they are considered installed.
- Tab moves focus to the toggle input.
- Space activates native checkbox behavior. Enter behavior must match the installed switch implementation and browser behavior; do not add local key handlers unless a future API owns them.
- Focus-visible treatment must be visible in all supported themes.
- Disabled toggles use native `disabled`.
- Read-only switch behavior is gated because native checkbox does not support `readonly`.
- Warning and error states must be communicated through associated text, not color alone.
- Helper, warning, and error text must be associated through `aria-describedby` when it changes the user’s understanding of the setting.
- Loading/saving feedback must expose pending status through text or approved loading Components, not motion alone.
- Reduced-motion preferences must be respected for switch handle/track transitions.
- The control target must remain large enough for pointer and touch use according to the app’s interaction target standard.

## 11. Content contract

- Use sentence case.
- Label text must be stable and must describe the setting, not the current state.
- Use nouns or adjective phrases for settings where possible: `Email notifications`, `Two-factor authentication`, `Public profile`.
- Use state text such as `On` | `Off`, `Enabled` | `Disabled`, or another concise pair that describes state.
- Keep state text to three words or fewer.
- Do not write labels as commands such as `Turn on email notifications` when the current state can change.
- Do not change labels to `Email notifications on` | `Email notifications off`.
- Helper text should explain consequence, scope, dependency, or timing.
- Warning text should explain recoverable risk or dependency.
- Error text should explain what failed and the next step when available.
- Avoid vague labels such as `Enabled`, `Active`, `Setting`, or `Option` without naming the affected object.
- Avoid using Toggle inside long paragraph text. Use a form/settings row so label, control, and helper text remain scannable.

### 11.1. Recommended label/state patterns:

| Setting                       | Label                                              | State text |
| ----------------------------- | -------------------------------------------------- | ---------- |
| Email notification preference | `Email notifications` / `On` / `Off`               |            |
| Security requirement          | `Require two-factor authentication` / `On` / `Off` |            |
| Profile visibility            | `Public profile` / `Enabled` / `Disabled`          |            |
| Beta feature                  | `Beta dashboard` / `On` / `Off`                    |            |
| Audit option                  | `Audit export` / `Enabled` / `Disabled`            |            |

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not create a fake `x-ui.toggle` API in feature code.
- Do not use Bootstrap `.form-switch`, `.form-check`, or feature-local `toggle-*` classes for app-owned Toggle behavior.
- Do not use direct Carbon production classes such as `cds--*` or `bx--*`.
- Do not use Toggle when a submit action is required to apply the setting.
- Do not use Toggle for more than two options.
- Do not use Toggle for destructive, irreversible, or confirmation-required actions.
- Do not use Toggle for navigation or view switching.
- Do not hide critical choices behind a dropdown when a small visible set is clearer.
- Do not hide required setting meaning inside a Tooltip or Toggletip.
- Do not change the label based on checked state.
- Do not rely on color alone for on/off, warning, error, disabled, or read-only meaning.
- Do not create custom on/off colors, dimensions, animation timing, focus rings, helper text styling, or disabled treatment.
- Do not add local click handlers or keyboard handlers for baseline checked behavior.
- Do not use read-only checkbox hacks such as inline `onclick="return false"`.
- Do not render placeholder copy such as `Component-specific API pending correction` or `Allowed variants: None` on the implemented UI Reference page.

## 13. Deferred or gated capabilities

No deferred capability blocks the installed default Toggle API. Future extensions still require an updated Component standard and UI Reference proof before production use.

| Capability                              | Status                          | Gate                                                                                                                      |
| --------------------------------------- | ------------------------------- | ------------------------------------------------------------------------------------------------------------------------- |
| Dedicated `x-ui.toggle` Blade component | Deferred unless later installed | Requires documented props, slots, native/switch output, label/helper API, state text API, accessibility proof, and tests. |
| Small Toggle                            | Gated unless already proved     | Requires size proof, target proof, state redundancy, focus/disabled/read-only proof, and responsive proof.                |
| Read-only Toggle                        | Gated                           | Requires a valid non-editable switch model, keyboard behavior, screen-reader behavior, and no inline JavaScript hacks.    |
| Async saving state                      | Pattern-owned / gated           | Requires persistence owner, pending text, rollback behavior, failed-save handling, and tests.                             |
| Group-level validation                  | Pattern-owned                   | Requires Forms Pattern ownership, fieldset/legend behavior, summary behavior, and tests.                                  |
| Toggle groups                           | Pattern-owned                   | Requires grouping, headings/legend, spacing, keyboard order, and validation/status ownership.                             |
| Custom state text pairs                 | Gated                           | Requires content rules, localization review, and UI Reference proof.                                                      |
| Icon/tickmark API                       | Gated                           | Requires Icons/Foundation proof or component-owned CSS mark, state redundancy, and accessibility proof.                   |
| Toggle as disclosure trigger            | Not owned by Toggle             | Use Button, Accordion, Toggletip, or Modal as appropriate.                                                                |
| Toggle as navigation/view switch        | Not owned by Toggle             | Use Tabs or Content switcher.                                                                                             |
| Custom colors/sizes/motion              | Not allowed                     | Requires Color, Spacing, Typography, and Motion Element updates plus UI Reference proof.                                  |

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

The Toggle page is a broad selection-control reference page. It should use matrices, comparison grids, state tables, grouped examples, responsive examples, content examples, and developer implementation examples. It does not need to force every example into the Accordion-style tab model.

### 15.1. Required Live examples internal sections:

| Required proof                | Rendered behavior                                                                                                                                   | Variants/options shown                                                                                            |
| ----------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------- |
| Basic immediate setting       | A default toggle changes a binary setting immediately and shows stable label, switch control, and state text.                                       | Off, On, Default size, Immediate behavior                                                                         |
| On/off state matrix           | Selected and unselected states render side by side with redundant state text.                                                                       | Selected/on, Unselected/off, State text                                                                           |
| Focus and interaction states  | Native input focus-visible and active/pressed treatment render using token-backed classes.                                                          | Focus-visible, Active/pressed, Hover boundary                                                                     |
| Disabled setting              | A setting is unavailable because of permissions, dependency, or plan limit and explains why.                                                        | Disabled on, Disabled off, Helper text                                                                            |
| Setting with helper text      | Optional context explains what the setting changes without hiding required meaning.                                                                 | Helper text, `aria-describedby`, Wrapping                                                                         |
| Warning/error status boundary | Warning/error messages render as associated text around the control, not as custom switch colors alone.                                             | Warning, Error, Helper/message text                                                                               |
| Read-only boundary            | If read-only is not installed, the page shows gated trigger conditions and disabled/static alternatives instead of a fake working read-only switch. | Read-only gated, Disabled alternative, Static summary alternative                                                 |
| Small toggle boundary         | If small Toggle is installed, render size comparison and redundant state proof. If not installed, show gated boundary content.                      | Default, Small gated/proved, Target size, State redundancy                                                        |
| Async save boundary           | A Pattern-owned example explains pending save/failure handling with Inline loading or Notification outside the Toggle.                              | Inline loading relationship, Notification relationship, Pattern-owned saving                                      |
| Responsive behavior           | Label, helper text, state text, and control remain associated in narrow containers.                                                                 | Wrapping, Narrow width, No clipping                                                                               |
| Reduced-motion behavior       | Switch handle/track transition documents reduced-motion behavior where motion exists.                                                               | Motion, Reduced motion                                                                                            |
| Content behavior              | Labels remain stable, state text changes, helper/error copy stays concise, and long text wraps.                                                     | Stable label, On/Off text, Long helper text                                                                       |
| Developer implementation      | Canonical native calls and class contracts render as token-backed code snippets.                                                                    | `<input type="checkbox" role="switch">`, `checked`, `disabled`, `aria-describedby`, `ui-toggle*` classes          |
| Prohibited usage proof        | The page calls out non-approved local patterns without rendering them as approved examples.                                                         | No fake `x-ui.toggle`, no Bootstrap form-switch, no direct Carbon classes, no local JS, no submit-required toggle |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered selected/unselected states, rendered focus/disabled/helper examples, status boundaries, content rules, prohibited usage, deferred gates, related API links, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/toggle` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The Component contract card includes Anatomy and States first, followed by Behavior, Developer implementation, Content guidance, and Accessibility requirements.
- The Live examples card may use matrices, comparison grids, state tables, grouped examples, and full-width sections.
- Default Toggle examples render native checkbox inputs with `role="switch"`, stable labels, and app-owned `ui-toggle*` classes.
- On/off examples render selected and unselected states with redundant state text where space permits.
- Focus-visible, active/pressed, disabled, helper text, warning/error, responsive, and reduced-motion behavior are visible.
- Disabled examples use native `disabled` and explain unavailable settings when needed.
- Read-only behavior is either rendered through an installed, accessible Component API or marked gated with approved alternatives.
- Small Toggle behavior is either rendered through an installed, accessible Component API or marked gated with proof requirements.
- Developer examples use native checkbox/switch markup and app-owned classes, not placeholder comments or ad hoc local switches.
- Selection guidance clearly distinguishes Toggle from Checkbox, Radio button, Tabs, Content switcher, Button, and Forms Pattern.
- No generic placeholder content appears.
- No direct Carbon classes, Bootstrap form-switch classes, raw utility clusters, hard-coded colors, local focus rings, local animation, or custom JavaScript are presented as approved implementation.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/toggle');

$response->assertOk();
$response->assertSee('Toggle');
$response->assertSee('ui-toggle');
$response->assertSee('ui-toggle-input');
$response->assertSee('ui-toggle-control');
$response->assertSee('ui-toggle-track');
$response->assertSee('ui-toggle-handle');
$response->assertSee('Selected/on');
$response->assertSee('Unselected/off');
$response->assertSee('Immediate setting');
$response->assertSee('Disabled setting');
$response->assertSee('Setting with helper text');
$response->assertSee('Read-only boundary');
$response->assertSee('Small toggle boundary');
$response->assertSee('Async save boundary');
$response->assertSee('aria-describedby');
$response->assertSee('role=&quot;switch&quot;', false);
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Allowed variants: None');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('Generic fallback');
$response->assertDontSee('TODO');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
$response->assertDontSee('class="form-switch');
$response->assertDontSee('class="form-check');
$response->assertDontSee('onclick="return false"');
```

For implementation tests, add page-specific assertions that rendered examples include real native checkbox/switch inputs rather than only text labels or simulated div-only switches.

## 17. Related APIs

| API                           | Route                                                            |
| ----------------------------- | ---------------------------------------------------------------- |
| Components overview           | `/platform/ui-reference/components`                              |
| Checkbox                      | `/platform/ui-reference/components/checkbox`                     |
| Radio button                  | `/platform/ui-reference/components/radio-button`                 |
| Content switcher              | `/platform/ui-reference/components/content-switcher`             |
| Button                        | `/platform/ui-reference/components/button`                       |
| Notification                  | `/platform/ui-reference/components/notification`                 |
| Inline loading                | `/platform/ui-reference/components/inline-loading`               |
| Tooltip                       | `/platform/ui-reference/components/tooltip`                      |
| Toggletip                     | `/platform/ui-reference/components/toggletip`                    |
| Forms pattern                 | `/platform/ui-reference/patterns/forms`                          |
| Overlay and feedback patterns | `/platform/ui-reference/patterns/overlays-feedback`              |
| Tables Pattern                | `/platform/ui-reference/patterns/tables`                         |
| Layout Pattern                | `/platform/ui-reference/patterns/layout`                         |
| Color element                 | `/platform/ui-reference/elements/color`                          |
| Spacing element               | `/platform/ui-reference/elements/spacing`                        |
| Typography element            | `/platform/ui-reference/elements/typography`                     |
| Motion element                | `/platform/ui-reference/elements/motion`                         |
| Themes element                | `/platform/ui-reference/elements/themes`                         |
| 2x Grid element               | `/platform/ui-reference/elements/2x-grid`                        |
| Canonical toggle doc          | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Ftoggle.md` |
| Carbon toggle usage           | `https://carbondesignsystem.com/components/toggle/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Toggle usage, style, code, and accessibility guidance inform immediate binary-setting usage, default/small size boundaries, label/state text anatomy, focus/disabled/read-only/skeleton considerations, redundant state information, and keyboard/accessibility expectations. Login App keeps its own native markup contract, app-owned `ui-*` class namespace, Foundation Element token model, route ownership, and UI Reference proof requirements.
