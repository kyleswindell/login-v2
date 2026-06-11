---
title: Text input
slug: text-input
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: inputs
priority: tier-a-baseline-app-development
ui_reference_route: /platform/ui-reference/components/text-input
canonical_doc: docs/02-standards/ui/components/text-input.md
source_owner: /platform/ui-reference/components/text-input
blade_api:
  - native input[type="text"] composed with app-owned ui-* field and text-input classes
  - native input[type="email"] composed with app-owned ui-* field and text-input classes
  - native input[type="password"] composed with app-owned ui-* field and text-input classes
  - native input[type="search"] composed with app-owned ui-* field and text-input classes
javascript_api: []
data_attributes: []
source_files:
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
related_components:
  - textarea
  - select
  - checkbox
  - radio-button
  - button
  - inline-loading
  - notification
related_patterns:
  - forms
  - overlays-feedback
carbon_reference:
  - https://carbondesignsystem.com/components/text-input/usage/
  - https://carbondesignsystem.com/components/text-input/style/
  - https://carbondesignsystem.com/components/text-input/accessibility/
  - https://carbondesignsystem.com/patterns/forms-pattern/
---

# Text input Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
  - [3.1. The installed standard is:](#31-the-installed-standard-is)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Native field option contract](#43-native-field-option-contract)
  - [4.4. Input type contract](#44-input-type-contract)
  - [4.5. Installed state class contract](#45-installed-state-class-contract)
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

Single-line free-entry text fields capture short user-provided values.

Canonical API owner: `/platform/ui-reference/components/text-input`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Text input is the installed Login App 2.0 single-line free-entry field API. It owns native input composition, labels, helper copy, validation messaging, disabled and read-only states, browser autocomplete guidance, field type selection, token-backed field states, and UI Reference proof for login, settings, validation, read-only, and disabled field examples. It does not own multi-line text entry, formatted rich text, select/dropdown choice behavior, password reveal controls, search result behavior, masked inputs, date/time pickers, number steppers, or form layout.

### 1.1. Canonical API responsibilities:

- Render short free-entry fields through native `<input>` elements composed with app-owned `ui-*` field classes.
- Preserve a visible label and accessible name for every input.
- Support common single-line types: `text`, `email`, `password`, `search`, `url`, `tel`, and simple numeric string values where a number-stepper is not required.
- Expose helper, error, warning, loading/status, and requirement copy through stable IDs and `aria-describedby`.
- Represent validation through wrapper state classes, message IDs, and `aria-invalid` only for blocking errors.
- Support disabled and read-only behavior through native attributes and token-backed state classes.
- Use browser-native keyboard, selection, focus, editing, autocomplete, and input semantics.
- Consume Foundation Element APIs for color, spacing, typography, themes, and motion.
- Prove installed form-field behavior on the UI Reference page.

### 1.2. Non-owned responsibilities:

- Form grouping, submit/cancel placement, fieldset layout, grid alignment, and workflow orchestration. Use the Forms Pattern.
- Multi-line content. Use Textarea.
- Known-list choices. Use Select, Radio button, Checkbox, Toggle, or a future Combobox/Autocomplete API when installed.
- Password reveal behavior, input masking, prefix/suffix adornments, inline actions, async validation, or search suggestions unless those capabilities are separately implemented and proven.
- Server-side validation rules, request objects, model casting, or controller behavior.

## 2. Status and ownership

| Field                        | Value                                                                                                        |
| ---------------------------- | ------------------------------------------------------------------------------------------------------------ |
| Status                       | Approved API                                                                                                 |
| System maturity              | Partial                                                                                                      |
| API layer                    | Component API                                                                                                |
| Component slug               | `text-input`                                                                                                 |
| Category                     | Inputs                                                                                                       |
| Priority                     | Tier A - Baseline app development                                                                            |
| UI Reference route           | `/platform/ui-reference/components/text-input`                                                               |
| Canonical doc                | `docs/02-standards/ui/components/text-input.md`                                                              |
| Source owner                 | `/platform/ui-reference/components/text-input`                                                               |
| Blade API                    | Native `<input>` composed with app-owned `ui-*` field and text-input classes                                 |
| Dedicated Blade component    | Not public until `x-ui.text-input` is implemented, documented, and proven                                    |
| JavaScript API               | None required for installed single-line input behavior                                                       |
| Data attributes              | None required for installed behavior                                                                         |
| Source files                 | `resources/css/app.css`; UI Reference implementation owned by `/platform/ui-reference/components/text-input` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion                                                                   |
| Carbon benchmark             | Carbon Text input usage, style, accessibility, and Forms guidance                                            |

`Approved API` means the UI Reference route and component-specific examples exist, but the canonical document must replace placeholder API text with the installed native-input contract, explicit state rules, and deferred enhanced-input gates.

## 3. Installed standard

Text input is installed as a native-input field composition. The approved production API is native Blade markup using the app field class contract and text-input class namespace. A dedicated `<x-ui.text-input>` component is not public until it is implemented and documented as a follow-up API.

### 3.1. The installed standard is:

- Use a native `<input>` for single-line free-entry values.
- Wrap the input in `.ui-field.ui-text-input-field`.
- Use a visible `<label>` associated with the input through `for` and `id`.
- Use `.ui-field-helper` for short instruction, format, requirement, or constraint copy.
- Use `.ui-text-input` on the native input.
- Use the most specific native input `type` available for the value being collected.
- Use `autocomplete` intentionally for login, account, contact, and browser-fillable fields.
- Use `required`, `minlength`, `maxlength`, `pattern`, `inputmode`, and similar native attributes only when they match server-side validation.
- Use `readonly` only when the value should remain selectable/copyable but not editable.
- Use `disabled` only when the value is unavailable and should not submit with the form.
- Represent blocking validation through `.ui-field-error`, `aria-invalid="true"`, and a message ID referenced by `aria-describedby`.
- Represent warning guidance through `.ui-field-warning` and a warning message ID without `aria-invalid`.
- Represent loading/pending validation with `.ui-field-loading`, `aria-busy="true"`, status copy, and disabled or read-only behavior when interaction must pause.
- Do not rely on placeholder text as the label.
- Do not create custom field chrome when the native input satisfies the workflow.

Carbon alignment note: Carbon documents text input as a fixed-height free-form field for short entries, emphasizes labels and helper text, surfaces helper and error text programmatically, uses sentence case for labels and field text, and separates text input from broader form and selection-control patterns. Login App maps that guidance to native Blade markup, app-owned `ui-*` classes, Laravel validation expectations, and UI Reference proof instead of adopting Carbon implementation classes directly.

## 4. Public API

### 4.1. Canonical calls

Use native Blade markup with the installed field and text-input class contract.

```blade
<div class="ui-field ui-text-input-field">
    <label class="ui-field-label" for="email">
        Email address
    </label>

    <input
        id="email"
        name="email"
        type="email"
        class="ui-text-input"
        value="{{ old('email') }}"
        autocomplete="email"
        required
    >
</div>
```

```blade
<div class="ui-field ui-text-input-field">
    <label class="ui-field-label" for="tenant-name">
        Tenant name
    </label>

    <p class="ui-field-helper" id="tenant-name-helper">
        Use the legal or customer-facing tenant name.
    </p>

    <input
        id="tenant-name"
        name="tenant_name"
        type="text"
        class="ui-text-input"
        value="{{ old('tenant_name', $tenant->name ?? '') }}"
        maxlength="120"
        aria-describedby="tenant-name-helper"
    >
</div>
```

```blade
<div class="ui-field ui-text-input-field ui-field-error">
    <label class="ui-field-label" for="username">
        Username
    </label>

    <p class="ui-field-helper" id="username-helper">
        Use 4 to 40 letters, numbers, dashes, or underscores.
    </p>

    <input
        id="username"
        name="username"
        type="text"
        class="ui-text-input"
        value="{{ old('username') }}"
        autocomplete="username"
        aria-describedby="username-helper username-error"
        aria-invalid="true"
    >

    <p class="ui-field-error-message" id="username-error">
        Enter a username from 4 to 40 characters.
    </p>
</div>
```

```blade
<div class="ui-field ui-text-input-field ui-field-readonly">
    <label class="ui-field-label" for="account-id">
        Account ID
    </label>

    <input
        id="account-id"
        name="account_id"
        type="text"
        class="ui-text-input"
        value="{{ $account->public_id }}"
        readonly
    >
</div>
```

Use this native API instead of hand-building local field markup in feature views.

### 4.2. API surfaces

| API surface               | Installed value                                                                                                  |
| ------------------------- | ---------------------------------------------------------------------------------------------------------------- |
| Blade API                 | Native `<input>` composed with app-owned `ui-*` field and text-input classes                                     |
| Dedicated Blade component | Not installed as public API. Do not call `<x-ui.text-input>` until that component is implemented and documented. |
| JavaScript                | No dedicated JavaScript controller required for installed single-line input behavior                             |
| Root semantic element     | Native `<input>` inside an app field wrapper                                                                     |
| Data attributes           | None required for installed behavior. Feature views must not invent data attributes for text-input behavior.     |
| CSS namespace             | App-owned `ui-*` classes documented in this standard                                                             |
| Source files              | `resources/css/app.css`; UI Reference owner route `/platform/ui-reference/components/text-input`                 |

### 4.3. Native field option contract

| Option/attribute   | Type              | Default         | Allowed values                                                | Required                                      | Notes                                                                      |
| ------------------ | ----------------- | --------------- | ------------------------------------------------------------- | --------------------------------------------- | -------------------------------------------------------------------------- |
| `id`               | `string`          | none            | Unique DOM ID                                                 | Yes                                           | Must match the visible label `for` attribute.                              |
| `name`             | `string`          | none            | Laravel field name                                            | Yes                                           | Must match server request validation keys.                                 |
| `type`             | `string`          | `text`          | `text`, `email`, `password`, `search`, `url`, `tel`           | Yes                                           | Use the most specific native type that fits the workflow.                  |
| Visible label      | text/HTML         | none            | Short concrete label                                          | Yes                                           | Do not replace the label with placeholder text.                            |
| `value`            | `string / null`   | empty           | Escaped old/model value                                       | No                                            | Use `old()` with model fallback for Laravel forms.                         |
| `placeholder`      | `string / null`   | none            | Example value only                                            | No                                            | Placeholder may supplement but never replace the label or helper.          |
| Helper text        | text/HTML         | none            | Short instruction copy                                        | No                                            | Strongly recommended when format, limits, or requirements are not obvious. |
| `autocomplete`     | `string / null`   | browser default | Valid browser autocomplete tokens                             | No                                            | Use intentionally for login, contact, account, and address values.         |
| `required`         | boolean attribute | omitted         | present/omitted                                               | No                                            | Must match server-side required validation.                                |
| `readonly`         | boolean attribute | omitted         | present/omitted                                               | No                                            | Value remains focusable/selectable and submits with the form.              |
| `disabled`         | boolean attribute | omitted         | present/omitted                                               | No                                            | Value is unavailable, not editable, and not submitted.                     |
| `maxlength`        | integer/null      | none            | Positive integer                                              | No                                            | Must match server-side max validation.                                     |
| `minlength`        | integer/null      | none            | Positive integer                                              | No                                            | Must match server-side min validation.                                     |
| `pattern`          | `string / null`   | none            | Valid HTML pattern                                            | No                                            | Use sparingly and only when helper/error copy explains the format.         |
| `inputmode`        | `string / null`   | browser default | `text`, `email`, `url`, `tel`, `numeric`, `decimal`, `search` | No                                            | Use to improve mobile keyboard behavior.                                   |
| `aria-describedby` | `string / null`   | none            | Space-separated IDs                                           | Required when helper/status/error text exists | Reference helper, warning, error, and status copy.                         |
| `aria-invalid`     | `true             | null`           | omitted                                                       | `true` when invalid                           | Required for blocking errors                                               | Do not set for warnings.       |
| `aria-busy`        | `true             | null`           | omitted                                                       | `true` on wrapper while pending               | Required for loading/pending validation state                              | Pair with visible status copy. |

Any option not listed here is not public as a component-specific convention. Native browser attributes may be used only when they are semantically correct, match server validation, and do not create a custom component behavior.

### 4.4. Input type contract

| Type                                      | Status                             | Use when                                                                         | Do not use when                                                                              |
| ----------------------------------------- | ---------------------------------- | -------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------- |
| `text`                                    | Implemented                        | General short free-entry strings such as names, titles, IDs, and labels          | The browser has a more specific type that improves validation or keyboard behavior.          |
| `email`                                   | Implemented                        | Email address fields                                                             | The value can contain multiple arbitrary contacts or complex chips.                          |
| `password`                                | Implemented                        | Password entry with browser-native obscuring                                     | A reveal toggle or generated-password workflow is required; that behavior is deferred.       |
| `search`                                  | Implemented for plain search entry | The field captures a simple query string                                         | Search suggestions, async results, or command palettes are needed.                           |
| `url`                                     | Implemented                        | Single URL values                                                                | Multiple URLs, rich validation, previews, or remote fetch behavior is needed.                |
| `tel`                                     | Implemented                        | Phone-like values where numeric formatting varies                                | A masked phone input is required. Masking is deferred.                                       |
| Numeric string with `inputmode="numeric"` | Implemented                        | IDs, ZIP/postal codes, or values where leading zeroes matter                     | Mathematical numbers, min/max stepping, or increment/decrement controls are needed.          |
| `number`                                  | Gated                              | Only when native number semantics and browser controls are intentionally desired | IDs, ZIP codes, account numbers, currency, or values where native spinner behavior is wrong. |
| `date`, `time`, `datetime-local`          | Deferred                           | Use future Date/time input standard when installed                               | Do not treat as Text input.                                                                  |
| Hidden input                              | Not this component                 | Use native hidden fields only for form state                                     | Hidden fields are not UI components.                                                         |

### 4.5. Installed state class contract

| Class                       | Status      | Purpose                                                  |
| --------------------------- | ----------- | -------------------------------------------------------- |
| `.ui-field`                 | Implemented | App field wrapper shared by input components.            |
| `.ui-text-input-field`      | Implemented | Root text-input field namespace.                         |
| `.ui-field-label`           | Implemented | Visible label text.                                      |
| `.ui-field-helper`          | Implemented | Helper and format copy.                                  |
| `.ui-text-input`            | Implemented | Native input styling hook.                               |
| `.ui-field-error`           | Implemented | Blocking validation state on the wrapper.                |
| `.ui-field-error-message`   | Implemented | Error copy referenced by `aria-describedby`.             |
| `.ui-field-warning`         | Implemented | Non-blocking warning state on the wrapper.               |
| `.ui-field-warning-message` | Implemented | Warning copy referenced by `aria-describedby`.           |
| `.ui-field-disabled`        | Implemented | Optional wrapper class when the input is disabled.       |
| `.ui-field-readonly`        | Implemented | Read-only state treatment.                               |
| `.ui-field-loading`         | Implemented | Pending validation or pending server work state.         |
| `.ui-field-status`          | Implemented | Loading or status copy referenced by `aria-describedby`. |

## 5. Allowed variants, options, and modifiers

| Name                            | Type               | Status                   | API                                                  | Notes                                                                               |
| ------------------------------- | ------------------ | ------------------------ | ---------------------------------------------------- | ----------------------------------------------------------------------------------- |
| Basic text field                | Variant            | Implemented              | `type="text"`                                        | Default short free-entry field.                                                     |
| Email field                     | Type variant       | Implemented              | `type="email"`                                       | Use browser-native email semantics and autocomplete.                                |
| Password field                  | Type variant       | Implemented              | `type="password"`                                    | Native obscured text only; reveal toggle is deferred.                               |
| Search field                    | Type variant       | Implemented              | `type="search"`                                      | Plain query entry only. Suggestions are deferred.                                   |
| URL field                       | Type variant       | Implemented              | `type="url"`                                         | Single URL entry.                                                                   |
| Telephone field                 | Type variant       | Implemented              | `type="tel"`                                         | Phone-like strings. Masking is deferred.                                            |
| Helper text                     | Composition        | Implemented              | `.ui-field-helper` and `aria-describedby`            | Use for format, limits, and requirement context.                                    |
| Required                        | Option/state       | Implemented              | `required` plus label/helper/error copy              | Must match server validation.                                                       |
| Min/max length                  | Option             | Implemented              | `minlength`, `maxlength`                             | Must match server validation.                                                       |
| Pattern hint                    | Option             | Implemented with caution | `pattern` plus helper/error copy                     | Use only for simple formats.                                                        |
| Autocomplete                    | Option             | Implemented              | `autocomplete="..."`                                 | Use intentionally for browser-fillable fields.                                      |
| Input mode                      | Option             | Implemented              | `inputmode="..."`                                    | Improves mobile keyboard behavior.                                                  |
| Error validation                | State              | Implemented              | `.ui-field-error`, message ID, `aria-invalid="true"` | Blocking invalid state.                                                             |
| Warning validation              | State              | Implemented              | `.ui-field-warning`, warning message ID              | Non-blocking guidance. Do not set `aria-invalid`.                                   |
| Disabled                        | State              | Implemented              | `disabled` and optional `.ui-field-disabled`         | Unavailable and not submitted.                                                      |
| Read-only                       | State              | Implemented              | `readonly` and `.ui-field-readonly`                  | Copyable, focusable, and submitted.                                                 |
| Loading/pending                 | State              | Implemented              | `.ui-field-loading`, `aria-busy="true"`, status copy | Use for pending server validation or availability checks.                           |
| Inline icon                     | Modifier           | Deferred                 | none                                                 | Requires icon placement, label, contrast, and accessibility proof.                  |
| Prefix/suffix text              | Modifier           | Deferred                 | none                                                 | Requires adornment semantics and layout proof.                                      |
| Clear button                    | Modifier           | Deferred                 | none                                                 | Requires Button integration and keyboard/focus behavior.                            |
| Password reveal                 | Modifier           | Deferred                 | none                                                 | Requires Button integration, state announcements, and security guidance.            |
| Character counter               | Modifier           | Deferred                 | none                                                 | Requires counter semantics, warning/error rules, and UI Reference proof.            |
| Masked input                    | Modifier           | Deferred                 | none                                                 | Requires formatting rules, paste behavior, error handling, and accessibility proof. |
| Async validation indicator      | Modifier           | Deferred                 | none                                                 | Requires Inline loading/Notification integration and server-client contract.        |
| Search suggestions/autocomplete | Modifier           | Deferred                 | none                                                 | Use future Combobox/Search Pattern when installed.                                  |
| Multi-line text                 | Not this component | `textarea`               | Use Textarea.                                        |                                                                                     |
| Custom field chrome             | Not allowed        | none                     | Native control satisfies the installed workflow.     |                                                                                     |

## 6. States

| State              | Status                                     | Implementation requirement                                                                           |
| ------------------ | ------------------------------------------ | ---------------------------------------------------------------------------------------------------- |
| Default            | Implemented                                | Renders visible label and native input with approved type and class.                                 |
| Filled             | Implemented                                | Input contains a value; styling remains token-backed and does not depend on placeholder tricks.      |
| Empty              | Implemented                                | Empty value remains labeled and scannable. Placeholder is optional only.                             |
| Hover-capable      | Implemented                                | Token-backed hover treatment where pointer hover is supported.                                       |
| Focus-visible      | Implemented                                | Native input receives visible focus in all supported themes.                                         |
| Active/editing     | Implemented                                | Browser-native caret, selection, copy, paste, undo, and text editing remain available.               |
| Helper             | Implemented                                | Helper copy is visible and referenced by `aria-describedby`.                                         |
| Error              | Implemented                                | Blocking error uses `.ui-field-error`, `aria-invalid="true"`, and an error message ID.               |
| Warning            | Implemented                                | Non-blocking warning uses `.ui-field-warning` and warning message ID without `aria-invalid`.         |
| Disabled           | Implemented                                | Native `disabled` prevents editing and excludes the value from form submission.                      |
| Read-only          | Implemented                                | Native `readonly` prevents editing but allows focus, selection, copy, and form submission.           |
| Loading/pending    | Implemented                                | Wrapper uses `aria-busy="true"`, visible status copy, and interaction is paused only when needed.    |
| Required           | Implemented                                | Native `required` and copy/validation align with server rules.                                       |
| Optional           | Implemented                                | Optional status may be described in helper copy when surrounding form context is ambiguous.          |
| Overflow/truncated | Implemented by browser text field behavior | Long values scroll horizontally within the input; do not replace with custom truncation.             |
| Success            | Not public as a field state                | Use field value, helper/status copy, or Notification when a workflow needs success feedback.         |
| Skeleton           | Not applicable                             | Use Skeleton/Loading component or Pattern-owned loading state before the form renders.               |
| Selected           | Not applicable                             | Text selection is browser-native; selected field state belongs to choices such as Select/Radio/Tabs. |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Text input consumes Foundation Color, Spacing, Typography, Themes, and Motion.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.

2x Grid is parent-owned when fields are placed in forms, cards, settings pages, or modal layouts. Text input does not define page-level grid placement by itself.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                                   |
| ----------- | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Field text, label, helper, border, background, placeholder, focus, disabled, read-only, warning, error, and loading/status roles.               |
| Spacing     | Label/helper/input/message stack gaps, input padding, and internal field rhythm.                                                                |
| Typography  | Label, input value, placeholder, helper, warning, error, and status text.                                                                       |
| Themes      | Light and dark token resolution for default, hover, focus, disabled, read-only, warning, error, and loading states.                             |
| Motion      | Productive state transitions for focus, hover, validation, and loading/status changes where installed; must respect reduced-motion preferences. |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$field`, `$field-hover` | Field background and hover field background | `ui-field`, `ui-input`, `--ui-field`, `--ui-field-hover` | App field palette | Same role / app value | Shared with Select, Dropdown, Search, Date picker, Number input, and Textarea. |
| `$border-strong`, `$border-subtle` | Default border-bottom and read-only border-bottom | `ui-input`, field border aliases | App border palette | Same role / app value | Do not create local input border colors. |
| `$text-primary`, `$text-secondary`, `$text-helper`, `$text-placeholder`, `$text-disabled` | Input value, label, helper, placeholder, and disabled text | `ui-field-*`, `ui-input` text roles | App text palette | Same role / app value | Text hierarchy stays Color/Typography-owned. |
| `$support-error`, `$text-error`, `$support-warning` | Invalid border/icon, error message, warning icon/message | Field validation state classes | App status palette | Same role / app value | Validation must include non-color cues and message text. |
| `$focus` | Focus field border/ring | `ui-input:focus-visible`, `--ui-focus` | App focus palette | Same role / app value | Focus is shared Color Element ownership. |
| `$icon-primary` | Password visibility icon | Password input icon role when installed | App icon palette | Same role / app value | Icons inherit through component classes; no local icon color utilities. |
| `$ai-border-strong`, `$ai-aura-start-sm`, `$ai-aura-stop` | AI text field presence | No general text-input role until AI variant is approved | None | Not adopted | AI tokens remain gated and must not leak into baseline fields. |

### 7.3. CSS namespace

Allowed component classes use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-field
.ui-field-label
.ui-field-helper
.ui-field-error
.ui-field-error-message
.ui-field-warning
.ui-field-warning-message
.ui-field-disabled
.ui-field-readonly
.ui-field-loading
.ui-field-status
.ui-text-input-field
.ui-text-input
```

Feature views must not create local `text-input-*`, `input-*`, Bootstrap `.form-control` examples, raw utility clusters, arbitrary hex colors, arbitrary spacing, custom focus rings, local icon adornments, or component-local JavaScript for the same UI role.

## 8. Composition rules

- Text input must be composed as a field, not as an unlabeled standalone control.
- The input ID and visible label `for` value must match.
- Helper, warning, error, and status copy must use stable IDs referenced by `aria-describedby`.
- Use the most specific native input type available.
- Use native attributes only when they match server validation.
- Preserve browser-native editing behavior: focus, caret movement, selection, copy, paste, undo, autocomplete, and validation affordances.
- Placeholder text may show an example format, but it must never be the only label or the only instruction.
- Disabled fields are unavailable and do not submit values.
- Read-only fields remain copyable and submit values.
- Use warning copy for non-blocking concerns and error copy for blocking validation.
- Do not put action buttons, icons, counters, reveal toggles, or async indicators inside the field unless the capability is installed as part of this Component API.
- Parent Forms Patterns own field grouping, required/optional policy, layout columns, submit/cancel placement, external spacing, and workflow orchestration.
- Components own internal field semantics, label/helper/error associations, field styling, and token-backed states.

## 9. Selection guidance

### 9.1. Use when:

- A user needs to enter a short single-line free-form value.
- The value is best represented as letters, numbers, symbols, email, password, URL, phone-like text, or a simple query.
- The field needs label, helper, validation, disabled, read-only, or loading/pending state treatment.
- Browser-native keyboard, autocomplete, editing, and validation behavior are sufficient.

### 9.2. Do not use when:

- The value requires multiple lines. Use Textarea.
- The user must choose from a known list. Use Select, Radio button, Checkbox, or Toggle.
- The user needs search suggestions or autocomplete options. Use a future Combobox/Search Pattern when installed.
- The field needs tags/chips, multi-value entry, masked formatting, counters, prefix/suffix adornments, inline actions, or async validation UI that is not yet installed.
- The value is a date/time, file, color, slider/range, or rich-text value.
- The workflow is purely display-only and does not need copyable form-field behavior. Use a data display component or read-only summary pattern.

### 9.3. Selection matrix:

| Need                                   | Use                                                 |
| -------------------------------------- | --------------------------------------------------- |
| Name, title, label, ID, short note     | Text input `type="text"`                            |
| Email address                          | Text input `type="email"`                           |
| Password                               | Text input `type="password"`                        |
| Plain query without suggestions        | Text input `type="search"`                          |
| Single URL                             | Text input `type="url"`                             |
| Phone-like value                       | Text input `type="tel"`                             |
| ZIP/account number with leading zeroes | Text input `type="text"` plus `inputmode="numeric"` |
| Multi-line message                     | Textarea                                            |
| Known list of options                  | Select or Radio button                              |
| Boolean value                          | Checkbox or Toggle                                  |
| Search with suggestions/results        | Future Combobox/Search Pattern                      |

## 10. Accessibility contract

- Use a native `<input>` element for installed text input behavior.
- Provide a visible label for every input.
- Associate the label with the input using `for` and `id`.
- Do not rely on placeholder text as the label.
- Expose helper, warning, error, and loading/status copy through `aria-describedby`.
- Use `aria-invalid="true"` only when the current value is invalid and blocks submission.
- Error messages must give enough guidance for the user to correct the value.
- Disabled inputs must use the native `disabled` attribute.
- Read-only inputs must use the native `readonly` attribute and should remain focusable/selectable when the value may need to be copied.
- Loading/pending validation must expose visible status copy and should not prevent typing unless the operation requires it.
- Focus-visible treatment must be visible in all supported themes.
- Meaning must not rely on color alone for error, warning, disabled, read-only, or loading states.
- Browser-native keyboard behavior must remain intact.
- If `pattern`, `minlength`, `maxlength`, or specific formatting is required, helper or error copy must describe the expected format.
- Password fields must allow browser password manager behavior unless a security requirement explicitly prevents it.
- Icon-only or inline action affordances are not part of the installed API and must not be added locally.

## 11. Content contract

- Use sentence case.
- Use concrete labels that describe the requested value: `Email address`, `Username`, `Tenant name`, `Account ID`.
- Keep labels short. Prefer one to three words where possible.
- Use helper text for format, limits, required context, and timing constraints when they are not obvious.
- Use placeholder text only as an example, such as `name@example.com`, not as instruction text.
- Error messages must be specific and actionable: `Enter a valid email address.`
- Warning messages must explain risk or next step without implying the field is invalid.
- Avoid vague labels such as `Value`, `Info`, `Data`, `Input`, or `Text`.
- Do not put long instructions in labels.
- Avoid repeating the same noun in every field in a grouped form when the group heading already provides the context.
- Keep helper, warning, error, and status copy short enough to scan.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, custom focus rings, or custom JavaScript.
- Do not create feature-local text input systems for the same UI role.
- Do not use Bootstrap `.form-control` examples or direct Carbon production classes in app markup.
- Do not rely on placeholder text as the only label.
- Do not use custom field chrome when the native control satisfies the workflow.
- Do not use `type="number"` for IDs, ZIP codes, account numbers, or values where leading zeroes matter.
- Do not set `aria-invalid` for warnings.
- Do not use disabled when read-only is the correct state and the value still needs to submit.
- Do not use read-only when the value is unavailable or should not submit.
- Do not add inline icons, prefix/suffix adornments, clear buttons, password reveal buttons, character counters, masks, or async validation spinners locally.
- Do not truncate field labels, helper text, or validation copy as a substitute for concise content.
- Do not use Text input for multi-line content, known-list choices, tabs, menus, file upload, rich text, or progress/loading display.

## 13. Deferred or gated capabilities

| Capability                        | Status      | Gate                                                                                                         |
| --------------------------------- | ----------- | ------------------------------------------------------------------------------------------------------------ |
| `x-ui.text-input` Blade component | Deferred    | Requires source implementation, prop contract, accessibility review, UI Reference proof, and tests.          |
| Inline icon/adornment             | Deferred    | Requires icon placement, contrast, assistive technology behavior, RTL behavior, and UI Reference proof.      |
| Prefix/suffix text                | Deferred    | Requires semantic rules, spacing rules, validation behavior, and responsive proof.                           |
| Clear button                      | Deferred    | Requires Button integration, keyboard behavior, accessible name, focus recovery, and tests.                  |
| Password reveal                   | Deferred    | Requires Button integration, security guidance, state announcements, and UI Reference proof.                 |
| Character counter                 | Deferred    | Requires max-length policy, warning/error thresholds, live-region behavior, and tests.                       |
| Masked input                      | Deferred    | Requires paste/editing behavior, undo behavior, validation parity, localization, and accessibility proof.    |
| Async availability/validation     | Deferred    | Requires request lifecycle, Inline loading integration, status/error copy, cancellation behavior, and tests. |
| Search suggestions/autocomplete   | Deferred    | Requires Combobox/Search Pattern ownership, keyboard behavior, result semantics, and UI Reference proof.     |
| Date/time fields                  | Deferred    | Requires Date/time input standard. Do not treat as Text input.                                               |
| Additional size variants          | Not public  | Requires Spacing, Typography, Forms Pattern, and UI Reference updates.                                       |
| Custom field chrome               | Not allowed | Native input is the installed API.                                                                           |

Future extensions require an updated Component standard and UI Reference proof before production use.

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

The Text input page is a broad field reference page. The Live examples card may use grouped examples, state tables, validation examples, form rows, and implementation examples. It must not render fake controls for deferred enhanced-input capabilities.

### 15.1. Required Live examples internal sections:

| Required proof           | Rendered behavior                                                                                                                                       | Variants/options shown                                                                             |
| ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------- |
| Login form field         | Login fields render with visible labels, browser autocomplete, required behavior, and production field classes.                                         | Email, Password, Required, Autocomplete, Focus-visible                                             |
| Settings form field      | Settings fields render model-backed values, helper text, and common text types.                                                                         | Text, Email, URL, Telephone, Helper text, Max length                                               |
| Validation field         | Error and warning examples render with proper message IDs and `aria-describedby`; blocking errors include `aria-invalid="true"`.                        | Error, Warning, Helper text, Required, Pattern/format guidance                                     |
| Read-only field          | Read-only value remains selectable/copyable and uses native `readonly`.                                                                                 | Read-only, Focus-visible, Submitted value behavior                                                 |
| Disabled field           | Disabled value renders unavailable and uses native `disabled`.                                                                                          | Disabled, Helper text, Non-submitted behavior                                                      |
| Pending field            | Pending validation or server work shows status copy and busy state without inventing async behavior.                                                    | Loading/pending, `aria-busy`, Status text                                                          |
| Type matrix              | Supported native types render as separate examples with correct labels and autocomplete/inputmode where appropriate.                                    | Text, Email, Password, Search, URL, Tel, Numeric inputmode                                         |
| State matrix             | Production examples render each approved field state using token-backed classes.                                                                        | Default, Filled, Empty, Hover, Focus-visible, Error, Warning, Disabled, Read-only, Loading/pending |
| Developer implementation | Canonical native Blade markup and option tables render as real code examples.                                                                           | Native input, `ui-*` classes, documented attributes                                                |
| Deferred capabilities    | Page shows enhanced-input gates instead of fake clear buttons, masks, counters, password reveal, or suggestions.                                        | Deferred gates, approved alternatives                                                              |
| Prohibited usage         | Page shows forbidden placeholder-only labels, local JavaScript, custom field chrome, direct Carbon classes, and Bootstrap field classes as not allowed. | Prohibited examples and alternatives                                                               |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered states, rendered type variants, prohibited usage, deferred gates, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `/platform/ui-reference/components/text-input` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- Login form examples use visible labels, native `email`/`password` inputs, and appropriate autocomplete values.
- Settings examples use helper text, model-backed values, and app-owned field classes.
- Validation examples include error and warning states with proper `aria-describedby` references.
- Error examples include `aria-invalid="true"`; warning examples do not.
- Read-only examples use native `readonly` and remain copyable/selectable.
- Disabled examples use native `disabled` and are described as unavailable/non-submitted.
- Type matrix examples render `text`, `email`, `password`, `search`, `url`, `tel`, and numeric `inputmode` behavior where appropriate.
- Pending examples use `aria-busy="true"`, visible status copy, and no fake async validation.
- Developer examples do not call `<x-ui.text-input>` until that component is implemented and documented.
- The page contains no generic placeholder content.
- Tests assert stale labels and legacy scaffolding remain absent when they are not part of approved UI copy.
- Tests assert no raw Bootstrap `.form-control`, hard-coded color, arbitrary local spacing, feature-local input class system, local JavaScript input controller, or direct Carbon production class is presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('/platform/ui-reference/components/text-input');

$response->assertOk();
$response->assertSee('Text input');
$response->assertSee('ui-text-input-field');
$response->assertSee('ui-text-input');
$response->assertSee('type="text"', false);
$response->assertSee('type="email"', false);
$response->assertSee('type="password"', false);
$response->assertSee('aria-describedby');
$response->assertSee('aria-invalid="true"', false);
$response->assertSee('readonly');
$response->assertSee('disabled');
$response->assertSee('Login form field');
$response->assertSee('Settings form field');
$response->assertSee('Validation field');
$response->assertSee('Read-only field');
$response->assertSee('Disabled field');
$response->assertSee('Type matrix');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('<li>None.</li>', false);
$response->assertDontSee('Use only documented props/options');
$response->assertDontSee('See UI Reference developer implementation section');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('form-control');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
```

## 17. Related APIs

| API                      | Route                                                                |
| ------------------------ | -------------------------------------------------------------------- |
| Textarea                 | `/platform/ui-reference/components/textarea`                         |
| Select                   | `/platform/ui-reference/components/select`                           |
| Checkbox                 | `/platform/ui-reference/components/checkbox`                         |
| Radio button             | `/platform/ui-reference/components/radio-button`                     |
| Button                   | `/platform/ui-reference/components/button`                           |
| Inline loading           | `/platform/ui-reference/components/inline-loading`                   |
| Notification             | `/platform/ui-reference/components/notification`                     |
| Forms pattern            | `/platform/ui-reference/patterns/forms`                              |
| Overlay/feedback pattern | `/platform/ui-reference/patterns/overlays-feedback`                  |
| Color element            | `/platform/ui-reference/elements/color`                              |
| Spacing element          | `/platform/ui-reference/elements/spacing`                            |
| Typography element       | `/platform/ui-reference/elements/typography`                         |
| Themes element           | `/platform/ui-reference/elements/themes`                             |
| Motion element           | `/platform/ui-reference/elements/motion`                             |
| Components overview      | `/platform/ui-reference/components`                                  |
| Canonical text input doc | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Ftext-input.md` |
| Carbon text input usage  | `https://carbondesignsystem.com/components/text-input/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Text input usage, style, accessibility, and Forms guidance inform short free-form entry, label/helper/error exposure, sentence-case content, field state expectations, and form composition. Login App keeps its own native Blade markup, Laravel validation expectations, app-owned `ui-*` class contract, and UI Reference proof.