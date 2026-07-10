---
title: File uploader
slug: file-uploader
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: inputs
priority: tier-b-common-reusable-component
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/file-uploader.md
source_owner: not installed
blade_api:
  - native input[type="file"] composed with app-owned ui-* field and file-uploader classes
javascript_api: []
data_attributes: []
source_files:
  - resources/css/app.css
foundation_elements:
  - color
  - spacing
  - typography
  - themes
related_components:
  - button
  - inline-loading
  - notification
  - text-input
related_patterns:
  - forms
  - overlays-feedback
carbon_reference:
  - https://carbondesignsystem.com/components/file-uploader/usage/
  - https://carbondesignsystem.com/components/file-uploader/style/
  - https://carbondesignsystem.com/components/file-uploader/accessibility/
---

# File uploader Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Canonical calls](#41-canonical-calls)
  - [4.2. API surfaces](#42-api-surfaces)
  - [4.3. Markup and option contract](#43-markup-and-option-contract)
  - [4.4. Installed state class contract](#44-installed-state-class-contract)
  - [4.5. File item data contract](#45-file-item-data-contract)
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
- [10. Accessibility contract](#10-accessibility-contract)
- [11. Content contract](#11-content-contract)
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

File uploader collects one or more user-selected files through an accessible native file input.

Canonical API owner: `not installed`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

File uploader is the installed Login App 2.0 file-selection field API. It owns native file-input composition, labels, helper copy, file constraints, validation messaging, disabled/loading/read-only treatment, token-backed field states, and rendered evidence proof for installed button upload behavior. It does not own upload storage, malware scanning, server validation rules, asynchronous upload transport, drag-and-drop behavior, image previews, file transformation, or workflow layout.

### 1.1. Canonical API responsibilities:

- Render file selection through a native `<input type="file">` control.
- Preserve a visible label and accessible name for every file input.
- Expose helper, error, warning, and loading/status copy through stable IDs and `aria-describedby`.
- Support single-file and multi-file selection through native attributes.
- Support accepted file type hints through the native `accept` attribute while requiring server-side validation outside the component.
- Represent disabled, read-only, validation, and loading states through installed app field classes and native attributes where valid.
- Use app-owned `ui-*` field and file-uploader classes instead of raw utility clusters or custom file-field chrome.
- Prove installed button upload, validation, disabled/read-only, loading, and drag-drop deferral behavior on the rendered evidence page.

### 1.2. Non-owned responsibilities:

- File persistence, disk selection, storage drivers, signed URLs, virus scanning, or import processing.
- Server-side validation rules, request classes, policy checks, or controller behavior.
- Asynchronous upload, upload progress bars, retry queues, chunked upload, or client-side file previews.
- Drag-and-drop file handling. That remains deferred until a JavaScript owner, accessibility contract, and rendered evidence proof are installed.
- External layout, form grouping, submit/cancel actions, and workflow orchestration. Parent Forms and Overlay/feedback Patterns own those responsibilities.

## 2. Status and ownership

| Field                        | Value                                                                                                           |
| ---------------------------- | --------------------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                                    |
| System maturity              | Partial                                                                                                         |
| API layer                    | Component API                                                                                                   |
| Component slug               | `file-uploader`                                                                                                 |
| Category                     | Inputs                                                                                                          |
| Priority                     | Tier B - Common reusable component                                                                              |
| Rendered evidence route           | `not installed`                                                               |
| Canonical doc                | `docs/02-standards/ui/components/file-uploader.md`                                                              |
| Source owner                 | `not installed`                                                               |
| Blade API                    | Native `<input type="file">` composed with app-owned `ui-*` field and file-uploader classes                     |
| Dedicated Blade component    | Not public until `x-ui.file-uploader` is implemented, documented, and proven                                    |
| JavaScript API               | None required for installed button upload behavior                                                              |
| Data attributes              | None required for installed behavior                                                                            |
| Source files                 | `resources/css/app.css`; rendered evidence implementation owned by `not installed` |
| Foundation Elements consumed | Color, Spacing, Typography, Themes                                                                              |
| Carbon benchmark             | Carbon File uploader usage, style, and accessibility guidance                                                   |

`Approved API` means the Rendered evidence route and component-specific examples exist, but the canonical document must replace placeholder API text with the installed native-input contract, explicit field states, and deferred drag-drop gates.

## 3. Installed standard

File uploader is installed as a native-input field composition. The approved production API is native Blade markup using the app field class contract and file-uploader class namespace. A dedicated `<x-ui.file-uploader>` component is not public until it is implemented and documented as a follow-up API.

### The installed standard is:

- Use `<input type="file">` for file selection.
- Wrap the input in `.ui-field.ui-file-uploader`.
- Use a visible `<label>` associated with the input through `for` and `id`.
- Use helper text to state file type, size, count, and workflow constraints before selection.
- Use `accept` to hint allowed file types, but keep real validation in server-side app code.
- Use `multiple` only when the workflow accepts more than one file.
- Use array-style field names such as `attachments[]` when `multiple` files are submitted to Laravel as an array.
- Use `required` only when the field is required for the current form submission.
- Use `disabled` for unavailable upload controls.
- Represent read-only as a non-interactive file summary. Do not put an invalid `readonly` attribute on a file input.
- Represent loading with the wrapper state, `aria-busy="true"`, status copy, and a disabled input while work is pending.
- Represent validation through `.ui-field-error` or `.ui-field-warning` and message IDs referenced by `aria-describedby`.
- Use `aria-invalid="true"` only for blocking error states, not for warnings.
- Render existing or previously uploaded files as a server-rendered file list when needed.
- Keep drag-and-drop examples deferred. The rendered evidence page may show trigger conditions and alternatives, but must not render a fake drop zone as production API.

Carbon alignment note: Carbon documents both button-based and drag-and-drop uploaders, file selection through one or more files, small/medium/large height alignment, accessible keyboard operation, and assistive-technology exposure for errors and file-removal buttons. Login App maps the installed portion to a native file input plus app-owned field classes, and explicitly defers drag-and-drop, asynchronous progress, and dedicated JavaScript behavior until they have app-owned implementation proof.

## 4. Public API

### 4.1. Canonical calls

Use native Blade markup with the installed field and file-uploader class contract.

```blade
<div class="ui-field ui-file-uploader">
    <label class="ui-field-label" for="tenant-logo">
        Tenant logo
    </label>

    <p class="ui-field-helper" id="tenant-logo-helper">
        PNG or JPG up to 2 MB.
    </p>

    <input
        id="tenant-logo"
        name="tenant_logo"
        type="file"
        class="ui-file-input"
        accept="image/png,image/jpeg"
        aria-describedby="tenant-logo-helper"
    >
</div>
```

```blade
<div class="ui-field ui-file-uploader">
    <label class="ui-field-label" for="support-attachments">
        Support attachments
    </label>

    <p class="ui-field-helper" id="support-attachments-helper">
        Add up to 5 PDF, PNG, or JPG files. Each file must be under 10 MB.
    </p>

    <input
        id="support-attachments"
        name="attachments[]"
        type="file"
        class="ui-file-input"
        accept="application/pdf,image/png,image/jpeg"
        multiple
        aria-describedby="support-attachments-helper"
    >
</div>
```

```blade
<div class="ui-field ui-file-uploader ui-field-error">
    <label class="ui-field-label" for="bulk-import">
        Import users
    </label>

    <p class="ui-field-helper" id="bulk-import-helper">
        CSV only. Maximum file size is 5 MB.
    </p>

    <input
        id="bulk-import"
        name="bulk_import"
        type="file"
        class="ui-file-input"
        accept="text/csv,.csv"
        aria-describedby="bulk-import-helper bulk-import-error"
        aria-invalid="true"
    >

    <p class="ui-field-error-message" id="bulk-import-error">
        Choose a CSV file under 5 MB.
    </p>
</div>
```

```blade
<div class="ui-field ui-file-uploader ui-field-readonly">
    <span class="ui-field-label" id="signed-contract-label">
        Signed contract
    </span>

    <p class="ui-field-helper" id="signed-contract-helper">
        Current file on record.
    </p>

    <div
        class="ui-file-list"
        role="list"
        aria-labelledby="signed-contract-label"
        aria-describedby="signed-contract-helper"
    >
        <div class="ui-file-item" role="listitem">
            <span class="ui-file-name">signed-contract.pdf</span>
            <span class="ui-file-meta">PDF, 428 KB</span>
        </div>
    </div>
</div>
```

Do not hand-build local file upload controls outside this contract.

### 4.2. API surfaces

| API surface               | Installed value                                                                                                       |
| ------------------------- | --------------------------------------------------------------------------------------------------------------------- |
| Blade API                 | Native `<input type="file">` composed with app-owned `ui-*` field and file-uploader classes                           |
| Dedicated Blade component | Not installed as public API. Do not call `<x-ui.file-uploader>` until that component is implemented and documented.   |
| JavaScript                | No dedicated JavaScript controller required for installed button upload behavior                                      |
| Root semantic element     | Native file input inside an app field wrapper                                                                         |
| Data attributes           | None required for installed behavior. Feature views must not invent data attributes for file upload behavior.         |
| CSS namespace             | App-owned `ui-*` classes documented in this standard                                                                  |
| Source ownership          | rendered evidence owner route `not installed`; shared styling in `resources/css/app.css` |

### 4.3. Markup and option contract

| Option/attribute   | Type              | Default         | Allowed values               | Required                                      | Notes                                                                            |
| ------------------ | ----------------- | --------------- | ---------------------------- | --------------------------------------------- | -------------------------------------------------------------------------------- |
| `id`               | `string`          | none            | Unique DOM ID                | Yes                                           | Must match the visible label `for` attribute.                                    |
| `name`             | `string`          | none            | Laravel field name           | Yes                                           | Use `attachments[]` style names for multi-file arrays.                           |
| `type`             | `string`          | `file`          | `file`                       | Yes                                           | File uploader must use native file input semantics.                              |
| Visible label      | text/HTML         | none            | Short, concrete label        | Yes                                           | Use `<label for="...">` for interactive upload fields.                           |
| Helper text        | text/HTML         | none            | Short instruction copy       | Strongly recommended                          | State file type, count, size, and timing constraints.                            |
| `accept`           | `string / null`   | browser default | MIME types and/or extensions | No                                            | Hint only. Server validation remains required.                                   |
| `multiple`         | boolean attribute | omitted         | present/omitted              | No                                            | Use only when multiple files are accepted.                                       |
| `required`         | boolean attribute | omitted         | present/omitted              | No                                            | Use only when the current form cannot submit without a file.                     |
| `disabled`         | boolean attribute | omitted         | present/omitted              | No                                            | Use for unavailable upload controls and loading states.                          |
| `aria-describedby` | `string / null`   | none            | Space-separated IDs          | Required when helper/status/error text exists | Reference helper, warning, error, or status copy.                                |
| `aria-invalid`     | `true             | null`           | omitted                      | `true` when invalid                           | Required for blocking errors                                                     | Do not set for warnings.                  |
| `aria-busy`        | `true             | null`           | omitted                      | `true` on wrapper while pending               | Required for loading state                                                       | Pair with disabled input and status copy. |
| `readonly`         | not valid         | not supported   | none                         | Not applicable                                | Do not place `readonly` on file inputs. Render a read-only file summary instead. |

Any option not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the rendered evidence proof before use.

### 4.4. Installed state class contract

| Class                       | Status                                    | Purpose                                                                  |
| --------------------------- | ----------------------------------------- | ------------------------------------------------------------------------ |
| `.ui-field`                 | Implemented                               | App field wrapper shared by input components.                            |
| `.ui-file-uploader`         | Implemented                               | Root file uploader component namespace.                                  |
| `.ui-field-label`           | Implemented                               | Visible label text.                                                      |
| `.ui-field-helper`          | Implemented                               | Helper and constraint copy.                                              |
| `.ui-file-input`            | Implemented                               | Native file input styling hook.                                          |
| `.ui-field-error`           | Implemented                               | Blocking validation state on the wrapper.                                |
| `.ui-field-error-message`   | Implemented                               | Error copy referenced by `aria-describedby`.                             |
| `.ui-field-warning`         | Implemented                               | Non-blocking warning state on the wrapper.                               |
| `.ui-field-warning-message` | Implemented                               | Warning copy referenced by `aria-describedby`.                           |
| `.ui-field-disabled`        | Implemented                               | Optional wrapper class when the input is disabled.                       |
| `.ui-field-readonly`        | Implemented                               | Read-only file summary state; does not render an interactive file input. |
| `.ui-field-loading`         | Implemented                               | Pending state paired with `aria-busy="true"` and disabled input.         |
| `.ui-file-list`             | Implemented for server-rendered summaries | Existing or selected file summary list.                                  |
| `.ui-file-item`             | Implemented for server-rendered summaries | One file summary item.                                                   |
| `.ui-file-name`             | Implemented for server-rendered summaries | File name text.                                                          |
| `.ui-file-meta`             | Implemented for server-rendered summaries | Optional file type, size, or upload metadata.                            |

### 4.5. File item data contract

File uploader may display server-rendered existing files or previously submitted files when the form owns that data.

| Field                          | Required | Notes                                                                                     |
| ------------------------------ | -------- | ----------------------------------------------------------------------------------------- |
| File name                      | Yes      | Render the user-visible filename. Escape output.                                          |
| File extension or MIME summary | No       | Use when it helps users identify the file.                                                |
| File size                      | No       | Use when relevant to quota or validation.                                                 |
| File status                    | No       | Use only for server-known states such as uploaded, rejected, or pending review.           |
| Remove action                  | No       | If present, use Button/Icon button APIs and include the filename in the accessible label. |

Client-side selected-file previews are not part of the installed API because no file-uploader JavaScript controller is installed.

## 5. Allowed variants, options, and modifiers

| Name                      | Type         | Status                               | API                                                                                          | Notes                                                    |
| ------------------------- | ------------ | ------------------------------------ | -------------------------------------------------------------------------------------------- | -------------------------------------------------------- |
| Button upload             | Mode         | Implemented                          | Native `<input type="file">` with `.ui-file-input`                                           | Installed default. Uses browser file-selection behavior. |
| Single file               | Option       | Implemented                          | Omit `multiple`                                                                              | Use for one file only.                                   |
| Multiple files            | Option       | Implemented                          | `multiple` and array-style `name`                                                            | Use only when the workflow accepts multiple files.       |
| Accepted file types       | Option       | Implemented                          | `accept="..."`                                                                               | Hint allowed types; does not replace server validation.  |
| Required file             | State/option | Implemented                          | `required` plus label/helper copy                                                            | Use only when form submission requires a file.           |
| Helper text               | Composition  | Implemented                          | `.ui-field-helper` and `aria-describedby`                                                    | State constraints before selection.                      |
| Error validation          | State        | Implemented                          | `.ui-field-error`, message ID, `aria-invalid="true"`                                         | Blocking invalid state.                                  |
| Warning validation        | State        | Implemented                          | `.ui-field-warning`, message ID                                                              | Non-blocking guidance. Do not set `aria-invalid`.        |
| Disabled                  | State        | Implemented                          | `disabled` and optional `.ui-field-disabled`                                                 | Prevents file selection.                                 |
| Read-only summary         | State/mode   | Implemented                          | `.ui-field-readonly` plus `.ui-file-list`                                                    | Render existing files without a chooser.                 |
| Loading                   | State        | Implemented                          | `.ui-field-loading`, `aria-busy="true"`, disabled input, status copy                         | Use while upload/import work is pending.                 |
| Existing file list        | Composition  | Implemented for server-rendered data | `.ui-file-list`, `.ui-file-item`                                                             | Use for current files or validation return state.        |
| Upload progress           | Deferred     | none                                 | Requires async upload owner, progress semantics, cancellation rules, and rendered evidence proof. |                                                          |
| Client-side preview       | Deferred     | none                                 | Requires JavaScript owner and accessibility review.                                          |                                                          |
| Drag-drop uploader        | Deferred     | none                                 | rendered evidence must show trigger conditions and alternatives, not a fake drop zone.            |                                                          |
| Dedicated Blade component | Deferred     | `<x-ui.file-uploader>` not public    | Requires implementation, documented props, tests, and examples.                              |                                                          |
| Custom button chrome      | Not allowed  | none                                 | Do not replace native file input with one-off local markup.                                  |                                                          |
| Directory upload          | Not allowed  | none                                 | Requires separate workflow and browser support review before approval.                       |                                                          |

## 6. States

| State              | Status                                            | Implementation requirement                                                                                                                             |
| ------------------ | ------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Default            | Implemented                                       | Renders visible label, helper text when available, and native file input.                                                                              |
| Hover-capable      | Implemented                                       | Native/browser upload button and token-backed field chrome may expose hover when supported.                                                            |
| Focus-visible      | Implemented                                       | The native input receives visible focus in all supported themes.                                                                                       |
| Active/pressed     | Implemented where browser exposes the file button | Do not create static active styling.                                                                                                                   |
| Helper             | Implemented                                       | Helper copy is visible and referenced by `aria-describedby`.                                                                                           |
| Error              | Implemented                                       | Blocking error uses `.ui-field-error`, `aria-invalid="true"`, and error message ID.                                                                    |
| Warning            | Implemented                                       | Non-blocking warning uses `.ui-field-warning` and warning message ID without `aria-invalid`.                                                           |
| Disabled           | Implemented                                       | Native `disabled` prevents file selection. Wrapper may also use `.ui-field-disabled`.                                                                  |
| Read-only          | Implemented as summary                            | Render non-interactive file summary. Do not render an enabled chooser. Do not use invalid `readonly` attribute.                                        |
| Loading            | Implemented                                       | Wrapper uses `aria-busy="true"`, input is disabled, and visible status copy is provided.                                                               |
| Empty              | Implemented                                       | Empty state is the default no-file-selected state. Helper copy should state constraints.                                                               |
| Selected/uploaded  | Implemented for server-rendered data              | Existing or previously submitted files render in `.ui-file-list`. Browser-selected filenames remain browser-owned unless a future JS API is installed. |
| Overflow/truncated | Implemented for file summaries                    | Long filenames may truncate visually only if the full filename is available through title, tooltip, or adjacent disclosure.                            |
| Success            | Not public as a field state                       | Use server-rendered file summary or Notification/Inline loading patterns when a workflow needs success feedback.                                       |
| Drag-over          | Deferred                                          | Belongs to the deferred drag-drop uploader, not the installed button upload API.                                                                       |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

File uploader consumes Foundation Color, Spacing, Typography, and Themes.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                   |
| ----------- | --------------------------------------------------------------------------------------------------------------- |
| Color       | Field text, helper text, borders, focus, disabled, warning, error, and loading/status roles.                    |
| Spacing     | Label/helper/input gaps, file-list item padding, message spacing, and field stack spacing within the component. |
| Typography  | Label, helper, filename, metadata, warning, error, and status text.                                             |
| Themes      | Light and dark token resolution for default, disabled, warning, error, focus, and loading states.               |

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
.ui-file-uploader
.ui-file-input
.ui-file-list
.ui-file-item
.ui-file-name
.ui-file-meta
.ui-file-status
```

Feature views must not create local `file-upload-*`, `upload-*`, Bootstrap input groups, raw utility clusters, arbitrary colors, arbitrary spacing, custom focus rings, local SVG icons, or custom JavaScript for the same UI role.

## 8. Composition rules

- File uploader must be composed as a field, not as a standalone unlabeled control.
- The input ID and visible label `for` value must match.
- Helper, warning, error, and status copy must use stable IDs referenced by `aria-describedby`.
- The helper text should state allowed file types, maximum file size, maximum file count, and timing constraints when those constraints exist.
- The `accept` attribute is only a chooser hint. Laravel request validation remains required.
- Use `multiple` only when the downstream form, controller, storage, and validation rules accept multiple files.
- Use array-style names for multi-file uploads submitted to Laravel.
- Disabled and loading uploaders must not allow file selection.
- Read-only uploaders must render file information only; they must not render an enabled chooser.
- Existing files may render as a server-owned list below the field.
- Removal controls, when present, must use the Button/Icon button Component API and include the filename in the accessible name.
- Parent Forms and Overlay/feedback Patterns own grouping, external spacing, submit/cancel controls, modal/side-panel placement, and page-level upload workflow.
- Components own internal field semantics, label/helper/error associations, file summary styling, and token-backed states.

## 9. Selection guidance

### 9.1. Use when:

- A user needs to attach, import, or submit one or more local files through a form.
- The file selection can be handled by the browser’s native file chooser.
- The workflow needs visible label, helper, validation, disabled, loading, or read-only field treatment.
- The app needs a server-rendered summary of existing files or validation-returned files.

### 9.2. Do not use when:

- The workflow requires drag-and-drop. That capability is deferred.
- The workflow requires asynchronous upload progress, retries, cancellation, or chunked upload. Use a future upload Pattern after it is installed.
- The workflow requires file previews, cropping, scanning status, or transformation before submission.
- The user is importing from a URL, cloud provider, camera, scanner, or external system rather than choosing a local file.
- The control is only a button-like command with no file input. Use Button.
- The field is part of a complex import wizard with metadata mapping. Use a Pattern-owned import workflow when available.
- Multiple uploaded files would stack inside a constrained modal. Prefer a full page, side panel, or Pattern-approved flow.

### Selection matrix:

| Need                                  | Use                                                             |
| ------------------------------------- | --------------------------------------------------------------- |
| One local file                        | Native file input without `multiple`                            |
| Multiple local files                  | Native file input with `multiple` and array-style `name`        |
| File constraints                      | Helper text plus `accept`, with server validation               |
| Blocking invalid file                 | Error state with `aria-invalid="true"`                          |
| Non-blocking constraint warning       | Warning state without `aria-invalid`                            |
| Existing file with no edit permission | Read-only file summary                                          |
| Pending upload/import state           | Loading state with disabled input and status copy               |
| Drag-drop selection                   | Deferred drag-drop trigger conditions; do not implement locally |

## 10. Accessibility contract

- Use the native file input for installed upload behavior.
- Provide a visible label for every file input.
- Associate the label with the input using `for` and `id`.
- Do not rely on placeholder text or adjacent prose as the only label.
- Expose helper, warning, error, and loading/status copy through `aria-describedby`.
- Use `aria-invalid="true"` only when the current value is invalid and blocks submission.
- Error messages must give enough guidance for the user to correct the file selection.
- Disabled inputs must use the native `disabled` attribute.
- Read-only mode must not expose an enabled file chooser.
- Loading mode must expose pending status and prevent repeated selection while pending.
- Focus-visible treatment must be visible in all supported themes.
- Do not rely on color alone for error, warning, disabled, or loading states.
- The native input must remain keyboard reachable and operable.
- When the file chooser closes, focus should return to the invoking input according to browser behavior.
- File removal controls must include the filename in the accessible name, such as `Remove signed-contract.pdf`.
- A drag-drop area is not approved until it is implemented as keyboard-operable control with documented focus, activation, drop, error, and assistive-technology behavior.

## 11. Content contract

- Use sentence case.
- Use concrete labels that describe the requested file: `Tenant logo`, `Import users`, `Signed contract`.
- Use helper text for constraints: file type, size, count, required/optional status, and what happens after selection.
- Keep helper, warning, error, and status copy short enough to scan.
- Use `Add files` when the action is generic and multiple files are accepted.
- Use a specific label such as `Upload CSV` only when the required file type is central to the workflow.
- Avoid vague labels such as `Upload`, `Choose`, `Browse`, or `Submit file` when a specific file noun is available.
- Error messages must be actionable: `Choose a CSV file under 5 MB.`
- Warning messages must explain risk or next step without implying the field is invalid.
- File names must preserve the user-recognizable filename.
- Long filenames may truncate visually only when the full filename is still available through an approved disclosure.
- Do not expose fake selected filenames in examples unless the example is explicitly server-rendered sample data.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, custom focus rings, or custom JavaScript.
- Do not create feature-local `file-upload-*`, `upload-*`, or `dropzone-*` class systems for the same UI role.
- Do not use direct Carbon production classes in app markup.
- Do not replace the native file input with custom button chrome unless the Component API is formally updated and accessibility proof is added.
- Do not hide the native file input in a way that removes keyboard access or accessible name calculation.
- Do not rely on the `accept` attribute as validation.
- Do not omit helper copy when file type, size, count, or required constraints exist.
- Do not place `readonly` on `<input type="file">`.
- Do not render enabled file inputs in read-only views.
- Do not set `aria-invalid` for warnings.
- Do not render fake upload progress or fake selected-file states without implementation ownership.
- Do not implement drag-and-drop locally.
- Do not put multiple-file upload flows into constrained modals without Pattern approval.
- Do not use this component for URL import, remote provider selection, scanner/camera capture, or file transformation workflows.

## 13. Deferred or gated capabilities

| Capability                           | Status                                   | Gate                                                                                                                                                              |
| ------------------------------------ | ---------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `x-ui.file-uploader` Blade component | Deferred                                 | Requires source implementation, prop contract, accessibility review, rendered evidence proof, and tests.                                                               |
| Drag-and-drop uploader               | Deferred                                 | Requires JavaScript owner, keyboard-operable drop target, drag-over/drop states, error handling, reduced-motion review if motion is used, and rendered evidence proof. |
| Async upload progress                | Deferred                                 | Requires upload service contract, progress semantics, retry/cancel behavior, Inline loading or Progress API integration, and tests.                               |
| Client-side validation controller    | Deferred                                 | Requires documented validation rules, server/client parity, message mapping, and accessibility proof.                                                             |
| Client-side selected-file list       | Deferred                                 | Requires JavaScript owner, filename overflow behavior, removal controls, and screen-reader announcements.                                                         |
| Image/file preview                   | Deferred                                 | Requires content security review, file type handling, alt/text behavior, and rendered evidence proof.                                                                  |
| Directory upload                     | Not implemented                          | Requires browser support review, server contract, and Pattern approval.                                                                                           |
| Custom visual drop zone              | Not allowed until drag-drop is installed | Use native button upload instead.                                                                                                                                 |
| Arbitrary size variants              | Not public                               | Must be approved through Form Pattern and field sizing standards before use.                                                                                      |

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

The File uploader page is an input component reference page. The Live examples card should use grouped field examples and state tables rather than a fake full uploader application. Deferred behavior must appear as trigger conditions and alternatives, not as production controls.

### Required Live examples internal sections:

| Required proof           | Rendered behavior                                                                                                                                       | Variants/options shown                                            |
| ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------- |
| Button upload            | Native file input renders with visible label, helper text, accepted types, and token-backed field styling.                                              | Single file, Multiple files, `accept`, Helper text, Focus-visible |
| File validation          | Error and warning examples render with proper message IDs and `aria-describedby`; blocking errors include `aria-invalid="true"`.                        | Error, Warning, Helper text, Accepted types                       |
| Disabled                 | Disabled file input renders unavailable and cannot be selected.                                                                                         | Disabled, Helper text                                             |
| Read-only summary        | Existing file renders as non-interactive summary without an enabled file chooser.                                                                       | Read-only, Existing file list, Filename/meta text                 |
| Loading                  | Pending upload/import state disables input, sets busy state, and shows status copy.                                                                     | Loading, Disabled while pending, Status text                      |
| Existing file list       | Server-rendered file list shows filename and optional metadata without requiring JavaScript.                                                            | File list, File item, Filename overflow behavior                  |
| Drag-drop deferred       | Page shows drag-drop trigger conditions, gates, and approved native-input alternative.                                                                  | Deferred drag-drop, No fake drop zone                             |
| Developer implementation | Canonical native Blade markup and option tables render as real code examples.                                                                           | Native input, `ui-*` classes, documented attributes               |
| Prohibited usage         | The page shows forbidden local markup, custom JavaScript, fake drop zones, invalid read-only input usage, and direct Carbon class usage as not allowed. | Prohibited examples and deferred gates                            |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered states, options/modifiers, prohibited usage, deferred gates, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- Button upload examples use native `<input type="file">` with `ui-file-uploader` and `ui-file-input` classes.
- Every rendered upload field has a visible label associated through `for` and `id`.
- Helper, warning, error, and status copy are associated through `aria-describedby`.
- Error examples include `aria-invalid="true"` and warning examples do not.
- Disabled examples include the native `disabled` attribute.
- Read-only examples render a file summary and do not render an enabled file input.
- Loading examples use `aria-busy="true"`, visible status copy, and disabled input behavior.
- Multiple upload examples use `multiple` and array-style field names where appropriate.
- Drag-drop examples are clearly marked deferred and do not render a fake production drop zone.
- Developer examples do not call `<x-ui.file-uploader>` until that component is implemented and documented.
- The page contains no generic placeholder content.
- Tests assert stale labels and legacy scaffolding remain absent when they are not part of approved UI copy.
- Tests assert no raw Bootstrap input group, hard-coded color, arbitrary local spacing, feature-local file upload class system, local JavaScript uploader, or direct Carbon production class is presented as approved.

### 16.1. Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('File uploader');
$response->assertSee('ui-file-uploader');
$response->assertSee('ui-file-input');
$response->assertSee('type="file"', false);
$response->assertSee('Button upload');
$response->assertSee('File validation');
$response->assertSee('Disabled');
$response->assertSee('Read-only summary');
$response->assertSee('Loading');
$response->assertSee('Drag-drop deferred');
$response->assertSee('aria-describedby');
$response->assertSee('aria-invalid="true"', false);
$response->assertSee('aria-busy="true"', false);
$response->assertSee('accept=');
$response->assertSee('multiple');
$response->assertDontSee('Component-specific API pending correction');
$response->assertDontSee('Live Examples Card');
$response->assertDontSee('Reference Examples');
$response->assertDontSee('Legacy Contract Summary');
$response->assertDontSee('tier-1');
$response->assertDontSee('tier-2');
$response->assertDontSee('btn btn-primary');
$response->assertDontSee('dropzone-js');
$response->assertDontSee('cds--');
$response->assertDontSee('bx--');
```

## 17. Related APIs

| API                         | Route                                                                   |
| --------------------------- | ----------------------------------------------------------------------- |
| Button                      | `not installed`                              |
| Inline loading              | `not installed`                      |
| Notification                | `not installed`                        |
| Text input                  | `not installed`                          |
| Forms pattern               | `not installed`                                 |
| Overlay/feedback pattern    | `not installed`                     |
| Color element               | `not installed`                                 |
| Spacing element             | `not installed`                               |
| Typography element          | `not installed`                            |
| Themes element              | `not installed`                                |
| Components overview         | `not installed`                                     |
| Canonical file uploader doc | `/platform/docs?path=02-standards%2Fui%2Fcomponents%2Ffile-uploader.md` |
| Carbon file uploader usage  | `https://carbondesignsystem.com/components/file-uploader/usage/`        |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon File uploader usage, style, and accessibility guidance inform native file selection, helper/validation content, sizing alignment, keyboard operation, error exposure, and drag-and-drop deferral. Login App keeps its own app-owned `ui-*` class contract, native Blade markup, server-validation expectations, and rendered evidence proof.