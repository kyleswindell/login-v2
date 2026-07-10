---
title: Modal
slug: modal
api_layer: Component API
status: implemented-pending-correction
system_maturity: partial
category: overlays
priority: tier-a-baseline-app-development
rendered_evidence_route: null
canonical_doc: docs/02-standards/ui/components/modal.md
source_owner: not installed
blade_api:
  - x-ui.modal
javascript_api: []
source_files:
  - resources/views/components/ui/modal/index.blade.php
  - resources/css/app.css
  - resources/js/app.js
foundation_elements:
  - color
  - spacing
  - typography
  - themes
  - motion
  - icons
  - 2x-grid
related_components:
  - button
  - tooltip
  - inline-loading
  - notification
  - text-input
  - select
related_patterns:
  - overlays-feedback
  - forms
  - loading
  - layout
carbon_reference:
  - https://carbondesignsystem.com/components/modal/usage/
  - https://carbondesignsystem.com/components/modal/style/
  - https://carbondesignsystem.com/components/modal/accessibility/
---

# Modal Component API Standard
- [1. API summary](#1-api-summary)
  - [1.1. Canonical API responsibilities:](#11-canonical-api-responsibilities)
  - [1.2. Non-owned responsibilities:](#12-non-owned-responsibilities)
- [2. Status and ownership](#2-status-and-ownership)
- [3. Installed standard](#3-installed-standard)
- [4. Public API](#4-public-api)
  - [4.1. Canonical confirmation dialog](#41-canonical-confirmation-dialog)
  - [4.2. Canonical form modal](#42-canonical-form-modal)
  - [4.3. Canonical read-only detail modal](#43-canonical-read-only-detail-modal)
  - [4.4. Canonical destructive action modal](#44-canonical-destructive-action-modal)
  - [4.5. API surfaces](#45-api-surfaces)
  - [4.6. Props and options](#46-props-and-options)
  - [4.7. Slots](#47-slots)
  - [4.8. Data attribute contract](#48-data-attribute-contract)
  - [4.9. Variant contract](#49-variant-contract)
  - [4.10. Size contract](#410-size-contract)
  - [4.11. Dismissal contract](#411-dismissal-contract)
  - [4.12. Initial-focus contract](#412-initial-focus-contract)
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
  - [9.4. Size selection:](#94-size-selection)
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
- [17. Related APIs](#17-related-apis)
- [18. References](#18-references)

## 1. API summary

Modal interrupts the current page for a required decision, urgent task-specific information, or a contained task that must be completed or dismissed before the user returns to the page.

Canonical API owner: `not installed`. Use this Component API instead of creating local markup, styling, or behavior for the same UI role.

Modal is the installed Login App 2.0 blocking overlay API. It owns dialog semantics, overlay treatment, open and closed states, initial focus, focus containment, focus return, close button behavior, Escape and outside-click rules, size selection, footer action structure, responsive body scrolling, reduced-motion behavior, and token-backed modal surfaces. It does not own page layout, form validation rules, submit workflow orchestration, table row actions, persistent notifications, multi-step wizard state, or page-level loading.

### 1.1. Canonical API responsibilities:

- Render blocking dialogs through `x-ui.modal`.
- Require a stable `id` for trigger, close, focus-return, and test targeting.
- Render a labelled modal surface with `role="dialog"` and `aria-modal="true"` or the installed equivalent.
- Connect the modal title to the dialog accessible name.
- Provide a component-owned close affordance when dismissal is allowed.
- Keep keyboard focus inside the modal while it is open.
- Return focus to the opener when the modal closes.
- Define variant, size, dismissal, footer, and focus behavior through documented props and data attributes.
- Use `x-ui.button` for modal footer actions.
- Consume Foundation Element APIs for color, spacing, typography, themes, motion, icons, and 2x grid sizing behavior.
- Prove confirmation, form, read-only detail, destructive action, dismissal, focus, reduced-motion, and deferred wizard behavior on the rendered evidence page.

### 1.2. Non-owned responsibilities:

- Trigger button hierarchy and disabled/loading states. Use Button.
- Form field layout, validation, helper text, and field errors. Use the Forms Pattern and field Component APIs.
- Persistent success, warning, or error feedback after the modal closes. Use Notification or the owning Pattern.
- Short pending feedback in a modal footer action. Use Button loading or Inline loading.
- Page-level loading or blocked route transitions. Use the Loading Pattern when installed.
- Multi-step or wizard workflow state. Use a full page or a gated Pattern until the wizard modal API is installed.
- Menus, popovers, tooltips, and non-blocking disclosure. Use the owning overlay Component or Pattern.
- External spacing, page placement, and workflow orchestration. Parent Patterns own those concerns.

## 2. Status and ownership

| Field                        | Value                                                                                                                                                       |
| ---------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Status                       | Approved API                                                                                                                                                |
| System maturity              | Partial                                                                                                                                                     |
| API layer                    | Component API                                                                                                                                               |
| Component slug               | modal                                                                                                                                                       |
| Category                     | Overlays                                                                                                                                                    |
| Priority                     | Tier A - Baseline app development                                                                                                                           |
| Rendered evidence route           | `not installed`                                                                                                                   |
| Canonical doc                | `docs/02-standards/ui/components/modal.md`                                                                                                                  |
| Source owner                 | `not installed`                                                                                                                   |
| Blade API                    | `x-ui.modal`                                                                                                                                                |
| JavaScript API               | No dedicated feature JavaScript controller required; modal behavior must be component-owned or app-bootstrap-owned                                          |
| Source files                 | `resources/views/components/ui/modal/index.blade.php`; `resources/css/app.css`; `resources/js/app.js` if the installed focus/open-close behavior is script-backed |
| Foundation Elements consumed | Color, Spacing, Typography, Themes, Motion, Icons, 2x Grid                                                                                                  |
| Carbon benchmark             | Carbon Modal usage, style, and accessibility guidance                                                                                                       |

`Approved API` means the installed component and rendered evidence examples exist, but the canonical public API, variant definitions, dismissal rules, focus contract, footer composition, deferred wizard behavior, and regression expectations must be corrected so feature teams do not create local overlay markup or custom modal scripts.

## 3. Installed standard

Modal has component-specific rendered evidence examples that consume approved Foundation Elements and installed Button/Form/Feedback APIs.

### The installed standard is:

- Render modal surfaces through `<x-ui.modal>`.
- Open modals only from a user-initiated trigger, normally an `x-ui.button` with the documented modal trigger data attribute.
- Use `variant="transactional"` for confirmation and contained task modals with footer actions.
- Use `variant="passive"` for read-only urgent detail that can be dismissed without submitting data.
- Use `variant="danger"` for destructive or irreversible confirmation.
- Use `variant="acknowledgment"` only when the user must explicitly acknowledge task-specific information.
- Treat progress, wizard, and multi-step modal behavior as deferred until a Pattern-owned API is installed.
- Use `size="xs"`, `size="sm"`, `size="md"`, or `size="lg"` only.
- Keep modal content scoped to one required decision or contained task.
- Keep modal header, body, and footer zones component-owned.
- Keep header and footer visible while long modal body content scrolls vertically.
- Never allow horizontal modal body scrolling; use a larger modal or a full page instead.
- Use `x-ui.button` for every footer action.
- Use Button loading or Inline loading for short submit progress inside a modal.
- Keep form validation inside the open modal until errors are resolved or the user cancels.
- Return focus to the trigger when the modal closes.
- Respect reduced-motion preferences for overlay, dialog, and state transitions.
- Do not create raw overlays, local focus traps, local Escape handlers, one-off modal sizing classes, or feature-specific modal JavaScript.

Carbon alignment note: Carbon defines modals as blocking dialogs for immediate responses, urgent task-specific information, confirmations, and contained tasks. Carbon documents passive, transactional, danger, acknowledgment, and progress modal variants; four responsive sizes; header/body/footer anatomy; fixed header/footer with vertically scrolling body; focus containment; variant-specific initial focus; Escape dismissal; and clear modal-versus-notification boundaries. Login App maps those principles to its own `x-ui.modal`, `x-ui.button`, `ui-*` classes, Foundation tokens, and rendered evidence proof. Carbon implementation classes, framework feature flags, and AI styling are not Login App public APIs.

## 4. Public API

### 4.1. Canonical confirmation dialog

```blade
<x-ui.button
    type="button"
    semantic="primary"
    data-ui-modal-trigger="confirm-archive"
>
    Archive workspace
</x-ui.button>

<x-ui.modal
    id="confirm-archive"
    title="Archive workspace"
    size="sm"
    variant="transactional"
>
    <p>Archived workspaces are hidden from active lists. You can restore this workspace later.</p>

    <x-slot:footer>
        <x-ui.button semantic="secondary" type="button" data-ui-modal-close>
            Cancel
        </x-ui.button>

        <x-ui.button semantic="primary" type="submit" form="archive-workspace-form">
            Archive workspace
        </x-ui.button>
    </x-slot:footer>
</x-ui.modal>
```

### 4.2. Canonical form modal

```blade
<x-ui.button
    type="button"
    semantic="tertiary"
    data-ui-modal-trigger="edit-member"
>
    Edit member
</x-ui.button>

<x-ui.modal
    id="edit-member"
    title="Edit member"
    label="Team settings"
    size="md"
    variant="transactional"
    initial-focus="first-field"
>
    <form id="edit-member-form" method="POST" action="{{ route('members.update', $member) }}">
        @csrf
        @method('PATCH')

        <x-ui.text-input
            name="name"
            label="Member name"
            value="{{ old('name', $member->name) }}"
            required
        />
    </form>

    <x-slot:footer>
        <x-ui.button semantic="secondary" type="button" data-ui-modal-close>
            Cancel
        </x-ui.button>

        <x-ui.button semantic="primary" type="submit" form="edit-member-form">
            Save changes
        </x-ui.button>
    </x-slot:footer>
</x-ui.modal>
```

### 4.3. Canonical read-only detail modal

```blade
<x-ui.button
    type="button"
    semantic="ghost"
    data-ui-modal-trigger="session-detail"
>
    View session detail
</x-ui.button>

<x-ui.modal
    id="session-detail"
    title="Session detail"
    size="sm"
    variant="passive"
    :close-on-backdrop="true"
>
    <dl class="ui-description-list">
        <dt>Signed in</dt>
        <dd>{{ $session->created_at->format('M j, Y g:i A') }}</dd>

        <dt>IP address</dt>
        <dd>{{ $session->ip_address }}</dd>
    </dl>
</x-ui.modal>
```

### 4.4. Canonical destructive action modal

```blade
<x-ui.button
    type="button"
    semantic="danger-tertiary"
    data-ui-modal-trigger="delete-workspace"
>
    Delete workspace
</x-ui.button>

<x-ui.modal
    id="delete-workspace"
    title="Delete workspace"
    size="sm"
    variant="danger"
    initial-focus="cancel"
>
    <p>Deleting this workspace permanently removes its projects, members, and audit history.</p>

    <x-slot:footer>
        <x-ui.button semantic="secondary" type="button" data-ui-modal-close>
            Cancel
        </x-ui.button>

        <x-ui.button semantic="danger" type="submit" form="delete-workspace-form">
            Delete workspace
        </x-ui.button>
    </x-slot:footer>
</x-ui.modal>
```

Use these Blade and data-attribute APIs instead of hand-building overlay markup, attaching local JavaScript, or copying external modal implementations.

### 4.5. API surfaces

| API surface                 | Installed value                                                                                                                                  |
| --------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
| Blade API                   | `x-ui.modal`                                                                                                                                     |
| Trigger API                 | `data-ui-modal-trigger="{modal-id}"` on an approved trigger, normally `x-ui.button`                                                              |
| Close API                   | `data-ui-modal-close` on close/cancel controls inside the modal                                                                                  |
| Optional initial-focus hook | `initial-focus="..."` prop or `data-ui-modal-initial-focus` when the implementation supports element-level targeting                             |
| JavaScript                  | No dedicated feature JavaScript controller required. Component-owned or app-bootstrap-owned behavior may power open/close/focus handling.        |
| Root semantic element       | Component-owned dialog surface with `role="dialog"`, `aria-modal="true"`, and title labelling                                                    |
| Data attributes             | Use only the documented trigger, close, initial-focus, and component-owned state hooks. Feature views must not invent modal behavior attributes. |
| CSS namespace               | App-owned `ui-*` modal classes documented by the component implementation                                                                        |
| Source files                | `resources/views/components/ui/modal/index.blade.php`; `resources/css/app.css`; `resources/js/app.js` if behavior is script-backed                     |

### 4.6. Props and options

| Prop/option       | Type              | Default         | Allowed values                                         | Required                                                                            | Notes                                                                                                                                   |
| ----------------- | ----------------- | --------------- | ------------------------------------------------------ | ----------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------- |
| `id`              | `string`          | none            | Stable document ID                                     | Yes                                                                                 | Required for trigger, close, focus return, accessibility relationships, and tests.                                                      |
| `title`           | `string / null`   | `null`          | Short sentence-case modal title                        | Required unless title slot is installed and used                                    | Must provide the dialog accessible name. Prefer matching the trigger label.                                                             |
| `label`           | `string / null`   | `null`          | Short contextual label                                 | No                                                                                  | Renders above the title when extra object/path/context is required. Do not use as decorative eyebrow text.                              |
| `size`            | `string`          | `md`            | `xs`, `sm`, `md`, `lg`                                 | No                                                                                  | Selects responsive modal width and max-height. Use the smallest size that fits the task.                                                |
| `variant`         | `string`          | `transactional` | `transactional`, `passive`, `danger`, `acknowledgment` | No                                                                                  | Selects task, dismissal, footer, and initial-focus expectations. `progress`/wizard is deferred.                                         |
| `dismissible`     | `bool`            | `true`          | `true`, `false`                                        | No                                                                                  | When `true`, renders close behavior through installed mechanisms. `false` is gated for exceptional compliance/security flows.           |
| `closeOnEscape`   | `bool`            | `true`          | `true`, `false`                                        | No                                                                                  | Escape dismissal should remain enabled except for a documented gated exception.                                                         |
| `closeOnBackdrop` | `bool`            | `false`         | `true`, `false`                                        | No                                                                                  | Use `true` only for passive/read-only detail modals. Do not use backdrop dismissal for transactional, danger, or acknowledgment modals. |
| `closeLabel`      | `string`          | `Close dialog`  | Short accessible label                                 | No                                                                                  | Accessible name for the close icon button. May include the modal subject when useful.                                                   |
| `initialFocus`    | `initial-focus`   | `string / null` | `auto`                                                 | `auto`, `close`, `primary`, `cancel`, `first-field`, or a documented element target | No / `auto` follows variant rules. Forms should focus the first field. Danger should focus cancel.                                      |
| `returnFocusTo`   | `return-focus-to` | `string / null` | auto trigger                                           | Valid trigger target ID when automatic trigger tracking is unavailable              | No / Prefer automatic return through `data-ui-modal-trigger`. Use only when the modal has no standard trigger relationship.             |
| `class`           | `string / null`   | `null`          | Layout passthrough if supported                        | No                                                                                  | Parent Patterns may pass placement hooks only. Do not use for color, width, z-index, animation, focus, or state overrides.              |

Any prop not listed here is not public. If a feature needs another option, update the component implementation, this standard, and the rendered evidence proof before use.

### 4.7. Slots

| Slot                    | Status                    | Required                                                                                                                           | Rule                                                                                              |
| ----------------------- | ------------------------- | ---------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------- |
| Default/body slot       | Implemented               | Yes                                                                                                                                | Contains the modal body content. Keep content scoped to the modal task.                           |
| `footer`                | Implemented               | Required for transactional, danger, and acknowledgment modals; omitted for passive modals unless a close acknowledgement is needed | Contains `x-ui.button` actions only, plus Pattern-approved inline loading when needed.            |
| `title`                 | Gated unless installed    | Only when the prop cannot express the title                                                                                        | Must render one visible heading connected to the dialog accessible name. Prefer the `title` prop. |
| `description`           | Deferred unless installed | No                                                                                                                                 | Use body copy or a Pattern-owned helper if no description slot exists.                            |
| `trigger`               | Not public                | No                                                                                                                                 | Triggers are rendered outside the modal through Button/Link APIs and `data-ui-modal-trigger`.     |
| Arbitrary header markup | Not allowed               | No                                                                                                                                 | Modal owns header structure, title placement, label placement, and close button alignment.        |

### 4.8. Data attribute contract

| Attribute                             | Status                                                                               | Where used                                                        | Behavior                                                                                   |
| ------------------------------------- | ------------------------------------------------------------------------------------ | ----------------------------------------------------------------- | ------------------------------------------------------------------------------------------ |
| `data-ui-modal-trigger="{id}"`        | Implemented                                                                          | Approved trigger outside the modal                                | Opens the matching modal and records focus return target.                                  |
| `data-ui-modal-close`                 | Implemented                                                                          | Close, cancel, and non-submit dismissal controls inside the modal | Closes the current modal without submitting.                                               |
| `data-ui-modal-initial-focus`         | Implemented if source supports element-level targeting; otherwise pending correction | One focusable element inside the modal                            | Receives initial focus when `initialFocus`/`initial-focus` targets element-level behavior. |
| `data-ui-component="modal"`           | Component-emitted                                                                    | Modal root                                                        | Test and implementation hook only. Feature views must not set this manually.               |
| `data-ui-modal-state="open / closed"` | Component-emitted                                                                    | Modal root or wrapper                                             | State hook for tests and token-backed styling only. Do not use for local scripts.          |
| `data-ui-modal-variant="..."`         | Component-emitted                                                                    | Modal root or wrapper                                             | Variant hook for tests and token-backed styling only.                                      |
| `data-ui-modal-size="..."`            | Component-emitted                                                                    | Modal root or wrapper                                             | Size hook for tests and token-backed styling only.                                         |

Feature teams must not add custom modal data attributes, local query selectors, or local listeners to create open/close/focus behavior.

### 4.9. Variant contract

| Variant value       | Status                       | Purpose                                    | Use when                                                                                     | Do not use when                                                                           | Footer expectation                                                     |
| ------------------- | ---------------------------- | ------------------------------------------ | -------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------- | ---------------------------------------------------------------------- |
| `transactional`     | Implemented                  | Required decision or contained task        | The user must confirm, cancel, submit, or complete a short task before returning to the page | The content is only informational or the workflow is repeatable/complex enough for a page | Two buttons by default: secondary cancel + primary action              |
| `passive`           | Implemented                  | Urgent read-only task-specific information | The user needs to inspect detail related to current work and can dismiss without submitting  | The message is non-critical or can be shown as Notification                               | No footer by default; close button required                            |
| `danger`            | Implemented                  | Destructive or irreversible confirmation   | The primary modal action deletes, removes, revokes, resets, or permanently changes data      | The action is not destructive or the consequence is minor/reversible                      | Secondary cancel + visible danger primary action                       |
| `acknowledgment`    | Implemented / required proof | Required acknowledgement                   | The system needs explicit acknowledgement of task-specific information                       | A passive close is enough, or the information is non-critical                             | One primary acknowledgement button, with close/Escape rules documented |
| `progress` / wizard | Deferred                     | Multi-step focused flow                    | Several steps are required before completion                                                 | Today: use a full page or Pattern-owned flow                                              | Trigger conditions only; no fake production controls                   |

### 4.10. Size contract

| Size value        | Status                       | Use                                                                                 | Avoid when                                                                                                                                      |
| ----------------- | ---------------------------- | ----------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------- |
| `xs`              | Implemented / required proof | Short direct confirmations, title-as-message content, or one short read-only detail | The body contains a form, table, or multiple paragraphs                                                                                         |
| `sm`              | Implemented / required proof | Standard confirmation, destructive confirmation, or compact read-only detail        | Body copy creates long line lengths or components feel cramped                                                                                  |
| `md`              | Implemented                  | required proof                                                                      | Default form modal, detail modal, or contained task with several controls / The task is brief enough for `xs`/`sm` or complex enough for a page |
| `lg`              | Implemented / required proof | Complex contained content such as wider forms or approved component composition     | The largest modal still requires extensive scrolling; use a full page                                                                           |
| Custom width      | Not allowed                  | none                                                                                | Requires 2x Grid, spacing, responsive, and rendered evidence updates                                                                                 |
| Full-screen modal | Deferred / Pattern-owned     | none                                                                                | Use a page or gated overlay Pattern until installed                                                                                             |

### 4.11. Dismissal contract

| Dismissal method             | Passive  | Transactional          | Danger                 | Acknowledgment                  | Rule                                                                   |
| ---------------------------- | -------- | ---------------------- | ---------------------- | ------------------------------- | ---------------------------------------------------------------------- |
| Close icon                   | Required | Required unless gated  | Required unless gated  | Required unless gated           | Closes without submitting and returns focus.                           |
| Escape key                   | Required | Required unless gated  | Required unless gated  | Required unless gated           | Must be tested with focus inside the dialog.                           |
| Backdrop click               | Allowed  | Not allowed by default | Not allowed            | Not allowed                     | Use only for passive/read-only detail to prevent accidental task loss. |
| Cancel button                | Optional | Required               | Required               | Not typical                     | Uses `x-ui.button` and `data-ui-modal-close`.                          |
| Primary action               | None     | Required               | Required danger action | Required acknowledgement action | Submits or completes the task and then closes only on success.         |
| Forced non-dismissible modal | Gated    | Gated                  | Gated                  | Gated                           | Requires accessibility and product review before production use.       |

### 4.12. Initial-focus contract

| Modal condition                           | Initial focus target                                                  |
| ----------------------------------------- | --------------------------------------------------------------------- |
| Passive/read-only detail                  | Close button                                                          |
| Transactional confirmation without inputs | Primary action                                                        |
| Form modal                                | First invalid field when errors exist; otherwise first editable field |
| Destructive confirmation                  | Cancel button, not the destructive action                             |
| Acknowledgment                            | Primary acknowledgement button unless a close-only flow is approved   |
| Wizard/progress modal                     | Deferred until the Pattern API is installed                           |

## 5. Allowed variants, options, and modifiers

| Name                       | Type           | Status                                    | API                                                           | Notes                                                             |
| -------------------------- | -------------- | ----------------------------------------- | ------------------------------------------------------------- | ----------------------------------------------------------------- |
| Transactional modal        | Variant        | Implemented                               | `variant="transactional"`                                     | Confirmation and contained task with cancel + primary action.     |
| Passive/read-only modal    | Variant        | Implemented                               | `variant="passive"`                                           | Urgent read-only detail with close behavior.                      |
| Danger modal               | Variant        | Implemented                               | `variant="danger"`                                            | Destructive confirmation with visible danger action.              |
| Acknowledgment modal       | Variant        | Implemented / required proof              | `variant="acknowledgment"`                                    | Single acknowledgement action for task-specific information.      |
| Progress/wizard modal      | Variant        | Deferred                                  | none                                                          | rendered evidence shows trigger conditions and alternatives only.      |
| Extra small size           | Size           | Implemented / required proof              | `size="xs"`                                                   | Short confirmations and direct messages.                          |
| Small size                 | Size           | Implemented / required proof              | `size="sm"`                                                   | Standard compact confirmation/detail.                             |
| Medium size                | Size           | Implemented / required proof              | `size="md"`                                                   | Default form/contained task size.                                 |
| Large size                 | Size           | Implemented / required proof              | `size="lg"`                                                   | Complex contained content that still fits in a modal.             |
| Close button               | Modifier       | Implemented                               | automatic when `dismissible` is true                          | Close icon button uses component-owned icon and accessible label. |
| Escape dismissal           | Behavior       | Implemented                               | `closeOnEscape` / `close-on-escape`                           | Enabled by default. Disabling is gated.                           |
| Backdrop dismissal         | Behavior       | Implemented with restriction              | `closeOnBackdrop` / `close-on-backdrop`                       | Allowed for passive/read-only detail only.                        |
| Initial focus              | Behavior       | Implemented                               | `initialFocus` / `initial-focus`                              | Defaults by variant; forms may target first field.                |
| Focus return               | Behavior       | Implemented                               | automatic from trigger or `returnFocusTo` / `return-focus-to` | Required after every dismissal path.                              |
| Footer actions             | Composition    | Implemented                               | `footer` slot + `x-ui.button`                                 | Modal owns footer zone; Button owns controls.                     |
| Button loading in footer   | Composition    | Implemented through Button/Inline loading | `loading` on Button or `x-ui.inline-loading` where approved   | Use for short pending submit states.                              |
| Modal body loading overlay | Capability     | Gated                                     | none                                                          | Requires Loading Pattern proof before production use.             |
| Form validation            | Composition    | Pattern-owned                             | Forms Pattern + field APIs                                    | Modal remains open while invalid fields are corrected.            |
| Reduced motion             | State/modifier | Implemented                               | automatic through Foundation Motion                           | Overlay and dialog transitions respect reduced motion.            |
| Custom width or placement  | Modifier       | Not allowed                               | none                                                          | Requires component and 2x Grid update.                            |
| Nested modal               | Composition    | Not allowed                               | none                                                          | Use one modal at a time.                                          |
| AI presence styling        | Modifier       | Not implemented                           | none                                                          | Requires AI standard and rendered evidence proof before use.           |

## 6. States

| State                         | Status                        | Implementation requirement                                                                                                     |
| ----------------------------- | ----------------------------- | ------------------------------------------------------------------------------------------------------------------------------ |
| Closed                        | Implemented                   | Modal is not exposed to assistive technology, does not receive focus, and does not block page interaction.                     |
| Open                          | Implemented                   | Overlay and dialog render, page content is inert or otherwise blocked, focus enters the dialog, and body scroll is controlled. |
| Opening/closing motion        | Implemented                   | Uses Foundation Motion and reduced-motion fallbacks. No custom transition classes.                                             |
| Hover                         | Implemented where interactive | Close button and footer buttons use their own token-backed hover states. The modal surface itself has no hover state.          |
| Focus-visible                 | Implemented                   | Every interactive element inside the modal has visible focus. Focus does not escape the dialog while open.                     |
| Active/pressed                | Implemented where interactive | Close and footer buttons use Button/Icon Button pressed states. Modal container has no pressed state.                          |
| Disabled trigger              | Composition state             | Trigger disabled behavior belongs to Button. A disabled trigger must not open a modal.                                         |
| Dismiss                       | Implemented                   | Close icon, Escape, cancel button, and allowed backdrop clicks close the modal and return focus.                               |
| Escape dismissal              | Implemented                   | Enabled by default; disabling requires a gated exception.                                                                      |
| Outside-click dismissal       | Implemented with restriction  | Allowed only for passive/read-only detail unless a Pattern explicitly proves otherwise.                                        |
| Focus return                  | Implemented                   | Focus returns to the trigger or documented return target after every close path.                                               |
| Loading                       | Composition state             | Use Button loading or Inline loading for short pending actions. Modal body loading overlay is gated.                           |
| Validation                    | Pattern-owned                 | Invalid form submission keeps the modal open and renders field errors through Forms Pattern APIs.                              |
| Error, warning, success, info | Not modal root states         | Use Notification, field errors, Inline loading, or Pattern-owned status. Do not color the modal container by status.           |
| Read-only                     | Scenario state                | Use `variant="passive"` or a transactional detail modal with no editable fields.                                               |
| Empty                         | Not allowed                   | Do not render a modal with no title or no body content.                                                                        |
| Overflow/scrolling            | Implemented                   | Body scrolls vertically when needed; header and footer stay available; horizontal scrolling is prohibited.                     |
| Responsive/mobile             | Implemented / required proof  | Modal sizes adapt to supported breakpoints and remain usable on narrow screens.                                                |
| Reduced motion                | Implemented                   | Motion preferences are honored while preserving open/closed state clarity.                                                     |
| Stacked/nested                | Not allowed                   | Only one blocking modal may be active at a time.                                                                               |
| Wizard/progress               | Deferred                      | rendered evidence documents trigger conditions and alternatives; no fake production control.                                        |

States must be represented through the installed Component API and token-backed classes. Do not create state-only local CSS outside the API.

## 7. Token, class, and helper usage

Modal consumes Foundation Color, Spacing, Typography, Themes, Motion, Icons, and 2x Grid.

### 7.1. Foundation Elements consumed:

- Color.
- Spacing.
- Typography.
- Themes.
- Motion.
- Icons.
- 2x Grid.

### 7.2. Allowed token roles

| Element API | Allowed usage                                                                                                                                                                 |
| ----------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Color       | Overlay, modal surface, title/body text, borders, close button hover/active/focus, footer divider, disabled content, danger action composition, and supported theme contrast. |
| Spacing     | Header padding, label/title rhythm, body padding, footer spacing, close button hit area, internal content rhythm, and responsive modal insets.                                |
| Typography  | Modal label, title, body copy, helper text, field labels inside forms, and footer action label alignment.                                                                     |
| Themes      | Light, dark, and inverse token resolution for overlay, surface, borders, text, close button, and footer actions.                                                              |
| Motion      | Overlay fade, dialog entrance/exit, focus transition expectations, and reduced-motion fallback.                                                                               |
| Icons       | Component-owned close icon only. Other icons inside body content must come from the owning Component or Pattern.                                                              |
| 2x Grid     | Responsive width, max-width, column alignment, and full-width component placement inside approved modal sizes.                                                                |

Carbon color role mapping:

| Carbon token / role | Carbon responsibility | Login App token / API | Login value source | Mapping status | Owner rule |
| ------------------- | --------------------- | --------------------- | ------------------ | -------------- | ---------- |
| `$layer` | Modal dialog/container surface | `ui-modal__dialog`, modal surface alias | App layer palette | Same role / app value | Modal surface must use layer roles, not local card colors. |
| `$border-subtle` | Modal container/footer border | `ui-modal` border/divider roles | App border palette | Same role / app value | Modal borders share Color-owned border roles. |
| `$overlay` | Page overlay/scrim | Overlay Pattern role / `--ui-overlay` when installed | App overlay palette | Same role / app value | Overlay color is Pattern-owned; do not create modal-local scrims. |
| `$layer-hover` | Close icon hover background | `ui-modal__close:hover` | App layer state palette | Same role / app value | Close control state uses shared layer hover. |
| `$text-primary`, `$text-secondary`, `$icon-primary` | Modal title/body text and close icon | Modal text/icon roles | App text/icon palettes | Same role / app value | Body content components keep their own roles. |
| `$focus` | Close/action focus | Modal close focus-visible and composed Button focus | App focus palette | Same role / app value | Focus stays shared Color ownership. |
| `$ai-border-start`, `$ai-border-end`, `$ai-drop-shadow`, `$ai-inner-shadow`, `$ai-overlay` | AI modal presence | No baseline modal role until AI modal variant is approved | None | Not adopted | AI modal tokens remain gated. |

### 7.3. CSS namespace

Allowed component classes must use the app-owned `ui-*` namespace documented by the implementation. Acceptable class families include:

```css
.ui-modal
.ui-modal__overlay
.ui-modal__dialog
.ui-modal__header
.ui-modal__label
.ui-modal__title
.ui-modal__close
.ui-modal__body
.ui-modal__footer
.ui-modal__footer-actions
.ui-modal--open
.ui-modal--closed
.ui-modal--xs
.ui-modal--sm
.ui-modal--md
.ui-modal--lg
.ui-modal--transactional
.ui-modal--passive
.ui-modal--danger
.ui-modal--acknowledgment
.ui-modal--scrolling
.ui-modal--reduced-motion
```

Feature views must not create local overlay classes, z-index stacks, raw utility clusters, arbitrary widths, raw colors, local close icons, local focus traps, local body-scroll locks, custom animation classes, or component-specific modal scripts for the same UI role.

## 8. Composition rules

- Open a modal only from a user action, normally a Button trigger.
- Use the least disruptive overlay that satisfies the task.
- Keep the modal scoped to one decision, confirmation, or contained task.
- Use a full page when the task is repeatable, long-running, multi-step, or complex enough that users need page context.
- Do not launch a modal automatically on page load unless a gated product/accessibility exception is approved.
- Do not nest modals or stack multiple blocking overlays.
- Do not place required page content only inside a modal.
- Do not place hover-only content inside a modal trigger path.
- Keep trigger copy, modal title, and primary action copy aligned.
- For form modals, keep the form inside the modal body and use `x-ui.button type="submit"` in the footer.
- For destructive modals, use `variant="danger"`, explicit consequence copy, a visible danger primary action, and a visible cancel path.
- For read-only detail, use `variant="passive"` and omit footer actions unless an acknowledgement is required.
- Use `closeOnBackdrop` only for passive/read-only detail.
- Use Button loading or Inline loading for short pending submit states; do not close the modal until the submit succeeds.
- Keep the modal open when form validation fails and place error messages with the affected fields.
- Use Notification inside or near the modal only when a persistent server-side or workflow message is required.
- Header and footer remain fixed while the body scrolls vertically when content exceeds available height.
- Do not allow horizontal scrolling. Increase modal size or move the task to a full page.
- Parent Patterns own trigger placement, external spacing, workflow state, permission logic, and post-close routing.
- Modal owns internal semantics, overlay, focus behavior, close/dismiss behavior, sizing, token-backed styling, and internal zones.

## 9. Selection guidance

### 9.1. Use when:

- A user-initiated process needs an immediate response before the page can continue.
- A user must confirm a decision that has meaningful consequences.
- A destructive or irreversible action needs secondary confirmation.
- A short form or contained task must be completed without leaving the current page context.
- Urgent task-specific information must interrupt the current workflow.
- Read-only detail needs a focused temporary surface and is too disruptive or dense for Tooltip/Popover.

### 9.2. Do not use when:

- The content is non-critical status feedback; use Notification.
- The content is helper text or field guidance; use helper text, Tooltip, or the Forms Pattern.
- The task is frequent, repeatable, complex, or multi-step; use a full page or Pattern-owned flow.
- The task requires comparing page content behind the overlay.
- The content is required page content that should be visible by default.
- The interaction is a menu, tooltip, popover, or hover disclosure.
- The only reason is to avoid designing a clear page layout.
- A full-page loading or route transition is needed; use the Loading Pattern when installed.

### 9.3. Variant selection:

| Need                                         | Use                                                   |
| -------------------------------------------- | ----------------------------------------------------- |
| Confirm or submit a contained task           | `variant="transactional"`                             |
| Inspect urgent read-only detail              | `variant="passive"`                                   |
| Confirm a destructive or irreversible action | `variant="danger"`                                    |
| Require explicit acknowledgement             | `variant="acknowledgment"`                            |
| Run a multi-step wizard                      | Deferred; use a full page or gated Pattern-owned flow |
| Show non-critical feedback                   | Notification, not Modal                               |
| Show short pending submit progress           | Button loading or Inline loading inside Modal footer  |
| Show page-level blocked loading              | Loading Pattern, not Modal                            |

### 9.4. Size selection:

| Need                                                 | Use                              |
| ---------------------------------------------------- | -------------------------------- |
| One short confirmation or direct message             | `size="xs"`                      |
| Standard confirmation or compact detail              | `size="sm"`                      |
| Default form or contained task                       | `size="md"`                      |
| Wider approved content that still belongs in a modal | `size="lg"`                      |
| Content still overflows heavily at `lg`              | Full page, not custom modal size |

## 10. Accessibility contract

- Modal must render a real dialog semantic surface with `role="dialog"` and `aria-modal="true"` or the installed accessible equivalent.
- The visible title must provide the dialog accessible name through `aria-labelledby` or an equivalent component-owned relationship.
- A description should be associated through component-owned markup when additional body text is necessary to understand the decision.
- The close icon button must have an accessible name, defaulting to `Close dialog`.
- Opening a modal moves focus into the modal.
- Focus remains contained in the modal while it is open.
- `Tab` and `Shift+Tab` wrap through focusable controls inside the dialog only.
- `Escape` closes the modal by default and returns focus to the opener.
- Every close path returns focus to the trigger or a documented replacement target.
- Page content behind an open modal must be inert, hidden from interaction, or otherwise blocked by the installed modal behavior.
- Body/page scrolling behind the modal must be locked or controlled while the modal is open.
- Passive/read-only modals place initial focus on the close button.
- Transactional confirmations without fields place initial focus on the primary action.
- Form modals place initial focus on the first invalid field when validation errors exist; otherwise on the first editable field.
- Destructive confirmations place initial focus on Cancel, not the destructive action.
- Do not place initial focus on a body link unless a Pattern-specific accessibility review approves it.
- Footer actions must preserve logical reading order and visible focus order.
- Danger modals must not rely on color alone; title, body copy, and action label must name the destructive outcome.
- Backdrop dismissal must not be used for transactional, danger, or acknowledgment modals because accidental dismissal can lose task context.
- Form validation errors keep the modal open and identify the affected fields through field APIs.
- Reduced-motion preferences must be respected without hiding open/closed state meaning.
- Modal content must maintain contrast in supported light and dark themes.
- Do not use a modal as the only way to access required page content.

## 11. Content contract

- Use sentence case.
- Use a brief modal title that describes the task or decision.
- Prefer matching the trigger label and modal title when the trigger directly opens the modal task.
- Use the optional `label` only for context such as object name, path, section, or account scope.
- Keep body copy specific to the modal task.
- Explain consequences before destructive or irreversible actions.
- Use verb-led footer action labels such as `Save changes`, `Delete workspace`, `Archive project`, or `Send invitation`.
- Use `Cancel` for the non-submit escape path in transactional and danger modals.
- Avoid vague primary labels such as `OK`, `Done`, `Yes`, `No`, `Submit`, or `Proceed` when a specific action is known.
- `OK` may appear only in approved acknowledgment content where no clearer action label exists.
- For title-as-message modals, keep the full message in the title and omit repetitive body copy.
- Do not include unrelated links in the footer. Put supporting links in the modal body when approved.
- Do not expose internal service names, queue names, exception classes, stack traces, or implementation details.
- Do not use long instructional content inside a modal. Move complex instructions to a page.
- Keep error copy with the affected field or Notification; do not replace form validation with modal title changes.
- Keep trigger, title, body, and primary action copy aligned so the user can predict the result.

## 12. Prohibited usage

- Do not bypass the installed Component API with one-off Blade markup, raw utility clusters, raw colors, arbitrary spacing, local icons, or custom JavaScript.
- Do not create local overlay markup, local body scroll locks, local focus traps, local Escape handlers, or feature-specific modal controllers.
- Do not copy Carbon, Bootstrap, or other external modal classes into production examples.
- Do not use modal to avoid designing a clear page layout.
- Do not put required page content only inside a modal.
- Do not use modal for non-critical success, error, warning, or informational messages; use Notification.
- Do not use modal for hover-only disclosure; use Tooltip or Popover when installed.
- Do not use modal as a menu or action overflow; use Menu buttons.
- Do not use modal for full-page loading, route transitions, or background jobs.
- Do not use custom widths, custom z-index values, custom animation durations, or custom overlay colors.
- Do not use backdrop click to dismiss transactional, danger, or acknowledgment modals.
- Do not disable Escape dismissal unless a gated exception is documented and tested.
- Do not open a destructive modal with focus on the destructive action.
- Do not hide the cancel path for destructive actions.
- Do not close a form modal when validation fails.
- Do not allow horizontal scrolling inside the modal body.
- Do not stack or nest modals.
- Do not present wizard/progress modal controls as implemented until the deferred API is installed and proved.

## 13. Deferred or gated capabilities

| Capability                                | Status                   | Gate                                                                                                                                                                                        |
| ----------------------------------------- | ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Wizard/progress modal                     | Deferred                 | Requires Pattern owner, step state API, keyboard model, focus rules per step, footer button rules, route/escape behavior, validation rules, rendered evidence proof, and tests.                  |
| Forced non-dismissible modal              | Gated                    | Requires product, accessibility, and security/compliance approval; must document why Escape/close is not allowed and provide an accessible escape or completion path.                       |
| Modal body loading overlay                | Gated                    | Requires Loading Pattern integration, inert body content, disabled footer action rules, reduced-motion proof, and tests. Use Button loading or Inline loading for short pending work today. |
| Full-screen/mobile sheet modal            | Deferred / Pattern-owned | Requires responsive Pattern, focus/scroll behavior, and rendered evidence proof. Use a page when content exceeds large modal constraints.                                                        |
| Alertdialog role                          | Gated                    | Requires accessibility review and explicit criteria for urgent destructive/critical messages. Default modal role remains `dialog`.                                                          |
| System-generated automatic modal          | Gated                    | Requires product and accessibility review. Modals should normally open from user action.                                                                                                    |
| Nested or stacked modals                  | Not allowed              | Use one modal at a time or redesign the flow.                                                                                                                                               |
| Custom modal width or placement           | Not allowed              | Requires 2x Grid, Spacing, responsive, and rendered evidence updates.                                                                                                                            |
| AI presence styling                       | Not implemented          | Requires AI design standard, token mapping, explainability behavior, and rendered evidence proof.                                                                                                |
| Custom close icon or icon set             | Not allowed              | Requires Icons Element update and component proof.                                                                                                                                          |
| Component-specific feature JavaScript API | Deferred                 | Requires documented initializer, events, cleanup behavior, and tests. Feature views must not add local scripts.                                                                             |

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

The Modal page is a scenario-driven overlay reference. The Live examples card should use tabs or grouped scenarios for confirmation, form, read-only detail, destructive action, and wizard deferred proof. It should also include compact matrices for size, dismissal, initial focus, footer action structure, reduced motion, and developer implementation.

### 15.1. Required Live examples internal sections:

| Required proof                   | Rendered behavior                                                                                                                                                            | Variants/options shown                                                                                             |
| -------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------ |
| Confirmation dialog              | A user-triggered modal opens from Button, traps focus, shows title/body/footer, supports close/cancel/Escape, prevents backdrop dismissal, and returns focus to the trigger. | `variant="transactional"`, `size="sm"`, open, closed, focus-visible, Escape, cancel, primary action                |
| Form modal                       | A contained form opens with initial focus on the first field, validates in place, keeps the modal open on errors, and submits through footer Button.                         | `variant="transactional"`, `size="md"`, `initial-focus="first-field"`, validation, loading submit, disabled submit |
| Read-only detail                 | A passive modal shows urgent task-specific detail, focuses the close button, permits close/Escape and optional backdrop dismissal, and has no submit footer.                 | `variant="passive"`, `size="sm"`, close button, Escape, `close-on-backdrop`, no footer                             |
| Destructive action               | A danger modal explains consequences, focuses Cancel first, uses a visible danger primary action, blocks backdrop dismissal, and returns focus after cancel/delete.          | `variant="danger"`, `initial-focus="cancel"`, danger Button, secondary cancel, focus return                        |
| Acknowledgment dialog            | A modal requiring acknowledgement shows one clear acknowledgement action and documented close/Escape behavior.                                                               | `variant="acknowledgment"`, one primary action, close/Escape rules                                                 |
| Wizard deferred                  | A non-production section documents why wizard/progress modal is deferred and points to approved alternatives.                                                                | Deferred progress/wizard, full-page flow alternative, no fake controls                                             |
| Size scale                       | All approved modal sizes render with representative content and responsive notes.                                                                                            | `xs`, `sm`, `md`, `lg`; no custom width                                                                            |
| Dismissal matrix                 | The page compares close button, Escape, backdrop click, cancel button, and primary action by variant.                                                                        | Passive, Transactional, Danger, Acknowledgment dismissal rules                                                     |
| Initial-focus matrix             | The page shows or documents initial focus for passive, transactional, form, danger, and acknowledgment modals.                                                               | Close, primary, first field, cancel, acknowledgement                                                               |
| Footer action structure          | Footer examples use Button APIs and approved one-, two-, and rare three-button structures.                                                                                   | Secondary cancel, primary action, danger action, acknowledgement action, disabled/loading action                   |
| Overflow and responsive behavior | Long body content scrolls vertically while header/footer remain available; horizontal scrolling is not presented as allowed.                                                 | Body scroll, fixed header/footer, responsive/mobile, large size alternative                                        |
| Reduced-motion behavior          | Overlay/dialog motion respects reduced-motion preferences while keeping state clear.                                                                                         | Open/close motion, reduced motion                                                                                  |
| Error and loading handoff        | Short pending state uses Button loading or Inline loading; validation errors remain in modal fields; persistent server feedback uses Notification.                           | Button loading, Inline loading, Forms Pattern, Notification relationship                                           |
| Prohibited overlay choices       | The page contrasts modal with tooltip, popover/menu, notification, full-page loading, and full-page workflow.                                                                | Not owned: tooltip/popover/menu, notification, loading, wizard/full page                                           |
| Developer implementation         | Canonical calls and props render as real code examples.                                                                                                                      | `x-ui.modal`, `data-ui-modal-trigger`, `data-ui-modal-close`, `variant`, `size`, `initial-focus`, `footer` slot    |

The page must not display generic fallback/reference sections or placeholder developer comments. It must show the actual installed API, rendered variants, states, options, prohibited usage, deferred gates, focus/dismissal behavior, footer composition, and Foundation Elements consumed.

## 16. Testing and acceptance criteria

- `not installed` returns 200 for authorized users.
- The page shows the installed API, states, variants/options, prohibited usage, deferred gates, and Foundation Elements consumed.
- Implemented APIs render production examples; deferred APIs render trigger conditions instead of fake controls.
- The Purpose, Use cases, Component contract, Live examples, and Related components and patterns cards render in that top-level order.
- The confirmation dialog example opens from a Button trigger and returns focus to that trigger after close.
- The form modal example shows first-field initial focus, field validation, modal-open-on-error behavior, and footer submit Button.
- The read-only detail example shows passive behavior with close button, Escape, and optional backdrop dismissal.
- The destructive action example uses `variant="danger"`, visible consequence copy, cancel-first focus, and a visible danger Button.
- The acknowledgment example shows one acknowledgement action and documented close/Escape behavior.
- The wizard/progress example renders as deferred trigger conditions and approved alternatives, not fake production controls.
- The size examples render `xs`, `sm`, `md`, and `lg` only.
- The dismissal matrix documents close button, Escape, backdrop click, cancel, and primary action behavior by variant.
- The initial-focus matrix documents passive close focus, transactional primary focus, form first-field focus, danger cancel focus, and acknowledgment action focus.
- The overflow example shows vertical body scrolling and does not allow horizontal scrolling.
- Reduced-motion expectations are visible for open/close transitions.
- Developer examples use `x-ui.modal`, `x-ui.button`, documented data attributes, and documented props only.
- Tests assert stale scaffold labels, placeholder pending-correction copy, legacy reference sections, old tier paths, and direct Carbon implementation class prefixes remain absent from rendered approved examples.
- No generic placeholder content appears.

Suggested automated assertions:

```php
$response = $this->actingAs($admin)->get('not installed');

$response->assertOk();
$response->assertSee('Modal');
$response->assertSee('x-ui.modal');
$response->assertSee('data-ui-modal-trigger');
$response->assertSee('data-ui-modal-close');
$response->assertSee('variant="transactional"');
$response->assertSee('variant="passive"');
$response->assertSee('variant="danger"');
$response->assertSee('variant="acknowledgment"');
$response->assertSee('size="xs"');
$response->assertSee('size="sm"');
$response->assertSee('size="md"');
$response->assertSee('size="lg"');
$response->assertSee('initial-focus="first-field"');
$response->assertSee('initial-focus="cancel"');
$response->assertSee('Wizard deferred');
$response->assertSee('focus return');
$response->assertSee('Escape');
$response->assertSee('Do not use backdrop click to dismiss transactional, danger, or acknowledgment modals');
$response->assertDontSee('Component-specific API ' . 'pending correction');
$response->assertDontSee('Live Examples ' . 'Card');
$response->assertDontSee('Reference ' . 'Examples');
$response->assertDontSee('Legacy Contract ' . 'Summary');
$response->assertDontSee('tier' . '-1');
$response->assertDontSee('tier' . '-2');
$response->assertDontSee('cds' . '--');
$response->assertDontSee('bx' . '--');
$response->assertDontSee('TODO');
$response->assertDontSee('Generic ' . 'fallback');
```

## 17. Related APIs

| API                           | Route                                                          |
| ----------------------------- | -------------------------------------------------------------- |
| Button                        | `not installed`                     |
| Tooltip                       | `not installed`                    |
| Inline loading                | `not installed`             |
| Notification                  | `not installed`               |
| Text input                    | `not installed`                 |
| Select                        | `not installed`                     |
| Overlay and feedback patterns | `not installed`            |
| Forms pattern                 | `not installed`                        |
| Loading pattern               | `not installed`                      |
| Layout Pattern                | `not installed`                       |
| Color element                 | `not installed`                        |
| Spacing element               | `not installed`                      |
| Typography element            | `not installed`                   |
| Themes element                | `not installed`                       |
| Motion element                | `not installed`                       |
| Icons element                 | `not installed`                        |
| 2x Grid element               | `not installed`                      |
| Components overview           | `not installed`                            |
| Canonical modal doc           | `/platform/docs?path=02-standards%2Fui%2Components%2Fmodal.md` |
| Carbon modal usage            | `https://carbondesignsystem.com/components/modal/usage/`       |

## 18. References

- [Component Standards Index](index.md)
- [Component Implementation Checklist](checklist.md)
- [Foundation Elements Standards](../elements/index.md)
- [Pattern Standards Index](../patterns/index.md)
- Carbon Modal usage, style, and accessibility guidance inform blocking-dialog scope, variants, sizing, anatomy, focus containment, dismissal rules, footer composition, overflow behavior, and modal-versus-notification boundaries. Login App keeps its own Blade API, data attributes, `ui-*` namespace, token model, and rendered evidence proof.