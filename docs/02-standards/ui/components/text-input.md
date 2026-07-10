---
title: Text input
slug: text-input
api_layer: Component API
status: implemented-pending-review
system_maturity: installed
category: inputs
priority: tier-a-critical-component
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/text-input.md
source_owner: not installed
blade_api:
  - x-ui.text-input
related_components:
  - select
  - dropdown
  - radio-button
  - checkbox
  - search
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - icons
carbon_reference:
  - https://carbondesignsystem.com/components/text-input/usage/
  - https://carbondesignsystem.com/components/text-input/style/
  - https://carbondesignsystem.com/components/text-input/accessibility/
---

# Text input Component API Standard

- [1. API summary](#1-api-summary)
- [2. Installed standard](#2-installed-standard)
- [3. Public API](#3-public-api)
- [4. Variants and styles](#4-variants-and-styles)
- [5. Labels, helper text, and placeholders](#5-labels-helper-text-and-placeholders)
- [6. States and validation](#6-states-and-validation)
- [7. Color tokens](#7-color-tokens)
- [8. Typography and structure](#8-typography-and-structure)
- [9. Text area behavior](#9-text-area-behavior)
- [10. Password behavior](#10-password-behavior)
- [11. Rendered evidence requirements](#11-ui-reference-requirements)
- [12. Testing and acceptance criteria](#12-testing-and-acceptance-criteria)
- [13. Related APIs](#13-related-apis)
- [14. References](#14-references)

## 1. API summary

Text input is the component family for free-form user-entered content. It owns single-line text input, password input, and text area behavior through `x-ui.text-input`.

Use Text input when expected user input is free-form, unique, memorable, or may include letters, numbers, symbols, or short strings. Do not use it when the user must choose from predefined valid options; use Select, Dropdown, Radio button, Checkbox, or another selection control instead.

## 2. Installed standard

- Use `x-ui.text-input` as the canonical API.
- Implement text input, password input, and text area variants.
- Support default and fluid styles.
- Support small, medium, and large default input sizes.
- Support enabled, active, focus, error, warning, disabled, read-only, and skeleton states.
- Require labels unless an approved accessibility exemption exists.
- Keep placeholder text optional and never a label replacement.
- Replace helper text with error or warning copy when validation is active.
- Use token-backed field, text, helper, focus, error, warning, disabled, and read-only roles.

## 3. Public API

```blade
<x-ui.text-input
    name="workspace_name"
    label="Workspace name"
    value="North region"
    helper="Use a recognizable workspace name."
/>

<x-ui.text-input
    type="password"
    variant="password"
    label="Password"
    helper="Use at least 12 characters."
/>

<x-ui.text-input
    type="textarea"
    variant="textarea"
    label="Description"
    maxlength="120"
    counter="characters"
/>
```

| Prop | Default | Allowed values | Notes |
| ---- | ------- | -------------- | ----- |
| `label` | none | Short visible label | Required. Use sentence case and no trailing colon. |
| `type` | `text` | `text`, `email`, `password`, `search`, `url`, `tel`, `textarea` | Native input type or text area marker. |
| `variant` | `text` | `text`, `password`, `textarea` | Selects family behavior. |
| `style` | `default` | `default`, `fluid` | Fluid places label inside the field. |
| `size` | `md` | `sm`, `md`, `lg` | Applies to default text/password fields. |
| `helper` | null | Sentence guidance | Persistent below default fields; tooltip semantics in fluid style. |
| `error` | null | Error message | Adds invalid state, error icon, and associated message. |
| `warning` | null | Warning message | Adds warning icon and associated warning message. |
| `disabled` | false | boolean | Unavailable and not focusable. |
| `readonly` | false | boolean | Readable and accessible, not editable. |
| `required` / `optional` | false | boolean | Adds the appropriate label indicator for the form context. |
| `skeleton` | false | boolean | Loading placeholder before the field is ready. |
| `maxlength` / `maxwords` | null | number | Text area counter limits. |
| `counter` | null | `characters`, `words` | Text area counter display. |
| `passwordVisible` | false | boolean | Initial password visibility state. |

## 4. Variants and styles

| Variant | Purpose | Required behavior |
| ------- | ------- | ----------------- |
| Text input | Single-line free-form text | Remains one line; long content scrolls horizontally inside the field. |
| Password input | Private single-line text | Hidden by default; visibility toggle is a separate button target. |
| Text area | Multi-line free-form text | Variable height, resize handle, vertical scrolling, optional counters. |

| Style | Required behavior |
| ----- | ----------------- |
| Default | Label and helper text appear outside the field. Use for productive forms and dense layouts. |
| Fluid | Label is placed inside the field and stacked inline with input text. Helper text uses tooltip semantics. |

## 5. Labels, Helper Text, And Placeholders

- Labels are required for text input, password input, and text area.
- Labels use sentence-style capitalization, are short, and do not end with colons.
- Use `(optional)` when most fields are required. Use `(required)` when most fields are optional.
- Helper text is optional, persistent in default style, and replaced by warning or error text while active.
- Placeholder text is optional, must not contain crucial information, and must not replace the label.

## 6. States and validation

| State | Required behavior |
| ----- | ----------------- |
| Enabled | Field is live and may be empty, contain placeholder text, or contain user content. |
| Active | User is typing into the field. |
| Focus | Focus ring/border appears after keyboard or pointer focus. |
| Error / invalid | Error border, error icon, `aria-invalid`, and associated error message. |
| Warning | Warning icon and associated warning text. |
| Disabled | Unavailable, non-interactive, and not focusable. |
| Read-only | Value is readable and accessible but cannot be modified. |
| Skeleton | Initial loading placeholder. |

## 7. Color Tokens

Default text input, password input, and text area use these roles:

| Element | Property | Token |
| ------- | -------- | ----- |
| Label | `color` | `$text-secondary` |
| Field text | `color` | `$text-primary` |
| Placeholder text | `color` | `$text-placeholder` |
| Helper text | `color` | `$text-helper` |
| Field | `background-color` | `$field` |
| Field | `border-bottom` | `$border-strong` |
| Focus border | `border` | `$focus` |
| Invalid border/icon | `border`, `svg` | `$support-error` |
| Error message | `color` | `$text-error` |
| Warning icon | `svg` | `$support-warning` |
| Warning message | `color` | `$text-primary` |
| Disabled text | `color` | `$text-disabled` |
| Read-only border | `border-bottom` | `$border-subtle` |
| Password view icon | `svg` | `$icon-primary` |

Read-only default fields use transparent background. Read-only fluid fields use `$field` background and `$text-secondary` text. Disabled default fields use transparent bottom border; disabled fluid fields use `$border-subtle`.

## 8. Typography And Structure

| Element | Size | Weight | Token |
| ------- | ---: | -----: | ----- |
| Label | 12px / 0.75rem | 400 | `$label-01` |
| Field text | 14px / 0.875rem | 400 | `$body-compact-01` |
| Helper text | 12px / 0.75rem | 400 | `$helper-text-01` |
| Error/warning message | 12px / 0.75rem | 400 | `$label-01` |

| Size | Default input height |
| ---- | -------------------: |
| Small `sm` | 32px / 2rem |
| Medium `md` | 40px / 2.5rem |
| Large `lg` | 48px / 3rem |
| Fluid text/password | 64px / 4rem |
| Text area minimum | 40px / 2.5rem |

Default field text uses 16px left/right padding. Fluid fields use 16px left/right padding and label padding inside the field. Focus and validation borders are 2px.

## 9. Text Area Behavior

- Use text area when input may span multiple lines: comments, descriptions, notes, and message-style content.
- Text area has variable height and includes a resize handle by default.
- Resize affects height only, not width.
- Content may scroll vertically when it exceeds the visible height.
- Optional character and word counters are supported.
- Text area supports all standard text input states except password visibility behavior.

## 10. Password Behavior

- Password input hides characters by default.
- A view icon appears on the far right of the field.
- The visibility toggle is a separate interactive target with `aria-pressed`.
- Password input supports default and fluid styles plus validation, disabled, read-only, focus, warning, and skeleton states.
- Password helper text should describe password requirements when applicable.

## 11. Rendered evidence requirements

The rendered evidence page must show:

- Default and fluid text input.
- Default and fluid password input.
- Default and fluid text area.
- Small, medium, and large default text/password sizes.
- Enabled, active, focus, error, warning, disabled, read-only, and skeleton states.
- Password input with hidden and visible examples plus toggle button.
- Text area resize handle, character counter, word counter, and vertical overflow.
- Required/optional label indicators and placeholder limitations.

## 12. Testing And Acceptance Criteria

- `not installed` returns 200 for authorized users.
- `x-ui.text-input` renders text, password, and textarea variants.
- Password input renders a separate toggle button and the JavaScript controller toggles the native input type.
- Error state renders `aria-invalid`, error icon, and associated error message.
- Warning state renders warning icon and warning message.
- Fluid style renders a 64px field shell with internal label.
- Text area renders a resize-capable control and counter examples.
- Tests assert component source, CSS, JS lifecycle registration, rendered evidence examples, and this standard.

## 13. Related APIs

| API | Route |
| --- | ----- |
| Select | `not installed` |
| Dropdown | `not installed` |
| Radio button | `not installed` |
| Checkbox | `not installed` |
| Search | `not installed` |
| Form patterns | `not installed` |

## 14. References

- [Component Standards Index](index.md)
- [Foundation Color](../elements/color.md)
- [Foundation Typography](../elements/typography.md)
- [Foundation Icons](../elements/icons.md)
- Carbon Text input usage, style, and accessibility guidance inform the variant, state, size, text area, password, validation, and token coverage. Login App owns the `x-ui.text-input` API and app-owned `ui-*` implementation contract.
